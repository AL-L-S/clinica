<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Copiar Procedimentos Convenio</a></h3>
        <div>
            <form name="form_convenio" id="form_convenio" action="<?= base_url() ?>cadastros/convenio/gravarcopia" method="post">

                <dl class="dl_desconto_lista">

                    <dt>
                    <label>Copiar Convenio</label>
                    </dt>
                    <dd>
                        <select name="txtconvenio" id="txtconvenio" class="size4">
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                        <input type="hidden" name="txtconvenio_id"value="<?= $convenioid; ?>" />
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
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_sala').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
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