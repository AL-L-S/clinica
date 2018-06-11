<div class="content ficha_ceatox">
    <div >
        <?
        $sala = "";
        $ordenador1 = "";
        $sala_id = "";
        $medico_id = "";
        $medico = "";
        $medico_solicitante = "";
        $medico_solicitante_id = "";
        $convenio_paciente = "";
        if ($contador > 0) {
            $sala_id = $exames[0]->agenda_exames_nome_id;
            $sala = $exames[0]->sala;
            $medico_id = $exames[0]->medico_agenda_id;
            $medico = $exames[0]->medico_agenda;
            $medico_solicitante = $exames[0]->medico_solicitante;
            $medico_solicitante_id = $exames[0]->medico_solicitante_id;
            $convenio_paciente = $exames[0]->convenio_id;
            $ordenador1 = $exames[0]->ordenador;
        }
        ?>
        <h3 class="singular"><a href="#">Marcar exames</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentos" method="post">
                <fieldset>
                    <legend>Dados do paciente</legend>
                    <div>
                        <input type="hidden" id="guia_id" name="guia_id"  value="<?= $ambulatorio_guia_id; ?>"/>
                    </div>
                </fieldset>

                <fieldset>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th width="70px;" class="tabela_header">Sala</th>
                                <th class="tabela_header">Medico</th>
                                <th class="tabela_header">ordenador</th>
<!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  width="10px;"><input type="text" name="qtde1" id="qtde1" value="1" class="texto00"/></td>
                                <td  width="50px;"><input type="text" name="medico1" id="medico1" value="<?= $medico_solicitante; ?>" class="size1"/></td>
                                <td  width="50px;"><input type="hidden" name="crm1" id="crm1" value="<?= $medico_solicitante_id; ?>" class="texto01"/></td>
                            </tr>

                        </tbody>

                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="4">
                                </th>
                            </tr>
                        </tfoot>
                    </table> 
                    <hr/>
                    <button type="submit" name="btnEnviar">Adicionar</button>
                </fieldset>
            </form>
            <fieldset>
<?
$total = 0;
$guia = 0;
if ($contador > 0) {
    ?>
                    <table id="table_agente_toxico" border="0">
                        <thead>

                            <tr>
                                <th class="tabela_header">Data</th>
                                <th class="tabela_header">Hora</th>
                                <th class="tabela_header">Sala</th>
                                <th class="tabela_header">Valor</th>
                                <th class="tabela_header">Exame</th>
                                <th colspan="3" class="tabela_header">&nbsp;</th>
                            </tr>
                        </thead>
    <?
    $estilo_linha = "tabela_content01";
    foreach ($exames as $item) {
        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
        $total = $total + $item->valor_total;
        $guia = $item->guia_id;
        ?>
                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->sala; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/guiacancelamento/<?= $item->agenda_exames_id ?>');">Cancelar

                                            </a></div>
                                    </td>
                                </tr>

                            </tbody>
        <?
    }
}
?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="6">
                                Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                            </th>
                            <th colspan="2" align="center"><center><div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarguia/" . $guia; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=500');">Faturar Guia

                                                </a></div></center></th>
                        </tr>
                    </tfoot>
                </table> 

            </fieldset>

        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

            $(function() {
                $("#data").datepicker({
                    autosize: true,
                    changeYear: true,
                    changeMonth: true,
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                    buttonImage: '<?= base_url() ?>img/form/date.png',
                    dateFormat: 'dd/mm/yy'
                });
            });

            $(function() {
                $("#accordion").accordion();
            });


            $(function() {
                $("#medico1").autocomplete({
                    source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                    minLength: 3,
                    focus: function(event, ui) {
                        $("#medico1").val(ui.item.label);
                        return false;
                    },
                    select: function(event, ui) {
                        $("#medico1").val(ui.item.value);
                        $("#crm1").val(ui.item.id);
                        return false;
                    }
                });
            });

            $(function() {
                $('#convenio1').change(function() {
                    if ($(this).val()) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function(j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                            }
                            $('#procedimento1').html(options).show();
                            $('.carregando').hide();
                        });
                    } else {
                        $('#procedimento1').html('<option value="">Selecione</option>');
                    }
                });
            });


            $(function() {
                $('#procedimento1').change(function() {
                    if ($(this).val()) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function(j) {
                            options = "";
                            options += j[0].valortotal;
                            document.getElementById("valor1").value = options
                            $('.carregando').hide();
                        });
                    } else {
                        $('#valor1').html('value=""');
                    }
                });
            });




</script>