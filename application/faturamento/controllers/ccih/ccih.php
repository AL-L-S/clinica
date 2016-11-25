<?php

/**
 * Esta classe é o controller da Ficha Ceatox. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage eco
 */
require_once APPPATH . 'controllers/base/BaseController.php';

class Ccih extends BaseController
{

    function Ccih()
    {
        parent::Controller();
        $this->load->model('ccih/ccih_model', 'ccih');
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
    function index()
    {
        $this->pesquisarcirurgia();
    }

    function pesquisarcirurgia()
    {

        $this->loadView('ccih/consultacirurgias');
    }

    function imprimircirurgia()
    {
        
        $data['lista'] = $this->ccih->listarCirrugias();
        $data['competencia'] = $_POST['txtcompetencia'];
        $data['tipo'] = $_POST['txtclassificacao'];
        if ($data['tipo'] == " ") {
            $data['tipo'] = "TODAS";
        }
        
        $this->load->View('ccih/listacirurgias', $data);
    }

}