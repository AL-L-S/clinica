
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacientefisioterapiaencaixemedico');">
                        Encaixar Especialidade
                    </a>
                </div>
            </td>
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
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Multifuncao Especialidade</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $empresa = $this->guia->listarempresasaladeespera();
            @$ordem_chegada = @$empresa[0]->ordem_chegada;
            $medicos = $this->operador_m->listarmedicos();
            $especialidade = $this->exame->listarespecialidade();
            $perfil_id = $this->session->userdata('perfil_id');
            ?>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicofisioterapia">

                    <tr>
                        <th class="tabela_title">Salas</th>
                        <? if ($perfil_id != 4) { ?>
                            <th class="tabela_title">Especialidade</th>
                            <th class="tabela_title">Medico</th>
                        <? } ?>
                        <th class="tabela_title">Situação</th>
                        <th class="tabela_title">Data</th>
                        <th colspan="1" class="tabela_title">Nome</th>
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
                            <th class="tabela_title">
                                <select name="especialidade" id="especialidade" class="size1">
                                    <option value=""></option>
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
                            <select name="situacao" id="situacao" class="size1">
                                <option value=""></option>
                                <option value="BLOQUEADO" <?
                                if (@$_GET['situacao'] == "BLOQUEADO") {
                                    echo 'selected';
                                }
                                ?>>BLOQUEADO</option>
                                <option value="FALTOU" <?
                                if (@$_GET['situacao'] == "FALTOU") {
                                    echo 'selected';
                                }
                                ?>>FALTOU</option>
                                <option value="OK" <?
                                if (@$_GET['situacao'] == "OK") {
                                    echo 'selected';
                                }
                                ?>>OCUPADO</option>
                                <option value="LIVRE" <?
                                if (@$_GET['situacao'] == "LIVRE") {
                                    echo 'selected';
                                }
                                ?>>VAGO</option>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
                        <th colspan="1" class="tabela_title">
                            <input type="text" name="nome" class="texto03 bestupper" value="<?php echo @$_GET['nome']; ?>" />

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
                        <th class="tabela_header" width="400px;">Nome</th>
                        <th class="tabela_header"></th>
                        <th class="tabela_header" width="250px;">Telefone</th>
                        <th class="tabela_header" width="250px;">Tempo</th>
                        <th class="tabela_header" width="60px;">Convenio</th>
                        <th class="tabela_header" width="60px;">Agenda</th>
                        <th class="tabela_header" width="60px;;">Autorização</th>
                        <th class="tabela_header" width="250px;">Procedimento</th>
                        <th class="tabela_header">Observações</th>
                        <th class="tabela_header" colspan="5"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarmultifuncaofisioterapia($_GET);
                $total = $consulta->count_all_results();
                $limit = 100;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->exame->listarmultifuncao2fisioterapia($_GET, @$ordem_chegada)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        $operador_id = $this->session->userdata('operador_id');
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_autorizacao;
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%H:%I:%S');

                            $verifica = 0;

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            if (($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') && $item->situacaoexame != "PENDENTE") {
                                $situacao = "Aguardando";
                                $verifica = 2;
                            } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                                $situacao = "Finalizado";
                                $verifica = 4;
                            } elseif ($item->confirmado == 'f') {
                                $situacao = "agenda";
                                $verifica = 1;
                            } elseif ($item->situacaoexame == 'PENDENTE') {
                                $situacao = "pendente";
                                $verifica = 1;
                            } else {
                                $situacao = "espera";
                                $verifica = 3;
                            }
                            ?>
                            <tr>
                                <? if ($verifica == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $situacao; ?></td>
                                <? }if ($verifica == 2) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $situacao; ?></b></td>
                                <? }if ($verifica == 3) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $situacao; ?></b></td>
                                <? }if ($verifica == 4) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $situacao; ?></b></td>
                                <? } ?>
                                <? if ($verifica == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <? }if ($verifica == 2) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $item->paciente; ?></b></td>
                                <? }if ($verifica == 3) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->paciente; ?></b></td>
                                <? }if ($verifica == 4) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->paciente; ?></b></td>
                                <? } ?>
                        <style>
                            .vermelho{
                                color: red;
                            }
                        </style>
                        <td class="<?php echo $estilo_linha; ?>"><?
                            if ($item->encaixe == 't') {
                                if ($item->paciente == '') {
                                    echo '<span class="vermelho">Encaixe H.</span>';
                                } else {
                                    echo '<span class="vermelho">Encaixe</span>';
                                }
                            }
                            ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->celular; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $teste; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)) . " " . $item->inicio; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?
                            if ($item->data_autorizacao != '') {
                                echo date("H:i:s", strtotime($item->data_autorizacao));
                            }
                            ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                                                            width=500,height=230');">=><?= $item->observacoes; ?></td>
<!--                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                <a href="<?= base_url() ?>ambulatorio/exame/anexarimagem/">
                                    Chamar
                                </a></div>
                        </td>-->
                        <!--<td class="<?php echo $estilo_linha; ?>"></td>-->
                        <!--<td class="<?php echo $estilo_linha; ?>"></td>-->
                        <? if ($item->confirmado == 't' && $item->situacaoexame != 'PENDENTE') { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="70px;">
                            </td>
                            <?
                            if (($item->medico_parecer1 == $operador_id && $item->situacao == 'FINALIZADO') || $item->situacao != 'FINALIZADO' && $item->realizada == 't' || $operador_id == 3) {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaranaminese/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');" >
                                            Atender</a></div>
                                </td>
                            <? } else { ?>
<!--                                <td class="<?php echo $estilo_linha; ?>" width="40px;"><font size="-2">
                                    <a>Bloqueado</a></font>
                                </td>-->
                            <? } ?>

                        <?php } if (($item->medico_parecer1 == $operador_id && $item->situacao == 'FINALIZADO') || $item->situacao != 'FINALIZADO' && $item->realizada == 't' || $operador_id == 3) { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $item->ambulatorio_laudo_id ?>');">
                                        Arquivos</a></div>
                            </td>


                        <!--                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                               <a href="<?= base_url() ?>ambulatorio/laudo/chamarpaciente/<?= $item->ambulatorio_laudo_id ?> ">
                               Chamar</a></div>
                        </td>-->
                            <? if (($operador_id == 1 || $perfil_id == 1) && $item->realizada == 't') { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <? if ($item->encaixe == 't') { ?>
                                        <div class="bt_link">
                                            <a onclick="javascript: return confirm('Deseja realmente cancelar o encaixe?\n\nObs: Irá excluir também o horário');" href="<?= base_url() ?>ambulatorio/exametemp/examecancelamentoencaixe/<?= $item->agenda_exames_id; ?>">
                                                Cancelar</a></div>

                                    <? } else { ?>
                                        <div class="bt_link"><a href="<?= base_url() ?>ambulatorio/exame/examecancelamento/<?= $item->exame_id ?>/<?= $item->agenda_exames_nome_id ?> /<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?> ">
                                                Cancelar
                                            </a></div>
                                    <? } ?>
                                </td>
                            <? } elseif (($operador_id == 1 || $perfil_id == 1) && $item->realizada == 'f') { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <? if ($item->encaixe == 't') {
                                        ?> 

                                        <div class="bt_link">
                                            <a onclick="javascript: return confirm('Deseja realmente cancelar o encaixe?\n\nObs: Irá excluir também o horário');" href="<?= base_url() ?>ambulatorio/exametemp/examecancelamentoencaixe/<?= $item->agenda_exames_id; ?>">
                                                Cancelar</a></div>

                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/exame/esperacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?> ">
                                                Cancelar
                                            </a></div>
                                    <? } ?>
                                </td>
                            <? } ?>

                        <? } else { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                <font size="-2"><a></a></font>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                <a></a></font>
                            </td>

                            <? if ($item->paciente_id == "" && $item->bloqueado == 'f') { ?>
                                                                                                                <!--                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><font size="-2">
                                                                                                                                                            <a></a></font>
                                                                                                                                                        </td>-->
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Bloquear
                                        </a></div>
                                </td>


                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarfisioterapiatempmedico/<?= $item->agenda_exames_id ?>');">Consultas
                                        </a></div>
                                </td>


                            <? } elseif ($item->bloqueado == 't') { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
                                        </a></div>
                                </td>
                            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                    <a></a></font>
                                </td>
                                <!--<td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">-->

                                <?
                                if (($perfil_id == 4) || $perfil_id == 1) {
                                    if ($item->encaixe == 't') {
                                        ?>      <td  class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                            <div class="bt_link">
                                                <a onclick="javascript: return confirm('Deseja realmente cancelar o encaixe?\n\nObs: Irá excluir também o horário');" href="<?= base_url() ?>ambulatorio/exametemp/examecancelamentoencaixe/<?= $item->agenda_exames_id; ?>">
                                                    Cancelar</a></div>
                                        </td>
                                    <? } elseif (($operador_id == 3 || $perfil_id == 1) && $verifica != 3) { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                            <div class="bt_link">
                                                <a onclick="javascript: return confirm('Deseja realmente cancelar esse horario?');" href="<?= base_url() ?>ambulatorio/exametemp/excluirfisioterapiatempmultifuncaomedico/<?= $item->agenda_exames_id; ?>">
                                                    Cancelar</a></div>
                                        </td>
                                    <? }else{?>
                                        
                                    <?} ?>

                                <? } ?></font>
                                </td>

                            <? } ?>
                        <? } ?>
                        </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="16">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<script type="text/javascript">
                            $(document).ready(function () {
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
                                });

//                                        setTimeout('delayReload()', 20000);
//                                        function delayReload()
//                                        {
//                                            if (navigator.userAgent.indexOf("MSIE") != -1) {
//                                                history.go(0);
//                                            } else {
//                                                window.location.reload();
//                                            }
//                                        }

                            });

                            setInterval(function () {
                                window.location.reload();
                            }, 60000);

</script>
