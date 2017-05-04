<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Procedimento</a></h3>
        <div>
            <form name="form_procedimento" id="form_procedimento" action="<?= base_url() ?>ambulatorio/procedimento/gravar" method="post">

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
                    <!--                    <dd>
                                            <select name="grupo" id="grupo" class="size1" >
                                                <option value='' >Selecione</option>
                                                <option value='AUDIOMETRIA' <?
                    if (@$obj->_grupo == 'AUDIOMETRIA'):echo 'selected';
                    endif;
                    ?>>AUDIOMETRIA</option>
                                                <option value='CONSULTA' <?
                    if (@$obj->_grupo == 'CONSULTA'):echo 'selected';
                    endif;
                    ?>>CONSULTA</option>
                                                <option value='DENSITOMETRIA' <?
                    if (@$obj->_grupo == 'DENSITOMETRIA'):echo 'selected';
                    endif;
                    ?>>DENSITOMETRIA</option>
                                                <option value='ECOCARDIOGRAMA' <?
                    if (@$obj->_grupo == 'ECOCARDIOGRAMA'):echo 'selected';
                    endif;
                    ?>>ECOCARDIOGRAMA</option>
                                                <option value='ELETROCARDIOGRAMA' <?
                    if (@$obj->_grupo == 'ELETROCARDIOGRAMA'):echo 'selected';
                    endif;
                    ?>>ELETROCARDIOGRAMA</option>
                                                <option value='ELETROENCEFALOGRAMA' <?
                    if (@$obj->_grupo == 'ELETROENCEFALOGRAMA'):echo 'selected';
                    endif;
                    ?>>ELETROENCEFALOGRAMA</option>
                                                <option value='ESPIROMETRIA' <?
                    if (@$obj->_grupo == 'ESPIROMETRIA'):echo 'selected';
                    endif;
                    ?>>ESPIROMETRIA</option>
                                                <option value='FISIOTERAPIA' <?
                    if (@$obj->_grupo == 'FISIOTERAPIA'):echo 'selected';
                    endif;
                    ?>>FISIOTERAPIA</option>
                                                <option value='LABORATORIAL' <?
                    if (@$obj->_grupo == 'LABORATORIAL'):echo 'selected';
                    endif;
                    ?>>LABORATORIAL</option>
                                                <option value='MAMOGRAFIA' <?
                    if (@$obj->_grupo == 'MAMOGRAFIA'):echo 'selected';
                    endif;
                    ?>>MAMOGRAFIA</option>
                                                <option value='MEDICAMENTO' <?
                    if (@$obj->_grupo == 'MEDICAMENTO'):echo 'selected';
                    endif;
                    ?>>MEDICAMENTO</option>
                                                <option value='PSICOLOGIA' <?
                    if (@$obj->_grupo == 'PSICOLOGIA'):echo 'selected';
                    endif;
                    ?>>PSICOLOGIA</option>
                                                <option value='RM' <?
                    if (@$obj->_grupo == 'RM'):echo 'selected';
                    endif;
                    ?>>RM</option>
                                                <option value='RX' <?
                    if (@$obj->_grupo == 'RX'):echo 'selected';
                    endif;
                    ?>>RAIOX</option>
                                                <option value='US'<?
                    if (@$obj->_grupo == 'US'):echo 'selected';
                    endif;
                    ?> >US</option>
                                                <option value='TOMOGRAFIA'<?
                    if (@$obj->_grupo == 'TOMOGRAFIA'):echo 'selected';
                    endif;
                    ?> >TOMOGRAFIA</option>
                    
                                            </select>
                                        </dd>-->
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
                    <dt>
                        <label>Qtde de sess&otilde;es</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtqtde" class="texto" value="<?= @$obj->_qtde; ?>" />
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


    $(function () {
        $("#accordion").accordion();
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