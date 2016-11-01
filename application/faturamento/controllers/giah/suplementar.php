<?php

/**
* Esta classe é o controler de Suplentar. Responsável por chamar as funções e views, efetuando as chamadas de models
* @author Equipe de desenvolvimento APH
* @version 1.0
* @copyright Prefeitura de Fortaleza
* @access public
* @package Model
* @subpackage GIAH
*/


class Suplementar extends Controller {

	function Suplementar () {
            parent::Controller();
            $this->load->model('giah/suplementar_model','suplementar');
            $this->load->model('giah/servidor_model', 'servidor');
            $this->load->model('giah/competencia_model', 'competencia');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
	}
	
	function index() {
            
	}

        function pesquisar($servidor_id) {
            $competencia = $this->competencia->competenciaAtiva();
            if ($competencia == '000000') {
                redirect(base_url()."giah/servidor","refresh");
            }else {
                $data['servidor'] = new Servidor_model($servidor_id);
                $data['lista'] = $this->suplementar->listarSuplementarDoServidor($servidor_id, $competencia);
                $data['teto']  = $this->servidor->listarTeto($servidor_id);
                $this->carregarView($data);
            }
        }

        function excluir($servidor_id) {
            $competencia = $this->competencia->competenciaAtiva();
            if ($this->suplementar->excluir($servidor_id, $competencia))
            { $data['mensagem'] = 'Sucesso ao excluir a suplementar.'; }
            else
            { $data['mensagem'] = 'Erro ao excluir a suplementar. Opera&ccedil;&atilde;o cancelada.'; }
            $data['servidor'] = new Servidor_model($servidor_id);
            $data['lista'] = $this->suplementar->listarSuplementarDoServidor($servidor_id, $competencia);
//            $this->carregarView($data);
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url()."giah/suplementar/pesquisar/$servidor_id",$data);
        }

        function gravar() {
            $competencia    = $this->competencia->competenciaAtiva();
            $servidor_id    = $_POST['txtServidorID'];

            if ($this->suplementar->gravar($competencia)) {
                $data['mensagem'] = 'Sucesso ao gravar a suplementar.';
            } else {
                $data['mensagem'] = 'Erro ao gravar a suplementar. Opera&ccedil;&atilde;o cancelada.';
            }
            $data['servidor'] = new Servidor_model($servidor_id);
            $data['lista'] = $this->suplementar->listarSuplementarDoServidor($servidor_id, $competencia);
//            $this->carregarView($data);
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url()."giah/suplementar/pesquisar/$servidor_id",$data);
        }

        private function carregarView($data=null, $view=null) {
            if (!isset ($data)) { $data['mensagem'] = ''; }
            if ($this->utilitario->autorizar(4, $this->session->userdata('modulo')) == true)
            {
                $this->load->view('header', $data);
                if (!isset ($view))
                { $this->load->view('giah/suplementar-lista', $data); }
                else
                { $this->load->view($view, $data); }
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