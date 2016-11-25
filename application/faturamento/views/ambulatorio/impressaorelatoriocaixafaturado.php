<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>CONFERENCIA CAIXA</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <? if ($contador > 0 && $operador != 0) { ?>
        <h3>ATENDENTE: <?= $relatorio[0]->nomefaturamento; ?></h3>
    <? } ?>
    <? if ($operador == 0) { ?>
        <h3>ATENDENTE: TODOS</h3>
    <? } ?>
    <hr>
    <?
    if ($contador > 0) {
        ?>
        <table >
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Atendimento</th>
                    <th class="tabela_header"><font size="-1">Emissao</th>
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Exame</th>
                    <th class="tabela_header"><font size="-1">F. Pagamento</th>
                    <th class="tabela_header"><font size="-1">QTDE</th>
                    <th class="tabela_header" width="80px;"><font size="-1">V. Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $b = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $y = 0;
                $DINHEIRO = 0;
                $NUMERODINHEIRO = 0;
                $DEBITO_CONTA = 0;
                $NUMERODEBITO_CONTA = 0;
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
                $exame = "";

                foreach ($relatorio as $item) :

                    $i++;
                    $b++;
                    if ($item->financeiro == 't') {
                        $financeiro = 't';
                    }
                    if ($item->exames_id == "") {
                        $exame = 'f';
                    }
                    if ($item->faturado == "f") {
                        $faturado = 'f';
                    }

                    $valortotal = $valortotal + $item->valor_total;

                    if ($i == 1 || $item->nomefaturamento == $operadorexames) {

                        $valoroperador = $valoroperador + $item->valor_total;
                        $qtdepaciente++;
                        $qtdeexame++;
                        if ($i == 1) {
                            ?>
                            <tr>
                                <td colspan="8"><font ><b>Operador:&nbsp;<?= utf8_decode($item->nomefaturamento); ?></b></td>
                            </tr>
                        <? }
                        ?>
                        <tr>
                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><font size="-2"><?= $item->guia_id; ?></td>
                                <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?>
                                    <? if ($item->verificado == 't') {
                                        ?>&Sqrt;<? }
                                    ?>
                                </td>
                                <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                            <? } ?>
                            <td><font size="-2"><?= utf8_decode($item->exame); ?></td>
                            <? if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 != '') { ?>
                                <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                        <font size="-2"><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?><br><?= $item->forma_pagamento_4; ?></a></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>

                                    <?
                                }
                            }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 == '') {
                                ?>
                                <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                        <font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?></a></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?></td>

                                    <?
                                }
                            }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                ?>
                                <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                        <font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?></a></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?></td>

                                    <?
                                }
                            }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                ?>
                                <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                        <font size="-2"><?= $item->forma_pagamento; ?></font>
                                    </a></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?> 
                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/valoralterado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-1">  --(*)</font>
                                        </a></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?></td>

                                    <?
                                }
                            } if ($item->forma_pagamento == '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                ?>
                                <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                        <font size="-2"><?= $item->forma_pagamento; ?></font>
                                    </a></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?> 
                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/valoralterado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-1">  --(*)</font>
                                        </a></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?></td>

                                    <?
                                }
                            }
                            if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 != '') {
                                ?>
                                <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                        <font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_4; ?></a></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>

                                    <?
                                }
                            }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 != '') {
                                ?>
                                <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                        <font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_4; ?></font>
                                    </a></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>

                                    <?
                                }
                            }
                            ?>
                        </tr>

                        <?php
                        if ($item->forma_pagamento == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor1;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento == "DEBITO CONTA") {
                            $DEBITO_CONTA= $DEBITO_CONTA + $item->valor1;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor1;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor1;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento == "HIPER CARD") {
                            $CARTAOHIPER = $CARTAOHIPER + $item->valor1;
                            $NUMEROCARTAOHIPER++;
                        }
                        if ($item->forma_pagamento == "") {
                            $OUTROS = $OUTROS + $item->valor_total;
                            $NUMEROOUTROS++;
                        }
                        if ($item->forma_pagamento_2 == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor2;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento_2 == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor2;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento_2 == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor2;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento_2 == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor2;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento_2 == "HIPER CARD") {
                            $CARTAOHIPER = $CARTAOHIPER + $item->valor2;
                            $NUMEROCARTAOHIPER++;
                        }
                        if ($item->forma_pagamento_3 == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor3;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento_3 == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor3;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento_3 == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor3;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento_3 == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor3;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento_3 == "HIPER CARD") {
                            $CARTAOHIPER = $CARTAOHIPER + $item->valor3;
                            $NUMEROCARTAOHIPER++;
                        }
                        if ($item->forma_pagamento_4 == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor4;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento_4 == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor4;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento_4 == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor4;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento_4 == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor4;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento_4 == "HIPER CARD") {
                            $CARTAOHIPER = $CARTAOHIPER + $item->valor4;
                            $NUMEROCARTAOHIPER++;
                        }

                        $y++;
                        $valor = $valor + $item->valor_total;
                        $paciente = $item->paciente;
                        $operadorexames = $item->nomefaturamento;
                    } else {
                        $operadorexames = $item->nomefaturamento;
                        $paciente = "";
                        ?> 

                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>TOTAL</b></td>
                </tr>
                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>Nr. Exa: <?= $y; ?></b></td>
                </tr>
                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></b></td>
                </tr>
                        <tr>
                            <td colspan="8"><font ><b>Operador:&nbsp;<?= utf8_decode($item->nomefaturamento); ?></b></td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>


                        <tr>
                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><font size="-2"><?= $item->guia_id; ?></td>
                                <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                            <? } ?>
                            <td><font size="-2"><?= utf8_decode($item->exame); ?></td>
                            <? if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 != '') { ?>
                                <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?><br><?= $item->forma_pagamento_4; ?></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>

                                    <?
                                }
                            }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 == '') {
                                ?>
                                <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?></td>

                                    <?
                                }
                            }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                ?>
                                <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?></td>

                                    <?
                                }
                            }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                ?>
                                <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?></td>

                                    <?
                                }
                            } if ($item->forma_pagamento == '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                ?>
                                <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <? if ($item->operador_editar != '') { ?>
                                    <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') . " (*)" ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?></td>

                                    <?
                                }
                            }
                            ?>
                        </tr>
                        <?
                        if ($item->forma_pagamento == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor1;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor1;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor1;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor1;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento == "HIPER CARD") {
                            $CARTAOHIPER = $CARTAOHIPER + $item->valor1;
                            $NUMEROCARTAOHIPER++;
                        }
                        if ($item->forma_pagamento == "") {
                            $OUTROS = $OUTROS + $item->valor_total;
                            $NUMEROOUTROS++;
                        }
                        if ($item->forma_pagamento_2 == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor2;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento_2 == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor2;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento_2 == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor2;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento_2 == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor2;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento_2 == "HIPER CARD") {
                            $CARTAOHIPER = $CARTAOHIPER + $item->valor2;
                            $NUMEROCARTAOHIPER++;
                        }
                        if ($item->forma_pagamento_3 == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor3;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento_3 == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor3;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento_3 == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor3;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento_3 == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor3;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento3 == "HIPER CARD") {
                            $CARTAOHIPER = $CARTAOHIPER + $item->valor3;
                            $NUMEROCARTAOHIPER++;
                        }
                        if ($item->forma_pagamento_4 == "DINHEIRO") {
                            $DINHEIRO = $DINHEIRO + $item->valor4;
                            $NUMERODINHEIRO++;
                        }
                        if ($item->forma_pagamento_4 == "DEBITO CONTA") {
                            $DEBITO_CONTA = $DEBITO_CONTA + $item->valor4;
                            $NUMERODEBITO_CONTA++;
                        }
                        if ($item->forma_pagamento_4 == "CARTAO VISA") {
                            $CARTAOVISA = $CARTAOVISA + $item->valor4;
                            $NUMEROCARTAOVISA++;
                        }
                        if ($item->forma_pagamento_4 == "CARTAO MASTER") {
                            $CARTAOMASTER = $CARTAOMASTER + $item->valor4;
                            $NUMEROCARTAOMASTER++;
                        }
                        if ($item->forma_pagamento_4 == "HIPER CARD") {
                            $CARTAOHIPER = $CARTAOHIPER + $item->valor4;
                            $NUMEROCARTAOHIPER++;
                        }
                        $valor = 0;
                        $valor = $valor + $item->valor_total;
                        $y = 0;
                        $y++;
                    }
                endforeach;
                ?>
            <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharcaixa" method="post">
                <input type="hidden" class="texto3" name="dinheiro" value="<?= number_format($DINHEIRO, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="cheque" value="<?= number_format($DEBITO_CONTA, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="cartaovisa" value="<?= number_format($CARTAOVISA, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="cartaomaster" value="<?= number_format($CARTAOMASTER, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="cartaohiper" value="<?= number_format($CARTAOHIPER, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="outros" value="<?= number_format($OUTROS, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>
                <input type="hidden" class="texto3" name="grupo" value="<?= $grupo; ?>"/>

                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>TOTAL</b></td>
                </tr>
                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>Nr. Exa: <?= $y; ?></b></td>
                </tr>
                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></b></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                                <tr>
                    <td colspan="5"></td>
                    <? if ($faturado == 't' && $exame == "") { ?>
                        <? if ($operador == 0 && $financeiro == 'f') { ?>
                            <td colspan="2" ><font size="-1"><button type="submit" name="btnEnviar">Fechar Caixa</button></td>
                        <? } else {
                            ?>
                            <td colspan="2" ><b>Caixa Fechado</b></td>
                        <? } ?>
                    <? } else { ?>
                        <td colspan="3" ><b>Pendencias de Faturamento / Finalizar exame</b></td>
                    <? } ?>
                </tr>


            </form>
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
                <td width="140px;"><font size="-1">DEBITO_CONTA </td>
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
                <td width="140px;"><font size="-1">HIPER CARD</td>
                <td width="140px;"><font size="-1"><?= $NUMEROCARTAOHIPER; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1"><?= number_format($CARTAOHIPER, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td width="140px;"><font size="-1">PENDENCIAS</td>
                <td width="140px;"><font size="-1"><?= $NUMEROOUTROS; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1"><?= number_format($OUTROS, 2, ',', '.'); ?></td>
            </tr>
            <?
            $TOTALCARTAO = $CARTAOVISA + $CARTAOMASTER + $CARTAOHIPER;
            $QTDECARTAO = $NUMEROCARTAOVISA + $NUMEROCARTAOMASTER + $NUMEROCARTAOHIPER;
            ?>
            <tr>
                <td width="140px;"><font size="-1">TOTAL CARTAO</td>
                <td width="140px;"><font size="-1">Nr. Cart&otilde;es: <?= $QTDECARTAO; ?></td>
                <td><font size="-2"></td>
                <td width="200px;"><font size="-1">Total Cartao: <?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
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
        <?
        $PERCENTUALDINHEIRO = ($NUMERODINHEIRO * 100) / $i;
        $PERCENTUALDEBITO_CONTA = ($NUMERODEBITO_CONTA  * 100) / $i;
        $PERCENTUALCARTAOVISA = ($NUMEROCARTAOVISA * 100) / $i;
        $PERCENTUALCARTAOMASTER = ($NUMEROCARTAOMASTER * 100) / $i;
        $PERCENTUALCARTAOHIPER = ($NUMEROCARTAOHIPER * 100) / $i;
        $PERCENTUALOUTROS = ($NUMEROOUTROS * 100) / $i;
        $PERCENTUALVALORDINHEIRO = ($DINHEIRO * 100) / $valortotal;
        $PERCENTUALVALORDEBITO_CONTA = ($DEBITO_CONTA * 100) / $valortotal;
        $PERCENTUALVALORCARTAOVISA = ($CARTAOVISA * 100) / $valortotal;
        $PERCENTUALVALORCARTAOMASTER = ($CARTAOMASTER * 100) / $valortotal;
        $PERCENTUALVALORCARTAOHIPER = ($CARTAOHIPER * 100) / $valortotal;
        $PERCENTUALVALOROUTROS = ($OUTROS * 100) / $valortotal;
        $VALORDINHEIRO = (str_replace("", ".", str_replace("", ",", $DINHEIRO))) / 100;
        $VALORDEBITO_CONTA = (str_replace("", ".", str_replace("", ",", $DEBITO_CONTA))) / 100;
        $VALORCARTAOVISA = (str_replace("", ".", str_replace("", ",", $CARTAOVISA))) / 100;
        $VALORCARTAOMASTER = (str_replace("", ".", str_replace("", ",", $CARTAOMASTER))) / 100;
        $VALORCARTAOHIPER = (str_replace("", ".", str_replace("", ",", $CARTAOHIPER))) / 100;
        $VALOROUTROS = (str_replace("", ".", str_replace("", ",", $OUTROS))) / 100;
        ?>

        <!--        GRAFICO DE QUANTIDADE DE EXAMES
                <center><img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?= $NUMERODINHEIRO; ?>,<?= $NUMERODEBITO_CONTA; ?>,<?= $NUMEROCARTAOVISA; ?>,<?= $NUMEROCARTAOMASTER; ?>,<?= $NUMEROCARTAOHIPER; ?>,<?= $NUMEROOUTROS; ?>&chtt=QUANTIDADE DE EXAMES&chs=600x300&chl=<?= number_format($PERCENTUALDINHEIRO, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALDEBITO_CONTA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOVISA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALOUTROS, 2, ',', '.'); ?>%&chdl=DINHEIRO|DEBITO_CONTA |CARTAO VISA|CARTAO MASTER|CARTAO HIPER|OUTROS&chco=c60000|1da3f8|58e015|fffc00|67087b|#5F9EA0" alt="" name="teste"/></center>
                GRAFICO DE VALOR DE EXAMES
                <center><img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?= $VALORDINHEIRO; ?>,<?= $VALORDEBITO_CONTA; ?>,<?= $VALORCARTAOVISA; ?>,<?= $VALORCARTAOMASTER; ?>,<?= $VALORCARTAOHIPER; ?>,<?= $VALOROUTROS; ?>&chtt=VALOR DOS EXAMES&chs=600x300&chl=<?= number_format($PERCENTUALVALORDINHEIRO, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORDEBITO_CONTA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOVISA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOHIPER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALOROUTROS, 2, ',', '.'); ?>%&chdl=DINHEIRO|DEBITO_CONTA |CARTAO VISA|CARTAO MASTER|CARTAO HIPER|OUTROS&chco=c60000|1da3f8|58e015|fffc00|67087b|#5F9EA0" alt="" name="teste2" /></center>-->


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
