<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_prescricao" id="form_prescricao" action="<?= base_url() ?>internacao/internacao/gravarprescricaofarmacia/<?= $internacao_id ?>" method="post">
        <fieldset>
            <legend>Prescricao</legend>
            <div>
                <label>Medicamento</label>
                <input type="hidden" id="prescricaoID" class="texto_id" name="prescricaoID" value="<?= $prescricao_id; ?>"/>
                <input type="hidden" id="txtMedicamentoID" class="texto_id" name="txtMedicamentoID"/>
                <input type="text" id="txtMedicamento" class="texto06" name="txtMedicamento"/>
            </div>
            
            <div>
                <label>Volume</label>                      
                <!--<input type="text" id="volume" class="texto02" alt="integer" name="volume" value="" />-->
                <input type="text" id="volume" alt="decimal" class="texto02" name="volume"/>

            </div>

            <div>
                <label>Aprasamento</label>
                <input type="number" name="aprasamento" id="aprasamento" alt="numeromask" class="size1" />

            </div>

            <div>
                <label>Dias</label>                      
                <input type="number" name="dias" id="dias" alt="numeromask" class="size1" value="0"/>
            </div>


            <div style="display: block; width: 100%; margin-top: 5pt;">
                <button type="submit" name="btnEnviar">Adicionar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </div>
        </fieldset>

    </form>

    <table>
        <thead>
            <tr>
                <th class="tabela_header">Medicamento</th>
                <th class="tabela_header">Aprasamento</th>
                <th class="tabela_header">Dias</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $estilo_linha = "tabela_content01";
            foreach ($medicamentos as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tr>
                    <td class="<?php echo $estilo_linha; ?>"><?php echo $item->descricao; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?php echo $item->aprasamento; ?>/<?php echo $item->aprasamento; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?php echo $item->dias; ?></td>
                </tr>
            <? } ?>
        </tbody>

    </table>

</div> 

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
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


    $(function () {
        $("#accordion").accordion();
    });

    $(document).ready(function () {
        jQuery('#form_prescricao').validate({
            rules: {
                aprasamento: {
                    required: true
                },
                txtMedicamento: {
                    required: true
                }
            },
            messages: {
                txtMedicamento: {
                    required: "*"
                },
                aprasamento: {
                    required: "*"
                }
            }
        });
    });
</script>
