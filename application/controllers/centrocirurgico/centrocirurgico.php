<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class centrocirurgico extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('emergencia/solicita_acolhimento_model', 'acolhimento');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('internacao/internacao_model', 'internacao_m');
        $this->load->model('internacao/unidade_model', 'unidade_m');
        $this->load->model('internacao/motivosaida_model', 'motivosaida');
        $this->load->model('internacao/enfermaria_model', 'enfermaria_m');
        $this->load->model('internacao/leito_model', 'leito_m');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/guia_model', 'guia');
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

    public function mapacirurgico($args = array()) {
        $this->load->View('centrocirurgico/calendariocirurgico');
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

    public function pesquisargrauparticipacao($args = array()) {
        $this->loadView('centrocirurgico/grauparticipacao-lista');
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

    function faturarprocedimentos($solicitacao_id,$guia_id, $financeiro_grupo_id = null) {
        $data['exame'][0] = new stdClass();
        $data['solicitacao_id'] = $solicitacao_id;
        // Criar acima a variável resolve o Warning que aparece na página de Faturar Guia.
        // A linha acima inicia o Objeto antes de atribuir um valor
        if (isset($financeiro_grupo_id)) {
            $data['forma_pagamento'] = $this->centrocirurgico_m->formadepagamentoguiaprocedimentos($guia_id, $financeiro_grupo_id);
            $data['exame'] = $this->centrocirurgico_m->listarexameguiaformaprocedimentos($guia_id, $financeiro_grupo_id);
        } else {
            $data['forma_pagamento'] = $this->centrocirurgico_m->formadepagamento();
            $data['exame1'] = $this->centrocirurgico_m->listarexameguiaprocedimentos($guia_id);
            $data['exame2'] = $this->centrocirurgico_m->listarexameguiaformaprocedimentos($guia_id, $financeiro_grupo_id);
            $data['exame'][0]->total = $data['exame1'][0]->total - $data['exame2'][0]->total;
        }
//        echo '<pre>';
//        var_dump($data['exame']); die;

        $data['financeiro_grupo_id'] = $financeiro_grupo_id;
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;

        $this->load->View('centrocirurgico/faturarprocedimentoscirurgicos-form', $data);
    }
    
    function gravarfaturadoprocedimentos() {
//        var_dump($_POST); die;
        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {

            $erro = false;
            if ($_POST['valorMinimo1'] != '' && ( ((float) $_POST['valorMinimo1']) > ((float) $_POST['valor1']) / $_POST['parcela1'] ) && $_POST['parcela1'] != 1) {
                $data['mensagem'] = 'Erro ao gravar faturamento. Valor da forma de pagamento 1 é menor que o valor da parcela minima cadastrado na forma de pagamento.';
                $erro = true;
//                echo "<script>alert('something');</script>";
            }
            if ($_POST['valorMinimo2'] != '' && ( ((float) $_POST['valorMinimo2']) > ((float) $_POST['valor2']) / $_POST['parcela2'] ) && $_POST['parcela2'] != 1) {
                $data['mensagem'] = 'Erro ao gravar faturamento. Valor da forma de pagamento 2 é menor que o valor da parcela minima cadastrado na forma de pagamento.';
                $erro = true;
//                echo "<script>alert('something');</script>";
            }
            if ($_POST['valorMinimo3'] != '' && ( ((float) $_POST['valorMinimo3']) > ((float) $_POST['valor3']) / $_POST['parcela3'] ) && $_POST['parcela3'] != 1) {
                $data['mensagem'] = 'Erro ao gravar faturamento. Valor da forma de pagamento 3 é menor que o valor da parcela minima cadastrado na forma de pagamento.';
                $erro = true;
//                echo "<script>alert('something');</script>";
            }
            if ($_POST['valorMinimo4'] != '' && ( ((float) $_POST['valorMinimo4']) > ((float) $_POST['valor4']) / $_POST['parcela4'] ) && $_POST['parcela4'] != 1) {
                $data['mensagem'] = 'Erro ao gravar faturamento. Valor da forma de pagamento 4 é menor que o valor da parcela minima cadastrado na forma de pagamento.';
                $erro = true;
//                echo "<script>alert('something');</script>";
            }
            if ($_POST['valorMinimo4'] != '' && $_POST['valorMinimo3'] != '' && $_POST['valorMinimo2'] != '' && $_POST['valorMinimo1'] != '') {
                $erro = true;
//                echo "<script>alert('something');</script>";
            }

            $_POST['parcela1'] = ($_POST['parcela1'] == '' || $_POST['parcela1'] == 0) ? 1 : $_POST['parcela1'];
            $_POST['parcela2'] = ($_POST['parcela2'] == '' || $_POST['parcela2'] == 0) ? 1 : $_POST['parcela2'];
            $_POST['parcela3'] = ($_POST['parcela3'] == '' || $_POST['parcela3'] == 0) ? 1 : $_POST['parcela3'];
            $_POST['parcela4'] = ($_POST['parcela4'] == '' || $_POST['parcela4'] == 0) ? 1 : $_POST['parcela4'];

            if (!$erro) {
                $ambulatorio_guia_id = $this->centrocirurgico_m->gravarfaturamentototalprocedimentos();


                if ($_POST['valorcredito'] != '' && $_POST['valorcredito'] != '0') {
//                    $this->guia->descontacreditopaciente();
                }
//                var_dump($_POST['valorcredito']);die;

                if ($ambulatorio_guia_id == "-1") {
                    $data['mensagem'] = 'Erro ao gravar faturamento. Opera&ccedil;&atilde;o cancelada.';
                } else {
                    $data['mensagem'] = 'Sucesso ao gravar faturamento.';
                }
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
            } else {
                $mensagem = $data['mensagem'];
                echo "<html>
                    <meta charset='UTF-8'>
        <script type='text/javascript'>
        
        alert('$mensagem');
        window.onunload = fechaEstaAtualizaAntiga;
        function fechaEstaAtualizaAntiga() {
            window.opener.location.reload();
            }
        window.close();
            </script>
            </html>";
//                echo "<meta charset='UTF-8'><script>alert('$mensagem');</script>";
            }
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }
    

    function importarquivos($solicitacao_cirurgia_id) {
        $this->load->helper('directory');

        if (!is_dir("./upload/centrocirurgico")) {
            mkdir("./upload/centrocirurgico");
            $destino = "./upload/centrocirurgico";
            chmod($destino, 0777);
        }
        if (!is_dir("./upload/centrocirurgico/$solicitacao_cirurgia_id")) {
            mkdir("./upload/centrocirurgico/$solicitacao_cirurgia_id");
            $destino = "./upload/centrocirurgico/$solicitacao_cirurgia_id";
            chmod($destino, 0777);
        }

        $data['arquivo_pasta'] = directory_map("./upload/centrocirurgico/$solicitacao_cirurgia_id/");
        //        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['solicitacao_cirurgia_id'] = $solicitacao_cirurgia_id;
        $this->loadView('centrocirurgico/importacao-imagemcentrocirurgico', $data);
    }

    function importarimagemcentrocirurgico() {
        $solicitacao_cirurgia_id = $_POST['paciente_id'];

        for ($i = 0; $i < count($_FILES['arquivos']['name']); $i++) {
            $_FILES['userfile']['name'] = $_FILES['arquivos']['name'][$i];
            $_FILES['userfile']['type'] = $_FILES['arquivos']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $_FILES['arquivos']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $_FILES['arquivos']['error'][$i];
            $_FILES['userfile']['size'] = $_FILES['arquivos']['size'][$i];

            if (!is_dir("./upload/centrocirurgico/$solicitacao_cirurgia_id")) {
                mkdir("./upload/centrocirurgico/$solicitacao_cirurgia_id");
                $destino = "./upload/centrocirurgico/$solicitacao_cirurgia_id";
                chmod($destino, 0777);
            }

            //        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
            $config['upload_path'] = "./upload/centrocirurgico/" . $solicitacao_cirurgia_id . "/";
            $config['allowed_types'] = 'gif|jpg|BMP|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar|xml|txt';
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
        }
//        var_dump($error); die;


        $data['solicitacao_cirurgia_id'] = $solicitacao_cirurgia_id;
        redirect(base_url() . "centrocirurgico/centrocirurgico/importarquivos/$solicitacao_cirurgia_id");
    }

    function excluirarquivocentrocirurgico($solicitacao_cirurgia_id, $nome) {

        if (!is_dir("./uploadopm/centrocirurgico")) {
            if (!is_dir("./uploadopm/centrocirurgico")) {
                mkdir("./uploadopm/centrocirurgico");
            }
            mkdir("./uploadopm/centrocirurgico");
            $destino = "./uploadopm/centrocirurgico/";
            chmod($destino, 0777);
        }

        if (!is_dir("./uploadopm/centrocirurgico/$solicitacao_cirurgia_id")) {
            if (!is_dir("./uploadopm/centrocirurgico")) {
                mkdir("./uploadopm/centrocirurgico");
            }
            mkdir("./uploadopm/centrocirurgico/$solicitacao_cirurgia_id");
            $destino = "./uploadopm/centrocirurgico/$solicitacao_cirurgia_id";
            chmod($destino, 0777);
        }

        $origem = "./upload/centrocirurgico/$solicitacao_cirurgia_id/$nome";
        $destino = "./uploadopm/centrocirurgico/$solicitacao_cirurgia_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        redirect(base_url() . "centrocirurgico/centrocirurgico/importarquivos/$solicitacao_cirurgia_id");
    }

    function excluirequipecirurgica($equipe_cirurgia_id) {
        $this->centrocirurgico_m->excluirequipecirurgica($equipe_cirurgia_id);
        $data['mensagem'] = 'Equipe excluida com Sucesso';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisarequipecirurgica");
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

    function excluirsolicitacaoprocedimentoeditar($solicitacao_procedimento_id, $solicitacao) {
        $this->solicitacirurgia_m->excluirsolicitacaoprocedimento($solicitacao_procedimento_id);
        $data['mensagem'] = 'Procedimento removido com sucesso';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditar/$solicitacao");
    }

    function excluirsolicitacaoprocedimentoeditarorcamento($solicitacao_procedimento_id, $solicitacao) {
        $this->solicitacirurgia_m->excluirsolicitacaoprocedimento($solicitacao_procedimento_id);
        $data['mensagem'] = 'Procedimento removido com sucesso';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditarorcamento/$solicitacao");
    }

    function excluirsolicitacaoprocedimentoeditarconvenio($solicitacao_procedimento_id, $solicitacao) {
        $this->solicitacirurgia_m->excluirsolicitacaoprocedimento($solicitacao_procedimento_id);
        $data['mensagem'] = 'Procedimento removido com sucesso';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditarconvenio/$solicitacao");
    }

    function novo($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);

        $horario = date(" Y-m-d H:i:s");

        $hour = substr($horario, 11, 3);
        $minutes = substr($horario, 15, 2);
        $seconds = substr($horario, 18, 4);

        $this->loadView('emergencia/solicitacoes-paciente', $data);
    }

    function novograuparticipacao() {
        $this->loadView('centrocirurgico/grauparticipacao-form');
    }

    function editarpercentualoutros($percentual_id) {
        $data['percentual_id'] = $percentual_id;
        $data['percentual'] = $this->centrocirurgico_m->carregarpercentualoutros($percentual_id);
        $this->loadView('centrocirurgico/configurarpercentuaisoutros-form', $data);
    }

    function editarpercentualfuncao($percentual_id) {
        $data['percentual_id'] = $percentual_id;
        $data['percentual'] = $this->centrocirurgico_m->carregarpercentualfuncao($percentual_id);
        $this->loadView('centrocirurgico/configurarpercentuais-form', $data);
    }

    function editarhorarioespecial($percentual_id) {
        $data['percentual_id'] = $percentual_id;
        $data['percentual'] = $this->centrocirurgico_m->carregarpercentualfuncao($percentual_id);
        $this->loadView('centrocirurgico/configurarhorarioespecial-form', $data);
    }

    function configurarpercentuais() {
        $data['funcao'] = $this->centrocirurgico_m->listarpercentualfuncao();
        $data['percentual'] = $this->centrocirurgico_m->listarpercentualoutros();
        $this->loadView('centrocirurgico/configurarpercentuais-lista', $data);
    }

    function atribuirpadraopercentualans() {
        $this->centrocirurgico_m->atribuirpadraopercentualans();
        $data['mensagem'] = 'Percentual alterado com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/configurarpercentuais");
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

    function editarprocedimentoscirurgia($solicitacao_id, $guia_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['guia_id'] = $guia_id;
        $data['ambulatorio_guia_id'] = $guia_id;
        $data['convenios'] = $this->solicitacirurgia_m->listarconvenios();
        $data['solicitacao'] = $this->solicitacirurgia_m->listardadossolicitacaoautorizar($solicitacao_id);
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['procedimentos'] = $this->solicitacirurgia_m->listarprocedimentosolicitacaocirurgicaeditar($solicitacao_id);
        $this->loadView('centrocirurgico/editarprocedimentoscirurgia', $data);
    }

    function mostraautorizarcirurgia($solicitacao_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['solicitacao'] = $this->solicitacirurgia_m->listardadossolicitacaoautorizar($solicitacao_id);
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['procedimentos'] = $this->solicitacirurgia_m->listarprocedimentosolicitacaocirurgica($solicitacao_id);
//        var_dump($data['procedimentos']); die;
        $this->loadView('centrocirurgico/autorizarcirurgia', $data);
    }

    function editarcirurgia($solicitacao_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['solicitacao'] = $this->solicitacirurgia_m->listardadossolicitacaoautorizar($solicitacao_id);
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['procedimentos'] = $this->solicitacirurgia_m->listarprocedimentosolicitacaocirurgicaeditar($solicitacao_id);
        $this->loadView('centrocirurgico/editarcirurgia', $data);
    }

    function impressaoorcamento($solicitacao_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['empresa'] = $this->solicitacirurgia_m->burcarempresa();
        $data['procedimentos'] = $this->solicitacirurgia_m->impressaoorcamento($solicitacao_id);
        $data['solicitacao'] = $this->solicitacirurgia_m->listardadossolicitacaoorcamentoimpressao($solicitacao_id);
//        echo "<pre>"; var_dump($data['procedimentos']); die;
        $this->load->view('centrocirurgico/impressaoorcamento', $data);
    }

    function adicionarprocedimentos($solicitacao) {
        $data['solicitacao'] = $solicitacao;
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacao/$solicitacao");
    }

    function gravarpercentualhorarioespecial() {
        $this->centrocirurgico_m->gravarpercentualhorarioespecial();

        $data['mensagem'] = 'Percentual gravado com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/configurarpercentuais");
    }

    function gravarpercentualoutros() {
        $this->centrocirurgico_m->gravarpercentualoutros();

        $data['mensagem'] = 'Percentual gravado com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/configurarpercentuais");
    }

    function gravarpercentualfuncao() {
        $this->centrocirurgico_m->gravarpercentualfuncao();

        $data['mensagem'] = 'Percentual gravado com sucesso.';
        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/configurarpercentuais");
    }

    function finalizarequipecirurgica($solicitacaocirurgia_id) {
        $this->centrocirurgico_m->finalizarequipecirurgica($solicitacaocirurgia_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function gravarguiacirurgicaequipe() {
        $guia_id = $_POST['txtambulatorioguiaid'];

        $data['guia'] = $this->guia->instanciarguia($guia_id);
        $data['procedimentos'] = $this->centrocirurgico_m->listarprocedimentosguiacirurgica($guia_id);
        $funcao = $this->centrocirurgico_m->listarfuncaoexameequipe($guia_id);
//        echo '<pre>';
//        var_dump($funcao);
//        die;

        if (count($funcao) == 0) {

            $data['mensagem'] = 'Função gravada com sucesso.';
            $this->centrocirurgico_m->gravarguiacirurgicaequipe($data['procedimentos'], $data['guia'][0]);
        } else {
            $data['mensagem'] = 'Função já existente.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/cadastrarequipeguiacirurgica/$guia_id");
    }

    function gravarguiacirurgicaequipeeditar($guia_id, $solicitacao_id) {
//        var_dump($guia_id); die;
        $data['guia'] = $this->guia->instanciarguia($guia_id);
        $data['procedimentos'] = $this->centrocirurgico_m->listarprocedimentosguiacirurgica($guia_id);
        $funcao = $this->centrocirurgico_m->listarfuncaoexameequipe($guia_id);
//        echo '<pre>';
//        var_dump($funcao);
//        die;

        if (count($funcao) == 0) {
            $data['mensagem'] = 'Função gravada com sucesso.';
            $this->centrocirurgico_m->gravarguiacirurgicaequipeeditar($data['procedimentos'], $data['guia'][0], $solicitacao_id);
        } else {
            $data['mensagem'] = 'Função já existente.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/cadastrarequipeguiacirurgicasolicitacao/$solicitacao_id/$guia_id");
    }

    function procedimentocirurgicovalor($agenda_exames_id) {
        $data['valor'] = $this->centrocirurgico_m->procedimentocirurgicovalor($agenda_exames_id);
//        var_dump($data['valor']); die;

        $this->load->View('ambulatorio/procedimentocirurgicovalor-form', $data);
    }

    function gravarprocedimentocirurgicovalor($agenda_exames_id) {
        $this->centrocirurgico_m->gravarprocedimentocirurgicovalor($agenda_exames_id);
//        var_dump($data['valor']); die;

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function cadastrarequipeguiacirurgica($guia) {

        $data['guia_id'] = $guia;
        $data['guia'] = $this->guia->instanciarguia($guia);

        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['grau_participacao'] = $this->solicitacirurgia_m->grauparticipacao();
        $data['equipe_operadores'] = $this->centrocirurgico_m->listarequipeoperadores($guia);
        $this->loadView('centrocirurgico/equipeguiacirurgica-form', $data);
    }

    function cadastrarequipeguiacirurgicasolicitacao($solicitacao_cirurgia_id, $guia) {

        $data['guia_id'] = $guia;
        $data['solicitacao_id'] = $solicitacao_cirurgia_id;
        $data['guia'] = $this->guia->instanciarguia($guia);

        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['grau_participacao'] = $this->solicitacirurgia_m->grauparticipacao();
        $data['equipe_operadores'] = $this->centrocirurgico_m->listarequipeoperadoreseditar($guia);
        $this->loadView('centrocirurgico/equipeguiacirurgicaeditar-form', $data);
    }

    function cadastrarequipe() {
        $this->loadView("centrocirurgico/equipecirurgica-form");
    }

    function excluirguiacirurgica($guia) {
        $this->centrocirurgico_m->excluirguiacirurgica($guia);

        $data['mensagem'] = 'Guia Cirurgica cancelada com sucesso';
        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "ambulatorio/exame/faturamentomanual");
    }

    function finalizarcadastroequipecirurgica($guia) {
        $verifica = $this->centrocirurgico_m->finalizarcadastroequipecirurgica($guia);
        if ($verifica) {
            $data['mensagem'] = 'Equipe gravada com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao finalizar equipe';
        }
        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "ambulatorio/exame/faturamentomanual");
    }

//    function adicionarprocedimentosdecisao() {
////        if ($_POST['escolha'] == "SIM") {
//            $solicitacao = $_POST['solicitacao_id'];
//            redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacao/$solicitacao");
////        } else {
////            redirect(base_url() . "centrocirurgico/centrocirurgico/centrocirurgico");
////        }
//    }

    function gravargrauparticipacao() {
        $solicitacao = $this->centrocirurgico_m->gravargrauparticipacao();
        if ($solicitacao == -1) {
            $data['mensagem'] = 'Erro ao Gravar. Esse Código ja foi cadastrado.';
        } else {
            $data['mensagem'] = 'Grau de partipação salvo com Sucesso';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisargrauparticipacao");
    }

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

    function gravarsolicitacaoprocedimentosalterarorcamento() {
//        var_dump($_POST); die;
        $solicitacao = $_POST['solicitacao_id'];


        if ($_POST['procedimentoID'] != '') {
            $verifica = count($this->solicitacirurgia_m->verificasolicitacaoprocedimentorepetidos());
            if ($verifica == 0) {
                $valor = $this->solicitacirurgia_m->listarvalorprocedimentocadastrar();
                if ($this->solicitacirurgia_m->gravarsolicitacaoprocedimentoalterar($valor)) {
                    $data['mensagem'] = 'Procedimento adicionado com Sucesso';
                } else {
                    $data['mensagem'] = 'Erro ao gravar Procedimento';
                }
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditarorcamento/$solicitacao");
            }
        } else {
            $data['mensagem'] = 'Erro ao gravar Procedimento. Procedimento nao selecionado ou invalido.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditarorcamento/$solicitacao");
    }

    function gravarsolicitacaoprocedimentosalterarconvenio() {
//        var_dump($_POST); die;
        $solicitacao = $_POST['solicitacao_id'];


        if ($_POST['procedimentoID'] != '') {
            $verifica = count($this->solicitacirurgia_m->verificasolicitacaoprocedimentorepetidos());
            $valor = $this->solicitacirurgia_m->listarvalorprocedimentocadastrar();
            if ($verifica == 0) {
                if ($this->solicitacirurgia_m->gravarsolicitacaoprocedimentoalterar($valor)) {
                    $data['mensagem'] = 'Procedimento adicionado com Sucesso';
                } else {
                    $data['mensagem'] = 'Erro ao gravar Procedimento';
                }
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditarconvenio/$solicitacao");
            }
        } else {
            $data['mensagem'] = 'Erro ao gravar Procedimento. Procedimento nao selecionado ou invalido.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditarconvenio/$solicitacao");
    }

    function gravarsolicitacaoprocedimentosalterar() {
//        var_dump($_POST); die;
        $solicitacao = $_POST['solicitacao_id'];


        if ($_POST['procedimentoID'] != '') {
            $valor = $this->solicitacirurgia_m->listarvalorprocedimentocadastrar();
            $verifica = count($this->solicitacirurgia_m->verificasolicitacaoprocedimentorepetidos());
            if ($verifica == 0) {
                if ($this->solicitacirurgia_m->gravarsolicitacaoprocedimentoalterar($valor)) {
                    $data['mensagem'] = 'Procedimento adicionado com Sucesso';
                } else {
                    $data['mensagem'] = 'Erro ao gravar Procedimento';
                }
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditar/$solicitacao");
            }
        } else {
            $data['mensagem'] = 'Erro ao gravar Procedimento. Procedimento nao selecionado ou invalido.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacaoeditar/$solicitacao");
    }

    function gravarsolicitacaoprocedimentos() {

        $solicitacao = $_POST['solicitacao_id'];

        if ($_POST['tipo'] == 'procedimento') {

            if ($_POST['procedimentoID'] != '') {
                $valor = $this->solicitacirurgia_m->listarvalorprocedimentocadastrar();
//                var_dump($valor);
//                die;

                $verifica = count($this->solicitacirurgia_m->verificasolicitacaoprocedimentorepetidos());
                if ($verifica == 0) {
                    if ($this->solicitacirurgia_m->gravarsolicitacaoprocedimento($valor)) {
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
//            var_dump($procedimentos); die;
            foreach ($procedimentos as $item) {
                $_POST['procedimentoID'] = $item->procedimento_id;
                $valor = $this->solicitacirurgia_m->listarvalorprocedimentocadastrar();
                $verifica = count($this->solicitacirurgia_m->verificasolicitacaoprocedimentorepetidos());
                if ($verifica == 0) {
                    $this->solicitacirurgia_m->gravarsolicitacaoprocedimento($valor);
                }
            }
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/carregarsolicitacao/$solicitacao");
    }

    function carregarsolicitacao($solicitacao_id) {

        $data['solicitacao_id'] = $solicitacao_id;
        $data['dados'] = $this->centrocirurgico_m->listarsolicitacoes3($solicitacao_id);
        $data['convenios'] = $this->solicitacirurgia_m->listarconvenios();
        $data['procedimento'] = $this->solicitacirurgia_m->carregarsolicitacaoprocedimento($data['dados'][0]->convenio_id);
        $data['agrupador'] = $this->solicitacirurgia_m->carregarsolicitacaoagrupador($data['dados'][0]->convenio_id);
        $data['procedimentos'] = $this->solicitacirurgia_m->listarsolicitacaosprocedimentos($solicitacao_id);
        $this->loadView('centrocirurgico/solicitacaoprocedimentos-form', $data);
    }

    function carregarsolicitacaoeditarorcamento($solicitacao_id) {

        $data['solicitacao_id'] = $solicitacao_id;
        $data['dados'] = $this->centrocirurgico_m->listarsolicitacoes3($solicitacao_id);
        $data['convenios'] = $this->solicitacirurgia_m->listarconveniosdinheiro();
        $data['procedimento'] = $this->solicitacirurgia_m->carregarsolicitacaoprocedimento($data['dados'][0]->convenio_id);
        $data['agrupador'] = $this->solicitacirurgia_m->carregarsolicitacaoagrupador($data['dados'][0]->convenio_id);
        $data['procedimentos'] = $this->solicitacirurgia_m->listarsolicitacaosprocedimentosorcamento($solicitacao_id);
        $this->loadView('centrocirurgico/solicitacaoprocedimentosalterarorcamento-form', $data);
    }

    function carregarsolicitacaoeditarconvenio($solicitacao_id) {

        $data['solicitacao_id'] = $solicitacao_id;
        $data['dados'] = $this->centrocirurgico_m->listarsolicitacoes3($solicitacao_id);
        $data['convenios'] = $this->solicitacirurgia_m->listarconvenios();
        $data['procedimento'] = $this->solicitacirurgia_m->carregarsolicitacaoprocedimento($data['dados'][0]->convenio_id);
        $data['agrupador'] = $this->solicitacirurgia_m->carregarsolicitacaoagrupador($data['dados'][0]->convenio_id);
        $data['procedimentos'] = $this->solicitacirurgia_m->listarsolicitacaosprocedimentosconvenio($solicitacao_id);
        $this->loadView('centrocirurgico/solicitacaoprocedimentosalterarconvenio-form', $data);
    }

    function carregarsolicitacaoeditar($solicitacao_id) {

        $data['solicitacao_id'] = $solicitacao_id;
        $data['dados'] = $this->centrocirurgico_m->listarsolicitacoes3($solicitacao_id);
        $data['convenios'] = $this->solicitacirurgia_m->listarconveniostodos();
        $data['procedimento'] = $this->solicitacirurgia_m->carregarsolicitacaoprocedimento($data['dados'][0]->convenio_id);
        $data['agrupador'] = $this->solicitacirurgia_m->carregarsolicitacaoagrupador($data['dados'][0]->convenio_id);
        $data['procedimentos'] = $this->solicitacirurgia_m->listarsolicitacaosprocedimentos($solicitacao_id);
        $this->loadView('centrocirurgico/solicitacaoprocedimentosalterar-form', $data);
    }

    function editarprocedimentossolicitacaocirurgia($solicitacao_id, $guia_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['guia_id'] = $guia_id;
        $data['ambulatorio_guia_id'] = $guia_id;
        $data['convenios'] = $this->solicitacirurgia_m->listarconvenios();
        $data['solicitacao'] = $this->solicitacirurgia_m->listardadossolicitacaoautorizar($solicitacao_id);
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['procedimentos'] = $this->solicitacirurgia_m->listarprocedimentosolicitacaocirurgicaeditar($solicitacao_id);
        $this->loadView('centrocirurgico/editarprocedimentoscirurgia', $data);
    }

    function carregarhospital($hospital_id) {

        $data['hospital_id'] = $hospital_id;
        $data['hospital'] = $this->centrocirurgico_m->instanciarhospitais($hospital_id);
//        echo "<pre>";var_dump($data['hospital'] );die;
        $this->loadView('centrocirurgico/hospital-form', $data);
    }

    function gravarequipeoperadores() {
        $solicitacao_id = $_POST['solicitacao_id'];

        $equipe_funcao = $this->centrocirurgico_m->listarequipeoperadoresfuncao();
        if (count($equipe_funcao) == 0) {
            $this->centrocirurgico_m->gravarequipeoperadores();
            $data['mensagem'] = 'Sucesso ao gravar função.';
        } else {
            $data['mensagem'] = 'Função ou operador já cadastrado(a)';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/montarequipe/$solicitacao_id");
    }

    function finalizarcadastroprocedimentosguia($guia) {
        redirect(base_url() . "centrocirurgico/centrocirurgico/cadastrarequipeguiacirurgica/$guia");
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

    function excluirgrauparticipacao($grau_participacao_id) {
        $this->centrocirurgico_m->excluirgrauparticipacao($grau_participacao_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisargrauparticipacao");
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

    function excluiroperadorequipecirurgica($guia_id, $funcao_id, $solicitacao_id) {
        $this->solicitacirurgia_m->excluiroperadorequipecirurgica($guia_id, $funcao_id, $solicitacao_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/cadastrarequipeguiacirurgica/$guia_id");
    }

    function excluiroperadorequipecirurgicaeditar($guia_id, $funcao_id, $solicitacao_id) {
        $this->solicitacirurgia_m->excluiroperadorequipecirurgicaeditar($guia_id, $funcao_id, $solicitacao_id);
        redirect(base_url() . "centrocirurgico/centrocirurgico/cadastrarequipeguiacirurgicasolicitacao/$solicitacao_id/$guia_id");
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

//    function novasolicitacaoconsulta($exame_id) {
//        $data['paciente'] = $this->solicitacirurgia_m->solicitacirurgiaconsulta($exame_id);
//        $data['medicos'] = $this->operador_m->listarmedicos();
//        $this->loadView('centrocirurgico/novasolicitacao', $data);
//    }

    function novasolicitacao($solicitacao_id, $laudo_id = null) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['hospitais'] = $this->centrocirurgico_m->listarhospitaissolicitacao();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['convenio'] = $this->centrocirurgico_m->listarconveniocirurgiaorcamento();
        if ($laudo_id != null && $laudo_id != '0') {
            $data['laudo'] = $this->centrocirurgico_m->listarlaudosolicitacaocirurgica($laudo_id);
        }
        $this->loadView('centrocirurgico/novasolicitacao', $data);
    }

    function novasolicitacaointernacao($internacao_id, $paciente_id) {
        $data['internacao_id'] = $internacao_id;
        $data['paciente_id'] = $paciente_id;
        $data['hospitais'] = $this->centrocirurgico_m->listarhospitaissolicitacao();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['convenio'] = $this->centrocirurgico_m->listarconveniocirurgiaorcamento();
        $data['paciente'] = $this->centrocirurgico_m->listarpacientesolicitacaocirurgicainternacao($paciente_id);

        $this->loadView('centrocirurgico/novasolicitacaointernacao', $data);
    }

    function listarhorarioscalendariocirurgico() {
//        echo 'asdasd';
//        die;
//            echo $_POST['custom_param1'];
        if (count($_POST) > 0) {
            $result = $this->centrocirurgico_m->listarcirurgiacalendario($_POST['medico']);
//            $algo = 'asd';
        } else {
            $result = $this->centrocirurgico_m->listarcirurgiacalendario();
//            $algo = 'dsa';
        }
//        echo '<pre>';
//        var_dump($result);
//        die;

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $data_atual = date("Y-m-d");
            if ($item->nascimento != '') {
                $idade = $data_atual - date("Y-m-d", strtotime($item->nascimento));
            } else {
                $idade = '';
            }
            if ($item->autorizado == 't') {
                $situacao = 'Autorizada';
            } else {
                $situacao = 'Solicitada';
            }
            $anestesista_select = $this->centrocirurgico_m->listacalendarioanestesistaautocomplete($item->solicitacao_cirurgia_id);
            $procedimento_select = $this->centrocirurgico_m->listacalendarioprocedimentoautocomplete($item->solicitacao_cirurgia_id);
            if (count($anestesista_select) > 0) {
                $anestesista = $anestesista_select[0]->nome;
            } else {
                $anestesista = '';
            }
            if (count($procedimento_select) > 0) {
                $procedimento = $procedimento_select[0]->nome;
            } else {
                $procedimento = '';
            }
//            var_dump($procedimento); die;
//            var_dump(date("Y-m-d",strtotime($item->nascimento))); die;

            $retorno['id'] = $i;
            $retorno['solicitacao_id'] = $item->solicitacao_cirurgia_id;
            $retorno['title'] = "Situação: $situacao \n \nCirurgião: $item->cirurgiao | Hospital: $item->hospital | Paciente: $item->nome | Convênio: $item->convenio | Procedimento: $procedimento | Fornecedor :  | Anestesista : $anestesista | Telefone: $item->celular / $item->telefone | Idade : $idade ";
            $retorno['texto'] = "Situação:  $situacao \n \nCirurgião: $item->cirurgiao \n \nHospital: $item->hospital  \n \nPaciente: $item->nome  \n \nConvênio: $item->convenio  \n \nProcedimento: $procedimento \n \nFornecedor :  \n \nAnestesista  : $anestesista  \n \n Telefone: $item->celular / $item->telefone  \n \n Idade : $idade ";


            $retorno['start'] = date("Y-m-d", strtotime($item->data_prevista)) . "T" . date("H:i:s", strtotime($item->hora_prevista));
            if ($item->hora_prevista_fim != '') {
                $retorno['end'] = date("Y-m-d", strtotime($item->data_prevista)) . "T" . date("H:i:s", strtotime($item->hora_prevista_fim));
            } else {
                $retorno['end'] = date("Y-m-d", strtotime($item->data_prevista)) . "T" . date("H:i:s", strtotime($item->hora_prevista));
            }

//            $retorno['start'] = date("Y-m-d",strtotime($item->data_prevista));
//            $retorno['end'] = date("Y-m-d",strtotime($item->data_prevista));
            if ($item->cor_mapa != '') {
                $retorno['color'] = $item->cor_mapa;
            } else {
                $retorno['color'] = '#62C462';
            }
//            $situacao = $item->situacao;
//            if (isset($item->medico)) {
//                $medico = $item->medico;
//            } else {
//                $medico = null;
//            }
//            $dia = date("d", strtotime($item->data_prevista));
//            $mes = date("m", strtotime($item->data_prevista));
//            $ano = date("Y", strtotime($item->data_prevista));
//            $medico = $item->medico;
//            if ($this->session->userdata('calendario_layout') == 't') {
//                $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaocalendario2?empresa=$empresa&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";
//            } else {
//                $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaocalendario?empresa=$empresa&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";
//            }

            $var[] = $retorno;
        }
//        echo '<pre>';
//        var_dump($var); die;
        echo json_encode($var);
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

    function solicitacarorcamento($solicitacao_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['solicitacao'] = $this->solicitacirurgia_m->listardadossolicitacaoorcamento($solicitacao_id);
        $data['procedimentos'] = $this->solicitacirurgia_m->listarprocedimentosolicitacaocirurgicaorcamento($solicitacao_id);
        $this->loadView('centrocirurgico/solicitacarorcamento-form', $data);
    }

    function solicitacarorcamentoconvenio($solicitacao_id) {
        $data['solicitacao_id'] = $solicitacao_id;
        $data['solicitacao'] = $this->solicitacirurgia_m->listardadossolicitacaoorcamentoconvenio($solicitacao_id);
        $data['procedimentos'] = $this->solicitacirurgia_m->listarprocedimentosolicitacaocirurgicaconvenio($solicitacao_id);
        $this->loadView('centrocirurgico/solicitacarorcamentoconvenio-form', $data);
    }

    function gerarelatoriocaixacirurgico() {
        $data['operador'] = $this->operador_m->listaroperador($_POST['operador']);
        $data['medico'] = $this->operador_m->listaroperador($_POST['medico']);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
//        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->centrocirurgico_m->relatoriocaixacirurgico();
//        echo '<pre>';
//        var_dump($data['relatorio']); die;
        $data['formapagamento'] = $this->formapagamento->listarforma();
        $this->load->View('ambulatorio/impressaorelatoriocaixacirurgico', $data);
    }

    function relatoriocaixacirurgico() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['grupos'] = $this->procedimento->listargrupos();
//        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
//        $data['grupomedico'] = $this->grupomedico->listargrupomedicos();
        $this->loadView('ambulatorio/relatoriocaixacirurgico', $data);
    }

    function fecharcaixacirurgico() {
//        echo '<pre>';
//        var_dump($_POST); die;
        $caixa = $this->centrocirurgico_m->fecharcaixacirurgico();
//        $this->guia->fecharcaixacredito();
//        echo 'mostre algo';
//        die;
        if ($caixa == "-1") {
            $data['mensagem'] = 'Erro ao fechar caixa. Opera&ccedil;&atilde;o cancelada.';
        } elseif ($caixa == 10) {
            $data['mensagem'] = 'Erro ao fechar caixa. Forma de pagamento não configurada corretamente.';
        } else {
            $data['mensagem'] = 'Sucesso ao fechar caixa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "centrocirurgico/centrocirurgico/relatoriocaixacirurgico", $data);
    }

    function montarequipe($solicitacaocirurgia_id) {
        $data['solicitacaocirurgia_id'] = $solicitacaocirurgia_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['equipe'] = $this->solicitacirurgia_m->listarequipe($solicitacaocirurgia_id);
        $data['equipe_operadores'] = $this->solicitacirurgia_m->listarequipeoperadores($solicitacaocirurgia_id);
        $data['grau_participacao'] = $this->solicitacirurgia_m->grauparticipacao();
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

    function autorizarsolicitacaocirurgica() {
        $this->solicitacirurgia_m->autorizarsolicitacaocirurgica();

        $guia_id = $this->solicitacirurgia_m->gravarguiasolicitacaocirurgica();

        if ($this->solicitacirurgia_m->gravarprocedimentosolicitacaocirurgica($guia_id)) {
            $data['mensagem'] = "Solicitação autorizada gravado com sucesso!";
        } else {
            $data['mensagem'] = "Erro ao gravar Orçamento. Opera&ccedil;&atilde;o cancelada.";
        }

        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function excluirprocedimentoscirurgia($solicitacao_cirurgia_procedimento_id, $guia_id, $solicitacao_id) {
//        var_dump($_POST); die;
        $this->solicitacirurgia_m->excluirprocedimentocirurgico($solicitacao_cirurgia_procedimento_id, $guia_id, $solicitacao_id);

        $this->solicitacirurgia_m->excluirentradasagendaexames($guia_id);

        $this->solicitacirurgia_m->gravarguiaeditarprocedimentoscirurgia($guia_id, $solicitacao_id);

        if ($this->solicitacirurgia_m->gravareditarprocedimentosolicitacaocirurgica($guia_id, $solicitacao_id)) {
            $data['mensagem'] = "Solicitação autorizada gravado com sucesso!";
        } else {
            $data['mensagem'] = "Erro ao gravar Orçamento. Opera&ccedil;&atilde;o cancelada.";
        }

        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/editarprocedimentoscirurgia/$solicitacao_id/$guia_id");
    }

    function gravareditarprocedimentoscirurgia($guia_id, $solicitacao_id) {
//        var_dump($_POST); die;
        $this->solicitacirurgia_m->gravarsolicitacaoeditarprocedimento($guia_id, $solicitacao_id);

        $this->solicitacirurgia_m->excluirentradasagendaexames($guia_id);

        $this->solicitacirurgia_m->gravarguiaeditarprocedimentoscirurgia($guia_id, $solicitacao_id);

        if ($this->solicitacirurgia_m->gravareditarprocedimentosolicitacaocirurgica($guia_id, $solicitacao_id)) {
            $data['mensagem'] = "Solicitação autorizada gravado com sucesso!";
        } else {
            $data['mensagem'] = "Erro ao gravar Orçamento. Opera&ccedil;&atilde;o cancelada.";
        }

        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/editarprocedimentoscirurgia/$solicitacao_id/$guia_id");
    }

    function gravareditarcirurgia() {

        if ($this->solicitacirurgia_m->gravareditarcirurgia()) {
            $data['mensagem'] = "Sucesso ao editar cirurgia!";
        } else {
            $data['mensagem'] = "Erro ao editar cirurgia. Opera&ccedil;&atilde;o cancelada.";
        }

        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisarcirurgia");
    }

    function gravarsolicitacaorcamento() {
        $orcamento_id = $this->solicitacirurgia_m->gravarsolicitacaorcamento();

        if ($this->solicitacirurgia_m->gravarsolicitacaorcamentoitens($orcamento_id)) {
            $data['mensagem'] = "Orçamento gravado com sucesso!";
        } else {
            $data['mensagem'] = "Erro ao gravar Orçamento. Opera&ccedil;&atilde;o cancelada.";
        }

        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function gravarsolicitacaorcamentoconvenio() {
        $orcamento_id = $this->solicitacirurgia_m->gravarsolicitacaorcamentoconvenio();

        if ($this->solicitacirurgia_m->gravarsolicitacaorcamentoconvenioitens($orcamento_id)) {
            $data['mensagem'] = "Orçamento gravado com sucesso!";
        } else {
            $data['mensagem'] = "Erro ao gravar Orçamento. Opera&ccedil;&atilde;o cancelada.";
        }

        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "centrocirurgico/centrocirurgico/pesquisar");
    }

    function internacaoalta($internacao_id) {

        $data['resultado'] = $this->internacao_m->internacaoalta($internacao_id);
    }

}

?>
