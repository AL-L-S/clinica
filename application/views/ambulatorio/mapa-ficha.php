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
                         
                        
                            <td>
                               <button type="button" name="btnconsultacintil"onclick="javascript:window.open('<?= base_url() ?><?= $ambulatorio_laudo_id ?>');" >
                                    Consulta Mapa
                               </button>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                
                <? 

//                    $exameslab = json_decode(@$exameslab[0]->exameslab);
                    
                ?>
                
                <fieldset>
                    
                            <table align="center" width="600px" height="450px">
                                <tr>
                                    <td>
                                        Medidas:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="medidas"  value ="<?= @$obj->medidas; ?>" id ="txtMedidas">
                                    <input type="text" id="txtmedidas" name="medidas" class="texto3"  value="<?= @$obj->medidas; ?>" />&nbsp;%&nbsp;&nbsp;
                                    </td>
                                    
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PAS Vigília:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="pasvigilia"  value ="<?= @$obj->pasvigilia; ?>" id ="txtPasvigilia">
                                    <input type="text" id="txtpasvigilia" name="pasvigilia" class="texto3"  value="<?= @$obj->pasvigilia; ?>" />&nbsp;%&nbsp;&nbsp;NL < 50%
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PAD Vigília:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="padvigilia"  value ="<?= @$obj->padvigilia; ?>" id ="txtPadvigilia">
                                    <input type="text" id="txtpadvigilia" name="padvigilia" class="texto3"  value="<?= @$obj->padvigilia; ?>" />&nbsp;%&nbsp;&nbsp;NL < 50%
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        PAS Sono:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="passono"  value ="<?= @$obj->passono; ?>" id ="txtPassono">
                                    <input type="text" id="txtpassono" name="passono" class="texto3"  value="<?= @$obj->passono; ?>" />&nbsp;%&nbsp;&nbsp;NL < 50%
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PAD Sono:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="padsono"  value ="<?= @$obj->padsono; ?>" id ="txtPadsono">
                                    <input type="text" id="txtpadsono" name="padsono" class="texto3"  value="<?= @$obj->padsono; ?>" />&nbsp;%&nbsp;&nbsp;NL < 50%
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
                                    <input type="text" id="txtsistolico" name="sistolico" class="texto3"  value="<?= @$obj->sistolico; ?>" />&nbsp;%&nbsp;&nbsp; > 10%
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        - Distólico:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="distolico"  value ="<?= @$obj->distolico; ?>" id ="txtDistolico">
                                    <input type="text" id="txtdistolico" name="distolico" class="texto3"  value="<?= @$obj->distolico; ?>" />&nbsp;%&nbsp;&nbsp; > 8%
                                    </td>
                                                                        
                                </tr>
                               
                               <tr>
                                   <td>
                                     Conclusão:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="conclusao"  value ="<?= @$obj->conclusao; ?>" id ="txtConclusao">
                                    <textarea type="text" id="txtconclusao" name="conclusao" class="texto"  value="" cols="50" rows="8"><?= @$obj->conclusao; ?></textarea>
                                   </td> 
                                </tr>
                                                               
                            
                        
                    </table>                   
                    
                </fieldset>
                <br>
                    <table align="center">
                        <td><button type="submit" name="btnEnviar">Salvar</button></td>
                        <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaomapa/<?= $ambulatorio_laudo_id ?>');">

                                Imprimir
                            </button>
                        </td>
                    </table>
            </div>
        </form>
    </div>
</div>





