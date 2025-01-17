
<style>
    .custom-combobox {
        position: relative;
        display: inline-block;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }
    .custom-combobox-input {
        margin: 0;
        /*padding: 5px 10px;*/
    }
    .custom-combobox a {
        display: inline-block;        
    }
</style>
<script>
    
    $(function () {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);

                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function () {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                
                var wasOpen = false;
//                console.log(value);

                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left input-recomendacao-combobox")
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        })
                        .tooltip({
                            classes: {
                                "ui-tooltip": "ui-state-highlight"
                            }
                        });

                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option.text
                        });
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function () {
                var input = this.input,
                        wasOpen = false;

                input.on("click", function () {
                    input.trigger("focus");

                    // Close if already visible
                    if (wasOpen) {
                        return;
                    }

                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
            },

            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },

            _removeIfInvalid: function (event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                        .val("")
                        .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },

            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });
        <? for($i = 1; $i <= count($exames); $i++) { ?>
            $("#indicacao<?= $i ?>").combobox();
        <? } ?>
    });
</script>
<? 
$recomendacao_obrigatorio = $this->session->userdata('recomendacao_obrigatorio'); 
$empresa = $this->guia->listarempresapermissoes(); 
$odontologia_alterar = $empresa[0]->odontologia_valor_alterar;
$retorno_alterar = $empresa[0]->selecionar_retorno;
$empresa_id = $this->session->userdata('empresa_id');
$empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
//var_dump($retorno_alterar); die;

?>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <!--<div class="clear"></div>-->
    <div class="bt_link_new" style="width: 150pt">
        <a style="width: 150pt" onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
            Novo Medico Solicitante
        </a>
    </div>
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente_id ?>');">
            Nova guia
        </a>
    </div>

    <div>
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>cadastros/pacientes/autorizarambulatoriotempfisioterapia/<?= $paciente_id; ?>" method="post">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <input name="sexo" id="txtSexo" class="size2" 
                           value="<?
                           if ($paciente['0']->sexo == "M"):echo 'Masculino';
                            endif;
                            if ($paciente['0']->sexo == "F"):echo 'Feminino';
                            endif;
                            if ($paciente['0']->sexo == "O"):echo 'Outro';
                            endif;
                           ?>" readonly="true">
                </div>

                <div>
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>

                <div>

                    <label>Idade</label>
                    <input type="text" name="txtIdade" id="txtIdade" class="texto01" readonly/>

                </div>

                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
            </fieldset>
            <fieldset>
                <legend>Especialidades anteriores</legend>
                <?
                if (count($consultasanteriores) > 0) {
                    foreach ($consultasanteriores as $value) {
                        $data_atual = date('Y-m-d');
                        $data1 = new DateTime($data_atual);
                        $data2 = new DateTime($value->data);

                        $intervalo = $data1->diff($data2);
                        ?>
                        <h6><?= $value->procedimento; ?> - DATA: <b><?= substr($value->data, 8, 2) . '/' . substr($value->data, 5, 2) . '/' . substr($value->data, 0, 4); ?> </b> - M&eacute;dico: <b> <?= $value->medico; ?></b> - Convenio:  <?= $value->convenio; ?> - <?= $intervalo->days ?> dia(s)</h6>

                        <?
                    }
                } else {
                    ?>
                    <h6>NENHUMA CONSULTA ENCONTRADA</h6>
                    <?
                }
                ?>
            </fieldset>
            <input type="hidden" name="paciente_id" value="<?= $paciente_id; ?>" />

            <fieldset>
                <legend>Autorizar sess&otilde;es de Especialidade</legend>
                <table id="table_justa">
                    <thead>

                        <tr>
                            <th class="tabela_header">Hora</th>
                            <th class="tabela_header">Sala</th>
                            <th class="tabela_header">Solicitante</th>
                            <th class="tabela_header">Medico</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">autorizacao</th>
                            <th class="tabela_header">V. Unit</th>
                            <th class="tabela_header">Qtde</th>
                            <th class="tabela_header">Pagamento</th>
                            <th class="tabela_header">Promotor</th>
                            <th class="tabela_header">ordenador</th>
                            <th class="tabela_header">Confir.</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    $i = 0;

                    foreach ($exames as $item) {
//                        echo "<pre>";
//                        var_dump($item);die;
                        $i++;
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        $agenda_exame_id = $item->agenda_exames_id;
                        ?>
                        <input type="hidden" name="medico_id[<?= $i; ?>]" value="<?= $item->medico_consulta_id; ?>" />
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->inicio, 0, 5); ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="sala[<?= $i; ?>]" id="sala<?= $i; ?>" class="size1"  >
                                        <option value="">Selecione</option>
                                        <? foreach ($salas as $itens) : ?>
                                            <option value="<?= $itens->exame_sala_id; ?>" <? if (count($salas) == 1) echo 'selected';?>>
                                                <?= $itens->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="medico[<?= $i; ?>]" id="medico<?= $i; ?>" class="size1" />
                                    <input type="hidden" name="crm[<?= $i; ?>]" id="crm<?= $i; ?>" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?= $item->medico; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <?
//                                    echo "<pre>";
//                                    var_dump($convenio);
//                                    die;
                                    ?>
                                    <select  name="convenio[<?= $i; ?>]" id="convenio<?= $i; ?>" class="size1"  >
                                        <option value="">Selecione</option>
                                        <? foreach ($convenio as $item2) : ?>
                                            <option value="<?= $item2->convenio_id; ?>" <? if ($item2->convenio_id == $item->convenio_agenda) echo'selected'; ?>>
                                                <?= $item2->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                
                                <td class="<?php echo $estilo_linha; ?>" >
                                    <select  name="grupo1" id="grupo<?= $i; ?>" class="size1" >
                                        <option value="">Selecione</option>
                                        <?foreach ($grupos as $item2) :?>
                                            <option value="<?= $item2->nome; ?>" <?if ($item2->nome == $item->grupo) echo "selected"; ?>><?= $item2->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="procedimento[<?= $i; ?>]" id="procedimento<?= $i; ?>" class="size1">
                                        <option value="">-- Escolha um procedimento --</option>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="autorizacao[<?= $i; ?>]" id="autorizacao" class="size1"/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="valor[<?= $i; ?>]" id="valor<?= $i; ?>" class="texto01" readonly=""/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="qtde[<?= $i; ?>]" id="qtde<?= $i; ?>" class="texto01" readonly=""/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="formapamento[<?= $i; ?>]" id="formapamento<?= $i; ?>" class="size1" >
                                        <option value="0">Selecione</option>
                                        <? foreach ($forma_pagamento as $item) : ?>
                                            <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select name="indicacao[<?= $i; ?>]" id="indicacao<?= $i ?>" class="size1 ui-widget" >
                                        <option value='' >Selecione</option>
                                        <?php
                                        $indicacao = $this->paciente->listaindicacao($_GET);
                                        foreach ($indicacao as $item) {
                                            ?>
                                            <option value="<?php echo $item->paciente_indicacao_id; ?>"> <?php echo $item->nome . ( ($item->registro != '' ) ? " - " . $item->registro : '' ); ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <select name="ordenador" id="ordenador" class="size1" >
                                        <option value='1' >Normal</option>
                                        <option value='2' >Prioridade</option>
                                        <option value='3' >Urgência</option>

                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" ><input type="checkbox" name="confimado[<?= $i; ?>]" id="checkbox<?= $i; ?>" /><input type="hidden" name="agenda_exames_id[<?= $i; ?>]" value="<?= $agenda_exame_id; ?>" /></td>

                            </tr>

                        </tbody>
                        <?
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="4">
                            </th>
                        </tr>
                    </tfoot>
                </table> 
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </fieldset>
        </form>
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">



                        $(document).ready(function () {
                            var convenio_agendado = new Array();
                            var proc_agendado = new Array();

<? for ($b = 1; $b <= $i; $b++) { ?>
    <? $it = ($b == 1) ? '' : $b; ?>
    <? if (@$exames[$b - 1]->convenio_agenda != '' && $exames[$b - 1]->procedimento_tuss_id != '') { ?>
                                
                                convenio_agendado[<?= $b - 1 ?>] = <?= @$exames[$b - 1]->convenio_agenda ?>;
                                proc_agendado[<?= $b - 1 ?>] = <?= @$exames[$b - 1]->procedimento_tuss_id ?>;
//        alert(proc_agendado[<?= $b - 1 ?>]);
//                                    var convenio_agendado = <?= @$exames[$b - 1]->convenio_agenda ?>;
//                                    var proc_agendado = <?= @$exames[$b - 1]->procedimento_tuss_id ?>;

                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniofisioterapia', {convenio1: convenio_agendado[<?= $b - 1 ?>], ajax: true}, function (t) {
                                            console.log(t);
                                                var opt = '<option value=""></option>';
                                                var slt = '';
                                                for (var c = 0; c < t.length; c++) {
                                                    if (proc_agendado[<?= $b - 1 ?>] == t[c].procedimento_convenio_id) {
                                                        slt = "selected='true'";
                                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia<?= $it ?>', {procedimento<?= $b ?>: t[c].procedimento_convenio_id, ajax: true}, function (a) {
                                                            var valor = a[0].valortotal;
                                                            var qtde = a[0].qtde;
                                                        <?if($odontologia_alterar == 't'){?>
                                                        if(a[0].grupo == 'ODONTOLOGIA'){
                                                            $("#valor<?=$b?>").prop('readonly', false);
                                                        }else{
                                                            $("#valor<?=$b?>").prop('readonly', true);
                                                        }    
                                                        <?}?>
//                                                        console.log(valor);
                                                            document.getElementById("valor<?=$b?>").value = valor;
                                                            document.getElementById("qtde<?=$b?>").value = qtde;
                                                            $('.carregando').hide();
                                                        });
                                                        
                                                        $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento<?= $b ?>', {procedimento<?= $b ?>: t[c].procedimento_convenio_id, ajax: true}, function (j) {
                                                            var options = '<option value="0">Selecione</option>';
                                                            for (var c = 0; c < j.length; c++) {
                                                                if (j[c].forma_pagamento_id != null) {
                                                                    options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                }
                                                            }
                                                            $('#formapamento<?= $b ?>').html(options).show();
                                                            $('.carregando').hide();
                                                        });
                                                                            
                                                    }
                                                    opt += '<option value="' + t[c].procedimento_convenio_id + '"' + slt + '>' + t[c].procedimento + '</option>';
                                                    slt = '';
                                                }
                                                $('#procedimento<?= $b ?>').html(opt).show();
                                                $('.carregando').hide();
                                    });
    <? }
    ?>
                                                            $('#checkbox<?= $b ?>').change(function () {
                                                                if ($(this).is(":checked")) {
                                                                    $("#medico<?= $b; ?>").prop('required', true);
                                                                    $("#sala<?= $b; ?>").prop('required', true);
                                                                    $("#convenio<?= $b; ?>").prop('required', true);
                                                                    $("#procedimento<?= $b; ?>").prop('required', true);
                                                                    
                                                                    <? if ( $recomendacao_obrigatorio == 't' ){ ?>
                                                                        $("#indicacao<?= $b; ?>").prop('required', true);
                                                                    <? } ?>
                                                                } else {
                                                                    $("#medico<?= $b; ?>").prop('required', false);
                                                                    $("#sala<?= $b; ?>").prop('required', false);
                                                                    $("#convenio<?= $b; ?>").prop('required', false);
                                                                    $("#procedimento<?= $b; ?>").prop('required', false);
                                                                    
                                                                    <? if ( $recomendacao_obrigatorio == 't' ){ ?>
                                                                        $("#indicacao<?= $b; ?>").prop('required', false);
                                                                    <? } ?>
                                                                }
                                                            });
                                                            
                                                            //         $(function () {
             $('#convenio<?= $b; ?>').change(function () {
//                 alert('asdasd');
                 if ($(this).val()) {
//                     $('.carregando').show();
                     $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $(this).val()}, function (j) {
                         options = '<option value=""></option>';
                         <? if (@$empresapermissoes[0]->valor_convenio_nao == 't') { ?>
                          if (j[0].dinheiro == 't') {
//                             $("#valor<?= $b; ?>").show();
//                           $("#valortd<?= $b; ?>").show();
                              $("#valor<?= $b; ?>").attr("type", "text");
                          } else {
                              $("#valor<?= $b; ?>").attr("type", "hidden");
//                             $("#valor<?= $b; ?>").hide();
//                       $("#valortd<?= $b; ?>").hide();
                          }
                          <?}?>
                         if (j[0].carteira_obrigatoria == 't') {
                             $("#autorizacao<?= $b; ?>").prop('required', true);
                         } else {
                             $("#autorizacao<?= $b; ?>").prop('required', false);
                         }

                     });
                 }
             });
//         });
         
         if ($('#convenio<?= $b; ?>').val()) {
//             $('.carregando').show();
             $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $('#convenio<?= $b; ?>').val()}, function (j) {
                 options = '<option value=""></option>';
                 <? if (@$empresapermissoes[0]->valor_convenio_nao == 't') { ?>
                         if (j[0].dinheiro == 't') {
//                             $("#valor<?= $b; ?>").show();
//                             $("#valortd<?= $b; ?>").show();
                              $("#valor<?= $b; ?>").attr("type", "text");
                          } else {
                              $("#valor<?= $b; ?>").attr("type", "hidden");
//                             $("#valor<?= $b; ?>").hide();
//                             $("#valortd<?= $b; ?>").hide();
                         }
                 <?}?>
                 if (j[0].carteira_obrigatoria == 't') {
                     $("#autorizacao<?= $b; ?>").prop('required', true);
                 } else {
                     $("#autorizacao<?= $b; ?>").prop('required', false);
                 }

             });
         } 

<? }
?>

                                                    });
                                    
<? for ($b = 1; $b <= $i; $b++) { ?>
                                    $('#grupo<?= $b ?>').change(function () {
                                        if ($('#convenio<?= $b ?>').val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $(this).val(), convenio1: $('#convenio<?= $b ?>').val()}, function (j) {
                                                options = '<option value=""></option>';
                                                for (var c = 0; c < j.length; c++) {
                                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                }
                                                $('#procedimento<?= $b ?>').html(options).show();
                                                $('.carregando').hide();
                                            });
                                        }
                                    });
                                    
                                    
                                    

                                                        $(function () {
                                                            $('#convenio<?= $b ?>').change(function () {
                                                                if ($(this).val()) {
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniofisioterapia', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                                        var options = '<option value=""></option>';
                                                                        for (var c = 0; c < j.length; c++) {
                                                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                                                        }
                                                                        $('#procedimento<?= $b ?>').html(options).show();
                                                                        $('.carregando').hide();
                                                                    });
                                                                } else {
                                                                    $('#procedimento<?= $b ?>').html('<option value="">-- Escolha um exame --</option>');
                                                                }
                                                            });
                                                        });

                                                        $(function () {
                                                            $('#procedimento<?= $b ?>').change(function () {
                                                                if ($(this).val()) {
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                                        options = "";
                                                                        options += j[0].valortotal;
                                                                        qtde = "";
                                                                        qtde += j[0].qtde;
                                                                         <?if($odontologia_alterar == 't'){?>
                                                                            if(j[0].grupo == 'ODONTOLOGIA'){
                                                                                $("#valor<?= $b ?>").prop('readonly', false);
                                                                            }else{
                                                                                $("#valor<?= $b ?>").prop('readonly', true);
                                                                            }    
                                                                         <?}?>  
                                                                        document.getElementById("valor<?= $b ?>").value = options;
                                                                        document.getElementById("qtde<?= $b ?>").value = qtde;
                                                                        $('.carregando').hide();
                                                                    });
                                                                } else {
                                                                    $('#valor<?= $b ?>').html('value=""');
                                                                }
                                                            });
                                                        });

                                                        $(function () {
                                                            $('#procedimento<?= $b ?>').change(function () {
                                                                if ($(this).val()) {
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                                        var options = '<option value="0">Selecione</option>';
                                                                        for (var c = 0; c < j.length; c++) {
                                                                            if (j[c].forma_pagamento_id != null) {
                                                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                            }
                                                                        }
                                                                        $('#formapamento<?= $b ?>').html(options).show();
                                                                        $('.carregando').hide();
                                                                    });
                                                                } else {
                                                                    $('#formapamento<?= $b ?>').html('<option value="0">Selecione</option>');
                                                                }
                                                            });
                                                        });

                                                        $(function () {
                                                            $("#medico<?= $b ?>").autocomplete({
                                                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                                                minLength: 3,
                                                                focus: function (event, ui) {
                                                                    $("#medico<?= $b ?>").val(ui.item.label);
                                                                    return false;
                                                                },
                                                                select: function (event, ui) {
                                                                    $("#medico<?= $b ?>").val(ui.item.value);
                                                                    $("#crm<?= $b ?>").val(ui.item.id);
                                                                    return false;
                                                                }
                                                            });
                                                        });

<? }
?>




//                        $(function () {
//                            $('#convenio2').change(function () {
//                                if ($(this).val()) {
//                                    $('.carregando').show();
//                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniofisioterapia2', {convenio2: $(this).val(), ajax: true}, function (j) {
//                                        var options = '<option value=""></option>';
//                                        for (var c = 0; c < j.length; c++) {
//                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
//                                        }
//                                        $('#procedimento2').html(options).show();
//                                        $('.carregando').hide();
//                                    });
//                                } else {
//                                    $('#procedimento2').html('<option value="">-- Escolha um exame --</option>');
//                                }
//                            });
//                        });



                                                    //$(function(){     
                                                    //    $('#exame').change(function(){
                                                    //        exame = $(this).val();
                                                    //        if ( exame === '')
                                                    //            return false;
                                                    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
                                                    //            var option = new Array();
                                                    //            $.each(data, function(i, obj){
                                                    //                console.log(obl);
                                                    //                option[i] = document.createElement('option');
                                                    //                $( option[i] ).attr( {value : obj.id} );
                                                    //                $( option[i] ).append( obj.nome );
                                                    //                $("select[name='horarios']").append( option[i] );
                                                    //            });
                                                    //        });
                                                    //    });
                                                    //});





                                                    $(function () {
                                                        $("#accordion").accordion();
                                                    });


                                                    $(document).ready(function () {
                                                        jQuery('#form_exametemp').validate({
                                                            rules: {
                                                                txtNome: {
                                                                    required: true,
                                                                    minlength: 3
                                                                },
                                                                nascimento: {
                                                                    required: true
                                                                },
                                                                idade: {
                                                                    required: true
                                                                }
                                                            },
                                                            messages: {
                                                                txtNome: {
                                                                    required: "*",
                                                                    minlength: "!"
                                                                },
                                                                nascimento: {
                                                                    required: "*"
                                                                },
                                                                idade: {
                                                                    required: "*"
                                                                }
                                                            }
                                                        });
                                                    });

//                                                    function calculoIdade() {
//                                                        var data = document.getElementById("txtNascimento").value;
//                                                        var ano = data.substring(6, 12);
//                                                        var idade = new Date().getFullYear() - ano;
//                                                        document.getElementById("txtIdade").value = idade;
//                                                    }

                                                    function calculoIdade() {
                                                        var data = document.getElementById("txtNascimento").value;

                                                        if (data != '' && data != '//') {

                                                            var ano = data.substring(6, 12);
                                                            var idade = new Date().getFullYear() - ano;

                                                            var dtAtual = new Date();
                                                            var aniversario = new Date(dtAtual.getFullYear(), parseInt(data.substring(3, 5)) - 1, data.substring(0, 2));

                                                            if (dtAtual < aniversario) {
                                                                idade--;
                                                            }

                                                            document.getElementById("txtIdade").value = idade + " ano(s)";
                                                        }
                                                    }
                                                    calculoIdade();

</script>