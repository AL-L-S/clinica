
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>estoque/menu/carregarmenu/0">
            Novo Menu
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Menu</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>estoque/menu/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->menu->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->menu->listar($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>

                                <td class="<?php echo $estilo_linha; ?>" width="60px;">                                  
                                    <a href="<?= base_url() ?>estoque/menu/criarmenu/<?= $item->estoque_menu_id ?>">Cadastrar</a>
                            </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">                                  
                                    <a href="<?= base_url() ?>estoque/menu/carregarmenu/<?= $item->estoque_menu_id ?>">Editar</a>
                            </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Menu?');" href="<?= base_url() ?>estoque/menu/excluir/<?= $item->estoque_menu_id ?>">Excluir</a>
                            </td>
                        </tr>

                        </tbody>
                        <?php
                                }
                            }
                        ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="4">
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
        $( "#accordion" ).accordion();
    });

</script>
