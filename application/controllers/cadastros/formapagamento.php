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
class Formapagamento extends BaseController {

    function Formapagamento() {
        parent::Controller();
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/formapagamento-lista', $args);

//            $this->carregarView($data);
    }

    function carregarformapagamento($formapagamento_id) {
        $obj_formapagamento = new formapagamento_model($formapagamento_id);
        $data['obj'] = $obj_formapagamento;
        $data['conta'] = $this->forma->listarforma();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/formapagamento-form', $data);
    }

    function excluir($formapagamento_id) {
        $valida = $this->formapagamento->excluir($formapagamento_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento");
    }

    function gravar() {
        $exame_formapagamento_id = $this->formapagamento->gravar();
        if ($exame_formapagamento_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Forma. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Forma.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento");
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
