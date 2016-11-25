<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>ponto/setor">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Setor</a></h3>
        <div>
            <form name="form_setor" id="form_setor" action="<?= base_url() ?>ponto/setor/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtsetorID" value="<?= @$obj->_setor_id; ?>" />
                        <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                        <label>SIGLA</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtSIGLA" class="texto3 bestupper" value="<?= @$obj->_sigla; ?>"/>
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
        $(location).attr('href', '<?= base_url(); ?>ponto/setor');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_setor').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtSIGLA: {
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtSIGLA: {
                    minlength: "!"
                }
            }
        });
    });

</script>