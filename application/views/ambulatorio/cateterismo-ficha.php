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
                    <table align = "center"  width="500px">
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

//                    $exameslab = json_decode(@$exameslab[0]->exameslab);
                    
                ?>
                
                <fieldset>
                    <table align="center">
                        <td>
                            <table width="600px">
                                <tr>
                                    <td>
                                        DA:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="da"  value ="<?= @$obj->da; ?>" id ="txtDA">
                                    <input type="text" id="txtda" name="da" class="texto3"  value="<?= @$obj->da; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        CX:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="cx"  value ="<?= @$obj->cx; ?>" id ="txtCX">
                                    <input type="text" id="txtcx" name="cx" class="texto3"  value="<?= @$obj->cx; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        MgCX 1:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="mgcx1"  value ="<?= @$obj->mgcx1; ?>" id ="txtMgcx1">
                                    <input type="text" id="txtmgcx1" name="mgcx1" class="texto3"  value="<?= @$obj->mgcx1; ?>" />
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        MgCX 2:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="mgcx2"  value ="<?= @$obj->mgcx2; ?>" id ="txtMgcx2">
                                    <input type="text" id="txtmgcx2" name="mgcx2" class="texto3"  value="<?= @$obj->mgcx2; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        MgCX 3:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="mgcx3"  value ="<?= @$obj->mgcx3; ?>" id ="txtMgcx3">
                                    <input type="text" id="txtmgcx3" name="mgcx3" class="texto3"  value="<?= @$obj->mgcx3; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Diag:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diag"  value ="<?= @$obj->diag; ?>" id ="txtDiag">
                                    <input type="text" id="txtdiag" name="diag" class="texto3"  value="<?= @$obj->diag; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Diagonalis:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diagonalis"  value ="<?= @$obj->diagonalis; ?>" id ="txtDiagonalis">
                                    <input type="text" id="txtdiagonalis" name="diagonalis" class="texto3"  value="<?= @$obj->diagonalis; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        CD:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="cd"  value ="<?= @$obj->cd; ?>" id ="txtCD">
                                    <input type="text" id="txtcd" name="cd" class="texto3"  value="<?= @$obj->cd; ?>" />
                                    </td>
                                                                       
                                </tr>
                                <tr>
                                    <td>
                                        DP da CD:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="dpcd"  value ="<?= @$obj->dpcd; ?>" id ="txtDPcd">
                                    <input type="text" id="txtdpcd" name="dpcd" class="texto3"  value="<?= @$obj->dpcd; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        VP da CD:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="vpcd"  value ="<?= @$obj->vpcd; ?>" id ="txtVPcd">
                                    <input type="text" id="txtvpcd" name="vpcd" class="texto3"  value="<?= @$obj->vpcd; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Colaterais:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="colaterais"  value ="<?= @$obj->colaterais; ?>" id ="txtColaterais">
                                    <input type="text" id="txtcolaterais" name="colaterais" class="texto3"  value="<?= @$obj->colaterais; ?>" />
                                    </td>                                                                      
                                </tr>                                
                            </table>
                        </td>
                        <td>
                            <table width="600px" height="450px">
                                <tr>
                                   <td>
                                     VE:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="ve"  value ="<?= @$obj->ve; ?>" id ="txtVE">
                                    <input type="text" id="txtve" name="ve" class="texto08"  value="<?= @$obj->ve; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     VM:  
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="vm"  value ="<?= @$obj->vm; ?>" id ="txtVM">
                                    <input type="text" id="txtvm" name="vm" class="texto08"  value="<?= @$obj->vm; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     VAo:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="vao"  value ="<?= @$obj->vao; ?>" id ="txtVao">
                                    <input type="text" id="txtvao" name="vao" class="texto08"  value="<?= @$obj->vao; ?>" />
                                   </td> 
                                </tr>
                               
                                <tr>
                                   <td>
                                     VT:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="vt"  value ="<?= @$obj->vt; ?>" id ="txtVT">
                                    <input type="text" id="txtvt" name="vt" class="texto08"  value="<?= @$obj->vt; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     VP:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="vp"  value ="<?= @$obj->vp; ?>" id ="txtVP">
                                    <input type="text" id="txtvp" name="vp" class="texto08"  value="<?= @$obj->vp; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Circ Pulmonar:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="circpulmonar"  value ="<?= @$obj->circpulmonar; ?>" id ="txtCircpulmonar">
                                    <input type="text" id="txtcircpulmonar" name="circpulmonar" class="texto08"  value="<?= @$obj->circpulmonar; ?>" />
                                   </td> 
                                </tr>
                               <tr>
                                   <td>
                                     Observações:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="observacoes"  value ="<?= @$obj->observacoes; ?>" id ="txtObservacoes">
                                    <textarea type="text" id="txtobservacoes" name="observacoes" class="texto"  value="" cols="50" rows="8"><?= @$obj->observacoes; ?></textarea>
                                   </td> 
                                </tr>                               
                            </table>
                        </td>
                    </table>                   
                    
                </fieldset>
                <br>
                    <table align="center">
                        <td><button type="submit" name="btnEnviar">Salvar</button></td>
                        <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaocate/<?= $ambulatorio_laudo_id ?>');">

                                Imprimir
                            </button>
                        </td>
                    </table>
            </div>
        </form>
    </div>
</div>





