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
class Solicitacao extends BaseController {

    function Solicitacao() {
        parent::Controller();
        $this->load->model('farmacia/solicitacao_model', 'solicitacao');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function carregarsolicitacao($farmacia_solicitacao_id) {

        $data['farmacia_solicitacao_id'] = $farmacia_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($farmacia_solicitacao_id);

        $data['produto'] = $this->solicitacao->listarprodutos($farmacia_solicitacao_id);
        $data['contador'] = $this->solicitacao->contador($farmacia_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($farmacia_solicitacao_id);
        }
        $this->loadView('farmacia/solicitacaoitens-form', $data);
    }
    
    function carregarsaida($farmacia_solicitacao_id) {

        $data['farmacia_solicitacao_id'] = $farmacia_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($farmacia_solicitacao_id);
        $data['contador'] = $this->solicitacao->contador($farmacia_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($farmacia_solicitacao_id);
        }
        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($farmacia_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($farmacia_solicitacao_id);
        $this->loadView('farmacia/saida-form', $data);
    }

    function imprimirsaida($farmacia_solicitacao_id) {

        $data['farmacia_solicitacao_id'] = $farmacia_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($farmacia_solicitacao_id);

        $data['armazem'] = $this->solicitacao->listararmazem();
        $data['contador'] = $this->solicitacao->contador($farmacia_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($farmacia_solicitacao_id);
        }
        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($farmacia_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($farmacia_solicitacao_id);
        $this->loadView('farmacia/saida-form', $data);
    }

    function imprimir($farmacia_solicitacao_id) {

        $data['farmacia_solicitacao_id'] = $farmacia_solicitacao_id;
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['nome'] = $this->solicitacao->solicitacaonome($farmacia_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($farmacia_solicitacao_id);
        $this->load->View('farmacia/impressaosaida', $data);
    }

    function saidaitens($farmacia_solicitacao_itens_id, $farmacia_solicitacao_id) {

        $data['farmacia_solicitacao_id'] = $farmacia_solicitacao_id;
        $data['farmacia_solicitacao_itens_id'] = $farmacia_solicitacao_itens_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($farmacia_solicitacao_id);

        $data['armazem'] = $this->solicitacao->listararmazem();
        $data['contador'] = $this->solicitacao->contadorprodutositem($farmacia_solicitacao_itens_id);
        $data['produto'] = $this->solicitacao->listarsolicitacaos($farmacia_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarprodutositem($farmacia_solicitacao_itens_id);
        }

//        var_dump($data['contador']);
//        die;
        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($farmacia_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($farmacia_solicitacao_id);
        $this->loadView('farmacia/saidaitens-form', $data);
    }

    function gravarsaidaitens() {
        $farmacia_solicitacao_id = $_POST['txtfarmacia_solicitacao_id'];
        $farmacia_solicitacao_itens_id = $_POST['txtfarmacia_solicitacao_itens_id'];
        $this->solicitacao->gravarsaidaitens();
        redirect(base_url() . "farmacia/solicitacao/saidaitens/$farmacia_solicitacao_itens_id/$farmacia_solicitacao_id");
    }

    function gravaritens() {
        $farmacia_solicitacao_id = $_POST['txtfarmacia_solicitacao_id'];
        $this->solicitacao->gravaritens();
        $this->carregarsolicitacao($farmacia_solicitacao_id);
    }

    function excluirsolicitacao($farmacia_solicitacao_itens_id, $farmacia_solicitacao_id) {
        $this->solicitacao->excluirsolicitacao($farmacia_solicitacao_itens_id);
        $this->carregarsolicitacao($farmacia_solicitacao_id);
    }

    function excluirsaida($farmacia_saida_id, $farmacia_solicitacao_id, $farmacia_solicitacao_itens_id) {
        $this->solicitacao->excluirsaida($farmacia_saida_id);
        $this->saidaitens($farmacia_solicitacao_itens_id, $farmacia_solicitacao_id);
    }

    function liberarsolicitacao($farmacia_solicitacao_id) {
        $this->solicitacao->liberarsolicitacao($farmacia_solicitacao_id);
        $this->pesquisar();
    }

    function fecharsolicitacao($farmacia_solicitacao_id) {
        $this->solicitacao->fecharsolicitacao($farmacia_solicitacao_id);
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('farmacia/solicitacao-lista', $args);

//            $this->carregarView($data);
    }

    function criarsolicitacao($farmacia_solicitacao_id) {
        $obj_solicitacao = new solicitacao_model($farmacia_solicitacao_id);
        $data['obj'] = $obj_solicitacao;
        $data['setor'] = $this->solicitacao->listarclientes();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('farmacia/solicitacao-form', $data);
    }

    function excluir($farmacia_solicitacao_setor_id) {
        $valida = $this->solicitacao->excluir($farmacia_solicitacao_setor_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Solicitacao';
        } else {
            $data['mensagem'] = 'Erro ao excluir a solicitacao. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/solicitacao");
    }

    function gravar() {
        $farmacia_solicitacao_setor_id = $this->solicitacao->gravar();
        if ($farmacia_solicitacao_setor_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Solicitacao. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Solicitacao.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/solicitacao/carregarsolicitacao/$farmacia_solicitacao_setor_id");
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/servidor-lista', $data);
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
