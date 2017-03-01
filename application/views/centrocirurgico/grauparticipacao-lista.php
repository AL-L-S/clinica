
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new" style="width: 150pt">
        <a href="<?php echo base_url() ?>centrocirurgico/centrocirurgico/novograuparticipacao" style="width: 250pt">
            Novo Grau de Participação
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Grau de Participação</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisargrauparticipacao">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Codigo</th>
                        <th class="tabela_header">Descricao</th>
                        <th class="tabela_header" colspan=""><center></center></th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->centrocirurgico_m->listargrauparticipacao($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 20;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->centrocirurgico_m->listargrauparticipacao($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir <?= $item->descricao; ?>');"
                                       href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirgrauparticipacao/<?= $item->grau_participacao_id; ?>" class="delete"></a>
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
