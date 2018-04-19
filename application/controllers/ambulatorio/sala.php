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
class Sala extends BaseController {

    function Sala() {
        parent::Controller();
        $this->load->model('ambulatorio/sala_model', 'sala');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/sala-lista', $args);

//            $this->carregarView($data);
    }

    function carregarsala($exame_sala_id) {
        $obj_sala = new sala_model($exame_sala_id);
        $data['obj'] = $obj_sala;
        $data['armazem'] = $this->sala->listararmazem();
        $data['grupos'] = $this->procedimento->listargrupos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/sala-form', $data);
    }

    function excluir($exame_sala_id) {
        if ($this->procedimento->excluir($exame_sala_id)) {
            $mensagem = 'Sucesso ao excluir a Sala';
        } else {
            $mensagem = 'Erro ao excluir a sala. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/sala");
    }

    function excluirsala($exame_sala_id) {
        if ($this->sala->excluirsala($exame_sala_id)) {
            $mensagem = 'Sucesso ao excluir a Sala';
        } else {
            $mensagem = 'Erro ao excluir a sala. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/sala");
    }

    function carregarsalapainel($exame_sala_id) {
        $data['exame_sala_id'] = $exame_sala_id;
        $data['paineis'] = $this->sala->carregarsalapainel($exame_sala_id);
        $this->loadView('ambulatorio/salapainel-form', $data);
    }

    function gravarsalapainel() {
        $exame_sala_id = $_POST['exame_sala_id'];
        $this->sala->gravarsalapainel();
        redirect(base_url() . "ambulatorio/sala/carregarsalapainel/" . $exame_sala_id);
    }

    function carregarsalagrupo($exame_sala_id) {
        $data['exame_sala_id'] = $exame_sala_id;
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['gruposAssociados'] = $this->sala->carregarsalagrupo($exame_sala_id);
        $this->loadView('ambulatorio/salagrupo-form', $data);
    }

    function gravarsalagrupo() {
        $exame_sala_id = $_POST['exame_sala_id'];
        $retorno = $this->sala->gravarsalagrupo();
        if ($retorno == "-1") {
            $data['mensagem'] = 'Erro ao associar o Grupo. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao associar o Grupo.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/sala/carregarsalagrupo/" . $exame_sala_id);
    }

    function excluirsalapainel($sala_painel_id, $sala_id) {
        if ($this->sala->excluirsalapainel($sala_painel_id)) {
            $mensagem = 'Sucesso ao excluir o Painel.';
        } else {
            $mensagem = 'Erro ao excluir o Painel. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/sala/carregarsalapainel/" . $sala_id);
    }

    function excluirmultiplossalagrupo($sala_id) {
//        var_dump($_POST); die;
        if(count($_POST) > 0){
            if ($this->sala->excluirmultiplossalagrupo() ) {
                $mensagem = 'Sucesso ao excluir os Grupos marcados.';
            } else {
                $mensagem = 'Erro ao excluir os Grupos marcados. Opera&ccedil;&atilde;o cancelada.';
            }
            $this->session->set_flashdata('message', $mensagem);
        }

        redirect(base_url() . "ambulatorio/sala/carregarsalagrupo/" . $sala_id);
    }

    function excluirsalagrupo($sala_grupo_id, $sala_id) {
        if ($this->sala->excluirsalagrupo($sala_grupo_id)) {
            $mensagem = 'Sucesso ao excluir o Grupo.';
        } else {
            $mensagem = 'Erro ao excluir o Grupo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/sala/carregarsalagrupo/" . $sala_id);
    }

    function gravar() {
        $grupos = $this->procedimento->listargrupos();
        $exame_sala_id = $this->sala->gravar($grupos);
        if ($exame_sala_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Sala. Opera&ccedil;&atilde;o cancelada.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/sala");
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Sala.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/sala/carregarsalapainel/$exame_sala_id");
    }

    function ativar($exame_sala_id) {
        $this->sala->ativar($exame_sala_id);
        $data['mensagem'] = 'Sucesso ao ativar a Sala.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/sala");
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
