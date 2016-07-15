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
class Modelolinha extends BaseController {

    function Modelolinha() {
        parent::Controller();
        $this->load->model('ambulatorio/modelolinha_model', 'modelolinha');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/modelolinha-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmodelolinha($exame_modelolinha_id) {
        $obj_modelolinha = new modelolinha_model($exame_modelolinha_id);
        $data['obj'] = $obj_modelolinha;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->load->View('ambulatorio/modelolinha-form', $data);
    }

    function excluir($exame_modelolinha_id) {
        if ($this->procedimento->excluir($exame_modelolinha_id)) {
            $mensagem = 'Sucesso ao excluir a Modelolinha';
        } else {
            $mensagem = 'Erro ao excluir a modelolinha. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelolinha");
    }

    function gravar() {
        $exame_modelolinha_id = $this->modelolinha->gravar();
        if ($exame_modelolinha_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelolinha. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelolinha.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelolinha");
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
