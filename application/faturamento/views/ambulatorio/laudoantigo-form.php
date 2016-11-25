<div >

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarlaudo/<?= $id ?>" method="post">
            <div >
                <fieldset>

                            <div>

                                <fieldset>
                                    <legend>Laudo</legend>

                                        <label>Nome do Laudo</label>
                                        <input type="text" id="cabecalho" class="texto10" name="cabecalho" value="<?= $laudo['0']->nomeexame ?>"/>
                                    </div>
                                    <div>
                                        <textarea id="laudo" name="laudo" rows="30" cols="80" style="width: 80%"><?= $laudo['0']->laudo; ?></textarea>
                                    </div>
                                    <div>
                                        <label>M&eacute;dico respons&aacutevel</label>
                                        <input type="text" id="cabecalho" class="texto10" name="cabecalho" value="<?= $laudo['0']->nomemedicolaudo ?>" readonly=""/>
                                    </div>
                            </fieldset>
                            <fieldset>
                                <legend>Impress&atilde;o</legend>
                                <div>
                                    <table>
                                        <tr>
                                            <td >
                                                <div class="bt_link">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $id ?>');">
                                                        <font size="-1"> Imprimir</font></a></div></td>
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
                          
     

//                                
//
//                                tinyMCE.init({
//                                    // General options
//                                    mode : "textareas",
//                                    theme : "advanced",
//                                    plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
//
//                                    // Theme options
//                                    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
//                                    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
//                                    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
//                                    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
//                                    theme_advanced_toolbar_location : "top",
//                                    theme_advanced_toolbar_align : "left",
//                                    theme_advanced_statusbar_location : "bottom",
//                                    theme_advanced_resizing : true,
//
//                                    // Example content CSS (should be your site CSS)
//                                    //                                    content_css : "css/content.css",
//                                    content_css : "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
//
//                                    // Drop lists for link/image/media/template dialogs
//                                    template_external_list_url : "lists/template_list.js",
//                                    external_link_list_url : "lists/link_list.js",
//                                    external_image_list_url : "lists/image_list.js",
//                                    media_external_list_url : "lists/media_list.js",
//                                    
//
//                                    // Style formats
//                                    style_formats : [
//                                        {title : 'Bold text', inline : 'b'},
//                                        {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
//                                        {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
//                                        {title : 'Example 1', inline : 'span', classes : 'example1'},
//                                        {title : 'Example 2', inline : 'span', classes : 'example2'},
//                                        {title : 'Table styles'},
//                                        {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
//                                    ],
//
//                                    // Replace values for the template plugin
//                                    template_replace_values : {
//                                        username : "Some User",
//                                        staffid : "991234"
//                                    }
//
//                                });
    

                            </script>