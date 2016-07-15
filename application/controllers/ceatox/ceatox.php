<?php

/**
 * Esta classe é o controller da Ficha Ceatox. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage ceatox
 */
require_once APPPATH . 'controllers/base/BaseController.php';

class Ceatox extends BaseController
{

    function Ceatox()
    {
        parent::Controller();
        $this->load->model('ceatox/ceatox_model', 'ceatox_m');
        $this->load->model('cadastro/paciente_model', 'paciente_m');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('validation');
    }

    /**
     * Função
     * @name index
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function index()
    {
        $this->pesquisar();
    }

    function novo()
    {

        $data['valor'] = $this->retornaUltimaFicha();
        $data['chave'] = 0;
        $data['chave2'] = 0;
        $data['acao'] = 0;
        $data['listaTelefonico'] = $this->ceatox_m->listarGrupoResposta(1);
        $data['listaHospitalar'] = $this->ceatox_m->listarGrupoResposta(2);
        $data['listaTipoOcorrencia'] = $this->ceatox_m->listarGrupoResposta(3);
        $data['listaCircunstancia'] = $this->ceatox_m->listarGrupoResposta(4);
        $data['listaZona'] = $this->ceatox_m->listarGrupoResposta(5);
        $data['listaLocal'] = $this->ceatox_m->listarGrupoResposta(6);
        $data['listaVia'] = $this->ceatox_m->listarGrupoResposta(7);
        $data['listaTipo'] = $this->ceatox_m->listarGrupoResposta(8);
        $data['listaAgenteToxico'] = $this->ceatox_m->listarGrupoResposta(9);
        $data['listaCentro'] = $this->ceatox_m->listarCentro();
        $data['listaTratamentoA'] = $this->ceatox_m->listarGrupoResposta(10);
        $data['listaTratamentoB'] = $this->ceatox_m->listarGrupoResposta(11);
        $data['listaTratamentoC'] = $this->ceatox_m->listarGrupoResposta(12);
        $data['listaManifClinica'] = $this->ceatox_m->listarGrupoResposta(13);
        $data['listaInternacao'] = $this->ceatox_m->listarGrupoResposta(14);
        $data['listaAnaliseToxicologica'] = $this->ceatox_m->listarGrupoResposta(15);
        $data['listaEvolucao'] = $this->ceatox_m->listarGrupoResposta(16);
        $data['listaAvaliacao'] = $this->ceatox_m->listarGrupoResposta(17);
        $this->loadView('ceatox/ceatox-ficha', $data);
    }

    function pesquisar($args = array())
    {

        $this->loadView('ceatox/ceatox-lista');
    }

    function retornaUltimaFicha()
    {

        $valor = $this->ceatox_m->retornaUltimaFicha();
        if ($valor != null) {
            return $valor + 1;
        } else {
            return 1;
        }
    }

    function excluirobservacao($ficha_id, $evolucao_id)
    {

        if ($this->ceatox_m->excluirobservacao($evolucao_id)) {
            $data['mensagem'] = 'Observa&ccedil;&atilde;o deletada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao deletar Observa&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.';
        }
        $data['ficha'] = new ceatox_model($ficha_id);
        $data['lista'] = $this->ceatox_m->listarobservacao($ficha_id);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ceatox/ceatox/pesquisarobservacao/$ficha_id", $data);
    }

    function excluirevolucao($ficha_id, $evolucao_id)
    {
        if ($this->ceatox_m->excluirevolucao($evolucao_id)) {
            $data['mensagem'] = 'Evolu&ccedil;&atilde;o deletada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao deletar Evolu&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.';
        }
        $data['ficha'] = new ceatox_model($ficha_id);
        $data['listaEvolucao'] = $this->ceatox_m->listarGrupoResposta(16);
        $data['lista'] = $this->ceatox_m->listarevolucao($ficha_id);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ceatox/ceatox/evolucao/$ficha_id", $data);
    }

    function excluirficha($ficha_id)
    {
        if ($this->ceatox_m->deletarficha($ficha_id)) {
            $data['mensagem'] = 'Ficha deletada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao deletar Ficha . Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ceatox/ceatox", $data);
    }

    function evolucao($ficha_id)
    {
        $data['ficha'] = new ceatox_model($ficha_id);
        $data['listaEvolucao'] = $this->ceatox_m->listarGrupoResposta(16);
        $data['lista'] = $this->ceatox_m->listarevolucao($ficha_id);
        $this->loadView('ceatox/ceatox-ficha-evolucao', $data);
    }

    function gravar()
    {


        if ($_POST['acao'] == 0) {
            $ficha_id = $this->ceatox_m->criaFicha();
            $paciente_id = $this->paciente_m->gravarPaciente($_POST);
            $solicitante_id = $this->ceatox_m->gravarSolicitante($_POST);
        } else {
            $ficha_id = $_POST['fichaId'];
            $paciente_id = $this->paciente_m->gravarPaciente($_POST);
            $solicitante_id = $this->ceatox_m->gravarSolicitante($_POST);
        }
        if ($this->ceatox_m->gravar($ficha_id, $paciente_id, $solicitante_id) && $this->ceatox_m->gravarAgente($ficha_id) && $this->ceatox_m->gravarTratamento($ficha_id)) {
            if ($_POST['acao'] == 0)
                $data['mensagem'] = 'Ficha de notifica&ccedil;&atilde;o cadastrada com sucesso.';
            else
                $data['mensagem'] = 'Ficha de notifica&ccedil;&atilde;o alterada com sucesso.';
        }

        else {
            $data['mensagem'] = 'Erro ao cadastrar ficha de notifica&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.';
        }
//          $this->loadView('ceatox/ceatox-lista');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ceatox/ceatox", $data);
    }

    function gravarobservacao()
    {
        $ficha_id = $_POST['txtFichaID'];
        if ($this->ceatox_m->gravarobservacao()) {
            $data['mensagem'] = 'Observa&ccedil;&atilde;o gravada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao cadastrar Observa&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.';
        }
        $data['ficha'] = new ceatox_model($ficha_id);
        $data['lista'] = $this->ceatox_m->listarobservacao($ficha_id);
//          $this->loadView('ceatox/ceatox-ficha-observacao',$data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ceatox/ceatox/pesquisarobservacao/$ficha_id", $data);
    }

    function gravarevolucao()
    {

        $ficha_id = $_POST['txtFichaID'];
        if ($this->ceatox_m->gravarevolucao()) {
            $data['mensagem'] = 'Evolu&ccedil;&atilde;o cadastrada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao cadastrar Evolu&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.';
        }
        $data['lista'] = $this->ceatox_m->listarevolucao($ficha_id);
//            $this->loadView('ceatox/ceatox-ficha-evolucao',$data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ceatox/ceatox/evolucao/$ficha_id", $data);
    }

    function pesquisarobservacao($ficha_id)
    {

        $data['ficha'] = new ceatox_model($ficha_id);
        $data['lista'] = $this->ceatox_m->listarobservacao($ficha_id);
        $this->loadView('ceatox/ceatox-ficha-observacao', $data);
    }

    function pdf($ficha_id)
    {

        $this->load->plugin('to_pdf_pi');
        $data['lista'] = $this->ceatox_m->fichaRelatorio($ficha_id);
        $this->load->view('ceatox/relatorios', $data);
    }

    /* Métodos privados */

    private function carregarView($data=null, $view=null)
    {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(9, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('ceatox/ceatox-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

    function carregar($ficha_id)
    {
        $obj_ficha = new ceatox_model($ficha_id);

        $data['obj'] = $obj_ficha;
        $data['chave'] = 1;
        $data['chave2'] = 1;
        $data['acao'] = 1;
        $data['listaTelefonico'] = $this->ceatox_m->listarGrupoResposta(1);
        $data['listaHospitalar'] = $this->ceatox_m->listarGrupoResposta(2);
        $data['listaTipoOcorrencia'] = $this->ceatox_m->listarGrupoResposta(3);
        $data['listaCircunstancia'] = $this->ceatox_m->listarGrupoResposta(4);
        $data['listaZona'] = $this->ceatox_m->listarGrupoResposta(5);
        $data['listaLocal'] = $this->ceatox_m->listarGrupoResposta(6);
        $data['listaVia'] = $this->ceatox_m->listarGrupoResposta(7);
        $data['listaTipo'] = $this->ceatox_m->listarGrupoResposta(8);
        $data['listaAgenteToxico'] = $this->ceatox_m->listarGrupoResposta(9);
        $data['listaCentro'] = $this->ceatox_m->listarCentro();
        $data['listaTratamentoA'] = $this->ceatox_m->listarGrupoResposta(10);
        $data['listaTratamentoB'] = $this->ceatox_m->listarGrupoResposta(11);
        $data['listaTratamentoC'] = $this->ceatox_m->listarGrupoResposta(12);
        $data['listaManifClinica'] = $this->ceatox_m->listarGrupoResposta(13);
        $data['listaInternacao'] = $this->ceatox_m->listarGrupoResposta(14);
        $data['listaAnaliseToxicologica'] = $this->ceatox_m->listarGrupoResposta(15);
        $data['listaEvolucao'] = $this->ceatox_m->listarGrupoResposta(16);
        $data['listaAvaliacao'] = $this->ceatox_m->listarGrupoResposta(17);
        $data['lista'] = $this->ceatox_m->listarAgentesFicha($ficha_id);
        $this->loadView('ceatox/ceatox-ficha', $data);
    }

    function relatoriohumanaagente()
    {
        $this->loadView('ceatox/relatoriohumanaagente');
    }

    function impressaohumanaagente()
    {
        $this->load-> plugin('to_pdf_pi');
        $data['lista'] = $this->ceatox_m->listarHumanaAgenteToxico();
        $this->load->view('ceatox/impressaohumanaagente', $data);
    }

    function relatoriosexoagente()
    {
        $this->loadView('ceatox/relatoriosexoagente');
    }

    function impressaosexoagente()
    {
        $this->load-> plugin('to_pdf_pi');
        $data['lista'] = $this->ceatox_m->listarSexoAgenteToxico();
//        echo "<pre>";
//        var_dump($data['lista']);
//        die;
        $this->load->view('ceatox/impressaosexoagente', $data);
    }

}