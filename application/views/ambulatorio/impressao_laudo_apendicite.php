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

        <table> 
            <tr>
                <td width="400px;">Paciente: <?= @$obj->_nome ?></td>                                                        
            </tr>

        </table>


    </fieldset>

    <h2 align = "center">Laudo de US para Apendicite</h2>


    <?
    $detalhamento = $this->laudo->preencherlaudous($obj->_paciente_id, $obj->_guia_id);
    $diagnostico = json_decode(@$detalhamento[0]->simnao);
    $diagnosticous = json_decode(@$detalhamento[0]->perguntas);
    ?>
    <br>
    <table width="90%">
        <tr height="30px">
            <td style="padding-left: 350px"><b>Histórico Clínico:</b></td>
            <td>                
                <?= @$diagnosticous->historicoclinico; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px"><b>Estudos Anteriores:</b></td>
            <td>
                <?= @$diagnosticous->estudosanteriores; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px"><b>Descobertas:</b></td>
            <td>
                <?= @$diagnosticous->descobertas; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px"><b><u>Apêndice:</u></b></td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Visualizado:</td>
            <td>
                <?= @$diagnosticous->visualizado; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Com Fluido:</td>
            <td>
              
                <?= @$diagnostico->comfluido; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Compressível:</td>

            <td>
                
                <?= @$diagnostico->compressivel; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Diâmetro máximo com compressão (parede exterior a parede exterior):</td>
            <td>
                <?= @$diagnosticous->diametromax; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Apendicólito:</td>
            <td>
                
                <?= @$diagnostico->apendicolito; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;<u>- Parede:</u></td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Hiperemia:</td>
            <td>
               
                <?= @$diagnostico->hiperemia; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Espessamento (>2mm):</td>
            <td>
                
                <?= @$diagnostico->espessamento; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Perda de estratificação mural:</td>
            <td>
                
                <?= @$diagnostico->pemural; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px"><b>Fluido Livre:</b></td>
            <td>
                
                <?= @$diagnostico->fluidolivre; ?>
            </td>

        </tr>
        <tr height="30px">
            <td style="padding-left: 350px"><b>Aumento da ecogenicidade da gordura periapendicular:</b></td>
            <td>                
                 <?= @$diagnostico->aegperiapendicular; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px"><b>Abscesso:</b></td>
            <td>                
                <?= @$diagnostico->abscesso; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px"><b>Descobertas Adicionais:</b></td>
            <td>
                <?= @$diagnosticous->descobertasadc; ?>
            </td>
        </tr>
        <tr height="60px">
            <td style="padding-left: 350px"><b><u>IMPRESSÕES:</u></b></td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">Escore de Apendicite:</td>
            <td>
                <?= @$diagnosticous->escoreapendicite; ?>
            </td>
        </tr>
        <tr height="30px">
            <td style="padding-left: 350px">Diagnóstico adicional/alternativo</td>
            <td>
                <?= @$diagnosticous->diagnosticoadc; ?>
            </td>
        </tr>
    </table>
    <br><br>
    <h4 align = "center">Classificação de achados cirurgicos da Apendicite</h4>
    <table align="center" border="1" style="border-collapse: collapse; text-align: center">
        <tr>
            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;Grau&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;Achados Laparoscópicos&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
        </tr>
        <tr>
            <td>0</td>
            <td>Apêndice de aparência normal</td>
        </tr>
        <tr>
            <td>1</td>
            <td>Hiperemia e edema</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Exsudado fibrinoso</td>
        </tr>
        <tr>
            <td>3A</td>
            <td>Necrose segmentar</td>
        </tr>
        <tr>
            <td>3B</td>
            <td>Necrose de base</td>
        </tr>
        <tr>
            <td>4A</td>
            <td>Abscesso</td>
        </tr>
        <tr>
            <td>4B</td>
            <td>Peritonite Regional</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Peritonite Difusa</td>
        </tr>
    </table>
    <br>
    </fieldset>
    <br><br><br>


</div>



