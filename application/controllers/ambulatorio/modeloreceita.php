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
class Modeloreceita extends BaseController {

    function Modeloreceita() {
        parent::Controller();
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/modeloreceita_model', 'modeloreceita');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/modeloreceita-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmodeloreceita($exame_modeloreceita_id) {
        $obj_modeloreceita = new modeloreceita_model($exame_modeloreceita_id);
        $data['obj'] = $obj_modeloreceita;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modeloreceita-form', $data);
        $this->load->View('ambulatorio/modeloreceita-form', $data);
    }

    function ativarmodeloreceitaautomatico($modeloreceita_id) {
        $this->modeloreceita->ativarmodeloreceitaautomatico($modeloreceita_id);
        redirect(base_url() . "ambulatorio/modeloreceita");
    }

    function desativarmodeloreceitaautomatico($modeloreceita_id) {
        $this->modeloreceita->desativarmodeloreceitaautomatico($modeloreceita_id);
        redirect(base_url() . "ambulatorio/modeloreceita");
    }

    function excluir($exame_modeloreceita_id) {
        if ($this->procedimento->excluir($exame_modeloreceita_id)) {
            $mensagem = 'Sucesso ao excluir a Modeloreceita';
        } else {
            $mensagem = 'Erro ao excluir a modeloreceita. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modeloreceita");
    }

    function gravar() {
        $exame_modeloreceita_id = $this->modeloreceita->gravar();
        if ($exame_modeloreceita_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modeloreceita. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modeloreceita.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modeloreceita");
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
