<body bgcolor="#C0C0C0">
    <meta charset="utf-8"/>
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">ALTERACAO</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/guia/fecharprocedimentonota/<? // $verificado['0']->agenda_exames_id;           ?>" method="post">
                <fieldset>

                    <table cellspacing="5" cellpadding="5">
                        <tr>
                            <td colspan="8"><font><b>Guia: <?= $ambulatorio_guia_id; ?></b></font></td>
                        </tr>
                        <tr>
                            <th class="tabela_header"><font size="4">Paciente</font></th>
                            <th class="tabela_header"><font size="4">Procedimento</font></th>
                            <th class="tabela_header"><font size="4">Convenio</font></th>
                            <th class="tabela_header" style="text-align: right"><font size="4">QTDE</font></th>
                            <th class="tabela_header" width="80px;" style="text-align: right"><font size="4">Preço</font></th>
                        </tr>

                        <?
                        $verificador = true;
                        foreach ($formapagamento as $item2) {
                            $data[$item2->nome] = 0;
                            $numero[$item2->nome] = 0;
                            $desconto[$item2->nome] = 0;
                            $parcela[$item2->nome] = 0;
                        }
                        $valTotal = $this->guia->relatorionotaprocedimentosvalortotal($ambulatorio_guia_id);
                                    
                        foreach ($procedimento as $item) {
                            ?>
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

                                    if ($item->forma_pagamento == $value5->nome) {
                                        $data[$value5->nome] = $data[$value5->nome] + $item->valor1;
                                        if ($item->valor1 != 0 && isset($item->valor1)) {
                                            $parcela[$value5->nome] = $item->parcelas1;
                                        }
                                        $numero[$value5->nome] ++;
                                    }
                                    if ($item->forma_pagamento_2 == $value5->nome) {
                                        $data[$value5->nome] = $data[$value5->nome] + $item->valor2;
                                        $numero[$value5->nome] ++;
                                        if ($item->valor2 != 0 && isset($item->valor2)) {
                                            $parcela[$value5->nome] = $item->parcelas2;
                                        }
                                    }
                                    if ($item->forma_pagamento_3 == $value5->nome) {
                                        $data[$value5->nome] = $data[$value5->nome] + $item->valor3;
                                        $numero[$value5->nome] ++;
                                        if ($item->valor3 != 0 && isset($item->valor3)) {
                                            $parcela[$value5->nome] = $item->parcelas3;
                                        }
                                    }
                                    if ($item->forma_pagamento_4 == $value5->nome) {
                                        $data[$value5->nome] = $data[$value5->nome] + $item->valor4;
                                        $numero[$value5->nome] ++;
                                        if ($item->valor4 != 0 && isset($item->valor4)) {
                                            $parcela[$value5->nome] = $item->parcelas4;
                                        }
                                    }
                                }

                                if ($item->forma_pagamento == "") {
                                    $OUTROS = $OUTROS + $item->valor_total;
                                    $NUMEROOUTROS++;
                                }
                                if ($item->faturado == 'f') {
                                    $pendentes ++;
                                }
                                ?>
                                <td style="text-align: right; color: <?= $cor ?>; font-weight: <?= $weigth ?>"><?= number_format($perc, 2, ',', '.'); ?></td>
                            </tr>
                        <?
                        }
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
                                    <? endif;
                                ?>
                    </table>
                    <hr/>
                    <button type="submit" name="btnEnviar">OK</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });


</script>