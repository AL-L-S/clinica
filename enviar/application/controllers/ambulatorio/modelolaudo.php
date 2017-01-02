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
class Modelolaudo extends BaseController {

    function Modelolaudo() {
        parent::Controller();
        $this->load->model('ambulatorio/modelolaudo_model', 'modelolaudo');
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

        $this->loadView('ambulatorio/modelolaudo-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmodelolaudo($exame_modelolaudo_id) {
        $obj_modelolaudo = new modelolaudo_model($exame_modelolaudo_id);
        $data['obj'] = $obj_modelolaudo;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelolaudo-form', $data);
        $this->load->View('ambulatorio/modelolaudoteste-form', $data);
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
        $exame_modelolaudo_id = $this->modelolaudo->gravar();
        if ($exame_modelolaudo_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelolaudo. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelolaudo.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelolaudo");
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
