<meta charset="UTF-8">
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    $idade = $diff->format('%Y');
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
                Agenda...: <?= $exame[0]->crm_medico; ?>  - <?= $exame[0]->medico; ?>
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
                Solicitante: <?= $exame[0]->crm_solicitante; ?>  - <?= $exame[0]->medicosolicitante; ?>
            </td>
            <td>
                Validade: <? //= $exame[0]->agenda_exames_id;                                ?>
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
                Responsável: <? //= ($paciente[0]->nome_mae != '')? $paciente[0]->nome_mae : $paciente[0]->nome_pai ;                              ?>
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
            padding-left: 20px;
            padding-bottom: 15px;
            padding-right: 20px;
            /*padding-top: 15px;*/
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
    <!-- Cabaçalho da clinica configurável-->
    <?= @$cabecalho_config; ?>
    <table style="width: 100%; text-align: center; font-size: 10pt">
        <tr>
            <td>
                <span> QUESTIONÁRIO / TERMO DE CONSENTIMENTO INFORMADO PARA EXAMES RADIOLÓGICOS CONTRASTADOS</span>
            </td>
        </tr>
    </table>
    <br>    
    <table style="width: 100%; text-align: center;font-weight: bolder; font-size: 10pt">
        <tr>
            <td>
                <span> INFORMAÇÕES IMPORTANTES </span>
            </td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; text-align: justify; font-size: 10pt">
        <tr>
            <td>
                <span> Amamentação e gravidez (confirmada ou suspeita) deverão ser comunicadas ao médico radiologista ou ao técnico em radiologia antes da realização do exame.
                    O seu médico julgou que este exame é necessário para sua avaliação, podendo necessitar da injeção na veia e/ou ingestão de um contraste à base de IODO. Como ocorre com qualquer tipo de medicamento, esse contraste pode, em raras ocasiões, provocar reações adversas como, por exemplo, alergia. Essas reações são, na grande maioria das vezes, leves e de fácil tratamento. No entanto, embora o risco seja muito pequeno, reações mais graves e até mesmo fatais também podem ocorrer.
                    Apesar de ser impossível prever com certeza quem terá reação ao contraste, algumas informações podem alertar para uma situação de risco aumentado. Por isso, é necessário que todas as perguntas sejam respondidas com exatidão. </span>
            </td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; text-align: justify; font-size: 10pt">
        <tr>
            <td class="tdpadding">
                PACIENTE: <?= $paciente[0]->nome ?>
            </td>
            <td class="tdpadding">
                FORM: <?= $exame[0]->ambulatorio_guia_id ?>
            </td>
        </tr>
        <tr>
            <td class="tdpadding">
                PESO:_____ IDADE: <?= $idade ?>
            </td>

            <td class="tdpadding">
                EXAME: <?= $exame[0]->procedimento ?>
            </td>
            <td class="tdpadding">
                DATA: <?= date("d/m/Y", strtotime($exame[0]->data)); ?>
            </td>
        </tr>
    </table>
    <br>    
    <table style="width: 100%; text-align: justify; font-size: 10pt">
        <tr>
            <td class="tdpadding" style="width: 50%">
                1. Quando foi a última refeição ou <br> ingestão de líquidos? Às_______horas
            </td>
            <td class="tdpadding">
                9. Você é diabético? ____SIM ___NÃO. Está tomando Glicofage ou Glucoformin?
            </td>
        </tr>
        <tr>
            <td class="tdpadding">
                2. Apresenta algum tipo de alergia? ____SIM ______NÃO
            </td >
            <td class="tdpadding">
                10. Tem problema de coração (insuficiência cardíaca, infarto, angina, arritmia ou palpitação) ____SIM _____NÃO
            </td>
        </tr>
        <tr>
            <td class="tdpadding">
                3. Já utilizou contraste à base de IODO em algum exame (tomografia, urografia
                excretora, cateterismo cardiaco, doença arteriografia, etc.)? ____ SIM ____ NÃO
                Apresentou alguma reação alérgica nessa aplicação? ____ SIM ____ NÃO 
            </td>
            <td class="tdpadding">
                11. Tem insuficiência renal ou outro problema nos rins? ____ SIM ____ NÃO <br>
                Faz diálise?  ____ SIM ____ NÃO
            </td>
        </tr>
        <tr>
            <td class="tdpadding">
                4. Já usou algum remédio que fez empolar o corpo, inchar os ou fechar a garganta? ____ SIM ____ NÃO
            </td>
            <td class="tdpadding">
                12. Tem problema de tireoide ou alguma doença grave? ____ SIM ____ NÃO 
            </td>
        </tr>
        <tr>
            <td class="tdpadding">
                5. Tem alergia a frutos do mar, peixe, camarão, agrião ou alimentos em conserva? ____ SIM ____ NÃO 
            </td>
            <td class="tdpadding">
                13. Já fez alguma cirurgia? ____ SIM ____ NÃO 
            </td>
        </tr>
        <tr>
            <td class="tdpadding">
                6. Tem alergia de pele (urticária, coceira)? ____ SIM ____ NÃO 
            </td>
            <td class="tdpadding">
                14. Já fez radioterapia ou quimioterapia? ____ SIM ____ NÃO 
            </td>
        </tr>
        <tr>
            <td class="tdpadding">
                7. Tem asma ou bronquite?  ____ SIM ____ NÃO 
            </td>
            <td class="tdpadding">
                15. Você é fumante?  ____ SIM ____ NÃO 
            </td>
        </tr>
        <tr>
            <td class="tdpadding">
                8. Já usou bombinha? ____ SIM ____ NÃO  
            </td>
            <td class="tdpadding">
                16. Por que você vai fazer esse exame? ____________________________________________ <br>
                ____________________________________________<br>
                ____________________________________________<br>
                ____________________________________________<br>
                ____________________________________________<br>
            </td>
        </tr>

    </table>
    <table style="width: 100%; font-size: 10pt">
        <tr>
            <td colspan="2">
                AUTORIZAÇÃO:
                Li as informações acima, declaro estar ciente das possíveis complicações inerentes ao procedimento e autorizo o uso de contraste para realização do exame radiológico.
            </td>

        </tr>
        <tr>
            <td>
                _______________________________________________________________ <br>
                Nome do paciente ou Representante Legal
            </td>
            <td>
                RG_____________________
            </td>

        </tr>
        <tr>
            <td>
                _______________________________________________________________ <br>
                Assinatura do paciente ou do Representante Legal
            </td>
            <td>
                Limoeiro, <?= date("d/m/Y"); ?>
            </td>

        </tr>
    </table>




</div>












