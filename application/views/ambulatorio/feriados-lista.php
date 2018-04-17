<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/agenda/carregarferiado/0">
            Novo Feriado
        </a>
    </div>
    <form method="get" action="<?= base_url() ?>ambulatorio/agenda/pesquisarferiados">
        <div id="accordion">
            <h3 class="singular"><a href="#">Manter Feriados</a></h3>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th colspan="" class="tabela_title">Data</th>
                            <th colspan="" class="tabela_title">Nome</th>
                            <th colspan="4" class="tabela_title"></th>
                        </tr>
                        <tr>
                            <th class="tabela_title">
                                <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                            </th>
                            <th colspan="" class="tabela_title">
                                <input type="text" name="nome" class="texto04 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                            </th>
                            <th colspan="" class="tabela_title">
                                <button type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>
                        <tr>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Nome</th>
                            <th class="tabela_header" colspan="3"><center>A&ccedil;&otilde;es</center></th>
                        </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->agenda->listarferiados($_GET);
                    $total = $consulta->count_all_results();
                    $limit = $limite_paginacao;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            if ($limit != "todos") {
                                $lista = $this->agenda->listarferiados($_GET)->orderby('data, nome')->limit($limit, $pagina)->get()->result();
                            } else {
                                $lista = $this->agenda->listarferiados($_GET)->orderby('data, nome')->get()->result();
                            }
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->data; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>

                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/agenda/excluirferiado/<?= $item->feriado_id; ?>">
                                                Excluir
                                            </a>
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/agenda/carregarferiado/<?= $item->feriado_id ?>" target="_blank">
                                                Editar
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                            <?php
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="6">
                                <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                                Total de registros: <?php echo $total; ?>
                                <div style="display: inline">
                                    <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                    <select style="width: 50px">
                                        <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/agenda/pesquisarferiados/10');" <?
                                        if ($limit == 10) {
                                            echo "selected";
                                        }
                                        ?>> 10 </option>
                                        <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/agenda/pesquisarferiados/50');" <?
                                        if ($limit == 50) {
                                            echo "selected";
                                        }
                                        ?>> 50 </option>
                                        <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/agenda/pesquisarferiados/100');" <?
                                        if ($limit == 100) {
                                            echo "selected";
                                        }
                                        ?>> 100 </option>
                                        <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/agenda/pesquisarferiados/todos');" <?
                                        if ($limit == "todos") {
                                            echo "selected";
                                        }
                                        ?>> Todos </option>
                                    </select>
                                </div>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>
        

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    
     $(function () {
        $("#data").datepicker({
            autosize: true,
//            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm'
        });
    });

</script>
