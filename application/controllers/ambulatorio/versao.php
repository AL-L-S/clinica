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
class Versao extends BaseController {

    function Versao() {
        parent::Controller();
        $this->load->model('ambulatorio/versao_model', 'versao');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/versao-lista', $args);

//            $this->carregarView($data);
    }

    function pesquisardetalhes($versao) {
        $data['lista'] = $this->versao->listardetalhesversao($versao);
        $this->loadView('ambulatorio/versaodetalhes-lista', $data);

//            $this->carregarView($data);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */