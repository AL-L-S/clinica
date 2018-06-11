<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Hospital</a></h3>
        <div>
            <form name="form_empresa" id="form_empresa" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarhospital" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtempresaid" class="texto10" value="<?= @$hospital[0]->hospital_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$hospital[0]->nome; ?>" />
                    </dd>
<!--<dt>
                    <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtrazaosocial" id="txtrazaosocial" class="texto10" value="<?= @$hospital[0]->razao_social; ?>" />
                    </dd>-->
<!--                    <dt>
                    <label>CNPJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$hospital[0]->cnpj; ?>" />
                    </dd>
                    <dt>
                    <label>CNES</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNES" maxlength="14" class="texto03" value="<?= @$hospital[0]->cnes; ?>" />
                    </dd>-->
                    <dt>
                    <label>Endere&ccedil;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$hospital[0]->logradouro; ?>" />
                    </dd>
                    <dt>
                    <label>N&uacute;mero</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$hospital[0]->numero; ?>" />
                    </dd>
                    <dt>
                    <label>Bairro</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$hospital[0]->bairro; ?>" />
                    </dd>
                    <dt>
                    <label>CEP</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCEP" class="texto02" name="cep" alt="cep" value="<?= @$hospital[0]->cep; ?>" />
                    </dd>
                    <dt>
                    <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtTelefone" class="texto03" name="telefone" alt="phone" value="<?= @$hospital[0]->telefone; ?>" />
                    </dd>
                    <dt>
                    <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCelular" class="texto03" name="celular" alt="phone" value="<?= @$hospital[0]->celular; ?>" />
                    </dd>
                    <dt>
                    <label>Município</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$hospital[0]->municipio_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$hospital[0]->municipio; ?>" />
                    </dd>
                    <dt>
                    <label>Valor Taxa</label>
                    </dt>
                    <dd>
                        <input type="text" id="valor_taxa" class="texto02" name="valor_taxa" alt="decimal" value="<?= @$hospital[0]->valor_taxa; ?>" />
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
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
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

    $(document).ready(function(){
        jQuery('#form_empresa').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>