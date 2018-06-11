<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Vers&atilde;o</a></h3>
        <div>
            <table>
                <thead>

                    <tr>
                        <th class="tabela_header">Vers&atilde;o do Sistema</th>
                        <th class="tabela_header">Vers&atilde;o do Banco de Dados</th>
                        <th class="tabela_header">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->versao->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->versao->listar($_GET)->orderby('versao_id')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->sistema; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->banco_de_dados; ?></td>                                                    
                                <td style="text-align: right" class="<?php echo $estilo_linha; ?>">
                                    <div class="bt_link_new">
                                        <a href="<?= base_url() . "ambulatorio/versao/pesquisardetalhes/" . $item->sistema; ?>" >Detalhes</a>
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



