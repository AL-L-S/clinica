<div class="content"> <!-- Inicio da DIV content -->
    <? $tipoempresa = ""; ?>
    <table>
        <thead>

            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
                <?
                $tipoempresa = $empresa[0]->razao_social;
            } else {
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
                <?
                $tipoempresa = 'TODAS';
            }
            ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESTOQUE MINIMO PRODUTOS</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>

            <? IF ($armazem > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ARMAZEM: <?= $armazem[0]->descricao; ?></th>
                </tr>
            <? } ELSE { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ARMAZEM: TODOS</th>
                </tr>
            <? } ?>
        </thead>
    </table>

    <? if ($contador > 0) {
        ?>

        <table>
            <thead>
                <tr>
                    <td class="tabela_teste"><font size="-2">Produto</th>
                    <td style='text-align: right;' class="tabela_teste" width="70px;"><font size="-2">QTDE</th>
                    <td style='text-align: right;' class="tabela_teste" width="70px;"><font size="-2">Estoque minimo</th>

                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $armazem = "";
                $paciente = "";
                foreach ($relatorio as $item) :
                    $i++;
                    if ($i == 1 || $item->armazem == $armazem) {
                        $qtdetotal++;

                        if ($i == 1) {
                            ?>
                            <tr>
                                <td colspan="8"><font size="-2"><b>Armazem:&nbsp;<?= utf8_decode($item->armazem); ?></b></td>
                            </tr>
                            <?
                        }
                        if ($item->quantidade <= $item->estoque_minimo) {
                            ?>
                            <tr>
                                <td><font size="-2"><?= utf8_decode($item->produto); ?></td>
                                <td style='text-align: right;'><font size="-2"><?= $item->quantidade; ?></td>
                                <td style='text-align: right;'><font size="-2"><?= utf8_decode($item->estoque_minimo); ?></td>
                            </tr>


                            <?php
                            $qtde++;
                        }
                        $armazem = $item->armazem;
                    } else {
                        $armazem = $item->armazem;
                        ?>

                        <tr>
                            <td width="140px;" align="Right" colspan="9"><b>Nr. Itens:&nbsp; <?= $qtde; ?></b></td>
                        </tr>
                        <?
                        $qtdetotal++;
                        ?>
                        <tr>
                            <td colspan="8"><font size="-2"><b>Armazem:&nbsp;<?= utf8_decode($item->armazem); ?></b></td>
                        </tr>
                        <? if ($item->quantidade <= $item->estoque_minimo) { ?>
                            <tr>
                                <td><font size="-2"><?= utf8_decode($item->produto); ?></td>
                                <td style='text-align: right;'><font size="-2"><?= $item->quantidade; ?></td>
                                <td style='text-align: right;'><font size="-2"><?= utf8_decode($item->estoque_minimo); ?></td>
                            </tr>
                            <?
                            $qtde = 0;
                            $qtde++;
                        }
                    }
                endforeach;
                ?>

                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Itens:&nbsp; <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
                <tr>
                    <td width="140px;" align="Right" ><b>TOTAL GERAL</b></td>
                    <td width="140px;" align="center" ><b>Nr. Itens: &nbsp;<?= $qtdetotal; ?></b></td>
                </tr>
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