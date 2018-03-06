<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($tipo) > 0) { ?>
        <h4>TIPO: <?= $tipo[0]->descricao; ?></h4>
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
    <h4>RELATORIO MOVIMENTA&Ccedil;&Atilde;O</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <hr>
    <h4>Saldo anterior: <?= number_format($saldoantigo[0]->total, 2, ",", "."); ?></h4>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th width="100px;" class="tabela_header">Conta</th>
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header">Credor/Devedor</th>
                    <th class="tabela_header">Tipo</th>
                    <th class="tabela_header">Classe</th>
                    <th class="tabela_header">Valor</th>
                    <th class="tabela_header">Observa&ccedil;&atilde;o</th>
                    <th class="tabela_header">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = $saldoantigo[0]->total;
                $data = 0;
                $totalrelatorio = 0;
                foreach ($relatorio as $item) :
                    if ($item->tiposaida != 'TRANSFERENCIA' && $item->tipoentrada != 'TRANSFERENCIA') {
                        $total = $total + $item->valor;
                        $totalrelatorio = $totalrelatorio + $item->valor;
                    }

//                    $totalrelatorio = $totalrelatorio + $item->valor;
                    $dataatual = substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4);
                    ?>

                    <tr>
                        <td ><?= utf8_decode($item->contanome); ?></td>
                        <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td ><?= utf8_decode($item->razao_social); ?></td>
                        <? if ($item->tiposaida != null) { ?>
                            <td ><?= utf8_decode($item->tiposaida); ?></td>
                            <td ><?= utf8_decode($item->classesaida); ?></td>
                            <? if ($item->valor > 0) { ?>
                                <td ><font color="blue"><?= number_format($item->valor, 2, ",", "."); ?></td>   

                            <? } else { ?>
                                <td ><font color="red"><?= number_format($item->valor, 2, ",", "."); ?></td>    

                            <? } ?>

                        <? } else { ?>
                            <td ><?= utf8_decode($item->tipoentrada); ?></td>
                            <td ><?= utf8_decode($item->classeentrada); ?></td>                      
                            <td ><font color="blue"><?= number_format($item->valor, 2, ",", "."); ?></td>
                        <? } ?>


                        <? if ($item->observacaosaida != null) { ?>
                            <td ><?= utf8_decode($item->observacaosaida); ?></td>
                        <? } else { ?>
                            <td ><?= utf8_decode($item->observacaoentrada); ?></td>
                        <? } ?>
                        <td colspan="2"><b><?= number_format($total, 2, ",", "."); ?></b></td>
                    </tr>


                <? endforeach; ?>
                <tr>
                    <td colspan="5"><b>Saldo Final</b></td>
                    <td ><b><?= number_format($totalrelatorio, 2, ",", "."); ?></b></td>
                    <td ><b></b></td>
                    <td ><b><?= number_format($total, 2, ",", "."); ?></b></td>
                </tr>
            </tbody>


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
