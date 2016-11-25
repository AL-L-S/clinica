<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>
    <head>
        <meta charset="utf-8">
    </head>
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
    <hr>
    <TABLE >
        <body>

        <TR>
            <TD ><font size = -1>Anammese: </font>
            </TD>
        </TR>
        <TR>
            <TD ><font size = -1>Encaminhamento: (&nbsp;)alta   (&nbsp;)transferência </font>
            </TD>
        </TR>
        </body>
    </TABLE>
    <hr>
    <table>
        <tr>
            <td ><font size = -1><center><b>RESPONDA SIM OU N&Atilde;O, NOS ITENS QUE SE SEGUEM</b></center></td>            
        <td ><font size = -1><b>Peso:<? echo utf8_decode($peso) ?>Kg</b></td>
        </tr>
        <tr>
            <td ><font size = -1>Trabalha ou trabalhou com metais?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r1); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem ou teve fragmentos metalicos nos olhos?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r2); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem ou teve projetil de arma no corpo?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r3); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>(bala ou fragmentos metalicos de qualquer origem)</font></td>
            <td ></td>
        </tr>
        <tr>
            <td ><font size = -1>Tem marcapasso cardiaco, desfibrilador ou cardioverter?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r4); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem clipes de aneurisma no cerebro?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r5); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem pumpes ou neuroestimuladores implantados?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r6); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Fez substituicao de valvulas cardiacas?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r7); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem implantes no ouvido (coclear, estribo) ou aparelho auditivo?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r8); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem algum componente artificial no corpo?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r9); ?> &nbsp; )</td>

        </tr>
        <tr>
            <td ><font size = -1>Tem protese, hastes, placas ou parafuso metalicos no corpo?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r10); ?> &nbsp; )--<? echo utf8_decode($txtp9); ?></td>
        </tr>
        <tr>
            <td ><font size = -1>Tem protese dentaria, aparelho ortodontico ou peruca?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r11); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem implante peniano?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r12); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem D.I.U dispositivo contraceptivo intra-uterino?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r13); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Consegue ficar deitado de costas e sentir-se confortavel num</font></td>
            <td ></td>
        </tr>
        <tr>
            <td ><font size = -1>espaco pequeno durante aproximadamente 1/2 hora?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r14); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Ja fez tratamento quimioterapico ou radioterapico?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r15); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Tem problema de insuficiencia renal?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r16); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Existe alguma possibilidade de voce estar gravida?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r17); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td ><font size = -1>Esta amamentando?</font></td>
            <td ><font size = -1>(&nbsp; <? echo utf8_decode($r18); ?> &nbsp; )</td>
        </tr>
        <tr>
            <td <font size = -1>Tem alergia</font></td>
            <td ><font size = -1>(&nbsp;<? echo utf8_decode($r19); ?> &nbsp; )--<? echo utf8_decode($txtp19); ?> </td>
        </tr>
        <tr>
            <td <font size = -1>Ja realizou cirurgias </font></td>
            <td ><font size = -1>(&nbsp;<? echo utf8_decode($r20); ?> &nbsp; )--<? echo utf8_decode($txtp20); ?></td>
        </tr>
        <tr>
            <td ><font size = -1>Este exame pode necessitar de contraste. O Sr. permite administra&ccedil;&atilde;o?</font></td>
            <td ><font size = -1>(&nbsp; &nbsp; &nbsp; )</td>
        </tr>
        <tr>
            <td colspan="1"><font size = -1>OBS:</font></td>
        </tr> 
        <tr>
            <td colspan="-1"><font size = -1><? echo utf8_decode($obs) ?></font></td>
        </tr>
        <tr>
            <td colspan="-1"><font size = -1><b>Declaro que as informações por mim fornecidas neste formulário são verdadeiras e que estou ciente dos riscos inerentes ao exame.</br> Autorizo a realização do(s) exame(s) solicitado(s) e de injeção de produto de contraste, necessário ao(s) mesmo(s).</b></font></td>
        </tr>
        <tr>
            <td ><font size = -1><b>Fortaleza,<?= str_replace("-", "/", utf8_decode($emissao)); ?></b></font></td>
        </tr>
        <!--        <table>
                    <br>
                    <tr>           
                        <td>Obs:<p CLASS="western" STYLE="margin-bottom: 0cm"><SPAN ID="quadroOBS" DIR="LTR" STYLE="float: left; width: 18cm; height: 1.5cm; border: 1px solid #000000; padding: 0.15cm; background: #ffffff">
                                </SPAN>
                            </P>
                        </td>
                    </tr>
                </table>-->
    </table>

    <center><table>
            <tr>
                <td width="150px">_______________________________</td>
                <td width="150px">_______________________________</td>
                <td width="150px">_______________________________</td>
                <td>_______________________________</td>
            </tr>
            <tr>
                <td width="150px"><center>Paciente</center></td>
                <td width="150px"><center>Técnico</center></td>
                <td width="150px"><center>Enfermagem</center></td>
                <td><center>Médico</center></td>
            </tr>
        </table></center>
<!--    <tr>
        <td colspan="2"><center><font size = -1>________________________________________    ________________________________________    ________________________________________    ________________________________________</center></td>
</tr>-->
<!--<tr>
    <td colspan="4"><center>Paciente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        Técnico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
    Enfermagem &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Médico</center></td>
</tr>-->

    <div style="page-break-after: always"></div>
</tbody>
<br/>
<hr/>

<TABLE ><CENTER>

        <TD >
            <P ><FONT SIZE=-1><B>Material</B></FONT></P>
        </TD>
        <TD>
            <P ><FONT SIZE=-1><B>Qtde</B></FONT></P>
        </TD>
        <TD>
            <P ><FONT SIZE=-1><B>Material</B></FONT></P>
        </TD>
        <TD >
            <P><FONT SIZE=-1><B>Qtde</B></FONT></P>
        </TD>
        <TD>
            <P ><FONT SIZE=-1><B>Material</B></FONT></P>
        </TD>
        <TD >
            <P ><FONT SIZE=-1><B>Qtde</B></FONT></P>
        </TD>
        <TD ROWSPAN=4 >
            <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Contraste: Sim (  )    
                Não(  )</FONT></P>
            <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Dose:_____ml</FONT></P>
            <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Qual
                Contraste___________</FONT></P>
            <P CLASS="western" ALIGN=LEFT><BR>
            </P>
            <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Lote:_________________</FONT></P>
        </TD>
        </TR>
        <TR VALIGN=TOP>
            <TD >
                <P ALIGN=LEFT><FONT SIZE=-1>Scalp n°</FONT></P>
            </TD>
            <TD >
                <P  ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD >
                <P  ALIGN=LEFT><FONT SIZE=-1>Contraste</FONT></P>
            </TD>
            <TD >
                <P  ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD >
                <P  ALIGN=LEFT><FONT SIZE=-1>Soro Ringer</FONT></P>
            </TD>
            <TD >
                <P ALIGN=LEFT><BR>
                </P>
            </TD>
        </TR>
        <TR VALIGN=TOP>
            <TD >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Seringa  ml</FONT></P>
            </TD>
            <TD >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Equipo n°</FONT></P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Água</FONT></P>
            </TD>
            <TD WIDTH=38 >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
        </TR>
        <TR VALIGN=TOP>
            <TD >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Abocat   n°</FONT></P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Esparadrapo</FONT></P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Luva</FONT></P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
        </TR>
        <TR VALIGN=TOP>
            <TD >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Agulha n°</FONT></P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Alcool</FONT></P>
            </TD>
            <TD >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Filmes</FONT></P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD ROWSPAN=3 >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Exame finalizado:</FONT></P>
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>com intercorrencia  (  
                    ) </FONT>
                </P>
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>sem intercorrencia (  )
                    </FONT>
                </P>
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Justificativa:</FONT></P>
            </TD>
        </TR>
        <TR VALIGN=TOP>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Bolas de Algodão</FONT></P>
            </TD>
            <TD WIDTH=41 >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD WIDTH=124 >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Soro Físico    ml</FONT></P>
            </TD>
            <TD WIDTH=42 >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD WIDTH=111 >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Filmes papel</FONT></P>
            </TD>
            <TD WIDTH=38 >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
        </TR>
        <TR VALIGN=TOP>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Compressa Gaze</FONT></P>
            </TD>
            <TD >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Soro Glico     ml</FONT></P>
            </TD>
            <TD >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
            <TD >
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>CD/DVD</FONT></P>
            </TD>
            <TD  >
                <P CLASS="western" ALIGN=LEFT><BR>
                </P>
            </TD>
        </TR>
</TABLE>
<br/><br/>
<hr>
<TABLE>
    <TR>
        <TD COLSPAN=7 >
            <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>Anotações de
                Enfermagem:</FONT></P>
            <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>P.A PRÉ -</FONT></P>
            <P CLASS="western" ALIGN=LEFT><FONT SIZE=-1>P.A PÓS -</FONT></P>
        </TD>
    </TR>
</TABLE>
<br/><br/>
<hr>
<TABLE >

    <TR>
        <TD >
            <P CLASS="western"><FONT FACE="Serif"><FONT SIZE=1 STYLE="font-size: 8pt">
    <center><b>Checklist</B></CENTER><br>
    Nome
    do paciente ( ) –  Data Nasc.( ) –  RG( ) – N° carteira( )
    -- Validade da carteira( ) – Convênio( ) – Exame Solicitado(
    ) 
    Exame Autorizado( )             </FONT></FONT>
    </P>
    <P CLASS="western"><FONT FACE="Serif"><FONT SIZE=1 STYLE="font-size: 8pt">Médico
        Solicitante( ) – Assinatura Paciente ( )</FONT></FONT></P>
    </TD>
    </TR>
    </CENTER>
</TABLE>
</div>
