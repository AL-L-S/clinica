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
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('ambulatorio/odontograma_model', 'odontograma');
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

    function pesquisarconsultaantigo($args = array()) {
        $this->loadView('ambulatorio/laudoconsultaantigo-lista', $args);

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

    function encaminharatendimento($ambulatorio_laudo_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->load->View('ambulatorio/encaminharatendimento-form', $data);
    }

    function gravarencaminhamentoatendimento() {
        $empresapermissao = $this->guia->listarempresapermissoes();
        $laudo_id = $_POST["ambulatorio_laudo_id"];
        $medico_id = $_POST["medico_id"];
        $email_ativado = $empresapermissao[0]->encaminhamento_email;
//        var_dump($_POST);
//        die;
//        $this->laudo->gravarencaminhamentoatendimento();
        if ($email_ativado == 't') {
            $this->enviaremailencaminhamento($medico_id, $laudo_id);
        }
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function enviaremailencaminhamento($medico_id, $laudo_id) {
        $empresa = $this->guia->listarempresa();

        $resposta = $this->laudo->listarlaudoemailencaminhamento($laudo_id);
        $resposta2 = $this->laudo->listarmedicoenviarencaminhamento($medico_id);

        $medico1 = $resposta[0]->medico;
        $medico_encaminhar = $resposta2[0]->medico;
        $medico_email = $resposta2[0]->email;
//            $senha = $resposta[0]->agenda_exames_id;
        $mensagem = "Dr(a). $medico1 indicou você para um paciente. Continue a corrente e sempre que possível, indique outro procedimento da " . $empresa[0]->nome . " para fazer a clinica ainda mais forte <br><br><br><br> <span>Obs: Não responda esse email. Email automático</span>";
//            echo '<pre>';
//            var_dump($empresa); die;           
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
        $config['smtp_pass'] = 'DUCOCOFRUTOPCE';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $this->email->initialize($config);
        if (@$empresa[0]->email != '') {
            $this->email->from($empresa[0]->email, $empresa[0]->nome);
        } else {
            $this->email->from('equipe2016gcjh@gmail.com', $empresa[0]->nome);
        }

        $this->email->to($medico_email);
        $this->email->subject("Encaminhamento de Paciente");
        $this->email->message($mensagem);
        if ($this->email->send()) {
            $data['mensagem'] = "Email enviado com sucesso.";
        } else {
            $data['mensagem'] = "Envio de Email malsucedido.";
        }
    }

    function limparnomes($exame_id) {
        $data['exame_id'] = $exame_id;
        $this->load->View('ambulatorio/limparnomeimagem-form', $data);
    }

    function gravarlimparnomes($exame_id) {
        $this->laudo->deletarnomesimagens($exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function chamarpacientesalaespera($ambulatorio_laudo_id) {
        $this->laudo->chamarpacientesalaespera($ambulatorio_laudo_id);
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

    function alterardata($ambulatorio_laudo_id) {
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/alterardatalaudo-form', $data);
    }

    function gravaralterardata($ambulatorio_laudo_id) {
        $this->laudo->gravaralterardata($ambulatorio_laudo_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
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
        $arquivo_pasta = directory_map("./cr/$agenda_exames_id/");
        $origem = "./cr/$agenda_exames_id";

//        if (count($arquivo_pasta) > 0) {
//
//            foreach ($arquivo_pasta as $nome1 => $item) {
//                foreach ($item as $nome2 => $valor) {
//
//                  
//                        $nova = $valor;
//                        if (!is_dir("./upload/$exame_id")) {
//                            mkdir("./upload/$exame_id");
//                            $destino = "./upload/$exame_id/$nova";
//                            chmod($destino, 0777);
//                        }
//                        $destino = "./upload/$exame_id/$nova";
//                        $local = "$origem/$nome1/$nova";
//                        $deletar = "$origem/$nome1/$nome2";
//                        copy($local, $destino);
//                }
//            }
//        }        

        $data['integracao'] = $this->laudo->listarlaudosintegracao($agenda_exames_id);
        if (count($data['integracao']) > 0) {
            $this->laudo->atualizacaolaudosintegracao($agenda_exames_id);
        }
        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
        $data['historico'] = $this->laudo->listarconsultahistorico($paciente_id);
        $data['historicoantigo'] = $this->laudo->listarconsultahistoricoantigo($paciente_id);
        $data['historicoexame'] = $this->laudo->listarexamehistorico($paciente_id);
//        var_dump($data['historicoexame']); die;
        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $this->load->helper('directory');
        $data['arquivos_anexados'] = directory_map("./upload/consulta/$ambulatorio_laudo_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivos_anexados'] != false) {
            sort($data['arquivos_anexados']);
        }
        $data['arquivos_paciente'] = directory_map("./upload/paciente/$paciente_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivos_paciente'] != false) {
            sort($data['arquivos_paciente']);
        }
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            natcasesort($data['arquivo_pasta']);
        }
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresapermissao'] = $this->guia->listarempresasaladepermissao($empresa_id);
        $data['obj'] = $obj_laudo;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/laudo-form_1', $data);
//        $this->load->View('ambulatorio/laudo-form', $data);
    }

    function carregaruploadcliente() {
        $this->load->View('ambulatorio/uploadimagens');
    }

    function redirecionauploadcliente() {
        $caminho = $_POST['caminho'];
        $arquivo = (isset($_POST['arquivo'])) ? $_POST['arquivo'] : '';
        $todos = (isset($_POST['todos'])) ? 'true' : 'false';
        header("Location: http://localhost/conexao.php?caminho={$caminho}&arquivo={$arquivo}&todos={$todos}");
    }

    function carregarlaudolaboratorial($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);

        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
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
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
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

    function vozemtexto($ambulatorio_laudo_id, $operador_id) {
        $data['laudo_id'] = $ambulatorio_laudo_id;
        $data['operador_id'] = $operador_id;
        $this->load->View('ambulatorio/voz', $data);
    }

    function gravartextoconvertido() {
        $this->exametemp->gravartextoconvertido();

        //O google Chrome não permite fechar a janela pelo javascript a menos que ela tenha sido aberta com javascript
        echo "<script>window.location.href = 'https://www.google.com';</script>";
    }

    function caregarodontograma($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;

        $data['primeiroQuadrante'] = $this->odontograma->instanciarprimeiroquadrantepacienteodontograma($ambulatorio_laudo_id);
        $data['segundoQuadrante'] = $this->odontograma->instanciarsegundoquadrantepacienteodontograma($ambulatorio_laudo_id);
        $data['terceiroQuadrante'] = $this->odontograma->instanciarterceiroquadrantepacienteodontograma($ambulatorio_laudo_id);
        $data['quartoQuadrante'] = $this->odontograma->instanciarquartoquadrantepacienteodontograma($ambulatorio_laudo_id);

        $data['procedimentos'] = $this->convenio->listarprocedimentoconvenioodontograma(@$data['obj']->_convenio_id);

        $this->load->View('ambulatorio/odontograma-form', $data);
    }

    function carregaranamineseodontologia($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $situacaolaudo = @$obj_laudo->_situacaolaudo;
        $agenda_exames_id = @$obj_laudo->_agenda_exames_id;
        $atendimento = @$obj_laudo->_atendimento;
        if ($atendimento != 't') {
            $this->exame->atendimentohora($agenda_exames_id);
        }
        if ($situacaolaudo != 'FINALIZADO') {
            $this->exame->atenderpacienteconsulta($exame_id);
        }
        $this->load->helper('directory');
        $data['arquivos_anexados'] = directory_map("./upload/consulta/$ambulatorio_laudo_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivos_anexados'] != false) {
            sort($data['arquivos_anexados']);
        }
        $data['arquivos_paciente'] = directory_map("./upload/paciente/$paciente_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivos_paciente'] != false) {
            sort($data['arquivos_paciente']);
        }
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresapermissao'] = $this->guia->listarempresasaladepermissao($empresa_id);
        $data['listarades'] = $this->laudo->listarades();
        $data['listaradcl'] = $this->laudo->listaradcl();
        $data['listarodes'] = $this->laudo->listarodes();
        $data['listarodcl'] = $this->laudo->listarodcl();
        $data['listarodeixo'] = $this->laudo->listarodeixo();
        $data['listarodav'] = $this->laudo->listarodav();
        $data['listaroees'] = $this->laudo->listaroees();
        $data['listaroecl'] = $this->laudo->listaroecl();
        $data['listaroeeixo'] = $this->laudo->listaroeeixo();
//        var_dump($data['listaroeeixo']); die;
        $data['listaroeav'] = $this->laudo->listaroeav();
        $data['listaracuidadeod'] = $this->laudo->listaracuidadeod();
        $data['listaracuidadeoe'] = $this->laudo->listaracuidadeoe();

        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
        $data['laudo_peso'] = $this->laudo->listarlaudospesoaltura($paciente_id, $ambulatorio_laudo_id);
//        echo '<pre>';
//        var_dump($data['laudo_peso']); die;
        $data['historico'] = $this->laudo->listarconsultahistorico($paciente_id);
        $data['historicoantigo'] = $this->laudo->listarconsultahistoricoantigo($paciente_id);
        $data['historicoexame'] = $this->laudo->listarexamehistorico($paciente_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $data['paciente_id'] = $paciente_id;
        $data['exame_id'] = $exame_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/laudoodontologia-form', $data);
    }

    function carregaranaminese($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $situacaolaudo = @$obj_laudo->_situacaolaudo;
        $agenda_exames_id = @$obj_laudo->_agenda_exames_id;
        $atendimento = @$obj_laudo->_atendimento;
        if ($atendimento != 't') {
            $this->exame->atendimentohora($agenda_exames_id);
        }
        if ($situacaolaudo != 'FINALIZADO') {
            $this->exame->atenderpacienteconsulta($exame_id);
        }
        $this->load->helper('directory');
        $data['arquivos_anexados'] = directory_map("./upload/consulta/$ambulatorio_laudo_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivos_anexados'] != false) {
            sort($data['arquivos_anexados']);
        }
        $data['arquivos_paciente'] = directory_map("./upload/paciente/$paciente_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivos_paciente'] != false) {
            sort($data['arquivos_paciente']);
        }
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresapermissao'] = $this->guia->listarempresasaladepermissao($empresa_id);
        $data['listarades'] = $this->laudo->listarades();
        $data['listaradcl'] = $this->laudo->listaradcl();
        $data['listarodes'] = $this->laudo->listarodes();
        $data['listarodcl'] = $this->laudo->listarodcl();
        $data['listarodeixo'] = $this->laudo->listarodeixo();
        $data['listarodav'] = $this->laudo->listarodav();
        $data['listaroees'] = $this->laudo->listaroees();
        $data['listaroecl'] = $this->laudo->listaroecl();
        $data['listaroeeixo'] = $this->laudo->listaroeeixo();
//        var_dump($data['listaroeeixo']); die;
        $data['listaroeav'] = $this->laudo->listaroeav();
        $data['listaracuidadeod'] = $this->laudo->listaracuidadeod();
        $data['listaracuidadeoe'] = $this->laudo->listaracuidadeoe();

        $data['lista'] = $this->exametemp->listarmodeloslaudo($procedimento_tuss_id);
        $data['linha'] = $this->exametemp->listarmodeloslinha($procedimento_tuss_id);
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
        $data['laudo_peso'] = $this->laudo->listarlaudospesoaltura($paciente_id, $ambulatorio_laudo_id);
//        echo '<pre>';
//        var_dump($data['laudo_peso']); die;
        $data['historico'] = $this->laudo->listarconsultahistorico($paciente_id);
        $data['historicoantigo'] = $this->laudo->listarconsultahistoricoantigo($paciente_id);
        $data['historicoexame'] = $this->laudo->listarexamehistorico($paciente_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $data['mensagem'] = $messagem;
        $data['paciente_id'] = $paciente_id;
        $data['exame_id'] = $exame_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->load->View('ambulatorio/laudoconsulta-form', $data);
    }

    function impressaoreceitaoculos($ambulatorio_laudo_id) {
        $this->load->plugin('mpdf');
//        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
//        $data['laudo'] = $obj_laudo;
        $data['laudo'] = $this->laudo->listarreceitaoculosimpressao($ambulatorio_laudo_id);
        $data['medico'] = $this->operador_m->medicoreceituario($data['laudo'][0]->medico_parecer1);
//        var_dump($data['laudo']); die;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['empresa'] = $this->guia->listarempresa();
        $data['receituario'] = true;
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['impressaolaudo'] = $this->guia->listarconfiguracaoimpressaolaudo($empresa_id);
        $cabecalho_config = $data['cabecalho'][0]->cabecalho;
        $rodape_config = $data['cabecalho'][0]->rodape;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        if ($data['laudo'][0]->assinatura == 't') {
            $data['operador_assinatura'] = $data['laudo'][0]->medico_parecer1;
        }

        $base_url = base_url();


        if ($data['laudo'][0]->carimbo == 't') {
            $carimbo = $data['laudo'][0]->medico_carimbo;
        } elseif (isset($data['laudo'][0]->medico_parecer1)) {
            $this->load->helper('directory');
            $arquivo_pasta = directory_map("./upload/1ASSINATURAS/");
            foreach ($arquivo_pasta as $value) {
                if ($value == $data['laudo'][0]->medico_parecer1 . ".jpg") {
                    $carimbo = "<img width='200px;' height='100px;' src='$base_url" . "upload/1ASSINATURAS/$value' />";
                }
            }
        } else {
            $carimbo = "";
        }


//        echo '<pre>';
        $data['assinatura'] = $carimbo;
//        var_dump($data['laudo']);
//        die;

        $filename = "laudo.pdf";
        if ($data['empresa'][0]->cabecalho_config == 't') {
//                $cabecalho = $cabecalho_config;
            $cabecalho = "<table style='width:100%'><tr><td>$cabecalho_config</td></tr><tr><td></td></tr></table><table style='width:100%;text-align:center;'><tr><td><b>Receita de Óculos</b></td></tr></table>";
        } else {
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/cabecalho.jpg'></td></tr><tr><td>Receita de Óculos</td></tr></table>";
        }
        if ($data['empresa'][0]->rodape_config == 't') {
            $rodape = $rodape_config;
        } else {
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
        }
        $html = $this->load->view('ambulatorio/impressaoreceitaoculos', $data, true);
        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('ambulatorio/impressaoreceitaoculos', $data);
    }

    function pendenteexamemultifuncao($exames_id) {
//        $sala_id = $exames_id;
        $verificar = $this->exame->pendenteexamemultifuncao($exames_id);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao encaminhar para sala de pendentes. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao encaminhar para sala de pendentes.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function pendenteodontologia($exames_id) {
//        $sala_id = $exames_id;
        $verificar = $this->exame->pendenteodontologia($exames_id);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao encaminhar para sala de pendentes. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao encaminhar para sala de pendentes.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function pendenteespecialidade($exames_id) {
//        $sala_id = $exames_id;
        $verificar = $this->exame->pendenteespecialidade($exames_id);
        if ($verificar == "-1") {
            $data['mensagem'] = 'Erro ao encaminhar para sala de pendentes. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao encaminhar para sala de pendentes.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function carregaranamineseantigo($paciente_id) {

        $data['historicoantigo'] = $this->laudo->listarconsultahistoricoantigo($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['historicoexame'] = $this->laudo->listarexamehistorico($paciente_id);

        $this->load->View('ambulatorio/laudoconsultaantigo-form', $data);
    }

    function editaranaminesehistorico() {

        $this->laudo->editaranaminesehistorico();
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function carregaranaminesehistorico($laudoantigo_id) {

        $data['historicoantigo'] = $this->laudo->listarconsultahistoricoantigoeditar($laudoantigo_id);
        $this->load->View('ambulatorio/editarhistoricoconsulta-form', $data);
    }

    function carregarreceituario($ambulatorio_laudo_id) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['obj'] = $obj_laudo;
        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['lista'] = $this->exametemp->listarautocompletemodelosreceita();
        $data['modelo'] = $this->exametemp->listarmodelosreceitaautomatico();
        $data['empresapermissao'] = $this->guia->listarempresapermissoes();
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
                $nometemp = "./upload/$exame_id/9999999";
                $newname = "./upload/$exame_id/$sequencia";
                rename($newname, $nometemp);
                rename($oldname, $newname);
                rename($nometemp, $oldname);
                redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
            } elseif ($sequencia == trim($_POST['imagem_id'])) {
                $this->laudo->alterarnome($exame_id, $imagem_id, $novonome, $sequencia);
                $nometemp = "./upload/$exame_id/9999999";
                $newname = "./upload/$exame_id/$sequencia";
                rename($newname, $nometemp);
                rename($oldname, $newname);
                rename($nometemp, $oldname);
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
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
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

    function adicionalcabecalho($cabecalho, $laudo) {

//        $cabecalho = $impressaolaudo[0]->texto;
        $cabecalho = str_replace("_paciente_", $laudo['0']->paciente, $cabecalho);
        $cabecalho = str_replace("_sexo_", $laudo['0']->sexo, $cabecalho);
        $cabecalho = str_replace("_nascimento_", date("d/m/Y", strtotime($laudo['0']->nascimento)), $cabecalho);
        $cabecalho = str_replace("_convenio_", $laudo['0']->convenio, $cabecalho);
        $cabecalho = str_replace("_sala_", $laudo['0']->sala, $cabecalho);
        $cabecalho = str_replace("_CPF_", $laudo['0']->cpf, $cabecalho);
        $cabecalho = str_replace("_solicitante_", $laudo['0']->solicitante, $cabecalho);
        $cabecalho = str_replace("_data_", substr($laudo['0']->data_cadastro, 8, 2) . '/' . substr($laudo['0']->data_cadastro, 5, 2) . '/' . substr($laudo['0']->data_cadastro, 0, 4), $cabecalho);
        $cabecalho = str_replace("_medico_", $laudo['0']->medico, $cabecalho);
        $cabecalho = str_replace("_revisor_", $laudo['0']->medicorevisor, $cabecalho);
        $cabecalho = str_replace("_procedimento_", $laudo['0']->procedimento, $cabecalho);
        $cabecalho = str_replace("_laudo_", $laudo['0']->texto, $cabecalho);
        $cabecalho = str_replace("_nomedolaudo_", $laudo['0']->cabecalho, $cabecalho);
        $cabecalho = str_replace("_queixa_", $laudo['0']->cabecalho, $cabecalho);
        $cabecalho = str_replace("_peso_", $laudo['0']->peso, $cabecalho);
        $cabecalho = str_replace("_altura_", $laudo['0']->altura, $cabecalho);
        $cabecalho = str_replace("_cid1_", $laudo['0']->cid1, $cabecalho);
        $cabecalho = str_replace("_cid2_", $laudo['0']->cid2, $cabecalho);

        return $cabecalho;
    }

    function impressaolaudo($ambulatorio_laudo_id, $exame_id) {


        $this->load->plugin('mpdf');
        $empresa_id = $this->session->userdata('empresa_id');
        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['empresapermissoes'] = $this->guia->listarempresapermissoes();
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalhomedico'] = $this->operador_m->medicocabecalhorodape($data['laudo'][0]->medico_parecer1);
//        var_dump($data['cabecalhomedico']); die;
        $data['impressaolaudo'] = $this->guia->listarconfiguracaoimpressaolaudo($empresa_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;


        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        $data['integracao'] = $this->laudo->listarlaudosintegracao(@$agenda_exames_id);
        if (count($data['integracao']) > 0) {
            $this->laudo->atualizacaolaudosintegracao($agenda_exames_id);
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////
        //LAUDO CONFIGURÁVEL
        if ($data['empresa'][0]->laudo_config == 't') {
            
            $filename = "laudo.pdf";
            if ($data['cabecalhomedico'][0]->cabecalho != '') { // Cabeçalho do Profissional
                $cabecalho = $data['cabecalhomedico'][0]->cabecalho;
            }
            else{
                if (file_exists("upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . ".jpg")) { // Logo do Profissional
                    $cabecalho = '<img style="width: 100%; heigth: 35%;" src="upload/operadorLOGO/' . $data['laudo'][0]->medico_parecer1 . '.jpg"/>';
                }
                else {
                    if ($data['impressaolaudo'][0]->cabecalho == 't') {
                        if ($data['empresa'][0]->cabecalho_config == 't') { // Cabeçalho Da clinica
                            $cabecalho = "$cabecalho_config";
                        } else {
                            $cabecalho = "<table><tr><td><img width='1000px' height='180px' src='img/cabecalho.jpg'></td></tr></table>";
                        }
                    }
                    else {
                        $cabecalho = '';
                    }
                }
            }
//            if ($data['impressaolaudo'][0]->cabecalho == 't') {
//                if ($data['empresa'][0]->cabecalho_config == 't') {
//                    if ($data['cabecalhomedico'][0]->cabecalho != '') {
//                        $cabecalho = $data['cabecalhomedico'][0]->cabecalho;
//                    } else {
//                        $cabecalho = "$cabecalho_config";
//                    }
//                } else {
//                    $cabecalho = "<table><tr><td><img width='1000px' height='180px' src='img/cabecalho.jpg'></td></tr></table>";
//                }
//            } else {
//                $cabecalho = '';
//            }
            $cabecalho = str_replace("_paciente_", $data['laudo'][0]->paciente, $cabecalho);
            $cabecalho = str_replace("_sexo_", $data['laudo'][0]->sexo, $cabecalho);
            $cabecalho = str_replace("_nascimento_", date("d/m/Y", strtotime($data['laudo'][0]->nascimento)), $cabecalho);
            $cabecalho = str_replace("_convenio_", $data['laudo'][0]->convenio, $cabecalho);
            $cabecalho = str_replace("_sala_", $data['laudo'][0]->sala, $cabecalho);
            $cabecalho = str_replace("_CPF_", $data['laudo'][0]->cpf, $cabecalho);
            $cabecalho = str_replace("_solicitante_", $data['laudo'][0]->solicitante, $cabecalho);
            $cabecalho = str_replace("_data_", substr($data['laudo'][0]->data_cadastro, 8, 2) . '/' . substr($data['laudo'][0]->data_cadastro, 5, 2) . '/' . substr($data['laudo'][0]->data_cadastro, 0, 4), $cabecalho);
            $cabecalho = str_replace("_medico_", $data['laudo'][0]->medico, $cabecalho);
            $cabecalho = str_replace("_revisor_", $data['laudo'][0]->medicorevisor, $cabecalho);
            $cabecalho = str_replace("_procedimento_", $data['laudo'][0]->procedimento, $cabecalho);
            $cabecalho = str_replace("_nomedolaudo_", $data['laudo'][0]->cabecalho, $cabecalho);
            $cabecalho = str_replace("_queixa_", $data['laudo'][0]->cabecalho, $cabecalho);
            $cabecalho = str_replace("_cid1_", $data['laudo'][0]->cid1, $cabecalho);
            
            $cabecalho = $cabecalho . "<br> {$data['impressaolaudo'][0]->adicional_cabecalho}";
            $cabecalho = $this->adicionalcabecalho($cabecalho, $data['laudo']);
            
            
            
            if (file_exists("upload/1ASSINATURAS/" . $data['laudo'][0]->medico_parecer1 . ".jpg")) {
                $assinatura = "<img   width='200px' height='100px' src='" . base_url() . "./upload/1ASSINATURAS/" . $data['laudo'][0]->medico_parecer1 . ".jpg'>";
                $data['assinatura'] = "<img   width='200px' height='100px' src='" . base_url() . "./upload/1ASSINATURAS/" . $data['laudo'][0]->medico_parecer1 . ".jpg'>";
            } else {
                $assinatura = "";
                $data['assinatura'] = "";
            }
            
            if ($data['cabecalhomedico'][0]->rodape != '') { // Rodapé do profissional
                $rodape_config = $data['cabecalhomedico'][0]->rodape;
                $rodape_config = str_replace("_assinatura_", $assinatura, $rodape_config);
                $rodape = $rodape_config;    
            }
            else{
                if ($data['impressaolaudo'][0]->rodape == 't') { // rodape da empresa
                    if ($data['empresa'][0]->rodape_config == 't') {
                        $rodape_config = str_replace("_assinatura_", $assinatura, $rodape_config);
                        $rodape = $rodape_config; 
                    }
                    else {
                        $rodape = ""; 
                    }                    
                }
                else {
                    $rodape = ""; 
                }
            }
            
            
//            if ($data['impressaolaudo'][0]->rodape == 't') {
//                if ($data['empresa'][0]->rodape_config == 't') {
////                $cabecalho = $cabecalho_config;
//                    if ($data['cabecalhomedico'][0]->rodape != '') {
//                        $rodape_config = $data['cabecalhomedico'][0]->rodape;
//                    }
//                    $rodape_config = str_replace("_assinatura_", $assinatura, $rodape_config);
//                    $rodape = $rodape_config;
//                } else {
//                    if (!file_exists("upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . ".jpg")) {
//                        $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
//                    }
//                }
//            } else {
//                $rodape = "";
//            }

            $html = $this->load->view('ambulatorio/impressaolaudoconfiguravel', $data, true);
            
            pdf($html, $filename, $cabecalho, $rodape);
        }
        else{ // CASO O LAUDO NÃO CONFIGURÁVEL
    //////////////////////////////////////////////////////////////////////////////////////////////////
            if ($data['empresa'][0]->impressao_laudo == 1) {//HUMANA IMAGEM
                $filename = "laudo.pdf";
                if ($data['empresa'][0]->cabecalho_config == 't') {
    //                $cabecalho = $cabecalho_config;
                    $cabecalho = "<table><tr><td>$cabecalho_config</td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                } else {
                    $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                }
                if ($data['empresa'][0]->rodape_config == 't') {
                    $rodape = $rodape_config;
                } else {
                    $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
                }
                $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
                pdf($html, $filename, $cabecalho, $rodape);
                $this->load->View('ambulatorio/impressaolaudo_1', $data);
            }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
            elseif ($data['empresa'][0]->impressao_laudo == 10) {//CLINICA MED
                $filename = "laudo.pdf";
                if ($data['empresa'][0]->cabecalho_config == 't') {
    //                $cabecalho = $cabecalho_config;
                    $cabecalho = "<table width=100% border=1><tr> <td>$cabecalho_config</td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                } else {
                    $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='180px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                }

                if ($data['empresa'][0]->rodape_config == 't') {
                    $rodape = $rodape_config;
                } else {
                    $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
                }


                $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
                pdf($html, $filename, $cabecalho, $rodape);
                $this->load->View('ambulatorio/impressaolaudo_1', $data);
            }

    // //////////////////////////////////////////////////////////////////////////////////////////////////////////////       
            elseif ($data['empresa'][0]->impressao_laudo == 11) {//CLINICA MAIS
                $filename = "laudo.pdf";
    //            var_dump( $data['laudo']['0']->carimbo); die;
                $cabecalho = $cabecalho_config;
                if ($data['empresa'][0]->cabecalho_config == 't') {
    //                $cabecalho = $cabecalho_config;
                    $cabecalho = "<table><tr><td>$cabecalho_config</td></tr><tr><td>&nbsp;</td></tr><tr><td><b>NOME:" . $data['laudo']['0']->paciente . "<b><br>EXAME: " . $data['laudo']['0']->cabecalho . "<br><b>DATA: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</b></td></tr><tr><td>&nbsp;</td></tr></table> <table  width='100%' style='width:100%; text-align:center;'><tr><td><b>LAUDO</b></td></tr></table>";
                } else {
                    $cabecalho = "<table><tr><td><img align = 'left'  width='300px' height='90px' src='img/logomais.png'></td></tr><tr><td>&nbsp;</td></tr><tr><td><b>NOME:" . $data['laudo']['0']->paciente . "<b><br>EXAME: " . $data['laudo']['0']->cabecalho . "<br><b>DATA: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</b></td></tr><tr><td>&nbsp;</td></tr></table> <table  width='100%' style='width:100%; text-align:center;'><tr><td><b>LAUDO</b></td></tr></table>";
                }

                if ($data['laudo']['0']->situacao == "DIGITANDO") {
                    $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt; text-align:center;'><tr><td>" . $data['laudo']['0']->carimbo . "</td></tr>
                <tr><td><center></td></tr></table><img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
                } elseif ($data['laudo']['0']->situacao == "FINALIZADO") {
    //                echo $data['laudo']['0']->carimbo;
                    if ($data['empresa'][0]->rodape_config == 't') {
    //                $cabecalho = $cabecalho_config;
                        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></table>$rodape_config<br><br><br>";
                    } else {
                        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></table><img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'><br><br><br>";
                    }
                }
                $html = $this->load->view('ambulatorio/impressaolaudo_1pacajus', $data, true);
                pdf($html, $filename, $cabecalho, $rodape);
                $this->load->View('ambulatorio/impressaolaudo_1pacajus', $data);
            }

    ////////////////////////////////////////////////////////////////////////////////////////////
            elseif ($data['empresa'][0]->impressao_laudo == 6) {//CLINICA DEZ
                $filename = "laudo.pdf";
                if ($data['empresa'][0]->cabecalho_config == 't') {
    //                $cabecalho = $cabecalho_config;
                    $cabecalho = "<table><tr><td>$cabecalho_config</td></tr><tr><td>&nbsp;</td></tr><tr><td><b>NOME:" . $data['laudo']['0']->paciente . "<b><br>EXAME: " . $data['laudo']['0']->cabecalho . "<br><b>DATA: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</b></td></tr><tr><td>&nbsp;</td></tr></table> <table  width='100%' style='width:100%; text-align:center;'><tr><td><b>LAUDO</b></td></tr></table>";
                } else {
                    $cabecalho = "<table><tr><td><img align = 'left'  width='300px' height='90px' src='img/logomais.png'></td></tr><tr><td>&nbsp;</td></tr><tr><td><b>NOME:" . $data['laudo']['0']->paciente . "<b><br>EXAME: " . $data['laudo']['0']->cabecalho . "<br><b>DATA: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</b></td></tr><tr><td>&nbsp;</td></tr></table> <table  width='100%' style='width:100%; text-align:center;'><tr><td><b>LAUDO</b></td></tr></table>";
                }
    //            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='90px' src='img/clinicadez.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                if ($data['empresa'][0]->rodape_config == 't') {
    //                $cabecalho = $cabecalho_config;
                    $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></table><table><tr><td><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rua Dr. Batista de Oliveira, 302 - Papicu - Fortaleza - Ceará</center></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: (85) 3017-0010 - (85) 3265-7007</tr></table>";
                } else {
                    $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></table><table><tr><td><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rua Dr. Batista de Oliveira, 302 - Papicu - Fortaleza - Ceará</center></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: (85) 3017-0010 - (85) 3265-7007</tr></table>";
                }
                $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
                $grupo = 'laboratorial';
                pdf($html, $filename, $cabecalho, $rodape, $grupo);
                $this->load->View('ambulatorio/impressaolaudo_1', $data);
            }

    //   /////////////////////////////////////////////////////////////////////////////////////////////     
            elseif ($data['empresa'][0]->impressao_laudo == 2) {//CLINICA PROIMAGEM
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
    <td width='30px'></td><td width='400px'>Reg.:" . $data['laudo']['0']->paciente_id . "</td><td>Emiss&atilde;o: " . substr($data['laudo']['0']->data, 8, 2) . '/' . substr($data['laudo']['0']->data, 5, 2) . '/' . substr($data['laudo']['0']->data, 0, 4) . "</td>
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
            }

    /////////////////////////////////////////////////////////////////////////////////////////////////////
            if ($data['empresa'][0]->impressao_laudo == 12) {//PRONTOMEDICA
                $filename = "laudo.pdf";
                $cabecalho = "<table>
    <tr>
      <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/clinicadez.jpg'></td>
    </tr>
    <tr>
    <td width='30px'></td><td width='400px'>Numero do exame: " . $ambulatorio_laudo_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
    </tr>
    <tr>
      <td width='30px'></td><td >Paciente: " . strtoupper($data['laudo']['0']->paciente) . "</td><td>Idade: " . $teste . "</td>
    </tr>
    <tr>
    <td width='30px'></td><td>Solicitante: Dr(a). " . strtoupper($data['laudo']['0']->solicitante) . "</td><td>Data de Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td>
    </tr>
    <tr>
    <td width='30px'></td><td>Covenio: " . $data['laudo']['0']->convenio . "</td>
    </tr>
    </tr>
    </tr><tr><td>&nbsp;</td></tr>
    <tr>
    </table>";
                $rodape = "";
                if ($data['laudo']['0']->situacao == "FINALIZADO") {
                    $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></table>";
                } else {
                    if ($data['laudo']['0']->medico_parecer1 == 929) {

                        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                <tr><td><center>Ultrassonografista</td></tr>
                <tr><td><center>CRM" . $data['laudo']['0']->conselho . "/CBR01701</td></tr></table>";
                    } else {
                        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
                    }
                }
                $grupo = 'laboratorial';
                $html = $this->load->view('ambulatorio/impressaolaudo_8', $data, true);
                pdf($html, $filename, $cabecalho, $rodape, $grupo);
                $this->load->View('ambulatorio/impressaolaudo_8', $data);
            }
            //////////////////////////////////////////////////////////////////////////////////////////////
            if ($data['empresa'][0]->impressao_laudo == 19) {//OLÁ CLINICA
                $filename = "laudo.pdf";
                if ($data['empresa'][0]->cabecalho_config == 't') {
    //                $cabecalho = $cabecalho_config;
                    $cabecalho = "<table>
    <tr>
      <td width='30px'></td><td>$cabecalho_config</td>
    </tr>
    <tr>
    <td width='30px'></td><td width='400px'>Numero do exame: " . $ambulatorio_laudo_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
    </tr>
    <tr>
      <td width='30px'></td><td >Paciente: " . strtoupper($data['laudo']['0']->paciente) . "</td><td>Idade: " . $teste . "</td>
    </tr>
    <tr>
    <td width='30px'></td><td>Solicitante: Dr(a). " . strtoupper($data['laudo']['0']->solicitante) . "</td><td>Data de Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td>
    </tr>
    <tr>
    <td width='30px'></td><td>Covenio: " . $data['laudo']['0']->convenio . "</td>
    </tr>
    </tr>
    </tr><tr><td>&nbsp;</td></tr>
    <tr>
    </table>";
                } else {
                    $cabecalho = "<table>
    <tr>
      <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/clinicadez.jpg'></td>
    </tr>
    <tr>
    <td width='30px'></td><td width='400px'>Numero do exame: " . $ambulatorio_laudo_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
    </tr>
    <tr>
      <td width='30px'></td><td >Paciente: " . strtoupper($data['laudo']['0']->paciente) . "</td><td>Idade: " . $teste . "</td>
    </tr>
    <tr>
    <td width='30px'></td><td>Solicitante: Dr(a). " . strtoupper($data['laudo']['0']->solicitante) . "</td><td>Data de Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td>
    </tr>
    <tr>
    <td width='30px'></td><td>Covenio: " . $data['laudo']['0']->convenio . "</td>
    </tr>
    </tr>
    </tr><tr><td>&nbsp;</td></tr>
    <tr>
    </table>";
                }

                $rodape = "";

                if ($data['laudo']['0']->situacao == "FINALIZADO") {
                    $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></table>";
                } else {
                    if ($data['laudo']['0']->medico_parecer1 == 929) {

                        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                <tr><td><center>Ultrassonografista</td></tr>
                <tr><td><center>CRM" . $data['laudo']['0']->conselho . "/CBR01701</td></tr></table>";
                    } else {
                        $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
                    }
                }
                if ($data['empresa'][0]->rodape_config == 't') {
    //                $cabecalho = $cabecalho_config;
                    $rodape = $rodape . '<br>' . $rodape_config;
                } else {
                    $rodape = $rodape . '<br>' . "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='330px' height='100px' src='img/rodape.jpg'></td></tr></table>";
                }
                $grupo = 'laboratorial';
                $html = $this->load->view('ambulatorio/impressaolaudo_8', $data, true);
                pdf($html, $filename, $cabecalho, $rodape, $grupo);
                $this->load->View('ambulatorio/impressaolaudo_8', $data);
            }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////        
            elseif ($data['empresa'][0]->impressao_laudo == 15) {//INSTITUTO VASCULAR
                $filename = "laudo.pdf";
                $cabecalho = "<table>
    <tr>
      <td width='300px'></td><td width='180px'></td><td><img align = 'right'  width='180px' height='90px' src='img/clinicadez.jpg'></td>
    </tr>

    <tr>
      <td >PACIENTE: " . $data['laudo']['0']->paciente . "</td><td>IDADE: " . $teste . "</td>
    </tr>
    <tr>
    <td>COVENIO: " . $data['laudo']['0']->convenio . "</td><td>NASCIMENTO: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td>
    </tr>
    <tr>
    <td>INDICA&Ccedil;&Atilde;O: " . $data['laudo']['0']->indicacao . "</td><td>DATA: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
    </tr>

    </tr>
    </tr><tr><td>&nbsp;</td></tr>
    <tr>
    </table>";
                $rodape = "";
                if ($data['laudo']['0']->situacao == "FINALIZADO") {
                    $rodape = "<table  width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr>"
                            . "<tr><td><img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'></td></tr>"
                            . "</table> ";
                } else {
                    $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr>"
                            . "<tr><td><img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'></td></tr>"
                            . "</table> ";
                }
                $grupo = 'laboratorial';

                $html = $this->load->view('ambulatorio/impressaolaudo_5', $data, true);

                pdf($html, $filename, $cabecalho, $rodape, $grupo);
                $this->load->View('ambulatorio/impressaolaudo_5', $data);
            }
    ///////////////////////////////////////////////////////////////////////////////////////////////        
            elseif ($data['empresa'][0]->impressao_laudo == 13) {// CLINICA CAGE
                if ($data['laudo']['0']->sexo == "F") {
                    $SEXO = 'FEMININO';
                } else {
                    $SEXO = 'MASCULINO';
                }

                $filename = "laudo.pdf";
                $cabecalho = "<table>
            <tr>
              <td><img align = 'left'  width='330px' height='100px' src='img/cage.jpg'></td>
            </tr>
            <tr><td></td></tr>

            <tr><td>&nbsp;</td></tr>
            <tr>
            <td width='430px'>Nome.:" . $data['laudo']['0']->paciente . "</td><td>Idade:" . substr($teste, 0, 2) . "</td>
            </tr>
            <tr>
              <td >Sexo:" . $SEXO . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
            </tr>
            <tr>
            <td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td></td>
            </tr>

            <tr>
            <td colspan='2'><b><center>" . $data['laudo']['0']->cabecalho . "</center></b></td>
            </tr>
            </table>";
                $rodape = "";

                $grupo = 'laboratorial';
                $html = $this->load->view('ambulatorio/impressaolaudo_6', $data, true);
                pdf($html, $filename, $cabecalho, $rodape, $grupo);
                $this->load->View('ambulatorio/impressaolaudo_6', $data);
            }

            ///////////////////////////////////////////////////////////////////////////////////////////
            elseif ($data['empresa'][0]->impressao_laudo == 8) {//RONALDO BARREIRA
                $medicoparecer = $data['laudo']['0']->medico_parecer1;
    //            echo "<pre>"; var_dump($data['laudo']['0']);die;
                $cabecalho = "<table><tr><td><center></td></tr>

                        <tr><td colspan='2'>Exame de: " . $data['laudo']['0']->paciente . "</td></tr>
                        <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "----Idade: " . $teste . "</td></tr>
                        <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "----Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                        <tr><td>Convenio: " . $data['laudo']['0']->convenio . "----Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
                        </table>";
                if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
                    $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
                        <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
                        <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>           
                        <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                        <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                        <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                        <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
                        </table>";
                }
                if ($data['laudo']['0']->medico_parecer1 != 929) {
                    $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                        <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
                }
                if ($data['laudo']['0']->medico_parecer1 == 929 && $data['laudo']['0']->situacao != "FINALIZADO") {
                    $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                        <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
                        <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
                }
                if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 929) {
                    $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width='200px' height='130px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
                }
                if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 930) {
                    $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
                }
                if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 2483) {
                    $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
                }
                $grupo = $data['laudo']['0']->grupo;
                $filename = "laudo.pdf";
                $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
                pdf($html, $filename, $cabecalho, $rodape, $grupo);
                $this->load->View('ambulatorio/impressaolaudo_2', $data);
            }
            //////////////////////////////////////////////////////////////////////////////       
            else {//GERAL       //este item fica sempre por último
                $filename = "laudo.pdf";
                if ($data['cabecalhomedico'][0]->cabecalho != '') {
                    $cabecalho = $data['cabecalhomedico'][0]->cabecalho."<table><tr><td></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                } else {
                    if ($data['empresa'][0]->cabecalho_config == 't') {
                        $cabecalho = "$cabecalho_config<table><tr><td></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                    } else {
                        if (file_exists("upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . ".jpg")) {
                            $img = '<img style="width: 100%; height: 40%;" src="upload/operadorLOGO/' . $data['laudo'][0]->medico_parecer1 . '.jpg"/>';
                        } else {
                            $img = "<img align = 'left'style='width: 100%; height: 40%;'  src='img/cabecalho.jpg'>";
                        }
                        $cabecalho = "<table><tr><td>" . $img . "</td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                    }
                }
                //            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='90px' src='img/clinicadez.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
                if ($data['cabecalhomedico'][0]->rodape != '') {
                    $rodape_config = $data['cabecalhomedico'][0]->rodape;
                } else {
                    if ($data['empresa'][0]->rodape_config == 't') {
        //                $cabecalho = $cabecalho_config;
                        $rodape = $rodape_config;
                    } else {
                        if(!file_exists("upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . ".jpg")){
                            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
                        }
                    }
                }


                $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
                pdf($html, $filename, $cabecalho, $rodape);
                $this->load->View('ambulatorio/impressaolaudo_1', $data);
            }
        }
    }

    function impressaolaudolaboratorial($ambulatorio_laudo_id, $exame_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['empresa'] = $this->guia->listarempresa();

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');


        if ($data['empresa'][0]->impressao_tipo == 1) {//HUMANA IMAGEM
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);
        }

////////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 10) {//CDC
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);
        }

////////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 11) {//CLINICA MAIS
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='110px' src='img/logomais.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='900px' height='100px' src='img/rodapemais.png'>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);
        }

//////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 6) {//CLINICA DEZ
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='90px' src='img/clinicadez.jpg'></td><td><center>CLÍNICA DEZ <br> LABORATÓRIO DE ANÁLISES CLÍNICAS</center></td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "  </td><td> Data da Coleta: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . " </td></tr><tr><td> Medico:" . $data['laudo']['0']->medicosolicitante . "   </td><td>  RG: " . $data['laudo']['0']->rg . "</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table>";
            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></table><table><tr><td><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rua Dr. Batista de Oliveira, 302 - Papicu - Fortaleza - Ceará</center></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: (85) 3017-0010 - (85) 3265-7007</tr></table>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            $grupo = 'laboratorial';
            pdf($html, $filename, $cabecalho, $rodape, $grupo);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);
        }

/////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 8) {//RONALDO BARREIRA
            $medicoparecer = $data['laudo']['0']->medico_parecer1;
            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
                    <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
                    <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                    <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                    <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                    <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
                    </table>";
            if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
                $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
                    <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
                    <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
                    <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                    <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                    <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                    <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
                    </table>";
            }
            if ($data['laudo']['0']->medico_parecer1 != 929) {
                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                    <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            }
            if ($data['laudo']['0']->medico_parecer1 == 929 && $data['laudo']['0']->situacao != "FINALIZADO") {
                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                    <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
                    <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            }
            if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 929) {
                $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width='200px' height='130px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
            }
            if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 930) {
                $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
            }
            if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 2483) {
                $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
            }
            $grupo = $data['laudo']['0']->grupo;
            $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
            pdf($html, $filename, $cabecalho, $rodape, $grupo);
            $this->load->View('ambulatorio/impressaolaudo_2', $data);
        }

////////////////////////////////////////////////////////////////////////////////////////        
        else {//GERAL   // este item fica sempre por último
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/CABECALHO.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);
        }
    }

    function impressaolaudoeco($ambulatorio_laudo_id, $exame_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['empresa'] = $this->guia->listarempresa();

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');
    }

    function impressaolaudo2via($ambulatorio_laudo_id, $exame_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['empresa'] = $this->guia->listarempresa();

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

//                GERAL
//                $filename = "laudo.pdf";
//                $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/CABECALHO.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
//                $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
//                $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
//                pdf($html, $filename, $cabecalho, $rodape);
//                $this->load->View('ambulatorio/impressaolaudo_1', $data);
        //PROIMAGEM
//        $filename = "laudo.pdf";
//        $cabecalho = "<table>
//        <tr>
//          <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/clinicadez.jpg'></td>
//        </tr>
//        <td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
//        <tr>
//        <td width='30px'></td><td>" . substr($data['laudo']['0']->sala, 0, 10) . "</td>
//        </tr>
//        <tr>
//        <td width='30px'></td><td width='400px'>Reg.:" . $data['laudo']['0']->paciente_id . "</td><td>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
//        </tr>
//        <tr>
//          <td width='30px'></td><td >Paciente:" . $data['laudo']['0']->paciente . "</td><td>Idade:" . $teste . "</td>
//        </tr>
//        <tr>
//        <td width='30px'></td><td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td>Sexo:" . $data['laudo']['0']->sexo . "</td>
//        </tr>
//        </tr>
//        </tr><tr><td>&nbsp;</td></tr>
//        <tr>
//        </table>";
//        $rodape = "";
//        if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer2 == "") {
//            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td width='400px'></td><td><img align = 'Right'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td></tr></tr><tr><td>&nbsp;</td></tr></table>";
//        } elseif ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer2 != "") {
//            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td width='30px'></td><td><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer1 . ".jpg'></td><td width='30px'></td><td><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $data['laudo']['0']->medico_parecer2 . ".jpg'></td></tr></tr><tr><td>&nbsp;</td></tr></table>";
//        }
//        $grupo = 'laboratorial';
//        $html = $this->load->view('ambulatorio/impressaolaudo_5', $data, true);
//        pdf($html, $filename, $cabecalho, $rodape, $grupo);
//        $this->load->View('ambulatorio/impressaolaudo_5', $data);
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




        if ($data['empresa'][0]->impressao_tipo == 1) {//HUMANA        
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);
        }

/////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 13) {//CAGE        
            if ($data['laudo']['0']->sexo == "F") {
                $SEXO = 'FEMININO';
            } else {
                $SEXO = 'MASCULINO';
            }

            $filename = "laudo.pdf";
            $cabecalho = "<table>
        <tr>
          <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='img/cage.jpg'></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td width='30px'></td><td colspan='2'><b><center>" . $data['laudo']['0']->cabecalho . "</center></b></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td width='30px'></td><td width='350px'>Reg.:" . $data['laudo']['0']->paciente . "</td><td>Idade:" . $teste . "</td>
        </tr>
        <tr>
          <td width='30px'></td><td >Sexo:" . $SEXO . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td>
        </tr>
        <tr>
        <td width='30px'></td><td>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "</td><td></td>
        </tr>
        
                                                                                                                                                                                                        <tr>
        <td width='30px'></td><td><b>VIDEOENDOSCOPIO:</b> Olympus Exera CV 145</td><td><b>MONITORIZA&Ccedil;&Atilde;O:</b> Oximetria de pulso</td>
        </tr>
        </table>";
            $rodape = "";

            $grupo = 'laboratorial';
            $html = $this->load->view('ambulatorio/impressaolaudo_6', $data, true);
            pdf($html, $filename, $cabecalho, $rodape, $grupo);
            $this->load->View('ambulatorio/impressaolaudo_6', $data);
        }

///////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 10) {//CDC
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);

/////////////////////////////////////////////////////////////////////////////////////////////////            
        } elseif ($data['empresa'][0]->impressao_tipo == 6) {//CLINICA DEZ     
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='90px' src='img/clinicadez.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rua Dr. Batista de Oliveira, 302 - Papicu - Fortaleza - Ceará</center></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: (85) 3017-0010 - (85) 3265-7007</tr></table>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);
        }

/////////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 8) {//RONALDO BARREIRA
            $medicoparecer = $data['laudo']['0']->medico_parecer1;
            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
                    <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
                    <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                    <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                    <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                    <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
                    </table>";
            if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
                $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
                    <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
                    <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
                    <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                    <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                    <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                    <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
                    </table>";
            }
            if ($data['laudo']['0']->medico_parecer1 != 929) {
                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                    <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            }
            if ($data['laudo']['0']->medico_parecer1 == 929 && $data['laudo']['0']->situacao != "FINALIZADO") {
                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                    <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
                    <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            }
            if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 929) {
                $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width='200px' height='130px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
            }
            if ($data['laudo']['0']->situacao == "FINALIZADO" && $data['laudo']['0']->medico_parecer1 == 930) {
                $rodape = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img  width='120px' height='80px' src='upload/1ASSINATURAS/$medicoparecer.bmp'>";
            }
            $grupo = $data['laudo']['0']->grupo;
            $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
            pdf($html, $filename, $cabecalho, $rodape, $grupo);
            $this->load->View('ambulatorio/impressaolaudo_2', $data);

///////////////////////////////////////////////////////////////////////////////////////            
        } else {//GERAL        //  este item fica sempre por ultimo
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/CABECALHO.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Solicitante: Dr(a). " . $data['laudo']['0']->solicitante . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaolaudo_1', $data);
        }
    }

    function impressaoreceita($ambulatorio_laudo_id) {

        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarreceitaimpressao($ambulatorio_laudo_id);
        $data['medico'] = $this->operador_m->medicoreceituario($data['laudo'][0]->medico_parecer1);
//        var_dump($data['medico']); die;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['empresa'] = $this->guia->listarempresa();
        $data['receituario'] = true;
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalhomedico'] = $this->operador_m->medicocabecalhorodape($data['laudo'][0]->medico_parecer1);
        $data['impressaolaudo'] = $this->guia->listarconfiguracaoimpressaolaudo($empresa_id);
        $cabecalho_config = $data['cabecalho'][0]->cabecalho;
        $rodape_config = $data['cabecalho'][0]->rodape;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        if ($data['laudo'][0]->assinatura == 't') {
            $data['operador_assinatura'] = $data['laudo'][0]->medico_parecer1;
        }

        $base_url = base_url();


        if ($data['laudo'][0]->assinatura == 't') {
            if (isset($data['laudo'][0]->medico_parecer1)) {
                $this->load->helper('directory');
                $arquivo_pasta = directory_map("./upload/1ASSINATURAS/");
                foreach ($arquivo_pasta as $value) {
                    if ($value == $data['laudo'][0]->medico_parecer1 . ".jpg") {
                        $carimbo = "<img width='200px;' height='100px;' src='$base_url" . "upload/1ASSINATURAS/$value' />";
                    }
                }
            }
        } elseif ($data['laudo'][0]->carimbo == 't') {
            $carimbo = $data['laudo'][0]->medico_carimbo;
        } else {
            $carimbo = "";
        }
        $data['assinatura'] = $carimbo;

//        var_dump($carimbo);die;
        $meses = array('01' => "Janeiro", '02' => "Fevereiro", '03' => "Março", '04' => "Abril", '05' => "Maio", '06' => "Junho", '07' => "Julho", '08' => "Agosto", '09' => "Setembro", '10' => "Outubro", '11' => "Novembro", '12' => "Dezembro");

        $dia = substr($data['laudo'][0]->data_cadastro, 8, 2);
        $mes = substr($data['laudo'][0]->data_cadastro, 5, 2);
        $ano = substr($data['laudo'][0]->data_cadastro, 0, 4);

        $nomemes = $meses[$mes];



        $texto_rodape = "Fortaleza, " . $dia . " de " . $nomemes . " de " . $ano;
        
        if ($data['empresa'][0]->ficha_config == 't') {
            if ($data['empresa'][0]->cabecalho_config == 't') {
                if ($data['cabecalhomedico'][0]->cabecalho != '') {
                    $cabecalho = $data['cabecalhomedico'][0]->cabecalho;
                } else {
                    $cabecalho = "$cabecalho_config";
                }
//                $cabecalho = $cabecalho_config;
            } else {
                $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr></table>";
            }
            
            if (file_exists("upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . ".jpg") && $data['cabecalhomedico'][0]->cabecalho == '') {
                $cabecalho = '<img width="300px" height="50px" src="upload/operadorLOGO/' . $data['laudo'][0]->medico_parecer1 . '.jpg"/>';
            }

            if ($data['empresa'][0]->rodape_config == 't') {
                if ($data['cabecalhomedico'][0]->rodape != '') {
                    $rodape_config = $data['cabecalhomedico'][0]->rodape;
                }
                $rodape_config = str_replace("_assinatura_", $carimbo, $rodape_config);
                $rodape = $texto_rodape . $rodape_config;
            } else {
                $rodape = "<table><tr><td>$texto_rodape</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  >$carimbo</td></tr></table><table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'></td></tr></table>";
            }

            $filename = "laudo.pdf";
//            $cabecalho = "<table ><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td><center><b><p style='text-align: center; font-weight: bold;'>Receita Médica</p></b></center></td></tr><tr><td>Para:" . $data['laudo']['0']->paciente . "<br></td></tr></table>";
//            $rodape = "<table><tr><td>$texto_rodape</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td ></td></tr></table><div>$carimbo</div><table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'></td></tr></table>";
            if (!preg_match('/\_paciente_/', $data['laudo'][0]->texto)) {
                $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            } else {
                $html = $this->load->view('ambulatorio/impressaoreceituarioconfiguravel', $data, true);
            }
            pdf($html, $filename, $cabecalho, $rodape);
        }

        if ($data['empresa'][0]->impressao_tipo == 1) {//HUMANA        
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

/////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 13) {//CAGE        
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/cage.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapecage.jpg'>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

///////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 10) {//CDC
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);

/////////////////////////////////////////////////////////////////////////////////////////////////            
        } elseif ($data['empresa'][0]->impressao_tipo == 6) {//CLINICA DEZ     
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  src='img/cabecalho.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td><center><img align = 'left'  src='img/rodape.jpg'></center></td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

/////////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 8) {//RONALDO BARREIRA
            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
                        <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
                        <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
                        <tr><td></td><td></td></tr>
                        <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                        <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                        <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                        <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
                        </table>";
            if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
                $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
                        <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
                        <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
                        <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                        <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                        <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                        <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
                        </table>";
            }
            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                        <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            if ($data['laudo']['0']->medico_parecer1 == 929) {
                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                        <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
                        <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            }
            $grupo = $data['laudo']['0']->grupo;
            $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
            pdf($html, $filename, $cabecalho, $rodape, $grupo);

///////////////////////////////////////////////////////////////////////////////////////            
        } else {//GERAL        //  este item fica sempre por ultimo
            $filename = "laudo.pdf";
            
            if (file_exists("upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . ".jpg")) {
                $img = '<img width="700px" src="upload/operadorLOGO/' . $data['laudo'][0]->medico_parecer1 . '.jpg"/>';
            }
            else{
                $img = "<img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'>";
            }
            
            $cabecalho = "<table ><tr><td>" . $img . "</td></tr><tr><td><center><b><p style='text-align: center; font-weight: bold;'>Receita Médica</p></b></center></td></tr><tr><td>Para:" . $data['laudo']['0']->paciente . "<br></td></tr></table>";
            $rodape = "<table><tr><td>$texto_rodape</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td ></td></tr></table><div>$carimbo</div><table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'></td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }
    }

    function impressaosolicitarexame($ambulatorio_laudo_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarsolicitarexameimpressao($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['empresa'] = $this->guia->listarempresa();

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');


        if ($data['laudo'][0]->assinatura == 't') {
            $data['operador_assinatura'] = $data['laudo'][0]->medico_parecer1;
        }

        if ($data['empresa'][0]->impressao_tipo == 1) {//HUMANA        
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/humana.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 13) {//CAGE        
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='img/cage.jpg'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapecage.jpg'>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        } elseif ($data['empresa'][0]->impressao_tipo == 10) {//CDC
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='img/logo2.png'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

///////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 6) {//CLINICA DEZ     
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  src='img/cabecalho.jpg'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td><center><img align = 'left'  src='img/rodape.jpg'></center></td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

////////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 8) {//RONALDO BARREIRA
            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
                    <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
                    <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                    <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                    <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                    <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
                    </table>";
            if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
                $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
                    <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
                    <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
                    <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                    <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                    <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                    <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
                    </table>";
            }
            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                    <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            if ($data['laudo']['0']->medico_parecer1 == 929) {
                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                    <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
                    <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            }
            $grupo = $data['laudo']['0']->grupo;
            $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
            pdf($html, $filename, $cabecalho, $rodape, $grupo);
        } else { //GERAL        // este item fica sempre por ultimo
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }
    }

    function impressaoatestado($ambulatorio_laudo_id) {

        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listaratestadoimpressao($ambulatorio_laudo_id);
        $data['medico'] = $this->operador_m->medicoreceituario($data['laudo'][0]->medico_parecer1);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['empresa'] = $this->guia->listarempresa();

        $data['atestado'] = true;
        $data['imprimircid'] = $data['laudo']['0']->imprimir_cid;
        $data['co_cid'] = $data['laudo']['0']->cid1;
        $data['co_cid2'] = $data['laudo']['0']->cid2;
//        var_dump($data); die;
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['impressaolaudo'] = $this->guia->listarconfiguracaoimpressaolaudo($empresa_id);
        $cabecalho_config = $data['cabecalho'][0]->cabecalho;
        $rodape_config = $data['cabecalho'][0]->rodape;

        if (isset($data['co_cid'])) {
            $data['cid'] = $this->laudo->listarcid($data['co_cid']);
        }

        if (isset($data['co_cid'])) {
            $data['cid2'] = $this->laudo->listarcid($data['co_cid2']);
        }

        if ($data['laudo'][0]->assinatura == 't') {
            $data['operador_assinatura'] = $data['laudo'][0]->medico_parecer1;
        }

        $base_url = base_url();

        $this->load->helper('directory');
        $arquivos = directory_map("./upload/operadorLOGO/");
        $arquivo_existe = false;
        foreach ($arquivos as $value) {
            if ($value == $data['laudo'][0]->medico_parecer1 . ".jpg") {
                $arquivo_existe = true;
                $data['medico_parecer1'] = $data['laudo'][0]->medico_parecer1;
                break;
            }
        }
//        var_dump($data['laudo'][0]->medico_parecer1);die;

        if ($data['laudo'][0]->assinatura == 't') {
            if (isset($data['laudo'][0]->medico_parecer1)) {
                $this->load->helper('directory');
                $arquivo_pasta = directory_map("./upload/1ASSINATURAS/");
                foreach ($arquivo_pasta as $value) {
                    if ($value == $data['laudo'][0]->medico_parecer1 . ".jpg") {
                        $carimbo = "<img width='200px;' height='100px;' src='$base_url" . "upload/1ASSINATURAS/$value'/>";
                    }
                }
            }
        } elseif ($data['laudo'][0]->carimbo == 't') {
            $carimbo = $data['laudo'][0]->medico_carimbo;
        } else {
            $carimbo = "";
        }
        $data['assinatura'] = $carimbo;
//        var_dump($carimbo); die;

        $meses = array('01' => "Janeiro", '02' => "Fevereiro", '03' => "Março", '04' => "Abril", '05' => "Maio", '06' => "Junho", '07' => "Julho", '08' => "Agosto", '09' => "Setembro", '10' => "Outubro", '11' => "Novembro", '12' => "Dezembro");

        $dia = substr($data['laudo'][0]->data, 8, 2);
        $mes = substr($data['laudo'][0]->data, 5, 2);
        $ano = substr($data['laudo'][0]->data, 0, 4);

        $nomemes = $meses[$mes];

        $texto_rodape = "Fortaleza, " . $dia . " de " . $nomemes . " de " . $ano;


        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        if ($data['empresa'][0]->ficha_config == 't') {
            if ($arquivo_existe) {
                $src = base_url() . "upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . '.jpg';
            } else {
                $src = 'img/cabecalho.jpg';
            }
            $filename = "Atestado.pdf";
            if ($data['empresa'][0]->cabecalho_config == 't') {
                $cabecalho = $cabecalho_config;
            } else {
                $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='{$src}'></td></tr></table>";
            }
            $rodape_config = str_replace("_assinatura_", $carimbo, $rodape_config);
            if ($data['empresa'][0]->atestado_config == 't') {
                $rodape = $texto_rodape . $rodape_config;
            } else {
                $rodape = "<table><tr><td>$texto_rodape</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  >$carimbo</td></tr></table><table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'></td></tr></table>";
            }

            $html = $this->load->view('ambulatorio/impressaoatestadoconfiguravel', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
//            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }


        if ($data['empresa'][0]->impressao_tipo == 14) {//MEDLAB
            if ($arquivo_existe) {
                $src = base_url() . "upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . '.jpg';
            } else {
                $src = 'img/medlab.jpg';
            }
            $filename = "laudo.pdf";

            if ($data['empresa'][0]->cabecalho_config == 't') {
                $cabecalho = "$cabecalho_config";
            } else {
                $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='{$src}'></td></tr></table>";
            }

//        $rodape = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
            $html = $this->load->view('ambulatorio/impressaoreceituariomedlab', $data, true);
            pdf($html, $filename, $cabecalho);
            $this->load->View('ambulatorio/impressaoreceituariomedlab', $data);
        }

//////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 1) {//HUMANA   
            if ($arquivo_existe) {
                $src = base_url() . "upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . '.jpg';
            } else {
                $src = 'img/humana.jpg';
            }
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='{$src}'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data, 8, 2) . '/' . substr($data['laudo']['0']->data, 5, 2) . '/' . substr($data['laudo']['0']->data, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

//////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 13) {//CAGE      
            if ($arquivo_existe) {
                $src = base_url() . "upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . '.jpg';
            } else {
                $src = 'img/cage.jpg';
            }
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  width='180px' height='180px' src='{$src}'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data, 8, 2) . '/' . substr($data['laudo']['0']->data, 5, 2) . '/' . substr($data['laudo']['0']->data, 0, 4) . "</td></tr></table>";
            $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapecage.jpg'>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

//////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 10) {//CDC
            if ($arquivo_existe) {
                $src = base_url() . "upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . '.jpg';
            } else {
                $src = 'img/logo2.png';
            }
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td><img align = 'left'  width='180px' height='80px' src='{$src}'></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data, 8, 2) . '/' . substr($data['laudo']['0']->data, 5, 2) . '/' . substr($data['laudo']['0']->data, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaolaudo_1', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

/////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 6) {//CLINICA DEZ    
            if ($arquivo_existe) {
                $src = base_url() . "upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . '.jpg';
            } else {
                $src = 'img/cabecalho.jpg';
            }
            $filename = "laudo.pdf";
            $cabecalho = "<table><tr><td><img align = 'left'  src='{$src}'></td></tr><tr><td>&nbsp;</td></tr><tr><td>Paciente:" . $data['laudo']['0']->paciente . "<br>Data: " . substr($data['laudo']['0']->data, 8, 2) . '/' . substr($data['laudo']['0']->data, 5, 2) . '/' . substr($data['laudo']['0']->data, 0, 4) . "</td></tr></table>";
            $rodape = "<table><tr><td><center><img align = 'left' src='img/rodape.jpg'></center></td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }

/////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 8) {//RONALDO BARREIRA
            $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 10pt;'>
                    <tr><td style='vertical-align: bottom; font-family: serif; font-size: 14pt;' colspan='2'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td></tr>
                    <tr><td colspan='2'><center>Rua 24 de maio, 961 - Fone: 3226-9536<center></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                    <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                    <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                    <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . $data['laudo']['0']->solicitante . "<br></td></tr>
                    </table>";
            if ($data['laudo']['0']->convenio_id >= 29 && $data['laudo']['0']->convenio_id <= 84) {
                $cabecalho = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 9pt;'>
                    <tr><td width='70%' style='vertical-align: bottom; font-family: serif; font-size: 12pt;'><center><u>Clinica Radiol&oacute;gica Dr. Ronaldo Barreira</u><center></td><td rowspan='2'><center><img align = 'left'  width='140px' height='40px' src='img/sesi.jpg'><center></td></tr>
                    <tr><td ><center>Rua 24 de maio, 961-Fone: 3226-9536<center></td><td></td></tr>            
                    <tr><td colspan='2'>Exame de:" . $data['laudo']['0']->paciente . "</td></tr>
                    <tr><td>Nascimento: " . substr($data['laudo']['0']->nascimento, 8, 2) . '/' . substr($data['laudo']['0']->nascimento, 5, 2) . '/' . substr($data['laudo']['0']->nascimento, 0, 4) . "</td><td>Idade: " . $teste . "</td></tr>
                    <tr><td>Atendimento:" . $data['laudo']['0']->guia_id . "</td><td>Data: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr>
                    <tr><td>Convenio: " . $data['laudo']['0']->convenio . "<td>Solicitante: " . substr($data['laudo']['0']->solicitante, 0, 15) . "<br></td></tr>
                    </table>";
            }
            $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                    <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            if ($data['laudo']['0']->medico_parecer1 == 929) {
                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td><center>Dr." . $data['laudo']['0']->medico . "</td></tr>
                    <tr><td><center>Radiologista - Leitor Qualificado Padrao OIT</td></tr>
                    <tr><td><center>CRM" . $data['laudo']['0']->conselho . "</td></tr></table>";
            }
            $grupo = $data['laudo']['0']->grupo;
            $html = $this->load->view('ambulatorio/impressaolaudo_2', $data, true);
            pdf($html, $filename, $cabecalho, $rodape, $grupo);
        } else { //GERAL        //este item fica sempre por útimo
            if ($arquivo_existe) {
                $src = base_url() . "upload/operadorLOGO/" . $data['laudo'][0]->medico_parecer1 . '.jpg';
            } else {
                $src = 'img/cabecalho.jpg';
            }
            $filename = "laudo.pdf";
            $cabecalho = "<table ><tr><td><img align = 'left'  width='1000px' height='300px' src='{$src}'></td></tr><tr><td><center><b>ATESTADO MÉDICO</b></center><br/><br/><br/></td></tr><tr><td><b>Para:" . $data['laudo']['0']->paciente . "<br></b></td></tr></table>";
            $rodape = "<table><tr><td>$texto_rodape</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  >$carimbo</td></tr></table><table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'></td></tr></table>";
            $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
            pdf($html, $filename, $cabecalho, $rodape);
//            $this->load->View('ambulatorio/impressaoreceituario', $data);
        }
    }

    function impressaoreceitaespecial($ambulatorio_laudo_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->laudo->listarreceitaespecialimpressao($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['empresa'] = $this->guia->listarempresamunicipio();
        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo'][0]->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');

        if ($data['laudo'][0]->assinatura == 't') {
            $data['operador_assinatura'] = $data['laudo'][0]->medico_parecer1;
        }

        $this->load->helper('directory');
        $arquivos = directory_map("./upload/operadorLOGO/");
        $data['arquivo_existe'] = false;
//        var_dump($arquivos); die;
//        var_dump($arquivos);die;
        if (@$arquivos != false) {
            foreach (@$arquivos as $value) {
                if (@$value == @$data['laudo'][0]->medico_parecer1 . ".jpg") {
                    @$data['arquivo_existe'] = true;
                    @$data['medico_parecer1'] = @$data['laudo'][0]->medico_parecer1;
                    break;
                }
            }
        }

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
        $sort = $this->laudo->listarnomeimagem($exame_id);

        $sort_array = array();
        for ($i = 0; $i < count($sort); $i++) {
            if (substr($sort[$i]->nome, 0, 7) == 'Foto 10') {
                $c = $i;
                continue;
            }
            $sort_array[] = $sort[$i]->nome;
        }
        if (isset($c)) {
            $sort_array[] = $sort[$c]->nome;
        }

        $data['nomeimagem'] = $sort_array;


        $data['empresa'] = $this->guia->listarempresa();

        $data['laudo'] = $this->laudo->listarlaudo($ambulatorio_laudo_id);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['impressaolaudo'] = $this->guia->listarconfiguracaoimpressaolaudo($empresa_id);
        $cabecalho_config = $data['cabecalho'][0]->cabecalho;
        $rodape_config = $data['cabecalho'][0]->rodape;
        $verificador = $data['laudo']['0']->imagens;
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
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
//        var_dump($data['empresa'][0]->impressao_tipo); die;

        if ($data['empresa'][0]->laudo_config == 't') {
            if ($data['impressaolaudo'][0]->cabecalho == 't') {
                if ($data['empresa'][0]->cabecalho_config == 't') {
                    $cabecalho = "$cabecalho_config . <table><tr><td></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame:" . $data['laudo']['0']->procedimento . "</td></tr></table>";
                } else {
                    $cabecalho = "<table><tr><td></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame:" . $data['laudo']['0']->procedimento . "</td></tr></table>";
                }
            }
            $filename = "laudo.pdf";

            if ($data['empresa'][0]->rodape_config == 't') {
                $rodape = "$rodape_config";
            } else {
                $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
            }
        } else {

            if ($data['empresa'][0]->impressao_tipo == 1) {//humana
                $filename = "laudo.pdf";
                $cabecalho = "<table><tr><td></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame:" . $data['laudo']['0']->procedimento . "</td></tr></table>";
                $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodapehumana.jpg'>";

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
            }

/////////////////////////////////////////////////////////////////////////////////        
            elseif ($data['empresa'][0]->impressao_tipo == 13) {//CAGE
                $filename = "laudo.pdf";
                if ($data['laudo']['0']->sexo == "F") {
                    $SEXO = 'FEMININO';
                } else {
                    $SEXO = 'MASCULINO';
                }
                $filename = "laudo.pdf";
                $cabecalho = "<table>
        
                                                                                                                                                                                                        <tr>
        </td><td width='430px'>Nome.:" . $data['laudo']['0']->paciente . "</td><td></td>
        </tr>
        <tr>
          </td><td >Sexo:" . $SEXO . " Idade:" . substr($teste, 0, 2) . "</td><td></td>
        </tr>
        
                                                                                                                                                                                                        </table>";
                $rodape = "";
                $html = $this->load->view('ambulatorio/impressaoimagem6cage', $data, true);
            }

////////////////////////////////////////////////////////////////////////////////        
            elseif ($data['empresa'][0]->impressao_tipo == 16) {//GASTROSUL
                $filename = "laudo.pdf";
                if ($data['laudo']['0']->sexo == "F") {
                    $SEXO = 'FEMININO';
                } else {
                    $SEXO = 'MASCULINO';
                }
                $filename = "laudo.pdf";
                $cabecalho = "<table>
            
                                                                                                                                                                                                        <tr>
            </td><td width='100px'></td><td width='430px'>Nome.:" . $data['laudo']['0']->paciente . "</td><td></td>
            </tr>
            <tr>
              </td><td width='100px'></td><td >Sexo:" . $SEXO . " Idade:" . substr($teste, 0, 2) . "</td><td></td>
            </tr>
            
                                                                                                                                                                                                        </table>";
                $rodape = "";
//                var_dump($html); die;
                $html = $this->load->view('ambulatorio/impressaoimagem6gastrosul', $data, true);
            }

////////////////////////////////////////////////////////////////////////////////        
            elseif ($data['empresa'][0]->impressao_tipo == 10) {//CDC      
                $filename = "laudo.pdf";
                $cabecalho = "<table><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame:" . $data['laudo']['0']->procedimento . "</td></tr></table>";
                $rodape = "<table><tr><td>Rua Juiz Renato Silva, 20 - Papicu | Fone (85)3234-3907</td></tr></table>";
            }

////////////////////////////////////////////////////////////////////////////////        
            elseif ($data['empresa'][0]->impressao_tipo == 11) {//clinica MAIS      
                $filename = "laudo.pdf";
                $cabecalho = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame: Dr(a). " . $data['laudo']['0']->procedimento . "</td></tr></table>";
                $rodape = "<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table>";
            }

////////////////////////////////////////////////////////////////////////////////        
            else {//GERAL  // este item deve ficar sempre por último
                $filename = "laudo.pdf";
                $cabecalho = "<table><tr><td></td><td>Nome:" . $data['laudo']['0']->paciente . "<br>Exame:" . $data['laudo']['0']->procedimento . "</td></tr></table>";
                $rodape = "<img align = 'left'  width='1000px' height='100px' src='img/rodape.jpg'>";
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
            }
        }


        $grupo = $data['laudo']['0']->grupo;

        pdf($html, $filename, $cabecalho, $rodape, $grupo);

//                pdf($html, $filename, $cabecalho, $rodape);
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
        $origem = "./upload/laudo";

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

                    $nome = "./upload/laudo/" . $convenio . "/" . $item->paciente_id . "/" . $sl_cod_doc . ".xml";
                    $xml = $cabecalho . $corpo . $fim_numguia . $rodape;
                    $fp = fopen($nome, "w+");
                    fwrite($fp, $xml . "\n");
                    fclose($fp);

                    $nomepdf = "./upload/laudo/" . $convenio . "/" . $item->paciente_id . "/" . $sl_cod_doc . ".pdf";
                    $cabecalhopdf = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $item->paciente . " <br>Emiss&atilde;o: </td></tr></table>";
                    $rodapepdf = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
                    salvapdf($texto, $nomepdf, $cabecalhopdf, $rodapepdf);


                    $zip = new ZipArchive;
                    $this->load->helper('directory');
                    $arquivo_pasta = directory_map("./upload/laudo/$convenio/$item->paciente_id/");
                    $pasta = $item->paciente_id;
                    if ($arquivo_pasta != false) {
                        foreach ($arquivo_pasta as $value) {
                            $zip->open("./upload/laudo/$convenio/$pasta/$sl_cod_doc.zip", ZipArchive::CREATE);
                            $zip->addFile("./upload/laudo/$convenio/$pasta/$value", "$sl_cod_doc.xml");
                            $zip->addFile("./upload/laudo/$convenio/$pasta/$value", "$sl_cod_doc.pdf");
                            $zip->close();
                        }
                        $arquivoxml = "./upload/laudo/$convenio/$pasta/$sl_cod_doc.xml";
                        $arquivopdf = "./upload/laudo/$convenio/$pasta/$sl_cod_doc.pdf";
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

                if (!is_dir($origem . '/' . $convenio)) {
                    mkdir($origem . '/' . $convenio);
                    chmod($origem . '/' . $convenio, 0777);
                }

                $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
                            <NAJA>
                                <NJ_CodPaciente>" . $item->paciente_id . "</NJ_CodPaciente>
                                <NJ_NomePaciente>" . $item->paciente . "</NJ_NomePaciente>
                                <NJ_Laudo>" . $item->ambulatorio_laudo_id . "</NJ_Laudo>
                                <NJ_LocalLaudo>./upload/laudo/" . $convenio . "</NJ_LocalLaudo>
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

                $nome = "./upload/laudo/" . $convenio . "/" . $item->paciente_id . ".xml";
                $xml = $cabecalho . $corpo . $rodape;
                $fp = fopen($nome, "w+");
                fwrite($fp, $xml . "\n");
                fclose($fp);

                $nome = "./upload/laudo/" . $convenio . "/" . $item->paciente_id . ".rtf";
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

        if (count($listarexame) > 0) {
            $empresa = $this->exame->listarcnpj();

            $convenio = $listarexame[0]->convenio;

            $origem = "./upload/laudo";

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

//                    if ($_POST['apagar'] == 1) {
//                        delete_files($origem . '/' . $convenio . '/' . $item->paciente_id);
//                    }

                    if ($item->paciente_id !== $paciente_dif) {
                        $sl_cod_doc = $item->ambulatorio_laudo_id;
                        $texto = "";
                        if (!is_dir($origem . '/' . $convenio)) {
                            mkdir($origem . '/' . $convenio);
                            chmod($origem . '/' . $convenio, 0777);
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

                        $nome = "./upload/laudo/" . $convenio . "/" . $sl_cod_doc . ".xml";
                        $xml = $cabecalho . $corpo . $fim_numguia . $rodape;
                        $fp = fopen($nome, "w+");
                        fwrite($fp, $xml . "\n");
                        fclose($fp);

                        $nomepdf = "./upload/laudo/" . $convenio . "/" . $sl_cod_doc . ".pdf";
                        $cabecalhopdf = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $item->paciente . " <br>Emiss&atilde;o: </td></tr></table>";
                        $rodapepdf = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
                        salvapdf($texto, $nomepdf, $cabecalhopdf, $rodapepdf);


                        $zip = new ZipArchive;
                        $this->load->helper('directory');
                        $arquivo_pasta = directory_map("./upload/laudo/$convenio/");
                        $pasta = $item->paciente_id;
                        if ($arquivo_pasta != false) {
                            foreach ($arquivo_pasta as $value) {
                                $zip->open("./upload/laudo/$convenio/$sl_cod_doc.zip", ZipArchive::CREATE);
                                $zip->addFile("./upload/laudo/$convenio/$value", "$sl_cod_doc.xml");
                                $zip->addFile("./upload/laudo/$convenio/$value", "$sl_cod_doc.pdf");
                                $zip->close();
                            }
                            $arquivoxml = "./upload/laudo/$convenio/$sl_cod_doc.xml";
                            $arquivopdf = "./upload/laudo/$convenio/$sl_cod_doc.pdf";
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
                                <NJ_LocalLaudo>./upload/laudo" . $convenio . "/" . $listarexame[0]->paciente_id . "</NJ_LocalLaudo>
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

                $nome = "./upload/laudo/" . $convenio . "/" . $listarexame[0]->paciente_id . "/" . $listarexame[0]->paciente_id . ".xml";
                $xml = $cabecalho . $corpo . $rodape;
                $fp = fopen($nome, "w+");
                fwrite($fp, $xml . "\n");
                fclose($fp);

                $nome = "./upload/laudo/" . $convenio . "/" . $listarexame[0]->paciente_id . "/" . $listarexame[0]->paciente_id . ".rtf";
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
    }

    function carregarrevisao($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id, $messagem = null) {
        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
        $data['lista'] = $this->exametemp->listarautocompletemodelos();
        $data['laudos_anteriores'] = $this->laudo->listarlaudos($paciente_id, $ambulatorio_laudo_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
        $this->load->helper('directory');
        $data['mensagem'] = $messagem;
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
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

    function imagenspacs($accession_number) {
//        $verifica = $this->empresa->listarpacs();

        $pacs = $this->empresa->listarpacs();
        if (count($pacs) > 0) {

//        var_dump($agenda_exames_id);
//        die;
// $AN- variavel, com o accession number( numero do exame), obtida do sistema gestor da clinica;
            $AN = $accession_number;
            $ipPACS_LAN = $pacs[0]->ip_local; //Ip atribuido ao PACS, na LAN do cliente;
            $IPpublico = $pacs[0]->ip_externo; // IP, OU URL( dyndns, no-ip, etc) PARA ACESSO EXTERNO AO PACS;
//login que depende da clinica;
            $login = $pacs[0]->login;
            $password = $pacs[0]->senha;

// url de requisicao(GET),composta pelo IP publico da clinica  ou dns dinamico , considerando, que o seu webserver vai estar fora da clinica, se ele estiver na clinica, aqui deve ser substituido por $ipPACS_LAN ;

            $url = "http://{$IPpublico}/createlink?AccessionNumber={$AN}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $resultado = curl_exec($ch);
            curl_close($ch);
// A variavel $resultado, comtem o link, com o IP da rede local do pacs, que deve ser substituido pelo 
// endereco de acesso externo;
//$linkImagem, variável com o link a ser exportado para o site, para o cliente acessar as imagens;

            $linkImagem = str_replace("$ipPACS_LAN", "$IPpublico", "$resultado");

            echo $url, '<br>';
            echo $resultado, '<br>';
            echo $linkImagem, '<br>';


//        if ($verifica == 0) {
//            $ambulatorio_laudooit_id = $this->laudooit->inserirlaudo($ambulatorio_laudo_id);
//            $obj_laudo = new laudooit_model($ambulatorio_laudooit_id);
//        } 
        } else {
            echo '<script>window.close();</script>';
        }
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
//            var_dump($validar); die;

            if ($validar == '1') {
                $gravar = $this->laudo->gravarlaudo($ambulatorio_laudo_id, $exame_id, $sala_id, $procedimento_tuss_id);
                if ($gravar == 0) {
                    $this->gerarxmlsalvar($ambulatorio_laudo_id, $exame_id, $sala_id);
                }
                $messagem = 2;

                $email_paciente = $this->laudo->email($paciente_id);
                if ((isset($email_paciente)) && $email_paciente !== "") {
                    $this->email($_POST['laudo'], $email_paciente);
                }
            } else {
                $this->laudo->gravarlaudodigitando($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id);
                $messagem = 1;
            }
        } else {
            $this->laudo->gravarlaudodigitando($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id);
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

    function gravaranamineseodontologia($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id) {

        $this->laudo->gravaranamineseodontologia($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id);

        $servicoemail = $this->session->userdata('servicoemail');
        if ($servicoemail == 't') {

            $dados = $this->laudo->listardadoservicoemail($ambulatorio_laudo_id, $exame_id);
            if ($dados['enviado'] != 't') {
                $this->load->library('My_phpmailer');
                $mail = new PHPMailer(true);

                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'ssl://smtp.gmail.com';
                $config['smtp_port'] = '465';
                $config['smtp_user'] = 'stgsaude@gmail.com';
                $config['smtp_pass'] = 'saude123';
                $config['validate'] = TRUE;
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';
                $config['newline'] = "\r\n";

                $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
                $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
                $mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
                $mail->isSMTP();                                      // Configura o disparo como SMTP
                $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
                $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
                $mail->Username = 'stgsaude@gmail.com';                    // Usuário do SMTP
                $mail->Password = 'saude123';                   // Senha do SMTP
                $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
                $mail->Port = 465;                                    // Porta TCP para a conexão
                $mail->From = $dados['empresaEmail'];             // Endereço previamente verificado no painel do SMTP
                $mail->FromName = $dados['razaoSocial'];                        // Nome no remetente
                $mail->addAddress($dados['pacienteEmail']);                            // Acrescente um destinatário
                $mail->isHTML(true);                                  // Configura o formato do email como HTML
                $mail->Subject = $dados['razaoSocial'] . " agradece sua presença.";
                $mail->Body = $dados['mensagem'];

                //                $mail->AddAttachment("./upload/nfe/$solicitacao_cliente_id/validada/" . $notafiscal[0]->chave_nfe . '-danfe.pdf', $notafiscal[0]->chave_nfe . '-danfe.pdf');

                if (!$mail->Send()) {
                    $mensagem = "Erro: " . $mail->ErrorInfo;
                } else {
                    $mensagem = "Email enviado com sucesso!";
                }

                $this->laudo->setaemailparaenviado($ambulatorio_laudo_id);
            }
        }

        $data['exame_id'] = $exame_id;
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $data['paciente_id'] = $paciente_id;
        $data['procedimento_tuss_id'] = $procedimento_tuss_id;

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravaranaminese($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id) {

        $this->laudo->gravaranaminese($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id);

        $servicoemail = $this->session->userdata('servicoemail');
        if ($servicoemail == 't') {

            $dados = $this->laudo->listardadoservicoemail($ambulatorio_laudo_id, $exame_id);
            if ($dados['enviado'] != 't') {
                $this->load->library('My_phpmailer');
                $mail = new PHPMailer(true);

                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'ssl://smtp.gmail.com';
                $config['smtp_port'] = '465';
                $config['smtp_user'] = 'stgsaude@gmail.com';
                $config['smtp_pass'] = 'saude123';
                $config['validate'] = TRUE;
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';
                $config['newline'] = "\r\n";

                $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
                $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
                $mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
                $mail->isSMTP();                                      // Configura o disparo como SMTP
                $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
                $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
                $mail->Username = 'stgsaude@gmail.com';                    // Usuário do SMTP
                $mail->Password = 'saude123';                   // Senha do SMTP
                $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
                $mail->Port = 465;                                    // Porta TCP para a conexão
                $mail->From = $dados['empresaEmail'];             // Endereço previamente verificado no painel do SMTP
                $mail->FromName = $dados['razaoSocial'];                        // Nome no remetente
                $mail->addAddress($dados['pacienteEmail']);                            // Acrescente um destinatário
                $mail->isHTML(true);                                  // Configura o formato do email como HTML
                $mail->Subject = $dados['razaoSocial'] . " agradece sua presença.";
                $mail->Body = $dados['mensagem'];

                //                $mail->AddAttachment("./upload/nfe/$solicitacao_cliente_id/validada/" . $notafiscal[0]->chave_nfe . '-danfe.pdf', $notafiscal[0]->chave_nfe . '-danfe.pdf');

                if (!$mail->Send()) {
                    $mensagem = "Erro: " . $mail->ErrorInfo;
                } else {
                    $mensagem = "Email enviado com sucesso!";
                }

                $this->laudo->setaemailparaenviado($ambulatorio_laudo_id);
            }
        }

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

        for ($i = 0; $i < count($_FILES['arquivos']['name']); $i++) {
            $_FILES['userfile']['name'] = $_FILES['arquivos']['name'][$i];
            $_FILES['userfile']['type'] = $_FILES['arquivos']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $_FILES['arquivos']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $_FILES['arquivos']['error'][$i];
            $_FILES['userfile']['size'] = $_FILES['arquivos']['size'][$i];

            if (!is_dir("./upload/consulta/$ambulatorio_laudo_id")) {
                mkdir("./upload/consulta/$ambulatorio_laudo_id");
                $destino = "./upload/consulta/$ambulatorio_laudo_id";
                chmod($destino, 0777);
            }

            //        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
            $config['upload_path'] = "./upload/consulta/" . $ambulatorio_laudo_id . "/";
            $config['allowed_types'] = 'gif|jpg|BMP|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar|xml|txt';
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
        }
//        var_dump($error); die;


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

    function excluirimagemlaudo($ambulatorio_laudo_id, $nome) {

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
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
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
                $this->laudo->gravarlaudo($ambulatorio_laudo_id, $exame_id, $paciente_id, $procedimento_tuss_id);
                $messagem = 2;
            } else {
                $this->laudo->gravarlaudodigitando($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id);
                $messagem = 1;
            }
        } else {
            $this->laudo->gravarlaudodigitando($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id);
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

    private
            function carregarView($data = null, $view = null) {
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
