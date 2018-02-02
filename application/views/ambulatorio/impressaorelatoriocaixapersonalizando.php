<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">

    <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.5.1.min.js" ></script>
    <style>
        .totais{
            text-transform: uppercase;
            font-weight: bold;
            font-size: 11pt;
        }
        .barra{
            font-size: 15pt;
        }
        .resumo{
            padding-bottom: 20pt;
            margin-top: 20pt;
            margin-bottom: 10pt;
            border-bottom: 2.5pt solid black;
        }
        .fecharCaixa{
            position: absolute;
            top: 30pt;
            right: 50pt;
        }

        .button-resumoGeral{
            font-size: 9pt;
            text-decoration: underline;
            font-style: italic;
            cursor: help;
        }

        .legenda{
            position: absolute;
            top: 70pt;
            right: 50pt;
        }
        .legenda ul{ list-style: none; }
        #itemLegenda { width: 8pt; height: 8pt; border: 1pt solid black; border-radius: 10pt; display: inline-block }
        .legendaFaturado{background-color: red}
        .LegendaEnviado{background-color: #FFA500}
        .LegendaEditado{background-color: blue}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".button-resumoGeral").click(function () {
                $('html, body').animate({
                    scrollTop: $("#resumoGeral").offset().top
                }, 2000);
            });
            $("#buttonProcNaoFaturados").click(function () {
                $('html, body').animate({
                    scrollTop: $("#resumoProcNaoFaturados").offset().top
                }, 2000);
            });
            
            <? foreach ($operadores as $opItem) { ?>
                $("#button<?= $opItem->operador_id ?>").click(function () {
                    $('html, body').animate({
                        scrollTop: $("#resumoOperador<?= $opItem->operador_id ?>").offset().top
                    }, 2000);
                });
            <? } ?>
        });
    </script>
</head>
<body>
    <div class="content"> <!-- Inicio da DIV content -->

        <div class="legenda">
            <ul>
                <li><div class="legendaFaturado" id="itemLegenda"></div> <span style="color: red; font-weight: bold">Procedimento Não Faturado</span></li>
                <li><div class="LegendaEnviado" id="itemLegenda"></div> <span style="color: #FFA500; font-weight: bold">Procedimento Não Enviado</span></li>
                <li><div class="LegendaEditado" id="itemLegenda"></div> <span style="color: blue; font-weight: bold">Procedimento Editado</span></li>
                <li><div id="itemLegenda"></div> <span style="color: black">Normal</span></li>
            </ul>
        </div>

        <? if (count($empresa) > 0) { ?>
            <h4><?= $empresa[0]->razao_social; ?></h4>
        <? } else { ?>
            <h4>TODAS AS CLINICAS</h4>
        <? } ?>
        <h4>CONFERENCIA CAIXA (Personalizado)</h4>
        <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
        <h4>PACIENTE: <?= $paciente; ?></h4>
        <h4>OPERADOR: <?= (count($operador) != 0) ? $operador[0]->nome : "TODOS"; ?></h4>
        <? if (count($medico) != 0) { ?>
            <h3>MÉDICO: <?= $medico[0]->nome; ?></h3>
        <? } ?>    
        <? if (count($medico) == 0) { ?>
            <h3>MÉDICO: TODOS</h3>
        <? } ?>
        <hr>
        <?
        $agenda_exames_id = '';
        $financeiro = 'f';
        $faturado = 't';
        $exame = 't';
        

        foreach ($formapagamento as $item_resumo) {
            $caixaOperador[$item_resumo->nome] = 0;
            $caixaNumero[$item_resumo->nome] = 0;
            $caixaDesconto[$item_resumo->nome] = 0;
            $caixaParcela[$item_resumo->nome] = 0;
            
            $datacredito[$item_resumo->nome] = 0;
            $numerocredito[$item_resumo->nome] = 0;
        }
        
        $valPendentes = 0;
                
        if (count($procNaoFaturados) > 0 || count($operadores) > 0) {
            
            $totalProcedimentos = count($procNaoFaturados);
            
            foreach ($operadores as $opItem) {

                $resumoTotalCartao = 0;
                $resumoQtdeCartao = 0;
                $resumoDinheiro = 0;
                $resumoDesconto = 0;

                foreach ($formapagamento as $item_resumo) {
                    $resumoOperador[$item_resumo->nome] = 0;
                    $numeroOperador[$item_resumo->nome] = 0;
                    $descontoResumo[$item_resumo->nome] = 0;
                    $parcelaResumo[$item_resumo->nome] = 0;
                }
                $verificador_operador = true;
                ?>
                <table border='1' cellspacing=0 cellpadding=5>
                    <thead>
                        <tr>
                            <th class="tabela_header" colspan="5">
                                Operador Faturamento: <font size="5"><?= $opItem->nome; ?></font>
                                <button type="button" id="button<?= $opItem->operador_id ?>">Ver Resumo</button>
                            </th>
                        </tr>
                        <tr>
                            <th class="tabela_header"><font size="4">Paciente</font></th>
                            <th class="tabela_header"><font size="4">Procedimento</font></th>
                            <th class="tabela_header"><font size="4">Convenio</font></th>
                            <th class="tabela_header" style="text-align: right"><font size="4">QTDE</font></th>
                            <th class="tabela_header" width="80px;" style="text-align: right"><font size="4">Preço</font></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $listaProcOp = $this->guia->listarprocedimentocaixapersonalizadooperadorfaturamento($opItem->operador_id);
                        $totalProcedimentos += count($listaProcOp);
                        $primeiro = true;
                        $t = -1;

                        foreach ($listaProcOp as $item) {
                            $t++;

                            if ($opItem->operador_id == $item->operador_faturamento) {
                                /* CABECALHO */
                                if ($primeiro) {

                                    $primeiro = false;

                                    $DINHEIRO = 0;
                                    $NUMERODINHEIRO = 0;
                                    $DEBITO_CONTA = 0;
                                    $NUMERODEBITO_CONTA = 0;
                                    $CARTAOVISA = 0;
                                    $NUMEROCARTAOVISA = 0;
                                    $CARTAOMASTER = 0;
                                    $NUMEROCARTAOMASTER = 0;
                                    $CARTAOHIPER = 0;
                                    $CARTAOCREDITO = 0;
                                    $NUMEROCARTAOCREDITO;
                                    $NUMEROCARTAOHIPER = 0;
                                    $CARTAOELO = 0;
                                    $NUMEROCARTAOELO = 0;
                                    $CHEQUE = 0;
                                    $NUMEROCHEQUE = 0;
                                    $OUTROS = 0;
                                    $NUMEROOUTROS = 0;
//                                    $pendentes = 0;


                                    $verificador = true;
                                    $valTotal = $this->guia->relatoriocaixapersonalizadoprocedimentosvalortotal($item->guia_id, $item->operador_faturamento);
                                    $desconto_tot = 0;

                                    $data = array();
                                    $numero = array();
                                    $desconto = array();

                                    foreach ($formapagamento as $item2) {
                                        $data[$item2->nome] = 0;
                                        $numero[$item2->nome] = 0;
                                        $desconto[$item2->nome] = 0;
                                        $parcela[$item2->nome] = 0;
                                    }

                                    $agenda_exames_id .= $item->agenda_exames_id . ',';

                                    if ($item->financeiro == 't') {
                                        $financeiro = 't';
                                    }
                                    if ($item->exames_id == "") {
                                        $exame = 'f';
                                    }
                                    if ($item->faturado == "f" && $item->exame != 'RETORNO') {
                                        $faturado = 'f';
                                    }

                                    if ($verificador) {
                                        ?>
                                        <tr>
                                            <td colspan="8"><font><b>Guia: <?= $item->guia_id; ?></b></font></td>
                                        </tr>
                                        <?
                                    }
                                }
                                /* FIM DO CABECALHO */
                                ?>

                                <!-- CORPO -->
                                <tr>
                                    <?
                                    if ($item->faturado == 'f') {
                                        $cor = "red";
                                        $weigth = 'bold';
                                    } elseif ($item->realizada == 'f') {
                                        $cor = "#FFA500";
                                        $weigth = 'bold';
                                    } elseif ($item->operador_editar != '') {
                                        $cor = "blue";
                                        $weigth = 'bold';
                                    } else {
                                        $cor = "black";
                                        $weigth = 'normal';
                                    }

                                    if ($verificador):
                                        $verificador = false;
                                        ?>
                                        <td style="text-align: left;"><?= $item->paciente; ?></td>
                                    <? else: ?>
                                        <td style="text-align: left">&nbsp;</td>
                                    <? endif; ?>
                                    <td style="text-align: left; color: <?= $cor ?>; font-weight: <?= $weigth ?>;"><?= $item->procedimento; ?></td>
                                    <td style="text-align: left; color: <?= $cor ?>; font-weight: <?= $weigth ?>"><?= $item->convenio; ?></td>
                                    <td style="text-align: right; color: <?= $cor ?>; font-weight: <?= $weigth ?>"><?= $item->quantidade; ?></td>
                                    <?
                                    if ($valTotal != 0) {
                                        $perc = ((int) $item->quantidade * (float) $item->valor_total);
                                    } else {
                                        $perc = 0;
                                    }

                                    foreach ($formapagamento as $value5) {
                                        if ($item->desconto != '0.00') {
                                            $desconto[$value5->nome] = $desconto[$value5->nome] + (float) $item->desconto;
                                            $descontoResumo[$value5->nome] += (float) $item->desconto;
                                            $caixaDesconto[$value5->nome] += (float) $item->desconto;
                                        } else {
                                            //                                            $d = $item->valor - $item->valor_total;
                                            //                                            $desconto[$value5->nome] = $desconto[$value5->nome] + $d;
                                        }

                                        if ($item->forma_pagamento == $value5->nome) {
                                            $data[$value5->nome] = $data[$value5->nome] + $item->valor1;
                                            if ($item->valor1 != 0 && isset($item->valor1)) {
                                                $parcela[$value5->nome] = $item->parcelas1;
                                            }
                                            //Resumo do operador
                                            $numeroOperador[$value5->nome] ++;
                                            $caixaNumero[$value5->nome] ++;

                                            $numero[$value5->nome] ++;
                                        }
                                        if ($item->forma_pagamento_2 == $value5->nome) {
                                            $data[$value5->nome] = $data[$value5->nome] + $item->valor2;
                                            $numero[$value5->nome] ++;
                                            if ($item->valor2 != 0 && isset($item->valor2)) {
                                                $parcela[$value5->nome] = $item->parcelas2;
                                            }
                                            //Resumo do operador
                                            $numeroOperador[$value5->nome] ++;
                                            $caixaNumero[$value5->nome] ++;
                                        }
                                        if ($item->forma_pagamento_3 == $value5->nome) {
                                            $data[$value5->nome] = $data[$value5->nome] + $item->valor3;
                                            $numero[$value5->nome] ++;
                                            if ($item->valor3 != 0 && isset($item->valor3)) {
                                                $parcela[$value5->nome] = $item->parcelas3;
                                            }
                                            //Resumo do operador
                                            $numeroOperador[$value5->nome] ++;
                                            $caixaNumero[$value5->nome] ++;
                                        }
                                        if ($item->forma_pagamento_4 == $value5->nome) {
                                            $data[$value5->nome] = $data[$value5->nome] + $item->valor4;
                                            $numero[$value5->nome] ++;
                                            if ($item->valor4 != 0 && isset($item->valor4)) {
                                                $parcela[$value5->nome] = $item->parcelas4;
                                            }
                                            //Resumo do operador
                                            $numeroOperador[$value5->nome] ++;
                                            $caixaNumero[$value5->nome] ++;
                                        }
                                    }

                                    if ($item->forma_pagamento == "") {
                                        $OUTROS = $OUTROS + $item->valor_total;
                                        $NUMEROOUTROS++;
                                    }
                                    if ($item->faturado == 'f') {
                                        $pendentes ++;
                                    }
                                    $valor = 0;
                                    $valor = $valor + $item->valor_total;
                                    $y = 0;
                                    $y++;
                                    ?>
                                    <td style="text-align: right; color: <?= $cor ?>; font-weight: <?= $weigth ?>"><?= number_format($perc, 2, ',', '.'); ?></td>
                                </tr>
                                <!-- FIM DO CORPO -->

                                <?
                                if (isset($listaProcOp[$t + 1]->guia_id) && $listaProcOp[$t + 1]->guia_id == $item->guia_id) {
                                    continue;
                                    
                                } else {/* RESUMO GUIA */
                                    
                                    if (!$verificador):
                                        
                                        $TOTALCARTAO = 0;
                                        $QTDECARTAO = 0;
                                        $TOTALDINHEIRO = 0;
                                        foreach ($formapagamento as $value) {
                                            if ($value->cartao != 'f') {
                                                $TOTALCARTAO = $TOTALCARTAO + $data[$value->nome];
                                                $QTDECARTAO = $QTDECARTAO + $numero[$value->nome];
                                            } else {
                                                $TOTALDINHEIRO = $TOTALDINHEIRO + $data[$value->nome];
                                            }
                                        }

                                        $valortotal = $TOTALDINHEIRO + $TOTALCARTAO;
                                        $desconto_tot = $valTotal - $valortotal;

                                        // Resumo Geral do Operador
                                        $resumoDesconto += $desconto_tot;
                                        ?>
                                        <tr><td colspan="8"><span class="totais">Valor Total = R$ <?= number_format($valTotal, 2, ',', '.') ?>  <span class="barra">|</span>  Desconto = R$ <?= number_format($desconto_tot, 2, ',', '.') ?>  <span class="barra">|</span>  Valor Ajustado = R$ <?= number_format(($valTotal - $desconto_tot), 2, ',', '.') ?></span></td></tr>

                                        <tr><td colspan="8"></td></tr>

                                        <tr>
                                            <td colspan="8">

                                                <table border="1" cellspacing=0 >
                                                    <thead>
                                                        <tr>
                                                            <th width="270px;"><font size="2">Forma Pagamento</font></th>
                                                            <!--<th style="text-align: right" width="70px;"><font size="2">Qtde</font></th>-->
                                                            <th style="text-align: right" width="70px;"><font size="2">Ajuste (%)</font></th>
                                                            <th style="text-align: right" width="70px;"><font size="2">Parcela</font></th>
                                                            <th style="text-align: right" width="70px;"><font size="2">Vlr Parcela</font></th>
                                                            <th style="text-align: right" width="70px;"><font size="2">Vlr Total</font></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        foreach ($formapagamento as $value) {
                                                            if (@$data[$value->nome] == 0 || !isset($data[$value->nome])) {
                                                                continue;
                                                            }

                                                            $caixaOperador[$value->nome] += $data[$value->nome];
                                                            $caixaParcela[$value->nome] += $parcela[$value->nome];

                                                            $parcelaResumo[$value->nome] += $parcela[$value->nome];
                                                            $resumoOperador[$value->nome] += $data[$value->nome];
                                                            ?>


                                                            <tr>
                                                                <td ><font size="-1"><?= $value->nome ?></td>
                                                                <!--<td style="text-align: right"><font size="-1"><?= $numero[$value5->nome]; ?></td>-->
                                                                <td style="text-align: right"><font size="-1"><?= $value->ajuste; ?></td>
                                                                <td style="text-align: right"><font size="-1"><?= $parcela[$value->nome]; ?></td>
                                                                <td style="text-align: right"><font size="-1"><?= number_format(((float) $data[$value->nome] / (int) $parcela[$value->nome]), 2, ',', '.'); ?></td>
                                                                <td style="text-align: right"><font size="-1"><?= number_format($data[$value->nome], 2, ',', '.'); ?></td>
                                                            </tr>   
                                                        <? } ?>
                                                        <tr>
                                                            <td width="140px;" colspan="4"><font size="-1">TOTAL CARTAO</td>
                                                            <td width="200px;" style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="140px;" colspan="4"><font size="-1">TOTAL GERAL</td>
                                                            <td width="200px;" style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($valortotal, 2, ',', '.'); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr><td colspan="8"><br></td></tr>

                                        <tr><td colspan="8"><hr style="border: 0px none white; border-top: 2pt dashed #854141;"></td></tr>
                                        <?
                                    endif;

                                    $primeiro = true;
                                }
                                /* FIM DO RESUMO GUIA */
                            }
                        }
                        ?>
                    </tbody>
                </table>


                <div id="resumoOperador<?= $opItem->operador_id ?>" class="resumo">
                    <center>
                        <h3>RESUMO</h3>
                        <table border="1">
                            <thead>
                                <tr>
                                    <th width="270px;" colspan="3"><font size="2">Forma Pagamento</font></th>
                                    <th width="50px;" style="text-align: right"><font size="2">Desconto</font></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                foreach ($formapagamento as $formaPagamentoResumo) {
                                    if (@$resumoOperador[$formaPagamentoResumo->nome] == 0 || !isset($resumoOperador[$formaPagamentoResumo->nome])) {
                                        continue;
                                    }
                                    if ($formaPagamentoResumo->cartao != 'f') {
                                        $resumoTotalCartao = $resumoTotalCartao + $resumoOperador[$formaPagamentoResumo->nome];
                                        $resumoQtdeCartao = $resumoQtdeCartao + $numeroOperador[$formaPagamentoResumo->nome];
                                    } else {
                                        $resumoDinheiro = $resumoDinheiro + $resumoOperador[$formaPagamentoResumo->nome];
                                    }
                                    ?>
                                    <tr>
                                        <td ><font size="-1"><?= $formaPagamentoResumo->nome ?></td>
                                        <td style="text-align: right"><font size="-1"><?= $numeroOperador[$formaPagamentoResumo->nome]; ?></td>
                                        <td style="text-align: right"><font size="-1"><?= number_format($resumoOperador[$formaPagamentoResumo->nome], 2, ',', '.'); ?></td>
                                        <td style="text-align: right"><font size="-1"><?= number_format($descontoResumo[$formaPagamentoResumo->nome], 2, ',', '.'); ?></td>
                                    </tr>   
                                <? } ?>
                                <tr>
                                    <td colspan="4" align="center" style="background-color: #ddd"><font size="-1">TOTAL</td></tr>
                                <tr>
                                    <td colspan="3"><font size="-1">TOTAL CARTAO</td>
                                    <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($resumoTotalCartao, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><font size="-1">TOTAL DESCONTO</td>
                                    <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($resumoDesconto, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td width="140px;" colspan="3"><font size="-1">TOTAL GERAL</td>
                                    <? $resumoTotal = $resumoTotalCartao + $resumoDinheiro; ?>
                                    <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($resumoTotal, 2, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </div>

                <?
            }
            
            if (count($procNaoFaturados) > 0) {
                $cor = "red";
                $weigth = 'bold'; 

                $DINHEIRO = 0;
                $NUMERODINHEIRO = 0;
                $DEBITO_CONTA = 0;
                $NUMERODEBITO_CONTA = 0;
                $CARTAOVISA = 0;
                $NUMEROCARTAOVISA = 0;
                $CARTAOMASTER = 0;
                $NUMEROCARTAOMASTER = 0;
                $CARTAOHIPER = 0;
                $CARTAOCREDITO = 0;
                $NUMEROCARTAOCREDITO;
                $NUMEROCARTAOHIPER = 0;
                $CARTAOELO = 0;
                $NUMEROCARTAOELO = 0;
                $CHEQUE = 0;
                $NUMEROCHEQUE = 0;
                $OUTROS = 0;
                $NUMEROOUTROS = 0;
                $pendentes = 0;

                $verificador = true;
                $desconto_tot = 0;

                $data = array();
                $numero = array();
                $desconto = array();

                foreach ($formapagamento as $item2) {
                    $data[$item2->nome] = 0;
                    $numero[$item2->nome] = 0;
                    $desconto[$item2->nome] = 0;
                    $parcela[$item2->nome] = 0;
                }
                
                foreach ($formapagamento as $item_resumo) {
                    $resumoOperador[$item_resumo->nome] = 0;
                    $numeroOperador[$item_resumo->nome] = 0;
                    $descontoResumo[$item_resumo->nome] = 0;
                    $parcelaResumo[$item_resumo->nome] = 0;
                }
                ?>
                <table cellpadding="5" border='1'>
                    <thead>
                        <tr>
                            <th class="tabela_header" colspan="5">
                                <font size="5">Procedimentos Não Faturados</font>
                                <button type="button" id="buttonProcNaoFaturados">Ver Resumo</button>
                            </th>
                        </tr>
                        <tr>
                            <th class="tabela_header"><font size="4">Paciente</font></th>
                            <th class="tabela_header"><font size="4">Procedimento</font></th>
                            <th class="tabela_header"><font size="4">Convenio</font></th>
                            <th class="tabela_header" style="text-align: right"><font size="4">QTDE</font></th>
                            <th class="tabela_header" width="80px;" style="text-align: right"><font size="4">Preço</font></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($procNaoFaturados as $proc) { ?>
                        <td style="text-align: left;"><?= $proc->paciente; ?></td>
                        <td style="text-align: left; color: <?= $cor ?>; font-weight: <?= $weigth ?>;"><?= $proc->procedimento; ?></td>
                        <td style="text-align: left; color: <?= $cor ?>; font-weight: <?= $weigth ?>"><?= $proc->convenio; ?></td>
                        <td style="text-align: right; color: <?= $cor ?>; font-weight: <?= $weigth ?>"><?= $proc->quantidade; ?></td>
                        <?
                        
                        $agenda_exames_id .= $proc->agenda_exames_id . ',';

                        if ($proc->financeiro == 't') {
                            $financeiro = 't';
                        }
                        if ($proc->exames_id == "") {
                            $exame = 'f';
                        }
                        if ($proc->faturado == "f") {
                            $faturado = 'f';
                        }
                        
                        $perc = ((int) $proc->quantidade * (float) $proc->valor_total);
                        $valPendentes += $perc;

                        if ($proc->forma_pagamento == "") {
                            $OUTROS = $OUTROS + $proc->valor_total;
                            $NUMEROOUTROS++;
                        }
                        if ($proc->faturado == 'f') {
                            $pendentes ++;
                        }
                        $valor = 0;
                        $valor = $valor + $proc->valor_total;
                        $y = 0;
                        $y++;
                        ?>
                        <td style="text-align: right; color: <?= $cor ?>; font-weight: <?= $weigth ?>"><?= number_format($perc, 2, ',', '.'); ?></td>
                    <? } ?>
                    </tbody>
                </table>
        
                <div id="resumoProcNaoFaturados" class="resumo">
                    <center>
                        <h3>RESUMO</h3>
                        <table border="1">
                            <tbody>
                                <tr>
                                    <td width="140px;" colspan="3"><font size="-1">PENDENTES</td>
                                    <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($pendentes, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td width="140px;" colspan="3"><font size="-1">TOTAL GERAL</td>
                                    <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($valPendentes, 2, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </div>
            <? } ?>
            <? if (count($creditos) > 0) {
                foreach ($creditos as $item) {
                    if ($item->faturado == 'f') {
                        $faturado = 'f';
                    }
                    
                    foreach ($formapagamento as $value) {
                        if ($item->forma_pagamento == $value->nome) {
                            $datacredito[$value->nome] = $datacredito[$value->nome] + $item->valor1;
                            $numerocredito[$value->nome] ++;
                        }
                        
                        if ($item->forma_pagamento_2 == $value->nome) {
                            $datacredito[$value->nome] = $datacredito[$value->nome] + $item->valor2;
                            $numerocredito[$value->nome] ++;
                        }
                        
                        if ($item->forma_pagamento_3 == $value->nome) {
                            $datacredito[$value->nome] = $datacredito[$value->nome] + $item->valor3;
                            $numerocredito[$value->nome] ++;
                        }
                        
                        if ($item->forma_pagamento_4 == $value->nome) {
                            $datacredito[$value->nome] = $datacredito[$value->nome] + $item->valor4;
                            $numerocredito[$value->nome] ++;
                        }
                    }
                    
                } ?>
                <table border="1" cellpadding="5" cellspacing="5" style="magin-right: 12pt;">
                    <thead>
                        <tr>
                            <th colspan="12" bgcolor="#C0C0C0"><font size="-1"> CRÉDITOS LANÇADOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td bgcolor="#C0C0C0"><font size="-2">PACIENTE</td>
                            <td bgcolor="#C0C0C0"><font size="-2">DATA</td>
                            <td bgcolor="#C0C0C0"><font size="-2">VALOR</td>
                            <td bgcolor="#C0C0C0"><font size="-2">F.Pagamento 1</td>
                            <td bgcolor="#C0C0C0"><font size="-2">Valor 1</td>
                            <td bgcolor="#C0C0C0"><font size="-2">F.Pagamento 2</td>
                            <td bgcolor="#C0C0C0"><font size="-2">Valor 2</td>
                            <td bgcolor="#C0C0C0"><font size="-2">F.Pagamento 3</td>
                            <td bgcolor="#C0C0C0"><font size="-2">Valor 3</td>
                            <td bgcolor="#C0C0C0"><font size="-2">F.Pagamento 4</td>
                            <td bgcolor="#C0C0C0"><font size="-2">Valor 4</td>
                        </tr>
                        <?
                        $valorcreditototal = 0;
                        foreach ($creditos as $item) {
                            ?>
                            <?
                            $valorcreditototal = $valorcreditototal + $item->valor;
                            ?>
                            <tr <? if ($item->faturado == 'f') { ?> style="color: red;" <? } ?>>
                                <td><font size="-2"><?= $item->paciente ?></td>
                                <td><font size="-2"><?= date("d/m/Y", strtotime($item->data)) ?></td>
                                <td><font size="-2"><?= number_format($item->valor, 2, ',', '') ?></td>
                                <td><font size="-2"><?= $item->forma_pagamento ?></td>
                                <td><font size="-2"><?= number_format($item->valor1, 2, ',', '') ?></td>
                                <td><font size="-2"><?= $item->forma_pagamento_2 ?></td>
                                <td><font size="-2"><?= number_format($item->valor2, 2, ',', '') ?></td>
                                <td><font size="-2"><?= $item->forma_pagamento_3 ?></td>
                                <td><font size="-2"><?= number_format($item->valor3, 2, ',', '') ?></td>
                                <td><font size="-2"><?= $item->forma_pagamento_4 ?></td>
                                <td><font size="-2"><?= number_format($item->valor4, 2, ',', '') ?></td>
                            </tr>

                        <? }
                        ?>
                    </tbody>
                </table> 
            <? } ?>  
        
            <table>
                <tr>
                    <td>
                        <div class="fecharCaixa">
                            <span class="button-resumoGeral">Resumo Geral</span>
                            <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharcaixapersonalizado" method="post">
                                <?
                                foreach ($formapagamento as $value) {
                                    if ($value->forma_pagamento_id == 1000){
                                        continue; //Caso seja forma de pagamento CREDITO não será processado no fechar caixa
                                    }

                                    /*
                                     * Obs: O codigo abaixo foi feito pois o CodeIgniter não aceita certos caracteres
                                     * tais como '-', ' ', entre outros ao se fazer isso:
                                     * name="qtde['<? $value->nome; \?\>']
                                     */
                                    $nomeForma = str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $value->nome);
                                    $nomeForma = strtolower($nomeForma);
                                    ?>

                                    <input type="hidden" class="texto3" name="qtdecredito[<?= $nomeForma; ?>]" value="<?= number_format($datacredito[$value->nome], 2, ',', '.'); ?>"/>
                                    <input type="hidden" class="texto3" name="qtde[<?= $nomeForma; ?>]" value="<?= number_format($caixaOperador[$value->nome], 2, ',', '.'); ?>"/>
                                <? }
                                if (count($empresa) > 0) { ?>
                                    <input type="hidden" class="texto3" name="empresa" value="<?= $empresa[0]->empresa_id; ?>"/>
                                <? } ?>
                                <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                                <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>
                                <input type="hidden" class="texto3" name="agenda_exames_id" value="<?= $agenda_exames_id; ?>"/>

                                <? if ($faturado == 't' && $exame == 't') { 
                                    if (count($operador) == 0 && $financeiro == 'f') {
                                        if($paciente == '' || $paciente == 'TODOS') {?>
                                            <button type="submit" name="btnEnviar">Fechar Caixa</button>
                                    <?  } else { ?>
                                            <b>Não é possível fechar caixa por paciente</b>
                                        <? }
                                    } elseif (count($operador) > 0 && $financeiro == 'f') {
                                        ?>
                                        <b>Não é possível fechar caixa por operador</b>
                                        <?
                                    } else {
                                        ?>
                                        <b>Caixa Fechado</b>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <b>Pendencias de Faturamento / Finalizar exame</b>
                                <? } ?>
                            </form>
                        </div>

                    </td>
                    <td>
                        <div id="resumoGeral" class="resumo">
                            <center>
                                <h3>RESUMO GERAL</h3>
                                <table border="1">
                                    <thead>
                                        <tr>
                                            <th width="270px;" colspan="3"><font size="2">Forma Pagamento</font></th>
                                            <th width="50px;" style="text-align: right"><font size="2">Desconto</font></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                    $resumoDesconto = 0;
                                    $resumoDinheiro = 0;
                                    $resumoTotalCaixa = 0;
                                    $resumoQtdeCaixa = 0;
                                    $desconto = 0;
                                    $geral = 0;

                                    foreach ($formapagamento as $fpCaixa) {
                                        if (@$caixaOperador[$fpCaixa->nome] == 0 || !isset($caixaOperador[$fpCaixa->nome])) {
                                            continue;
                                        }

                                        if ($fpCaixa->cartao != 'f') {
                                            $resumoTotalCaixa = $resumoTotalCaixa + $caixaOperador[$fpCaixa->nome];
                                            $resumoQtdeCaixa = $resumoQtdeCaixa + $caixaOperador[$fpCaixa->nome];
                                        } else {
                                            $resumoDinheiro = $resumoDinheiro + $caixaOperador[$fpCaixa->nome];
                                        }
                                        $desconto += (float) $caixaDesconto[$fpCaixa->nome];
                                        ?>
                                        <tr>
                                            <td ><font size="-1"><?= $fpCaixa->nome ?></td>
                                            <td style="text-align: right"><font size="-1"><?= $caixaNumero[$fpCaixa->nome]; ?></td>
                                            <td style="text-align: right"><font size="-1"><?= number_format($caixaOperador[$fpCaixa->nome], 2, ',', '.'); ?></td>
                                            <td style="text-align: right"><font size="-1"><?= number_format($descontoResumo[$fpCaixa->nome], 2, ',', '.'); ?></td>
                                        </tr>   
                                    <?  } ?>
                                        <tr>
                                            <td colspan="4" align="center" style="background-color: #ddd"><font size="-1">TOTAL</td></tr>
                                        <tr>
                                            <td colspan="3"><font size="-1">NÚMERO DE PROCEDIMENTOS</td>
                                            <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= $totalProcedimentos; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><font size="-1">PENDENTES</td>
                                            <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($valPendentes, 2, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><font size="-1">TOTAL CARTAO</td>
                                            <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($resumoTotalCaixa, 2, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><font size="-1">TOTAL DESCONTO</td>
                                            <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($desconto, 2, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="140px;" colspan="3"><font size="-1">TOTAL GERAL</td>
                                            <? $resumoTotal = $resumoTotalCaixa + $resumoDinheiro + $valPendentes; ?>
                                            <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($resumoTotal, 2, ',', '.'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </center>
                        </div> 
                    </td>
                    <td>
                        <? if (count($creditos) > 0) {
                            $i = 0; ?>
                            <div style="display: inline-block;margin-left: 10px;">
                                <table border="1">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1">FORMA DE PAGAMENTO CRÉDITO</center></td>
                                    <!--<td colspan="1" bgcolor="#C0C0C0"><center><font size="-1">DESCONTO</center></td>-->
                                    </tr>
                                    <?
                                    foreach ($formapagamento as $value) {
                                        
                                        if ($numerocredito[$value->nome] > 0) {
                                            $i += $numerocredito[$value->nome];
                                            ?>
                                            <tr>
                                                <td width="140px;"><font size="-1"><?= $value->nome ?></td>
                                                <td width="140px;"><font size="-1"><?= $numerocredito[$value->nome]; ?></td>
                                                <td width="200px;"><font size="-1"><?= number_format($datacredito[$value->nome], 2, ',', '.'); ?></td>
                                                
                                            </tr>    


                                            <?
                                        }
                                    }
                                    
                                    $TOTALCARTAO = 0;
                                    $QTDECARTAO = 0;
                                    foreach ($formapagamento as $value) {
                                        /* A linha abaixo era a condiçao do IF antigamente. Agora tudo que nao for cartao sera DINHEIRO */
                                        //                ($value->nome != 'DINHEIRO' && $value->nome != 'DEBITO' && $value->nome != 'CHEQUE') 
                                        if ($value->cartao != 'f') {
                                            $TOTALCARTAO = $TOTALCARTAO + $datacredito[$value->nome];
                                            $QTDECARTAO = $QTDECARTAO + $numerocredito[$value->nome];
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td width="140px;"><font size="-1">TOTAL CARTAO</td>
                                        <td width="140px;"><font size="-1">Nr. Cart&otilde;es: <?= $QTDECARTAO; ?></td>
                                        <td width="200px;" colspan="2"><font size="-1">Total Cartao: <?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="140px;"><font size="-1">TOTAL GERAL</td>
                                        <td width="140px;"><font size="-1">Nr. Exa: <?= $i; ?></td>
                                        <td width="200px;" colspan="2"><font size="-1">Total Geral: <?= number_format($valorcreditototal, 2, ',', '.'); ?></td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>
                        <? } ?>
                    </td>
                </tr>
            </table>
        
            <? if (count($caixa)) { ?>
                <div>
                    <table border="1">
                        <thead>
                            <tr>
                                <th colspan="2" bgcolor="#C0C0C0">Sangria</th>
                            </tr>
                            <tr>
                                <th bgcolor="#C0C0C0">Caixa</th>
                                <th bgcolor="#C0C0C0">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            $valorsangria = 0;
                            
                            foreach ($caixa as $item) :
                                $valorsangria = $valorsangria + $item->valor;
                                ?>
                                <tr>
                                    <td><?= utf8_decode($item->operador_caixa); ?></td>
                                    <td><?= number_format($item->valor, 2, ',', '.'); ?></td>
                                </tr>
                            <? endforeach; ?>
                            <tr>
                                <th colspan="2" bgcolor="#C0C0C0">Total de Sangria</th>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Total</td>
                                <td><?= number_format($valorsangria, 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th colspan="2" bgcolor="#C0C0C0">Total Apurado Menos Sangria</th>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Total</td>
                                <td><?= number_format($resumoTotal - $valorsangria, 2, ',', '.'); ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            <? } ?>
    <?
        } 
        else {
        ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <? }
        ?>
    </div> <!-- Final da DIV content -->
</body>

