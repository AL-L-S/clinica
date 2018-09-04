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
        <form name="holter_laudo" id="holter_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravartergometrico/<?= $ambulatorio_laudo_id ?>" method="post">
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
                            <td><h1 align = "center">TESTE ERGOMÉTRICO</h1></td>                            
                         
                        </tr>
                    </table>
                </fieldset>
                
                <? 

                    $tergometrico = json_decode(@$tergometrico[0]->tergometrico);
                    
                ?>
                
                <fieldset>
                    
                            <table align="center" width="600px" height="450px">
                                <tr>
                                    <td>
                                        Estágio:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="estagio"  value ="<?= @$obj->estagio; ?>" id ="txtEstagio">
                                    <? echo "$tergometrico->estagio"; ?>
                                    </td>
                                    
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PA:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="pa"  value ="<?= @$obj->pa; ?>" id ="txtPa">
                                    <? echo "$tergometrico->pa"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Arritmias:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="arritmias"  value ="<?= @$obj->arritmias; ?>" id ="txtArritmias">
                                    <? echo "$tergometrico->arritmias"; ?>
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        Isquemia:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="isquemia"  value ="<?= @$obj->isquemia; ?>" id ="txtIsquemia">
                                    <? echo "$tergometrico->isquemia"; ?>
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Aptidão Física:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="aptidaofisica"  value ="<?= @$obj->aptidaofisica; ?>" id ="txtAptidaofisica">
                                    <? echo "$tergometrico->aptidaofisica"; ?>
                                    </td>
                                                                        
                                </tr>
                                
                               <tr>
                                   <td>
                                     Conclusão:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="conclusao"  value ="<?= @$obj->conclusao; ?>" id ="txtConclusao">
                                    <? echo "$tergometrico->conclusao"; ?>
                                   </td> 
                                </tr>
                                                               
                            
                        
                    </table>                   
                    
                </fieldset>
                <br>
                   
            </div>
        </form>
    </div>
</div>







