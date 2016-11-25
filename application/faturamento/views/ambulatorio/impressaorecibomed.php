<?
$dataatualizacao = $exame[0]->data_autorizacao;
$totalpagar =0;
$formapagamento ='';
     $teste= "";
     $teste2= "";
     $teste3= "";
     $teste4= "";
     
     
         $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $idade = $diff->format('%Y');
?>

<table>
    <tbody>
        <tr>
            <td ><font size = -1><u>RECIBO</u></font></td>
</tr>
<tr>
    <td ><font size = -1>N&SmallCircle;: <?= $exame[0]->agenda_exames_id; ?></font></td>
</tr>

<tr>
    <td ><font size = -1>DATA: <?= substr($exame[0]->data, 8, 2) . "/" . substr($exame[0]->data, 5, 2) . "/" . substr($exame[0]->data, 0, 4); ?> HORA: <?= substr($dataatualizacao, 10, 6); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>Paciente: <?= utf8_decode($paciente['0']->nome); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>Idade: <?= $idade; ?></font></td>
</tr>
<tr>
    <td ><font size = -1>Convenio: <?= utf8_decode($exame[0]->convenio); ?></font></td>
</tr>
<tr>
    <td ><font size = -1>-------------------------------------------------------------</font></td>
</tr>
<td ><font size = -1><?
    foreach ($exames as $item) :
        $totalpagar = $totalpagar + $item->valor_total;
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
        echo utf8_decode($item->procedimento);
        ?><br><? endforeach; ?></font>
</td>
<tr>
    <td ><font size = -1>-------------------------------------------------------------</font></td>
</tr>
<tr>
    <td ><font size = -1><b>TOTAL R$ <?= number_format($totalpagar, 2, ',', '.')?> <?= $formapagamento; ?></b></font></td>
</tr>
<tr>
    <td ><font size = -1>-------------------------------------------------------------</font></td>
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