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

    function pesquisarlembrete($args = array()) {
        $this->loadView('ambulatorio/lembrete-lista', $args);
    }

    function carregarlembrete($empresa_lembretes_id) {
        $data['empresa_lembretes_id'] = $empresa_lembretes_id;
        $data['operadores'] = $this->operador->listaroperadoreslembrete();
        $this->loadView('ambulatorio/lembrete-form', $data);
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
    
    function configurarcabecalho($empresa_impressao_cabecalho_id) {
        $data['empresa_impressao_cabecalho_id'] = $empresa_impressao_cabecalho_id;
        $data['impressao'] = $this->empresa->listarconfiguracaoimpressaocabecalho($empresa_impressao_cabecalho_id);
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaocabecalho-form', $data);
    }
    
    function configurarlaudo($empresa_impressao_laudo_id) {
        $data['empresa_impressao_laudo_id'] = $empresa_impressao_laudo_id;
        $data['impressao'] = $this->empresa->listarconfiguracaoimpressaolaudoform($empresa_impressao_laudo_id);
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarimpressaolaudo-form', $data);
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
    function ativarconfiguracaolaudo($impressao_id) {
        if ($this->empresa->ativarconfiguracaolaudo($impressao_id)) {
            $mensagem = 'Laudo ativado com sucesso';
        } else {
            $mensagem = 'Erro ao ativar laudo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarlaudoconfig");
    }

    function checandolembrete() {
        $data = $this->empresa->buscandolembreteoperador();
        die(json_encode($data));
    }

    function visualizalembrete() {
        $this->empresa->visualizalembrete();
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
    
    function gravarimpressaocabecalho() {
        $impressao_id = $_POST['impressao_id'];
        if ($this->empresa->gravarconfiguracaoimpressao($impressao_id)) {
            $mensagem = 'Sucesso ao gravar cabeçalho e rodapé';
        } else {
            $mensagem = 'Erro ao gravar cabeçalho e rodapé. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarcabecalho");
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

    function carregarempresa($exame_empresa_id) {
        $obj_empresa = new empresa_model($exame_empresa_id);
        $data['obj'] = $obj_empresa;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/empresa-form', $data);
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
