<head>
    <title>STG - SISTEMA DE GESTAO DE CLINICAS v1.0</title>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->
    <link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>css/batepapo.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>js/fullcalendar/fullcalendar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>js/fullcalendar/lib/cupertino/jquery-ui.min.css" rel="stylesheet" />

        <!--<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />-->
        <!--<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />-->
        <!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>-->
    <script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/jquery-ui.min.js"></script>
    <!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>-->



<!--<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />-->
    <!--Scripts necessários para o calendário-->

    <script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/moment.min.js"></script>
    <script src="<?= base_url() ?>js/fullcalendar/locale/pt-br.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url() ?>js/fullcalendar/fullcalendar.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url() ?>js/fullcalendar/scheduler.js" type="text/javascript" charset="utf-8"></script>
</head>
<!--<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >-->



<div class="content">
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteconsultaencaixe');">
            Encaixar Consulta
        </a>
    </div>

    <style>

        body {
            /*margin: 40px 10px;*/
            padding: 0;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
            background-color: white;
        }
        .content{
            margin-left: 0px;
        }

        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
        .vermelho{
            color: red;
        }
        /*#pop{display:none;position:absolute;top:50%;left:50%;margin-left:-150px;margin-top:-100px;padding:10px;width:300px;height:200px;border:1px solid #d0d0d0}*/

    </style>




    <div id="accordion">
        <h3 class="singular">Multifuncao Consulta Recep&ccedil;&atilde;o</h3>
        <div>
            <?
            $medicos = $this->operador_m->listarmedicos();
            $salas = $this->exame->listartodassalas();
            $especialidade = $this->exame->listarespecialidade();
            $empresas = $this->exame->listarempresas();
            $empresa_logada = $this->session->userdata('empresa_id');
            ?>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsultacalendario">

                    <tr>
                        <th class="tabela_title">Empresa</th>
                        <th class="tabela_title">Especialidade</th>
                        <th class="tabela_title">Medico</th>
                        <th class="tabela_title">Nome</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <select name="empresa" id="empresa" class="size2">
                                <option value=""></option>
                                <?
                                $selected = false;
                                foreach ($empresas as $value) :
                                    ?>
                                    <option value="<?= $value->empresa_id; ?>" <?
                                    if ((isset($_GET['empresa']) || @$_GET['empresa'] != '') && @$_GET['empresa'] == $value->empresa_id) {
                                        echo 'selected';
                                        $selected = true;
                                    } else {
                                        if ($empresa_logada == $value->empresa_id && $selected == false) {
                                            echo 'selected';
                                            $selected = true;
                                        }
                                    }
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>

                        </th>
                        <th class="tabela_title">
                            <select name="especialidade" id="especialidade" class="size2">
                                <option value=""></option>
                                <option value="">TODOS</option>
                                <? foreach ($especialidade as $value) : ?>
                                    <option value="<?= $value->cbo_ocupacao_id; ?>" <?
                                    if (@$_GET['especialidade'] == $value->cbo_ocupacao_id):echo 'selected';
                                    endif;
                                    ?>>
                                                <?
//                                                if (@$_GET['especialidade'] == $value->cbo_ocupacao_id):
//                                                    echo '<script>carregaMedicoEspecialidade();</script>';
//                                                endif;
                                                ?>
                                                <?php echo $value->descricao; ?>
                                    </option>
                                <? endforeach; ?>
                            </select>
                        </th>


                        <th class="tabela_title">
                            <select name="medico" id="medico" class="size2">
                                <option value=""> </option>
                                <? foreach ($medicos as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>"<?
                                    if (@$_GET['medico'] == $value->operador_id):echo 'selected';
                                    endif;
                                    ?>>

                                        <?php echo $value->nome . ' - CRM: ' . $value->conselho; ?>


                                    </option>
                                <? endforeach; ?>

                            </select>
                        </th>
                        <th colspan="2" class="tabela_title">
                            <input type="text" name="nome" class="texto04 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </th>


                        <th colspan="3" class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>

                    </tr>
                </form>
                </thead>
            </table> 
            <table>
                <tr>
                    <td colspan="2">

                    </td>
                </tr>
                <tr>
                    <td rowspan="2">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <!--                                Calendário-->
                            </div>
                            <div class="row" style="width: 400px;">
                                <div class="col-lg-12">



                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <div id='calendar'></div>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                        </div>  
                    </td>
                    <td>
                        <div style="width: 10px;">

                        </div>
                    </td>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <th class="tabela_header" >Status</th>
                                    <th class="tabela_header" width="250px;">Nome</th>
                                    <!--<th class="tabela_header" width="70px;">Resp.</th>-->
                                    <th class="tabela_header" width="70px;">Data</th>
                                    <!--<th class="tabela_header" width="50px;">Dia</th>-->
                                    <th class="tabela_header" width="70px;">Agenda</th>
                                    <th class="tabela_header" width="70px;">    </th>
                                    <th class="tabela_header" width="150px;">Sala</th>
                                    <th class="tabela_header" width="150px;">Convenio</th>
                                    <th class="tabela_header">Telefone</th>
                                    <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                                    <th class="tabela_header" colspan="3"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarexamemultifuncaoconsulta($_GET);
                $total = $consulta->count_all_results();
                $limit = 50;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                $l = $this->exame->listarestatisticapacienteconsulta($_GET);
                $p = $this->exame->listarestatisticasempacienteconsulta($_GET);

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->exame->listarexamemultifuncaoconsulta2($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        $paciente = "";
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_atualizacao;

                            if ($item->celular != "") {
                                $telefone = $item->celular;
                            } elseif ($item->telefone != "") {
                                $telefone = $item->telefone;
                            } else {
                                $telefone = "";
                            }

                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%H:%I:%S');
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

                            $faltou = false;
                            if ($item->paciente == "" && $item->bloqueado == 't') {
                                $situacao = "Bloqueado";
                                $paciente = "Bloqueado";
                                $verifica = 7;
                            } else {
                                $paciente = "";

                                if ($item->realizada == 't' && $item->situacaoexame == 'EXECUTANDO') {
                                    $situacao = "Aguardando";
                                    $verifica = 2;
                                } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                                    $situacao = "Finalizado";
                                    $verifica = 4;
                                } elseif ($item->realizada == 't' && $item->situacaoexame == 'FINALIZADO') {
                                    $situacao = "Atendendo";
                                    $verifica = 5;
                                } elseif ($item->confirmado == 'f' && $item->operador_atualizacao == null) {
                                    $situacao = "agenda";
                                    $verifica = 1;
                                } elseif ($item->confirmado == 'f' && $item->operador_atualizacao != null) {
                                    $verifica = 6;
                                    $verifica = 6;
                                    date_default_timezone_set('America/Fortaleza');
                                    $data_atual = date('Y-m-d');
                                    $hora_atual = date('H:i:s');
                                    if ($item->data < $data_atual) {
                                        $situacao = "<font color='gray'>faltou";
                                        $faltou = true;
                                    } else {
                                        $situacao = "agendado";
                                    }
                                } else {
                                    $situacao = "espera";
                                    $verifica = 3;
                                }
                            }
                            if ($item->paciente == "" && $item->bloqueado == 'f') {
                                $paciente = "vago";
                            }
                            $data = $item->data;
                            $dia = strftime("%A", strtotime($data));

                            switch ($dia) {
                                case"Sunday": $dia = "Domingo";
                                    break;
                                case"Monday": $dia = "Segunda";
                                    break;
                                case"Tuesday": $dia = "Terça";
                                    break;
                                case"Wednesday": $dia = "Quarta";
                                    break;
                                case"Thursday": $dia = "Quinta";
                                    break;
                                case"Friday": $dia = "Sexta";
                                    break;
                                case"Saturday": $dia = "Sabado";
                                    break;
                            }
                            ?>
                            <tr>
                                <? if ($verifica == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                <? }if ($verifica == 2) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $item->paciente; ?></b></td>
                                <? }if ($verifica == 3) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->paciente; ?></b></td>
                                <? }if ($verifica == 4) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->paciente; ?></b></td>
                                <? } if ($verifica == 5) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><?= $item->paciente; ?></b></td>
                                <? } if ($verifica == 6) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                <? } if ($verifica == 7) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                                    <td class="<?php echo $estilo_linha; ?>"></td>
                                <? } ?>
                                <!--<td class="<?php echo $estilo_linha; ?>"><?= substr($item->secretaria, 0, 9); ?></td>-->
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <!--<td class="<?php echo $estilo_linha; ?>"><?= substr($dia, 0, 3); ?></td>-->
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>

                                <td class="<?php echo $estilo_linha; ?>"><?
                                    if ($item->encaixe == 't') {
                                        if ($item->paciente == '') {
                                            echo '<span class="vermelho">Encaixe H.</span>';
                                        } else {
                                            echo '<span class="vermelho">Encaixe</span>';
                                        }
                                    }
                                    ?>
                                </td>

                                <? if ($situacao == 'espera' || $situacao == 'agendado' || $situacao == "<font color='gray'>faltou") { ?>
                                <td style="cursor: pointer; color:red;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $item->sala . " - " . substr($item->medicoagenda, 0, 15); ?>"><b><a style="color:red;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarmedicoconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?=substr( $item->sala, 0,5) . " - " . substr($item->medicoagenda, 0, 5); ?>(...)</b></td>
                                <? } else { ?>
                                    <td style="cursor: pointer; color:red;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $item->sala . " - " . substr($item->medicoagenda, 0, 15); ?>"><?=substr( $item->sala, 0,5) . " - " . substr($item->medicoagenda, 0, 5); ?>(...)</td>

                                <? } ?>                                


                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio . ' - ' . $item->procedimento; ?></td>

                             <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->convenio_paciente . ' - ' . $item->procedimento; ?></td>-->

                                <td class="<?php echo $estilo_linha; ?>"><?= $telefone; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><a title="<?= $item->observacoes ; ?>" style="color:red; cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                width=500,height=230');">=><?=  substr($item->observacoes, 0,5) ; ?>(...)</td>
                                    <? if ($item->paciente_id != "") { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>');">Editar
                                            </a></div>
                                    </td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
                                    <?
                                }
                                if ($item->paciente_id == "" && $item->bloqueado == 'f') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarconsultatemp/<?= $item->agenda_exames_id ?>');">Consultas
                                            </a></div>
                                    </td>
                                <? } elseif ($item->bloqueado == 'f') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacienteconsultatemp/<?= $item->paciente_id ?>/<?= $faltou; ?>');">Consultas
                                            </a></div>
                                    </td>
                                <?
                                } elseif ($item->bloqueado == 't') {
//            die;
                                    ?>
                                    <!--<td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>-->
                                    <?
                                }
                                if ($paciente == "Bloqueado" || $paciente == "vago") {
                                    if ($item->bloqueado == 'f') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Bloquear
                                                </a></div>
                                        </td>
            <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;" colspan="2"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
                                                </a></div>
                                        </td>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <? if ($item->telefonema == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="green"title="<?= $item->telefonema_operador; ?>" ><b>Confirmado</b></td>
            <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/telefonema/<?= $item->agenda_exames_id ?>/<?= $item->paciente; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Confirma
                                                </a></div>
                                        </td>
                                        <?
                                    }
                                }
                                ?>

                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="14">
<?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total . " - Vago: " . $l . " - Marcado: " . $p; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
            </td>
            </tr>
            </table>


        </div>
    </div>
</div>
<?
if (@$_GET['data'] != '') {
    $data = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['data'])));
} else {
    $data = date('Y-m-d');
}
?>
<script>
//alert($('#medico').val());
    $(function () {
        $("#accordion").accordion();
    });



//    function date() {


    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        height: 400,
        theme: true,
        dayClick: function (date) {
            var data = date.format();

            window.open('<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsultacalendario?empresa=&especialidade=&medico=&situacao=&data=' + moment(data).format('DD%2FMM%2FYYYY') + '&nome=', '_self');



        },
//        eventDragStop: function (date, jsEvent, view) {
////            alert(date.format());
//        },
//        navLinks: true,
        showNonCurrentDates: false,
//            weekends: false,

//                navLinks: true, // can click day/week names to navigate views
        defaultDate: '<?= $data ?>',
        locale: 'pt-br',
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        schedulerLicenseKey: 'CC-Attribution-Commercial-NoDerivatives',
//            events: '<?= base_url() ?>autocomplete/listarhorarioscalendario',

        eventSources: [
            // your event source

            {
                url: '<?= base_url() ?>autocomplete/listarhorarioscalendarioconsulta',
                type: 'POST',
                data: {
                    medico: $('#medico').val(),
                    especialidade: $('#especialidade').val(),
                    empresa: $('#empresa').val()
                },
                error: function () {
//                    alert('Houve !');
                }

            }

            // any other sources...

        ]

    });

//    }


//    $(document).ready(function () {



//            $.getJSON("<?= base_url() ?>autocomplete/listarhorarioscalendario", json);
//            function json(data) {


//            }

//    });
//    $('#medico').change(function () {
//        document.getElementById('form').submit();
//    });
//    $('#especialidade').change(function () {
//        document.getElementById('form').submit();
//    });

    $(function () {
        $('#especialidade').change(function () {

            if ($(this).val()) {

//                                                  alert('teste_parada');
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">TODOS</option>';
                    console.log(j);

                    for (var c = 0; c < j.length; c++) {


                        if (j[0].operador_id != undefined) {
                            options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                        }
                    }
                    $('#medico').html(options).show();
                    $('.carregando').hide();



                });
            } else {
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidadetodos', {txtcbo: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">TODOS</option>';
                    console.log(j);

                    for (var c = 0; c < j.length; c++) {


                        if (j[0].operador_id != undefined) {
                            options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                        }
                    }
                    $('#medico').html(options).show();
                    $('.carregando').hide();



                });

            }
        });
    });


    if ($('#especialidade').val()) {

//                                                  alert('teste_parada');
        $('.carregando').show();
//                                                        alert('teste_parada');
        $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $('#especialidade').val(), ajax: true}, function (j) {
            options = '<option value="">TODOS</option>';
            console.log(j);

            for (var c = 0; c < j.length; c++) {


                if (j[0].operador_id != undefined) {
                    options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                }
            }
            $('#medico').html(options).show();
            $('.carregando').hide();



        });
    } else {


    }
</script>


