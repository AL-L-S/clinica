<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class internacao extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('emergencia/solicita_acolhimento_model', 'acolhimento');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('farmacia/produto_model', 'produto_m');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/laudo_model', 'laudo_m');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/empresa_model', 'empresa');
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

    public function pesquisarstatusinternacao($args = array()) {
        $this->loadView('internacao/listarstatusinternacao');
    }

    public function listarimpressoes($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $this->loadView('internacao/listarimpressoesinternacao', $data);
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

    function novointernacao($paciente_id, $internacao_ficha_id = null) {
        $data['numero'] = $this->internacao_m->verificainternacao($paciente_id);
//        var_dump($data['numero']);
//        die;
        $data['internacao_ficha_id'] = $internacao_ficha_id;
        if ($data['numero'] == 0) {
            $data['precadastro'] = $this->internacao_m->listarultimoprecadastro($paciente_id, $internacao_ficha_id);
            $data['paciente'] = $this->paciente->listardados($paciente_id);
            $data['medicos'] = $this->operador_m->listarmedicos();
            $data['convenio'] = $this->convenio->listardados();
//            var_dump($data['precadastro']); die;

            $data['paciente_id'] = $paciente_id;
            $this->loadView('internacao/cadastrarinternacao', $data);
        } else {
            $data['mensagem'] = 'Paciente já possui Internação';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "internacao/internacao/pesquisar");
        }
    }

    function carregarinternacao($internacao_id, $paciente_id, $internacao_ficha_id = null) {

        $data['internacao_ficha_id'] = $internacao_ficha_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['convenio'] = $this->convenio->listardados();
        $data['internacao'] = $this->internacao_m->listarcarregarinternacao($internacao_id);
//            var_dump($data['medico']); die;
//            if ($data['paciente'][0]->cep == '' || $data['paciente'][0]->cns == '') {
//                $data['mensagem'] = 'CEP ou CNS obrigatorio';
//                $this->session->set_flashdata('message', $data['mensagem']);
//                redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
//            }
        $data['paciente_id'] = $paciente_id;
        $this->loadView('internacao/cadastrarinternacao', $data);
    }

    function mantertipodependencia() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('internacao/mantertipodependencia-lista');
    }

    function editarmodelointernacaoimpressao($internacao_id, $impressao_id) {
//        var_dump($impressao_id);
//        die;
//        $this->load->plugin('mpdf');
        $empresa_id = $this->session->userdata('empresa_id');
        $data['internacao'] = $this->internacao_m->internacaoimpressaomodelo($internacao_id);
        $data['empresapermissoes'] = $this->guia->listarempresapermissoes();
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['impressao_id'] = $impressao_id;
        $data['internacao_id'] = $internacao_id;
        $data['cabecalhomedico'] = $this->operador_m->medicocabecalhorodape($data['internacao'][0]->medico_id);
//        echo '<pre>';
//        var_dump($data['empresapermissoes']); die;
        $data['impressaointernacao'] = $this->internacao_m->listarmodeloimpressaointernacao($impressao_id);

        $data['html'] = $this->load->view('internacao/impressaointernacaoconfiguravel', $data, true);
//        var_dump($data['html']); die;
        $this->loadview('internacao/editarimpressaomodelointernacao-form', $data);
    }

    function gravareditarimpressao($impressao_id, $internacao_id) {

        $impressao_temp_id = $this->internacao_m->gravareditarimpressao($impressao_id);
//        var_dump($impressao_temp_id); die;
        if ($impressao_temp_id > 0) {
//            $data['mensagem'] = 'Tipo gravado com sucesso';
            redirect(base_url() . "internacao/internacao/impressaomodelointernacao/$impressao_temp_id/$impressao_id/$internacao_id");
        } else {
//            $data['mensagem'] = 'Erro ao gravar Tipo';
            redirect(base_url() . "internacao/internacao/impressaomodelointernacao/$impressao_temp_id/$impressao_id/$internacao_id");
        }
    }

    function impressaomodelointernacao($impressao_temp_id, $impressao_id, $internacao_id) {
//        var_dump($impressao_temp_id);
//        die;
        $this->load->plugin('mpdf');
        $empresa_id = $this->session->userdata('empresa_id');
        $data['internacao'] = $this->internacao_m->internacaoimpressaomodelo($internacao_id);
        $data['empresapermissoes'] = $this->guia->listarempresapermissoes();
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalhomedico'] = $this->operador_m->medicocabecalhorodape($data['internacao'][0]->medico_id);
//        echo '<pre>';
//        var_dump($data['empresapermissoes']); die;
        $data['impressaointernacao'] = $this->internacao_m->listarmodeloimpressaointernacao($impressao_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;

        $filename = "internacao.pdf";
        if ($data['cabecalhomedico'][0]->cabecalho != '') { // Cabeçalho do Profissional
            $cabecalho = $data['cabecalhomedico'][0]->cabecalho;
        } else {
            if (file_exists("upload/operadorLOGO/" . $data['internacao'][0]->medico_id . ".jpg")) { // Logo do Profissional
                $cabecalho = '<img style="width: 100%; heigth: 35%;" src="upload/operadorLOGO/' . $data['internacao'][0]->medico_id . '.jpg"/>';
            } else {
                if ($data['impressaointernacao'][0]->cabecalho == 't') {
                    $cabecalho = "$cabecalho_config";
                } else {
                    $cabecalho = '';
                }
            }
        }


        if (file_exists("upload/1ASSINATURAS/" . $data['internacao'][0]->medico_id . ".jpg")) {
            $assinatura = "<img   width='200px' height='100px' src='" . base_url() . "./upload/1ASSINATURAS/" . $data['internacao'][0]->medico_id . ".jpg'>";
            $data['assinatura'] = "<img   width='200px' height='100px' src='" . base_url() . "./upload/1ASSINATURAS/" . $data['internacao'][0]->medico_id . ".jpg'>";
        } else {
            $assinatura = "";
            $data['assinatura'] = "";
        }

        if ($data['cabecalhomedico'][0]->rodape != '') { // Rodapé do profissional
            $rodape_config = $data['cabecalhomedico'][0]->rodape;
            $rodape_config = str_replace("_assinatura_", $assinatura, $rodape_config);
            $rodape = $rodape_config;
        } else {
            if ($data['impressaointernacao'][0]->rodape == 't') { // rodape da empresa
                $rodape_config = str_replace("_assinatura_", $assinatura, $rodape_config);
                $rodape = $rodape_config;
            } else {
                $rodape = "";
            }
        }



        $html = $this->internacao_m->listarmodeloimpressaointernacaotemp($impressao_temp_id);
//        var_dump($html);die;

        pdf($html, $filename, $cabecalho, $rodape);
    }

    function configurartipodependencia($internacao_tipo_dependencia_id) {
        $data['config'] = $this->internacao_m->listartipodependenciaform($internacao_tipo_dependencia_id);
        $data['internacao_tipo_dependencia_id'] = $internacao_tipo_dependencia_id;
        $this->loadView('internacao/mantertipodependencia-form', $data);
    }

    function gravartipodependencia() {

        if ($this->internacao_m->gravartipodependencia()) {
            $data['mensagem'] = 'Tipo gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar Tipo';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/mantertipodependencia");
    }

    function excluirtipodependencia($internacao_modelo_grupo_id) {

        if ($this->internacao_m->excluirtipodependencia($internacao_modelo_grupo_id)) {
            $data['mensagem'] = 'Modelo excluido com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao excluido Modelo';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/mantertipodependencia");
    }

    function mantermodelogrupo() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('internacao/mantermodelogrupo-lista');
    }

    function configurarmodelogrupo($internacao_modelo_grupo_id) {
        $data['config'] = $this->internacao_m->listarmodelogrupoform($internacao_modelo_grupo_id);
        $data['internacao_modelo_grupo_id'] = $internacao_modelo_grupo_id;
        $this->loadView('internacao/mantermodelogrupo-form', $data);
    }

    function gravarmodelogrupo() {

        if ($this->internacao_m->gravarmodelogrupo()) {
            $data['mensagem'] = 'Modelo gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar Modelo';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/mantermodelogrupo");
    }

    function excluirmodelogrupo($internacao_modelo_grupo_id) {

        if ($this->internacao_m->excluirmodelogrupo($internacao_modelo_grupo_id)) {
            $data['mensagem'] = 'Modelo excluido com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao excluido Modelo';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/mantermodelogrupo");
    }

    function manterfichaquestionario($args = array()) {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('internacao/manterfichaquestionario-lista', $args);
    }

    function pesquisarinternacaolista($args = array()) {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('internacao/pesquisarinternacao-lista', $args);
    }

    function carregarfichaquestionario($internacao_ficha_questionario_id) {
        $data['convenio'] = $this->convenio->listardados();
        $data['modelo_grupo'] = $this->internacao_m->listarmodelogrupoquestionario();
//        var_dump($data['modelo_grupo']); die;
        $data['config'] = $this->internacao_m->listarfichaquestionarioform($internacao_ficha_questionario_id);
        $data['internacao_ficha_questionario_id'] = $internacao_ficha_questionario_id;
        $this->loadView('internacao/manterfichaquestionario-form', $data);
    }

    function gravarfichaquestionario() {
//        echo '<pre>';
//        var_dump($_POST); die;

        if ($this->internacao_m->gravarfichaquestionario()) {
            $data['mensagem'] = 'Pré-Cadastro gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar Pré-Cadastro';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/manterfichaquestionario");
    }

    function excluirfichaquestionario($internacao_modelo_grupo_id) {

        if ($this->internacao_m->excluirfichaquestionario($internacao_modelo_grupo_id)) {
            $data['mensagem'] = 'Modelo excluido com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao excluido Modelo';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/manterfichaquestionario");
    }

    function confirmarligacaofichaquestionario($internacao_modelo_grupo_id) {

        if ($this->internacao_m->confirmarligacaofichaquestionario($internacao_modelo_grupo_id)) {
            $data['mensagem'] = 'Confirmação efetuada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao efetuar confirmação';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function ligacaofichaquestionario($internacao_ficha_questionario_id) {

        $data['internacao_ficha_questionario_id'] = $internacao_ficha_questionario_id;
        $data['observacao'] = $this->internacao_m->observacaoprecadastros($internacao_ficha_questionario_id);
//        $data['teste'] = 'ISSO E UM TESTE';
//        var_dump($data['observacao']); die;
        $this->load->View('internacao/observacaoligacaoprecadastro.php', $data);
    }

    function desconfirmarligacaofichaquestionario($internacao_modelo_grupo_id) {

        if ($this->internacao_m->desconfirmarligacaofichaquestionario($internacao_modelo_grupo_id)) {
            $data['mensagem'] = 'Confirmação efetuada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao efetuar confirmação';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/manterfichaquestionario");
    }

    function confirmaraprovacaofichaquestionario($internacao_ficha_id, $paciente_id) {

        if ($this->internacao_m->confirmaraprovacaofichaquestionario($internacao_ficha_id)) {
            $data['mensagem'] = 'Aprovada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao Aprovar';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes/carregarinternacaoprecadastro/$paciente_id/$internacao_ficha_id");
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

    function alterarstatuspaciente($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $data['status_sele'] = $this->internacao_m->listarstatuspaciente($internacao_id);
        $data['status'] = $this->internacao_m->listarstatuspacientetodos();
        $this->load->View('internacao/alterarstatuspaciente-form', $data);
    }

    function mostraenfermarialeito($unidade) {
        $data['enfermaria'] = $this->unidade_m->listaenfermariaunidade($unidade);
        $data['leitos'] = $this->unidade_m->listaleitounidade();
        $this->loadView('internacao/mostraenfermarialeito', $data);
    }

    function observacaoprecadastro($internacao_ficha_questionario_id) {
        $data['internacao_ficha_questionario_id'] = $internacao_ficha_questionario_id;
        $data['observacao'] = $this->internacao_m->observacaoprecadastros($internacao_ficha_questionario_id);
//        $data['teste'] = 'ISSO E UM TESTE';
//        var_dump($data['observacao']); die;
        $this->load->View('internacao/observacaoprecadastro-form', $data);
    }

    function mostrafichapaciente($internacao_id) {
        $data['paciente'] = $this->unidade_m->mostrafichapaciente($internacao_id);
        $this->loadView('internacao/mostrafichapaciente', $data);
    }

    function mostrafichapacienteleito($internacao_leito_id) {
        $data['paciente'] = $this->unidade_m->mostrafichapacienteleito($internacao_leito_id);
        $this->loadView('internacao/mostrafichapaciente', $data);
    }

    function termoresponsabilidade($internacao_id) {
        $this->load->plugin('mpdf');

        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;
        @$impressao_empresa_id = $data['empresa'][0]->impressao_internacao;

        if ($data['empresa'][0]->cabecalho_config == 't') { // Cabeçalho Da clinica
            $cabecalho = "$cabecalho_config";
        } else {
            $cabecalho = "<table><tr><td><img src='img/cabecalho.jpg'></td></tr></table>";
        }

        $data['cabecalho_form'] = $cabecalho;
        $data['dependencias'] = $this->internacao_m->listartipodependenciaquestionario();
        $data['paciente'] = $this->internacao_m->mostrartermoresponsabilidade($internacao_id);
        $paciente_id = $data['paciente'][0]->paciente_id;
        $data['historicoantigo'] = $this->laudo_m->listarlaudohistoricointernacao($paciente_id);
        $data['historicoexame'] = $this->laudo_m->listarexamehistorico($paciente_id);
//        echo '<pre>';
//        var_dump($data['historicoantigo']); die;
        if (@$impressao_empresa_id == 2) {
            $html = $this->load->View('internacao/impressaotermoresponsabilidade2', $data, true);
            $filename = 'Termo de Responsabilidade';
            $rodape = @$rodape_config;
            $cabecalho_file = $cabecalho;
        } else {
            $html = $this->load->View('internacao/impressaotermoresponsabilidade', $data, true);
            $filename = 'Termo de Responsabilidade';
            $rodape = '';
            $cabecalho_file = '';
        }
        pdf($html, $filename, $cabecalho_file, $rodape);
    }

    function imprimirevolucaointernacao($internacao_evolucao_id) {
        $this->load->plugin('mpdf');

        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['empresapermissoes'] = $this->guia->listarempresapermissoes();
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;
        @$impressao_empresa_id = $data['empresa'][0]->impressao_internacao;

        if ($data['empresa'][0]->cabecalho_config == 't') { // Cabeçalho Da clinica
            $cabecalho = "$cabecalho_config";
        } else {
            $cabecalho = "<table><tr><td><img src='img/cabecalho.jpg'></td></tr></table>";
        }

        $data['cabecalho_form'] = $cabecalho;
        $data['paciente'] = $this->internacao_m->imprimirevolucaointernacao($internacao_evolucao_id);
        $paciente_id = $data['paciente'][0]->paciente_id;
//        echo '<pre>';
//        var_dump($data['historicoantigo']); die;
        $html = $this->load->View('internacao/impressaoevolucaointernacao', $data, true);
        $filename = 'Impressão Evolução';
        $rodape = @$rodape_config;
        $cabecalho_file = $cabecalho;
        pdf($html, $filename, $cabecalho_file, $rodape);
    }

    function acompanhamentoanestesico($internacao_id) {
        $this->load->plugin('mpdf');

        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;
        @$impressao_empresa_id = $data['empresa'][0]->impressao_internacao;

        if ($data['empresa'][0]->cabecalho_config == 't') { // Cabeçalho Da clinica
            $cabecalho = "$cabecalho_config";
        } else {
            $cabecalho = "<table><tr><td><img width='1000px' height='180px' src='img/cabecalho.jpg'></td></tr></table>";
        }

        $data['cabecalho_form'] = $cabecalho;

        $data['paciente'] = $this->internacao_m->listarinformacoesinternacao($internacao_id);
        $paciente_id = $data['paciente'][0]->paciente_id;
//        $data['historicoantigo'] = $this->laudo_m->listarlaudohistoricointernacao($paciente_id);
//        $data['historicoexame'] = $this->laudo_m->listarexamehistorico($paciente_id);
//        echo '<pre>';
//        var_dump($data['historicoantigo']); die;

        $html = $this->load->View('internacao/impressaoacompanhamentoanestesico', $data, true);
        $filename = 'Acompanhamento Anestésico';
        $rodape = '';
        $cabecalho_file = '';

        pdf($html, $filename, $cabecalho_file, $rodape);
    }

    function termosaida($internacao_id) {
        $this->load->plugin('mpdf');

        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['motivosaida'] = $this->motivosaida->listamotivosaidapacientes($internacao_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;
        @$impressao_empresa_id = $data['empresa'][0]->impressao_internacao;

        if ($data['empresa'][0]->cabecalho_config == 't') { // Cabeçalho Da clinica
            $cabecalho = "$cabecalho_config";
        } else {
            $cabecalho = "<table><tr><td><img width='1000px' height='180px' src='img/cabecalho.jpg'></td></tr></table>";
        }

        $data['cabecalho_form'] = $cabecalho;

        $data['paciente'] = $this->internacao_m->mostrartermoresponsabilidade($internacao_id);
        $paciente_id = $data['paciente'][0]->paciente_id;
        $data['historicoantigo'] = $this->laudo_m->listarlaudohistoricointernacao($paciente_id);
        $data['historicoexame'] = $this->laudo_m->listarexamehistorico($paciente_id);
//        echo '<pre>';
//        var_dump($data['historicoantigo']); die;

        $html = $this->load->View('internacao/impressaotermosaida', $data, true);
        $filename = 'Termo de Saída';
        $rodape = @$rodape_config;
        $cabecalho_file = $cabecalho;

        pdf($html, $filename, $cabecalho_file, $rodape);
    }

    function mostrarnovasaidapaciente($internacao_id) {

        $data['paciente'] = $this->motivosaida->mostrarnovasaidapaciente($internacao_id);
        $data['motivosaida'] = $this->motivosaida->listamotivosaidapacientes($internacao_id);
        $data['medicos'] = $this->operador_m->listarmedicos();
//        echo "<pre>";
//        var_dump($internacao_id, $data['paciente']); die;
        $this->loadView('internacao/mostrarnovasaidapaciente', $data);
    }

    function mostrarsaidapaciente($internacao_id) {
        $data['paciente'] = $this->motivosaida->mostrarsaidapaciente($internacao_id);
        $this->loadView('internacao/mostrarsaidapaciente', $data);
    }

    function retornarinternacao($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $data['paciente'] = $this->internacao_m->retornarinternacaopaciente($internacao_id);
        $this->loadView('internacao/retornarinternacao', $data);
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

    function evolucaointernacao($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $this->loadView('internacao/evolucaointernacao', $data);
    }

    function listarevolucaointernacao($internacao_id) {
        $data['lista'] = $this->internacao_m->listarevolucoes($internacao_id);
        $data['internacao_id'] = $internacao_id;
        $this->loadView('internacao/evolucaointernacao-lista', $data);
    }

    function listarprocedimentosexterno($internacao_id) {
        $data['lista'] = $this->internacao_m->listarprocedimentoexterno($internacao_id);
        $data['internacao_id'] = $internacao_id;
        $this->loadView('internacao/procedimentoexterno-lista', $data);
    }

    function editarprocedimentoexternointernacao($internacao_procedimentoexterno_id, $internacao_id) {
        $data['lista'] = $this->internacao_m->editarprocedimentoexternointernacao($internacao_procedimentoexterno_id);
//        var_dump( $data['lista']); die;
        $data['internacao_id'] = $internacao_id;
        $data['internacao_procedimentoexterno_id'] = $internacao_procedimentoexterno_id;
        $this->loadView('internacao/procedimentoexternoeditar', $data);
    }

    function editarevolucaointernacao($internacao_evolucao_id, $internacao_id) {
        $data['lista'] = $this->internacao_m->editarevolucaointernacao($internacao_evolucao_id);
//        var_dump( $data['lista']); die;
        $data['internacao_id'] = $internacao_id;
        $data['internacao_evolucao_id'] = $internacao_evolucao_id;
        $this->loadView('internacao/evolucaointernacaoeditar', $data);
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

    function gravarstatusinternacao() {

        if ($this->internacao_m->gravarstatusinternacao()) {
            $data['mensagem'] = 'Status de internação gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar status de internação';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarstatusinternacao");
    }

    function gravarstatuspaciente($internacao_id) {

        if ($this->internacao_m->gravarstatuspaciente($internacao_id)) {
            $data['mensagem'] = 'Motivo de saida gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar Motivo de Saida';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarevolucaointernacao($internacao_id) {
        $_POST["internacao_id"] = $internacao_id;
        $data["internacao_id"] = $internacao_id;
        $this->internacao_m->gravarevolucaointernacao();
        if ($_POST['solicitasaida'] == 'on') {
            $data['paciente'] = $this->motivosaida->mostrarnovasaidapaciente($internacao_id);
//            $this->loadView('internacao/mostrarnovasaidapaciente', $data);
            redirect(base_url() . "internacao/internacao/mostrarnovasaidapaciente/$internacao_id", $data);
        } else {
            redirect(base_url() . "internacao/internacao/listarevolucaointernacao/$internacao_id", $data);
        }
    }

    function gravarprocedimentoexternointernacao($internacao_id) {
        $_POST["internacao_id"] = $internacao_id;
        $data["internacao_id"] = $internacao_id;
        $this->internacao_m->gravarprocedimentoexternointernacao();
        
        redirect(base_url() . "internacao/internacao/listarprocedimentosexterno/$internacao_id");
       
    }
    function excluirprocedimentoexternointernacao($internacao_proc_id, $internacao_id) {
        $_POST["internacao_id"] = $internacao_id;
        $data["internacao_id"] = $internacao_id;
        $this->internacao_m->excluirprocedimentoexternointernacao($internacao_proc_id);
        
        redirect(base_url() . "internacao/internacao/listarprocedimentosexterno/$internacao_id");
       
    }

    function excluirevolucaointernacao($internacao_evolucao_id, $internacao_id) {
        $_POST["internacao_evolucao_id"] = $internacao_evolucao_id;
        $data['internacao_id'] = $internacao_id;
        $this->internacao_m->excluirevolucaointernacao($internacao_evolucao_id);

        redirect(base_url() . "internacao/internacao/listarevolucaointernacao/$internacao_id", $data);
    }

    function gravarobservacaoprecadastro($internacao_ficha_questionario_id) {

        if ($this->internacao_m->gravarobservacaoprecadastro($internacao_ficha_questionario_id)) {
            $data['mensagem'] = 'Observação alterada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao alterar observação';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
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
        redirect(base_url() . "internacao/internacao/pesquisarinternacaolista");
    }

    function gravarretornarinternacao($internacao_id) {
        if ($_POST['leitoID'] > 0) {
            if ($this->internacao_m->gravarretornarinternacao($internacao_id)) {
                $data['mensagem'] = 'Internacao gravada com sucesso';
            } else {
                $data['mensagem'] = 'Erro ao gravar internação';
            }
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "internacao/internacao/pesquisarinternacaolista");
        } else {
            $data['mensagem'] = 'Leito inválido';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "internacao/internacao/retornarinternacao/$internacao_id");
        }
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

    function excluirinternacao($internacao_motivosaida_id, $paciente_id, $leito_id) {
        // var_dump($leito_id); die;
        $this->internacao_m->excluirinternacao($internacao_motivosaida_id, $paciente_id, $leito_id);
        $data['mensagem'] = 'Motivo de Saida excluido com sucesso.';


//            redirect(base_url()."seguranca/operador/index/$data","refresh");
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarinternacaolista", $data);
    }

    function excluirmotivosaida($internacao_motivosaida_id) {
        $this->motivosaida->excluirmotivosaida($internacao_motivosaida_id);
        $data['mensagem'] = 'Motivo de Saida excluido com sucesso.';


//            redirect(base_url()."seguranca/operador/index/$data","refresh");
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarmotivosaida", $data);
    }

    function excluirleito($leito_id) {
        $retorno = $this->leito_m->excluirleito($leito_id);
        // var_dump($retorno); die;
        if($retorno == -10){
            $data['mensagem'] = 'O leito está em uso.';
        }else{
            $data['mensagem'] = 'Leito excluido com sucesso.';
        }
        // $data['mensagem'] = 'Leito excluido com sucesso.';
        // var_dump($data['mensagem']); die;
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "internacao/internacao/pesquisarleito", $data);
    }

    function ativarleito($leito_id) {
        $retorno = $this->leito_m->ativarleito($leito_id);
        // var_dump($retorno); die;
        if($retorno == -10){
            $data['mensagem'] = 'O leito está em uso.';
        }else{
            $data['mensagem'] = 'Leito excluido com sucesso.';
        }
        // $data['mensagem'] = 'Leito excluido com sucesso.';
        // var_dump($data['mensagem']); die;
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

    function relatorioprecadastro() {
        $data['unidade'] = $this->internacao_m->listaunidade();
        $this->loadView('internacao/relatorioprecadastro', $data);
    }

    function gerarelatorioprecadastro() {
//        echo '<pre>';
//        var_dump($_POST);
//        die;
        $data['data_inicio'] = $_POST['txtdata_inicio'];
        $data['data_fim'] = $_POST['txtdata_fim'];
        $data['precadastro'] = $this->internacao_m->relatorioprecadastro();
        $data['dependencias'] = $this->internacao_m->listartipodependenciaquestionario();
//        var_dump($data['precadastro']);die;
        if ($_POST['indicacao'] != 0) {
            $indicacao = $this->internacao_m->pesquisarindicaco($_POST['indicacao']);
            $data['indicacao'] = $indicacao[0]->nome;
        } else {
            $data['indicacao'] = 'TODOS';
        }
        if ($_POST['convenio'] == '-1') {
            $data['convenio'] = 'Não Tem';
        } else {
            if ($_POST['convenio'] != 0) {
                $convenio = $this->internacao_m->pesquisarconvenio($_POST['convenio']);
                $data['convenio'] = $convenio[0]->nome;
            } else {
                $data['convenio'] = 'TODOS';
            }
        }

        if ($_POST['tipo_dependencia'] != 0) {
            $tipo_dependencia = $this->internacao_m->pesquisartipodependencia($_POST['tipo_dependencia']);
            $data['tipo_dependencia'] = $tipo_dependencia[0]->nome;
        } else {
            $data['tipo_dependencia'] = 'TODOS';
        }
        if ($_POST['cidade'] != 0) {
            $cidade = $this->internacao_m->pesquisarcidade($_POST['cidade']);
            $data['cidade'] = $cidade[0]->nome;
        } else {
            $data['cidade'] = 'TODOS';
        }

        $this->load->View('internacao/impressaorelatorioprecadastro', $data);
    }

    function relatoriocensodiario() {
        $data['unidade'] = $this->internacao_m->listaunidade();
        $this->loadView('internacao/relatoriocensodiario', $data);
    }
    
    function relatoriounidadeleito() {
        $data['unidade'] = $this->internacao_m->listaunidade();
        $this->loadView('internacao/relatoriounidadeleito', $data);
    }

    function gerarelatoriocensodiario() {
//        echo '<pre>';
//        var_dump($_POST);
//        die;
        $data['censodiario'] = $this->internacao_m->relatoriocensodiario();
    //    echo '<pre>';
    //    var_dump($data['censodiario']);
    //    die;
        if ($_POST['unidade'] != 0) {
            $unidade = $this->internacao_m->pesquisarunidade($_POST['unidade']);
            $data['unidade'] = $unidade[0]->nome;
        } else {
            $data['unidade'] = 'TODOS';
        }

        if ($_POST['enfermaria'] != 0) {
            $enfermaria = $this->internacao_m->pesquisarenfermaria($_POST['enfermaria']);
            $data['enfermaria'] = $enfermaria[0]->nome;
        } else {
            $data['enfermaria'] = 'TODOS';
        }



        if ($_POST['gerar_pdf'] == 'SIM') {
            $html = $this->load->View('internacao/impressaorelatoriocensodiario', $data, true);
            $this->load->plugin('mpdf');

            $cabecalhopdf = '';
            $rodapepdf = '';
            $nomepdf = "Relatorio Censo " . date("d/m/Y H:i:s") . ".pdf";
            pdf($html, $nomepdf, $cabecalhopdf, $rodapepdf);
        } else {
            $this->load->View('internacao/impressaorelatoriocensodiario', $data);
        }
    }
    
    function gerarelatoriounidadeleito() {

        $data['unidadeleito'] = $this->internacao_m->relatoriounidadeleito();

        if ($_POST['unidade'] != 0) {
            $unidade = $this->internacao_m->pesquisarunidade($_POST['unidade']);
            $data['unidade'] = $unidade[0]->nome;
        } else {
            $data['unidade'] = 'TODOS';
        }

        if ($_POST['enfermaria'] != 0) {
            $enfermaria = $this->internacao_m->pesquisarenfermaria($_POST['enfermaria']);
            $data['enfermaria'] = $enfermaria[0]->nome;
        } else {
            $data['enfermaria'] = 'TODOS';
        }



        if ($_POST['gerar_pdf'] == 'SIM') {
            $html = $this->load->View('internacao/impressaorelatoriounidadeleito', $data, true);
            $this->load->plugin('mpdf');

            $cabecalhopdf = '';
            $rodapepdf = '';
            $nomepdf = "Relatorio Censo " . date("d/m/Y H:i:s") . ".pdf";
            pdf($html, $nomepdf, $cabecalhopdf, $rodapepdf);
        } else {
            $this->load->View('internacao/impressaorelatoriounidadeleito', $data);
        }
    }

    function relatoriointernacao() {
        $data['unidade'] = $this->internacao_m->listaunidade();
        $this->loadView('internacao/relatoriointernacao', $data);
    }
    
    function relatoriosituacao() {
        $data['unidade'] = $this->internacao_m->listaunidade();
        $this->loadView('internacao/relatoriosituacao', $data);
    }

    function relatoriosaidainternacao() {
        $data['unidade'] = $this->internacao_m->listaunidade();
        $this->loadView('internacao/relatoriosaidainternacao', $data);
    }

    function gerarelatoriointernacao() {
//        echo '<pre>';
//        var_dump($_POST);
//        die;
        $data['data_inicio'] = $_POST['txtdata_inicio'];
        $data['data_fim'] = $_POST['txtdata_fim'];
        $data['internacao'] = $this->internacao_m->relatoriointernacao();
//        echo '<pre>';
//        var_dump($data['internacao']);
//        die;
        if ($_POST['convenio'] == '-1') {
            $data['convenio'] = 'Não Tem';
        } else {
            if ($_POST['convenio'] != 0) {
                $convenio = $this->internacao_m->pesquisarconvenio($_POST['convenio']);
                $data['convenio'] = $convenio[0]->nome;
            } else {
                $data['convenio'] = 'TODOS';
            }
        }

        $this->load->View('internacao/impressaorelatoriointernacao', $data);
    }
    
    function gerarelatoriointernacaosituacao() {
//        echo '<pre>';
//        var_dump($_POST);
//        die;
        $data['data_inicio'] = $_POST['txtdata_inicio'];
        $data['data_fim'] = $_POST['txtdata_fim'];
        $data['internacao'] = $this->internacao_m->relatoriointernacaosituacao();
//        echo '<pre>';
//        var_dump($data['internacao']);
//        die;
        if ($_POST['convenio'] == '-1') {
            $data['convenio'] = 'Não Tem';
        } else {
            if ($_POST['convenio'] != 0) {
                $convenio = $this->internacao_m->pesquisarconvenio($_POST['convenio']);
                $data['convenio'] = $convenio[0]->nome;
            } else {
                $data['convenio'] = 'TODOS';
            }
        }

        $this->load->View('internacao/impressaorelatoriointernacaosituacao', $data);
    }

    function gerarelatoriosaidainternacao() {
//        echo '<pre>';
//        var_dump($_POST);
//        die;
        $data['data_inicio'] = $_POST['txtdata_inicio'];
        $data['data_fim'] = $_POST['txtdata_fim'];
        $data['internacao'] = $this->internacao_m->relatoriosaidainternacao();
//        echo '<pre>';
//        var_dump($data['internacao']);
//        die;
        if ($_POST['convenio'] == '-1') {
            $data['convenio'] = 'Não Tem';
        } else {
            if ($_POST['convenio'] != 0) {
                $convenio = $this->internacao_m->pesquisarconvenio($_POST['convenio']);
                $data['convenio'] = $convenio[0]->nome;
            } else {
                $data['convenio'] = 'TODOS';
            }
        }

        $this->load->View('internacao/impressaorelatoriosaidainternacao', $data);
    }

    function relatoriointernacaofaturamento() {
        $data['unidade'] = $this->internacao_m->listaunidade();
        $this->loadView('internacao/relatoriointernacaofaturamento', $data);
    }

    function gerarelatoriointernacaofaturamento() {
//        echo '<pre>';
//        var_dump($_POST);
//        die;
        $data['data_inicio'] = $_POST['txtdata_inicio'];
        $data['data_fim'] = $_POST['txtdata_fim'];
        $data['internacao'] = $this->internacao_m->relatoriointernacaofaturamento();
//        echo '<pre>';
//        var_dump($data['internacao']);
//        die;
        if ($_POST['convenio'] == '-1') {
            $data['convenio'] = 'Não Tem';
        } else {
            if ($_POST['convenio'] != 0) {
                $convenio = $this->internacao_m->pesquisarconvenio($_POST['convenio']);
                $data['convenio'] = $convenio[0]->nome;
            } else {
                $data['convenio'] = 'TODOS';
            }
        }

        $this->load->View('internacao/impressaorelatoriointernacaofaturamento', $data);
    }

    function mostratransferirpaciente($internacao_id) {
        $data['paciente'] = $this->internacao_m->listapacienteinternado($internacao_id);
        $data['unidades'] = $this->internacao_m->listaunidadetransferencia();
        $this->loadView('internacao/transferirpaciente', $data);
    }

    function prescricaopaciente($internacao_id) {
        $data['usafarmacia'] = count($this->internacao_m->usafarmacia());
        $data['medicamentos'] = $this->internacao_m->listamedicamentointernacao($internacao_id);
        $data['internacao_id'] = $internacao_id;
        if ($data['usafarmacia'] > 0) {
            $this->loadView('internacao/prescricaopacientefarmacia', $data);
        } else {
//            $data['lista'] = $this->exametemp->listarautocompletemodelosreceita();
//        $data['contador'] = $this->laudo->contadorlistarreceita($ambulatorio_laudo_id);
            $data['receita'] = $this->laudo_m->listarreceitainternacao($internacao_id);
            $data['operadores'] = $this->operador_m->listarmedicos();
            $data['paciente'] = $this->internacao_m->listardadosreceituario($internacao_id);

            $data['internacao_id'] = $internacao_id;
            $this->load->View('internacao/receituarioconsulta-form', $data);
        }
    }

    function carregarprescricaopaciente($internacao_prescricao_id, $internacao_id) {
        $data['usafarmacia'] = count($this->internacao_m->usafarmacia());
        $data['medicamentos'] = $this->internacao_m->carregarprescricaopaciente($internacao_prescricao_id);
        $data['internacao_id'] = $internacao_id;
//        var_dump($data['medicamentos']); die;
        $data['internacao_prescricao_id'] = $internacao_prescricao_id;

        $this->loadView('internacao/carregarprescricaopaciente', $data);
    }

    function transferirpaciente() {
        $this->internacao_m->transferirpacienteleito();
        $this->internacao_m->atualizaleitotranferencia($_POST['leito_id'], $_POST['novo_leito']);

        //Redirecionando para a ficha do paciente novamente
        $leito_id = $_POST['novo_leito'];
        $internacao_id = $_POST['internacao_id'];
        redirect(base_url() . "internacao/internacao/mostrafichapaciente/$internacao_id");
    }

    function permutapaciente() {
        $_POST['id_paciente_troca'] = $this->internacao_m->pegaidpacientepermuta($_POST['leito_troca']);
        $this->internacao_m->permutapacientes();

        //Redirecionando para a ficha do paciente novamente
        $leito_id = $_POST['leito_troca'];
        $internacao_id = $_POST['internacao_id'];
        redirect(base_url() . "internacao/internacao/mostrafichapaciente/$internacao_id");
    }

    function mostrapermutapaciente($internacao_id) {
        $data['paciente'] = $this->internacao_m->listapacienteinternado($internacao_id);
        $data['unidades'] = $this->internacao_m->listaunidadetransferencia();
        $this->loadView('internacao/permutapaciente', $data);
    }

    function gravarprescricaoenteralnormal($internacao_id) {
        $this->internacao_m->gravarprescricaoenteralnormal($internacao_id);
        redirect(base_url() . "internacao/internacao/prescricaonormalenteral/$internacao_id");
    }

    function gravarprescricaofarmacia($internacao_id) {
        $this->internacao_m->gravarprescricaofarmacia($internacao_id);
//        $this->prescricaopaciente($internacao_id);
        redirect(base_url() . "internacao/internacao/prescricaopaciente/$internacao_id");
//        redirect(base_url() . "internacao/internacao/prescricaopacientefarmacia/$internacao_id");
    }

    function cancelarprescricaopaciente($internacao_prescricao_id, $internacao_id) {
        $this->internacao_m->cancelarprescricaopaciente($internacao_prescricao_id);
//        $this->prescricaopaciente($internacao_id);
        redirect(base_url() . "internacao/internacao/prescricaopaciente/$internacao_id");
//        redirect(base_url() . "internacao/internacao/prescricaopacientefarmacia/$internacao_id");
    }

    function confirmarprescricaofarmacia($internacao_prescricao_id, $internacao_id) {
        $this->internacao_m->confirmarprescricaofarmacia($internacao_prescricao_id);
//        $this->prescricaopaciente($internacao_id);
        redirect(base_url() . "internacao/internacao/prescricaopaciente/$internacao_id");
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

    function novostatusinternacao($internacao_statusinternacao_id) {
        
        $data['lista'] = $this->internacao_m->novostatusinternacao($internacao_statusinternacao_id);

        $this->loadView('internacao/cadastrarstatusinternacao', $data);

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
