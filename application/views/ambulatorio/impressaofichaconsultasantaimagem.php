<meta charset="utf-8">
<div class="content ficha_ceatox">

    <?
                            $dataFuturo = date("Y-m-d");
                            $dataAtual = $paciente['0']->nascimento;
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%Ya %mm %dd');
    ?>
    
    
    <p><img align = 'center'  width='100%' height='100px' src="<?= base_url() . "img/cabecalho.jpg" ?>"></p>
    <table>
        <tbody>
            <tr>
                <td width="70%;" ><font size = -1><?= $exame[0]->razao_social; ?></td>
                <!--<td ><font size = -1>Emissao:<?= str_replace("-", "/", $emissao); ?></td>-->
            </tr>
            <tr>
                <td ><font size = -1><?= $exame[0]->logradouro; ?><?= $exame[0]->numero; ?> - <?= $exame[0]->bairro; ?></td>
                <td ></td>
            </tr>
            <tr>
                <td ><font size = -1>Fone: <?= $exame[0]->telefone; ?></td>
                <td ></td>
            </tr>
<!--            <tr>
                <td ><font size = -1>&nbsp;</td>
                <td ></td>
            </tr>-->
  

            <?
            foreach ($exames as $item) :
                if ($item->grupo == $exame[0]->grupo) {
                $exame_id = $item->agenda_exames_id;
                $dataatualizacao = $item->data_autorizacao;
                $inicio = $item->inicio;
                $agenda = $item->agenda;
                $operador_autorizacao = $item->operador;
                ?>

            <? 
                }
            endforeach; ?>
        </tbody>
    </table>

    <table>
        <tbody>
<!--            <tr>
                <td ><font size = -1>Data:<?= str_replace("-", "/", $emissao); ?></font></td>
            </tr>-->
            <tr>
                
                <td ><font size = -1>Nr.Ficha: <?= $paciente['0']->paciente_id; ?></font></td>
                <td ><font size = -1>Aut.:<?= substr($operador_autorizacao, 0, 15); ?></font></td>
                
            </tr>
            <tr>
                <td width="50%;" ><font size = -1>Paciente:<b> <?= $paciente['0']->nome; ?></b></font></td>
                <td width="30%;"><font size = -1>Nascimento:<?= substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4);?></font></td>
                <td ><font size = -1>Idade: <?= $teste; ?></font></td>    
            </tr>
            <tr>
                <!--<td ><font size = -1>Nr. Pedido: <?= $exame[0]->agenda_exames_id; ?></font></td>-->
                <td ><font size = -1>Telefone:<?= $paciente['0']->telefone; ?>/<?= $paciente['0']->celular; ?></font></td>
                <!--<td ><font size = -1>Chegada: <?= substr($dataatualizacao, 10, 9); ?></font></td>-->
                <td ><font size = -1>Sexo: <?= $exame[0]->sexo; ?></font></td>
            </tr>
            <tr>
                <td ><font size = -1>Sala: <?= $agenda;?></font></td>
                <td ><font size = -1>Emissao: <?= str_replace("-", "/", $emissao); ?></font></td>
                <!--<td ><font size = -1>Ordem: <?= $inicio; ?></font></td>,-->
                <td ><font size = -1>Chegada: <?= substr($dataatualizacao, 10, 9); ?></font></td>
                <td ></td>
            </tr>
            

    </table>
    <br>
    <table>
        <tr>
            <td colspan="2">PROCEDIMENTO</td>
            <td >CONVENIO</td>
            <!--<td >AUTORIZACAO</td>-->
            <td >MÉDICO</td>
        </tr>
            <?
            foreach ($exames as $item) :
                if ($item->grupo == $exame[0]->grupo) {
                ?>
            <tr>
                <td ><?= $item->quantidade ?></td>
                <td width="50%;"><?= $item->procedimento  . "-" . $item->sala?></td>
                <td width="30%;"><?= $item->convenio ?></td>
<!--                <td ><?= $item->autorizacao ?></td>-->
                <td ><?= $item->medicoagenda ?></td>
            </tr>
        <? 
                }
        endforeach; ?>
        </tbody>
    </table>
    <!--<hr>-->
    <br>
    <br>
    <table>
            <?
//            foreach ($exames as $item) :
//                if ($item->grupo != $exame[0]->grupo) {
                ?>
<!--            <tr>
                <td width="40%;"><?= $item->procedimento  . "-" . $item->sala  ?></td>
                <td ><?= $item->convenio ?></td>
                <td ><?= $item->autorizacao ?></td>
                <td width="25%;"><?= $item->medicosolicitante ?></td>
            </tr>-->
        <? 
//                }
//        endforeach; ?>
        </tbody>
    </table>

</div>
<hr>

<table border="0" width=620 height=70>
    <tr>
        <td valign="top">QUEIXA:
            
        </td>
    </tr>
</table>
<hr>

<table border="0" width=620 height=70>
    <tr>
        <td valign="top">HPMA:
            
        </td>
    </tr>
</table>
<hr>

<table border="0" width=620 height=200>
    <tr>
        <td valign="top">OBSERVAÇÕES:
            
        </td>
    </tr>
</table>
<!--<hr>-->
