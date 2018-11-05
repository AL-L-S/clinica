<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/saudeocupacional/carregarsituacao/0">
            Nova Situação
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Situação</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarsituacao">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="tabela_header">Situação</th>                        
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->saudeocupacional->listarsituacao($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->saudeocupacional->listarsituacao($_GET)->orderby('descricao_situacao')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao_situacao; ?></td>                                
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a href="<?= base_url() ?>ambulatorio/saudeocupacional/carregarsituacao/<?= $item->aso_situacao_id ?>">Editar</a>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir?');" href="<?= base_url() ?>ambulatorio/saudeocupacional/excluirsituacao/<?= $item->aso_situacao_id ?>">Excluir</a>
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

