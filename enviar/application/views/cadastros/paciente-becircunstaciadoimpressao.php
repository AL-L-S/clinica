<div class="content">

<a><img src="<?= base_url() ?>img/logopreto.png" width="200" height="35" alt="teste"></a>
<a><img align="right" src="<?= base_url() ?>img/fortalezabela.png" width="50" height="50" alt="teste"></a>
<TABLE BORDER=0 WIDTH="100%">
    <TR><td width="55%">&ensp;</td><TD ><font size="-1">Fortaleza <?php echo substr($paciente['0']->data,7,3) . "/" . substr($paciente['0']->data,5,2) . "/" . substr($paciente['0']->data,0,5);?></font></TD></TR>
    <TR><TD width="55%"><font size="-1">CI: <?php echo $paciente['0']->relatoriocircuntanciado_id . "/" . substr($paciente['0']->data,0,4);?> </font></TD><td></td></TR>
    <TR><TD width="55%" ><font size="-1"></font></TD><td><font size="-1">Do: Dire&ccedil;&atilde;o M&eacute;dica / Emerg&ecirc;ncia</font></td></TR>
    <TR><TD width="55%" ><font size="-1"></font></TD><td><font size="-1">Ao(&Agrave;) <?php echo $paciente['0']->ao;?></font></td></TR>
    <TR><TD width="55%" ><font size="-1">Caro(a) Dr(a)<?php echo $paciente['0']->caro;?>,</font></TD><td></td></TR>
</TABLE>
    <h5>Solicito a V.Sa. que seja enviado a esta Diretoria um relat&oacute;rio circunstanciado do paciente abaixo qualificado, contendo as seguintes informa&ccedil;&otilde;es:</h5>
<TABLE BORDER=0 WIDTH="100%">
    <TR><TD width="70%"><font size="-1">1. Nome: <?php echo $paciente['0']->nome;?></font></TD></TR>
    <TR><TD width="70%"><font size="-1">2. Data Nascimento <?php echo substr($paciente['0']->data_nascimento,7,3) . "/" . substr($paciente['0']->data_nascimento,5,2) . "/" . substr($paciente['0']->data_nascimento,0,5);?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">3. Endereço: <?php echo $paciente['0']->endereco?></font></TD></TR>
    <TR><TD width="70%" colspan="2"><font size="-1">4. Filia&ccedil;&atilde;o: <?php echo $paciente['0']->nome_mae;?></font></TD></TR>
</TABLE>
    

<h5>5. Diagn&oacute;tico Atual (LEG&Iacute;VEL, ASSINADO E CARIMBADO):</h5>

    <TABLE BORDER=1 WIDTH="100%">
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>

</TABLE>
    <br>
    <h5>6. Plano Terapêutico Indicado (LEG&Iacute;VEL, ASSINADO E CARIMBADO) &ensp;( &ensp;)EMERG&Ecirc;NCIA/URG&Ecirc;NCIA ou (&ensp; ) ELETIVA:</h5>
  
    <TABLE BORDER=1 WIDTH="100%">
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>
    <TR><TD>&ensp;</TD></TR>

</TABLE>


<h5>Atenciosamente,</h5>
<br>


<label><?=  $paciente['0']->solicitante;?></label><br>
<label>&ensp;&ensp;&ensp;&ensp;&ensp;CRM / CPF <?= $paciente['0']->numero;?></label><br>
<label>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<?=  $paciente['0']->diretoria;?></label><br>
                &ensp;
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>&ensp;
                &ensp;
                <br>
<label><font size="-2"><center>INSTITUTO Dr. JOSÉ FROTA</center></font></label>
<label><font size="-2"><center> Rua: Barão do Rio Branco, 1816 – Centro</center></font></label>
<label><font size="-2"><center>Fortaleza-Ceará</center></font></label>
<label><font size="-2"><center>Telefone: (85) 3255 5000</center></font></label>

</div>