<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacientefisioterapiaencaixe" method="post">
        </fieldset>
        <fieldset>

            <legend>Manter Especialidade</legend>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1"  />
                <input type="hidden" name="txtpaciente_id"  value="<?= @$obj->_ambulatorio_pacientetemp_id; ?>" />
            </div>
            <div>
                <label>Medico</label>
                <select name="medico" id="medico" class="size4">
                    <option value="" >Selecione</option>
                    <? foreach ($medico as $item) : ?>
                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div>
                <label>Horarios</label>
                <input type="text" id="horarios" alt="time" class="size1" name="horarios" maxlength="8" onkeypress="mascara(this)" />
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
                <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" name="txtNome" class="texto10"/>
            </div>
            <div>
                <label>Dt de nascimento</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date"/>
            </div>
            <div>

                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone"  maxlength="14"  onkeypress="mascara2(this)"/>
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone"  maxlength="14"  onkeypress="mascara2(this)"/>
            </div>

            <div>
                <label>Convenio *</label>
                <select name="convenio" id="convenio" class="size4" required>
                    <option  value="0">Selecione</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select  name="procedimento" id="procedimento" class="size1" required>
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Qtde Sessões</label>
                <input type="text" name="qtde" id="qtde" class="texto01" readonly=""/>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>


</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">
<? if ($this->session->flashdata('message') != ""): ?>
                        alert("<? echo $this->session->flashdata('message'); ?>");
<? endif; ?>

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
                        $("#txtNascimento").datepicker({
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
                        $('#convenio').change(function () {
                            if ($(this).val()) {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniofisioterapia', {convenio1: $(this).val(), ajax: true}, function (j) {
                                    options = '<option value=""></option>';
                                    for (var c = 0; c < j.length; c++) {
                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                    }
                                    $('#procedimento').html(options).show();
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#procedimento').html('<option value="">Selecione</option>');
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
                                $("#txtTelefone").val(ui.item.itens);
                                $("#txtNascimento").val(ui.item.valor);
                                return false;
                            }
                        });
                    });

                    $(function () {
                        $('#procedimento').change(function () {
                            if ($(this).val()) {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                    qtde = "";
                                    qtde += j[0].qtde;
                                    document.getElementById("qtde").value = qtde;
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#qtde').html('value=""');
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
                                horarios: {
                                    required: true,
                                    minlength: 5
                                }
                            },
                            messages: {
                                data_ficha: {
                                    required: "*"
                                },
                                horarios: {
                                    required: "*",
                                    minlength: "!"
                                }
                            }
                        });
                    });

                    jQuery("#txtTelefone").mask("(99) 9999-9999");
                    jQuery("#txtCelular").mask("(99) 99999-9999");
                    jQuery("#txtNascimento").mask("99/99/9999");
                    jQuery("#horarios").mask("99:99");

</script>
