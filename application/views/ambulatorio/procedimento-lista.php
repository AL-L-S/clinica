
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/procedimento/carregarprocedimento/0">
            Novo Procedimento
        </a>
    </div>
    <?
    $perfil_id = $this->session->userdata('perfil_id');
    ?>

    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Procedimento</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/procedimento/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header" width="50%">Nome</th>
                        <th class="tabela_header" width="10%">Grupo</th>
                        <th class="tabela_header" width="10%">Codigo</th>
                        <th class="tabela_header" width="25%">Descri&ccedil;&atilde;o</th>
                        <th style="text-align: center;" colspan="3" class="tabela_header">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->procedimento->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        if ($limit != "todos") {
                            $lista = $this->procedimento->listar($_GET)->orderby('grupo')->orderby('nome')->limit($limit, $pagina)->get()->result();
                        } else {
                            $lista = $this->procedimento->listar($_GET)->orderby('grupo')->orderby('nome')->get()->result();
                        }
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>



                                <? if ($perfil_id != 10) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                            <a style="cursor: pointer;" onclick="javascript: return confirm('Deseja realmente excluir o procedimento');" href="<?= base_url() . "ambulatorio/procedimento/excluir/$item->procedimento_tuss_id"; ?>"
                                               >Excluir
                                            </a>
                                        </div>
            <!--                                    href="<?= base_url() ?>seguranca/operador/excluirOperador/<?= $item->operador_id; ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                            <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimento/carregarprocedimento/$item->procedimento_tuss_id"; ?> ', '_blank');">Editar
                                            </a></div>
                <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                            <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimento/procedimentoconveniovalor/$item->procedimento_tuss_id"; ?> ', '_blank');">Convênio
                                            </a></div>
                <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
                                    </td>

                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                            Excluir
                                        </div>
            <!--                                    href="<?= base_url() ?>seguranca/operador/excluirOperador/<?= $item->operador_id; ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                            Editar
                                        </div>
            <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                            Convênio
                                        </div>
            <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
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
                        <th class="tabela_footer" colspan="7">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                            <div style="display: inline">
                                <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                <select style="width: 50px">
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimento/pesquisar/50');" <?
                                    if ($limit == 50) {
                                        echo "selected";
                                    }
                                    ?>> 50 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimento/pesquisar/100');" <?
                                            if ($limit == 100) {
                                                echo "selected";
                                            }
                                    ?>> 100 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimento/pesquisar/todos');" <?
                                            if ($limit == "todos") {
                                                echo "selected";
                                            }
                                    ?>> Todos </option>
                                </select>
                            </div>
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
