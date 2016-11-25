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
class Cargo extends BaseController
{

    function Cargo()
    {
        parent::Controller();
        $this->load->model('ponto/cargo_model', 'cargo');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index()
    {
        $this->pesquisar();
    }


    function pesquisar($args = array())
    {

        $this->loadView('ponto/cargo-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($cargo_id)
    {
        $obj_cargo = new cargo_model($cargo_id);
        $data['obj'] = $obj_cargo;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ponto/cargo-form', $data);
    }

    function excluir($cargo_id)
    {
        if ($this->cargo->excluir($cargo_id)) {
            $mensagem = 'Sucesso ao excluir o cargo';
        } else {
            $mensagem = 'Erro ao excluir o cargo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ponto/cargo");
    }

    function gravar()
    {
        $cargo_id = $this->cargo->gravar();
        //    { $mensagem = 'servidor003';}
        if ($cargo_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o cargo. Opera&ccedil;&atilde;o cancelada.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Sucesso ao gravar o cargo.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/cargo");

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