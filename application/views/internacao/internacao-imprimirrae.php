<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Impressão Evolução</title>
    </head>

    <body>
        <table id="tabelaspec" width="92%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp">
            <tbody>
                <tr>
                    <td width="58" height="51" style="font-size: 9px;"><p class="ttr"><strong style="font-weight: normal; text-align: center;"><strong style="font-weight: normal; text-align: left;"><img src="<?= base_url() ?>img/logorae.png" alt="" width="58" height="49" class="ttr"/></strong></strong></p></td>
                    <td width="127" class="ttrl" style="font-size: 9px;">&nbsp;</td>
                    <td height="51" colspan="4" class="ttrl" style="font-size: 10px; font-weight: normal; text-align: center;"><strong><? echo $empresa[0]->razao_social; ?><br>
                            <? echo $empresa[0]->logradouro; ?><? echo $empresa[0]->bairro; ?>&nbsp;N &nbsp;<? echo $empresa[0]->numero; ?> <br>
                            CNPJ:&nbsp; <? echo $empresa[0]->cnpj; ?><br>
                            Telefone:&nbsp; <? echo $empresa[0]->telefone; ?></strong></td>
                    <td height="51" colspan="2" class="ttl" style="font-size: 15px; font-weight: normal; text-align: right;"><strong>SUS</strong></td>
                </tr>
                <tr>
                    <td height="27" colspan="8" align="center" style="text-align: center; font-size: 15px; font-weight: normal;"><strong>REGISTRO DE ATENDIMENTO EMERGENCIAL</strong></td>
                </tr>
                <tr>
                    <td colspan="8" align="center" style="text-align:center;font-size: 9px;"><strong> DADOS PESSOAIS</strong></td>
                </tr>
                <tr>
                    <td colspan="6" class="ti">NOME</td>
                    <td colspan="2" class="ti">N° De Registro</td>
                </tr>
                <tr>
                    <td height="16" colspan="6" class="tc"><strong><? echo $lista[0]->paciente; ?></strong></td>
                    <td colspan="2" class="tc"><strong> <? echo $lista[0]->paciente_id; ?> </strong></td>
                </tr>
                <tr>
                    <td colspan="3" class="ti"><em class="ti" style="font-size: 7pt">TIPO DOC</em></td>
                    <td width="331" class="ti"><em>N DOC</em></td>
                    <td width="131" class="ti"><em>NASCIMENTO</em></td>
                    <td width="326" colspan="4" class="ti"><em>SEXO</em></td>

                </tr>
                <tr>
                    <td colspan="3" class="tc"><strong>RG</strong></td>
                    <td class="tc"><strong><? echo $lista[0]->rg; ?></strong></td>
                    <td class="tc"><strong><? $ano = substr($lista[0]->nascimento, 0, 4); ?>
                            <? $mes = substr($lista[0]->nascimento, 5, 2); ?>
                            <? $dia = substr($lista[0]->nascimento, 8, 2); ?>
                            <? $datafinal = $dia . '/' . $mes . '/' . $ano; ?>
                            <?php echo$datafinal ?></strong></td>
                    <td class="tc" colspan="4"><strong><? echo $lista[0]->sexo; ?></strong></td>

                </tr>

                <tr>
                    <td colspan="6" class="ti">NOME MÃE</td>
                    <td colspan="2" class="ti">CONTATO</td>
                </tr>
                <tr>
                    <td height="16" colspan="6" class="tc"><strong><? echo $lista[0]->nome_mae; ?></strong></td>
                    <td colspan="2" class="tc"><strong><? echo $lista[0]->telefoneresp; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="6" class="ti">NOME RESPONSÁVEL</td>
                    <td colspan="2" class="ti">CONTATO</td>
                </tr>
                <tr>
                    <td height="16" colspan="6" class="tc"><strong><? echo $lista[0]->nomeresp; ?></strong></td>
                    <td colspan="2" class="tc"><strong><? echo $lista[0]->telefoneresp; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="8" class="ti">ENDEREÇO</td>
                </tr>
                <tr>
                    <td height="16" colspan="8" class="tc"><strong><? echo $lista[0]->logradouro; ?> &nbsp;N&nbsp; <? echo $lista[0]->numero; ?> &nbsp; <? echo $lista[0]->complemento; ?> </strong></td>
                </tr>
                <tr>
                    <td colspan="5" class="ti">MUNICIPIO</td>
                    <td class="ti">COD IBGE</td>
                    <td width="91" class="ti">CEP</td>
                    <td width="174" class="ti">UF</td>
                </tr>
                <tr>
                    <td colspan="5" class="tc"><strong><? echo $lista[0]->municipio; ?></strong></td>
                    <td class="tc"><strong><? echo $lista[0]->codigo_ibge; ?></strong></td>
                    <td class="tc"><strong><? echo $lista[0]->cep; ?></strong></td>
                    <td class="tc"><strong><? echo $lista[0]->estado; ?></strong></td>
                </tr>


                <tr>
                    <td colspan="8" align="center" style="text-align:center;font-size: 9px;"><strong> ATENDIMENTO MÉDICO</strong></td>
                </tr>

                <tr>
                    <td height="13" colspan="4" class="ti">DIAGNÓSTICO</td>
                    <td colspan="2" class="ti">COD. PROCEDIMENTO</td>
                    <td colspan="2" class="ti">CID</td>
                </tr>
                <tr>
                    <td height="16" colspan="4" class="tc"><strong><? echo $lista[0]->diagnostico; ?></strong></td>
                    <td colspan="2" class="tc"><strong><? echo $lista[0]->cod; ?></strong></td>
                    <td colspan="2" class="tc"><strong><? echo $lista[0]->cid; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="8" class="ti">SADT SOLICITADO:</td>
                </tr>
                <tr>
                    <td height="27" colspan="8" class="tc"><strong>( ) HC ( ) SU ( ) US ABDOMINAL ( ) TC CRANIO ( ) RAIO-X __________________________________ ( ) OUTROS __________________________________</strong></td>
                </tr>
                <tr>
                    <td height="13" colspan="8" class="ti">CONDUTA</td>
                </tr>
                <tr>
                    <td height="16" colspan="8" class="tc"><strong><? echo $lista[0]->conduta; ?></strong></td>
                </tr>
                <tr>
                    <td height="13" colspan="4" class="ti">DATA E HORA DO ATENDIMENTO</td>
                    <td colspan="4" class="ti">CARIMBO E ASSINATURA DO MÉDICO ESPECIALISTA</td>
                </tr>
                <tr>
                    <td height="61" colspan="4" class="tc">&nbsp;</td>
                    <td colspan="4" class="tc">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
