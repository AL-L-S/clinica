<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Unidade Leito</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>internacao/internacao/gerarelatoriounidadeleito">
                <dl>
                    <dt>
                        <label>Unidade</label>
                    </dt>
                    <? $unidade = $this->unidade_m->listaunidadepacientes(); ?>
                    <dd>
                        <select name="unidade" id="unidade" class="size2" >
                            <option value=''>TODOS</option>
                            <?php
                            foreach ($unidade as $item) {
                                ?>
                                <option value="<?php echo $item->internacao_unidade_id; ?>">

                                    <?php echo $item->nome; ?>
                                </option>
                                <?php
                            }
                            ?> 
                        </select>
                    </dd>

                    <dt>
                        <label>Enfermaria</label>
                    </dt>
                    <? $enfermaria = $this->enfermaria_m->listaenfermariarelatorio(); ?>
                    <dd>
                        <select name="enfermaria" id="enfermaria" class="size2" >
                            <option value=''>TODOS</option>
                           
                        </select>
                    </dd>

                    <dt>
                        <label>Gerar PDF</label>
                    </dt>

                    <dd>
                        <select name="gerar_pdf" id="gerar_pdf" class="size2" >
                            <option value='NAO'>NÃO</option>
                            <option value='SIM'>SIM</option>

                            <!--<option value='Cirurgico'>Cirurgico</option>-->
                        </select>
                    </dd>


                    <dt>
                </dl>
                <button type="submit" >Pesquisar</button>

            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
    $(function () {
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

    $(function () {
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


    $(function () {
        $("#accordion").accordion();
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
        $('#unidade').change(function () {
//            alert('adsdasd');
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/enfermariaunidade', {id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    console.log(j);

                    for (var c = 0; c < j.length; c++) {

                        options += '<option value="' + j[c].id + '">' + j[c].value + '</option>';

                    }
                    $('#enfermaria').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('.carregando').show();
                options = '';
                $('#enfermaria').html(options).show();
            }
        });
    });



</script>

