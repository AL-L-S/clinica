    <?
$dataatualizacao = $exame[0]->data_autorizacao;
$valor_medico = $exame[0]->valor_total * ($exame[0]->perc_medico /100);
$valor_clinca = $exame[0]->valor_total - $valor_medico;
    ?>

<table>
    <tbody>
        <tr>
            <td ><font size = -1><u>MEDICO:<?= substr($exame[0]->medico, 0, 20); ?></u></font></td>
</tr>

<tr>
    <td ><font size = -1>&nbsp; </font></td>
</tr>
<tr>
    <td ><font size = -1>Ficha:<?= $exame[0]->agenda_exames_id; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>DATA: <?= substr($exame[0]->data, 8, 2) . "/" . substr($exame[0]->data, 5, 2) . "/" . substr($exame[0]->data, 0, 4); ?> HORA: <?= substr($dataatualizacao, 10, 6); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>PACIENTE:<?= utf8_decode($paciente['0']->nome); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>CONVENIO: <?= utf8_decode($exame[0]->convenio); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>-------------------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -1><?= utf8_decode($exame[0]->procedimento); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>VALOR R$ <?= number_format($valor_medico, 2, ',', '.')?></font></td>
</tr>
<tr>
    <td ><font size = -1>-------------------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -2>SERVI&Ccedil;O DE LOCA&Ccedil;&Atilde;O DE CONSULTORIO M&Eacute;DICO</font></td>
</tr>
<tr>
    <td ><font size = -1>VALOR R$ <?= number_format($valor_clinca, 2, ',', '.')?></font></td>
</tr>
<tr>
    <td ><font size = -1>-------------------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -1><b>TOTAL PAGO R$ <?= number_format($exame[0]->valor_total, 2, ',', '.')?></b></font></td>
</tr>


</table>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    window.print()


</script>