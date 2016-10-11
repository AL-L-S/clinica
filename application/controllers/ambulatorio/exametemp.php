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
class Exametemp extends BaseController {

    function Exametemp() {
        parent::Controller();
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/exametemp-lista', $args);

//            $this->carregarView($data);
    }

    function novo() {
        $ambulatorio_pacientetemp_id = $this->exametemp->criar();
        $this->carregarexametemp($ambulatorio_pacientetemp_id);

//            $this->carregarView($data);
    }

    function novopaciente() {
        $data['idade'] = 0;
        $this->loadView('ambulatorio/pacientetemp-form', $data);
    }

    function novopacienteconsulta() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempconsulta-form', $data);
    }

    function novopacientefisioterapia() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempfisioterapia-form', $data);
    }

    function novopacienteconsultaencaixe() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempconsultaencaixe-form', $data);
    }

    function novopacienteexameencaixe() {
        $data['idade'] = 0;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacientetempexameencaixe-form', $data);
    }

    function novopacienteencaixegeral() {
        $data['idade'] = 0;
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacientetempencaixegeral-form', $data);
    }

    function novohorarioexameencaixe() {
        $data['idade'] = 0;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/horariotempexameencaixe-form', $data);
    }

    function novohorarioencaixegeral() {
        $data['idade'] = 0;
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/horariotempencaixegeral-form', $data);
    }

    function novopacientefisioterapiaencaixe() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempfisioterapiaencaixe-form', $data);
    }

    function pacienteconsultaencaixe($paciente_id) {
        $data['idade'] = 0;
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacienteconsultaencaixe-form', $data);
    }

    function carregarexametemp($ambulatorio_pacientetemp_id) {
        $obj_exametemp = new exametemp_model($ambulatorio_pacientetemp_id);
        $data['obj'] = $obj_exametemp;
        $data['idade'] = 0;
        $data['contador'] = $this->exametemp->contador($ambulatorio_pacientetemp_id);
        if ($data['contador'] > 0) {
            $data['exames'] = $this->exametemp->listaragendas($ambulatorio_pacientetemp_id);
        }
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/exametemp-form', $data);
    }

    function unificar($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $this->loadView('ambulatorio/unificar-form', $data);
    }

    function gravarunificar() {
        $pacientetemp_id = $_POST['paciente_id'];
        $verifica = $this->exametemp->gravarunificacao();
        if ($verifica == "-1") {
            $data['mensagem'] = 'Erro ao unificar Paciente. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao unificar Paciente.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
    }

    function carregarpacientetempgeral($pacientetemp_id) {

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['exames'] = $this->exametemp->listaragendatotalpacientegeral($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarprocedimentosanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarprocedimentoanteriorcontador($pacientetemp_id);


        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepacientetempgeral-form', $data);
    }

    function carregarpacientetemp($pacientetemp_id) {

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorpaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpaciente($pacientetemp_id);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepacientetemp-form', $data);
    }

    function carregarpacienteconsultatemp($pacientetemp_id) {

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['contador'] = $this->exametemp->contadorconsultapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacienteconsulta($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/consultapacientetemp-form', $data);
    }

    function carregarpacientefisioterapiatemp($pacientetemp_id) {

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['contador'] = $this->exametemp->contadorfisioterapiapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapia($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/fisioterapiapacientetemp-form', $data);
    }

    function carregarexamegeral($agenda_exames_id, $medico_id) {
        $data['medico'] = $medico_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconveniomedico($medico_id);
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
//
//        if (count($data['exameshorario']) > 0 || count($data['exameshorariofim']) > 0) {
//            
//            $data['mensagem'] = 'Esse medico já tem paciente neste horario:';
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral2/$agenda_exames_id/$medico_id");
//            
//        } else {
        $this->loadView('ambulatorio/examepacientegeral-form', $data);
//        }
    }

    function carregarexamegeral2($agenda_exames_id, $medico_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico'] = $medico_id;
//        $data['medicos'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconveniomedico($medico_id);
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
        $this->loadView('ambulatorio/examepacientegeral-form', $data);
    }

    function carregarexamegeral3($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
        $this->loadView('ambulatorio/examepacientegeralmedico-form', $data);
    }

    function carregarexame($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);
        $medico = $data['exames'][0]->medico_agenda;
        $datas = $data['exames'][0]->data;
        $data['valor'] = $this->exametemp->listarvalortotalexames($medico, $datas);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepaciente-form', $data);
    }

    function carregarconsultatemp($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['consultas'] = $this->exametemp->listaragendasconsultapaciente($agenda_exames_id);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/consultapaciente-form', $data);
    }

    function carregarfisioterapiatemp($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['consultas'] = $this->exametemp->listaragendasconsultapaciente($agenda_exames_id);
        
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/fisioterapiapaciente-form', $data);
    }

    function excluir($agenda_exames_id, $ambulatorio_pacientetemp_id) {
        $this->exametemp->excluir($agenda_exames_id);
        $this->carregarexametemp($ambulatorio_pacientetemp_id);
    }

    function excluirexametemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->excluirexametemp($agenda_exames_id);
        $this->carregarpacientetemp($pacientetemp_id);
    }

    function excluirconsultatempgeral($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->excluirexametemp($agenda_exames_id);
        $this->carregarpacientetempgeral($pacientetemp_id);
    }

    function excluirconsultatemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->excluirexametemp($agenda_exames_id);
        $this->carregarpacienteconsultatemp($pacientetemp_id);
    }

    function excluirfisioterapiatemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->excluirexametemp($agenda_exames_id);
        $this->carregarpacientefisioterapiatemp($pacientetemp_id);
    }

    function gravar() {
        $exametemp_tuss_id = $this->exametemp->gravar();
        if ($exametemp_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exametemp");
    }

    function excluirpaciente($paciente_id) {
        $pacienteexame = $this->exametemp->contadorpacienteexame($paciente_id);
        $pacienteagendaexame = $this->exametemp->contadorpaciente($paciente_id);
        $pacienteguia = $this->exametemp->contadorpacienteguia($paciente_id);
        $pacienteconsulta = $this->exametemp->contadorpacienteconsulta($paciente_id);
        $pacientelaudo = $this->exametemp->contadorpacientelaudo($paciente_id);
        if ($pacienteexame != 0 || $pacienteagendaexame != 0 || $pacienteguia != 0 || $pacienteconsulta != 0 || $pacientelaudo != 0) {
            $data['mensagem'] = 'Erro ao excluir o Paciente. Favor verificar pendencias';
        } else {
            $verifica = $this->exametemp->excluirpaciente($paciente_id);
            if ($verifica == "-1") {
                $data['mensagem'] = 'Erro ao excluir o Paciente. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao excluir o Paciente.';
            }
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes");
    }

    function gravartemp() {
        $ambulatorio_pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarexames($ambulatorio_pacientetemp_id);
        $this->carregarexametemp($ambulatorio_pacientetemp_id);
    }

    function gravarpacienteexametemp($agenda_exames_id) {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
        } else {
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                $this->carregarpacientetemp($paciente_id);
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
            }
        }
    }

    function gravarpacienteexametempgeral($agenda_exames_id) {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
        } else {
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                $this->carregarpacientetempgeral($paciente_id);
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncaogeral");
            }
        }
    }

    function gravarpacienteconsultatemp($agenda_exames_id) {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $data['medico'] = $this->exametemp->listarmedicoconsulta();
            $paciente_id = $this->exametemp->gravarpacienteconsultas($agenda_exames_id);
            if ($paciente_id != 0) {
                $this->carregarpacienteconsultatemp($paciente_id);
            } else {
                $data['mensagem'] = 'Erro ao marcar consulta o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncaoconsulta");
            }
        }
    }

    function gravarpacientefisioterapiatemp($agenda_exames_id) {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $data['medico'] = $this->exametemp->listarmedicoconsulta();
            
            if (isset($_POST['sessao'])){
                echo "<pre>";
                $data['agenda_selecionada'] = $this->exametemp->listaagendafisioterapia($agenda_exames_id);
                $data['horarios_livres'] = $this->exametemp->listadisponibilidadefisioterapia($data['agenda_selecionada'][0]);
                $tothorarios = count($data['horarios_livres']);
                $_POST['sessao'] = (int) $_POST['sessao']; 
            }
            
            if(isset($_POST['sessao']) && $tothorarios < $_POST['sessao']){
                
                $data['mensagem'] = "Não há horarios suficientes na agenda para o numero de sessoes escolhido";
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
                
            } else {
                $paciente_id = $this->exametemp->gravarpacientefisioterapia($agenda_exames_id);
                $this->carregarpacientefisioterapiatemp($paciente_id);
            }
        }
    }

    function reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data) {
        $paciente_id = $this->exametemp->reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data);
        $this->carregarpacientetemp($paciente_id);
    }

    function reservartempgeral($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data) {
        $paciente_id = $this->exametemp->reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data);
        $this->carregarpacientetempgeral($paciente_id);
    }

    function reservarconsultatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        $paciente_id = $this->exametemp->reservarconsultatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data);
        $this->carregarpacienteconsultatemp($paciente_id);
    }

    function reservarfisioterapiatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        $paciente_id = $this->exametemp->reservarfisioterapiatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data);
        $this->carregarpacientefisioterapiatemp($paciente_id);
    }

    function gravarpacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarexames($pacientetemp_id);
        $this->carregarpacientetemp($pacientetemp_id);
    }

    function gravarpacientetempgeral() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarpacienteexistentegeral($pacientetemp_id);
        $this->carregarpacientetempgeral($pacientetemp_id);
    }

    function gravarconsultapacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarconsultaspacienteexistente($pacientetemp_id);
        $this->carregarpacienteconsultatemp($pacientetemp_id);
    }

    function gravarfisioterapiapacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarfisioterapiapacienteexistente($pacientetemp_id);
        $this->carregarpacientefisioterapiatemp($pacientetemp_id);
    }

    function gravarpaciente() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
        } else {
            $agenda_exames_id = $_POST['horarios'];
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                $this->carregarpacientetemp($paciente_id);
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
            }
        }
    }

    function gravarpacienteconsulta() {
        if ((trim($_POST['txtNome']) == "") || (trim($_POST['convenio']) == "0")) {
            $mensagem = 'Erro ao marcar consulta é obrigatorio nome do Paciente e Convenio.';
            $this->session->set_flashdata('message', $mensagem);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $pacientetemp_id = $this->paciente->gravarpacientetemp();
            $this->exametemp->gravarconsultas($pacientetemp_id);
            $this->carregarpacienteconsultatemp($pacientetemp_id);
        }
    }

    function gravarpacientefisioterapia() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapia");
        } else {
            $pacientetemp_id = $this->paciente->gravarpacientetemp();
            $this->exametemp->gravarfisioterapia($pacientetemp_id);
            $this->carregarpacientefisioterapiatemp($pacientetemp_id);
        }
    }

    function gravarpacienteconsultaencaixe() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $pacientetemp_id = $this->exametemp->gravarconsultasencaixe();
            $this->carregarpacienteconsultatemp($pacientetemp_id);
        }
    }

    function gravarpacienteexameencaixe() {
        if (trim($_POST['txtNome']) == "" || $_POST['convenio1'] == "-1") {
            $data['mensagem'] = 'Erro. Obrigatório Convenio e nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
            redirect(base_url() . "ambulatorio/exametemp/novopacienteexameencaixe");
        } else {
            $pacientetemp_id = $this->exametemp->gravarexameencaixe();
            $this->carregarpacientetemp($pacientetemp_id);
        }
    }

    function gravarpacienteencaixegeral() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteencaixegeral");
        } else {
            $pacientetemp_id = $this->exametemp->gravarexameencaixegeral();
            $this->carregarpacientetempgeral($pacientetemp_id);
        }
    }

    function gravarhorarioexameencaixe() {
        $this->exametemp->gravarhorarioencaixe();
        redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
    }

    function gravarhorarioexameencaixegeral() {
        $this->exametemp->gravarhorarioencaixegeral();
        redirect(base_url() . "ambulatorio/exame/listarmultifuncaogeral");
    }

    function gravarpacientefisioterapiaencaixe() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $pacientetemp_id = $this->exametemp->gravarfisioterapiaencaixe();
            $this->carregarpacientefisioterapiatemp($pacientetemp_id);
        }
    }

    function gravapacienteconsultaencaixe() {
        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravaconsultasencaixe($pacientetemp_id);
        $this->carregarpacienteconsultatemp($pacientetemp_id);
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

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
