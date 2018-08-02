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

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarformulario/<?= $ambulatorio_laudo_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr>
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>                            
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                           <!-- <td>Peso:<?= $peso ?></td>
                            <td>Altura:<?= $altura ?></td>-->
                           
                        </tr>
                       

                        <tr>                        
                      
                            <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
                        </tr>
                        <tr>
                            <td>
                          
                            <button type="button" name="btnAvaliacao"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                            
                               Avaliação
                            
                            </button> 
                        </td>
                        </tr>
                      
                    </table>


                </fieldset>
                <fieldset>
                    <h1 align = "center">Questionário para Avaliação da Capacidade Funcional</h1>
                    
                </fieldset>
                
                 <fieldset>
                    <table border = "1" align = "center"> 
                    <tr>
                        <th><h3 align = "center" colspan = "4">Você Consegue?</h3></th>
                        <th><h3 align = "center">Resposta</h3></th>
                    </tr> 
                    <tr>
                        <td>Cuidar de si mesmo: vestir-se, alimentar-se, tomar banho?*</td>
                        <td>
                              <select name="pergunta1" id="pergunta1" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta1 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta1 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>
                        <td>Caminhar uma quadra ou duas, no plano?</td>
                        <td>
                             <select name="pergunta2" id="pergunta2" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta2 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta2 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr> 
                    <tr>
                        <td>Subir um lance de escadas ou caminhar em uma subida?</td>
                        <td>
                             <select name="pergunta3" id="pergunta3" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta3 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta3 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>
                        <td>Correr uma distância curta?</td>
                        <td>
                             <select name="pergunta4" id="pergunta4" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta4 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta4 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr> 
                        <td>Fazer trabalhos leves em casa, como juntar o lixo ou lavar a louça?</td>
                        <td>
                             <select name="pergunta5" id="pergunta5" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta5 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta5 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>    
                    <tr>    
                        <td>Fazer trabalhos moderados em casa, como passar o aspirador de pó, varrer o chão ou carregar mantimentos?</td>
                        <td>
                             <select name="pergunta6" id="pergunta6" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta6 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta6 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>    
                        <td>Fazer trabalhos pesados em casa, como esfregar/lavar o piso ou deslocar móveis pesados?</td>
                        <td>
                             <select name="pergunta7" id="pergunta7" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta7 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta7 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>    
                        <td>Fazer trabalhos no jardim/quintal, como usar o rastelo, juntar folhas ou usar a máquina de cortar grama?</td>
                        <td>
                             <select name="pergunta8" id="pergunta8" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta8 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta8 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>    
                        <td>Ter atividade sexual?</td>
                        <td>
                             <select name="pergunta9" id="pergunta9" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta9 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta9 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>    
                        <td>Participar de atividades recreacionais moderadas, como jogar boliche, dançar, jogar tênis em dupla?</td>
                        <td>
                             <select name="pergunta10" id="pergunta10" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta10 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta10 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>    
                        <td>Participar de atividades esportivas, como natação, tênis individual ou jogar futebol?</td>
                        <td>
                             <select name="pergunta11" id="pergunta11" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_pergunta11 == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_pergunta11 == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
               
                    <tr>
                        <th><h3 align = "center" colspan = "4">Fatores de Risco para Doença Arterial Coronariana (DAC)</h3></th>
                        <th><h3 align = "center">Resposta</h3></th>
                    </tr> 
                    <tr>
                        <td>OBESIDADE</td>
                        <td>
                              <select name="obesidade" id="obesidade" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_obesidade == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_obesidade == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>
                        <td>SEDENTARISMO</td>
                        <td>
                             <select name="sedentarismo" id="sedentarismo" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_sedentarismo == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_sedentarismo == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr> 
                    <tr>
                        <td>DIABETES</td>
                        <td>
                             <select name="diabetes" id="diabetes" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_diabetes == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_diabetes == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>
                        <td>HIPERTENSÃO ARTERIAL</td>
                        <td>
                             <select name="hipertensao" id="hipertensao" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_hipertensao == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_hipertensao == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr> 
                        <td>DAC PRECOCE NA FAMÍLIA</td>
                        <td>
                             <select name="dac" id="dac" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_dac == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_dac == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>    
                    <tr>    
                        <td>TABAGISMO</td>
                        <td>
                             <select name="tabagismo" id="tabagismo" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_tabagismo == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_tabagismo == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>    
                        <td>DISLIPIDEMIA</td>
                        <td>
                             <select name="dislipidemia" id="dislipidemia" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_dislipidemia == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_dislipidemia == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                <tr>
                        <th><h3 align = "center" colspan = "4">Doenças Pré Existentes</h3></th>
                        <th><h3 align = "center">Resposta</h3></th>
                    </tr> 
                    <tr>
                        <td>DIABETES</td>
                        <td>
                              <select name="diabetespe" id="diabetespe" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_diabetespe == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_diabetespe == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>
                        <td>HAS</td>
                        <td>
                             <select name="haspe" id="haspe" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_haspe == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_haspe == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr> 
                    <tr>
                        <td>DAC PRECOCE FAMILIAR</td>
                        <td>
                             <select name="dacpe" id="dacpe" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_dacpe == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_dacpe == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr>
                        <td>IRC</td>
                        <td>
                             <select name="ircpe" id="ircpe" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_ircpe == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_ircpe == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>
                    <tr> 
                        <td>SOPROS</td>
                        <td>
                             <select name="sopros" id="sopros" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='NAO'<?
                                        if (@$obj->_sopros == 'NAO'):echo 'selected';
                                        endif;
                                        ?> >NÃO</option>
                                        <option value='SIM' <?
                                        if (@$obj->_sopros == 'SIM'):echo 'selected';
                                        endif;
                                        ?> >SIM</option>
                                    </select><font>
                        </td>
                    </tr>    
                    </table>
                       <?
                                if (@$obj->_questoes != '') {
                                    $perguntas_form = json_decode(@$obj->_questoes);
                                } else {
                                    $perguntas_form = array();
                                }
                               
                                ?>
                   
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