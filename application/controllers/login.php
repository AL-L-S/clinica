<?php

class Login extends Controller {

    function Login() {
        parent::Controller();
        $this->load->model('login_model', 'login');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    function index() {
        $this->carregarView();
    }

    function verificasms() {
        ini_set('display_errors', 1);
        ini_set('display_startup_erros', 1);
        error_reporting(E_ALL);

        set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão

        $servicoemail = $this->session->userdata('servicoemail');

        if ($servicoemail == 't') {
            $emailVerificacao = $this->login->verificaemail();
            if (count($emailVerificacao) == 0) {
                $this->login->emailautomatico();
            }
        }

        $servicosms = $this->session->userdata('servicosms');
//        var_dump($servicosms);
        if ($servicosms == 't') {
//            $verificacoes = $this->login->verificacaosmsdia();
//            if ($verificacoes[0]->total < 3 && ( date("H") == "08" ) ) {

            $registro_sms_id = $this->login->criandoregistrosms();

            $dadosEmpresaSms = $this->login->listarempresasmsdados();
//                var_dump($dadosEmpresaSms);die;
            // verificando o total de mensagens utilizadas do pacote
            $totalUtilizado = (int) $this->login->totalutilizado();
            $totalPacote = (int) $this->login->listarempresapacote();

            if ($totalUtilizado < $totalPacote || $dadosEmpresaSms[0]->enviar_excedentes == "t") {

                //calculando total disponivel
                $disponivel = $totalPacote - $totalUtilizado;

                //INSERINDO EXAMES AGENDADOS PARA O DIA SEGUINTE NA TABELA DE CONTROLE (CONFIRMACAO)
                $examesAgendados = $this->login->examesagendados();
                $totalInserido = $this->login->atualizandoagendadostabelasms($examesAgendados, $disponivel);

                //calculando novo total disponivel
                $disponivel = $disponivel - $totalInserido;

                if ($disponivel > 0) {
                    //INSERINDO PACIENTES ATENDIDOS NO DECORRER DO DIA (AGRADECIMENTO)
                    $pacientesDia = $this->login->atendimentos();
                    $totalInserido = $this->login->atualizandoatendidostabelasms($pacientesDia, $disponivel);
                    $disponivel = $disponivel - $totalInserido;
                }

                /* So deve executar esse bloco uma vez ao dia */

                $smsVerificacao = $this->login->verificasms();
                if (count($smsVerificacao) == 0) {
                    if ($disponivel > 0) {
                        //INSERINDO ANIVERSARIANTES NA TABELA DE CONTROLE (ANIVERSARIANTE)
                        $aniversariantes = $this->login->aniversariantes();
                        $totalInserido = $this->login->atualizandoaniversariantestabelasms($aniversariantes, $disponivel);

                        //calculando novo total disponivel
                        $disponivel = $disponivel - $totalInserido;
                    }

                    if ($disponivel > 0) {
                        //INSERINDO REVISÕES NA TABELA DE CONTROLE (REVISAO)
                        $revisoes = $this->login->revisoes();
                        $totalInserido = $this->login->atualizandorevisoestabelasms($revisoes, $disponivel);
                        $disponivel = $disponivel - $totalInserido;
                    }
                }
                /* Fim do Bloco */

                $this->login->atualizandoregistro($registro_sms_id);
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
            
            // Buscando mensagens  no banco que deverao ser mandadas
//            $dados = $this->login->listarsms();
            
            if (count($dados) > 0) {
                
//                require_once ('./application/libraries/Googl.class.php');
//                $Googl = new Googl('AIzaSyAXqZLY8c_aC-G2VD7ppuCBF-lWEhWmEvY ');
                
                /* INTEGRAÇÃO ZENVIA API */
                require_once ('./application/libraries/php-rest-api/autoload.php');
                $smsFacade = new SmsFacade("stgs.api", "ydaLex6jin");
                $smsLote = array();

                foreach ($dados as $value) {
                    $numero = $this->utilitario->validaTelefone($value['numero']);
                    if($numero["valido"]){
                        $sms = new Sms();
                        $sms->setTo($numero["numFor"]);
                        
                        if($value['tipo'] == 'CONFIRMACAO') {
                            // Encurta a URL de confirmação
                            $url = $this->utilitario->validaExternoEndereco($value['endereco_externo']) . "login/confirmarAtendimentoSMS/" . $value['agenda_exames_id'];
                            $msg = $value['mensagem'] . " Para confirmar, acesse: " . $url;
                            $sms->setMsg($msg);
                        }
                        else {
                            $sms->setMsg($value['mensagem']);
                        }
                        
                        $sms->setId($value['numero_indentificacao'] . "-" . $value['sms_id']);
    //                    $sms->setFrom($from);
    //                    $sms->setSchedule("2014-07-13T16:00:00");
                        $smsLote[] = $sms;
                    }
                }
                
//                echo "<pre>";
//                var_dump($smsLote); die;
                
                try {
                    $responses = $smsFacade->sendMultiple($smsLote);
                    foreach ($responses as $response) {
                        echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
                        echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription() . "\n";
                    }
                } catch( Exception $ex ){
                    echo "<pre>";
                    var_dump($ex->message);
                }
            }          
//                die('morreu');
            
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
            $data['mensagem'] = $this->mensagem->getMensagem('Navegador n&atilde;o suportado. Utilize o Firefox (Em caso de IOS. Atualize sua vers&atilde;o).');
            $this->carregarView($data);
        }
    }

    function confirmarAtendimentoSMS($agenda_exames_id) {
        $this->login->confirmarAtendimentoSMS($agenda_exames_id);
        echo '
            <html>
                <head>
                    <meta charset="utf-8"/>
                </head>
                <body>
                    <h3 style="text-align: center">Consulta/Exame Confirmado com sucesso!</h3>
                </body>
            </html>
        ';
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
