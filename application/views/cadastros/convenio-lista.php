
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>cadastros/convenio/carregar/0">
                        Novo Convenio
                    </a>
                </div>
            </td>
<!--            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanoexcluirgrupo">
                        Excluir Proc. Grupo
                    </a>
                </div>
            </td>-->
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Convenio</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="7" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>cadastros/convenio/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th colspan="10" class="tabela_header"><center>Detalhes</center></th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->convenio->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->convenio->listar($_GET)->limit($limit, $pagina)->orderby('nome')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/convenio/carregar/<?= $item->convenio_id ?>">
                                            Editar
                                        </a>
                                    </div></td>
                                <? if($item->associado == "f"){ ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>cadastros/convenio/copiar/<?= $item->convenio_id ?>">
                                                Copiar
                                            </a>
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link" style="width: 100px;">
                                            <a href="<?= base_url() ?>cadastros/convenio/desconto/<?= $item->convenio_id ?>">
                                                Ajuste (%)
                                            </a>
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link" style="width: 100px;">
                                            <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanoexcluirgrupo/<?= $item->convenio_id ?>">
                                                Excluir Proc.
                                            </a>
                                        </div>
                                    </td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link" style="width: 100px;">
                                            <a href="<?= base_url() ?>cadastros/convenio/ajustargrupoeditar/<?= $item->convenio_id ?>">
                                                Ajuste Grupo
                                            </a>
                                        </div>
                                    </td>                                    
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link" style="width: 100px;">
                                        <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanoformapagamento/<?= $item->convenio_id ?>">
                                            G. Pagamento
                                        </a>
                                    </div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link" style="width: 100px;">
                                        <a href="<?php echo base_url() ?>cadastros/convenio/anexararquivoconvenio/<?= $item->convenio_id ?>">
                                            Logo
                                        </a>
                                    </div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir o convenio?\n\nObs: Irá excluir também os procedimentos associados ao convenio  ');" href="<?= base_url() ?>cadastros/convenio/excluir/<?= $item->convenio_id ?>">
                                            
                                            Excluir
                                        </a>
                                    </div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" colspan="10"></td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="12">
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
