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
class Funcao extends BaseController
{

    function Funcao()
    {
        parent::Controller();
        $this->load->model('ponto/funcao_model', 'funcao');
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

        $this->loadView('ponto/funcao-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($funcao_id)
    {
        $obj_funcao = new Funcao_model($funcao_id);
        $data['obj'] = $obj_funcao;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ponto/funcao-form', $data);
    }

    function excluir($funcao_id)
    {
        if ($this->funcao->excluir($funcao_id)) {
            $mensagem = 'Sucesso ao excluir a fun&ccedil;&atilde;o.';
        } else {
            $mensagem = 'Erro ao excluir a fun&ccedil;&atilde;o. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ponto/funcao");
    }

    function gravar()
    {
        $funcao_id = $this->funcao->gravar();
        //    { $mensagem = 'servidor003';}
        if ($funcao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o fun&ccedil;&atilde;o. Opera&ccedil;&atilde;o cancelada.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Sucesso ao gravar o fun&ccedil;&atilde;o.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/funcao");

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