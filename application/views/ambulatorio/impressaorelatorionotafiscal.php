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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Nota Fiscal</th>
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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></th>
            </tr>

        </thead>
    </table>

    <? if (count($relatorio) > 0) {
        ?>

        <table border="1">
            <thead>
                <tr>
                    <td class="tabela_teste">Guia</td>
                    <td class="tabela_teste">Nome</td>
                    <td class="tabela_teste">Valor da Nota</td>
                    <td class="tabela_teste">Data da Guia</td>
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

                        <td><?= utf8_decode($item->ambulatorio_guia_id); ?></td>
                        <td><?= utf8_decode($item->paciente); ?></td>
                        <td><?= number_format($item->valor_guia, 2, ',', '.'); ?></td>
                        <td><?= str_replace("-","/",date("d-m-Y", strtotime($item->data_criacao) ) ); ?></td>

                    </tr>
                <? endforeach; ?>

                <tr>
                    <td width="140px;" align="center" colspan="5"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>
        </table>
       
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
