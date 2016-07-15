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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">FATURAMENTO POR GRUPO DE PRODUTO</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></th>
            </tr>
            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $relatorio[0]->grupo; ?></th>
                </tr>
            <? } ?>
            <? if ($conveniotipo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS CONVENIOS</th>
                </tr>
            <? } elseif ($conveniotipo == "-1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PARTICULARES</th>
                </tr>
            <? } elseif ($conveniotipo == "") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                </tr>
            <? } ?>
            <? if ($contador > 0) {
                ?>
            <table border="1">
                <thead>
                    <tr>
                        <th class="tabela_header"><font size="-1">Grupo</th>
                        <th class="tabela_header"><font size="-1">Paciente</th>
                        <th class="tabela_header"><font size="-1">Procedimento</th>
                        <th class="tabela_header"><font size="-1">Quantidade</th>
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
                    $qtde = 0;
                    $qtdetotal = 0;
                    $RX = 0;
                    $US = 0;
                    $DENSITOMETRIA = 0;
                    $MAMOGRAFIA = 0;
                    $RM = 0;
                    $NUMERORX = 0;
                    $NUMEROUS = 0;
                    $NUMERODENSITOMETRIA = 0;
                    $NUMEROMAMOGRAFIA = 0;
                    $NUMERORM = 0;
                    $AUDIOMETRIA = 0;
                    $NUMEROAUDIOMETRIA = 0;
                    $ELETROCARDIOGRAMA = 0;
                    $NUMEROELETROCARDIOGRAMA = 0;
                    $ELETROENCEFALOGRAMA = 0;
                    $NUMEROELETROENCEFALOGRAMA = 0;
                    $ESPIROMETRIA = 0;
                    $NUMEROESPIROMETRIA = 0;
                    $ECOCARDIOGRAMA = 0;
                    $NUMEROECOCARDIOGRAMA = 0;

                    foreach ($relatorio as $item) :
                        $i++;


                        if ($i == 1 || $item->convenio == $convenio) {
                            if ($i == 1) {
                                $y++;
                                ?>
                                <tr>
                                    <td colspan="5" bgcolor="#C0C0C0"><font ><?= $item->convenio; ?></td>
                                </tr>
                            <? }
                            ?>
                            <tr>
                                <td><font size="-2"><?= $item->grupo; ?></td>
                                <td><font size="-2"><?= $item->nome; ?></td>
                                <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>	
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>
                            </tr>
                            <?php
                            if ($item->grupo == "RX") {
                                $RX = $RX + $item->valor;
                                $NUMERORX = $NUMERORX + $item->quantidade;
                            }
                            if ($item->grupo == "US") {
                                $US = $US + $item->valor;
                                $NUMEROUS = $NUMEROUS + $item->quantidade;
                            }
                            if ($item->grupo == "DENSITOMETRIA") {
                                $DENSITOMETRIA = $DENSITOMETRIA + $item->valor;
                                $NUMERODENSITOMETRIA = $NUMERODENSITOMETRIA + $item->quantidade;
                            }
                            if ($item->grupo == "MAMOGRAFIA") {
                                $MAMOGRAFIA = $MAMOGRAFIA + $item->valor;
                                $NUMEROMAMOGRAFIA = $NUMEROMAMOGRAFIA + $item->quantidade;
                            }
                            if ($item->grupo == "RM") {
                                $RM = $RM + $item->valor;
                                $NUMERORM = $NUMERORM + $item->quantidade;
                            }
                            if ($item->grupo == "AUDIOMETRIA") {
                                $AUDIOMETRIA = $AUDIOMETRIA + $item->valor;
                                $NUMEROAUDIOMETRIA = $NUMEROAUDIOMETRIA + $item->quantidade;
                            }
                            if ($item->grupo == "ELETROCARDIOGRAMA") {
                                $ELETROCARDIOGRAMA = $ELETROCARDIOGRAMA + $item->valor;
                                $NUMEROELETROCARDIOGRAMA = $NUMEROELETROCARDIOGRAMA + $item->quantidade;
                            }
                            if ($item->grupo == "ELETROENCEFALOGRAMA") {
                                $ELETROENCEFALOGRAMA = $ELETROENCEFALOGRAMA + $item->valor;
                                $NUMEROELETROENCEFALOGRAMA = $NUMEROELETROENCEFALOGRAMA + $item->quantidade;
                            }
                            if ($item->grupo == "ESPIROMETRIA") {
                                $ESPIROMETRIA = $ESPIROMETRIA + $item->valor;
                                $NUMEROESPIROMETRIA = $NUMEROESPIROMETRIA + $item->quantidade;
                            }
                            if ($item->grupo == "ECOCARDIOGRAMA") {
                                $ECOCARDIOGRAMA = $ECOCARDIOGRAMA + $item->valor;
                                $NUMEROECOCARDIOGRAMA = $NUMEROECOCARDIOGRAMA + $item->quantidade;
                            }
                            $qtde = $qtde + $item->quantidade;
                            $qtdetotal = $qtdetotal + $item->quantidade;
                            $valor = $valor + $item->valor;
                            $valortotal = $valortotal + $item->valor;
                            $convenio = $item->convenio;
                        } else {
                            $convenio = $item->convenio;
                            ?>  
                            <tr>
                                <td ><font size="-1">TOTAL</td>
                                <td colspan="2"><font size="-1">Nr. Exa: <?= $qtde; ?></td>
                                <td colspan="2"><font size="-1">VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr>
                                <td colspan="5" bgcolor="#C0C0C0"><font ><?= $item->convenio; ?></td>
                            </tr>
                            <tr>
                                <td><font size="-2"><?= $item->grupo; ?></td>
                                <td><font size="-2"><?= $item->nome; ?></td>
                                <td><font size="-2"><?= $item->procedimento; ?></td>	
                                <td><font size="-2"><?= $item->quantidade; ?></td>
                                <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>
                            </tr>


                            <?
                            if ($item->grupo == "RX") {
                                $RX = $RX + $item->valor;
                                $NUMERORX = $NUMERORX + $item->quantidade;
                            }
                            if ($item->grupo == "US") {
                                $US = $US + $item->valor;
                                $NUMEROUS = $NUMEROUS + $item->quantidade;
                            }
                            if ($item->grupo == "DENSITOMETRIA") {
                                $DENSITOMETRIA = $DENSITOMETRIA + $item->valor;
                                $NUMERODENSITOMETRIA = $NUMERODENSITOMETRIA + $item->quantidade;
                            }
                            if ($item->grupo == "MAMOGRAFIA") {
                                $MAMOGRAFIA = $MAMOGRAFIA + $item->valor;
                                $NUMEROMAMOGRAFIA = $NUMEROMAMOGRAFIA + $item->quantidade;
                            }
                            if ($item->grupo == "RM") {
                                $RM = $RM + $item->valor;
                                $NUMERORM = $NUMERORM + $item->quantidade;
                            }
                            if ($item->grupo == "AUDIOMETRIA") {
                                $AUDIOMETRIA = $AUDIOMETRIA + $item->valor;
                                $NUMEROAUDIOMETRIA = $NUMEROAUDIOMETRIA + $item->quantidade;
                            }
                            if ($item->grupo == "ELETROCARDIOGRAMA") {
                                $ELETROCARDIOGRAMA = $ELETROCARDIOGRAMA + $item->valor;
                                $NUMEROELETROCARDIOGRAMA = $NUMEROELETROCARDIOGRAMA + $item->quantidade;
                            }
                            if ($item->grupo == "ELETROENCEFALOGRAMA") {
                                $ELETROENCEFALOGRAMA = $ELETROENCEFALOGRAMA + $item->valor;
                                $NUMEROELETROENCEFALOGRAMA = $NUMEROELETROENCEFALOGRAMA + $item->quantidade;
                            }
                            if ($item->grupo == "ESPIROMETRIA") {
                                $ESPIROMETRIA = $ESPIROMETRIA + $item->valor;
                                $NUMEROESPIROMETRIA = $NUMEROESPIROMETRIA + $item->quantidade;
                            }
                            if ($item->grupo == "ECOCARDIOGRAMA") {
                                $ECOCARDIOGRAMA = $ECOCARDIOGRAMA + $item->valor;
                                $NUMEROECOCARDIOGRAMA = $NUMEROECOCARDIOGRAMA + $item->quantidade;
                            }
                            $qtde = 0;
                            $qtde = $qtde + $item->quantidade;
                            $qtdetotal = $qtdetotal + $item->quantidade;
                            $valor = 0;
                            $valor = $valor + $item->valor;
                            $valortotal = $valortotal + $item->valor;
                            $y = 0;
                        }
                    endforeach;
                    ?>
                    <tr>
                        <td ><font size="-1">TOTAL</td>
                        <td colspan="2"><font size="-1">Nr. Exa: <?= $qtde; ?></td>
                        <td width="200px;" colspan="2"><font size="-1">VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <?
            if ($conveniotipo == "0") {
                ?>
                <table BORDER="1">
                    <tbody>
                        <tr>
                            <td width="140px;" colspan="4" bgcolor="#C0C0C0"><center><font size="-1">Resumo da Clinica</center></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">RAIOX</td>
                        <td width="140px;"><font size="-1"><?= $NUMERORX; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"> <?= number_format($RX, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">US</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROUS; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"> <?= number_format($US, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">DENSITOMETRIA</td>
                        <td width="140px;"><font size="-1"><?= $NUMERODENSITOMETRIA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($DENSITOMETRIA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">MAMOGRAFIA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROMAMOGRAFIA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($MAMOGRAFIA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">RM</td>
                        <td width="140px;"><font size="-1"><?= $NUMERORM; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($RM, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">AUDIOMETRIA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROAUDIOMETRIA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($AUDIOMETRIA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">ELETROCARDIOGRAMA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROELETROCARDIOGRAMA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($ELETROCARDIOGRAMA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">ELETROENCEFALOGRAMA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROELETROENCEFALOGRAMA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($ELETROENCEFALOGRAMA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">ESPIROMETRIA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROESPIROMETRIA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($ESPIROMETRIA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">AUDIOMETRIA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROAUDIOMETRIA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($AUDIOMETRIA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">ELETROCARDIOGRAMA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROELETROCARDIOGRAMA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($ELETROCARDIOGRAMA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">ESPIROMETRIA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROESPIROMETRIA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($ESPIROMETRIA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">ECOCARDIOGRAMA</td>
                        <td width="140px;"><font size="-1"><?= $NUMEROECOCARDIOGRAMA; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1"><?= number_format($ECOCARDIOGRAMA, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td width="140px;"><font size="-1">TOTAL GERAL</td>
                        <td width="140px;"><font size="-1"><?= $qtdetotal; ?></td>
                        <td><font size="-2"></td>
                        <td width="200px;"><font size="-1">Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></td>
                    </tr>
                    </tbody>

                </table>
            <? } ?>
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
