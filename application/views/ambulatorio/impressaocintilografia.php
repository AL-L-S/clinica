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
        <form name="holter_laudo" id="holter_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarcintilografia/<?= $ambulatorio_laudo_id ?>" method="post">
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
                            <td><h1 align = "center">CINTILOGRAFIA</h1></td>                            
                         
                        
                            
                        </tr>
                    </table>
                </fieldset>
                
                <? 

                    $cintil = json_decode(@$cintil[0]->cintil);
                    
                ?>
                
                <fieldset>
                    
                            <table align="center" width="600px" height="450px">
                                <tr>
                                    <td>
                                        Tipo:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="tipo"  value ="<?= @$obj->tipo; ?>" id ="txtTipo">
                                    <? echo "$cintil->tipo"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        SSS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sss"  value ="<?= @$obj->sss; ?>" id ="txtSSS">
                                    <? echo "$cintil->sss"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        FE:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fe"  value ="<?= @$obj->fe; ?>" id ="txtFE">
                                    <? echo "$cintil->fe"; ?>
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        Área de Fibrose:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="afibrose"  value ="<?= @$obj->afibrose; ?>" id ="txtAfibrose">
                                    <? echo "$cintil->afibrose"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Área de Isquemia:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="aisquemia"  value ="<?= @$obj->aisquemia; ?>" id ="txtAisquemia">
                                    <? echo "$cintil->aisquemia"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Disfunção:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="disfuncao"  value ="<?= @$obj->disfuncao; ?>" id ="txtDisfuncao">
                                    <? echo "$cintil->disfuncao"; ?>
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        Teste Ergométrico:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="tergometrico"  value ="<?= @$obj->tergometrico; ?>" id ="txtTergometrico">
                                    <? echo "$cintil->tergometrico"; ?>
                                    </td>
                                                                        
                                </tr>
                               
                               <tr>
                                   <td>
                                     Outros achados:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="outrosachados"  value ="<?= @$obj->outrosachados; ?>" id ="txtOutrosachados">
                                    <? echo "$cintil->outrosachados"; ?>
                                   </td> 
                                </tr>
                                                               
                            
                        
                    </table>                   
                    
                </fieldset>
                <br>
                   
            </div>
        </form>
    </div>
</div>





