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
class Grupoconta extends BaseController {

    function Grupoconta() {
        parent::Controller();
        $this->load->model('cadastro/grupoconta_model', 'grupoconta');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/grupoconta-lista', $args);

//            $this->carregarView($data);
    }

    function carregargrupoconta($grupoconta_id) {
        $obj_grupoconta = new grupoconta_model($grupoconta_id);
        $data['obj'] = $obj_grupoconta;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/grupoconta-form', $data);
    }

    function carregargrupocontaadicionar($grupoconta_id) {
        $data['relatorio'] = $this->grupoconta->listargrupocontaadicionar($grupoconta_id);
        $data['contas'] = $this->forma->listarcontas();
        $obj_grupoconta = new grupoconta_model($grupoconta_id);
        $data['obj'] = $obj_grupoconta;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/grupocontaadicionar-form', $data);
    }

    function excluir($grupoconta_id) {
        if ($this->grupoconta->excluir($grupoconta_id)) {
            $mensagem = 'Sucesso ao excluir a Grupo Conta';
        } else {
            $mensagem = 'Erro ao excluir a Grupo Conta. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/grupoconta");
    }
    
    function excluircontagrupo($conta_grupo_contas_id, $conta_grupo_id) {
        if ($this->grupoconta->excluircontagrupo($conta_grupo_contas_id)) {
            $mensagem = 'Sucesso ao excluir Conta';
        } else {
            $mensagem = 'Erro ao excluir Conta. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/grupoconta/carregargrupocontaadicionar/$conta_grupo_id");
    }

    function gravar() {
        $grupoconta_id = $this->grupoconta->gravar();
        if ($grupoconta_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Grupo Conta. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Grupo Conta.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoconta");
    }

    function gravaradicionar() {
        if ($_POST['conta'] != '') {
            $conta = $this->grupoconta->listargrupocontaadicionarteste();
        } else {
            $conta = array();
        }
//        var_dump($medico); die;

        if (count($conta) == 0) {
            $grupoconta_id = $this->grupoconta->gravaradicionar();
            if ($grupoconta_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar a Grupo Conta. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar a Grupo Conta.';
            }
        } else {
            $data['mensagem'] = 'Já existe um registro dessa conta no grupo.';
            $grupoconta_id = $_POST['grupocontaid'];
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoconta/carregargrupocontaadicionar/$grupoconta_id");
    }

//    function ativar($exame_grupomedico_id) {
//        $this->grupomedico->ativar($exame_grupomedico_id);
//        $data['mensagem'] = 'Sucesso ao ativar a Grupomedico.';
//        $this->session->set_flashdata('message', $data['mensagem']);
//        redirect(base_url() . "cadastros/grupomedico");
//    }

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

