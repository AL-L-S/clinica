<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Confirmar Prescrição</h3>
    <fieldset>
        <legend>Prescrição</legend>

        <?
        if (count($medicamentos) > 0) {
            ?>


            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Medicamento</th>
                        <th class="tabela_header">Aprasamento</th>
                        <th class="tabela_header">Dias</th>
                        <th class="tabela_header">Quantidade Solicitada</th>
                        <th class="tabela_header">Quantidade Saída Estoque</th>
                        <!--<th class="tabela_header" style="text-align: left;" colspan="1">Ações</th>-->
                        <!--<th class="tabela_header" colspan="1"></th>-->
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $perfil_id = $this->session->userdata('perfil_id');

                    $estilo_linha = "tabela_content01";

                    foreach ($medicamentos as $item) {
                        if ($item->aprasamento == 1) {
                            $quantidade_solicitada = 1 * $item->dias;
                        } else {
                            $quantidade_solicitada = (int) (24 / $item->aprasamento) * $item->dias;
                        }
                        $quantidade_saida = $item->quantidade;
                        $farmacia_saida_id = $item->farmacia_saida_id;
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->descricao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->aprasamento; ?>/<?php echo $item->aprasamento; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->dias; ?></td>
                            <td class="<?php echo $estilo_linha; ?>">
                                <?= $quantidade_solicitada ?>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $quantidade_saida; ?></td>


                        </tr>
                    <? } ?>
                </tbody>

            </table>
        <? } else {
            ?>
            Sem saída no estoque até este momento
        <? }
        ?>
    </fieldset>
    <?
    if (count($medicamentos) > 0) {
        ?>


        <form name="form_prescricao" id="form_prescricao" action="<?= base_url() ?>internacao/internacao/confirmarprescricaofarmacia/<?= $internacao_prescricao_id ?>/<?= $internacao_id ?>" method="post">
            <fieldset>
                <legend>Confirmar Prescrição</legend>


                <div>
                    <label>Quantidade Ministrada</label>
                    <input type="number" name="quantidade_ministrada" id="quantidade_ministrada" min="1" alt="numeromask" max="<?= $quantidade_saida ?>" class="size1" required/>
                    <input type="hidden" name="quantidade_saida" id="quantidade_saida"  value="<?= $quantidade_saida ?>" class="size1" required/>
                    <input type="hidden" name="farmacia_saida_id" id="quantidade_saida"  value="<?= $farmacia_saida_id ?>" class="size1" required/>

                </div>

                <!--            <div>
                                <label>Dias</label>                      
                                <input type="number" name="dias" min="1" id="dias" alt="numeromask" class="size1" value="0" required/>
                            </div>-->

                <div style="display: block; width: 100%; margin-top: 5pt;">
                    <button type="submit" name="btnEnviar">Confirmar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                </div>
            </fieldset>

        </form>

    <? } ?>

</div> 

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>

<script>



    $(document).ready(function () {
        jQuery('#form_prescricao').validate({
            rules: {
                txtMedicamento: {
                    required: true
                },
                dias: {
                    required: true
                },
                aprasamento: {
                    required: true
                }
            },
            messages: {
                txtMedicamento: {
                    required: "*"
                },
                dias: {
                    required: "*"
                },
                aprasamento: {
                    required: "*"
                }
            }
        });
    });
</script>
