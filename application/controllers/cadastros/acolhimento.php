<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class acolhimento extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/acolhimento_model', 'acolhimento');
        $this->load->library('utilitario');
    }

    public function index() {
        $this->pesquisar();
    }

    public function pesquisar($args = array()) {
        $this->loadView('cadastros/acolhimento-lista');
    }

    function novo() {
        $data['listaUnidade']  = $this->acolhimento->listarUnidades();
        $data['cbo']      = $this->paciente->listarCBO();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/acolhimento-ficha', $data);
    }

    function gravar() {

        if ($this->acolhimento->gravar($_POST)) {
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/acolhimento");
    }

}

?>
