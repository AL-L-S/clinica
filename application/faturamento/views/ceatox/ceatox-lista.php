<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ceatox/ceatox/novo">
            Nova Ficha
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Fichas de Notificação e de atendimento de assistência toxicológica</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="6" class="tabela_title">
                            Lista de Fichas
                            <form name="form_busca" method="get" action="<?= base_url() ?>ceatox/ceatox/pesquisar">
                                <input type="text" name="pacienet_nome" value="<?php echo @$_GET['pacienet_nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">N&uacute;mero</th>
                        <th class="tabela_header">Paciente</th>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Hora</th>
                        <th class="tabela_header">Diagnostico</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->ceatox_m->listarFichas($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->ceatox_m->listarFichas($_GET)->orderby('numero desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->numero; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?$ano= substr($item->data,0,4);?>
                                                            <?$mes= substr($item->data,5,2);?>
                                                            <?$dia= substr($item->data,8,2);?>
                                                            <?$datafinal= $dia . '/' . $mes . '/' . $ano; ?>
                                                            <?=$datafinal?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><?$hora= substr($item->hora,0,2); ?>
                                                            <?$minuto= substr($item->hora,3,2); ?>
                                                            <?$horafinal = $hora . ':' . $minuto;?>
                                                            <?=$horafinal?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->diagnostico_definitivo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>ceatox/ceatox/carregar/<?= $item->ficha_id ?>">
                                        <img border="0" title="Alterar registro" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                                    </a>
                                    <a href="<?= base_url() ?>ceatox/ceatox/evolucao/<?= $item->ficha_id ?>">
                                        <img border="0" title="Evolu&ccedil;&atilde;o" alt="Evolu&ccedil;&atilde;o"
                                             src="<?= base_url() ?>img/form/page_white_magnify.png" />
                                    </a>
                                    <a href="<?= base_url() ?>ceatox/ceatox/pesquisarobservacao/<?= $item->ficha_id; ?>">
                                        <img border="0" title="Observa&ccedil;&atilde;o" alt="Observa&ccedil;&atilde;o"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                                    </a>
                                    <a href="<?= base_url() ?>ceatox/ceatox/excluirficha/<?= $item->ficha_id; ?>">
                                        <img border="0" title="Excluir" alt="Excluir"
                                             src="<?= base_url() ?>img/form/page_white_delete.png" />
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
