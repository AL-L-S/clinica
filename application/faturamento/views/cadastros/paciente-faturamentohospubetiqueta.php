<div>
    <?PHP


    
    
    $sexo = " ";
    if ($paciente["sexo"]=='1'): $sexo = 'Masculino';
    endif;
    if ($paciente["sexo"]=='3'): $sexo = 'Feminino';
    endif;
        ?>

<TABLE BORDER=0 WIDTH="100%">
<TR><TD width="35%"><font size="-1">INSTITUTO DR. JOSE FROTA </font></TD><TD width="35%" align="center"><font size="-1">IJF PROCESSAMENTO DE DADOS </font></TD><TD><font size="-1">Data <?php echo  $data?>  <?php echo "as" . $hora?> </font></TD></TR>
<TR><TD width="35%"><font size="-1">&ensp;</font></TD><TD width="35%" align="center"><font size="-1">Capa de Prontuario - SAME </font></TD><TD>&ensp;</TD></TR>
</TABLE>
<hr size="4">
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="70%"><font size="-1"> Prontuario: <?php echo  " " . $paciente["prontuario"]?>&ensp;&ensp; <?php echo $paciente["nome"];?></font></TD></TR>
    <TR><TD width="70%"><font size="-1">Data Nascimento <?php echo substr($paciente["data_nascimento"],6,2) . "/" . substr($paciente["data_nascimento"],4,2) . "/" . substr($paciente["data_nascimento"],0,4);?></font></TD><TD><font size="-1">CPF: <?php echo $paciente["documento"];?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">Sexo: <?php echo $sexo?> </font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">Pai: <?php echo $paciente["nome_pai"];?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">M&atilde;e: <?php echo $paciente["nome_mae"];?></font></TD></TR>
    <TR><TD width="70%"><font size="-1">Endere&ccedil;o: <?php echo $paciente["endereco"];?></font></TD><TD><font size="-1">Fone: <?php echo $paciente["fone"];?></font></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="40%" ><font size="-1"> Bairro: <?php echo $paciente["bairro"];?></font></TD><TD width="15%" ><font size="-1">Municipio: <?php echo $paciente["municipio"];?></font> </TD></TR>
    <TR><TD width="40%" ><font size="-1"> Naturalidade: <?php echo $paciente["naturalidade"];?></font></TD><TD width="15%" ><font size="-1">Nacionalidade: <?php echo $paciente["nacionalidade"];?></font> </TD></TR>
</TABLE>
<br>
<br>
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="40%" ><font size="-1"> Data Admiss&atilde;o: ______/______/___________</font></TD><TD width="15%" ><font size="-1">Municipio: <?php echo $paciente["municipio"];?></font> </TD></TR>
    <TR><TD width="40%" ><font size="-1"> Clinica: ____________&ensp; Enfermaria: _____________ &ensp; Leito: _____________</font></TD></TR>
</TABLE>
<h5 align="center">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ </h5>
</div>
        

