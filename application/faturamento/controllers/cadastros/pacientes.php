<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class pacientes extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->library('utilitario');
        $this->load->library('email');
        $this->load->library('mensagem');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    public function index() {
        $this->pesquisar();
    }

    public function pesquisar($args = array()) {
        $this->loadView('cadastros/pacientes-lista');
    }

    public function pesquisarsubstituir($args = array()) {
        $data['paciente_temp_id'] = $args;
        $this->loadView('cadastros/pacientes-listasubstituir', $data);
    }

    function novo() {

        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $this->loadView('cadastros/paciente-ficha', $data);
    }

    function substituirambulatoriotemp($paciente_id, $paciente_temp_id) {
        $paciente_id = $this->exametemp->substituirpacientetemp($paciente_id, $paciente_temp_id);
        if ($paciente_id == 0) {
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exametemp");
    }

    function anexarimagem($paciente_id) {

        $this->load->helper('directory');
        if (!is_dir("./upload/paciente/$paciente_id")) {
            mkdir("./upload/paciente/$paciente_id");
            $destino = "./upload/paciente/$paciente_id";
            chmod($destino, 0777);
        }
//        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$paciente_id/");
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/paciente/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['paciente_id'] = $paciente_id;
        $this->loadView('ambulatorio/importacao-imagempaciente', $data);
    }

    function importarimagem() {
        $paciente_id = $_POST['paciente_id'];
        if (!is_dir("./upload/paciente/$paciente_id")) {
            mkdir("./upload/paciente/$paciente_id");
            $destino = "./upload/paciente/$paciente_id";
            chmod($destino, 0777);
        }

        $config['upload_path'] = "/home/sisprod/projetos/clinica/upload/paciente/" . $paciente_id . "/";
//        $config['upload_path'] = "/home/sisprod/projetos/clinica/upload/paciente/" . $paciente_id . "/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt';
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
        $data['paciente_id'] = $paciente_id;
        $this->anexarimagem($paciente_id);
    }

    function excluirimagem($paciente_id, $nome) {

        if (!is_dir("./uploadopm/paciente/$paciente_id")) {
            mkdir("./uploadopm/paciente");
            mkdir("./uploadopm/paciente/$paciente_id");
            $destino = "./uploadopm/paciente/$paciente_id";
            chmod($destino, 0777);
        }

        $origem = "./upload/paciente/$paciente_id/$nome";
        $destino = "./uploadopm/paciente/$paciente_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        $this->anexarimagem($paciente_id);
    }

    function autorizarambulatoriotemp($paciente_id) {

        $resultadoguia = $this->guia->listarguia($paciente_id);
        $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        if ($ambulatorio_guia_id == 0) {
            $ambulatorio_guia_id = $this->guia->gravarguia($paciente_id);
        }
        $teste = $this->exametemp->autorizarpacientetemp($paciente_id, $ambulatorio_guia_id);
        if ($teste == 0) {
//            $this->gerardicom($ambulatorio_guia_id);
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function autorizarambulatoriotempconsulta($paciente_id) {

        $resultadoguia = $this->guia->listarguia($paciente_id);
        $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        if ($ambulatorio_guia_id == 0) {
            $ambulatorio_guia_id = $this->guia->gravarguia($paciente_id);
        }
        $teste = $this->exametemp->autorizarpacientetempconsulta($paciente_id, $ambulatorio_guia_id);
        if ($teste == 0) {
//            $this->gerardicom($ambulatorio_guia_id);
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function autorizarambulatoriotempfisioterapia($paciente_id) {

        $resultadoguia = $this->guia->listarguia($paciente_id);
        $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        if ($ambulatorio_guia_id == 0) {
            $ambulatorio_guia_id = $this->guia->gravarguia($paciente_id);
        }
        $teste = $this->exametemp->autorizarpacientetempfisioterapia($paciente_id, $ambulatorio_guia_id);
        if ($teste == 0) {
//            $this->gerardicom($ambulatorio_guia_id);
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function autorizarambulatoriotempgeral($paciente_id) {

        $resultadoguia = $this->guia->listarguia($paciente_id);
        $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        if ($ambulatorio_guia_id == 0) {
            $ambulatorio_guia_id = $this->guia->gravarguia($paciente_id);
        }
        $teste = $this->exametemp->autorizarpacientetempgeral($paciente_id, $ambulatorio_guia_id);
        if ($teste == 0) {
//            $this->gerardicom($ambulatorio_guia_id);
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function procedimentosubstituir($paciente_id, $paciente_temp_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['paciente_temp_id'] = $paciente_temp_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaragendas($paciente_temp_id);
        $this->loadView('ambulatorio/procedimentosubstituir-form', $data);
    }

    function procedimentoautorizar($paciente_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaragendaspaciente($paciente_id);
        $this->loadView('ambulatorio/procedimentoautorizar-form', $data);
    }

    function procedimentoautorizarconsulta($paciente_id) {
        $data['paciente_id'] = $paciente_id;
        $data['salas'] = $this->exame->listarsalastotal();
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaragendaspacienteconsulta($paciente_id);
        $this->loadView('ambulatorio/procedimentoautorizarconsulta-form', $data);
    }

    function procedimentoautorizarfisioterapia($paciente_id) {
//        $lista = $this->exame->autorizarsessaofisioterapia($paciente_id);
//        if (count($lista) == 0) {
            $data['paciente_id'] = $paciente_id;
            $data['salas'] = $this->exame->listarsalastotal();
            $data['convenio'] = $this->convenio->listardados();
            $data['forma_pagamento'] = $this->guia->formadepagamento();
            $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
            $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
            $data['procedimento'] = $this->procedimento->listarprocedimentos();
            $data['exames'] = $this->exametemp->listaragendaspacientefisioterapia($paciente_id);
            $this->loadView('ambulatorio/procedimentoautorizarfisioterapia-form', $data);
//        } else {
//            $data['mensagem'] = 'Paciente com sessões pendentes.';
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
//        }
    }

    function procedimentoautorizaratendimento($paciente_id) {
        $lista = $this->exame->autorizarsessaofisioterapia($paciente_id);
            $data['paciente_id'] = $paciente_id;
            $data['salas'] = $this->exame->listarsalastotal();
            $data['convenio'] = $this->convenio->listardados();
            $data['medicos'] = $this->operador_m->listarmedicos();
            $data['forma_pagamento'] = $this->guia->formadepagamento();
            $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
            $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
            $data['procedimento'] = $this->procedimento->listarprocedimentos();
            $data['exames'] = $this->exametemp->listaragendaspacienteatendimento($paciente_id);
            $this->loadView('ambulatorio/procedimentoautorizaratendimento-form', $data);
        
    }

    function novosubstituir() {

        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $this->loadView('cadastros/paciente-fichasubstituir', $data);
    }

    function carregar($paciente_id) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['idade'] = 1;
        $this->loadView('cadastros/paciente-ficha', $data);
    }

    function gravar() {
        $contador = $this->paciente->contador();
       if ($_POST['cpf'] != ""){
        $contadorcpf = $this->paciente->contadorcpf();
        }else{
            $contadorcpf = 0;
        }
        
        if ($contador == 0 && $contadorcpf == 0) {
            if ($paciente_id = $this->paciente->gravar()) {
                $data['mensagem'] = 'Paciente gravado com sucesso';
            } else {
                $data['mensagem'] = 'Erro ao gravar paciente';
            }
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
        } elseif ($contador > 0 && $_POST['paciente_id'] != "") {
            if ($paciente_id = $this->paciente->gravar()) {
                $data['mensagem'] = 'Paciente gravado com sucesso';
            } else {
                $data['mensagem'] = 'Erro ao gravar paciente';
            }
        } elseif ($contador == 0 && $contadorcpf == 1 && $_POST['paciente_id'] != "") {
            if ($paciente_id = $this->paciente->gravar()) {
                $data['mensagem'] = 'Paciente gravado com sucesso';
            } else {
                $data['mensagem'] = 'Erro ao gravar paciente';
            }
        } else {
            $data['mensagem'] = 'Paciente ja cadastrado';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes");
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
    }

    public function pesquisarprocedimento($args = array()) {
        $this->loadView('cadastros/procedimento-lista');
    }

    public function pesquisarpacientecenso($args = array()) {
        $this->loadView('cadastros/censoprocedimento-lista');
    }

    public function listarpacientecenso($args = array()) {
        $operador = $this->session->userdata('operador_id');

        if ($operador == 100) {
            $data['paciente'] = $this->paciente->relatoriopacientecensosuper();
            $data['demanda'] = $this->paciente->relatoriodemandadiretoria();
            $data['data'] = date("Ydm");
            $this->load->View('cadastros/relatoriodirecao-lista', $data);
        } else {
            $data['paciente'] = $this->paciente->relatoriopacientecenso($operador);
            $data['demanda'] = $this->paciente->relatoriodemandadiretoria();
            $data['data'] = date("Ydm");
            $this->load->View('cadastros/relatoriodirecao-lista', $data);
        }
    }

    function pesquisarbe($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-be');
    }

    function pesquisarbectq($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-bectq');
    }

    function pesquisarbegiah($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-begiah');
    }

    function pesquisarbeapac($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-beapac');
    }

    function pesquisarbeacolhimento($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-beacolhimento');
    }

    function formulariobeacolhimento($args = array()) {
        $this->loadView('cadastros/pacientesformulario-beacolhimento');
    }

    function pesquisarfaturamentohospub($args = array()) {
        $this->loadView('cadastros/faturamentohospub');
    }

    function pesquisarfaturamentohospubinternado($args = array()) {
        $this->loadView('cadastros/faturamentohospubinternado');
    }

    function pesquisarfaturamentohospubetiqueta($args = array()) {
        $this->loadView('cadastros/faturamentohospubetiqueta');
    }

    function pesquisarsamecomparecimento($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-samecomparecimento');
    }

    function pesquisarfaturamentomensal($args = array()) {
        $this->loadView('cadastros/consulta-faturamentomensal');
    }

    function pesquisarcensohospub($args = array()) {
        if ($this->utilitario->autorizar(23, $this->session->userdata('modulo')) == true) {
            $data['clinicas'] = $this->paciente->listarclinicashospub();
            $this->loadView('cadastros/censohospub', $data);
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    function pesquisarcensohospubstatus($args = array()) {

        if ($this->utilitario->autorizar(21, $this->session->userdata('modulo')) == true) {
            $data['clinicas'] = $this->paciente->listarclinicashospub();
            $this->loadView('cadastros/censohospub_status', $data);
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    function consultacpf($args = array()) {
        $data['cpf'] = $this->paciente->consultacpf();
        $competencia = str_replace("/", "", $_POST['txtcompetencia']);
        $valida = $this->paciente->verificaproducaomedica($competencia);
        if ($valida == 0) {
            foreach ($data['cpf'] as $value) {
                $cpf = substr($value['IC0CPF'], 1, 12);
                $nome = $value['IC0NOMGUE'];
                $crm = $value['IC0ICR'];
                $this->paciente->consultaprocedimento($cpf, $nome, $competencia, $crm);
            }
        }
        $this->gerarelatoriofaturamento($competencia);
    }

    function consultapacientes() {
        $municipio = '2304400';
        $this->paciente->listapacientes($municipio);
    }

    function gerarelatoriofaturamento($competencia) {
        $data['ponto'] = $this->paciente->listarProcedimentosPontos($competencia);
        $data['lista'] = $this->paciente->listarfaturamentomensal($competencia);
//                echo "<pre>";
//                var_dump($data['lista']);
//                echo "</pre>";
//                die;
        $this->load->View('cadastros/producaomedica', $data);
    }

    function samelistacomparecimento() {
        $data['lista'] = $this->paciente->samelistahospub();
        $this->loadView('cadastros/paciente-samelistacomparecimento', $data);
    }

    function samecomparecimento($registro, $datainternacao) {
        $data['paciente'] = $this->paciente->samehospub($registro, $datainternacao);
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->loadView('cadastros/paciente-samecomparecimento', $data);
    }

    function pesquisabecircunstanciado($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-becircunstaciado');
    }

    function listarcircunstanciado($args = array()) {
        $this->loadView('cadastros/pacientes-relatoriocircunstanciadolista');
    }

    public function impressaocircunstanciado() {
        $data['paciente'] = $this->paciente->conection();
        $this->loadview('cadastros/paciente-becircunstaciado', $data);
    }

    function relatoriocircunstanciado() {
        $id = $this->paciente->gravarcircunstanciado();
        $data['paciente'] = $this->paciente->relatoriobecircunstanciado($id);
        $this->load->view('cadastros/paciente-becircunstaciadoimpressao', $data);
    }

    function impressaorelatoriocircunstanciado($id) {
        $data['paciente'] = $this->paciente->relatoriobecircunstanciado($id);
        $this->load->view('cadastros/paciente-becircunstaciadoimpressao_1', $data);
    }

    function samecomparecimentoimpressao($registro, $datainternacao) {
        $data['paciente'] = $this->paciente->samehospubimpressao($registro, $datainternacao);
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->load->view('cadastros/paciente-samecomparecimentoimpressao', $data);
    }

    function faturamentohospubetiqueta() {
        $data['paciente'] = $this->paciente->faturamentohospub();
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->load->view('cadastros/paciente-faturamentohospubetiqueta', $data);
    }

    function faturamentohospub() {
        $data['paciente'] = $this->paciente->faturamentohospub();
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->load->view('cadastros/paciente-faturamentohospub', $data);
    }

    function faturamentohospubinternado() {
        $data['paciente'] = $this->paciente->faturamentohospubinternado();
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->load->view('cadastros/paciente-faturamentohospubinternado', $data);
    }

    function formularioacolhimento() {
        $data['paciente'] = $this->paciente->conection();
        $this->load->view('cadastros/paciente-formularioacolhimento', $data);
    }

    function atualizacao() {
        $data = $this->paciente->listaAtualizar();

        foreach ($data as $value) {
            $this->paciente->atualizar($value->be);
        }
        $this->loadView('cadastros/pacientesconsulta-be');
    }

    public function impressaobe() {
        $data['paciente'] = $this->paciente->conection();
        $this->load->view('cadastros/paciente-impressaobe', $data);
    }

    public function impressaobectq() {
        $data['paciente'] = $this->paciente->conectionctq();
        $this->load->view('cadastros/paciente-formularioacolhimentoctq', $data);
    }

    public function impressaoacolhimento() {
        $data['paciente'] = $this->paciente->conection();
        $this->load->view('cadastros/paciente-impressaoacolhimento', $data);
    }

    public function impressaobegiah() {
        $data['paciente'] = $this->paciente->conection();
        $this->load->view('cadastros/paciente-impressaobegiah', $data);
    }

    public function impressaoabeapac() {
        $data['paciente'] = $this->paciente->apac();
        $this->load->view('cadastros/paciente-impressaobeapac', $data);
    }

    public function impressaocensohospub() {
        if ($this->utilitario->autorizar(21, $this->session->userdata('modulo')) == true) {
            $clinica = $_POST['txtclinica'];
            $data['paciente'] = $this->paciente->censohospub($clinica);
            $data['leitos'] = $this->paciente->listarleitoshospub($clinica);
            $clinicadescricao = $data['paciente']["0"]["C14NOMEC"];
            $this->paciente->deletarclinicas($clinicadescricao);
            foreach ($data['paciente'] as $value) {
                $this->paciente->gravarcensoclinicas($value);
            }
            $data['procedimentos'] = $this->paciente->listarProcedimentos();
            $data['risco1'] = $this->paciente->listarpacienterisco1();
            $data['risco2'] = $this->paciente->listarpacienterisco2();
            $data['corredor'] = $this->paciente->listarpacientecorredor();
            $capitalfortaleza = $this->paciente->listarpacientemunicipio();
            $data['capitalfortaleza'] = $capitalfortaleza['0']->count;
            $data['procedimentopaciente'] = $this->paciente->listarpacientecenso();
            $data['data'] = date("Ydm");

            $this->load->view('cadastros/impressao-censo', $data);
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    public function impressaocensohospubstatus() {
        if ($this->utilitario->autorizar(21, $this->session->userdata('modulo')) == true) {
            $clinica = $_POST['txtclinica'];
            $data['paciente'] = $this->paciente->censohospub($clinica);
            $data['leitos'] = $this->paciente->listarleitoshospub($clinica);
            $data['procedimentos'] = $this->paciente->listarProcedimentos();
            $data['procedimentopaciente'] = $this->paciente->listarpacientecenso();
            $clinicadescricao = $data['paciente']["0"]["C14NOMEC"];
            $pacienteativos = $this->paciente->listarpacienteporclinicas($clinicadescricao);
            foreach ($pacienteativos as $value) {
                $verificador = 0;
                foreach ($data['paciente'] as $item) {

                    if ($value->prontuario == trim($item['IB6REGIST'])) {
                        $verificador = 1;
                    }
                }
                if ($verificador == 0) {
                    $this->paciente->atualizarpacienteporclinicas($value->prontuario);
                }
            }
            $data['data'] = date("Ydm");
            $this->load->view('cadastros/impressao-censostatus', $data);
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    function novademanda() {
        $this->loadView('cadastros/demandasdiretorias-ficha');
    }

    function gravardemanda() {

        if ($this->paciente->gravardemanda()) {
            $data['mensagem'] = 'Demanda gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar demanda';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes/listarpacientecenso");
    }

    function atualizardemanda($demanda_id) {

        $this->paciente->atualizardemanda($demanda_id);
        redirect(base_url() . "cadastros/pacientes/listarpacientecenso");
    }

    function gravarpacientecenso() {
        if ($this->paciente->gravarpacientecenso()) {
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes/pesquisarpacientecenso");
    }

    function carregarprocedimento($procedimento) {
        $data['procedimento'] = $this->paciente->instanciarprocedimento($procedimento);
        $this->loadView('cadastros/procedimento-ficha', $data);
    }

    function carregarpacientecenso($prontuario = null, $nome = null, $procedimento = null, $procedimentodescricao = null, $unidade = null) {
        $data['prontuario'] = $prontuario;
        $data['nome'] = $nome;
        $data['procedimento'] = $procedimento;
        $data['procedimentodescricao'] = $procedimentodescricao;
        $data['status'] = null;
        $data['unidade'] = $unidade;
        $dados = $this->paciente->instanciarpacientecenso($prontuario);
        if ($dados != null) {
            $data['prontuario'] = $dados['prontuario'];
            $data['nome'] = $dados['nome'];
            $data['procedimento'] = $dados['procedimento'];
            $data['procedimentodescricao'] = $dados['descricao_resumida'];
            $data['status'] = $dados['status'];
        }
        $this->loadView('cadastros/censoprocedimento-ficha', $data);
    }

    function carregarpacientecensostatus($prontuario, $nome = null, $procedimento = null, $procedimentodescricao = null, $unidade = null) {
        $data['prontuario'] = $prontuario;
        $data['nome'] = $nome;
        $data['procedimento'] = $procedimento;
        $data['procedimentodescricao'] = $procedimentodescricao;
        $data['status'] = null;
        $data['unidade'] = $unidade;
        $dados = $this->paciente->instanciarpacientecenso($prontuario);
        if ($dados != null) {
            $data['prontuario'] = $dados['prontuario'];
            $data['nome'] = $dados['nome'];
            $data['procedimento'] = $dados['procedimento'];
            $data['procedimentodescricao'] = $dados['descricao_resumida'];
            $data['status'] = $dados['status'];
        }
        $this->loadView('cadastros/censoprocedimento-fichastatus', $data);
    }

    function atualizaprocedimento() {

        if ($this->paciente->atualizaProcedimentos()) {
            $data['mensagem'] = 'Erro ao gravar procedimento';
        } else {
            $data['mensagem'] = 'Procedimento gravado com sucesso';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes/pesquisarprocedimento");
    }
    
    
    function gerardicom($guia_id) {
        $exame = $this->exame->listardicom($guia_id);

        $grupo = $exame[0]->grupo;
        if ($grupo == 'RX' ||$grupo == 'MAMOGRAFIA') {
            $grupo = 'CR';
        }
        if ($grupo == 'RM') {
            $grupo = 'MR';
        }
        $data['titulo'] = "AETITLE";
        $data['data'] = str_replace("-", "", date("Y-m-d"));
        $data['hora'] = str_replace(":", "", date("H:i:s"));
        $data['tipo'] = $grupo;
        $data['tecnico'] = $exame[0]->tecnico;
        $data['procedimento'] = $exame[0]->procedimento;
        $data['procedimento_tuss_id'] = $exame[0]->codigo;
        $data['procedimento_tuss_id_solicitado'] = $exame[0]->codigo;
        $data['procedimento_solicitado'] = $exame[0]->procedimento;
        $data['identificador_id'] = $guia_id;
        $data['pedido_id'] = $guia_id;
        $data['solicitante'] = $exame[0]->convenio;
        $data['referencia'] = "";
        $data['paciente_id'] = $exame[0]->paciente_id;
        $data['paciente'] = $exame[0]->paciente;
        $data['nascimento'] = str_replace("-", "", $exame[0]->nascimento);
        $data['sexo'] = $exame[0]->sexo;
        $this->exame->gravardicom($data);
    }

}

?>
