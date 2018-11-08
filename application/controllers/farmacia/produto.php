<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta produto é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Produto extends BaseController {

    function Produto() {
        parent::Controller();
        $this->load->model('farmacia/produto_model', 'produto');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('farmacia/produto-lista', $args);

//            $this->carregarView($data);
    }

    function carregarproduto($farmacia_produto_id) {
        $obj_produto = new produto_model($farmacia_produto_id);
        $data['obj'] = $obj_produto;
        $data['sub'] = $this->produto->listarsub();
        $data['unidade'] = $this->produto->listarunidade();
        $data['procedimentos'] = $this->produto->listarprocedimentos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('farmacia/produto-form', $data);
    }

    function barra() {
        $this->load->View('farmacia/barra');
    }

    function excluir($farmacia_produto_id) {
        $valida = $this->produto->excluir($farmacia_produto_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Produto';
        } else {
            $data['mensagem'] = 'Erro ao excluir a produto. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/produto");
    }

    function gravar() {
        $exame_produto_id = $this->produto->gravar();
        if ($exame_produto_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Produto. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Produto.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/produto");
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
