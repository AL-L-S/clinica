<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Movimentacao</h3>
    <form name="form_movimentacao" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarmovimentacao/<?= $paciente_id; ?>/<?= $leito; ?>" method="post">
        <fieldset>
            <legend>Dados do paciente</legend>
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
            <legend>Dados da internacao</legend>
            <div>
                <label>Leito</label>
                <input type="hidden" id="txtinternacao_id" name="internacao_id"  class="texto01" value="<?= @$obj->_internacao_id; ?>" readonly/>
                <input type="hidden" id="txtleitoID" class="texto_id" name="leitoID" value="<?= @$obj->_leito; ?>" />
                <input type="text" id="txtleito" class="texto08" name="txtleito" value="<?= @$obj->_leito_nome; ?>" />
            </div>
            <br>
       
        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#txtleito" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=leito",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtleito" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtleito" ).val( ui.item.value );
                $( "#txtleitoID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtoperador" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=operador",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtoperador" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtoperador" ).val( ui.item.value );
                $( "#txtoperadorID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtprocedimento" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=procedimento",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtprocedimento" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtprocedimento" ).val( ui.item.value );
                $( "#txtprocedimentoID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtcid1" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=cid1",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtcid1" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtcid1" ).val( ui.item.value );
                $( "#txtcid1ID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtcid2" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=cid2",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtcid2" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtcid2" ).val( ui.item.value );
                $( "#txtcid2ID" ).val( ui.item.id );
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