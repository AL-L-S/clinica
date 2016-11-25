<style type="text/css">
    table
    {
        float:left;
    }
</style> 

<table border=1>
    <thead>
        <tr>
            <th class="tabela_header"colspan="4"><center>Sala de espera</center></th>
</tr>
<tr>
    <th class="tabela_header" width="200px;">Nome</th>
    <th class="tabela_header" width="100px;">Sala</th>
    <th class="tabela_header" width="200px;">Procedimento</th>
    <th class="tabela_header">tempo</th>
</tr>
</thead>
<?php
$url = $this->utilitario->build_query_params(current_url(), $_GET);
$espera = $this->exame->listarexameagendaconfirmada($_GET);
$totalespera = $espera->count_all_results();
$i = 0;
$estilo_linha = "tabela_content01";
if ($totalespera > 0) {
    ?>
    <tbody>
        <?php
        $listaespera = $this->exame->listarexameagendaconfirmada2($_GET)->get()->result();
        
        foreach ($listaespera as $itens) {
            $i++;
            $dataFuturo = date("Y-m-d H:i:s");
            $dataAtual = $itens->data_autorizacao;

            $date_time = new DateTime($dataAtual);
            $diff = $date_time->diff(new DateTime($dataFuturo));
            $teste = $diff->format('%H:%I:%S');
            ?>
            <tr>
                <td class="<?php echo $estilo_linha; ?>"><?= $itens->paciente; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $itens->sala; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $itens->procedimento; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $teste; ?></td>
            </tr>

        </tbody>
        <?php
        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
    }
}
?>

<tfoot>
    <tr>
        <td class="<?php echo $estilo_linha; ?>" colspan="4"><center>Total: <?= $i; ?></center></td>
</tr>
</tfoot>
</table>
<table>
    <tr>
        <th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
    </tr>
</table>
<table border=1>
    <thead>
        <tr>
            <th class="tabela_header"colspan="4"><center>Salas de Exames</center></th>
</tr>
<tr>
    <th class="tabela_header" width="200px;">Nome</th>
    <th class="tabela_header"width="100px;">Sala</th>
    <th class="tabela_header"width="200px;">Procedimento</th>
    <th class="tabela_header">Tempo</th>
</tr>
</thead>
<?php
$url = $this->utilitario->build_query_params(current_url(), $_GET);
$consulta = $this->exame->listarexames($_GET);
$total = $consulta->count_all_results();
$b = 0;
if ($total > 0) {
    ?>
    <tbody>
        <?php
        $lista = $this->exame->listarexames($_GET)->get()->result();
        $estilo_linha = "tabela_content01";
        foreach ($lista as $item) {
            $b++;
            $dataFuturoexame = date("Y-m-d H:i:s");
            $dataAtualexame = $item->data_cadastro;

            $date_timeexame = new DateTime($dataAtualexame);
            $diffexame = $date_timeexame->diff(new DateTime($dataFuturoexame));
            $testeexame = $diff->format('%H:%I:%S');
            ?>
            <tr>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->sala; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $testeexame; ?></td>
            </tr>

        </tbody>
        <?php
        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
    }
}
?>

<tfoot>
    <tr>
        <td class="<?php echo $estilo_linha; ?>" colspan="4"><center>Total: <?= $b; ?></center></td>
</tr>
</tfoot>
</table>

<script type="text/javascript">

    setTimeout('delayReload()', 40000);
    function delayReload()
    {
        if(navigator.userAgent.indexOf("MSIE") != -1){
            history.go(0);
        }else{
            window.location.reload();
        }
    }

</script>
