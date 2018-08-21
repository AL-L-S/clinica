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
class Saudeocupacional extends BaseController {

    function Saudeocupacional() {
        parent::Controller();
        $this->load->model('ambulatorio/saudeocupacional_model', 'saudeocupacional');
        $this->load->model('ambulatorio/modelodeclaracao_model', 'modelodeclaracao');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('ambulatorio/sala_model', 'sala');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/laboratorio_model', 'laboratorio');
        $this->load->model('cadastro/caixa_model', 'caixa');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('ambulatorio/indicacao_model', 'indicacao');
        $this->load->model('centrocirurgico/centrocirurgico_model', 'centrocirurgico_m');
        $this->load->model('cadastro/grupoconvenio_model', 'grupoconvenio');
        $this->load->model('cadastro/grupomedico_model', 'grupomedico');
        $this->load->model('cadastro/grupoclassificacao_model', 'grupoclassificacao');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/GExtenso', 'GExtenso');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }
   

    function pesquisarsetor($args = array()) {
               
        $this->loadView('ambulatorio/setor-lista', $args);

    }
    
    function pesquisarfuncao($args = array()) {        
                
        $this->loadView('ambulatorio/funcao-lista', $args);

    }
    function pesquisarrisco($args = array()) {
                
        $this->loadView('ambulatorio/risco-lista', $args);

    }

    function carregarfuncao($aso_funcao_id) {
        
        $data['obj'] = $this->saudeocupacional->carregarfuncao($aso_funcao_id);
        $data['risco'] = $this->saudeocupacional->listarriscofuncao();
        $this->loadView('ambulatorio/funcao-empresa-form', $data);
    }
    function carregarrisco($aso_risco_id) {
        
        $data['obj'] = $this->saudeocupacional->carregarrisco($aso_risco_id);
        $data['riscos'] = $this->saudeocupacional->carregarriscoaso($aso_risco_id);
        $data['risco'] = $this->saudeocupacional->listarrisco();
        $this->loadView('ambulatorio/risco-empresa-form', $data);
    }
    
    function carregarsetor($aso_setor_id) {

        $data['obj'] = $this->saudeocupacional->carregarsetor($aso_setor_id);        
        $data['funcao'] = $this->saudeocupacional->listarsetorfuncao();
        $data['convenio'] = $this->convenio->listardados();
        $this->loadView('ambulatorio/setor-empresa-form', $data);
    }

    function excluirsetor($aso_setor_id) {
        $valida = $this->saudeocupacional->excluirsetor($aso_setor_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir Setor';
        } else {
            $data['mensagem'] = 'Erro ao excluir Setor. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/saudeocupacional/pesquisarsetor");
    }
    
    function excluirfuncao($aso_funcao_id) {
        $valida = $this->saudeocupacional->excluirfuncao($aso_funcao_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir Função';
        } else {
            $data['mensagem'] = 'Erro ao excluir Função. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/saudeocupacional/pesquisarfuncao");
    }
    function excluirrisco($aso_risco_id) {
        $valida = $this->saudeocupacional->excluirrisco($aso_risco_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir Risco';
        } else {
            $data['mensagem'] = 'Erro ao excluir Risco. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/saudeocupacional/pesquisarrisco");
    }

    function gravarsetor() {
        $aso_setor_id = $this->saudeocupacional->gravarsetor();
        if ($aso_setor_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar Setor. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Setor.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/saudeocupacional/pesquisarsetor");
    }
    function gravarfuncao() {
        $aso_funcao_id = $this->saudeocupacional->gravarfuncao();
        if ($aso_funcao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar Função. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Função.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/saudeocupacional/pesquisarfuncao");
    }
    function gravarrisco() {
        $aso_risco_id = $this->saudeocupacional->gravarrisco();
        if ($aso_risco_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar Risco. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Risco.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/saudeocupacional/pesquisarrisco");
    }
    
    
}