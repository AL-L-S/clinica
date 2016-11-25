<div style="float:left;">
    <table border="1" style="border-collapse: collapse" >
        <tr >
            <th width="300px" colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>IDENTIFICA&Ccedil;&Atilde;O DO EMITENTE</th>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Nome Completo: <? echo $laudo[0]->medico; ?></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Endere&ccedil;o Completo: </td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>CRM:<? echo $laudo[0]->conselho; ?></td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>UF: CE</td>
        </tr>
        <tr>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Munic&iacute;pio:</td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>UF: </td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Telefone: </td>
        </tr>
    </table>
</div>
<div style="float:left;">
    <table >
        <tr >
            <td width="210px" colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>
<table border="1" style="border-collapse: collapse" >
    <tr >
        <th width="300px" colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>IDENTIFICA&Ccedil;&Atilde;O DO EMITENTE</th>
    </tr>
    <tr>
        <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Nome Completo: <? echo $laudo[0]->medico; ?></td>
    </tr>
    <tr>
        <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Endere&ccedil;o Completo: </td>
    </tr>
    <tr>
        <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>CRM:<? echo $laudo[0]->conselho; ?></td>
        <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>UF: CE</td>
    </tr>
    <tr>
        <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Munic&iacute;pio:</td>
        <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>UF: </td>
        <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Telefone: </td>
    </tr>
</table>
<br>
<div style="float:left;">
    <table>
        <tr>
            <td width="300px" colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Paciente: <? echo $laudo[0]->paciente; ?></td>
        </tr>
        <tr>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>R.G.:<? echo $laudo[0]->rg; ?></td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>&Oacute;rg&atilde;o Emissor:<? echo $laudo[0]->uf_rg; ?></td>
        </tr>
        <tr>
            <td width="300px" colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Endere&ccedil;o:<? echo $laudo[0]->tipologradouro; ?> <? echo $laudo[0]->logradouro; ?> n:<? echo $laudo[0]->numero; ?> <? echo $laudo[0]->cidade; ?></td>
        </tr>
    </table>
</div>
<div style="float:left;">
    <table >
        <tr >
            <td width="210px" colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>
<table>
    <tr>
        <td width="300px" colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Paciente: <? echo $laudo[0]->paciente; ?></td>
    </tr>
    <tr>
        <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>R.G.:<? echo $laudo[0]->rg; ?></td>
        <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>&Oacute;rg&atilde;o Emissor:<? echo $laudo[0]->uf_rg; ?></td>
    </tr>
    <tr>
        <td width="300px" colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Endere&ccedil;o:<? echo $laudo[0]->tipologradouro; ?> <? echo $laudo[0]->logradouro; ?> n:<? echo $laudo[0]->numero; ?> <? echo $laudo[0]->cidade; ?></td>
    </tr>
</table>

<div style="float:left;">
    <table>
        <tr height="340px">
            <td width="450px" ><? echo $laudo[0]->texto; ?>

            </td>
        </tr>
    </table>
</div>
<div style="float:left;">
    <table >
        <tr >
            <td width="50px" colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>
<div>
    <table>
        <tr height="340px">
            <td width="450px" ><? echo $laudo[0]->texto; ?>

            </td>
        </tr>
    </table>
</div>

<div style="float:left;">
    <table border="1" style="border-collapse: collapse" >
        <tr >
            <th colspan="2" width="220px" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>IDENTIFICA&Ccedil;&Atilde;O DO COMPRADOR</th><th width="220px" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>IDENTIFICA&Ccedil;&Atilde;O DO FORNECEDOR</th>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Nome:</td>
            <td rowspan="4" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'></td>
        </tr>
        <tr>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>R.G.:</td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Emissor:</td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>End.:</td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>&nbsp;</td>
        </tr>
        <tr>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Munic&iacute;pio:</td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>UF:</td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Telefone:</td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Ass. do Farmac&ecirc;utico - Data:</td>
        </tr>
    </table>
</div>
<div style="float:left;">
    <table >
        <tr >
            <td width="70px" colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>
<div >
    <table border="1" style="border-collapse: collapse" >
        <tr >
            <th colspan="2" width="220px" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>IDENTIFICA&Ccedil;&Atilde;O DO COMPRADOR</th><th width="220px" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>IDENTIFICA&Ccedil;&Atilde;O DO FORNECEDOR</th>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Nome:</td>
            <td rowspan="4" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'></td>
        </tr>
        <tr>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>R.G.:</td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Emissor:</td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>End.:</td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>&nbsp;</td>
        </tr>
        <tr>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Munic&iacute;pio:</td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>UF:</td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Telefone:</td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Ass. do Farmac&ecirc;utico - Data:</td>
        </tr>
    </table>
</div>