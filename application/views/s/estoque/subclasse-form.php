<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Classe</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/subclasse/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtestoquesub_classeid" class="texto10" value="<?= @$obj->_estoque_sub_classe_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_descricao; ?>" />
                    </dd>
                    <dt>
                    <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="txtclasse_id" id="txtclasse_id" class="size4">
                            <? foreach ($classe as $value) : ?>
                                <option value="<?= $value->classe_id; ?>"<? if (@$obj->_classe_id == $value->classe_id):echo 'selected';
                    endif;
                        ?>><?= $value->descricao; ?></option>
                            <? endforeach; ?>
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
        $(location).attr('href', '<?= base_url(); ?>estoque/subclasse');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_sala').validate( {
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