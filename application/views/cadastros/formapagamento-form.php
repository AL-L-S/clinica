<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Forma de Pagamento</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravar" method="post">

                <dl class="dl_desconto_lista" >
                    <dt title="Nome da forma de Pagamento">
                        <label >Nome</label>
                    </dt>
                    <dd title="Nome da forma de Pagamento">
                        <input type="hidden" name="txtcadastrosformapagamentoid" class="texto10" value="<?= @$obj->_forma_pagamento_id; ?>" />
                        <input type="text" name="txtNome" class="texto05" value="<?= @$obj->_nome; ?>" required/>
                    </dd>

                    <dt title="Ajuste percentual da forma de pagamento">
                        <label>Ajuste</label>
                    </dt>
                    <dd title="Ajuste percentual da forma de pagamento">
                        <input type="text" name="ajuste" class="texto02" id="ajuste" value="<?= @$obj->_ajuste; ?>" />%
                    </dd>

                    <dt title="Preencha caso a forma de pagamento tenha um dia certo do mês para cair">
                        <label>Dia de Recebimento</label>
                    </dt>
                    <dd title="Preencha caso a forma de pagamento tenha um dia certo do mês para cair">
                        <input type="text" name="diareceber" class="texto02" id="diareceber" value="<?= @$obj->_dia_receber; ?>"/>
                    </dd>
                    <dt title="Aqui é digitado o tempo que leva desde o momento do pagamento até o recebimento do dinheiro em si. (Esse campo anula o Dia de recebimento)">
                        <label>Tempo de Recebimento</label>
                    </dt>
                    <dd>
                        <input title="Aqui é digitado o tempo que leva desde o momento do pagamento até o recebimento do dinheiro em si. (Esse campo anula o Dia de recebimento)" type="text" name="temporeceber" class="texto02" id="temporeceber" value= "<?= @$obj->_tempo_receber; ?>" />
                        <input type="checkbox" name="arrendondamento" id="arrendondamento" <? if (@$obj->_fixar == 't') { ?>checked <? } ?>  />Fixar
                    </dd>
                    <dt>
                        <label>N° Maximo de Parcelas</label>
                    </dt>
                    <dd>
                        <input type="text" name="parcelas" class="texto02" id="parcelas" value= "<?= @$obj->_parcelas; ?>" required=""/>
                    </dd>
                    <dt>
                        <label>Valor Mínimo da Parcela</label>
                    </dt>
                    <dd>
                        <input type="text" name="parcela_minima" class="texto02" alt="decimal" id="parcela_minima" value= "<?= @$obj->_parcela_minima; ?>" />
                    </dd>
                    <dt title="Selecione a conta onde o dinheiro irá ingressar">
                        <label>Conta</label>
                    </dt>
                    <dd title="Selecione a conta onde o dinheiro irá ingressar">
                        <select name="conta" id="conta" class="texto03" required>
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
                        <select name="credor_devedor" id="credor_devedor" class="texto03" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($credor_devedor as $value) { ?>
                                <option value="<?= $value->financeiro_credor_devedor_id ?>" <?
                                if (@$obj->_credor_devedor == $value->financeiro_credor_devedor_id):echo 'selected';
                                endif;
                                ?>><?= $value->razao_social ?></option>
                                    <? } ?>                            
                        </select>
                    </dd>
                    <dt>
                        <label>Forma de Pagamento Cartão</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="cartao" id="cartao" <? if (@$obj->_cartao == 't') { ?>checked <? } ?>  />
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

<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
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
                    required: true

                },
                credor_devedor: {
                    required: true
                },
                parcelas: {
                    required: true
                }

            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                conta: {
                    required: "*"

                },
                credor_devedor: {
                    required: "*"
                },
                parcelas: {
                    required: "*"
                }
            }
        });
    });

</script>
