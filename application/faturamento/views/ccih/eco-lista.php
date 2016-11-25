<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>eco/eco/novo">
            Novo Laudo
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Laudo Descritivo</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="4" class="tabela_title">
                            Lista de Laudos
                            <form name="form_busca" method="get" action="<?= base_url() ?>eco/eco/pesquisar">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Paciente</th>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">M&eacute;dico</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->eco_m->listarLaudos($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->eco_m->listarLaudos($_GET)->orderby('laudo_id desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?$ano= substr($item->data,0,4);?>
                                                            <?$mes= substr($item->data,5,2);?>
                                                            <?$dia= substr($item->data,8,2);?>
                                                            <?$datafinal= $dia . '/' . $mes . '/' . $ano; ?>
                                                            <?=$datafinal?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>ceatox/ceatox/carregar/<?= $item->laudo_id ?>">
                                        <img border="0" title="Alterar registro" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
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
                        <th class="tabela_footer" colspan="4">
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
