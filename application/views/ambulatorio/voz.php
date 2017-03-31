
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Speech to text converter in JS</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css" />
        <style type="text/css">
            /*            body{
                            font-family: verdana;
                        }
                        #result{
                            height: 200px;
                            border: 1px solid #ccc;
                            padding: 10px;
                            box-shadow: 0 0 10px 0 #bbb;
                            margin-bottom: 30px;
                            font-size: 14px;
                            line-height: 25px;
                        }
                        button{
                            font-size: 20px;
                            position: absolute;
                            top: 240px;
                            left: 50%;
                        }*/
        </style>
    </head>
    <body>
        <form>
            <h4 align="center">Conversor: Voz para  texto</h4>

            <div id="result">
                <textarea id="textarea" name="textarea" rows="30" cols="80" style="width: 80%"></textarea>
            </div>

            <button type="button" onclick="startConverting();"><i class="fa fa-microphone"></i></button>
        </form>


        <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
        <script type="text/javascript">
                tinyMCE.init({
                    // General options
                    mode: "textareas",
                    theme: "advanced",
                    plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                    // Theme options
                    theme_advanced_buttons1: "bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
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

                var content = document.getElementById('textarea');

                function startConverting() {
                    if ('webkitSpeechRecognition' in window) {
                        var speechRecognizer = new webkitSpeechRecognition();
                        speechRecognizer.continuous = true;
                        speechRecognizer.maxAlternatives = 10;
                        speechRecognizer.interimResults = true;
                        speechRecognizer.lang = 'pt-BR';
                        speechRecognizer.start();

                        var finalTranscripts = '';

                        speechRecognizer.onresult = function (event) {
                            // alert('ola');
                            var interimTranscripts = '';
                            for (var i = event.resultIndex; i < event.results.length; i++) {
                                var transcript = event.results[i][0].transcript;
                                transcript.replace("\n", "<br>");
                                if (event.results[i].isFinal) {
                                    finalTranscripts += transcript;
                                } else {
                                    interimTranscripts += transcript;
                                }
                            }
                            var valor = finalTranscripts + '<span style="color:#999">' + interimTranscripts + '</span>';
//                            tinyMCE.triggerSave(true, true);
                            document.getElementById("textarea").value = valor;
                            var ed = tinyMCE.get('textarea');
                            ed.setContent($('#textarea').val());
                        };

                        speechRecognizer.onerror = function (event) {
                        };
                    } else {
                        var valor = '<center><h1>O browser atual não tem suporte!</h1></center><br> \n\
                        Instale a extensão <span style="color: red">Open In Chrome</span> em seu firefox e reinicie o navegador.<br> \n\
                        Feito isso, navegue até o Laudo, clique com o <span style="font-weight: bold">Botão Direito</span> do mouse\n\
                        e selecione a opção "Abrir com o Google Chrome"!';

                        tinyMCE.triggerSave(true, true);
                        document.getElementById("textarea").value = $('#textarea').val() + valor;
                        var ed = tinyMCE.get('textarea');
                        ed.setContent($('#textarea').val());
                    }
                }



        </script>
    </body>
</html>