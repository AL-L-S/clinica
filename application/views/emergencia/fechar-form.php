<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Acolhimento</h3>
    <form name="form_fechamento" id="form_fechamento" action="<?= base_url() ?>emergencia/filaacolhimento/gravarfechamentorae/<?= $paciente_id; ?>" method="post">
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
            <legend>Dados do encerramento</legend>
            <div>
                <div>
                    <label>Data e hora ex.( 20/01/2010 14:30:21)</label>
                    <input type="text" name="data" id="data" alt="39/19/9999 29:59:59" value="<? echo $data; ?>" class="size2" />
                </div>
                            <div>
                <label>Medico</label>
                <input type="hidden" id="txtmedicoID" class="texto_id" name="medicoID"/>
                <input type="text" id="txtmedico" class="size10" name="txtmedico"/>
            </div>
                <label>Tipo de saida</label>
                <select name="tiposaida" id="tiposaida" class="size10" >
                    <option value='1' >selecione</option>
                    <?php
                    $listaatendimento = $this->acolhimento->listatipoatendimento($_GET);
                    foreach ($listaatendimento as $item) {
                        ?>
                        <option ><?php echo $item->nome; ?></option>
                        <?php
                    }
                    ?> 
                </select>
            </div>


            <div>
                <label>Observa&ccedil;&atilde;os</label>
                <textarea cols="" rows="" name="observacoes" id="txtobservacoes" class="texto_area"></textarea>
            </div>

        </fieldset>


        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">


    $(document).ready(function(){
        jQuery('#form_acolhimento').validate( {
            rules: {
                data: {
                    required: true
                },
                txtmedico: {
                    required: true
                },
                txtmedicoID: {
                    required: true
                }
   
            },
            messages: {
                data: {
                    required: "*"
                },
                txtmedico: {
                    required: "*"
                },
                txtmedicoID: {
                    required: "*"
                }
            }
        });
    });
    $(function() {
        $( "#txtmedico" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicosaida",
            minLength: 4,
            focus: function( event, ui ) {
                $( "#txtmedico" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtmedico" ).val( ui.item.value );
                $( "#txtmedicoID" ).val( ui.item.id );
                return false;
            }
        });
    });


</script>