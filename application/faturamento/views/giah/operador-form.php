<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>giah/operador">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Operador</a></h3>
        <div>
            <form name="form_operador" id="form_operador" action="<?= base_url() ?>giah/operador/gravar" method="post">
                <dl id="dl_form_operador">

                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtNome" name="txtNome"  class="texto06" value="<?= @$obj->_usuario; ?>" />
                    </dd>
                    <dt>
                        <label>Nome usu&aacute;rio</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtUsuario" name="txtUsuario"  class="texto02" value="<?= @$obj->_usuario; ?>" />
                    </dd>
                    <dt>
                        <label>Senha</label>
                    </dt>
                    <dd>
                        <input type="password" name="txtSenha" id="txtSenha" class="texto02" value="<?= @$obj->_senha; ?>" />
                    </dd>
                    <dt>
                        <label>Tipo perfil</label>
                    </dt>
                    <dd>
                        <select name="txtPerfil" id="txtPerfil" class="size2">
                        <option value="">Selecione</option>
                            <? foreach ($listarPerfil as $item) : ?>
                                <option value="<?= $item->perfil_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                         </select>
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
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>sca/operador');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

     $(document).ready(function(){
        jQuery('#form_operador').validate( {
            rules: {
                txtUsuario: {
                    required: true,
                    minlength: 3
                },

                txtSenha: {
                    required: true,
                    minlength: 3
                },

                txtPerfil: {
                    required: true

                }

            },
            txtUsuario: {
                txtData: {
                    required: "*"
                },

                txtSenha: {
                    required: "*",
                    minlength: "!"
                },

                txtPerfil: {
                    required: "*"

                }
            }
        });
    });

</script>