<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ceatox/solicitante/novo">
            Novo Solicitante
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Manter solicitante</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="4">
                            Lista solicitantes
                            <form method="get" action="<?php echo base_url()?>ceatox/solicitante/pesquisar">
                                Nome<input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                
                                <button type="submit" name="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header" >Nome</th>
                        <th class="tabela_header" >Institui&ccedil;&atilde;o</th>
                        <th class="tabela_header" ><center>Alterar</center></th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->solicitante_m->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->solicitante_m->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            
                    ?>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $item->nome; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $item->instituicao; ?></td>
                       
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>ceatox/solicitante/carregar/<?= $item->ceatox_solicitante_id ?>"><center>
                                        <img border="0" title="Alterar registro" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                                        </center></a>
                        
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
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>