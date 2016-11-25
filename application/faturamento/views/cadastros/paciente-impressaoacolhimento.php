<div>
    <?PHP


    //var_dump($paciente);
    $sexo = " ";
    if ($paciente["sexo"]=='1'): $sexo = 'MASCULINO';
    endif;
    if ($paciente["sexo"]=='3'): $sexo = 'FEMININO';
    endif;
        ?>

<TABLE BORDER=0 WIDTH="100%">
<TR><TD width="65%"></TD><TD> <?php echo  "Nº " . $paciente["behospub_id"]?> </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD WIDTH="65%" > </TD><TD>  </TD><TD><font size = -1 ><?php echo "Nº BE " . $paciente["be"];?> </font> </TD></TR>
<TR ><TD COLSPAN=2  WIDTH="62%"><font size = -1><?php echo $paciente["nome"];?></font></TD><TD WIDTH="45%"  ><font size = -1><?php echo substr($paciente["nome_mae"],0,30);?></font></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD width="54%"> </TD><TD COLSPAN=4 width="16%"><font size = -1><?php echo $sexo;?></font></TD><TD> <?php echo $paciente["idade"] ;?> </TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD COLSPAN=4 WIDTH="65%" ><font size = -1><?php echo $paciente["endereco"] ;?></font></TD><TD WIDTH="30%"><font size = -1><?php echo $paciente["bairro"];?></font></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD  WIDTH="20%" > <font size = -1><?php echo $paciente["estado"];?></font> </TD><TD WIDTH="20%" VALIGN=BOTTOM> <font size = -1><?php echo $paciente["municipio"];?> </font></TD><TD WIDTH="15%" VALIGN=BOTTOM></TD>
<TR ><TD ></TD><TD  ></TD><TD width="10%" ></TD><TD  valign="top" >
<font size = -1><?php echo "Data de Nascimento " . substr($paciente["data_nascimento"],7,3) . "/" . substr($paciente["data_nascimento"],5,2) . "/" . substr($paciente["data_nascimento"],0,5);?></font></TD>
    </TR>
</TABLE>
</div>
        

