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
        <form name="holter_laudo" id="holter_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarholter/<?= $ambulatorio_laudo_id ?>" method="post">
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
                
                <? 

                    $holter = json_decode(@$holter[0]->holter);
                    
                ?>
                
                <fieldset>
                    <table align = "center"  width="500px">
                        <tr>                            
                            <td><h1 align = "center">Holter 24h</h1></td>                            
                         
                        
                            
                        </tr>
                    </table>
                </fieldset>
                
                <? 

//                    $exameslab = json_decode(@$exameslab[0]->exameslab);
                    
                ?>
                
                <fieldset>
                    <table align="center">
                        <td>
                            <table width="400px" height="450px">
                                <tr>
                                    <td>
                                        Ritmo:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="ritmo"  value ="<?= @$obj->ritmo; ?>" id ="txtRitmo">
                                    <? echo "$holter->ritmo"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        FC MAX:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fcmax"  value ="<?= @$obj->fcmax; ?>" id ="txtFCmax">
                                    <? echo "$holter->fcmax"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        FC MIN:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fcmin"  value ="<?= @$obj->fcmin; ?>" id ="txtFCmin">
                                    <? echo "$holter->fcmin"; ?>
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        FC MED:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fcmed"  value ="<?= @$obj->fcmed; ?>" id ="txtFCmed">
                                    <? echo "$holter->fcmed"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        ESSV:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="essv"  value ="<?= @$obj->essv; ?>" id ="txtEssv">
                                    <? echo "$holter->essv"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        ESV:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="esv"  value ="<?= @$obj->esv; ?>" id ="txtEsv">
                                    <? echo "$holter->esv"; ?>
                                    </td>
                                                                        
                                </tr>
                                                               
                            </table>
                        </td>
                        <td>
                            <table width="400px" height="450px">
                                <tr>
                                    <td>
                                        TAQUIARRITMIAS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="taquiarritmias"  value ="<?= @$obj->taquiarritmias; ?>" id ="txtTaquiarritmias">
                                    <? echo "$holter->taquiarritmias"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        BRADIARRITMIAS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="bradiarritmias"  value ="<?= @$obj->bradiarritmias; ?>" id ="txtBradiarritmias">
                                    <? echo "$holter->bradiarritmias"; ?>
                                    </td>
                                                                       
                                </tr>
                                <tr>
                                    <td>
                                        SINTOMAS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sintomas"  value ="<?= @$obj->sintomas; ?>" id ="txtSintomas">
                                    <? echo "$holter->sintomas"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PAUSAS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="pausas"  value ="<?= @$obj->pausas; ?>" id ="txtPausas">
                                    <? echo "$holter->pausas"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Alt Repol Ventricular:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="arventricular"  value ="<?= @$obj->arventricular; ?>" id ="txtArventricular">
                                    <? echo "$holter->arventricular"; ?>
                                    </td>                                                                      
                                </tr> 
                               <tr>
                                   <td>
                                     Conclusão:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="conclusao"  value ="<?= @$obj->conclusao; ?>" id ="txtConclusao">
                                    <? echo "$holter->conclusao"; ?>
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





