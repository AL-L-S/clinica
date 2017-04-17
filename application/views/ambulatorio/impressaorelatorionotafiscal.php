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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
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
                    <td class="tabela_teste">CPF</td>
                    <td class="tabela_teste">RG</td>
                    <td class="tabela_teste">Telefone</td>
                    <td class="tabela_teste">Valor da Nota</td>
                    <td class="tabela_teste">Valor da Guia</td>
                    <td class="tabela_teste">Data da Guia</td>
                    <td class="tabela_teste">Checado</td>
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
                        <td><a href="#<?$item->paciente_id?>"><?= utf8_decode($item->paciente); ?></a></td>
                        <td>
                            <?
                            if ($item->cpf != '') {
                                echo $cpf = substr(utf8_decode($item->cpf), 0, 3) . "." .
                                substr(utf8_decode($item->cpf), 3, 3) . "." .
                                substr(utf8_decode($item->cpf), 6, 3) . "-" .
                                substr(utf8_decode($item->cpf), 9, 2)
                                ;
                            }
                            ?>
                        </td>
                        <td>
                            <?
//                            if ($item->rg != '') {
//
//
//                                $numero = strlen($item->rg);
//                                echo $rg = substr(utf8_decode($item->rg), 0, $numero - 1) . "-" .
//                                substr(utf8_decode($item->rg), $numero - 1, 1);
                      echo  utf8_decode($item->rg);
                           // }
                            ?>
                        </td>
                        <td><?= utf8_decode($item->telefone); ?></td>
                        <? $cor = ((float)$item->valor_guia < (float)$item->total)?'green':'blue';?>
                        <td style="text-align: right">
                            <a style="cursor: pointer; color: <?=$cor; ?>" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/procedimentoguianotaform/$item->ambulatorio_guia_id/$item->total/$item->valor_guia"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=400,height=300');">
                                    <?= number_format($item->valor_guia, 2, ',', '.'); ?>
                                </a>
                        </td>
                        <td style="text-align: right">
                            <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/procedimentoguianota/$item->ambulatorio_guia_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=1300,height=800');">
                                    <?= number_format($item->total, 2, ',', '.'); ?>
                                </a></td>
                        </td>
                        <td style="text-align: right"><?= str_replace("-", "/", date("d-m-Y", strtotime($item->data_criacao))); ?></td>
                        <td style="text-align: center">
                            <? if ($item->checado == 't') {
                                ?>
                            <font size="+1"> &#8730;</font>
                            <? } else { ?>
                                <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/gravarchecknota/$item->ambulatorio_guia_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                    
                                </a></td>
                        <? } ?>
                    </tr>
                <? endforeach; ?>

                <tr>
                    <td width="140px;" align="center" colspan="9"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>
        </table>

    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
