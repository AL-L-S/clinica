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
        $this->load->model('cadastro/convenio_model', 'convenio');
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

    function carregarprocedimentoformapagamento($procedimento_convenio_id) {
        $data["procedimento_convenio_id"] = $procedimento_convenio_id;
        $this->loadView('ambulatorio/procedimentoformapagamento-form', $data);
    }

    function procedimentopercentualmedico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentopercentualmedico-form', $data);
    }

    function editarprocedimento($procedimento_percentual_medico_id) {
        $data['dados'] = $procedimento_percentual_medico_id;
        $this->loadView('ambulatorio/procedimentopercentualmedico-editar', $data);
    }

    function novomedico($procedimento_percentual_medico_id) {
        $data['dados'] = $this->procedimentoplano->novomedico($procedimento_percentual_medico_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['procedimento_percentual_medico_id'] = $procedimento_percentual_medico_id;
        $this->loadView('ambulatorio/procedimentopercentualmediconovo', $data);
    }

    function gravarnovomedico($procedimento_percentual_medico_id) {
        $return = $this->procedimentoplano->gravarnovomedico($procedimento_percentual_medico_id);
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar Médico.';
        }if ($return == 0) {
            $mensagem = 'Erro ao gravar Médico.';
        }if ($return == 2) {
            $mensagem = 'Erro: Médico já cadastrado.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimento/$procedimento_percentual_medico_id");
    }

    function gravarformapagamentoprocedimento() {
        $return = $this->procedimentoplano->gravarformapagamentoprocedimento();
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar Forma de Pagamento.';
        }if ($return == 0) {
            $mensagem = 'Erro ao gravar Forma de Pagamento.';
        }if ($return == 2) {
            $mensagem = 'Erro: Forma de Pagamento já cadastrado.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano");
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

    function excluirmedicopercentual($procedimento_percentual_medico_convenio_id) {
        if ($this->procedimentoplano->excluirmedicopercentual($procedimento_percentual_medico_convenio_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual medico';
        } else {
            $mensagem = 'Erro ao excluir o Percentual medico. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentopercentual");
    }

    function editarmedicopercentual($procedimento_percentual_medico_convenio_id) {
        $data['busca'] = $this->procedimentoplano->buscarmedicopercentual($procedimento_percentual_medico_convenio_id);
        $data['procedimento_percentual_medico_convenio_id'] = $procedimento_percentual_medico_convenio_id;
        $this->loadView("ambulatorio/medicopercentual-editar", $data);
    }

    function gravareditarmedicopercentual($procedimento_percentual_medico_convenio_id) {
        if ($this->procedimentoplano->gravareditarmedicopercentual($procedimento_percentual_medico_convenio_id)) {
            $mensagem = 'Sucesso ao editar o Percentual medico';
        } else {
            $mensagem = 'Erro ao editar o Percentual medico. Opera&ccedil;&atilde;o cancelada.';
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
