<div  class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>laboratorio/laboratorio">
            Voltar
        </a>
    </div>
    <!-- div nova-->
    <div id="accordion" >
            <h3 class="singular"><a href="#">Solicitar Exame</a></h3>
            <form name="form_laboratiorio" id="form_laboratorio" action="<?= base_url() ?>laboratorio/laboratorio/gravar" method="post">
                <fieldset>
                    
                    <dl >
                        <dt>
                            <label>Paciente</label>
                        </dt>
                        <dd>
                            <input type="text" id="paciente" class="size4" name="paciente" />
                        </dd>
                        <dt>
                            <label>Nome</label>
                        </dt>
                        <dd>
                            <input type="text" name="txtNome" id="txtNome" class="size4" value="<?= @$obj->_nome; ?>" readonly="true"/>

                        </dd>
                        <dt>
                            <label>Be</label>
                        </dt>
                        <dd>
                            <input type="text" id="txtBe" name="txtBe"  class="texto02" value="<?= @$obj->_be; ?>" readonly="true"/>
                        </dd>

                        <dt>
                            <label>Unidade</label>
                        </dt>
                        <dd>
                            <input type="text" name="txtUnidade" id="txtUnidade" class="size4" value="<?= @$obj->_unidade; ?>"/>
                        </dd>
                        <dt>
                            <label>Leito</label>
                        </dt>
                        <dd>
                            <input type="text" name="txtLeito" id="txtLeito" name="txtLeito"  class="texto02" value="<?= @$obj->_leito; ?>"/>
                        </dd>
                        <dt>
                            <label>Observações</label>
                        </dt>
                        <dd>
                            <input type="text" id="txtObservacao" name="txtObservacao"  class="size4" value="<?= @$obj->_observacao; ?>" />
                        </dd>
                        </dl>
                    </fieldset>
                
                <?php if (@$obj->_leito == ""){?>
                    <button type="submit">Enviar</button>
                    <button type="reset">Limpar</button>

                    <a href="<?= base_url() ?>laboratorio/laboratorio">
                       <button type="button" id="btnVoltar">Voltar</button>
                    </a>
                    <br>
                    <?php }?>

                </form>
            </div>

    </div> <!-- Final da DIV content -->


    <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        $( "#accordion" ).accordion();
    });

     $(function() {
        $( "#paciente" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=pacientebe",
            minLength: 4,
            focus: function( event, ui ) {
                $( "#paciente" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#paciente" ).val( ui.item.value );
                $( "#txtBe" ).val( ui.item.be );
                $( "#txtNome" ).val( ui.item.nome );
                $( "#txtIdade" ).val( ui.item.idade );
                $( "#txtDataNascimento" ).val( ui.item.nascimento );
                return false;
            }
        });
    });

    $(document).ready(function(){
        jQuery('#form_laboratorio').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 4
                },
                txtBe: {
                    required: true,
                    verificaCPF: true,
                    minlength: 11,
                    maxlenght: 11
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtBe: {
                    required: "*",
                    minlength: "!",
                    verificaCPF: "CPF inválido"
                }
            }
        });
    });

</script>