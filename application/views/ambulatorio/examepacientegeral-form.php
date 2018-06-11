<script>
    function consultasAnteriores() {
        if ($("#txtNomeid").val() != "" && $("#convenio1").val() != "" && $("#procedimento1").val() != "") {
            jQuery.ajax({
                url: "<?= base_url(); ?>autocomplete/buscaconsultasanteriores",
                type: "GET",
                data: 'paciente_id=' + $("#txtNomeid").val() + '&convenio_id=' + $("#convenio1").val() + '&procedimento_id=' + $("#procedimento1").val(),
                dataType: 'json',
                async: false,
                success: function (retorno) {
                    if (retorno.length > 0) {
//                        console.log(retorno);
                        var mensagem = "Este paciente ja fez ";

                        if (retorno[0].tipo = "EXAME") {
                            mensagem += "esse exame";
                        } else {
                            mensagem += "essa consulta";
                        }

                        mensagem += " nos ultimos 30 dias. Deseja prosseguir?";
                        var escolha = confirm(mensagem);

                        if (escolha)
                            document.form_exametemp.submit();
                    } else {
                        document.form_exametemp.submit();
                    }
                },
                error: function (erro) {
                    return true;
                }
            });

            return false;
        } else {
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
                <input type="text" id="txtNome" required name="txtNome" class="texto10" onblur="calculoIdade(document.getElementById('nascimento').value)"/>

                <div style="display: none">
                    <input type="text" id="medicoid" name="medicoid" class="texto_id" value="<?= $medico; ?>"/>
                    <input type="text" id="agendaid" name="agendaid" class="texto_id" value="<?= $agenda_exames_id; ?>"/>
                </div>

            </div>
            <div>
                <label>Dt de nascimento</label>
                <input type="text" name="nascimento" id="nascimento" class="texto02" onblur="calculoIdade();"/>                
            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade2" id="idade2" class="texto01" readonly/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>
                <input type="hidden" name="medico" id="medico" class="texto01" value="<?= $medico ?>"/>

            </div>
            <div>
                <label>End.</label>
                <input type="text" id="txtEnd" class="texto06" name="txtEnd"   />
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone"/>
            </div>
            <div>
                <label>Celular</label>


                <input type="text" id="txtCelular" class="texto02" name="txtCelular"/>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio1" id="convenio1" class="size4" required>
                    <option  value="">Selecione</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
<? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select  name="procedimento1" id="procedimento1" class="size1" required>
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
<? ?>
    <table id="table_agente_toxico" border="0">
        <thead>

            <tr>
                <th class="tabela_header">Data</th>
                <th class="tabela_header">Hora</th>
                <th class="tabela_header">Empresa</th>
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
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td> <!-- . $item->medico_agenda -->
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->sala; ?></td> <!-- . $item->medico_agenda -->
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
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
    jQuery("#telefone")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    jQuery("#txtCelular")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });


    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                <? $empresa_id = $this->session->userdata('empresa_id'); ?>
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedico', {convenio1: $(this).val(), teste: $("#medico").val(), empresa_id: <?= $empresa_id ?> }, function (j) {
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

//    function calculoIdade() {
//        var data = document.getElementById("nascimento").value;
//        var ano = data.substring(6, 12);
//        var idade = new Date().getFullYear() - ano;
//        document.getElementById("idade2").value = idade;
//    }
    function calculoIdade() {
        var data = document.getElementById("nascimento").value;

        if (data != '' && data != '//') {

            var ano = data.substring(6, 12);
            var idade = new Date().getFullYear() - ano;

            var dtAtual = new Date();
            var aniversario = new Date(dtAtual.getFullYear(), data.substring(3, 5), data.substring(0, 2));

            if (dtAtual < aniversario) {
                idade--;
            }

            document.getElementById("idade2").value = idade + " ano(s)";
        }
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
