<meta charset="UTF-8">
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>
    <table>
        <td>
            <table style="width: 200px;">
                <tr>
                    <td>
                        <?= @$cabecalho_config; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table style="width: 100%;">
                <tbody>
                    <tr>                        
                        <td width="900px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    <tr>                        
                        <td align="center"><font size = -1>Rua Raimundo Nogueira Lopes, 236  Centro - Horizonte</td>
                    </tr>
                    <tr>
                        <td align="center"><font size = -1><?= $exame[0]->telefoneempresa; ?>-<?= $exame[0]->celularempresa; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; multiclinicashorizonte@yahoo.com.br</td>                        
                    </tr>

                </tbody>
            </table>
        </td>
    </table>
    <table style="width: 100%">
        <tr>            
            <td colspan="2"><b><font size = -1><?= $paciente['0']->nome; ?></b></td>
            <td align="right"><font size = -1>Data de Realização do(s) exame(s):<b> <?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?></b></td>            
<!--            <td ><font size = -1>
                <b>Resultado: www.clinicavaleimagem.com.br/ </b><br>
                Usuario:&nbsp;<b><?= $paciente['0']->paciente_id ?>&nbsp;</b>Senha: &nbsp;<b><?= $exames['0']->agenda_exames_id ?></b>
            </td>-->
        </tr>
        <tr>
            <td colspan="2"><font size = -1>Exame(s):<b> <?= $exame[0]->procedimento; ?></b></td>            
            <!--<td colspan="1" align="right"><font size = -1>Horário de Atendimento:<b> <?= $exame[0]->inicio; ?></b></td>-->            
        </tr>
    </table>
    <? // echo'<pre>'; var_dump($exame);die;?>
    <br><br>
    <?
    foreach ($exames as $item) :
        if ($item->grupo == $exame[0]->grupo) {
            $exame_id = $item->agenda_exames_id;
            $dataatualizacao = $item->data_autorizacao;
            $inicio = $item->inicio;
            $agenda = $item->agenda;
            $operador_autorizacao = $item->operador;
            ?>     
            <?
        }
    endforeach;
    ?>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td width="30px">
                            <?= @$cabecalho_config; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>                        
                        <td width="700px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    <tr>                        
                        <td align="center"><font size = -1>Rua Raimundo Nogueira Lopes, 236  Centro - Horizonte</td>
                    </tr>
                    <tr>
                        <td align="center"><font size = -1><?= $exame[0]->telefoneempresa; ?>-<?= $exame[0]->celularempresa; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; multiclinicashorizonte@yahoo.com.br</td>                        
                    </tr>                    
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="30px">
                            <?= @$cabecalho_config; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>                        
                        <td width="700px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    <tr>                        
                        <td align="center"><font size = -1>Rua Raimundo Nogueira Lopes, 236  Centro - Horizonte</td>
                    </tr>
                    <tr>
                        <td align="center"><font size = -1><?= $exame[0]->telefoneempresa; ?>-<?= $exame[0]->celularempresa; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; multiclinicashorizonte@yahoo.com.br</td>                        
                    </tr>  
                </table>
            </td>
        </tr>

    </table>
    <table style="width: 100%;">
        <tr>
            <td align="center">
                <hr>                
                <b><?= $exame[0]->grupo; ?></b>                
                <hr>
            </td>
            <td align="center">
                <hr>
                <b><?= $exame[0]->grupo; ?></b> 
                <hr>
            </td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 11pt;">

        <tr>
            <td>Código: <?= $item->codigo ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Data: <?= date("d/m/Y", strtotime($exame[0]->data)); ?></td>
            <td>Código: <?= $item->codigo ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Data: <?= date("d/m/Y", strtotime($exame[0]->data)); ?></td>

        </tr>
        
        <tr>
            <td>
                Paciente.: <span style="font-weight: bold"><?= $paciente[0]->paciente_id; ?>  - <?= $paciente[0]->nome; ?></span>
            </td>
            <td>
                Paciente.: <span style="font-weight: bold"><?= $paciente[0]->paciente_id; ?>  - <?= $paciente[0]->nome; ?></span>
            </td>

        </tr>
        
        <tr>
            <td>
                Idade.......:  <?= $teste; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Nasc.: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

            </td>
            <td>
                Idade.......:  <?= $teste; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Nasc.: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

            </td>

        </tr>
        <tr>
            <td>RG: <?= $paciente[0]->rg; ?></td>
            <td>RG: <?= $paciente[0]->rg; ?></td>
        </tr>
        <tr>
            <td>
                Telefones: <?= $paciente[0]->telefone; ?>  - <?= $paciente[0]->celular; ?> - <?= $paciente[0]->whatsapp; ?>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Sexo:  <span style="font-weight: bold"><?= $paciente[0]->sexo; ?></span>
            </td>
            <td>
                Telefones: <?= $paciente[0]->telefone; ?>  - <?= $paciente[0]->celular; ?> - <?= $paciente[0]->whatsapp; ?>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Sexo:  <span style="font-weight: bold"><?= $paciente[0]->sexo; ?></span>
            </td>

        </tr>
        <tr>


        </tr>
        <tr>
            <td>
                Tipo de Atendimento.: <span style="font-weight: bold"> <?= $exame[0]->convenio; ?> </span>
            </td>
            <td>
                Tipo de Atendimento.: <span style="font-weight: bold"> <?= $exame[0]->convenio; ?> </span>
            </td>

        </tr>
        <tr>
            <td>Forma de Pagamento.: 
                
                <? foreach ($exames as $key => $item): if ($item->grupo == $exame[0]->grupo) { 
                    if($item->faturado == 't'){?>
                        <?
                        if ($key == count($exames) - 1) {
                            echo $item->formadepagamento;
                            if ($item->formadepagamento2 != '') {
                                echo ", " . $item->formadepagamento2;
                            }
                            if ($item->formadepagamento3 != '') {
                                echo ", " . $item->formadepagamento3;
                            }
                            if ($item->formadepagamento4 != '') {
                                echo ", " . $item->formadepagamento4;
                            }
                        } else {
                            echo $item->formadepagamento . ", ";
                            if ($item->formadepagamento2 != '') {
                                echo $item->formadepagamento2 . ", ";
                            }
                            if ($item->formadepagamento3 != '') {
                                echo $item->formadepagamento3 . ", ";
                            }
                            if ($item->formadepagamento4 != '') {
                                echo $item->formadepagamento4 . ", ";
                            }
                        }
                    }
                }
                    ?>
<? endforeach; ?>
            </td>
            <td>Forma de Pagamento.: 
                
                <? foreach ($exames as $key => $item): if ($item->grupo == $exame[0]->grupo) { 
                    if($item->faturado == 't'){?>
                        <?
                        if ($key == count($exames) - 1) {
                            echo $item->formadepagamento;
                            if ($item->formadepagamento2 != '') {
                                echo ", " . $item->formadepagamento2;
                            }
                            if ($item->formadepagamento3 != '') {
                                echo ", " . $item->formadepagamento3;
                            }
                            if ($item->formadepagamento4 != '') {
                                echo ", " . $item->formadepagamento4;
                            }
                        } else {
                            echo $item->formadepagamento . ", ";
                            if ($item->formadepagamento2 != '') {
                                echo $item->formadepagamento2 . ", ";
                            }
                            if ($item->formadepagamento3 != '') {
                                echo $item->formadepagamento3 . ", ";
                            }
                            if ($item->formadepagamento4 != '') {
                                echo $item->formadepagamento4 . ", ";
                            }
                        }
                    }
                }
                    ?>
<? endforeach; ?>
            </td>
        </tr>
        <tr>
            <td>
                Atendente.: <?= $exame[0]->usuario; ?>
            </td>
            <td>
                Atendente.: <?= $exame[0]->usuario; ?>
            </td>

        </tr>
        <tr>
            <td>Película: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CD: </td>
            <td>Película: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CD: </td>
        </tr>

        <tr>
            <td>
                Previsão de Entrega.: <?= ($exame[0]->data_entrega != '') ? date("d/m/Y", strtotime($exame[0]->data_entrega)) : ''; ?>
            </td>
            <td>
                Previsão de Entrega.: <?= ($exame[0]->data_entrega != '') ? date("d/m/Y", strtotime($exame[0]->data_entrega)) : ''; ?>
            </td>
        </tr>        
        <tr>
            <td>

            </td>
            <td>

            </td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 11pt;">
        <tr>
            <td>
                <table style="width:100%;">                
                    <td><font size = -1>Exame</td>
                    <td align="right"><font size = -1>Valor</td>
                    <hr>
                </table>
            </td>
            <td>
                <table style="width:100%;">                
                    <td><font size = -1>Exame</td>
                    <td align="right"><font size = -1>Valor</td>
                    <hr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 11pt;">
        <tr>
            <td>
                <table style="width: 100%; font-size: 11pt;">

                    <?
                    $valor_total_ficha = 0;
                    $desconto_total = 0;
                    $cartao_total = 0;
                    foreach ($formapagamento as $value) {
                        $data[$value->nome] = 0;
                        $datacredito[$value->nome] = 0;
                        $numerocredito[$value->nome] = 0;
                        $descontocredito[$value->nome] = 0;
                        $numero[$value->nome] = 0;
                        $desconto[$value->nome] = 0;
                    }
//                    echo'<pre>';
//        var_dump($exames); die;
                    foreach ($exames as $item) :
                        $u = 0;



                        if ($item->grupo == $exame[0]->grupo) {
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento == $value->nome) {
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
                                if ($item->formadepagamento2 == $value->nome) {
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
                                if ($item->formadepagamento3 == $value->nome) {
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
                                if ($item->formadepagamento4 == $value->nome) {
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


                            $valor_total_ficha = $valor_total_ficha + ($item->valor_total * $item->quantidade);
                            $desconto_total = $desconto_total + $item->desconto;
                            ?>
        <? // echo'<pre>'; var_dump($exames);die;  ?>
                            <tr>
                                <td ><?= $item->procedimento ?></td>                    
                                <td align="right"><font size = -1>R$<?= number_format($item->valor_total * $item->quantidade, 2, ',', '.') + number_format($item->desconto * $item->quantidade, 2, ',', '.') ?></td>
                            </tr>
                            <?
                        }
                    endforeach;
                    ?>
                    <tr height="50px">
                        <td >Desc: R$ <?= $desconto_total ?></td> 
                        <td align="right">Total Líquido.: R$<?= $valor_total_ficha ?></td>
                    </tr>        
                </table>
                <hr>
                Para sua segurança, não passamos resultado de exames por telefone.<br>
                TRAZER ESTA VIA PARA RECEBIMENTO DE EXAMES.
            </td>

            <td>
                <table style="width: 100%; font-size: 11pt;">

                    <?
                    $valor_total_ficha = 0;
                    $desconto_total = 0;
                    $cartao_total = 0;
                    foreach ($formapagamento as $value) {
//                        var_dump($formapagamento);die;
                        $data[$value->nome] = 0;
                        $datacredito[$value->nome] = 0;
                        $numerocredito[$value->nome] = 0;
                        $descontocredito[$value->nome] = 0;
                        $numero[$value->nome] = 0;
                        $desconto[$value->nome] = 0;
                    }

//        var_dump($exames); die;
                    foreach ($exames as $item) :
                        $u = 0;



                        if ($item->grupo == $exame[0]->grupo) {
                            foreach ($formapagamento as $value) {
                                if ($item->formadepagamento == $value->nome) {
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
                                if ($item->formadepagamento2 == $value->nome) {
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
                                if ($item->formadepagamento3 == $value->nome) {
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
                                if ($item->formadepagamento4 == $value->nome) {
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


                            $valor_total_ficha = $valor_total_ficha + ($item->valor_total * $item->quantidade);
                            $desconto_total = $desconto_total + $item->desconto;
                            ?>
                            <tr>
                                <td ><?= $item->procedimento ?></td>                    
                                <td align="right"><font size = -1>R$<?= number_format($item->valor_total * $item->quantidade, 2, ',', '.') + number_format($item->desconto * $item->quantidade, 2, ',', '.') ?></td>
                            </tr>                            
                            <?
                        }
                    endforeach;
                    ?>
                     <tr height="50px">
                        <td >Desc: R$ <?= $desconto_total ?></td> 
                        <td align="right">Total Líquido.: R$<?= $valor_total_ficha ?></td>
                    </tr>        
                </table>
                <hr>
                Para sua segurança, não passamos resultado de exames por telefone.<br>
                TRAZER ESTA VIA PARA RECEBIMENTO DE EXAMES.
            </td>
        </tr>
    </table>


</div>












