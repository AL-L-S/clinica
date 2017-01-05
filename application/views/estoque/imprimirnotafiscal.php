<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Nota Fiscal</title>
    </head>

    <body>
        <table id="tabelaspec" width="92%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp" style="border-bottom: 0px;">

            <tr>
                <td width="58" height="51" style="font-size: 9px;"><p class="ttr"><strong style="font-weight: normal; text-align: center;"><strong style="font-weight: normal; text-align: left;"><img src="<?= base_url() ?>img/logorae.png" alt="" width="58" height="49" class="ttr"/></strong></strong></p></td>
                <td width="127" class="ttrl" style="font-size: 9px;">&nbsp;</td>
                <td height="51" colspan="4" class="ttrl" style="font-size: 10px; font-weight: normal; text-align: center;"><strong><? echo $empresa[0]->razao_social; ?><br>
                        <? echo $empresa[0]->logradouro; ?><? echo $empresa[0]->bairro; ?>&nbsp;N &nbsp;<? echo $empresa[0]->numero; ?> <br>
                        CNPJ:&nbsp; <? echo $empresa[0]->cnpj; ?><br>
                        Telefone:&nbsp; <? echo $empresa[0]->telefone; ?></strong></td>
                <td height="51" colspan="2" class="ttl" style="font-size: 15px; font-weight: normal; text-align: right;"><strong>&nbsp;</strong></td>
            </tr>
            <tr>
                <td height="27" colspan="8" align="center" style="text-align: center; font-size: 15px; font-weight: normal;"><strong>Nota Fiscal</strong></td>
            </tr>
            <tr>
                <td colspan="2" class="tic">NATUREZA DA OPERAÇÃO</td>
                <td colspan="2" class="tic">CFOP</td>
                <td colspan="2" class="tic">INSC.ESTADUAL DO SUBSTITUTO TRIBUTÁRIO</td>
                <td colspan="1" class="tic">INSCRIÇÃO ESTADUAL</td>
                <td colspan="2" class="tic">CNPJ</td>
            </tr>
            <tr>
                <td height="30" colspan="2" class="tc"><strong></strong></td>
                <td height="30" colspan="2" class="tc"><strong></strong></td>
                <td height="30" colspan="2" class="tc"><strong></strong></td>
                <td height="30" colspan="1" class="tc"><strong></strong></td>
                <td height="30" colspan="2" class="tc"><strong></strong></td>
            </tr>
            <tr>
                <td colspan="8" align="center" style="text-align:center;font-size: 10px;"><strong> DESTINATÁRIO/REMETENTE</strong></td>
            </tr>
            <tr>
                <td width="30%" colspan="5" class="ti">NOME/RAZÃO SOCIAL</td>
                <td width="25%" colspan="2" class="ti">CPF/CNPJ</td>
                <td width="10%" colspan="1" class="ti">DATA DA EMISSÃO</td>
            </tr>
            <tr>
                <td height="16" colspan="5" class="tc"><strong><?= $destinatario[0]->nome ?></strong></td>
                <td colspan="2" class="tc"><strong><?= $destinatario[0]->cnpj ?></strong></td>
                <td colspan="1" class="tc"><strong></strong></td>
            </tr>

            <tr>
                <td colspan="5" class="ti">ENDEREÇO</td>
                <td class="ti">BARRO/DISTRITO</td>
                <td width="91" class="ti">CEP</td>
                <td width="10%" class="ti">DATA SAÍDA/ENTRADA</td>
            </tr>
            <tr>
                <td colspan="5" class="tc"><strong><?= $destinatario[0]->logradouro ?></strong></td>
                <td class="tc"><strong><?= $destinatario[0]->bairro ?></strong></td>
                <td class="tc"><strong><?= $destinatario[0]->cep ?></strong></td>
                <td class="tc"><strong></strong></td>
            </tr>
            <tr>
                <td colspan="3" class="ti">MUNICIPIO</td>
                <td colspan="2" class="ti">FONE/FAX</td>
                <td class="ti">UF</td>
                <td width="10%" width="91" class="ti">INSCRIÇÃO ESTADUAL</td>
                <td width="91" class="ti">HORA DA SAÍDA</td>
            </tr>
            <tr>
                <td colspan="3" class="tc"><strong>Dionisio Torres</strong></td>
                <td colspan="2" class="tc"><strong></strong></td>
                <td class="tc"><strong>CE</strong></td>
                <td class="tc"><strong></strong>
                <td class="tc"><strong></strong></td>
            </tr>
            <tr>
                <td colspan="8" align="center" style="text-align:center;font-size: 10px;"><strong> DADOS DO PRODUTO</strong></td>
            </tr>
        </table>
        <!--    <tr>
              <td colspan="8" align="center" style="text-align:center;font-size: 9px;"><strong>FATURA</strong></td>
            </tr>
            <tr>
              <td colspan="8"  class="ti">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" class="tc"><strong>ads </strong></td>
            </tr>-->
        <table id="tabelaspec" width="80%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp" style="border-bottom: 0px;">
            <tbody>

                    <tr >
                    <td width="15%" height="12" class="sembordadireitacimabaixo">CÓDIGO DO PRODUTO</td>
                    <td width="30%" colspan="1" class="semborda">DESCRIÇÃO DOS PRODUTOS</td>
                    <td width="10%" class="semborda">QUANTIDADE</td>

                    <td width="6%" colspan="1" class="semborda">CF</td>
                    <td width="6%" colspan="1" class="semborda">SIT.TRIB.</td>
                    <td width="5%" colspan="1" class="semborda">UNID</td>

                    <td width="10%" colspan="1" class="semborda">VALOR UNITÁRIO</td>
                    <td width="10%" colspan="1" class="semborda">VALOR TOTAL</td>
                    <td width="10%" colspan="1" class="semborda">ALÍQUOTAS (ICMS/IPI)</td>
                    <td width="10%" colspan="1" class="semborda">VALOR DO IPI</td>


                </tr>
                <?  
                $valortotal = 0;
                foreach ($produtos as $item){ ?>
                <tr>
                    <td class="semborda"><strong><?= $item->estoque_produto_id ?></strong></td>
                    <td colspan="1" class="semborda"><strong><?= $item->descricao ?></strong></td>
                    <td height="16" class="semborda"><strong><?= $item->quantidade ?></strong></td>

                    <td colspan="1" class="semborda"><strong></strong></td>
                    <td colspan="1" class="semborda"><strong></strong></td>
                    <td colspan="1" class="semborda"><strong></strong></td>
                    
                    <?
                    $v = (float) $item->valor_venda;
                    $a = (int) str_replace('.', '', $item->quantidade); 
                    $preco = (float) $a * $v; 
                    $valortotal += $preco;
                    ?>

                    <td colspan="1" class="semborda"><strong><?= $item->valor_venda ?></strong></td>
                    <td colspan="1" class="semborda"><strong><?= $item->descricao ?></strong></td>
                    <td colspan="1" class="semborda"><strong><?= $preco ?></strong></td>
                    <td colspan="1" class="semborda"><strong></strong></td>

                </tr>
                <?}?>

        </table>
        <table id="tabelaspec" width="92%" border="1" align="center" cellpadding="0" cellspacing="0" class="tipp" >
            <tr>
                <td colspan="8" align="center" style="text-align:center;font-size: 10px;border-top: 0px;"><strong> CÁLCULO DO IMPOSTO</strong></td>
            </tr>
            <tr class="tic">
                <td width="20%" height="13" class="tic">BASE DE CÁLCULO DO ICMS</td>
                <td width="10%" colspan="1" class="tic">VALOR DO ICMS</td>

                <td width="13%" colspan="1" class="tic">BASE DE CÁLCULO ICMS SUBSTIT. </td>

                <td width="20%" colspan="1" class="tic">VALOR DO ICMS SUBSTITUIÇÃO </td>
                <td width="10%" colspan="3" class="tic">VALOR TOTAL PRODUTOS </td>
                

            </tr>
            <tr>
                <td class="tc"><strong></strong></td>
                <td height="16" colspan="1" class="tc"><strong></strong></td>

                <td colspan="1" class="tc"><strong></strong></td>

                <td colspan="1" class="tc"><strong></strong></td>
                <td colspan="3" class="tc"><strong><?=$valortotal?></strong></td>
            </tr>
            <tr class="tic">
                <td width="20%" height="13" class="tic">VALOR DO FRETE</td>
                <td width="10%" colspan="1" class="tic">VALOR DO SEGURO</td>

                <td width="13%" colspan="1" class="tic">OUTRAS DESPESAS ACESSÓRIAS</td>

                <td width="20%" colspan="1" class="tic">VALOR TOTAL DO IPI </td>
                <td width="10%" colspan="3" class="tic">VALOR TOTAL DA NOTA </td>
                

            </tr>
            <tr>
                <td class="tc"><strong></strong></td>
                <td height="16" colspan="1" class="tc"><strong></strong></td>

                <td colspan="1" class="tc"><strong></strong></td>

                <td colspan="1" class="tc"><strong></strong></td>
                <td colspan="3" class="tc"><strong></strong></td>
            </tr>
     
            <tr>
                <td colspan="8" align="center" style="text-align:center;font-size: 10px;"><strong> DADOS ADICIONAIS</strong></td>
            </tr>
            <tr>
                <td colspan="2" class="tic">&nbsp;</td>
                <td colspan="2" class="tic">RESERVADO AO FISCO</td>
                <td colspan="3" class="tic">N° DE CONTROLE DO FORMULÁRIO</td>
            </tr>
            <tr>
                <td height="50" colspan="2" class="tc"><strong></strong></td>
                <td height="50" colspan="2" class="tc"><strong></strong></td>
                <td height="50" colspan="3" class="tc"><strong></strong></td>
            </tr>
            <tr>
                <td colspan="8" align="center" style="text-align:center;font-size: 10px;"><strong> DADOS ADICIONAIS</strong></td>
            </tr>
            <tr>
                <td height="13" colspan="3" class="ti">DATA DE RECEBIMENTO</td>
                <td colspan="2" class="ti">IDENTIFICAÇÃO E ASSINATURA DO RECEBEDOR</td>
                <td colspan="3" class="ti">NÚMERO DA NOTA FISCAL</td>
            </tr>
            <tr>
                <td height="16" colspan=3" class="tc"><strong></strong></td>
                <td colspan="2" class="tc"><strong></strong></td>
                <td colspan="3" class="tc"><strong></strong></td>
            </tr>
            <tr>
                <td height="13" colspan="4" class="ti">CÓDIGO DE BARRAS</td>
                <td colspan="4" class="ti">CARIMBO</td>
            </tr>
            <tr>
                <td height="61" colspan="4" class="tc">&nbsp;</td>
                <td colspan="4" class="tc">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
