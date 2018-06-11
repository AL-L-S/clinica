<?

$sexo = $exame[0]->sexo;
if ($sexo == "M") {
    $sexopaciente = "Masculino";
} elseif ($sexo == "F") {
    $sexopaciente = "Feminino";
} else {
    $sexopaciente = "Outro";
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

    
    <p><center><u>MEDLAB</u></center></p>
    <p><center>Rua Monsenhor Aloisio, 300 - Fone: (88) 3614-4600 / 99779-9000</center></p>
    <p>
    <p><center>Recibo</center></p>
    <p>
    <p><center>N&SmallCircle; PEDIDO:<?= $exame[0]->agenda_exames_id; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VALOR:# <?= $valor;?> &nbsp;#</center></p>
    <p>
    <p>Recebi de <?= utf8_decode($paciente['0']->nome); ?>, a importancia de <?= $valor;?> (<?= $extenso;?>)  referente
     a   <? 
     $formapagamento= "";
     $teste= "";
     $teste2= "";
     $teste3= "";
     $teste4= "";
     foreach ($exames as $item) :
               
                echo utf8_decode($item->procedimento);
                ?><br><?
                                                        if($item->forma_pagamento != null && $item->formadepagamento != $teste && $item->formadepagamento != $teste2 && $item->formadepagamento != $teste3 && $item->formadepagamento != $teste4){
                                                            $teste= $item->formadepagamento; 
                                                            $formapagamento = $formapagamento . "/" . $item->formadepagamento; }
                                                        if($item->forma_pagamento2 != null && $item->formadepagamento2 != $teste && $item->formadepagamento2 != $teste2 && $item->formadepagamento2 != $teste3 && $item->formadepagamento2 != $teste4){
                                                            $teste2= $item->formadepagamento2; 
                                                            $formapagamento = $formapagamento . "/" . $item->formadepagamento2; }
                                                        if($item->forma_pagamento3 != null && $item->formadepagamento3 != $teste && $item->formadepagamento3 != $teste2 && $item->formadepagamento3 != $teste3 && $item->formadepagamento3 != $teste4){
                                                            $teste3= $item->formadepagamento3; 
                                                            $formapagamento = $formapagamento . "/" . $item->formadepagamento3; }
                                                        if($item->forma_pagamento4 != null && $item->formadepagamento4 != $teste && $item->formadepagamento4 != $teste2 && $item->formadepagamento4 != $teste3 && $item->formadepagamento4 != $teste4){
                                                            $teste4= $item->formadepagamento4;
                                                            $formapagamento = $formapagamento . "/" . $item->formadepagamento4; }
                                endforeach;?></p>
    <p>Recebimento atraves de: <?= $formapagamento;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Categoria: <?= $exame[0]->convenio; ?></p><p align="right">Sobral, <?= substr($exame[0]->data_autorizacao, 8, 2) . "/" . substr($exame[0]->data_autorizacao, 5, 2) . "/" . substr($exame[0]->data_autorizacao, 0, 4) . " ";?><?= substr($exame[0]->data_autorizacao, 11, 5); ?></p>
    <br>
    <h4><center>___________________________________________</center></h4>
    <h4><center>Atendente: <?= substr($exame[0]->atendente, 0, 13); ?></center></h4>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
window.print() 


</script>
