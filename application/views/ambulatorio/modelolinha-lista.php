
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/modelolinha/carregarmodelolinha/0">
            Nova Modelo
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Modelos de linhas</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/modelolinha/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Medico</th>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Detalhes</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->modelolinha->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->modelolinha->listar($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>

                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                  
                                    <a href="<?= base_url() ?>ambulatorio/modelolinha/carregarmodelolinha/<?= $item->ambulatorio_modelo_linha_id ?>">
 editar
                                    </a>
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
