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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Promotor</th>
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
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS PROMOTORES</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROMOTOR: <?= $indicacao[0]->indicacao; ?></th>
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
                    <th class="tabela_teste">Nome</th>
                    <th class="tabela_teste">Promotor</th>
                    <th class="tabela_teste">Procedimento</th>
                    <th class="tabela_teste" title="Data em que foi agendado.">Data Agendamento</th>
                    <th class="tabela_teste">Observação</th>
                    <th class="tabela_teste">Valor do Promotor</th>
                    <th class="tabela_teste">Valor Recebido R$</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $resultado = 0;
                $i = 0;
                $b = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $tecnicos = "";
                $paciente = "";
                $perc = 0;
                $totalgeral = 0;
                $totalperc = 0;
                foreach ($indicacao_valor as $value) {
                    $data[$value->nome] = '';
                    $numero[$value->nome] = 0;
                    $valor[$value->nome] = 0;
                }
//                    var_dump($data); die;

                foreach ($relatorio as $item) :
                    $i++;
                    $qtdetotal++;
                    $valor_total = $item->valor_total;

                    if ($item->percentual_promotor == "t") {
                        $simbolopercebtual = " %";

                        $valorpercentualmedico = $item->valor_promotor;

                        $perc = $valor_total * ($valorpercentualmedico / 100);
                        $totalperc = $totalperc + $perc;
                        $totalgeral = $totalgeral + $valor_total;
                        $data[$item->indicacao] = $item->indicacao;
                        $numero[$item->indicacao] ++;
                        $valor[$item->indicacao] = $valor[$item->indicacao] + $perc;
                        $valor_promotor = $item->valor_promotor . $simbolopercebtual;
                    } else {
                        $simbolopercebtual = "";
                        $valorpercentualmedico = $item->valor_promotor;

                        $perc = $valorpercentualmedico;
                        $totalperc = $totalperc + $perc;
                        $totalgeral = $totalgeral + $valor_total;
                        $data[$item->indicacao] = $item->indicacao;
                        $numero[$item->indicacao] ++;
                        $valor[$item->indicacao] = $valor[$item->indicacao] + $perc;
                        $valor_promotor = "R$ " . number_format($item->valor_promotor, 2, ",", ".");
                    }

                    $resultado += $perc;
                    ?>
                    <tr>

                        <td><?= utf8_decode($item->paciente); ?></td>

                        <td style='text-align: center;'><font size="-2"><?= $item->indicacao; ?></td>
                        <td style='text-align: center;'><font size="-2"><?= $item->procedimento ?></td>
                        <td style='text-align: center;'><font size="-2"><?= date("d/m/Y",strtotime($item->data)) ?></td>
                        <td style='text-align: center;'><font size="-2"><?= $item->observacoes ?></td>
                        <td style='text-align: center;'><font size="-2"><?= $valor_promotor ?></td>
                        <td style='text-align: center;'><font size="-1"><?= "R$ " . number_format($perc, 2, ",", "."); ?></td>
                    </tr>
                <? endforeach; ?>

                <tr>
                    <td width="140px;" align="Right" colspan="5"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>
        </table>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_teste">Promotor</th>
                    <th class="tabela_teste">Qtde</th>
                    <th class="tabela_teste">Valor R$</th>
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
                        <td><?= number_format($valor[$item->indicacao], 2, ",", "."); ?></td>
                    </tr>

                <? endforeach; ?>
            </tbody>
        </table>
        <? if ($_POST['grafico'] == '1' && $indicacao == '0') { ?>
            <div id="grafico" style="height: 300px;"></div>
        <? } 
        if ($indicacao != '0') { ?> 
            <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharpromotor" method="post">
                <input type="hidden" class="texto3" name="tipo" value="<?= @$indicacao[0]->tipo_id; ?>" readonly/>
                <input type="hidden" class="texto3" name="nome" value="<?= @$indicacao[0]->credor_devedor_id; ?>" readonly/>
                <input type="hidden" class="texto3" name="conta" value="<?= @$indicacao[0]->conta_id; ?>" readonly/>
                <input type="hidden" class="texto3" name="classe" value="<?= @$indicacao[0]->classe; ?>" readonly/>
                <input type="hidden" class="texto3" name="observacao" value="<?= "Período " . substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4) . " até " . substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4) . " promotor: " . @$indicacao[0]->indicacao; ?>" readonly/>
                <input type="hidden" class="texto3" name="data" value="<?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4) ?>" readonly/>
                <input type="hidden" class="texto3" name="valor" value="<?= $resultado; ?>" readonly/>
                <br>
                <?
                $empresa_id = $this->session->userdata('empresa_id');
                $data['empresa'] = $this->guia->listarempresa($empresa_id);
                $data_contaspagar = $data['empresa'][0]->data_contaspagar;
                if ($data_contaspagar == 't') {
                    ?>
                    <br>
                    <label>Data Contas a Pagar</label><br>
                    <input type="text" class="texto3" name="data_escolhida" id="data_escolhida" value="" required=""/>
                    <br>
                    <br>  
                <? } ?>
                <button type="submit" name="btnEnviar">Producao Promotor</button>

            </form>
        <? } ?>

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
                {indicacao: '<?= $item->indicacao; ?>', quantidade: <?= $item->quantidade; ?>, label: '<?= substr($item->indicacao, 0, 11); ?>'},
<? } ?>

        ],
        // The name of the data record attribute that contains x-values.
        xkey: 'indicacao',
        resize: true,
        hideHover: true,
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