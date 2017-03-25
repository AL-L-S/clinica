
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div style="width: 100%">
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/empresa/gravarconfiguracaosms/" method="post">
            <fieldset>
                <legend>Dados do Pacote</legend>
                <div style="width: 100%">
                    <label>Pacote</label>
                    <input type="hidden" name="sms_id" value="<?= @$mensagem[0]->empresa_sms_id ?>"/>
                    <input type="hidden" name="empresa_id" value="<?= $empresa_id ?>"/>
                    <select name="txtpacote" id="txtpacote" class="size2" required="">
                        <option value="">Selecione</option>
                        <? foreach ($pacotes as $item) : ?>
                            <option value="<?= $item->pacote_sms_id; ?>" <?= (@$item->pacote_sms_id == @$mensagem[0]->pacote_id) ? "selected" : ''; ?>>
                                <?= $item->descricao_pacote; ?>
                            </option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div style="width: 100%">
                    <label>Mensagem Confirmaçao</label>
                    <input type="text" id="txtMensagemConfirmacao" class="mensagem_texto" name="txtMensagemConfirmacao" value="<?= @$mensagem[0]->mensagem_confirmacao ?>"/>
                </div>
                <div  style="width: 100%">
                    <label>Mensagem de Agradecimento</label>
                    <input type="text" id="txtMensagemAgradecimento" class="mensagem_texto" name="txtMensagemAgradecimento" value="<?= @$mensagem[0]->mensagem_agradecimento ?>"/>
                </div>
                <div style="width: 100%">
                    <label>Mensagem de Aniversariantes</label>
                    <input type="text" id="txtMensagemAniversariantes" class="mensagem_texto" name="txtMensagemAniversariantes" value="<?= @$mensagem[0]->mensagem_aniversariante ?>"/>
                </div>

                <div style="width: 100%">
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                </div>
            </fieldset>
        </form>
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<style>
    .mensagem_texto{
        width: 500pt;
        /*font-size: 18pt;*/
        /*height: 50pt;*/
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#data1").datepicker({
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
        $("#data2").datepicker({
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
        $("#data3").datepicker({
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
        $("#data4").datepicker({
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
        $("#data5").datepicker({
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
        $("#data6").datepicker({
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
        $("#data7").datepicker({
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
        $("#data8").datepicker({
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
        $("#data9").datepicker({
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
        $("#data10").datepicker({
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
        $("#medico1").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico1").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico1").val(ui.item.value);
                $("#crm1").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico2").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico2").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico2").val(ui.item.value);
                $("#crm2").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico3").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico3").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico3").val(ui.item.value);
                $("#crm3").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico4").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico4").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico4").val(ui.item.value);
                $("#crm4").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico5").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico5").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico5").val(ui.item.value);
                $("#crm5").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico6").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico6").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico6").val(ui.item.value);
                $("#crm6").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico7").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico7").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico7").val(ui.item.value);
                $("#crm7").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico8").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico8").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico8").val(ui.item.value);
                $("#crm8").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico9").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico9").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico9").val(ui.item.value);
                $("#crm9").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#medico10").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
            minLength: 3,
            focus: function (event, ui) {
                $("#medico10").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medico10").val(ui.item.value);
                $("#crm10").val(ui.item.id);
                return false;
            }
        });
    });




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
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor1").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor1').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio2').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio2', {convenio2: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento2').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento2').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento2').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor2', {procedimento2: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor2").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor2').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio3').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio3', {convenio3: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento3').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento3').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento3').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor3', {procedimento3: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor3").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor3').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio4').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio4', {convenio4: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento4').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento4').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento4').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor4', {procedimento4: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor4").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor4').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio5').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio5', {convenio5: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento5').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento5').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento5').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor5', {procedimento5: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor5").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor5').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio6').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio6', {convenio6: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento6').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento6').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento6').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor6', {procedimento6: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor6").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor6').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio7').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio7', {convenio7: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento7').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento7').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento7').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor7', {procedimento7: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor7").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor7').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio8').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio8', {convenio8: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento8').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento8').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento8').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor8', {procedimento8: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor8").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor8').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio9').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio9', {convenio9: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento9').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento9').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento9').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor9', {procedimento9: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor9").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor9').html('value=""');
            }
        });
    });

    $(function () {
        $('#convenio10').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio10', {convenio10: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento10').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento10').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $('#procedimento10').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor10', {procedimento10: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor10").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor10').html('value=""');
            }
        });
    });

    $(function () {
        $('#procedimento1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento1').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento2').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento2', {procedimento2: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento2').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento2').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento3').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento3', {procedimento3: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento3').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento3').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento4').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento4', {procedimento4: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento4').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento4').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento5').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento5', {procedimento5: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento5').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento5').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento6').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento6', {procedimento6: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento6').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento6').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento7').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento7', {procedimento7: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento7').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento7').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento8').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento8', {procedimento8: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento8').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento8').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento9').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento9', {procedimento9: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento9').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento9').html('<option value="0">Selecione</option>');
            }
        });
    });

    $(function () {
        $('#procedimento10').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento10', {procedimento10: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value="0">Selecione</option>';
                    for (var c = 0; c < j.length; c++) {
                        if (j[c].forma_pagamento_id != null) {
                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                        }
                    }
                    $('#formapamento10').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#formapamento10').html('<option value="0">Selecione</option>');
            }
        });
    });
//            $(function(){
//        $('#procedimento2').change(function(){
//            if( $(this).val() ) {
//                $('.carregando').show();
//                $.getJSON('<?= base_url() ?>autocomplete/listarautocompleteprocedimentosforma',{procedimento2:$(this).val(), ajax:true}, function(j){
//                    var options = '<option value=""></option>';	
//                    for (var c = 0; c < j.length; c++) {
//                        options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
//                    }	
//                    $('#formapamento2').html(options).show();
//                    $('.carregando').hide();
//                });
//            } else {
//                $('#formapamento2').html('<option value="0">Selecione</option>');
//            }
//        });
//    });

    //$(function(){     
    //    $('#exame').change(function(){
    //        exame = $(this).val();
    //        if ( exame === '')
    //            return false;
    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
    //            var option = new Array();
    //            $.each(data, function(i, obj){
    //                console.log(obl);
    //                option[i] = document.createElement('option');
    //                $( option[i] ).attr( {value : obj.id} );
    //                $( option[i] ).append( obj.nome );
    //                $("select[name='horarios']").append( option[i] );
    //            });
    //        });
    //    });
    //});





    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_exametemp').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                nascimento: {
                    required: true
                },
                idade: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                nascimento: {
                    required: "*"
                },
                idade: {
                    required: "*"
                }
            }
        });
    });

    function calculoIdade() {
        var data = document.getElementById("txtNascimento").value;
        var ano = data.substring(6, 12);
        var idade = new Date().getFullYear() - ano;
        document.getElementById("txtIdade").value = idade;
    }

    calculoIdade();

</script>
