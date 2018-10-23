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
if (@$_GET['data'] != '' && date("Y-m-d", strtotime(str_replace('/', '-', @$_GET['data']))) == '1969-12-31') {
    $_GET['data'] = date("Y-m-d");
}
?>


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
                        Horários da Agenda
                    </th>
                    
<!--                    <th>
                        <div class="bt_link_new">
                            <a class="btnTexto" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novohorarioencaixegeral');">
                                Encaixar Horario
                            </a>
                        </div>
                    </th>-->
                </tr>


            </table>
        </h3>
        <div>
            <?
            $medicos = $this->operador_m->listarmedicos();
            $salas = $this->exame->listartodassalasgrupos();
            $especialidade = $this->exame->listarespecialidade();
            $grupos = $this->procedimento->listargrupos();
            $empresas = $this->exame->listarempresas();
            $empresa_logada = $this->session->userdata('empresa_id');
            $tipo_consulta = $this->tipoconsulta->listarcalendario();

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
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/calendariohorariosagenda">

                    <tr>
                        <th>
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <!--                                Calendário-->
                                </div>
                                <div class="row" style="width: 60%; ">
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
                        </th>
                        <th>
                            <div style="border: 1pt dotted #444; border-radius: 10pt;">
                                <table border="1">
                                    <tr>
                                        <th class="tabela_title">Situação</th>

                                    </tr>
                                    <tr>
                                    <? if (@$_GET['data'] != '') { ?>
                                        <input type="hidden" name="data" id="data" class="texto04 bestupper" value="<?php echo date("Y-m-d", strtotime(str_replace('/', '-', @$_GET['data']))); ?>" />
                                    <? } else { ?>
                                        <input type="hidden" name="data" id="data" class="texto04 bestupper" value="" />
                                    <? } ?>
                                    <input type="hidden"  id="agenda_id" name="agenda_id" class="size2" value="<?=@$_GET['agenda_id']?>" required/>
                                        <th class="tabela_title">
                                            <select name="situacao" id="situacao" class="size2">
                                                <!--<option value=""></option>-->
                                                <option value="" <?=(@$_GET['situacao'] == 'TODOS')? 'selected' : ''?>>TODOS</option>
                                                <option value="OK" <?=(@$_GET['situacao'] == 'OK')? 'selected' : ''?>>OCUPADO</option>
                                                <option value="LIVRE" <?=(@$_GET['situacao'] == 'LIVRE')? 'selected' : ''?>>VAGO</option>
                                                
                                            </select>
                                        </th>
                                        
                                    </tr>
                                </table>
                            </div>
                            <table border="1">
                               

                                <tr>
                                    <th colspan="1" class="tabela_title">
                                        <button type="submit" id="enviar">Pesquisar</button>
                                    </th>
                                    
                                </tr>
                            </table>

                        </th>


                    </tr>

                    <!--</form>-->
                    <tr>

                    </tr>
                    </thead>

            </table> 
            <!-- Comentei essa parte só pra publicar -->
            

            <table>
                <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>
                <tr>
<!--                    <td rowspan="2"> 
                    </td>-->
<!--                    <td>
                        <div style="width: 10px;">

                        </div>
                    </td>-->
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <th class="tabela_header" width="80px;">Empresa</th>
                                    <th class="tabela_header" width="70px;">Status</th>
                                    <th class="tabela_header" width="100px;">Data</th> 
                                    <th class="tabela_header" width="70px;">Agenda</th> 
                                    <th class="tabela_header" width="250px;">Nome</th>
                                    <!--<th class="tabela_header" width="70px;">Resp.</th>-->                                    
                                    <!--<th class="tabela_header" width="50px;">Dia</th>-->                                                                        
                                    <th class="tabela_header" width="70px;">    </th>
                                    <th class="tabela_header" width="150px;">Telefone</th>
                                    <th class="tabela_header" width="150px;">Convenio</th>
                                    <th class="tabela_header">Sala</th>
                                    <th class="tabela_header">Médico</th>
                                    <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                                    <th class="tabela_header" colspan="5"><center>&nbsp;</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                $limit = 100;
                $lista = $this->exame->listarexamemultifuncaogeralhorarioagenda($_GET)->limit($limit, $pagina)->get()->result();
//                $consulta = $this->exame->listarexamemultifuncaogeral($_GET);
                $total = count($lista);

                $l = $this->exame->listarestatisticapaciente($_GET);
                $p = $this->exame->listarestatisticasempaciente($_GET);

                if ($total > 0) {
                    ?>
                    <tbody>
                  
                    <?php
//                        var_dump($item->situacaoexame);
//                        die;
                    $estilo_linha = "tabela_content01";
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
                            $verifica = 5;
                        } else {
                            $paciente = "";

                            if ($item->realizada == 't' && $item->situacaoexame == 'EXECUTANDO') {
                                $situacao = "Atendendo";
                                $verifica = 2;
                            } elseif ($item->realizada == 't' && $item->situacaoexame == 'FINALIZADO') {
                                $situacao = "Finalizado";
                                $verifica = 4;
                            } elseif ($item->confirmado == 'f' && $item->operador_atualizacao == null) {
                                $situacao = "agenda";
                                $verifica = 1;
                            } elseif ($item->confirmado == 'f' && $item->operador_atualizacao != null) {
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
                        $cor = '';
                        if ($verifica == 1) {
                            $cor = '';
                        }
                        if ($verifica == 2) {
                            $cor = 'green';
                        }
                        if ($verifica == 3) {
                            $cor = 'red';
                        }
                        if ($verifica == 4) {
                            $cor = 'blue';
                        }
                        if ($verifica == 5) {
                            $cor = 'gray';
                        }
                        ?>

                        <tr>
                            <td class="<?php echo $estilo_linha; ?>">
                                <div style="font-size: 8pt; margin-left: 2pt"><?= $item->empresa; ?></div>
                            </td>
                            <?
                            if ($verifica == 1) {
                                if ($item->ocupado == 't') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><strike><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></strike></b></td>

                                <? } else {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></b></td>

                                    <?
                                }
                            }

                            if ($verifica == 2) {
                                ?>

                                <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                <?
                            }


                            if ($verifica == 3) {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                <?
                            }

                            if ($verifica == 4) {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                <?
                            }

                            if ($verifica == 5) {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>

                                <?
                            }


                            if ($verifica == 6) {
                                if ($item->ocupado == 't') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><strike><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></strike></b></td>

                                <? } else {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></b></td>

                                    <?
                                }
                            }
                            ?>
                            <?
                            //  echo "<pre>";
//                                    var_dump($lista);die;
                            ?>
                            <!-- RESPONSAVEL -->
                            <!--<td class="<?php echo $estilo_linha; ?>"><?= substr($item->secretaria, 0, 9); ?></td>-->

                            <!-- DATA, DIA E AGENDA -->
                            <? if ($item->ocupado == 't') { ?>
                                <td class="<?php echo $estilo_linha; ?>"><strike><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></strike></td>
                            <td class="<?php echo $estilo_linha; ?>"><strike><?= $item->inicio; ?></strike></td>
                            <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><?= $item->paciente; ?></b></td>
                        <? } else { ?>
                            <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><font color="<?= $cor ?>"><b><?= $item->paciente; ?></b></td>
                        <? } ?>
                        <!-- EMPRESA -->


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

                        <!-- TELEFONE -->
                        <td class="<?php echo $estilo_linha; ?>"><?= $telefone; ?></td>

                        <!-- CONVENIO -->
                        <? if ($item->convenio != "") { ?>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio . " - " . $item->procedimento . " - " . $item->codigo; ?></td>
                        <? } else { ?>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio_paciente . " - " . $item->procedimento . " - " . $item->codigo; ?></td>
                        <? } ?>

                        <!-- SALA -->   
                        <?
                        if ($verifica = 2) {
                            $cor = "green";
                        } else if ($verifica = 3) {
                            $cor = "red";
                        } else if ($verifica = 4) {
                            $cor = "blue";
                        } else if ($verifica = 5) {
                            $cor = "gray";
                        } else {
                            $cor = "black";
                        }

                        $title = $item->medicoagenda;
                        $corMedico = $cor;
                        if ($item->confirmacao_medico != '') {
                            if ($item->confirmacao_medico == 'f') {
                                $corMedico = "#ff8c00";
                                $title .= ". Não comparecerá na clinica.";
                            } else {
                                $corMedico = "green";
                                $title .= ". Comparecerá na clinica.";
                            }
                        }
                        if ($situacao == 'espera' || $situacao == 'agendado' || $situacao == "<font color='gray'>faltou") {
                            ?>
                            <td style=" color: <?= $cor ?>;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $item->sala; ?>"><b><a style="color:<?= $cor ?>;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarmedicoconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?= $item->sala; ?></b></td>
                            <td style=" color: <?= $corMedico; ?>" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $title; ?>"><b><a style="color:<?= $corMedico ?>;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarmedicoconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?= $item->medicoagenda ?></b></td>
                        <? } else { ?>
                            <td style="color: <?= $cor ?>;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $item->sala ?>"><?= $item->sala ?></td>
                            <td style="color: <?= $corMedico; ?>" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $title; ?>"><?= $item->medicoagenda; ?></td>

                        <? } ?>  
                        <!-- OBSERVAÇOES -->
                        <!--<td class="<?php // echo $estilo_linha;                             ?>"><?= $item->observacoes; ?></td>-->

                        <td class="<?php echo $estilo_linha; ?>"><a title="<?= $item->observacoes; ?>" style=" cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                                                                                                        width=500,height=400');">=><?= $item->observacoes; ?></td>
                            <? if ($item->paciente_id != "") { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="60px;">
                            </td>
                        <? } else { ?>
                            <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
                            <?
                        }
                        if ($item->paciente_id == "" && $item->bloqueado == 'f') {
                            if ($item->medicoagenda == "") {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" >
                                </td>
                            <? } else {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>">
                                    
                                </td>
                                <?
                            }
                        } elseif ($item->bloqueado == 'f') {
                            ?>
                            <td class="<?php echo $estilo_linha; ?>" >
                            </td>
                        <? } elseif ($item->bloqueado == 't') { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                            <?
                        }
                        if ($paciente == "Bloqueado" || $paciente == "vago") {
                            if ($item->bloqueado == 'f') {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                </td>
                            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                </td>
                                <?
                            }
                        } else {
                            ?>
                            <? if ($item->telefonema == 't') { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="green" title="<?= $item->telefonema_operador; ?>"><b>Confirmado</b></td>
                            <? } elseif ($item->confirmacao_por_sms == 't') {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="ff8c00" title="<?= $item->telefonema_operador; ?>"><b>Confirmado&nbsp;(SMS)</b></td>
                            <? } else {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
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
                        <th class="tabela_footer" colspan="15">
<?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>

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
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script>
$(function () {
    $("#accordion").accordion();
});
//    alert('<?= $sala_atual ?>');
                                            $('#calendar').fullCalendar({
                                                header: {
                                                    left: 'prev,next',
                                                    center: 'title',
                                                    right: 'today'
                                                },
                                                height: 400,
//        theme: true,
                                                dayRender: function (date, cell) {
                                                    var data_escolhida = $('#data').val();
                                                    var today = moment(new Date()).format('YYYY-MM-DD');
                                                    var check = moment(date).format('YYYY-MM-DD');
//            alert(data_escolhida);
//            var today = $.fullCalendar.formatDate(new Date(), 'yyyy-MM-dd');
                                                    if (data_escolhida == check && data_escolhida != today) {
                                                        cell.css("background-color", "#BCD2EE");
                                                    }
                                                },
                                                dayClick: function (date, cell) {
                                                    var data = date.format();
//            cell.css("background-color", "#BCD2EE");
                                                    window.open('<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario2?empresa=' + $('#empresa').val() + '&tipoagenda=' + $('#tipoagenda').val() + '&sala=' + $('#sala').val() + '&grupo=' + $('#grupo').val() + '&especialidade=&medico=' + $('#medico').val() + '&situacao=&data=' + moment(data).format('DD%2FMM%2FYYYY') + '&nome=' + paciente + '', '_self');



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
                                                eventLimit: false, // allow "more" link when too many events
                                                schedulerLicenseKey: 'CC-Attribution-Commercial-NoDerivatives',
//            events: '<?= base_url() ?>autocomplete/listarhorarioscalendario',

                                                eventSources: [
                                                    // your event source

                                                    {
                                                        url: '<?= base_url() ?>autocomplete/listarhorarioscalendarioagendacriada',
                                                        type: 'POST',
                                                        data: {
                                                            agenda_id: $('#agenda_id').val(),
                                                            situacao: $('#situacao').val()
                                                            
                                                        },
                                                        error: function () {
//                    alert('Houve !');
                                                        }

                                                    }

                                                    // any other sources...

                                                ]

                                            });




</script>


