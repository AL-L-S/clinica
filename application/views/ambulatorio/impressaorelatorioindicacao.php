<div class="content"> <!-- Inicio da DIV content -->
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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Indica&ccedil;&atilde;o</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>

            <? if ($indicacao == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS INDICADOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">INDICADO: <?= $indicacao; ?></th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></th>
            </tr>

        </thead>
    </table>











    <? if (count($relatorio) > 0) {
        ?>

        <table border="1">
            <thead>
                <tr>
                    <td class="tabela_teste">Nome</th>
                    <td class="tabela_teste">Indica&ccedil;&atilde;o</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $i = 0;
                $b = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $tecnicos = "";
                $paciente = "";
                $indicacao = "";
                foreach ($relatorio as $item) :
                    $i++;
                    $qtdetotal++;
                    ?>
                    <tr>

                        <td><?= utf8_decode($item->paciente); ?></td>

                        <td style='text-align: center;'><font size="-2"><?= $item->indicacao; ?></td>
                    </tr>
                <? endforeach; ?>

                <tr>
                    <td width="140px;" align="Right" colspan="2"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>
        </table>
        <table border="1">
            <thead>
                <tr>
                    <td class="tabela_teste">Indica&ccedil;&atilde;o</th>
                    <td class="tabela_teste">Qtde</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                foreach ($consolidado as $item) :
                    $b++;
                    $qtde++;
                    ?>

                    <tr>
                        <td style='text-align: center;'><font size="-2"><?= $item->indicacao; ?></td>
                        <td><?= $item->quantidade; ?></td>
                    </tr>

                <? endforeach; ?>
            </tbody>
        </table>
    <?if($_POST['grafico'] == '1'&& $_POST['indicacao'] == '0'){?>
        <div id="grafico" style="height: 300px;width: 800px;"></div>
    <?}?>
        
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>js/morris/morris.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/Gruntfile.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/morris.js" ></script>
<script src="<?= base_url() ?>js/morris/raphael.js"></script>

<script>
    new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'grafico',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
<? foreach ($consolidado as $item) { ?>
                {indicacao: '<?= $item->indicacao; ?>', quantidade: <?= $item->quantidade; ?>, label:'<?= substr($item->indicacao, 0,11); ?>'},
<? } ?>

        ],
        // The name of the data record attribute that contains x-values.
        xkey: 'indicacao',
        resize: true,
        hideHover: true,
        gridTextSize: 10 ,
//        axes: false
        // A list of names of data record attributes that contain y-values.
        ykeys: ['quantidade'],
        barColors: function (row, series, type) {
            if (type === 'bar') {
                var red = Math.ceil(150 * row.y / this.ymax);
                return 'rgb(' + red + ' ,0,0)';
            } else {
                return '#000';
            }
        },
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Quantidade']
    });
</script>