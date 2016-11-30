
<div class="content"> <!-- Inicio da DIV content -->

    <table>
        <thead>
            <tr>
                <th >        <div class="bt_link_new">
                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteencaixegeral');">
                            Encaixar Paciente
                        </a>
                    </div></th>
                <th >        <div class="bt_link_new">
                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novohorarioencaixegeral');">
                            Encaixar Horario
                        </a>
                    </div></th>

            </tr>


    </table>

    <div id="accordion">
        <h3 class="singular"><a href="#">Multifuncao Geral Recep&ccedil;&atilde;o</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $medico = $this->exame->listarespecialidade();
            ?>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaogeral">

                    <tr>
                        <th class="tabela_title">Especialidade</th>
                        <th class="tabela_title">Medico</th>
                        <th class="tabela_title">Salas</th>
                        <th class="tabela_title">SITUA&Ccedil;&Atilde;O</th>
                        <th class="tabela_title">Medico S/N</th>
                        <th class="tabela_title">Data</th>
                        <th colspan="2" class="tabela_title">Nome</th>
                        <th colspan="2" class="tabela_title">Dt. Nascimento</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <select name="especialidade" id="especialidade" class="size1">
                                <option value=""></option>
                                <? foreach ($medico as $value) : ?>
                                    <option value="<?= $value->descricao; ?>" <?
                                    if (@$_GET['sala'] == $value->descricao):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->descricao; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                      

                        <th class="tabela_title">
                            <select name="medico" id="medico" class="size1">
                                <option value=""> </option>

                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="sala" id="sala" class="size1">
                                <option value=""></option>
                                <? foreach ($salas as $value) : ?>
                                    <option value="<?= $value->exame_sala_id; ?>" <?
                                    if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="situacao" id="situacao" class="size1">
                                <option value=""></option>
                                <option value="LIVRE">VAGO</option>
                                <option value="OK">OCUPADO</option>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="c_s_medico" id="c_s_medico" class="size1">
                                <option value=""></option>
                                <option value="t">SIM</option>
                                <option value="f">NAO</option>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
                        <th colspan="2" class="tabela_title">
                            <input type="text" name="nome" class="texto02 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        <th  class="tabela_title">
                            <input type="text" name="nascimento" class="texto02" alt="date" value="<?php echo @$_GET['nascimento']; ?>" />
                        </th>
                        <th colspan="3" class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>

                    </tr>
                </form>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" >Status</th>
                        <th class="tabela_header" width="250px;">Nome</th>
                        <th class="tabela_header" width="70px;">Resp.</th>
                        <th class="tabela_header" width="70px;">Data</th>
                        <th class="tabela_header" width="50px;">Dia</th>
                        <th class="tabela_header" width="70px;">Agenda</th>
                        <th class="tabela_header" width="150px;">Telefone</th>
                        <th class="tabela_header" width="150px;">Convenio</th>
                        <th class="tabela_header">Sala</th>
                        <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                        <th class="tabela_header" colspan="5"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarexamemultifuncaogeral($_GET);
                $total = $consulta->count_all_results();
                $limit = 20;
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
                                    if ($item->data <= $data_atual && $item->inicio < $hora_atual) {
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
                                <? }
                                
                                if ($verifica == 3) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->paciente; ?></b></td>
                                <? }
                                
                                if ($verifica == 4) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/agendadoauditoria/<?= $item->agenda_exames_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=400');"><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->paciente; ?></b></td>
                                <? } 
                                
                                if ($verifica == 5) { ?>
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
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->secretaria, 0, 9); ?></td>

                                <!-- DATA, DIA E AGENDA -->
                                <? if ($item->ocupado == 't') {                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><strike><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></strike></td>
                                    <td class="<?php echo $estilo_linha; ?>"><strike><?= substr($dia, 0, 3); ?></strike></td>
                                    <td class="<?php echo $estilo_linha; ?>"><strike><?= $item->inicio; ?></strike></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($dia, 0, 3); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                <? } ?>
                                    
                                <!-- TELEFONE -->
                                <td class="<?php echo $estilo_linha; ?>"><?= $telefone; ?></td>
                                 
                                <!-- CONVENIO -->
                                <? if ($item->convenio != "") { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio . " - " . $item->procedimento . " - " . $item->codigo; ?></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio_paciente . " - " . $item->procedimento . " - " . $item->codigo; ?></td>
                                <? } ?>

                                <!-- SALA -->   
                                <td class="<?php echo $estilo_linha; ?>" width="150px;"><?= $item->sala . " - " . substr($item->medicoagenda, 0, 15); ?></td>
                                
                                <!-- OBSERVAÇOES -->
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                        
                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
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
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral3/<?= $item->agenda_exames_id ?>');">Atendimento
                                        </a>


                                    </div>
                                </td>
                            <? } else {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexamegeral/<?= $item->agenda_exames_id ?>/<?= $item->medico_agenda ?>');">Atendimento
                                        </a>


                                    </div>
                                </td>
                                <?
                            }
                        } elseif ($item->bloqueado == 'f') {
                            ?>
                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link_new">
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
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Bloquear
                                        </a></div>
                                </td>
            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
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
                            Total de registros: <?php echo $total . " - Vago: " . $l . " - Marcado: " . $p; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">
    $(document).ready(function () {
        
        
        var txtcbo = $("#txtcbo");
        txtcbo.focusout( function(){
   
        });

        $(function () {
            $("#txtcbo").autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=cboprofissionaismultifuncao",
                minLength: 3,
                focus: function (event, ui) {
                    $("#txtcbo").val(ui.item.label);
                    return false;
                },
                select: function (event, ui) {
                    $("#txtcbo").val(ui.item.value);
                    $("#txtcboID").val(ui.item.id);
                    return false;
                }
            });
        });


        $(function () {
            $('#especialidade').change(function () {
                 
                if ($(this).val()) {
  
                    especialidade_medico = txtcbo.val();
//                     alert(teste_parada);
                    $('.carregando').show();
//                     alert(teste_parada);
                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade' , {txtcbo: $(this).val(), ajax: true}, function (j) {
                        options = '<option value=""></option>';
                        console.log(j);
                        
                        for (var c = 0; c < j.length; c++) {
                          
                            
                            if (j[0].operador_id != undefined){
                       options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                        }
                        }
                        $('#medico').html(options).show();
                        $('.carregando').hide();

                          
                        
                    });
                } else {
                    $('#medico').html('<option value="">Selecione</option>');
                }
            });
        });



        $(function () {
            $("#data").datepicker({
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
            $("#accordion").accordion();
        });

        

    });

</script>
