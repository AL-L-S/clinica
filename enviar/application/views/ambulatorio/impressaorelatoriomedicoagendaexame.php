<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Agenda Consultas</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <? if (count($medico) > 0) { ?>
        <h4>Medico: <?= $medico[0]->operador; ?></h4>
    <? } ?>
    <? if (count($salas) > 0) { ?>
        <h4>Sala: <?= $salas[0]->nome; ?></h4>
    <? } ?>
    <hr>
    <table border="1">
        <thead>
            <tr>
                <th class="tabela_header" >Status</th>
                <th class="tabela_header" width="250px;">Nome</th>
                <th class="tabela_header" width="70px;">Resp.</th>
                <th class="tabela_header" width="70px;">Procedimento</th>
                <th class="tabela_header" width="70px;">Data</th>
                <th class="tabela_header" width="50px;">Dia</th>
                <th class="tabela_header" width="70px;">Agenda</th>
                <th class="tabela_header" width="150px;">Medico</th>
                <th class="tabela_header" width="150px;">Convenio</th>
                <th class="tabela_header">Telefone</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $paciente = "";
            $contador = 0;
            if (count($relatorio) > 0) {
                foreach ($relatorio as $item) {
                    $dataFuturo = date("Y-m-d H:i:s");
                    $dataAtual = $item->data_atualizacao;

                    if ($item->celular != "") {
                        $telefone = $item->celular;
                    } elseif ($item->telefone != "") {
                        $telefone = $item->telefone;
                    } else {
                        $telefone = "";
                    }

                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%H:%I:%S');

                    if ($item->paciente == "" && $item->bloqueado == 't') {
                        $situacao = "Bloqueado";
                        $paciente = "Bloqueado";
                        $verifica = 5;
                    } else {
                        $paciente = "";

                        if ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') {
                            $situacao = "Aguardando";
                            $verifica = 2;
                        } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                            $situacao = "Finalizado";
                            $verifica = 4;
                        } elseif ($item->confirmado == 'f') {
                            $situacao = "agenda";
                            $verifica = 1;
                        } else {
                            $situacao = "espera";
                            $verifica = 3;
                        }
                    }
                    if ($item->paciente == "" && $item->bloqueado == 'f') {
                        $paciente = "vago";
                    }
                    $data = $item->data;
                    $dia = strftime("%A", strtotime($data));

                    switch ($dia) {
                        case"Sunday": $dia = "Domingo";
                            break;
                        case"Monday": $dia = "Segunda";
                            break;
                        case"Tuesday": $dia = "Terça";
                            break;
                        case"Wednesday": $dia = "Quarta";
                            break;
                        case"Thursday": $dia = "Quinta";
                            break;
                        case"Friday": $dia = "Sexta";
                            break;
                        case"Saturday": $dia = "Sabado";
                            break;
                    }
                    ?>
                    <tr>
                        <td ><b><?= $situacao; ?></b></td>
                        <? if ($item->paciente != '') { ?>
                        <td <b><?= utf8_decode($item->paciente); ?></b></td>
                        <? 
                        $contador++;
                        } else { ?>
                            <td >&nbsp;</td>
                        <? } ?>
                        <? if ($item->secretaria != '') { ?>
                            <td ><?= substr($item->secretaria, 0, 9); ?></td>
                        <? } else { ?>
                            <td >&nbsp;</td>
                        <? } ?>
                        
                        <td><?= utf8_decode($item->procedimento); ?></td>    
                        <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>

                        <td ><?= substr($dia, 0, 3); ?></td>
                        <td ><?= $item->inicio; ?></td>
                        <td  width="150px;"><?= $item->sala . " - " . utf8_decode(substr($item->medicoagenda, 0, 15)); ?></td>
                        <? if ($item->convenio != '') { ?>
                            <td ><?= utf8_decode($item->convenio); ?></td>
                        <? } else { ?>
                            <td >&nbsp;</td>
                        <? } ?>
                        <? if ($telefone != '') { ?>
                            <td ><?= $telefone; ?></td>
                        <? } else { ?>
                            <td >&nbsp;</td>
                        <? } ?>

                    </tr>

                </tbody>
                <?php
            }
        }
        ?>

    </table>
     <h4>Toatl de exames marcados <?= $contador; ?></h4>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>
