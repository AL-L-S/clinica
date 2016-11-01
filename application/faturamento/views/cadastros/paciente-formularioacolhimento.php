    <?PHP


    //var_dump($paciente);
    $sexo = " ";
    if ($paciente["sexo"]=='1'): $sexo = 'MASCULINO';
    endif;
    if ($paciente["sexo"]=='3'): $sexo = 'FEMININO';
    endif;
        ?>
<a><img src="<?= base_url() ?>img/logoijf.gif" width="200" height="20" alt="teste"></a><a><center>Acolhimento <?php echo  " nº " . $paciente["behospub_id"]?></center></a>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD align="center" > <font size="-2">INFORMA&Ccedil;&Otilde;ES DO PACIENTE <?php echo " BE Nº" . $paciente["be"];?> </font></TD><TD width="15%"><font size="-2"> Data:<?php echo" " . substr($paciente["data_abertura"],7,3) . "/" . substr($paciente["data_abertura"],5,2) . "/" . substr($paciente["data_abertura"],0,5);?> </font> </TD><TD width="10%"><font size="-2">Hora:<?php echo " " . substr($paciente["hora_abertura"],0,2) . ":" . substr($paciente["hora_abertura"],2,2)?></font> </TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="50%" ><font size="-2">Nome: <?php echo  " " . $paciente["nome"];?></font> </TD><TD><font size="-2">Nome da m&atilde;e: <?php echo " " . substr($paciente["nome_mae"],0,30);?></font>  </TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
<TR><TD width="35%"><font size="-2">Estado civil:</font></TD><TD width="35%"><font size="-2">Sexo: <?php echo " ". $sexo;?></font> </TD><TD width="30%" ><font size="-2">Idade:<?php echo " " . $paciente["idade"] ;?><?php echo " -- Nascimento " . substr($paciente["data_nascimento"],7,3) . "/" . substr($paciente["data_nascimento"],5,2) . "/" . substr($paciente["data_nascimento"],0,5);?></font> </TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="50%" ><font size="-2">Resid&ecirc;ncia: <?php echo " " . $paciente["endereco"] ;?></font> </TD><TD><font size="-2">Bairro: <?php echo " " . $paciente["bairro"];?></font>  </TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="10%"><font size="-2">UF: <?php echo " " . $paciente["estado"];?></font></TD><TD width="35%"><font size="-2">Munic&iacute;pio: <?php echo " " . $paciente["municipio"];?></font> </TD><TD width="30%" ><font size="-2">Proced&ecirc;ncia: </font></TD><TD width="25%" ><font size="-2">Documento: <?php echo  " " . $paciente["documento"]?></font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="30%"><font size="-2">Regional&ensp; &omicron;&ensp;I&ensp; &omicron;&ensp;II&ensp; &omicron;&ensp;III&ensp;&omicron;&ensp;IV&ensp;&omicron;&ensp;V&ensp;&omicron;&ensp;VI&ensp;</font> </TD><TD width="15%"><font size="-2">H&aacute; quanto tempo: </font></TD> <TD WIDTH="8%"> <font size="-2">Dias: </font></TD> <TD WIDTH="8%"><font size="-2">Meses:</font></TD> <TD WIDTH="8%"><font size="-2">Ano:</font></TD><TD rowspan="3" width="14%" align="center" valign="top" > <font size="-2">DEMANDA ADMINISTRATIVA</font></TD></TR>
<TR><TD width="45%" colspan="5"><font size="-2">QUEIXAS<p></p></font> </TD></TR>
<TR><TD width="45%" colspan="5" ><font size="-2">SINAIS E</font><font size="-3"> <br></font> <font size="-2">SINTOMAS </font></TD></TR>
</TABLE>
<TABLE BORDER=1  WIDTH="100%">
<TR><TD COLSPAN=12 align="center" > <font size="-2"> SINAIS VITAIS </font> </TD></TR>
<TR><TD COLSPAN=12 align="center" > <font size="-2">Escala de dor Adulto</font> </TD></TR>
<TR><TD align="center" ><font size="-2">0</font></TD><TD align="center" WIDTH="6%"><font size="-2">1</font></TD><TD align="center" WIDTH="6%"><font size="-2">2</font></TD><TD align="center" WIDTH="6%"><font size="-2">3</font></TD><TD align="center" WIDTH="6%"><font size="-2">4</font></TD><TD align="center" WIDTH="6%"><font size="-2">5</font></TD><TD align="center" WIDTH="6%"><font size="-2">6</font></TD><TD align="center" WIDTH="6%"><font size="-2">7</font></TD><TD align="center" WIDTH="6%"><font size="-2">8</font></TD><TD align="center" WIDTH="6%" ><font size="-2">9</font></TD><TD align="center" WIDTH="6%" ><font size="-2">10</font></TD><TD WIDTH="34%" ><font size="-2">Pontos:</font></TD></TR>
<TR><TD align="center" WIDTH="12%" COLSPAN=2><font size = -2>Sem dor</font></TD><TD align="center" WIDTH="18%" COLSPAN=3 ><font size = -2>Dor leve</font></TD><TD align="center" WIDTH="18%" COLSPAN=3 ><font size = -2>Dor moderada</font></TD><TD align="center" WIDTH="12%" COLSPAN=2><font size = -2>Dor forte</font></TD><TD align="center" WIDTH="6%"><font size = -2>Pior dor possivel</font></TD><TD WIDTH="34%" ></TD></TR>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="20%" ><img src="<?= base_url() ?>img/tabelamauricio.GIF" width="330" height="85" alt="teste"></TD><TD width="70%"  ><img src="<?= base_url() ?>img/escalacomportamental.GIF" width="300" height="85" alt="teste" ></TD><TD width="15%" valign="top" >Pontos:</TD></TR>
</TABLE>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="20%"><font size="-2">PA:</font></TD><TD width="20%"><font size="-2">P:</font> </TD><TD width="20%" ><font size="-2">FR:</font> </TD><TD width="20%" ><font size="-2">Temp: </font></TD><TD width="20%" ><font size="-2">SATO&sup2;: </font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="35%"><font size="-2">CLASSIFICA&Ccedil;&Atilde;O DE RISCO: </font>      &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<font size="-2"> &omicron; Vermelho </font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Laranje </font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Amarelo</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Verde</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Azul</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Nenhum</font></TD></TR>
    <TR><TD width="35%"><font size="-2">REFER&Ecirc;NCIA PARA A REDE:     </font>  &ensp;&ensp;&ensp;&ensp;&ensp;<font size="-2"> &omicron; B&aacute;sica</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Secud&aacute;rio </font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Terci&aacute;rio</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Ambulat&aacute;rio especializado</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Pronto atendimento</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%"><font size="-2"> Data e hora:<p><p><p><p></font></TD><TD width="40%" align="center"><font size="-2">Respons&aacute;vel pelo acolhimento(Carimbo/Ass.)<p><p><p><p></p> </font></TD><TD width="30%" align="center"><font size="-2">Ass. Paciente/Respons&aacute;vel <p><p><p><p></font></TD></TR>
</TABLE>
<hr>
<p>
<br>
<a><img src="<?= base_url() ?>img/logoijf.gif" width="200" height="20" alt="teste"></a><a><center>Acolhimento <?php echo  " nº " . $paciente["behospub_id"]?></center></a>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD align="center" > <font size="-2">INFORMA&Ccedil;&Otilde;ES DO PACIENTE <?php echo " BE Nº" . $paciente["be"];?> </font></TD><TD width="15%"><font size="-2"> Data:<?php echo" " . substr($paciente["data_abertura"],7,3) . "/" . substr($paciente["data_abertura"],5,2) . "/" . substr($paciente["data_abertura"],0,5);?> </font> </TD><TD width="10%"><font size="-2">Hora:<?php echo " " . substr($paciente["hora_abertura"],0,2) . ":" . substr($paciente["hora_abertura"],2,2)?></font> </TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="50%" ><font size="-2">Nome: <?php echo  " " . $paciente["nome"];?></font> </TD><TD><font size="-2">Nome da m&atilde;e: <?php echo " " . substr($paciente["nome_mae"],0,30);?></font>  </TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
<TR><TD width="35%"><font size="-2">Estado civil:</font></TD><TD width="35%"><font size="-2">Sexo: <?php echo " ". $sexo;?></font> </TD><TD width="30%" ><font size="-2">Idade:<?php echo " " . $paciente["idade"] ;?><?php echo " -- Nascimento " . substr($paciente["data_nascimento"],7,3) . "/" . substr($paciente["data_nascimento"],5,2) . "/" . substr($paciente["data_nascimento"],0,5);?></font> </TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="50%" ><font size="-2">Resid&ecirc;ncia: <?php echo " " . $paciente["endereco"] ;?></font> </TD><TD><font size="-2">Bairro: <?php echo " " . $paciente["bairro"];?></font>  </TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="10%"><font size="-2">UF: <?php echo " " . $paciente["estado"];?></font></TD><TD width="35%"><font size="-2">Munic&iacute;pio: <?php echo " " . $paciente["municipio"];?></font> </TD><TD width="30%" ><font size="-2">Proced&ecirc;ncia: </font></TD><TD width="25%" ><font size="-2">Documento: <?php echo  " " . $paciente["documento"]?></font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="30%"><font size="-2">Regional&ensp; &omicron;&ensp;I&ensp; &omicron;&ensp;II&ensp; &omicron;&ensp;III&ensp;&omicron;&ensp;IV&ensp;&omicron;&ensp;V&ensp;&omicron;&ensp;VI&ensp;</font> </TD><TD width="15%"><font size="-2">H&aacute; quanto tempo: </font></TD> <TD WIDTH="8%"> <font size="-2">Dias: </font></TD> <TD WIDTH="8%"><font size="-2">Meses:</font></TD> <TD WIDTH="8%"><font size="-2">Ano:</font></TD><TD rowspan="3" width="14%" align="center" valign="top" > <font size="-2">DEMANDA ADMINISTRATIVA</font></TD></TR>
<TR><TD width="45%" colspan="5"><font size="-2">QUEIXAS<p></p></font> </TD></TR>
<TR><TD width="45%" colspan="5" ><font size="-2">SINAIS E</font><font size="-3"> <br></font> <font size="-2">SINTOMAS </font></TD></TR>
</TABLE>
<TABLE BORDER=1  WIDTH="100%">
<TR><TD COLSPAN=12 align="center" > <font size="-2"> SINAIS VITAIS </font> </TD></TR>
<TR><TD COLSPAN=12 align="center" > <font size="-2">Escala de dor Adulto</font> </TD></TR>
<TR><TD align="center" ><font size="-2">0</font></TD><TD align="center" WIDTH="6%"><font size="-2">1</font></TD><TD align="center" WIDTH="6%"><font size="-2">2</font></TD><TD align="center" WIDTH="6%"><font size="-2">3</font></TD><TD align="center" WIDTH="6%"><font size="-2">4</font></TD><TD align="center" WIDTH="6%"><font size="-2">5</font></TD><TD align="center" WIDTH="6%"><font size="-2">6</font></TD><TD align="center" WIDTH="6%"><font size="-2">7</font></TD><TD align="center" WIDTH="6%"><font size="-2">8</font></TD><TD align="center" WIDTH="6%" ><font size="-2">9</font></TD><TD align="center" WIDTH="6%" ><font size="-2">10</font></TD><TD WIDTH="34%" ><font size="-2">Pontos:</font></TD></TR>
<TR><TD align="center" WIDTH="12%" COLSPAN=2><font size = -2>Sem dor</font></TD><TD align="center" WIDTH="18%" COLSPAN=3 ><font size = -2>Dor leve</font></TD><TD align="center" WIDTH="18%" COLSPAN=3 ><font size = -2>Dor moderada</font></TD><TD align="center" WIDTH="12%" COLSPAN=2><font size = -2>Dor forte</font></TD><TD align="center" WIDTH="6%"><font size = -2>Pior dor possivel</font></TD><TD WIDTH="34%" ></TD></TR>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="20%" ><img src="<?= base_url() ?>img/tabelamauricio.GIF" width="330" height="85" alt="teste"></TD><TD width="70%"  ><img src="<?= base_url() ?>img/escalacomportamental.GIF" width="300" height="85" alt="teste" ></TD><TD width="15%" valign="top" >Pontos:</TD></TR>
</TABLE>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="20%"><font size="-2">PA:</font></TD><TD width="20%"><font size="-2">P:</font> </TD><TD width="20%" ><font size="-2">FR:</font> </TD><TD width="20%" ><font size="-2">Temp: </font></TD><TD width="20%" ><font size="-2">SATO&sup2;: </font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="35%"><font size="-2">CLASSIFICA&Ccedil;&Atilde;O DE RISCO: </font>      &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<font size="-2"> &omicron; Vermelho </font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Laranje </font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Amarelo</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Verde</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Azul</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Nenhum</font></TD></TR>
    <TR><TD width="35%"><font size="-2">REFER&Ecirc;NCIA PARA A REDE:     </font>  &ensp;&ensp;&ensp;&ensp;&ensp;<font size="-2"> &omicron; B&aacute;sica</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Secud&aacute;rio </font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Terci&aacute;rio</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Ambulat&aacute;rio especializado</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Pronto atendimento</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%"><font size="-2"> Data e hora:<p><p><p><p></font></TD><TD width="40%" align="center"><font size="-2">Respons&aacute;vel pelo acolhimento(Carimbo/Ass.)<p><p><p><p></p> </font></TD><TD width="30%" align="center"><font size="-2">Ass. Paciente/Respons&aacute;vel <p><p><p><p></font></TD></TR>
</TABLE>