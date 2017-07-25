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
class Servidor extends BaseController
{

    function Servidor()
    {
        parent::Controller();
        $this->load->model('giah/servidor_model', 'servidor');
        $this->load->model('giah/uo_model', 'uo_m');
        $this->load->model('giah/funcao_model', 'funcao_m');
        $this->load->model('giah/classificacao_model', 'classificacao_m');
        $this->load->model('giah/competencia_model', 'competencia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index()
    {
        $this->pesquisar();
    }

    function pesquisarteto($servidor_id)
    {
        $data['servidor'] = new Servidor_model($servidor_id);
        $data['lista'] = $this->servidor->listarTeto($servidor_id);
        //$this->carregarView($data, 'giah/servidorteto-lista');
        $this->loadView('giah/servidorteto-lista', $data);
    }

    function instaciarteto($teto_id, $servidor_id)
    {

        $data['servidor'] = new Servidor_model($servidor_id);

        $data['teto'] = $this->servidor->instaciarTeto($teto_id);
        //$this->carregarView($data, 'giah/servidorteto-lista');
        $this->loadView('giah/servidorteto-editar', $data);
    }

    function editarteto($teto_id, $servidor_id)
    {
        if ($this->servidor->gravarTeto($teto_id)) {
            $data['mensagem'] = 'Sucesso ao gravar o teto.';
        } else {
            $data['mensagem'] = 'Erro ao gravar o teto.';
        }
        $data['servidor'] = new Servidor_model($servidor_id);

        $data['lista'] = $this->servidor->listarTeto($servidor_id);
        //$this->carregarView($data, 'giah/servidorteto-lista');
        $this->loadView('giah/servidorteto-lista', $data);
    }

    function pesquisar($args = array())
    {

        $this->loadView('giah/servidor-lista', $args);

        $data['competencia'] = $this->competencia->competenciaAtiva();
//            $this->carregarView($data);
    }

    function carregar($servidor_id)
    {
        $obj_servidor = new Servidor_model($servidor_id);
        $data['obj'] = $obj_servidor;

        $data['uos'] = $this->uo_m->listar();
        $data['funcoes'] = $this->funcao_m->listar();
        $data['classificacoes'] = $this->classificacao_m->listar();

        //$this->carregarView($data, 'giah/servidor-form');



        $this->loadView('giah/servidor-form', $data);
    }

    function gravarteto()
    {
        $servidor_id = $_POST['txtServidorID'];
        if ($this->servidor->gravarTeto($servidor_id)) {
            $data['mensagem'] = 'Sucesso ao gravar o teto.';
        } else {
            $data['mensagem'] = 'Erro ao gravar o teto.';
        }
        $data['servidor'] = new Servidor_model($servidor_id);
        $data['lista'] = $this->servidor->listarTeto($servidor_id);
        //$this->carregarView($data, 'giah/servidorteto-lista');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "giah/servidor/pesquisarteto/$servidor_id", $data);
//            $this->loadView('giah/servidorteto-lista', $data);
    }

    function excluirTeto($teto_id, $servidor_id)
    {
        if ($this->servidor->excluirteto($teto_id)) {
            $mensagem = 'Sucesso ao excluir o teto.';
        } else {
            $mensagem = 'Erro ao excluir o teto.';
        }
        $data['servidor'] = new Servidor_model($servidor_id);
        $data['lista'] = $this->servidor->listarTeto($servidor_id);
        //$this->carregarView($data, 'giah/servidorteto-lista');
//            $this->loadView('giah/servidorteto-lista', $data);
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "giah/servidor/pesquisarteto/$servidor_id", $data);
    }

    function excluirServidor($servidor_id)
    {
        if ($this->servidor->excluirServidor($servidor_id)) {
            $mensagem = 'Sucesso ao excluir o servidor.';
        } else {
            $mensagem = 'Erro ao excluir o servidor. Opera&ccedil;&atilde;o cancelada.';
        }

        $data['lista'] = $this->servidor->listar();
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "giah/servidor/index/$data");
    }

    function gravar()
    {
        $servidor_id = $this->servidor->gravar();
        if ($servidor_id == "0") {
            $data['mensagem'] = 'Sucesso ao excluir o servidor.';
        }
        //    { $mensagem = 'servidor003';}
        elseif ($servidor_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o servidor. Opera&ccedil;&atilde;o cancelada.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Sucesso ao gravar o servidor.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "giah/servidor");

        //$this->carregarView();
        //redirect(base_url()."giah/servidor/index/$data","refresh");
    }

    private function carregarView($data=null, $view=null)
    {
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