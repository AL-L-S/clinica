<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteexameencaixe" method="post">
        </fieldset>
        <fieldset>

            <legend>Manter Exames</legend>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1"  />
                <input type="hidden" name="txtpaciente_id"  value="<?= @$obj->_ambulatorio_pacientetemp_id; ?>" />
            </div>
            <div>
                <label>Sala</label>
                <select name="sala" id="sala" class="size4">
                    <option value="" >Selecione</option>
                    <? foreach ($salas as $item) : ?>
                        <option value="<?= $item->exame_sala_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Medico</label>
                <select name="medico" id="medico" class="size2">
                    <option value="" >Selecione</option>
                    <? foreach ($medico as $item) : ?>
                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Horarios</label>
                <input type="time" id="horarios" name="horarios"  class="size1"  maxlength="8"  onkeypress="mascara(this)" onclick="if (this.value !== '')
                            this.value = ''" />
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
                <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" name="txtNome" class="texto10"/>
            </div>
            <div>
                <label>Dt de nascimento</label>
                <input type="text" name="nascimento" id="nascimento" class="texto02" maxlength="10" onkeypress="mascara3(this)"/>
            </div>
            <div>

                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone" maxlength="14"  onkeypress="mascara2(this)"/>
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="celular"  maxlength="14"  onkeypress="mascara2(this)" />
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>


</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

<?php if ($this->session->flashdata('message') != ''): ?>
                        alert("<? echo $this->session->flashdata('message') ?>");
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

                    /* Máscaras ER */
                    function mascara(horarios) {
                        if (horarios.value.length == 2)
                            horarios.value = horarios.value + ':'; //quando o campo já tiver 2 caracteres (2 números) o script irá inserir um ':'.

                        if (horarios.value.length == 5)
                            horarios.value = horarios.value + ':'; //quando o campo já tiver 5 caracteres (2 números + ':' + 2 números), o script irá inserir um ':'.      
                    }

                    function mascara2(horarios) {
                        if (horarios.value !== '') {
                            if (horarios.value.length == 1)
                                horarios.value = '(' + horarios.value;

                            if (horarios.value.length == 3)
                                horarios.value = horarios.value + ') ';

                            if (horarios.value.length == 9)
                                horarios.value = horarios.value + '-';

                        }
                    }

                    function mascara3(horarios) {
                        if (horarios.value !== '') {
                            if (horarios.value.length == 2)
                                horarios.value = horarios.value + '/';

                            if (horarios.value.length == 5)
                                horarios.value = horarios.value + '/';


                        }
                    }

</script>
