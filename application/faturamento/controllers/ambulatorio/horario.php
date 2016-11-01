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
class Horario extends BaseController {

    function Horario() {
        parent::Controller();
        $this->load->model('ambulatorio/horario_model', 'horario');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('ambulatorio/sala_model', 'sala');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/horario-lista', $args);

//            $this->carregarView($data);
    }

    function listarhorariolivro($horario) {
        $data['horario'] = $horario;
        $data['nome'] = $this->horario->listarhorarionome($horario);
        $data['lista'] = $this->horario->listarhorariolivro($horario);

        $this->loadView('ambulatorio/horariolivro-lista', $data);
    }

    function medicohorario() {
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/medicohorario-form', $data);
    }

    function virada() {

        $this->loadView('ponto/virada-tipo');

//            $this->carregarView($data);
    }

    function excluirhorariohorario($horariovariavel_id, $horariotipo) {
        if ($this->horario->excluirhorariofixo($horariovariavel_id)) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/horario/listarhorariohorario/$horariotipo");
    }

    function carregar($horario_id) {
        $obj_horario = new horario_model($horario_id);
        $data['obj'] = $obj_horario;
        $data['salas'] = $this->sala->listarsalas();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/horario-form', $data);
    }

    function excluir($horario_id) {
        if ($this->horario->excluir($horario_id)) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/horario");
    }

    function gravar() {
        $horario_id = $this->horario->gravar();
        if ($horario_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/horario/listarhorariolivro/$horario_id");
    }

    function gravarmedico() {
        $horario_id = $this->horario->gravarmedico();
        if ($horario_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Medico. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Medico.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/horario");
    }

    function viradahorariofixo() {

        $competencia = $this->competencia->listaAtiva();

        $todosfixos = $this->horario->listartotalhoariofixo();

        foreach ($todosfixos as $value) {

            $horario = $this->horario->listarhorariofixo($value->horario_id);
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

                        $this->horario->gravarviradahorariovariavel($item, $index, $value->horario_id);
                    }
                }
            }
        }

        $this->loadView('ponto/virada-tipo');
    }

    function novohorariohorario($horario_id) {
        $data['horario_id'] = $horario_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('ambulatorio/horariolivro-form', $data);
    }

    function gravarhorariohorario() {
        $horariotipo = $_POST['txthorarioID'];
        if ($this->horario->gravarhorariofixo()) {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/horario/listarhorariohorario/$horariotipo");
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
