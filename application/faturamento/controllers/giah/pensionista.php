<?php

/**
 * Esta classe é o controler de Pensionista. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Pensionista extends Controller {

    /**
     * Função para carregar as informações de pensionistas
     * @name pensionista
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Pensionista() {
        parent::Controller();
        $this->load->model('giah/servidor_model', 'servidor');
        $this->load->model('giah/pensionista_model', 'pensionista');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    /**
     * @name index
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function index() {

    }

    /**
     * Função para carregar as informações de pensionistas
     * @name pesquisar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function pesquisar($servidor_id) {
        $data['servidor'] = new Servidor_model($servidor_id);
        $data['lista'] = $this->pensionista->listarPensionistasDoServidor($servidor_id);
        $this->carregarView($data);
    }

    /**
     * Função para carregar as informações de pensionistas
     * @name excluir
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param $servidor_id, $pensionista_id
     */
    function excluir($servidor_id, $pensionista_id) {
        if ($this->pensionista->excluir($pensionista_id)) {
            $data['mensagem'] = 'Excluido com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao excluir o pensionista. Opera&ccedil;&atilde;o cancelada.';
        }
        $data['servidor'] = new Servidor_model($servidor_id);
        $data['lista'] = $this->pensionista->listarPensionistasDoServidor($servidor_id);
//        $this->carregarView($data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/pensionista/pesquisar/$servidor_id",$data);
    }

    /**
     * Função para carregar as informações de pensionistas
     * @name gravar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function gravar() {
        $servidor_id = $_POST['txtServidorID'];
        if ($this->pensionista->gravar()) {
            $data['mensagem'] = 'Sucesso ao gravar o pensionista.';
        } else {
            $data['mensagem'] = 'Erro ao gravar o pensionista. Opera&ccedil;&atilde;o cancelada.';
        }
        $data['servidor'] = new Servidor_model($servidor_id);
        $data['lista'] = $this->pensionista->listarPensionistasDoServidor($servidor_id);
//        $this->carregarView($data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/pensionista/pesquisar/$servidor_id",$data);
    }

    /**
     * Função para carregar as informações de pensionistas
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
        if ($this->utilitario->autorizar(3, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if (isset($view)) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/pensionista-lista', $data);
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