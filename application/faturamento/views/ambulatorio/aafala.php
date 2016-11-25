<!--<div id="1">
Há em Lisboa um pequeno número de restaurantes ou casas de pasto em que, sobre uma loja com feitio de taberna decente se ergue uma sobreloja com uma feição pesada e caseira de restaurante de vila sem comboios.
</div>

<script type="text/javascript" src="http://vozme.com/get_text.js"></script>
<div><a href="javascript:void(0);" 
onclick="get_id('1','pt','fm');">
</a>
<a href="javascript:void(0);" 
onclick="get_id('1','pt','fm');">
Ouça este texto</a></div>-->

<?

$paciente = $chamada[0]->paciente;
$nome_sala = $chamada[0]->nome_sala;
$sala = $chamada[0]->paciente . " " . $chamada[0]->sala;

?>

        <script>
            function test(){
                voices = window.speechSynthesis.getVoices();
                console.log(voices[3])
            }
        </script>

<div >
    
    <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturado" method="post">
    <input type="text" name="paciente" id="paciente" class="texto10" value="<?= $paciente; ?>" />
    <input type="text" name="sala" id="sala" class="texto06" value="<?= $nome_sala; ?>" />
    <input type="text" name="sala2" id="sala2" class="texto06" value="<?= $sala; ?>" />

    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
 <?   
# Incluindo cabecalho que tratara os acentos (pt-br)

# Incluindo a classe
require_once APPPATH . 'controllers/base/googleTranslateTool.class.php';

# Iniciando o tradutor de ‘pt-br’ para ‘en’ (ingles) 
$translator = new googleTranslateTool('pt-br','en');
#Importante: É preciso que a extensão cUrl esteja ativada em seu PHP, se não estiver basta descomentar a linha extension=php_curl.dll (removendo o “;” ) no arquivo php.ini
# Informando e Traduzindo o texto de pt-br para en (informado no parametro)
$result = $translator->translate_Text('Oi, sou Rafael e estou testando.');
var_dump($result);
die;
# Checando o resultado
if ( $result===false )
{
 # Exibindo o erro
 echo $translator->return_error();
}
else
{
 # Exibindo a resultado traduzido
 echo $result;
}

?>
<script>
var msg = new SpeechSynthesisUtterance();
var voices = window.speechSynthesis.getVoices();
//msg.voice = speechSynthesis.getVoices().filter(function(voice) { return voice.name == 'Whisper'; })[0];
msg.voice = voices[3]; // Obs: algumas vozes não dão suporte a alterar alguns parâmetros
//msg.voiceURI = 'native';
msg.volume = 1; // 0 to 1
msg.rate = 1; // 0.1 to 10
msg.pitch = 1; //0 to 2
msg.text = document.form_faturar.sala2.value;
msg.lang = 'pt-br';

msg.onend = function(e) {
  console.log('Finished in ' + event.elapsedTime + ' seconds.');
};

speechSynthesis.speak(msg);

</script>
</form>
</div>