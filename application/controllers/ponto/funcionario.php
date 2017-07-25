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
class Funcionario extends BaseController
{

    function Funcionario()
    {
        parent::Controller();
        $this->load->model('ponto/funcionario_model', 'funcionario');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->model('ponto/horariostipo_model', 'horariostipo');
        $this->load->model('ponto/funcao_model', 'funcao');
        $this->load->model('ponto/setor_model', 'setor');
        $this->load->model('ponto/cargo_model', 'cargo');
        $this->load->helper('date');
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

    function carregar($funcionario_id)
    {

        $obj_funcionario = new Funcionario_model($funcionario_id);
        $data['obj'] = $obj_funcionario;

        $data['funcao'] = $this->funcao->listarautocomplete();
        $data['cargo'] = $this->cargo->listarautocomplete();
        $data['setor'] = $this->setor->listarautocomplete();

        $this->loadView('ponto/funcionario-form', $data);
    }

    function relatorio()
    {

        $data['lista'] = $this->funcionario->relatorio();
        $this->load->View('ponto/relatorios_funcionario', $data);
    }
    
    function impressaocartao($funcionario_id)
    {
        $competencia = $this->competencia->listaAtiva();
        $inicio = $competencia[0]->data_abertura;
        $fim = $competencia[0]->data_fechamento;
        $obj_funcionario = new Funcionario_model($funcionario_id);
        $data['obj'] = $obj_funcionario;
        $data['critica'] = $this->funcionario->listarcritica($funcionario_id, $inicio, $fim);
        $data['horario'] = $this->funcionario->listarhorariovariavel($funcionario_id);
        $data['lista'] = $this->horariostipo->listarhoarioindividual($funcionario_id);
        $this->load->View('ponto/impressao-cartao', $data);
    }

    function excluirfuncionario($funcionario_id)
    {
        if ($this->funcionario->excluirfuncionario($funcionario_id)) {
            $data['mensagem'] = 'Sucesso ao excluir o funcionario.';
        } else {
            $data['mensagem'] = 'Erro ao excluir o funcionarior. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/funcionario");
    }

    function gravar()
    {
        $funcionario_id = $this->funcionario->gravar();
        if ($funcionario_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o funcionario. Opera&ccedil;&atilde;o cancelada.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Sucesso ao gravar o funcionario.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/funcionario");

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