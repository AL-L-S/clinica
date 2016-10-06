<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Forma de Pagamento</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosformapagamentoid" class="texto10" value="<?= @$obj->_forma_pagamento_id; ?>" />
                        <input type="text" name="txtNome" class="texto05" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                    <dt>
                        <label>Ajuste</label>
                    </dt>
                    <dd>
                        <input type="text" name="ajuste" class="texto02" id="ajuste" value="<?= @$obj->_ajuste; ?>" />
                    </dd>

                    <dt>
                        <label>Dia Recebimento</label>
                    </dt>
                    <dd>
                        <input type="text" name="diareceber" class="texto02" id="diareceber" value="<?= @$obj->_dia_receber; ?>"/>
                    </dd>
                    <dt>
                        <label>Tempo Recebimento</label>
                    </dt>
                    <dd>
                        <input type="text" name="temporeceber" class="texto02" id="temporeceber" value= "<?= @$obj->_tempo_receber; ?>" />
                    </dd>
                    <dt>
                        <label>Conta</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" class="texto03">
                            <option value="">SELECIONE</option>
                            <? foreach ($conta as $value) { ?>
                                <option value="<?= $value->forma_entradas_saida_id ?>" <?
                                if (@$obj->_conta_id == $value->forma_entradas_saida_id):echo 'selected';
                                endif;
                                ?>><?= $value->descricao ?></option>
                                    <? } ?>                            
                        </select>
                    </dd>
                    <dt>
                        <label>Credor/Devedor</label>
                    </dt>
                    <dd>
                        <select name="credor_devedor" id="credor_devedor" class="texto03">
                            <option value="0">SELECIONE</option>
                            <? foreach ($credor_devedor as $value) { ?>
                                <option value="<?= $value->financeiro_credor_devedor_id ?>" <?
                                if (@$obj->_credor_devedor == $value->financeiro_credor_devedor_id):echo 'selected';
                                endif;
                                ?>><?= $value->razao_social ?></option>
                                    <? } ?>                            
                        </select>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_formapagamento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                conta: {
                    required: true,
                    equal: ""
                }

            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                conta: {
                    required: "*",
                    equal: "*"
                }
            }
        });
    });

</script>