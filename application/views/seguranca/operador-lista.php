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
                    <tr>
                        <th colspan="5" class="tabela_title">
                            Lista de Operadores
                            <form method="get" action="<?= base_url() ?>seguranca/operador/pesquisar">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Usu&aacute;rio</th>
                        <th class="tabela_header">Perfil</th>
                        <th class="tabela_header">Ativo</th>
                        <th class="tabela_header" colspan="3" width="140px;">A&ccedil;&otilde;es</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->operador_m->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 50;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->operador_m->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->usuario; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nomeperfil; ?></td>
                                <?if($item->ativo == 't'){?>
                                <td class="<?php echo $estilo_linha; ?>">Ativo</td>
                                <?}else{?>
                                <td class="<?php echo $estilo_linha; ?>">Não Ativo</td>
                                <?}?>
                                                                <?if($item->ativo == 't'){?>
                                <td class="<?php echo $estilo_linha; ?>" >
                                    <a onclick="javascript: confirm('Deseja realmente excluir o operador <?=$item->usuario; ?>'); window.open('<?= base_url() . "seguranca/operador/excluirOperador/$item->operador_id";?>' , '_blanck')"
                                       >Excluir
                                    </a>
<!--                                    href="<?=base_url()?>seguranca/operador/excluirOperador/<?=$item->operador_id;?>"-->
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
                                                                    <?}else{?>
                                    <td class="<?php echo $estilo_linha; ?>" width="140px;">
                                    <?}?>
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
