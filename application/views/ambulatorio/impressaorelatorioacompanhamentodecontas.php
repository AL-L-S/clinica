<div class="content"> <!-- Inicio da DIV content -->
    <?
    $i = 0;
    ?>
    <table>
        <thead>

            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">FATURAMENTO POR GRUPO DE PRODUTO</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></th>
            </tr>
            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
            <? } elseif ($grupo == "1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: SEM RM</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $grupo; ?></th>
                </tr>
            <? } ?>
           
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="5">&nbsp;</th>
            </tr>
            <? if (count($relatorioexamesgrupoprocedimento) > 0) {
                ?>

                <tr>
                    <td class="tabela_teste"><font size="-1">Grupo de produtos</th>
                    <td><font width="180px;"></td>
                    <td class="tabela_teste"><font size="-1">Quantidade</th>
                    <td class="tabela_teste" width="80px;"><font size="-1">Valor</th>
                    <td class="tabela_teste" width="80px;"><font size="-1">Percentual</th>
                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="5">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $y = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $perc = 0;
                $perctotal = 0;

                foreach ($relatorioexamesgrupoprocedimento as $itens) :
                    $valortotal = $valortotal + $itens->valor;
                endforeach;

                foreach ($relatorioexamesgrupoprocedimento as $item) :
                    $i++;


                    if ($i == 1 || $item->convenio == $convenio) {
                        if ($i == 1) {
                            $y++;
                            ?>
                            <tr>
                                <td colspan="4"><font ><b><?= utf8_decode($item->convenio); ?></b></td>
                            </tr>
                        <? }
                        ?>
                        <tr>
                            <td><font width="180px;"></td>
                            <td><font size="-2"><?= $item->nome; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>
                        </tr>
                        <?php
    
                        $qtde = $qtde + $item->quantidade;
                        $qtdetotal = $qtdetotal + $item->quantidade;
                        $valor = $valor + $item->valor;
                        $perc = (($valor ) / $valortotal) * 100;
                        $convenio = $item->convenio;
                    } else {
                        ?>  
                        <tr>
                            <td><font width="180px;"></td>
                            <td ><font size="-1"><b>TOTAL <?= utf8_decode($convenio); ?></b></td>
                            <td ><font size="-1"><b><?= $qtde; ?></b></td>
                            <td ><font size="-1"><b><?= number_format($valor, 2, ',', '.'); ?></b></td>
                            <td ><font size="-1"><b><?= substr($perc, 0, 4); ?>%</b></td>

                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                        <tr>
                            <td colspan="3"><font ><b><?= utf8_decode($item->convenio); ?></b></td>
                        </tr>
                        <tr>
                            <td><font width="180px;"></td>
                            <td><font size="-2"><?= $item->nome; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>

                        </tr>


                        <?
                        $convenio = $item->convenio;

                        $qtde = 0;
                        $qtde = $qtde + $item->quantidade;
                        $qtdetotal = $qtdetotal + $item->quantidade;
                        $valor = 0;
                        $valor = $valor + $item->valor;
                        $perc = 0;
                        $perc = (($valor ) / $valortotal) * 100;
                        $y = 0;
                    }
                endforeach;
                ?>
                <tr>
                    <td><font width="180px;"></td>
                    <td ><font size="-1"><b>TOTAL <?= utf8_decode($convenio); ?></b></td>
                    <td ><font size="-1"><b><?= $qtde; ?></b></td>
                    <td ><font size="-1"><b><?= number_format($valor, 2, ',', '.'); ?></b></td>
                    <td ><font size="-1"><b><?= substr($perc, 0, 4); ?>%</b></td>
                </tr>
            </tbody>
        </table>
        <hr>
     
    <? }
    ?>
<?
    if (count($relatoriosaida) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header">Despesa</th>
                    <th class="tabela_header">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($relatoriosaida as $item) :
                    $total = $total + $item->valor;
                    ?>
                    <tr>
                        <td ><?= utf8_decode($item->tipo); ?></td>
                        <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                    </tr>
                <? endforeach; ?>
                <tr>
            <td><b>TOTAL</b></td>
                    <td ><b><?= number_format($total, 2, ",", "."); ?></b></td>
                </tr>
            </tbody>
        </table>


        <?
        $despesa = $total;
        }?>
        <br>
<?
    if (count($relatorioentrada) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header">Recita</th>
                    <th class="tabela_header">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($relatorioentrada as $item) :
                    $total = $total + $item->valor;
                    ?>
                    <tr>
                        <td ><?= utf8_decode($item->tipo); ?></td>
                        <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                    </tr>
                <? endforeach; ?>
                <tr>
            <td><b>TOTAL</b></td>
                    <td ><b><?= number_format($total, 2, ",", "."); ?></b></td>
                </tr>
            </tbody>
</table>
<br>

        <?
        $receita = $total;
        }
        $resultado = $receita - $despesa;
        ?>
                <table>
            <tr>
            <th class="tabela_header">SALDO</th>
        <th class="tabela_header"><?= number_format($resultado, 2, ",", "."); ?></th>
        </tr>
        </table>
</div> <!-- Final da DIV content -->
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>
