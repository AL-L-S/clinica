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
class Laboratorio extends BaseController {

    function Laboratorio() {
        parent::Controller();
        $this->load->model('cadastro/laboratorio_model', 'laboratorio');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
//        $this->load->model('cadastro/grupoconvenio_model', 'grupolaboratorio');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/laboratorio-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($laboratorio_id) {
//        die('morreu');
        $obj_laboratorio = new laboratorio_model($laboratorio_id);
        $data['obj'] = $obj_laboratorio;
        $data['laboratorio'] = $this->laboratorio->listardados();
        $this->loadView('cadastros/laboratorio-form', $data);
    }

    function copiar($laboratorio_id) {
        $data['laboratorio'] = $this->laboratorio->listarlaboratorioscopiar($laboratorio_id);
        $data['laboratorio_selecionado'] = $this->laboratorio->listarlaboratorioselecionado($laboratorio_id);
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['laboratorioid'] = $laboratorio_id;
        $this->loadView('cadastros/copiarlaboratorio-form', $data);
    }

    function ajustargrupo($laboratorio_id) {
        $data['laboratorios'] = $this->laboratorio->listardados();
        $data['grupos'] = $this->laboratorio->listargrupos();
        $data['associacoes'] = $this->laboratorio->listarassociacoeslaboratorio($laboratorio_id);
        $data['laboratorio_id'] = $laboratorio_id;
        $this->loadView('cadastros/laboratorioassociacaoajustevalores-form', $data);
    }

    function desconto($laboratorio_id) {
        $data['laboratorio'] = $this->laboratorio->listarlaboratoriodesconto($laboratorio_id);
        $data['grupos'] = $this->laboratorio->listargrupos();
        $data['laboratorioid'] = $laboratorio_id;
        $this->loadView('cadastros/desconto-laboratorio', $data);
    }

    function gravarvaloresassociacao() {
        $laboratorio_id = $_POST['laboratorio_secundario_id'];
        $data['laboratorio'] = $this->laboratorio->gravarvaloresassociacaoantigo($laboratorio_id);
        $data['laboratorio'] = $this->laboratorio->gravarvaloresassociacao($laboratorio_id);
        $data['laboratorioid'] = $laboratorio_id;
        redirect(base_url() . "cadastros/laboratorio");
    }

    function gravardesconto($laboratorio_id) {
        
        $data['laboratorio_antigo'] = $this->laboratorio->gravardescontoantigo($laboratorio_id);
        $data['laboratorio'] = $this->laboratorio->gravardesconto($laboratorio_id);
        
        $this->laboratorio->gravarajustelaboratoriosecundario($laboratorio_id);
        
        $data['laboratorioid'] = $laboratorio_id;
        redirect(base_url() . "cadastros/laboratorio");
    }

    function excluir($laboratorio_id) {
        $result = $this->laboratorio->excluir($laboratorio_id);
        if ($result == "-1") {
            $mensagem = 'Erro ao excluir o Laboratorio. Opera&ccedil;&atilde;o cancelada.';
        } elseif ($result == "-2") {
            $mensagem = 'Erro ao excluir o Laboratorio. Existem outros laboratorios vinculados a este.';
        } else {
            $mensagem = 'Sucesso ao excluir o Laboratorio';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/laboratorio");
    }

    function gravar() {
        $laboratorio_id = $this->laboratorio->gravar();
        
        if ($laboratorio_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar Laboratorio. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Laboratorio.';
        }
        
        $this->session->set_flashdata('message', $data['mensagem']);
        
        if (isset($_POST['associalaboratorio'])) {
            
//            $laboratorio_associacao = $_POST['laboratorio_associacao'];
            $laboratorio_id = $_POST['txtlaboratorio_id'];
            
            $this->laboratorio->removerprocedimentosnaopertenceprincipal($laboratorio_id);
            
            redirect(base_url() . "cadastros/laboratorio/ajustargrupo/$laboratorio_id");
        }
        else{
            redirect(base_url() . "cadastros/laboratorio");
        }
    }

    function gravarcopia() {
        $laboratorio_id = $this->laboratorio->gravarcopia();
        if ($laboratorio_id == "-1") {
            $data['mensagem'] = 'Erro ao copiar Laboratorio. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao copiar Laboratorio.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/laboratorio");
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
