<meta http-equiv="content-type" content="text/html;charset=utf-8" />


<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');




    if (@$empresapermissao[0]->campos_atendimentomed != '') {
        $opc_telatendimento = json_decode(@$empresapermissao[0]->campos_atendimentomed);
    } else {
        $opc_telatendimento = array();
    }
    ?>
    <?php
    $this->load->library('utilitario');
//    var_dump($this->session->flashdata('message')); die;
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>
    <div >
        <form name="exameslab_laudo" id="exameslab_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarexameslab/<?= $ambulatorio_laudo_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <input type="hidden" name="paciente_id" id="paciente_id" class="texto01"  value="<?= @$obj->_paciente_id; ?>"/>
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr>                          
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>                            
                        </tr>
                        <tr>
                            <td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                        </tr>


                        <tr>                        

                            <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
                        </tr>
                        

                    </table>


                </fieldset>
                <fieldset>
                    <table align = "center">
                        <tr>                            
                            <td><h1 align = "center">Exames Laboratoriais</h1></td>                            
                        </tr>                        
                    </table>
                </fieldset>
                
                <? 
                    $exameslab = json_decode(@$exameslab[0]->exames_laboratoriais);
//                    var_dump(@$exameslab[0]->exameslab);die;
                    
                ?>
                
                <fieldset>
                    <table align="center">
                        <td>
                            <table width="800px">
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="ct"  value ="<?= @$obj->ct; ?>" id ="txtCT">
                                       CT: <? echo "$exameslab->ct"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="hdl"  value ="<?= @$obj->hdl; ?>" id ="txtHDL">
                                       HDL: <? echo "$exameslab->hdl"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="tg"  value ="<?= @$obj->tg; ?>" id ="txtTG">
                                       TG: <? echo "$exameslab->tg"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                    <input type ="hidden" name ="ldl"  value ="<?= @$obj->ldl; ?>" id ="txtLDL">
                                    <b>LDL:</b> <? echo "$exameslab->ldl"; ?>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type ="hidden" name ="cthdl"  value ="<?= @$obj->cthdl; ?>" id ="txtCthdl">
                                        CT/HDL <b>(< 5)</b>:<? echo "$exameslab->cthdl"; ?>
                                    </td>
                                    <td>
                                    
                                    </td>
                                    <td>
                                        <input type ="hidden" name ="ldlhdl"  value ="<?= @$obj->ldlhdl; ?>" id ="txtLDLHDL">
                                        LDL/HDL <b>(< 3)</b>: <? echo "$exameslab->ldlhdl"; ?> 
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="glicose"  value ="<?= @$obj->glicose; ?>" id ="txtGlicose">
                                       Glicose: <? echo "$exameslab->glicose"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="glpp"  value ="<?= @$obj->glpp; ?>" id ="txtGLPP">
                                       GL PP: <? echo "$exameslab->glpp"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="hemoglic"  value ="<?= @$obj->hemoglic; ?>" id ="txtHemoglic">
                                       Hemo Glic: <? echo "$exameslab->hemoglic"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="ureia"  value ="<?= @$obj->ureia; ?>" id ="txtUreia">
                                       Ureia: <? echo "$exameslab->ureia"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="creatina"  value ="<?= @$obj->creatina; ?>" id ="txtCreatina">
                                       Creatina: <? echo "$exameslab->creatina"; ?>
                                    </td>
                                    <td>
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="hb"  value ="<?= @$obj->hb; ?>" id ="txtHb">
                                       Hb: <? echo "$exameslab->hb"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="ht"  value ="<?= @$obj->ht; ?>" id ="txtHt">
                                       Ht: <? echo "$exameslab->ht"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="leucocitos"  value ="<?= @$obj->leucocitos; ?>" id ="txtLeucocitos">
                                       Leucócitos: <? echo "$exameslab->leucocitos"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="t3"  value ="<?= @$obj->t3; ?>" id ="txtT3">
                                       T3: <? echo "$exameslab->t3"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="t4"  value ="<?= @$obj->t4; ?>" id ="txtT4">
                                       T4: <? echo "$exameslab->t4"; ?>
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="tsh"  value ="<?= @$obj->tsh; ?>" id ="txtTsh">
                                       TSH: <? echo "$exameslab->tsh"; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width="300px">
                                <tr>
                                   <td>
                                    <input type ="hidden" name ="tapinr"  value ="<?= @$obj->tapinr; ?>" id ="txtTAPINR">
                                     TAP-INR: <? echo "$exameslab->tapinr"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                  <td>
                                    <input type ="hidden" name ="acurico"  value ="<?= @$obj->acurico; ?>" id ="txtACurico">
                                     Ac Urico: <? echo "$exameslab->acurico"; ?>
                                  </td>  
                                </tr>
                                <tr>
                                  <td>
                                    <input type ="hidden" name ="digoxina"  value ="<?= @$obj->digoxina; ?>" id ="txtDIGOXINA">
                                     Digoxina: <? echo "$exameslab->digoxina"; ?>
                                  </td>  
                                </tr>
                                                               
                            </table>
                        </td>
                    </table>                   
                    
                </fieldset>
                <br>
                    
            </div>
        </form>
    </div>
</div>



