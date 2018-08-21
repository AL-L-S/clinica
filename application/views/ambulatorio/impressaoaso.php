<html>
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>css/tabelarae.css" rel="stylesheet" type="text/css">
        <title>Impressão ASO</title>
    </head>
    <style>
        .tituloSemB{
            font-size: 14px;
            font-weight: bold;
        }
        .NaoMapeado{
            font-size: 14px;
            display: inline-block;
            font-weight: bold;
        }
        .td20p{
            font-size: 14px;
            width: 20%;
            font-weight: bold;
        }
        .td30p{
            font-size: 14px;
            width: 30%;
            font-weight: bold;
        }
        .td40p{
            font-size: 12px;
            width: 40%;
            font-weight: bold;
        }
        .titulo50SemB{
            font-size: 14px;
            width: 50%;
            font-weight: bold;
        }
        .titulo80SemB{
            font-size: 14px;
            width: 80%;
            font-weight: bold;
        }
        .titulo30SemB{
            font-size: 14px;
            width: 30%;
            font-weight: bold;
        }
        .trAlturaMaior{

            height: 80px;

        }
        .trcinza{
            background-color: #b7b2b2;
        }
        .caixaBranca{
            display: inline-block;border:1px solid; height: 20px;width: 30px; background: white;   
        }
        .caixaPreta{
            display: inline-block;border:1px solid; height: 20px;width: 30px; background: black;   
        }
    </style>
    <?
    $impressao_aso = json_decode($relatorio[0]->impressao_aso);
//    echo '<pre>';
//    var_dump($impressao_aso); die;
    ?>
    <body>
        <div style="width: 100%">
            <?=@$cabecalho_imp;?>
        </div>
        <table border="1" style="width: 100%;border-collapse: collapse;" >
            <tr class="trcinza">
                <th colspan="2">
                    ASO Atestado de Saúde Ocupacional 
                </th>
            </tr>
            <tr style="">
                <td colspan="2">
                    <p>
                        Em cumprimento a NR7() que regulamenta o art. 168 da consolidação das Leis Trabalhistas,
                        atesto que o trabalhador abaixo identificado foi examinado e submetido aos procedimentos e exames
                        complementares abaixo mencionados.</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table cellspacing="6" style="width: 100%">
                        <tr>
                            <td >
                                <div class="<?=($relatorio[0]->tipo == 'ADMISSIONAL')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">ADMISSIONAL</div>

                            </td>
                            <td>
                                <div class="<?=($relatorio[0]->tipo == 'PERÍODICO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado BRANCO--> &nbsp; &nbsp; &nbsp;
                                </div>

                                <div style="display: inline-block;">PERÍODICO</div>
                            </td>
                            <td>
                                <div class="<?=($relatorio[0]->tipo == 'RETORNO AO TRABALHO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado BRANCO--> &nbsp; &nbsp; &nbsp;
                                </div>

                                <div style="display: inline-block;">RETORNO AO TRABALHO</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="<?=($relatorio[0]->tipo == 'MUDANÇA DE FUNÇÃO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp; &nbsp;
                                </div>

                                <div style="display: inline-block;">MUDANÇA DE FUNÇÃO</div>

                            </td>
                            <td>
                                <div class="<?=($relatorio[0]->tipo == 'DEMISSIONAL')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado BRANCO--> &nbsp; &nbsp; &nbsp;
                                </div>

                                <div style="display: inline-block;">DEMISSIONAL</div>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table >
                        <tr>
                            <td class="tituloSemB">
                                Empresa
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <?= $impressao_aso->convenio1 ?> 
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="tituloSemB">
                                Funcionário
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <?= $relatorio[0]->paciente ?>  
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td class="titulo50SemB">
                                Setor
                            </td>
                            <td class="tituloSemB">
                                Função
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <?= $impressao_aso->setor ?>  
                            </td>
                            <td>
                                <?= $impressao_aso->funcao ?>  
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td class="titulo50SemB">
                                Documento
                            </td>
                            <td class="titulo30SemB">
                                Data Nascimento
                            </td>
                            <td class="tituloSemB">
                                Idade
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <?= $relatorio[0]->rg ?>  
                            </td>
                            <td>
                                <?= ($relatorio[0]->nascimento != '') ? date("d/m/Y", strtotime($relatorio[0]->nascimento)) : '' ?>  
                            </td>
                            <td>
                                <?
                                if ($relatorio[0]->nascimento != '') {
                                    $nascimento = new DateTime($relatorio[0]->nascimento);
                                    $atual = new DateTime(date("Y-m-d"));

// Resgata diferença entre as datas
                                    $dateInterval = $nascimento->diff($atual);
                                    $idade = $dateInterval->y ;
                                }else{
                                    $idade = '';
                                }
                                ?>
                                <?=$idade?>  
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td  class="tituloSemB">
                                Riscos Ocupacionais Específicos
                            </td>


                        </tr>
                        <tr>
                            <td>
                                <?= @$impressao_aso->riscos_ocupacionais ?>   
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td class="titulo80SemB">
                                Exames
                            </td>
                            <td class="tituloSemB">
                                Data de Realização
                            </td>

                        </tr>
                        <tr>
                            <td>
                                ASO 
                            </td>
                            <td>
                                <?= (@$impressao_aso->data_realizacao != '') ? @$impressao_aso->data_realizacao : ''; ?>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="trcinza">
                <td colspan="2">
                    AVALIAÇÃO CLINICA
                </td>
            </tr>
            <tr >
                <td colspan="2" style="min-height: 50px;">
                    <?= @$impressao_aso->avaliacao_clinica ?>    
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td class="tituloSemB" colspan="2">
                                O funcionário acima, foi submetido(a) a exame médico, conforme a NR 07, sendo considerado:
                            </td>
                        </tr>
                        <tr>
                            <td class="td20p">
                                <div class="<?=(@$impressao_aso->questao_um == 'APTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">APTO</div>

                            </td>
                            <td >
                                <div class="<?=(@$impressao_aso->questao_um == 'INAPTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">INAPTO</div>

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td class="tituloSemB" colspan="3">
                                NR 35 - Quanto a obrigatoriedade de constar no ASO do funcionário se ele é mapeado para Trabalho em Altura <br>
                                NR 35.4.1.2.1 - A Aptidão para Trabalho em Altura deve ser consignada no atestado de saúde ocupacional do trabalhador
                            </td>
                        </tr>
                        <tr>
                            <td class="td20p">
                                <div class="<?=(@$impressao_aso->questao_dois == 'APTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">APTO</div>

                            </td>
                            <td class="td20p">
                                <div class="<?=(@$impressao_aso->questao_dois == 'INAPTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">INAPTO</div>

                            </td>
                            <td >
                                <div class="<?=(@$impressao_aso->questao_dois == 'NÃO MAPEADO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div class="NaoMapeado">NÃO MAPEADO</div>

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td class="tituloSemB" colspan="3">
                                NR 33 - Segurança e Saúde nos Trabalhos em Espaços Confinados conforme item 33.3.4.1
                            </td>
                        </tr>
                        <tr>
                            <td class="td20p">
                                <div class="<?=(@$impressao_aso->questao_tres == 'APTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">APTO</div>

                            </td>
                            <td class="td20p">
                                <div class="<?=(@$impressao_aso->questao_tres == 'INAPTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">INAPTO</div>

                            </td>
                            <td >
                                <div class="<?=(@$impressao_aso->questao_tres == 'NÃO MAPEADO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div class="NaoMapeado">NÃO MAPEADO</div>

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td class="td40p">
                                <div class="<?=(@$impressao_aso->questao_quatro == 'APTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">APTO PARA OPERAR MÁQUINAS MÓVEIS</div>

                            </td>
                            <td class="td40p">
                                <div class="<?=(@$impressao_aso->questao_quatro == 'INAPTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">INAPTO PARA OPERAR MÁQUINAS MÓVEIS</div>

                            </td>
                            <td >
                                <div class="<?=(@$impressao_aso->questao_quatro == 'NÃO MAPEADO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div class="NaoMapeado">NÃO MAPEADO</div>

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%">
                        <tr>
                            <td class="tituloSemB" colspan="3">
                                NR 10 - Segurança em Instalações e Serviços em Eletricidade conforme item 10.8.7
                            </td>
                        </tr>
                        <tr>
                            <td class="td20p">
                                <div class="<?=(@$impressao_aso->questao_cinco == 'APTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">APTO</div>

                            </td>
                            <td class="td20p">
                                <div class="<?=(@$impressao_aso->questao_cinco == 'INAPTO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div style="display: inline-block;">INAPTO</div>

                            </td>
                            <td >
                                <div class="<?=(@$impressao_aso->questao_cinco == 'NÃO MAPEADO')? 'caixaPreta': 'caixaBranca'?>">
                                    <!--Quadrado PRETO--> &nbsp; &nbsp;&nbsp;
                                </div>

                                <div class="NaoMapeado">NÃO MAPEADO</div>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td >
                    <table style="width: 100%">
                        <tr>
                            <td class="tituloSemB">
                                Carimbo e assinatura do médico Examinador
                            </td>


                        </tr>
                        <tr class="trAlturaMaior">
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td  class="tituloSemB">
                                Médico Coordenador
                            </td>


                        </tr>
                        <tr  class="trAlturaMaior">
                            <td>
                                <p>
                                    <?=@$relatorio[0]->medico?>  CRM: <?=@$relatorio[0]->conselho?>
                                </p>
                                <p>
                                    <?=@$relatorio[0]->telefone?>/<?=@$relatorio[0]->celular?>
                                </p>
                                
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr>
                <th colspan="2">
                    Estou ciente do resultado do presente exame médico e recebi a 2ª VIA deste ASO
                </th>
            </tr>
            <tr>
                <td >
                    <table style="width: 100%">
                        <tr>
                            <td class="tituloSemB">
                                Local e data da LIBERAÇÃO do ASO
                            </td>


                        </tr>
                        <tr class="trAlturaMaior">
                            <td>

                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td  class="tituloSemB">
                                Assinatura do(a) funcionário(a)
                            </td>


                        </tr>
                        <tr  class="trAlturaMaior">
                            <td>

                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>
    </body>

</html>
