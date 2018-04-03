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
$desabilitar_trava_retorno = $empresa[0]->desabilitar_trava_retorno;
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
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>cadastros/pacientes/autorizarambulatoriotempgeral/<?= $paciente_id; ?>" method="post">
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
                    <? 
                    if($paciente['0']->nascimento != '') { 
                        $data_atual = date('Y-m-d');
                        $data1 = new DateTime($data_atual);
                        $data2 = new DateTime($paciente[0]->nascimento);

                        $intervalo = $data1->diff($data2);
                        ?>
                        <input type="text" name="idade" id="idade" class="texto02" readonly value="<?= $intervalo->y ?> ano(s)"/>
                    <? } else { ?>
                        <input type="text" name="nascimento" id="txtNascimento" class="texto01" readonly/>
                    <? } ?>
                </div>

                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
            </fieldset>
            <fieldset>
                <legend>Atendimentos anteriores</legend>
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
                    <h6>NENHUM ATENDIMENTO ENCONTRADO</h6>
                    <?
                }
                ?>
            </fieldset>
            <input type="hidden" name="paciente_id" value="<?= $paciente_id; ?>" />

            <fieldset>
                <legend>Autorizar Atendimento</legend>
                <table id="table_justa">
                    <thead>

                        <tr>
                            <th class="tabela_header">Hora</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header">QTDE</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">Sala</th>
                            <th class="tabela_header">Medico</th>
                            <th class="tabela_header">Solicitante</th>
                            
                            <th class="tabela_header">Autorização</th>
                            <th class="tabela_header" <? if(@$empresapermissoes[0]->valor_autorizar == 'f'){?>style="display: none;" <? } ?>>Valor</th>
                            <th class="tabela_header">Sessoes</th>
                            <th class="tabela_header">Pagamento</th>
                            <th class="tabela_header">Promotor</th>
                            <th class="tabela_header">ordenador</th>
                            <th class="tabela_header">Confir.</th>
                            <th class="tabela_header">Descricao</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    $i = 0;
                    foreach ($exames as $item) {
                        $i++;
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        $agenda_exame_id = $item->agenda_exames_id;
                        ?>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->inicio, 0, 5); ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="convenio[<?= $i; ?>]" id="convenio<?= $i; ?>" class="size1"  >
                                        <? foreach ($convenio as $item2) : ?>
                                            <option value="<?= $item2->convenio_id; ?>" <? if ($item2->convenio_id == $item->convenio_agenda) echo'selected'; ?>>
                                                <?= $item2->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="number" name="qtdeProc[<?= $i; ?>]" id="qtdeProc<?= $i; ?>"  value="1"  min="1" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>" >
                                    <select  name="grupo1" id="grupo<?= $i; ?>" class="size1" >
                                        <option value="">Selecione</option>
                                       
                                        <? foreach ($grupos as $item2) :?>
                                            <option value="<?= $item2->nome; ?>" <? if ($item2->nome == $item->grupo) echo "selected=''"; ?>><?= $item2->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" >
                                    <select  name="procedimento[<?= $i; ?>]" id="procedimento<?= $i; ?>" class="size1"  >
                                        <option value="">-- Escolha um procedimento --</option>
                                    </select>
                                </td>
                                
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="sala[<?= $i; ?>]" id="sala<?= $i; ?>" class="size1"  >
                                        <option value="">Selecione</option>
                                        <? foreach ($salas as $itens) : ?>
                                            <option value="<?= $itens->exame_sala_id; ?>" <?if (@$item->agenda_exames_nome_id == @$itens->exame_sala_id) echo "selected"; ?>>
                                                <?= $itens->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="medico_id[<?= $i; ?>]" id="medico_id<?= $i; ?>" class="size1" >
                                        <option value="">Selecione</option>
                                        <? foreach ($medicos as $itens) : ?>
                                            <option value="<?= $itens->operador_id; ?>" <?if (@$item->medico_consulta_id == @$itens->operador_id) echo "selected"; ?>>
                                                <?= $itens->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="medico[<?= $i; ?>]" id="medico<?= $i; ?>" class="size1"/>
                                    <input type="hidden" name="crm[<?= $i; ?>]" id="crm<?= $i; ?>" class="texto01"/></td>
                                
                                 <? // var_dump($item->grupo); die;?>
                                
                                
                                

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="autorizacao[<?= $i; ?>]" id="autorizacao" class="size1"/></td>
                                <td class="<?php echo $estilo_linha; ?>" <?if(@$empresapermissoes[0]->valor_autorizar == 'f'){?>style="display: none;" <?}?>>
                                    <input type="text" name="valor[<?= $i; ?>]" id="valor<?= $i; ?>" class="texto01" readonly=""/>
                                    <input type="hidden" name="valorunitario[<?= $i; ?>]" id="valorunitario<?= $i; ?>" class="texto01" readonly=""/>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="qtde[<?= $i; ?>]" id="qtde<?= $i; ?>"  value="1"  min="1" class="texto01" readonly=""/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="formapamento[<?= $i; ?>]" id="formapamento<?= $i; ?>" class="size1" >
                                        <option value="0">Selecione</option>
                                        <? foreach ($forma_pagamento as $value) : ?>
                                            <option value="<?= $value->forma_pagamento_id; ?>"><?= $value->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select name="indicacao[<?= $i; ?>]" id="indicacao<?= $i; ?>" class="size1 ui-widget" >
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
                                <td class="<?php echo $estilo_linha; ?>" ><input type="checkbox" name="confimado[<?= $i; ?>]" id="checkbox<?= $i; ?>"/> <input type="hidden" name="agenda_exames_id[<?= $i; ?>]" value="<?= $agenda_exame_id; ?>" /></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?= substr(@$item->medico, 0, 12); ?> <br><?= substr(@$item->procedimento, 0, 12); ?></td>
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
<? // echo '<pre>'; var_dump($exames); die;?>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">


    $(document).ready(function () { 

        var convenio_agendado = new Array();
        var proc_agendado = new Array();
        var sala_selecionada = new Array();
        var medico_agenda = new Array();
        var grupo = new Array();

        <? for ($b = 1; $b <= $i; $b++) { 
            $it = ($b == 1) ? '' : $b; ?>

//            $.getJSON('<?= base_url() ?>autocomplete/listargruposala', { sala: $('#sala<?= $b ?>').val() }, function (j) {
//                options = '<option value=""></option>';
//                for (var c = 0; c < j.length; c++) {
//                    options += '<option value="' + j[c].nome + '">' + j[c].nome + '</option>';
//                }
//                $('#grupo<?= $b ?> option').remove();
//                $('#grupo<?= $b ?>').append(options);
//                $("#grupo<?= $b ?>").trigger("chosen:updated");
//                $('.carregando').hide();
//            }); 
        <? if (@$exames[$b - 1]->convenio_agenda != '' && $exames[$b - 1]->procedimento_tuss_id != '') { ?>
            convenio_agendado[<?= $b - 1 ?>] = <?= @$exames[$b - 1]->convenio_agenda ?>;
            proc_agendado[<?= $b - 1 ?>] = <?= @$exames[$b - 1]->procedimento_tuss_id ?>;
            <?
            if(@$exames[$b - 1]->agenda_exames_nome_id != ''){?>
              sala_selecionada[<?= $b - 1 ?>] = <?=@$exames[$b - 1]->agenda_exames_nome_id?>;  
            <?}else{?>
              sala_selecionada[<?= $b - 1 ?>] = ''; 
            <?}
            ?>
            <?
            if(@$exames[$b - 1]->medico_consulta_id != ''){?>
              medico_agenda[<?= $b - 1 ?>] = <?=@$exames[$b - 1]->medico_consulta_id?>;  
            <?}else{?>
              medico_agenda[<?= $b - 1 ?>] = ''; 
            <?}
            ?>
            
            <?
            if(@$exames[$b - 1]->grupo != ''){?>
              grupo[<?= $b - 1 ?>] = '<?=@$exames[$b - 1]->grupo?>';  
            <?}else{?>
              grupo[<?= $b - 1 ?>] = ''; 
            <?}
            ?>
            
            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioatendimento', {convenio1: convenio_agendado[<?= $b - 1 ?>], grupo: grupo[<?= $b - 1 ?>], ajax: true}, function (t) {
//             console.log(t);
                 var opt = '<option value=""></option>';
                 var slt = '';
                 for (var c = 0; c < t.length; c++) {
                     if (proc_agendado[<?= $b - 1 ?>] == t[c].procedimento_convenio_id) {
                         slt = "selected='true'";
                         var procedimento_atual = t[c].procedimento_convenio_id;
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
                         
                        $.getJSON('<?= base_url() ?>autocomplete/listarmedicoprocedimentoconvenio', {procedimento: procedimento_atual, ajax: true}, function (j) {
                            options = '<option value=""></option>';
//                            console.log(j);
                            for (var y = 0; y < j.length; y++) {
                                
                                if(j[y].operador_id == medico_agenda[<?= $b - 1 ?>]){
                                  options += '<option selected="" value="' + j[y].operador_id + '">' + j[y].nome + '</option>';  
                                }else{
                                  options += '<option value="' + j[y].operador_id + '">' + j[y].nome + '</option>';  
                                }
         
                            }
                            $('#medico_id<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                        
                        $.getJSON('<?= base_url() ?>autocomplete/listarsalaporgrupo', {grupo1: a[0].grupo, ajax: true}, function (j) {
                            options = '<option value=""></option>';
                            for (var x = 0; x < j.length; x++) {
                                
                                if(j[x].exame_sala_id == sala_selecionada[<?= $b - 1 ?>]){
                                  options += '<option selected="" value="' + j[x].exame_sala_id + '">' + j[x].nome + '</option>';  
                                }else{
                                  options += '<option value="' + j[x].exame_sala_id + '">' + j[x].nome + '</option>';  
                                }
                    
                            }
                            $('#sala<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
//                         console.log(valor);
                            <?if(@$exames[$b - 1]->valor != ''){ ?>
                              document.getElementById("valorunitario<?= $b ?>").value = <?=@$exames[$b - 1]->valor?>;
                              document.getElementById("valor<?= $b ?>").value = <?=@$exames[$b - 1]->valor?>;
                              document.getElementById("qtde<?= $b ?>").value = <?=@$exames[$b - 1]->quantidade?>;
//                          <? } else { ?>
                              document.getElementById("valorunitario<?= $b ?>").value = valor;
                              document.getElementById("valor<?= $b ?>").value = valor;
                              document.getElementById("qtde<?= $b ?>").value = qtde;  
//                          <? } ?>
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
            
            $('#grupo<?= $b ?>').change(function () {
                if ($('#convenio<?= $b ?>').val()) {
                    if ($(this).val()) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $(this).val(), convenio1: $('#convenio<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                            }
                            $('#procedimento<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                        $.getJSON('<?= base_url() ?>autocomplete/listarsalaporgrupo', {grupo1: $(this).val(), ajax: true}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                            }
                            $('#sala<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                    }
                }
            });
            


            $('#qtdeProc<?= $b ?>').change(function () {
                if ( $(this).val() ) {
                    var valor = $(this).val() * document.getElementById("valorunitario<?= $b ?>").value;
                    if( typeof(valor) == 'number' ){
                        document.getElementById("valor<?= $b ?>").value = valor;
                    }
                }
                else{
                    $(this).val(1);
                }
            });
            
            $('#procedimento<?= $b; ?>').change(function () {
                if ($(this).val()) {
                    <? if($desabilitar_trava_retorno == 'f') { ?>
                        $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimento', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {
    //                          console.log(r);
                            if (r.qtdeConsultas == 0 && r.grupo == "RETORNO") {
                                alert("Erro ao selecionar retorno. Esse paciente não executou o procedimento associado a esse retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
                                $("select[name=procedimento<?= $b; ?>]").val($("select[name=procedimento<?= $b; ?>] option:first-child").val(''));
                            } else if (r.qtdeConsultas > 0 && r.grupo == "RETORNO" && r.retorno_realizado > 0) {
                                alert("Erro ao selecionar retorno. Esse paciente já realizou o retorno associado a esse procedimento no tempo cadastrado");
                                $("select[name=procedimento<?= $b; ?>]").val($("select[name=procedimento<?= $b; ?>] option:first-child").val(''));
                            }
                        });

                        $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimentoinverso', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {

                            if (r.qtdeConsultas > 0 && r.retorno_realizado == 0) {
    //                              alert('asdasd'); 
    //                              alert("Esse paciente executou um procedimento associado a um retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
    //                              alert(r.procedimento_retorno);
                                if('<?=$retorno_alterar?>' == 'f'){
                                    if (confirm("Esse paciente já executou esse procedimento num período de " + r.diasRetorno + " dia(s) e tem direito a um retorno. Deseja atribuí-lo?")) {
    //                                  alert('asdas');
                                          $("#procedimento<?= $b; ?>").val(r.procedimento_retorno);
                                          //                                                            $('#valor1').val('0.00');
                                          $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                              options = "";
                                              options += j[0].valortotal;
                                              document.getElementById("valor<?= $b; ?>").value = options;
                                              $('.carregando').hide();
                                          });
                                      } 
                                    else {

                                  }    
                                } else {
                                    alert("Este paciente tem direito a um retorno associado ao procedimento escolhido");
                                    $("#procedimento<?= $b; ?>").val(r.procedimento_retorno);    
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        document.getElementById("valor<?= $b; ?>").value = options;
                                        $('.carregando').hide();
                                    });
                                }

                            }
                        });
                    <? } ?>
                }
            });

            $('#checkbox<?= $b ?>').change(function () {
                if ($(this).is(":checked")) {
                    $("#medico_id<?= $b; ?>").prop('required', true);
                    $("#sala<?= $b; ?>").prop('required', true);
                    $("#convenio<?= $b; ?>").prop('required', true);
                    $("#qtde<?= $b; ?>").prop('required', true);
                    $("#qtdeProc<?= $b; ?>").prop('required', true);
                    $("#procedimento<?= $b; ?>").prop('required', true);
                    <? if ( $recomendacao_obrigatorio == 't' ){ ?>
                        $("#indicacao<?= $b; ?>").prop('required', true);
                    <? } ?>
                     if ($("#procedimento<?= $b; ?>").val() != '') {
                         
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia<?= $it ?>', {procedimento<?= $b ?>: $("#procedimento<?= $b; ?>").val(), ajax: true}, function (a) {
                            if (a[0].tipo == 'EXAME' || a[0].tipo == 'ESPECIALIDADE' || a[0].tipo == 'FISIOTERAPIA') {
                                $("#medico<?=$b?>").prop('required', true);
                            } else {
                                $("#medico<?=$b?>").prop('required', false);
                            }
                        });
                        
                         <? if($desabilitar_trava_retorno == 'f') { ?>
                              $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimento', {procedimento_id: $("#procedimento<?= $b; ?>").val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {
    //                                    g(r); 
    //                                        d');
                                  if (r.qtdeConsultas == 0 && r.grupo == "RETORNO") {
                                      alert("Erro ao selecionar retorno. Esse paciente não executou o procedimento associado a esse retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
                                      $("select[name=procedimento<?= $b; ?>]").val($("select[name=procedimento<?= $b; ?>] option:first-child").val(''));
                                  } else if (r.qtdeConsultas > 0 && r.grupo == "RETORNO" && r.retorno_realizado > 0) {
                                      alert("Erro ao selecionar retorno. Esse paciente já realizou o retorno associado a esse procedimento no tempo cadastrado");
                                      $("select[name=procedimento<?= $b; ?>]").val($("select[name=procedimento<?= $b; ?>] option:first-child").val(''));
                                  }
                              });

                              $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimentoinverso', {procedimento_id: $("#procedimento<?= $b; ?>").val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {

//                                    g(r);

                              if (r.qtdeConsultas > 0 && r.retorno_realizado == 0) {
//                                    'asdasd'); 
//                                    "Esse paciente executou um procedimento associado a um retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
//                                    r.procedimento_retorno);
                               if('<?=$retorno_alterar?>' == 'f'){
                                   if (confirm("Esse paciente já executou esse procedimento num período de " + r.diasRetorno + " dia(s) e tem direito a um retorno. Deseja atribuí-lo?")) {
//                                               cutou um procedimento associado a um retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");    alert('asdas');
                                         $("#procedimento<?= $b; ?>").val(r.procedimento_retorno);

                                         $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                             options = "";
                                             options += j[0].valortotal;
                                             document.getElementById("valor<?= $b; ?>").value = options;
                                             $('.carregando').hide();
                                         });
                                     } else {

                                     }    
                                   }else{
                                   alert("Este paciente tem direito a um retorno associado ao procedimento escolhido");
                                   $("#procedimento<?= $b; ?>").val(r.procedimento_retorno);    
                                   $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                             options = "";
                                             options += j[0].valortotal;
                                             document.getElementById("valor<?= $b; ?>").value = options;
                                             $('.carregando').hide();
                                         });
                                   }
                              }
                          });
                         <? } ?>
                      }   
                } else {
                    $("#medico_id<?= $b; ?>").prop('required', false);
                    $("#sala<?= $b; ?>").prop('required', false);
                    $("#convenio<?= $b; ?>").prop('required', false);
                    $("#qtde<?= $b; ?>").prop('required', false);
                    $("#qtdeProc<?= $b; ?>").prop('required', false);
                    $("#procedimento<?= $b; ?>").prop('required', false);
                    $("#medico<?=$b?>").prop('required', false);
                    <? if ( $recomendacao_obrigatorio == 't' ){ ?>
                        $("#indicacao<?= $b; ?>").prop('required', false);
                    <? } ?>
                }
            });

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
       
            $('#convenio<?= $b ?>').change(function () {
//                alert('asdads');
                if ($(this).val()) {
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioatendimento', {convenio1: $(this).val(), ajax: true}, function (j) {
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
                     

            $('#procedimento<?= $b ?>').change(function () {
                if ($(this).val()) {
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia', {procedimento1: $(this).val(), ajax: true}, function (j) {
                        options = "";
                        options += j[0].valortotal;
                        qtde = "";
                        if(j[0].qtde == ''){
                           qtde += j[0].qtde; 
                        }else{
                           qtde = 1; 
                        }
                        if ((j[0].tipo == 'EXAME' || j[0].tipo == 'ESPECIALIDADE' || j[0].tipo == 'FISIOTERAPIA') && $('#checkbox<?= $b ?>').is(":checked")) {
                            $("#medico<?=$b?>").prop('required', true);
//                            alert(j[0].tipo);
                        } else {
                            $("#medico<?=$b?>").prop('required', false);
//                            alert(j[0].tipo);
                        }
                        $('#grupo<?= $b ?>').find('option:contains("' + j[0].grupo + '")').prop('selected', true);
                        
                        $.getJSON('<?= base_url() ?>autocomplete/listarsalaporgrupo', {grupo1: j[0].grupo, ajax: true}, function (i) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < i.length; c++) {
                                options += '<option value="' + i[c].exame_sala_id + '">' + i[c].nome + '</option>';
                            }
                            $('#sala<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                        
                        $.getJSON('<?= base_url() ?>autocomplete/listarmedicoprocedimentoconvenio', {procedimento: j[0].procedimento_convenio_id, ajax: true}, function (m) {
                            options = '<option value=""></option>';
//                            console.log(j);
                            for (var y = 0; y < m.length; y++) {
//                                if(m[y].operador_id == medico_agenda[]){
//                                  options += '<option selected="" value="' + m[y].operador_id + '">' + m[y].nome + '</option>';  
//                                }else{
                                  options += '<option value="' + m[y].operador_id + '">' + m[y].nome + '</option>';  
//                                }
                            }
                            $('#medico_id<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                        
                        <? if ($odontologia_alterar == 't') { ?>
                             if(j[0].grupo == 'ODONTOLOGIA'){
                                 $("#valor<?= $b ?>").prop('readonly', false);
                             } else {
                                 $("#valor<?= $b ?>").prop('readonly', true);
                             }    
                        <? } ?>
                        document.getElementById("valorunitario<?= $b ?>").value = options;
                        document.getElementById("valor<?= $b ?>").value = options;
                        document.getElementById("qtde<?= $b ?>").value = qtde;
                        $('.carregando').hide();
                    });
                } else {
                    $('#valor<?= $b ?>').html('value=""');
                }
            });

            $('#procedimento<?= $b ?>').change(function () {
                if ($(this).val()) {
//                                    alert('sadasd');
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
            
            
                   if ($('#convenio<?= $b ?>').val()) {
                    if ($('#grupo<?= $b ?>').val() != grupo[<?= $b - 1 ?>]) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $('#grupo<?= $b ?>').val(), convenio1: $('#convenio<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                            }
                            $('#procedimento<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                        $.getJSON('<?= base_url() ?>autocomplete/listarsalaporgrupo', {grupo1: $('#grupo<?= $b ?>').val(), ajax: true}, function (j) {
//                            alert('asdasdasd');
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                            }
                            $('#sala<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                    }
                }

        <? } ?>

    });
    
    


    $(function () {
        $("#accordion").accordion();
    });

</script>
