<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>cadastros/pacientes/pesquisabecircunstanciado">
            Novo Paciente
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Manter pacientes</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="4">
                            Lista de pacientes
                            <form method="get" action="<?php echo base_url()?>cadastros/pacientes/listarcircunstanciado">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" name="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">BE</th>
                        <th class="tabela_header">Diretoria</th>
                        <th class="tabela_header" width="100px;"><center></center></th>
                        
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->paciente->listarrelatoriobecircunstanciado($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->paciente->listarrelatoriobecircunstanciado($_GET)->orderby('relatoriocircuntanciado_id')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->be; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->diretoria; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>cadastros/pacientes/impressaorelatoriocircunstanciado/<?= $item->relatoriocircuntanciado_id ?>"><center>
                                        <img border="0" title="Imprimir" alt="imprimir"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                                        </center></a>
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
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
   
    $(function() {
        $( "#accordion" ).accordion();
    });

</script>