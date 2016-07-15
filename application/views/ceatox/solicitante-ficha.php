<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ceatox/solicitante">
            Voltar
        </a>
    </div>
        
        <div id="accordion">
            <h3 class="singular"><a href="#">Solicita&ccedil;&atilde;o de Acolhimento</a></h3>
            <form name="form_ceatox" id="form_ceatox" action="<?= base_url() ?>ceatox/solicitante/gravar" method="post">
                <fieldset>
                    <dl id="dl_form_servidor">
                        <dt>
                            <label>Solicitante</label>
                        </dt>
                        <dd>
                            <input type ="hidden" name ="ceatox_solicitante_id" value ="<?= @$obj->_ceatox_solicitante_id; ?>" id ="ceatox_solicitante_id">
                            <input type="text" name="txtNome" id="nome" class="size4" value="<?= @$obj->_nome; ?>"/>
                            
                        </dd>
                        <dt>
                            <label>Endere&ccedil;o</label>
                        </dt>
                        <dd>
                            <input type="text" id="endereco" name="txtEndereco"  class="texto07" value="<?= @$obj->_endereco; ?>"/>
                        </dd>
                        <dt>
                            <label>Complemento</label>
                        </dt>
                        <dd>
                            <input type="text" id="complemento" name="txtComplemento"  class="texto07" value="<?= @$obj->_complemento; ?>" />
                        </dd>
                        <dt>
                            <label>Bairro</label>
                        </dt>
                        <dd>
                            <input type="text" id="bairro" name="txtBairro"  class="texto07" value="<?= @$obj->_bairro; ?>" />
                        </dd>
                        <dt>
                            <label>Munic&iacute;pio</label>
                        </dt>
                        <dd>
                            <input type="text" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" readonly="true" />
                            <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" />
                        </dd>
                        
                        <dt>
                            <label>Institui&ccedil;&atilde;o</label>
                        </dt>
                        <dd>
                            <input type="text" id="instituicao" name="txtInstituicao"  class="texto09" value="<?= @$obj->_instituicao; ?>" />
                        </dd>
                        <dt>
                            <label>Telefone</label>
                        </dt>
                        <dd>
                            <input type="text" id="txtTelefone" class="texto02" name="txtTelefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
                        </dd>
                        <dt>
                            <label>Ramal</label>
                        </dt>
                        <dd>
                            <input type="text" id="ramal" name="txtRamal"  class="texto09" value="<?= @$obj->_ramal; ?>" />
                        </dd>
                        
                         
                        </dl>
                    </fieldset>
                    <button type="submit">Enviar</button>
                    <button type="reset">Limpar</button>
                  
                    <a href="<?= base_url() ?>ceatox/solicitante">
                       <button type="button" id="btnVoltar">Voltar</button>
                    </a>
                    
                </form>
            </div>
        
    </div> <!-- Final da DIV content -->
    <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
    <script type="text/javascript">
    $(function() {
        $( "#accordion" ).accordion();
    });
    $(function() {
            $( "#txtCidade" ).autocomplete({
                source: "<?= base_url() ?>index?c=autocomplete&m=cidade",
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
</script>