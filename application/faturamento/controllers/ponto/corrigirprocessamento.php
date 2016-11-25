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
class Corrigirprocessamento extends BaseController
{

    function Corrigirprocessamento()
    {
        parent::Controller();
        $this->load->model('ponto/corrigirprocessamento_model', 'corrigirprocessamento');
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

        $this->loadView('ponto/funcionario-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($criticafinal_id, $funcionario_id)
    {

        $obj_criticafinal = new Corrigirprocessamento_model($criticafinal_id);
        $data['obj'] = $obj_criticafinal;
        $data['funcionario'] = $funcionario_id;
        $this->loadView('ponto/corrigirprocessamento-form', $data);
    }

    function gravar($criticafinal_id, $funcionario_id)
    {
        $criticafinal_id = $this->corrigirprocessamento->gravar($criticafinal_id);
        if ($criticafinal_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o critica. Opera&ccedil;&atilde;o cancelada.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Sucesso ao gravar o critica.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/funcionario/impressaocartao/$funcionario_id");

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