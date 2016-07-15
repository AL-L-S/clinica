
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>


    <table>
        <tbody>
            <tr>
                <td width="70%;" ><font size = -1><?= $exame[0]->razao_social; ?></td>
                <td ><font size = -1>Emissao:<?= str_replace("-", "/", $emissao); ?></td>
            </tr>
            <tr>
                <td ><font size = -1><?= $exame[0]->logradouro; ?><?= $exame[0]->numero; ?> - <?= $exame[0]->bairro; ?></td>
                <td ></td>
            </tr>
            <tr>
                <td ><font size = -1>Fone: <?= $exame[0]->telefoneempresa; ?></td>
                <td ></td>
            </tr>
            <tr>
                <td ><font size = -1>&nbsp;</td>
                <td ></td>
            </tr>
            <tr>
                <td ><b><font size = -1>Paciente:<?= $paciente['0']->nome; ?></b></td>
                <td ></td>
            </tr>
            <tr>
                <td ><font size = -1>Usuario:&nbsp;<b><?= $paciente['0']->paciente_id ?>&nbsp;</b>Senha: &nbsp;<b><?= $exames['0']->agenda_exames_id ?></b></td>
                <td ><b>Site: www.humanaimagem.com.br/</b></td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td ><font size = -1>Exame</td>
                <td ><font size = -1>RECEBER EM</td>
                <td ><font size = -1>Horario</td>
            </tr>
            <?
            foreach ($exames as $item) :
                if ($item->grupo == $exame[0]->grupo) {
                    $exame_id = $item->agenda_exames_id;
                    $dataatualizacao = $item->data_autorizacao;
                    $inicio = $item->inicio;
                    $agenda = $item->agenda;
                    $operador_autorizacao = $item->operador;
                    ?>

                    <tr>
                        <td width="35%;" ><font size = -1><?= utf8_decode($item->procedimento) ?></td>
                        <? if ($exame[0]->data_entrega != "") { ?>
                            <td width="25%;"><font size = -1><?= substr($exame[0]->data_entrega, 8, 2) . "/" . substr($exame[0]->data_entrega, 5, 2) . "/" . substr($exame[0]->data_entrega, 0, 4); ?></td>
                        <? } else { ?>
                            <td width="25%;"><font size = -1>_____/_____/_________</td>
                        <? } ?>
                        <td ><font size = -1>_____:_____</td>
                    </tr>
                    <?
                }
            endforeach;
            ?>
        </tbody>
    </table>
    <hr>
    <label><font size = -1>OBS: RECEBIMENTO DE EXAMES SOMENTE COM APRESENTACAO DESTE CANHOTO ACOMPANHADO DE DOCUMENTO DE IDENTIFICACAO.</font></label>
    <hr>
    <table>
        <tbody>
            <tr>
                <? if ($exame[0]->data_entrega != "") { ?>
                    <td width="25%;"><font size = -1>RECEBER EM <?= substr($exame[0]->data_entrega, 8, 2) . "/" . substr($exame[0]->data_entrega, 5, 2) . "/" . substr($exame[0]->data_entrega, 0, 4); ?></td>
                <? } else { ?>
                    <td width="25%;"><font size = -1>RECEBER EM_____/_____/_________</td>
<? } ?>
                <td ><font size = -1>Horario: ____:____</font></td>
                <td ><font size = -1>Sexo: <?= $exame[0]->sexo; ?></font></td>
            </tr>
            <tr>
                <td ><font size = -1>FICHA DE EXAME - Nr.Ficha:<?= $paciente['0']->paciente_id; ?></font></td>
                <td ><font size = -1>Aut.:<?= substr($operador_autorizacao, 0, 15); ?></font></td>
                <td ><font size = -1>VIA - MEDICO</font></td>
            </tr>
            <tr>
                <td ><font size = -1>Nr. Pedido: <?= $exame[0]->guia_id; ?></font></td>
                <td ><font size = -1>TELEFONE:<?= $paciente['0']->telefone; ?>/<?= $paciente['0']->celular; ?></font></td>
                <td ><font size = -1>Chegada: <?= substr($dataatualizacao, 10, 9); ?></font></td>
            </tr>
            <tr>
                <td ><font size = -1>Agenda:<?= $agenda; ?></font></td>
                <td ><font size = -1>Emissao:<?= str_replace("-", "/", $emissao); ?></font></td>
                <td ><font size = -1>Ordem:<?= $inicio; ?></font></td>
                <td ></td>
            </tr>
            <tr>
                <td width="50%;" ><font size = -1>Paciente: <?= $paciente['0']->nome; ?></font></td>
                <td width="30%;"><font size = -1>Nascimento:<?= substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?></font></td>
                <td ><font size = -1>Idade: <?= $teste; ?></font></td>    
            </tr>

    </table>
    <table>
        <tr>
            <td colspan="2">EXAME</td>
            <td >CONVENIO</td>
            <td >AUTORIZACAO</td>
            <td >SOLICITANTE</td>
        </tr>
        <?
        foreach ($exames as $item) :
            if ($item->grupo == $exame[0]->grupo) {
                ?>
                <tr>
                    <td ><?= utf8_decode($item->quantidade) ?></td>
                    <td width="40%;"><?= utf8_decode($item->procedimento) . "-" . utf8_decode($item->sala) ?></td>
                    <td ><?= $item->convenio ?></td>
                    <td ><?= $item->autorizacao ?></td>
                    <td width="25%;">Dr(a). <?= utf8_decode($item->medicosolicitante) ?></td>
                </tr>
                <?
            }
        endforeach;
        ?>
        </tbody>
    </table>
    <hr>
    <table>
        <?
        foreach ($exames as $item) :
            if ($item->grupo != $exame[0]->grupo) {
                ?>
                <tr>
                    <td width="40%;"><?= utf8_decode($item->procedimento) . "-" . utf8_decode($item->sala) ?></td>
                    <td ><?= $item->convenio ?></td>
                    <td ><?= $item->autorizacao ?></td>
                    <td width="25%;"><?= utf8_decode($item->medicosolicitante) ?></td>
                </tr>
                <?
            }
        endforeach;
        ?>
        </tbody>
    </table>

    <table>
        <tr>
            <td width="80%;"><font size = -1>*****************************QUESTIONARIO****************************</td>
            <td ><font size = -1>S/N</td>
        </tr>
        <tr>
            <td ><font size = -1>Trabalha ou trabalhou com metais?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem ou teve fragmentos metalicos nos olhos?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem ou teve projetil de arma no corpo?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>(bala ou fragmentos metalicos de qualquer origem)</font></td>
            <td ></td>
        </tr>
        <tr>
            <td ><font size = -1>Tem marcapasso cardiaco, desfibrilador ou cardioverter?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem clipes de aneurisma no cerebro?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem pumpes ou neuroestimuladores implantados?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Fez substituicao de valvulas cardiacas?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem implantes no ouvido (coclear, estribo) ou aparelho auditivo?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem algum componente artificial no corpo?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem protese, hastes, placas ou parafuso metalicos no corpo?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem protese dentaria, aparelho ortodontico ou peruca?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem implante peniano?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem D.I. udispositivo contraceptivo intra-uterino?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Consegue ficar deitado de costas e sentir-se confortavel num</font></td>
            <td ></td>
        </tr>
        <tr>
            <td ><font size = -1>espaco pequeno durante aproximadamente 1/2 hora?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Ja fez tratamento quimioterapico ou radioterapico?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem problema de insuficiencia renal?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Existe alguma possibilidade de voce estar gravida?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Esta amamentando?</font></td>
            <td ><font size = -1>(&nbsp;&nbsp; )</td>
        </tr>
        <tr>
            <td colspan="2"><font size = -1>Tem alergia S /N (   ) A que___________________________________________________</font></td>
        </tr>
        <tr>
            <td colspan="2"><font size = -1>Ja realizou cirurgias S /N (   ) Quais___________________________________________</font></td>
        </tr>
        <tr>
            <td colspan="2"><font size = -1>_____________________________________________________________________________</td>
        </tr>
        <tr>
            <td colspan="2"><center><font size = -1>________________________________________</center></td>
        </tr>
        <tr>
            <td colspan="2"><center>ASSINATURA</center></td>
        </tr>

        </tbody>
    </table>
</div>
