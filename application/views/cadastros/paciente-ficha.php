<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar" method="post">
        <!--        Chamando o Script para a Webcam   -->
        <script src="<?= base_url() ?>js/webcam.js"></script>
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome*</label>                      
                <input type ="hidden" name ="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId">
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" required="true" />
            </div>
            <div>
                <label>Nascimento*</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" onblur="calculoIdade()"
                       <?= (@$empresaPermissao[0]->campos_obrigatorios_pac_nascimento == 't') ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade2" id="idade2" class="texto02" readonly/>
            </div>


            <div>
                <label>Nome da M&atilde;e</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto06" value="<?= @$obj->_nomemae; ?>" />
            </div>
            <div>
                <label>Nome do Pai</label>
                <input type="text"  name="nome_pai" id="txtNomePai" class="texto06" value="<?= @$obj->_nomepai; ?>" />
            </div>
            <div>
                <label>Email</label>
                <input type="text" id="txtCns" name="cns"  class="texto06" value="<?= @$obj->_cns; ?>" />
            </div>
            <div>
                <label>Sexo</label>
                <select name="sexo" id="txtSexo" class="size1" <?= (@$empresaPermissao[0]->campos_obrigatorios_pac_sexo == 't') ? 'required' : '' ?>>
                    <option value="" <?
                    if (@$obj->_sexo == ""):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value="M" <?
                    if (@$obj->_sexo == "M"):echo 'selected';
                    endif;
                    ?>>Masculino</option>
                    <option value="F" <?
                    if (@$obj->_sexo == "F"):echo 'selected';
                    endif;
                    ?>>Feminino</option>
                </select>

            </div>

            <div>
                <legend>Foto</legend>

                <!-- A Imagem do Paciente-->
                <img src="<?= base_url() ?>upload/webcam/pacientes/<?= @$obj->_paciente_id ?>.jpg" alt="" height="140" width="100"  />
            </div>
        </fieldset>
        <fieldset>
            <legend>Documentos</legend>
            <div>
                <label>CPF</label>


                <input type="text" <? if ($empresapermissoes[0]->cpf_obrigatorio == 't') { ?>required <? } ?> name="cpf" id ="txtCpf" maxlength="11" alt="cpf" class="texto02" value="<?= @$obj->_cpf; ?>" <?= (@$empresaPermissao[0]->campos_obrigatorios_pac_cpf == 't') ? 'required' : '' ?>/>
            </div>
            <div>
                <label>RG</label>


                <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>" />
            </div>
            <!--            <div>
                            <label>UF Expedidor</label>
            
            
                            <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" maxlength="20" value="<?= @$obj->_uf_rg; ?>"/>
                        </div>
                        <div>
                            <div>
                                <label>Data Emiss&atilde;o</label>
            
            
                                <input type="text" name="data_emissao" id="txtDataEmissao" class="texto02" alt="date" value="<?php echo substr(@$obj->_data_emissao, 8, 2) . '/' . substr(@$obj->_data_emissao, 5, 2) . '/' . substr(@$obj->_data_emissao, 0, 4); ?>" />
                            </div>
            
                            <div>
            
                                <label>T. Eleitor</label>
            
            
                                <input type="text"   name="titulo_eleitor" id="txtTituloEleitor" class="texto02" value="<?= @$obj->_titulo_eleitor; ?>" />
                            </div>-->




        </fieldset>
        <fieldset>
            <legend>Domicilio</legend>

            <div>
                <label>T. logradouro</label>


                <select name="tipo_logradouro" id="txtTipoLogradouro" class="size2" >
                    <option value='' >selecione</option>
                    <?php
                    $listaLogradouro = $this->paciente->listaTipoLogradouro($_GET);
                    foreach ($listaLogradouro as $item) {
                        ?>

                        <option   value =<?php echo $item->tipo_logradouro_id; ?> <?
                        if (@$obj->_tipoLogradouro == $item->tipo_logradouro_id):echo 'selected';
                        endif;
                        ?>><?php echo $item->descricao; ?></option>
                                  <?php
                              }
                              ?> 
                </select>

                <? if ($this->session->userdata('recomendacao_configuravel') != "t") { ?>
                    <label>Indicacao</label>
                    <select name="indicacao" id="indicacao" class="size2" >
                        <option value=''>Selecione</option>
                        <?php
                        $indicacao = $this->paciente->listaindicacao($_GET);
                        foreach ($indicacao as $item) {
                            ?>
                            <option value="<?php echo $item->paciente_indicacao_id; ?>" 
                            <?
                            if (@$obj->_indicacao == $item->paciente_indicacao_id):echo 'selected';
                            endif;
                            ?>>
                                        <?php echo $item->nome; ?>
                            </option>
                            <?php
                        }
                        ?> 
                    </select>
                <? } ?>
            </div>
            <div>
                <label>Endere&ccedil;o</label>
                <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_endereco; ?>" />
            </div>
            <div>
                <label>N&uacute;mero</label>


                <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" />
            </div>
            <div>
                <label>Complemento</label>


                <input type="text" id="txtComplemento" class="texto04" name="complemento" value="<?= @$obj->_complemento; ?>" />
            </div>
            <div>
                <label>Bairro</label>


                <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" />
            </div>


            <div>
                <label>Município</label>


                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" readonly="true" />
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>"  <?= (@$empresaPermissao[0]->campos_obrigatorios_pac_municipio == 't') ? 'required' : '' ?>/>
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep"  value="<?= @$obj->_cep; ?>" />
                <!--<input type="text" id="cep" class="texto02" name="cep"  value="<?= @$obj->_cep; ?>" />-->

            </div>


            <div>
                <label>Telefone 1*</label>
                <?
                if (@$obj->_telefone != '' && strlen(@$obj->_telefone) > 3) {

                    if (preg_match('/\(/', @$obj->_telefone)) {
                        $telefone = @$obj->_telefone;
                    } else {
                        $telefone = "(" . substr(@$obj->_telefone, 0, 2) . ")" . substr(@$obj->_telefone, 2, strlen(@$obj->_telefone) - 2);
                    }
                } else {
                    $telefone = '';
                }
                if (@$obj->_celular != '' && strlen(@$obj->_celular) > 3) {
                    if (preg_match('/\(/', @$obj->_celular)) {
                        $celular = @$obj->_celular;
                    } else {
                        $celular = "(" . substr(@$obj->_celular, 0, 2) . ")" . substr(@$obj->_celular, 2, strlen(@$obj->_celular) - 2);
                    }
                } else {
                    $celular = '';
                }
                if (@$obj->_whatsapp != '' && strlen(@$obj->_whatsapp) > 3) {
                    if (preg_match('/\(/', @$obj->_whatsapp)) {
                        $whatsapp = @$obj->_whatsapp;
                    } else {
                        $whatsapp = "(" . substr(@$obj->_whatsapp, 0, 2) . ")" . substr(@$obj->_whatsapp, 2, strlen(@$obj->_whatsapp) - 2);
                    }
                } else {
                    $whatsapp = '';
                }
                ?>

                <input type="text" id="txtTelefone" class="texto02" name="telefone"  value="<?= @$telefone; ?>" <?= (@$empresaPermissao[0]->campos_obrigatorios_pac_telefone == 't') ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Telefone 2</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" value="<?= @$celular; ?>" />
            </div>
            <div>
                <label>WhatsApp</label>
                <input type="text" id="txtwhatsapp" class="texto02" name="txtwhatsapp" value="<?= @$whatsapp; ?>" />
            </div>

        </fieldset>
        <fieldset>
            <legend>Dados Sociais</legend>
            <div>
                <label>Plano de Saude</label>


                <select name="convenio" id="txtconvenio" class="size2" >
                    <option value='' >selecione</option>
                    <?php
                    $listaconvenio = $this->paciente->listaconvenio($_GET);
                    foreach ($listaconvenio as $item) {
                        ?>

                        <option   value =<?php echo $item->convenio_id; ?> <?
                        if (@$obj->_convenio == $item->convenio_id):echo 'selected';
                        endif;
                        ?>><?php echo $item->descricao; ?></option>
                                  <?php
                              }
                              ?> 
                </select>
            </div>
            <div>
                <label>Leito</label>


                <select name="leito" id="leito" class="size2">
                    <option value='' >Selecione</option>
                    <option value='ENFERMARIA' <? if (@$obj->_leito == 'ENFERMARIA') {
                                  echo 'selected';
                              } ?>>ENFERMARIA</option>
                    <option value='APARTAMENTO'<? if (@$obj->_leito == 'APARTAMENTO') {
                                  echo 'selected';
                              } ?>>APARTAMENTO</option>

                </select>
            </div>
            <div>
                <label>N&uacute;mero</label>


                <input type="text" id="txtconvenionumero" class="texto03" name="convenionumero" value="<?= @$obj->_convenionumero; ?>" />
            </div>
            <div>
                <label>Ocupa&ccedil;&atilde;o</label>
                <input type="hidden" id="txtcboID" class="texto_id" name="txtcboID" value="<?= @$obj->_cbo_ocupacao_id; ?>" readonly="true" />
                <input type="text" id="txtcbo" class="texto04" name="txtcbo" value="<?= @$obj->_cbo_nome; ?>" />
            </div>
            <div>
                <label>Ra&ccedil;a / Cor</label>


                <select name="raca_cor" id="txtRacaCor" class="size2">

                    <option value=0  <?
                    if (@$obj->_raca_cor == 0):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value=1 <?
                    if (@$obj->_raca_cor == 1):echo 'selected';
                    endif;
                    ?>>Branca</option>
                    <option value=2 <?
                    if (@$obj->_raca_cor == 2):echo 'selected';
                    endif;
                    ?>>Amarela</option>
                    <option value=3 <?
                    if (@$obj->_raca_cor == 3):echo 'selected';
                    endif;
                    ?>>Preta</option>
                    <option value=4 <?
                    if (@$obj->_raca_cor == 4):echo 'selected';
                    endif;
                    ?>>Parda</option>
                    <option value=5 <?
                            if (@$obj->_raca_cor == 5):echo 'selected';
                            endif;
                    ?>>Ind&iacute;gena</option>
                </select>
            </div>
            <div>
                <label>Estado civil</label>


                <select name="estado_civil_id" id="txtEstadoCivil" class="size2" selected="<?= @$obj->_estado_civil; ?>">
                    <option value=0 <?
                    if (@$obj->_estado_civil == 0):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value=1 <?
                    if (@$obj->_estado_civil == 1):echo 'selected';
                    endif;
                    ?>>Solteiro</option>
                    <option value=2 <?
                    if (@$obj->_estado_civil == 2):echo 'selected';
                    endif;
                    ?>>Casado</option>
                    <option value=3 <?
                    if (@$obj->_estado_civil == 3):echo 'selected';
                    endif;
                    ?>>Divorciado</option>
                    <option value=4 <?
                    if (@$obj->_estado_civil == 4):echo 'selected';
                    endif;
                    ?>>Viuvo</option>
                    <option value=5 <?
                            if (@$obj->_estado_civil == 5):echo 'selected';
                            endif;
                    ?>>Outros</option>
                </select>
            </div>
            <div>
                <label>Escolaridade</label>

                <select name="escolaridade" id="escolaridade" class="size2" selected="<?= @$obj->_escolaridade_id; ?>">
                    <option value=0 <?
                    if (@$obj->_escolaridade_id == 0):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value=1 <?
                    if (@$obj->_escolaridade_id == 1):echo 'selected';
                    endif;
                    ?>>Fundamental-Incompleto </option>
                    <option value=2 <?
                            if (@$obj->_escolaridade_id == 2):echo 'selected';
                            endif;
                    ?>>Fundamental-Completo</option>

                    <option value=3 <?
                    if (@$obj->_escolaridade_id == 3):echo 'selected';
                    endif;
                    ?>>Médio 
                        -
                        Incompleto</option>
                    <option value=4 <?
                    if (@$obj->_escolaridade_id == 4):echo 'selected';
                    endif;
                    ?>>Médio 
                        -
                        Completo
                    </option>
                    <option value=5 <?
                    if (@$obj->_escolaridade_id == 5):echo 'selected';
                    endif;
                    ?>>Superior 
                        -
                        Incompleto</option>
                    <option value=6 <?
                    if (@$obj->_escolaridade_id == 6):echo 'selected';
                    endif;
                    ?>>Superior-Completo </option>


                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>Fotografia</legend>

            <label>Câmera</label>
            <input id="mydata" type="hidden" name="mydata" value=""/>
            <div id="my_camera"></div>
            <div></div>
            <div><input type=button value="Ativar Câmera" onClick="ativar_camera()">
                <input type=button value="Tirar Foto" onClick="take_snapshot()"></div>

            <div id="results">A imagem capturada aparece aqui...</div>

        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>

        <a href="<?= base_url() ?>cadastros/pacientes">
            <button type="button" id="btnVoltar">Voltar</button>
        </a>

    </form>


    <script language="JavaScript">
        Webcam.set({
            width: 140,
            height: 160,
            dest_width: 480,
            dest_height: 360,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        function ativar_camera() {
            Webcam.attach('#my_camera');
        }
        function take_snapshot() {
            // tira a foto e gera uma imagem para a div
            Webcam.snap(function (data_uri) {
                // display results in page
                document.getElementById('results').innerHTML =
                        '<img height = "160" width = "140" src="' + data_uri + '"/>';
                //              Gera uma variável com o código binário em base 64 e joga numa variável
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                //              Pega o valor do campo mydata, campo hidden que armazena temporariamente o código da imagem
                document.getElementById('mydata').value = raw_image_data;

            });
        }



    </script>

</div>



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

                if (code > 57 || (code < 48 && code != 8 && code != 0)) {
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
//    mascaraTelefone(form_paciente.txtTelefone);
//    mascaraTelefone(form_paciente.txtwhatsapp);
//    mascaraTelefone(form_paciente.txtCelular);
    jQuery("#txtwhatsapp")
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
//(99) 9999-9999


    $(function () {
        $("#txtcbo").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cboprofissionais",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtcbo").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtcbo").val(ui.item.value);
                $("#txtcboID").val(ui.item.id);
                return false;
            }
        });
    });


    $(function () {
        $('#txtconvenio').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $(this).val()}, function (j) {
                    options = '<option value=""></option>';
                    if (j[0].carteira_obrigatoria == 't') {
                        $("#txtconvenionumero").prop('required', true);
                    } else {
                        $("#txtconvenionumero").prop('required', false);
                    }

                });
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
        $("#txtEstado").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=estado",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtEstado").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtEstado").val(ui.item.value);
                $("#txtEstadoID").val(ui.item.id);
                return false;
            }
        });
    });



    $(function () {
        $("#cep").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cep",
            minLength: 3,
            focus: function (event, ui) {
                $("#cep").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#cep").val(ui.item.cep);
                $("#txtendereco").val(ui.item.logradouro_nome);
                $("#txtBairro").val(ui.item.nome_bairro);
//                        $("#txtCidade").val(ui.item.localidade_nome);
                $("#txtTipoLogradouro").val(ui.item.tipo_logradouro);

                return false;
            }
        });
    });
    
    function calculoIdade() {
        var data = document.getElementById("txtNascimento").value;
        
        if ( data != '' && data != '//' ) {
            
            var ano = data.substring(6, 12);
            var idade = new Date().getFullYear() - ano;

            var dtAtual = new Date();
            var aniversario = new Date(dtAtual.getFullYear(), data.substring(3, 5), data.substring(0, 2));

            if ( dtAtual < aniversario ) {
                idade--;
            }

            document.getElementById("idade2").value = idade + " ano(s)";
        }
    }
    calculoIdade();

</script>
