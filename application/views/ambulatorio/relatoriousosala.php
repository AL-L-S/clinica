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
<?
if (date("Y-m-d", strtotime(str_replace('/', '-', @$_GET['data']))) == '1969-12-31') {
    $_GET['data'] = date("Y-m-d");
}
?>


<div class="content">



    <style>
        #sidebar-wrapper{
            z-index: 100;
            position: fixed;
            margin-top: 50px;
            margin-left: 37%;
            list-style-type: none; /* retira o marcador de listas*/ 
            overflow-y: scroll;
            overflow-x: auto;
            /*height: 900px;*/
            /*width: 500px;*/
            max-height: 900px;

        }

        #sidebar-wrapper ul {
            padding:0px;
            margin:0px;
            background-color: #ebf7f9;
            list-style:none;
            margin-bottom: 30px;

        }
        #sidebar-wrapper ul li a {
            color: #ff004a;
            border: 20px;
            text-decoration: none;
            /*padding: 3px;*/
            /*border: 2px solid #00BDFF;*/ 
            margin-bottom: 20px;
        }

        #botaosalaesconder {
            border: 1px solid #8399f6
        }
        #botaosala {
            border: 1px solid #8399f6;
            width: 80pt;   
        }
        .vermelho{
            color: red;
        }

    </style>


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

        .singular table div.bt_link_new .btnTexto {color: #2779aa; }
        .singular table div.bt_link_new .btnTexto:hover{ color: red; font-weight: bolder;}
        .vermelho{
            color: red;
        }
        /*#pop{display:none;position:absolute;top:50%;left:50%;margin-left:-150px;margin-top:-100px;padding:10px;width:300px;height:200px;border:1px solid #d0d0d0}*/

    </style>




    <div id="accordion">
        <h3 class="singular">
            <table>
                <tr>
                    <th>
                        Mapa de Uso de Salas
                    </th>

                </tr>


            </table>
        </h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
//            $empresas = $this->exame->listarempresas();
            $empresa_logada = $this->session->userdata('empresa_id');
//            $tipo_consulta = $this->tipoconsulta->listarcalendario();

            if (@$_GET['medico'] != '') {
                $medico_atual = $_GET['medico'];
            } else {
                $medico_atual = 0;
            }
            if (@$_GET['empresa'] != '') {
                $empresa_atual = $_GET['empresa'];
            } else {
                $empresa_atual = $empresa_logada;
            }
            if (@$_GET['sala'] != '') {
                $sala_atual = $_GET['sala'];
            } else {
                $sala_atual = 0;
            }
            if (@$_GET['tipoagenda'] != '') {
                $tipoagenda = $_GET['tipoagenda'];
            } else {
                $tipoagenda = 0;
            }
            ?>
            <form method="get" action="<?= base_url() ?>ambulatorio/exame/relatoriousosala">

                <table>
                    <thead>

                        <tr>

                            <th>
                                <table border="1">
                                    <tr>

                                        <th colspan="2" class="tabela_title">Sala</th>
                                    </tr>

                                    <tr>

                                        <th colspan="2" class="tabela_title">

                                            <!--                                        <label>Médicos </label>-->


                                            <select  name="sala" id="sala" class="size4" >
                                                <option value="">Selecione</option>
                                                <? foreach ($salas as $item) : ?>
                                                    <option value="<?= $item->exame_sala_id; ?>" <?= ( @$_GET['sala'] == $item->exame_sala_id ) ? 'selected' : '' ?>>
                                                        <?= $item->nome; ?>
                                                    </option>
                                                <? endforeach; ?>
                                            </select>

                                            <input type="hidden" name="data" id="data" class="texto04 bestupper" value="<?php echo date("Y-m-d", strtotime(str_replace('/', '-', @$_GET['data']))); ?>" />
                                        </th>
                                    </tr>

                                    <tr>
                                        <th colspan="1" class="tabela_title">
                                            <button type="submit" id="enviar">Pesquisar</button>
                                        </th>
                                        <!--                               O FORM FECHA AQUI-->     </form>

                                    </tr>
                                </table>



                            </th>
                            <th>



                            </th>


                        </tr>


                        <tr>
                            <td>
                                <div class="panel panel-default">
                                    <div class="panel-heading ">
                                        <!--                                Calendário-->
                                    </div>
                                    <div class="row" style="width: 100%; ">
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
                        </tr>
                    </thead>

                </table> 
            </form>


        </div>
    </div>
</div>
<?
if (@$_GET['data'] != '') {
    $data = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['data'])));
} else {
    $data = date('Y-m-d');
}
if (@$_GET['nome'] != '') {
    $nome = $_GET['nome'];
} else {
    $nome = "";
}
if (@$_GET['sala'] != '') {
    $sala = "";
}
?>
<style>
    .titulo{
        font-weight: bold;
        font-size: 15pt;
        text-align: center;
    }
</style>
<script>

//alert();

    if ($('#grupo').val()) {

//        alert($('#grupo').val());
        $('.carregando').show();
//                                                        alert('teste_parada');
        $.getJSON('<?= base_url() ?>autocomplete/grupoempresasala', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
//                    alert(j);
            sala_atual = <?= $sala_atual ?>;
            for (var c = 0; c < j.length; c++) {
                if (sala_atual == j[c].exame_sala_id) {
                    options += '<option selected value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                } else {
                    options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                }

            }

            $('#sala').html(options).show();
            $('.carregando').hide();



        });
    }


    if ($('#grupo').val()) {

//        alert($('#grupo').val());
        $('.carregando').show();
//                                                        alert('teste_parada');
        $.getJSON('<?= base_url() ?>autocomplete/grupoempresa', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
//                    alert(j);
            var empresa_atual = <?= $empresa_atual ?>;
            for (var c = 0; c < j.length; c++) {
                if (empresa_atual == j[c].empresa_id) {
                    options += '<option selected value="' + j[c].empresa_id + '">' + j[c].nome + '</option>';
                } else {
                    options += '<option value="' + j[c].empresa_id + '">' + j[c].nome + '</option>';
                }


            }
            $('#empresa').html(options).show();
            $('.carregando').hide();



        });
    }

//alert($('#medico').val());
    $(function () {
        $("#accordion").accordion();
    });
    $("#botaosala").click(function () {
        $("#sala-de-espera").toggle("fast", function () {
            // Animation complete.
        });
    });

    $("#botaosalaesconder").click(function () {
        $("#sala-de-espera").hide("fast", function () {
            // Animation complete.
        });
    });


    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next,today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay, listMonth,listWeek,listDay'
        },
        views: {
            listDay: {buttonText: 'Lista Dia'},
            listMonth: {buttonText: 'Lista Mes'},
            listWeek: {buttonText: 'Lista Semana'}
        },
        height: 900,
        dayRender: function (date, cell) {
            var data_escolhida = $('#data').val();
            var today = moment(new Date()).format('YYYY-MM-DD');
            var check = moment(date).format('YYYY-MM-DD');
            if (data_escolhida == check && data_escolhida != today) {
                cell.css("background-color", "#BCD2EE");
            }
//            cell.css("height", "5pt");
        },
        dayClick: function (date, cell) {
            var data = date.format();
            window.open('<?= base_url() ?>ambulatorio/exame/relatoriousosala?&sala=' + $('#sala').val() + '&data=' + moment(data).format('DD%2FMM%2FYYYY') + '', '_self');
        },
                
        eventClick: function (calEvent, jsEvent, view) {
            alert(calEvent.texto);
        },
//        contentHeight: 600,
        showNonCurrentDates: false,
        defaultDate: '<?= $data ?>',
        locale: 'pt-br',
        editable: false,
        navLinks: true,
        eventLimit: false, // allow "more" link when too many events
        schedulerLicenseKey: 'CC-Attribution-Commercial-NoDerivatives',
        eventSources: [
            {
                url: '<?= base_url() ?>ambulatorio/exame/listarusosala',
                type: 'GET',
                data: {
                    sala: $('#sala').val()

                },
                error: function (e) {
                    console.log(e);
                }

            }
        ],
        timeFormat: 'H:mm'

    });
    
    $(function () {
        $('#sala').change(function () {
            window.open('<?= base_url() ?>ambulatorio/exame/relatoriousosala?&sala=' + $('#sala').val() + '&data=' + moment(data).format('DD%2FMM%2FYYYY') + '', '_self');
        });
    });

    $(function () {
        $('#empresa').change(function () {

            if ($(this).val()) {
//                alert($(this).val());
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/grupoempresasala', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//                    alert(j);
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                    }
                    $('#sala').html(options).show();
                    $('.carregando').hide();
                });

            } else {
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/grupoempresasalatodos', {txtgrupo: $('#grupo').val(), txtempresa: $('#empresa').val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//                    alert(j);
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                    }
                    $('#sala').html(options).show();
                    $('.carregando').hide();
                });
            }

        });
    });

    $(function () {
        $('#tipoagenda').change(function () {
            $('.carregando').show();
//            alert('teste_parada');
            $.getJSON('<?= base_url() ?>autocomplete/listarmedicotipoagenda', {tipoagenda: $(this).val(), ajax: true}, function (j) {
                options = '<option value=""></option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';
                }
//                console.log(options);
                $('#medico').html(options).show();
                $('.carregando').hide();

            });
        });
    });

    $(function () {
        $('#grupo').change(function () {

//            if ($(this).val()) {

//                alert($(this).val());
            $('.carregando').show();
//                                                        alert('teste_parada');
            $.getJSON('<?= base_url() ?>autocomplete/grupoempresa', {txtgrupo: $(this).val(), ajax: true}, function (j) {
                options = '<option value=""></option>';
//                    alert(j);

                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].empresa_id + '">' + j[c].nome + '</option>';
                }
                $('#empresa').html(options).show();
                $('.carregando').hide();



            });
//            }
        });
    });





</script>


