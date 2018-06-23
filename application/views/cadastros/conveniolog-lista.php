
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_voltar">
                    <a href="<?php echo base_url() ?>cadastros/convenio/">
                        Voltar
                    </a>
                </div>
            </td>
            
<!--            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanoexcluirgrupo">
                        Excluir Proc. Grupo
                    </a>
                </div>
            </td>-->
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Log de Alterações</a></h3>
        <div>
            <table>
                <thead>
                    
                    <tr>
                        <th class="tabela_header">Convênio</th>
                        <th class="tabela_header">Operador Alteração</th>
                        <th class="tabela_header">Data Alteração</th>
                        <th class="tabela_header">Campo</th>
                        <th class="tabela_header" style="max-width: 200px;">Informação Antiga</th>
                        <th class="tabela_header" style="max-width: 200px">Informação Nova</th>
                        
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->convenio->listarconveniolog($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->convenio->listarconveniolog($_GET)->limit($limit, $pagina)->orderby('data_cadastro desc')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->operador; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i:s", strtotime($item->data_cadastro)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->alteracao; ?></td>
                                <td style="max-width: 200px;" class="<?php echo $estilo_linha; ?>"><?= $item->informacao_antiga; ?></td>
                                <td style="max-width: 200px;" class="<?php echo $estilo_linha; ?>"><?= $item->informacao_nova; ?></td>
                                
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="12">
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
