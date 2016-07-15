<?php

class Login extends Controller {

	function Login() {
            parent::Controller();
            $this->load->model('login_model', 'login');
            $this->load->library('mensagem');
	}
	
	function index() {
            $this->carregarView();
	}

        function autenticar() {
            $usuario = $_POST['txtLogin'];
            $senha = $_POST['txtSenha'];
            $empresa = $_POST['txtempresa'];
            if (($this->login->autenticar($usuario, $senha, $empresa)) &&
                ($this->session->userdata('autenticado') == true)) {
                $valuecalculado = 0;
                setcookie("TestCookie", $valuecalculado);
                redirect(base_url()."home","refresh");

            } else {
                $data['mensagem'] = $this->mensagem->getMensagem('login002');
                $this->carregarView($data);
            }
        }

        function sair() {
            $this->session->sess_destroy();
            $data['mensagem'] = $this->mensagem->getMensagem('login003');
            $this->carregarView($data);
        }

        private function carregarView($data=null, $view=null) {
            if (!isset ($data)) { $data['mensagem'] = ''; }
            $data['empresa'] = $this->login->listar();
            $this->load->view('login', $data);
        }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */