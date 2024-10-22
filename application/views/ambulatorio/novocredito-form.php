<div class="content ficha_ceatox">
    <div >
        <h3 class="singular"><a href="#">Novo Crédito</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/exametemp/gravarcredito" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                    </div>
                    <div>
                        <label>Sexo</label>
                        <input type="text" id="txtSexo" name="sexo"  class="texto05" value="<?
                        if ($paciente['0']->sexo == "M"):echo 'Masculino';
                        endif;
                        if ($paciente['0']->sexo == "F"):echo 'Feminino';
                        endif;
                        if ($paciente['0']->sexo == "O"):echo 'Outro';
                        endif;
                        ?>" readonly/>
                    </div>

                    <div>
                        <label>Nascimento</label>
                        <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" readonly/>
                    </div>

                    <div>
                        <label>Idade</label>
                        <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                    </div>
                </fieldset>

                <fieldset>
                    <table>
                        <? 
                        if (@$permissoes[0]->associa_credito_procedimento == 't') { ?>
                            <tr>
                                <td>Convenio</td>
                                <td>
                                    <select name="convenio1" id="convenio1" class="size2" required>
                                        <option value="">Selecione</option>
                                        <? foreach ($convenio as $item) : ?>
                                            <option value="<?= $item->convenio_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Procedimento</td>
                                <td>
                                    <select name="procedimento1" id="procedimento1" class="size4 chosen-select" data-placeholder="Selecione" tabindex="1">
                                        <option value="">Selecione</option>
                                    </select>
        <!--                            <select  name="procedimento1" id="procedimento1" class="size8" required>
                                        <option value="">-- Escolha um procedimento --</option>
                                    </select>-->
                                </td>
                            </tr>
                            <tr>
                                <td>Valor Unitario</td>
                                <td><input type="text" name="valor1" id="valor1" class="texto02" readonly="" required/></td>
                            </tr>

                        <? }
                        else {
                            ?>
                            <tr>
                                <td>Valor Unitario</td>
                                <td><input type="text" name="valor1" id="valor1" class="texto02" alt="decimal" required/></td>
                            </tr>                            
                        <?    
                        } 
                        
                        if(@$permissoes[0]->ajuste_pagamento_procedimento == 't'){ 
                        ?>
<!--                            <tr class="ajustePagamento">
                                <td>Forma de Pagamento</td>
                                <td>
                                    <select name="formapamento" id="formapamento" class="size2" onchange="buscaValorAjustePagamentoProcedimento()">
                                        <option value="">Selecione</option>
                                        <? foreach ($forma_pagamento as $item) :
                                            if ($item->forma_pagamento_id == 1000) continue; ?>
                                            <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr class="ajustePagamento">
                                <td>Valor Ajuste</td>
                                <td><input type="text" name="valorAjuste" id="valorAjuste" class="texto02" readonly=""/></td>
                            </tr>  -->
                        <? } ?>
                    </table>

                    <hr/>

                    <button type="submit" name="btnEnviar">Enviar</button>
                </fieldset>
            </form>
        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    /*.chosen-container{ margin-top: 5pt;}*/
    /*#procedimento1_chosen a { width: 130px; }*/
</style>

<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos', {convenio1: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
//                    $('#procedimento1').html(options).show();
                    $('#procedimento1 option').remove();
                    $('#procedimento1').append(options);
                    $("#procedimento1").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1 option').remove();
                $('#procedimento1').append('');
                $("#procedimento1").trigger("chosen:updated");
//                $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });


    $(function () {
        $('#procedimento1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    if (j[0].grupo == "ODONTOLOGIA") {
                        $("#valor1").removeAttr("readonly", "false");
                    } else {
                        $("#valor1").attr("readonly", "");
                    }

                    document.getElementById("valor1").value = options;
                    $('.carregando').hide();
                });
            } else {
                $('#valor1').html('value=""');
            }
        });
    });
    <? 
    if(@$permissoes[0]->ajuste_pagamento_procedimento == 't'){ 
        ?>
        $(function () {
            $('#procedimento1').change(function () {
                if ($(this).val()) {
                    $('.carregando').show();

                    var procedimento = $(this).val();
                    $("#formapamento").prop('required', false);
                    $("#valorAjuste").val('');

                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {

                        verificaAjustePagamentoProcedimento(procedimento);
                        var options = '<option value="">Selecione</option>';
                        for (var c = 0; c < j.length; c++) {
                            if (j[c].forma_pagamento_id != null) {
                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                            }
                        }
                        $('#formapamento').html(options).show();
                        $('.carregando').hide();

                    });
                }
            });
        });
        <? 
    } 
    ?>

    
    function verificaAjustePagamentoProcedimento(procedimentoConvenioId){
        <? if(@$permissoes[0]->ajuste_pagamento_procedimento == 't'){ ?>
            $.getJSON('<?= base_url() ?>autocomplete/verificaAjustePagamentoProcedimento', {procedimento: procedimentoConvenioId, ajax: true}, function (p) {
                if (p.length != 0) {
                    $("#formapamento").prop('required', true);
                }
            });
        <? } ?>
    }

    function buscaValorAjustePagamentoProcedimento(){                                    
        $.getJSON('<?= base_url() ?>autocomplete/buscaValorAjustePagamentoProcedimento', {procedimento: $('#procedimento1').val(), forma: $('#formapamento').val(), ajax: true}, function (p) {
            if (p.length != 0) {
                $("#valorAjuste").val(p[0].ajuste);
            }
            else{
                $("#valorAjuste").val('');
            }
        });
    }

</script>