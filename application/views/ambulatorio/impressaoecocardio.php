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
        <form name="eco_laudo" id="eco_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarecocardio/<?= $ambulatorio_laudo_id ?>" method="post">
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
                            <td><h1 align = "center">Ecocardiograma</h1></td>                            
                        </tr>                        
                    </table>
                </fieldset>
                
                <? 
                    $ecocardio = json_decode(@$ecocardio[0]->ecocardio);                   
                ?>
                
                <fieldset>
                    <table align="center">
                        <td>
                            <table width="600px">
                                <tr>
                                    <td>
                                        Diametro diast VE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diastve"  value ="<?= @$obj->diastve; ?>" id ="txtDiastve">
                                    <? echo "$ecocardio->diastve"; ?>
                                    </td>
                                    <td>
                                        (35 a 56 mm)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Diametro sist VE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sistve"  value ="<?= @$obj->sistve; ?>" id ="txtSistve">
                                    <? echo "$ecocardio->sistve"; ?>
                                    </td>
                                    <td>
                                        (26 a 39 mm)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Esp diast septo IV:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="septoiv"  value ="<?= @$obj->septoiv; ?>" id ="txtSeptoiv">
                                    <? echo "$ecocardio->septoiv"; ?>
                                    </td>
                                    <td>
                                        (06 a 11 mm)
                                    </td>                                    
                                </tr>
                                
                                <tr>
                                    <td>
                                        Esp diast PP VE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diastppve"  value ="<?= @$obj->diastppve; ?>" id ="txtDiastppve">
                                    <? echo "$ecocardio->diastppve"; ?>
                                    </td>
                                    <td>
                                        (06 a 11 mm)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Massa VE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="massave"  value ="<?= @$obj->massave; ?>" id ="txtMassave">
                                    <? echo "$ecocardio->massave"; ?>
                                    </td>
                                    <td>
                                        (até 276 g)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Diametro diast VI:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diastvi"  value ="<?= @$obj->diastvi; ?>" id ="txtDiastvi">
                                    <? echo "$ecocardio->diastvi"; ?>
                                    </td>
                                    <td>
                                        (08 a 26 mm)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Diametro sist AE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sistae"  value ="<?= @$obj->sistae; ?>" id ="txtSistae">
                                    <? echo "$ecocardio->sistae"; ?>
                                    </td>
                                    <td>
                                        (20 a 40 mm)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Diametro Ao:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="ao"  value ="<?= @$obj->ao; ?>" id ="txtAo">
                                    <? echo "$ecocardio->ao"; ?>
                                    </td>
                                    <td>
                                        (20 a 37 mm)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        FE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fe"  value ="<?= @$obj->fe; ?>" id ="txtFE">
                                    <? echo "$ecocardio->fe"; ?>
                                    </td>
                                    <td>
                                        (53 a 77 %)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        %enc sist (AD):
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sistad"  value ="<?= @$obj->sistad; ?>" id ="txtSistad">
                                    <? echo "$ecocardio->sistad"; ?>
                                    </td>
                                    <td>
                                        (27 a 46 %)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        VDFVE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="vdfve"  value ="<?= @$obj->vdfve; ?>" id ="txtVdfve">
                                    <? echo "$ecocardio->vdfve"; ?>
                                    </td>
                                    <td>
                                        (51 a 154 ml)
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        VSFVE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="vsfve"  value ="<?= @$obj->vsfve; ?>" id ="txtVsfve">
                                    <? echo "$ecocardio->vsfve"; ?>
                                    </td>
                                    <td>
                                        (25 a 66 ml)
                                    </td>                                    
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width="600px" height="450px">
                                <tr>
                                   <td>
                                     Cavidades:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="cavidades"  value ="<?= @$obj->cavidades; ?>" id ="txtCavidades">
                                    <? echo "$ecocardio->cavidades"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Contratilidade VE:  
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="contratilidade"  value ="<?= @$obj->contratilidade; ?>" id ="txtContratilidade">
                                    <? echo "$ecocardio->contratilidade"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Válvulas:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="valvulas"  value ="<?= @$obj->valvulas; ?>" id ="txtValvulas">
                                    <? echo "$ecocardio->valvulas"; ?>
                                   </td> 
                                </tr>
                               
                                <tr>
                                   <td>
                                     Aorta:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="aorta"  value ="<?= @$obj->aorta; ?>" id ="txtAorta">
                                    <? echo "$ecocardio->aorta"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Pericardio:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="pericardio"  value ="<?= @$obj->pericardio; ?>" id ="txtPericardio">
                                    <? echo "$ecocardio->pericardio"; ?>
                                   </td> 
                                </tr>
                               <tr>
                                   <td>
                                     Conclusão:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="conclusao"  value ="<?= @$obj->conclusao; ?>" id ="txtConclusao">
                                    <? echo "$ecocardio->conclusao"; ?>
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





