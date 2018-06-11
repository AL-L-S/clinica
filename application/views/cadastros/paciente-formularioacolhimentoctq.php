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
    <TR><TD align="center" > <font size="-2">INFORMA&Ccedil;&Otilde;ES DO PACIENTE <?php echo " BE CTQ Nº" . $paciente["be"];?> </font></TD><TD width="15%"><font size="-2"> Data:<?php echo" " . substr($paciente["data_abertura"],7,3) . "/" . substr($paciente["data_abertura"],5,2) . "/" . substr($paciente["data_abertura"],0,5);?> </font> </TD><TD width="10%"><font size="-2">Hora:<?php echo " " . substr($paciente["hora_abertura"],0,2) . ":" . substr($paciente["hora_abertura"],2,2)?></font> </TD></TR>
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
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="20%"><font size="-2">PA:</font></TD><TD width="20%"><font size="-2">P:</font> </TD><TD width="20%" ><font size="-2">FR:</font> </TD><TD width="20%" ><font size="-2">Temp: </font></TD><TD width="20%" ><font size="-2">SATO&sup2;: </font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="35%"><font size="-2">CLASSIFICA&Ccedil;&Atilde;O DE RISCO: </font>      &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<font size="-2"> &omicron; Vermelho </font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Laranje </font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Amarelo</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Verde</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Azul</font>&ensp;&ensp;&ensp;<font size="-2">&omicron; Nenhum</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%"><font size="-2"> Data e hora:<p><p><p><p></font></TD><TD width="40%" align="center"><font size="-2">Respons&aacute;vel pelo acolhimento(Carimbo/Ass.)<p><p><p><p></p> </font></TD><TD width="30%" align="center"><font size="-2">Ass. Paciente/Respons&aacute;vel <p><p><p><p></font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%"align="center"><font size="-1"> Atendimento M&eacute;dico</font></TD></TR>
    <TR><TD width="25%"><font size="-2"> Anamnese:</font></TD></TR>
    <TR><TD width="25%">&ensp;</TD></TR>
    <TR><TD width="25%">&ensp;</TD></TR>
    <TR><TD width="25%">&ensp;</TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="70%"><font size="-2">Diagn&oacute;tico</font></TD><TD width="20%"><font size="-2">C&oacute;digo</font></TD><TD width="10%"><font size="-2">CID</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%"><font size="-2">SADT &ensp;(&ensp;)HC&ensp;(&ensp;)SU&ensp;(&ensp;)PCR &ensp;(&ensp;)US ABDOMINAL &ensp;(&ensp;)TC CR&Acirc;NIO &ensp;(&ensp;)RAIO-X ______________________&ensp;(&ensp;)OUTROS</font></TD></TR>
    <TR><TD width="25%" align="left"><font size="-2">CONDUTA&ensp;</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="30%"><font size="-2">DATA E HORA DO ATENDIMENTO<p>&ensp;&ensp;   /&ensp;&ensp;    /&ensp;&ensp;    ÀS&ensp;&ensp;    h&ensp;&ensp;    </p></font></TD><TD width="70%" align="left"><font size="-2">CARIMBO E ASSINATURA DO M&Eacute;DICO ASSISTENTE<p>&ensp;</p></font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%"align="center"><font size="-1"> Parecer M&eacute;dico</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="30%"><font size="-2">Especialidade</font></TD><TD width="30%"><font size="-2">DATA E HORA DA SOLICITA&Ccedil;&Atilde;O &ensp;&ensp;   /&ensp;&ensp;    /&ensp;&ensp;    ÀS&ensp;&ensp;    h&ensp;&ensp;    </font></TD><TD width="40%"><font size="-2">CARIMBO E ASSINATURA DO M&Eacute;DICO SOLICITANTE</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%"><font size="-2">Exame Cl&iacute;nico</font></TD></TR>
    <TR><TD width="25%">&ensp;</TD></TR>
    <TR><TD width="25%">&ensp;</TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="70%"><font size="-2">Diagn&oacute;tico</font></TD><TD width="20%"><font size="-2">C&oacute;digo</font></TD><TD width="10%"><font size="-2">CID</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%" align="left"><font size="-2">CONDUTA&ensp;</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="30%"><font size="-2">DATA E HORA DO ATENDIMENTO<p>&ensp;&ensp;   /&ensp;&ensp;    /&ensp;&ensp;    ÀS&ensp;&ensp;    h&ensp;&ensp;    </p></font></TD><TD width="70%" align="left"><font size="-2">CARIMBO E ASSINATURA DO M&Eacute;DICO ASSISTENTE<p>&ensp;</p></font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%" align="center"><font size="-1">Prescri&ccedil;&atilde;o Ambulatorial</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="55%"><font size="-2">Prescri&ccedil;&atilde;o M&eacute;dica</font></TD><TD width="20%"><font size="-2">APRAZAMENTO</font></TD><TD width="25%"><font size="-2">OBSERVA&ccedil;&otilde;es</font></TD></TR>
    <TR><TD width="55%"><font size="-2">&ensp;</font></TD><TD width="20%"><font size="-2">&ensp;</font></TD><TD width="25%"><font size="-2">&ensp;</font></TD></TR>
    <TR><TD width="55%"><font size="-2">&ensp;</font></TD><TD width="20%"><font size="-2">&ensp;</font></TD><TD width="25%"><font size="-2">&ensp;</font></TD></TR>
    <TR><TD width="55%"><font size="-2">&ensp;</font></TD><TD width="20%"><font size="-2">&ensp;</font></TD><TD width="25%"><font size="-2">&ensp;</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="25%" align="center"><font size="-1">Tipo de Alta/Sa&Iacute;da</font></TD></TR>
</TABLE>
<TABLE BORDER=1 WIDTH="100%">
    <TR><TD width="40%"><font size="-2">(&ensp;)Decis&atilde;o M&eacute;dica&ensp;(&ensp;)A pedido&ensp;(&ensp;)Evas&atilde;o&ensp;<p>(&ensp;)Transfer&ecirc;ncia&ensp;(&ensp;)Interna&ccedil;&atilde;o&ensp;(&ensp;)Obito</p></font></TD><TD width="30%"><font size="-2">Carimbo / Ass. M&eacute;dico assistente<p>&ensp;</p></font></TD>
    <TD width="15%"><font size="-2">DATA<p>&ensp;</p></font></TD><TD width="15%"><font size="-2">HORA<p>&ensp;</p></font></TD></TR>
</TABLE>