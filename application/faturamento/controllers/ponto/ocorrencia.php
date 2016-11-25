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
class Ocorrencia extends BaseController {

    function Ocorrencia() {
        parent::Controller();
        $this->load->model('ponto/ocorrencia_model', 'ocorrencia');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->model('ponto/ocorrenciatipo_model', 'ocorrenciatipo');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($funcionario_id) {
        $data['funcionario_id'] = $funcionario_id;
        $competenciaativa = $this->competencia->competenciaAtiva();
        $data['lista'] = $this->ocorrencia->listar($funcionario_id, $competenciaativa);
        $data['listaocorrenciatipo'] = $this->ocorrenciatipo->listarautocomplete();
        $this->loadView('ponto/ocorrencia-lista', $data);
      

//            $this->carregarView($data);
    }
    
    function processarocorrencia() {
        $competenciaativa = $this->competencia->competenciaAtiva();
        $lista = $this->ocorrencia->listarocorrencias($competenciaativa);
        foreach ($lista as $value) {

            for ($index = $value->diainicio; $index <= $value->diafim; $index = date('Y-m-d', strtotime("+1 days", strtotime($index)))) {
                
                $critica = $value->nome . $value->observacao;
                $data = $index;
                $matricula = $value->matricula;
                
                $this->ocorrencia->processarocorrencia($critica, $data, $matricula);
            }
        }
        $this->loadView('ponto/processar-tipo');
      

//            $this->carregarView($data);
    }

    function carregar($ocorrencia_id) {
        $obj_ocorrencia = new ocorrencia_model($ocorrencia_id);
        $data['obj'] = $obj_ocorrencia;
        $data['listaocorrenciatipo'] = $this->ocorrenciatipo->listarautocomplete();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ponto/ocorrencia-form', $data);
    }

    function excluir($ocorrencia_id, $funcionario_id) {
        if ($this->ocorrencia->excluir($ocorrencia_id)) {
            $mensagem = 'Sucesso ao excluir a ocorrencia.';
        } else {
            $mensagem = 'Erro ao excluir a ocorrencia. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ponto/ocorrencia/pesquisar/$funcionario_id");
    }

    function gravar() {
        $funcionario_id = $_POST['txtfuncionario_id'];
        $competenciaativa = $this->competencia->competenciaAtiva();
        //    { $mensagem = 'servidor003';}
        if ($this->ocorrencia->gravar($competenciaativa)) {
            $data['mensagem'] = 'Sucesso ao gravar o ocorrencia.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Erro ao gravar o ocorrencia. Opera&ccedil;&atilde;o cancelada.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/ocorrencia/pesquisar/$funcionario_id");

        //$this->carregarView();
        //redirect(base_url()."giah/servidor/index/$data","refresh");
    }

    private function carregarView($data=null, $view=null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(1, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('ponto/ocorrencia-lista', $data);
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