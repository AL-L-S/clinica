<div class="content ficha_ceatox">
    <div>
        <form name="transfere_paciente" id="transfere_paciente" method="post" action="<?= base_url()?>internacao/internacao/transferirpaciente">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente[0]->paciente ?>" readonly/>
                </div>

                <div style="display: none;">                     
                    <input type="number" id="paciente_id" name="paciente_id"  class="texto02" value="<?= $paciente[0]->paciente_id; ?>" readonly/>
                    <input type="number" id="leito_id" name="leito_id"  class="texto02" value="<?= $paciente[0]->leito_id; ?>" readonly/>
                </div>

                <div>
                    <label>Leito</label>
                    <input type="text"  name="leito" id="leito" class="texto02" value="<?= $paciente[0]->leito; ?>" readonly/>
                </div>

            </fieldset>

            <fieldset>
                <legend>Transferir Para</legend>
                
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
                <label >Leito</label>
                <select name="novo_leito" id="novo_leito">
                    <option>Selecione</option> 
                </select>
                </div> 
                
            </fieldset>

            <div>
                <input type="submit" value="Transferir"/>
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
                        $.getJSON('<?= base_url() ?>autocomplete/unidadeleito2', {unidade: $(this).val(), ajax: true}, function(j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].internacao_leito_id+ '">' + j[c].leito + ' - ' + j[c].enfermaria + '</option>';
                            }
                            $('#novo_leito').html(options).show();
                            $('.carregando').hide();
                        });
                    } else {
                        $('#novo_leito').html('<option value="">uuu</option>');
                    }
                });
            });
        
    </script>
    