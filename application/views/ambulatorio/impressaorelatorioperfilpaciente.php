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
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Perfil Paciente</th>
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
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MÉDICO: <?= $medico ?></th>
        </tr>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PLANO DE SAÚDE: <?= $plano ?></th>
        </tr>

        <? if ($tipoempresa == "0") { ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS RECOMENDAÇÕES</th>
            </tr>
        <? } else { ?>
            <tr>
                <!--<th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RECOMENDAÇÃO: <?= $indicacao; ?></th>-->
            </tr>
        <? } ?>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
        </tr>

    </thead>
</table>

<? if (count($relatorio) > 0) {
    ?>

    <table border="1">
        <thead>
            <tr>
                <td class="tabela_teste">Nome</td>
                <td class="tabela_teste">Idade</td>
                <td class="tabela_teste">Sexo</td>
                <td class="tabela_teste">Estado Civil</td>
                <td class="tabela_teste">Escolaridade</td>
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
            $adoles = 0;
            $adulto = 0;
            $adulto2 = 0;
            $adulto3 = 0;
            $adulto4 = 0;
            $adulto5 = 0;
            $adulto6 = 0;
            $adulto7 = 0;
            $adulto8 = 0;
            $adulto9 = 0;
            $adulto10 = 0;
            $idosos = 0;
            $idades = array();
            $totPlanoSaude = 0;
            $planoSaude = array();
            foreach ($relatorio as $item) :

                $i++;
                $qtdetotal++;
                ?>
                <tr>
                    <?
                    $totPlanoSaude++;
                    if($item->plano != ''){
                        @$planoSaude[$item->plano]++;
//                        @$planoSaude['teste']++;
//                        @$planoSaude['ok']++;
//                        $planoSaude['dsfjso']++;
                    }
                    else {
                        $planoSaude['semPlano']++;
                    }
                    
                    $dataFuturo = date("Y-m-d");
                    $dataAtual = $item->nascimento;
                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%Ya %mm %dd');
                    $idade = $teste = $diff->format('%Y');
                    if ($idade <= 11) {
                        $crianca ++;
                    }
                    if ($idade <= 18 && $idade >= 12) {
                        $adoles ++;
                    }
                    if ($idade <= 59 && $idade >= 19) {
                        $adulto++;
                        if ($idade <= 25 && $idade > 19) {
                            $adulto2++;
                        }
                        if ($idade <= 30 && $idade > 25) {
                            $adulto3++;
                        }
                        if ($idade <= 35 && $idade > 30) {
                            $adulto4++;
                        }
                        if ($idade <= 40 && $idade > 35) {
                            $adulto5++;
                        }
                        if ($idade <= 45 && $idade > 40) {
                            $adulto6++;
                        }
                        if ($idade <= 50 && $idade > 45) {
                            $adulto7++;
                        }
                        if ($idade <= 55 && $idade > 50) {
                            $adulto8++;
                        }
                        if ($idade <= 59 && $idade > 55) {
                            $adulto9++;
                        }
                    }
                    if ($idade >= 60) {
                        $idosos++;
                    }
                    ?>
                    <td><?= utf8_decode($item->paciente); ?></td>

                    <td style='text-align: center;'><font size="-1"><?= $idade; ?> Anos</td>
                    <td style='text-align: center;'><?
                        if ($item->sexo == "M") {
                            echo 'Masculino';
                            $masculino ++;
                        } else {
                            $feminino ++;
                            echo 'Feminino';
                        }
                        ?></td>
                    <td style='text-align: center;'><?
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
                        ?></td>

                    <td style='text-align: center;'><?
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
                        ?></td>
                </tr>
            <? endforeach; ?>

            <tr>
                <td width="140px;" align="Right" colspan="4"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
            </tr>
        </tbody>
    </table>
    <?php
    $sexo_total = $masculino + $feminino;
    $masculinop = round(($masculino * 100) / $sexo_total);
    $femininop = round(($feminino * 100) / $sexo_total);

    $faixa_etaria = $crianca + $adoles + $adulto + $idosos;
    $criancap = round(($crianca * 100) / $faixa_etaria);
    $adolesp = round(($adoles * 100) / $faixa_etaria);
    $adultop = round(($adulto * 100) / $faixa_etaria);
    $idososp = round(($idosos * 100) / $faixa_etaria);

    $estado_civil = $solteiro + $casado + $divorciado + $viuvo + $outros;
    $solteirop = round(($solteiro * 100) / $qtdetotal);
    $casadop = round(($casado * 100) / $qtdetotal);
    $divorciadop = round(($divorciado * 100) / $qtdetotal);
    $viuvop = round(($viuvo * 100) / $qtdetotal);
    $outrosp = round(($outros * 100) / $qtdetotal);

    $escolaridade = $fundamental1 + $fundamental2 + $medio1 + $medio2 + $superior1 + $superior2;

    if ($escolaridade > 0) {

        $fundamental1p = round(($fundamental1 * 100) / $escolaridade);
        $fundamental2p = round(($fundamental2 * 100) / $escolaridade);
        $medio1p = round(($medio1 * 100) / $escolaridade);
        $medio2p = round(($medio2 * 100) / $escolaridade);
        $superior1p = round(($superior1 * 100) / $escolaridade);
        $superior2p = round(($superior2 * 100) / $escolaridade);
    } else {
        $fundamental1p = 0;
        $fundamental2p = 0;
        $medio1p = 0;
        $medio2p = 0;
        $superior1p = 0;
        $superior2p = 0;
    }
    
    ?>
    <br>

    <table cellspacing="10" cellpadding="10">
        <tr>
            <td>
                <h3>Gênero</h3>

                <table border="1">
                    <thead>
                        <tr>
                            <th class="tabela_teste">Sexo</th>
                            <th class="tabela_teste">Quantidade</th>
                            <th class="tabela_teste">Percentual</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td style='text-align: center;'>Homens</td>
                            <td style="text-align: right"><?= $masculino; ?></td>
                            <td style="text-align: right"><?= $masculinop . "%"; ?></td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Mulheres</td>
                            <td style="text-align: right"><?= $feminino; ?></td>
                            <td style="text-align: right"><?= $femininop . "%"; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" rowspan="3" style='text-align: center;'><div id="sexo" style="height: 250px;"></div></td>
                        </tr>


                    </tbody>


                    <tbody>

                    </tbody>
                </table>
            </td>
            <td>
                <h3>Estado Civil</h3>
                <br>
                <table border="1">
                    <thead>
                        <tr>
                            <th class="tabela_teste">Estado Civil</th>
                            <th class="tabela_teste">Quantidade</th>
                            <th class="tabela_teste">Percentual</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td style='text-align: center;'>Solteiro(a)</td>
                            <td style="text-align: right"><?= $solteiro; ?></td>
                            <td style="text-align: right"><?= $solteirop . "%"; ?></td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Casado(a)</td>
                            <td style="text-align: right"><?= $casado; ?></td>
                            <td style="text-align: right"><?= $casadop . "%"; ?></td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Divorciado(a)</td>
                            <td style="text-align: right"><?= $divorciado; ?></td>
                            <td style="text-align: right"><?= $divorciadop . "%"; ?></td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Viuvo(a)</td>
                            <td style="text-align: right"><?= $viuvo; ?></td>
                            <td style="text-align: right"><?= $viuvop . "%"; ?></td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Outros</td>
                            <td style="text-align: right"><?= $outros; ?></td>
                            <td style="text-align: right"><?= $outrosp . "%"; ?></td>
                        </tr>
                        <tr>
                            <td rowspan="3" colspan="3"><div id="estado" style="height: 250px;"></div></td>
                        </tr>


                    </tbody>


                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3>Faixa Etária</h3>
                <br>
                <table border="1">
                    <thead>
                        <tr>
                            <th class="tabela_teste">Classificação</th>
                            <th class="tabela_teste">Quantidade</th>
                            <th class="tabela_teste">Percentual</th>
                            <th class="tabela_teste">Faixa Etária</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td style='text-align: center;'>Criança(s)</td>
                            <td style="text-align: right"><?= $crianca; ?></td>
                            <td style="text-align: right"><?= $criancap . "%"; ?></td>
                            <td style='text-align: center;'>0 - 11</td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Adolesteste(s)</td>
                            <td style="text-align: right"><?= $adoles; ?></td>
                            <td style="text-align: right"><?= $adolesp . "%"; ?></td>
                            <td style='text-align: center;'>12 - 18</td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Adulto(s)</td>
                            <td style="text-align: right"><?= $adulto; ?></td>
                            <td style="text-align: right"><?= $adultop . "%"; ?></td>
                            <td id="teste" class="btn1" style='text-align: center;color: red;cursor: pointer;' title="Mostrar Mais">19 - 59</td>

                        </tr>
                        <tr>
                            <td style='text-align: center;'>Idoso(s)</td>
                            <td style="text-align: right"><?= $idosos; ?></td>
                            <td style="text-align: right"><?= $idososp . "%"; ?></td>
                            <td style='text-align: center;'>60+</td>

                        </tr>
                        <tr>
                            <td rowspan="3" colspan="4">
                                <div id="grafico" style="height: 250px;"></div>

                            </td>
                        </tr>
                    </tbody>


                </table>
                <h3 id="adultoslabel" style="display: none">Adultos</h3> <button id="esconder" style="display: none">Esconder</button>

                <div id="adultos" style="height: 300px;display: none;"></div>
            </td>
            <td>

                <h3>Escolaridade</h3>
                <br>
                <table border="1">
                    <thead>
                        <tr>
                            <th class="tabela_teste">Classificação</th>
                            <th class="tabela_teste">Quantidade</th>
                            <th class="tabela_teste">Percentual</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td style='text-align: center;'>Fundamental-Incompleto</td>
                            <td style="text-align: right"><?= $fundamental1; ?></td>
                            <td style="text-align: right"><?= $fundamental1p . "%"; ?></td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Fundamental-Completo</td>
                            <td style="text-align: right"><?= $fundamental2; ?></td>
                            <td style="text-align: right"><?= $fundamental2p . "%"; ?></td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Médio-Incompleto</td>
                            <td style="text-align: right"><?= $medio1; ?></td>
                            <td style="text-align: right"><?= $medio1p . "%"; ?></td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>Médio-Completo</td>
                            <td style="text-align: right"><?= $medio2; ?></td>
                            <td style="text-align: right"><?= $medio2p . "%"; ?></td>

                        </tr>
                        <tr>
                            <td style='text-align: center;'>Superior-Incompleto</td>
                            <td style="text-align: right"><?= $superior1; ?></td>
                            <td style="text-align: right"><?= $superior1p . "%"; ?></td>

                        </tr>
                        <tr>
                            <td style='text-align: center;'>Superior-Completo</td>
                            <td style="text-align: right"><?= $superior2; ?></td>
                            <td style="text-align: right"><?= $superior2p . "%"; ?></td>

                        </tr>
                        <tr>
                            <td rowspan="3" colspan="4"><div id="escolaridade" style="height: 250px;"></div></td>
                        </tr>
                    </tbody>


                </table>
            </td>
        </tr>
        <tr>
            <td>
                <h3>Plano de Saude</h3>
                <br>
                <table border="1">
                    <thead>
                        <tr>
                            <th class="tabela_teste">Plano</th>
                            <th class="tabela_teste">Quantidade</th>
                            <th class="tabela_teste">Percentual</th>
                        </tr>
                    </thead>

                    <tbody>
                        
                        <? foreach($planoSaude as $nome => $plano){ 
                            if($nome == 'semPlano') continue;?>
                            
                            <tr>
                                <td><?= $nome ?></td>
                                <td style="text-align: right"><?= $plano ?></td>
                                <td style="text-align: right"><?= round(($plano * 100) / $totPlanoSaude); ?>%</td>
                            </tr>
                        <? }
                        if(isset($planoSaude['semPlano']) && @$planoSaude['semPlano'] > 0) {?>
                            <tr>
                                <td>Sem Plano</td>
                                <td style="text-align: right"><?= $planoSaude['semPlano'] ?></td>
                                <td style="text-align: right"><?= round(($planoSaude['semPlano'] * 100) / $totPlanoSaude); ?>%</td>
                            </tr>
                        <? } ?>
                        <tr>
                            <td rowspan="3" colspan="4"><div id="planosaude" style="height: 250px;"></div></td>
                        </tr>
                            
                    </tbody>


                </table>
                <!--<div id="adultos" style="height: 300px;display: none;"></div>-->
            </td>
            <td></td>
        </tr>
    </table>
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
    new Morris.Donut({
        element: 'planosaude',
        data: [
            <? foreach($planoSaude as $nome => $plano) { 
                $perc = round(($plano * 100) / $totPlanoSaude) ?>
            {label: "<?= $nome ?>", value: <?= $plano; ?>, formatted: '<?= $perc; ?>%'},
            <?}?>
        ],
        colors: [
            <? 
            foreach($planoSaude as $nome => $plano) { 
                ?>
            'rgb( <?= rand ( 0, 150) ?> , <?= rand ( 0, 150) ?> , <?= rand ( 0, 150) ?>)',
            <? } ?>
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
    });
    new Morris.Donut({
        element: 'grafico',
        data: [
            {label: "Crianças", value: <?= $criancap; ?>, formatted: '<?= $criancap; ?>%'},
            {label: "Adolescentes", value: <?= $adolesp; ?>, formatted: '<?= $adolesp; ?>%'},
            {label: "Adultos", value: <?= $adultop; ?>, formatted: '<?= $adultop; ?>%'},
            {label: "Idosos", value: <?= $idososp; ?>, formatted: '<?= $idososp; ?>%'}
        ],
        colors: [
            '#E3000E',
            '#2C82C9',
            '#2CC990',
            '#EEE657'
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
    });

    new Morris.Donut({
        element: 'sexo',
        data: [
            {label: "Homens", value: <?= $masculinop; ?>, formatted: '<?= $masculinop; ?>%'},
            {label: "Mulheres", value: <?= $femininop; ?>, formatted: '<?= $femininop; ?>%'}

        ],
        colors: [
            '#E3000E',
            '#2C82C9'
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
    });
    new Morris.Donut({
        element: 'estado',
        data: [
            {label: "Solteiro(a)", value: <?= $solteirop; ?>, formatted: '<?= $solteirop; ?>%'},
            {label: "Casado(a)", value: <?= $casadop; ?>, formatted: '<?= $casadop; ?>%'},
            {label: "Divorciado(a)", value: <?= $divorciadop; ?>, formatted: '<?= $divorciadop; ?>%'},
            {label: "Viuvo(a)", value: <?= $viuvop; ?>, formatted: '<?= $viuvop; ?>%'},
            {label: "Outros", value: <?= $outrosp; ?>, formatted: '<?= $outrosp; ?>%'}

        ],
        colors: [
            '#E3000E',
            '#2C82C9',
            '#2CC990',
            '#EEE657',
            '#7BB0A6'
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
    });

    new Morris.Donut({
        element: 'escolaridade',
        data: [
            {label: "Fundamental-Incompleto", value: <?= $fundamental1p; ?>, formatted: '<?= $fundamental1p; ?>%'},
            {label: "Fundamental-Completo", value: <?= $fundamental2p; ?>, formatted: '<?= $fundamental2p; ?>%'},
            {label: "Médio-Incompleto", value: <?= $medio1p; ?>, formatted: '<?= $medio1p; ?>%'},
            {label: "Médio-Completo", value: <?= $medio2p; ?>, formatted: '<?= $medio2p; ?>%'},
            {label: "Superior-Incompleto", value: <?= $superior1p; ?>, formatted: '<?= $superior1p; ?>%'},
            {label: "Superior-Completo", value: <?= $superior2p; ?>, formatted: '<?= $superior2p; ?>%'}

        ],
        colors: [
            '#E3000E',
            '#2C82C9',
            '#2CC990',
            '#EEE657',
            '#7BB0A6'
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
    });

    new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'adultos',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
            {idade: '20-25', quantidade: <?= $adulto2; ?>},
            {idade: '26-30', quantidade: <?= $adulto3; ?>},
            {idade: '31-35', quantidade: <?= $adulto4; ?>},
            {idade: '36-40', quantidade: <?= $adulto5; ?>},
            {idade: '41-45', quantidade: <?= $adulto6; ?>},
            {idade: '46-50', quantidade: <?= $adulto7; ?>},
            {idade: '51-55', quantidade: <?= $adulto8; ?>},
            {idade: '56-59', quantidade: <?= $adulto9; ?>}
        ],
        // The name of the data record attribute that contains x-values.
        xkey: 'idade',
        resize: true,
        hideHover: true,
        xLabelAngle: 60,
//        gridTextSize: 7,
//        axes: false
        // A list of names of data record attributes that contain y-values.
        ykeys: ['quantidade'],
        barColors: function (row, series, type) {
            if (type === 'bar') {
                var red = Math.ceil(200 * row.y / this.ymax);
                return 'rgb( 50,20,' + red + ')';
            } else {
                return '#000';
            }
        },
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Quantidade']
    });

    $(document).ready(function () {
        $("#teste").click(function () {
            $("#adultos").fadeIn(1000);
            $("#adultoslabel").fadeIn(1000);
            $("#esconder").fadeIn(1000);
//            $("#adultos").css( "display", "block" );
//            $("#adultos").css( "display", "none" );
        });
        $("#esconder").click(function () {
            $("#adultos").fadeOut(1000);
            $("#adultoslabel").fadeOut(1000);
            $("#esconder").fadeOut(1000);
        });
    });
</script>
