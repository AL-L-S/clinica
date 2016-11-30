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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">FATURAMENTO POR PER&Iacute;ODO DE COMPET&Ecirc;NCIA</th>
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
            <? } elseif($grupo == "1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: SEM RM</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $grupo; ?></th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>

            <? if ($contador > 0) {
                ?>
                <tr>
                    <td width="180px;"><font size="-1"><B>Convenio</B></th>
                    <td style='text-align: right;'width="120px;"><font size="-1"><B>Qtde Guias</B></th>
                    <td style='text-align: right;' width="200px;"><font size="-1"><B>Total Faturado</B></th>
                    <td style='text-align: right;'width="80px;"><font size="-1"><B>Percentual</B></th>
                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="4">&nbsp;</th>
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
                foreach ($relatorio as $itens) :
                    $valortotal = $valortotal + $itens->valor;
                endforeach;
                foreach ($listarconvenio as $value) :

                    foreach ($relatorio as $item) :

                        if ($value->nome == $item->convenio) {
                            $i = 1;
                            $perc = (($item->valor ) / $valortotal) * 100;
                            ?>
                            <tr>
                                <td><font size="-1" width="180px;"><?= utf8_decode($item->convenio); ?></td>
                                <td style='text-align: right;'><font size="-1" width="120px;"><?= $item->quantidade; ?></td>
                                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($item->valor, 2, ',', '.') ?></td>
                                <td style='text-align: right;'><font size="-1" width="80px;"><?= substr($perc, 0, 4); ?>%</td>
                            </tr>
                            <?php
                            $qtdetotal = $qtdetotal + $item->quantidade;
                            $perctotal = $perctotal + $perc;
                        }
                    endforeach;
                    if ($i == 0) {
                        ?>
                        <tr>
                            <td><font size="-1" width="180px;"><?= utf8_decode($value->nome); ?></td>
                            <td style='text-align: right;'><font size="-1" width="120px;">0</td>
                            <td style='text-align: right;'><font size="-1" width="200px;">0</td>
                            <td style='text-align: right;'><font size="-1" width="80px;">0%</td>
                        </tr>

                        <?
                    }
                    $i = 0;
                endforeach;
                ?>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="4">&nbsp;</th>
                </tr>
                <tr>
                    <td width="180px;"><font size="-1"><b>TOTAL GERAL</b></td>
                    <td width="120px;"><font size="-1"><b><?= $qtdetotal; ?></b></td>
                    <td width="200px;"><font size="-1"><b><?= number_format($valortotal, 2, ',', '.'); ?></b></td>
                </tr>
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
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>