<div class="content"> <!-- Inicio da DIV content -->

    <table>
        <tr>

                            </table>
                            <div id="accordion">
                                <h3><a href="#">Manter Internações</a></h3>
                                <div>
                                    <table >
                                        <thead>
                                            <tr>
                                                <th class="tabela_title" colspan="7">
                                                    Lista de pacientes
                                        <form method="get" action="<?php echo base_url() ?>cadastros/pacientes/pesquisar">
                                            <input type="text" name="nome" class="texto08" value="<?php echo @$_GET['nome']; ?>" />
                                            <button type="submit" name="enviar">Pesquisar</button>
                                        </form>
                                        </th>
                                        </tr>
                                        <tr>
                                            <th class="tabela_header">Prontuario</th>
                                            <th class="tabela_header">Nome</th>
                                            <th class="tabela_header">Data de Internação</th>
                                            <th class="tabela_header" width="100px;">Nascimento</th>
                                            <th class="tabela_header" width="100px;">Telefone</th>
                                            <th class="tabela_header" colspan="4"  width="70px;"><center>A&ccedil;&otilde;es</center></th>

                                        </tr>
                                        </thead>
                                        <?php
                                        $url = $this->utilitario->build_query_params(current_url(), $_GET);
                                        $consulta = $this->internacao_m->listar($_GET);
                                        $total = $consulta->count_all_results();
                                        $limit = 10;
                                        isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                                        if ($total > 0) {
                                            ?>
                                            <tbody>
                                                <?php
                                                $lista = $this->internacao_m->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                                                $estilo_linha = "tabela_content01";
                                                foreach ($lista as $item) {
                                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                                    if ($item->celular == "") {
                                                        $telefone = $item->telefone;
                                                    } else {
                                                        $telefone = $item->celular;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente_id; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?php echo substr($item->data_internacao, 8, 2) . '/' . substr($item->data_internacao, 5, 2) . '/' . substr($item->data_internacao, 0, 4); ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo substr($item->nascimento, 8, 2) . '/' . substr($item->nascimento, 5, 2) . '/' . substr($item->nascimento, 0, 4); ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $telefone; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link">
                                                                <a href="<?= base_url() ?>internacao/internacao/mostrarnovasaidapaciente/<?= $item->internacao_id ?>">
                                                                    <b>Saida</b>
                                                                </a></div>
                                                        </td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                                <a href="<?= base_url() ?>internacao/internacao/pesquisarevolucao/<?= $item->internacao_id ?>">
                                                                    <b>Evolução</b>
                                                                </a></div>
                                                        </td>

                        <!--                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                                <a href="<?= base_url() ?>cadastros/pacientes/procedimentoautorizar/<?= $item->paciente_id ?>">
                                                                    <b>Autorizar</b>
                                                                </a></div>
                                                        </td>-->
                        <!--                                                                <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link">
                                                                <a href="<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>">
                                                                    <b>Autorizar</b>
                                                                </a></div>
                                                        </td>-->
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
                            <link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
                            <script type="text/javascript">

                                $(function() {
                                    $("#accordion").accordion();
                                });

                            </script>