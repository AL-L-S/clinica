<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Laboratório Convenios</h4>
    <h4>DATA: <?= date("d/m/Y", strtotime($dataSelecionada)); ?></h4>
    <h4>Laboratório: <?= $laboratorio[0]->nome; ?></h4>


    <hr>
    <?
    if ($detalhes > 0) {
        $totalperc = 0;
        $valor_recebimento = 0;

        if (count($detalhes) > 0):
            ?>
            <table border="1">

                <thead>
                    <tr>
                        <th class="tabela_header"><font size="-1">Convenio</th>
                        <th class="tabela_header"><font size="-1">Nome</th>
                        <th class="tabela_header"><font size="-1">Qtde</th>
                        <th class="tabela_header" width="220px;"><font size="-1">Procedimento</th>
                        <th class="tabela_header" width="80px;"><font size="-1">Valor Laboratorio</th>
                        <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dados = array();
                    $vlrTotalDinheiro = 0;
                    $vlrTotalCartao = 0;
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
                    $totalgeral = 0;
                    $percpromotor = 0;
                    $totalgeralpromotor = 0;
                    $totalpercpromotor = 0;
                    $totalconsulta = 0;
                    $totalretorno = 0;
                    $taxaAdministracao = 0;
                    foreach ($detalhes as $item) :
                        $i++;
                        $procedimentopercentual = $item->procedimento_convenio_id;
                        $laboratoriopercentual = $item->laboratorio_id;
                        $valor_total = $item->valor_total;
                        ?>
                        <tr>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><font size="-2"><?= $item->paciente; ?></td>
                            <td ><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= $item->procedimento; ?></td>
                            <?
                            if ($item->percentual_laboratorio == "t") {
                                $simbolopercebtual = " %";

                                $valorpercentuallaboratorio = $item->valor_laboratorio/* - ((float) $item->valor_laboratorio * ((float) $item->taxa_administracao / 100)) */;

                                $perc = $valor_total * ($valorpercentuallaboratorio / 100);
                            } else {
                                $simbolopercebtual = "";
                                $valorpercentuallaboratorio = $item->valor_laboratorio/* - ((float) $item->valor_laboratorio * ((float) $item->taxa_administracao / 100)) */;

//                                    $perc = $valorpercentuallaboratorio;
                                $perc = $valorpercentuallaboratorio * $item->quantidade;
                            }

                            $totalperc = $totalperc + $perc;
                            $totalgeral = $totalgeral + $valor_total;
                            ?>

                            <td style='text-align: right;'><font size="-2"><?= number_format($valorpercentuallaboratorio, 2, ",", "") . $simbolopercebtual ?></td>

                            <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>
                        </tr>


                        <?php
                        $qtdetotal = $qtdetotal + $item->quantidade;
                    endforeach;

                    $resultadototalgeral = $totalgeral - $totalperc;
                    ?>
                    <tr>
                        <td ><font size="-1">TOTAL</td>
                        <td  colspan="2" style='text-align: right;'><font size="-1">Nr. Procedimentos: <?= $qtdetotal; ?></td>
                        <td colspan="9" style='text-align: right;'><font size="-1">TOTAL LABORATORIO: <?= number_format($totalperc, 2, ",", "."); ?></td>
                    </tr>
                </tbody>
            </table>
    <? endif; ?>



    </div>
    <?
} else {
    ?>
    <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <?
}
?>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

</script>