
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>cadastros/contasreceber/carregar/0">
            Nova Conta
        </a>
    </div>
    <?
    $empresa = $this->caixa->empresa();
    $saldo = $this->caixa->saldo();
    $conta = $this->forma->listarforma();
    $tipo = $this->tipo->listartipo();
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Contas a Receber</a></h3>
        <div>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>cadastros/contasreceber/pesquisar">
                    <tr>
                        <th class="tabela_title">Conta</th>
                        <th class="tabela_title">Data Inicio</th>
                        <th class="tabela_title">Data Fim</th>
                        <th class="tabela_title">Tipo</th>
                        <th class="tabela_title">Classe</th>
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
                                    <option value="<?= $value->tipo_entradas_saida_id; ?>" <?
                                    if (@$_GET['nome'] == $value->tipo_entradas_saida_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->descricao; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="nome_classe" id="nome_classe" class="size2">
                                <option value="">TODOS</option>
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
                        <th>
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_title">Saldo em Caixa:  <?= number_format($saldo[0]->sum, 2, ",", ".") ?></th>
                </tr>
                <tr>
                    <th class="tabela_header">Devedor</th>
                    <th class="tabela_header">Tipo</th>
                    <th class="tabela_header">Classe</th>
                    <th class="tabela_header">Dt contasreceber</th>
                    <th class="tabela_header">Conta</th>
                    <th class="tabela_header">Valor</th>
                    <th class="tabela_header">Observacao</th>
                    <th class="tabela_header" colspan="4"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->contasreceber->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 50;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                $valortotal = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->contasreceber->listar($_GET)->orderby('data')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        $dataatual = date("Y-m-d");
                        foreach ($lista as $item) {

                            $valortotal = $valortotal + $item->valor;
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <? if ($dataatual > $item->data) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><?= $item->razao_social; ?></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->razao_social; ?></td>
                                <? } ?>

                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->classe; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->conta; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ",", "."); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacao; ?></td>

                                <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/contasreceber/carregar/<?= $item->financeiro_contasreceber_id ?>">Editar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir a conta <?= $item->razao_social; ?>');" href="<?= base_url() ?>cadastros/contasreceber/excluir/<?= $item->financeiro_contasreceber_id ?>">Excluir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/contasreceber/carregarconfirmacao/<?= $item->financeiro_contasreceber_id ?>">Confirmar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/contasreceber/anexarimagemcontasareceber/<?= $item->financeiro_contasreceber_id ?>">Arquivos</a></div>
                                </td>
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
                        <th class="tabela_footer" colspan="4">
                            Total a receber:  <?= number_format($valortotal, 2, ",", "."); ?>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

                                            $(function () {
                                                $("#accordion").accordion();
                                            });

                                            $(function () {
                                                $('#nome').change(function () {
                                                    if ($(this).val()) {
                                                        $('.carregando').show();
                                                        $.getJSON('<?= base_url() ?>autocomplete/classeportiposaidalista', {nome: $(this).val(), ajax: true}, function (j) {
                                                            options = '<option value=""></option>';
                                                            for (var c = 0; c < j.length; c++) {
                                                                options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
                                                            }
                                                            $('#nome_classe').html(options).show();
                                                            $('.carregando').hide();
                                                        });
                                                    } else {
                                                        $('#nome_classe').html('<option value="">TODOS</option>');
                                                    }
                                                });
                                            });
</script>
