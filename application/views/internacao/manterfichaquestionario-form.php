
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3>Novo Pré-Cadastro</h3>
    <!--<div style="width: 100%">-->
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>internacao/internacao/gravarfichaquestionario" method="post">
        <!--                <fieldset>
                            <legend>Nome</legend>
                            <input type="text" id="nome" name="nome" value="<?= @$config[0]->nome ?>"/>
                            
                
                        </fieldset>-->
        <fieldset>
            <legend>Dados do Responsável</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="nome_responsavel" name="nome_responsavel"  class="texto09" value="<?= @$config[0]->nome ?>"/>
                <input type="hidden" id="internacao_ficha_questionario_id" name="internacao_ficha_questionario_id" value="<?= @$internacao_ficha_questionario_id ?>"/>
            </div>



            <div>
                <label>Grau Parentesco</label>
                <input type="text" name="grau_parentesco" id="grau_parentesco" class="texto04"  value="<?= @$config[0]->grau_parentesco ?>"/>
            </div>
            <div>
                <label>Ocupação</label>
                <input type="text" name="ocupacao" id="ocupacao" class="texto04"  value="<?= @$config[0]->ocupacao_responsavel ?>"/>
            </div>
            <!--            <div>
                            <label>Nome do Paciente</label>
                            <input type="text" name="grau_parentesco" id="grau_parentesco" class="texto04"  />
                        </div>-->


        </fieldset>
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome</label>                      
                <input required="" type="text" id="txtNome" name="nome_paciente"  class="texto09" value="<?= @$config[0]->paciente ?>" />
                <input type="hidden" id="txtPacienteId" name="txtPacienteId"  class="texto09" value="<?= @$config[0]->paciente_id ?>"/>
            </div>
            <div>
                <label>Sexo</label>
                <select name="sexo" id="txtSexo" class="size2" required="">
                    <option value="" <?
                    if (@$config[0]->sexo == ""):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value="M" <?
                    if (@$config[0]->sexo == "M"):echo 'selected';
                    endif;
                    ?>>Masculino</option>
                    <option value="F" <?
                    if (@$config[0]->sexo == "F"):echo 'selected';
                    endif;
                    ?>>Feminino</option>
                    <option value="O" <?
                    if (@$config[0]->sexo == "O"):echo 'selected';
                    endif;
                    ?>>Outro</option>
                </select>

            </div>
            <div>
                <label>DT de nascimento</label>

                <input type="text" name="nascimento" id="nascimento" alt="date" value="<?= (@$config[0]->nascimento != '') ? date("d/m/Y", strtotime(@$config[0]->nascimento)) : ''; ?>"  class="texto02" maxlength="10" value=""/>
            </div>
            <div>
                <label>Idade</label>

                <input type="text" onblur="calculoIdade()" name="idade"  id="idade" class="texto02"   maxlength="10" value="<?=@$config[0]->idade?>" required=""/>
            </div>

            <!--            <div>
                            <label>Nome do Paciente</label>
                            <input type="text" name="grau_parentesco" id="grau_parentesco" class="texto04"  />
                        </div>-->


        </fieldset>
        <fieldset>
            <legend>Questionário</legend>
            <? $dependencia = $this->internacao_m->listartipodependenciaquestionario(); ?>
            <div>
                <label>Tipo de Dependência Química</label>                      
                <select name="tipo_dependencia" id="tipo_dependencia" class="texto05" required="">
                    <option value=''>Selecione</option>
                    <?php
                    foreach ($dependencia as $item) {
                        ?>
                        <option value="<?php echo $item->internacao_tipo_dependencia_id; ?>" 
                        <?
                        if (@$config[0]->tipo_dependencia == $item->internacao_tipo_dependencia_id):echo 'selected';
                        endif;
                        ?>>
                                    <?php echo $item->nome; ?>
                        </option>
                        <?php
                    }
                    ?> 
                </select>
            </div>
            <div>
                <label>Idade de Inicio</label>                      
                <input type="number" id="idade_inicio" name="idade_inicio"  class="texto02" value="<?= @$config[0]->idade_inicio ?>"/>
            </div>
            <div>
                <label>O Paciente Tem ficado agressivo?</label>
                <select id="paciente_agressivo" name="paciente_agressivo"  class="texto05" >
                    <option value="">
                        Selecione
                    </option>
                    <option value="SIM" <?= (@$config[0]->paciente_agressivo == 'SIM') ? 'selected' : ''; ?>>
                        Sim
                    </option>
                    <option value="NAO" <?= (@$config[0]->paciente_agressivo == 'NAO') ? 'selected' : ''; ?>>
                        Não
                    </option>
                </select>

            </div>
            <div>
                <label>Aceita o tratamento?</label>
                <select id="aceita_tratamento" name="aceita_tratamento"  class="texto05" required="">
                    <option value="">
                        Selecione
                    </option>
                    <option value="SIM" <?= (@$config[0]->aceita_tratamento == 'SIM') ? 'selected' : ''; ?>>
                        Sim  
                    </option>     
                    <option value="NAO" <?= (@$config[0]->aceita_tratamento == 'NAO') ? 'selected' : ''; ?>>
                        Não
                    </option>
                </select>

            </div>
            <div>
                <label>Tomou Conhecimento da Institução Como?</label>
                <select name="indicacao" id="indicacao" class="size2">
                    <option value=''>Selecione</option>
                    <?php
                    $indicacao = $this->paciente->listaindicacao($_GET);
                    foreach ($indicacao as $item) {
                        ?>
                        <option value="<?php echo $item->paciente_indicacao_id; ?>" 
                        <?
                        if (@$config[0]->tomou_conhecimento == $item->paciente_indicacao_id):echo 'selected';
                        endif;
                        ?>>
                                    <?php echo $item->nome; ?>
                        </option>
                        <?php
                    }
                    ?> 
                </select>
            </div>
            <div>
                <label>Tem plano de saúde?</label>
                <select id="plano_saude" name="plano_saude"  class="texto05" required>
                    <option value="">
                        Selecione
                    </option>
                    <option value="SIM" <?= (@$config[0]->plano_saude == 'SIM') ? 'selected' : ''; ?>>
                        Sim
                    </option>
                    <option value="NAO" <?= (@$config[0]->plano_saude == 'NAO') ? 'selected' : ''; ?>>
                        Não
                    </option>
                </select>
            </div>
            <div>
                <label>Se Sim, qual?</label>
                <select  name="convenio" id="convenio" class="texto04" required="">
                    <option value="">Selecione</option>
                    <?
                    foreach ($convenio as $item) :
                        ?>
                        <option  value="<?= $item->convenio_id; ?>" <? if (@$config[0]->convenio_id == $item->convenio_id) echo 'selected'; ?>>
                            <?= $item->nome; ?>
                        </option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Tratamentos Anteriores</label>
                <input type="text" name="tratamento_anterior" id="tratamento_anterior" class="texto09" value="<?= @$config[0]->tratamento_anterior ?>" />
            </div>
            <div>
                <label>Telefone Para Contato</label>
                <input type="text" name="telefone_contato" id="telefone_contato" class="texto04"  value="<?= @$config[0]->telefone_contato ?>"/>
            </div>
            <div>
                <label>Município</label>


                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$config[0]->municipio_id ?>" readonly="true" />
                <input required="" type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$config[0]->cidade ?>"  />
            </div>
            <!--            <div>
                            <label>Nome do Paciente</label>
                            <input type="text" name="grau_parentesco" id="grau_parentesco" class="texto04"  />
                        </div>-->


        </fieldset>
        <fieldset>
            <legend>Observações</legend>
            <textarea name="observacao" style="height: 300px;" id="observacao"><?= @$config[0]->observacao ?></textarea>
            <div style="width: 100%;">
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </div>

        </fieldset>

        <fieldset>
            <legend>Grupo</legend>
            <div>
<!--                <script>
                    
                </script>-->
                <label>Modelo Grupo</label>
                <select  name="modelo_grupo" id="modelo_grupo" class="texto04" required="">
                    <option value="-1">Selecione</option>
                    <?
                    foreach ($modelo_grupo as $item) :
                        ?>
                        <option  value="<?= $item->internacao_modelo_grupo_id; ?>">
                            <?= $item->nome; ?>
                        </option>

                    <? endforeach; ?>
                </select>
            </div>
            <textarea style="height: 300px;" name="grupo" id="grupo"><?= @$config[0]->grupo ?></textarea>
            <div style="width: 100%;">
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </div>

        </fieldset>

    </form>
    <!--</div>  Final da DIV content -->
</div> <!-- Final da DIV content -->
<style>
    textarea{
        width: 90%;
        /*font-size: 18pt;*/
        /*height: 50pt;*/
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

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
                        $('#plano_saude').change(function () {
//                                    alert($(this).val());
                            if ($(this).val() == 'SIM') {
                                $("#convenio").prop('required', true);

                            } else {
                                $("#convenio").prop('required', false);
                            }
                        });
                    });

                    function atualizagrupomodelo(id) {
                        var options = grupo_modelo[id];
                        $('#grupo').val(options)
                        var ed = tinyMCE.get('grupo');
                        ed.setContent($('#grupo').val());
                    }

                    function calculoIdade() {
                        var data = document.getElementById("nascimento").value;

                        if (data != '' && data != '//') {

                            var ano = data.substring(6, 12);
                            var idade = new Date().getFullYear() - ano;

                            var dtAtual = new Date();
                            var aniversario = new Date(dtAtual.getFullYear(), data.substring(3, 5), data.substring(0, 2));

                            if (dtAtual < aniversario) {
                                idade--;
                            }


                            document.getElementById("idade").value = idade;
                        }
                    }
                    calculoIdade();

                    jQuery("#telefone_contato")
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
                    $(function () {
                        $("#accordion").accordion();
                    });

                    $(function () {
                        $('#modelo_grupo').change(function () {
                            if ($(this).val()) {
                                //$('#laudo').hide();
//                                alert('asdasd');
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/modelosgrupo', {exame: $(this).val(), ajax: true}, function (j) {
                                    options = "";
//                                    console.log(j);
                                    options += j[0].texto;
                                    //                                                document.getElementById("laudo").value = options

                                    $('#grupo').val(options)
                                    var ed = tinyMCE.get('grupo');
                                    ed.setContent($('#grupo').val());

                                    //$('#laudo').val(options);
                                    //$('#laudo').html(options).show();
                                    //                                                $('.carregando').hide();
                                    //history.go(0) 
                                });
                            } else {
                                $('#grupo').html('value=""');
                            }
                        });
                    });

<? if (@$config[0]->paciente_id == NULL) { ?>
                        $(function () {
                            $("#txtNome").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
                                minLength: 5,
                                focus: function (event, ui) {
                                    $("#txtNome").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#txtNome").val(ui.item.value);
                                    $("#txtNomeid").val(ui.item.id);
                                    $("#txtTelefone").val(ui.item.itens);
                                    $("#txtCelular").val(ui.item.celular);
                                    $("#nascimento").val(ui.item.valor);
                                    calculoIdade();
                                    return false;
                                }
                            });
                        });
<? } ?>

                    tinyMCE.init({
                        // General options
                        mode: "textareas",
                        theme: "advanced",
                        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                        // Theme options
                        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,fullscreen",
                        theme_advanced_toolbar_location: "top",
                        theme_advanced_toolbar_align: "left",
                        theme_advanced_statusbar_location: "bottom",
                        theme_advanced_resizing: true,
                        browser_spellcheck: true,
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
