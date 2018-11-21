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
//
//    function carregargrupomedicoadicionar($exame_grupomedico_id) {
//        $data['relatorio'] = $this->grupomedico->listargrupomedicoadicionar($exame_grupomedico_id);
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $obj_grupomedico = new grupomedico_model($exame_grupomedico_id);
//        $data['obj'] = $obj_grupomedico;
//        //$this->carregarView($data, 'giah/servidor-form');
//        $this->loadView('cadastros/grupomedicoadicionar-form', $data);
//    }
//
//    function excluir($grupomedico_id) {
//        if ($this->grupomedico->excluir($grupomedico_id)) {
//            $mensagem = 'Sucesso ao excluir a Grupomedico';
//        } else {
//            $mensagem = 'Erro ao excluir a grupomedico. Opera&ccedil;&atilde;o cancelada.';
//        }
//
//        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "cadastros/grupomedico");
//    }
//    
//    function excluirmedicogrupo($operador_grupo_medico_id, $operador_grupo_id) {
//        if ($this->grupomedico->excluirmedicogrupo($operador_grupo_medico_id)) {
//            $mensagem = 'Sucesso ao excluir Médico';
//        } else {
//            $mensagem = 'Erro ao excluir Médico. Opera&ccedil;&atilde;o cancelada.';
//        }
//
//        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "cadastros/grupomedico/carregargrupomedicoadicionar/$operador_grupo_id");
//    }

    function gravar() {
        $grupoconta_id = $this->grupoconta->gravar();
        if ($grupoconta_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Grupo Conta. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Grupo Conta.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupomedico");
    }

//    function gravaradicionar() {
//        if ($_POST['medico'] != '') {
//            $medico = $this->grupomedico->listargrupomedicoadicionarteste();
//        } else {
//            $medico = array();
//        }
////        var_dump($medico); die;
//
//        if (count($medico) == 0) {
//            $exame_grupomedico_id = $this->grupomedico->gravaradicionar();
//            if ($exame_grupomedico_id == "-1") {
//                $data['mensagem'] = 'Erro ao gravar a Grupomedico. Opera&ccedil;&atilde;o cancelada.';
//            } else {
//                $data['mensagem'] = 'Sucesso ao gravar a Grupomedico.';
//            }
//        } else {
//            $data['mensagem'] = 'Já existe um registro desse médico no grupo.';
//            $exame_grupomedico_id = $_POST['grupomedicoid'];
//        }
//        $this->session->set_flashdata('message', $data['mensagem']);
//        redirect(base_url() . "cadastros/grupomedico/carregargrupomedicoadicionar/$exame_grupomedico_id");
//    }
//
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

