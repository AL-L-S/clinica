<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/exame/carregarguiacirurgica">
            Nova Equipe
        </a>
    </div>
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteexametempgeral" method="post">
        <fieldset>
            <legend>Dados da Guia</legend>

            <div>
                <label>Nome</label>
                <input type="hidden" id="txtguiaid" class="texto_id" name="txtguiaid" readonly="true" value="<?= @$guia[0]->ambulatorio_guia_id; ?>" />
                <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" value="<?= @$guia[0]->paciente_id; ?>" />
                <input type="text" id="txtNome" required name="txtNome" class="texto10" value="<?= @$guia[0]->paciente; ?>" readonly="true"/>
            </div>
            <div>
                <label>Dt de nascimento</label>
                <input type="text" name="nascimento" id="nascimento" class="texto02" value="<?= date("d/m/Y", strtotime(@$guia[0]->nascimento)); ?>" readonly="true"/>                
            </div>

            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone" value="<?= @$guia[0]->telefone; ?>" readonly="true"/>
            </div>
            <div>
                <label>Convenio</label>
                <input type="text" id="convenio" class="texto02" name="convenio" value="<?= @$guia[0]->convenio; ?>" readonly="true"/>
            </div>

        </fieldset>
        <fieldset>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Enviar</button>
            </div>
        </fieldset>
    </form>

    <!--    <fieldset>
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
//            $estilo_linha = "tabela_content01";
//            foreach ($exames as $item) {
//                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
    ?>
                    <tbody>
                        <tr>
                            <td class="<?php // echo $estilo_linha;  ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                            <td class="<?php // echo $estilo_linha;  ?>"><?= $item->inicio; ?></td>
                            <td class="<?php // echo $estilo_linha;  ?>"><?= $item->sala; ?></td>  . $item->medico_agenda 
                            <td class="<?php // echo $estilo_linha;  ?>"><?= $item->observacoes; ?></td>
                        </tr>
    
    
    <?
//                }
    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                        </th>
                    </tr>
                </tfoot>
            </table> 
    
        </fieldset>-->
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    mascaraTelefone(form_exametemp.telefone);
    mascaraTelefone(form_exametemp.txtCelular);


    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedico', {convenio1: $(this).val(), teste: $("#medico").val()}, function (j) {
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
                $("#txtCelular").val(ui.item.celular);
                $("#telefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                $("#txtEnd").val(ui.item.endereco);
                return false;
            }
//                            _renderItem: function (ul, item) {
//                                return $("<li>")
//                                        .attr("data-value", item.value)
//                                        .append(item.label)
//                                        .appendTo(ul);
//                            }
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
    jQuery("#horarios").mask("99:99");

    function calculoIdade() {
        var data = document.getElementById("nascimento").value;
        var ano = data.substring(6, 12);
        var idade = new Date().getFullYear() - ano;
        document.getElementById("idade2").value = idade;
    }

//                    $(function () {
//                        function split(val) {
//                            return val.split(/,\s*/);
//                        }
//                        function extractLast(term) {
//                            return split(term).pop();
//                        }
//
//                        $("#txtNome")
//                                // don't navigate away from the field on tab when selecting an item
//                                .on("keydown", function (event) {
//                                    if (event.keyCode === $.ui.keyCode.TAB &&
//                                            $(this).autocomplete("instance").menu.active) {
//                                        event.preventDefault();
//                                    }
//                                })
//                                .autocomplete({
//                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
//                                    minLength: 2,
//                                    search: function () {
////                                         custom minLength
//                                        var term = extractLast(this.value);
//                                        if (term.length < 2) {
//                                            return false;
//                                        }
//                                    },
//                                    focus: function (event, ui) {
//                                        $("#txtNome").val(ui.item.label);
//                                        return false;
//                                    },
//                                    select: function (event, ui) {
//                                        var terms = split(this.value);
//                                        // remove the current input
//                                        terms.pop();
//                                        // add the selected item
//                                        terms.push(ui.item.value);
//                                        // add placeholder to get the comma-and-space at the end
//                                        terms.push("");
//                                        this.value = terms.join(", ");
//                                        return false;
//                                    }
//                                });
//                    });
</script>
