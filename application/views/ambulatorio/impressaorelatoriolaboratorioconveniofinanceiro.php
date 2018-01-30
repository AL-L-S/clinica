<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<?
$MES = date("m");

switch ($MES) {
    case 1 : $MES = 'Janeiro';
        break;
    case 2 : $MES = 'Fevereiro';
        break;
    case 3 : $MES = 'Mar&ccedil;o';
        break;
    case 4 : $MES = 'Abril';
        break;
    case 5 : $MES = 'Maio';
        break;
    case 6 : $MES = 'Junho';
        break;
    case 7 : $MES = 'Julho';
        break;
    case 8 : $MES = 'Agosto';
        break;
    case 9 : $MES = 'Setembro';
        break;
    case 10 : $MES = 'Outubro';
        break;
    case 11 : $MES = 'Novembro';
        break;
    case 12 : $MES = 'Dezembro';
        break;
        break;
}
?>
<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->

    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Laboratório Convenios</h4>
    <? $sit = ($situacao == '') ? "TODOS" : (($situacao == '0') ? 'ABERTO' : 'FINALIZADO' ); ?>
    <h4>SITUAÇÃO: <?= $sit ?></h4>
    <h4>PERIODO: <?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4); ?> ate <?= substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4); ?></h4>

        <?

    if ($laboratorio == 0) {
        ?>
        <h4>Laboratório: TODOS</h4>
    <? } else { ?>
        <h4>Laboratório: <?= $laboratorio[0]->nome; ?></h4>
    <? } ?>


    <hr>
    <?
    if ($contador > 0 || count($relatoriocirurgico) > 0 || count($relatoriohomecare) > 0) {
        $totalperc = 0;
        $valor_recebimento = 0;
        ?>

        <? if (count($relatorio) > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <td colspan="50"><center>PRODUÇÃO LABORATORIAL</center></td>
                </tr>
                <tr>


                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Laboratorio</th>
                    <th class="tabela_header" width="100px;" title="Data do agendamento. Data onde o paciente foi agendado"><font size="-1">Data Agend.</th>
                    <th class="tabela_header" width="100px;" title="Data do atendimento. Data em que foi enviado da sala de espera"><font size="-1">Data Atend.</th>
                    <th class="tabela_header" width="100px;" title="Data de recebimento. Data em que o relatorio se baseia"><font size="-1">Data Receb.</th>
                    <th class="tabela_header"><font size="-1">Qtde</th>
                    <th class="tabela_header" width="220px;"><font size="-1">Procedimento</th>
                    <? if ($clinica == 'SIM') { ?>
                        <th class="tabela_header" ><font size="-1">Valor Bruto</th>
                        <th class="tabela_header" ><font size="-1">ISS</th>
                        <th class="tabela_header" ><font size="-1">Valor Liquido</th>
                    <? } ?>
                    <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor Laboratório</th>
                    <? if ($solicitante == 'SIM') { ?>
                        <th class="tabela_header" width="80px;"><font size="-1">Solicitante</th>
                    <? } ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $dados = array();
                    $vlrTotalDinheiro = 0;
                    $vlrTotalCartao = 0;
                    $i = 0;
                    $valor = 0;
                    $valortotal = 0;
                    $convenio = "";
                    $y = 0;
                    $qtde = 0;
                    $qtdetotal = 0;
                    $resultado = 0;
                    $simbolopercebtual = " %";
                    $iss = 0;
                    $perc = 0;
                    $totalgeral = 0;
                    $percpromotor = 0;
                    $totalgeralpromotor = 0;
                    $totalpercpromotor = 0;
                    $totalconsulta = 0;
                    $totalretorno = 0;
                    $taxaAdministracao = 0;
                    foreach ($relatorio as $item) :
                        $i++;
                        $procedimentopercentual = $item->procedimento_convenio_id;
                        $laboratoriopercentual = $item->laboratorio_id;
                        if ($item->grupo != "RETORNO") {
                            $totalconsulta++;
                        } else {
                            $totalretorno++;
                        }
                        $valor_total = $item->valor_total;
                        ?>
                        <tr>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><font size="-2"><?= $item->paciente; ?></td>
                            <td><font size="-2"><?= $item->laboratorio; ?></td>
                            <td><font size="-2">
                                <?
                                $modificado = "";
                                $onclick = "";
                                if ($item->data_antiga != "") {
                                    $modificado = " ** ";
                                }

                                echo $modificado,
                                substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4),
                                ($item->sala_pendente != "f") ? " (PENDENTE)" : "",
                                $modificado;
                                ?>
                            </td>
                            <td ><font size="-2"><?= date('d/m/Y', strtotime($item->data_laudo)); ?></td>
                            <td ><font size="-2"><?= date('d/m/Y', strtotime($item->data_producao)); ?></td>
                            <td ><font size="-2"><?= $item->quantidade; ?></td>

                            <td><font size="-2"><?= $item->procedimento; ?></td>
                            <? if ($clinica == 'SIM') { ?>
                                <td style='text-align: right;'><font size="-2"><?= number_format($valor_total, 2, ",", "."); ?></td>
                                <td style='text-align: right;' width="50"><font size="-2"><?= number_format($item->iss, 2, ",", "."); ?> (%)</td>
                                <td style='text-align: right;'><font size="-2"><?= number_format(((float) $valor_total - ((float) $valor_total * ((float) $item->iss / 100))), 2, ",", "."); ?></td>
                                <?
                            }
                            ?>
                            <?
                            if ($item->percentual_laboratorio == "t") {
                                $simbolopercebtual = " %";

                                $valorpercentuallaboratorio = $item->valor_laboratorio/* - ((float) $item->valor_laboratorio * ((float) $item->taxa_administracao / 100)) */;

                                $perc = $valor_total * ($valorpercentuallaboratorio / 100);
                            } else {
                                $simbolopercebtual = "";
                                $valorpercentuallaboratorio = $item->valor_laboratorio/* - ((float) $item->valor_laboratorio * ((float) $item->taxa_administracao / 100)) */;

//                                    $perc = $valorpercentuallaboratorio;
                                $perc = $valorpercentuallaboratorio * $item->quantidade;
                            }

                            $totalperc = $totalperc + $perc;
                            $totalgeral = $totalgeral + $valor_total;



                            @$tempoRecebimento[str_replace("-", "", $item->data_producao)][$item->laboratorio_parecer1] = array(
                                "laboratorio_nome" => @$item->laboratorio,
                                "valor_recebimento" => @$tempoRecebimento[str_replace("-", "", $item->data_producao)][@$item->laboratorio_parecer1]["valor_recebimento"] + $perc,
                                "data_recebimento" => $item->data_producao
                            );
                            ?>

                            <td style='text-align: right;'><font size="-2"><?= number_format($valorpercentuallaboratorio, 2, ",", "") . $simbolopercebtual ?></td>

                            <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>



                            <? if ($solicitante == 'SIM') { ?>
                                <td style='text-align: right;'><font size="-2"><?= $item->laboratoriosolicitante; ?></td>
                            <? } ?>
                        </tr>


                        <?php
                        $qtdetotal = $qtdetotal + $item->quantidade;
                    endforeach;

                    $resultadototalgeral = $totalgeral - $totalperc;
                    ?>
                    <tr>
                        <td ><font size="-1">TOTAL</td>
                        <td  colspan="2" style='text-align: right;'><font size="-1">Nr. Procedimentos: <?= $qtdetotal; ?></td>
                        <? if ($clinica == 'SIM') { ?>
                            <!--<td colspan="2" style='text-align: right;'><font size="-1">TOTAL CLINICA: <?= number_format($resultadototalgeral, 2, ",", "."); ?></td>-->
                        <? } else { ?>
                            <td colspan="2" style='text-align: right;'><font size="-1">&nbsp;</td>
                        <? } ?>
                        <!--                            As váriaveis estão invertidas-->

                        <td colspan="9" style='text-align: right;'><font size="-1">TOTAL LABORATORIO: <?= number_format($totalperc, 2, ",", "."); ?></td>
                    </tr>
                </tbody>
            </table>
        <? endif; ?>



        <?
        if ($laboratorio != 0) {
            ?>

            <hr>

                <? ?>
                <? if ($laboratorio != 0) {
                    ?>

                    <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharlaboratorio" method="post">
                        <input type="hidden" class="texto3" name="tipo" value="<?= $laboratorio[0]->tipo; ?>" readonly/>
                        <input type="hidden" class="texto3" name="nome" value="<?= $laboratorio[0]->credor_devedor_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="conta" value="<?= $laboratorio[0]->conta_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="classe" value="<?= $laboratorio[0]->classe; ?>" readonly/>
                        <input type="hidden" class="texto3" name="observacao" value="<?= "Período " . substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4) . " até " . substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4) . " laboratório: " . $laboratorio[0]->nome; ?>" readonly/>
                        <input type="hidden" class="texto3" name="data" value="<?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4) ?>" readonly/>
                        <input type="hidden" class="texto3" name="valor" value="<?= $totalperc; ?>" readonly/>
                        <?
                        $j = 0;
                        if ($laboratorio != 0) {
                            ?> 
                            <br>
                            <?
                            $empresa_id = $this->session->userdata('empresa_id');
                            $data['empresa'] = $this->guia->listarempresa($empresa_id);
                            $data_contaspagar = $data['empresa'][0]->data_contaspagar;
                            if ($data_contaspagar == 't') {
                                ?>

                                <br>
                                <label>Data Contas a Pagar</label><br>
                                <input type="text" class="texto3" name="data_escolhida" id="data_escolhida" value=""/>
                                <br>
                                <br>  
                            <? } ?>

                            <!--<br>-->
                            <button type="submit" name="btnEnviar">Produção Laboratorial</button>

                        <? } ?>
                    </form>
                    <?
                }
            }
            ?>
            <br>
            <? if ($laboratorio != 0) { ?> 
                <div>
                    <div style="display: inline-block">
                        <table border="1">
                            <thead>
                                <tr>
                                    <td colspan="50"><center>PRODUÇÃO LABORATORIAL</center></td>
                            </tr>
                            <tr>
                                <th class="tabela_header"><font size="-1">Laboratório</th>
                                <th class="tabela_header"><font size="-1">Qtde</th>
                                <th class="tabela_header"><font size="-1">Produ&ccedil;&atilde;o Medico</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?
                                foreach ($relatoriogeral as $itens) :
                                    ?>

                                    <tr>
                                        <td><font size="-2"><?= $itens->laboratorio; ?></td>
                                        <td ><font size="-2"><?= $itens->quantidade; ?></td>
                                        <td ><font size="-2"><?= number_format($itens->valor, 2, ",", "."); ?></td>
                                    </tr>

                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <? } ?>
                <div style="display: inline-block;margin: 5pt">
                </div>



            </div>

            <hr>
                    <style>
                /*.pagebreak { page-break-before: always; }*/
                    </style>
            
            <?
        } else {
            ?>
                    <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#data_escolhida").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

</script>