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
class Armazem extends BaseController {

    function Armazem() {
        parent::Controller();
        $this->load->model('estoque/armazem_model', 'armazem');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/armazem-lista', $args);

//            $this->carregarView($data);
    }

    function carregararmazem($estoque_armazem_id) {
        $obj_armazem = new armazem_model($estoque_armazem_id);
        $data['obj'] = $obj_armazem;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('estoque/armazem-form', $data);
    }

    function armazemtransferencia() {

        $data['armazem'] = $this->armazem->listararmazem();
        $data['produto'] = $this->armazem->listarproduto();
        $this->loadView('estoque/transferencia-form', $data);
    }

    function excluir($estoque_armazem_id) {
        $valida = $this->armazem->excluir($estoque_armazem_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Armazem';
        } else {
            $data['mensagem'] = 'Erro ao excluir a armazem. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/armazem");
    }

    function gravartransferencia() {
//        var_dump($_POST);
//        die;
        $exame_armazem_id = $this->armazem->gravartransferencia();
        if ($exame_armazem_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar transferência. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Transferência.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/armazem");
    }

    function gravar() {
        $exame_armazem_id = $this->armazem->gravar();
        if ($exame_armazem_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Armazem. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Armazem.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/armazem");
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
