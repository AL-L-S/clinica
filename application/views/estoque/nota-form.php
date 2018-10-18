<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Nota Fiscal</a></h3>

        <div>
            <form name="form_nota" id="form_nota" action="<?= base_url() ?>estoque/nota/gravar" method="post">

                <dl class="dl_desconto_lista">                                        
                    <dt>
                    <label>Nota Fiscal</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtestoque_nota_id" id="txtestoque_nota_id" value="<?= @$obj->_estoque_nota_id; ?>" />                        
                        <input type="text" id="nota" alt="integer" class="texto04" name="nota" value="<?= @$obj->_nota_fiscal; ?>" required="" />
                    </dd>
                    <dt>
                    <label>Fornecedor</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtfornecedor" id="txtfornecedor" value="<?= @$obj->_fornecedor_id; ?>" />
                        <input type="text" name="txtfornecedorlabel" id="txtfornecedorlabel" class="texto04" value="<?= @$obj->_fornecedor; ?>" required=""/>
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
                    <label>Valor da Nota Fiscal</label>
                    </dt>
                    <dd>
                        <input type="text" id="valornota" alt="decimal" class="texto02" name="valornota" value="<?= @$obj->_valor_nota; ?>" required=""/>
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