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
        <title>STG - SOLUCAO EM TECNOLOGIA DE GESTAO v1.0</title>
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
        <!--<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>-->
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
                            jQuery(".batepapo_div #contatos_chat_lista").append("<span class='total_mensagens'>+"+retorno+"</span>");
                            abrindomensagensnaolidas();
                        }
                    }
                });
            }
            
            
            function abrindomensagensnaolidas() {
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>" + "batepapo/abrindomensagensnaolidas",
                    dataType: "json",
                    success: function (retorno) {
                        
                        if(retorno.length > 0){
                            for (var obj in retorno){
                                var id = "<?= $operador_id ?>:" + retorno[obj].operador_id;
                                var nome = retorno[obj].usuario;
                                var status = null;    
                                var aberta = false;
                                for (var i = 0; i < chatsAbertos.length; i++){
                                    if(retorno[obj].operador_id == chatsAbertos[i]){
                                        aberta = true;
                                    }
                                }
                                if(!aberta){
                                    adicionarJanela(id, nome, status);
                                }
                            }
                        }
                        
                    }
                });
            }

            //carrega a lista de contatos ao clicar no icone do batepapo
            function carregacontatos() {
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>" + "batepapo/pesquisar",
                    dataType: "json",
                    success: function (retorno) {
                        //traz uma lista com todos os operadores cadastrados, exceto a pessoa que esta logada
                        jQuery.each(retorno, function (i, usr) {
                            var tags = null;
                            if (usr.operador_id != <? echo $operador_id ?> && usr.usuario != 0) {
                                // Toda item da lista e construido da seguinte maneira:
                                // TAG <li> com o id do operador correspondente aquele item
                                // TAG <div> dentro de <li> com o classe imgPerfil (onde ficara a foto de perfil do usuario)
                                // TAG <a> dentro de <li> que ira servir de link para iniciar a janela de batepapo. Esta estruturada da seguinte forma:
                                //     href com endereco cego 
                                //     id com id do operador logado e do operador clicado, separado por ':'. Exemplo id="1:4327"
                                //     class com o valor "comecarChat", que ira servir para impedir que o usuario abra duas vezes o mesmo contato.
                                //          quando e clicado em um item o valor automaticamente e removido
                                // TAG <span> com class='total_mensagens' mostrando o numero de mensagens nao lidas daquele contato
                                // TAG <span> que futuramente indicara se o uusuario esta online ou offline
                                tags = "<li id='" + usr.operador_id + "'><div class='imgPerfil'></div>";
                                tags += "<a href='#' id='<? echo $operador_id ?>:" + usr.operador_id + "' class='comecarChat'>" + usr.usuario + "</a>";
                                if (usr.num_mensagens != 0) {
                                    tags += "<span class='total_mensagens'> +" + usr.num_mensagens + " </span>";
                                }
                                tags += "<span id='"+usr.operador_id+"'></span></li>";
                                
                                //apos criar o item, adciona ele a lista e cria-se o item seguinte
                                jQuery("#principalChat #usuarios_online ul").append(tags);
                            }
                        });
                    }
                });
            }

            
            //abri uma nova janela de batepapo
            function adicionarJanela(id, nome, status) {
                //o parametro ID diz respeito ao operador_id que mandou a mensagem
                //o parametro NOME diz respeito ao nome de usuario de quem mandou a mensagem
                //o parametro STATUS e para saber se quem mandou a mensagem esta online no momento


                //o numero maximo de janelas permitido sao cinco
                var numeroJanelas = Number(jQuery("#chats .janela_chat").length);
                if (numeroJanelas < 5) {
                    
                    //atribui dinamicamente a posicao da janela na pagina
                    var posicaoJanela = (270 + 15) * numeroJanelas;
                    var estiloJanela = 'float:none; position: absolute; bottom:0; right:' + posicaoJanela + 'px';

                    //pega o id do operador origem e do operador destino
                    var splitOperadores = id.split(':');
                    var operadorDestino = Number(splitOperadores[1]);
                    
                    
                    // CRIANDO A JANELA DE BATEPAPO
                    // Toda janela de batepapo e construida da seguinte maneira:
                    // TAG <div> class='janela_chat' (serve para estilizar via CSS) e id que contera o id do contado aberto
                    //           tornando diferente cada janela aberta e auxiliando em alguns eventos. 
                    //           (tais como fechar o chat e atualizar na lista de chatsAbertos). Todas as divs abaixos estao contidas nessa.
                    // TAG <div> dentro da principal com class='cabecalho_janela_chat'(estilizacao via CSS). Essa contera o cabecalho da 
                    //           janela. Exemplo: icone de fechar, nome, status (futuramente)
                    //              TAG <span> com class='fechar' para fecchar janela
                    //              TAG <span> com class='nome_chat' para mostrar o nome do usuario
                    //              TAG <span> que futuramente mostrara status
                    // TAG <div> com class='corpo_janela_chat' que contera as mensagens deste contato e o input para enviar mensagens.
                    //           TAG <div> com class='mensagens_chat' que dentro tera uma lista <ul> mostrando as mensagens
                    //                  cada mensagem em uma janela aberta esta dentro de uma <li>, nesta <ul>
                    //           TAG <div> com class='enviar_mensagens_chat' que tera o input para enviar as mensagens
                    //                  essa div tera um id com o id do operador logado e do operador qe ela esta dialogando
                    //                  para ajudar em eventos do javascript.
                    //                  o INPUT tem um valor maximo de 300 caracteres
                    var janela;
                    janela = "<div class='janela_chat' id='janela_" + operadorDestino + "' style='" + estiloJanela + "'>";
                    janela += "<div class='cabecalho_janela_chat'> <a href='#' class='fechar'>X</a>"; 
                    janela += "<span class='nome_chat'>" + nome + "</span><span id='" + operadorDestino + "'></span></div>";
                    janela += "<div class='corpo_janela_chat'><div class='mensagens_chat'><ul></ul></div>";
                    janela += "<div class='enviar_mensagens_chat' id='" + id + "'>";
                    janela += "<input type='text' maxlength='300' name='mensagem_chat' class='mensagem_chat' id='" + id + "' /></div></div></div>";

                    //acrescenta a janela ao aside chats
                    jQuery("#chats").append(janela);
                    //adiciona a janela criada na lista de janelas abertas
                    chatsAbertos.push(operadorDestino);
                    //retorna o historico de mensagens e faz a pagina se atualizar novamente
                    verifica(0, 0,<? echo $operador_id ?>);
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
                        <a id="contatos_chat_lista" href="#" class="nao_clicado">
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
                <li><span class="folder">Estoque</span>
                    <ul>
                        <li><span class="folder">Rotinas</span>
                            <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/solicitacao">Manter Pedido</a></span></ul>
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
                
                <li><span class="folder">Configura&ccedil;&atilde;o</span>
                    <ul>
                        
                        <li><span class="folder">Estoque</span>
<? if ($perfil_id == 1 || $perfil_id == 8) { ?>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/menu">Manter Menu</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/tipo">Manter Tipo</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/classe">Manter Classe</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/subclasse">Manter Sub-Classe</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/unidade">Manter Medida</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/armazem">Manter Armazem</a></span></ul>
                                <ul><span class="file"><a href="<?= base_url() ?>estoque/cliente">Manter Cliente</a></span></ul>
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
            
            jQuery(function(){
                
                jQuery("#contatos_chat_lista").click( function () {
                    
                    var classe = jQuery("#contatos_chat_lista").attr("class");
                    
                    //verificando se o usuario ja clicou no icone de batepapo
                    if(classe == 'nao_clicado'){
                        //mostrando a lista de contatos
                        carregacontatos();
                        jQuery("#contatos_chat_lista").attr("class", 'clicado');

                        jQuery("#principalChat #usuarios_online").mouseleave( function () {
                            jQuery("#principalChat #usuarios_online ul li").remove();
                            jQuery("#contatos_chat_lista").attr("class", 'nao_clicado');
                        });
                    }
                });
                
            });
            
            jQuery(".total_mensagens").css("opacity","0.4");//define opacidade inicial
            //faz o numero de mensagens nao lidas piscar
            setInterval(function() {
                if($(".total_mensagens").css("opacity") == 0){
                    $(".total_mensagens").css("opacity","1");
                }
                else{
                  $(".total_mensagens").css("opacity","0");
                }
            }, 600);
                
                
            //abrindo a janelas de batepapo
            jQuery(function(){
                jQuery("#principalChat #usuarios_online ul li a").live('click', function () {
//                    console.log('teste');
                    var id = jQuery(this).attr("id");
                    jQuery(this).removeClass("comecarChat");

                    var status = jQuery(this).next().attr("class"); 
//                    console.log(status);
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
            jQuery(function(){
                jQuery("#principalChat .cabecalho_janela_chat").live('click', function () {
                    var corpo_janela_chat = jQuery(this).next();
                    corpo_janela_chat.toggle(100);
                });
            });


            //fechando a janela
            jQuery(function(){
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
            jQuery(function(){
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
            
            //Atualizando novas mensagens
            function verifica(timestamp, ultimoId, operadorOrigem) {
                var t;
                
                //ESSA FUNCAO IRA VERIFICAR SE HA NOVAS MENSAGENS PARA OS CONTATOS ABERTOS OU NOVAS MENSAGENS NAO LIDAS
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
                                        
                                        //caso a janela ja esteja aberta adciona as novas mensagens em uma tag <li> e incrementa elas a <ul> da janela correspondente
                                        if (jQuery("#janela_" + msg.janela + " .mensagens_chat ul li#" + msg.chat_id).length == 0 && msg.janela > 0) {

                                            if (operadorOrigem == msg.id_origem) {
                                                jQuery("#janela_" + msg.janela + " .mensagens_chat ul").append("<li class='eu' id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p></li>");
                                            } else {
                                                jQuery("#janela_" + msg.janela + " .mensagens_chat ul").append("<li id='" + msg.chat_id + "'><div class='imgPerfil'></div><p>" + msg.mensagem + "</p></li>");
                                            }
                                        }
                                        
                                        //CASO O CONTATO ESTEJA ABBERTO ELE MARCA A MENSAGEM COMO LIDA
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
//            mensagensnaolidas();

        </script>
