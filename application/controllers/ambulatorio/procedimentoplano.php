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
class Procedimentoplano extends BaseController {

    function Procedimentoplano() {
        parent::Controller();
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/laboratorio_model', 'laboratorio');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($limite = 50) {
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            redirect(base_url() . "ambulatorio/procedimentoplano/pesquisar2/$limite");
        }

        $data["limite_paginacao"] = $limite;
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento4();
        $this->loadView('ambulatorio/procedimentoplano-lista', $data);
    }

    function pesquisar2($limite = 50) {
        $data["limite_paginacao"] = $limite;
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento4();
        $this->loadView('ambulatorio/procedimentoplano2-lista', $data);
    }

    function procedimentoplanoconsulta($args = array()) {

        $this->loadView('ambulatorio/procedimentoplano-consulta', $args);

//            $this->carregarView($data);
    }

    function procedimentoplanoconsultalaudo($args = array()) {

        $this->loadView('ambulatorio/procedimentoplanolaudo-consulta', $args);

//            $this->carregarView($data);
    }

    function medicopercentual($args = array()) {
        $this->loadView('ambulatorio/percentualmedico-lista', $args);
    }

    function promotorpercentual($args = array()) {
        $this->loadView('ambulatorio/percentualpromotor-lista', $args);
    }

    function laboratoriopercentual($args = array()) {
        $this->loadView('ambulatorio/percentuallaboratorio-lista', $args);
    }

    function conveniopercentuallaboratorio($laboratorio_id) {
        $data['laboratorio_id'] = $laboratorio_id;
        $this->loadView('ambulatorio/conveniopercentuallaboratorio-lista', $data);
    }

    function procedimentoconveniopercentualpromotor($promotor_id, $convenio_id) {
        $data['promotor_id'] = $promotor_id;
        $data['convenio_id'] = $convenio_id;
        $data['grupo'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/procedimentopercentualpromotor-lista', $data);
    }

    function procedimentoconveniopercentual($medico_id, $convenio_id) {
        $data['convenio_id'] = $convenio_id;
        $data['medico_id'] = $medico_id;
        $data['grupo'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/procedimentopercentualmedico-lista', $data);
    }

    function procedimentoconveniopercentuallaboratorial($laboratorio_id, $convenio_id) {
        $data['convenio_id'] = $convenio_id;
        $data['laboratorio_id'] = $laboratorio_id;
        $data['grupo'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/procedimentopercentuallaboratorial-lista', $data);
    }

    function procedimentopercentual($args = array()) {

        $this->loadView('ambulatorio/procedimentopercentualmedico-lista', $args);
    }

    function conveniopercentualpromotor($promotor_id) {
        $data['promotor_id'] = $promotor_id;
        $this->loadView('ambulatorio/conveniopercentualpromotor-lista', $data);
    }

    function agrupador($args = array()) {
        $this->loadView('ambulatorio/agrupadorprocedimentos-lista', $args);
    }

    function carregaragrupador($agrupador_id = null) {
        $data['agrupador'] = $this->procedimentoplano->instanciaragrupador($agrupador_id);
//        $data['forma_pagamento'] = $this->formapagamento->listarforma();
        $this->loadView('ambulatorio/agrupadorprocedimentos-form', $data);
    }

    function gravaragrupadornome() {
        $agrupador_id = $this->procedimentoplano->gravaragrupadornome();
        if ($agrupador_id != false) {
            $data['mensagem'] = 'Agrupador criado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao criar agrupador.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/agrupadoradicionar/$agrupador_id");
    }

    function agrupadoradicionar($agrupador_id) {
        $data['agrupador'] = $this->procedimentoplano->buscaragrupador($agrupador_id);
        $data['convenio'] = $this->convenio->listardados();
//        $data['procedimentos'] = $this->procedimentoplano->listarprocedimentoconvenioagrupadorcirurgico(73);
        $data['relatorio'] = $this->procedimentoplano->listarprocedimentosagrupador($agrupador_id);
        $this->loadView('ambulatorio/agrupador-adicionar', $data);
    }

    function gravaragrupadoradicionar() {
        $agrupador_id = $_POST['agrupador_id'];
        if ($this->procedimentoplano->gravaragrupadoradicionar()) {
            $data['mensagem'] = 'Procedimento adicionada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao adicionar.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/agrupadoradicionar/$agrupador_id");
    }

    function excluiragrupador($agrupador_id) {
        $teste = $this->procedimentoplano->excluiragrupadornome($agrupador_id);
        if ($teste != 0) {
            $data['mensagem'] = 'Agrupador criado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao criar agrupador.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/agrupador");
    }

    function excluirformapagamentoplanoconvenio($convenio_formapagamento_id, $convenio_id, $grupopagamento_id) {
        $this->procedimentoplano->excluirformapagamentoplanoconvenio($convenio_formapagamento_id, $grupopagamento_id, $convenio_id);
        redirect(base_url() . "ambulatorio/procedimentoplano/carregarprocedimentoplanoformapagamento/$convenio_id");
    }

    function excluirprocedimentoplanoconveniosessao($procedimento_convenio_sessao_id, $procedimento_convenio_id) {
        $this->procedimentoplano->excluirprocedimentoplanoconveniosessao($procedimento_convenio_sessao_id, $procedimento_convenio_id);
        redirect(base_url() . "ambulatorio/procedimentoplano/carregarprocedimentoplanosessao/$procedimento_convenio_id");
    }

    function excluirprocedimentoagrupador($procedimento_agrupado_id, $agrupador_id) {
        $this->procedimentoplano->excluirprocedimentoagrupador($procedimento_agrupado_id);
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/agrupadoradicionar/$agrupador_id");
    }

    function carregarmultiplosprocedimentoplano() {
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento3();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['grupos'] = $this->procedimentoplano->listargrupo();
        $data['empresa'] = $this->empresa->listarempresasprocedimento();

        $this->loadView('ambulatorio/multiplosprocedimentoplano-form', $data);
    }

    function listaprocedimentomultiempresa($procedimento_tuss_id, $convenio_id) {
        $data['procedimentos'] = $this->procedimentoplano->listaprocedimentomultiempresa($procedimento_tuss_id, $convenio_id);
        $this->loadView('ambulatorio/listaprocedimentomultiempresa-form', $data);
    }

    function carregarprocedimentoplanoagrupador($procedimentoplano_tuss_id) {
        $obj_procedimentoplano = new procedimentoplano_model($procedimentoplano_tuss_id);
        $data['obj'] = $obj_procedimentoplano;
        $data['procedimento'] = $this->procedimentoplano->listaragrupadoresprocedimento();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['empresa'] = $this->empresa->listarempresasprocedimento();

        $this->loadView('ambulatorio/procedimentoplanoagrupador-form', $data);
    }

    function carregarprocedimentoplano($procedimentoplano_tuss_id) {
        $obj_procedimentoplano = new procedimentoplano_model($procedimentoplano_tuss_id);
        $data['obj'] = $obj_procedimentoplano;
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento2();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['grupos'] = $this->procedimento->listargruposmatmed();
        $data['empresa'] = $this->empresa->listarempresasprocedimento();

        $this->loadView('ambulatorio/procedimentoplano-form', $data);
    }

    function carregarprocedimentoplanoformapagamento($convenio_id) {

        $data['convenio_id'] = $convenio_id;

        $data["formapagamento_grupo"] = $this->formapagamento->listargrupos();
        $data['formas'] = $this->procedimentoplano->listarformaspagamentoconvenio($convenio_id);

        $this->loadView('ambulatorio/procedimentoplanoformapagamento', $data);
    }

    function carregarprocedimentoplanosessao($convenio_id) {

        $data['convenio_id'] = $convenio_id;
        $data['sessao'] = $this->procedimentoplano->listarprocedimentoconveniosessao($convenio_id);

        $this->loadView('ambulatorio/procedimentoplanosessao', $data);
    }

    function carregarprocedimentoplanoexcluirgrupo($convenio_id) {

        $data['convenio_id'] = $convenio_id;
        $data['grupos'] = $this->procedimento->listargrupos();
//        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentoplanoexcluirgrupo', $data);
    }

    function carregarprocedimentoformapagamento($procedimento_convenio_id) {
        $data["procedimento_convenio_id"] = $procedimento_convenio_id;
        $data["formapagamento_grupo"] = $this->formapagamento->listargrupos();
        $data["grupos_associados"] = $this->formapagamento->listargruposasssociados($procedimento_convenio_id);
        $this->loadView('ambulatorio/procedimentoformapagamento-form', $data);
    }

    function gravarorcamentorecepcao() {
        if ($_POST['procedimento1'] == '' || $_POST['convenio1'] == '-1' || $_POST['qtde1'] == '') {
            $data['mensagem'] = 'Informe o convenio, o procedimento e a quantidade.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/orcamento/$paciente_id");
        } else {
            $retorno = $this->guia->listarorcamentorecepcao();

            $resultadoorcamento = $retorno['orcamento'];
            $paciente_id = $retorno['paciente_id'];

            if ($resultadoorcamento == null) {
                $ambulatorio_orcamento = $this->guia->gravarorcamentorecepcao($paciente_id);
            } else {
                $ambulatorio_orcamento = $resultadoorcamento['ambulatorio_orcamento_id'];
            }

            $this->guia->gravarorcamentoitemrecepcao($ambulatorio_orcamento, $paciente_id);

            redirect(base_url() . "ambulatorio/procedimentoplano/orcamento/$paciente_id/$ambulatorio_orcamento");
        }
    }

    function gravarorcamentorecepcaonaocadastro() {
        if ($_POST['procedimento1'] == '' || $_POST['convenio1'] == '-1' || $_POST['qtde1'] == '') {
            $data['mensagem'] = 'Informe o convenio, o procedimento e a quantidade.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/orcamento/0");
        } else {
            if ($_POST['txtNomeid'] > 0) {
                $paciente_id = $_POST['txtNomeid'];
            } else {
                $paciente_id = null;
            }
            if ($_POST['orcamento_id'] > 0) {
                $ambulatorio_orcamento = $_POST['orcamento_id'];
            } else {
                $ambulatorio_orcamento = $this->guia->gravarorcamentorecepcaonaocadastro($paciente_id);
            }

            $this->guia->gravarorcamentoitemrecepcaonaocadastro($ambulatorio_orcamento, $paciente_id);
            if ($paciente_id > 0) {
                redirect(base_url() . "ambulatorio/procedimentoplano/orcamento/$paciente_id/$ambulatorio_orcamento");
            } else {
                redirect(base_url() . "ambulatorio/procedimentoplano/orcamento/0/$ambulatorio_orcamento");
            }
        }
    }

    function excluirorcamentorecepcao($ambulatorio_orcamento_item_id, $paciente_id, $orcamento_id) {
        if ($this->procedimento->excluirorcamentorecepcao($ambulatorio_orcamento_item_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimento';
        } else {
            $mensagem = 'Erro ao excluir o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/orcamento/$paciente_id/$orcamento_id");
    }

    function orcamento($paciente_id = 0, $ambulatorio_orcamento = 0) {

        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $empresa_id = $this->session->userdata('empresa_id');
        $permissoes = $this->guia->listarempresapermissoes($empresa_id);
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['forma_pagamento'] = $this->guia->formadepagamentoguianovo();
        $data['exames'] = $this->procedimento->listarorcamentosrecepcao($ambulatorio_orcamento);
        $data['responsavel'] = $this->procedimento->listaresponsavelorcamento($ambulatorio_orcamento);
        $data['orcamento_id'] = $ambulatorio_orcamento;
//        echo "<pre>";
//        var_dump($data['exames']); die;
        if (@$permissoes[0]->orcamento_cadastro == 't') {
            $this->loadView('ambulatorio/orcamentogeral-form_1', $data);
        } else {
            $this->loadView('ambulatorio/orcamentogeralnaocadastro-form', $data);
        }
    }

    function orcamentorecepcaofila($orcamento) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exames'] = $this->guia->listarexamesorcamento($orcamento);
        $data['permissoes'] = $this->guia->listarempresapermissoes($empresa_id);
        $data['impressaoorcamento'] = $this->guia->listarconfiguracaoimpressaoorcamento($empresa_id);
        $data['cabecalhoconfig'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalho'] = @$data['cabecalhoconfig'][0]->cabecalho;
        $data['rodape'] = @$data['cabecalhoconfig'][0]->rodape;
        $paciente = $data['exames'][0]->paciente;
        $paciente_id = $data['exames'][0]->paciente_id;
//        var_dump($paciente); die;

        if ($data['permissoes'][0]->orcamento_config == 't') {
            $html = $this->load->View('ambulatorio/impressaoorcamentorecepcaoconfiguravel', $data, true);
        } else {
            $html = $this->load->View('ambulatorio/impressaoorcamentorecepcao', $data, true);
        }
        $tipo = 'ORÇAMENTO';
        $this->guia->gravarfiladeimpressao($html, $tipo, $paciente, $paciente_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function impressaoorcamentorecepcao($orcamento) {
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['permissoes'] = $this->guia->listarempresapermissoes($empresa_id);
        $data['emissao'] = date("d-m-Y");
        $data['impressaoorcamento'] = $this->guia->listarconfiguracaoimpressaoorcamento($empresa_id);
        $data['cabecalhoconfig'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalho'] = @$data['cabecalhoconfig'][0]->cabecalho;
        $data['rodape'] = @$data['cabecalhoconfig'][0]->rodape;
        $data['exames'] = $this->guia->listarexamesorcamento($orcamento);

        if ($data['permissoes'][0]->orcamento_config == 't') {
            $this->load->View('ambulatorio/impressaoorcamentorecepcaoconfiguravel', $data);
        } elseif ($data['empresa'][0]->impressao_orcamento == 1) {// MODELO SOLICITADO PELA AME
            $this->load->View('ambulatorio/impressaoorcamentorecepcao1', $data);
        } else {
            $this->load->View('ambulatorio/impressaoorcamentorecepcao', $data);
        }
    }

    function replicarpercentualmedico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('ambulatorio/replicarpercentualmedico-form', $data);
    }

    function salvareplicacaopercentualmedico() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->salvareplicacaopercentualmedico();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao replicar os Procedimentos. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao replicar os Procedimentos.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function conveniopercentualmedico($medico_id) {
        $data['medico_id'] = $medico_id;
        $data['convenio'] = $this->convenio->listardados();
        $this->loadView('ambulatorio/conveniopercentualmedico-lista', $data);
    }

    function ajustarpercentualmedico($medico_id = null, $convenio_id = null) {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['convenio_id'] = $convenio_id;
        $data['medico_id'] = $medico_id;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/ajustarpercentualmedico-form', $data);
    }

    function procedimentoconveniopercentualmedico($medico_id = null, $convenio_id = null) {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['convenio_id'] = $convenio_id;
        $data['medico_id'] = $medico_id;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentoconveniopercentualmedico-form', $data);
    }

    function procedimentoconveniopercentuallaboratorio($laboratorio_id = null, $convenio_id = null) {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['laboratorios'] = $this->laboratorio->listarlaboratorios();
        $data['laboratorio_id'] = $laboratorio_id;
        $data['convenio_id'] = $convenio_id;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentoconveniopercentuallaboratorio-form', $data);
    }

    function procedimentopercentualmedico($convenio_id, $medico_id) {
        $data['convenio'] = $this->convenio->listardados();
        $data['convenio_id'] = $convenio_id;
        $data['medico_id'] = $medico_id;
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('ambulatorio/procedimentopercentualmedico-form', $data);
    }

    function procedimentopercentuallaboratorio($convenio_id) {
        $data['convenio'] = $this->convenio->listardados();
        $data['convenio_id'] = $convenio_id;
//        $data['procedimento'] = $this->procedimentoplano->listarprocedimentopercentuallaboratorio();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['laboratorios'] = $this->laboratorio->listarlaboratorios();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentopercentuallaboratorio-form', $data);
    }

    function novoprocedimentopercentualpromotor($promotor_id = null, $convenio_id = null) {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['promotor'] = $this->paciente->listaindicacao();
        $data['promotor_id'] = $promotor_id;
        $data['convenio_id'] = $convenio_id;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentopercentualpromotor-form', $data);
    }

    function editarprocedimento($procedimento_percentual_medico_id, $convenio_id) {
        $data['convenio_id'] = $convenio_id;
        $data['dados'] = $procedimento_percentual_medico_id;
        $this->loadView('ambulatorio/procedimentopercentualmedico-editar', $data);
    }

    function editarprocedimentolaboratorial($procedimento_percentual_medico_id, $convenio_id) {
        $data['convenio_id'] = $convenio_id;
        $data['dados'] = $procedimento_percentual_medico_id;
        $this->loadView('ambulatorio/procedimentopercentuallaboratorial-editar', $data);
    }

    function editarprocedimentopromotor($procedimento_percentual_promotor_id, $convenio_id) {
        $data['convenio_id'] = $convenio_id;
        $data['dados'] = $procedimento_percentual_promotor_id;
        $this->loadView('ambulatorio/procedimentopercentualpromotor-editar', $data);
    }

    function novomedico($procedimento_percentual_medico_id, $convenio_id) {
        $data['dados'] = $this->procedimentoplano->novomedico($procedimento_percentual_medico_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['procedimento_percentual_medico_id'] = $procedimento_percentual_medico_id;
        $data['convenio_id'] = $convenio_id;
        $this->loadView('ambulatorio/procedimentopercentualmediconovo', $data);
    }

    function novolaboratorio($procedimento_percentual_laboratorio_id, $convenio_id) {
        $data['dados'] = $this->procedimentoplano->novolaboratorio($procedimento_percentual_laboratorio_id);
        $data['laboratorios'] = $this->laboratorio->listarlaboratorios();
        $data['procedimento_percentual_laboratorio_id'] = $procedimento_percentual_laboratorio_id;
        $data['convenio_id'] = $convenio_id;
        $this->loadView('ambulatorio/procedimentopercentuallaboratorionovo', $data);
    }

    function novoprocedimentopromotor($convenio_id) {
        $data['convenio'] = $this->convenio->listarconvenioselecionado($convenio_id);
        $data['convenio_id'] = $convenio_id;
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['promotor'] = $this->paciente->listaindicacao();
        $this->loadView('ambulatorio/novoprocedimentopromotor-form', $data);
    }

    function novopromotor($procedimento_percentual_promotor_id, $convenio_id) {
        $data['dados'] = $this->procedimentoplano->novopromotor($procedimento_percentual_promotor_id);
        $data['promotors'] = $this->paciente->listaindicacao();
        $data['procedimento_percentual_promotor_id'] = $procedimento_percentual_promotor_id;
        $data['convenio_id'] = $convenio_id;
        $this->loadView('ambulatorio/procedimentopercentualpromotornovo', $data);
    }

    function gravarnovomedico($procedimento_percentual_medico_id, $convenio_id) {
        $return = $this->procedimentoplano->gravarnovomedico($procedimento_percentual_medico_id);
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar Médico.';
        }if ($return == 0) {
            $mensagem = 'Erro ao gravar Médico.';
        }if ($return == 2) {
            $mensagem = 'Erro: Médico já cadastrado.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimento/$procedimento_percentual_medico_id/$convenio_id");
    }

    function gravarnovolaboratorio($procedimento_percentual_medico_id, $convenio_id) {
        $return = $this->procedimentoplano->gravarnovolaboratorio($procedimento_percentual_medico_id);
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar Laboratório.';
        }if ($return == 0) {
            $mensagem = 'Erro ao gravar Laboratório.';
        }if ($return == 2) {
            $mensagem = 'Erro: Laboratório já cadastrado.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentolaboratorial/$procedimento_percentual_medico_id/$convenio_id");
    }

    function gravarnovopromotor($procedimento_percentual_promotor_id, $convenio_id) {
        $return = $this->procedimentoplano->gravarnovopromotor($procedimento_percentual_promotor_id);
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar Promotor.';
        }if ($return == 0) {
            $mensagem = 'Erro ao gravar Promotor.';
        }if ($return == 2) {
            $mensagem = 'Erro: Promotor já cadastrado.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentopromotor/$procedimento_percentual_promotor_id/$convenio_id");
    }

    function gravarformapagamentoplanoconvenio($convenio_id) {
        $return = $this->procedimentoplano->gravarformapagamentoplanoconvenio();
        $mensagem = 'Sucesso ao gravar Forma de Pagamento.';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/carregarprocedimentoplanoformapagamento/$convenio_id");
    }

    function gravarprocedimentoconveniosessao($procedimento_convenio_id) {
        $return = $this->procedimentoplano->gravarprocedimentoconveniosessao();
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar o valor da sessão.';
        } else {
            $mensagem = 'Sessão já cadastrada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/carregarprocedimentoplanosessao/$procedimento_convenio_id");
    }

    function gravarformapagamentoprocedimento() {
        $return = $this->procedimentoplano->gravarformapagamentoprocedimento();
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar Forma de Pagamento.';
        }if ($return == 0) {
            $mensagem = 'Erro ao gravar Forma de Pagamento.';
        }if ($return == 2) {
            $mensagem = 'Erro: Forma de Pagamento já cadastrado.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirgrupopagamentoprocedimento($grupo_id, $procedimento_convenio_id) {
        $this->procedimentoplano->excluirgrupopagamentoprocedimento($grupo_id);
//        if ($return == 1) {
        $mensagem = 'Sucesso ao gravar Forma de Pagamento.';
//        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/carregarprocedimentoformapagamento/$procedimento_convenio_id");
    }

    function reativarprocedimentoconvenio($procedimentoplano_tuss_id) {
        if ($this->procedimentoplano->reativarprocedimentoconvenio($procedimentoplano_tuss_id)) {
            $mensagem = 'Sucesso ao reativar o Procedimentoplano';
        } else {
            $mensagem = 'Erro ao reativar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        }

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirdesativado($procedimentoplano_tuss_id) {
        if ($this->procedimentoplano->excluirdesativado($procedimentoplano_tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimentoplano';
        } else {
            $mensagem = 'Erro ao excluir o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        }

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluir($procedimentoplano_tuss_id) {
        if ($this->procedimentoplano->excluir($procedimentoplano_tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimentoplano';
        } else {
            $mensagem = 'Erro ao excluir o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        }

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirporgrupo() {
        if ($this->procedimentoplano->excluirporgrupo()) {
            $mensagem = 'Sucesso ao excluir o Procedimentoplano';
        } else {
            $mensagem = 'Erro ao excluir o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/convenio");
    }

    function excluirpercentualconveniopromotor() {
        $promotor_id = $_POST['promotor_id'];

        foreach ($_POST['convenio'] as $key => $value) {
            $convenio_id = $key;
            $this->procedimentoplano->excluirpercentualconveniopromotor($promotor_id, $convenio_id);
        }

        $mensagem = 'Sucesso ao excluir os Percentuais associados a esse convenio';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirpercentualconvenio() {
        $medico_id = $_POST['medico_id'];

        foreach ($_POST['convenio'] as $key => $value) {
            $convenio_id = $key;
            $this->procedimentoplano->excluirpercentualconvenio($medico_id, $convenio_id);
        }

        $mensagem = 'Sucesso ao excluir os Percentuais medicos associados a esse convenio';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirpercentuallaboratorioconvenio() {
        $laboratorio_id = $_POST['laboratorio_id'];
        foreach ($_POST['convenio'] as $key => $value) {
            $convenio_id = $key;
            $this->procedimentoplano->excluirpercentuallaboratorioconvenio($laboratorio_id, $convenio_id);
        }

        $mensagem = 'Sucesso ao excluir os Percentuais medicos associados a esse convenio';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirpercentuallaboratorio() {
        foreach ($_POST['laboratorio'] as $key => $value) {
            $laboratorio_id = $key;
            $this->procedimentoplano->excluirpercentuallaboratorio($laboratorio_id);
        }

        $mensagem = 'Sucesso ao excluir o Percentual medico';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirpercentual() {

        foreach ($_POST['percentual'] as $key => $value) {
            $procedimento_percentual_medico_convenio_id = $key;
            $this->procedimentoplano->excluirpercentual($procedimento_percentual_medico_convenio_id);
        }

        $mensagem = 'Sucesso ao excluir o Percentual medico';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirpercentualpromotorgeral() {
        foreach ($_POST['promotor'] as $key => $value) {
            $promotor_id = $key;
            $this->procedimentoplano->excluirpercentualpromotorgeral($promotor_id);
        }

        $mensagem = 'Sucesso ao excluir o Percentual promotor';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirmedicopercentual() {

        foreach ($_POST['medico'] as $key => $value) {
            $medico_id = $key;
            $this->procedimentoplano->excluirmedicopercentual($medico_id);
        }

        $mensagem = 'Sucesso ao excluir os percentuais desse medico';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirlaboratoriopercentual() {
        foreach ($_POST['percentual'] as $key => $value) {
            $procedimento_percentual_laboratorio_convenio_id = $key;
            $this->procedimentoplano->excluirlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id);
        }

        $mensagem = 'Sucesso ao excluir o Percentual laboratorio';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirpromotorpercentual() {

        foreach ($_POST['percentual'] as $key => $value) {
            $procedimento_percentual_promotor_convenio_id = $key;
            $this->procedimentoplano->excluirpromotorpercentual($procedimento_percentual_promotor_convenio_id);
        }

        $mensagem = 'Sucesso ao excluir o Percentual promotor';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function editarmedicopercentual($procedimento_percentual_medico_convenio_id, $medico_id, $convenio_id) {
        $data['medico_id'] = $medico_id;
        $data['convenio_id'] = $convenio_id;
        $data['busca'] = $this->procedimentoplano->buscarmedicopercentual($procedimento_percentual_medico_convenio_id);
        $data['procedimento_percentual_medico_convenio_id'] = $procedimento_percentual_medico_convenio_id;
        $this->loadView("ambulatorio/medicopercentual-editar", $data);
    }

    function editarlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id) {
        $data['procedimento_percentual_laboratorio_convenio_id'] = $procedimento_percentual_laboratorio_convenio_id;
        $data['busca'] = $this->procedimentoplano->buscarlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id);
        $this->loadView("ambulatorio/laboratoriopercentual-editar", $data);
    }

    function editarpromotorpercentual($procedimento_percentual_promotor_convenio_id) {
        $data['busca'] = $this->procedimentoplano->buscarpromotorpercentual($procedimento_percentual_promotor_convenio_id);
//        $data['dados'] = $dados;
//        $data['convenio_id'] = $convenio_id;
        $data['procedimento_percentual_promotor_convenio_id'] = $procedimento_percentual_promotor_convenio_id;
        $this->loadView("ambulatorio/promotorpercentual-editar", $data);
    }

    function gravareditarmedicopercentual($procedimento_percentual_medico_convenio_id, $medico_id, $convenio_id) {

        if ($this->procedimentoplano->gravareditarmedicopercentual($procedimento_percentual_medico_convenio_id)) {
            $mensagem = 'Sucesso ao editar o Percentual medico';
        } else {
            $mensagem = 'Erro ao editar o Percentual medico. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentoconveniopercentual/{$medico_id}/{$convenio_id}");
    }

    function gravareditarlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id) {
        $convenio_id = $_POST['convenio_id'];
        $percentual_laboratorio_id = $_POST['percentual_laboratorio_id'];

        if ($this->procedimentoplano->gravareditarlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id)) {
            $mensagem = 'Sucesso ao editar o Percentual laboratorio';
        } else {
            $mensagem = 'Erro ao editar o Percentual laboratorio. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravareditarpromotorpercentual($procedimento_percentual_promotor_convenio_id) {
        if ($this->procedimentoplano->gravareditarpromotorpercentual($procedimento_percentual_promotor_convenio_id)) {
            $mensagem = 'Sucesso ao editar o Percentual promotor';
        } else {
            $mensagem = 'Erro ao editar o Percentual promotor. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarmultiplos() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarmultiplos();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Procedimento já cadastrado.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravaragrupador() {

        $verifica = $this->procedimentoplano->verificaagrupadorconvenio($_POST['convenio'], $_POST['procedimento']);
        if ($verifica == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Agrupador. Alguns procedimentos do pacote não estão cadastrados nesse convenio.';
        } else {
            $procedimento_id = $this->procedimentoplano->gravaragrupador();
            if ($procedimento_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar o Agrupador. Operação cancelada.';
            } elseif ($procedimento_id == "-2") {
                $data['mensagem'] = 'Erro ao gravar. Esse Agrupador ja está cadastrado.';
            } elseif ($procedimento_id == "-3") {
                $data['mensagem'] = 'Erro ao gravar. Algum(ns) convenio(s) associado(s) a esse, não estão vinculados através dos grupos contidos no agrupador.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar Agrupador.';
            }
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravar() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravar();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Procedimento já cadastrado.';
        } elseif ($procedimentoplano_tuss_id == "-2") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Esse procedimento não pertence ao convenio Primario.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarpercentualmedico() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentualmedico();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarajustepercentualmedico() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarajustepercentualmedico();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarpercentuallaboratorioconvenio() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentuallaboratorioconvenio();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o percentual do convênio. Convênio já cadastrado';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
//        die('morreu');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarpercentuallaboratorio() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentuallaboratorio();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o percentual do convênio. Convênio já cadastrado';
        } elseif ($procedimentoplano_tuss_id == "-2") {
            $data['mensagem'] = 'Alguns procedimentos não foram gravados porque já existem registros dos mesmos.';
        } else {
            $data['mensagem'] = 'Erro ao gravar o percentual do convênio. Convênio já cadastrado';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/conveniopercentuallaboratorio");
    }

    function gravarpercentualprocedimentopromotor($convenio_id) {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentualpromotor();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentoconveniopercentualpromotor/$convenio_id");
    }

    function gravarpercentualpromotor() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentualpromotor();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
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
