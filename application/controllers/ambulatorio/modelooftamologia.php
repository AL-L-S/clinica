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
class Modelooftamologia extends BaseController {

    function Modelooftamologia() {
        parent::Controller();
        $this->load->model('ambulatorio/modelooftamologia_model', 'modelooftamologia');
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

        $this->loadView('ambulatorio/modelooftamologia-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmodelooftamologiaacuidadeod($exame_modelooftamologia_id = null) {
        $data['acuidadeod'] = $this->modelooftamologia->listaracuidadeod($exame_modelooftamologia_id);
//        var_dump($data['acuidadeod']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaacuidadeod-form', $data);
    }

    function excluiracuidadeod($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluiracuidadeod($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaacuidadeod");
    }

    function gravaracuidadeod() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravaracuidadeod();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaacuidadeod");
    }

    function carregarmodelooftamologiaacuidadeoe($exame_modelooftamologia_id = null) {
        $data['acuidadeoe'] = $this->modelooftamologia->listaracuidadeoe($exame_modelooftamologia_id);
//        var_dump($data['acuidadeoe']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaacuidadeoe-form', $data);
    }

    function excluiracuidadeoe($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluiracuidadeoe($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaacuidadeoe");
    }

    function gravaracuidadeoe() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravaracuidadeoe();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaacuidadeoe");
    }

    function carregarmodelooftamologiaadcl($exame_modelooftamologia_id = null) {
        $data['adcl'] = $this->modelooftamologia->listaradcl($exame_modelooftamologia_id);
//        var_dump($data['adcl']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaadcl-form', $data);
    }

    function excluiradcl($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluiradcl($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaadcl");
    }

    function gravaradcl() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravaradcl();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaadcl");
    }

    function carregarmodelooftamologiaades($exame_modelooftamologia_id = null) {
        $data['ades'] = $this->modelooftamologia->listarades($exame_modelooftamologia_id);
//        var_dump($data['ades']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaades-form', $data);
    }

    function excluirades($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluirades($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaades");
    }

    function gravarades() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravarades();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaades");
    }

    function carregarmodelooftamologiaodcl($exame_modelooftamologia_id = null) {
        $data['odcl'] = $this->modelooftamologia->listarodcl($exame_modelooftamologia_id);
//        var_dump($data['odcl']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaodcl-form', $data);
    }

    function excluirodcl($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluirodcl($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaodcl");
    }

    function gravarodcl() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravarodcl();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaodcl");
    }

    function carregarmodelooftamologiaodes($exame_modelooftamologia_id = null) {
        $data['odes'] = $this->modelooftamologia->listarodes($exame_modelooftamologia_id);
//        var_dump($data['odes']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaodes-form', $data);
    }

    function excluirodes($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluirodes($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaodes");
    }

    function gravarodes() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravarodes();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaodes");
    }

    function carregarmodelooftamologiaodeixo($exame_modelooftamologia_id = null) {
        $data['odeixo'] = $this->modelooftamologia->listarodeixo($exame_modelooftamologia_id);
//        var_dump($data['odeixo']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaodeixo-form', $data);
    }

    function excluirodeixo($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluirodeixo($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaodeixo");
    }

    function gravarodeixo() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravarodeixo();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaodeixo");
    }

    function carregarmodelooftamologiaodav($exame_modelooftamologia_id = null) {
        $data['odav'] = $this->modelooftamologia->listarodav($exame_modelooftamologia_id);
//        var_dump($data['odav']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaodav-form', $data);
    }

    function excluirodav($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluirodav($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaodav");
    }

    function gravarodav() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravarodav();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaodav");
    }

    function carregarmodelooftamologiaoecl($exame_modelooftamologia_id = null) {
        $data['oecl'] = $this->modelooftamologia->listaroecl($exame_modelooftamologia_id);
//        var_dump($data['oecl']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaoecl-form', $data);
    }

    function excluiroecl($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluiroecl($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaoecl");
    }

    function gravaroecl() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravaroecl();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaoecl");
    }

    function carregarmodelooftamologiaoees($exame_modelooftamologia_id = null) {
        $data['oees'] = $this->modelooftamologia->listaroees($exame_modelooftamologia_id);
//        var_dump($data['oees']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaoees-form', $data);
    }

    function excluiroees($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluiroees($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaoees");
    }

    function gravaroees() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravaroees();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaoees");
    }

    function carregarmodelooftamologiaoeeixo($exame_modelooftamologia_id = null) {
        $data['oeeixo'] = $this->modelooftamologia->listaroeeixo($exame_modelooftamologia_id);
//        var_dump($data['oeeixo']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaoeeixo-form', $data);
    }

    function excluiroeeixo($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluiroeeixo($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaoeeixo");
    }

    function gravaroeeixo() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravaroeeixo();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaoeeixo");
    }

    function carregarmodelooftamologiaoeav($exame_modelooftamologia_id = null) {
        $data['oeav'] = $this->modelooftamologia->listaroeav($exame_modelooftamologia_id);
//        var_dump($data['oeav']); die;
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $this->load->View('ambulatorio/modelooftamologia-form', $data);
        $this->loadView('ambulatorio/modelooftamologiaoeav-form', $data);
    }

    function excluiroeav($exame_modelooftamologia_id) {
        if ($this->modelooftamologia->excluiroeav($exame_modelooftamologia_id)) {
            $mensagem = 'Sucesso ao excluir o item do campo';
        } else {
            $mensagem = 'Erro ao excluir o item do campo.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaoeav");
    }

    function gravaroeav() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravaroeav();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia/carregarmodelooftamologiaoeav");
    }

    function gravar() {
        $exame_modelooftamologia_id = $this->modelooftamologia->gravar();
        if ($exame_modelooftamologia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Modelooftamologia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Modelooftamologia.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/modelooftamologia");
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
