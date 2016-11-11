<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>internacao/internacao">
            Voltar
        </a>
    </div>
    <div class="clear"></div>
    <h3 class="h3_title">Cadastro de Enfermaria</h3>
    <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarenfermaria" method="post">
        <fieldset>
            <legend>Dados do Enfermaria</legend>
            <div>
                <label>Nome</label>                      
                <input type ="hidden" name ="internacao_enfermaria_id" value ="<?= @$obj->_internacao_enfermaria_id; ?>" id ="txtinternacao_enfermaria_id"/>
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$obj->_nome; ?>" />
            </div>
            <div>
                <label>Localizacao</label>
                <input type="text" name="localizacao" id="txtlocalizacao" class="texto06" value="<?= @$obj->_localizacao; ?>" />
            </div>
            <div>
                <label>Unidade</label>
                <input type="hidden" id="txtUnidadeID" class="texto_id" name="UnidadeID" value="<?= @$obj->_unidade; ?>" readonly="true" />
                <input type="text" id="txtUnidade" class="texto06" name="txtUnidade" value="<?= @$obj->_unidade_nome; ?>" />
            </div>
            <div>
                <label>Tipo</label>
                <select name="tipo" id="txtTipo" class="size2" selected="<?= @$obj->_tipo; ?>">
                    <option value=Berçário <?
                            if (@$obj->_tipo == 'Berçário'):echo 'selected';
                            endif;
                                        ?>>Berçário</option>
                    <option value=UMI <?
                            if (@$obj->_tipo == 'UMI'):echo 'selected';
                            endif;
                                        ?>>UMI</option>
                    <option value=Emergência <?
                            if (@$obj->_tipo == 'Emergência'):echo 'selected';
                            endif;
                                        ?>>Emergência</option>
                    <option value=APTO <?
                            if (@$obj->_tipo == 'APTO'):echo 'selected';
                            endif;
?>>APTO</option>
                    <option value='Unid. Especial' <?
                            if (@$obj->_tipo == 'Unid. Especial'):echo 'selected';
                            endif;
?>>Unid. Especial</option>
                    <option value=Enfermaria <?
                            if (@$obj->_tipol == 'Enfermaria'):echo 'selected';
                            endif;
?>>Enfermaria</option>
                    <option value=UTI <?
                            if (@$obj->_tipol == 'UTI'):echo 'selected';
                            endif;
?>>UTI</option>
                    <option value='Unid. Intermediaria' <?
                            if (@$obj->_tipol == 'Unid. Intermediaria'):echo 'selected';
                            endif;
?>>Unid. Intermediaria</option>
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