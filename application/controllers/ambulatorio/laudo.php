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
class Laudo extends BaseController {

    function Laudo() {
        parent::Controller();
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/laudooit_model', 'laudooit');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {
        $this->loadView('ambulatorio/laudo-lista', $args);
    }

    function pesquisarconsulta($args = array()) {
        $this->loadView('ambulatorio/laudoconsulta-lista', $args);

//            $this->carregarView($data);
    }

    function pesquisardigitador($args = array()) {
        $this->loadView('ambulatorio/laudodigitador-lista', $args);
    }

    function pesquisarlaudoantigo($args = array()) {
        $this->loadView('ambulatorio/laudoantigo-lista', $args);

//            $this->carregarView($data);
    }

    function pesquisarrevisor($args = array()) {
        $this->loadView('ambulatorio/revisor-lista', $args);

//            $this->carregarView($data);
    }

    function calculadora($args = array()) {
        $data['valor1'] = '';
        $data['valor2'] = '';
        $data['valor3'] = '';
        $data['resultado'] = '';
        $this->load->View('ambulatorio/calculadora-form', $data);
    }

    function limparnomes($exame_id) {
        $data['exame_id'] = $exame_id;
        $this->load->View('ambulatorio/limparnomeimagem-form', $data);
    }

    function gravarlimparnomes($exame_id) {
        $this->laudo->deletarnomesimagens($exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function chamarpaciente($ambulatorio_laudo_id) {
        $this->laudo->chamada($ambulatorio_laudo_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function chamarpaciente2($ambulatorio_laudo_id) {
        $this->laudo->chamada($ambulatorio_laudo_id);
        redirect(base_url() . "ambulatorio/exame/listarexamerealizando");
    }

    function calcularvolume($args = array()) {
        (int)
                $valor1 = str_replace(",", ".", $_POST['valor1']);
        $valor2 = str_replace(",", ".", $_POST['valor2']);
        $valor3 = str_replace(",", ".", $_POST['valor3']);
        $resultado = 0.5233 * $valor1 * $valor2 * $valor3;
        $data['valor1'] = $valor1;
        $data['valor2'] = $valor2;
        $data['valor3'] = $valor3;
        $data['resultado'] = $resultado;
        $this->load->View('ambulatorio/calculadora-form', $data);
    }

    function email($texto, $email) {

//        $this->load->library('email');
//
//        //SMTP
////        stgsaude
////        teste123
//        $config['protocol'] = 'smtp';
//        $config['smtp_host'] = 'ssl://smtp.gmail.com';
//        $config['smtp_port'] = '465';
//        $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
//        $config['smtp_pass'] = 'DUCOCOFRUTOPCE';
//        $config['validate']  = TRUE;
//        $config['mailtype']  = 'text';
//        $config['charset'] = 'utf-8';
//        $config['newline'] = "\r\n";
//        $this->email->initialize($config);
//
//        $this->email->from('equipe2016gcjh@gmail.com', 'STG Saúde');
//        $this->email->to($email_paciente);
//        $this->email->subject('Laudo Médico');
//        $this->email->message($texto);
//        $this->email->send();
//        echo $this->email->print_debugger();     

        $this->load->library('My_phpmailer');

        $mail = new PHPMailer;

        $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
        $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
        //$mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
        $mail->isSMTP();                                      // Configura o disparo como SMTP
        $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
        $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
        $mail->Username = 'equipe2016gcjh@gmail.com';         // Usuário do SMTP
        $mail->Password = 'DUCOCOFRUTOPCE';                   // Senha do SMTP
        $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
        $mail->Port = 465;                                    // Porta TCP para a conexão
        $mail->From = 'equipe2016gcjh@gmail.com';             // Endereço previamente verificado no painel do SMTP
        $mail->FromName = 'STG Saúde';                        // Nome no remetente
        $mail->addAddress($email);                            // Acrescente um destinatário
        $mail->isHTML(true);                                  // Configura o formato do email como HTML
        $mail->Subject = 'Laudo Médico';
        $mail->Body = $texto;
        $mail->send();
    }

    function carregarlaudo($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
//        $arquivo_pasta = directory_map( base_url() . "dicom/");
        $this->load->helper('directory');
        $agenda_exames_id = $obj_laudo->_agenda_exames_id;
        $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/cr/$agenda_exames_id/");
        $origem = "/home/sisprod/projetos/clinica/cr/$agenda_exames_id";

//        if (count($arquivo_pasta) > 0) {
//
//            foreach ($arquivo_pasta as $nome1 => $item) {
//                foreach ($item as $nome2 => $valor) {
//
//                  
//                        $nova = $valor;
//                        if (!is_dir("/home/sisprod/projetos/clinica/upload/$exame_id")) {
//                            mkdir("/home/sisprod/projetos/clinica/upload/$exame_id");
//                            $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                            chmod($destino, 0777);
//                        }
//                        $destino = "/home/sisprod/projetos/clinica/upload/$exame_id/$nova";
//                        $local = "$origem/$nome1/$nova";
//                        $deletar = "$origem/$nome1/$nome2";
//                        copy($local, $destino);
//                }
//            }
//        }

        $data['integracao'] = $this->laudo->listarlaudosintegracao($ambulatorio_laudo_id);
        if (count($data['integracao']) > 0) {
            $this->laudo->atualizacaolaudosintegracao($agenda_exames_id);
        }
        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);

        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$exame_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['obj'] = $obj_laudo;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/laudo-form_1', $data);
//        $this->load->View('ambulatorio/laudo-form', $data);
    }

    function carregarlaudolaboratorial($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);

        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$exame_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['obj'] = $obj_laudo;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/laudolaboratorial-form', $data);
    }

    function carregarlaudoeco($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);

        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$exame_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['obj'] = $obj_laudo;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/laudoeco-form', $data);
    }

    function carregarlaudohistorico($paciente_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->load->View('ambulatorio/laudoconsultahistorico-form', $data);
    }

    function carregaranaminese($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $situacaolaudo = @$obj_laudo->_situacaolaudo;
        if ($situacaolaudo != 'FINALIZADO') {
            $this->exame->atenderpacienteconsulta($exame_id);
        }
        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
        $data['historico'] = $this->laudo->listarconsultahistorico($paciente_id);
        $data['historicoantigo'] = $this->laudo->listarconsultahistoricoantigo($paciente_id);
        $data['historicoexame'] = $this->laudo->listarexamehistorico($paciente_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $data['paciente_id'] = $paciente_id;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/laudoconsulta-form', $data);
    }

    function carregarreceituario($ambulatorio_laudo_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['lista'] = $this->exametemp->listarautocompletemodelosreceita();
//        $data['contador'] = $this->laudo->contadorlistarreceita($ambulatorio_laudo_id);
        $data['receita'] = $this->laudo->listarreceita($ambulatorio_laudo_id);
        $data['operadores'] = $this->operador_m->listarmedicos();

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/receituarioconsulta-form', $data);
    }

    function carregaratestado($ambulatorio_laudo_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['lista'] = $this->exametemp->listarautocompletemodelosatestado();
//        $data['contador'] = $this->laudo->contadorlistarreceita($ambulatorio_laudo_id);
        $data['receita'] = $this->laudo->listaratestado($ambulatorio_laudo_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/atestadoconsulta-form', $data);
    }

    function carregarexames($ambulatorio_laudo_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['lista'] = $this->exametemp->listarautocompletemodelossolicitarexames();
//        $data['contador'] = $this->laudo->contadorlistarreceita($ambulatorio_laudo_id);
        $data['receita'] = $this->laudo->listarexame($ambulatorio_laudo_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/solicitarexame-form', $data);
    }

    function imprimirmodeloaih($ambulatorio_laudo_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('internacao/impressaoaih', $data);
    }

    function impressaosolicitacaoexames($guia_id) {
        $data['exames'] = $this->guia->listarexamesguia($guia_id);

        $this->load->View('ambulatorio/impressaosolicitacaoexames', $data);
    }

    function alterarnomeimagem($exame_id, $imagem_id) {
        $data['listaendoscopia'] = $this->laudo->listarnomeendoscopia();
        $data['exame_id'] = $exame_id;
        $data['imagem_id'] = $imagem_id;
        $data['contador'] = $this->laudo->contadorimagem2($exame_id, $imagem_id);
        $this->load->View('ambulatorio/alterarnomeimagem-form', $data);
    }

    function renomearimagem($exame_id) {

        $imagem_id = trim($_POST['imagem_id']);
        $sequencia = $_POST['sequencia'];

//        if ($imagem_id == 7){
//            $this->laudo->deletarregistroimagem($exame_id, $imagem_id);
//        }
        $contador = $this->laudo->contadorimagem($exame_id, $sequencia);
//        var_dump($imagem_id);
//        echo '-------------';
//        var_dump($contador);
//        die;
//        $imagem_id = '111';
        $oldname = "./upload/$exame_id/$imagem_id";

        $nome = $_POST['nome'];
        $complemento = $_POST['complemento'];
        $novonome = 'Foto ' . $sequencia;
        if ($nome != '') {
            $novonome = 'Foto ' . $sequencia . " - " . $nome;
        } elseif ($complemento != '') {
            $novonome = 'Foto ' . $sequencia . " - " . $complemento;
        }
        if ($sequencia == 11) {
            $this->laudo->deletarregistroimagem($exame_id, $imagem_id);
        } else {

            if (count($contador) == 0) {
                $this->laudo->deletarregistroimagem($exame_id, $imagem_id);
                $this->laudo->gravarnome($exame_id, $sequencia, $novonome, $sequencia);
                $newname = "./upload/$exame_id/$sequencia";
                rename($oldname, $newname);
                redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
            } elseif ($sequencia == trim($_POST['imagem_id'])) {
                $this->laudo->alterarnome($exame_id, $imagem_id, $novonome, $sequencia);
                $newname = "./upload/$exame_id/$sequencia";
                rename($oldname, $newname);
                redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
            } else {
                $mensagem = "Imagem Foto " . $sequencia . " já existe";
                $this->session->set_flashdata('message', $mensagem);
                redirect(base_url() . "ambulatorio/laudo/alterarnomeimagem/$exame_id/$imagem_id");
            }
            redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
        }
    }

    function salvarnomeimagem($exame_id, $imagem_id) {
        $data['listaendoscopia'] = $this->laudo->listarnomeendoscopia();
        $data['exame_id'] = $exame_id;
        $data['imagem_id'] = $imagem_id;
        $this->load->View('ambulatorio/alterarnomeimagem-form', $data);
    }

    function faturamentolaudoxml($args = array()) {
        $this->loadView('ambulatorio/faturamentolaudoxml-form', $args);
    }

    function carregarreceituarioespecial($ambulatorio_laudo_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['lista'] = $this->exametemp->listarautocompletemodelosreceitaespecial();
        $data['receita'] = $this->laudo->listarreceitasespeciais($ambulatorio_laudo_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/receituarioespecialconsulta-form', $data);
    }

    function editarcarregarreceituarioespecial($ambulatorio_laudo_id, $ambulatorio_receituario_especial_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['receita'] = $this->laudo->listarreceitaespecial($ambulatorio_receituario_especial_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/editarreceituarioespecialconsulta-form', $data);
    }

    function editarcarregarreceituario($ambulatorio_laudo_id, $ambulatorio_receituario_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['receita'] = $this->laudo->listareditarreceita($ambulatorio_receituario_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
//        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/editarreceituarioconsulta-form', $data);
    }

    function editarcarregaratestado($ambulatorio_laudo_id, $ambulatorio_receituario_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['receita'] = $this->laudo->listareditaratestado($ambulatorio_receituario_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
//        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/editaratestado-form', $data);
    }

    function editarexame($ambulatorio_laudo_id, $ambulatorio_receituario_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['receita'] = $this->laudo->listareditarexame($ambulatorio_receituario_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
//        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/editarsolicitarexame-form', $data);
    }

    function carregarlaudodigitador($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
        $data['padrao'] = $this->laudo->listarlaudopadrao($procedimento_tuss_id);


        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$exame_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['obj'] = $obj_laudo;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;

        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        //$this->carregarView($data, 'giah/servidor-form');

        $this->load->View('ambulatorio/laudodigitador-form_1', $data);
    }

    function todoslaudo($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $guia_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $grupo = @$obj_laudo->_grupo;
        $procedimento = $this->laudo->listarprocedimentos($guia_id, $grupo);
        $data['grupo'] = $grupo;
        $data['mensagem'] = $messagem;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $uniaoprocedimento = "";
        foreach ($procedimento as $value) {
            $procedimentos = $value->procedimento_tuss_id;
            $contador = $this->laudo->contadorlistarlaudopadrao($procedimentos);
            $item = $this->laudo->listarlaudopadrao($procedimentos);
            if ($contador > 0) {
                $uniaoprocedimento = $uniaoprocedimento . '<br><u><b>' . $item['0']->procedimento . '</u></b>';
                $uniaoprocedimento = $uniaoprocedimento . '<br>' . $item['0']->texto;
            } else {
                $uniaoprocedimento = $uniaoprocedimento . '<br><u><b>' . $value->nome . '</u></b><br>';
            }
        }
        $data['padrao'] = $uniaoprocedimento;
        $this->load->View('ambulatorio/laudodigitadortotal-form_1', $data);
    }

    function carregarlaudoanterior($paciente_id, $ambulatorio_laudo_id) {
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
        $data['total'] = $this->laudo->listarlaudoscontador($paciente_id, $ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $ambulatorio_laudo_id;

        $this->loadView('ambulatorio/laudoanterior-lista', $data);
    }

    function listarxml($convenio, $paciente_id) {
        $data['convenio'] = $convenio;
        $data['paciente_id'] = $paciente_id;
        $this->loadView('ambulatorio/xml-lista', $data);
    }

    function carregarlaudoantigo($id) {
        $data['id'] = $id;
        $data['laudo'] = $this->laudo->listarlaudoantigoimpressao($id);
        $this->load->View('ambulatorio/laudoantigo-form', $data);
    }

    function impressaolaudo($ambulatorio_laudo_id, $exame_id) {


        $this->load->plugin('mpdf');

        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);

        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        $data['integracao'] = $this->laudo->listarlaudosintegracao($ambulatorio_laudo_id);
        if (count($data['integracao']) > 0) {
            $this->laudo->atualizacaolaudosintegracao($ambulatorio_laudo_id);
        }

        //GERAL
//        $filename = "laudo.pdf";
//        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/CABECALHO.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
//        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
//        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape);
//        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //HUMANA IMAGEM
//        $filename = "laudo.pdf";
//        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
//        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
//        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape);
//        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //CDC
//        $filename = "laudo.pdf";
//        $cabecalho = "<table><tr><td width='900px'><center><img align = 'center'  width='180px' height='80px' src='img/logo2.png'></center></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
//        $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
//        $html = $this->load->view('ambulatorio/impressaolaudo_7', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape);
//        $this->load->View('ambulatorio/impressaolaudo_7', $data);
//        
        //CLINICA MAIS
//        $filename = "laudo.pdf";
//        $cabecalho = "<table><tr><td><img align = 'left'  width='300px' height='90px' src='img/logomais.png'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr><tr><td>&nbsp;</td></tr></table>";
//        $rodape = "<table><tr><td>Rua Luis Carlos Lopes Ribeiro, 100-A - Messejana - Fortaleza/CE | Fone (85)3017-2566</td></tr></table>";
//        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape);
//        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //CLINICA DEZ
//        $filename = "laudo.pdf";
//        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='90px' src='img/clinicadez.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
//        $rodape = "<table><tr><td><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rua Dr. Batista de Oliveira, 302 - Papicu - Fortaleza - Ceará</center></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: (85) 3017-0010 - (85) 3265-7007</tr></table>";
//        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
//        $grupo = 'laboratorial';
//        pdf($html, $filename, $cabecalho, $rodape, $grupo);
//        $this->load->View('ambulatorio/impressaolaudo_1', $data);
//        
        //CLINICA PROIMAGEM
        $filename = "laudo.pdf";
        $cabecalho = "<table>
<tr>
  <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/clinicadez.jpg'></td>
</tr>
<td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
<tr>
<td width='30px'></td><td>" . substr($data['laudo']['0']->sala, 0, 10) . "</td>
</tr>
<tr>
<td width='30px'></td><td width='400px'>Reg.:" . $data['laudo']['0']->paciente_id . "</td><td>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
</tr>
<tr>
  <td width='30px'></td><td >Paciente:" . $data['laudo']['0']->paciente . "</td><td>Idade:" . $teste . "</td>
</tr>
<tr>
<td width='30px'></td><td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td>Sexo:" . $data['laudo']['0']->sexo . "</td>
</tr>
</tr>
</tr><tr><td>&nbsp;</td></tr>
<tr>
</table>";
        $rodape = "";
        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer2 == "") {
            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td width='400px'></td><td><img align = 'Right'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></tr><tr><td>&nbsp;</td></tr></table>";
        } elseif ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer2 != "") {
            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td width='30px'></td><td><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td><td width='30px'></td><td><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer2 . ".jpg'></td></tr></tr><tr><td>&nbsp;</td></tr></table>";
        }
        $grupo = 'laboratorial';
        $html = $this->load->view('ambulatorio/impressaolaudo_5', $data, true);
        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        $this->load->View('ambulatorio/impressaolaudo_5', $data);
//        
//        
//        
        //PRONTOMEDICA
//        $filename = "laudo.pdf";
//        $cabecalho = "<table>
//<tr>
//  <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/clinicadez.jpg'></td>
//</tr>
//<tr>
//<td width='30px'></td><td width='400px'>Numero do exame: " . $ambulatorio_laudo_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
//</tr>
//<tr>
//  <td width='30px'></td><td >Paciente: " . $data['laudo']['0']->paciente . "</td><td>Idade: " . $teste . "</td>
//</tr>
//<tr>
//<td width='30px'></td><td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td>Data de Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td>
//</tr>
//<tr>
//<td width='30px'></td><td>Covenio: " . $data['laudo']['0']->convenio . "</td>
//</tr>
//</tr>
//</tr><tr><td>&nbsp;</td></tr>
//<tr>
//</table>";
//        $rodape = "";
//        if ($data['laudo']['0']->situacao == "FINALIZADO") {
//            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></table>";
//        }else{
//            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
//            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
//        }
//        $grupo = 'laboratorial';
//        $html = $this->load->view('ambulatorio/impressaolaudo_5', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape, $grupo);
//        $this->load->View('ambulatorio/impressaolaudo_5', $data);
        //INSTITUTO VASCULAR
//        $filename = "laudo.pdf";
//        $cabecalho = "<table >
//<tr>
//  <td width='300px'></td><td width='180px'></td><td><img align = 'right'  width='180px' height='90px' src='img/clinicadez.jpg'></td>
//</tr>
//
//<tr>
//  <td >PACIENTE: " . $data['laudo']['0']->paciente . "</td><td>IDADE: " . $teste . "</td>
//</tr>
//<tr>
//<td>COVENIO: " . $data['laudo']['0']->convenio . "</td><td>NASCIMENTO: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td>
//</tr>
//<tr>
//<td>INDICA&Ccedil;&Atilde;O: " . $data['laudo']['0']->indicacao . "</td><td>DATA: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
//</tr>
//
//</tr>
//</tr><tr><td>&nbsp;</td></tr>
//<tr>
//</table>";
//        $rodape = "";
//        if ($data['laudo']['0']->situacao == "FINALIZADO") {
//            $rodape = "<table  width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr>"
//                    . "<tr><td><img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'></td></tr>"
//                    . "</table> ";
//        } else {
//            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
//            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr>"
//                    . "<tr><td><img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'></td></tr>"
//                    . "</table> ";
//        }
//        $grupo = 'laboratorial';
//
//        $html = $this->load->view('ambulatorio/impressaolaudo_5', $data, true);
//
//        pdf($html, $filename, $cabecalho, $rodape, $grupo);
//        $this->load->View('ambulatorio/impressaolaudo_5', $data);
//        CLINICA CAGE
//        if ($data['laudo']['0']->sexo == "F") {
//            $SEXO = 'FEMININO';
//        } else {
//            $SEXO = 'MASCULINO';
//        }
//
//        $filename = "laudo.pdf";
//        $cabecalho = "<table>
        //<tr>
        //  <td><img align = 'left'  width='330px' height='100px' src='img/cage.jpg'></td>
        //</tr>
        //<tr><td></td></tr>
        //<tr>
        //<td colspan='2'><b><center>" . $data['laudo']['0']->cabecalho . "</center></b></td>
        //</tr>
        //<tr><td>&nbsp;</td></tr>
        //<tr>
        //<td width='430px'>Nome.:" . $data['laudo']['0']->paciente . "</td><td>Idade:" . substr($teste, 0, 2) . "</td>
        //</tr>
        //<tr>
        //  <td >Sexo:" . $SEXO . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
        //</tr>
        //<tr>
        //<td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td></td>
        //</tr>
        //
    //<tr>
        //<td><b>VIDEOENDOSCOPIO:</b> Olympus Exera CV 145</td><td><b>MONITORIZA&Ccedil;&Atilde;O:</b> Oximetria de pulso</td>
        //</tr>
        //</table>";
//        $rodape = "";
//
//        $grupo = 'laboratorial';
//        $html = $this->load->view('ambulatorio/impressaolaudo_6', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape, $grupo);
//        $this->load->View('ambulatorio/impressaolaudo_6', $data);
//        
//        
//RONALDO BARREIRA
//        $medicoparecer = $data['laudo']['0']->medico_parecer1;
//        $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
        //            <tr><td ><center><img align = 'left'  width='140px' height='40px' src='img/cabecalho.jpg'><center></td></tr>
        //            <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
        //            <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
        //            <tr><td></td><td></td></tr>
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
        //            </table>";
        //        if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
        //            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
        //            <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
        //            <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
        //            </table>";
        //        }
        //        if ($data['laudo']['0']->medico_parecer1 != 929) {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        if ($data['laudo']['0']->medico_parecer1 == 929 && $data['laudo']['0']->situacao != "FINALIZADO") {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 929) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width='200px' height='130px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 930) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 2483) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        $grupo = $data['laudo']['0']->grupo;
        //        $filename = "laudo.pdf";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        //        $this->load->View('ambulatorio/impressaolaudo_2', $data);
    }

    function impressaolaudolaboratorial($ambulatorio_laudo_id, $exame_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        //GERAL
        $filename = "laudo.pdf";
        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/CABECALHO.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //HUMANA IMAGEM
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //CDC
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //        
        //CLINICA MAIS
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='110px' src='img/logomais.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='900px' height='100px' src='img/rodapemais.png'>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //CLINICA DEZ
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='90px' src='img/clinicadez.jpg'></td><td><center>CLÍNICA DEZ <br> LABORATÓRIO DE ANÁLISES CLÍNICAS</center></td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "  </td><td> Data da Coleta: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . " </td></tr><tr><td> Medico:" . $data['laudo']['0']->medicosolicitante . "   </td><td>  RG: " . $data['laudo']['0']->rg . "</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table>";
        //        $rodape = "<table><tr><td><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rua Dr. Batista de Oliveira, 302 - Papicu - Fortaleza - Ceará</center></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: (85) 3017-0010 - (85) 3265-7007</tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        $grupo = 'laboratorial';
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //RONALDO BARREIRA
        //        $medicoparecer = $data['laudo']['0']->medico_parecer1;
        //        $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
        //            <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
        //            <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
        //            <tr><td></td><td></td></tr>
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
        //            </table>";
        //        if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
        //            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
        //            <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
        //            <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
        //            </table>";
        //        }
        //        if ($data['laudo']['0']->medico_parecer1 != 929) {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        if ($data['laudo']['0']->medico_parecer1 == 929 && $data['laudo']['0']->situacao != "FINALIZADO") {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 929) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width='200px' height='130px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 930) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 2483) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        $grupo = $data['laudo']['0']->grupo;
        //        $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        //        $this->load->View('ambulatorio/impressaolaudo_2', $data);
    }

    function impressaolaudoeco($ambulatorio_laudo_id, $exame_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        //GERAL
        $filename = "laudo.pdf";
        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/CABECALHO.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //HUMANA IMAGEM
//        $filename = "laudo.pdf";
//        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
//        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
//        $html = $this->load->view('ambulatorio/impressaolaudo_3', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape);
//        $this->load->View('ambulatorio/impressaolaudo_3', $data);
        //CAGE
        //                if ($data['laudo']['0']->sexo == "F"){
        //            $SEXO= 'FEMININO';
        //        }else{
        //            $SEXO= 'MASCULINO';
        //        }
        //        
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table>
        //<tr>
        //  <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/cage.jpg'></td>
        //</tr>
        //<tr><td>&nbsp;</td></tr>
        //<tr>
        //<td width='30px'></td><td colspan='2'><b><center>" . $data['laudo']['0']->cabecalho . "</center></b></td>
        //</tr>
        //<tr><td>&nbsp;</td></tr>
        //<tr>
        //<td width='30px'></td><td width='350px'>Reg.:" . $data['laudo']['0']->paciente . "</td><td>Idade:" . $teste . "</td>
        //</tr>
        //<tr>
        //  <td width='30px'></td><td >Sexo:" . $SEXO . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
        //</tr>
        //<tr>
        //<td width='30px'></td><td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td></td>
        //</tr>
        //
                                                                                                                                                                    //<tr>
        //<td width='30px'></td><td><b>VIDEOENDOSCOPIO:</b> Olympus Exera CV 145</td><td><b>MONITORIZA&Ccedil;&Atilde;O:</b> Oximetria de pulso</td>
        //</tr>
        //</table>";
        //        $rodape = "<table><tr>
        //  <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/rodapecage.jpg'></td>
        //</tr></table>";
        //
                                                                                                                                                                //        $grupo = 'laboratorial';
        //        $html = $this->load->view('ambulatorio/impressaolaudo_6', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        //        $this->load->View('ambulatorio/impressaolaudo_6', $data);
        //CDC
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_3', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo32', $data);
        //CLINICA MAIS
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='110px' src='img/logomais.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='900px' height='100px' src='img/rodapemais.png'>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //CLINICA DEZ
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='90px' src='img/clinicadez.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rua Dr. Batista de Oliveira, 302 - Papicu - Fortaleza - Ceará</center></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: (85) 3017-0010 - (85) 3265-7007</tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //RONALDO BARREIRA
        //        $medicoparecer = $data['laudo']['0']->medico_parecer1;
        //        $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
        //            <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
        //            <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
        //            <tr><td></td><td></td></tr>
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
        //            </table>";
        //        if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
        //            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
        //            <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
        //            <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
        //            </table>";
        //        }
        //        if ($data['laudo']['0']->medico_parecer1 != 929) {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        if ($data['laudo']['0']->medico_parecer1 == 929 && $data['laudo']['0']->situacao != "FINALIZADO") {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 929) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width='200px' height='130px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 930) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        $grupo = $data['laudo']['0']->grupo;
        //        $html = $this->load->view('ambulatorio/impressaolaudo_3', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        //        $this->load->View('ambulatorio/impressaolaudo_3', $data);
    }

    function impressaolaudo2via($ambulatorio_laudo_id, $exame_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        //GERAL
//                $filename = "laudo.pdf";
//                $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/CABECALHO.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
//                $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
//                $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
//                pdf($html, $filename, $cabecalho, $rodape);
//                $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //HUMANA IMAGEM
//        $filename = "laudo.pdf";
//        $cabecalho = "<table><tr><td></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
//        $rodape = "";
//        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape);
//        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //PROIMAGEM
        $filename = "laudo.pdf";
        $cabecalho = "<table>
        <tr>
          <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/clinicadez.jpg'></td>
        </tr>
        <td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
        <tr>
        <td width='30px'></td><td>" . substr($data['laudo']['0']->sala, 0, 10) . "</td>
        </tr>
        <tr>
        <td width='30px'></td><td width='400px'>Reg.:" . $data['laudo']['0']->paciente_id . "</td><td>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
        </tr>
        <tr>
          <td width='30px'></td><td >Paciente:" . $data['laudo']['0']->paciente . "</td><td>Idade:" . $teste . "</td>
        </tr>
        <tr>
        <td width='30px'></td><td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td>Sexo:" . $data['laudo']['0']->sexo . "</td>
        </tr>
        </tr>
        </tr><tr><td>&nbsp;</td></tr>
        <tr>
        </table>";
        $rodape = "";
        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer2 == "") {
            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td width='400px'></td><td><img align = 'Right'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></tr><tr><td>&nbsp;</td></tr></table>";
        } elseif ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer2 != "") {
            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td width='30px'></td><td><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td><td width='30px'></td><td><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer2 . ".jpg'></td></tr></tr><tr><td>&nbsp;</td></tr></table>";
        }
        $grupo = 'laboratorial';
        $html = $this->load->view('ambulatorio/impressaolaudo_5', $data, true);
        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        $this->load->View('ambulatorio/impressaolaudo_5', $data);
        //CAGE
        //                if ($data['laudo']['0']->sexo == "F"){
        //            $SEXO= 'FEMININO';
        //        }else{
        //            $SEXO= 'MASCULINO';
        //        }
        //        
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table>
        //<tr>
        //  <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/cage.jpg'></td>
        //</tr>
        //<tr><td>&nbsp;</td></tr>
        //<tr>
        //<td width='30px'></td><td colspan='2'><b><center>" . $data['laudo']['0']->cabecalho . "</center></b></td>
        //</tr>
        //<tr><td>&nbsp;</td></tr>
        //<tr>
        //<td width='30px'></td><td width='350px'>Reg.:" . $data['laudo']['0']->paciente . "</td><td>Idade:" . $teste . "</td>
        //</tr>
        //<tr>
        //  <td width='30px'></td><td >Sexo:" . $SEXO . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
        //</tr>
        //<tr>
        //<td width='30px'></td><td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td></td>
        //</tr>
        //
                                                                                                                                                                                                        //<tr>
        //<td width='30px'></td><td><b>VIDEOENDOSCOPIO:</b> Olympus Exera CV 145</td><td><b>MONITORIZA&Ccedil;&Atilde;O:</b> Oximetria de pulso</td>
        //</tr>
        //</table>";
        //        $rodape = "";
        //
                                                                                                                                                                                                        //        $grupo = 'laboratorial';
        //        $html = $this->load->view('ambulatorio/impressaolaudo_6', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        //        $this->load->View('ambulatorio/impressaolaudo_6', $data);
        //CDC
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //CLINICA MAIS
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='110px' src='img/logomais.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='900px' height='100px' src='img/rodapemais.png'>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //        
        //CLINICA DEZ
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='90px' src='img/clinicadez.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rua Dr. Batista de Oliveira, 302 - Papicu - Fortaleza - Ceará</center></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: (85) 3017-0010 - (85) 3265-7007</tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //RONALDO BARREIRA
        //        $medicoparecer = $data['laudo']['0']->medico_parecer1;
        //        $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
        //            <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
        //            <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
        //            <tr><td></td><td></td></tr>
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
        //            </table>";
        //        if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
        //            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
        //            <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
        //            <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
        //            </table>";
        //        }
        //        if ($data['laudo']['0']->medico_parecer1 != 929) {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        if ($data['laudo']['0']->medico_parecer1 == 929 && $data['laudo']['0']->situacao != "FINALIZADO") {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 929) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width='200px' height='130px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 930) {
        //            $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //                <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
        //        }
        //        $grupo = $data['laudo']['0']->grupo;
        //        $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        //        $this->load->View('ambulatorio/impressaolaudo_2', $data);
    }

    function impressaoreceita($ambulatorio_laudo_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarreceitaimpressao($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        //GERAL        
        $filename = "laudo.pdf";
        $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        $rodape = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //HUMANA        
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CAGE        
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/cage.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapecage.jpg'>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CDC
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CLINICA DEZ     
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  src='img/cabecalho.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td><center><img align = 'left'  src='img/rodape.jpg'></center></td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //RONALDO BARREIRA
        //        $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
        //            <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
        //            <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
        //            <tr><td></td><td></td></tr>
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
        //            </table>";
        //        if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
        //            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
        //            <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
        //            <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
        //            </table>";
        //        }
        //        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        if ($data['laudo']['0']->medico_parecer1 == 929) {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        $grupo = $data['laudo']['0']->grupo;
        //        $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
    }

    function impressaosolicitarexame($ambulatorio_laudo_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarsolicitarexameimpressao($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        //GERAL        
        $filename = "laudo.pdf";
        $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        $rodape = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //HUMANA        
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CAGE        
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/cage.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapecage.jpg'>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CDC
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CLINICA DEZ     
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  src='img/cabecalho.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td><center><img align = 'left'  src='img/rodape.jpg'></center></td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //RONALDO BARREIRA
        //        $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
        //            <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
        //            <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
        //            <tr><td></td><td></td></tr>
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
        //            </table>";
        //        if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
        //            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
        //            <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
        //            <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
        //            </table>";
        //        }
        //        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        if ($data['laudo']['0']->medico_parecer1 == 929) {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        $grupo = $data['laudo']['0']->grupo;
        //        $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
    }

    function impressaoatestado($ambulatorio_laudo_id) {

        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listaratestadoimpressao($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        //GERAL        
        $filename = "laudo.pdf";
        $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        $rodape = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('ambulatorio/impressaoreceituario', $data);

        //HUMANA        
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CAGE        
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/cage.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapecage.jpg'>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CDC
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //CLINICA DEZ     
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td><img align = 'left'  src='img/cabecalho.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        //        $rodape = "<table><tr><td><center><img align = 'left' src='img/rodape.jpg'></center></td></tr></table>";
        //        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituario', $data);
        //RONALDO BARREIRA
        //        $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
        //            <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
        //            <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
        //            <tr><td></td><td></td></tr>
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
        //            </table>";
        //        if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
        //            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
        //            <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
        //            <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
        //            </table>";
        //        }
        //        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        if ($data['laudo']['0']->medico_parecer1 == 929) {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        $grupo = $data['laudo']['0']->grupo;
        //        $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
    }

    function impressaoreceitaespecial($ambulatorio_laudo_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarreceitaespecialimpressao($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo'][0]->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');
        $this->load->View('ambulatorio/impressaoreceituarioespecial', $data);
        //        $filename = "laudo.pdf";
        //        $cabecalho = "";
        //        $rodape = "";
        //        $html = $this->load->view('ambulatorio/impressaoreceituarioespecial', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape);
        //        $this->load->View('ambulatorio/impressaoreceituarioespecial', $data);
        //        $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
        //            <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
        //            <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
        //            <tr><td></td><td></td></tr>
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
        //            </table>";
        //        if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
        //            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
        //            <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
        //            <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
        //            <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
        //            <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
        //            <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
        //            <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
        //            </table>";
        //        }
        //        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        if ($data['laudo']['0']->medico_parecer1 == 929) {
        //            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
        //            <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
        //            <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
        //        }
        //        $grupo = $data['laudo']['0']->grupo;
        //        $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
        //        pdf($html, $filename, $cabecalho, $rodape, $grupo);
    }

    function impressaolaudoantigo($id) {
        $data['laudo'] = $this->laudo->listarlaudoantigoimpressao($id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->load->View('ambulatorio/impressaolaudoantigo', $data);
    }

    function impressaoimagem($ambulatorio_laudo_id, $exame_id) {
        $this->load->plugin('mpdf');
        $data['nomeimagem'] = $this->laudo->listarnomeimagem($exame_id);

        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $verificador = $data['laudo']['0']->imagens;
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$exame_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');



        //GERAL
        $filename = "laudo.pdf";
        $cabecalho = "<table><tr><td></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame:" . $data['laudo']['0']->procedimento . "</td></tr></table>";
        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
        //humana
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame:" . $data['laudo']['0']->procedimento . "</td></tr></table>";
        //        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
        //CAGE
        //
                                                                                                                                                                                                        //        $filename = "laudo.pdf";
        //        if ($data['laudo']['0']->sexo == "F") {
        //            $SEXO = 'FEMININO';
        //        } else {
        //            $SEXO = 'MASCULINO';
        //        }
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table>
        //
                                                                                                                                                                                                        //<tr>
        //</td><td width='430px'>Nome.:" . $data['laudo']['0']->paciente . "</td><td></td>
        //</tr>
        //<tr>
        //  </td><td >Sexo:" . $SEXO . " Idade:" . substr($teste, 0, 2) . "</td><td></td>
        //</tr>
        //
                                                                                                                                                                                                        //</table>";
        //        $rodape = "";
        //        $html = $this->load->view('ambulatorio/impressaoimagem6cage', $data, true);
        //GASTROSUL
        //
                                                                                                                                                                                                        //        $filename = "laudo.pdf";
        //        if ($data['laudo']['0']->sexo == "F") {
        //            $SEXO = 'FEMININO';
        //        } else {
        //            $SEXO = 'MASCULINO';
        //        }
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table>
        //
                                                                                                                                                                                                        //<tr>
        //</td><td width='100px'></td><td width='430px'>Nome.:" . $data['laudo']['0']->paciente . "</td><td></td>
        //</tr>
        //<tr>
        //  </td><td width='100px'></td><td >Sexo:" . $SEXO . " Idade:" . substr($teste, 0, 2) . "</td><td></td>
        //</tr>
        //
                                                                                                                                                                                                        //</table>";
        //        $rodape = "";
        //        $html = $this->load->view('ambulatorio/impressaoimagem6gastrosul', $data, true);
        //CDC      
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame:" . $data['laudo']['0']->procedimento . "</td></tr></table>";
        //        $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
        //clinica MAIS      
        //        $filename = "laudo.pdf";
        //        $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame: Dr(a). " . $data['laudo']['0']->procedimento . "</td></tr></table>";
        //        $rodape = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table>";
        //        
        if ($verificador == 1) {
            $html = $this->load->view('ambulatorio/impressaoimagem1', $data, true);
        }
        if ($verificador == 2) {
            $html = $this->load->view('ambulatorio/impressaoimagem2', $data, true);
        }
        if ($verificador == 3) {
            $html = $this->load->view('ambulatorio/impressaoimagem3', $data, true);
        }
        if ($verificador == 4) {
            $html = $this->load->view('ambulatorio/impressaoimagem4', $data, true);
        }
        if ($verificador == 5) {
            $html = $this->load->view('ambulatorio/impressaoimagem5', $data, true);
        }
        if ($verificador == 6 || $verificador == "") {

            $html = $this->load->view('ambulatorio/impressaoimagem6', $data, true);
        }
        $grupo = $data['laudo']['0']->grupo;

        pdf($html, $filename, $cabecalho, $rodape, $grupo);
        //        pdf($html, $filename, $cabecalho, $rodape);
    }

    function gerarxml() {

        $this->load->plugin('mpdf');

//        $listarexame = $this->laudo->listarxmllaudo();
//        echo '<pre>';
//        var_dump($listarexame);
//        die;
        //        if ($_POST['convenio'] !== "") {
        $listarexame = $this->laudo->listarxmllaudo();
        $empresa = $this->exame->listarcnpj();
//        $cnpjxml = $listarexame[0]->codigoidentificador;
//        $razao_socialxml = $empresa[0]->razao_socialxml;
//        $registroans = $listarexame[0]->registroans;
//        $cpfxml = $empresa[0]->cpfxml;
//        $cnpj = $empresa[0]->cnpj;

        $convenio = $listarexame[0]->convenio;
//        $datainicio = str_replace("/", "", $_POST['datainicio']);
//        $datafim = str_replace("/", "", $_POST['datafim']);
//        $paciente = $listarexame[0]->paciente;
//        $nomearquivo = $convenio . "-" . $paciente . "-" . $datainicio . "-" . $datafim;
        $origem = "/home/sisprod/projetos/clinica/upload/laudo";

        if (!is_dir($origem)) {
            mkdir($origem);
            chmod($origem, 0777);
        }
        if (!is_dir($origem . '/' . $convenio)) {
            mkdir($origem . '/' . $convenio);
            chmod($origem . '/' . $convenio, 0777);
        }

        $tipo_xml = $this->laudo->listarempresatipoxml(); //verifica qual tipo de xml que a empresa usa.
        if ($tipo_xml[0]->nome == 'TIPO 1') { // se o tipo xml for SLINE (início).
            $corpo = "";
            $paciente_dif = "";
            foreach ($listarexame as $item) {

                if ($_POST['apagar'] == 1) {
                    delete_files($origem . '/' . $convenio . '/' . $item->paciente_id);
                }

                if ($item->paciente_id !== $paciente_dif) {
                    $sl_cod_doc = $item->ambulatorio_laudo_id;
                    $texto = "";
                    if (!is_dir($origem . '/' . $convenio . '/' . $item->paciente_id)) {
                        mkdir($origem . '/' . $convenio . '/' . $item->paciente_id);
                        chmod($origem . '/' . $convenio . '/' . $item->paciente_id, 0777);
                    }
                    //cria código para TAG <SL_COD_DOC>
//                $dataatual = date("Y-m-d");
//                $horarioatual = date("H-i");
//                $data_cod = str_replace("-", "", $dataatual);
//                $horario_cod = str_replace("-", "", $horarioatual);
//                $num_aleatorio = mt_rand(1000, 100000000);
//                $sl_cod_doc = $num_aleatorio . $data_cod . $horario_cod;
                    //NUMERO DA CARTEIRA
                    if ($item->convenionumero == '') {
                        $numerodacarteira = '0000000';
                    } else {
                        $numerodacarteira = $item->convenionumero;
                    }

                    //NUMERO GUIA CONVENIO  
                    if ($item->guiaconvenio == '') {
                        $numeroguia = '0000000';
                    } else {
                        $numeroguia = $item->guiaconvenio;
                    }

                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
                      <S_LINE>
                      <SL_TIPO>RP</SL_TIPO>
                      <SL_TITULO>" . $item->paciente . "-" . $item->nascimento . "</SL_TITULO>
                      <SL_SN>O</SL_SN>
                      <SL_CHAVE></SL_CHAVE>
                      <SL_SENHA></SL_SENHA>                      
                      <SL_COD_DOC>" . $sl_cod_doc . "</SL_COD_DOC>                      
                      <SL_FORMATO>PDF</SL_FORMATO>
                      <SL_DATA_REALIZACAO>" . substr($item->data_realizacao, 0, 10) . "T" . substr($item->data_realizacao, 10, 18) . " </SL_DATA_REALIZACAO>
                        <SL_OPER>
                           <OPER_REGANS>384577</OPER_REGANS>
                           <OPER_NUMCARTEIRA>" . $numerodacarteira . "</OPER_NUMCARTEIRA>
                           <OPER_NUMGUIA>" . $numeroguia . "
                                ";
                    //este foreach irá inserir todos os códigos dos exames relacionados ao numeroguia 
                    foreach ($listarexame as $value) {
                        $corpo = $corpo . "<OPER_EXAME>" . $value->codigo . "</OPER_EXAME>";
                        $texto = $texto . $value->texto_laudo;
                    }


                    $fim_numguia = "</OPER_NUMGUIA>";

                    $rodape = "</SL_OPER>
                       <SL_TEXTO></SL_TEXTO>
                    </S_LINE>";

                    $nome = "/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $item->paciente_id . "/" . $sl_cod_doc . ".xml";
                    $xml = $cabecalho . $corpo . $fim_numguia . $rodape;
                    $fp = fopen($nome, "w+");
                    fwrite($fp, $xml . "\n");
                    fclose($fp);

                    $nomepdf = "/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $item->paciente_id . "/" . $sl_cod_doc . ".pdf";
                    $cabecalhopdf = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $item->paciente . " <br>Emiss&atilde;o: </td></tr></table>";
                    $rodapepdf = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
                    salvapdf($texto, $nomepdf, $cabecalhopdf, $rodapepdf);


                    $zip = new ZipArchive;
                    $this->load->helper('directory');
                    $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$item->paciente_id/");
                    $pasta = $item->paciente_id;
                    if ($arquivo_pasta != false) {
                        foreach ($arquivo_pasta as $value) {
                            $zip->open("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$sl_cod_doc.zip", ZipArchive::CREATE);
                            $zip->addFile("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$value", "$sl_cod_doc.xml");
                            $zip->addFile("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$value", "$sl_cod_doc.pdf");
                            $zip->close();
                        }
                        $arquivoxml = "/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$sl_cod_doc.xml";
                        $arquivopdf = "/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$sl_cod_doc.pdf";
                        unlink($arquivoxml);
                        unlink($arquivopdf);
                    }

                    $paciente_dif = $item->paciente_id;
                }
            }
        } // se o tipo xml for SLINE (fim).
        else { // se o tipo xml for NAJA (início).
            $texto = "";
            $corpo = "";
            foreach ($listarexame as $item) {

                if (!is_dir($origem . '/' . $convenio . '/' . $item->paciente_id)) {
                    mkdir($origem . '/' . $convenio . '/' . $item->paciente_id);
                    chmod($origem . '/' . $convenio . '/' . $item->paciente_id, 0777);
                }

                $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
                            <NAJA>
                                <NJ_CodPaciente>" . $item->paciente_id . "</NJ_CodPaciente>
                                <NJ_NomePaciente>" . $item->paciente . "</NJ_NomePaciente>
                                <NJ_Laudo>" . $item->ambulatorio_laudo_id . "</NJ_Laudo>
                                <NJ_LocalLaudo>/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $item->paciente_id . "</NJ_LocalLaudo>
                                <NJ_FormatoLaudo>RTF</NJ_FormatoLaudo>
                                <NJ_NomeMedicoLaudante>" . $item->medicosolicitante . "</NJ_NomeMedicoLaudante>
                                <NJ_Detalhes>";

                $corpo = $corpo . "<NJ_Exame>
                                            <NJ_Accessionnumber>" . $item->wkl_accnumber . "</NJ_Accessionnumber>                            
                                            <NJ_NomeExame>" . $item->wkl_procstep_descr . "</NJ_NomeExame>
                                        </NJ_Exame>";
                $texto = $texto . $value->texto_laudo;

                $rodape = "</NJ_Detalhes>
                       </NAJA>";

                $nome = "/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $item->paciente_id . "/" . $item->paciente_id . ".xml";
                $xml = $cabecalho . $corpo . $rodape;
                $fp = fopen($nome, "w+");
                fwrite($fp, $xml . "\n");
                fclose($fp);

                $nome = "/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $item->paciente_id . "/" . $item->paciente_id . ".rtf";
                $rtf = $texto;
                $fp = fopen($nome, "w+");
                fwrite($fp, $rtf . "\n");
                fclose($fp);
            }
        }// se o tipo xml for NAJA (fim).



        $data['mensagem'] = 'Sucesso ao gerar arquivo.';

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/faturamentolaudoxml", $data);
    }

    function gerarxmlsalvar($ambulatorio_laudo_id, $exame_id, $sala_id) {
        $this->load->plugin('mpdf');

        $listarexame = $this->laudo->listarxmlsalvar($ambulatorio_laudo_id, $exame_id, $sala_id);
        $empresa = $this->exame->listarcnpj();

        $convenio = $listarexame[0]->convenio;

        $origem = "/home/sisprod/projetos/clinica/upload/laudo";

        if (!is_dir($origem)) {
            mkdir($origem);
            chmod($origem, 0777);
        }
        if (!is_dir($origem . '/' . $convenio)) {
            mkdir($origem . '/' . $convenio);
            chmod($origem . '/' . $convenio, 0777);
        }


        $tipo_xml = $this->laudo->listarempresatipoxml(); //verifica qual tipo de xml que a empresa usa.
        if ($tipo_xml[0]->nome == 'TIPO 1') {

            $corpo = "";
            $paciente_dif = "";
            foreach ($listarexame as $item) {

                if ($_POST['apagar'] == 1) {
                    delete_files($origem . '/' . $convenio . '/' . $item->paciente_id);
                }

                if ($item->paciente_id !== $paciente_dif) {
                    $sl_cod_doc = $item->ambulatorio_laudo_id;
                    $texto = "";
                    if (!is_dir($origem . '/' . $convenio . '/' . $item->paciente_id)) {
                        mkdir($origem . '/' . $convenio . '/' . $item->paciente_id);
                        chmod($origem . '/' . $convenio . '/' . $item->paciente_id, 0777);
                    }

                    //NUMERO DA CARTEIRA
                    if ($item->convenionumero == '') {
                        $numerodacarteira = '0000000';
                    } else {
                        $numerodacarteira = $item->convenionumero;
                    }

                    //NUMERO GUIA CONVENIO  
                    if ($item->guiaconvenio == '') {
                        $numeroguia = '0000000';
                    } else {
                        $numeroguia = $item->guiaconvenio;
                    }

                    $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
                      <S_LINE>
                      <SL_TIPO>RP</SL_TIPO>
                      <SL_TITULO>" . $item->paciente . "-" . $item->nascimento . "</SL_TITULO>
                      <SL_SN>O</SL_SN>
                      <SL_CHAVE></SL_CHAVE>
                      <SL_SENHA></SL_SENHA>                      
                      <SL_COD_DOC>" . $sl_cod_doc . "</SL_COD_DOC>                      
                      <SL_FORMATO>PDF</SL_FORMATO>
                      <SL_DATA_REALIZACAO>" . substr($item->data_realizacao, 0, 10) . "T" . substr($item->data_realizacao, 10, 18) . " </SL_DATA_REALIZACAO>
                        <SL_OPER>
                           <OPER_REGANS>384577</OPER_REGANS>
                           <OPER_NUMCARTEIRA>" . $numerodacarteira . "</OPER_NUMCARTEIRA>
                           <OPER_NUMGUIA>" . $numeroguia . "
                                ";
                    //este foreach irá inserir todos os códigos dos exames relacionados ao numeroguia 
                    foreach ($listarexame as $value) {
                        $corpo = $corpo . "<OPER_EXAME>" . $value->codigo . "</OPER_EXAME>";
                        $texto = $texto . $value->texto_laudo;
                    }


                    $fim_numguia = "</OPER_NUMGUIA>";

                    $rodape = "</SL_OPER>
                       <SL_TEXTO></SL_TEXTO>
                    </S_LINE>";

                    $nome = "/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $item->paciente_id . "/" . $sl_cod_doc . ".xml";
                    $xml = $cabecalho . $corpo . $fim_numguia . $rodape;
                    $fp = fopen($nome, "w+");
                    fwrite($fp, $xml . "\n");
                    fclose($fp);

                    $nomepdf = "/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $item->paciente_id . "/" . $sl_cod_doc . ".pdf";
                    $cabecalhopdf = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $item->paciente . " <br>Emiss&atilde;o: </td></tr></table>";
                    $rodapepdf = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
                    salvapdf($texto, $nomepdf, $cabecalhopdf, $rodapepdf);


                    $zip = new ZipArchive;
                    $this->load->helper('directory');
                    $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$item->paciente_id/");
                    $pasta = $item->paciente_id;
                    if ($arquivo_pasta != false) {
                        foreach ($arquivo_pasta as $value) {
                            $zip->open("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$sl_cod_doc.zip", ZipArchive::CREATE);
                            $zip->addFile("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$value", "$sl_cod_doc.xml");
                            $zip->addFile("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$value", "$sl_cod_doc.pdf");
                            $zip->close();
                        }
                        $arquivoxml = "/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$sl_cod_doc.xml";
                        $arquivopdf = "/home/sisprod/projetos/clinica/upload/laudo/$convenio/$pasta/$sl_cod_doc.pdf";
                        unlink($arquivoxml);
                        unlink($arquivopdf);
                    }

                    $paciente_dif = $item->paciente_id;
                }
            }
        } else {

            if (!is_dir($origem . '/' . $convenio . '/' . $listarexame[0]->paciente_id)) {
                mkdir($origem . '/' . $convenio . '/' . $listarexame[0]->paciente_id);
                chmod($origem . '/' . $convenio . '/' . $listarexame[0]->paciente_id, 0777);
            }

            $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
                            <NAJA>
                                <NJ_CodPaciente>" . $listarexame[0]->paciente_id . "</NJ_CodPaciente>
                                <NJ_NomePaciente>" . $listarexame[0]->paciente . "</NJ_NomePaciente>
                                <NJ_Laudo>" . $listarexame[0]->ambulatorio_laudo_id . "</NJ_Laudo>
                                <NJ_LocalLaudo>/home/sisprod/projetos/clinica/upload/laudo" . $convenio . "/" . $listarexame[0]->paciente_id . "</NJ_LocalLaudo>
                                <NJ_FormatoLaudo>RTF</NJ_FormatoLaudo>
                                <NJ_NomeMedicoLaudante>" . $listarexame[0]->medicosolicitante . "</NJ_NomeMedicoLaudante>
                               <NJ_Detalhes>";

            $corpo = "<NJ_Exame>
                            <NJ_Accessionnumber>" . $listarexame[0]->wkl_accnumber . "</NJ_Accessionnumber>                            
                            <NJ_NomeExame>" . $listarexame[0]->wkl_procstep_descr . "</NJ_NomeExame>
                       </NJ_Exame>";

            $texto = $listarexame[0]->texto_laudo;

            $rodape = "</NJ_Detalhes>
                       </NAJA>";

            $nome = "/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $listarexame[0]->paciente_id . "/" . $listarexame[0]->paciente_id . ".xml";
            $xml = $cabecalho . $corpo . $rodape;
            $fp = fopen($nome, "w+");
            fwrite($fp, $xml . "\n");
            fclose($fp);

            $nome = "/home/sisprod/projetos/clinica/upload/laudo/" . $convenio . "/" . $listarexame[0]->paciente_id . "/" . $listarexame[0]->paciente_id . ".rtf";
            $rtf = $texto;
            $fp = fopen($nome, "w+");
            fwrite($fp, $rtf . "\n");
            fclose($fp);
        }
//        $data['mensagem'] = 'Sucesso ao gerar arquivo.';
//
//        $this->session->set_flashdata('message', $data['mensagem']);
//        redirect(base_url() . "ambulatorio/laudo", $data);
    }

    function carregarrevisao($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['lista'] = $this->exametemp->listarautocompletemodelos();
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $this->load->helper('directory');
        $data['mensagem'] = $messagem;
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$exame_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['obj'] = $obj_laudo;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->load->View('ambulatorio/laudorevisao-form', $data);
    }

    function oit($ambulatorio_laudo_id) {
        $verifica = $this->laudooit->contadorlaudo($ambulatorio_laudo_id);
        if ($verifica == 0) {
            $ambulatorio_laudooit_id = $this->laudooit->inserirlaudo($ambulatorio_laudo_id);
            $obj_laudo = new laudooit_model($ambulatorio_laudooit_id);
        } else {
            $resultado = $this->laudooit->consultalaudo($ambulatorio_laudo_id);
            $ambulatorio_laudooit_id = $resultado[0]->ambulatorio_laudooit_id;
            $obj_laudo = new laudooit_model($ambulatorio_laudooit_id);
            $data['operadores'] = $this->operador_m->listarmedicos();
            //        $obj_laudo = new laudooit_model($ambulatorio_laudooit_id);
            //        $data['lista'] = $this->exametemp->listarautocompletemodelos();
            //        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
            //        $data['operadores'] = $this->operador_m->listarmedicos();
        }
        $data['obj'] = $obj_laudo;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/laudooit-form', $data);
    }

    function impressaooit($ambulatorio_laudo_id) {
        $verifica = $this->laudooit->contadorlaudo($ambulatorio_laudo_id);
        if ($verifica == 0) {
            $ambulatorio_laudooit_id = $this->laudooit->inserirlaudo($ambulatorio_laudo_id);
            $obj_laudo = new laudooit_model($ambulatorio_laudooit_id);
        } else {
            $resultado = $this->laudooit->consultalaudo($ambulatorio_laudo_id);
            $ambulatorio_laudooit_id = $resultado[0]->ambulatorio_laudooit_id;
            $obj_laudo = new laudooit_model($ambulatorio_laudooit_id);
            $data['operadores'] = $this->operador_m->listarmedicos();
        }
        $data['obj'] = $obj_laudo;
        //        $this->loadView('ambulatorio/laudooit-form', $data);
        $this->load->View('ambulatorio/impressaooit', $data);
    }

    function gravaroit() {

        $this->laudo->gravaroit();
        $mensagem = 'Sucesso ao gravar OIT';
        $data['exame_id'] = $exame_id;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/oit/$ambulatorio_laudo_id");
    }

    function gravarhistorico($paciente_id) {

        $this->laudo->gravarhistorico($paciente_id);
        $mensagem = 'Sucesso ao gravar historico';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
    }

    function excluir($exame_sala_id) {
        if ($this->procedimento->excluir($exame_sala_id)) {
            $mensagem = 'Sucesso ao excluir a Sala';
        } else {
            $mensagem = 'Erro ao excluir a sala. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/sala");
    }

    function gravar($paciente_id) {
        $ambulatorio_laudo_id = $this->laudo->gravar($paciente_id);
        //        if ($ambulatorio_laudo_id == "-1") {
        //            $data['mensagem'] = 'Erro ao gravar a Sala. Opera&ccedil;&atilde;o cancelada.';
        //        } else {
        //            $data['mensagem'] = 'Sucesso ao gravar a Sala.';
        //        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $this->novo($data);
    }

    function gravarlaudo($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $sala_id) {

        if ($_POST['situacao'] == 'FINALIZADO') {
            $validar = $this->laudo->validar();
            //$validar = $this->laudo->validar();

            if ($validar == '1') {
                $gravar = $this->laudo->gravarlaudo($ambulatorio_laudo_id, $exame_id, $sala_id);
                if ($gravar == 0) {
                    $this->gerarxmlsalvar($ambulatorio_laudo_id, $exame_id, $sala_id);
                }
                $messagem = 2;

                $email_paciente = $this->laudo->email($paciente_id);
                if ((isset($email_paciente)) && $email_paciente !== "") {
                    $this->email($_POST['laudo'], $email_paciente);
                }
            } else {
                $this->laudo->gravarlaudodigitando($ambulatorio_laudo_id, $exame_id);
                $messagem = 1;
            }
        } else {
            $this->laudo->gravarlaudodigitando($ambulatorio_laudo_id, $exame_id);
        }
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;


        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregarlaudo/$ambulatorio_laudo_id/$exame_id/$paciente_id/$procedimento_tuss_id/$messagem");
    }

    function gravarlaudolaboratorial($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id) {

        if ($_POST['situacao'] == 'FINALIZADO') {
            $validar = $this->laudo->validar();
            if ($validar == '1') {
                $this->laudo->gravarlaudolaboratorial($ambulatorio_laudo_id, $exame_id);
                $messagem = 2;
            } else {
                $this->laudo->gravarlaudodigitandolaboratorial($ambulatorio_laudo_id, $exame_id);
                $messagem = 1;
            }
        } else {
            $this->laudo->gravarlaudodigitandolaboratorial($ambulatorio_laudo_id, $exame_id);
        }
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;


        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregarlaudolaboratorial/$ambulatorio_laudo_id/$exame_id/$paciente_id/$procedimento_tuss_id/$messagem");
    }

    function gravarlaudoeco($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id) {

        if ($_POST['situacao'] == 'FINALIZADO') {
            $validar = $this->laudo->validar();
            if ($validar == '1') {
                $this->laudo->gravarlaudoeco($ambulatorio_laudo_id);
                $messagem = 2;
            } else {
                $this->laudo->gravarlaudodigitandoeco($ambulatorio_laudo_id);
                $messagem = 1;
            }
        } else {
            $this->laudo->gravarlaudodigitandoeco($ambulatorio_laudo_id);
        }
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregarlaudoeco/$ambulatorio_laudo_id/$exame_id/$paciente_id/$procedimento_tuss_id/$messagem");
    }

    function gravaranaminese($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id) {

        $this->laudo->gravaranaminese($ambulatorio_laudo_id, $exame_id);
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function anexarimagem($ambulatorio_laudo_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/consulta/$ambulatorio_laudo_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->loadView('ambulatorio/importacao-imagemconsulta', $data);
    }

    function importarimagem() {
        $ambulatorio_laudo_id = $_POST['paciente_id'];
        //        $data = $_FILES['userfile'];
        //        var_dump($data);
        //        die;
        if (!is_dir("./upload/consulta/$ambulatorio_laudo_id")) {
            mkdir("./upload/consulta/$ambulatorio_laudo_id");
            $destino = "./upload/consulta/$ambulatorio_laudo_id";
            chmod($destino, 0777);
        }

        //        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/consulta/" . $ambulatorio_laudo_id . "/";
        $config['allowed_types'] = 'gif|jpg|BMP|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $data = array('upload_data' => $this->upload->data());
        }
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->anexarimagem($ambulatorio_laudo_id);
    }

    function excluirimagem($ambulatorio_laudo_id, $nome) {

        if (!is_dir("./uploadopm/consulta/$ambulatorio_laudo_id")) {
            if (!is_dir("./uploadopm/consulta")) {
                mkdir("./uploadopm/consulta");
            }
            mkdir("./uploadopm/consulta/$ambulatorio_laudo_id");
            $destino = "./uploadopm/consulta/$ambulatorio_laudo_id";
            chmod($destino, 0777);
        }

        $origem = "./upload/consulta/$ambulatorio_laudo_id/$nome";
        $destino = "./uploadopm/consulta/$ambulatorio_laudo_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        $this->anexarimagem($ambulatorio_laudo_id);
    }

    function gravarreceituario($ambulatorio_laudo_id) {

        $this->laudo->gravarreceituario($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        //        $data['paciente_id'] = $paciente_id;
        //        $data['procedimento_tuss_id'] = $procedimento_tuss_id;

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregarreceituario/$ambulatorio_laudo_id");
    }

    function gravaratestado($ambulatorio_laudo_id) {

        $this->laudo->gravaratestado($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;


        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregaratestado/$ambulatorio_laudo_id");
    }

    function gravarexame($ambulatorio_laudo_id) {

        $this->laudo->gravarexame($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;


        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregarexames/$ambulatorio_laudo_id");
    }

    function gravarreceituarioespecial($ambulatorio_laudo_id) {

        $this->laudo->gravarreceituarioespecial($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregarreceituarioespecial/$ambulatorio_laudo_id");
    }

    function editarreceituarioespecial($ambulatorio_laudo_id) {

        $this->laudo->editarreceituarioespecial($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function editarreceituario($ambulatorio_laudo_id) {

        $this->laudo->editarreceituario($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function editaratestado($ambulatorio_laudo_id) {

        $this->laudo->editaratestado($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function editarexame2($ambulatorio_laudo_id) {

        $this->laudo->editarsolicitarexame($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarlaudodigitador($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id) {

        if ($_POST['situacao'] == 'FINALIZADO') {
            $validar = $this->laudo->validar();
            if ($validar == '1') {
                $this->laudo->gravarlaudo($ambulatorio_laudo_id);
                $messagem = 2;
            } else {
                $this->laudo->gravarlaudodigitando($ambulatorio_laudo_id);
                $messagem = 1;
            }
        } else {
            $this->laudo->gravarlaudodigitando($ambulatorio_laudo_id);
        }
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;


        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregarlaudodigitador/$ambulatorio_laudo_id/$exame_id/$paciente_id/$procedimento_tuss_id/$messagem");
    }

    function gravarlaudodigitadortotal($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id) {

        if ($_POST['situacao'] == 'FINALIZADO') {
            $validar = $this->laudo->validar();
            if ($validar == '1') {
                $this->laudo->gravarlaudotodos($ambulatorio_laudo_id);
                $messagem = 2;
            } else {
                $this->laudo->gravarlaudodigitandotodos($ambulatorio_laudo_id);
                $messagem = 1;
            }
        } else {
            $this->laudo->gravarlaudodigitandotodos($ambulatorio_laudo_id);
        }
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;


        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/carregarlaudodigitador/$ambulatorio_laudo_id/$exame_id/$paciente_id/$procedimento_tuss_id/$messagem");
    }

    function gravarrevisao($ambulatorio_laudo_id) {

        if ($_POST['situacao'] == 'FINALIZADO') {
            $validar = $this->laudo->validarrevisor();
            if ($validar == '1') {
                $this->laudo->gravarrevisao($ambulatorio_laudo_id);
                $messagem = 2;
            } else {
                $this->laudo->gravarrevisaodigitando($ambulatorio_laudo_id);
                $messagem = 1;
            }
        } else {
            $this->laudo->gravarrevisaodigitando($ambulatorio_laudo_id);
        }
        if ($ambulatorio_laudo_id == "1") {
            $data['mensagem'] = 'Sucesso ao gravar a Laudo.';
        } else {
            $data['mensagem'] = 'Erro ao gravar a Laudo. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/laudo/pesquisarrevisor", $data);
    }

    function gravarprocedimentos() {
        $agenda_exames_id = $this->laudo->gravarexames();
        if ($agenda_exames_id == "-1") {
            $data['mensagem'] = 'Erro ao agendar Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao agendar Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes", $data);
    }

    function novo($data) {
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['convenio'] = $this->convenio->listardados();
        $this->loadView('ambulatorio/laudo-form', $data);
    }

    private function carregarView($data = null, $view = null) {
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
