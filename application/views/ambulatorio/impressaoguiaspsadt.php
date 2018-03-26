<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>/css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Guia de Serviço Profissional</title>
    </head>

    <body>
        <? if (count($relatorio) > 0) { ?>  
            <table id="tabelaspec" width="92%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>
                    <tr bgcolor="#B1B1B1">
                        <td width="133" height="51" style="font-size: 9px;"><p class="ttr">
                                <strong style="font-weight: normal; text-align: center;">
                                    <strong style="font-weight: normal; text-align: left;">
                                        <img src="<?= base_url() . $relatorio[0]->caminho_logo ?>"  width="133" height="49" class="ttr"/>
                                    </strong>
                                </strong></p></td>
                        <td height="51" colspan="8" class="ttrl" style="font-size: 9px;"><p>GUIA DE SERVIÇO PROFISSIONAL/SERVIÇO AUXILIAR DE
                            </p>
                            <p> DIAGNÓSTICO E TERAPIA - SP/SADT</p></td>
                        <td width="239" style="font-size: 9px;"><p>2-N° Guia no Prestador</p><p><strong><?= $relatorio[0]->guia_id ?></strong></p></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="ti">1- Registro ANS</td>
                        <td colspan="8" class="ti">2- Número da Guia Principal</td>

                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tc"><strong><?= $relatorio[0]->registroans ?></strong></td>
                        <td colspan="8" class="tc"><strong><?= $relatorio[0]->guiaconvenio ?> </strong></td>

                    </tr>
                    <tr>
                        <td colspan="3" class="ti">4- Data de autorização</td>
                        <td colspan="2" class="ti">5- Senha</td>

                        <td colspan="2" class="ti">6- Data de validade da Senha </td>
                        <td colspan="3" class="ti">7- Número da guia atribuida pela operadora</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="3" class="tc"><strong><? $ano = substr($relatorio[0]->data_autorizacao, 0, 4); ?>
                                <? $mes = substr($relatorio[0]->data_autorizacao, 5, 2); ?>
                                <? $dia = substr($relatorio[0]->data_autorizacao, 8, 2); ?>
                                <? $datafinal = $dia . '/' . $mes . '/' . $ano; ?>
                                <?php echo$datafinal ?></strong></td>
                        <td colspan="2" class="tc"><strong><?= $relatorio[0]->autorizacao; ?> </strong></td>
                        <td colspan="2" class="tc"><strong>&nbsp; </strong></td>
                        <td colspan="3" class="tc"><strong>&nbsp; </strong></td>
                    </tr>
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong > DADOS DO BENEFICIÁRIO</strong></td>
                    </tr>


                </tbody>
                <tbody>


                    <tr>
                        <td colspan="3" class="ti">8-Número da carteira</td>
                        <td width="259" colspan="1" class="ti">9-Validade da carteira</td>
                        <td colspan="4" class="ti">10- Nome</td>
                        <td width="208" colspan="1" class="ti">11-Cartão Nacional de saúde</td>
                        <td colspan="1" class="ti">12- Atendimento a RN</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="3" class="tc"><strong><? echo $relatorio[0]->convenionumero; ?></strong></td>
                        <td colspan="1" class="tc"><strong> </strong></td>
                        <td colspan="4" class="tc"><strong><?= $relatorio[0]->paciente; ?> </strong></td>
                        <td colspan="1" class="tc"><strong>&nbsp; </strong></td>
                        <td colspan="1" class="tc"><strong>&nbsp; </strong></td>
                    </tr>
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong > DADOS DO SOLICITANTE</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="ti">13-Código da Operadora</td>
                        <td colspan="8" class="ti">14- Nome do Contratado</td>

                    </tr>
                    <tr>
                        <td height="16" colspan="2" class="tc"><strong><? echo $relatorio[0]->codigoidentificador; ?></strong></td>
                        <td colspan="8" class="tc"><strong><? echo $empresa[0]->razao_social; ?> </strong></td>

                    </tr>

                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr class="tic">
                        <td width="20%" height="13" class="tic">15- Nome da Profissional Solicitante</td>
                        <td width="10%" colspan="1" class="tic">16- Conselho Profissional</td>

                        <td width="13%" colspan="1" class="tic">17- Número no Conselho </td>

                        <td width="4%" colspan="1" class="tic">18-UF </td>
                        <? $codigoUF = $this->utilitario->codigo_uf($relatorio[0]->codigo_ibge); ?>
                        <td width="13%" colspan="1" class="tic">19- Código CBO </td>
                        <td width="40%" colspan="1" class="tic">20- Assinatura do Profissional Solicitante</td>

                    </tr>
                    <tr>
                        <td class="tc"><strong><?= $relatorio[0]->solicitante; ?></strong></td>
                        <td height="16" colspan="1" class="tc"><strong>&nbsp;</strong></td>

                        <td colspan="1" class="tc"><strong><?= $relatorio[0]->conselho; ?> </strong></td>

                        <td colspan="1" class="tc"><strong><?= $codigoUF; ?> </strong></td>
                        <td colspan="1" class="tc"><strong><? echo $relatorio[0]->cbo; ?>  </strong></td>
                        <td colspan="1" class="tc"><strong> </strong></td>
                    </tr>
                    <tr>
                        <td colspan="10" align="center" bgcolor="#B1B1B1" style="text-align:left;font-size: 9px;"><strong > DADOS DA SOLICITAÇÃO/ PROCEDIMENTOS E EXAMES SOLICITADOS</strong></td>
                    </tr>
                    <tr class="tic">
                        <td width="20%" height="13" class="ti">21- Caráter do atendimento</td>
                        <td colspan="2" class="ti">22- Data da Solicitação</td>

                        <td colspan="3" class="ti">23- Indicação Clínica</td>
                    </tr>
                    <tr>
                        <td class="tic"><strong></strong></td>
                        <td height="16" colspan="2" class="tic"><strong></strong><strong> </strong></td>

                        <td colspan="3" class="tic"><strong><? //echo $relatorio[0]->carater_internacao;  ?> </strong><strong> </strong></td>
                    </tr>

                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr class="semborda">
                        <td width="16%" height="13" class="semborda">24- Tabela</td>
                        <td width="14%" class="semborda">25- Código do Procedimento </td>

                        <td width="47%" colspan="1" class="semborda">26- Descrição</td>
                        <td width="12%" colspan="1" class="semborda">27- Quantidade Solicitada</td>
                        <td width="11%" colspan="1" class="semborda">28- Quantidade Autorizada</td>

                    </tr>
                    <?
                    $valor_procedimento = 0;
                    ?>
                <!--<a onmouseover="style = 'color:red;cursor: pointer;'" onmouseout="style = 'color:white;'"style="" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoguiaconsultaspsadt/<?= $test->ambulatorio_guia_id; ?>');">-->
                    <? //= $test->ambulatorio_guia_id  ?>
                    <!--</a>-->
                    <? foreach ($relatorio as $value) { ?>

                        <tr>
                            <td class="semborda"><strong> <a onmouseover="style = 'color:red;cursor: pointer;'" onmouseout="style = 'color:black;'"style="" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoguiaconsultaspsadtprocedimento/<? echo $value->agenda_exames_id; ?>');">22 </a></strong></td>
                            <td height="16" class="semborda"><strong><a onmouseover="style = 'color:red;cursor: pointer;'" onmouseout="style = 'color:black;'"style="" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoguiaconsultaspsadtprocedimento/<? echo $value->agenda_exames_id; ?>');"><? echo $value->codigo_procedimento; ?> </a></strong></td>

                            <td colspan="1" class="semborda"><strong><a onmouseover="style = 'color:red;cursor: pointer;'" onmouseout="style = 'color:black;'"style="" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoguiaconsultaspsadtprocedimento/<? echo $value->agenda_exames_id; ?>');"><? echo $value->procedimento; ?> </a></strong></td>
                            <td colspan="1" class="semborda"><strong><? echo $value->quantidade; ?> </strong></td>
                            <td colspan="1" class="semborda"><strong><? echo $value->quantidade; ?></strong></td>
                        </tr>

                        <?
                        $valor_procedimento = $valor_procedimento + $value->valor;
                    }
                    ?>

                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr>
                        <td colspan="8" align="center" bgcolor="#B1B1B1" class="tic" style="text-align:left;font-size: 9px;"><strong > DADOS DO CONTRATADO EXECUTANTE</strong></td>
                    </tr>
                    <tr class="ti">
                        <td width="18%" height="13" class="ti">29- Código da Operadora</td>
                        <td width="39%" class="ti">30-Nome do Contratado</td>

                        <td colspan="2" class="ti">31- Código CNES</td>
                    </tr>
                    <tr>
                        <td class="tc"><strong><? echo $relatorio[0]->codigoidentificador; ?></strong></td>
                        <td height="16" class="tc"><strong><? echo $empresa[0]->razao_social; ?> </strong></td>

                        <td colspan="2" class="tc"><strong><?= $empresa[0]->cnes; ?> </strong><strong> </strong></td>
                    </tr>
                    <tr>
                        <td colspan="8" align="center" bgcolor="#B1B1B1" class="tic" style="text-align:left;font-size: 9px;"><strong > DADOS DO ATENDIMENTO</strong></td>
                    </tr>
                    <tr class="ti">
                        <td width="18%" height="13" class="ti">32- Tipo de atendimento</td>
                        <td class="ti">33- Indicação do Acidente (Acidente ou doença relacionada)</td>

                        <td width="20%" class="ti"> 34- Tipo de Consulta</td>
                        <td width="23%" colspan="1" class="ti">35- Motivo de Encerramento do Atendimento</td>

                    </tr>
                    <tr>
                        <td class="tc"><strong></strong></td>
                        <td height="16" class="tc"><strong></strong></td>

                        <td class="tc"><strong></strong></td>
                        <td colspan="1" class="tc"><strong> </strong></td>
                    </tr>
                    <tr>
                        <td colspan="8" align="center" bgcolor="#B1B1B1" class="tic" style="text-align:left;font-size: 9px;"><strong>DADOS DA EXECUÇÃO/PROCEDIMENTOS E EXAMES REALIZADOS</strong></td>
                    </tr>

                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr class="semborda">
                        <td width="3%" height="12" class="semborda">36- Data</td>
                        <td width="6%" class="semborda">37- Hora Inicial</td>

                        <td width="5%" colspan="1" class="semborda">38- Hora Final</td>
                        <td width="5%" colspan="1" class="semborda">39- Tabela</td>
                        <td width="10%" colspan="1" class="semborda">40- Código do Procedimento</td>
                        <td width="32%" colspan="1" class="semborda">41- Descrição</td>
                        <td width="4%" colspan="1" class="semborda">42- Qtde</td>
                        <td width="4%" colspan="1" class="semborda">43- Vla</td>
                        <td width="3%" colspan="1" class="semborda">44- Tec.</td>
                        <td width="8%" colspan="1" class="semborda">45- Fator Red./Acresc.</td>
                        <td width="10%" colspan="1" class="semborda">46- Valor Unitário (R$)</td>
                        <td width="10%" colspan="1" class="semborda">47- Valor Total (R$)</td>

                    </tr>
                    <? foreach ($relatorio as $value) { ?>

                        <tr>
                            <td class="semborda"><strong><? echo date("d-m-Y", strtotime($value->data)); ?>&nbsp;&nbsp;</strong></td>
                            <td height="16" class="semborda"><strong><? echo $value->inicio ?></strong></td>

                            <td colspan="1" class="semborda"><strong><? echo $value->fim ?></strong></td>
                            <td colspan="1" class="semborda"><strong>22 </strong></td>
                            <td colspan="1" class="semborda"><strong><? echo $value->codigo_procedimento; ?></strong></td>
                            <td colspan="1" class="semborda"><strong><? echo $value->procedimento; ?></strong></td>
                            <td colspan="1" class="semborda"><strong><? echo $value->quantidade; ?></strong></td>
                            <td colspan="1" class="semborda"><strong>&nbsp;</strong></td>
                            <td colspan="1" class="semborda"><strong>&nbsp;</strong></td>
                            <td colspan="1" class="semborda"><strong>&nbsp;</strong></td>
                            <td colspan="1" class="semborda"><strong><? echo number_format($value->valor, 2, ',', '.'); ?></strong></td>
                            <td colspan="1" class="semborda"><strong><? echo number_format($value->quantidade * $value->valor, 2, ',', '.'); ?></strong></td>
                        </tr>
                        <?
                    }
                    ?>

                    <tr>
                        <td colspan="12" align="center" bgcolor="#B1B1B1" class="tic" style="text-align:left;font-size: 9px;"><strong>IDENTIFICAÇÃO DO(s) PROFISSIONAL(is) EXECUTANTE(s)</strong></td>
                    </tr>



                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>

                    <tr class="semborda">
                        <td width="6%" height="12" class="semborda">48- Seq. Ref</td>
                        <td width="7%" class="semborda">49- Grau Part.</td>
                        <td width="13%" colspan="1" class="semborda">50- Código na operadora/CPF</td>
                        <td width="36%" colspan="1" class="semborda">51- Nome do Profissional</td>
                        <td width="10%" colspan="1" class="semborda">52- Conselho Profissional</td>
                        <td width="14%" class="semborda">53- Número no Conselho</td>
                        <td width="5%" colspan="1" class="semborda">54- UF</td>
                        <td width="9%" colspan="1" class="semborda">55- Código CBO</td>

                    </tr>

                    <? foreach ($relatorio as $value) { ?>
                        <tr>
                            <td height="16" class="semborda"><strong></strong><strong></strong></td>
                            <td class="semborda"><strong></strong><strong></strong></td>
                            <td colspan="1" class="semborda"><strong><?= $value->cpf_executante; ?></strong></td>
                            <td colspan="1" class="semborda"><strong><?= $value->executante; ?></strong></td>
                            <td colspan="1" class="semborda"><strong></strong></td>
                            <td class="semborda"><strong><?= $value->conselho_executante; ?></strong></td>
                            <td colspan="1" class="semborda"><strong><?= $codigoUF = $this->utilitario->codigo_uf($value->codigo_ibge_executante); ?></strong></td>
                            <td colspan="1" class="semborda"><strong><?= $value->cbo_executante; ?></strong></td>
                        </tr>
                    <? } ?>

                    <tr class="ti">
                        <td height="12" colspan="8" class="ti">56- Data de Realização de Procedimentos em Série &nbsp;&nbsp;&nbsp;&nbsp; 57- Assinatura do Beneficiário ou Responsável</td>
                    </tr>
                    <tr>
                        <td height="16" colspan="8" class="semborda"><strong>1- ___/___/_______&nbsp;&nbsp; _______________________________ 3- ___/___/_______&nbsp;&nbsp; _______________________________ 5- ___/___/_______&nbsp;&nbsp; _______________________________ 7- ___/___/_______&nbsp;&nbsp; _______________________________ 9- ___/___/_______&nbsp;&nbsp; _______________________________</strong></td>
                    </tr>
                    <tr>
                        <td height="16" colspan="8" class="semborda"><strong>2- ___/___/_______&nbsp;&nbsp; _______________________________ 4- ___/___/_______&nbsp;&nbsp; _______________________________ 6- ___/___/_______&nbsp;&nbsp; _______________________________ 8- ___/___/_______&nbsp;&nbsp; _______________________________ 10- ___/___/_______&nbsp;&nbsp; _______________________________</strong></td>
                    </tr>


                </tbody>

            </table>
            <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
                <tbody>
                    <tr>
                        <td height="13" colspan="10" class="ti">58- Observação / Justificativa</td>
                    </tr>
                    <tr>
                        <td height="34" colspan="10" class="tc"><strong></strong><strong></strong></td>
                    </tr>
                    <tr class="tic">
                        <td width="11%" height="13" class="tic">59- Total de Procedimentos(RS)</td>
                        <td width="13%" height="13" colspan="1" class="tic">60- Total de Taxas e Alugueis (RS)</td>
                        <td width="15%" height="13" class="tic">61- Total de Materiais (R$)</td>
                        <td width="17%" height="13" class="tic">62- Total de OPME (R$)</td>
                        <td width="16%" height="13" class="tic">63- Total de Medicamentos (R$)</td>
                        <td width="16%" height="13" class="tic">64- Total de Gases Medicinais (R$)</td>

                        <td width="12%" colspan="1" class="tic">65- Total Geral (R$)</td>
                    </tr>
                    <tr>
                        <td class="tc"><strong><?= number_format($valor_procedimento, 2, ',', '.'); ?></strong></td>
                        <td height="16" colspan="1" class="tc"><strong></strong></td>
                        <td height="16" colspan="1" class="tc"><strong></strong></td>
                        <td height="16" colspan="1" class="tc"><strong></strong></td>
                        <td height="16" colspan="1" class="tc"><strong></strong></td>
                        <td height="16" colspan="1" class="tc"><strong></strong></td>

                        <td colspan="1" class="tc"><strong><?= number_format($valor_procedimento, 2, ',', '.'); ?></strong> </td>
                    </tr>
                    <tr class="tic">
                        <td height="13" colspan="3" class="tic">66- Assinatura do Responsável Pela Autorização</td>
                        <td height="13" colspan="2" class="tic">67- Assinatura do beneficiário ou Responsável</td>
                        <td height="13" colspan="2" class="tic">68- Assinatura do Contratado</td>
                    </tr>
                    <tr>
                        <td height="20" colspan="3" class="tc">&nbsp;</td>
                        <td height="20" colspan="2" class="tc">&nbsp;</td>
                        <td height="20" colspan="2" class="tc">&nbsp;</td>
                    </tr>

                </tbody>

            </table>
        <? } else{?>
        <h4><?=$empresa[0]->razao_social?></h4> 
        <h4>Guia: <?=$guia_id?></h4> 
        <h4>NÃO É POSSÍVEL GERAR A GUIA - SP/SADT SEM PROCEDIMENTOS CADASTRADOS NA GUIA</h4> 
        
                             
        
       <? }
        ?>


    </body>
</html>