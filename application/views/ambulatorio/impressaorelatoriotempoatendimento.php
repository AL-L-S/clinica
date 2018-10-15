<!--<div class="content">  Inicio da DIV content -->
<meta charset="utf-8"/>
<? $tipoempresa = ""; ?>
<table>
    <thead>

        <? if (count($empresa) > 0) { ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
            </tr>
            <?
            $tipoempresa = $empresa[0]->razao_social;
        } else {
            ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
            </tr>
            <?
            $tipoempresa = 'TODAS';
        }
        ?>

        
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Tempo de Atendimento</th>
        </tr>
        <tr>
            <th style='width:10pt;border:solid windowtext 1.0pt;
                border-bottom:none;mso-border-top-alt:none;border-left:
                none;border-right:none;' colspan="4">&nbsp;</th>
        </tr>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
        </tr>

        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $txtdata_inicio ?> ate <?= $txtdata_fim; ?></th>
        </tr>
        <? if (count($procedimentos) > 0) { ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROCEDIMENTO: <?= $procedimentos[0]->nome; ?></th>
            </tr>
            <?
            $procedimentos = $procedimentos[0]->nome;
        } else {
            ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROCEDIMENTO: TODOS</th>
            </tr>
            <?
            // $tipoempresa = 'TODAS';
        }
        ?>
        <? if (count($medico) > 0) { ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MÉDICO: <?= $medico[0]->operador; ?></th>
            </tr>
            <?
            $medico = $medico[0]->nome;
        } else {
            ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MÉDICO: TODOS</th>
            </tr>
            <?
            // $tipoempresa = 'TODAS';
        }
        ?>
    </thead>
</table>

<? if (count($relatorio) > 0) {
    ?>

    <table border="1">
        <thead>
            <tr>
                <th class="tabela_teste">Nome</th>
                <!--<th class="tabela_teste">Sexo</th>-->
                <!--<th class="tabela_teste">Idade</th>-->
                <!--<th class="tabela_teste">Data de Nascimento</th>-->
                <th class="tabela_teste">Data</th>
                <!--<th class="tabela_teste">Escolaridade</th>-->
                <th rowspan="2" class="tabela_teste">Hora de  <br> Chegada</th>
                <th class="tabela_teste">Tempo entre chegada e <br> Horário Marcado</th>
                <th class="tabela_teste">Horário <br> Marcado</th>
                <th class="tabela_teste">Tempo entre horário<br> marcado e atendimento</th>
                <th class="tabela_teste">Horário do <br> Atendimento</th>
                <th class="tabela_teste">Tempo até<br> Finalizar</th>
                <th class="tabela_teste">Atendimento <br> Finalizado</th>
            </tr>
        </thead>
        <hr>
        <tbody>
            <?php
            $i = 0;
            $b = 0;
            $c = 0;
            $qtde = 0;
            $qtdetotal = 0;
            $tecnicos = "";
            $paciente = "";
            $indicacao = "";
            $masculino = 0;
            $feminino = 0;
            $solteiro = 0;
            $casado = 0;
            $divorciado = 0;
            $fundamental1 = 0;
            $fundamental2 = 0;
            $medio1 = 0;
            $medio2 = 0;
            $superior1 = 0;
            $superior2 = 0;
            $viuvo = 0;
            $outros = 0;
            $crianca = 0;
            
            $total_chegada = 0;
            $total_consulta = 0;
            $total_atendimento = 0;
            $idades = array();
            foreach ($relatorio as $item) :

                $i++;
                $qtdetotal++;
                ?>
                <tr>
                    <?
                    $dataFuturo = date("Y-m-d");
                    $dataAtual = $item->nascimento;
                    $nascimento = date("d/m/Y", strtotime($item->nascimento));
                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%Ya %mm %dd');
                    $idade = $teste = $diff->format('%Y');
                    
                    ?>
                    <td><?= $item->paciente; ?></td>

                                                                                                            <!--<td style='text-align: center;'><font size="-1"><?= $nascimento; ?></td>-->
                    <td style='text-align: center;'><font size="-1"><?= date(" d/m/Y", strtotime($item->data)) ?></td>
        <!--                    <td style='text-align: center;'><?
                    if ($item->sexo == "M") {
//                            echo 'Masculino';
                        $masculino ++;
                    } else {
                        $feminino ++;
//                            echo 'Feminino';
                    }
                    ?></td>-->
        <!--                    <td style='text-align: center;'><?
                    if ($item->estado_civil_id == "1") {
                        echo 'Solteiro(a)';
                        $solteiro++;
                    } elseif ($item->estado_civil_id == "2") {
                        echo 'Casado(a)';
                        $casado++;
                    } elseif ($item->estado_civil_id == "3") {
                        echo 'Divorciado(a)';
                        $divorciado++;
                    } elseif ($item->estado_civil_id == "4") {
                        echo 'Viuvo(a)';
                        $viuvo++;
                    } elseif ($item->estado_civil_id == "5") {
                        echo 'Outros';
                        $outros++;
                    }
                    ?></td>-->

                                                                                                                        <!--                    <td style='text-align: center;'><?
                    //echo $item->conta;
                    if ($item->escolaridade_id == 1) {
                        echo 'Fundamental-Incompleto';
                        $fundamental1++;
                    } elseif ($item->escolaridade_id == 2) {
                        echo 'Fundamental-Completo';
                        $fundamental2++;
                    } elseif ($item->escolaridade_id == 3) {
                        echo 'Médio-Incompleto';
                        $medio1++;
                    } elseif ($item->escolaridade_id == 4) {
                        echo 'Médio-Completo';
                        $medio2++;
                    } elseif ($item->escolaridade_id == 5) {
                        echo 'Superior-Incompleto';
                        $superior1++;
                    } elseif ($item->escolaridade_id == 6) {
                        echo 'Superior-Completo';
                        $superior2++;
                    }
                    ?></td>-->

                    <td style='text-align: center;'><?= date(" H:i:s", strtotime($item->data_autorizacao)) ?></td>
                    <td style='text-align: center;'><?
                        $data_autorizacao = new DateTime($item->data_autorizacao);
                        $inicio = new DateTime($item->data . $item->inicio);
                        $diff2 = $data_autorizacao->diff($inicio, true);
                        if($data_autorizacao > $inicio){
                            echo 'Atraso:';
                        }
                        ?>
                        <span 
                        <?
                        if ($diff2->format('%H:%I:%S') > date("H:i:s", strtotime($tempo[0]->tempo_chegada))) {
                            echo "style='color:red;'";
                        }
                        if (((int) $diff2->format('%H')) > 0) {
                            $minutos_chegada = (((int) $diff2->format('%H')) * 60 + $diff2->format('%i'));
                        } else {
                            $minutos_chegada = ((int) $diff2->format('%i'));
                        }
                        $total_chegada = $total_chegada + $minutos_chegada;
                        ?>
                            >
                            <? echo $diff2->format('%H:%I:%S'); ?></span>
                    </td>
                    <td style='text-align: center;'><?= date("H:i:s", strtotime($item->inicio)) ?></td>
                    <td style='text-align: center;'><?
                        $data_inicio = new DateTime($item->data .' '. $item->inicio);
                        $data_atendimento = new DateTime($item->data_cadastro);
                        $diff3 = $data_inicio->diff($data_atendimento, true);
                        ?>
                        <span 
                        <?
                        if ($diff3->format('%H:%I:%S') > date("H:i:s", strtotime($tempo[0]->tempo_atendimento))) {
                            echo "style='color:red;'";
                        }
                        if (((int) $diff3->format('%H')) > 0) {
                            $minutos_consulta = (((int) $diff3->format('%H')) * 60 + $diff3->format('%i'));
                        } else {
                            $minutos_consulta = ((int) $diff3->format('%i'));
                        }

                        $total_consulta = $total_consulta + $minutos_consulta;
                        ?>
                            >
                            <? echo $diff3->format('%H:%I:%S'); ?></span>
                    </td>
                    <td style='text-align: center;'><?= date(" H:i:s", strtotime($item->data_cadastro)) ?></td>
                    <td style='text-align: center;'><?
                        $data_finalizado = new DateTime($item->data_atualizacao);
                        $diff4 = $data_finalizado->diff($data_atendimento, true);
                        ?>
                        <span 
                        <?
                        if ($diff4->format('%H:%I:%S') > date("H:i:s", strtotime($tempo[0]->tempo_finalizado))) {
                            echo "style='color:red;'";
                        }
                        if (((int) $diff4->format('%H')) > 0) {
                            $minutos_atendimento = (((int) $diff4->format('%H')) * 60 + $diff4->format('%i'));
                        } else {
                            $minutos_atendimento = ((int) $diff4->format('%i'));
                        }

                        $total_atendimento = $total_atendimento + $minutos_atendimento;
                        ?>
                            >

                            <? echo $diff4->format('%H:%I:%S'); ?></span>
                    </td>
                    <td style='text-align: center;'><?= date("H:i:s", strtotime($item->data_atualizacao)) ?></td>
                </tr>
            <? endforeach; ?>

            <tr>
                <td width="140px;" align="Right" colspan="9"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
            </tr>
        </tbody>
    </table>
    <?
    $media_chegada = round(($total_chegada) / $qtdetotal);
    $media_consulta = round(($total_consulta) / $qtdetotal);
    $media_atendimento = round(($total_atendimento) / $qtdetotal);
    ?>
    <br>
    <h3>Estatísticas</h3>

    <table border="1">
        <thead>
            <tr>
                <th class="tabela_teste">Tipo</th>
                <th class="tabela_teste">Tempo Médio</th>
                <th class="tabela_teste">Tempo Esperado</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td style='text-align: center;'>Chegada/Cons</td>
                <td style='text-align: center;'><?= $media_chegada; ?> Minutos</td>
                <td style='text-align: center;'><?= date("i", strtotime($tempo[0]->tempo_chegada)) . " Minutos"; ?></td>
            </tr>
            <tr>
                <td style='text-align: center;'>Consul/Atend</td>
                <td style='text-align: center;'><?= $media_consulta; ?> Minutos</td>
                <td style='text-align: center;'><?= date("i", strtotime($tempo[0]->tempo_atendimento)) . " Minutos"; ?></td>
            </tr>
            <tr>
                <td style='text-align: center;'>Atend/Final</td>
                <td style='text-align: center;'><?= $media_atendimento; ?> Minutos</td>
                <td style='text-align: center;'><?= date("i", strtotime($tempo[0]->tempo_finalizado)) . " Minutos"; ?></td>
            </tr>
            <tr>
                <!--<td colspan="3" rowspan="3" style='text-align: center;'><div id="sexo" style="height: 250px;"></div></td>-->
            </tr>


        </tbody>


        <tbody>

        </tbody>
    </table>
    <div id="graph" style="width: 800px;"></div>
    <? ?>
<? } else {
    ?>
    <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
<? }
?>


<!--</div>  Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>js/morris/morris.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/Gruntfile.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/morris.js" ></script>
<script src="<?= base_url() ?>js/morris/raphael.js"></script>


<script>

    // Use Morris.Bar
    Morris.Bar({
        element: 'graph',
        data: [
            {x: 'Chegada/Horário', y: <?= $media_chegada; ?>, z: <?=date("i", strtotime($tempo[0]->tempo_chegada))?>},
            {x: 'Horário/Atendim', y: <?= $media_consulta; ?>, z: <?=date("i", strtotime($tempo[0]->tempo_atendimento))?>},
            {x: 'Atendime/Final', y: <?= $media_atendimento; ?>, z: <?=date("i", strtotime($tempo[0]->tempo_finalizado))?>}
        ],
        xkey: 'x',
        hideHover:true,
        ykeys: ['y', 'z'],
        labels: ['Tempo Médio', 'Tempo Esperado']
    }).on('click', function (i, row) {
        console.log(i, row);
    });
</script>
