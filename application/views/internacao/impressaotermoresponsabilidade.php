<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Termo de Responsabilidade</title>
    </head>
    <style>
        /* Gradient color1 - color2 - color1 */ .hrlegal { border: 0; height: 3px; background: #333;}
    </style>
    <style type="text/css">
        .quebrapagina {
            page-break-before: always;
        }
    </style>

    <body>
        <?= $cabecalho_form ?>
        <hr class="hrlegal">
        <h1 style="text-align:center;text-decoration: underline;">ADMISSÃO DE PACIENTE</h1>
        <div >
            <table style="border: 1px solid;border-radius: 20px;font-size: 8pt;height: 40%;width: 100%;padding: 10px 0px 10px 10px;">
                <tr >
                    <td style="padding:4px 4px 4px 4px;">
                        ATEND Nº: <?= @$paciente[0]->internacao_id; ?>
                    </td>
                    <td style="padding:4px 4px 4px 4px;">
                        PRONT Nº: <?= @$paciente[0]->paciente_id; ?>
                    </td>
                    <td style="padding:4px 4px 4px 4px;">
                        CATEGORIA: <?= @$paciente[0]->convenio; ?>
                    </td>
                    <td style="padding:4px 4px 4px 4px;">
                        ACOMODAÇÃO: <?= @$paciente[0]->leito; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        PACIENTE: <?= @$paciente[0]->nome; ?>
                    </td>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        DT. NASCIMENTO: <?= date("d/m/Y", strtotime(@$paciente[0]->nascimento)); ?>
                    </td>

                </tr>
                <tr>
                    <?
                    $dataFuturo = date("Y-m-d");
                    $dataAtual = @$paciente[0]->nascimento;
                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%Ya %mm %dd');
                    $idade = $teste = $diff->format('%Y');
                    
                    ?>
                    <td colspan="1" style="padding:4px 4px 4px 4px;">
                        IDADE: <?=$idade?> ANO(S)
                    </td>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        PROFISSÃO: <?= @$paciente[0]->profissao; ?> 
                    </td>
                    <td colspan="1" style="padding:4px 4px 4px 4px;">
                        IDENTIDADE: <?= @$paciente[0]->rg; ?> <?= @$paciente[0]->uf_rg; ?>
                    </td>

                </tr>
                <tr>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        ENDEREÇO: <?= @$paciente[0]->logradouro; ?> Nº <?= @$paciente[0]->numero; ?>
                    </td>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        BAIRRO: <?= @$paciente[0]->bairro; ?>
                    </td>


                </tr>
                <tr>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        CIDADE: <?= @$paciente[0]->municio; ?>
                    </td>
                    <?= $codigoUF = $this->utilitario->codigo_uf(@$paciente[0]->codigo_ibge, 'sigla'); ?>
                    <td colspan="1" style="padding:4px 4px 4px 4px;">
                        UF: <?= $codigoUF ?>
                    </td>
                    <td colspan="1" style="padding:4px 4px 4px 4px;">
                        FONE: <?= @$paciente[0]->telefone; ?>
                    </td>


                </tr>

                <tr>
                    <td colspan="4" style="padding:4px 4px 4px 4px;">
                        MÃE: <?= @$paciente[0]->nome_mae; ?>
                    </td>

                </tr>
                <tr>
                    <td colspan="4" style="padding:4px 4px 4px 4px;">
                        CIRURGIA PROPOSTA:  <?= @$paciente[0]->procedimento; ?>
                    </td>

                </tr>
                <tr>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        MÉDICO: <?= @$paciente[0]->medico; ?>
                    </td>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        CRM: <?= @$paciente[0]->conselho; ?>
                    </td>

                </tr>
                <tr>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        DATA DE INTERNAÇÃO:  <?= date("d/m/Y", strtotime(@$paciente[0]->data_internacao)); ?>
                    </td>
                    <td colspan="1" style="padding:4px 4px 4px 4px;">
                        HORA:  <?= date("H:i:s", strtotime(@$paciente[0]->data_internacao)); ?>
                    </td>
                    <td colspan="1" style="padding:4px 4px 4px 4px;">
                        VISTO: _____________________________
                    </td>

                </tr>
                <tr>
                    <td colspan="2" style="padding:4px 4px 4px 4px;">
                        DATA DA SAÍDA: <?= (@$paciente[0]->data_saida != '') ? date("d/m/Y", strtotime(@$paciente[0]->data_saida)) : ''; ?>
                    </td>
                    <td colspan="1" style="padding:4px 4px 4px 4px;">
                        HORA:  <?= (@$paciente[0]->data_saida != '') ? date("H:i:s", strtotime(@$paciente[0]->data_saida)) : ''; ?>
                    </td>
                    <td colspan="1" style="padding:4px 4px 4px 4px;">
                        VISTO: _____________________________
                    </td>

                </tr>

            </table>
        </div>
        <br>

        OBSERVAÇÃO: __________________________________________________________________________
        <br>
        <br>
        <table style="border: 1px solid;border-radius: 20px;font-size: 9pt;height: 50%;width: 100%;">
            <tr>
                <td colspan="2">
                    <div>
                        <p>
                            Declaro que tive a oportunidade de fazer todas as indagações sobre meu tratamento e o procedimento (A) que serei submetido, me sendo prontamente respondidas e esclarecidas todas as minhas dúvidas. 
                        </p>
                        <p>
                            Todavia, tendo em vista que a natureza da prestação dos serviços médicos é de meio, estou ciente dos riscos e que o resultado pode ser o esperado. Também entendi que, a qualquer momento e sem prestar qualquer explicação, poderei revogar este consentimento, antes da realização do procedimento.   
                        </p>
                        <p>
                            Este hospital não se responsabiliza por quaisquer objetos deixados nas acomodações. O (a) responsável declara assumir neste ato e em caráter principal e solidário com o (IOF) proprietário(a) PACIENTE a obrigação de pagar todas as diárias de internação, materiais, medicamentos, procedimentos não coberto pelos convênios, taxa de utilização de sala cirúrgica, gastos de telefone, despesas decorrente de atendimento, diagnóstico médico hospitalar necessários e indispensáveis, incluindo medicamento, matérias, OPMES(Órteses, próteses, matérias) e serviços utilizados por terceiros (radiografia, transfusão de sangue) e que a critério médico forem imprescindíveis para o sucesso do tratamento indicado.   
                        </p>
                        <p>
                            Deixando claro que todos os procedimentos serão cobrados direto do convênio isso é para o caso de ,não autorizado. Em caso de paciente particular o mesmo fica ciente de caso seja necessário será feita a cobrança do diferencial usado na cirurgia e em sua estadia no Hospital IOF. E que o IOF deixa claro e evidente aos PACIENTES que é uma empresa aberta para médicos na especialidade de otorrino fazer a cirurgia no referido hospital mesmo sem nenhum vínculo empregatício do mesmo.   
                        </p>
                        <p style="font-weight: bold">
                            Finalmente, declara ter sido informado a respeito de métodos terapêuticos alternativos e estar atendido em suas dúvidas e questões, através de linguagem clara e acessível. Assim, tendo lido, entendido e aceito as explicações sobre os mais comuns RISCOS E COMPLICAÇÕES deste procedimento, expressa seu pleno consentimento para sua realização cirúrgica e pelos procedimentos administrativos explicados e contidos no 10F.   
                        </p>

                        <br>
                        <br>
                        <br>

                    </div>  
                </td>
            </tr>
            <tr>

                <td style="width: 50%">
                    <? $meses = array('01' => "Janeiro", '02' => "Fevereiro", '03' => "Março", '04' => "Abril", '05' => "Maio", '06' => "Junho", '07' => "Julho", '08' => "Agosto", '09' => "Setembro", '10' => "Outubro", '11' => "Novembro", '12' => "Dezembro"); ?>
                    Fortaleza, <?= date("d"); ?> de <?= $meses[date('m')]; ?> de <?= date("Y"); ?> 
                </td>
                <td>
                    _____________________________________________________
                    <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Assinatura do Paciente Ou Responsável  
                </td>
            </tr>
        </table>
    <pagebreak></pagebreak>
    <h3 style="text-align:center;">HISTÓRICO E EXAME CLÍNICO</h3>
    <? foreach ($historicoantigo as $item) { ?>
    <!--        <p style="">Médico: <?= $item->medico; ?> Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?>
           Procedimento: <?= $item->procedimento; ?> 
        </p>  -->
    <? } ?>

    <? foreach ($historicoexame as $item) { ?>
    <!--        <p style="">Médico: <?= $item->medico; ?> Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?>
       Procedimento: <?= $item->procedimento; ?> 
    </p>  -->
    <? } ?>
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <style>
        td{
          padding: 6px 6px 6px 6px;  
        }
    </style>
    <table border="1" style="width: 100%;border-collapse: collapse;" >
       
        <tr>
            <td>
                CIRURGIÃO  
            </td>
            <td>
                1 AUX: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                2 AUX: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td>
                DIAGNÓSTICO
            </td>
            <td>
                CIRURGIA
            </td>
        </tr>
        <tr>
            <td colspan="2">
                ANESTESIA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                INÍCIO:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                FIM:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                DURAÇÃO:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>

        </tr>
        <tr>
            <td colspan="2">
                DATA DA CIRURGIA:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                INÍCIO:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                FIM: 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                DURAÇÃO: 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>

        </tr>
        <tr>
            <td colspan="2">
                OXIGÊNIO:
            </td>

        </tr>
    </table>
    <h3 style="text-align:center;">DESCRIÇÃO DA CIRURGIA</h3>
    
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <hr style="height: 1px;border: 1px solid">
    <br>
    <p style="text-align: center;">
        ______________________________________________________________
    </p>
    <p style="font-weight: bold;text-align: center;">
       CIRURGIÃO - CRM  
    </p>
</body>
</html>