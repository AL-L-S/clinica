<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class filaacolhimento extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('emergencia/solicita_acolhimento_model', 'acolhimento');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->library('utilitario');
    }

    public function index() {
        $this->pesquisar();
    }

    public function pesquisar($args = array()) {
        $this->loadView('emergencia/solicita-acolhimento-lista');
    }

    public function pesquisarrae($args = array()) {
        $this->loadView('emergencia/emergencia-lista');
    }

    function novo($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $horario = date(" Y-m-d H:i:s");

        $hour = substr($horario, 11, 3);
        $minutes = substr($horario, 15, 2);
        $seconds = substr($horario, 18, 4);

        $this->loadView('emergencia/solicitacoes-paciente', $data);
    }

    function novosolicitacaoacolhimento($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $this->loadView('emergencia/solicitacao_acolhimento', $data);
    }

    function novoacolhimento($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $data['data'] = date("d/m/Y H:i:s");
        $this->loadView('emergencia/cadastrar_acolhimento', $data);
    }

    function fecharRae($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $data['data'] = date("d/m/Y H:i:s");
        $this->loadView('emergencia/fechar-form', $data);
    }

    function gravar() {

        if ($this->paciente->gravar()) {
            $data['mensagem'] = 'Fila acolhimento gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar fila acolhimento';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "emergencia/filaAcolhimento");
    }

    function gravarsolicitacao($paciente_id) {

        $data['numero'] = $this->acolhimento->verificaacolhimento($paciente_id);
        if ($data['numero'] == 0) {
        if ($this->acolhimento->gravarsolicitacao($paciente_id)) {
            $data['mensagem'] = 'Fila acolhimento gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar fila acolhimento';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes");
        } else {
            $data['mensagem'] = 'Paciente ja esta na fila de acolhimento';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes");
        }
    }

    function gravarfechamentorae($paciente_id) {

        if ($this->acolhimento->gravarfechamentorae($paciente_id)) {
            $data['mensagem'] = 'RAE fechada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao fechar RAE';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes");
    }

    function gravarrae($paciente_id) {

        if ($this->acolhimento->gravarrae($paciente_id)) {
            $data['mensagem'] = 'Fila acolhimento gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar fila acolhimento';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes");
    }

    function carregar($emergencia_solicitacao_acolhimento_id) {
        $obj_paciente = new paciente_model($emergencia_solicitacao_acolhimento_id);
        $data['obj'] = $obj_paciente;
        $this->loadView('emergencia/solicita-acolhimento-ficha', $data);
    }

}

?>
