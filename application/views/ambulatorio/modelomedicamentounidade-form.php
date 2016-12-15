<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Unidade</a></h3>
        <div>
            <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>ambulatorio/modelomedicamento/gravarunidade" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtunidadeid" id="txtunidadeid" class="texto10" value="<?= @$unidade[0]->unidade_id; ?>" />
                        <input type="text" name="txtDescricao" id="txtDescricao" class="texto10" value="<?= @$unidade[0]->descricao; ?>" />
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_unidade').validate( {
            rules: {
                txtDescricao: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtDescricao: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>