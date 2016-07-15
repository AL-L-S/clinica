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
<TR><TD width="45%"> </TD><TD> <?php echo  "Nº" . $paciente["behospub_id"]?> </TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD width="70%"> </TD><TD width="20%"><font size="-1"> <?php echo substr($paciente["data_abertura"],7,3) . "/" . substr($paciente["data_abertura"],5,2) . "/" . substr($paciente["data_abertura"],0,5);?> </font> </TD></TR>
<TR><TD width="70%"> </TD><TD width="10%"><font size="-1"> <?php echo  substr($paciente["hora_abertura"],0,2) . ":" . substr($paciente["hora_abertura"],2,2)?></font> </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD width="90%"><?php echo $paciente["nome"];?></TD><TD WIDTH="10%"><?php echo $paciente["be"];?></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD width="22%"></TD><TD width="25%"></TD><TD width="16%">
<?php echo substr($paciente["data_nascimento"],7,3) . "/" . substr($paciente["data_nascimento"],5,2) . "/" . substr($paciente["data_nascimento"],0,5);?></TD>
    <TD width="7%"><?php echo $sexo;?></TD><TD width="21%"></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD COLSPAN=4><?php echo $paciente["nome_mae"];?></TD><TD WIDTH="20%"><?php echo $paciente["fone"];?></TD></TR>
<TR><TD HEIGHT="50%"> </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD COLSPAN=4><?php echo $paciente["responsavel"];?></TD><TD WIDTH="20%"><?php echo $paciente["complemento"];?></TD></TR>
<TR><TD HEIGHT="50%"> </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD COLSPAN=4><?php echo $paciente["endereco"] ;?> &ensp; <?php echo $paciente["bairro"] ;?></TD><TD WIDTH="20%"></TD></TR>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD COLSPAN=2 WIDTH="65%" VALIGN=BOTTOM HEIGHT="15px"> <?php echo $paciente["municipio"];?></TD><TD WIDTH="16%" VALIGN=BOTTOM> <?php echo $paciente["codigo_ibge"];?> </TD><TD WIDTH="7%" VALIGN=BOTTOM> <?php echo $paciente["estado"];?></TD><TD WIDTH="15%" VALIGN=BOTTOM></TD>
</TABLE>
<TABLE BORDER=0 WIDTH="100%">
<TR><TD > </TD><TD>  </TD></TR>
<TR><TD WIDTH="21%"><font size="-1">Motivo: <?php echo $paciente["motivo_atendimento_descricao"];?></font></TD><TD WIDTH="14%" VALIGN=BOTTOM><font size="-1">Acidente de Trabalho: <?php echo $paciente["acidente_trabalho"];?></font> </TD><TD WIDTH="10%" VALIGN=BOTTOM><font size="-1">Caso Policial: <?php echo $paciente["caso_policial"];?></font></TD><TD WIDTH="7%" VALIGN=BOTTOM><font size="-1">Ambulancia: <?php echo $paciente["caso_policial"];?></font></TD>
</TABLE>
</div>
        

