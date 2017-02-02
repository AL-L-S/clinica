
<div class="content ficha_ceatox">
    <div id="accordion">
        <h3 class="singular"><a href="#">UNIFICAR</a></h3>
    <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/exametemp/gravarunificar" method="post">
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                <input type="hidden" id="paciente_id" name="paciente_id"  class="texto02" value="<?= $paciente_id; ?>"/>
            </div>
            <div>
                <label>Prontuario</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto02" value="<?= $paciente['0']->paciente_id; ?>" readonly/>
            </div>
            <div>
                <label>Nome da M&atilde;e</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
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
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" readonly/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Paciente que sera unificado e excluido</legend>
            <div>
                <label>Nome</label>   
                
                <input type="text" id="txtpaciente" class="texto09" name="txtpaciente" />
            </div>
            <div>
                <label>Prontuario</label>
                <input type="text" id="pacienteid" class="texto02" name="pacienteid" readonly/>
            </div>
            <div>
                <label>Nome da M&atilde;e</label>
                <input type="text" name="txtnome_mae" id="txtnome_mae" class="texto08" readonly/>
            </div>
            <div>
                <label>Nascimento</label>
                <input type="text" name="txtdtnascimento" id="txtdtnascimento" class="texto02" readonly/>
            </div>
        </fieldset>
        <button type="submit" name="btnEnviar">enviar</button>
    </form>
</div>
</div>


<script type="text/javascript">
    $(function() {
        
            
        $(function() {
            $( "#txtpaciente" ).autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=pacienteunificar",
                minLength: 3,
                focus: function( event, ui ) {
                    $( "#txtpaciente" ).val( ui.item.label );
                    return false;
                },
                select: function( event, ui ) {
                    $( "#txtpaciente" ).val( ui.item.value );
                    $( "#txtnome_mae" ).val( ui.item.mae );
                    $( "#txtdtnascimento" ).val( ui.item.valor );
                    $( "#pacienteid" ).val( ui.item.id );
                    return false;
                }
            });
        });
        
        $( ".competencia" ).accordion({ autoHeight: false });
        $( ".accordion" ).accordion({ autoHeight: false, active: false });
        $( ".lotacao" ).accordion({

            active: true,
            autoheight: false,
            clearStyle: true

        });


    });
</script>
