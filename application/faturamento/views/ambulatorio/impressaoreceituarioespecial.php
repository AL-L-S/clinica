<div id="esquerdo" style="float:left;">
<div >
    <table>
        </tr>        
        <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RECEITUARIO DE CONTROLE ESPECIAL</td>
        </tr>
    </table>
</div>
<br>
<div style="float:left;">
    <table border="1" style="border-collapse: collapse" >
        <tr >
            <th width="230px" colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>IDENTIFICA&Ccedil;&Atilde;O DO EMITENTE</th>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Nome: <? echo $laudo[0]->medico; ?></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>End: <? echo $laudo[0]->endempresa; ?> &nbsp; <? echo $laudo[0]->numeroempresa; ?></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>CRM:<? echo $laudo[0]->conselho; ?></td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Munic&iacute;pio:&nbsp;<? echo $laudo[0]->cidade; ?></td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>UF: &nbsp;<? echo $laudo[0]->estado; ?></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Telefone:&nbsp; <? echo $laudo[0]->telempresa; ?> / <? echo $laudo[0]->celularempresa; ?></td>
        </tr>
    </table>
</div>
<div style="float:left;" >
    <table >
        <tr >
            <td width="10px" colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>

<div >
    <table   style="border-collapse: collapse" >
        <tr >
            <th colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>1&acy; VIA: FARMACIA OU DROGARIA</th>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>2&acy; VIA: ORIENTA&Ccedil;&Atilde;O AO PACIENTE</td>
        </tr>

        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>&nbsp;</td>
        </tr>

        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><center>________________________</center></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><center>Carimbo do m&eacute;dico</center></td>
        </tr>
    </table>
</div>



<div >
    <table >
        <tr >
            <td width="10px" colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>
<div>
    <table>
        <tr >
            <td >Paciente:&nbsp; <? echo $laudo[0]->paciente; ?></td>
        </tr>
        <tr >
            <td >Endere&ccedil;o: &nbsp; <? echo $laudo[0]->logradouro; ?>&nbsp; <? echo $laudo[0]->numero; ?></td>
        </tr>
    </table>
</div>
<div>
    <table>
        <tr height="300px">
            <td >Prescri&ccedil;&atilde;o: &nbsp;<? echo $laudo[0]->texto; ?></td>
        </tr>
    </table>
</div>
<div >
    <table>
        <tr >
            <td style='font-family: serif; font-size: 8pt;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ______________________________ </td>
        <tr>
        </tr>
        <td style='font-family: serif; font-size: 8pt;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data:____/____/______ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Assinatura do medico </td>
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
</div>


<div id="direito" style="float:right;" >
<div >
    <table>
        </tr>        
        <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RECEITUARIO DE CONTROLE ESPECIAL</td>
        </tr>
    </table>
</div>
<br>
<div style="float:left;">
    <table border="1" style="border-collapse: collapse" >
        <tr >
            <th width="230px" colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>IDENTIFICA&Ccedil;&Atilde;O DO EMITENTE</th>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Nome: <? echo $laudo[0]->medico; ?></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>End: <? echo $laudo[0]->endempresa; ?> &nbsp; <? echo $laudo[0]->numeroempresa; ?></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>CRM:<? echo $laudo[0]->conselho; ?></td>
        </tr>
        <tr>
            <td colspan="2" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Munic&iacute;pio:&nbsp;<? echo $laudo[0]->cidade; ?></td>
            <td style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>UF: &nbsp;<? echo $laudo[0]->estado; ?></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>Telefone:&nbsp; <? echo $laudo[0]->telempresa; ?> / <? echo $laudo[0]->celularempresa; ?></td>
        </tr>
    </table>
</div>
<div style="float:left;" >
    <table >
        <tr >
            <td width="10px" colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>

<div >
    <table   style="border-collapse: collapse" >
        <tr >
            <th colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>1&acy; VIA: FARMACIA OU DROGARIA</th>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>2&acy; VIA: ORIENTA&Ccedil;&Atilde;O AO PACIENTE</td>
        </tr>

        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'>&nbsp;</td>
        </tr>

        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><center>________________________</center></td>
        </tr>
        <tr>
            <td colspan="3" style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><center>Carimbo do m&eacute;dico</center></td>
        </tr>
    </table>
</div>



<div >
    <table >
        <tr >
            <td width="10px" colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>
<div>
    <table>
        <tr >
            <td >Paciente:&nbsp; <? echo $laudo[0]->paciente; ?></td>
        </tr>
        <tr >
            <td >Endere&ccedil;o: &nbsp; <? echo $laudo[0]->logradouro; ?>&nbsp; <? echo $laudo[0]->numero; ?></td>
        </tr>
    </table>
</div>
<div>
    <table>
        <tr height="300px">
            <td >Prescri&ccedil;&atilde;o: &nbsp;<? echo $laudo[0]->texto; ?></td>
        </tr>
    </table>
</div>
<div >
    <table>
        <tr >
            <td style='font-family: serif; font-size: 8pt;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ______________________________ </td>
        <tr>
        </tr>
        <td style='font-family: serif; font-size: 8pt;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data:____/____/______ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Assinatura do medico </td>
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
</div>

