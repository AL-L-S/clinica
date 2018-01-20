<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>
            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONFERENCIA CAIXA CART&Atilde;O</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
            </tr>
            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
                <?
            } else {
                if (isset($relatorio[0]->grupo)) {
                    $nome_grupo = $relatorio[0]->grupo;
                } else {
                    $nome_grupo = $grupo;
                }
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $nome_grupo; ?></th>
                </tr>
            </thead>
            <?
        }
        if ($contador > 0) {
            ?>
            <tbody>
                <?php
                $i = 0;
                $b = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $cartao = 0;
                $y = 0;
                $w = 0;
                $DINHEIRO = 0;
                $NUMERODINHEIRO = 0;
                $CHEQUE = 0;
                $NUMEROCHEQUE = 0;
                $CARTAOVISA = 0;
                $NUMEROCARTAOVISA = 0;
                $CARTAOMASTER = 0;
                $NUMEROCARTAOMASTER = 0;
                $CARTAOHIPER = 0;
                $NUMEROCARTAOHIPER = 0;
                $OUTROS = 0;
                $NUMEROOUTROS = 0;
                $financeiro = 'f';
                $faturado = 't';
                $valoroperador = 0;
                $qtdepaciente = 0;
                $qtdeexame = 0;
                $operadorexames = "";
                $paciente = "";

                foreach ($formapagamento as $value) {
                    $data[$value->nome] = 0;
                    $datacredito[$value->nome] = 0;
                    $numerocredito[$value->nome] = 0;
                    $descontocredito[$value->nome] = 0;
                    $numero[$value->nome] = 0;
                    $desconto[$value->nome] = 0;
                }

                foreach ($relatorio as $item) :

                    $i++;
                    $b++;
                    if ($item->financeiro == 't') {
                        $financeiro = 't';
                    }
                    if ($item->faturado == "f") {
                        $faturado = 'f';
                    }

                    $u = 0;
                    foreach ($formapagamento as $value) {
//                            echo 'teste'; die;
                        if ($item->forma_pagamento == $value->nome) {
                            $data[$value->nome] = $data[$value->nome] + $item->valor1;
                            $numero[$value->nome] ++;
                            if ($u == 0) {
                                $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                            }
                            if ($item->desconto != '') {
                                $u++;
                            }
                        }
                    }
                    foreach ($formapagamento as $value) {
                        if ($item->forma_pagamento_2 == $value->nome) {
                            $data[$value->nome] = $data[$value->nome] + $item->valor2;
                            $numero[$value->nome] ++;
                            if ($u == 0) {

                                $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                            }
                            if ($item->desconto != '') {
                                $u++;
                            }
                        }
                    }
                    foreach ($formapagamento as $value) {
                        if ($item->forma_pagamento_3 == $value->nome) {
                            $data[$value->nome] = $data[$value->nome] + $item->valor3;
                            $numero[$value->nome] ++;
                            if ($u == 0) {

                                $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                            }
                            if ($item->desconto != '') {
                                $u++;
                            }
                        }
                    }
                    foreach ($formapagamento as $value) {
                        if ($item->forma_pagamento_4 == $value->nome) {
                            $data[$value->nome] = $data[$value->nome] + $item->valor4;
                            $numero[$value->nome] ++;
                            if ($u == 0) {

                                $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                            }
                            if ($item->desconto != '') {
                                $u++;
                            }
                        }
                    }


                    $valortotal = $valortotal + $item->valor_total;

                    $valoroperador = $valoroperador + $item->valor_total;
                    $qtdepaciente++;
                    $qtdeexame++;
                    ?>
                                                                                                <!--<tr>-->
                    <? if ($paciente == $item->paciente) { ?>
                                                                                                                            <!--                                    <td>&nbsp;</td>
                                                                                                                                                            <td>&nbsp;</td>
                                                                                                                                                            <td>&nbsp;</td>-->
                    <? } else { ?>
                                                                                                                            <!--                                    <td><font size="-2"><?= $item->guia_id; ?></td>
                                                                                                                                                            <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?>
                        <? if ($item->verificado == 't') {
                            ?>&Sqrt;<? }
                        ?>
                                                                                                                                                            </td>
                                                                                                                                                            <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>-->
                    <? } ?>
                                                                        <!--                                <td><font size="-2"><?= utf8_decode($item->exame); ?></td>-->
                    <? if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_2 != 'DINHEIRO' && $item->forma_pagamento_3 != 'DINHEIRO' && $item->forma_pagamento_4 != 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 != '') { ?>
                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?><br><?= $item->forma_pagamento_4; ?></td>
                                                                                                                                                            <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1 + $item->valor2 + $item->valor3 + $item->valor4;
                    }if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_2 != 'DINHEIRO' && $item->forma_pagamento_3 != 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 == '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1 + $item->valor2 + $item->valor3;
                    }
                    if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_2 != 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1 + $item->valor2;
                    }
                    if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1;
                    }

                    if ($item->forma_pagamento == 'DINHEIRO' && $item->forma_pagamento_2 != 'DINHEIRO' && $item->forma_pagamento_3 != 'DINHEIRO' && $item->forma_pagamento_4 != 'DINHEIRO' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 != '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?><br><?= $item->forma_pagamento_4; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor2 + $item->valor3 + $item->valor4;
                    }if ($item->forma_pagamento == 'DINHEIRO' && $item->forma_pagamento_2 != 'DINHEIRO' && $item->forma_pagamento_3 != 'DINHEIRO' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 == '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor2 + $item->valor3;
                    }if ($item->forma_pagamento == 'DINHEIRO' && $item->forma_pagamento_2 != 'DINHEIRO' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                        ?>

                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento_2; ?></td>
                                                                                                                                                                            <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor2, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor2, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor2;
                    }
                    ?>
                    <? if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_2 == 'DINHEIRO' && $item->forma_pagamento_3 != 'DINHEIRO' && $item->forma_pagamento_4 != 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 != '') { ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_3; ?><br><?= $item->forma_pagamento_4; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1 + $item->valor3 + $item->valor4;
                    }if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_2 == 'DINHEIRO' && $item->forma_pagamento_3 != 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 == '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_3; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1 + $item->valor3;
                    }if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_2 == 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1;
                    }
                    ?>
                    <? if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_2 != 'DINHEIRO' && $item->forma_pagamento_3 == 'DINHEIRO' && $item->forma_pagamento_4 != 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_4 != '') { ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_4; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1 + $item->valor2 + $item->valor4;
                    }if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_2 != 'DINHEIRO' && $item->forma_pagamento_3 == 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_4 == '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1 + $item->valor2;
                    }if ($item->forma_pagamento != 'DINHEIRO' && $item->forma_pagamento_3 == 'DINHEIRO' && $item->forma_pagamento != '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_4 == '') {
                        ?>
                                                                                                                                                                            <!--                                    <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                                                                                                                                                                                                                <td><font size="-2"><?= $item->quantidade; ?></td>-->
                        <? if ($item->operador_editar != '') { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') . " (*)" ?></td>-->
                        <? } else { ?>
                                                                                                                                                                                                                                <!--                                        <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?></td>-->

                            <?
                        }
                        $valor = $valor + $item->valor1;
                        ?>
                        <!--</tr>-->

                        <?php
                        $y++;

                        $paciente = $item->paciente;
                        $operadorexames = $item->nomefaturamento;

                        $cartao = 0;
                    }
                endforeach;
                ?>
            <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharcaixa" method="post">
                <input type="hidden" class="texto3" name="dinheiro" value="<?= number_format($DINHEIRO, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="cheque" value="<?= number_format($CHEQUE, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="cartaovisa" value="<?= number_format($CARTAOVISA, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="cartaomaster" value="<?= number_format($CARTAOMASTER, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="outros" value="<?= number_format($OUTROS, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>
                <input type="hidden" class="texto3" name="grupo" value="<?= $grupo; ?>"/>
                <!--
                                <tr>
                                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>TOTAL</b></td>
                                </tr>
                                <tr>
                                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>Nr. Exa: <?= $y; ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></b></td>
                                </tr>-->


            </form>
            </tbody>
        </table>
        <!--<hr>-->
        <?
//        var_dump($numero);
//        die;
        ?>
        <table border="1">
            <tbody>
            <tr>
              <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1">FORMA DE PAGAMENTO</center></td>
              <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1">DESCONTO</center></td>
            </tr>
            <?
            foreach ($formapagamento as $value) {
                if ($numero[$value->nome] > 0) {
                    ?>
                    <tr>
                        <td width="140px;"><font size="-1"><?= $value->nome ?></td>
                        <td width="140px;"><font size="-1"><?= $numero[$value->nome]; ?></td>
                        <td width="200px;"><font size="-1"><?= number_format($data[$value->nome], 2, ',', '.'); ?></td>
                        <td><font size="-1"><?= number_format($desconto[$value->nome], 2, ',', '.'); ?></td>
                    </tr>    


                    <?
                }
            }
            ?>
            <tr>
                <td width="140px;"><font size="-1">PENDENTES</td>
                <td width="140px;"><font size="-1"><?= $NUMEROOUTROS ?></td>
                <td width="200px;"><font size="-1"><?= number_format($OUTROS, 2, ',', '.'); ?></td>
                <td><font size="-2"></td>
            </tr>  
            <?
            $TOTALCARTAO = 0;
            $QTDECARTAO = 0;
            foreach ($formapagamento as $value) {
                /* A linha abaixo era a condiçao do IF antigamente. Agora tudo que nao for cartao sera DINHEIRO */
                //                ($value->nome != 'DINHEIRO' && $value->nome != 'DEBITO' && $value->nome != 'CHEQUE') 
                if ($value->cartao != 'f') {
                    $TOTALCARTAO = $TOTALCARTAO + $data[$value->nome];
                    $QTDECARTAO = $QTDECARTAO + $numero[$value->nome];
                }
            }
            ?>
            <tr>
                <td width="140px;"><font size="-1">TOTAL CARTAO</td>
                <td width="140px;"><font size="-1">Nr. Cart&otilde;es: <?= $QTDECARTAO; ?></td>
                <td width="200px;" colspan="2"><font size="-1">Total Cartao: <?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
            </tr>

            </tbody>

        </table>
        <!--<h4>(*) Valores alterados.</h4>-->
        <?
        @$PERCENTUALDINHEIRO = ($NUMERODINHEIRO * 100) / $i;
        @$PERCENTUALCHEQUE = ($NUMEROCHEQUE * 100) / $i;
        @$PERCENTUALCARTAOVISA = ($NUMEROCARTAOVISA * 100) / $i;
        @$PERCENTUALCARTAOMASTER = ($NUMEROCARTAOMASTER * 100) / $i;
        @$PERCENTUALCARTAOHIPER = ($NUMEROCARTAOHIPER * 100) / $i;
        @$PERCENTUALOUTROS = ($NUMEROOUTROS * 100) / $i;
        @$PERCENTUALVALORDINHEIRO = ($DINHEIRO * 100) / $valortotal;
        @$PERCENTUALVALORCHEQUE = ($CHEQUE * 100) / $valortotal;
        @$PERCENTUALVALORCARTAOVISA = ($CARTAOVISA * 100) / $valortotal;
        @$PERCENTUALVALORCARTAOMASTER = ($CARTAOMASTER * 100) / $valortotal;
        @$PERCENTUALVALORCARTAOHIPER = ($CARTAOHIPER * 100) / $valortotal;
        @$PERCENTUALVALOROUTROS = ($OUTROS * 100) / $valortotal;
        @$VALORDINHEIRO = (str_replace("", ".", str_replace("", ",", $DINHEIRO))) / 100;
        @$VALORCHEQUE = (str_replace("", ".", str_replace("", ",", $CHEQUE))) / 100;
        @$VALORCARTAOVISA = (str_replace("", ".", str_replace("", ",", $CARTAOVISA))) / 100;
        @$VALORCARTAOMASTER = (str_replace("", ".", str_replace("", ",", $CARTAOMASTER))) / 100;
        @$VALORCARTAOHIPER = (str_replace("", ".", str_replace("", ",", $CARTAOHIPER))) / 100;
        @$VALOROUTROS = (str_replace("", ".", str_replace("", ",", $OUTROS))) / 100;
        ?>

        <!--        GRAFICO DE QUANTIDADE DE EXAMES
                <center><img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?= $NUMERODINHEIRO; ?>,<?= $NUMEROCHEQUE; ?>,<?= $NUMEROCARTAOVISA; ?>,<?= $NUMEROCARTAOMASTER; ?>,<?= $NUMEROCARTAOHIPER; ?>,<?= $NUMEROOUTROS; ?>&chtt=QUANTIDADE DE EXAMES&chs=600x300&chl=<?= number_format($PERCENTUALDINHEIRO, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCHEQUE, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOVISA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALOUTROS, 2, ',', '.'); ?>%&chdl=DINHEIRO|CHEQUE|CARTAO VISA|CARTAO MASTER|CARTAO HIPER|OUTROS&chco=c60000|1da3f8|58e015|fffc00|67087b|#5F9EA0" alt="" name="teste"/></center>
                GRAFICO DE VALOR DE EXAMES
                <center><img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?= $VALORDINHEIRO; ?>,<?= $VALORCHEQUE; ?>,<?= $VALORCARTAOVISA; ?>,<?= $VALORCARTAOMASTER; ?>,<?= $VALORCARTAOHIPER; ?>,<?= $VALOROUTROS; ?>&chtt=VALOR DOS EXAMES&chs=600x300&chl=<?= number_format($PERCENTUALVALORDINHEIRO, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCHEQUE, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOVISA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOHIPER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALOROUTROS, 2, ',', '.'); ?>%&chdl=DINHEIRO|CHEQUE|CARTAO VISA|CARTAO MASTER|CARTAO HIPER|OUTROS&chco=c60000|1da3f8|58e015|fffc00|67087b|#5F9EA0" alt="" name="teste2" /></center>-->


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



    $(function () {
        $("#accordion").accordion();
    });

</script>
