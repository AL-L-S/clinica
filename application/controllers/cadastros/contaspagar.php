<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta classe é o controler de Servifinanceiro_contaspagar_id. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Contaspagar extends BaseController {

    function Contaspagar() {
        parent::Controller();
        $this->load->model('cadastro/contaspagar_model', 'contaspagar');
        $this->load->model('cadastro/caixa_model', 'caixa');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('cadastro/tipo_model', 'tipo');
        $this->load->model('cadastro/classe_model', 'classe');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/contaspagar-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($financeiro_contaspagar_id) {
        $obj_contaspagar = new contaspagar_model($financeiro_contaspagar_id);
        $data['obj'] = $obj_contaspagar;
        $data['conta'] = $this->forma->listarforma();
//        $data['tipo'] = $this->tipo->listartipo();
        $data['classe'] = $this->classe->listarclasse();
        $this->loadView('cadastros/contaspagar-form', $data);
    }

    function carregarconfirmacao($financeiro_contaspagar_id) {
        $obj_contaspagar = new contaspagar_model($financeiro_contaspagar_id);
        $data['obj'] = $obj_contaspagar;
        $data['conta'] = $this->forma->listarforma();
        $data['tipo'] = $this->tipo->listartipo();
        $this->loadView('cadastros/contaspagarconfirmar-form', $data);
    }

    function relatoriocontaspagar() {
        $data['conta'] = $this->forma->listarforma();
        $data['credordevedor'] = $this->caixa->listarcredordevedor();
        $data['tipo'] = $this->tipo->listartipo();
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('cadastros/relatoriocontaspagar', $data);
    }

    function gerarelatoriocontaspagar() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['credordevedor'] = $this->caixa->buscarcredordevedor($_POST['credordevedor']);
        $data['tipo'] = $this->tipo->buscartiporelatorio($_POST['tipo']);
        $data['classe'] = $this->classe->buscarclasserelatorio($_POST['classe']);
        $data['forma'] = $this->forma->buscarforma($_POST['conta']);
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->contaspagar->relatoriocontaspagar();
        $data['contador'] = $this->contaspagar->relatoriocontaspagarcontador();
        $this->load->View('cadastros/impressaorelatoriocontaspagar', $data);
    }

    function excluir($financeiro_contaspagar_id) {
        $valida = $this->contaspagar->excluir($financeiro_contaspagar_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Contaspagar';
        } else {
            $data['mensagem'] = 'Erro ao excluir a contaspagar. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/contaspagar");
    }

    function gravar() {
        $repetir = $_POST['repitir'];
        $dia = str_replace("/", "-", $_POST['inicio']);
        if ($_POST['financeiro_contaspagar_id'] == '') {
            if ($repetir == '' || $repetir == 1) {
                $parcela = 1;
                $financeiro_contaspagar_id = $this->contaspagar->gravar($dia, $parcela);
            } elseif ($repetir >= 2) {
                $financeiro_contaspagar_id = $this->contaspagar->gravar($dia, $parcela);
                for ($index = 2; $index <= $repetir; $index++) {
                    $dia = date('d-m-Y', strtotime("+1 month", strtotime($dia)));
                    $parcela = $index;
                    $financeiro_contaspagar_id = $this->contaspagar->gravar($dia, $parcela);
                }
            }
        } else {
            $financeiro_contaspagar_id = $this->contaspagar->gravar($dia, $parcela);
        }
        if ($financeiro_contaspagar_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Contas a pagar. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Contas a pagar.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/contaspagar");
    }

    function confirmar() {
        $financeiro_contaspagar_id = $this->contaspagar->gravarconfirmacao();
        if ($financeiro_contaspagar_id == "-1") {
            $data['mensagem'] = 'Erro ao confirmar a Contas a pagar. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao confirmar a Contas a pagar.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/contaspagar");
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
                $this->load->view('giah/servifinanceiro_contaspagar_id-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

    function anexarimagemcontasapagar($financeiro_contaspagar_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/contasapagar/$financeiro_contaspagar_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['financeiro_contaspagar_id'] = $financeiro_contaspagar_id;
        $this->loadView('cadastros/importacao-imagemcontasapagar', $data);
    }

    function importarimagemcontasapagar() {
        $financeiro_contaspagar_id = $_POST['paciente_id'];
//        $data = $_FILES['userfile'];
//        var_dump($data);
//        die;
        if (!is_dir("./upload/contasapagar/$financeiro_contaspagar_id")) {
            mkdir("./upload/contasapagar/$financeiro_contaspagar_id");
            $destino = "./upload/contasapagar/$financeiro_contaspagar_id";
            chmod($destino, 0777);
        }

//        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/contasapagar/" . $financeiro_contaspagar_id . "/";
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
        $data['financeiro_contaspagar_id'] = $financeiro_contaspagar_id;
        $this->anexarimagemcontasapagar($financeiro_contaspagar_id);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
