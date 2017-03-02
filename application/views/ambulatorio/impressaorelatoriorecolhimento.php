<div class="content"> <!-- Inicio da DIV content -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONFERENCIA DOS CONVENIOS</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
            </tr>
            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $grupo; ?></th>
                </tr>
            <? } ?>
            <? if ($procedimentos == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROCEDIMENTO: TODOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROCEDIMENTO: <?= utf8_decode($procedimentos[0]->nome); ?></th>
                </tr>
            <? } ?>
            <? if ($medico == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: TODOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: <?= utf8_decode($medico[0]->operador); ?></th>
                </tr>
            <? } ?>
            <? if ($convenio == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS CONVENIOS</th>
                </tr>
            <? } elseif ($convenio == "-1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PARTICULARES</th>
                </tr>
            <? } elseif ($convenio == "") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= utf8_decode($convenios[0]->nome); ?></th>
                </tr>
            <? } ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="8">&nbsp;</th>
            </tr>
        </thead>
    </table>

    <?
    $valorFaturado = 0;
    $valorReceber = 0;
    $valorTotal = 0;
    foreach ($relatorio as $value) :
        $valorProc = (float) $value->valor_total;
        if ($value->faturado == 't') {
            $valorFaturado += $valorProc;
        } else {
            $valorReceber += $valorProc;
        }
        $valorTotal += $valorProc;
    endforeach;
    ?>
    <table cellpadding="5">
        <tr>
            <td><p style="font-size: 10pt; font-weight: bold">TOTAL FATURADO</p></td>
            <td><?= number_format($valorTotal, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td><p style="font-size: 10pt; font-weight: bold">TOTAL RECEBIDO</p></td>
            <td><?= number_format($valorFaturado, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td><p style="font-size: 10pt; font-weight: bold">TOTAL A RECEBER</p></td>
            <td><?= number_format($valorReceber, 2, ',', '.'); ?></td>
        </tr>
    </table>
    <table cellpadding="10" cellspacing="10">
        <thead>
            <? if (count($relatorio) > 0) {
                ?>
                <tr>
                    <!--<td class="tabela_teste" width="80px;">Atend.</th>-->
                    <th class="tabela_teste"  colspan="50"><center>PROTOCOLO DE RECOLHIMENTO</center></th>
            </tr>
            <tr>
                <!--<td class="tabela_teste" width="80px;">Atend.</th>-->
                <th class="tabela_teste" >Emissao</th>
            <th class="tabela_teste" >Convenio</th>
            <th class="tabela_teste" >Paciente</th>
            <th class="tabela_teste" >Tipo</th>
            <th class="tabela_teste" >Executante</th>
            <th class="tabela_teste" >Local de Atend.</th>
            <th class="tabela_teste" >Guia</th>
            </tr>
            </thead>
            <tbody>
                <? foreach ($relatorio as $value) : ?>
                    <tr>
                        <td><?= date("d/m/Y", strtotime($value->data)); ?></td>
                        <td><?= $value->convenio; ?></td>
                        <td><?= $value->paciente; ?></td>
                        <td><?= $value->tipo; ?></td>
                        <td><?= $value->medico; ?></td>
                        <td><?= $value->empresa; ?></td>
                        <td><?= $value->guia_id; ?></td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    <? } ?>


</div>  <!-- Final da DIV content -->
<!--<meta http-equiv="content-type" content="text/html;charset=utf-8" />-->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>