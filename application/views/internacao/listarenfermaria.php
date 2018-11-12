<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>internacao/internacao/novoenfermaria">
            Nova Enfermaria
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Manter Enfermarias</a></h3>
        <div>
            <form method="get" action="<?php echo base_url() ?>internacao/internacao/pesquisarenfermaria">
                <table>
                    <tr>
                        <th class="tabela_title" colspan="1">
                            Nome
                        </th>
                        <th class="tabela_title" colspan="1">
                            Unidade
                        </th>
                    </tr>
                    <tr>
                        <? $unidade = $this->unidade_m->listaunidadepacientes(); ?>
                        <th class="tabela_title" colspan="1">
                            <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        <th class="tabela_title" colspan="1">
                            <select name="unidade" id="unidade" class="size2" >
                                <option value=''>TODOS</option>
                                <?php
                                foreach ($unidade as $item) {
                                    ?>
                                    <option <?=($item->internacao_unidade_id == @$_GET['unidade'])? 'selected' : '';?> value="<?php echo $item->internacao_unidade_id; ?>">
                                        <?php echo $item->nome; ?>
                                    </option>
                                    <?php
                                }
                                ?> 
                            </select>
                        </th>
                        <th class="tabela_title" colspan="1">
                            <button type="submit" name="enviar">Pesquisar</button>
                        </th>
                        
                    </tr>
                </table>
            </form>
            <table>
                <thead>
                
                <tr>
                    <th class="tabela_header">Codigo</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Unidade</th>
                    <th class="tabela_header" width="30px;"><center></center></th>
                <th class="tabela_header" width="30px;"><center></center></th>

                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->enfermaria_m->listaenfermaria($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->enfermaria_m->listaenfermaria($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->internacao_enfermaria_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->unidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <a href="<?= base_url() ?>internacao/internacao/carregarenfermaria/<?= $item->internacao_enfermaria_id ?>"><center>
                                            <img border="0" title="Alterar registro" alt="Detalhes"
                                                 src="<?= base_url() ?>img/form/page_white_edit.png" />
                                        </center></a>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir a Enfermaria?');"
                                       href="<?=base_url()?>internacao/internacao/excluirenfermaria/<?= $item->internacao_enfermaria_id ?>">
                                        <center><img border="0" title="Excluir" alt="Excluir"
                                                    src="<?=  base_url()?>img/form/page_white_delete.png" /></center>
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
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
   
    $(function() {
        $( "#accordion" ).accordion();
    });

</script>