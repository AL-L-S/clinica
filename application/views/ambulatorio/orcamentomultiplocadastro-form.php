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
        $empresaPermissoes = $this->guia->listarempresapermissoes();
        $odontologia_alterar = $empresaPermissoes[0]->odontologia_valor_alterar;
        ?>
        <h3 class="singular"><a href="#">Orçamento exames</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarorcamentomultiplocadastro" method="post">
                <fieldset>
                    <legend>Dados do paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
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
                        <label>CPF</label>
                        <input type="text" name="cpf" id="cpf" class="texto02" value="<?= @$paciente['0']->cpf ?>" readonly/>
                    </div>
                    <div>
                        <?
                        $telefone = $paciente['0']->celular;
                        if($paciente['0']->telefone != '') $telefone = $paciente['0']->telefone;
                        ?>
                        <label>Telefone</label>
                        <input type="text" name="cpf" id="cpf" class="texto02" value="<?= @$telefone ?>" readonly/>
                    </div>

<!--                    <div>
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
                    </div>-->
                </fieldset>

                <fieldset>
                    <style>
                        td{
                            vertical-align: middle;
                        }
                    </style>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th class="tabela_header">Empresa*</th>
                                <th class="tabela_header">Convenio*</th>
                                <th class="tabela_header">Grupo</th>
                                <th class="tabela_header">Procedimento*</th>
                              
<!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            
               
                             
                            <td  width="50px;">
                                <select  name="empresa1" id="empresa1" class="size1" required="">
                                    <option value="">Selecione</option>
                                    <?
                                   
                                    $lastEmp = $exames[count($exames) - 1]->empresa_id; ?>
                                    <? foreach ($empresa as $item) : ?>
                                        <option <? if ($lastEmp == $item->empresa_id) echo 'selected';?> value="<?= $item->empresa_id; ?>"><?= $item->nome; ?></option>
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

                                <select name="procedimento1[]" id="procedimento1" required class="size4 chosen-select" data-placeholder="Selecione" multiple tabindex="1">
                                    <!-- <option value="">Selecione</option> -->
                                </select>
                            </td>


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
                <legend>Orçamento Atual</legend>
                <?
                $total = 0;
                $totalCartao = 0;
                $orcamento = 0;
                $contador_id = 0;
                $contador_grupos = array();
                if (count($exames) > 0) {
                    ?>
                    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/guia/gravarorcamentomultiplodetalhescadastro/<?=$exames[0]->orcamento_id?>/<?=$exames[0]->paciente_id?>" method="post">
                        <table id="table_agente_toxico" border="0">
                            <thead>
                                <tr>
                                    <th colspan="10"><span style="font-size: 12pt; font-weight: bold;">Operador Responsável: <?= @$responsavel[0]->nome ?></span></th>
                                </tr>
                                <tr>
                                    <th class="tabela_header">Empresa</th>
                                    <th class="tabela_header">Convenio</th>
                                    <th class="tabela_header">Grupo</th>
                                    <th class="tabela_header">Procedimento</th>
                                    <th class="tabela_header">Data</th>
                                    <th class="tabela_header">Horário de Preferência</th>
                                    <th class="tabela_header">Forma de Pagamento</th>
                                    <!-- <th class="tabela_header" width="80">Descrição</th> -->
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
                                ?>
                                <tbody>
                                <tr>
                                        <input type="hidden" name="orcamento_item_id[<?=$contador_id?>]" id="orcamento_item_id<?=$contador_id?>" class="size1" value="<?=$item->ambulatorio_orcamento_item_id?>"/>
                                        <td class="<?php echo $estilo_linha; ?>">
                                        <?= $item->empresa; ?>
                                            <input type="hidden" name="empresa_array[<?=$contador_id?>]" id="empresa_array<?=$contador_id?>" class="size1" value="<?=$item->empresa_id?>"/>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>">
                                        <?= $item->grupo; ?>
                                        <input type="hidden" name="grupo_array[<?=$contador_id?>]" id="grupo_array<?=$contador_id?>" class="size1" value="<?=$item->grupo?>"/>
                                        </td>
                                        
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <input type="text" onchange="BuscarHorarios(<?=$contador_id?>);" name="txtdata[<?=$contador_id?>]" id="txtdata<?=$contador_id?>" alt="date" value="<?=($item->data_preferencia != '')? date("d/m/Y", strtotime($item->data_preferencia)): '';?>" class="size1"/>
                                            <input type="hidden" name="txthorario[<?=$contador_id?>]" id="txthorario<?=$contador_id?>"  value="<?=($item->horario_preferencia != '')? date("H:i:s", strtotime($item->horario_preferencia)): '';?>" class="size1"/>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <select name="turno_preferencia[<?=$contador_id?>]" id="turno_preferencia<?=$contador_id?>" class="size1" >
                                                <option value="">Selecione</option>

                                            </select>
                                    
                                        </td>
                                        
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <input type="hidden" name="procedimento_conv[<?=$contador_id?>]" id="procedimento_conv<?=$contador_id?>" class="size1" value="<?=$item->procedimento_convenio_id?>"/>
                                            <input type="hidden" name="formapamento_hid[<?=$contador_id?>]" id="formapamento_hid<?=$contador_id?>" class="size1" value="<?=$item->forma_pagamento_id?>"/>
                                            <select name="formapamento[<?=$contador_id?>]" id="formapamento<?=$contador_id?>" class="size1" onchange="buscaValorAjustePagamentoProcedimento(<?=$contador_id?>)">
                                                <option value="">Selecione</option>
                                                <? foreach ($forma_pagamento as $value) : ?>
                                                    <option <?=($item->forma_pagamento_id == $value->forma_pagamento_id) ? 'selected' : '';?> value="<?= $value->forma_pagamento_id; ?>"><?= $value->nome; ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <input readonly type="text" name="ajustevalor[<?=$contador_id?>]" id="ajustevalor<?=$contador_id?>"  class="texto01" value="<?=$item->valor_ajustado?>"/>
                                        </td>
                                        
                                        
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <a href="<?= base_url() ?>ambulatorio/guia/excluirorcamentorecepcaomultiplo/<?= $item->ambulatorio_orcamento_item_id ?>/<?= $item->paciente_id ?>/<?= $item->orcamento_id ?>" class="delete">
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                                <?
                                $contador_grupos[$contador_id] = $item->grupo;

                                $contador_id++;
                            }
                        ?>
                            <tr>
                                <td  colspan="10" style="background-color: grey;">
                                    <button type="submit" name="btnEnviar">Gravar Detalhes</button>
                                </td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <th class="tabela_footer" colspan="2" style="vertical-align: top;">
                                        Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                                    </th>
                                    <th class="tabela_footer" colspan="2" style="vertical-align: top;">
                                        Valor Total Ajustado: <?php echo number_format($totalCartao, 2, ',', '.'); ?>
                                    </th>
                                    <th colspan="2" align="center">
                                        <center>
                                            <div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoorcamento/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Imprimir Or&ccedil;amento</a>
                                            </div>
                                        </center>
                                        <center>
                                            <div class="bt_linkf">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/orcamentocadastrofila/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Fila de Impressão</a>
                                            </div>
                                        </center>
                                    </th>
                                    <th colspan="2" align="center">
                                        <?  if ($exames[0]->autorizado != 't') {  ?>
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
                    </form>
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
                                        <th class="tabela_header">Horário de Preferência</th>
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
                                            <td class="<?php echo $estilo_linha; ?>"><?= ($item->horario_preferencia != '') ? date("H:i", strtotime($item->horario_preferencia)) : 'Não-Informado' ?></td>
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
    #procedimento1_chosen a { width: 100%; }
</style>
<script type="text/javascript">
//    $(".select-data").hide();
//    $(".input-data").hide();
var array_datas = [];
//    var array_datas_teste = [];
    // alert('asd');
//     $(document).ready(function() {
    function date_picker (id, array_Dates){
        // alert(id);
        $("#txtdata" + id).datepicker({
            beforeShowDay: function(d) {
        // normalize the date for searching in array
            var dmy = "";
            dmy += ("00" + d.getDate()).slice(-2) + "-";
            dmy += ("00" + (d.getMonth() + 1)).slice(-2) + "-";
            dmy += d.getFullYear();
//            console.log(dmy);
            return [$.inArray(dmy, array_Dates) >= 0 ? true : false, ""];
            },
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
//    });
    }
    
//    document.ready
    $( document ).ready(function() {
        var contador_id = 0;
        for (index = 0; index < <?=$contador_id?>; index++) {
            // alert($("#grupo_array" + index).val());
            // date_picker(index, array_datas);
            BuscarDatas(index);
            FormaPagamentoProcedimento(index, $("#procedimento_conv" + index).val());
            BuscarHorarios(index);
            
            // date_picker(index, array_datas);
            contador_id++;
        }

    });

    function verificaAjustePagamentoProcedimento(index, procedimentoConvenioId){
        <? if ($empresaPermissoes[0]->ajuste_pagamento_procedimento == "t") { ?>
            $.getJSON('<?= base_url() ?>autocomplete/verificaAjustePagamentoProcedimento', {procedimento: procedimentoConvenioId, ajax: true}, function (p) {
                    if (p.length != 0) {
                        $("#formapamento" + index).prop('required', true);
                    }
                });
        
        <?} ?>
    }

    function FormaPagamentoProcedimento(index, procedimento){
        // alert(procedimento);
        <? if ($empresaPermissoes[0]->ajuste_pagamento_procedimento == "t") { ?>
                $("#formapamento").prop('required', false);
        
        $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: procedimento, ajax: true}, function (j) {

            verificaAjustePagamentoProcedimento(index, procedimento);
            var options = '<option value="">Selecione</option>';
            var selected = '';
            for (var c = 0; c < j.length; c++) {
                if (j[c].forma_pagamento_id != null) {
                    // alert('');
                    if(j[c].forma_pagamento_id == $("#formapamento_hid" + index).val()){
                        selected = 'selected';  
                    }else{
                        selected = '';
                    }
                    options += '<option '+ selected +' value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                }
            }
            $('#formapamento' + index).html(options).show();
            // $('.carregando').hide();

        });

        <?}?>
    }

     function buscaValorAjustePagamentoProcedimento(index){                                    
        $.getJSON('<?= base_url() ?>autocomplete/buscaValorAjustePagamentoProcedimento', {procedimento: $('#procedimento_conv' + index).val(), forma: $('#formapamento' + index).val(), ajax: true}, function (p) {
            if (p.length != 0) {
                $("#ajustevalor" + index).val(p[0].ajuste);
            }
            else{
                $("#ajustevalor" + index).val('');
            }
        });
    }

    function BuscarDatas(index){

        $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamento', {grupo1: $("#grupo_array" + index).val(), empresa1: $('#empresa_array' + index).val(), ajax: true}, function (j) {
//                                   alert('teste');
                if(j.length > 0){
                     array_datas = [];

                    var options = '<option value="">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].data != null) {
                           
                            array_datas.push(j[c].data_formatada_picker);
                            options += '<option value="' + j[c].data + '">' + j[c].data_formatada + '</option>';
                        }
                    }
                    // console.log(array_datas);
                    // alert(index);
//                    $("#txtdata").datepicker("refresh");
                    date_picker(index, array_datas);
//                    $('select#txtdata').html(options).show();
                    // $('.carregando').hide();
                    
                    
                }else{
                    array_datas = [];
                    date_picker(index, array_datas);
                }
        });
    }

        function BuscarHorarios(index){
            // alert(id);
            $.getJSON('<?= base_url() ?>autocomplete/horariosdisponiveisorcamentodata', {grupo1: $("#grupo_array" + index).val(), empresa1: $('#empresa_array' + index).val(), data:  $('#txtdata' + index).val(),  ajax: true}, function (j) {
    //                    console.log(j);
                        if(j.length > 0){
    //                    alert('teste');
                        var options = '<option value="">Selecione</option>';
                        manha = '';
                        tarde = '';
                        noite = '';
                        hora = '';
                        selected = '';
                        for (var c = 0; c < j.length; c++) {
                            if (j[c].inicio != null) {
                                hora = j[c].inicio;
                                // alert(hora, $("#txthorario" + index).val());
                                if(hora == $("#txthorario" + index).val()){
                                    selected = 'selected';
                                }else{
                                    selected = '';
                                }
                                if(parseInt(hora.substring(0, 2)) < 12 && manha == ''){
                                    manha = j[c].inicio;
                                    options += '<option '+ selected +' value="' + manha + '">' + manha.substring(0, 5) + '</option>';
                                }
                                if(parseInt(hora.substring(0, 2)) < 18 && parseInt(hora.substring(0, 2)) > 11 && tarde == ''){
                                    tarde = j[c].inicio;
                                    options += '<option '+ selected +' value="' + tarde + '">' + tarde.substring(0, 5) + '</option>';
                                }
                                if(parseInt(hora.substring(0, 2)) > 17 && noite == ''){
                                    noite = j[c].inicio;
                                    options += '<option '+ selected +' value="' + noite + '">' + noite.substring(0, 5) + '</option>';
                                }
                                
                            }
                        }
                        $('#turno_preferencia'+ index).html(options).show();
                        // $('.carregando').hide();
                    }
                });

        }

            if ($('#convenio1').val() != '-1') {
                if($('#grupo1').val() == ''){
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioorcamento', {convenio1: $('#convenio1').val(), ajax: true}, function (j) {
                        options = '<option value=""></option>';
                        for (var c = 0; c < j.length; c++) {
                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                        }
//                                        $('#procedimento1').html(options).show();
// alert('ola');
                        $('#procedimento1 option').remove();
                        $('#procedimento1').append(options);
                        $("#procedimento1").trigger("chosen:updated");
                        $('.carregando').hide();
                    });
                }
                else {
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $('#grupo1').val(), convenio1: $('#convenio1').val()}, function (j) {
                        options = '<option value=""></option>';
                                    //    alert('ola');
                        for (var c = 0; c < j.length; c++) {
                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                        }

                        $('#procedimento1 option').remove();
                        $('#procedimento1').append(options);
                        $("#procedimento1").trigger("chosen:updated");
//                                        $('#procedimento1').html(options).show();
                        $('.carregando').hide();
                    });
                }
            }

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
//                                            $('#procedimento1').html(options).show();
                        $('.carregando').hide();
                    });
                });
            });

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

            $(function () {
                $('#convenio1').change(function () {
                    if ($(this).val()) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioorcamento', {convenio1: $(this).val(), ajax: true}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                            }
//                                                console.log(options);
//                                                $('#procedimento1').html(options).show();

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
//                                                    $('#procedimento1').html(options).show();

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





</script>
