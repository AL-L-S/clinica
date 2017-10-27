
<div class="content"> <!-- Inicio da DIV content -->
<!--    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologia/0">
            Novo item
        </a>
    </div>-->
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Campos Oftamologia</a></h3>
        <div>
            <table>
                <thead>
<!--                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/modelooftamologia/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>-->
                    <tr>
                        <th colspan="3" class="tabela_header">Valor</th>
                        <!--<th class="tabela_header">Medico</th>-->
                        <!--<th class="tabela_header">Procedimento</th>-->
                        <!--<th class="tabela_header">Detalhes</th>-->
                    </tr>
                </thead>
                <?php
//                $url = $this->utilitario->build_query_params(current_url(), $_GET);
//                $consulta = $this->modelooftamologia->listar($_GET);
//                $total = $consulta->count_all_results();
//                $limit = 10;
//                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
//
//                if ($total > 0) {
                ?>
                <tbody>
                    <tr>
                        <td class="tabela_content02">Modelo OE Esférico </td>


                        <td class="tabela_content02" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaoees/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="tabela_content01">Modelo OE Cilindrico</td>



                        <td class="tabela_content01" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaoecl/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="tabela_content02">Modelo OE Eixo</td>



                        <td class="tabela_content02" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaoeeixo/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="tabela_content01">Modelo OE AV</td>



                        <td class="tabela_content01" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaoeav/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="tabela_content02">Modelo OD Esférico </td>


                        <td class="tabela_content02" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaodes/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="tabela_content01">Modelo OD Cilindrico</td>



                        <td class="tabela_content01" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaodcl/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="tabela_content02">Modelo OD Eixo</td>



                        <td class="tabela_content02" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaodeixo/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="tabela_content01">Modelo OD AV</td>



                        <td class="tabela_content01" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaodav/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="tabela_content02">Modelo AD Esférico</td>



                        <td class="tabela_content02" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaades/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="tabela_content01">Modelo AD Cilindrico</td>



                        <td class="tabela_content01" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaadcl/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="tabela_content02">Modelo Acuidade OE</td>



                        <td class="tabela_content02" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaacuidadeoe/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="tabela_content01">Modelo Acuidade OD</td>



                        <td class="tabela_content01" width="100px;">

                            <a href="<?= base_url() ?>ambulatorio/modelooftamologia/carregarmodelooftamologiaacuidadeod/<? //= $item->ambulatorio_modelo_laudo_id  ?>">
                                Editar
                            </a>
                        </td>
                    </tr>



                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="5">
                            <?php // $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: 10
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
