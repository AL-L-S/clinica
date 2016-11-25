<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>giah/servidor">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Servidor</a></h3>
        <div>
            <form name="form_funcionario" id="form_funcionario" action="<?= base_url() ?>ponto/funcionario/gravar" method="post">

                <dl id="dl_form_servidor">
                    <dt>
                    <label>Matr&iacute;cula</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtFuncionarioID" value="<?= @$obj->_funcionario_id; ?>" />
                        <input type="text" name="txtMatricula" alt="numeromask" class="texto02" value="<?= @$obj->_matricula; ?>" />
                    </dd>
                    <dt>
                    <label>CPF</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCPF" maxlength="11" alt="cpf" class="texto03" value="<?= @$obj->_cpf; ?>" />
                    </dd>
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>"/>
                    </dd>
                    <dt>
                    <label>Email</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtemail" class="texto10" value="<?= @$obj->_email; ?>"/>
                    </dd>
                    <dt>
                    <label>Aniversario</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtaniversario" alt="99/99" class="texto02" value="<?= @$obj->_aniversario; ?>"/>
                    </dd>
                    <dt>
                    <label>Cargo</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCargo" class="texto_id" name="txtCargo" value="<?= @$obj->_cargo_id; ?>" readonly="true" />
                        <input type="text" id="txtCargoLabel" class="texto09" name="txtCargoLabel" value="<?= @$obj->_cargo; ?>" />
                    </dd>
                    <dt>
                    <label>Fun&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtFuncao" class="texto_id" name="txtFuncao" value="<?= @$obj->_funcao_id; ?>" readonly="true" />
                        <input type="text" id="txtFuncaoLabel" class="texto09" name="txtFuncaoLabel" value="<?= @$obj->_funcao; ?>" />
                    </dd>
                    <dt>
                    <label>Setor</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtSetor" class="texto_id" name="txtSetor" value="<?= @$obj->_setor_id; ?>" readonly="true" />
                        <input type="text" id="txtSetorLabel" class="texto09" name="txtSetorLabel" value="<?= @$obj->_setor; ?>" />
                    </dd>
                    </dt>
                    <dt>
                    <label>Escala</label>
                    <dd>
                        <input type="text" id="txtHorariostipo" class="texto_id" name="txtHorariostipo" value="<?= @$obj->_horariostipo_id; ?>" readonly="true" />
                        <input type="text" id="txtHorariostipoLabel" class="texto09" name="txtHorariostipoLabel" value="<?= @$obj->_horariostipo; ?>" />
                    </dd>
                    </dt>
                    <dt>
                    <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtTelefone" alt="phone" class="texto02" value="<?= @$obj->_telefone; ?>"/>
                    </dd>
                    <dt>
                    <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtcelular" alt="phone" class="texto02" value="<?= @$obj->_celular; ?>"/>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/funcionario');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });



    $(document).ready(function(){
        jQuery('#form_funcionario').validate( {
            rules: {

                txtNome: {
                    required: true,
                    minlength: 4
                },
                txtFuncao: {
                    required: true,
                    minlength: 1
                },
                txtSetor: {
                    required: true,
                    minlength: 1
                },
                txtCargo: {
                    required: true,
                    minlength: 1
                },
                txtHorariostipo: {
                    required: true,
                    minlength: 1
                },
                txtSetorLabel: {
                    required: true,
                    minlength: 1
                }

            },
            messages: {

                txtEndereco: {
                    required: "*",
                    minlength: "!"
                },
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtFuncao: {
                    required: "*",
                    minlength: "!"
                },
                txtSetor: {
                    required: "*",
                    minlength: "!"
                },
                txtCargo: {
                    required: "*",
                    minlength: "!"
                },
                txtHorariostipo: {
                    required: "*",
                    minlength: "!"
                },
                txtSetorLabel: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });
    
        $(function() {
        $( "#txtSetorLabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=setor",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtSetorLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtSetorLabel" ).val( ui.item.value );
                $( "#txtSetor" ).val( ui.item.id );
                return false;
            }
        });
    });
    $(function() {
        $( "#txtHorariostipoLabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=horariostipo",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtHorariostipoLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtHorariostipoLabel" ).val( ui.item.value );
                $( "#txtHorariostipo" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtCargoLabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cargo",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtCargoLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCargoLabel" ).val( ui.item.value );
                $( "#txtCargo" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtFuncaoLabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=funcao",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtFuncaoLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtFuncaoLabel" ).val( ui.item.value );
                $( "#txtFuncao" ).val( ui.item.id );
                return false;
            }
        });
    });

</script>
