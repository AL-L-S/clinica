<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Detalhamento Cadastro ASO</a></h3>
        <div>

            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gravardetalhamentoaso/<?= $paciente_id?>/<?= $cadastro_aso_id?>/">
               <? //var_dump($paciente_id);die;?>
                <table>
                    <thead>
                        <tr>


                        </tr>

                        <tr>
                            <th colspan="4" class="tabela_header">Procedimentos</th>
                            <th colspan="1" class="tabela_header">Situação</th>

                        </tr>
                    </thead>           
                    <?
                    if (count(@$informacao_aso[0]->impressao_aso) > 0) {
                        $config = json_decode(@$informacao_aso[0]->impressao_aso);
                    } else {
                        $config = '';
                    }
                    ?>
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
                            $lista = $this->guia->listarprocedimentoscadastroaso($cadastro_aso_id)->limit($limit, $pagina)->orderby("grupo")->get()->result();
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
//                        var_dump($item->cadastro_aso_id);die;
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>" style="width: 300px;"><?= $item->nome; ?></td>

                                    <? if ($item->aso_id == $item->cadastro_aso_id) { ?>
                                        <td class="<?php echo $estilo_linha; ?>"></td>
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
                                        <td class="<?php echo $estilo_linha; ?>" style="width: 150px;">
                                            <div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/detalharnr/" . $item->cadastro_aso_id . "/" . $paciente['0']->paciente_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=1300,height=800');">Detalhar
                                                </a>
                                            </div>
                                        </td>
                                        
                                    <? }elseif($item->grupo == 'ACUIDADE VISUAL'){?>
                                        
                                        <td class="<?php echo $estilo_linha; ?>"></td>
                                        <td class="<?php echo $estilo_linha; ?>" style="width: 150px;">
                                            <div class="bt_link">
                                                <a target="_blank" href="<?= base_url() ?>ambulatorio/guia/impressaofichaacuidadevisual/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Impressão A.Visual</a>
                                            </div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" style="width: 150px;">
                                            <div class="bt_link">
                                                <a target="_blank" href="<?= base_url() ?>ambulatorio/guia/impressaofichaacuidadevisual2/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Impressão A.Visual Especial</a>
                                            </div>
                                        </td>
                                        
                                    <?}elseif($item->grupo == 'AUDIOMETRIA'){?>
                                        
                                        <td class="<?php echo $estilo_linha; ?>"></td>
                                        <td class="<?php echo $estilo_linha; ?>"></td>
                                        <td class="<?php echo $estilo_linha; ?>" style="width: 200px;">
                                            <div class="bt_link">
                                                <a target="_blank" href="<?= base_url() ?>ambulatorio/guia/impressaofichaaudiometria/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Impressão Audiometria</a>
                                            </div>
                                        </td>
                                        
                                        
                                    <?} else { ?>
                                        <td class="<?php echo $estilo_linha; ?>"></td>
                                        <td class="<?php echo $estilo_linha; ?>"></td>
                                        <td class="<?php echo $estilo_linha; ?>"></td>
                                        


                                    <? } ?>
                                        <?$situacao_aso = $item->situacao_aso;?>
                                        <td class="<?php echo $estilo_linha; ?>" style="width: 150px;">
                                            <input type="hidden" id="procedimento_id" name="procedimento_id[]" value="<?= $item->procedimento_convenio_id?>"/>
                                            <select  name="situacao[]" id="situacao" class="size2">
                                                <option value="">Selecione</option>
                                                <? foreach ($situacao as $item2) : ?>
                                                    <option value="<?= $item2->aso_situacao_id; ?>"<?if (@$item2->aso_situacao_id == $situacao_aso):echo 'selected';
                                    endif; ?>>
                                                        <?= $item2->descricao_situacao; ?>
                                                    </option>
                                        <? // var_dump($item->situacao_aso);die;?>
                                                <? endforeach; ?>
                                            </select>
                                        </td>
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

                </table>
                <br><br>
                <table>
                    <tr>
                        <td>
                            <button type="submit" name="btnEnviar">Enviar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
