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
class Agenda extends BaseController {

    function Agenda() {
        parent::Controller();
        $this->load->model('ambulatorio/agenda_model', 'agenda');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('seguranca/operador_model', 'operador_m');
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
        $this->loadView('ambulatorio/agenda-lista', $data);

//            $this->carregarView($data);
    }

    function listarhorarioagenda($agenda) {
        $data['agenda'] = $agenda;
        $data['lista'] = $this->agenda->listarhorarioagenda($agenda);
        $data['lista_agenda'] = $this->exame->listaragendacriada($agenda);
//        echo "<pre>";
//        var_dump($agenda);die;
        $this->loadView('ambulatorio/horarioagenda-lista', $data);
    }

    function medicoagendageral() {
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/medicoagendageral-form', $data);
    }
    
    function medicoagenda() {
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/medicoagenda-form', $data);
    }

    function medicoagendaconsulta() {
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/medicoagendaconsulta-form', $data);
    }
    
    function medicoagendaespecialidade() {
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/medicoagendaespecialidade-form', $data);
    }

    function virada() {

        $this->loadView('ponto/virada-tipo');

//            $this->carregarView($data);
    }
    
    function editaragendacriada($agenda_id) {
        $data['horario_id'] = $agenda_id;
        $data['horarios'] = $this->agenda->listarhorariosagendacriada($agenda_id);
        $data['horarios_consolidados'] = $this->agenda->listarhorariosagendacriadaconsolidados($agenda_id);
        $this->loadView('ambulatorio/editaragendacriada-form',$data );
    }
    
    function carregarexclusaohorario($horariovariavel_id, $horariotipo) {
//        var_dump($horariotipo); die;
        $data['horariotipo'] = $horariotipo;
        $data['horariovariavel_id'] = $horariovariavel_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['lista'] = $this->agenda->listarhorarioagendaexclusao($horariovariavel_id);
        $this->loadView('ambulatorio/agendaexclusaohorario-form',$data );
//        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "ambulatorio/agenda/listarhorarioagenda/$horariotipo");
    }
    function carregarexclusaoagenda($agenda_id) {
//        var_dump($agenda_id); die;
        $data['agenda_id'] = $agenda_id;
//        $data['horariovariavel_id'] = $horariovariavel_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['lista'] = $this->agenda->listaragendaexclusao($agenda_id);
//        var_dump($data['lista']); die;
        $this->loadView('ambulatorio/agendaexclusao-form',$data );
//        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "ambulatorio/agenda/listarhorarioagenda/$horariotipo");
    }

    function excluiragendascriadas($agenda_id) {
        if ( $this->agenda->excluiragendascriadas() ) {
            $mensagem = 'Sucesso ao excluir as agendas.';
        } else {
            $mensagem = 'Erro ao excluir as agendas. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/agenda/listarhorarioagenda/$agenda_id");
    }

    function excluirhorarioagendaconsolidada($agenda_id) {
        if ( $this->agenda->excluirhorarioagendaconsolidada($agenda_id) ) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        
        $parametro = "";
        foreach ($_GET as $key => $value) {
            $value = str_replace(" ", "+", $value);
            $parametro .= $key . "=" . $value . "&";
        }
        
        $this->session->set_flashdata('message', $data['mensagem']);
//        var_dump($parametro); die;
        
        redirect(base_url() . "ambulatorio/agenda/editaragendacriada/$agenda_id?".$parametro);
    }

    function excluirhorarioagendacriada($agenda_id) {
        if ( $this->agenda->excluirhorarioagendacriada($agenda_id) ) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        
        $parametro = "";
        foreach ($_GET as $key => $value) {
            $value = str_replace(" ", "+", $value);
            $parametro .= $key . "=" . $value . "&";
        }
        
        $this->session->set_flashdata('message', $data['mensagem']);
//        var_dump($parametro); die;
        
        redirect(base_url() . "ambulatorio/agenda/editaragendacriada/$agenda_id?".$parametro);
    }

    function excluirhorarioagendaeditada($horario_id) {
//        var_dump($_POST); die;
        if ( $this->agenda->excluirhorarioagendaeditada($horario_id) ) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }
    
    
    function excluirhorarioagenda($horariovariavel_id, $horariotipo) {
//        var_dump($_POST); die;
        if ($this->agenda->excluirhorariofixo($horariovariavel_id)) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/agenda/listarhorarioagenda/$horariotipo");
    }

    function carregar($agenda_id) {
        $obj_agenda = new agenda_model($agenda_id);
        $data['obj'] = $obj_agenda;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/agenda-form', $data);
    }

    function excluir($agenda_id) {
        if ($this->agenda->excluir($agenda_id)) {
            $mensagem = 'Sucesso ao excluir o Agenda';
        } else {
            $mensagem = 'Erro ao excluir o Agenda. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/agenda");
    }

    function gravar() {
        $agenda_id = $this->agenda->gravar();
        if ($agenda_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Agenda. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Agenda.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/agenda/listarhorarioagenda/" . $agenda_id);
    }

    function gravarmedicogeral() {
        $agenda_id = $this->agenda->gravarmedicogeral();
        if ($agenda_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Medico. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Medico.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
    }
    
    function gravarmedico() {
        $agenda_id = $this->agenda->gravarmedico();
        if ($agenda_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Medico. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Medico.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
    }

    function gravarmedicoconsulta() {
        $agenda_id = $this->agenda->gravarmedicoconsulta();
        if ($agenda_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Medico. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Medico.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarmultifuncaoconsulta");
    }
    
    function gravarmedicoespecialidade() {
//         echo 'especialidade';
//        die;
        $agenda_id = $this->agenda->gravarmedicoespecialidade();
        if ($agenda_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Medico. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Medico.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exame/listarmultifuncaoconsulta");
    }

    function viradahorariofixo() {

        $competencia = $this->competencia->listaAtiva();

        $todosfixos = $this->agenda->listartotalhoariofixo();

        foreach ($todosfixos as $value) {

            $horario = $this->agenda->listarhorariofixo($value->agenda_id);
            foreach ($horario as $item) {

                for ($index = $competencia[0]->data_abertura; $index <= $competencia[0]->data_fechamento; $index = date('Y-m-d', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime("$index"));

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

                    if ($data == substr($item->dia, 4)) {

                        $this->agenda->gravarviradahorariovariavel($item, $index, $value->agenda_id);
                    }
                }
            }
        }

        $this->loadView('ponto/virada-tipo');
    }

    function novohorarioagendacriada($agenda_id) {
        $data['agenda_id'] = $agenda_id;
        $data['empresas'] = $this->agenda->listarempresa();
        $data['horarios'] = $this->agenda->listarhorarioagendaeditadas($agenda_id);
        $this->loadView('ambulatorio/horarioagendacriada-form', $data);
    }

    function novohorarioagenda($agenda_id) {
        $data['agenda_id'] = $agenda_id;
        $data['empresas'] = $this->agenda->listarempresa();
        $this->loadView('ambulatorio/horarioagenda-form', $data);
    }
    
    function gravarhorarioagenda() {
        $horariotipo = $_POST['txtagendaID'];
        if ($this->agenda->gravarhorariofixo()) {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
//        die;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/agenda/listarhorarioagenda/$horariotipo");
    }

    function gravarhorarioagendacriada($agenda_id) {
        
        if ($this->agenda->gravarhorarioagendacriada($agenda_id)) {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        
        $parametro = "nome=" . $_POST['nome_agenda'] . "&" . "medico_id=" . $_POST['medico_id'];
        
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/agenda/novohorarioagendacriada/$agenda_id?".$parametro);
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
