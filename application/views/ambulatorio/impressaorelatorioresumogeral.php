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

            <? if (count($creditos) > 0) { 
                $datacredito = array();
                $numerocredito = array();?>
                <tr>
                    <td colspan="10"><center><font size="-1"><B>CRÉDITOS LANÇADOS</B></center></td>
                </tr>
                <tr>
                    <td><font size="-1"><B>Paciente</B></td>
                    <td style='text-align: right;'><font size="-1"><B>Data</B></td>
                    <td style='text-align: right;'><font size="-1"><B>Valor</B></td>
                    <td style='text-align: center;'><font size="-1"><B>Operador</B></td>
                </tr>
                <?
                $vlrCreditosLancados = 0;
                foreach ($creditos as $item) {
                    $vlrCreditosLancados += $item->valor;
                    
                    foreach ($formapagamento as $value) {
                        if ($item->forma_pagamento == $value->nome) {
                            $datacredito[$value->nome] = @$datacredito[$value->nome] + $item->valor1;
                            @$numerocredito[$value->nome]++;
                        }
                        if ($item->forma_pagamento_2 == $value->nome) {
                            $datacredito[$value->nome] = @$datacredito[$value->nome] + $item->valor2;
                            @$numerocredito[$value->nome]++;
                        }
                        if ($item->forma_pagamento_3 == $value->nome) {
                            $datacredito[$value->nome] = @$datacredito[$value->nome] + $item->valor3;
                            @$numerocredito[$value->nome]++;
                        }
                        if ($item->forma_pagamento_4 == $value->nome) {
                            $datacredito[$value->nome] = @$datacredito[$value->nome] + $item->valor4;
                            @$numerocredito[$value->nome]++;
                        }
                    }
                    ?>
                    <tr>
                        <td><?= $item->paciente ?></td>
                        <td style='text-align: right;'><?= date("d/m/Y", strtotime($item->data)) ?></td>
                        <td style='text-align: right;'><?= number_format($item->valor, 2, ',', '') ?></td>
                        <td style='text-align: right;'><?= $item->operador ?></td>
                    </tr>
                <? } ?>
                <tr>
                    <td colspan="20"><hr><br></td>
                </tr>
            <? } ?>

        <? if (count($medico) > 0): ?>
            <tr>
                <td colspan="4"><center><font size="-1"><B>PRODUÇÃO AMBULATORIAL</B></center></td>
            </tr>
        <? endif; ?>



        <tr>
            <td width="350px;"><font size="-1"><B>Medico</B></td>
            <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor Produzido</B></td>
            <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor Pago</B></td>
        </tr>

        <? if (count($medico) > 0): ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
        <? endif; ?>
        </thead>


        <tbody>
            <?php
            $i = 0;
            $total_particular = 0;
            $medicos = 0;
            $total_medicos = 0;
            $total_medicospagar = 0;
            $totalgerallaboratorio = 0;
            $totalperclaboratorio = 0;
            $perc = 0;
            $totalperc = 0;
            $total_geral = 0;
            $totalgeral = 0;
            $total_convenio = 0;
            $liquidodinheiro = 0;
            $faturamento_clinica = 0;
            $total_laboratoriospagar = 0;
            $TOTALCARTAO = 0;

            foreach ($formapagamento as $value) {
                $data[$value->nome] = 0;
                $numero[$value->nome] = 0;
                $desconto[$value->nome] = 0;
            }
            foreach ($medicorecebido as $itens) :

                if ($itens->dinheiro == 't') {

                    foreach ($formapagamento as $value) {
                        if ($itens->forma_pagamento == $value->forma_pagamento_id) {
                            $data[$value->nome] = $data[$value->nome] + $itens->valor1;
                            $numero[$value->nome] ++;
//                                $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                        }
                    }
                    foreach ($formapagamento as $value) {
                        if ($itens->forma_pagamento2 == $value->forma_pagamento_id) {
                            $data[$value->nome] = $data[$value->nome] + $itens->valor2;
                            $numero[$value->nome] ++;
//                                $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                        }
                    }
                    foreach ($formapagamento as $value) {
                        if ($itens->forma_pagamento3 == $value->forma_pagamento_id) {
                            $data[$value->nome] = $data[$value->nome] + $itens->valor3;

                            $numero[$value->nome] ++;
//                                $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                        }
                    }
                    foreach ($formapagamento as $value) {
                        if ($itens->forma_pagamento4 == $value->forma_pagamento_id) {
                            $data[$value->nome] = $data[$value->nome] + $itens->valor4;
                            $numero[$value->nome] ++;
//                                $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                        }
                    }
                }


            endforeach;

            foreach ($medico as $item) :
                foreach ($medicorecebido as $itens) :
                    if ($item->medico == $itens->medico) {

                        $valor_total = $itens->valor_total;

                        if ($_POST['laboratorio'] == 'SIM') {

                            if ($itens->percentual_laboratorio == "t") {
                                $simbolopercebtuallaboratorio = " %";

                                $valorpercentuallaboratorio = $itens->valor_laboratorio/* - ((float) $itens->valor_laboratorio * ((float) $itens->taxa_administracao / 100)) */;

                                $perclaboratorio = $valor_total * ($valorpercentuallaboratorio / 100);
//                                    var_dump(@$empresa_permissao[0]->valor_laboratorio); die;
                            } else {
                                $simbolopercebtuallaboratorio = "";
                                $valorpercentuallaboratorio = $itens->valor_laboratorio/* - ((float) $itens->valor_laboratorio * ((float) $itens->taxa_administracao / 100)) */;

//                                    $perclaboratorio = $valorpercentuallaboratorio;
                                $perclaboratorio = $valorpercentuallaboratorio * $itens->quantidade;
                            }
                            if (@$empresa_permissao[0]->valor_laboratorio == 't') {
                                $valor_total = $valor_total - $perclaboratorio;
                            }
//                            $totalperclaboratorio = $totalperclaboratorio + $perclaboratorio;
//                            $totalgerallaboratorio = $totalgerallaboratorio + $valor_total;
                        }

                        $procedimentopercentual = $itens->procedimento_tuss_id;
                        $medicopercentual = $itens->medico_parecer1;

                        $percentual = $this->guia->percentualmedico($procedimentopercentual, $medicopercentual);

                        $testearray = count($percentual);

                        if ($itens->percentual_medico == "t") {

                            $valorpercentualmedico = $itens->valor_medico;

                            $perc = $valor_total * ($valorpercentualmedico / 100);

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
                    <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($medicos, 2, ',', '.') ?></td>
                </tr>
                <?php
                $total_medicos = $total_medicos + $item->valor;
                $medicos = 0;
            endforeach;
            ?>
            <?
            $valCirurgico = 0;

            if (count($relatoriocirurgico) > 0):
                ?>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="4">&nbsp;</th>
                </tr>

                <tr>
                    <td colspan="3"><center><font size="-1"><B>PRODUÇÃO CIRURGICA</B></center></td>
            </tr>
            <?
            $i = 0;
            $ultimo = count($relatoriocirurgico);
            foreach ($relatoriocirurgico as $item) :
                if ($i == 0) {
                    $guia_anterior = $item->guia_id;
                    $valGuiaAnterior = (float) $item->valor;
                }

                if ($item->guia_id != $guia_anterior):
                    ?>
                    <tr>                        
                        <td style='text-align: right;' colspan=""></td>
                        <td style='text-align: right;' colspan="">
                            <div style="font-weight: bold">
                                Produzido: <?= number_format($valGuiaAnterior, 2, ',', '.') ?>
                            </div>
                        </td>
                        <td style='text-align: right;' colspan=""></td>
                    </tr>
                    <?
                    $guia_anterior = $item->guia_id;
                    $valGuiaAnterior = (float) $item->valor;
                endif;
                $total_medicospagar += (float) $item->valor_medico;
                $i++;
                ?>

                <tr>
                    <td><font size="-1" width="350px;"><?= $item->guia_id . ' => ' . utf8_decode($item->medico); ?></td>
                    <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($item->valor, 2, ',', '.') ?></td>
                    <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($item->valor_medico, 2, ',', '.') ?></td>
                </tr>
                <? if ($i == $ultimo): ?>
                    <tr>
                        <td style='text-align: right;' colspan=""></td>
                        <td style='text-align: right;' colspan="">
                            <div style="font-weight: bold">
                                Produzido: <?= number_format($item->valor, 2, ',', '.') ?>
                            </div>
                        </td>
                        <td style='text-align: right;' colspan=""></td>
                    </tr>
                <? endif; ?>


                <?
            endforeach;

            foreach ($procedimentoscirurgicos as $value):
                $total_medicos += (float) $value->valor;
            endforeach;
            ?>

            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <?
        endif;
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
    <? if ($_POST['laboratorio'] == 'SIM') { ?>
        <table>
            <tbody>           

                <tr>
                    <td width="350px;"><font size="-1"><B>Laboratório</B></td>
                    <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor Produzido</B></td>
                    <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor Pago</B></td>
                </tr>

                <? if (count($laboratorio) > 0): ?>
                    <tr>
                        <th style='width:10pt;border:solid windowtext 1.0pt;
                            border-bottom:none;mso-border-top-alt:none;border-left:
                            none;border-right:none;' colspan="4">&nbsp;</th>
                    </tr>
                <? endif; ?>
                <?
                $i = 0;

                foreach ($laboratorio as $item) :
                    $laboratorio_total = 0;
                    foreach ($medicorecebido as $itens) :
                        if ($item->laboratorio_id == $itens->laboratorio_id) {

                            $valor_total = $itens->valor_total;

                            if ($itens->percentual_laboratorio == "t") {
                                $simbolopercebtuallaboratorio = " %";

                                $valorpercentuallaboratorio = $itens->valor_laboratorio/* - ((float) $itens->valor_laboratorio * ((float) $itens->taxa_administracao / 100)) */;

                                $perclaboratorio = $valor_total * ($valorpercentuallaboratorio / 100);
//                                    var_dump(@$empresa_permissao[0]->valor_laboratorio); die;
                            } else {
                                $simbolopercebtuallaboratorio = "";
                                $valorpercentuallaboratorio = $itens->valor_laboratorio/* - ((float) $itens->valor_laboratorio * ((float) $itens->taxa_administracao / 100)) */;


                                $perclaboratorio = $valorpercentuallaboratorio * $itens->quantidade;
                            }
//                            if (@$empresa_permissao[0]->valor_laboratorio == 't') {
//                                $valor_total = $valor_total - $perclaboratorio;
//                            }
                            $totalperclaboratorio = $totalperclaboratorio + $perclaboratorio;
                            $totalgerallaboratorio = $totalgerallaboratorio + $valor_total;
                            $laboratorio_total = $laboratorio_total + $perclaboratorio;
                        }


                    endforeach;
                    $i++;
                    $total_laboratoriospagar = $total_laboratoriospagar + $laboratorio_total;
                    ?>
                    <tr>
                        <td><font size="-1" width="350px;"><?= utf8_decode($item->laboratorio); ?></td>
                        <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($item->valor, 2, ',', '.') ?></td>
                        <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($laboratorio_total, 2, ',', '.') ?></td>
                    </tr>
                    <?php
//                    $total_medicos = $total_medicos + $item->valor;
//                    $medicos = 0;
                endforeach;
                ?>

            </tbody>
        </table>
        <br>
        <br>
        <br>
    <? } ?>
    <table>
        <tbody>           

            <tr>
                <td width="350px;"><font size="-1"><B>Valor Convênio</B></th>
                <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor</B></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <?
            $valor_p = 0;
            $contador_a = 0;
            $total_convenio_geral = 0;
            foreach ($convenios as $value) {
                $contador_a++;
                $total_convenio_f = 0;
                
                $total_convenio = 0;
                foreach ($convenio as $item) {

                    if ($value->convenio_id == $item->convenio_id) {
                        if ($value->dinheiro == 't') {
//                            $valor_p = $item->valor;

                            if ($item->forma_pagamento1 != 1000 && $item->forma_pagamento2 != 1000 && $item->forma_pagamento3 != 1000 && $item->forma_pagamento4 != 1000) {
                                $valor_p = $item->valor;
                            } else {
                                if ($item->forma_pagamento1 == 1000) {
                                    $valorSemCreditoTotal = $item->valor2 + $item->valor3 + $item->valor4;
                                }
                                if ($item->forma_pagamento2 == 1000) {
                                    $valorSemCreditoTotal = $item->valor1 + $item->valor3 + $item->valor4;
                                }
                                if ($item->forma_pagamento3 == 1000) {
                                    $valorSemCreditoTotal = $item->valor1 + $item->valor2 + $item->valor4;
                                }
                                if ($item->forma_pagamento4 == 1000) {
                                    $valorSemCreditoTotal = $item->valor1 + $item->valor2 + $item->valor3;
                                }
                                $valor_p = $valorSemCreditoTotal;
                            }

                            $total_particular = $total_particular + $valor_p;
                        } else {
                            $total_convenio = $total_convenio + $item->valor;
                        }
                        $total_convenio_f = $total_convenio_f + $valor_p;
                    }
                }
                $value->valor_teste = $total_convenio_f;
                $total_geral = $total_geral + $item->valor;
                $total_convenio_geral = $total_convenio_geral + $total_convenio;

                if ($value->dinheiro == 'f') {
                    ?>
                    <tr>
                        <td><font size="-1" width="350px;"><?= utf8_decode($value->convenio); ?></td>
                        <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($total_convenio, 2, ',', '.') ?></td>
                    </tr>
                    <?php
                }
                
                
                
            }
//            echo '<pre>';
//            var_dump($contador_a); die;
            $total_geral = $total_particular + $total_convenio;
            if($_POST['laboratorio'] == 'SIM'){
              $liquidodinheiro = $total_particular - $total_medicospagar - $total_laboratoriospagar;  
            }else{
              $liquidodinheiro = $total_particular - $total_medicospagar;    
            }
            
            if (count($creditos) > 0) {
                $liquidodinheiro += $vlrCreditosLancados;
            }
            
            $faturamento_clinica = $liquidodinheiro + $total_convenio_geral;
            ?>
            <tr>
                <td><font size="-1" width="350px;"><b>VALOR GERAL</b></td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($total_convenio_geral, 2, ',', '.') ?></td>
            </tr>

        </tbody>
    </table>

    <br>
    <br>
    <br>
    <table>
        <tbody>           

            <tr>
                <td width="350px;"><font size="-1"><B>Valor Não-Convênio</B></th>
                <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor</B></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <?
            foreach ($convenios as $item2) :

                if ($item2->dinheiro == 't') {
                    ?>
                    <tr>
                        <td><font size="-1" width="350px;"><?= utf8_decode($item2->convenio); ?></td>
                        <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($item2->valor_teste, 2, ',', '.') ?></td>
                    </tr>
                    <?php
                }
            endforeach;

//            if ($item->dinheiro == 't') {
            ?>
<!--                <tr>
<td><font size="-1" width="350px;"><?= utf8_decode($item->convenio); ?></td>
<td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($item->valor, 2, ',', '.') ?></td>
</tr>-->
            <?php
//            }
            ?>
            <tr>
                <td><font size="-1" width="350px;"><b>VALOR GERAL</b></td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($total_particular, 2, ',', '.') ?></td>
            </tr>

        </tbody>
    </table>
    <BR>
    <BR>
    <BR>
    <table>
        <tbody>
<!--            <tr>
                <td width="350px;"><font size="-1"><B>Valor Não-Convênio</B></th>
                <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor</B></th>
            </tr>-->
<!--            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>-->
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
                <td><font size="-1" width="350px;">VALOR LIQUIDO NÃO-CONVÊNIO</td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($liquidodinheiro, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td><font size="-1" width="350px;">VALOR CONVENIO</td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($total_convenio_geral, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td><font size="-1" width="350px;">VALOR LIQUIDO DA CLINICA</td>
                <td style='text-align: right;'><font size="-1" width="200px;"><?= number_format($faturamento_clinica, 2, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td>
                <table cellspacing='5'>
                    <tr>
                        <td width="350px;"><font size="-1"><B>Valor Não-Convênio</B></th>
                        <td style='text-align: right;'width="120px;"><font size="-1"><B>Valor</B></th>
                    </tr>
                    <tr>
                        <th style='width:10pt;border:solid windowtext 1.0pt;
                            border-bottom:none;mso-border-top-alt:none;border-left:
                            none;border-right:none;' colspan="4">&nbsp;</th>
                    </tr>
                    <tr>
                        <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1">FORMA DE PAGAMENTO NÃO CONVÊNIO</center></td>
                        <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1">VALOR</center></td>
                    </tr>

                    <? // if (count($creditos) > 0) {
//                        $totalgeral = $totalgeral + $vlrCreditosLancados; ?>
<!--                        <tr>
                            <td ><font size="-1">CRÉDITO</td>
                            <td ><font size="-1"><?= number_format($vlrCreditosLancados, 2, ',', '.'); ?></td>
                        </tr> -->
                    <? // } ?>

                    <? foreach ($formapagamento as $value) {
                        if ($numero[$value->nome] > 0) {
                            if ($value->forma_pagamento_id != 1000) {
                                $totalgeral = $totalgeral + $data[$value->nome];
                            } else {
                                continue;
                            }
                            ?>
                            <tr>
                                <td ><font size="-1"><?= $value->nome ?></td>
                                <td ><font size="-1"><?= number_format($data[$value->nome], 2, ',', '.'); ?></td>
                            </tr>  
                            <?
                        }


                        if ($value->cartao != 'f') {
                            $TOTALCARTAO = $TOTALCARTAO + $data[$value->nome];
                        }
                        ?>


                    <? } ?>
                    <tr>
                        <td ><font size="-1">TOTAL CARTÃO</td>
                        <td ><font size="-1"> <?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
                    </tr>  
                    <tr>
                        <td ><font size="-1">TOTAL GERAL</td>
                        <td ><font size="-1"><?= number_format($totalgeral, 2, ',', '.'); ?></td>
                    </tr>  

                </table>
            </td>
            <td>
                <br>
                <br>
                <? if (count($creditos) > 0) { ?>
                    <table border="0">
                        <tbody>
                            <tr>
                                <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1">FORMA DE PAGAMENTO CRÉDITO</center></td>
                            </tr>
                            <?
                            $TOTALCARTAOCREDITO = 0;
                            $QTDECARTAO = 0;
                            $valorcreditototal = 0;
                            foreach ($formapagamento as $value) {
                                if (@$numerocredito[$value->nome] > 0) {
                                    $valorcreditototal += @$datacredito[$value->nome]
                                    ?>
                                    <tr>
                                        <td width="140px;"><font size="-1"><?= @$value->nome ?></td>
                                        <td width="140px;"><font size="-1"><?= @$numerocredito[$value->nome]; ?></td>
                                        <td width="200px;"><font size="-1"><?= number_format(@$datacredito[$value->nome], 2, ',', '.'); ?></td>
                                    </tr>
                                    <?
                                    if ($value->cartao != 'f') {
                                        $TOTALCARTAOCREDITO = $TOTALCARTAOCREDITO + @$datacredito[$value->nome];
                                        $QTDECARTAO = $QTDECARTAO + @$numerocredito[$value->nome];
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td width="140px;"><font size="-1">TOTAL CARTAO</td>
                                <td width="140px;"><font size="-1">Nr. Cart&otilde;es: <?= $QTDECARTAO; ?></td>
                                <td width="200px;" colspan="2"><font size="-1">Total Cartao: <?= number_format($TOTALCARTAOCREDITO, 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td width="140px;"><font size="-1">TOTAL GERAL</td>
                                <td width="140px;"><font size="-1">Nr. Exa: <?= count($creditos); ?></td>
                                <td width="200px;" colspan="2"><font size="-1">Total Geral: <?= number_format($valorcreditototal, 2, ',', '.'); ?></td>
                            </tr>
                        </tbody>

                    </table>
                <? } ?>
            </td>
        </tr>
    </table>
    <? if (count($creditos) > 0) { ?>
        <br>
        <br>
        <div style="">
            <table border="0">
                <tbody>
                    <tr>
                        <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1">TOTAL GERAL (Atendimentos + Créditos Lançados)</center></td>
                    </tr>
                    <tr style="text-align: center;">
                        <? $totalGeralDinheiro = ($valorcreditototal - $TOTALCARTAOCREDITO) + ($totalgeral - $TOTALCARTAO); ?>
                        <td width="1000px;" colspan="3"><font size="-1">Total Dinheiro: <?= number_format($totalGeralDinheiro, 2, ',', '.'); ?></td>
                    </tr>
                    <tr style="text-align: center;">
                        <? $totalGeralCartao = $TOTALCARTAOCREDITO + $TOTALCARTAO; ?>
                        <td width="1000px;" colspan="3"><font size="-1">Total Cartão: <?= number_format($totalGeralCartao, 2, ',', '.'); ?></td>
                    </tr>
                    <tr style="text-align: center;">
                        <? $TOTAL_GERAL_CREDITO_ATENDIMENTO = @$valorcreditototal + @$totalgeral; ?>
                        <td width="1000px;" colspan="3"><font size="-1">Total Geral: <?= number_format($TOTAL_GERAL_CREDITO_ATENDIMENTO, 2, ',', '.'); ?></td>
                    </tr>
                </tbody>

            </table>
        </div>
    <? } ?>
    
    <? if (count($relatoriocredito) > 0) { ?>
        <br>
        <table border="1" cellspacing="0" cellpadding="5">
            <tr>
                <td colspan="6"><center><font size="-1"><B>PACIENTES CRÉDITO</B></center></td>
            </tr>
            <tr>
                <th style='text-align: left;'><font size="-1">Paciente</th>
                <th style='text-align: right;'width="120px;"><font size="-1">Procedimento</th>
                <th style='text-align: right;'width="120px;"><font size="-1">Valor Crédito</th>
                <th style='text-align: right;'width="120px;"><font size="-1">Saldo Atual</th>
                <th style=''width="120px;"><font size="-1">Data Lançamento</th>
                <th style=''width="120px;"><font size="-1">Data</th>
            </tr> <?
        foreach ($relatoriocredito as $item) {
            if ($item->forma_pagamento == 1000) {
                $credito = $credito + $item->valor1;
            }
            if ($item->forma_pagamento2 == 1000) {
                $credito = $credito + $item->valor2;
            }
            if ($item->forma_pagamento3 == 1000) {
                $credito = $credito + $item->valor3;
            }
            if ($item->forma_pagamento4 == 1000) {
                $credito = $credito + $item->valor4;
            }
            ?>
                <tr>
                    <td ><font size="-1"><?= $item->paciente ?></td>
                    <td style='text-align: right;'width="120px;"><font size="-1"><?= $item->procedimento ?></td>
                    <td style='text-align: right;'width="120px;"><font size="-1"><?= "R$ " . number_format($credito, 2, ',', '.') ?></td>
                    <td style='text-align: right;'width="120px;"><font size="-1"><?= "R$ " . number_format($item->saldo_credito, 2, ',', '.') ?></td>
                    <td style='text-align: right;'width="120px;"><font size="-1"><?= date("d/m/Y", strtotime($item->data_lancamento)) ?></td>
                    <td style='text-align: right;'width="120px;"><font size="-1"><?= date("d/m/Y", strtotime($item->data)) ?></td>
                </tr> 

                <?
                $credito = 0;
            }
            ?>
        </table>
        <?
    }
    ?>



</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>