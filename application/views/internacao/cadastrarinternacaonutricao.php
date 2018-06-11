<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Internacao</h3>
    <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarinternacaonutricao/<?= $paciente_id; ?>" method="post">
        <fieldset>
            <legend>Dados do Pacienete</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
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
            <div>
                <label>Nome do Pai</label>
                <input type="text"  name="nome_pai" id="txtNomePai" class="texto08" value="<?= $paciente['0']->nome_pai; ?>" readonly/>
            </div>
            <div>
                <label>CNS</label>
                <input type="text" id="txtCns" name="cns"  class="texto04" value="<?= $paciente['0']->cns; ?>" readonly/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Dados da internacao</legend>


            <div>
                <label>GIH</label>
                <input type="hidden" id="txtinternacao_id" name="internacao_id"  class="texto01" value="<?= @$obj->_internacao_id; ?>" readonly/>
                <input type="text" id="txtaih" class="texto06" name="aih" value="<?= @$obj->_aih; ?>" />
            </div>
            <div>
                <label>Data solicita&ccedil;&atilde;o</label>
                <input type="text" id="data_solicitacao" class="texto02" name="data_solicitacao" value="<?= @$obj->_data_solicitacao; ?>" />
            </div>
            <div>
                <label>Data Interna&ccedil;&atilde;o</label>
                <input type="text" id="data_internacao" class="texto02" name="data_internacao" value="<?= @$obj->_data_internacao; ?>" />
            </div>
            <div>
                <label>Autorizacao</label>
                <input type="text" id="sisreg" class="texto06" name="sisreg" value="<?= @$obj->_codigo; ?>" />
            </div>

            <div>
                <label>Hospital</label>
                <select  name="unidade" id="unidade" class="size10" >
                    <option value="-1">Selecione</option>
                    <? foreach ($unidade as $item) : ?>
                        <option value="<?= $item->internacao_unidade_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Leito</label>

                <select  name="leito" id="leito" class="size1" >
                    <option value="">Selecione</option>
                </select>
            </div>

            <div>
                <label>Carater</label>
                <select name="carater" id="carater" class="size04" selected="<?= @$obj->_carater; ?>">
                    <option value=Selecione <?
                    if (@$obj->_tipo == 'Selecione'):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value=Enteral <?
                    if (@$obj->_tipo == 'Enteral'):echo 'selected';
                    endif;
                    ?>>Enteral</option>
                    <option value=Parenteral <?
                    if (@$obj->_tipo == 'Parenteral'):echo 'selected';
                    endif;
                    ?>>Parenteral</option>

                </select>
            </div>
            <div>
                <label>Diagnostico</label>
                <input type="hidden" id="txtprocedimentoID" class="texto_id" name="procedimentoID" value="<?= @$obj->_procedimento; ?>" />
                <input type="text" id="txtprocedimento" class="texto10" name="txtprocedimento" value="<?= @$obj->_procedimento_nome; ?>" />
            </div>
            <div>
                <label>CID principal</label>
                <input type="hidden" id="txtcid1ID" class="texto_id" name="cid1ID" value="<?= @$obj->_cid1; ?>" />
                <input type="text" id="txtcid1" class="texto10" name="txtcid1" value="<?= @$obj->_cid1_nome; ?>" />
            </div>
            <div>
                <label>Solicitante</label>
                <input type="text" id="solicitante" class="texto06" name="solicitante" value="<?= @$obj->_solicitante; ?>" />
            </div>
            <div>
                <label>Reg</label>
                <input type="text" id="reg" class="texto02" name="reg" value="<?= @$obj->_reg; ?>" />
            </div>
            <div>
                <label>Val</label>
                <input type="text" id="val" class="texto02" name="val" value="<?= @$obj->_val; ?>" />
            </div>
            <div>
                <label>Pla</label>
                <input type="text" id="pla" class="texto02" name="pla" value="<?= @$obj->_pla; ?>" />
            </div>
            <div>
                <label>Rx</label>
                <select name="rx" id="rx" class="size04" selected="<?= @$obj->_rx; ?>">
                    <option value=Selecione <?
                    if (@$obj->_tipo == 'Selecione'):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value=Sim <?
                    if (@$obj->_tipo == 'Sim'):echo 'selected';
                    endif;
                    ?>>Sim</option>
                    <option value=Nao <?
                    if (@$obj->_tipo == 'Nao'):echo 'selected';
                    endif;
                    ?>>Nao</option>

                </select>
            </div>
            <div>
                <label>Acesso Duplo l&uacute;men</label>
                <select name="acesso" id="acesso" class="size04" selected="<?= @$obj->_acesso; ?>">
                    <option value=Selecione <?
                    if (@$obj->_tipo == 'Selecione'):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value=Sim <?
                    if (@$obj->_tipo == 'Sim'):echo 'selected';
                    endif;
                    ?>>Sim</option>
                    <option value=Nao <?
                    if (@$obj->_tipo == 'Nao'):echo 'selected';
                    endif;
                    ?>>Nao</option>

                </select>
            </div>

            <div>
                <label>Justificativa</label>
                <textarea cols="" rows="" name="observacao" id="txtobservacao" class="texto_area" value="<?= @$obj->_data_internacao; ?>"></textarea><br/>
            </div>
        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">



                    $(function() {
                        $("#data_solicitacao").datepicker({
                            autosize: true,
                            changeYear: true,
                            changeMonth: true,
                            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                            buttonImage: '<?= base_url() ?>img/form/date.png',
                            dateFormat: 'dd/mm/yy'
                        });
                    });

                    $(function() {
                        $("#data_internacao").datepicker({
                            autosize: true,
                            changeYear: true,
                            changeMonth: true,
                            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                            buttonImage: '<?= base_url() ?>img/form/date.png',
                            dateFormat: 'dd/mm/yy'
                        });
                    });


                    $(function() {
                        $('#unidade').change(function() {
                            if ($(this).val()) {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/unidadeleito', {unidade: $(this).val(), ajax: true}, function(j) {
                                    options = '<option value=""></option>';
                                    for (var c = 0; c < j.length; c++) {
                                        options += '<option value="' + j[c].internacao_leito_id + '">' + j[c].nome + '</option>';
                                    }
                                    $('#leito').html(options).show();
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#leito').html('<option value="">Selecione</option>');
                            }
                        });
                    });

                    $(function() {
                        $("#txtoperador").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=operador",
                            minLength: 2,
                            focus: function(event, ui) {
                                $("#txtoperador").val(ui.item.label);
                                return false;
                            },
                            select: function(event, ui) {
                                $("#txtoperador").val(ui.item.value);
                                $("#txtoperadorID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(function() {
                        $("#txtprocedimento").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimento",
                            minLength: 2,
                            focus: function(event, ui) {
                                $("#txtprocedimento").val(ui.item.label);
                                return false;
                            },
                            select: function(event, ui) {
                                $("#txtprocedimento").val(ui.item.value);
                                $("#txtprocedimentoID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(function() {
                        $("#txtcid1").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
                            minLength: 2,
                            focus: function(event, ui) {
                                $("#txtcid1").val(ui.item.label);
                                return false;
                            },
                            select: function(event, ui) {
                                $("#txtcid1").val(ui.item.value);
                                $("#txtcid1ID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(function() {
                        $("#txtcid2").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid2",
                            minLength: 2,
                            focus: function(event, ui) {
                                $("#txtcid2").val(ui.item.label);
                                return false;
                            },
                            select: function(event, ui) {
                                $("#txtcid2").val(ui.item.value);
                                $("#txtcid2ID").val(ui.item.id);
                                return false;
                            }
                        });
                    });



                    $(document).ready(function() {
                        jQuery('#form_unidade').validate({
                            rules: {
                                aih: {
                                    required: true,
                                    minlength: 3
                                },
                                data_solicitacao: {
                                    required: true
                                }

                            },
                            messages: {
                                aih: {
                                    required: "*",
                                    minlength: "*"
                                },
                                data_solicitacao: {
                                    required: "*"
                                }
                            }
                        });
                    });



</script>