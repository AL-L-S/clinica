<meta charset="utf8"/>
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
            <? if ($conveniotipo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS CONVENIOS</th>
                </tr>
            <? } elseif ($conveniotipo == "-1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PARTICULARES</th>
                </tr>
            <? } elseif ($conveniotipo == "") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIOS</th>
                </tr>
                <?
            } else {
                $i = 1;
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                </tr>

            <? } ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="5">&nbsp;</th>
            </tr>
            <? if ($contador > 0) {
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
                $RAIOX = 0;
                $US = 0;
                $DENSITOMETRIA = 0;
                $MAMOGRAFIA = 0;
                $RM = 0;
                $NUMERORAIOX = 0;
                $NUMEROUS = 0;
                $NUMERODENSITOMETRIA = 0;
                $NUMEROMAMOGRAFIA = 0;
                $NUMERORM = 0;
                $AUDIOMETRIA = 0;
                $NUMEROAUDIOMETRIA = 0;
                $ELETROCARDIOGRAMA = 0;
                $NUMEROELETROCARDIOGRAMA = 0;
                $ELETROENCEFALOGRAMA = 0;
                $NUMEROELETROENCEFALOGRAMA = 0;
                $ESPIROMETRIA = 0;
                $NUMEROESPIROMETRIA = 0;
                $LABORATORIAL = 0;
                $NUMEROLABORATORIAL = 0;
                $FISIOTERAPIA = 0;
                $NUMEROFISIOTERAPIA = 0;
                $ECOCARDIOGRAMA = 0;
                $NUMEROECOCARDIOGRAMA = 0;
                $TOMOGRAFIA = 0;
                $NUMEROTOMOGRAFIA = 0;
                $CONSULTA = 0;
                $NUMEROCONSULTA = 0;
                $perc = 0;
                $perctotal = 0;

                foreach ($relatorio as $itens) :
                    $valortotal = $valortotal + $itens->valor;
                endforeach;
                
                $resumoPagamento = array();

                foreach ($relatorio as $item) :
                    $i++;
                    
                    $resumoPagamento[$item->grupo]["valor"] = @$resumoPagamento[$item->grupo]["valor"] + $item->valor;
                    $resumoPagamento[$item->grupo]["quantidade"] = @$resumoPagamento[$item->grupo]["quantidade"] + $item->quantidade;

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
                            <td><font size="-2"><?= $item->grupo; ?></td>
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
                            <td><font size="-2"><?= $item->grupo; ?></td>
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
        <?
        if ($conveniotipo == '0') {
            ?>
            <table >
                <tbody>
                    <tr>
                        <td width="140px;" colspan="4" bgcolor="#C0C0C0"><center><font size="-1">Resumo da Clinica</center></td>
                    </tr>
                    <? foreach ($resumoPagamento as $key => $resumo) { ?>
                        <tr>
                            <td width="140px;"><font size="-1"><?= @$key; ?></td>
                            <td width="140px;"><font size="-1"><?= @$resumo['quantidade']; ?></td>
                            <td><font size="-2"></td>
                            <td width="200px;"><font size="-1"> <?= number_format($resumo['valor'], 2, ',', '.'); ?></td>
                        </tr>
                        
                    <? } ?>
                    <tr>
                        <td width="140px;" bgcolor="#C0C0C0"><font size="-1">TOTAL GERAL</td>
                        <td width="140px;" bgcolor="#C0C0C0"><font size="-1"><?= $qtdetotal; ?></td>
                        <td><font size="-2" bgcolor="#C0C0C0"></td>
                        <td width="200px;" bgcolor="#C0C0C0"><font size="-1">Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></td>
                    </tr>
                </tbody>

            </table>
        <? } ?>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
