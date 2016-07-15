
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplano/0">
            Novo Procedimento
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Procedimento Convenio</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                    </tr>
                <form method="get" action="<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar">
                    <tr>
                        <th class="tabela_title">Procedimento</th>
                        <th class="tabela_title">Plano</th>
                        <th colspan="2" class="tabela_title">Codigo</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                    <input type="text" name="procedimento" class="texto04" value="<?php echo @$_GET['procedimento']; ?>" />
                    </th>
                        <th class="tabela_title">
                    <input type="text" name="nome" class="texto04" value="<?php echo @$_GET['nome']; ?>" />
                    </th>
                        <th class="tabela_title">
                    <input type="text" name="codigo" class="texto04" value="<?php echo @$_GET['codigo']; ?>" />
                    </th>
                    <th class="tabela_title">
                    <button type="submit" id="enviar">Pesquisar</button>
                    </th>
                    </tr>
                </form>
                </th>
                </tr>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Plano</th>
                        <th class="tabela_header">codigo</th>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header" colspan="2">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->procedimentoplano->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->procedimentoplano->listar($_GET)->orderby('pt.grupo')->orderby('pt.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->valortotal; ?></td>



                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o procedimento');"
                                       href="<?= base_url() ?>ambulatorio/procedimentoplano/excluir/<?= $item->procedimento_convenio_id; ?>">Excluir
                                    </a>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"> 
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplano/<?= $item->procedimento_convenio_id ?>');">
                                        Editar
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
                        <th class="tabela_footer" colspan="7">
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
