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
        $this->load->model('estoque/menu_model', 'menu');
        $this->load->model('estoque/cliente_model', 'cliente');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function criarmenu($estoque_menu_id) {

        $data['menu'] = $this->menu->listarmenu($estoque_menu_id);
        $data['tipo'] = $this->menu->listartipos();
//        $data['classe'] = $this->menu->listarclasses();
//        $data['sub_classe'] = $this->menu->listarsubclasses();
        $data['produto'] = $this->menu->listarprodutos();
        $data['contador'] = $this->menu->contador($estoque_menu_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->menu->listarmenus($estoque_menu_id);
        }
        $this->loadView('estoque/menuitens-form', $data);
    }

    function gravaritens() {
        $estoque_menu_id = $_POST['txtestoque_menu_id'];
        if ($_POST['produto_id'] == '') {
            $data['mensagem'] = 'Selecione um produto.';
            $this->session->set_flashdata('message', $data['mensagem']);
        }
        else {
            $this->menu->gravaritens();        
        }
        redirect(base_url() . "estoque/menu/criarmenu/$estoque_menu_id");
//        $this->criarmenu($estoque_menu_id);
    }

    function excluirmenu($estoque_menu_produtos_id, $estoque_menu_id) {
        $this->menu->excluirmenuproduto($estoque_menu_produtos_id);  
        $data['mensagem'] = 'Sucesso ao excluir a Menu';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/menu/criarmenu/$estoque_menu_id");
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/menu-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmenu($estoque_menu_id) {
        $obj_menu = new menu_model($estoque_menu_id);
        $data['obj'] = $obj_menu;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('estoque/menu-form', $data);
    }

    function excluir($estoque_menu_id) {
        $valida = $this->menu->excluir($estoque_menu_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Menu';
        } else {
            $data['mensagem'] = 'Erro ao excluir a menu. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/menu");
    }

    function gravar() {
        $exame_menu_id = $this->menu->gravar();
        if ($exame_menu_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Menu. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Menu.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/menu");
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
