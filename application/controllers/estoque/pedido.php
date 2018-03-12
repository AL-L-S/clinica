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
class Pedido extends BaseController {

    function Pedido() {
        parent::Controller();
        $this->load->model('estoque/pedido_model', 'pedido');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function carregarpedido($estoque_pedido_id) {

        $data['estoque_pedido_id'] = $estoque_pedido_id;
        $data['nome'] = $this->pedido->pedidonome($estoque_pedido_id);

        $data['produto'] = $this->pedido->listarprodutos();
        $data['produtosPedido'] = $this->pedido->listarpedidos($estoque_pedido_id);
        
        $this->loadView('estoque/pedidoitens-form', $data);
    }

    function carregarsaida($estoque_pedido_id) {

        $data['estoque_pedido_id'] = $estoque_pedido_id;
        $data['nome'] = $this->pedido->pedidonome($estoque_pedido_id);
//        echo '<pre>';
//        var_dump($data['nome']);die;
        $data['contador'] = $this->pedido->contador($estoque_pedido_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->pedido->listarpedidos($estoque_pedido_id);
        }
        $data['contadorsaida'] = $this->pedido->contadorsaidaitem($estoque_pedido_id);
        $data['produtossaida'] = $this->pedido->listarsaidaitem($estoque_pedido_id);
        $this->loadView('estoque/saida-form', $data);
    }

    function imprimirpedido($estoque_pedido_id) {
        $data['relatorio'] = $this->pedido->relatorioimpressaopedido($estoque_pedido_id);
        $this->load->View('estoque/impressaorelatoriopedidocompra', $data);
    }

    function imprimirsaida($estoque_pedido_id) {

        $data['estoque_pedido_id'] = $estoque_pedido_id;
        $data['nome'] = $this->pedido->pedidonome($estoque_pedido_id);

        $data['armazem'] = $this->pedido->listararmazem();
        $data['contador'] = $this->pedido->contador($estoque_pedido_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->pedido->listarpedidos($estoque_pedido_id);
        }
        $data['contadorsaida'] = $this->pedido->contadorsaidaitem($estoque_pedido_id);
        $data['produtossaida'] = $this->pedido->listarsaidaitem($estoque_pedido_id);
        $this->loadView('estoque/saida-form', $data);
    }

    function imprimir($estoque_pedido_id) {
        
        $data['estoque_pedido_id'] = $estoque_pedido_id;
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['nome'] = $this->pedido->pedidonome($estoque_pedido_id);
        $data['produtossaida'] = $this->pedido->listarsaidaitemrelatorio($estoque_pedido_id);
        $this->load->View('estoque/impressaosaida', $data);
    }

    function imprimirliberada($estoque_pedido_id) {

        $data['estoque_pedido_id'] = $estoque_pedido_id;
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['nome'] = $this->pedido->pedidonomeliberado($estoque_pedido_id);
        $data['produtossaida'] = $this->pedido->listaritemliberado($estoque_pedido_id);
        $this->load->View('estoque/impressaoliberada', $data);
    }

    function saidaitens($estoque_pedido_itens_id, $estoque_pedido_id) {

        $data['estoque_pedido_id'] = $estoque_pedido_id;
        $data['estoque_pedido_itens_id'] = $estoque_pedido_itens_id;
        $data['nome'] = $this->pedido->pedidonome($estoque_pedido_id);

        $data['armazem'] = $this->pedido->listararmazem();
        $data['contador'] = $this->pedido->contadorprodutositem($estoque_pedido_itens_id);
        $data['produto'] = $this->pedido->listarpedidos($estoque_pedido_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->pedido->listarprodutositem($estoque_pedido_itens_id);
        }

//        var_dump($data['contador']);
//        die;
        $data['contadorsaida'] = $this->pedido->contadorsaidaitem($estoque_pedido_id);
        $data['produtossaida'] = $this->pedido->listarsaidaitem($estoque_pedido_id);
        $this->loadView('estoque/saidaitens-form', $data);
    }

    function gravarsaidaitens() {
        $estoque_pedido_id = $_POST['txtestoque_pedido_id'];
        $estoque_pedido_itens_id = $_POST['txtestoque_pedido_itens_id'];
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
            $data['produtos'] = $this->pedido->listarprodutositem($estoque_pedido_itens_id);
            $this->pedido->gravarsaidaitens();
        }
        redirect(base_url() . "estoque/pedido/saidaitens/$estoque_pedido_itens_id/$estoque_pedido_id");
    }

    function gravaritens() {
        $estoque_pedido_id = $_POST['txtestoque_pedido_id'];
        if($_POST['produto_id'] == '' ){
            $data['mensagem'] = 'Insira um produto valido.';
            $this->session->set_flashdata('message', $data['mensagem']);
        }
        elseif($_POST['txtqtde'] == ''){
            $data['mensagem'] = 'Insira uma quantidade valida.';
            $this->session->set_flashdata('message', $data['mensagem']);
        }
        else {
            $this->pedido->gravaritens();
        }
        
        redirect(base_url() . "estoque/pedido/carregarpedido/$estoque_pedido_id");
    }

    function excluirpedido($estoque_pedido_itens_id, $estoque_pedido_id) {
        $this->pedido->excluirpedido($estoque_pedido_itens_id);
        redirect(base_url() . "estoque/pedido/carregarpedido/$estoque_pedido_id");
    }

    function excluirsaida($estoque_saida_id, $estoque_pedido_id, $estoque_pedido_itens_id) {
        $this->pedido->excluirsaida($estoque_saida_id);
        redirect(base_url() . "estoque/pedido/saidaitens/$estoque_pedido_itens_id/$estoque_pedido_id");
    }

    function excluirsaidapedido($estoque_saida_id, $estoque_pedido_id) {
        $this->pedido->excluirsaida($estoque_saida_id);
        redirect(base_url() . "estoque/pedido/carregarsaida/$estoque_pedido_id");
    }

    function liberarpedido($estoque_pedido_id) {
        $this->pedido->liberarpedido($estoque_pedido_id);
        redirect(base_url() . "estoque/pedido/pesquisar");
    }

    function fecharpedido($estoque_pedido_id) {
        $this->pedido->fecharpedido($estoque_pedido_id);
        redirect(base_url() . "estoque/pedido/pesquisar");
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/pedido-lista', $args);

//            $this->carregarView($data);
    }

    function manterpedido($estoque_pedido_id) {
        $obj_pedido = new pedido_model($estoque_pedido_id);
        $data['obj'] = $obj_pedido;
        
        $this->loadView('estoque/pedido-form', $data);
    }

    function excluir($estoque_pedido_id) {
        $valida = $this->pedido->excluir($estoque_pedido_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir o Pedido';
        } else {
            $data['mensagem'] = 'Erro ao excluir o pedido. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/pedido");
    }

    function gravar() {
        $estoque_pedido_setor_id = $this->pedido->gravar();
        if ($estoque_pedido_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Pedido. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Pedido.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/pedido/carregarpedido/$estoque_pedido_setor_id");
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
