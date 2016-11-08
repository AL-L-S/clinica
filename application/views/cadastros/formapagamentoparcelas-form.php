<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Forma de Pagamento</a></h3>
        <form name="form_formapagamento_parcela" id="form_formapagamento_parcela" action="<?= base_url() ?>cadastros/formapagamento/gravarparcelas" method="post">
            <input type="hidden" name="formapagamento_id" value="<?= $formapagamento_id ?>">
            <table class="taxas">
                <tbody>
                    <tr>
                        <td class="esquerda"><label>Taxa: </label></td> 
                        <td><input type="text" alt="decimal" name="taxa" class="size1" id="taxa"></td>
                    </tr>

                    <tr>
                        <td class="esquerda"><label>Parcela Inicial:</label></td> 
                        <td>
                            <select name="parcela_inicio" class="size2" id="parcela_inicio">
                                <option value="<?= $ultima_parcela ?>"> <?= $ultima_parcela ?> </option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="esquerda"><label>Parcela Fim:</label></td> 
                        <td>
                            <select name="parcela_fim" class="size2" id="parcela_fim">
                                <? for ($i = $ultima_parcela + 1; $i <= $formapagamento[0]->parcelas; $i++) { ?>
                                    <option value="<?= $i ?>"> <?= $i ?></option>
                                <? } ?>
                            </select>
                        </td>    
                    </tr>
                </tbody>
            </table>

<!--                <table border="1" style="width: 200px; margin-top: 10px;" id="funcoes">
    <tr>-->
            <td><button type="submit">Enviar</button></td>
            <!--                    </tr>
                            </table>-->
        </form>
        <div>
            <? if (count($faixas_parcelas) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Taxa</th>
                            <th class="tabela_header">Parcela Inicial</th>
                            <th class="tabela_header">Parcela Fim</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($faixas_parcelas as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tr>
                                <td class="<?php echo $estilo_linha; ?>">Taxa: <?= $item->taxa_juros ?></td>
                                <td class="<?php echo $estilo_linha; ?>">Parcela inicio: <?= $item->parcelas_inicio ?></td>
                                <td class="<?php echo $estilo_linha; ?>">Parcela fim: <?= $item->parcelas_fim ?></td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            <? } ?> 
        </div>
    </div>
</div> <!-- Final da DIV content -->
<style>
    .taxas{
        width: 100px;
    }
    .taxas .esquerda{
        width: 130px;
    }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $(document).ready(function () {
        jQuery('#form_formapagamento_parcela').validate({
            rules: {
                taxa: {
                    required: true
                },
                parcela_inicio: {
                    required: true
                },
                parcela_fim: {
                    required: true
                }

            },
            messages: {
                taxa: {
                    required: "*"
                },
                parcela_inicio: {
                    required: "*"
                },
                parcela_fim: {
                    required: "*"
                }
            }
        });
    });

</script>