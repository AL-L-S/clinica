<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Produto</a></h3>

        <div>
            <form name="form_produto" id="form_produto" action="<?= base_url() ?>estoque/produto/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtestoqueprodutoid" class="texto10" value="<?= @$obj->_estoque_produto_id; ?>" />
                        <input type="text" name="nome" class="texto10" value="<?= @$obj->_descricao; ?>" />
                    </dd>
                    <dt>
                    <label>Sub-classe</label>
                    </dt>
                    <dd>
                        <select name="sub" id="sub" class="size4">
                            <? foreach ($sub as $value) : ?>
                                <option value="<?= $value->estoque_sub_classe_id; ?>"<?
                            if(@$obj->_sub_classe_id == $value->estoque_sub_classe_id):echo'selected';
                            endif;?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <dt>
                    <label>Unidade</label>
                    </dt>
                    <dd>
                        <select name="unidade" id="unidade" class="size4">
                            <? foreach ($unidade as $value) : ?>
                                <option value="<?= $value->estoque_unidade_id; ?>"<?
                            if(@$obj->_unidade_id == $value->estoque_unidade_id):echo'selected';
                            endif;?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <dt>
                    <label>Codigo</label>
                    </dt>
                    <dd>
                        <input type="text" name="codigo" id="codigo" class="texto2" value="<?= @$obj->_codigo; ?>" />
                    </dd>
                    
                    <dt>
                    <label>NCM</label>
                    </dt>
                    <dd>
                        <input type="text" name="ncm" id="ncm" class="texto2" value="<?= @$obj->_ncm; ?>" />
                    </dd>
                    
                    <dt>
                    <label>Valor de compra</label>
                    </dt>
                    <dd>
                        <input type="text" id="compra" alt="decimal" class="texto02" name="compra" value="<?= @$obj->_valor_compra; ?>" />
                    </dd>
                    <dt>
                    <label>Valor de venda</label>
                    </dt>
                    <dd>
                        <input type="text" id="venda" alt="decimal" class="texto02" name="venda" value="<?= @$obj->_valor_venda; ?>" />
                    </dd>
                    
                    <dt>
                    <label>Estoque minimo</label>
                    </dt>
                    <dd>
                        <input type="text" id="minimo" alt="integer" class="texto02" name="minimo" value="<?= @$obj->_estoque_minimo; ?>" />
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
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>estoque/produto');
    });
    $(function() {
        $( "#txtCidade" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtCidade" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCidade" ).val( ui.item.value );
                $( "#txtCidadeID" ).val( ui.item.id );
                return false;
            }
        });
    });
    
    $(function() {
        $( "#procedimento" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentoproduto",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#procedimento" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#procedimento" ).val( ui.item.value );
                $( "#procedimentoID" ).val( ui.item.id );
                return false;
            }
        });
    });


    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_produto').validate( {
            rules: {
                nome: {
                    required: true,
                    minlength: 3
                },
                compra: {
                    required: true
                },
                venda: {
                    required: true
                },
                minimo: {
                    required: true
                }
   
            },
            messages: {
                nome: {
                    required: "*",
                    minlength: "*"
                },
                compra: {
                    required: "*"
                },
                venda: {
                    required: "*"
                },
                minimo: {
                    required: "*"
                }
            }
        });
    });

</script>
