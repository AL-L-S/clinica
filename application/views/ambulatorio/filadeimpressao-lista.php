
<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Fila de Impressão</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/indicacao/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Tipo</th>
                        <th class="tabela_header">Solicitante</th>
                        <th class="tabela_header" style="text-align: center;" colspan="2">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->guia->listarfiladeimpressao($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->guia->listarfiladeimpressao2($_GET)->limit($limit, $pagina)->orderby('nome')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i:s", strtotime(str_replace('/', '-', $item->data_cadastro))) ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->solicitante; ?></td>
                                <td colspan="1" class="<?php echo $estilo_linha; ?>"  width="60px">
                                    <div class="bt_link" >


                                        <a onclick="javascript: return confirm('Atenção! Após clicar em ok será aberto a tela de impressão e a solicitação desaparecerá dessa lista.');" href="<?= base_url() ?>ambulatorio/guia/imprimirfiladeimpressao/<?= $item->ambulatorio_fila_impressao_id ?>">
                                            Imprimir
                                        </a>
                                    </div>
                                    
                                    <!--&zwnj;&nbsp;-->

                                </td>
<!--                                <td colspan="1" class="<?php echo $estilo_linha; ?>" width="60px">
                                    <div class="bt_link">


                                        <a href="<?= base_url() ?>ambulatorio/guia/excluirfiladeimpressao/<?= $item->ambulatorio_fila_impressao_id ?>">
                                            Excluir
                                        </a>
                                    </div>
                                    
                                    &zwnj;&nbsp;

                                </td>-->
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
