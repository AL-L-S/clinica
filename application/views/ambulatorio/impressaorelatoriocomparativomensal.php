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
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $mes1_inicio_view; ?> ate <?= $mes1_fim_view; ?></th>
                </tr>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $mes2_inicio_view; ?> ate <?= $mes2_fim_view; ?></th>
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
                <? if (count($relatorio) > 0 || count($relatorio2) > 0) {
                    ?>

                </thead>

            </table>
            <table>
                <tr>
                    <td>
                        <table border="1">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        Período : <?= $mes1_inicio_view; ?> até <?= $mes1_fim_view; ?>
                                    </th> 
                                </tr>
                                <tr>
                                    <th colspan="1">
                                        Convênio
                                    </th> 
                                    <th colspan="1">
                                        Valor
                                    </th> 
                                </tr>
                            </thead>
                            <? $total1 = 0; ?>
                            <? foreach ($relatorio as $item) { 
                                $total1 = $total1 + $item->valor_total;
                                ?>
                            
                                <tr>
                                    <td>
                                        <?= $item->convenio ?>
                                    </td>
                                    <td>
                                        <?= number_format($item->valor_total, 2, ',', '.'); ?>
                                    </td>
                                </tr> 
                            <? } ?>
                            <tr>
                                <th>
                                    Valor Total  
                                </th>
                                <th>
                                    <?= number_format($total1, 2, ',', '.'); ?> 
                                </th>
                            </tr>

                        </table>
                    </td>
                    <td>
                        <table border="1">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        Período : <?= $mes2_inicio_view; ?> até <?= $mes2_fim_view; ?>
                                    </th> 
                                </tr>
                                <tr>
                                    <th colspan="1">
                                        Convênio
                                    </th> 
                                    <th colspan="1">
                                        Valor
                                    </th> 
                                </tr>
                            </thead>
                            <? $total2 = 0; ?>
                            <?
                            foreach ($relatorio2 as $item) {
                                $total2 = $total2 + $item->valor_total;
                                ?>
                                <tr>
                                    <td>
                                        <?= $item->convenio ?>
                                    </td>
                                    <td>
                                        <?= number_format($item->valor_total, 2, ',', '.'); ?>
                                    </td>
                                </tr> 
                            <? } ?>
                            <tr>
                                <th>
                                    Valor Total  
                                </th>
                                <th>
                                    <?= number_format($total2, 2, ',', '.'); ?> 
                                </th>
                            </tr>

                        </table>
                    </td>

                </tr>
            </table>
            <hr>


        <? } else {
            ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <? }
        ?>


    </div> <!-- Final da DIV content -->
</html>
