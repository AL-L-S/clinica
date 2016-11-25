    <?
$dataatualizacao = $exame[0]->data_autorizacao;
$dataFuturo = date("Y-m-d");
$dataAtual = $paciente['0']->nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
    ?>

<table>
    <tbody>
        <tr>
            <td ><font size = -1><u>COTCLINICA - CLINICA ORT. E TRAUMAT. CEARA</u></font></td>
</tr>

<tr>
    <td ><font size = -1>&nbsp; </font></td>
</tr>
<tr>
    <td ><font size = -1>FICHA:<?= $exame[0]->agenda_exames_id; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>DATA: <?= substr($exame[0]->data_guia, 8, 2) . "/" . substr($exame[0]->data_guia, 5, 2) . "/" . substr($exame[0]->data_guia, 0, 4); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>NOME:<?= utf8_decode($paciente['0']->nome); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>IDADE: <?= $teste; ?> - CONVENIO: <?= utf8_decode($exame[0]->convenio); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>MEDICO:<?= substr($exame[0]->medico, 0, 20); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>PROFISSAO:<?= utf8_decode($exame[0]->profissaos); ?> </font></td>
</tr>

<tr>
    <td ><font size = -1>-----------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -1>DATA: <?= substr($exame[0]->data_autorizacao, 8, 2) . "/" . substr($exame[0]->data_autorizacao, 5, 2) . "/" . substr($exame[0]->data_autorizacao, 0, 4); ?> HORA: <?= substr($dataatualizacao, 10, 6); ?></font></td>
</tr>
<tr>
    <td ><font size = -1><?= utf8_decode($exame[0]->texto); ?></font></td>
</tr>

<tr>
    <td ><font size = -1>-----------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -1>Secoes Realizadas: <?= $exame[0]->numero_sessao; ?> / <?= $exame[0]->qtde_sessao; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>Hipertensao: <?= $exame[0]->hipertensao; ?> Diabetes: <?= $exame[0]->diabetes; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>-----------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -1>&nbsp; </font></td>
</tr>
<tr>
    <td ><font size = -1>&nbsp; </font></td>
</tr>

</table>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    window.print()


</script>