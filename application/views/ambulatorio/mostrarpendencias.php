<meta charset="utf8">
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<? //echo "<pre>"; var_dump($pendencias);die;?>
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Atendimentos Pendentes</h3>
        <div>
            <? if( count($pendencias) > 0 ) {?>
                <table border="1">
                    <thead>
                        <th>Nome</th>
                        <th>Sala</th>
                        <th>Procedimento</th>
                        <th></th>
                    </thead>
                    
                    <tbody>
                        <? 
                        foreach ( $pendencias as $item ){ 
                            ?>
                            <tr style="border-bottom: 1pt">
                                <td><?= $item->paciente ?></td>
                                <td><?= $item->sala ?></td>
                                <td><?= $item->procedimento ?></td>
                                <td>
                                    <div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exametemp/enviarpendenteatendimento/<?= $item->exames_id ?>/<?= $item->sala_id ?>/<?= $item->agenda_exames_id ?> ">
                                            Enviar P/ Atendimento
                                        </a>
                                    </div>
                                </td>
                            </tr>                    
                        <? } ?>
                    </tbody>
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