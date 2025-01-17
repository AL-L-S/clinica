
<script>
    // Fazendo a integracao
    $(function () {
        $.ajax({
            type: "GET",
            url: "<?= base_url(); ?>ambulatorio/laudo/multifuncaomedicointegracao",
            dataType: "json",
            success: function () {

            }
        });
    });
</script>
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/mostrarlembretes', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=700');" >
                        Lembretes
                    </a>
                </div>
            </td>
            <td>
                <div class="bt_link_new">
                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/mostrarpendencias', '_blank', 'width=1600,height=700');" >
                        Ver Pendentes
                    </a>
                </div>
            </td>
            <td>  
                <div class="bt_link_new">
                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/agenda/medicoagenda');">
                        Bloquear Agenda
                    </a>
                </div>
            </td>
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Multifuncao Medico</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $empresa = $this->guia->listarempresasaladeespera();
            @$ordem_chegada = @$empresa[0]->ordem_chegada;
            @$ordenacao_situacao = @$empresa[0]->ordenacao_situacao;
            $medicos = $this->operador_m->listarmedicos();
            $perfil_id = $this->session->userdata('perfil_id');
            $procedimento = $this->procedimento->listarprocedimento2();
            $empresa_id = $this->session->userdata('empresa_id');
            $data['empresa'] = $this->empresa->listarempresatoten($empresa_id);
            @$endereco = $data['empresa'][0]->endereco_toten;
            ?>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedico">

                    <tr>
                        <th class="tabela_title">Salas</th>

                        <? if ($perfil_id != 4) { ?>
                            <th class="tabela_title">Medico</th>
                        <? } ?>
                        <th class="tabela_title">Data</th>
                        <th class="tabela_title">Prontu&aacute;rio</th>
                        <th colspan="1" class="tabela_title">Nome</th>
                        <th colspan="1" class="tabela_title">Procedimento</th>
                        <th colspan="1" class="tabela_title">Cid</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <select name="sala" id="sala" class="size2">
                                <option value=""></option>
                                <? foreach ($salas as $value) : ?>
                                    <option value="<?= $value->exame_sala_id; ?>" <?
                                    if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <? if ($perfil_id != 4) { ?>
                                    <!--                            <th class="tabela_title">
                                                                    <select name="especialidade" id="especialidade" class="size1">
                                                                        <option value=""></option>
                                 
                                                                    </select>
                                                                </th>-->



                            <th class="tabela_title">
                                <select name="medico" id="medico" class="size1">
                                    <option value=""> </option>
                                    <? foreach ($medicos as $value) : ?>
                                        <option value="<?= $value->operador_id; ?>"<?
                                        if (@$_GET['medico'] == $value->operador_id):echo 'selected';
                                        endif;
                                        ?>>
                                                    <?php echo $value->nome; ?>

                                        </option>
                                    <? endforeach; ?>

                                </select>
                            </th>
                        <? } ?>
                        <th class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="prontuario" name="prontuario" class="size1"  value="<?php echo @$_GET['prontuario']; ?>" />
                        </th>
                        <th colspan="1" class="tabela_title">
                            <input type="text" name="nome" class="texto03 bestupper" value="<?php echo @$_GET['nome']; ?>" />

                        </th>
                        <th colspan="1" class="tabela_title">
                            <select name="txtprocedimento" id="procedimento" class="size2 chosen-select" tabindex="1">
                                <option value="">Selecione</option>
                                <? foreach ($procedimento as $value) : ?>
                                    <option value="<?= $value->nome; ?>"<?
                                    if (@$_GET['txtprocedimento'] == $value->nome):echo'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th colspan="1" class="tabela_title">
                            <input type="text" name="txtCICPrimariolabel" id="txtCICPrimariolabel" class="texto03" value="<?php echo @$_GET['txtCICPrimariolabel']; ?>" />
                            <input type="hidden" name="txtCICPrimario" id="txtCICPrimario" value="" class="size2" />
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
                        <th class="tabela_header" width="60px;;">Espera</th>
                        <th class="tabela_header" width="60px;">Convenio</th>
                        <th class="tabela_header" width="60px;">Data</th>
                        <th class="tabela_header" width="60px;">Agenda</th>
                        <th class="tabela_header" width="60px;;">Autorização</th>
                        <th class="tabela_header" width="75px;">Sala</th>
                        <th class="tabela_header" width="250px;">Procedimento</th>
                        <th class="tabela_header">laudo</th>
                        <th class="tabela_header">Observações</th>
                        <th class="tabela_header" colspan="5"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
//                $consulta = $this->exame->listarmultifuncaomedico($_GET);
                $total = 2000000000000000000000;
                $limit = 50;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
//                if ($total > 0) {
                ?>
                <tbody>
                    <?php
                    $lista = $this->exame->listarmultifuncao2medico($_GET, @$ordem_chegada, $ordenacao_situacao)->limit($limit, $pagina)->get()->result();
                    $estilo_linha = "tabela_content01";
                    $operador_id = $this->session->userdata('operador_id');
                    foreach ($lista as $item) {
                        $dataFuturo = date("Y-m-d H:i:s");
                        $dataAtual = $item->data_autorizacao;
                        $date_time = new DateTime($dataAtual);
                        $diff = $date_time->diff(new DateTime($dataFuturo));
                        $teste = $diff->format('%H:%I:%S');

                        $verifica = 0;

                        if ($item->paciente != '') {
                            if ($item->cpf != '') {
                                $cpf = $item->cpf;
                            } else {
                                $cpf = 'null';
                            }
                            if ($item->toten_fila_id != '') {
                                $toten_fila_id = $item->toten_fila_id;
                            } else {
                                $toten_fila_id = 'null';
                            }
                            if ($item->toten_sala_id != '') {
                                $toten_sala_id = $item->toten_sala_id;
                            } else {
                                $toten_sala_id = 'null';
                            }
                            $url_enviar_ficha = "$endereco/webService/telaAtendimento/enviarFicha/$toten_fila_id/$item->paciente/$cpf/$item->medico_consulta_id/$item->medicoconsulta/$toten_sala_id/false";
                        } else {
                            $url_enviar_ficha = '';
                        }

                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
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
                            } elseif ($item->confirmado == 'f') {
                                $situacao = "agenda";
                                $verifica = 1;
                            } elseif ($item->situacaoexame == 'PENDENTE') {
                                $situacao = "pendente";
                                $verifica = 1;
                            } else {
//                                echo $item->situacaoexame;
                                $situacao = "espera";
                                $verifica = 3;
                            }
                        }
                        if ($item->paciente == "" && $item->bloqueado == 'f') {
                            $paciente = "vago";
                        }
                        ?>
                        <tr>
                            <? if ($verifica == 1) { ?>
                                <td class="<?php echo $estilo_linha; ?>"><b><?= $situacao; ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                            <? }if ($verifica == 2) { ?>
                                <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $situacao; ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $item->paciente; ?></b></td>
                            <? }if ($verifica == 3) { ?>
                                <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $situacao; ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->paciente; ?></b></td>
                            <? }if ($verifica == 4) { ?>
                                <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $situacao; ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->paciente; ?></b></td>
                            <? } if ($verifica == 5) { ?>
                                <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><?= $situacao; ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><?= $item->paciente; ?></b></td>
                            <? } ?>
                            <? if ($verifica == 4) { ?>
                                <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
                            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= $teste; ?></td>
                            <? } ?>
                            <? if ($item->convenio != '') { ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio_paciente; ?></td>
                            <? } ?>
                            <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?
                                if ($item->data_autorizacao != '') {
                                    echo date("H:i:s", strtotime($item->data_autorizacao));
                                }
                                ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="120px;"><?= $item->sala; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . " " . $item->agenda_exames_id; ?></td>
                            <? if ($item->situacaolaudo == 'FINALIZADO' || $item->situacaolaudo == 'REVISAR') { ?>
                                <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->situacaolaudo; ?></b></td>
                            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->situacaolaudo; ?></td>
                            <? } ?>
                            <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                        width=500,height=400');">=><?= $item->observacoes; ?></td>
                                <? if ($item->situacaolaudo != '' && $item->situacaoexame != 'PENDENTE') { ?>
                                    <?
                                    if (($item->medico_parecer1 == $operador_id && $item->situacaolaudo == 'FINALIZADO') || ($item->situacaolaudo != 'FINALIZADO' && $item->situacaolaudo != '') || $operador_id == 1) {
                                        if ($item->grupo == 'ECOCARDIOGRAMA') {
                                            ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarlaudoeco/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');" >
                                                    Laudo</a></div>
                                        </td>
                                        <?
                                    } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarlaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');" >
                                                    Laudo</a></div>
                                        </td>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="40px;"><font size="-2">
                                        <a>Bloqueado</a></font>
                                    </td>
                                <? }
                                ?>

                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                            Imprimir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo2via/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                            2º via</a></div>
                                </td>
                            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                    </font>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                    <a></a></font>
                                </td>
                                <? if ($item->paciente_id == '') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                        <div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexame/<?= $item->agenda_exames_id ?>');">Exame
                                            </a></div></font>
                                    </td>   
                                <? } elseif ($item->paciente_id != '' && $item->confirmado == 'f') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                        <div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/excluirconsultatempmedico/<?= $item->agenda_exames_id ?>');">Cancelar
                                            </a></div></font>
                                    </td>  
                                <? } else { ?>
                                    <? if ($verifica == 3) { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;" colspan="">
                                        <? if ($endereco != '') { ?>
                                                <div class="bt_link">
                                                    <a onclick="chamarPaciente('<?= $url_enviar_ficha ?>', <?= $toten_fila_id ?>, <?= $item->medico_consulta_id ?>, <?= $toten_sala_id ?>);" >Chamar</a>
                                                </div>  
                                            <?
                                        } else { ?>
                                                <div class="bt_link">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/chamarpacientesalaespera/<?= $item->agenda_exames_id ?>');" >Chamar</a>
                                                </div>  
                                            <?
                                        } ?>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;" colspan="">
                                            <div class="bt_link">
                                                <a target="_blank" onclick="javascript: return confirm('Deseja realmente confirmar o paciente?');" href="<?= base_url() ?>ambulatorio/exame/enviarsalaesperamedicoexame/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id; ?>/<?= $item->medico_consulta_id ?>">Confirmar</a>
                                            </div>
                                        </td>
                                    <? } else { ?>
                                        <td colspan="10" class="<?php echo $estilo_linha; ?>" width="70px;"></td> 
                                    <? } ?>

                                <? }
                                ?>

                            <? } ?>
                        </tr>

                    </tbody>
                    <?php
                }
//                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="15">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            <!-- Total de registros: <?php // echo $total;         ?> -->
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>-->

<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<style>
    #procedimento_chosen a { width: 130px; }
</style>
<script type="text/javascript">
                                                    // $(document).ready(function () {
//alert('teste_parada');

                                                        if ($('#especialidade').val() != '') {
                                                            $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $('#especialidade').val(), ajax: true}, function (j) {
                                                                var options = '<option value=""></option>';
                                                                var slt = '';
                                                                for (var c = 0; c < j.length; c++) {
                                                                    if (j[0].operador_id != undefined) {
                                                                        if (j[c].operador_id == '<?= @$_GET['medico'] ?>') {
                                                                            slt = 'selected';
                                                                        }
                                                                        options += '<option value="' + j[c].operador_id + '" ' + slt + '>' + j[c].nome + '</option>';
                                                                        slt = '';
                                                                    }
                                                                }
                                                                $('#medico').html(options).show();
                                                                $('.carregando').hide();



                                                            });
                                                        }

                                                        $(function () {
                                                            $('#especialidade').change(function () {

                                                                if ($(this).val()) {

//                                                  alert('teste_parada');
                                                                    $('.carregando').show();
//                                                        alert('teste_parada');
                                                                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $(this).val(), ajax: true}, function (j) {
                                                                        options = '<option value=""></option>';
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
                                                                        options = '<option value=""></option>';
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

                                                        $(function () {
                                                            $("#txtCICPrimariolabel").autocomplete({
                                                                source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
                                                                minLength: 3,
                                                                focus: function (event, ui) {
                                                                    $("#txtCICPrimariolabel").val(ui.item.label);
                                                                    return false;
                                                                },
                                                                select: function (event, ui) {
                                                                    $("#txtCICPrimariolabel").val(ui.item.value);
                                                                    $("#txtCICPrimario").val(ui.item.id);
                                                                    return false;
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

                                                            $("#procedimento").chosen({
                                                                width: '200%'
                                                            });
                                                        });

<? if (($endereco != '')) { ?>
  function chamarPaciente(url, toten_fila_id, medico_id, toten_sala_id) {
    //   alert(url);
      $.ajax({
          type: "POST",
          data: {teste: 'teste'},
          //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
          url: url,
          success: function (data) {
              //                console.log(data);
              //                    alert(data.id);
              $("#idChamada").val(data.id);

          },
          error: function (data) {
              console.log(data);
              //                alert('DEU MERDA');
          }
      });


      $.ajax({
          type: "POST",
          data: {teste: 'teste'},
          //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
          url: "<?= $endereco ?>/webService/telaChamado/proximo/" + medico_id + '/ '+ toten_fila_id +'/' + toten_sala_id,
          success: function (data) {

              alert('Operação efetuada com sucesso');


          },
          error: function (data) {
              console.log(data);
              alert('Erro ao chamar paciente');
          }
      });
      $.ajax({
          type: "POST",
          data: {teste: 'teste'},
          //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
          url: "<?= $endereco ?>/webService/telaChamado/cancelar/" + toten_fila_id,
          success: function (data) {

              //                            alert('Operação efetuada com sucesso');


          },
          error: function (data) {
              console.log(data);
              //                            alert('Erro ao chamar paciente');
          }
      });
  }

<? } ?>

//                                        setTimeout('delayReload()', 20000);
//                                        function delayReload()
//                                        {
//                                            if (navigator.userAgent.indexOf("MSIE") != -1) {
//                                                history.go(0);
//                                            } else {
//                                                window.location.reload();
//                                            }
//                                        }

                                                    // });
                                                    setInterval(function () {
                                                        window.location.reload();
                                                    }, 60000);


</script>
