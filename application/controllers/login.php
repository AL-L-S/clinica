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
            $dados = $this->login->listarsms();
//                var_dump($dados); die;
//            if (count($dados) > 0) {
//                
//                
//                /* INTEGRAÇÃO ZENVIA API */
//                require_once ('./application/libraries/php-rest-api/autoload.php');
//                $smsFacade = new SmsFacade("stgs.api", "ydaLex6jin");
//                $smsLote = array();
//
////                foreach ($dados as $value) {
////                    $sms = new Sms();
////                    $sms->setTo($value['numero']);
////                    $sms->setMsg('+55' . $value['mensagem']);
////                    $sms->setId($value['numero_indentificacao'] . "-" . $value['sms_id']);
//////                    $sms->setFrom($from);
//////                    $sms->setSchedule("2014-07-13T16:00:00");
////                    $smsLote[] = $sms;
////                }
//                
//                $sms = new Sms();
//                $sms->setTo('+5585996150680');
//                $sms->setMsg("
//Quem
//Somos
//
//A necessidade de suprir a falta de softwares profissionais na área da saúde foi o fator preponderante para se dar os primeiros passos no intuito da melhores soluções Tecnológica, Com um plantel de profissionais conhecedores na área da tecnologia e da saúde. A STGSaúde busca permanentemente: Capacitar seus colaboradores nas mais diversas áreas, visando sempre o crescimento pessoal, para a certeza de produção de softwares seguros e inovadores. Proporcionar também aos hospitais e clínicas de pequeno e médio porte um sistema altamente confiável e que se adapte facilmente às suas rotinas diárias e às suas condições financeiras.
//Missão
//
//Desenvolver aplicações de qualidade elevada e com custo acessível para a área da saúde, facilitando a rotina diária dos usuários, auxiliando no gerenciamento das instituições de saúde, visando o armazenamento e recuperação de dados de forma íntegra e segura e focando a garantia da privacidade e confidencialidade dos dados dos pacientes.
//Visão
//
//Desenvolver eficientemente aplicações que satisfaçam às necessidades dos clientes e à legislação da área da saúde, com colaboradores capacitados e métodos inovadores.
//
//
//Metas
//
//Nossa meta é sempre acompanhar a evolução das tecnologias, a informática tem essa característica de sempre surgirem novidades, e temos que ter sempre essa sintônia, e junto com nossos parceiros sempre achar a melhor solução.
//
//Valores
//
//Ética; Profissionalismo; Excelência nos serviços; Segurança das Informações; Lucratividade; Inovação.
//
//Locação de Impressora
//
//Projetos personalizados para redução e otimização de custos na área de impressões e cópias. Nosso grande diferencial são nossos equipamentos de longa durabilidade e confiabilidade. Nossos preços são compatíveis com o mercado, mesmo oferecendo uma qualidade superior de impressão. Abastecimento de suprimentos e suporte técnico.
//
//Gestão de Hardware
//
//Manutenção Preventiva e Corretiva em equipamento de Informática. Inúmeras vezes nos deparamos com problemas em computadores, tanto nas empresas quanto nas máquinas pessoais, que acarretam em perda parcial e na maioria das vezes total de arquivos, sistemas etc, o que nos causa um transtorno terrível e irreparável. E é aí que entra a Gestão de Hardware. Compõem a Gestão de Hardware: Manutenção Preventiva e Corretiva; Administração de Redes Gerenciamento de Backups; Entre outros.
//");
//                $sms->setId("0-2");
//                $smsLote[] = $sms;
////                
////                $sms = new Sms();
////                $sms->setTo('+5585996954467');
////                $sms->setMsg("Teste de Mensagem");
////                $sms->setId("0-1");
////                $smsLote[] = $sms;
////                
//                try {
//                    $responses = $smsFacade->sendMultiple($smsLote);
//                    foreach ($responses as $response) {
//                        echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
//                        echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription() . "\n";
//                    }
//                } catch( Exception $ex ){
////                    echo "<pre>";
////                    var_dump($ex->message);
//                }
//            }          
            
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
