<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Fornecedor</a></h3>

        <div>
            <form name="form_fornecedor" id="form_fornecedor" action="<?= base_url() ?>farmacia/fornecedor/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome Fantasia</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtfantasia" id="txtfantasia" class="texto10" value="<?= @$obj->_fantasia; ?>" />
                    </dd>
                    <dt>
                    <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtfarmaciafornecedorid" class="texto10" value="<?= @$obj->_farmacia_fornecedor_id; ?>" />
                        <input type="text" name="txtrazaosocial" id="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                    <label>CNPJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$obj->_cnpj; ?>" />
                    </dd>
                    <dt>
                    <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="txttipo_id" id="txttipo_id" class="size4">
                            <? foreach ($tipo as $value) : ?>
                                <option value="<?= $value->tipo_logradouro_id; ?>"<?
                            if(@$obj->_tipo_logradouro_id == $value->tipo_logradouro_id):echo'selected';
                            endif;?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Endere&ccedil;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_logradouro; ?>" />
                    </dd>
                    <dt>
                    <label>N&uacute;mero</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" />
                    </dd>
                    <dt>
                    <label>Bairro</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" />
                    </dd>
                    <dt>
                    <label>Complemento</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtComplemento" class="texto10" name="complemento" value="<?= @$obj->_complemento; ?>" />
                    </dd>
                    <dt>
                    <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
                    </dd>
                    <dt>
                    <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                    </dd>
                    <dt>
                    <label>Município</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_municipio_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_nome; ?>" />
                    </dd>
                     <dt>
                    <label>Criar Credor</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="criarcredor"/>
                    </dd>
                    <dt>
                    <label>Credor / Devedor</label>
                    </dt>
                    <dd>
                        <select name="credor_devedor" id="credor_devedor" class="size2" >
                            <option value='' >selecione</option>
                            <?php
                            $credor_devedor = $this->convenio->listarcredordevedor();
                            foreach ($credor_devedor as $item) {
                                ?>

                                <option   value =<?php echo $item->financeiro_credor_devedor_id; ?> <?
                                if (@$obj->_credor_devedor_id == $item->financeiro_credor_devedor_id):echo 'selected';
                                endif;
                                ?>><?php echo $item->razao_social; ?></option>
                                          <?php
                                      }
                                      ?> 
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
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>farmacia/fornecedor');
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
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_fornecedor').validate( {
            rules: {
                txtrazaosocial: {
                    required: true,
                    minlength: 3
                },
                txtfantasia: {
                    required: true,
                    minlength: 3
                }
   
            },
            messages: {
                txtrazaosocial: {
                    required: "*",
                    minlength: "!"
                },
                txtfantasia: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>