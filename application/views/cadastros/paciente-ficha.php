<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar" method="post">
        <!--        Chamando o Script para a Webcam   -->
        <script src="<?= base_url() ?>js/webcam.js"></script>
        <fieldset>
            <?
            if (@$empresapermissoes[0]->campos_cadastro != '') {
                $campos_obrigatorios = json_decode(@$empresapermissoes[0]->campos_cadastro);
            } else {
                $campos_obrigatorios = array();
            }

//            var_dump(); die;
            ?>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome*</label>                      
                <input type ="hidden" name ="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId">
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" required="true" />
            </div>
            <div>
                <label>Nascimento*</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" onblur="calculoIdade()"
                       <?= (in_array('nascimento', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade2" id="idade2" class="texto02" readonly/>
            </div>


            <div>
                <label>Nome da M&atilde;e</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto06" value="<?= @$obj->_nomemae; ?>" 
                       <?= (in_array('nome_mae', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Nome do Pai</label>
                <input type="text"  name="nome_pai" id="txtNomePai" class="texto06" value="<?= @$obj->_nomepai; ?>" 
                       <?= (in_array('nome_pai', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <?
//            var_dump(@$empresapermissoes); die;
            ?>
            <? if (@$empresapermissoes[0]->conjuge == 't') { ?>

                <div>
                    <label>Nome do Cônjuge</label>
                    <input type="text"  name="nome_conjuge" id="nome_conjuge" class="texto06" value="<?= @$obj->_nome_conjuge; ?>" 
                           <?= (in_array('nome_conjuge', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>
                <div>
                    <label>Nascimento do Cônjuge</label>
                    <input type="text" name="nascimento_conjuge" id="nascimento_conjuge" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento_conjuge, 8, 2) . '/' . substr(@$obj->_nascimento_conjuge, 5, 2) . '/' . substr(@$obj->_nascimento_conjuge, 0, 4); ?>" 
                           <?= (in_array('nascimento_conjuge', $campos_obrigatorios)) ? 'required' : '' ?>/>

                </div>
            <? } ?>
            <div>
                <label>Email</label>
                <input type="text" id="txtCns" name="cns"  class="texto06" value="<?= @$obj->_cns; ?>" 
                       <?= (in_array('email', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Sexo</label>
                <select name="sexo" id="txtSexo" class="size1" <?= (in_array('nascimento', $campos_obrigatorios)) ? 'required' : '' ?>>
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
                    <option value="O" <?
                    if (@$obj->_sexo == "O"):echo 'selected';
                    endif;
                       ?>>Outro</option>
                </select>

            </div>
            <div id="sexo_real_div" style="display: none;">
                <label>Sexo Biológico</label>
                <select name="sexo_real" id="sexo_real" class="size1">
                    <option value="" <?
                    if (@$obj->_sexo_real == ""):echo 'selected';
                    endif;
                       ?>>Selecione</option>
                    <option value="M" <?
                    if (@$obj->_sexo_real == "M"):echo 'selected';
                    endif;
                       ?>>Masculino</option>
                    <option value="F" <?
                    if (@$obj->_sexo_real == "F"):echo 'selected';
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


                <input type="text" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> name="cpf" id ="txtCpf" maxlength="11" alt="cpf" class="texto02" value="<?= @$obj->_cpf; ?>" />
            </div>
            <div id="cpf_responsavel_label">
                <label>CPF Responsável</label>


                <input type="text" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> name="cpf_responsavel" id ="cpf_responsavel" maxlength="11" alt="cpf" class="texto02" value="<?= @$obj->_cpf_responsavel; ?>"/>
            </div>
            <div>
                <label>RG</label>


                <input type="text" name="rg" <?= (in_array('rg', $campos_obrigatorios)) ? 'required' : '' ?>  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>" />
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


                <select name="tipo_logradouro" id="txtTipoLogradouro" class="size2" <?= (in_array('logradouro', $campos_obrigatorios)) ? 'required' : '' ?>>
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
                    <select name="indicacao" id="indicacao" class="size2" <?= (in_array('indicacao', $campos_obrigatorios)) ? 'required' : '' ?>>
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
                <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_endereco; ?>" <?= (in_array('endereco', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>N&uacute;mero</label>


                <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" <?= (in_array('numero', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Complemento</label>


                <input type="text" id="txtComplemento" class="texto04" name="complemento" value="<?= @$obj->_complemento; ?>" <?= (in_array('complemento', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Bairro</label>


                <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" <?= (in_array('bairro', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>


            <div>
                <label>Município</label>


                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" readonly="true" />
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>"  <?= (in_array('municipio', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep"  value="<?= @$obj->_cep; ?>" <?= (in_array('cep', $campos_obrigatorios)) ? 'required' : '' ?>/>
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

                <input type="text" id="txtTelefone" class="texto02" name="telefone"  value="<?= @$telefone; ?>" <?= (in_array('telefone1', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Telefone 2</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" value="<?= @$celular; ?>" <?= (in_array('telefone2', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>WhatsApp</label>
                <input type="text" id="txtwhatsapp" class="texto02" name="txtwhatsapp" value="<?= @$whatsapp; ?>" <?= (in_array('whatsapp', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>

        </fieldset>
        <fieldset>
            <legend>Dados Sociais</legend>
            <div>
                <label>Plano de Saude</label>


                <select name="convenio" id="txtconvenio" class="size2" <?= (in_array('plano_saude', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value='' >selecione</option>
                    <?php
                    $listaconvenio = $this->paciente->listaconvenio($_GET);
                    foreach ($listaconvenio as $item) {
                        ?>

                        <option   value =<?php echo $item->convenio_id; ?> <?
                    if (@$obj->_convenio == $item->convenio_id):echo 'selected';
                    endif;
                        ?>><?php echo $item->nome; ?></option>
                                  <?php
                              }
                              ?> 
                </select>
            </div>
            <div>
                <label>Leito</label>


                <select name="leito" id="leito" class="size2" <?= (in_array('leito', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value='' >Selecione</option>
                    <option value='ENFERMARIA' <?
                              if (@$obj->_leito == 'ENFERMARIA') {
                                  echo 'selected';
                              }
                              ?>>ENFERMARIA</option>
                    <option value='APARTAMENTO'<?
                    if (@$obj->_leito == 'APARTAMENTO') {
                        echo 'selected';
                    }
                              ?>>APARTAMENTO</option>

                </select>
            </div>
            <div>
                <label>N&uacute;mero</label>


                <input type="text" id="txtconvenionumero" class="texto03" name="convenionumero" value="<?= @$obj->_convenionumero; ?>" <?= (in_array('numero_carteira', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Vencimento Carteira</label>


                <input type="text" id="vencimento_carteira" class="texto03" name="vencimento_carteira" value="<?
                    if (@$obj->_vencimento_carteira != '') {
                        echo date("d/m/Y", strtotime(@$obj->_vencimento_carteira));
                    }
                              ?>" <?= (in_array('vencimento_carteira', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Ocupa&ccedil;&atilde;o</label>
                <input type="hidden" id="txtcboID" class="texto_id" name="txtcboID" value="<?= @$obj->_cbo_ocupacao_id; ?>" readonly="true" />
                <input type="text" id="txtcbo" class="texto04" name="txtcbo" value="<?= @$obj->_cbo_nome; ?>" <?= (in_array('ocupacao', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Nacionalidade</label>
                <input type="text" id="nacionalidade" class="texto04" name="nacionalidade" value="<?= @$obj->_nacionalidade; ?>" <?= (in_array('nacionalidade', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Ra&ccedil;a / Cor</label>


                <select name="raca_cor" id="txtRacaCor" class="size2" <?= (in_array('raca_cor', $campos_obrigatorios)) ? 'required' : '' ?>>

                    <option value=''  <?
                if (@$obj->_raca_cor == ''):echo 'selected';
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


                <select name="estado_civil_id" id="txtEstadoCivil" class="size2" selected="<?= @$obj->_estado_civil; ?>" <?= (in_array('estado_civil', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value='' <?
                    if (@$obj->_estado_civil == ''):echo 'selected';
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

                <select name="escolaridade" id="escolaridade" class="size2" selected="<?= @$obj->_escolaridade_id; ?>" <?= (in_array('escolaridade', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value='' <?
                    if (@$obj->_escolaridade_id == ''):echo 'selected';
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
            <div>
                <label>Instagram (ex: @testeclini79)</label>
                <input type="text" id="instagram" class="texto04" name="instagram" value="<?= @$obj->_instagram; ?>" <?= (in_array('instagram', $campos_obrigatorios)) ? 'required' : '' ?>/>
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
        <!--        <fieldset>
                    <legend>Outros</legend>
                    
        
                </fieldset>-->
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
    $(function () {
        $("#vencimento_carteira").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

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
        $('#txtSexo').change(function () {
//            alert($(this).val());
            if ($(this).val() == 'O') {
                $("#sexo_real_div").show();

            } else {
                $("#sexo_real_div").hide();
            }
        });
    });

    if ($('#txtSexo').val() == 'O') {
        $("#sexo_real_div").show();

    } else {
        $("#sexo_real_div").hide();
    }

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

    $(document).ready(function () {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
//            $("#rua").val("");
//            $("#bairro").val("");
//            $("#txtCidade").val("");
//            $("#uf").val("");
//            $("#ibge").val("");
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
            if (idade <= 10) {
                $("#cpf_responsavel_label").show();
                $("#cpf_responsavel").prop('required', true);
            } else {
                $("#cpf_responsavel_label").hide();
                $("#cpf_responsavel").prop('required', false);
            }

            document.getElementById("idade2").value = idade + " ano(s)";
        } else {
            $("#cpf_responsavel_label").hide();
            $("#cpf_responsavel").prop('required', false);
        }
    }
    calculoIdade();

</script>
