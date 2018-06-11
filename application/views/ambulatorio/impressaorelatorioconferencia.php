<html>
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
            <? if (isset($_POST['filtro_hora'])) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">DE <?= $_POST['horario_inicio']; ?>hrs as <?= $_POST['horario_fim']; ?>hrs</th>
                </tr>
            <? } ?>
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
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PROCEDIMENTO: <?= $procedimentos[0]->nome; ?></th>
                </tr>
            <? } ?>
            <? if ($medico == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: TODOS</th>
                </tr>
            <? } else { ?>

                <?
                foreach ($medico as $item) {
                    $medicos_array[] = $item->operador;
                }
                $medicos = array_unique($medicos_array);
                $medicos = implode(', ', $medicos);
//                $medicos = $medico;
//                var_dump($medicos);
//                die;
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: <?= $medicos; ?></th>
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
                    none;border-right:none;' colspan="8">&nbsp;</th>
            </tr>
            <? if (count($relatorio) > 0) {
                ?>
                <tr>
                    <th class="tabela_teste" width="80px;">Atend.</th>
                    <th class="tabela_teste" >Emissao</th>
                    <th class="tabela_teste" width="350px;">Paciente</th>
                    <th class="tabela_teste" >Autorizacao</th>
                    <th class="tabela_teste" >Procedimentos</th>
                    <th class="tabela_teste" >Codigo</th>
                    <th class="tabela_teste" >QTDE</th>
                    <? if ($_POST['aparecervalor'] == '1') { ?>
                        <th class="tabela_teste" width="80px;">V. UNIT</th>
                        <th class="tabela_teste" width="80px;">V. Total</th>
                        <th class="tabela_teste" width="80px;">Total Geral</th>                        
                    <? }
                    ?>

                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="8">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $valor = 0;
                $valortotal = 0;
                $medicamento = 0;
                $convenio = "";
                $paciente = "";
                $totalpaciente = 0;
                $maximo = 0;
                $contadorpaciente = "";
                $contadorpacientetotal = "";
                foreach ($relatorio as $key => $value) {
                    $maximo = $key;
                }

                foreach ($relatorio as $item) :
                    $p = $i + 1;
                    if ($item->grupo == 'MEDICAMENTO' || $item->grupo == 'MATERIAL') {
                        $medicamento = $medicamento + $item->quantidade;
                    }
                    $i++;
                    if ($p > $maximo) {
                        $p = $maximo;
                    }
                    $totalpaciente = $totalpaciente + $item->valor_total;
                    if ($i == 1 || $item->convenio == $convenio) {
                        $valortotal = $valortotal + $item->valor_total;
                        $valor = $valor + $item->valor_total;
                        $qtde++;
                        $qtdetotal = $qtdetotal + $item->quantidade;

                        if ($i == 1) {
                            ?>
                            <tr>
                                <td colspan="8"><font ><b>Convenio:&nbsp;<?= $item->convenio; ?></b></td>
                            </tr>
                        <? } ?>
                        <tr>

                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><?= $item->guia_id; ?></td>
                                <td>
                                    <?
                                    if ($item->data_antiga != "")
                                        echo " ** ";

                                    if (isset($_POST['filtro_hora'])) {
                                        echo date("d/m/Y H:i", strtotime($item->data . " " . $item->inicio));
                                    } else {
                                        echo date("d/m/Y", strtotime($item->data));
                                    }

                                    if ($item->data_antiga != "")
                                        echo " ** ";
                                    ?>
                                </td>
                                <td><?= $item->paciente; ?></td>
                                <?
                                $contadorpaciente++;
                                $contadorpacientetotal++;
                            }
                            ?>
                            <td><?= $item->autorizacao; ?></td>
                            <td><?= $item->exame; ?></td>
                            <td><?= $item->codigo; ?></td>
                            <td><?= $item->quantidade; ?></td>
                            <? if ($_POST['aparecervalor'] == '1') { ?>
                                <td ><?= number_format($item->valor, 2, ',', '.') ?></td>
                                <td <? if ($item->ajuste_cbhpm == 't' && $item->valor != $item->valor_total) { ?>style="color: blue;" title="Ajustado" <? } ?>><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                                <? if ($item->paciente != $relatorio[$p]->paciente || $p == $maximo) { ?>
                                    <td><b><?= number_format($totalpaciente, 2, ',', '.') ?></b></td>
                                    <?
                                    $totalpaciente = 0;
                                } else {
                                    ?>
                                    <td></td>
                                <? } ?>
                            <? } ?>
                        </tr>


                        <?
                        $paciente = $item->paciente;
                        $convenio = $item->convenio;
                    } else {
                        $convenio = $item->convenio;
                        ?>
                        <? if ($_POST['aparecervalor'] == '1') { ?>

                            <tr>
                                <td width="200px;" align="Right" colspan="9"><b>Valor Previsto <?= number_format($valor, 2, ',', '.'); ?></b></td>
                            </tr>
                        <? } ?>
                        <tr>
                            <td width="2000px;" align="Right" colspan="9"><b>Nr. Pacientes: <?= $contadorpaciente; ?></b></td>
                        </tr>
                        <tr>
                            <td width="140px;" align="Right" colspan="9"><b>Nr. Procedimentos: <?= $qtde; ?></b></td>
                        </tr>
                        <?
                        $paciente = "";
                        $valor = 0;
                        $qtde = 0;
                        $contadorpaciente = 0;
                        $valortotal = $valortotal + $item->valor_total;
                        $valor = $valor + $item->valor_total;
                        $qtde++;

                        $qtdetotal = $qtdetotal + $item->quantidade;
                        ?>
                        <tr>
                            <td colspan="8"><font ><b>Convenio:&nbsp;<?= $item->convenio; ?></b></td>
                        </tr>
                        <tr>
                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><?= $item->guia_id; ?></td>
                                <td><?
                                    if ($item->data_antiga != "") {
                                        echo " ** ";
                                    }
                                    ?><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?><?
                                    if ($item->data_antiga != "") {
                                        echo " ** ";
                                    }
                                    ?></td>
                                <td><?= $item->paciente; ?></td>
                                <?
                                $contadorpaciente++;
                                $contadorpacientetotal++;
                            }
                            ?>
                            <td><?= $item->autorizacao; ?></td>
                            <td><?= $item->exame; ?></td>
                            <td><?= $item->codigo; ?></td>
                            <td><?= $item->quantidade; ?></td>
                            <? if ($_POST['aparecervalor'] == '1') { ?>

                                <td><?= number_format($item->valortotal, 2, ',', '.') ?></td>
                                <td><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                            <? } ?>
                            <? if ($item->paciente != $relatorio[$p]->paciente || $p == $maximo) { ?>
                                <? if ($_POST['aparecervalor'] == '1') { ?>
                                    <td><b><?= number_format($totalpaciente, 2, ',', '.') ?></b></td>
                                <? } ?>
                                <?
                                $totalpaciente = 0;
                            } else {
                                ?>
                                <td></td>
                            <? } ?>
                        </tr>
                        <?
                        $paciente = $item->paciente;
                    }
                endforeach;
                ?>
                <? if ($_POST['aparecervalor'] == '1') { ?>
                    <tr>
                        <td width="200px;" align="Right" colspan="9"><b>Valor Previsto <?= number_format($valor, 2, ',', '.'); ?></b></td>
                    </tr>
                <? } ?>
                <tr>
                    <td width="2000px;" align="Right" colspan="9"><b>Nr. Pacientes: <?= $contadorpaciente; ?></b></td>
                </tr>
                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Procedimentos: <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <?
        $qtdetotal = $qtdetotal - $medicamento;
        ?>
        <table>
            <tbody>
                <tr>
                    <? if ($_POST['aparecervalor'] == '1') { ?>
                        <td width="140px;" align="Right" ><b>TOTAL GERAL</b></td>
                    <? } ?>
                    <td width="200px;" align="Right" ><b>Nr. Pacienets: <?= $contadorpacientetotal; ?></b></td>
                    <td width="200px;" align="Right" ><b>Nr. Procedimentos: <?= $qtdetotal; ?></b></td>
                    <td width="140px;" align="Right" ><b>Nr. Mat/Med: <?= $medicamento; ?></b></td>
                    <? if ($_POST['aparecervalor'] == '1') { ?>
                        <td width="200px;" align="Right" colspan="3"><b>Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></b></td>
                    <? } ?>
                </tr>
            </tbody>

        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
</html>
