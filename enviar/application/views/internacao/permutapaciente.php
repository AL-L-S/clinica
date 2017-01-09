<div class="content ficha_ceatox">
    <div>
        <form name="permuta_paciente" id="permuta_paciente" method="post" action="<?= base_url()?>internacao/internacao/permutapaciente">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="nome_paciente_selecionado" name="nome_paciente_selecionado"  class="texto09" value="<?= $paciente[0]->paciente ?>" readonly/>
                </div>

                <div style="display: none;">                     
                    <input type="number" id="paciente_id_selecionado" name="paciente_id_selecionado"  class="texto02" value="<?= $paciente[0]->paciente_id; ?>" readonly/>
                    <input type="number" id="leito_id_selecionado" name="leito_id_selecionado"  class="texto02" value="<?= $paciente[0]->leito_id; ?>" readonly/>
                </div>

                <div>
                    <label>Leito</label>
                    <input type="text"  name="leito_paciente_selecionado" id="leito_paciente_selecionado" class="texto02" value="<?= $paciente[0]->leito; ?>" readonly/>
                </div>

            </fieldset>

            <fieldset>
                <legend>Permutar Com</legend>
                
                <div>
                <label>Unidade</label>
                <select name="unidade" id="unidade">
                    <option>Selecione</option>
                    <? foreach($unidades as $item){?>
                    <option value="<?= $item->internacao_unidade_id?>"><? echo $item->unidade; ?></option>    
                    <?}?>                    
                </select>
                </div>
                
                <div>
                
                <label>Paciente</label>
                <select name="leito_troca" id="leito_troca">
                    <option>Selecione</option> 
                </select>
                
                </div> 
                
            </fieldset>

            <div>
                <input type="submit" value="Permutar"/>
            </div>
    </div>
</div>
    <div class="clear"></div>

    <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
    <script>
         $(function() {
                $('#unidade').change(function() {
                    if ($(this).val()) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/unidadepaciente', {unidade: $(this).val(), ajax: true}, function(j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].leito_id+ '">' + j[c].paciente + ' - ' + j[c].leito + ' - ' + j[c].enfermaria + '</option>';
                            }
                            $('#leito_troca').html(options).show();
                            $('.carregando').hide();
                        });
                    } else {
                        $('#leito_troca').html('<option value="">SELECIONE</option>');
                    }
                });
            });
    </script>
   
