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
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/paciente_model', 'paciente');
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

    function pesquisar($limite = 50) {
        $data["limite_paginacao"] = $limite;

        $this->loadView('ambulatorio/procedimentoplano-lista', $data);

//            $this->carregarView($data);
    }

    function procedimentoplanoconsulta($args = array()) {

        $this->loadView('ambulatorio/procedimentoplano-consulta', $args);

//            $this->carregarView($data);
    }

    function procedimentopercentual($args = array()) {

        $this->loadView('ambulatorio/procedimentopercentualmedico-lista', $args);
    }
    function procedimentopercentualpromotor($args = array()) {

        $this->loadView('ambulatorio/procedimentopercentualpromotor-lista', $args);
    }

    function agrupador($args = array()) {
        $this->loadView('ambulatorio/agrupadorprocedimentos-lista', $args);
    }

    function carregaragrupador($agrupador_id = null) {
        $data['convenio'] = $this->convenio->listardados();
        $data['agrupador'] = $this->procedimentoplano->instanciaragrupador($agrupador_id);
//        $data['forma_pagamento'] = $this->formapagamento->listarforma();
        $this->loadView('ambulatorio/agrupadorprocedimentos-form', $data);
    }

    function gravaragrupadornome() {
        $agrupador_id = $this->procedimentoplano->gravaragrupadornome();
        if ($agrupador_id != false) {
            $data['mensagem'] = 'Agrupador criado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao criar agrupador.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/agrupadoradicionar/$agrupador_id");
    }

    function agrupadoradicionar($agrupador_id) {
        $data['agrupador'] = $this->procedimentoplano->buscaragrupador($agrupador_id);
        $data['procedimentos'] = $this->procedimentoplano->listarprocedimento();
//        die;
        $data['relatorio'] = $this->procedimentoplano->listarprocedimentosagrupador($agrupador_id);
        $this->loadView('ambulatorio/agrupador-adicionar', $data);
    }

    function gravaragrupadoradicionar() {
        $agrupador_id = $_POST['agrupador_id'];
        if ($this->procedimentoplano->gravaragrupadoradicionar()) {
            $data['mensagem'] = 'Procedimento adicionada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao adicionar.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/agrupadoradicionar/$agrupador_id");
    }

    function excluiragrupador($agrupador_id) {
        $teste = $this->procedimentoplano->excluiragrupadornome($agrupador_id);
        if ($teste != 0) {
            $data['mensagem'] = 'Agrupador criado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao criar agrupador.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/agrupador");
    }

    function excluirprocedimentoagrupador($procedimento_agrupado_id , $agrupador_id) {
        $this->procedimentoplano->excluirprocedimentoagrupador($procedimento_agrupado_id);
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/agrupadoradicionar/$agrupador_id");
    }

    function carregarprocedimentoplano($procedimentoplano_tuss_id) {
        $obj_procedimentoplano = new procedimentoplano_model($procedimentoplano_tuss_id);
        $data['obj'] = $obj_procedimentoplano;
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento2();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentoplano-form', $data);
    }

    function carregarprocedimentoformapagamento($procedimento_convenio_id) {
        $data["procedimento_convenio_id"] = $procedimento_convenio_id;
        $data["formapagamento_grupo"] = $this->formapagamento->listargrupos();
        $this->loadView('ambulatorio/procedimentoformapagamento-form', $data);
    }

    function orcamento() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['grupos'] = $this->procedimento->listargruposexame();
//        $data['exames'] = $this->exametemp->listarorcamentos();
        $this->loadView('ambulatorio/orcamentogeral-form_1', $data);
    }

    function imprimirorcamento() {
        $data = $_POST;
//        echo "<pre>";
//        var_dump($data);
//        die;
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $this->load->View('ambulatorio/impressaoorcamentogeral', $data);
    }

    function procedimentopercentualmedico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentopercentualmedico-form', $data);
    }
    
    function novoprocedimentopercentualpromotor() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['promotor'] = $this->paciente->listaindicacao();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentopercentualpromotor-form', $data);
    }

    function editarprocedimento($procedimento_percentual_medico_id) {
        $data['dados'] = $procedimento_percentual_medico_id;
        $this->loadView('ambulatorio/procedimentopercentualmedico-editar', $data);
    }
    
    function editarprocedimentopromotor($procedimento_percentual_promotor_id) {
        $data['dados'] = $procedimento_percentual_promotor_id;
        $this->loadView('ambulatorio/procedimentopercentualpromotor-editar', $data);
    }

    function novomedico($procedimento_percentual_medico_id) {
        $data['dados'] = $this->procedimentoplano->novomedico($procedimento_percentual_medico_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['procedimento_percentual_medico_id'] = $procedimento_percentual_medico_id;
        $this->loadView('ambulatorio/procedimentopercentualmediconovo', $data);
    }
    
    function novopromotor($procedimento_percentual_promotor_id) {
        $data['dados'] = $this->procedimentoplano->novopromotor($procedimento_percentual_promotor_id);
        $data['promotors'] = $this->paciente->listaindicacao();
        $data['procedimento_percentual_promotor_id'] = $procedimento_percentual_promotor_id;
        $this->loadView('ambulatorio/procedimentopercentualpromotornovo', $data);
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
    
    function gravarnovopromotor($procedimento_percentual_promotor_id) {
        $return = $this->procedimentoplano->gravarnovopromotor($procedimento_percentual_promotor_id);
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar Promotor.';
        }if ($return == 0) {
            $mensagem = 'Erro ao gravar Promotor.';
        }if ($return == 2) {
            $mensagem = 'Erro: Promotor já cadastrado.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentopromotor/$procedimento_percentual_promotor_id");
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
    
    function excluirpercentualpromotorgeral($procedimento_percentual_medico_id) {
        if ($this->procedimentoplano->excluirpercentualpromotorgeral($procedimento_percentual_medico_id)) {
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
    
    function excluirpromotorpercentual($procedimento_percentual_promotor_convenio_id, $dados) {
        if ($this->procedimentoplano->excluirpromotorpercentual($procedimento_percentual_promotor_convenio_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual promotor';
        } else {
            $mensagem = 'Erro ao excluir o Percentual promotor. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentopromotor/$dados");
    }

    function editarmedicopercentual($procedimento_percentual_medico_convenio_id) {
        $data['busca'] = $this->procedimentoplano->buscarmedicopercentual($procedimento_percentual_medico_convenio_id);
        $data['procedimento_percentual_medico_convenio_id'] = $procedimento_percentual_medico_convenio_id;
        $this->loadView("ambulatorio/medicopercentual-editar", $data);
    }
    
    function editarpromotorpercentual($procedimento_percentual_promotor_convenio_id, $dados) {
        $data['busca'] = $this->procedimentoplano->buscarpromotorpercentual($procedimento_percentual_promotor_convenio_id);
        $data['dados'] = $dados;
        $data['procedimento_percentual_promotor_convenio_id'] = $procedimento_percentual_promotor_convenio_id;
        $this->loadView("ambulatorio/promotorpercentual-editar", $data);
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
    
    function gravareditarpromotorpercentual($procedimento_percentual_promotor_convenio_id, $dados) {
        if ($this->procedimentoplano->gravareditarpromotorpercentual($procedimento_percentual_promotor_convenio_id)) {
            $mensagem = 'Sucesso ao editar o Percentual promotor';
        } else {
            $mensagem = 'Erro ao editar o Percentual promotor. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentopromotor/$dados");
    }

    function gravar() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravar();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Procedimento já cadastrado.';
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
    function gravarpercentualpromotor() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentualpromotor();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentopercentualpromotor");
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
