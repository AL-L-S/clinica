<? // var_dump($atestado, $co_cid) ?>
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />

<BODY>

    <br>
    <? //if (isset($atestado) && !$atestado) { ?>
       <!--<p style="text-align: left;">Paciente: <? // echo $laudo['0']->paciente;  ?></p>-->
    <? //} ?>

    <?= $laudo['0']->texto; ?><br/>

    <? if (isset($atestado) && !$atestado) { ?>
        <p style="text-align: right; font-size: 12px;">Data: <? echo $laudo['0']->data_cadastro; ?></p>
    <? } else { ?>

        <? if ($imprimircid == "t") { ?>
        <tr><td><center>Cid Principal: <? echo $cid['0']->co_cid . "-" . $cid['0']->no_cid; ?></center></td></tr><br/>
        <tr><td><center>Resolução CFM 1.658/2002 - Art. 5º - Os médicos somente podem fornecer atestados com o diagnóstico codificado ou não quando por justa causa, exercício de dever legal, solicitação do próprio paciente ou de seu representante legal.</center></tr>
    <? }
}
?>

             <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".bmp" ?>">-->



</BODY>
</HTML>