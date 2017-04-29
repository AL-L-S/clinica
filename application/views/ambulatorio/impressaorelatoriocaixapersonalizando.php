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
            top: 50pt;
            right: 50pt;
        }

        .button-resumoGeral{
            font-size: 9pt;
            text-decoration: underline;
            font-style: italic;
            cursor: help;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".button-resumoGeral").click(function () {
                $('html, body').animate({
                    scrollTop: $("#resumoGeral").offset().top
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
        <? if (count($empresa) > 0) { ?>
            <h4><?= $empresa[0]->razao_social; ?></h4>
        <? } else { ?>
            <h4>TODAS AS CLINICAS</h4>
        <? } ?>
        <h4>CONFERENCIA CAIXA (Personalizado)</h4>
        <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
        <h4>PACIENTE: <?= $paciente; ?></h4>
        <h4>OPERADOR: <?= (count($operador) != 0) ? $operador[0]->nome : "TODOS"; ?></h4>

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
        }

        if (count($relatorioprocedimentos) > 0) {
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
                <table cellpadding="5">
                    <thead><?
                        if ($verificador_operador) {
                            $verificador_operador = false;
                            ?>

                            <tr>
                                <th class="tabela_header" colspan="5">
                                    Operador Faturamento: <font size="5"><?= $opItem->nome; ?></font>
                                    <button type="button" id="button<?= $opItem->operador_id ?>">Ver Resumo</button>
                                </th>
                            </tr>
                        <? }
                        ?>
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
                        $primeiro = true;
                        $t = -1;


                        foreach ($relatorioprocedimentos as $item) {
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
                                    $pendentes = 0;

                                    $verificador = true;

                                    //pegando o valor total dessa guia
                                    $valTotal = $this->guia->relatoriocaixapersonalizadoprocedimentosvalortotal($item->guia_id);
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
                                        } else {
                                            $d = $item->valor - $item->valor_total;
                                            $desconto[$value5->nome] = $desconto[$value5->nome] + $d;
                                        }

                                        $descontoResumo[$value5->nome] += $desconto[$value5->nome];
                                        $caixaDesconto[$value5->nome] += $desconto[$value5->nome];

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
                                if (isset($relatorioprocedimentos[$t + 1]->guia_id) && @$relatorioprocedimentos[$t + 1]->guia_id == $item->guia_id) {
                                    continue;
                                }
                                /* RESUMO GUIA */ else {
                                    if (!$verificador):
//            }
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

                                                <table border="1">
                                                    <thead>
                                                        <tr>
                                                            <th width="270px;"><font size="2">Forma Pagamento</font></th>
                                                            <!--<th style="text-align: right" width="70px;"><font size="2">Qtde</font></th>-->
                                                            <th style="text-align: right" width="70px;"><font size="2">Ajuste (%)</font></th>
                                                            <th style="text-align: right" width="70px;"><font size="2">Parcela</font></th>
                                                            <th style="text-align: right" width="70px;"><font size="2">Vlr Proc</font></th>
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
//            if ($operador == 'TODOS') {
                ?>
                <div class="fecharCaixa">
                    <span class="button-resumoGeral">Resumo Geral</span>
                    <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharcaixapersonalizado" method="post">
                        <?
                        foreach ($formapagamento as $value) {
                            /*
                             * Obs: O codigo abaixo foi feito pois o CodeIgniter não aceita certos caracteres
                             * tais como '-', ' ', entre outros ao se fazer isso:
                             * name="qtde['<? $value->nome; \?\>']
                             */
                            $nomeForma = str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $value->nome);
                            $nomeForma = strtolower($nomeForma);
                            ?>

                            <input type="hidden" class="texto3" name="qtde[<?= $nomeForma; ?>]" value="<?= number_format($caixaOperador[$value->nome], 2, ',', '.'); ?>"/>
                        <? }
                        ?>
                        <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                        <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>
                        <input type="hidden" class="texto3" name="agenda_exames_id" value="<?= $agenda_exames_id; ?>"/>
                        <? if ($faturado == 't' && $exame == 't') { ?>
                            <? if (count($operador) == 0 && $financeiro == 'f') { ?>
                                <button type="submit" name="btnEnviar">Fechar Caixa</button>
                            <? } elseif (count($operador) > 0 && $financeiro == 'f') {
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
                <?
//            }
            ?>
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
                            <? } ?>
                            <tr>
                                <td colspan="4" align="center" style="background-color: #ddd"><font size="-1">TOTAL</td></tr>
                            <tr>
                                <td colspan="3"><font size="-1">NÚMERO DE PROCEDIMENTOS</td>
                                <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= count($relatorioprocedimentos); ?></td>
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
                                <? $resumoTotal = $resumoTotalCaixa + $resumoDinheiro; ?>
                                <td style="text-align: right; font-weight: bolder;"><font size="-1"><?= number_format($resumoTotal, 2, ',', '.'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>   
            <?
        } else {
            ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <? }
        ?>
    </div> <!-- Final da DIV content -->
</body>

