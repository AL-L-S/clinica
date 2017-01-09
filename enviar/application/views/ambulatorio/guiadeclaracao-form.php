<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body bgcolor="#C0C0C0">

    <? $guia = $guia_id[0]->ambulatorio_guia_id; ?>
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Declara&ccedil;&atilde;o</h3>
        <div>
            <form name="form1" id="form1" action="<?= base_url() ?>ambulatorio/guia/impressaodeclaracaoguia/<?= $guia_id[0]->ambulatorio_guia_id ?>" method="post">
                <fieldset>
                    <dl class="dl_desconto_lista">
                        <dt>
                            <label>Modelo</label>
                        </dt>
                        <dd>
                            <select name="modelo" id="modelo" class="size2" >
                                <option value='' >Selecione</option>
                                <? foreach ($modelos as $modelo) { ?>                                
                                    <option value='<?= $modelo->ambulatorio_modelo_declaracao_id ?>'>
                                        <?= $modelo->nome ?></option>
                                <? } ?>
                            </select>
                        </dd>
                        <dd>
                            <textarea id="declaracao" name="declaracao" cols="90" rows="30" ><?= $guia_id[0]->declaracao ?></textarea>
                        </dd>
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar">enviar</button>


            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    $('#btnimprimir').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/guia/impressaodeclaracaoguia');
    });


    tinyMCE.init({
        // General options
        mode: "textareas",
        theme: "advanced",
        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
        // Theme options
        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,fullscreen",
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

    $(function () {
        $('#modelo').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/modelosdeclaracao', {modelo: $(this).val()}, function (j) {
                    options = "";

                    options += j[0].texto;
                    //                                                document.getElementById("laudo").value = options

                    $('#declaracao').val(options)
                    var ed = tinyMCE.get('declaracao');
                    ed.setContent($('#declaracao').val());

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
</script>