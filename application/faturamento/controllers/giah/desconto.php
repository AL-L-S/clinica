<?php

/**
 * Esta classe é o controler de Desconto. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Desconto extends Controller {

    /**
     * Função
     * @name Desconto
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Desconto() {
        parent::Controller();
        $this->load->model('giah/desconto_model', 'desconto');
        $this->load->model('giah/servidor_model', 'servidor');
        $this->load->model('giah/competencia_model', 'competencia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    /**
     * Função
     * @name Index
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function index() {

    }

    /**
     * Função
     * @name pesquisar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param $servidor_id com a chave id de servidor
     */
    function pesquisar($servidor_id) {

        $competencia = $this->competencia->competenciaAtiva();
        if ($competencia == '000000') {
            redirect(base_url() . "giah/servidor", "refresh");
        } else {
            $data['servidor'] = new Servidor_model($servidor_id);
            $data['lista'] = $this->desconto->listarDescontosDoServidor($servidor_id, $competencia);
            $data['teto'] = $this->servidor->listarTeto($servidor_id);
            $this->carregarView($data);
        }
    }

    /**
     * Função
     * @name gravar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function gravar() {
        $servidor_id = $_POST['txtServidorID'];
        $competencia = $this->competencia->competenciaAtiva();
        if ($this->desconto->gravar($competencia)) {
            $data['mensagem'] = 'Sucesso ao gravar o desconto.';
        } else {
            $data['mensagem'] = 'Erro ao gravar o desconto. Opera&ccedil;&atilde;o cancelada.';
        }
        $data['servidor'] = new Servidor_model($servidor_id);
        $data['lista'] = $this->desconto->listarDescontosDoServidor($servidor_id, $competencia);
        $data['teto'] = $this->servidor->listarTeto($servidor_id);
//        $this->carregarView($data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/desconto/pesquisar/$servidor_id",$data);
    }

    /**
     * Função
     * @name excluir
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param $servidor_id, com a informação de Id do servidor, e $tipodesconto_id com o Id do dipo de desconto
     */
    function excluir($servidor_id, $tipodesconto_id) {
        $competencia = $this->competencia->competenciaAtiva();
        if ($this->desconto->excluir($servidor_id, $competencia, $tipodesconto_id)) {
            $data['mensagem'] = 'Sucesso ao excluir o desconto.';
        } else {
            $data['mensagem'] = 'Erro ao excluir o desconto. Opera&ccedil;&atilde;o cancelada.';
        }
        $data['servidor'] = new Servidor_model($servidor_id);
        $data['lista'] = $this->desconto->listarDescontosDoServidor($servidor_id, $competencia);
        $data['teto'] = $this->servidor->listarTeto($servidor_id);
//        $this->carregarView($data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/desconto/pesquisar/$servidor_id",$data);
    }

    /**
     * Função
     * @name carregarView
     * @author Equipe de desenvolvimento APH
     * @access private
     * @return void
     * @param $data, $view
     */
    private function carregarView($data=null, $view=null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }
        if ($this->utilitario->autorizar(5, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if (!isset($view)) {
                $this->load->view('giah/desconto-lista', $data);
            } else {
                $this->load->view($view, $data);
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