<meta charset="utf8">
<style>
    .negrito{
        font-weight: bold;
    }
</style>
<?

$procedimentos = "<table cellpadding='5'>
        <tr>
            <td class='negrito'>Procedimento</td>
            <td class='negrito'>Descrição</td>
            <td class='negrito'>Qtde</td>
            <td class='negrito'>V. Unit</td>
            <td class='negrito'>Grupo</td>
            <td class='negrito'>Convenio</td>
            <td class='negrito'>Forma de Pagamento</td>
            <td class='negrito'>Valor</td>
            <td class='negrito'>Valor Cartão</td>
        </tr> ";

$total = 0;
$totalCartao = 0;
foreach ($exames as $item) {
    $total = $total + $item->valor_total;
    $totalCartao = $totalCartao + $item->valor_total_ajustado;
    
    $procedimentos = $procedimentos . "<tr><td width='25%;'>" . utf8_decode($item->procedimento) . "</td>
                <td width='10%;'>" . utf8_decode($item->descricao_procedimento) . "</td>
                <td width='10%;'>" . utf8_decode($item->quantidade) . "</td>
                <td width='10%;'>" . number_format($item->valor, 2, ',', '.') . "</td>
                <td width='10%;'>" . $item->grupo . "</td>
                <td width='10%;'>" . $item->convenio . "</td>
                <td width='10%;'>" . $item->forma_pagamento . "</td>
                <td width='15%;'>" . number_format($item->valor_total, 2, ',', '.') . "</td>
                <td width='20%;'>" . number_format($item->valor_total_ajustado, 2, ',', '.') . "</td></tr>";
}
$procedimentos = $procedimentos 
        . ' <tr>
                <td colspan="7"></td>
                <td colspan="">
                    <span class="negrito">Total:</span> ' . number_format($total, 2, ',', '.') . ' 
                </td>
                <td colspan="">
                    <span class="negrito">Total Cartão:</span>' . number_format($totalCartao, 2, ',', '.') . '
                </td>
            </tr>'
        . "</table>";
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




if (@$impressaoorcamento[0]->cabecalho == 't') {
    echo @$cabecalho;
}
echo $corpo . "<br>";

if (@$impressaoorcamento[0]->rodape == 't') {
    echo @$rodape;
}
?>