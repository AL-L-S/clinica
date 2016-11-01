<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>seguranca/operador">
            Voltar
        </a>
    </div>

    <h3 class="singular"><a href="#">Cadastro de Operador</a></h3>
    <div>
        <form name="form_operador" id="form_operador" action="<?= base_url() ?>seguranca/operador/gravar" method="post">
            <fieldset>
                <legend>Dados do Profissional</legend>
                <div>
                    <label>Nome *</label>                      
                    <input type ="hidden" name ="operador_id" value ="<?= @$obj->_operador_id; ?>" id ="txtoperadorId">
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$obj->_nome; ?>" />
                </div>
                <div>
                    <label>Sexo *</label>


                    <select name="sexo" id="txtSexo" class="size2">
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
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" onblur="retornaIdade()"/>
                </div>
                <div>
                    <label>Conselho</label>
                    <input type="text" id="txtconselho" name="conselho"  class="texto04" value="<?= @$obj->_conselho; ?>" />
                </div>
                <div>
                    <label>CPF *</label>


                    <input type="text" name="cpf" id ="txtCpf" maxlength="11" alt="cpf" class="texto02" value="<?= @$obj->_cpf; ?>" />
                </div>
                <div>
                    <label>Ocupa&ccedil;&atilde;o</label>
                    <input type="hidden" id="txtcboID" class="texto_id" name="txtcboID" value="<?= @$obj->_cbo_ocupacao_id; ?>" readonly="true" />
                    <input type="text" id="txtcbo" class="texto04" name="txtcbo" value="<?= @$obj->_cbo_nome; ?>" />


                    <?php
                    if (@$obj->_consulta == "t") {
                        ?>
                        <input type="checkbox" name="txtconsulta" checked ="true"/>Realiza consulta
                        <?php
                    } else {
                        ?>
                        <input type="checkbox" name="txtconsulta"  />Realiza consulta
                        <?php
                    }
                    ?>
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
                            <option   value =<?php echo $item->tipo_logradouro_id; ?> 
                            <?
                            if (@$obj->_tipoLogradouro == $item->tipo_logradouro_id):echo 'selected';
                            endif;
                            ?>><?php echo $item->descricao; ?></option>
                                  <?php } ?> 
                    </select>
                </div>
                <div>
                    <label>Endere&ccedil;o</label>


                    <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_logradouro; ?>" />
                </div>
                <div>
                    <label>N&uacute;mero</label>


                    <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" />
                </div>
                <div>
                    <label>Bairro</label>


                    <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" />
                </div>
                <div>
                    <label>Complemento</label>


                    <input type="text" id="txtComplemento" class="texto06" name="complemento" value="<?= @$obj->_complemento; ?>" />
                </div>

                <div>
                    <label>Município</label>


                    <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" readonly="true" />
                    <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" />
                </div>
                <div>
                    <label>CEP</label>


                    <input type="text" id="txtCep" class="texto02" name="cep" alt="cep" value="<?= @$obj->_cep; ?>" />
                </div>


                <div>
                    <label>Telefone</label>


                    <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
                </div>
                <div>
                    <label>Celular *</label>


                    <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                </div>
                <div>
                    <label>E-mail *</label>
                    <input type="text" id="txtemail" class="texto06" name="email" value="<?= @$obj->_email; ?>" />
                </div>
            </fieldset>
            <fieldset>
                <legend>Acesso</legend>
                <div>
                    <label>Nome usu&aacute;rio *</label>

                    <input type="text" id="txtUsuario" name="txtUsuario"  class="texto04" value="<?= @$obj->_usuario; ?>" />
                </div>
                <div>
                    <label>Senha *</label>

                    <input type="password" name="txtSenha" id="txtSenha" class="texto04" value="<?= @$obj->_senha; ?>" />
                </div>
                <div>
                    <label>Tipo perfil *</label>

                    <select name="txtPerfil" id="txtPerfil" class="size4">
                        <option value="">Selecione</option>
                        <? foreach ($listarPerfil as $item) :
                            if ($this->session->userdata('perfil_id') == 1) { ?>
                                    <option value="<?= $item->perfil_id; ?>"<?
                                    if (@$obj->_perfil_id == $item->perfil_id):echo 'selected';
                                    endif;?>>
                                    <?= $item->nome; ?></option>
                            <?} else {
                                if( !($item->perfil_id == 1) ){ ?>
                                    <option value="<?= $item->perfil_id; ?>"<?
                                    if (@$obj->_perfil_id == $item->perfil_id):echo 'selected';
                                    endif;
                                    ?>><?= $item->nome; ?></option>
                            <?}}?>
                        <? endforeach; ?>
                    </select>
                </div>

            </fieldset>
            <fieldset>
                <legend>Financeiro</legend>
                <div>
                    <label>Criar Credor</label>
                <input type="checkbox" name="criarcredor"/></div>
                
                <div>

                        

                    <label>Credor / Devedor</label>


                    <select name="credor_devedor" id="credor_devedor" class="size2" >
                        <option value='' >selecione</option>
                        <?php
                        $credor_devedor = $this->convenio->listarcredordevedor();
                        foreach ($credor_devedor as $item) {
                            ?>

                            <option   value =<?php echo $item->financeiro_credor_devedor_id; ?> <?
                            if (@$obj->_credor_devedor_id == $item->financeiro_credor_devedor_id):echo 'selected';
                            endif;
                            ?>><?php echo $item->razao_social; ?></option>
                                      <?php
                                  }
                                  ?> 
                    </select>
                </div>
                <div>
                    <label>Conta</label>


                    <select name="conta" id="conta" class="size2" >
                        <option value='' >selecione</option>
                        <?php
                        $conta = $this->forma->listarforma();
                        foreach ($conta as $item) {
                            ?>

                            <option   value =<?php echo $item->forma_entradas_saida_id; ?> <?
                            if (@$obj->_conta_id == $item->forma_entradas_saida_id):echo 'selected';
                            endif;
                            ?>><?php echo $item->descricao; ?></option>
                                      <?php
                                  }
                                  ?> 
                    </select>
                </div>
                <div>
                    <label>Tipo</label>


                    <select name="tipo" id="tipo" class="size2" >
                        <option value='' >selecione</option>
                        <?php
                        $tipo = $this->tipo->listartipo();

                        foreach ($tipo as $item) {
                            ?>

                            <option   value = "<?= $item->descricao; ?>" <?
                            if (@$obj->_tipo_id == $item->descricao):echo 'selected';
                            endif;
                            ?>><?php echo $item->descricao; ?></option>
                                      <?php
                                  }
                                  ?> 
                    </select>
                </div>
                <div>
                    <label>IR</label>
                    <input type="text" id="ir" class="texto02" name="ir" alt="decimal" value="<?= @$obj->_ir; ?>" />
                </div>
                <div>
                    <label>PIS</label>
                    <input type="text" id="pis" class="texto02" name="pis" alt="decimal" value="<?= @$obj->_pis; ?>" />
                </div>
                <div>
                    <label>COFINS</label>
                    <input type="text" id="cofins" class="texto02" name="cofins" alt="decimal" value="<?= @$obj->_cofins; ?>" />
                </div>
                <div>
                    <label>CSLL</label>
                    <input type="text" id="csll" class="texto02" name="csll" alt="decimal" value="<?= @$obj->_csll; ?>" />
                </div>
                <div>
                    <label>ISS</label>
                    <input type="text" id="iss" class="texto02" name="iss" alt="decimal" value="<?= @$obj->_iss; ?>" />
                </div>
                <div>
                    <label>Valor Base para Imposto</label>
                    <input type="text" id="valor_base" class="texto02" name="valor_base" alt="decimal" value="<?= @$obj->_valor_base; ?>" />
                </div>
            </fieldset>

            <fieldset style="dislpay:block">

                <button type="submit" name="btnEnviar">Enviar</button>

                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </fieldset>
        </form>
    </div>

</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
                        $('#btnVoltar').click(function() {
                            $(location).attr('href', '<?= base_url(); ?>sca/operador');
                        });


                        $(function() {
                            $("#txtCidade").autocomplete({
                                source: "<?= base_url() ?>index?c=autocomplete&m=cidade",
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
                            $("#txtcbo").autocomplete({
                                source: "<?= base_url() ?>index?c=autocomplete&m=cboprofissionais",
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

                        $(document).ready(function() {
                            jQuery('#form_operador').validate({
                                rules: {
                                    nome: {
                                        required: true,
                                        minlength: 6
                                    }
                                },
                                messages: {
                                    nome: {
                                        required: "*",
                                        minlength: "!"
                                    }
                                }
                            });
                        });

</script>