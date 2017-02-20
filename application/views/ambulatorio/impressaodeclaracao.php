<?
$sexo = $exame[0]->sexo;
if ($sexo == "M") {
    $sexopaciente = "Masculino";
} elseif ($sexo == "F") {
    $sexopaciente = "Feminino";
}
$dataFuturo = date("Y-m-d");
$dataAtual = $paciente['0']->nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
$exame_id = $exame[0]->agenda_exames_id;
$dataatualizacao = $exame[0]->data_autorizacao;
$inicio = $exame[0]->inicio;
$agenda = $exame[0]->agenda;
$data = $exame[0]->data;
$MES = substr($exame[0]->data, 5, 2);

switch ($MES) {
    case 1 : $MES = 'Janeiro';
        break;
    case 2 : $MES = 'Fevereiro';
        break;
    case 3 : $MES = 'Mar&ccedil;o';
        break;
    case 4 : $MES = 'Abril';
        break;
    case 5 : $MES = 'Maio';
        break;
    case 6 : $MES = 'Junho';
        break;
    case 7 : $MES = 'Julho';
        break;
    case 8 : $MES = 'Agosto';
        break;
    case 9 : $MES = 'Setembro';
        break;
    case 10 : $MES = 'Outubro';
        break;
    case 11 : $MES = 'Novembro';
        break;
    case 12 : $MES = 'Dezembro';
        break;
        break;
}
?>
<p><center><img align = 'center'  width='1000px' height='300px' src="<?= base_url() . "img/cabecalho1.jpg" ?>"></center></p>

<p>Paciente: <strong><?= utf8_decode($paciente['0']->nome); ?></strong></p>
<?echo $modelo[0]->texto?>

<!--<p><center><u><b><?= $empresa[0]->razao_social; ?></b></u></center></p>
<br>
<br>
<br>
<br>
<p><center><font size = 4><b>DECLARA&Ccedil;&Atilde;O</b></font></center></p>
<br>
<br>
<br>
<br>
<p>Declaro para os devidos fins que a paciente: <?= utf8_decode($paciente['0']->nome); ?>, compareceu a esta cl&iacute;nica na presente data para realizarconsulta e/ou exames.
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
<p><?= $exame[0]->municipio ?>, <?= substr($exame[0]->data, 8, 2) . " de " . $MES . " de " . substr($exame[0]->data, 0, 4); ?></p>
<br>
<br>
<br>
<h4><center>___________________________________________</center></h4>
<h4><center><?= $empresa[0]->razao_social; ?></center></h4>

<br>
<br>
<br>
<p><center><?= $exame[0]->logradouro; ?><?= $exame[0]->numero; ?> - <?= $exame[0]->bairro; ?> - <?= $exame[0]->municipio ?></center></p>
<p><center>Fone: (85) <?= $exame[0]->telefone; ?> - (85) <?= $exame[0]->celular; ?></center></p>-->
<p><center><img align = 'center'  width='1000px' height='300px' src="<?= base_url() . "img/rodape1.jpg" ?>"></center></p>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
