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
        $this->load->model('ambulatorio/sala_model', 'sala');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('login_model', 'login');
        $this->load->model('ambulatorio/tipoconsulta_model', 'tipoconsulta');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/motivocancelamento_model', 'motivocancelamento');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
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

    function listarsalasespera($args = array()) {

        $this->loadView('ambulatorio/exameespera-lista', $args);
    }

    function listaresperacaixa($args = array()) {

        $this->loadView('ambulatorio/exameesperacaixa-lista', $args);
    }

    function listarmultifuncao($args = array()) {

        $this->loadView('ambulatorio/examemultifuncao-lista', $args);
    }

    function listarmultifuncaogeral($args = array()) {

        $this->loadView('ambulatorio/examemultifuncaogeral-lista', $args);
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

    function gerarelatoriomedicoagendaconsultas() {
        $medicos = $_POST['medicos'];
        $data['medico'] = $this->operador_m->listarCada($medicos);
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
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
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
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
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->exame->listaragendaexame();
        $this->load->View('ambulatorio/impressaorelatoriomedicoagendaexame', $data);
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

    function listarmultifuncaomedicoconsulta($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicoconsulta-lista', $args);
    }

    function listarmultifuncaomedicogeral($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicogeral-lista', $args);
    }

    function listarmultifuncaomedico($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedico-lista', $args);
    }

    function listarmultifuncaomedicolaboratorial($args = array()) {

        $this->loadView('ambulatorio/multifuncaomedicolaboratorial-lista', $args);
    }

    function faturamentoexame() {

        $this->loadView('ambulatorio/faturamentoexame');
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
        $this->exame->autorizarsessao($agenda_exames_id);
        $data['lista'] = $this->exame->autorizarsessaofisioterapia($paciente_id);
        redirect(base_url() . "ambulatorio/guia/impressaoficha/$paciente_id/$guia_id/$agenda_exames_id");
    }

    function autorizarsessaocadapsicologia($agenda_exames_id, $paciente_id, $guia_id) {
        $this->exame->autorizarsessao($agenda_exames_id);
        $data['lista'] = $this->exame->autorizarsessaopsicologia($paciente_id);
        redirect(base_url() . "ambulatorio/guia/impressaoficha/$paciente_id/$guia_id/$agenda_exames_id");
    }

    function faturamentoexamelista() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
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

    function estoqueguia($agenda_exames_id) {

        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->loadView('ambulatorio/estoqueguia-form', $data);
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
            $laudo_id = $this->exame->gravarexame();
            if ($laudo_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar o Exame. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar o Exame.';
//                $this->gerarcr($agenda_exames_id); //clinica humana
                $this->gerardicom($laudo_id); //clinica ronaldo
            }
        } else {
            $data['mensagem'] = 'Erro ao gravar o Exame. Exame ja cadastrato.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        $this->laudo->chamada($laudo_id);
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
        $verificar = $this->exame->cancelarespera();
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao cancelar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao cancelar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarsalasespera");
    }

    function cancelarguia() {
        $verificar = $this->exame->cancelarespera();
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao cancelar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao cancelar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function telefonema($agenda_exame_id, $paciente) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['paciente'] = $paciente;
        $this->load->View('ambulatorio/telefonema-form', $data);
    }

    function telefonemagravar($agenda_exame_id) {
        $this->exame->telefonema($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function observacao($agenda_exame_id, $paciente) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['paciente'] = $paciente;
        $this->load->View('ambulatorio/observacao-form', $data);
    }

    function alterarobservacao($agenda_exame_id) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['observacao'] = $this->exame->listarobservacoes($agenda_exame_id);
        $this->load->View('ambulatorio/alterarobservacao-form', $data);
    }

    function observacaogravar($agenda_exame_id) {
        $verificar = $this->exame->observacao($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
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
        $verificar = $this->exame->cancelarexame();
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao cancelar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao cancelar o Exame.';
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
        redirect(base_url() . "ambulatorio/exame/listarexamependente");
    }

    function finalizarexame($exames_id, $sala_id) {
        $verificar = $this->exame->finalizarexame($exames_id, $sala_id);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao finalizar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao finalizar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamerealizando");
    }

    function finalizarexametodos($sala_id, $guia_id, $grupo) {
        $verificar = $this->exame->finalizarexametodos($sala_id, $guia_id, $grupo);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao finalizar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao finalizar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarexamerealizando");
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

    function anexarimagem($exame_id, $sala_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['arquivos_deletados'] = directory_map("/home/sisprod/projetos/clinica/uploadopm/$exame_id/");
//        $data['arquivo_pasta'] = directory_map("/home/hamilton/projetos/clinica/upload/$exame_id/");
        //$data['arquivos_deletados'] = directory_map("/home/hamilton/projetos/clinica/uploadopm/$exame_id/");
        $data['exame_id'] = $exame_id;
        $data['sala_id'] = $sala_id;
        $this->loadView('ambulatorio/importacao-imagem', $data);
    }

    function anexarimagemmedico($exame_id, $sala_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$exame_id/");
//        $data['arquivo_pasta'] = directory_map("/home/hamilton/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['arquivos_deletados'] = directory_map("/home/sisprod/projetos/clinica/uploadopm/$exame_id/");
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

        $config['upload_path'] = "/home/sisprod/projetos/clinica/upload/" . $exame_id . "/";
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
            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom1/");
            //$origem = "/home/hamilton/teste";
            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom1";
            foreach ($arquivo_pasta as $value) {
                $nova = substr($value, 11, 6);
                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }
        if ($sala_id == 2) {

            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom2/");
            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom2";
            foreach ($arquivo_pasta as $value) {
                $nova = substr($value, 11, 6);
                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }
        if ($sala_id == 9) {

            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom3/");
            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom3";
            foreach ($arquivo_pasta as $value) {
                $nova = substr($value, 8, 6);
                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
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
//            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom1/");
//            sort($arquivo_pasta);
//            //$origem = "/home/hamilton/teste";
//            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom1";
//            foreach ($arquivo_pasta as $value) {
//                $i++;
//                $nova = $i . ".jpg";
//                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
//                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
//                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//        if ($sala_id == 2) {
//
//            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom2/");
//            sort($arquivo_pasta);
//            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom2";
//            foreach ($arquivo_pasta as $value) {
//                $i++;
//                $nova = $i . ".jpg";
//                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
//                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
//                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//        if ($sala_id == 9) {
//
//            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom3/");
//            sort($arquivo_pasta);
//            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom3";
//            foreach ($arquivo_pasta as $value) {
//                $i++;
//                $nova = $i . ".jpg";
//                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
//                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
//                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
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
        
        
        $this->load->helper('directory');
        if ($sala_id == 1) {

            //$arquivo_pasta = directory_map("/home/hamilton/teste/");
            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom1/");
            //$origem = "/home/hamilton/teste";
            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom1";
            foreach ($arquivo_pasta as $value) {

                $nova = substr($value, 11, 6);

                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }
        if ($sala_id == 2) {

            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom2/");
            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom2";
            foreach ($arquivo_pasta as $value) {

                $nova = substr($value, 11, 6);

                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }
        if ($sala_id == 9) {

            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom3/");
            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom3";
            foreach ($arquivo_pasta as $value) {

                $nova = substr($value, 8, 6);

                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                    chmod($destino, 0777);
                }
                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
                $local = "$origem/$value";
                copy($local, $destino);
            }
        }

        delete_files($origem);

        redirect(base_url() . "ambulatorio/exame/anexarimagemmedico/$exame_id/$sala_id");

//      CAGE/GASTROSUL
//        
//        $this->load->helper('directory');
//        $i=0;
//        if ($sala_id == 1) {
//
//            //$arquivo_pasta = directory_map("/home/hamilton/teste/");
//            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom1/");
//            sort($arquivo_pasta);
//            //$origem = "/home/hamilton/teste";
//            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom1";
//            foreach ($arquivo_pasta as $value) {
//                $i++;
//                $nova = $i . ".jpg";
//
//                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
//                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
//                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//        if ($sala_id == 2) {
//
//            
//            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom2/");
//            sort($arquivo_pasta);
//            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom2";
//            foreach ($arquivo_pasta as $value) {
//
//                $i++;
//                $nova = $i . ".jpg";
//
//                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
//                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
//                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//        if ($sala_id == 9) {
//
//            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/ultrasom3/");
//            sort($arquivo_pasta);
//            $origem = "/home/sisprod/projetos/clinica/upload/ultrasom3";
//            foreach ($arquivo_pasta as $value) {
//
//                $i++;
//                $nova = $i . ".jpg";
//
//                if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
//                    mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
//                    $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                    chmod($destino, 0777);
//                }
//                $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                $local = "$origem/$value";
//                copy($local, $destino);
//            }
//        }
//
//        delete_files($origem);
//
//        redirect(base_url() . "ambulatorio/exame/anexarimagemmedico/$exame_id/$sala_id");
    }

    function restaurarimagem($exame_id, $nome) {

        $origem = "./uploadopm/$exame_id/$nome";
        $destino = "./upload/$exame_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        redirect(base_url() . "ambulatorio/exame/anexarimagem/$exame_id");
    }

    function ordenarimagens($exame_id, $sala_id) {
        $i = 1;
        $imagens = $_POST['teste'];
        foreach ($imagens as $value) {

            $origem = "./upload/$exame_id/$value";
            $destino = "./upload/$exame_id/$i$value";
            copy($origem, $destino);
            unlink($origem);
            $i++;
        }
        redirect(base_url() . "ambulatorio/exame/anexarimagemmedico/$exame_id/$sala_id");
    }

    function restaurarimagemmedico($exame_id, $nome, $sala_id) {

        $origem = "./uploadopm/$exame_id/$nome";
        $destino = "./upload/$exame_id/$nome";
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

        $dia = date("d-m-Y");
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

    function novoagendaexame() {
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exame->listarmedico();
        $data['agenda'] = $this->agenda->listaragenda();
        $this->loadView('ambulatorio/exame-form', $data);
    }

    function novoagendaconsulta() {
        $data['medico'] = $this->exame->listarmedico();
        $data['agenda'] = $this->agenda->listaragenda();
        $data['tipo'] = $this->tipoconsulta->listartodos();
        $this->loadView('ambulatorio/consulta-form', $data);
    }

    function novoagendaespecializacao() {
        $data['medico'] = $this->exame->listarmedico();
        $data['agenda'] = $this->agenda->listaragenda();
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
        $datainicial = str_replace("/", "-", $_POST['txtdatainicial']);
        $datafinal = str_replace("/", "-", $_POST['txtdatafinal']);
        $nome = $_POST['txtNome'];
        $horarioagenda = $this->agenda->listarhorarioagenda($agenda_id);
        $id = 0;

        foreach ($horarioagenda as $item) {

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
                                $this->exame->gravar($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id);
                            }
                            if (( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravar($agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id);
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
                                $this->exame->gravar($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id);
                            }
                            if ((($horaverifica < $item->intervaloinicio) || ($horaverifica >= $item->intervalofim)) && ( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravar($agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        }
                    }
                }
            }
        }

        $data['mensagem'] = 'Sucesso ao gravar o Agenda.';

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame");
    }

    function gravarconsulta() {
        $agenda_id = $_POST['txthorario'];
        $medico_id = $_POST['txtmedico'];
        $datainicial = str_replace("/", "-", $_POST['txtdatainicial']);
        $datafinal = str_replace("/", "-", $_POST['txtdatafinal']);
        $nome = $_POST['txtNome'];
        $horarioagenda = $this->agenda->listarhorarioagenda($agenda_id);
        $id = 0;

        foreach ($horarioagenda as $item) {

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
                                $this->exame->gravarconsulta($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id);
                            }
                            if (( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravarconsulta($agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $medico_id, $id);
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
                                $this->exame->gravarconsulta($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id);
                            }
                            if ((($horaverifica < $item->intervaloinicio) || ($horaverifica >= $item->intervalofim)) && ( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravarconsulta($agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $medico_id, $id);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        }
                    }
                }
            }
        }

        $data['mensagem'] = 'Sucesso ao gravar o Agenda.';

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame");
    }

    function gravarespecialidade() {
        $agenda_id = $_POST['txthorario'];
        $medico_id = $_POST['txtmedico'];
        $datainicial = str_replace("/", "-", $_POST['txtdatainicial']);
        $datafinal = str_replace("/", "-", $_POST['txtdatafinal']);
        $nome = $_POST['txtNome'];
        $horarioagenda = $this->agenda->listarhorarioagenda($agenda_id);
        $id = 0;
        
        foreach ($horarioagenda as $item) {

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
                                $this->exame->gravarespecialidade($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id);
                            }
                            if (( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravarespecialidade($agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $medico_id, $id);
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
                                $this->exame->gravarespecialidade($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id);
                            }
                            if ((($horaverifica < $item->intervaloinicio) || ($horaverifica >= $item->intervalofim)) && ( $horaverifica < $item->horasaida1)) {
                                $x = 1;
                                $horaconsulta = $horaverifica;
                                $horasaida = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                                $this->exame->gravarespecialidade($agenda_id, $horaconsulta, $horasaida, $nome, $datainicial, $datafinal, $index, $medico_id, $id);
                            }
                            $horaverifica = date('H:i:s', strtotime("+ $tempoconsulta minutes", strtotime($horaverifica)));
                        }
                    }
                }
            }
        }
        
        $data['mensagem'] = 'Sucesso ao gravar a Agenda.';

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame");
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

        if (!is_dir("/home/sisprod/projetos/clinica/cr/")) {
            mkdir("/home/sisprod/projetos/clinica/cr/");
        }
        $nome = "/home/sisprod/projetos/clinica/cr/" . $agenda_exames_id . ".txt";
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

//        $listarexame = $this->exame->listargxmlfaturamento();
//        foreach ($listarexame as $value) {
//            $total = $total + $value->valor_total;
//        }
//        var_dump($total);
//        die;
        $horario = date("Y-m-d");
        $empresa = $this->exame->listarcnpj();
        $lote = $this->exame->listarlote();
        $cnpjxml = $listarexame[0]->codigoidentificador;
        $razao_socialxml = $empresa[0]->razao_socialxml;
        $registroans = $listarexame[0]->registroans;
        $cpfxml = $empresa[0]->cpfxml;
        $cnpj = $empresa[0]->cnpj;
        $cnes = $empresa[0]->cnes;
        $convenio = $listarexame[0]->convenio;
        $versao = $_POST['xml'];
        $modelo = $_POST['modelo'];

        if ($_POST['tipo'] != 0) {
            $classificacao = $listarexame[0]->classificacao;
        } else {
            $classificacao = 'TODOS';
        }
        $datainicio = str_replace("/", "", $_POST['datainicio']);
        $datafim = str_replace("/", "", $_POST['datafim']);
        $nomearquivo = '035753bf836c231bedbc68a08daf4668';
        $nomearquivoconsulta = 'e2eadfe09fd6750a184902545aa41771';
        $origem = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio;

        if (!is_dir("/home/sisprod/projetos/clinica/upload/cr/" . $convenio)) {
            mkdir("/home/sisprod/projetos/clinica/upload/cr/" . $convenio);
            chmod($origem, 0777);
        }
        if ($_POST['apagar'] == 1) {
            delete_files($origem);
        }
        $i = 0;
        $b = $lote[0]->lote;
        $j = $b - 53;
        $zero = '0000000000000000';
        $corpo = "";

        if ($modelo == 'cpf') {
            if ($listarexame[0]->grupo != 'CONSULTA') {

                $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
<ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
   <ans:cabecalho>
      <ans:identificacaoTransacao>
         <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
         <ans:sequencialTransacao>". $j ."</ans:sequencialTransacao>
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
                            <ans:UF>23</ans:UF>
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
                        <ans:UF>23</ans:UF>
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

                        $nome = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
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
                        $nome = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                        $xml = $cabecalho . $corpo . $rodape;
                        $fp = fopen($nome, "w+");
                        fwrite($fp, $xml . "\n");
                        fclose($fp);
                        $b++;
                        $corpo = "";
                        $rodape = "";
                    }
                }
            } else {


                $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
<ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
   <ans:cabecalho>
      <ans:identificacaoTransacao>
         <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
         <ans:sequencialTransacao>". $j ."</ans:sequencialTransacao>
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

                        $nome = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
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
                        $nome = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
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
         <ans:sequencialTransacao>". $j ."</ans:sequencialTransacao>
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
                            <ans:UF>23</ans:UF>
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
                        <ans:UF>23</ans:UF>
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

                        $nome = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                        $xml = $cabecalho . $corpo . $rodape;
                        $fp = fopen($nome, "w+");
                        fwrite($fp, $xml . "\n");
                        fclose($fp);
                        $b++;
                        $corpo = "";
                        $rodape = "";
                    }
                    if ($contador < 80 && $contador == $i) {
                        var_dump($corpo);
                        die;
                        $i = 0;
                        $rodape = "   </ans:guiasTISS>
         
      </ans:loteGuias>
   </ans:prestadorParaOperadora>
   <ans:epilogo>
      <ans:hash>035753bf836c231bedbc68a08daf4668</ans:hash>
   </ans:epilogo>
</ans:mensagemTISS>
";
                        $nome = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivo . ".xml";
                        $xml = $cabecalho . $corpo . $rodape;
                        $fp = fopen($nome, "w+");
                        fwrite($fp, $xml . "\n");
                        fclose($fp);
                        $b++;
                        $corpo = "";
                        $rodape = "";
                    }
                }
            } else {


                $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
<ans:mensagemTISS xmlns='http://www.w3.org/2001/XMLSchema' xmlns:ans='http://www.ans.gov.br/padroes/tiss/schemas'>
   <ans:cabecalho>
      <ans:identificacaoTransacao>
         <ans:tipoTransacao>ENVIO_LOTE_GUIAS</ans:tipoTransacao>
         <ans:sequencialTransacao>". $j ."</ans:sequencialTransacao>
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

                        $nome = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
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
                        $nome = "/home/sisprod/projetos/clinica/upload/cr/" . $convenio . "/" . $zero . $b . "_" . $nomearquivoconsulta . ".xml";
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
        $this->exame->gravarlote($b);
        $zip = new ZipArchive;
        $this->load->helper('directory');
        $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/cr/$convenio/");
        if ($arquivo_pasta != false) {
            foreach ($arquivo_pasta as $value) {
                $deletar[] = "/home/sisprod/projetos/clinica/upload/cr/$convenio/$value";
            }
            foreach ($arquivo_pasta as $value) {
                $zip->open("/home/sisprod/projetos/clinica/upload/cr/$convenio/$value.zip", ZipArchive::CREATE);
                $zip->addFile("/home/sisprod/projetos/clinica/upload/cr/$convenio/$value", "$value");
//           $deletarxml = "/home/sisprod/projetos/clinica/upload/cr/$convenio/$value";
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

    
