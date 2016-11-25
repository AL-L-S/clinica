
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>cadastros/caixa/novasangria">
            Nova sangria
        </a>
    </div>
    <?
    $operador = $this->operador->listaradminitradores();
    ?>

    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Saida</a></h3>
        <div>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>cadastros/caixa/pesquisar3">
                    <tr>
                        <th class="tabela_title">Data Inicio</th>
                        <th class="tabela_title">Data Fim</th>
                        <th class="tabela_title">Nome</th>
                        <th class="tabela_title">Observacao</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <input type="text"  id="datainicio" alt="date" name="datainicio" class="size1"  value="<?php echo @$_GET['datainicio']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="datafim" alt="date" name="datafim" class="size1"  value="<?php echo @$_GET['datafim']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <select name="nome" id="nome" class="size2">
                                <option value="">TODOS</option>
                                <? foreach ($operador as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>" <?
                                    if (@$_GET['NOME'] == $value->operador_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->usuario; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="obs" name="obs" class="size2"  value="<?php echo @$_GET['obs']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                </form>
                </th>

                </tr>

                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header" width="90px;">Data</th>
                        <th class="tabela_header" width="90px;">Valor</th>
                        <th class="tabela_header">Caixa</th>
                        <th class="tabela_header">Observacao</th>
                        <th class="tabela_header">Status</th>
                        <th class="tabela_header" colspan="1">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->caixa->listarsangria($_GET);
                $total = $consulta->count_all_results();
                $limit = 50;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->caixa->listarsangria($_GET)->orderby('data desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->operador; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><b><?= number_format($item->valor, 2, ",", "."); ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->operador_caixa; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacao; ?></td>
                                <? if ($item->ativo == 'f') { ?>
                                    <td class="<?php echo $estilo_linha; ?>">CANCELADA</td>
                                    <td class="<?php echo $estilo_linha; ?>"></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>">REALIZADA</td>
                                    <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>cadastros/caixa/cancelarsangria/<?= $item->sangria_id ?>">Cancelar</a></div>
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
                        <th class="tabela_footer" colspan="7">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>

                    </tr>
                </tfoot>
            </table>
            <br>
            <br>

        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $("#datainicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $("#datafim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $("#accordion").accordion();
    });

</script>
