<?
IF($tipo == 'ENTERALNORMAL'){
$impressaotipo = 'ENTERAL NORMAL';  
}else{
$impressaotipo = 'ENTERAL EMERGENCIA';    
}
?>

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h4 class="title_relatorio">Prescri&ccedil;&atilde;o</h4>
    <p></p>
    <h4 class="title_relatorio">Inicio: <?= $data_inicio; ?> - Fim: <?= $data_fim; ?> </h4>
    <h4 class="title_relatorio">HOSPITAL: <?= $unidade; ?> </h4>
    <h4 class="title_relatorio">TIPO: <?= $impressaotipo; ?> </h4>

</table>
<? if (count($prescricao) > 0) { ?>
    <hr/>
    <table>
        <tr>
            <th class="tabela_header">
                Paciente
            </th>
            <th class="tabela_header">
                Prescricao
            </th>
            <th class="tabela_header">
                Etapas
            </th>
            <th class="tabela_header">
                Produto
            </th>
            <th class="tabela_header">
                Volume
            </th>
            <th class="tabela_header">
                Vaz&atilde;o
            </th>
            <th class="tabela_header">
                Equipo
            </th>
        </tr>
        <tr>
            <?
            $totaletapas = 0;
            $totalpacientes = 0;
            $paciente = "";
            $etapas = "";
            $internacao_precricao_id = "";
            $estilo_linha = "tabela_content01";
            $teste = 0;
            foreach ($prescricao as $item) {
                $i = $item->etapas;
                
                if ($item->internacao_precricao_id != $internacao_precricao_id) {
                    $paciente = $item->paciente;
                    $totalpacientes ++;
                    $data = substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4);
                    $internacao_precricao_id = $item->internacao_precricao_id;
                    foreach ($prescricaoequipo as $value) {
                        $equipo = $value->nome;
                    }
                } else {
                    $data = '&nbsp;';
                    $equipo = '&nbsp;';
                    $paciente = '&nbsp;';
                }
                if ($item->internacao_precricao_etapa_id == $etapas) {
                    $i = '&nbsp;';
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content01" : $estilo_linha = "tabela_content02";
                } else {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                }
                $totaletapas = $totaletapas + $i;
                ?>
            <tr>
                <td class="<?php echo $estilo_linha; ?>"><?= $paciente; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $data; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $i; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->volume; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->vasao; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $equipo; ?></td>
            </tr>
            <?
            $i++;
            $etapas = $item->internacao_precricao_etapa_id;
        }
        
        
        ?>
            <tr><th colspan="2" class="tabela_header">Total de Pacientes: <?= $totalpacientes; ?></th><th colspan="5" class="tabela_header">Total de etapas: <?= $totaletapas; ?></th></tr>
            </table>
    <? } ?>


</div> 
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->
<link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" />


<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

</script>