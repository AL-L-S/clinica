<div class="content"> <!-- Inicio da DIV content -->


    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Medico Convenios</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <? if ($medico == 0) { ?>
        <h4>TODOS</h4>
    <? } else { ?>
        <h4>Medico: <?= $medico[0]->operador; ?></h4>
    <? } ?>
    <hr>
    <? if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Medico</th>
                    <th class="tabela_header"><font size="-1">Data</th>
                    <th class="tabela_header"><font size="-1">Qtde</th>
                    <th class="tabela_header" width="220px;"><font size="-1">Procedimento</th>
                    <? if ($clinica == 'SIM') { ?>
                        <th class="tabela_header" ><font size="-1">Valor</th>
                    <? } ?>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor Medico</th>
                    <? if ($clinica == 'SIM') { ?>
                        <th class="tabela_header" width="80px;"><font size="-1">Valor Total</th>
                    <? } ?>
                    <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor</th>
                    <? if ($solicitante == 'SIM') { ?>
                        <th class="tabela_header" width="80px;"><font size="-1">Solicitante</th>
                    <? } ?>
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
                $resultado = 0;
                $simbolopercebtual = " %";
                $iss = 0;
                $perc = 0;
                $totalperc = 0;
                $totalgeral = 0;
                $totalconsulta = 0;
                $totalretorno = 0;
                foreach ($relatorio as $item) :
                    $i++;
                    $procedimentopercentual = $item->procedimento_convenio_id;
                    $medicopercentual = $item->medico_parecer1;
                    $percentual = $this->guia->percentualmedicoconvenio($procedimentopercentual, $medicopercentual);
                    $testearray = count($percentual);
                    if ($item->classificacao == 1) {
                        $totalconsulta++;
                    }
                    if ($item->classificacao == 2) {
                        $totalretorno++;
                    }
                    ?>
                    <tr>
                        <td><font size="-2"><?= $item->convenio; ?></td>
                        <td><font size="-2"><?= $item->paciente; ?></td>
                        <td><font size="-2"><?= $item->medico; ?></td>
                        <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td ><font size="-2"><?= $item->quantidade; ?></td>
                        <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                        <? if ($clinica == 'SIM') { ?>
                            <td style='text-align: right;'><font size="-2"><?= number_format($item->valor_total, 2, ",", "."); ?></td>
                        <? } ?>
                        <?
                        if ($item->percentual == "t") {
                            $simbolopercebtual = " %";
                            if ($testearray > 0) {
                                $valorpercentualmedico = $percentual[0]->valor;
                            } else {
                                $valorpercentualmedico = $item->perc_medico;
                            }
                            $perc = $item->valor_total * ($valorpercentualmedico / 100);
                            $totalperc = $totalperc + $perc;
                            $totalgeral = $totalgeral + $item->valor_total;
                        } else {
                            $simbolopercebtual = "";
                            if ($testearray > 0) {
                                $valorpercentualmedico = $percentual[0]->valor;
                            } else {
                                $valorpercentualmedico = $item->perc_medico;
                            }
                            $perc = $valorpercentualmedico;
                            $totalperc = $totalperc + $perc;
                            $totalgeral = $totalgeral + $item->valor_total;
                        }
                        ?>
                        <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>

                        <? $valor_total = $item->valor_total + $perc; ?>
                        <? if ($clinica == 'SIM') { ?>
                            <td style='text-align: right;'><font size="-2"><?= number_format($valor_total, 2, ",", "."); ?></td>
                        <? } ?>

                        <td style='text-align: right;'><font size="-2"><?= $valorpercentualmedico . $simbolopercebtual ?></td>
                        <? if ($solicitante == 'SIM') { ?>
                            <td style='text-align: right;'><font size="-2"><?= $item->medicosolicitante; ?></td>
                        <? } ?>
                    </tr>


                    <?php
                    $qtdetotal = $qtdetotal + $item->quantidade;
                endforeach;
                $resultadototalgeral = $totalgeral - $totalperc;
                ?>
                <tr>
                    <td ><font size="-1">TOTAL</td>
                    <td style='text-align: right;'><font size="-1">Nr. Procedimentos: <?= $qtdetotal; ?></td>
                    <? if ($clinica == 'SIM') { ?>
                        <td colspan="3" style='text-align: right;'><font size="-1">VALOR TOTAL CLINICA: <?= number_format($resultadototalgeral, 2, ",", "."); ?></td>
                    <? } else { ?>
                        <td colspan="3" style='text-align: right;'><font size="-1">&nbsp;</td>
                    <? } ?>
                    <td colspan="3" style='text-align: right;'><font size="-1">VALOR TOTAL MEDICO: <?= number_format($totalperc, 2, ",", "."); ?></td>
                </tr>
            </tbody>
        </table>
        <?
    } else {
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
