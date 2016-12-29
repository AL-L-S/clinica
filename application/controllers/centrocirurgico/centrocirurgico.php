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

    function solicitacirurgia($internacao_id){
        $data['paciente'] = $this->solicitacirurgia_m->solicitacirurgia($internacao_id);
        $this->loadView('centrocirurgico/solicitacirurgia', $data);
    }
    
    function gravarsolicitacaocirurgia() {

        if ($this->solicitacirurgia_m->gravarsolicitacaocirurgia( )) {
            $data['mensagem'] = 'Erro ao efetuar solicitação de cirurgia';
        } 
        else {
            $data['mensagem'] = 'Solicitação de Cirurgia efetuada com Sucesso';
        }

         $this->session->set_flashdata('message', $data['mensagem']);
         redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }
    
    function autorizarcirurgia() {
         $this->centrocirurgico_m->autorizarcirurgia( );
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
    
    function gravarnovasolicitacao() {
        $verifica = $this->solicitacirurgia_m->gravarnovasolicitacao();
        if($verifica){
            $data['mensagem'] = 'Solicitacao efetuada com Sucesso';
        }
        else{
            $data['mensagem'] = 'Erro ao efetuar Solicitacao';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }
    
    function novasolicitacaoconsulta($exame_id) {
        $data['paciente'] = $this->solicitacirurgia_m->solicitacirurgiaconsulta($exame_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('centrocirurgico/novasolicitacao', $data);
    }
    
    
    function novasolicitacao($solicitacao_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        if($solicitacao_id != '0'){
//        $data['solicitacao']= $this->centrocirurgico_m->pegasolicitacaoinformacoes($solicitacao_id);
//        $data['leito']= $this->solicitacirurgia_m->listaleitocirugia();
        }
        
        $this->loadView('centrocirurgico/novasolicitacao', $data);
    }
    
    function internacaoalta($internacao_id){

        $data['resultado']=$this->internacao_m->internacaoalta($internacao_id);
        
    }
    
    
}
   

?>
