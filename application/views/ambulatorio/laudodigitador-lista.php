
<div class="content"> <!-- Inicio da DIV content -->
    <?
    $salas = $this->exame->listartodassalas();
    $medicos = $this->operador_m->listarmedicos();
    $empresa_id = $this->session->userdata('empresa_id');
    $data['empresa'] = $this->guia->listarempresa($empresa_id);
    $medico_laudodigitador = $data['empresa'][0]->medico_laudodigitador;
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Laudo Digitador</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form name="laudo_lista" id="laudo_lista" method="get" action="<?= base_url() ?>ambulatorio/laudo/pesquisardigitador">
                                <tr>
                                    <th class="tabela_title">Salas</th>
                                    <th class="tabela_title">Medico</th>
                                    <th class="tabela_title">Status</th>
                                    <th class="tabela_title">Data</th>
                                    <th class="tabela_title">Exame</th>
                                    <th class="tabela_title">Prontuario</th>
                                    <th colspan="2" class="tabela_title">Nome</th>
                                </tr>
                                <tr>
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
                                        <select name="medico" id="medico" class="size1">
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
                                        <select name="situacao" id="situacao" class="size1" >
                                            <option value='' ></option>
                                            <option value='AGUARDANDO' <? if (@$_GET['situacao'] == 'AGUARDANDO') echo 'selected'; ?>>AGUARDANDO</option>
                                            <option value='DIGITANDO' <? if (@$_GET['situacao'] == 'DIGITANDO') echo 'selected'; ?>>DIGITANDO</option>
                                            <option value='FINALIZADO' <? if (@$_GET['situacao'] == 'FINALIZADO') echo 'selected'; ?>>FINALIZADO</option>
                                        </select>
                                    </th>
                                    <th class="tabela_title">
                                        <input type="text"  id="data" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <input type="text"  id="exame_id" name="exame_id" class="size1"  value="<?php echo @$_GET['exame_id']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <input type="text"  id="paciente_id" name="paciente_id" class="size1"  value="<?php echo @$_GET['paciente_id']; ?>" />
                                    </th>
                                    <th colspan="2" class="tabela_title">
                                        <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <button type="submit" id="enviar">Pesquisar</button>
                                    </th>
                            </form>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" width="300px;">Nome</th>
                        <th class="tabela_header" width="30px;">Idade</th>
                        <th class="tabela_header" width="30px;">Data</th>
                        <th class="tabela_header" width="130px;">M&eacute;dico</th>
                        <th class="tabela_header">Status</th>
                        <th class="tabela_header" width="300px;">Procedimento</th>
<!--                            <th class="tabela_header">M&eacute;dico Revisor</th>
                        <th class="tabela_header">Status Revisor</th>-->
                        <th class="tabela_header" colspan="8" width="140px;"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->laudo->listardigitador($_GET, $medico_laudodigitador);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->laudo->listar2digitador($_GET, $medico_laudodigitador )->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_cadastro;
                            $operador_id = $this->session->userdata('operador_id');
                            $perfil_id = $this->session->userdata('perfil_id');
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%d');

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= $item->idade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="130px;"><?= substr($item->medico, 0, 18); ?></td>
                                <? if ($item->situacao != 'FINALIZADO') { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao; ?></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao . '<br>' . substr($item->data_atualizacao, 8, 2) . '/' . substr($item->data_atualizacao, 5, 2) . '/' . substr($item->data_atualizacao, 0, 4) . '<br>' . substr($item->data_atualizacao, 10, 8); ?></td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
        <!--                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->medicorevisor; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao_revisor; ?></td>-->
                                <? if (($item->medico_parecer1 == $operador_id && $item->situacao == 'FINALIZADO') || $item->situacao != 'FINALIZADO' || $operador_id == 1) { ?>

                                    <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarlaudodigitador/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');" >
                                                Laudo</a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/todoslaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>');" >
                                                TODOS</a></div>
                                    </td> 
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="40px;"><font size="-2">
                                        <a>Bloqueado</a></font>
                                    </td>
                                <? }
                                ?>
        <!--                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
                        <a href="<?= base_url() ?>ambulatorio/laudo/carregarrevisao/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>">
                            Revis&atilde;o</a>
                    </td>-->
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                            Imprimir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                            imagem</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <a href="<?= base_url() ?>ambulatorio/guia/impressaoetiiqueta/<?= $item->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Etiqueta</a></div>
                                </td>
                                <? if ($perfil_id == 1 || $operador_id == 4582) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/exame/examecancelamento/<?= $item->exames_id ?>/<?= $item->sala_id ?> /<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?> ">
                                                Cancelar
                                            </a></div>
                                    </td>
                                <? } ?>

                                <? if (((($item->medico_parecer1 == $operador_id && $item->situacao == 'FINALIZADO') || $item->situacao != 'FINALIZADO' || $operador_id == 1)) && @$_GET['exame_id'] != "") { ?>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $("body").keypress(function (event) {
                                        if (event.keyCode == 120)   // se a tecla apertada for 13 (enter)
                                        {
                                            window.open("<?= base_url() ?>ambulatorio/laudo/carregarlaudodigitador/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>"); // abre uma janela
                                                        }
                                                    });
                                                });

                            </script>

                        <? } ?>

                        <? if ($item->recebido == 'f') { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;"><a href="<?= base_url() ?>ambulatorio/guia/recebidoresultado/<?= $item->paciente_id; ?>/<?= $item->agenda_exames_id ?>">ENTREGAR
                                </a></td>
                        <? } else {
                            ?>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;"><center></center><?= $item->operadorrecebido . " - " . substr($item->data_recebido, 8, 2) . "/" . substr($item->data_recebido, 5, 2) . "/" . substr($item->data_recebido, 0, 4) ?></center>
                            </td>
                            <?
                        }
                        if ($item->entregue == "") {
                            ?>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/entregaexame/$item->paciente_id/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                    ENTREGUE
                                </a></td>
                        <? } else { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;"><center><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/vizualizarobservacao/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');"> SIM <br/> <?= substr($item->data_entregue, 8, 2) . "/" . substr($item->data_entregue, 5, 2) . "/" . substr($item->data_entregue, 0, 4) ?></a></center>
                            </td>
                        <? } ?></tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="14">
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

    document.laudo_lista.exame_id.focus()

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
