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
class Empresa extends BaseController {

    function Empresa() {
        parent::Controller();
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/empresa-lista', $args);

//            $this->carregarView($data);
    }

    function carregarempresa($exame_empresa_id) {
        $obj_empresa = new empresa_model($exame_empresa_id);
        $data['obj'] = $obj_empresa;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/empresa-form', $data);
    }

    function excluir($exame_empresa_id) {
        if ($this->procedimento->excluir($exame_empresa_id)) {
            $mensagem = 'Sucesso ao excluir a Empresa';
        } else {
            $mensagem = 'Erro ao excluir a empresa. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function gravar() {
        $empresa_id = $this->empresa->gravar();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Empresa. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Empresa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function ativar($exame_empresa_id) {
        $this->empresa->ativar($exame_empresa_id);
            $data['mensagem'] = 'Sucesso ao ativar a Empresa.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
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
