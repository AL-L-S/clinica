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
class Formapagamento extends BaseController {

    function Formapagamento() {
        parent::Controller();
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/formapagamento-lista', $args);

//            $this->carregarView($data);
    }

    function grupospagamento($args = array()) {

        $this->loadView('cadastros/grupopagamento-lista', $args);

//            $this->carregarView($data);
    }

    function carregargrupospagamento() {
        $data['forma_pagamento'] = $this->formapagamento->listarforma();
        $this->loadView('cadastros/grupopagamento-form', $data);
    }

    function carregarformapagamento($formapagamento_id) {
        $obj_formapagamento = new formapagamento_model($formapagamento_id);
        $data['obj'] = $obj_formapagamento;
        $data['conta'] = $this->forma->listarforma();
        $data['credor_devedor'] = $this->formapagamento->listarcredordevedor();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/formapagamento-form', $data);
    }

    function formapagamentoparcelas($formapagamento_id) {
        $data['formapagamento_id'] = $formapagamento_id;
        $data['formapagamento'] = $this->formapagamento->buscarforma($formapagamento_id);
        $data['faixas_parcelas'] = $this->formapagamento->buscafaixasparcelas($formapagamento_id);
        
        if(count($data['faixas_parcelas']) > 0){
            
            $ind_ultima_parcela = count($data['faixas_parcelas']) - 1;
            $data['ultima_parcela'] = (int) $data['faixas_parcelas'][$ind_ultima_parcela]->parcelas_fim;
            
            foreach ($data['faixas_parcelas'] as $item) {
                $item->parcelas_fim = (int)$item->parcelas_fim;
                if( $data['ultima_parcela'] >= $item->parcelas_fim){
                    continue;
                }
                else {
                    $data['ultima_parcela'] = $item->parcelas_fim;
                }
            }
        } else {
            $data['ultima_parcela'] = 0;
        }
        $this->loadView('cadastros/formapagamentoparcelas-form', $data);
    }
    
    
    function gravarparcelas() {
        $formapagamento_id = $_POST['formapagamento_id'];
        $_POST['taxa'] = str_replace(",", ".", $_POST['taxa']);
        $this->formapagamento->gravarparcelas();
        redirect(base_url() . "cadastros/formapagamento/formapagamentoparcelas/$formapagamento_id");
    }

    function excluir($formapagamento_id) {
        $valida = $this->formapagamento->excluir($formapagamento_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento");
    }
    
    function excluirparcela($parcela_id, $formapagamento_id) {
        $this->formapagamento->excluirparcela($parcela_id);
        $this->formapagamentoparcelas($formapagamento_id);
    }

    function excluirgrupo($grupo_id) {
        $valida = $this->formapagamento->excluirgrupo($grupo_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/grupospagamento");
    }

    function excluirformapagamentodogrupo($grupo_id, $grupo_formapagamento_id) {
        $valida = $this->formapagamento->excluirformapagamentodogrupo($grupo_formapagamento_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/grupoadicionar/$grupo_id");
    }

    function gravar() {
        $exame_formapagamento_id = $this->formapagamento->gravar();
        if ($exame_formapagamento_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Forma. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Forma.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento");
    }

    function grupoadicionar($financeiro_grupo_id) {
        $data['financeiro_grupo'] = $this->formapagamento->buscargrupo($financeiro_grupo_id);
        $data['forma_pagamento'] = $this->formapagamento->listarforma();
        $data['relatorio'] = $this->formapagamento->listarformapagamentonogrupo($financeiro_grupo_id);
        $this->loadView('cadastros/grupopagamento-adicionar', $data);
    }

    function gravargrupoadicionar() {
        $financeiro_grupo_id = $_POST['grupo_id'];
        if ($this->formapagamento->gravargrupoadicionar()) {
            $data['mensagem'] = 'Forma de Pagamento adicionada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao adicionar.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/grupoadicionar/$financeiro_grupo_id");
    }


    function gravargruponome() {
        $financeiro_grupo_id = $this->formapagamento->gravargruponome();
        if ($financeiro_grupo_id != false) {
            $data['mensagem'] = 'Grupo criado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao criar grupo.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/grupoadicionar/$financeiro_grupo_id");
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
