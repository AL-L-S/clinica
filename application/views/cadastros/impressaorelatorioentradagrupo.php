<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($tipo) > 0) { ?>
        <h4>TIPO<?= $tipo[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODAS OS TIPOS</h4>
    <? } ?>
    <? if (count($classe) > 0) { ?>
        <? $texto = strtr(strtoupper($classe[0]->descricao), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"); ?>
        <h4>CLASSE: <?= $texto; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLASSES</h4>
    <? } ?>
    <? if (count($forma) > 0) { ?>
        <h4>CONTA:<?= $forma[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CONTAS</h4>
    <? } ?>
    <? if (count($credordevedor) > 0) { ?>
        <h4><?= $credordevedor[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS OS DEVEDORES</h4>
    <? } ?>
    <h4>RELATORIO DE ENTRADA</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <hr>
    <?
    if ($relatorioentrada > 0) {
        ?>
        <table border ="1" >
            <thead>
                <tr>
                    <th width="100px;" class="tabela_header">Conta</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Tipo</th>
                    <th class="tabela_header">Classe</th>
                    <th class="tabela_header">Observacao</th>
                    <th class="tabela_header">Dt entrada</th>
                    <th class="tabela_header">Valor</th>
                    <th class="tabela_header">Empresa</th>


                </tr>
            </thead>
            <tbody>
                <?php
                $totalgeral = 0;
                $totaltipo = 0;
                $i = 0;
                $s = '';
                foreach ($relatorioentrada as $item) :
                    if ($item->tipo != 'TRANSFERENCIA') {
                        $totalgeral = $totalgeral + $item->valor;
                    }
//                    $totalgeral = $totalgeral + $item->valor;
                    if ($i == 0 || $item->conta == $s) {
                        $s = $item->conta;
                        if ($item->tipo != 'TRANSFERENCIA') {
                            $totaltipo = $totaltipo + $item->valor;
                        }
                        ?>
                        <tr>
                            <td ><?= $item->conta; ?></td>
                            <td ><?= $item->razao_social; ?></td>
                            <td ><?= $item->tipo; ?>&nbsp;</td>
                            <td ><?= $item->classe; ?></td>
                            <td ><?= $item->observacao; ?>&nbsp;</td>
                            <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                            <td ><?= $item->empresa; ?></td>

                        </tr>
                    <? } else { ?>
                        <tr>
                            <td colspan="6" bgcolor="#C0C0C0"><b>SUB-TOTAL</b></td>
                            <td colspan="2" bgcolor="#C0C0C0"><b><?= number_format($totaltipo, 2, ",", "."); ?></b></td>

                        </tr>
                        <tr>
                            <td ><?= $item->conta; ?></td>
                            <td ><?= $item->razao_social; ?></td>
                            <td ><?= $item->tipo; ?></td>
                            <td ><?= $item->classe; ?></td>
                            <td ><?= $item->observacao; ?></td>
                            <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                            <td ><?= $item->empresa; ?></td>
                        </tr>
                        <?
                        $s = $item->conta;
                        $totaltipo = 0;
                        if ($item->tipo != 'TRANSFERENCIA') {
                            $totaltipo = $item->valor;
                        }
                    }
                    $i++
                    ?>
                <? endforeach; ?>
                <tr>
                    <td colspan="6" bgcolor="#C0C0C0"><b>TOTAL</b></td>
                    <td colspan="2" bgcolor="#C0C0C0"><b><?= number_format($totalgeral, 2, ",", "."); ?></b></td>
                </tr>
            </tbody>
        </table>
        <h4>Obs: Transfer&ecirc;ncias n&atilde;o s&atilde;o somadas no valor total</h4>
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
