<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta fornecedor é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Fornecedor extends BaseController {

    function Fornecedor() {
        parent::Controller();
        $this->load->model('cadastro/fornecedor_model', 'fornecedor');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/fornecedor-lista', $args);

//            $this->carregarView($data);
    }

    function carregarfornecedor($financeiro_credor_devedor_id) {
        $obj_fornecedor = new fornecedor_model($financeiro_credor_devedor_id);
        $data['obj'] = $obj_fornecedor;
        $data['tipo'] = $this->fornecedor->listartipo();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/fornecedor-form', $data);
    }

    function excluir($financeiro_credor_devedor_id) {
        $valida = $this->fornecedor->excluir($financeiro_credor_devedor_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Fornecedor';
        } else {
            $data['mensagem'] = 'Erro ao excluir a fornecedor. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/fornecedor");
    }

    function gravar() {
        $exame_fornecedor_id = $this->fornecedor->gravar();
        if ($exame_fornecedor_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Fornecedor. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Fornecedor.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/fornecedor");
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
