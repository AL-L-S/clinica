<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta entrada é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Entrada extends BaseController {

    function Entrada() {
        parent::Controller();
        $this->load->model('farmacia/entrada_model', 'entrada');
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

        $this->loadView('farmacia/entrada-lista', $args);

//            $this->carregarView($data);
    }

    function carregarentrada($farmacia_entrada_id) {
        $obj_entrada = new entrada_model($farmacia_entrada_id);
        $data['obj'] = $obj_entrada;
        $data['sub'] = $this->entrada->listararmazem();
        $data['unidade'] = $this->entrada->listarunidade();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('farmacia/entrada-form', $data);
    }

    function relatoriosaldoarmazem() {
        $data['armazem'] = $this->entrada->listararmazem();
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
            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
        }
        if ($farmacia_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->entrada->listarfornecedorcada($farmacia_fornecedor_id);
        }
        if ($farmacia_produto_id == '') {
            $data['produto'] = 0;
        } else {
            $data['produto'] = $this->entrada->listarprodutocada($farmacia_produto_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->entrada->relatoriosaldoarmazemcontador();
        $data['relatorio'] = $this->entrada->relatoriosaldoarmazem();
        $this->load->View('farmacia/impressaorelatoriosaldoarmazem', $data);
    }

    function relatoriosaldo() {
        $data['armazem'] = $this->entrada->listararmazem();
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
            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
        }
        if ($farmacia_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->entrada->listarfornecedorcada($farmacia_fornecedor_id);
        }
        if ($farmacia_produto_id == '') {
            $data['produto'] = 0;
        } else {
            $data['produto'] = $this->entrada->listarprodutocada($farmacia_produto_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->entrada->relatoriosaldocontador();
        $data['relatorio'] = $this->entrada->relatoriosaldo();
        $this->load->View('farmacia/impressaorelatoriosaldo', $data);
    }

    function relatoriominimo() {
        $data['armazem'] = $this->entrada->listararmazem();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatoriominimo', $data);
    }

    function gerarelatoriominimo() {
        $armazem = $_POST['armazem'];
        if ($armazem == 0) {
            $data['armazem'] = 0;
        } else {
            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
        }
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->entrada->relatoriominimoarmazemcontador();
        $data['relatorio'] = $this->entrada->relatoriominimoarmazem();
        $this->load->View('farmacia/impressaorelatoriominimo', $data);
    }

    function relatorioprodutos() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatorioprodutos', $data);
    }

    function gerarelatorioprodutos() {
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->entrada->relatorioprodutocontador();
        $data['relatorio'] = $this->entrada->relatorioproduto();
        $this->load->View('farmacia/impressaorelatorioprodutos', $data);
    }

    function relatoriofornecedores() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatoriofornecedores', $data);
    }

    function gerarelatoriofornecedores() {
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->entrada->relatoriofornecedorescontador();
        $data['relatorio'] = $this->entrada->relatoriofornecedores();
        $this->load->View('farmacia/impressaorelatoriofornecedores', $data);
    }

    function relatorioentradaarmazem() {
        $data['armazem'] = $this->entrada->listararmazem();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('farmacia/relatorioentradaarmazem', $data);
    }

    function gerarelatorioentradaarmazem() {
        $armazem = $_POST['armazem'];
        $farmacia_fornecedor_id = $_POST['txtfornecedor'];
        $farmacia_produto_id = $_POST['txtproduto'];
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        if ($armazem == 0) {
            $data['armazem'] = 0;
        } else {
            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
        }
        if ($farmacia_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->entrada->listarfornecedorcada($farmacia_fornecedor_id);
        }
        if ($farmacia_produto_id == '') {
            $data['produto'] = 0;
        } else {
            $data['produto'] = $this->entrada->listarprodutocada($farmacia_produto_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->entrada->relatorioentradaarmazemcontador();
        $data['relatorio'] = $this->entrada->relatorioentradaarmazem();
        $this->load->View('farmacia/impressaorelatorioentradaarmazem', $data);
    }

    function relatoriosaidaarmazem() {
        $data['armazem'] = $this->entrada->listararmazem();
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
            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
        }
        if ($farmacia_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->entrada->listarfornecedorcada($farmacia_fornecedor_id);
        }
        if ($farmacia_produto_id == '') {
            $data['produto'] = 0;
        } else {
            $data['produto'] = $this->entrada->listarprodutocada($farmacia_produto_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->entrada->relatoriosaidaarmazemcontador();
        $data['relatorio'] = $this->entrada->relatoriosaidaarmazem();
        $this->load->View('farmacia/impressaorelatoriosaidaarmazem', $data);
    }

    function excluir($farmacia_entrada_id) {
        $valida = $this->entrada->excluir($farmacia_entrada_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Entrada';
        } else {
            $data['mensagem'] = 'Erro ao excluir a entrada. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/entrada");
    }

    function gravar() {
        $exame_entrada_id = $this->entrada->gravar();
        if ($exame_entrada_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Entrada. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Entrada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/entrada");
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
 
    function anexarimagementrada($farmacia_entrada_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/entradadenota/$farmacia_entrada_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['farmacia_entrada_id'] = $farmacia_entrada_id;
        $this->loadView('farmacia/importacao-imagementrada', $data);
    }

    function importarimagementrada() {
        $farmacia_entrada_id = $_POST['paciente_id'];
//        $data = $_FILES['userfile'];
//        var_dump($data);
//        die;
        if (!is_dir("./upload/entradadenota/$farmacia_entrada_id")) {
            mkdir("./upload/entradadenota/$farmacia_entrada_id");
            $destino = "./upload/entradadenota/$farmacia_entrada_id";
            chmod($destino, 0777);
        }

//        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/entradadenota/" . $farmacia_entrada_id . "/";
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
        $data['farmacia_entrada_id'] = $farmacia_entrada_id;
        $this->anexarimagementrada($farmacia_entrada_id);
    }
    
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
