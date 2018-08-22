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
        <form name="eco_laudo" id="ecostress_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarecostress/<?= $ambulatorio_laudo_id ?>" method="post">
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
                            <td><h1 align = "center">Eco Stress</h1></td>                        
                                                
                            
                        </tr>
                    </table>
                </fieldset>
                
                <? 

                    $ecostress = json_decode(@$ecostress[0]->ecostress);
                    
                ?>
                
                <fieldset>                                        
                        
                            <table align="center" width="600px" height="300px">
                                <tr>
                                   <td>
                                     Hipocinesia Anterior:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesiaanterior"  value ="<?= @$obj->hipocinesiaanterior; ?>" id ="txtHipocinesiaanterior">
                                    <? echo "$ecostress->hipocinesiaanterior"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Hipocinesia Medial:  
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesiamedial"  value ="<?= @$obj->hipocinesiamedial; ?>" id ="txtHipocinesiamedial">
                                    <? echo "$ecostress->hipocinesiamedial"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Hipocinesia Apical:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesiaapical"  value ="<?= @$obj->hipocinesiaapical; ?>" id ="txtHipocinesiaapical">
                                    <? echo "$ecostress->hipocinesiaapical"; ?>
                                   </td> 
                                </tr>
                               
                                <tr>
                                   <td>
                                     Hipocinesia Inferior:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesiainferior"  value ="<?= @$obj->hipocinesiainferior; ?>" id ="txtHipocinesiainferior">
                                    <? echo "$ecostress->hipocinesiainferior"; ?>
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Hipocinesia Lateral:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesialateral"  value ="<?= @$obj->hipocinesialateral; ?>" id ="txtHipocinesialateral">
                                    <? echo "$ecostress->hipocinesialateral"; ?>
                                   </td> 
                                </tr>
                               <tr>
                                   <td>
                                     Disfunção:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="disfuncao"  value ="<?= @$obj->disfuncao; ?>" id ="txtDisfuncao">
                                    <? echo "$ecostress->disfuncao"; ?>
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









