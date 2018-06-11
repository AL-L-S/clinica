<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta sub_classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Subclasse extends BaseController {

    function Subclasse() {
        parent::Controller();
        $this->load->model('farmacia/subclasse_model', 'sub_classe');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('farmacia/subclasse-lista', $args);

//            $this->carregarView($data);
    }

    function carregarsubclasse($farmacia_sub_classe_id) {
        $obj_sub_classe = new subclasse_model($farmacia_sub_classe_id);
        $data['obj'] = $obj_sub_classe;
        $data['classe'] = $this->sub_classe->listartipo();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('farmacia/subclasse-form', $data);
    }

    function excluir($farmacia_sub_classe_id) {
        $valida = $this->sub_classe->excluir($farmacia_sub_classe_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Sub-Classe';
        } else {
            $data['mensagem'] = 'Erro ao excluir a sub_classe. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/subclasse");
    }

    function gravar() {
        $exame_sub_classe_id = $this->sub_classe->gravar();
        if ($exame_sub_classe_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Sub-Classe. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Sub-Classe.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/subclasse");
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
