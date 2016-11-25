<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class triagem extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('emergencia/triagem_model', 'triagem');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->library('utilitario');
    }

    public function index() {
        $this->pesquisar();
    }

    public function pesquisar($args = array()) {
        $this->loadView('emergencia/triagem-lista');
    }

    function gravarsolicitacaotriagem($paciente_id) {

        $data['numero'] = $this->triagem->verificatriagem($paciente_id);
        if ($data['numero'] == 0) {
            if ($this->triagem->gravarsolicitacaotriagem($paciente_id)) {
                $data['mensagem'] = 'Fila triagem gravado com sucesso';
            } else {
                $data['mensagem'] = 'Erro ao gravar fila triagem';
            }
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes");
        } else {
            $data['mensagem'] = 'Paciente ja esta na fila triagem';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes");
        }
    }

    function gravar($paciente_id) {

        if ($this->triagem->gravar($paciente_id)) {
            $data['mensagem'] = 'Triagem gravado com sucesso';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "emergencia/triagem");
        } else {
            $data['mensagem'] = 'Erro ao gravar triagem';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "emergencia/triagem");
        }

    }

    function nova($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $this->loadView('emergencia/triagem-form', $data);
    }

    function cancelar($paciente_id) {
        if ($this->triagem->cancelar($paciente_id)) {
            $data['mensagem'] = 'Triagem cancelada com sucesso';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "emergencia/triagem");
        } else {
            $data['mensagem'] = 'Erro ao cancelar triagem';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "emergencia/triagem");
        }
    }

    function novoacolhimento($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $data['data'] = date("d/m/Y H:i:s");
        $this->loadView('emergencia/cadastrar_acolhimento', $data);
    }

}

?>
