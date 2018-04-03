<meta charset="UTF-8">
<?
$sexo = $exame[0]->sexo;
if ($sexo == "M") {
    $sexopaciente = "Masculino";
} elseif ($sexo == "F") {
    $sexopaciente = "Feminino";
} else {
    $sexopaciente = "Outro";
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
<?
if (@$empresa[0]->cabecalho_config == 't') {
    echo @$cabecalho[0]->cabecalho;
} else {
    if ($empresa[0]->impressao_declaracao == 1) {
        ?>
        <p style="text-align: center"><img align = 'center'  width='400px' height='200px' src="<?= base_url() . "img/cabecalho.jpg" ?>"></p>   
    <? } else {
        ?>
        <p style="text-align: center"><img align = 'center'  width='1000px' height='300px' src="<?= base_url() . "img/cabecalho.jpg" ?>"></p> 
        <?
    }
}
?> 







<p>Paciente: <strong><?= utf8_decode($paciente['0']->nome); ?></strong></p>
<? echo $modelo[0]->texto ?>

<style>
    footer {
        position: absolute; 
        bottom: 0px; 
        width: 100%; 
        /*height: 60px;*/ 
        /*background-color: green;*/
    }
    html {
        position: relative;
        min-height: 100%;
    }
    body {
        margin: 0 0 60px; /* altura do seu footer */
    }

</style>

<footer>
    <p style="text-align: center"><?= $exame[0]->municipio ?> - <?= $exame[0]->estado ?>
        , <?= substr($exame[0]->data, 8, 2) . " de " . $MES . " de " . substr($exame[0]->data, 0, 4); ?> /

        <?= date("H:i:s") ?>
        <?
        @$cabecalho = @$cabecalho[0]->rodape;
        @$cabecalho = str_replace("_assinatura_", '', @$cabecalho);
        if ($empresa[0]->rodape_config == 't') {
            echo @$cabecalho;
        } else {
            if ($empresa[0]->impressao_declaracao == 1) {
                ?>
            <p style="text-align: center"><img align = 'center'  width='1000px' height='100px' src="<?= base_url() . "img/rodape.jpg" ?>"></p>    
        <? } else {
            ?>
            <p style="text-align: center"><img align = 'center'  width='1000px' height='300px' src="<?= base_url() . "img/rodape.jpg" ?>"></p> 
            <?
        }
    }
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
</p>
<style>
    @media print {
        button { 
            display: none; 
        }
    }
</style>


</footer>



<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
