<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar" method="post">
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome</label>                      
                <input type ="hidden" name ="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId">
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" />
            </div>
            <div>
                <label>Nascimento</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" />
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
                <select name="sexo" id="txtSexo" class="size1">
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
        </fieldset>
        <fieldset>
            <legend>Documentos</legend>
            <div>
                <label>CPF</label>


                <input type="text" name="cpf" id ="txtCpf" maxlength="11" alt="cpf" class="texto02" value="<?= @$obj->_cpf; ?>" />
            </div>
            <div>
                <label>RG</label>


                <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>" />
            </div>
            <div>
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
                </div>




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
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" />
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep" alt="cep" value="<?= @$obj->_cep; ?>" />
            </div>


            <div>
                <label>Telefone</label>


                <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$obj->_telefone; ?>" />
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
            </div>
            <div>
                <label>Indicacao</label>


                <select name="indicacao" id="indicacao" class="size2" >
                    <option value='' >selecione</option>
                    <?php
                    $indicacao = $this->paciente->listaindicacao($_GET);
                    foreach ($indicacao as $item) {
                        ?>

                        <option   value =<?php echo $item->paciente_indicacao_id; ?> <?
                        if (@$obj->_indicacao == $item->paciente_indicacao_id):echo 'selected';
                        endif;
                        ?>><?php echo $item->nome; ?></option>
                                  <?php
                              }
                              ?> 
                </select>
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
        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>

        <a href="<?= base_url() ?>cadastros/pacientes">
            <button type="button" id="btnVoltar">Voltar</button>
        </a>

    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


                    $(document).ready(function() {
                        jQuery('#form_paciente').validate({
                            rules: {
                                nome: {
                                    required: true,
                                    minlength: 3
                                },
                                sexo: {
                                    required: true
                                },
                                telefone: {
                                    required: true
                                },
                                nascimento: {
                                    required: true
                                }

                            },
                            messages: {
                                nome: {
                                    required: "*",
                                    minlength: "*"
                                },
                                sexo: {
                                    required: "*"
                                },
                                telefone: {
                                    required: "*"
                                },
                                nascimento: {
                                    required: "*"
                                }
                            }
                        });
                    });

                    $(function() {
                        $("#txtcbo").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=cboprofissionais",
                            minLength: 3,
                            focus: function(event, ui) {
                                $("#txtcbo").val(ui.item.label);
                                return false;
                            },
                            select: function(event, ui) {
                                $("#txtcbo").val(ui.item.value);
                                $("#txtcboID").val(ui.item.id);
                                return false;
                            }
                        });
                    });

                    $(function() {
                        $("#txtCidade").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
                            minLength: 3,
                            focus: function(event, ui) {
                                $("#txtCidade").val(ui.item.label);
                                return false;
                            },
                            select: function(event, ui) {
                                $("#txtCidade").val(ui.item.value);
                                $("#txtCidadeID").val(ui.item.id);
                                return false;
                            }
                        });
                    });
                    $(function() {
                        $("#txtEstado").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=estado",
                            minLength: 2,
                            focus: function(event, ui) {
                                $("#txtEstado").val(ui.item.label);
                                return false;
                            },
                            select: function(event, ui) {
                                $("#txtEstado").val(ui.item.value);
                                $("#txtEstadoID").val(ui.item.id);
                                return false;
                            }
                        });
                    });




</script>