
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/modeloreceita/carregarmodeloreceita/0">
            Nova Modelo
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Modelos de receitas</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/modeloreceita/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Medico</th>
                        <th class="tabela_header" colspan="4"><center>Detalhes</center></th>
                    </tr>
                </thead>
                <?php
                    $empresapermissao = $this->guia->listarempresapermissoes();
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->modeloreceita->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->modeloreceita->listar($_GET)->limit($limit, $pagina)->orderby('nome')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                                
                                <? 
                                if (@$empresapermissao[0]->carregar_modelo_receituario == 't') { 
                                    if (@$item->carregar_automaticamente != 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                            <a href="<?= base_url() ?>ambulatorio/modeloreceita/ativarmodeloreceitaautomatico/<?= $item->ambulatorio_modelo_receita_id ?>">
                                                Ativar
                                            </a>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                            <a href="<?= base_url() ?>ambulatorio/modeloreceita/desativarmodeloreceitaautomatico/<?= $item->ambulatorio_modelo_receita_id ?>">
                                                Desativar
                                            </a>
                                        </td>
                                    <? } 
                                } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>ambulatorio/modeloreceita/carregarmodeloreceita/<?= $item->ambulatorio_modelo_receita_id ?>">
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
