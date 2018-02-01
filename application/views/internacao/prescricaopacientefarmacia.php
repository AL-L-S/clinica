<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Prescri&ccedil;&atilde;o</h3>
    <form name="form_prescricao" id="form_prescricao" action="<?= base_url() ?>internacao/internacao/gravarprescricaofarmacia/<?= $internacao_id ?>" method="post">
        <fieldset>
            <legend>Prescricao</legend>
            <div>
                <label>Medicamento</label>
                <input type="hidden" id="txtMedicamentoID" class="texto_id" name="txtMedicamentoID"/>
                <input type="text" id="txtMedicamento" class="texto06" name="txtMedicamento" required/>
            </div>

            <div>
                <label>Aprasamento</label>
                <input type="number" name="aprasamento" id="aprasamento" min="1" alt="numeromask" class="size1" required/>

            </div>

            <div>
                <label>Dias</label>                      
                <input type="number" name="dias" min="1" id="dias" alt="numeromask" class="size1" value="0" required/>
            </div>

            <div style="display: block; width: 100%; margin-top: 5pt;">
                <button type="submit" name="btnEnviar">Adicionar Item</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </div>
        </fieldset>

    </form>

    <table>
        <thead>
            <tr>
                <th class="tabela_header">Medicamento</th>
                <th class="tabela_header">Status</th>
                <th class="tabela_header">Aprasamento</th>

                <th class="tabela_header">Dias</th>
                <th class="tabela_header">Quantidade Ministrada</th>
                <th class="tabela_header" style="text-align: left;" colspan="1">Ações</th>
                <th class="tabela_header" colspan="1"></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $perfil_id = $this->session->userdata('perfil_id');

            $estilo_linha = "tabela_content01";
            foreach ($medicamentos as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tr>
                    <td class="<?php echo $estilo_linha; ?>"><?php echo $item->descricao; ?></td>
                    <td class="<?php echo $estilo_linha; ?>">
                        <? if ($item->confirmado == 't') { ?>
                            <span style="color: green;">Confirmado</span>
                        <? } else { ?>
                            <span  style="color: red;"> Não Confirmado </span>
                        <? }
                        ?>   


                    </td>
                    <td class="<?php echo $estilo_linha; ?>"><?php echo $item->aprasamento; ?>/<?php echo $item->aprasamento; ?></td>

                    <td class="<?php echo $estilo_linha; ?>"><?php echo $item->dias; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?php echo $item->qtde_ministrada; ?></td>
                    <td class="<?php echo $estilo_linha; ?>">
                        <? if ($item->confirmado != 't') { ?>
                            <div class="bt_link">
                                <a href="<?= base_url() ?>internacao/internacao/carregarprescricaopaciente/<?= $item->internacao_prescricao_id ?>/<?= $internacao_id ?>">
                                    <b>Confirmar</b>
                                </a>
                            </div>
                            <div class="bt_link">
                                <a href="<?= base_url() ?>internacao/internacao/cancelarprescricaopaciente/<?= $item->internacao_prescricao_id ?>/<?= $internacao_id ?>">
                                    <b>Cancelar</b>
                                </a>
                            </div>    
                        <? } else { ?>
                            <? if ($perfil_id == 1) { ?>

                                <div class="bt_link">
                                    <a href="<?= base_url() ?>internacao/internacao/cancelarprescricaopaciente/<?= $item->internacao_prescricao_id ?>/<?= $internacao_id ?>">
                                        <b>Cancelar</b>
                                    </a>
                                </div>  
                            <? } ?>
                        <? }
                        ?>

                    </td>

                <!--                    <td class="<?php echo $estilo_linha; ?>">
                    
                </td>-->
                </tr>
            <? } ?>
        </tbody>

    </table>

</div> 

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>

<script>

    $(function () {
        $("#txtMedicamento").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=prescricaomedicamento",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtMedicamento").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtMedicamento").val(ui.item.value);
                $("#txtMedicamentoID").val(ui.item.id);
                return false;
            }
        });
    });

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
