<?php

require_once APPPATH . 'controllers/base/BaseController.php';
class Ceatoxrelatorio extends BaseController {

        function Ceatoxrelatorio() {
            parent::Controller();
            $this->load->model('ceatox/ceatoxrelatorio_model', 'ceatoxrelatorio_m');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
            $this->load->library('validation');
        }

        function index() {
                $this->loadView('ceatox/ceatoxrelatorio-lista');
        }


        function agentetoxicocircunstancia(){

            $this->loadView('ceatox/agentetoxicocircunstancia-relatorio');

        }

        function agentetoxicoidade(){

            $this->loadView('ceatox/agentetoxicoidade-relatorio');

        }


        function agentetoxicozona(){

            $this->loadView('ceatox/agentetoxicozona-relatorio');

        }

        function agentetoxicosexo(){

            $this->loadView('ceatox/agentetoxicosexo-relatorio');

        }

        function agentetoxicoevolucao(){

            $this->loadView('ceatox/agentetoxicoevolucao-relatorio');

        }

       function agentetoxico(){
            $this->load-> plugin('to_pdf_pi');
            $data['lista'] = $this->ceatoxrelatorio_m->listarAgenteToxico();
            $this->load->view('ceatox/agentetoxico-relatorio', $data);

        }



}