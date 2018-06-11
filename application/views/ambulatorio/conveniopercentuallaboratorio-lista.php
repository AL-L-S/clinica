
<div class="content"> <!-- Inicio da DIV content -->    
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimentoplano/laboratoriopercentual">
            Voltar
        </a>
    </div>
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a target="_blank" href="<?php echo base_url() ?>ambulatorio/procedimentoplano/procedimentoconveniopercentuallaboratorio/<?=$laboratorio_id?>">
                        Novo Percentual
                    </a>
                </div>
            </td>
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Convenio Honor&aacute;rios Laboratório Terceirizado</a></h3>
        <div>
            <? $convenio = $this->convenio->listardados(); ?>
            <form method="get" action="<?= base_url() ?>ambulatorio/procedimentoplano/conveniopercentuallaboratorio/<?=$laboratorio_id?>">
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
            <form id="form_menuitens" action="<?= base_url() ?>ambulatorio/procedimentoplano/excluirpercentuallaboratorioconvenio" method="post" target="_blank">
                <input type="hidden" name="laboratorio_id" value="<?=$laboratorio_id?>">
                <div id="marcarTodos" style="float: right">
                    <input type="checkbox" name="selecionaTodos" id="selecionaTodos">
                    Todos
                </div>
                <table>
                    <thead>
                        <tr>
    <!--                        <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">Grupo</th>
                            <td class="tabela_header" width="120px;"></td>-->
                            <th class="tabela_header">Convenio</th>
                            <td class="tabela_header" width="120px;"></td>
                            <th class="tabela_header" colspan="">Detalhes</th>
                            <th class="tabela_header" colspan="" style="text-align: center">Excluir?</th>
                        </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->procedimentoplano->listarpercentualconveniolaboratorio($laboratorio_id, $_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->procedimentoplano->listarpercentualconveniolaboratorio($laboratorio_id, $_GET)->orderby('c.nome')->limit($limit, $pagina)->get()->result();
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
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentoconveniopercentuallaboratorial/<?=$laboratorio_id?>/<?= $item->convenio_id; ?>">
                                            Editar
                                        </a>  
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>"  style="text-align: center">
<!--                                        <a onclick="javascript: return confirm('Deseja realmente excluir os percentuais associados a esse convenio?');" target="_blank"
                                           href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirpercentuallaboratorioconvenio/<?=$laboratorio_id?>/<?= $item->convenio_id; ?>">Excluir&nbsp;
                                        </a>-->
                                        <input type="checkbox" id="percentual" name="convenio[<?= $item->convenio_id; ?>]"/>
                                    </td>
                                </tr>

                            </tbody>
                            <?php
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="3">
                                <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                                Total de registros: <?php echo $total; ?>
                            </th>
                            <th class="tabela_footer" colspan="3">
                                <button type="submit" style="font-weight: bold">Excluir</button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
       $(function () {
        $('#selecionaTodos').change(function () {
            if ($(this).is(":checked")) {
                $("input[id='percentual']").attr("checked", "checked");

            } else {
                $("input[id='percentual']").attr("checked", false);
            }
        });
    });


</script>
