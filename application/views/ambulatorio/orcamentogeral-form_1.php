<? // var_dump($obj->_paciente_id); die;   ?>
<div class="content ficha_ceatox"  >
    <?
    $empresa_id = $this->session->userdata('empresa_id');
    $empresa = $this->guia->listarempresa($empresa_id);
    $empresaPermissoes = $this->guia->listarempresapermissoes();
    $odontologia_alterar = $empresaPermissoes[0]->odontologia_valor_alterar;
    ?>
    <div>
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarorcamentorecepcao" method="post">  
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
                <table id="table_justa">
                    <thead>

                        <tr>
                            <th class="tabela_header">Empresa*</th>
                            <th class="tabela_header">Convenio*</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Procedimento*</th>
                            <th class="tabela_header">Data Preferência</th>
                            <th class="tabela_header">Turno</th>
                            <th class="tabela_header">Qtde*</th>
                            <th class="tabela_header">V. Unit</th>
                            <th class="tabela_header">F. de Pagamento</th>
                            <th class="tabela_header">V. Ajuste</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td  width="50px;">
                                <select  name="empresa1" id="empresa1" class="size1" required="">
                                    <option value="">Selecione</option>
                                    <? foreach ($empresa as $item) : ?>
                                        <option value="<?= $item->empresa_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
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
                            <td>
                                <div class="input-data">
                                    <input type="text" name="txtdata" id="txtdata" alt="date" class="size1"/>
                                </div>
                                <div class="select-data">
                                    <select name="txtdata" id="txtdata" class="size1" >
                                        <option value="">Selecione</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <select name="turno_preferencia" id="turno_preferencia" class="size1" >
                                    <option value="">Selecione</option>
                                    <option value="manha" <?if(@$exames[count($exames)-1]->turno_prefencia == "manha") echo 'selected';?>>Manhã</option>
                                    <option value="tarde" <?if(@$exames[count($exames)-1]->turno_prefencia == "tarde") echo 'selected';?>>Tarde</option>
                                    <option value="noite" <?if(@$exames[count($exames)-1]->turno_prefencia == "noite") echo 'selected';?>>Noite</option>
                                </select>
                            </td>
                            
                            <td  width="10px;"><input type="text" name="qtde1" id="qtde1" value="1" class="texto00"/></td>
                            <td  width="20px;"><input type="text" name="valor1" id="valor1" class="texto01" readonly=""/></td>
                            <td  width="100px;">
                                <select name="formapamento" id="formapamento" class="size1" onchange="buscaValorAjustePagamentoProcedimento()">
                                    <option value="">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td  width="20px;"><input type="text" name="ajustevalor1" id="ajustevalor1" class="texto01" readonly=""/></td>
                        </tr>
                        <? if ($empresa[0]->impressao_orcamento == 1) { ?>
                            <tr>
                                <th colspan="6" class="tabela_header">Observação</th>

                            </tr>
                            <tr>
                                <td colspan="6" ><textarea  type="text" name="observacao" id="observacao" class="textarea" cols="60" rows="4" > </textarea></td>

                            </tr>    

                        <? }
                        ?>


                    </tbody>
                </table> 
                <hr/>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </fieldset>

            <fieldset>
                <legend>Orçamento Atual</legend>
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
                                <th class="tabela_header">Empresa</th>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Grupo</th>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">Forma de Pagamento</th>
                                <th class="tabela_header">Descrição</th>
                                <th class="tabela_header">V. Total</th>
                                <th class="tabela_header">V. Ajuste</th>
                                <th class="tabela_header">Data</th>
                                <th class="tabela_header">Turno</th>
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
                            
                            ?>
                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->forma_pagamento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao_procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total_ajustado; ?></td>
                                    
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <? if ($item->data_preferencia != "") echo date("d/m/Y", strtotime($item->data_preferencia)); 
                                           else echo "Não informado";?>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $turno ?></td>
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
                                <th class="tabela_footer" colspan="" style="vertical-align: top;">
                                    Valor Total Ajustado: <?php echo number_format($totalCartao, 2, ',', '.'); ?>
                                </th>
                                <th colspan="3" align="center">
                                    <center>
                                        <div class="bt_linkf">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/impressaoorcamentorecepcao/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Imprimir Or&ccedil;amento</a>
                                        </div>
                                    </center>
                                    <center>
                                        <div class="bt_linkf">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/orcamentorecepcaofila/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Fila de Impressão</a>
                                        </div>
                                    </center>
                                </th>
                                <th colspan="3" align="center">
                                    <? if ($exames[0]->autorizado != 't') { ?>
                                        <center>
                                            <div class="bt_linkf">
                                                <a href="<?= base_url() . "ambulatorio/exame/gravarautorizarorcamento/" . $orcamento; ?>" target='_blank'>Autorizar Orçamento</a>
                                            </div>
                                        </center>
                                    <? } ?>
                                    <center>
                                        <div class="bt_linkf">
                                            <a href="<?= base_url() . "ambulatorio/guia/transformaorcamentocredito/" . $orcamento; ?>" target='_blank'>Transformar em Crédito</a>
                                        </div>
                                    </center>
                                </th>
                            </tr>
                        </tfoot>
                    </table> 
                
                    </fieldset>
                    <?
                    foreach($orcamentos as $value){
                        
                        $total = 0;
                        $totalCartao = 0;
                        $orcamento = 0;
                        $autorizado = false;
                    
                        if($value->qtdeproc == 0) continue;?>
            
                        <fieldset>
                            <table id="table_agente_toxico">
                                <thead>
                                    <tr>
                                        <th colspan="10"><span style="font-size: 12pt; font-weight: bold;">Operador Responsável: <?= @$value->responsavel ?></span></th>
                                    </tr>
                                    <tr>
                                        <th class="tabela_header">Empresa</th>
                                        <th class="tabela_header">Convenio</th>
                                        <th class="tabela_header">Grupo</th>
                                        <th class="tabela_header">Procedimento</th>
                                        <th class="tabela_header">Forma de Pagamento</th>
                                        <th class="tabela_header">Descrição</th>
                                        <th class="tabela_header">V. Total</th>
                                        <th class="tabela_header">V. Ajuste</th>
                                        <th class="tabela_header">Data</th>
                                        <th class="tabela_header">Turno</th>
                                        <th class="tabela_header"></th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                            <?

                            $estilo_linha = "tabela_content01";
                            foreach($orcamentoslista as $item){
                                if ($item->orcamento_id == $value->ambulatorio_orcamento_id) {

                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                    $total = $total + $item->valor_total;
                                    $totalCartao = $totalCartao + $item->valor_total_ajustado;

                                    $orcamento = $item->orcamento_id;
                                    
                                    if ($item->autorizado == 't'){
                                        $autorizado = true;
                                    }

                                    switch ($item->turno_prefencia) {
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
                                    } ?>
                                        <tr>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->forma_pagamento; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao_procedimento; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total_ajustado; ?></td>
                                            
                                            <td class="<?php echo $estilo_linha; ?>">
                                                <? if ($item->data_preferencia != "") echo date("d/m/Y", strtotime($item->data_preferencia)); 
                                                   else echo "Não informado";?>
                                            </td>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $turno ?></td>
<!--                                            <td class="<?php echo $estilo_linha; ?>">
                                                <a href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirorcamentorecepcao/<?= $item->ambulatorio_orcamento_item_id ?>/<?= $item->paciente_id ?>/<?= $item->orcamento_id ?>" class="delete">
                                                </a>
                                            </td>-->
                                        </tr>
                                <?
                                }
                            }
                            ?>
                                        

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="tabela_footer" colspan="2" style="vertical-align: top;">
                                        Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                    </th>
                                    <th class="tabela_footer" colspan="" style="vertical-align: top;">
                                        Valor Total Ajustado: <?php echo number_format($totalCartao, 2, ',', '.'); ?>
                                    </th>
                                    <th colspan="3" align="center">
                                        <center>
                                            <div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/impressaoorcamentorecepcao/" . $value->ambulatorio_orcamento_id; ?> ', '_blank', 'width=600,height=600');">Imprimir Or&ccedil;amento</a>
                                            </div>
                                        </center>
                                        <center>
                                            <div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/orcamentorecepcaofila/" . $value->ambulatorio_orcamento_id; ?> ', '_blank', 'width=600,height=600');">Fila de Impressão</a>
                                            </div>
                                        </center>
                                    </th>
                                    <th colspan="3" align="center">
                                        <? if (!$autorizado) { ?>
                                                <center>
                                                    <div class="bt_linkf">
                                                        <a href="<?= base_url() . "ambulatorio/exame/gravarautorizarorcamento/" . $value->ambulatorio_orcamento_id; ?>" target='_blank'>Autorizar Orçamento</a>
                                                    </div>
                                                </center>
                                        <? } ?>
                                        <center>
                                            <div class="bt_linkf">
                                                <a href="<?= base_url() . "ambulatorio/guia/transformaorcamentocredito/" . $value->ambulatorio_orcamento_id; ?>" target='_blank'>Transformar em Crédito</a>
                                            </div>
                                        </center>
                                    </th>
                                </tr>
                            </tfoot>
                            </table> 
                        </fieldset>
                        <?
                    }
                }
            ?>
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
    $(".select-data").show();
    $(".input-data").hide();
    
    $(function () {
        $('#procedimento1').change(function () {
            $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamento', {procedimento1: $("#procedimento1").val(), empresa1: $('#empresa1').val(), ajax: true}, function (j) {
                if(j.length > 0){
//                    alert('teste');
                    var options = '<option value="">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].data != null) {
                            options += '<option value="' + j[c].data + '">' + j[c].data_formatada + '</option>';
                        }
                    }
                    $('select#txtdata').html(options).show();
                    $('.carregando').hide();
                    
                }
            });
        });
    });
    
    $(function () {
        $('#empresa1').change(function () {
            $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamento', {procedimento1: $("#procedimento1").val(), empresa1: $('#empresa1').val(), ajax: true}, function (j) {
                if(j.length > 0){
//                    alert('teste');
                    var options = '<option value="">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].data != null) {
                            options += '<option value="' + j[c].data + '">' + j[c].data_formatada + '</option>';
                        }
                    }
                    $('select#txtdata').html(options).show();
                    $('.carregando').hide();
                    
                }
            });
        });
    });

    $(function () {
        $("input#txtdata").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

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
                                                            
                                                            var procedimento = $(this).val();
                                                            
                                                            $('.carregando').show();
                                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                                options = "";
                                                                options += j[0].valortotal;
                                                                if(j[0].grupo == 'LABORATORIAL'){
                                                                    $(".select-data").hide();
                                                                    $(".input-data").show();
                                                                }
                                                                else{
                                                                    $(".select-data").show();
                                                                    $(".input-data").hide();
                                                                }
<? if ($odontologia_alterar == 't') { ?>
                                                                    if (j[0].grupo == 'ODONTOLOGIA') {
                                                                        $("#valor1").prop('readonly', false);
                                                                    } else {
                                                                        $("#valor1").prop('readonly', true);
                                                                    }
<? } ?>
                                                                document.getElementById("valor1").value = options;
                                                                
                                                                <? if($empresaPermissoes[0]->ajuste_pagamento_procedimento != "t") { ?>
                                                                    if ($('#formapamento').val()) {
                                                                        $.getJSON('<?= base_url() ?>autocomplete/formapagamentoorcamento', {formapamento1: $('#formapamento').val(), ajax: true}, function (j) {
                                                                            var ajuste = (j[0].ajuste == null) ? 0 : j[0].ajuste;

                                                                            var valorajuste1 = parseFloat(($("#valor1").val() * ajuste) / 100) + parseFloat($("#valor1").val());

                                                                            $("#ajustevalor1").val(valorajuste1.toFixed(2));

                                                                            $('.carregando').hide();
                                                                        });
                                                                    }
                                                                <? } ?>

                                                                $('.carregando').hide();
                                                            });
                                                            
                                                            <? if($empresaPermissoes[0]->ajuste_pagamento_procedimento == "t") { ?>
                                                                $("#formapamento").prop('required', false);
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
                                                            <? } ?>
                                                        } else {
                                                            $('#valor1').html('value=""');
                                                        }
                                                    });
                                                });


                                                if ($("#convenio1").val() != "-1") {
                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $("#grupo1").val(), convenio1: $('#convenio1').val()}, function (j) {
                                                        options = '<option value=""></option>';
                                                        for (var c = 0; c < j.length; c++) {
                                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                        }
//                                        $('#procedimento1').html(options).show();
                                                        $('.carregando').hide();
                                                    });
                                                }

                                                <? if($empresaPermissoes[0]->ajuste_pagamento_procedimento != "t") { ?>
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
                                                            } else {
                                                                $("#ajustevalor1").val('');
                                                            }
                                                        });
                                                    });
                                                <? } ?>
                                                
                                                
                                function verificaAjustePagamentoProcedimento(procedimentoConvenioId){
                                    <? if($empresaPermissoes[0]->ajuste_pagamento_procedimento == "t") { ?>
                                        $.getJSON('<?= base_url() ?>autocomplete/verificaAjustePagamentoProcedimento', {procedimento: procedimentoConvenioId, ajax: true}, function (p) {
                                            if (p.length != 0) {
                                                $("#formapamento").prop('required', true);
                                            }
                                        });
                                    <?}?>
                                }
                                
                                function buscaValorAjustePagamentoProcedimento(){                                    
                                    $.getJSON('<?= base_url() ?>autocomplete/buscaValorAjustePagamentoProcedimento', {procedimento: $('#procedimento1').val(), forma: $('#formapamento').val(), ajax: true}, function (p) {
                                        if (p.length != 0) {
                                            $("#ajustevalor1").val(p[0].ajuste);
                                        }
                                        else{
                                            $("#ajustevalor1").val('');
                                        }
                                    });
                                }


</script>
