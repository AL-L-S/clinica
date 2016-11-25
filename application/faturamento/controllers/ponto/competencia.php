<?php

/**
 * Esta classe é o controler de Competencia. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Competencia extends Controller {

    /**
     * Função
     * @name Competencia
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Competencia() {
        parent::Controller();
        $this->load->model('ponto/competencia_model', 'competencia');
        //$this->load->model('giah/incentivo_model', 'incentivo_m');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    /**
     * Função
     * @name INDEX
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function index() {
        $this->listar(date('Y'));
    }

    function listar($ano=null) {
        $data['lista'] = $this->competencia->listar($ano);
        $this->carregarView($data);
    }

    function gravar() {
        if ($this->competencia->abrir()) {
            //$this->incentivo_m->iniciarNovaCompetencia($_POST['txtCompetencia']);
            $data['mensagem'] = 'Compet&ecirc;ncia cadastrada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao cadastrar compet&ecirc;ncia. Opera&ccedil;&atilde;o cancelada.';
        }
        $data['lista'] = $this->competencia->listar(date('Y'));
//        $this->carregarView($data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."ponto/competencia",$data);
    }
    /**
     * Função
     * @name Competencia
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param $competencia com id da competencia
     */

    function fechar($competencia) {
        if ($this->competencia->fechar($competencia)) {
            $data['mensagem'] = 'Compet&ecirc;ncia fechada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao fechar compet&ecirc;ncia. Opera&ccedil;&atilde;o cancelada.';
        }
        $data['lista'] = $this->competencia->listar(date('Y'));
//        $this->carregarView($data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."ponto/competencia",$data);
    }

    /**
     * Função
     * @name Carregar view
     * @author Equipe de desenvolvimento APH
     * @access private
     * @return void
     * @param string $data com a data referente, boolean view.
     */
    private function carregarView($data=null, $view=null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(1, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('ponto/competencia-lista', $data);
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