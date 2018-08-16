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
        <form name="exameslab_laudo" id="exameslab_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarexameslab/<?= $ambulatorio_laudo_id ?>" method="post">
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
                            <td><h1 align = "center">Exames Laboratoriais</h1></td>                            
                        </tr>                        
                    </table>
                </fieldset>
                
                <? 

                    $exameslab = json_decode(@$exameslab[0]->exameslab);
                    
                ?>
                
                <fieldset>
                    <table align="center">
                        <td>
                            <table width="800px">
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="ct"  value ="<?= @$obj->ct; ?>" id ="txtCT">
                                       CT: <input type="text" id="txtct" name="ct" class="texto3"  value="<?= @$obj->ct; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="hdl"  value ="<?= @$obj->hdl; ?>" id ="txtHDL">
                                       HDL: <input type="text" id="txthdl" name="hdl" class="texto3"  value="<?= @$obj->hdl; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="tg"  value ="<?= @$obj->tg; ?>" id ="txtTG">
                                       TG: <input type="text" id="txttg" name="tg" class="texto3"  value="<?= @$obj->tg; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                    <input type ="hidden" name ="ldl"  value ="<?= @$obj->ldl; ?>" id ="txtLDL">
                                    <b>LDL:</b> <input type="text" id="txtldl" name="ldl" class="texto3"  value="<?= @$obj->ldl; ?>" />
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type ="hidden" name ="cthdl"  value ="<?= @$obj->cthdl; ?>" id ="txtCthdl">
                                        CT/HDL: <b>< 5</b><input type="text" id="txtcthdl" name="cthdl" class="texto3"  value="<?= @$obj->cthdl; ?>" />
                                    </td>
                                    <td>
                                    
                                    </td>
                                    <td>
                                        <input type ="hidden" name ="ldlhdl"  value ="<?= @$obj->ldlhdl; ?>" id ="txtLDLHDL">
                                        LDL/HDL: <b>< 3</b> <input type="text" id="txtldlhdl" name="ldlhdl" class="texto3"  value="<?= @$obj->ldlhdl; ?>" /> 
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="glicose"  value ="<?= @$obj->glicose; ?>" id ="txtGlicose">
                                       Glicose: <input type="text" id="txtglicose" name="glicose" class="texto3"  value="<?= @$obj->glicose; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="glpp"  value ="<?= @$obj->glpp; ?>" id ="txtGLPP">
                                       GL PP: <input type="text" id="txtglpp" name="glpp" class="texto3"  value="<?= @$obj->glpp; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="hemoglic"  value ="<?= @$obj->hemoglic; ?>" id ="txtHemoglic">
                                       Hemo Glic: <input type="text" id="txthemoglic" name="hemoglic" class="texto3"  value="<?= @$obj->hemoglic; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="ureia"  value ="<?= @$obj->ureia; ?>" id ="txtUreia">
                                       Ureia: <input type="text" id="txtureia" name="ureia" class="texto3"  value="<?= @$obj->ureia; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="creatina"  value ="<?= @$obj->creatina; ?>" id ="txtCreatina">
                                       Creatina: <input type="text" id="txtcreatina" name="creatina" class="texto3"  value="<?= @$obj->creatina; ?>" />
                                    </td>
                                    <td>
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="hb"  value ="<?= @$obj->hb; ?>" id ="txtHb">
                                       Hb: <input type="text" id="txthb" name="hb" class="texto3"  value="<?= @$obj->hb; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="ht"  value ="<?= @$obj->ht; ?>" id ="txtHt">
                                       Ht: <input type="text" id="txtht" name="ht" class="texto3"  value="<?= @$obj->ht; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="leucocitos"  value ="<?= @$obj->leucocitos; ?>" id ="txtLeucocitos">
                                       Leucócitos: <input type="text" id="txtleucocitos" name="leucocitos" class="texto3"  value="<?= @$obj->leucocitos; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <input type ="hidden" name ="t3"  value ="<?= @$obj->t3; ?>" id ="txtT3">
                                       T3: <input type="text" id="txtt3" name="t3" class="texto3"  value="<?= @$obj->t3; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="t4"  value ="<?= @$obj->t4; ?>" id ="txtT4">
                                       T4: <input type="text" id="txtt4" name="t4" class="texto3"  value="<?= @$obj->t4; ?>" />
                                    </td>
                                    <td>
                                    <input type ="hidden" name ="tsh"  value ="<?= @$obj->tsh; ?>" id ="txtTsh">
                                       TSH: <input type="text" id="txttsh" name="tsh" class="texto3"  value="<?= @$obj->tsh; ?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width="300px">
                                <tr>
                                   <td>
                                    <input type ="hidden" name ="tapinr"  value ="<?= @$obj->tapinr; ?>" id ="txtTAPINR">
                                     TAP-INR: <input type="text" id="txttapinr" name="tapinr" class="texto3"  value="<?= @$obj->tapinr; ?>" />
                                   </td> 
                                </tr>
                                <tr>
                                  <td>
                                    <input type ="hidden" name ="acurico"  value ="<?= @$obj->acurico; ?>" id ="txtACurico">
                                     Ac Urico: <input type="text" id="txtacurico" name="acurico" class="texto3"  value="<?= @$obj->acurico; ?>" />
                                  </td>  
                                </tr>
                                <tr>
                                  <td>
                                    <input type ="hidden" name ="digoxina"  value ="<?= @$obj->digoxina; ?>" id ="txtDIGOXINA">
                                     Digoxina: <input type="text" id="txtdigoxina" name="digoxina" class="texto3"  value="<?= @$obj->digoxina; ?>" />
                                  </td>  
                                </tr>
                               
                                <tr align="center">
                                   <td>
                                    <button type="button" name="btnconsultacirurgias"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                                    Consulta PG
                                    </button>
                                   </td> 
                                </tr>
                                <tr align="center">
                                  <td>
                                    <button type="button" name="btnconsultacirurgias"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                                    Consulta PL
                                    </button>
                                  </td>  
                                </tr>
                                <tr align="center">
                                  <td>
                                   <button type="button" name="btnconsultacirurgias"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                                    Relatório PG
                                   </button> 
                                  </td>  
                                </tr>
                                <tr align="center">
                                  <td>
                                   <button type="button" name="btnconsultacirurgias"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                                    Relatório PL
                                   </button> 
                                  </td>  
                                </tr>
                            </table>
                        </td>
                    </table>                   
                    
                </fieldset>
                <br>
                    <table align="center">
                        <td><button type="submit" name="btnEnviar">Salvar</button></td>
                        <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoexameslab/<?= $ambulatorio_laudo_id ?>');">

                                Imprimir
                            </button>
                        </td>
                    </table>
            </div>
        </form>
    </div>
</div>



