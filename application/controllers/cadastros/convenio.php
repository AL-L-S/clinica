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
class Convenio extends BaseController {

    function Convenio() {
        parent::Controller();
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/grupoconvenio_model', 'grupoconvenio');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/convenio-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($convenio_id) {
        $obj_convenio = new convenio_model($convenio_id);
        $data['obj'] = $obj_convenio;
        $this->loadView('cadastros/convenio-form', $data);
    }

    function copiar($convenio_id) {
        $data['convenio'] = $this->convenio->listardados();
        $data['convenioid'] = $convenio_id;
        $this->loadView('cadastros/copiarconvenio-form', $data);
    }

    function desconto($convenio_id) {
        $data['convenio'] = $this->convenio->listarconveniodesconto($convenio_id);
        $data['grupos'] = $this->convenio->listargrupos();
        $data['convenioid'] = $convenio_id;
        $this->loadView('cadastros/desconto-convenio', $data);
    }

    function gravardesconto($convenio_id) {
        $data['convenio'] = $this->convenio->gravardesconto($convenio_id);
        $data['convenioid'] = $convenio_id;
        redirect(base_url() . "cadastros/convenio");
    }

    function excluir($convenio_id) {
        if ($this->convenio->excluir($convenio_id)) {
            $mensagem = 'Sucesso ao excluir a Convenio';
        } else {
            $mensagem = 'Erro ao excluir a Convenio. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/convenio");
    }

    function gravar() {
        $convenio_id = $this->convenio->gravar();
        if ($convenio_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar Convenio. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Convenio.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/convenio");
    }

    function gravarcopia() {
        $convenio_id = $this->convenio->gravarcopia();
        if ($convenio_id == "-1") {
            $data['mensagem'] = 'Erro ao copiar Convenio. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao copiar Convenio.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/convenio");
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
