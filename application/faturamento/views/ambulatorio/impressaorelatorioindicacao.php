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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Indica&ccedil;&atilde;o</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>

            <? if ($indicacao == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS INDICADOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">INDICADO: <?= $indicacao; ?></th>
                </tr>
            <? } ?>
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
                    <td class="tabela_teste">Nome</th>
                    <td class="tabela_teste">Indica&ccedil;&atilde;o</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $i = 0;
                $b = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $tecnicos = "";
                $paciente = "";
                $indicacao = "";
                foreach ($relatorio as $item) :
                    $i++;

                    $qtdetotal++;
                    ?>
                    <tr>

                        <td><?= utf8_decode($item->paciente); ?></td>

                        <td style='text-align: center;'><font size="-2"><?= $item->indicacao; ?></td>
                    </tr>
                <? endforeach; ?>

                <tr>
                    <td width="140px;" align="Right" colspan="2"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>
        </table>
        <table border="1">
            <thead>
                <tr>
                    <td class="tabela_teste">Indica&ccedil;&atilde;o</th>
                    <td class="tabela_teste">Qtde</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                foreach ($consolidado as $item) :
                    $b++;
                    $qtde++;
                        ?>

                        <tr>
                            <td style='text-align: center;'><font size="-2"><?= $item->indicacao; ?></td>
                            <td><?= $item->quantidade; ?></td>
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
