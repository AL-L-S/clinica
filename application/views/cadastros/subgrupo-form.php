<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Subgrupo</a></h3>
        <div>
            <form name="form_grupoclassificacao" id="form_grupoclassificacao" action="<?= base_url() ?>cadastros/grupoclassificacao/gravarsubgrupo" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="ambulatorio_subgrupo_id" class="texto10" value="<?= @$obj[0]->ambulatorio_subgrupo_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj[0]->nome; ?>" />
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

    $(function() {
        $( "#accordion" ).accordion();
    });


</script>