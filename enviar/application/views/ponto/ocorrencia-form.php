<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/ocorrencia">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Ocorrencia</a></h3>
        <div>
            <form name="form_ocorrencia" id="form_ocorrencia" action="<?= base_url() ?>ponto/ocorrencia/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtocorrenciaID" value="<?= @$obj->_ocorrencia_id; ?>" />
                        <select name="txtnome" id="txtnome" class="size2">
                            <option value="">Selecione</option>
                            <? foreach ($listaocorrenciatipo as $item) : ?>
                                <option value="<?= $item->ocorrenciatipo_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Data inicio</label>
                    </dt>
                    <dd>
                    <td><input type="text"  id="txtDatainicio" name="txtDatainicio" alt="date" class="size1" /></td>
                    </dd>
                    <dt>
                    <label>Data fim</label>
                    </dt>
                    <dd>
                    <td><input type="text"  id="txtDatafim" name="txtDatafim" alt="date" class="size1" /></td>
                    </dd>
                    <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="" rows="" name="txtobservacao" class="texto_area" ></textarea><br/>
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
        $(location).attr('href', '<?= base_url(); ?>ponto/ocorrencia');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_ocorrencia').validate( {
            rules: {
                txtnome: {
                    required: true,
                    minlength: 1
                },
                txtDatainicio: {
                    required: true,
                    minlength: 8
                },
                txtDatafim: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
                txtnome: {
                    required: "*",
                    minlength: "!"
                },
                txtDatainicio: {
                    required: "*",
                    minlength: "!"
                },
                txtDatafim: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>