<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
            Novo Medico
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Medico Solicitante</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            Lista de Operadores
                            <form method="get" action="<?= base_url() ?>seguranca/operador/pesquisarmedicosolicitante">
                                <input type="text" name="nome" class="size10" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">CRM</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->operador_m->listarmedicosolicitante($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->operador_m->listarmedicosolicitante($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->conselho; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="140px;">

                                    <a href="<?= base_url() ?>seguranca/operador/alterarrecepcao/<?= $item->operador_id ?>">Editar                                    </a>
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
