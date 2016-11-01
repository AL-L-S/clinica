<div class="content ficha_ceatox">
    <div >
        <h3 class="singular"><a href="#">Marcar exames</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/editarexames" method="post">
                <fieldset>
                    <legend>Dados do Pacienete</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hiden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
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

                <fieldset>
                    <dl>
                        <dt>Sala</dt>
                        <dd>
                            <select  name="sala1" id="sala1" class="size2" >
                                <option value="">Selecione</option>
                                <? foreach ($salas as $item) : ?>
                                    <option value="<?= $item->exame_sala_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </dd>
                        <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" value="<?= $ambulatorio_guia_id; ?>"/>
                        <input type="hidden" name="guia_id" id="guia_id" value="<?= $guia_id; ?>"/>
                        <dt>Solicitante</dt>
                        <dd><select  name="medico" id="medico" class="size2" >
                                <option value="0">Selecione</option>
                                <? foreach ($operadores as $item) : ?>
                                    <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select></dd>
                        <dt>autorizacao</dt>
                        <dd><input type="text" name="autorizacao1" id="autorizacao" class="size1"/></dd>
                    </dl>
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                </fieldset>
            </form>
        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
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


    $(document).ready(function(){
        jQuery('#form_guia').validate( {
            rules: {
                medico1: {
                    required: true,
                    minlength: 3
                },
                crm: {
                    required: true
                },
                sala1: {
                    required: true
                }
            },
            messages: {
                medico1: {
                    required: "*",
                    minlength: "!"
                },
                crm: {
                    required: "*"
                },
                sala1: {
                    required: "*"
                }
            }
        });
    });

</script>