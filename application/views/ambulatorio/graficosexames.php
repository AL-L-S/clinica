<!--<div class="content">  Inicio da DIV content -->
<meta charset="utf-8"/>
<? $tipoempresa = ""; ?>

<?
if (count($relatorio) > 0) {
    $tot = 0;
    $totHoje = 0;
    $totGrupoHoje = 0;
    $mesGrupos = array();
    $prcGrupo = array();
    $hojeProcedimentos = array();
    $hojeGrupo = array();

    foreach ($relatorio as $item) :
        if ($item->grupo != '') {
            @$mesGrupos[$item->grupo] ++;
            @$prcGrupo[$item->grupo][$item->procedimento] ++;

            $tot++;

            if ($item->data == date("Y-m-d")) {
                @$hojeProcedimentos[$item->procedimento] ++;
                @$hojeGrupo[$item->procedimento] ++;
                $totHoje++;
                $totGrupoHoje++;
            }
        }
    endforeach;
    ?>
    <?php ?>

    <table cellspacing="10" cellpadding="10">
        <tr>
            <td>
                <h3>Grupo do Dia</h3>

                <table border="1">
                    <thead>
                        <tr>
                            <th class="tabela_teste">Grupo</th>
                            <th class="tabela_teste">Quantidade</th>
                            <th class="tabela_teste">Percentual</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?
                        foreach ($mesGrupos as $key => $item2) {
                            $grupoPerc = number_format((($item2 * 100) / $tot), 2, ',', '');
                            ?>
                            <tr>
                                <td > <span style="color: red; cursor: pointer;" id="botao<?= $key ?>"><?= $key ?></span> </td>
                                <td style="text-align: right"> <?= $item2 ?></td>
                                <td style="text-align: right"> <?= $grupoPerc ?>%</td>
                                <!--<td style="text-align: right"> <?= $grupoPerc ?>%</td>-->
                            </tr>
                        <? } ?>
                        <tr>
                            <td colspan="3" rowspan="3" style='text-align: center;'><div id="grupos" style="height: 250px;"></div></td>
                        </tr>
                    </tbody>


                    <tbody>

                    </tbody>
                </table>
            </td>

            <td>
                <h3>Exames do Dia</h3>
                <br>
                <table border="1">
                    <thead>
                        <tr>
    <!--                            <th class="tabela_teste">Exame</th>
                            <th class="tabela_teste">Quantidade</th>
                            <th class="tabela_teste">Percentual</th>-->
                        </tr>
                    </thead>

                    <tbody>
                        <?
                        foreach ($hojeProcedimentos as $key => $item) {
                            $perc = number_format((($item * 100) / $totHoje), 2, ',', '');
                            ?>
                    <!--                                            <tr>
                                                           <td> <?= $key ?> </td>
                                                           <td style="text-align: right"> <?= $item ?></td>
                                                           <td style="text-align: right"> <?= $perc ?>%</td>
                                                       </tr>-->
                        <? } ?>
                        <tr>
                            <td colspan="3" rowspan="3" style='text-align: center;'><div id="hoje" style="min-width: 1000px;height: 450px;"></div></td>
                        </tr>
                    </tbody>


                </table>

            </td>
        </tr>
        <? foreach ($prcGrupo as $key => $item) { ?>
        <tr id="label<?= $key ?>">
                <td></td><td>Procedimentos do grupo: <?= $key ?> <button id="esconder<?= $key ?>">Esconder</button></td>
            </tr>
            <tr id="graphico<?= $key ?>">
                <td colspan="3" rowspan="3" style='text-align: center;'><div id="<?= $key ?>" style="min-width: 800pt;height: 450px;"></div></td>
            </tr>
        <? } ?>
    </table>
    <?
} else {
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
    element: 'grupos',
            data: [
<?
foreach ($mesGrupos as $nome => $item2) {
    $perc = round(($item2 * 100) / $tot)
    ?>
                {label: "<?= $nome ?>", value: <?= $item2; ?>, formatted: '<?= $perc; ?>%'},
<? } ?>
            ],
            colors: [
                    '#E3000E',
                    '#2C82C9',
                    '#2CC990',
                    '#C89657',
                    '#FFEaa0',
                    '#000000',
                    '#cccccc',
                    '#46gccc',
            ],
            formatter: function (x, data) {
            return data.formatted;
            }
    });
<? foreach ($prcGrupo as $key => $item) { ?>
        new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: '<?= $key ?>',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [
    <? foreach ($item as $nome => $item2) { ?>
                    {idade: '<?= $nome ?>', quantidade: <?= $item2; ?>},
    <? } ?>
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
<? } ?>
    new Morris.Bar({
    // ID of the element in which to draw the chart.
    element: 'hoje',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: [
<? foreach ($hojeProcedimentos as $nome => $item2) { ?>
                {idade: '<?= $nome ?>', quantidade: <?= $item2; ?>},
<? } ?>
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
<?
foreach ($mesGrupos as $key => $item2) {
    ?>
        $("#botao<?= $key ?>").click(function () {
        $("#graphico<?= $key ?>").fadeIn(1000);
        $("#label<?= $key ?>").fadeIn(1000);
        $("#esconder<?= $key ?>").fadeIn(1000);
        });
        $("#esconder<?= $key ?>").click(function () {
        $("#graphico<?= $key ?>").fadeOut(1000);
        $("#label<?= $key ?>").fadeOut(1000);
        $("#esconder<?= $key ?>").fadeOut(1000);
        });
<? } ?>
<?
foreach ($mesGrupos as $key => $item2) {
    ?>

//        $("#esconder<?= $key ?>").click(function () {
        $("#graphico<?= $key ?>").hide();
        $("#label<?= $key ?>").hide();
        $("#esconder<?= $key ?>").hide();
//        });
<? } ?>

//                    $(document).ready(function () {

//});
</script>
