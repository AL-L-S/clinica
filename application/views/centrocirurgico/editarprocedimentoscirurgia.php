<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->      
    <!--<form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/autorizarsolicitacaocirurgica" method="post">-->
    <?
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <fieldset >
        <legend>Dados da Solicitacao</legend>

        <div>
            <label>Paciente</label>
            <input type="hidden" id="txtsolcitacao_id" class="texto_id" name="txtsolcitacao_id" readonly="true" value="<?= @$solicitacao_id; ?>" />
            <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" value="<?= @$solicitacao[0]->paciente_id; ?>" />

            <input type="text" id="txtNome" required name="txtNome" class="texto10" value="<?= @$solicitacao[0]->paciente; ?>" readonly="true"/>
        </div>

        <div>
            <label>Telefone</label>
            <input type="text" id="telefone" class="texto02" name="telefone" value="<?= @$solicitacao[0]->telefone; ?>" readonly="true"/>
        </div>

        <div>
            <label>Solicitante</label>
            <input type="text"  id="solicitante" class="texto02" name="solicitante" value="<?= @$solicitacao[0]->solicitante; ?>" readonly="true"/>
        </div>

        <div>
            <label>Convenio</label>
            <input type="text"  id="convenio" class="texto02" name="convenio" value="<?= @$solicitacao[0]->convenio; ?>" readonly="true"/>
        </div>

        <div>
            <label>Hospital</label>
            <input type="text"  id="hospital" class="texto02" name="hospital" value="<?= @$solicitacao[0]->hospital; ?>" readonly="true"/>
        </div>

    </fieldset>

    <fieldset>
        <legend>Adicionar Procedimentos</legend>

        <fieldset>
            <legend>Procedimentos</legend>
            <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravareditarprocedimentoscirurgia/<?= $guia_id ?>/<?= $solicitacao_id ?>" method="post">
                <input type="hidden" name="txtdata" id="txtdata" alt="date" class="texto02" value="<?
                if (@$solicitacao[0]->data_prevista != '') {
                    echo date("d/m/Y", strtotime(@$solicitacao[0]->data_prevista));
                }
                ?>" required/>
                <input type="hidden" name="hora" id="hora" alt="99:99" class="texto02" value="<?
                if (@$solicitacao[0]->hora_prevista != '') {
                    echo date("H:i", strtotime(@$solicitacao[0]->hora_prevista));
                }
                ?>" required/>
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
                        <td><select  name="convenio1" id="convenio1" class="size2"  required=""<?
                            if ($perfil_id != 1) {
                                echo 'disabled';
                            }
                            ?>>
                                <option value="-1">Selecione</option>
                                <? foreach ($convenios as $item) : ?>
                                    <option value="<?= $item->convenio_id; ?>" ><?= $item->nome; ?></option>
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
                        <td>Valor Unitario</td>
                        <td><input type="text" name="valor1" id="valor1" <?
                            if ($perfil_id != 1) {
                                echo 'readonly';
                            }
                            ?> class="texto01"/></td>
                    </tr>
                    <tr>
                        <td>Pagamento</td>
                        <td><select  name="formapamento" id="formapamento" class="size2"  <?
                            if ($perfil_id != 1) {
                                echo 'disabled';
                            }
                            ?>>
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
            </form>
        </fieldset>

        <hr/>

        <!--<button type="submit" name="btnEnviar">Enviar</button>-->
        <!--<button type="reset" name="btnLimpar">Limpar</button>-->
    </fieldset>
    <fieldset>
        <legend>Editar Procedimentos</legend>

        <fieldset>
            <legend>Procedimentos</legend>
            <table id="table_agente_toxico" border="0">
                <thead>

                    <tr>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Convênio</th>
                        <th class="tabela_header">Valor</th>
                        <!--<th class="tabela_header">Quantidade</th>-->
                        <!--<th class="tabela_header">Horario Especial</th>-->
                        <th class="tabela_header"></th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $estilo_linha = "tabela_content01";
                    $i = 0;
                    foreach ($procedimentos as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>">
                                <input type="hidden" name="procedimento_convenio_id[<?= $i; ?>]" value="<?= $item->procedimento_convenio_id; ?>" />
                                <input type="hidden" name="cirurgia_procedimento_id[<?= $i; ?>]" value="<?= $item->solicitacao_cirurgia_procedimento_id; ?>" />
                                <?= $item->procedimento; ?>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>">
                                <?= $item->convenio; ?>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>">
                                R$ <?= number_format(@$item->valor, 2, ',', '.'); ?>
                            </td> 
                            <td class="<?php echo $estilo_linha; ?>">
                                <? if ($item->dinheiro == 'f') { ?>
                                    <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirprocedimentoscirurgia/<?= $item->solicitacao_cirurgia_procedimento_id; ?>/<?= @$guia_id; ?>/<?= $solicitacao_id ?>" class="delete">
                                    </a>
                                <? } ?>
                            </td>                            

                        </tr>
                        <?
                        $i++;
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
        <!--        </form>-->
        <hr/>

        <!--<button type="submit" name="btnEnviar">Enviar</button>-->
        <!--<button type="reset" name="btnLimpar">Limpar</button>-->
    </fieldset>

    <!--</form>-->
</div> <!-- Final da DIV content -->
<style>
    div#via label { color: black; font-weight: bolder; font-size: 12pt; }
    div#via label, div#via input{ display: inline-block; }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    $(function () {
        $("#txtdata").datepicker({
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
        $('#valor').blur(function () {

        });
    });


    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniocirurgico', {convenio1: $(this).val(), ajax: true}, function (j) {
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
        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniocirurgico', {convenio1: $('#convenio1').val(), ajax: true}, function (j) {
            var options = '<option value=""></option>';
            for (var c = 0; c < j.length; c++) {
                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';

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


</script>
