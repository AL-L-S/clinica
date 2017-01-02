<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Conta</a></h3>
        <div>
            <form name="form_forma" id="form_sala" action="<?= base_url() ?>cadastros/forma/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosformaid" class="texto10" value="<?= @$obj->_forma_entradas_saida_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_descricao; ?>" />
                    </dd>
                    <dt>
                    <label>Agencia</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtagencia" class="texto04" value="<?= @$obj->_agencia; ?>" />
                    </dd>
                    <dt>
                    <label>Conta</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtconta" class="texto04" value="<?= @$obj->_conta; ?>" />
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


    $(document).ready(function(){
        jQuery('#form_forma').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtagencia: {
                    required: true
                },
                txtconta: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtagencia: {
                    required: "*"
                },
                txtconta: {
                    required: "*"
                }
            }
        });
    });

</script>