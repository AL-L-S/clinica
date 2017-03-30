 /*
License (MIT)

Copyright © 2013 Matt Diamond
Modified by Srinivas Tamada http://www.9lessons.info

*/
 
 
 function __log(e, data) {
    log.innerHTML += "\n" + e + " " + (data || '');
  }

  var audio_context;
  var recorder;

  function startUserMedia(stream) {
    var input = audio_context.createMediaStreamSource(stream);
    __log('Media stream created.' );
	__log("input sample rate " +input.context.sampleRate);
    
    input.connect(audio_context.destination);
    __log('Input connected to audio context destination.');
    
    recorder = new Recorder(input);
	$("#recordButton").removeClass("recordOff").addClass("recordOn");
	$("#recordHelp").fadeOut("slow");
	    __log('Recorder initialised.');
  }

  function startRecording(button) {
    recorder.record();
    button.disabled = true;
//    console.log(button.nextElementSibling);
//    button.nextElementSibling.disabled = false;
    __log('Recording...');
  }

  function stopRecording(button) {
    recorder.stop();
    
    button.disabled = true;
    //button.previousElementSibling.disabled = false;
    __log('Stopped recording.');
    
    // create WAV download link using audio data blob
    recorder.exportWAV();

    recorder.clear();
  }

  function createDownloadLink() {
    recorder.exportWAV(function(blob) {
//        alert('ola');
    });
  }