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
                            <p>GUIA DE SOLICITAÇÃO</p>
                            <p>DE INTERNAÇÃO</p>
                        </td>
                        <td colspan="2" width="239" style="font-size: 9px;">
                            <p>N° Guia no Prestador</p>
                            <p><strong></strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" class="ti">1- Registro ANS</td>
                        <td colspan="5" class="ti">2- Número da Guia Principal</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="1" class="tc"><strong><?= $relatorio[0]->registroans ?></strong></td>
                        <td colspan="5" class="tc"><strong>&nbsp; </strong></td>
                    </tr>                    
                    <tr>
                        <td colspan="2" class="ti">4- Data de autorização</td>
                        <td colspan="2" class="ti">5- Senha</td>

                        <td colspan="2" class="ti">6- Data de validade da Senha </td>
                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tc"><strong>
                                <? 
                                if($relatorio[0]->data_autorizacao != ''){
                                    $ano = substr($relatorio[0]->data_autorizacao, 0, 4); 
                                    $mes = substr($relatorio[0]->data_autorizacao, 5, 2); 
                                    $dia = substr($relatorio[0]->data_autorizacao, 8, 2); 
                                    $datafinal = $dia . '/' . $mes . '/' . $ano; 
                                    echo $datafinal;
                                }?></strong></td>
                        <td colspan="2" class="tc"><strong>&nbsp; </strong></td>
                        <td colspan="2" class="tc"><strong>&nbsp; </strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="6" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong>DADOS DO BENEFICIÁRIO</strong></td>
                    </tr>
                </tbody>
                
                <tbody>
                    <tr>
                        <td colspan="4" class="ti">7-Número da carteira</td>
                        <td width="259" colspan="1" class="ti">8-Validade da carteira</td>
                        <td width="259" colspan="1" class="ti">9-Atendimento RN</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="4" class="tc"><strong><? echo $relatorio[0]->convenionumero; ?></strong></td>
                        <td colspan="1" class="tc"><strong></strong></td>
                        <td colspan="1" class="tc"><strong>&nbsp; </strong></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="ti">10- Nome</td>
                        <td width="208" colspan="1" class="ti">11-Cartão Nacional de saúde</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="tc"><strong><?= $relatorio[0]->paciente; ?></strong></td>
                        <td colspan="1" class="tc"><strong>&nbsp; </strong></td>
                    </tr>
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong > DADOS DO CONTRATADO SOLICITANTE</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="ti">12-Código da Operadora</td>
                        <td colspan="4" class="ti">13-Nome do Contratado</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tc"><strong><? echo $relatorio[0]->codigoidentificador; ?></strong></td>
                        <td colspan="8" class="tc"><strong></strong></td>

                    </tr>

                    <tr class="tic">
                        <td width="20%" colspan="2" height="13" class="tic">14- Nome da Profissional Solicitante</td>
                        <td width="10%" colspan="1" class="tic">15- Conselho Profissional</td>
                        <td width="13%" colspan="1" class="tic">16- Número no Conselho </td>
                        <td width="4%" colspan="1" class="tic">17- UF </td>
                        <? $codigoUF = $this->utilitario->codigo_uf($relatorio[0]->codigo_ibge); ?>
                        <td width="13%" colspan="1" class="tic">18- Código CBO </td>

                    </tr>
                    <tr>
                        <td class="tc" colspan="2"><strong><?= $relatorio[0]->solicitante; ?></strong></td>
                        <td height="16" colspan="1" class="tc"><strong>&nbsp;</strong></td>

                        <td colspan="1" class="tc"><strong><?= $relatorio[0]->conselho; ?> </strong></td>

                        <td colspan="1" class="tc"><strong><?= $codigoUF; ?> </strong></td>
                        <td colspan="1" class="tc"><strong><? echo $relatorio[0]->cbo; ?>  </strong></td>
                    </tr>
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong>DADOS DO HOSPITAL /LOCAL SOLICITADO /DADOS DA INTERNAÇÃO</strong></td>
                    </tr>
                    
                    <tr class="tic">
                        <td width="20%" height="13" colspan="2" class="ti">19- Código na Operadora / CNPJ</td>
                        <td colspan="2" class="ti">20- Nome do Hospital/Local Solicitado</td>
                        <td class="ti" colspan="2">21- Data sugerida para internação</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tic"><strong><? echo $relatorio[0]->cnpj; ?></strong></td>
                        <td height="16" colspan="2" class="tic"><strong><? echo $relatorio[0]->hospital; ?></strong></td>
                        <td height="16" colspan="2" class="tic"><strong></strong></td>
                    </tr>
                    
                    <tr class="tic">
                        <td width="20%" height="13" class="ti">22- Caráter do Atendimento</td>
                        <td width="10%" height="13" class="ti">23- Tipo de Internação</td>
                        <td width="10%" height="13" class="ti">24- Regime de Internação</td>
                        <td width="20%" height="13" class="ti">25- Qtde. Diárias Solicitadas</td>
                        <td width="20%" height="13" class="ti">26- Previsão de uso de OPME</td>
                        <td width="20%" height="13" class="ti">27- Previsão de uso de quimioterápico</td>
                    </tr>
                    <tr>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                    </tr>
                    
                    <tr class="tic">
                        <td width="100%" height="13" class="ti" colspan="6">28- Indicação Clinica</td>
                    </tr>
                    <tr>
                        <td height="46" class="tic" colspan="6"><strong><? echo $relatorio[0]->indicacao_clinica; ?></strong></td>
                    </tr>
                    <tr class="tic">
                        <td width="10%" height="13" class="ti">29- CID 10 Principal</td>
                        <td width="10%" height="13" class="ti">30- CID 10 (2)</td>
                        <td width="10%" height="13" class="ti">31- CID 10 (3)</td>
                        <td width="10%" height="13" class="ti">32- CID 10 (4)</td>
                        <td width="60%" height="13" class="ti" colspan="2">33- Indicação de Acidente (acidente ou doença relacionada)</td>
                    </tr>
                    <tr>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" class="tic" colspan="2"><strong>&nbsp;</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong>PROCEDIMENTOS SOLICITADOS</strong></td>
                    </tr>
                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr class="semborda">
                        <td width="16%" height="13" class="semborda">34- Tabela</td>
                        <td width="14%" class="semborda">35- Código do Procedimento </td>
                        <td width="47%" colspan="2" class="semborda">36- Descrição</td>
                        <td width="12%" colspan="1" class="semborda">37- Quantidade Solicitada</td>
                        <td width="11%" colspan="1" class="semborda">38- Quantidade Autorizada</td>
                    </tr>
                    <? foreach($procedimentos as $value) { ?>
                        <tr>
                            <td class="semborda"><strong>22</strong></td>
                            <td height="16" class="semborda"><strong><?= $value->codigo ?></strong></td>
                            <td colspan="2" class="semborda"><strong><?= $value->procedimento ?></strong></td>
                            <td colspan="1" class="semborda"><strong><?= $value->quantidade ?></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        
            <table id="tabelaspec" width="92%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>
                    <tr>
                        <td colspan="6" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong>DADOS DA AUTORIZAÇÃO</strong></td>
                    </tr>
                    <tr class="tic">
                        <td width="20%" height="13" colspan="2" class="ti">39- Data Provável da Admissão Hospitalar</td>
                        <td colspan="" class="ti">40- Qtde. Diarias Autorizadas</td>
                        <td class="ti" colspan="3">41- Tipo da Acomodação Autorizada</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" colspan="" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" colspan="3" class="tic"><strong>&nbsp;</strong></td>
                    </tr>                    
                    <tr class="tic">
                        <td width="20%" height="13" colspan="2" class="ti">42- Código na Operadora / CNPJ autorizado</td>
                        <td colspan="3" class="ti">43- Nome do Hospital / Local Autorizado</td>
                        <td class="ti" colspan="">44- Código CNES</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" colspan="3" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" colspan="1" class="tic"><strong>&nbsp;</strong></td>
                    </tr>
                    
                    <tr class="tic">
                        <td class="ti" colspan="6">45- Observação / Justificativa</td>
                    </tr>
                    <tr>
                        <td height="40" colspan="6" class="tic"><strong><? echo $relatorio[0]->observacao ?></strong></td>
                    </tr>
                    
                    <tr class="tic">
                        <td width="20%" height="13" colspan="" class="ti">46- Data da Solicitação</td>
                        <td class="ti" colspan="">47- Assinatura do Profissional Solicitante</td>
                        <td class="ti" colspan="">48- Assinatura do Beneficiário ou Responsável</td>
                        <td class="ti" colspan="3">49- Assinatura do Responsável pela Autorização</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="" class="tic"><strong></strong></td>
                        <td height="16" colspan="" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" colspan="" class="tic"><strong>&nbsp;</strong></td>
                        <td height="16" colspan="3" class="tic"><strong>&nbsp;</strong></td>
                    </tr>
                </tbody>
            </table>
        <? } else { ?>
            <h4><?=$empresa[0]->razao_social?></h4> 
            <h4>Guia: <?= $guia_id ?></h4> 
            <h4>NÃO É POSSÍVEL GERAR A GUIA DE INTERNAÇÃO SEM PROCEDIMENTOS CADASTRADOS NA GUIA</h4>
        <? } ?>


    </body>
</html>
