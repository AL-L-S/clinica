<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario</a></h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ponto/horariostipo/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txthorariostipoID" value="<?= @$obj->_horariostipo_id; ?>" />
                        <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->_nome; ?>" />
                    </dd>

                    
                        <dt>
                        <label>Tipo</label>
                        </dt>
                        <dd>
                            <select name="txtTipo" id="txtTipo" class="size2">
                                <option value="Fixo" <? if (@$obj->_tipo == 'Fixo'):echo 'selected';
                    endif; ?>>Fixo</option>
                                <option value="Variavel" <? if (@$obj->_tipo == 'Variavel'):echo 'selected';
                    endif; ?>>Variavel</option>
                                <option value="Semiflexivel" <? if (@$obj->_tipo == 'Semiflexivel'):echo 'selected';
                    endif; ?>>Semiflexivel</option>
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
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_horariostipo').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtTipo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtTipo: {
                    required: "*"
                }
            }
        });
    });

</script>