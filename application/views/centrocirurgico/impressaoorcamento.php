<head>
    <meta charset="utf8"/>
</head>
<div class="content" onload="javascript: window.print();"> <!-- Inicio da DIV content -->
    <table style="margin-left: 50px;">
        <tbody>
            <tr>
                <td><?= $empresa[0]->razao_social; ?></td>
            </tr>
            <tr>
                <td>CNPJ:<?= $empresa[0]->cnpj; ?></td>
            </tr>
            <tr>
                <td><?= $empresa[0]->logradouro; ?> - <?= $empresa[0]->bairro; ?></td>
            </tr>
            <tr>
                <td>Telefone: <?= $empresa[0]->telefone; ?></td>
            </tr>
        </tbody>
    </table>


    <h4>PACIENTE: <?= $nomes[0]->paciente; ?></h4>
    <h4>CONVÊNIO: <?= $nomes[0]->convenio; ?></h4>
    <h4>CIRURGIÃO:<?= $nomes[0]->medico; ?></h4>

    <?
    $total = 0;
    $total_geral = 0;
    if (count($impressao) > 0) {
        ?>
        <table border="1" style="width: 800px;">
            <thead>
                <tr>
                    <th  class="tabela_header" colspan="4" >HONORÁRIOS MÉDICOS</th>
                </tr>
            </thead>
            <?php
            $x = 1;
            foreach ($impressao as $item) :
                $total = $total + $item->valor;
                $total_geral = $total_geral + $item->valor;
                if ($x == 1) {
                    $grau_participacao = $item->grau_participacao;
                }
                if ($grau_participacao != $item->grau_participacao || $x == 1) {
                    ?>

                    <thead>
                        <tr>
                            <th width="80px" class="tabela_header">Código</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">Grau de participação</th>
                        </tr>
                    </thead>
                <? } ?>
                <tbody>

                    <tr>
                        <td ><?= utf8_decode($item->codigo); ?></td>
                        <td ><?= utf8_decode($item->procedimento); ?></td>
                        <td ><?= utf8_encode($item->grau_participacao); ?></td>
                    </tr>
                    <?
                    if ($grau_participacao != $item->grau_participacao || $x == 1) {
                        $grau_participacao = $item->grau_participacao;
                        ?>
                        <tr>
                            <td colspan="2"></td>
                            <td ><b>TOTAL: R$ <?= number_format($total, 2, ",", "."); ?></b></td>

                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                    </tbody>
                    <?
                    $total = 0;
                } else {
                    
                }
                $x++;
            endforeach;
            ?>
            <tfoot>
                <tr>
                    <td colspan="2"><b>TOTAL GERAL:</b></td>
                    <td colspan=""><b>R$ <?= number_format($total_geral, 2, ",", "."); ?></b></td>
                </tr>
                <tr>
                    <td colspan="3"><b>OBS: <?= $item->observacao; ?></b></td>
                </tr>
            </tfoot>>


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
