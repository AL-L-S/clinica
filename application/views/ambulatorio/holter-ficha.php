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
        <form name="holter_laudo" id="holter_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarholter/<?= $ambulatorio_laudo_id ?>" method="post">
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
                            <td><h1 align = "center">Holter 24h</h1></td>                            
                         
                        
                            <td>
                               <button type="button" name="btnconsultacate"onclick="javascript:window.open('<?= base_url() ?><?= $ambulatorio_laudo_id ?>');" >
                                    Consulta Holter
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
                            <table width="600px" height="450px">
                                <tr>
                                    <td>
                                        Ritmo:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="ritmo"  value ="<?= @$obj->ritmo; ?>" id ="txtRitmo">
                                    <input type="text" id="txtritmo" name="ritmo" class="texto3"  value="<?= @$obj->ritmo; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        FC MAX:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fcmax"  value ="<?= @$obj->fcmax; ?>" id ="txtFCmax">
                                    <input type="text" id="txtfcmax" name="fcmax" class="texto3"  value="<?= @$obj->fcmax; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        FC MIN:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fcmin"  value ="<?= @$obj->fcmin; ?>" id ="txtFCmin">
                                    <input type="text" id="txtfcmin" name="fcmin" class="texto3"  value="<?= @$obj->fcmin; ?>" />
                                    </td>
                                                                        
                                </tr>
                                
                                <tr>
                                    <td>
                                        FC MED:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="fcmed"  value ="<?= @$obj->fcmed; ?>" id ="txtFCmed">
                                    <input type="text" id="txtfcmed" name="fcmed" class="texto3"  value="<?= @$obj->fcmed; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        ESSV:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="essv"  value ="<?= @$obj->essv; ?>" id ="txtEssv">
                                    <input type="text" id="txtessv" name="essv" class="texto3"  value="<?= @$obj->essv; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        ESV:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="esv"  value ="<?= @$obj->esv; ?>" id ="txtEsv">
                                    <input type="text" id="txtesv" name="esv" class="texto3"  value="<?= @$obj->esv; ?>" />
                                    </td>
                                                                        
                                </tr>
                                                               
                            </table>
                        </td>
                        <td>
                            <table width="600px" height="450px">
                                <tr>
                                    <td>
                                        TAQUIARRITMIAS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="taquiarritmias"  value ="<?= @$obj->taquiarritmias; ?>" id ="txtTaquiarritmias">
                                    <input type="text" id="txttaquiarritmias" name="taquiarritmias" class="texto3"  value="<?= @$obj->taquiarritmias; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        BRADIARRITMIAS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="bradiarritmias"  value ="<?= @$obj->bradiarritmias; ?>" id ="txtBradiarritmias">
                                    <input type="text" id="txtbradiarritmias" name="bradiarritmias" class="texto3"  value="<?= @$obj->bradiarritmias; ?>" />
                                    </td>
                                                                       
                                </tr>
                                <tr>
                                    <td>
                                        SINTOMAS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="sintomas"  value ="<?= @$obj->sintomas; ?>" id ="txtSintomas">
                                    <input type="text" id="txtsintomas" name="sintomas" class="texto3"  value="<?= @$obj->sintomas; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        PAUSAS:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="pausas"  value ="<?= @$obj->pausas; ?>" id ="txtPausas">
                                    <input type="text" id="txtpausas" name="pausas" class="texto3"  value="<?= @$obj->pausas; ?>" />
                                    </td>
                                                                        
                                </tr>
                                <tr>
                                    <td>
                                        Alt Repol Ventricular:
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="arventricular"  value ="<?= @$obj->arventricular; ?>" id ="txtArventricular">
                                    <input type="text" id="txtarventricular" name="arventricular" class="texto3"  value="<?= @$obj->arventricular; ?>" />
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
                        <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoholter/<?= $ambulatorio_laudo_id ?>');">

                                Imprimir
                            </button>
                        </td>
                    </table>
            </div>
        </form>
    </div>
</div>





