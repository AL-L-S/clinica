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
class Unidade extends BaseController {

    function Unidade() {
        parent::Controller();
        $this->load->model('farmacia/unidade_model', 'unidade');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('farmacia/unidade-lista', $args);

//            $this->carregarView($data);
    }

    function carregarunidade($farmacia_unidade_id) {
        $obj_unidade = new unidade_model($farmacia_unidade_id);
        $data['obj'] = $obj_unidade;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('farmacia/unidade-form', $data);
    }

    function excluir($farmacia_unidade_id) {
        $valida = $this->unidade->excluir($farmacia_unidade_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Unidade';
        } else {
            $data['mensagem'] = 'Erro ao excluir a unidade. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/unidade");
    }

    function gravar() {
        $exame_unidade_id = $this->unidade->gravar();
        if ($exame_unidade_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Unidade. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Unidade.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/unidade");
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
