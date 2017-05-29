<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <!--<div class="clear"></div>-->
    <div class="bt_link_new" style="width: 150pt">
        <a style="width: 150pt" onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
            Novo Medico Solicitante
        </a>
    </div>
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente_id ?>');">
            Nova guia
        </a>
    </div>

    <div>
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>cadastros/pacientes/autorizarambulatoriotemp/<?= $paciente_id; ?>" method="post">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <input name="sexo" id="txtSexo" class="size2" 
                           value="<?
                           if ($paciente['0']->sexo == "M"):echo 'Masculino';
                           endif;
                           if ($paciente['0']->sexo == "F"):echo 'Feminino';
                           endif;
                           ?>" readonly="true">
                </div>

                <div>
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>

                <div>

                    <label>Idade</label>
                    <input type="text" name="txtIdade" id="txtIdade" class="texto01" readonly/>

                </div>

                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto09" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
            </fieldset>
            <input type="hidden" name="paciente_id" value="<?= $paciente_id; ?>" />

            <fieldset>
                <legend>Autorizar exames</legend>
                <table id="table_justa">
                    <thead>

                        <tr>
                            <th class="tabela_header">Hora</th>
                            <th class="tabela_header">Sala</th>
                            <th class="tabela_header">Qtde</th>
                            <th class="tabela_header">Solicitante</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">autorizacao</th>
                            <th class="tabela_header">V. Unit</th>
                            <th class="tabela_header">Pagamento</th>
                            <th class="tabela_header">Recomendação</th>
                            <th class="tabela_header">Entrega</th>
                            <th class="tabela_header">ordenador</th>
                            <th class="tabela_header">Confir.</th>
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
                        <input type="hidden" name="medicoexecutante[<?= $i; ?>]" value="<?= $item->medico_agenda; ?>" class="size1"/>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->inicio, 0, 5); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?= $item->sala; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="qtde[<?= $i; ?>]" id="qtde<?= $i; ?>"  alt="numeromask" value="1" class="texto00"/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="medico[<?= $i; ?>]" id="medico<?= $i; ?>" class="size1"/>
                                    <input type="hidden" name="crm[<?= $i; ?>]" id="crm<?= $i; ?>" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="convenio[<?= $i; ?>]" id="convenio<?= $i; ?>" class="size1" >
                                        <option value="">Selecione</option>
                                        <? foreach ($convenio as $value) : ?>
                                            <option value="<?= $value->convenio_id; ?>" <? if ($value->convenio_id == $item->convenio_agenda) echo'selected'; ?>><?= $value->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="procedimento[<?= $i; ?>]" id="procedimento<?= $i; ?>" class="size1" >
                                        <option value="">-- Escolha um procedimento --</option>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="autorizacao[<?= $i; ?>]" id="autorizacao<?= $i; ?>" class="size1"/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="valor[<?= $i; ?>]" id="valor<?= $i; ?>" class="texto01" readonly=""/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="formapamento[<?= $i; ?>]" id="formapamento<?= $i; ?>" class="size1" >
                                        <option value="0">Selecione</option>
                                        <? //foreach ($forma_pagamento as $item) : ?>
    <!--                                            <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>-->
                                        <? // endforeach;  ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select name="indicacao[<?= $i; ?>]" id="indicacao" class="size1" >
                                        <option value=''>Selecione</option>
                                        <?php
                                        $indicacao = $this->paciente->listaindicacao($_GET);
                                        foreach ($indicacao as $item) {
                                            ?>
                                            <option value="<?php echo $item->paciente_indicacao_id; ?>">
                                                <?php echo $item->nome; ?>
                                            </option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" ><input type="text" alt="date" name="data[<?= $i; ?>]" id="data<?= $i; ?>" class="size1" /></td>
                                <td class="<?php echo $estilo_linha; ?>" ><input type="text" name="ordenador" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>" ><input type="checkbox" name="confimado[<?= $i; ?>]" id="checkbox<?= $i; ?>" /><input type="hidden" name="agenda_exames_id[<?= $i; ?>]" value="<?= $agenda_exame_id; ?>" /></td>

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
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">


                        $(document).ready(function () {

<? for ($b = 1; $b <= $i; $b++) { ?>

    <? $it = ($b == 1) ? '' : $b; ?>
                                var convenio_agendado = <?= @$exames[$b - 1]->convenio_agenda ?>;
                                var proc_agendado = <?= @$exames[$b - 1]->procedimento_tuss_id ?>;

                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio<?= $it ?>', {convenio<?= $b ?>: convenio_agendado, ajax: true}, function (t) {

                                            var opt = '<option value=""></option>';
                                            var slt = '';
                                            for (var c = 0; c < t.length; c++) {
                                                if (proc_agendado == t[c].procedimento_convenio_id) {
                                                    slt = "selected='true'";
                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor<?= $it ?>', {procedimento<?= $b ?>: t[c].procedimento_convenio_id, ajax: true}, function (a) {
                                                                            var valor = a[0].valortotal;
                                                                            var qtde = a[0].qtde;
                                                                            document.getElementById("valor<?= $b ?>").value = valor;
                                                                            document.getElementById("qtde<?= $b ?>").value = qtde;
                                                                            $('.carregando').hide();
                                                                        });
                                                                    }
                                                                    opt += '<option value="' + t[c].procedimento_convenio_id + '"' + slt + '>' + t[c].procedimento + '</option>';
                                                                    slt = '';
                                                                }
                                                                $('#procedimento<?= $b ?>').html(opt).show();
                                                                $('.carregando').hide();
                                                            });
                                                            
                                                            $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio<?= $b ?>: convenio_agendado}, function (j) {
//                                                                options = '<option value=""></option>';
                                                                if (j[0].carteira_obrigatoria == 't') {
                                                                    $("#autorizacao<?= $b; ?>").prop('required', true);
                                                                } else {
                                                                    $("#autorizacao<?= $b; ?>").prop('required', false);
                                                                }

                                                            });


                                                            //                                alert(convenio_agendado, proc_agendado);
                                                            $('#checkbox<?= $b ?>').change(function () {
                                                                if ($(this).is(":checked")) {
                                                                    $("#medico_id<?= $b; ?>").prop('required', true);
                                                                    $("#medico<?= $b; ?>").prop('required', true);
                                                                    $("#sala<?= $b; ?>").prop('required', true);
                                                                    $("#convenio<?= $b; ?>").prop('required', true);
                                                                    $("#procedimento<?= $b; ?>").prop('required', true);
                                                                    //                                        $("#autorizacao<?= $b; ?>").prop('required', true);
                                                                } else {
                                                                    $("#medico_id<?= $b; ?>").prop('required', false);
                                                                    $("#medico<?= $b; ?>").prop('required', false);
                                                                    $("#sala<?= $b; ?>").prop('required', false);
                                                                    $("#convenio<?= $b; ?>").prop('required', false);
                                                                    $("#procedimento<?= $b; ?>").prop('required', false);
                                                                    //                                        $("#autorizacao<?= $b; ?>").prop('required', false);
                                                                }
                                                            });




<? }
?>

                                                    });
<? for ($b = 1; $b <= $i; $b++) { ?>
                                                        $(function () {
                                                            $('#convenio<?= $b; ?>').change(function () {
                                                                if ($(this).val()) {
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $(this).val()}, function (j) {
                                                                        options = '<option value=""></option>';
                                                                        if (j[0].carteira_obrigatoria == 't') {
                                                                            $("#autorizacao<?= $b; ?>").prop('required', true);
                                                                        } else {
                                                                            $("#autorizacao<?= $b; ?>").prop('required', false);
                                                                        }

                                                                    });
                                                                }
                                                            });
                                                        });

<? }
?>


                                                    $(function () {
                                                        $("#data1").datepicker({
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
                                                        $("#data2").datepicker({
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
                                                        $("#data3").datepicker({
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
                                                        $("#data4").datepicker({
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
                                                        $("#data5").datepicker({
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
                                                        $("#data6").datepicker({
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
                                                        $("#data7").datepicker({
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
                                                        $("#data8").datepicker({
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
                                                        $("#data9").datepicker({
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
                                                        $("#data10").datepicker({
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
                                                        $('#convenio1').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor1").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor1').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio2').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio2', {convenio2: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor2', {procedimento2: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor2").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor2').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio3').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio3', {convenio3: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor3', {procedimento3: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor3").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor3').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio4').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio4', {convenio4: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor4', {procedimento4: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor4").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor4').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio5').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio5', {convenio5: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor5', {procedimento5: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor5").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor5').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio6').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio6', {convenio6: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor6', {procedimento6: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor6").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor6').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio7').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio7', {convenio7: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor7', {procedimento7: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor7").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor7').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio8').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio8', {convenio8: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor8', {procedimento8: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor8").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor8').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio9').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio9', {convenio9: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor9', {procedimento9: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor9").value = options
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {
                                                                $('#valor9').html('value=""');
                                                            }
                                                        });
                                                    });

                                                    $(function () {
                                                        $('#convenio10').change(function () {
                                                            if ($(this).val()) {
                                                                $('.carregando').show();
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio10', {convenio10: $(this).val(), ajax: true}, function (j) {
                                                                    var options = '<option value=""></option>';
                                                                    for (var c = 0; c < j.length; c++) {
                                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
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
                                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor10', {procedimento10: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].valortotal;
                                                                    document.getElementById("valor10").value = options
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
//            $(function(){
//        $('#procedimento2').change(function(){
//            if( $(this).val() ) {
//                $('.carregando').show();
//                $.getJSON('<?= base_url() ?>autocomplete/listarautocompleteprocedimentosforma',{procedimento2:$(this).val(), ajax:true}, function(j){
//                    var options = '<option value=""></option>';	
//                    for (var c = 0; c < j.length; c++) {
//                        options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
//                    }	
//                    $('#formapamento2').html(options).show();
//                    $('.carregando').hide();
//                });
//            } else {
//                $('#formapamento2').html('<option value="0">Selecione</option>');
//            }
//        });
//    });

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

                                                    function calculoIdade() {
                                                        var data = document.getElementById("txtNascimento").value;
                                                        var ano = data.substring(6, 12);
                                                        var idade = new Date().getFullYear() - ano;
                                                        document.getElementById("txtIdade").value = idade;
                                                    }

                                                    calculoIdade();

</script>
