<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />

    <p><?= $laudo['0']->texto; ?></p>

            <?
            if ($laudo['0']->situacao == "FINALIZADO" && $laudo['0']->medico_parecer2 == "" || $laudo['0']->medico_parecer1 == 38 ) {
                ?>
 
                <?
            }
            if ($laudo['0']->situacao == "FINALIZADO" && $laudo['0']->medico_parecer2 != "") {
                ?>

                <!--<img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".jpg" ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer2 . ".jpg" ?>">-->
            <? }
            ?>

        <?
        if ($laudo['0']->rodape == "t") {
            ?>
            <FONT size="-1"> REALIZAMOS EXAMES DE RESSON&Acirc;NCIA MAGN&Eacute;TICA DE ALTO CAMPO (1,5T)
            <?
        }
        ?>

