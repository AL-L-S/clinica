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
class Convenio extends BaseController {

    function Convenio() {
        parent::Controller();
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('ambulatorio/saudeocupacional_model', 'saudeocupacional');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->model('cadastro/grupoconvenio_model', 'grupoconvenio');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/convenio-lista', $args);

//            $this->carregarView($data);
    }
    
    function pesquisarlogs($args = array()) {

        $this->loadView('cadastros/conveniolog-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($convenio_id) {
//        die('morreu');
        $obj_convenio = new convenio_model($convenio_id);
        $data['obj'] = $obj_convenio;
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('cadastros/convenio-form', $data);
    }
  
    function copiar($convenio_id) {
        $data['convenio'] = $this->convenio->listarconvenioscopiar($convenio_id);
        $data['convenio_selecionado'] = $this->convenio->listarconvenioselecionado($convenio_id);
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['convenioid'] = $convenio_id;
        $this->loadView('cadastros/copiarconvenio-form', $data);
    }

    function empresaconvenio($convenio_id) {
        $data['empresa'] = $this->empresa->listarempresasativo();
        $data['empresa_conta'] = $this->convenio->buscarconvenioempresa($convenio_id);
        $data['convenio_selecionado'] = $this->convenio->listarconvenioselecionado($convenio_id);
        $data['convenioid'] = $convenio_id;
        $this->loadView('cadastros/empresaconvenio-form', $data);
    }
    
    function setores($convenio_id) {
        
        $data['cadastro'] = $this->convenio->listarsetorselecionadotabela($convenio_id);
        $data['riscos'] = $this->saudeocupacional->listarriscofuncao();
        $data['funcao'] = $this->saudeocupacional->listarsetorfuncao();
        $data['setor'] = $this->saudeocupacional->listarsetor2();        
        $data['convenio_selecionado'] = $this->convenio->listarconvenioselecionado2($convenio_id);
        $data['convenioid'] = $convenio_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentossetores($convenio_id);
        $this->loadView('cadastros/convenio-setores', $data);
    }
    
    function listarprocedimentossetores(){
        
      $result = $this->procedimento->listarprocedimentossetores($_GET['empresa']);
      echo json_encode($result);
      
    }
    
    function excluirsetor($setor_cadastro_id, $convenio_id) {       

        
        $valida = $this->convenio->excluirsetor($setor_cadastro_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir Setor';
        } else {
            $data['mensagem'] = 'Erro ao excluir Setor. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/convenio/setores/$convenio_id");
    }
    
    function editarsetor($setor_cadastro_id, $convenio_id) {

        $data['cadastro'] = $this->convenio->setorcadastro();
        $data['riscos'] = $this->saudeocupacional->listarriscofuncao();
        $data['funcao'] = $this->saudeocupacional->listarsetorfuncao();
        $data['setor'] = $this->saudeocupacional->listarsetor2();        
        $data['convenio_selecionado'] = $this->convenio->listarconvenioselecionado2($convenio_id);
        $data['setor_selecionado'] = $this->convenio->listarsetorselecionado($setor_cadastro_id);
        $data['convenioid'] = $convenio_id;
        $data['setor_cadastro_id'] = $setor_cadastro_id;
        $this->loadView('cadastros/convenio-setores-editar', $data);
    }
    
    function ajustargrupo($convenio_id) {
        $data['convenios'] = $this->convenio->listarconveniosprimarios();
        $data['grupos'] = $this->convenio->listargrupos();
        $data['associacoes'] = $this->convenio->listarassociacoesconvenio($convenio_id);
        $data['convenio_id'] = $convenio_id;
        $this->loadView('cadastros/convenioassociacaoajustevalores-form', $data);
    }

    function ajustargrupoeditar($convenio_id) {
        $data['convenios'] = $this->convenio->listarconveniosprimarios();
        $data['grupos'] = $this->convenio->listargrupos();
        $data['associacoes'] = $this->convenio->listarassociacoesconvenio($convenio_id);
        $data['convenio_id'] = $convenio_id;
        $this->loadView('cadastros/convenioassociacaoajustevaloreseditar-form', $data);
    }

    function desconto($convenio_id) {
        $data['convenio'] = $this->convenio->listarconveniodesconto($convenio_id);
        $data['grupos'] = $this->convenio->listargrupos();
        $data['convenioid'] = $convenio_id;
        $this->loadView('cadastros/desconto-convenio', $data);
    }

    function gravarvaloresassociacao() {
        $convenio_id = $_POST['convenio_secundario_id'];
        $data['convenio'] = $this->convenio->gravarvaloresassociacaoantigo($convenio_id);
        $data['convenio'] = $this->convenio->gravarvaloresassociacao($convenio_id);
        $data['convenioid'] = $convenio_id;
        redirect(base_url() . "cadastros/convenio");
    }

    function gravarvaloresassociacaoeditar() {
        $convenio_id = $_POST['convenio_secundario_id'];
        $data['convenio'] = $this->convenio->gravarvaloresassociacaoantigo($convenio_id);
        $data['convenio'] = $this->convenio->gravarvaloresassociacaoeditar($convenio_id);
//        $data['percentual'] = $this->convenio->gravarvalorespercentuaisassociacao($convenio_id);
        $data['convenioid'] = $convenio_id;
        redirect(base_url() . "cadastros/convenio");
    }

    function gravardesconto($convenio_id) {

        $data['convenio_antigo'] = $this->convenio->gravardescontoantigo($convenio_id);
        $data['convenio'] = $this->convenio->gravardesconto($convenio_id);

        $this->convenio->gravarajusteconveniosecundario($convenio_id);

        $data['convenioid'] = $convenio_id;
        redirect(base_url() . "cadastros/convenio");
    }

    function excluir($convenio_id) {
;
        $result = $this->convenio->excluir($convenio_id);
        if ($result == "-1") {
            $mensagem = 'Erro ao excluir a Convenio. Opera&ccedil;&atilde;o cancelada.';
        } elseif ($result == "-2") {
            $mensagem = 'Erro ao excluir a Convenio. Existem outros convenios vinculados a este.';
        } else {
            $mensagem = 'Sucesso ao excluir a Convenio';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/convenio");
    }

    function gravar() {
        if($_POST['txtconvenio_id'] > 0){
             $log = $this->convenio->gravarlog();
        }
       
        $convenio_id = $this->convenio->gravar();

        if ($convenio_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar Convenio. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Convenio.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);

        if (isset($_POST['associaconvenio'])) {
            
            set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
            ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão

            if ($_POST['txtconvenio_id'] > 0) {
                $convenio_id = $_POST['txtconvenio_id'];
                $this->convenio->removerprocedimentosnaopertenceprincipal($convenio_id);
                $this->convenio->removerpercentuaisnaopertenceprincipal($convenio_id);
            }
        } else {
            $this->convenio->removeassociacoescomoutrosconvenios($convenio_id);
        }

        redirect(base_url() . "cadastros/convenio");
    }

    function gravarcopia() {
        $convenio_id = $this->convenio->gravarcopia();
        if ($convenio_id == "-1") {
            $data['mensagem'] = 'Erro ao copiar Convenio. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao copiar Convenio.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/convenio");
    }

    function gravarconvenioempresa() {
        $convenio_id = $_POST['convenio_id'];
        $teste = $this->convenio->gravarconvenioempresa();
        if (!$teste) {
            $data['mensagem'] = 'Erro ao gravar empresa. Empresa já cadastrada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar empresa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/convenio/empresaconvenio/$convenio_id");
    }
    
    function gravarsetorempresa() {
        $convenio_id = $_POST['txtconvenioid'];
//        var_dump($convenio_id);die;
        $setor_id = $this->convenio->gravarsetorempresa();
        if ($setor_id == 'banana') {
//            $data['mensagem'] = 'Erro ao gravar setor. Setor já cadastrado.';
        } else {
//            $data['mensagem'] = 'Sucesso ao gravar setor.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/convenio/setores/$convenio_id");
    }
    
    function editarsetorempresa($setor_cadastro_id, $convenio_id) {
        
        $valida = $this->convenio->editarsetorempresa($setor_cadastro_id);
//        var_dump($_POST); die;
        if (!$valida == 0) {
//            $data['mensagem'] = 'Sucesso ao excluir Setor';
        } else {
//            $data['mensagem'] = 'Erro ao excluir Setor. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
//        var_dump($convenio_id);die;
        redirect(base_url() . "cadastros/convenio/setores/$convenio_id");
    }
    
    function excluirconvenioempresa($convenio_empresa_id,$convenio_id) {
        $teste = $this->convenio->excluirconvenioempresa($convenio_empresa_id);
        if (!$teste) {
            $data['mensagem'] = 'Erro ao excluir empresa.';
        } else {
            $data['mensagem'] = 'Sucesso ao excluir empresa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/convenio/empresaconvenio/$convenio_id");
    }

    function anexararquivoconvenio($convenios_id) {
        if (!is_dir("./upload/convenios")) {
            mkdir("./upload/convenios");
            chmod("./upload/convenios", 0777);
        }
        if (!is_dir("./upload/convenios/$convenios_id")) {
            mkdir("./upload/convenios/$convenios_id");
            chmod("./upload/convenios/$convenios_id", 0777);
        }

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/convenios/$convenios_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['convenios_id'] = $convenios_id;
        $this->loadView('cadastros/importacao-imagemconvenio', $data);
    }

    function importararquivoconvenio() {
        $convenios_id = $_POST['paciente_id'];
        $data = $_FILES['userfile'];
        $nome = $_FILES['userfile']['name'];
        $arquivo = "upload/convenios/$convenios_id/$nome";
//        var_dump($arquivo); die;
//        $arquivonovo = "./upload/1ASSINATURAS/$convenios_id.jpg";
        $this->convenio->gravarcaminhologo($convenios_id, $arquivo);
//        var_dump($data);
//        die;
        if (!is_dir("./upload/convenios")) {
            mkdir("./upload/convenios");
            chmod("./upload/convenios", 0777);
        }

        if (!is_dir("./upload/entrada/$convenios_id")) {
            mkdir("./upload/entrada/$convenios_id");
            $destino = "./upload/entrada/$convenios_id";
            chmod($destino, 0777);
        }

//        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/convenios/" . $convenios_id . "/";
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

        $data['convenios_id'] = $convenios_id;
        redirect(base_url() . "cadastros/convenio/anexararquivoconvenio/$convenios_id");
    }

    function excluirlogoconvenio($convenios_id, $value) {
        unlink("./upload/convenios/$convenios_id/$value");
        redirect(base_url() . "cadastros/convenio/anexararquivoconvenio/$convenios_id");
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
