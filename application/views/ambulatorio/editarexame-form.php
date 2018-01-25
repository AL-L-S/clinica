<div class="content ficha_ceatox">
    <div >
        <h3 class="singular"><a href="#">Marcar exames</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/editarexames" method="post">
                <fieldset>
                    <legend>Dados do paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                        <input type="hidden" name="procedimento1" id="procedimento1" class="texto01" value="<?= $selecionado[0]->procedimento_tuss_id; ?>"/>
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

                    <!--                    <div>
                    
                                            <label>Idade</label>
                                            <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />
                    
                                        </div>-->

                    <div>
                        <label>Nome da M&atilde;e</label>


                        <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                    </div>
                </fieldset>

                <fieldset>
                    <dl>
                        <dt>Sala</dt>

                        <dd>
                            <select  name="sala1" id="sala1" class="size2" required="true" >
                                <option value="">Selecione</option>
                                <? foreach ($salas as $item) : ?>
                                    <option value="<?= $item->exame_sala_id; ?>" <?
                                    if ($selecionado[0]->agenda_exames_nome_id == $item->exame_sala_id) {
                                        echo 'selected';
                                    }
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </dd>
                    </dl>
                    <dl>

                        <dt>Médico</dt>

                        <dd>
                            <select name="medico_agenda" id="medico" class="size2" required="true">
                                <option value=""> </option>
                                <? foreach ($medico as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>"<?
                                    if ($selecionado[0]->medico_agenda == $value->operador_id):echo 'selected';
                                    endif;
                                    ?>>
                                                <?php echo $value->nome; ?>

                                    </option>
                                <? endforeach; ?>

                            </select>
                        </dd>
                        <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" value="<?= $ambulatorio_guia_id; ?>"/>
                        <input type="hidden" name="guia_id" id="guia_id" value="<?= $guia_id; ?>"/>
                        <dt>Solicitante</dt>
                        <dd><select  name="medico" id="medico" class="size2" required="true">
                                <option value="">Selecione</option>
                                <? foreach ($operadores as $item) : ?>
                                    <option value="<?= $item->operador_id; ?>" <?
                                    if ($selecionado[0]->medico_solicitante == $item->operador_id) {
                                        echo 'selected';
                                    }
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                            </select></dd>
                        <dt>Recomendação</dt>
                        <dd><select name="indicacao" id="indicacao" class="size4" >
                                <option value='' >Selecione</option>
                                <?php
                                $indicacao = $this->paciente->listaindicacao($_GET);
                                foreach ($indicacao as $item) {
                                    ?>
                                    <option value="<?php echo $item->paciente_indicacao_id; ?>" <?php
                                    if ($item->paciente_indicacao_id == $indicacao_selecionada[0]->indicacao) {
                                        echo 'selected';
                                    }
                                    ?>> 
                                                <?php echo $item->nome . ( ($item->registro != '' ) ? " - " . $item->registro : '' ); ?>
                                    </option>
                                    <?php
                                }
                                ?> 
                            </select></dd>
                        <dt>Autorização</dt>
                        <dd><input type="text" name="autorizacao1" id="autorizacao" class="size1" value="<? echo $selecionado[0]->autorizacao ?>"/></dd>

                        <dt>Data de Entrega</dt>
                        <dd><input type="text" name="data_entrega" id="data_entrega" class="size1" value="<?= ($selecionado[0]->data_entrega != '') ? date("d/m/Y", strtotime($selecionado[0]->data_entrega)) : ''; ?>"/></dd>
                        
                        <?
                        $operador_id = $this->session->userdata('operador_id');
                        $perfil_id = $this->session->userdata('perfil_id');

                        if ($operador_id == 1) {
                            ?>
                            <dt>Data de Faturamento</dt>
                            <dd><input type="text" name="data_faturar" id="data_faturar" class="size1" value="<?= ($selecionado[0]->data_faturar != '') ? date("d/m/Y", strtotime($selecionado[0]->data_faturar)) : ''; ?>"/></dd>
                            
                            <dt>Data de Agendamento</dt>
                            <dd><input type="text" name="data" id="data" class="size1" value="<? echo date("d/m/Y", strtotime($selecionado[0]->data)); ?>"/></dd>
                            
                            <dt>Data de Atendimento</dt>
                            <dd><input type="text" name="data_laudo" id="data_laudo" class="size1" value="<?= ($selecionado[0]->data_laudo != '') ? date("d/m/Y", strtotime($selecionado[0]->data_laudo)) : ''; ?>"/></dd>
                            
                            <dt>Data de Recebimento</dt>
                            <dd><input type="text" name="data_producao" id="data_producao" class="size1" value="<?= ($selecionado[0]->data_producao != '') ? date("d/m/Y", strtotime($selecionado[0]->data_producao)) : ''; ?>"/></dd>
                            
                        <? } ?>
                    </dl>
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
<script type="text/javascript">

                            $(function () {
                                $("#data_entrega").datepicker({
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
                                $("#data_faturar").datepicker({
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
                                $('#convenio1').change(function () {
                                    if ($(this).val()) {
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
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