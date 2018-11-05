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
<?
$dependencia = array();
$dependencia_id = array();

foreach($dependencias as $value){

    array_push($dependencia, $value->nome);
    array_push($dependencia_id, $value->internacao_tipo_dependencia_id);

}

$dependencia_nomes = '';
$array_dependencia = json_decode(@$paciente[0]->tipo_dependencia);
$total_cadastros++;
foreach ($array_dependencia as $value) {
    $key = array_search($value, $dependencia_id);
    $dependencia_loop = $dependencia[$key];
    if ($dependencia_nomes == '') {
        $dependencia_nomes = $dependencia_nomes . $dependencia_loop;
    } else {
        $dependencia_nomes = $dependencia_nomes . ', ' . $dependencia_loop;
    }
}

?>
    <body>
        <? //= $cabecalho_form ?>
        <!--<hr class="hrlegal">-->
        <!--<h1 style="text-align:center;text-decoration: underline;">ADMISSÃO DE PACIENTE</h1>-->

        <table style="font-size: 11pt;width: 100%; font-family: Times New Roman; font-weight: bold;">
            <tr >
                <td style="text-align: center;">
                    Ficha de Internação 
                </td>
            </tr>
            <tr >
                <td style="text-align: center;">
                    SENHA: <?= @$paciente[0]->senha; ?> 
                </td>
            </tr>
        </table>
        <table style="font-size: 9pt;height: 30%;width: 100%; font-family: Times New Roman">

            <tr>
                <td colspan="3" style="">
                    Nome: <?= @$paciente[0]->nome; ?>
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
                <td style="width: 40%;">
                    Data do Nasc: <?= (@$paciente[0]->nascimento != '') ? date("d/m/Y", strtotime(@$paciente[0]->nascimento)) : ''; ?>
                </td>

                <td colspan="1" style="">
                    Profissão: <?= @$paciente[0]->profissao; ?> 
                </td>


                <td colspan="1" style="">
                    Estado Civil: <?
                    if (@$paciente[0]->estado_civil_id == "1") {
                        echo 'Solteiro(a)';
                    } elseif (@$paciente[0]->estado_civil_id == "2") {
                        echo 'Casado(a)';
                    } elseif (@$paciente[0]->estado_civil_id == "3") {
                        echo 'Divorciado(a)';
                    } elseif (@$paciente[0]->estado_civil_id == "4") {
                        echo 'Viuvo(a)';
                    } elseif (@$paciente[0]->estado_civil_id == "5") {
                        echo 'Outros';
                    }
                    ?>
                </td>

            </tr>
            <tr>
                <td colspan="1" style="">
                    RG: <?= @$paciente[0]->rg; ?> <?= @$paciente[0]->uf_rg; ?>
                </td>
                <td colspan="1" style="">
                    CPF: <?= @$paciente[0]->cpf; ?>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="">
                    Convênio: <?= @$paciente[0]->convenio; ?>
                </td>

                <td colspan="1" style="">
                    Escolaridade: <?
                    if (@$paciente[0]->escolaridade_id == 1) {
                        echo 'Fundamental-Incompleto';
                    } elseif (@$paciente[0]->escolaridade_id == 2) {
                        echo 'Fundamental-Completo';
                    } elseif (@$paciente[0]->escolaridade_id == 3) {
                        echo 'Médio-Incompleto';
                    } elseif (@$paciente[0]->escolaridade_id == 4) {
                        echo 'Médio-Completo';
                    } elseif (@$paciente[0]->escolaridade_id == 5) {
                        echo 'Superior-Incompleto';
                    } elseif (@$paciente[0]->escolaridade_id == 6) {
                        echo 'Superior-Completo';
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td colspan="1" style="">
                    Data de Internação:  <?= date("d/m/Y", strtotime(@$paciente[0]->data_internacao)); ?>
                </td>
                <td colspan="1" style="">
                    Data de Saída:  <?= (@$paciente[0]->data_saida != '') ? date("d/m/Y", strtotime(@$paciente[0]->data_saida)) : ''; ?>
                </td>
            </tr>

            <tr>
                <td colspan="1" style="">
                    Endereço: <?= @$paciente[0]->logradouro; ?>
                </td>
                <td colspan="1" style="">
                    N°: <?= @$paciente[0]->numero; ?>
                </td>

            </tr>
            <tr>
                <td colspan="1" style="">
                    Bairro: <?= @$paciente[0]->bairro; ?>
                </td>
                <td colspan="1" style="">
                    Cidade: <?= @$paciente[0]->municio; ?>
                </td>

            </tr>
            <tr>
                <td colspan="3" style="">
                    Tipo de Dependência: <?= $dependencia_nomes; ?>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="">
                    Inicio do uso: <?= (@$paciente[0]->idade_inicio > 0) ? @$paciente[0]->idade_inicio . " Anos" : ''; ?>
                </td>
                <td colspan="1" style="">
                    Problemas com a justiça?: (&nbsp;&nbsp;&nbsp;) Sim (&nbsp;&nbsp;&nbsp;) Não 
                </td>
            </tr>
            <tr>
                <td colspan="3" style="">
                    Qual artigo? ______________________________________________________________________
                </td>
            </tr>
            <tr>
                <td colspan="3" style="">
                    Filiação:(pai) <?= @$paciente[0]->nome_pai; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="">
                    Filiação:(mãe) <?= @$paciente[0]->nome_mae; ?>
                </td>
            </tr>

            <tr>
                <td colspan="3" style="text-align: center;text-decoration: underline;  font-size: 12pt;">
                    Dados do Responsável
                </td>
            </tr>

            <tr>
                <td colspan="3" style="">
                    Nome: <?= @$paciente[0]->nome_responsavel; ?>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="">
                    RG: <?= @$paciente[0]->rg_responsavel; ?>
                </td>
                <td colspan="1" style="">
                    CPF: <?= @$paciente[0]->cpf_responsavel; ?>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="">
                    Endereço: <?= @$paciente[0]->logradouro_responsavel; ?>
                </td>
                <td colspan="1" style="">
                    N°: <?= @$paciente[0]->numero_responsavel; ?>
                </td>

            </tr>
            <tr>
                <td colspan="1" style="">
                    Bairro: <?= @$paciente[0]->bairro_responsavel; ?>
                </td>
                <td colspan="1" style="">
                    Cidade: <?= @$paciente[0]->municipio_responsavel; ?>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="">
                    Parentesco: <?= @$paciente[0]->grau_parentesco; ?>
                </td>
                <td colspan="1" style="">
                    Profissão: <?= @$paciente[0]->ocupacao_responsavel; ?>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="">
                    Telefone: <?= @$paciente[0]->telefone_responsavel; ?>
                </td>
                <td colspan="1" style="">
                    Celular:  <?= @$paciente[0]->celular_responsavel; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="">
                    Email: <?= @$paciente[0]->email_responsavel; ?>
                </td>

            </tr>



        </table>

        <br>
        <br>
        <table style="font-size: 9pt;height: 50%;width: 100%; font-family: Times New Roman">
            <tr>
                <td colspan="2">
                    <div>
                        <p>
                            O Sr.(a) <?= @$paciente[0]->nome_responsavel; ?> declara se responsabilizar pela internação, para fins de tratamento de Quimio-dependencia do paciente: <?= @$paciente[0]->nome; ?> obrigando-se à contribuição mensal à título e manutenção no valor de: _________________________________.  Não haverá devolução de  contribuições quitadas, caso o paciente interrompa o tratamento. 
                        </p>
                        <p>
                            O Instituto Volta Vida não será responsável por danos ocorridos por desavença, bem como não se responsabiliza por qualquer enfermidade adquirida, devendo apenas a Equipe e Tratamento comunicar imediatamente aos familiares; caso isto aconteça.
                        </p>
                        <p>
                            O responsável pelo paciente, assumira por danos ocorridos por seu dependente ao patrimônio o Instituto Volta Vida não se responsabilizará, a qualquer titulo,  por eventuais danos que venha sofrer o paciente fora das dependências  da Instituição quando elas tenha se afastado sem permissão ou por violação do regulamento.  
                        </p>
                        <p>
                            Venho através desse documento autorizar a Comunidade terapêutica Instituto Volta Vida Ltda. – IVV a desligar, abrir as portas de saída para o residente acima citado, caso o mesmo esteja com má conduta e infringir as regras da Instituição. Não responsabilizando em hipótese alguma a Instituição de qualquer acontecimento que venha a ocorrer ao meu familiar após sua saída do Instituto.  Concordo inteiramente com o acima escrito.
                        </p>

                        <br>
                        <br>
                        <p>
                            _____________________________________________________<br>
                            Assinatura do responsável
                        </p>




                    </div>  
                </td>
            </tr>

        </table>
    <pagebreak></pagebreak>


    <table  style="width: 100%;border-collapse: collapse;" >

        <tr>
            <td style="text-align: center; font-weight: bold; font-family: Arial; font-size: 11pt;">
                COMUNICAÇÃO DE INTERNAÇÃO <br> PSIQUIÁTRICA INVOLUNTÁRIA  
            </td>

        </tr>



    </table>
    <br>
    <!--<br>-->

    <table  style="width: 100%;border-collapse: collapse;" >


        <tr>
            <td style="text-align: left; font-family: Arial;font-size: 10pt;">
                Fortaleza, <?= date("d") ?> de <?= $this->utilitario->retornarNomeMes(date("m")); ?> de <?= date("Y") ?>
            </td>

        </tr>


    </table>
    <p style="font-size: 10pt;">
        Dando cumprimento ao que dispõe o parágrafo I do artigo 8 da Lei 10.216 de 06/01/2001, regulamentada na portaria n° 2.391 de 26 de dezembro de 2002, encaminhamos dentro do prazo legal de (72 horas) as informações do paciente abaixo.
    </p>
    <p style="font-size: 10pt;">
        Relacionado(a): <br><br>
        <span style="font-weight: bold;">AO MINISTÉRIO PÚBLICO DO CEARÁ
            PROMOTORIA DE JUSTIÇA DE DEFESA DA SAÚDE PÚBLICA
            COMISSÃO REVISORA DE INTERNAÇÕES PSIQUIÁTRICAS INVOLUNTÁRIAS (CRIPI)</span>
    </p>

    <table style="font-size: 9pt;height: 50%;width: 100%; font-family: Arial;">
        <tr>
            <td style="text-align: center;" colspan="2">
                ESTABELECIMENTO: COMUNIDADE TERAP&Ecirc;UTICA INSTITUTO VOLTA VIDA
            </td>  
        </tr>
        <tr>
            <td colspan="2" >
                CLIENTE: <?= @$paciente[0]->nome; ?>
            </td>  
        </tr>
        <tr>
            <td colspan="2">
                PAI: <?= @$paciente[0]->nome_pai; ?>
            </td>  
        </tr>
        <tr>
            <td colspan="2">
                MÃE: <?= @$paciente[0]->nome_mae; ?>
            </td>  
        </tr>
        <tr>
            <td>
                DATA DE NASCIMENTO: <?= (@$paciente[0]->nascimento != '') ? date("d/m/Y", strtotime(@$paciente[0]->nascimento)) : ''; ?>
            </td>  
            <td>
                EST. CIVIL:  <?
                if (@$paciente[0]->estado_civil_id == "1") {
                    echo 'Solteiro(a)';
                } elseif (@$paciente[0]->estado_civil_id == "2") {
                    echo 'Casado(a)';
                } elseif (@$paciente[0]->estado_civil_id == "3") {
                    echo 'Divorciado(a)';
                } elseif (@$paciente[0]->estado_civil_id == "4") {
                    echo 'Viuvo(a)';
                } elseif (@$paciente[0]->estado_civil_id == "5") {
                    echo 'Outros';
                }
                ?>
            </td>  
        </tr>
        <tr>
            <td>
                NATURALIDADE: <?= @$paciente[0]->nacionalidade; ?>
            </td>  
            <td>
                NACIONALIDADE: <?= @$paciente[0]->nacionalidade; ?>
            </td>  
        </tr>
        <tr>
            <td>
                IDENTIDADE N&ordm;:  <?= @$paciente[0]->rg; ?>  
            </td>  
            <td>
                &Oacute;RG&Atilde;O EXPEDIDOR/UF: ________________
            </td>  
        </tr>
        <tr>
            <td>
                CPF: <?= @$paciente[0]->cpf; ?>  
            </td>  
            <td>
                PROFISS&Atilde;O: <?= @$paciente[0]->profissao; ?>  
            </td>  
        </tr>
        <tr>
            <td colspan="2">
                ENDERE&Ccedil;O: <?= @$paciente[0]->logradouro; ?> Nº <?= @$paciente[0]->numero; ?>  
            </td>  

        </tr>
        <tr>
            <?
            $codigoUF = $this->utilitario->codigo_uf(@$paciente[0]->codigo_ibge);
            ?>
            <td>
                CIDADE: <?= @$paciente[0]->municio; ?>  
            </td>  
            <td>
                UF: <?= @$codigoUF; ?>  
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                ACOMPANHANTE/RESPONS&Aacute;VEL: <?= @$paciente[0]->nome_responsavel; ?>  
            </td>  


        </tr>
        <tr>
            <td>
                GRAU PARENTESCO: <?= @$paciente[0]->grau_parentesco; ?>  
            </td>  

            <td>
                RG: <?= @$paciente[0]->rg_responsavel; ?>  
            </td>  
        </tr>
        <tr>
            <td colspan="2">
                ENDERE&Ccedil;O: <?= @$paciente[0]->logradouro_responsavel; ?>  Nº <?= @$paciente[0]->numero_responsavel; ?>  
            </td>  


        </tr>
        <tr>
            <td colspan="2">
                LOCAL DE INTERNA&Ccedil;&Atilde;O: _______________________________________________________
            </td>  
        </tr>
        <tr>
            <td>
                DATA INTERNA&Ccedil;&Atilde;O: <?= date("d/m/Y", strtotime(@$paciente[0]->data_internacao)); ?>
            </td>  
            <td>
                HORA:  <?= date("H:i:s", strtotime(@$paciente[0]->data_internacao)); ?> CID: <?= @$paciente[0]->cid1solicitado; ?>  
            </td>  
        </tr>
        <tr>
            <td colspan="2">
                MOTIVO DE INTERNA&Ccedil;&Atilde;O: _____________________________________________________
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                JUSTIFICATIVA DA INVOLUNTARIEDADE: __________________________________________
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                MOTIVO DA DISCORD&Acirc;NCIA DO CLIENTE QUANTO &Aacute; INTERNA&Ccedil;&Atilde;O: _____________________
            </td>  

        </tr>

        <tr>
            <td colspan="2">
                ANTECEDENTES PSIQUI&Aacute;TRICOS: ___________________________________________________
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                CONTEXTO FAMILIAR: _______________________________________________________________
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                TEMPO ESTIMADO INTERNA&Ccedil;&Atilde;O (DIAS) (&nbsp;&nbsp; )1 A 5 (&nbsp;&nbsp; )6 A 14 (&nbsp;&nbsp; )15 A 21 (&nbsp;&nbsp; )22 A 30 (&nbsp;&nbsp; ) MAIS DE 30
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                M&Eacute;DICO RESPONS&Aacute;VEL PELA INTERNA&Ccedil;&Atilde;O: <?= @$paciente[0]->medico; ?>  
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                SITUA&Ccedil;&Atilde;O JUR&Iacute;DICA DO CLIENTE: INTERDITADO ( ) SIM ( ) N&Atilde;O ( ) N&Atilde;O SABE
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                DADOS SOBRE O INSS: _________________________________________________________
            </td>  

        </tr>
        <tr>
            <td colspan="2">
                OBSERVA&Ccedil;&Otilde;ES: ______________________________________________________________
            </td>  

        </tr>

    </table>
    <br>
    <br>
    <table style="width: 100%; font-family: Times New Roman; text-align: center;">
        <tr>
            <td style="width: 50%">
                __________________________________________ <br><span style="font-size: 9pt"> RESP. P/ INTERNAÇÃO INVOLUNTÁRIA</span>
            </td>
            <td style="width: 50%">
                __________________________________________ <br><span style="font-size: 9pt"> MÉDICO RESPONSÁVEL </span>
            </td>
        </tr>
    </table>



</body>
</html>