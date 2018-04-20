<div class="content"> <!-- Inicio da DIV content -->
    <meta charset="utf8"/>
    <?
    $tipoempresa = "";
    $credito = 0;
    ?>
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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RELATORIO DE ESTORNOS</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="6">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="6">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left;' width="320px;"><font size="-1">Paciente</th>
                <th style='text-align: left;'width="320px;"><font size="-1">Data do Crédito</th>
                <th style='text-align: left;'width="320px;"><font size="-1">Data do Estorno</th>
                <th style='text-align: left;'width="320px;"><font size="-1">Operador Responsável</th>
                <th style='text-align: left;'width="320px;"><font size="-1">Empresa</th>
                <th style='text-align: right;'width="320px;"><font size="-1">Valor Crédito</th>
            </tr> 
            <?
            $i = 0;
            if (count($relatorio) > 0) {


                foreach ($relatorio as $item) {
                    ?>
                    <tr>
                        <td ><font size="-1"><?= $item->paciente ?></td>
                        <td style='text-align: left;'><font size="-1"><?= date("d/m/Y", strtotime($item->data_credito)) ?></td>
                        <td style='text-align: left;'><font size="-1"><?= date("d/m/Y", strtotime($item->data_estorno)) ?></td>
                        <td ><font size="-1"><?= $item->operador_estorno ?></td>
                        <td ><font size="-1"><?= $item->empresa ?></td>
                        <td style='text-align: right;'><font size="-1"><?= "R$ " . number_format($item->valor, 2, ',', '.') ?></td>
                    </tr> 
                    
                    <?
                    $i++;
                    $credito = $credito +$item->valor ;
                }
            }
            ?>
            <tr>
                <th colspan="6">&nbsp;</th>
            </tr> 
            <tr>
                <td colspan="4" style='text-align: left;'width="120px;"><font size="-1"><b>TOTAL DE ESTORNOS</b></td>
                <td style='text-align: right;'width="120px;"><font size="-1"><b><?=$i?></b></td>
            </tr> 
            <tr>
                <td colspan="4" style='text-align: left;'width="120px;"><font size="-1"><b>VALOR TOTAL DE ESTORNOS</b></td>
                <td style='text-align: right;'width="120px;"><font size="-1"><b><?="R$ " . number_format($credito, 2, ',', '.')?></b></td>
            </tr> 






    </table>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>