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
        padding: 5px 10px;
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

                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left text-input-recomendacao")
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
                            item: ui.item.option
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

        $("#indicacao").combobox();
    });
</script>
<?
$recomendacao_obrigatorio = $this->session->userdata('recomendacao_obrigatorio');
$empresa = $this->guia->listarempresapermissoes();
$odontologia_alterar = $empresa[0]->odontologia_valor_alterar;
$retorno_alterar = $empresa[0]->selecionar_retorno;
//var_dump($retorno_alterar); die;
?>
<div class="content ficha_ceatox">
    <!--    <div class="bt_link_new" style="width: 150pt">
            <a style="width: 150pt" onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
                Novo Medico Solicitante
            </a>
        </div>-->
    <div class="bt_link_new">
        <a href="<?= base_url() ?>cadastros/pacientes">
            Cadastros
        </a>
    </div>
    <div >
        <?
        $perfil_id = $this->session->userdata('perfil_id');

        $botao_faturar_guia = $this->session->userdata('botao_faturar_guia');
        $botao_faturar_proc = $this->session->userdata('botao_faturar_proc');
        $empresa_id = $this->session->userdata('empresa_id');
        $empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);

        $sala = "";
        $ordenador1 = "";
        $sala_id = "";
        $medico_id = "";
        $medico = "";
        $medico_solicitante = "";
        $medico_solicitante_id = "";
        $convenio_paciente = "";
        $promotor_id = @$exames[count($exames) - 1]->indicacao;
//        var_dump($contador);die;
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

        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentosconsulta" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                        <input type="hidden" id="guia_id" name="guia_id"  value="<?= $ambulatorio_guia_id; ?>"/>
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
                        if ($paciente['0']->nascimento != '') {
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


                        <input type="text" name="nome_mae" id="txtNomeMae" class="texto09" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Consultas anteriores</legend>
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

                <fieldset>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th width="70px;" class="tabela_header">Sala*</th>
                                <th class="tabela_header">Medico*</th>
                                <th class="tabela_header">Qtde*</th>
                                <th class="tabela_header">Convenio*</th>
                                <th class="tabela_header">Procedimento*</th>
                                <th class="tabela_header">Autorizacao</th>
                                <th id="valorth" class="tabela_header">V. Unit</th>
                                <th class="tabela_header" id="vAjuste" style="display: none;"><span >V.Ajuste</span></th>
                                <th class="tabela_header">Pagamento</th>
                                <th class="tabela_header">Promotor</th>
                                <th class="tabela_header">Ordenador</th>
<!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td > 
                                    <select  name="sala1" id="sala1" class="size1" required="" >
                                        <option value="">Selecione</option>
                                        <? foreach ($salas as $item) : ?>
                                            <option value="<?= $item->exame_sala_id; ?>"<? if ($sala == $item->nome || count($salas) == 1) echo 'selected'; ?>>
                                                <?= $item->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select></td>
                                <td > 
                                    <select  name="medicoagenda" id="medicoagenda" class="size1" required="" >
                                        <option value="">Selecione</option>
                                        <? foreach ($medicos as $item) : ?>
                                            <option value="<?= $item->operador_id; ?>"<?
                                            if ($medico == $item->nome):echo 'selected';
                                            endif;
                                            ?>><?= $item->nome; ?></option>
                                                <? endforeach; ?>
                                    </select></td>
                                <td  ><input type="text" name="qtde1" id="qtde1" value="1" class="texto00" required=""/></td>
                                <td  >
                                    <select  name="convenio1" id="convenio1" class="size1" required="" >
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

                                <td  >
<!--                                    <select  name="procedimento1" id="procedimento1" class="size1" required="" >
                                        <option value="">Selecione</option>
                                    </select>-->
                                    <select name="procedimento1" id="procedimento1" required class="size4" data-placeholder="Selecione" tabindex="1">
                                        <option value="">Selecione</option>
                                    </select>
                                </td>

                                <td  ><input type="text" name="autorizacao1" id="autorizacao" class="size1"/></td>
                                <td id="valortd">
                                    <input type="text" name="valor1" id="valor1" class="texto01" readonly=""/>
                                </td>
                                <td id="vAjusteIn" style="display: none;"  >
                                    <input type="text" name="valorAjuste" id="valorAjuste" class="texto01" readonly=""/>
                                </td>
                                <td >
                                    <select  name="formapamento" id="formapamento" class="size1" onchange="buscaValorAjustePagamentoProcedimento()">
                                        <option value="">Selecione</option>
                                        <?
                                        foreach ($forma_pagamento as $item) :
                                            if ($item->forma_pagamento_id == 1000)
                                                continue;
                                            ?>
                                            <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td  width="50px;">
                                    <select name="indicacao" id="indicacao" class="size1 ui-widget" <?= $recomendacao_obrigatorio == 't' ? 'required' : '' ?>>
                                        <option value='' >Selecione</option>
                                        <?php
                                        $indicacao = $this->paciente->listaindicacao($_GET);
                                        foreach ($indicacao as $item) {
                                            ?>
                                            <option value="<?= $item->paciente_indicacao_id; ?>" <?= ($item->paciente_indicacao_id == $promotor_id) ? 'selected' : '' ?>><?php echo $item->nome . ( ($item->registro != '' ) ? " - " . $item->registro : '' ); ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </td>
                                <td  width="70px;">
                                    <select name="ordenador" id="ordenador" class="size1" >
                                        <option value='1' >Normal</option>
                                        <option value='2' >Prioridade</option>
                                        <option value='3' >Urgência</option>

                                    </select>
                                </td>
                                <!--<td  ><input type="text" name="ordenador" id="ordenador" value="<?= $ordenador1; ?>" class="texto01"/></td>-->
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
                    <button type="submit" name="btnEnviar" id="submitButton">Adicionar</button>
                </fieldset>
            </form>
            <fieldset>
                <?
                if ($contador > 0) {
                    if (count($exames_lista) > 0) {
                        ?>
                        <table id="table_agente_toxico" border="0">
                            <thead>
                                <tr>
                                    <th class="tabela_header">Data</th>
                                    <th class="tabela_header">Hora</th>
                                    <th class="tabela_header">Sala</th>
                                    <th class="tabela_header">Valor</th>
                                    <th class="tabela_header">Convenio</th>
                                    <th class="tabela_header">Procedimento</th>
                                    <th class="tabela_header" colspan="2">Descricao</th>
                                    <th colspan="4" class="tabela_header">&nbsp;</th>
                                </tr>
                            </thead>
                            <?
                            $total = 0;
                            $guia = 0;
                            $faturado = 0;
                            foreach ($exames_lista as $item) {

                                $estilo_linha = "tabela_content01";
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
                                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/vizualizarpreparoconvenio/" . $item->convenio_id; ?> ', '_blank', 'width=900,height=400');"><?= $item->convenio; ?></a></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>" colspan="2"><?= $item->descricao_procedimento; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <? if (@$item->valor_diferenciado != 't') { ?>
                                                <? if (@$empresapermissoes->gerente_cancelar == 't' || $perfil_id == 1) { ?>
                                                    <div class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/guiacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');">Cancelar</a>
                                                    </div>
                                                <? } ?>
                                            <? } ?>
                                            <div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoficha/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha</a>
                                            </div>
                                            <!--                                        </td>
                                                                                    <td class="<?php echo $estilo_linha; ?>" width="60px;">-->
                                            <? if ($empresapermissoes[0]->botao_ficha_convenio = 't') { ?>
                                                <div class="bt_link ">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaofichaconvenio/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha-Convenio
                                                    </a></div>
                                            <? } ?>    

                                            <!--</td>-->
                                            <?
                                            if ($item->faturado == "f" && $item->dinheiro == "t") {
                                                if ($empresapermissoes[0]->ajuste_pagamento_procedimento != 't') {
                                                    ?>
                                                    <?if($empresapermissoes[0]->faturamento_novo == 't'){?>                                              <!--<td class="<?php echo $estilo_linha; ?>" width="60px;">-->
                                                
                                                        <div class="bt_link">
                                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarmodelo2/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id; ?>', '_blank', 'width=1000,height=800');">Faturar

                                                            </a>
                                                        </div>
                                                        <!--</td>-->
                                                    <?}else{?>
                                                        <div class="bt_link">
                                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturar/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?> ', '_blank', 'width=800,height=600');">Faturar

                                                            </a>
                                                        </div>
                                                    <?}?> 
                                                <? } else {
                                                    ?>

                                                    <div class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarpersonalizado/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?> ', '_blank', 'width=800,height=600');">Faturar</a>
                                                    </div>
                                                    <?
                                                }
                                            } else {
                                                $faturado++;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <?
                            }
                            ?>


                            <tfoot>
                                <tr>
                                    <th class="tabela_footer" colspan="4">
                                        Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                    </th>

                                    <? if ($perfil_id != 11) { ?>

                                        <?
                                        if ($perfil_id == 1 || $faturado == 0) {
                                            if ($botao_faturar_guia == 't') {
                                                ?>
                                                <th colspan="2" align="center"><center><div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarguia/" . $guia; ?> ', '_blank', 'width=800,height=600');">Faturar Guia

                                                </a></div></center>
                                        </th>
                                        <?
                                    }
                                    if ($botao_faturar_proc == 't') {
                                        if (@$empresapermissoes[0]->listarempresapermissoes != 't') {
                                            ?>  
                                            <th colspan="2" align="center">    
                                                <div class="bt_linkf">
                                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarprocedimentos/" . $guia; ?> ', '_blank', 'width=800,height=600');">Faturar Procedimentos

                                                    </a></div></center>
                                            </th>
                                            <?
                                        } else {
                                            ?>
                                            <th colspan="2" align="center">    
                                                <div class="bt_linkf">
                                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarprocedimentospersonalizados/" . $guia; ?> ', '_blank', 'width=800,height=600');">Faturar Procedimentos

                                                    </a></div>
                                            </th>
                                            <?
                                        }
                                    }
                                }
                            }
                            ?>
                            </tr>
                            </tfoot>
                        </table> 
                        <br/>
                        <?
                    }
                    if (count($exames_particular) > 0) {
                        ?>
                        <table id="table_agente_toxico" border="0">
                            <thead>
                                <tr>
                                    <th class="tabela_header">Data</th>
                                    <th class="tabela_header">Hora</th>
                                    <th class="tabela_header">Sala</th>
                                    <th class="tabela_header">Valor</th>
                                    <th class="tabela_header">Convenio</th>
                                    <th class="tabela_header">Procedimento</th>
                                    <th class="tabela_header" colspan="2">Descricao</th>
                                    <th colspan="4" class="tabela_header">&nbsp;</th>
                                </tr>
                            </thead>
                            <?
                            $total = 0;
                            $guia = 0;
                            $faturado = 0;
                            foreach ($exames_particular as $item) {

                                $estilo_linha = "tabela_content01";
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
                                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/vizualizarpreparoconvenio/" . $item->convenio_id; ?> ', '_blank', 'width=900,height=400');"><?= $item->convenio; ?></a></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>" colspan="2"><?= $item->descricao_procedimento; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoficha/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha</a>
                                            </div>
                                            <!--                                        </td>
                                                                                    <td class="<?php echo $estilo_linha; ?>" width="60px;">-->
                                            <? if ($empresapermissoes[0]->botao_ficha_convenio == 't') { ?>
                                                <div class="bt_link ">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaofichaconvenio/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha-Convenio</a></div>
                                            <? } ?>  
                                            <!--</td>-->
                                            <?
                                            if ($item->faturado == "f" && $item->dinheiro == "t") {
                                                if (@$item->valor_diferenciado != 't') {
                                                    if ($empresapermissoes[0]->ajuste_pagamento_procedimento != 't') {
                                                        ?> 
                                                        <?if($empresapermissoes[0]->faturamento_novo == 't'){?>                                              <!--<td class="<?php echo $estilo_linha; ?>" width="60px;">-->
                                                
                                                            <div class="bt_link">
                                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarmodelo2/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id; ?>', '_blank', 'width=1000,height=800');">Faturar

                                                                </a>
                                                            </div>
                                                            <!--</td>-->
                                                        <?}else{?>
                                                            <div class="bt_link">
                                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturar/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?> ', '_blank', 'width=800,height=600');">Faturar

                                                                </a>
                                                            </div>
                                                        <?}?>                  
                                                    <? } else { ?>
                                                        <div class="bt_link">
                                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarpersonalizado/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?> ', '_blank', 'width=800,height=600');">Faturar</a>
                                                        </div>
                                                    <? } ?>
                                                    <? if (@$empresapermissoes->gerente_cancelar == 't' || $perfil_id == 1) { ?>
                                                        <div class="bt_link">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/guiacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');">Cancelar</a>
                                                        </div>
                                                    <? } ?>
                                                    <?
                                                } else {
                                                    $faturado++;
                                                }
                                                ?>

                                            <? } ?>  
                                        </td>
                                    </tr>
                                </tbody>
                                <?
                            }
                            ?>


                            <tfoot>
                                <tr>
                                    <th class="tabela_footer" colspan="4">
                                        Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                    </th>

                                    <? if ($perfil_id != 11) { ?>

                                        <?
                                        if ($perfil_id == 1 || $faturado == 0) {
                                            if ($botao_faturar_guia == 't') {
                                                ?>
                                                <th colspan="2" align="center"><center><div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarguia/" . $guia; ?> ', '_blank', 'width=800,height=600');">Faturar Guia

                                                </a></div></center>
                                        </th>
                                        <?
                                    }
                                    if ($botao_faturar_proc == 't') {
                                        if ($empresapermissoes[0]->ajuste_pagamento_procedimento == 't') {
                                            ?>
                                            <th colspan="2" align="center">  
                                                <div class="bt_link">
                                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarprocedimentospersonalizados/" . $guia; ?> ', '_blank', 'width=800,height=600');">Faturar Procedimentos</a>
                                                </div>
                                            </th> 
                                            <?
                                        } else {
                                            ?>
                                            <th colspan="2" align="center">
                                            <?if($empresapermissoes[0]->faturamento_novo == 't'){?>                                              <!--<td class="<?php echo $estilo_linha; ?>" width="60px;">-->
                                                <div class="bt_linkf">
                                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarprocedimentosmodelo2/" . $guia; ?> ', '_blank', 'width=1000,height=800');">Faturar Procedimentos

                                                    </a>
                                                </div>
                                            <?}else{?>
                                                <div class="bt_linkf">
                                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarprocedimentos/" . $guia; ?> ', '_blank', 'width=800,height=600');">Faturar Procedimentos

                                                    </a>
                                                </div>        
                                            <?}?> 
                                            </th>
                                            <?
                                        }
                                    }
                                }
                            }
                            ?>
                            </tr>
                            </tfoot>
                        </table> 
                        <br/>
                        <?
                    }
                }
                ?>

            </fieldset>
            <? if (count(@$exames_pacote) > 0) { ?>
                <fieldset>
                    <legend>Pacotes Lançados</legend>
                    <table id="table_agente_toxico" border="0">
                        <thead>
                            <tr>
                                <th class="tabela_header">Data</th>
                                <th class="tabela_header">Hora</th>
                                <th class="tabela_header">Sala</th>
                                <th class="tabela_header">Valor</th>
                                <th class="tabela_header">Procedimento</th>
                                <!--<th class="tabela_header" colspan="2">Descricao</th>-->
                                <th class="tabela_header" colspan="2">Pacote</th>
                                <th colspan="4" class="tabela_header">&nbsp;</th>
                            </tr>
                        </thead>

                        <?
                        $total = 0;
                        $guia = 0;
                        $faturado = 0;
                        foreach ($exames_pacote as $item) {
                            $estilo_linha = "tabela_content01";
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
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                    <!--<td class="<?php echo $estilo_linha; ?>" colspan="2"><?= $item->descricao_procedimento; ?></td>-->
                                    <td class="<?php echo $estilo_linha; ?>" colspan="2">
                                        <?= $item->pacote_nome; ?><?= (@$item->valor_diferenciado == 't') ? " **" : ""; ?>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                        <? if (@$empresapermissoes->gerente_cancelar == 't' || $perfil_id == 1) { ?>
                                            <div class="bt_link_new">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/atendimentocancelamentopacote/<?= $guia ?>/<?= $item->paciente_id ?>/<?= $item->agrupador_pacote_id ?>');">Cancelar Pacote

                                                </a>
                                            </div>
                                        <? } ?>
                                        <!--                                        <div class="bt_link_new">
                                                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoficha/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha
                                                                                    </a></div>
                                                                            </td>
                                                                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link_new">
                                                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaofichaconvenio/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha-convenio
                                                                                    </a></div>-->
                                        <!--</td>-->
                                        <? if ($item->faturado == "f" && $item->dinheiro == "t") { ?>
                                            <?
                                            if ($perfil_id != 11) {
                                                if ($empresapermissoes[0]->ajuste_pagamento_procedimento != 't') {
                                                    ?>
                                                    <?if($empresapermissoes[0]->faturamento_novo == 't'){?>                                              <!--<td class="<?php echo $estilo_linha; ?>" width="60px;">-->
                                                
                                                        <div class="bt_link">
                                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarmodelo2/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id; ?>', '_blank', 'width=1000,height=800');">Faturar

                                                            </a>
                                                        </div>
                                                        <!--</td>-->
                                                    <?}else{?>
                                                        <div class="bt_link">
                                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturar/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?> ', '_blank', 'width=800,height=600');">Faturar

                                                            </a>
                                                        </div>
                                                    <?}?> 
                                                <? } else {
                                                    ?>

                                                    <div class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarpersonalizado/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?> ', '_blank', 'width=800,height=600');">Faturar</a>
                                                    </div>
                                                    <?
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?
                        }
                        ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="4">
                                    Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                </th>
                                <th class="tabela_footer" colspan="5">** = Valor diferenciado</th>
                                <!--    <? if ($perfil_id != 11) { ?>
                                                    
                                    <?
                                    if ($perfil_id == 1 || $faturado == 0) {
                                        if ($botao_faturar_guia == 't') {
                                            ?>
                                                                                                                                        <th colspan="2" align="center"><center><div class="bt_linkf">
                                                                                                                                        <a onclick="javascript:window.open('////<?= base_url() . "ambulatorio/guia/faturarguia/" . $guia . '/' . $item->grupo_pagamento_id; ?>  ', '_blank', 'width=800,height=600');">Faturar Guia
                                                                                            
                                                                                                                                        </a></div></center></th>
                                            <?
                                        }
                                        if ($botao_faturar_proc == 't') {
                                            ?>
                                                                                                                                <th colspan="2" align="center">    
                                                                                                                                    <div class="bt_linkf">
                                                                                                                                        <a onclick="javascript:window.open('////<?= base_url() . "ambulatorio/guia/faturarprocedimentos/" . $guia; ?> ', '_blank', 'width=800,height=600');">Faturar Procedimentos
                                                                                            
                                                                                                                                        </a></div></center>
                                                                                                                                </th>
                                            <?
                                        }
                                    }
                                }
                                ?>-->
                            </tr>
                        </tfoot>
                    </table> 
                </fieldset>
            <? } ?>
        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>

<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 130px; }
</style>

<script type="text/javascript">
                                                            // Fazendo com que ao clicar no botão de submit, este passe a ficar desabilitado
                                                            var formID = document.getElementById("form_guia");
                                                            var send = $("#submitButton");
                                                            $(formID).submit(function (event) {
                                                                if (formID.checkValidity()) {
                                                                    send.attr('disabled', 'disabled');
                                                                }
                                                            });

                                                            if ($("#convenio1").val() != "-1") {
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioconsulta', {convenio1: $("#convenio1").val()}, function (j) {
                                                                    options = '<option value="">Selecione</option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                                                    }
//                                                $('#procedimento1').html(options).show();
                                                                    $('#procedimento1 option').remove();
                                                                    $('#procedimento1').append(options);
                                                                    $("#procedimento1").trigger("chosen:updated");
                                                                    $('.carregando').hide();
                                                                });
                                                            }


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

<? if ($empresapermissoes[0]->valor_autorizar == 'f') { ?>
                                                                $(function () {
                                                                    $('#convenio1').change(function () {
                                                                        if ($(this).val()) {
                                                                            $('.carregando').show();
                                                                            $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $('#convenio1').val()}, function (j) {
                                                                                options = '<option value=""></option>';
                                                                                if (j[0].dinheiro == 't') {
                                                                                    //                                                                            $("#valorth").show();
                                                                                    //                                                                            $("#valortd").show();

                                                                                    $("#valor1").attr("type", "text");
                                                                                } else {
                                                                                    $("#valor1").attr("type", "hidden");
                                                                                    //                                                                            $("#valorth").hide();
                                                                                    //                                                                            $("#valortd").hide();
                                                                                }
                                                                                if (j[0].carteira_obrigatoria == 't') {
                                                                                    $("#autorizacao").prop('required', true);
                                                                                } else {
                                                                                    $("#autorizacao").prop('required', false);
                                                                                }

                                                                            });
                                                                        }
                                                                    });
                                                                });


                                                                if ($('#convenio1').val()) {
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $('#convenio1').val()}, function (j) {
                                                                        options = '<option value=""></option>';
                                                                        if (j[0].dinheiro == 't') {
                                                                            $("#valor1").attr("type", "text");
                                                                        } else {
                                                                            $("#valor1").attr("type", "hidden");
                                                                        }
                                                                        if (j[0].carteira_obrigatoria == 't') {
                                                                            $("#autorizacao").prop('required', true);
                                                                        } else {
                                                                            $("#autorizacao").prop('required', false);
                                                                        }

                                                                    });

                                                                }
<? } ?>


                                                            $(function () {
                                                                $('#convenio1').change(function () {
                                                                    if ($(this).val()) {
                                                                        $('.carregando').show();
                                                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioconsulta', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                                            options = '<option value="">Selecione</option>';
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
                                                                        $('#procedimento1').html('<option value="">Selecione</option>');
                                                                    }
                                                                });
                                                            });


                                                            $(function () {
                                                                $('#procedimento1').change(function () {
                                                                    if ($(this).val()) {
                                                                        $("#submitButton").attr('disabled', 'disabled');
                                                                        $('.carregando').show();
                                                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                                            options = "";
                                                                            options += j[0].valortotal;
                                                                            document.getElementById("valor1").value = options;
                                                                            $("#submitButton").removeAttr('disabled');
                                                                            $('.carregando').hide();
                                                                        });

                                                                        $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimento', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {
//                                                        console.log(r);
//                                                        if(r.qtdeConsultas == 0 && r.grupo == "RETORNO"){
//                                                            alert("Erro ao selecionar retorno. Esse paciente não executou o procedimento associado a esse retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
//                                                            $("select[name=procedimento1]").val($("select[name=procedimento1] option:first-child").val(''));
//                                                        }else if(r.qtdeConsultas > 0 && r.grupo == "RETORNO" && r.retorno_realizado > 0){
//                                                            alert("Erro ao selecionar retorno. Esse paciente já realizou o retorno associado a esse procedimento no tempo cadastrado");
//                                                            $("select[name=procedimento1]").val($("select[name=procedimento1] option:first-child").val(''));
//                                                        }
                                                                        });

                                                                        $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimentoinverso', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {

//                                                        console.log(r);

                                                                            if (r.qtdeConsultas > 0 && r.retorno_realizado == 0) {
//                                                            alert('asdasd'); 
//                                                            alert("Esse paciente executou um procedimento associado a um retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
//                                                            alert(r.procedimento_retorno);
                                                                                if ('<?= $retorno_alterar ?>' == 'f') {
                                                                                    if (confirm("Esse paciente já executou esse procedimento num período de " + r.diasRetorno + " dia(s) e tem direito a um retorno. Deseja atribuí-lo?")) {
//                                                                alert('asdas');
                                                                                        $("#procedimento1").val(r.procedimento_retorno);
                                                                                        //                                                            $('#valor1').val('0.00');
                                                                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                                                                            options = "";
                                                                                            options += j[0].valortotal;
                                                                                            document.getElementById("valor1").value = options;
                                                                                            $('.carregando').hide();
                                                                                        });
                                                                                    }
                                                                                } else {
                                                                                    alert("Este paciente tem direito a um retorno associado ao procedimento escolhido");
                                                                                    $("#procedimento1").val(r.procedimento_retorno);
                                                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                                                                        options = "";
                                                                                        options += j[0].valortotal;
                                                                                        document.getElementById("valor1").value = options;
                                                                                        $('.carregando').hide();
                                                                                    });
                                                                                }


                                                                            }
                                                                        });
                                                                    } else {
                                                                        $('#valor1').html('value=""');
                                                                    }
                                                                });
                                                            });

                                                            $(function () {
                                                                $('#procedimento1').change(function () {
                                                                    if ($(this).val()) {
                                                                        $('.carregando').show();

                                                                        var procedimento = $(this).val();
                                                                        $("#formapamento").prop('required', false);

                                                                        $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                                            $("#vAjuste").css('display', 'none');
                                                                            $("#vAjusteIn").css('display', 'none');

                                                                            verificaAjustePagamentoProcedimento(procedimento);

                                                                            var options = '<option value="0">Selecione</option>';
                                                                            for (var c = 0; c < j.length; c++) {
                                                                                if (j[c].forma_pagamento_id != null) {
                                                                                    options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                                                }
                                                                            }
                                                                            $('#formapamento').html(options).show();
                                                                            $('.carregando').hide();
                                                                        });
                                                                    } else {
                                                                        $('#formapamento').html('<option value="0">Selecione</option>');
                                                                    }
                                                                });
                                                            });

//                                        function calculoIdade() {
//                                            var data = document.getElementById("txtNascimento").value;
//                                            var ano = data.substring(6, 12);
//                                            var idade = new Date().getFullYear() - ano;
//                                            document.getElementById("txtIdade").value = idade;
//                                        }
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

                                                                    document.getElementById("idade").value = idade + " ano(s)";
                                                                }
                                                            }

                                                            calculoIdade();


                                                            function verificaAjustePagamentoProcedimento(procedimentoConvenioId) {
<? if (@$empresapermissoes[0]->ajuste_pagamento_procedimento == 't') { ?>
                                                                    $.getJSON('<?= base_url() ?>autocomplete/verificaAjustePagamentoProcedimento', {procedimento: procedimentoConvenioId, ajax: true}, function (p) {
                                                                        if (p.length != 0) {
                                                                            $("#formapamento").prop('required', true);
                                                                            $("#vAjuste").css('display', 'block');
                                                                            $("#vAjusteIn").css('display', 'block');
                                                                            //                                                console.log($('#formapamento'));
                                                                        }
                                                                    });
<? } ?>
                                                            }

                                                            function buscaValorAjustePagamentoProcedimento() {
                                                                $.getJSON('<?= base_url() ?>autocomplete/buscaValorAjustePagamentoProcedimento', {procedimento: $('#procedimento1').val(), forma: $('#formapamento').val(), ajax: true}, function (p) {
                                                                    if (p.length != 0) {
                                                                        $("#valorAjuste").val(p[0].ajuste);
                                                                    } else {
                                                                        $("#valorAjuste").val('');
                                                                    }
                                                                });
                                                            }



</script>
