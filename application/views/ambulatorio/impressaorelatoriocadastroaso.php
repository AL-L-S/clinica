
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h4 class="title_relatorio">Relatório Cadastro ASO</h4>
    <p></p>
    <h4 class="title_relatorio">Inicio: <?= $data_inicio; ?> - Fim: <?= $data_fim; ?> </h4>

    
    <h4 class="title_relatorio">Procedimento Grupo: <?= $procedimentogrupo ?> </h4>
    <h4 class="title_relatorio">Procedimento: <?= $procedimento ?> </h4>
    <h4 class="title_relatorio">Convênio Grupo: <?= $conveniogrupo ?> </h4>
    <h4 class="title_relatorio">Convênio: <?= $convenio ?> </h4>    
<?
//        echo '<pre>';
//        var_dump($relatorioaso);
//        die; ?>

    <? if (count($relatoriocadastroaso) > 0) { ?>
        <hr/>
        <table border='1' cellspacing=0 cellpadding=5 style="border-collapse: collapse; text-align: center" width="100%">
            <tr>
                <th class="tabela_header">
                    TIPO ASO
                </th>
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


                foreach ($relatorioaso as $item) {
       
                $impressao_aso = json_decode($item->impressao_aso);
                if(count($impressao_aso) > 0){
                if(isset($impressao_aso->funcao)){
                $funcao = $this->guia->listarfuncaoaso($impressao_aso->funcao);
                }else{
                $funcao = $impressao_aso->funcao2;    
                }
                }
//                var_dump($item);die;
//                var_dump($impressao_aso->funcao2);die;
                    ?>
                <tr>
                    <td ><?= $item->tipo ?></td>
                    <td ><?= $item->cadastro_aso_id ?></td>
                    <?if($item->consulta == "particular"){?>
                    <td ><?= $item->convenio2 ?></td>
                    <? }else{ ?>
                    <td ><?= $item->convenio ?></td>
                    <? } ?>
                    <td ><?= $item->paciente_id ?></td>
                    <td ><?= $item->paciente ?></td>
                    <?if(isset($impressao_aso->funcao)){?>
                    <td ><?= $funcao[0]->descricao_funcao ?></td>
                    <? }else{ ?>
                    <td><?= $funcao ?></td>
                    <? } ?>
                    <td ><?= date("d/m/Y", strtotime($item->data_realizacao)); ?></td>
                    <td ><?= date("d/m/Y", strtotime($item->data_validade)); ?></td>
                    
                </tr>
                <?
            }
            ?>
            <tr><th colspan="12" class="tabela_header">Total de Internações: <?= count($relatorioaso); ?></th></tr>
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