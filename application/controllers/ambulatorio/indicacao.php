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
class Indicacao extends BaseController {

    function Indicacao() {
        parent::Controller();
        $this->load->model('ambulatorio/indicacao_model', 'indicacao');
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

        $this->loadView('ambulatorio/indicacao-lista', $args);

//            $this->carregarView($data);
    }

    function carregarindicacao($exame_indicacao_id) {
        $obj_indicacao = new indicacao_model($exame_indicacao_id);
        $data['obj'] = $obj_indicacao;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/indicacao-form', $data);
        $this->loadView('ambulatorio/indicacao-form', $data);
    }

    function excluir($exame_indicacao_id) {
        if ($this->procedimento->excluir($exame_indicacao_id)) {
            $mensagem = 'Sucesso ao excluir a Indicacao';
        } else {
            $mensagem = 'Erro ao excluir a indicacao. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/indicacao");
    }

    function gravar() {
        $exame_indicacao_id = $this->indicacao->gravar();
        if ($exame_indicacao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Indicacao. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Indicacao.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/indicacao");
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
