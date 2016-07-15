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
class Caixa extends BaseController {

    function Caixa() {
        parent::Controller();
        $this->load->model('cadastro/caixa_model', 'caixa');
        $this->load->model('cadastro/tipo_model', 'tipo');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('seguranca/operador_model', 'operador');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/entrada-lista', $args);
    }

    function pesquisar2($args = array()) {

        $this->loadView('cadastros/saida-lista', $args);
    }

    function pesquisar3($args = array()) {

        $this->loadView('cadastros/sangria-lista', $args);
    }

    function carregar($saidas_id) {
        $obj_saidas = new caixa_model($saidas_id);
        $data['obj'] = $obj_saidas;
        $data['conta'] = $this->forma->listarforma();
        $data['tipo'] = $this->tipo->listartipo();
        $this->loadView('cadastros/saida-form', $data);
    }

    function novaentrada() {
        $data['tipo'] = $this->tipo->listartipo();
        $data['conta'] = $this->forma->listarforma();
        $this->loadView('cadastros/entrada-form', $data);
    }

    function novasaida() {
        $data['tipo'] = $this->tipo->listartipo();
        $data['conta'] = $this->forma->listarforma();
        $this->loadView('cadastros/saida-form', $data);
    }

    function transferencia() {
        $data['conta'] = $this->forma->listarforma();
        $this->loadView('cadastros/transferencia-form', $data);
    }

    function novasangria() {
        $data['operador'] = $this->operador->listaradminitradores();
        $data['operadorcaixa'] = $this->operador->listartecnicos();
        $data['conta'] = $this->forma->listarforma();
        $this->loadView('cadastros/sangria-form', $data);
    }

    function cancelarsangria($sangria_id) {
        $data['sangria'] = $this->caixa->listarcancelarsangria($sangria_id);
        $this->loadView('cadastros/cancelarsangria-form', $data);
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

    function gravarentrada() {
        $caixa_id = $this->caixa->gravarentrada();
        if ($caixa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar entrada. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a entrada.';
        }
        redirect(base_url() . "cadastros/caixa", $data);
    }

    function gravarsaida() {
        $caixa_id = $this->caixa->gravarsaida();
        if ($caixa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Saida. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Saida.';
        }
        redirect(base_url() . "cadastros/caixa/pesquisar2", $data);
    }

    function gravartransferencia() {
        $caixa_id = $this->caixa->gravartransferencia();
        if ($caixa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Transferencia. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Transferencia.';
        }
        redirect(base_url() . "cadastros/caixa/pesquisar2", $data);
    }

    function gravarsangria() {
        $caixa_id = $this->caixa->gravarsangria();

        if ($caixa_id == 1) {
            $data['mensagem'] = 'Erro ao gravar a Saida. Opera&ccedil;&atilde;o cancelada.';
        } elseif ($caixa_id == 1) {
            $data['mensagem'] = 'Sucesso ao gravar a Saida.';
        } elseif ($caixa_id == 0) {
            $data['mensagem'] = 'Senha incorreta.';
        }
        redirect(base_url() . "cadastros/caixa/pesquisar3", $data);
    }

    function gravarcancelarsangria() {
        $caixa_id = $this->caixa->gravarcancelarsangria();

        if ($caixa_id == 1) {
            $data['mensagem'] = 'Erro ao gravar a Saida. Opera&ccedil;&atilde;o cancelada.';
        } elseif ($caixa_id == 1) {
            $data['mensagem'] = 'Sucesso ao gravar a Saida.';
        } elseif ($caixa_id == 0) {
            $data['mensagem'] = 'Senha incorreta.';
        }
        redirect(base_url() . "cadastros/caixa/pesquisar3", $data);
    }

    function excluirentrada($entrada) {
        $this->caixa->excluirentrada($entrada);
        redirect(base_url() . "cadastros/caixa");
    }

    function excluirsaida($saida) {
        $this->caixa->excluirsaida($saida);
        redirect(base_url() . "cadastros/caixa/pesquisar2");
    }

    function excluirsangria($saida) {
        $this->caixa->excluirsaida($saida);
        redirect(base_url() . "cadastros/caixa/pesquisar2");
    }

    function gravarprocedimentos() {
        $agenda_exames_id = $this->guia->gravarexames();
        if ($agenda_exames_id == "-1") {
            $data['mensagem'] = 'Erro ao agendar Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao agendar Exame.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/pacientes");
    }

    function novo($data) {
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['convenio'] = $this->convenio->listardados();
        $this->loadView('ambulatorio/guia-form', $data);
    }

    function relatoriosaida() {
        $data['conta'] = $this->forma->listarforma();
        $data['credordevedor'] = $this->caixa->listarcredordevedor();
        $data['tipo'] = $this->tipo->listartipo();
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriosaida', $data);
    }

    function relatorioacompanhamentodecontas() {
        $data['grupo'] = $this->guia->listargrupo();
        $this->loadView('ambulatorio/relatorioacompanhamentodecontas', $data);
    }

    function gerarelatorioacompanhamentodecontas() {
        $empresa_id = $this->session->userdata('empresa_id');
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatoriosaida'] = $this->caixa->relatoriosaidaacompanhamentodecontas();
//        echo '<pre>';
//        var_dump($data['relatoriosaida']);
//        echo '<pre>';
        $data['relatorioentrada'] = $this->caixa->relatorioentradaacompanhamentodecontas();
        $data['relatorioexamesgrupoprocedimento'] = $this->caixa->relatorioexamesgrupoprocedimentoacompanhamento();
        $this->load->View('ambulatorio/impressaorelatorioacompanhamentodecontas', $data);
    }

    function gerarelatoriosaida() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['credordevedor'] = $this->caixa->buscarcredordevedor($_POST['credordevedor']);
        $data['tipo'] = $this->tipo->buscartiporelatorio($_POST['tipo']);
        $data['forma'] = $this->forma->buscarforma($_POST['conta']);
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->caixa->relatoriosaida();
        $this->load->View('ambulatorio/impressaorelatoriosaida', $data);
    }

    function relatoriosaidagrupo() {
        $data['conta'] = $this->forma->listarforma();
        $data['credordevedor'] = $this->caixa->listarcredordevedor();
        $data['tipo'] = $this->tipo->listartipo();
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriosaidagrupo', $data);
    }

    function gerarelatoriosaidagrupo() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['credordevedor'] = $this->caixa->buscarcredordevedor($_POST['credordevedor']);
        $data['tipo'] = $this->tipo->buscartipo($_POST['tipo']);
        $data['forma'] = $this->forma->buscarforma($_POST['conta']);
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->caixa->relatoriosaidagrupo();
        $data['contador'] = $this->caixa->relatoriosaidacontador();
        $this->load->View('ambulatorio/impressaorelatoriosaidagrupo', $data);
    }

    function relatorioentrada() {
        $data['conta'] = $this->forma->listarforma();
        $data['credordevedor'] = $this->caixa->listarcredordevedor();
        $data['tipo'] = $this->tipo->listartipo();
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioentrada', $data);
    }

    function gerarelatorioentrada() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['credordevedor'] = $this->caixa->buscarcredordevedor($_POST['credordevedor']);
        $data['tipo'] = $this->tipo->buscartiporelatorio($_POST['tipo']);
        $data['forma'] = $this->forma->buscarforma($_POST['conta']);
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorioentrada'] = $this->caixa->relatorioentrada();
        $this->load->View('cadastros/impressaorelatorioentrada', $data);
    }

    function relatorioentradagrupo() {
        $data['conta'] = $this->forma->listarforma();
        $data['credordevedor'] = $this->caixa->listarcredordevedor();
        $data['tipo'] = $this->tipo->listartipo();
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('cadastros/relatorioentradagrupo', $data);
    }

    function gerarelatorioentradagrupo() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['credordevedor'] = $this->caixa->buscarcredordevedor($_POST['credordevedor']);
        $data['tipo'] = $this->tipo->buscartipo($_POST['tipo']);
        $data['forma'] = $this->forma->buscarforma($_POST['conta']);
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorioentrada'] = $this->caixa->relatorioentradagrupo();
        $data['contadorentrada'] = $this->caixa->relatorioentredacontador();
        $this->load->View('cadastros/impressaorelatorioentradagrupo', $data);
    }

    function relatoriomovitamentacao() {
        $data['conta'] = $this->forma->listarforma();
        $data['credordevedor'] = $this->caixa->listarcredordevedor();
        $data['tipo'] = $this->tipo->listartipo();
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriomovimento', $data);
    }

    function gerarelatoriomovitamentacao() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['credordevedor'] = $this->caixa->buscarcredordevedor($_POST['credordevedor']);
        $data['tipo'] = $this->tipo->buscartipo($_POST['tipo']);
        $data['forma'] = $this->forma->buscarforma($_POST['conta']);
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);

        $data['relatorio'] = $this->caixa->relatoriomovimento();
        $data['saldoantigo'] = $this->caixa->relatoriomovimentosaldoantigo();

//        echo '<pre>';
//        var_dump($data['relatorio']);
//        echo '<pre>';
//        die;
        $this->load->View('ambulatorio/impressaorelatoriomovimento', $data);
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

    function anexarimagementrada($entradas_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/entrada/$entradas_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['entradas_id'] = $entradas_id;
        $this->loadView('cadastros/importacao-imagementrada', $data);
    }

    function importarimagementrada() {
        $entradas_id = $_POST['paciente_id'];
//        $data = $_FILES['userfile'];
//        var_dump($data);
//        die;
        if (!is_dir("./upload/entrada/$entradas_id")) {
            mkdir("./upload/entrada/$entradas_id");
            $destino = "./upload/entrada/$entradas_id";
            chmod($destino, 0777);
        }

//        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/entrada/" . $entradas_id . "/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar';
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
        $data['entradas_id'] = $entradas_id;
        $this->anexarimagementrada($entradas_id);
    }

    function anexarimagemsaida($saidas_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/saida/$saidas_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['saidas_id'] = $saidas_id;
        $this->loadView('cadastros/importacao-imagemsaida', $data);
    }

    function importarimagemsaida() {
        $saidas_id = $_POST['paciente_id'];
//        $data = $_FILES['userfile'];
//        var_dump($data);
//        die;
        if (!is_dir("./upload/saida/$saidas_id")) {
            mkdir("./upload/saida/$saidas_id");
            $destino = "./upload/saida/$saidas_id";
            chmod($destino, 0777);
        }

//        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/saida/" . $saidas_id . "/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar';
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
        $data['saidas_id'] = $saidas_id;
        $this->anexarimagemsaida($saidas_id);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
