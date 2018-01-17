
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Honor&aacute;rios M&eacute;dicos</a></h3>
        <div>
            <form name="form_procedimentohonorario" id="form_procedimentohonorario" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarpercentuallaboratorio" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Convênio</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="covenio" id="covenio" value="<?= $convenio_id ?>"/>
                        <select name="__covenio" id="__covenio" class="size4" required disabled="">
                            <option value="">SELECIONE</option>
                            <? foreach ($convenio as $value) : ?>
                                <option  value="<?= $value->convenio_id; ?>" <? if ($value->convenio_id == $convenio_id) echo 'selected' ?>>
                                    <?php echo $value->nome; ?>
                                </option>                            
                            <? endforeach; ?>                                                                                             
                        </select>               

                    </dd>                                                           
                    <dt>                         
                        <label>Grupo</label>
                    </dt>                    
                    <dd>                       
                        <select name="grupo" id="grupo" class="size4" required>
                            <option value="">SELECIONE</option>
                            <!--<option>TODOS</option>-->                           
                            <? foreach ($grupo as $value) : ?>
                                <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; /* $value->ambulatorio_grupo_id; */ ?>

                        </select>
                    </dd>
                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd>

                        <select name="procedimento" id="procedimento" class="size4 chosen-select" data-placeholder="Selecione" tabindex="1">
                            <option value="">Selecione</option>
                        </select>

                    </dd>
                    <dt>
                        <label>Laboratório</label>
                    </dt>
                    <dd>                    
                        <select name="laboratorio" id="laboratorio" class="size4">
                            <option>SELECIONE</option>
                            <!--<option>TODOS</option>-->
                            <? foreach ($laboratorios as $value) : ?>
                                <option value="<?= $value->laboratorio_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" id="valor" class="texto01" />
                    </dd>
                    <dt>
                        <label>Percentual</label>
                    </dt>
                    <dd>
                        <select name="percentual"  id="percentual" class="size1">                            
                            <option value="1"> SIM</option>
                            <option value="0"> NÃO</option>                                   
                        </select>
                    </dd>
                    <div id="revisordiv">
                        <dt>
                            <label>Revisor</label>
                        </dt>
                        <dd>
                            <select name="revisor"  id="revisor" class="size1">  
                                <option value="0"> NÃO</option>             
                                <option value="1"> SIM</option>
                            </select>
                        </dd>
                    </div>
                    <dt>
                        <label>Dia Faturamento</label>
                    </dt>
                    <dd>
                        <input type="text" id="entrega" class="texto02" name="dia_recebimento" alt="99"/>
                    </dd>
                    <dt>
                        <label>Tempo para Recebimento</label>
                    </dt>
                    <dd>
                        <input type="text" id="pagamento" class="texto02" name="tempo_recebimento" alt="99"/>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>

        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#covenio').change(function () {
            if ($(this).val()) {
                if ($('#grupo').val() == "TODOS") {
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoporconvenio', {covenio: $(this).val(), ajax: true}, function (j) {
                        options = '<option value="">TODOS</option>';
                        for (var c = 0; c < j.length; c++) {
                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                        }
//                        $('#procedimento').html(options).show();

                        $('#procedimento option').remove();
                        $('#procedimento').append(options);
                        $("#procedimento").trigger("chosen:updated");
                        $('.carregando').hide();
                    });
                } else {
                    if ($('#grupo').val() != "SELECIONE") {
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $('#grupo').val(), convenio1: $(this).val()}, function (j) {
                            options = '<option value="">TODOS</option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                            }
//                            $('#procedimento').html(options).show();

                            $('#procedimento option').remove();
                            $('#procedimento').append(options);
                            $("#procedimento").trigger("chosen:updated");
                            $('.carregando').hide();
                        });
                    }
                }
            } else {
                $('#procedimento').html('<option value="">SELECIONE</option>');
            }
        });
    });

    $(function () {
        $('#grupo').change(function () {
            if ($('#grupo').val() == 'RM') {
                $('#revisordiv').show();
            } else {
                $('#revisordiv').hide();
            }


        });
    });

    if ($('#grupo').val() == 'RM') {
        $('#revisordiv').show();
    } else {
//        $('#revisordiv').hide();
        $(document).ready(function () {
            $('#revisordiv').hide();
        });
    }


    $(function () {
        $('#grupo').change(function () {
            if ($('#covenio').val() != 'SELECIONE' && $('#grupo').val() != 'TODOS') {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $(this).val(), convenio1: $('#covenio').val()}, function (j) {
//                    alert('teste');
                    options = '<option value="">TODOS</option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
//                    $('#procedimento').html(options).show();

                    $('#procedimento option').remove();
                    $('#procedimento').append(options);
                    $("#procedimento").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {

                if ($('#grupo').val() == 'TODOS') {
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoporconvenio', {covenio: $('#covenio').val(), ajax: true}, function (j) {
                        options = '<option value="">TODOS</option>';
                        for (var c = 0; c < j.length; c++) {
                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                        }
//                        $('#procedimento').html(options).show();

                        $('#procedimento option').remove();
                        $('#procedimento').append(options);
                        $("#procedimento").trigger("chosen:updated");
                        $('.carregando').hide();
                    });
                }

            }
        });
    });


</script>