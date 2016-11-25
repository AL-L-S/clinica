
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Laudo Anterior</a></h3>
        <div>

            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" width="300px;">Nome</th>
                        <th class="tabela_header" width="30px;">Data</th>
                        <th class="tabela_header" width="130px;">M&eacute;dico</th>
                        <th class="tabela_header" width="300px;">Procedimento</th>
<!--                            <th class="tabela_header">M&eacute;dico Revisor</th>
                        <th class="tabela_header">Status Revisor</th>-->
                        <th class="tabela_header" colspan="4" width="140px;"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($laudos_anteriores as $item) {


                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="130px;"><?= substr($item->medico,0 ,18); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                            Imprimir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                            imagem</a></div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#data" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
