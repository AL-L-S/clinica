<?php

/**
* Esta classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
* @author Equipe de desenvolvimento APH
* @version 1.0
* @copyright Prefeitura de Fortaleza
* @access public
* @package Model
* @subpackage GIAH
*/


class Relatorio extends Controller {

	function Relatorio() {
            parent::Controller();
            $this->load->model('giah/relatorio_model', 'relatorio');
            $this->load->model('giah/provento_model', 'provento');
            $this->load->model('giah/competencia_model', 'competencia');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
            $this->load->library('validation');
	}
	
	function index() {
             $this->pesquisarservidor();
            
	}

        function pesquisarservidor($servidor_id=null) {
        $data['lista'] = $this->relatorio->listar($servidor_id);
        $this->carregarView($data, 'giah/relatorios_servidor');
        }

        function servidor (){

            $data[] = $this->competencia->competenciaAtiva();
            $data['lista'] = $this->relatorio->listar();
            $this->load->view('giah/relatorios_servidor', $data);
        }

        function incentivo (){

            $data['competenciaativa'] = $this->competencia->competenciaAtiva();
            $data['lista'] = $this->relatorio->listarIncentivo($data['competenciaativa']);
            $this->load->view('giah/relatorios_incentivo', $data);
        }

        function ir(){

            $data['competenciaativa'] = $this->competencia->competenciaAtiva();
            $data['lista'] = $this->provento->listarProventosIr($data['competenciaativa']);
            $this->load->view('giah/relatorios_ir', $data);
        }

        function inss(){

            $data['competenciaativa'] = $this->competencia->competenciaAtiva();
            $data['lista'] = $this->provento->listarProventosInss($data['competenciaativa']);
            $this->load->view('giah/relatorios_inss', $data);
        }

        function suplementar (){

            $data['competenciaativa'] = $this->competencia->competenciaAtiva();
            $data['lista'] = $this->relatorio->listarSuplementar($data['competenciaativa']);
            $this->load->view('giah/relatorios_suplementar', $data);
        }

        function provento (){
            $data['competenciaativa'] = $this->competencia->competenciaAtiva();
            $data['lista'] = $this->relatorio->listarprovento($data['competenciaativa']);
            //$data['lista'] = $this->relatorio->listarSuplementar($data['competenciaativa']);
            $this->load->view('giah/relatorios_provento', $data);
           
        }

        function pensionista (){
            $data['lista'] = $this->relatorio->listarPencionista();
            $this->load->view('giah/relatorios_pensionista', $data);
        }

        private function carregarView($data=null, $view=null) {
            if (!isset ($data)) { $data['mensagem'] = ''; }

            if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true)
            {
                $this->load->view('header', $data);
                if ($view != null) {
                    $this->load->view($view, $data);
                } else {
                    $this->load->view('giah/relatorios', $data);
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