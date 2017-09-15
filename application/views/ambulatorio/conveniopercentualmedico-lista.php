
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/procedimentoconveniopercentualmedico">
                        Novo Convenio
                    </a>
                </div>
            </td>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/replicarpercentualmedico">
                        Replicar Percentual
                    </a>
                </div>
            </td>
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Convenio Honor&aacute;rios M&eacute;dicos</a></h3>
        <div>
            <? $convenio = $this->convenio->listardados(); ?>
            <form method="get" action="<?= base_url() ?>ambulatorio/procedimentoplano/conveniopercentual">
                <table>
                    <thead>
                        <tr>
                            <th colspan="5" class="tabela_title">
                        </tr>
                        <tr>
    <!--                        <th class="tabela_title">Procedimento</th>
                            <th class="tabela_title" >Grupo</th>                  -->
                            <th class="tabela_title">Convenio</th>                        
                        </tr>
                        <tr>
    <!--                        <th class="tabela_title">
                                <input type="text" name="procedimento" class="texto05" value="<?php echo @$_GET['procedimento']; ?>" />
                            </th>
                            <th class="tabela_title">
                                <input type="text" name="grupo" class="texto03" value="<?php echo @$_GET['grupo']; ?>" />
                            </th>-->
                            <th class="tabela_title">
                                <select name="convenio" id="convenio" class="size2">
                                    <option value="">Selecione</option>
                                    <? foreach ($convenio as $value) : ?>
                                        <option value="<?= $value->convenio_id; ?>"
                                                <?if($value->convenio_id == @$_GET['convenio']) echo 'selected';?>>
                                                <?= $value->nome; ?>
                                        </option>
                                    <? endforeach; ?>

                                </select>
                            </th>
                            <th class="tabela_title">
                                <button type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>
                    </thead>
                </table>
            </form>
            <table>
                <thead>
                    <tr>
<!--                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Grupo</th>
                        <td class="tabela_header" width="120px;"></td>-->
                        <th class="tabela_header">Convenio</th>
                        <td class="tabela_header" width="120px;"></td>
                        <th class="tabela_header" colspan="2">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->procedimentoplano->listarpercentualconvenio($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->procedimentoplano->listarpercentualconvenio($_GET)->orderby('c.nome')->limit($limit, $pagina)->get()->result();
//                        echo '<pre>';
//                        var_dump($lista);
//                        die;
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir os percentuais associados a esse convenio?');"
                                       href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirpercentualconvenio/<?= $item->convenio_id; ?>">Excluir&nbsp;
                                    </a>
                                    <a 
                                        href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentoconveniopercentual/<?= $item->convenio_id; ?>">Editar
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
