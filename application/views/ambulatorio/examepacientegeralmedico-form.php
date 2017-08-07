<script>
    function consultasAnteriores() {
        if( $("#txtNomeid").val() != "" && $("#convenio1").val() != "" && $("#procedimento1").val() != "" && $("#exame").val() ){
            jQuery.ajax({
                url: "<?= base_url(); ?>autocomplete/buscaconsultasanteriores",
                type: "GET",
                data: 'paciente_id=' + $("#txtNomeid").val() + '&convenio_id=' + $("#convenio1").val() + '&procedimento_id=' + $("#procedimento1").val() + '&medico_id=' + $("#exame").val(),
                dataType: 'json',
                async: false,
                success: function (retorno) {
                    if(retorno.length > 0){
                        var mensagem = "Este paciente ja fez ";
                        
                        if (retorno[0].tipo = "EXAME") { mensagem += "esse exame"; }
                        else { mensagem += "essa consulta"; }
                        
                        mensagem += " nos ultimos 30 dias. Deseja prosseguir?";
                        var escolha = confirm(mensagem);
                        
                        if(escolha) document.form_exametemp.submit(); 
                    }
                    else{
                        document.form_exametemp.submit(); 
                    }
                },
                error: function(erro){
                    return true;
                }
            });
            
            return false;
        }
        else{
            return true;
        }
        
    }
</script>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteexametempgeral/<?= $agenda_exames_id ?>" method="post">
        <fieldset>
            <legend>Agendamento Geral</legend>

            <div>
                <label>Nome</label>
                <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" name="txtNome" class="texto10" required=""/>
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input type="text" name="nascimento" id="nascimento" class="texto02" maxlength="10" type="text"/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>

            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone"/>
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="txtCelular" />
            </div>
            <div>
                <label>Medico</label>
                <select name="medico" id="exame" class="size2" required="">
                    <option value="" >Selecione</option>
                    <? foreach ($medico as $item) : ?>
                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio1" id="convenio1" class="size4" required="">
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select  name="procedimento1" id="procedimento1" class="size1" required="">
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Observacoes</label>


                <input type="text" id="observacoes" class="texto10" name="observacoes" />
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar" onclick="javascript: return consultasAnteriores()">
                    Enviar
                </button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    ?>
    <table id="table_agente_toxico" border="0">
        <thead>

            <tr>
                <th class="tabela_header">Data</th>
                <th class="tabela_header">Hora</th>
                <th class="tabela_header">Sala</th>
                <th class="tabela_header">Observa&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <?
        $estilo_linha = "tabela_content01";
        foreach ($exames as $item) {
            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
            ?>
            <tbody>
                <tr>
                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->sala . $item->medico_agenda; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                </tr>


                <?
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 

</fieldset>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script>
    function mascaraTelefone(campo) {

        function trata(valor, isOnBlur) {

            valor = valor.replace(/\D/g, "");
            valor = valor.replace(/^(\d{2})(\d)/g, "($1)$2");

            if (isOnBlur) {

                valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
            } else {

                valor = valor.replace(/(\d)(\d{3})$/, "$1-$2");
            }
            return valor;
        }

        campo.onkeypress = function (evt) {

            var code = (window.event) ? window.event.keyCode : evt.which;
            var valor = this.value

            if (code > 57 || (code < 48 && code != 0 && code != 8 && code != 9)) {
                return false;
            } else {
                this.value = trata(valor, false);
            }
        }

        campo.onblur = function () {

            var valor = this.value;
            if (valor.length < 13) {
                this.value = ""
            } else {
                this.value = trata(this.value, true);
            }
        }

        campo.maxLength = 14;
    }


</script>
<script type="text/javascript">
    mascaraTelefone(form_exametemp.telefone);
    mascaraTelefone(form_exametemp.txtCelular);

    $(function () {
        $('#exame').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio', {exame: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                    }
                    $('#convenio1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#convenio1').html('<option value="">-- Escolha um hora --</option>');
            }
        });
    });

    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedico', {convenio1: $(this).val(), teste: $("#exame").val()}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
                    $('#procedimento1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">Selecione</option>');
            }
        });
    });


    $(function () {
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#txtCelular").val(ui.item.celular);
                $("#nascimento").val(ui.item.valor);
                return false;
            }
        });
    });

    $(function () {
        $("#nascimento").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=pacientenascimento",
            minLength: 3,
            focus: function (event, ui) {
                $("#nascimento").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                return false;
            }
        });
    });

    jQuery("#nascimento").mask("99/99/9999");
</script>