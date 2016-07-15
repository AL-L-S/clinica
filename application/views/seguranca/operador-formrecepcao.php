<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="singular"><a href="#">Cadastro de Operador</a></h3>
    <div>
        <form name="form_operador" id="form_operador" action="<?= base_url() ?>seguranca/operador/gravarrecepcao" method="post">
            <fieldset>
                <legend>Dados do Profissional</legend>
                <div>
                    <label>Nome *</label>                      
                    <input type ="hidden" name ="operador_id" value ="<?= @$obj->_operador_id; ?>" id ="txtoperadorId">
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$obj->_nome; ?>" />
                </div>
                <div>
                    <label>Sexo *</label>


                    <select name="sexo" id="txtSexo" class="size2">
                        <option value="M" <?
if (@$obj->_sexo == "M"):echo 'selected';
endif;
?>>Masculino</option>
                        <option value="F" <?
                                if (@$obj->_sexo == "F"):echo 'selected';
                                endif;
?>>Feminino</option>
                    </select>
                </div>

                <div>
                    <label>Conselho</label>
                    <input type="text" id="txtconselho" name="conselho"  class="texto04" value="<?= @$obj->_conselho; ?>" />
                </div>
                                <div>
                    <label>Ocupa&ccedil;&atilde;o</label>
                    <input type="hidden" id="txtcboID" class="texto_id" name="txtcboID" value="<?= @$obj->_cbo_ocupacao_id; ?>" readonly="true" />
                    <input type="text" id="txtcbo" class="texto04" name="txtcbo" value="<?= @$obj->_cbo_nome; ?>" />

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
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>sca/operador');
    });


    $(function() {
        $( "#txtCidade" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtCidade" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCidade" ).val( ui.item.value );
                $( "#txtCidadeID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtcbo" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=cboprofissionais",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtcbo" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtcbo" ).val( ui.item.value );
                $( "#txtcboID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(document).ready(function(){
        jQuery('#form_operador').validate( {
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