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
        $this->load->model('ambulatorio/laudo_model', 'laudo');
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
        
        if ($_POST['paciente_id'] == $_POST['pacienteid']) {
            $data['mensagem'] = 'Erro ao unificar. Você está tentando unificar ';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
        }

        if ($_POST['txtpaciente'] == '' || $_POST['pacienteid'] == '') {
            $data['mensagem'] = 'Paciente que sera unificado nao informado ou invalido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
        } else {
            $verifica = $this->exametemp->gravarunificacao();
            if ($verifica == "-1") {
                $data['mensagem'] = 'Erro ao unificar Paciente. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao unificar Paciente.';
            }
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
        }
    }

    function carregarpacientetempgeral($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['exames'] = $this->exametemp->listaragendatotalpacientegeral($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarprocedimentosanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarprocedimentoanteriorcontador($pacientetemp_id);


        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepacientetempgeral-form', $data);
    }

    function carregarpacientetemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorpaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpaciente($pacientetemp_id);
        $data['examesanteriores'] = $this->exametemp->listarexameanterior($pacientetemp_id);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepacientetemp-form', $data);
    }

    function carregarpacienteconsultatemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

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

    function carregarpacientefisioterapiatemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['contador'] = $this->exametemp->contadorfisioterapiapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapia($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarespecialidadeanterior($pacientetemp_id);
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
        $agenda_id = $_POST['agendaid'];
        if (trim($_POST['convenio1']) == "-1") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar o convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexame/$agenda_id");
        } elseif (trim($_POST['procedimento1']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar o procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexame/$agenda_id");
        } else {
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$paciente_id");
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
            }
        }
    }

    function gravarpacienteexametempgeral($agenda_exames_id) {
//        $agenda = $_POST['agendaid'];
        $medico = $_POST['medico'];
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
        } elseif (trim($_POST['txtNomeid']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta. Selecione um paciente válido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral3/$agenda_exames_id");
        } elseif (trim($_POST['telefone']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta. Selecione um paciente válido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral3/$agenda_exames_id");
        } elseif (trim($_POST['convenio1']) == "-1") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio seleionar um convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral3/$agenda_exames_id");
        } elseif (trim($_POST['procedimento1']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar um procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral3/$agenda_exames_id");
        } else {
            $tipo = $this->exametemp->tipomultifuncaogeral($_POST['procedimento1']);
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id, $tipo[0]->tipo);
            if ($paciente_id != 0) {
                redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$paciente_id");
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncaogeral");
            }
        }
    }

    function gravarpacienteconsultatemp($agenda_exames_id) {
        if (trim($_POST['txtNome']) == "" && trim($_POST['txtNomeid']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } 
        elseif (trim($_POST['convenio']) == "0" ) {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio informar o convênio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } 
        
        elseif (trim($_POST['procedimento']) == "" ) {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio informar o procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } 
        else {
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
        if (trim($_POST['txtNome']) == "" && trim($_POST['txtNomeid']) == "") {
            $data['mensagem'] = 'Erro ao marcar especialidade é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } elseif ($_POST['convenio'] == '0') {
            $data['mensagem'] = 'Erro ao marcar especialidade. Selecione um convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } elseif ($_POST['procedimento'] == '') {
            $data['mensagem'] = 'Erro ao marcar especialidade. Selecione um procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        }  else {

            $data['medico'] = $this->exametemp->listarmedicoconsulta();

            if (isset($_POST['sessao'])) {
                $data['agenda_selecionada'] = $this->exametemp->listaagendafisioterapia($agenda_exames_id);
                $contaHorarios = count($this->exametemp->contadordisponibilidadefisioterapia($data['agenda_selecionada'][0]));

                //tratando o numero que veio nas sessoes
                if ($_POST['sessao'] == '' || $_POST['sessao'] == null || $_POST['sessao'] == 'null' || $_POST['sessao'] == 0) {
                    $_POST['sessao'] = 1;
                }
                $_POST['sessao'] = (int) $_POST['sessao'];

                //pegando os dias da semana disponiveis
                $diaSemana = date("Y-m-d", strtotime($data['agenda_selecionada'][0]->data));
                $contador = 0;

                //definindo array que recebera os selects
                $horarios_livres = array();

                //definindo array que tera os valores filtrados de $horarios_livres
                $data['horarios_livres'] = array();

                do {
                    $horarios_livres = $this->exametemp->listadisponibilidadefisioterapia($data['agenda_selecionada'][0], $diaSemana);
                    $diaSemana = date("Y-m-d", strtotime("+1 week", strtotime($diaSemana)));
                    $contador++;

                    //verificando se a busca veio vazia, caso nao, adciona essa busca a $data['horarios_livres']
                    if (count($horarios_livres) != 0) {
                        $data['horarios_livres'][] = $horarios_livres[0];
                    }
                } while ($contador < $contaHorarios);

                //limpando o array
                $data['horarios_livres'] = array_filter($data['horarios_livres']);

                //testando se ha disponibilidade de horario para todas as sessoes
                $tothorarios = count($data['horarios_livres']);

                if ($tothorarios < $_POST['sessao']) {
                    $data['mensagem'] = "Não há horarios suficientes na agenda para o numero de sessoes escolhido";
                    $this->session->set_flashdata('message', $data['mensagem']);
                    redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
                }

                $_POST['txtNomeid'] = $this->exametemp->crianovopacienteespecialidade();

                //marcando sessoes
                if ($_POST['sessao'] == 1) {
                    $paciente_id = $this->exametemp->gravarpacientefisioterapia($data['agenda_selecionada'][0]->agenda_exames_id);
                } else {
                    for ($i = 0; $i < $_POST['sessao']; $i++) {
                        $paciente_id = $this->exametemp->gravarpacientefisioterapia($data['horarios_livres'][$i]->agenda_exames_id);
                    }
                }

                $this->carregarpacientefisioterapiatemp($paciente_id);
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

        if ($_POST['txtNome'] == '' || $_POST['data_ficha'] == '' || $_POST['exame'] == '' || $_POST['convenio1'] == '' || $_POST['procedimento1'] == '' || $_POST['horarios'] == '') {
            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
        } else {
            $this->exametemp->gravarpacienteexistentegeral($pacientetemp_id);
            $this->carregarpacientetempgeral($pacientetemp_id);
        }
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
        if (trim($_POST['procedimento']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar um procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } 
        elseif (trim($_POST['convenio']) == "0") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar um convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        }
        elseif (trim($_POST['txtNomeid']) == "" && trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir um Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        }
        else {
            $pacientetemp_id = $this->exametemp->gravarconsultasencaixe();

            //enviar email
            $texto = "Consulta agendada para o dia " . $_POST['data_ficha'] . ", com início às " . $_POST['horarios'] . ".";
            $email = $this->laudo->email($pacientetemp_id);
            if (isset($email)) {
                $this->email($email, $texto);
            }
            //fim eviafr email

            $this->carregarpacienteconsultatemp($pacientetemp_id);
        }
    }

    function email($email, $texto) {
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
        $config['smtp_pass'] = 'DUCOCOFRUTOPCE';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'text';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $this->email->initialize($config);

        $this->email->from('equipe2016gcjh@gmail.com', 'STG Saúde');
        $this->email->to($email);
        $this->email->subject('Consulta Agendada');
        $this->email->message($texto);
        $this->email->send();
//    echo $this->email->print_debugger();
    }

    function gravarpacienteexameencaixe() {
        if (trim($_POST['txtNome']) == "" || $_POST['convenio1'] == "-1") {
            $data['mensagem'] = 'Erro. Obrigatório Convenio e nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
            redirect(base_url() . "ambulatorio/exametemp/novopacienteexameencaixe");
        } else {
            $pacientetemp_id = $this->exametemp->gravarexameencaixe();
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$pacientetemp_id");
        }
    }

    function gravarpacienteencaixegeral() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteencaixegeral");
        } else {
            $pacientetemp_id = $this->exametemp->gravarexameencaixegeral();
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
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
        if (trim($_POST['txtNomeid']) == "" && trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir um Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } 
        elseif (trim($_POST['convenio']) == "0") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir o covenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } 
        elseif (trim($_POST['procedimento']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir o procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } 
        else {
//            die;
            $disponibilidade = $this->exametemp->contadorhorariosdisponiveisfisioterapia($_POST['data_ficha'], $_POST['horarios'], $_POST['medico']);
            if ($disponibilidade == 0) {
                $pacientetemp_id = $this->exametemp->gravarfisioterapiaencaixe();
                $this->carregarpacientefisioterapiatemp($pacientetemp_id);
            } else {
                $data['mensagem'] = 'Erro ao marcar consulta. Este horário já está agendado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
            }
        }
    }

    function gravapacienteconsultaencaixe() {
        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravaconsultasencaixe($pacientetemp_id);
        $this->carregarpacienteconsultatemp($pacientetemp_id);
    }

    private
            function carregarView($data = null, $view = null) {
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
