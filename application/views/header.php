<?
//Da erro no home

if ($this->session->userdata('autenticado') != true) {
    redirect(base_url() . "login/index/login004", "refresh");
}
$perfil_id = $this->session->userdata('perfil_id');
$operador_id = $this->session->userdata('operador_id');
$internacao = $this->session->userdata('internacao');


function alerta($valor) {
    echo "<script>alert('$valor');</script>";
}

function debug($object) {
    
}
?>
<!DOCTYPE html PUBLIC "-//carreW3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >
    <head>
        <title>STG - SISTEMA DE GESTAO DE CLINICAS v1.0</title>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->
        <link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/batepapo.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>
        <!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.js" ></script>-->
        <script type="text/javascript">
//            var jQuery = jQuery.noConflict();
            var chatsAbertos = new Array();

            (function ($) {
                $(function () {
                    $('input:text').setMask();
                });
            })(jQuery);


            function mensagensnaolidas() {
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>" + "batepapo/totalmensagensnaolidas",
                    dataType: "json",
                    success: function (retorno) {
                        if (jQuery(".batepapo_div #contatos_chat_lista span").length > 0) {
                            jQuery(".batepapo_div #contatos_chat_lista span").remove();
                        }

                        if (retorno != 0) {
                            jQuery(".batepapo_div #contatos_chat_lista").append("<span class='total_mensagens'></span>");
                            jQuery(".batepapo_div .total_mensagens").text("+" + retorno);
                        }
                    }
                });
            }
            mensagensnaolidas();

            function carregacontatos() {
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>" + "batepapo/pesquisar",
                    dataType: "json",
                    success: function (retorno) {
                        jQuery.each(retorno, function (i, usr) {
                            var tags = null;
                            if (usr.operador_id != <? echo $operador_id ?> && usr.usuario != 0) {
                                tags = "<li id='" + usr.operador_id + "'><div class='imgPerfil'></div>";
                                tags += "<a href='#' id='<? echo $operador_id ?>:" + usr.operador_id + "' class='comecarChat'>" + usr.usuario + "</a>";
                                if (usr.num_mensagens != 0) {
                                    tags += "<span class='total_mensagens'> +" + usr.num_mensagens + " </span>";
                                }
                                tags += "<span id='usr.operador_id'></span></li>";
                                jQuery("#principalChat #usuarios_online ul").append(tags);
                            }
                        });
                    }
                });
            }

            //abri uma nova janela
            function adicionarJanela(id, nome, status) {

                //atribui dinamicamente a posicao da janela na pagina
                var numeroJanelas = Number(jQuery("#chats .janela_chat").length);
                if (numeroJanelas < 4) {
                    var posicaoJanela = (270 + 15) * numeroJanelas;
                    var estiloJanela = 'float:none; position: absolute; bottom:0; right:' + posicaoJanela + 'px';

                    //pega o id do operador origem e do operador destino
                    var splitOperadores = id.split(':');
                    var operadorDestino = Number(splitOperadores[1]);
                    
                    //criando a janela de mensagem
                    var janela;
                    janela = "<div class='janela_chat' id='janela_" + operadorDestino + "' style='" + estiloJanela + "'>";
                    janela += "<div class='cabecalho_janela_chat'> <a href='#' class='fechar'>X</a>";
                    janela += "<span class='nome_chat'>" + nome + "</span><span id='" + operadorDestino + "'></span></div>";
                    janela += "<div class='corpo_janela_chat'><div class='mensagens_chat'><ul></ul></div>";
                    janela += "<div class='enviar_mensagens_chat' id='" + id + "'>";
                    janela += "<input type='text' maxlength='300' name='mensagem_chat' class='mensagem_chat' id='" + id + "' /></div></div></div>";

                    //acrescenta a janela ao aside chats
                    jQuery("#chats").append(janela);
                    chatsAbertos.push(operadorDestino);
                } else {
                    alert("Voce estorou o limite de janelas.")
                }
            }

            //retornando historico de conversas
            function retorna_historico(idJanela) {
                var operadorOrigem = <? echo $operador_id; ?>;
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>" + "batepapo/historicomensagens",
                    data: "operador_origem=" + operadorOrigem + "&operador_destino=" + idJanela,
                    dataType: 'json',
                    success: function (retorno) {
                        jQuery.each(retorno, function (i, msg) {
                            if (jQuery('#janela_' + msg.janela).length > 0) {

                                if (operadorOrigem == msg.id_origem) {
                                    jQuery("#janela_" + msg.janela + " .corpo_janela_chat .mensagens_chat ul").append("<li class='eu' id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p></li>");
                                } else {
                                    jQuery("#janela_" + msg.janela + " .corpo_janela_chat .mensagens_chat ul").append("<li id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p></li>");
                                }
                            }
                        });
                        var altura = jQuery("#janela_" + idJanela + " .corpo_janela_chat .mensagens_chat").height();
                        jQuery("#janela_" + idJanela + " .corpo_janela_chat .mensagens_chat").animate({scrollTop: 1000000}, '500');
                    }
                });
            }


        </script>

    </head>
    <script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>

    <?php
    $this->load->library('utilitario');
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>


    <div class="container">
        <div class="header">
            <div id="imglogo">
                <img src="<?= base_url(); ?>img/stg - logo.jpg" alt="Logo"
                     title="Logo" height="70" id="Insert_logo"
                     style="display:block;" />
            </div>
            <div id="login">
                <div id="user_info">
                    <label style='font-family: serif; font-size: 8pt;'>Seja bem vindo <?= $this->session->userdata('login'); ?>! </label>
                    <label style='font-family: serif; font-size: 8pt;'>Empresa: <?= $this->session->userdata('empresa'); ?> </label>
                </div>
                <div id="login_controles">
                    <!--
                    <a href="#" alt="Alterar senha" id="login_pass">Alterar Senha</a>
                    -->
                    <a id="login_sair" title="Sair do Sistema" onclick="javascript: return confirm('Deseja realmente sair da aplicação?');"
                       href="<?= base_url() ?>login/sair">Sair</a>

                    <div class="batepapo_div">
                        <a id="contatos_chat_lista" href="#">
                            <img src="<?= base_url(); ?>img/chat_icon.png" alt="Batepapo"
                                 title="Batepapo"/></a>
                    </div>
                </div>
                <!--<div id="user_foto">Imagem</div>-->

            </div>
        </div>
        <div class="decoration_header">&nbsp;</div>

        <!-- INICIO BATEPAPO -->
        <div id="principalChat">
            <aside id="usuarios_online" >
                <ul>
                </ul>
            </aside>

            <aside id="chats">

            </aside>


        </div>
        <!-- FIM BATEPAPO -->

        <!-- Fim do Cabeçalho -->
        <div class="barraMenus" style="float: left;">
            <ul id="menu" class="filetree">
                <li><span class="folder">Recep&ccedil;&atilde;o</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
                            <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/pacientes">Cadastro</a></span></ul>
                                <? if ($perfil_id != 2) { ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listaresperacaixa">Fila Caixa</a></span></ul>
                                <? } ?>            
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaogeral">Multifuncao Geral</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncao">Multifuncao Exame</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta">Multifuncao Consulta</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaofisioterapia">Multifuncao Especialidade</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/medicoagendageral">Medico agenda geral</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/medicoagenda">Medico agenda exame</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/medicoagendaconsulta">Medico agenda consulta</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/medicoagendaespecialidade">Medico agenda especialidade</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentoplanoconsulta">Pre&ccedil;o procedimento</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/indicacao">Manter indica&ccedil;&atilde;o</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador/pesquisarmedicosolicitante">Editar Medico Solicitante</a></span></ul>
                            <? } elseif ($perfil_id == 9) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listaresperacaixa">Fila Caixa</a></span></ul>
                            <? } ?>
                        </li>
                        <li><span class="folder">Relatorios</span>
                            <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriomedicoagendaconsultas">Relatorio agenda Consulta</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriomedicoagendaexame">Relatorio agenda Exames</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriomedicoordem">Relatorio ordem atendimento</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioconvenioquantidade">Convenio exames/consultas</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioaniversariante">Relatorio Aniversariantes</a></span></ul>
                                <?
                            }
                            if ($perfil_id == 1 || $perfil_id == 6) {
                                ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogruporm">Relatorio Rm</a></span></ul>
                                <?
                            }
                            if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 11 || $perfil_id == 12) {
                                ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriorecepcaomedicoconvenio">Relatorio Medico Convenio</a></span></ul>
                            <?
                            }
                            if ($perfil_id != 9) {
                                ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioatendenteconvenio">Relatorio Atendente Convenio</a></span></ul>
<? } ?>    
<!--                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exametemp">Pacientes temporarios</a></span></ul>
<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/localizapaciente">Loacalizar pacientes</a></span></ul>-->
                        </li>
                    </ul>
                </li>

                <li><span class="folder">Atendimento</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
<? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/painelrecepcao">Painel recepcao</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarsalasespera">Salas de Espera</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarexamerealizando">Salas de Exames</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarexamependente">Exames pendentes</a></span></ul>
<? } ?>
                        </li>
                    </ul>
                </li>
                <li><span class="folder">Imagem</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
<? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedico">Multifuncao Medico</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo">Manter Laudo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisardigitador">Manter Laudo Digitador</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisarrevisor">Manter Revisor</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisarlaudoantigo">Manter Antigo</a></span></ul>
<? } ?>     
                        </li>
                        <li><span class="folder">Relatorios</span>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
<? } ?>    
                        </li>    
                    </ul>
                </li>
                <li><span class="folder">Consultas</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
<? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoconsulta">Multifuncao Medico</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisarconsulta">Manter Consulta</a></span></ul>
                                <?
                            }
                            ?>
                        </li> 
                        <li><span class="folder">Relatorios</span>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
<? } ?>
                        </li>   
                    </ul>
                </li>
                <li><span class="folder">Especialidade</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
                            <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicofisioterapia">Multifuncao Especialidade</a></span></ul>
                                <?
                            }
                            ?>
                        </li>
                        <li><span class="folder">Relatorios</span>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
<? } ?>
                        </li>  
                    </ul>
                </li>
                <li><span class="folder">Laboratorial</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
                            <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicolaboratorial">Multifuncao Laboratorial</a></span></ul>
                                <?
                            }
                            ?>
                        </li>
                        <li><span class="folder">Relatorios</span>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
<? } ?>
                        </li>  
                    </ul>
                </li>
                <li><span class="folder">Geral</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
                            <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicogeral">Multifuncao Geral</a></span></ul>
                                <?
                            }
                            ?>
                        </li> 
                        <li><span class="folder">Relatorios</span>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
<? } ?>    
                        </li>   
                    </ul>
                </li>
                <li><span class="folder">Faturamento</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
<? if ($perfil_id == 1 || $perfil_id == 3) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/faturamentoexame">Faturar</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/faturamentoexamexml">Gerar xml</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/faturamentolaudoxml">Gerar xml Laudo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriovalorprocedimento">Ajustar valores</a></span></ul>
<? } ?>
                        </li>
                        <li><span class="folder">Relatorios</span>
<? if ($perfil_id == 1 || $perfil_id == 3) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioexame">Relatorio Conferencia</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/gerarelatoriogeralsintetico">Relatorio Sintetico Geral</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioexamech">Relatorio Faturamento Convenio CH</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriopacieneteexame">Relatorio Convenio Paciente</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocancelamento">Relatorio Cancelamento</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriotempoesperaexame">Relatorio Tempo espera exame</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriotemposalaespera">Relatorio Tempo sala de espera</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogrupo">Relatorio Exame Grupo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogrupoanalitico">Relatorio Exame Grupo Analitico</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogrupoprocedimento">Relatorio Exame Grupo Procedimento</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogrupoprocedimentomedico">Relatorio Grupo Procedimento Medico</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogeralconvenio">Relatorio Geral Convenio</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicosolicitante">Relatorio Medico Solicitante sintetico</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicosolicitantexmedico">Relatorio Medico Solicitante analitico</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicosolicitantexmedicoindicado">Relatorio Medico Solicitante X Medico Indicado</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriolaudopalavra">Relatorio Laudo palavra chave</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriophmetria">Relatorio PH Metria</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriotecnicoconvenio">Relatorio Tecnico Convenio</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriotecnicoconveniosintetico">Relatorio Tecnico Convenio Sintetico</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioexamesala">Relatorio Consolidado por sala</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioconveniovalor">Relatorio Convenio exames/consultas valor</a></span></ul>
<? } ?>
                        </li> 
                    </ul>
                </li>
                <li><span class="folder">Estoque</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/solicitacao">Manter Solicitacao</a></span></ul>
<? } if ($perfil_id == 1 || $perfil_id == 8) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada">Manter Entrada</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/inventario">Manter Inventario</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/fornecedor">Manter Fornecedor</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/produto">Manter Produto</a></span></ul>
<? } ?>
                        </li> 
                        <li><span class="folder">Relatorios</span>
<? if ($perfil_id == 1 || $perfil_id == 8) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatorioentradaarmazem">Relatorio Entrada Produtos</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaidaarmazem">Relatorio Saida Produtos</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaldoarmazem">Relatorio Saldo Produtos/Entrada</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaldo">Relatorio Saldo Produtos</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriominimo">Relatorio Estoque Minimo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatorioprodutos">Relatorio Produtos</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriofornecedores">Relatorio Fornecedores</a></span></ul>

<? } ?>
                        </li> 
                    </ul>
                </li>
                <li><span class="folder">Financeiro</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
<? if ($perfil_id == 1) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa">Manter Entrada</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/pesquisar2">Manter Saida</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/contaspagar">Manter Contas a pagar</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/contasreceber">Manter Contas a Receber</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/pesquisar3">Manter Sangria</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/fornecedor">Manter Credor/Devedor</a></span></ul>
                            <? }
                            ?>
                        </li> 
                        <li><span class="folder">Relatorios</span>
                            <?
                            if ($perfil_id == 1) {
                                ?>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriosaida">Relatorio Saida</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriosaidagrupo">Relatorio Saida Tipo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioentrada">Relatorio Entrada</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioentradagrupo">Relatorio Entrada Conta</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/contaspagar/relatoriocontaspagar">Relatorio Contas a pagar</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/contasreceber/relatoriocontasreceber">Relatorio Contas a Receber</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriomovitamentacao">Relatorio Moviten&ccedil;&atilde;o</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriovalormedio">Relatorio Valor Medio</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorionotafiscal">Relatorio Nota</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioresumogeral">Relatorio Resumo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioacompanhamentodecontas">Relatorio Acompanhamento de contas</a></span></ul>
                                <?
                            }
                            if ($perfil_id == 1 || $perfil_id == 5) {
                                ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixa">Relatorio Caixa</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixafaturado">Relatorio Caixa Faturamento</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixacartao">Relatorio Caixa Cartao</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixacartaoconsolidado">Relatorio Consolidado Cartao</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioindicacao">Relatorio Indicacao</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconveniofinanceiro">Relatorio Produ&ccedil;&atilde;o M&eacute;dica</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenioprevisaofinanceiro">Relatorio Previs&atilde;o M&eacute;dica</a></span></ul>
                                <?
                            }
                            ?>

                        </li> 

                    </ul>
                </li>
                
                <? if ($internacao == 't') { ?>
                            <li><span class="folder">Internacao</span>
                                <ul>
                                    <li><span class="file"><a href="<?= base_url() ?>internacao/internacao">Listar Internações</a></span></li>
                                    <!--<li><span class="file"><a href="<?= base_url() ?>internacao/internacao">Listar Internacoes</a></span></li>-->
                                    <li><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarsaida">Listar Saidas</a></span></li>
                                </ul>
                            </li>
                
                
<? } ?>
<!--                <li><span class="folder">Centro Cirurgico</span>
                    <ul>
                        <li><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico">Listar Solicitacoes</a></span></li>
                        <li><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarcirurgia">Fila de Cirurgia</a></span></li>
                    </ul>
                </li>-->
                <li><span class="folder">Relatorios (RM)</span>
                    <ul>
                        <? if ($perfil_id == 1 || $perfil_id == 6 || $perfil_id == 3) { ?>
                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogruporm">Relatorio Caixa</a></span></ul>
                            <?
                        }
                        if ($perfil_id == 1 || $perfil_id == 3) {
                            ?>
                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicosolicitanterm">Relatorio Medico Solicitante</a></span></ul>
                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconveniorm">Relatorio Medico Convenio</a></span></ul>
                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriofaturamentorm">Relatorio Faturamento</a></span></ul>
<? } ?>
                    </ul>
                </li>
                <li><span class="folder">Configura&ccedil;&atilde;o</span>
                    <ul>
                        <li><span class="folder">Recep&ccedil;&atilde;o</span>
<? if ($perfil_id == 1 || $perfil_id == 5) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador">Listar Profissionais</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/motivocancelamento">Motivo cancelamento</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/tipoconsulta">Tipo consulta</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/horario">Manter Horarios</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda">Agenda Horarios</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame">Agenda Manter</a></span></ul>
                            <? } ?>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/sala">Manter Salas</a></span></ul>
<? } ?>
                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelodeclaracao">Modelo Declara&ccedil;&atilde;o</a></span></ul>
                        </li>
                        <li><span class="folder">Procedimento</span>                    
<? if ($perfil_id == 1 || $perfil_id == 3) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento">Manter Procedimentos</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/relatorioprocedimento">Relatorio Procedimentos</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/pesquisartuss">Manter Procedimentos TUSS</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/gerarelatorioprocedimentotuss">Relatorio Procedimentos TUSS</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoconvenio">Manter grupo convenio</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/convenio">Manter convenio</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano">Manter Procedimentos Convenio</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/relatorioprocedimentoconvenio">Relatorio Procedimentos Convenio</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentopercentual">Manter Percentual M&eacute;dico</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/classificacao">Manter Classificacao</a></span></ul>
<? } ?>
                        </li>
                        <li><span class="folder">Imagem</span> 
<? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelolaudo">Manter Modelo Laudo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelolinha">Manter Modelo Linha</a></span></ul>
                        <? } ?>
                        </li>
<? if ($internacao == 't') { ?>
                            <li><span class="folder">Interna&ccedil;&atilde;o</span>
                                <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarmotivosaida">Manter Motivo Saida</a></span></ul> 
                            </li>
                            <? } ?>
                        <li><span class="folder">Consulta</span> 
<? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 6) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloreceita">Manter Modelo Receita</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloatestado">Manter Modelo Atestado</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloreceitaespecial">Manter Modelo R. Especial</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelosolicitarexames">Manter Modelo S.Exames</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelomedicamento">Manter Medicamento</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelomedicamento/pesquisarunidade">Manter Medicamento Unidade</a></span></ul>
<? } ?>
                        </li>
                        <li><span class="folder">Estoque</span>
<? if ($perfil_id == 1 || $perfil_id == 8) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/menu">Manter Menu</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/tipo">Manter Tipo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/classe">Manter Classe</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/subclasse">Manter Sub-Classe</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/unidade">Manter Medida</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/armazem">Manter Armazem</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/cliente">Manter Setor</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador/operadorsetor">Listar Operadores</a></span></ul>
<? } ?>
                        </li> 
                        <li><span class="folder">Financeiro</span>
<? if ($perfil_id == 1) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tipo">Manter Tipo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/classe">Manter Classe</a></span></ul>
    <!--                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/subclasse">Manter Sub-Classe</a></span></ul>-->
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/forma">Manter Conta</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento">Manter Forma de Pagamento</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento/grupospagamento">Forma de Pagamento Grupo</a></span></ul>
<? } ?>
                        </li> 
                        <li><span class="folder">Administrativas</span>
<? if ($perfil_id == 1 || $perfil_id == 3) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa">Manter Empresa</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/versao">Vers&atilde;o</a></span></ul>
<? } ?>
                        </li> 
                    </ul>
                </li>
                <li><span class="file"><a onclick="javascript: return confirm('Deseja realmente sair da aplicação?');"
                                          href="<?= base_url() ?>login/sair">Sair</a></span>
                </li>
            </ul>                       
            <!-- Fim da Barra Lateral -->
        </div>
        <div class="mensagem"><?
            if (isset($mensagem)): echo $mensagem;
            endif;
            ?></div>
        <script type="text/javascript">
            $("#menu").treeview({
                animated: "normal",
                persist: "cookie",
                collapsed: true,
                unique: true
            });
            
            $(function(){

                jQuery("#contatos_chat_lista").click( function () {
                    //mostrando a lista de contatos
                    carregacontatos();
                    
                    jQuery("#principalChat #usuarios_online").mouseleave( function () {
                        $("#principalChat #usuarios_online ul li").remove();
                    });
                });
                
            });
            
                
            //abrindo a janelas de batepapo
            $(function(){
                $("#principalChat #usuarios_online ul li a").live('click', function () {
                    var id = jQuery(this).attr("id");
                    jQuery(this).removeClass("comecarChat");

                    var status = jQuery(this).next().attr("class");
                    var splitId = id.split(":");
                    var idJanela = Number(splitId[1]);

                    if (jQuery("#janela_" + idJanela).length == 0) {
                        var nome = jQuery(this).text();
                        adicionarJanela(id, nome, status);
                        retorna_historico(idJanela);
                    } else {
                        jQuery(this).removeClass("comecarChat");
                    }
                });
            });

            //minimizando as janelas
            $(function(){
                jQuery("#principalChat .cabecalho_janela_chat").live('click', function () {
                    var corpo_janela_chat = jQuery(this).next();
                    corpo_janela_chat.toggle(100);
                });
            });


            //fechando a janela
            $(function(){
                jQuery("#principalChat .fechar").live('click', function () {

                    var janelaSelecionada = jQuery(this).parent().parent();
                    var idJanela = janelaSelecionada.attr("id");
                    var janelaSplit = idJanela.split("_");
                    var janelaFechada = Number(janelaSplit[1]);

                    var janelasAbertas = Number(jQuery(".janela_chat").length) - 1;
                    var indice = Number(jQuery(".fechar").index(this));
                    var janelasAfrente = janelasAbertas - indice;

                    for (var i = 1; i <= janelasAfrente; i++) {
                        jQuery(".janela_chat:eq(" + (indice + i) + ")").animate({right: "-=285"}, 200);
                    }

                    janelaSelecionada.remove();
                    jQuery("#usuarios_online li#" + janelaFechada + " a").addClass("comecar");

                    var test;
                    for (var i = 0; i < chatsAbertos.length; i++) {
                        test = Number(chatsAbertos[i]);
                        if (janelaFechada == test) {
                            chatsAbertos.splice(i, 1);
                            break;
                        }
                    }
                });
            });

            //Enviando mensagens
            $(function(){
                jQuery("#principalChat .mensagem_chat").live('keyup', function (tecla) {

                    if (tecla.which == 13) {
                        var texto = jQuery(this).val();
                        var len = Number(texto.length);

                        if (len > 0) {
                            var id = jQuery(this).attr("id");
                            var splitId = id.split(":");
                            var operadorOrigem = Number(splitId[0]);
                            var operadorDestino = Number(splitId[1]);
                            jQuery.ajax({
                                type: "GET",
                                url: "<?= base_url(); ?>" + "batepapo/enviarmensagem",
                                data: "mensagem=" + texto + "&origem=" + operadorOrigem + "&destino=" + operadorDestino,
                                success: function () {
                                    jQuery('.mensagem_chat').val('');
                                    verifica(0, 0, <? echo $operador_id ?>);
                                }
                            });
                        }

                    }
                });
            });
//
            //Atualizando novas mensagens (LongPolling)
            function verifica(timestamp, ultimoId, operadorOrigem) {
                var t;

                jQuery.ajax({
                    url: "<?= base_url(); ?>" + "batepapo/atualizamensagens",
                    type: "GET",
                    data: 'timestamp=' + timestamp + '&ultimoid=' + ultimoId + '&usuario=' + operadorOrigem,
                    dataType: 'json',
                    success: function (retorno) {
                        clearInterval(t);

                        if (retorno.status == 'resultados' || retorno.status == 'vazio') {

//                                //funcao chamando a si mesma a cada 1s
//                                t = setTimeout(function () {
//                                    verifica(retorno.timestamp, retorno.ultimoId, retorno.operadorOrigem);
//                                }, 2000);


                            //verifica se ha mensagens novas
                            if (retorno.status == 'resultados') {
                                jQuery.each(retorno.dados, function (i, msg) {

                                    //testando se ela ja esta aberta
                                    if (jQuery("#janela_" + msg.janela).length > 0) {

                                        if (jQuery("#janela_" + msg.janela + " .mensagens_chat ul li#" + msg.chat_id).length == 0 && msg.janela > 0) {

                                            if (operadorOrigem == msg.id_origem) {
                                                jQuery("#janela_" + msg.janela + " .mensagens_chat ul").append("<li class='eu' id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p></li>");
                                            } else {
                                                jQuery("#janela_" + msg.janela + " .mensagens_chat ul").append("<li id='" + msg.chat_id + "'><div class='imgPerfil'></div><p>" + msg.mensagem + "</p></li>");
                                            }
                                        }

                                        jQuery.ajax({
                                            url: "<?= base_url(); ?>" + "batepapo/visualizacontatoaberto",
                                            type: "GET",
                                            data: 'operador_destino=' + msg.janela,
                                            success: function () {

                                            }
                                        });
                                    }
                                });

                                var altura = jQuery(".corpo_janela_chat .mensagens_chat").height();
                                jQuery(".corpo_janela_chat .mensagens_chat").animate({scrollTop: 1000000}, '500');
                            }
                        }
                    },
                    error: function (retorno) {
                        clearInterval(t);
                        t = setTimeout(function () {
                            verifica(retorno.timestamp, retorno.ultimoId, retorno.operadorOrigem);
                        }, 10000);
                    }
                });
            }

            function buscamensagens() {
                setInterval(function () {
                    verifica(0, 0,<? echo $operador_id ?>);
                    mensagensnaolidas();
                }, 3000);
            }

            buscamensagens();

        </script>
