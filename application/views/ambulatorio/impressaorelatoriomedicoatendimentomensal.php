<meta charset="UTF-8">
<? 
    $meses = array(
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    );
?>
<div class="content"> <!-- Inicio da DIV content -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>PERIODO: <?= $periodo ?></h4>
    <? if ($revisor == 0) { ?>
        <h4>Revisor: TODOS</h4>
    <? } else { ?>
        <h4>Revisor: <?= $revisor[0]->operador; ?></h4>
    <? } 
    if ($medico == 0) { ?>
        <h4>Medico: TODOS</h4>
    <? } else { ?>
        <h4>Medico: <?= $medico[0]->operador; ?></h4>
    <? } ?>
        
    <hr>
    
    <? if(count($procedimentos) > 0){ ?>
        <table border="1">
            <thead>
                <tr>
                    <td rowspan="2"><center>PROCEDIMENTOS</center></td>
                    <td><center>MES</center></td>
                    <? foreach ($medicos as $value) {?>
                        <td><center>MEDICO</center></td>
                    <? } ?>
                </tr>
                <tr>
                    <td><center><?= $meses[(int)substr($periodo, 0, 2)] ?></center></td>
                    <? 
                    foreach ($medicos as $value) {
                        $col[$value->medico_parecer1] = 0; ?>
                        <td><center><?= $value->medico ?></center></td>
                    <? } ?>
                </tr>
            </thead>

            <tbody>
                <? foreach ($procedimentos as $value) {?>
                <tr>
                    <td><center><?= $value->procedimento ?></center></td>
                    <td><center><?= $value->qtde ?></center></td>

                    <? 
                    foreach ($medico_procedimento as $item) {
                        if($item->procedimento_tuss_id == $value->procedimento_tuss_id){
                           $col[$item->medico_parecer1] = $col[$item->medico_parecer1] + $item->total;
                        }
                    }

                    foreach ($col as $key => $qtde) { ?>
                        <td><center><?= $qtde ?></center></td>
                    <? 
                    $col[$key] = 0;
                    } ?>


                </tr>
                <? } ?>
            </tbody>
        </table>
    <? } 
    else { ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
?>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
