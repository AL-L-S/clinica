<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />

<BODY>
    <p><?= $laudo['0']->texto; ?></p>


            <?
            if ($laudo['0']->situacao == "FINALIZADO" && $laudo['0']->medico_parecer2 == "" || $laudo['0']->medico_parecer1 == 38 ) {
                ?>
    <br>
    <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".bmp" ?>"></center>
                <?
            }?>


                                            </BODY>
                                            </HTML>
