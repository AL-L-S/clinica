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
            <td width="170px"></td>
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
            padding: 10px;
        }


    </style>
    <br>
    <br>
    <br>
    <table style="width: 100%; font-size: 10pt;">
        <tr>
            <td class="tdpadding" style="width: 100%">
                FUMANTE:(S/N)______&nbsp;&nbsp; HÁ ______ ANOS
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                FEBRE:(S/N)______&nbsp;&nbsp; HÁ ______ DIAS
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                TOSSE: (S/N)______&nbsp;&nbsp; SECA ( ) PRODUTIVA ( )
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                DISPNEIA: (S/N)______&nbsp;&nbsp; 
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                DOR: (S/N)______&nbsp;&nbsp; LADO DIREITO ( ) LADO ESQUERDO ( )
            </td>
        </tr>
        <tr>
            <td class="tdpadding" style="width: 100%">
                TRAUMA: (S/N)______&nbsp;&nbsp; LADO DIREITO ( ) LADO ESQUERDO ( )
            </td>
        </tr>

    </table>

</div>












