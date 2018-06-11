(function(window){
var WORKER_PATH = 'js/recorderWorker.js';
var Recorder = function(source, cfg){
var config = cfg || {};
var bufferLen = config.bufferLen || 4096;
this.context = source.context;
this.node = (this.context.createScriptProcessor ||
this.context.createJavaScriptNode).call(this.context,
bufferLen, 2, 2);
var worker = new Worker(config.workerPath || WORKER_PATH);
worker.postMessage({
command: 'init',
config: {
sampleRate: this.context.sampleRate
}
});
var recording = false,
currCallback;
this.node.onaudioprocess = function(e){
if (!recording) return;
worker.postMessage({
command: 'record',
buffer: [
e.inputBuffer.getChannelData(0),
e.inputBuffer.getChannelData(1)
]
});
}
this.configure = function(cfg){
for (var prop in cfg){
if (cfg.hasOwnProperty(prop)){
config[prop] = cfg[prop];
}
}
}
this.record = function(){
recording = true;
}
this.stop = function(){
recording = false;
}
this.clear = function(){
worker.postMessage({ command: 'clear' });
}
this.getBuffer = function(cb) {
currCallback = cb || config.callback;
worker.postMessage({ command: 'getBuffer' })
}
this.exportWAV = function(cb, type){
currCallback = cb || config.callback;
type = type || config.type || 'audio/wav';
if (!currCallback) throw new Error('Callback not set');
worker.postMessage({
command: 'exportWAV',
type: type
});
}
worker.onmessage = function(e){
var blob = e.data;
currCallback(blob);
}
source.connect(this.node);
this.node.connect(this.context.destination); //this should not be necessary
};
Recorder.forceDownload = function(blob, filename){
var url = (window.URL || window.webkitURL).createObjectURL(blob);
var link = window.document.createElement('a');
link.href = url;
link.download = filename || 'output.wav';
var click = document.createEvent("Event");
click.initEvent("click", true, true);
link.dispatchEvent(click);
}
window.Recorder = Recorder;
})(window);


function uploadAudioBase64(audiosrc)
{
var dataString ='audiosrc='+audiosrc;
$.ajax({
type: "POST",
url: "uploadAudio.php",
data: dataString,
cache: false,
success: function(html)
{
var ID = Number(new Date()); //Timestamp
var A='<div class="audioContainer">'
+'<div class="audioProgress" id="audioProgress'+ID+'" style="width:0px"></div>'
+'<div class="audioControl audioPlay" rel="play" id="'+ID+'"></div>'
+'<div class="audioTime" id="audioTime'+ID+'">00.00</div>'
+'<div class="audioBar"></div>'
+'<audio preload="auto" src="'+audiosrc+'" type="audio/mpeg" class="a" id="audio'+ID+'"><source></audio>'
+'</div>';
var B='<div class="stbody"><div class="stimg ">'
+'<a href="https://labs.9lessons.info/srinivas"><img src="http://www.gravatar.com/avatar/c9e85bd3f889cc998dd1bb71d832634b?d=mm&s=230" class="big_face " alt="You" ></a></div>'
+'<div class="sttext"><div class="sttext_content"><span class="sttext_span"><b><a href="https://labs.9lessons.info/srinivas">Você</a></b> </span>'
+A
+'</div></div></div>';
$(".recordingslist").prepend(B);
}
});
}
