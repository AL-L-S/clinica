<?
$dataatualizacao = $exame[0]->data_autorizacao;
$totalpagar =0;
?>

<table>
    <tbody>
        <tr>
            <td ><font size = -1><u>CLINICA DEZ</u></font></td>
</tr>

<tr>
    <td ><font size = -1>&nbsp; </font></td>
</tr>
<tr>
    <td ><font size = -1>N&SmallCircle;: <?= $exame[0]->agenda_exames_id; ?></font></td>
</tr>

<tr>
    <td ><font size = -1>DATA: <?= substr($exame[0]->data, 8, 2) . "/" . substr($exame[0]->data, 5, 2) . "/" . substr($exame[0]->data, 0, 4); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>HORA: <?= substr($dataatualizacao, 10, 6); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>&nbsp;</font></td>
</tr>
<tr>
    <td ><font size = -1><?= utf8_decode($paciente['0']->nome); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>-------------------------------------------------------------</font></td>
</tr>
<td ><font size = -1><?
    foreach ($exames as $item) :
        $totalpagar = $totalpagar + $item->valor_total;
        echo utf8_decode($item->procedimento);
        ?><br><? endforeach; ?></font>
</td>
<tr>
    <td ><font size = -1>-------------------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -1><b>TOTAL R$ <?= number_format($totalpagar, 2, ',', '.')?></b></font></td>
</tr>
<tr>
    <td ><font size = -1>&nbsp; </font></td>
</tr>
<tr>
    <td ><font size = -1>Entrega Data</font></td>
</tr>
<tr>
    <td ><font size = -1><?= substr($exame[0]->data_entrega, 8,2) . "/" . substr($exame[0]->data_entrega, 5,2) .  "/" . substr($exame[0]->data_entrega, 0,4)?></font></td>
</tr>
</table>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    window.print()


</script>