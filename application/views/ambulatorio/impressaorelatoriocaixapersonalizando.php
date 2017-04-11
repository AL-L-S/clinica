<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>CONFERENCIA CAIXA (Personalizado)</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <h4>PACIENTE: <?= $paciente; ?></h4>

    <hr>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table cellpadding="5">
            <thead>

                <tr>
                    <th class="tabela_header"><font size="4">Paciente</font></th>
                    <th class="tabela_header"><font size="4">Procedimento</font></th>
                    <th class="tabela_header"><font size="4">Convenio</font></th>
                    <th class="tabela_header" style="text-align: right"><font size="4">QTDE</font></th>
                    <th class="tabela_header" width="80px;" style="text-align: right"><font size="4">Percentual</font></th>
                </tr>
                <!--<tr><td colspan="8"><hr></td></tr>-->
            </thead>
            <tbody>
                <?
                foreach ($relatorio as $value):
                    $DINHEIRO = 0;
                    $NUMERODINHEIRO = 0;
                    $DEBITO_CONTA = 0;
                    $NUMERODEBITO_CONTA = 0;
                    $CARTAOVISA = 0;
                    $NUMEROCARTAOVISA = 0;
                    $CARTAOMASTER = 0;
                    $NUMEROCARTAOMASTER = 0;
                    $CARTAOHIPER = 0;
                    $CARTAOCREDITO = 0;
                    $NUMEROCARTAOCREDITO;
                    $NUMEROCARTAOHIPER = 0;
                    $CARTAOELO = 0;
                    $NUMEROCARTAOELO = 0;
                    $CHEQUE = 0;
                    $NUMEROCHEQUE = 0;
                    $OUTROS = 0;
                    $NUMEROOUTROS = 0;
                    $pendentes = 0;

                    $verificador = true;

                    //pegando o valor total dessa guia
                    $valTotal = $this->guia->relatoriocaixapersonalizadoprocedimentosvalortotal($value->ambulatorio_guia_id);
                    $desconto_tot = 0;

                    $data = array();
                    $numero = array();
                    $desconto = array();

                    foreach ($formapagamento as $item2) {
                        $data[$item2->nome] = 0;
                        $numero[$item2->nome] = 0;
                        $desconto[$item2->nome] = 0;
                        $procedimento[$item2->nome] = 0;
                    }

                    foreach ($relatorioprocedimentos as $item) :
//                        var_dump($item->guia_id);die;
                        if ($value->ambulatorio_guia_id == $item->guia_id):
                            if ($verificador) {
                                ?>
                                <tr>
                                    <td colspan="8"><font><b>Guia: <?= $value->ambulatorio_guia_id; ?></b></font></td>
                                </tr>
                            <? }
                            ?>
                            <tr>
                                <?
                                $cor = ($item->faturado == 'f')? "red": 'black';
                                
                                if ($verificador):
                                    $verificador = false;
                                    ?>
                                    <td style="text-align: left"><?= $item->paciente; ?></td>
                                <? else: ?>
                                    <td style="text-align: left">&nbsp;</td>
                                <? endif; ?>
                                <td style="text-align: left; color: <?=$cor?>"><?= $item->procedimento; ?></td>
                                <td style="text-align: left; color: <?=$cor?>"><?= $item->convenio; ?></td>
                                <td style="text-align: right; color: <?=$cor?>"><?= $item->quantidade; ?></td>
                                <?
                                $perc = (((int) $item->quantidade * (float) $item->valor_total) / $valTotal) * 100;
                                $desc = ( ((int) $item->quantidade * (float) $item->valor_total) * (float) $item->desconto) / 100;
                                $desconto_tot += $desc;
                                
                                foreach ($formapagamento as $value5) {
                                    if ($item->forma_pagamento == $value5->nome) {
                                        $data[$value5->nome] = $data[$value5->nome] + $item->valor1;
                                        $numero[$value5->nome] ++;
                                        $desconto[$value5->nome] = $desconto[$value5->nome] + $item->desconto;
                                    }
                                }
                                foreach ($formapagamento as $value5) {
                                    if ($item->forma_pagamento_2 == $value5->nome) {
                                        $data[$value5->nome] = $data[$value5->nome] + $item->valor2;
                                        $numero[$value5->nome] ++;
                                        $desconto[$value5->nome] = $desconto[$value5->nome] + $item->desconto;
                                    }
                                }
                                foreach ($formapagamento as $value5) {
                                    if ($item->forma_pagamento_3 == $value5->nome) {
                                        $data[$value5->nome] = $data[$value5->nome] + $item->valor3;
                                        $numero[$value5->nome] ++;
                                        $desconto[$value5->nome] = $desconto[$value5->nome] + $item->desconto;
                                    }
                                }
                                foreach ($formapagamento as $value5) {
                                    if ($item->forma_pagamento_4 == $value5->nome) {
                                        $data[$value5->nome] = $data[$value5->nome] + $item->valor4;
                                        $numero[$value5->nome] ++;
                                        $desconto[$value5->nome] = $desconto[$value5->nome] + $item->desconto;
                                    }
                                }
                                
                                if ($item->forma_pagamento == "") {
                                    $OUTROS = $OUTROS + $item->valor_total;
                                    $NUMEROOUTROS++;
                                }
                                if ($item->faturado == 'f') {
                                    $pendentes ++;
                                }
                                $valor = 0;
                                $valor = $valor + $item->valor_total;
                                $y = 0;
                                $y++;
                                ?>
                                <td style="text-align: right; color: <?=$cor?>"><?= number_format($perc, 2, ',', '.'); ?> %</td>
                            </tr>
                            <?
                        endif;

                    endforeach;

                    if (!$verificador):
                        ?>
                        <tr><td colspan="8"><span class="totais">Valor Total = R$ <?= number_format($valTotal, 2, ',', '.') ?>  <span class="barra">|</span>  Desconto = R$ <?= $desconto_tot ?>  <span class="barra">|</span>  Valor Ajustado = R$ <?= number_format(($valTotal - $desconto_tot), 2, ',', '.') ?></span></td></tr>
                        
                        <tr><td colspan="8"></td></tr>
                        
                        <tr>
                            <td colspan="8">

                                <table>
                                    <thead>
                                        <tr>
                                            <th width="270px;"><font size="2">Forma Pagamento</font></th>
                                            <th style="text-align: right" width="70px;"><font size="2">Ajuste (%)</font></th>
                                                        <!--<th class="tabela_header"><font size="4">Parcela</font></th>-->
                                            <!--<th style="text-align: right" width="70px;"><font size="2">Vlr Proc</font></th>-->
                                            <th style="text-align: right" width="70px;"><font size="2">Vlr Total</font></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach ($formapagamento as $value) {
                                            if(@$data[$value->nome] == 0 || !isset($data[$value->nome])){
                                                continue;
                                            } ?>
                                        
                                        
                                            <tr>
                                                <td ><font size="-1"><?= $value->nome ?></td>
                                                <td style="text-align: right"><font size="-1"><?= $value->ajuste; ?></td>
                                                <!--<td style="text-align: right"><font size="-1"><?= number_format($data[$value->nome], 2, ',', '.'); ?></td>-->
                                                <td style="text-align: right"><font size="-1"><?= number_format($data[$value->nome], 2, ',', '.'); ?></td>
                                            </tr>   
                                        <? } ?>
                                        <tr>
                                            <td width="140px;"><font size="-1">PENDENTES</td>
                                            <td width="140px;" style="text-align: right"><font size="-1"><?= $NUMEROOUTROS ?></td>
                                            <td width="200px;" style="text-align: right"><font size="-1"><?= number_format($OUTROS, 2, ',', '.'); ?></td>
                                        </tr>  
                                        <?
                                        $TOTALCARTAO = 0;
                                        $QTDECARTAO = 0;
                                        $TOTALDINHEIRO = 0;
                                        foreach ($formapagamento as $value) {
                                            if ($value->cartao != 'f') {
                                                $TOTALCARTAO = $TOTALCARTAO + $data[$value->nome];
                                                $QTDECARTAO = $QTDECARTAO + $numero[$value->nome];
                                            }
                                            else{
                                                $TOTALDINHEIRO = $TOTALDINHEIRO + $data[$value->nome];
                                            }
                                        }
                                        $valortotal = $TOTALDINHEIRO + $TOTALCARTAO;
                                        ?>
                                        <tr>
                                            <td width="140px;"><font size="-1">TOTAL CARTAO</td>
                                            <!--<td width="140px;"><font size="-1">Nr. Cart&otilde;es: <?= $QTDECARTAO; ?></td>-->
                                            <td width="200px;" colspan="2"><font size="-1">Total Cartao: <?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="140px;"><font size="-1">TOTAL GERAL</td>
                                            <!--<td width="140px;"><font size="-1">Nr. Exa: <?= @$i; ?></td>-->
                                            <td width="200px;" colspan="2"><font size="-1">Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr><td colspan="8"><hr></td></tr>
                        <?
                    endif;
                endforeach;
                ?>
                        
            </tbody>
        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<style>
    .totais{
        text-transform: uppercase;
        font-weight: bold;
        font-size: 11pt;
    }
    .barra{
        font-size: 15pt;
    }
</style>
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
