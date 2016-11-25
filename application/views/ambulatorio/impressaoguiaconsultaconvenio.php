
<div class="content ficha_ceatox">
    <table>
        <tbody>
            <tr>
                <td width=800 ><font size = 5><center>GUIA DE CONSULTA</center></td>
                <td width=190 ><font size = -1>2 - N Guia: </font><b><?= $exames[0]->guia_id; ?></b></td>
            </tr>           
        </tbody>
    </table>
    <table border="1">
        <tbody>
            <tr>
                <td width=200 valign="top" ><font size = -1>1 - Registro ANS</font> <br><b> <?= $exames[0]->registroans; ?></b></td>
                <td width=400 valign="top" ><font size = -1>3 - Numero da Guia Atribuido pela Operadora </font><br><b><?= $exames[0]->guiaconvenio; ?></b></td>
            </tr>           
        </tbody>
    </table>
    <p>Dados do Beneficiario</p>
    <table border="1">
        <tbody>
            <tr>
                <td width=600 valign="top" ><font size = -1>4 - Numero da Carteira</font> <br><b> <?= $exames[0]->convenionumero; ?></b></td>
                <td width=150 valign="top" ><font size = -1>5 - Validade da Carteira </font><br><b>&nbsp;</b></td>
                <td width=150 valign="top" ><font size = -1>6 - Atendimento a RN </font><br><b>N</b></td>
            </tr>           
        </tbody>
    </table>
    <table border="1">
        <tbody>
            <tr>
                <td width=600 valign="top"><font size = -1>7 - Nome</font> <br><b> <?= $exames[0]->paciente; ?></b></td>
                <td width=400 valign="top"><font size = -1>8 - Cartao Nacional de Saude </font><br><b>&nbsp;</b></td>
            </tr>           
        </tbody>
    </table>
<p>Dados do Contratado</p>
    <table border="1">
        <tbody>
            <tr>
                <td width=600 valign="top"><font size = -1>9 - Codigo na Operadora</font> <br><b> <?= $exames[0]->codigoidentificador; ?></b></td>
                <td width=200 valign="top"><font size = -1>10 - Nome do Contratado </font><br><b><?= $exames[0]->convenio; ?></b></td>
                <td width=190 valign="top"><font size = -1>11 - Codigo CNES </font><br><b>&nbsp;</b></td>
            </tr>           
        </tbody>
    </table>
    <table border="1">
        <tbody>
            <tr>
                <td width=500 valign="top"><font size = -1>12 - Nome do Profissional Executante </font> <br><b><?= $exames[0]->medicoagenda;?></b></td>
                <td width=90 valign="top"><font size = -1>13 - Conselho Profissional</font><br><b>&nbsp</b></td>
                <td width=200 valign="top" align="center"><font size = -1>14 - Numero no Conselho</font><br><b><?= $exames[0]->conselho;?></b></td>
                <td width=88 valign="top" align="center"><font size = -1>15 - UF</font><br><b><?= substr($exames[0]->cbo_ocupacao_id, 0, 2);?></b></td>
                <td width=100 valign="top" align="center"><font size = -1>16 - Codigo CBO</font><br><b><?= $exames[0]->cbo_ocupacao_id;?></b></td>
            </tr>           
        </tbody>
    </table>
<p>Dados de Atendimento / Procedimento Realizado</p>
    <table border="1">
        <tbody>
            <tr>
                <td width=600 valign="top"><font size = -1>17 - Indicacao de Acidente(acidente ou doenca relacionada)</font> <br><b>1</b></td>
            </tr>           
        </tbody>
    </table>
    <table border="1">
        <tbody>
            <tr>
                <td width=225 valign="top" ><font size = -1>18 - Data do Atendimento </font> <br><b><?= substr($exames[0]->data_autorizacao, 8, 2) . "/" . substr($exames[0]->data_autorizacao, 5, 2) . "/" . substr($exames[0]->data_autorizacao, 0, 4); ?></b></td>
                <td width=151 valign="top" ><font size = -1>19 - Tipo de Consulta</font><br><b>1</b></td>
                <td width=151 valign="top" ><font size = -1>20 - Tabela</font><br><b>22</b></td>
                <td width=225 valign="top" ><font size = -1>21 - Codigo Procedimento</font><br><b><?= $exames[0]->codigo;?></b></td>
                <td width=225 valign="top" ><font size = -1>22 - Valor do Procedimento</font><br><b><?= number_format($exames[0]->valor_total, 2, ',', '.');?></b></td>
            </tr>           
        </tbody>
    </table>


<table border="1" width=1015 height=130>
    <tr>
        <td valign="top">23 - Observacao / Justificativa
            
        </td>
    </tr>
</table>
    <table border="1">
        <tbody>
            <tr>
                <td width=499 ><font size = -1>24 - Assinatura do Profissional Executante</font> <br><b>&nbsp</b></td>
                <td width=498 ><font size = -1>25 - Assinatura do Beneficiario ou Responsavel</font> <br><b>&nbsp</b></td>
            </tr>           
        </tbody>
    </table>
</div>
