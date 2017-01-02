<?php

/**
 * Esta classe é o controler de Parametro Giah (cadastro de valores a ser rateados). Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Parametrogiah extends Controller {

    /**
     * Função
     * @name Parametrogiah
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Parametrogiah() {
        parent::Controller();
        $this->load->model('giah/parametrogiah_model', 'parametrogiah_m');
        $this->load->model('giah/competencia_model', 'competencia');
        $this->load->library('mensagem');
        $this->load->library('validation');
        $this->load->library('utilitario');
    }
    /**
     * Função
     * @name index
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function index() {
        $this->pesquisar();
    }

    /**
     * Função para pesquisar dados no banco
     * @name Pesquisar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function pesquisar() {
        $ano = date('Y');
        $data['lista'] = $this->parametrogiah_m->listar($ano);
        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        $this->carregarView($data);
    }

    /**
     * Função para gravar as informações no banco
     * @name gravar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function gravar() {
        $competenciaativa = $this->competencia->competenciaAtiva();
        if ($this->parametrogiah_m->gravar($competenciaativa)) {
            $data['mensagem'] = 'Sucesso ao gravar o parametro da giah.';
        } else {
            $data['mensagem'] = 'Erro ao gravar o parametro da giah. Opera&ccedil;&atilde;o cancelada.';
        }
//        $this->pesquisar();
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/parametrogiah",$data);
    }

    /**
     * Função para excluir dados do banco
     * @name excluir
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param competencia
     */
    function excluir($competencia) {
        if ($this->parametrogiah_m->excluir($competencia)) {
            $data['mensagem'] = 'Sucesso ao excluir o parametro da giah.';
        } else {
            $data['mensagem'] = 'Erro ao excluir o parametro da giah. Opera&ccedil;&atilde;o cancelada.';
        }
//        $this->pesquisar();
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/parametrogiah",$data);
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
        if ($this->utilitario->autorizar(15, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if (!isset($view)) {
                $this->load->view('giah/parametrogiah-lista', $data);
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