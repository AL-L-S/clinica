<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<style>
    .negrito{
        font-weight: bold;
    }
</style>
<?
if($credito['0']->procedimento != ''){
  $procedimentos = $credito['0']->procedimento;  
}else{
   $procedimentos = 'Entrada de crédito'; 
}

//$linha_procedimento = @$impressaorecibo[0]->linha_procedimento;
$total = 0;
$totalCartao = 0;
//foreach ($exames as $item) {
//    $linha_procedimento = @$impressaorecibo[0]->linha_procedimento;
//    $total = $total + $item->valor_total;
//    $nome = $item->procedimento;
//    $valor = $item->valor_total / $item->quantidade;
//    $quantidade = $item->quantidade;
//    $valor_to = $item->valor_total;
////    $procedimentos = '';
//
//    $linha_procedimento = str_replace("_procedimento_", $nome, $linha_procedimento);
//    $linha_procedimento = str_replace("_valor_unit_", number_format($valor, 2, ',', '.'), $linha_procedimento);
//    $linha_procedimento = str_replace("_valor_total_", number_format($valor_to, 2, ',', '.'), $linha_procedimento);
//    $linha_procedimento = str_replace("_quantidade_", $quantidade, $linha_procedimento);
//
//    $procedimentos = $procedimentos . $linha_procedimento;
////    echo $linha_procedimento;
//}

//echo '<pre>';
//var_dump($procedimentos);
//die;

@$corpo = $impressaorecibo[0]->texto;
//echo '<pre>';
//var_dump($paciente); die;
$corpo = str_replace("_paciente_", $paciente['0']->nome, $corpo);
if($paciente['0']->sexo == 'M'){
   $sexo = 'Masculino'; 
}elseif($paciente['0']->sexo == 'F'){
   $sexo = 'Feminino';  
}else{
   $sexo = 'Outro';  
}
//Atenção na hora de alterar o código abaixo porque a ordem dos acontecimentos altera o resultado final
// Se alterar por exemplo "_total_" antes de _recibo_total, ele vai tirar o total e ficará _recibo

$corpo = str_replace("_sexo_", $sexo, $corpo);
$corpo = str_replace("_nascimento_", date("d/m/Y", strtotime($paciente['0']->nascimento)), $corpo);
$corpo = str_replace("_CPF_", $paciente['0']->cpf, $corpo);

$corpo = str_replace("_valor_extenso_", $extenso, $corpo);


$corpo = str_replace("_primeiro_procedimento_", $procedimentos, $corpo);
$corpo = str_replace("_primeiro_valor_total_", number_format($credito['0']->valor, 2, ',', '.'), $corpo);
$corpo = str_replace("_primeiro_valor_", '', $corpo);
$corpo = str_replace("_primeira_quantidade_", '', $corpo);


$corpo = str_replace("_recibo_total_", number_format($credito['0']->valor, 2, ',', '.'), $corpo);
$corpo = str_replace("_procedimentos_", $procedimentos, $corpo);
$corpo = str_replace("_data_", substr($paciente['0']->data_cadastro, 8, 2) . '/' . substr($paciente['0']->data_cadastro, 5, 2) . '/' . substr($paciente['0']->data_cadastro, 0, 4), $corpo);




if (@$impressaorecibo[0]->cabecalho == 't') {
    echo @$cabecalho;
}
echo $corpo . "<br>";

if (@$impressaorecibo[0]->rodape == 't') {
    echo @$rodape;
}
?>