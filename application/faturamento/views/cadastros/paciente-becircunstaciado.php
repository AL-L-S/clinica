<div class="content">


<form method="post" action="<?= base_url() ?>cadastros/pacientes/relatoriocircunstanciado">
    <input type="hidden" name="txtbe" value="<?= $paciente["be"]?>" class="size1" />
    <input type="hidden" name="txtnome" value="<?= $paciente["nome"]?>" class="size1" />
    <input type="hidden" name="txtnascimento" value="<?= $paciente["data_nascimento"]?>" class="size1"/>
    <input type="hidden" name="txtendereco" value="<?= $paciente["endereco"] . $paciente["bairro"]?>" class="size1"/>
    <input type="hidden" name="txtmae" value="<?= $paciente["nome_mae"]?>" class="size1"/>
    <label>Ao(&Agrave;):</label>
    <select name="txtAO">
        <option>Cirurgia Pedi&aacute;trica</option>
        <option>Traumatologia ortopedica</option>
        <option>Oftalmologia</option>
        <option>Otorrinolaringologista</option>
        <option>Hematologia / Hemoterapia</option>
        <option>Cardiologia</option>
        <option>Bucomaxilofacial</option>
        <option>C&iacute;nica m&eacute;dica</option>
        <option>Vascular / Tor&aacute;xico</option>
        <option>Pl&aacute;tica</option>
        <option>Cirurgia geral</option>
        <option>Anestesiologia</option>
        <option>Servi&ccedil;o social</option>
        <option>Psiquiatria / Psicologia</option>
    </select><BR>
    <label>Caro:</label>
    <input type="text" name="txtCARO" class="size10"  />
<br>
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="70%"><font size="-1">1. Nome: <?php echo $paciente["nome"];?></font></TD></TR>
    <TR><TD width="70%"><font size="-1">2. Data Nascimento <?php echo substr($paciente["data_nascimento"],7,3) . "/" . substr($paciente["data_nascimento"],5,2) . "/" . substr($paciente["data_nascimento"],0,5);?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">3. Endereço: <?php echo $paciente["endereco"]?>, <?php echo $paciente["bairro"]?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">4. Filia&ccedil;&atilde;o: <?php echo $paciente["nome_mae"];?></font></TD></TR>
</TABLE>

    <label>5. Diagn&oacute;tico Atual (LEG&Iacute;VEL, ASSINADO E CARIMBADO):</label><br />
    <TABLE BORDER=1 WIDTH="100%">
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>

</TABLE>
    <label>6. Plano Terapêutico Indicado (LEG&Iacute;VEL, ASSINADO E CARIMBADO) ( )EMERG&Ecirc;NCIA/URG&Ecirc;NCIA ou ( ) ELETIVA:</label><br />
    <TABLE BORDER=1 WIDTH="100%">
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>

</TABLE>
    <label>Solicitante</label>
    <input type="text" name="txtsolicitante" class="size10"  /><br>
    <label>CRM ou CPF</label>
    <input type="text" name="txtcpf" class="size2"  /><br>
    <label>Diretoria:</label>
    <select name="txtdiretoria">
        <option>Superintend&ecirc;ncia</option>
        <option>Diretoria M&eacute;dica</option>
        <option>Diretoria T&eacute;cnica</option>
        <option>Diretoria Executiva</option>
        <option>Diretoria de Emerg&ecirc;ncia</option>
        <option>Chefia de equipe</option>
        <option>Central de interna&ccedil;&atilde;o</option>

    </select><BR>
    
                <button type="submit" >Enviar</button>
</form>

</div>