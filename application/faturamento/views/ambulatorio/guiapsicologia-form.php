<div class="content ficha_ceatox">
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
            Novo Medico
        </a>
    </div>
    <div class="bt_link_new">
        <a href="<?= base_url() ?>cadastros/pacientes">
            Cadastros
        </a>
    </div>
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
        <h3 class="singular"><a href="#">Marcar Fisioterapia</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentospsicologia" method="post">
                <fieldset>
                    <legend>Dados do Pacienete</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                        <input type="hidden" id="guia_id" name="guia_id"  value="<?= $ambulatorio_guia_id; ?>"/>
                    </div>
                    <div>
                        <label>Sexo</label>
                        <select name="sexo" id="txtSexo" class="size2">
                            <option value="M" <?
        if ($paciente['0']->sexo == "M"):echo 'selected';
        endif;
        ?>>Masculino</option>
                            <option value="F" <?
                            if ($paciente['0']->sexo == "F"):echo 'selected';
                            endif;
                            ?>>Feminino</option>
                        </select>
                    </div>

                    <div>
                        <label>Nascimento</label>


                        <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                    </div>

                    <div>

                        <label>Idade</label>
                        <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                    </div>

                    <div>
                        <label>Nome da M&atilde;e</label>


                        <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Consultas anteriores</legend>
                        <?
    if(count($consultasanteriores) > 0){
    foreach ($consultasanteriores as $value) {
        ?>
             <h6>ULTIMA ATENDIMENTO: <?= $value->procedimento; ?> - DATA: <b><?= substr($value->data, 8, 2) . '/' . substr($value->data, 5, 2) . '/' . substr($value->data, 0, 4); ?> </b> - M&eacute;dico: <b> <?= $value->medico; ?></b> - Convenio:  <?= $value->convenio; ?></h6>
            
            <?
        
    }
    }else{
        ?>
             <h6>NENHUMA CONSULTA ENCONTRADA</h6>
            <?
    }
?>
                </fieldset>

                <fieldset>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th width="70px;" class="tabela_header">Sala</th>
                                <th class="tabela_header">Medico</th>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">autorizacao</th>
                                <th class="tabela_header">V. Unit</th>
                                <th class="tabela_header">Qtde</th>
                                <th class="tabela_header">Pagamento</th>
                                <th class="tabela_header">ordenador</th>
<!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td > 
                                    <select  name="sala1" id="sala1" class="size1" >
                                        <option value="">Selecione</option>
<? foreach ($salas as $item) : ?>
                                            <option value="<?= $item->exame_sala_id; ?>"<?
    if ($sala == $item->nome):echo 'selected';
    endif;
    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select></td>
                                <td > 
                                    <select  name="medicoagenda" id="medicoagenda" class="size1" >
                                        <option value="">Selecione</option>
<? foreach ($medicos as $item) : ?>
                                            <option value="<?= $item->operador_id; ?>"<?
    if ($medico == $item->nome):echo 'selected';
    endif;
    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select></td>
                                <td  >
                                    <select  name="convenio1" id="convenio1" class="size1" >
                                        <option value="-1">Selecione</option>
<? foreach ($convenio as $item) : ?>
                                            <option value="<?= $item->convenio_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td  >
                                    <select  name="procedimento1" id="procedimento1" class="size1" >
                                        <option value="">Selecione</option>
                                    </select>
                                </td>

                                <td  ><input type="text" name="autorizacao1" id="autorizacao" class="size1"/></td>
                                <td  ><input type="text" name="valor1" id="valor1" class="texto01" readonly=""/></td>
                                <td  ><input type="text" name="qtde" id="qtde" class="texto01" readonly=""/></td>
                                <td >
                                    <select  name="formapamento" id="formapamento" class="size1" >
                                        <option value="0">Selecione</option>
<? foreach ($forma_pagamento as $item) : ?>
                                            <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td  ><input type="text" name="ordenador" id="ordenador" value="<?= $ordenador1; ?>" class="texto01"/></td>
<!--                                <td  width="70px;"><input type="text" name="observacao" id="observacao" class="texto04"/></td>-->
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
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/guiacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id?>/<?= $item->procedimento_tuss_id?>');">Cancelar

                                            </a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoficha/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha
                                            </a></div>
                                    </td>
        <? if ($item->faturado == "f" && $item->dinheiro== "t") { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarguia/" . $guia; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=500');">Faturar

                                                </a></div>
                                        </td>
        <? } ?>
                                </tr>

                            </tbody>
        <?
    }
}
?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="8">
                                Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                            </th>

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
                    source: "<?= base_url() ?>index?c=autocomplete&m=medicos",
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
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniopsicologia', {convenio1: $(this).val(), ajax: true}, function(j) {
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
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorpsicologia', {procedimento1: $(this).val(), ajax: true}, function(j) {
                            options = "";
                            options += j[0].valortotal;
                            qtde = "";
                            qtde += j[0].qtde;
                            document.getElementById("valor1").value = options;
                            document.getElementById("qtde").value = qtde;
                            $('.carregando').hide();
                        });
                    } else {
                        $('#valor1').html('value=""');
                    }
                });
            });




</script>
