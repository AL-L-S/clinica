<div >

            <?
                            $dataFuturo = date("Y-m-d");
                            $dataAtual = @$obj->_nascimento;
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%Ya %mm %dd');
    ?>
    
    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarlaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>" method="post">
            <div >
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr><td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <td>Solicitante: <?= @$obj->_solicitante ?></td>
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                            <td>Sala:<?= @$obj->_sala ?></td>
                        </tr>
                    </table>
                </fieldset>
                <?
                $i = 0;
                if ($arquivo_pasta != false):
                    foreach ($arquivo_pasta as $value) {
                        $i++;
                    }
                endif
                ?>
                <fieldset>
                    <legend>Imagens : <font size="2"><b> <?= $i ?></b></legend>
                    <ul id="sortable">
                    <?
                    
                    if ($arquivo_pasta != false):
                        foreach ($arquivo_pasta as $value) {
                            ?>
                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/alterarnomeimagem/" . $exame_id . "/" . $value ?> ','_blank','toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></a></li>
                            <?
                        }
                    endif
                    ?>
                    </ul>
                    <!--                <ul id="sortable">
                    <?
                    if ($arquivo_pasta != false):
                        foreach ($arquivo_pasta as $value) {
                            ?>
                                                                                <li class="ui-state-default"> <input type="hidden"  value="<?= $value ?>" name="teste[]" class="size2" /><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></li>
                            <?
                        }
                    endif
                    ?>
                                    </ul>-->
                </fieldset>
                <table>
                    <tr><td width="60px;"><center>
                        <div class="bt_link_new">
                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/galeria/" . $exame_id ?> ','_blank','toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                <font size="-1"> vizualizar imagem</font>
                            </a>
                        </div>
                        </td>
                        <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/exame/anexarimagemmedico/" . $exame_id . "/" . @$obj->_sala_id; ?> ','_blank','toolbar=no,Location=no,menubar=yes,width=1200,height=400');">
                                   <font size="-1"> adicionar/excluir</font>
                                </a>
                            </div></center>
                        </td>
                        <td width="250px;"><font size="-2"><center>
                            <div>
                                <h4>Imagens por pagina</h4>
                                <?
//                    var_dump(@$obj->_quantidade);
//                    die;

                                if (@$obj->_imagens == "1") {
                                    ?>
                                    <label><input type="radio" value="1" name="imagem" class="radios3" checked ="true"/>oi jorge  1</label>
                                <? } else { ?>
                                    <label><input type="radio" value="1" name="imagem" class="radios3" />1</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "2") { ?>
                                    <label><input type="radio" value="2" name="imagem" class="radios3" checked ="true"/> 2</label>
                                <? } else { ?>
                                    <label><input type="radio" value="2" name="imagem" class="radios3" /> 2</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "3") { ?>
                                    <label><input type="radio" value="3" name="imagem" class="radios3" checked ="true"/> 3</label>
                                <? } else { ?>
                                    <label><input type="radio" value="3" name="imagem" class="radios3" /> 3</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "4") { ?>
                                    <label><input type="radio" value="4" name="imagem" class="radios3" checked ="true"/> 4</label>
                                <? } else { ?>
                                    <label><input type="radio" value="4" name="imagem" class="radios3" /> 4</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "5") { ?>
                                    <label><input type="radio" value="5" name="imagem" class="radios3" checked ="true"/> 5</label>
                                <? } else { ?>
                                    <label><input type="radio" value="5" name="imagem" class="radios3" /> 5</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "6") { ?>
                                    <label><input type="radio" value="6" name="imagem" class="radios3" checked ="true"/> 6</label>
                                <? } else { ?>
                                    <label><input type="radio" value="6" name="imagem" class="radios3" /> 6</label>
                                <? } ?>
                            </div>
                            </font></center></td>
                        <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolaudo"; ?> ','_blank','toolbar=no,Location=no,menubar=no,width=900,height=650 ');">
                                    <font size="-1">laudo Modelo</font>
                                </a>
                            </div>
                            </td>
                            <td width="60px;"><center>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolinha"; ?> ','_blank','toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                      <font size="-1">  Linha Modelo </font>
                                    </a>
                                </div></center>
                            </td>
                            </table>

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
                                                <option value="<?php echo $item->nome; ?>" ><?php echo $item->nome; ?></option>
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

                                        <label>Laudos anteriores</label>
                                        <select name="anteriores" id="anteriores" onclick="alerta()" class="size2" >
                                            <option value='' >selecione</option>
                                            <?php foreach ($laudos_anteriores as $itens) { ?>
                                                <option value="<?php echo $itens->ambulatorio_laudo_id; ?>" ><?php echo $itens->nome . " " . substr($itens->data_cadastro, 8, 2) . "-" . substr($itens->data_cadastro, 5, 2) . "-" . substr($itens->data_cadastro, 0, 4); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div>
                                        <textarea id="laudo" name="laudo" rows="30" cols="80" style="width: 90%"><?= @$obj->_texto; ?></textarea>
                                        <!--<textarea id="laudo" name="laudo" class="jqte-test" ><?= @$obj->_texto; ?></textarea>-->
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
                                        <label>situa&ccedil;&atilde;o</label>
                                        <select name="situacao" id="situacao" class="size2" >
                                            <option value='DIGITANDO'<?
if (@$obj->_status == 'DIGITANDO'):echo 'selected';
endif;
?> >DIGITANDO</option>
                                            <option value='FINALIZADO' <?
if (@$obj->_status == 'FINALIZADO'):echo 'selected';
endif;
?> >FINALIZADO</option>
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
                                        <select name="medicorevisor" id="medicorevisor" class="size2">
                                            <option value="">Selecione</option>
                                            <? foreach ($operadores as $valor) : ?>
                                                <option value="<?= $valor->operador_id; ?>"<?
                                                    if (@$obj->_medico_parecer2 == $valor->operador_id):echo 'selected';
                                                    endif;
                                                    ?>><?= $valor->nome; ?></option>
                                    <? endforeach; ?>
                                        </select>
                                        <span class="espec spanClass">Senha</span>
                                        <input type="text" name="senha" id="senha" class="size2" />
                                    </div>
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
                            <style>
                                #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
                                #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
                            </style>
                            <meta http-equiv="content-type" content="text/html;charset=utf-8" />
<!--                            <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />-->
<!--                            <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />-->
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
                            <script type="text/javascript">
    
                                $(document).ready(function(){ 
                                    $('#sortable').sortable();
                                });
    

                                $(document).ready(function(){
                                    jQuery('#ficha_laudo').validate( {
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

tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Example content CSS (should be your site CSS)
        content_css : "css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        // Style formats
        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}

    });

                                $(function(){
                                    $('#exame').change(function(){
                                        if( $(this).val() ) {
                                            //$('#laudo').hide();
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/modeloslaudo',{exame:$(this).val(), ajax:true}, function(j){
                                                options =  "";
                    
                                                options += j[0].texto;
                                                tinyMCE.triggerSave();
                                                document.getElementById("laudo").value = options
                                                //$('#laudo').val(options);
                                                //$('#laudo').html(options).show();
                                                $('.carregando').hide();
                                                history.go(0) 
                                            });
                                        } else {
                                            $('#laudo').html('value=""');
                                        }
                                    });
                                });

                                $(function(){
                                    $('#linha').change(function(){
                                        if( $(this).val() ) {
                                            //$('#laudo').hide();
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/modeloslinhas',{linha:$(this).val(), ajax:true}, function(j){
                                                options =  "";
                    
                                                options += j[0].texto;
                                                tinyMCE.triggerSave();
                                                document.getElementById("laudo").value = $('#laudo').val() + options
                                                //$('#laudo').val(options);
                                                //$('#laudo').html(options).show();
                                                $('.carregando').hide();
                                                history.go(0) 
                                            });
                                        } else {
                                            $('#laudo').html('value=""');
                                        }
                                    });
                                });

                                $(function() {
                                    $( "#linha2" ).autocomplete({
                                        source: "<?= base_url() ?>index?c=autocomplete&m=linhas",
                                        minLength: 1,
                                        focus: function( event, ui ) {
                                            $( "#linha2" ).val( ui.item.label );
                                            return false;
                                        },
                                        select: function( event, ui ) {
                                            $( "#linha2" ).val( ui.item.value );
                                            tinyMCE.triggerSave(true, true);
                                            document.getElementById("laudo").value = $('#laudo').val() + ui.item.id
                                            //$( "#laudo" ).val() + ui.item.id;
                                            document.getElementById("linha2").value = ''
                                            history.go(0)
                                            return false;
                                        }
                                    });
                                });

                                $(function alerta(){
                                    $('#anteriores').change(function(){
//                                        if( $(this).val() ) {
//                                            //$('#laudo').hide();
//                                            $('.carregando').show();
//                                            $.getJSON('<?= base_url() ?>autocomplete/laudosanteriores',{anteriores:$(this).val(), ajax:true}, function(i){
//                                                option =  "";
//                                                option = i[0].texto;
//                                                
//                                                //$('#laudo').val(options);
//                                                //$('#laudo').html(options).show();
//                                            });
//                                            
//                                        } 
                                        alert("oi");
                                    });
                                });
                                //bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                                $('.jqte-test').jqte();

    


    
    
    

                            </script>