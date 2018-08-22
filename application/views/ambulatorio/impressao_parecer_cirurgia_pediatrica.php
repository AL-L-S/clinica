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

        <table> 
            <tr>
                <td width="400px;">Paciente:<?= @$obj->_nome ?></td>                                                        
            </tr>

        </table>


    </fieldset>
   
        <h2 align = "center">Solicitação de Parecer para Cirurgia Pediátrica</h2>


        <?
        
        $dados = json_decode(@$parecer[0]->dados);
        $exames = json_decode(@$parecer[0]->exames);
        $examesc = json_decode(@$parecer[0]->exames_complementares);
        $hipotese_diagnostica = json_decode(@$parecer[0]->hipotese_diagnostica);
        $soma = 0;          
        ?>
        <table border = "1" align = "center"> 
            <tr>
                <th><h3 align = "center" colspan = "4">HISTÓRIA CLÍNICA</h3></th>
                <th><h3 align = "center">Resposta</h3></th>
                <th><h3 align = "center">A</h3></th>
            </tr> 
            <tr>
                <td>Anorexia</td>
                <td>                    
                   <? echo "$dados->dado1"; ?>
                </td>
                <td id="tddado1">
                    <? if ($dados->dado1 == 'SIM'){
                           echo "1";
                           $soma = $soma + 1;
                       }                     
                       ?>                                
                </td>
            </tr>
            <tr>
                <td>Náuseas e/ou Vômitos</td>
                <td>
                    <? echo "$dados->dado2"; ?>
                </td>
                <td id="tddado2">
                    <? if ($dados->dado2 == 'SIM'){
                           echo "1";
                           $soma = $soma + 1;
                       }                     
                       ?>  
                </td>
            </tr> 
            <tr>
                <td>Vômitos Não-Biliosos sugestivos de Estenose Pilórica </td>
                <td>
                    <? echo "$dados->dado3"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>Dor abdominal intensa e progressiva compatível com Isquemia Intestinal</td>
                <td>
                    <? echo "$dados->dado4"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr> 
                <td>Migração da dor para quadrante inferior D</td>
                <td>
                    <? echo "$dados->dado5"; ?>
                </td>
                <td id="tddado5">
                    <? if ($dados->dado5 == 'SIM'){
                           echo "1";
                           $soma = $soma + 1;
                       }                     
                       ?>  
                </td>
            </tr>    
            <tr>    
                <td>História de dor localizada em FID</td>
                <td>
                    <? echo "$dados->dado6"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Dor Abdominal que piora com caminhar/pular ou tossir</td>
                <td>
                    <? echo "$dados->dado7"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Dor Lombar com irradiação para abdome anterior sugestiva de Cólica Renal</td>
                <td>
                    <? echo "$dados->dado8"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Dor + Abaulamento Inguinal sugestivo de encarceramento/estrangulamento herniário</td>
                <td>
                    <? echo "$dados->dado9"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Relato de evacuações com sangue e muco ("Geléia de Morango")</td>
                <td>
                    <? echo "$dados->dado10"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Relato de evacuações com sangue em grande quantidade</td>
                <td>
                    <? echo "$dados->dado11"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Parada de eliminação de gases e fezes</td>
                <td>
                    <? echo "$dados->dado12"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>  
                <td>
                    <input type ="hidden" name ="dado13"  value ="<?= @$obj->dado13; ?>" id ="txtDado13">
                    Outros: <? echo "$dados->dado13"; ?>
                </td>
            </tr>

            <tr>
                <th><h3 align = "center" colspan = "4">EXAME FÍSICO</h3></th>
                <th><h3 align = "center">Resposta</h3></th>
            </tr> 
            <tr>
                <td>Temperatura>37, 3oC</td>
                <td>
                    <? echo "$exames->exame1"; ?>
                </td>
                <td id="tdexame1">
                    <? if ($exames->exame1 == 'SIM'){
                           echo "1";
                           $soma = $soma + 1;
                       }                     
                       ?>  
                </td>
            </tr>
            <tr>
                <td>Avaliação Pulmonar <b>NORMAL</b></td>
                <td>
                    <? echo "$exames->exame2"; ?>
                </td>
                <td>

                </td>
            </tr> 
            <tr>
                <td>Defesa em Quadrante Inferior D</td>
                <td>
                    <? echo "$exames->exame3"; ?>
                </td>
                <td id="tdexame3">
                    <? if ($exames->exame3 == 'SIM'){
                           echo "1";
                           $soma = $soma + 1;
                       }                     
                       ?>
                </td>
            </tr>
            <tr>
                <td>Sinal de Murphy Positivo</td>
                <td>
                    <? echo "$exames->exame4"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr> 
                <td>Sinal de Blumberg Positivo</td>
                <td>
                    <? echo "$exames->exame5"; ?>
                </td>
                <td id="tdexame5">
                    <? if ($exames->exame5 == 'SIM'){
                           echo "1";
                           $soma = $soma + 1;
                       }                     
                       ?>
                </td>
            </tr>    
            <tr>    
                <td>Sinal de Rovsing Positivo</td>
                <td>
                    <? echo "$exames->exame6"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Dificuldade para Deambular</td>
                <td>
                    <? echo "$exames->exame7"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Massa Palpável sugestiva de Neoplasia ou Hidronefrose</td>
                <td>
                    <? echo "$exames->exame8"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>Abaulamento Inguinal Não-Redutível</td>
                <td>
                    <? echo "$exames->exame9"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>
                    <input type ="hidden" name ="exame10"  value ="<?= @$obj->exame10; ?>" id ="txtExame10">
                    Outros: <? echo "$exames->exame10"; ?>
                </td>
            </tr>
            <tr>
                <th><h3 align = "center" colspan = "4">EXAMES COMPLEMENTARES(se houver)</h3></th>
                <th><h3 align = "center">Resposta</h3></th>
            </tr> 
            <tr>
                <td>Leucocitose > 10.000/μL</td>
                <td>
                    <? echo "$examesc->examec1"; ?>
                </td>
                <td id="tdexamec1">
                    <? if ($examesc->examec1 == 'SIM'){
                           echo "1";
                           $soma = $soma + 1;
                       }                     
                       ?>
                </td>
            </tr>
            <tr>
                <td>Leucocitose com Desvio à Esquerda (>75% de Neutrófilos)</td>
                <td>
                    <? echo "$examesc->examec2"; ?>
                </td>
                <td id="tdexamec2">
                    <? if ($examesc->examec2 == 'SIM'){
                           echo "1";
                           $soma = $soma + 1;
                       }                     
                       ?>
                </td>
            </tr> 
            <tr>
                <td>Neutrófilos > 6.750/μL</td>
                <td>
                    <? echo "$examesc->examec3"; ?>
                </td>
                <td>

                </td>
            </tr>
            <tr>    
                <td>
                    <input type ="hidden" name ="examec4"  value ="<?= @$obj->examec4; ?>" id ="txtExamec4">
                    Outros: <? echo "$examesc->examec4"; ?>
                </td>
            </tr>
        </table>
        <table border="1" align="center" width = "740">                            

            <h3 align = "center">HIPÓTESE DIAGNÓSTICA</h3>                           


            <tr>
                <td>
                    
                    <input type="checkbox" name="diagnostico1" id="diagnostico1" value="on" <? if ($hipotese_diagnostica->diagnostico1 == "on"){ ?> checked="" <? } ?> >Apendicite
                   
                </td>
                <td><input type="checkbox" name="diagnostico2" id="diagnostico2" value="on" <? if ($hipotese_diagnostica->diagnostico2 == "on"){ ?> checked="" <? } ?> >Invaginação Intestinal</td>
                <td><input type="checkbox" name="diagnostico3" id="diagnostico3" value="on" <? if ($hipotese_diagnostica->diagnostico3 == "on"){ ?> checked="" <? } ?> >Brida Pós-Operatória</td>                            
            </tr>
            <tr>
                <td><input type="checkbox" name="diagnostico4" id="diagnostico4" value="on" <? if ($hipotese_diagnostica->diagnostico4 == "on"){ ?> checked="" <? } ?> >Torção Ovariana</td>
                <td><input type="checkbox" name="diagnostico5" id="diagnostico5" value="on" <? if ($hipotese_diagnostica->diagnostico5 == "on"){ ?> checked="" <? } ?> >Estenose Pilórica</td>
                <td><input type="checkbox" name="diagnostico6" id="diagnostico6" value="on" <? if ($hipotese_diagnostica->diagnostico6 == "on"){ ?> checked="" <? } ?> >Colecistite Aguda</td>                            
            </tr>
            <tr>
                <td><input type="checkbox" name="diagnostico7" id="diagnostico7" value="on" <? if ($hipotese_diagnostica->diagnostico7 == "on"){ ?> checked="" <? } ?> >Pancreatite Aguda</td>
                <td><input type="checkbox" name="diagnostico8" id="diagnostico8" value="on" <? if ($hipotese_diagnostica->diagnostico8 == "on"){ ?> checked="" <? } ?> >Litíase Renal</td>                                                        
            </tr>
            <tr>
                <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" <? if ($hipotese_diagnostica->diagnostico9 == "on"){ ?> checked="" <? } ?> >Divert. Meckel Sangrante</td>
                <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on" <? if ($hipotese_diagnostica->diagnostico10 == "on"){ ?> checked="" <? } ?> >Hérnia Inguinal Encarcerda/Estrangulada</td>
            </tr>    
        </table>

        <br><br>
        <fieldset>
            <legend style="color:red">OBSERVAÇÕES EM SUSPEITA DE APENDICITE</legend>
            <h4 align = "center">HISTÓRICO DE USO DE ANTIBIÓTICO PRÉVIO A CONFUNDIR AVALIAÇÃO CLÍNICA: <input type="checkbox" name="sim" value="sim" <? if (@$parecer[0]->antibiotico == "sim"){ ?> checked="" <? } ?> >SIM <input type="checkbox" name="nao" value="nao" <? if (@$parecer[0]->antibiotico == "nao"){ ?> checked="" <? } ?> >NÃO</h4>
            <table>
                <th>ALVARADO(A):</th><td id="tdtotal"><? echo "$soma"; ?></td>
                <td id="tdresult"><?
                        if ($soma < 4) {
                            echo "BAIXO RISCO (Condulta clínica e, em casos selecionados, avaliação cirurgica)";
                        } 
                        if($soma >= 4 && $soma <= 7){
                            echo "RISCO INTERMEDIÁRIO (US + Avaliação do Cirurgião)";
                        } else{
                            echo "ALTO RISCO DE APENDICITE (Avaliação do Cirurgião)";
                        }
                        ?>
                </td>
            </table>
        </fieldset>
        <br><br><br>

                                     
</div>



