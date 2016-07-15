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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Valor M&eacute;dio</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></th>
            </tr>

        </thead>
    </table>











    <? if (count($relatorio) > 0) {
        ?>

        <table border="1">
            <thead>
                <tr>
                    <td class="tabela_teste">Procedimento</th>
                    <td class="tabela_teste">Qtde</th>
                    <td class="tabela_teste">Valor M&eacute;dio</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $conevenio = "";
                $valorconvenio = "";
                $procedimento = 0;
                foreach ($relatorio as $item) :
                    $conevenio = "";
                    $valorconvenio = "";

                    foreach ($convenio as $value) :
                        if ($item->procedimento == $value->procedimento) {
                            $valorconvenio = $value->valortotal;
                            $procedimento = $value->procedimento_tuss_id;
                        }
                    endforeach;
                    if ($item->quantidade != 0) {
                        $valor = $item->valor / $item->quantidade;
                    } else {
                        $valor = 0;
                    }
                    ?>
                    <tr>
                        <td ><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                        <td style='text-align: center;' ><?= $item->quantidade; ?></td>
                        <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/graficovalormedio/$procedimento/$valor"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                <font size="-2"><?= number_format($valor, 2, ',', '.'); ?></font>
                            </a></td>
                    </tr>

                <? endforeach; ?>
            </tbody>
        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
