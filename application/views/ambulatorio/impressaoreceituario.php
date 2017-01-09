<? // var_dump($atestado, $co_cid)       ?>
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<meta charset="utf8"/>

<BODY>
    <? if (@$receituario != NULL) { ?>
    <center><p style="text-align: center; font-weight: bold;">RECEITUÁRIO</p></center>
<? } ?>
<br>
<? //if (isset($atestado) && !$atestado) { ?>
   <!--<p style="text-align: left;">Paciente: <? // echo $laudo['0']->paciente;        ?></p>-->
<? //} ?>

<?= $laudo['0']->texto; ?><br/>

<? if (@$atestado != NULL) { ?>
    <?
    if (@$imprimircid == "t") {
        if (isset($cid['0']->co_cid) && isset($cid['0']->no_cid)) {
            ?>

            <tr><td><center>Cid Principal: <? echo $cid['0']->co_cid . "-" . $cid['0']->no_cid; ?></center></td></tr><br/>
        <? } ?>

        <tr><td><center>Resolução CFM 1.658/2002 - Art. 5º - Os médicos somente podem fornecer atestados com o diagnóstico codificado ou não quando por justa causa, exercício de dever legal, solicitação do próprio paciente ou de seu representante legal.</center></tr>

    <? } else { ?>
        <p style="text-align: right; font-size: 12px;">Data: <? echo date("d/m/Y H:i:s", strtotime($laudo['0']->data_cadastro)); ?></p>
        <?
    }
}
//else {
if (isset($operador_assinatura)) {
    $this->load->helper('directory');
    $arquivo_pasta = directory_map("./upload/1ASSINATURAS/");
    foreach ($arquivo_pasta as $value) {
        if ($value == $operador_assinatura . ".jpg") {
            ?>
            <table>
                <tr>
                    <td><img width="200px;" height="50px;" src="<?= base_url() . "upload/1ASSINATURAS/$value" ?>" /></td>
                </tr>
            </table>
            <?
        }
    }
//        $arquivo_pasta = directory_map("/home/sisprod/projetos/clinicas/upload/1ASSINATURAS/");
//        
}
//        var_dump($medico);die;
if ($laudo[0]->carimbo == 't') {
    ?>
    <table>
        <tr>
            <td><?= $laudo[0]->medico_carimbo ?></td>
            
        </tr>
        
    </table>
    <?
}
//}
?>
        <table>
        
        <tr>
            <td><? echo $medico[0]->nome; ?></td>
        </tr>
        <tr>
            <td>CRM: <?= $medico[0]->conselho ?></td>
        </tr>
        <tr>
            <td>ESPECIALIDADE: <?= $medico[0]->ocupacao ?></td>
        </tr>
    </table>

             <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".bmp" ?>">-->



</BODY>
</HTML>