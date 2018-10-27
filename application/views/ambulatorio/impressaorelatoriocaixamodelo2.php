<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>CONFERENCIA CAIXA</h4>
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
        table{
           
            
        }
        .tabelaGeral{
            /* font-size: 5pt; */
            border-collapse: separate;
            border-spacing: 5px;
        }
        .tabelaGeral td{
            font-size: 10px;
            vertical-align: top;

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
        .tabelaFormasValor{
            /* margin-bottom: 30px; */
            width: 70px;
            text-align: left;
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

       <? $guia_idTeste = 0;
          $operadorAtual = '';
          $data_inicio = $txtdata_inicio;
          $data_fim = $txtdata_fim;
        foreach ($relatorio as $item) { ?>
        <?
           
           if($item->operador_autorizacao != $operadorAtual){
               $operadorAtualD = true;
           }else{
               $operadorAtualD = false;
           }
           // Se for uma guia diferente da anterior
           if($guia_idTeste != $item->guia_id){
            $guia_id = $item->guia_id; 
            
            $paciente = $item->paciente; 
            $data = date("d/m/Y",strtotime($item->data)); 
           }else{
            $guia_id = ''; 
            $paciente = ''; 
            $data= '';
           
           }
           $corPR = 'black';
           // Cor do procedimento
           if($item->realizada == 'f'){
            $corPR = 'red';
           }

           $operadorAtual = $item->operador_autorizacao;


           $guia_idTeste = $item->guia_id;

        //    $guia_id = $item->guia_id; 
        //    $paciente = $item->paciente; 
           
           if($item->data_faturar != ''){
            $data_faturar = date("d/m/Y",strtotime($item->data_faturar)); 
           }else{
            $data_faturar = '';
           }
           
          
           $procedimento = $item->procedimento; 
           $qtdePro = $item->quantidade; 
           $codigoTUSS = $item->codigo; 
           $valor_totalProc = $item->valor_total; 
           $valor_descontoTotal = 0; 
           $valor_totalFormas = 0;
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
           // Ajuste
           $array_ajustePG = $item->ajuste_array;
           $array_ajusteStr = str_replace('{', '',str_replace('}', '', $array_ajustePG));
           $array_ajuste = explode(',', $array_ajusteStr);
           // Contador usado pra atribuir valores as formas
           $contf = 0;
            
        ?>
            <?if($operadorAtualD){?>
                <tr>
                    <th colspan="6" class="thOperador">
                        Operador: <?=$operadorAtual?>
                    </th>
                    <td class="tabela_header">
                        <table border=1 class="tabelaFormas" cellspacing=0 cellpadding=1>
                                <tr>
                                    <th class="tdNomeForma">
                                    F. Pag   
                                    </th>
                                    <th class="tabelaFormasValor">
                                    Valor Pag
                                    </th class="tabelaFormasValor">
                                    <th>
                                    Ajuste
                                    </th class="tabelaFormasValor">
                                    <th class="tabelaFormasValor">
                                    Desconto 
                                    </th>
                                </tr>
                        </table>

                    </td>
                </tr>
            <?}?>
            <tr>
                <td ><?=$guia_id?></td>
                <td ><?=$data?></td>
                <td ><?=$paciente?></td>
                <td style="color: <?=$corPR?>"><?=$codigoTUSS?> - <?=$procedimento?></td>
                <td ><?=$qtdePro?></td>
                <td ><?=$data_faturar?></td>
                <td style="text-align: center;">

                    <table border=1 class="tabelaFormas" cellspacing=0 cellpadding=1>
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
                            if($array_ativo[$contf] == 'f'){
                                // echo '<tr><td>AAaA</td></tr>';
                                $contf++;
                                continue;
                            }
                            $valor_totalFormas += $array_valorAjustado[$contf];
                            $valor_descontoTotal+= $array_desconto[$contf];
                            ?>
                        <tr>
                            <td class="tdNomeForma">
                                <?=str_replace('"', '',$forma)?>
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
                <td >R$: <?= number_format($valor_totalProc, 2, ',', '.');?></td>
                <td >R$: <?= number_format($valor_totalFormas, 2, ',', '.')?></td>
                <td>R$: <?= number_format($valor_descontoTotal, 2, ',', '.')?></td>
                <!--<th class="tabela_teste" width="80px;"style="text-align: right"><font size="-1">Total Geral</th>-->
            </tr>    
        

            
        <?} ?>

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
