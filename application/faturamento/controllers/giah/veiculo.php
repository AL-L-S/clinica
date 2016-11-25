<?php

class Veiculo extends Controller {

	function Veiculo () {
            parent::Controller();
            $this->load->model('giah/veiculo_model','veiculo');
            $this->load->model('giah/servidor_model', 'servidor');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
	}
	
	function index() {
            
	}

        function pesquisar($servidor_id) {
                if ($this->utilitario->autorizar(16, $this->session->userdata('modulo')) == true){
                $data['servidor'] = new Servidor_model($servidor_id);
                $data['lista'] = $this->veiculo->listarVeiculoDoServidor($servidor_id);
                $data['cor']    = $this->veiculo->listarCor();
                $data['marca']     = $this->veiculo->listarMarca();
                $this->carregarView($data);
                }else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
                }


        }

        function pesquisarestacionamento($filtro=-1) {
            if (isset ($_POST['filtro']))
            { $filtro = $_POST['filtro']; }
                if ($this->utilitario->autorizar(18, $this->session->userdata('modulo')) == true){
                $data['lista'] = $this->veiculo->listarEstacionamento($filtro);
                $this->carregarView($data, 'giah/estacionamento-lista');
                }else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
                }
        }

        function excluir($servidor_id, $veiculo_id) {
            
            if ($this->veiculo->excluir($veiculo_id))
            { $data['mensagem'] = 'Sucesso ao excluir o veiculo.'; }
            else
            { $data['mensagem'] = 'Erro ao excluir o veiculo. Opera&ccedil;&atilde;o cancelada.'; }
            
            $data['servidor'] = new Servidor_model($servidor_id);
            $data['lista'] = $this->veiculo->listarVeiculoDoServidor($servidor_id);
            $data['cor']    = $this->veiculo->listarCor();
            $data['marca']     = $this->veiculo->listarMarca();
//            $this->carregarView($data);
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url()."giah/veiculo/pesquisar/$servidor_id",$data);
        }

        function gravar() {
            
            $servidor_id    = $_POST['txtServidorID'];

            if ($this->veiculo->gravar()) {
                $data['mensagem'] = 'Sucesso ao gravar o veiculo.';
            } else {
                $data['mensagem'] = 'Erro ao gravar o veiculo. Opera&ccedil;&atilde;o cancelada.';
            }
            $data['servidor'] = new Servidor_model($servidor_id);
            $data['lista'] = $this->veiculo->listarVeiculoDoServidor($servidor_id);
//            $this->carregarView($data);
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url()."giah/veiculo/pesquisar/$servidor_id",$data);
        }

        function gravarestacionamento() {
          
            $servidor    = $_POST['txtServidorID'];
            
            $datas = $this->veiculo->listarEstacionamento();
            $t = 0;
                foreach ($datas as $value) {
                    $servidor_id = $value->servidor_id;

                if (($servidor_id== $servidor)) {
                    $data['mensagem'] = 'Servidor ja possui veiculo no estacionamento.';
                        $t = 1;
                }
                }
                if ($t == 0) {
                      if ($this->veiculo->gravarestacionamento()) {
                        $data['mensagem'] = 'Sucesso ao gravar o veiculo.';
                    } else {
                        $data['mensagem'] = 'Erro ao gravar o veiculo. Opera&ccedil;&atilde;o cancelada.';
                    }
                }
                
            $data['lista'] = $this->veiculo->listarEstacionamento();
//            $this->carregarView($data, 'giah/estacionamento-lista');
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url()."giah/veiculo/pesquisarestacionamento",$data);
           
        }

        function saidaestacionamento($veiculo_estacionamento_id) {

        if ($this->utilitario->autorizar(18, $this->session->userdata('modulo')) == true){

            if ($this->veiculo->saidaestacionamento($veiculo_estacionamento_id)) {
                $data['mensagem'] = 'Sucesso dar saida do veiculo.';
            } else {
                $data['mensagem'] = 'Erro ao dar saida do veiculo. Opera&ccedil;&atilde;o cancelada.';
            }
            $data['lista'] = $this->veiculo->listarEstacionamento();
//            $this->carregarView($data, 'giah/estacionamento-lista');
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url()."giah/veiculo/pesquisarestacionamento",$data);
        }
        }

        private function carregarView($data=null, $view=null) {
            if (!isset ($data)) { $data['mensagem'] = ''; }

                $this->load->view('header', $data);
                if (!isset ($view))
                { $this->load->view('giah/veiculo-lista', $data); }
                else
                { $this->load->view($view, $data); }

            $this->load->view('footer');
        }
       
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */