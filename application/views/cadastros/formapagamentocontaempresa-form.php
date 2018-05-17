<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_formapagamento_parcela" id="form_formapagamento_parcela" action="<?= base_url() ?>cadastros/formapagamento/gravarcontaempresa" method="post">
        <!--<fieldset>-->
            <div>
                <!--<label>&nbsp;</label>-->
                <div class="bt_link_voltar"><a href="<?= base_url() ?>cadastros/formapagamento/">Voltar</a></div>
            </div>
        <!--</fieldset>-->
        <fieldset>
            <legend>Forma de Pagamento</legend>
            <input type="text" class="texto09" name="forma_nome" value="<?= @$formapagamento[0]->nome; ?>" readonly="">
            <!--<legend>Cadastrar Valor Por Convênio</legend>-->


        </fieldset>
        <fieldset>
            <legend>Cadastro Conta Empresa</legend>
            <input type="hidden" name="formapagamento_id" value="<?= $formapagamento_id ?>">
            <!--<legend>Cadastrar Valor Por Convênio</legend>-->
            <div>
                <? $perfil_id = $this->session->userdata('perfil_id'); ?>
                <label>Empresa</label>
                <select name="empresa" id="empresa" class="size4" required>
                    <!--<option value="">SELECIONE</option>-->
                    <? foreach ($empresa as $item) { ?>
                        <option value="<?= $item->empresa_id ?>" <?
                        if ($perfil_id == $item->empresa_id) {
                            echo 'selected';
                        }
                        ?>><?= $item->nome ?></option>
                            <? } ?>
                </select>
            </div>
            <div>
                <label>Conta</label>
                <select name="conta" id="conta" class="size4" required>
                    <!--<option value="">SELECIONE</option>-->
                    <? foreach ($conta as $item) { ?>
                        <option value="<?= $item->forma_entradas_saida_id ?>">
                            <?= $item->descricao ?> 
                            <? if ($item->agencia!='') echo "| Ag: ".$item->agencia ?> 
                            <? if ($item->conta!='') echo "| Conta: ".$item->conta ?> 
                    <? } ?>
                </select>
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
            <!--<button type="submit">Enviar</button>-->

        </fieldset>
    </form>
    <div style="display: block; width: 100%;">
        <? if (count($empresa_conta) > 0) { ?>
            <table class="taxas-feitas">
                <thead>
                    <tr>
                        <th class="tabela_header">Empresa</th>
                        <th class="tabela_header">Conta</th>
                        <th class="tabela_header">Agência</th>
                        <th class="tabela_header">Numero</th>
                        <th class="tabela_header"><center>Deletar</center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo_linha = "tabela_content01";
                    foreach ($empresa_conta as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>

                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->conta_id ?> - <?= $item->conta ?> </td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->agencia ?> </td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->numero_conta ?> </td>
                            <td class="<?php echo $estilo_linha; ?>"><center><a class="delete" href="<?= base_url() ?>cadastros/formapagamento/excluircontaempresa/<?= $item->formapagamento_conta_empresa_id ?>/<?= $formapagamento_id ?>">delete</a></center></td>
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
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });


    $(function () {
        $('#empresa').change(function () {
//                                            if ($(this).val()) {
            $('.carregando').show();
            $.getJSON('<?= base_url() ?>autocomplete/contaporempresa', {empresa: $(this).val(), ajax: true}, function (j) {
                var options = '<option value=""></option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="'+j[c].forma_entradas_saida_id+'">'+j[c].descricao;
                    if(j[c].agencia != ''){
                        options += ' | Ag: '+j[c].agencia;
                    }
                    if(j[c].conta != ''){
                        options += ' | Conta: '+j[c].conta;
                    }
                    options += '</option>';
                }
                $('#conta').html(options).show();
                $('.carregando').hide();
            });
//                                            } else {
//                                                $('#nome_classe').html('<option value="">TODOS</option>');
//                                            }
        });
    });



    if ($('#empresa').val() > 0) {
//                                          $('.carregando').show();
        $.getJSON('<?= base_url() ?>autocomplete/contaporempresa', {empresa: $('#empresa').val(), ajax: true}, function (j) {
            var options = '<option value=""></option>';
            for (var c = 0; c < j.length; c++) {
                    options += '<option value="'+j[c].forma_entradas_saida_id+'">'+j[c].descricao;
                    if(j[c].agencia != ''){
                        options += ' | Ag: '+j[c].agencia;
                    }
                    if(j[c].conta != ''){
                        options += ' | Conta: '+j[c].conta;
                    }
                    options += '</option>';
            }
            $('#conta').html(options).show();
            $('.carregando').hide();
        });
    }



</script>