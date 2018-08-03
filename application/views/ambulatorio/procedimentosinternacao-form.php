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
        $empresa_id = $this->session->userdata('empresa_id');
        ?>
        <h3 class="singular"><a href="#">Adicionar Procedimentos</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/exame/gravarprocedimentosinternacao" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                        <input type="hidden" id="txtinternacao_id" name="txtinternacao_id"  value="<?= $internacao_id; ?>"/>
                    </div>
                    <div>
                        <label>Sexo</label>
                        <select name="sexo" id="txtSexo" class="size1">
                            <option value="M" <?
                            if ($paciente['0']->sexo == "M"):echo 'selected';
                            endif;
                            ?>>Masculino</option>
                            <option value="F" <?
                            if ($paciente['0']->sexo == "F"):echo 'selected';
                            endif;
                            ?>>Feminino</option>
                            <option value="O" <?
                            if ($paciente['0']->sexo == "O"):echo 'selected';
                            endif;
                            ?>>Outros</option>
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

                    <table id="table_justa">
                        <thead>
                            <tr>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">Medico</th>
                                <th class="tabela_header">Qtde</th>
                                <th class="tabela_header">V. Unit</th>
                                <th class="tabela_header">Autorizacao</th>
                                <th class="tabela_header">Empresa</th>
                                <!--<th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="convenio1" id="convenio1" class="texto03" value="<?= @$internacao[0]->convenio; ?>" readonly=""/>
                                    <input type="hidden" name="convenio_id" id="convenio_id" class="texto03" value="<?= @$internacao[0]->convenio_id; ?>" readonly=""/>
                                </td>
                                <td >
                                    <select name="procedimento1" id="procedimento1" class="size2 chosen-select" data-placeholder="Selecione" tabindex="1" required="">
                                        <option value="">Selecione</option>
                                    </select>
                                </td>
                                <td > 
                                    <select  name="medicoagenda" id="medicoagenda" class="size1" required="">
                                        <option value="">Selecione</option>
                                        <? foreach ($medicos as $item) : ?>
                                            <option value="<?= $item->operador_id; ?>"<?
                                            if ($medico == $item->nome):echo 'selected';
                                            endif;
                                            ?>><?= $item->nome; ?></option>
                                                <? endforeach; ?>
                                    </select></td>
                                <td ><input type="text" name="qtde1" id="qtde1" value="1" class="texto00" readonly=""/></td>
                                <td >
                                    <input type="text" name="valor1" id="valor1" class="texto01" readonly=""/>
                                    <input type="hidden" name="valortot" id="valortot" class="texto01" readonly=""/>
                                </td>
                                <td ><input type="text" name="autorizacao1" id="autorizacao" class="size1"/></td>
                                <td>
                                    <select  name="txtempresa" id="empresa" class="size1" >
                                        <? foreach ($empresa as $item) : ?>
                                            <option value="<?= $item->empresa_id; ?>" <?
                                            if ($empresa_id == $item->empresa_id):echo 'selected';
                                            endif;
                                            ?>>
                                                <?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <!--<td><input type="text" name="observacao" id="observacao" class="texto04"/></td>-->
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

                <fieldset>
                    <legend>Procedimentos</legend>
                    <div class="bt_link_new">
                        <a onclick="javascript: return confirm('Deseja realmente faturar todos os procedimentos? ');" href="<?= base_url() . "ambulatorio/exame/gravarfaturaramentointernacaoconveniotodos/" . $internacao_id; ?>" target="_blank" >Faturar Todos
                        </a>
                    </div>
                    <br>
                    <br>
                    <!--<br>-->
                    <?
                    $total = 0;
                    $totalCartao = 0;
                    $orcamento = 0;
                    if (count($procedimentos) > 0) {
                        ?>
                        <table id="table_agente_toxico">
                            <thead>
                                <tr>
                                    <th class="tabela_header">Convenio</th>
                                    <th class="tabela_header">Procedimento</th>
                                    <th class="tabela_header">Médico</th>
                                    <th class="tabela_header">Autorização</th>
                                    <th class="tabela_header">Faturamento</th>
                                    <th class="tabela_header">Valor Total</th>
                                    <th class="tabela_header" colspan="2"></th>
                                </tr>
                            </thead>
                            <?
                            $estilo_linha = "tabela_content01";
                            foreach ($procedimentos as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                $total = $total + $item->valor_total;
                                ?>
                                <tbody>
                                    <tr>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>

                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->autorizacao; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?
                                            if ($item->faturado == 't') {
                                                echo 'Faturado';
                                            } else {
                                                echo 'Pendente';
                                            }
                                            ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <div class="bt_link_new">
                                                <a onclick="javascript: return confirm('Deseja realmente faturar o procedimento? ');" href="<?= base_url() . "ambulatorio/exame/gravarfaturaramentointernacaoconvenio/" . $item->internacao_procedimentos_id; ?>/<?= $item->internacao_id ?>" target="_blank">Faturar
                                                </a>
                                            </div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <a href="<?= base_url() ?>ambulatorio/exame/excluirprocedimentointernacao/<?= $item->internacao_procedimentos_id ?>/<?= $item->internacao_id ?>/<?= $paciente_id ?>" class="delete">
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                                <?
                            }
                            ?>

                            <tr>
                                <th class="tabela_footer" colspan="12" style="text-align: center;">
                                    Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                </th>
                            <? }
                            ?>
                        </tr>

                    </table> 

                </fieldset>
            </form>

        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 170px; }
</style>

<script type="text/javascript">

                                            $(function () {
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

                                            $(function () {
                                                $("#accordion").accordion();
                                            });


                                            $(function () {
                                                $('#convenio_id').change(function () {
                                                    if ($('#convenio_id').val()) {
                                                        $('.carregando').show();
                                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniointernacao', {convenio1: $('#convenio_id').val(), ajax: true}, function (j) {
                                                            options = '<option value=""></option>';
                                                            for (var c = 0; c < j.length; c++) {
                                                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                                            }
//                                                        $('#procedimento1').html(options).show();
                                                            $('#procedimento1 option').remove();
                                                            $('#procedimento1').append(options);
                                                            $("#procedimento1").trigger("chosen:updated");
                                                            $('.carregando').hide();
                                                        });
                                                    } else {
                                                        $('#procedimento1 option').remove();
                                                        $('#procedimento1').append('');
                                                        $("#procedimento1").trigger("chosen:updated");
                                                    }
                                                });
                                            });

                                            if ($('#convenio_id').val() > 0) {
                                                $('.carregando').show();
                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniointernacao', {convenio1: $('#convenio_id').val(), ajax: true}, function (j) {
                                                    options = '<option value=""></option>';
                                                    for (var c = 0; c < j.length; c++) {
                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                                    }
//                                                        $('#procedimento1').html(options).show();
                                                    $('#procedimento1 option').remove();
                                                    $('#procedimento1').append(options);
                                                    $("#procedimento1").trigger("chosen:updated");
                                                    $('.carregando').hide();
                                                });
                                            }


                                            $(function () {
                                                $('#procedimento1').change(function () {
                                                    if ($(this).val()) {
                                                        $('.carregando').show();
                                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {

                                                            var valorTotal = parseFloat(j[0].valortotal);
                                                            var qt = document.getElementById("qtde1").value;
                                                            document.getElementById("valor1").value = valorTotal;
                                                            document.getElementById("valortot").value = valorTotal;
                                                            $('.carregando').hide();

                                                        });
                                                    } else {
                                                        $('#valor1').html('value=""');
                                                    }
                                                });
                                            });

</script>