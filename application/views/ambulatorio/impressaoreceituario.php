<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />

<BODY>

    <br>
    
    <p style="text-align: left;">Paciente: <? echo $laudo['0']->paciente;?></p>
    <?= $laudo['0']->texto; ?>
    
    <? if( isset($atestado) && !$atestado) : ?>
    <p style="text-align: right; font-size: 12px;">Data: <? echo $laudo['0']->data_cadastro;?></p>
    <? endif; ?>

             <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".bmp" ?>">-->

  

</BODY>
</HTML>