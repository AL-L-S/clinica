<head>
    <meta charset="utf8"/>
</head>
<div class="content" onload="javascript: window.print();"> <!-- Inicio da DIV content -->

    <h4>PACIENTE: <?= $nomes[0]->paciente; ?></h4>
    <h4>CONVÊNIO: <?= $nomes[0]->convenio; ?></h4>
    <h4>CIRURGIÃO:<?= $nomes[0]->medico; ?></h4>

    <?
    if (count($impressao) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th  class="tabela_header" colspan="4" >HONORÁRIOS MÉDICOS</th>
                </tr>
                <tr>
                    <th width="80px" class="tabela_header">Código</th>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header">Grau de participação</th>
                    <th class="tabela_header">Valor (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($impressao as $item) :
                    $total = $total + $item->valor;
                    ?>
                    <tr>
                        <td ><?= utf8_decode($item->codigo); ?></td>
                        <td ><?= utf8_decode($item->procedimento); ?></td>
                        <td ><?= utf8_decode($item->grau_participacao); ?> - <?= utf8_decode($item->medico); ?></td>
                        <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                    </tr>
                <? endforeach; ?>
                <tr>
                    <td colspan="3"><b>TOTAL HONORÁRIOS MÉDICOS</b></td>
                    <td colspan=""><b><?= number_format($total, 2, ",", "."); ?></b></td>
                </tr>
                <tr>
                    <td colspan="3"><b>OBS: <?= $item->observacao; ?></b></td>
                </tr>
            </tbody>


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
