<div class="content ficha_ceatox"  >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>jQuery UI Dialog - Modal form</title>
        <link href="<?= base_url() ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <!--<link rel="stylesheet" href="<?= base_url() ?>css/style.css"  type="text/css"/>-->
        <style>
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            select.text { width:95%; }
            #qtde{ width:50px; }
            #valor{ width:50px; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 800px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th {}
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
    </head>


    <div id="dialog-form" title="Adicionar Procedimento">
        <form>
            <fieldset>
                <input type="hidden" name="convenio_nome" id="convenio_nome">
                <input type="hidden" name="procedimento_nome" id="procedimento_nome">
                <label for="convenio">Convenio</label>
                <select  name="convenio" id="convenio" class="text ui-widget-content ui-corner-all" >
                    <option value="selecione">Selecione</option>
                    <?
                    foreach ($convenio as $item) :
                        ?>
                        <option value="<?= $item->convenio_id; ?>" onclick="invisivel('<? echo $item->nome ?>');"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
                <label for="procedimento">Procedimento</label>
                <select  name="procedimento" id="procedimento" class="text ui-widget-content ui-corner-all" >
                    <option value="selecione">Selecione</option>
                </select>
                <label for="qtde">Qtde</label>
                <input type="qtde" name="qtde" id="qtde"  class="text ui-widget-content ui-corner-all">
                <label for="valor">Valor UND</label>
                <input type="valor" name="valor" id="valor" class="text ui-widget-content ui-corner-all">
                <label for="descricao">Descrição</label>
                <textarea  type="text" name="descricao" id="descricao" class="textarea" cols="60" rows="1"> </textarea>
                        

                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
            </fieldset>
        </form>
    </div>
    <? $valor_total = 0; ?>
    <fieldset>
        <div id="users-contain" class="ui-widget">
            <legend>Orçamento</legend>
            <table id="users" class="ui-widget ui-widget-content">
                <thead>
                    <tr class="ui-widget-header">
                        <th  class="tabela_header">Convênio</th>
                        <th  class="tabela_header">Procedimento</th>
                        <th  class="tabela_header">Descrição</th>
                        <th  class="tabela_header">Qtde</th>
                        <th  class="tabela_header">Valor UND(R$)</th>
<!--                        <th  class="tabela_header">Valor Total(R$)</th>-->
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr class="ui-widget-header">
                        <td class="tabela_header" colspan="6"><center>Valor Total: R$ <? echo $valor_total ?></center></td>
                        <!--<td class="tabela_header" colspan="4"></td>-->
                    </tr>
                </tfoot>
            </table>
            <form method="post" action="<?= base_url() ?>ambulatorio/procedimentoplano/imprimirorcamento">
                <!--<input type="hidden" name="contador" id="contador" value="0">-->
                <table id="form" class="ui-widget ui-widget-content">
                    <thead>
                        <tr class="ui-widget-header">
                            <th  class="tabela_header"></th>
                            <th  class="tabela_header"></th>
                            <th  class="tabela_header"></th>
                            <th  class="tabela_header"></th>
                            <th  class="tabela_header"></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>


        </div>
    </fieldset>
    <button  type="submit">Imprimir</button>
</form>
<button id="create-user"  >Adicionar</button>
<!--        <button type="submit" >imprimir</button>-->

</div>


<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>-->
<script src="<?= base_url() ?>js/jquery-1.12.4.js"></script>
<script src="<?= base_url() ?>js/jquery-ui.js"></script>
<script>
                        $(function () {
                            var dialog, form,
                                    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                                    convenio = $("#convenio_nome"),
                                    procedimento = $("#procedimento_nome"),
                                    descricao = $("#descricao"),
                                    qtde = $("#qtde"),
                                    valor = $("#valor"),
                                    valor_parcial = 0,
                                    valor_replace = 0;

//                allFields = $([]).add(convenio).add(procedimento).add(qtde).add(valor),
//                tips = $(".validateTips")
                            ;
                            function addUser() {
                                var valid = true;
//            allFields.removeClass("ui-state-error");

                                if (valid) {

                                    $("#users tbody").append("<tr>" +
                                            "<td>" + convenio.val() + "</td>" +
                                            "<td>" + procedimento.val() + "</td>" +
                                            "<td>" + descricao.val() + "</td>" +
                                            "<td>" + qtde.val() + "</td>" +
                                            "<td >" + valor.val().replace("," , ".") + "</td>" +
                                            "</tr>");
                                    $("#form tbody").append("<tr>" +
                                            "<td><input name='convenio[]' type='hidden' value='" + convenio.val() + "' /></td>" +
                                            "<td><input name='procedimento[]' type='hidden' value='" + procedimento.val() + "' /></td>" +
                                            "<td><input name='qtde[]' type='hidden' value='" + qtde.val() + "' /></td>" +
                                            "<td ><input name='valor[]' type='hidden' value='" + valor.val() + "' /></td>" +
                                            "<td ><input name='descricao[]' type='hidden' value='" + descricao.val() + "' /></td>" +
                                            "</tr>");

                                    $("#users tfoot tr").remove();
                                    valor_replace = valor.val();
                                    valor_replace = valor_replace.replace("," , ".");
                                    valor_parcial = valor_parcial + (parseFloat(valor_replace) * parseFloat(qtde.val())) ;
                                    $("#users tfoot").append("<tr>" +
                                            "<td class='tabela_header' colspan='5' ><center>" + 'Valor Total: R$ ' + valor_parcial + "</center></td>" +
                                            "</tr>");

                                    dialog.dialog("close");
                                }


                                return valid;
                            }

                            dialog = $("#dialog-form").dialog({
                                autoOpen: false,
                                height: 400,
                                width: 500,
                                modal: true,
                                buttons: {
                                    "Enviar": addUser,
                                    Cancel: function () {
                                        dialog.dialog("close");
                                    }
                                },
                                close: function () {
                                    form[ 0 ].reset();
//                allFields.removeClass("ui-state-error");
                                }
                            });

                            form = dialog.find("form").on("submit", function (event) {
                                event.preventDefault();
                                addUser();
                            });

                            $("#create-user").button().on("click", function () {
                                dialog.dialog("open");
                            });
                        });

                        function invisivel(nome) {
                            $("#convenio_nome").val(nome);
                        }
                        function invisivel2(nome) {
                            $("#procedimento_nome").val(nome);
                        }

                        $(function () {
                            $('#convenio').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                                        options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            procedimento = "'" + j[c].procedimento + "'";
                                            options += '<option onclick="invisivel2(' + procedimento + ')" value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento').html('<option value="">Selecione</option>');
                                }
                            });
                        });


                        $(function () {
                            $('#procedimento').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        options = options.replace(".", ",")
                                        document.getElementById("valor").value = options;
                                        document.getElementById("qtde").value = "1";
                                        $("#descricao").val(j[0].descricao_procedimento);
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor').html('value=""');
                                }
                            });
                        });


</script>
