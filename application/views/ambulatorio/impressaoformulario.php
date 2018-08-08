<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?
$dataFuturo = date("Y-m-d");
$dataAtual = @$obj->_nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
?>    
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
            <tr><td>Idade: <?= $teste ?></td>
                <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
               <!-- <td>Peso:<?= $peso ?></td>
                <td>Altura:<?= $altura ?></td>-->

            </tr>


            <tr>                        

                <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
            </tr>


        </table>


    </fieldset>
    <br><br>

    <h2 align = "center">Questionário para Avaliação da Capacidade Funcional</h2>


    <br><br>
    <?
//                    echo '<pre>';
//                    var_dump($formulario);
//                    die;
    $questoes = json_decode(@$formulario[0]->questoes);
//                    var_dump($questoes);die;
    ?>
    <table border = "1" align = "center"> 
        <tr>
            <th><h3 align = "center" colspan = "4">Você Consegue?</h3></th>
            <th><h3 align = "center">Resposta</h3></th>
        </tr> 
        <tr>
            <td>Cuidar de si mesmo: vestir-se, alimentar-se, tomar banho?*</td>
            <td>
                <? echo "$questoes->pergunta1"; ?>
            </td>
        </tr>
        <tr>
            <td>Caminhar uma quadra ou duas, no plano?</td>
            <td>
                <? echo "$questoes->pergunta2"; ?>
            </td>
        </tr> 
        <tr>
            <td>Subir um lance de escadas ou caminhar em uma subida?</td>
            <td>
                <? echo "$questoes->pergunta3"; ?>
            </td>
        </tr>
        <tr>
            <td>Correr uma distância curta?</td>
            <td>
                <? echo "$questoes->pergunta4"; ?>
            </td>
        </tr>
        <tr> 
            <td>Fazer trabalhos leves em casa, como juntar o lixo ou lavar a louça?</td>
            <td>
                <? echo "$questoes->pergunta5"; ?>
            </td>
        </tr>    
        <tr>    
            <td>Fazer trabalhos moderados em casa, como passar o aspirador de pó, varrer o chão ou carregar mantimentos?</td>
            <td>
                <? echo "$questoes->pergunta6"; ?>
            </td>
        </tr>
        <tr>    
            <td>Fazer trabalhos pesados em casa, como esfregar/lavar o piso ou deslocar móveis pesados?</td>
            <td>
                <? echo "$questoes->pergunta7"; ?>
            </td>
        </tr>
        <tr>    
            <td>Fazer trabalhos no jardim/quintal, como usar o rastelo, juntar folhas ou usar a máquina de cortar grama?</td>
            <td>
                <? echo "$questoes->pergunta8"; ?>
            </td>
        </tr>
        <tr>    
            <td>Ter atividade sexual?</td>
            <td>
                <? echo "$questoes->pergunta9"; ?>
            </td>
        </tr>
        <tr>    
            <td>Participar de atividades recreacionais moderadas, como jogar boliche, dançar, jogar tênis em dupla?</td>
            <td>
                <? echo "$questoes->pergunta10"; ?>
            </td>
        </tr>
        <tr>    
            <td>Participar de atividades esportivas, como natação, tênis individual ou jogar futebol?</td>
            <td>
                <? echo "$questoes->pergunta11"; ?>
            </td>
        </tr>

        <tr>
            <th><h3 align = "center" colspan = "4">Fatores de Risco para Doença Arterial Coronariana (DAC)</h3></th>
            <th><h3 align = "center">Resposta</h3></th>
        </tr> 
        <tr>
            <td>OBESIDADE</td>
            <td>
                <? echo $formulario[0]->obesidade; ?>                                                                      
            </td>
        </tr>
        <tr>
            <td>SEDENTARISMO</td>
            <td>
                <? echo $formulario[0]->sedentarismo; ?> 
            </td>
        </tr> 
        <tr>
            <td>DIABETES</td>
            <td>
                <? echo $formulario[0]->diabetes; ?>
            </td>
        </tr>
        <tr>
            <td>HIPERTENSÃO ARTERIAL</td>
            <td>
                <? echo $formulario[0]->hipertensao; ?>
            </td>
        </tr>
        <tr> 
            <td>DAC PRECOCE NA FAMÍLIA</td>
            <td>
                <? echo $formulario[0]->dac; ?>
            </td>
        </tr>    
        <tr>    
            <td>TABAGISMO</td>
            <td>
                <? echo $formulario[0]->tabagismo; ?>
                </select><font>
            </td>
        </tr>
        <tr>    
            <td>DISLIPIDEMIA</td>
            <td>
                <? echo $formulario[0]->dislipidemia; ?>                                
            </td>
        </tr>
        <tr>
            <th><h3 align = "center" colspan = "4">Doenças Pré Existentes</h3></th>
            <th><h3 align = "center">Resposta</h3></th>
        </tr> 
        <tr>
            <td>DIABETES</td>
            <td>
                <? echo $formulario[0]->diabetespe; ?>
            </td>
        </tr>
        <tr>
            <td>HAS</td>
            <td>
                <? echo $formulario[0]->haspe; ?>
            </td>
        </tr> 
        <tr>
            <td>DAC PRECOCE FAMILIAR</td>
            <td>
                <? echo $formulario[0]->dacpe; ?>
            </td>
        </tr>
        <tr>
            <td>IRC</td>
            <td>
                <? echo $formulario[0]->ircpe; ?>
            </td>
        </tr>
        <tr> 
            <td>SOPROS</td>
            <td>
                <? echo $formulario[0]->sopros; ?>
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




</div>

