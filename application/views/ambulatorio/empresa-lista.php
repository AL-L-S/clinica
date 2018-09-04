
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/empresa/carregarempresa/0">
            Nova Empresa
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Empresa</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/empresa/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">CNPJ</th>
                        <th class="tabela_header">Raz&atilde;o social</th>
                        <th class="tabela_header" colspan="7"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->empresa->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->empresa->listar($_GET)->limit($limit, $pagina)->orderby("nome")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->cnpj; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->razao_social; ?></td>

                                <td class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/empresa/carregarempresa/<?= $item->empresa_id ?>">Editar</a></div>
                                </td>
                                <?
                                $perfil_id = $this->session->userdata('perfil_id');
                                $operador_id = $this->session->userdata('operador_id');
                                if ($perfil_id == 1):
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                            <a   href="<?= base_url() ?>ambulatorio/empresa/configurarlogomarca/<?= $item->empresa_id ?>">Logomarca</a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                            <a   href="<?= base_url() ?>ambulatorio/empresa/configurarsms/<?= $item->empresa_id ?>">Serviço SMS</a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                            <a   href="<?= base_url() ?>ambulatorio/empresa/configuraremail/<?= $item->empresa_id ?>">Serviço EMAIL</a></div>
                                    </td>
<!--                                    <td class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/empresa/configuraracessoexterno/<?= $item->empresa_id ?>">Acesso Multiempresa</a></div>
                                    </td>-->

            <!--                                    <td class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                    <a href="<?= base_url() ?>ambulatorio/empresa/anexarimagemlogo/<?= $item->empresa_id ?>">Logo Sistema</a></div>
            </td>-->
                                <? endif; ?>
                                <?
//                                $perfil_id = $this->session->userdata('perfil_id');
                                if ($operador_id == 1):
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>"><div class="bt_link" style="">
                                            <a style="" href="<?= base_url() ?>ambulatorio/empresa/configurarpacs/<?= $item->empresa_id ?>">PACS</a></div>
                                    </td>
                                <? endif; ?>
                                <? if (count($lista) > 1 && $perfil_id == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                            <a style="cursor: pointer;" onclick="javascript: return confirm('Deseja realmente desativar a empresa?');" href="<?= base_url() ?>ambulatorio/empresa/excluirempresa/<?= $item->empresa_id ?>">Desativar</a></div>
                                    </td>    
                                <? } ?>
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
