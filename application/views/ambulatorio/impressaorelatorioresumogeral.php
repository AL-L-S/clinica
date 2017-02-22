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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RESUMO GERAL</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
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
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>

            <?
            $contador = count($convenio);
            ?>
            <tr>
                <td width="350px;"><font size="-1"><B>Medico</B></th>
                <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor Produzido</B></th>
                <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor Pago</B></th>
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
            $total_particular = 0;
            $medicos = 0;
            $total_medicos = 0;
            $total_medicospagar = 0;
            $perc = 0;
            $totalperc = 0;
            $total_geral = 0;
            $totalgeral = 0;
            $total_convenio = 0;
            $liquidodinheiro = 0;
            $faturamento_clinica = 0;
            foreach ($medico as $item) :
                foreach ($medicorecebido as $itens) :
                    if ($item->medico == $itens->medico) {
                        $procedimentopercentual = $itens->procedimento_tuss_id;
                        $medicopercentual = $itens->medico_parecer1;

                        $percentual = $this->guia->percentualmedico($procedimentopercentual, $medicopercentual);

                        $testearray = count($percentual);
  
                        if ($itens->percentual_medico == "t") {

                            $valorpercentualmedico = $itens->valor_medico;
                            
                            $perc = $itens->valor_total * ($valorpercentualmedico / 100);

                            $medicos = $medicos + $perc;
                        } else {
                            $simbolopercebtual = "";
                            $valorpercentualmedico = $itens->valor_medico;
                            $perc = $valorpercentualmedico;
                            $medicos = $medicos + $perc;
                        }
                    }
                endforeach;
                $i++;
                $total_medicospagar = $total_medicospagar + $medicos;
                ?>
                <tr>
                    <td><font size="-1" width="350px;"><?= utf8_decode($item->medico); ?></td>
                    <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($item->valor, 2, ',', '.') ?></td>
                    <td style='text-align: right;'><font size="-1" width="200px;"><?=  number_format($medicos, 2, ',', '.') ?></td>
                </tr>
                <?php
                $total_medicos = $total_medicos + $item->valor;
                $medicos = 0;
            endforeach;
            ?>
            <tr>
                <td><font size="-1" width="350px;"><b>Valor Total Medicos</b></td>
                <td style='text-align: right;'><font size="-1" width="200px;"><b><?= number_format($total_medicos, 2, ',', '.') ?></b></td>
                <td style='text-align: right;'><font size="-1" width="200px;"><b><?= number_format($total_medicospagar, 2, ',', '.') ?></b></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <table>
        <tbody>           

            <tr>
                <td width="350px;"><font size="-1"><B>Forma de Pagamento</B></th>
                <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor</B></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <?
            foreach ($convenio as $item) :
                foreach ($convenios as $value) :
                    if ($item->convenio == $value->nome) {

                        if ($value->dinheiro == 't') {
                            $total_particular = $total_particular + $item->valor;
                        } else {
                            $total_convenio = $total_convenio + $item->valor;
                        }
                    }
                endforeach;
                ?>
                <tr>
                    <td><font size="-1" width="350px;"><?= utf8_decode($item->convenio); ?></td>
                    <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($item->valor, 2, ',', '.') ?></td>
                </tr>
                <?php
                $total_geral = $total_geral + $item->valor;
            endforeach;

            $total_geral = $total_particular + $total_convenio;
            $liquidodinheiro = $total_particular - $total_medicospagar;
            $faturamento_clinica = $liquidodinheiro + $total_convenio;
            ?>
            <tr>
                <td><font size="-1" width="350px;">VALOR GERAL</td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($total_geral, 2, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>
    <BR>
    <BR>
    <BR>
    <table>
        <tbody>
            <tr>
                <td width="350px;"><font size="-1"><B>Resumo</B></th>
                <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor</B></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <td><font size="-1" width="350px;">VALOR LIQUIDO DINHEIRO</td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($liquidodinheiro, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td><font size="-1" width="350px;">VALOR CONVENIO</td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($total_convenio, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td><font size="-1" width="350px;">VALOR LIQUIDO DA CLINICA</td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($faturamento_clinica, 2, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>