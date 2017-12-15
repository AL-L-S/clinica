<div class="content ficha_ceatox">

    <div >
        <?
        $sala = "";
        $ordenador1 = "";
        $sala_id = "";
        $medico_id = "";
        $medico = "";
        $medico_solicitante = "";
        $medico_solicitante_id = "";
        $convenio_paciente = "";
        $empresa = $this->guia->listarempresapermissoes(); 
        $odontologia_alterar = $empresa[0]->odontologia_valor_alterar;
        ?>
        <h3 class="singular"><a href="#">Or&ccedil;amento exames</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarorcamento" method="post">
                <fieldset>
                    <legend>Dados do paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
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
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th class="tabela_header">Convenio*</th>
                                <th class="tabela_header">Grupo</th>
                                <th class="tabela_header">Procedimento*</th>
                                <th class="tabela_header">Forma de Pagamento</th>
                                <th class="tabela_header">Qtde*</th>
                                <th class="tabela_header">V. Unit</th>
<!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td  width="50px;">
                                    <? //echo "<pre>"; var_dump($exames[count($exames) - 1]);die;?>
                                    <select  name="convenio1" id="convenio1" class="size1" >
                                        <option value="-1">Selecione</option>
                                        <?
                                        $lastConv = $exames[count($exames) - 1]->convenio_id;
                                        foreach ($convenio as $item) :
                                            ?>
                                            <option value="<?= $item->convenio_id; ?>" <? if ($lastConv == $item->convenio_id) echo 'selected'; ?>>
                                                <?= $item->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td width="50px;">
                                    <select  name="grupo1" id="grupo1" class="size1" >
                                        <option value="">Selecione</option>
                                        <?
                                        $lastGrupo = $exames[count($exames) - 1]->grupo;
                                        foreach ($grupos as $value) :
                                            ?>
                                            <option value="<?= $value->nome; ?>" <? if ($lastGrupo == $value->nome) echo 'selected'; ?>>
                                                <?= $value->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td  width="50px;">
<!--                                    <select  name="procedimento1" id="procedimento1" class="size1" >
                                        <option value="">Selecione</option>
                                    </select>-->

                                    <select name="procedimento1" id="procedimento1" required class="size4 chosen-select" data-placeholder="Selecione" tabindex="1">
                                        <option value="">Selecione</option>
                                    </select>
                                </td>
                                
                                <td width="100px;">

                                    <select name="formapamento" id="formapamento" class="size1" >
                                        <option value="">Selecione</option>
                                        <? foreach ($forma_pagamento as $item) : ?>
                                            <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td  width="10px;"><input type="text" name="qtde1" id="qtde1" value="1" class="texto00"/></td>
                                <td  width="20px;"><input type="text" name="valor1" id="valor1" class="texto01" readonly=""/></td>
                            </tr>

                        </tbody>

                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="4">
                                </th>
                            </tr>
                        </tfoot>
                    </table> 
                    <hr/>
                    <button type="submit" name="btnEnviar">Adicionar</button>
                </fieldset>
            </form>
            <fieldset>
                <?
                $total = 0;
                $orcamento = 0;
                if (count($exames) > 0) {
                    ?>
                    <table id="table_agente_toxico" border="0">
                        <thead>
                            <tr>
                                <th colspan="10"><span style="font-size: 12pt; font-weight: bold;">Operador Responsavel: <?= @$responsavel[0]->nome ?></span></th>
                            </tr>
                            <tr>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Grupo</th>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">Forma de Pagamento</th>
                                <th class="tabela_header">Descriçao</th>
                                <th class="tabela_header">V. Unit</th>
                                <th class="tabela_header"></th>
                            </tr>
                        </thead>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($exames as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            $total = $total + $item->valor_total;
                            $orcamento = $item->orcamento_id;
                            ?>
                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->forma_pagamento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao_procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a href="<?= base_url() ?>ambulatorio/guia/excluirorcamento/<?= $item->ambulatorio_orcamento_item_id ?>/<?= $item->paciente_id ?>/<?= $item->orcamento_id ?>" class="delete">
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                            <?
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="2">
                                Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                            </th>
                            <th colspan="1" align="center"><center><div class="bt_linkf">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoorcamento/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Imprimir Or&ccedil;amento

                                </a></div></center>
                            </th>
                            <th colspan="2" align="center">
                                <center>
                                    <div class="bt_linkf">
                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/orcamentocadastrofila/" . $orcamento; ?> ', '_blank', 'width=600,height=600');">Fila de Impressão</a>
                                    </div>
                                </center>
                            </th>
                            <th colspan="2" align="center">
                                <center>
                                    <div class="bt_linkf">
                                        <a href="<?= base_url() . "ambulatorio/exame/autorizarorcamento/" . $orcamento; ?>" target='_blank'>Autorizar Orçamento</a>
                                    </div>
                                </center>
                            </th>
                        </tr>
                    </tfoot>
                </table> 

            </fieldset>

        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt; }
</style>
<script type="text/javascript">
                                if ($('#convenio1').val() != '-1') {
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $('#convenio1').val(), ajax: true}, function (j) {
                                        options = '<option value=""></option>';
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                        }
//                                        $('#procedimento1').html(options).show();

                                        $('#procedimento1 option').remove();
                                        $('#procedimento1').append(options);
                                        $("#procedimento1").trigger("chosen:updated");
                                        $('.carregando').hide();
                                    });
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $('#grupo1').val(), convenio1: $('#convenio1').val()}, function (j) {
                                        options = '<option value=""></option>';
//                                        alert('ola');
                                        for (var c = 0; c < j.length; c++) {
                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                        }

                                        $('#procedimento1 option').remove();
                                        $('#procedimento1').append(options);
                                        $("#procedimento1").trigger("chosen:updated");
//                                        $('#procedimento1').html(options).show();
                                        $('.carregando').hide();
                                    });
                                }

                                $(function () {
                                    $('#grupo1').change(function () {
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $(this).val(), convenio1: $('#convenio1').val()}, function (j) {
                                            options = '<option value=""></option>';
                                            for (var c = 0; c < j.length; c++) {
                                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                            }

                                            $('#procedimento1 option').remove();
                                            $('#procedimento1').append(options);
                                            $("#procedimento1").trigger("chosen:updated");
//                                            $('#procedimento1').html(options).show();
                                            $('.carregando').hide();
                                        });
                                    });
                                });

                                $(function () {
                                    $("#data").datepicker({
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
                                    $("#accordion").accordion();
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
                                    $('#convenio1').change(function () {
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioorcamento', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                options = '<option value=""></option>';
                                                for (var c = 0; c < j.length; c++) {
                                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                }
//                                                console.log(options);
//                                                $('#procedimento1').html(options).show();

                                                $('#procedimento1 option').remove();
                                                $('#procedimento1').append(options);
                                                $("#procedimento1").trigger("chosen:updated");
                                                $('.carregando').hide();
                                            });
                                            if ($('#grupo1').val() != '') {
                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupoorcamento', {grupo1: $('#grupo1').val(), convenio1: $('#convenio1').val()}, function (j) {
                                                    options = '<option value=""></option>';
                                                    for (var c = 0; c < j.length; c++) {
                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                    }
//                                                    $('#procedimento1').html(options).show();

                                                    $('#procedimento1 option').remove();
                                                    $('#procedimento1').append(options);
                                                    $("#procedimento1").trigger("chosen:updated");
                                                    $('.carregando').hide();
                                                });
                                            }

                                        } else {
                                            $('#procedimento1').html('<option value="">Selecione</option>');
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
                                                <? if($odontologia_alterar == 't'){?>
                                                    if(j[0].grupo == 'ODONTOLOGIA'){
                                                        $("#valor1").prop('readonly', false);
                                                    }else{
                                                        $("#valor1").prop('readonly', true);
                                                    }    
                                                <? } ?>
                                                document.getElementById("valor1").value = options
                                                $('.carregando').hide();
                                            });
                                        } else {
                                            $('#valor1').html('value=""');
                                        }
                                    });
                                });




</script>
