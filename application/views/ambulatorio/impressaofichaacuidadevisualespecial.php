<meta charset="UTF-8">
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>
    <table align="center">
        <td>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <?= @$cabecalho_config; ?>
                    </td>
                </tr>
            </table>
        </td>
    </table>
    <hr>
    <table style="width: 100%; text-align: center;">
        <tr>
            <td>
                <span style="font-weight: bold">TESTE DE ACUIDADE VISUAL - TABELA DE SNELLEN</span> <br> 
            </td>
        </tr>
    </table>
    <hr>
    <!--<br>-->
    <table style="width: 100%;" bgcolor="silver">
        <tr>
            <td>
                <span style="font-weight: normal">1. IDENTIFICAÇÃO</span>
            </td>
        </tr>
    </table>
    <hr>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%" colspan="2"><b><font size = -1><?= $paciente['0']->nome; ?></b></td>
            </tr>
            <tr>
                <td><font size = -1>EMPRESA: <?= $exame[0]->convenio; ?> </td> 
            </tr>
            <tr>
                <td><font size = -1>RG: <?= $paciente[0]->rg; ?></td>
                <td><font size = -1>DATA DE NASCIMENTO: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?> </td>
                <td><font size = -1>SEXO: <?= $paciente[0]->sexo; ?> </td>
            </tr>
            <tr>
                <td><font size = -1>TIPO DE EXAME: </td>
            </tr>
            <tr>
                <td><font size = -1>FUNÇÃO: </td>
            </tr>            
        </tbody>
    </table>
    <hr>
    <table style="width: 100%;" bgcolor="silver">
        <tr>
            <td>
                <span style="font-weight: normal">2. QUESTIONÁRIO OFTALMOLÓGICO</span>
            </td>
        </tr>
    </table>
    <hr>
    <style>

        .tdpadding{
            padding: 10px;
        }


    </style>

    <table style="width: 100%; font-size: 9pt;">
        <tr>
            <td class="tdpadding" style="width: 100%">
                2.1: TEM DIFICULDADE COM A VISÃO?&nbsp; (&nbsp; )&nbsp;SIM (&nbsp; )&nbsp;NÃO;&nbsp;&nbsp; QUAL: _______________________________________________________________________
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                2.2: USA ÓCULOS?&nbsp; (&nbsp; )&nbsp;SIM (&nbsp; )&nbsp;NÃO; (&nbsp; )&nbsp;P/LONGE (&nbsp; )&nbsp;P/PERTO (&nbsp; )&nbsp;BIFOCAL
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                2.3: USA LENTES DE CONTATO?&nbsp; (&nbsp; )&nbsp;SIM (&nbsp; )&nbsp;NÃO;  (&nbsp; )&nbsp;BIFOCAL   (&nbsp; )&nbsp;OUTROS: ___________________________________________________________
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                2.4: REALIZOU CIRURGIA NO(S) OLHO(S)?&nbsp; (&nbsp; )&nbsp;SIM (&nbsp; )&nbsp;NÃO;&nbsp;&nbsp; QUAL: ___________________________________________________________________
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                2.5: ALGUMA QUEIXA COM A VISÃO?&nbsp; (&nbsp; )&nbsp;SIM (&nbsp; )&nbsp;NÃO;&nbsp;&nbsp; DESCREVER: ____________________________________________________________________________________________________________________________________________
            </td>
        </tr>        
        <tr height="50px">
            <td class="tdpadding" style="width: 100%">
                ASSINATURA DO EXAMINADO: ___________________________________________________________________________________________________________
            </td>
        </tr>        
    </table>
    <hr>
    <table style="width: 100%;" bgcolor="silver">
        <tr>
            <td>
                <span style="font-weight: normal">3. TESTE DE ACUIDADE VISUAL</span>
            </td>
        </tr>
    </table>
    <hr>
    <table align="center">
        <tr>
            <td>
                <span style="font-size: 9pt; font-weight: normal">Tabela de Snellen ou Optótico de Snellen Raizamed nº de série A210*9W9</span> 
            </td>
        </tr>
    </table>
    <table width="80%" border="1" style="border-collapse: collapse; text-align: center" align="center">

        <tr>
            <th width="150px"><font size = -1>Indicador</th>
            <th width="150px"><font size = -1>D 3,00m</th>
            <th><font size = -1>OLHO D</th>
            <th><font size = -1>OLHO E</th>                            
        </tr>
        <tr>
            <td><font size = -1>1</td>
            <td><font size = -1>0,1</td>
            <td><font size = -1>ᗱ</td>
            <td><font size = -1>ᗱ</td>                            
        </tr>
        <tr>
            <td><font size = -1>2</td>
            <td><font size = -1>0,2</td>
            <td><font size = -1>ᗰ&nbsp; ᗴ</td>
            <td><font size = -1>ᗰ&nbsp; ᗴ</td>                                                        
        </tr>
        <tr>
            <td><font size = -1>3</td>
            <td><font size = -1>0,4</td>
            <td><font size = -1>ᗱ&nbsp; ᗰ&nbsp; ᗴ&nbsp; ᗯ</td>
            <td><font size = -1>ᗱ&nbsp; ᗰ&nbsp; ᗴ&nbsp; ᗯ</td>
        </tr> 
        <tr>
            <td><font size = -1>4</td>
            <td><font size = -1>0,5</td>
            <td><font size = -1>ᗰ&nbsp; ᗴ&nbsp; ᗯ&nbsp; ᗱ&nbsp; ᗰ</td>
            <td><font size = -1>ᗰ&nbsp; ᗴ&nbsp; ᗯ&nbsp; ᗱ&nbsp; ᗰ</td>
        </tr> 
        <tr>
            <td><font size = -1>5</td>
            <td><font size = -1>0,66</td>
            <td><font size = -1>ᗱ&nbsp; ᗰ&nbsp; ᗯ&nbsp; ᗴ&nbsp; ᗱ&nbsp; ᗰ</td>
            <td><font size = -1>ᗱ&nbsp; ᗰ&nbsp; ᗯ&nbsp; ᗴ&nbsp; ᗱ&nbsp; ᗰ</td>
        </tr> 
        <tr>
            <td><font size = -1>6</td>
            <td><font size = -1>0,8</td>
            <td><font size = -1>ᗰ&nbsp; ᗱ&nbsp; ᗰ&nbsp; ᗯ&nbsp; ᗴ&nbsp; ᗰ&nbsp; ᗱ</td>
            <td><font size = -1>ᗰ&nbsp; ᗱ&nbsp; ᗰ&nbsp; ᗯ&nbsp; ᗴ&nbsp; ᗰ&nbsp; ᗱ</td>
        </tr> 
        <tr>
            <td><font size = -1>7</td>
            <td><font size = -1>1,00</td>
            <td><font size = -1>ᗴ&nbsp; ᗯ&nbsp; ᗱ&nbsp; ᗰ&nbsp; ᗴ&nbsp; ᗯ&nbsp; ᗱ</td>
            <td><font size = -1>ᗴ&nbsp; ᗯ&nbsp; ᗱ&nbsp; ᗰ&nbsp; ᗴ&nbsp; ᗯ&nbsp; ᗱ</td>
        </tr> 
        <tr>
            <td><font size = -1>8</td>
            <td><font size = -1>1,33</td>
            <td><font size = -1>ᗱ&nbsp; ᗴ&nbsp; ᗰ&nbsp; ᗯ&nbsp; ᗴ&nbsp; ᗰ&nbsp; ᗱ</td>
            <td><font size = -1>ᗱ&nbsp; ᗴ&nbsp; ᗰ&nbsp; ᗯ&nbsp; ᗴ&nbsp; ᗰ&nbsp; ᗱ</td>
        </tr> 
        <tr>
            <td><font size = -1>9</td>
            <td><font size = -1>1,54</td>
            <td><font size = -1>ᗱ&nbsp; ᗯ&nbsp; ᗴ&nbsp; ᗰ&nbsp; ᗯ&nbsp; ᗱ&nbsp; ᗰ</td>
            <td><font size = -1>ᗱ&nbsp; ᗯ&nbsp; ᗴ&nbsp; ᗰ&nbsp; ᗯ&nbsp; ᗱ&nbsp; ᗰ</td>
        </tr> 
        <tr>
            <td><font size = -1>10</td>
            <td><font size = -1>2,00</td>
            <td><font size = -1>ᗴ&nbsp; ᗯ&nbsp; ᗱ&nbsp; ᗰ&nbsp; ᗱ&nbsp; ᗯ&nbsp; ᗴ</td>
            <td><font size = -1>ᗴ&nbsp; ᗯ&nbsp; ᗱ&nbsp; ᗰ&nbsp; ᗱ&nbsp; ᗯ&nbsp; ᗴ</td>
        </tr>
    </table>
    <table width="80%" border="1" style="border-collapse: collapse; text-align: center" align="center">
        <tr>
            <td>
                <table style="text-align: center">
                    <tr>
                        <td width="250px"><font size = -1>
                            <b>Cores:</b>
                        </td>
                    </tr>
                </table>            
            </td>
            <td>
                <table style="text-align: center">
                    <tr>
                        <td><font size = -1>(&nbsp; )&nbsp;AMARELO (&nbsp; )&nbsp;VERDE</td>
                    </tr>
                    <tr>
                        <td><font size = -1>(&nbsp; )&nbsp;VERMELHO (&nbsp; )&nbsp;AZUL</td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="text-align: center">
                    <tr>
                        <td><font size = -1>(&nbsp; )&nbsp;AMARELO (&nbsp; )&nbsp;VERDE</td>
                    </tr>
                    <tr>
                        <td><font size = -1>(&nbsp; )&nbsp;VERMELHO (&nbsp; )&nbsp;AZUL</td>
                    </tr>
                </table> 
            </td>
        </tr>
    </table>
    <hr>
    <table style="width: 100%;" bgcolor="silver">
        <tr>
            <td>
                <span style="font-weight: normal">4. RESULTADO DO TESTE</span>
            </td>
        </tr>
    </table>
    <hr>
    <table>
        <tr>
            <td colspan="2">
                <table style="width: 100%; font-size: 9pt;">
                    <tr>
                        <td class="tdpadding" style="width: 100%">
                            4.1 - PERCEPÇÃO DAS CORES: &nbsp; (&nbsp; )&nbsp;NORMAL (&nbsp; )&nbsp;ANORMAL: _______________________________________________________________________
                        </td>
                    </tr>
                    <tr>
                        <td class="tdpadding" style="width: 100%">
                            4.2 - CONCLUSÃO PARA TRABALHO EM ALTURA: &nbsp; (&nbsp; )&nbsp;APTO (&nbsp; )&nbsp;INAPTO (&nbsp; )&nbsp;NÃO APLICÁVEL
                        </td>
                    </tr>
                </table>
            </td>            
        </tr>
        <tr>
            <td>
                <table style="width: 100%; font-size: 9pt;">
                    
                    <tr>
                        <td class="tdpadding" style="width: 100%">
                            4.3 - CONCLUSÃO PARA O TRABALHO:<br><br> &nbsp; &nbsp;  &nbsp; (&nbsp; )&nbsp;LIBERADO PARA O TRABALHO <br> &nbsp;  &nbsp;  &nbsp; (&nbsp; )&nbsp;NÃO LIBERADO PARA O TRABALHO <br> &nbsp; &nbsp;  &nbsp; (&nbsp; )&nbsp;ENCAMINHADO AO OFTALMOLOGISTA 
                        </td>
                    </tr>                
                </table>
            </td>
            <td>
                <table style="width: 100%; font-size: 9pt;">

                    <tr>
                        <td class="tdpadding" style="width: 100%">
                            OBS: ___________________________________________________________________________
                        </td>
                    </tr>
                    <tr>
                        <td class="tdpadding" style="width: 100%">
                            _________________________________________________________________________________
                        </td>
                    </tr>
                    <tr>
                        <td class="tdpadding" style="width: 100%">
                            _________________________________________________________________________________ 
                        </td>
                    </tr>                
                </table> 
            </td>
        </tr>
        <tr height="100px">
            <td></td>
            <td>
                <table style="width: 100%; font-size: 9pt;">
                    <tr>
                        <td class="tdpadding" style="width: 100%">
                            DATA _____/_____/______
                        </td>
                        <td class="tdpadding" style="width: 100%;">
                            ___________________________________ 
                            <br>assinatura e carimbo
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>














