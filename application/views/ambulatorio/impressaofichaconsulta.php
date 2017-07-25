
<div class="content ficha_ceatox">

    <?
                            $dataFuturo = date("Y-m-d");
                            $dataAtual = $paciente['0']->nascimento;
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%Ya %mm %dd');
    ?>
    
    
    
    <table>
        <tbody>
            <tr>
                <td width="70%;" ><font size = -1><?= $exame[0]->razao_social; ?></td>
                <td ><font size = -1>Emissao:<?= str_replace("-", "/", $emissao); ?></td>
            </tr>
            <tr>
                <td ><font size = -1><?= $exame[0]->logradouro; ?><?= $exame[0]->numero; ?> - <?= $exame[0]->bairro; ?></td>
                <td ></td>
            </tr>
            <tr>
                <td ><font size = -1>Fone: (85) <?= $exame[0]->telefone; ?></td>
                <td ></td>
            </tr>
            <tr>
                <td ><font size = -1>&nbsp;</td>
                <td ></td>
            </tr>
  

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
    <hr>

    <table>
        <tbody>
            <tr>
                <td ><font size = -1>FICHA DE CONSULTA - Nr.Ficha:<?= $paciente['0']->paciente_id; ?></font></td>
                <td ><font size = -1>Aut.:<?= substr($operador_autorizacao, 0, 15); ?></font></td>
                <td ><font size = -1>Sexo: <?= $exame[0]->sexo; ?></font></td>
            </tr>
            <tr>
                <td ><font size = -1>Nr. Pedido: <?= $exame[0]->agenda_exames_id; ?></font></td>
                <td ><font size = -1>TELEFONE:<?= $paciente['0']->telefone; ?>/<?= $paciente['0']->celular; ?></font></td>
                <td ><font size = -1>Chegada: <?= substr($dataatualizacao, 10, 9); ?></font></td>
            </tr>
            <tr>
                <td ><font size = -1>Agenda:<?= $agenda;?></font></td>
                <td ><font size = -1>Emissao:<?= str_replace("-", "/", $emissao); ?></font></td>
                <td ><font size = -1>Ordem:<?= $inicio; ?></font></td>
                <td ></td>
            </tr>
            <tr>
                <td width="50%;" ><font size = -1>Paciente:<b> <?= $paciente['0']->nome; ?></b></font></td>
                <td width="30%;"><font size = -1>Nascimento:<?= substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4);?></font></td>
                <td ><font size = -1>Idade: <?= $teste; ?></font></td>    
            </tr>

    </table>
    <table>
        <tr>
            <td colspan="2">EXAME</td>
            <td >CONVENIO</td>
            <td >AUTORIZACAO</td>
        </tr>
            <?
            foreach ($exames as $item) :
                if ($item->grupo == $exame[0]->grupo) {
                ?>
            <tr>
                <td ><?= utf8_decode($item->quantidade) ?></td>
                <td width="40%;"><?= utf8_decode($item->procedimento)  . "-" . utf8_decode($item->sala) ?></td>
                <td ><?= $item->convenio ?></td>
                <td ><?= $item->autorizacao ?></td>
            </tr>
        <? 
                }
        endforeach; ?>
        </tbody>
    </table>
    <hr>
    <table>
            <?
            foreach ($exames as $item) :
                if ($item->grupo != $exame[0]->grupo) {
                ?>
            <tr>
                <td width="40%;"><?= utf8_decode($item->procedimento)  . "-" . utf8_decode($item->sala)  ?></td>
                <td ><?= $item->convenio ?></td>
                <td ><?= $item->autorizacao ?></td>
                <td width="25%;"><?= utf8_decode($item->medicosolicitante) ?></td>
            </tr>
        <? 
                }
        endforeach; ?>
        </tbody>
    </table>

</div>
<table border="1" width=620 height=450>
    <tr>
        <td valign="top">ANAMNESE:
            
        </td>
    </tr>
</table>
