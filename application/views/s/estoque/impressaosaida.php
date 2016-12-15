<table>
    <tbody>
        <tr>
            <td colspan="2"  ><font size = -1>SETOR</font></td>
            <td ><font size = -1>Idade: <?= $teste; ?>&nbsp; </font></td>
            <td width="280px"><font size = -1><center></center></font></td>
<td width="30px">&nbsp;</td>
<td ><font size = -1><u><?= $empresa[0]->razao_social; ?></u></font></td>
</tr>
        <tr>
            <td colspan="2"  ><font size = -1><?= utf8_decode($nome); ?></font></td>
            <td ><font size = -1>Idade: <?= $teste; ?>&nbsp; </font></td>
            <td width="280px"><font size = -1><center></center></font></td>
<td width="30px">&nbsp;</td>
<td ><font size = -1><u><?= $empresa[0]->razao_social; ?></u></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1><?= utf8_decode($exame[0]->convenio); ?>&nbsp;&nbsp; - &nbsp;&nbsp;<?= $exame[0]->guia_id ?></font></td>
    <td ><font size = -1>SEXO: <?= $sexopaciente ?></font></td>
    <td ><font size = -1>D.N.: <?= substr($paciente['0']->nascimento, 8, 2) . "/" . substr($paciente['0']->nascimento, 5, 2) . "/" . substr($paciente['0']->nascimento, 0, 4); ?></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1><u></u></font></td>
</tr>
</table>

