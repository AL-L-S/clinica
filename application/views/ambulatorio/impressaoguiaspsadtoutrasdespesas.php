<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>/css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Guia de Serviço Profissional</title>
    </head>
<?
$caminho = base_url() . str_replace(' ','_', $convenio[0]->caminho_logo);

//var_dump($caminho); die;
?>
    <body>
        <? if (count($relatorio) > 0) {
            $totGeral = 0;
            $totMaterial = 0;?>  
            <table id="tabelaspec" width="92%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>
                    <tr>
                        <td width="133" height="51" style="font-size: 9px;"><p class="ttr"><strong style="font-weight: normal; text-align: center;"><strong style="font-weight: normal; text-align: left;"><img src="<?= $caminho ?>"  width="130" height="50" class="ttr"/></strong></strong></p></td>
                        <td height="51" colspan="9" class="ttrl" style="font-size: 9px;">
                            <p>ANEXO DE OUTRAS DESPESAS</p>
                            <p>(para Guia de SP/SADT e Resumo de Internaçao)</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="ti">Registro ANS</td>
                        <td colspan="8" class="ti">Número da Guia Referenciada</td>

                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tc"><strong><?= $convenio[0]->registroans ?></strong></td>
                        <td colspan="8" class="tc"><strong><?= $relatorio[0]->guiaconvenio ?> </strong></td>

                    </tr>
                </tbody>
            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr>
                        <td colspan="8" align="center" bgcolor="#B1B1B1" class="tic" style="text-align:left;font-size: 9px;"><strong > DADOS DO CONTRATADO EXECUTANTE</strong></td>
                    </tr>
                    <tr class="ti">
                        <td width="18%" height="13" class="ti">Código da Operadora</td>
                        <td width="39%" class="ti">Nome do Contratado</td>

                        <td colspan="2" class="ti">Código CNES</td>
                    </tr>
                    <tr>
                        <td class="tc"><strong><? echo $convenio[0]->codigoidentificador; ?></strong></td>
                        <td height="16" class="tc"><strong><? echo @$empresa[0]->razao_social; ?> </strong></td>

                        <td colspan="2" class="tc"><strong><?= @$empresa[0]->cnes; ?> </strong><strong> </strong></td>
                    </tr>
                    <tr>
                        <td colspan="8" align="center" bgcolor="#B1B1B1" class="tic" style="text-align:left;font-size: 9px;"><strong>DESPESAS REALIZADAS</strong></td>
                    </tr>

                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr class="semborda">
                        <td width="1%" height="12" class="semborda">&nbsp;&nbsp;</td>
                        <td width="3%" height="12" class="semborda">CD</td>
                        <td width="3%" height="12" class="semborda">Data</td>
                        <td width="3%" class="semborda">Hora Inicial</td>
                        <td width="3%" colspan="1" class="semborda">Hora Final</td>
                        <td width="3%" colspan="1" class="semborda">Tabela</td>
                        <td width="8%" colspan="1" class="semborda">Código do Item</td>
                        <td width="5%" colspan="1" class="semborda">Qtde</td>
                        <td width="5%" colspan="1" class="semborda">Unidade de Medida</td>
                        <td width="4%" colspan="1" class="semborda">Fator Red./Acresc.</td>
                        <td width="5%" colspan="1" class="semborda">Valor Unitário (R$)</td>
                        <td width="5%" colspan="1" class="semborda">Valor Total (R$)</td>
                        <td width="4%" colspan="1" class="semborda">Registro ANVISA do material</td>
                        <td width="4%" colspan="1" class="semborda">Referencia do Material no fabricante</td>
                        <td width="4%" colspan="1" class="semborda">N° Autorização de Funcionamento</td>

                    </tr>
                    <? 
                    $i = 1;
                    foreach ($relatorio as $value) { ?>

                        <tr>
                            <td class="semborda"><strong><?= $i ?> - </strong></td>
                            <td class="semborda"><strong>&nbsp;&nbsp;</strong></td>
                            <td class="semborda"><strong><? echo date("d-m-Y", strtotime(@$value->data_criacao)); ?>&nbsp;&nbsp;</strong></td>
                            <td height="16" colspan="1" class="semborda"><strong>&nbsp;&nbsp;</strong></td>
                            <td height="16" colspan="1" class="semborda"><strong>&nbsp;&nbsp;</strong></td>
                            <td colspan="1" class="semborda"><strong>19</strong></td>
                            <td colspan="1" class="semborda"><strong><? echo @$value->codigo_procedimento; ?></strong></td>
                            <td colspan="1" class="semborda"><strong><? echo @$value->quantidade; ?></strong></td>
                            <td colspan="1" class="semborda"><strong><? echo @$value->unidade; ?></strong></td>
                            <td colspan="1" class="semborda"><strong>&nbsp;</strong></td>
                            <td colspan="1" class="semborda"><strong><? echo number_format(@$value->valor, 2, ',', '.'); ?></strong></td>
                            <?$totMaterial += (@$value->quantidade * @$value->valor);?>
                            <td colspan="1" class="semborda"><strong><? echo number_format(@$value->quantidade * $value->valor, 2, ',', '.'); ?></strong></td>
                            <td colspan="1" class="semborda"><strong>&nbsp;</strong></td>
                            <td colspan="1" class="semborda"><strong>&nbsp;</strong></td>
                            <td colspan="1" class="semborda"><strong>&nbsp;</strong></td>
                        </tr>
                        <tr>
                            <td class="semborda" colspan="17">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="semborda" colspan="2"><strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                            <td class="semborda" style="text-align: right"><strong>Descrição: </strong></td>
                            <td class="semborda" colspan="17" style="border-bottom: 0.5pt solid #999"><? echo @$value->descricao; ?></td>
                        </tr>
                        <tr >
                            <td class="semborda" colspan="17">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr >
                            <td class="semborda" colspan="17">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?
                        $i++;
                    }
                    ?>

                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>
                    <tr class="tic">
                        <td width="14%" height="13" class="tic"><span style="margin-left: 5pt">Total Gases Medicinais R$</span></td>
                        <td width="14%" colspan="1" class="tic"><span style="margin-left: 5pt">Total Medicamentos R$</span></td>
                        <td width="14%" colspan="1" class="tic"><span style="margin-left: 5pt">Total Materiais R$</span></td>
                        <td width="14%" colspan="1" class="tic"><span style="margin-left: 5pt">Total Taxas Diversas R$</span></td>
                        <td width="14%" colspan="1" class="tic"><span style="margin-left: 5pt">Total Diárias R$</span></td>
                        <td width="14%" colspan="1" class="tic"><span style="margin-left: 5pt">Total Aluguéis R$</span></td>
                        <td width="14%" colspan="1" class="tic"><span style="margin-left: 5pt">Total Geral R$</span></td>

                    </tr>
                    <tr>
                        <?$totGeral += @$totMaterial;?>
                        <td class="tc" style="text-align: right"><strong style="margin-right: 5pt">0,00</strong></td>
                        <td class="tc" style="text-align: right"><strong style="margin-right: 5pt">0,00</strong></td>
                        <td class="tc" style="text-align: right"><strong style="margin-right: 5pt"><? echo number_format($totMaterial, 2, ',', '.'); ?></strong></td>
                        <td class="tc" style="text-align: right"><strong style="margin-right: 5pt">0,00</strong></td>
                        <td class="tc" style="text-align: right"><strong style="margin-right: 5pt">0,00</strong></td>
                        <td class="tc" style="text-align: right"><strong style="margin-right: 5pt">0,00</strong></td>
                        <td class="tc" style="text-align: right"><strong style="margin-right: 5pt"><? echo number_format($totGeral, 2, ',', '.'); ?></strong></td>
                    </tr>
                </tbody>

            </table>
        <? } else{?>
        <h4><?=@$empresa[0]->razao_social?></h4> 
        <h4>Guia: <?=$guia_id?></h4> 
        <h4>NÃO É POSSÍVEL GERAR A GUIA - SP/SADT SEM PROCEDIMENTOS CADASTRADOS NA GUIA</h4> 
        
                             
        
       <? }
        ?>


    </body>
</html>
