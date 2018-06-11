<? $permissoes = $this->guia->listarempresapermissoes(); ?>
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <? if($permissoes[0]->percentual_multiplo != 't') { ?>
                <td>
                    <div class="bt_link_new">
                        <a target="_blank" href="<?php echo base_url() ?>ambulatorio/procedimentoplano/procedimentoconveniopercentualmedico">
                            Novo Percentual
                        </a>
                    </div>
                </td>
            <? } 
            else { ?>
                <td>
                    <div class="bt_link_new">
                        <a target="_blank" href="<?php echo base_url() ?>ambulatorio/procedimentoplano/percentualmedicomultiplo">
                            Novo Percentual
                        </a>
                    </div>
                </td>
            <? } ?>
            <td>
                <div class="bt_link_new">
                    <a target="_blank" href="<?php echo base_url() ?>ambulatorio/procedimentoplano/replicarpercentualmedico">
                        Replicar Percentual
                    </a>
                </div>
            </td>
            <td>
                <div class="bt_link_new">
                    <a target="_blank" href="<?php echo base_url() ?>ambulatorio/procedimentoplano/ajustarpercentualmedico">
                        Ajustar Percentuais
                    </a>
                </div>
            </td>
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Convenio Honor&aacute;rios M&eacute;dicos</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>ambulatorio/procedimentoplano/medicopercentual">
                <table>
                    <thead>
                        <tr>
                            <th colspan="5" class="tabela_title">
                        </tr>
                        <tr>
                            <th class="tabela_title">Médico</th>                        
                        </tr>
                        <? $medicos = $this->operador_m->listarmedicos(); ?>
                        <tr>
                            <th class="tabela_title">
                                <select name="operador_id" id="operador_id" class="size4">
                                    <option value="">Selecione</option>
                                    <? foreach ($medicos as $value) : ?>
                                        <option value="<?= $value->operador_id; ?>" <? if ($value->operador_id == @$_GET['operador_id']) echo "selected"; ?>>
                                            <?php echo $value->nome; ?>
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
            <form id="form_menuitens" action="<?= base_url() ?>ambulatorio/procedimentoplano/excluirmedicopercentual" method="post" target="_blank">
                
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
                            <th class="tabela_header">Médico</th>
                            <td class="tabela_header" width="120px;"></td>
                            <th class="tabela_header" colspan="">Detalhes</th>
                            <th class="tabela_header" colspan="" style="text-align: center">Excluir?</th>
                        </tr>
                    </thead>
                    <?php
                    $url = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->procedimentoplano->listarpercentualmedico($_GET);
                    $total = $consulta->count_all_results();
                    $limit = 10;
                    isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                            $lista = $this->procedimentoplano->listarpercentualmedico($_GET)->orderby('o.nome')->limit($limit, $pagina)->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->operador; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"></td>
                                    <? if($permissoes[0]->percentual_multiplo != 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <a href="<?= base_url() ?>ambulatorio/procedimentoplano/conveniopercentualmedico/<?= $item->operador_id; ?>">Editar</a>  
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <a target="_blank" href="<?= base_url() ?>ambulatorio/procedimentoplano/editarmedicopercentualmultiplos/<?= $item->operador_id; ?>">Editar</a>  
                                        </td>                                        
                                    <? } ?>
                                    <td class="<?php echo $estilo_linha; ?>" style="text-align: center">
                                        <input type="checkbox" id="percentual" name="medico[<?= $item->operador_id; ?>]"/>
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
