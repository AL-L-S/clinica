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
        <form name="cate_laudo" id="cate_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarcate/<?= $ambulatorio_laudo_id ?>" method="post">
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
                    <table align = "center"  width="800px">
                        <tr>                            
                            <td><h1 align = "center">Cateterismo Cardíaco</h1></td>                            
                         
                        
                            <td>
                               <button type="button" name="btnconsultacate"onclick="javascript:window.open('<?= base_url() ?><?= $ambulatorio_laudo_id ?>');" >
                                    Consulta CATE
                               </button>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                
                <? 

                    $cateterismo = json_decode(@$cate[0]->cate);
                    
                ?>
                
                <fieldset>
                    <table align="center">
                        <td>
                            <table width="600px" height="300px">
                                <tr>
                                    <td>
                                        DA:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="da"  value ="<?= @$obj->da; ?>" id ="txtDA">
                                    <? echo "$cateterismo->da"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        CX:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="cx"  value ="<?= @$obj->cx; ?>" id ="txtCX">
                                    <? echo "$cateterismo->cx"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        MgCX 1:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="mgcx1"  value ="<?= @$obj->mgcx1; ?>" id ="txtMgcx1">
                                    <? echo "$cateterismo->mgcx1"; ?>
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        MgCX 2:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="mgcx2"  value ="<?= @$obj->mgcx2; ?>" id ="txtMgcx2">
                                    <? echo "$cateterismo->mgcx2"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        MgCX 3:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="mgcx3"  value ="<?= @$obj->mgcx3; ?>" id ="txtMgcx3">
                                    <? echo "$cateterismo->mgcx3"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Diag:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diag"  value ="<?= @$obj->diag; ?>" id ="txtDiag">
                                    <? echo "$cateterismo->diag"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Diagonalis:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diagonalis"  value ="<?= @$obj->diagonalis; ?>" id ="txtDiagonalis">
                                    <? echo "$cateterismo->diagonalis"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        CD:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="cd"  value ="<?= @$obj->cd; ?>" id ="txtCD">
                                    <? echo "$cateterismo->cd"; ?>
                                    </td>
                                                                       
                                </tr>
                                <tr>
                                    <td>
                                        DP da CD:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="dpcd"  value ="<?= @$obj->dpcd; ?>" id ="txtDPcd">
                                    <? echo "$cateterismo->dpcd"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        VP da CD:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="vpcd"  value ="<?= @$obj->vpcd; ?>" id ="txtVPcd">
                                    <? echo "$cateterismo->vpcd"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Colaterais:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="colaterais"  value ="<?= @$obj->colaterais; ?>" id ="txtColaterais">
                                    <? echo "$cateterismo->colaterais"; ?>
                                    </td>                                                                      
                                </tr>                                
                            </table>
                        </td>
                        <td>
                            <table width="600px" height="300px">
                                <tr>
                                   <td>
                                     VE:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="ve"  value ="<?= @$obj->ve; ?>" id ="txtVE">
                                    <? echo "$cateterismo->ve"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     VM:  
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="vm"  value ="<?= @$obj->vm; ?>" id ="txtVM">
                                    <? echo "$cateterismo->vm"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     VAo:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="vao"  value ="<?= @$obj->vao; ?>" id ="txtVao">
                                    <? echo "$cateterismo->vao"; ?>
                                   </td> 
                                </tr>
                               
                                <tr>
                                   <td>
                                     VT:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="vt"  value ="<?= @$obj->vt; ?>" id ="txtVT">
                                    <? echo "$cateterismo->vt"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     VP:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="vp"  value ="<?= @$obj->vp; ?>" id ="txtVP">
                                    <? echo "$cateterismo->vp"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Circ Pulmonar:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="circpulmonar"  value ="<?= @$obj->circpulmonar; ?>" id ="txtCircpulmonar">
                                    <? echo "$cateterismo->circpulmonar"; ?>
                                   </td> 
                                </tr>
                               <tr>
                                   <td>
                                     Observações:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="observacoes"  value ="<?= @$obj->observacoes; ?>" id ="txtObservacoes">
                                    <? echo "$cateterismo->observacoes"; ?>
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







