<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<HEAD>
    <STYLE>
        thead { display: table-header-group; }
    </STYLE>
</HEAD>
<BODY>
    <? $i = 0; ?>
    <table  >
        <thead>
            <tr><th ></th><th align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome: <?= $laudo['0']->nomedopaciente; ?></th><th></th></tr>
            <tr><th ></th><th align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Solicitante: Dr(a). <?= $laudo['0']->nomemedicosolic; ?></th><th></th></tr>
            <tr><th ></th><th align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Emiss&atilde;o: <?= substr($laudo['0']->emissao, 8, 2); ?>/<?= substr($laudo['0']->emissao, 5, 2); ?>/<?= substr($laudo['0']->emissao, 0, 4); ?></th><th></th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
            <tr><th colspan="4">&nbsp;</th></tr>
        </thead>

        <tbody>
            <tr><td ></td><td><b><textarea id="titulo" name="titulo" cols="80"><?= utf8_decode($laudo['0']->nomeexame); ?></textarea></b></td><td></td></tr>
            <tr><td ></td><td><textarea id="laudo" name="laudo" rows="35" cols="80"><?= $laudo['0']->laudo; ?></textarea></td><td></td></tr>




            <tr><td width="50px"></td><td><center><img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->nrmedicolaudo . ".bmp" ?>"></center></td></tr>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
            <tr><td width="20px"></td><td><FONT size="-1"> REALIZAMOS EXAMES DE RESSON&Acirc;CIA MAGN&Eacute;TICA DE ALTO CAMPO (1,5T)</td><td></td></tr>
    </tbody>
</table>

</BODY>
</HTML>
