<style>
    .botaoGerarLoteRPS{
        border: 1pt solid #ddd;
        border-radius: 5pt;
        padding: 5pt;
        width: 80pt;
        text-align: center;
        right: 10pt;
        display: block;
        font-weight: normal;
    }
    .botaoGerarLoteRPS a {
        text-decoration: none;
        color: black;
    }
    .botaoGerarLoteRPS:hover{
        font-weight: bold;
        border: 1pt solid #333;
        background-color: #ccc; 
        
    }
    
</style>
<div class="content"> <!-- Inicio da DIV content -->
    <? $tipoempresa = ""; ?>
    <table width="100%">
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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="3">EMPRESA: <?= $tipoempresa ?></th>
                <th rowspan="2">
                    <? if (count($relatorio) > 0) { ?>    
                        <div class="botaoGerarLoteRPS">
                            <?
                            $parametros = "txtdata_inicio=".$_POST['txtdata_inicio']."&txtdata_fim=".$_POST['txtdata_fim'];
                            $parametros .= "&empresa=".$_POST['empresa']."&guia=".$_POST['guia'];
                            ?>
                            <a target="_blank" href="<?= base_url() ?>ambulatorio/guia/gerarXmlLoteRPS?<?=$parametros?>">Gerar RPS</a>
                        </div>
                    <? } ?>
                </th>
            </tr>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="3">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
            </tr>

        </thead>
    </table>
    
    <? if (count($relatorio) > 0) {
        ?>    

        <hr>
        
        <table border="1" width="100%">
            <thead>
                <tr>
                    <td class="tabela_teste">Guia</td>
                    <td class="tabela_teste">Nome</td>
                    <td class="tabela_teste">CPF</td>
                    <td class="tabela_teste">RG</td>
                    <td class="tabela_teste">Telefone</td>
                    <td class="tabela_teste">Tipo</td>
                    <td class="tabela_teste">Numero da Nota</td>
                    <td class="tabela_teste">Valor da Nota</td>
                    <td class="tabela_teste">Valor da Guia</td>
                    <td class="tabela_teste">Data da Guia</td>
                    <!--<td class="tabela_teste">Checado</td>-->
                </tr>
            </thead>
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
                        <td>
                            <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/listardadospacienterelatorionota/$item->paciente_id"; ?> ', '_blank', 'width=1200,height=700');">
                                <?= utf8_decode($item->paciente); ?>
                            </a>
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
                        <td><?
                            if($item->nota_fiscal == 't'){
                                echo "Nota";
                            }else{
                                echo "Recibo";
                            }
                        ?></td>
                        <td><?= $item->numero_nota_fiscal; ?></td>
                        <? $cor = ((float)$item->valor_guia < (float)$item->total)?'green':'blue';?>
                        <td style="text-align: right">
                            <a style="cursor: pointer; color: <?=$cor; ?>" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/procedimentoguianotaform/$item->ambulatorio_guia_id/$item->total/$item->valor_guia"; ?> ', '_blank', 'width=400,height=300');">
                                    <?= number_format($item->valor_guia, 2, ',', '.'); ?>
                                </a>
                        </td>
                        <td style="text-align: right">
                            <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/procedimentoguianota/$item->ambulatorio_guia_id"; ?> ', '_blank', 'width=1000,height=700');">
                                    <?= number_format($item->total, 2, ',', '.'); ?>
                                </a></td>
                        </td>
                        <td style="text-align: right"><?= str_replace("-", "/", date("d-m-Y", strtotime($item->data_criacao))); ?></td>
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
