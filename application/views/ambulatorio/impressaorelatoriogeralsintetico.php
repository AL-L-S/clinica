<div class="content"> <!-- Inicio da DIV content -->
    <?
    $horario = 12;
//    $ano = date("2016");
//    var_dump($ano); die;
    $index = 1;
    if ($horario > 1) {
        for ($index = 1; $index <= $horario; $index++) {

            $particular[] = $this->guia->consultargeralparticular($index, $ano);
            $particularfaturado[] = $this->guia->consultargeralparticularfaturado($index, $ano);
            $particularnaofaturado[] = $this->guia->consultargeralparticularnaofaturado($index, $ano);
            $convenio[] = $this->guia->consultargeralconvenio($index, $ano);
            $conveniofaturado[] = $this->guia->consultargeralconveniofaturado($index, $ano);
            $convenionaofaturado[] = $this->guia->consultargeralconvenionaofaturado($index, $ano);
            $geral[] = $this->guia->consultargeralsintetico($index, $ano);
        }
    }
    ?>
    <table>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="6"><?= $empresa[0]->razao_social; ?></th>
        <tr>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
        <tr>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EVOLUCAO MENSAL DE FATURAMENTO</th>
        <tr>
        <tr>
            <th style='width:10pt;border:solid windowtext 1.0pt;
                border-bottom:none;mso-border-top-alt:none;border-left:
                none;border-right:none;' colspan="13">&nbsp;</th>
        </tr>
        <tr>
            <td class="tabela_teste" width="200px;">&nbsp;</th>
<?
                if ($horario > 1) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>JAN <?= $ano; ?></b></th>
            <? }if ($horario > 2) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>FEV <?= $ano; ?></b></th>
            <? } if ($horario > 3) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>MAR <?= $ano; ?></b></th>
            <? } if ($horario > 4) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>ABR <?= $ano; ?></b></th>
            <? } if ($horario > 5) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>MAI <?= $ano; ?></b></th>
            <? } if ($horario > 6) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>JUN <?= $ano; ?></b></th>
            <? } if ($horario > 7) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>JUL <?= $ano; ?></b></th>
            <? } if ($horario > 8) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>AGO <?= $ano; ?></b></th>
            <? } if ($horario > 9) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>SET <?= $ano; ?></b></th>
            <? } if ($horario > 10) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>OUT <?= $ano; ?></b></th>
            <? } if ($horario > 11) { ?>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>NOV <?= $ano; ?></b></th>
                <td class="tabela_teste" width="70px;"><font size="-2"><b>DEZ <?= $ano; ?></b></th>
            <? } ?>
        </tr>
        <tr>
            <th style='width:10pt;border:solid windowtext 1.0pt;
                border-bottom:none;mso-border-top-alt:none;border-left:
                none;border-right:none;' colspan="13">&nbsp;</th>
        </tr>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">AN&Aacute;LISE GERAL</th>
        <tr>
        <tr>
            <td colspan="4"><b>Convenio</b></td>
        </tr>
        <tr>
            <td width="200px;">Faturado</td>
            <?
            foreach ($conveniofaturado as $valor) {
                foreach ($valor as $iten) {


                    if (empty($iten->total)) {
                        ?>
                        <!--<td width="70px;"><font size="-2">0</td>-->
                    <? } else { ?>
                        <td width="70px;"><font size="-2"><?= number_format($iten->total, 2, ',', '.'); ?></td>

                        <?
                    }
                }
            }
            ?>
        </tr>
        <tr>
            <td width="200px;">Aberto</td>
            <?
            foreach ($convenionaofaturado as $valor) {
                foreach ($valor as $iten) {


                    if (empty($iten->total)) {
                        ?>
                        <td width="70px;"><font size="-2">0</td>
                    <? } else { ?>
                        <td width="70px;"><font size="-2"><?= number_format($iten->total, 2, ',', '.'); ?></td>

                        <?
                    }
                }
            }
            ?>
        </tr>
        </tr>
        <tr>
            <td width="200px;"></td>
            <?
            foreach ($convenionaofaturado as $valor) {
                foreach ($valor as $iten) {
                    ?>
                    <td width="70px;"><font size="-2">----------------</td>
                    <?
                }
            }
            ?>
        </tr>
        <tr>
            <td width="200px;"><b>TOTAL Conv.</b></td>
            <?
            foreach ($convenio as $valor) {
                foreach ($valor as $iten) {


                    if (empty($iten->total)) {
                        ?>
                        <td width="70px;"><font size="-2">0</td>
                    <? } else { ?>
                        <td width="70px;"><font size="-2"><?= number_format($iten->total, 2, ',', '.'); ?></td>

                        <?
                    }
                }
            }
            ?>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4"><b>Particulares</b></td>
        </tr>
        <tr>
            <td width="200px;">Faturado</td>
            <?
            foreach ($particularfaturado as $value) {
                foreach ($value as $item) {


                    if (empty($item->total)) {
                        ?>
                        <td width="70px;"><font size="-2">0</td>
                    <? } else { ?>
                        <td width="70px;"><font size="-2"><?= number_format($item->total, 2, ',', '.'); ?></td>

                        <?
                    }
                }
            }
            ?>
        </tr>
        <tr>
            <td width="200px;">Aberto</td>
            <?
            foreach ($particularnaofaturado as $value) {
                foreach ($value as $item) {


                    if (empty($item->total)) {
                        ?>
                        <td width="70px;"><font size="-2">0</td>
                    <? } else { ?>
                        <td width="70px;"><font size="-2"><?= number_format($item->total, 2, ',', '.'); ?></td>

                        <?
                    }
                }
            }
            ?>
        </tr>
        <tr>
            <td width="200px;"></td>
            <?
            foreach ($particular as $valor) {
                foreach ($valor as $iten) {
                    ?>
                    <td width="70px;"><font size="-2">----------------</td>
                    <?
                }
            }
            ?>
        </tr>
        <tr>
            <td width="200px;"><b>TOTAL Part.</b></td>
            <?
            foreach ($particular as $value) {
                foreach ($value as $item) {


                    if (empty($item->total)) {
                        ?>
                        <td width="70px;"><font size="-2">0</td>
                    <? } else { ?>
                        <td width="70px;"><font size="-2"><?= number_format($item->total, 2, ',', '.'); ?></td>

                        <?
                    }
                }
            }
            ?>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td width="200px;"></td>
            <?
            foreach ($particular as $valor) {
                foreach ($valor as $iten) {
                    ?>
                    <td width="70px;"><font size="-2">========</td>
                    <?
                }
            }
            ?>
        </tr>

        <tr>
            <td width="200px;"><b>TOTAL GERAL</b></td>
            <?
            foreach ($geral as $valor) {
                foreach ($valor as $iten) {


                    if (empty($iten->total)) {
                        ?>
                        <td width="70px;"><font size="-2">0</td>
                    <? } else { ?>
                        <td width="70px;"><font size="-2"><?= number_format($iten->total, 2, ',', '.'); ?></td>

                        <?
                    }
                }
            }
            ?>
        </tr>
    </table>
    <? ?>
</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>