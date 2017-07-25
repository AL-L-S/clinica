<?php
/**
 * Esta classe é o controller do Modulo de controle de ambulâncias. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage sca
 */
require_once APPPATH . 'controllers/base/BaseController.php';

class Ambulancia extends BaseController {

        function Ambulancia() {
            parent::Controller();
            $this->load->model('sca/ambulancia_model', 'ambulancia_m');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
            $this->load->library('validation');
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

        function novo () {
            
             $this->loadView('sca/ambulancia-form');
        }


        function pesquisar($args = array()) {

            $this->loadView('sca/ambulancia-lista');
        }

        function gravar() {
            if( $this->ambulancia_m->gravar() )
            {$data['mensagem'] = 'Entrada de ambulancia cadastrada com sucesso.'; }
            else
            { $data['mensagem'] = 'Erro ao cadastrar entrada de ambulancia. Opera&ccedil;&atilde;o cancelada.'; }
//             $this->loadView('sca/ambulancia-form');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."sca/ambulancia",$data);
        }

       function excluir($ambulancia_id) {
        if ($this->ambulancia_m->excluir($ambulancia_id)) {
            $data['mensagem'] = 'Entrada de ambulancia excluida com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao excluir entrada de ambulancia. Opera&ccedil;&atilde;o cancelada.';
        }
//             $this->loadView('sca/ambulancia-form');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."sca/ambulancia",$data);
    }

//       function pdf ($ficha_id){
//
//                $this->load-> plugin('to_pdf_pi');
//                $data['lista'] = $this->ceatox_m->fichaRelatorio($ficha_id);
//                $this->load->view('ceatox/relatorios', $data);
//
//       }

        /* Métodos privados */
        private function carregarView($data=null, $view=null){
            if (!isset ($data)) { $data['mensagem'] = ''; }

            if ($this->utilitario->autorizar(9, $this->session->userdata('modulo')) == true)
            {
                $this->load->view('header', $data);
                if ($view != null) {
                    $this->load->view($view, $data);
                } else {
                    $this->load->view('sca/ambulancia-lista', $data);
                }
            } else {
                $data['mensagem'] = $this->mensagem->getMensagem('login005');
                $this->load->view('header', $data);
                $this->load->view('home');
            }
            $this->load->view('footer');
        }
}