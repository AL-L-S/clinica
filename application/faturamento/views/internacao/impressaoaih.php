
<div class="content ficha_ceatox">


    <table border="1">
        <tbody>
            <tr>
                <td width="650px" colspan="4" BGCOLOR=GRAY><b><center>LAUDO PARA SOLICITA&Ccedil;&Atilde;O DE INTERNA&Ccedil;&Atilde;O HOSPITALAR</center></b></td>
            </tr>
            <tr>
                <td colspan="4" BGCOLOR=GRAY><font size = -1><b><center>IDENTIFICACAO DO ESTABELECIMENTO DE SAUDE</center></b></font></td>
            </tr>
            <tr height="30px">
                <td colspan="3" style='vertical-align: top; font-family: serif; font-size: 6pt;'>NOME DO ESTABELECIMENTO SOLICITANTE:  &nbsp;<?= @$obj->_nome ?></td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CNES:</td>
            </tr>
            <tr height="30px">
                <td colspan="3" style='vertical-align: top; font-family: serif; font-size: 6pt;'>NOME DO ESTABELECIMENTO EXECUTANTE:  &nbsp;<?= @$obj->_nome ?></td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CNES:</td>
            </tr>
            <tr>
                <td colspan="4" BGCOLOR=GRAY><font size = -1><b><center>IDENTIFICACAO DO PACIENTE</center></b></font></td>
            </tr>
            <tr height="30px">
                <td colspan="3" style='vertical-align: top; font-family: serif; font-size: 6pt;'>NOME DO PACIENTE: &nbsp;<?= @$obj->_nome ?></td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>PRONTUARIO  &nbsp;<?= @$obj->_paciente_id ?></td>
            </tr>
            <tr height="30px">
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CARTAO NACIONAL DE SAUDE:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>NASC.:  &nbsp;<?= @$obj->_nascimento ?></td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>SEXO:  &nbsp;<?= @$obj->_sexo ?></td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>RACA/COR:</td>
            </tr>
            <tr height="30px">
                <td colspan="3" style='vertical-align: top; font-family: serif; font-size: 6pt;'>NOME MAE:  &nbsp;<?= @$obj->_nome ?></td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CONTATO: </td>
            </tr>
            <tr height="30px">
                <td colspan="3" style='vertical-align: top; font-family: serif; font-size: 6pt;'>NOME RESP.:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CONTATO: </td>
            </tr>
            <tr height="30px">
                <td colspan="3" style='vertical-align: top; font-family: serif; font-size: 6pt;'>ENDERE&Ccedil;O:  &nbsp;<?= @$obj->_logradouro ?>&nbsp;<?= @$obj->_numero ?></td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CONTATO: </td>
            </tr>
            <tr height="30px">
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>MUNICIPIO:  &nbsp;<?= @$obj->_nome ?></td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>COD.IBGE:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>UF:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CEP:</td>
            </tr>
            <tr>
                <td colspan="4" BGCOLOR=GRAY><font size = -1><b><center>JUSTIFICATIVA DA INTERNA&Ccedil;&Atilde;O</center></b></font></td>
            </tr>
            <tr height="200px">
                <td colspan="4" style='vertical-align: top; font-family: serif; font-size: 6pt;'>PRINCIPAIS SINAIS E SINTOMAS CLINICOS:  &nbsp;<?= @$obj->_texto?></td>
            </tr>
            <tr height="30px">
                <td colspan="4" style='vertical-align: top; font-family: serif; font-size: 6pt;'>CONDICOES QUE JUSTIFICAM A INTERNACAO:</td>
            </tr>
            <tr height="30px">
                <td colspan="4" style='vertical-align: top; font-family: serif; font-size: 6pt;'>PRINCIPAIS RESULTADOS DE PROVAS DIAGNOSTICAS (RESULTADOS DE EXAMES REALIZADOS):</td>
            </tr>
            <tr height="30px">
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>DIAGNOSTICO INICIAL:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CID 10 PRINCIPAL:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CID 10 SECUNDARIO:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CID 10 CAUSAS ASSOCIADAS:</td>
            </tr>
            <tr>
                <td colspan="4" BGCOLOR=GRAY><font size = -1><b><center>PROCEDIMENTO SOLICITADO</center></b></font></td>
            </tr>
            <tr height="30px">
                <td colspan="3" style='vertical-align: top; font-family: serif; font-size: 6pt;'>DESCRICAO DO PROCEDIMENTO SOLICITADO:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CODIGO DO PROCEDIMENTO: </td>
            </tr>
            <tr height="30px">
                <td colspan="2" style='vertical-align: top; font-family: serif; font-size: 6pt;'>CLINICA:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CARATER DA INTERNACAO:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>CPF</td>
            </tr>
            <tr height="30px">
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>NOME DO PROFISSIONAL SOLICITANTE:</td>
                <td style='vertical-align: top; font-family: serif; font-size: 6pt;'>DATA SOLICITACAO:</td>
                <td colspan="2" style='vertical-align: top; font-family: serif; font-size: 6pt;'>ASSINATURA E CARIMBO (No. CR):</td>
            </tr>
        </tbody>
    </table>

</div>

