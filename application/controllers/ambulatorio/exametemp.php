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
class Exametemp extends BaseController {

    function Exametemp() {
        parent::Controller();
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('ambulatorio/GExtenso', 'GExtenso');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/exametemp-lista', $args);

//            $this->carregarView($data);
    }

    function novo() {
        $ambulatorio_pacientetemp_id = $this->exametemp->criar();
        $this->carregarexametemp($ambulatorio_pacientetemp_id);

//            $this->carregarView($data);
    }

    function novopaciente() {
        $data['idade'] = 0;
        $this->loadView('ambulatorio/pacientetemp-form', $data);
    }

    function novopacienteconsulta() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempconsulta-form', $data);
    }

    function novopacientefisioterapia() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempfisioterapia-form', $data);
    }

    function novopacienteconsultaencaixe() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['empresas'] = $this->exame->listarempresas();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempconsultaencaixe-form', $data);
    }

    function novopacienteexameencaixe() {
        $data['idade'] = 0;
        $data['empresas'] = $this->exame->listarempresas();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacientetempexameencaixe-form', $data);
    }

    function novopacienteencaixegeral() {
        $data['idade'] = 0;
        $data['empresas'] = $this->exame->listarempresas();
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacientetempencaixegeral-form', $data);
    }

    function novohorarioexameencaixe() {
        $data['idade'] = 0;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/horariotempexameencaixe-form', $data);
    }

    function novohorarioencaixegeral() {
        $data['idade'] = 0;
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/horariotempencaixegeral-form', $data);
    }

    function novopacientefisioterapiaencaixe() {
        $data['idade'] = 0;
        $data['empresas'] = $this->exame->listarempresas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempfisioterapiaencaixe-form', $data);
    }

    function novopacientefisioterapiaencaixemedico() {
        $data['idade'] = 0;
        $data['empresas'] = $this->exame->listarempresas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempfisioterapiaencaixemedico-form', $data);
    }

    function pacienteconsultaencaixe($paciente_id) {
        $data['idade'] = 0;
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacienteconsultaencaixe-form', $data);
    }

    function mostrargraficosexames() {
        $data['relatorio'] = $this->exametemp->gerargraficosexames();
//        var_dump($data);die;
        $this->load->View('ambulatorio/graficosexames', $data);
    }

    function carregarexametemp($ambulatorio_pacientetemp_id) {
        $obj_exametemp = new exametemp_model($ambulatorio_pacientetemp_id);
        $data['obj'] = $obj_exametemp;
        $data['idade'] = 0;
        $data['contador'] = $this->exametemp->contador($ambulatorio_pacientetemp_id);
        if ($data['contador'] > 0) {
            $data['exames'] = $this->exametemp->listaragendas($ambulatorio_pacientetemp_id);
        }
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/exametemp-form', $data);
    }

    function unificar($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $this->loadView('ambulatorio/unificar-form', $data);
    }

    function gravarunificar() {
        $pacientetemp_id = $_POST['paciente_id'];

        if ($_POST['paciente_id'] == $_POST['pacienteid']) {
            $data['mensagem'] = 'Erro ao unificar. Você está tentando unificar ';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
        }

        if ($_POST['txtpaciente'] == '' || $_POST['pacienteid'] == '') {
            $data['mensagem'] = 'Paciente que sera unificado nao informado ou invalido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
        } else {
            $verifica = $this->exametemp->gravarunificacao();
            if ($verifica == "-1") {
                $data['mensagem'] = 'Erro ao unificar Paciente. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao unificar Paciente.';
            }
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
        }
    }

    function carregarpacientetempgeral($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['exames'] = $this->exametemp->listaragendatotalpacientegeral($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarprocedimentosanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarprocedimentoanteriorcontador($pacientetemp_id);


        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepacientetempgeral-form', $data);
    }

    function carregarpacientetemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorpaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpaciente($pacientetemp_id);
        $data['examesanteriores'] = $this->exametemp->listarexameanterior($pacientetemp_id);
        $data['salas'] = $this->exame->listartodassalasexames();
        $data['grupos'] = $this->procedimento->listargrupos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepacientetemp-form', $data);
    }

    function carregarpacienteconsultatemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorconsultapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacienteconsulta($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/consultapacientetemp-form', $data);
    }

    function carregarpacientefisioterapiatemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorfisioterapiapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapia($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarespecialidadeanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/fisioterapiapacientetemp-form', $data);
    }

    function reangedarfisioterapiatemp($agenda_exames_id, $pacientetemp_id, $medico_consulta_id) {
//        if (isset($faltou)) {
//            $data['faltou'] = $faltou;
//        }
        $data['pacientetemp_id'] = $pacientetemp_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico_consulta_id'] = $medico_consulta_id;
        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorfisioterapiapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapiareangedar($agenda_exames_id);
        $data['consultasanteriores'] = $this->exametemp->listarespecialidadeanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/reagendarfisioterapiapacientetemp-form', $data);
    }

    function reangedarconsultatemp($agenda_exames_id, $pacientetemp_id, $medico_consulta_id) {
//        if (isset($faltou)) {
//            $data['faltou'] = $faltou;
//        }
        $data['pacientetemp_id'] = $pacientetemp_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico_consulta_id'] = $medico_consulta_id;
        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorfisioterapiapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapiareangedar($agenda_exames_id);
        $data['consultasanteriores'] = $this->exametemp->listarespecialidadeanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/reagendarconsultapacientetemp-form', $data);
    }
    function reangedargeraltemp($agenda_exames_id, $pacientetemp_id, $medico_consulta_id) {
//        if (isset($faltou)) {
//            $data['faltou'] = $faltou;
//        }
        $data['pacientetemp_id'] = $pacientetemp_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico_consulta_id'] = $medico_consulta_id;
        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorfisioterapiapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapiareangedar($agenda_exames_id);
        $data['consultasanteriores'] = $this->exametemp->listarespecialidadeanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/reagendargeralpacientetemp-form', $data);
    }

    function listarcredito($paciente_id) {

        $data['paciente_id'] = $paciente_id;
        $data['permissoes'] = $this->guia->listarempresapermissoes();
        $data['valortotal'] = $this->exametemp->listarsaldocreditopaciente($paciente_id);

        $this->loadView('ambulatorio/carregarcredito-lista', $data);
    }

    function mostrarpendencias() {

        $data['pendencias'] = $this->exametemp->listarpendenciasoperador();


        $this->load->view('ambulatorio/mostrarpendencias', $data);
    }

    function gerasaldocredito($paciente_id) {
        $data['paciente_id'] = $paciente_id;

        $credito = $this->exametemp->gerasaldocredito($paciente_id);
//        var_dump($credito); die;

        if (@$credito[0]->valor_total == '0.00') {
            $data['extenso'] = 'ZERO';
        } else {
            $valoreditado = str_replace(",", "", str_replace(".", "", @$credito[0]->valor_total));
            $data['extenso'] = GExtenso::moeda($valoreditado);
        }

        $data['credito'] = $credito;
        $data['empresa'] = $this->guia->listarempresa();

//        var_dump($credito); die;
        $this->load->view('ambulatorio/impressaosaldopacientecredito', $data);
    }

    function gerarecibocredito($paciente_credito_id, $paciente_id) {
        $data['paciente_credito_id'] = $paciente_credito_id;

        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['empresapermissoes'] = $this->guia->listarempresapermissoes($empresa_id);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);

        $data['impressaorecibo'] = $this->guia->listarconfiguracaoimpressaorecibo($empresa_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;
        
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        
        $credito = $this->exametemp->gerarecibocredito($paciente_credito_id);
//        var_dump($credito); die;
        if ($credito[0]->valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {
            $valoreditado = str_replace(",", "", str_replace(".", "", $credito[0]->valor));
            $data['extenso'] = GExtenso::moeda($valoreditado);
        }

        $data['credito'] = $credito;
        
                if ($data['empresapermissoes'][0]->recibo_config == 't') {

            if ($data['impressaorecibo'][0]->cabecalho == 't') {
                if ($data['empresa'][0]->cabecalho_config == 't') { // Cabeçalho Da clinica
                    $cabecalho = "$cabecalho_config";
                } else {
                    $cabecalho = "<table><tr><td><img width='1000px' height='180px' src='img/cabecalho.jpg'></td></tr></table>";
                }
            } else {
                $cabecalho = '';
            }

            if ($data['impressaorecibo'][0]->rodape == 't') { // rodape da empresa
                if ($data['empresa'][0]->rodape_config == 't') {
                    $rodape = $rodape_config;
                } else {
                    $rodape = "";
                }
            } else {
                $rodape = "";
            }
            $data['cabecalho'] = $cabecalho;
            $data['rodape'] = $rodape;
            
            $this->load->View('ambulatorio/impressaorecibocreditoconfiguravel', $data);
        }else{
            $this->load->view('ambulatorio/reciboprocedimentocredito', $data);
        }
        

        
    }

    function enviarpendenteatendimento($exames_id, $sala_id, $agenda_exames_id) {
        $verificar = $this->exametemp->enviarpendenteatendimento($exames_id, $sala_id, $agenda_exames_id);
        if ($verificar == -1) {
            $data['mensagem'] = 'Erro ao finalizar o Exame. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao finalizar o Exame.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function mostrarlembretes() {

        $data['lembretes'] = $this->exametemp->listarlembretesoperador();

        $this->load->view('ambulatorio/mostrarlembretes', $data);
    }

    function carregarcredito($paciente_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['permissoes'] = $this->guia->listarempresapermissoes();
        $this->loadView('ambulatorio/novocredito-form', $data);
    }

    function gravarcredito() {
        $paciente_id = $_POST['txtpaciente_id'];
        $credito_id = $this->exametemp->gravarcredito();
        redirect(base_url() . "ambulatorio/exametemp/faturarcreditos/$credito_id/$paciente_id");
    }

    function faturarcreditos($credito_id, $paciente_id) {
        $data['forma_pagamento'] = $this->guia->formadepagamentofaturarcredito();
        $data['valor_credito'] = $this->exametemp->listarcreditofaturar($credito_id);
        $permissoes = $this->guia->listarempresapermissoes();
        $data['paciente_id'] = $paciente_id;
        $data['credito_id'] = $credito_id;
        $data['valor'] = 0.00;
        
        if($permissoes[0]->ajuste_pagamento_procedimento == 't') {
            $this->load->View('ambulatorio/faturarcreditopersonalizado-form', $data);
        }
        else {
            $this->load->View('ambulatorio/faturarcredito-form', $data);
        }
    }

    function gravarfaturarcreditopersonalizado() {
        $this->guia->gravarfaturarcreditopersonalizado();
//        var_dump($_POST['paciente_teste_id']);
//        die;
        $credito_id = $_POST['credito_id'];
        $paciente_id = $_POST['paciente_teste_id'];
//        $data['agenda_exames_id'] = $agenda_exames_id;
//        $this->load->View('ambulatorio/faturar-form', $data);
        redirect(base_url() . "ambulatorio/exametemp/listarcredito/$paciente_id");
    }

    function gravarfaturarcredito() {
        $this->guia->gravarfaturamentocredito();
//        var_dump($_POST['paciente_teste_id']);
//        die;
        $credito_id = $_POST['credito_id'];
        $paciente_id = $_POST['paciente_teste_id'];
//        $data['agenda_exames_id'] = $agenda_exames_id;
//        $this->load->View('ambulatorio/faturar-form', $data);
        redirect(base_url() . "ambulatorio/exametemp/listarcredito/$paciente_id");
    }

    function excluircredito($credito_id, $paciente_id) {
        $this->exametemp->registrainformacaoestornocredito($credito_id);
        $verificar = $this->exametemp->excluircredito($credito_id);
        if ($verificar == -1) {
            $data['mensagem'] = 'Erro ao estornar o Crédito. Opera&ccedil;&atilde;o cancelada.';
        } elseif ($verificar == -2) {
            $data['mensagem'] = 'Erro ao estornar. Crédito já utilizado.';
        } else {
            $data['mensagem'] = 'Sucesso ao estornar o Crédito.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exametemp/listarcredito/$paciente_id");
    }

    function carregaragendamultiempresa3($agenda_exames_id, $externo_id) {
        $data['externo_id'] = $externo_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $externo = $this->exame->listarexterno($externo_id);

        $parametro = array(
            "acao" => "convenio",
            "agenda_exames_id" => $agenda_exames_id,
            "ip" => $externo[0]->ip_externo
        );

        $dados = http_build_query($parametro);

        $contexto = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'content' => $dados,
                'header' => "Content-type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: " . strlen($dados) . "\r\n",
            )
        ));

        $url = "acao={$parametro['acao']}&ip={$parametro['ip']}&agenda_exames_id={$agenda_exames_id}";
        $resposta = file_get_contents("http://localhost/arquivoRequisicoes.php?{$url}", null, $contexto);

//        $data['convenio'] = json_decode($resposta);

        $array = explode("|", $resposta);
        $convenio = json_decode($array[0]);
        $dadosAgendaExame = json_decode($array[1]);

        $data["convenio"] = $convenio;
        $data["consultas"] = $dadosAgendaExame;
        $data["ip"] = $externo[0]->ip_externo;

        $this->loadView('ambulatorio/consultapacientemultiempresa-form', $data);
    }

    function carregaragendamultiempresa($agenda_exames_id, $medico_id, $externo_id) {
        $data['medico'] = $medico_id;
        $data['externo_id'] = $externo_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $externo = $this->exame->listarexterno($externo_id);

        $parametro = array(
            "acao" => "convenio",
            "agenda_exames_id" => $agenda_exames_id,
            "ip" => $externo[0]->ip_externo
        );

        $dados = http_build_query($parametro);

        $contexto = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'content' => $dados,
                'header' => "Content-type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: " . strlen($dados) . "\r\n",
            )
        ));

        $url = "acao={$parametro['acao']}&ip={$parametro['ip']}&agenda_exames_id={$agenda_exames_id}";
        $resposta = file_get_contents("http://localhost/arquivoRequisicoes.php?{$url}", null, $contexto);

//        $data['convenio'] = json_decode($resposta);

        $array = explode("|", $resposta);
        $convenio = json_decode($array[0]);
        $dadosAgendaExame = json_decode($array[1]);

        $data["convenio"] = $convenio;
        $data["consultas"] = $dadosAgendaExame;
        $data["ip"] = $externo[0]->ip_externo;

        $this->loadView('ambulatorio/consultapacientemultiempresa-form', $data);
    }

    function carregarexamegeral($agenda_exames_id, $medico_id) {
        $data['medico'] = $medico_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconveniomedico($medico_id);
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
//
//        if (count($data['exameshorario']) > 0 || count($data['exameshorariofim']) > 0) {
//            
//            $data['mensagem'] = 'Esse medico já tem paciente neste horario:';
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral2/$agenda_exames_id/$medico_id");
//            
//        } else {
        $this->loadView('ambulatorio/examepacientegeral-form', $data);
//        }
    }

    function carregarexamegeral2($agenda_exames_id, $medico_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico'] = $medico_id;
//        $data['medicos'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconveniomedico($medico_id);
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
        $this->loadView('ambulatorio/examepacientegeral-form', $data);
    }

    function carregarexamegeral3($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
        $this->loadView('ambulatorio/examepacientegeralmedico-form', $data);
    }

    function carregarexame($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);
        $medico = $data['exames'][0]->medico_agenda;
        $datas = $data['exames'][0]->data;
        $data['valor'] = $this->exametemp->listarvalortotalexames($medico, $datas);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepaciente-form', $data);
    }

    function carregarconsultatemp($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['consultas'] = $this->exametemp->listaragendasconsultapaciente($agenda_exames_id);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/consultapaciente-form', $data);
    }

    function carregarfisioterapiatemp($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['consultas'] = $this->exametemp->listaragendasconsultapaciente($agenda_exames_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/fisioterapiapaciente-form', $data);
    }

    function carregarfisioterapiatempmedico($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['consultas'] = $this->exametemp->listaragendasconsultapaciente($agenda_exames_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/fisioterapiapacientemedico-form', $data);
    }

    function excluir($agenda_exames_id, $ambulatorio_pacientetemp_id) {
        $this->exametemp->excluir($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarexametemp/$ambulatorio_pacientetemp_id");
    }

    function excluirprocedimentoguia($agenda_exames_id, $guia_id) {
        $this->exametemp->excluirprocedimentoguia($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exame/guiacirurgicaitens/$guia_id");
    }

    function excluirexametemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametemp($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$pacientetemp_id");
    }

    function excluirconsultatempgeral($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametemp($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
    }

    function excluirconsultatemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametemp($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$pacientetemp_id");
    }

    function excluirconsultatempmedico($agenda_exames_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametemp($agenda_exames_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirconsultatempencaixe($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametempencaixe($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$pacientetemp_id");
    }

    function excluirexametempencaixeodontologia($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametempencaixeodontologia($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$pacientetemp_id");
    }

    function excluirexametempencaixe($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametempencaixe($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$pacientetemp_id");
    }

    function examecancelamentoencaixe($agenda_exames_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametempencaixe($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exame/listarmultifuncaomedicofisioterapia");
    }

    function excluirfisioterapiatempencaixe($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametempencaixe($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$pacientetemp_id");
    }

    function excluirfisioterapiatemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametemp($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$pacientetemp_id");
    }

    function excluirfisioterapiatempmultifuncaomedico($agenda_exames_id) {
//        $args = str_replace('!', '=', $url);
//        $args = str_replace('@', '&', $args);
        $this->exametemp->salvaragendamentoexcluido($agenda_exames_id);
        $this->exametemp->excluirexametempmultifuncaomedico($agenda_exames_id);
        redirect(base_url() . "ambulatorio/exame/listarmultifuncaomedicofisioterapia");
    }

    function gravar() {
        $exametemp_tuss_id = $this->exametemp->gravar();
        if ($exametemp_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exametemp");
    }

    function excluirpaciente($paciente_id) {
        $pacienteexame = $this->exametemp->contadorpacienteexame($paciente_id);
        $pacienteagendaexame = $this->exametemp->contadorpaciente($paciente_id);
        $pacienteguia = $this->exametemp->contadorpacienteguia($paciente_id);
        $pacienteconsulta = $this->exametemp->contadorpacienteconsulta($paciente_id);
        $pacientelaudo = $this->exametemp->contadorpacientelaudo($paciente_id);
        if ($pacienteexame != 0 || $pacienteagendaexame != 0 || $pacienteguia != 0 || $pacienteconsulta != 0 || $pacientelaudo != 0) {
            $data['mensagem'] = 'Erro ao excluir o Paciente. Favor verificar pendencias';
        } else {
            $verifica = $this->exametemp->excluirpaciente($paciente_id);
            if ($verifica == "-1") {
                $data['mensagem'] = 'Erro ao excluir o Paciente. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao excluir o Paciente.';
            }
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes");
    }

    function gravartemp() {
        $ambulatorio_pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarexames($ambulatorio_pacientetemp_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarexametemp/$ambulatorio_pacientetemp_id");
    }

    function gravarguiacirurgicaprocedimentos() {
        $guia_id = $_POST['txtguiaid'];
        $procedimento_valor = $this->procedimento->carregavalorprocedimentocirurgico($_POST['procedimento']);
        $_POST['valor'] = $procedimento_valor[0]->valortotal;
//        var_dump($procedimento_valor); die;
        $this->exametemp->gravarguiacirurgicaprocedimentos();
        redirect(base_url() . "ambulatorio/exame/guiacirurgicaitens/$guia_id");
    }

    function carregavalorprocedimentocirurgico() {

        if (isset($_GET['procedimento_id']) && isset($_GET['equipe_id'])) {
            $procedimento_valor = $this->procedimento->carregavalorprocedimentocirurgico($_GET['procedimento_id']);
            $equipe = $this->exame->listarquipeoperadores($_GET['equipe_id']);

            $valorProcedimento = ((float) ($procedimento_valor[0]->valor_total));
            $valorCirurgiao = 0;
            $valorAnestesista = 0;

            foreach ($equipe as $value) {
                if ($value->funcao == '00') {//cirurgiao
                } elseif ($value->funcao == '00') {//anestesista
                }
            }
        }
        return $result;
    }

    function gravarpacienteexametemp($agenda_exames_id) {
        $agenda_id = $_POST['agendaid'];
        if (trim($_POST['convenio1']) == "-1") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar o convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexame/$agenda_id");
        } elseif (trim($_POST['procedimento1']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar o procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexame/$agenda_id");
        } else {
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$paciente_id");
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
            }
        }
    }

    function gravarpacienteexametempgeral($agenda_exames_id) {
//        die;
//        $agenda = $_POST['agendaid'];
        $medico = $_POST['medico'];
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral3/$agenda_exames_id");
        } else {
            $tipo = $this->exametemp->tipomultifuncaogeral($_POST['procedimento1']);
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id, $tipo[0]->tipo);
            if ($paciente_id != 0) {
                redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$paciente_id");
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncaogeral");
            }
        }
    }

    function gravarpacienteagendamultiempresa($agenda_exames_id) {
//        die;
        $tipo = $this->exametemp->tipomultifuncaogeralmultiempresa($_POST['procedimento']);
        $paciente_id = $this->exametemp->gravarpacienteconsultasmultiempresa($agenda_exames_id, $tipo[0]->tipo);

        if ($paciente_id != 0) {
            $data['mensagem'] = 'Consulta agendada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao agendar consulta.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarpacienteconsultatemp($agenda_exames_id) {
//        var_dump($_POST); die;
        if (trim($_POST['txtNome']) == "" && trim($_POST['txtNomeid']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarconsultatemp/$agenda_exames_id");
        } elseif (trim($_POST['convenio']) == "0") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio informar o convênio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarconsultatemp/$agenda_exames_id");
        } elseif (trim($_POST['procedimento']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio informar o procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarconsultatemp/$agenda_exames_id");
        } else {
            $data['medico'] = $this->exametemp->listarmedicoconsulta();
            $paciente_id = $this->exametemp->gravarpacienteconsultas($agenda_exames_id);
            if ($paciente_id != 0) {
                redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$paciente_id");
            } else {
                $data['mensagem'] = 'Erro ao marcar consulta o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncaoconsulta");
            }
        }
    }

    function gravarpacientefisioterapiatemp($agenda_exames_id) {
        if (trim($_POST['txtNome']) == "" && trim($_POST['txtNomeid']) == "") {
            $data['mensagem'] = 'Erro ao marcar especialidade é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } elseif ($_POST['convenio'] == '0') {
            $data['mensagem'] = 'Erro ao marcar especialidade. Selecione um convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } elseif ($_POST['procedimento'] == '') {
            $data['mensagem'] = 'Erro ao marcar especialidade. Selecione um procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {

            $_POST['horarios'] = array_filter($_POST['horarios']);
            $_POST['txtNomeid'] = $this->exametemp->crianovopacienteespecialidade();
            $agrupador = $this->exametemp->agrupadorfisioterapia();
            $agenda_escolhida = array();
            $x = 1;
            foreach ($_POST['horarios'] as $item) {
                $agenda_escolhida [$x] = $item;
                $x++;
            }

            $data['medico'] = $this->exametemp->listarmedicoconsulta();

            if (count($_POST['dia']) > 0 && $_POST['sessao'] > 0) {
                $contador_sessao = $this->exametemp->gravarpacientefisioterapiapersonalizada($_POST['horarios'], $_POST['sessao'], $agrupador);
            }

            $c = 1;
            $semana = 1;

            for ($i = $contador_sessao; $i <= $_POST['sessao']; $i++) {

                $agenda_selecionada = $this->exametemp->listaagendafisioterapiapersonalizada($agenda_escolhida[$c], $semana);

                if ($agenda_selecionada != false) {
                    $this->exametemp->gravarpacientefisioterapiapersonalizadasessao($agenda_selecionada[0]->agenda_exames_id, $_POST['sessao'], $contador_sessao, $agrupador);
                } else {

                    $agenda_inexistente = $this->exametemp->listaagendafisioterapiapersonalizadaerro($agenda_escolhida[$c], $semana);
//                    var_dump($agenda_inexistente); die;
                    $medico = $agenda_inexistente[0]->medico;
                    $hora = $agenda_inexistente[0]->inicio;

                    $data = date("d/m/Y", strtotime($agenda_inexistente[0]->data));
                    $mensagem = "Horário de $medico em $data as $hora não existe ou está ocupado";
//                    echo $mensagem; die;
                    $this->session->set_flashdata('message', $mensagem);

                    foreach ($agenda_escolhida as $item) {
                        $excluir = $this->exametemp->excluirfisioterapiatemp($item);
                    }

                    redirect(base_url() . "ambulatorio/exametemp/carregarfisioterapiatemp/$agenda_escolhida[1]");
                }


                if ($c == count($_POST['horarios'])) {
                    $c = 0;
                    $semana ++;
                }
                $c++;
                $contador_sessao++;
            }

            $paciente_id = $_POST['txtNomeid'];
            $data['mensagem'] = 'Sucesso ao realizar agendamento';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$paciente_id");
//            if (count($_POST['dia']) > 0 && $_POST['sessao'] > 0) {                
//            }
            //LOGICA ANTIGA. AQUI ELE BOTA UM POR SEMANA SE NAO MARCAR NADA LÁ NOS CHECKBOXES
//            else {
//
//                if (isset($_POST['sessao'])) {
//                    $data['agenda_selecionada'] = $this->exametemp->listaagendafisioterapia($agenda_exames_id);
//                    $contaHorarios = count($this->exametemp->contadordisponibilidadefisioterapia($data['agenda_selecionada'][0]));
//
//                    //tratando o numero que veio nas sessoes
//                    if ($_POST['sessao'] == '' || $_POST['sessao'] == null || $_POST['sessao'] == 'null' || $_POST['sessao'] == 0) {
//                        $_POST['sessao'] = 1;
//                    }
//                    $_POST['sessao'] = (int) $_POST['sessao'];
//
//                    //pegando os dias da semana disponiveis
//                    $diaSemana = date("Y-m-d", strtotime($data['agenda_selecionada'][0]->data));
//                    $contador = 0;
//
//                    //definindo array que recebera os selects
//                    $horarios_livres = array();
//
//                    //definindo array que tera os valores filtrados de $horarios_livres
//                    $data['horarios_livres'] = array();
//
//                    do {
//                        $horarios_livres = $this->exametemp->listadisponibilidadefisioterapia($data['agenda_selecionada'][0], $diaSemana);
//                        $diaSemana = date("Y-m-d", strtotime("+1 week", strtotime($diaSemana)));
//                        $contador++;
//
//                        //verificando se a busca veio vazia, caso nao, adciona essa busca a $data['horarios_livres']
//                        if (count($horarios_livres) != 0) {
//                            $data['horarios_livres'][] = $horarios_livres[0];
//                        }
//                        if ($contador == $_POST['sessao']) {
//                            break;
//                        }
//                    } while ($contador < $contaHorarios);
////                var_dump($data['horarios_livres']); die;
//                    //limpando o array
//                    $data['horarios_livres'] = array_filter($data['horarios_livres']);
//
//                    //testando se ha disponibilidade de horario para todas as sessoes
//                    $tothorarios = count($data['horarios_livres']);
//
//                    if ($tothorarios < $_POST['sessao']) {
//                        $data['mensagem'] = "Não há horarios suficientes na agenda para o numero de sessoes escolhido";
//                        $this->session->set_flashdata('message', $data['mensagem']);
//                        redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
//                    }
//
//                    $_POST['txtNomeid'] = $this->exametemp->crianovopacienteespecialidade();
//                    $agrupador = $this->exametemp->agrupadorfisioterapia();
//
//                    //marcando sessoes
//                    if ($_POST['sessao'] == 1) {
//                        $paciente_id = $this->exametemp->gravarpacientefisioterapia($data['agenda_selecionada'][0]->agenda_exames_id);
//                    } else {
//                        $contador_sessao = 1;
//                        for ($i = 0; $i < $_POST['sessao']; $i++) {
//                            $paciente_id = $this->exametemp->gravarpacientefisioterapia($data['horarios_livres'][$i]->agenda_exames_id, $_POST['sessao'], $contador_sessao, $agrupador);
//                            $contador_sessao++;
//                        }
//                    }
//
//                    redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$paciente_id");
//                } else {
//                    $paciente_id = $this->exametemp->gravarpacientefisioterapia($agenda_exames_id);
//                    redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$paciente_id");
//                }
//            }
        }
    }

    function reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data) {
        $paciente_id = $this->exametemp->reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$paciente_id");
    }

    function reservartempgeral($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data) {
        $paciente_id = $this->exametemp->reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$paciente_id");
    }

    function reservarconsultatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        $paciente_id = $this->exametemp->reservarconsultatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$paciente_id");
    }

    function reservarfisioterapiatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        $paciente_id = $this->exametemp->reservarfisioterapiatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$paciente_id");
    }

    function gravarpacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarexames($pacientetemp_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$pacientetemp_id");
    }

    function gravarpacientetempgeral() {

        $pacientetemp_id = $_POST['txtpaciente_id'];

        if ($_POST['data_ficha'] == '' || $_POST['exame'] == '' || $_POST['convenio1'] == '' || $_POST['procedimento1'] == '' || $_POST['horarios'] == '') {
            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
        }
//        elseif ($_POST['txtNome'] == '') {
//            $data['mensagem'] = 'Paciente não informado ou inválido.';
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
//        } 
        else {
            $this->exametemp->gravarpacienteexistentegeral($pacientetemp_id);
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
        }
    }

    function gravarconsultapacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarconsultaspacienteexistente($pacientetemp_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$pacientetemp_id");
    }

    function gravarfisioterapiapacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarfisioterapiapacienteexistente($pacientetemp_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$pacientetemp_id");
//        $this->carregarpacientefisioterapiatemp($pacientetemp_id);
    }

    function gravarfisioterapiapacientetempreagendar() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
//        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapiareangedar();
        $this->exametemp->gravarfisioterapiapacientetempreagendar($pacientetemp_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$pacientetemp_id");
//        $this->carregarpacientefisioterapiatemp($pacientetemp_id);
    }

    function gravarconsultapacientetempreagendar() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
//        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapiareangedar();
        $this->exametemp->gravarconsultapacientetempreagendar($pacientetemp_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$pacientetemp_id");
//        $this->carregarpacientefisioterapiatemp($pacientetemp_id);
    }
    
    function gravargeralpacientetempreagendar() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
//        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapiareangedar();
        $this->exametemp->gravargeralpacientetempreagendar($pacientetemp_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
//        $this->carregarpacientefisioterapiatemp($pacientetemp_id);
    }

    function gravarpaciente() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
        } else {
            $agenda_exames_id = $_POST['horarios'];
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$paciente_id");
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
            }
        }
    }

    function gravarpacienteconsulta() {
        if ((trim($_POST['txtNome']) == "") || (trim($_POST['convenio']) == "0")) {
            $mensagem = 'Erro ao marcar consulta é obrigatorio nome do Paciente e Convenio.';
            $this->session->set_flashdata('message', $mensagem);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $pacientetemp_id = $this->paciente->gravarpacientetemp();
            $this->exametemp->gravarconsultas($pacientetemp_id);
            redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$pacientetemp_id");
        }
    }

    function gravarpacientefisioterapia() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapia");
        } else {
            $pacientetemp_id = $this->paciente->gravarpacientetemp();
            $this->exametemp->gravarfisioterapia($pacientetemp_id);
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$pacientetemp_id");
        }
    }

    function gravarpacienteconsultaencaixe() {
        if (trim($_POST['procedimento']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar um procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } elseif (trim($_POST['convenio']) == "0") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar um convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } elseif (trim($_POST['txtNomeid']) == "" && trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir um Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $pacientetemp_id = $this->exametemp->gravarconsultasencaixe();

//            enviar email
//            $texto = "Consulta agendada para o dia " . $_POST['data_ficha'] . ", com início às " . $_POST['horarios'] . ".";
//            $email = $this->laudo->email($pacientetemp_id);
//            if (isset($email)) {
//                $this->email($email, $texto);
//            }
//            fim enviar email

            redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$pacientetemp_id");
        }
    }

    function email($email, $texto) {
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
        $config['smtp_pass'] = 'DUCOCOFRUTOPCE';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'text';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $this->email->initialize($config);

        $this->email->from('equipe2016gcjh@gmail.com', 'STG Saúde');
        $this->email->to($email);
        $this->email->subject('Consulta Agendada');
        $this->email->message($texto);
        $this->email->send();
//        echo $this->email->print_debugger();
    }

    function gravarpacienteexameencaixe() {
        if (trim($_POST['txtNome']) == "" || $_POST['convenio1'] == "-1") {
            $data['mensagem'] = 'Erro. Obrigatório Convenio e nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
            redirect(base_url() . "ambulatorio/exametemp/novopacienteexameencaixe");
        } else {
            $pacientetemp_id = $this->exametemp->gravarexameencaixe();
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetemp/$pacientetemp_id");
        }
    }

    function gravarpacienteencaixegeral() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteencaixegeral");
        } else {
            $pacientetemp_id = $this->exametemp->gravarexameencaixegeral();
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
        }
    }

    function gravarhorarioexameencaixe() {
        $this->exametemp->gravarhorarioencaixe();
        redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
    }

    function gravarhorarioexameencaixegeral() {
        $this->exametemp->gravarhorarioencaixegeral();
        redirect(base_url() . "ambulatorio/exame/listarmultifuncaogeral");
    }

    function gravarpacientefisioterapiaencaixe() {
        if (trim($_POST['txtNomeid']) == "" && trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir um Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
        } elseif (trim($_POST['convenio']) == "0") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir o covenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
        } elseif (trim($_POST['procedimento']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir o procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
        } elseif (trim($_POST['horarios']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta. É obrigatorio inserir o horario.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
        } else {
//            $disponibilidade = $this->exametemp->contadorhorariosdisponiveisfisioterapia($_POST['data_ficha'], $_POST['horarios'], $_POST['medico']);
//            if ($disponibilidade == 0) {
//            var_dump($_POST); die;
            $pacientetemp_id = $this->exametemp->gravarfisioterapiaencaixe();

            redirect(base_url() . "ambulatorio/exametemp/carregarpacientefisioterapiatemp/$pacientetemp_id");
//            } else {
//                $data['mensagem'] = 'Erro ao marcar consulta. Este horário já está agendado.';
//                $this->session->set_flashdata('message', $data['mensagem']);
//                redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
//            }
        }
    }

    function gravarpacientefisioterapiaencaixemedico() {
        if (trim($_POST['txtNomeid']) == "" && trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir um Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
        } elseif (trim($_POST['convenio']) == "0") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir o covenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
        } elseif (trim($_POST['procedimento']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio inserir o procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
        } elseif (trim($_POST['horarios']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta. É obrigatorio inserir o horario.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
        } else {
//            $disponibilidade = $this->exametemp->contadorhorariosdisponiveisfisioterapia($_POST['data_ficha'], $_POST['horarios'], $_POST['medico']);
//            if ($disponibilidade == 0) {
            $pacientetemp_id = $this->exametemp->gravarfisioterapiaencaixe();

            redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
//            } else {
//                $data['mensagem'] = 'Erro ao marcar consulta. Este horário já está agendado.';
//                $this->session->set_flashdata('message', $data['mensagem']);
//                redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapiaencaixe");
//            }
        }
    }

    function gravapacienteconsultaencaixe() {
        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravaconsultasencaixe($pacientetemp_id);
        redirect(base_url() . "ambulatorio/exametemp/carregarpacienteconsultatemp/$pacientetemp_id");
    }

    private
            function carregarView($data = null, $view = null) {
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
