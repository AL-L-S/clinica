<div class="content"> <!-- Inicio da DIV content -->
    <? $tipoempresa = ""; ?>
    <table>
        <thead>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PEDIDO DE COMPRA</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">DATA DE EMISSAO: <?= date("d/m/Y"); ?></th>
            </tr>
        </thead>
    </table>

    <? if (count($relatorio) > 0) {
        ?>
        <br>
        <table border='1' cellpadding='5' cellspacing='0' style='width: 100%'>
            <thead>
                <tr>
                    <td class="tabela_teste"><font size="-2">Produto</font></td>
                    <td class="tabela_teste"><font size="-2">QTDE</font></td>
                    <td class="tabela_teste"><font size="-2">Valor Estimado</font></td>
                    <td class="tabela_teste"><font size="-2">Observação</font></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $qtde = 0;
                foreach ($relatorio as $item) :
                    $qtde++;
                    ?>
                    <tr>
                        <td><?= $item->produto ?></td>
                        <td><?= (int)$item->quantidade ?></td>
                        <td><? 
                            if ($item->valor_entrada != ''){
                                $vlr = (float)$item->valor_entrada * (int)$item->quantidade;
                                echo number_format($vlr, 2, ',', '.');
                            } ?>
                        </td>
                        <td><?= $item->observacao ?></td>
                    </tr>
                    <?
                endforeach;
                ?>

                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Itens:&nbsp; <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <hr>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });
</script>