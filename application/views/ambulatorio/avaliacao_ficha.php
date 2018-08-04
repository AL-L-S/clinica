<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>

<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/langs/pt_BR.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/plugins/spellchecker/plugin.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/themes/modern/theme.min.js"></script>


<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');

    if (isset($obj->_peso)) {
        $peso = @$obj->_peso;
    } else {
        $peso = @$laudo_peso[0]->peso;
    }
    if (isset($obj->_altura)) {
        $altura = @$obj->_altura;
    } else {
        $altura = @$laudo_peso[0]->altura;
    }


    if (@$empresapermissao[0]->campos_atendimentomed != '') {
        $opc_telatendimento = json_decode(@$empresapermissao[0]->campos_atendimentomed);
    } else {
        $opc_telatendimento = array();
    }
    ?>
      <?php
    $this->load->library('utilitario');
    Utilitario::pmf_mensagem($this->session->flashdata('message'));

    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravaravaliacao/<?= $ambulatorio_laudo_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <input type="hidden" name="paciente_id" id="paciente_id" class="texto01"  value="<?= @$obj->_paciente_id; ?>"/>
                <fieldset>
                    <h1 align = "center">AVALIAÇÃO DE RISCO CIRÚRGICO CARDIOVASCULAR</h1>
                </fieldset>
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr>
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>                            
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>

                        </tr>


                        <tr>                        
                            <td>Médico Solicitante: <?= @$obj->_operador ?></td>        
                            <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
                        </tr>

                    </table>
                </fieldset>
                <fieldset>
                    <? 
                    $tabela1 = json_decode(@$avaliacao[0]->avaliacao_tabela1);
                    ?>
                    <h2 align = "center">TABELA 1: ALGORITMO DE LEE</h2>
                    <table width = "900" border = "1" align = "center">
                        <tr>
                            <th><br><h5 align = "center">CIR. INTRAPERITONEAL VASCULAR SUPRA INGUINAL</h5></th>
                            <th><br><h5 align = "center">DAC : ONDA Q, ANGINA,  TE+, USO NITRATO</h5></th>
                            <th><br><h5 align = "center">ICC: CLÍNICA, RX C/ CONGESTÃO, ECO</h5></th>
                            <th><br><h5 align = "center">DOENÇA CEREBRO VASCULAR</h5></th>
                            <th><br><h5 align = "center">DIABETE + INSULINA</h5></th>
                            <th><br><h5 align = "center">CREATININA > 2,0</h5></th>
                        </tr> 
                        <tr>
                            <td>
                                <select name="c1tb1" id="c1tb1" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela1->c1tb1 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela1->c1tb1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                <select name="c2tb1" id="c2tb1" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela1->c2tb1 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela1->c2tb1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                <select name="c3tb1" id="c3tb1" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela1->c3tb1 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela1->c3tb1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                <select name="c4tb1" id="c4tb1" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela1->c4tb1 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela1->c4tb1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                <select name="c5tb1" id="c5tb1" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela1->c5tb1 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela1->c5tb1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                <select name="c6tb1" id="c6tb1" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela1->c6tb1 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela1->c6tb1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                        </tr>
                    </table> <br><br><br>
                    <table border = "2" align = "center">
                        <tr> 
                            <td>
                                <table border="1">
                                    <tr>
                                        <th>RISCO</th>
                                        <th>I</th>
                                        <th>II</th>
                                        <th>III</th>
                                        <th>IV</th>
                                    </tr>
                                    <tr>
                                        <th>VARIÁVEIS</th>
                                        <td>0</td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>>=3</td>
                                    </tr>
                                    <tr>
                                        <th>RISCO</th>
                                        <td>0,4</td>
                                        <td>0,9</td>
                                        <td>7</td>
                                        <td>11</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <th>RISCO</th>
                                    </tr>
                                    <tr>
                                        <td><br><br></td>
                                    </tr>


                                </table>

                            </td>
                        </tr>    
                    </table>
                    <br><br><br>

                    <? 
                    $tabela2 = json_decode(@$avaliacao[0]->avaliacao_tabela2);
                    ?>
                    <div>
                        
                    <h2 align = "center">TABELA 2: CRITÉRIOS DO AMERICAN COLLEGE OF PYISICIANS (ACP)</h2>
                    <table width = "900" border = "1" align = "center">
                        <tr>
                            <th><br><h5 align = "center"></h5>VARIÁVEL</th>
                            <th><br><h5 align = "center"></h5>RESPOSTA</th>
                            <th><br><h5 align = "center"></h5>PONTOS</th>

                        </tr> 
                        <tr>
                            <td>
                                IAM < 6 M
                            </td>
                            <td>
                                <select name="c1tb2" id="c1tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c1tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c1tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc1tb2">
                                <div id="divc1tb2">

                                </div>
                                <input type="hidden" id="inputc1tb2" value="" >
                            </td>
                        </tr>    
                        <tr>
                            <td>
                                IAM > 6 M  
                            </td>
                            <td>
                                <select name="c2tb2" id="c2tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c2tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c2tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc2tb2">
                                <div id="divc2tb2">

                                </div>
                                <input type="hidden" id="inputc2tb2" value="">
                            </td>
                        </tr>    
                        <tr>
                            <td>
                                ANGINA CLASSE III 
                            </td>
                            <td>
                                <select name="c3tb2" id="c3tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c3tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c3tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc3tb2">
                                <div id="divc3tb2">

                                </div>
                                <input type="hidden" id="inputc3tb2" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ANGINA CLASSE IV   
                            </td>
                            <td>
                                <select name="c4tb2" id="c4tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c4tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c4tb2 == 'SIM') {
                                    echo 'selected';
                                    }
                                 ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc4tb2">
                                <div id="divc4tb2">

                                </div>
                                <input type="hidden" id="inputc4tb2" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                EAP HÁ UMA SEMANA  
                            </td>
                            <td>
                                <select name="c5tb2" id="c5tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c5tb2 == 'NAO'):echo 'selected';
                                    endif;
                                            ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c5tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc5tb2">
                                <div id="divc5tb2">

                                </div> 
                                <input type="hidden" id="inputc5tb2" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                EAP QUALQUER TEMPO  
                            </td>
                            <td>
                                <select name="c6tb2" id="c6tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c6tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c6tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc6tb2">
                                <div id="divc6tb2">

                                </div>
                                <input type="hidden" id="inputc6tb2" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                SUSPEITA DE EAO CRÍTICA
                            </td>
                            <td>
                                <select name="c7tb2" id="c7tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c7tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c7tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc7tb2">
                                <div id="divc7tb2">

                                </div>
                                <input type="hidden" id="inputc7tb2" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                RITMO NÃO SINUSAL OU ESSV NO ECG   
                            </td>
                            <td>
                                <select name="c8tb2" id="c8tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                            if (@$tabela2->c8tb2 == 'NAO'):echo 'selected';
                                            endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                            if (@$tabela2->c8tb2 == 'SIM') {
                                                echo 'selected';
                                            }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc8tb2">
                                <div id="divc8tb2">

                                </div>
                                <input type="hidden" id="inputc8tb2" value="">
                            </td>
                        </tr>    
                        <tr>
                            <td>
                                > 5 ESV NO ECG   
                            </td>
                            <td>
                                <select name="c9tb2" id="c9tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c9tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c9tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc9tb2">
                                <div id="divc9tb2">

                                </div>
                                <input type="hidden" id="inputc9tb2" value="">
                            </td>
                        </tr>    
                        <tr>
                            <td>
                                PO2< 60, PCO2> 50, K<3, U> 50, C> 3,0,RESTRITO AO LEITO  
                            </td>
                            <td>
                                <select name="c10tb2" id="c10tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c10tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c10tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc10tb2">
                                <div id="divc10tb2">

                                </div>
                                <input type="hidden" id="inputc10tb2" value="">
                            </td>
                        </tr>    
                        <tr>
                            <td>
                                IDADE > 70 ANOS  
                            </td>
                            <td>
                                <select name="c11tb2" id="c11tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c11tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c11tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc11tb2">
                                <div id="divc11tb2">

                                </div>
                                <input type="hidden" id="inputc11tb2" value="">
                            </td>
                        </tr>    
                        <tr>
                            <td>
                                CIRURGIA DE EMERGÊNCIA  
                            </td>
                            <td>
                                <select name="c12tb2" id="c12tb2" class="size2 change_tb2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela2->c12tb2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela2->c12tb2 == 'SIM') {
                                        echo 'selected';
                                    }
                                    ?> >SIM</option>
                                </select>
                            </td>
                            <td id="tdc12tb2">
                                <div id="divc12tb2">

                                </div>
                                <input type="hidden" id="inputc12tb2" value="">
                            </td>
                        </tr>    
                    </table>
                    </div>
                    <br><br><br>
                    <div>
                        
                    <table position="relative" float ="left" align="center" border="1" width = "500">
                        <h3 align = "center">VARIÁVEIS</h3>

                        <tr>
                            <td style="width:250;">≥ 20 PONTOS</td>
                            <td style="width:250;">0 – 15 PONTOS</td>
                        </tr>
                        <tr>
                            <td style="width:250;">ALTO RISCO</td>
                            <td style="width:250;">AVALIAR TABELA 3</td>
                        </tr>
                    </table>
                    </div>
                    <div>
                        
                    <table align="center" border="1" width = "500">
                        <h3 align = "center">RESULTADO</h3>                            
                        <tr>
                            <td id="tdresultado" style="width:250;"><div id="divresultado">

                                </div><br></td>
                            <td id="tdresult" style="width:250;"><div id="divresult">

                                </div><br></td>
                        </tr>

                    </table><br><br><br>
                    </div>

                    <? 
                    $tabela3 = json_decode(@$avaliacao[0]->avaliacao_tabela3);
                    ?>
                    <table width = "900" border = "1" align = "center">
                    <h2 align = "center">TABELA 3: VARIÁVEIS DE RISCO</h2>
                        <tr>
                            <td>
                                > 70 ANOS  
                            </td>
                            <td>
                                <select name="c1tb3" id="c1tb3" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela3->c1tb3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela3->c1tb3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                HISTÓRIA DE ANGINA  
                            </td>
                            <td>
                                <select name="c2tb3" id="c2tb3" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela3->c2tb3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela3->c2tb3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                DIABETES  
                            </td>
                            <td>
                                <select name="c3tb3" id="c3tb3" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela3->c3tb3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela3->c3tb3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ONDAS Q NO ECG  
                            </td>
                            <td>
                                <select name="c4tb3" id="c4tb3" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela3->c4tb3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela3->c4tb3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                HISTÓRIA DE ICC  
                            </td>
                            <td>
                                <select name="c5tb3" id="c5tb3" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela3->c5tb3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela3->c5tb3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                HISTÓRIA DE IAM  
                            </td>
                            <td>
                                <select name="c6tb3" id="c6tb3" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela3->c6tb3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela3->c6tb3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ALT. ISQUÊMICAS DO ST  
                            </td>
                            <td>
                                <select name="c7tb3" id="c7tb3" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela3->c7tb3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela3->c7tb3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                HAS COM HVE IMPORTANTE  
                            </td>
                            <td>
                                <select name="c8tb3" id="c8tb3" class="size2">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$tabela3->c8tb3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$tabela3->c8tb3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select>
                            </td>
                        </tr>


                    </table>
                    <br><br><br>

                    <? 
                    $tabela4 = json_decode(@$avaliacao[0]->avaliacao_tabela4);
                    ?>

                    <h2 align = "center">TABELA 4: RISCO CARDÍACO PARA PROCEDIMENTOS NÃO CARDÍACOS</h2>
                    <table align = "center">
                        <tr> 
                            <td>
                                <table border="1">
                                    <td>
                                        <table width = "200">
                                            <tr>
                                                <th><font color = red><br><br>ALTO RISCO<br><br></font></th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "500">
                                            <tr>
                                                <td>a) Cirurgias vasculares</td>
                                            </tr>
                                            <tr>
                                                <td>b) Cirurgias de urgência ou emergência</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "200">
                                            <tr>
                                                <th><font color = black><br><br>Risco  ≥ 5,0%<br><br></font></th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "100">
                                            <tr>
                                                <th><select name="riscoalto" id="riscoalto" class="size2">
                                                        <option value=''>SELECIONE</option>
                                                        <option value='NAO'<?
                                    if (@$tabela4->riscoalto == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                                        <option value='SIM' <?
                                    if (@$tabela4->riscoalto == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                                    </select></th>
                                            </tr>
                                        </table>
                                    </td>
                                </table>
                                <table border="1">
                                    <td>
                                        <table width = "200">
                                            <tr>
                                                <th><font color = orange><br><br><br>RISCO INTERMEDIÁRIO<br><br><br></font></th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "500">
                                            <tr>   
                                                <td>a) Endarterectomia carotídea e correção endovascular de AAA</td>
                                            </tr>
                                            <tr>
                                                <td>b) Cirurgia de cabeça e pescoço</td>
                                            </tr>
                                            <tr>
                                                <td>c) cirurgias intraperitoneais e intratorácicas</td>
                                            </tr>
                                            <tr>
                                                <td>d) Cirurgias ortopédicas</td>
                                            </tr>
                                            <tr>
                                                <td>e) Cirurgias prostáticas</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "200">
                                            <tr>
                                                <th><font color = black><br><br><br>Risco ≥ 1,0% < 5,0%<br><br><br></font></th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "100">
                                            <tr>
                                                <th><select name="riscomedio" id="riscomedio" class="size2">
                                                        <option value=''>SELECIONE</option>
                                                        <option value='NAO'<?
                                    if (@$tabela4->riscomedio == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                                        <option value='SIM' <?
                                    if (@$tabela4->riscomedio == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                                    </select></th>
                                            </tr>
                                        </table>
                                    </td>
                                </table>        
                                <table border="1">
                                    <td>
                                        <table width = "200">
                                            <tr>
                                                <th><font color = green><br><br><br>BAIXO RISCO<br><br><br><br></font></th>
                                            </tr>                                                             
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "500">

                                            <tr>
                                                <td>a) Procedimentos endoscópicos</td>
                                            </tr>
                                            <tr>
                                                <td>b) Procedimentos superficiais</td>
                                            </tr>
                                            <tr>
                                                <td>c) Cirurgia de catarata</td>
                                            </tr>
                                            <tr>
                                                <td>d) Cirurgia de mama</td>
                                            </tr>
                                            <tr>
                                                <td>e) Cirurgia ambulatorial</td>
                                            </tr>                           
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "200">
                                            <tr>
                                                <th><font color = black><br><br><br>Risco < 1,0%<br><br><br><br></font></th>
                                            </tr>                                                             
                                        </table>
                                    </td>
                                    <td>
                                        <table width = "100">
                                            <tr>
                                                <th><select name="riscobaixo" id="riscobaixo" class="size2">
                                                        <option value=''>SELECIONE</option>
                                                        <option value='NAO'<?
                                    if (@$tabela4->riscobaixo == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                                        <option value='SIM' <?
                                    if (@$tabela4->riscobaixo == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                                    </select></th>
                                            </tr>
                                        </table>
                                    </td>
                                </table>
                        </tr>    

                    </table><br><br><br>
                                      
                    <table align="center" border="1" width = "500">
                        <h3 align = "center">CONCLUSÕES</h3>

                        <tr>
                            <th style="width:250;">RISCO AGREGADO</th>
                            <td style="width:250;"></td>
                        </tr>
                        <tr>
                            <th style="width:250;">RISCO DO PACIENTE</th>
                            <td style="width:250;"></td>
                        </tr>
                        <tr>
                            <th style="width:250;">RISCO DO PROCEDIMENTO</th>
                            <td style="width:250;"></td>
                        </tr>
                    </table><br><br><br>
                    <table align="center">
                        <td><button type="submit" name="btnEnviar">Salvar</button></td>
                        <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoformulario/<?= $ambulatorio_laudo_id ?>');">

                                Imprimir
                            </button>
                        </td>
                    </table>

                </fieldset>
            </div>
        </form>
    </div>

    <script>
        $('#c1tb2').change(function () {

            if ($('#c1tb2 :selected').val() == 'SIM') {
                $('#divc1tb2').remove();
                $('#tdc1tb2').append('<div id="divc1tb2">10</div>');
                $('#inputc1tb2').val('10');

            } else {
                $('#divc1tb2').remove();
                $('#tdc1tb2').append('<div id="divc1tb2">0</div>');
                $('#inputc1tb2').val('0');
            }
        });
        $('#c2tb2').change(function () {

            if ($('#c2tb2 :selected').val() == 'SIM') {
                $('#divc2tb2').remove();
                $('#tdc2tb2').append('<div id="divc2tb2">5</div>');
                $('#inputc2tb2').val('5');

            } else {
                $('#divc2tb2').remove();
                $('#tdc2tb2').append('<div id="divc2tb2">0</div>');
                $('#inputc2tb2').val('0');
            }
        });
        $('#c3tb2').change(function () {

            if ($('#c3tb2 :selected').val() == 'SIM') {
                $('#divc3tb2').remove();
                $('#tdc3tb2').append('<div id="divc3tb2">10</div>');
                $('#inputc3tb2').val('10');
            } else {
                $('#divc3tb2').remove();
                $('#tdc3tb2').append('<div id="divc3tb2">0</div>');
                $('#inputc3tb2').val('0');
            }
        });
        $('#c4tb2').change(function () {

            if ($('#c4tb2 :selected').val() == 'SIM') {
                $('#divc4tb2').remove();
                $('#tdc4tb2').append('<div id="divc4tb2">20</div>');
                $('#inputc4tb2').val('20');
            } else {
                $('#divc4tb2').remove();
                $('#tdc4tb2').append('<div id="divc4tb2">0</div>');
                $('#inputc4tb2').val('0');
            }
        });
        $('#c5tb2').change(function () {

            if ($('#c5tb2 :selected').val() == 'SIM') {
                $('#divc5tb2').remove();
                $('#tdc5tb2').append('<div id="divc5tb2">10</div>');
                $('#inputc5tb2').val('10');
            } else {
                $('#divc5tb2').remove();
                $('#tdc5tb2').append('<div id="divc5tb2">0</div>');
                $('#inputc5tb2').val('0');
            }
        });
        $('#c6tb2').change(function () {

            if ($('#c6tb2 :selected').val() == 'SIM') {
                $('#divc6tb2').remove();
                $('#tdc6tb2').append('<div id="divc6tb2">5</div>');
                $('#inputc6tb2').val('5');
            } else {
                $('#divc6tb2').remove();
                $('#tdc6tb2').append('<div id="divc6tb2">0</div>');
                $('#inputc6tb2').val('0');
            }
        });
        $('#c7tb2').change(function () {

            if ($('#c7tb2 :selected').val() == 'SIM') {
                $('#divc7tb2').remove();
                $('#tdc7tb2').append('<div id="divc7tb2">20</div>');
                $('#inputc7tb2').val('20');
            } else {
                $('#divc7tb2').remove();
                $('#tdc7tb2').append('<div id="divc7tb2">0</div>');
                $('#inputc7tb2').val('0');
            }
        });
        $('#c8tb2').change(function () {

            if ($('#c8tb2 :selected').val() == 'SIM') {
                $('#divc8tb2').remove();
                $('#tdc8tb2').append('<div id="divc8tb2">5</div>');
                $('#inputc8tb2').val('5');
            } else {
                $('#divc8tb2').remove();
                $('#tdc8tb2').append('<div id="divc8tb2">0</div>');
                $('#inputc8tb2').val('0');
            }
        });
        $('#c9tb2').change(function () {

            if ($('#c9tb2 :selected').val() == 'SIM') {
                $('#divc9tb2').remove();
                $('#tdc9tb2').append('<div id="divc9tb2">5</div>');
                $('#inputc9tb2').val('5');
            } else {
                $('#divc9tb2').remove();
                $('#tdc9tb2').append('<div id="divc9tb2">0</div>');
                $('#inputc9tb2').val('0');
            }
        });
        $('#c10tb2').change(function () {

            if ($('#c10tb2 :selected').val() == 'SIM') {
                $('#divc10tb2').remove();
                $('#tdc10tb2').append('<div id="divc10tb2">5</div>');
                $('#inputc10tb2').val('5');
            } else {
                $('#divc10tb2').remove();
                $('#tdc10tb2').append('<div id="divc10tb2">0</div>');
                $('#inputc10tb2').val('0');
            }
        });
        $('#c11tb2').change(function () {

            if ($('#c11tb2 :selected').val() == 'SIM') {
                $('#divc11tb2').remove();
                $('#tdc11tb2').append('<div id="divc11tb2">5</div>');
                $('#inputc11tb2').val('5');

            } else {
                $('#divc11tb2').remove();
                $('#tdc11tb2').append('<div id="divc11tb2">0</div>');
                $('#inputc11tb2').val('0');
            }
        });
        $('#c12tb2').change(function () {

            if ($('#c12tb2 :selected').val() == 'SIM') {
                $('#divc12tb2').remove();
                $('#tdc12tb2').append('<div id="divc12tb2">10</div>');
                $('#inputc12tb2').val('10');
            } else {
                $('#divc12tb2').remove();
                $('#tdc12tb2').append('<div id="divc12tb2">0</div>');
                $('#inputc12tb2').val('0');
            }
        });
        
        
        
        function calcula() {
            var n1 = parseInt($('#inputc1tb2').val()) || 0;
            var n2 = parseInt($('#inputc2tb2').val()) || 0;
            var n3 = parseInt($('#inputc3tb2').val()) || 0;
            var n4 = parseInt($('#inputc4tb2').val()) || 0;
            var n5 = parseInt($('#inputc5tb2').val()) || 0;
            var n6 = parseInt($('#inputc6tb2').val()) || 0;
            var n7 = parseInt($('#inputc7tb2').val()) || 0;
            var n8 = parseInt($('#inputc8tb2').val()) || 0;
            var n9 = parseInt($('#inputc9tb2').val()) || 0;
            var n10 = parseInt($('#inputc10tb2').val()) || 0;
            var n11 = parseInt($('#inputc11tb2').val()) || 0;
            var n12 = parseInt($('#inputc12tb2').val()) || 0;
            console.log(n1, n2, n3, n4, n5, n6, n7, n8, n9, n10, n11, n12);

            resultado = n1 + n2 + n3 + n4 + n5 + n6 + n7 + n8 + n9 + n10 + n11 + n12;

            $('#divresultado').remove();
            $('#tdresultado').append('<div id="divresultado">' + resultado + '</div>');
            
            if($('#divresultado').text()>=20){
                $('#divresult').remove();
                $('#tdresult').append('<div id="divresult"> ALTO RISCO </div>'); 
            }
            else{
                $('#divresult').remove();
                $('#tdresult').append('<div id="divresult"> AVALIAR </div>');   
            }
        }



        $('.change_tb2').change(function () {
//            alert('asdsa');
            calcula();
        });
    </script>
