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
class Modelomedicamento extends BaseController {

    function Modelomedicamento() {
        parent::Controller();
        $this->load->model('ambulatorio/modelomedicamento_model', 'modelomedicamento');
        $this->load->model('seguranca/operador_model', 'operador_m');
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
        $this->loadView('ambulatorio/modelomedicamento-lista', $args);
    }

    function pesquisarunidade($args = array()) {
        $this->loadView('ambulatorio/modelomedicamentounidade-lista', $args);
    }

    function carregarmodelomedicamento($modelomedicamento_id) {
        $obj_modelomedicamento = new modelomedicamento_model($modelomedicamento_id);
        $data['obj'] = $obj_modelomedicamento;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelomedicamento-form', $data);
        $this->loadView('ambulatorio/modelomedicamento-form', $data);
    }

    function carregarunidade($unidade_id) {
        $data['unidade'] = $this->modelomedicamento->carregarunidade($unidade_id);
//        $this->load->View('ambulatorio/modelomedicamento-form', $data);
        $this->loadView('ambulatorio/modelomedicamentounidade-form', $data);
    }

    function excluir($exame_modelomedicamento_id) {
        if ($this->procedimento->excluir($exame_modelomedicamento_id)) {
            $mensagem = 'Sucesso ao excluir a Modelomedicamento';
        } else {
            $mensagem = 'Erro ao excluir a modelomedicamento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelomedicamento");
    }
    
    function excluirunidade($unidade_id) {
        $valida = $this->modelomedicamento->excluirunidade($unidade_id);
        if ($valida) {
            $mensagem = 'Sucesso ao excluir a Modelomedicamento';
        } else {
            $mensagem = 'Erro ao excluir a modelomedicamento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelomedicamento/pesquisarunidade");
    }

    function gravar() {
        if($_POST['unidadeid'] != ''){
            $verifica = $this->modelomedicamento->gravar();
            if($verifica){
                $mensagem = 'Sucesso ao excluir a Medicamento';
            } 
            else{
                $mensagem = 'Erro ao excluir o Medicamento';
            }
        }
        else{
            $mensagem = 'Erro. Unidade escolhida não é valida.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelomedicamento");
    }

    function gravarunidade() {
        $unidade_id = $this->modelomedicamento->gravarunidade();
        if ($unidade_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Unidade. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Unidade.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelomedicamento/pesquisarunidade");
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
