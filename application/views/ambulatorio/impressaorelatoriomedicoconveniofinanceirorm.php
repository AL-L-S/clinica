<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <h4>HUMANA IMAGEM</h4>
    <h4>Medico Convenios RM</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <h4>Medico: <?= $medico[0]->operador; ?></h4>
    <hr>
    <? if ($contador > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Data</th>
                    <th class="tabela_header"><font size="-1">Quantidade</th>
                    <th class="tabela_header" width="220px;"><font size="-1">Procedimento</th>
                    <th class="tabela_header" width="100px;"><font size="-1">Laudo</th>
                    <th class="tabela_header" ><font size="-1">Revisor</th>
                    <!--<th class="tabela_header" width="80px;"><font size="-1">Valor</th>-->
                    <th class="tabela_header" width="80px;"><font size="-1">Indice Revisor</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor Revisor </th>
                    <th class="tabela_header" width="80px;"><font size="-1">Indice Médico</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor Médico</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $valortotalexames = 0;
                $totalrevisor = 0;
                $convenio = "";
                $y = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $totalgeral = 0;
                $percpromotor = 0;
                $totalgeralrevisor = 0;
                $totalpercrevisor = 0;
                $totalconsulta = 0;
                $totalretorno = 0;
                $taxaAdministracao = 0;
                $valor_semrevisor = 0;
                $totalperc = 0;
                $qtde_semrevisor = 0;
                foreach ($relatorio as $item) :
                    $valor_total = $item->valor_total;
                    $i++;
                    if ($item->percentual_revisor == "t") {
                        $simbolopercebtualrevisor = " %";

                        $valorpercentualrevisor = $item->valor_revisor/* - ((float) $item->valor_revisor * ((float) $item->taxa_administracao / 100)) */;

                        $percrevisor = $valor_total * ($valorpercentualrevisor / 100);
                    } else {
                        $simbolopercebtualrevisor = "";
                        $valorpercentualrevisor = $item->valor_revisor/* - ((float) $item->valor_revisor * ((float) $item->taxa_administracao / 100)) */;

//                        $percrevisor = $valorpercentualrevisor;
                        $percrevisor = $valorpercentualrevisor * $item->quantidade;
                    }

                    $totalpercrevisor = $totalpercrevisor + $percrevisor;
                    $totalgeralrevisor = $totalgeralrevisor + $valor_total;


                    if ($item->percentual_medico == "t") {
                        $simbolopercebtual = " %";

                        $valorpercentualmedico = $item->valor_medico/* - ((float) $item->valor_medico * ((float) $item->taxa_administracao / 100)) */;

                        $perc = $valor_total * ($valorpercentualmedico / 100);
                    } else {
                        $simbolopercebtual = "";
                        $valorpercentualmedico = $item->valor_medico/* - ((float) $item->valor_medico * ((float) $item->taxa_administracao / 100)) */;

//                        $perc = $valorpercentualmedico;
                        $perc = $valorpercentualmedico * $item->quantidade;
                    }
                    if ($item->valor_revisor != '') {
                        $valor_medico = $perc - $percrevisor;
                    } else {
                        $valor_medico = $perc;
                        $valor_semrevisor = $valor_semrevisor + $perc;
                        $qtde_semrevisor++;
                    }

                    $totalperc = $totalperc + $perc;
                    $totalgeral = $totalgeral + $valor_total;
                    $valortotalexames = $valortotalexames + $valor_medico;
                    ?>
                    <tr>
                        <td><font size="-2"><?= $item->convenio; ?></td>
                        <td><font size="-2"><?= $item->paciente; ?></td>
                        <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td><font size="-2"><?= $item->quantidade; ?></td>
                        <td><font size="-2"><?= $item->procedimento; ?></td>
                        <td><font size="-2"><?= $item->situacaolaudo; ?></td>
                        <td><font size="-2"><?= substr($item->revisor, 0, 20); ?></td>

                        <td><font size="-2"><?= $item->valor_revisor . $simbolopercebtualrevisor ?></td>
                        <td><font size="-2"> R$ <?= number_format($percrevisor, 2, ',', '.'); ?></td>
                        <td><font size="-2"><?= $item->valor_medico . $simbolopercebtual ?></td>
                        <td><font size="-2"> R$ <?= number_format($valor_medico, 2, ',', '.'); ?></td>
                    </tr>


                    <?php
                    $qtdetotal = $qtdetotal + $item->quantidade;
                endforeach;
                ?>
                <tr>
                    <td ><font size="-1">TOTAL GERAL</td>
                    <td colspan="3"><font size="-1"><center><?= $qtdetotal; ?></center></td>
            <td colspan="4"><font size="-1"><center>R$ <?= number_format($valortotalexames, 2, ',', '.'); ?></center></td>
            </tr>
            </tbody>
        </table>
        <?
    } else {
        $y = 0;
        $valor = 0;
        ?>
        <h4>Medico: <?= $medico[0]->operador; ?>, n&atilde;o fez laudo</h4>
        <?
    }
    if (count($revisada) > 0) {
        ?>
        <hr>
        <table border="1">
            <tr>
                <th class="tabela_header"><font size="-1">Medico</th>
                <th class="tabela_header"><font size="-1">QTDE</th>
                <!--<th class="tabela_header"><font size="-1">Valor Unit.</th>-->
                <th class="tabela_header"><font size="-1">Total Bruto</th>
            </tr>
            <tr>
                <td ><font size="-1"><b>SEM REVISOR</b></td>
                <td ><font size="-1"><?= @$qtde_semrevisor ?></td>
                <!--<td ><font size="-1">Novo(R$ 50,00) Antigo (R$ 75,00)</td>-->



                <td ><font size="-1">R$<?= number_format(@$valor_semrevisor, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="4"><font size="-1"><center><b>COM REVISOR</b></center></td>
            </tr>
            <?
            $valortotal = $valor;
            $qtdetotal = $y;
            foreach ($revisorunico as $value) {
                $datac[$value->revisor] = 0;
                $numeroc[$value->revisor] = 0;
                $descontoc[$value->revisor] = 0;
            }
//            var_dump($revisor); die;

            foreach ($revisor as $items) :
                if ($items->revisor != "") {
                    $valor_total = $items->valor_total;
                    if ($items->percentual_revisor == "t") {
                        $simbolopercebtualrevisor = " %";

                        $valorpercentualrevisor = $items->valor_revisor/* - ((float) $item->valor_revisor * ((float) $item->taxa_administracao / 100)) */;

                        $percrevisor = $valor_total * ($valorpercentualrevisor / 100);
                    } else {
                        $simbolopercebtualrevisor = "";
                        $valorpercentualrevisor = $items->valor_revisor/* - ((float) $item->valor_revisor * ((float) $item->taxa_administracao / 100)) */;

//                        $percrevisor = $valorpercentualrevisor;
                        $percrevisor = $valorpercentualrevisor * $items->quantidade;
                    }

                    if ($items->percentual_medico == "t") {
                        $simbolopercebtual = " %";

                        $valorpercentualmedico = $items->valor_medico/* - ((float) $items->valor_medico * ((float) $items->taxa_administracao / 100)) */;

                        $perc = $valor_total * ($valorpercentualmedico / 100);
                    } else {
                        $simbolopercebtual = "";
                        $valorpercentualmedico = $items->valor_medico/* - ((float) $items->valor_medico * ((float) $items->taxa_administracao / 100)) */;

//                        $perc = $valorpercentualmedico;
                        $perc = $valorpercentualmedico * $items->quantidade;
                    }
                    if ($items->valor_revisor != '') {
                        $valor_medico = $perc - $percrevisor;
                    } else {
                        $valor_medico = $perc;
                    }

                    $datac[$items->revisor] = $datac[$items->revisor] + $valor_medico;
                    $numeroc[$items->revisor] = $numeroc[$items->revisor] + 1;
//                    echo '<pre>';
//                    var_dump($valorpercentualrevisor); die;    
                    ?>

                    <?
                    @$valorcomrevisor = @$valorcomrevisor + $percrevisor;
                    $valortotal = $valortotal + $totalrevisor;
//                    $qtdetotal = $qtdetotal + 1;
                }
                $totalrevisor = 0;
            endforeach;
            ?>
            <?
//            var_dump($revisadaunico); die;
            foreach ($revisorunico as $item) {
                if ($numeroc[$item->revisor] > 0) {
                    ?>

                    <tr>
                        <td ><font size="-1"><?= $item->revisor ?></td>
                        <!--<td ><font size="-1"><? //= $items->quantidade         ?></td>-->
                        <td ><font size="-1"><?= $numeroc[$item->revisor] ?></td>


                        <td ><font size="-1">R$<?= number_format($datac[$item->revisor], 2, ',', '.'); ?></td>
                    </tr>  
                    <?
                }
            }
            ?>    
            <tr>
                <td colspan="4"><font size="-1"><center><b>COMO REVISOR</b></center></td>
            </tr>
            <?
            if (count($revisada) > 0) {
                
            }
            foreach ($revisadaunico as $value) {
                $data[$value->revisor] = 0;
                $numero[$value->revisor] = 0;
                $desconto[$value->revisor] = 0;
            }

            foreach ($revisada as $items) :
//                if ($items->revisor != "") {
                $valor_total = $items->valor_total;
                if ($items->percentual_revisor == "t") {
                    $simbolopercebtualrevisor = " %";

                    $valorpercentualrevisor = $items->valor_revisor/* - ((float) $item->valor_revisor * ((float) $item->taxa_administracao / 100)) */;

                    $percrevisor = $valor_total * ($valorpercentualrevisor / 100);
                } else {
                    $simbolopercebtualrevisor = "";
                    $valorpercentualrevisor = $items->valor_revisor/* - ((float) $item->valor_revisor * ((float) $item->taxa_administracao / 100)) */;

//                        $percrevisor = $valorpercentualrevisor;
                    $percrevisor = $valorpercentualrevisor * $items->quantidade;
                }

                $data[$items->revisor] = $data[$items->revisor] + $percrevisor;
                $numero[$items->revisor] = $numero[$items->revisor] + 1;
//                    echo '<pre>';
//                    var_dump($valorpercentualrevisor); die;
                ?>



                <?
//                }
                @$valor_como_revisor = @$valor_como_revisor + $percrevisor;
                $valortotal = $valortotal + @$totalrevisor;
                $qtdetotal = $qtdetotal + 1;
                $totalrevisor = 0;
            endforeach;
            ?>
            <?
//            var_dump($revisadaunico); die;
            foreach ($revisadaunico as $item) {
                ?>

                <tr>
                    <td ><font size="-1"><?= $item->revisor ?></td>
                    <!--<td ><font size="-1"><? //= $items->quantidade         ?></td>-->
                    <td ><font size="-1"><?= $numero[$item->revisor] ?></td>


                    <td ><font size="-1">R$<?= number_format($data[$item->revisor], 2, ',', '.'); ?></td>
                </tr>  
            <? }
            ?>
            <?
            $valortotalreceber = @$valorcomrevisor + @$valor_semrevisor + $valor_como_revisor;
            
            ?>
            <tr>
                <td ><font size="-1">TOTAL A RECEBER</td>
                <!--<td ><font size="-1"><?= $qtdetotal ?></td>-->
                <td colspan="3"><font size="-1"><center><?= number_format($valortotalreceber, 2, ',', '.'); ?></center></td>
            </tr>
        </table>
    <? } else {
        ?>
        <h4>Medico: <?= $medico[0]->operador; ?>, n&atilde;o foi revisor</h4>
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