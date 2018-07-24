<?
if (count(@$informacao_aso[0]->impressao_aso) > 0) {
    $config = json_decode(@$informacao_aso[0]->impressao_aso);
} else {
    $config = '';
}
?>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3>Cadastro ASO</h3>
    <!--<div style="width: 100%">-->
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/guia/gravarcadastroaso/<?= @$paciente[0]->paciente_id ?>/<?=@$medico_id?>" method="post">
        <!--                <fieldset>
                            <legend>Nome</legend>
                            <input type="text" id="nome" name="nome" value="<?= @$config->nome ?>"/>
                            
                
                        </fieldset>-->

        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome</label>                      
                <input readonly="" type="text" id="txtNome" name="nome_paciente"  class="texto09" value="<?= $paciente[0]->nome ?>" />
                <input type="hidden" id="txtPacienteId" name="txtPacienteId"  class="texto09" value="<?= @$paciente[0]->paciente_id ?>"/>
                <input type="hidden" id="cadastro_aso_id" name="cadastro_aso_id"  class="texto09" value="<?= @$informacao_aso[0]->cadastro_aso_id ?>"/>
            </div>
            <div>
                <label>Sexo</label>
                <select disabled="" name="sexo" id="txtSexo" class="size2" required="">
                    <option value="" <?
                    if (@$paciente[0]->sexo == ""):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value="M" <?
                    if (@$paciente[0]->sexo == "M"):echo 'selected';
                    endif;
                    ?>>Masculino</option>
                    <option value="F" <?
                    if (@$paciente[0]->sexo == "F"):echo 'selected';
                    endif;
                    ?>>Feminino</option>
                    <option value="O" <?
                    if (@$paciente[0]->sexo == "O"):echo 'selected';
                    endif;
                    ?>>Outro</option>
                </select>

            </div>
            <div>
                <label>DT de nascimento</label>

                <input readonly type="text" name="nascimento" id="nascimento" alt="date" value="<?= (@$paciente[0]->nascimento != '') ? date("d/m/Y", strtotime(@$paciente[0]->nascimento)) : ''; ?>"  class="texto02" maxlength="10" value="" required=""/>
            </div>
            <div>
                <label>Idade</label>

                <input readonly="" type="text" onblur="calculoIdade()" name="idade"  id="idade" class="texto02"   maxlength="10" value="<?php echo substr(@$paciente[0]->nascimento, 8, 2) . '/' . substr(@$paciente[0]->nascimento, 5, 2) . '/' . substr(@$paciente[0]->nascimento, 0, 4); ?>" required=""/>
            </div>

            <!--            <div>
                            <label>Nome do Paciente</label>
                            <input type="text" name="grau_parentesco" id="grau_parentesco" class="texto04"  />
                        </div>-->


        </fieldset>
        <fieldset>
            <legend>Informações</legend>

            <div>
                <label>Tipo</label>
                <select id="paciente_agressivo" name="tipo"  class="size02" >
                    <option value="">
                        Selecione
                    </option>
                    <option value="ADMISSIONAL" <?= (@$informacao_aso[0]->tipo == 'ADMISSIONAL') ? 'selected' : ''; ?>>
                        ADMISSIONAL
                    </option>
                    <option value="PERÍODICO" <?= (@$informacao_aso[0]->tipo == 'PERÍODICO') ? 'selected' : ''; ?>>
                        PERÍODICO
                    </option>
                    <option value="RETORNO AO TRABALHO" <?= (@$informacao_aso[0]->tipo == 'RETORNO AO TRABALHO') ? 'selected' : ''; ?>>
                        RETORNO AO TRABALHO
                    </option>
                    <option value="MUDANÇA DE FUNÇÃO" <?= (@$informacao_aso[0]->tipo == 'MUDANÇA DE FUNÇÃO') ? 'selected' : ''; ?>>
                        MUDANÇA DE FUNÇÃO
                    </option>
                    <option value="DEMISSIONAL" <?= (@$informacao_aso[0]->tipo == 'DEMISSIONAL') ? 'selected' : ''; ?>>
                        DEMISSIONAL
                    </option>
                </select>

            </div>



            <div>
                <label>Empresa</label>
                <input type="text" name="empresa" id="empresa" class="texto09" value="<?= @$config->empresa ?>" />
            </div>

            <div>
                <label>Setor</label>
                <input type="text" name="setor" id="setor" class="texto04" value="<?= @$config->setor ?>" />
            </div>
            <div>
                <label>Função</label>
                <input type="text" name="funcao" id="funcao" class="texto04" value="<?= @$config->funcao ?>" />
            </div>
            <div>
                <label>Riscos Ocupacionais Específicos</label>
                <input type="text" name="riscos_ocupacionais" id="riscos_ocupacionais" class="texto09" value="<?= @$config->riscos_ocupacionais ?>" />
            </div>
            <div>
                <label>Data De Realização</label>
                <input type="text" name="data_realizacao" id="data_realizacao" class="texto04" value="<?= @$config->data_realizacao ?>" />
            </div>

            <!--            <div>
                            <label>Nome do Paciente</label>
                            <input type="text" name="grau_parentesco" id="grau_parentesco" class="texto04"  />
                        </div>-->


        </fieldset>
        <fieldset>
            <legend>Avaliação Clínica</legend>
            <textarea name="avaliacao_clinica" style="height: 300px;" id="avaliacao_clinica"><?= @$config->avaliacao_clinica ?></textarea>
            <div style="width: 100%;">
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </div>

        </fieldset>

        <fieldset>
            <legend>Aptidões</legend>
            <div>

                <label title="O funcionário acima, foi submetido(a) a exame médico, conforme a NR 07, sendo considerado:">NR7 (?) </label>
                <select name="questao_um" id="questao_um" class="texto04" required="" title="O funcionário acima, foi submetido(a) a exame médico, conforme a NR 07, sendo considerado:" >
                    <option value="">Selecione</option>
                    <option value="APTO" <?= (@$config->questao_um == 'APTO') ? 'selected' : '' ?>>APTO</option>
                    <option value="INAPTO" <?= (@$config->questao_um == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>

                </select>
            </div>
            <div>

                <label title="NR 35 - Quanto a obrigatoriedade de constar no ASO do funcionário se ele é mapeado para Trabalho em Altura
                       NR 35.4.1.2.1 - A Aptidão para Trabalho em Altura deve ser consignada no atestado de saúde ocupacional do trabalhador ">NR35, NR 35.4.1.2.1</label>
                <select name="questao_dois" id="questao_dois" class="texto04" required="" title="NR 35 - Quanto a obrigatoriedade de constar no ASO do funcionário se ele é mapeado para Trabalho em Altura
                        NR 35.4.1.2.1 - A Aptidão para Trabalho em Altura deve ser consignada no atestado de saúde ocupacional do trabalhador ">
                    <option value="">Selecione</option>
                    <option value="APTO" <?= (@$config->questao_dois == 'APTO') ? 'selected' : '' ?>>APTO</option>
                    <option value="INAPTO" <?= (@$config->questao_dois == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>
                    <option value="NÃO MAPEADO" <?= (@$config->questao_dois == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                </select>
            </div>
            <div>

                <label title="NR 33 - Segurança e Saúde nos Trabalhos em Espaços Confinados conforme item 33.3.4.1">NR 33 </label>
                <select name="questao_tres" id="questao_tres" class="texto04" required="" title="NR 33 - Segurança e Saúde nos Trabalhos em Espaços Confinados conforme item 33.3.4.1">
                    <option value="">Selecione</option>
                    <option value="APTO" <?= (@$config->questao_tres == 'APTO') ? 'selected' : '' ?>>APTO</option>
                    <option value="INAPTO" <?= (@$config->questao_tres == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>
                    <option value="NÃO MAPEADO" <?= (@$config->questao_tres == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                </select>
            </div>
            <div>

                <label>APTIDÃO MÁQUINAS MÓVEIS </label>
                <select name="questao_quatro" id="questao_quatro" class="texto04" required="">
                    <option value="">Selecione</option>
                    <option value="APTO" <?= (@$config->questao_quatro == 'APTO') ? 'selected' : '' ?>>APTO PARA OPERAR MÁQUINAS MÓVEIS</option>
                    <option value="INAPTO" <?= (@$config->questao_quatro == 'INAPTO') ? 'selected' : '' ?>>INAPTO PARA OPERAR MÁQUINAS MÓVEIS</option>
                    <option value="NÃO MAPEADO" <?= (@$config->questao_quatro == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                </select>
            </div>
            <div>

                <label title="NR 10 - Segurança em Instalações e Serviços em Eletricidade conforme item 10.8.7">NR 10 </label>
                <select name="questao_cinco" id="questao_cinco" class="texto04" required="" title="NR 10 - Segurança em Instalações e Serviços em Eletricidade conforme item 10.8.7">
                    <option value="">Selecione</option>
                    <option value="APTO" <?= (@$config->questao_cinco == 'APTO') ? 'selected' : '' ?>>APTO</option>
                    <option value="INAPTO" <?= (@$config->questao_cinco == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>
                    <option value="NÃO MAPEADO" <?= (@$config->questao_cinco == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>

                </select>
            </div>



        </fieldset>
        <fieldset>
            <?if(@$informacao_aso[0]->medico_responsavel != ''){?>
                 <input type="hidden" name="medico_responsavel" id="medico_responsavel" class="texto04" value="<?= @$informacao_aso[0]->medico_responsavel ?>" />
            <?}else{?>
                 <input type="hidden" name="medico_responsavel" id="medico_responsavel" class="texto04" value="<?=@$medico_id ?>" />
            <?}?>
             
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
                        $("#data_realizacao").datepicker({
                            autosize: true,
                            changeYear: true,
                            changeMonth: true,
                            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                            buttonImage: '<?= base_url() ?>img/form/date.png',
                            dateFormat: 'dd/mm/yy'
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

<? if (@$config->paciente_id == NULL) { ?>
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
