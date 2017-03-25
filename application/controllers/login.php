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

            if ($totalUtilizado < $totalPacote) {
                //calculando total disponivel
                $disponivel = $totalPacote - $totalUtilizado;
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

                $this->login->atualizandoregistro();
            } else {
                //Mandar email para o administrador alertando que o pacote foi excedido
//                $config['protocol'] = 'smtp';
//                $config['smtp_host'] = 'ssl://smtp.gmail.com';
//                $config['smtp_port'] = '465';
//                $config['smtp_user'] = 'stgsaude@gmail.com';
//                $config['smtp_pass'] = 'saude123';
//                $config['validate'] = TRUE;
//                $config['mailtype'] = 'html';
//                $config['charset'] = 'utf-8';
//                $config['newline'] = "\r\n";
//                $this->load->library('email');
//                
//                $this->email->initialize($config);
//                $this->email->from($email_empresa, $remetente);
//                $this->email->to($item->cns);
//                $this->email->subject($assunto);
//                $this->email->message($mensagem);
//                $this->email->send();
            }
            // Buscando mensagens  no banco que deverao ser mandadas para o webservice
            $dados = $this->login->listarsms();

            /* ENVIANDO PARA O WEBSERVICE */
            // Criando um Cliente 
            $cliente = new SoapClient(null, array(
                'location' => "http://192.168.25.26/weservice/webservice/servidor.php",
                'uri' => "http://192.168.25.26/weservice/webservice/",
                'trace' => 1
            ));

            try {
                $resultado = $cliente->__soapCall("recebemensagens", array(
                    "dados" => $dados
                ));
            } catch (SoapFault $fault) {
                die("SOAP Fault: fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
            }
            //Salvando o numero de controle recebido pelo WEBSERVICE no banco
            $this->login->atualizandonumerocontrole($resultado);
        }
    }

    function autenticar() {

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

//                $this->verificasms();

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
