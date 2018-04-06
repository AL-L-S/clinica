<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>seguranca/operador">
            Voltar
        </a>
    </div>

    <h3 class="singular"><a href="#">Cadastro de Operador</a></h3>
    <div>
        <form name="form_operador" id="form_operador" action="<?= base_url() ?>seguranca/operador/gravar" method="post" style="margin-bottom: 50px;">
            <fieldset>
                <legend>Dados do Profissional</legend>
                <div>
                    <label>Nome *</label>                      
                    <input type ="hidden" name ="operador_id" value ="<?= @$obj->_operador_id; ?>" id ="txtoperadorId" >
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$obj->_nome; ?>" required="true"/>
                </div>
                <div>
                    <label>Sexo *</label>


                    <select name="sexo" id="txtSexo" class="size2">
                        <option value="">Selecione</option>
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
                    <label>Cor do Mapa</label>
                    <input type="color" id="txtcolor" name="txtcolor"  class="texto04" value="<?= @$obj->_cor_mapa; ?>" />
                </div>
                <div>
                    <label>CPF *</label>


                    <input type="text" name="cpf" id ="txtCpf" maxlength="11" alt="cpf" class="texto02" value="<?= @$obj->_cpf; ?>" required />
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

                    <input type="checkbox" name="txtsolicitante" <? if (@$obj->_solicitante == "t") echo 'checked' ?> />Médico Solicitante
                    <input type="checkbox" name="ocupacao_painel" <? if (@$obj->_ocupacao_painel == "t") echo 'checked' ?> />Ocupação no Painel
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
                ?>

                <div>
                    <label>Telefone</label>


                    <input type="text" id="txtTelefone" class="texto02" name="telefone"  value="<?= $telefone ?>" />
                </div>
                <div>
                    <label>Celular *</label>


                    <input type="text" id="txtCelular" class="texto02" name="celular" value="<?= $celular; ?>" required="true"/>
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

                    <input type="text" id="txtUsuario" name="txtUsuario"  class="texto04" value="<?= @$obj->_usuario; ?>" required="true"/>
                </div>
                <div>
                    <label>Senha: *</label>
                    <input type="password" name="txtSenha" id="txtSenha" class="texto04" value="" <? if (@$obj->_senha == null) {
                    ?>
                               required="true"
                           <? } ?> />

                    <!--                    <label>Confirme a Senha: *</label>
                                        <input type="password" name="verificador" id="txtSenha" class="texto04" value="" onblur="confirmaSenha(this)"/>-->
                </div>
                <div>
                    <label>Tipo perfil *</label>

                    <select name="txtPerfil" id="txtPerfil" class="size4" required="true">
                        <option value="">Selecione</option>
                        <?
                        foreach ($listarPerfil as $item) :
                            if ($this->session->userdata('perfil_id') == 1) {
                                ?>
                                <option value="<?= $item->perfil_id; ?>"<?
                                if (@$obj->_perfil_id == $item->perfil_id):echo 'selected';
                                endif;
                                ?>>
                                    <?= $item->nome; ?></option>
                                <?
                            } else {
                                if (!($item->perfil_id == 1)) {
                                    ?>
                                    <option value="<?= $item->perfil_id; ?>"<?
                                    if (@$obj->_perfil_id == $item->perfil_id):echo 'selected';
                                    endif;
                                    ?>><?= $item->nome; ?></option>
                                            <?
                                        }
                                    }
                                    ?>
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
                        <option value='' >Selecione</option>
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
                        <option value='' >Selecione</option>
                        <?php
                        $conta = $this->forma->listarforma();
                        
                        foreach ($conta as $item) {
                            ?>

                            <option   value =<?php echo $item->forma_entradas_saida_id; ?> <?
                            if (@$obj->_conta_id == $item->forma_entradas_saida_id):echo 'selected';
                            endif;
                            ?>><?php echo $item->descricao . " - " . $item->empresa; ?></option>
                                      <?php
                                  }
                                  ?> 
                    </select>
                    <?
//                    var_dump($conta); die;
                    ?>
                </div>
                <div>
                    <label>Tipo</label>


                    <select name="tipo" id="tipo" class="size2">
                        <option value='' >Selecione</option>
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
                    <label>Classe</label>


                    <select name="classe" id="classe" class="size2">
                        <option value="">Selecione</option>
                        <? foreach ($classe as $value) : ?>
                            <option value="<?= $value->descricao; ?>"
                            <?
                            if ($value->descricao == @$obj->_classe):echo'selected';
                            endif;
                            ?>
                                    ><?php echo $value->descricao; ?></option>
                                <? endforeach; ?>
                    </select>
                </div>

                <fieldset>
                    <legend>Impostos e Taxas</legend>
                    <div>
                        <label>Taxa Adminsitração</label>
                        <input type="text" id="taxaadm" class="texto02" name="taxaadm" alt="decimal" value="<?= @$obj->_taxa_administracao; ?>" />
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
            </fieldset>
            
            <? if (@$empresapermissao[0]->desativar_personalizacao_impressao == 'f'){ ?>
                <fieldset>
                    <div>
                        <label>Carimbo</label>
                        <textarea name="carimbo" id="carimbo" rows="5" cols="30"  ><?= @$obj->_carimbo; ?></textarea>
                    </div>
                    <div>
                        <label>Mini-Curriculo</label>
                        <textarea name="curriculo" id="curriculo" rows="5" cols="50"  ><?= @$obj->_curriculo; ?></textarea>
                    </div>
                </fieldset>
                <fieldset>
                    <div>
                        <label>Cabeçalho</label>
                        <textarea name="cabecalho" id="cabecalho" rows="10" cols="100"  ><?= @$obj->_cabecalho; ?></textarea>
                    </div>
                    <div>
                        <label>Rodapé</label>
                        <textarea name="rodape" id="rodape" rows="10" cols="100"  ><?= @$obj->_rodape; ?></textarea>
                    </div>
                    <div>
                        <label>Timbrado</label>
                        <textarea name="timbrado" id="timbrado" rows="10" cols="100"  ><?= @$obj->_timbrado; ?></textarea>
                    </div>
                    <div>
                        <p>
                            Obs: O tamanho da imagem é padrão: 800px X 600px <br>
                            Obs²: O formato da imagem importada deverá ser .png (Sendo possivel dessa forma, aplicar opacidade na imagem através de edição da mesma por softwares de terceiros)
                        </p>
                    </div>
                </fieldset>
            <? } ?>
            
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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

    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>sca/operador');
    });

    function confirmaSenha(verificacao) {
        var senha = $("#txtSenha");
        if (verificacao.value != senha.val()) {
            verificacao.setCustomValidity("As senhas não correspondem!");
        } else {
            verificacao.setCustomValidity("");
        }
    }

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
        $('#tipo').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/classeportiposaidalistadescricao', {nome: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
                    }
                    $('#classe').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/classeportiposaidalistadescricaotodos', {nome: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
                    }
                    $('#classe').html(options).show();
                    $('.carregando').hide();
                });
            }
        });
    });

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


    tinyMCE.init({
        // General options
        mode: "textareas",
        theme: "advanced",
        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
        // Theme options
        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,image",
        theme_advanced_buttons2: "styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        // Example content CSS (should be your site CSS)
        //                                    content_css : "css/content.css",
        content_css: "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
        // Drop lists for link/image/media/template dialogs
        template_external_list_url: "lists/template_list.js",
        external_link_list_url: "lists/link_list.js",
        external_image_list_url: "lists/image_list.js",
        media_external_list_url: "lists/media_list.js",
        // Style formats
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
        // Replace values for the template plugin
        template_replace_values: {
            username: "Some User",
            staffid: "991234"
        }

    });

</script>