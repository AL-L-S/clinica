
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div>
        <form name="form_convenio" id="form_convenio" action="<?= base_url() ?>cadastros/convenio/gravar" method="post">
            <fieldset>
                <legend>Dados do Convenio</legend>
                <div>
                    <label>Nome</label>
                    <input type="hidden" name="txtconvenio_id" class="texto10 bestupper" value="<?= @$obj->_convenio_id; ?>" />
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
                <div>
                    <label>Registro ANS</label>
                    <input type="text" name="txtregistroans" class="texto10" value="<?= @$obj->_registroans; ?>" />
                </div>
                <div>
                    <label>Codigo identifica&ccedil;&atilde;o</label>
                    <input type="text" name="txtcodigo" maxlength="20" class="texto03" value="<?= @$obj->_codigoidentificador; ?>" />
                </div>
                <div>
                    <label>&nbsp;</label>
                    <?php
                    if (@$obj->_carteira_obrigatoria == "t") {
                        ?>
                        <input type="checkbox" name="txtcarteira" checked ="true" />Número da carteira/autorização obrigatorio
                        <?php
                    } else {
                        ?>
                        <input type="checkbox" name="txtcarteira"  />Número da carteira/autorização obrigatorio
                        <?php
                    }
                    ?>
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
                <legend>Detalhes</legend>
                <div>
                    <label>Tabela</label>
                    <select  name="tipo" id="tipo" class="size1" >
                        <option value="SIGTAP" <?
                        if (@$obj->_tabela == "SIGTAP"):echo 'selected';
                        endif;
                        ?>>SIGTAP</option>
                        <option value="AMB92" <?
                        if (@$obj->_tabela == "AMB92"):echo 'selected';
                        endif;
                        ?>>AMB92</option>
                        <option value="TUSS" <?
                        if (@$obj->_tabela == "TUSS"):echo 'selected';
                        endif;
                        ?>>TUSS</option>
                        <option value="CBHPM" <?
                        if (@$obj->_tabela == "CBHPM"):echo 'selected';
                        endif;
                        ?>>CBHPM</option>
                        <option value="PROPRIA" <?
                        if (@$obj->_tabela == "PROPRIA"):echo 'selected';
                        endif;
                        ?>>TABELA PROPRIA</option>
                    </select>

                </div>
                <div>
                    <label>Grupo convenio</label>
                    <select name="grupoconvenio" id="grupoconvenio" class="size2" >
                        <option value='' >selecione</option>
                        <?php
                        $grupoconvenio = $this->grupoconvenio->listargrupoconvenios();
                        foreach ($grupoconvenio as $item) {
                            ?>

                            <option   value =<?php echo $item->convenio_grupo_id; ?> <?
                            if (@$obj->_convenio_grupo_id == $item->convenio_grupo_id):echo 'selected';
                            endif;
                            ?>><?php echo $item->nome; ?></option>
                                      <?php
                                  }
                                  ?> 
                    </select>
                </div>
                <div>
                    <label>Primeiro procedimento</label>
                    <input type="text" id="procedimento1" class="texto01" name="procedimento1" alt="integer" value="<?= @$obj->_procedimento1; ?>" />%
                </div>
                <div>
                    <label>Outros procedimento</label>
                    <input type="text" id="procedimento2" class="texto01" name="procedimento2" alt="integer" value="<?= @$obj->_procedimento2; ?>" />%
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
                <div>
                    <label>Data entrega</label>
                    <input type="text" id="entrega" class="texto02" name="entrega" alt="integer" value="<?= @$obj->_entrega; ?>" />
                </div>
                <div>
                    <label>Tempo para pagamento</label>
                    <input type="text" id="pagamento" class="texto02" name="pagamento" alt="integer" value="<?= @$obj->_pagamento; ?>" />

                </div>

            </fieldset>
            <fieldset>
                <legend>Condi&ccedil;&atilde;o de recebimento</legend>
                <div>
                    <?php
                    if (@$obj->_dinheiro == "t") {
                        ?>
                        <input type="checkbox" name="txtdinheiro" checked ="true" />Recebimento em Caixa
                        <?php
                    } else {
                        ?>
                        <input type="checkbox" name="txtdinheiro"  />Recebimento em Caixa
                        <?php
                    }
                    ?>
                </div>
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
                        $forma = $this->convenio->listarforma();
//                        var_dump($forma);
                        foreach ($forma as $item) {
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
            </fieldset>
            <fieldset>
                <legend>Associaçao de Convenio</legend>
                <div>
                    <input type="checkbox" name="associaconvenio" id="associaconvenio" <?= (@$obj->_associado == 't')? 'checked':""; ?>/> Associar a outro convenio
                </div>
                
                <div id="div_associacao">
                    <div>
                        <label>Convenio Principal</label>
                        <select name="convenio_associacao" id="convenio_associacao" class="size2" >
                            <option value=''>Selecione</option>
                            <?php
                            foreach ($convenio as $item) {
                                ?>
                                <option value =<?php echo $item->convenio_id; ?> <?= (@$obj->_associacao_convenio_id == $item->convenio_id)? 'selected':""; ?>><?php echo $item->nome; ?></option>
                            <?php } ?> 
                        </select>
                    </div>
<!--                    <div>
                        <label>Valor Percentual</label>
                        <input type="number" step="0.01" name="valorpercentual"  id="valorpercentual" class="texto02" value="<?= @$obj->_associacao_percentual; ?>" /> %
                    </div>-->
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
    <?if(@$obj->_associado != 't'){?>
        $("#div_associacao").hide();
    <?}?>
    $('#associaconvenio').change(function () {
        if ($(this).is(":checked")) {
            $("#div_associacao").show();
            $("#convenio_associacao").prop('required', true);
            $("#valorpercentual").prop('required', true);
            
        } else {
            $("#div_associacao").hide();
            $("#convenio_associacao").prop('required', false);
            $("#valorpercentual").prop('required', false);
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

    $(function () {
        $('#tipo').change(function () {
            if ($(this).val() == 'PROPRIA' || $(this).val() == 'CBHPM') {
                $("#procedimento1").prop('required', true);
                $("#procedimento2").prop('required', true);

            } else {
                $("#procedimento1").prop('required', false);
                $("#procedimento2").prop('required', false);
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