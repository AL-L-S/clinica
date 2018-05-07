<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="singular"><a href="#">Cadastro de Contato</a></h3>
    <div>
        <form name="form_operador" id="form_operador" action="<?= base_url() ?>seguranca/operador/gravaragendatelefonica" method="post">
            <fieldset>
                <legend>Dados do Contato</legend>
                <div>
                    <label>Nome *</label>                      
                    <input type ="hidden" name ="agenda_telefonica_id" value ="<?= @$agenda[0]->agenda_telefonica_id; ?>" id ="txtoperadorId">
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$agenda[0]->nome; ?>" />
                </div>


                <div>
                    <label>Telefone1</label>
                    <input type="text" id="telefone1" name="telefone1"  class="texto04" value="<?= @$agenda[0]->telefone1; ?>" />
                </div>
                <div>
                    <label>Telefone2</label>
                    <input type="text" id="telefone2" name="telefone2"  class="texto04" value="<?= @$agenda[0]->telefone2; ?>" />
                </div>
                <div>
                    <label>Telefone3</label>
                    <input type="text" id="telefone3" name="telefone3"  class="texto04" value="<?= @$agenda[0]->telefone3; ?>" />
                </div>


            </fieldset>

            <button type="submit" name="btnEnviar">Enviar</button>

            <button type="reset" name="btnLimpar">Limpar</button>
            <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
        </form>
    </div>

</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>sca/operador');
    });


    jQuery("#telefone1")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    jQuery("#telefone2")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    jQuery("#telefone3")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });


    $(function () {
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#txtcbo").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cboprofissionais",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtcbo").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtcbo").val(ui.item.value);
                $("#txtcboID").val(ui.item.id);
                return false;
            }
        });
    });

    $(document).ready(function () {
        jQuery('#form_operador').validate({
            rules: {
                nome: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                nome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>