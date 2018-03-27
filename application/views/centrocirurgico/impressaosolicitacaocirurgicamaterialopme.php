<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>/css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Guia de Solicitacao De Internação</title>
    </head>

    <body>
        <? if (count($relatorio) > 0) { ?>  
            <table id="tabelaspec" width="92%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>
                    <tr bgcolor="#B1B1B1">
                        <td width="80" height="51" style="font-size: 9px;">
                            <p class="ttr">
                                <strong style="font-weight: normal; text-align: center;">
                                    <strong style="font-weight: normal; text-align: left;">
                                        <img src="<?= base_url() . $relatorio[0]->caminho_logo; ?>"  width="80" height="49" class="ttr"/>
                                    </strong>
                                </strong>
                            </p>
                        </td>
                        <td height="51" colspan="4" class="ttrl" style="font-size: 9px;">
                            <p>ANEXO DE SOLICITAÇÃO DE ÓRTESES, PRÓTESES E</p>
                            <p>MATERIAIS ESPECIAIS - OPME</p>
                        </td>
                        <td colspan="2" width="239" style="font-size: 9px;">
                            <p>N° Guia no Prestador</p>
                            <p><strong></strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" class="ti">1- Registro ANS</td>
                        <td colspan="1" class="ti">3- Número da Guia Referenciada</td>
                        <td colspan="2" class="ti">4- Senha</td>
                        <td colspan="1" class="ti">5- Data de autorização</td>
                        <td colspan="1" class="ti">6- Número da Atribuida pela Operadora</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="1" class="tc"><strong><?= $relatorio[0]->registroans ?></strong></td>
                        <td colspan="1" class="tc"><strong>&nbsp; </strong></td>
                        <td colspan="2" class="tc"><strong>&nbsp; </strong></td>
                        <td height="16" colspan="1" class="tc"><strong>
                                <? 
                                if($relatorio[0]->data_autorizacao != ''){
                                    $ano = substr($relatorio[0]->data_autorizacao, 0, 4); 
                                    $mes = substr($relatorio[0]->data_autorizacao, 5, 2); 
                                    $dia = substr($relatorio[0]->data_autorizacao, 8, 2); 
                                    $datafinal = $dia . '/' . $mes . '/' . $ano; 
                                    echo $datafinal;
                                }?></strong>
                        </td>
                        <td colspan="1" class="tc"><strong>&nbsp; </strong></td>
                    </tr>  
                    
                    <tr>
                        <td colspan="6" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong>DADOS DO BENEFICIÁRIO</strong></td>
                    </tr>
                </tbody>
                
                <tbody>
                    <tr>
                        <td colspan="2" class="ti">7-Número da carteira</td>
                        <td colspan="4" class="ti">8- Nome</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tc"><strong><? echo $relatorio[0]->convenionumero; ?></strong></td>
                        <td colspan="4" class="tc"><strong><?= $relatorio[0]->paciente; ?></strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong > DADOS DO PROFISSIONAL SOLICITANTE</strong></td>
                    </tr>
                    <tr class="tic">
                        <td colspan="3" height="13" class="tic">9- Nome da Profissional Solicitante</td>
                        <td colspan="1" class="tic">10- Telefone</td>
                        <td colspan="2" class="tic">11- Email </td>

                    </tr>
                    <tr>
                        <td class="tc" colspan="3"><strong><?= $relatorio[0]->solicitante; ?></strong></td>
                        <?
                        $telefone = $relatorio[0]->celular;
                        if ($relatorio[0]->telefone != ''){
                            $telefone = $relatorio[0]->telefone;
                        }
                        ?>
                        <td height="16" colspan="1" class="tc"><strong><?= $telefone; ?></strong></td>
                        <td height="16" colspan="2" class="tc"><strong><?= $relatorio[0]->email; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong>DADOS DA CIRURGIA</strong></td>
                    </tr>
                    <tr class="tic">
                        <td width="100%" height="13" class="ti" colspan="6">12- Justificativa Técnica</td>
                    </tr>
                    <tr>
                        <td height="46" class="tic" colspan="6"><strong>&nbsp;</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong>PROCEDIMENTOS SOLICITADOS</strong></td>
                    </tr>
                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr class="semborda">
                        <td width="8%" height="13" class="semborda">13- Tabela</td>
                        <td width="10%" class="semborda">14- Código do Material </td>
                        <td width="15%" colspan="1" class="semborda">15- Descrição</td>
                        <td width="5%" colspan="1" class="semborda">16- Opção</td>
                        <td width="8%" colspan="1" class="semborda">17- Quantidade Solicitada</td>
                        <td width="10%" colspan="1" class="semborda">18- Valor Unit. Solicitado</td>
                        <td width="8%" colspan="1" class="semborda">19- Quantidade Autorizada</td>
                        <td width="10%" colspan="1" class="semborda">20- Valor Unit. Autorizado</td>
                        <td width="12%" colspan="1" class="semborda">21- Registro ANVISA do material</td>
                        <td width="12%" colspan="1" class="semborda">22- Referência do material no fabricante</td>
                        <td width="12%" colspan="1" class="semborda">23- N° autorização de funcionamento</td>
                    </tr>
                    <? foreach($procedimentos as $value) { ?>
                        <tr>
                            <td class="semborda"><strong></strong></td>
                            <td height="16" class="semborda"><strong><?= $value->codigo ?></strong></td>
                            <td colspan="1" class="semborda"><strong><?= $value->nome ?></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                            <td colspan="1" class="semborda"><strong><?= $value->quantidade ?></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                        </tr>
                        <tr>
                            <td colspan="11" class="semborda"><strong>&nbsp;</strong></td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        
            <table id="tabelaspec" width="92%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>
                    
                    <tr class="tic">
                        <td width="100%" height="13" class="ti" colspan="6">24- Especificação do Material</td>
                    </tr>
                    <tr>
                        <td height="46" class="tic" colspan="6"><strong>&nbsp;</strong></td>
                    </tr>
                    
                    <tr class="tic">
                        <td width="100%" height="13" class="ti" colspan="6">25- Observação/Justificativa</td>
                    </tr>
                    <tr>
                        <td height="46" class="tic" colspan="6"><strong><? echo $relatorio[0]->observacao ?></strong></td>
                    </tr>
                    <tr class="tic">
                        <td width="20%" height="13" colspan="" class="ti">46- Data da Solicitação</td>
                        <td class="ti" colspan="">47- Assinatura do Profissional Solicitante</td>
                        <td class="ti" colspan="3">49- Assinatura do Responsável pela Autorização</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="" class="tic"><strong></strong></td>
                        <td height="16" colspan="" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" colspan="3" class="tic"><strong>&nbsp;</strong></td>
                    </tr>
                </tbody>
            </table>
        <? } else { ?>
            <h4><?=$empresa[0]->razao_social?></h4> 
            <h4>Guia: <?= $guia_id ?></h4> 
            <h4>NÃO É POSSÍVEL GERAR A GUIA DE OPME SEM MATERIAIS CADASTRADOS NA GUIA</h4>
        <? } ?>


    </body>
</html>