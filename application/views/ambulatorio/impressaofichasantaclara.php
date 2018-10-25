<meta charset="UTF-8">
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>
    <? // echo'<pre>';    var_dump($exame[0]->email);die;?>
    <table border="1" width="100%" style="border-collapse: collapse">
        <tr height="90px">
            <td colspan="1">
                <table style="width: 100%;">
                    <tbody>
                        <tr>                        
                            <td width="900px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                        </tr>

                        <tr>
                            <td align="center"><font size = -1>Telefone:<?= $exame[0]->telefoneempresa; ?></td>                        
                        </tr>
                        <tr>
                            <td align="center"><font size = -1>Email:<?= $exame[0]->email; ?></td>                        
                        </tr>

                    </tbody>
                </table>
            </td>
            <td colspan="1">
                <table style="width: 250px;">
                    <tr>
                        <td>
                            &nbsp;&nbsp;<b>Data Coleta:</b> <?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="width: 100%;">
                    <tbody>
                        <tr height="50px">                        
                            <td colspan="2" width="900px" align="center"><span style="font-weight: normal"><b>PROTOCOLO DE RETIRADA</b></span></td>
                        </tr>

                        <tr>
                            <td><font size = -1>RG: <?= $exame[0]->rg; ?></td>                        
                            <td><font size = -1>Nº CARTEIRINHA: <?= $exame[0]->rg; ?></td>                        
                            <td><font size = -1><b>Resultados na Internet:</b> http://stgclinica.ddns.net/pacientesantaclara/</td>                        
                        </tr>
                       
                        <tr>
                            <td colspan="2"><font size = -1>NOME: <?= $exame[0]->paciente_id; ?> - <?= $exame[0]->paciente; ?></td>
                            <td><font size = -1><b>Usuario:</b><?= $exame[0]->paciente_id; ?> <b>Senha:</b><?= $exame[0]->agenda_exames_id; ?></td>                        
                        </tr>
                        <tr>
                            <td><font size = -1>IDADE: <?= $teste; ?></td>                        
                            <td><font size = -1>SEXO: <?= $paciente[0]->sexo; ?></td>                        
                                                    
                        </tr>
                        <tr>
                            <td colspan="2"><font size = -1>MÉDICO: <?
                                if ($exame[0]->crm_medico != '') {
                                    echo $exame[0]->crm_medico;
                                } else {
                                    echo 'NI';
                                }
                                ?>  - <?
                                if ($exame[0]->medico != '') {
                                    echo $exame[0]->medico;
                                } else {
                                    echo 'NÃO INFORMADO';
                                }
                                ?>
                            </td>                        
                            <td><font size = -1><b>Solicitação: <?= $exame[0]->agenda_exames_id; ?></b></td>                        
                        </tr>
                        <tr>
                            <?
                            $maior_data_entrega = '1995-08-30';
                            foreach ($exames as $item):
                                if ($item->data_entrega > $maior_data_entrega) {
                                    $maior_data_entrega = $item->data_entrega;
                                } else {
                                    $maior_data_entrega = $maior_data_entrega;
                                }
                            endforeach;
                            ?>
                            <td colspan="2"><font size = -1><b>
                                    PREVISÃO DE ENTREGA: <?= ($maior_data_entrega != '1995-08-30') ? date("d/m/Y", strtotime($maior_data_entrega)) : ''; ?>
                                </b></td>                        
                        </tr>

                    </tbody>
                </table>                
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>
                <b>Procedimentos</b>
            </td>
        </tr>
        <tr height="30px">
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
            $contador = 0;            
            foreach ($exames as $item) :
                $u = 0;
                $contador++;
                

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
                if($item->faturado == 't'){
                $valor_total_pago = $valor_total_ficha + ($item->valor_total * $item->quantidade);
                }else{
                $valor_total_pago = 0;    
                }
                $desconto_total = $desconto_total + $item->desconto;
                ?>
                <td width="400px">
                    <font size = -1><?= $item->codigo ?> - <?= $item->procedimento ?>
                </td>    
                    <?if ($contador == 3) {
                        $contador = 0;
                        ?>
                </tr><tr>
                    <?
                }

//        var_dump($contador1);die;
            endforeach;
            ?>
        </tr>
        <tr height="50px">
            <td class="tabela_header"><b>Total de Procedimentos: <?= count($exames); ?></b></td>
            <td><b>Valor Total: R$ <?= $valor_total_ficha ?></b></td>
            <td><b>Valor Pago: R$ <?= $valor_total_pago ?></b></td>
        </tr>
    </table>
    <br>
    <table border="1" width="100%" style="border-collapse: collapse">
        <tr height="90px">
            <td colspan="1">
                <table style="width: 100%;">
                    <tbody>
                        <tr>                        
                            <td width="900px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                        </tr>

                        <tr>
                            <td align="center"><font size = -1>Telefone:<?= $exame[0]->telefoneempresa; ?></td>                        
                        </tr>
                        <tr>
                            <td align="center"><font size = -1>Email:<?= $exame[0]->email; ?></td>                        
                        </tr>

                    </tbody>
                </table>
            </td>
            <td colspan="1">
                <table style="width: 250px;">
                    <tr>
                        <td>
                            &nbsp;&nbsp;<b>Data Coleta:</b> <?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="width: 100%;">
                    <tbody>
                        <tr height="50px">                        
                            <td colspan="2" width="900px" align="center"><span style="font-weight: normal"><b>PROTOCOLO DE RETIRADA</b></span></td>
                        </tr>

                        <tr>
                            <td><font size = -1>RG: <?= $exame[0]->rg; ?></td>                        
                            <td><font size = -1>Nº CARTEIRINHA: <?= $exame[0]->rg; ?></td>                        
                            <td><font size = -1><b>Resultados na Internet:</b> http://stgclinica.ddns.net/pacientesantaclara/</td>                        
                        </tr>
                        
                        <tr>
                            <td colspan="2"><font size = -1>NOME: <?= $exame[0]->paciente_id; ?> - <?= $exame[0]->paciente; ?></td>
                            <td><font size = -1><b>Usuario:</b><?= $exame[0]->paciente_id; ?> <b>Senha:</b><?= $exame[0]->agenda_exames_id; ?></td>                        
                        </tr>
                        <tr>
                            <td><font size = -1>IDADE: <?= $teste; ?></td>                        
                            <td><font size = -1>SEXO: <?= $paciente[0]->sexo; ?></td>                        
                                                   
                        </tr>
                        <tr>
                            <td colspan="2"><font size = -1>MÉDICO: <?
                                if ($exame[0]->crm_medico != '') {
                                    echo $exame[0]->crm_medico;
                                } else {
                                    echo 'NI';
                                }
                                ?>  - <?
                                if ($exame[0]->medico != '') {
                                    echo $exame[0]->medico;
                                } else {
                                    echo 'NÃO INFORMADO';
                                }
                                ?>
                            </td>                        
                            <td><font size = -1><b>Solicitação: <?= $exame[0]->agenda_exames_id; ?></b></td>                        
                        </tr>
                        <tr>
                            <?
                            $maior_data_entrega = '1995-08-30';
                            foreach ($exames as $item):
                                if ($item->data_entrega > $maior_data_entrega) {
                                    $maior_data_entrega = $item->data_entrega;
                                } else {
                                    $maior_data_entrega = $maior_data_entrega;
                                }
                            endforeach;
                            ?>
                            <td colspan="2"><font size = -1><b>
                                    PREVISÃO DE ENTREGA: <?= ($maior_data_entrega != '1995-08-30') ? date("d/m/Y", strtotime($maior_data_entrega)) : ''; ?>
                                </b></td>                        
                        </tr>

                    </tbody>
                </table>                
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>
                <b>Procedimentos</b>
            </td>
        </tr>
        <tr height="30px">
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
            $contador = 0;            
            foreach ($exames as $item) :
                $u = 0;
                $contador++;
                

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
                if($item->faturado == 't'){
                $valor_total_pago = $valor_total_ficha + ($item->valor_total * $item->quantidade);
                }else{
                $valor_total_pago = 0;    
                }
                $desconto_total = $desconto_total + $item->desconto;
                ?>
                <td width="400px">
                    <font size = -1><?= $item->codigo ?> - <?= $item->procedimento ?>
                </td>    
                    <?if ($contador == 3) {
                        $contador = 0;
                        ?>
                </tr><tr>
                    <?
                }

//        var_dump($contador1);die;
            endforeach;
            ?>
        </tr>
        <tr height="50px">
            <td class="tabela_header"><b>Total de Procedimentos: <?= count($exames); ?></b></td>
            <td><b>Valor Total: R$ <?= $valor_total_ficha ?></b></td>            
            <td><b>Valor Pago: R$ <?= $valor_total_pago ?></b></td>
        </tr>
    </table>


</div>












