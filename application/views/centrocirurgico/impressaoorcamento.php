<head>
    <meta charset="utf8"/>
    <style>
        .procedimentoNome{ background-color: #ccc; }
        h4 { margin: 5; padding: 5; }
    </style>
</head>
<div class="content" onload="javascript: window.print();"> <!-- Inicio da DIV content -->
    <table style="margin-left: 50px;">
        <tbody>
            <tr>
                <td><?= $empresa[0]->razao_social; ?></td>
            </tr>
            <tr>
                <td>CNPJ:<?= $empresa[0]->cnpj; ?></td>
            </tr>
            <tr>
                <td><?= $empresa[0]->logradouro; ?> - <?= $empresa[0]->bairro; ?></td>
            </tr>
            <tr>
                <td>Telefone: <?= $empresa[0]->telefone; ?></td>
            </tr>
        </tbody>
    </table>


    <h4>PACIENTE: <?= $solicitacao[0]->paciente; ?></h4>
    <h4>CONVÊNIO: <?= $solicitacao[0]->convenio; ?></h4>
    <h4>MÉDICO SOLICITANTE: <?= $solicitacao[0]->solicitante; ?></h4>
    <h4>HOSPITAL: <?= $solicitacao[0]->hospital; ?></h4>
    <br>
    <?
    $total_geral = 0;

    if (count($procedimentos) > 0) {
        ?>
        <table style="max-width: 100%" cellpadding="4">
            <thead>
                <tr>
                    <th class="tabela_header" colspan="4" style="border:1pt solid gray">HONORÁRIOS MÉDICOS</th>
                </tr>
                <tr>
                    <th  class="tabela_header" colspan="4" ><div style="height: 40pt"></div></th>
                </tr>
                <tr>
                    <th  class="tabela_header" align="left">MÉDICO</th>
                    <th  class="tabela_header" align="left">GRAU DE PARTICIPAÇÃO</th>
                    <th  class="tabela_header" align="right">VALOR</th>
                </tr>
            </thead>
            <tbody>
                <? foreach ($procedimentos as $value) { ?>
                    <tr>
                        <td colspan="4" class="procedimentoNome">Procedimento: <?= $value->procedimento ?></td>
                    </tr>
                    <? 
                    $participacao = $this->solicitacirurgia_m->listarprocedimentoorcamentofuncao($value->cirurgia_procedimento_id); 
                    foreach ($participacao as $item) { 
                        $total_geral += (float)$item->valor; ?>
                        <tr>
                            <td> <?= $item->medico ?> </td>
                            <td> <?= $item->descricao ?> </td>
                            <td align="right"> <?= number_format($item->valor, 2, ',', ''); ?> </td>
                        </tr>                        
                    <? } ?>
                <? } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td  class="tabela_header" colspan="4" ><div style="height: 5pt"></div></td>
                </tr>
                <tr>
                    <td colspan="1" align="right">Taxa Hospital:</td>
                    <td colspan="4" align="right">R$ <?= number_format($solicitacao[0]->valor_taxa, 2, ",", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="1" align="right"><b>TOTAL HONORARIOS MEDICOS:</b></td>
                    
                    <? $total_geral += $solicitacao[0]->valor_taxa; ?>
                    
                    <td colspan="4" align="right"><b>R$ <?= number_format($total_geral, 2, ",", "."); ?></b></td>
                </tr>
            </tfoot>

        </table>
        <?
    } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>
</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
