<?php
/**
 * Esta classe é o controller da Ficha Solicitante
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage ceatox
 */
require_once APPPATH . 'controllers/base/BaseController.php';
class solicitante extends BaseController {

        function solicitante() {
            parent::Controller();
            $this->load->model('ceatox/solicitante_model', 'solicitante_m');
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

            
            $this->loadView('ceatox/solicitante-ficha');
        }

        function pesquisar($args = array()) {
        //$data['lista'] = $this->solicitante_m->listar();
        $this->loadView('ceatox/solicitante-lista');
        }

        function gravar() {

        if ($this->solicitante_m->gravar($_POST)) {
            $data['mensagem'] = 'Solicitante gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar solicitante';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ceatox/solicitante");
    }

    function carregar ($ceatox_solicitante_id) {
            $objSolicitante = new solicitante_model($ceatox_solicitante_id);
            $data['obj'] = $objSolicitante;
            $this->loadView('ceatox/solicitante-ficha', $data);
        }
}
?>