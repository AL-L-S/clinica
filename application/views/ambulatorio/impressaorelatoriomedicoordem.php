<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>ATENDIMENTOS POR ORDEM DE CHEGADA/PRIORIDADE</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <? if ($medico == 0) { ?>
        <h4>TODOS OS MEDICOS</h4>
    <? } else { ?>
        <h4>Medico: <?= $medico[0]->operador; ?></h4>
    <? } ?>
    <? if ($procedimentos == 0) { ?>
        <h4>TODOS OS PROCEDIMENTOS</h4>
    <? } else { ?>
        <h4>PROCEDIMENTO: <?= $procedimentos[0]->nome; ?></h4>
    <? } ?>
    <? if ($salas == 0) { ?>
        <h4>TODAS AS SALAS</h4>
    <? } else { ?>
        <h4>SALA: <?= $salas[0]->nome; ?></h4>
    <? } ?>
    <hr>
    <table border="1">
        <thead>
            <tr>
                <th class="tabela_header" >Ordem</th>
                <th class="tabela_header" >Status</th>
                <th class="tabela_header" width="250px;">Nome</th>
                <th class="tabela_header" width="250px;">Idade</th>
                <th class="tabela_header" width="70px;">Data</th>
                <th class="tabela_header" width="70px;">Hora</th>
                <th class="tabela_header" width="150px;">Medico</th>
                <th class="tabela_header" width="120px;">Convenio</th>
                <th class="tabela_header" width="120px;">Procedimento</th>
                <th class="tabela_header" width="90px;">Valor</th>
                <th class="tabela_header" width="90px;">V. Medico</th>
                <th class="tabela_header" width="90px;">F. Pagamento</th>
                <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $totalperc = 0;
            $totalgeral = 0;
            $verificador = 0;
            $valortotal = 0;
            $valorliquidoclinica = 0;
            $valortotalmedico = 0;
            $valortotaldinheiro = 0;
            $valortotalcartao = 0;
            $valortotalconvenio = 0;
            $tabela = 0;
            $procedimento = "";
            $paciente = "";
            if (count($relatorio) > 0) {
                foreach ($relatorio as $item) {
                    $i++;
                    $idade = date("Y-m-d") - $item->nascimento;


                    if ($item->procedimento == $procedimento || $verificador == 0) {
                        $verificador++;
                        $tabela = 0;
                        $procedimento = $item->procedimento;
                        foreach ($relatorioprioridade as $itens) {
//                        var_dump($i);
//                        echo"----";

                            $ordenador = intval($itens->ordenador);
//                                                var_dump($ordenador);
//                        die;

                            if ($i == $ordenador) {
                                $dataFuturo = date("Y-m-d H:i:s");
                                $dataAtual = $itens->data_atualizacao;

                                $date_time = new DateTime($dataAtual);
                                $diff = $date_time->diff(new DateTime($dataFuturo));
                                $teste = $diff->format('%H:%I:%S');


                                $paciente = "";

                                if ($itens->realizada == 't' && $itens->situacaolaudo != 'FINALIZADO') {
                                    $situacao = "Aguardando";
                                    $verifica = 2;
                                } elseif ($itens->realizada == 't' && $itens->situacaolaudo == 'FINALIZADO') {
                                    $situacao = "Finalizado";
                                    $verifica = 4;
                                } else {
                                    $situacao = "espera";
                                    $verifica = 3;
                                }
                                if ($item->procedimento == $itens->procedimento) {
                                    $procedimentopercentual = $itens->procedimento_tuss_id;
                                    $medicopercentual = $itens->medico_parecer1;
                                    $percentual = $this->guia->percentualmedico($procedimentopercentual, $medicopercentual);
                                    $testearray = count($percentual);
                                    if ($testearray > 0) {
                                        $valorpercentualmedico = $percentual[0]->valor;
                                    } else {
                                        $valorpercentualmedico = $itens->perc_medico;
                                    }
                                    $valormedicoordem = $itens->valortotal * ($valorpercentualmedico / 100);
                                    $valortotal = $valortotal + $itens->valor_total;
                                    $valortotalmedico = $valortotalmedico + $valormedicoordem;
                                    if ($itens->dinheiro == 't') {
                                        if ($item->forma_pagamento == 'DINHEIRO') {
                                            $valortotaldinheiro = $valortotaldinheiro + $itens->valor_total;
                                        } else {
                                            $valortotalcartao = $valortotalcartao + $itens->valor_total;
                                        }
                                    } else {
                                        $valortotalconvenio = $valortotalconvenio + $itens->valor_total;
                                    }
                                    ?>
                                    <tr>
                                        <td ><b><?= $i . " P"; ?></b></td>
                                        <td ><b><?= $situacao; ?></b></td>
                                        <td <b><?= $itens->paciente; ?></b></td>
                                        <td><?= substr($itens->data, 8, 2) . "/" . substr($itens->data, 5, 2) . "/" . substr($itens->data, 0, 4); ?></td>
                                        <td  width="150px;"><?= $itens->inicio; ?></td>
                                        <td  width="150px;"><?= substr($itens->medicoagenda, 0, 15); ?></td>
                                        <td ><?= $itens->convenio; ?></td>
                                        <td ><?= utf8_decode($itens->procedimento); ?></td>
                                        <td ><?= number_format($itens->valor_total, 2, ",", "."); ?></td>
                                        <td ><?= number_format($valormedicoordem, 2, ",", "."); ?></td>
                                        <td ><?= $item->forma_pagamento; ?></td>
                                        <td ><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $itens->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                                                                                                                                                                                                                                width=500,height=230');">=><?= $itens->observacoes; ?></td>
                                    </tr>

                                </tbody>
                                <?php
                            }
                        }
                    }
                    $dataFuturo = date("Y-m-d H:i:s");
                    $dataAtual = $item->data_atualizacao;

                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%H:%I:%S');


                    $paciente = "";

                    if ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') {
                        $situacao = "Aguardando";
                        $verifica = 2;
                    } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                        $situacao = "Finalizado";
                        $verifica = 4;
                    } else {
                        $situacao = "espera";
                        $verifica = 3;
                    }
                    $procedimentopercentual = $item->procedimento_tuss_id_novo;
                    $medicopercentual = $item->medico_parecer1;
                    $percentual = $this->guia->percentualmedico($procedimentopercentual, $medicopercentual);
                    $testearray = count($percentual);
                    if ($item->percentual == "t") {
                        $simbolopercebtual = " %";
                        if ($testearray > 0) {
                            $valorpercentualmedico = $percentual[0]->valor;
                        } else {
                            $valorpercentualmedico = $item->perc_medico;
                        }
                        $perc = $item->valor_total * ($valorpercentualmedico / 100);
                        $totalperc = $totalperc + $perc;
                        $totalgeral = $totalgeral + $item->valor_total;
                    } else {
                        $simbolopercebtual = "";
                        if ($testearray > 0) {
                            $valorpercentualmedico = $percentual[0]->valor;
                        } else {
                            $valorpercentualmedico = $item->perc_medico;
                        }
                        $perc = $valorpercentualmedico;
                        $totalperc = $totalperc + $perc;
                        $totalgeral = $totalgeral + $item->valor_total;
                    }
                    $valortotal = $valortotal + $item->valor_total;
                    $valortotalmedico = $valortotalmedico + $valorpercentualmedico;
                    if ($item->dinheiro == 't') {
                        if ($item->forma_pagamento == 'DINHEIRO') {
                            $valortotaldinheiro = $valortotaldinheiro + $item->valor_total;
                        } else {
                            $valortotalcartao = $valortotalcartao + $item->valor_total;
                        }
                    } else {
                        $valortotalconvenio = $valortotalconvenio + $item->valor_total;
                    }
                    ?>
                    <tr>
                        <td ><b><?= $i; ?></b></td>
                        <td ><b><?= $situacao; ?></b></td>
                        <td <b><?= $item->paciente; ?></b></td>
                        <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td  width="150px;"><?= $item->inicio; ?></td>
                        <td  width="150px;"><?= substr($item->medicoagenda, 0, 15); ?></td>
                        <td ><?= $item->convenio; ?></td>
                        <td ><?= utf8_decode($item->procedimento); ?></td>
                        <td ><?= number_format($item->valor_total, 2, ",", "."); ?></td>
                        <td ><?= number_format($valorpercentualmedico, 2, ",", "."); ?></td>
                        <td ><?= $item->forma_pagamento; ?></td>
                        <td ><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                                    width=500,height=400');">=><?= $item->observacoes; ?></td>
                    </tr>

                    </tbody>
                    <?php
                } else {
                    if ($item->procedimento != $procedimento) {
                        $tabela = 0;
                    }
                    $idade = date("Y-m-d") - $item->nascimento;
                    $procedimento = $item->procedimento;
                    if ($tabela == 0) {
                        $tabela = 1;
                        $i = 1;
                        ?>
                        <tr>
                            <td colspan="7"></td>
                            <td>VL. Total</td>
                            <td><?= number_format($valortotal, 2, ",", "."); ?></td>
                            <td><?= number_format($valortotalmedico, 2, ",", "."); ?></td>
                        </tr>
                    </table>
                    <p>
                        <?
                        $valorliquidoclinica = $valortotaldinheiro - $valortotalmedico;
                        ?>
                    <table border="1">
                        <thead>
                            <tr>
                                <th colspan="2">Resumo Geral</th>
                            </tr>
                            <tr>
                                <th>Valor Medico</th>
                                <th><?= number_format($valortotalmedico, 2, ",", "."); ?></th>
                            </tr>
                            <tr>
                                <th>Valor Cartao</th>
                                <th><?= number_format($valortotalcartao, 2, ",", "."); ?></th>
                            </tr>
                            <tr>
                                <th>Valor Convenio</th>
                                <th><?= number_format($valortotalconvenio, 2, ",", "."); ?></th>
                            </tr>
                            <tr>
                                <th>Valor Dinheiro</th>
                                <th><?= number_format($valortotaldinheiro, 2, ",", "."); ?></th>
                            </tr>
                            <tr>
                                <th>Valor Liquido Clinica</th>
                                <th><?= number_format($valorliquidoclinica, 2, ",", "."); ?></th>
                            </tr>
                        </thead>
                    </table>
                    <p>
                    <table border="1">
                        <thead>
                            <tr>
                                <th class="tabela_header" >Ordem</th>
                                <th class="tabela_header" >Status</th>
                                <th class="tabela_header" width="250px;">Nome</th>
                                <th class="tabela_header" width="250px;">Idade</th>
                                <th class="tabela_header" width="70px;">Data</th>
                                <th class="tabela_header" width="70px;">Hora</th>
                                <th class="tabela_header" width="150px;">Medico</th>
                                <th class="tabela_header" width="120px;">Convenio</th>
                                <th class="tabela_header" width="120px;">Procedimento</th>
                                <th class="tabela_header" width="90px;">Valor</th>
                                <th class="tabela_header" width="90px;">V. Medico</th>
                                <th class="tabela_header" width="90px;">F. Pagamento</th>
                                <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            $valortotal = 0;
                            $valortotalmedico = 0;
                            $valortotaldinheiro = 0;
                            $valortotalcartao = 0;
                            $valortotalconvenio = 0;
                            $valorliquidoclinica = 0;
                        }
                        $verificador++;
                        foreach ($relatorioprioridade as $itens) {
                            $idade = date("Y-m-d") - $item->nascimento;
//                        var_dump($i);
//                        echo"----";
                            $idade = date("Y-m-d") - $item->nascimento;
                            $ordenador = intval($itens->ordenador);
//                                                var_dump($ordenador);
//                        die;

                            if ($i == $ordenador) {
                                $dataFuturo = date("Y-m-d H:i:s");
                                $dataAtual = $itens->data_atualizacao;

                                $date_time = new DateTime($dataAtual);
                                $diff = $date_time->diff(new DateTime($dataFuturo));
                                $teste = $diff->format('%H:%I:%S');

//                                var_dump($itens->procedimento);
//                                die;
                                $paciente = "";

                                if ($itens->realizada == 't' && $itens->situacaolaudo != 'FINALIZADO') {
                                    $situacao = "Aguardando";
                                    $verifica = 2;
                                } elseif ($itens->realizada == 't' && $itens->situacaolaudo == 'FINALIZADO') {
                                    $situacao = "Finalizado";
                                    $verifica = 4;
                                } else {
                                    $situacao = "espera";
                                    $verifica = 3;
                                }
                                if ($item->procedimento == $itens->procedimento) {
                                    $procedimentopercentual = $itens->procedimento_tuss_id;
                                    $medicopercentual = $itens->medico_parecer1;
                                    $percentual = $this->guia->percentualmedico($procedimentopercentual, $medicopercentual);
                                    $testearray = count($percentual);
                                    if ($item->percentual == "t") {
                                        $simbolopercebtual = " %";
                                        if ($testearray > 0) {
                                            $valorpercentualmedico = $percentual[0]->valor;
                                        } else {
                                            $valorpercentualmedico = $item->perc_medico;
                                        }
                                        $perc = $item->valor_total * ($valorpercentualmedico / 100);
                                        $totalperc = $totalperc + $perc;
                                        $totalgeral = $totalgeral + $item->valor_total;
                                    } else {
                                        $simbolopercebtual = "";
                                        if ($testearray > 0) {
                                            $valorpercentualmedico = $percentual[0]->valor;
                                        } else {
                                            $valorpercentualmedico = $item->perc_medico;
                                        }
                                        $perc = $valorpercentualmedico;
                                        $totalperc = $totalperc + $perc;
                                        $totalgeral = $totalgeral + $item->valor_total;
                                    }
                                    $valortotal = $valortotal + $itens->valor_total;
                                    $valortotalmedico = $valortotalmedico + $valorpercentualmedico;
                                    if ($itens->dinheiro == 't') {
                                        if ($item->forma_pagamento == 'DINHEIRO') {
                                            $valortotaldinheiro = $valortotaldinheiro + $itens->valor_total;
                                        } else {
                                            $valortotalcartao = $valortotalcartao + $itens->valor_total;
                                        }
                                    } else {
                                        $valortotalconvenio = $valortotalconvenio + $itens->valor_total;
                                    }
                                    ?>
                                    <tr>
                                        <td ><b><?= $i . " P"; ?></b></td>
                                        <td ><b><?= $situacao; ?></b></td>
                                        <td <b><?= $itens->paciente; ?></b></td>
                                        <td <b><?= $idade; ?></b></td>
                                        <td><?= substr($itens->data, 8, 2) . "/" . substr($itens->data, 5, 2) . "/" . substr($itens->data, 0, 4); ?></td>
                                        <td  width="150px;"><?= $itens->inicio; ?></td>
                                        <td  width="150px;"><?= substr($itens->medicoagenda, 0, 15); ?></td>
                                        <td ><?= $itens->convenio; ?></td>
                                        <td ><?= utf8_decode($itens->procedimento); ?></td>
                                        <td ><?= number_format($itens->valor_total, 2, ",", "."); ?></td>
                                        <td ><?= number_format($valorpercentualmedico, 2, ",", "."); ?></td>
                                        <td ><?= $item->forma_pagamento; ?></td>
                                        <td ><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $itens->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                                                                                                                                                                                                                                width=500,height=230');">=><?= $itens->observacoes; ?></td>
                                    </tr>

                                </tbody>
                                <?php
                            }
                        }
                    }
                    $dataFuturo = date("Y-m-d H:i:s");
                    $dataAtual = $item->data_atualizacao;

                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%H:%I:%S');


                    $paciente = "";

                    if ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') {
                        $situacao = "Aguardando";
                        $verifica = 2;
                    } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                        $situacao = "Finalizado";
                        $verifica = 4;
                    } else {
                        $situacao = "espera";
                        $verifica = 3;
                    }
                    $procedimentopercentual = $item->procedimento_tuss_id_novo;
                    $medicopercentual = $item->medico_parecer1;
                    $percentual = $this->guia->percentualmedico($procedimentopercentual, $medicopercentual);
                    $testearray = count($percentual);
                    if ($item->percentual == "t") {
                        $simbolopercebtual = " %";
                        if ($testearray > 0) {
                            $valorpercentualmedico = $percentual[0]->valor;
                        } else {
                            $valorpercentualmedico = $item->perc_medico;
                        }
                        $perc = $item->valor_total * ($valorpercentualmedico / 100);
                        $totalperc = $totalperc + $perc;
                        $totalgeral = $totalgeral + $item->valor_total;
                    } else {
                        $simbolopercebtual = "";
                        if ($testearray > 0) {
                            $valorpercentualmedico = $percentual[0]->valor;
                        } else {
                            $valorpercentualmedico = $item->perc_medico;
                        }
                        $perc = $valorpercentualmedico;
                        $totalperc = $totalperc + $perc;
                        $totalgeral = $totalgeral + $item->valor_total;
                    }




                    $valortotal = $valortotal + $item->valor_total;
                    $valortotalmedico = $valortotalmedico + $valorpercentualmedico;
                    if ($item->dinheiro == 't') {
                        if ($item->forma_pagamento == 'DINHEIRO') {
                            $valortotaldinheiro = $valortotaldinheiro + $item->valor_total;
                        } else {
                            $valortotalcartao = $valortotalcartao + $item->valor_total;
                        }
                    } else {
                        $valortotalconvenio = $valortotalconvenio + $item->valor_total;
                    }
                    ?>
                    <tr>
                        <td ><b><?= $i; ?></b></td>
                        <td ><b><?= $situacao; ?></b></td>
                        <td <b><?= $item->paciente; ?></b></td>
                        <td <b><?= $idade; ?></b></td>
                        <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td  width="150px;"><?= $item->inicio; ?></td>
                        <td  width="150px;"><?= substr($item->medicoagenda, 0, 15); ?></td>
                        <td ><?= $item->convenio; ?></td>
                        <td ><?= utf8_decode($item->procedimento); ?></td>
                        <td ><?= number_format($item->valor_total, 2, ",", "."); ?></td>
                        <td ><?= number_format($valorpercentualmedico, 2, ",", "."); ?></td>
                        <td ><?= $item->forma_pagamento; ?></td>
                        <td ><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                                                                                    width=500,height=400');">=><?= $item->observacoes; ?></td>
                    </tr>

                    </tbody>
                    <?php
                }
            }
        } elseif (count($relatorioprioridade) > 0) {
            $i = 0;
            foreach ($relatorioprioridade as $item) {
                $idade = date("Y-m-d") - $item->nascimento;
                $i++;
                $dataFuturo = date("Y-m-d H:i:s");
                $dataAtual = $item->data_atualizacao;

                $date_time = new DateTime($dataAtual);
                $diff = $date_time->diff(new DateTime($dataFuturo));
                $teste = $diff->format('%H:%I:%S');


                $paciente = "";

                if ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') {
                    $situacao = "Aguardando";
                    $verifica = 2;
                } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                    $situacao = "Finalizado";
                    $verifica = 4;
                } else {
                    $situacao = "espera";
                    $verifica = 3;
                }
                $procedimentopercentual = $item->procedimento_tuss_id_novo;
                $medicopercentual = $item->medico_parecer1;
                $percentual = $this->guia->percentualmedico($procedimentopercentual, $medicopercentual);
                $testearray = count($percentual);
                if ($item->percentual == "t") {
                    $simbolopercebtual = " %";
                    if ($testearray > 0) {
                        $valorpercentualmedico = $percentual[0]->valor;
                    } else {
                        $valorpercentualmedico = $item->perc_medico;
                    }
                    $perc = $item->valor_total * ($valorpercentualmedico / 100);
                    $totalperc = $totalperc + $perc;
                    $totalgeral = $totalgeral + $item->valor_total;
                } else {
                    $simbolopercebtual = "";
                    if ($testearray > 0) {
                        $valorpercentualmedico = $percentual[0]->valor;
                    } else {
                        $valorpercentualmedico = $item->perc_medico;
                    }
                    $perc = $valorpercentualmedico;
                    $totalperc = $totalperc + $perc;
                    $totalgeral = $totalgeral + $item->valor_total;
                }
                $valortotal = $valortotal + $item->valor_total;
                $valortotalmedico = $valortotalmedico + $valorpercentualmedico;
                if ($item->dinheiro == 't') {
                    if ($item->forma_pagamento == 'DINHEIRO') {
                        $valortotaldinheiro = $valortotaldinheiro + $item->valor_total;
                    } else {
                        $valortotalcartao = $valortotalcartao + $item->valor_total;
                    }
                } else {
                    $valortotalconvenio = $valortotalconvenio + $item->valor_total;
                }
                ?>
                <tr>
                    <td ><b><?= $i; ?></b></td>
                    <td ><b><?= $situacao; ?></b></td>
                    <td <b><?= $item->paciente; ?></b></td>
                    <td <b><?= $idade; ?></b></td>
                    <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                    <td  width="150px;"><?= $item->inicio; ?></td>
                    <td  width="150px;"><?= substr($item->medicoagenda, 0, 15); ?></td>
                    <td ><?= $item->convenio; ?></td>
                    <td ><?= utf8_decode($item->procedimento); ?></td>
                    <td ><?= number_format($item->valor_total, 2, ",", "."); ?></td>
                    <td ><?= number_format($valorpercentualmedico, 2, ",", "."); ?></td>
                    <td ><?= $item->forma_pagamento; ?></td>
                    <td ><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                                                                                                                width=500,height=400');">=><?= $item->observacoes; ?></td>
                </tr>

                </tbody>
                <?php
            }
            ?>
        </table>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header" >Ordem</th>
                    <th class="tabela_header" >Status</th>
                    <th class="tabela_header" width="250px;">Nome</th>
                    <th class="tabela_header" width="250px;">Idade</th>
                    <th class="tabela_header" width="70px;">Data</th>
                    <th class="tabela_header" width="70px;">Hora</th>
                    <th class="tabela_header" width="150px;">Medico</th>
                    <th class="tabela_header" width="120px;">Convenio</th>
                    <th class="tabela_header" width="120px;">Procedimento</th>
                    <th class="tabela_header" width="90px;">Valor</th>
                    <th class="tabela_header" width="90px;">V. Medico</th>
                    <th class="tabela_header" width="90px;">F. Pagamento</th>
                    <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                </tr>
            </thead>
            <tbody>
                <?
            }
            ?>

            <!--</table>-->
            <tr>
                <td colspan="7"></td>
                <td>VL. Total</td>
                <td><?= number_format($valortotal, 2, ",", "."); ?></td>
                <td><?= number_format($valortotalmedico, 2, ",", "."); ?></td>
            </tr>
    </table>
    <?
    $valorliquidoclinica = $valortotaldinheiro - $valortotalmedico;
    ?>
    <table border="1">
        <thead>
            <tr>
                <th colspan="2">Resumo Geral</th>
            </tr>
            <tr>
                <th>Valor Medico</th>
                <th><?= number_format($valortotalmedico, 2, ",", "."); ?></th>
            </tr>
            <tr>
                <th>Valor Cartao</th>
                <th><?= number_format($valortotalcartao, 2, ",", "."); ?></th>
            </tr>
            <tr>
                <th>Valor Convenio</th>
                <th><?= number_format($valortotalconvenio, 2, ",", "."); ?></th>
            </tr>
            <tr>
                <th>Valor Dinheiro</th>
                <th><?= number_format($valortotaldinheiro, 2, ",", "."); ?></th>
            </tr>
            <tr>
                <th>Valor Liquido Clinica</th>
                <th><?= number_format($valorliquidoclinica, 2, ",", "."); ?></th>
            </tr>
        </thead>
    </table>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



                                            $(function() {
                                                $("#accordion").accordion();
                                            });

</script>
