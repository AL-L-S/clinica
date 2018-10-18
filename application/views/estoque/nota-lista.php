
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td style="width: 200px;">
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>estoque/nota/carregarnota/0">
                        Nova Nota Fiscal
                    </a>
                    <?
                    $perfil_id = $this->session->userdata('perfil_id');
                    ?>
                </div> 
            </td>

        </tr>
    </table>


    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Nota Fiscal</a></h3>
        <div>
            <form method="get" action="<?= base_url() ?>estoque/nota/pesquisar">
                <table>
                    <thead>
                        <tr>
                            <th colspan="5" class="tabela_title">
                        <tr>

                            <th class="tabela_title">Nota</th>
                            <th class="tabela_title">Fornecedor</th>
                            <th class="tabela_title">Armazem</th>


                        </tr>
                        <tr>
                            <th class="tabela_title">
                                <input type="text" name="nota" value="<?php echo @$_GET['nota']; ?>" colspan="2"/>
                            </th>
                            <th class="tabela_title">
                                <input type="text" name="fornecedor" value="<?php echo @$_GET['fornecedor']; ?>" />
                            </th>
                            <th class="tabela_title">
                                <input type="text" name="armazem" value="<?php echo @$_GET['armazem']; ?>" colspan="2"/>
                            </th>
                            <th class="tabela_title">
                                <button type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>

                </table>
            </form>
            <table>
                <tr>                    
                    <th class="tabela_header">Nota</th>
                    <th class="tabela_header">Fornecedor</th>
                    <th class="tabela_header">Armazem</th>
                    <th class="tabela_header">Data</th>                    
                    <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->nota->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->nota->listar($_GET)->orderby('n.estoque_nota_id DESC, f.razao_social')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
//                            var_dump($item);die;
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>                                
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nota_fiscal; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->fantasia; ?></td>

                                <td class="<?php echo $estilo_linha; ?>"><?= $item->armazem; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data_cadastro)); ?></td>

                                <?
                                if ($perfil_id != 10) {
                                    if (date("Y-m-d", strtotime($item->data_cadastro)) == date("Y-m-d")) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">                                  
                                                <a href="<?= base_url() ?>estoque/nota/carregarnota/<?= $item->estoque_nota_id ?>">Editar</a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"></td>
                                    <? } ?>

                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                            <a onclick="javascript: return confirm('Deseja realmente exlcuir essa Nota?');" href="<?= base_url() ?>estoque/nota/excluir/<?= $item->estoque_nota_id ?>">Excluir</a></div>
                                    </td> 
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">                                  
                                            <a href="<?= base_url() ?>estoque/nota/alimentarnota/<?= $item->estoque_nota_id ?>">Entradas</a></div>
                                    </td>


                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">                                  
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                        </div>
                                    </td>  
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                        </div>
                                    </td>  

                                <? }
                                ?>
        <!--                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>estoque/entrada/anexarimagementrada/<?= $item->estoque_nota_id ?>">Arquivos</a></div>
                                        </td>-->
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="10">
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

</script>
