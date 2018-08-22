<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
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
                         
                        
                            <td>
                               <button type="button" name="btnconsultaeco"onclick="javascript:window.open('<?= base_url() ?><?= $ambulatorio_laudo_id ?>');" >
                                    Consulta ECO STRESS
                               </button>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                
                <? 

//                    $exameslab = json_decode(@$exameslab[0]->exameslab);
                    
                ?>
                
                <fieldset>                                        
                        
                            <table align="center" width="600px" height="300px">
                                <tr>
                                   <td>
                                     Hipocinesia Anterior:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesiaanterior"  value ="<?= @$obj->hipocinesiaanterior; ?>" id ="txtHipocinesiaanterior">
                                    <input type="text" id="txthipocinesiaanterior" name="hipocinesiaanterior" class="texto08"  value="<?= @$obj->hipocinesiaanterior; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Hipocinesia Medial:  
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesiamedial"  value ="<?= @$obj->hipocinesiamedial; ?>" id ="txtHipocinesiamedial">
                                    <input type="text" id="txthipocinesiamedial" name="hipocinesiamedial" class="texto08"  value="<?= @$obj->hipocinesiamedial; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Hipocinesia Apical:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesiaapical"  value ="<?= @$obj->hipocinesiaapical; ?>" id ="txtHipocinesiaapical">
                                    <input type="text" id="txthipocinesiaapical" name="hipocinesiaapical" class="texto08"  value="<?= @$obj->hipocinesiaapical; ?>" />
                                   </td> 
                                </tr>
                               
                                <tr>
                                   <td>
                                     Hipocinesia Inferior:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesiainferior"  value ="<?= @$obj->hipocinesiainferior; ?>" id ="txtHipocinesiainferior">
                                    <input type="text" id="txthipocinesiainferior" name="hipocinesiainferior" class="texto08"  value="<?= @$obj->hipocinesiainferior; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Hipocinesia Lateral:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="hipocinesialateral"  value ="<?= @$obj->hipocinesialateral; ?>" id ="txtHipocinesialateral">
                                    <input type="text" id="txthipocinesialateral" name="hipocinesialateral" class="texto08"  value="<?= @$obj->hipocinesialateral; ?>" />
                                   </td> 
                                </tr>
                               <tr>
                                   <td>
                                     Disfunção:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="disfuncao"  value ="<?= @$obj->disfuncao; ?>" id ="txtDisfuncao">
                                    <input type="text" id="txtdisfuncao" name="disfuncao" class="texto08"  value="<?= @$obj->disfuncao; ?>" />
                                   </td> 
                                </tr>                               
                            </table>
                        </td>
                    </table>                   
                    
                </fieldset>
                <br>
                    <table align="center">
                        <td><button type="submit" name="btnEnviar">Salvar</button></td>
                        <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoecostress/<?= $ambulatorio_laudo_id ?>');">

                                Imprimir
                            </button>
                        </td>
                    </table>
            </div>
        </form>
    </div>
</div>







