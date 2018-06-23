<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Relatorio De Demanda Por Grupo</h4>   
    <h4>GRUPO: <?= ($grupo != '') ? $grupo : "TODOS" ?></h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> até <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>

    <hr>
    
    <? 
    $grupos = array();
    if( count($relatorio) > 0 ){
        ?> 
        <h3 style="text-align: center;">Dia de Preferência</h3> 
        <?
        foreach ($relatorio as $value){
            $gp = str_replace(" ", "", (($value->grupo == '')?'void':$value->grupo));
            $diaSemana = (($value->dia_semana_preferencia!='')?$value->dia_semana_preferencia:'indiferente');
            @$grupos[$gp][$diaSemana]++;
            @$grupos[$gp]['total']++;
        } 
        foreach($grupos as $key => $value){ ?>
            <table border="1" class="tableGrupos">
                <tbody>
                    <tr>
                        <td colspan='2' style="text-align: center; background-color: #ccc">GRUPO: <?= $key ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">Dia</td>
                        <td style="text-align: center;">Quantidade</td>
                    </tr>
                    <? if(@$value['segunda'] != 0) { ?>
                        <tr>
                            <td>Segunda</td>
                            <td style="text-align: right;"><?= (int)$value['segunda'] ?></td>
                        </tr>  
                    <? } ?>
                    <? if(@$value['terca'] != 0) { ?>
                        <tr>
                            <td>Terça</td>
                            <td style="text-align: right;"><?= (int)$value['terca'] ?></td>
                        </tr>  
                    <? } ?>
                    <? if(@$value['quarta'] != 0) { ?>
                        <tr>
                            <td>Quarta</td>
                            <td style="text-align: right;"><?= (int)$value['quarta'] ?></td>
                        </tr>  
                    <? } ?>
                    <? if(@$value['quinta'] != 0) { ?>
                        <tr>
                            <td>Quinta</td>
                            <td style="text-align: right;"><?= (int)$value['quinta'] ?></td>
                        </tr>  
                    <? } ?>
                    <? if(@$value['sexta'] != 0) { ?>
                        <tr>
                            <td>Sexta</td>
                            <td style="text-align: right;"><?= (int)$value['sexta'] ?></td>
                        </tr>  
                    <? } ?>
                    <? if(@$value['sabado'] != 0) { ?>
                        <tr>
                            <td>Sabado</td>
                            <td style="text-align: right;"><?= (int)$value['sabado'] ?></td>
                        </tr>  
                    <? } ?>
                    <? if(@$value['domingo'] != 0) { ?>
                        <tr>
                            <td>Domingo</td>
                            <td style="text-align: right;"><?= (int)$value['domingo'] ?></td>
                        </tr>  
                    <? } ?>
                    <? if(@$value['indiferente'] != 0) { ?>
                        <tr>
                            <td>Indiferente</td>
                            <td style="text-align: right;"><?= (int)$value['indiferente'] ?></td>
                        </tr>  
                    <? } ?>
                    <tr>
                        <td colspan="3" rowspan="3" style='text-align: center;'><div id="<?= $key ?>" style="height: 250px; width: 250px;"></div></td>
                    </tr>
                </tbody>
            </table>
            
        <? } ?>
        <div id="turnoPreferencia" style="display: none">
            <hr>
            <h3 style="text-align: center">Turno de Preferência</h3>
            <table border='1' style="margin: auto">
                <tr>
                    <td colspan='2' style='text-align: center; background-color: #ccc'>
                        GRUPO: <span class="grupoValor" style="text-transform: uppercase"></span><br>
                        DIA: <span class="diaValor" style="text-transform: uppercase"></span>
                    </td>
                </tr>
                <tr>
                    <td style='text-align: center;'>Turno</td>
                    <td style='text-align: center;'>Quantidade</td>
                </tr>
                <tr><td>Manhã</td><td style='text-align: right;'><span class="manhaValor">0</span></td></tr>
                <tr><td>Tarde</td><td style='text-align: right;'><span class="tardeValor">0</span></td></tr>
                <tr><td>Noite</td><td style='text-align: right;'><span class="noiteValor">0</span></td></tr>
                <tr><td>Indiferente</td><td style='text-align: right;'><span class="indiferenteValor">0</span></td></tr>
                <tr>
                    <td colspan='3' rowspan='3' style='text-align: center;'>
                        <div id='turnoGrupo' style='height: 250px; width: 250px;'></div>
                    </td>
                </tr>
            </table>
        </div>
    
    <? } 
    else {
        echo "<h3>Não há resultados para essa consulta.</h3>";
    }
?>
</div> <!-- Final da DIV content -->
<style>
    .tableGrupos{
        display: inline-block;
        vertical-align: top;
        margin: 10pt;
    }
</style>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/Gruntfile.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/morris.js" ></script>
<script src="<?= base_url() ?>js/morris/raphael.js"></script>
<script>
    $(document).ready(function () {
        $(".tableGrupos").click(function () {
            $('html, body').animate({
                scrollTop: $("#turnoPreferencia").offset().top
            }, 1000);
        });
    });
            
    var turnoGrafico = new Morris.Donut({
        element: 'turnoGrupo',
        data: [
            {label: "Manhã", value: 0, formatted: '0%'},
            {label: "Tarde", value: 0, formatted: '0%'},
            {label: "Noite", value: 0, formatted: '0%'},
            {label: "Indiferente", value: 0, formatted: '0%'}
        ],
        colors: [
            '#e74c3c',
            '#2980b9',
            '#2ecc71',
            '#7f8c8d',
        ],
        formatter: function (x, data) {
            return data.formatted;
        } 
    });
    <? 
    foreach($grupos as $key => $value){ ?> 
        
        new Morris.Donut({
            element: '<?= $key ?>',
            data: [
                <? foreach ($value as $key2 => $item) { 
                    if($key2 != 'total') { ?>
                        {label: "<?= $key2; ?>", value: <?= $item; ?>, formatted: '<?= number_format(($item/$value['total'])*100, 2, ',', ''); ?>%'},
                <?  }
                } ?>
            ],
            colors: [
                '#e74c3c',
                '#2980b9',
                '#2ecc71',
                '#7f8c8d',
                '#34495e',
                '#f1c40f',
                '#9b59b6',
                '#F8EFBA',
            ],
            formatter: function (x, data) {
                return data.formatted;
            }
        }).on('click', function(value, item){
            $("#turnoPreferencia").css('display', 'block');
            
            var parametros = new Object();
            parametros.txtdata_inicio = '<?= $_POST['txtdata_inicio'] ?>';
            parametros.txtdata_fim = '<?= $_POST['txtdata_fim'] ?>';
            parametros.empresa = '<?= $_POST['empresa'] ?>';
            parametros.grupo = '<?= $key ?>';
            parametros.dia = item.label;
            
            $("span.grupoValor").text(parametros.grupo);
            $("span.diaValor").text(parametros.dia);
            
            $.getJSON('<?= base_url() ?>autocomplete/buscadadosgraficorelatoriodemandagrupo', parametros, function (j) {
                $("span.manhaValor").text(j.manha);
                $("span.tardeValor").text(j.tarde);
                $("span.noiteValor").text(j.noite);
                $("span.indiferenteValor").text(j.indiferente);
                
                var total = parseInt(j.manha) + parseInt(j.tarde) + parseInt(j.noite) + parseInt(j.indiferente);
                
                var json = [
                    {label: "Manhã", value: parseInt(j.manha), formatted: ((j.manha/total)*100).toFixed(2).replace(".",",")+'%'},
                    {label: "Tarde", value: parseInt(j.tarde), formatted: ((j.tarde/total)*100).toFixed(2).replace(".",",")+'%'},
                    {label: "Noite", value: parseInt(j.noite), formatted: ((j.noite/total)*100).toFixed(2).replace(".",",")+'%'},
                    {label: "Indiferente", value: parseInt(j.indiferente), formatted: ((j.indiferente/total)*100).toFixed(2).replace(".",",")+'%'}
                ];
                
                turnoGrafico.setData(json);
                
            });
        });
    <? } ?>
    
    $(function () {
        $("#accordion").accordion();
    });

</script>
