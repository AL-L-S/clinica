<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório ASO</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatorioaso">
                <dl>
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
                        <label>Tipo</label>
                    </dt>
                    
                    <dd>
                        <select id="tipo" name="tipo"  class="size02" >
                    <option value="">
                        TODOS
                    </option>                    
                    <option value="ADMISSIONAL" <?= (@$informacao_aso[0]->tipo == 'ADMISSIONAL') ? 'selected' : ''; ?>>
                        ADMISSIONAL
                    </option>
                    <option value="PERÍODICO" <?= (@$informacao_aso[0]->tipo == 'PERÍODICO') ? 'selected' : ''; ?>>
                        PERÍODICO
                    </option>
                    <option value="RETORNO AO TRABALHO" <?= (@$informacao_aso[0]->tipo == 'RETORNO AO TRABALHO') ? 'selected' : ''; ?>>
                        RETORNO AO TRABALHO
                    </option>
                    <option value="MUDANÇA DE FUNÇÃO" <?= (@$informacao_aso[0]->tipo == 'MUDANÇA DE FUNÇÃO') ? 'selected' : ''; ?>>
                        MUDANÇA DE FUNÇÃO
                    </option>
                    <option value="DEMISSIONAL" <?= (@$informacao_aso[0]->tipo == 'DEMISSIONAL') ? 'selected' : ''; ?>>
                        DEMISSIONAL
                    </option>
                </select>
                    </dd>
                    <dt>
                        <label>Convênio</label>
                    </dt>

                    <dd>
                        <select name="convenio" id="convenio" class="size2" >
                            <option value='' >TODOS</option>
<!--                            <option value='-1' >Não Tem</option>-->
                            <?php
                            $listaconvenio = $this->paciente->listaconvenio();
                            foreach ($listaconvenio as $item) {
                                ?>

                                <option   value =<?php echo $item->convenio_id; ?> >
                                    <?php echo $item->nome; ?>
                                </option>

                            <? } ?> 

                        </select>
                    </dd>

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

