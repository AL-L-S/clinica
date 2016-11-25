<div>
    <?PHP
    
    $sexo = " ";
    if ($paciente["sexo"]=='1'): $sexo = 'Masc';
    endif;
    if ($paciente["sexo"]=='3'): $sexo = 'Fem';
    endif;
        ?>

<TABLE BORDER=0 WIDTH="100%">
<TR><TD width="78%"><font size="-1">PREFEITURA DE FORTALEZA </font></TD><TD><font size="-1">Data <?php echo  $data?> </font></TD></TR>
<TR><TD width="78%"><font size="-1">INSTITUTO DR. JOSE FROTA </font></TD><TD><font size="-1">Hora <?php echo  $hora?> </font></TD></TR>
<TR><TD width="78%" align="center"><font size="-1">ASSESSORAMENTO A GERENCIA HOSPITALAR </font></TD><TD><font size="-1">Emitido: PINHEIRO </font></TD></TR>
</TABLE>
    <hr size="1">
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="70%" align="center" colspan="2"> <font size="2">FICHA DE FATURAMENTO DE AIH</font></TD></TR>
    <TR><TD width="70%" align="right"> <font size="-1">TIPO:</font></TD><TD><font size="-1"> 1 - INICIAL </font></TD></TR>
    <TR><TD width="70%"><font size="-1">N&deg; AIH: _______________________&ensp;Orgao Local CE: <?php echo $paciente["codigo_ibge"];?></font></TD><TD> <font size="-1">2 - CONTINUIDADE </font></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="70%"><font size="-1"> Prontuario: <?php echo  " " . $paciente["prontuario"]?>&ensp;&ensp;Data Interna&ccedil;&atilde;o: <?php echo substr($paciente["data_abertura"],7,3) . "/" . substr($paciente["data_abertura"],5,2) . "/" . substr($paciente["data_abertura"],0,5);?> </font></TD><TD><font size="-1">Data Saida:____/____/_______ </font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">Nome do Paciente: <?php echo $paciente["nome"];?></font></TD></TR>
    <TR><TD width="70%"><font size="-1">Endere&ccedil;o: <?php echo $paciente["endereco"];?></font></TD><TD><font size="-1">Municipio: <?php echo $paciente["municipio"];?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">UF: <?php echo $paciente["estado"];?>&ensp;CEP:__________________&ensp;Dt. Nasc. <?php echo substr($paciente["data_nascimento"],6,2) . "/" . substr($paciente["data_nascimento"],4,2) . "/" . substr($paciente["data_nascimento"],0,4);?>
        &ensp;Sexo: <?php echo $sexo?> &ensp; Nac: <?php echo  $paciente["nacionalidade"]?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">M&atilde;e: <?php echo $paciente["nome_mae"];?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">Pai: <?php echo $paciente["nome_pai"];?></font></TD></TR>
</TABLE>
    <hr size="1">
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="40%" ><font size="-1"> CPF: <?php echo $paciente["documento"];?></font></TD><TD width="15%" ><font size="-1">Enf: <?php echo $paciente["clinica"];?></font> </TD><TD><font size="-1">Leito: <?php echo $paciente["leito"];?></font> </TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="50%"><font size="-1">PROC SOLICITADO:___________________________</font></TD><TD><font size="-1">PROC REALIZADO:___________________________</font></TD></TR>
    <TR><TD width="50%"></TD><TD> </TD></TR>
    <TR><TD width="50%"><font size="-1">ESPECIALIDADE:____________________________</font></TD><TD><font size="-1">CARATER ATENDIMENTO:___________________ </font></TD></TR>
    <TR><TD width="50%"><font size="-1">CID PRINCIPAL:_____________________________</font></TD><TD><font size="-1">CID SECUNDARIO:___________________________</font> </TD></TR>
    <TR><TD width="50%"><font size="-1">CID CAUSAS ASSOC:__________________________</font></TD><TD><font size="-1">CID CAUSA MORTE:__________________________ </font></TD></TR>
    <TR><TD colspan="2"><font size="-1">MOTIVO SAIDA/PERMANENCIA:___________________________________________</font></TD></TR>
    <TR><TD width="50%"><font size="-1">CPF PROF SOLICITANTE:_____________________</font></TD><TD><font size="-1">CPF PROF RESPONSAVEL: 120.679.678.27</font></TD></TR>
    <TR><TD width="50%"><font size="-1">CPF DO AUTORIZADOR: 379.774.403.00</font></TD><TD><font size="-1">DATA AUTORIZA&Ccedil;&Atilde;O: _____/_____/_______</font> </TD></TR>
    <TR><TD width="50%"><font size="-1">AIH ANTERIOR: _______________________________</font></TD><TD><font size="-1">AIH POSTERIOR: ___________________________</font> </TD></TR>
</TABLE>
    <br>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="30%" align="center"><font size="-1"> PROCEDIMENTO</font></TD><TD width="2%" align="center"><font size="-1">QTDE </font></TD><TD width="18%" align="center"> <font size="-1">CPF / CNPJ</font> </TD><TD align="center" width="11%"> <font size="-1">CBO </font></TD><TD width="12%" align="center"> <font size="-1">EXECUTAR</font> </TD><TD  width="12%" align="center"> <font size="-1">APURAR</font> </TD></TR>
    <TR><TD width="30%">01</TD><TD><font size="4">&ensp; </font> </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">02</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">03</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">04</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">05</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp; </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">06</TD><TD><font size="4">&ensp; </font></TD><TD> &ensp; </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">07</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">08</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">09</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">10</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">11</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">12</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">13</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">14</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">15</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">16</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">17</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">18</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">19</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">20</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    <TR><TD width="30%">21</TD><TD><font size="4">&ensp;  </font></TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD><TD>&ensp;  </TD></TR>
    </TABLE>
    


</div>
        

