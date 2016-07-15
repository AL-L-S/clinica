
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>cadastros/caixa/novasaida">
                        Nova saida
                    </a>
                </div>

            </td>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>cadastros/caixa/transferencia">
                        Transferencia
                    </a>
                </div>

            </td>
        </tr>
    </table>


    <?
    $saldo = $this->caixa->saldo();
    $empresa = $this->caixa->empresa();
    $conta = $this->forma->listarforma();
    $tipo = $this->tipo->listartipo();
    ?>

    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Saida</a></h3>
        <div>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>cadastros/caixa/pesquisar2">
                    <tr>
                        <th class="tabela_title">Conta</th>
                        <th class="tabela_title">Data Inicio</th>
                        <th class="tabela_title">Data Fim</th>
                        <th class="tabela_title">Tipo</th>
                        <th class="tabela_title">Empresa</th>
                        <th class="tabela_title">Observacao</th>
                    </tr>

                    <tr>
                        <th class="tabela_title">
                            <select name="conta" id="conta" class="size2">
                                <option value="">TODAS</option>
                                <? foreach ($conta as $value) : ?>
                                    <option value="<?= $value->forma_entradas_saida_id; ?>" <?
                                    if (@$_GET['conta'] == $value->forma_entradas_saida_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->descricao; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="datainicio" alt="date" name="datainicio" class="size1"  value="<?php echo @$_GET['datainicio']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="datafim" alt="date" name="datafim" class="size1"  value="<?php echo @$_GET['datafim']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <select name="nome" id="nome" class="size2">
                                <option value="">TODOS</option>
                                <? foreach ($tipo as $value) : ?>
                                    <option value="<?= $value->descricao; ?>" <?
                                    if (@$_GET['NOME'] == $value->descricao):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->descricao; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="empresa" id="empresa" class="size1">
                                <option value="">TODOS</option>
                                <? foreach ($empresa as $value) : ?>
                                    <option value="<?= $value->financeiro_credor_devedor_id; ?>" <?
                                    if (@$_GET['empresa'] == $value->financeiro_credor_devedor_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->razao_social; ?></option>
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
                <tr>

                    <th class="tabela_title">Saldo Total em Caixa:  <?= number_format($saldo[0]->sum, 2, ",", ".") ?></th>
                </tr>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Tipo</th>
                        <th class="tabela_header" width="90px;">Dt saida</th>
                        <th class="tabela_header" width="90px;">Valor</th>
                        <th class="tabela_header">Conta</th>
                        <th class="tabela_header">Observacao</th>
                        <th class="tabela_header" colspan="2">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->caixa->listarsaida($_GET);
                $total = $consulta->count_all_results();
                $limit = 50;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $totaldalista = 0;
                        $lista = $this->caixa->listarsaida($_GET)->orderby('data desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            $totaldalista = $totaldalista + $item->valor;
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->razao_social; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><b><?= number_format($item->valor, 2, ",", "."); ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->conta; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacao; ?></td>


                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/caixa/carregar/<?= $item->saidas_id ?>">Editar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/caixa/excluirsaida/<?= $item->saidas_id ?>">Excluir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/caixa/anexarimagemsaida/<?= $item->saidas_id ?>">Arquivos</a></div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="5">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                        <th class="tabela_footer" colspan="3">
                            <? if ($total > 0) { ?>
                                Valor Total : <?= number_format($totaldalista, 2, ",", "."); ?>
                            <? } ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
            <br>
            <br>
            <table>
                <thead>
                <th class="tabela_header">Contas</th>
                <th class="tabela_header">Saldo</th>
                </thead>
                <tbody>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($conta as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        $valor = $this->caixa->listarsomaconta($item->forma_entradas_saida_id);
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= number_format($valor[0]->total, 2, ",", "."); ?></td>
                        </tr>
                    <? } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="2">
                            Saldo Total: <?= number_format($saldo[0]->sum, 2, ",", ".") ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
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
