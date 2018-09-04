<div >

    <?
//    var_dump($padrao[0]->texto);
//    die;


    if (@$obj->_texto == "") {

        foreach ($padrao as $item) {
            @$obj->_texto = $item->texto;
        }
    }




    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarlaudodigitador/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>" method="post">
            <div >
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr><td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <td>Solicitante: <?= @$obj->_solicitante ?></td>
                            <td rowspan="2"><img src="<?= base_url() ?>upload/webcam/pacientes/<?= $paciente_id ?>.jpg" width="100" height="100" /></td>
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                            <td>Sala:<?= @$obj->_sala ?></td>
                            
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div>

                <fieldset>
                    <legend>Laudo</legend>
                    <div>
                        <?
                        if (@$obj->_cabecalho == "") {
                            $cabecalho = @$obj->_procedimento;
                        } else {
                            $cabecalho = @$obj->_cabecalho;
                        }
                        ?>
                        <label>Nome do Laudo</label>
                        <input type="text" id="cabecalho" class="texto10" name="cabecalho" value="<?= $cabecalho ?>"/>
                    </div>
                    <div>
                        <label>Laudo</label>
                        <select name="exame" id="exame" class="size2" >
                            <option value='' >selecione</option>
                            <?php foreach ($lista as $item) { ?>
                                <option value="<?php echo $item->ambulatorio_modelo_laudo_id; ?>" ><?php echo $item->nome; ?></option>
                            <?php } ?>
                        </select>

                        <label>Linha</label>
                        <input type="text" id="linha2" class="texto02" name="linha2"/>
<!--                        <select name="linha" id="linha" class="size2" >
                            <option value='' >selecione</option>
                        <?php foreach ($linha as $item) { ?>
                                                                                                <option value="<?php echo $item->nome; ?>" ><?php echo $item->nome; ?></option>
                        <?php } ?>
                        </select>-->


                    </div>
                    <div>
                        <textarea id="laudo" name="laudo" rows="18" cols="85"> <?= @$obj->_texto; ?></textarea>
                    </div>
                    <div>
                        <label>M&eacute;dico respons&aacutevel</label>
                        <select name="medico" id="medico" class="size2">
                            <option value=0 >selecione</option>
                            <? foreach ($operadores as $value) : ?>
                                <option value="<?= $value->operador_id; ?>"<?
                            if (@$obj->_medico_parecer1 == $value->operador_id):echo 'selected';
                            endif;
                                ?>><?= $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                        <?php
                        if (@$obj->_revisor == "t") {
                            ?>
                            <input type="checkbox" name="revisor" checked ="true" /><label>Revisor</label>
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="revisor"  /><label>Revisor</label>
                            <?php
                        }
                        ?>
                        <input type="checkbox" name="carimbo" id="carimbo" <? //=(@$obj->_carimbo == 't')? 'checked': '';?> /><label>Carimbo</label>
                        <select name="medicorevisor" id="medicorevisor" class="size2">
                            <option value="">Selecione</option>
                            <? foreach ($operadores as $valor) : ?>
                                <option value="<?= $valor->operador_id; ?>"<?
                            if (@$obj->_medico_parecer2 == $valor->operador_id):echo 'selected';
                            endif;
                                ?>><?= $valor->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                        <?php
                        if (@$obj->_assinatura == "t") {
                            ?>
                            <input type="checkbox" name="assinatura" checked ="true" /><label>Assinatura</label>
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="assinatura"  /><label>Assinatura</label>
                            <?php
                        }
                        ?>

                        <?php
                        if (@$obj->_rodape == "t") {
                            ?>
                            <input type="checkbox" name="rodape" checked ="true" /><label>Rodape</label>
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="rodape"  /><label>Rodape</label>
                            <?php
                        }
                        ?>


                        <label>situa&ccedil;&atilde;o</label>
                        <select name="situacao" id="situacao" class="size2" onChange="muda(this)">
                            <option value='DIGITANDO'<?
                        if (@$obj->_status == 'DIGITANDO'):echo 'selected';
                        endif;
                        ?> >DIGITANDO</option>
                            <option value='FINALIZADO' <?
                            if (@$obj->_status == 'FINALIZADO'):echo 'selected';
                            endif;
                        ?> >FINALIZADO</option>
                        </select>
                    </div>
                    <div>
                        <label id="titulosenha">Senha</label>
                        <input type="password" name="senha" id="senha" class="size1" />
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Impress&atilde;o</legend>
                    <div>
                        <table>
                            <tr>
                                <td >
                                    <div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                            <font size="-1"> Imprimir</font></a></div></td>
                                <td ><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                            <font size="-1"> fotos</font></a></div></td>
                                <td ><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/pesquisarlaudoantigo');">
                                            <font size="-1">L. Antigo</font></a></div></td>
                                <td ><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $ambulatorio_laudo_id ?>');" >
                                            <font size="-1">Arquivos</font></a></div></td>
                                <td ><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/oit/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>');" >
                                            <font size="-1">OIT</font></a></div></td>
                            </tr>
                        </table>
                    </div>
                    <div>


                        <!--<input name="textarea" id="textarea"></input>
                   <!-- <input name="textarea" id="textarea" ></input>-->

                        <hr/>

                        <button type="submit" name="btnEnviar">Salvar</button>
                    </div>
                </fieldset>
        </form>

    </div> 
</div> 
</div> 
</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

                            document.getElementById('titulosenha').style.display = "none";
                            document.getElementById('senha').style.display = "none";

                            document.form_laudo.linha2.focus()

                            $(document).ready(function() {
                                $("body").keypress(function(event) {
                                    if (event.keyCode == 119)   // se a tecla apertada for 13 (enter)
                                    {
                                        window.open("<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>"); // abre uma janela
                                    }
                                    if (event.keyCode == 121)   // se a tecla apertada for 13 (enter)
                                    {
                                        document.form_laudo.submit()
                                    }
                                });
                            });

                            $(document).ready(function() {
                                jQuery('#ficha_laudo').validate({
                                    rules: {
                                        imagem: {
                                            required: true
                                        }
                                    },
                                    messages: {
                                        imagem: {
                                            required: "*"
                                        }
                                    }
                                });
                            });

                            $(function () {
                                $('#carimbo').change(function () {
                            //                                                                            alert('adasd');
                                    if ($(this).prop('checked') == true) {
                                        //$('#laudo').hide();
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/carimbomedico', {medico_id: $('#medico').val(), ajax: true}, function (j) {
                                            options = "";

                                            options += j[0].carimbo;
                                            tinyMCE.triggerSave(true, true);
                                            document.getElementById("laudo").value = $('#laudo').val() + j[0].carimbo;
                                            $('#laudo').val() + j[0].carimbo;
                                            var ed = tinyMCE.get('laudo');
                                            ed.setContent($('#laudo').val());
                                        });
                                    } else {
                                        //$('#laudo').html('value=""');
                                    }
                                });
                            });



                            function muda(obj) {
                                if (obj.value != 'DIGITANDO') {
                                    document.getElementById('titulosenha').style.display = "block";
                                    document.getElementById('senha').style.display = "block";
                                } else {
                                    document.getElementById('titulosenha').style.display = "none";
                                    document.getElementById('senha').style.display = "none";
                                }
                            }



                            tinyMCE.init({
                                // General options
                                mode: "textareas",
                                theme: "advanced",
                                plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                                // Theme options
                                theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,pagebreak,|,search,replace,|,bullist,numlist,,undo,redo,|,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
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

                            $(function() {
                                $('#exame').change(function() {
                                    if ($(this).val()) {
                                        //$('#laudo').hide();
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/modeloslaudo', {exame: $(this).val(), ajax: true}, function(j) {
                                            options = "";

                                            options += j[0].texto;
                                            //                                                document.getElementById("laudo").value = options

                                            $('#laudo').val(options)
                                            var ed = tinyMCE.get('laudo');
                                            ed.setContent($('#laudo').val());

                                            //$('#laudo').val(options);
                                            //$('#laudo').html(options).show();
                                            //                                                $('.carregando').hide();
                                            //history.go(0) 
                                        });
                                    } else {
                                        $('#laudo').html('value=""');
                                    }
                                });
                            });

                            $(function() {
                                $('#linha').change(function() {
                                    if ($(this).val()) {
                                        //$('#laudo').hide();
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/modeloslinhas', {linha: $(this).val(), ajax: true}, function(j) {
                                            options = "";

                                            options += j[0].texto;
                                            //                                                document.getElementById("laudo").value = $('#laudo').val() + options
                                            $('#laudo').val() + options
                                            var ed = tinyMCE.get('laudo');
                                            ed.setContent($('#laudo').val());
                                            //$('#laudo').html(options).show();
                                        });
                                    } else {
                                        $('#laudo').html('value=""');
                                    }
                                });
                            });

                            $(function() {
                                $("#linha2").autocomplete({
                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=linhas",
                                    minLength: 1,
                                    focus: function(event, ui) {
                                        $("#linha2").val(ui.item.label);
                                        return false;
                                    },
                                    select: function(event, ui) {
                                        $("#linha2").val(ui.item.value);
                                        tinyMCE.triggerSave(true, true);
                                        document.getElementById("laudo").value = $('#laudo').val() + ui.item.id
                                        $('#laudo').val() + ui.item.id
                                        var ed = tinyMCE.get('laudo');
                                        ed.setContent($('#laudo').val());
                                        //$( "#laudo" ).val() + ui.item.id;
                                        document.getElementById("linha2").value = ''
                                        return false;
                                    }
                                });
                            });

                            $(function(a) {
                                $('#anteriores').change(function() {
                                    if ($(this).val()) {
                                        //$('#laudo').hide();
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/laudosanteriores', {anteriores: $(this).val(), ajax: true}, function(i) {
                                            option = "";

                                            option = i[0].texto;
                                            tinyMCE.triggerSave();
                                            document.getElementById("laudo").value = option
                                            //$('#laudo').val(options);
                                            //$('#laudo').html(options).show();
                                            $('.carregando').hide();
                                            history.go(0)
                                        });
                                    } else {
                                        $('#laudo').html('value="texto"');
                                    }
                                });
                            });
                            //bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                            $('.jqte-test').jqte();








</script>


<? if ($mensagem == 2) { ?>
    <script type="text/javascript">
        alert("Sucesso ao finalizar Laudo");
    </script>
<?
}
if ($mensagem == 1) {
    ?>
    <script type="text/javascript">
        alert("Erro ao finalizar Laudo");
    </script>
    <?
}