<?
$dataatualizacao = $exame[0]->data_autorizacao;
$dataFuturo = date("Y-m-d");
$dataAtual = $paciente['0']->nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
$telefone = "";
if ($exame[0]->celular == ""){
    $telefone = $exame[0]->telefone;
}else{
    $telefone = $exame[0]->celular;
}

?>

<table>
    <tbody>
        <tr>
            <td ><font size = -1><u><?= $exame[0]->razao_social; ?></u></font></td>
</tr>

<tr>
    <td ><font size = -1>&nbsp; </font></td>
</tr>
<tr>
    <td ><font size = -1>N&SmallCircle;:<?= $exame[0]->agenda_exames_id; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>MEDICO:<?= substr($exame[0]->medico, 0, 20); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>DATA: <?= substr($exame[0]->data, 8, 2) . "/" . substr($exame[0]->data, 5, 2) . "/" . substr($exame[0]->data, 0, 4); ?> HORA: <?= substr($dataatualizacao, 10, 6); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>PACIENTE:<?= utf8_decode($paciente['0']->nome); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>NASCIMENTO: <?= substr($paciente['0']->nascimento, 8, 2) . "/" . substr($paciente['0']->nascimento, 5, 2) . "/" . substr($paciente['0']->nascimento, 0, 4); ?> - IDADE: <?= $teste; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>END: <?= utf8_decode($exame[0]->logradouro_paciente) . " " . $exame[0]->numero_paciente . " " .  $exame[0]->bairro_paciente; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>TEL: <?= $telefone; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>CONVENIO: <?= utf8_decode($exame[0]->convenio); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>-----------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -1><?= utf8_decode($exame[0]->procedimento); ?></font></td>
</tr>


</table>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    window.print()


</script>