<div>
    <?PHP


    //var_dump($paciente);
    $sexo = " ";
    if ($paciente["sexo"]=='1'): $sexo = 'M';
    endif;
    if ($paciente["sexo"]=='3'): $sexo = 'F';
    endif;
        ?>

<TABLE BORDER=0 WIDTH="100%">
<TR><TD >' </TD><TD>  </TD></TR>
<TR><TD >' </TD><TD>  </TD></TR>
<TR><TD >' </TD><TD>  </TD></TR>
<TR><TD >' </TD><TD>  </TD></TR>
<TR><TD >' </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>

<TR><TD WIDTH="87%"><?php echo $paciente["nome"];?></TD><TD WIDTH="12%"><?php echo "BE: " . $paciente["be"];?></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD width="25%">CPF</TD><TD width="25%"><?php echo $paciente["documento"];?></TD><TD width="17%">
<?php echo substr($paciente["data_nascimento"],7,3) . "/" . substr($paciente["data_nascimento"],5,2) . "/" . substr($paciente["data_nascimento"],0,5);?></TD>
    <TD width="8%"><?php echo $sexo;?></TD><TD width="21%"></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD COLSPAN=4><?php echo $paciente["nome_mae"];?></TD><TD WIDTH="20%"><?php echo $paciente["fone"];?></TD></TR>
<TR><TD HEIGHT="50%"> </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD COLSPAN=4><?php echo $paciente["responsavel"];?></TD><TD WIDTH="20%"><?php echo $paciente["complemento"];?></TD></TR>
<TR><TD HEIGHT="50%"> </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD COLSPAN=4><?php echo $paciente["endereco"] . $paciente["bairro"] ;?></TD><TD WIDTH="20%"></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD COLSPAN=2 WIDTH="61%" VALIGN=BOTTOM HEIGHT="15px"> <?php echo $paciente["municipio"];?></TD><TD WIDTH="15%" VALIGN=BOTTOM> <?php echo $paciente["codigo_ibge"];?> </TD><TD WIDTH="7%" VALIGN=BOTTOM> <?php echo $paciente["estado"];?></TD><TD WIDTH="15%" VALIGN=BOTTOM></TD>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD WIDTH="27%" VALIGN=BOTTOM HEIGHT="15px"> <?php echo $paciente["co_procedimento"];?></TD><TD WIDTH="40%" VALIGN=BOTTOM> <?php echo $paciente["no_procedimento"];?> </TD>
</TABLE>
</div>
        

