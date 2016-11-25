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
class Cliente extends BaseController {

    function Cliente() {
        parent::Controller();
        $this->load->model('estoque/cliente_model', 'cliente');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/cliente-lista', $args);

//            $this->carregarView($data);
    }

    function carregarcliente($estoque_cliente_id) {
        $obj_cliente = new cliente_model($estoque_cliente_id);
        $data['obj'] = $obj_cliente;
        $data['menu'] = $this->cliente->listarmenu();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('estoque/cliente-form', $data);
    }

    function excluir($estoque_cliente_id) {
        $valida = $this->cliente->excluir($estoque_cliente_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Cliente';
        } else {
            $data['mensagem'] = 'Erro ao excluir a cliente. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/cliente");
    }

    function clientesetor($operador_id) {

        $data['operadores'] = $this->cliente->listaroperadores($operador_id);
        $data['clientes'] = $this->cliente->listarclientes();
        $data['contador'] = $this->cliente->contador($operador_id);
        if ($data['contador'] > 0) {
            $data['cliente'] = $this->cliente->listarcliente($operador_id);
        }
        $this->loadView('estoque/clientesoperador-form', $data);
    }

    function gravarclientes() {
        $operador_id = $_POST['txtoperador_id'];
        $this->cliente->gravarclientes();
        $this->clientesetor($operador_id);
    }

    function excluirclientes($operado_cliente, $operador_id) {
        $this->cliente->excluirclientes($operado_cliente);
        $this->clientesetor($operador_id);
    }

    function gravar() {
        $exame_cliente_id = $this->cliente->gravar();
        if ($exame_cliente_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Cliente. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Cliente.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/cliente");
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
