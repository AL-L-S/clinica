<div class="content"> <!-- Inicio da DIV content -->
    <h4>HUMANA IMAGEM</h4>
    <h4>CONFERENCIA RM</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <hr>
    <? if ($contador > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Emissao</th>
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Exame</th>
                    <th class="tabela_header"><font size="-1">Codigo</th>
                    <th class="tabela_header"><font size="-1">QTDE</th>
                    <th class="tabela_header"><font size="-1">F. Pagamento</th>
                    <th class="tabela_header" width="80px;"><font size="-1">V. Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $y = 0;
                $DINHEIRO = 0;
                $NUMERODINHEIRO = 0;
                $DEBITO_CONTA = 0;
                $NUMERODEBITO_CONTA = 0;
                $CHEQUE = 0;
                $NUMEROCHEQUE = 0;
                $CARTAOVISA = 0;
                $NUMEROCARTAOVISA = 0;
                $CARTAOMASTER = 0;
                $NUMEROCARTAOMASTER = 0;
                $OUTROS = 0;
                $NUMEROOUTROS = 0;

                foreach ($relatorio as $item) :
                    $i++;

                    $valortotal = $valortotal + $item->valor_total;

                    if ($i == 1 || $item->convenio == $convenio) {
                        ?>
                        <tr>
                            <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td><font size="-2"><?= $item->paciente; ?></td>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><font size="-2"><?= utf8_decode($item->exame); ?></td>
                            <td><font size="-2"><?= $item->codigo; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                            <? if ($item->operador_editar != '') { ?>
                                <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') . " (*)" ?></td>
                            <? } else { ?>
                                <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                            <? } ?>
                        </tr>


                        <?php
                        if ($item->forma_pagamento == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor_total;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor_total;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento == "CHEQUE") {
                            $CHEQUE = $CHEQUE + $item->valor_total;
                            $NUMEROCHEQUE++;
                        }
                        if ($item->forma_pagamento == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor_total;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor_total;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento == "") {
                            $OUTROS = $OUTROS + $item->valor_total;
                            $NUMEROOUTROS++;
                        }

                        $y++;
                        $valor = $valor + $item->valor_total;
                        $convenio = $item->convenio;
                    } else {
                        $convenio = $item->convenio;
                        ?>  
                        <tr>
                            <td colspan="2"><font size="-1">TOTAL</td>
                            <td colspan="2"><font size="-1">Nr. Exa: <?= $y; ?></td>
                            <td colspan="4"><font size="-1">VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>


                        <tr>
                            <td><font size="-2"><?= $item->data; ?></td>
                            <td><font size="-2"><?= $item->paciente; ?></td>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><font size="-2"><?= utf8_decode($item->exame); ?></td>
                            <td><font size="-2"><?= $item->codigo; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                            <? if ($item->operador_editar != '') { ?>
                                <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') . " (*)" ?></td>
                            <? } else { ?>
                                <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                            <? } ?>
                        </tr>
                        <?
                        if ($item->forma_pagamento == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor_total;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento == "CHEQUE") {
                            $CHEQUE = $CHEQUE + $item->valor_total;
                            $NUMEROCHEQUE++;
                        }
                        if ($item->forma_pagamento == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor_total;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor_total;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor_total;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento == "") {
                            $OUTROS = $OUTROS + $item->valor_total;
                            $NUMEROOUTROS++;
                        }

                        $valor = 0;
                        $valor = $valor + $item->valor_total;
                        $y = 0;
                        $y++;
                    }
                endforeach;
                ?>
                <tr>
                    <td colspan="2"><font size="-1">TOTAL</td>
                    <td colspan="2"><font size="-1">Nr. Exa: <?= $y; ?></td>
                    <td colspan="4"><font size="-1">VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
                <tr>
                    <td width="140px;"><font size="-1">TOTAL GERAL</td>
                    <td width="140px;"><font size="-1">Nr. Exa: <?= $i; ?></td>
                    <td><font size="-2"></td>
                    <td width="200px;"><font size="-1">Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></td>
                </tr>
            </tbody>

        </table>
        <hr>
        <table border="1">
            <tbody>
                <tr>
                    <td colspan="4" bgcolor="#C0C0C0"><center><font size="-1">FORMA DE PAGAMENTO</center></td>
            </tr>
            <tr>
                <td width="140px;"><font size="-1">DINHEIRO</td>
                <td width="140px;"><font size="-1"><?= $NUMERODINHEIRO; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1"><?= number_format($DINHEIRO, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td width="140px;"><font size="-1">CHEQUE</td>
                <td width="140px;"><font size="-1"><?= $NUMEROCHEQUE; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1"><?= number_format($CHEQUE, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td width="140px;"><font size="-1">DEBITO CONTA</td>
                <td width="140px;"><font size="-1"><?= $NUMERODEBITO_CONTA; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1"><?= number_format($DEBITO_CONTA, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td width="140px;"><font size="-1">CARTAO VISA</td>
                <td width="140px;"><font size="-1"><?= $NUMEROCARTAOVISA; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1"><?= number_format($CARTAOVISA, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td width="140px;"><font size="-1">CARTAO MASTER</td>
                <td width="140px;"><font size="-1"><?= $NUMEROCARTAOMASTER; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1"><?= number_format($CARTAOMASTER, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td width="140px;"><font size="-1">OUTROS</td>
                <td width="140px;"><font size="-1"><?= $NUMEROOUTROS; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1"><?= number_format($OUTROS, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td width="140px;"><font size="-1">TOTAL GERAL</td>
                <td width="140px;"><font size="-1">Nr. Exa: <?= $i; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1">Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></td>
            </tr>
            </tbody>

        </table>
        <h4>(*) Valores alterados.</h4>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>