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
class Modelodeclaracao extends BaseController {

    function Modelodeclaracao() {
        parent::Controller();
        $this->load->model('ambulatorio/modelodeclaracao_model', 'modelodeclaracao');
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

        $this->loadView('ambulatorio/modelodeclaracao-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmodelodeclaracao($exame_modelo_declaracao_id) {
        $obj_modelo_declaracao = new modelodeclaracao_model($exame_modelo_declaracao_id);
        $data['obj'] = $obj_modelo_declaracao;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->load->View('ambulatorio/modelodeclaracao-form', $data);
    }

    function excluir($exame_modelolaudo_id) {
        if ($this->procedimento->excluir($exame_modelolaudo_id)) {
            $mensagem = 'Sucesso ao excluir a Modelolaudo';
        } else {
            $mensagem = 'Erro ao excluir a modelolaudo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelolaudo");
    }

    function gravar() {
        $exame_modelo_declaracao_id = $this->modelodeclaracao->gravar();
        if ($exame_modelo_declaracao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelolaudo. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelolaudo.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelodeclaracao");
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
