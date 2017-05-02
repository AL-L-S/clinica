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
        $this->load->model('estoque/solicitacao_model', 'solicitacao');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function carregarsolicitacao($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);

        $data['produto'] = $this->solicitacao->listarprodutos($estoque_solicitacao_id);
        $data['contador'] = $this->solicitacao->contador($estoque_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($estoque_solicitacao_id);
        }
        $this->loadView('estoque/solicitacaoitens-form', $data);
    }

    function carregarsaida($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);
//        echo '<pre>';
//        var_dump($data['nome']);die;
        $data['contador'] = $this->solicitacao->contador($estoque_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($estoque_solicitacao_id);
        }
        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $this->loadView('estoque/saida-form', $data);
    }

    function imprimirsaida($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);

        $data['armazem'] = $this->solicitacao->listararmazem();
        $data['contador'] = $this->solicitacao->contador($estoque_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($estoque_solicitacao_id);
        }
        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $this->loadView('estoque/saida-form', $data);
    }

    function imprimir($estoque_solicitacao_id) {
        
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitemrelatorio($estoque_solicitacao_id);
        $this->load->View('estoque/impressaosaida', $data);
    }

    function imprimirliberada($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['nome'] = $this->solicitacao->solicitacaonomeliberado($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);
        $this->load->View('estoque/impressaoliberada', $data);
    }

    function saidaitens($estoque_solicitacao_itens_id, $estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['estoque_solicitacao_itens_id'] = $estoque_solicitacao_itens_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);

        $data['armazem'] = $this->solicitacao->listararmazem();
        $data['contador'] = $this->solicitacao->contadorprodutositem($estoque_solicitacao_itens_id);
        $data['produto'] = $this->solicitacao->listarsolicitacaos($estoque_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarprodutositem($estoque_solicitacao_itens_id);
        }

//        var_dump($data['contador']);
//        die;
        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $this->loadView('estoque/saidaitens-form', $data);
    }

    function gravarsaidaitens() {
        $estoque_solicitacao_id = $_POST['txtestoque_solicitacao_id'];
        $estoque_solicitacao_itens_id = $_POST['txtestoque_solicitacao_itens_id'];
//        
//        $_POST['txtqtde'] = (int) $_POST['txtqtde'];
//        $_POST['qtdedisponivel'] = (int) $_POST['qtdedisponivel'];
//        var_dump($_POST['qtdedisponivel']); die;
        
        if($_POST['produto_id'] == ''){
            $data['mensagem'] = 'Insira um produto valido.';
            $this->session->set_flashdata('message', $data['mensagem']);
        }                
        elseif( $_POST['txtqtde'] == ''){
            $data['mensagem'] = 'Insira uma quantidade valida.';
            $this->session->set_flashdata('message', $data['mensagem']);
        }
        elseif( isset($_POST['qtdedisponivel']) && ( (int)$_POST['txtqtde'] > (int)$_POST['qtdedisponivel']) ){
            $data['mensagem'] = 'Quantidade selecionada excede o saldo disponivel.';
            $this->session->set_flashdata('message', $data['mensagem']);
        }
        else{
            //nao permitir quantidades maiores que o que tem
            $data['produtos'] = $this->solicitacao->listarprodutositem($estoque_solicitacao_itens_id);
            $this->solicitacao->gravarsaidaitens();
        }
        redirect(base_url() . "estoque/solicitacao/saidaitens/$estoque_solicitacao_itens_id/$estoque_solicitacao_id");
    }

    function gravaritens() {
        $estoque_solicitacao_id = $_POST['txtestoque_solicitacao_id'];
        if($_POST['produto_id'] == '' ){
            $data['mensagem'] = 'Insira um produto valido.';
            $this->session->set_flashdata('message', $data['mensagem']);
        }
        elseif($_POST['txtqtde'] == ''){
            $data['mensagem'] = 'Insira uma quantidade valida.';
            $this->session->set_flashdata('message', $data['mensagem']);
        }
        else {
            $this->solicitacao->gravaritens();
        }
        
        redirect(base_url() . "estoque/solicitacao/carregarsolicitacao/$estoque_solicitacao_id");
    }

    function excluirsolicitacao($estoque_solicitacao_itens_id, $estoque_solicitacao_id) {
        $this->solicitacao->excluirsolicitacao($estoque_solicitacao_itens_id);
        redirect(base_url() . "estoque/solicitacao/carregarsolicitacao/$estoque_solicitacao_id");
    }

    function excluirsaida($estoque_saida_id, $estoque_solicitacao_id, $estoque_solicitacao_itens_id) {
        $this->solicitacao->excluirsaida($estoque_saida_id);
        redirect(base_url() . "estoque/solicitacao/saidaitens/$estoque_solicitacao_itens_id/$estoque_solicitacao_id");
    }

    function excluirsaidasolicitacao($estoque_saida_id, $estoque_solicitacao_id) {
        $this->solicitacao->excluirsaida($estoque_saida_id);
        redirect(base_url() . "estoque/solicitacao/carregarsaida/$estoque_solicitacao_id");
    }

    function liberarsolicitacao($estoque_solicitacao_id) {
        $this->solicitacao->liberarsolicitacao($estoque_solicitacao_id);
        redirect(base_url() . "estoque/solicitacao/pesquisar");
    }

    function fecharsolicitacao($estoque_solicitacao_id) {
        $this->solicitacao->fecharsolicitacao($estoque_solicitacao_id);
        redirect(base_url() . "estoque/solicitacao/pesquisar");
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/solicitacao-lista', $args);

//            $this->carregarView($data);
    }

    function criarsolicitacao($estoque_solicitacao_id) {
        $obj_solicitacao = new solicitacao_model($estoque_solicitacao_id);
        $data['obj'] = $obj_solicitacao;
        $data['setor'] = $this->solicitacao->listarclientes();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('estoque/solicitacao-form', $data);
    }

    function excluir($estoque_solicitacao_setor_id) {
        $valida = $this->solicitacao->excluir($estoque_solicitacao_setor_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Solicitacao';
        } else {
            $data['mensagem'] = 'Erro ao excluir a solicitacao. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/solicitacao");
    }

    function gravar() {
        $estoque_solicitacao_setor_id = $this->solicitacao->gravar();
        if ($estoque_solicitacao_setor_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Solicitacao. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Solicitacao.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/solicitacao/carregarsolicitacao/$estoque_solicitacao_setor_id");
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
