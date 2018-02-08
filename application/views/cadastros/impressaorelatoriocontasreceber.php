<meta charset="utf-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($tipo) > 0) { ?>
        <h4>TIPO<?= $tipo[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODAS OS TIPOS</h4>
    <? } ?>
    <? if (count($classe) > 0) { ?>
        <? $texto = strtr(strtoupper($classe[0]->descricao), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"); ?>
        <h4>CLASSE: <?= $texto; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLASSES</h4>
    <? } ?>
    <? if (count($forma) > 0) { ?>
        <h4>CONTA:<?= $forma[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CONTAS</h4>
    <? } ?>
    <? if (count($credordevedor) > 0) { ?>
        <h4><?= $credordevedor[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS OS CREDORES</h4>
    <? } ?>
    <h4>RELATORIO DE SAIDA</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <hr>
    <?
    if (count($relatorio) > 0 || count($previsaoconvenio) > 0) {
        if (count($relatorio) > 0) {
            ?>
            <table border="1">
                <thead>
                    <tr>
                        <th width="100px;" class="tabela_header">Conta</th>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Tipo</th>
                        <th class="tabela_header">Classe</th>
                        <th class="tabela_header">Dt saida</th>
                        <th class="tabela_header">Valor</th>

                        <th class="tabela_header">Observacao</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($relatorio as $item) :
                        $total = $total + $item->valor;
                        ?>
                        <tr>
                            <td ><?= $item->conta; ?></td>
                            <td ><?= $item->razao_social; ?></td>
                            <td ><?= $item->tipo; ?></td>
                            <td ><?= $item->classe; ?></td>
                            <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                            <td ><?= $item->observacao; ?></td>
                        </tr>
                    <? endforeach; ?>
                    <tr>
                        <td colspan="4"><b>TOTAL</b></td>
                        <td colspan="2"><b><?= number_format($total, 2, ",", "."); ?></b></td>
                    </tr>
                </tbody>

            </table>
            <?
        }
        
        if (count($relatorioconvenio) > 0) {
            $previsaoConvenio = Array();

            foreach ($relatorioconvenio as $item) {
                
                $previsaoConvenio[$item->convenio_id]["nome"] = $item->convenio;
                $previsaoConvenio[$item->convenio_id]["credor_devedor_id"] = $item->credor_devedor_id;
                $previsaoConvenio[$item->convenio_id]["conta_id"] = $item->conta_id;                
                $previsaoConvenio[$item->convenio_id]["valor"] = @$previsaoConvenio[$item->convenio_id]["valor"] + $item->valor_total;
                
                if ( $item->confirmacao_recebimento_convenio == 't' ){
                    @$previsaoConvenio[$item->convenio_id]["confirmado"]++;
                }
            }

            ?>
            <br>
            <br>
            <br>
            <table border="1" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th class="tabela_header" colspan="5" style="background-color: #ccc;">Previsão Convênio</th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Convênio</th>
                        <th class="tabela_header">Valor Previsto</th>
                        <th class="tabela_header">Confirmar Recebimento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($previsaoConvenio as $key => $item) :
                        if($item["valor"] != 0) {
                        ?>
                        <tr>
                            <td ><?= $item["nome"]; ?></td>
                            <td style="text-align: right"><?= number_format($item["valor"], 2, ",", ".");?></td>
                            <td style="text-align: center">
                                <? 
                                if ( ($_POST['empresa'] != '') ) {
                                    if ( !isset($item["confirmado"]) ) {
                                        if ($item["credor_devedor_id"] != '' && $item["conta_id"] != ''){?>
                                        <form id="confirmacao-form" name="confirmacao-form" method="get" action="<?= base_url() ?>cadastros/contasreceber/confirmarprevisaorecebimentoconvenio" target="_blank">
                                            <input type="hidden" name="empresa" value="<?= $_POST['empresa'] ?>"/>
                                            <input type="hidden" name="conta" value="<?= $item["conta_id"] ?>"/>
                                            <input type="hidden" name="credordevedor" value="<?= $item["credor_devedor_id"] ?>"/>
                                            <input type="hidden" name="txtdata_inicio" value="<?= $_POST['txtdata_inicio'] ?>"/>
                                            <input type="hidden" name="txtdata_fim" value="<?= $_POST['txtdata_fim'] ?>"/>
                                            <input type="hidden" name="valor" value="<?= $item["valor"] ?>"/>
                                            <input type="hidden" name="convenio_id" value="<?= $key ?>"/>
                                            <input type="hidden" name="convenio_nome" value="<?= $item["nome"] ?>"/>
                                            <button type="submit">Confirmar</button>

                                        </form>
                                    <?  }
                                        else{
                                            if($item["credor_devedor_id"] == ''){
                                                echo "Credor/Devedor não informado";
                                            } else{
                                                echo "Conta não informada";
                                            }
                                        }
                                    }
                                    else{
                                        echo "Valor já confirmado";
                                    }
                                }
                                else {
                                    echo "Selecione uma empresa";
                                } ?>
                            </td>
                        </tr>
                        <? }
                    endforeach; ?>
                </tbody>

            </table>
            <?
        }
    }
    else {
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
