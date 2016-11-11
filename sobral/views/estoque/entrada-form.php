<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Entrada</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>estoque/entrada/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Produto</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtestoque_entrada_id" id="txtestoque_entrada_id" value="<?= @$obj->_estoque_entrada_id; ?>" />
                        <input type="hidden" name="txtproduto" id="txtproduto" value="<?= @$obj->_produto_id; ?>" />
                        <input type="text" name="txtprodutolabel" id="txtprodutolabel" class="texto10" value="<?= @$obj->_produto; ?>" />
                    </dd>
                    <dt>
                    <label>Fornecedor</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtfornecedor" id="txtfornecedor" value="<?= @$obj->_fornecedor_id; ?>" />
                        <input type="text" name="txtfornecedorlabel" id="txtfornecedorlabel" class="texto10" value="<?= @$obj->_fornecedor; ?>" />
                    </dd>
                    <dt>
                    <label>Armazem</label>
                    </dt>
                    <dd>
                        <select name="txtarmazem" id="txtarmazem" class="size4">
                            <? foreach ($sub as $value) : ?>
                                <option value="<?= $value->estoque_armazem_id; ?>"<?
                            if(@$obj->_armazem_id == $value->estoque_armazem_id):echo'selected';
                            endif;?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Valor de compra</label>
                    </dt>
                    <dd>
                        <input type="text" id="compra" alt="decimal" class="texto02" name="compra" value="<?= @$obj->_valor_compra; ?>" />
                    </dd>
                    <dt>
                    <label>Quantidade</label>
                    </dt>
                    <dd>
                        <input type="text" id="quantidade" class="texto02" alt="integer" name="quantidade" value="<?= @$obj->_quantidade; ?>" />
                    </dd>
                    <dt>
                    <label>Nota Fiscal</label>
                    </dt>
                    <dd>
                        <input type="text" id="nota" alt="integer" class="texto02" name="nota" value="<?= @$obj->_nota_fiscal; ?>" />
                    </dd>
                    <dt>
                    <label>Validade</label>
                    </dt>
                    <dd>
                        <input type="text" id="validade" class="texto02" name="validade" value="<?= substr(@$obj->_validade, 8,2) . "/" . substr(@$obj->_validade, 5,2) . "/" . substr(@$obj->_validade, 0,4); ?>" />
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

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    
    $(function() {
        $( "#txtfornecedorlabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedor",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtfornecedorlabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtfornecedorlabel" ).val( ui.item.value );
                $( "#txtfornecedor" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtprodutolabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=produto",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtprodutolabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtprodutolabel" ).val( ui.item.value );
                $( "#txtproduto" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#validade" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    
    
    $(document).ready(function(){
        jQuery('#form_entrada').validate( {
            rules: {
                txtproduto: {
                    required: true
                },
                quantidade: {
                    required: true
                },
                compra: {
                    required: true
                }
   
            },
            messages: {
                txtproduto: {
                    required: "*"
                },
                quantidade: {
                    required: "*"
                },
                compra: {
                    required: "*"
                }
            }
        });
    });
    

    $(function() {
        $( "#accordion" ).accordion();
    });
</script>