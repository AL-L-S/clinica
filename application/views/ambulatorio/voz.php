
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Conversor: Voz para  texto</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css" />
        <style type="text/css">
            body{
                font-family: verdana;
            }
            #result{
                display: block;
                min-height: 200px;
                border: 1px solid #ccc;
                padding: 10px;
                box-shadow: 0 0 10px 0 #bbb;
                margin-bottom: 30px;
                font-size: 14px;
                line-height: 25px;
            }

            #microfoneIcone {position: relative; display: inline-block; left: 50%; margin: -2pt;}
            #microfoneIcone button {display: inline-block; margin: 1pt;}
            #on {color: green;}
            #off {color: red;}
            #microphone {display: block;font-size: 22px; border-radius: 10%; border: 1px solid black; margin-top: 1pt}
            #submit {min-height: 30px;border-radius: 10%; border: 1px solid gray; position: relative;}
            .textResult{margin-top: 20pt;}
        </style>
    </head>
    <body>
        <form action="<?= base_url() ?>ambulatorio/laudo/gravartextoconvertido" method="post">
            <h4 align="center">Conversor: Voz para  texto</h4>
            <div id="result">
                <div id="microfoneIcone">
                    <button type="button" id="microphone"><i class="fa fa-microphone" id="off" ></i></button>
                    <button type="submit" id="submit"  name="enviar" value="Enviar">SALVAR</button>
                    <input type="hidden" name="texto" value="" id="texto"/>
                    <input type="hidden" name="laudo_id" value="<?=$laudo_id?>" id="texto"/>
                    <input type="hidden" name="operador_id" value="<?=$operador_id?>" id="texto"/>
                </div>
                <hr>
                <div id="textResult">

                </div>
            </div>
        </form>


        <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
        <script type="text/javascript">
            if (!('webkitSpeechRecognition' in window)) {

                var valor = '<center><h1>O browser atual não tem suporte!</h1></center><br> \n\
                                        <div style="font-size: 16pt">Instale a extensão <a href="https://addons.mozilla.org/pt-BR/firefox/addon/open-in-chrome/" target="_blank"><span style="color: red">Open In Chrome</span></a> em seu firefox e reinicie o navegador.<br> \n\
                                        Feito isso, navegue até o Laudo, clique com o <span style="font-weight: bold">Botão Direito</span> do mouse\n\
                                        e selecione a opção "Abrir com o Google Chrome"!</div>';

                $('body form').remove();
                $('body').append(valor);
            }

            var r = document.getElementById('textResult');

//                if ('webkitSpeechRecognition' in window) {
            var speechRecognizer = new webkitSpeechRecognition();
            speechRecognizer.continuous = true;
            speechRecognizer.maxAlternatives = 10;
            speechRecognizer.interimResults = true;
            speechRecognizer.lang = 'pt-BR';

            var finalTranscripts = '';

            speechRecognizer.onresult = function (event) {
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
                r.innerHTML = finalTranscripts + '<span style="color:#999">' + interimTranscripts + '</span>';
                $('#texto').val(finalTranscripts + interimTranscripts);
            };

            speechRecognizer.onerror = function (event) {

            };
            
            speechRecognizer.onend = function (event) {
                
            };


            function stopConverting() {
                speechRecognizer.stop();
            }

            function startConverting() {
                speechRecognizer.start();
            }

            jQuery(function () {
                $("#off").live('click', function () {
                    jQuery(".fa.fa-microphone").attr("id", 'on');
                    startConverting();
                });
            });

            jQuery(function () {
                $("#on").live('click', function () {
                    jQuery(".fa.fa-microphone").attr("id", 'off');
                    stopConverting();
                });
            });



        </script>
    </body>
</html>