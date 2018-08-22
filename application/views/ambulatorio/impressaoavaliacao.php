<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?
$dataFuturo = date("Y-m-d");
$dataAtual = @$obj->_nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
?>    

<div >
    <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
    <input type="hidden" name="paciente_id" id="paciente_id" class="texto01"  value="<?= @$obj->_paciente_id; ?>"/>
    <fieldset>
        <h3 align = "center">AVALIAÇÃO DE RISCO CIRÚRGICO CARDIOVASCULAR</h3>
    </fieldset>
    <fieldset>
        <legend>Dados</legend>
        <table> 
            <tr>
                <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>                            
            </tr>
            <tr><td>Idade: <?= $teste ?></td>
                <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>

            </tr>


            <tr>                        
                <td>Médico Solicitante: <?= @$obj->_operador ?></td>        
                <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
            </tr>

        </table>
    </fieldset>
    <fieldset>
        <?        
        $tabela1 = json_decode(@$avaliacao[0]->avaliacao_tabela1);
        ?>
        <h4 align = "center">TABELA 1: ALGORITMO DE LEE</h4>
        <table width = "900" border = "1" align = "center">
            <tr>
                <th><br><h5 align = "center">CIR. INTRAPERITONEAL VASCULAR SUPRA INGUINAL</h5></th>
                <th><br><h5 align = "center">DAC : ONDA Q, ANGINA,  TE+, USO NITRATO</h5></th>
                <th><br><h5 align = "center">ICC: CLÍNICA, RX C/ CONGESTÃO, ECO</h5></th>
                <th><br><h5 align = "center">DOENÇA CEREBRO VASCULAR</h5></th>
                <th><br><h5 align = "center">DIABETE + INSULINA</h5></th>
                <th><br><h5 align = "center">CREATININA > 2,0</h5></th>
            </tr> 
            <tr>
                <td>
                    <? echo "$tabela1->c1tb1"; ?>                    
                </td>
                <td>
                    <? echo "$tabela1->c2tb1"; ?>
                </td>
                <td>
                    <? echo "$tabela1->c3tb1"; ?>
                </td>
                <td>
                    <? echo "$tabela1->c4tb1"; ?>
                </td>
                <td>
                    <? echo "$tabela1->c5tb1"; ?>
                </td>
                <td>
                    <? echo "$tabela1->c6tb1"; ?>
                </td>
            </tr>
        </table> <br><br><br>
        <table border = "2" align = "center">
            <tr> 
                <td>
                    <table border="1">
                        <tr>
                            <th>RISCO</th>
                            <th>I</th>
                            <th>II</th>
                            <th>III</th>
                            <th>IV</th>
                        </tr>
                        <tr>
                            <th>VARIÁVEIS</th>
                            <td>0</td>
                            <td>1</td>
                            <td>2</td>
                            <td>>=3</td>
                        </tr>
                        <tr>
                            <th>RISCO</th>
                            <td>0,4</td>
                            <td>0,9</td>
                            <td>7</td>
                            <td>11</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <th>RISCO</th>
                        </tr>
                        <tr>
                            <td><br><br></td>
                        </tr>


                    </table>

                </td>
            </tr>    
        </table>
        <br><br><br>

        <?
        $tabela2 = json_decode(@$avaliacao[0]->avaliacao_tabela2);
        $somatb2 = 0;
        ?>
        <div>

            <h4 align = "center">TABELA 2: CRITÉRIOS DO AMERICAN COLLEGE OF PYISICIANS (ACP)</h4>
            <table width = "900" border = "1" align = "center">
                <tr>
                    <th><br><h5 align = "center"></h5>VARIÁVEL</th>
                    <th><br><h5 align = "center"></h5>RESPOSTA</th>
                    <th><br><h5 align = "center"></h5>PONTOS</th>

                </tr> 
                <tr>
                    <td>
                        IAM < 6 M
                    </td>
                    <td>
                        <? echo "$tabela2->c1tb2"; ?>
                    </td>
                    <td id="tdc1tb2">
                       
                        <? if ($tabela2->c1tb2 == 'SIM'){
                           echo "10";
                           $somatb2 = $somatb2 + 10;
                       }                     
                       ?>
                       
                    </td>
                </tr>    
                <tr>
                    <td>
                        IAM > 6 M  
                    </td>
                    <td>
                        <? echo "$tabela2->c2tb2"; ?>
                    </td>
                    <td id="tdc2tb2">
                        <? if ($tabela2->c2tb2 == 'SIM'){
                           echo "5";
                           $somatb2 = $somatb2 + 5;
                       }                     
                       ?>
                    </td>
                </tr>    
                <tr>
                    <td>
                        ANGINA CLASSE III 
                    </td>
                    <td>
                        <? echo "$tabela2->c3tb2"; ?>
                    </td>
                    <td id="tdc3tb2">
                        <? if ($tabela2->c3tb2 == 'SIM'){
                           echo "10";
                           $somatb2 = $somatb2 + 10;
                       }                     
                       ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        ANGINA CLASSE IV   
                    </td>
                    <td>
                        <? echo "$tabela2->c4tb2"; ?>
                    </td>
                    <td id="tdc4tb2">
                        <? if ($tabela2->c4tb2 == 'SIM'){
                           echo "20";
                           $somatb2 = $somatb2 + 20;
                       }                     
                       ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        EAP HÁ UMA SEMANA  
                    </td>
                    <td>
                        <? echo "$tabela2->c5tb2"; ?>
                    </td>
                    <td id="tdc5tb2">
                        <? if ($tabela2->c5tb2 == 'SIM'){
                           echo "10";
                           $somatb2 = $somatb2 + 10;
                       }                     
                       ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        EAP QUALQUER TEMPO  
                    </td>
                    <td>
                        <? echo "$tabela2->c6tb2"; ?>
                    </td>
                    <td id="tdc6tb2">
                        <? if ($tabela2->c6tb2 == 'SIM'){
                           echo "5";
                           $somatb2 = $somatb2 + 5;
                       }                     
                       ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        SUSPEITA DE EAO CRÍTICA
                    </td>
                    <td>
                        <? echo "$tabela2->c7tb2"; ?>
                    </td>
                    <td id="tdc7tb2">
                        <? if ($tabela2->c7tb2 == 'SIM'){
                           echo "20";
                           $somatb2 = $somatb2 + 20;
                       }                     
                       ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        RITMO NÃO SINUSAL OU ESSV NO ECG   
                    </td>
                    <td>
                        <? echo "$tabela2->c8tb2"; ?>
                    </td>
                    <td id="tdc8tb2">
                        <? if ($tabela2->c8tb2 == 'SIM'){
                           echo "5";
                           $somatb2 = $somatb2 + 5;
                       }                     
                       ?>
                    </td>
                </tr>    
                <tr>
                    <td>
                        > 5 ESV NO ECG   
                    </td>
                    <td>
                        <? echo "$tabela2->c9tb2"; ?>
                    </td>
                    <td id="tdc9tb2">
                        <? if ($tabela2->c9tb2 == 'SIM'){
                           echo "5";
                           $somatb2 = $somatb2 + 5;
                       }                     
                       ?>
                    </td>
                </tr>    
                <tr>
                    <td>
                        PO2< 60, PCO2> 50, K<3, U> 50, C> 3,0,RESTRITO AO LEITO  
                    </td>
                    <td>
                        <? echo "$tabela2->c10tb2"; ?>
                    </td>
                    <td id="tdc10tb2">
                        <? if ($tabela2->c10tb2 == 'SIM'){
                           echo "5";
                           $somatb2 = $somatb2 + 5;
                       }                     
                       ?>
                    </td>
                </tr>    
                <tr>
                    <td>
                        IDADE > 70 ANOS  
                    </td>
                    <td>
                        <? echo "$tabela2->c11tb2"; ?>
                    </td>
                    <td id="tdc11tb2">
                        <? if ($tabela2->c11tb2 == 'SIM'){
                           echo "5";
                           $somatb2 = $somatb2 + 5;
                       }                     
                       ?>
                    </td>
                </tr>    
                <tr>
                    <td>
                        CIRURGIA DE EMERGÊNCIA  
                    </td>
                    <td>
                        <? echo "$tabela2->c12tb2"; ?>
                    </td>
                    <td id="tdc12tb2">
                        <? if ($tabela2->c12tb2 == 'SIM'){
                           echo "10";
                           $somatb2 = $somatb2 + 10;
                       }                     
                       ?>
                    </td>
                </tr>    
            </table>
        </div>
        <br><br><br>
        <div>

            <table position="relative" float ="left" align="center" border="1" width = "500">
                <h4 align = "center">VARIÁVEIS</h4>

                <tr>
                    <td style="width:250;">≥ 20 PONTOS</td>
                    <td style="width:250;">0 – 15 PONTOS</td>
                </tr>
                <tr>
                    <td style="width:250;">ALTO RISCO</td>
                    <td style="width:250;">AVALIAR TABELA 3</td>
                </tr>
            </table>
        </div>
        <div>

            <table align="center" border="1" width = "500">
                <h4 align = "center">RESULTADO</h4>                            
                <tr>
                    <td id="tdresultado" style="width:250;">
                       <? echo "$somatb2"; ?>
                    </td>
                    <td id="tdresult" style="width:250;">
                        <?
                        if ($somatb2 >= 20) {
                            echo "ALTO RISCO";
                        } else {
                            echo "AVALIAR TABELA 3";
                        }
                        ?>
                    </td>
                </tr>

            </table><br><br><br>
        </div>

        <?
        $tabela3 = json_decode(@$avaliacao[0]->avaliacao_tabela3);
        ?>
        <table width = "900" border = "1" align = "center">
            <h4 align = "center">TABELA 3: VARIÁVEIS DE RISCO</h4>
            <tr>
                <td>
                    > 70 ANOS  
                </td>
                <td>
                    <? echo "$tabela3->c1tb3"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    HISTÓRIA DE ANGINA  
                </td>
                <td>
                    <? echo "$tabela3->c2tb3"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    DIABETES  
                </td>
                <td>
                    <? echo "$tabela3->c3tb3"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    ONDAS Q NO ECG  
                </td>
                <td>
                    <? echo "$tabela3->c4tb3"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    HISTÓRIA DE ICC  
                </td>
                <td>
                    <? echo "$tabela3->c5tb3"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    HISTÓRIA DE IAM  
                </td>
                <td>
                    <? echo "$tabela3->c6tb3"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    ALT. ISQUÊMICAS DO ST  
                </td>
                <td>
                    <? echo "$tabela3->c7tb3"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    HAS COM HVE IMPORTANTE  
                </td>
                <td>
                    <? echo "$tabela3->c8tb3"; ?>
                </td>
            </tr>


        </table>
        <br><br><br>

        <?
        $tabela4 = json_decode(@$avaliacao[0]->avaliacao_tabela4);
        ?>

        <h4 align = "center">TABELA 4: RISCO CARDÍACO PARA PROCEDIMENTOS NÃO CARDÍACOS</h4>
        <table align = "center">
            <tr> 
                <td>
                    <table border="1">
                        <td>
                            <table width = "200">
                                <tr>
                                    <th><font color = red><br><br>ALTO RISCO<br><br></font></th>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width = "500">
                                <tr>
                                    <td>a) Cirurgias vasculares</td>
                                </tr>
                                <tr>
                                    <td>b) Cirurgias de urgência ou emergência</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width = "200">
                                <tr>
                                    <th><font color = black><br><br>Risco  ≥ 5,0%<br><br></font></th>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width = "100">
                                <tr>
                                    <th><? echo "$tabela4->riscoalto"; ?></th>
                                </tr>
                            </table>
                        </td>
                    </table>
                    <table border="1">
                        <td>
                            <table width = "200">
                                <tr>
                                    <th><font color = orange><br><br><br>RISCO INTERMEDIÁRIO<br><br><br></font></th>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width = "500">
                                <tr>   
                                    <td>a) Endarterectomia carotídea e correção endovascular de AAA</td>
                                </tr>
                                <tr>
                                    <td>b) Cirurgia de cabeça e pescoço</td>
                                </tr>
                                <tr>
                                    <td>c) cirurgias intraperitoneais e intratorácicas</td>
                                </tr>
                                <tr>
                                    <td>d) Cirurgias ortopédicas</td>
                                </tr>
                                <tr>
                                    <td>e) Cirurgias prostáticas</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width = "200">
                                <tr>
                                    <th><font color = black><br><br><br>Risco ≥ 1,0% < 5,0%<br><br><br></font></th>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width = "100">
                                <tr>
                                    <th><? echo "$tabela4->riscomedio"; ?></th>
                                </tr>
                            </table>
                        </td>
                    </table>        
                    <table border="1">
                        <td>
                            <table width = "200">
                                <tr>
                                    <th><font color = green><br><br><br>BAIXO RISCO<br><br><br><br></font></th>
                                </tr>                                                             
                            </table>
                        </td>
                        <td>
                            <table width = "500">

                                <tr>
                                    <td>a) Procedimentos endoscópicos</td>
                                </tr>
                                <tr>
                                    <td>b) Procedimentos superficiais</td>
                                </tr>
                                <tr>
                                    <td>c) Cirurgia de catarata</td>
                                </tr>
                                <tr>
                                    <td>d) Cirurgia de mama</td>
                                </tr>
                                <tr>
                                    <td>e) Cirurgia ambulatorial</td>
                                </tr>                           
                            </table>
                        </td>
                        <td>
                            <table width = "200">
                                <tr>
                                    <th><font color = black><br><br><br>Risco < 1,0%<br><br><br><br></font></th>
                                </tr>                                                             
                            </table>
                        </td>
                        <td>
                            <table width = "100">
                                <tr>
                                    <th><? echo "$tabela4->riscobaixo"; ?></th>
                                </tr>
                            </table>
                        </td>
                    </table>
            </tr>    

        </table><br><br><br>

        <table align="center" border="1" width = "500">
            <h3 align = "center">CONCLUSÕES</h3>

            <tr>
                <th style="width:250;">RISCO AGREGADO</th>
                <td style="width:250;"></td>
            </tr>
            <tr>
                <th style="width:250;">RISCO DO PACIENTE</th>
                <td style="width:250;"></td>
            </tr>
            <tr>
                <th style="width:250;">RISCO DO PROCEDIMENTO</th>
                <td style="width:250;">
                   <?
                        if ($tabela4->riscoalto == 'SIM') {
                            echo "ALTO RISCO";
                        } else {
                            if ($tabela4->riscomedio == 'SIM'){
                            echo "RISCO INTERMEDIÁRIO";
                            } else {
                                if ($tabela4->riscobaixo == 'SIM'){
                                    echo "BAIXO RISCO";
                                }
                                
                            }
                        }
                        ?> 
                </td>
            </tr>
        </table><br><br><br>


    </fieldset>

</div>

