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
class Motivocancelamento extends BaseController {

    function Motivocancelamento() {
        parent::Controller();
        $this->load->model('ambulatorio/motivocancelamento_model', 'motivocancelamento');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/motivocancelamento-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmotivocancelamento($estoque_motivocancelamento_id) {
        $obj_motivocancelamento = new motivocancelamento_model($estoque_motivocancelamento_id);
        $data['obj'] = $obj_motivocancelamento;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/motivocancelamento-form', $data);
    }

    function excluir($estoque_motivocancelamento_id) {
        $valida = $this->motivocancelamento->excluir($estoque_motivocancelamento_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Motivocancelamento';
        } else {
            $data['mensagem'] = 'Erro ao excluir a motivocancelamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/motivocancelamento");
    }

    function gravar() {
        $exame_motivocancelamento_id = $this->motivocancelamento->gravar();
        if ($exame_motivocancelamento_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Motivocancelamento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Motivocancelamento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/motivocancelamento");
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
