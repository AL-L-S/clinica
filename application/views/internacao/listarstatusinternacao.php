<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>internacao/internacao/novostatusinternacao">
            Novo Status Internação
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Manter Status</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="4">
                            Lista de Status
                <form method="get" action="<?php echo base_url() ?>internacao/internacao/pesquisarstatusinternacao">
                    <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                    <button type="submit" name="enviar">Pesquisar</button>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Codigo</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header" width="30px;"><center></center></th>
                    <th class="tabela_header" width="30px;"><center></center></th>

                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->internacao_m->listastatusinternacao($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->statusinternacao->listastatusinternacao($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->internacao_statusinternacao_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <a href="<?= base_url() ?>internacao/internacao/carregarstatusinternacao/<?= $item->internacao_statusinternacao_id ?>"><center>
                                            <img border="0" title="Alterar registro" alt="Detalhes"
                                                 src="<?= base_url() ?>img/form/page_white_edit.png" />
                                        </center></a>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o Status Internação <?= $item->nome ?>');"
                                       href="<?=base_url()?>internacao/internacao/excluirstatusinternacao/<?= $item->internacao_statusinternacao_id ?>">
                                        <img border="0" title="Excluir" alt="Excluir"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
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
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
   
    $(function() {
        $( "#accordion" ).accordion();
    });

</script>