<?


$sexo = $exame[0]->sexo;
if ($sexo == "M") {
    $sexopaciente = "Masculino";
} elseif ($sexo == "F") {
    $sexopaciente = "Feminino";
}
$dataFuturo = date("Y-m-d");
$dataAtual = $paciente['0']->nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
$exame_id = $exame[0]->agenda_exames_id;
$dataatualizacao = $exame[0]->data_autorizacao;
$inicio = $exame[0]->inicio;
$agenda = $exame[0]->agenda;
?>

<table>
    <tbody>
        <tr>
            <td colspan="2"  ><font size = -1><?= utf8_decode($paciente['0']->nome); ?> - <?= $paciente['0']->paciente_id; ?></font></td>
            <td ><font size = -1>Idade: <?= $teste; ?>&nbsp; </font></td>
            <td width="280px"><font size = -1><center></center></font></td>
<td width="30px">&nbsp;</td>
<td ><font size = -1><u>CLINICA RADIOLOGICA</u></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1><?= utf8_decode($exame[0]->convenio); ?>&nbsp;&nbsp; - &nbsp;&nbsp;<?= $exame[0]->guia_id ?></font></td>
    <td ><font size = -1>SEXO: <?= $sexopaciente ?></font></td>
    <td><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1><u>DR RONALDO BARREIRA</u></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1>DATA: <?= substr($exame[0]->data, 8, 2) . "/" . substr($exame[0]->data, 5, 2) . "/" . substr($exame[0]->data, 0, 4); ?> HORA: <?= substr($dataatualizacao, 10, 6); ?></font></td>
    <td ><font size = -1>FONE:<?= $paciente['0']->telefone; ?> </font></td>
    <td><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1>
        <?
        foreach ($exames as $item) :
            echo utf8_decode($item->procedimento);
            ?><br><? endforeach; ?>
        </font></td>
    <td ><font size = -1>MEDICO:<?= substr($exame[0]->medicosolicitante, 0, 8); ?></font></td>
    <td><font size = -2></font></td>
    <td >&nbsp;</td> 
    <td ><font size = -1><?
        foreach ($exames as $item) :
            echo utf8_decode($item->procedimento);
            ?><br><? endforeach; ?></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1>Atendente: <?= substr($exame[0]->atendente, 0, 13); ?></font></td>
    <td ><font size = -1> &nbsp;<?= $exame[0]->agenda_exames_id; ?></font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2><center>LAUDO:</center></font></td>
<td >&nbsp;</td>            
<td ><font size = -1></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1></font></td>
    <td ><font size = -1></font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2>&nbsp;</font></td>
    <td >&nbsp;</td>
    <td ><font size = -1></font></td>
</tr>
<tr>
    <td ><font size = -2>( )FEBRE</font></td>
    <td ><font size = -2>( )DIARREIA</font></td>
    <td ><font size = -2>( )FRATURA</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>PAC: <?= substr($paciente['0']->nome, 0, 18); ?></font></td>
</tr>
<tr>
    <td ><font size = -2>( )TOSSE</font></td>
    <td ><font size = -2>( )VOMITOS</font></td>
    <td ><font size = -2>( )CORPO ESTRANHO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1></font></td>
</tr>
<tr>
    <td ><font size = -2>( )EXPECTORA&Ccedil;&Atilde;O</font></td>
    <td ><font size = -2>( )SANGUE NA URINA</font></td>
    <td ><font size = -2>( )PERDA DE PESO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>CONV: <?= substr($exame[0]->convenio, 0, 10); ?></font></td>
</tr>
<tr>
    <td ><font size = -2>( )HEMOPTISE</font></td>
    <td ><font size = -2>( )CALCULO</font></td>
    <td ><font size = -2>( )MH</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>N.PEDIDO: <u><?= $exame[0]->guia_id ?></font></td>
    </tr>
    <tr>
        <td ><font size = -2>( )DISPNEIA</font></td>
        <td ><font size = -2>( )CEFALEIA</font></td>
        <td ><font size = -2>( )DIABETE</font></td>
        <td style='width:58pt;border:solid windowtext 1.0pt;
            border-bottom:none;border-top:none;mso-border-left-alt:
            solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
        <td >&nbsp;</td>
        <td ><font size = -1>REALIZADO: <?= substr($exame[0]->data_autorizacao, 8, 2) . "/" . substr($exame[0]->data_autorizacao, 5, 2) . "/" . substr($exame[0]->data_autorizacao, 0, 4); ?>&agrave;s <?= substr($dataatualizacao, 10, 9); ?></u></font></td>
</tr>
<tr>
    <td ><font size = -2>( )TB RESIDUAL</font></td>
    <td ><font size = -2>( )CORIZA</font></td>
    <td ><font size = -2>( )TONTURA</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>PREVISAO ENTREGA:</font></td>
</tr>
<tr>
    <td ><font size = -2>( )CONT. DE TRAT.</font></td>
    <td ><font size = -2>( )OBSTRU&Ccedil;&Atilde;O</font></td>
    <td ><font size = -2>( )ADMISSIONAL</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1><?= substr($exame[0]->data_entrega, 8, 2) . "/" . substr($exame[0]->data_entrega, 5, 2) . "/" . substr($exame[0]->data_entrega, 0, 4); ?></font></td>
</tr>
<tr>
    <td ><font size = -2>( )COMUNICANTE</font></td>
    <td ><font size = -2>( )SINUSITE</font></td>
    <td ><font size = -2>( )DEMISSIONAL</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>DE 16:00 AS 17:00 HS</font></td>
</tr>
<tr>
    <td ><font size = -2>( )PNEUMONIA</font></td>
    <td ><font size = -2>( )DOR</font></td>
    <td ><font size = -2>( )PERIODICO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>ASS:</font></td>
</tr>
<tr>
    <td ><font size = -2>( )COLICA</font></td>
    <td ><font size = -2>( )EDEMA</font></td>
    <td ><font size = -2>( )PRE-OPERATORIO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>Atendimento:</font></td>
</tr>
<tr>
    <td ><font size = -2>( )FUMANTE</font></td>
    <td ><font size = -2>( )TRAUMATISMO</font></td>
    <td ><font size = -2>( )POS-OPERATORIO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>Seg a Sex de 07:30 as 17:00 hs</font></td>
</tr>
<tr>
    <td ><font size = -2>( )HIPERTENS&Atilde;O</font></td>
    <td ><font size = -2>( )ESCOLIOSE</font></td>
    <td ><font size = -2>( )CHECK-UP</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>Sab de 07:30 as 11:30 hs</font></td>
</tr>
<tr>
    <td ><font size = -1>INDICA&Ccedil;&Atilde;O: <?= $exame[0]->indicacao; ?></font></td>
    <td ><font size = -1></font></td>
    <td ><font size = -1>D.N.: <?= substr($paciente['0']->nascimento, 8, 2) . "/" . substr($paciente['0']->nascimento, 5, 2) . "/" . substr($paciente['0']->nascimento, 0, 4); ?></font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1><?= $exame[0]->logradouro; ?><?= $exame[0]->numero; ?> - <?= $exame[0]->bairro; ?></font></td>
</tr>
<tr>
    <td ><font size = -2>TEC:________________ANA:____________ SALA:____</font></td>
    <td><font size = -2></font></td>
    <td ><font size = -1><center></center></font></td>
<td style='width:58pt;border:solid windowtext 1.0pt;
    mso-border-bottom-alt:solid windowtext .5pt;border-top:none;mso-border-left-alt:
    solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -1><center></center></font></td>

<td >&nbsp;</td>
<td ><font size = -1>Fone: (85) - <?= $empresa[0]->telefone; ?></font></td>
</tr>
</table>
<div style="float:left;">
    <table border="1" style="border-collapse: collapse" >
        <tr >
            <td width="60px;"><font size = -2>E-</font></td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td>
        </tr>
        <tr>
            <td><font size = -2>MA-</font></td><td width="60px;">&nbsp;</td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td>
        </tr>
        <tr>
            <td><font size = -2>S-</font></td><td width="60px;">&nbsp;</td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td>
        </tr>
        <tr>
            <td><font size = -2>KV-</font></td><td width="60px;">&nbsp;</td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td>
        </tr>
    </table>
</div>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    window.print()


</script>
