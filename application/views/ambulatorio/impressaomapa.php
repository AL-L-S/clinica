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
        <form name="holter_laudo" id="holter_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarmapa/<?= $ambulatorio_laudo_id ?>" method="post">
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
                    <table align = "center"  width="500px">
                        <tr>                            
                            <td><h1 align = "center">MAPA</h1></td>                            
                         
                        </tr>
                    </table>
                </fieldset>
                
                <? 

                    $mapa = json_decode(@$mapa[0]->mapa);
                    
                ?>
                
                <fieldset>
                    
                            <table align="center" width="600px" height="450px">
                                <tr>
                                    <td>
                                        Medidas:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="medidas"  value ="<?= @$obj->medidas; ?>" id ="txtMedidas">
                                    <? echo "$mapa->medidas"; ?>&nbsp;%&nbsp;&nbsp;
                                    </td>
                                    
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PAS Vigília:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="pasvigilia"  value ="<?= @$obj->pasvigilia; ?>" id ="txtPasvigilia">
                                    <? echo "$mapa->pasvigilia"; ?>&nbsp;%&nbsp;&nbsp;(NL < 50%)
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PAD Vigília:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="padvigilia"  value ="<?= @$obj->padvigilia; ?>" id ="txtPadvigilia">
                                    <? echo "$mapa->padvigilia"; ?>&nbsp;%&nbsp;&nbsp;(NL < 50%)
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        PAS Sono:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="passono"  value ="<?= @$obj->passono; ?>" id ="txtPassono">
                                    <? echo "$mapa->passono"; ?>&nbsp;%&nbsp;&nbsp;(NL < 50%)
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PAD Sono:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="padsono"  value ="<?= @$obj->padsono; ?>" id ="txtPadsono">
                                    <? echo "$mapa->padsono"; ?>&nbsp;%&nbsp;&nbsp;(NL < 50%)
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        <b> Descenso Sono</b>:
                                    </td>
                                    <td>
                                    
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                       - Sistólico:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sistolico"  value ="<?= @$obj->sistolico; ?>" id ="txtSistolico">
                                    <? echo "$mapa->sistolico"; ?>&nbsp;%&nbsp;&nbsp; (> 10%)
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        - Distólico:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="distolico"  value ="<?= @$obj->distolico; ?>" id ="txtDistolico">
                                    <? echo "$mapa->distolico"; ?>&nbsp;%&nbsp;&nbsp; (> 8%)
                                    </td>
                                                                        
                                </tr>
                               
                               <tr>
                                   <td>
                                     Conclusão:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="conclusao"  value ="<?= @$obj->conclusao; ?>" id ="txtConclusao">
                                    <? echo "$mapa->conclusao"; ?>
                                   </td> 
                                </tr>
                                                               
                            
                        
                    </table>                   
                    
                </fieldset>
                <br>
                    
            </div>
        </form>
    </div>
</div>





