<meta charset="UTF-8">
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>
    <table>
        <td>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <?= @$cabecalho_config; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 50%" colspan="2"><b><font size = -1><?= $paciente['0']->nome; ?></b></td>
                        <td ><font size = -1><?= $exame[0]->razao_social; ?></td>
                    </tr>
                    <tr>
                        <td ><font size = -1>Formulário: <?= $exame[0]->ambulatorio_guia_id; ?></td>
                        <td ><font size = -1>Data: <?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?></td>
                        <td ><font size = -1>Informações: <?= $exame[0]->telefoneempresa; ?></td>
                    </tr>
                    <tr>
                        <? //echo '<pre>'; var_dump($exame); die;?>
                        <td colspan="2"><font size = -1>Previsão de Entrega: <?= ($exame[0]->data_entrega != '') ? date("d/m/Y", strtotime($exame[0]->data_entrega)) : ''; ?>, a partir das 16h</td>
                        <td ><font size = -1>Agradecemos a sua preferência</td>
                    </tr>

                </tbody>
            </table>
        </td>
    </table>
    <table style="width: 100%">
        <tr>
            <td></td>
            <td colspan="1"><font size = -1>Exame(s):<b> <?= $exame[0]->procedimento; ?></b></td>
            <td ><font size = -1>
                <b>Resultado: www.clinicavaleimagem.com.br/ </b><br>
                Usuario:&nbsp;<b><?= $paciente['0']->paciente_id ?>&nbsp;</b>Senha: &nbsp;<b><?= $exames['0']->agenda_exames_id ?></b>
            </td>
        </tr>
    </table>
    <hr>
    <!--<br>-->
    <table style="width: 100%;text-align: center;">
        <tr>
            <td>
                <!--<h4 style="text-align: center;">-->
                <span style="font-weight: bold"> Sistema de Controle de Clínicas</span> <br>
                <span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span>
                <!--</h4>-->  
            </td>
        </tr>
    </table>
    <hr>
    <?
    foreach ($exames as $item) :
        if ($item->grupo == $exame[0]->grupo) {
            $exame_id = $item->agenda_exames_id;
            $dataatualizacao = $item->data_autorizacao;
            $inicio = $item->inicio;
            $agenda = $item->agenda;
            $operador_autorizacao = $item->operador;
            ?>     
            <?
        }
    endforeach;
    ?>

    <table style="width: 100%; font-size: 11pt;">
        <tr>
            <td>
                Agenda...: <?= $exame[0]->medico_agenda; ?>  - <?= $exame[0]->medico; ?>
            </td>
            <td>
                <span style="font-weight: bold; font-size: 14pt;">Formulário(AN): <?= $exame[0]->ambulatorio_guia_id; ?></span> 
            </td>
        </tr>
        <tr>
            <td>
                Paciente.: <span style="font-weight: bold"><?= $paciente[0]->paciente_id; ?>  - <?= $paciente[0]->nome; ?></span>
            </td>
            <td>
                Data: <?= date("d/m/Y", strtotime($exame[0]->data)); ?>
            </td>
        </tr>
        <tr>
            <td>
                Endereço: <?= $paciente[0]->logradouro; ?>  - <?= $paciente[0]->numero; ?> - <?= $paciente[0]->bairro; ?>
            </td>
            <td>
                RG: <?= $paciente[0]->rg; ?>
            </td>
        </tr>
        <tr>
            <td>
                Telefones: <?= $paciente[0]->telefone; ?>  - <?= $paciente[0]->celular; ?> - <?= $paciente[0]->whatsapp; ?>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                Sexo:  <span style="font-weight: bold"><?= $paciente[0]->sexo; ?></span>
            </td>
            <td>
                CPF......: <?= ($paciente[0]->cpf_responsavel_flag == 'f') ? $paciente[0]->cpf : ''; ?>
            </td>
        </tr>
        <tr>

            <td>
                Idade.......: <span style="font-weight: bold"> <?= $teste; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    Nasc.: <?= ($paciente['0']->nascimento != '') ? date("d/m/Y", strtotime($paciente['0']->nascimento)) : ''; ?>
                </span>
            </td>
            <td>
                <span style="font-weight: bold">Chegada:  <?= substr($dataatualizacao, 10, 9); ?></span>
            </td>
        </tr>
        <tr>
            <td>
                Convênio.: <span style="font-weight: bold"> <?= $exame[0]->convenio; ?> </span>
            </td>
            <td>
                Sequência:
            </td>
        </tr>
        <tr>
            <td>
                Carteira....: <?= $paciente[0]->convenionumero; ?>
            </td>
            <td>
                Autorização: <?= $exame[0]->autorizacao; ?>
            </td>
        </tr>
        <tr>
            <td>
                Solicitante: <?= $exame[0]->medico_solicitante; ?>  - <?= $exame[0]->medicosolicitante; ?>
            </td>
            <td>
                Validade: <? //= $exame[0]->agenda_exames_id;                  ?>
            </td>
        </tr>
        <tr>
            <td>
                Solicit(CPF): 
            </td>
            <td>
                Ficha Dia: 
            </td>
        </tr>
        <tr>
            <td>
                Atendente...: <?= $exame[0]->atendente; ?> 
            </td>
            <td>
                CPF Responsável: <?= ($paciente[0]->cpf_responsavel_flag == 't') ? $paciente[0]->cpf : ''; ?>
            </td>
        </tr>
        <tr>
            <td>
                Responsável: <? //= ($paciente[0]->nome_mae != '')? $paciente[0]->nome_mae : $paciente[0]->nome_pai ;                ?>
            </td>
            <td>
                Último Atendimento: <?= (count($exameanterior) > 0) ? date("d/m/Y", strtotime($exameanterior[0]->data)) : ''; ?>
            </td>
        </tr>
    </table>
    <hr>
    <!--<br>-->
    <table style="width: 100%; font-size: 11pt;">
        <tr>
            <td >Código</td>
            <td >Descrição do item</td>
            <td >Quantidade</td>
            <td >Vl. Unitário</td>
            <td >Vl. Total</td>
        </tr>
        <?
        $valor_total_ficha = 0;
        $desconto_total = 0;
        $cartao_total = 0;
        foreach ($formapagamento as $value) {
            $data[$value->nome] = 0;
            $datacredito[$value->nome] = 0;
            $numerocredito[$value->nome] = 0;
            $descontocredito[$value->nome] = 0;
            $numero[$value->nome] = 0;
            $desconto[$value->nome] = 0;
        }

//        var_dump($exames); die;
        foreach ($exames as $item) :
            $u = 0;



            if ($item->grupo == $exame[0]->grupo) {
                foreach ($formapagamento as $value) {
                    if ($item->formadepagamento == $value->nome) {
                        $data[$value->nome] = $data[$value->nome] + $item->valor1;
                        $numero[$value->nome] ++;
                        if ($u == 0) {
                            $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                        }
                        if ($item->desconto != '') {
                            $u++;
                        }
                    }
                }
                foreach ($formapagamento as $value) {
                    if ($item->formadepagamento2 == $value->nome) {
                        $data[$value->nome] = $data[$value->nome] + $item->valor2;
                        $numero[$value->nome] ++;
                        if ($u == 0) {

                            $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                        }
                        if ($item->desconto != '') {
                            $u++;
                        }
                    }
                }
                foreach ($formapagamento as $value) {
                    if ($item->formadepagamento3 == $value->nome) {
                        $data[$value->nome] = $data[$value->nome] + $item->valor3;
                        $numero[$value->nome] ++;
                        if ($u == 0) {

                            $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                        }
                        if ($item->desconto != '') {
                            $u++;
                        }
                    }
                }
                foreach ($formapagamento as $value) {
                    if ($item->formadepagamento4 == $value->nome) {
                        $data[$value->nome] = $data[$value->nome] + $item->valor4;
                        $numero[$value->nome] ++;
                        if ($u == 0) {

                            $desconto[$value->nome] = $desconto[$value->nome] + $item->desconto;
                        }
                        if ($item->desconto != '') {
                            $u++;
                        }
                    }
                }


                $valor_total_ficha = $valor_total_ficha + ($item->valor_total * $item->quantidade);
                $desconto_total = $desconto_total + $item->desconto;
                ?>
                <tr>

                    <td ><?= $item->codigo ?></td>
                    <td ><?= $item->procedimento ?></td>
                    <td ><?= $item->quantidade ?></td>
                    <td >R$<?= number_format($item->valor_total, 2, ',', '.') ?></td>
                    <td >R$<?= number_format($item->valor_total * $item->quantidade, 2, ',', '.') ?></td>
                    <!--<td ><?= $item->convenio ?></td>-->

                </tr>
                <?
            }
        endforeach;
        ?>

    </table>
    <hr>
    <table style="width: 89%; font-size: 11pt; text-align: right; font-weight: bolder">
        <tr>
            <td colspan="5">R$<?= number_format($valor_total_ficha, 2, ',', '.'); ?></td>
        </tr>

    </table>
    <hr>
    <table style="width: 100%; font-size: 9pt;">
        <tr>
            <td colspan="5">Valores--> Br: R$ <?= number_format($valor_total_ficha, 2, ',', '.'); ?> 
                Acrés: R$ 0,00 Desc: R$ <?= number_format($desconto_total, 2, ',', '.'); ?> 
                Líqui: R$ <?= number_format($valor_total_ficha, 2, ',', '.'); ?>


                <?
//                var_dump($numero);
//                die;
                foreach ($formapagamento as $value) {
                    if ($numero[$value->nome] > 0) {
                        ?>
                        <?= $value->nome ?>: R$ <?= number_format($data[$value->nome], 2, ',', '.'); ?>

                        <?
                    }
                }
                ?>

            </td>
        </tr>

    </table>
    <hr>

    <span style="font-size: 10pt;">Outro(s) procd(s).:</span>

    <table style="font-size: 9pt;">
        <?
        foreach ($exames as $item) :
            if ($item->grupo != $exame[0]->grupo) {
                ?>
                <tr>
                    <td ><?= $item->codigo ?>-</td>
                    <td ><?= $item->procedimento ?>-</td>
                    <td ><?= $item->convenio ?>-</td>
                    <!--<td ><?= $item->autorizacao ?>-</td>-->
                    <td ><?= $item->medicosolicitante ?></td>
                </tr>
                <?
            }
        endforeach;
        ?>
        </tbody>
    </table>
    <hr>
    <span style="font-size: 10pt;">Observações: <?= $exame[0]->observacoes; ?></span>
    <style>

        .tdpadding{
            padding: 5px;
        }


    </style>
    <br>
    <br>
    <br>
    <style type="text/css">
        .quebrapagina {
            page-break-before: always;
        }
    </style>
    <pagebreak></pagebreak>
    <br class="quebrapagina">
    <?= @$cabecalho_config; ?>
   
    <!--<br>-->
    <table style="width: 100%;text-align: center; font-size: 10pt">
        <tr>
            <td>
                <!--<h4 style="text-align: center;">-->
                <span style="font-weight: bold; font-size: 10pt">QUESTIONÁRIO - ACOMPANHANTE RESSONÂNCIA MAGNÉTICA</span> <br>
                <span style="font-weight: normal; font-size: 10pt">PARA O ACOMPANHAMENTO DO PACIENTE É NECESSÁRIO QUE TODAS AS PERGUNTAS SEJAM RESPONDIDAS COM EXATIDÃO</span>
                <!--</h4>-->  
            </td>
        </tr>
    </table>
   
    <table style="width: 100%; font-size: 10pt;padding: 14px;">
        <tr>
            <td class="tdpadding" style="width: 100%">
                ACOMPANHANTE:_______________________________________________________________________  FORM: <?= $exame[0]->ambulatorio_guia_id; ?>&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                IDADE:___________________________  TELEFONE:____________________________________
            </td>
        </tr>     
    </table>
    <br>
    <table align="center" width="100%" style="text-align:center; border-collapse: collapse; font-size:10pt" border="1">
        <tr>
        <th>DATA DO EXAME</th>
        <th>HORÁRIO PREVISTO</th>
        <th>HORÁRIO DE CHEGADA</th>
        </tr>
        <tr>
        <td><?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?></td>
        <td><?= $exame[0]->inicio; ?></td>
        <td><?= substr($dataatualizacao, 10, 9); ?></td>
        </tr>
    </table> <br>
    <table width="100%" style="font-size: 10pt">
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;<b>1.  TEM MARCAPASSO CARDÍACO, DESFIBRILADOR OU CARDIOVERTER?</b></td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;<b>2.  FEZ SUBSTITUIÇÃO DE "VÁLVULAS" CARDÍACAS?</b></td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;<b>3.  FEZ CIRURGIA CEREBRAL (ANEURISMA) QUE USE CLIP METÁLICO?</b></td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;<b>4.  TEM PRÓTESE/IMPLANTE NO OUVIDO (COCLEAR, ESTRIBO) OU APARELHO AUDITIVO?</b></td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;5.  TRABALHA OU TRABALHOU COM METAIS?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;6.  TEM OU TEVE FRAGMENTOS METÁLICOS NOS OLHOS?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;7.  JÁ SOFREU FERIMENTO COM ESTILHAÇO DE METAL OU ARMA DE FOGO?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;8.  TEM "PUMPS" OU NEUROESTIMULADORES IMPLANTADOS?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;9.  TEM ALGUM COMPONENTE ARTIFICIAL NO CORPO?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;10. TEM PRÓTESE DENTÁRIA, APARELHO ORTODÔNTICO OU PERUCA?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;11. TEM IMPLANTE (PRÓTESE DE MAMA OU PÊNIS)?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;12. TEM D.I.U (DISPOSITIVO INTRAUTERINO)?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;13. ESTÁ GRAVIDA OU AMAMENTANDO?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;14. TEM TATUAGEM/PIERCING/AGULHA DE ACUPUNTURA?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;15. TEM FOBIA A AMBIENTES FECHADOS?</td><td> (SIM)(NÃO)</td></tr>
    </table> <br>
    <b><span style="font-size: 10pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OBS.: CASO POSITIVO EM PELO MENOS UMA DAS QUATRO PRIMEIRAS QUESTÕES, O ACOMPANHANTE NÃO PODE ENTRAR NA SALA DE RESSONÂNCIA.</span></b> 
    <br><br><br><br>
    <table width="100%">
        <tr>
            <td>
             &nbsp;&nbsp;&nbsp;&nbsp;   _______________________________________________ <br>
             &nbsp;&nbsp;&nbsp;&nbsp;   Assinatura do acompanhante do paciente
            </td>
            <td>
                Limoeiro, <?= date("d/m/Y"); ?>
            </td>

        </tr>
    </table>
</div>
    <br>
    <br>
    <br>
    <style type="text/css">
        .quebrapagina {
            page-break-before: always;
        }
    </style>
    <pagebreak></pagebreak>
    <br class="quebrapagina">

    <?= @$cabecalho_config; ?>
    
    
    <table style="width: 100%;text-align: center; font-size: 9pt">
        <tr>
            <td>
                
                <span style="font-weight: bold; font-size: 9pt">QUESTIONÁRIO - RESSONÂNCIA MAGNÉTICA</span> <br>
                <!--<span style="font-weight: normal">PARA O ACOMPANHAMENTO DO PACIENTE É NECESSÁRIO QUE TODAS AS PERGUNTAS SEJAM RESPONDIDAS COM EXATIDÃO</span>-->
                  
            </td>
        </tr>
    </table>
    <br>
    <table><span style="font-size: 9pt;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O seu médico julgou que este exame é necessário para sua avaliação, podendo necessitar da injeção de constraste na veia. Como ocorre com qualquer tipo de medicamento, esse contraste pode, em raras ocasiões, provocar reações adversas como, por exemplo, alergia. Essas reações são, na grande maioria das vezes, leves e de fácil tratamento.<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No entanto, embora o risco seja <b>muito pequeno</b>, reações mais graves e até mesmo fatais também podem ocorrer.<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apesar de ser impossível prever com certeza quem terá reação ao contraste, algumas informações podem alertar para uma situação de risco aumentado. Por isso, é necessário que todas as perguntas sejam respondidas com exatidão.</span>
    </table>
    
    <table style="width: 100%; font-size: 8pt;padding: 14px;">
        <tr>
            <td class="tdpadding" style="font-size: 8pt; width: 100%">
                PACIENTE: <?= $paciente['0']->nome; ?> FORM: <?= $exame[0]->ambulatorio_guia_id; ?>&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="font-size: 8pt; width: 100%">
                IDADE: <?= $teste; ?>&nbsp;&nbsp;&nbsp;&nbsp; TELEFONE: <?= $paciente[0]->telefone; ?>  - <?= $paciente[0]->celular; ?> - <?= $paciente[0]->whatsapp; ?>&nbsp;&nbsp;&nbsp;&nbsp; CONVÊNIO: <?= $exame[0]->convenio; ?>
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="font-size: 8pt; width: 100%">
                MÉDICO SOLICITANTE:  <?= $exame[0]->medico_solicitante; ?>  - <?= $exame[0]->medicosolicitante; ?> &nbsp;&nbsp;&nbsp; PACIENTE INTERNADO?   (SIM)(NÃO)&nbsp;&nbsp;  EXAME: <?= $exame[0]->procedimento; ?>
            </td>
        </tr>
        
        <tr>
            <td class="tdpadding" style="font-size: 8pt; width: 100%">
                SINAIS E SINTOMAS:_____________________________________________________________________________________
            </td>
        </tr>
    </table>
    
    

    
    <table align="center" width="100%" style="text-align:center; border-collapse: collapse" border="1">
        <tr>
        <th style="font-size: 8pt;">DATA DO EXAME</th>
        <th style="font-size: 8pt;">HORÁRIO PREVISTO</th>
        <th style="font-size: 8pt;">HORÁRIO DE CHEGADA</th>
        </tr>
        <tr>
        <td style="font-size: 8pt;"><?= ($exame[0]->data != '') ? date("d/m/Y", strtotime($exame[0]->data)) : ''; ?></td>
        <td style="font-size: 8pt;"><?= $exame[0]->inicio; ?></td>
        <td style="font-size: 8pt;"><?= substr($dataatualizacao, 10, 9); ?></td>
        </tr>
        <tr>
        <th style="font-size: 8pt;">JEJUM (SIM)(NÃO) HORAS</th>
        <th style="font-size: 8pt;">PESO(KG)</th>
        <th style="font-size: 8pt;">INFORMADO POR</th>
        </tr>
        <tr height="18px">
        <td></td>
        <td></td>
        <td></td>
        </tr>
    </table>
     <table width="100%"style="font-size: 8pt">
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;<b>1.  TEM MARCAPASSO CARDÍACO, DESFIBRILADOR OU CARDIOVERTER?</b></td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;<b>2.  FEZ SUBSTITUIÇÃO DE "VÁLVULAS" CARDÍACAS?</b></td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;<b>3.  FEZ CIRURGIA CEREBRAL (ANEURISMA) QUE USE CLIP METÁLICO?</b></td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;<b>4.  TEM PRÓTESE/IMPLANTE NO OUVIDO (COCLEAR, ESTRIBO) OU APARELHO AUDITIVO?</b></td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;5.  FAZ HEMODIÁLISE OU DIÁLISE PERITONEAL?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;6.  TEM INSUFICIÊNCIA RENAL?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;7.  TRABALHA OU TRABALHOU COM METAIS?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;8.  TEM OU TEVE FRAGMENTOS METÁLICOS NOS OLHOS?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;9.  JÁ SOFREU FERIMENTO COM ESTILHAÇO DE METAL OU ARMA DE FOGO?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;10.  TEM "PUMPS" OU NEUROESTIMULADORES IMPLANTADOS?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;11.  TEM ALGUM COMPONENTE ARTIFICIAL NO CORPO?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;12. TEM PRÓTESE DENTÁRIA, APARELHO ORTODÔNTICO OU PERUCA?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;13. TEM IMPLANTE (PRÓTESE DE MAMA OU PÊNIS)?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;14. TEM D.I.U (DISPOSITIVO INTRAUTERINO)?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;15. ESTÁ GRAVIDA OU AMAMENTANDO?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;16. TEM TATUAGEM/PIERCING/AGULHA DE ACUPUNTURA?</td><td>(SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;17. TEM FOBIA A AMBIENTES FECHADOS?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;18. TEM ALERGIA? A QUÊ?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;19. JÁ FEZ ALGUM TRATAMENTO QUIMIOTERÁPICO OU RADIOTERÁPICO?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;20. APRESENTA ANOMALIAS DE NASCIMENTO?</td><td> (SIM)(NÃO)</td></tr>
        <tr><td class="tdpadding" style="font-size: 8pt; width: 100%">&nbsp;&nbsp;&nbsp;&nbsp;21. JÁ REALIZOU ALGUMA CIRURGIA DA REGIÃO A SER EXAMINADA?</td><td> (SIM)(NÃO)</td></tr>
     </table><br>
    <b><span style="font-size: 8pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OBS.: CASO POSITIVO EM PELO MENOS UMA DAS QUATRO PRIMEIRAS QUESTÕES, O EXAME ESTÁ CONTRA INDICADO.</span></b> 
    <br><br>
    <table width="100%" style="font-size: 9pt">
        <tr>
            <td>
             &nbsp;&nbsp;&nbsp;&nbsp;   _______________________________________________________________________<br>
             &nbsp;&nbsp;&nbsp;&nbsp;   Assinatura do paciente ou do representante legal
            </td>
            <td>
                Limoeiro, <?= date("d/m/Y"); ?>
            </td>

        </tr>
    </table>






