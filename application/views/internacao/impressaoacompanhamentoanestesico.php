<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Acompanhamento Anestésico</title>
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
        <table style="width: 100%" >
            <tr>
                <td style="font-weight: bold; font-size: 13pt; text-align: center;">
                    FICHA DE <br> ACOMPANHAMENTO ANESTÉSICO
                </td>
                <td style="width: 50%">
                    <table style="width: 100%; font-size: 10pt;border: 1px solid;border-radius: 20px;">
                        <tr>
                            <td colspan="2">
                                Nome: <?= @$paciente[0]->nome; ?> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Data Nasc: <?= (@$paciente[0]->nascimento != '') ? date("d/m/Y", strtotime(@$paciente[0]->nascimento)) : ''; ?>
                            </td>
                            <td>
                                Unidade: <?= @$paciente[0]->unidade; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Leito: <?= @$paciente[0]->enfermaria . " - " . @$paciente[0]->leito; ?>
                            </td>
                            <td>
                                Prontuário: <?= @$paciente[0]->paciente_id; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Convênio: <?= @$paciente[0]->convenio; ?>
                            </td>
                            <td>
                                Atendimento: <?= @$paciente[0]->internacao_id; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <!--<div >-->
        <br>
        <br>
        <style>
            .tdEspaco { 
                padding: 0px 6px 15px 6px;  
            }
        </style>
        <table style="border-spacing: 0px;border-collapse: collapse; font-size: 6pt; width: 100%;"border="1">
            <?
            $nascimento = new DateTime($paciente[0]->nascimento);
            $atual = new DateTime(date("Y-m-d"));

            // Resgata diferença entre as datas
            $dateInterval = $nascimento->diff($atual);
            ?>
            <tr >
                <td class="tdEspaco">
                    DATA: <?= date("d/m/Y"); ?>
                </td>
                <td class="tdEspaco">
                    IDADE: <?= @$dateInterval->y; ?> Anos
                </td>
                <td class="tdEspaco">
                    SEXO: <?= @$paciente[0]->sexo; ?>
                </td>
                <td class="tdEspaco">
                    PESO: 
                </td>
                <td class="tdEspaco">
                    ALTURA: 
                </td>
            </tr>
            <tr >
                <td class="tdEspaco">
                    PRESSÃO ARTERIAL: 
                </td>
                <td class="tdEspaco">
                    PULSO: 
                </td>
                <td class="tdEspaco">
                    RESPIRAÇÃO: 
                </td>
                <td class="tdEspaco">
                    TEMPERATURA: 
                </td>
                <td class="tdEspaco">
                    UREIA: 
                </td>
            </tr>
        </table>
        <table style="border-spacing: 0px;border-collapse: collapse; font-size: 6pt; width: 100%"border="1">
            <tr >
                <td rowspan="2" class="tdEspaco">
                    TIPO SANGUÍNIO: 
                </td>
                <td class="tdEspaco">
                    HEMÁCIAS: 
                </td>
                <td class="tdEspaco">
                    HEMOGLOBINA: 
                </td>
                <td class="tdEspaco">
                    HEMATÓCRITO: 
                </td>
                <td class="tdEspaco">
                    GLICEMIA: 
                </td>
                <td rowspan="2" class="tdEspaco">
                    OUTROS:
                </td>
            </tr>
            <tr >
                <td class="tdEspaco" colspan="4">
                    &nbsp;
                </td>

            </tr>
            <tr >
                <td class="tdEspaco">
                    TIPO SANGUÍNIO: 
                </td>
                <td class="tdEspaco">
                    HEMÁCIAS: 
                </td>
                <td class="tdEspaco">
                    HEMOGLOBINA: 
                </td>
                <td class="tdEspaco">
                    HEMATÓCRITO: 
                </td>
                <td class="tdEspaco">
                    GLICEMIA: 
                </td>
                <td class="tdEspaco">
                    OUTROS:
                </td>
            </tr>
            <tr >
                <td class="tdEspaco" colspan="3">
                    AP.RESPIRATÓRIO: 
                </td>
                <td class="tdEspaco" colspan="2">
                    ASMA: 
                </td>
                <td class="tdEspaco">
                    BRONQUITE: 
                </td>

            </tr>
            <tr >
                <td class="tdEspaco" colspan="3">
                    AP.CIRCULATÓRIO: 
                </td>
                <td class="tdEspaco" colspan="3">
                    ELETROCARDIOGRAMA: 
                </td>
            </tr>
            <tr >
                <td class="tdEspaco" colspan="2">
                    AP.DIGESTIVO: 
                </td>
                <td class="tdEspaco" colspan="1">
                    DENTES: 
                </td>
                <td class="tdEspaco" colspan="1">
                    PESCOÇO: 
                </td>
                <td class="tdEspaco" colspan="2">
                    AP.URINÁRIO: 
                </td>
            </tr>
            <tr >
                <td class="tdEspaco" colspan="2">
                    ESTADO MENTAL: 
                </td>
                <td class="tdEspaco" colspan="1">
                    ATARAXICOS: 
                </td>
                <td class="tdEspaco" colspan="1">
                    CORTICÓIDES: 
                </td>
                <td class="tdEspaco" colspan="1">
                    ALERGIA: 
                </td>
                <td class="tdEspaco" colspan="1">
                    HIPOTENSORES: 
                </td>
            </tr>
            <tr >
                <td class="tdEspaco" colspan="3">
                    DIAGNÓSTICO PRÉ-OPERATÓRIO: 
                </td>
                <td class="tdEspaco" colspan="2">
                    ESTADO FÍSICO: 
                </td>
                <td class="tdEspaco" colspan="1">
                    RISCOS: 
                </td>
                
            </tr>
            <tr >
                <td class="tdEspaco" colspan="2">
                    ANESTESIAS ANTERIORES: 
                </td>
                <td class="tdEspaco" colspan="2">
                    MEDICAÇÃO PRÉ-ANESTÉSICA: 
                </td>
                <td class="tdEspaco" colspan="1">
                    HORAS: 
                </td>
                <td class="tdEspaco" colspan="1">
                    EFEITO: 
                </td>
                
            </tr>
            <tr >
                <td class="tdEspaco" colspan="2">
                    &nbsp;
                </td>
                <td class="tdEspaco" colspan="2">
                    &nbsp;
                </td>
                <td class="tdEspaco" colspan="1">
                    &nbsp;
                </td>
                <td class="tdEspaco" colspan="1">
                    &nbsp;
                </td>
                
            </tr>
            <tr >
                <td class="tdEspaco" colspan="6">
                   HORÁRIO
                </td>
            </tr>
        </table>
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

</body>
</html>