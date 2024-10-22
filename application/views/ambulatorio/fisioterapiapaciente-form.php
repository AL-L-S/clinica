<script>
    function consultasAnteriores() {
        if ($("#txtNomeid").val() != "" && $("#convenio").val() != "" && $("#procedimento").val() != "") {
            jQuery.ajax({
                url: "<?= base_url(); ?>autocomplete/buscaconsultasanteriores",
                type: "GET",
                data: 'paciente_id=' + $("#txtNomeid").val() + '&convenio_id=' + $("#convenio").val() + '&procedimento_id=' + $("#procedimento").val(),
                dataType: 'json',
                async: false,
                success: function (retorno) {
                    if (retorno.length > 0) {
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
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacientefisioterapiatemp/<?= $agenda_exames_id ?>" method="post">
        <fieldset>
            <legend>Marcar Fisioterapia</legend>

            <div>
                <label>Nome</label>
                <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" name="txtNome" class="texto10" onblur="calculoIdade(document.getElementById('nascimento').value)" required/>
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input type="text" name="nascimento" id="nascimento" class="texto02" onblur="calculoIdade(this.value)"/>
            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade2" id="idade2" class="texto01" readonly/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>

            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="txtTelefone" class="texto02" name="txtTelefone"/>
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="txtCelular" />
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio" id="convenio" class="size4" required>
                    <option  value="0">Selecione</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
<? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
<!--                <select  name="procedimento" id="procedimento" class="size1" required>
                    <option value="">Selecione</option>
                </select>-->
                <select name="procedimento" id="procedimento" class="size3 chosen-select" data-placeholder="Selecione" tabindex="1" required="">
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Qtde Sessões</label>
                <input type="text" name="sessao" id="sessao" class="texto01" readonly=""/>
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

        </fieldset>

        <fieldset>
<? ?>
            <table id="table_agente_toxico" border="0">
                <thead>

                    <tr>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Dia</th>
                        <th class="tabela_header">Hora</th>
                        <th class="tabela_header">Exame</th>
                        <th class="tabela_header">Observa&ccedil;&otilde;es</th>
                    </tr>
                </thead>
                <?
                $estilo_linha = "tabela_content01";
                foreach ($consultas as $item) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    $datadia_atual = date('Y-m-d', strtotime($item->data));
                    $dia_atual = strftime("%A", strtotime($datadia_atual));
                    switch ($dia_atual) {
                        case"Sunday": $data_atual = "Domingo";
                            break;
                        case"Monday": $data_atual = "Segunda";
                            break;
                        case"Tuesday": $data_atual = "Terça";
                            break;
                        case"Wednesday": $data_atual = "Quarta";
                            break;
                        case"Thursday": $data_atual = "Quinta";
                            break;
                        case"Friday": $data_atual = "Sexta";
                            break;
                        case"Saturday": $data_atual = "Sabado";
                            break;
                    }
                    ?>
                    <tbody>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $data_atual; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                        </tr>

                    </tbody>
                    <?
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                        </th>
                    </tr>
                </tfoot>
            </table> 

        </fieldset>
        <fieldset>
            <?
            $medico = $this->exametemp->listarmedicoconsulta();
            ?>
            <table id="table_agente_toxico" border="0">
                <thead>

                    <tr>
                        <th class="tabela_header">Dias Das Sessões</th>
                        <th class="tabela_header">Médico</th>
                        <th class="tabela_header">Horário</th>
                        <th class="tabela_header">Marcar</th>
                    </tr>
                </thead>
                <?
//        $testedia = 0;
//        $datadia = date("Y-m-d", strtotime($consultas[0]->data));
                $datadia_atual = date('Y-m-d', strtotime($consultas[0]->data));
                $dia = strftime("%A", strtotime($datadia_atual));
                switch ($dia) {
                    case"Sunday": $numerodia_atual = "0";
                        break;
                    case"Monday": $numerodia_atual = "1";
                        break;
                    case"Tuesday": $numerodia_atual = "2";
                        break;
                    case"Wednesday": $numerodia_atual = "3";
                        break;
                    case"Thursday": $numerodia_atual = "4";
                        break;
                    case"Friday": $numerodia_atual = "5";
                        break;
                    case"Saturday": $numerodia_atual = "6";
                        break;
                }

//                var_dump($numerodia_atual);
//                die;
                ?>
                <input style="display:none;" type="checkbox" checked="true" name="dia[<?= $dia ?>]" value="<?= $numerodia_atual ?>">
                <input style="display:none;" type="hidden" name="medico[<?= $dia ?>]" value="<?= $consultas[0]->medico_agenda ?>">
                <input style="display:none;" type="hidden" name="horarios[1]" value="<?= $agenda_exames_id ?>">
                <input style="display:none;" type="hidden" name="data[<?= $dia ?>]" value="<?= $consultas[0]->data ?>">
                <?
                $datadia = date('Y-m-d', strtotime("+1 days", strtotime($consultas[0]->data)));
                $estilo_linha = "tabela_content01";
                $contador_array = 1;
                for ($i = 1; $i <= 6; $i++) {
                    $contador_array++;
                    $dia = strftime("%A", strtotime($datadia));
                    switch ($dia) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }
                    switch ($dia) {
                        case"Sunday": $numerodia = "0";
                            break;
                        case"Monday": $numerodia = "1";
                            break;
                        case"Tuesday": $numerodia = "2";
                            break;
                        case"Wednesday": $numerodia = "3";
                            break;
                        case"Thursday": $numerodia = "4";
                            break;
                        case"Friday": $numerodia = "5";
                            break;
                        case"Saturday": $numerodia = "6";
                            break;
                    }

                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>

                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $data ?></td>
                        <td class="<?php echo $estilo_linha; ?>">
                            <!--<label>Medico</label>-->
                            <select name="medico[<?= $dia ?>]" id="medico<?= $numerodia ?>" class="size2">
                                <option value="" >Selecione</option>
                                <? foreach ($medico as $item) : ?>
                                    <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                        <td class="<?php echo $estilo_linha; ?>">
                            <select name="horarios[<?= $contador_array ?>]" id="horarios<?= $numerodia ?>" class="size2" >
                                <option value="" >-- Escolha um médico --</option>
                            </select>

                            <input type="hidden" name="data[<?= $dia ?>]" id="data<?= $dia ?>" value="<?= $datadia ?>">
                        </td>
                        <td class="<?php echo $estilo_linha; ?>"><input type="checkbox" name="dia[<?= $dia ?>]" value="<?= $numerodia ?>"></td>
                    </tr>


                    <?
                    $datadia = date('Y-m-d', strtotime("+1 days", strtotime($datadia)));
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                        </th>
                    </tr>
                </tfoot>
            </table> 
            <p>Obs: Caso queira que a sessão se repita naturalmente semana a semana do dia escolhido. Não selecione nenhum horário acima</p>
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 130px; }
</style>

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
<?
$datadia = date('Y-m-d', strtotime("+1 days", strtotime($consultas[0]->data)));

for ($i = 1; $i <= 6; $i++) {

    $dia = strftime("%A", strtotime($datadia));
    switch ($dia) {
        case"Sunday": $data = "Domingo";
            break;
        case"Monday": $data = "Segunda";
            break;
        case"Tuesday": $data = "Terça";
            break;
        case"Wednesday": $data = "Quarta";
            break;
        case"Thursday": $data = "Quinta";
            break;
        case"Friday": $data = "Sexta";
            break;
        case"Saturday": $data = "Sabado";
            break;
    }
    switch ($dia) {
        case"Sunday": $numerodia = "0";
            break;
        case"Monday": $numerodia = "1";
            break;
        case"Tuesday": $numerodia = "2";
            break;
        case"Wednesday": $numerodia = "3";
            break;
        case"Thursday": $numerodia = "4";
            break;
        case"Friday": $numerodia = "5";
            break;
        case"Saturday": $numerodia = "6";
            break;
    }
    ?>
        $(function () {
            $('#medico<?= $numerodia ?>').change(function () {
                if ($(this).val()) {
                    $('#horarios').hide();
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/horariosambulatorioespecialidadepersonalizado', {exame: $(this).val(), teste: $('#data<?= $dia ?>').val()}, function (j) {
                        var options = '<option value=""></option>';
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + ' ' + j[i].medico + '</option>';
                        }
                        $('#horarios<?= $numerodia ?>').html(options).show();
                        $('.carregando').hide();
                    });
                } else {
                    $('#horarios<?= $numerodia ?>').html('<option value="">-- Escolha um exame --</option>');
                }
            });
        });
    //        alert('<?= $datadia ?>');

    <?
    $datadia = date('Y-m-d', strtotime("+1 days", strtotime($datadia)));
}
?>

    jQuery("#txtTelefone")
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
        $("#data_ficha").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


    $(function () {
        $('#convenio').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniofisioterapia', {convenio1: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
                    $('#procedimento option').remove();
                    $('#procedimento').append(options);
                    $("#procedimento").trigger("chosen:updated");
//                    $('#procedimento').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento option').remove();
                $('#procedimento').append('');
                $("#procedimento").trigger("chosen:updated");
            }
        });
    });

    $(function () {
        $('#procedimento').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia', {procedimento1: $(this).val(), ajax: true}, function (j) {
                    qtde = "";
                    qtde += j[0].qtde;
                    document.getElementById("sessao").value = qtde;
                    $('.carregando').hide();
                });
            } else {
                $('#sessao').html('value=""');
            }
        });
    });


    $(function () {
        $('#exame').change(function () {
            if ($(this).val()) {
                $('#horarios').hide();
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatorio', {exame: $(this).val(), teste: $("#data_ficha").val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '-' + j[i].nome + '-' + j[i].medico_agenda + '</option>';
                    }
                    $('#horarios').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#horarios').html('<option value="">-- Escolha um médico --</option>');
            }
        });
    });

    $(function () {
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 10, // Todas as telas de agendamento eu coloquei esse comentario. Quando for alterar esse valor, basta ir em "Localizar em Projetos" e pesquisar por ele.
            focus: function (event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#txtTelefone").val(ui.item.itens);
                $("#txtCelular").val(ui.item.celular);
                $("#telefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                return false;
            }
        });
    });



    //$(function(){     
    //    $('#exame').change(function(){
    //        exame = $(this).val();
    //        if ( exame === '')
    //            return false;
    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
    //            var option = new Array();
    //            $.each(data, function(i, obj){
    //                console.log(obl);
    //                option[i] = document.createElement('option');
    //                $( option[i] ).attr( {value : obj.id} );
    //                $( option[i] ).append( obj.nome );
    //                $("select[name='horarios']").append( option[i] );
    //            });
    //        });
    //    });
    //});





    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_exametemp').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

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
            var aniversario = new Date(dtAtual.getFullYear(), parseInt(data.substring(3, 5)) - 1, data.substring(0, 2));

            if (dtAtual < aniversario) {
                idade--;
            }

            document.getElementById("idade2").value = idade + " ano(s)";
        }
    }

    jQuery("#nascimento").mask("99/99/9999");

</script>