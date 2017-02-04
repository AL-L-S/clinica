<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteencaixegeral" method="post">
        </fieldset>
        <fieldset>

            <legend>Agenda Geral</legend>
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
                <input type="text" id="horarios" class="size1" name="horarios"/>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio1" id="convenio1" class="size4" required>
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select  name="procedimento1" id="procedimento1" class="size1" required>
                    <option value="">Selecione</option>
                </select>
            </div>
<!--            <div>
                <label>Tipo</label>
                <select  name="tipo" id="tipo" class="size1" >
                    <option value="EXAME">Exame</option>
                    <option value="CONSULTA">Consulta</option>
                </select>
            </div>-->
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
                <input type="text" name="nascimento" id="nascimento" class="texto02"/>
            </div>
            <div>

                <input type="hidden" name="idade" id="txtIdade" class="texto01"/>
            </div>
            <div>
                <label>End.</label>
                <input type="text" id="txtEnd" class="texto06" name="txtEnd" />
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone"/>
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="celular"/>
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">



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
                        $('#medico').change(function () {
                            if ($(this).val()) {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio', {exame: $(this).val(), ajax: true}, function (j) {
                                    var options = '<option value=""></option>';
                                    for (var i = 0; i < j.length; i++) {
                                        options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                    }
                                    $('#convenio1').html(options).show();
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#convenio1').html('<option value="">-- Escolha um hora --</option>');
                            }
                        });
                    });

                    $(function () {
                        $('#convenio1').change(function () {
//                            alert('entrou');
                            if ($(this).val()) {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedico', {convenio1: $(this).val(), teste: $("#medico").val()}, function (j) {
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
                                $("#txtEnd").val(ui.item.endereco);
                                return false;
                            }
                        });
                    });


                    $(function () {
                        $("#accordion").accordion();
                    });
                  
                    

                    jQuery("#telefone").mask("(99) 9999-9999");
                    jQuery("#txtCelular").mask("(99) 99999-9999");
                    jQuery("#nascimento").mask("99/99/9999");
                    jQuery("#horarios").mask("99:99");

</script>
