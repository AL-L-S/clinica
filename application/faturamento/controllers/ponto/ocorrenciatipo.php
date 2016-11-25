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
class Ocorrenciatipo extends BaseController
{

    function Ocorrenciatipo()
    {
        parent::Controller();
        $this->load->model('ponto/ocorrenciatipo_model', 'ocorrenciatipo');
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

        $this->loadView('ponto/ocorrenciatipo-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($ocorrenciatipo_id)
    {
        $obj_ocorrenciatipo = new ocorrenciatipo_model($ocorrenciatipo_id);
        $data['obj'] = $obj_ocorrenciatipo;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ponto/ocorrenciatipo-form', $data);
    }

    function excluir($ocorrenciatipo_id)
    {
        if ($this->ocorrenciatipo->excluir($ocorrenciatipo_id)) {
            $mensagem = 'Sucesso ao excluir a ocorrencia tipo.';
        } else {
            $mensagem = 'Erro ao excluir a ocorrencia tipo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ponto/ocorrenciatipo");
    }

    function gravar()
    {
        $ocorrenciatipo_id = $this->ocorrenciatipo->gravar();
        //    { $mensagem = 'servidor003';}
        if ($ocorrenciatipo_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o ocorrencia tipo. Opera&ccedil;&atilde;o cancelada.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Sucesso ao gravar o ocorrencia tipo.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/ocorrenciatipo");

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