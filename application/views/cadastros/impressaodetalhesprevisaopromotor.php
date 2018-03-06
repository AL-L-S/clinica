<div class="content"> <!-- Inicio da DIV content -->
    <meta charset="utf-8"/>
    <table>
        <thead>

            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
                <?
                $tipoempresa = $empresa[0]->razao_social;
            } else {
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
                <?
                $tipoempresa = 'TODAS';
            }
            ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROMOTOR: <?= $indicacao[0]->indicacao; ?></th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">DATA: <?= date("d/m/Y", strtotime($dataSelecionada)); ?></th>
            </tr>

        </thead>
    </table>

    <? if (count($detalhes) > 0) {
        ?>

        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_teste">Nome</th>
                    <th class="tabela_teste">Promotor</th>
                    <th class="tabela_teste">Procedimento</th>
                    <th class="tabela_teste">Valor do Promotor</th>
                    <th class="tabela_teste">Valor Recebido R$</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $resultado = 0;
                $i = 0;
                $b = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $tecnicos = "";
                $paciente = "";
                $perc = 0;
                $totalgeral = 0;
                $totalperc = 0;
                foreach ($indicacao_valor as $value) {
                    $data[$value->nome] = '';
                    $numero[$value->nome] = 0;
                    $valor[$value->nome] = 0;
                }
//                    var_dump($data); die;

                foreach ($detalhes as $item) :
                    $i++;
                    $qtdetotal++;
                    $valor_total = $item->valor_total;

                    if ($item->percentual_promotor == "t") {
                        $simbolopercebtual = " %";

                        $valorpercentualmedico = $item->valor_promotor;

                        $perc = $valor_total * ($valorpercentualmedico / 100);
                        $totalperc = $totalperc + $perc;
                        $totalgeral = $totalgeral + $valor_total;
                        $data[$item->indicacao] = $item->indicacao;
                        $numero[$item->indicacao] ++;
                        $valor[$item->indicacao] = $valor[$item->indicacao] + $perc;
                        $valor_promotor = $item->valor_promotor . $simbolopercebtual;
                    } else {
                        $simbolopercebtual = "";
                        $valorpercentualmedico = $item->valor_promotor;

                        $perc = $valorpercentualmedico;
                        $totalperc = $totalperc + $perc;
                        $totalgeral = $totalgeral + $valor_total;
                        $data[$item->indicacao] = $item->indicacao;
                        $numero[$item->indicacao] ++;
                        $valor[$item->indicacao] = $valor[$item->indicacao] + $perc;
                        $valor_promotor = "R$ " . number_format($item->valor_promotor, 2, ",", ".");
                    }

                    $resultado += $perc;
                    ?>
                    <tr>

                        <td><?= utf8_decode($item->paciente); ?></td>

                        <td style='text-align: center;'><font size="-2"><?= $item->indicacao; ?></td>
                        <td style='text-align: center;'><font size="-2"><?= $item->procedimento ?></td>
                        <td style='text-align: center;'><font size="-2"><?= $valor_promotor ?></td>
                        <td style='text-align: center;'><font size="-1"><?= "R$ " . number_format($perc, 2, ",", "."); ?></td>
                    </tr>
                <? endforeach; ?>

                <tr>
                    <td width="140px;" align="Right" colspan="4"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>
        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>js/morris/morris.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
