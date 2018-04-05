<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_formapagamento_parcela" id="form_formapagamento_parcela" action="<?= base_url() ?>cadastros/formapagamento/gravarparcelas" method="post">
        <fieldset>
            <legend>Cadastro Forma de Pagamento</legend>
            <input type="hidden" name="formapagamento_id" value="<?= $formapagamento_id ?>">
            <table class="taxas">
                <tbody>
                    <tr>
                        <td class="esquerda"><label>Taxa: </label></td> 
                        <td><input type="text" alt="decimal" name="taxa" class="size1" id="taxa"></td>
                    </tr>

                    <tr>
                        <td class="esquerda"><label>Inicio:</label></td> 
                        <td>
                            <select name="parcela_inicio" class="size2" id="parcela_inicio" required>
                                <? 
                                $parcelaInicialDisponivel = $ultima_parcela+1;
                                if ($ultima_parcela < $maximo) { 
                                    
                                    ?>
                                    <option value="<?= $parcelaInicialDisponivel ?>"> <?= $parcelaInicialDisponivel ?> </option>
                                    <?
                                    
                                    ?>
                                <? } else { ?>
                                        <option value=""></option>
                                <? } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="esquerda"><label>Fim:</label></td> 
                        <td>
                            <select name="parcela_fim" class="size2" id="parcela_fim" required>
                                <?
                                if ($ultima_parcela < $maximo) {
                                    for ($i = $parcelaInicialDisponivel; $i <= $formapagamento[0]->parcelas; $i++) { ?>
                                        <option value="<?= $i ?>"> <?= $i ?></option>
                                    <? } 
                                }?>
                            </select>
                        </td>    
                    </tr>          
                </tbody>
            </table>
            <button type="submit">Enviar</button>

        </fieldset>
    </form>

    <div style="display: block; width: 100%;">
        <? if (count($faixas_parcelas) > 0) { ?>
            <table class="taxas-feitas">
                <thead>
                    <tr>
                        <th class="tabela_header">Taxa</th>
                        <th class="tabela_header">Inicio</th>
                        <th class="tabela_header">Fim</th>
                        <th class="tabela_header"><center>Deletar</center></th>
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
                            <td class="<?php echo $estilo_linha; ?>"><center><a class="delete" href="<?= base_url() ?>cadastros/formapagamento/excluirparcela/<?= $item->formapagamento_pacela_juros_id ?>/<?= $item->forma_pagamento_id ?>">delete</a></center></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        <? } ?> 
    </div>

</div> <!-- Final da DIV content -->
<style>
    .taxas{
        width: 100px;
    }
    .taxas .esquerda{
        width: 130px;
    }
    .taxas-feitas{
        width: 80%;
    }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

 

</script>