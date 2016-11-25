<div class="content"> <!-- Inicio da DIV content -->
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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONFERENCIA DOS CONVENIOS CH</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></th>
            </tr>
            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
            <?
            } else {
                if (isset($relatorio[0]->grupo)) {
                    $nome_grupo = $relatorio[0]->grupo;
                } else {
                    $nome_grupo = $grupo;
                }
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $nome_grupo; ?></th>
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
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                </tr>
<? } ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="10">&nbsp;</th>
            </tr>
            <? if ($contador > 0) {
                ?>
                <tr>
                    <td class="tabela_teste" width="80px;">Atend.</th>
                    <td class="tabela_teste">Emissao</th>
                    <td class="tabela_teste" width="150px;">Paciente</th>
                    <td class="tabela_teste" width="150px;">Medico</th>
                    <td class="tabela_teste">Autorizacao</th>
                    <td class="tabela_teste" >Exame</th>
                    <td class="tabela_teste">Codigo</th>
                    <td class="tabela_teste">QTDE</th>
                    <td class="tabela_teste" width="80px;">QTDE. CH</th>
                    <td class="tabela_teste" width="80px;">V. CH</th>
                    <td class="tabela_teste" width="80px;">V. Total</th>
                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="10">&nbsp;</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $medicamento = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $paciente = "";
                $contadorpaciente = "";
                $contadorpacientetotal = "";
                foreach ($relatorio as $item) :
                    if ($item->grupo == 'MEDICAMENTO') {
                        $medicamento++;
                    }
                    $i++;
                    if ($i == 1 || $item->convenio == $convenio) {
                        $valortotal = $valortotal + $item->valor_total;
                        $valor = $valor + $item->valor_total;
                        $qtde++;
                        $qtdetotal++;

                        if ($i == 1) {
                            ?>
                            <tr>
                                <td colspan="8"><font ><b>Convenio:&nbsp;<?= utf8_decode($item->convenio); ?></b></td>
                            </tr>
            <? } ?>
                        <tr>

            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
            <? } else { ?>
                                <td><?= $item->guia_id; ?></td>
                                <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td><?= utf8_decode($item->paciente); ?></td>
                                <?
                                $contadorpaciente++;
                                $contadorpacientetotal++;
                            }
                            ?>
                            <td><?= utf8_decode(substr($item->medico, 0, 20)); ?></td>
                            <td><?= $item->autorizacao; ?></td>
                            <td><?= utf8_decode($item->exame); ?></td>
                            <td><?= $item->codigo; ?></td>
                            <td><?= $item->quantidade; ?></td>
                            <td><?= number_format($item->qtdech, 2, ',', '.') ?></td>
                            <td><?= number_format($item->valorch, 2, ',', '.') ?></td>
                            <td><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                        </tr>


                        <?php
                        $paciente = $item->paciente;
                        $convenio = $item->convenio;
                    } else {
                        $convenio = $item->convenio;
                        ?>
                        <tr>
                            <td width="200px;" align="Right" colspan="9"><b>Valor Previsto <?= number_format($valor, 2, ',', '.'); ?></b></td>
                        </tr>
                        <tr>
                            <td width="2000px;" align="Right" colspan="9"><b>Nr. Pacientes: <?= $contadorpaciente; ?></b></td>
                        </tr>
                        <tr>
                            <td width="140px;" align="Right" colspan="9"><b>Nr. Exa: <?= $qtde; ?></b></td>
                        </tr>
                        <?
                        $paciente = "";
                        $valor = 0;
                        $qtde = 0;
                        $contadorpaciente = 0;
                        $valortotal = $valortotal + $item->valor_total;
                        $valor = $valor + $item->valor_total;
                        $qtde++;
                        $qtdetotal++;
                        ?>
                        <tr>
                            <td colspan="8"><font ><b>Convenio:&nbsp;<?= utf8_decode($item->convenio); ?></b></td>
                        </tr>
                        <tr>
            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
            <? } else { ?>
                                <td><?= $item->guia_id; ?></td>
                                <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td><?= utf8_decode($item->paciente); ?></td>
                                <?
                                $contadorpaciente++;
                                $contadorpacientetotal++;
                            }
                            ?>
                            <td><?= utf8_decode(substr($item->medico, 0, 20)); ?></td>
                            <td><?= $item->autorizacao; ?></td>
                            <td><?= utf8_decode($item->exame); ?></td>
                            <td><?= $item->codigo; ?></td>
                            <td><?= $item->quantidade; ?></td>
                            <td><?= number_format($item->valortotal, 2, ',', '.') ?></td>
                            <td><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                        </tr>
                        <?
                        $paciente = $item->paciente;
                    }
                endforeach;
                ?>
                <tr>
                    <td width="200px;" align="Right" colspan="9"><b>Valor Previsto <?= number_format($valor, 2, ',', '.'); ?></b></td>
                </tr>
                <tr>
                    <td width="2000px;" align="Right" colspan="9"><b>Nr. Pacientes: <?= $contadorpaciente; ?></b></td>
                </tr>
                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Exa: <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <?
        $qtdetotal = $qtdetotal - $medicamento;
        ?>
        <hr>
        <table>
            <tbody>
                <tr>
                    <td width="140px;" align="Right" >TOTAL GERAL</td>
                    <td width="200px;" align="Right" >Nr. Pacienets: <?= $contadorpacientetotal; ?></td>
                    <td width="140px;" align="Right" >Nr. Exa: <?= $qtdetotal; ?></td>
                    <td width="200px;" align="Right">Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></td>
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