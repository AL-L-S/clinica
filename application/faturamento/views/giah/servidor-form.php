<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>giah/servidor">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Servidor</a></h3>
        <div>
            <form name="form_servidor" id="form_servidor" action="<?= base_url() ?>giah/servidor/gravar" method="post">

                <dl id="dl_form_servidor">
                    <dt>
                        <label>Matr&iacute;cula</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtServidorID" value="<?= @$obj->_servidor_id; ?>" />
                        <input type="text" name="txtMatricula" maxlength="7" class="texto02" value="<?= @$obj->_matricula; ?>" />
                    </dd>
                    <dt>
                        <label>CPF</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCPF" maxlength="11" alt="cpf" class="texto03" value="<?= @$obj->_cpf; ?>" />
                    </dd>
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>"/>
                    </dd>
                    <dt>
                        <label>CRP</label>
                    </dt>
                    <dd>
                        <select name="txtCRPTipo" size="1" class="texto03" id="teste"  >
                            <option value="0" ></option>
                            <option VALUE="200" <? if (@$obj->_crptipo == 200):echo 'selected'; endif;?>>CRM</option>
                            <option VALUE="210" <? if (@$obj->_crptipo == 210):echo 'selected'; endif;?>>CRF</option>
                            <option VALUE="220" <? if (@$obj->_crptipo == 220):echo 'selected'; endif;?>>CRE</option>
                        </select>
                        <input type="text" name="txtCRP" class="texto03" value="<?= @$obj->_crp; ?>"/>
                    </dd>
                    <dt>
                        <label>Categoria</label>
                    </dt>
                    <dd>
                        <select name="txtCategoria" size="1" class="texto03" id="teste"  >
                            <option value="<?= @$obj->_categoria; ?>" selected><?= @$obj->_categoria; ?></option>
                            <option>DIS</option>
                            <option>CCO</option>
                            <option>SER</option>
                            <option>CCV</option>
                        </select>
                    </dd>
                    <dt>
                        <label>UO Contrato</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtUOContrato" class="texto_id" name="txtUOContrato" value="<?= @$obj->_uo_id_contrato; ?>" readonly="true" />
                        <input type="text" id="txtUOContratoLabel" class="texto09" name="txtUOContratoLabel" value="<?= @$obj->_contrato; ?>" />
                    </dd>
                    <dt>
                        <label>UO Lota&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtUOLotacao" class="texto_id" name="txtUOLotacao" value="<?= @$obj->_uo_id_lotacao; ?>" readonly="true" />
                        <input type="text" id="txtUOLotacaoLabel" class="texto09" name="txtUOLotacaoLabel" value="<?= @$obj->_lotacao; ?>" />
                    </dd>
                    <dt>
                        <label>Fun&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtFuncao" class="texto_id" name="txtFuncao" value="<?= @$obj->_funcao_id; ?>"readonly="true" />
                        <input type="text" id="txtFuncaoLabel" class="texto09" name="txtFuncaoLabel" value="<?= @$obj->_funcao; ?>" />
                    </dd>
                    <dt>
                        <label>Classifica&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtClassificacao" class="texto_id" name="txtClassificacao" value="<?= @$obj->_classificacao_id; ?>" readonly="true" />
                        <input type="text" id="txtClassificacaoLabel" class="texto09" name="txtClassificacaoLabel" value="<?= @$obj->_classificacao; ?>" />
                    </dd>

                </dl>

                <div id="chk_desc_inss">
                <?php
                      if (@$obj->_inss == "t") {
                  ?>
                    <input type="checkbox" name="txtInss" checked ="true" /><label>Desconto INSS</label>
                  <?php
                    }else{                       
                  ?>
                    <input type="checkbox" name="txtInss"  /><label>Desconto INSS</label>
                  <?php
                         }
                ?>



              <?php
                
                    if (@$obj->_situacao_id == "1") {

                  ?>
                    <input type="checkbox" name="txtProdutividade" checked ="true" /><label>Recebe Produtividade</label>
                  <?php
                    }else{
                                                
                  ?>
                    <input type="checkbox" name="txtProdutividade" /><label>Recebe Produtividade</label>
                  <?php
                         }
              ?>


                </div>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>giah/servidor');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(function() {
        $( "#txtUOContratoLabel" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=uo",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#txtUOContratoLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtUOContratoLabel" ).val( ui.item.value );
                $( "#txtUOContrato" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtUOLotacaoLabel" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=uo",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#txtUOLotacaoLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtUOLotacaoLabel" ).val( ui.item.value );
                $( "#txtUOLotacao" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtFuncaoLabel" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=funcao",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#txtFuncaoLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtFuncaoLabel" ).val( ui.item.value );
                $( "#txtFuncao" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtClassificacaoLabel" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=classificacao",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#txtClassificacaoLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtClassificacaoLabel" ).val( ui.item.value );
                $( "#txtClassificacao" ).val( ui.item.id );
                return false;
            }
        });
    });


    $(document).ready(function(){
        jQuery('#form_servidor').validate( {
            rules: {
                txtMatricula: {
                    required: true,
                    minlength: 4
                },
                txtCPF: {
                    required: true,
                    verificaCPF: true,
                    minlength: 11,
                    maxlenght: 11
                },
                txtNome: {
                    required: true,
                    minlength: 10
                },
                txtCRM: {
                    minlength: 3
                },
                txtUOContrato: {
                    required: true,
                    minlength: 3
                },
                txtUOLotacao: {
                    required: true,
                    minlength: 3
                },
                txtFuncao: {
                    required: true,
                    minlength: 3
                },
                txtClassificacao: {
                    required: true,
                    minlength: 3
                },
                txtGratificacao: {
                    required: true,
                    minlength: 3
                }

            },
            messages: {
                txtMatricula: {
                    required: "*",
                    minlength: "!"
                },
                txtCPF: {
                    required: "*",
                    minlength: "!",
                    verificaCPF: "CPF inválido"
                },
                txtEndereco: {
                    required: "*",
                    minlength: "!"
                },
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtCRM: {
                    minlength: "!"
                },
                txtUOContrato: {
                    required: "*",
                    minlength: "!"
                },
                txtUOLotacao: {
                    required: "*",
                    minlength: "!"
                },
                txtFuncao: {
                    required: "*",
                    minlength: "!"
                },
                txtClassificacao: {
                    required: "*",
                    minlength: "!"
                },
                txtGratificacao: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>