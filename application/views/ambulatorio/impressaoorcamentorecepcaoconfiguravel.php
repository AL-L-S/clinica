<?

$procedimentos = "<table cellpadding='5'>
        <tr>
            <td >Procedimento</td>
            <td >Qtde</td>
            <td >V. Unit</td>
            <td >Grupo</td>
            <td >Convenio</td>
            <td >Forma de Pagamento</td>
            <td >V. Total</td>
        </tr> ";

$total = 0;
foreach ($exames as $item) {
    $total = $total + $item->valor_total;
    $procedimentos = $procedimentos . "<tr><td width='25%;'>" . utf8_decode($item->procedimento) . "</td>
                <td width='10%;'>" . utf8_decode($item->quantidade) . "</td>
                <td width='10%;'>" . number_format($item->valor, 2, ',', '.') . "</td>
                <td width='15%;'>" . $item->grupo . "</td>
                <td width='25%;'>" . $item->convenio . "</td>
                <td width='25%;'>" . $item->forma_pagamento . "</td>
                <td width='25%;'>" . number_format($item->valor_total, 2, ',', '.') . "</td></tr>";
}
$procedimentos = $procedimentos. "</table>";
//        echo $procedimentos;










@$corpo = $impressaoorcamento[0]->texto;
//var_dump($exames[0]->paciente); die;
$corpo = str_replace("_paciente_", $exames['0']->paciente, $corpo);
$corpo = str_replace("_sexo_", $exames['0']->sexo, $corpo);
$corpo = str_replace("_nascimento_", date("d/m/Y", strtotime($exames['0']->nascimento)), $corpo);
$corpo = str_replace("_CPF_", $exames['0']->cpf, $corpo);
$corpo = str_replace("_total_", number_format($total, 2, ',', '.'), $corpo);
$corpo = str_replace("_procedimento_", $procedimentos, $corpo);
$corpo = str_replace("_data_", substr($exames['0']->data_cadastro, 8, 2) . '/' . substr($exames['0']->data_cadastro, 5, 2) . '/' . substr($exames['0']->data_cadastro, 0, 4), $corpo);




if ($impressaoorcamento[0]->cabecalho == 't') {
    echo @$cabecalho;
}
echo $corpo . "<br>";

if ($impressaoorcamento[0]->rodape == 't') {
    echo @$rodape;
}
?>