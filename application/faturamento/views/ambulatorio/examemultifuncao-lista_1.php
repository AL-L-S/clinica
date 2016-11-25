
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Multifuncao Exame Recep&ccedil;&atilde;o</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            ?>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncao">

                    <tr>
                        <th class="tabela_title">Salas</th>
                        <th class="tabela_title">SITUA&Ccedil;&Atilde;O</th>
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
                            <select name="situacao" id="situacao" class="size2">
                                <option value=""></option>
                                <option value="LIVRE">VAGO</option>
                                <option value="OK">OCUPADO</option>
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
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" width="250px;">Nome</th>
                        <th class="tabela_header" width="70px;">Resp.</th>
                        <th class="tabela_header" width="70px;">Agenda</th>
                        <th class="tabela_header" width="150px;">Sala</th>
                        <th class="tabela_header">Telefone</th>
                        <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                        <th class="tabela_header" colspan="3"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarexamemultifuncao($_GET);
                $total = $consulta->count_all_results();
                $limit = 15;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;


                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->exame->listarexamemultifuncao2($_GET)->limit($limit, $pagina)->get()->result();
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
                            if ($item->paciente == "" && $item->bloqueado == 't') {
                                $paciente = "Bloqueado";
                                $verifica = 1;
                            } elseif ($item->paciente == "" && $item->bloqueado == 'f') {
                                $paciente = "vago";
                                $verifica = 2;
                            } else {
                                $paciente = $item->paciente;
                                $verifica = 3;
                            }
                            ?>
                            <tr>
                                <? if ($verifica == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $paciente; ?></b></td>
                                <? }if ($verifica == 2) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $paciente; ?></b></td>
                                <? }if ($verifica == 3) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $paciente; ?></td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->secretaria, 0, 15); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="150px;"><?= $item->sala . " - " . substr($item->medicoagenda, 0, 15); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $telefone; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                                <? if ($item->paciente_id == "" && $item->bloqueado == 'f') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarexame/<?= $item->agenda_exames_id ?>');">Consultas
                                            </a></div>
                                    </td>
                                <? } elseif ($item->bloqueado == 'f') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarpacientetemp/<?= $item->paciente_id ?>');">Consultas
                                            </a></div>
                                    </td>
                                <? } elseif ($item->bloqueado == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                                <?
                                }
                                if ($paciente == "Bloqueado" || $paciente == "vago") {
                                    if ($item->bloqueado == 'f') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ','toolbar=no,Location=no,menubar=no,width=500,height=200');">Bloquear
                                                </a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ','toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
                                                </a></div>
                                        </td>
                                    <? }
                                } else {
                                    ?>
                                    <? if ($item->telefonema == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">Confirmado</td>
            <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/telefonema/<?= $item->agenda_exames_id ?>/<?= $paciente; ?> ','toolbar=no,Location=no,menubar=no,width=500,height=200');">Confirma
                                                </a></div>
                                        </td>
                                    <? }
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
                        <th class="tabela_footer" colspan="8">
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

    $(function() {
        $( "#data" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
