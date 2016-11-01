<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONFERENCIA EXAMES SALAS</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></th>
            </tr>
            <? if ($salas == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS SALA</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">SALA: <?= utf8_decode($sala[0]->nome); ?></th>
                </tr>
            <? } ?>

            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="8">&nbsp;</th>
            </tr>
            <? if (count($relatorio) > 0) {
                ?>
                <tr>
                    <td class="tabela_teste" >Sala</th>
                    <td class="tabela_teste">Quantidade</th>
                    <td class="tabela_teste"  >Valor</th>
                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="8">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalgeral = 0;
                foreach ($relatorio as $item) {
                    $totalgeral = $totalgeral + $item->valor;
                    ?>
                <tr>
                <td><?= $item->nome; ?></td>
                <td><?= $item->quantidade; ?></td>
                <td><?= number_format($item->valor, 2, ',', '.') ?></td>
                </tr>
                <?
            }
?>
                <tr><td>Total</td><td><?= number_format($totalgeral, 2, ',', '.') ?></td></tr>
            </tbody>
        </table>

    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>