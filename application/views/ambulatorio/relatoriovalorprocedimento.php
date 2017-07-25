<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a > Gerar relatorio Caixa</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarrelatoriovalorprocedimento">
                <dl>
                    <dt>
                    <label>Convenio</label>
                    </dt>
                    <dd>
                        <select  name="convenio1" id="convenio1" class="size1">
                            <option value="-1">Selecione</option>
                            <? foreach ($convenio as $item) : ?>
                                <option value="<?= $item->convenio_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    <dt>
                    <label>Procedimento</label>
                    </dt>
                    <dd>
                        <select  name="procedimento1" id="procedimento1" class="size1" required="true">
                            <option value="">Selecione</option>
                        </select>
                    </dd>
                    <dt>
                    <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                    <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>

                    <dt>
                    <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                    <dt>
                </dl>
                <button type="submit" >Pesquisar</button>

            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        $("#txtdata_inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $("#txtdata_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


            $(function() {
                $('#convenio1').change(function() {
                    if ($(this).val()) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioajustarvalor', {convenio1: $(this).val(), ajax: true}, function(j) {
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

    $(function() {
        $("#accordion").accordion();
    });

</script>