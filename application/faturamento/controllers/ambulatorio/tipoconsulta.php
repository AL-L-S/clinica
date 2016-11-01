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
class Tipoconsulta extends BaseController {

    function Tipoconsulta() {
        parent::Controller();
        $this->load->model('ambulatorio/tipoconsulta_model', 'tipoconsulta');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/tipoconsulta-lista', $args);

//            $this->carregarView($data);
    }

    function carregartipoconsulta($estoque_tipoconsulta_id) {
        $obj_tipoconsulta = new tipoconsulta_model($estoque_tipoconsulta_id);
        $data['obj'] = $obj_tipoconsulta;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/tipoconsulta-form', $data);
    }

    function excluir($estoque_tipoconsulta_id) {
        $valida = $this->tipoconsulta->excluir($estoque_tipoconsulta_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Tipoconsulta';
        } else {
            $data['mensagem'] = 'Erro ao excluir a tipoconsulta. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/tipoconsulta");
    }

    function gravar() {
        $exame_tipoconsulta_id = $this->tipoconsulta->gravar();
        if ($exame_tipoconsulta_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Tipoconsulta. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Tipoconsulta.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/tipoconsulta");
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
