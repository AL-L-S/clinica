<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>CONFERENCIA CAIXA</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> Até <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <? if (count($operador) != 0) { ?>
        <h3>ATENDENTE: <?= $operador[0]->nome; ?></h3>
    <? } ?>
    <? if (count($operador) == 0) { ?>
        <h3>ATENDENTE: TODOS</h3>
    <? } ?>
    <? if (count($medico) != 0) { ?>
        <h3>MÉDICO: <?= $medico[0]->nome; ?></h3>
    <? } ?>    
    <? if (count($medico) == 0) { ?>
        <h3>MÉDICO: TODOS</h3>
    <? } ?>
    <hr>
    <style>
        .procedimentoNome{ background-color: #ccc; }
        .procedimentoEquipe{ background-color: #7b7b7b; }
        h4 { margin: 5; padding: 5; }
    </style>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table >
            <thead>
                <tr>
                    <!--<th class="tabela_header"><font size="-1">Atendimento</th>-->
                    <th class="tabela_header"><font size="-1">Data Prevista</th>
    <!--                    <th class="tabela_header"><font size="-1">Data Faturamento</th>-->
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Exame</th>
                    <th class="tabela_header"><font size="-1">F. Pagamento</th>
                    <th class="tabela_header" style="text-align: right"><font size="-1">Parcelas</th>
                    <th class="tabela_header" style="text-align: right"><font size="-1">QTDE</th>
                    <th class="tabela_header" width="80px;" style="text-align: right"><font size="-1">V. Total</th>
                    <th class="tabela_header" width="80px;" style="text-align: right"><font size="-1">Desconto</th>
                    <!--<th class="tabela_teste" width="80px;"style="text-align: right"><font size="-1">Total Geral</th>-->
                </tr>
            </thead>

            <tbody>
                <?php
                if (count($relatorio) > 0) {


                    foreach ($formapagamento as $value) {
                        $data[$value->nome] = 0;
                        $datacredito[$value->nome] = 0;
                        $dataequipe[$value->nome] = 0;
                        $numerocredito[$value->nome] = 0;
                        $descontocredito[$value->nome] = 0;
                        $numeroequipe[$value->nome] = 0;
                        $descontoequipe[$value->nome] = 0;
                        $numero[$value->nome] = 0;
                        $desconto[$value->nome] = 0;
                    }

                    $i = 0;
                    $b = 0;
                    $valor = 0;
                    $valortotal = 0;
                    $valorequipetotal = 0;
                    $convenio = "";
                    $y = 0;
                    $DINHEIRO = 0;
                    $NUMERODINHEIRO = 0;
                    $DEBITO_CONTA = 0;
                    $NUMERODEBITO_CONTA = 0;
                    $CARTAOVISA = 0;
                    $NUMEROCARTAOVISA = 0;
                    $CARTAOMASTER = 0;
                    $NUMEROCARTAOMASTER = 0;
                    $CARTAOHIPER = 0;
                    $CARTAOCREDITO = 0;
                    $NUMEROCARTAOCREDITO;
                    $NUMEROCARTAOHIPER = 0;
                    $CARTAOELO = 0;
                    $NUMEROCARTAOELO = 0;
                    $CHEQUE = 0;
                    $NUMEROCHEQUE = 0;
                    $OUTROS = 0;
                    $NUMEROOUTROS = 0;
                    $financeiro = 'f';
                    $faturado = 't';
                    $valoroperador = 0;
                    $qtdepaciente = 0;
                    $qtdeexame = 0;
                    $operadorexames = "";
                    $paciente = "";
                    $exame = "";
                    $pendentes = 0;

                    foreach ($relatorio as $item) {

                        $i++;
                        $b++;
                        if ($item->financeiro == 't' && $item->dinheiro == 't') {
                            $financeiro = 't';
                        }
//                        if ($item->exames_id == "") {
//                            $exame = 'f';
//                        }
                        if ($item->faturado == "f" && $item->dinheiro == 't') {
                            $faturado = 'f';
                        }
                        if ($item->dinheiro == 't') {
                            $valortotal = $valortotal + $item->valor_total;
                        }
                        if ($i == 1 || $item->nome == $operadorexames) {

                            $valoroperador = $valoroperador + $item->valor_total;
                            $qtdepaciente++;
                            $qtdeexame++;
                            if ($i == 1) {
                                ?>
                                <tr>
                                    <td colspan="8"><font ><b>Operador:&nbsp;<?= $item->nome; ?></b></td>
                                </tr>
                            <? }
                            ?>
                            <tr class="procedimentoNome">

                                                                                                                                                                                                                     <!--<td><font size="-2"><?= $item->guia_id ?></td>-->
                                <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?>
                <!--                                    <td><font size="-2"><?= substr($item->data_faturar, 8, 2) . "/" . substr($item->data_faturar, 5, 2) . "/" . substr($item->data_faturar, 0, 4); ?>
                                    <? if ($item->verificado == 't') {
                                        ?>&Sqrt;<? }
                                    ?>
                                </td>-->
                                <td><font size="-2"><?= $item->paciente; ?></td>


                                <td class="procedimento"><font size="-2"><?= $item->exame ?></td>

                                <? if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 != '' && $item->dinheiro == 't') { ?>
                                    <td>
                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-2"><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?>
                                            <br><?= $item->forma_pagamento_3; ?><br><?= $item->forma_pagamento_4; ?>
                                        </a>
                                    </td>
                                    <td  style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?><br><?= $item->parcelas2; ?>
                                        <br><?= $item->parcelas3; ?><br><?= $item->parcelas4; ?>
                                        </font>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>


                                    <? } ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 == '' && $item->dinheiro == 't') {
                                    ?>
                                    <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?></a></td>
                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?><br><?= $item->parcelas2; ?>
                                        <br><?= $item->parcelas3; ?>
                                        </font>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?></td>


                                    <? } ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '' && $item->dinheiro == 't') {
                                    ?>
                                    <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?></a></td>
                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?><br><?= $item->parcelas2; ?>
                                        </font>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?></td>


                                    <? } ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '' && $item->dinheiro == 't') {
                                    ?>
                                    <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-2"><?= $item->forma_pagamento; ?></font>
                                        </a></td>
                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?> 
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/valoralterado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                                <font size="-1">  --(*)</font>
                                            </a></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?></td>


                                    <? } ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                } if ($item->forma_pagamento == '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '' && $item->dinheiro == 't') {
                                    ?>
                                    <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-2"><?= $item->forma_pagamento; ?></font>
                                        </a></td>

                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?>
                                    </td>

                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?> 
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/valoralterado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                                <font size="-1">  --(*)</font>
                                            </a></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?></td>

                                    <? }
                                    ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }
                                if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 != '' && $item->dinheiro == 't') {
                                    ?>
                                    <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_4; ?></a></td>

                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?><br><?= $item->parcelas2; ?><br><?= $item->parcelas4; ?>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>

                                    <? }
                                    ?>
                                    <td><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 != '' && $item->dinheiro == 't') {
                                    ?>
                                    <td><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/verificado/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                            <font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_4; ?></font>
                                        </a></td>

                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?><br><?= $item->parcelas4; ?>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>

                                    <? }
                                    ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }
                                ?>
                            </tr>
                            <?
                            $participacao = $this->solicitacirurgia_m->listarprocedimentoorcamentoconveniofuncaocaixa($item->agenda_exames_id);
//                            var_dump($participacao);
//                            die;
                            ?>
                            <?
                            foreach ($participacao as $value) {
//                                $total_geral += (float) $value->valor;
                                $valor = $valor + $value->valor;
                                $valortotal = $valortotal + $value->valor;
                                ?>
                                <tr class="">

                                    <td><font size="-2"> <?= $value->medico ?> </td>
                                    <td><font size="-2"> <?= $value->descricao ?> </td>
                                    <td align="right"><font size="-2"> <?= number_format($value->valor, 2, ',', ''); ?> </td>
                                    <td colspan="6">
                                        <font size="-2">
                                        <? if ($value->forma_pagamento != '') { ?>
                                            <?= $value->forma_pagamento ?> : 
                                            <?= number_format($value->valor1, 2, ',', '') ?>

                                        <? }
                                        ?>
                                        <? if ($value->forma_pagamento2 != '') { ?>
                                            <?= $value->forma_pagamento_2 ?> : 
                                            <?= number_format($value->valor2, 2, ',', '') ?>

                                        <? }
                                        ?>
                                        <? if ($value->forma_pagamento3 != '') { ?>
                                            <?= $value->forma_pagamento_3 ?> : 
                                            <?= number_format($value->valor3, 2, ',', '') ?>

                                        <? }
                                        ?>
                                        <? if ($value->forma_pagamento4 != '') { ?>
                                            <?= $value->forma_pagamento_4 ?> : 
                                            <?= number_format($value->valor4, 2, ',', '') ?>

                                        <? }
                                        ?>
                                        <?
//                                        $u = 0;
                                        foreach ($formapagamento as $item2) {
                                            if ($item->forma_pagamento == $item2->nome) {
                                                $dataequipe[$item2->nome] = $dataequipe[$item2->nome] + $item->valor1;
                                                $numeroequipe[$item2->nome] ++;
                                            }
                                        }
                                        foreach ($formapagamento as $item2) {
                                            if ($item->forma_pagamento_2 == $item2->nome) {
                                                $dataequipe[$item2->nome] = $dataequipe[$item2->nome] + $item->valor2;
                                                $numeroequipe[$item2->nome] ++;
                                            }
                                        }
                                        foreach ($formapagamento as $item2) {
                                            if ($item->forma_pagamento_3 == $item2->nome) {
                                                $dataequipe[$item2->nome] = $dataequipe[$item2->nome] + $item->valor3;
                                                $numeroequipe[$item2->nome] ++;
                                            }
                                        }
                                        foreach ($formapagamento as $item2) {
                                            if ($item->forma_pagamento_4 == $item2->nome) {
                                                $dataequipe[$item2->nome] = $dataequipe[$item2->nome] + $item->valor4;
                                                $numeroequipe[$item2->nome] ++;
                                            }
                                        }
                                        ?>    

                                        </font>

                                    </td>
                                </tr>                        
                            <? } ?>

                            <?php
                            if ($item->dinheiro == 't') {
                                $u = 0;
                                foreach ($formapagamento as $value) {
                                    if ($item->forma_pagamento == $value->nome) {
                                        $data[$value->nome] = $data[$value->nome] + $item->valor1;
                                        $numero[$value->nome] ++;
                                        if ($u == 0) {
                                            $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                        }
                                        if ($item->desconto != '') {
                                            $u++;
                                        }
                                    }
                                }
                                foreach ($formapagamento as $value) {
                                    if ($item->forma_pagamento_2 == $value->nome) {
                                        $data[$value->nome] = $data[$value->nome] + $item->valor2;
                                        $numero[$value->nome] ++;
                                        if ($u == 0) {

                                            $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                        }
                                        if ($item->desconto != '') {
                                            $u++;
                                        }
                                    }
                                }
                                foreach ($formapagamento as $value) {
                                    if ($item->forma_pagamento_3 == $value->nome) {
                                        $data[$value->nome] = $data[$value->nome] + $item->valor3;
                                        $numero[$value->nome] ++;
                                        if ($u == 0) {

                                            $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                        }
                                        if ($item->desconto != '') {
                                            $u++;
                                        }
                                    }
                                }
                                foreach ($formapagamento as $value) {
                                    if ($item->forma_pagamento_4 == $value->nome) {
                                        $data[$value->nome] = $data[$value->nome] + $item->valor4;
                                        $numero[$value->nome] ++;
                                        if ($u == 0) {

                                            $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                        }
                                        if ($item->desconto != '') {
                                            $u++;
                                        }
                                    }
                                }
                            }
                            if ($item->faturado == 'f' && $item->dinheiro == 't') {
                                $pendentes ++;
                            }
                            if ($item->forma_pagamento == "" && $item->dinheiro == 't') {
                                $OUTROS = $OUTROS + $item->valor_total;
                                $NUMEROOUTROS++;
                            }
                            $y++;
                            if ($item->dinheiro == 't') {

                                $valor = $valor + $item->valor_total;
                            }

                            $paciente = $item->paciente;
                            $operadorexames = $item->nome;
                        } else {
                            $operadorexames = $item->nome;
                            $paciente = "";
                            ?> 

                            <tr>
                                <td colspan="5"></td><td colspan="2"><font size="-1"><b>TOTAL</b></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td><td colspan="2"><font size="-1"><b>Nr. Exa: <?= $y; ?></b></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td><td colspan="2"><font size="-1"><b>VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></b></td>
                            </tr>
                            <tr>
                                <td colspan="8"><font ><b>Operador:&nbsp;<?= utf8_decode($item->nome); ?></b></td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>


                            <tr>
                                <? if ($paciente == $item->paciente) { ?>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                <? } else { ?>
                                    <td><font size="-2"><?= $item->guia_id; ?></td>
                                    <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                    <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                                <? } ?>
                                <? if ($item->exames_id == "") { ?>
                                    <td><font color="red" size="-2"><?= utf8_decode($item->exame) . " " . $item->numero_sessao; ?></td>
                                <? } else { ?>
                                    <td><font size="-2"><?= utf8_decode($item->exame) . " " . $item->numero_sessao; ?></td>
                                <? } ?>
                                <? if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 != '') { ?>
                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?><br><?= $item->forma_pagamento_4; ?></td>

                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?><br><?= $item->parcelas2; ?>
                                        <br><?= $item->parcelas3; ?><br><?= $item->parcelas4; ?>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?><br><?= number_format($item->valor4, 2, ',', '.') ?></td>

                                    <? }
                                    ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 != '' && $item->forma_pagamento_4 == '') {
                                    ?>
                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?><br><?= $item->forma_pagamento_3; ?></td>

                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?><br><?= $item->parcelas2; ?>
                                        <br><?= $item->parcelas3; ?>
                                    </td>
                                    <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?><br><?= number_format($item->valor3, 2, ',', '.') ?></td>

                                    <? }
                                    ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 != '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                    ?>
                                    <td><font size="-2"><?= $item->forma_pagamento; ?><br><?= $item->forma_pagamento_2; ?></td>

                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?><br><?= $item->parcelas2; ?>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?><br><?= number_format($item->valor2, 2, ',', '.') ?></td>

                                    <? }
                                    ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }if ($item->forma_pagamento != '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                    ?>
                                    <td><font size="-2"><?= $item->forma_pagamento; ?></td>

                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor1, 2, ',', '.') ?></td>

                                    <? }
                                    ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                } if ($item->forma_pagamento == '' && $item->forma_pagamento_2 == '' && $item->forma_pagamento_3 == '' && $item->forma_pagamento_4 == '') {
                                    ?>
                                    <td><font size="-2"><?= $item->forma_pagamento; ?></td>

                                    <td style="text-align: right">
                                        <font size="-2">
                                        <?= $item->parcelas1; ?>
                                    </td>
                                    <? if ($item->faturado == "f") { ?>
                                        <td style="text-align: right"><font size="-2" color="red"><?= $item->quantidade; ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= $item->quantidade; ?></td>
                                    <? } ?>
                                    <? if ($item->operador_editar != '') { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') . " (*)" ?></td>
                                    <? } else { ?>
                                        <td style="text-align: right"><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?></td>

                                    <? }
                                    ?>
                                    <td style="text-align: right"><font size="-2"><?= $item->desconto; ?></td>
                                    <?
                                }
                                ?>
                            </tr>
                            <?
                            foreach ($formapagamento as $value) {
                                if ($item->forma_pagamento == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor1;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {
                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->forma_pagamento_2 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor2;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->forma_pagamento_3 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor3;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            foreach ($formapagamento as $value) {
                                if ($item->forma_pagamento_4 == $value->nome) {
                                    $data[$value->nome] = $data[$value->nome] + $item->valor4;
                                    $numero[$value->nome] ++;
                                    if ($u == 0) {

                                        $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                                    }
                                    if ($item->desconto != '') {
                                        $u++;
                                    }
                                }
                            }
                            if ($item->forma_pagamento == "") {
                                $OUTROS = $OUTROS + $item->valor_total;
                                $NUMEROOUTROS++;
                            }
                            if ($item->faturado == 'f') {
                                $pendentes ++;
                            }
                            $valor = 0;
                            $valor = $valor + $item->valor_total;
                            $y = 0;
                            $y++;
                        }
                    }

                    $w = 0;
                }
                ?>    
    <!--            <tr>
    <td colspan="8"><font ><b>&nbsp;</b></td>
    </tr>
    <tr>
    <td colspan="8" style="text-align: center;"><font ><b>HOME CARE</b></td>
    </tr>-->          

            <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>centrocirurgico/centrocirurgico/fecharcaixacirurgico" method="post">
                <?
                foreach ($formapagamento as $value) {

                    //Caso seja forma de pagamento CREDITO não será processado no fechar caixa da mesma forma que os outros
                    if ($value->forma_pagamento_id == 1000) {
                        continue;
                    }

                    $w++;

                    /*
                     * Obs: O codigo abaixo foi feito pois o CodeIgniter não aceita certos caracteres
                     * tais como '-', ' ', entre outros ao se fazer isso:
                     * name="qtde['<?= $value->nome; ?>']
                     */
                    $nomeForma = str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $value->nome);
                    $nomeForma = strtolower($nomeForma);
                    ?>

                    <input type="hidden" class="texto3" name="qtde[<?= $nomeForma; ?>]" value="<?= number_format($data[$value->nome], 2, ',', '.'); ?>"/>
                    <input type="hidden" class="texto3" name="qtdecredito[<?= $nomeForma; ?>]" value="<?= number_format($datacredito[$value->nome], 2, ',', '.'); ?>"/>
                    <input type="hidden" class="texto3" name="qtdeequipe[<?= $nomeForma; ?>]" value="<?= number_format($dataequipe[$value->nome], 2, ',', '.'); ?>"/>
                <? }
                ?>
    <!--                <input type="hidden" class="texto3" name="dinheiro" value="<?= number_format($DINHEIRO, 2, ',', '.'); ?>" readonly/>
    <input type="hidden" class="texto3" name="cheque" value="<?= number_format($CHEQUE, 2, ',', '.'); ?>" readonly/>
    <input type="hidden" class="texto3" name="debito" value="<?= number_format($DEBITO_CONTA, 2, ',', '.'); ?>" readonly/>
    <input type="hidden" class="texto3" name="cartaocredito" value="<?= number_format($CARTAOCREDITO, 2, ',', '.'); ?>" readonly/>
    <input type="hidden" class="texto3" name="cartaovisa" value="<?= number_format($CARTAOVISA, 2, ',', '.'); ?>" readonly/>
    <input type="hidden" class="texto3" name="cartaomaster" value="<?= number_format($CARTAOMASTER, 2, ',', '.'); ?>" readonly/>
    <input type="hidden" class="texto3" name="cartaohiper" value="<?= number_format($CARTAOHIPER, 2, ',', '.'); ?>" readonly/>
    <input type="hidden" class="texto3" name="cartaoelo" value="<?= number_format($CARTAOELO, 2, ',', '.'); ?>" readonly/>-->
    <!--                <input type="hidden" class="texto3" name="outros" value="<?= number_format($OUTROS, 2, ',', '.'); ?>" readonly/>-->
                <?
//                $j = 0;
//                foreach ($creditos as $item) {
                ?>
    <!--                    <input type="hidden" class="texto3" name="creditoValor[<?= $j; ?>]" value="<?= $item->valor; ?>"/>
    <input type="hidden" class="texto3" name="creditoData[<?= $j; ?>]" value="<?= $item->data; ?>"/>
    <input type="hidden" class="texto3" name="creditoForma[<?= $j; ?>]" value="<?= $item->forma_pagamento_id; ?>"/>-->
                <? // $j++;   ?>
                <? // }    ?>

                <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>
                <!--<input type="hidden" class="texto3" name="grupo" value="<?= $grupo; ?>"/>-->
                <!--<input type="hidden" class="texto3" name="empresa" value="<?= $grupo; ?>"/>-->
                <? if (count($empresa) > 0) { ?>
                    <input type="hidden" class="texto3" name="empresa" value="<?= $empresa[0]->empresa_id; ?>"/>
                <? } ?>

                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>TOTAL</b></td>
                </tr>
                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>Nr. Exa: <?= $y; ?></b></td>
                </tr>
                <tr>
                    <td colspan="5"></td><td colspan="2"><font size="-1"><b>VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></b></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <? if ($faturado == 't' && $exame == "") { ?>
                        <? if ((count($operador) == 0 && count($medico) == 0 && $financeiro == 'f')) { ?>
                            <td colspan="2" ><font size="-1"><button type="submit" name="btnEnviar">Fechar Caixa</button></td>

                        <? } elseif ((count($operador) > 0 || count($medico) > 0) && $financeiro == 'f') { ?>
                            <td colspan="2" ><b>Retire os filtros de operador e/ou médico e/ou procedimentos para fechar o caixa</b></td> 
                        <? } else {
                            ?>
                            <td colspan="2" ><b>Caixa Fechado</b></td>
                        <? } ?>
                    <? } else { ?>
                        <td colspan="3" ><b>Pendencias de Faturamento / Finalizar exame</b></td>
                    <? } ?>
                </tr>


            </form>
            </tbody>
        </table>
        <hr>
        <!--<br>-->
        <br>

        <br>
        <div style="display: inline-block;">
            <table border="1">
                <tbody>
                    <tr>
                        <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1">FORMA DE PAGAMENTO</center></td>
                <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1">DESCONTO</center></td>
                </tr>
                <?
                foreach ($formapagamento as $value) {
                    if ($numero[$value->nome] > 0) {
                        ?>
                        <tr>
                            <td width="140px;"><font size="-1"><?= $value->nome ?></td>
                            <td width="140px;"><font size="-1"><?= $numero[$value->nome]; ?></td>
                            <td width="200px;"><font size="-1"><?= number_format($data[$value->nome], 2, ',', '.'); ?></td>
                            <td><font size="-1"><?= number_format($desconto[$value->nome], 2, ',', '.'); ?></td>
                        </tr>    


                        <?
                    }
                }
                ?>
                <tr>
                    <td width="140px;"><font size="-1">PENDENTES</td>
                    <td width="140px;"><font size="-1"><?= $NUMEROOUTROS ?></td>
                    <td width="200px;"><font size="-1"><?= number_format($OUTROS, 2, ',', '.'); ?></td>
                    <td><font size="-2"></td>
                </tr>  
                <?
                $TOTALCARTAO = 0;
                $QTDECARTAO = 0;
                foreach ($formapagamento as $value) {
                    /* A linha abaixo era a condiçao do IF antigamente. Agora tudo que nao for cartao sera DINHEIRO */
                    //                ($value->nome != 'DINHEIRO' && $value->nome != 'DEBITO' && $value->nome != 'CHEQUE') 
                    if ($value->cartao != 'f') {
                        $TOTALCARTAO = $TOTALCARTAO + $data[$value->nome];
                        $QTDECARTAO = $QTDECARTAO + $numero[$value->nome];
                    }
                }
                ?>
                <tr>
                    <td width="140px;"><font size="-1">TOTAL CARTAO</td>
                    <td width="140px;"><font size="-1">Nr. Cart&otilde;es: <?= $QTDECARTAO; ?></td>
                    <td width="200px;" colspan="2"><font size="-1">Total Cartao: <?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td width="140px;"><font size="-1">TOTAL GERAL</td>
                    <td width="140px;"><font size="-1">Nr. Exa: <?= $i; ?></td>
                    <td width="200px;" colspan="2"><font size="-1">Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></td>
                </tr>
                </tbody>

            </table>
        </div>

        <div style="display: inline-block;margin-left: 10px;">
            <table border="1">
                <tbody>
                    <tr>
                        <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1">FORMA DE PAGAMENTO EQUIPE</center></td>
                <!--<td colspan="1" bgcolor="#C0C0C0"><center><font size="-1">DESCONTO</center></td>-->
                </tr>
                <?
                foreach ($formapagamento as $value) {
                    if ($numerocredito[$value->nome] > 0) {
                        ?>
                        <tr>
                            <td width="140px;"><font size="-1"><?= $value->nome ?></td>
                            <td width="140px;"><font size="-1"><?= $numerocredito[$value->nome]; ?></td>
                            <td width="200px;"><font size="-1"><?= number_format($datacredito[$value->nome], 2, ',', '.'); ?></td>
                            <!--<td><font size="-1"><?= number_format($desconto[$value->nome], 2, ',', '.'); ?></td>-->
                        </tr>    


                        <?
                    }
                }
                ?>

                <?
                $TOTALCARTAO = 0;
                $QTDECARTAO = 0;
                foreach ($formapagamento as $value) {
                    /* A linha abaixo era a condiçao do IF antigamente. Agora tudo que nao for cartao sera DINHEIRO */
                    //                ($value->nome != 'DINHEIRO' && $value->nome != 'DEBITO' && $value->nome != 'CHEQUE') 
                    if ($value->cartao != 'f') {
                        $TOTALCARTAO = $TOTALCARTAO + $datacredito[$value->nome];
                        $QTDECARTAO = $QTDECARTAO + $numerocredito[$value->nome];
                    }
                }
                ?>
                <tr>
                    <td width="140px;"><font size="-1">TOTAL CARTAO</td>
                    <td width="140px;"><font size="-1">Nr. Cart&otilde;es: <?= $QTDECARTAO; ?></td>
                    <td width="200px;" colspan="2"><font size="-1">Total Cartao: <?= number_format($TOTALCARTAO, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td width="140px;"><font size="-1">TOTAL GERAL</td>
                    <td width="140px;"><font size="-1">Nr. Exa: <?= $i; ?></td>
                    <td width="200px;" colspan="2"><font size="-1">Total Geral: <?= number_format($valorequipetotal, 2, ',', '.'); ?></td>
                </tr>
                </tbody>

            </table>
        </div>


        <br>

        <h4>(*) Valores alterados.</h4>
        <?
        $PERCENTUALDINHEIRO = ($NUMERODINHEIRO * 100) / $i;
        $PERCENTUALDEBITO_CONTA = ($NUMERODEBITO_CONTA * 100) / $i;
        $PERCENTUALCARTAOVISA = ($NUMEROCARTAOVISA * 100) / $i;
        $PERCENTUALCARTAOMASTER = ($NUMEROCARTAOMASTER * 100) / $i;
        $PERCENTUALCARTAOHIPER = ($NUMEROCARTAOHIPER * 100) / $i;
        $PERCENTUALCARTAOELO = ($NUMEROCARTAOELO * 100) / $i;
        $PERCENTUALOUTROS = ($NUMEROOUTROS * 100) / $i;
        if ($valortotal != 0) {
            $PERCENTUALVALORDINHEIRO = ($DINHEIRO * 100) / $valortotal;
            $PERCENTUALVALORDEBITO_CONTA = ($DEBITO_CONTA * 100) / $valortotal;
            $PERCENTUALVALORCARTAOVISA = ($CARTAOVISA * 100) / $valortotal;
            $PERCENTUALVALORCARTAOMASTER = ($CARTAOMASTER * 100) / $valortotal;
            $PERCENTUALVALORCARTAOHIPER = ($CARTAOHIPER * 100) / $valortotal;
            $PERCENTUALVALORCARTAOELO = ($CARTAOELO * 100) / $valortotal;
            $PERCENTUALVALOROUTROS = ($OUTROS * 100) / $valortotal;
        } else {
            $PERCENTUALVALORDINHEIRO = 0;
            $PERCENTUALVALORDEBITO_CONTA = 0;
            $PERCENTUALVALORCARTAOVISA = 0;
            $PERCENTUALVALORCARTAOMASTER = 0;
            $PERCENTUALVALORCARTAOHIPER = 0;
            $PERCENTUALVALORCARTAOELO = 0;
            $PERCENTUALVALOROUTROS = 0;
        }
        $VALORDINHEIRO = (str_replace("", ".", str_replace("", ",", $DINHEIRO))) / 100;
        $VALORDEBITO_CONTA = (str_replace("", ".", str_replace("", ",", $DEBITO_CONTA))) / 100;
        $VALORCARTAOVISA = (str_replace("", ".", str_replace("", ",", $CARTAOVISA))) / 100;
        $VALORCARTAOMASTER = (str_replace("", ".", str_replace("", ",", $CARTAOMASTER))) / 100;
        $VALORCARTAOHIPER = (str_replace("", ".", str_replace("", ",", $CARTAOHIPER))) / 100;
        $VALORCARTAOELO = (str_replace("", ".", str_replace("", ",", $CARTAOELO))) / 100;
        $VALOROUTROS = (str_replace("", ".", str_replace("", ",", $OUTROS))) / 100;
        ?>

        <!--        GRAFICO DE QUANTIDADE DE EXAMES
                <center><img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?= $NUMERODINHEIRO; ?>,<?= $NUMERODEBITO_CONTA; ?>,<?= $NUMEROCARTAOVISA; ?>,<?= $NUMEROCARTAOMASTER; ?>,<?= $NUMEROCARTAOHIPER; ?>,<?= $NUMEROCARTAOELO; ?>,<?= $NUMEROOUTROS; ?>&chtt=QUANTIDADE DE EXAMES&chs=600x300&chl=<?= number_format($PERCENTUALDINHEIRO, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALDEBITO_CONTA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOVISA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALOUTROS, 2, ',', '.'); ?>%&chdl=DINHEIRO|DEBITO_CONTA\00|CARTAO VISA|CARTAO MASTER|CARTAO HIPER|OUTROS&chco=c60000|1da3f8|58e015|fffc00|67087b|#5F9EA0" alt="" name="teste"/></center>
                GRAFICO DE VALOR DE EXAMES
                <center><img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?= $VALORDINHEIRO; ?>,<?= $VALORDEBITO_CONTA; ?>,<?= $VALORCARTAOVISA; ?>,<?= $VALORCARTAOMASTER; ?>,<?= $VALORCARTAOHIPER; ?>,<?= $VALORCARTAOELO; ?>,<?= $VALOROUTROS; ?>&chtt=VALOR DOS EXAMES&chs=600x300&chl=<?= number_format($PERCENTUALVALORDINHEIRO, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORDEBITO_CONTA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOVISA, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOMASTER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALORCARTAOHIPER, 2, ',', '.'); ?>%|<?= number_format($PERCENTUALVALOROUTROS, 2, ',', '.'); ?>%&chdl=DINHEIRO|DEBITO_CONTA\00|CARTAO VISA|CARTAO MASTER|CARTAO HIPER|OUTROS&chco=c60000|1da3f8|58e015|fffc00|67087b|#5F9EA0" alt="" name="teste2" /></center>-->
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



    $(function () {
        $("#accordion").accordion();
    });

</script>
