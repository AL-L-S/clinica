<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Internação</h3>
    <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarinternacao/<?= $paciente_id; ?>" method="post">
        <fieldset>
            <legend>Dados do Pacienete</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                <input type="hidden" id="txtNome" name="internacao_id"  class="texto09" value="<?= @$internacao['0']->internacao_id; ?>" readonly/>
                <input type="hidden" id="txtNome" name="internacao_ficha_id"  class="texto09" value="<?= $internacao_ficha_id; ?>" readonly/>
            </div>
            <div>
                <label>Nascimento</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php
                if ($paciente['0']->nascimento != '') {
                    echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4);
                }
                ?>" onblur="retornaIdade()" readonly/>
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
            <legend>Dados do Responsável</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome_responsavel"  class="texto09" value="<?= (@$internacao[0]->nome_responsavel != '') ? @$internacao[0]->nome_responsavel : @$precadastro[0]->nome; ?>"/>
            </div>
            <div>
                <label>CPF</label>
                <input type="text" name="cpf_responsavel" alt="cpf" id="cpf_responsavel" class="texto03" value="<?= @$internacao[0]->cpf_responsavel; ?>"/>
            </div>
            <div>
                <label>RG</label>
                <input type="text" name="rg_responsavel" id="rg_responsavel" class="texto04"  value="<?= @$internacao[0]->rg_responsavel; ?>"/>
            </div>
            <div>
                <label>Grau Parentesco</label>
                <input type="text" name="grau_parentesco" id="grau_parentesco" class="texto04"  value="<?= (@$internacao[0]->grau_parentesco != '') ? @$internacao[0]->grau_parentesco : @$precadastro[0]->grau_parentesco; ?>"/>
            </div>
            <div>
                <label>Ocupação</label>
                <input type="text" name="ocupacao_responsavel" id="grau_parentesco" class="texto04"  value="<?= (@$internacao[0]->ocupacao_responsavel != '') ? @$internacao[0]->ocupacao_responsavel : @$precadastro[0]->ocupacao_responsavel; ?>"/>
            </div>

            <div>
                <label>Endere&ccedil;o</label>
                <input type="text" id="txtendereco" class="texto10" name="logradouro_responsavel"  value="<?= @$internacao[0]->logradouro_responsavel; ?>"/>
            </div>
            <div>
                <label>N&uacute;mero</label>


                <input type="text" id="txtNumero" class="texto02" name="numero_responsavel" value="<?= @$internacao[0]->numero_responsavel; ?>"/>
            </div>

            <div>
                <label>Bairro</label>


                <input type="text" id="txtBairro" class="texto03" name="bairro_responsavel" value="<?= @$internacao[0]->bairro_responsavel; ?>"/>
            </div>


            <div>
                <label>Município</label>


                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_responsavel_id"  readonly="true" value="<?= @$internacao[0]->municipio_responsavel_id; ?>"/>
                <input type="text" id="txtCidade" class="texto04" name="cidade_responsavel" value="<?= @$internacao[0]->cidade_responsavel; ?>"/>
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep_responsavel" value="<?= @$internacao[0]->cep_responsavel; ?>"/>
                <!--<input type="text" id="cep" class="texto02" name="cep"  value="<?= @$internacao[0]->cep; ?>" />-->

            </div>


            <div>
                <label>Telefone </label>


                <input type="text" id="telefone_responsavel" class="texto02" name="telefone_responsavel"  value="<?= @$internacao[0]->telefone_responsavel; ?>"/>
            </div>
            <div>
                <label>Celular </label>
                <input type="text" id="celular_responsavel" class="texto02" name="celular_responsavel" value="<?= @$internacao[0]->celular_responsavel; ?>"/>
            </div>
            <div>
                <label>Email</label>
                <input type="text" id="email_responsavel" class="texto05" name="email_responsavel" value="<?= @$internacao[0]->email_responsavel; ?>" />
            </div>


        </fieldset>
        <fieldset>
            
            <legend>Dependência</legend>
            <? $dependencia = $this->internacao_m->listartipodependenciaquestionario(); ?>
            <div>
                <label>Tipo de Dependência Química</label>                      
                <select name="tipo_dependencia[]" id="tipo_dependencia" class="texto05 chosen-select" data-placeholder="Selecione as Dependências..." multiple >
                    <option value=''>Selecione</option>
                    <?php
                    if(count($precadastro) > 0){
                        @$tipo_json = json_decode(@$precadastro[0]->tipo_dependencia);
                    }else{
                        @$tipo_json = array();
                    }
                    if(count($internacao) > 0){
                        @$tipo_inter_json = json_decode(@$internacao[0]->tipo_dependencia);
                    }else{
                        @$tipo_inter_json = array();
                    }
                    foreach ($dependencia as $item) {
                        ?>
                        <option value="<?php echo $item->internacao_tipo_dependencia_id; ?>" 
                        <?
                        if (in_array($item->internacao_tipo_dependencia_id,$tipo_json) || in_array($item->internacao_tipo_dependencia_id, $tipo_inter_json)) {
                            echo 'selected';
                        }
                        ?>>
                                    <?php echo $item->nome; ?>           
                        </option>
                        <?php
                    }
                    ?> 
                </select>
            </div>
            <div>
                <label>Idade de Inicio</label>                      
                <input type="number" id="idade_inicio" name="idade_inicio"  class="texto02" value="<?= (@$internacao[0]->idade_inicio != '') ? @$internacao[0]->idade_inicio : @$precadastro[0]->idade_inicio; ?>"/>
            </div>
        </fieldset>

        <fieldset>
            <legend>Dados da internacao</legend>
            <div>
                <label>Leito</label>
                <input type="hidden" id="txtinternacao_id" name="internacao_id"  class="texto01" value="<?= @$internacao[0]->internacao_id; ?>" readonly/>
                <input type="hidden" id="txtleitoID" class="texto_id" name="leitoID" value="<?= @$internacao[0]->internacao_leito_id; ?>" />
                <input type="text" id="txtleito" class="texto10" name="txtleito" value="<?= (@$internacao[0]->leito != '') ? @$internacao[0]->leito . ' - ' . @$internacao[0]->enfermaria . ' - ' . @$internacao[0]->unidade : ''; ?>" required/>
            </div>
            <!--<br>-->
            <!--<br>-->

            <div>
                <label>Autorizacao Sisreg</label>
                <input type="text" id="txtsisreg" class="texto06" name="sisreg" value="<?= @$internacao[0]->codigo; ?>" />
            </div>
            <div>
                <label>AIH</label>
                <input type="text" id="txtaih" class="texto06" maxlength="9" name="aih" value="<?= @$internacao[0]->aih; ?>" />
            </div>
            <div>
                <label>Autorizacao central</label>
                <input type="text" id="txtcentral" class="texto06" name="central" value="<?= @$internacao[0]->prelaudo; ?>" />
            </div>
            <div>
                <label>Senha</label>
                <input type="text" id="senha" class="texto06" name="senha" value="<?= @$internacao[0]->senha; ?>" />
            </div>
            <div>
                <label>Medico</label>
                <select name="operadorID" id="txtoperadorID" class="texto08" selected="<?= @$internacao[0]->forma_de_entrada; ?>" required>
                    <option value="">Selecione</option>   
                    <? foreach ($medicos as $item) { ?>
                        <option value="<?= $item->operador_id ?>" <?
                        if ($item->operador_id == @$internacao[0]->medico_id) {
                            echo 'selected';
                        }
                        ?>><?= $item->nome ?></option>   
                            <? }
                            ?>




                </select>

                <!--<input type="hidden" id="txtoperadorID" class="texto_id" name="operadorID" value="<?= @$internacao[0]->operador; ?>" />-->
                <!--<input type="text"  id="txtoperador" class="texto06" name="txtoperador" value="<?= @$internacao[0]->operador_nome; ?>" required/>-->
            </div>
            <div>
                <label>Data/hora ex.( 20/01/2010 14:30:21)</label>
                <input type="text" required id="txtdata" class="texto08" name="data" alt="39/19/9999 29:59:59" value="<?= (@$internacao[0]->data_internacao != '') ? date("d/m/Y H:i:s", strtotime(@$internacao[0]->data_internacao)) : ''; ?>" />
            </div>
            <div>
                <label>Forma de entrada</label>
                <select name="forma" id="txtforma" class="texto08" selected="<?= @$internacao[0]->forma_de_entrada; ?>" required>
                    <option value="">Selecione</option>
                    <option value=Residencia <?
                    if (@$internacao[0]->forma_de_entrada == 'Residencia'):echo 'selected';
                    endif;
                    ?>>Residencia</option>
                    <option value=Transferido <?
                    if (@$internacao[0]->forma_de_entrada == 'Transferido'):echo 'selected';
                    endif;
                    ?>>Transferido</option>
                    <option value=Emergencia <?
                    if (@$internacao[0]->forma_de_entrada == 'Emergencia'):echo 'selected';
                    endif;
                    ?>>Emergencia</option>
                    <option value=Ambulatorio <?
                    if (@$internacao[0]->forma_de_entrada == 'Ambulatorio'):echo 'selected';
                    endif;
                    ?>>Ambulatorio</option>
                </select>
            </div>
            <div>
                <label>Estado</label>
                <select name="estado" id="txtEstado" class="size04" selected="<?= @$internacao[0]->tipo; ?>" required>
                    <option value="">Selecione</option>
                    <option value=Bom <?
                    if (@$internacao[0]->estado == 'Bom'):echo 'selected';
                    endif;
                    ?>>Bom</option>
                    <option value=Regular <?
                    if (@$internacao[0]->estado == 'Regular'):echo 'selected';
                    endif;
                    ?>>Regular</option>
                    <option value=Grave <?
                    if (@$internacao[0]->estado == 'Grave'):echo 'selected';
                    endif;
                    ?>>Grave</option>
                </select>
            </div>
            <div>
                <label>Carater</label>
                <select name="carater" id="txtcarater" class="size04" selected="<?= @$internacao[0]->carater; ?>" required>
                    <option value="">Selecione</option>
                    <option value=Eletiva <?
                    if (@$internacao[0]->carater_internacao == 'Eletiva'):echo 'selected';
                    endif;
                    ?>>Eletiva</option>
                    <option value=Normal <?
                    if (@$internacao[0]->carater_internacao == 'Normal'):echo 'selected';
                    endif;
                    ?>>Normal</option>
                    <option value=Emergencia <?
                    if (@$internacao[0]->carater_internacao == 'Emergencia'):echo 'selected';
                    endif;
                    ?>>Emergencia</option>
                </select>
            </div>

            <div>
                <label>Convênio</label>
                <select  name="convenio1" id="convenio1" class="size2" required="" >
                    <option value="">Selecione</option>
                    <?
                    foreach ($convenio as $item) :
                        ?>
                        <option value="<?= $item->convenio_id; ?>" <? if (@$internacao[0]->convenio_id == $item->convenio_id) echo 'selected'; ?>>
                            <?= $item->nome; ?>
                        </option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select name="procedimento1" id="procedimento1" class="size4" data-placeholder="Selecione" tabindex="1" required="">
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>CID principal</label>
                <input type="hidden" id="txtcid1ID" class="texto_id" name="cid1ID" value="<?= @$internacao[0]->co_cid; ?>" />
                <input type="text" id="txtcid1" class="texto10" name="txtcid1" value="<?= @$internacao[0]->no_cid; ?>" required/>
            </div>
            <div>
                <label>CID secundario</label>
                <input type="hidden" id="txtcid2ID" class="texto_id" name="cid2ID" value="<?= @$internacao[0]->co_cid2; ?>" />
                <input type="text" id="txtcid2" class="texto10" name="txtcid2" value="<?= @$internacao[0]->no_cid2; ?>" />
            </div>
            <div>
                <label>Justificativa</label>
                <textarea cols="" rows="" name="observacao" id="txtobservacao" class="texto_area" value="<?= @$internacao[0]->data_internacao; ?>"></textarea><br/>
            </div>
        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

                    jQuery("#celular_responsavel")
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

                    jQuery("#telefone_responsavel")
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
                    $(document).ready(function () {

                        function limpa_formulário_cep() {
                            // Limpa valores do formulário de cep.

                        }
                        $("#cep").mask("99999-999");
                        //Quando o campo cep perde o foco.
                        $("#cep").blur(function () {

                            //Nova variável "cep" somente com dígitos.
                            var cep = $(this).val().replace(/\D/g, '');

                            //Verifica se campo cep possui valor informado.
                            if (cep != "") {

                                //Expressão regular para validar o CEP.
                                var validacep = /^[0-9]{8}$/;

                                //Valida o formato do CEP.
                                if (validacep.test(cep)) {

                                    //Preenche os campos com "..." enquanto consulta webservice.
//                    $("#rua").val("Aguarde...");
//                    $("#bairro").val("Aguarde...");
//                    $("#txtCidade").val("Aguarde...");
//                    $("#uf").val("Aguarde...");

                                    //Consulta o webservice viacep.com.br/
                                    $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                                        if (!("erro" in dados)) {
                                            //Atualiza os campos com os valores da consulta.
                                            $("#txtendereco").val(dados.logradouro);
                                            $("#txtBairro").val(dados.bairro);
                                            $("#txtCidade").val(dados.localidade);
//                            $("#uf").val(dados.uf);
                                            $("#ibge").val(dados.ibge);
                                            $.getJSON('<?= base_url() ?>autocomplete/cidadeibge', {ibge: dados.ibge}, function (j) {
                                                $("#txtCidade").val(j[0].value);
                                                $("#txtCidadeID").val(j[0].id);

//                                console.log(j);
                                            });
//                            console.log(dados);
//                            console.log(dados.bairro);

                                        } //end if.
                                        else {
                                            //CEP pesquisado não foi encontrado.
//                            limpa_formulário_cep();
                                            alert("CEP não encontrado.");

//                            swal({
//                                title: "Correios informa!",
//                                text: "CEP não encontrado.",
//                                imageUrl: "<?= base_url() ?>img/correios.png"
//                            });
                                        }
                                    });

                                } //end if.
                                else {
                                    //cep é inválido.
                                    limpa_formulário_cep();
//                    alert("Formato de CEP inválido.");
                                    swal({
                                        title: "Correios informa!",
                                        text: "Formato de CEP inválido.",
                                        imageUrl: "<?= base_url() ?>img/correios.png"
                                    });
                                }
                            } //end if.
                            else {
                                //cep sem valor, limpa formulário.
                                limpa_formulário_cep();
                            }
                        });
                    });

<? if (@$internacao[0]->procedimento_convenio_id) { ?>
                        var procedimento_atual = <?= @$internacao[0]->procedimento_convenio_id ?>;
<? } else { ?>
                        var procedimento_atual = 0;
<? } ?>

                    $(function () {
                        $('#convenio1').change(function () {
                            if ($(this).val()) {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos', {convenio1: $(this).val()}, function (j) {
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

                            } else {
                                $('#procedimento1').html('<option value="">Selecione</option>');
                            }
                        });
                    });



                    if ($('#convenio1').val() > 0) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniotodos', {convenio1: $('#convenio1').val()}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                if (procedimento_atual == j[c].procedimento_convenio_id) {
                                    options += '<option selected value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                } else {
                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                }

                            }
//                                                    $('#procedimento1').html(options).show();

                            $('#procedimento1 option').remove();
                            $('#procedimento1').append(options);
                            $("#procedimento1").trigger("chosen:updated");
                            $('.carregando').hide();
                        });

                    }

                    $(function () {
                        $("#txtleito").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=leito",
                            minLength: 2,
                            focus: function (event, ui) {
                                $("#txtleito").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $("#txtleito").val(ui.item.value);
                                $("#txtleitoID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(function () {
                        $("#txtCidade").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
                            minLength: 3,
                            focus: function (event, ui) {
                                $("#txtCidade").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $("#txtCidade").val(ui.item.value);
                                $("#txtCidadeID").val(ui.item.id);
                                return false;
                            }
                        });
                    });



                    $(function () {
                        $("#txtoperador").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=operador",
                            minLength: 2,
                            focus: function (event, ui) {
                                $("#txtoperador").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $("#txtoperador").val(ui.item.value);
                                $("#txtoperadorID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(function () {
                        $("#txtprocedimento").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=listarprocedimentointernacaoautocomplete",
                            minLength: 2,
                            focus: function (event, ui) {
                                $("#txtprocedimento").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $("#txtprocedimento").val(ui.item.value);
                                $("#txtprocedimentoID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(function () {
                        $("#txtcid1").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
                            minLength: 2,
                            focus: function (event, ui) {
                                $("#txtcid1").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $("#txtcid1").val(ui.item.value);
                                $("#txtcid1ID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(function () {
                        $("#txtcid2").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid2",
                            minLength: 2,
                            focus: function (event, ui) {
                                $("#txtcid2").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $("#txtcid2").val(ui.item.value);
                                $("#txtcid2ID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(document).ready(function () {
                        jQuery('#form_paciente').validate({
                            rules: {
                                nome: {
                                    required: true,
                                    minlength: 3
                                },
                                endereco: {
                                    required: true
                                },
                                cep: {
                                    required: true
                                },
                                cns: {
                                    maxLength: 15
                                }, rg: {
                                    maxLength: 20
                                }

                            },
                            messages: {
                                nome: {
                                    required: "*",
                                    minlength: "*"
                                },
                                endereco: {
                                    required: "*"
                                },
                                cep: {
                                    required: "*"
                                },
                                cns: {
                                    required: "Tamanho m&acute;ximo do campo CNS é de 15 caracteres"
                                },
                                rg: {
                                    maxlength: "Tamanho m&acute;ximo do campo RG é de 20 caracteres"
                                }
                            }
                        });
                    });




</script>