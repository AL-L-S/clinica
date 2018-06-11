<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta fracionamento é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Fracionamento extends BaseController {

    function Fracionamento() {
        parent::Controller();
        $this->load->model('farmacia/fracionamento_model', 'fracionamento');
        $this->load->model('farmacia/cliente_model', 'cliente');
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

        $this->loadView('farmacia/fracionamento-lista', $args);

//            $this->carregarView($data);
    }

    function carregarfracionamento($farmacia_fracionamento_entrada_id) {
        $obj_fracionamento = new fracionamento_model($farmacia_fracionamento_entrada_id);
        $data['obj'] = $obj_fracionamento;
        $data['sub'] = $this->fracionamento->listararmazem();
        $data['unidade'] = $this->fracionamento->listarunidade();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('farmacia/fracionamento-form', $data);
    }

    function relatoriosaldoarmazem() {
        $data['armazem'] = $this->fracionamento->listararmazem();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatoriosaldoarmazem', $data);
    }

    function gerarelatoriosaldoarmazem() {
        $armazem = $_POST['armazem'];
        $farmacia_fornecedor_id = $_POST['txtfornecedor'];
        $farmacia_produto_id = $_POST['txtproduto'];
        if ($armazem == 0) {
            $data['armazem'] = 0;
        } else {
            $data['armazem'] = $this->fracionamento->listararmazemcada($armazem);
        }
        if ($farmacia_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->fracionamento->listarfornecedorcada($farmacia_fornecedor_id);
        }
        if ($farmacia_produto_id == '') {
            $data['produto'] = 0;
        } else {
            $data['produto'] = $this->fracionamento->listarprodutocada($farmacia_produto_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->fracionamento->relatoriosaldoarmazemcontador();
        $data['relatorio'] = $this->fracionamento->relatoriosaldoarmazem();
        $this->load->View('farmacia/impressaorelatoriosaldoarmazem', $data);
    }

    function relatoriosaldo() {
        $data['armazem'] = $this->fracionamento->listararmazem();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatoriosaldo', $data);
    }

    function gerarelatoriosaldo() {
        $armazem = $_POST['armazem'];
        $farmacia_fornecedor_id = $_POST['txtfornecedor'];
        $farmacia_produto_id = $_POST['txtproduto'];
        if ($armazem == 0) {
            $data['armazem'] = 0;
        } else {
            $data['armazem'] = $this->fracionamento->listararmazemcada($armazem);
        }
        if ($farmacia_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->fracionamento->listarfornecedorcada($farmacia_fornecedor_id);
        }
        if ($farmacia_produto_id == '') {
            $data['produto'] = 0;
        } else {
            $data['produto'] = $this->fracionamento->listarprodutocada($farmacia_produto_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->fracionamento->relatoriosaldocontador();
        $data['relatorio'] = $this->fracionamento->relatoriosaldo();
        $this->load->View('farmacia/impressaorelatoriosaldo', $data);
    }

    function relatoriominimo() {
        $data['armazem'] = $this->fracionamento->listararmazem();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatoriominimo', $data);
    }

    function gerarelatoriominimo() {
        $armazem = $_POST['armazem'];
        if ($armazem == 0) {
            $data['armazem'] = 0;
        } else {
            $data['armazem'] = $this->fracionamento->listararmazemcada($armazem);
        }
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->fracionamento->relatoriominimoarmazemcontador();
        $data['relatorio'] = $this->fracionamento->relatoriominimoarmazem();
        $this->load->View('farmacia/impressaorelatoriominimo', $data);
    }

    function relatorioprodutos() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatorioprodutos', $data);
    }

    function gerarelatorioprodutos() {
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->fracionamento->relatorioprodutocontador();
        $data['relatorio'] = $this->fracionamento->relatorioproduto();
        $this->load->View('farmacia/impressaorelatorioprodutos', $data);
    }

    function relatoriofornecedores() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatoriofornecedores', $data);
    }

    function gerarelatoriofornecedores() {
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->fracionamento->relatoriofornecedorescontador();
        $data['relatorio'] = $this->fracionamento->relatoriofornecedores();
        $this->load->View('farmacia/impressaorelatoriofornecedores', $data);
    }

    function relatoriofracionamentoarmazem() {
        $data['armazem'] = $this->fracionamento->listararmazem();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatoriofracionamentoarmazem', $data);
    }

    function gerarelatoriofracionamentoarmazem() {
        $armazem = $_POST['armazem'];
        $farmacia_fornecedor_id = $_POST['txtfornecedor'];
        $farmacia_produto_id = $_POST['txtproduto'];
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        if ($armazem == 0) {
            $data['armazem'] = 0;
        } else {
            $data['armazem'] = $this->fracionamento->listararmazemcada($armazem);
        }
        if ($farmacia_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->fracionamento->listarfornecedorcada($farmacia_fornecedor_id);
        }
        if ($farmacia_produto_id == '') {
            $data['produto'] = 0;
        } else {
            $data['produto'] = $this->fracionamento->listarprodutocada($farmacia_produto_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->fracionamento->relatoriofracionamentoarmazemcontador();
        $data['relatorio'] = $this->fracionamento->relatoriofracionamentoarmazem();
        $this->load->View('farmacia/impressaorelatoriofracionamentoarmazem', $data);
    }

    function relatoriosaidaarmazem() {
        $data['armazem'] = $this->fracionamento->listararmazem();
        $data['empresa'] = $this->guia->listarempresas();
        $data['cliente'] = $this->cliente->listarclientes();
        $this->loadView('farmacia/relatoriosaidaarmazem', $data);
    }

    function gerarelatoriosaidaarmazem() {
        $armazem = $_POST['armazem'];
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $farmacia_fornecedor_id = $_POST['txtfornecedor'];
        $farmacia_produto_id = $_POST['txtproduto'];
        if ($armazem == 0) {
            $data['armazem'] = 0;
        } else {
            $data['armazem'] = $this->fracionamento->listararmazemcada($armazem);
        }
        if ($farmacia_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->fracionamento->listarfornecedorcada($farmacia_fornecedor_id);
        }
        if ($farmacia_produto_id == '') {
            $data['produto'] = 0;
        } else {
            $data['produto'] = $this->fracionamento->listarprodutocada($farmacia_produto_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->fracionamento->relatoriosaidaarmazemcontador();
        $data['relatorio'] = $this->fracionamento->relatoriosaidaarmazem();
        $this->load->View('farmacia/impressaorelatoriosaidaarmazem', $data);
    }

    function excluir($farmacia_fracionamento_entrada_id) {
        $valida = $this->fracionamento->excluir($farmacia_fracionamento_entrada_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Fracionamento';
        } else {
            $data['mensagem'] = 'Erro ao excluir a fracionamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/fracionamento");
    }

    function gravar() {
        $exame_fracionamento_id = $this->fracionamento->gravar();
        if ($exame_fracionamento_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Fracionamento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Fracionamento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/fracionamento");
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
 
    function anexarimagemfracionamento($farmacia_fracionamento_entrada_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/fracionamentodenota/$farmacia_fracionamento_entrada_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['farmacia_fracionamento_entrada_id'] = $farmacia_fracionamento_entrada_id;
        $this->loadView('farmacia/importacao-imagemfracionamento', $data);
    }

    function importarimagemfracionamento() {
        $farmacia_fracionamento_entrada_id = $_POST['paciente_id'];
//        $data = $_FILES['userfile'];
//        var_dump($data);
//        die;
        if (!is_dir("./upload/fracionamentodenota/$farmacia_fracionamento_entrada_id")) {
            mkdir("./upload/fracionamentodenota/$farmacia_fracionamento_entrada_id");
            $destino = "./upload/fracionamentodenota/$farmacia_fracionamento_entrada_id";
            chmod($destino, 0777);
        }

//        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/fracionamentodenota/" . $farmacia_fracionamento_entrada_id . "/";
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
        $data['farmacia_fracionamento_entrada_id'] = $farmacia_fracionamento_entrada_id;
        $this->anexarimagemfracionamento($farmacia_fracionamento_entrada_id);
    }
    
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
