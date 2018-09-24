
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h4 class="title_relatorio">Relatório ASO</h4>
    <p></p>
    <h4 class="title_relatorio">Inicio: <?= $data_inicio; ?> - Fim: <?= $data_fim; ?> </h4>

    <h4 class="title_relatorio">Tipo: <?= @$tipo ?> </h4>



    <? if (count($cadastroaso) > 0) { ?>
        <hr/>
        <table border='1' cellspacing=0 cellpadding=5 style="border-collapse: collapse" width="100%">
            <tr>
                <th class="tabela_header">
                    Nº ASO
                </th>
                <th class="tabela_header">
                    Empresa
                </th>
                <th class="tabela_header">
                    ID Funcionário
                </th>
                <th class="tabela_header">
                    Nome do Funcionário
                </th>

                <th class="tabela_header">
                    Função
                </th>

                <th class="tabela_header">
                    Data ASO
                </th>
                <th class="tabela_header">
                    Validade ASO
                </th>
                

            </tr>
            <tr>
                <?
//                $totaletapas = 0;
//                $totalpacientes = 0;
//                $paciente = "";
//                $etapas = "";
//                $internacao_precricao_id = "";
//                $estilo_linha = "tabela_content01";
//                $teste = 0;



//                foreach ($internacao as $item) {
////                    var_dump($item);die;
//                    $nascimento = new DateTime($item->nascimento);
//                    $atual = new DateTime(date("Y-m-d"));
//
//                    // Resgata diferença entre as datas
//                    $dateInterval = $nascimento->diff($atual);
//
//                    $data_inicio = new DateTime($item->data_internacao);
//                    $data_fim = new DateTime(date("Y-m-d H:i:s"));
//
//                    // Resgata diferença entre as datas
//                    $dateInterval2 = $data_inicio->diff($data_fim);
                    ?>
<!--                <tr>
                    <td ><?= ($item->convenio != '') ? $item->convenio : '<b>Não Tem</b>'; ?></td>
                    <td ><?= $item->unidade; ?></td>
                    <td ><?= $item->enfermaria; ?></td>
                    <td ><?= $item->leito; ?></td>
                    <td ><?= $item->paciente; ?></td>
                    <td ><?= $item->sexo; ?></td>
                    <td ><?= ($item->nascimento != '') ? $dateInterval->y : $item->idade; ?> Anos</td>
                    <td ><?= $item->procedimento; ?></td>
                    <td ><?= $item->cid1; ?></td>
                    <td ><?= date("d/m/Y H:i:s", strtotime($item->data_internacao)); ?></td>
                    <td ><?= $dateInterval2->days; ?> Dias</td>
                    <? if ($item->situacao == 't') { ?>
                    <td style="color:green">INTERNADO</td>
                    <? } ?>
                    <? if ($item->situacao == 'f') { ?>
                    <td style="color:red">NÃO INTERNADO</td>
                    <? } ?>
                </tr>-->
                <?
            }
            ?>
            <!--<tr><th colspan="12" class="tabela_header">Total de Internações: <?= count($tipo); ?></th></tr>-->
        </table>
    <? // } else { ?>
<!--        <br> <hr/>
        <h2 class="title_relatorio">Sem Registros </h2>-->
    <? // } ?>


</div> 

<!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->

<script type="text/javascript">

</script>