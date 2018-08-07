
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>internacao/internacao/carregarfichaquestionario/0">
            Novo Pré-Cadastro
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Pré-Cadastro</a></h3>
        <div>

            <table>
                <form method="get" action="<?= base_url() ?>internacao/internacao/manterfichaquestionario">
                    <thead>
                        <tr>
                            <th colspan="1" class="tabela_title">
                                Nome
                            </th>
                            <th colspan="1" class="tabela_title">
                                Data Inicio
                            </th>
                            <th colspan="1" class="tabela_title">
                                Data Fim
                            </th>
                            <th colspan="1" class="tabela_title">
                                Ligação Confirmada
                            </th>
                            <th colspan="1" class="tabela_title">
                                Aprovado
                            </th>

                        </tr>
                        <tr>
                            <th colspan="1" class="tabela_title">

                                <input name="nome" type="text" class="texto05" value="<?= @$_GET['nome'] ?>">
                                <!--<button type="submit" id="enviar">Pesquisar</button>-->

                            </th>
                            <th colspan="1" class="tabela_title">

                                <input name="data_inicio" id="data_inicio" type="text" class="texto02" value="<?= @$_GET['data_inicio'] ?>">
                                <!--<button type="submit" id="enviar">Pesquisar</button>-->

                            </th>
                            <th colspan="1" class="tabela_title">

                                <input name="data_fim" id="data_fim" type="text" class="texto02" value="<?= @$_GET['data_fim'] ?>">
                                <!--<button type="submit" id="enviar">Pesquisar</button>-->

                            </th>
                            <th colspan="1" class="tabela_title">

                                <select id="confirmado" name="confirmado"  class="texto02" >
                                    <option value="">
                                        Selecione
                                    </option>
                                    <option value="t" <?= (@$_GET['confirmado'] == 't') ? 'selected' : ''; ?>>
                                        Sim
                                    </option>
                                    <option value="f" <?= (@$_GET['confirmado'] == 'f') ? 'selected' : ''; ?>>
                                        Não
                                    </option>
                                </select>
                                <!--<button type="submit" id="enviar">Pesquisar</button>-->

                            </th>
                            <th colspan="1" class="tabela_title">

                                <select id="aprovado" name="aprovado"  class="texto03" >
                                    <option value="">
                                        Selecione
                                    </option>
                                    <option value="t" <?= (@$_GET['aprovado'] == 't') ? 'selected' : ''; ?>>
                                        Sim
                                    </option>
                                    <option value="f" <?= (@$_GET['aprovado'] == 'f') ? 'selected' : ''; ?>>
                                        Não
                                    </option>
                                </select>


                            </th>
                            <th>
                                <button type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>
                        </table>
                    <table>
                        <tr>
                            <th class="tabela_header">Nome Paciente</th>
                            <th class="tabela_header">Nome Responsável</th>
                            <th class="tabela_header">Operador Cadastro</th>
                            <!--<th class="tabela_header">Observação</th>-->

                            <th class="tabela_header">Data/Hora</th>
                            <th class="tabela_header">Ligação</th>
                            <th class="tabela_header">Aprovação</th>
                            <!--<th class="tabela_header">Raz&atilde;o social</th>-->
                            <th class="tabela_header" colspan="5"><center>Detalhes</center></th>
                        </tr>
                        </thead>

                </form>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->internacao_m->listarfichaquestionario($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->internacao_m->listarfichaquestionario($_GET)->limit($limit, $pagina)->orderby("if.data_cadastro desc")->get()->result();
                        $estilo_linha = "tabela_content01";
//                        echo '<pre>';
//                        var_dump($lista);
//                        die;
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>

                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->operador; ?></td>
                                <!--<td class="<?php echo $estilo_linha; ?>"><a style="color: red" href="<?= base_url() ?>internacao/internacao/observacaoprecadastro/<?= $item->internacao_ficha_questionario_id; ?>" target="_blank"><?= substr($item->observacao, 0, 15); ?></a></td>-->
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i:s", strtotime($item->data_cadastro)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= ($item->confirmado == 't' ? 'Efetuada' : 'Não-Efetuada'); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= ($item->aprovado == 't' ? 'Aprovado' : 'Não-Aprovado'); ?></td>

                                <td class="<?php echo $estilo_linha; ?>" style="width: 80px;">
                                    <? if ($item->confirmado == 'f') { ?>
                                        <div class="bt_link">
                                            <a onclick="javascript:return confirm('Deseja confirmar a ligação?');" href="<?= base_url() ?>internacao/internacao/confirmarligacaofichaquestionario/<?= $item->internacao_ficha_questionario_id; ?>">Ligação</a>
                                        </div>
                                    <? } else { ?>
                                        <div class="bt_link">
                                            <a onclick="javascript:return confirm('Deseja retirar a confirmação de ligação?');" href="<?= base_url() ?>internacao/internacao/desconfirmarligacaofichaquestionario/<?= $item->internacao_ficha_questionario_id; ?>">Ligação</a>
                                        </div>
                                    <? } ?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" style="width: 80px;">
                                    <? //if($item->aprovado == 'f'){?>
                                    <div class="bt_link">
                                        <a onclick="javascript:return confirm('Deseja aprovar o Pré-Cadastro?');" href="<?= base_url() ?>internacao/internacao/confirmaraprovacaofichaquestionario/<?= $item->internacao_ficha_questionario_id; ?>/<?= $item->paciente_id; ?>">Aprovar</a>
                                    </div>
                                    <? //}?>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>" style="width: 50px;"><div class="bt_link">
                                        <a target="_blank" href="<?= base_url() ?>internacao/internacao/observacaoprecadastro/<?= $item->internacao_ficha_questionario_id; ?>">Obs.</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" style="width: 70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>internacao/internacao/carregarfichaquestionario/<?= $item->internacao_ficha_questionario_id; ?>">Editar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" style="width: 70px;"><div class="bt_link">
                                        <a onclick="javascript:return confirm('Deseja realmente excluir esse pré-cadastro?');" href="<?= base_url() ?>internacao/internacao/excluirfichaquestionario/<?= $item->internacao_ficha_questionario_id; ?>">Excluir</a></div>
                                </td>
                                <?
                                $perfil_id = $this->session->userdata('perfil_id');
                                $operador_id = $this->session->userdata('operador_id');
                                if ($perfil_id == 1):
                                    ?>

                                <? endif; ?>
                                <?
//                                $perfil_id = $this->session->userdata('perfil_id');
                                if ($operador_id == 1):
                                    ?>

                                <? endif; ?>
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
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
    $(function () {
        $("#data_inicio").datepicker({
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
        $("#data_fim").datepicker({
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
