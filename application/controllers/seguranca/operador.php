<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class Operador extends BaseController {

    function Operador() {
        parent::Controller();
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/tipo_model', 'tipo');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('cadastro/classe_model', 'classe');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {

        if ($this->utilitario->autorizar(1, $this->session->userdata('modulo')) == true) {
            $this->pesquisar();
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    function novo() {
        $data['credor_devedor'] = $this->convenio->listarcredordevedor();
        $data['conta'] = $this->forma->listarforma();
        $data['tipo'] = $this->tipo->listartipo();
        $data['classe'] = $this->classe->listarclasse();
        $data['listarPerfil'] = $this->operador_m->listarPerfil();
//        $data['listarempresas'] = $this->operador_m->listarempresas();
        $this->loadView('seguranca/operador-form', $data);
    }

    function associarempresas($operador_id) {
        $data['operador'] = $this->operador_m->listarCada($operador_id);
        $data['empresa'] = $this->operador_m->listarempresas();
        $data['empresas'] = $this->operador_m->listarempresasoperador($operador_id);
        $this->loadView('seguranca/operadorempresa-form', $data);
    }

    function gravarassociarempresas() {
        $this->operador_m->gravarassociarempresas();
        $operador_id = $_POST['txtoperador_id'];
        redirect(base_url() . "seguranca/operador/associarempresas/$operador_id");
    }

    function excluirassociarempresas($operador_empresa_id, $operador_id) {
        $this->operador_m->excluirassociarempresas($operador_empresa_id);
        redirect(base_url() . "seguranca/operador/associarempresas/$operador_id");
    }

    function novorecepcao() {
        $this->loadView('seguranca/operador-formrecepcao');
    }

    function alterarrecepcao($operador_id) {
        $obj_operador_id = new operador_model($operador_id);
        $data['obj'] = $obj_operador_id;
        $this->loadView('seguranca/operador-formrecepcao', $data);
    }

    function alterar($operador_id) {
        $obj_operador_id = new operador_model($operador_id);
        $data['obj'] = $obj_operador_id;
        $data['classe'] = $this->classe->listarclasse();
        $data['listarPerfil'] = $this->operador_m->listarPerfil();
        $this->loadView('seguranca/operador-form', $data);
    }

    function alteraSenha($operador_id) {
        $data['lista'] = $this->operador_m->listarCada($operador_id);

        $this->loadView('seguranca/operador-novasenha', $data);
    }

    function gravarNovaSenha() {
        $novasenha = $_POST['txtNovaSenha'];
        $confirmacao = $_POST['txtConfirmacao'];

        if ($novasenha == $confirmacao) {
            if ($this->operador_m->gravarNovaSenha()) {
                $data['mensagem'] = 'Nova senha cadastrada com sucesso.';
            } else {
                $data['mensagem'] = 'Erro ao cadastrar nova senha . Opera&ccedil;&atilde;o cancelada.';
            }
        } else {
            $data['mensagem'] = 'Confirma&ccedil;&atilde;o de nova senha diferente da nova senha . Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador", $data);
    }

    function pesquisar($limite = 50) {
        $data["limite_paginacao"] = $limite;
        $this->loadView('seguranca/operador-lista', $data);
    }

    function pesquisarmedicosolicitante($filtro = -1, $inicio = 0) {
        $this->loadView('seguranca/editarmedicosolicitante-lista');
    }

    function pesquisarrecepcao($filtro = -1, $inicio = 0) {
        $this->loadView('seguranca/operador-listarecepcao');
    }

    function operadorsetor($limite = 10) {
        $data["limite_paginacao"] = $limite;
        $this->loadView('estoque/operador-lista', $data);
    }

    function gravar() {
        if ($this->operador_m->gravar()) {
            $data['mensagem'] = 'Operador cadastrado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao cadastrar novo operador . Opera&ccedil;&atilde;o cancelada.';
        }
        $data['lista'] = $this->operador_m->listar($filtro = null, $maximo = null, $inicio = null);

//            redirect(base_url()."seguranca/operador/index/$data","refresh");
        $this->session->set_flashdata('message', $data['mensagem']);
//        header("Location: base_url() . seguranca/operador");
        redirect(base_url() . "seguranca/operador", $data);
    }

    function anexarimagem($operador_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/1ASSINATURAS/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['operador_id'] = $operador_id;
        $this->loadView('seguranca/operador_assinatura', $data);
    }

    function importarimagem() {
        $this->load->helper('directory');
        $operador_id = $_POST['operador_id'];
        $_FILES['userfile']['name'] = $operador_id . ".jpg";

        if (!is_dir("./upload/1ASSINATURAS")) {
            mkdir("./upload/1ASSINATURAS");
            $destino = "./upload/1ASSINATURAS";
            chmod($destino, 0777);
        }

        $arquivos = directory_map("./upload/1ASSINATURAS/");
        foreach ($arquivos as $value) {
            if ($value == $operador_id . ".jpg") {
                $arquivo_existe = true;
                break;
            } else {
                $arquivo_existe = false;
            }
        }

        if (!$arquivo_existe) {
            //        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
            $config['upload_path'] = "./upload/1ASSINATURAS/";
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar';
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
            $data['operador_id'] = $operador_id;
        }

        redirect(base_url() . "seguranca/operador/anexarimagem/ $operador_id");
    }

    function ecluirimagem($operador_id) {

        unlink("./upload/1ASSINATURAS/$operador_id.jpg");
        $this->anexarimagem($operador_id);
    }

    function operadorconvenio($operador_id) {

        $data['operador'] = $this->operador_m->listarCada($operador_id);
        $data['convenio'] = $this->convenio->listardados();
        $data['convenios'] = $this->operador_m->listarconveniooperador($operador_id);
        $this->loadView('seguranca/operadorconvenio-form', $data);
    }

    function operadorconvenioprocedimento($convenio_id, $operador_id) {

        $data['operador'] = $this->operador_m->listarCada($operador_id);
        $data['convenio'] = $this->operador_m->listarprocedimentoconvenio($convenio_id);
        $data['procedimentos'] = $this->operador_m->listarprocedimentoconveniooperador($operador_id);
        $this->loadView('seguranca/operadorconvenioprocedimento-form', $data);
    }

    function gravaroperadorconvenio() {
        $operador_id = $_POST['txtoperador_id'];
        $this->operador_m->gravaroperadorconvenio();
        redirect(base_url() . "seguranca/operador/operadorconvenio/$operador_id");
    }

    function gravaroperadorconvenioprocedimento() {
        $operador_id = $_POST['txtoperador_id'];
        $convenio_id = $_POST['txtconvenio_id'];
        $this->operador_m->gravaroperadorconvenioprocedimento();
        redirect(base_url() . "seguranca/operador/operadorconvenioprocedimento/$convenio_id/$operador_id");
    }

    function excluiroperadorconvenio($ambulatorio_convenio_operador_id, $operador_id) {
        $this->operador_m->excluiroperadorconvenio($ambulatorio_convenio_operador_id);
        $this->operadorconvenio($operador_id);
    }

    function excluiroperadorconvenioprocedimento($convenio_operador_procedimento_id, $convenio_id, $operador_id) {
        $this->operador_m->excluiroperadorconvenioprocedimento($convenio_operador_procedimento_id);
        $this->operadorconvenioprocedimento($convenio_id, $operador_id);
    }

    function gravarrecepcao() {
        if ($this->operador_m->gravarrecepcao()) {
            $data['mensagem'] = 'Operador cadastrado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao cadastrar novo operador . Opera&ccedil;&atilde;o cancelada.';
        }
        $data['lista'] = $this->operador_m->listar($filtro = null, $maximo = null, $inicio = null);

//            redirect(base_url()."seguranca/operador/index/$data","refresh");
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarmedicosolicitante", $data);
    }

    function excluirOperador($operador_id) {
        $this->operador_m->excluirOperador($operador_id);
        $data['mensagem'] = 'Operador excluido com sucesso.';

        $data['lista'] = $this->operador_m->listar($filtro = null, $maximo = null, $inicio = null);

//            redirect(base_url()."seguranca/operador/index/$data","refresh");
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador", $data);
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(19, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('seguranca/operador-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

}

?>
