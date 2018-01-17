<div class="content ficha_ceatox">
    <h3 class="singular"><a href="#">Novo Grupo Indicação/Recomendação</a></h3>
    <div>
        <form name="form_indicacao" id="form_indicacao" action="<?= base_url() ?>ambulatorio/indicacao/gravargrupo" method="post">
            <fieldset>
                <div>
                    <label>Nome</label>
                    <input type="hidden" name="grupo_id" class="texto10" value="<?= @$grupo[0]->grupo_id; ?>" />
                    <input type="text" name="txtNome" id="txtNome" class="texto10" value="<?= @$grupo[0]->nome; ?>" />
                </div>
            </fieldset>
                <hr>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
        </form>
    </div>
</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script type="text/javascript">    

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_indicacao').validate( {
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