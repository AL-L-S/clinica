
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Ajuste de Honorários Médicos</a></h3>
        <div>
            <form name="form_procedimentohonorario" id="form_procedimentohonorario" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarajustepercentualmedico" method="post">
                <style>
                    dd{
                        margin-bottom: 4px;
                    }
                    dt{
                        margin-bottom: 4px;
                    }
                </style>
                <dl class="dl_desconto_lista">
                    <? if(@$medico_id != '') { ?>
                        <dt>
                            <label>Médico</label>
                        </dt>
                        <dd>
                            <? 
                            foreach ($medicos as $value) {
                                if ($value->operador_id == @$medico_id) {
                                    $medicoNome = $value->nome;
                                }
                            }
                            ?>
                            <input type="text" name="texto_medico" value="<?=$medicoNome?>" readonly="">
                            <input type="hidden" name="medico[]" id="medico" value="<?=@$medico_id?>">

                        </dd>       
                    <? } else { ?>
                        
                        <dt>
                            <label>Médico</label>
                        </dt>
                        <dd>                    
                            <select name="medico[]" id="medico" class="size4 chosen-select" multiple required="" data-placeholder="Selecione um ou mais médicos">
                                <!-- <option value="">SELECIONE</option> -->
                                <option>TODOS</option>
                                <? foreach ($medicos as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>">
                                        <?php echo $value->nome; ?>
                                    </option>
                                <? endforeach; ?>
                            </select>
                        </dd>
                        <!-- <br> -->
                        <br>
                    
                    <? } 
                    if(@$convenio_id != '') { ?>
                        <dt>
                            <label>Convênio</label>
                        </dt>
                        <dd>
                            <? 
                            foreach ($convenio as $value) {
                                if ($value->convenio_id == @$convenio_id) {
                                    $convenioNome = $value->nome;
                                }
                            }
                            ?>
                            <input type="text" name="texto_convenio" value="<?=$convenioNome?>" readonly="">
                            <input type="hidden" name="covenio" id="covenio" value="<?=@$convenio_id?>">

                        </dd>       
                    <? } else { ?>
                        <dt>
                            <label>Convênio</label>
                        </dt>
                        <dd>
                            <select name="covenio[]" id="covenio" class="size4 chosen-select" multiple required="" data-placeholder="Selecione um ou mais convênios">
                                <!-- <option value="">SELECIONE</option> -->
                                <? foreach ($convenio as $value) : ?>
                                    <option  value="<?= $value->convenio_id; ?>">
                                        <?php echo $value->nome; ?>
                                    </option>                            
                                <? endforeach; ?>                                                                                             
                            </select>
                        </dd>
                        <!-- <br> -->
                        <br>
                    <? } ?>
                    <dt>                         
                        <label>Grupo</label>
                    </dt>                    
                    <dd>                       
                        <select name="grupo[]" id="grupo" class="size4 chosen-select" multiple required="" data-placeholder="Selecione um ou mais grupos">
                            <!-- <option value="">SELECIONE</option> -->
                            <option value="TODOS">TODOS</option>                           
                            <? foreach ($grupo as $value) : ?>
                                <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; /* $value->ambulatorio_grupo_id; */ ?>

                        </select>
                    </dd>
                    <!-- <br> -->
                    <br>
                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd>
<!--                        <select  name="procedimento" id="procedimento" class="size4" >
                            <option value="">SELECIONE</option>
                        </select>-->
                        <?
                        $procedimentos_tuss = $this->procedimentoplano->listarprocedimento4();
                        ?>
                        <select required name="procedimento[]" id="procedimento" multiple class="size4 chosen-select" data-placeholder="Selecione um ou mais procedimentos" tabindex="1">
                            <option value="TODOS">TODOS</option>    
                            
                        </select>

                    </dd>
                    <br>
                    <!-- <br> -->
                    <br>
                    <dt>
                        <label>Ajustar Percentual?</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="ajuste" id="ajuste" class="texto01" /> 
                    </dd>
                    <div id="cadastrarPercentual">
                        
                        <dt>
                            <label>Perc./Valor Medico</label>
                        </dt>
                        <dd>
                            <input type="number" name="txtperc_medico" id="txtperc_medico" step="0.01" style="width: 6em;"/>
                            <!--<input type="text" name="txtperc_medico" id="txtperc_medico" class="texto" value="<?= @$obj->_perc_medico; ?>" />-->
                        </dd>
                        <dt>
                            <label>Percentual</label>
                        </dt>
                        <dd>
                            <select name="percentual" id="percentual" class="size2" required="">
                                <option value="">Selecione</option>
                                <option value="t">SIM</option>
                                <option value="f">N&Atilde;O</option>
                            </select>
                        </dd>

                    </div>
                    
                    <div id="editarPercentual">                        
                        <dt>
                            <label>Ajuste no valor atual: </label>
                        </dt>
                        <dd>
                            <input type="number" name="ajuste_percentual" id="ajuste_percentual" step="0.01" style="width: 6em;"/> %
                            <!--<input type="text"  class="texto"/> %-->
                        </dd>
                    </div>
                   
<!--                    <dt>
                        <label>Percentual</label>
                    </dt>
                    <dd>
                        <select name="percentual"  id="percentual" class="size1">                            
                            <option value="1"> SIM</option>
                            <option value="0"> NÃO</option>                                   
                        </select>
                    </dd>-->
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
<!--                    <dt>
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
                    </dd>-->
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
//    $('#btnVoltar').click(function () {
//        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
//    });
    $("#editarPercentual").hide();
        $('#ajuste').change(function () {
            if ($(this).is(":checked")) {
                $("#cadastrarPercentual").hide();
                $("#editarPercentual").show();
                $("#ajuste_percentual").prop('required', true);
                $("#percentual").prop('required', false);
                
            } else {
                $("#cadastrarPercentual").show();
                $("#editarPercentual").hide();
                $("#ajuste_percentual").prop('required', false);
                $("#percentual").prop('required', true);
    //            $("#procedimento").toggle();
         }
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#covenio').change(function () {
            // alert($(this).val());
            if ($(this).val()) {
                if ( $('#grupo').val() == "TODOS") {
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoporconvenioajustemedico', {covenio: $(this).val(), ajax: true}, function (j) {
                        options = '<option value="TODOS">TODOS</option>';
                        for (var c = 0; c < j.length; c++) {
                            options += '<option value="' + j[c].procedimento_tuss_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                        }
//                        $('#procedimento').html(options).show();
                        $('#procedimento option').remove();
                        $('#procedimento').append(options);
                        $("#procedimento").trigger("chosen:updated");
                        $('.carregando').hide();
                    });
                }
                else{
                    if ( $('#grupo').val() != "") {
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoajustemedico', {grupo1: $('#grupo').val(), convenio1: $(this).val()}, function (j) {
                            options = '<option value="TODOS">TODOS</option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_tuss_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
//                $('#procedimento').html();

                $('#procedimento option').remove();
                $('#procedimento').append('<option value="">SELECIONE</option>');
                $("#procedimento").trigger("chosen:updated");
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
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoajustemedico', {grupo1: $(this).val(), convenio1: $('#covenio').val()}, function (j) {
                    options = '<option value="TODOS">TODOS</option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_tuss_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
//                    $('#procedimento').html(options).show();

                    $('#procedimento option').remove();
                    $('#procedimento').append(options);
                    $("#procedimento").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            }
            
            else {
                
                if ( $('#grupo').val() == 'TODOS' ) {
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoporconvenioajustemedico', {covenio: $('#covenio').val(), ajax: true}, function (j) {
                        options = '<option value="TODOS">TODOS</option>';
                        for (var c = 0; c < j.length; c++) {
                            options += '<option value="' + j[c].procedimento_tuss_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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