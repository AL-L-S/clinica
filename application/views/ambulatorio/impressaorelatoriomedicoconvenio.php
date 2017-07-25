<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? $tipoempresa = ""; ?>
    <table>
        <thead>

            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
                <?
                $tipoempresa = $empresa[0]->razao_social;
            } else {
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
                <?
                $tipoempresa = 'TODAS';
            }
            ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONFERENCIA DOS CONVENIOS</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>

            <? if ($convenio == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO:TODOS OS CONVENIOS</th>
                </tr>
            <? } elseif ($convenio == "-1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO:PARTICULARES</th>
                </tr>
            <? } elseif ($convenio == "") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: CONVENIOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                </tr>
            <? } ?>
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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
            </tr>
            <? IF (COUNT($medico) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: <?= $medico[0]->nome; ?></th>
                </tr>
            <? } ELSE { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: TODOS</th>
                </tr>
            <? } ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>

        </thead>
    </table>











    <? if ($contador > 0) {
        ?>

        <table>
            <thead>
                <tr>
                    <td class="tabela_teste">Emissao</th>
                    <td class="tabela_teste">Convenio</th>
                    <td class="tabela_teste">Paciente</th>
                    <td class="tabela_teste">QTDE</th>
                    <td class="tabela_teste">Procedimento</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Perc. Medico</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Indice</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $convenio = "";
                $paciente = "";
                $perc = 0;
                $totalperc = 0;
                $totalgeral = 0;
                foreach ($relatorio as $item) :
                    $i++;
                    $procedimentopercentual = $item->procedimento_tuss_id;
                    $medicopercentual = $item->medico_parecer1;
                    $percentual = $this->guia->percentualmedico($procedimentopercentual, $medicopercentual);
                    $testearray = count($percentual);
                    if ($i == 1 || $item->convenio == $convenio) {
                        $qtde++;
                        $qtdetotal++;

                        if ($i == 1) {
                            ?>
                            <tr>
                                <td colspan="8"><font ><b>Convenio:&nbsp;<?= $item->convenio; ?></b></td>
                            </tr>
                        <? } ?>
                        <tr>
                            <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td>&nbsp;</td>
                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><?= $item->paciente; ?></td>
                            <? } ?>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= $item->procedimento; ?></td>
                            <?
                            if ($empresa[0]->producaomedicadinheiro == "f") {
                                if ($item->percentual_medico == "t") {
                                    $simbolopercebtual = " %";

                                    $valorpercentualmedico = $item->valor_medico;

                                    $perc = $item->valor_total * ($valorpercentualmedico / 100);
                                    $totalperc = $totalperc + $perc;
                                    $totalgeral = $totalgeral + $item->valor_total;
                                } else {
                                    $simbolopercebtual = "";
                                    $valorpercentualmedico = $item->valor_medico;

                                    $perc = $valorpercentualmedico;
                                    $totalperc = $totalperc + $perc;
                                    $totalgeral = $totalgeral + $item->valor_total;
                                }
                            } else {
                                if ($item->percentual_medico == "t") {
                                    $simbolopercebtual = " %";

                                    $valorpercentualmedico = $item->valor_medico;

                                    $perc = $item->valor_total * ($valorpercentualmedico / 100);
                                    $totalperc = $totalperc + $perc;
                                    $totalgeral = $totalgeral + $item->valor_total;
                                } else {
                                    $simbolopercebtual = "";
                                    $valorpercentualmedico = $item->valor_medico;

                                    $perc = $valorpercentualmedico;
                                    $totalperc = $totalperc + $perc;
                                    $totalgeral = $totalgeral + $item->valor_total;
                                }
                            }
                            ?>
                            <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>
                            <td style='text-align: right;'><font size="-2"><?= $valorpercentualmedico . $simbolopercebtual ?></td>
                            
                        </tr>


                        <?php
                        $paciente = $item->paciente;
                        $convenio = $item->convenio;
                    } else {
                        $convenio = $item->convenio;
                        ?>

                        <tr>
                            <td width="140px;" align="Right" colspan="9"><b>Nr. Procedimentos:&nbsp; <?= $qtde; ?></b></td>
                        </tr>
                        <?
                        $paciente = "";
                        $qtde = 0;
                        $qtde++;
                        $qtdetotal++;
                        ?>
                        <tr>
                            <td colspan="8"><font ><b>Convenio:&nbsp;<?= $item->convenio; ?></b></td>
                        </tr>
                        <tr>
                            <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td>&nbsp;</td>                        
                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><?= $item->paciente ; ?></td>
                            <? } ?>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= $item->procedimento; ?></td>
                            <?
                            if ($empresa[0]->producaomedicadinheiro == "f") {
                                if ($item->percentual_medico == "t") {
                                    $simbolopercebtual = " %";

                                    $valorpercentualmedico = $item->valor_medico;

                                    $perc = $item->valor_total * ($valorpercentualmedico / 100);
                                    $totalperc = $totalperc + $perc;
                                    $totalgeral = $totalgeral + $item->valor_total;
                                } else {
                                    $simbolopercebtual = "";
                                    $valorpercentualmedico = $item->valor_medico;

                                    $perc = $valorpercentualmedico;
                                    $totalperc = $totalperc + $perc;
                                    $totalgeral = $totalgeral + $item->valor_total;
                                }
                            } else {
                                if ($item->percentual_medico == "t") {
                                    $simbolopercebtual = " %";

                                    $valorpercentualmedico = $item->valor_medico;

                                    $perc = $item->valor_total * ($valorpercentualmedico / 100);
                                    $totalperc = $totalperc + $perc;
                                    $totalgeral = $totalgeral + $item->valor_total;
                                } else {
                                    $simbolopercebtual = "";
                                    $valorpercentualmedico = $item->valor_medico;

                                    $perc = $valorpercentualmedico;
                                    $totalperc = $totalperc + $perc;
                                    $totalgeral = $totalgeral + $item->valor_total;
                                }
                            }
                            ?>
                            <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>
                            <td style='text-align: right;'><font size="-2"><?= $valorpercentualmedico . $simbolopercebtual ?></td>
                        </tr>
                        <?
                        $paciente = $item->paciente;
                    }
                endforeach;
                ?>

                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Procedimentos:&nbsp; <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
                <tr>
                    <td width="340px;" ><b>TOTAL GERAL: &nbsp;<?= number_format($totalperc, 2, ",", "."); ?></b></td>
                    <td  width="340px;" align="center" ><b>Nr. Procedimentos: &nbsp;<?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>

        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>