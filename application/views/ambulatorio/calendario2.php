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
    <div id="sala-de-espera" style="display: none;">

        <div id="sidebar-wrapper" class="sidebarteste">
            <div style="margin-left: 35%;">
                <button id="botaosalaesconder">Esconder</button>
            </div>
            <div>
                <ul class="sidebar-nav">

                    <li class="tabela_content01">
                        <span> Agenda</span> - <span style="color:#ff004a">Paciente - <span style="color: #5659C9">Procedimento</span> - <span style="color: black"> Tempo de Espera</span>

                    </li>
                    <?
                    $listaespera = $this->exame->listarexameagendaconfirmada2geral()->get()->result();

                    if (count($listaespera) > 0) {
                        @$estilo_linha == "tabela_content01";
                        foreach ($listaespera as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_autorizacao;
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%H:%I:%S');

                            (@$estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <li class="<?= $estilo_linha ?>">
                                <a href="<?= base_url() ?>ambulatorio/exame/examesala/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id; ?>" target="_blank">
                                    <span style="color: black"><?= $item->inicio; ?></span> -  <span> <?= $item->paciente ?></span> - <span style="color: #5659C9"><?= $item->procedimento ?></span> - <span style="color: black"><?= $teste ?></span> - 
                                </a>
                            </li>


                            <?
                        }
                    }
                    ?>


                </ul>
            </div>
        </div>
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
                        Multifuncao Geral Recep&ccedil;&atilde;o
                    </th>
                    <th>  
                        <div class="bt_link_new">
                            <a class="btnTexto" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteencaixegeral');">
                                Encaixar Paciente
                            </a>
                        </div>
                    </th>
                    <th>
                        <div class="bt_link_new">
                            <a class="btnTexto" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novohorarioencaixegeral');">
                                Encaixar Horario
                            </a>
                        </div>
                    </th>
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
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario2">

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

                                <table border="1" style="border">
                                    <tr>
                                        <th class="tabela_title">Grupo</th>
                                        <th class="tabela_title">Empresa</th>

                                    </tr>
                                    <tr>
                                        <th class="tabela_title">
                                            <select name="grupo" id="grupo" class="size2" >
                                                <option value='' >TODOS</option>
                                                <? foreach ($grupos as $grupo) { ?>                                
                                                    <option value='<?= $grupo->nome ?>' <?
                                                    if (@$_GET['grupo'] == $grupo->nome):echo 'selected';
                                                    endif;
                                                    ?>><?= $grupo->nome ?></option>
                                                        <? } ?>
                                            </select>

                                        </th>
                                        <th class="tabela_title">
                                            <select name="empresa" id="empresa" class="size2">
                                                <option value="">TODOS</option>
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

                                    </tr>
                                </table>

                                <table border="1">
                                    <tr>
                                        <th class="tabela_title">Sala</th>

                                    </tr>
                                    <tr>
                                        <th class="tabela_title">
                                            <select name="sala" id="sala" class="size2">
                                                <option value="">TODOS</option>
                                                <? foreach ($salas as $value) : ?>
                                                    <option value="<?= $value->exame_sala_id; ?>" <?
                                                    if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                                    endif;
                                                    ?>><?php echo $value->nome; ?></option>
                                                        <? endforeach; ?>
                                            </select>

                                        </th>

                                    </tr>    
                                </table>

                            </div>

                            <div style="border: 1pt dotted #444; border-radius: 10pt;">
                                <table border="1">
                                    <tr>
                                        <th class="tabela_title">Tipo Agenda</th>
                                        <th class="tabela_title" colspan="2">Medico</th>

                                    </tr>
                                    <tr>

                                        <th class="tabela_title">
                                            <select name="tipoagenda" id="tipoagenda" class="size2">
                                                <!--<option value=""></option>-->
                                                <option value="">TODOS</option>
                                                <? foreach ($tipo_consulta as $value) : ?>
                                                    <option value="<?= $value->ambulatorio_tipo_consulta_id; ?>" <?
                                                    if (@$_GET['tipoagenda'] == $value->ambulatorio_tipo_consulta_id):echo 'selected';
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
                                        <th class="tabela_title" colspan="2">
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

                                    </tr>
                                </table>
                            </div>
                            <table border="1">
                                <tr>

                                    <th colspan="2" class="tabela_title">Nome</th>
                                </tr>

                                <tr>

                                    <th colspan="2" class="tabela_title">
                                        <input type="text" name="nome" class="texto08 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                        <input type="hidden" name="data" id="data" class="texto04 bestupper" value="<?php echo date("Y-m-d", strtotime(str_replace('/', '-', @$_GET['data']))); ?>" />
                                    </th>
                                </tr>

                                <tr>
                                    <th colspan="1" class="tabela_title">
                                        <button type="submit" id="enviar">Pesquisar</button>
                                    </th>
<!--                               O FORM FECHA AQUI-->     </form>
                                    <th colspan="1" class="tabela_title">
                                        <button id="botaosala">S/ de Espera</button>
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
                                    <th class="tabela_header" >Status</th>
                                    <th class="tabela_header" width="250px;">Nome</th>
                                    <!--<th class="tabela_header" width="70px;">Resp.</th>-->
                                    <!--<th class="tabela_header" width="70px;">Data</th>-->
                                    <!--<th class="tabela_header" width="50px;">Dia</th>-->
                                    <th class="tabela_header" width="70px;">Agenda</th>
                                    <th class="tabela_header" width="70px;">    </th>
                                    <th class="tabela_header" width="150px;">Telefone</th>
                                    <th class="tabela_header" width="150px;">Convenio</th>
                                    <th class="tabela_header">Sala</th>
                                    <th class="tabela_header">Médico</th>
                                    <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                                    <th class="tabela_header" colspan="5"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarexamemultifuncaogeral($_GET);
                $total = $consulta->count_all_results();
                $limit = 100;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                $l = $this->exame->listarestatisticapaciente($_GET);
                $p = $this->exame->listarestatisticasempaciente($_GET);

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
//                        var_dump($item->situacaoexame);
//                        die;
                        $lista = $this->exame->listarexamemultifuncaogeral2($_GET)->limit($limit, $pagina)->get()->result();
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
                            ?>
                            <tr>
                                <?
                                if ($verifica == 1) {
                                    if ($item->ocupado == 't') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><b><strike><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></strike></b></td>
                                        <td class="<?php echo $estilo_linha; ?>"><b><strike><?= $item->paciente; ?></strike></b></td>
                                    <? } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></b></td>
                                        <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                        <?
                                    }
                                }

                                if ($verifica == 2) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $item->paciente; ?></b></td>
                                    <?
                                }

                                if ($verifica == 3) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->paciente; ?></b></td>
                                    <?
                                }

                                if ($verifica == 4) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->paciente; ?></b></td>
                                    <?
                                }

                                if ($verifica == 5) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><?= $item->paciente; ?></b></td>
                                    <?
                                }

                                // NOME
                                if ($verifica == 6) {
                                    if ($item->ocupado == 't') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><b><strike><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></strike></b></td>
                                        <td class="<?php echo $estilo_linha; ?>"><b><strike><?= $item->paciente; ?></strike></b></td>
                                    <? } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendaauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $situacao; ?></b></td>
                                        <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                        <?
                                    }
                                }
                                ?>

                                <!-- RESPONSAVEL -->
                                <!--<td class="<?php echo $estilo_linha; ?>"><?= substr($item->secretaria, 0, 9); ?></td>-->

                                <!-- DATA, DIA E AGENDA -->
                                <? if ($item->ocupado == 't') { ?>
                                                                <!--<td class="<?php echo $estilo_linha; ?>"><strike><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></strike></td>-->
                                                        <!--<td class="<?php echo $estilo_linha; ?>"><strike><?= substr($dia, 0, 3); ?></strike></td>-->
                                    <td class="<?php echo $estilo_linha; ?>"><strike><?= $item->inicio; ?></strike></td>
                        <? } else { ?>
                                    <!--<td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>-->
                                    <!--<td class="<?php echo $estilo_linha; ?>"><?= substr($dia, 0, 3); ?></td>-->
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                        <? } ?>
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
                        if($verifica = 2){ $cor = "green"; }
                        else if($verifica = 3){ $cor = "red"; }
                        else if($verifica = 4){ $cor = "blue"; }
                        else if($verifica = 5){ $cor = "gray"; }
                        else{ $cor = "black"; }
                              
                        $title = $item->medicoagenda;
                        $corMedico = $cor;
                        if ($item->confirmacao_medico != '') {
                            if($item->confirmacao_medico == 'f'){
                                $corMedico = "#ff8c00";
                                $title .= ". Não comparecerá na clinica.";
                            } 
                            else{
                                $corMedico = "green";
                                $title .=  ". Comparecerá na clinica.";
                            }
                        }
                        if ($situacao == 'espera' || $situacao == 'agendado' || $situacao == "<font color='gray'>faltou") {  ?>
                            <td style="cursor: pointer; color: <?=$cor?>;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $item->sala; ?>"><b><a style="color:<?=$cor?>;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarmedicoconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?= $item->sala; ?></b></td>
                            <td style="cursor: pointer; color: <?= $corMedico; ?>" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $title; ?>"><b><a style="color:<?=$corMedico?>;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/trocarmedicoconsulta/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');" /><?= $item->medicoagenda ?></b></td>
                        <? } else { ?>
                            <td style="cursor: pointer; color: <?=$cor?>;" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $item->sala ?>"><?= $item->sala ?></td>
                            <td style="cursor: pointer; color: <?= $corMedico; ?>" class="<?php echo $estilo_linha; ?>" width="150px;" title="<?= $title; ?>"><?= $item->medicoagenda; ?></td>

                        <? } ?>  
                        <!-- OBSERVAÇOES -->
                        <!--<td class="<?php // echo $estilo_linha;                   ?>"><?= $item->observacoes; ?></td>-->

                        <td class="<?php echo $estilo_linha; ?>"><a title="<?= $item->observacoes; ?>" style=" cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                        width=500,height=230');">=><?= $item->observacoes; ?></td>
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
                            if ($item->medicoagenda == "") {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link_new" style="width: 90px;">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral3/<?= $item->agenda_exames_id ?>');">Agendar
                                        </a>


                                    </div>
                                </td>
                            <? } else {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <div class="bt_link_new" style="width: 90px;">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral/<?= $item->agenda_exames_id ?>/<?= $item->medico_agenda ?>');">Agendar
                                        </a>


                                    </div>
                                </td>
                                <?
                            }
                        } elseif ($item->bloqueado == 'f') {
                            ?>
                            <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link_new" style="width: 90px;">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacientetempgeral/<?= $item->paciente_id ?>/<?= $faltou; ?>');">Atendimento
                                    </a>


                                </div>
                            </td>
                        <? } elseif ($item->bloqueado == 't') { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                            <?
                        }
                        if ($paciente == "Bloqueado" || $paciente == "vago") {
                            if ($item->bloqueado == 'f') {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a title="<?= $item->operador_desbloqueio ?>" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Bloquear
                                        </a></div>
                                </td>
                            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a title="<?= $item->operador_bloqueio ?>"  onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
                                        </a></div>
                                </td>
                                <?
                            }
                        } else {
                            ?>
                            <? if ($item->telefonema == 't') { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="green" title="<?= $item->telefonema_operador; ?>"><b>Confirmado</b></td>
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
if (@$_GET['nome'] != '') {
    $nome = $_GET['nome'];
} else {
    $nome = "";
}
?>
<script>
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


//    function date() {
    if ($('#nome').val() != '') {
        var paciente = '<?= $nome ?>';
    } else {
        var paciente = '';
    }

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
            window.open('<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario2?empresa=' + $('#empresa').val() + '&tipoagenda=' + $('#tipoagenda').val() + '&sala=' + $('#sala').val() + '&grupo=' + $('#grupo').val() + '&especialidade=&medico=' + $('#medico').val() + '&situacao=&data=' + moment(data).format('DD%2FMM%2FYYYY') + '&nome= ' + paciente + '', '_self');



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
                url: '<?= base_url() ?>autocomplete/listarhorarioscalendario',
                type: 'POST',
                data: {
                    medico: $('#medico').val(),
                    tipoagenda: $('#tipoagenda').val(),
                    empresa: $('#empresa').val(),
                    sala: $('#sala').val(),
                    grupo: $('#grupo').val(),
                    paciente: paciente
                },
                error: function () {
//                    alert('Houve !');
                }

            }

            // any other sources...

        ]

    });
    $(function () {
        $('#grupo').change(function () {

            if ($(this).val()) {
//                alert($(this).val());
                $('.carregando').show();
//                                                        alert('teste_parada');
                $.getJSON('<?= base_url() ?>autocomplete/grupoempresasala', {txtgrupo: $(this).val(), ajax: true}, function (j) {
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
                $.getJSON('<?= base_url() ?>autocomplete/grupoempresasalatodos', {txtgrupo: $(this).val(), ajax: true}, function (j) {
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


    if ($('#grupo').val()) {

//        alert($('#grupo').val());
        $('.carregando').show();
//                                                        alert('teste_parada');
        $.getJSON('<?= base_url() ?>autocomplete/grupoempresa', {txtgrupo: $('#grupo').val(), ajax: true}, function (j) {
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
    if ($('#grupo').val()) {

//        alert($('#grupo').val());
        $('.carregando').show();
//                                                        alert('teste_parada');
        $.getJSON('<?= base_url() ?>autocomplete/grupoempresasala', {txtgrupo: $('#grupo').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
//                    alert(j);
            var sala_atual = <?= $sala_atual ?>;
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





</script>


