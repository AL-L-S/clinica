
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>estoque/produto/carregarproduto/0">
            Novo Produto
        </a>
        <?
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Produto</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>estoque/produto/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Unidade</th>
                        <th class="tabela_header">Sub-classe</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->produto->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->produto->listar($_GET)->orderby('p.descricao')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->unidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->sub_classe; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor_compra, 2, ',', '.'); ?></td>
                                <?if($perfil_id != 10){?>
                                 <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a href="<?= base_url() ?>estoque/produto/carregarproduto/<?= $item->estoque_produto_id ?>">Editar</a>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Produto?');" href="<?= base_url() ?>estoque/produto/excluir/<?= $item->estoque_produto_id ?>">Excluir</a>
                                </td>   
                                <?}else{?>
                                  <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    Editar
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    Excluir
                                </td>  
                                <?}?>
                                
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
