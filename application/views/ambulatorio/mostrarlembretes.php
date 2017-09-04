<meta charset="utf8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Lembretes</h3>
        <div>
            <? if( count($lembretes) > 0 ) {?>
                <table border="1">
                    <? 
                    $i = 0; 
                    foreach ( $lembretes as $item ){ 
                        $i++;
                        ?>
                        <tr style="border-bottom: 1pt">
                            <td style="padding:10px;"> <?= $i ?> </td>
                            <td> <?= $item->texto ?> </td>
                        </tr>                    
                    <? } ?>
                </table>
            <?} else { ?>
                <h4>N&atilde;o foi encontrado lembretes para você.</h4>
            <? } ?>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

</script>