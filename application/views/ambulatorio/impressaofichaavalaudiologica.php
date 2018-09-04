<meta charset="UTF-8">
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    $idade = $diff->format('%Y');
    ?>


    <hr>
    <!--<br>-->
    <table style="width: 100%;text-align: center;">
        <tr>
            <td>
                <!--<h4 style="text-align: center;">-->
                <span style="font-weight: bold">AVALIAÇÃO AUDIOLÓGICA</span> <br>
                <span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span>
                <!--</h4>-->  
            </td>
        </tr>
    </table>
    <hr>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%" colspan="2"><b><font size = -1><?= $paciente['0']->nome; ?></b></td>
<!--                <td ><font size = -1><?= $exame[0]->razao_social; ?></td>-->
            </tr>
            <tr>
                <td ><font size = -1>FUNÇÃO: </td>
                <td ><font size = -1>SETOR:</td>
                <!--<td ><font size = -1>Formulário: <?= $exame[0]->ambulatorio_guia_id; ?></td>-->
                <!--<td ><font size = -1>Data: <?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?></td>-->
<!--                <td ><font size = -1>Informações: <?= $exame[0]->telefoneempresa; ?></td>-->
            </tr>
            <tr>
                <? //echo '<pre>'; var_dump($exame); die;?>
                <td ><font size = -1>SEXO: <?= $paciente[0]->sexo; ?> </td>
                <!--<td colspan="2"><font size = -1>Previsão de Entrega: <?= ($exame[0]->data_entrega != '') ? date("d/m/Y", strtotime($exame[0]->data_entrega)) : ''; ?>, a partir das 16h</td>-->
                <td ><font size = -1>RG: <?= $paciente[0]->rg; ?>  </td>
                <td ><font size = -1>DATA DE NASCIMENTO: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?> </td>
                <td ><font size = -1>IDADE: <?= $teste; ?> </td>
            </tr>
            <tr>
                <td ><font size = -1>EMPRESA: <?= $exame[0]->convenio; ?> </td>
                <td ><font size = -1>CABINE:  </td>
                <td ><font size = -1>AFERIÇÃO:  </td>
                <td ><font size = -1>DATA DO EXAME: <?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?> </td>
            </tr>
            <tr>
                <td ><font size = -1>AUDIÔMETRO: </td>
                <td ><font size = -1>FABRICANTE:  </td>
                <td ><font size = -1>AFERIÇÃO:  </td>                
            </tr>
            <tr>
                <td ><font size = -1>TEMPO CALIBRAÇÃO: </td>
                <td ><font size = -1>REPOUSO AUDITIVO:  </td>
                <td ><font size = -1>NÍVEL DE RUÍDO:  </td>                
                <td ><font size = -1>Nº FICHA: <?= $exame[0]->ambulatorio_guia_id; ?> </td>                
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tr>
            <td colspan="1"><font size = -1>EXAME(S): <?= $exame[0]->procedimento; ?></b></td>

        </tr>
    </table>

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

<!--    <table style="width: 100%; font-size: 11pt;">
        <tr>
            <td>
                Agenda...: <?= $exame[0]->medico_agenda; ?>  - <?= $exame[0]->medico; ?>
            </td>
            <td>
                <span style="font-weight: bold; font-size: 14pt;">Formulário(AN): <?= $exame[0]->ambulatorio_guia_id; ?></span> 
            </td>
        </tr>
        <tr>
            <td>
                Paciente.: <span style="font-weight: bold"><?= $paciente[0]->paciente_id; ?>  - <?= $paciente[0]->nome; ?></span>
            </td>
            <td>
                Data: <?= date("d/m/Y", strtotime($exame[0]->data)); ?>
            </td>
        </tr>
        <tr>
            <td>
                Endereço: <?= $paciente[0]->logradouro; ?>  - <?= $paciente[0]->numero; ?> - <?= $paciente[0]->bairro; ?>
            </td>
            <td>
                RG: <?= $paciente[0]->rg; ?>
            </td>
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
                CPF......: <?= ($paciente[0]->cpf_responsavel_flag == 'f') ? $paciente[0]->cpf : ''; ?>
            </td>
        </tr>
        <tr>

            <td>
                Idade.......: <span style="font-weight: bold"> <?= $teste; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    Nasc.: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?>
                </span>
            </td>
            <td>
                <span style="font-weight: bold">Chegada:  <?= substr($dataatualizacao, 10, 9); ?></span>
            </td>
        </tr>
        <tr>
            <td>
                Convênio.: <span style="font-weight: bold"> <?= $exame[0]->convenio; ?> </span>
            </td>
            <td>
                Sequência:
            </td>
        </tr>
        <tr>
            <td>
                Carteira....: <?= $paciente[0]->convenionumero; ?>
            </td>
            <td>
                Autorização: <?= $exame[0]->autorizacao; ?>
            </td>
        </tr>
        <tr>
            <td>
                Solicitante: <?= $exame[0]->medico_solicitante; ?>  - <?= $exame[0]->medicosolicitante; ?>
            </td>
            <td>
                Validade: <? //= $exame[0]->agenda_exames_id;                                 ?>
            </td>
        </tr>
        <tr>
            <td>
                Solicit(CPF): 
            </td>
            <td>
                Ficha Dia: 
            </td>
        </tr>
        <tr>
            <td>
                Atendente...: <?= $exame[0]->atendente; ?> 
            </td>
            <td>
                CPF Responsável: <?= ($paciente[0]->cpf_responsavel_flag == 't') ? $paciente[0]->cpf : ''; ?>
            </td>
        </tr>
        <tr>
            <td>
                Responsável: <? //= ($paciente[0]->nome_mae != '')? $paciente[0]->nome_mae : $paciente[0]->nome_pai ;                               ?>
            </td>
            <td>
                Último Atendimento: <?= (count($exameanterior) > 0) ? date("d/m/Y", strtotime($exameanterior[0]->data)) : ''; ?>
            </td>
        </tr>
    </table>-->
    <hr>
    <!--<br>-->
    <table style="width: 100%; text-align: center; font-weight: bolder;">
        <tr>
            <td>
                <span> AUDIOMETRIA TONAL </span>
            </td>
        </tr>
    </table><br>
    <table align="center" border="1" style="text-align: center; border-collapse: collapse" width="60%">
        <tr>
            <th style="font-size: 11pt;">O.D</th>  
            <th style="font-size: 9pt;">125</th>  
            <th style="font-size: 9pt;">250</th>  
            <th style="font-size: 9pt;">500</th>  
            <th style="font-size: 9pt;">750</th>  
            <th style="font-size: 9pt;">1000</th>  
            <th style="font-size: 9pt;">1500</th>  
            <th style="font-size: 9pt;">2000</th>  
            <th style="font-size: 9pt;">3000</th>  
            <th style="font-size: 9pt;">4000</th>  
            <th style="font-size: 9pt;">6000</th>  
            <th style="font-size: 9pt;">8000</th>  
            <th style="font-size: 9pt;">hz</th>  
        </tr>
        <tr>
            <th style="font-size: 11pt;">Via Aérea</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size: 9pt;">dB</td>
        </tr>
        <tr>
            <th style="font-size: 11pt;">Via Óssea</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size: 9pt;">dB</td>
        </tr>
    </table><br>
    <table align="center" border="1" style="text-align: center; border-collapse: collapse" width="60%">
        <tr>
            <th style="font-size: 11pt;">O.E</th>  
            <th style="font-size: 9pt;">125</th>  
            <th style="font-size: 9pt;">250</th>  
            <th style="font-size: 9pt;">500</th>  
            <th style="font-size: 9pt;">750</th>  
            <th style="font-size: 9pt;">1000</th>  
            <th style="font-size: 9pt;">1500</th>  
            <th style="font-size: 9pt;">2000</th>  
            <th style="font-size: 9pt;">3000</th>  
            <th style="font-size: 9pt;">4000</th>  
            <th style="font-size: 9pt;">6000</th>  
            <th style="font-size: 9pt;">8000</th>  
            <th style="font-size: 9pt;">hz</th>  
        </tr>
        <tr>
            <th style="font-size: 11pt;">Via Aérea</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size: 9pt;">dB</td>
        </tr>
        <tr>
            <th style="font-size: 11pt;">Via Óssea</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size: 9pt;">dB</td>
        </tr>
    </table><br><br>
    <table width="100%">
        <tr>
            <td>

            </td>
            <td>
                <table style="width: 100%; text-align: center; font-weight: bolder;">
                    <tr>
                        <td>
                            <span style="color:red"> OUVIDO DIREITO </span>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            </td>
            <td>

            </td>

            <td>
                <table style="width: 100%; text-align: center; font-weight: bolder;">
                    <tr>
                        <td>
                            <span style="color:blue"> OUVIDO ESQUERDO </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <table align="center" style="width: 100%; text-align: center;">
                    <tr style="text-align:right">
                        <td style="font-size: 8pt; padding-left: 15px">125</td>
                        <td style="font-size: 8pt; padding-left: 12px">250</td>
                        <td style="font-size: 8pt; padding-left: 10px">500</td>
                        <td style="font-size: 8pt; padding-left: 8px">750</td>
                        <td style="font-size: 8pt; padding-left: 5px">1000</td>
                        <td style="font-size: 8pt; padding-right: 5px">1500</td>
                        <td style="font-size: 8pt; padding-right: 8px">2000</td>
                        <td style="font-size: 8pt; padding-right: 13px">3000</td>
                        <td style="font-size: 8pt; padding-right: 5px">4000</td>
                        <td style="font-size: 8pt;">6000</td>
                        <td style="font-size: 8pt; padding-right: 15px">8000</td>

                    </tr>  
                </table>   
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>
                <table align="center" style="width: 100%; text-align: center;">
                    <tr style="text-align:right; text-color:white;">
                        <td style="font-size: 8pt; padding-left: 15px">125</td>
                        <td style="font-size: 8pt; padding-left: 12px">250</td>
                        <td style="font-size: 8pt; padding-left: 10px">500</td>
                        <td style="font-size: 8pt; padding-left: 8px">750</td>
                        <td style="font-size: 8pt; padding-left: 5px">1000</td>
                        <td style="font-size: 8pt; padding-right: 5px">1500</td>
                        <td style="font-size: 8pt; padding-right: 8px">2000</td>
                        <td style="font-size: 8pt; padding-right: 13px">3000</td>
                        <td style="font-size: 8pt; padding-right: 5px">4000</td>
                        <td style="font-size: 8pt;">6000</td>
                        <td style="font-size: 8pt; padding-right: 15px">8000</td>

                    </tr>
                </table>
            </td>
        </tr>
        <tr>

            <td>
                <table align="center" style="text-align: center;">

                    <tr style="font-size: 8pt; height: 22px;"><td>-10</td></tr>                    
                    <tr style="font-size: 8pt; height: 22px;"><td>0</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>10</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>20</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>30</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>40</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>50</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>60</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>70</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>80</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>90</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>100</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>110</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>120</td></tr>


                </table>  
            </td>
            <td>
                <table align="center" border="1" style="width: 100%; text-align: center; border-collapse: collapse;">
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>

                </table>
            </td>
            <td>

            </td>
            <td>
                <table align="center" style="text-align: center;">

                    <tr style="font-size: 8pt; height: 22px;"><td>-10</td></tr>                    
                    <tr style="font-size: 8pt; height: 22px;"><td>0</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>10</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>20</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>30</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>40</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>50</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>60</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>70</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>80</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>90</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>100</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>110</td></tr>
                    <tr style="font-size: 8pt; height: 22px;"><td>120</td></tr>


                </table>  
            </td>

            <td>

                <table align="center" border="1" style="width: 100%; text-align: center; border-collapse: collapse;">
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;</td>
            <td>               
                <table style="width: 100%; text-align: center; font-weight: bolder;">
                    <tr>&nbsp;&nbsp;
                        <td>
                            <span style="color:red">&#9711;</span> Aérea
                        </td>
                        <td>
                            <span style="color:red"> [ </span>Óssea Mascarada 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span style="color:red"> < </span>Óssea 
                        </td>
                        <td>
                            <span style="color:red">&#9651;</span> Aérea Mascarada 
                        </td>
                    </tr>
                </table>            
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>               
                <table style="width: 100%; text-align: center; font-weight: bolder;">
                    <tr>&nbsp;&nbsp;
                        <td>
                            <span style="color:blue">&#10006;</span> Aérea
                        </td>
                        <td>
                            <span style="color:blue"> ] </span>Óssea Mascarada 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span style="color:blue"> > </span>Óssea 
                        </td>
                        <td>
                            <span style="color:blue">&#9633;</span> Aérea Mascarada 
                        </td>
                    </tr>
                </table>            
            </td>    
        </tr>
        <tr>
            <td>&nbsp;&nbsp;</td>
            <td>               
                <table style="width: 100%; text-align: center; font-weight: bolder; font-size: 10pt">
                    <tr>&nbsp;&nbsp;
                        <td style="padding-right: 230px">
                           LRF: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:red">dB</span>
                        </td>
                        <td>
                             &nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-right: 230px">
                            LAF: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:red">dB</span> 
                        </td>
                        <td>
                             &nbsp;&nbsp;
                        </td>
                    </tr>
                </table>            
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>               
                <table style="width: 100%; text-align: center; font-weight: bolder; font-size: 10pt">
                    <tr>&nbsp;&nbsp;
                        <td style="padding-right: 230px">
                           LRF: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:blue">dB</span>
                        </td>
                        <td>
                             &nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-right: 230px">
                            LAF: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:blue">dB</span> 
                        </td>
                        <td>
                             &nbsp;&nbsp;
                        </td>
                    </tr>
                </table>             
            </td>    
        </tr>
        
    </table> <br>
    <table width="100%" >
        <tr>
            
            <td>
                <table style="width: 450px; text-align: center; font-weight: bolder; font-size: 10pt">
                    <tr>
                        <td>
                            <span> ÍNDICE PERCENTUAL DE RECONHECIMENTO DE FALA </span>
                        </td>
                    </tr>
                </table>
            </td>
            
            <td>
                <table style="width: 450px; text-align: center; font-weight: bolder;">
                    <tr>
                        <td>
                            <span> MASCARAMENTO (EM dB) </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
           
            <td>
                <table align="center" border="1" style="width: 100%; text-align: center; border-collapse: collapse;">
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>Intensidade</td>
                        <td>Monossílaba</td>
                        <td>Dissílaba</td>
                    </tr>
                    <tr>
                        <td>Pal. Faladas</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>OD</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>OE</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        
                    </tr>
                </table>
            </td>
            
            <td>
                <table align="center" border="1" style="width: 100%; text-align: center; border-collapse: collapse;">
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>VA</td>
                        <td>VO</td>
                        <td>LOGO/</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>MIN/MAX</td>
                        <td>MIN/MAX</td>
                        <td>QTDE</td>
                    </tr>
                    <tr>
                        <td>OD</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>OE</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" height="100px" style="font-size: 10pt">
       <tr>          
          <td>
              <span><b> MEATOSCOPIA:</b>&nbsp;&nbsp; CANAL ORELHA DIREITA LIVRE: </span>
           </td>
           <td>
              <span> CANAL ORELHA ESQUERDA LIVRE: </span> 
           </td>
       </tr>
       
       <tr>
           <td>
               <span> <b>PARECER AUDIOLÓGICO:</b> </span> 
           </td>
       </tr>
    </table><br>

    <table width="100%" align="center" style="font-size: 10pt"><br><br>
        <tr>
            <td>
                &nbsp;&nbsp;&nbsp;         ___________________________________ <br>
                &nbsp;&nbsp;&nbsp;        &nbsp;&nbsp;&nbsp; FONOAUDIÓLOGO
            </td>



            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ________________________________________ <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ASSINATURA DO FUNCIONÁRIO(A)
            </td>


        </tr>
    </table>



</div>

<br>











