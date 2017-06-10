<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Exame extends BaseController {

    function Exame() {
        parent::Controller();
        $this->load->model('ambulatorio/exame_model', 'exame');
//        $this->load->model('ambulatorio/agenda_model', 'agenda');
        $this->load->model('ambulatorio/sala_model', 'sala');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('login_model', 'login');
        $this->load->model('ambulatorio/tipoconsulta_model', 'tipoconsulta');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/motivocancelamento_model', 'motivocancelamento');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('centrocirurgico/centrocirurgico_model', 'centrocirurgico_m');
        $this->load->model('ambulatorio/agenda_model', 'agenda');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($limite = 10) {
        $data["limite_paginacao"] = $limite;
        $this->loadView('ambulatorio/exame-lista', $data);
    }

    function gravaraudio($args = array()) {

        $this->loadView('ambulatorio/gravaraudio-form', $args);
    }

    function listarsalaspreparo($args = array()) {

        $this->loadView('ambulatorio/examepreparo-lista', $args);
    }

    function listarsalasespera($args = array()) {

        $this->loadView('ambulatorio/exameespera-lista', $args);
    }

    function listaresperacaixa($args = array()) {

        $this->loadView('ambulatorio/exameesperacaixa-lista', $args);
    }

    function listarmultifuncao($args = array()) {

        $this->loadView('ambulatorio/examemultifuncao-lista', $args);
    }

    function listaragendamentomultiempresa($args = array()) {
        $parametro = array(
            'especialidade' => (@$_GET['especialidade'] != '') ? @$_GET['especialidade'] : '',
            'medico' => (@$_GET['medico'] != '') ? @$_GET['medico'] : '',
            'data' => (@$_GET['data'] != '') ? @$_GET['data'] : '',
            'nome' => (@$_GET['nome'] != '') ? @$_GET['nome'] : ''
        );
        
//        var_dump($_GET);die;
        
        $dados = http_build_query($parametro);

        $contexto = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'content' => $dados,
                'header' => "Content-type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: " . strlen($dados) . "\r\n",
            )
        ));
        $url = "especialidade={$parametro['especialidade']}&medico={$parametro['medico']}&data={$parametro['data']}&nome={$parametro['nome']}";
        
        $resposta = file_get_contents("http://localhost/arquivoDados.php?{$url}", null, $contexto);
        
//        $medicos = file_get_contents("http://localhost/arquivoMedicos.php", null, $contexto);
        
        $array = explode("|", $resposta);
        
        foreach($array as $item){
            if(strlen($item) >= 2) {
                $a = explode("$", $item);
                @$args["agenda"][$a[0]] = json_decode($a[1]);
            }
        }
        $data["dados"] = $args;
//        echo "<pre>";
//        var_dump($resposta);die;
        $this->loadView('ambulatorio/agendamentomultiempresa-lista', $data);
    }

    function listarmultifuncaogeral($args = array()) {

        $this->loadView('ambulatorio/examemultifuncaogeral-lista', $args);
    }

    function listarmultifuncaocalendario($args = array()) {

        $this->load->View('ambulatorio/calendario', $args);
    }

    function listarmultifuncaoconsulta($args = array()) {

        $this->loadView('ambulatorio/examemultifuncaoconsulta-lista', $args);
    }

    function relatoriomedicoagendaexame() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/relatoriomedicoagendaexame', $data);
    }

    function relatoriomedicoagendafaltou() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/relatoriomedicoagendaexamefaltou', $data);
    }

    function carregarreagendamento() {
        if (count($_POST) > 0) {

            @$agenda = $this->exame->listarhorariosreagendamento();
            if (count(@$agenda) > 0) {
                $verificao = $this->exame->gravareagendamento($agenda);
                if (count($verificao) == 0) {
                    $data['mensagem'] = 'Sucesso ao reagendar todos Pacientes do dia selecionado.';
                } else {
                    $data['mensagem'] = 'Não foi possivel reagendar alguns pacientes devido a conflitos de horario.';
                }
            } else {
                $data['mensagem'] = 'Não há pacientes agendados para o dia escolhido.';
            }
        }

//        echo "<pre>";
//        var_dump($agenda);die;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/reagendamentogeral");
    }

    function carregarreagendamentoespecialidade() {
//        var_dump($_POST); die;
        if (count($_POST['reagendar']) > 0) {

            @$agenda = $this->exame->listarhorariosreagendamentoespecialidade();

            $pacientes = '';
            if (count(@$agenda) > 0) {
                $verificao = $this->exame->gravareagendamentoespecialidade($agenda);
                if (count($verificao) == 0) {
                    $data['mensagem'] = 'Sucesso ao reagendar todos Pacientes do dia selecionado.';
                } else {

                    foreach ($verificao as $item) {
                        $pacientes = $pacientes . ", " . $item;
//                    var_dump($item); 
                    }
//                die;
                    $data['mensagem'] = "Não foi possivel reagendar os seguintes pacientes devido a conflitos de horario. $pacientes";
                }
            } else {
                $data['mensagem'] = 'Não há pacientes agendados para o dia escolhido.';
            }
        } else {
            $data['mensagem'] = 'Não foram escolhidos ou não há pacientes para reagendar.';
        }

//        echo "<pre>";
//        var_dump($agenda);die;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarmultifuncaomedicofisioterapia");
    }

    function reagendamentogeral() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/relatorioreagendamentogeral', $data);
    }

    function relatorioteleoperadora() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarteleoperadora();
        $data['empresa'] = $this->guia->listarempresas();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/relatorioteleoperadora', $data);
    }

    function relatoriorecepcaoagenda() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/relatoriorecepcaoagenda', $data);
    }

    function relatoriomedicoagendaconsultas() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriomedicoagendaconsulta', $data);
    }

    function relatoriomedicoordem() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimentos'] = $this->guia->listarprocedimentos();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['salas'] = $this->sala->listarsalas();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriomedicoordem', $data);
    }

    function gerarelatoriorecepcaoagenda() {
        if ($_POST['tipoRelatorio'] == '0') {
            $this->gerarelatoriomedicoagendaconsultas();
        } else if ($_POST['tipoRelatorio'] == '1') {
            $this->gerarelatoriomedicoagendaexame();
        } else if ($_POST['tipoRelatorio'] == '2') {
            $this->gerarelatoriomedicoagendaexamefaltou();
        } else if ($_POST['tipoRelatorio'] == '3') {
            $this->gerarelatoriomedicoagendaespecialidade();
        }
    }

    function gerarelatorioteleoperadora() {
        $medicos = $_POST['medicos'];
        if ($_POST['medicos'] != '') {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = null;
        }

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->exame->listaragendamentoteleoperadora();
        $this->load->View('ambulatorio/impressaorelatorioteleoperadora', $data);
    }

    function gerarelatoriomedicoagendaconsultas() {
        $medicos = $_POST['medicos'];
        if ($_POST['medicos'] != '') {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = null;
        }

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->exame->listaragendaconsulta();
        $this->load->View('ambulatorio/impressaorelatoriomedicoagendaconsulta', $data);
    }

    function gerarelatoriomedicoagendaespecialidade() {
        $medicos = $_POST['medicos'];
        if ($_POST['medicos'] != '') {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = null;
        }

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->exame->listaragendaespecialidade();
        $this->load->View('ambulatorio/impressaorelatoriomedicoagendaespecialidade', $data);
    }

    function gerarelatoriomedicoagendaduplicidade() {
        $medicos = $_POST['medicos'];
        if ($_POST['medicos'] != '') {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = null;
        }

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->exame->listaragendaconsulta();
        $this->load->View('ambulatorio/impressaorelatoriomedicoagendaconsulta', $data);
    }

    function excluiragenda($agenda_id) {
        if ($this->exame->excluiragenda($agenda_id)) {
            $mensagem = 'Sucesso ao excluir o Agenda';
        } else {
            $mensagem = 'Erro ao excluir o Agenda. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/exame");
    }

    function gerarelatoriomedicoordem() {
        $data['medico'] = $_POST['medicos'];
        if ($data['medico'] != '0') {
            $data['medico'] = $this->operador_m->listarCada($_POST['medicos']);
        }
        $data['procedimentos'] = $_POST['procedimentos'];
        if ($_POST['procedimentos'] != '0') {
            $data['procedimentos'] = $this->guia->selecionarprocedimentos($_POST['procedimentos']);
        }
        $data['salas'] = $_POST['salas'];
        if ($_POST['salas'] != '0') {
            $data['salas'] = $this->sala->listarsala($_POST['salas']);
        }
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->exame->listaragendaordem();
        $data['relatorioprioridade'] = $this->exame->listaragendaordemprioridade();
//        echo '<pre>';
//        var_dump($data['relatorioprioridade']);
//        echo '<pre>';
//        die;
        $this->load->View('ambulatorio/impressaorelatoriomedicoordem', $data);
    }

    function gerarelatoriomedicoagendaexame() {
        $medicos = $_POST['medicos'];
        $salas = $_POST['salas'];
        $data['medico'] = $this->operador_m->listarCada($medicos);
        $data['salas'] = $this->sala->listarsala($salas);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->exame->listaragendaexame();
        $this->load->View('ambulatorio/impressaorelatoriomedicoagendaexame', $data);
    }

    function gerarelatoriomedicoagendaexamefaltou() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//        echo '<pre>'; 
        $data['relatorio'] = $this->exame->gerarelatoriomedicoagendaexamefaltou();
//        var_dump($data['relatorio']); die;
        $this->load->View('ambulatorio/impressaorelatoriomedicoagendaexamefaltou', $data);
    }

    function listarmultifuncaofisioterapia($args = array()) {

        $this->loadView('ambulatorio/examemultifuncaofisioterapia-lista', $args);
    }

    function autorizarsessaofisioterapia($paciente_id) {
        $data['lista'] = $this->exame->autorizarsessaofisioterapia($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $this->loadView('ambulatorio/autorizarsessaofisioterapia', $data);
    }

    function autorizarsessaopsicologia($paciente_id) {
        $data['lista'] = $this->exame->autorizarsessaopsicologia($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $this->loadView('ambulatorio/autorizarsessaopsicologia', $data);
    }

    function cancelartodosfisioterapia($paciente_id) {
        $lista = $this->exame->autorizarsessaofisioterapia($paciente_id);
        foreach ($lista as $item) {
            $this->exame->cancelartodosfisioterapia($item->agenda_exames_id);
        }
        $data['mensagem'] = 'Sucesso ao cancelar o Exame.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
    }

    function cancelartodospsicologia($paciente_id) {
        $lista = $this->exame->autorizarsessaopsicologia($paciente_id);
        foreach ($lista as $item) {
            $this->exame->cancelartodospsicologia($item->agenda_exames_id);
        }
        $data['mensagem'] = 'Sucesso ao cancelar o Exame.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
    }

    function listarmultifuncaomedicopsicologia($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicopsicologia-lista', $args);
    }

    function listarmultifuncaomedicofisioterapia($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicofisioterapia-lista', $args);
    }

    function listarmultifuncaomedicofisioterapiareagendar($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicofisioterapiareagendar-lista', $args);
    }

    function listarmultifuncaomedicoconsulta($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicoconsulta-lista', $args);
    }

    function listarmultifuncaomedicogeral($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicogeral-lista', $args);
    }

    function multifuncaomedicointegracao() {
        set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão 

        $data['integracao'] = $this->laudo->listarlaudosintegracaotodos();
        if (count($data['integracao']) > 0) {
//            echo count($data['integracao']) . "<hr>";
            $this->laudo->atualizacaolaudosintegracaotodos();
        }
    }

    function reagendarespecialidade() {
        var_dump($_POST);
        die;
        set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão 

        $data['integracao'] = $this->laudo->listarlaudosintegracaotodos();
        if (count($data['integracao']) > 0) {
//            echo count($data['integracao']) . "<hr>";
            $this->laudo->atualizacaolaudosintegracaotodos();
        }
    }

    function listarmultifuncaomedico($args = array()) {
//        $data['integracao'] = $this->laudo->listarlaudosintegracaotodos();
//        if (count($data['integracao']) > 0) {
////            echo count($data['integracao']) . "<hr>";
//            $this->laudo->atualizacaolaudosintegracaotodos();
//        }
        /* A integraçao agora e feita por AJAX na view abaixo */
        $this->loadView('ambulatorio/multifuncaomedico-lista', $args);
    }

    function listarmultifuncaomedicolaboratorial($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicolaboratorial-lista', $args);
    }

    function faturamentoexame() {

        $this->loadView('ambulatorio/faturamentoexame');
    }

    function faturamentomanual($args = array()) {

        $this->loadView('ambulatorio/faturamentomanual', $args);
    }

    function gravarguiacirurgica() {
        $ambulatorio_guia = $this->guia->gravarguiacirurgica();

        if ($ambulatorio_guia == "-1") {
            $data['mensagem'] = 'Erro ao gravar Guia. Opera&ccedil;&atilde;o cancelada.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exame/faturamentomanual");
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Guia.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exame/guiacirurgicaitens/$ambulatorio_guia");
        }
    }

    function gravarguiaambulatorial() {
        var_dump($_POST);
        die;
        $ambulatorio_guia = $this->guia->gravarguiacirurgica();

        if ($ambulatorio_guia == "-1") {
            $data['mensagem'] = 'Erro ao gravar Guia. Opera&ccedil;&atilde;o cancelada.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exame/faturamentomanual");
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Guia.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exame/guiacirurgicaitens/$ambulatorio_guia");
        }
    }

    function guiacirurgicaitens($guia_id) {

        $data['guia'] = $this->guia->instanciarguia($guia_id);
        $data['procedimentos'] = $this->exame->listarprocedimentocirurgicoconvenio($data['guia'][0]->convenio_id);
        $data['procedimentos_cadastrados'] = $this->exame->listarprocedimentosadcionados($guia_id);
        $this->loadView('ambulatorio/guiacirurgicaitens', $data);
    }

    function carregarguiacirurgica($guia_id = null) {

        $data['guia'] = $this->guia->instanciarguia($guia_id);
        $data['hospitais'] = $this->exame->listarhospitais();
        $data['convenios'] = $this->guia->listarconvenios();
        $this->loadView('ambulatorio/novaguiacirurgica-form', $data);
    }

    function carregarguiaambulatorial($guia_id = null) {

        $data['guia'] = $this->guia->instanciarguia($guia_id);
        $data['hospitais'] = $this->exame->listarhospitais();
        $data['convenios'] = $this->guia->listarconvenios();
        $this->loadView('ambulatorio/novaguiaambulatorio-form', $data);
    }

    function fecharfinanceiro() {
        $financeiro = $this->exame->fecharfinanceiro();
        if ($financeiro == "-1") {
            $data['mensagem'] = 'Erro ao fechar financeiro. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao fechar financeiro.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/faturamentoexame", $data);
    }

    function autorizarsessao($agenda_exames_id, $paciente_id, $guia_id) {
        $home_care = $this->exame->procedimentohomecare($agenda_exames_id);
//        var_dump($home_care); die;
        $intervalo = $this->exame->verificadiasessaohomecare($agenda_exames_id);
        if ($intervalo == 0) {
            $this->exame->autorizarsessao($agenda_exames_id);
            $data['lista'] = $this->exame->autorizarsessaofisioterapia($paciente_id);
            redirect(base_url() . "ambulatorio/guia/impressaoficha/$paciente_id/$guia_id/$agenda_exames_id");
        } else {
            $data['mensagem'] = 'Essa sessao só poderá ser autorizada amanhã.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exame/autorizarsessaofisioterapia/$paciente_id/");
        }
    }

    function autorizarsessaocadapsicologia($agenda_exames_id, $paciente_id, $guia_id) {
        $this->exame->autorizarsessao($agenda_exames_id);
        $data['lista'] = $this->exame->autorizarsessaopsicologia($paciente_id);
        redirect(base_url() . "ambulatorio/guia/impressaoficha/$paciente_id/$guia_id/$agenda_exames_id");
    }

    function faturamentomanuallista() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        } else {
            $data['convenios'] = 0;
        }
        $data['listar'] = $this->exame->listarguiafaturamentomanual();
//        echo "<pre>";
//        var_dump($data['listar']);die;
        $this->loadView('ambulatorio/faturamentomanual-lista', $data);
    }

    function faturamentoexamelista() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        } else {
            $data['convenios'] = 0;
        }
        $data['listar'] = $this->exame->listarguiafaturamento();
        $this->loadView('ambulatorio/faturamentoexame-lista', $data);
    }

    function faturamentoexamexml($args = array()) {

        $this->loadView('ambulatorio/faturamentoexamexml-form', $args);
    }

    function listarexamerealizando($args = array()) {

        $this->loadView('ambulatorio/examerealizando-lista', $args);
    }

    function listarexamependente($args = array()) {
        $this->loadView('ambulatorio/examependente-lista', $args);
    }

    function painelrecepcao($args = array()) {

        $this->loadView('ambulatorio/painelrecepcao-lista', $args);
    }

    function faturaramentomanualguia($guia_id, $paciente_id) {
        $data['guia_id'] = $guia_id;
        $data['paciente_id'] = $paciente_id;
        $data['guia'] = $this->guia->instanciarguia($guia_id);
        $data['procedimentos'] = $this->centrocirurgico_m->listarprocedimentosguiacirurgica($guia_id);
        $data['equipe'] = $this->centrocirurgico_m->listarequipecirurgicaoperadores($data['guia'][0]->equipe_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->loadView('ambulatorio/guiafaturamentomanual-form', $data);
    }

    function faturarguia($guia_id, $paciente_id) {
        $data['guia_id'] = $guia_id;
        $data['paciente_id'] = $paciente_id;
        $data['convenios'] = $this->convenio->listarconvenionaodinheiro();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->login->listar();
        $data['exames'] = $this->exame->listarexamesguia($guia_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->loadView('ambulatorio/guiafaturamento-form', $data);
    }

    function faturarguiamanual($paciente_id = null) {
        if ($paciente_id == null) {
            $paciente_id = $_POST['txtpacienteid'];
        }
//        var_dump($_POST); die;

        $data['paciente_id'] = $paciente_id;
        $data['convenios'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->login->listar();
        $data['exames'] = $this->exame->listarexamesguiamanual($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->loadView('ambulatorio/guiafaturamentoambulatorial-form', $data);
    }

    function gravarprocedimentosfaturamentomanual($paciente_id) {
//        var_dump($_POST); die;

        $resultadoguia = $this->exame->listarguiafaturamentomanualambulatorial($paciente_id);
        if ($resultadoguia == null) {
            $ambulatorio_guia = $this->exame->gravarguiamanual($paciente_id);
        } else {
            $ambulatorio_guia = $resultadoguia[0]->ambulatorio_guia_id;
        }
//            var_dump($ambulatorio_guia); die;

        $this->exame->gravarexamesfaturamentomanual($ambulatorio_guia);
//        var_dump($ambulatorio_guia); die;
        redirect(base_url() . "ambulatorio/exame/faturarguiamanual/$paciente_id");
    }

    function estoqueguia($agenda_exames_id) {

        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->loadView('ambulatorio/estoqueguia-form', $data);
    }

    function preparosala($paciente_id, $procedimento_tuss_id, $guia_id, $agenda_exames_id) {
        $data['salas'] = $this->exame->listarsalas();
        $data['medico_id'] = $this->exame->listarmedicoagenda($agenda_exames_id);
        $data['agenda_exames_nome_id'] = $this->exame->listarsalaagenda($agenda_exames_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['guia_id'] = $guia_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->loadView('ambulatorio/examepreparo-form', $data);
    }

    function enviarsalaatendimento($agenda_exames_id) {
        $this->exame->gravarexamepreparo($agenda_exames_id);
        $data['mensagem'] = 'Enviado para a sala de atendimento com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarsalaspreparo");
    }

    function examesala($paciente_id, $procedimento_tuss_id, $guia_id, $agenda_exames_id) {
        $data['salas'] = $this->exame->listarsalas();
        $data['medico_id'] = $this->exame->listarmedicoagenda($agenda_exames_id);
        $data['agenda_exames_nome_id'] = $this->exame->listarsalaagenda($agenda_exames_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['guia_id'] = $guia_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->loadView('ambulatorio/exameespera-form', $data);
    }

    function examepacientedetalhes($paciente_id, $procedimento_tuss_id, $guia_id, $agenda_exames_id) {
        $data['guia'] = $this->exame->listarguia($agenda_exames_id);
        $data['exames'] = $this->exame->listarexamesguias($guia_id);
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['guia_id'] = $guia_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/examepacientedetalhe-form', $data);
    }

    function agendaauditoria($agenda_exames_id) {
        $data['guia'] = $this->exame->listaragendaauditoria($agenda_exames_id);
        $this->load->View('ambulatorio/agendaauditoria-form', $data);
    }

    function agendadoauditoria($agenda_exames_id) {
        $data['guia'] = $this->exame->listaragendadoauditoria($agenda_exames_id);
        $this->load->View('ambulatorio/agendadoauditoria-form', $data);
    }

    function agendamedicocurriculo($medico_agenda) {
        $data['guia'] = $this->exame->listaragendamedicocurriculo($medico_agenda);
//        var_dump($data['guia']); die;
        $this->load->View('ambulatorio/agendamedicocurriculo-form', $data);
    }

    function trocarmedico($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico_atual'] = $this->exame->buscarmedicotroca($agenda_exames_id);
        $data['medicos'] = $this->exame->listarmedico();
        $data['tipo'] = 1; // exame ou consulta ou fisio
        $this->load->View('ambulatorio/trocarmedico-form', $data);
    }

    function guiacirurgicafaturamento($guia) {

        $data['guia_id'] = $guia;
        $data['guia'] = $this->guia->instanciarguia($guia);
        $data['procedimentos'] = $this->centrocirurgico_m->listarprocedimentosguiacirurgica($guia);
        $data['equipe'] = $this->centrocirurgico_m->listarequipecirurgicaoperadores($data['guia'][0]->equipe_id);
        $this->loadView('centrocirurgico/guiacirurgicafaturamento-lista', $data);
    }

    function trocarmedicoconsulta($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico_atual'] = $this->exame->buscarmedicotrocaconsulta($agenda_exames_id);
        $data['medicos'] = $this->exame->listarmedico();
        $data['tipo'] = 2; // exame ou consulta ou fisio        
        $this->load->View('ambulatorio/trocarmedico-form', $data);
    }

    function gravartrocarmedico() {
        $this->exame->trocarmedico();
    }

    function gravarpacientedetalhes() {

        $paciente_id = $_POST['paciente_id'];
        $procedimento_tuss_id = $_POST['procedimento_tuss_id'];
        $guia_id = $_POST['guia_id'];
        $agenda_exames_id = $_POST['agenda_exames_id'];
        $this->exame->gravarpacientedetalhes();
        $data['mensagem'] = 'Guia atualizada com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/examesala/$paciente_id /$procedimento_tuss_id /$guia_id/$agenda_exames_id");
    }

    function examesalatodos($paciente_id, $procedimento_tuss_id, $guia_id, $agenda_exames_id) {

        $data['salas'] = $this->exame->listarsalas();
        $data['grupo'] = $this->exame->listargrupo($agenda_exames_id);
        $data['medico_id'] = $this->exame->listarmedicoagenda($agenda_exames_id);
        $data['agenda_exames_nome_id'] = $this->exame->listarsalaagenda($agenda_exames_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['guia_id'] = $guia_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->loadView('ambulatorio/exameesperatodos-form', $data);
    }

    function esperacancelamento($agenda_exames_id, $paciente_id, $procedimento_tuss_id) {
        $data['motivos'] = $this->motivocancelamento->listartodos();
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $this->loadView('ambulatorio/esperacancelamento-form', $data);
    }

    function guiacancelamento($agenda_exames_id, $paciente_id, $procedimento_tuss_id) {
        $data['motivos'] = $this->motivocancelamento->listartodos();
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $this->loadView('ambulatorio/guiacancelamento-form', $data);
    }

    function examecancelamento($exames_id, $sala_id, $agenda_exames_id, $paciente_id, $procedimento_tuss_id) {
        $data['motivos'] = $this->motivocancelamento->listartodos();
        $data['exames_id'] = $exames_id;
        $data['sala_id'] = $sala_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->loadView('ambulatorio/examecancelamento-form', $data);
    }

    function gravarexame() {
        $total = $this->exame->contadorexames();
        if ($total == 0) {
            $preparo = $this->guia->listarprocedimentopreparo();
            $procedimentopercentual = $_POST['txtprocedimento_tuss_id'];
            $medicopercentual = $_POST['txtmedico'];
            $percentual = $this->guia->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
            if (count($percentual) == 0) {
                $percentual = $this->guia->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
            }
            //            var_dump($_POST['txtagenda_exames_id']);
            //            var_dump($percentual); die;
            $laudo_id = $this->exame->gravarexame($percentual);
            if ($laudo_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar o Exame. Opera&ccedil;&atilde;o cancelada.';
            } else {

                if ($preparo[0]->sala_preparo == 't') {
                    $this->exame->gravarsalapreparo();
                    $data['mensagem'] = 'Sucesso ao enviar para a sala de preparo.';
                } else {
                    $data['mensagem'] = 'Sucesso ao gravar o Exame.';
                }
//                $this->gerarcr($agenda_exames_id); //clinica humana
                $this->gerardicom($laudo_id); //clinica ronaldo
//               $this->laudo->chamada($laudo_id);
            }
        } else {
            $data['mensagem'] = 'Erro ao gravar o Exame. Exame ja cadastrato.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarexametodos() {
        $total = $this->exame->contadorexamestodos();
        if ($total == 0) {
            $laudo_id = $this->exame->gravarexametodos();

            if (count($laudo_id) == 0) {
                $data['mensagem'] = 'Erro ao gravar o Exame. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar o Exame.';
//                $this->gerarcr($agenda_exames_id); //clinica humana
                foreach ($laudo_id as $value) {
                    $this->gerardicom($value); //clinica ronaldo
                }
            }
        } else {
            $data['mensagem'] = 'Erro ao gravar o Exame. Exame ja cadastrato.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarsalasespera");
    }

    function cancelarespera() {
        if ($this->session->userdata('perfil_id') != 12) {
            $verificar = $this->exame->cancelarespera();
            if ($verificar == "-1") {
                $data['mensagem'] = 'Erro ao cancelar o Exame. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao cancelar o Exame.';
            }
        } else {
            $data['mensagem'] = 'Erro ao cancelar o Exame. Você não possui perfil para realizar essa opera&ccedil;&atilde;o .';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarsalasespera");
    }

    function cancelarguia() {
        if ($this->session->userdata('perfil_id') != 12) {
            $verificar = $this->exame->cancelarespera();
            if ($verificar == "-1") {
                $data['mensagem'] = 'Erro ao cancelar o Exame. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao cancelar o Exame.';
            }
        } else {
            $data['mensagem'] = 'Erro ao cancelar o Exame. Você não possui perfil para realizar essa opera&ccedil;&atilde;o .';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function telefonema($agenda_exame_id, $paciente) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['paciente'] = $paciente;
        $this->load->View('ambulatorio/telefonema-form', $data);
    }

    function chegada($agenda_exame_id, $paciente) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['paciente'] = $paciente;
        $this->load->View('ambulatorio/chegada-form', $data);
    }

    function telefonemagravar($agenda_exame_id) {
        $this->exame->telefonema($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function chegadagravar($agenda_exame_id) {
        $this->exame->chegada($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function observacao($agenda_exame_id, $paciente = '') {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['paciente'] = $paciente;
        $this->load->View('ambulatorio/observacao-form', $data);
    }

    function alterarobservacao($agenda_exame_id) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['observacao'] = $this->exame->listarobservacoes($agenda_exame_id);
        $this->load->View('ambulatorio/alterarobservacao-form', $data);
    }

    function alterarobservacaofaturar($agenda_exame_id) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['observacao'] = $this->exame->listarobservacoesfaturar($agenda_exame_id);
        $this->load->View('ambulatorio/alteracaoobservacaofaturamento-form', $data);
    }

    function alterarobservacaofaturaramentomanual($guia_id) {
        $data['guia_id'] = $guia_id;
        $data['observacao'] = $this->exame->listarobservacoesfaturaramentomanual($guia_id);
//        var_dump($data);die;
        $this->load->View('ambulatorio/alteracaoobservacaofaturamentomanual-form', $data);
    }

    function observacaogravar($agenda_exame_id) {
        $verificar = $this->exame->observacao($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function observacaofaturargravar($agenda_exame_id) {
        $this->exame->observacaofaturamento($agenda_exame_id);
        echo '<script type="text/javascript">window.close();</script>';
    }

    function observacaofaturaramentomanualgravar($guia_id) {
        $this->exame->observacaofaturamentomanual($guia_id);
        echo '<script type="text/javascript">window.close();</script>';
    }

    function desbloquear($agenda_exame_id, $inicio) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['inicio'] = $inicio;
        $this->load->View('ambulatorio/desbloquearagenda-form', $data);
    }

    function bloquear($agenda_exame_id, $inicio) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['inicio'] = $inicio;
        $this->load->View('ambulatorio/bloquearagenda-form', $data);
    }

    function desbloqueargravar($agenda_exame_id) {
        $this->exame->desbloquear($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function bloqueargravar($agenda_exame_id) {
        $this->exame->bloquear($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function cancelarexame() {
        if ($this->session->userdata('perfil_id') != 12) {
            $verificar = $this->exame->cancelarexame();
            if ($verificar == "-1") {
                $data['mensagem'] = 'Erro ao cancelar o Exame. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao cancelar o Exame.';
            }
        } else {
            $data['mensagem'] = 'Erro ao cancelar o Exame. Você não possui perfil para realizar essa opera&ccedil;&atilde;o .';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamerealizando");
    }

    function voltarexame($exame_id, $sala_id, $agenda_exames_id) {
        $verificar = $this->exame->voltarexame($exame_id, $sala_id, $agenda_exames_id);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao adiar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao adiar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamerealizando");
    }

    function voltarexamependente($exame_id, $sala_id, $agenda_exames_id) {
        $verificar = $this->exame->voltarexame($exame_id, $sala_id, $agenda_exames_id);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao adiar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao adiar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamependente", $data);
    }

    function finalizarexame($exames_id, $sala_id) {
        $verificar = $this->exame->finalizarexame($exames_id, $sala_id);
        if ($verificar == -1) {
            $data['mensagem'] = 'Erro ao finalizar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao finalizar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamerealizando", $data);
    }

    function finalizarexamependente($exames_id, $sala_id, $agenda_exames_id) {
        $verificar = $this->exame->finalizarexamependente($exames_id, $sala_id, $agenda_exames_id);
        if ($verificar == -1) {
            $data['mensagem'] = 'Erro ao finalizar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao finalizar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamependente", $data);
    }

    function finalizarexametodos($sala_id, $guia_id, $grupo) {
        $verificar = $this->exame->finalizarexametodos($sala_id, $guia_id, $grupo);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao finalizar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao finalizar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamerealizando", $data);
    }

    function pendenteexame($exames_id, $sala_id) {
        $verificar = $this->exame->pendenteexame($exames_id, $sala_id);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao encaminhar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao encaminhar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamerealizando");
    }

    function gastosdesala($exames_id, $convenio_id, $sala_id = null) {
        $data['convenio_id'] = $convenio_id;
        $data['sala_id'] = $sala_id;

        $data['armazem_id'] = $this->exame->listararmazemsala($sala_id);
        $armazem_id = $data['armazem_id'];
        $data['paciente'] = $this->exame->listarpacientegastos($exames_id);
        $data['produtos'] = $this->exame->listarprodutossalagastos($convenio_id, $armazem_id);
        $data['guia_id'] = $this->exame->listargastodesalaguia($exames_id);
        $data['produtos_gastos'] = $this->exame->listaritensgastos($data['guia_id']);
        $data['laudo'] = $this->exame->mostrarlaudogastodesala($exames_id);
//        echo '<pre>'; var_dump($data['laudo']);
        $data['exames_id'] = $exames_id;
        $this->load->View('ambulatorio/gastosdesala', $data);
    }

    function gravargastodesala() {

        $exame_id = $_POST['exame_id'];
//        var_dump($exame_id);
//        die;
        $sala_id = $_POST['sala_id'];
//        $convenio_id = $_POST['convenio_id'];
        $data['agenda_exames'] = $this->exame->listaagendaexames($exame_id);
        $convenio_id = $data['agenda_exames'][0]->convenio_id;
        $this->exame->gravargastodesala();
        if (isset($_POST['faturar'])) {



            $_POST['medicoagenda'] = $data['agenda_exames'][0]->medico_agenda;
            $_POST['tipo'] = $data['agenda_exames'][0]->tipo;
            $data['procedimento'] = $this->exame->listaprocedimento($_POST['procedimento_id'], $convenio_id);
//            var_dump($data['procedimento']); die;
            if (count($data['procedimento']) > 0) {
                $this->exame->faturargastodesala($data['procedimento'][0]);
            }
        }
        redirect(base_url() . "ambulatorio/exame/gastosdesala/$exame_id/$convenio_id/$sala_id");
    }

    function excluirgastodesala($gasto_id, $exame_id, $convenio_id, $sala_id) {
        $this->exame->excluirgastodesala($gasto_id);
        redirect(base_url() . "ambulatorio/exame/gastosdesala/$exame_id/$convenio_id/$sala_id");
//        $this->gastosdesala($exame_id);
    }

    function anexarimagem($exame_id, $sala_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['arquivos_deletados'] = directory_map("./uploadopm/$exame_id/");
        $data['agenda_exames'] = $this->exame->listaagendaexames($exame_id);
        $convenio_id = $data['agenda_exames'][0]->convenio_id;
//        $data['arquivo_pasta'] = directory_map("/home/hamilton/projetos/clinica/upload/$exame_id/");
        //$data['arquivos_deletados'] = directory_map("/home/hamilton/projetos/clinica/uploadopm/$exame_id/");
        $data['convenio_id'] = $convenio_id;
        $data['exame_id'] = $exame_id;
        $data['sala_id'] = $sala_id;
        $this->loadView('ambulatorio/importacao-imagem', $data);
    }

    function anexarimagemmedico($exame_id, $sala_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
//        $data['arquivo_pasta'] = directory_map("/home/hamilton/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            natcasesort($data['arquivo_pasta']);
        }
        $data['arquivos_deletados'] = directory_map("./uploadopm/$exame_id/");
//        $data['arquivos_deletados'] = directory_map("/home/hamilton/projetos/clinica/uploadopm/$exame_id/");
        $data['exame_id'] = $exame_id;
        $data['sala_id'] = $sala_id;
        $this->load->View('ambulatorio/importacao-imagem2', $data);
    }

    function importarimagem() {
        $exame_id = $_POST['exame_id'];
        $sala_id = $_POST['sala_id'];
//        $data = $_FILES['userfile'];
//        var_dump($data);
//        die;
        if (!is_dir("./upload/$exame_id")) {
            mkdir("./upload/$exame_id");
            $destino = "./upload/$exame_id";
            chmod($destino, 0777);
        }

        $config['upload_path'] = "./upload/" . $exame_id . "/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1000';
        $config['overwrite'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $data = array('upload_data' => $this->upload->data());
        }
        $data['exame_id'] = $exame_id;
        $this->anexarimagem($exame_id, $sala_id);
    }

    function excluirimagemmedico($exame_id, $nome, $sala_id) {

        if (!is_dir("./uploadopm/$exame_id")) {
            mkdir("./uploadopm/$exame_id");
            $pasta = "./uploadopm/$exame_id";
            chmod($pasta, 0777);
        }
        $origem = "./upload/$exame_id/$nome";
        $destino = "./uploadopm/$exame_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        redirect(base_url() . "ambulatorio/exame/anexarimagemmedico/$exame_id/$sala_id");
    }

    function excluirimagem($exame_id, $nome, $sala_id) {

        if (!is_dir("./uploadopm/$exame_id")) {
            mkdir("./uploadopm/$exame_id");
            $pasta = "./uploadopm/$exame_id";
            chmod($pasta, 0777);
        }
        $origem = "./upload/$exame_id/$nome";
        $destino = "./uploadopm/$exame_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        redirect(base_url() . "ambulatorio/exame/anexarimagem/$exame_id/$sala_id");
    }

    function moverimagens($exame_id, $sala_id) {

        //HUMANA
        $this->load->helper('directory');
        if ($sala_id == 1) {

            //$arquivo_pasta = directory_map("/home/hamilton/teste/");
            $arquivo_pasta = directory_map("./upload/ultrasom1/");
            //$origem = "/home/hamilton/teste";
            $origem = "./upload/ultrasom1";
            foreach ($arquivo_pasta as $value) {
                $nova = substr($value, 11, 6);
                if (!is_dir("./upload/$exame_id")) {
                    mkdir("./upload/$exame_id");
                    $destino = "./upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "./upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }
        if ($sala_id == 2) {

            $arquivo_pasta = directory_map("./upload/ultrasom2/");
            $origem = "./upload/ultrasom2";
            foreach ($arquivo_pasta as $value) {
                $nova = substr($value, 11, 6);
                if (!is_dir("./upload/$exame_id")) {
                    mkdir("./upload/$exame_id");
                    $destino = "./upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "./upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }
        if ($sala_id == 9) {

            $arquivo_pasta = directory_map("./upload/ultrasom3/");
            $origem = "./upload/ultrasom3";
            foreach ($arquivo_pasta as $value) {
                $nova = substr($value, 8, 6);
                if (!is_dir("./upload/$exame_id")) {
                    mkdir("./upload/$exame_id");
                    $destino = "./upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "./upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }

        delete_files($origem);

        redirect(base_url() . "ambulatorio/exame/anexarimagem/$exame_id/$sala_id");

//        CAGE/GASTROSUL
//        
//        $this->load->helper('directory');
//        if ($sala_id == 1) {
//
//            //$arquivo_pasta = directory_map("/home/hamilton/teste/");
//            $arquivo_pasta = directory_map("./upload/ultrasom1/");
//            sort($arquivo_pasta);
//            //$origem = "/home/hamilton/teste";
//            $origem = "./upload/ultrasom1";
//            foreach ($arquivo_pasta as $value) {
//                $i++;
//                $nova = $i . ".jpg";
//                if (!is_dir("./upload/$exame_id")) {
//                    mkdir("./upload/$exame_id");
//                    $destino = "./upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "./upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//        if ($sala_id == 2) {
//
//            $arquivo_pasta = directory_map("./upload/ultrasom2/");
//            sort($arquivo_pasta);
//            $origem = "./upload/ultrasom2";
//            foreach ($arquivo_pasta as $value) {
//                $i++;
//                $nova = $i . ".jpg";
//                if (!is_dir("./upload/$exame_id")) {
//                    mkdir("./upload/$exame_id");
//                    $destino = "./upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "./upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//        if ($sala_id == 9) {
//
//            $arquivo_pasta = directory_map("./upload/ultrasom3/");
//            sort($arquivo_pasta);
//            $origem = "./upload/ultrasom3";
//            foreach ($arquivo_pasta as $value) {
//                $i++;
//                $nova = $i . ".jpg";
//                if (!is_dir("./upload/$exame_id")) {
//                    mkdir("./upload/$exame_id");
//                    $destino = "./upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "./upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//
//        delete_files($origem);
//
//        redirect(base_url() . "ambulatorio/exame/anexarimagem/$exame_id/$sala_id");
    }

    function moverimagensmedico($exame_id, $sala_id) {
        //HUMANA
        //
        
//        
//        $this->load->helper('directory');
//        if ($sala_id == 1) {
//
//            //$arquivo_pasta = directory_map("/home/hamilton/teste/");
//            $arquivo_pasta = directory_map("./upload/ultrasom1/");
//            //$origem = "/home/hamilton/teste";
//            $origem = "./upload/ultrasom1";
//            foreach ($arquivo_pasta as $value) {
//
//                $nova = substr($value, 11, 6);
//
//                if (!is_dir("./upload/$exame_id")) {
//                    mkdir("./upload/$exame_id");
//                    $destino = "./upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "./upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//        if ($sala_id == 2) {
//
//            $arquivo_pasta = directory_map("./upload/ultrasom2/");
//            $origem = "./upload/ultrasom2";
//            foreach ($arquivo_pasta as $value) {
//
//                $nova = substr($value, 11, 6);
//
//                if (!is_dir("./upload/$exame_id")) {
//                    mkdir("./upload/$exame_id");
//                    $destino = "./upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "./upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//        if ($sala_id == 9) {
//
//            $arquivo_pasta = directory_map("./upload/ultrasom3/");
//            $origem = "./upload/ultrasom3";
//            foreach ($arquivo_pasta as $value) {
//
//                $nova = substr($value, 8, 6);
//
//                if (!is_dir("./upload/$exame_id")) {
//                    mkdir("./upload/$exame_id");
//                    $destino = "./upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "./upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//
//        delete_files($origem);
//
//        redirect(base_url() . "ambulatorio/exame/anexarimagemmedico/$exame_id/$sala_id");
//      CAGE/GASTROSUL

        $this->load->helper('directory');
        $contador = directory_map("./upload/$exame_id/");
//        var_dump(count($contador)); die;
        if ($contador > 0) {
            $i = count($contador);
        } else {
            $i = 0;
        }
        if ($sala_id == 1) {

            //$arquivo_pasta = directory_map("/home/hamilton/teste/");
            $arquivo_pasta = directory_map("./upload/ultrasom1/");

            natcasesort($arquivo_pasta);

            $origem = "./upload/ultrasom1";
            foreach ($arquivo_pasta as $value) {
                $i++;
                $nova = $i . ".jpg";

                if (!is_dir("./upload/$exame_id")) {
                    mkdir("./upload/$exame_id");
                    $destino = "./upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "./upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }
        if ($sala_id == 2) {


            $arquivo_pasta = directory_map("./upload/ultrasom2/");
            natcasesort($arquivo_pasta);
            $origem = "./upload/ultrasom2";
            foreach ($arquivo_pasta as $value) {

                $i++;
                $nova = $i . ".jpg";

                if (!is_dir("./upload/$exame_id")) {
                    mkdir("./upload/$exame_id");
                    $destino = "./upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "./upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }
        if ($sala_id == 9) {

            $arquivo_pasta = directory_map("./upload/ultrasom3/");
            natcasesort($arquivo_pasta);
            $origem = "./upload/ultrasom3";
            foreach ($arquivo_pasta as $value) {

                $i++;
                $nova = $i . ".jpg";

                if (!is_dir("./upload/$exame_id")) {
                    mkdir("./upload/$exame_id");
                    $destino = "./upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "./upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }

        delete_files($origem);

        redirect(base_url() . "ambulatorio/exame/anexarimagemmedico/$exame_id/$sala_id");
    }

    function restaurarimagem($exame_id, $nome) {



        $origem = "./uploadopm/$exame_id/$nome";
        $destino = "./upload/$exame_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        redirect(base_url() . "ambulatorio/exame/anexarimagem/$exame_id");
    }

    function ordenarimagens($exame_id, $sala_id) {
        $this->load->helper('directory');
        $i = 1;
        $b = 1;
        $imagens = $_POST['teste'];
//        var_dump($imagens); die;
        foreach ($imagens as $value) {

            $origem = "./upload/$exame_id/$value";
            $destino = "./upload/$exame_id/$i-$value";
            copy($origem, $destino);
            unlink($origem);
            $i++;
        }
        $arquivo_pasta = directory_map("./upload/$exame_id");
        natcasesort($arquivo_pasta);
//        var_dump($arquivo_pasta);
//        die;

        foreach ($arquivo_pasta as $value) {
//            var_dump($value); die;
            $nova = $nova = $b . ".jpg";
            ;
            $oldname = "./upload/$exame_id/$value";
            $newname = "./upload/$exame_id/$nova";
            rename($oldname, $newname);
            $b++;
        }

        redirect(base_url() . "ambulatorio/exame/anexarimagemmedico/$exame_id/$sala_id");
    }

    function restaurarimagemmedico($exame_id, $nome, $sala_id) {
        $this->load->helper('directory');

        $contador = directory_map("./upload/$exame_id/");
//        var_dump(count($contador)); die;
        if ($contador > 0) {
            $novonome = count($contador) + 1 . '.jpg';
        } else {
            $novonome = $nome;
        }


//        var_dump($novonome); die;

        $origem = "./uploadopm/$exame_id/$nome";
        $destino = "./upload/$exame_id/$novonome";
        copy($origem, $destino);
        unlink($origem);

        redirect(base_url() . "ambulatorio/exame/anexarimagemmedico/$exame_id/$sala_id");
    }

    function gravarpaciente() {
        $agenda_exame_id = $_POST['txtagenda_exames_id'];
        $verificar = $this->exame->gravarpaciente($agenda_exame_id);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao marcar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao marcar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame");
    }

    function listaragendaexame($agenda_exames_nome_id) {

        $dia = date("Y-m-d");
        $data['diainicio'] = $dia;
        $data['agenda_exames_nome_id'] = $agenda_exames_nome_id;
        $data['dia1'] = $this->exame->listarexameagenda($dia, $agenda_exames_nome_id);
        $data['contadia1'] = $this->exame->contador($dia, $agenda_exames_nome_id);
        $data2 = date('d-m-Y', strtotime("+1 days", strtotime($dia)));
        $data['dia2'] = $this->exame->listarexameagenda($data2, $agenda_exames_nome_id);
        $data['contadia2'] = $this->exame->contador($data2, $agenda_exames_nome_id);
        $data3 = date('d-m-Y', strtotime("+2 days", strtotime($dia)));
        $data['dia3'] = $this->exame->listarexameagenda($data3, $agenda_exames_nome_id);
        $data['contadia3'] = $this->exame->contador($data3, $agenda_exames_nome_id);
        $data4 = date('d-m-Y', strtotime("+3 days", strtotime($dia)));
        $data['dia4'] = $this->exame->listarexameagenda($data4, $agenda_exames_nome_id);
        $data['contadia4'] = $this->exame->contador($data4, $agenda_exames_nome_id);
        $data5 = date('d-m-Y', strtotime("+4 days", strtotime($dia)));
        $data['dia5'] = $this->exame->listarexameagenda($data5, $agenda_exames_nome_id);
        $data['contadia5'] = $this->exame->contador($data5, $agenda_exames_nome_id);
        $data6 = date('d-m-Y', strtotime("+5 days", strtotime($dia)));
        $data['dia6'] = $this->exame->listarexameagenda($data6, $agenda_exames_nome_id);
        $data['contadia6'] = $this->exame->contador($data6, $agenda_exames_nome_id);
        $data7 = date('d-m-Y', strtotime("+6 days", strtotime($dia)));
        $data['dia7'] = $this->exame->listarexameagenda($data7, $agenda_exames_nome_id);
        $data['contadia7'] = $this->exame->contador($data7, $agenda_exames_nome_id);
        if ($data['contadia1'] != '0') {
            $data['repetidor'] = $data['dia1'];
        } elseif ($data['contadia2'] != '0') {
            $data['repetidor'] = $data['dia2'];
        } elseif ($data['contadia3'] != '0') {
            $data['repetidor'] = $data['dia3'];
        } elseif ($data['contadia4'] != '0') {
            $data['repetidor'] = $data['dia4'];
        } elseif ($data['contadia5'] != '0') {
            $data['repetidor'] = $data['dia5'];
        } elseif ($data['contadia6'] != '0') {
            $data['repetidor'] = $data['dia6'];
        } elseif ($data['contadia7'] != '0') {
            $data['repetidor'] = $data['dia7'];
        }
        $this->loadView('ambulatorio/exameagenda-lista', $data);

//            $this->carregarView($data);
    }

    function esquerda($dia, $agenda_exames_nome_id) {

        $data['diainicio'] = date('d-m-Y', strtotime("-7 days", strtotime($dia)));
        $dia = date('d-m-Y', strtotime("-7 days", strtotime($dia)));
        $data['agenda_exames_nome_id'] = $agenda_exames_nome_id;
        $data['dia1'] = $this->exame->listarexameagenda($dia, $agenda_exames_nome_id);
        $data['contadia1'] = $this->exame->contador($dia, $agenda_exames_nome_id);
        $data2 = date('d-m-Y', strtotime("+1 days", strtotime($dia)));
        $data['dia2'] = $this->exame->listarexameagenda($data2, $agenda_exames_nome_id);
        $data['contadia2'] = $this->exame->contador($data2, $agenda_exames_nome_id);
        $data3 = date('d-m-Y', strtotime("+2 days", strtotime($dia)));
        $data['dia3'] = $this->exame->listarexameagenda($data3, $agenda_exames_nome_id);
        $data['contadia3'] = $this->exame->contador($data3, $agenda_exames_nome_id);
        $data4 = date('d-m-Y', strtotime("+3 days", strtotime($dia)));
        $data['dia4'] = $this->exame->listarexameagenda($data4, $agenda_exames_nome_id);
        $data['contadia4'] = $this->exame->contador($data4, $agenda_exames_nome_id);
        $data5 = date('d-m-Y', strtotime("+4 days", strtotime($dia)));
        $data['dia5'] = $this->exame->listarexameagenda($data5, $agenda_exames_nome_id);
        $data['contadia5'] = $this->exame->contador($data5, $agenda_exames_nome_id);
        $data6 = date('d-m-Y', strtotime("+5 days", strtotime($dia)));
        $data['dia6'] = $this->exame->listarexameagenda($data6, $agenda_exames_nome_id);
        $data['contadia6'] = $this->exame->contador($data6, $agenda_exames_nome_id);
        $data7 = date('d-m-Y', strtotime("+6 days", strtotime($dia)));
        $data['dia7'] = $this->exame->listarexameagenda($data7, $agenda_exames_nome_id);
        $data['contadia7'] = $this->exame->contador($data7, $agenda_exames_nome_id);
        if ($data['contadia1'] != '0') {
            $data['repetidor'] = $data['dia1'];
        } elseif ($data['contadia2'] != '0') {
            $data['repetidor'] = $data['dia2'];
        } elseif ($data['contadia3'] != '0') {
            $data['repetidor'] = $data['dia3'];
        } elseif ($data['contadia4'] != '0') {
            $data['repetidor'] = $data['dia4'];
        } elseif ($data['contadia5'] != '0') {
            $data['repetidor'] = $data['dia5'];
        } elseif ($data['contadia6'] != '0') {
            $data['repetidor'] = $data['dia6'];
        } elseif ($data['contadia7'] != '0') {
            $data['repetidor'] = $data['dia7'];
        }

        $this->loadView('ambulatorio/exameagenda-lista', $data);
    }

    function direita($dia, $agenda_exames_nome_id) {

        $data['diainicio'] = date('d-m-Y', strtotime("+7 days", strtotime($dia)));
        $dia = date('d-m-Y', strtotime("+7 days", strtotime($dia)));
        $data['agenda_exames_nome_id'] = $agenda_exames_nome_id;
        $data['dia1'] = $this->exame->listarexameagenda($dia, $agenda_exames_nome_id);
        $data['contadia1'] = $this->exame->contador($dia, $agenda_exames_nome_id);
        $data2 = date('d-m-Y', strtotime("+1 days", strtotime($dia)));
        $data['dia2'] = $this->exame->listarexameagenda($data2, $agenda_exames_nome_id);
        $data['contadia2'] = $this->exame->contador($data2, $agenda_exames_nome_id);
        $data3 = date('d-m-Y', strtotime("+2 days", strtotime($dia)));
        $data['dia3'] = $this->exame->listarexameagenda($data3, $agenda_exames_nome_id);
        $data['contadia3'] = $this->exame->contador($data3, $agenda_exames_nome_id);
        $data4 = date('d-m-Y', strtotime("+3 days", strtotime($dia)));
        $data['dia4'] = $this->exame->listarexameagenda($data4, $agenda_exames_nome_id);
        $data['contadia4'] = $this->exame->contador($data4, $agenda_exames_nome_id);
        $data5 = date('d-m-Y', strtotime("+4 days", strtotime($dia)));
        $data['dia5'] = $this->exame->listarexameagenda($data5, $agenda_exames_nome_id);
        $data['contadia5'] = $this->exame->contador($data5, $agenda_exames_nome_id);
        $data6 = date('d-m-Y', strtotime("+5 days", strtotime($dia)));
        $data['dia6'] = $this->exame->listarexameagenda($data6, $agenda_exames_nome_id);
        $data['contadia6'] = $this->exame->contador($data6, $agenda_exames_nome_id);
        $data7 = date('d-m-Y', strtotime("+6 days", strtotime($dia)));
        $data['dia7'] = $this->exame->listarexameagenda($data7, $agenda_exames_nome_id);
        $data['contadia7'] = $this->exame->contador($data7, $agenda_exames_nome_id);
        if ($data['contadia1'] != '0') {
            $data['repetidor'] = $data['dia1'];
        } elseif ($data['contadia2'] != '0') {
            $data['repetidor'] = $data['dia2'];
        } elseif ($data['contadia3'] != '0') {
            $data['repetidor'] = $data['dia3'];
        } elseif ($data['contadia4'] != '0') {
            $data['repetidor'] = $data['dia4'];
        } elseif ($data['contadia5'] != '0') {
            $data['repetidor'] = $data['dia5'];
        } elseif ($data['contadia6'] != '0') {
            $data['repetidor'] = $data['dia6'];
        } elseif ($data['contadia7'] != '0') {
            $data['repetidor'] = $data['dia7'];
        }

        $this->loadView('ambulatorio/exameagenda-lista', $data);
    }

    function carregarprocedimento($procedimento_tuss_id) {
        $obj_procedimento = new procedimento_model($procedimento_tuss_id);
        $data['obj'] = $obj_procedimento;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimento-form', $data);
    }

    function novoagendaexame($agenda_id) {
        $data['agenda_id'] = $agenda_id;
        $data['medico'] = $this->exame->listarmedico();
        $data['agenda'] = $this->agenda->listaratribuiragenda($agenda_id);
        $data['salas'] = $this->exame->listartodassalas();
        $data['horarioagenda'] = $this->agenda->listarhorarioagenda($agenda_id);
        $this->loadView('ambulatorio/exame-form', $data);
    }

    function novoagendaconsulta($agenda_id) {
        $data['agenda_id'] = $agenda_id;
        $data['medico'] = $this->exame->listarmedico();
        $data['agenda'] = $this->agenda->listaratribuiragenda($agenda_id);
        $data['horarioagenda'] = $this->agenda->listarhorarioagenda($agenda_id);
//        var_dump($data['horarioagenda']); die;
        $data['tipo'] = $this->tipoconsulta->listartodos();
        $this->loadView('ambulatorio/consulta-form', $data);
    }

    function novoagendaespecializacao($agenda_id) {
        $data['agenda_id'] = $agenda_id;
        $data['medico'] = $this->exame->listarmedico();
        $data['agenda'] = $this->agenda->listaratribuiragenda($agenda_id);
        $data['horarioagenda'] = $this->agenda->listarhorarioagenda($agenda_id);
        $data['tipo'] = $this->agenda->listarespecialidades();
        $this->loadView('ambulatorio/especializacao-form', $data);
    }

    function excluir($procedimento_tuss_id) {
        if ($this->procedimento->excluir($procedimento_tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimento';
        } else {
            $mensagem = 'Erro ao excluir o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimento");
    }

    function gravarss() {
        $procedimento_tuss_id = $this->procedimento->gravar();
        if ($procedimento_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimento");
    }

    function gravar() {

        $agenda_id = $_POST['txthorario'];
        $sala_id = $_POST['txtsala'];
        $medico_id = $_POST['txtmedico'];
        $datainicial = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdatainicial'])));
        $datafinal = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdatafinal'])));
        $nome = $_POST['txtNome'];
        $tipo = 'EXAME';
        $horarioagenda = $this->agenda->listarhorarioagendacriacao($agenda_id, $medico_id, $datainicial, $datafinal, $tipo);
//        var_dump($horarioagenda); die;
        $id = 0;

        foreach ($horarioagenda as $item) {

            $tempoconsulta = $item->tempoconsulta;
            $qtdeconsulta = $item->qtdeconsulta;
            $qtdeconsulta = (int) $qtdeconsulta;
            $horarioagenda_id = $item->horarioagenda_id;
            $empresa_id = $item->empresa_id;
            $obs = $item->observacoes;

            if (($qtdeconsulta != 0) && ($item->intervaloinicio == "00:00:00")) {
                $entrada = $item->horaentrada1;
                $saida = $item->horasaida1;
                $hora1 = explode(":", $entrada);
                $hora2 = explode(":", $saida);
                $acumulador1 = ($hora1[0] * 60) + $hora1[1];
                $acumulador2 = ($hora2[0] * 60) + $hora2[1];
                $resultado = $acumulador2 - $acumulador1;
                $tempoconsulta = $resultado / $item->qtdeconsulta;
                $tempoconsulta = (int) $tempoconsulta + 1;
            }
            if (($qtdeconsulta != 0) && ($item->intervaloinicio != "00:00:00")) {
                $entrada = $item->horaentrada1;
                $saida = $item->horasaida1;
                $intervaloinicio = $item->intervaloinicio;
                $intervalofim = $item->intervalofim;
                $hora1 = explode(":", $entrada);
                $hora2 = explode(":", $saida);
                $horainicio = explode(":", $intervaloinicio);
                $horafim = explode(":", $intervalofim);
                $acumulador1 = ($hora1[0] * 60) + $hora1[1];
                $acumulador2 = ($hora2[0] * 60) + $hora2[1];
                $acumulador3 = ($horainicio[0] * 60) + $horainicio[1];
                $acumulador4 = ($horafim[0] * 60) + $horafim[1];
                $resultado = ($acumulador3 - $acumulador1) + ($acumulador2 - $acumulador4);
                $tempoconsulta = $resultado / $item->qtdeconsulta;
                $tempoconsulta = (int) $tempoconsulta + 1;
            }

            for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                $data = strftime("%A", strtotime($index));

                switch ($data) {
                    case"Sunday": $data = "Domingo";
                        break;
                    case"Monday": $data = "Segunda";
                        break;
                    case"Tuesday": $data = "Terça";
                        break;
                    case"Wednesday": $data = "Quarta";
                        break;
                    case"Thursday": $data = "Quinta";
                        break;
                    case"Friday": $data = "Sexta";
                        break;
                    case"Saturday": $data = "Sabado";
                        break;
                }
                $i = 0;
                $horaconsulta = 0;
                $horaverifica = 0;
                $horasaida = 0;
                if ($data == substr($item->dia, 4)) {
                    for ($horaindex = $item->horaentrada1; $horaindex <= $item->horasaida1; $horaindex = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaindex)))) {

                        if ($item->intervaloinicio == "00:00:00") {
                            if ($i == 0) {
                                $horaconsulta = date('H:i:s', strtotime($item->horaentrada1));
                                $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($item->horaentrada1)));
                                $i = 1;
                                if ($id == 0) {
                                    $id = $this->exame->gravarnome($nome);
                                }
                                $this->exame->gravar($horarioagenda_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id, $empresa_id, $obs);
                            }
                            if (( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravar($horarioagenda_id, $agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id, $empresa_id, $obs);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        } else {
                            if ($i == 0) {
                                $horaconsulta = date('H:i:s', strtotime($item->horaentrada1));
                                $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($item->horaentrada1)));
                                $i = 1;
                                if ($id == 0) {
                                    $id = $this->exame->gravarnome($nome);
                                }
                                $this->exame->gravar($horarioagenda_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id, $empresa_id, $obs);
                            }
                            if ((($horaverifica < $item->intervaloinicio) || ($horaverifica >= $item->intervalofim)) && ( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravar($horarioagenda_id, $agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id, $empresa_id, $obs);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        }
                    }
                }
            }
        }

        $data['mensagem'] = 'Sucesso ao gravar o Agenda.';

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/agenda");
    }

    function gravarconsulta() {
        $agenda_id = $_POST['txthorario'];
        $medico_id = $_POST['txtmedico'];
        $datainicial = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdatainicial'])));
        $datafinal = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdatafinal'])));
        $nome = $_POST['txtNome'];
        $tipo = 'CONSULTA';
        $horarioagenda = $this->agenda->listarhorarioagendacriacao($agenda_id, $medico_id, $datainicial, $datafinal, $tipo);
//        var_dump($horarioagenda); die;
        $id = 0;

        foreach ($horarioagenda as $item) {

            $observacoes = $item->observacoes;
            $horarioagenda_id = $item->horarioagenda_id;
            $empresa_id = $item->empresa_id;
            $tempoconsulta = $item->tempoconsulta;
            $qtdeconsulta = $item->qtdeconsulta;
            $qtdeconsulta = (int) $qtdeconsulta;

            if (($qtdeconsulta != 0) && ($item->intervaloinicio == "00:00:00")) {
                $entrada = $item->horaentrada1;
                $saida = $item->horasaida1;
                $hora1 = explode(":", $entrada);
                $hora2 = explode(":", $saida);
                $acumulador1 = ($hora1[0] * 60) + $hora1[1];
                $acumulador2 = ($hora2[0] * 60) + $hora2[1];
                $resultado = $acumulador2 - $acumulador1;
                $tempoconsulta = $resultado / $item->qtdeconsulta;
                $tempoconsulta = (int) $tempoconsulta + 1;
            }
            if (($qtdeconsulta != 0) && ($item->intervaloinicio != "00:00:00")) {
                $entrada = $item->horaentrada1;
                $saida = $item->horasaida1;
                $intervaloinicio = $item->intervaloinicio;
                $intervalofim = $item->intervalofim;
                $hora1 = explode(":", $entrada);
                $hora2 = explode(":", $saida);
                $horainicio = explode(":", $intervaloinicio);
                $horafim = explode(":", $intervalofim);
                $acumulador1 = ($hora1[0] * 60) + $hora1[1];
                $acumulador2 = ($hora2[0] * 60) + $hora2[1];
                $acumulador3 = ($horainicio[0] * 60) + $horainicio[1];
                $acumulador4 = ($horafim[0] * 60) + $horafim[1];
                $resultado = ($acumulador3 - $acumulador1) + ($acumulador2 - $acumulador4);
                $tempoconsulta = $resultado / $item->qtdeconsulta;
                $tempoconsulta = (int) $tempoconsulta + 1;
            }

            for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {
//                var_dump($index); die;
                $data = strftime("%A", strtotime($index));

                switch ($data) {
                    case"Sunday": $data = "Domingo";
                        break;
                    case"Monday": $data = "Segunda";
                        break;
                    case"Tuesday": $data = "Terça";
                        break;
                    case"Wednesday": $data = "Quarta";
                        break;
                    case"Thursday": $data = "Quinta";
                        break;
                    case"Friday": $data = "Sexta";
                        break;
                    case"Saturday": $data = "Sabado";
                        break;
                }
                $i = 0;
                $horaconsulta = 0;
                $horaverifica = 0;
                $horasaida = 0;
                if ($data == substr($item->dia, 4)) {
                    for ($horaindex = $item->horaentrada1; $horaindex <= $item->horasaida1; $horaindex = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaindex)))) {

                        if ($item->intervaloinicio == "00:00:00") {
                            if ($i == 0) {
                                $horaconsulta = date('H:i:s', strtotime($item->horaentrada1));
                                $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($item->horaentrada1)));
                                $i = 1;
                                if ($id == 0) {
                                    $id = $this->exame->gravarnome($nome);
                                }
                                $this->exame->gravarconsulta($horarioagenda_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $observacoes, $empresa_id);
                            }
                            if (( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravarconsulta($horarioagenda_id, $agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $observacoes, $empresa_id);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        } else {
                            if ($i == 0) {
                                $horaconsulta = date('H:i:s', strtotime($item->horaentrada1));
                                $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($item->horaentrada1)));
                                $i = 1;
                                if ($id == 0) {
                                    $id = $this->exame->gravarnome($nome);
                                }
                                $this->exame->gravarconsulta($horarioagenda_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $observacoes, $empresa_id);
                            }
                            if ((($horaverifica < $item->intervaloinicio) || ($horaverifica >= $item->intervalofim)) && ( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravarconsulta($horarioagenda_id, $agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $observacoes, $empresa_id);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        }
                    }
                }
            }
        }

        $data['mensagem'] = 'Sucesso ao gravar o Agenda.';

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/agenda");
    }

    function gravarespecialidade() {
        $agenda_id = $_POST['txthorario'];
        $medico_id = $_POST['txtmedico'];
        $datainicial = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdatainicial'])));
        $datafinal = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdatafinal'])));
        $nome = $_POST['txtNome'];
        $tipo = 'ESPECIALIDADE';
        $horarioagenda = $this->agenda->listarhorarioagendacriacaoespecialidade($agenda_id, $medico_id, $datainicial, $datafinal, $tipo);
//        var_dump($horarioagenda); die;
        $id = 0;
//        var_dump($horarioagenda);die;
        foreach ($horarioagenda as $item) {

            $tempoconsulta = $item->tempoconsulta;
            $qtdeconsulta = $item->qtdeconsulta;
            $qtdeconsulta = (int) $qtdeconsulta;
            $horarioagenda_id = $item->horarioagenda_id;
            $empresa_id = $item->empresa_id;
            $obs = $item->observacoes;

            if (($qtdeconsulta != 0) && ($item->intervaloinicio == "00:00:00")) {
                $entrada = $item->horaentrada1;
                $saida = $item->horasaida1;
                $hora1 = explode(":", $entrada);
                $hora2 = explode(":", $saida);
                $acumulador1 = ($hora1[0] * 60) + $hora1[1];
                $acumulador2 = ($hora2[0] * 60) + $hora2[1];
                $resultado = $acumulador2 - $acumulador1;
                $tempoconsulta = $resultado / $item->qtdeconsulta;
                $tempoconsulta = (int) $tempoconsulta + 1;
            }
            if (($qtdeconsulta != 0) && ($item->intervaloinicio != "00:00:00")) {
                $entrada = $item->horaentrada1;
                $saida = $item->horasaida1;
                $intervaloinicio = $item->intervaloinicio;
                $intervalofim = $item->intervalofim;
                $hora1 = explode(":", $entrada);
                $hora2 = explode(":", $saida);
                $horainicio = explode(":", $intervaloinicio);
                $horafim = explode(":", $intervalofim);
                $acumulador1 = ($hora1[0] * 60) + $hora1[1];
                $acumulador2 = ($hora2[0] * 60) + $hora2[1];
                $acumulador3 = ($horainicio[0] * 60) + $horainicio[1];
                $acumulador4 = ($horafim[0] * 60) + $horafim[1];
                $resultado = ($acumulador3 - $acumulador1) + ($acumulador2 - $acumulador4);
                $tempoconsulta = $resultado / $item->qtdeconsulta;
                $tempoconsulta = (int) $tempoconsulta + 1;
            }

            for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                $data = strftime("%A", strtotime($index));

                switch ($data) {
                    case"Sunday": $data = "Domingo";
                        break;
                    case"Monday": $data = "Segunda";
                        break;
                    case"Tuesday": $data = "Terça";
                        break;
                    case"Wednesday": $data = "Quarta";
                        break;
                    case"Thursday": $data = "Quinta";
                        break;
                    case"Friday": $data = "Sexta";
                        break;
                    case"Saturday": $data = "Sabado";
                        break;
                }
                $i = 0;
                $horaconsulta = 0;
                $horaverifica = 0;
                $horasaida = 0;
                if ($data == substr($item->dia, 4)) {
                    for ($horaindex = $item->horaentrada1; $horaindex <= $item->horasaida1; $horaindex = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaindex)))) {

                        if ($item->intervaloinicio == "00:00:00") {
                            if ($i == 0) {
                                $horaconsulta = date('H:i:s', strtotime($item->horaentrada1));
                                $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($item->horaentrada1)));
                                $i = 1;
                                if ($id == 0) {
                                    $id = $this->exame->gravarnome($nome);
                                }
                                $this->exame->gravarespecialidade($horarioagenda_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $empresa_id, $obs);
                            }
                            if (( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravarespecialidade($horarioagenda_id, $agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $empresa_id, $obs);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        } else {
                            if ($i == 0) {
                                $horaconsulta = date('H:i:s', strtotime($item->horaentrada1));
                                $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($item->horaentrada1)));
                                $i = 1;
                                if ($id == 0) {
                                    $id = $this->exame->gravarnome($nome);
                                }
                                $this->exame->gravarespecialidade($horarioagenda_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $empresa_id, $obs);
                            }
                            if ((($horaverifica < $item->intervaloinicio) || ($horaverifica >= $item->intervalofim)) && ( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravarespecialidade($horarioagenda_id, $agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $empresa_id, $obs);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        }
                    }
                }
            }
        }

        $data['mensagem'] = 'Sucesso ao gravar a Agenda.';

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/agenda");
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/servidor-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

    function gerarcr($agenda_exames_id) {
        $exame = $this->exame->listararquivo($agenda_exames_id);
        $titulo = "                                       " . $agenda_exames_id;
        $comando = "CMD=CREATE";
        $id = "PATID=" . $agenda_exames_id;
        $paciente = "PATNAME=" . $exame[0]->paciente;
        $sexo = "PATSEX=" . $exame[0]->sexo;
        $banco = "PATBD=19480915";
        $acc = "ACCNUM=" . $agenda_exames_id;
        $procedimento = "STDDESC=" . $exame[0]->procedimento;
        $modalidade = "MODALITY=CR";
        $data = "STDDATE=" . str_replace("-", "", date("Y-m-d"));
        $hora = "STDTIME=" . str_replace(":", "", date("H:i:s"));

        if (!is_dir("./cr/")) {
            mkdir("./cr/");
        }
        $nome = "./cr/" . $agenda_exames_id . ".txt";
        $fp = fopen($nome, "w+");
        fwrite($fp, $titulo . "\n");
        fwrite($fp, $comando . "\n");
        fwrite($fp, $id . "\n");
        fwrite($fp, $paciente . "\n");
        fwrite($fp, $sexo . "\n");
        fwrite($fp, $banco . "\n");
        fwrite($fp, $acc . "\n");
        fwrite($fp, $procedimento . "\n");
        fwrite($fp, $modalidade . "\n");
        fwrite($fp, $data . "\n");
        fwrite($fp, $hora . "\n");
        fclose($fp);
    }

    function gerarxml() {

        $total = 0;
        $listarpacienete = $this->exame->listarpacientesxmlfaturamento();
        $listarexame = $this->exame->listargxmlfaturamento();
        $listarexames = $this->exame->listarxmlfaturamentoexames();

        $horario = date("Y-m-d");
        $hora = date("H:i:s");
        $empresa = $this->exame->listarcnpj();
        $lote = $this->exame->listarlote();

        $codigoUF = $this->utilitario->codigo_uf($empresa[0]->codigo_ibge, 'codigo');

        $cnpjxml = $listarexame[0]->codigoidentificador;
        $razao_socialxml = $empresa[0]->razao_socialxml;
        $registroans = $listarexame[0]->registroans;
        $cpfxml = $empresa[0]->cpfxml;
        $cnpj = $empresa[0]->cnpj;
        $cnes = $empresa[0]->cnes;
        $convenio = $listarexame[0]->convenio;
        $versao = $_POST['xml'];
        $modelo = $_POST['modelo'];

        $limite = ($_POST['limite'] == '0') ? false : true;

        if ($_POST['tipo'] != 0) {
            $classificacao = $listarexame[0]->classificacao;
        } else {
            $classificacao = 'TODOS';
        }
        $_POST['datainicio'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
        $_POST['datafim'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));
        $datainicio = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
        $datafim = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));
        $nomearquivo = '035753bf836c231bedbc68a08daf4668';
        $nomearquivoconsulta = 'e2eadfe09fd6750a184902545aa41771';
        $origem = "./upload/cr/" . $convenio;

        if (!is_dir("./upload/cr/" . $convenio)) {
            mkdir("./upload/cr/" . $convenio);
            chmod($origem, 0777);
        }
        if ($_POST['apagar'] == 1) {
            delete_files($origem);
        }
        $i = 0;
        $totExames = 0;
        $b = $lote[0]->lote;
        $j = $b - 53;
        $zero = '0000000000000000';
        $corpo = "";
        if ($versao == '3.03.01') {
            if ($modelo == 'cpf') {

                if ($listarexame[0]->grupo != 'CONSULTA') {
                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
    <ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
       <ans:cabecalho>
          <ans:identificacaoTransacao>
             <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
             <ans:sequencialTransacao>" . $j . "</ans:sequencialTransacao>
             <ans:dataRegistroTransacao>" . $horario . "</ans:dataRegistroTransacao>
             <ans:horaRegistroTransacao>" . $hora . "</ans:horaRegistroTransacao>
          </ans:identificacaoTransacao>
          <ans:origem>
             <ans:identificacaoPrestador>
                <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
             </ans:identificacaoPrestador>
          </ans:origem>
          <ans:destino>
             <ans:registroANS>" . $registroans . "</ans:registroANS>
          </ans:destino>
          <ans:Padrao>" . $versao . "</ans:Padrao>
       </ans:cabecalho>
       
       <ans:prestadorParaOperadora>
          <ans:loteGuias>
             <ans:numeroLote>" . $b . "</ans:numeroLote>
                <ans:guiasTISS>";
                    $contador = count($listarpacienete);
                    foreach ($listarpacienete as $value) {

                        if ($value->guiaconvenio == '') {
                            $guianumero = '0000000';
                        } else {
                            $guianumero = $value->guiaconvenio;
                        }
                        if ($value->convenionumero == '') {
                            $numerodacarteira = '0000000';
                        } else {
                            $numerodacarteira = $value->convenionumero;
                        }

                        foreach ($listarexames as $item) {

                            if ($value->paciente_id == $item->paciente_id && $value->ambulatorio_guia_id == $item->ambulatorio_guia_id) {
                                $i++;
                                $totExames++;
                                $data_autorizacao = $this->exame->listarxmldataautorizacao($value->ambulatorio_guia_id);
                                $dataautorizacao = substr($data_autorizacao[0]->data_cadastro, 0, 10);
                                $dataValidadeSenha = date('Y-m-d', strtotime("+30 days", strtotime($dataautorizacao)));
                                if ($item->medico == '') {
                                    $medico = 'ADMINISTRADOR';
                                } else {
                                    $medico = $item->medico;
                                }
                                if ($item->conselho == '') {
                                    $conselho = '0000000';
                                } else {
                                    $conselho = $item->conselho;
                                }
                                if ($item->medicosolicitante == '') {
                                    $medicosolicitante = $item->medico;
                                } else {
                                    $medicosolicitante = $item->medicosolicitante;
                                }
                                if ($item->conselhosolicitante == '') {
                                    $conselhosolicitante = $item->conselho;
                                } else {
                                    $conselhosolicitante = $item->conselhosolicitante;
                                }


                                if ($_POST['autorizacao'] == 'SIM') {
                                    $corpo = $corpo . "
                    <ans:guiaSP-SADT>
                      <ans:cabecalhoGuia>
                         <ans:registroANS>" . $registroans . "</ans:registroANS>
                         <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                         <ans:guiaPrincipal>1</ans:guiaPrincipal>
                      </ans:cabecalhoGuia>
                      
                      <ans:dadosAutorizacao>
                        <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                        <ans:dataAutorizacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataAutorizacao>
                        <ans:senha>" . $item->autorizacao . "</ans:senha>
                        <ans:dataValidadeSenha>" . $dataValidadeSenha . "</ans:dataValidadeSenha> 
                      </ans:dadosAutorizacao>
                      
                      <ans:dadosBeneficiario>
                         <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                         <ans:atendimentoRN>S</ans:atendimentoRN>
                         <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                      </ans:dadosBeneficiario>
                      
                      <ans:dadosSolicitante>
                         <ans:contratadoSolicitante>
                            <ans:cpfContratado>" . $cpfxml . "</ans:cpfContratado>
                            <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoSolicitante>
                      
                        <ans:profissionalSolicitante>
                              <ans:nomeProfissional>" . $medicosolicitante . "</ans:nomeProfissional>
                              <ans:conselhoProfissional>06</ans:conselhoProfissional>
                              <ans:numeroConselhoProfissional >" . $conselhosolicitante . "</ans:numeroConselhoProfissional >
                              <ans:UF>" . $codigoUF . "</ans:UF>
                              <ans:CBOS>999999</ans:CBOS>
                        </ans:profissionalSolicitante>
                      
                      </ans:dadosSolicitante>
                      
                      <ans:dadosSolicitacao>
                         <ans:dataSolicitacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataSolicitacao>
                         <ans:caraterAtendimento>1</ans:caraterAtendimento>
                         <ans:indicacaoClinica>I</ans:indicacaoClinica>
                      </ans:dadosSolicitacao>
                      
                      <ans:dadosExecutante>
                            <ans:contratadoExecutante>
                            <ans:cpfContratado>" . $cpfxml . "</ans:cpfContratado>
                         <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoExecutante>
                         <ans:CNES>" . $cnes . "</ans:CNES>
                      </ans:dadosExecutante>
                      
                      <ans:dadosAtendimento>
                        <ans:tipoAtendimento>04</ans:tipoAtendimento>
                        <ans:indicacaoAcidente>0</ans:indicacaoAcidente>
                        <ans:tipoConsulta>1</ans:tipoConsulta>
                        <ans:motivoEncerramento>41</ans:motivoEncerramento>
                      </ans:dadosAtendimento>
                      
                      <ans:procedimentosExecutados>
                         <ans:procedimentoExecutado>
                                <ans:dataExecucao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataExecucao>
                                <ans:horaInicial>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaInicial>
                                <ans:horaFinal>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaFinal>
                                <ans:procedimento>
                                   <ans:codigoTabela>22</ans:codigoTabela>
                                   <ans:codigoProcedimento>" . $item->codigo . "</ans:codigoProcedimento>
                                   <ans:descricaoProcedimento >" . substr(utf8_decode($item->procedimento), 0, 60) . "</ans:descricaoProcedimento >
                               </ans:procedimento>                        
                               <ans:quantidadeExecutada>" . $item->quantidade . "</ans:quantidadeExecutada>
                                <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
                                <ans:valorUnitario >" . $item->valor . "</ans:valorUnitario >
                                <ans:valorTotal>" . $item->valor_total . "</ans:valorTotal>
                                <ans:equipeSadt>
                                    <ans:codProfissional>
                                        <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                                    </ans:codProfissional>
                                    <ans:nomeProf>" . $medico . "</ans:nomeProf>
                                    <ans:conselho>01</ans:conselho>
                                    <ans:numeroConselhoProfissional>$conselho</ans:numeroConselhoProfissional>
                                    <ans:UF>" . $codigoUF . "</ans:UF>
                                    <ans:CBOS>999999</ans:CBOS>
                                </ans:equipeSadt>
                      </ans:procedimentoExecutado>
                      </ans:procedimentosExecutados>
                      <ans:observacao>III</ans:observacao>
                         <ans:valorTotal >
                         <ans:valorProcedimentos >" . $item->valor_total . "</ans:valorProcedimentos >
                         <ans:valorDiarias>0.00</ans:valorDiarias>
                         <ans:valorTaxasAlugueis>0.00</ans:valorTaxasAlugueis>
                         <ans:valorMateriais>0.00</ans:valorMateriais>
                         <ans:valorMedicamentos>0.00</ans:valorMedicamentos>
                         <ans:valorOPME>0.00</ans:valorOPME>
                         <ans:valorGasesMedicinais>0.00</ans:valorGasesMedicinais>
                         <ans:valorTotalGeral>" . $item->valor_total . "</ans:valorTotalGeral>
                      </ans:valorTotal>
                      </ans:guiaSP-SADT>";
                                } else {
                                    $corpo = $corpo . "
                <ans:guiaSP-SADT>
                          <ans:cabecalhoGuia>
                            <ans:registroANS>" . $registroans . "</ans:registroANS>
                         <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                         <ans:guiaPrincipal>1</ans:guiaPrincipal>
                      </ans:cabecalhoGuia>
                      <ans:dadosAutorizacao>
                      <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                      <ans:dataAutorizacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataAutorizacao>
                      </ans:dadosAutorizacao>
                      <ans:dadosBeneficiario>
                         <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                             <ans:atendimentoRN>S</ans:atendimentoRN>
                         <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                      </ans:dadosBeneficiario>
                      
                      <ans:dadosSolicitante>
                         <ans:contratadoSolicitante>
                               <ans:cpfContratado>" . $cpfxml . "</ans:cpfContratado>
                               <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoSolicitante>
                         <ans:profissionalSolicitante>
                            <ans:nomeProfissional>" . $medicosolicitante . "</ans:nomeProfissional>
                            <ans:conselhoProfissional>06</ans:conselhoProfissional>
                            <ans:numeroConselhoProfissional >" . $conselhosolicitante . "</ans:numeroConselhoProfissional >
                            <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                         </ans:profissionalSolicitante>
                      </ans:dadosSolicitante>
                      
                      <ans:dadosSolicitacao>
                         <ans:dataSolicitacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataSolicitacao>
                         <ans:caraterAtendimento>1</ans:caraterAtendimento>
                         <ans:indicacaoClinica>I</ans:indicacaoClinica>
                      </ans:dadosSolicitacao>
                      
                      <ans:dadosExecutante>
                        <ans:contratadoExecutante>
                            <ans:cpfContratado>" . $cpfxml . "</ans:cpfContratado>
                            <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoExecutante>
                         <ans:CNES>" . $cnes . "</ans:CNES>
                      </ans:dadosExecutante>
                        
                      <ans:dadosAtendimento>
                        <ans:tipoAtendimento>04</ans:tipoAtendimento>
                        <ans:indicacaoAcidente>0</ans:indicacaoAcidente>
                        <ans:tipoConsulta>1</ans:tipoConsulta>
                        <ans:motivoEncerramento>41</ans:motivoEncerramento>
                      </ans:dadosAtendimento>
                      
                      <ans:procedimentosExecutados>
                         <ans:procedimentoExecutado>
                                <ans:dataExecucao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataExecucao>
                                <ans:horaInicial>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaInicial>
                                <ans:horaFinal>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaFinal>
                                <ans:procedimento>
                                    <ans:codigoTabela>22</ans:codigoTabela>
                                    <ans:codigoProcedimento>" . $item->codigo . "</ans:codigoProcedimento>
                                    <ans:descricaoProcedimento >" . substr(utf8_decode($item->procedimento), 0, 60) . "</ans:descricaoProcedimento >
                                </ans:procedimento>                        
                                <ans:quantidadeExecutada>" . $item->quantidade . "</ans:quantidadeExecutada>
                                <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
                                <ans:valorUnitario >" . $item->valor . "</ans:valorUnitario >
                                <ans:valorTotal>" . $item->valor_total . "</ans:valorTotal>
                                <ans:equipeSadt>
                                    <ans:codProfissional>
                                        <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                                    </ans:codProfissional>
                                    <ans:nomeProf>" . $medico . "</ans:nomeProf>
                                    <ans:conselho>01</ans:conselho>
                                    <ans:numeroConselhoProfissional>$conselho</ans:numeroConselhoProfissional>
                                    <ans:UF>" . $codigoUF . "</ans:UF>
                                    <ans:CBOS>999999</ans:CBOS>
                                </ans:equipeSadt>
                      </ans:procedimentoExecutado>
                    </ans:procedimentosExecutados>
                      <ans:observacao>III</ans:observacao>
                         <ans:valorTotal >
                         <ans:valorProcedimentos >" . $item->valor_total . "</ans:valorProcedimentos >
                         <ans:valorDiarias>0.00</ans:valorDiarias>
                         <ans:valorTaxasAlugueis>0.00</ans:valorTaxasAlugueis>
                         <ans:valorMateriais>0.00</ans:valorMateriais>
                         <ans:valorMedicamentos>0.00</ans:valorMedicamentos>
                         <ans:valorOPME>0.00</ans:valorOPME>
                         <ans:valorGasesMedicinais>0.00</ans:valorGasesMedicinais>
                         <ans:valorTotalGeral>" . $item->valor_total . "</ans:valorTotalGeral>
                      </ans:valorTotal>
                      </ans:guiaSP-SADT>";
                                }

                                if (!$limite) {
                                    if ($totExames == count($listarexames)) {
                                        $contador = $contador - $i;

                                        $i = 0;
                                        $rodape = "   </ans:guiasTISS>
          </ans:loteGuias>
       </ans:prestadorParaOperadora>
       <ans:epilogo>
          <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
       </ans:epilogo>
    </ans:mensagemTISS>";

                                        $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                        $xml = $cabecalho . $corpo . $rodape;
                                        $fp = fopen($nome, "w+");
                                        fwrite($fp, $xml . "\n");
                                        fclose($fp);
                                        $b++;
                                        $corpo = "";
                                        $rodape = "";
                                    }
                                } else {
                                    if ($i == 80) {
                                        $contador = $contador - $i;

                                        $i = 0;
                                        $rodape = "   </ans:guiasTISS>
          </ans:loteGuias>
       </ans:prestadorParaOperadora>
       <ans:epilogo>
          <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
       </ans:epilogo>
    </ans:mensagemTISS>";

                                        $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                        $xml = $cabecalho . $corpo . $rodape;
                                        $fp = fopen($nome, "w+");
                                        fwrite($fp, $xml . "\n");
                                        fclose($fp);
                                        $b++;
                                        $corpo = "";
                                        $rodape = "";
                                    }
                                    if ($contador < 80 && $contador == $i) {
                                        $i = 0;
                                        $rodape = "   </ans:guiasTISS>
          </ans:loteGuias>
       </ans:prestadorParaOperadora>
       <ans:epilogo>
          <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
       </ans:epilogo>
    </ans:mensagemTISS>";
                                        $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                        $xml = $cabecalho . $corpo . $rodape;
                                        $fp = fopen($nome, "w+");
                                        fwrite($fp, $xml . "\n");
                                        fclose($fp);
                                        $b++;
                                        $corpo = "";
                                        $rodape = "";
                                    }
                                }
                            }
                        }
                    }
                } else {

                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
    <ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
       <ans:cabecalho>
          <ans:identificacaoTransacao>
             <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
             <ans:sequencialTransacao>" . $j . "</ans:sequencialTransacao>
             <ans:dataRegistroTransacao>" . substr($listarexame[0]->data_autorizacao, 0, 10) . "</ans:dataRegistroTransacao>
             <ans:horaRegistroTransacao>" . $hora . "</ans:horaRegistroTransacao>
          </ans:identificacaoTransacao>
          <ans:origem>
             <ans:identificacaoPrestador>
                <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
             </ans:identificacaoPrestador>
          </ans:origem>
          <ans:destino>
             <ans:registroANS>" . $registroans . "</ans:registroANS>
          </ans:destino>
          <ans:Padrao>" . $versao . "</ans:Padrao>
       </ans:cabecalho>
       <ans:prestadorParaOperadora>
          <ans:loteGuias>
             <ans:numeroLote>" . $b . "</ans:numeroLote>
                <ans:guiasTISS>";
                    $contador = count($listarexame);
                    foreach ($listarexame as $value) {

                        if ($value->convenionumero == '') {
                            $numerodacarteira = '0000000';
                        } else {
                            $numerodacarteira = $value->convenionumero;
                        }
                        if ($value->medico == '') {
                            $medico = 'ADMINISTRADOR';
                        } else {
                            $medico = $value->medico;
                        }
                        if ($value->conselho == '') {
                            $conselho = '0000000';
                        } else {
                            $conselho = $value->conselho;
                        }
                        if ($value->guiaconvenio == '') {
                            $guianumero = '0000000';
                        } else {
                            $guianumero = $value->guiaconvenio;
                        }
                        $corpo = $corpo . "
                <ans:guiaConsulta>
                    <ans:cabecalhoConsulta>
                        <ans:registroANS>" . $registroans . "</ans:registroANS>
                        <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                    </ans:cabecalhoConsulta>
                    <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                    <ans:dadosBeneficiario>
                        <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                        <ans:atendimentoRN>N</ans:atendimentoRN>
                        <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                    </ans:dadosBeneficiario>
                    <ans:contratadoExecutante>
                        <ans:codigoPrestadorNaOperadora>" . $cpfxml . "</ans:codigoPrestadorNaOperadora>
                        <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                        <ans:CNES>" . $cnes . "</ans:CNES>
                    </ans:contratadoExecutante>
                    <ans:profissionalExecutante>
                        <ans:nomeProfissional>" . $medico . "</ans:nomeProfissional>
                        <ans:conselhoProfissional>06</ans:conselhoProfissional>
                        <ans:numeroConselhoProfissional>" . $conselho . "</ans:numeroConselhoProfissional>
                        <ans:UF>15</ans:UF>
                        <ans:CBOS>225120</ans:CBOS>
                    </ans:profissionalExecutante>
                    <ans:indicacaoAcidente>9</ans:indicacaoAcidente>
                    <ans:dadosAtendimento>
                        <ans:dataAtendimento>" . substr($value->data_autorizacao, 0, 10) . "</ans:dataAtendimento>
                        <ans:tipoConsulta>1</ans:tipoConsulta>
                        <ans:procedimento>
                            <ans:codigoTabela>22</ans:codigoTabela>
                            <ans:codigoProcedimento>" . $value->codigo . "</ans:codigoProcedimento>
                            <ans:valorProcedimento>" . $value->valor . "</ans:valorProcedimento>
                        </ans:procedimento>
                    </ans:dadosAtendimento>
                </ans:guiaConsulta>";
                        if (!$limite) {
                            if ($totExames == count($listarexames)) {
                                $contador = $contador - $i;
                                $b++;
                                $i = 0;
                                $rodape = "</ans:guiasTISS>
        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>";

                                $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                                $xml = $cabecalho . $corpo . $rodape;
                                $fp = fopen($nome, "w+");
                                fwrite($fp, $xml . "\n");
                                fclose($fp);
                                $corpo = "";
                                $rodape = "";
                            }
                        } else {
                            if ($i == 80) {
                                $contador = $contador - $i;
                                $b++;
                                $i = 0;
                                $rodape = "</ans:guiasTISS>
        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>";

                                $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                                $xml = $cabecalho . $corpo . $rodape;
                                $fp = fopen($nome, "w+");
                                fwrite($fp, $xml . "\n");
                                fclose($fp);
                                $corpo = "";
                                $rodape = "";
                            }
                            if ($contador < 80 && $contador == $i) {

                                $i = 0;
                                $rodape = "   </ans:guiasTISS>


        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>";
                                $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                                $xml = $cabecalho . $corpo . $rodape;
                                $fp = fopen($nome, "w+");
                                fwrite($fp, $xml . "\n");
                                fclose($fp);
                                $b++;
                                $corpo = "";
                                $rodape = "";
                            }
                        }
                    }
                }
            } else {

                if ($listarexame[0]->grupo != 'CONSULTA') {
                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
    <ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
       <ans:cabecalho>
          <ans:identificacaoTransacao>
             <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
             <ans:sequencialTransacao>" . $j . "</ans:sequencialTransacao>
             <ans:dataRegistroTransacao>" . substr($listarexame[0]->data_autorizacao, 0, 10) . "</ans:dataRegistroTransacao>
             <ans:horaRegistroTransacao>" . $hora . "</ans:horaRegistroTransacao>
          </ans:identificacaoTransacao>
          <ans:origem>
             <ans:identificacaoPrestador>
                <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
             </ans:identificacaoPrestador>
          </ans:origem>
          <ans:destino>
             <ans:registroANS>" . $registroans . "</ans:registroANS>
          </ans:destino>
          <ans:Padrao>" . $versao . "</ans:Padrao>
       </ans:cabecalho>
       <ans:prestadorParaOperadora>
          <ans:loteGuias>
             <ans:numeroLote>" . $b . "</ans:numeroLote>
                <ans:guiasTISS>";
                    $contador = count($listarpacienete);
                    foreach ($listarpacienete as $value) {

                        if ($value->guiaconvenio == '') {
                            $guianumero = '0000000';
                        } else {
                            $guianumero = $value->guiaconvenio;
                        }
                        if ($value->convenionumero == '') {
                            $numerodacarteira = '0000000';
                        } else {
                            $numerodacarteira = $value->convenionumero;
                        }

                        foreach ($listarexames as $item) {
                            if ($value->paciente_id == $item->paciente_id && $value->ambulatorio_guia_id == $item->ambulatorio_guia_id) {
                                $i++;
                                $totExames++;
                                $data_autorizacao = $this->exame->listarxmldataautorizacao($value->ambulatorio_guia_id);
                                $dataautorizacao = substr($data_autorizacao[0]->data_cadastro, 0, 10);
                                $dataValidadeSenha = date('Y-m-d', strtotime("+30 days", strtotime($dataautorizacao)));
                                if ($item->medico == '') {
                                    $medico = 'ADMINISTRADOR';
                                } else {
                                    $medico = $item->medico;
                                }
                                if ($item->conselho == '') {
                                    $conselho = '0000000';
                                } else {
                                    $conselho = $item->conselho;
                                }
                                if ($item->medicosolicitante == '') {
                                    $medicosolicitante = $item->medico;
                                } else {
                                    $medicosolicitante = $item->medicosolicitante;
                                }
                                if ($item->conselhosolicitante == '') {
                                    $conselhosolicitante = $item->conselho;
                                } else {
                                    $conselhosolicitante = $item->conselhosolicitante;
                                }

                                if ($_POST['autorizacao'] == 'SIM') {
                                    $corpo = $corpo . "
                                                          <ans:guiaSP-SADT>
                          <ans:cabecalhoGuia>
                            <ans:registroANS>" . $registroans . "</ans:registroANS>
                         <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                         <ans:guiaPrincipal>1</ans:guiaPrincipal>
                      </ans:cabecalhoGuia>
                      <ans:dadosAutorizacao>
                      <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                      <ans:dataAutorizacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataAutorizacao>
                      <ans:senha>" . $item->autorizacao . "</ans:senha>
                      <ans:dataValidadeSenha>" . $dataValidadeSenha . "</ans:dataValidadeSenha> 
                      </ans:dadosAutorizacao>
                      <ans:dadosBeneficiario>
                         <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                             <ans:atendimentoRN>S</ans:atendimentoRN>
                         <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                      </ans:dadosBeneficiario>
                                                      <ans:dadosSolicitante>
                         <ans:contratadoSolicitante>
                               <ans:cnpjContratado>" . $cnpj . "</ans:cnpjContratado>
                            <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoSolicitante>
                         <ans:profissionalSolicitante>
                            <ans:nomeProfissional>" . $medicosolicitante . "</ans:nomeProfissional>
                            <ans:conselhoProfissional>06</ans:conselhoProfissional>
                            <ans:numeroConselhoProfissional >" . $conselhosolicitante . "</ans:numeroConselhoProfissional >
                                <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                         </ans:profissionalSolicitante>
                      </ans:dadosSolicitante>
                      <ans:dadosSolicitacao>
                         <ans:dataSolicitacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataSolicitacao>
                         <ans:caraterAtendimento>1</ans:caraterAtendimento>
                         <ans:indicacaoClinica>I</ans:indicacaoClinica>
                      </ans:dadosSolicitacao>
                      <ans:dadosExecutante>
                            <ans:contratadoExecutante>
                            <ans:cnpjContratado>" . $cnpj . "</ans:cnpjContratado>
                         <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoExecutante>
                         <ans:CNES>" . $cnes . "</ans:CNES>
                      </ans:dadosExecutante>
                      <ans:dadosAtendimento>
                      <ans:tipoAtendimento>04</ans:tipoAtendimento>
                      <ans:indicacaoAcidente>0</ans:indicacaoAcidente>
                      <ans:tipoConsulta>1</ans:tipoConsulta>
                      <ans:motivoEncerramento>41</ans:motivoEncerramento>
                      </ans:dadosAtendimento>
                      <ans:procedimentosExecutados>
                         <ans:procedimentoExecutado>
                                <ans:dataExecucao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataExecucao>
                                <ans:horaInicial>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaInicial>
                                <ans:horaFinal>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaFinal>
                                <ans:procedimento>
                                <ans:codigoTabela>22</ans:codigoTabela>
                               <ans:codigoProcedimento>" . $item->codigo . "</ans:codigoProcedimento>
                               <ans:descricaoProcedimento >" . substr(utf8_decode($item->procedimento), 0, 60) . "</ans:descricaoProcedimento >
                               </ans:procedimento>                        
                        <ans:quantidadeExecutada>" . $item->quantidade . "</ans:quantidadeExecutada>
                            <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
                            <ans:valorUnitario >" . $item->valor . "</ans:valorUnitario >
                            <ans:valorTotal>" . $item->valor_total . "</ans:valorTotal>
                            <ans:equipeSadt>
                            <ans:codProfissional>
                            <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                            </ans:codProfissional>
                            <ans:nomeProf>" . $medico . "</ans:nomeProf>
                            <ans:conselho>01</ans:conselho>
                            <ans:numeroConselhoProfissional>$conselho</ans:numeroConselhoProfissional>
                            <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                            </ans:equipeSadt>
                      </ans:procedimentoExecutado>
                      </ans:procedimentosExecutados>
                      <ans:observacao>III</ans:observacao>
                         <ans:valorTotal >
                         <ans:valorProcedimentos >" . $item->valor_total . "</ans:valorProcedimentos >
                         <ans:valorDiarias>0.00</ans:valorDiarias>
                         <ans:valorTaxasAlugueis>0.00</ans:valorTaxasAlugueis>
                         <ans:valorMateriais>0.00</ans:valorMateriais>
                         <ans:valorMedicamentos>0.00</ans:valorMedicamentos>
                         <ans:valorOPME>0.00</ans:valorOPME>
                         <ans:valorGasesMedicinais>0.00</ans:valorGasesMedicinais>
                         <ans:valorTotalGeral>" . $item->valor_total . "</ans:valorTotalGeral>
                      </ans:valorTotal>
                      </ans:guiaSP-SADT>";
                                } else {
                                    $corpo = $corpo . "
                                                          <ans:guiaSP-SADT>
                          <ans:cabecalhoGuia>
                            <ans:registroANS>" . $registroans . "</ans:registroANS>
                         <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                         <ans:guiaPrincipal>1</ans:guiaPrincipal>
                      </ans:cabecalhoGuia>
                      <ans:dadosAutorizacao>
                      <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                      <ans:dataAutorizacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataAutorizacao>
                      </ans:dadosAutorizacao>
                      <ans:dadosBeneficiario>
                         <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                             <ans:atendimentoRN>S</ans:atendimentoRN>
                         <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                      </ans:dadosBeneficiario>
                                                      <ans:dadosSolicitante>
                         <ans:contratadoSolicitante>
                               <ans:cnpjContratado>" . $cnpj . "</ans:cnpjContratado>
                            <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoSolicitante>
                         <ans:profissionalSolicitante>
                            <ans:nomeProfissional>" . $medicosolicitante . "</ans:nomeProfissional>
                            <ans:conselhoProfissional>06</ans:conselhoProfissional>
                            <ans:numeroConselhoProfissional >" . $conselhosolicitante . "</ans:numeroConselhoProfissional >
                                <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                         </ans:profissionalSolicitante>
                      </ans:dadosSolicitante>
                      <ans:dadosSolicitacao>
                         <ans:dataSolicitacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataSolicitacao>
                         <ans:caraterAtendimento>1</ans:caraterAtendimento>
                         <ans:indicacaoClinica>I</ans:indicacaoClinica>
                      </ans:dadosSolicitacao>
                      <ans:dadosExecutante>
                            <ans:contratadoExecutante>
                            <ans:cnpjContratado>" . $cnpj . "</ans:cnpjContratado>
                         <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoExecutante>
                         <ans:CNES>" . $cnes . "</ans:CNES>
                      </ans:dadosExecutante>
                      <ans:dadosAtendimento>
                      <ans:tipoAtendimento>04</ans:tipoAtendimento>
                      <ans:indicacaoAcidente>0</ans:indicacaoAcidente>
                      <ans:tipoConsulta>1</ans:tipoConsulta>
                      <ans:motivoEncerramento>41</ans:motivoEncerramento>
                      </ans:dadosAtendimento>
                      <ans:procedimentosExecutados>
                         <ans:procedimentoExecutado>
                                <ans:dataExecucao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataExecucao>
                                <ans:horaInicial>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaInicial>
                                <ans:horaFinal>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaFinal>
                                <ans:procedimento>
                                <ans:codigoTabela>22</ans:codigoTabela>
                               <ans:codigoProcedimento>" . $item->codigo . "</ans:codigoProcedimento>
                               <ans:descricaoProcedimento >" . substr(utf8_decode($item->procedimento), 0, 60) . "</ans:descricaoProcedimento >
                               </ans:procedimento>                        
                        <ans:quantidadeExecutada>" . $item->quantidade . "</ans:quantidadeExecutada>
                            <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
                            <ans:valorUnitario >" . $item->valor . "</ans:valorUnitario >
                            <ans:valorTotal>" . $item->valor_total . "</ans:valorTotal>
                            <ans:equipeSadt>
                            <ans:codProfissional>
                            <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                            </ans:codProfissional>
                            <ans:nomeProf>" . $medico . "</ans:nomeProf>
                            <ans:conselho>01</ans:conselho>
                            <ans:numeroConselhoProfissional>$conselho</ans:numeroConselhoProfissional>
                            <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                            </ans:equipeSadt>
                      </ans:procedimentoExecutado>
                      </ans:procedimentosExecutados>
                      <ans:observacao>III</ans:observacao>
                         <ans:valorTotal >
                         <ans:valorProcedimentos >" . $item->valor_total . "</ans:valorProcedimentos >
                         <ans:valorDiarias>0.00</ans:valorDiarias>
                         <ans:valorTaxasAlugueis>0.00</ans:valorTaxasAlugueis>
                         <ans:valorMateriais>0.00</ans:valorMateriais>
                         <ans:valorMedicamentos>0.00</ans:valorMedicamentos>
                         <ans:valorOPME>0.00</ans:valorOPME>
                         <ans:valorGasesMedicinais>0.00</ans:valorGasesMedicinais>
                         <ans:valorTotalGeral>" . $item->valor_total . "</ans:valorTotalGeral>
                      </ans:valorTotal>
                      </ans:guiaSP-SADT>";
                                }
                                if (!$limite) {
                                    if ($totExames == count($listarexames)) {
                                        $contador = $contador - $i;
                                        $b++;
                                        $i = 0;
                                        $rodape = "</ans:guiasTISS>
        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>";

                                        $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                                        $xml = $cabecalho . $corpo . $rodape;
                                        $fp = fopen($nome, "w+");
                                        fwrite($fp, $xml . "\n");
                                        fclose($fp);
                                        $corpo = "";
                                        $rodape = "";
                                    }
                                } else {

                                    if ($i == 80) {
                                        $contador = $contador - $i;

                                        $i = 0;
                                        $rodape = "   </ans:guiasTISS>

          </ans:loteGuias>
       </ans:prestadorParaOperadora>
       <ans:epilogo>
          <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
       </ans:epilogo>
    </ans:mensagemTISS>
    ";

                                        $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                        $xml = $cabecalho . $corpo . $rodape;
                                        $fp = fopen($nome, "w+");
                                        fwrite($fp, $xml . "\n");
                                        fclose($fp);
                                        $b++;
                                        $corpo = "";
                                        $rodape = "";
                                    }

                                    if ($contador < 80 && $contador == $i) {
                                        $i = 0;
                                        $rodape = "   </ans:guiasTISS>

          </ans:loteGuias>
       </ans:prestadorParaOperadora>
       <ans:epilogo>
          <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
       </ans:epilogo>
    </ans:mensagemTISS>
    ";
                                        $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                        $xml = $cabecalho . $corpo . $rodape;
                                        $fp = fopen($nome, "w+");
                                        fwrite($fp, $xml . "\n");
                                        fclose($fp);
                                        $b++;
                                        $corpo = "";
                                        $rodape = "";
                                    }
                                }
                            }
                        }
                    }
                } else {

                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
    <ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
       <ans:cabecalho>
          <ans:identificacaoTransacao>
             <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
             <ans:sequencialTransacao>" . $j . "</ans:sequencialTransacao>
             <ans:dataRegistroTransacao>" . substr($listarexame[0]->data_autorizacao, 0, 10) . "</ans:dataRegistroTransacao>
             <ans:horaRegistroTransacao>" . $hora . "</ans:horaRegistroTransacao>
          </ans:identificacaoTransacao>
          <ans:origem>
             <ans:identificacaoPrestador>
                <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
             </ans:identificacaoPrestador>
          </ans:origem>
          <ans:destino>
             <ans:registroANS>" . $registroans . "</ans:registroANS>
          </ans:destino>
          <ans:Padrao>" . $versao . "</ans:Padrao>
       </ans:cabecalho>
       <ans:prestadorParaOperadora>
          <ans:loteGuias>
             <ans:numeroLote>" . $b . "</ans:numeroLote>
                <ans:guiasTISS>";
                    $contador = count($listarexame);

                    foreach ($listarexame as $value) {
                        $i++;
                        $totExames++;
                        if ($value->convenionumero == '') {
                            $numerodacarteira = '0000000';
                        } else {
                            $numerodacarteira = $value->convenionumero;
                        }
                        if ($value->medico == '') {
                            $medico = 'ADMINISTRADOR';
                        } else {
                            $medico = $value->medico;
                        }
                        if ($value->conselho == '') {
                            $conselho = '0000000';
                        } else {
                            $conselho = $value->conselho;
                        }
                        if ($value->guiaconvenio == '') {
                            $guianumero = '0000000';
                        } else {
                            $guianumero = $value->guiaconvenio;
                        }
                        $corpo = $corpo . "
                <ans:guiaConsulta>
                    <ans:cabecalhoConsulta>
                        <ans:registroANS>" . $registroans . "</ans:registroANS>
                        <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                    </ans:cabecalhoConsulta>
                    <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                    <ans:dadosBeneficiario>
                        <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                        <ans:atendimentoRN>N</ans:atendimentoRN>
                        <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                    </ans:dadosBeneficiario>
                    <ans:contratadoExecutante>
                        <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                        <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                        <ans:CNES>" . $cnes . "</ans:CNES>
                    </ans:contratadoExecutante>
                    <ans:profissionalExecutante>
                        <ans:nomeProfissional>" . $medico . "</ans:nomeProfissional>
                        <ans:conselhoProfissional>06</ans:conselhoProfissional>
                        <ans:numeroConselhoProfissional>" . $conselho . "</ans:numeroConselhoProfissional>
                        <ans:UF>15</ans:UF>
                        <ans:CBOS>225120</ans:CBOS>
                    </ans:profissionalExecutante>
                    <ans:indicacaoAcidente>9</ans:indicacaoAcidente>
                    <ans:dadosAtendimento>
                        <ans:dataAtendimento>" . substr($value->data_autorizacao, 0, 10) . "</ans:dataAtendimento>
                        <ans:tipoConsulta>1</ans:tipoConsulta>
                        <ans:procedimento>
                            <ans:codigoTabela>22</ans:codigoTabela>
                            <ans:codigoProcedimento>" . $value->codigo . "</ans:codigoProcedimento>
                            <ans:valorProcedimento>" . $value->valor . "</ans:valorProcedimento>
                        </ans:procedimento>
                    </ans:dadosAtendimento>
                </ans:guiaConsulta>";

                        if (!$limite) {
                            if ($totExames == count($listarexames)) {
                                $contador = $contador - $i;
                                $b++;
                                $i = 0;
                                $rodape = "</ans:guiasTISS>
        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>";

                                $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                                $xml = $cabecalho . $corpo . $rodape;
                                $fp = fopen($nome, "w+");
                                fwrite($fp, $xml . "\n");
                                fclose($fp);
                                $corpo = "";
                                $rodape = "";
                            }
                        } else {
                            if ($i == 80) {
                                $contador = $contador - $i;
                                $i = 0;
                                $rodape = "</ans:guiasTISS>
        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>
    ";

                                $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                                $xml = $cabecalho . $corpo . $rodape;
                                $fp = fopen($nome, "w+");
                                fwrite($fp, $xml . "\n");
                                fclose($fp);
                                $b++;
                                $corpo = "";
                                $rodape = "";
                            }
                            if ($contador < 80 && $contador == $i) {
                                $i = 0;
                                $rodape = "   </ans:guiasTISS>


        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>
    ";
                                $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                                $xml = $cabecalho . $corpo . $rodape;
                                $fp = fopen($nome, "w+");
                                fwrite($fp, $xml . "\n");
                                fclose($fp);
                                $b++;
                                $corpo = "";
                                $rodape = "";
                            }
                        }
                    }
                }
            }
        }

        //VERSÃO ANTIGA DO XML
        else {
            if ($modelo == 'cpf') {

                if ($listarexame[0]->grupo != 'CONSULTA') {

                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
    <ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
       <ans:cabecalho>
          <ans:identificacaoTransacao>
             <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
             <ans:sequencialTransacao>" . $j . "</ans:sequencialTransacao>
             <ans:dataRegistroTransacao>" . $horario . "</ans:dataRegistroTransacao>
             <ans:horaRegistroTransacao>18:40:50</ans:horaRegistroTransacao>
          </ans:identificacaoTransacao>
          <ans:origem>
             <ans:identificacaoPrestador>
                <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
             </ans:identificacaoPrestador>
          </ans:origem>
          <ans:destino>
             <ans:registroANS>" . $registroans . "</ans:registroANS>
          </ans:destino>
          <ans:versaoPadrao>" . $versao . "</ans:versaoPadrao>
       </ans:cabecalho>
       <ans:prestadorParaOperadora>
          <ans:loteGuias>
             <ans:numeroLote>" . $b . "</ans:numeroLote>
                <ans:guiasTISS>";
                    $contador = count($listarpacienete);
                    foreach ($listarpacienete as $value) {

                        if ($value->guiaconvenio == '') {
                            $guianumero = '0000000';
                        } else {
                            $guianumero = $value->guiaconvenio;
                        }
                        if ($value->convenionumero == '') {
                            $numerodacarteira = '0000000';
                        } else {
                            $numerodacarteira = $value->convenionumero;
                        }

                        foreach ($listarexames as $item) {

                            if ($value->paciente_id == $item->paciente_id && $value->ambulatorio_guia_id == $item->ambulatorio_guia_id) {
                                $i++;
                                $data_autorizacao = $this->exame->listarxmldataautorizacao($value->ambulatorio_guia_id);
                                $dataautorizacao = substr($data_autorizacao[0]->data_cadastro, 0, 10);
                                $dataValidadeSenha = date('Y-m-d', strtotime("+30 days", strtotime($dataautorizacao)));
                                if ($item->medico == '') {
                                    $medico = 'ADMINISTRADOR';
                                } else {
                                    $medico = $item->medico;
                                }
                                if ($item->conselho == '') {
                                    $conselho = '0000000';
                                } else {
                                    $conselho = $item->conselho;
                                }
                                if ($item->medicosolicitante == '') {
                                    $medicosolicitante = $item->medico;
                                } else {
                                    $medicosolicitante = $item->medicosolicitante;
                                }
                                if ($item->conselhosolicitante == '') {
                                    $conselhosolicitante = $item->conselho;
                                } else {
                                    $conselhosolicitante = $item->conselhosolicitante;
                                }


                                if ($_POST['autorizacao'] == 'SIM') {
                                    $corpo = $corpo . "
                                                          <ans:guiaSP-SADT>
                          <ans:cabecalhoGuia>
                            <ans:registroANS>" . $registroans . "</ans:registroANS>
                         <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                         <ans:guiaPrincipal>1</ans:guiaPrincipal>
                      </ans:cabecalhoGuia>
                      <ans:dadosAutorizacao>
                      <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                      <ans:dataAutorizacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataAutorizacao>
                      <ans:senha>" . $item->autorizacao . "</ans:senha>
                      <ans:dataValidadeSenha>" . $dataValidadeSenha . "</ans:dataValidadeSenha> 
                      </ans:dadosAutorizacao>
                      <ans:dadosBeneficiario>
                         <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                             <ans:atendimentoRN>S</ans:atendimentoRN>
                         <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                      </ans:dadosBeneficiario>
                                                      <ans:dadosSolicitante>
                         <ans:contratadoSolicitante>
                               <ans:cpfContratado>" . $cpfxml . "</ans:cpfContratado>
                            <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoSolicitante>
                         <ans:profissionalSolicitante>
                            <ans:nomeProfissional>" . $medicosolicitante . "</ans:nomeProfissional>
                            <ans:conselhoProfissional>6</ans:conselhoProfissional>
                            <ans:numeroConselhoProfissional >" . $conselhosolicitante . "</ans:numeroConselhoProfissional >
                                <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                         </ans:profissionalSolicitante>
                      </ans:dadosSolicitante>
                      <ans:dadosSolicitacao>
                         <ans:dataSolicitacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataSolicitacao>
                         <ans:caraterAtendimento>1</ans:caraterAtendimento>
                         <ans:indicacaoClinica>I</ans:indicacaoClinica>
                      </ans:dadosSolicitacao>
                      <ans:dadosExecutante>
                            <ans:contratadoExecutante>
                            <ans:cpfContratado>" . $cpfxml . "</ans:cpfContratado>
                         <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoExecutante>
                         <ans:CNES>" . $cnes . "</ans:CNES>
                      </ans:dadosExecutante>
                      <ans:dadosAtendimento>
                      <ans:tipoAtendimento>04</ans:tipoAtendimento>
                      <ans:indicacaoAcidente>0</ans:indicacaoAcidente>
                      <ans:tipoConsulta>1</ans:tipoConsulta>
                      <ans:motivoEncerramento>41</ans:motivoEncerramento>
                      </ans:dadosAtendimento>
                      <ans:procedimentosExecutados>
                         <ans:procedimentoExecutado>
                                <ans:dataExecucao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataExecucao>
                                <ans:horaInicial>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaInicial>
                                <ans:horaFinal>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaFinal>
                                <ans:procedimento>
                                <ans:codigoTabela>22</ans:codigoTabela>
                               <ans:codigoProcedimento>" . $item->codigo . "</ans:codigoProcedimento>
                               <ans:descricaoProcedimento >" . substr(utf8_decode($item->procedimento), 0, 60) . "</ans:descricaoProcedimento >
                               </ans:procedimento>                        
                        <ans:quantidadeExecutada>" . $item->quantidade . "</ans:quantidadeExecutada>
                            <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
                            <ans:valorUnitario >" . $item->valor . "</ans:valorUnitario >
                            <ans:valorTotal>" . $item->valor_total . "</ans:valorTotal>
                            <ans:equipeSadt>
                            <ans:codProfissional>
                            <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                            </ans:codProfissional>
                            <ans:nomeProf>" . $medico . "</ans:nomeProf>
                            <ans:conselho>1</ans:conselho>
                            <ans:numeroConselhoProfissional>$conselho</ans:numeroConselhoProfissional>
                            <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                            </ans:equipeSadt>
                      </ans:procedimentoExecutado>
                      </ans:procedimentosExecutados>
                      <ans:observacao>III</ans:observacao>
                         <ans:valorTotal >
                         <ans:valorProcedimentos >" . $item->valor_total . "</ans:valorProcedimentos >
                         <ans:valorDiarias>0.00</ans:valorDiarias>
                         <ans:valorTaxasAlugueis>0.00</ans:valorTaxasAlugueis>
                         <ans:valorMateriais>0.00</ans:valorMateriais>
                         <ans:valorMedicamentos>0.00</ans:valorMedicamentos>
                         <ans:valorOPME>0.00</ans:valorOPME>
                         <ans:valorGasesMedicinais>0.00</ans:valorGasesMedicinais>
                         <ans:valorTotalGeral>" . $item->valor_total . "</ans:valorTotalGeral>
                      </ans:valorTotal>
                      </ans:guiaSP-SADT>";
                                } else {
                                    $corpo = $corpo . "
                                                          <ans:guiaSP-SADT>
                          <ans:cabecalhoGuia>
                            <ans:registroANS>" . $registroans . "</ans:registroANS>
                         <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                         <ans:guiaPrincipal>1</ans:guiaPrincipal>
                      </ans:cabecalhoGuia>
                      <ans:dadosAutorizacao>
                      <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                      <ans:dataAutorizacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataAutorizacao>
                      </ans:dadosAutorizacao>
                      <ans:dadosBeneficiario>
                         <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                             <ans:atendimentoRN>S</ans:atendimentoRN>
                         <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                      </ans:dadosBeneficiario>
                                                      <ans:dadosSolicitante>
                         <ans:contratadoSolicitante>
                               <ans:cpfContratado>" . $cpfxml . "</ans:cpfContratado>
                            <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoSolicitante>
                         <ans:profissionalSolicitante>
                            <ans:nomeProfissional>" . $medicosolicitante . "</ans:nomeProfissional>
                            <ans:conselhoProfissional>6</ans:conselhoProfissional>
                            <ans:numeroConselhoProfissional >" . $conselhosolicitante . "</ans:numeroConselhoProfissional >
                                <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                         </ans:profissionalSolicitante>
                      </ans:dadosSolicitante>
                      <ans:dadosSolicitacao>
                         <ans:dataSolicitacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataSolicitacao>
                         <ans:caraterAtendimento>1</ans:caraterAtendimento>
                         <ans:indicacaoClinica>I</ans:indicacaoClinica>
                      </ans:dadosSolicitacao>
                      <ans:dadosExecutante>
                            <ans:contratadoExecutante>
                            <ans:cpfContratado>" . $cpfxml . "</ans:cpfContratado>
                         <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                         </ans:contratadoExecutante>
                         <ans:CNES>" . $cnes . "</ans:CNES>
                      </ans:dadosExecutante>
                      <ans:dadosAtendimento>
                      <ans:tipoAtendimento>04</ans:tipoAtendimento>
                      <ans:indicacaoAcidente>0</ans:indicacaoAcidente>
                      <ans:tipoConsulta>1</ans:tipoConsulta>
                      <ans:motivoEncerramento>41</ans:motivoEncerramento>
                      </ans:dadosAtendimento>
                      <ans:procedimentosExecutados>
                         <ans:procedimentoExecutado>
                                <ans:dataExecucao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataExecucao>
                                <ans:horaInicial>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaInicial>
                                <ans:horaFinal>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaFinal>
                                <ans:procedimento>
                                <ans:codigoTabela>22</ans:codigoTabela>
                               <ans:codigoProcedimento>" . $item->codigo . "</ans:codigoProcedimento>
                               <ans:descricaoProcedimento >" . substr(utf8_decode($item->procedimento), 0, 60) . "</ans:descricaoProcedimento >
                               </ans:procedimento>                        
                        <ans:quantidadeExecutada>" . $item->quantidade . "</ans:quantidadeExecutada>
                            <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
                            <ans:valorUnitario >" . $item->valor . "</ans:valorUnitario >
                            <ans:valorTotal>" . $item->valor_total . "</ans:valorTotal>
                            <ans:equipeSadt>
                            <ans:codProfissional>
                            <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                            </ans:codProfissional>
                            <ans:nomeProf>" . $medico . "</ans:nomeProf>
                            <ans:conselho>1</ans:conselho>
                            <ans:numeroConselhoProfissional>$conselho</ans:numeroConselhoProfissional>
                            <ans:UF>" . $codigoUF . "</ans:UF>
                            <ans:CBOS>999999</ans:CBOS>
                            </ans:equipeSadt>
                      </ans:procedimentoExecutado>
                      </ans:procedimentosExecutados>
                      <ans:observacao>III</ans:observacao>
                         <ans:valorTotal >
                         <ans:valorProcedimentos >" . $item->valor_total . "</ans:valorProcedimentos >
                         <ans:valorDiarias>0.00</ans:valorDiarias>
                         <ans:valorTaxasAlugueis>0.00</ans:valorTaxasAlugueis>
                         <ans:valorMateriais>0.00</ans:valorMateriais>
                         <ans:valorMedicamentos>0.00</ans:valorMedicamentos>
                         <ans:valorOPME>0.00</ans:valorOPME>
                         <ans:valorGasesMedicinais>0.00</ans:valorGasesMedicinais>
                         <ans:valorTotalGeral>" . $item->valor_total . "</ans:valorTotalGeral>
                      </ans:valorTotal>
                      </ans:guiaSP-SADT>";
                                }

                                if ($i == 80) {
                                    $contador = $contador - $i;

                                    $i = 0;
                                    $rodape = "   </ans:guiasTISS>
          </ans:loteGuias>
       </ans:prestadorParaOperadora>
       <ans:epilogo>
          <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
       </ans:epilogo>
    </ans:mensagemTISS>";

                                    $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                    $xml = $cabecalho . $corpo . $rodape;
                                    $fp = fopen($nome, "w+");
                                    fwrite($fp, $xml . "\n");
                                    fclose($fp);
                                    $b++;
                                    $corpo = "";
                                    $rodape = "";
                                }
                                if ($contador < 80 && $contador == $i) {
                                    $i = 0;
                                    $rodape = "   </ans:guiasTISS>
          </ans:loteGuias>
       </ans:prestadorParaOperadora>
       <ans:epilogo>
          <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
       </ans:epilogo>
    </ans:mensagemTISS>";
                                    $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                    $xml = $cabecalho . $corpo . $rodape;
                                    $fp = fopen($nome, "w+");
                                    fwrite($fp, $xml . "\n");
                                    fclose($fp);
                                    $b++;
                                    $corpo = "";
                                    $rodape = "";
                                }
                            }
                        }
                    }
                } else {


                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
    <ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
       <ans:cabecalho>
          <ans:identificacaoTransacao>
             <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
             <ans:sequencialTransacao>" . $j . "</ans:sequencialTransacao>
             <ans:dataRegistroTransacao>" . substr($listarexame[0]->data_autorizacao, 0, 10) . "</ans:dataRegistroTransacao>
             <ans:horaRegistroTransacao>18:40:50</ans:horaRegistroTransacao>
          </ans:identificacaoTransacao>
          <ans:origem>
             <ans:identificacaoPrestador>
                <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
             </ans:identificacaoPrestador>
          </ans:origem>
          <ans:destino>
             <ans:registroANS>" . $registroans . "</ans:registroANS>
          </ans:destino>
          <ans:versaoPadrao>" . $versao . "</ans:versaoPadrao>
       </ans:cabecalho>
       <ans:prestadorParaOperadora>
          <ans:loteGuias>
             <ans:numeroLote>" . $b . "</ans:numeroLote>
                <ans:guiasTISS>";
                    $contador = count($listarexame);
                    foreach ($listarexame as $value) {

                        if ($value->convenionumero == '') {
                            $numerodacarteira = '0000000';
                        } else {
                            $numerodacarteira = $value->convenionumero;
                        }
                        if ($value->medico == '') {
                            $medico = 'ADMINISTRADOR';
                        } else {
                            $medico = $value->medico;
                        }
                        if ($value->conselho == '') {
                            $conselho = '0000000';
                        } else {
                            $conselho = $value->conselho;
                        }
                        if ($value->guiaconvenio == '') {
                            $guianumero = '0000000';
                        } else {
                            $guianumero = $value->guiaconvenio;
                        }
                        $corpo = $corpo . "
                <ans:guiaConsulta>
                    <ans:cabecalhoConsulta>
                        <ans:registroANS>" . $registroans . "</ans:registroANS>
                        <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                    </ans:cabecalhoConsulta>
                    <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                    <ans:dadosBeneficiario>
                        <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                        <ans:atendimentoRN>N</ans:atendimentoRN>
                        <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                    </ans:dadosBeneficiario>
                    <ans:contratadoExecutante>
                        <ans:codigoPrestadorNaOperadora>" . $cpfxml . "</ans:codigoPrestadorNaOperadora>
                        <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                        <ans:CNES>" . $cnes . "</ans:CNES>
                    </ans:contratadoExecutante>
                    <ans:profissionalExecutante>
                        <ans:nomeProfissional>" . $medico . "</ans:nomeProfissional>
                        <ans:conselhoProfissional>6</ans:conselhoProfissional>
                        <ans:numeroConselhoProfissional>" . $conselho . "</ans:numeroConselhoProfissional>
                        <ans:UF>15</ans:UF>
                        <ans:CBOS>225120</ans:CBOS>
                    </ans:profissionalExecutante>
                    <ans:indicacaoAcidente>9</ans:indicacaoAcidente>
                    <ans:dadosAtendimento>
                        <ans:dataAtendimento>" . substr($value->data_autorizacao, 0, 10) . "</ans:dataAtendimento>
                        <ans:tipoConsulta>1</ans:tipoConsulta>
                        <ans:procedimento>
                            <ans:codigoTabela>22</ans:codigoTabela>
                            <ans:codigoProcedimento>" . $value->codigo . "</ans:codigoProcedimento>
                            <ans:valorProcedimento>" . $value->valor . "</ans:valorProcedimento>
                        </ans:procedimento>
                    </ans:dadosAtendimento>
                </ans:guiaConsulta>";
                        if ($i == 80) {
                            $contador = $contador - $i;
                            $b++;
                            $i = 0;
                            $rodape = "</ans:guiasTISS>
        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>";

                            $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                            $xml = $cabecalho . $corpo . $rodape;
                            $fp = fopen($nome, "w+");
                            fwrite($fp, $xml . "\n");
                            fclose($fp);
                            $corpo = "";
                            $rodape = "";
                        }
                        if ($contador < 80 && $contador == $i) {

                            $i = 0;
                            $rodape = "   </ans:guiasTISS>


        </ans:loteGuias>
    </ans:prestadorParaOperadora>
    <ans:epilogo>
    <ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
    </ans:epilogo>
    </ans:mensagemTISS>";
                            $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                            $xml = $cabecalho . $corpo . $rodape;
                            $fp = fopen($nome, "w+");
                            fwrite($fp, $xml . "\n");
                            fclose($fp);
                            $b++;
                            $corpo = "";
                            $rodape = "";
                        }
                    }
                }
            } else {

                if ($listarexame[0]->grupo != 'CONSULTA') {
                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
<ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
   <ans:cabecalho>
      <ans:identificacaoTransacao>
         <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
         <ans:sequencialTransacao>" . $j . "</ans:sequencialTransacao>
         <ans:dataRegistroTransacao>" . substr($listarexame[0]->data_autorizacao, 0, 10) . "</ans:dataRegistroTransacao>
         <ans:horaRegistroTransacao>18:40:50</ans:horaRegistroTransacao>
      </ans:identificacaoTransacao>
      <ans:origem>
         <ans:identificacaoPrestador>
            <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
         </ans:identificacaoPrestador>
      </ans:origem>
      <ans:destino>
         <ans:registroANS>" . $registroans . "</ans:registroANS>
      </ans:destino>
      <ans:versaoPadrao>" . $versao . "</ans:versaoPadrao>
   </ans:cabecalho>
   <ans:prestadorParaOperadora>
      <ans:loteGuias>
         <ans:numeroLote>" . $b . "</ans:numeroLote>
            <ans:guiasTISS>";
                    $contador = count($listarpacienete);
                    foreach ($listarpacienete as $value) {

                        if ($value->guiaconvenio == '') {
                            $guianumero = '0000000';
                        } else {
                            $guianumero = $value->guiaconvenio;
                        }
                        if ($value->convenionumero == '') {
                            $numerodacarteira = '0000000';
                        } else {
                            $numerodacarteira = $value->convenionumero;
                        }

                        foreach ($listarexames as $item) {
                            if ($value->paciente_id == $item->paciente_id && $value->ambulatorio_guia_id == $item->ambulatorio_guia_id) {
                                $i++;
                                $data_autorizacao = $this->exame->listarxmldataautorizacao($value->ambulatorio_guia_id);
                                $dataautorizacao = substr($data_autorizacao[0]->data_cadastro, 0, 10);
                                $dataValidadeSenha = date('Y-m-d', strtotime("+30 days", strtotime($dataautorizacao)));
                                if ($item->medico == '') {
                                    $medico = 'ADMINISTRADOR';
                                } else {
                                    $medico = $item->medico;
                                }
                                if ($item->conselho == '') {
                                    $conselho = '0000000';
                                } else {
                                    $conselho = $item->conselho;
                                }
                                if ($item->medicosolicitante == '') {
                                    $medicosolicitante = $item->medico;
                                } else {
                                    $medicosolicitante = $item->medicosolicitante;
                                }
                                if ($item->conselhosolicitante == '') {
                                    $conselhosolicitante = $item->conselho;
                                } else {
                                    $conselhosolicitante = $item->conselhosolicitante;
                                }

                                if ($_POST['autorizacao'] == 'SIM') {
                                    $corpo = $corpo . "
                                                      <ans:guiaSP-SADT>
                      <ans:cabecalhoGuia>
                        <ans:registroANS>" . $registroans . "</ans:registroANS>
                     <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                     <ans:guiaPrincipal>1</ans:guiaPrincipal>
                  </ans:cabecalhoGuia>
                  <ans:dadosAutorizacao>
                  <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                  <ans:dataAutorizacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataAutorizacao>
                  <ans:senha>" . $item->autorizacao . "</ans:senha>
                  <ans:dataValidadeSenha>" . $dataValidadeSenha . "</ans:dataValidadeSenha> 
                  </ans:dadosAutorizacao>
                  <ans:dadosBeneficiario>
                     <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                         <ans:atendimentoRN>S</ans:atendimentoRN>
                     <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                  </ans:dadosBeneficiario>
                                                  <ans:dadosSolicitante>
                     <ans:contratadoSolicitante>
                           <ans:cnpjContratado>" . $cnpj . "</ans:cnpjContratado>
                        <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                     </ans:contratadoSolicitante>
                     <ans:profissionalSolicitante>
                        <ans:nomeProfissional>" . $medicosolicitante . "</ans:nomeProfissional>
                        <ans:conselhoProfissional>6</ans:conselhoProfissional>
                        <ans:numeroConselhoProfissional >" . $conselhosolicitante . "</ans:numeroConselhoProfissional >
                            <ans:UF>" . $codigoUF . "</ans:UF>
                        <ans:CBOS>999999</ans:CBOS>
                     </ans:profissionalSolicitante>
                  </ans:dadosSolicitante>
                  <ans:dadosSolicitacao>
                     <ans:dataSolicitacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataSolicitacao>
                     <ans:caraterAtendimento>1</ans:caraterAtendimento>
                     <ans:indicacaoClinica>I</ans:indicacaoClinica>
                  </ans:dadosSolicitacao>
                  <ans:dadosExecutante>
                        <ans:contratadoExecutante>
                        <ans:cnpjContratado>" . $cnpj . "</ans:cnpjContratado>
                     <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                     </ans:contratadoExecutante>
                     <ans:CNES>" . $cnes . "</ans:CNES>
                  </ans:dadosExecutante>
                  <ans:dadosAtendimento>
                  <ans:tipoAtendimento>04</ans:tipoAtendimento>
                  <ans:indicacaoAcidente>0</ans:indicacaoAcidente>
                  <ans:tipoConsulta>1</ans:tipoConsulta>
                  <ans:motivoEncerramento>41</ans:motivoEncerramento>
                  </ans:dadosAtendimento>
                  <ans:procedimentosExecutados>
                     <ans:procedimentoExecutado>
                            <ans:dataExecucao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataExecucao>
                            <ans:horaInicial>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaInicial>
                            <ans:horaFinal>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaFinal>
                            <ans:procedimento>
                            <ans:codigoTabela>22</ans:codigoTabela>
                           <ans:codigoProcedimento>" . $item->codigo . "</ans:codigoProcedimento>
                           <ans:descricaoProcedimento >" . substr(utf8_decode($item->procedimento), 0, 60) . "</ans:descricaoProcedimento >
                           </ans:procedimento>                        
                    <ans:quantidadeExecutada>" . $item->quantidade . "</ans:quantidadeExecutada>
                        <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
                        <ans:valorUnitario >" . $item->valor . "</ans:valorUnitario >
                        <ans:valorTotal>" . $item->valor_total . "</ans:valorTotal>
                        <ans:equipeSadt>
                        <ans:codProfissional>
                        <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                        </ans:codProfissional>
                        <ans:nomeProf>" . $medico . "</ans:nomeProf>
                        <ans:conselho>1</ans:conselho>
                        <ans:numeroConselhoProfissional>$conselho</ans:numeroConselhoProfissional>
                        <ans:UF>" . $codigoUF . "</ans:UF>
                        <ans:CBOS>999999</ans:CBOS>
                        </ans:equipeSadt>
                  </ans:procedimentoExecutado>
                  </ans:procedimentosExecutados>
                  <ans:observacao>III</ans:observacao>
                     <ans:valorTotal >
                     <ans:valorProcedimentos >" . $item->valor_total . "</ans:valorProcedimentos >
                     <ans:valorDiarias>0.00</ans:valorDiarias>
                     <ans:valorTaxasAlugueis>0.00</ans:valorTaxasAlugueis>
                     <ans:valorMateriais>0.00</ans:valorMateriais>
                     <ans:valorMedicamentos>0.00</ans:valorMedicamentos>
                     <ans:valorOPME>0.00</ans:valorOPME>
                     <ans:valorGasesMedicinais>0.00</ans:valorGasesMedicinais>
                     <ans:valorTotalGeral>" . $item->valor_total . "</ans:valorTotalGeral>
                  </ans:valorTotal>
                  </ans:guiaSP-SADT>";
                                } else {
                                    $corpo = $corpo . "
                                                      <ans:guiaSP-SADT>
                      <ans:cabecalhoGuia>
                        <ans:registroANS>" . $registroans . "</ans:registroANS>
                     <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                     <ans:guiaPrincipal>1</ans:guiaPrincipal>
                  </ans:cabecalhoGuia>
                  <ans:dadosAutorizacao>
                  <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                  <ans:dataAutorizacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataAutorizacao>
                  </ans:dadosAutorizacao>
                  <ans:dadosBeneficiario>
                     <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                         <ans:atendimentoRN>S</ans:atendimentoRN>
                     <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                  </ans:dadosBeneficiario>
                                                  <ans:dadosSolicitante>
                     <ans:contratadoSolicitante>
                           <ans:cnpjContratado>" . $cnpj . "</ans:cnpjContratado>
                        <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                     </ans:contratadoSolicitante>
                     <ans:profissionalSolicitante>
                        <ans:nomeProfissional>" . $medicosolicitante . "</ans:nomeProfissional>
                        <ans:conselhoProfissional>6</ans:conselhoProfissional>
                        <ans:numeroConselhoProfissional >" . $conselhosolicitante . "</ans:numeroConselhoProfissional >
                            <ans:UF>" . $codigoUF . "</ans:UF>
                        <ans:CBOS>999999</ans:CBOS>
                     </ans:profissionalSolicitante>
                  </ans:dadosSolicitante>
                  <ans:dadosSolicitacao>
                     <ans:dataSolicitacao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataSolicitacao>
                     <ans:caraterAtendimento>1</ans:caraterAtendimento>
                     <ans:indicacaoClinica>I</ans:indicacaoClinica>
                  </ans:dadosSolicitacao>
                  <ans:dadosExecutante>
                        <ans:contratadoExecutante>
                        <ans:cnpjContratado>" . $cnpj . "</ans:cnpjContratado>
                     <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                     </ans:contratadoExecutante>
                     <ans:CNES>" . $cnes . "</ans:CNES>
                  </ans:dadosExecutante>
                  <ans:dadosAtendimento>
                  <ans:tipoAtendimento>04</ans:tipoAtendimento>
                  <ans:indicacaoAcidente>0</ans:indicacaoAcidente>
                  <ans:tipoConsulta>1</ans:tipoConsulta>
                  <ans:motivoEncerramento>41</ans:motivoEncerramento>
                  </ans:dadosAtendimento>
                  <ans:procedimentosExecutados>
                     <ans:procedimentoExecutado>
                            <ans:dataExecucao>" . substr($data_autorizacao[0]->data_cadastro, 0, 10) . "</ans:dataExecucao>
                            <ans:horaInicial>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaInicial>
                            <ans:horaFinal>" . substr($data_autorizacao[0]->data_cadastro, 11, 8) . "</ans:horaFinal>
                            <ans:procedimento>
                            <ans:codigoTabela>22</ans:codigoTabela>
                           <ans:codigoProcedimento>" . $item->codigo . "</ans:codigoProcedimento>
                           <ans:descricaoProcedimento >" . substr(utf8_decode($item->procedimento), 0, 60) . "</ans:descricaoProcedimento >
                           </ans:procedimento>                        
                    <ans:quantidadeExecutada>" . $item->quantidade . "</ans:quantidadeExecutada>
                        <ans:reducaoAcrescimo>1.00</ans:reducaoAcrescimo>
                        <ans:valorUnitario >" . $item->valor . "</ans:valorUnitario >
                        <ans:valorTotal>" . $item->valor_total . "</ans:valorTotal>
                        <ans:equipeSadt>
                        <ans:codProfissional>
                        <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                        </ans:codProfissional>
                        <ans:nomeProf>" . $medico . "</ans:nomeProf>
                        <ans:conselho>1</ans:conselho>
                        <ans:numeroConselhoProfissional>$conselho</ans:numeroConselhoProfissional>
                        <ans:UF>" . $codigoUF . "</ans:UF>
                        <ans:CBOS>999999</ans:CBOS>
                        </ans:equipeSadt>
                  </ans:procedimentoExecutado>
                  </ans:procedimentosExecutados>
                  <ans:observacao>III</ans:observacao>
                     <ans:valorTotal >
                     <ans:valorProcedimentos >" . $item->valor_total . "</ans:valorProcedimentos >
                     <ans:valorDiarias>0.00</ans:valorDiarias>
                     <ans:valorTaxasAlugueis>0.00</ans:valorTaxasAlugueis>
                     <ans:valorMateriais>0.00</ans:valorMateriais>
                     <ans:valorMedicamentos>0.00</ans:valorMedicamentos>
                     <ans:valorOPME>0.00</ans:valorOPME>
                     <ans:valorGasesMedicinais>0.00</ans:valorGasesMedicinais>
                     <ans:valorTotalGeral>" . $item->valor_total . "</ans:valorTotalGeral>
                  </ans:valorTotal>
                  </ans:guiaSP-SADT>";
                                }


                                if ($i == 80) {
                                    $contador = $contador - $i;

                                    $i = 0;
                                    $rodape = "   </ans:guiasTISS>
         
      </ans:loteGuias>
   </ans:prestadorParaOperadora>
   <ans:epilogo>
      <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
   </ans:epilogo>
</ans:mensagemTISS>
";

                                    $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                    $xml = $cabecalho . $corpo . $rodape;
                                    $fp = fopen($nome, "w+");
                                    fwrite($fp, $xml . "\n");
                                    fclose($fp);
                                    $b++;
                                    $corpo = "";
                                    $rodape = "";
                                }

                                if ($contador < 80 && $contador == $i) {
                                    $i = 0;
                                    $rodape = "   </ans:guiasTISS>
         
      </ans:loteGuias>
   </ans:prestadorParaOperadora>
   <ans:epilogo>
      <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
   </ans:epilogo>
</ans:mensagemTISS>
";
                                    $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                                    $xml = $cabecalho . $corpo . $rodape;
                                    $fp = fopen($nome, "w+");
                                    fwrite($fp, $xml . "\n");
                                    fclose($fp);
                                    $b++;
                                    $corpo = "";
                                    $rodape = "";
                                }
                            }
                        }
                    }
                } else {

                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
<ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
   <ans:cabecalho>
      <ans:identificacaoTransacao>
         <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
         <ans:sequencialTransacao>" . $j . "</ans:sequencialTransacao>
         <ans:dataRegistroTransacao>" . substr($listarexame[0]->data_autorizacao, 0, 10) . "</ans:dataRegistroTransacao>
         <ans:horaRegistroTransacao>18:40:50</ans:horaRegistroTransacao>
      </ans:identificacaoTransacao>
      <ans:origem>
         <ans:identificacaoPrestador>
            <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
         </ans:identificacaoPrestador>
      </ans:origem>
      <ans:destino>
         <ans:registroANS>" . $registroans . "</ans:registroANS>
      </ans:destino>
      <ans:versaoPadrao>" . $versao . "</ans:versaoPadrao>
   </ans:cabecalho>
   <ans:prestadorParaOperadora>
      <ans:loteGuias>
         <ans:numeroLote>" . $b . "</ans:numeroLote>
            <ans:guiasTISS>";
                    $contador = count($listarexame);

                    foreach ($listarexame as $value) {
                        $i++;
                        if ($value->convenionumero == '') {
                            $numerodacarteira = '0000000';
                        } else {
                            $numerodacarteira = $value->convenionumero;
                        }
                        if ($value->medico == '') {
                            $medico = 'ADMINISTRADOR';
                        } else {
                            $medico = $value->medico;
                        }
                        if ($value->conselho == '') {
                            $conselho = '0000000';
                        } else {
                            $conselho = $value->conselho;
                        }
                        if ($value->guiaconvenio == '') {
                            $guianumero = '0000000';
                        } else {
                            $guianumero = $value->guiaconvenio;
                        }
                        $corpo = $corpo . "
            <ans:guiaConsulta>
                <ans:cabecalhoConsulta>
                    <ans:registroANS>" . $registroans . "</ans:registroANS>
                    <ans:numeroGuiaPrestador>" . $value->ambulatorio_guia_id . "</ans:numeroGuiaPrestador>
                </ans:cabecalhoConsulta>
                <ans:numeroGuiaOperadora>" . $guianumero . "</ans:numeroGuiaOperadora>
                <ans:dadosBeneficiario>
                    <ans:numeroCarteira>" . $numerodacarteira . "</ans:numeroCarteira>
                    <ans:atendimentoRN>N</ans:atendimentoRN>
                    <ans:nomeBeneficiario>" . $value->paciente . "</ans:nomeBeneficiario>
                </ans:dadosBeneficiario>
                <ans:contratadoExecutante>
                    <ans:codigoPrestadorNaOperadora>" . $cnpjxml . "</ans:codigoPrestadorNaOperadora>
                    <ans:nomeContratado>" . $razao_socialxml . "</ans:nomeContratado>
                    <ans:CNES>" . $cnes . "</ans:CNES>
                </ans:contratadoExecutante>
                <ans:profissionalExecutante>
                    <ans:nomeProfissional>" . $medico . "</ans:nomeProfissional>
                    <ans:conselhoProfissional>6</ans:conselhoProfissional>
                    <ans:numeroConselhoProfissional>" . $conselho . "</ans:numeroConselhoProfissional>
                    <ans:UF>15</ans:UF>
                    <ans:CBOS>225120</ans:CBOS>
                </ans:profissionalExecutante>
                <ans:indicacaoAcidente>9</ans:indicacaoAcidente>
                <ans:dadosAtendimento>
                    <ans:dataAtendimento>" . substr($value->data_autorizacao, 0, 10) . "</ans:dataAtendimento>
                    <ans:tipoConsulta>1</ans:tipoConsulta>
                    <ans:procedimento>
                        <ans:codigoTabela>22</ans:codigoTabela>
                        <ans:codigoProcedimento>" . $value->codigo . "</ans:codigoProcedimento>
                        <ans:valorProcedimento>" . $value->valor . "</ans:valorProcedimento>
                    </ans:procedimento>
                </ans:dadosAtendimento>
            </ans:guiaConsulta>";
                        if ($i == 80) {
                            $contador = $contador - $i;
                            $i = 0;
                            $rodape = "</ans:guiasTISS>
    </ans:loteGuias>
</ans:prestadorParaOperadora>
<ans:epilogo>
<ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
</ans:epilogo>
</ans:mensagemTISS>
";

                            $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                            $xml = $cabecalho . $corpo . $rodape;
                            $fp = fopen($nome, "w+");
                            fwrite($fp, $xml . "\n");
                            fclose($fp);
                            $b++;
                            $corpo = "";
                            $rodape = "";
                        }
                        if ($contador < 80 && $contador == $i) {
                            $i = 0;
                            $rodape = "   </ans:guiasTISS>
         
       
    </ans:loteGuias>
</ans:prestadorParaOperadora>
<ans:epilogo>
<ans:hash>e2eadfe09fd6750a184902545aa41771</ans:hash>
</ans:epilogo>
</ans:mensagemTISS>
";
                            $nome = "./upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
                            $xml = $cabecalho . $corpo . $rodape;
                            $fp = fopen($nome, "w+");
                            fwrite($fp, $xml . "\n");
                            fclose($fp);
                            $b++;
                            $corpo = "";
                            $rodape = "";
                        }
                    }
                }
            }
        }
        $this->exame->gravarlote($b);
        $zip = new ZipArchive;
        $this->load->helper('directory');
        $arquivo_pasta = directory_map("./upload/cr/$convenio/");
        if ($arquivo_pasta != false) {
            foreach ($arquivo_pasta as $value) {
                $deletar[] = "./upload/cr/$convenio/$value";
            }
            foreach ($arquivo_pasta as $value) {
                $zip->open("./upload/cr/$convenio/$value.zip", ZipArchive::CREATE);
                $zip->addFile("./upload/cr/$convenio/$value", "$value");
//           $deletarxml = "./upload/cr/$convenio/$value";
//           unlink($deletarxml);
            }
            $zip->close();
            foreach ($deletar as $arquivonome) {
                unlink($arquivonome);
            }
        }
        $data['mensagem'] = 'Sucesso ao gerar arquivo.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/faturamentoexamexml", $data);
    }

    function gerardicom($laudo_id) {
        $exame = $this->exame->listardicom($laudo_id);

        $grupo = $exame[0]->grupo;
        if ($grupo == 'RX' || $grupo == 'MAMOGRAFIA') {
            $grupo = 'CR';
        }
        if ($grupo == 'RM') {
            $grupo = 'MR';
        }
        if ($grupo == 'TOMOGRAFIA') {
            $grupo = 'CT';
        }
        if ($grupo == 'DENSITOMETRIA') {
            $grupo = 'DX';
        }
        $data['titulo'] = "AETITLE";
        $data['data'] = str_replace("-", "", date("Y-m-d"));
        $data['hora'] = str_replace(":", "", date("H:i:s"));
        $data['tipo'] = $grupo;
        $data['tecnico'] = $exame[0]->tecnico;
        $data['procedimento'] = $exame[0]->procedimento;
        $data['procedimento_tuss_id'] = $exame[0]->codigo;
        $data['procedimento_tuss_id_solicitado'] = $exame[0]->codigo;
        $data['procedimento_solicitado'] = $exame[0]->procedimento;
        $data['identificador_id'] = $exame[0]->guia_id;
        $data['pedido_id'] = $exame[0]->guia_id;
        $data['solicitante'] = $exame[0]->convenio;
        $data['referencia'] = "";
        $data['paciente_id'] = $exame[0]->paciente_id;
        $data['paciente'] = $exame[0]->paciente;
        $data['nascimento'] = str_replace("-", "", $exame[0]->nascimento);
        $data['sexo'] = $exame[0]->sexo;
        $data['exame_id'] = $laudo_id;
        $this->exame->gravardicom($data);
    }

}

/* End of file welcome.php */
    /* Location: ./system/application/controllers/welcome.php */

    
