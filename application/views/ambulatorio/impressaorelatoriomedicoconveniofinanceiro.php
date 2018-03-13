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
    <? if ($medico != 0 && $recibo == 'SIM') { ?>
        <div>
            <p style="text-align: center;"><img align = 'center'  width='300px' height='150px' src="<?= base_url() . "img/cabecalho.jpg" ?>"></p>
        </div>
    <? } ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Medico Convenios</h4>
    <? $sit = ($situacao == '') ? "TODOS" : (($situacao == '0') ? 'ABERTO' : 'FINALIZADO' ); ?>
    <h4>SITUAÇÃO: <?= $sit ?></h4>
    <h4>PERIODO: <?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4); ?> ate <?= substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4); ?></h4>
    <? if ($revisor == 0) { ?>
        <h4>Revisor: TODOS</h4>
    <? } else { ?>
        <h4>Revisor: <?= $revisor[0]->operador; ?></h4>
        <?
    }
    if ($medico == 0) {
        ?>
        <h4>Medico: TODOS</h4>
    <? } else { ?>
        <h4>Medico: <?= $medico[0]->operador; ?></h4>
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
                        <td colspan="50"><center>PRODUÇÃO AMBULATORIAL</center></td>
                </tr>
                <tr>


                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Medico</th>
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
                    <? if ($_POST['forma_pagamento'] == 'SIM') { ?>
                        <th class="tabela_header" ><font size="-1">F. Pagamento Cartão</th>
                        <th class="tabela_header" ><font size="-1">F. Pagamento Dinheiro</th>
                    <? } ?>
                    <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor Medico</th>
                    <? if ($_POST['promotor'] == 'SIM') { ?>
                        <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor Promotor</th>
                        <th class="tabela_header" width="80px;"><font size="-1">Valor Promotor</th>   
                        <th class="tabela_header" width="80px;"><font size="-1">Promotor</th>   
                    <? } ?>
                    <? if ($_POST['laboratorio'] == 'SIM') { ?>
                        <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor Laboratório</th>
                        <th class="tabela_header" width="80px;"><font size="-1">Valor Laboratório</th>   
                        <th class="tabela_header" width="80px;"><font size="-1">Laboratório</th>   
                    <? } ?>

                    <? if ($mostrar_taxa == 'SIM') { ?>
                        <th class="tabela_header" ><font size="-1">Taxa Administração</th>
                    <? } ?>

                    <th class="tabela_header"><font size="-1">Revisor</th>
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
                    $perclaboratorio = 0;
                    $totalgerallaboratorio = 0;
                    $totalperclaboratorio = 0;
                    $totalconsulta = 0;
                    $totalretorno = 0;
                    $taxaAdministracao = 0;
                    foreach ($relatorio as $item) :
                        $i++;
                        $procedimentopercentual = $item->procedimento_convenio_id;
//            $medicopercentual = $item->medico_parecer1;
                        $medicopercentual = $item->operador_id;
                        if ($item->grupo != "RETORNO") {
                            $totalconsulta++;
                        } else {
                            $totalretorno++;
                        }
//                        $valor_total_formas = $item->valor1 + $item->valor2 + $item->valor3 + $item->valor4;
//                        $valor_total = $valor_total_formas + $item->desconto_ajuste1 + $item->desconto_ajuste2 + $item->desconto_ajuste3 + $item->desconto_ajuste4;
                        $valor_total = $item->valor_total;
                        ?>
                        <tr>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><font size="-2"><?= $item->paciente; ?></td>
                            <td><font size="-2"><?= $item->medico; ?></td>
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
                                <?
//                                $valorLiqMed = ((float) $valor_total - ((float) $valor_total * ((float) $item->iss / 100)) - ((float) $valor_total * ((float) $item->taxa_administracao / 100))); 
                                ?>
                                <td style='text-align: right;'><font size="-2"><?= number_format(((float) $valor_total - ((float) $valor_total * ((float) $item->iss / 100))), 2, ",", "."); ?></td>
                                <?
                            }
                            if ($_POST['forma_pagamento'] == 'SIM') {
                                $vlrDinheiro = 0;
                                $vlrCartao = 0;
                                if ($item->forma_pagamento1 != 1000 && $item->forma_pagamento2 != 1000 && $item->forma_pagamento3 != 1000 && $item->forma_pagamento4 != 1000) {


                                    if ($item->cartao1 != 'f') {
                                        $vlrDinheiro += $item->valor1;
                                    } else {
                                        $vlrCartao += $item->valor1;
                                    }

                                    if ($item->cartao2 != 'f') {
                                        $vlrDinheiro += $item->valor2;
                                    } else {
                                        $vlrCartao += $item->valor2;
                                    }

                                    if ($item->cartao3 != 'f') {
                                        $vlrDinheiro += $item->valor3;
                                    } else {
                                        $vlrCartao += $item->valor3;
                                    }

                                    if ($item->cartao4 != 'f') {
                                        $vlrDinheiro += $item->valor4;
                                    } else {
                                        $vlrCartao += $item->valor4;
                                    }
                                }

                                $vlrTotalDinheiro += $vlrDinheiro;
                                $vlrTotalCartao += $vlrCartao;
                                ?>
                                <td style='text-align: right;'><font size="-2"><?= number_format($vlrDinheiro, 2, ",", "."); ?></td>
                                <td style='text-align: right;'><font size="-2"><?= number_format($vlrCartao, 2, ",", "."); ?></td>
                                <?
                            }

                            // DESCONTANDO O VALOR DO LABORATORIO
                            if ($_POST['laboratorio'] == 'SIM') {


                                if ($item->percentual_laboratorio == "t") {
                                    $simbolopercebtuallaboratorio = " %";

                                    $valorpercentuallaboratorio = $item->valor_laboratorio/* - ((float) $item->valor_laboratorio * ((float) $item->taxa_administracao / 100)) */;

                                    $perclaboratorio = $valor_total * ($valorpercentuallaboratorio / 100);
//                                    var_dump(@$empresa_permissao[0]->valor_laboratorio); die;
                                } else {
                                    $simbolopercebtuallaboratorio = "";
                                    $valorpercentuallaboratorio = $item->valor_laboratorio/* - ((float) $item->valor_laboratorio * ((float) $item->taxa_administracao / 100)) */;

//                                    $perclaboratorio = $valorpercentuallaboratorio;
                                    $perclaboratorio = $valorpercentuallaboratorio * $item->quantidade;
                                }
                                if (@$empresa_permissao[0]->valor_laboratorio == 't') {
                                    $valor_total = $valor_total - $perclaboratorio;
                                }
                                $totalperclaboratorio = $totalperclaboratorio + $perclaboratorio;
                                $totalgerallaboratorio = $totalgerallaboratorio + $valor_total;
                            }
                            // EM CASO DE A CONDIÇÃO ABAIXO SER VERDADEIRA. O VALOR DO PROMOTOR VAI SER DESCONTADO DO MÉDICO
                            // NÃO DÁ CLINICA

                            if (@$empresa_permissao[0]->promotor_medico == 't' && $_POST['promotor'] == 'SIM') {
                                // MESMAS REGRAS ABAIXO PARA O PROMOTOR ABAIXO
//                                var_dump(@$empresa_permissao[0]->promotor_medico);
//                                die;
                                if ($item->percentual_promotor == "t") {
                                    $simbolopercebtualpromotor = " %";
                                    $valorpercentualpromotor = $item->valor_promotor/* - ((float) $item->valor_promotor * ((float) $item->taxa_administracao / 100)) */;

                                    $percpromotor = $valor_total * ($valorpercentualpromotor / 100);
                                } else {
                                    $simbolopercebtualpromotor = "";
                                    $valorpercentualpromotor = $item->valor_promotor/* - ((float) $item->valor_promotor * ((float) $item->taxa_administracao / 100)) */;

                                    $percpromotor = $valorpercentualpromotor * $item->quantidade;
                                }

                                // SE FOR PERCENTUAL, ELE CALCULA O TOTAL PELO PERCENTUAL
                                if ($item->percentual_medico == "t") {
                                    $simbolopercebtual = " %";

                                    $valorpercentualmedico = $item->valor_medico/* - ((float) $item->valor_medico * ((float) $item->taxa_administracao / 100)) */;

                                    $perc = $valor_total * ($valorpercentualmedico / 100);
                                    if ($item->valor_promotor != null) {
//                                        echo '<pre>';
                                        $perc = $perc - $percpromotor;
                                    }
                                } else {
                                    // SE FOR VALOR, É O VALOR * A QUANTIDADE
                                    $simbolopercebtual = "";
                                    $valorpercentualmedico = $item->valor_medico/* - ((float) $item->valor_medico * ((float) $item->taxa_administracao / 100)) */;

//                                    $perc = $valorpercentualmedico;

                                    $perc = $valorpercentualmedico * $item->quantidade;
                                    if ($item->valor_promotor != null) {
//                                        echo '<pre>';
                                        $perc = $perc - $percpromotor;
                                    }
                                }
//                                var_dump($item->valor_promotor);
//                                var_dump($perc);
//                                var_dump($percpromotor);
//                                die;

                                $totalperc = $totalperc + $perc;
                                if ($item->forma_pagamento1 != 1000 && $item->forma_pagamento2 != 1000 && $item->forma_pagamento3 != 1000 && $item->forma_pagamento4 != 1000) {
                                    $totalgeral = $totalgeral + $valor_total;
                                }

                                $totalpercpromotor = $totalpercpromotor + $percpromotor;
                                $totalgeralpromotor = $totalgeralpromotor + $valor_total;
                            } else {
                                // SENÃO, VAI CONTINUAR DA FORMA QUE ERA ANTES
                                if ($item->percentual_medico == "t") {
                                    $simbolopercebtual = " %";

                                    $valorpercentualmedico = $item->valor_medico/* - ((float) $item->valor_medico * ((float) $item->taxa_administracao / 100)) */;

                                    $perc = $valor_total * ($valorpercentualmedico / 100);
                                } else {
                                    $simbolopercebtual = "";
                                    $valorpercentualmedico = $item->valor_medico/* - ((float) $item->valor_medico * ((float) $item->taxa_administracao / 100)) */;

//                                    $perc = $valorpercentualmedico;
                                    $perc = $valorpercentualmedico * $item->quantidade;
                                }

                                $totalperc = $totalperc + $perc;
                                if ($item->forma_pagamento1 != 1000 && $item->forma_pagamento2 != 1000 && $item->forma_pagamento3 != 1000 && $item->forma_pagamento4 != 1000) {
                                    $totalgeral = $totalgeral + $valor_total;
                                }

                                if ($item->percentual_promotor == "t") {
                                    $simbolopercebtualpromotor = " %";

                                    $valorpercentualpromotor = $item->valor_promotor/* - ((float) $item->valor_promotor * ((float) $item->taxa_administracao / 100)) */;

                                    $percpromotor = $valor_total * ($valorpercentualpromotor / 100);
                                } else {
                                    $simbolopercebtualpromotor = "";
                                    $valorpercentualpromotor = $item->valor_promotor/* - ((float) $item->valor_promotor * ((float) $item->taxa_administracao / 100)) */;

//                                    $percpromotor = $valorpercentualpromotor;
                                    $percpromotor = $valorpercentualpromotor * $item->quantidade;
                                }

                                $totalpercpromotor = $totalpercpromotor + $percpromotor;
                                $totalgeralpromotor = $totalgeralpromotor + $valor_total;
                            }

                            @$tempoRecebimento[str_replace("-", "", $item->data_producao)][$item->medico_parecer1] = array(
                                "medico_nome" => @$item->medico,
                                "valor_recebimento" => @$tempoRecebimento[str_replace("-", "", $item->data_producao)][@$item->medico_parecer1]["valor_recebimento"] + $perc,
                                "data_recebimento" => $item->data_producao
                            );
                            ?>

                            <td style='text-align: right;'><font size="-2"><?= number_format($valorpercentualmedico, 2, ",", "") . $simbolopercebtual ?></td>

                            <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>

                            <? if ($_POST['promotor'] == 'SIM') { ?>
                                <td style='text-align: right;'><font size="-2"><?= number_format($valorpercentualpromotor, 2, ",", "") . $simbolopercebtual ?></td>

                                <td style='text-align: right;'><font size="-2"><?= number_format($percpromotor, 2, ",", "."); ?></td>
                                <td style='text-align: left;'><font size="-2"><?= $item->indicacao ?></td>

                            <? }
                            ?>
                            <? if ($_POST['laboratorio'] == 'SIM') { ?>
                                <td style='text-align: right;'><font size="-2"><?= number_format($valorpercentuallaboratorio, 2, ",", "") . $simbolopercebtualpromotor ?></td>

                                <td style='text-align: right;'><font size="-2"><?= number_format($perclaboratorio, 2, ",", "."); ?></td>
                                <td style='text-align: left;'><font size="-2"><?= $item->laboratorio ?></td>

                            <? }
                            ?>


                            <? if ($mostrar_taxa == 'SIM') { ?>
                                <td style='text-align: right;' width="50"><font size="-2"><?= number_format($item->taxa_administracao, 2, ",", "."); ?> (%)</td>
                                <? $taxaAdministracao += ((float) $perc * ((float) $item->taxa_administracao / 100)); ?>
                            <? } ?>

                            <td><font size="-2"><?= $item->revisor; ?></td>

                            <? if ($solicitante == 'SIM') { ?>
                                <td style='text-align: right;'><font size="-2"><?= $item->medicosolicitante; ?></td>
                            <? } ?>
                        </tr>


                        <?php
                        $qtdetotal = $qtdetotal + $item->quantidade;
                    endforeach;
                    if ($_POST['promotor'] == 'SIM') {
//                        if (@$empresa_permissao[0]->promotor_medico == 't') {
                        $resultadototalgeral = $totalgeral - $totalperc - $totalpercpromotor;
//                            $totalperc = $totalperc - $totalpercpromotor;
//                        } else {
//                        $resultadototalgeral = $totalgeral - $totalperc - $totalpercpromotor;
//                        }
                    } else {
                        $resultadototalgeral = $totalgeral - $totalperc - $totalperclaboratorio;
                    }
                    ?>
                    <tr>
                        <td ><font size="-1">TOTAL</td>
                        <td  colspan="2" style='text-align: right;'><font size="-1">Nr. Procedimentos: <?= $qtdetotal; ?></td>
                        <? if ($clinica == 'SIM') { ?>
                            <td colspan="3" style='text-align: right;'><font size="-1">TOTAL CLINICA: <?= number_format($resultadototalgeral, 2, ",", "."); ?></td>
                        <? } else { ?>
                            <td colspan="3" style='text-align: right;'><font size="-1">&nbsp;</td>
                        <? } ?>
                        <!--                            As váriaveis estão invertidas-->
                        <? if ($_POST['forma_pagamento'] == 'SIM') { ?>
                            <td colspan="2" style='text-align: right;'><font size="-1">T. CARTÃO: <?= number_format($vlrTotalDinheiro, 2, ",", "."); ?></td>
                            <td colspan="3" style='text-align: right;'><font size="-1">T. DINHEIRO: <?= number_format($vlrTotalCartao, 2, ",", "."); ?></td>
                        <? } ?>
                        <? if ($_POST['promotor'] == 'SIM') { ?>
                            <td colspan="2" style='text-align: right;'><font size="-1">TOTAL PROMOTOR: <?= number_format($totalpercpromotor, 2, ",", "."); ?></td>
                            <td colspan="2" style='text-align: right;'
                                title="Diferença entre o valor do médico e o valor do promotor."><font size="-1">DIFERENÇA: <?= number_format($totalperc - $totalpercpromotor, 2, ",", "."); ?></td>
                            <? }
                            ?>
                            <? if ($_POST['laboratorio'] == 'SIM') { ?>
                            <td colspan="2" style='text-align: right;'><font size="-1">TOTAL LABORATÓRIO: <?= number_format($totalperclaboratorio, 2, ",", "."); ?></td>
                        <? }
                        ?>
                        <td colspan="4" style='text-align: right;'><font size="-1">TOTAL MEDICO: <?= number_format($totalperc, 2, ",", "."); ?></td>
                    </tr>
                </tbody>
            </table>
        <? endif; ?>

        <? if (count($relatoriohomecare) > 0): ?>
            <hr>
            <table border="1">
                <thead>
                    <tr>
                        <td colspan="50"><center>PRODUÇÃO HOME CARE</center></td>
                </tr>
                <tr>


                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Medico</th>
                    <th class="tabela_header"><font size="-1">Data</th>
                    <th class="tabela_header"><font size="-1">Qtde</th>
                    <th class="tabela_header" width="220px;"><font size="-1">Procedimento</th>
                    <? if ($clinica == 'SIM') { ?>
                        <th class="tabela_header" ><font size="-1">Valor Bruto</th>
                        <th class="tabela_header" ><font size="-1">ISS</th>
                        <th class="tabela_header" ><font size="-1">Valor Liquido</th>
                    <? } ?>
                    <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor Medico</th>
                    <? if ($_POST['promotor'] == 'SIM') { ?>
                        <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor Promotor</th>
                        <th class="tabela_header" width="80px;"><font size="-1">Valor Promotor</th>   
                        <th class="tabela_header" width="80px;"><font size="-1">Promotor</th>   
                    <? }
                    ?>

                    <? if ($solicitante == 'SIM') { ?>
                        <th class="tabela_header" width="80px;"><font size="-1">Solicitante</th>
                    <? } ?>
                </tr>
                </thead>
                <tbody>
                    <?php
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
                    $totalperchome = 0;
                    $totalgeralhome = 0;
                    $perchome = 0;
                    $totalgeral = 0;
                    $totalconsulta = 0;
                    $totalretorno = 0;
                    $percpromotorhome = 0;
                    $totalpercpromotor = 0;
                    $totalgeralpromotor = 0;

                    foreach ($relatoriohomecare as $item) :
                        $i++;
                        $procedimentopercentual = $item->procedimento_convenio_id;
//            $medicopercentual = $item->medico_parecer1;
                        $medicopercentual = $item->operador_id;
                        if ($item->classificacao == 1) {
                            $totalconsulta++;
                        }
                        if ($item->classificacao == 2) {
                            $totalretorno++;
                        }
                        ?>
                        <tr>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><font size="-2"><?= $item->paciente; ?></td>
                            <td><font size="-2"><?= $item->medico; ?></td>
                            <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td ><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= $item->procedimento; ?></td>
                            <? if ($clinica == 'SIM') { ?>
                                <td style='text-align: right;'><font size="-2"><?= number_format($valor_total, 2, ",", "."); ?></td>
                                <td style='text-align: right;' width="50"><font size="-2"><?= number_format($item->iss, 2, ",", "."); ?> (%)</td>
                                <td style='text-align: right;'><font size="-2"><?= number_format(((float) $valor_total - ((float) $valor_total * ((float) $item->iss / 100))), 2, ",", "."); ?></td>
                            <? } ?>
                            <?
                            if ($item->percentual_medico == "t") {
                                $simbolopercebtual = " %";

                                $valorpercentualmedico = $item->valor_medico;

                                $perc = $valor_total * ($valorpercentualmedico / 100);
                                $totalperchome = $totalperchome + $perc;
                                $totalgeralhome = $totalgeralhome + $valor_total;
                            } else {
                                $simbolopercebtual = "";
                                $valorpercentualmedico = $item->valor_medico;

                                $perchome = $valorpercentualmedico;
                                $totalperchome = $totalperchome + $perchome;
                                $totalgeralhome = $totalgeralhome + $valor_total;
                            }

                            if ($item->percentual_promotor == "t") {
                                $simbolopercebtualpromotorhome = " %";

                                $valorpercentualpromotorhome = $item->valor_promotor/* - ((float) $item->valor_promotorhome * ((float) $item->taxa_administracao / 100)) */;

                                $percpromotorhome = $valor_total * ($valorpercentualpromotorhome / 100);
                            } else {
                                $simbolopercebtualpromotorhome = "";
                                $valorpercentualpromotorhome = $item->valor_promotor/* - ((float) $item->valor_promotorhome * ((float) $item->taxa_administracao / 100)) */;

                                $percpromotorhome = $valorpercentualpromotorhome;
                                $percpromotorhome = $percpromotorhome * $item->quantidade;
                            }

                            $totalpercpromotor = $totalpercpromotor + $percpromotorhome;
                            $totalgeralpromotor = $totalgeralpromotor + $valor_total;
                            ?>
                            <td style='text-align: right;'><font size="-2"><?= $valorpercentualmedico . $simbolopercebtualpromotorhome ?></td>
                            <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>
                            <? if ($_POST['promotor'] == 'SIM') { ?>
                                <td style='text-align: right;'><font size="-2"><?= $valorpercentualpromotorhome . $simbolopercebtualpromotorhome ?></td>
                                <td style='text-align: right;'><font size="-2"><?= number_format($percpromotorhome, 2, ",", "."); ?></td>  
                                <td style='text-align: left;'><font size="-2"><?= $item->indicacao ?></td>
                            <? }
                            ?>



                            <? if ($solicitante == 'SIM') { ?>
                                <td style='text-align: right;'><font size="-2"><?= $item->medicosolicitante; ?></td>
                            <? } ?>
                        </tr>


                        <?php
                        $qtdetotal = $qtdetotal + $item->quantidade;
                    endforeach;
                    if ($_POST['promotor'] == 'SIM') {
                        $resultadototalgeralhome = $totalgeralhome - $totalperchome - $totalpercpromotor;
                    } else {
                        $resultadototalgeralhome = $totalgeralhome - $totalperchome;
                    }
                    ?>
                    <tr>
                        <td ><font size="-1">TOTAL</td>
                        <td style='text-align: right;'><font size="-1">Nr. Procedimentos: <?= $qtdetotal; ?></td>
                        <? if ($clinica == 'SIM') { ?>
                            <td colspan="5" style='text-align: right;'><font size="-1">TOTAL CLINICA: <?= number_format($resultadototalgeralhome, 2, ",", "."); ?></td>
                        <? } else { ?>
                            <td colspan="4" style='text-align: right;'><font size="-1">&nbsp;</td>
                        <? } ?>
                        <? if ($_POST['promotor'] == 'SIM') { ?>
                            <td colspan="3" style='text-align: right;'><font size="-1">TOTAL PROMOTOR: <?= number_format($totalpercpromotor, 2, ",", "."); ?></td>

                        <? }
                        ?>
                        <td colspan="2" style='text-align: right;'><font size="-1">TOTAL MEDICO: <?= number_format($totalperchome, 2, ",", "."); ?></td>
                    </tr>
                </tbody>
            </table>
        <? endif; ?>

        <?
        if (count(@$relatoriocirurgico) > 0):
            $totalprocedimentoscirurgicos = 0;
            ?>
            <br>
            <table border="1">
                <thead>
                    <tr>
                        <td colspan="50"><center>PRODUÇÃO CIRURGICA</center></td>
                </tr>
                <tr>
                    <th class="tabela_header"><font size="-1"><center>Convenio</center></th>
                <th class="tabela_header"><font size="-1"><center>Nome</center></th>
                <th class="tabela_header"><font size="-1"><center>Medico</center></th>
                <th class="tabela_header"><font size="-1"><center>Data</center></th>
                <th class="tabela_header"><font size="-1"><center>Procedimento</center></th>
                <th class="tabela_header"><font size="-1"><center>Valor Procedimento</center></th>
                <th class="tabela_header"><font size="-1"><center>Grau de Participação</center></th>
                <th class="tabela_header"><font size="-1"><center>Valor Médico</center></th>
                </tr>
                </thead>
                <tbody>
                    <?
                    $totalMedicoCirurgico = 0;
                    foreach ($relatoriocirurgico as $itens) :
                        $totalprocedimentoscirurgicos++;
                        $totalMedicoCirurgico += (float) $itens->valor_medico;
//                        $totalperc += $totalMedicoCirurgico;
                        ?>

                        <tr>
                            <!--<td><font size="-2"><?= $itens->guia_id; ?></td>-->
                            <td ><font size="-2"><?= $itens->convenio; ?></td>
                            <td><font size="-2"><?= $itens->paciente; ?></td>
                            <td><font size="-2"><?= $itens->medico; ?></td>
                            <td><font size="-2"><?= date("d/m/Y", strtotime($itens->data)); ?></td>
                            <td ><font size="-2"><?= $itens->procedimento; ?></td>
                            <td style='text-align: right;'><font size="-2"><?= number_format($itens->valor_total, 2, ",", "."); ?></td>
                            <td><font size="-2"><?= $itens->funcao; ?></td>
                            <td style='text-align: right;'><font size="-2"><?= number_format($itens->valor_medico, 2, ",", "."); ?></td>
                        </tr>

                        <?
                    endforeach;
                    $totalperc += $totalMedicoCirurgico;
                    ?>
                    <tr>
                        <td ><font size="-1">TOTAL</td>
                        <td style='text-align: right;'><font size="-1">Nr. Procedimentos: <?= $totalprocedimentoscirurgicos; ?></td>
                        <td colspan="4" style='text-align: right;'><font size="-1">&nbsp;</td>
                        <td colspan="2" style='text-align: right;'><font size="-1">TOTAL MEDICO: <?= number_format($totalMedicoCirurgico, 2, ",", "."); ?></td>
                    </tr>

                </tbody>
            </table>
            <?
        endif;

        if ($medico != 0) {
            ?>

            <hr>
            <? if ($medico != 0 && $recibo == 'NAO') { ?> 
                <table border="1">
                    <tr>
                        <th colspan="2" width="200px;">RESUMO</th>
                    </tr>
                    <?
                    $resultado = $totalperc;
                    if (@$totalretorno > 0 || @$totalconsulta > 0) :
                        ?>
                        <tr>
                            <td>TOTAL CONSULTAS</td>
                            <td style='text-align: right;' width="30px;"><?= $totalconsulta; ?></td>
                        </tr>

                        <tr>
                            <td>TOTAL RETORNO</td>
                            <td style='text-align: right;'><?= $totalretorno; ?></td>
                        </tr>
                        <?
                    endif;
                    if (@$totalprocedimentoscirurgicos > 0):
                        ?>
                        <tr>
                            <td>TOTAL PROC. CIRURGICOS</td>
                            <td style='text-align: right;'><?= $totalprocedimentoscirurgicos; ?></td>
                        </tr>
                    <? endif; ?>
                </table>
                <?
                if (@$totalperchome != 0) {
                    $totalperc = $totalperc + $totalperchome;
                }

                $irpf = 0;
                if ($totalperc >= $medico[0]->valor_base) {
                    $irpf = $totalperc * ($medico[0]->ir / 100);
                    ?>
                    <br>
                    <table border="1">
                        <tr>
                            <th colspan="2" width="200px;">RESUMO FISCAL</th>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td style='text-align: right;'><?= number_format(@$totalperc + @$taxaAdministracao, 2, ",", "."); ?></td>
                        </tr>

                        <tr>
                            <td>IRPF</td>
                            <td style='text-align: right;'><?= number_format($irpf, 2, ",", "."); ?></td>
                        </tr>
                        <? if ($mostrar_taxa == 'SIM') { ?>
                            <tr>
                                <td>TAXA ADMINISTRAÇÃO</td>
                                <td style='text-align: right;'><?= number_format($taxaAdministracao, 2, ",", "."); ?></td>
                            </tr>
                            <?
                        }
                        $resultado = @$totalperc - @$irpf - @$taxaAdministracao;
                    } else {
                        ?>
                        <hr>
                        <table border="1">
                            <tr>
                                <th colspan="2" width="200px;">RESUMO FISCAL</th>
                            </tr>
                            <?
                        }
                        if ($totalperc > 215) {
                            $pis = $totalperc * ($medico[0]->pis / 100);
                            $csll = $totalperc * ($medico[0]->csll / 100);
                            $cofins = $totalperc * ($medico[0]->cofins / 100);
                            $resultado = $resultado - $pis - $csll - $cofins;
                            ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--                            <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td>TAXA ADMINISTRAÇÃO</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td style='text-align: right;'><?= number_format($taxaAdministracao, 2, ",", "."); ?></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>-->
                            <tr>
                                <td>PIS</td>
                                <td style='text-align: right;'><?= number_format($pis, 2, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td>CSLL</td>
                                <td style='text-align: right;'><?= number_format($csll, 2, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td>COFINS</td>
                                <td style='text-align: right;'><?= number_format($cofins, 2, ",", "."); ?></td>
                            </tr>
                            <?
                            $iss = $totalperc * ($medico[0]->iss / 100);
                            $resultado = $resultado - $iss;
                        }
                        if (@$iss > 0) {
                            ?>
                            <tr>
                                <td>ISS</td>
                                <td style='text-align: right;'><?= number_format($iss, 2, ",", "."); ?></td>
                            </tr>
                        <? } ?>
                        <tr>
                            <td>RESULTADO</td>
                            <td style='text-align: right;'><?= number_format($resultado, 2, ",", "."); ?></td>
                        </tr>
                    </table>
                <? } ?>
                <? ?>
                <? if ($medico != 0 & $revisor == 0) {
                    ?>

                    <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fecharmedico" method="post">
                        <input type="hidden" class="texto3" name="tipo" value="<?= $medico[0]->tipo_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="nome" value="<?= $medico[0]->credor_devedor_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="conta" value="<?= $medico[0]->conta_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="classe" value="<?= $medico[0]->classe; ?>" readonly/>
                        <input type="hidden" class="texto3" name="observacao" value="<?= "Período " . substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4) . " até " . substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4) . " médico: " . $medico[0]->operador; ?>" readonly/>
                        <input type="hidden" class="texto3" name="data" value="<?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4) ?>" readonly/>
                        <input type="hidden" class="texto3" name="valor" value="<?= $resultado; ?>" readonly/>
                        <?
                        $j = 0;
                        if ($medico != 0 && $recibo == 'NAO') {
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
                            <button type="submit" name="btnEnviar">Producao medica</button>

                        <? } ?>
                    </form>
                    <?
                }
            }
            ?>
            <br>
            <? if ($medico != 0 && $recibo == 'NAO') { ?> 
                <div>
                    <div style="display: inline-block">
                        <table border="1">
                            <thead>
                                <tr>
                                    <td colspan="50"><center>PRODUÇÃO AMBULATORIAL</center></td>
                            </tr>
                            <tr>
                                <th class="tabela_header"><font size="-1">Medico</th>
                                <th class="tabela_header"><font size="-1">Qtde</th>
                                <th class="tabela_header"><font size="-1">Produ&ccedil;&atilde;o Medico</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?
                                foreach ($relatoriogeral as $itens) :
                                    ?>

                                    <tr>
                                        <td><font size="-2"><?= $itens->medico; ?></td>
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

                <? if (count($relatoriocirurgicogeral) > 0):
                    ?>
                    <div style="display: inline-block">
                        <table border="1">
                            <thead>
                                <tr>
                                    <td colspan="50"><center>PRODUÇÃO CIRURGICA</center></td>
                            </tr>
                            <tr>
                                <th class="tabela_header"><font size="-1">Medico</th>
                                <th class="tabela_header"><font size="-1">Qtde</th>
                                <th class="tabela_header"><font size="-1">Produ&ccedil;&atilde;o Medico</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?
                                foreach ($relatoriocirurgicogeral as $itens) :
                                    ?>

                                    <tr>
                                        <td><font size="-2"><?= $itens->medico; ?></td>
                                        <td ><font size="-2"><?= $itens->quantidade; ?></td>
                                        <td ><font size="-2"><?= number_format($itens->valor, 2, ",", "."); ?></td>
                                    </tr>

                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <? endif; ?>
                <? if (count($relatoriohomecaregeral) > 0):
                    ?>
                    <div style="display: inline-block">
                        <table border="1">
                            <thead>
                                <tr>
                                    <td colspan="50"><center>PRODUÇÃO HOME CARE</center></td>
                            </tr>
                            <tr>
                                <th class="tabela_header"><font size="-1">Medico</th>
                                <th class="tabela_header"><font size="-1">Qtde</th>
                                <th class="tabela_header"><font size="-1">Produ&ccedil;&atilde;o Medico</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?
                                foreach ($relatoriohomecaregeral as $itens) :
                                    ?>

                                    <tr>
                                        <td><font size="-2"><?= $itens->medico; ?></td>
                                        <td ><font size="-2"><?= $itens->quantidade; ?></td>
                                        <td ><font size="-2"><?= number_format($itens->valor, 2, ",", "."); ?></td>
                                    </tr>

                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <? endif; ?>
            </div>

            <hr>
            <? if ($tabela_recebimento == "SIM") { ?>
                <table border="1">
                    <tr>
                        <td colspan="3" align="center">PREVISÃO DE RECEBIMENTO</td>
                    </tr>
                    <tr>
                        <td>Médico</td>
                        <td>Valor</td>
                        <td>Data Prevista</td>
                    </tr>
                    <pre>
                        <?
                        foreach ($tempoRecebimento as $value) {
                            foreach ($value as $item) {
                                $vlr = $item['valor_recebimento'];

                                if ($vlr == 0) {
                                    continue;
                                }

                                $dt_recebimento = date("d/m/Y", strtotime($item['data_recebimento']));
                                ?>
                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                <td><?= $item['medico_nome'] ?></td>
                                                                                                                                                                                                                                                                <td><?= number_format($vlr, 2, ",", "."); ?></td>
                                                                                                                                                                                                                                                                <td><?= $dt_recebimento ?></td>
                                                                                                                                                                                                                                                            </tr> 
                                <?
                            }
                        }
                        ?>
                                                                                                                                </table>
                                                                                                                                <hr>
            <? } ?>
                                                                    <style>
                /*.pagebreak { page-break-before: always; }*/
                                                                    </style>
            <? if ($medico != 0 && $recibo == 'SIM') { ?>
                                                                                                                                <div>

                                                                                                                                    <!--                    <div>
                                                                                                                                                            <p><center><img align = 'center'  width='400px' height='200px' src="<?= base_url() . "img/cabecalho.jpg" ?>"></center></p>
                                                                                                                                                        </div>-->
                                                                                                                                    <div>
                                                                                                                                        <p style="text-align: center;font-size: 14pt"> <strong>RECIBO</strong></p>
                        <?
                        $valor = number_format($totalperc, 2, ",", ".");
                        $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
                        $extenso = GExtenso::moeda($valoreditado);
                        ?>
                                                                                                                                        <p style="text-align: center;">EU   <u><b><?= $medico[0]->operador ?></b></u>, RECEBI DA CLÍNICA,</p>
                                                                                                                                        <p style="text-align: center;">  A QUANTIA DE R$ <?= number_format($totalperc, 2, ",", "."); ?> (<?= strtoupper($extenso) ?>)

                                                                                                                                        <p style="text-align: center;">REFERENTE AOS ATENDIMENTOS 
                                                                                                                                            CLÍNICOS DO PERÍODO DE <?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4); ?> a <?= substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4); ?> </p>
                                                                                                                                        <!--<p><?= $empresamunicipio[0]->municipio ?> </p>-->
                                                                                                                                        <p style="text-align: center"><?= $empresamunicipio[0]->municipio ?>,
                            <?= date("d") . " de " . $MES . " de " . date("Y"); ?> -

                            <?= date("H:i") ?>
                                                                                                                                        </p>
                                                                                                                                    <!--<p><center><font size = 4><b>DECLARA&Ccedil;&Atilde;O</b></font></center></p>-->
                                                                                                                                        <br>


                                                                                                                                        <h4><center>______________________________________________________________</center></h4>
                                                                                                                                        <h4><center>Assinatura do Profissional</center></h4>
                                                                                                                                        <h4><center>Carimbo</center></h4>
                                                                                                                                        <br>
                                                                                                                                        <br>
                                                                                                                                        <p style="text-align: center"><b>AVISO:</b> CARO PROFISSIONAL, INFORMAMOS QUE QUSQUER RECLAMAÇÃO DAREMOS UM 
                                                                                                                                            PRAZO DE 05(CINCO DIAS) A CONTAR DA DATA DE RECEBIMENTO PARA REINVIDICAR SEUS 
                                                                                                                                            DIREITOS. A CLINICA NÃO RECEBERÁ CONTESTAÇÃO SOB HIPÓTESE ALGUMA FORA DO PRAZO DETERMINADO ACIMA
                                                                                                                                        </p>
                                                                                                                                    </div>
                                                                                                                                </div>
            <? } ?>
            <?
        } else {
            ?>
                                                                    <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>

</div> <!-- Final da DIV content -->
