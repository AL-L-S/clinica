
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php // echo base_url() ?>ambulatorio/exametemp/novocredito/<?= $paciente_id ?>">
            Novo Crédito
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Crédito</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/exametemp/carregarcredito/<?= $paciente_id?>">
                                <tr>
                                    <th class="tabela_title">Procedimento</th>
                                    <th class="tabela_title">Convênio</th>
                                    <th class="tabela_title"></th>
                                </tr>
                                <tr>
                                    <th class="tabela_title">
                                        <input type="text" name="procedimento" value="<?php echo @$_GET['procedimento']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <input type="text" name="convenio" value="<?php echo @$_GET['convenio']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <button type="submit" id="enviar">Pesquisar</button>
                                    </th>
                                </tr>
                            </form>
            </table>
            <table>
                <tr>
                    <th class="tabela_header">Paciente</th>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header">Convênio</th>
                    <th class="tabela_header">Valor (R$)</th>
                    <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exametemp->listarcredito($paciente_id);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->entrada->listar($_GET)->orderby('pt.nome, c.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ",", ""); ?></td>
                                
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/exametemp/editarcredito/<?= $item->paciente_credito_id ?>">Editar</a></div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
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
