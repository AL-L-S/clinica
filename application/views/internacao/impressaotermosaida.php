<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Termo de Saída</title>
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
        <? //= $cabecalho_form ?>
        <!--<hr class="hrlegal">-->
        <!--<h1 style="text-align:center;text-decoration: underline;">ADMISSÃO DE PACIENTE</h1>-->

        <table style="font-size: 15pt;width: 100%; font-family: Times New Roman; font-weight: bold;">
            <tr >
                <td style="text-align: center;">
                    DESLIGAMENTO 
                </td>
            </tr>

        </table>

        <table style="font-size: 13pt;height: 30%;width: 100%; font-family: Times New Roman;border-spacing: 30px;">

            <tr>
                <td colspan="2" >
                    Nome: <?= @$paciente[0]->nome; ?>
                </td>
            </tr>

            <?
            $dataFuturo = date("Y-m-d");
            $dataAtual = @$paciente[0]->nascimento;
            $date_time = new DateTime($dataAtual);
            $diff = $date_time->diff(new DateTime($dataFuturo));
            $teste = $diff->format('%Ya %mm %dd');
            $idade = $teste = $diff->format('%Y');
            ?>
            <tr>
                <td colspan="1" >
                    Data de Internação:  <?= date("d/m/Y", strtotime(@$paciente[0]->data_internacao)); ?>
                </td>
                <td colspan="1" >
                    Data de Saída:  <?= (@$paciente[0]->data_saida != '') ? date("d/m/Y", strtotime(@$paciente[0]->data_saida)) : ''; ?>
                </td>
            </tr>        
            <tr>
                <td colspan="2" >
                    Motivo: Graduação (&nbsp;&nbsp;&nbsp;)  Alta a pedido (&nbsp;&nbsp;&nbsp;)  Outros motivos (&nbsp;&nbsp;&nbsp;)

                </td>

            </tr>        
            <tr>
                <td colspan="2" >
                    Qual?______________________________________________________________________________________ <br>
                    ___________________________________________________________________________________________

                </td>

            </tr>        
            <tr>
                <td colspan="2" >
                    Parecer do Conselheiro:__________________________________________________________________ <br>
                    ___________________________________________________________________________________________
                </td>

            </tr>        
            <tr>
                <td colspan="2" >
                    <p>
                        Declaro estar retirando da Sede do Instituto Volta Vida, todos os meus pertences e que o mesmo não se responsabiliza por nada referente a minha pessoa.
                        Declaro ainda estar me desligando em perfeitas condições físicas, isentando o Instituto Volta Vida de qualquer responsabilidade civil ou criminal a esse respeito.
                    </p>
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    Li e Concordei:
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;font-weight: bold;font-size: 13pt;">
                    _____________________________________ <br>
                    Ass: do residente (interno)
                </td>
            </tr>
            <tr>
                <td colspan="1" style="text-align: center;font-size: 13pt;">
                    _____________________________________ <br>
                    Conselheiro
                </td>
                <td colspan="1" style="text-align: center;font-size: 13pt;">
                    _____________________________________ <br>
                    Responsável
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Testemunhas:
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    ____________________________________ <br>
                    ____________________________________
                </td>
            </tr>



        </tr>


    </table>


<pagebreak></pagebreak>

<table  style="width: 100%;border-collapse: collapse;" >


    <tr>
        <td style="text-align: left; font-family: Arial;font-size: 10pt;">
            Fortaleza, <?= date("d") ?> de <?= $this->utilitario->retornarNomeMes(date("m")); ?> de <?= date("Y") ?>
        </td>

    </tr>


</table>
<table style="font-size: 15pt;width: 100%; font-family: Times New Roman; font-weight: bold;">
    <tr >
        <td style="text-align: center;">
            RELATORIO DE ALTA 
        </td>
    </tr>

</table>
<p>
    (A primeira via ficará com o paciente (ou familiar) para ser encaminhada ao profissional de saúde que irá dar continuidade ao tratamento, e a segunda ficará no Serviço).
</p>
<br>
<table style="font-size: 12pt;width: 100%; font-family: Times New Roman;border-spacing: 10px">
    <tr >
        <td>
            PACIENTE: <?= @$paciente[0]->nome; ?>
        </td>
        <td>
            Idade: <?= @$idade; ?> Anos
        </td>
        <td>
            Sexo: <?= @$paciente[0]->sexo; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size: 10pt;">
            DIAGNÓSTICO PSIQUIÁTRICO PRINCIPAL:  
        </td>
        <td colspan="2" style="font-size: 10pt;">
            Código: <?= @$paciente[0]->co_cid ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 9pt;text-decoration: underline">
            <?= @$paciente[0]->no_cid ?>
        </td>

    </tr>
    <tr>
        <td colspan="2" style="font-size: 10pt;">
            DIAGNÓSTICO PSIQUIÁTRICO SECUNDÁRIO:
        </td>
        <td colspan="1" style="font-size: 10pt;">
            Código:  <?= @$paciente[0]->co_cid2 ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 9pt;text-decoration: underline">
            <?= @$paciente[0]->no_cid2 ?>
        </td>

    </tr>
    <tr>
        <td colspan="2" style="font-size: 10pt;">
            RESUMO CLINICO:
        </td>

    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            ________________________________________________________________________________________________________<br>
            ________________________________________________________________________________________________________<br>
            ________________________________________________________________________________________________________<br>
            ________________________________________________________________________________________________________<br>
            ________________________________________________________________________________________________________<br>
            ________________________________________________________________________________________________________<br>

        </td>

    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            EXAMES REALIZADOS E RESULTADOS:
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            ________________________________________________________________________________________________________<br>
            ________________________________________________________________________________________________________<br>

        </td>

    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            MODALIDADE DE TRATAMENTOS REALIZADOS ATÉ O MOMENTO:

        </td>

    </tr>
    <style>
        .caixaBranca{
            display: inline-block;border:1px solid; height: 20px;width: 30px; background: white;   
        }
        .caixaPreta{
            display: inline-block;border:1px solid; height: 20px;width: 30px; background: black;   
        }
    </style>
    <tr>
        <td colspan="1" style="font-size: 10pt;">
            TRATAMENTO/ACOMPANHAMENTO GRUPAL

        </td>
        <td colspan="1" style="font-size: 10pt;">
            TERAPIA OCUPACIONAL

        </td>

    </tr>

    <tr>
        <td colspan="1" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  NÃO <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> SIM     

        </td>
        <td colspan="1" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  NÃO <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> SIM     

        </td>

    </tr>
    <tr>
        <td colspan="1" style="font-size: 10pt;">
            ACOMPANHAMENTO PSICOLÓGICO

        </td>
        <td colspan="2" style="font-size: 10pt;">
            ACOMPANHAMENTO/TERAPIA DE FAMILIA

        </td>

    </tr>

    <tr>
        <td colspan="1" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  NÃO <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> SIM     

        </td>
        <td colspan="1" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  NÃO <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> SIM     

        </td>

    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            MEDICAÇÃO UTILIZADA DURANTE A INTERNAÇÃO: <span style="font-size: 7pt;">(Listar os medicamentos psiquiátricos utilizados)</span>

        </td>


    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  NÃO 1.__________________________mg/dia     2. _______________________________mg/dia     

        </td>


    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> SIM&nbsp; 3.__________________________mg/dia     4. _______________________________mg/dia   

        </td>


    </tr>

</table>
<pagebreak></pagebreak>
<table style="font-size: 12pt;width: 100%; font-family: Times New Roman;border-spacing: 10px">

    <tr>
        <td colspan="1" style="font-size: 10pt;">
            OUTRO TIPO DE TERAPÊUTICA:

        </td>


    </tr>

    <tr>
        <td colspan="1" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  NÃO <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> SIM  QUAL:  <br> &nbsp;  <br> &nbsp;   <br>   

        </td>


    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            MEDICAÇÃO PRESCRITA PARA CASA: <span style="font-size: 7pt;">(Listar os medicamentos psiquiátricos utilizados)</span>

        </td>


    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  NÃO 1.__________________________mg/dia     2. _______________________________mg/dia     

        </td>


    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> SIM&nbsp; 3.__________________________mg/dia     4. _______________________________mg/dia   

        </td>


    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            TIPO DE ALTA 

        </td>
    </tr>
    <? foreach ($motivosaida as $item) { ?>

        <tr>
            <td colspan="3" style="font-size: 10pt;">
                <span class="<?= (@$paciente[0]->motivo_saida == $item->internacao_motivosaida_id) ? 'caixaPreta' : 'caixaBranca' ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <?= $item->nome ?>

            </td>
        </tr> 
    <? } ?>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="<?= (@$paciente[0]->hospital_transferencia != '') ? 'caixaPreta' : 'caixaBranca' ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Transferência

        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            ENCAMINHAMENTOS APÓS A ALTA 

        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="<?= (@$paciente[0]->hospital_transferencia == 'Hospital dia') ? 'caixaPreta' : 'caixaBranca' ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Hospital dia

        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="<?= (@$paciente[0]->hospital_transferencia == 'Elo de vida') ? 'caixaPreta' : 'caixaBranca' ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Elo de vida

        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="<?= (@$paciente[0]->hospital_transferencia == 'Ambulatório especializado do HSMM' || @$paciente[0]->hospital_transferencia == 'HSMM') ? 'caixaPreta' : 'caixaBranca' ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Ambulatório especializado do HSMM

        </td>
    </tr>
     <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Outro Serviço Hospitalar: ______________________

        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Residência Terapêutica

        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">
            <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Não encaminhado

        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10pt;">

        <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> CAPS
        <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Geral
        <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> A.D          
        <span class="caixaBranca">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Infantil
        </td>
    </tr>
    <tr>
        
    </tr>


</table>
<br>
<br>
<table style="font-size: 12pt; width: 100%; font-family: Times New Roman;border-spacing: 10px">
    <tr>
        <td colspan="1" style="font-size: 10pt;text-align: center;width: 50%">
            ____________________________________ <br>
            Responsável pela Internação <br>
        </td>
        <td colspan="1" style="font-size: 10pt;text-align: center;">
            ____________________________________ <br>
            Médico – Carimbo e Assinatura <br>
        </td>
        <td>

        </td>
    </tr>
</table>



</body>
</html>