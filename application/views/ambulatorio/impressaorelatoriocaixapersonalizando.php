<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>CONFERENCIA CAIXA (Personalizado)</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <h4>PACIENTE: <?= $paciente; ?></h4>

    <hr>
    <?
    if (count($relatorio) > 0) {
        $valTotal = (float) $valortotal[0]->valor_total;
        ?>
        <table cellpadding="5">
            <thead>
                
                                <tr>
                                    <th class="tabela_header"><font size="4">Paciente</font></th>
                                    <th class="tabela_header"><font size="4">Procedimento</font></th>
                                    <th class="tabela_header"><font size="4">Convenio</font></th>
                                    <th class="tabela_header" style="text-align: right"><font size="4">QTDE</font></th>
                                    <th class="tabela_header" width="80px;" style="text-align: right"><font size="4">Percentual</font></th>
                                </tr>
            </thead>
            <tbody>
                <?
                foreach ($relatorio as $value):
                    $verificador = true;
                    foreach ($relatorioprocedimentos as $item) :
                        if ($value->ambulatorio_guia_id == $item->guia_id):
                            if ($verificador) {
                                $verificador = false;
                                ?>
                                <tr>
                                    <td colspan="8"><font ><b>Guia <?= $value->ambulatorio_guia_id; ?></b></td>
                                </tr>
                            <? }
                            ?>
                            <tr>
                                <td style="text-align: left"><?= $item->paciente; ?></td>
                                <td style="text-align: left"><?= $item->procedimento; ?></td>
                                <td style="text-align: left"><?= $item->convenio; ?></td>
                                <td style="text-align: right"><?= $item->quantidade; ?></td>
                                <? $perc = (((int) $item->quantidade * (float) $item->valor_total) / $valTotal) * 100; ?>
                                <td style="text-align: right"><?= number_format($perc, 2, ',', '.'); ?> %</td>
                            </tr>
                            <?
                        endif;

                    endforeach;
                endforeach;
                ?>
            </tbody>
        <? } else {
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
