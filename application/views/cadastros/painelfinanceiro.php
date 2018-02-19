<?
$valor_medico_total = 0;
$valor_laboratorio_total = 0;
$valor_promotor_total = 0;

$valormes_medico_total = 0;
$valormes_laboratorio_total = 0;
$valormes_promotor_total = 0;

$valor_recebimento = 0;
$valormes_recebimento = 0;

//foreach ($relatoriomedico as $item) {
//
//    if ($item->perc_medico_excecao != "") {
//        $valor = ($item->percentual_excecao == 't') ? $item->valor_total * ($item->perc_medico_excecao / 100) : $item->perc_medico_excecao;
//    } else {
//        $valor = ($item->percentual == 't') ? $item->valor_total * ($item->perc_medico / 100) : $item->perc_medico;
//    }
//    $valor_medico_total = $valor_medico_total + $valor;
//}
//
//foreach ($relatoriopromotor as $item) {
//
//    if ($item->percentual_promotor == 't') {
//        $valor = $item->valor_total * ($item->valor_promotor / 100);
//    } else {
//        $valor = $item->valor_promotor;
//    }
//    $valor_promotor_total = $valor_promotor_total + $valor;
//}
//
//
//foreach ($relatoriolaboratorio as $item) {
//    if ($item->percentual_laboratorio == 't') {
//        $valor = $item->valor_total * ($item->valor_laboratorio / 100);
//    } else {
//        $valor = $item->valor_laboratorio;
//    }
//    $valor_laboratorio_total = $valor_laboratorio_total + $valor;
//}
//
//foreach ($relatorioconvenio as $item) {
//
//    if ($item->valor_total != '') {
//        $valor = $item->valor_total;
//    } else {
//        $valor = $item->valor_procedimento;
//    }
//
//    $valor_recebimento = $valor_recebimento + $valor;
//
//}
//
//
//foreach ($relatoriomesmedico as $item) {
//
//    if ($item->perc_medico_excecao != "") {
//        $valor = ($item->percentual_excecao == 't') ? $item->valor_total * ($item->perc_medico_excecao / 100) : $item->perc_medico_excecao;
//    } else {
//        $valor = ($item->percentual == 't') ? $item->valor_total * ($item->perc_medico / 100) : $item->perc_medico;
//    }
//    $valormes_medico_total = $valormes_medico_total + $valor;
//}
//
//foreach ($relatoriomespromotor as $item) {
//
//    if ($item->percentual_promotor == 't') {
//        $valor = $item->valor_total * ($item->valor_promotor / 100);
//    } else {
//        $valor = $item->valor_promotor;
//    }
//    $valormes_promotor_total = $valormes_promotor_total + $valor;
//}
//
//
//foreach ($relatoriomeslaboratorio as $item) {
//    if ($item->percentual_laboratorio == 't') {
//        $valor = $item->valor_total * ($item->valor_laboratorio / 100);
//    } else {
//        $valor = $item->valor_laboratorio;
//    }
//    $valormes_laboratorio_total = $valormes_laboratorio_total + $valor;
//}
//
//
//foreach ($relatoriomesconvenio as $item) {
//
//    if ($item->valor_total != '') {
//        $valor = $item->valor_total;
//    } else {
//        $valor = $item->valor_procedimento;
//    }
//
//    $valormes_recebimento = $valormes_recebimento + $valor;
//
//}

$valor_total_pagamento = $valor_medico_total + $valor_laboratorio_total + $valor_promotor_total;
$valormes_total_pagamento = $valormes_medico_total + $valormes_laboratorio_total + $valormes_promotor_total;
//var_dump($valor_recebimento);
//die;
?>

<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Painel Financeiro</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>cadastros/caixa/painelfinanceiro">
                <table border="1">
                    <thead>
                        <tr>
                            <th class="tabela_title">Data Inicio</th>
                            <th class="tabela_title">Data Fim</th>
                        </tr>
                        <tr>


                            <th class="tabela_title">
                                <? if (isset($_GET['txtdata_inicio'])) { ?>
                                    <input type="text"  id="txtdata_inicio" alt="date" name="txtdata_inicio" class="size1"  value="<?php echo @$_GET['txtdata_inicio']; ?>" />
                                <? } else { ?>
                                    <input type="text"  id="txtdata_inicio" alt="date" name="txtdata_inicio" class="size1"  value="<?php echo @date('01/m/Y'); ?>" /> 
                        <!--<input type="text"  id="datainicio" alt="date" name="datainicio" class="size1"  value="<?php echo @$_GET['datainicio']; ?>" />-->

                                <? } ?>
                            </th>
                            <th class="tabela_title">
                                <? if (isset($_GET['txtdata_fim'])) { ?>
                                    <input type="text"  id="txtdata_fim" alt="date" name="txtdata_fim" class="size1"  value="<?php echo @$_GET['txtdata_fim']; ?>" />
                                <? } else { ?>
                                    <input type="text"  id="txtdata_fim" alt="date" name="txtdata_fim" class="size1"  value="<?php echo @date('t/m/Y'); ?>" /> 
                        <!--<input type="text"  id="datafim" alt="date" name="datafim" class="size1"  value="<?php echo @$_GET['datafim']; ?>" />-->

                                <? } ?>
                            </th>
                            <th>
                                <button type="submit" id="enviar">Pesquisar</button>  
                            </th>

                        </tr>

                    </thead>




                </table>
            </form>
            <table>
              <tr>
               <td style="width: 33%;">
                 <table>
                     <tr>

                       <th class="tabela_header" ><center>Entradas/Saidas Período</center></th>
                     </tr>
                     <tr>
                         <td><div id="contas" style="height: 250px;"></div></td>
                     </tr>
                     <tr>
                         <!--<td><div id="contas" style="height: 250px;"></div></td>-->
                         <td >Entradas :<span style="color:#2cc990; "> VERDE</span></td>
                     </tr>
                     <tr>
                         <!--<td><div id="contas" style="height: 250px;"></div></td>-->
                         <td >Saidas :<span style="color:#e3000e; "> VERMELHO</span></td>
                     </tr>
                     <tr>
                         <!--<td><div id="contas" style="height: 250px;"></div></td>-->
                         <td >Contas a Receber :<span style="color:#2c82c9; "> AZUL</span></td>
                     </tr>
                     <tr>
                         <!--<td><div id="contas" style="height: 250px;"></div></td>-->
                         <td >Contas a Pagar :<span style="color:#a8a237; "> AMARELO</span></td>
                     </tr>
                 </table>   
               </td>
               
               <td style="width: 33%;<?if(date("m") == date("m", strtotime(str_replace('/', '-', @$_GET['txtdata_inicio'])))){echo 'display:none'; }?>">
                <table>
                    <tr>
                           <!--<th class="tabela_header">Nome</th>-->
                           <!--<th class="tabela_header">Tipo</th>-->
                        <th class="tabela_header" ><center>Entradas/Saidas (Mês: <?= date("m", strtotime(str_replace('/', '-', @$_GET['txtdata_inicio']))); ?>)</center></th>
                    </tr>
                    <tr>
                        <td><div id="contames" style="height: 250px;"></div></td>
                    </tr>

                </table>    
               </td>
               
            <td style="width: 33%">
                <table>
                    <tr>
                           <!--<th class="tabela_header">Nome</th>-->
                           <!--<th class="tabela_header">Tipo</th>-->
                        <th class="tabela_header" ><center>Entradas/Saidas (Mês Atual)</center></th>
                    </tr>
                    <tr>
                        <td><div id="contamesatual" style="height: 250px;"></div></td>
                    </tr>

                </table>    
            </td>
            </tr>
            </table>








        </div>
        <!--<div>-->

        <!--</div>-->


    </div>
    <?
    if ($saida[0]->valor_total > 0) {
        $saida_valor = $saida[0]->valor_total;
        $saida_formatado = number_format($saida[0]->valor_total, 2, ",", ".");
    } else {
        $saida_valor = 0;
        $saida_formatado = 0;
    }

    if ($entrada[0]->valor_total > 0) {
        $entrada_valor = $entrada[0]->valor_total;
        $entrada_formatado = number_format($entrada[0]->valor_total, 2, ",", ".");
    } else {
        $entrada_valor = 0;
        $entrada_formatado = 0;
    }

    if ($contaspagar[0]->valor_total > 0) {
        $contaspagar_valor = $contaspagar[0]->valor_total;
        $contaspagar_formatado = number_format($contaspagar[0]->valor_total, 2, ",", ".");
    } else {
        $contaspagar_valor = 0;
        $contaspagar_formatado = 0;
    }

    if ($contasreceber[0]->valor_total > 0) {
        $contasreceber_valor = $contasreceber[0]->valor_total;
        $contasreceber_formatado = number_format($contasreceber[0]->valor_total, 2, ",", ".");
    } else {
        $contasreceber_valor = 0;
        $contasreceber_formatado = 0;
    }

    // VALORES POR MES ESCOLHIDO NA DATA

    if ($saidames[0]->valor_total > 0) {
        $saidames_valor = $saidames[0]->valor_total;
        $saidames_formatado = number_format($saidames[0]->valor_total, 2, ",", ".");
    } else {
        $saidames_valor = 0;
        $saidames_formatado = 0;
    }

    if ($entradames[0]->valor_total > 0) {
        $entradames_valor = $entradames[0]->valor_total;
        $entradames_formatado = number_format($entradames[0]->valor_total, 2, ",", ".");
    } else {
        $entradames_valor = 0;
        $entradames_formatado = 0;
    }

    if ($contaspagarmes[0]->valor_total > 0) {
        $contaspagarmes_valor = $contaspagarmes[0]->valor_total;
        $contaspagarmes_formatado = number_format($contaspagarmes[0]->valor_total, 2, ",", ".");
    } else {
        $contaspagarmes_valor = 0;
        $contaspagarmes_formatado = 0;
    }

    if ($contasrecebermes[0]->valor_total > 0) {
        $contasrecebermes_valor = $contasrecebermes[0]->valor_total;
        $contasrecebermes_formatado = number_format($contasrecebermes[0]->valor_total, 2, ",", ".");
    } else {
        $contasrecebermes_valor = 0;
        $contasrecebermes_formatado = 0;
    }

    // VALORES DO MES ATUAL


    if ($saidamesatual[0]->valor_total > 0) {
        $saidamesatual_valor = $saidamesatual[0]->valor_total;
        $saidamesatual_formatado = number_format($saidamesatual[0]->valor_total, 2, ",", ".");
    } else {
        $saidamesatual_valor = 0;
        $saidamesatual_formatado = 0;
    }

    if ($entradamesatual[0]->valor_total > 0) {
        $entradamesatual_valor = $entradamesatual[0]->valor_total;
        $entradamesatual_formatado = number_format($entradamesatual[0]->valor_total, 2, ",", ".");
    } else {
        $entradamesatual_valor = 0;
        $entradamesatual_formatado = 0;
    }

    if ($contaspagarmesatual[0]->valor_total > 0) {
        $contaspagarmesatual_valor = $contaspagarmesatual[0]->valor_total;
        $contaspagarmesatual_formatado = number_format($contaspagarmesatual[0]->valor_total, 2, ",", ".");
    } else {
        $contaspagarmesatual_valor = 0;
        $contaspagarmesatual_formatado = 0;
    }

    if ($contasrecebermesatual[0]->valor_total > 0) {
        $contasrecebermesatual_valor = $contasrecebermesatual[0]->valor_total;
        $contasrecebermesatual_formatado = number_format($contasrecebermesatual[0]->valor_total, 2, ",", ".");
    } else {
        $contasrecebermesatual_valor = 0;
        $contasrecebermesatual_formatado = 0;
    }
    ?>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>js/morris/morris.css">
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/morris/Gruntfile.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/morris/morris.js" ></script>
<script src="<?= base_url() ?>js/morris/raphael.js"></script>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $("#txtdata_inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    $(function () {
        $("#txtdata_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


    new Morris.Donut({
        element: 'contas',
        data: [
            {label: "Saidas", value: <?= $saida_valor; ?>, formatted: 'R$: <?= $saida_formatado; ?>'},
            {label: "Contas a Pagar", value: <?= $contaspagar_valor; ?>, formatted: 'R$: <?= $contaspagar_formatado; ?>'},
            {label: "Contas a Receber", value: <?= $contasreceber_valor; ?>, formatted: 'R$: <?= $contasreceber_formatado; ?>'},
            {label: "Entradas", value: <?= $entrada_valor; ?>, formatted: 'R$: <?= $entrada_formatado; ?>'}


        ],
        colors: [
            '#E3000E',
            '#EEE657',

            '#2C82C9',
            '#2CC990'
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
    });

    new Morris.Donut({
        element: 'contames',
        data: [
            {label: "Saidas", value: <?= $saidames_valor; ?>, formatted: 'R$: <?= $saidames_formatado; ?>'},
            {label: "Contas a Pagar", value: <?= $contaspagarmes_valor; ?>, formatted: 'R$: <?= $contaspagarmes_formatado; ?>'},
            {label: "Contas a Receber", value: <?= $contasrecebermes_valor; ?>, formatted: 'R$: <?= $contasrecebermes_formatado; ?>'},
            {label: "Entradas", value: <?= $entradames_valor; ?>, formatted: 'R$: <?= $entradames_formatado; ?>'}


        ],
        colors: [
            '#E3000E',
            '#EEE657',
            '#2C82C9',
            '#2CC990'
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
    });

    new Morris.Donut({
        element: 'contamesatual',
        data: [
            {label: "Saidas", value: <?= $saidamesatual_valor; ?>, formatted: 'R$: <?= $saidamesatual_formatado; ?>'},
            {label: "Contas a Pagar", value: <?= $contaspagarmesatual_valor; ?>, formatted: 'R$: <?= $contaspagarmesatual_formatado; ?>'},
            {label: "Contas a Receber", value: <?= $contasrecebermesatual_valor; ?>, formatted: 'R$: <?= $contasrecebermesatual_formatado; ?>'},
            {label: "Entradas", value: <?= $entradamesatual_valor; ?>, formatted: 'R$: <?= $entradamesatual_formatado; ?>'}


        ],
        colors: [
            '#E3000E',
            '#EEE657',
            '#2C82C9',
            '#2CC990'
        ],
        formatter: function (x, data) {
            return data.formatted;
        }
    });

//    new Morris.Donut({
//        element: 'recebimento',
//        data: [
//            {label: "Pagamento", value: <?= $valor_total_pagamento; ?>, formatted: 'R$: <?= number_format($valor_total_pagamento, 2, ",", "."); ?>'},
//            {label: "Recebimento", value: <?= $valor_recebimento; ?>, formatted: 'R$: <?= number_format($valor_recebimento, 2, ",", "."); ?>'}
//
//
//
//        ],
//        colors: [
//            '#E3000E',
//            '#2CC990'
//        ],
//        formatter: function (x, data) {
//            return data.formatted;
//        }
//    });
//    new Morris.Donut({
//        element: 'recebimentomes',
//        data: [
//            {label: "Pagamento", value: <?= $valormes_total_pagamento; ?>, formatted: 'R$: <?= number_format($valormes_total_pagamento, 2, ",", "."); ?>'},
//            {label: "Recebimento", value: <?= $valormes_recebimento; ?>, formatted: 'R$: <?= number_format($valormes_recebimento, 2, ",", "."); ?>'}
//
//
//
//        ],
//        colors: [
//            '#E3000E',
//            '#2CC990'
//        ],
//        formatter: function (x, data) {
//            return data.formatted;
//        }
//    });
//


</script>

