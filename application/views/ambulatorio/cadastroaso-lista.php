<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/guia/carregarcadastroaso/<?= $paciente_id ?>/0/">
            Novo Cadastro ASO
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Cadastro ASO</a></h3>
        <div>

            <table>
                <form method="get" action="<?= base_url() ?>ambulatorio/guia/cadastroaso">
                    <thead>
                        <tr>


                        </tr>

                        <tr>
                            <th class="tabela_header">Paciente</th>
                            <th class="tabela_header">Tipo</th>
                            <th class="tabela_header">Data/Hora</th>
                            <th class="tabela_header" colspan="5"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                </form>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->guia->listarcadastroaso($paciente_id);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                    <?php
                    $lista = $this->guia->listarcadastroaso($paciente_id)->limit($limit, $pagina)->orderby("cadastro_aso_id desc")->get()->result();
                    $estilo_linha = "tabela_content01";
                    foreach ($lista as $item) {
//                            echo'<pre>';var_dump($lista[1]);die;
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                            <tr>

                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i:s", strtotime($item->data_cadastro)); ?></td>

                                <td class="<?php echo $estilo_linha; ?>" style="width: 100px;">

                                    <div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/guia/carregarcadastroaso/<?= $item->paciente_id; ?>/<?= $item->cadastro_aso_id; ?>">Editar</a>
                                    </div>

                                </td>

        <? if ($permissoes[0]->impressao_cimetra == 't') { ?>
                                    <? if ($item->consulta == "conveniado") { ?>
                                        <td class="<?php echo $estilo_linha; ?>" style="width: 100px;">

                                            <div class="bt_link">
                                                <a href="<?= base_url() ?>ambulatorio/guia/impressaoaso2/<?= $item->cadastro_aso_id; ?>">Imprimir</a>
                                            </div>

                                        </td>
            <? } else { ?>

                                        <td class="<?php echo $estilo_linha; ?>" style="width: 100px;">

                                            <div class="bt_link">
                                                <a href="<?= base_url() ?>ambulatorio/guia/impressaoasoparticular/<?= $item->cadastro_aso_id; ?>">Imprimir</a>
                                            </div>

                                        </td>

            <? } ?>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" style="width: 100px;">

                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/guia/impressaoaso/<?= $item->cadastro_aso_id; ?>">Imprimir</a>
                                        </div>

                                    </td>

        <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" style="width: 100px;">
                                <? //if($item->aprovado == 'f'){?>
                                    <div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir esse ASO?');" href="<?= base_url() ?>ambulatorio/guia/excluircadastroaso/<?= $item->cadastro_aso_id; ?>/<?= $item->paciente_id; ?>">Excluir</a>
                                    </div>
        <? //} ?>
                                </td>
                                <?if($item->consulta == "particular" || $item->dinheiro == 'TRUE'){?>
                                <td class="<?php echo $estilo_linha; ?>" style="width: 100px;">

                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/guia/faturarprocedimentospersonalizados/<?= $item->guia_id; ?>">Faturar</a>
                                        </div>

                                    </td>
                                <? }else{ ?>
                                    <td class="<?php echo $estilo_linha; ?>"></td>
                                <? } ?>
                                    <?
                                    $perfil_id = $this->session->userdata('perfil_id');
                                    $operador_id = $this->session->userdata('operador_id');
                                    ?>
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
