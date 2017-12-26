<div class="content ficha_ceatox">
    <div >
        <h3 class="singular"><a href="#">Marcar Exames</a></h3>
        <div>
            <?
            $perfil_id = $this->session->userdata('perfil_id');
            ?>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/valorexames" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hiden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
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
                    <table>
                        <tr>
                            <td>Quantidade</td>
                            <td>
                                <input type="text" name="qtde1" id="qtde1" value="1" class="texto00"/>
                                <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" value="<?= $ambulatorio_guia_id; ?>"/>
                                <input type="hidden" name="guia_id" id="guia_id" value="<?= $guia_id; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Convenio</td>
                            <td><select  name="convenio1" id="convenio1" class="size2" <? if ($perfil_id != 1) {
                                                echo 'disabled';
                                            } ?>>
                                    <option value="-1">Selecione</option>
                                    <? foreach ($convenio as $item) : ?>
                                        <option value="<?= $item->convenio_id; ?>" <?
                                    if ($exame[0]->convenio_id == $item->convenio_id) {
                                        echo 'selected';
                                    }
                                        ?>><?= $item->nome; ?></option>
                                            <? endforeach; ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Procedimento</td>
                            <td>
                                <select name="procedimento1" id="procedimento1" class="size4 chosen-select" data-placeholder="Selecione" tabindex="1">
                                    <option value="">Selecione</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Autorização</td>
                            <td><input type="text" name="autorizacao1" id="autorizacao" class="size1"/></td>
                        </tr>
                        <tr>
                            <td>Valor Unitario</td>
                            <td><input type="text" name="valor1" id="valor1" <? if ($perfil_id != 1) {
                                                echo 'readonly';
                                            } ?> class="texto01"/></td>
                        </tr>
                        <tr>
                            <td>Pagamento</td>
                            <td><select  name="formapamento" id="formapamento" class="size2"  <? if ($perfil_id != 1) {
                                                echo 'disabled';
                                            } ?>>
                                    <option value="0">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
<? endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                </fieldset>
            </form>
        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    /*.chosen-container{ margin-top: 5pt;}*/
    #procedimento1_chosen { width: 430px; }
</style>
<script type="text/javascript">

                            $(function () {
                                $("#accordion").accordion();
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
//                    $('#procedimento1').html(options).show();
                                            $('#procedimento1 option').remove();
                                            $('#procedimento1').append(options);
                                            $("#procedimento1").trigger("chosen:updated");
                                            $('.carregando').hide();
                                        });
                                    } else {
                                        $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
                                    }
                                });
                            });


                            if ($('#convenio1').val() != '') {
//                            alert('asdsd');
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos', {convenio1: $('#convenio1').val(), ajax: true}, function (j) {
                                    var options = '<option value=""></option>';
                                    for (var c = 0; c < j.length; c++) {

                                        if (j[c].procedimento_convenio_id == <?= $exame[0]->procedimento_convenio_id ?>) {
                                            options += '<option selected value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
//                                            alert(j[c].procedimento);
                                        } else {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                        }


                                    }

//                    $('#procedimento1').html(options).show();
                                    $('#procedimento1 option').remove();
                                    $('#procedimento1').append(options);
                                    $("#procedimento1").trigger("chosen:updated");
                                    $('.carregando').hide();

                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $('#procedimento1').val(), ajax: true}, function (j) {
                                        options = "";
                                        options += j[0].valortotal;
                                        document.getElementById("valor1").value = options
                                        $('.carregando').hide();
                                    });
                                });
                            } else {
                                $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
                            }



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


                            $(document).ready(function () {
                                jQuery('#form_guia').validate({
                                    rules: {
                                        medico1: {
                                            required: true,
                                            minlength: 3
                                        },
                                        crm: {
                                            required: true
                                        },
                                        sala1: {
                                            required: true
                                        }
                                    },
                                    messages: {
                                        medico1: {
                                            required: "*",
                                            minlength: "!"
                                        },
                                        crm: {
                                            required: "*"
                                        },
                                        sala1: {
                                            required: "*"
                                        }
                                    }
                                });
                            });

</script>