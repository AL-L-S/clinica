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
class Tipo extends BaseController {

    function Tipo() {
        parent::Controller();
        $this->load->model('estoque/tipo_model', 'tipo');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/tipo-lista', $args);

//            $this->carregarView($data);
    }

    function carregartipo($estoque_tipo_id) {
        $obj_tipo = new tipo_model($estoque_tipo_id);
        $data['obj'] = $obj_tipo;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('estoque/tipo-form', $data);
    }

    function excluir($estoque_tipo_id) {
        $valida = $this->tipo->excluir($estoque_tipo_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Tipo';
        } else {
            $data['mensagem'] = 'Erro ao excluir a tipo. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/tipo");
    }

    function gravar() {
        $exame_tipo_id = $this->tipo->gravar();
        if ($exame_tipo_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Tipo. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Tipo.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/tipo");
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
