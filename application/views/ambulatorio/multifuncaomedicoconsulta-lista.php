
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Multifuncao Medico Consulta</a></h3>

        <div>

            <?
            $salas = $this->exame->listartodassalas();
            $medicos = $this->operador_m->listarmedicos();
            ?>

            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoconsulta">

                    <tr>
                        <th class="tabela_title">Salas</th>
                        <th class="tabela_title">Medico</th>
                        <th class="tabela_title">Data</th>
                        <th colspan="2" class="tabela_title">Nome</th>

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
                        <th class="tabela_title">
                            <select name="medico" id="medico" class="size2">
                                <option value=""></option>
                                <? foreach ($medicos as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>" <?
                                    if (@$_GET['medico'] == $value->operador_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
                        <th colspan="3" class="tabela_title">
                            <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        <th colspan="3" class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>


                    </tr>
                </form>
                </thead>
            </table>
            <?
            $listas = $this->exame->listarmultifuncao2consulta($_GET)->get()->result();
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
                        <th class="tabela_header" >Status</th>
                        <th class="tabela_header" width="250px;">Nome</th>
                        <th class="tabela_header" width="250px;">Espera</th>
                        <th class="tabela_header" width="60px;">Convenio</th>
                        <th class="tabela_header" width="60px;">Data</th>                        
                        <th class="tabela_header" width="60px;">Agenda</th>
                        <th class="tabela_header" width="250px;">Procedimento</th>
                        <th class="tabela_header">OBS</th>
                        <th class="tabela_header" colspan="2"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarmultifuncaoconsulta($_GET);
                $total = $consulta->count_all_results();
                $limit = 100;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->exame->listarmultifuncao2consulta($_GET)->limit($limit, $pagina)->get()->result();
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
                            if ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') {
                                $situacao = "Aguardando";
                                $verifica = 2;
                            } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                                $situacao = "Finalizado";
                                $verifica = 4;
                            } elseif ($item->confirmado == 'f') {
                                $situacao = "agenda";
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
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
        <!--                                <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                        <a href="<?= base_url() ?>ambulatorio/exame/anexarimagem/">
                                            Chamar
                                        </a></div>
                                </td>-->
                                <? if ($item->situacaolaudo != '') { ?>
                                    <? if (($item->medico_parecer1 == $operador_id && $item->situacaolaudo == 'FINALIZADO') || ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') || $operador_id == 1) { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaranaminese/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');" >
                                                    Atender</a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><font size="-2">
                                            <a>Bloqueado</a></font>
                                        </td>
                                    <? } ?>


                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $item->ambulatorio_laudo_id ?>');">
                                                Arquivos</a></div>
                                    </td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                        <a></a></font>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><font size="-2">
                                        <a></a></font>
                                    </td>

                                <? } ?>

                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="11">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">
    setTimeout('delayReload()', 20000);
    function delayReload()
    {
        if (navigator.userAgent.indexOf("MSIE") != -1) {
            history.go(0);
        } else {
            window.location.reload();
        }
    }


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

</script>
