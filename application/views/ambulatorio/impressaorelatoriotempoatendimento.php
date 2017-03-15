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
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Paciente Único/Retorno</th>
        </tr>
        <tr>
            <th style='width:10pt;border:solid windowtext 1.0pt;
                border-bottom:none;mso-border-top-alt:none;border-left:
                none;border-right:none;' colspan="4">&nbsp;</th>
        </tr>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
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
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?=$txtdata_inicio ?> ate <?=$txtdata_fim; ?></th>
        </tr>

    </thead>
</table>

<? if (count($relatorio) > 0) {
    ?>

    <table border="1">
        <thead>
            <tr>
                <th class="tabela_teste">Nome</th>
                <th class="tabela_teste">Sexo</th>
                <th class="tabela_teste">Idade</th>
                <th class="tabela_teste">Data de Nascimento</th>
                <!--<th class="tabela_teste">Escolaridade</th>-->
                <th class="tabela_teste">Hora da chegada</th>
                <th class="tabela_teste">Tempo Recepção</th>
                <th class="tabela_teste">Status</th>
                <th class="tabela_teste">Status</th>
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
            $retorno = 0;
            $unico = 0;
            $idades = array();
            foreach ($relatorio as $item) :

                $i++;
                $qtdetotal++;
                
                ?>
                <tr>
                    <?
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
                            $adulto5++;
                        }
                        if ($idade <= 40 && $idade > 35) {
                            $adulto6++;
                        }
                        if ($idade <= 45 && $idade > 40) {
                            $adulto7++;
                        }
                        if ($idade <= 50 && $idade > 45) {
                            $adulto8++;
                        }
                        if ($idade <= 55 && $idade > 50) {
                            $adulto9++;
                        }
                        if ($idade <= 59 && $idade > 55) {
                            $adulto10++;
                        }
                    }
                    if ($idade >= 60) {
                        $idosos++;
                    }
                    ?>
                    <td><?= $item->paciente; ?></td>

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

                    <td style='text-align: center;'><? ?></td>
                </tr>
            <? endforeach; ?>

            <tr>
                <td width="140px;" align="Right" colspan="5"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
            </tr>
        </tbody>
    </table>
    <?
    
    $unicop = round(($unico * 100) / $qtdetotal);
    $retornop = round(($retorno * 100) / $qtdetotal);
    
    ?>
    <br>
    <h3>Estatísticas</h3>

    <table border="1">
        <thead>
            <tr>
                <th class="tabela_teste">Tipo</th>
                <th class="tabela_teste">Quantidade</th>
                <th class="tabela_teste">Percentual</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td style='text-align: center;'>Único</td>
                <td><?= $unico; ?></td>
                <td><?= $unicop . "%"; ?></td>
            </tr>
            <tr>
                <td style='text-align: center;'>Retorno</td>
                <td><?= $retorno; ?></td>
                <td><?= $retornop . "%"; ?></td>
            </tr>
            <tr>
                <td colspan="3" rowspan="3" style='text-align: center;'><div id="sexo" style="height: 250px;"></div></td>
            </tr>


        </tbody>


        <tbody>

        </tbody>
    </table>
    <?
    ?>
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
        element: 'sexo',
        data: [
            {label: "Retorno", value: <?= $retornop; ?>, formatted: '<?= $retornop; ?>%'},
            {label: "Único", value: <?= $unicop; ?>, formatted: '<?= $unicop; ?>%'}
            

        ],
        colors: [
            '#E3000E',
            '#2C82C9'
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
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
