<?php
require_once APPPATH . 'controllers/base/BaseController.php';
/**
 * Esta classe é o controler de Pensionista. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Vigilante extends BaseController {

    /**
     * Função para carregar as informações de pensionistas
     * @name pensionista
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Vigilante() {
        parent::Controller();
        $this->load->model('sca/vigilante_model', 'vigilante_m');
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

        $this->loadView('sca/vigilante-lista');

    }

    /**
     * Função para carregar as informações de pensionistas
     * @name pesquisar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */


    /**
     * Função para carregar as informações de pensionistas
     * @name excluir
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param $servidor_id, $pensionista_id
     */
    function excluir($vigilante_id) {
        if ($this->vigilante_m->excluir($vigilante_id)) {
            $data['mensagem'] = 'Vigilante excluido com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao excluir vigilante . Opera&ccedil;&atilde;o cancelada.';
        }
//        $this->loadView('sca/vigilante-lista');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."sca/vigilante",$data);
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

        if ($this->vigilante_m->gravar()) {
            $data['mensagem'] = 'Vigilante cadastrado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao cadastrar vigilante . Opera&ccedil;&atilde;o cancelada.';
        }
//        $this->loadView('sca/vigilante-lista');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."sca/vigilante",$data);
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
                $this->load->view('sca/vigilante-lista', $data);
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