<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Triagem</h3>
    <div>
    <form name="form_triagem" id="form_triagem" action="<?= base_url() ?>emergencia/triagem/gravar/<?= $paciente_id; ?>" method="post">
        <fieldset>
            <legend>Dados do Pacienete</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
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
            <div>
                <label>CNS</label>
                <input type="text" id="txtCns" name="cns"  class="texto04" value="<?= $paciente['0']->cns; ?>" readonly/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Atendimento</legend>
            <div>
                <label>Gravidade</label>
                <select name="txtgravidade" id="txtgravidade" class="size10" >
                    <option >estavel</option>
                    <option >grave</option>
                </select>
            </div>
            <div>
                <label>Observa&ccedil;&atilde;o</label>
                <textarea cols="" rows="" name="txtdescricao" id="txtdescricao" class="texto_area" ></textarea>
            </div>

        </fieldset>

        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>
</div>

</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
        jQuery('#form_paciente').validate( {
            rules: {
                txtdescricao: {
                    required: true,
                    minlength: 10
                } 
   
            },
            messages: {
                txtdescricao: {
                    required: "*",
                    minlength: "minimo 10 digitos"
                }
             }
        });
    });




</script>