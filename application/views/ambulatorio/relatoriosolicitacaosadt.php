
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Guia SADT</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatorioguiasadt">
                <dl>
                    <dt>
                        <label>Médico</label>
                    </dt>
                    <dd>
                        <select name="medico" id="medico" class="size2">
                            <option value="0">TODOS</option>
                        <? foreach ($medicos as $value) : ?>
                            <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                        <? endforeach; ?>

                        </select>
                    </dd>
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value='0' >TODOS</option>
                            <!-- <option value="" >CONVENIOS</option> -->
                            <!-- <option value="-1" >PARTICULARES</option> -->
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <div>
                        <dt>
                            <label>Data fim</label>
                        </dt>
                        <dd  style="margin-bottom: 5pt; position: relative">
                            <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                            <!-- <input type="checkbox" name="filtro_hora" id="filtro_hora"><label for="filtro_hora">Filtrar por horario?</label> -->
                        </dd>
                    </div>
                    
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
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 130px; }
    /* form { min-height: 550pt; } */
</style>
<script type="text/javascript">

    $('#filtro_hora').change(function () {
        if ($(this).is(":checked")) {
            $("#div-filtro-hora").show();
//            $("#horario_inicio").prop('required', true);
//            $("#horario_fim").prop('required', true);
        } else {
            $("#div-filtro-hora").hide();
//            $("#horario_inicio").prop('required', false);
//            $("#horario_fim").prop('required', false);

        }

    });
    $("#div-filtro-hora").hide();


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

</script>