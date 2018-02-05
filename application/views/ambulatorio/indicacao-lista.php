<?
$grupos = $this->indicacao->listargrupoindicacao();
$termo = ($this->session->userdata('recomendacao_configuravel') == "t") ? "Promotor" : "Indicação";
?>

<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/indicacao/carregarindicacao/0">
            <?= ($termo == "Promotor") ? "Novo " : "Nova " ;?><?= $termo ?>
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter <?= $termo ?></a></h3>
        <div>
            <table>
                <thead>
                    <form method="get" action="<?= base_url() ?>ambulatorio/indicacao/pesquisar">
                        <tr>
                            <th colspan="" class="tabela_title">Nome / Registro</th>
                            <th colspan="" class="tabela_title">Grupo</th>
                            <th colspan="" class="tabela_title"></th>
                        </tr>
                        <tr>
                            <th colspan="" class="tabela_title">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                            </th>
                            <th colspan="" class="tabela_title">
                                <select name="grupo_id" id="grupo_id" class="">
                                    <option value="">Todos</option>
                                    <? foreach ($grupos as $item) : ?>
                                        <option value="<?= $item->grupo_id; ?>" <?= (@@$_GET['grupo_id'] == $item->grupo_id)? 'selected': ""?>><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </th>
                            <th colspan="" class="tabela_title">
                                <button type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>
                    </form>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Registro</th>
                        <th class="tabela_header">Grupo</th>
                        <th class="tabela_header">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->indicacao->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->indicacao->listar($_GET)->limit($limit, $pagina)->orderby('nome')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->registro; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">

                                    <a href="<?= base_url() ?>ambulatorio/indicacao/carregarindicacao/<?= $item->paciente_indicacao_id ?>">
                                        Editar
                                    </a>&nbsp;
                                    <a href="<?= base_url() ?>ambulatorio/indicacao/excluir/<?= $item->paciente_indicacao_id ?>">
                                        Excluir
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
