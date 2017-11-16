<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimento">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Procedimento</a></h3>
        <div>
            <form name="form_procedimento" id="form_procedimento" style="height: 450pt;" action="<?= base_url() ?>ambulatorio/procedimento/gravar" method="post">

                <dl class="dl_cadastro_teto dt">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtprocedimentotussid" value="<?= @$obj->_procedimento_tuss_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                        <label>Procedimento</label>
                    </dt>

                    <dd>
                        <input type="hidden" name="txtprocedimento" id="txtprocedimento" class="size2" value="<?= @$obj->_tuss_id; ?>"  />
                        <input type="hidden" name="txtcodigo" id="txtcodigo" class="size2" value="<?= @$obj->_codigo; ?>" />
                        <input type="hidden" name="txtdescricao" id="txtdescricao" class="size2" value="<?= @$obj->_descricao; ?>"  />
                        <input type="text" name="txtprocedimentolabel" id="txtprocedimentolabel" class="size10" value="<?= @$obj->_descricao; ?>" />
                    </dd>
                    <dt>
                        <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size2" >
                            <option value='' >Selecione</option>
                            <? foreach ($grupos as $grupo) { ?>                                
                                <option value='<?= $grupo->nome ?>' <?
                                if (@$obj->_grupo == $grupo->nome):echo 'selected';
                                endif;
                                ?>><?= $grupo->nome ?></option>
                                    <? } ?>
                        </select>
                    </dd>
                    
                    
                    <div id="divRetorno">
                        <dt>
                            <label>Procedimento *</label>
                        </dt>
                        <dd>
                            <select name="procedimento_associacao" id="procedimento_associacao" class="size4 chosen-select" tabindex="1" required="">
                                <option value="">Selecione</option>
                                <? foreach ($procedimento as $value) : ?>
                                    <option value="<?= $value->procedimento_tuss_id; ?>"<?
                                    if (@$obj->_associacao_procedimento_tuss_id == $value->procedimento_tuss_id):echo'selected';
                                    endif;
                                    ?>><?php echo $value->codigo . " - " . $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </dd>
                        
                        <dt>
                            <label>Dias p/ Retorno</label>
                        </dt>
                        <dd>
                            <input type="text" name="diasRetorno" id="diasRetorno" alt="integer" value="<?= @$obj->_retorno_dias ?>" required=""/>
                        </dd>
                    </div>
                    
                    
                    <dt>
                        <label>Perc./Valor Medico</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtperc_medico" id="txtperc_medico" class="texto" value="<?= @$obj->_perc_medico; ?>" />
                    </dd>
                    <dt>
                        <label>Percentual</label>
                    </dt>
                    <dd>
                        <select name="percentual" id="percentual" class="size2">
                            <option value="" <?
                            if (@$obj->_percentual == ""):echo 'selected';
                            endif;
                            ?>>Selecione</option>
                            <option value="1" <?
                            if (@$obj->_percentual == "t"):echo 'selected';
                            endif;
                            ?>>SIM</option>
                            <option value="0" <?
                            if (@$obj->_percentual == "f"):echo 'selected';
                            endif;
                            ?>>N&Atilde;O</option>
                        </select>
                    </dd>
                    
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="medico" id="medico" class="size2">
                            <option value="" <?
                            if (@$obj->_medico == ""):echo 'selected';
                            endif;
                            ?>>Selecione</option>
                            <option value="1" <?
                            if (@$obj->_medico == "t"):echo 'selected';
                            endif;
                            ?>>SIM</option>
                            <option value="0" <?
                            if (@$obj->_medico == "f"):echo 'selected';
                            endif;
                            ?>>N&Atilde;O</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Home Care</label>
                    </dt>
                    <dd>
                        <select name="homecare" id="homecare" class="size2">
                            <option value="" <?
                            if (@$obj->_home_care == ""):echo 'selected';
                            endif;
                            ?>>Selecione</option>
                            <option value="1" <?
                            if (@$obj->_home_care == "t"):echo 'selected';
                            endif;
                            ?>>SIM</option>
                            <option value="0" <?
                            if (@$obj->_home_care == "f"):echo 'selected';
                            endif;
                            ?>>N&Atilde;O</option>
                        </select>
                    </dd>
<!--                    <dt>
                        <label>Perc./Valor Promotor</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtperc_promotor" id="txtperc_promotor" class="texto" value="<?= @$obj->_valor_promotor; ?>" />
                    </dd>
                    <dt>
                        <label>Promotor Percentual</label>
                    </dt>
                    <dd>
                        <select name="percentual_promotor" id="percentual_promotor" class="size2">
                            <option value="" <?
                            if (@$obj->_percentual_promotor == ""):echo 'selected';
                            endif;
                            ?>>Selecione</option>
                            <option value="1" <?
                            if (@$obj->_percentual_promotor == "t"):echo 'selected';
                            endif;
                            ?>>SIM</option>
                            <option value="0" <?
                            if (@$obj->_percentual_promotor == "f"):echo 'selected';
                            endif;
                            ?>>N&Atilde;O</option>
                        </select>
                    </dd>-->
                    <dt>
                        <label>Perc./Valor Revisor</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtperc_revisor" id="txtperc_revisor" class="texto" value="<?=@ $obj->_valor_revisor; ?>" />
                    </dd>
                    <dt>
                        <label>Revisor Percentual</label>
                    </dt>
                    <dd>
                        <select name="percentual_revisor" id="percentual_revisor" class="size2">
                            <option value="" <?
                            if (@$obj->_percentual_revisor == ""):echo 'selected';
                            endif;
                            ?>>Selecione</option>
                            <option value="1" <?
                            if (@$obj->_percentual_revisor == "t"):echo 'selected';
                            endif;
                            ?>>SIM</option>
                            <option value="0" <?
                            if (@$obj->_percentual_revisor == "f"):echo 'selected';
                            endif;
                            ?>>N&Atilde;O</option>
                        </select>
                    </dd>
                            
                    <dt>
                        <label>Qtde de sess&otilde;es</label>
                    </dt>
                    <dd>
                        <input required type="number" name="txtqtde" min="1" class="texto" value="<?= @$obj->_qtde; ?>" />
                    </dd>
                    <dt>
                        <label>Prazo entrega</label>
                    </dt>
                    <dd>
                        <input type="text" name="entrega" class="texto" value="<?= @$obj->_entrega; ?>" />
                    </dd>
                    <dt>
                        <label>Descrição</label>
                    </dt>
                    <dd>
                        <textarea  type="text" name="descricao" id="descricao" class="textarea" cols="60" rows="1" ><?= @$obj->_descricao_procedimento; ?> </textarea>
                    </dd>
                    
                    <dt>
                        <label>Revisão?</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="rev" id="rev" <?if(@$obj->_revisao == 't'){ echo "checked"; }?>/>
                        <div class="dias" style="display: inline">
                            <?if(@$obj->_revisao == 't'){ ?>
                            <span>Dias</span><input type="text" alt="integer" name="dias" id="dias" class="texto03" value="<?= @$obj->_revisao_dias; ?>" required/>
                            <?}?>
                        </div>
                    </dd>
                    
                    <dt>
                        <label>Sala de Preparo?</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="salaPreparo" id="salaPreparo" <?if(@$obj->_sala_preparo == 't'){ echo "checked"; }?>/>
                    </dd>
                    

                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <!--<button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>-->
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $('#rev').change(function () {
        if(this.checked){
            var tag = '<span>Dias</span><input type="text" alt="integer" name="dias" id="dias" required/>';
            $(".dias").append(tag);
        }
        else{
            $(".dias span").remove();
            $(".dias input").remove();
        }
    });
    
    $('#grupo').change(function () {
        if( $(this).val() == 'RETORNO'){
            $('#divRetorno').show();
            $("#procedimento_associacao").prop('required', true);
            $("#diasRetorno").prop('required', true);
            $("#diasRetorno").val('<?= @$obj->_retorno_dias ?>');
        }
        else if( $(this).val() == 'AGRUPADOR'){
            $('#divRetorno').show();
            $("#procedimento_associacao").prop('required', true);
            $("#diasRetorno").prop('required', true);
            $("#diasRetorno").val('<?= @$obj->_retorno_dias ?>');
        }
        else{;
            $('#divRetorno').hide();
            $("#procedimento_associacao").prop('required', false);
            $("#diasRetorno").prop('required', false);
            $("#diasRetorno").val('');
        }
    });
    

    $(function () {
        $("#accordion").accordion();
        <? if(@$obj->_grupo == 'RETORNO'){?>
            $('#divRetorno').show();
            $("#procedimento_associacao").prop('required', true);
            $("#diasRetorno").prop('required', true);
        <? } else { ?>
            $('#divRetorno').hide();
            $("#procedimento_associacao").prop('required', false);
            $("#diasRetorno").prop('required', false);
        <? } ?>
    });

    $(function () {
        $("#txtprocedimentolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentotuss",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtprocedimentolabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtprocedimentolabel").val(ui.item.value);
                $("#txtprocedimento").val(ui.item.id);
                $("#txtcodigo").val(ui.item.codigo);
                $("#txtdescricao").val(ui.item.descricao);
                return false;
            }
        });
    });

    $(document).ready(function () {
        jQuery('#form_procedimento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtprocedimentolabel: {
                    required: true
                },
                txtperc_medico: {
                    required: true
                },
                grupo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtprocedimentolabel: {
                    required: "*"
                },
                txtperc_medico: {
                    required: "*"
                },
                grupo: {
                    required: "*"
                }
            }
        });
    });

</script>