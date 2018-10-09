
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h4 class="title_relatorio">Relatório Cirurgia-Convenio</h4>
    <p></p>
    <h4 class="title_relatorio">Inicio: <?= $data_inicio; ?> - Fim: <?= $data_fim; ?> </h4>

    <h4 class="title_relatorio">Convênio: <?= $convenio ?> </h4>
<?
//        echo '<pre>';
//        var_dump($relatorioaso);
//        die; ?>

    <? if (count($relatoriocirurgiaconvenio) > 0) { ?>
        <hr/>
        <table border='1' cellspacing=0 cellpadding=5 style="border-collapse: collapse;" width="100%">
            <tr>
                
                
                <th class="tabela_header">
                    Nome do Paciente
                </th>

                <th class="tabela_header">
                    Convênio
                </th>
                
                <th class="tabela_header">
                    Cirurgião
                </th>
                
                <th class="tabela_header">
                    Pós-Operatório
                </th>
                
                <th class="tabela_header">
                    Data
                </th>
                
                <th class="tabela_header">
                    Leito
                </th>
                
                

            </tr>
            <tr>
                <?


                foreach ($relatoriocirurgiaconvenio as $item) {

//                var_dump($item);die;
//        echo '<pre>';
//                var_dump($item);die;
//                    ?>
                <tr>
                    
                                       
                    <td ><?= $item->paciente ?></td>                    
                    <td ><?= $item->convenio ?></td>
                    <td ><?= $item->cirurgiao ?></td>                    
                    <td ><?= $item->operatorio ?></td>                    
                    <td ><?= date("d/m/Y", strtotime($item->data_prevista)); ?></td>
                    <td ><?= $item->leito ?></td>                    
                   
                    
                </tr>
                <?
            }
            ?>
            <tr><th colspan="12" class="tabela_header">Total de Cirurgias: <?= count($relatoriocirurgiaconvenio); ?></th></tr>
        </table>
    <? } else { ?>
        <br> <hr/>
        <h2 class="title_relatorio">Sem Registros </h2>
    <? } ?>


</div> 

<!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->
<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<script type="text/javascript">

</script>