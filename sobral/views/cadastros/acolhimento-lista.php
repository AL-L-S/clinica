<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>cadastros/acolhimento/novo">
            Novo Acolhimento
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Listar Acolhimentos</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="5">
                            Lista de pacientes acolhidos
                            <form method="get" action="<?php echo base_url()?>cadastros/acolhimento/pesquisar">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" name="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Nome da Mãe</th>
                        <th class="tabela_header" width="200px;">Nascimento</th>
                        <th class="tabela_header" width="100px;">Data cadastro</th>
                        <th class="tabela_header" width="50px;">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->acolhimento->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->acolhimento->listar($_GET)->orderby('nomepaciente')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nomepaciente; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome_mae; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="200px;"><?php echo substr($item->data_nascimento,8,2). '/' . substr($item->data_nascimento,5,2) . '/' . substr($item->data_nascimento,0,4);?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo substr($item->data_acolhimento,8,2). '/' . substr($item->data_acolhimento,5,2) . '/' . substr($item->data_acolhimento,0,4);?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="50px;">&nbsp;</td>
                    </tr>
                </tbody>
                <?php 
                        }
                    }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="5">
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