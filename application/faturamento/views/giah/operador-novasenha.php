<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>giah/operador">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Nova Senha</a></h3>
        <div>
            <form name="form_novasenha" id="form_novasenha" action="<?= base_url() ?>giah/operador/gravarNovaSenha/" method="post">
                 <?foreach ($lista as $item) :?>
                <input type="hidden" name="txtOperadorID" value="<?= $item->operador_id; ?>" />
                <?endforeach;?>
                <dl id="dl_form_novasenha">
                    
                    <dt>
                        <label>Nova senha</label>
                    </dt>
                    <dd>
                        <input type="password" id="txtNovaSenha" name="txtNovaSenha"  class="texto02" value="<?= @$obj->_novasenha; ?>" />
                    </dd>
                    <dt>
                        <label>Confirma&ccedil;&atilde;o senha</label>
                    </dt>
                    <dd>
                        <input type="password" name="txtConfirmacao" id="txtConfirmacao" class="texto02" value="<?= @$obj->_confirmacao; ?>" />
                    </dd>

                </dl>
                <button type="submit" name="btnEnviar">Enviar</button>

                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>sca/operador');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

     $(document).ready(function(){
        jQuery('#form_novasenha').validate( {
            rules: {
                txtNovaSenha: {
                    required: true,
                    minlength: 3
                },

                txtConfirmacao: {
                    required: true,
                    minlength: 3
                }

            },
            messages: {
                txtNovaSenha: {
                    required: "*"
                },

                txtConfirmacao: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>