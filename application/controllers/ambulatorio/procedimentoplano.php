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
        $data["limite_paginacao"] = $limite;
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento2();
        $this->loadView('ambulatorio/procedimentoplano-lista', $data);
    }

    function procedimentoplanoconsulta($args = array()) {

        $this->loadView('ambulatorio/procedimentoplano-consulta', $args);

//            $this->carregarView($data);
    }

    function conveniopercentual($args = array()) {
        $this->loadView('ambulatorio/conveniopercentualmedico-lista', $args);
    }

    function conveniopercentuallaboratorio($args = array()) {
        $this->loadView('ambulatorio/conveniopercentuallaboratorio-lista', $args);
    }

//    function procedimentoconveniopercentuallaboratorio($convenio_id) {
//        $data['convenio_id'] = $convenio_id;
////        var_dump($_GET);die;
////        $data['procedimentos'] = $this->procedimentoplano->listarprocedimentoconveniopercentuallaboratorio($convenio_id);
//        $data['grupo'] = $this->procedimento->listargrupos();
////        var_dump($data['grupo']);die;
//        $this->loadView('ambulatorio/procedimentopercentuallaboratorio-lista', $data);
//    }

    function procedimentoconveniopercentual($convenio_id) {
        $data['convenio_id'] = $convenio_id;
//        var_dump($_GET);die;
//        $data['procedimentos'] = $this->procedimentoplano->listarprocedimentoconveniopercentual($convenio_id);
        $data['grupo'] = $this->procedimento->listargrupos();
//        var_dump($data['grupo']);die;
        $this->loadView('ambulatorio/procedimentopercentualmedico-lista', $data);
    }

    function procedimentoconveniopercentuallaboratorial($convenio_id) {
        $data['convenio_id'] = $convenio_id;
//        var_dump($_GET);die;
//        $data['procedimentos'] = $this->procedimentoplano->listarprocedimentoconveniopercentual($convenio_id);
        $data['grupo'] = $this->procedimento->listargrupos();
//        var_dump($data['grupo']);die;
        $this->loadView('ambulatorio/procedimentopercentuallaboratorial-lista', $data);
    }

    function procedimentopercentual($args = array()) {

        $this->loadView('ambulatorio/procedimentopercentualmedico-lista', $args);
    }

    function procedimentopercentualpromotor($args = array()) {

        $this->loadView('ambulatorio/procedimentopercentualpromotor-lista', $args);
    }

    function agrupador($args = array()) {
        $this->loadView('ambulatorio/agrupadorprocedimentos-lista', $args);
    }

    function carregaragrupador($agrupador_id = null) {
        $data['convenio'] = $this->convenio->listardados();
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
        $data['procedimentos'] = $this->procedimentoplano->listarprocedimentoconvenioagrupadorcirurgico(@$data['agrupador'][0]->convenio_id);
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

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/multiplosprocedimentoplano-form', $data);
    }

    function carregarprocedimentoplanoagrupador($procedimentoplano_tuss_id) {
        $obj_procedimentoplano = new procedimentoplano_model($procedimentoplano_tuss_id);
        $data['obj'] = $obj_procedimentoplano;
        $data['procedimento'] = $this->procedimentoplano->listaragrupadoresprocedimento();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['grupos'] = $this->procedimento->listargruposmatmed();
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

            $this->guia->gravarorcamentoitemrecepcao($ambulatorio_orcamento);

            redirect(base_url() . "ambulatorio/procedimentoplano/orcamento/$paciente_id/$ambulatorio_orcamento");
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

        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['forma_pagamento'] = $this->guia->formadepagamentoguianovo();
        $data['exames'] = $this->procedimento->listarorcamentosrecepcao($ambulatorio_orcamento);
        $data['responsavel'] = $this->procedimento->listaresponsavelorcamento($ambulatorio_orcamento);
//        echo "<pre>";
//        var_dump($data['exames']); die;

        $this->loadView('ambulatorio/orcamentogeral-form_1', $data);
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
        $html = utf8_decode($html);
        $tipo = 'ORÇAMENTO';
        $this->guia->gravarfiladeimpressao($html, $tipo, $paciente, $paciente_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function impressaoorcamentorecepcao($orcamento) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['permissoes'] = $this->guia->listarempresapermissoes($empresa_id);
        $data['impressaoorcamento'] = $this->guia->listarconfiguracaoimpressaoorcamento($empresa_id);
        $data['cabecalhoconfig'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalho'] = @$data['cabecalhoconfig'][0]->cabecalho;
        $data['rodape'] = @$data['cabecalhoconfig'][0]->rodape;
        $data['exames'] = $this->guia->listarexamesorcamento($orcamento);
//        var_dump($data['exames']); die;

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
        redirect(base_url() . "ambulatorio/procedimentoplano/conveniopercentual");
    }

    function procedimentoconveniopercentualmedico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentoconveniopercentualmedico-form', $data);
    }

    function procedimentoconveniopercentuallaboratorio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['laboratorios'] = $this->laboratorio->listarlaboratorios();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentoconveniopercentuallaboratorio-form', $data);
    }

    function procedimentopercentualmedico($convenio_id) {
        $data['convenio'] = $this->convenio->listardados();
        $data['convenio_id'] = $convenio_id;
//        $data['procedimento'] = $this->procedimentoplano->listarprocedimentopercentualmedico();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentopercentualmedico-form', $data);
    }

    function procedimentopercentuallaboratorio($convenio_id) {
        $data['convenio'] = $this->convenio->listardados();
        $data['convenio_id'] = $convenio_id;
//        $data['procedimento'] = $this->procedimentoplano->listarprocedimentopercentuallaboratorio();
        $data['grupo'] = $this->procedimentoplano->listargrupolaboratorial();
        $data['laboratorios'] = $this->laboratorio->listarlaboratorios();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimentopercentuallaboratorio-form', $data);
    }

    function novoprocedimentopercentualpromotor() {
        $data['convenio'] = $this->convenio->listardados();
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento();
        $data['grupo'] = $this->procedimentoplano->listargrupo();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['promotor'] = $this->paciente->listaindicacao();
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

    function editarprocedimentopromotor($procedimento_percentual_promotor_id) {
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

    function novopromotor($procedimento_percentual_promotor_id) {
        $data['dados'] = $this->procedimentoplano->novopromotor($procedimento_percentual_promotor_id);
        $data['promotors'] = $this->paciente->listaindicacao();
        $data['procedimento_percentual_promotor_id'] = $procedimento_percentual_promotor_id;
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

    function gravarnovopromotor($procedimento_percentual_promotor_id) {
        $return = $this->procedimentoplano->gravarnovopromotor($procedimento_percentual_promotor_id);
        if ($return == 1) {
            $mensagem = 'Sucesso ao gravar Promotor.';
        }if ($return == 0) {
            $mensagem = 'Erro ao gravar Promotor.';
        }if ($return == 2) {
            $mensagem = 'Erro: Promotor já cadastrado.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentopromotor/$procedimento_percentual_promotor_id");
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
        redirect(base_url() . "ambulatorio/procedimentoplano");
    }

    function excluir($procedimentoplano_tuss_id) {
        if ($this->procedimentoplano->excluir($procedimentoplano_tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimentoplano';
        } else {
            $mensagem = 'Erro ao excluir o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano");
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

    function excluirpercentualconvenio($convenio_id) {
        if ($this->procedimentoplano->excluirpercentualconvenio($convenio_id)) {
            $mensagem = 'Sucesso ao excluir os Percentuais medicos associados a esse convenio';
        } else {
            $mensagem = 'Erro ao excluir os percentuais medicos. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/conveniopercentual");
    }

    function excluirpercentuallaboratorioconvenio($convenio_id) {
        if ($this->procedimentoplano->excluirpercentuallaboratorioconvenio($convenio_id)) {
            $mensagem = 'Sucesso ao excluir os Percentuais medicos associados a esse convenio';
        } else {
            $mensagem = 'Erro ao excluir os percentuais medicos. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/conveniopercentuallaboratorio");
    }

    function excluirpercentuallaboratorio($procedimento_percentual_medico_id, $convenio_id) {
        if ($this->procedimentoplano->excluirpercentuallaboratorio($procedimento_percentual_medico_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual medico';
        } else {
            $mensagem = 'Erro ao excluir o Percentual medico. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentoconveniopercentuallaboratorial/$convenio_id");
    }

    function excluirpercentual($procedimento_percentual_medico_id, $convenio_id) {
        if ($this->procedimentoplano->excluirpercentual($procedimento_percentual_medico_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual medico';
        } else {
            $mensagem = 'Erro ao excluir o Percentual medico. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentoconveniopercentual/$convenio_id");
    }

    function excluirpercentualpromotorgeral($procedimento_percentual_medico_id) {
        if ($this->procedimentoplano->excluirpercentualpromotorgeral($procedimento_percentual_medico_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual promotor';
        } else {
            $mensagem = 'Erro ao excluir o Percentual promotor. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentopercentualpromotor");
    }

    function excluirmedicopercentual($procedimento_percentual_medico_convenio_id, $percentual_medico_id, $convenio_id) {
        if ($this->procedimentoplano->excluirmedicopercentual($procedimento_percentual_medico_convenio_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual medico';
        } else {
            $mensagem = 'Erro ao excluir o Percentual medico. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimento/$percentual_medico_id/$convenio_id");
    }

    function excluirlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id, $percentual_laboratorio_id, $convenio_id) {
        if ($this->procedimentoplano->excluirlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual laboratorio';
        } else {
            $mensagem = 'Erro ao excluir o Percentual laboratorio. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentolaboratorial/$percentual_laboratorio_id/$convenio_id");
    }

    function excluirpromotorpercentual($procedimento_percentual_promotor_convenio_id, $dados) {
        if ($this->procedimentoplano->excluirpromotorpercentual($procedimento_percentual_promotor_convenio_id)) {
            $mensagem = 'Sucesso ao excluir o Percentual promotor';
        } else {
            $mensagem = 'Erro ao excluir o Percentual promotor. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentopromotor/$dados");
    }

    function editarmedicopercentual($procedimento_percentual_medico_convenio_id, $percentual_medico_id, $convenio_id) {
        $data['percentual_medico_id'] = $percentual_medico_id;
        $data['convenio_id'] = $convenio_id;
        $data['busca'] = $this->procedimentoplano->buscarmedicopercentual($procedimento_percentual_medico_convenio_id);
        $data['procedimento_percentual_medico_convenio_id'] = $procedimento_percentual_medico_convenio_id;
        $this->loadView("ambulatorio/medicopercentual-editar", $data);
    }

    function editarlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id, $percentual_laboratorio_id, $convenio_id) {
        $data['percentual_laboratorio_id'] = $percentual_laboratorio_id;
        $data['convenio_id'] = $convenio_id;
        $data['busca'] = $this->procedimentoplano->buscarlaboratoriopercentual($procedimento_percentual_laboratorio_convenio_id);
        $data['procedimento_percentual_laboratorio_convenio_id'] = $procedimento_percentual_laboratorio_convenio_id;
        $this->loadView("ambulatorio/laboratoriopercentual-editar", $data);
    }

    function editarpromotorpercentual($procedimento_percentual_promotor_convenio_id, $dados) {
        $data['busca'] = $this->procedimentoplano->buscarpromotorpercentual($procedimento_percentual_promotor_convenio_id);
        $data['dados'] = $dados;
        $data['procedimento_percentual_promotor_convenio_id'] = $procedimento_percentual_promotor_convenio_id;
        $this->loadView("ambulatorio/promotorpercentual-editar", $data);
    }

    function gravareditarmedicopercentual($procedimento_percentual_medico_convenio_id) {
        $convenio_id = $_POST['convenio_id'];
        $percentual_medico_id = $_POST['percentual_medico_id'];

        if ($this->procedimentoplano->gravareditarmedicopercentual($procedimento_percentual_medico_convenio_id)) {
            $mensagem = 'Sucesso ao editar o Percentual medico';
        } else {
            $mensagem = 'Erro ao editar o Percentual medico. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimento/{$percentual_medico_id}/{$convenio_id}");
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
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentolaboratorial/{$percentual_laboratorio_id}/{$convenio_id}");
    }

    function gravareditarpromotorpercentual($procedimento_percentual_promotor_convenio_id, $dados) {
        if ($this->procedimentoplano->gravareditarpromotorpercentual($procedimento_percentual_promotor_convenio_id)) {
            $mensagem = 'Sucesso ao editar o Percentual promotor';
        } else {
            $mensagem = 'Erro ao editar o Percentual promotor. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimentoplano/editarprocedimentopromotor/$dados");
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
        redirect(base_url() . "ambulatorio/procedimentoplano");
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
        redirect(base_url() . "ambulatorio/procedimentoplano");
    }

    function gravarpercentualmedico() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentualmedico();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/conveniopercentual");
    }

    function gravarpercentuallaboratorio() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentuallaboratorio();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/conveniopercentuallaboratorio");
    }

    function gravarpercentualpromotor() {
        $procedimentoplano_tuss_id = $this->procedimentoplano->gravarpercentualpromotor();
        if ($procedimentoplano_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimentoplano. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimentoplano.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimentoplano/procedimentopercentualpromotor");
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
