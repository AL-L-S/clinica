<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>

    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacientetempgeral" method="post">

        <fieldset>
            <legend>Marcar Atendimento</legend>

            <div>
                <label>Nome</label>
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->_nome; ?>"/>
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" onblur="calculoIdade()"/>
            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade2" id="idade2" class="texto01" readonly/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= @$obj->_idade; ?>"  />

            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="txtTelefone" class="texto02" name="telefone"  value="<?= @$obj->_telefone; ?>" />
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" value="<?= @$obj->_celular; ?>" />
            </div>
            <div>
                <label>Convenio</label>
                <input type="text" id="txtCelular" class="texto02" name="convenio" value="<?= @$obj->_descricaoconvenio; ?>" readonly/>
            </div>
        </fieldset>
        <fieldset>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1" required/>
                <input type="hidden" name="txtpaciente_id" value="<?= @$obj->_paciente_id; ?>" />
            </div>
            <legend>Medicos</legend>

            <div>
                <label>Medico</label>
                <select name="exame" id="exame" class="size4" required>
                    <option value="" >Selecione</option>
                    <? foreach ($medico as $item) : ?>
                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div>
                <label>Horarios</label>
                <select name="horarios" id="horarios" class="size2" required>
                    <option value="" >-- Escolha um exame --</option>
                </select>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio1" id="convenio1" class="size4" required>
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select  name="procedimento1" id="procedimento1" class="size1" required>
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Obsedrva&ccedil;&otilde;es</label>
                <input type="text" id="observacoes" class="size3" name="observacoes" />
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    if (count($exames) > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header">Hora</th>
                    <th class="tabela_header">M&eacute;dico</th>
                    <th class="tabela_header">Observa&ccedil;&otilde;es</th>
                    <th class="tabela_header" colspan="2">&nbsp;</th>
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
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->sala . "-" . $item->medico; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                width=500,height=230');">=><?= $item->observacoes; ?></a></td>
                            <? if (empty($faltou)) { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/exametemp/excluirconsultatempgeral/<?= $item->agenda_exames_id; ?>/<?= @$obj->_paciente_id; ?>">
                                        excluir</a></td></div>
                        <? } ?>    
                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                <a href="<?= base_url() ?>ambulatorio/exametemp/reservartempgeral/<?= $item->agenda_exames_id; ?>/<?= @$obj->_paciente_id; ?>/<?= $item->medico_consulta_id; ?>/<?= $item->data; ?>">
                                    reservar</a></td></div>

                    </tr>

                </tbody>
                <?
            }
        }
        ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 
    <?
    if (count($consultasanteriores) > 0) {
        foreach ($consultasanteriores as $value) {
            $data_atual = date('Y-m-d');
            $data1 = new DateTime($data_atual);
            $data2 = new DateTime($value->data);

            $intervalo = $data1->diff($data2);
            ?>
            <h6>ULTIMO ATENDIMENTO: <?= $value->procedimento; ?> - DATA: <b><?= substr($value->data, 8, 2) . '/' . substr($value->data, 5, 2) . '/' . substr($value->data, 0, 4); ?> </b> - M&eacute;dico: <b> <?= $value->medico; ?></b> - Convenio:  <?= $value->convenio; ?> - <?= $intervalo->days ?> dia(s)</h6>

            <?
        }
    } else {
        ?>
        <h6>NENHUM ATENDIMENTO ENCONTRADO</h6>
        <?
    }
    ?>


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
        $('#exame').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatoriogeral', {exame: $(this).val(), teste: $("#data_ficha").val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '</option>';
                    }
                    $('#horarios').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#horarios').html('<option value="">-- Escolha um hora --</option>');
            }
        });
    });
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
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos', {convenio1: $(this).val(), ajax: true}, function (j) {
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
                },
                data_ficha: {
                    required: true
                },
                exame: {
                    required: true
                },
                convenio1: {
                    required: true
                },
                procedimento1: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                data_ficha: {
                    required: "*"
                },
                exame: {
                    required: "*"
                },
                convenio1: {
                    required: "*"
                },
                procedimento1: {
                    required: "*"
                }
            }
        });
    });


//    function calculoIdade() {
//        var data = document.getElementById("txtNascimento").value;
//        var ano = data.substring(6, 12);
//        var idade = new Date().getFullYear() - ano;
//        if (idade < 500) {
//            document.getElementById("idade2").value = idade;
//        }
//    }
    function calculoIdade() {
        var data = document.getElementById("txtNascimento").value;

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

    calculoIdade();

</script>