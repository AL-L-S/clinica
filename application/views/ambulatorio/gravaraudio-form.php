<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Live input record and playback</title>
<style type='text/css'>
ul { list-style: none; }
#recordingslist audio { display: block; margin-bottom: 10px; }
</style>
</head>
<body>
<h1>Recorder.js simple WAV export example</h1>
<p>Make sure you are using a recent version of Google Chrome, at the moment this only works with Google Chrome Canary.</p>
<p>Also before you enable microphone input either plug in headphones or turn the volume down if you want to avoid ear splitting feedback!</p>
<button onclick="startRecording(this);">record</button>
<button onclick="stopRecording(this);" disabled>stop</button>
<h2>Recordings</h2>
<ul id="recordingslist"></ul>
<h2>Log</h2>
<pre id="log"></pre>
<script type="text/javascript" src="<?= base_url() ?>js/record.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/recorderworker.js"></script>
<script>
function __log(e, data) {
log.innerHTML += "\n" + e + " " + (data || '');
}
var audio_context;
var recorder;
function startUserMedia(localMediaStream) {
    var input = audio_context.createMediaStreamSource(localMediaStream);
    input.connect(audio_context.destination);
    recorder = new Recorder(input);
    recorder.record();
}
function startRecording(button) {
recorder && recorder.record();
button.disabled = true;
button.nextElementSibling.disabled = false;
__log('Recording...');
}
function stopRecording(button) {
recorder.stop();
button.disabled = true;
button.previousElementSibling.disabled = false;

// create WAV download link using audio data blob
createDownloadLink();
recorder.clear();
}
function createDownloadLink() {
recorder.exportWAV(function(blob) {
var url = URL.createObjectURL(blob);
var li = document.createElement('li');
var au = document.createElement('audio');
var hf = document.createElement('a');
au.controls = true;
au.src = url;
hf.href = url;
hf.download = new Date().toISOString() + '.wav';
hf.innerHTML = hf.download;
li.appendChild(au);
li.appendChild(hf);
recordingslist.appendChild(li);

});
__log('Stopped recording.');
}
window.onload = function init() {
try {
// webkit shim
window.AudioContext = window.AudioContext || window.webkitAudioContext;
navigator.getUserMedia = navigator.getUserMedia || 
          navigator.webkitGetUserMedia ||
          navigator.mozGetUserMedia || 
          navigator.msGetUserMedia;
window.URL = window.URL || window.webkitURL;
audio_context = new AudioContext;
__log('Audio context set up.');
__log('navignavigator.mozGetUserMedia  ' + (navigator.getUserMedia  ? 'available.' : 'not present!'));
} catch (e) {
alert('No web audio support in this browser!');
}
 navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
__log('No live audio input: ' + e);
});
};
</script>
</body>
</html>