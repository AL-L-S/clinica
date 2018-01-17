
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div>
        <form name="form_laboratorio" id="form_laboratorio" action="<?= base_url() ?>cadastros/laboratorio/gravar" method="post">
            <fieldset>
                <legend>Dados do Laboratório</legend>
                <div>
                    <label>Nome</label>
                    <input type="hidden" name="txtlaboratorio_id" class="texto10 bestupper" value="<?= @$obj->_laboratorio_id; ?>" />
                    <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->_nome; ?>" />
                </div>
                <div>
                    <label>Raz&atilde;o social</label>
                    <input type="text" name="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" />
                </div>
                <div>
                    <label>CNPJ</label>
                    <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$obj->_cnpj; ?>" />
                </div>


            </fieldset>
            <fieldset>
                <legend>Endereco</legend>

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
                    <label>Celular</label>
                    <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                </div>
            </fieldset>
            <fieldset>
                <legend>Financeiro</legend>
                <div>
                    <label>Criar Credor</label>
                    <input type="checkbox" name="criarcredor" id="criarcredor"/></div>

                <div>



                    <label>Credor / Devedor</label>


                    <select name="credor_devedor" id="credor_devedor" class="size2" required>
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


                    <select name="conta" id="conta" class="size2" required>
                        <option value='' >Selecione</option>
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


                    <select name="tipo" id="tipo" class="size2" required>
                        <option value='' >Selecione</option>
                        <?php
                        $tipo = $this->tipo->listartipo();

                        foreach ($tipo as $item) {
                            ?>

                            <option   value = "<?= $item->descricao; ?>" <?
                            if (@$obj->_tipo == $item->descricao):echo 'selected';
                            endif;
                            ?>><?php echo $item->descricao; ?></option>
                                      <?php
                                  }
                                  ?> 
                    </select>
                </div>
                <div>
                    <label>Classe</label>


                    <select name="classe" id="classe" class="size2" required>
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


            </fieldset>          



            <fieldset>
                <legend>Observa&ccedil;&atilde;o</legend>
                <div>
                    <textarea cols="" rows="" name="txtObservacao" class="texto_area"><?= @$obj->_observacao; ?></textarea>
                </div>
            </fieldset>
            <hr/>
            <fieldset>
                <div>
                    <button type="submit" name="btnEnviar">Enviar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                </div>
            </fieldset>
            <br>
        </form>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $('#criarcredor').change(function () {
        if ($(this).is(":checked")) {
            $("#credor_devedor").prop('required', false);

        } else {
            $("#credor_devedor").prop('required', true);

        }
    });
    var teste = '<? echo $obj->_tabela; ?>';
    if (teste == 'CBHPM' || teste == 'PROPRIA') {
        $("#procedimento1").prop('required', true);
        $("#procedimento2").prop('required', true);
    } else {
        $("#procedimento1").prop('required', false);
        $("#procedimento2").prop('required', false);
    }

//    $(function () {
//        $('#tipo').change(function () {
//            if ($(this).val() == 'PROPRIA' || $(this).val() == 'CBHPM') {
//                $("#procedimento1").prop('required', true);
//                $("#procedimento2").prop('required', true);
//
//            } else {
//                $("#procedimento1").prop('required', false);
//                $("#procedimento2").prop('required', false);
//            }
//        });
//    });
    var classe_selecionada = '';
    <?if(@$obj->_classe != ''){?>
        classe_selecionada = '<?=@$obj->_classe?>';
    <?}?>

    if ($('#tipo').val()) {
        $('.carregando').show();
        $.getJSON('<?= base_url() ?>autocomplete/classeportiposaidalistadescricao', {nome: $('#tipo').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
            for (var c = 0; c < j.length; c++) {
                if(j[c].classe == classe_selecionada){
                  options += '<option selected value="' + j[c].classe + '">' + j[c].classe + '</option>';    
                }else{
                  options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';  
                }
                
            }
            $('#classe').html(options).show();
            $('.carregando').hide();
        });
    } else {
        $('.carregando').show();
        $.getJSON('<?= base_url() ?>autocomplete/classeportiposaidalistadescricaotodos', {nome: $('#tipo').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
            for (var c = 0; c < j.length; c++) {
                options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
            }
            $('#classe').html(options).show();
            $('.carregando').hide();
        });
    }
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
</script>