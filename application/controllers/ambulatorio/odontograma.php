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
class Odontograma extends BaseController {

    function Odontograma() {
        parent::Controller();
        $this->load->model('ambulatorio/odontograma_model', 'odontograma');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {
        die;
    }
    

    function gravarprocedimentoodontograma() {
        $odontograma_id = $_GET['odontograma_id'];
        
        // Verifica se o Odontograma ja foi criado (tb_odontograma)
        if($odontograma_id == ''){
            $odontograma_id = $this->odontograma->crianovoodontograma();
        }
        
        // Verifica se esse dente ja foi 'criado' (tb_odontograma_dente)
        $odontograma_dente_id = $this->odontograma->novodenteodontograma($odontograma_id);
        
        // Adiciona esse procedimento no dente (tb_odontograma_dente_procedimento)
        $this->odontograma->novoprocedimentodenteodontograma($odontograma_dente_id);
        
        $var = array(
            "odontograma_id" => $odontograma_id,
            "dente" => $_GET['dente']
        );

        echo json_encode($var);
    }
    
    function listarprocedimentosodontograma(){
        $result = $this->odontograma->listarprocedimentosodontograma();
        @$var = array();
        
        foreach($result as $value){
            $retorno['face'] = $value->face;
            $retorno['observacao'] = $value->observacao;
            $retorno['numero_dente'] = $value->numero_dente;
            $retorno['dente_procedimento_id'] = $value->odontograma_dente_procedimento_id;
            $retorno['codigo'] = $value->codigo;
            $retorno['procedimento'] = $value->procedimento;
            
            @$var[] = $retorno;
        }
        
        die(json_encode($var));
    }
    
    function excluirprocedimentoodontograma(){
        $result = $this->odontograma->excluirprocedimentoodontograma();
        die(json_encode($result));
    }


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
