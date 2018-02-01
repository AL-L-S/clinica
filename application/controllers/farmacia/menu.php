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
class Menu extends BaseController {

    function Menu() {
        parent::Controller();
        $this->load->model('farmacia/menu_model', 'menu');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function criarmenu($farmacia_menu_id) {

        $data['menu'] = $this->menu->listarmenu($farmacia_menu_id);
        $data['produto'] = $this->menu->listarprodutos();
        $data['contador'] = $this->menu->contador($farmacia_menu_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->menu->listarmenus($farmacia_menu_id);
        }
        $this->loadView('farmacia/menuitens-form', $data);
    }

    function gravaritens() {
        $farmacia_menu_id = $_POST['txtfarmacia_menu_id'];
        $this->menu->gravaritens();
        $this->criarmenu($farmacia_menu_id);
    }

    function excluirmenu($farmacia_menu_produtos_id, $farmacia_menu_id) {
        $this->cliente->excluirclientes($farmacia_menu_produtos_id);
        $this->clientesetor($farmacia_menu_id);
    }

    function pesquisar($args = array()) {

        $this->loadView('farmacia/menu-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmenu($farmacia_menu_id) {
        $obj_menu = new menu_model($farmacia_menu_id);
        $data['obj'] = $obj_menu;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('farmacia/menu-form', $data);
    }

    function excluir($farmacia_menu_id) {
        $valida = $this->menu->excluir($farmacia_menu_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Menu';
        } else {
            $data['mensagem'] = 'Erro ao excluir a menu. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/menu");
    }

    function gravar() {
        $exame_menu_id = $this->menu->gravar();
        if ($exame_menu_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Menu. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Menu.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/menu");
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
