<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>seguranca/operador/novo">
            Novo Operador
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Operadores</a></h3>
        <div>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>seguranca/operador/pesquisar">


                    <tr>
                        <th class="tabela_title">Nome</th>
                        <th class="tabela_title">Status</th>

                    </tr>
                    </thead>
                    <tr>
                        <th class="tabela_title">
                            <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />

                        </th>
                        <th class="tabela_title">
                            <select name="ativo" id="empresa" class="size1">
                                <option value="">Selecione</option>
                                <option value="t">Ativo</option>
                                <option value="f">Não-ativo</option>

                            </select>

                        </th>

                        <th colspan="1" class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>

                    </tr>
                </form>
                
            </table>
            <table>
                <thead>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Usu&aacute;rio</th>
                    <th class="tabela_header">Perfil</th>
                    <th class="tabela_header">Ativo</th>
                    <th class="tabela_header" colspan="5" width="140px;"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->operador_m->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        if ($limit != "todos") {
                            $lista = $this->operador_m->listar($_GET)->orderby('ativo desc')->orderby('nomeperfil')->orderby('nome')->limit($limit, $pagina)->get()->result();
                        } else {
                            $lista = $this->operador_m->listar($_GET)->orderby('ativo desc')->orderby('nomeperfil')->orderby('nome')->get()->result();
                        }
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->usuario; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nomeperfil; ?></td>
                                <? if ($item->ativo == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>">Ativo</td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>">Não Ativo</td>
                                <? } ?>
                                <? if ($item->ativo == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" >
                                        <a onclick="javascript: confirm('Deseja realmente excluir o operador <?= $item->usuario; ?>'); window.open('<?= base_url() . "seguranca/operador/excluirOperador/$item->operador_id"; ?>', '_blanck')"
                                           >Excluir
                                        </a>
            <!--                                    href="<?= base_url() ?>seguranca/operador/excluirOperador/<?= $item->operador_id; ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="140px;">
                                        <a  onclick="javascript:window.open('<?= base_url() . "seguranca/operador/alterar/$item->operador_id"; ?> ', '_blank');">Editar
                                        </a>
            <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="140px;">
                                        <a  onclick="javascript:window.open('<?= base_url() . "seguranca/operador/operadorconvenio/$item->operador_id"; ?> ', '_blank');">Convenio
                                        </a>
            <!--                           href="<?= base_url() ?>seguranca/operador/operadorconvenio/<?= $item->operador_id ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a  onclick="javascript:window.open('<?= base_url() . "seguranca/operador/associarempresas/$item->operador_id"; ?> ', '_blank');">Empresas
                                        </a>
            <!--                           href="<?= base_url() ?>seguranca/operador/operadorconvenio/<?= $item->operador_id ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a  onclick="javascript:window.open('<?= base_url() . "seguranca/operador/anexarimagem/$item->operador_id"; ?> ', '_blank');">Assinatura
                                        </a>
                                    </td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="140px;">
                                    <? } ?>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="9">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                            <div style="display: inline">
                                <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                <select style="width: 50px">
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>seguranca/operador/pesquisar/50');" <?
                                    if ($limit == 50) {
                                        echo "selected";
                                    }
                                    ?>> 50 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>seguranca/operador/pesquisar/100');" <?
                                    if ($limit == 100) {
                                        echo "selected";
                                    }
                                    ?>> 100 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>seguranca/operador/pesquisar/todos');" <?
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
