
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Sala de Preparo</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $medicos = $this->operador_m->listarmedicos();
            $situacaocaixa = $this->exame->listarcaixaempresa();
//            var_dump($situacaocaixa);
//            die;
            ?>
            <table>
                <tr>
                    <th  colspan="2" class="tabela_title">Salas</th>
                    <th class="tabela_title">Nome</th>
                </tr>
                <tr>

                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarsalaspreparo">
                    <th colspan="2" class="tabela_title">
                        <select name="sala" id="sala" class="size2">
                            <option value="">TODAS</option>
                            <? foreach ($salas as $value) : ?>
                                <option value="<?= $value->exame_sala_id; ?>" <?
                                if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </th>
                    <th colspan="4" class="tabela_title">
                        <input type="text" name="nome" class="texto09" value="<?php echo @$_GET['nome']; ?>" />

                    </th>
                    <th colspan="2" class="tabela_title">
                        <button type="submit" id="enviar">Pesquisar</button>
                    </th>
                </form>
                </tr>
                <tr>
                    <th class="tabela_header">Ordem</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Idade</th>
                    <th class="tabela_header">Tempo</th>
                    <th class="tabela_header">Agenda</th>
                    <th class="tabela_header">Sala</th>
                    <th class="tabela_header">Procedimento</th>              
                    <th class="tabela_header">Obs.</th>
                    <th class="tabela_header" colspan="4"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarexamesalapreparo($_GET);
                $total = $consulta->count_all_results();
                $limit = 100;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $perfil_id = $this->session->userdata('perfil_id');
                        $lista = $this->exame->listarexamesalapreparo2($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
//                        echo '<pre>';
//                        var_dump($lista); die;
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_autorizacao;
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%H:%I:%S');
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->ordenador; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/examepacientedetalhes/<?= $item->paciente_id; ?>/<?= $item->procedimento_tuss_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id; ?>', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $item->paciente; ?></a></td>
                                <?
                                $idade = date("Y-m-d") - $item->nascimento;
                                ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= $idade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $teste; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?
                                    echo $item->sala;
                                    if (isset($item->numero_sessao)) {
                                        echo "<br> SESSAO: " . $item->numero_sessao . "/" . $item->qtde_sessao;
                                    }
                                    ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>

                                <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->observacoes; ?></b></td>

                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/enviarsalaatendimento/<?= $item->agenda_exames_id; ?>">Enviar

                                        </a></div>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/observacao/<?= $item->agenda_exames_id ?>/<?= $item->paciente; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=230');">Obs.
                                        </a></div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="12">
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
