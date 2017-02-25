<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class centrocirurgico extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('emergencia/solicita_acolhimento_model', 'acolhimento');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('internacao/internacao_model', 'internacao_m');
        $this->load->model('internacao/unidade_model', 'unidade_m');
        $this->load->model('internacao/motivosaida_model', 'motivosaida');
        $this->load->model('internacao/enfermaria_model', 'enfermaria_m');
        $this->load->model('internacao/leito_model', 'leito_m');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('internacao/solicitainternacao_model', 'solicitacaointernacao_m');
        $this->load->model('centrocirurgico/centrocirurgico_model', 'centrocirurgico_m');
        $this->load->model('centrocirurgico/solicita_cirurgia_model', 'solicitacirurgia_m');
        $this->load->library('utilitario');
    }

    public function index() {
        $this->pesquisar();
    }

    public function pesquisar($args = array()) {
        $this->loadView('centrocirurgico/listarsolicitacao');
    }

    public function pesquisarsaida($args = array()) {
        $this->loadView('internacao/listarsaida');
    }

    public function pesquisarunidade($args = array()) {
        $this->loadView('internacao/listarunidade');
    }

    public function pesquisarcirurgia($args = array()) {
        $this->loadView('centrocirurgico/listarcirurgia');
    }

    public function pesquisarsolicitacaointernacao($args = array()) {
        $this->loadView('internacao/listarsolicitacaointernacao');
    }

    public function pesquisarhospitais($args = array()) {
        $this->loadView('centrocirurgico/hospital-lista');
    }

    public function pesquisarequipecirurgica($args = array()) {
        $this->loadView('centrocirurgico/equipecirurgica-lista');
    }

    function solicitacirurgia($internacao_id) {
        $data['paciente'] = $this->solicitacirurgia_m->solicitacirurgia($internacao_id);
        $this->loadView('centrocirurgico/solicitacirurgia', $data);
    }

    function gravarsolicitacaocirurgia() {

        if ($this->solicitacirurgia_m->gravarsolicitacaocirurgia()) {
            $data['mensagem'] = 'Erro ao efetuar solicitação de cirurgia';
        } else {
            $data['mensagem'] = 'Solicitação de Cirurgia efetuada com Sucesso';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function autorizarcirurgia() {
        $this->centrocirurgico_m->autorizarcirurgia();
        $data['mensagem'] = 'Autorizacao efetuada com Sucesso';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function excluirsolicitacaocirurgia($solicitacao_id) {
        $this->solicitacirurgia_m->excluirsolicitacaocirurgia($solicitacao_id);
        $data['mensagem'] = 'Solicitacao excluida com sucesso';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function excluirsolicitacaoprocedimento($solicitacao_procedimento_id, $solicitacao) {
        $this->solicitacirurgia_m->excluirsolicitacaoprocedimento($solicitacao_procedimento_id);
        $data['mensagem'] = 'Procedimento removido com sucesso';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacao/$solicitacao");
    }

    function novo($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);

        $horario = date(" Y-m-d H:i:s");

        $hour = substr($horario, 11, 3);
        $minutes = substr($horario, 15, 2);
        $seconds = substr($horario, 18, 4);

        $this->loadView('emergencia/solicitacoes-paciente', $data);
    }

    function carregar($emergencia_solicitacao_acolhimento_id) {
        $obj_paciente = new paciente_model($emergencia_solicitacao_acolhimento_id);
        $data['obj'] = $obj_paciente;
        $this->loadView('emergencia/solicita-acolhimento-ficha', $data);
    }

    function carregarunidade($internacao_unidade_id) {
        $obj_paciente = new unidade_model($internacao_unidade_id);
        $data['obj'] = $obj_paciente;
        $this->loadView('internacao/cadastrarunidade', $data);
    }

    function carregarmotivosaida($internacao_motivosaida_id) {
        $obj_paciente = new motivosaida_model($internacao_motivosaida_id);
        $data['obj'] = $obj_paciente;
        $this->loadView('internacao/cadastrarmotivosaida', $data);
    }

    function carregarenfermaria($internacao_enfermaria_id) {
        $obj_paciente = new enfermaria_model($internacao_enfermaria_id);
        $data['obj'] = $obj_paciente;
        $this->loadView('internacao/cadastrarenfermaria', $data);
    }

    function carregarleito($internacao_leito_id) {
        $obj_paciente = new leito_model($internacao_leito_id);
        $data['obj'] = $obj_paciente;
        $this->loadView('internacao/cadastrarleito', $data);
    }

    function mostraautorizarcirurgia($solicitacao_id) {
        $data['solicitacao'] = $this->centrocirurgico_m->pegasolicitacaoinformacoes($solicitacao_id);
        $data['leito'] = $this->solicitacirurgia_m->listaleitocirugia();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['salas'] = $this->centrocirurgico_m->listarsalas();
        $this->loadView('centrocirurgico/autorizarcirurgia', $data);
    }

    function impressaoorcamento($solicitacao_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['nomes'] = $this->solicitacirurgia_m->buscarnomesimpressao($solicitacao_id);
        $data['empresa'] = $this->solicitacirurgia_m->burcarempresa($solicitacao_id);
        $data['contador_impressao'] = $this->solicitacirurgia_m->impressaoorcamento($solicitacao_id);
        $data['funcoes'] = $this->solicitacirurgia_m->listarfuncoes();
        $this->load->view('centrocirurgico/impressaoorcamento', $data);
    }

    function adicionarprocedimentos($solicitacao) {
        $data['solicitacao'] = $solicitacao;
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacao/$solicitacao");
    }

    function cadastrarequipe() {
        $this->loadView("centrocirurgico/equipecirurgica-form");
    }

//    function adicionarprocedimentosdecisao() {
////        if ($_POST['escolha'] == "SIM") {
//            $solicitacao = $_POST['solicitacao_id'];
//            redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacao/$solicitacao");
////        } else {
////            redirect(base_url() . "centrocirurgico/centrocirurgico/centrocirurgico");
////        }
//    }

    function gravarnovasolicitacao() {
        if ($_POST["txtNomeid"] == "") {
            $data['mensagem'] = 'Paciente escolhido não é válido';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "centrocirurgico/centrocirurgico/novasolicitacao/0");
        } else {
            $solicitacao = $this->solicitacirurgia_m->gravarnovasolicitacao();
            if ($solicitacao == -1) {
                $data['mensagem'] = 'Erro ao efetuar Solicitacao';
            } else {
                $data['mensagem'] = 'Solicitacao efetuada com Sucesso';
//            var_dump($solicitacao);
            }
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "centrocirurgico/centrocirurgico/adicionarprocedimentos/$solicitacao");
        }
    }

    function gravarsolicitacaoprocedimentos() {
        $solicitacao = $_POST['solicitacao_id'];

        if ($_POST['tipo'] == 'procedimento') {
            if ($_POST['procedimentoID'] != '') {
                $verifica = count($this->solicitacirurgia_m->verificasolicitacaoprocedimentorepetidos());
                if ($verifica == 0) {
                    if ($this->solicitacirurgia_m->gravarsolicitacaoprocedimento()) {
                        $data['mensagem'] = 'Procedimento adicionado com Sucesso';
                    } else {
                        $data['mensagem'] = 'Erro ao gravar Procedimento';
                    }
                    $this->session->set_flashdata('message', $data['mensagem']);
                    redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacao/$solicitacao");
                }
            } else {
                $data['mensagem'] = 'Erro ao gravar Procedimento. Procedimento nao selecionado ou invalido.';
            }
        } elseif ($_POST['tipo'] == 'agrupador') {
            $procedimentos = $this->solicitacirurgia_m->listarprocedimentosagrupador($_POST['agrupador_id']);
            foreach ($procedimentos as $item) {
                $_POST['procedimentoID'] = $item->procedimento_id;
                $verifica = count($this->solicitacirurgia_m->verificasolicitacaoprocedimentorepetidos());
                if ($verifica == 0) {
                    $this->solicitacirurgia_m->gravarsolicitacaoprocedimento();
                }
            }
        }
        
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacao/$solicitacao");
    }

    function carregarsolicitacao($solicitacao_id) {

        $data['solicitacao_id'] = $solicitacao_id;
        $data['dados'] = $this->centrocirurgico_m->listarsolicitacoes()->where('solicitacao_cirurgia_id', $solicitacao_id)->get()->result();
        $data['procedimento'] = $this->solicitacirurgia_m->carregarsolicitacaoprocedimento();
        $data['agrupador'] = $this->solicitacirurgia_m->carregarsolicitacaoagrupador();
        $data['procedimentos'] = $this->solicitacirurgia_m->listarsolicitacaosprocedimentos($solicitacao_id);
        $this->loadView('centrocirurgico/solicitacaoprocedimentos-form', $data);
    }

    function carregarhospital($hospital_id) {

        $data['hospital_id'] = $hospital_id;
        $data['hospital'] = $this->centrocirurgico_m->instanciarhospitais($hospital_id);
//        echo "<pre>";var_dump($data['hospital'] );die;
        $this->loadView('centrocirurgico/hospital-form', $data);
    }

    function gravarequipeoperadores($equipe_id) {
        $equipe_id = $_POST['equipe_id'];
        $this->centrocirurgico_m->gravarequipeoperadores();
        redirect(base_url() . "centrocirurgico/centrocirurgico/montarequipe/$equipe_id");
    }

    function gravarhospital() {
        $hospital_id = $this->centrocirurgico_m->gravarhospital();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar Hospital. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Hospital.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisarhospitais");
    }

    function excluirhospital($hospital_id) {
        $this->centrocirurgico_m->excluirhospital($hospital_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisarhospitais");
    }

    function excluiritemorcamento($orcamento_id, $solicitacao_id, $convenio_id) {
        $this->solicitacirurgia_m->excluiritemorcamento($orcamento_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/solicitacarorcamento/$solicitacao_id/$convenio_id");
    }

    function excluiritemequipe($cirurgia_operadores_id, $equipe_id) {
        $this->solicitacirurgia_m->excluiritemequipe($cirurgia_operadores_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/montarequipe/$equipe_id");
    }

    function liberar($solicitacao_id, $orcamento) {
        if ($this->centrocirurgico_m->liberarsolicitacao($solicitacao_id, $orcamento)) {
            $data['mensagem'] = "LIBERADO!";
        } else {
            $data['mensagem'] = "Falha ao realizar Liberação!";
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function orcamentopergunta($solicitacao_id, $convenio_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['convenio_id'] = $convenio_id;
        $teste = $this->centrocirurgico_m->verificasituacao($solicitacao_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/solicitacarorcamento/$solicitacao_id/$convenio_id");
    }

    function orcamentoescolha($solicitacao_id, $convenio_id) {
        if ($_POST['escolha'] == 'SIM') {
            $this->centrocirurgico_m->alterarsituacaoorcamento($solicitacao_id);
            redirect(base_url() . "centrocirurgico/centrocirurgico/solicitacarorcamento/$solicitacao_id/$convenio_id");
        } else {
            $this->centrocirurgico_m->alterarsituacaoorcamentodisnecessario($solicitacao_id);
            redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
        }
    }

    function novasolicitacaoconsulta($exame_id) {
        $data['paciente'] = $this->solicitacirurgia_m->solicitacirurgiaconsulta($exame_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('centrocirurgico/novasolicitacao', $data);
    }

    function novasolicitacao($solicitacao_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['convenio'] = $this->procedimentoplano->listarconveniocirurgiaorcamento();
        if ($solicitacao_id != '0') {
//        $data['solicitacao']= $this->centrocirurgico_m->pegasolicitacaoinformacoes($solicitacao_id);
//        $data['leito']= $this->solicitacirurgia_m->listaleitocirugia();
        }

        $this->loadView('centrocirurgico/novasolicitacao', $data);
    }

    function finalizarorcamento($solicitacao_id) {
        if ($this->centrocirurgico_m->finalizarrcamento($solicitacao_id)) {
            $data['mensagem'] = "Orçamento Finalizado";
        } else {
            $data['mensagem'] = "ERRO: Orçamento NÃO Finalizado";
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function solicitacarorcamento($solicitacao_id, $convenio_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['convenio_id'] = $convenio_id;

        $data['convenio'] = $this->procedimentoplano->listarconveniocirurgiaorcamento();
        $data['procedimentos'] = $this->solicitacirurgia_m->listarprocedimentoscirurgia($solicitacao_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['funcoes'] = $this->solicitacirurgia_m->listarfuncoes();
        $data['procedimentos_orcamentados'] = $this->solicitacirurgia_m->listarprocedimentos_orcamentados($solicitacao_id);
        $this->loadView('centrocirurgico/solicitacarorcamento-form', $data);
    }

    function montarequipe($equipe_id) {
        $data['equipe_id'] = $equipe_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['equipe'] = $this->solicitacirurgia_m->listarequipe($equipe_id);
        $data['equipe_operadores'] = $this->solicitacirurgia_m->listarequipeoperadores($equipe_id);
//        echo "<pre>";var_dump($data['equipe_operadores'] );die;
        $this->loadView('centrocirurgico/montarequipe-form', $data);
    }

    function gravarequipe() {
        $equipe_id = $this->solicitacirurgia_m->gravarequipe();
        redirect(base_url() . "centrocirurgico/centrocirurgico/montarequipe/$equipe_id");
    }

    function finalizarrequipe($solicitacao_id) {
        $this->centrocirurgico_m->finalizarequipe($solicitacao_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function gravarsolicitacaorcamento() {
//        $verifica = $this->solicitacirurgia_m->gravarnovasolicitacao();
        $this->solicitacirurgia_m->gravarsolicitacaorcamento();

        $solicitacao_id = $_POST['solicitacao_id'];
        $convenio_id = $_POST['convenio_id'];
        redirect(base_url() . "centrocirurgico/centrocirurgico/solicitacarorcamento/$solicitacao_id/$convenio_id");
    }

    function internacaoalta($internacao_id) {

        $data['resultado'] = $this->internacao_m->internacaoalta($internacao_id);
    }

}

?>
