

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSeriesChart);

    function drawSeriesChart() {

      var data = google.visualization.arrayToDataTable([
        ['ID', 'Life Expectancy', 'Fertility Rate'],
        ['UNIMED',    80.66,              1.67],
        ['CAMED',    79.84,              1.36],
        ['HAPVIDA',    78.6,               1.84],
        ['AMIL',    72.73,              2.78],
        ['TESTE1',    80.05,              2],
        ['TESTE2',    72.49,              1.7],
        ['TESTE3',    68.09,              4.77],
        ['TESTE4',    81.55,              2.96],
        ['TESTE5',    68.6,               1.54],
        ['TESTE6',    78.09,              2.05]
      ]);

      var options = {
        title: 'VALOR MEDIO',
        hAxis: {title: 'dtde'},
        vAxis: {title: 'valor'},
        bubble: {textStyle: {fontSize: 11}}
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
      chart.draw(data, options);
    }
    </script>
  </head>
  <body>
    <div id="series_chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>



