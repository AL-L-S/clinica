<?php

/**
 * Esta classe é o controler de Matrícula. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Matricula extends Controller {

    /**
    * Função
    * @name Matricula
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return void
    * @param void
    */
    function Matricula() {
        parent::Controller();
        $this->load->model('giah/matricula_model', 'matricula_m');
    }
    /**
    * Função
    * @name index
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return void
    * @param void
    */
    function index() {

    }
    /**
    * Função que gerencia o autocomplete dos campos de matrícula
    * @name autocomplete
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return $x
    * @param void
    */
    function autocomplete() {
        $x = $this->matricula_m->listar();
        if (isset($_POST['ajax'])) {
            echo json_encode($x[0]);
        } else {
            return $x[0];
        }
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */