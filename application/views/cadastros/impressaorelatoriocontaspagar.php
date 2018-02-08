<meta charset="utf-8">
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    <?  $i = 0;
        foreach ($relatoriolaboratorio as $item){
            $i++;
            ?>
            $(function () {
                $("#dataLab<?= $i ?>").datepicker({
                    autosize: true,
                    changeYear: true,
                    changeMonth: true,
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                    buttonImage: '<?= base_url() ?>img/form/date.png',
                    dateFormat: 'dd/mm/yy'
                });
            });
            $(function () {
                $("#dataMed<?= $i ?>").datepicker({
                    autosize: true,
                    changeYear: true,
                    changeMonth: true,
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                    buttonImage: '<?= base_url() ?>img/form/date.png',
                    dateFormat: 'dd/mm/yy'
                });
            });
            $(function () {
                $("#dataPro<?= $i ?>").datepicker({
                    autosize: true,
                    changeYear: true,
                    changeMonth: true,
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                    buttonImage: '<?= base_url() ?>img/form/date.png',
                    dateFormat: 'dd/mm/yy'
                });
            });
            <?
        }
    ?>
    

    (function ($) {
        $(function () {
            $('input:text').setMask();
        });
    })(jQuery);
</script>
<style>
    #confirmacao-form{
        margin: 0;
        padding: 0;
    }
</style>
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
    if (count($relatorio) > 0 || count($relatoriomedico) > 0 || count($relatoriopromotor) > 0) {
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
        ?>
        <?
        if (count($relatoriomedico) > 0 || count($relatoriopromotor) > 0) { ?>
            <br>
            <br>
            <div>
                <table border="0" cellspacing="10">
                    <tr>
                    <?
                    if (count($relatoriomedico) > 0) { ?>
                        <td style="vertical-align: top">
                            <?
                            $previsaoMedicos = Array();

                            foreach ($relatoriomedico as $item) {
                                $previsaoMedicos[$item->medico_agenda]["nome"] = $item->medico;
                                $previsaoMedicos[$item->medico_agenda]["conta_id"] = $item->conta_id;
                                $previsaoMedicos[$item->medico_agenda]["credor_devedor_id"] = $item->credor_devedor_id;
                                $previsaoMedicos[$item->medico_agenda]["tipo"] = $item->tipo_id;
                                $previsaoMedicos[$item->medico_agenda]["classe"] = $item->classe;
                                if ( $item->confirmacao_previsao_medico == 't' ){
                                    @$previsaoMedicos[$item->medico_agenda]["confirmado"]++;
                                }

                                if($item->perc_medico_excecao != ""){
                                    $valor = ($item->percentual_excecao == 't') ?  $item->valor_total * ($item->perc_medico_excecao / 100) : $item->perc_medico_excecao;
                                }
                                else{
                                    $valor = ($item->percentual == 't') ?  $item->valor_total * ($item->perc_medico / 100) : $item->perc_medico;
                                }
                                $previsaoMedicos[$item->medico_agenda]["valor"] = @$previsaoMedicos[$item->medico_agenda]["valor"] + $valor;
                            }

                            ?>
                            <table border="1" cellspacing="0" cellpadding="5">
                                <thead>
                                    <tr>
                                        <th class="tabela_header" colspan="5" style="background-color: #ccc;">Previsão Médica</th>
                                    </tr>
                                    <tr>
                                        <th class="tabela_header">Médico</th>
                                        <th class="tabela_header">Valor Previsto</th>
                                        <th class="tabela_header">Confirmar Pagamento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($previsaoMedicos as $key => $item) :
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
                                                        <form id="confirmacao-form" name="confirmacao-form" method="get" action="<?= base_url() ?>cadastros/contaspagar/confirmarprevisaomedico" target="_blank">
                                                            <input type="hidden" name="empresa" value="<?= $_POST['empresa'] ?>"/>
                                                            <input type="hidden" name="conta" value="<?= $item["conta_id"] ?>"/>
                                                            <input type="hidden" name="credordevedor" value="<?= $item["credor_devedor_id"] ?>"/>
                                                            <input type="hidden" name="tipo" value="<?= $item["tipo"] ?>"/>
                                                            <input type="hidden" name="classe" value="<?= $item["classe"] ?>"/>
                                                            <input type="hidden" name="txtdata_inicio" value="<?= $_POST['txtdata_inicio'] ?>"/>
                                                            <input type="hidden" name="txtdata_fim" value="<?= $_POST['txtdata_fim'] ?>"/>
                                                            <input type="hidden" name="valor" value="<?= $item["valor"] ?>"/>
                                                            <input type="hidden" name="medico_id" value="<?= $key ?>"/>
                                                            <input type="hidden" name="medico_nome" value="<?= $item["nome"] ?>"/>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <label for="dataMed<?= $i ?>">Data</label>
                                                                        <input type="text" name="data" alt="date" id="dataMed<?= $i ?>"
                                                                           value="<?= ($_POST['txtdata_inicio'] == $_POST['txtdata_fim']) ? $_POST['txtdata_inicio'] : ""?>"
                                                                           style="width: 50%" required=""/>
                                                                    </td>
                                                                    <td align="center"><button type="submit">Confirmar</button></td>
                                                                </tr>
                                                                <tr>
                                                                </tr>
                                                            </table>

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
                        </td>
                        <?
                    }

                    if (count($relatoriopromotor) > 0) { ?>
                        <td style="vertical-align: top">
                            <?
                            $previsaoPromotor = Array();

                            foreach ($relatoriopromotor as $item) {
                                $previsaoPromotor[$item->indicacao]["nome"] = $item->promotor;
                                $previsaoPromotor[$item->indicacao]["conta_id"] = $item->conta_id;
                                $previsaoPromotor[$item->indicacao]["credor_devedor_id"] = $item->credor_devedor_id;
                                $previsaoPromotor[$item->indicacao]["tipo"] = $item->tipo_id;
                                $previsaoPromotor[$item->indicacao]["classe"] = $item->classe;
                                if ( $item->confirmacao_previsao_promotor == 't' ){
                                    @$previsaoPromotor[$item->indicacao]["confirmado"]++;
                                }


                                if($item->percentual_promotor == 't'){
                                    $valor = $item->valor_total * ($item->valor_promotor / 100);
                                }
                                else{
                                    $valor = $item->valor_promotor;
                                }
                                $previsaoPromotor[$item->indicacao]["valor"] = @$previsaoPromotor[$item->indicacao]["valor"] + $valor;
                            }

                            ?>
                            <table border="1" cellspacing="0" cellpadding="5">
                                <thead>
                                    <tr>
                                        <th class="tabela_header" colspan="5" style="background-color: #ccc;">Previsão Promotor</th>
                                    </tr>
                                    <tr>
                                        <th class="tabela_header">Promotor</th>
                                        <th class="tabela_header">Valor Previsto</th>
                                        <th class="tabela_header">Confirmar Pagamento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($previsaoPromotor as $key => $item) :
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
                                                        <form id="confirmacao-form" name="confirmacao-form" method="get" action="<?= base_url() ?>cadastros/contaspagar/confirmarprevisaopromotor" target="_blank">
                                                            <input type="hidden" name="empresa" value="<?= $_POST['empresa'] ?>"/>
                                                            <input type="hidden" name="conta" value="<?= $item["conta_id"] ?>"/>
                                                            <input type="hidden" name="credordevedor" value="<?= $item["credor_devedor_id"] ?>"/>
                                                            <input type="hidden" name="tipo" value="<?= $item["tipo"] ?>"/>
                                                            <input type="hidden" name="classe" value="<?= $item["classe"] ?>"/>
                                                            <input type="hidden" name="txtdata_inicio" value="<?= $_POST['txtdata_inicio'] ?>"/>
                                                            <input type="hidden" name="txtdata_fim" value="<?= $_POST['txtdata_fim'] ?>"/>
                                                            <input type="hidden" name="valor" value="<?= $item["valor"] ?>"/>
                                                            <input type="hidden" name="promotor_id" value="<?= $key ?>"/>
                                                            <input type="hidden" name="promotor_nome" value="<?= $item["nome"] ?>"/>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <label for="dataPro<?= $i ?>">Data</label>
                                                                        <input type="text" name="data" alt="date" id="dataPro<?= $i ?>"
                                                                           value="<?= ($_POST['txtdata_inicio'] == $_POST['txtdata_fim']) ? $_POST['txtdata_inicio'] : ""?>"
                                                                           style="width: 50%" required=""/>
                                                                    </td>
                                                                    <td align="center"><button type="submit">Confirmar</button></td>
                                                                </tr>
                                                                <tr>
                                                                </tr>
                                                            </table>

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
                        </td>
                        <?
                    }
                    ?>
                    </tr>
                </table>
            </div>
        <? 
        }
        if (count($relatoriolaboratorio) > 0) { ?>
            <?
            $previsaoLaboratorio = Array();

            foreach ($relatoriolaboratorio as $item) {
                $previsaoLaboratorio[$item->laboratorio_id]["nome"] = $item->laboratorio;
                $previsaoLaboratorio[$item->laboratorio_id]["conta_id"] = $item->conta_id;
                $previsaoLaboratorio[$item->laboratorio_id]["credor_devedor_id"] = $item->credor_devedor_id;
                $previsaoLaboratorio[$item->laboratorio_id]["tipo"] = $item->tipo;
                $previsaoLaboratorio[$item->laboratorio_id]["classe"] = $item->classe;
                if($item->confirmacao_previsao_labotorio == 't'){
                    @$previsaoLaboratorio[$item->laboratorio_id]["confirmado"]++;
                }
                
                if($item->percentual_laboratorio == 't'){
                    $valor = $item->valor_total * ($item->valor_laboratorio / 100);
                }
                else{
                    $valor = $item->valor_laboratorio;
                }
                $previsaoLaboratorio[$item->laboratorio_id]["valor"] = @$previsaoLaboratorio[$item->laboratorio_id]["valor"] + $valor;
            }

            ?>
            <br>
            <br>
            <table border="1" cellspacing="0" cellpadding="5" style="margin-bottom: 200pt;">
                <thead>
                    <tr>
                        <th class="tabela_header" colspan="5" style="background-color: #ccc;">Previsão Laboratórial</th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Laboratório</th>
                        <th class="tabela_header">Valor Previsto</th>
                        <th class="tabela_header">Confirmar Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($previsaoLaboratorio as $key => $item) :
                        $i++;
                    
                        if($item["valor"] != 0) {
                        ?>
                            <tr>
                                <td ><?= $item["nome"]; ?></td>
                                <td style="text-align: right"><?= number_format($item["valor"], 2, ",", ".");?></td>
                                <td style="text-align: center">
                                    <? 
                                    if ( ($_POST['empresa'] != '') ) {
                                        if ( !isset($item["confirmado"]) ) {
                                            if($item["credor_devedor_id"] != '' && $item["conta_id"] != ''){?>
                                                <form id="confirmacao-form" name="confirmacao-form" method="get" action="<?= base_url() ?>cadastros/contaspagar/confirmarprevisaolaboratorio" target="_blank">
                                                    <input type="hidden" name="empresa" value="<?= $_POST['empresa'] ?>"/>
                                                    <input type="hidden" name="conta" value="<?= $item["conta_id"] ?>"/>
                                                    <input type="hidden" name="credordevedor" value="<?= $item["credor_devedor_id"] ?>"/>
                                                    <input type="hidden" name="tipo" value="<?= $item["tipo"] ?>"/>
                                                    <input type="hidden" name="classe" value="<?= $item["classe"] ?>"/>
                                                    <input type="hidden" name="txtdata_inicio" value="<?= $_POST['txtdata_inicio'] ?>"/>
                                                    <input type="hidden" name="txtdata_fim" value="<?= $_POST['txtdata_fim'] ?>"/>
                                                    <input type="hidden" name="valor" value="<?= $item["valor"] ?>"/>
                                                    <input type="hidden" name="laboratorio_id" value="<?= $key ?>"/>
                                                    <input type="hidden" name="laboratorio_nome" value="<?= $item["nome"] ?>"/>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <label for="dataLab<?= $i ?>">Data</label>
                                                                <input type="text" name="data" alt="date" id="dataLab<?= $i ?>"
                                                                   value="<?= ($_POST['txtdata_inicio'] == $_POST['txtdata_fim']) ? $_POST['txtdata_inicio'] : ""?>"
                                                                   style="width: 50%" required=""/>
                                                            </td>
                                                            <td align="center"><button type="submit">Confirmar</button></td>
                                                        </tr>
                                                        <tr>
                                                        </tr>
                                                    </table>

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
        ?>
    <?
    }
    else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
