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
class Procedimento extends BaseController {

    function Procedimento() {
        parent::Controller();
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {
        $this->loadView('ambulatorio/procedimento-lista', $args);
    }

    function pesquisartuss($args = array()) {
        $this->loadView('ambulatorio/procedimentotuss-lista', $args);
    }

    function carregarprocedimento($procedimento_tuss_id) {
        $obj_procedimento = new procedimento_model($procedimento_tuss_id);
        $data['obj'] = $obj_procedimento;
        $data['grupos'] = $this->procedimento->listargrupos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimento-form', $data);
    }

    function carregarprocedimentotuss($procedimento_tuss_id) {
        $data['procedimento'] = $this->procedimento->listarprocedimentostuss($procedimento_tuss_id);
        $data['classificacao'] = $this->procedimento->listarclassificacaotuss();
        if (count($data['procedimento']) == 0) {
            $this->loadView('ambulatorio/procedimentotuss2-form', $data);
        } else {
            $this->loadView('ambulatorio/procedimentotuss-form', $data);
        }
    }

    function relatorioprocedimento() {
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioprocedimento' , $data);
    }

    function relatorioprocedimentoconvenio() {

        $data['convenio'] = $this->convenio->listardados();
        $data['grupo'] = $this->guia->listargrupo();
        $this->loadView('ambulatorio/relatorioprocedimentoconvenio', $data);
    }

    function gerarelatorioprocedimento() {
        $data['grupo'] = $_POST['grupo'];
        $data['relatorio'] = $this->procedimento->relatorioprocedimentos();
        $data['empresa'] = $this->procedimento->listarempresas();
        $this->load->View('ambulatorio/impressaorelatorioprocedimento', $data);
    }

    function gerarelatorioprocedimentoconvenio() {

        $this->load->plugin('mpdf');
        $grupo = 'laboratorial';
        $filename = "laudo.pdf";
        $cabecalho = "";
        $rodape = "";


        $data['grupo'] = $_POST['grupo'];
        $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        $data['conveniotipo'] = $_POST['convenio'];
        $data['relatorio'] = $this->procedimento->relatorioprocedimentoconvenio();
        $html = $this->load->view('ambulatorio/impressaorelatorioprocedimentoconvenio', $data, true);
        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        $this->load->View('ambulatorio/impressaorelatorioprocedimentoconvenio', $data);
    }

    function gerarelatorioprocedimentotuss() {
        $data['relatorio'] = $this->procedimento->relatorioprocedimentotuss();
        $data['empresa'] = $this->procedimento->listarempresas();
        $this->load->View('ambulatorio/impressaorelatorioprocedimentotuss', $data);
    }

    function excluir($procedimento_tuss_id) {
        if ($this->procedimento->excluir($procedimento_tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimento';
        } else {
            $mensagem = 'Erro ao excluir o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimento");
    }

    function excluirprocedimentotuss($tuss_id) {
        if ($this->procedimento->excluirprocedimentotuss($tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimento';
        } else {
            $mensagem = 'Erro ao excluir o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimento/pesquisartuss");
    }

    function gravar() {
        $procedimento_tuss_id = $this->procedimento->gravar();
        if ($procedimento_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimento");
    }

    function gravartuss() {
        $procedimento_tuss_id = $this->procedimento->gravartuss();
        if ($procedimento_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimento/pesquisartuss");
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
