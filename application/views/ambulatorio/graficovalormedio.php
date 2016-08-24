

<html>
    <head>  
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawSeriesChart);

            function drawSeriesChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Convenio', 'Quantidade', 'Valor'],
                    //                ['Valor Medio', 0.5, <?php echo $valor ?>],
<?php
$convenio = $grafico[0]->convenio;
$valortotal = $grafico[0]->valortotal;
$quantidade = $this->guia->relatoriograficovalormedio2($procedimento, $convenio, $txtdata_inicio, $txtdata_fim);

if ($quantidade !== 0) {
    ?>
                        ['<?php echo $convenio ?>', <?php echo $quantidade ?>, <?php echo $valortotal ?>],
<? } ?>
<?php
foreach ($grafico as $item) {
    if ($convenio !== $item->convenio) {
        $convenio = $item->convenio;
        $valortotal = $item->valortotal;
        $quantidade = $this->guia->relatoriograficovalormedio2($procedimento, $convenio, $txtdata_inicio, $txtdata_fim);
        if ($quantidade !== 0) {
            ?>
                                ['<?php echo $convenio ?>', <?php echo $quantidade ?>, <?php echo $valortotal ?>],
        <?php
        }
    }
}
?>
                ]);
                var options = {
                    title: 'VALOR MEDIO',
                    hAxis: {title: 'quantidade',
                        maxValue: '10',
                        gridlines: {count: '15'}
                    },
                    vAxis: {title: 'valor',
                        maxValue: '10',
                        baseline: '<?php echo $valor ?>',
                        gridlines: {count: '15'}
                    },
                    bubble: {textStyle: {fontSize: 11}}
                };

                var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <div id="series_chart_div" style="width: 1000px; height: 500px;"></div>
    </body>
</html>



