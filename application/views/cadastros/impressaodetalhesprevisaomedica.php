<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Medico Convenios</h4>
    <h4>Data: <?=date("d/m/Y", strtotime($dataSelecionada) ); ?></h4>
    <h4>Medico: <?= @$medico[0]->operador; ?></h4>
    <hr>
    <meta charset="utf-8"/>
    <? if (count($detalhes) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Qtde</th>
                    <th class="tabela_header" width="220px;"><font size="-1">Procedimento</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor Medico</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor</th>
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
                $taxaAdministracao = 0;
                foreach ($detalhes as $item) :
                    $i++;
                    $procedimentopercentual = $item->procedimento_convenio_id;
                    $medicopercentual = $item->medico_parecer1;
                    $percentual = $this->guia->percentualmedicoconvenio($procedimentopercentual, $medicopercentual);
                    $testearray = count($percentual);
                    ?>
                    <tr>
                        <td><font size="-2"><?= $item->convenio; ?></td>
                        <td><font size="-2"><?= $item->paciente; ?></td>
                        <td ><font size="-2"><?= $item->quantidade; ?></td>
                        <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                        <?
                        if ($testearray > 0) {
                            if($percentual[0]->percentual == 't'){
                                $valorpercentualmedico = $percentual[0]->valor;
                                $perc = ($item->valor_total) * ($valorpercentualmedico / 100);
                            }
                            else{
                                $valorpercentualmedico = $percentual[0]->valor;
                                $perc = $valorpercentualmedico;
                            }
                            $totalperc = $totalperc + $perc;
                            $totalgeral = $totalgeral + $item->valor_total;
                        }
                        else {
                            if ($item->percentual == "t") {
                                $valorpercentualmedico = $item->perc_medico;
                                $perc = ($item->valor_total) * ($valorpercentualmedico / 100);
                            }
                            else{
                                $valorpercentualmedico = $item->perc_medico;
                                $perc = $valorpercentualmedico;
                            }
                            $totalperc = $totalperc + $perc;
                            $totalgeral = $totalgeral + $item->valor_total;
                        }
                        $valor_total = $item->valor_total + $perc;
                        ?>
                        <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>

                        <td style='text-align: right;'><font size="-2"><?=  number_format($valorpercentualmedico, 2, ",", ".") . $simbolopercebtual ?></td>
                    </tr>
                    <?php
                    $qtdetotal = $qtdetotal + $item->quantidade;
                endforeach;
                
                $resultadototalgeral = $totalgeral - $totalperc;
                ?>
                <tr>
                    <td><font size="-1">TOTAL</td>
                    <td colspan="2" style='text-align: right;'><font size="-1">Nr. Procedimentos: <?= $qtdetotal; ?></td>
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
