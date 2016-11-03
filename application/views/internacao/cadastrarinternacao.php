<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Internacao</h3>
    <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarinternacao/<?= $paciente_id; ?>" method="post">
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
            <legend>Dados da internacao</legend>
            <div>
                <label>Leito</label>
                <input type="hidden" id="txtinternacao_id" name="internacao_id"  class="texto01" value="<?= @$obj->_internacao_id; ?>" readonly/>
                <input type="hidden" id="txtleitoID" class="texto_id" name="leitoID" value="<?= @$obj->_leito; ?>" />
                <input type="text" id="txtleito" class="texto08" name="txtleito" value="<?= @$obj->_leito_nome; ?>" />
            </div>
            <br>
            <br>

            <div>
                <label>Autorizacao Sisreg</label>
                <input type="text" id="txtsisreg" class="texto06" name="sisreg" value="<?= @$obj->_codigo; ?>" />
            </div>
            <div>
                <label>AIH</label>
                <input type="text" id="txtaih" class="texto06" name="aih" value="<?= @$obj->_aih; ?>" />
            </div>
            <div>
                <label>Autorizacao central</label>
                <input type="text" id="txtcentral" class="texto06" name="central" value="<?= @$obj->_prelaudo; ?>" />
            </div>
            <div>
                <label>Medico</label>
                <input type="hidden" id="txtoperadorID" class="texto_id" name="operadorID" value="<?= @$obj->_operador; ?>" />
                <input type="text" id="txtoperador" class="texto06" name="txtoperador" value="<?= @$obj->_operador_nome; ?>" />
            </div>
            <div>
                <label>Data/hora ex.( 20/01/2010 14:30:21)</label>
                <input type="text" id="txtdata" class="texto08" name="data" alt="39/19/9999 29:59:59" value="<?= @$obj->_data_internacao; ?>" />
            </div>
            <div>
                <label>Forma de entrada</label>
                <select name="forma" id="txtforma" class="texto08" selected="<?= @$obj->_forma_de_entrada; ?>">
                    <option value=Residencia <?
if (@$obj->_tipo == 'Residencia'):echo 'selected';
endif;
?>>Residencia</option>
                    <option value=Transferido <?
                            if (@$obj->_tipo == 'Transferido'):echo 'selected';
                            endif;
?>>Transferido</option>
                    <option value=Emergencia <?
                            if (@$obj->_tipo == 'Emergencia'):echo 'selected';
                            endif;
?>>Emergencia</option>
                    <option value=Ambulatorio <?
                            if (@$obj->_tipo == 'Ambulatorio'):echo 'selected';
                            endif;
?>>Ambulatorio</option>
                </select>
            </div>
            <div>
                <label>Estado</label>
                <select name="estado" id="txtEstado" class="size04" selected="<?= @$obj->_tipo; ?>">
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
            <div>
                <label>Carater</label>
                <select name="carater" id="txtcarater" class="size04" selected="<?= @$obj->_carater; ?>">
                    <option value=Eletiva <?
                            if (@$obj->_tipo == 'Eletiva'):echo 'selected';
                            endif;
?>>Eletiva</option>
                    <option value=Normal <?
                            if (@$obj->_tipo == 'Normal'):echo 'selected';
                            endif;
?>>Normal</option>
                    <option value=Emergencia <?
                            if (@$obj->_tipo == 'Emergencia'):echo 'selected';
                            endif;
?>>Emergencia</option>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <input type="hidden" id="txtprocedimentoID" class="texto_id" name="procedimentoID" value="<?= @$obj->_procedimento; ?>" />
                <input type="text" id="txtprocedimento" class="texto10" name="txtprocedimento" value="<?= @$obj->_procedimento_nome; ?>" />
            </div>
            <div>
                <label>CID principal</label>
                <input type="hidden" id="txtcid1ID" class="texto_id" name="cid1ID" value="<?= @$obj->_cid1; ?>" />
                <input type="text" id="txtcid1" class="texto10" name="txtcid1" value="<?= @$obj->_cid1_nome; ?>" />
            </div>
            <div>
                <label>CID secundario</label>
                <input type="hidden" id="txtcid2ID" class="texto_id" name="cid2ID" value="<?= @$obj->_cid2; ?>" />
                <input type="text" id="txtcid2" class="texto10" name="txtcid2" value="<?= @$obj->_cid2_nome; ?>" />
            </div>
            <div>
                <label>Justificativa</label>
                <textarea cols="" rows="" name="observacao" id="txtobservacao" class="texto_area" value="<?= @$obj->_data_internacao; ?>"></textarea><br/>
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
        $( "#txtleito" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=leito",
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
            source: "<?= base_url() ?>index.php?c=autocomplete&m=operador",
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
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimento",
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
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
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
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid2",
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