<div class="content">
    <?PHP
    $motivo = " ";
    if ($paciente["motivo"]=='1'): $motivo = 'ALTA';
    endif;
    if ($paciente["motivo"]=='2'): $motivo = 'REMO&Ccedil;&Atilde;O';
    endif;
    if ($paciente["motivo"]=='3'): $motivo = 'Obito ate 24 horas';
    endif;
    if ($paciente["motivo"]=='4'): $motivo = 'Obito apos 24 horas';
    endif;
    if ($paciente["motivo"]=='5'): $motivo = 'Alta - Ambulatorial';
    endif;
    $estadomotivo = " ";
    if ($paciente["motivoestado"]=='1'): $estadomotivo = 'CURADO';
    endif;
    if ($paciente["motivoestado"]=='2'): $estadomotivo = 'MELHORADO';
    endif;
    if ($paciente["motivoestado"]=='3'): $estadomotivo = 'INALTERADO';
    endif;
    if ($paciente["motivoestado"]=='4'): $estadomotivo = 'A PEDIDO';
    endif;
    if ($paciente["motivoestado"]=='5'): $estadomotivo = 'INT. P/ DIAG.';
    endif;
    if ($paciente["motivoestado"]=='6'): $estadomotivo = 'ADMINISTRATIVA';
    endif;
    if ($paciente["motivoestado"]=='7'): $estadomotivo = 'P/ INDISCIPLINA';
    endif;
    if ($paciente["motivoestado"]=='8'): $estadomotivo = 'EVAS&Atilde;O';
    endif;
    if ($paciente["motivoestado"]=='9'): $estadomotivo = 'P/ COMPLEMENTA&Ccedil;&Atilde;O';
    endif;



    $sexo = " ";
    if ($paciente["sexo"]=='1'): $sexo = 'Masculino';
    endif;
    if ($paciente["sexo"]=='3'): $sexo = 'Feminino';
    endif;
        ?>

<TABLE BORDER=0 WIDTH="100%">
<TR><TD width="35%"><font size="-1">INSTITUTO DR. JOSE FROTA </font></TD><TD width="35%" align="center"><font size="-1">IJF PROCESSAMENTO DE DADOS </font></TD><TD><font size="-1">Data <?php echo  $data?>  <?php echo "as" . $hora?> </font></TD></TR>
<TR><TD width="35%"><font size="-1">&ensp;</font></TD><TD width="35%" align="center"><font size="-1">Declara&ccedil;&atilde;o de Comparecimento - SAME </font></TD><TD>&ensp;</TD></TR>
</TABLE>
<hr size="4">
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="70%"><font size="-1"> Prontuario: <?php echo  " " . $paciente["prontuario"]?>&ensp;&ensp; <?php echo $paciente["nome"];?></font></TD></TR>
    <TR><TD width="70%"><font size="-1">Data Nascimento <?php echo substr($paciente["data_nascimento"],7,3) . "/" . substr($paciente["data_nascimento"],5,2) . "/" . substr($paciente["data_nascimento"],0,5);?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">Sexo: <?php echo $sexo?> </font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">Pai: <?php echo $paciente["nome_pai"];?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">M&atilde;e: <?php echo $paciente["nome_mae"];?></font></TD></TR>
</TABLE>
<hr>
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="40%" ><font size="-1">Data Atendimento: <?php echo substr($paciente["data_abertura"],7,3) . "/" . substr($paciente["data_abertura"],5,2) . "/" . substr($paciente["data_abertura"],0,5);?></font></TD><TD width="15%" ><font size="-1">Hora Atendimento:<?php echo  substr($paciente["hora_abertura"],0,2) . ":" . substr($paciente["hora_abertura"],2,2)?></font> </TD><TD width="15%" ><font size="-1">BE: <?php echo $paciente["be"];?></font> </TD></TR>
    <TR><TD width="40%" ><font size="-1">Data Interna&ccedil;&atilde;o: <?php echo substr($paciente["data_internacao"],7,3) . "/" . substr($paciente["data_internacao"],5,2) . "/" . substr($paciente["data_internacao"],0,5);?></font></TD><TD width="15%" ><font size="-1">Hora Interna&ccedil;&atilde;o:<?php echo  substr($paciente["hora_internacao"],0,2) . ":" . substr($paciente["hora_internacao"],2,2)?></font> </TD><TD width="15%" ><font size="-1"></font> </TD></TR>
    <TR><TD width="40%" ><font size="-1">Data Saida:<?php echo substr($paciente["data_alta"],7,3) . "/" . substr($paciente["data_alta"],5,2) . "/" . substr($paciente["data_alta"],0,5);?></font></TD><TD width="15%" ><font size="-1">Hora Saida:<?php echo  substr($paciente["hora_alta"],0,2) . ":" . substr($paciente["hora_alta"],2,2)?></font> </TD><TD width="15%" ><font size="-1"></font> </TD></TR>
    <TR><TD width="40%" colspan="3" ><font size="-1">Medico: CRM <?php echo $paciente["crm"];?><?php echo $paciente["medico"];?></font></TD></TR>
    <TR><TD width="40%" ><font size="-1"><?php echo $motivo;?> - <?php echo $estadomotivo;?></font></TD><TD width="15%" ><font size="-1"></font> </TD><TD width="15%" ><font size="-1"></font> </TD></TR>
</TABLE>
<form method="post" action="<?= base_url() ?>cadastros/pacientes/samecomparecimentoimpressao/<?= $paciente["prontuario"]?>/<?= $paciente["data_internacao"]?>">
    <label>Motivo:</label><br />
    <textarea cols="65" rows="30" name="txtDescricao" id="txtDescricao" ><?php echo $paciente["descricao"];?></textarea><br/>
    
                <button type="submit" >Enviar</button>
</form>

</div>