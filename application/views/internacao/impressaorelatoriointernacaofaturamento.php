
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h4 class="title_relatorio">Relatório Internação Faturamento</h4>
    <p></p>
    <h4 class="title_relatorio">Inicio: <?= $data_inicio; ?> - Fim: <?= $data_fim; ?> </h4>

    <h4 class="title_relatorio">Convênio: <?= @$convenio; ?> </h4>



    <? if (count($internacao) > 0) { ?>
        <hr/>
        <table border='1' cellspacing=0 cellpadding=5 style="border-collapse:collapse;font-size: 10pt;">
            <tr>
                <th class="tabela_header">
                    Convênio
                </th>
                <th class="tabela_header">
                    Paciente
                </th>
                <th class="tabela_header">
                    Unidade
                </th>
                <th class="tabela_header">
                    Enfermaria
                </th>
                <th class="tabela_header">
                    Leito
                </th>



                <th class="tabela_header">
                    Sexo
                </th>
                <th class="tabela_header">
                    Idade
                </th>
                <th class="tabela_header">
                    Procedimento
                </th>
                <th class="tabela_header">
                    Cid1
                </th>
                <th class="tabela_header">
                    Dias de Faturamento
                </th>
                <th class="tabela_header">
                    Valor Diária
                </th>
                <th class="tabela_header">
                    Total
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
                $valor_total = 0;



                foreach ($internacao as $item) {
                    $nascimento = new DateTime($item->nascimento);
                    $atual = new DateTime(date("Y-m-d"));

                    // Resgata diferença entre as datas
                    $dateInterval = $nascimento->diff($atual);


                    $data_i = date("Y-m-d", strtotime($item->data_internacao));

                    if ($item->data_saida != '') {
                        if (date("Y-m-d", strtotime($item->data_saida)) <= date("Y-m-d", strtotime(str_replace('/', '-', $data_fim)))) {
                            $data_f = date("Y-m-d", strtotime($item->data_saida));
                        } else {
                            $data_f = date("Y-m-d", strtotime(str_replace('/', '-', $data_fim)));
                        }
                    } else {
                        $data_f = date("Y-m-d", strtotime(str_replace('/', '-', $data_fim)));
                    }

//                    var_dump($data_i);
//                    var_dump($data_f);
//                    echo '<br>';
//                    die;
//                    if(){
//                        
//                    }else{
//                        
//                    }
                    $data_1 = new DateTime($data_i);
                    $data_2 = new DateTime($data_f);

                    // Resgata diferença entre as datas
                    $dateInterval2 = $data_1->diff($data_2);
                    
                    $valor_total = $valor_total + $item->valor_total * $dateInterval2->days;
                    ?>
                <tr>
                    <td ><?= ($item->convenio != '') ? $item->convenio : ''; ?></td>
                    <td ><?= $item->paciente; ?></td>
                    <!--<td ><?= $item->data_internacao; ?></td>-->
                    <!--<td ><?= $item->data_saida; ?></td>-->
                    <td ><?= $item->unidade; ?></td>
                    <td ><?= $item->enfermaria; ?></td>
                    <td ><?= $item->leito; ?></td>

                    <td ><?= $item->sexo; ?></td>
                    <td ><?= ($item->nascimento != '') ? $dateInterval->y : $item->idade; ?> Anos</td>
                    <td ><?= $item->procedimento; ?></td>
                    <td ><?= $item->cid1; ?></td>
                    <td ><?= $dateInterval2->days; ?> Dias</td>
                    <td ><?= number_format($item->valor_total, 2, ',', '.'); ?></td>
                    <td ><?= number_format($item->valor_total * $dateInterval2->days, 2, ',', '.'); ?></td>
                </tr>
                <?
            }
            ?>
            <tr>
                <th colspan="8" class="tabela_header">Total de Internações: <?= count($internacao); ?></th>
                <th colspan="4" class="tabela_header">Valor Total: <?=  number_format($valor_total, 2, ',', '.'); ?></th>
            </tr>
        </table>
    <? } else { ?>
        <br> <hr/>
        <h2 class="title_relatorio">Sem Registros </h2>
    <? } ?>


</div> 

<!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->

<script type="text/javascript">

</script>