<?
//Da erro no home
if ($this->session->userdata('autenticado') != true) {
    redirect(base_url() . "login/index/login004", "refresh");
}
// // $this->load->model('login_model', 'login');
$empresa_id = $this->session->userdata('empresa_id');
$this->db->select('ep.*');
$this->db->from('tb_empresa_permissoes ep');
//        
$this->db->where('ep.empresa_id', $empresa_id);
$retorno_header = $this->db->get()->result();
// session_cache_limiter();
// var_dump(@$retorno_header[0]->agenda_modelo2); die;
$chat = $this->session->userdata('chat');
$geral = $this->session->userdata('geral');
$ponto = $this->session->userdata('ponto');
$caixa = $this->session->userdata('caixa');
$imagem = $this->session->userdata('imagem');
$estoque = $this->session->userdata('estoque');
$consulta = $this->session->userdata('consulta');
$farmacia = $this->session->userdata('farmacia');
$uso_salas = $this->session->userdata('uso_salas');
$perfil_id = $this->session->userdata('perfil_id');
$marketing = $this->session->userdata('marketing');
$enfermagem = $this->session->userdata('enfermagem');
$internacao = $this->session->userdata('internacao');
$financeiro = $this->session->userdata('financeiro');
$empresa_id = $this->session->userdata('empresa_id');
$calendario = $this->session->userdata('calendario');
$manternota = $this->session->userdata('manternota');
$operador_id = $this->session->userdata('operador_id');
$relatoriorm = $this->session->userdata('relatoriorm');
$odontologia = $this->session->userdata('odontologia');
$laboratorio = $this->session->userdata('laboratorio');
$faturamento = $this->session->userdata('faturamento');
$relatorio_rm = $this->session->userdata('relatorio_rm');
$logo_clinica = $this->session->userdata('logo_clinica');
$especialidade = $this->session->userdata('especialidade');
$endereco_toten = $this->session->userdata('endereco_toten');
$agenda_modelo2 = @$retorno_header[0]->agenda_modelo2;
$limitar_acesso = $this->session->userdata('limitar_acesso');
$fila_impressao = $this->session->userdata('fila_impressao');
$relatorio_caixa = $this->session->userdata('relatorio_caixa');
$centrocirurgico = $this->session->userdata('centrocirurgico');
$relatorio_ordem = $this->session->userdata('relatorio_ordem');
$integracaosollis = $this->session->userdata('integracaosollis');
$manter_indicacao = $this->session->userdata('manter_indicacao');
$calendario_layout = $this->session->userdata('calendario_layout');
$sala_de_espera = $this->session->userdata('autorizar_sala_espera');
$perfil_marketing_p = $this->session->userdata('perfil_marketing_p');
$medicinadotrabalho = $this->session->userdata('medicinadotrabalho');
$medico_solicitante = $this->session->userdata('medico_solicitante');
$orcamento_recepcao = $this->session->userdata('orcamento_recepcao');
$relatorio_producao = $this->session->userdata('relatorio_producao');
$relatorio_operadora = $this->session->userdata('relatorio_operadora');
$relatorios_recepcao = $this->session->userdata('relatorios_recepcao');
$financeiro_cadastro = $this->session->userdata('financeiro_cadastro');
$caixa_personalizado = $this->session->userdata('caixa_personalizado');
$profissional_agendar = $this->session->userdata('profissional_agendar');
$profissional_agendar_o = $this->session->userdata('profissional_agendar_o');
$gerente_contasapagar = $this->session->userdata('gerente_contasapagar');
$subgrupo_procedimento = $this->session->userdata('subgrupo_procedimento');
$relatorios_clinica_med = $this->session->userdata('relatorios_clinica_med');
$relatorio_demandagrupo = $this->session->userdata('relatorio_demandagrupo');
$procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
$gerente_recepcao_top_saude = $this->session->userdata('gerente_recepcao_top_saude');
$retirar_preco_procedimento = $this->session->userdata('retirar_preco_procedimento');
$gerente_relatorio_financeiro = $this->session->userdata('gerente_relatorio_financeiro');

//var_dump($agenda_modelo2); die;
function alerta($valor) {
    echo "<script>alert('$valor');</script>";
}

function debug($object) {
    
}

//$this->load->model('login_model', 'login');
//$registro_sms_id = $this->login->listarempresapermissoes();
?>
<!DOCTYPE html PUBLIC "-//carreW3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >
    <head>
        <style>
            .ui-autocomplete-loading {
                background: white url("<?= base_url(); ?>img/ui-anim_basic_16x16.gif") right center no-repeat;
            }
        </style>
        <title>STG - SISTEMA DE GESTAO DE CLINICAS v1.0</title>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->
        <link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/batepapo.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
        <!--<link href="<?= base_url() ?>js/fullcalendar/lib/cupertino/jquery-ui.min.css" rel="stylesheet" />-->
        <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
        <!--<script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/jquery.min.js"></script>-->
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
        <!--<script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/jquery.min.js"></script>-->
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
        <!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.js" ></script>-->
        <script type="text/javascript">
//            var jQuery = jQuery.noConflict();

            (function ($) {
                $(function () {
                    $('input:text').setMask();
                });
            })(jQuery);

            // Fazendo atualização da tabela de SMS
            jQuery(function () {
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>" + "login/verificasms",
                    dataType: "json"
                });
            });

            // Checando lembretes
            jQuery(function () {
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>ambulatorio/empresa/checandolembrete",
                    dataType: "json",
                    success: function (retorno) {
//                        alert('ola');
                        for (var i = 0; i < retorno.length; i++) {
                            if (retorno[i].visualizado == 0) {
                                alert(retorno[i].texto);
                                jQuery.ajax({type: "GET", data: "lembretes_id=" + retorno[i].empresa_lembretes_id,
                                    url: "<?= base_url(); ?>ambulatorio/empresa/visualizalembrete"});
                            }
                        }
                    }
                });
            });

            // Checando lembretes aniversário
            jQuery(function () {
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>ambulatorio/empresa/checandolembreteaniversario",
                    dataType: "json",
                    success: function (retorno) {
                        //    alert('ola');
                        //    console.log(retorno);
                        if (retorno != null) {
                            alert(retorno[0]);
                            jQuery.ajax({type: "GET", data: "lembretes_id=" + retorno[1],
                                url: "<?= base_url(); ?>ambulatorio/empresa/visualizalembreteaniv"});
                        }
                    },
                    error: function () {
//                        alert('Error');
                    }
                });
            });


<? if ($chat == 't') { ?>

                var chatsAbertos = new Array();

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
                                jQuery(".batepapo_div #contatos_chat_lista").append("<span class='total_mensagens'>+" + retorno + "</span>");
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

                            if (retorno.length > 0) {
                                for (var obj in retorno) {
                                    var id = "<?= $operador_id ?>:" + retorno[obj].operador_id;
                                    var nome = retorno[obj].usuario;
                                    var status = null;
                                    var aberta = false;
                                    for (var i = 0; i < chatsAbertos.length; i++) {
                                        if (retorno[obj].operador_id == chatsAbertos[i]) {
                                            aberta = true;
                                        }
                                    }
                                    if (!aberta) {
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
                                    //     id com id do operador logado e do operador clicado, separado por ':'. Exemplo id="1:4327";
                                    //     class com o valor "comecarChat", que ira servir para impedir que o usuario abra duas vezes o mesmo contato.
                                    //          quando é clicado em um item o valor da class automaticamente é removido
                                    // TAG <span> com class='total_mensagens' mostrando o numero de mensagens nao lidas daquele contato
                                    // TAG <span> que futuramente indicara se o uusuario esta online ou offline
                                    tags = "<li id='" + usr.operador_id + "'><div class='imgPerfil'></div>";
                                    tags += "<a href='#' id='<? echo $operador_id ?>:" + usr.operador_id + "' class='comecarChat'>" + usr.usuario + "</a>";
                                    if (usr.num_mensagens != 0) {
                                        tags += "<span class='total_mensagens'> +" + usr.num_mensagens + " </span>";
                                    }
                                    if (usr.status == 't') {
                                        var status = 'on';
                                    } else {
                                        var status = 'off';
                                    }
                                    tags += "<span id='" + usr.operador_id + "' class='status " + status + "'></span></li>";

                                    //apos criar o item, adciona ele a lista e cria-se o item seguinte
                                    jQuery("#principalChat #usuarios_online ul").append(tags);
                                }
                            });
                        }
                    });
                    //                    verifica(0, 0,<? echo $operador_id ?>);
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
                        janela += "<span class='nome_chat'>" + nome + "</span><span id='" + operadorDestino + "' class='" + status + "'></span></div>";
                        janela += "<div class='corpo_janela_chat'><div class='mensagens_chat'><ul></ul></div>";
                        janela += "<div class='enviar_mensagens_chat' id='" + id + "'>";
                        janela += "<input type='text' maxlength='300' name='mensagem_chat' class='mensagem_chat' id='" + id + "' /></div></div></div>";

                        //acrescenta a janela ao aside chats
                        jQuery("#chats").append(janela);
                        //adiciona a janela criada na lista de janelas abertas
                        chatsAbertos.push(operadorDestino);
                        //retorna o historico de mensagens e faz a pagina se atualizar novamente
                        retorna_historico(operadorDestino);
                        //                        verifica(0, 0,<? // echo $operador_id                                                       ?>);
                    }
                }

                //retornando historico de conversas
                function retorna_historico(idJanela) {
                    //                    console.log('teste');
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
                                        jQuery("#janela_" + msg.janela + " .corpo_janela_chat .mensagens_chat ul").append("<li class='eu' id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p><div class='data_envio'>" + msg.data_envio + "</div></li>");
                                    } else {
                                        jQuery("#janela_" + msg.janela + " .corpo_janela_chat .mensagens_chat ul").append("<li id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p><div class='data_envio'>" + msg.data_envio + "</div></li>");
                                    }
                                }
                            });
                            var altura = jQuery("#janela_" + idJanela + " .corpo_janela_chat .mensagens_chat").height();
                            jQuery("#janela_" + idJanela + " .corpo_janela_chat .mensagens_chat").animate({scrollTop: 1000000}, '500');
                        }
                    });
                    //                    verifica(0, 0,<? // echo $operador_id                                                         ?>);
                }

<? } ?>


        </script>

    </head>
    <script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>

    <?php
    $this->load->library('utilitario');
    // var_dump($this->session->flashdata('message'));die;
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
                    <?
                    $numLetras = strlen($this->session->userdata('empresa'));
                    $css = ($numLetras > 20) ? 'font-size: 7pt' : '';
                    ?>
                    <label style='font-family: serif; font-size: 8pt;'>Empresa: <span style="<?= $css ?>"><?= $this->session->userdata('empresa'); ?></span></label>
                </div>
                <div id="login_controles">

                    <!--<a href="#" alt="Alterar senha" id="login_pass">Alterar Senha</a>-->

                    <a id="login_sair" title="Sair do Sistema" onclick="javascript: return confirm('Deseja realmente sair da aplicação?');"
                       href="<?= base_url() ?>login/sair">Sair</a>

                    <? if ($chat == 't') { ?>
                        <div class="batepapo_div">
                            <a id="contatos_chat_lista" href="#" class="nao_clicado">
                                <img src="<?= base_url(); ?>img/chat_icon.png" alt="Batepapo"
                                     title="Batepapo"/></a>
                        </div>
                    <? } ?>
                </div>
                <!--<div id="user_foto">Imagem</div>-->

            </div>


            <? if ($logo_clinica == 't') { ?>
                <div id="imgLogoClinica">
                    <img src="<?= base_url(); ?>upload/logomarca/<?= $empresa_id; ?>/logomarca.jpg" alt="Logo Clinica"
                         title="Logo Clinica" height="70" id="Insert_logo" />
                </div>
            <? } ?>
        </div>
        <div class="decoration_header">&nbsp;</div>

        <? if ($chat == 't') { ?>
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
        <? } ?>

        <!-- Fim do Cabeçalho -->
        <div class="barraMenus" style="float: left;">
            <div>
                <ul id="menu" class="filetree">
                    <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || ( $perfil_marketing_p == 't' && $perfil_id == 14)|| $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 15 || $perfil_id == 19 || ( $financeiro_cadastro == 't' && $perfil_id == 13)) { ?>

                        <li><span class="folder">Recep&ccedil;&atilde;o</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
                                    <? if (($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 ||( $perfil_marketing_p == 't' && $perfil_id == 14) || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 15 || $perfil_id == 19) || ( $financeiro_cadastro == 't' && $perfil_id == 13)) {
                                        ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/pacientes">Cadastro</a></span></ul> 
                                        <? if ($endereco_toten != '') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/operadorguiche">Operador Guichê</a></span></ul> 
                                        <? } ?>

                                        <?
                                        if ($perfil_id != 11 && $perfil_id != 4 && $perfil_id != 15 || ( $perfil_marketing_p == 't' && $perfil_id == 14)) {
                                            if ($relatorios_clinica_med != 't') {
                                                if ($caixa == 't') {
                                                    ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listaresperacaixa">Fila Caixa</a></span></ul>
                                                    <?
                                                }
                                            }
                                        }
                                        if ($endereco_toten != '') {
                                            ?> 
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listaresperasenhas">Senhas</a></span></ul>

                                            <?
                                        }

                                        if ($perfil_id != 4 && $perfil_id != 13 || ( $perfil_marketing_p == 't' && $perfil_id == 14)) {
                                            ?>
                                            <? if ($calendario == 't') { ?>
                                                <?
                                                if ($geral == 't') {
                                                    if ($calendario_layout == 't') {
                                                        ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario2" target="_blank">Multifuncao Geral</a></span></ul>
                                                    <? } else {
                                                        ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaocalendario" target="_blank">Multifuncao Geral</a></span></ul>
                                                        <?
                                                    }
                                                }
                                                ?>
                                                <?
                                                if ($relatorios_clinica_med != 't') {

                                                    if ($imagem == 't') {
                                                        ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoexamecalendario" target="_blank">Multifuncao Exame </a></span></ul>
                                                    <? } ?>
                                                    <? if ($consulta == 't') { ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsultacalendario" target="_blank">Multifuncao Consulta </a></span></ul>
                                                    <? } ?>
                                                    <? if ($especialidade == 't') { ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoespecialidadecalendario" target="_blank">Multifuncao Especialidade </a></span></ul> 
                                                        <?
                                                    }
                                                }
                                                ?>




                                            <? } else { ?>


                                                <? if ($geral == 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaogeral">Multifuncao Geral</a></span></ul>
                                                <? } ?>
                                                <? if ($imagem == 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncao">Multifuncao Exame</a></span></ul>
                                                <? } ?>
                                                <? if ($consulta == 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaoconsulta">Multifuncao Consulta</a></span></ul>
                                                <? } ?>
                                                <? if ($especialidade == 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaofisioterapia">Multifuncao Especialidade</a></span></ul>
                                                <? } ?>
                                            <? }
                                            ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/reagendamentogeral">Reagendamento Geral</a></span></ul>-->   
                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listaragendamentomultiempresa">Agendamento Multiempresa</a></span></ul>-->

                                            <? if ($perfil_id != 11 && $perfil_id != 2) { ?>
                                                <? if ($geral == 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/medicoagendageral">Medico agenda geral</a></span></ul>
                                                <? } ?>
                                                <?
                                                if ($relatorios_clinica_med != 't') {
                                                    if ($imagem == 't') {
                                                        ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/medicoagenda">Medico agenda exame</a></span></ul>
                                                    <? }
                                                    ?>
                                                    <? if ($consulta == 't') { ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/medicoagendaconsulta">Medico agenda consulta</a></span></ul>
                                                    <? } ?>
                                                    <? if ($especialidade == 't') { ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/medicoagendaespecialidade">Medico agenda especialidade</a></span></ul>
                                                        <?
                                                    }
                                                }
                                                ?>    



                                                <?
                                            } if ($relatorios_clinica_med != 't') {
                                                if ($uso_salas == 't') {
                                                    ?>
                                                    <ul><span class="file"><a target="_blank" href="<?= base_url() ?>ambulatorio/exame/relatoriousosala">Uso de Salas</a></span></ul>

                                                    <?
                                                }
                                                if (($perfil_id != 11 && $perfil_id != 12 && $perfil_id != 5 && $perfil_id != 18 && $perfil_id != 6) || $orcamento_recepcao == 't') {
                                                    if ($retirar_preco_procedimento == "t") {
                                                        ?>
                                                        <ul><span class="file"><a target="_blank" href="<?= base_url() ?>ambulatorio/procedimentoplano/orcamento/0">Orçamento</a></span></ul>
                                                        <?
                                                    }
                                                } else {
                                                    ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentoplanoconsulta">Pre&ccedil;o procedimento</a></span></ul>
                                                    <?
                                                }
                                            } {
                                                ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentoplanoconsulta">Pre&ccedil;o procedimento</a></span></ul>
                                                <?
                                            }


                                            if ($perfil_id != 11 && $perfil_id != 2) {
                                                if ($this->session->userdata('recomendacao_configuravel') != "t") {
                                                    if ($relatorios_clinica_med != 't') {
                                                        if ($manter_indicacao == 't') {
                                                            ?>
                                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/indicacao">Manter indica&ccedil;&atilde;o</a></span></ul>
                                                        <? } ?>
                                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/indicacao/pesquisargrupoindicacao">Manter Grupo Indicação</a></span></ul>
                                                        <?
                                                    }
                                                }
                                                if ($fila_impressao == 't') {
                                                    ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/pesquisarfiladeimpressao">Fila de Impressão</a></span></ul>
                                                    <?
                                                }
                                                if ($medico_solicitante == 't') {
                                                    ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador/pesquisarmedicosolicitante">Editar Medico Solicitante</a></span></ul>


                                                <? } ?>
                                            <? } ?>
                                        <? } ?>
                                        <? if ($relatorios_clinica_med != 't') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador/pesquisaragendatelefonica">Agenda Telefônica</a></span></ul>
                                        <? } elseif ($perfil_id == 9 || ( $perfil_marketing_p == 't' && $perfil_id == 14)) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listaresperacaixa">Fila Caixa</a></span></ul>
                                            <?
                                        }
                                    }
                                    ?>
                                </li>
                                <li><span class="folder">Relatorios</span>
                                    <? if ((($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 18 || $perfil_id == 5 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 15 || $perfil_id == 19) && $relatorios_recepcao == 't') || ( $perfil_marketing_p == 't' && $perfil_id == 14) || ($relatorios_recepcao == 'f' && ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 15 || $perfil_id == 19))) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriorecepcaoagenda">Relatorio Recepção Agenda</a></span></ul>
                                        <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriorecepcaoagendaduplicidade">Relatorio Duplicidade Agenda</a></span></ul>-->
        <!--                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriomedicoagendaconsultas">Relatorio agenda Consulta</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriomedicoagendafaltou">Relatorio agenda faltas</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriomedicoagendaexame">Relatorio agenda Exames</a></span></ul>-->
                                        <?
                                        if (($perfil_id != 11 && $perfil_id != 12 && $perfil_id != 5 && $perfil_id != 18 && $perfil_id != 6) || $relatorio_ordem == 't') {
                                            if ($relatorios_clinica_med != 't') {
                                                ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriomedicoordem">Relatorio ordem atendimento</a></span></ul>
                                                <?
                                            }
                                        }
                                        if ($relatorios_clinica_med != 't') {
                                            ?>        
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioconvenioquantidade">Convenio exames/consultas</a></span></ul>
                                        <? } ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioaniversariante">Relatorio Aniversariantes</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriopacientetelefone">Relatorio Paciente Telefone</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatorioretorno">Relatorio Retorno</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatorioencaminhamento">Relatorio Encaminhamentos</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriorevisao">Relatorio Revisão</a></span></ul>
                                        <? if ($relatorio_operadora == 't') { ?> 
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatorioteleoperadora">Relatorio Operadora</a></span></ul>
                                        <? } ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatorioorcamentos">Relatorio Orçamentos</a></span></ul>
                                        <? if ($relatorios_clinica_med != 't') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriopacienteduplicado">Relatorio Pacientes Duplicados</a></span></ul>

                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriopacientecpfvalido">Relatorio Paciente CPF Válido</a></span></ul>

                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriosituacaoatendimento">Relatorio Situação de Atendimento</a></span></ul>
                                            <? if ($relatorio_demandagrupo == 't') { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/relatoriodemandagrupo">Relatorio de Demanda Grupo</a></span></ul>

                                                <?
                                            }
                                        }
                                    }
                                    if ($relatorio_caixa == 't') {
                                        ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixa">Relatorio Caixa</a></span></ul>
                                        <?
                                    }
                                    if ($perfil_id == 1 || $perfil_id == 6 || $perfil_id == 15) {
                                        if ($relatorios_clinica_med != 't') {
                                            if ($relatorio_rm == 't') {
                                                ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogruporm">Relatorio RM</a></span></ul>
                                                <?
                                            }
                                        }
                                    }
                                    if (($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 15 ) && $relatorios_recepcao == 't') {
                                        ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriorecepcaomedicoconvenio">Relatorio Medico Convenio</a></span></ul>
                                        <?
                                    }
                                    if (($perfil_id != 9 && $perfil_id != 4 && $perfil_id != 7 && $perfil_id != 13) && $relatorios_recepcao == 't') {
                                        if ($relatorios_clinica_med != 't') {
                                            ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioatendenteconvenio">Relatorio Atendente Convenio</a></span></ul>
                                            <?
                                        }
                                    }
                                    ?>    
    <!--                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exametemp">Pacientes temporarios</a></span></ul>
    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/localizapaciente">Loacalizar pacientes</a></span></ul>-->
                                </li>
                            </ul>
                        </li>
                    <? } ?>
                    <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 7 || $perfil_id == 15) { ?>
                        <li><span class="folder">Atendimento</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>

                                                                                                    <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/painelrecepcao">Painel recepcao</a></span></ul>-->
                                    <? if ($sala_de_espera == 't') { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarsalasespera">Salas de Espera</a></span></ul>
                                    <? } ?>
                                        <? if ($limitar_acesso == 't') { ?>
                                        <? if ($perfil_id != 11) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarsalaspreparo">Salas de Preparo</a></span></ul>
                                        <? }
                                    } else {
                                        ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarsalaspreparo">Salas de Preparo</a></span></ul>

    <? } ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarexamerealizando">Salas de Atendimento</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarexamependente">Atendimentos pendentes</a></span></ul>

                                </li>
                            </ul>
                        </li>
                    <? } ?>
<? if ($imagem == 't' && ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 15 || $perfil_id == 19)) { ?>
                        <li><span class="folder">Imagem</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
    <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 15 || $perfil_id == 19) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedico">Multifuncao Medico</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo">Manter Laudo</a></span></ul>
        <? if ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 10) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisardigitador">Manter Laudo Digitador</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisarrevisor">Manter Revisor</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisarlaudoantigo">Manter Antigo</a></span></ul>
                                        <? } ?>
    <? } ?>     
                                </li>

                                <?
                                if ($relatorio_producao == 't') {
                                    ?>
                                    <li><span class="folder">Relatorios</span>
                                        <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12 && $perfil_id != 7 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
                                    <? } ?>    
                                    </li>   
                                    <?
                                }
                                ?>
                            </ul>
                        </li>
                    <? } ?>
<? if ($consulta == 't' && ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 19)) { ?>


                        <li><span class="folder">Consultas</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
    <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 19) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoconsulta">Multifuncao Medico</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisarconsulta">Manter Consulta</a></span></ul>
                                        <? if ($perfil_id == 1 || $perfil_id == 10) { ?>

                                        <? } ?>
                                        <? if ($perfil_id == 1 || $perfil_id == 10 || $perfil_id == 4) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/pesquisarconsultaantigo">Histórico de Consultas Antigas</a></span></ul>
                                        <? } ?>

    <? } ?>

                                </li> 
                                <?
                                if ($relatorio_producao == 't') {
                                    ?>
                                    <li><span class="folder">Relatorios</span>
                                        <? if ($perfil_id != 9 && $perfil_id != 7 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
                                    <? } ?>
                                    </li> 
    <? } ?>
                            </ul>
                        </li>
                    <? } ?>
<? if ($especialidade == 't' && ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 19)) { ?>


                        <li><span class="folder">Especialidade</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
                                    <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 19) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicofisioterapia">Multifuncao Especialidade</a></span></ul>
                                        <? if ($profissional_agendar == 't' && $profissional_agendar_o == 't') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicofisioterapiareagendar">Reagendar</a></span></ul>
                                        <? } ?>
                                        <?
                                    }
                                    ?>
                                </li>
                                <?
                                if ($relatorio_producao == 't') {
                                    ?>
                                    <li><span class="folder">Relatorios</span>
                                        <? if ($perfil_id != 9 && $perfil_id != 7 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
                                    <? } ?>
                                    </li>  
    <? } ?>
                            </ul>
                        </li>
                    <? } ?>
<? if ($odontologia == 't' && ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 19)) { ?>


                        <li><span class="folder">Odontologia</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
    <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 19) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoodontologia">Multifuncao Especialidade</a></span></ul>
                                        <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicoodontologiareagendar">Reagendar</a></span></ul>-->
                                        <?
                                    }
                                    ?>
                                </li>
                                <?
                                if ($relatorio_producao == 't') {
                                    ?>
                                    <li><span class="folder">Relatorios</span>
                                        <? if ($perfil_id != 9 && $perfil_id != 7 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
                                    <? } ?>
                                    </li>  
    <? } ?>
                            </ul>
                        </li>
                    <? } ?>
<? if ($laboratorio == 't' && ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 19)) { ?>
                        <li><span class="folder">Laboratorial</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
                                    <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 7 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 15 || $perfil_id == 19) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicolaboratorial">Multifuncao Laboratorial</a></span></ul>
                                        <?
                                    }
                                    ?>
                                </li>
                                <?
                                if ($relatorio_producao == 't') {
                                    ?>
                                    <li><span class="folder">Relatorios</span>
                                        <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
                                    <? } ?>
                                    </li>
    <? } ?>
                            </ul>
                        </li>
                    <? } ?>
<? if ($geral == 't' && ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 10 || $perfil_id == 19)) { ?>


                        <li><span class="folder">Geral</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
    <? if ($perfil_id == 1 || $perfil_id == 2 || $perfil_id == 3 || $perfil_id == 4 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 11 || $perfil_id == 12 || $perfil_id == 19) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicogeral">Multifuncao Geral</a></span></ul>
                                        <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/listarmultifuncaomedicofisioterapiareagendar">Reagendar</a></span></ul>-->
                                        <?
                                    }
                                    ?>
                                </li> 
                                <?
                                if ($relatorio_producao == 't') {
                                    ?>
                                    <li><span class="folder">Relatorios</span>
                                        <? if ($perfil_id != 9 && $perfil_id != 7 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenio">Relatorio de Produ&ccedil;&atilde;o</a></span></ul>
                                    <? } ?>    
                                    </li> 
    <? } ?>   
                            </ul>
                        </li>
                    <? } ?>
<? if ($faturamento == 't' && ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10 || $perfil_id == 16) || ($gerente_relatorio_financeiro == 't' && ($perfil_id == 18 || $perfil_id == 5))) { ?>


                        <li><span class="folder">Faturamento</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
                                    <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10 || $perfil_id == 16) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/faturamentoexame">Faturar</a></span></ul>
        <? if ($perfil_id != 10) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/faturamentomanual">Faturaramento Manual</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame/faturamentoexamexml">Gerar xml</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/laudo/faturamentolaudoxml">Gerar xml Laudo</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriovalorprocedimento">Ajustar Valores</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/ajustarvalorprocedimentocbhpm">Ajustar Valores CBHPM</a></span></ul>   
                                        <? } ?>

    <? } ?>
                                </li>
                                <li><span class="folder">Relatorios</span>
                                    <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10 || $perfil_id == 16 || ($gerente_relatorio_financeiro == 't' && $perfil_id == 18)) { ?>

        <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10 || $perfil_id == 16) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioexame">Relatorio Conferencia</a></span></ul>

                                            <? if ($medicinadotrabalho == 't') { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioaso">Relatorio ASO</a></span></ul>
            <? } ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriorecolhimento">Relatorio Recolhimento</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogastosala">Relatorio Gasto de Sala</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioguiasadt">Relatorio Solicit. SADT</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogeralsintetico">Relatorio Sintetico Geral</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioexamech">Relatorio Faturamento Convenio CH</a></span></ul>
                                            <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriopacienteexame">Relatorio Convenio Paciente</a></span></ul>-->
                                        <? } ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocancelamento">Relatorio Cancelamento</a></span></ul>
        <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10 || $perfil_id == 16) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriotempoesperaexame">Relatorio Tempo espera exame</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriotemposalaespera">Relatorio Tempo sala de espera</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogrupo">Relatorio Atendimento Grupo</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogrupoanalitico">Relatorio Atendimento Grupo Analitico</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriogrupoprocedimento">Relatorio Atendimento Grupo Procedimento</a></span></ul>
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
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioconveniovalor">Relatorio Convenio atendimento/consultas valor</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocomparativomensal">Relatorio Comparativo Mensal</a></span></ul>
        <? } ?>


    <? } ?>
                                </li> 
                            </ul>
                        </li>
                    <? } ?>
<? if ($estoque == 't') { ?>


                        <li><span class="folder">Estoque</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/solicitacao">Manter Solicitacao</a></span></ul>
                                    <? if ($enfermagem == 't') { ?>
        <? if ($perfil_id == 1 || $perfil_id == 8 || $perfil_id == 10 || $perfil_id == 7) { ?>
                                            <? if ($manternota != 't') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada">Manter Entrada</a></span></ul>
                                            <?}?>
                                            <? if ($manternota == 't') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/nota">Manter Nota Fiscal</a></span></ul>
                                            <?}?>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/inventario">Manter Inventario</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/fornecedor">Manter Fornecedor</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/produto">Manter Produto</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/pedido">Manter Pedido Compra</a></span></ul>
                                        <? }
                                    } else {
                                        ?>
        <? if ($perfil_id == 1 || $perfil_id == 8 || $perfil_id == 10) { ?>
                                            <? if ($manternota != 't') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada">Manter Entrada</a></span></ul>
                                            <?}?>
                                            <? if ($manternota == 't') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/nota">Manter Nota Fiscal</a></span></ul>
                                            <?}?>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/inventario">Manter Inventario</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/fornecedor">Manter Fornecedor</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/produto">Manter Produto</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>estoque/pedido">Manter Pedido Compra</a></span></ul>
                                        <?
                                        }
                                    }
                                    ?>
                                </li> 
                                <li><span class="folder">Relatorios</span>
    <? if ($perfil_id == 1 || $perfil_id == 8 || $perfil_id == 10) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaldoproduto">Relatorio Saldo Produtos</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/nota/relatorionotas">Relatorio Nota</a></span></ul>


                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatorioentradaarmazem">Relatorio Entrada Produtos</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaidaarmazem">Relatorio Saida Produtos</a></span></ul>


                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriominimo">Relatorio Estoque Minimo</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatorioprodutos">Relatorio Produtos</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriofornecedores">Relatorio Fornecedores</a></span></ul>


                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaldo">Relatorio Saldo Produtos Por Fornecedor</a></span></ul>

                                        <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaldoarmazem">Relatorio Saldo Produtos Por Entrada</a></span></ul>
                        <? } ?>
                                </li> 
                            </ul>
                        </li>
<? } ?>
<? if ($farmacia == 't') { ?>
                        <li><span class="folder">Farmácia</span>
                            <ul><? if ($perfil_id == 1 || $perfil_id == 8 || ($gerente_relatorio_financeiro == 't' && $perfil_id == 18)) { ?>
                                    <li><span class="folder">Rotinas</span>
                                        <!--<ul><span class="file"><a href="<?= base_url() ?>farmacia/solicitacao">Manter Solicitacao</a></span></ul>-->
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/entrada">Manter Entrada</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/menu">Manter Menu</a></span></ul>

                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/armazem">Manter Armazem</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/fornecedor">Manter Fornecedor</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/produto">Manter Produto</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/fracionamento">Fracionamento</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/saida">Saida por paciente</a></span></ul>
                                    </li> 
                                    <li><span class="folder">Relatórios</span>        
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/culente">Manter Setor</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/entrada/relatorioentradaarmazem">Relatorio Entrada Produtos</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/entrada/relatoriosaidaarmazem">Relatorio Saida Produtos</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/entrada/relatoriosaldoarmazem">Relatorio Saldo Produtos/Entrada</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/entrada/relatoriosaldo">Relatorio Saldo Produtos</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/entrada/relatoriominimo">Relatorio farmacia Minimo</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/entrada/relatorioprodutos">Relatorio Produtos</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>farmacia/entrada/relatoriofornecedores">Relatorio Fornecedores</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador/operadorsetor">Listar Operadores</a></span></ul>
                                    </li> 
                        <? } ?>
                            </ul>
                        </li>
<? } ?>

<? if ($financeiro == 't' && ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10 || $perfil_id == 16 || $perfil_id == 17 || $perfil_id == 18 || ($perfil_id == 5 && $gerente_contasapagar == 't') || ($gerente_recepcao_top_saude == 't' && $perfil_id == 5))) { ?>


                        <li><span class="folder">Financeiro</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
                                    <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa">Manter Entrada</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/pesquisar2">Manter Saida</a></span></ul>
                                    <? }
                                    ?>    
                                    <?
//                                    var_dump($gerente_contasapagar); die;
                                    ?>
                                    <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10 || ($perfil_id == 5 && $gerente_contasapagar == 't')) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/contaspagar">Manter Contas a pagar</a></span></ul>
                                    <? }
                                    ?> 

    <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/contasreceber">Manter Contas a Receber</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/pesquisar3">Manter Sangria</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/fornecedor">Manter Credor/Devedor</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/painelfinanceiro">Painel Financeiro</a></span></ul>
                                    <? }
                                    ?>    
                                </li> 
                                <li><span class="folder">Relatorios</span>
    <?
    if ($perfil_id == 1 || $perfil_id == 13 || ($gerente_relatorio_financeiro == 'f' && $perfil_id == 18) || $perfil_id == 10 || $perfil_id == 16 || $perfil_id == 17) {
        ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriosaida">Relatorio Saida</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriosaidagrupo">Relatorio Saida Tipo</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriosaidaclasse">Relatorio Saida Classe</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioentrada">Relatorio Entrada</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioentradagrupo">Relatorio Entrada Conta</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/contaspagar/relatoriocontaspagar">Relatorio Contas a pagar</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/contasreceber/relatoriocontasreceber">Relatorio Contas a Receber</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriomovitamentacao">Relatorio Movimentação</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriovalormedio">Relatorio Valor Medio</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorionotafiscal">Relatorio Nota</a></span></ul>

                                        <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioacompanhamentodecontas">Relatorio Acompanhamento de contas</a></span></ul>
                                        <?
                                    }
                                    if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 18 || $perfil_id == 10 || $perfil_id == 16 || $perfil_id == 17 || ($gerente_recepcao_top_saude == 't' && $perfil_id == 5)) {
                                        ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioresumogeral">Relatorio Resumo</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocredito">Relatorio Crédito Paciente</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocreditosaldo">Relatorio Crédito Saldo</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocreditoestorno">Relatorio Crédito Estorno</a></span></ul>
        <? if ($caixa_personalizado == 'f') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixa">Relatorio Caixa</a></span></ul>
            <? if (($gerente_relatorio_financeiro == 'f' && $perfil_id == 18) || $perfil_id != 18) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixapersonalizado">Relatorio Caixa Personalizado</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixafaturado">Relatorio Caixa Faturamento</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixacartao">Relatorio Caixa Cartao</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixacartaoconsolidado">Relatorio Consolidado Cartao</a></span></ul>
                                                <? if ($centrocirurgico == 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/relatoriocaixacirurgico">Relatorio Caixa Cirurgico</a></span></ul>
                                                <? } ?>
                                            <? } ?>

                                        <? } else {
                                            ?>
                                            <!-- O rel. de caixa faturamento não foi adicionado no padrão do personalizado pq ele possui as mesmas informações do rel. caixa personalizado-->
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixapersonalizado">Relatorio Caixa</a></span></ul>
                                        <? } ?>

                                        <? if ($this->session->userdata('recomendacao_configuravel') != "t" && ($gerente_relatorio_financeiro == 'f' && $perfil_id == 18)) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioindicacao">Relatorio Indicacao Cadastro</a></span></ul>
                                        <? } ?>

                                        <?
                                    }
                                    ?>
    <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 18 || $perfil_id == 10 || $perfil_id == 16 || $perfil_id == 6 || $perfil_id == 17 || ($gerente_recepcao_top_saude == 't' && $perfil_id == 5)) {
        ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconveniofinanceiro">Relatorio Produção Médica</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioindicacaoexames">Relatorio Produção Promotor</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriolaboratorioconveniofinanceiro">Relatorio Produção Terceirizado</a></span></ul>
                                        <?
                                    }
                                    ?>
                                    <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 18 || $perfil_id == 10 || $perfil_id == 16 || $perfil_id == 17 || ($gerente_recepcao_top_saude == 't' && $perfil_id == 5)) {
                                        ?>
                                        <? if ($caixa_personalizado == 'f') { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoconvenioprevisaofinanceiro">Relatorio Previs&atilde;o M&eacute;dica</a></span></ul>
                                            <? if (($gerente_relatorio_financeiro == 'f' && $perfil_id == 18) || ($perfil_id != 18 && $perfil_id != 5)) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoatendimentomensal">Relatorio Atendimento Mensal</a></span></ul>
                                            <? } ?>
                                            <?
                                        }
                                    }
                                    ?>
                                </li> 

                            </ul>
                        </li>
<? } ?>
<? if ($marketing == 't' && ($perfil_id == 1 || $perfil_id == 14)) { ?>


                        <li><span class="folder">Marketing</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
    <? if ($perfil_id == 1 || $perfil_id == 14) { ?>
                                        <ul><span class="file"><a onclick="javascript: return confirm('Esta operação irá exportar todos os emails de pacientes para uma planilha\n\nObs: Esse processo pode ser demorado  ');" href="<?php echo base_url() ?>ambulatorio/guia/exportaremails">
                                                    Exportar Emails
                                                </a></span></ul>
                                        <ul><span class="file"><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/tempomedioatendimento/" ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=500');"  href="#">
                                                    Manter Tempo Médio
                                                </a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriomedicoagendafaltouemail">Enviar Emails</a></span></ul>

                                    <? }
                                    ?>
                                </li> 
                                <li><span class="folder">Relatorios</span>
    <?
    if ($perfil_id == 1 || $perfil_id == 14) {
        ?>

                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioperfilpaciente">Relatorio Perfil Paciente</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriopacientewhatsapp">Relatorio WhatsApp Pacientes</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriounicoretorno">Relatório Paciente Unico/Retorno</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriotempoatendimento">Relatório Tempo de atendimento</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioindicacaounico">Relatorio Indicacao </a></span></ul>

        <?
    }
    ?>

                                </li> 

                            </ul>
                        </li>
<? } ?>
<? if ($internacao == 't') { ?>
                        <li><span class="folder">Internacao</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/manterfichaquestionario">Listar Pré-Cadastro</a></span></ul>

                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarsolicitacaointernacao">Listar Solicitações</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarinternacaolista">Listar Internações</a></span></ul>
                                    <!--<ul><span class="file"><a href="<?= base_url() ?>internacao/internacao">Listar Internacoes</a></span></ul>-->
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarsaida">Listar Saidas</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pacientesinternados/Todas">Pacientes Internados</a></span></ul>
                                </li>
                                <li><span class="folder">Relatórios</span>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/relatorioprecadastro">Relatório Pré-Cadastro</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/relatoriocensodiario">Relatório Censo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/relatoriounidadeleito">Relatório Leito</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/relatoriointernacao">Relatório Pacientes Internados</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/relatoriosituacao">Relatório Pacientes Situação</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/relatoriosaidainternacao">Relatório Pacientes Saída</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/relatoriointernacaofaturamento">Relatório Internação Faturamento</a></span></ul>
                                </li>
                            </ul>
                        </li>


                        <?
                    }
                    if ($centrocirurgico == 't' && ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 7 && $perfil_id != 15)) {
                        ?>
                        <li><span class="folder">Centro Cirurgico</span>
                            <ul>

    <? if ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 7 && $perfil_id != 15) { ?>
                                    <li><span class="folder">Rotinas</span>
                                        <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico">Listar Solicitações</a></span></ul>
                                        <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarcirurgia">Fila de Cirurgia</a></span></ul>
                                        <ul><span class="file"><a target="_blank" href="<?= base_url() ?>centrocirurgico/centrocirurgico/mapacirurgico">Mapa Cirurgico</a></span></ul>
                                                        <!--<li><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarequipecirurgica">Equipe Cirurgica</a></span></li>-->
                                    </li>
    <? } ?>

                                <li><span class="folder">Relatorios</span>
                                    <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/relatoriocirurgiaconvenio">Relatorio Cirurgia-Convenio</a></span></ul>
                                </li>
                            </ul>
                        </li>
                        <?
                    }
                    if ($relatoriorm == 't' && ($perfil_id == 1 || $perfil_id == 6 || $perfil_id == 3)) {
                        ?>
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
<? } ?>
<? if ($ponto == 't') { ?>
                        <li><span class="folder">Ponto</span>
                            <ul>
                                <li><span class="folder">Rotinas</span>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/funcionario">Funcionario</a></span></ul>

                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/setor">Setor</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/funcao">Fun&ccedil;&atilde;o</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/cargo">Cargo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/horariostipo">Horarios Tipo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/horariostipo/virada">Virada</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/competencia">Competencia</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/ocorrenciatipo">Ocorrencia tipo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/processaponto">processar</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/importarponto">importar ponto</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/importarponto/importarpontobatida">importar batida</a></span></ul>

                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/processaponto">processar</a></span></ul>
                                </li>
                                <li><span class="folder">Relatorios</span>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/funcionario/relatorio">Funcionario lista</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/relatorio/impressaocartaofixo">ponto Fixo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/relatorio/impressaocartaovariavel">ponto Variavel</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ponto/relatorio/impressaocartaosemiflexivel">ponto Semiflexivel</a></span></ul>
                                </li>
                            </ul>
                        </li>
<? } ?>
<? if ($limitar_acesso != 't') { ?>
                                    <? if ($perfil_id != 4 && $perfil_id != 16 && $perfil_id != 17) { ?>
                            <li><span class="folder">Configura&ccedil;&atilde;o</span>
                                <ul>
                                    <li><span class="folder">Recep&ccedil;&atilde;o</span>
        <? if ($perfil_id == 1 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 10) { ?>

                                            <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador">Listar Profissionais</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupomedico">Grupo Médico</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/motivocancelamento">Motivo cancelamento</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/tipoconsulta">Tipo Agenda</a></span></ul>
                                            <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/horario">Manter Horarios</a></span></ul>-->
                                            
                                            <?if($agenda_modelo2 == 'f'){?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda">Agenda Horarios</a></span></ul>
                                            <?}else{?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2">Agenda Médica</a></span></ul>
                                            <?}?>
                                            <? if ($this->session->userdata('recomendacao_configuravel') == "t") { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/indicacao">Manter Promotor</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/indicacao/pesquisargrupoindicacao">Manter Grupo Promotor</a></span></ul>
                                            <? } ?>

                                                                                                                            <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame">Agenda Manter</a></span></ul>-->
                                        <? } ?>
                                        <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 13 && $perfil_id != 11 && $perfil_id != 12 && $perfil_id != 4 && $perfil_id != 7 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/sala">Manter Salas</a></span></ul>
                                        <? } ?>
        <? if ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 13 && $perfil_id != 4 && $perfil_id != 7 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelodeclaracao">Modelo Declara&ccedil;&atilde;o</a></span></ul>
                                        <? } ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador/relatorioemailoperador">Relatorio Operador</a></span></ul>
                                    </li>
                                    <li><span class="folder">Procedimento</span>                    
        <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10) { ?>



                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento">Manter Procedimentos</a></span></ul>
            <? if ($perfil_id != 10) { ?> 
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/relatorioprocedimento">Relatorio Procedimentos</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/pesquisartuss">Manter Procedimentos TUSS</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/classificacao">Manter Classificação</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/gerarelatorioprocedimentotuss">Relatorio Procedimentos TUSS</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoconvenio">Manter grupo convenio</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/convenio">Manter convenio</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/laboratorio">Manter Terceirizado</a></span></ul>
                                                <?
                                            }
                                            if ($procedimento_multiempresa != 't') {
                                                ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano">Manter Procedimentos Convenio</a></span></ul>
                                            <? } else { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar2">Manter Procedimentos Convenio</a></span></ul>
                                                <?
                                            }
                                            if ($perfil_id != 10) {
                                                ?> 
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/relatorioprocedimentoconvenio">Relatorio Procedimentos Convenio</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/medicopercentual">Manter Percentual M&eacute;dico</a></span></ul>
                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentopercentual">Manter Percentual M&eacute;dico</a></span></ul>-->
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/promotorpercentual">Manter Percentual Promotor</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/laboratoriopercentual">Manter Percentual Terceirizado</a></span></ul>
                <? if ($subgrupo_procedimento != 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoclassificacao">Manter Grupo Classificação</a></span></ul>
                                                <? } else { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoclassificacao/pesquisarsubgrupo">Manter Subgrupo</a></span></ul>
                                                    <!-- <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoclassificacao/pesquisarassociacaosubgrupo">Manter Associação Subgrupo</a></span></ul> -->
                                                    <?
                                                }
                                            }
                                        }
                                        ?>
                                    </li>
        <? if ($medicinadotrabalho == 't') { ?>
                                        <li><span class="folder">M. Trabalho</span>
            <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10) { ?>



                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarsetor">Manter Setor</a></span></ul>                                        
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarfuncao">Manter Função</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarrisco">Manter Riscos OE.</a></span></ul>



                                        <? } ?>

                                        <? } ?>
                                    </li>
        <? if ($imagem == 't') { ?>
                                        <li><span class="folder">Imagem</span> 
                                            <? if ($perfil_id == 1 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelolaudo">Manter Modelo Laudo</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelolinha">Manter Modelo Linha</a></span></ul>
                                        <? } ?>
                                        </li>
                                        <? } ?>
        <? if ($centrocirurgico == 't' && ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 7 && $perfil_id != 15)) { ?>
                                        <li><span class="folder">Centro Cirurgico</span> 
            <? if ($perfil_id == 1 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarhospitais">Manter Hospital</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarfornecedormaterial">Manter Fornecedor</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisargrauparticipacao">Grau de Participação</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/configurarpercentuais">Configurar Percentuais</a></span></ul>
                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/agrupador">Manter Agrupador</a></span></ul>-->
                                        <? } ?>
                                        </li>
        <? } ?>
        <? if ($internacao == 't') { ?>
                                        <li><span class="folder">Internação</span>
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarunidade">Listar Unidades</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarenfermaria">Lista Enfermarias</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarleito">Listar Leitos</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarmotivosaida">Manter Motivo Saida</a></span></ul> 
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/mantermodelogrupo">Manter Modelo Grupo</a></span></ul> 
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/mantertipodependencia">Manter Tipo Depedência</a></span></ul> 
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarinternacaoconfig">Manter Impressões</a></span></ul>
                                        </li>
                                        <? } ?>
        <? if ($consulta == 't') { ?>
                                        <li><span class="folder">Consulta</span> 
            <? if ($perfil_id == 1 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloreceita">Manter Modelo Receita</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloatestado">Manter Modelo Atestado</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloreceitaespecial">Manter Modelo R. Especial</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelosolicitarexames">Manter Modelo S.Exames</a></span></ul>
                                                <? if ($integracaosollis != 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelomedicamento">Manter Medicamento</a></span></ul>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelomedicamento/pesquisarunidade">Manter Medicamento Unidade</a></span></ul>
                                            <? } ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelooftamologia">Manter Campos Oftamologia</a></span></ul>
                                        <? } ?>
                                        </li>
                                        <? } ?>
        <? if ($estoque == 't') { ?>
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
        <? } ?>
        <? if ($farmacia == 't') { ?>

                                        <li><span class="folder">Farmácia</span>
                                            <ul><span class="file"><a href="<?= base_url() ?>farmacia/tipo">Manter Tipo</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>farmacia/classe">Manter Classe</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>farmacia/subclasse">Manter Sub-Classe</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>farmacia/unidade">Manter Medida</a></span></ul>
                                        </li>
                                        <? } ?>
        <? if ($financeiro == 't') { ?>
                                        <li><span class="folder">Financeiro</span>
            <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tipo">Manter Tipo</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/classe">Manter Classe</a></span></ul>
                    <!--                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/subclasse">Manter Sub-Classe</a></span></ul>-->
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/forma">Manter Conta</a></span></ul>
                                                <? if ($perfil_id != 10) { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento">Manter Forma de Pagamento</a></span></ul>
                                                    <!--<ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento/grupospagamento">Forma de Pagamento Grupo</a></span></ul>-->

                                            <? } ?>
                                        <? } ?>
                                        </li> 
                                        <? } ?>
        <? if ($perfil_id == 1) { ?>
                                        <li><span class="folder">Impressão</span>
            <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Cabeçalho</a></span></ul>
                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Recibo</a></span></ul>-->
                    <!--                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/subclasse">Manter Sub-Classe</a></span></ul>-->
                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Ficha</a></span></ul>-->
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarlaudoconfig">Config.Laudo</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarorcamentoconfig">Config.Orçamento</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarreciboconfig">Config.Recibo</a></span></ul>

                                                    <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarencaminhamentoconfig">Msg Encaminhamento</a></span></ul>-->
                                                       <!--<ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento/grupospagamento">Config.Cabeçalho</a></span></ul>-->


                                            <? } ?>
                                        </li> 
                                        <? } ?>
                                    <li><span class="folder">Administrativas</span>
                                        <? if ($perfil_id == 1) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/pesquisarferiados">Manter Feriados</a></span></ul>
            <? if ($perfil_id == 1) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/pesquisarlembrete">Manter Lembretes</a></span></ul>
                                            <? } ?>
            <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/pesquisartotensetor">Manter Setor Toten</a></span></ul>-->
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa">Manter Empresa</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/versao">Vers&atilde;o</a></span></ul>
                            <? } ?>
                                    </li> 
                                </ul>
                            </li>
    <? } ?>
<? } else { ?>
                                    <? if ($perfil_id != 4 && $perfil_id != 16 && $perfil_id != 17 && $perfil_id != 11) { ?>
                            <li><span class="folder">Configura&ccedil;&atilde;o</span>
                                <ul>
                                    <li><span class="folder">Recep&ccedil;&atilde;o</span>
        <? if ($perfil_id == 1 || $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 10) { ?>

                                            <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador">Listar Profissionais</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupomedico">Grupo Médico</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/motivocancelamento">Motivo cancelamento</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/tipoconsulta">Tipo Agenda</a></span></ul>
                                            <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/horario">Manter Horarios</a></span></ul>-->
                                            <?if($agenda_modelo2 == 'f'){?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda">Agenda Horarios</a></span></ul>
                                            <?}else{?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2">Agenda Médica</a></span></ul>
                                            <?}?>
                                            <? if ($this->session->userdata('recomendacao_configuravel') == "t") { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/indicacao">Manter Promotor</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/indicacao/pesquisargrupoindicacao">Manter Grupo Promotor</a></span></ul>
                                            <? } ?>

                                                                                                                            <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/exame">Agenda Manter</a></span></ul>-->
                                        <? } ?>
                                        <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 13 && $perfil_id != 11 && $perfil_id != 12 && $perfil_id != 4 && $perfil_id != 7 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/sala">Manter Salas</a></span></ul>
                                        <? } ?>
        <? if ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 13 && $perfil_id != 4 && $perfil_id != 7 && $perfil_id != 15) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelodeclaracao">Modelo Declara&ccedil;&atilde;o</a></span></ul>
                                        <? } ?>
                                        <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador/relatorioemailoperador">Relatorio Operador</a></span></ul>
                                    </li>
                                    <li><span class="folder">Procedimento</span>                    
        <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10) { ?>



                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento">Manter Procedimentos</a></span></ul>
            <? if ($perfil_id != 10) { ?> 
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/relatorioprocedimento">Relatorio Procedimentos</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/pesquisartuss">Manter Procedimentos TUSS</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/classificacao">Manter Classificação</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/gerarelatorioprocedimentotuss">Relatorio Procedimentos TUSS</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoconvenio">Manter grupo convenio</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/convenio">Manter convenio</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/laboratorio">Manter Terceirizado</a></span></ul>
                                                <?
                                            }
                                            if ($procedimento_multiempresa != 't') {
                                                ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano">Manter Procedimentos Convenio</a></span></ul>
                                            <? } else { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar2">Manter Procedimentos Convenio</a></span></ul>
                                                <?
                                            }
                                            if ($perfil_id != 10) {
                                                ?> 
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimento/relatorioprocedimentoconvenio">Relatorio Procedimentos Convenio</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/medicopercentual">Manter Percentual M&eacute;dico</a></span></ul>
                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/procedimentopercentual">Manter Percentual M&eacute;dico</a></span></ul>-->
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/promotorpercentual">Manter Percentual Promotor</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/laboratoriopercentual">Manter Percentual Terceirizado</a></span></ul>
                <? if ($subgrupo_procedimento != 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoclassificacao">Manter Grupo Classificação</a></span></ul>
                                                <? } else { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoclassificacao/pesquisarsubgrupo">Manter Subgrupo</a></span></ul>
                                                    <!-- <ul><span class="file"><a href="<?= base_url() ?>cadastros/grupoclassificacao/pesquisarassociacaosubgrupo">Manter Associação Subgrupo</a></span></ul> -->
                                                    <?
                                                }
                                            }
                                        }
                                        ?>
                                    </li>
        <? if ($medicinadotrabalho == 't') { ?>
                                        <li><span class="folder">M. Trabalho</span>
            <? if ($perfil_id == 1 || $perfil_id == 3 || $perfil_id == 10) { ?>



                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarsetor">Manter Setor</a></span></ul>                                        
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarfuncao">Manter Função</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/saudeocupacional/pesquisarrisco">Manter Riscos OE.</a></span></ul>



                                        <? } ?>

                                        <? } ?>
                                    </li>
        <? if ($imagem == 't') { ?>
                                        <li><span class="folder">Imagem</span> 
                                            <? if ($perfil_id == 1 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelolaudo">Manter Modelo Laudo</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelolinha">Manter Modelo Linha</a></span></ul>
                                        <? } ?>
                                        </li>
                                        <? } ?>
        <? if ($centrocirurgico == 't' && ($perfil_id != 11 && $perfil_id != 2 && $perfil_id != 7 && $perfil_id != 15)) { ?>
                                        <li><span class="folder">Centro Cirurgico</span> 
            <? if ($perfil_id == 1 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarhospitais">Manter Hospital</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisarfornecedormaterial">Manter Fornecedor</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/pesquisargrauparticipacao">Grau de Participação</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/configurarpercentuais">Configurar Percentuais</a></span></ul>
                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/procedimentoplano/agrupador">Manter Agrupador</a></span></ul>-->
                                        <? } ?>
                                        </li>
        <? } ?>
        <? if ($internacao == 't') { ?>
                                        <li><span class="folder">Internação</span>
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarunidade">Listar Unidades</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarenfermaria">Lista Enfermarias</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarleito">Listar Leitos</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/pesquisarmotivosaida">Manter Motivo Saida</a></span></ul> 
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/mantermodelogrupo">Manter Modelo Grupo</a></span></ul> 
                                            <ul><span class="file"><a href="<?= base_url() ?>internacao/internacao/mantertipodependencia">Manter Tipo Depedência</a></span></ul> 
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarinternacaoconfig">Manter Impressões</a></span></ul>
                                        </li>
                                        <? } ?>
        <? if ($consulta == 't') { ?>
                                        <li><span class="folder">Consulta</span> 
            <? if ($perfil_id == 1 || $perfil_id == 3 || /* $perfil_id == 4 || */ $perfil_id == 5 || $perfil_id == 18 || $perfil_id == 6 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloreceita">Manter Modelo Receita</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloatestado">Manter Modelo Atestado</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modeloreceitaespecial">Manter Modelo R. Especial</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelosolicitarexames">Manter Modelo S.Exames</a></span></ul>
                                                <? if ($integracaosollis != 't') { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelomedicamento">Manter Medicamento</a></span></ul>
                                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelomedicamento/pesquisarunidade">Manter Medicamento Unidade</a></span></ul>
                                            <? } ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/modelooftamologia">Manter Campos Oftamologia</a></span></ul>
                                        <? } ?>
                                        </li>
                                        <? } ?>
        <? if ($estoque == 't') { ?>
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
        <? } ?>
        <? if ($farmacia == 't') { ?>

                                        <li><span class="folder">Farmácia</span>
                                            <ul><span class="file"><a href="<?= base_url() ?>farmacia/tipo">Manter Tipo</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>farmacia/classe">Manter Classe</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>farmacia/subclasse">Manter Sub-Classe</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>farmacia/unidade">Manter Medida</a></span></ul>
                                        </li>
                                        <? } ?>
        <? if ($financeiro == 't') { ?>
                                        <li><span class="folder">Financeiro</span>
            <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tipo">Manter Tipo</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/classe">Manter Classe</a></span></ul>
                    <!--                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/subclasse">Manter Sub-Classe</a></span></ul>-->
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/forma">Manter Conta</a></span></ul>
                                                <? if ($perfil_id != 10) { ?>
                                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento">Manter Forma de Pagamento</a></span></ul>
                                                    <!--<ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento/grupospagamento">Forma de Pagamento Grupo</a></span></ul>-->

                                            <? } ?>
                                        <? } ?>
                                        </li> 
                                        <? } ?>
        <? if ($perfil_id == 1) { ?>
                                        <li><span class="folder">Impressão</span>
            <? if ($perfil_id == 1 || $perfil_id == 13 || $perfil_id == 10) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Cabeçalho</a></span></ul>
                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Recibo</a></span></ul>-->
                    <!--                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/subclasse">Manter Sub-Classe</a></span></ul>-->
                                                <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarcabecalho">Config.Ficha</a></span></ul>-->
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarlaudoconfig">Config.Laudo</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarorcamentoconfig">Config.Orçamento</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarreciboconfig">Config.Recibo</a></span></ul>

                                                    <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/listarencaminhamentoconfig">Msg Encaminhamento</a></span></ul>-->
                                                       <!--<ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento/grupospagamento">Config.Cabeçalho</a></span></ul>-->


                                            <? } ?>
                                        </li> 
                                        <? } ?>
                                    <li><span class="folder">Administrativas</span>
                                        <? if ($perfil_id == 1) { ?>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/agenda/pesquisarferiados">Manter Feriados</a></span></ul>
            <? if ($perfil_id == 1) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/pesquisarlembrete">Manter Lembretes</a></span></ul>
                                            <? } ?>
            <!--<ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa/pesquisartotensetor">Manter Setor Toten</a></span></ul>-->
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa">Manter Empresa</a></span></ul>
                                            <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/versao">Vers&atilde;o</a></span></ul>
                            <? } ?>
                                    </li> 
                                </ul>
                            </li>
    <? } ?>
<? } ?>
                    <li>
                        <span class="file">
                            <a onclick="javascript: return confirm('Deseja realmente sair da aplicação?');"
                               href="<?= base_url() ?>login/sair">Sair</a>
                        </span>
                        <!--<div style="position: absolute; min-height: 30%; border: 1pt solid black"></div>-->
                    </li>
                </ul>                       
                <!-- Fim da Barra Lateral -->
            </div>
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

<? if ($chat == 't') { ?>
                jQuery(function () {

                    jQuery("#contatos_chat_lista").click(function () {

                        var classe = jQuery("#contatos_chat_lista").attr("class");
                        //                    console.log('ola');
                        //verificando se o usuario ja clicou no icone de batepapo
                        if (classe == 'nao_clicado') {
                            //mostrando a lista de contatos
                            carregacontatos();
                            jQuery("#contatos_chat_lista").attr("class", 'clicado');

                            jQuery("#principalChat #usuarios_online").mouseleave(function () {
                                jQuery("#principalChat #usuarios_online ul li").remove();
                                jQuery("#contatos_chat_lista").attr("class", 'nao_clicado');
                            });
                        }
                    });

                });

                jQuery(".total_mensagens").css("opacity", "0.4");//define opacidade inicial
                //faz o numero de mensagens nao lidas piscar
                setInterval(function () {
                    if ($(".total_mensagens").css("opacity") == 0) {
                        $(".total_mensagens").css("opacity", "1");
                    } else {
                        $(".total_mensagens").css("opacity", "0");
                    }
                }, 600);


                //abrindo a janelas de batepapo
                jQuery(function () {
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
                            //                            retorna_historico(idJanela);
                        } else {
                            jQuery(this).removeClass("comecarChat");
                        }
                    });
                });

                //minimizando as janelas
                jQuery(function () {
                    jQuery("#principalChat .cabecalho_janela_chat").live('click', function () {
                        var corpo_janela_chat = jQuery(this).next();
                        corpo_janela_chat.toggle(100);
                        verifica(0, 0, <? echo $operador_id ?>);
                    });
                });


                //fechando a janela
                jQuery(function () {
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
                jQuery(function () {
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
                                //verifica se ha mensagens novas
                                if (retorno.status == 'resultados') {
                                    jQuery.each(retorno.dados, function (i, msg) {

                                        //testando se ela ja esta aberta
                                        if (jQuery("#janela_" + msg.janela).length > 0) {

                                            //caso a janela ja esteja aberta adciona as novas mensagens em uma tag <li> e incrementa elas a <ul> da janela correspondente
                                            if (jQuery("#janela_" + msg.janela + " .mensagens_chat ul li#" + msg.chat_id).length == 0 && msg.janela > 0) {

                                                if (operadorOrigem == msg.id_origem) {
                                                    jQuery("#janela_" + msg.janela + " .mensagens_chat ul").append("<li class='eu' id='" + msg.chat_id + "'><p>" + msg.mensagem + "</p> <div class='data_envio'>" + msg.data_envio + "</div></li>");
                                                } else {
                                                    jQuery("#janela_" + msg.janela + " .mensagens_chat ul").append("<li id='" + msg.chat_id + "'><div class='imgPerfil'></div><p>" + msg.mensagem + "</p> <div class='data_envio'>" + msg.data_envio + "</div></li>");
                                                }
                                            }

                                            //CASO O CONTATO ESTEJA ABERTO ELE MARCA A MENSAGEM COMO LIDA
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

                                    //                                    buscamensagens();
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
                        atualizastatus();
                    }, 10000);
                }

                function atualizastatus() {
                    jQuery.ajax({
                        type: "GET",
                        url: "<?= base_url(); ?>" + "batepapo/atualizastatus",
                        dataType: "json"
                    });
                }

                //atualiza status do operador
                //                setInterval(function () {
                //                    atualizastatus();
                //                    verifica(0, 0,<? // echo $operador_id                                         ?>);
                //                }, 10000);

                buscamensagens();
                //            mensagensnaolidas();
<? } ?>
        </script>
