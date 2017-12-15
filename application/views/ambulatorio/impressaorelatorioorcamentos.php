<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Relatorio Orcamentos</h4>
    <h4>GRUPO: <?= ($grupo != '') ? $grupo: "TODOS" ?></h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> até <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    
    <hr>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th class="tabela_header" >Paciente</th>
                <th class="tabela_header" width="150px;">Telefone</th>
                <th class="tabela_header" width="150px;">Data</th>
                <th class="tabela_header" width="150px;">Valor (R$)</th>
                <th class="tabela_header" width="300px;">Empresa</th>
                <th class="tabela_header" width="150px;">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($relatorio) > 0) {
                foreach ($relatorio as $item) {

                    if ($item->celular != "") {
                        $telefone = $item->celular;
                    } elseif ($item->telefone != "") {
                        $telefone = $item->telefone;
                    } else {
                        $telefone = "";
                    }
                    ?>
                    <tr>
                        <td><b><?= $item->paciente; ?></b></td>
                        <td><?= $telefone ?></td>
                        <td><?= date( "d/m/Y", strtotime($item->data_criacao) ) ?></td>
                        <td style="text-align: right">
                            <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/listarprocedimentosorcamento/{$item->ambulatorio_orcamento_id}/{$empresa_id}"; ?>/', '_blank', 'width=800,height=800');">
                                    <?= number_format($item->valor, 2, ',', "") ?>
                                </a>
                        </td>
                        <td><b><?= $item->empresa_nome; ?></b></td>
                        <td align="center"><a href="<?= base_url() ?>ambulatorio/exame/autorizarorcamento/<?= $item->ambulatorio_orcamento_id ?>" target="_blank">Autorizar</a></td>
                    </tr>

                </tbody>
                <?php
            }
        }
        ?>

    </table>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>
