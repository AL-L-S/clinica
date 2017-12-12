<? // var_dump($obj->_paciente_id); die; ?>
<div class="content ficha_ceatox"  >
<?
        $empresa_id = $this->session->userdata('empresa_id');
        $empresa = $this->guia->listarempresa($empresa_id);

?>
    <div>
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarorcamentorecepcao" method="post">  
            <fieldset>
                <legend>Dados do Paciente</legend>

                <div>
                    <label>Nome</label>
                    <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" value="<?= @$obj->_paciente_id ;?>"/>
                    <input type="text" id="txtNome" required name="txtNome" class="texto10" value="<?= @$obj->_nome ;?>" required/>
                </div>
                <div>
                    <label>Dt de nascimento</label>

                    <input type="text" name="nascimento" id="nascimento" class="texto02" alt="date"  maxlength="10" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>"/>
                </div>
                <div>
                    <label>Telefone</label>


                    <input type="text" id="txtTelefone" class="texto02" name="txtTelefone" value="<?= @$obj->_telefone; ?>"/>
                </div>
                <div>
                    <label>Celular</label>


                    <input type="text" id="txtCelular" class="texto02" name="txtCelular" value="<?= @$obj->_celular; ?>"/>
                </div>
            </fieldset>

            <fieldset>
                <table id="table_justa">
                    <thead>

                        <tr>
                            <th class="tabela_header">Convenio*</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Procedimento*</th>
                            <th class="tabela_header">F. de Pagamento</th>
                            <th class="tabela_header">Qtde*</th>
                            <th class="tabela_header">V. Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td  width="50px;">
                                <select  name="convenio1" id="convenio1" class="size1" required="">
                                    <option value="-1">Selecione</option>
                                    <?
                                    $lastConv = $exames[count($exames) - 1]->convenio_id;
                                    foreach ($convenio as $item) :
                                        ?>
                                        <option value="<?= $item->convenio_id; ?>" <? if ($lastConv == $item->convenio_id) echo 'selected'; ?>>
                                            <?= $item->nome; ?>
                                        </option>
                                    <? endforeach; ?>
                                </select>
                            </td>

                            <td width="50px;">
                                <select  name="grupo1" id="grupo1" class="size1">
                                    <option value="">Selecione</option>
                                    <?
                                    $lastGrupo = $exames[count($exames) - 1]->grupo;
                                    foreach ($grupos as $value) :
                                        ?>
                                        <option value="<?= $value->nome; ?>" <? if ($lastGrupo == $value->nome) echo 'selected'; ?>>
                                            <?= $value->nome; ?>
                                        </option>
                                    <? endforeach; ?>
                                </select>
                            </td>

                            <td  width="50px;">
                                
                                <select name="procedimento1" id="procedimento1" required class="size4 chosen-select" data-placeholder="Selecione" tabindex="1">
                                    <option value="">Selecione</option>
                                </select>
                            </td>
                            <td  width="100px;">
                                
                                <select name="formapamento" id="formapamento" class="size1" >
                                    <option value="">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td  width="10px;"><input type="text" name="qtde1" id="qtde1" value="1" class="texto00"/></td>
                            <td  width="20px;"><input type="text" name="valor1" id="valor1" class="texto01" readonly=""/></td>
                        </tr>
                        <?if($empresa[0]->impressao_orcamento == 1){?>
                         <tr>
                            <th colspan="6" class="tabela_header">Observação</th>
                            
                        </tr>
                        <tr>
                            <td colspan="6" ><textarea  type="text" name="observacao" id="observacao" class="textarea" cols="60" rows="4" > </textarea></td>
                            
                        </tr>    
                            
                        <?}
                        
                        ?>
                        

                    </tbody>
                </table> 
                <hr/>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </fieldset>

                        <fieldset>
                            <?
                            $total = 0;
                            $orcamento = 0;
                            if (count($exames) > 0) {
                                ?>
                                    <table id="table_agente_toxico" border="0">
                                        <thead>
                                            <tr>
                                                <th colspan="10"><span style="font-size: 12pt; font-weight: bold;">Operador Responsavel: <?=@$responsavel[0]->nome?></span></th>
                                            </tr>
                                            <tr>
                                                <th class="tabela_header">Convenio</th>
                                                <th class="tabela_header">Grupo</th>
                                                <th class="tabela_header">Procedimento</th>
                                                <th class="tabela_header">Forma de Pagamento</th>
                                                <th class="tabela_header">Descrição</th>
                                                <th class="tabela_header">V. Unit</th>
                                                <th class="tabela_header"></th>
                                            </tr>
                                        </thead>
                <?
                $estilo_linha = "tabela_content01";
                foreach ($exames as $item) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    $total = $total + $item->valor_total;
                    $orcamento = $item->orcamento_id;
                    ?>
                                                <tbody>
                                                    <tr>
                                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->forma_pagamento; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao_procedimento; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>">
                                                            <a href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirorcamentorecepcao/<?= $item->ambulatorio_orcamento_item_id ?>/<?= $item->paciente_id ?>/<?= $item->orcamento_id ?>" class="delete">
                                                            </a>
                                                        </td>
                                                    </tr>
                    
                                                </tbody>
                    <?
                }
            }
            ?>
                                <tfoot>
                                    <tr>
                                        <th class="tabela_footer" colspan="2">
                                            Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                        </th>
                                        <th colspan="" align="center">
                                            <center>
                                            <div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/impressaoorcamentorecepcao/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Imprimir Or&ccedil;amento
                                            </a></div>
                                            </center>
                                        </th>
                                        <th colspan="2" align="center">
                                            <center>
                                            <div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/orcamentorecepcaofila/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Fila de Impressão
                                            </a></div>
                                            </center>
                                        </th>
                                        <th colspan="2" align="center">
                                            <center>
                                            <div class="bt_linkf">
                                                <a href="<?= base_url() . "ambulatorio/exame/autorizarorcamento/" . $orcamento; ?>" target='_blank'>Autorizar Orçamento</a>
                                            </div>
                                            </center>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table> 
            
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
    /*#procedimento1_chosen a { width: 300px; }*/
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
                            
                            
                        mascaraTelefone(form_exametemp.txtTelefone);
                        mascaraTelefone(form_exametemp.txtCelular);
                        
                        <? if( @$obj->_paciente_id ==  NULL ) { ?>
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
                                        document.getElementById("valor1").value = options
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



</script>
