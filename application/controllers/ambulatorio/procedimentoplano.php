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
class Procedimentoplano extends BaseController {

    function Procedimentoplano() {
        parent::Controller();
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/procedimentoplano-lista', $args);

//            $this->carregarView($data);
    }
    function procedimentoplanoconsulta($args = array()) {

        $this->loadView('ambulatorio/procedimentoplano-consulta', $args);

//            $this->carregarView($data);
    }

    function procedimentopercentual($args = array()) {

        $this->loadView('ambulatorio/procedimentopercentualmedico-lista', $args);
    }

    function carregarprocedimentoplano($procedimentoplano_tuss_id) {
        $obj_procedimentoplano = new procedimentoplano_model($procedimentoplano_tuss_id);
        $data['obj'] = $obj_procedimentoplano;
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentoplano-form', $data);
    }

    function procedimentopercentualmedico() {
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['medicos'] = $this->operador_m->listarmedicos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentopercentualmedico-form', $data);
    }

    function excluir($procedimentoplano_tuss_id) {
        if ($this->procedimentoplano->excluir($procedimentoplano_tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimentoplano';
        } else {
            $mensagem = 'Erro ao excluir o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano");
    }

    function excluirpercentual($procedimento_percentual_medico_id) {
        if ($this->procedimentoplano->excluirpercentual($procedimento_percentual_medico_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual medico';
        } else {
            $mensagem = 'Erro ao excluir o Percentual medico. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentopercentual");
    }

    function gravar() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravar();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano");
    }

    function gravarpercentualmedico() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentualmedico();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentopercentual");
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
