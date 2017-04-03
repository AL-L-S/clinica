<?php
// User session value 
$session_id = '1';
//$bdcon = pg_connect("host=localhost port=5432 dbname=clinica user=postgres password=123456");
////conecta a um banco de dados chamado "cliente"
//
//$con_string = "host=localhost port=5432 dbname=clinica user=postgres password=123456";
//$result = pg_query($bdcon, "INSERT INTO newsfeed (user_id_fk, audioMessage) VALUES ( $session_id, '2')");
//
//
//if(!$dbcon = pg_connect($con_string)){
//    echo 'ok';
//    die;
//}else{
//    echo 'nao';
//    die;
//}

?>
<!-- APARENTEMENTE O PROBLEMA É PORQUE NO ARQUIVO recorder.js NÃO ESTÁ INVOCANDO O WORKER recorderWorker.js -->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>voz</title>
        <meta content='width=device-width, initial-scale=1' name='viewport'/>
        <link type='text/css' rel='stylesheet' href="<?= base_url() ?>css/record.css" />
        <script src="<?= base_url() ?>js/recorderControl.js"></script>
        <script src="<?= base_url() ?>js/recorderWorker.js"></script>
        <script src="<?= base_url() ?>js/jquery.min.2.1.js"></script>
        <script src="<?= base_url() ?>js/jquery.stopwatch.js"></script>
        <script src="<?= base_url() ?>js/recorder.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("body").on('click', '.recordOn', function () {
                    $("#recordContainer").toggle();
                });
                $("#recordCircle").mousedown(function () {
                    $(this).removeClass('startRecord').addClass('stopRecord');
                    $("#recordContainer").removeClass('startContainer').addClass('stopContainer');
                    $("#recordText").html("Stop");
                    $.stopwatch.startTimer('sw');
                    startRecording(this);
                }).mouseup(function () {
                    $.stopwatch.resetTimer();
                    $(this).removeClass('stopRecord').addClass('startRecord');
                    $("#recordContainer").removeClass('stopContainer').addClass('startContainer');
                    $("#recordText").html("Record");
                    stopRecording(this);
                });
                // Utility method that will give audio formatted time
                getAudioTimeByDec = function (cTime, duration) {
                    var duration = parseInt(duration),
                            currentTime = parseInt(cTime),
                            left = duration - currentTime,
                            second, minute;
                    second = (left % 60);
                    minute = Math.floor(left / 60) % 60;
                    second = second < 10 ? "0" + second : second;
                    minute = minute < 10 ? "0" + minute : minute;
                    return minute + ":" + second;
                };
                $("body").on("click", ".audioControl", function (e) {
                    var ID = $(this).attr("id");
                    var progressArea = $("#audioProgress" + ID);
                    var audioTimer = $("#audioTime" + ID);
                    var audio = $("#audio" + ID);
                    var audioCtrl = $(this);
                    e.preventDefault();
                    var R = $(this).attr('rel');
                    if (R == 'play') {
                        $(this).removeClass('audioPlay').addClass('audioPause').attr("rel", "pause");
                        audio.trigger('play');
                    } else {
                        $(this).removeClass('audioPause').addClass('audioPlay').attr("rel", "play");
                        audio.trigger('pause');
                    }
                    // Audio Event listener, its listens audio time update events and updates Progress area and Timer area
                    audio.bind("timeupdate", function (e) {
                        var audioDOM = audio.get(0);
                        audioTimer.text(getAudioTimeByDec(audioDOM.currentTime, audioDOM.duration));
                        var audioPos = (audioDOM.currentTime / audioDOM.duration) * 100;
                        progressArea.css('width', audioPos + "%");
                        if (audioPos == "100")
                        {
                            $("#" + ID).removeClass('audioPause').addClass('audioPlay').attr("rel", "play");
                            audio.trigger('pause');
                        }
                    });
                });
            });
        </script>


    </head>
    <body>
        <audio controls>
            Your browser does not support the audio tag.
        </audio> 
        <div style="margin:0 auto; width:980px">


            <div id="wall_container" style="float:left">
                <div id="updateboxarea">
                    <b id="what">Gravar voz</b>
                    <!--<textarea name="update" id="update" ></textarea>-->
                    <input type="hidden" id="sessionValue" value="<?php echo $session_id; ?>" />
                    <div id="controlButtons">
                        <img src="<?= base_url() . "img/Microphone.png" ?>" id="recordButton" class="recordOff" > <span id="recordHelp">Microfone</span>

                        <span class="floatRight">
                            <input type="submit" value=" Update " id="update_button" class="update_button wallbutton update_box">
                        </span>
                    </div>

                    <div id="recordContainer" class="startContainer">
                        <div id="recordTime"> <span id="sw_m">00</span>:<span id="sw_s">00</span></div>
                        <div id="recordCircle" class="startRecord"><div id="recordText">Record</div></div>
                    </div>

                </div>

                <div id="loadStatus"><img src="<?= base_url() . "img/ajaxloader.gif" ?>"/> Loading...</div>
                <!-- News feed updates -->
                <div class="newsfeedContainer recordingslist">

                </div>


                <pre id="log" style="display:none"></pre>
            </div>

            <div style="float:right;width:350px">



            </div>


        </div>

    </body>
</html>
<script type="text/javascript">

    window.onload = function init() {
        try {
            // webkit shim
            window.AudioContext = window.AudioContext || window.webkitAudioContext;
            navigator.getUserMedia = (navigator.getUserMedia ||
                    navigator.webkitGetUserMedia ||
                    navigator.mozGetUserMedia ||
                    navigator.msGetUserMedia ||
                    navigator.mediaDevices.getUserMedia);
            window.URL = window.URL || window.webkitURL;

            audio_context = new AudioContext;
            __log('Audio context set up.');
            __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
//
        } catch (e) {
            alert('No web audio support in this browser!');
        }
//
        navigator.getUserMedia({audio: true}, function (stream) {
//            var video = document.querySelector('video');
//            video.src = window.URL.createObjectURL(localMediaStream);
//            video.onloadedmetadata = function (e) {
//                // Faz algo com o vídeo aqui.
//            };
            startUserMedia(stream);
        }, function (e) {
            __log('No live audio input: ' + e);
        });
    };
</script>