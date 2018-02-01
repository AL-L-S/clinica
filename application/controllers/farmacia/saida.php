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
class Saida extends BaseController {

    function Saida() {
        parent::Controller();
        $this->load->model('farmacia/saida_model', 'saida');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function carregarsaida($farmacia_saida_id) {

        $data['farmacia_saida_id'] = $farmacia_saida_id;
        $data['nome'] = $this->saida->saidanome($farmacia_saida_id);

        $data['produto'] = $this->saida->listarprodutos($farmacia_saida_id);
        $data['contador'] = $this->saida->contador($farmacia_saida_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->saida->listarsaidas($farmacia_saida_id);
        }
        $this->loadView('farmacia/saidaitens-form', $data);
    }

    function pesquisar($args = array()) {

        $this->loadView('farmacia/saida-lista', $args);

//            $this->carregarView($data);
    }

    function saidapaciente($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $data['produtossaida'] = $this->saida->listarprodutositemsaidafarmacia($internacao_id);
//        echo '<pre>';
//        var_dump($data['produtos']); die;
        $data['lista'] = $this->saida->listasaidapacienteprescricao($internacao_id);

        $this->loadView('farmacia/saida-pacientelista', $data);

//            $this->carregarView($data);
    }

    function excluirsaida($farmacia_saida_id, $internacao_id, $internacao_prescricao_id) {
        $this->saida->excluirsaida($farmacia_saida_id, $internacao_prescricao_id);

        redirect(base_url() . "farmacia/saida/saidapaciente/$internacao_id");
    }

    function gravarsaidapaciente($internacao_id) {

//        var_dump($_POST); die;
        
//        $contador = $this->saida->gravarsaidaitenspaciente($internacao_id);
        $return = $this->saida->gravarsaidaitenspaciente($internacao_id);
//        $this->loadView('farmacia/saida-pacientelista', $data);
//        if($return != false){
//           
//        }
//            $this->carregarView($data);
        redirect(base_url() . "farmacia/saida/saidapaciente/$internacao_id");
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
