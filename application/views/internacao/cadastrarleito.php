<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>internacao/internacao">
            Voltar
        </a>
    </div>
    <div class="clear"></div>
    <h3 class="h3_title">Cadastro de Leito</h3>
    <form name="form_leito" id="form_leito" action="<?= base_url() ?>internacao/internacao/gravarleito" method="post">
        <fieldset>
            <legend>Dados do Leito</legend>
            <div>
                <label>Nome</label>                      
                <input type ="hidden" name ="internacao_leito_id" value ="<?= @$obj->_internacao_leito_id; ?>" id ="txtinternacao_leito_id"/>
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$obj->_nome; ?>" required />
            </div>
            <div>
                <label>Enfermaria</label>
                <input type="hidden" id="txtEnfermariaID" class="texto_id" name="EnfermariaID" value="<?= @$obj->_enfermaria_id; ?>" readonly="true" />
                <input type="text" id="txtEnfermaria" class="texto06" name="txtEnfermaria" value="<?= @$obj->_enfermaria; ?>" required/>
            </div>
            <div>
                <label>Tipo</label>
                <select name="tipo" id="txtTipo" class="size2" selected="<?= @$obj->_tipo; ?>" required>
                    <option value=Idoso <?
                    if (@$obj->_tipo == 'Idoso'):echo 'selected';
                    endif;
                    ?>>Idoso</option>
                    <option value=Masculino <?
                    if (@$obj->_tipo == 'Masculino'):echo 'selected';
                    endif;
                    ?>>Masculino</option>
                    <option value=Feminino <?
                    if (@$obj->_tipo == 'Feminino'):echo 'selected';
                    endif;
                    ?>>Feminino</option>
                    <option value=Misto <?
                    if (@$obj->_tipo == 'Misto'):echo 'selected';
                    endif;
                    ?>>Misto</option>
                    <option value=Infantil <?
                    if (@$obj->_tipo == 'Infantil'):echo 'selected';
                    endif;
                    ?>>Infantil</option>
                    <option value=Outros <?
                    if (@$obj->_tipol == 'Outros'):echo 'selected';
                    endif;
                    ?>>Outros</option>
                </select>
            </div>
            <div>
                <label>Condi&ccedil;&atilde;o do leito</label>
                <select name="condicao" id="txtcondicao" class="size2" selected="<?= @$obj->_condicao; ?>">
                    <option value=Normal <?
                    if (@$obj->_condicao == 'Normal'):echo 'selected';
                    endif;
                    ?>>Normal</option>
                    <option value=Manutencao <?
                    if (@$obj->_condicao == 'Manutencao'):echo 'selected';
                    endif;
                    ?>>Manutencao</option>
                    <option value=Higienizacao <?
                    if (@$obj->_condicao == 'Higienizacao'):echo 'selected';
                    endif;
                    ?>>Higienizacao</option>
                    <option value=Fechado <?
                    if (@$obj->_condicao == 'Fechado'):echo 'selected';
                    endif;
                    ?>>Fechado</option>

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

    $(function () {
        $("#txtEnfermaria").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=enfermaria",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtEnfermaria").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtEnfermaria").val(ui.item.value);
                $("#txtEnfermariaID").val(ui.item.id);
                return false;
            }
        });
    });

    $(document).ready(function () {
        jQuery('#form_paciente').validate({
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
                    maxLength: 15
                }, rg: {
                    maxLength: 20
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