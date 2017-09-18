
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/novoprocedimentopercentualpromotor">
            Novo Procedimento
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Procedimento Honor&aacute;rios Promotores</a></h3>
        <div>
            <? $grupo = $this->procedimento->listargrupos(); 
               $convenio = $this->convenio->listardados(); ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                    </tr>
                <form method="get" action="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentopercentualpromotor">
                    <tr>
                        <th class="tabela_title" >Convenio</th>                        
                        <th class="tabela_title" >Grupo</th>                  
                        <th class="tabela_title">Procedimento</th>
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
                </form>
                </th>
                </tr>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Grupo</th>
                        <td class="tabela_header" width="120px;"></td>
                        <th class="tabela_header">Convenio</th>
                        <td class="tabela_header" width="120px;"></td>
                        <th class="tabela_header" colspan="2">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->procedimentoplano->listarprocedimentogrupopromotor($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->procedimentoplano->listarprocedimentogrupopromotor($_GET)->orderby('pt.grupo')->orderby('pt.nome')->limit($limit, $pagina)->get()->result();
//                        echo '<pre>';
//                        var_dump($lista);
//                        die;
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>                               
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td> 
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o procedimento');"
                                       href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirpercentualpromotorgeral/<?= $item->procedimento_percentual_promotor_id; ?>">Excluir&nbsp;
                                    </a>
                                    <a 
                                        href="<?= base_url() ?>ambulatorio/procedimentoplano/editarprocedimentopromotor/<?= $item->procedimento_percentual_promotor_id; ?>">Editar
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
</script>
