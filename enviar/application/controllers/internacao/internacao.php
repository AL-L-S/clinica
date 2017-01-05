<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class internacao extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('emergencia/solicita_acolhimento_model', 'acolhimento');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/laudo_model', 'laudo_m');
        $this->load->model('internacao/internacao_model', 'internacao_m');
        $this->load->model('internacao/unidade_model', 'unidade_m');
        $this->load->model('internacao/motivosaida_model', 'motivosaida');
        $this->load->model('internacao/enfermaria_model', 'enfermaria_m');
        $this->load->model('internacao/leito_model', 'leito_m');
        $this->load->model('internacao/solicitainternacao_model', 'solicitacaointernacao_m');
        $this->load->library('utilitario');
    }

    public function index() {

        $this->pesquisar();
    }

    public function pesquisar($args = array()) {

        $this->loadView('internacao/listarinternacao');
    }

    public function pesquisarsaida($args = array()) {
        $this->loadView('internacao/listarsaida');
    }

    public function pesquisarunidade($args = array()) {
        $this->loadView('internacao/listarunidade');
    }

    public function pesquisarenfermaria($args = array()) {
        $this->loadView('internacao/listarenfermaria');
    }

    public function pesquisarleito($args = array()) {
        $this->loadView('internacao/listarleito');
    }

    public function pesquisarmotivosaida($args = array()) {
        $this->loadView('internacao/listarmotivosaida');
    }

    public function pesquisarsolicitacaointernacao($args = array()) {
        $this->loadView('internacao/listarsolicitacaointernacao');
    }

    function novo($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);

        $horario = date(" Y-m-d H:i:s");

        $hour = substr($horario, 11, 3);
        $minutes = substr($horario, 15, 2);
        $seconds = substr($horario, 18, 4);

        $this->loadView('emergencia/solicitacoes-paciente', $data);
    }

    function listarinternacao() {

        $data['paciente'] = $this->internacao_m->listar();
        echo var_dump($data['paciente']);
        die;

        $horario = date(" Y-m-d H:i:s");

        $hour = substr($horario, 11, 3);
        $minutes = substr($horario, 15, 2);
        $seconds = substr($horario, 18, 4);

        $this->loadView('emergencia/solicitacoes-paciente', $data);
    }

    function acoes($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['internacao'] = $this->internacao_m->listarinternacao($paciente_id);
        $data['leitos'] = $this->internacao_m->listarleitosinternacao($paciente_id);
//        echo '<pre>';
//        var_dump($data['internacao']);
//        die;
        $data['paciente_id'] = $paciente_id;
        $horario = date(" Y-m-d H:i:s");

        $hour = substr($horario, 11, 3);
        $minutes = substr($horario, 15, 2);
        $seconds = substr($horario, 18, 4);

        $this->loadView('internacao/acoes-paciente', $data);
    }

    function novointernacao($paciente_id) {
        $data['numero'] = $this->internacao_m->verificainternacao($paciente_id);
//        var_dump($data['numero']);
//        die;
        if ($data['numero'] == 0) {
            $data['paciente'] = $this->paciente->listardados($paciente_id);
//            if ($data['paciente'][0]->cep == '' || $data['paciente'][0]->cns == '') {
//                $data['mensagem'] = 'CEP ou CNS obrigatorio';
//                $this->session->set_flashdata('message', $data['mensagem']);
//                redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
//            }
            $data['paciente_id'] = $paciente_id;
            $this->loadView('internacao/cadastrarinternacao', $data);
        } else {
            $data['mensagem'] = 'Paciente ja possui internacao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "internacao/internacao/");
        }
    }

    function novointernacaonutricao($paciente_id) {
        $data['numero'] = $this->internacao_m->verificainternacao($paciente_id);
//        var_dump($data['numero']);
//        die;
        if ($data['numero'] == 0) {
            $data['paciente'] = $this->paciente->listardados($paciente_id);
            $data['unidade'] = $this->internacao_m->listaunidade();
//            if ($data['paciente'][0]->cep == '' || $data['paciente'][0]->cns == '') {
//                $data['mensagem'] = 'CEP ou CNS obrigatorio';
//                $this->session->set_flashdata('message', $data['mensagem']);
//                redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
//            }
            $data['paciente_id'] = $paciente_id;
            $this->loadView('internacao/cadastrarinternacaonutricao', $data);
        } else {
            $data['mensagem'] = 'Paciente ja possui internacao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "internacao/internacao/pesquisar");
        }
    }

    function movimentacao($paciente_id) {

        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $leito = $this->internacao_m->listarleitosinternacao($paciente_id);

        $p = count($leito);
        $i = $p - 1;
        $data['leito'] = $leito["$i"]->leito_id;

        $data['paciente_id'] = $paciente_id;
        $this->loadView('internacao/movimentacao', $data);
    }

    function pacientesinternados($condicao) {
        $data['unidades'] = $this->unidade_m->listaunidadepacientes();
        if ($condicao != 'Todas') {
            $data['unidades'] = $this->internacao_m->listaunidadecondicao($condicao);
        }
        $this->loadView('internacao/pacientesinternados', $data);
    }

    function mostraenfermarialeito($unidade) {
        $data['enfermaria'] = $this->unidade_m->listaenfermariaunidade($unidade);
        $data['leitos'] = $this->unidade_m->listaleitounidade();
        $this->loadView('internacao/mostraenfermarialeito', $data);
    }

    function mostrafichapaciente($leito_id) {
        $data['paciente'] = $this->unidade_m->mostrafichapaciente($leito_id);
        $this->loadView('internacao/mostrafichapaciente', $data);
    }

    function mostrarnovasaidapaciente($internacao_id) {
        $data['paciente'] = $this->motivosaida->mostrarnovasaidapaciente($internacao_id);
        $data['saida'] = $this->motivosaida->listamotivosaida();
        $this->loadView('internacao/mostrarnovasaidapaciente', $data);
    }

    function mostrarsaidapaciente($internacao_id) {
        $data['paciente'] = $this->motivosaida->mostrarsaidapaciente($internacao_id);
        $this->loadView('internacao/mostrarsaidapaciente', $data);
    }

    function novounidade() {

        $this->loadView('internacao/cadastrarunidade');
    }

    function novoenfermaria() {

        $this->loadView('internacao/cadastrarenfermaria');
    }

    function novoleito() {

        $this->loadView('internacao/cadastrarleito');
    }

    function pesquisarevolucao($internacao_id) {

        $data['internacao_id'] = $internacao_id;
        $data['lista'] = $this->internacao_m->listarEvolucao($internacao_id);

        $this->loadView('internacao/internacao-lista-evolucao', $data);
    }

    function imprimirevolucaointernacao($internacao_evolucao_id) {
        
        $data['lista'] = $this->internacao_m->imprimirevolucaointernacao($internacao_evolucao_id);
        $data['empresa'] = $this->internacao_m->empresa();
//        echo var_dump($data['lista']); die;
        $this->load->View('internacao/internacao-imprimirrae', $data);
    }
    
    function novoevolucaointernacao($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $this->loadView('internacao/evolucaointernacao', $data);
    }

    function novomotivosaida() {

        $this->loadView('internacao/cadastrarmotivosaida');
    }

    function novosolicitacaointernacao($paciente_id) {
        $data['numero'] = $this->solicitacaointernacao_m->verificasolicitacao($paciente_id);
//        var_dump($data['numero']);
//        die;
        if ($data['numero'] == 0) {
            $data['paciente'] = $this->paciente->listardados($paciente_id);
            $data['paciente_id'] = $paciente_id;
            $this->loadView('internacao/cadastrarsolicitacaointernacao', $data);
        } else {
            $data['mensagem'] = 'Paciente ja possui solicitacao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "internacao/internacao/pesquisarsolicitacaointernacao");
        }
    }

    function gravarleito() {

        if ($this->leito_m->gravarleito()) {
            $data['mensagem'] = 'Leito gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar leito';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarleito");
    }

    function gravarenfermaria() {

        if ($this->enfermaria_m->gravarenfermaria()) {
            $data['mensagem'] = 'Enfermaria gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar enfermaria';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarenfermaria");
    }

    function gravarunidade() {

        if ($this->unidade_m->gravarunidade()) {
            $data['mensagem'] = 'Unidade gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar unidade';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarunidade");
    }

    function gravarmotivosaida() {

        if ($this->motivosaida->gravarmotivosaida()) {
            $data['mensagem'] = 'Motivo de saida gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar Motivo de Saida';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarmotivosaida");
    }

    function gravarevolucaointernacao($internacao_id) {
        $_POST["internacao_id"] = $internacao_id;
        $this->internacao_m->gravarevolucaointernacao();

        if ($_POST['solicitasaida'] == 'on') {
            $data['paciente'] = $this->motivosaida->mostrarnovasaidapaciente($internacao_id);

            $this->loadView('internacao/mostrarnovasaidapaciente', $data);
        } else {
            if ($return == 0) {
                $data['mensagem'] = 'Evolução gravada com sucesso';
            } else {
                $data['mensagem'] = 'Erro ao gravar Evolução';
            }
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "internacao/internacao/pesquisarevolucao/$internacao_id", $data);
        }
    }

    function excluirevolucaointernacao($internacao_evolucao_id, $internacao_id) {
        
        $this->internacao_m->excluirevolucaointernacao($internacao_evolucao_id);

        if ($return == 0) {
            $data['mensagem'] = 'Evolução excluida com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao excluir Evolução';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarevolucao/$internacao_id", $data);
    }

    function gravarsaida() {


        if ($this->motivosaida->gravarsaida()) {
            $data['mensagem'] = 'Erro ao efetuar Saida';
        } else {
            $data['mensagem'] = 'Saida efetuada com sucesso';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarsaida");
    }

    function gravarinternacao($paciente_id) {

        if ($this->internacao_m->gravar($paciente_id)) {
            $data['mensagem'] = 'Internacao gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar movimentacao';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao");
    }

    function gravarinternacaonutricao($paciente_id) {
        if ($_POST['leito'] != "" || $_POST['unidade'] != "") {
            $internacao_id = $this->internacao_m->gravarinternacaonutricao($paciente_id);
        } else {
            $internacao_id = 0;
        }
        if ($internacao_id > 0) {
            $data['mensagem'] = 'Internacao gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar movimentacao';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/selecionarprescricao/$internacao_id");
    }

    function gravarmovimentacao($paciente_id, $leito_id) {

        if ($this->internacao_m->gravarmovimentacao($paciente_id, $leito_id)) {
            $data['mensagem'] = 'Movimentacao gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar movimentacao';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/acoes/$paciente_id");
    }

    function gravarsolicitacaointernacao($paciente_id) {

        if ($this->solicitacaointernacao_m->gravarsolicitacaointernacao($paciente_id)) {
            $data['mensagem'] = 'Solicitacao gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar solicitacao';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarsolicitacaointernacao");
    }

    function carregarsolicitacaointernacao($internacao_solicitacao_id) {
        $obj_paciente = new solicitainternacao_model($internacao_solicitacao_id);
        $data['obj'] = $obj_paciente;
        $this->loadView('internacao/cadastrarsolicitacaointernacao', $data);
    }

    function selecionarprescricao($internacao_id) {
        $data['internacao_id'] = $internacao_id;

        $this->loadView('internacao/selecionarprescricao', $data);
    }

    function excluiritemprescicao($item_id, $internacao_id) {
        $this->internacao_m->excluiritemprescicao($item_id);
        $this->prescricaonormalenteral($internacao_id);
    }

    function excluirmotivosaida($internacao_motivosaida_id) {
        $this->motivosaida->excluirmotivosaida($internacao_motivosaida_id);
        $data['mensagem'] = 'Motivo de Saida excluido com sucesso.';


//            redirect(base_url()."seguranca/operador/index/$data","refresh");
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarmotivosaida", $data);
    }

    function excluirleito($leito_id) {
        $this->leito_m->excluirleito($leito_id);
        $data['mensagem'] = 'Leito excluido com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarleito", $data);
    }

    function excluirenfermaria($enfermaria_id) {
        $this->enfermaria_m->excluirenfermaria($enfermaria_id);
        $data['mensagem'] = 'Enfermaria excluida com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarenfermaria", $data);
    }

    function excluirunidade($unidade_id) {
        $this->unidade_m->excluirunidade($unidade_id);
        $data['mensagem'] = 'Unidade excluida com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarunidade", $data);
    }

    function repetirultimaprescicaoenteralnormal($internacao_id) {
        $this->internacao_m->repetirultimaprescicaoenteralnormal($internacao_id);
        $this->prescricaonormalenteral($internacao_id);
    }

    function prescricaonormalenteral($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $data['enteral'] = $this->internacao_m->listaprodutosenteral($internacao_id);
        $data['equipo'] = $this->internacao_m->listaprodutosequipo($internacao_id);
        $data['prescricao'] = $this->internacao_m->listaprescricoesenteral($internacao_id);
        $this->loadView('internacao/prescricaonormalenteral', $data);
    }

    function prescricaoemergencialenteral($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $data['enteral'] = $this->internacao_m->listaprodutosenteral($internacao_id);
        $data['equipo'] = $this->internacao_m->listaprodutosequipo($internacao_id);
        $data['prescricao'] = $this->internacao_m->listaprescricoesenteralemergencial($internacao_id);
        $this->loadView('internacao/prescricaoemergencialenteral', $data);
    }

    function listarprescricaopaciente($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $data['prescricao'] = $this->internacao_m->listaprescricoespaciente($internacao_id);
        $data['prescricaoequipo'] = $this->internacao_m->listaprescricoespacienteequipo($internacao_id);
        $this->loadView('internacao/listarprescricaoenteral', $data);
    }

    function listarprescricao() {
        $data['unidade'] = $this->internacao_m->listaunidade();
        $this->loadView('internacao/relatorioprescricao', $data);
    }

    function gerarelatoriointernacao() {
        $data['prescricao'] = $this->internacao_m->listaprescricoesdata();
        $data['data_inicio'] = $_POST['txtdata_inicio'];
        $data['data_fim'] = $_POST['txtdata_fim'];
        $data['tipo'] = $_POST['tipo'];
        if ($_POST['unidade'] != 0) {
            $unidade = $this->internacao_m->pesquisarunidade($_POST['unidade']);
            $data['unidade'] = $unidade[0]->nome;
        } else {
            $data['unidade'] = 'TODOS';
        }
        $data['prescricaoequipo'] = $this->internacao_m->listaprescricoesequipodata();
        $this->load->View('internacao/listarprescricoes', $data);
    }

    function mostratransferirpaciente($paciente_id) {
        $data['paciente'] = $this->internacao_m->listapacienteinternado($paciente_id);
        $data['unidades'] = $this->internacao_m->listaunidadetransferencia();
        $this->loadView('internacao/transferirpaciente', $data);
    }

    function prescricaopaciente($internacao_id, $prescricao_id = null) {
        $data['usafarmacia'] = count($this->internacao_m->usafarmacia());
        $data['medicamentos'] = $this->internacao_m->listamedicamentointernacao($internacao_id);
        $data['internacao_id'] = $internacao_id;
        if ($data['usafarmacia'] > 0) {
            $data["prescricao_id"] = ($prescricao_id != null) ? $prescricao_id : '';
            $this->loadView('internacao/prescricaopacientefarmacia', $data);
        } else {
            $data['lista'] = $this->internacao_m->listarautocompletemodelosreceita();
//        $data['contador'] = $this->laudo->contadorlistarreceita($ambulatorio_laudo_id);
            $data['receita'] = $this->internacao_m->listarreceitainternacao($internacao_id);
//            var_dump($data['receita']);
//            die;
            $data['operadores'] = $this->operador_m->listarmedicos();
            $data['paciente'] = $this->internacao_m->listardadosreceituario($internacao_id);
            $this->load->View('internacao/receituarioconsulta-form', $data);
        }
    }

    function transferirpaciente() {
        $this->internacao_m->transferirpacienteleito();
        $this->internacao_m->atualizaleitotranferencia($_POST['leito_id'], $_POST['novo_leito']);

        //Redirecionando para a ficha do paciente novamente
        $leito_id = $_POST['novo_leito'];
        redirect(base_url() . "internacao/internacao/mostrafichapaciente/$leito_id");
    }

    function permutapaciente() {
        $_POST['id_paciente_troca'] = $this->internacao_m->pegaidpacientepermuta($_POST['leito_troca']);
        $this->internacao_m->permutapacientes();

        //Redirecionando para a ficha do paciente novamente
        $leito_id = $_POST['leito_troca'];
        redirect(base_url() . "internacao/internacao/mostrafichapaciente/$leito_id");
    }

    function mostrapermutapaciente($paciente_id) {
        $data['paciente'] = $this->internacao_m->listapacienteinternado($paciente_id);
        $data['unidades'] = $this->internacao_m->listaunidadetransferencia();
        $this->loadView('internacao/permutapaciente', $data);
    }

    function impressaoreceita($ambulatorio_laudo_id) {


        $this->load->plugin('mpdf');
        $data['laudo'] = $this->internacao_m->listarreceitaimpressao($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $dataFuturo = date("Y-m-d");
        $dataAtual = $data['laudo']['0']->nascimento;
        $date_time = new DateTime($dataAtual);
        $diff = $date_time->diff(new DateTime($dataFuturo));
        $teste = $diff->format('%Ya %mm %dd');
        //GERAL        
        $filename = "laudo.pdf";
        $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $data['laudo']['0']->paciente . "<br>Emiss&atilde;o: " . substr($data['laudo']['0']->data_cadastro, 8, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 5, 2) . '/' . substr($data['laudo']['0']->data_cadastro, 0, 4) . "</td></tr></table>";
        $rodape = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
        $html = $this->load->view('ambulatorio/impressaoreceituario', $data, true);
        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('internacao/impressaoreceituario', $data);
    }

    function editarcarregarreceituario($internacao_id, $ambulatorio_receituario_id) {
//        $obj_laudo = new laudo_model($ambulatorio_laudo_id);
//        $data['obj'] = $obj_laudo;
        $data['paciente'] = $this->internacao_m->listardadosreceituario($internacao_id);

        $data['receita'] = $this->internacao_m->listareditarreceita($ambulatorio_receituario_id);
        $data['operadores'] = $this->operador_m->listarmedicos();
//        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;

        $data['internacao_id'] = $internacao_id;
        $this->load->View('internacao/editarreceituarioconsulta-form', $data);
    }

    function editarreceituario($ambulatorio_laudo_id) {
        $internacao_id = $_POST['internacao_id'];
        $this->internacao_m->editarreceituario($ambulatorio_laudo_id);
        $data['ambulatorio_laudo_id'] = $ambulatorio_laudo_id;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/prescricaopaciente/$internacao_id");
    }

    function gravarprescricaoenteralnormal($internacao_id) {
        $this->internacao_m->gravarprescricaoenteralnormal($internacao_id);
        redirect(base_url() . "internacao/internacao/prescricaonormalenteral/$internacao_id");
    }

    function gravarprescricaofarmacia($internacao_id) {
        $prescricao_id = $this->internacao_m->gravarprescricaofarmacia($internacao_id);
        redirect(base_url() . "internacao/internacao/prescricaopaciente/$internacao_id/$prescricao_id");
    }

    function gravarreceituariointernacao($internacao_id) {

        $this->internacao_m->gravarreceituariointernacao($internacao_id);
        $data['internacao_id'] = $internacao_id;

        $this->session->set_flashdata('message', $data['mensagem']);
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/prescricaopaciente/$internacao_id");
    }

    function gravarprescricaoenteralemergencial($internacao_id) {
        $this->internacao_m->gravarprescricaoenteralemergencial($internacao_id);
        redirect(base_url() . "internacao/internacao/prescricaoemergencialenteral/$internacao_id");
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

    function internacaoalta($internacao_id) {

        $data['resultado'] = $this->internacao_m->internacaoalta($internacao_id);
    }

}

?>
