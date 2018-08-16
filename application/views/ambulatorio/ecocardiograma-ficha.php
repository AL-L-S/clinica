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
                    <table align = "center"  width="500px">
                        <tr>                            
                            <td><h1 align = "center">Ecocardiograma</h1></td>                            
                         
                        
                            <td>
                               <button type="button" name="btnconsultaeco"onclick="javascript:window.open('<?= base_url() ?><?= $ambulatorio_laudo_id ?>');" >
                                    Consulta ECO
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
                                        Diametro diast VE
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diastve"  value ="<?= @$obj->diastve; ?>" id ="txtDiastve">
                                    <input type="text" id="txtdiastve" name="diastve" class="texto3"  value="<?= @$obj->diastve; ?>" />
                                    </td>
                                    <td>
                                        35 a 56 mm
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Diametro sist VE
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sistve"  value ="<?= @$obj->sistve; ?>" id ="txtSistve">
                                    <input type="text" id="txtsistve" name="sistve" class="texto3"  value="<?= @$obj->sistve; ?>" />
                                    </td>
                                    <td>
                                        26 a 39 mm
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Esp diast septo IV
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="septoiv"  value ="<?= @$obj->septoiv; ?>" id ="txtSeptoiv">
                                    <input type="text" id="txtseptoiv" name="septoiv" class="texto3"  value="<?= @$obj->septoiv; ?>" />
                                    </td>
                                    <td>
                                        06 a 11 mm
                                    </td>                                    
                                </tr>
                                
                                <tr>
                                    <td>
                                        Esp diast PP VE
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diastppve"  value ="<?= @$obj->diastppve; ?>" id ="txtDiastppve">
                                    <input type="text" id="txtdiastppve" name="diastppve" class="texto3"  value="<?= @$obj->diastppve; ?>" />
                                    </td>
                                    <td>
                                        06 a 11 mm
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Massa VE
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="massave"  value ="<?= @$obj->massave; ?>" id ="txtMassave">
                                    <input type="text" id="txtmassave" name="massave" class="texto3"  value="<?= @$obj->massave; ?>" />
                                    </td>
                                    <td>
                                        até 276 g
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Diametro diast VI
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="diastvi"  value ="<?= @$obj->diastvi; ?>" id ="txtDiastvi">
                                    <input type="text" id="txtdiastvi" name="diastvi" class="texto3"  value="<?= @$obj->diastvi; ?>" />
                                    </td>
                                    <td>
                                        08 a 26 mm
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Diametro sist AE
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sistae"  value ="<?= @$obj->sistae; ?>" id ="txtSistae">
                                    <input type="text" id="txtsistae" name="sistae" class="texto3"  value="<?= @$obj->sistae; ?>" />
                                    </td>
                                    <td>
                                        20 a 40 mm
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        Diametro Ao
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="ao"  value ="<?= @$obj->ao; ?>" id ="txtAo">
                                    <input type="text" id="txtao" name="ao" class="texto3"  value="<?= @$obj->ao; ?>" />
                                    </td>
                                    <td>
                                        20 a 37 mm
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        FE
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fe"  value ="<?= @$obj->fe; ?>" id ="txtFE">
                                    <input type="text" id="txtfe" name="fe" class="texto3"  value="<?= @$obj->fe; ?>" />
                                    </td>
                                    <td>
                                        53 a 77 %
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        %enc sist (AD)
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sistad"  value ="<?= @$obj->sistad; ?>" id ="txtSistad">
                                    <input type="text" id="txtsistad" name="sistad" class="texto3"  value="<?= @$obj->sistad; ?>" />
                                    </td>
                                    <td>
                                        27 a 46 %
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        VDFVE
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="vdfve"  value ="<?= @$obj->vdfve; ?>" id ="txtVdfve">
                                    <input type="text" id="txtvdfve" name="vdfve" class="texto3"  value="<?= @$obj->vdfve; ?>" />
                                    </td>
                                    <td>
                                        51 a 154 ml
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>
                                        VSFVE
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="vsfve"  value ="<?= @$obj->vsfve; ?>" id ="txtVsfve">
                                    <input type="text" id="txtvsfve" name="vsfve" class="texto3"  value="<?= @$obj->vsfve; ?>" />
                                    </td>
                                    <td>
                                        25 a 66 ml
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
                                    <input type="text" id="txtcavidades" name="cavidades" class="texto08"  value="<?= @$obj->cavidades; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Contratilidade VE:  
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="contratilidade"  value ="<?= @$obj->contratilidade; ?>" id ="txtContratilidade">
                                    <input type="text" id="txtcontratilidade" name="contratilidade" class="texto08"  value="<?= @$obj->contratilidade; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Válvulas:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="valvulas"  value ="<?= @$obj->valvulas; ?>" id ="txtValvulas">
                                    <input type="text" id="txtvalvulas" name="valvulas" class="texto08"  value="<?= @$obj->valvulas; ?>" />
                                   </td> 
                                </tr>
                               
                                <tr>
                                   <td>
                                     Aorta:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="aorta"  value ="<?= @$obj->aorta; ?>" id ="txtAorta">
                                    <input type="text" id="txtaorta" name="aorta" class="texto08"  value="<?= @$obj->aorta; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                   <td>
                                     Pericardio:   
                                   </td>                                       
                                   <td>
                                    <input type ="hidden" name ="pericardio"  value ="<?= @$obj->pericardio; ?>" id ="txtPericardio">
                                    <input type="text" id="txtpericardio" name="pericardio" class="texto08"  value="<?= @$obj->pericardio; ?>" />
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
                        </td>
                    </table>                   
                    
                </fieldset>
                <br>
                    <table align="center">
                        <td><button type="submit" name="btnEnviar">Salvar</button></td>
                        <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoecocardio/<?= $ambulatorio_laudo_id ?>');">

                                Imprimir
                            </button>
                        </td>
                    </table>
            </div>
        </form>
    </div>
</div>





