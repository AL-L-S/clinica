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
class Grupoconvenio extends BaseController {

    function Grupoconvenio() {
        parent::Controller();
        $this->load->model('cadastro/grupoconvenio_model', 'grupoconvenio');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/grupoconvenio-lista', $args);

//            $this->carregarView($data);
    }

    function carregargrupoconvenio($exame_grupoconvenio_id) {
        $obj_grupoconvenio = new grupoconvenio_model($exame_grupoconvenio_id);
        $data['obj'] = $obj_grupoconvenio;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/grupoconvenio-form', $data);
    }

    function excluir($exame_grupoconvenio_id) {
        if ($this->procedimento->excluir($exame_grupoconvenio_id)) {
            $mensagem = 'Sucesso ao excluir a Grupoconvenio';
        } else {
            $mensagem = 'Erro ao excluir a grupoconvenio. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/grupoconvenio");
    }

    function gravar() {
        $exame_grupoconvenio_id = $this->grupoconvenio->gravar();
        if ($exame_grupoconvenio_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Grupoconvenio. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Grupoconvenio.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoconvenio");
    }

    function ativar($exame_grupoconvenio_id) {
        $this->grupoconvenio->ativar($exame_grupoconvenio_id);
            $data['mensagem'] = 'Sucesso ao ativar a Grupoconvenio.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoconvenio");
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
