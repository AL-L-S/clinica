<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>

    <h3 class="h3_title">Solicitacao de internacao</h3>
    <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarsolicitacaointernacao/<?= $paciente_id; ?>" method="post">
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
                        <label>Nome do Pai</label>
                        <input type="text"  name="nome_pai" id="txtNomePai" class="texto08" value="<?= $paciente['0']->nome_pai; ?>" readonly/>
                    </div>
                    <div>
                        <label>CNS</label>
                        <input type="text" id="txtCns" name="cns"  class="texto04" value="<?= $paciente['0']->cns; ?>" readonly/>
                    </div>

                </fieldset>
        
        <fieldset>
            <legend>Dados da solicitacao</legend>
            <div>
                <label>Unidade</label>
                <input type="hidden" id="txtinternacao_solicitacao_id" name="internacao_solicitacao_id"  class="texto09" value="<?= @$obj->_internacao_solicitacao_id; ?>" readonly/>
                <input type="hidden" id="txtUnidadeID" class="texto_id" name="UnidadeID" value="<?= @$obj->_unidade; ?>" />
                <input type="text" id="txtUnidade" class="texto06" name="txtUnidade" value="<?= @$obj->_unidade_nome; ?>" />
            </div>
            <div>
                <label>Estado</label>
                <select name="estado" id="txtEstado" class="size2" selected="<?= @$obj->_tipo; ?>">
                    <option value=Bom <?
                            if (@$obj->_tipo == 'Bom'):echo 'selected';
                            endif;
                                        ?>>Bom</option>
                    <option value=Regular <?
                            if (@$obj->_tipo == 'Regular'):echo 'selected';
                            endif;
                                        ?>>Regular</option>
                    <option value=Grave <?
                            if (@$obj->_tipo == 'Grave'):echo 'selected';
                            endif;
                                        ?>>Grave</option>
                </select>
            </div>
        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#txtUnidade" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=unidade",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtUnidade" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtUnidade" ).val( ui.item.value );
                $( "#txtUnidadeID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(document).ready(function(){
        jQuery('#form_paciente').validate( {
            rules: {
                nome: {
                    required: true,
                    minlength: 3
                },
                endereco: {
                    required: true
                },
                cep: {
                    required: true
                },
                cns: {
                    maxLength:15
                }, rg: {
                    maxLength:20
                }
   
            },
            messages: {
                nome: {
                    required: "*",
                    minlength: "*"
                },
                endereco: {
                    required: "*"
                },
                cep: {
                    required: "*"
                },
                cns: {
                    required: "Tamanho m&acute;ximo do campo CNS é de 15 caracteres"
                },
                rg: {
                    maxlength: "Tamanho m&acute;ximo do campo RG é de 20 caracteres"
                }
            }
        });
    });




</script>