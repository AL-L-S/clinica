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
class Empresa extends BaseController {

    function Empresa() {
        parent::Controller();
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->model('seguranca/operador_model', 'operador');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {
        $this->loadView('ambulatorio/empresa-lista', $args);
    }

    function pesquisartotensetor($args = array()) {
        $this->loadView('ambulatorio/pesquisartotensetor-lista', $args);
    }

    function pesquisarlembrete($args = array()) {
        $this->loadView('ambulatorio/lembrete-lista', $args);
    }

    function carregarlembrete($empresa_lembretes_id) {
        $data['empresa_lembretes_id'] = $empresa_lembretes_id;
        $data['perfil'] = $this->operador->listarPerfil();
        $data['operadores'] = $this->operador->listaroperadoreslembrete();
        $this->loadView('ambulatorio/lembrete-form', $data);
    }
    
    function carregarlembreteaniversario($empresa_lembretes_aniversario_id) {
        $data['empresa_lembretes_aniversario_id'] = $empresa_lembretes_aniversario_id;
        $empresa_id = $this->session->userdata('empresa_id');
        $data['mensagem'] = $this->empresa->listarinformacaolembrete($empresa_id);
//        $data['perfil'] = $this->operador->listarPerfil();
//        $data['operadores'] = $this->operador->listaroperadoreslembrete();
        $this->loadView('ambulatorio/lembreteaniversario-form', $data);
    }

    function listarcabecalho() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaocabecalho-lista');
    }

    function listarlaudoconfig() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaolaudo-lista');
    }

    function listarinternacaoconfig() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaointernacao-lista');
    }

    function listarorcamentoconfig() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaoorcamento-lista');
    }

    function listarreciboconfig() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaorecibo-lista');
    }

    function listarencaminhamentoconfig() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarmsgencaminhamento-lista');
    }

    function configurarlogomarca($empresa_id) {

        $obj_empresa = new empresa_model($empresa_id);
        $data['obj'] = $obj_empresa;

        $this->load->helper('directory');

        if (!is_dir("./upload/logomarca")) {
            mkdir("./upload/logomarca");
            $destino = "./upload/logomarca";
            chmod($destino, 0777);
        }
        if (!is_dir("./upload/logomarca/$empresa_id")) {
            mkdir("./upload/logomarca/$empresa_id");
            $destino = "./upload/logomarca/$empresa_id";
            chmod($destino, 0777);
        }
        $data['empresa_id'] = $empresa_id;
        $data['arquivo_pasta'] = directory_map("./upload/logomarca/$empresa_id/");
//        echo "<pre>"; var_dump($data); die;
        $this->loadView('ambulatorio/configurarlogomarca-form', $data);
    }

    function gravarlogomarca() {
        $empresa_id = $_POST['empresa_id'];
        $data = $_FILES['userfile'];
        $nome = $_FILES['userfile']['name'];

        $this->empresa->gravarlogomarca();

        if (!is_dir("./upload/logomarca")) {
            mkdir("./upload/logomarca");
            $destino = "./upload/logomarca";
            chmod($destino, 0777);
        }
        if (!is_dir("./upload/logomarca/$empresa_id")) {
            mkdir("./upload/logomarca/$empresa_id");
            $destino = "./upload/logomarca/$empresa_id";
            chmod($destino, 0777);
        }

        array_map('unlink', glob("./upload/logomarca/$empresa_id/*.*"));

        $config['upload_path'] = "./upload/logomarca/$empresa_id/";
        $config['allowed_types'] = 'gif|jpg|JPG|png|jpeg|JPEG|pdf|doc|docx|xls|xlsx|ppt|zip|rar|bmp|BMP';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        $config['encrypt_name'] = FALSE;
        $config['name'] = FALSE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $data = array('upload_data' => $this->upload->data());
        }

        $arquivo = "./upload/logomarca/$empresa_id/$nome";
        $str = explode(".", $nome);
        $ext = $str[count($str) - 1];
        $arquivoNome = "./upload/logomarca/$empresa_id/logomarca.jpg";
        rename($arquivo, $arquivoNome);

        redirect(base_url() . "ambulatorio/empresa/configurarlogomarca/$empresa_id");
    }

    function excluirlogomarca($empresa_id) {

        if (!is_dir("./upload/logomarca")) {
            mkdir("./upload/logomarca");
            $destino = "./upload/logomarca";
            chmod($destino, 0777);
        }
        if (!is_dir("./upload/logomarca/$empresa_id")) {
            mkdir("./upload/logomarca/$empresa_id");
            $destino = "./upload/logomarca/$empresa_id";
            chmod($destino, 0777);
        }
        
//        echo "<pre>";
//        var_dump(unlink("./upload/logomarca/$empresa_id/logomarca")); die;
//        
        array_map('unlink', glob("./upload/logomarca/$empresa_id/*.*"));
        unlink("./upload/logomarca/$empresa_id/logomarca");
        redirect(base_url() . "ambulatorio/empresa/configurarlogomarca/$empresa_id");
    }

    function configurarcabecalho($empresa_impressao_cabecalho_id) {
        $data['empresa_impressao_cabecalho_id'] = $empresa_impressao_cabecalho_id;
        $data['impressao'] = $this->empresa->listarconfiguracaoimpressaocabecalho($empresa_impressao_cabecalho_id);
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaocabecalho-form', $data);
    }

    function anexarimagemlogo($empresa_id) {

        $this->load->helper('directory');

        if (!is_dir("./upload/logosistema")) {
            mkdir("./upload/logosistema");
            $destino = "./upload/logosistema";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/logosistema/$empresa_id")) {
            mkdir("./upload/logosistema/$empresa_id");
            $destino = "./upload/logosistema/$empresa_id";
            chmod($destino, 0777);
        }
        $data['arquivo_pasta'] = directory_map("./upload/logosistema/$empresa_id/");
//        $data['arquivo_pasta'] = directory_map("/home/hamilton/projetos/clinica/upload/$exame_id/");
        if ($data['arquivo_pasta'] != false) {
            natcasesort($data['arquivo_pasta']);
        }
//        $data['arquivos_deletados'] = directory_map("./uploadopm/$empresa_id/");
//        $data['arquivos_deletados'] = directory_map("/home/hamilton/projetos/clinica/uploadopm/$exame_id/");
        $data['empresa_id'] = $empresa_id;
//        $data['sala_id'] = $sala_id;
        $this->loadView('ambulatorio/logo_clinica', $data);
    }

    function importarimagemlogo() {
        $empresa_id = $_POST['empresa_id'];
        $data = $_FILES['userfile'];
        $nome = $_FILES['userfile']['name'];
//        var_dump($data);
//        die;
        if (!is_dir("./upload/logosistema")) {
            mkdir("./upload/logosistema");
            $destino = "./upload/logosistema";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/logosistema/$empresa_id")) {
            mkdir("./upload/logosistema/$empresa_id");
            $destino = "./upload/logosistema/$empresa_id";
            chmod($destino, 0777);
        }

        $arquivoantigo = "./upload/logosistema/$empresa_id/$nome";
        $arquivonovo = "./upload/logosistema/$empresa_id/$empresa_id.jpg";

//             var_dump($arquivo_existe); die;
        //        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/logosistema/$empresa_id/";
        $config['allowed_types'] = 'gif|jpg|JPG|png|jpeg|JPEG|pdf|doc|docx|xls|xlsx|ppt|zip|rar|bmp|BMP';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = FALSE;
        $config['name'] = FALSE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $data = array('upload_data' => $this->upload->data());
        }
        $data['empresa_id'] = $empresa_id;


        rename($arquivoantigo, $arquivonovo);

//            var_dump($error);
//            die;

        redirect(base_url() . "ambulatorio/empresa/anexarimagemlogo/$empresa_id");
//        $this->anexarimagem($empresa_id);
    }

    function configurarorcamento($empresa_impressao_orcamento_id) {
        $data['empresa_impressao_orcamento_id'] = $empresa_impressao_orcamento_id;
        $data['impressao'] = $this->empresa->listarconfiguracaoimpressaoorcamentoform($empresa_impressao_orcamento_id);
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaoorcamento-form', $data);
    }

    function configurarrecibo($empresa_impressao_recibo_id) {
        $data['empresa_impressao_recibo_id'] = $empresa_impressao_recibo_id;
        $data['impressao'] = $this->empresa->listarconfiguracaoimpressaoreciboform($empresa_impressao_recibo_id);
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaorecibo-form', $data);
    }

    function configurarencaminhamento($empresa_impressao_encaminhamento_id) {
        $data['empresa_impressao_encaminhamento_id'] = $empresa_impressao_encaminhamento_id;
        $data['impressao'] = $this->empresa->listarconfiguracaoimpressaoencaminhamentoform($empresa_impressao_encaminhamento_id);
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaoencaminhamento-form', $data);
    }

    function configurarlaudo($empresa_impressao_laudo_id) {
        $data['empresa_impressao_laudo_id'] = $empresa_impressao_laudo_id;
        $data['impressao'] = $this->empresa->listarconfiguracaoimpressaolaudoform($empresa_impressao_laudo_id);
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaolaudo-form', $data);
    }

    function configurarinternacao($empresa_impressao_internacao_id) {
        $data['empresa_impressao_internacao_id'] = $empresa_impressao_internacao_id;
        $data['impressao'] = $this->empresa->listarconfiguracaoimpressaointernacaoform($empresa_impressao_internacao_id);
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaointernacao-form', $data);
    }

    function excluirlembrete($empresa_lembretes_id) {
        if ($this->empresa->excluirlembrete($empresa_lembretes_id)) {
            $mensagem = 'Sucesso ao excluir o Lembrete';
        } else {
            $mensagem = 'Erro ao excluir o Lembrete. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/pesquisarlembrete");
    }

    function excluirconfiguracaointernacao($impressao_id) {
        if ($this->empresa->excluirconfiguracaointernacao($impressao_id)) {
            $mensagem = 'Impressão excluida com sucesso';
        } else {
            $mensagem = 'Erro ao excluir Impressão. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarinternacaoconfig");
    }

    function ativarconfiguracaolaudo($impressao_id) {
        if ($this->empresa->ativarconfiguracaolaudo($impressao_id)) {
            $mensagem = 'Laudo ativado com sucesso';
        } else {
            $mensagem = 'Erro ao ativar laudo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarlaudoconfig");
    }

    function ativarconfiguracaoorcamento($impressao_id) {
        if ($this->empresa->ativarconfiguracaoorcamento($impressao_id)) {
            $mensagem = 'Orçamento ativado com sucesso';
        } else {
            $mensagem = 'Erro ao ativar orcamento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarorcamentoconfig");
    }

    function checandolembrete() {
        $data = $this->empresa->buscandolembreteoperador();
        die(json_encode($data));
    }
    function checandolembreteaniversario() {
        $data = $this->empresa->buscandolembreteaniversariooperador();
        $visualizado = $data[0]->visualizado;

        if($data[0]->aniversario != ""){
            $aniversario = date("m-d", strtotime(str_replace('/', '-', $data[0]->aniversario)));
            $datahoje = date("m-d");
            if($aniversario == $datahoje && $visualizado == 0){
                $retorno = array($data[0]->texto, $data[0]->empresa_lembretes_aniversario_id);
            } else{
                $retorno = null;
            }
        }else{            
            $retorno = null;        
        }
        die(json_encode($retorno));
    }

    function visualizalembrete() {
        $this->empresa->visualizalembrete();
    }
    
    function visualizalembreteaniv() {
        $this->empresa->visualizalembreteaniv();
    }

    function gravarlembrete($empresa_lembretes_id) {
        if ($this->empresa->gravarlembrete($empresa_lembretes_id)) {
            $mensagem = 'Sucesso ao gravar o Lembrete';
        } else {
            $mensagem = 'Erro ao gravar o Lembrete. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/pesquisarlembrete");
    }
    
    function gravarlembreteaniversario($empresa_lembretes_aniversario_id) {
        if ($this->empresa->gravarlembreteaniversario($empresa_lembretes_aniversario_id)) {
            $mensagem = 'Sucesso ao gravar o Lembrete';
        } else {
            $mensagem = 'Erro ao gravar o Lembrete. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/pesquisarlembrete");
    }

    function gravarimpressaocabecalho() {
        $impressao_id = $_POST['impressao_id'];
        if ($this->empresa->gravarconfiguracaoimpressao($impressao_id)) {
            $mensagem = 'Sucesso ao gravar cabeçalho e rodapé';
        } else {
            $mensagem = 'Erro ao gravar cabeçalho e rodapé. Opera&ccedil;&atilde;o cancelada.';
        }
        // CRIANDO A PASTA ONDE VAI SALVAR O TIMBRADO CASO NÃO EXISTA
        if (!is_dir("./upload/timbrado")) {
            mkdir("./upload/timbrado");
            $destino = "./upload/timbrado";
            chmod($destino, 0777);
        }
        // ESSA GAMBIARRA RETIRA ALGUMAS PARTES DA STRING PARA PODER ENVIAR NA FUNÇÃO E TIRAR OS CAMPOS DO HTML QUE ATRAPALHARIAM
        if ($_POST['timbrado'] != '') {
            $arquivobase64_img = explode('src="', $_POST['timbrado']);
            $arquivobase64 = explode('alt=""', $arquivobase64_img[1]);
            $arquivobase64[1] = str_replace('/>', '', $arquivobase64[1]);
//            var_dump($arquivobase64[1]); die;
//            $arquivobase64[0] = $arquivobase64[0] . '==';
            // AQUI NESSA FUNÇÃO ELE VAI SALVAR O ARQUIVO. NO CAMINHO ENVIADO ABAIXO
            $arquivo_salvo = $this->base64_to_jpeg($arquivobase64[0], "upload/timbrado/timbrado.png");
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarcabecalho");
    }

    function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen($output_file, 'wb');

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode(',', $base64_string);

        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($data[1]));

        // clean up the file resource
        fclose($ifp);

        return $output_file;
    }

    function gravarimpressaolaudo() {
        $impressao_id = $_POST['impressao_id'];
        if ($this->empresa->gravarconfiguracaoimpressaolaudo($impressao_id)) {
            $mensagem = 'Sucesso ao gravar cabeçalho e rodapé';
        } else {
            $mensagem = 'Erro ao gravar cabeçalho e rodapé. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarlaudoconfig");
    }

    function gravarimpressaointernacao() {
        $impressao_id = $_POST['impressao_id'];
        if ($this->empresa->gravarconfiguracaoimpressaointernacao($impressao_id)) {
            $mensagem = 'Sucesso ao gravar modelo de impressão';
        } else {
            $mensagem = 'Erro ao gravar modelo de impressão. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarinternacaoconfig");
    }

    function gravarimpressaoorcamento() {
//        var_dump($_POST); die;
        $impressao_id = $_POST['impressao_id'];
        if ($this->empresa->gravarconfiguracaoimpressaoorcamento($impressao_id)) {
            $mensagem = 'Sucesso ao gravar cabeçalho e rodapé';
        } else {
            $mensagem = 'Erro ao gravar cabeçalho e rodapé. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarorcamentoconfig");
    }

    function gravarimpressaorecibo() {
//        var_dump($_POST); die;
        $impressao_id = $_POST['impressao_id'];
        if ($this->empresa->gravarconfiguracaoimpressaorecibo($impressao_id)) {
            $mensagem = 'Sucesso ao gravar cabeçalho e rodapé';
        } else {
            $mensagem = 'Erro ao gravar cabeçalho e rodapé. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarreciboconfig");
    }

    function carregarempresa($exame_empresa_id) {
        $obj_empresa = new empresa_model($exame_empresa_id);
        $data['obj'] = $obj_empresa;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/empresa-form', $data);
    }

    function carregartotensetor() {

        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->empresa->listarempresatoten($empresa_id);
        $endereco = $data['empresa'][0]->endereco_toten;
        $setor_busca = file_get_contents("$endereco/webService/telaAtendimento/setores");
        $data['setores'] = json_decode($setor_busca);
        echo '<pre>';
        var_dump($data['setores']);
        die;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/pesquisartotensetor-form', $data);
    }

    function configuraremail($empresa_id) {
        $data['empresa_id'] = $empresa_id;
        $data['mensagem'] = $this->empresa->listarinformacaoemail($empresa_id);
        $this->loadView('ambulatorio/empresaemail-form', $data);
    }

    function configurarsms($empresa_id) {
        $data['empresa_id'] = $empresa_id;
        $data['pacotes'] = $this->empresa->pacotesms();
        $data['mensagem'] = $this->empresa->listarinformacaosms($empresa_id);
        $data['numeros_indentificacao'] = $this->empresa->listarnumeroindentificacaosms();
        $this->loadView('ambulatorio/empresasms-form', $data);
    }

    function configuraracessoexterno($empresa_id) {
        $data['empresa_id'] = $empresa_id;
        $obj_empresa = new empresa_model($empresa_id);
        $data['obj'] = $obj_empresa;
        $data['pacotes'] = $this->empresa->pacotesms();
        $data['servidores'] = $this->empresa->listaripservidor();
        $this->loadView('ambulatorio/empresaacessoexterno-form', $data);
    }

    function configurarpacs($empresa_id) {
        $data['empresa_id'] = $empresa_id;
        $data['pacs'] = $this->empresa->listarpacs();
//        $data['mensagem'] = $this->empresa->listarinformacaosms();
        $this->loadView('ambulatorio/empresapacs-form', $data);
    }

    function excluir($exame_empresa_id) {
        if ($this->procedimento->excluir($exame_empresa_id)) {
            $mensagem = 'Sucesso ao excluir a Empresa';
        } else {
            $mensagem = 'Erro ao excluir a empresa. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function gravaripservidor($empresa_id) {
        if ($this->empresa->gravaripservidor($empresa_id)) {
            $mensagem = 'Sucesso ao gravar o Endereço';
        } else {
            $mensagem = 'Erro ao excluir o Endereço. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/configuraracessoexterno/$empresa_id");
    }

    function excluiripservidor($servidor_id, $empresa_id) {
        if ($this->empresa->excluiripservidor($servidor_id)) {
            $mensagem = 'Sucesso ao excluir o Endereço';
        } else {
            $mensagem = 'Erro ao excluir o Endereço. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/configuraracessoexterno/$empresa_id");
    }

    function excluirempresa($servidor_id, $empresa_id) {
        if ($this->empresa->excluirempresa($servidor_id)) {
            $mensagem = 'Sucesso ao desativar a empresa';
        } else {
            $mensagem = 'Erro ao excluir a empresa. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function gravarconfiguracaoemail() {
        $empresa_id = $this->empresa->gravarconfiguracaoemail();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao salvar configurações do serviço de Email.';
        } else {
            $data['mensagem'] = 'Configuração de Email efetuada com sucesso.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function gravarconfiguracaosms() {
        $empresa_id = $this->empresa->gravarconfiguracaosms();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao salvar configurações de SMS.';
        } else {
            $data['mensagem'] = 'Configuração de SMS efetuada com sucesso.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function gravarconfiguracaopacs() {
        $empresa_id = $this->empresa->gravarconfiguracaopacs();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao salvar configurações de PACS.';
        } else {
            $data['mensagem'] = 'Configuração de PACS efetuada com sucesso.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function gravar() {
//        var_dump($_POST['campos_obrigatorio']); die;
        $empresa_id = $this->empresa->gravar();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Empresa. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Empresa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function ativar($exame_empresa_id) {
        $this->empresa->ativar($exame_empresa_id);
        $data['mensagem'] = 'Sucesso ao ativar a Empresa.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
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
