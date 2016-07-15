    <?php
    //Utilitario::pmf_mensagem($message);
    


    //unset($message);
    ?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/agenda/carregar/0">
            Nova Agenda
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Agenda</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/agenda/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Tipo</th>
                        <th class="tabela_header" colspan="3"><center>A&ccedil;&otilde;es</center></th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->agenda->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->agenda->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>

                           

                                <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o horario <?=$item->nome; ?>');"
                                       href="<?=base_url()?>ambulatorio/agenda/excluir/<?=$item->agenda_id;?>">
                                        delete
                                    </a>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                    <a href="<?= base_url() ?>ambulatorio/agenda/carregar/<?= $item->agenda_id ?>">
                                        detalhes
                                    </a>
                                        </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">                                    <? 
                                    if ($item->tipo == "Fixo"){?>
                                    <a href="<?= base_url() ?>ambulatorio/agenda/listarhorarioagenda/<?= $item->agenda_id ?>">
                                        fixo
                                            </a>
                                        </td>
                                    <? }
                                    
                                    
                                    
                                    
                                    ?>
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
