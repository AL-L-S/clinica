<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class internacao extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('emergencia/solicita_acolhimento_model', 'acolhimento');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('internacao/internacao_model', 'internacao_m');
        $this->load->model('internacao/unidade_model', 'unidade_m');
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

    public function pesquisarunidade($args = array()) {
        $this->loadView('internacao/listarunidade');
    }

    public function pesquisarenfermaria($args = array()) {
        $this->loadView('internacao/listarenfermaria');
    }

    public function pesquisarleito($args = array()) {
        $this->loadView('internacao/listarleito');
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
            redirect(base_url() . "internacao/internacao/pesquisar");
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

    function novounidade() {

        $this->loadView('internacao/cadastrarunidade');
    }

    function novoenfermaria() {

        $this->loadView('internacao/cadastrarenfermaria');
    }

    function novoleito() {

        $this->loadView('internacao/cadastrarleito');
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

    function gravarinternacao($paciente_id) {

        if ($this->internacao_m->gravar($paciente_id)) {
            $data['mensagem'] = 'Internacao gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar movimentacao';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisar");
    }

    function gravarinternacaonutricao($paciente_id) {
        if($_POST['leito'] != "" || $_POST['unidade'] != ""){
        $internacao_id = $this->internacao_m->gravarinternacaonutricao($paciente_id);
        }else{
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
        $this-> prescricaonormalenteral($internacao_id);
    }

    function repetirultimaprescicaoenteralnormal($internacao_id) {
        $this->internacao_m->repetirultimaprescicaoenteralnormal($internacao_id);
        $this-> prescricaonormalenteral($internacao_id);
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
        if ($_POST['unidade'] != 0){
        $unidade = $this->internacao_m->pesquisarunidade($_POST['unidade']);
        $data['unidade'] = $unidade[0]->nome;
        }else{
            $data['unidade'] = 'TODOS';
        }
        $data['prescricaoequipo'] = $this->internacao_m->listaprescricoesequipodata();
//        $this->load->View('internacao/listarprescricoes', $data);
        $this->load->View('internacao/listarprescricoesporhospital', $data);
    }
    
    function gravarprescricaoenteralnormal($internacao_id) {
        $this->internacao_m->gravarprescricaoenteralnormal($internacao_id);
        redirect(base_url() . "internacao/internacao/prescricaonormalenteral/$internacao_id");
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

}

?>
