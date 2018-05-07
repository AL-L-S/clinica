<div class="content"> <!-- Inicio da DIV content -->
    <? $perfil_id = $this->session->userdata('perfil_id'); ?>
    <div class="bt_link_new">
        <a href="<?= base_url() ?>seguranca/operador/novoagendatelefonica" >
            Novo Contato
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Contatos Agenda Telefônica</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            Lista de Contatos
                            <form method="get" action="<?= base_url() ?>seguranca/operador/pesquisaragendatelefonica">
                                <input type="text" name="nome" class="size10" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Telefone 1</th>
                        <th class="tabela_header">Telefone 2</th>
                        <th class="tabela_header">Telefone 3</th>
                        <th class="tabela_header" colspan="2">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->operador_m->listaragendatelefonica($_GET);
                $total = $consulta->count_all_results();
                $limit = 50;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->operador_m->listaragendatelefonica($_GET)->limit($limit, $pagina)->orderby("nome")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->telefone1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->telefone2; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->telefone3; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="140px;">
                                    <a href="<?= base_url() ?>seguranca/operador/alteraragendatelefonica/<?= $item->agenda_telefonica_id ?>">Editar</a>
                                </td>


                                <td class="<?php echo $estilo_linha; ?>" width="140px;">
                                    <a  style="cursor: pointer;" onclick="javascript: return confirm('Deseja realmente excluir o contato <?= $item->nome; ?> da agenda? ');"
                                        href="<?= base_url() ?>seguranca/operador/excluiragendatelefonica/<?= $item->agenda_telefonica_id ?>">Excluir</a>
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
