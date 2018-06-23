<? // var_dump($obj->_paciente_id); die;   ?>
<div class="content ficha_ceatox"  >
    <?
    $empresa_id = $this->session->userdata('empresa_id');
    $empresa = $this->guia->listarempresa($empresa_id);
    $empresaPermissoes = $this->guia->listarempresapermissoes();
    $odontologia_alterar = $empresaPermissoes[0]->odontologia_valor_alterar;
    ?>
    <div>
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exame/gravarautorizarorcamentonaocadastro/<?=$ambulatorio_orcamento_id?>" method="post">  
            <fieldset>
                <legend>Dados do Paciente</legend>

                <div>
                    <label>Nome</label>
                    <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" value="<?= @$obj->_paciente_id; ?>"/>
                    <input type="text" id="txtNome" required name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" required/>
                </div>
                <div>
                    <label>Dt de nascimento</label>

                    <input type="text" name="nascimento" id="nascimento" class="texto02" alt="date"  maxlength="10" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" required=""/>
                </div>
                <div>
                    <label>Telefone</label>
                    <input type="text" id="txtTelefone" class="texto02" name="txtTelefone" value="<?= @$obj->_telefone; ?>" required=""/>
                </div>
                <div>
                    <label>Celular</label>
                    <input type="text" id="txtCelular" class="texto02" name="txtCelular" value="<?= @$obj->_celular; ?>"/>
                </div>
                
            </fieldset>
            <fieldset>
                <!--<hr>-->
                <div>
                    <button type="submit" name="btnEnviar">Enviar</button>
                </div>
            </fieldset>

            

            <fieldset>
                <?
                $total = 0;
                $totalCartao = 0;
                $orcamento = 0;
                if (count($exames) > 0) {
                    ?>
                    <table id="table_agente_toxico">
                        <thead>
                            <tr>
                                <th colspan="10"><span style="font-size: 12pt; font-weight: bold;">Operador Responsável: <?= @$responsavel[0]->nome ?></span></th>
                            </tr>
                            <tr>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Grupo</th>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">Forma de Pagamento</th>
                                <th class="tabela_header" width="80">Descrição</th>
                                <th class="tabela_header">Preferência</th>
                                <th class="tabela_header">V. Total</th>
                                <th class="tabela_header">V. Ajuste</th>
                                <th class="tabela_header"></th>
                            </tr>
                        </thead>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($exames as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            $total = $total + $item->valor_total;
                            $totalCartao = $totalCartao + $item->valor_total_ajustado;
                            
                            $orcamento = $item->orcamento_id;
                            
                            switch ($item->turno_prefencia){
                                case 'manha':
                                    $turno = "Manhã";
                                    break;
                                case 'tarde':
                                    $turno = "Tarde";
                                    break;
                                case 'noite':
                                    $turno = "Noite";
                                    break;
                                default:
                                    $turno = "Não informado";
                                    break;
                            }
                            
                            switch ($item->dia_semana_preferencia){
                                case 'segunda':
                                    $dia = "Segunda-Feira";
                                    break;
                                case 'terca':
                                    $dia = "Terça-Feira";
                                    break;
                                case 'quarta':
                                    $dia = "Quarta-Feira";
                                    break;
                                case 'quinta':
                                    $dia = "Quinta-Feira";
                                    break;
                                case 'sexta':
                                    $dia = "Sexta-Feira";
                                    break;
                                case 'sabado':
                                    $dia = "Sábado";
                                    break;
                                case 'domingo':
                                    $dia = "Domingo";
                                    break;
                                default:
                                    $dia = "Não informado";
                                    break;
                            }
                            
                            ?>
                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->forma_pagamento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao_procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <p style="font-size: 8pt;">
                                            <span style="font-weight: bold">Dia:</span> <?= $dia ?><br>
                                            <span style="font-weight: bold">Turno:</span> <?= $turno ?>
                                        </p>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total_ajustado; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirorcamentorecepcao/<?= $item->ambulatorio_orcamento_item_id ?>/<?= $item->paciente_id ?>/<?= $item->orcamento_id ?>" class="delete">
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                            <?
                        }
                    ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="2" style="vertical-align: top;">
                                    Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                </th>
                                <th class="tabela_footer" colspan="7" style="vertical-align: top;">
                                    Valor Total Ajustado: <?php echo number_format($totalCartao, 2, ',', '.'); ?>
                                </th>
                                
                            </tr>
                        </tfoot>
                    </table> 
                    <?
                }
            ?>
            </fieldset>
        </form>
    </div>

</div>


<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 100%; }
</style>
<script>

//    $(".chosen-container").each(function() {
////       $(this).attr('style', 'width: 100%');
//   })
                                function mascaraTelefone(campo) {

                                    function trata(valor, isOnBlur) {

                                        valor = valor.replace(/\D/g, "");
                                        valor = valor.replace(/^(\d{2})(\d)/g, "($1)$2");

                                        if (isOnBlur) {

                                            valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
                                        } else {

                                            valor = valor.replace(/(\d)(\d{3})$/, "$1-$2");
                                        }
                                        return valor;
                                    }

                                    campo.onkeypress = function (evt) {

                                        var code = (window.event) ? window.event.keyCode : evt.which;
                                        var valor = this.value

                                        if (code > 57 || (code < 48 && code != 0 && code != 8 && code != 9)) {
                                            return false;
                                        } else {
                                            this.value = trata(valor, false);
                                        }
                                    }

                                    campo.onblur = function () {

                                        var valor = this.value;
                                        if (valor.length < 13) {
                                            this.value = ""
                                        } else {
                                            this.value = trata(this.value, true);
                                        }
                                    }

                                    campo.maxLength = 14;
                                }


                                jQuery("#txtTelefone")
                                        .mask("(99) 9999-9999?9")
                                        .focusout(function (event) {
                                            var target, phone, element;
                                            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                                            phone = target.value.replace(/\D/g, '');
                                            element = $(target);
                                            element.unmask();
                                            if (phone.length > 10) {
                                                element.mask("(99) 99999-999?9");
                                            } else {
                                                element.mask("(99) 9999-9999?9");
                                            }
                                        });

                                jQuery("#txtCelular")
                                        .mask("(99) 9999-9999?9")
                                        .focusout(function (event) {
                                            var target, phone, element;
                                            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                                            phone = target.value.replace(/\D/g, '');
                                            element = $(target);
                                            element.unmask();
                                            if (phone.length > 10) {
                                                element.mask("(99) 99999-999?9");
                                            } else {
                                                element.mask("(99) 9999-9999?9");
                                            }
                                        });

                                <? if (@$obj->_paciente_id == NULL) { ?>
                                    $(function () {
                                        $("#txtNome").autocomplete({
                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
                                            minLength: 5,
                                            focus: function (event, ui) {
                                                $("#txtNome").val(ui.item.label);
                                                return false;
                                            },
                                            select: function (event, ui) {
                                                $("#txtNome").val(ui.item.value);
                                                $("#txtNomeid").val(ui.item.id);
                                                $("#txtTelefone").val(ui.item.itens);
                                                $("#txtCelular").val(ui.item.celular);
                                                $("#nascimento").val(ui.item.valor);
                                                return false;
                                            }
                                        });
                                    });
                                <? } ?>



                                $(function () {
                                    $('#grupo1').change(function () {
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $(this).val(), convenio1: $('#convenio1').val()}, function (j) {
                                            options = '<option value=""></option>';
                                            for (var c = 0; c < j.length; c++) {
                                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                            }
                                            $('#procedimento1 option').remove();
                                            $('#procedimento1').append(options);
                                            $("#procedimento1").trigger("chosen:updated");

//                                    $("#procedimento1").trigger("chosen:updated");
                                            $('.carregando').hide();
                                        });
                                    });
                                });

                                if ($('#grupo1').val() != '') {
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $('#grupo1').val(), convenio1: $('#convenio1').val()}, function (j) {
                                        options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                        }
//                                            $('#procedimento1').html(options).show();

                                        $('#procedimento1 option').remove();
                                        $('#procedimento1').append(options);
                                        $("#procedimento1").trigger("chosen:updated");
                                        $('.carregando').hide();
                                    });
                                }

                                $(function () {
                                    $("#medico1").autocomplete({
                                        source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                        minLength: 3,
                                        focus: function (event, ui) {
                                            $("#medico1").val(ui.item.label);
                                            return false;
                                        },
                                        select: function (event, ui) {
                                            $("#medico1").val(ui.item.value);
                                            $("#crm1").val(ui.item.id);
                                            return false;
                                        }
                                    });
                                });

                                $(function () {
                                    $('#convenio1').change(function () {
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioorcamento', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                options = '<option value=""></option>';
                                                for (var c = 0; c < j.length; c++) {
                                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                }
                                                $('#procedimento1 option').remove();
                                                $('#procedimento1').append(options);
                                                $("#procedimento1").trigger("chosen:updated");
                                                $('.carregando').hide();
                                            });
                                            if ($('#grupo1').val() != '') {
                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $('#grupo1').val(), convenio1: $('#convenio1').val()}, function (j) {
                                                    options = '<option value=""></option>';
                                                    for (var c = 0; c < j.length; c++) {
                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                    }
//                                            $('#procedimento1').html(options).show();

                                                    $('#procedimento1 option').remove();
                                                    $('#procedimento1').append(options);
                                                    $("#procedimento1").trigger("chosen:updated");
                                                    $('.carregando').hide();
                                                });
                                            }

                                        } else {
                                            $('#procedimento1').html('<option value="">Selecione</option>');
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
                                                <? if ($odontologia_alterar == 't') { ?>
                                                    if (j[0].grupo == 'ODONTOLOGIA') {
                                                        $("#valor1").prop('readonly', false);
                                                    } else {
                                                        $("#valor1").prop('readonly', true);
                                                    }
                                                <? } ?>
                                                document.getElementById("valor1").value = options;
                                                
                                                if( $('#formapamento').val() ){
                                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoorcamento', {formapamento1: $('#formapamento').val(), ajax: true}, function (j) {
                                                        var ajuste = (j[0].ajuste == null) ? 0 : j[0].ajuste;

                                                        var valorajuste1 = parseFloat(($("#valor1").val() * ajuste) / 100) + parseFloat($("#valor1").val());
                                                        
                                                        $("#ajustevalor1").val(valorajuste1.toFixed(2));

                                                        $('.carregando').hide();
                                                    });
                                                }
//                                                else{
//                                                    $("#ajustevalor1").val($("#valor1").val());
//                                                }
                                                
                                                $('.carregando').hide();
                                            });
                                        } else {
                                            $('#valor1').html('value=""');
                                        }
                                    });
                                });


                                if ($("#convenio1").val() != "-1") {
//                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $("#convenio1").val()}, function (j) {
//                                        options = '<option value=""></option>';
//                                        for (var c = 0; c < j.length; c++) {
//                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
//                                        }
//                                        $('#procedimento1').html(options).show();
//                                        $('.carregando').hide();
//                                    });
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $("#grupo1").val(), convenio1: $('#convenio1').val()}, function (j) {
                                        options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                        }
//                                        $('#procedimento1').html(options).show();
                                        $('.carregando').hide();
                                    });
                                }
                                

                                 $(function () {
                                    $('#formapamento').change(function () {
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/formapagamentoorcamento', {formapamento1: $(this).val(), ajax: true}, function (j) {
                                                var ajuste = (j[0].ajuste == null) ? 0 : j[0].ajuste;

                                                var valorajuste1 = parseFloat(($("#valor1").val() * ajuste) / 100) + parseFloat($("#valor1").val());

                                                $("#ajustevalor1").val(valorajuste1.toFixed(2));

                                                
                                                $('.carregando').hide();
                                            });
                                        }
                                        else{
                                            $("#ajustevalor1").val('');
                                        }
                                    });
                                });



</script>
