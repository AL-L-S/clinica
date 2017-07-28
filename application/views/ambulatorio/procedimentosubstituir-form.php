<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>cadastros/pacientes/substituirambulatoriotemp/<?= $paciente_id; ?>/<?= $paciente_temp_id; ?>" method="post">
        <fieldset>
            <legend>Dados do paciente</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
            </div>
            <div>
                <label>Sexo</label>
                <select name="sexo" id="txtSexo" class="size2">
                    <option value="M" <?
if ($paciente['0']->sexo == "M"):echo 'selected';
endif;
?>>Masculino</option>
                    <option value="F" <?
                            if ($paciente['0']->sexo == "F"):echo 'selected';
                            endif;
?>>Feminino</option>
                </select>
            </div>

            <div>
                <label>Nascimento</label>


                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
            </div>

            <div>

                <label>Idade</label>
                <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

            </div>

            <div>
                <label>Nome da M&atilde;e</label>


                <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
            </div>
        </fieldset>
        <input type="hidden" name="paciente_id" value="<?= $paciente_id; ?>" />
        <input type="hidden" name="paciente_temp_id" value="<?= $paciente_temp_id; ?>" />

        <fieldset>
            <table id="table_agente_toxico" border="0">
                <thead>

                    <tr>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Hora</th>
                        <th class="tabela_header">Sala</th>
                        <th class="tabela_header">Observa&ccedil;&otilde;es</th>
                        <th class="tabela_header">Qtde</th>
                        <th class="tabela_header">Solicitante</th>
                        <th class="tabela_header">Convenio</th>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">autorizacao</th>
                        <th class="tabela_header">V. Unit</th>
                        <th class="tabela_header">V. Total</th>
                        <th class="tabela_header">Confir.</th>
                    </tr>
                </thead>
                <?
                $estilo_linha = "tabela_content01";
                $i = 0;
                foreach ($exames as $item) {
                    $i++;
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    $agenda_exame_id = $item->agenda_exames_id;
                    ?>
                    <tbody>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 2, 2); ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= substr($item->inicio, 0, 5); ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="10px;"><input type="text" name="qtde[<?= $i; ?>]" id="qtde<?= $i; ?>" alt="numeromask" class="texto00"/></td>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                <select  name="medico[<?= $i; ?>]" id="medico<?= $i; ?>" class="texto02" >
                                    <option value="-1">Selecione</option>
                                    <? foreach ($medicos as $item) : ?>
                                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                <select  name="convenio[<?= $i; ?>]" id="convenio<?= $i; ?>" class="size1" >
                                    <option value="-1">Selecione</option>
                                    <? foreach ($convenio as $item) : ?>
                                        <option value="<?= $item->convenio_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>

                            <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                <select  name="procedimento[<?= $i; ?>]" id="procedimento<?= $i; ?>" class="size2" >
                                    <option value="-1">-- Escolha um procedimento --</option>
                                </select>
                            </td>

                            <td class="<?php echo $estilo_linha; ?>" width="50px;"><input type="text" name="autorizacao[<?= $i; ?>]" id="autorizacao" class="size1"/></td>
                            <td class="<?php echo $estilo_linha; ?>" width="20px;"><input type="text" name="valor[<?= $i; ?>]" id="valor<?= $i; ?>" class="texto01"/></td>
                            <td class="<?php echo $estilo_linha; ?>" width="20px;"><input type="text" name="valortotal[<?= $i; ?>]" id="valortotal<?= $i; ?>" class="texto01"/></td>
                            <td class="<?php echo $estilo_linha; ?>" width="70px;"><input type="checkbox" name="confimado[<?= $i; ?>]" /><input type="hidden" name="agenda_exames_id[<?= $i; ?>]" value="<?= $agenda_exame_id; ?>" /></td>
                        </tr>

                    </tbody>
                    <?
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                        </th>
                    </tr>
                </tfoot>
            </table> 
            <hr/>
            <button type="submit" name="btnEnviar">Enviar</button>
            <button type="reset" name="btnLimpar">Limpar</button>
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#data_ficha" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function(){
        $('#convenio1').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio',{convenio1:$(this).val(), ajax:true}, function(j){
                    var options = '<option value=""></option>';	
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }	
                    $('#procedimento1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });
    
    $(function(){
        $('#procedimento1').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor',{procedimento1:$(this).val(), ajax:true}, function(j){
                    options =  "";
                    options += j[0].valortotal;
                    document.getElementById("valor1").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor1').html('value=""');
            }
        });
    });

    $(function(){
        $('#convenio2').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio2',{convenio2:$(this).val(), ajax:true}, function(j){
                    var options = '<option value=""></option>';	
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }	
                    $('#procedimento2').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento2').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });
    
    $(function(){
        $('#procedimento2').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor2',{procedimento2:$(this).val(), ajax:true}, function(j){
                    options =  "";
                    options += j[0].valortotal;
                    document.getElementById("valor2").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor2').html('value=""');
            }
        });
    });

    $(function(){
        $('#convenio3').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio3',{convenio3:$(this).val(), ajax:true}, function(j){
                    var options = '<option value=""></option>';	
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }	
                    $('#procedimento3').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento3').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });
    
    $(function(){
        $('#procedimento3').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor3',{procedimento3:$(this).val(), ajax:true}, function(j){
                    options =  "";
                    options += j[0].valortotal;
                    document.getElementById("valor3").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor3').html('value=""');
            }
        });
    });

    $(function(){
        $('#convenio4').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio4',{convenio4:$(this).val(), ajax:true}, function(j){
                    var options = '<option value=""></option>';	
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }	
                    $('#procedimento4').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento4').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });
    
    $(function(){
        $('#procedimento4').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor4',{procedimento4:$(this).val(), ajax:true}, function(j){
                    options =  "";
                    options += j[0].valortotal;
                    document.getElementById("valor4").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor4').html('value=""');
            }
        });
    });

    $(function(){
        $('#convenio5').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio5',{convenio5:$(this).val(), ajax:true}, function(j){
                    var options = '<option value=""></option>';	
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }	
                    $('#procedimento5').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento5').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });
    
    $(function(){
        $('#procedimento5').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor5',{procedimento5:$(this).val(), ajax:true}, function(j){
                    options =  "";
                    options += j[0].valortotal;
                    document.getElementById("valor5").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor5').html('value=""');
            }
        });
    });

    $(function(){
        $('#convenio6').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio6',{convenio6:$(this).val(), ajax:true}, function(j){
                    var options = '<option value=""></option>';	
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }	
                    $('#procedimento6').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento6').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });
    
    $(function(){
        $('#procedimento6').change(function(){
            if( $(this).val() ) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor6',{procedimento6:$(this).val(), ajax:true}, function(j){
                    options =  "";
                    options += j[0].valortotal;
                    document.getElementById("valor6").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor6').html('value=""');
            }
        });
    });

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





    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_exametemp').validate( {
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

</script>