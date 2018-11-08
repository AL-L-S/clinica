<?
$empresa_id = $this->session->userdata('empresa_id');
$data['empresa'] = $this->empresa->listarempresatoten($empresa_id);
@$endereco = $data['empresa'][0]->endereco_toten;
?>
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>

            <td>  
                <div class="bt_link_new">
                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/agenda/medicoagendageral');">
                        Bloquear Agenda
                    </a>
                </div>
            </td>
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Multifuncao Medico Geral</a></h3>

        <div>

            <?
            $salas = $this->exame->listartodassalas();
            $empresa = $this->guia->listarempresasaladeespera();
            @$ordem_chegada = @$empresa[0]->ordem_chegada;
            @$ordenacao_situacao = @$empresa[0]->ordenacao_situacao;
            $medicos = $this->operador_m->listarmedicos();
            $perfil_id = $this->session->userdata('perfil_id');
            ?>

            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicogeral">

                    <tr>
                        <th class="tabela_title">Salas</th>
                        <? if ($perfil_id != 4) { ?>
                            <th class="tabela_title">Medico</th>
                        <? } ?>
                        <th class="tabela_title">Situação</th>
                        <th colspan="1" class="tabela_title">Status</th>
                        <th class="tabela_title">Data</th>
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

                            <th class="tabela_title">
                                <select name="medico" id="medico" class="size2">
                                    <option value=""> </option>
                                    <? foreach ($medicos as $value) : ?>
                                        <option value="<?= $value->operador_id; ?>" <?
                                        if (@$_GET['medico'] == $value->operador_id):echo 'selected';
                                        endif;
                                        ?>><?php echo $value->nome; ?></option>
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
                            <select name="status" id="status" class="size1">
                                <option value=""></option>
                                <option value="AGENDADO" <?
                                if (@$_GET['status'] == "AGENDADO") {
                                    echo 'selected';
                                }
                                ?>>AGENDADO</option>
                                <option value="AGUARDANDO" <?
                                if (@$_GET['status'] == "AGUARDANDO") {
                                    echo 'selected';
                                }
                                ?>>AGUARDANDO</option>
                                <option value="ATENDIDO" <?
                                if (@$_GET['status'] == "ATENDIDO") {
                                    echo 'selected';
                                }
                                ?>>ATENDIDO</option>
                                
                                <option value="ESPERA" <?
                                if (@$_GET['status'] == "ESPERA") {
                                    echo 'selected';
                                }
                                ?>>ESPERA</option>
                                
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
                        <th colspan="1" class="tabela_title">
                            <input type="text" name="nome" class="texto03 bestupper" value="<?php echo @$_GET['nome']; ?>" />

                        </th>
                        <th colspan="1" class="tabela_title">
                            <input type="text" name="txtprocedimento" class="texto03 bestupper" value="<?php echo @$_GET['txtprocedimento']; ?>" />

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
            <?
            $listas = $this->exame->listarmultifuncao2geral($_GET, $ordem_chegada)->get()->result();
            $aguardando = 0;
            $espera = 0;
            $finalizado = 0;
            $agenda = 0;
            foreach ($listas as $item) {
                if ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') {
                    $aguardando = $aguardando + 1;
                } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                    $finalizado = $finalizado + 1;
                } elseif ($item->confirmado == 'f') {
                    $agenda = $agenda + 1;
                } else {
                    $espera = $espera + 1;
                }
            }
            ?>
            <table>
                <thead>
                    <tr><th width="1100px;">&nbsp;</th><th class="tabela_header">Aguardando</th><th class="tabela_header"><?= $aguardando; ?></th></tr>
                    <tr><th>&nbsp;</th><th class="tabela_header">Espera</th><th class="tabela_header"><?= $espera; ?></th></tr>
                    <tr><th>&nbsp;</th><th class="tabela_header">Agendado</th><th class="tabela_header"><?= $agenda; ?></th></tr>
                    <tr><th>&nbsp;</th><th class="tabela_header">Atendido</th><th class="tabela_header"><?= $finalizado; ?></th></tr>
                    <tr><th>&nbsp;</th><th ></th><th ></th></tr>
                </thead>
            </table>

            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" width="100px;">Ordem</th>
                        <th class="tabela_header" >Status</th>
                        <th class="tabela_header" width="250px;">Nome</th>
                        <th class="tabela_header" width="100px;">Idade</th>
                        <th class="tabela_header" width="60px;">Espera</th>
                        <th class="tabela_header" width="100px;">Convenio</th>
                        <th class="tabela_header" width="80px;">Agenda</th>
                        <th class="tabela_header" width="250px;">Autorização</th>
                        <th class="tabela_header" width="250px;">Procedimento</th>
                        <th class="tabela_header">OBS</th>
                        <th class="tabela_header" colspan="8"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                $limit = 100;
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $lista = $this->exame->listarmultifuncao2geral($_GET, $ordem_chegada, $ordenacao_situacao)->limit($limit, $pagina)->get()->result();
                $total = count($lista);

//                echo "<pre>";
//                var_dump($lista); die;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
//                        $lista = $this->exame->listarmultifuncao2geral($_GET, $ordem_chegada)->limit($limit, $pagina)->get()->result();
//                        echo '<pre>';
                        $estilo_linha = "tabela_content01";
                        $operador_id = $this->session->userdata('operador_id');

                        foreach ($lista as $item) {
//                        var_dump($item->status); die;
                            $dataFuturo2 = date("Y-m-d");
                            $dataAtual2 = $item->nascimento;
                            $date_time2 = new DateTime($dataAtual2);
                            $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                            $teste2 = $diff2->format('%Ya %mm %dd');

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
//                            var_dump($endereco);
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
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
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"></td>
                                <? if ($verifica == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font <? ?>><b><?= $situacao; ?></b></td>
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
                                    <td class="<?php echo $estilo_linha; ?>"><?= $teste2; ?></td>
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
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)) . " " . $item->inicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?
                                    if ($item->data_autorizacao != '') {
                                        echo date("H:i:s", strtotime($item->data_autorizacao));
                                    }
                                    ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
        <!--                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                        <a href="<?= base_url() ?>ambulatorio/exame/anexarimagem/">
                                            Chamar
                                        </a></div>
                                </td>-->
                                <? if ($item->situacaolaudo != '') { ?>
                                    <?
                                    if (($item->medico_parecer1 == $operador_id && $item->situacaolaudo == 'FINALIZADO') || ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') || $operador_id == 1) {
                                        if ($item->tipo == 'EXAME') {
                                            if ($item->tipo == 'ECOCARDIOGRAMA') {
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
                                        } elseif ($item->tipo == 'CONSULTA') {
                                            ?>        

                                            <td class="<?php echo $estilo_linha; ?>" width="40px;">
                                                <?
                                                if ($verifica != 1) {
//                                                
                                                    ?>
                                                    <div class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaranaminese/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->situacaoexame == 'f' ?>');" >
                                                            Atender</a></div>
                                                </td>
                                                <?
                                            }
                                        } else {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="40px;">
                                                <div class="bt_link">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaranaminese/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->situacaoexame == 'f' ?>');" >
                                                        Atender</a></div>
                                            </td>  
                                            <?
                                        }
                                    } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><font size="-2">
                                            <a>Bloqueado</a></font>
                                        </td>
                                    <? } ?>

                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                                Imprimir</a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        <?
                                        if ($verifica != 1) {
//                                                
                                            ?>
                                            <div class="bt_link">

                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $item->ambulatorio_laudo_id ?>');">
                                                    Arquivos</a></div>
                                        <? } ?>
                                    </td>
                                    <? if ($perfil_id == 1) { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                                <a target="_blank" href="<?= base_url() ?>ambulatorio/exame/examecancelamentogeral/<?= $item->exames_id ?>/<?= $item->sala_id ?>/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?> ">
                                                    Cancelar
                                                </a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2"><a></a></font></td>
                                    <? } ?>


                                                                                    <!--                                                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                                                                                                                                        <a></a></font>
                                                                                                                                                    </td>
                                                                                                                                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                                                                                                                                        <a></a></font>
                                                                                                                                                    </td>-->


                                                                                                                        <!--                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $item->ambulatorio_laudo_id ?>');">
                                                                                                                                                                            Arquivos</a></div>-->
                                <? } else {
                                    ?>
                                    <!--</td>-->


                                    <? if ($verifica == 3) { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;" colspan="">
                                            <? if ($endereco != '') { ?>
                                                <div class="bt_link">
                                                    <a onclick="chamarPaciente('<?= $url_enviar_ficha ?>', <?= $toten_fila_id ?>, <?= $item->medico_consulta_id ?>, <?= $toten_sala_id ?>);" >Chamar</a>
                                                </div>  
                                            <? } else { ?>
                                                <div class="bt_link">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/chamarpacientesalaespera/<?= $item->agenda_exames_id ?>');" >Chamar</a>
                                                </div>  
                                            <? } ?>

                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;" colspan="">
                                            <div class="bt_link">
                                                <a target="_blank" onclick="javascript: return confirm('Deseja realmente confirmar o paciente?');" href="<?= base_url() ?>ambulatorio/exame/enviarsalaesperamedico/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id; ?>/<?= $item->medico_consulta_id ?>">Confirmar</a>
                                            </div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;" colspan="8"><font size="-2">
                                            <a></a></font>
                                        </td>                                            
                                    <? } ?>
            <!--                                            <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                    <a></a></font>
                </td>
                <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                    <a></a></font>
                </td>
                <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                    <a></a></font>
                </td>
                <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                    <a></a></font>
                </td>-->

                                    <?
                                }
                            }
                            ?>
                        <!--                            <td class="<?php // echo $estilo_linha;           ?>" width="70px;"><font size="-2">
                                                        <a></a></font>
                                                    </td>
                                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2"><a></a></font></td>
                                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2"><a></a></font></td>-->
                        <? } ?>
                    </tr>

                </tbody>
                <tfoot>
                    <tr>

                        <th class="tabela_footer" colspan="12">
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>    
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

//              alert('teste_parada');
                                                    $('.carregando').show();
//                    alert('teste_parada');
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
//                    alert('teste_parada');
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

                                        setTimeout('delayReload()', 20000);
                                        function delayReload()
                                        {
                                            if (navigator.userAgent.indexOf("MSIE") != -1) {
                                                history.go(0);
                                            } else {
                                                window.location.reload();
                                            }
                                        }

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

                                                }
                                            });


                                            $.ajax({
                                                type: "POST",
                                                data: {teste: 'teste'},
                                                //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
                                                url: "<?= $endereco ?>/webService/telaChamado/proximo/" + medico_id + '/ ' + toten_fila_id + '/' + toten_sala_id,
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
</script>

<?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
