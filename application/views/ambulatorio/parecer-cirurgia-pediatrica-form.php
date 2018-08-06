<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/langs/pt_BR.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/plugins/spellchecker/plugin.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/themes/modern/theme.min.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/tinymce2/tinymce/jquery.tinymce.min.js"></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/tinymce2/tinymce/tinymce.min.js"></script>-->


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
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarparecer/<?= $ambulatorio_laudo_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <input type="hidden" name="paciente_id" id="paciente_id" class="texto01"  value="<?= @$obj->_paciente_id; ?>"/>
                <fieldset>
                    
                    <table> 
                        <tr>
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>                                                        
                        </tr>
                                                                  
                    </table>


                </fieldset>
                <fieldset>
                    <h2 align = "center">Solicitação de Parecer para Cirurgia Pediátrica</h2>

               
                    <?
//                    echo '<pre>';
//                    var_dump($formulario);
//                    die;
                    
                    $dados = json_decode(@$parecer[0]->dados);
                    $exames = json_decode(@$parecer[0]->exames);
                    $examesc = json_decode(@$parecer[0]->exames_complementares);
                    $hipotese_diagnostica = json_decode(@$parecer[0]->hipotese_diagnostica);
//                   
                    ?>
                    <table border = "1" align = "center"> 
                        <tr>
                            <th><h3 align = "center" colspan = "4">HISTÓRIA CLÍNICA</h3></th>
                            <th><h3 align = "center">Resposta</h3></th>
                            <th><h3 align = "center">A</h3></th>
                        </tr> 
                        <tr>
                            <td>Anorexia</td>
                            <td>
                               
                                <select name="dado1" id="dado1" class="size1 change_p">
                                    <option value=''>SELECIONE</option>

                                    <option value='NAO' <? if (@$dados->dado1 == 'NAO'):echo 'selected';
                                    endif; ?>>NÃO</option>
                                    
                                    <option value='SIM' <?
                                    if (@$dados->dado1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td id="tddado1">
                                <div id="divdado1">

                                </div>
                            <input type="hidden" id="inputdado1" value="">                                
                            </td>
                        </tr>
                        <tr>
                            <td>Náuseas e/ou Vômitos</td>
                            <td>
                                <select name="dado2" id="dado2" class="size1 change_p">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado2  == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td id="tddado2">
                                <div id="divdado2">

                                </div>
                                <input type="hidden" id="inputdado2" value=""> 
                            </td>
                        </tr> 
                        <tr>
                            <td>Vômitos Não-Biliosos sugestivos de Estenose Pilórica </td>
                            <td>
                                <select name="dado3" id="dado3" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado3  == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado3  == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>Dor abdominal intensa e progressiva compatível com Isquemia Intestinal</td>
                            <td>
                                <select name="dado4" id="dado4" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado4  == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado4  == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr> 
                            <td>Migração da dor para quadrante inferior D</td>
                            <td>
                                <select name="dado5" id="dado5" class="size1 change_p">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado5 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado5 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td id="tddado5">
                                <div id="divdado5">

                                </div> 
                                <input type="hidden" id="inputdado5" value=""> 
                            </td>
                        </tr>    
                        <tr>    
                            <td>História de dor localizada em FID</td>
                            <td>
                                <select name="dado6" id="dado6" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado6 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado6  == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Dor Abdominal que piora com caminhar/pular ou tossir</td>
                            <td>
                                <select name="dado7" id="dado7" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado7  == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado7  == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Dor Lombar com irradiação para abdome anterior sugestiva de Cólica Renal</td>
                            <td>
                                <select name="dado8" id="dado8" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado8  == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado8  == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Dor + Abaulamento Inguinal sugestivo de encarceramento/estrangulamento herniário</td>
                            <td>
                                <select name="dado9" id="dado9" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado9  == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado9  == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Relato de evacuações com sangue e muco ("Geléia de Morango")</td>
                            <td>
                                <select name="dado10" id="dado10" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado10  == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado10  == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Relato de evacuações com sangue em grande quantidade</td>
                            <td>
                                <select name="dado11" id="dado11" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado11 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado11 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Parada de eliminação de gases e fezes</td>
                            <td>
                                <select name="dado12" id="dado12" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$dados->dado12 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$dados->dado12 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>  
                            <td>
                            <input type ="hidden" name ="dado13"  value ="<?= @$obj->dado13; ?>" id ="txtDado13">
                             Outros: <input type="text" id="txtdado13" name="dado13" class="texto10"  value="<?= @$obj->dado13; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <th><h3 align = "center" colspan = "4">EXAME FÍSICO</h3></th>
                            <th><h3 align = "center">Resposta</h3></th>
                        </tr> 
                        <tr>
                            <td>Temperatura>37, 3oC</td>
                            <td>
                                <select name="exame1" id="exame1" class="size1 change_p">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame1 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td id="tdexame1">
                                <div id="divexame1">

                                </div>
                                <input type="hidden" id="inputexame1" value=""> 
                            </td>
                        </tr>
                        <tr>
                            <td>Avaliação Pulmonar <b>NORMAL</b></td>
                            <td>
                                <select name="exame2" id="exame2" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame2 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr> 
                        <tr>
                            <td>Defesa em Quadrante Inferior D</td>
                            <td>
                                <select name="exame3" id="exame3" class="size1 change_p">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td id="tdexame3">
                                <div id="divexame3">

                                </div>
                                <input type="hidden" id="inputexame3" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>Sinal de Murphy Positivo</td>
                            <td>
                                <select name="exame4" id="exame4" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame4 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame4 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr> 
                            <td>Sinal de Blumberg Positivo</td>
                            <td>
                                <select name="exame5" id="exame5" class="size1 change_p">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame5 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame5 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td id="tdexame5">
                                <div id="divexame5">

                                </div>
                                <input type="hidden" id="inputexame5" value="">
                            </td>
                        </tr>    
                        <tr>    
                            <td>Sinal de Rovsing Positivo</td>
                            <td>
                                <select name="exame6" id="exame6" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame6 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame6 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Dificuldade para Deambular</td>
                            <td>
                                <select name="exame7" id="exame7" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame7 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame7 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Massa Palpável sugestiva de Neoplasia ou Hidronefrose</td>
                            <td>
                                <select name="exame8" id="exame8" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame8 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame8 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>Abaulamento Inguinal Não-Redutível</td>
                            <td>
                                <select name="exame9" id="exame9" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$exames->exame9 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$exames->exame9 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>
                            <input type ="hidden" name ="exame10"  value ="<?= @$obj->exame10; ?>" id ="txtExame10">
                             Outros: <input type="text" id="txtexame10" name="exame10" class="texto10"  value="<?= @$obj->exame10; ?>"  />
                            </td>
                        </tr>
                        <tr>
                            <th><h3 align = "center" colspan = "4">EXAMES COMPLEMENTARES(se houver)</h3></th>
                            <th><h3 align = "center">Resposta</h3></th>
                        </tr> 
                        <tr>
                            <td>Leucocitose > 10.000/μL</td>
                            <td>
                                <select name="examec1" id="examec1" class="size1 change_p">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$examesc->examec1 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$examesc->examec1 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td id="tdexamec1">
                                <div id="divexamec1">

                                </div>
                                <input type="hidden" id="inputexamec1" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>Leucocitose com Desvio à Esquerda (>75% de Neutrófilos)</td>
                            <td>
                                <select name="examec2" id="examec2" class="size1 change_p">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$examesc->examec2 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$examesc->examec2 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td id="tdexamec2">
                                <div id="divexamec2">

                                </div>
                                <input type="hidden" id="inputexamec2" value="">
                            </td>
                        </tr> 
                        <tr>
                            <td>Neutrófilos > 6.750/μL</td>
                            <td>
                                <select name="examec3" id="examec3" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='NAO'<?
                                    if (@$examesc->examec3 == 'NAO'):echo 'selected';
                                    endif;
                                    ?> >NÃO</option>
                                    <option value='SIM' <?
                                    if (@$examesc->examec3 == 'SIM'):echo 'selected';
                                    endif;
                                    ?> >SIM</option>
                                </select><font>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>    
                            <td>
                            <input type ="hidden" name ="examec4"  value ="<?= @$obj->examec4; ?>" id ="txtExamec4">
                             Outros: <input type="text" id="txtexamec4" name="examec4" class="texto10"  value="<?= @$obj->examec4; ?>" />
                            </td>
                        </tr>
                        </table>
                        <table border="1" align="center" width = "740">                            
                        
                            <h3 align = "center">HIPÓTESE DIAGNÓSTICA</h3>                           
                                                                     
                                                   
                        <tr>
                            <td><input type="checkbox" name="diagnostico1" id="diagnostico1" value="on">Apendicite</td>
                            <td><input type="checkbox" name="diagnostico2" id="diagnostico2" value="on">Invaginação Intestinal</td>
                            <td><input type="checkbox" name="diagnostico3" id="diagnostico3" value="on">Brida Pós-Operatória</td>                            
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="diagnostico4" id="diagnostico4" value="on">Torção Ovariana</td>
                            <td><input type="checkbox" name="diagnostico5" id="diagnostico5" value="on">Estenose Pilórica</td>
                            <td><input type="checkbox" name="diagnostico6" id="diagnostico6" value="on">Colecistite Aguda</td>                            
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="diagnostico7" id="diagnostico7" value="on">Pancreatite Aguda</td>
                            <td><input type="checkbox" name="diagnostico8" id="diagnostico8" value="on">Litíase Renal</td>                                                        
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Divert. Meckel Sangrante</td>
                            <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Hérnia Inguinal Encarcerda/Estrangulada</td>
                        </tr>    
                    </table>
                    
                    <br><br>
                    <fieldset>
                        <legend style="color:red">OBSERVAÇÕES EM SUSPEITA DE APENDICITE</legend>
                        <h4 align = "center">HISTÓRICO DE USO DE ANTIBIÓTICO PRÉVIO A CONFUNDIR AVALIAÇÃO CLÍNICA: <input type="checkbox" name="sim" value="sim" >SIM <input type="checkbox" name="nao" value="nao" >NÃO</h4>
                        <table>
                            <th>ALVARADO(A):</th><td id="tdtotal"><div id="divtotal"></div></td><td id="tdresult"><div id="divresult"></div></td>
                        </table>
                    </fieldset>
                    <br><br><br>
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
</div>
<script>
        $('#dado1').change(function () {

            if ($('#dado1 :selected').val() == 'SIM') {
                $('#divdado1').remove();
                $('#tddado1').append('<div id="divdado1">1</div>');
                $('#inputdado1').val('1');

            } else {
                $('#divdado1').remove();
                $('#tddado1').append('<div id="divdado1">0</div>');
                $('#inputdado1').val('0');
            }
        });
        $('#dado2').change(function () {

            if ($('#dado2 :selected').val() == 'SIM') {
                $('#divdado2').remove();
                $('#tddado2').append('<div id="divdado2">1</div>');
                $('#inputdado2').val('1');

            } else {
                $('#divdado2').remove();
                $('#tddado2').append('<div id="divdado2">0</div>');
                $('#inputdado2').val('0');
            }
        });
        $('#dado5').change(function () {

            if ($('#dado5 :selected').val() == 'SIM') {
                $('#divdado5').remove();
                $('#tddado5').append('<div id="divdado5">1</div>');
                $('#inputdado5').val('1');

            } else {
                $('#divdado5').remove();
                $('#tddado5').append('<div id="divdado5">0</div>');
                $('#inputdado5').val('0');
            }
        });
        $('#exame1').change(function () {

            if ($('#exame1 :selected').val() == 'SIM') {
                $('#divexame1').remove();
                $('#tdexame1').append('<div id="divexame1">1</div>');
                $('#inputexame1').val('1');

            } else {
                $('#divexame1').remove();
                $('#tdexame1').append('<div id="divexame1">0</div>');
                $('#inputexame1').val('0');
            }
        });
        $('#exame3').change(function () {

            if ($('#exame3 :selected').val() == 'SIM') {
                $('#divexame3').remove();
                $('#tdexame3').append('<div id="divexame3">2</div>');
                $('#inputexame3').val('1');

            } else {
                $('#divexame3').remove();
                $('#tdexame3').append('<div id="divexame3">0</div>');
                $('#inputexame3').val('0');
            }
        });
        $('#exame5').change(function () {

            if ($('#exame5 :selected').val() == 'SIM') {
                $('#divexame5').remove();
                $('#tdexame5').append('<div id="divexame5">1</div>');
                $('#inputexame5').val('1');

            } else {
                $('#divexame5').remove();
                $('#tdexame5').append('<div id="divexame5">0</div>');
                $('#inputexame5').val('0');
            }
        });
        $('#examec1').change(function () {

            if ($('#examec1 :selected').val() == 'SIM') {
                $('#divexamec1').remove();
                $('#tdexamec1').append('<div id="divexamec1">2</div>');
                $('#inputexamec1').val('2');

            } else {
                $('#divexamec1').remove();
                $('#tdexamec1').append('<div id="divexamec1">0</div>');
                $('#inputexamec1').val('0');
            }
        });
        $('#examec2').change(function () {

            if ($('#examec2 :selected').val() == 'SIM') {
                $('#divexamec2').remove();
                $('#tdexamec2').append('<div id="divexamec2">1</div>');
                $('#inputexamec2').val('1');

            } else {
                $('#divexamec2').remove();
                $('#tdexamec2').append('<div id="divexamec2">0</div>');
                $('#inputexamec2').val('0');
            }
        });
        
        function calcula1() {
            var x1 = parseInt($('#inputdado1').val()) || 0;
            var x2 = parseInt($('#inputdado2').val()) || 0;
            var x3 = parseInt($('#inputdado5').val()) || 0;
            var x4 = parseInt($('#inputexame1').val()) || 0;
            var x5 = parseInt($('#inputexame3').val()) || 0;
            var x6 = parseInt($('#inputexame5').val()) || 0;
            var x7 = parseInt($('#inputexamec1').val()) || 0;
            var x8 = parseInt($('#inputexamec2').val()) || 0;
            
            console.log(x1, x2, x3, x4, x5, x6, x7, x8);
            total = x1 + x2 + x3 + x4 + x5 + x6 + x7 + x8;

            $('#divtotal').remove();
            $('#tdtotal').append('<div id="divtotal">' + total + '</div>');
            
            if($('#divtotal').text()<4){
                $('#divresult').remove();
                $('#tdresult').append('<div id="divresult"> BAIXO RISCO </div>'); 
            }
            if($('#divtotal').text()>=4 && $('#divtotal').text()<=7){
                $('#divresult').remove();
                $('#tdresult').append('<div id="divresult"> RISCO INTERMEDIÁRIO </div>'); 
            }
            if($('#divtotal').text()>7){
                $('#divresult').remove();
                $('#tdresult').append('<div id="divresult"> ALTO RISCO DE APENDICITE </div>');   
            }
        }



        $('.change_p').change(function () {
            calcula1();
        });

</script>