
	<? $empresa_logada = $this->session->userdata('empresa_id'); ?>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteexameencaixe" method="post">
        </fieldset>
        <fieldset>

            <legend>Manter Exames</legend>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1" required/>
                <input type="hidden" name="txtpaciente_id"  value="<?= @$obj->_ambulatorio_pacientetemp_id; ?>" />
            </div>
            <div>
                <label>Sala</label>
                <select name="sala" id="sala" class="size4" required>
                    <option value="" >Selecione</option>
                    <? foreach ($salas as $item) : ?>
                        <option value="<?= $item->exame_sala_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Medico</label>
                <select name="medico" id="medico" class="size2" required>
                    <option value="" >Selecione</option>
                    <? foreach ($medico as $item) : ?>
                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Empresa</label>
                <select name="empresa" id="empresa" class="size1">
                    <?
                    foreach ($empresas as $value) :
                        ?>
                        <option value="<?= $value->empresa_id; ?>" <?
                        if ($empresa_logada == $value->empresa_id) {
                            echo 'selected';
                        }
                        ?>><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                </select>

            </div>
            <div>
                <label>Horarios</label>
                <input type="text" id="horarios" name="horarios"  class="size1" required/>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio1" id="convenio1" class="size4"  required>
                    <option  value="-1">Selecione</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select  name="procedimento1" id="procedimento1" class="size1" required>
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Observa&ccedil;&otilde;es</label>
                <input type="text" id="observacoes" class="size3" name="observacoes" />
            </div>


        </fieldset>
        <fieldset>
            <legend>Paciente</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" name="txtNome" class="texto10" required/>
            </div>
            <div>
                <label>Dt de nascimento</label>
                <input type="text" name="nascimento" id="nascimento" class="texto02"/>
            </div>
            <div>

                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone"/>
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="txtCelular"/>
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>


</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script>
    function mascaraTelefone(campo) {

        function trata(valor, isOnBlur) {

            valor = valor.replace(/\D/g, "");
            valor = valor.replace(/^(\d{2})(\d)/g, "($1)$2");

            if (isOnBlur) {

                valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
            } else {

                valor = valor.replace(/(\d)(\d{3})$/, "$1-$2");
            }
            return valor;
        }

        campo.onkeypress = function (evt) {

            var code = (window.event) ? window.event.keyCode : evt.which;
            var valor = this.value

            if (code > 57 || (code < 48 && code != 8)) {
                return false;
            } else {
                this.value = trata(valor, false);
            }
        }

        campo.onblur = function () {

            var valor = this.value;
            if (valor.length < 13) {
                this.value = ""
            } else {
                this.value = trata(this.value, true);
            }
        }

        campo.maxLength = 14;
    }


</script>
<script type="text/javascript">
    mascaraTelefone(form_exametemp.telefone);
    mascaraTelefone(form_exametemp.txtCelular);


                    $(function () {
                        $("#data_ficha").datepicker({
                            autosize: true,
                            changeYear: true,
                            changeMonth: true,
                            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                            buttonImage: '<?= base_url() ?>img/form/date.png',
                            dateFormat: 'dd/mm/yy'
                        });
                    });

                    $(function () {
                        $('#convenio1').change(function () {
                            if ($(this).val()) {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                                    options = '<option value=""></option>';
                                    for (var c = 0; c < j.length; c++) {
                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                    }
                                    $('#procedimento1').html(options).show();
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#procedimento1').html('<option value="">Selecione</option>');
                            }
                        });
                    });

                    $(function () {
                        $("#txtNome").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
                            minLength: 3,
                            focus: function (event, ui) {
                                $("#txtNome").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $("#txtNome").val(ui.item.value);
                                $("#txtNomeid").val(ui.item.id);
                                $("#telefone").val(ui.item.itens);
                                $("#txtCelular").val(ui.item.celular);
                                $("#nascimento").val(ui.item.valor);
                                return false;
                            }
                        });
                    });


                    $(function () {
                        $("#accordion").accordion();
                    });


                    $(document).ready(function () {
                        jQuery('#form_exametemp').validate({
                            rules: {
                                data_ficha: {
                                    required: true
                                },
                                sala: {
                                    required: true
                                },
                                medico: {
                                    required: true
                                },
                                txtNome: {
                                    required: true
                                },
                                horarios: {
                                    required: true,
                                    minlength: 5
                                }
                            },
                            messages: {
                                data_ficha: {
                                    required: "*"
                                },
                                sala: {
                                    required: "*"
                                },
                                medico: {
                                    required: "*"
                                },
                                txtNome: {
                                    required: "*"
                                },
                                horarios: {
                                    required: "*",
                                    minlength: "!"
                                }
                            }
                        });
                    });


                    jQuery("#nascimento").mask("99/99/9999");
                    jQuery("#horarios").mask("99:99");

</script>
