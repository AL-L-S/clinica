<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <!--<div class="clear"></div>-->
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
            Novo Medico
        </a>
    </div>
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente_id ?>');">
            Nova guia
        </a>
    </div>

    <div>
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>cadastros/pacientes/autorizarambulatoriotempgeral/<?= $paciente_id; ?>" method="post">
            <fieldset>
                <legend>Dados do Pacienete</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <select name="sexo" id="txtSexo" class="size2">
                        <option value="M" <?
                        if ($paciente['0']->sexo == "M"):echo 'selected';
                        endif;
                        ?>>Masculino</option>
                        <option value="F" <?
                        if ($paciente['0']->sexo == "F"):echo 'selected';
                        endif;
                        ?>>Feminino</option>
                    </select>
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
            </fieldset>
            <fieldset>
                <legend>Consultas anteriores</legend>
                <?
                if (count($consultasanteriores) > 0) {
                    foreach ($consultasanteriores as $value) {
                        $data_atual = date('Y-m-d');
                        $data1 = new DateTime($data_atual);
                        $data2 = new DateTime($value->data);

                        $intervalo = $data1->diff($data2);
                        ?>
                        <h6>ULTIMA ATENDIMENTO: <?= $value->procedimento; ?> - DATA: <b><?= substr($value->data, 8, 2) . '/' . substr($value->data, 5, 2) . '/' . substr($value->data, 0, 4); ?> </b> - M&eacute;dico: <b> <?= $value->medico; ?></b> - Convenio:  <?= $value->convenio; ?> - <?= $intervalo->d . ' dias' ?></h6>

                        <?
                    }
                } else {
                    ?>
                    <h6>NENHUMA CONSULTA ENCONTRADA</h6>
                    <?
                }
                ?>
            </fieldset>
            <input type="hidden" name="paciente_id" value="<?= $paciente_id; ?>" />

            <fieldset>
                <legend>Autorizar sess&otilde;es de fisioterapia</legend>
                <table id="table_justa">
                    <thead>

                        <tr>
                            <th class="tabela_header">Hora</th>
                            <th class="tabela_header">Sala</th>
                            <th class="tabela_header">Medico</th>
                            <th class="tabela_header">Solicitante</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">autorizacao</th>
                            <th class="tabela_header">V. Unit</th>
                            <th class="tabela_header">Qtde</th>
                            <th class="tabela_header">Pagamento</th>
                            <th class="tabela_header">ordenador</th>
                            <th class="tabela_header">Confir.</th>
                            <th class="tabela_header">Descricao</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    $i = 0;
                    foreach ($exames as $item) {
                        $i++;
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        $agenda_exame_id = $item->agenda_exames_id;
                        ?>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->inicio, 0, 5); ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="sala[<?= $i; ?>]" id="sala<?= $i; ?>" class="size1" >
                                        <option value="-1">Selecione</option>
                                        <? foreach ($salas as $itens) : ?>
                                            <option value="<?= $itens->exame_sala_id; ?>"><?= $itens->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="medico_id[<?= $i; ?>]" id="medico_id<?= $i; ?>" class="size1" >
                                        <option value="-1">Selecione</option>
                                        <? foreach ($medicos as $itens) : ?>
                                            <option value="<?= $itens->operador_id; ?>"><?= $itens->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="medico[<?= $i; ?>]" id="medico<?= $i; ?>" class="size1"/>
                                    <input type="hidden" name="crm[<?= $i; ?>]" id="crm<?= $i; ?>" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="convenio[<?= $i; ?>]" id="convenio<?= $i; ?>" class="size1" >
                                        <option value="">Selecione</option>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="procedimento[<?= $i; ?>]" id="procedimento<?= $i; ?>" class="size1" >
                                        <option value="-1">-- Escolha um procedimento --</option>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="autorizacao[<?= $i; ?>]" id="autorizacao" class="size1"/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="valor[<?= $i; ?>]" id="valor<?= $i; ?>" class="texto01" readonly=""/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="qtde[<?= $i; ?>]" id="qtde<?= $i; ?>" alt="numeromask" value="1" class="texto00"/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="formapamento[<?= $i; ?>]" id="formapamento<?= $i; ?>" class="size1" >
                                        <option value="0">Selecione</option>
                                        <? foreach ($forma_pagamento as $value) : ?>
                                            <option value="<?= $value->forma_pagamento_id; ?>"><?= $value->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" ><input type="text" name="ordenador" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>" ><input type="checkbox" name="confimado[<?= $i; ?>]" /><input type="hidden" name="agenda_exames_id[<?= $i; ?>]" value="<?= $agenda_exame_id; ?>" /></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?= substr($item->medico, 0, 12); ?> <br><?= substr($item->procedimento, 0, 12); ?></td>
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
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </fieldset>
        </form>
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

<?php if ($this->session->flashdata('message') != ''): ?>
                            alert("<? echo $this->session->flashdata('message') ?>");
<? endif; ?>
                        $(function () {
                            $("#medico1").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico1").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico1").val(ui.item.value);
                                    $("#crm1").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico2").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico2").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico2").val(ui.item.value);
                                    $("#crm2").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico3").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico3").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico3").val(ui.item.value);
                                    $("#crm3").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico4").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico4").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico4").val(ui.item.value);
                                    $("#crm4").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico5").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico5").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico5").val(ui.item.value);
                                    $("#crm5").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico6").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico6").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico6").val(ui.item.value);
                                    $("#crm6").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico7").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico7").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico7").val(ui.item.value);
                                    $("#crm7").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico8").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico8").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico8").val(ui.item.value);
                                    $("#crm8").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico9").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico9").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico9").val(ui.item.value);
                                    $("#crm9").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $("#medico10").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#medico10").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#medico10").val(ui.item.value);
                                    $("#crm10").val(ui.item.id);
                                    return false;
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id1').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio1', {medico_id1: $(this).val(), ajax: true}, function (j) {
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
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento1').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento1').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor1").value = options;
                                        document.getElementById("qtde1").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor1').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id2').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio2', {medico_id2: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio2').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio2').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio2').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos2', {convenio2: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento2').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento2').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento2').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia2', {procedimento2: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor2").value = options;
                                        document.getElementById("qtde2").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor2').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id3').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio3', {medico_id3: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio3').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio3').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });
                        $(function () {
                            $('#convenio3').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos3', {convenio3: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento3').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento3').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento3').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia3', {procedimento3: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor3").value = options;
                                        document.getElementById("qtde3").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor3').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id4').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio4', {medico_id4: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio4').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio4').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio4').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos4', {convenio4: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento4').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento4').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento4').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia4', {procedimento4: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor4").value = options;
                                        document.getElementById("qtde4").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor4').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id5').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio5', {medico_id5: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio5').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio5').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio5').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos5', {convenio5: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento5').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento5').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento5').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia5', {procedimento5: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor5").value = options;
                                        document.getElementById("qtde5").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor5').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id6').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio6', {medico_id6: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio6').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio6').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio6').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos6', {convenio6: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento6').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento6').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento6').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia6', {procedimento6: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor6").value = options;
                                        document.getElementById("qtde6").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor6').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id7').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio7', {medico_id7: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio7').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio7').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio7').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos7', {convenio7: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento7').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento7').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento7').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia7', {procedimento7: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor7").value = options;
                                        document.getElementById("qtde7").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor7').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id8').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio8', {medico_id8: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio8').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio8').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio8').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos8', {convenio8: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento8').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento8').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento8').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia8', {procedimento8: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor8").value = options;
                                        document.getElementById("qtde8").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor8').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id9').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio9', {medico_id9: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio9').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio9').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio9').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos9', {convenio9: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento9').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento9').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento9').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia9', {procedimento9: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor9").value = options;
                                        document.getElementById("qtde9").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor9').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id10').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio10', {medico_id10: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio10').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio10').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio10').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos10', {convenio10: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento10').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento10').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento10').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia10', {procedimento10: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor10").value = options;
                                        document.getElementById("qtde10").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor10').html('value=""');
                                }
                            });
                        });


                        $(function () {
                            $('#medico_id11').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio11', {medico_id11: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio11').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio11').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio11').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos11', {convenio11: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento11').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento11').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento11').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia11', {procedimento10: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor11").value = options;
                                        document.getElementById("qtde11").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor11').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id12').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio12', {medico_id12: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio12').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio12').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio12').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos12', {convenio12: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento12').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento12').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento12').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia12', {procedimento12: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor12").value = options;
                                        document.getElementById("qtde12").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor12').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id13').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio13', {medico_id13: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio13').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio13').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio13').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos13', {convenio13: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento13').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento13').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento13').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia13', {procedimento13: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor13").value = options;
                                        document.getElementById("qtde13").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor13').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id14').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio14', {medico_id14: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio14').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio14').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio14').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos14', {convenio14: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento14').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento14').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento14').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia14', {procedimento14: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor14").value = options;
                                        document.getElementById("qtde14").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor14').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#medico_id15').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio15', {medico_id15: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var i = 0; i < j.length; i++) {
                                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                                        }
                                        $('#convenio15').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#convenio15').html('<option value="">-- Escolha um hora --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#convenio15').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos15', {convenio15: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }
                                        $('#procedimento15').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#procedimento15').html('<option value="">-- Escolha um exame --</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento15').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia15', {procedimento15: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        qtde = "";
                                        qtde += j[0].qtde;
                                        document.getElementById("valor15").value = options;
                                        document.getElementById("qtde15").value = qtde;
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#valor10').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento1').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento1').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento1').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento2').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento2', {procedimento2: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento2').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento2').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento3').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento3', {procedimento3: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento3').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento3').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento4').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento4', {procedimento4: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento4').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento4').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento5').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento5', {procedimento5: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento5').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento5').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento6').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento6', {procedimento6: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento6').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento6').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento7').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento7', {procedimento7: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento7').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento7').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento8').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento8', {procedimento8: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento8').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento8').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento9').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento9', {procedimento9: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento9').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento9').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

                        $(function () {
                            $('#procedimento10').change(function () {
                                if ($(this).val()) {
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento10', {procedimento10: $(this).val(), ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento10').html(options).show();
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#formapamento10').html('<option value="0">Selecione</option>');
                                }
                            });
                        });

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
                                    nascimento: {
                                        required: true
                                    },
                                    idade: {
                                        required: true
                                    }
                                },
                                messages: {
                                    txtNome: {
                                        required: "*",
                                        minlength: "!"
                                    },
                                    nascimento: {
                                        required: "*"
                                    },
                                    idade: {
                                        required: "*"
                                    }
                                }
                            });
                        });

</script>
