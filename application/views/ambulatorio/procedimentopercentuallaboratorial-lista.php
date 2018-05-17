
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimentoplano/conveniopercentuallaboratorio/<?=$laboratorio_id?>">
            Voltar
        </a>
    </div>
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a target="_blank" href="<?php echo base_url() ?>ambulatorio/procedimentoplano/procedimentoconveniopercentuallaboratorio/<?=$laboratorio_id?>/<?=$convenio_id?>">
                        Novo Procedimento
                    </a>
                </div>
            </td>
<!--            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/replicarpercentuallaboratorio">
                        Replicar Percentual
                    </a>
                </div>
            </td>-->
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Procedimento Honor&aacute;rios Laboratório Terceirizado</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentoconveniopercentuallaboratorial/<?=$laboratorio_id?>/<?=$convenio_id?>">
                <table>
                    <thead>
                        <tr>
                            <th colspan="5" class="tabela_title">
                        </tr>
                        <tr>
                            <th class="tabela_title" >Grupo</th>                  
                            <th class="tabela_title">Procedimento</th>           
                        </tr>
                        <tr>
                            <th class="tabela_title">
                                <select name="grupo" id="grupo" class="size2">
                                    <option value="">Selecione</option>
                                    <? foreach ($grupo as $value) : ?>
                                        <option value="<?= $value->nome; ?>"
                                            <? if (@$_GET['grupo'] == $value->nome) echo 'selected'?>>
                                        <?= $value->nome; ?>
                                        </option>
                                    <? endforeach; ?>

                                </select>
                            </th>
                            <th class="tabela_title">
                                <input type="text" name="procedimento" id="procedimento" class="texto05" value="<?php echo @$_GET['procedimento']; ?>" />
                            </th>
                            <th class="tabela_title">
                                <button type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>
                    </thead>
                </table>
            </form>
            <form id="form_menuitens" action="<?= base_url() ?>ambulatorio/procedimentoplano/excluirlaboratoriopercentual" method="post" target="_blank">
                <div id="marcarTodos" style="float: right">
                    <input type="checkbox" name="selecionaTodos" id="selecionaTodos">
                    Todos
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header">Laboratorio</th>
                            <th class="tabela_header">Valor</th>
                            <th class="tabela_header" colspan="">Detalhes</th>
                            <th class="tabela_header" colspan="" style="text-align: center">Excluir?</th>
                        </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->procedimentoplano->listarprocedimentoconveniopercentuallaboratorio($laboratorio_id, $convenio_id);
                    $total = $consulta->count_all_results();

                    $limit = 10;
                    $procedimentos;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->procedimentoplano->listarprocedimentoconveniopercentuallaboratorio($laboratorio_id, $convenio_id)->orderby('pt.nome')->limit($limit, $pagina)->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>                               
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td> 
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->laboratorio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <?= ($item->percentual == "f")?"R$ " : '' ?>
                                        <?= number_format($item->valor, 2, ',', ''); ?>
                                        <?= ($item->percentual == "t")?" %" : '' ?>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a target="_blank" href="<?= base_url() ?>ambulatorio/procedimentoplano/editarlaboratoriopercentual/<?= $item->procedimento_percentual_laboratorio_convenio_id; ?>">
                                            Editar
                                        </a>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>"  style="text-align: center">
    <!--                                    <a onclick="javascript: return confirm('Deseja realmente excluir o procedimento');" target="_blank"
                                           href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirlaboratoriopercentual/<?= $item->procedimento_percentual_laboratorio_convenio_id; ?>">
                                            Excluir
                                        </a>-->
                                        <input type="checkbox" id="percentual" name="percentual[<?= $item->procedimento_percentual_laboratorio_convenio_id; ?>]"/>
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
    
    $(function() {
        $("#procedimento").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=listarprocedimentoautocomplete",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#procedimento" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#procedimento" ).val( ui.item.value );
                return false;
            }
        });
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
