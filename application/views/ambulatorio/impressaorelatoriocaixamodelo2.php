<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>RELATÓRIO DE CAIXA</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <? if (count($operador) != 0) { ?>
        <h3>ATENDENTE: <?= $operador[0]->nome; ?></h3>
    <? } ?>
    <? if (count($operador) == 0) { ?>
        <h3>ATENDENTE: TODOS</h3>
    <? } ?>
    <? if (count($medico) != 0) { ?>
        <h3>MÉDICO: <?= $medico[0]->nome; ?></h3>
    <? } ?>    
    <? if (count($medico) == 0) { ?>
        <h3>MÉDICO: TODOS</h3>
    <? } ?>
    <hr>
    <style>
       
        a:hover{
            color:red;
        }
        .bold{
            font-weight: bolder;
        }
        .grey{
            background-color: grey;
        }
        .circulo {
            height: 25px;
            width: 25px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
          }
        .tabelaPagamentos{
            /* font-size: 5pt; */
            border-collapse: collapse;
            border-spacing: 5px;
        }
        
        .tabelaPagamentos td{
            font-size: 12px;
            padding: 7px;
            /*vertical-align: top;*/

        }
        .tabelaPagamentos th{
            font-size: 13px;
            padding: 7px;
            border: 1px solid black;
            /*vertical-align: top;*/

        }
        .tabelaGeral{
            /* font-size: 5pt; */
            border-collapse: separate;
            border-spacing: 5px;
        }
        
        .tabelaGeral td{
            font-size: 10px;
            /*vertical-align: top;*/

        }
        .alignTop{
            vertical-align: top;
        }
        
        .alignBottom{
            vertical-align: bottom;
        }
        .alignLeft{
            text-align: left;
        }
        .thOperador{
            text-align: left;

        }
  
        .tabelaFormas{
            /* font-size: 13pt; */
            border-collapse: collapse;
            
            width: 100%;
        }
        .tabelaFormas th{
            font-size: 8pt;
             /* width: 100px; */
        }
        .tabelaFormas td{
            /* padding-left: 5px; */
            /* padding-right: 5px; */
            /* text-align: center; */
            font-size: 7pt;
            /* width: 100px; */
            /* max-width: 100px; */
        }
        .tdNomeForma{
            text-align: center;
            width: 100px;
            /* max-width: 100px; */
        }
        .thNomeForma{
            text-align: center;
            width: 110px;
            /* max-width: 100px; */
        }
        .tabelaFormasValor{
            /* margin-bottom: 30px; */
            width: 70px;
            text-align: left;
        }
        .tabelaFormasParcelas{
            /* margin-bottom: 30px; */
            width: 50px;
            text-align: center;
        }
    </style>
    <?
    if (count($relatorio) > 0) {?>
    <table class="tabelaGeral" cellspacing=1 cellpadding=1>
         <thead>
            <tr>
                <th class="tabela_header"><font size="-1">Atendimento</th>
                <th class="tabela_header"><font size="-1">Emissao</th>
                <th class="tabela_header"><font size="-1">Paciente</th>
                <th class="tabela_header"><font size="-1">Procedimento</th>
                <th class="tabela_header"><font size="-1">Qtde</th>
                <th class="tabela_header" title="Data de Atendimento"><font size="-1">Data Ate.</th>
                <th class="tabela_header"><font size="-1">Data Pag.</th>
                <th class="tabela_header"><font size="-1">F. Pagamento</th>
                <th class="tabela_header"><font size="-1">Valor Tot.</th>
                <th class="tabela_header"><font size="-1">Valor Pag.</th>
                <th class="tabela_header"><font size="-1">Desconto Tot.</th>
                <!--<th class="tabela_teste" width="80px;"style="text-align: right"><font size="-1">Total Geral</th>-->
            </tr>
            <tr>
                <td colspan="6" class="tabela_header"></td>
                
                <td colspan="3" class="tabela_header"></td>
                <!--<th class="tabela_teste" width="80px;"style="text-align: right"><font size="-1">Total Geral</th>-->
            </tr>
            
        </thead>

       <? 
        foreach ($formapagamento as $value) {
            $formasValor[$value->nome] = 0;
            $formasCont[$value->nome] = 0;
            $formasDes[$value->nome] = 0;
            $formasCartao[$value->nome] = $value->cartao;
        }
       
          $guia_idTeste = 0;
          $operadorAtual = '';
          $data_inicio = $txtdata_inicio;
          $data_fim = $txtdata_fim;
          $agenda_exames_id = 0;
          $valor_total = 0;
          $contador_geral = 0;
          $teste_operador = 0;
          $contador_operador = 0;
          $contadorDinheiro = 0;
          $contadorCartao = 0;
          $valor_totalOperador = 0;
          $contadorGeralFormas = 0;
          $valorDinheiro = 0;
          $valorCartao = 0;
          $valorGeralFormas = 0;
          $valorTotalRelatorio = 0;
          $botaoFechar = false;
          $contador_teste = 0;
          // Se houver pelo menos uma coisa a ser mandada pro financeiro, ele deixa o botao pra fechar caixa
          $i = 0;
          $asterisco = '(*)';
        foreach ($relatorio as $item) { ?>
        <?
//           $valorTotalRelatorio += $valor_totalOperador;
           if($contador_teste == 106){
            // break;
           }
           $contador_teste++;
           $contador_operadorAnt = $contador_operador;
           $valor_totalOperadorAnt = $valor_totalOperador;
           // Quantidade de procedimentos e valor do último operador
           if($item->operador_autorizacao != $operadorAtual){
               $operadorAtualD = true;
               $contador_operador = 0;
               $valor_totalOperador = 0;
//               $valorTotalRelatorio += $valor_totalOperador;
           }else{
               $operadorAtualD = false;
           }
           $data = date("d/m/Y",strtotime($item->data)); 
           // Se for uma guia diferente da anterior
           if($guia_idTeste != $item->guia_id){
            $guia_id = $item->guia_id; 
            
            $paciente = $item->paciente; 
            $dataD = $data; 
           }else{
            $guia_id = ''; 
            $paciente = ''; 
            $dataD = '';
           
           }
           $corPR = 'black';
           // Cor do procedimento
           if($item->realizada == 'f'){
            $corPR = 'blue';
           }
           
           $operadorEditar = $item->operador_editar;
           $operadorAtual = $item->operador_autorizacao;
           $procedimento = $item->procedimento; 
           $qtdePro = $item->quantidade; 
           $codigoTUSS = $item->codigo; 
           $valor_totalProc = $item->valor_total; 
           $valor_descontoTotal = 0; 
           $valor_totalFormas = 0;
           
           $guia_idTeste = $item->guia_id;

        //    $guia_id = $item->guia_id; 
        //    $paciente = $item->paciente; 
           if($operadorEditar != ''){
               $editado = $asterisco;
           }else{
               $editado = '';
           }
           
           
           if($item->data_faturar != ''){
                $data_faturar = date("d/m/Y",strtotime($item->data_faturar)); 
           }else{
                $data_faturar = '';
           }
           // Como o agenda_exames se repete,  o contador do relatório só conta caso o agenda_exames seja diferente do ultimo
           // E soma valor total da mesma forma
           if($agenda_exames_id != $item->agenda_exames_id){
               $contador_geral++;
               $valor_total += $valor_totalProc;
               $contador_operador ++;
               $valor_totalOperador += $valor_totalProc;
           }
           
           $agenda_exames_id = $item->agenda_exames_id;
           
          
           // Tratando os arrays com os pagamentos;
           // É só pra tirar as chavinhas e fazer ele virar um array mesmo, nada de mirabolante
           //
           $array_formasPG = $item->forma_pagamento_array;
           $array_formasStr = str_replace('{', '',str_replace('}', '', $array_formasPG));
           if($array_formasStr != 'NULL'){
             $array_formas = explode(',', $array_formasStr);
           }else{
             $array_formas = array();
           }
           // ATENCAO A ESSA PARTE, ELA VAI FAZER UM ARRAY PRA SABER QUAIS PAGAMENTOS ESTAO ATIVOS
           $array_ativoPG = $item->ativo_array;
           $array_ativoStr = str_replace('{', '',str_replace('}', '', $array_ativoPG));
           $array_ativo = explode(',', $array_ativoStr);

           if($data_faturar != ''){
                // echo '<pre>';
                // var_dump($array_ativo); die;
                if(!in_array('t', $array_ativo)){
                    continue;
                }
           }
        //    echo '<pre>'; 
        //    var_dump($array_ativo); 
        //    die;
            // Valor
           $array_valorPG = $item->valor_bruto_array;
           $array_valorStr = str_replace('{', '',str_replace('}', '', $array_valorPG));
           $array_valor = explode(',', $array_valorStr);
           // Valor ajustado
           $array_valorAjustadoPG = $item->valor_ajustado_array;
           $array_valorAjustadoStr = str_replace('{', '',str_replace('}', '', $array_valorAjustadoPG));
           $array_valorAjustado = explode(',', $array_valorAjustadoStr);
           // Desconto
           $array_descontoPG = $item->desconto_array;
           $array_descontoStr = str_replace('{', '',str_replace('}', '', $array_descontoPG));
           $array_desconto = explode(',', $array_descontoStr);
           // Parcelas
           $array_parcelasPG = $item->parcelas_array;
           $array_parcelasStr = str_replace('{', '',str_replace('}', '', $array_parcelasPG));
           $array_parcelas = explode(',', $array_parcelasStr);
           // Ajuste
           $array_ajustePG = $item->ajuste_array;
           $array_ajusteStr = str_replace('{', '',str_replace('}', '', $array_ajustePG));
           $array_ajuste = explode(',', $array_ajusteStr);
           // Financeiro = Se já foi fechado o caixa com esse pagamento 
           $array_financeiroPG = $item->financeiro_array;
           $array_financeiroStr = str_replace('{', '',str_replace('}', '', $array_financeiroPG));
           $array_financeiro = explode(',', $array_financeiroStr);
           // Contador usado pra atribuir valores as formas
           $contf = 0;
            
        ?>
            <?if($operadorAtualD){?>
        
                <?if($teste_operador > 0){// Se for zero é porque é o primeiro operador, então não mostra a tabelinha?>
                    
                <?}?>
                <tr>
                    <th colspan="7" class="thOperador">
                        Operador: <?=$operadorAtual?>
                    </th>
                    <td class="tabela_header">
                        <table  class="tabelaFormas" cellspacing=0 cellpadding=1>
                                <tr>
                                    <th class="thNomeForma">
                                    F. Pag   
                                    </th>
                                    <th class="tabelaFormasParcelas">
                                    Parcelas   
                                    </th>
                                    <th class="tabelaFormasValor">
                                    Valor Pag
                                    </th>
                                    <th class="tabelaFormasValor">
                                    Ajuste
                                    </th >
                                    <th class="tabelaFormasValor">
                                    Desconto 
                                    </th>
                                </tr>
                        </table>

                    </td>
                </tr>
            <?}?>
            
            
                
            <tr>
                <td class="alignTop"><?=$guia_id?></td>
                <td class="alignTop"><?=$dataD?></td>
                <td class="alignTop"><?=$paciente?></td>
                <td class="alignTop" style="color: <?=$corPR?>">
                    <a class="aHover" style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarmodelo2/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>', '_blank', 'width=1000,height=900');">
                    <?=$agenda_exames_id?> - <?=$procedimento?>
                    </a>
                </td>
                <td class="alignTop">
                    <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarmodelo2/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>', '_blank', 'width=1000,height=900');">
                        <?=$qtdePro?> <?=$editado?>
                    </a>   
                </td>
                <td class="alignTop"><?=$data?></td>
                <td class="alignTop"><?=$data_faturar?></td>
                <td style="text-align: center;">

                    <table  class="tabelaFormas" cellspacing=0 cellpadding=1>
                        <!-- <tr>
                            <th>
                             Forma   
                            </th>
                            <th>
                             Valor P
                            </th>
                            <th>
                             Ajuste
                            </th>
                            <th>
                             Desconto 
                            </th>
                        </tr> -->
                        <?
                        foreach($array_formas as $forma){
                            // AQUI EU VERIFICO SE A FORMA NAO ESTA EXCLUIDA
                            $forma = str_replace('"', '', $forma);
                            if($array_ativo[$contf] == 'f'){
                                // echo '<tr><td>AAaA</td></tr>';
                                $contf++;
                                continue;
                            }

                            $parcelas = $array_parcelas[$contf];
                            $valor_totalFormas += $array_valorAjustado[$contf];
                            $valor_descontoTotal+= $array_desconto[$contf];
                            
                            $formasValor[$forma] += $array_valorAjustado[$contf];
                            $formasDes[$forma] += $valor_descontoTotal;
                            $formasCont[$forma]++;
                            if($formasCartao[$forma] == 't'){
                                $contadorCartao++;
                                $valorCartao +=  $array_valorAjustado[$contf];
                            }else{
                                $contadorDinheiro++;
                                $valorDinheiro +=  $array_valorAjustado[$contf];
                            }
                            $valorGeralFormas += $array_valorAjustado[$contf];
                            $contadorGeralFormas++;
                            if($array_financeiro[$contf] == 't'){
                                $corForma = 'green';
                            }else{
                                $corForma = 'black';
                                $botaoFechar = true;
                            }
                            ?>
                        <tr style="color: <?=$corForma?>">
                            <td class="tdNomeForma">
                                <?=$forma?>
                            </td>

                            <td class="tabelaFormasParcelas">
                                <?=$parcelas?>
                            </td>
                            
                            <td class="tabelaFormasValor">
                                R$: <?=number_format($array_valorAjustado[$contf], 2, ',', '.')?>
                            </td>
                            <td class="tabelaFormasValor">
                                <?=$array_ajuste[$contf]?>%
                            </td>
                            <td class="tabelaFormasValor">
                                R$: <?=number_format($array_desconto[$contf], 2, ',', '.')?>
                            </td>
                        </tr>
                        <?
                         $contf++;
                        }?>
                        
                    </table>
                
                </td>
                <td class="alignBottom">R$: <?= number_format($valor_totalProc, 2, ',', '.');?></td>
                <td class="alignBottom">R$: <?= number_format($valor_totalFormas, 2, ',', '.')?></td>
                <td class="alignBottom">R$: <?= number_format($valor_descontoTotal, 2, ',', '.')?></td>
                <!--<th class="tabela_teste" width="80px;"style="text-align: right"><font size="-1">Total Geral</th>-->
            </tr>    
        

            
        <?
        // Listinha do Operador
        // É caso o próximo operador seja diferente ou o foreach tenha chegado no fim
            if(isset($relatorio[$i + 1]->operador_autorizacao) && $operadorAtual != $relatorio[$i + 1]->operador_autorizacao || !isset($relatorio[$i + 1])){?>
                    <tr>
                        <td colspan="10"></td>
                        <td colspan="2"><b>TOTAL</b></td>
                    </tr>
                    <tr>
                        <td colspan="10"></td>
                        <td colspan="2"><b>Nr. Procedimentos: <?= $contador_operador; ?></b></td>
                        <?
                        $contador_operadorAnt = 0;
                        ?>
                    </tr>
                    <tr>
                        <td colspan="10"></td>
                        <td colspan="2"><b>VALOR TOTAL: <?= number_format($valor_totalOperador, 2, ',', '.'); ?></b></td>
                    </tr>
            <?}
        
            $i++;
            } // Fim do Loop dos procedimentos  
            
            ?>
                    <?
                    // Form pra fechar o caixa
                    ?>
                    
                    
                    <tr>
                        <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharcaixamodelo2" method="post">
                        <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                        <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>    
                        <input type="hidden" class="texto3" name="empresa" value="<?=(count($empresa) > 0)? $empresa[0]->empresa_id: ''; ?>"/>
                        <input type="hidden" class="texto3" name="empresaNome" value="<?=(count($empresa) > 0)? $empresa[0]->nome: ''; ?>"/>
                        <input type="hidden" class="texto3" name="grupo" value="<?=$_POST['grupo'] ?>"/>
                        <input type="hidden" class="texto3" name="procedimentos" value="<?=(@$_POST['procedimentos'] > 0) ? $_POST['procedimentos']: '' ?>"/>
                        <input type="hidden" class="texto3" name="operador" value="<?=$_POST['operador'] ?>"/>
                        <input type="hidden" class="texto3" name="operadorNome" value="<?=(@$_POST['operador'] > 0) ? $operador[0]->nome: '' ?>"/>
                        <input type="hidden" class="texto3" name="medico" value="<?=$_POST['medico'] ?>"/>
                        <input type="hidden" class="texto3" name="medicoNome" value="<?=(@$_POST['medico'] > 0) ? $medico[0]->nome: '' ?>"/>
                        <td colspan="9" style="padding-top: 40px;"></td>
                        <?if($_POST['medico'] > 0 || $_POST['grupo'] > 0){?>
                                <td colspan="2" style="padding-top: 40px;color: #b31b1b"><h3>Retire o filtro de "Médico" e "Especialidade" para fechar o caixa</h3></td>
                        <?}else{?>
                            <?if($botaoFechar){?>
                                <td colspan="2" style="padding-top: 40px;"><button type="submit" name="btnEnviar">Fechar Caixa</button></td>
                            <?}else{?>
                                <td colspan="2" style="padding-top: 40px;"><button disabled="" >Caixa Fechado</button></td>
                            <?}?>
                        <?}?>
                        
                        </form>
                    </tr>
    </table>   
    
        <hr>
    
        <table border="1" class="tabelaPagamentos">
                <!--<thead>-->
                    <tr class="grey">
                        <th colspan="3">Forma de Pagamento</th>
                        <th>Desconto</th>
                        <!--<th>Desconto</th>-->
                    </tr>
                    <tr class="grey">
                        <th >Nome</th>
                        <th >Qtde</th>
                        <th colspan="1">Valor</th>
                        <th colspan="1"></th>
                       
                    </tr>
                <!--</thead>-->
                <tbody>
                    <?
                    foreach($formasValor as $nomeForma => $valor){
                        if($formasCont[$nomeForma] == 0){
                            continue;
                        }
                        ?>
                        <tr>
                            <td><?=$nomeForma?></td>
                            <td><?=$formasCont[$nomeForma]?></td>
                            <td class="alignLeft">R$ <?=number_format($valor, 2, ',', '.')?></td>
                            <td class="alignLeft">R$ <?=number_format($formasDes[$nomeForma], 2, ',', '.')?></td>
                        </tr>
                    <?}
                    ?>
                    
                    <tr>
                        <td class="bold">Total Cartão</td>
                        <td ><?=$contadorCartao?></td>
                        <td colspan="2">R$ <?=number_format($valorCartao, 2, ',', '.')?></td>
                    </tr>
                    <tr>
                        <td class="bold">Total Dinheiro</td>
                        <td ><?=$contadorDinheiro?></td>
                        <td class="alignLeft" colspan="2">R$ <?=number_format($valorDinheiro, 2, ',', '.')?></td>
                    </tr>
                    <tr>
                        <td class="bold">Total Pago</td>
                        <td ><?=$contadorGeralFormas?></td>
                        <td class="alignLeft" colspan="2">R$ <?=number_format($valorGeralFormas, 2, ',', '.')?></td>
                    </tr>
                    <tr>
                        <td class="bold">Total Geral</td>
                        <td class="alignLeft" colspan="3">R$ <?=number_format($valor_total, 2, ',', '.')?></td>
                    </tr>
<!--                    <tr>
                        <td class="bold">Pendente</td>
                        <td class="alignLeft" colspan="3">R$ <?=number_format($valor_total - $valorGeralFormas, 2, ',', '.')?></td>
                    </tr>-->
                </tbody>
            </table>
    
            
    
            <h4>(*) Procedimento Editado.</h4>
            <!--<br>-->
            <br>
            <table border="1" class="tabelaPagamentos">
                        <tr class="grey">
                            <th colspan="3">Legenda</th>

                        </tr>
                        <tr >
                            <td >Sala de Espera</td>
                            <!--<td >Azul</td>-->
                            <td>
                                <div class="circulo" style="color: blue; background-color: blue;">

                                </div>
                            </td>
                        </tr>
                        <tr >
                            <td >Fechado</td>
                            <!--<td >Verde</td>-->
                            <td>
                                <div class="circulo" style="color: blue; background-color: green;">

                                </div>
                            </td>
                        </tr>
                <tbody>

                </tbody>
            </table>

    <?}?>
    
    
</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
