<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<HEAD>
    <STYLE>
        thead { display: table-header-group; }
    </STYLE>
</HEAD>
<BODY>
    <? $i = 0; ?>
        <thead>
            <tr><th ></th><th align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome: <?= $laudo['0']->paciente; ?></th><th></th></tr>
            <tr><th ></th><th align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Solicitante: Dr(a). <?= $laudo['0']->solicitante; ?></th><th></th></tr>
            <tr><th ></th><th align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Emiss&atilde;o: <?= substr($laudo['0']->data_cadastro, 8, 2); ?>/<?= substr($laudo['0']->data_cadastro, 5, 2); ?>/<?= substr($laudo['0']->data_cadastro, 0, 4); ?></th><th></th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
        </thead>

        <tbody>
            <tr><td ></td><td><b><?= utf8_decode($laudo['0']->cabecalho); ?></b></td><td></td></tr>
            <tr><td ></td><td><?= utf8_decode($laudo['0']->texto); ?></td><td></td></tr>




            <?
            if ($laudo['0']->situacao == "FINALIZADO" && $laudo['0']->medico_parecer2 == "" || $laudo['0']->medico_parecer1 == 38 ) {
                ?>
            <tr><td width="50px"></td><td><center><img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".bmp" ?>"></center></td></tr>
                <?
            }
            if ($laudo['0']->situacao == "FINALIZADO" && $laudo['0']->medico_parecer2 != "") {
                ?>
                <tr><td width="50px"></td><td><center><img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".bmp" ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer2 . ".bmp" ?>"><center></td><td></td></tr>
            <? }
            ?>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <?
        if ($laudo['0']->rodape == "t") {
            ?>
            <tr><td width="20px"></td><td><FONT size="-1"> REALIZAMOS EXAMES DE RESSON&Acirc;CIA MAGN&Eacute;TICA DE ALTO CAMPO (1,5T)</td><td></td></tr>
            <?
        }
        ?>
    </tbody>
</table>

</BODY>
</HTML>
