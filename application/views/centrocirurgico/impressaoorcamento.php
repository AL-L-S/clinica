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
    <h4>MÉDICO SOLICITANTE:<?= $nomes[0]->medico; ?></h4>

    <?
    $total = 0;
    $total_geral = 0;

    if (count($contador_impressao) > 0) {
        ?>
        <table style="width: 800px;" cellpadding="4">
            <thead>
                <tr>
                    <th class="tabela_header" colspan="4" style="border:1pt solid gray">HONORÁRIOS MÉDICOS</th>
                </tr>
                <tr>
                    <th  class="tabela_header" colspan="4" ><div style="height: 40pt"></div></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 1;
                foreach ($funcoes as $value) {
                    $impressao = $this->solicitacirurgia_m->impressaoorcamento($solicitacao_id, $value->funcao_cirurgia_id);
                    if (count($impressao) > 0) {
                        ?>
                
                    <thead>
                        <tr style="border:1pt solid gray">
                            <th width="80px" class="tabela_header">CÓDIGO</th>
                            <th class="tabela_header">PROCEDIMENTO</th>
                            <th class="tabela_header">GRAU DE PARTICIPAÇÃO</th>
                        </tr>
                    </thead>
                    <?
                    foreach ($impressao as $item) {
                        $total = $total + $item->valor;
                        $total_geral = $total_geral + $item->valor;
                        ?>
                        <tbody>

                            <tr>
                                <td ><?= utf8_decode($item->codigo); ?></td>
                                <td ><?= utf8_decode($item->procedimento); ?></td>
                                <td ><?= utf8_encode($item->grau_participacao); ?></td>
                            </tr>
                            <?
                        }
                        ?>
                        <tr>
                            <td colspan="2"></td>
                            <td ><b>TOTAL: R$ <?= number_format($total, 2, ",", "."); ?></b></td>

                        </tr>
                        <tr>
                            <td class="tabela_header" colspan="4" ><div style="height: 15pt"></div></td>
                        </tr>
                    </tbody>
                    <?
                }
                $total = 0;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><b>TOTAL HONORARIOS MEDICOS:</b></td>
                    <td colspan=""><b>R$ <?= number_format($total_geral, 2, ",", "."); ?></b></td>
                </tr>
            </tfoot>

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
