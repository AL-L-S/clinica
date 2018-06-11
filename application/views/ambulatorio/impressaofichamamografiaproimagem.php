<meta charset="utf8">
<div class="content ficha_ceatox">
    <?
    $exame_id = $exame[0]->agenda_exames_id;
    $dataatualizacao = $exame[0]->data_autorizacao;
    $inicio = $exame[0]->inicio;
    $operador_autorizacao = $exame[0]->atendente;
    ?>

    <?
    ?>
    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>
    <table>
        <tbody>
        <td rowspan="3" width="70%;"><img align = 'left'  width='330px' height='100px' src=<?= base_url() . "img/logoclinicadez.png" ?>></td>
        <tr>
        <td>( &nbsp; ) RAIOS X 
            <br>( &nbsp; ) DENS. 
            <br>( &nbsp; ) MMG
            <br>( &nbsp; ) RNM
            <br>( &nbsp; ) USG SALA
            <br>( &nbsp; ) TOMOGRAFIA
        
        </td>
        <!--<td>( &nbsp; ) DENS.</td>-->
        </tr>
        <tr>
        <!--<td>( &nbsp; ) RAIOS X</td>-->
        <!--<td>( &nbsp; ) DENS.</td>-->
        </tr>
        <tr>
            <!--<td>( &nbsp; ) MMG</td>-->
            <!--<td>( &nbsp; ) RNM</td>-->
        </tr>
        <tr>
            <!--<td>( &nbsp; ) USG</td>-->
            <!--<td>( &nbsp; ) TOMOGRAFIA</td>-->
        </tr>
        <tr>
            <td ><font size = -1><?= substr($exame[0]->sala, 0, 10); ?></td>
            <td><font size = -1>Ficha de Entrega</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <table>
        <tbody>
            <tr>
                <td width="60%;" colspan="2"><font size = -1>Entrada: <?= substr($exame[0]->data, 8, 2) . '/' . substr($exame[0]->data, 5, 2) . '/' . substr($exame[0]->data, 0, 4); ?></td>
                <td><font size = -1>Agendado:<?= $inicio ?> </td>

            </tr>
            <tr>
                <td colspan="2"><font size = -1>Conv&ecirc;nio:<?= utf8_decode($exame[0]->convenio) ?></td>
                <td><font size = -1>Chegou:<?= substr($dataatualizacao, 10, 9); ?></td>
            </tr>
            <tr>
                <td colspan="2"><font size = -1>C&oacute;d. Paciente: <?= $paciente['0']->paciente_id; ?></td>
                <td><font size = -1>D.U.M:</td>
            </tr>
            <tr>
                <td colspan="2"><font size = -1>Paciente:<b><?= utf8_decode($paciente['0']->nome); ?></b></td>
                <td><font size = -1>Sexo: <?= $exame[0]->sexo; ?></td>
            </tr>
            <tr>
                <td colspan="2"><font size = -1>Nascimento:<?= substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?></td>
                <td><font size = -1>Idade: <?= $teste; ?></td>
            </tr>
            <tr>
                <td><font size = -1>Endere&ccedil;o: <?= utf8_decode($paciente['0']->logradouro) ?></td>
                <td><font size = -1>Num: <?= $paciente['0']->numero ?></td>
                <td><font size = -1>Bairro:<?= utf8_decode($paciente['0']->bairro) ?></td>
            </tr>
            <tr>
                <td colspan="2"><font size = -1>Cidade:<?= $paciente['0']->cidade_desc ?></td>
                <td><font size = -1>Estado: <?= $paciente['0']->estado ?></td>
            </tr>
            <tr>
                <td><font size = -1>Fone: <?= $paciente['0']->telefone; ?>/<?= $paciente['0']->celular; ?></td>
            </tr>
            <tr>
                <td colspan="2"><font size = -1>Data da Entrega:</td>
                <td><font size = -1>Cadastrado por: <?= substr($operador_autorizacao, 0, 15); ?></td>
            </tr>
            <tr>
                <td colspan="2"><font size = -1>&nbsp;</td>
                <td><font size = -1>Valor Devido:_________</td>
            </tr>
            <tr>
                <td colspan="2"><font size = -1>TECNICA:</td>
                <td><font size = -1>Valor Pago:___________</td>
            </tr>
        </tbody>
    </table>
    <?= $exame[0]->medico; ?>
    <hr>
    <table>
        <tr>
            <td ><font size = -1>Qtde</td>
            <td colspan="2"><font size = -1>Exames a Realizar</td>
            <td ><font size = -1>CONVENIO</td>
            <td ><font size = -1>SOLICITANTE</td>
            <td ><font size = -1>Codigo de Barras</td>
        </tr>
        <?
        foreach ($exames as $item) :
            if ($item->grupo == $exame[0]->grupo) {
                ?>
                <tr>
                    <td ><font size = -1><?= $item->quantidade ?></td>
                    <td ><font size = -1><? utf8_decode($item->codigo) ?></td>
                    <td width="40%;"><font size = -1><?= utf8_decode($item->procedimento) ?></td>
                    <td ><font size = -1><?= $item->convenio ?></td>
                    <td width="25%;"><font size = -1>Dr(a). <?= utf8_decode($item->medicosolicitante) ?></td>
                    <td ><img src="<?= base_url() . "upload/barcodeimg/$item->paciente_id/$item->agenda_exames_id.png"?>"</td>
                </tr>
                <?
            }
        endforeach;
        ?>
        </tbody>
    <table>
        <tbody>
        <td rowspan="3" width="70%;"><img align = 'left'  width='400px' height='200px' src=<?= base_url() . "img/seios.jpg" ?>></td>
        <td>Exame anterior</td>
        </tr>
        <tr>
            <td>MAMOGRAFIA</td>
        </tr>
        <tr>
            <td>USG MAMAS</td>
            <td></td>
        </tr>
        <tr>
            <td>Motivo:</td>
        </tr>
        <tr>
            <td>Rotina (&nbsp; )&nbsp;Rastrea (&nbsp; )</td>
        </tr>
        <tr>
            <td>Dados clinicos: __________________________________________________</td>
        </tr>
        </tbody>
    </table>







    <hr>
    <table>
        <tbody>
            <tr>
                <td colspan="3"><CENTER><font size = -1>PROTOCOLO DE ENTREGA DE RESULTADO DE EXAMES</CENTER></td>
        </tr>
        <tr>
            <td colspan="3"><CENTER><font size = -1>PR&Oacute;-IMAGEM DIGITAL / 3230-5900</CENTER></td>
        </tr>
        <tr>
            <td colspan="3"><font size = -1>UNIDADE I - AV. JO&Atilde;O PINHEIRO, 847 / UNIDADE II - RUA QUITINO BOCAIUVA, 254 - CENTRO</td>
        </tr>
        <tr>
            <td colspan="2"><font size = -1><?= $paciente['0']->paciente_id; ?></td>
            <td><font size = -1>Exames Realizados</td>
        </tr>
       
        <?
        $DT_ENTREGA = "";
        $b = 0;
        foreach ($exames as $item) :

            $b++;
            $data = $item->data_autorizacao;
            $dia = strftime("%A", strtotime($data));

            if ($dia == "Thursday") {
                if ($item->grupo == "RX" || $item->grupo == "US" || $item->grupo == "MAMOGRAFIA" || $item->grupo == "DENSITOMETRIA" || $item->grupo == "TOMOGRAFIA") {
                    $DT_ENTREGA = date('d-m-Y', strtotime("+1 days", strtotime($item->data_autorizacao)));
                } else {
                    $DT_ENTREGA = date('d-m-Y', strtotime("+5 days", strtotime($item->data_autorizacao)));
                }
            } elseif ($dia == "Friday") {
                if ($item->grupo == "RX" || $item->grupo == "US" || $item->grupo == "MAMOGRAFIA" || $item->grupo == "DENSITOMETRIA" || $item->grupo == "TOMOGRAFIA") {
                    $DT_ENTREGA = date('d-m-Y', strtotime("+3 days", strtotime($item->data_autorizacao)));
                } else {
                    $DT_ENTREGA = date('d-m-Y', strtotime("+5 days", strtotime($item->data_autorizacao)));
                }
            } elseif ($dia == "Saturday") {
                if ($item->grupo == "RX" || $item->grupo == "US" || $item->grupo == "MAMOGRAFIA" || $item->grupo == "DENSITOMETRIA" || $item->grupo == "TOMOGRAFIA") {
                    $DT_ENTREGA = date('d-m-Y', strtotime("+2 days", strtotime($item->data_autorizacao)));
                } else {
                    $DT_ENTREGA = date('d-m-Y', strtotime("+5 days", strtotime($item->data_autorizacao)));
                }
            } else {
                if ($item->grupo == "RX" || $item->grupo == "US" || $item->grupo == "MAMOGRAFIA" || $item->grupo == "DENSITOMETRIA" || $item->grupo == "TOMOGRAFIA") {
                    $DT_ENTREGA = date('d-m-Y', strtotime("+1 days", strtotime($item->data_autorizacao)));
                } else {
                    $DT_ENTREGA = date('d-m-Y', strtotime("+3 days", strtotime($item->data_autorizacao)));
                }
            }
            if ($item->grupo == $exame[0]->grupo) {
                if ($b == 1) {
                    ?>    
                    <tr>
                        <td ><font size = -1><?= $paciente['0']->nome; ?></td>
                        <?
                    } else {
                        ?>
                    <tr>
                        <td ><font size = -1>&nbsp;</td><? }
        ?>
                    <td width="40%;"><font size = -1>1 - <?= utf8_decode($item->procedimento) ?></td>
                    <td ><font size = -1><?= $DT_ENTREGA ?></td>
                <?
            }
        endforeach;
        ?>



        <tr>
            <td colspan="2"><font size = -1>Conv&ecirc;nio:<?= $exame[0]->convenio ?></td>
<!--            <td width="20%;"><font size = -1>Senha:<?= md5($exame_id) ?></td>-->
        </tr>
        </tbody>
        <table>
