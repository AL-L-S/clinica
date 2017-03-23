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

    function verificasms() {
        //verifica se ja foi feita uma verificaçao hoje.
        $smsVerificacao = $this->login->verificasms();
        if (count($smsVerificacao) == 0) {
            //atualizando a data da ultima verificacao
            $this->login->atualizaultimaverificacao();

            //verificando o total de mensagens utilizadas do pacote
            $totalUtilizado = (int) $this->login->totalutilizado();
            $totalPacote = (int) $this->login->listarempresapacote();

            if ($totalPacote < $totalPacote) {
                //calculando total disponivel
                $disponivel = $totalPacote - $totalPacote;

                //INSERINDO EXAMES AGENDADOS PARA O DIA SEGUINTE NA TABELA DE CONTROLE
                $examesAgendados = $this->login->examesagendados();
                $totalInserido = $this->login->atualizandoagendadostabelasms($examesAgendados, $disponivel);

                //calculando novo total disponivel
                $disponivel = $disponivel - $totalInserido;

                if ($disponivel > 0) {
                    //INSERINDO ANIVERSARIANTES NA TABELA DE CONTROLE
                    $aniversariantes = $this->login->aniversariantes();
                    $totalInserido = $this->login->atualizandoaniversariantestabelasms($aniversariantes, $disponivel);

                    //calculando novo total disponivel
                    $disponivel = $disponivel - $totalInserido;
                }

                if ($disponivel > 0) {
                    //INSERINDO PACIENTES ATENDIDOS NO DECORRER DO DIA
                }
            } else {
                //Mandar email para o administrador alertando que o pacote foi excedido
            }

            //ENVIANDO PARA O WEBSERVICE
        }
    }

    function autenticar() {
//        $this->verificasms();

        $usuario = $_POST['txtLogin'];
        $senha = $_POST['txtSenha'];
        $empresa = $_POST['txtempresa'];

        //Pegando o nome e versao do navegador
        preg_match('/Firefox.+/', $_SERVER['HTTP_USER_AGENT'], $browserPC);
        preg_match('/FxiOS.+/', $_SERVER['HTTP_USER_AGENT'], $browserIOS);
        $teste1 = count($browserPC);
        $teste2 = count($browserIOS);

        if ($teste1 > 0 || $teste2 > 0) {
            //Pegando somente o numero da versao.
            preg_match('/[0-9].+/', $browserPC[0], $verificanavegador['versao']);

            if (($this->login->autenticar($usuario, $senha, $empresa)) &&
                    ($this->session->userdata('autenticado') == true)) {
                $valuecalculado = 0;
                setcookie("TestCookie", $valuecalculado);
                redirect(base_url() . "home", "refresh");
            } else {
                $data['mensagem'] = $this->mensagem->getMensagem('login002');
                $this->carregarView($data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('Navegador n&atilde;o suportado. Utilize o Firefox.');
            $this->carregarView($data);
        }
    }

    function sair() {
        $this->login->sair();

        $this->session->sess_destroy();

        $data['mensagem'] = $this->mensagem->getMensagem('login003');
        $this->carregarView($data);
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }
        $data['empresa'] = $this->login->listar();
        $this->load->view('login', $data);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
