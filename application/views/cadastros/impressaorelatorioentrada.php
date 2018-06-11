<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($tipo) > 0) { ?>
        <h4>TIPO<?= $tipo[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODOS OS TIPOS</h4>
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
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <hr>
    <?
    if ($relatorioentrada > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th width="100px;" class="tabela_header">Conta</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Tipo</th>
                    <th class="tabela_header">Classe</th>
                    <th class="tabela_header">Dt entrada</th>
                    <th class="tabela_header">Valor</th>
                    <th class="tabela_header">Observacao</th>
                    <th class="tabela_header">Empresa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($relatorioentrada as $item) :
                    if($item->tipo != 'TRANSFERENCIA'){
                         $total = $total + $item->valor;
                    }
                   
                    ?>
                    <tr>
                        <td ><?= utf8_decode($item->conta); ?></td>
                        <td ><?= utf8_decode($item->razao_social); ?>&nbsp;</td>
                        <td ><?= utf8_decode($item->tipo); ?>&nbsp;</td>
                        <td ><?= utf8_decode($item->classe); ?>&nbsp;</td>
                        <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                        <td ><?= utf8_decode($item->observacao); ?>&nbsp;</td>
                        <td ><?= utf8_decode($item->empresa); ?>&nbsp;</td>
                    </tr>
                <? endforeach; ?>
                <tr>
                    <td colspan="4"><b>TOTAL</b></td>
                    <td colspan="2"><b><?= number_format($total, 2, ",", "."); ?></b></td>
                </tr>
            </tbody>
        </table>
            <h4>Obs: Transfer&ecirc;ncias n&atilde;o s&atilde;o somadas no valor total</h4>

            <?
        }
        else {
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
