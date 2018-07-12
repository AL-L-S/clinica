<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Atendimento Mensal</a></h3>
        <div>
            <form name="form_paciente" id="form_paciente"  method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriomedicoatendimentomensal">
                <dl>
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="medicos" id="medicos" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="periodo_inicio" id="periodo_inicio" alt="date" required=""/>
                    </dd>
                        
                    <dt>
                        <label>Data Fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="periodo_fim" id="periodo_fim" alt="date" required=""/>
                    </dd>
                        
                    <dt>
                        <label>Revisor</label>
                    </dt>
                    <dd>
                        <select name="revisor" id="revisor" class="size2">
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
                        <select name="convenio" id="convenio" class="size2" required="">
                            <option value="" >SELECIONE</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
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
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


    $(document).ready(function () {
        jQuery('#form_paciente').validate({
            rules: {
                txtdata_inicio: {
                    required: true
                },
                txtdata_fim: {
                    required: true
                },
                producao: {
                    required: true
                }

            },
            messages: {
                txtdata_inicio: {
                    required: "*"
                },
                txtdata_fim: {
                    required: "*"
                },
                producao: {
                    required: "*"
                }
            }
        });
    });

    $(function () {
        $("#periodo_inicio").datepicker({
            autosize: true,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'mm/yy',
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
            }
        });
    });
    
    $(function () {
        $("#periodo_inicio").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
    });

    $(function () {
        $("#periodo_fim").datepicker({
            autosize: true,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'mm/yy',
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
            }
        });
    });
    
    $(function () {
        $("#periodo_fim").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
    });
    
    $(function () {
        $("#accordion").accordion();
    });

</script>