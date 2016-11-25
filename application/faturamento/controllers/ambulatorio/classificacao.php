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
class Classificacao extends BaseController {

    function Classificacao() {
        parent::Controller();
        $this->load->model('ambulatorio/classificacao_model', 'classificacao');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/classificacao-lista', $args);

//            $this->carregarView($data);
    }

    function carregarclassificacao($tuss_classificacao_id) {
        $obj_classificacao = new classificacao_model($tuss_classificacao_id);
        $data['obj'] = $obj_classificacao;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/classificacao-form', $data);
    }

    function excluir($tuss_classificacao_id) {
        if ($this->procedimento->excluir($tuss_classificacao_id)) {
            $mensagem = 'Sucesso ao excluir a Classificacao';
        } else {
            $mensagem = 'Erro ao excluir a classificacao. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/classificacao");
    }

    function gravar() {
        $tuss_classificacao_id = $this->classificacao->gravar();
        if ($tuss_classificacao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Classificacao. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Classificacao.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/classificacao");
    }

    function ativar($tuss_classificacao_id) {
        $this->classificacao->ativar($tuss_classificacao_id);
            $data['mensagem'] = 'Sucesso ao ativar a Classificacao.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/classificacao");
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
