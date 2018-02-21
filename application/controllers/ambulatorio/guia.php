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
class Guia extends BaseController {

    function Guia() {
        parent::Controller();
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/modelodeclaracao_model', 'modelodeclaracao');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('ambulatorio/sala_model', 'sala');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/laboratorio_model', 'laboratorio');
        $this->load->model('cadastro/caixa_model', 'caixa');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('ambulatorio/indicacao_model', 'indicacao');
        $this->load->model('centrocirurgico/centrocirurgico_model', 'centrocirurgico_m');
        $this->load->model('cadastro/grupoconvenio_model', 'grupoconvenio');
        $this->load->model('cadastro/grupomedico_model', 'grupomedico');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/GExtenso', 'GExtenso');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($paciente_id) {
        $data['empresapermissoes'] = $this->guia->listarempresapermissoes();
        $data['exames'] = $this->guia->listarexames($paciente_id);
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->loadView('ambulatorio/guia-lista', $data);
    }

    function pesquisarfiladeimpressao($args = array()) {
        $this->loadView('ambulatorio/filadeimpressao-lista', $args);

//            $this->carregarView($data);
    }

    function acompanhamento($paciente_id) {
        $data['exames'] = $this->guia->listarexames($paciente_id);
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->loadView('ambulatorio/acompanhamento-lista', $data);
    }

    function voz() {
        $this->load->View('ambulatorio/aavoz');
    }

    function gravordevoz() {
        $this->load->View('ambulatorio/aagravadordevoz');
    }

    function impressaoguiaconsultaconvenio($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $dinheiro = $data['exame'][0]->dinheiro;
        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $exames = $data['exames'];

        $this->load->View('ambulatorio/impressaoguiaconsultaconvenio', $data);
    }

    function impressaoguiaconsultaspsadt($guia_id) {
        $data['guia_id'] = $guia_id;
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['relatorio'] = $this->guia->impressaoguiaconsultaspsadt($guia_id);
//        echo '<pre>';
//        var_dump($data['relatorio']); die;


        $this->load->View('ambulatorio/impressaoguiaspsadt', $data);
    }

    function impressaoguiaconsultaspsadtprocedimento($agenda_exames_id) {
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['relatorio'] = $this->guia->impressaoguiaconsultaspsadtprocedimento($agenda_exames_id);
//        echo '<pre>';
//        var_dump($data['relatorio']); die;


        $this->load->View('ambulatorio/impressaoguiaspsadtprocedimento', $data);
    }

    function chat() {
        $this->loadView('chat/formulario');
    }

    function fala() {
        $data['chamada'] = $this->guia->listarchamadas();
        $this->load->View('ambulatorio/aafala', $data);
    }

    function editarfichaxml($paciente_id, $exames_id) {
        $data['exames_id'] = $exames_id;
        $data['paciente_id'] = $paciente_id;

        $xml = $this->guia->listarfichaxml($exames_id);
        $texto = $this->guia->listarfichatexto($exames_id);


        $string = xml_convert($xml);

        $data['r1'] = substr($string, 86, 3);
        $data['r2'] = substr($string, 110, 3);
        $data['r3'] = substr($string, 134, 3);
        $data['r4'] = substr($string, 158, 3);
        $data['r5'] = substr($string, 182, 3);
        $data['r6'] = substr($string, 206, 3);
        $data['r7'] = substr($string, 230, 3);
        $data['r8'] = substr($string, 254, 3);
        $data['r9'] = substr($string, 278, 3);
        $data['r10'] = substr($string, 303, 3);
        $data['r11'] = substr($string, 329, 3);
        $data['r12'] = substr($string, 355, 3);
        $data['r13'] = substr($string, 381, 3);
        $data['r14'] = substr($string, 407, 3);
        $data['r15'] = substr($string, 433, 3);
        $data['r16'] = substr($string, 459, 3);
        $data['r17'] = substr($string, 485, 3);
        $data['r18'] = substr($string, 511, 3);
        $data['r19'] = substr($string, 537, 3);
        $data['r20'] = substr($string, 563, 3);

        $data['peso'] = $texto[0]->peso;
        $data['txtp9'] = $texto[0]->txtp9;
        $data['txtp19'] = $texto[0]->txtp19;
        $data['txtp20'] = $texto[0]->txtp20;
        $data['obs'] = $texto[0]->obs;

        $this->loadView('ambulatorio/fichaeditar-xml-form', $data);
    }

    function gravareditarfichaxml($paciente_id, $exames_id) {
        $this->guia->gravareditarfichaxml($exames_id);
        $this->pesquisar($paciente_id);
    }

    function fichaxml($paciente_id, $guia_id, $exames_id) {
        $data['exames_id'] = $exames_id;
        $data['paciente_id'] = $paciente_id;
        $data['guia_id'] = $guia_id;
        $teste = $this->guia->listarfichatexto($exames_id);
        if (isset($teste[0]->agenda_exames_id)) {
            $this->gravarfichaxml($paciente_id, $guia_id, $exames_id);
        } else {
            $this->loadView('ambulatorio/ficha-xml-form', $data);
        }
    }

    function gravarfichaxml($paciente_id, $guia_id, $exames_id) {
        $this->guia->gravarfichaxml($exames_id);
        $xml = $this->guia->listarfichaxml($exames_id);
        $texto = $this->guia->listarfichatexto($exames_id);


        $string = xml_convert($xml);

        $data['r1'] = substr($string, 86, 3);
        $data['r2'] = substr($string, 110, 3);
        $data['r3'] = substr($string, 134, 3);
        $data['r4'] = substr($string, 158, 3);
        $data['r5'] = substr($string, 182, 3);
        $data['r6'] = substr($string, 206, 3);
        $data['r7'] = substr($string, 230, 3);
        $data['r8'] = substr($string, 254, 3);
        $data['r9'] = substr($string, 278, 3);
        $data['r10'] = substr($string, 303, 3);
        $data['r11'] = substr($string, 329, 3);
        $data['r12'] = substr($string, 355, 3);
        $data['r13'] = substr($string, 381, 3);
        $data['r14'] = substr($string, 407, 3);
        $data['r15'] = substr($string, 433, 3);
        $data['r16'] = substr($string, 459, 3);
        $data['r17'] = substr($string, 485, 3);
        $data['r18'] = substr($string, 511, 3);
        $data['r19'] = substr($string, 537, 3);
        $data['r20'] = substr($string, 563, 3);
        $data['r21'] = substr($string, 589, 3);

        $data['peso'] = $texto[0]->peso;
        $data['txtp9'] = $texto[0]->txtp9;
        $data['txtp19'] = $texto[0]->txtp19;
        $data['txtp20'] = $texto[0]->txtp20;
        $data['obs'] = $texto[0]->obs;


        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $dinheiro = $data['exame'][0]->dinheiro;

        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $exames = $data['exames'];
        $valor_total = 0;

        foreach ($exames as $item) :
            if ($dinheiro == "t") {
                $valor_total = $valor_total + ($item->valor_total);
            }
        endforeach;

        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $valor = number_format($valor_total, 2, ',', '.');

        $data['valor'] = $valor;

        if ($valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {

            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            if ($dinheiro == "t") {
                $data['extenso'] = GExtenso::moeda($valoreditado);
            }
        }
//        var_dump($data['r1'] ,$data['r2'] , $data['r3'] , $data['r4'], $data['r5'] , $data['r6'] , $data['r7'] , $data['r8'], $data['r9'] , $data['r10'],$data['r11'],$data['r12'],$data['r13'],$data['r14'],$data['r15'],$data['r16'],$data['r17'],$data['r18'],$data['r19'],$data['r20']);
//        die;

        $this->load->view('ambulatorio/impressaoficharm', $data);
//        $this->load->view('ambulatorio/impressaoficharm-verso');
    }

    function impressaoficha($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $data['ordem_atendimento'] = $this->exame->listarexamesficha();
        $data['grupos'] = $this->guia->listargrupoficha($guia_id, $grupo);
//        echo '<pre>';
//        var_dump($data['lista']); die;
//        $grupo = $data['exame'][0]->grupo;
        $dinheiro = $data['exame'][0]->dinheiro;

        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $exames = $data['exames'];
        $valor_total = 0;

        foreach ($exames as $item) :
            if ($dinheiro == 't') {
                if ($item->dinheiro == "t") {
                    $valor_total = $valor_total + ($item->valor_total);
                }
            }
        endforeach;

        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $valor = number_format($valor_total, 2, ',', '.');

        $data['valor'] = $valor;

        if ($valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {

            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            if ($dinheiro == "t") {
                $data['extenso'] = GExtenso::moeda($valoreditado);
            }
        }
//        var_dump($grupo);
//        die;

        if ($data['empresa'][0]->impressao_tipo == 1) { //HUMANA 
            if ($grupo == "RX" || $grupo == "US" || $grupo == "CONSULTA" || $grupo == "LABORATORIAL") {
                $this->load->View('ambulatorio/impressaofichaus', $data);
            }
            if ($grupo == "MAMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichamamografia', $data);
            }
            if ($grupo == "DENSITOMETRIA") {
                $this->load->View('ambulatorio/impressaofichadensitometria', $data);
            }
            if ($grupo == "RM") {
                $this->fichaxml($paciente_id, $guia_id, $exames_id);
            }
        }

///////////////////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 2) { //PROIMAGEM 
            //criar codigo de barras (inicio)
            foreach ($exames as $value) {
                if (!is_dir("./upload/barcodeimg/")) {
                    mkdir("./upload/barcodeimg/");
                    chmod("./upload/barcodeimg/", 0777);
                }
                if (!is_dir("./upload/barcodeimg/$value->paciente_id/")) {
                    mkdir("./upload/barcodeimg/$value->paciente_id/");
                    chmod("./upload/barcodeimg/$value->paciente_id/", 0777);
                }
                $this->utilitario->barcode($value->agenda_exames_id, "./upload/barcodeimg/$value->paciente_id/$value->agenda_exames_id.png", $size = "20", "horizontal", "code128", true, 1);
            }
            // criar codigo de barras (fim)
            if ($grupo == "RX" || $grupo == "US" || $grupo == "RM" || $grupo == "DENSITOMETRIA" || $grupo == "TOMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichausproimagem', $data);
            }
            if ($grupo == "MAMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichamamografiaproimagem', $data);
            }
        }

///////////////////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 3) {// CLINICAS PACAJUS
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsulta', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaofichageralparticular', $data);
                } else {
                    $this->load->View('ambulatorio/impressaofichageral', $data);
                }
            }
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 21) {// CLINICAS NOSSA SENHORA AUXILIADORA
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultacnsa', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaofichageralparticularcnsa', $data);
                } else {
                    $this->load->View('ambulatorio/impressaofichageralcnsa', $data);
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 20) { // CLINICAS SANTA IMAGEM
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultasantaimagem', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaofichageralsantaimagem', $data);
                } else {
                    $this->load->View('ambulatorio/impressaofichageralsantaimagem', $data);
                }
            }
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 4) {// CLINICAS FISIOCLINICA
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultafisioclinica', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaofichageralparticular', $data);
                } else {
                    $this->load->View('ambulatorio/impressaofichageral', $data);
                }
            }
        }

///////////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 5) {// COT CLINICA
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultacot', $data);
            }
            elseif ($grupo == "FISIOTERAPIA" || $grupo == "ESPECIALIDADE" || $grupo == "ODONTOLOGIA") {
                $this->load->View('ambulatorio/impressaofichafisioterapia', $data);
            }
            elseif ($data['exame'][0]->tipo == "EXAME") {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaofichaconsultacot', $data);
                } else {
                    $this->load->View('ambulatorio/impressaofichaconsultacot', $data);
                }
            }
            else{
                $this->load->View('ambulatorio/impressaofichaconsultacot', $data);
            }
        }

///////////////////////////////////////////////////////////////////////////////////////////////       
        elseif ($data['empresa'][0]->impressao_tipo == 6) {// CLINICA dez
            $this->load->View('ambulatorio/impressaofichageralparticular', $data);
        }
//            
        elseif ($data['empresa'][0]->impressao_tipo == 10) {//      CLINICA MED
            $this->load->View('ambulatorio/impressaofichageral', $data);
        }

///////////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 8) { //RONALDO
            if ($dinheiro == "t") {
                $this->load->View('ambulatorio/impressaofichageralronaldoparticular', $data);
            } else {
                $this->load->View('ambulatorio/impressaofichageralronaldo', $data);
            }
        }

///////////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 14) {//MedLab
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichamedlabrecibo', $data);
            } elseif ($grupo == "RM") {
                $this->fichaxml($paciente_id, $guia_id, $exames_id);
            } else {
                $this->load->View('ambulatorio/impressaofichageral', $data);
            }
        }

///////////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 49) {//CITYCOR COM INFORMACOES DA HUMANA
            if ($dinheiro == "t") {
                $this->load->View('ambulatorio/impressaofichageralparticularcitycor', $data);
            } else {
                $this->load->View('ambulatorio/impressaofichageralcitycor', $data);
            }
        }

///////////////////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 9) { // CLINICA SAO PAULO
            $this->load->View('ambulatorio/impressaofichaconsultasaopaulo', $data);
        } else { //GERAL
            if ($dinheiro == "t") {
                $this->load->View('ambulatorio/impressaofichageralparticular', $data);
            } else {
                $this->load->View('ambulatorio/impressaofichageral', $data);
            }
//            $this->load->View('ambulatorio/', $data);
        }
//        echo 'something'; die;
    }

    function impressaoorcamento($orcamento) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exames'] = $this->guia->listarexamesorcamento($orcamento);
        
        $data['permissoes'] = $this->guia->listarempresapermissoes($empresa_id);
        $data['impressaoorcamento'] = $this->guia->listarconfiguracaoimpressaoorcamento($empresa_id);
        $data['cabecalhoconfig'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalho'] =  @$data['cabecalhoconfig'][0]->cabecalho;
        $data['rodape'] =  @$data['cabecalhoconfig'][0]->rodape;
//        var_dump($data['exames']); die;
        
        if($data['permissoes'][0]->orcamento_config == 't'){
           $this->load->View('ambulatorio/impressaoorcamentorecepcaoconfiguravel', $data);    
        }elseif($data['empresa'][0]->impressao_orcamento == 1){// MODELO SOLICITADO PELA AME
           $this->load->View('ambulatorio/impressaoorcamentorecepcao1', $data);    
        }else{
           $this->load->View('ambulatorio/impressaoorcamento', $data);    
        }
        
        
    }

    function impressaofichaconvenio($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $convenioid = $data['exame'][0]->convenio_id;
        $dinheiro = $data['exame'][0]->dinheiro;
        $data['exames'] = $this->guia->listarexamesguiaconvenio($guia_id, $convenioid);
        $exames = $data['exames'];
        $valor_total = 0;

        foreach ($exames as $item) :
            if ($dinheiro == 't') {
                if ($item->dinheiro == "t") {
                    $valor_total = $valor_total + ($item->valor_total);
                }
            }
        endforeach;

        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $valor = number_format($valor_total, 2, ',', '.');

        $data['valor'] = $valor;

        if ($valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {
            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            if ($dinheiro == "t") {
                $data['extenso'] = GExtenso::moeda($valoreditado);
            }
        }
        if ($data['empresa'][0]->impressao_tipo == 1) {//HUMANA        
            if ($grupo == "RX" || $grupo == "US" || $grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaus', $data);
            }
            if ($grupo == "MAMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichamamografia', $data);
            }
            if ($grupo == "DENSITOMETRIA") {
                $this->load->View('ambulatorio/impressaofichadensitometria', $data);
            }
            if ($grupo == "RM") {
                $this->load->View('ambulatorio/impressaoficharm', $data);
            }
        }

////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 2) {//PROIMAGEM 
            //criar codigo de barras (inicio)
            foreach ($exames as $value) {
                if (!is_dir("./upload/barcodeimg/")) {
                    mkdir("./upload/barcodeimg/");
                    chmod("./upload/barcodeimg/", 0777);
                }
                if (!is_dir("./upload/barcodeimg/$value->paciente_id/")) {
                    mkdir("./upload/barcodeimg/$value->paciente_id/");
                    chmod("./upload/barcodeimg/$value->paciente_id/", 0777);
                }
                $this->utilitario->barcode($value->agenda_exames_id, "./upload/barcodeimg/$value->paciente_id/$value->agenda_exames_id.png", $size = "20", "horizontal", "code128", true, 1);
            }
            // criar codigo de barras (fim)

            if ($grupo == "RX" || $grupo == "US" || $grupo == "RM" || $grupo == "DENSITOMETRIA" || $grupo == "TOMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichausproimagem', $data);
            }
            if ($grupo == "MAMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichamamografiaproimagem', $data);
            }
        }

/////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 3) {//CLINICAS PACAJUS
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsulta', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaoficharonaldoparticular', $data);
                } else {
                    $this->load->View('ambulatorio/impressaoficharonaldo', $data);
                }
            }
        }

///////////////////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 21) {// CLINICAS NOSSA SENHORA AUXILIADORA
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultacnsa', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaofichageralparticularcnsa', $data);
                } else {
                    $this->load->View('ambulatorio/impressaofichageralcnsa', $data);
                }
            }
        }

////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 4) {//  CLINICAS FISIOCLINICA
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultafisioclinica', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaofichafisioclinicaparticular', $data);
                } else {
                    $this->load->View('ambulatorio/impressaofichafisioclinica', $data);
                }
            }
        }

/////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 5) {// COT CLINICA
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultacot', $data);
            }
            if ($grupo == "FISIOTERAPIA") {
                $this->load->View('ambulatorio/impressaofichafisioterapia', $data);
            }
            if ($data['exame'][0]->tipo == "EXAME") {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaoficharonaldoparticular', $data);
                } else {
                    $this->load->View('ambulatorio/impressaoficharonaldo', $data);
                }
            }
        }

/////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 6) {// CLINICA dez
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultadez', $data);
            }
            if ($data['exame'][0]->tipo == "EXAME") {
                $this->load->View('ambulatorio/impressaofichaexamedez', $data);
            }
        }

////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 7) {// CLINICA MED
            $this->load->View('ambulatorio/impressaofichamed', $data);
        }

////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 8) {// RONALDO
            if ($dinheiro == "t") {
                $this->load->View('ambulatorio/impressaoficharonaldoparticular', $data);
            } else {
                $this->load->View('ambulatorio/impressaoficharonaldo', $data);
            }
        }

////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 9) {//CLINICA SAO PAULO
            $this->load->View('ambulatorio/impressaofichaconsultasaopaulo', $data);
        }
    }

    function impressaoetiiqueta($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $data['empresa_id'] = $this->guia->listarempresa($empresa_id);
        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        if ($data['empresa'][0]->impressao_tipo == 2) {// Proimagem
            $this->load->View('ambulatorio/impressaoetiquetaexameproimagem', $data);
        } else {
            $this->load->View('ambulatorio/impressaoetiquetaexame', $data);
        }
    }

    function impressaoetiquetaunica($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $data['exame'] = $this->guia->listarexame($exames_id);
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        if ($data['empresa'][0]->impressao_tipo == 1) { //HUMANA 
            $this->load->View('ambulatorio/impressaoetiquetaunicahumana', $data);
        } else {
            $this->load->View('ambulatorio/impressaoetiquetaunica', $data);
        }
    }

    function teste() {
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/20/");
        $this->load->View('ambulatorio/teste-lista', $data);

//            $this->carregarView($data);
    }

    function anexarimagem($guia_id) {

        $this->load->helper('directory');
        if (!is_dir("./upload/guia/$guia_id")) {
            mkdir("./upload/guia/$guia_id");
            $destino = "./upload/guia/$guia_id";
            chmod($destino, 0777);
        }
//        $data['arquivo_pasta'] = directory_map("./upload/$paciente_id/");
        $data['arquivo_pasta'] = directory_map("./upload/guia/$guia_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['guia_id'] = $guia_id;
        $this->loadView('ambulatorio/importacao-imagemguia', $data);
    }

    function importarimagem() {
        $guia_id = $_POST['guia_id'];
        if (!is_dir("./upload/guia/$guia_id")) {
            mkdir("./upload/guia/$guia_id");
            $destino = "./upload/guia/$guia_id";
            chmod($destino, 0777);
        }

        $config['upload_path'] = "./upload/guia/" . $guia_id . "/";
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
        $data['guia_id'] = $guia_id;
        $this->anexarimagem($guia_id);
    }

    function excluirimagem($guia_id, $nome) {

        if (!is_dir("./uploadopm/guia/$guia_id")) {
            mkdir("./uploadopm/guia");
            mkdir("./uploadopm/guia/$guia_id");
            $destino = "./uploadopm/guia/$guia_id";
            chmod($destino, 0777);
        }

        $origem = "./upload/guia/$guia_id/$nome";
        $destino = "./uploadopm/guia/$guia_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        $this->anexarimagem($guia_id);
    }

    function galeria($exame_id) {
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
        $data['exame_id'] = $exame_id;
        $this->load->View('ambulatorio/galeria-lista', $data);

//            $this->carregarView($data);
    }

    function teste2() {
        $teste1 = $_POST['teste'];
//        $teste2 = $_POST['teste'];
//        $teste3 = $_POST['teste'];
//        $teste4 = $_POST['teste'];
        var_dump($teste1);
//        var_dump($teste2);
//        var_dump($teste3);
//        var_dump($teste4);
        die;
        $this->load->View('ambulatorio/teste-lista');

//            $this->carregarView($data);
    }

    function carregarsala($ambulatorio_guia_id) {
        $obj_guia = new sala_model($ambulatorio_guia_id);
        $data['obj'] = $obj_guia;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/guia-form', $data);
    }

    function excluir($exame_sala_id) {
        if ($this->procedimento->excluir($exame_sala_id)) {
            $mensagem = 'Sucesso ao excluir a Sala';
        } else {
            $mensagem = 'Erro ao excluir a sala. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/sala");
    }

    function gravar($paciente_id) {
        $ambulatorio_guia_id = $this->guia->gravar($paciente_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Sala. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Sala.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        redirect(base_url() . "ambulatorio/guia/novo/$data");
    }

    function fecharcaixapersonalizado() {
        $caixa = $this->guia->fecharcaixapersonalizado();
        $this->guia->fecharcaixapersonalizadocredito();
        
        if ($caixa == "-1") {
            $data['mensagem'] = 'Erro ao fechar caixa. Opera&ccedil;&atilde;o cancelada.';
        } elseif ($caixa == 10) {
            $data['mensagem'] = 'Erro ao fechar caixa. Forma de pagamento não configurada corretamente.';
        } else {
            $data['mensagem'] = 'Sucesso ao fechar caixa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/relatoriocaixapersonalizado", $data);
    }

    function fecharcaixa() {
//        echo '<pre>';
//        var_dump($_POST); die;
        $caixa = $this->guia->fecharcaixa();
        $this->guia->fecharcaixacredito();
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
        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
    }

    function fecharmedico() {
        if ($_POST['conta'] == '') {
            $data['mensagem'] = 'Para fechar o caixa é necessário ter uma Conta associada ao cadastro do médico';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/relatoriomedicoconveniofinanceiro", $data);
        }

        if ($_POST['nome'] == '') {
            $data['mensagem'] = 'Para fechar o caixa é necessário ter um Credor associado ao cadastro do médico.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/relatoriomedicoconveniofinanceiro", $data);
        }

        if ($_POST['tipo'] == '') {
            $data['mensagem'] = 'Para fechar o caixa é necessário ter um Tipo associado ao cadastro do médico.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/relatoriomedicoconveniofinanceiro", $data);
        }

        if ($_POST['classe'] == '') {
            $data['mensagem'] = 'Para fechar o caixa é necessário ter uma Classe associada ao cadastro do médico.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/relatoriomedicoconveniofinanceiro", $data);
        }
        $empresa_id = $this->session->userdata('empresa_id');

        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data_contaspagar = $data['empresa'][0]->data_contaspagar;
        $caixa = $this->guia->fecharmedico($data_contaspagar);
        if ($caixa == "-1") {
            $data['mensagem'] = 'Erro ao fechar a produção do médico. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao fechar a produção do médico.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/relatoriomedicoconveniofinanceiro", $data);
    }
    
    function fecharlaboratorio() {
        if ($_POST['conta'] == '') {
            $data['mensagem'] = 'Para fechar o caixa é necessário ter uma Conta associada ao cadastro do laboratório';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/relatoriolaboratorioconveniofinanceiro", $data);
        }

        if ($_POST['nome'] == '') {
            $data['mensagem'] = 'Para fechar o caixa é necessário ter um Credor associado ao cadastro do laboratório.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/relatoriolaboratorioconveniofinanceiro", $data);
        }

        if ($_POST['tipo'] == '') {
            $data['mensagem'] = 'Para fechar o caixa é necessário ter um Tipo associado ao cadastro do laboratório.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/relatoriolaboratorioconveniofinanceiro", $data);
        }

        if ($_POST['classe'] == '') {
            $data['mensagem'] = 'Para fechar o caixa é necessário ter uma Classe associada ao cadastro do laboratório.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/relatoriolaboratorioconveniofinanceiro", $data);
        }
        $empresa_id = $this->session->userdata('empresa_id');

        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data_contaspagar = $data['empresa'][0]->data_contaspagar;
        $caixa = $this->guia->fecharlaboratorio($data_contaspagar);
        if ($caixa == "-1") {
            $data['mensagem'] = 'Erro ao fechar a produção do laboratório. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao fechar a produção do laboratório.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/relatoriolaboratorioconveniofinanceiro", $data);
    }

    function gravarprocedimentos() {
        $procedimentopercentual = $_POST['procedimento1'];
        $medicopercentual = $_POST['medicoagenda'];
        $percentual = $this->guia->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
        if (count($percentual) == 0) {
            $percentual = $this->guia->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
        }
//        $grupo = $this->exametemp->verificagrupoprocedimento($procedimentopercentual);
//        if ($grupo == 'LABORATORIAL') {
        $percentual_laboratorio = $this->guia->percentuallaboratorioconvenioexames($procedimentopercentual);
//        } else {
//            $percentual_laboratorio = array();
//        }
        
        $paciente_id = $_POST['txtpaciente_id'];
        
        if ($_POST['crm1'] == '') {
            $data['mensagem'] = 'Favor, selecione um medico solicitante da lista.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novo/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novo/$paciente_id");
            }
        }
        elseif ($_POST['sala1'] == '' || $_POST['medicoagenda'] == '' || $_POST['qtde1'] == '' || $_POST['medico1'] == '' || $_POST['convenio1'] == -1 || $_POST['procedimento1'] == '') {
            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novo/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novo/$paciente_id");
            }
        } else {

            if ($_POST["valor1"] == 'null') {
                $_POST["valor1"] = 0;
            }


            $medico_id = $_POST['crm1'];
            $paciente_id = $_POST['txtpaciente_id'];
            $resultadoguia = $this->guia->listarguia($paciente_id);

            if ($_POST['medicoagenda'] != '') {
                if ($resultadoguia == null) {
                    $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
                } else {
                    $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                }
                $this->guia->gravarexames($ambulatorio_guia, $medico_id, $percentual, $percentual_laboratorio);
            }

            redirect(base_url() . "ambulatorio/guia/novo/$paciente_id/$ambulatorio_guia");
        }
    }

    function gravarprocedimentosgeral() {
//        ini_set('display_errors',1);
//        ini_set('display_startup_erros',1);
//        error_reporting(E_ALL);
        $paciente_id = $_POST['txtpaciente_id'];
        if ($_POST['sala1'] == '' || $_POST['medicoagenda'] == '' || $_POST['qtde1'] == '' || $_POST['convenio1'] == -1 || $_POST['procedimento1'] == '') {
            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novoatendimento/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novoatendimento/$paciente_id");
            }
        } else {
            $procedimentopercentual = $_POST['procedimento1'];
            $medicopercentual = $_POST['medicoagenda'];
            $medico_id = $_POST['crm1'];
            $resultadoguia = $this->guia->listarguia($paciente_id);
            $percentual = $this->guia->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
            if (count($percentual) == 0) {
                $percentual = $this->guia->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
            }
//            $grupo = $this->exametemp->verificagrupoprocedimento($procedimentopercentual);
//            if ($grupo == 'LABORATORIAL') {
            $percentual_laboratorio = $this->guia->percentuallaboratorioconvenioexames($procedimentopercentual);
//            } else {
//                $percentual_laboratorio = array();
//            }
            
            if ($_POST['crm1'] == '' && $grupo != 'CONSULTA') {
                $data['mensagem'] = 'Favor, selecione um medico solicitante da lista.';
                $this->session->set_flashdata('message', $data['mensagem']);
                if (isset($_POST['guia_id'])) {
                    $guia_id = $_POST['guia_id'];
                    redirect(base_url() . "ambulatorio/guia/novoatendimento/$paciente_id/$guia_id");
                } else {
                    redirect(base_url() . "ambulatorio/guia/novoatendimento/$paciente_id");
                }
            }


            if ($_POST['medicoagenda'] != '') {
//        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                if ($resultadoguia == null) {
                    $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
                } else {
                    $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                }
//            $this->gerardicom($ambulatorio_guia);
                $tipo = $this->guia->verificaexamemedicamento($_POST['procedimento1']);
                if (($tipo == 'EXAME' || $tipo == 'MEDICAMENTO' || $tipo == 'MATERIAL') && $medico_id == '') {
                    $data['mensagem'] = 'ERRO: Obrigatório preencher solicitante.';
                    $this->session->set_flashdata('message', $data['mensagem']);
                } else {
                    if ($tipo != 'AGRUPADOR') {
                        $this->guia->gravaratendimemto($ambulatorio_guia, $medico_id, $percentual, $percentual_laboratorio);
                    } else {
                        // Cria um agrupador para o pacote
                        $agrupador_id = $this->guia->gravaragrupadorpacote($_POST['procedimento1']);

                        // Traz os procedimentos desse pacote bem como o valor
                        $pacoteProc = $this->guia->listarprocedimentospacote($_POST['procedimento1']);

                        /* Caso a pessoa tenha dado um valor diferenciado para o pacote, para descobrir o valor unitario,
                         * ele vai pegar o valor total do pacote e dividir pela quantidade de procedimentos do pacote */
                        if ($pacoteProc[0]->valor_pacote_diferenciado != 't') {
                            $valorTotal = 0;
                            foreach ($pacoteProc as $value) {
                                $valorTotal += $value->valortotal;
                            }
                        }

                        foreach ($pacoteProc as $value) {

                            if ($value->valor_pacote_diferenciado != 't') {
                                // Caso seja um valor diferenciado, ele vai descobrir o valor unitário
                                $valor = $valorTotal / count($pacoteProc);
                            } else {
                                $valor = $value->valortotal;
                            }

                            $this->guia->gravaratendimentoagrupador($ambulatorio_guia, $medico_id, $agrupador_id, $value->procedimento_convenio_id, $valor, $value->valor_pacote_diferenciado);
                        }
                    }
                }
            }

            redirect(base_url() . "ambulatorio/guia/novoatendimento/$paciente_id/$ambulatorio_guia");
        }
    }

    function gravarorcamento() {

        $paciente_id = $_POST['txtpaciente_id'];
        if ($_POST['procedimento1'] == '' || $_POST['convenio1'] == '-1' || $_POST['qtde1'] == '') {
            $data['mensagem'] = 'Informe o convenio, o procedimento e a quantidade.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/orcamento/$paciente_id");
        } else {
            $resultadoorcamento = $this->guia->listarorcamento($paciente_id);
            //        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
            if ($resultadoorcamento == null) {
                $ambulatorio_orcamento = $this->guia->gravarorcamento($paciente_id);
            } else {
                $ambulatorio_orcamento = $resultadoorcamento['ambulatorio_orcamento_id'];
            }
            //            $this->gerardicom($ambulatorio_guia);
            $this->guia->gravarorcamentoitem($ambulatorio_orcamento);
            redirect(base_url() . "ambulatorio/guia/orcamento/$paciente_id/$ambulatorio_orcamento");
        }
    }

    function gravarprocedimentosconsulta() {
        $procedimentopercentual = $_POST['procedimento1'];
        $medicopercentual = $_POST['medicoagenda'];
        $percentual = $this->guia->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
        if (count($percentual) == 0) {
            $percentual = $this->guia->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
        }
        
        $percentual_laboratorio = $this->guia->percentuallaboratorioconvenioexames($procedimentopercentual);
//        var_dump($percentual_laboratorio); die;
        $paciente_id = $_POST['txtpaciente_id'];

        if ($_POST['sala1'] == '' || $_POST['medicoagenda'] == '' || $_POST['qtde1'] == '' || $_POST['convenio1'] == -1 || $_POST['procedimento1'] == '') {

            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novoconsulta/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novoconsulta/$paciente_id");
            }
        } else {
            $resultadoguia = $this->guia->listarguia($paciente_id);
            if ($_POST['medicoagenda'] != '') {
                //        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                if ($resultadoguia == null) {
                    $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
                } else {
                    $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                }
                $this->guia->gravarconsulta($ambulatorio_guia, $percentual, $percentual_laboratorio);
            }
            //        $this->gerardicom($ambulatorio_guia);
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/novoconsulta/$paciente_id/$ambulatorio_guia");
        }
    }

    function gravarprocedimentosfisioterapia() {
        $procedimentopercentual = $_POST['procedimento1'];
        $medicopercentual = $_POST['medicoagenda'];
//        var_dump($percentual); die;
        $i = 1;
        $paciente_id = $_POST['txtpaciente_id'];
//        die('teste');
        if ($_POST['crm1'] == '') {
            $data['mensagem'] = 'Favor, selecione um medico solicitante da lista.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id");
            }
        } elseif ($_POST['sala1'] == '' || $_POST['medicoagenda'] == '' || $_POST['convenio1'] == -1 || $_POST['procedimento1'] == '') {
            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id");
            }
        } else {
            
            $percentual = $this->guia->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
            if (count($percentual) == 0) {
                $percentual = $this->guia->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
            }
            
            $resultadoguia = $this->guia->listarguia($paciente_id);

            //verifica se existem sessões abertas
            $retorno = $this->guia->verificasessoesabertas($_POST['procedimento1'], $_POST['txtpaciente_id']);

//            var_dump($retorno);die;

            if ($retorno == false) {
                if ($_POST['medicoagenda'] != '') {
                    //        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                    if ($resultadoguia == null) {
                        $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
                    } else {
                        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                    }
                    $medico_id = $_POST['crm1'];
                    $this->guia->gravarfisioterapia($ambulatorio_guia, $percentual, $medico_id);
                }
                //        $this->gerardicom($ambulatorio_guia);
                //            $this->session->set_flashdata('message', $data['mensagem']);
                if ($_POST['homecare'] == 't') {
                    $messagem = 'Operação Realizada com Sucesso';
                    $this->session->set_flashdata('message', $messagem);
                    redirect(base_url() . "ambulatorio/exame/autorizarsessaofisioterapia/$paciente_id", $data);
                } else {
                    redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$ambulatorio_guia/$i");
                }
            } else {
                $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                $messagem = 'Não autorizado, existem sessões abertas para essa especialidade';
                $this->session->set_flashdata('message', $messagem);
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$ambulatorio_guia");
            }
        }
    }

    function gravarprocedimentospsicologia() {
        $i = 1;
        $paciente_id = $_POST['txtpaciente_id'];
        $resultadoguia = $this->guia->listarguia($paciente_id);
        if ($_POST['medicoagenda'] != '') {
//        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
            if ($resultadoguia == null) {
                $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
            } else {
                $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
            }
            $this->guia->gravarpsicologia($ambulatorio_guia);
        }
//        $this->gerardicom($ambulatorio_guia);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$ambulatorio_guia/$messagem/$i");
    }

    function gravarprocedimentosfaturamento() {

        $guia_id = $_POST['txtguia_id'];
        $paciente_id = $_POST['txtpaciente_id'];
        $this->guia->gravarexamesfaturamento();
        redirect(base_url() . "ambulatorio/exame/faturarguia/$guia_id/$paciente_id");
    }

    function gravarprocedimentosfaturamentomatmed() {

        $guia_id = $_POST['txtguia_id'];
        $paciente_id = $_POST['txtpaciente_id'];
        $this->guia->gravarexamesfaturamentomatmed();
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function editarexames() {
        $procedimentopercentual = $_POST['procedimento1'];
        $medicopercentual = $_POST['medico_agenda'];
        // Calcula o Percentual do médico para salvar na agenda_exames
        $percentual = $this->guia->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
//        var_dump($percentual);
//        die;
        if (count($percentual) == 0) {
            $percentual = $this->guia->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
        }

        $paciente_id = $_POST['txtpaciente_id'];
        $ambulatorio_guia_id = $this->guia->editarexames($percentual);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Dados. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Dados.';
        }
        redirect(base_url() . "ambulatorio/guia/pesquisar/" . $paciente_id);
    }

    function editarexame($paciente_id, $guia_id, $ambulatorio_guia_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['operadores'] = $this->operador_m->listaroperadores();
        $data['indicacao_selecionada'] = $this->exame->listarindicacaoagenda($ambulatorio_guia_id);
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['salas'] = $this->guia->listarsalas();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['selecionado'] = $this->guia->editarexamesselect($ambulatorio_guia_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['guia_id'] = $guia_id;
        $this->loadView('ambulatorio/editarexame-form', $data);
    }

    function valorexamesfaturamento() {
        $paciente_id = $_POST['txtpaciente_id'];
        $guia_id = $_POST['guia_id'];
        $verifica = $this->guia->valorexamesfaturamento();
        if ($verifica == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Dados. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Dados.';
        }
        redirect(base_url() . "ambulatorio/exame/faturarguia/{$guia_id}/{$paciente_id}");
    }

    function valorexames() {
        $paciente_id = $_POST['txtpaciente_id'];
        $agenda_exames_id = $_POST['agenda_exames_id'];
        $procedimentopercentual = $_POST['procedimento1'];
        $medicopercentual = $_POST['medico_agenda'];
        // Calcula o Percentual do médico para salvar na agenda_exames
        $percentual = $this->guia->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
        if (count($percentual) == 0) {
            $percentual = $this->guia->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
        }
        // Caso seja um procedimento laboratorial
//        $grupo = $this->exametemp->verificagrupoprocedimento($procedimentopercentual);
//        if ($grupo == 'LABORATORIAL') {
        $percentual_laboratorio = $this->guia->percentuallaboratorioconvenioexames($procedimentopercentual);
//        } else {
//            $percentual_laboratorio = array();
//        }
        
        $dadosantigos = $this->guia->listardadosantigoseditarvalor($agenda_exames_id);
        $ambulatorio_guia_id = $this->guia->valorexames($percentual, $percentual_laboratorio);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Dados. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Dados.';
        }
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
//        $this->pesquisar($paciente_id);
    }

    function valorexamefaturamento($paciente_id, $guia_id, $ambulatorio_guia_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['guia_id'] = $guia_id;
        $this->loadView('ambulatorio/valorexamefaturamento-form', $data);
    }

    function valorexame($paciente_id, $guia_id, $ambulatorio_guia_id) {
        $agenda_exames_id = $ambulatorio_guia_id;
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['forma_pagamento'] = $this->guia->formadepagamentoguianovo();
        $data['exame'] = $this->guia->listarexamealterarvalor($agenda_exames_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['guia_id'] = $guia_id;
        $this->loadView('ambulatorio/valorexame-form', $data);
    }

    function orcamento($paciente_id, $ambulatorio_orcamento_id = null) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['responsavel'] = $this->exametemp->listaresponsavelorcamento($paciente_id);
        $data['forma_pagamento'] = $this->guia->formadepagamentoguianovo();
//        var_dump($data['responsavel']);die;
        $data['exames'] = $this->exametemp->listarorcamentos($paciente_id);
        $data['ambulatorio_orcamento_id'] = $ambulatorio_orcamento_id;
        $this->loadView('ambulatorio/orcamento-form', $data);
    }

    function orcamentocadastrofila($orcamento) {

        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exames'] = $this->guia->listarexamesorcamento($orcamento);
        $html = $this->load->View('ambulatorio/impressaoorcamento', $data, true);

        $html = utf8_decode($html);
        $tipo = 'ORÇAMENTO';
        $this->guia->gravarfiladeimpressao($html, $tipo);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirorcamento($ambulatorio_orcamento_item_id, $paciente_id, $orcamento_id) {
        if ($this->exametemp->excluirorcamento($ambulatorio_orcamento_item_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimento';
        } else {
            $mensagem = 'Erro ao excluir o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/orcamento/$paciente_id/$orcamento_id");
    }

    function novo($paciente_id, $ambulatorio_guia_id = null) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['salas'] = $this->guia->listarsalas();
        $data['medicos'] = $this->operador_m->listarmedicos();
//        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['forma_pagamento'] = $this->guia->formadepagamentoguianovo();
        $data['grupo_pagamento'] = $this->formapagamento->listargrupos();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaraexamespaciente($ambulatorio_guia_id);
        $data['grupos'] = $this->procedimento->listargruposexame();

        $data['x'] = 0;
        foreach ($data['exames'] as $value) {
            $teste = $this->exametemp->verificaprocedimentosemformapagamento($value->procedimento_tuss_id);
            if (empty($teste)) {
                $data['x'] ++;
            }
        }

        $data['contador'] = $this->exametemp->contadorexamespaciente($ambulatorio_guia_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $this->loadView('ambulatorio/guia-form', $data);
    }

    function novoconsulta($paciente_id, $ambulatorio_guia_id = null) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['salas'] = $this->guia->listarsalas();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['grupo_pagamento'] = $this->formapagamento->listargrupos();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
        $data['exames'] = $this->exametemp->listaraexamespaciente($ambulatorio_guia_id);
        $data['grupos'] = $this->procedimento->listargruposconsulta();
        $data['x'] = 0;
        foreach ($data['exames'] as $value) {
            $teste = $this->exametemp->verificaprocedimentosemformapagamento($value->procedimento_tuss_id);
            if (empty($teste)) {
                $data['x'] ++;
            }
        }

        $data['contador'] = $this->exametemp->contadorexamespaciente($ambulatorio_guia_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $this->loadView('ambulatorio/guiaconsulta-form', $data);
    }

    function novofisioterapia($paciente_id, $ambulatorio_guia_id = null, $i = null) {
//        $lista = $this->exame->autorizarsessaofisioterapia($paciente_id);
//        if (count($lista) == 0) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['salas'] = $this->guia->listarsalas();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['grupo_pagamento'] = $this->formapagamento->listargrupos();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['consultasanteriores'] = $this->exametemp->listarfisioterapiaanterior($paciente_id);
        $data['exames'] = $this->exametemp->listaraexamespaciente($ambulatorio_guia_id);
        $data['grupos'] = $this->procedimento->listargruposespecialidade();
        $data['x'] = 0;
        foreach ($data['exames'] as $value) {
            $teste = $this->exametemp->verificaprocedimentosemformapagamento($value->procedimento_tuss_id);
            if (empty($teste)) {
                $data['x'] ++;
            }
        }

        $data['contador'] = $this->exametemp->contadorexamespaciente($ambulatorio_guia_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $this->loadView('ambulatorio/guiafisioterapia-form', $data);
//        } else {
//            $data['mensagem'] = 'Paciente com sessões pendentes.';
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
//        }
    }

    function novoatendimento($paciente_id, $ambulatorio_guia_id = null) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['salas'] = $this->guia->listarsalas();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['grupo_pagamento'] = $this->formapagamento->listargrupos();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();

        if ($ambulatorio_guia_id != null && $ambulatorio_guia_id != '') {
            $data['exames'] = $this->exametemp->listaraexamespaciente($ambulatorio_guia_id);
            $data['exames_lista'] = $this->exametemp->listarexamespacienteatendimento($ambulatorio_guia_id);
            $data['exames_particular'] = $this->exametemp->listarexamespacienteatendimentoparticular($ambulatorio_guia_id);
            $data['exames_pacote'] = $this->exametemp->listarpacoteexamespaciente($ambulatorio_guia_id);
        } else {
            $data['exames'] = array();
            $data['exames_lista'] = array();
            $data['exames_pacote'] = array();
        }

        $data['grupos'] = $this->procedimento->listargruposatendimento();

        $data['x'] = 0;
        foreach ($data['exames'] as $value) {
            $teste = $this->exametemp->verificaprocedimentosemformapagamento($value->procedimento_tuss_id);
            if (empty($teste)) {
                $data['x'] ++;
            }
        }

        if ($ambulatorio_guia_id != null && $ambulatorio_guia_id != '') {
            $data['contador'] = $this->exametemp->contadorexamespaciente($ambulatorio_guia_id);
        } else {
            $data['contador'] = 0;
        }
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $this->loadView('ambulatorio/guiaatendimento-form', $data);
    }

    function faturar($agenda_exames_id, $procedimento_convenio_id) {
        $data['forma_pagamento'] = $this->guia->formadepagamentoprocedimento($procedimento_convenio_id);
        $data['exame'] = $this->guia->listarexame($agenda_exames_id);
        $data['guia_id'] = $data['exame'][0]->guia_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['valor'] = 0.00;
        $this->load->View('ambulatorio/faturar-form', $data);
    }

    function faturarconvenio($agenda_exames_id) {
        $data['exame'] = $this->guia->listarexame($agenda_exames_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/faturarconvenio-form', $data);
    }

    function faturarconveniostatus($agenda_exames_id) {
        $data['exame'] = $this->guia->listarexame($agenda_exames_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/faturarconveniostatus-form', $data);
    }

    function alterardata($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/alterardata-form', $data);
    }

    function alterardatafaturamento($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/alterardatafaturamento-form', $data);
    }

    function alterarautorizacao($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/alterarautorizacao-form', $data);
    }

    function gravaralterarautorizacao($agenda_exames_id) {

        $this->guia->gravaralterarautorizacao($agenda_exames_id);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravaralterardata($agenda_exames_id) {
        $data_escolhida = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data'])));
        $hoje = date("Y-m-d");

//        if ($hoje <= $data_escolhida) {
//            $data['mensagem'] = 'A data não pode ser maior que a de hoje.';
//            $this->session->set_flashdata('message', $data['mensagem']);
//        } else {
        $this->guia->gravaralterardata($agenda_exames_id);
//        }
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravaralterardatafaturamento($agenda_exames_id) {
        $data_escolhida = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data'])));
        $hoje = date("Y-m-d");

//        if ($hoje <= $data_escolhida) {
//            $data['mensagem'] = 'A data não pode ser maior que a de hoje.';
//            $this->session->set_flashdata('message', $data['mensagem']);
//        } else {
        $this->guia->gravaralterardatafaturamento($agenda_exames_id);
//        }
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function faturamentodetalhes($agenda_exames_id) {
        $data['exame'] = $this->guia->listarexame($agenda_exames_id);
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/faturamentodetalhe-form', $data);
    }

    function tempomedioatendimento() {
        $data['tempo'] = $this->guia->tempomedioatendimento();

        $this->load->View('ambulatorio/tempomedioconsulta-form', $data);
    }

    function procedimentocirurgicovalor($agenda_exames_id) {
        $data['valor'] = $this->guia->procedimentocirurgicovalor($agenda_exames_id);
//        var_dump($data['valor']); die;

        $this->load->View('ambulatorio/procedimentocirurgicovalor-form', $data);
    }

    function gravarprocedimentocirurgicovalor($agenda_exames_id) {
        $this->guia->gravarprocedimentocirurgicovalor($agenda_exames_id);
//        var_dump($data['valor']); die;

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarfaturar($agenda_exames_id) {
        $this->guia->gravarfaturamento($agenda_exames_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/faturar-form', $data);
    }

    function gravarfaturado() {

        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {
            $ambulatorio_guia_id = $this->guia->gravarfaturamento();

            if ($_POST['formapamento1'] == 1000 || $_POST['formapamento2'] == 1000 || $_POST['formapamento3'] == 1000 || $_POST['formapamento4'] == 1000) {
                $this->guia->descontacreditopaciente();
            }

            if ($ambulatorio_guia_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar faturamento. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar faturamento.';
            }

            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }

    function gravarfaturadoconvenio() {

        $this->guia->gravarfaturamentoconvenio();
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
    }

    function gravartempomedioatendimento() {

        $this->guia->gravartempomedioatendimento();
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
    }

    function gravarfaturadoconveniostatus() {

        $this->guia->gravarfaturamentoconveniostatus();
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
    }

    function gravarfaturamentodetalhe() {
        $procedimentopercentual = $_POST['procedimento1'];
        $medicopercentual = $_POST['medico'];
        $percentual = $this->guia->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
        if (count($percentual) == 0) {
            $percentual = $this->guia->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
        }

        $this->guia->gravarfaturamentodetalhe($percentual);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
    }

    function faturarguia($guia_id, $financeiro_grupo_id = null) {
        $data['exame'][0] = new stdClass();
        // Criar acima a variável resolve o Warning que aparece na página de Faturar Guia.
        // A linha acima inicia o Objeto antes de atribuir um valor
        if (isset($financeiro_grupo_id)) {
            $data['forma_pagamento'] = $this->guia->formadepagamentoguia($guia_id, $financeiro_grupo_id);
            $data['exame'] = $this->guia->listarexameguiaforma($guia_id, $financeiro_grupo_id);
        } else {
            $data['forma_pagamento'] = $this->guia->formadepagamento();
            $data['exame1'] = $this->guia->listarexameguia($guia_id);
            $data['exame2'] = $this->guia->listarexameguiaforma($guia_id, $financeiro_grupo_id);
            $data['exame'][0]->total = $data['exame1'][0]->total - $data['exame2'][0]->total;
        }

        $data['financeiro_grupo_id'] = $financeiro_grupo_id;
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;

        $this->load->View('ambulatorio/faturarguia-form', $data);
    }

    function faturarprocedimentos($guia_id, $financeiro_grupo_id = null) {
        $data['exame'][0] = new stdClass();
        // Criar acima a variável resolve o Warning que aparece na página de Faturar Guia.
        // A linha acima inicia o Objeto antes de atribuir um valor
        if (isset($financeiro_grupo_id)) {
            $data['forma_pagamento'] = $this->guia->formadepagamentoguiaprocedimentos($guia_id, $financeiro_grupo_id);
            $data['exame'] = $this->guia->listarexameguiaformaprocedimentos($guia_id, $financeiro_grupo_id);
        } else {
            $data['forma_pagamento'] = $this->guia->formadepagamento();
            $data['exame1'] = $this->guia->listarexameguiaprocedimentos($guia_id);
            $data['exame2'] = $this->guia->listarexameguiaformaprocedimentos($guia_id, $financeiro_grupo_id);
            $data['exame'][0]->total = $data['exame1'][0]->total - $data['exame2'][0]->total;
        }
//        echo '<pre>';
//        var_dump($data['exame1']); die;

        $data['financeiro_grupo_id'] = $financeiro_grupo_id;
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;

        $this->load->View('ambulatorio/faturarprocedimentos-form', $data);
    }

    function faturaramentomanualguias($guia_id) {

        $data['guia'] = $this->guia->instanciarguia($guia_id);
        $data['procedimentos'] = $this->centrocirurgico_m->listarprocedimentosguiacirurgica($guia_id);
        $data['equipe'] = $this->centrocirurgico_m->listarequipecirurgicaoperadores($data['guia'][0]->equipe_id);
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['exame'] = $this->guia->listarexameguia($guia_id);
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;
        $this->load->View('ambulatorio/faturaramentomanualguiaconvenio-form', $data);
    }

    function faturarguias($guia_id) {
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['procedimentos'] = $this->centrocirurgico_m->listarprocedimentosguiacirurgica($guia_id);
        $data['exame'] = $this->guia->listarexameguia($guia_id);
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;
        $this->load->View('ambulatorio/faturarguiaconvenio-form', $data);
    }

    function faturarguiacaixa($guia_id, $financeiro_grupo_id = null) {

        if (isset($financeiro_grupo_id)) {
            $data['forma_pagamento'] = $this->guia->formadepagamentoguia($guia_id, $financeiro_grupo_id);
            $data['exame'] = $this->guia->listarexameguianaofaturadoforma($guia_id, $financeiro_grupo_id);
        } else {
            $data['forma_pagamento'] = $this->guia->formadepagamento();
            $data['exame1'] = $this->guia->listarexameguia($guia_id);
            $data['exame2'] = $this->guia->listarexameguiaforma($guia_id, $financeiro_grupo_id);
            $data['exame'][0]->total = $data['exame1'][0]->total - $data['exame2'][0]->total;
        }

        $data['financeiro_grupo_id'] = $financeiro_grupo_id;
        $data['paciente'] = $this->guia->listarexameguiacaixa($guia_id);
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;
        $this->load->View('ambulatorio/faturarguiacaixa-form', $data);
    }

    function faturarfinanceiro() {
        $this->load->View('ambulatorio/faturarguia-form', $data);
    }

    function gravarfaturadoguia() {

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
                $ambulatorio_guia_id = $this->guia->gravarfaturamentototal();

//                var_dump($_POST['guia_id']);die;

                if ($_POST['formapamento1'] == 1000 || $_POST['formapamento2'] == 1000 || $_POST['formapamento3'] == 1000 || $_POST['formapamento4'] == 1000) {
                    $this->guia->descontacreditopaciente();
                }

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

    function gravarfaturadoprocedimentos() {

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
                $ambulatorio_guia_id = $this->guia->gravarfaturamentototalprocedimentos();

                if ($_POST['formapamento1'] == 1000 || $_POST['formapamento2'] == 1000 || $_POST['formapamento3'] == 1000 || $_POST['formapamento4'] == 1000) {
                    $this->guia->descontacreditopaciente();
                }

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

    function gravarfaturamentomanualguiaconvenio() {

        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {
            $ambulatorio_guia_id = $this->guia->gravarfaturamentomanualtotalconvenio();
            if ($ambulatorio_guia_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar faturamento. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar faturamento.';
            }

            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }

    function gravarfaturadoguiaconvenio() {

        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {
            $ambulatorio_guia_id = $this->guia->gravarfaturamentototalconvenio();
            if ($ambulatorio_guia_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar faturamento. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar faturamento.';
            }

            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }

    function gravarfaturadoguiacaixa() {

        $guia_id = $_POST['guia_id'];
        $exame = $_POST['exame'];
        $paciente = $_POST['paciente'];
        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {
            $this->guia->gravarfaturamentototalnaofaturado();
            redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente");
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }

    function relatorioexame() {
        $data['grupo'] = $this->guia->listargrupo();
        $data['grupoconvenio'] = $this->grupoconvenio->listargrupoconvenios();
        $data['procedimentos'] = $this->guia->listarprocedimentos();
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['classificacao'] = $this->guia->listarclassificacao();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioconferencia', $data);
    }

    function relatoriogastosala() {
        $data['grupo'] = $this->guia->listargrupo();
        $data['grupoconvenio'] = $this->grupoconvenio->listargrupoconvenios();
        $data['procedimentos'] = $this->guia->listarprocedimentos();
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['classificacao'] = $this->guia->listarclassificacao();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriogastosala', $data);
    }

    function relatoriorecolhimento() {
        $data['grupo'] = $this->guia->listargrupo();
        $data['grupoconvenio'] = $this->grupoconvenio->listargrupoconvenios();
        $data['procedimentos'] = $this->guia->listarprocedimentos();
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['classificacao'] = $this->guia->listarclassificacao();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriorecolhimento', $data);
    }

    function relatorioexamesala() {
        $data['salas'] = $this->sala->listarsalas();
        $this->loadView('ambulatorio/relatorioexamesala', $data);
    }

    function relatoriopacieneteexame() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriopacienteconvenioexame', $data);
    }

    function guiaspsadtoutrasdespesas($guia_id) {
        $data['guia_id'] = $guia_id;

        $empresa_id = $this->session->userdata('empresa_id');

        $data['empresa'] = $this->guia->listarempresa($empresa_id);

//        var_dump($empresa_id);die;

        $data['relatorio'] = $this->guia->guiaspsadtoutrasdespesas($guia_id);
//        $data['relatorio'] = $this->guia->relatoriogastosala();

        $this->load->View('ambulatorio/impressaoguiaspsadtoutrasdespesas', $data);
    }

    function gerarelatoriogastosala() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['relatorio'] = $this->guia->relatoriogastosala();
        $this->load->View('ambulatorio/impressaorelatoriogastosala', $data);
    }

    function gerarelatorioexame() {
        $data['convenio'] = $_POST['convenio'];
        $data['procedimentos'] = $_POST['procedimentos'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $medicos = $_POST['medico'];
        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        if ($_POST['procedimentos'] != '0') {
            $data['procedimentos'] = $this->guia->selecionarprocedimentos($_POST['procedimentos']);
        }
        $data['relatorio'] = $this->guia->relatorioexamesconferencia();
        if($_POST['planilha'] == "SIM"){
            $html = $this->load->View('ambulatorio/impressaorelatorioconferencia', $data, true);
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-type: application/x-msexcel");
            header("Content-Disposition: attachment; filename=\"Relatorio.xls\"");
            header("Content-Description: PHP Generated Data");
            // Envia o conteúdo do arquivo
            echo $html;
            exit;
        }
        else{
            $this->load->View('ambulatorio/impressaorelatorioconferencia', $data);
        }
    }

    function gerarelatoriorecolhimento() {
        $data['convenio'] = $_POST['convenio'];
        $data['procedimentos'] = $_POST['procedimentos'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $medicos = $_POST['medico'];
        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        if ($_POST['procedimentos'] != '0') {
            $data['procedimentos'] = $this->guia->selecionarprocedimentos($_POST['procedimentos']);
        }
        $data['relatorio'] = $this->guia->relatorioexamesconferencia();

        if ($_POST['planilha'] == 'sim') {
            $html = $this->load->view('ambulatorio/impressaorelatoriorecolhimento', $data, true);
            $horario = date('d-m-Y');
            //        $arquivo = "/home/planilha.xls";
            // Configurações header para forçar o download
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-type: application/x-msexcel");
            header("Content-Disposition: attachment; filename=\"relatoriorecolhimento $horario\"");
            header("Content-Description: PHP Generated Data");
            // Envia o conteúdo do arquivo
            echo $html;
            exit;
        } else {
            $this->load->View('ambulatorio/impressaorelatoriorecolhimento', $data);
        }
//        $this->load->View('', $data);
    }

    function exportaremails() {
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['relatorio'] = $this->guia->exportaremails();
//    $this->load->view('ambulatorio/impressaorelatorioexportaremails', $data);
        $html = $this->load->view('ambulatorio/impressaorelatorioexportaremails', $data, true);
        $horario = date('d-m-Y');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=\"emailexport $horario.xls\"");
        header("Content-Description: PHP Generated Data");
        // Envia o conteúdo do arquivo
        echo $html;
        exit;
    }

    function gerarelatorioexamesala() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['salas'] = $_POST['salas'];
        if ($_POST['salas'] != '0') {
            $data['sala'] = $this->sala->listarsala($_POST['salas']);
        }
        $data['relatorio'] = $this->guia->relatorioexamesala();

        $this->load->View('ambulatorio/impressaorelatorioexamesala', $data);
    }

    function relatoriogeralsintetico() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriogeralsintetico', $data);
    }

    function gerarelatoriogeralsintetico() {
        $data['empresa'] = $this->guia->listarempresas();
        $data['ano'] = $_POST['ano'];
        $this->load->View('ambulatorio/impressaorelatoriogeralsintetico', $data);
    }

    function relatorioexamech() {
        $data['grupo'] = $this->guia->listargrupo();
        $data['procedimentos'] = $this->guia->listarprocedimentos();
        $data['convenio'] = $this->convenio->listardados();
        $data['classificacao'] = $this->guia->listarclassificacao();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioconferenciach', $data);
    }

    function gerarelatorioexamech() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatorioexamescontador();
        $data['relatorio'] = $this->guia->relatorioexamesch();
        $this->load->View('ambulatorio/impressaorelatorioconferenciach', $data);
    }

    function relatoriocancelamento() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocancelamento', $data);
    }

    function relatoriotempoesperaexame() {

        $this->loadView('ambulatorio/relatoriotempoesperaexame');
    }

    function relatoriotemposalaespera() {

        $this->loadView('ambulatorio/relatoriotemposalaespera');
    }

    function gerarelatoriotempoesperaexame() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        } else {
            $data['convenios'] = 0;
        }
        $data['listar'] = $this->exame->gerarelatoriotempoesperaexame();
        $this->load->View('ambulatorio/impressaorelatoriotempoesperaexame', $data);
    }

    function gerarelatoriotemposalaespera() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        } else {
            $data['convenios'] = 0;
        }
        $data['listar'] = $this->exame->gerarelatoriotemposalaespera();
        $this->load->View('ambulatorio/impressaorelatoriotemposalaespera', $data);
    }

    function gerarelatoriocancelamento() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatoriocancelamentocontador();
        $data['relatorio'] = $this->guia->relatoriocancelamento();
        $this->load->View('ambulatorio/impressaorelatoriocancelamento', $data);
    }

    function gerarelatoriopacienteconvenioexame() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['relatorio'] = $this->guia->relatorioexames();
        $this->load->View('ambulatorio/impressaorelatoriopacienteconvenioexame', $data);
    }

    function relatoriogrupo() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioexamegrupo', $data);
    }

    function relatoriogrupoanalitico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioexamegrupoanalitico', $data);
    }

    function relatoriogrupoprocedimento() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioexamegrupoprocedimento', $data);
    }

    function relatoriogrupoprocedimentomedico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriogrupoprocedimentomedico', $data);
    }

    function gerarelatoriogrupo() {
        $data['conveniotipo'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatorioexamesgrupocontador();
        $data['relatorio'] = $this->guia->relatorioexamesgrupo();
        $this->load->View('ambulatorio/impressaorelatoriogrupo', $data);
    }

    function gerarelatoriogrupoprocedimento() {
        $data['conveniotipo'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatorioexamesgrupocontador();
        $data['relatorio'] = $this->guia->relatorioexamesgrupoprocedimento();
        $this->load->View('ambulatorio/impressaorelatoriogrupoprocedimento', $data);
    }

    function gerarelatoriogrupoprocedimentomedico() {
        $data['conveniotipo'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $medicos = $_POST['medico'];
        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['relatorio'] = $this->guia->relatoriogrupoprocedimentomedico();
        $this->load->View('ambulatorio/impressaorelatoriogrupoprocedimento', $data);
    }

    function gerarelatoriogrupoanalitico() {
        $data['conveniotipo'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatorioexamesgrupocontador();
        $data['relatorio'] = $this->guia->relatorioexamesgrupoanalitico();
        $this->load->View('ambulatorio/impressaorelatoriogrupoanalitico', $data);
    }

    function relatoriofaturamentorm() {
        $data['convenio'] = $this->convenio->listardados();
        $this->loadView('ambulatorio/relatorioexamefaturamentorm', $data);
    }

    function gerarelatoriofaturamentorm() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['contador'] = $this->guia->relatorioexamesfaturamentormcontador();
        $data['relatorio'] = $this->guia->relatorioexamesfaturamentorm();
        $this->load->View('ambulatorio/impressaorelatoriofaturamentorm', $data);
    }

    function relatoriogeralconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriogeralconvenio', $data);
    }

    function gerarelatoriogeralconvenio() {
        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }

        $data['contador'] = $this->guia->relatoriogeralconveniocontador();
        $data['relatorio'] = $this->guia->relatoriogeralconvenio();

        $this->load->View('ambulatorio/impressaorelatoriogeralconvenio', $data);
    }

    function relatorioresumogeral() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioresumogeral', $data);
    }

    function gerarelatorioresumogeral() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['medico'] = $this->guia->relatorioresumogeral();
        $data['medicorecebido'] = $this->guia->relatorioresumogeralmedico();
        $data['convenio'] = $this->guia->relatorioresumogeralconvenio();
        $data['convenios'] = $this->convenio->listardados();
        $data['creditos'] = $this->guia->relatorioresumocreditoslancados();
        $data['formapagamento'] = $this->formapagamento->listarforma();
        $data['relatoriocredito'] = $this->guia->relatorioresumocredito();
//        echo '<pre>'; 
//        var_dump($data['relatoriocredito']); die;
        $data['relatoriocirurgico'] = $this->guia->relatorioresumocirurgicomedico();
        $data['procedimentoscirurgicos'] = $this->guia->relatorioresumocirurgicomedicotodos();

        $this->load->View('ambulatorio/impressaorelatorioresumogeral', $data);
    }

    function relatoriocreditosaldo() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriocreditosaldo', $data);
    }

    function gerarelatoriocreditosaldo() {
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['txtNome'] = $_POST['txtNome'];
        $data['pacientes'] = $this->guia->relatoriocreditopacientes();
//        echo "<pre>"; var_dump($data['pacientes']); die;
        $this->load->View('ambulatorio/impressaorelatoriocreditosaldo', $data);
    }

    function relatoriocredito() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriocreditopaciente', $data);
    }

    function gerarelatoriocredito() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['txtNome'] = $_POST['txtNome'];

        $data['relatoriocredito'] = $this->guia->relatoriocredito();
//        $data['pacientes'] = $this->guia->relatoriocreditopacientes();
//        var_dump($data['relatoriocredito']); die;
        $this->load->View('ambulatorio/impressaorelatoriocredito', $data);
    }

    function relatoriomedicosolicitante() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicosolicitante', $data);
    }

    function gerarelatoriomedicosolicitante() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicosolicitantecontador();
        $data['relatorio'] = $this->guia->relatoriomedicosolicitante();
        $this->load->View('ambulatorio/impressaorelatoriomedicosolicitante', $data);
    }

    function relatoriomedicosolicitantexmedico() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicosolicitantexmedico', $data);
    }

    function gerarelatoriomedicosolicitantexmedico() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicosolicitantecontadorxmedico();
        $data['relatorio'] = $this->guia->relatoriomedicosolicitantexmedico();
        $this->load->View('ambulatorio/impressaorelatoriomedicosolicitantexmedico', $data);
    }

    function relatoriomedicosolicitantexmedicoindicado() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicosolicitantexmedicoindicado', $data);
    }

    function gerarelatoriomedicosolicitantexmedicoindicado() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicosolicitantecontadorxmedicoindicado();
        $data['relatorio'] = $this->guia->relatoriomedicosolicitantexmedicoindicado();
        $this->load->View('ambulatorio/impressaorelatoriomedicosolicitantexmedico', $data);
    }

    function relatoriolaudopalavra() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriolaudopalavra', $data);
    }

    function gerarelatoriolaudopalavra() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['palavra'] = $_POST['palavra'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriolaudopalavracontador();
        $data['relatorio'] = $this->guia->relatoriolaudopalavra();
        $this->load->View('ambulatorio/impressaorelatoriolaudopalavra', $data);
    }

    function relatoriomedicosolicitanterm() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $this->loadView('ambulatorio/relatoriomedicosolicitanterm', $data);
    }

    function gerarelatoriomedicosolicitanterm() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['contador'] = $this->guia->relatoriomedicosolicitantecontadorrm();
        $data['relatorio'] = $this->guia->relatoriomedicosolicitanterm();
        $this->load->View('ambulatorio/impressaorelatoriomedicosolicitanterm', $data);
    }

    function relatoriomedicoconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicoconvenio', $data);
    }

    function relatoriorecepcaomedicoconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriorecepcaomedicoconvenio', $data);
    }

    function relatorioconvenioquantidade() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioconvenioquantidade', $data);
    }

    function relatorioaniversariante() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioaniversariante', $data);
    }

    function relatoriopacientewhatsapp() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriopacientewhatsapp', $data);
    }

    function relatoriopacienteduplicado() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriopacienteduplicado', $data);
    }

    function relatorioperfilpaciente() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('ambulatorio/relatorioperfilpaciente', $data);
    }

    function relatoriomedicoagendafaltouemail() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['salas'] = $this->exame->listartodassalas();
        $this->loadView('ambulatorio/relatoriomedicoagendaexamefaltouemail', $data);
    }

    function gerarelatoriomedicoagendaexamefaltouemail() {
        $empresa_id = $this->session->userdata('empresa_id');
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
//        echo '<pre>'; 
        $data['relatorio'] = $this->guia->gerarelatorioexamefaltou();
//        echo '<pre>';
//        var_dump($data['relatorio']); die;
        $this->load->View('ambulatorio/impressaorelatoriomedicoagendaexamefaltouemail', $data);
    }

    function formularioemail($emails) {
        var_dump($emails);
        die;
        $data['emails'] = $emails;


        $this->load->View('ambulatorio/faturarguia-form', $data);
    }

    function enviaremail() {

        $empresa_id = $this->session->userdata('empresa_id');
        $empresa = $this->guia->listarempresa($empresa_id);

        $emails = $this->guia->gerarelatorioexamefaltouemail();
        if ($empresa[0]->email != '') {
            $email_empresa = $empresa[0]->email;
        } else {
            $email_empresa = 'stgsaude@gmail.com';
        }

        $remetente = $_POST['remetente'];
        $assunto = $_POST['assunto'];
        $mensagem = $_POST['mensagem'];

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'stgsaude@gmail.com';
        $config['smtp_pass'] = 'saude123';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $this->load->library('email');

        foreach ($emails as $item) {
            if ($item->cns != null) {
                $this->email->initialize($config);
                $this->email->from($email_empresa, $remetente);
                $this->email->to($item->cns);
                $this->email->subject($assunto);
                $this->email->message($mensagem);
                $this->email->send();
            }
        }

        if (1 == 1) {
            $data['mensagem'] = 'Email enviado com sucesso.';
        } else {
            $data['mensagem'] = 'Envio de Email malsucedido.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/relatoriomedicoagendafaltouemail");
    }

    function relatoriounicoretorno() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriounicoretorno', $data);
    }

    function relatoriotempoatendimento() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriotempoatendimento', $data);
    }

    function relatorioconveniovalor() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioconveniovalor', $data);
    }

    function relatorioconsultaconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioconsultaconvenio', $data);
    }

    function relatoriomedicoconveniorm() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('ambulatorio/relatoriomedicoconveniorm', $data);
    }

    function gerarelatoriomedicoconvenio() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicoconveniocontador();
        $data['relatorio'] = $this->guia->relatoriomedicoconvenio();
        $this->load->View('ambulatorio/impressaorelatoriomedicoconvenio', $data);
    }

    function gerarelatoriorecepcaomedicoconvenio() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicoconveniocontador();
        $data['relatorio'] = $this->guia->relatoriomedicoconvenio();
        $this->load->View('ambulatorio/impressaorelatoriorecepcaomedicoconvenio', $data);
    }

    function relatoriotecnicoconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriotecnicoconvenio', $data);
    }

    function relatorioindicacao() {
        $data['indicacao'] = $this->paciente->listaindicacao();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->indicacao->listargrupoindicacao();
        $this->loadView('ambulatorio/relatorioindicacao', $data);
    }

    function relatorioindicacaoexames() {
        $data['indicacao'] = $this->paciente->listaindicacao();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->indicacao->listargrupoindicacao();
        
        $this->loadView('ambulatorio/relatorioindicacaoexames', $data);
    }

    function relatorioindicacaoexamescadastro() {
        $data['indicacao'] = $this->paciente->listaindicacao();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioindicacaoexames', $data);
    }

    function relatorionotafiscal() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorionotafiscal', $data);
    }

    function relatoriovalormedio() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriovalormedio', $data);
    }

    function listardadospacienterelatorionota($paciente_id) {
        $data['paciente'] = $this->paciente->listardadospacienterelatorionota($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $horario = date(" Y-m-d H:i:s");

        $hour = substr($horario, 11, 3);
        $minutes = substr($horario, 15, 2);
        $seconds = substr($horario, 18, 4);

        $this->load->view('ambulatorio/dadospacienterelatorionota', $data);
    }

    function gerarelatoriotecnicoconvenio() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $tecnicos = $_POST['tecnicos'];
        $data['verificatecnicos'] = $_POST['tecnicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['tecnico'] = $this->operador_m->listarCada($tecnicos);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriotecnicoconveniocontador();
        $data['relatorio'] = $this->guia->relatoriotecnicoconvenio();
        $this->load->View('ambulatorio/impressaorelatoriotecnicoconvenio', $data);
    }

    function gerarelatorioindicacao() {

        if ($_POST['indicacao'] != '0') {
            $data['indicacao'] = $this->guia->listacadaindicacao($_POST['indicacao']);
            $data['indicacao'] = $data['indicacao'][0]->indicacao;
        } else {
            $data['indicacao'] = '0';
        }
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatorioindicacao();
        $data['indicacao_valor'] = $this->paciente->listaindicacao();
        if ($_POST['indicacao'] != '0') {
            $data['indicacao'] = $this->guia->listacadaindicacao($_POST['indicacao']);
            $data['indicacao'] = $data['indicacao'][0]->indicacao;
        } else {
            $data['indicacao'] = '0';
        }
        $data['consolidado'] = $this->guia->relatorioindicacaoconsolidado();
//        echo "<pre>";
//        var_dump($data['consolidado']);die;

        $this->load->View('ambulatorio/impressaorelatorioindicacao', $data);
    }

    function gerarelatorioindicacaoexames() {

        if ($_POST['indicacao'] != '0') {
            $data['indicacao'] = $this->guia->listacadaindicacao($_POST['indicacao']);
            $data['indicacao'] = $data['indicacao'][0]->indicacao;
        } else {
            $data['indicacao'] = '0';
        }
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatorioindicacaoexames();
        $data['indicacao_valor'] = $this->paciente->listaindicacao();
        $data['consolidado'] = $this->guia->relatorioindicacaoexamesconsolidado();
//        echo "<pre>";
//        var_dump($data['consolidado']);die;

        $this->load->View('ambulatorio/impressaorelatorioindicacaoexames', $data);
    }

    function gerarelatorionotafiscal() {

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatorionotafiscal($_POST['guia']);
        $this->load->View('ambulatorio/impressaorelatorionotafiscal', $data);
    }

    function gerarelatoriovalormedio() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriovalormedio();
        $data['convenio'] = $this->guia->relatoriovalormedioconvenio();
        $this->load->View('ambulatorio/impressaorelatoriovalormedio', $data);
    }

    function relatoriotecnicoconveniosintetico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriotecnicoconveniosintetico', $data);
    }

    function gerarelatoriotecnicoconveniosintetico() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $tecnicos = $_POST['tecnicos'];
        $data['verificatecnicos'] = $_POST['tecnicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['tecnico'] = $this->operador_m->listarCada($tecnicos);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriotecnicoconveniocontador();
        $data['relatorio'] = $this->guia->relatoriotecnicoconvenio();
        $this->load->View('ambulatorio/impressaorelatoriotecnicoconveniosintetico', $data);
    }

    function gerarelatorioconvenioquantidade() {
        $database = date("d-m-Y");
        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $_POST['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $_POST['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $datainicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $datafim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
//        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
//        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));

        if ((strtotime($datainicio) < strtotime($database)) && (strtotime($datafim) > strtotime($database))) {
            $atendidos = $this->guia->relatorioconvenioexamesatendidos();
            $naoatendidos = $this->guia->relatorioconvenioexamesnaoatendidos();
            $atendidosdatafim = $this->guia->relatorioconvenioexamesatendidosdatafim();
            $naoatendidosdatafim = $this->guia->relatorioconvenioexamesnaoatendidosdatafim();
            $data['atendidos'] = count($atendidos) + count($atendidosdatafim);
            $data['naoatendidos'] = count($naoatendidos) + count($naoatendidosdatafim);
        } else {
            $atendidos = $this->guia->relatorioconvenioexamesatendidos2();
            $data['atendidos'] = count($atendidos);
            $naoatendidos = $this->guia->relatorioconvenioexamesnaoatendidos2();
            $data['naoatendidos'] = count($naoatendidos);
        }
        if ((strtotime($datainicio) < strtotime($database)) && (strtotime($datafim) > strtotime($database))) {
            $consultasatendidos = $this->guia->relatorioconvenioconsultasatendidos();
            $consultasnaoatendidos = $this->guia->relatorioconvenioconsultasnaoatendidos();
            $consultasatendidosdatafim = $this->guia->relatorioconvenioconsultasatendidosdatafim();
            $consultasnaoatendidosdatafim = $this->guia->relatorioconvenioconsultasnaoatendidosdatafim();
            $data['consultasatendidos'] = count($consultasatendidos) + count($consultasatendidosdatafim);
            $data['consultasnaoatendidos'] = count($consultasnaoatendidos) + count($consultasnaoatendidosdatafim);
        } else {
            $consultasatendidos = $this->guia->relatorioconvenioconsultasatendidos2();
            $data['consultasatendidos'] = count($consultasatendidos);
            $consultasnaoatendidos = $this->guia->relatorioconvenioconsultasnaoatendidos2();
            $data['consultasnaoatendidos'] = count($consultasnaoatendidos);
        }
        $this->load->View('ambulatorio/impressaorelatorioconvenioquantidadeconsolidado', $data);
    }

    function gerarelatorioconveniovalor() {
        $database = date("Y-m-d");
        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));
        if ((strtotime($datainicio) < strtotime($database)) && (strtotime($datafim) > strtotime($database))) {
            $data['atendidos'] = $this->guia->relatorioconvenioexamesatendidos();
            $data['naoatendidos'] = $this->guia->relatorioconvenioexamesnaoatendidos();
            $data['atendidosdatafim'] = $this->guia->relatorioconvenioexamesatendidosdatafim();
            $data['naoatendidosdatafim'] = $this->guia->relatorioconvenioexamesnaoatendidosdatafim();
        } else {
            $data['atendidos'] = $this->guia->relatorioconvenioexamesatendidos2();
            $data['naoatendidos'] = $this->guia->relatorioconvenioexamesnaoatendidos2();
        }
        if ((strtotime($datainicio) < strtotime($database)) && (strtotime($datafim) > strtotime($database))) {
            $data['consultasatendidos'] = $this->guia->relatorioconvenioconsultasatendidos();
            $data['consultasnaoatendidos'] = $this->guia->relatorioconvenioconsultasnaoatendidos();
            $data['consultasatendidosdatafim'] = $this->guia->relatorioconvenioconsultasatendidosdatafim();
            $data['consultasnaoatendidosdatafim'] = $this->guia->relatorioconvenioconsultasnaoatendidosdatafim();
        } else {
            $data['consultasatendidos'] = $this->guia->relatorioconvenioconsultasatendidos2();
            $data['consultasnaoatendidos'] = $this->guia->relatorioconvenioconsultasnaoatendidos2();
        }
        $this->load->View('ambulatorio/impressaorelatorioconveniovalor', $data);
    }

    function gerarelatorioconsultaconvenio() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatorioconsultaconveniocontador();
        $data['relatorio'] = $this->guia->relatorioconsultaconvenio();
        $this->load->View('ambulatorio/impressaorelatorioconsultaconvenio', $data);
    }

    function gerarelatoriomedicoconveniorm() {
        $medicos = $_POST['medicos'];
        $data['medico'] = $this->operador_m->listarCada($medicos);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $data['contador'] = $this->guia->relatoriomedicoconveniocontadorrm();
        $data['relatorio'] = $this->guia->relatoriomedicoconveniorm();
        $data['revisor'] = $this->guia->relatoriomedicoconveniormrevisor();
        $data['revisorunico'] = $this->guia->relatoriomedicoconveniormrevisorunico();
        $data['revisada'] = $this->guia->relatoriomedicoconveniormrevisada();
        $data['revisadaunico'] = $this->guia->relatoriomedicoconveniormrevisadaunico();
        $this->load->View('ambulatorio/impressaorelatoriomedicoconveniofinanceirorm', $data);
    }

    function gerarelatorioaniversariantes() {
        if ($_POST["txtdata_inicio"] != "" && $_POST["txtdata_fim"] != "") {
            $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);

            $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
            $data['txtdata_fim'] = $_POST['txtdata_fim'];

            if (isset($_POST['mala_direta'])) {
                $data['mala_direta'] = true;
            } else {
                $data['mala_direta'] = false;
            }
//            var_dump($data['mala_direta']);die;

            $data['relatorio'] = $this->guia->relatorioaniversariantes();
            $this->load->View('ambulatorio/impressaorelatorioaniversariantes', $data);
        } else {
            $data['mensagem'] = 'Insira um periodo válido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "/ambulatorio/guia/relatorioaniversariante");
        }
    }

    function gerarelatoriopacientewhatsapp() {
        if ($_POST["txtdata_inicio"] != "" && $_POST["txtdata_fim"] != "") {
            $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//            var_dump($_POST['txtdata_inicio'], $_POST['txtdata_fim']); die;
            $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
            $data['txtdata_fim'] = $_POST['txtdata_fim'];
            $data['relatorio'] = $this->guia->relatoriopacientewhatsapp();
            if ($_POST['planilha'] == 'sim') {
                $html = $this->load->view('ambulatorio/impressaorelatoriopacientewhatsapp', $data, true);
                $horario = date('d-m-Y');
                //        $arquivo = "/home/planilha.xls";
                // Configurações header para forçar o download
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: application/x-msexcel");
                header("Content-Disposition: attachment; filename=\"WhatsApp Pacientes $horario\"");
                header("Content-Description: PHP Generated Data");
                // Envia o conteúdo do arquivo
                echo $html;
                exit;
            } else {
                $this->load->View('ambulatorio/impressaorelatoriopacientewhatsapp', $data);
            }
        } else {
            $data['mensagem'] = 'Insira um periodo válido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "/ambulatorio/guia/relatoriopacientewhatsapp");
        }
    }

    function gerarelatoriopacienteduplicado() {
        if ($_POST["txtdata_inicio"] != "" && $_POST["txtdata_fim"] != "") {
//            $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//            var_dump($_POST['txtdata_inicio'], $_POST['txtdata_fim']); die;
            $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
            $data['txtdata_fim'] = $_POST['txtdata_fim'];
            $data['relatorio'] = $this->guia->relatoriopacienteduplicado();

            $this->load->View('ambulatorio/impressaorelatoriopacienteduplicado', $data);
        } else {
            $data['mensagem'] = 'Insira um periodo válido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "/ambulatorio/guia/relatoriopacientewhatsapp");
        }
    }

    function gerarelatorioperfilpaciente() {
        if ($_POST["txtdata_inicio"] != "" && $_POST["txtdata_fim"] != "") {
            $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
            $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
            $data['txtdata_fim'] = $_POST['txtdata_fim'];
            $data['medico'] = $_POST['medicoNome'];
            $data['plano'] = $_POST['planoNome'];
            $data['relatorio'] = $this->guia->relatorioperfilpaciente();
            $this->load->View('ambulatorio/impressaorelatorioperfilpaciente', $data);
        } else {
            $data['mensagem'] = 'Insira um periodo válido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "/ambulatorio/guia/relatorioperfilpaciente");
        }
    }

    function gerarelatoriounicoretorno() {
        if ($_POST["txtdata_inicio"] != "" && $_POST["txtdata_fim"] != "") {
            $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
            $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
            $data['txtdata_fim'] = $_POST['txtdata_fim'];
            $data['relatorio'] = $this->guia->relatoriounicoretorno();
//            $data['relatoriounico'] = $this->guia->relatoriounicoretorno();
//            echo '<pre>';
//            var_dump($data['relatoriounico']); die;
            $this->load->View('ambulatorio/impressaorelatoriounicoretorno', $data);
        } else {
            $data['mensagem'] = 'Insira um periodo válido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "/ambulatorio/guia/relatoriounicoretorno");
        }
    }

    function gerarelatoriotempoatendimento() {
        $data['tempo'] = $this->guia->tempomedioatendimento();

        if (count($data['tempo']) > 0) {
            $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
            $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
            $data['txtdata_fim'] = $_POST['txtdata_fim'];
            $data['relatorio'] = $this->guia->gerarelatoriotempoatendimento();
            $this->load->View('ambulatorio/impressaorelatoriotempoatendimento', $data);
        } else {
            $data['mensagem'] = 'Cadastre um valor médio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "/ambulatorio/guia/relatoriotempoatendimento");
        }
    }

    function escolherdeclaracao($paciente_id, $guia_id, $exames_id) {
        $data['paciente_id'] = $paciente_id;
        $data['guia_id'] = $guia_id;
        $data['exames_id'] = $exames_id;
        $data['modelos'] = $this->modelodeclaracao->listarmodelo();
        $this->loadView('ambulatorio/escolhermodelo', $data);
    }

    function imprimirfiladeimpressao($impressao_id) {

        $data['impressao'] = $this->guia->gerarimpressaofiladeimpressao($impressao_id);
        echo $data['impressao'][0]->texto;
//        $this->loadView('ambulatorio/escolhermodelo', $data);
    }

//    function excluirfiladeimpressao($impressao_id) {
//       
//        $data['impressao'] = $this->guia->excluirfiladeimpressao($impressao_id);
////        echo $data['impressao'][0]->texto;
////        $this->loadView('ambulatorio/escolhermodelo', $data);
//    }

    function impressaodeclaracao($paciente_id, $guia_id, $exames_id) {
        $this->load->plugin('mpdf');
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $data['modelo'] = $this->modelodeclaracao->buscarmodelo($_POST['modelo']);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['impressaolaudo'] = $this->guia->listarconfiguracaoimpressaolaudo($empresa_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;
        $exames = $data['exames'];
        $valor_total = 0;

        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        @$paciente = $data['paciente'][0]->nome;
        $dataFuturo = date("Y-m-d");
        // 1 é a impressão com logo e rodapé pequenos
        // JOGO TODA A PAGINA EM UM HTML PARA PODER SALVAR NO BANCO E JOGAR NA FILA DE IMPRESSÃO
        $html = $this->load->View('ambulatorio/impressaodeclaracaopequena', $data, true);
        if ($_POST['solicitacao_impressao'] == 'SIM') {
            $html = utf8_decode($html);
            $tipo = 'DECLARAÇÃO';
            $this->guia->gravarfiladeimpressao($html, $tipo, $paciente, $paciente_id);
        }

//        var_dump($html); 
//        die;
        // AQUI A PAGINA DA VIEW É REALMENTE CARREGADA
        if ($data['empresa'][0]->declaracao_config == 't') {
            $this->load->View('ambulatorio/impressaodeclaracaoconfiguravel', $data);
        } else {
            $this->load->View('ambulatorio/impressaodeclaracaopequena', $data);
        }
    }

    function impressaodeclaracaoguia($guia_id) {
        $this->load->plugin('mpdf');
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $this->guia->gravardeclaracaoguia($guia_id);
        $data['exame'] = $this->guia->listarexamesguia($guia_id);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['impressaolaudo'] = $this->guia->listarconfiguracaoimpressaolaudo($empresa_id);
        @$cabecalho_config = $data['cabecalho'][0]->cabecalho;
        @$rodape_config = $data['cabecalho'][0]->rodape;
        $filename = "declaracao.pdf";
        if ($data['empresa'][0]->cabecalho_config == 't') {
            $cabecalho = @$cabecalho_config;
        } else {
            $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr></table>";
        }
        @$rodape_config = str_replace("_assinatura_", '', @$rodape_config);
        if ($data['empresa'][0]->rodape_config == 't') {
            $rodape = @$rodape_config;
        } else {
            $rodape = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
        }
//        $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr></table>";
//        $rodape = "";

        if ($data['empresa'][0]->declaracao_config == 't') {
            $html = $this->load->view('ambulatorio/impressaodeclaracaoguiaconfiguravel', $data, true);
        } else {
            $html = $this->load->view('ambulatorio/impressaodeclaracaoguia', $data, true);
        }





        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('impressaodeclaracaoguia', $data);
        $this->load->View('impressaodeclaracaoguiaconfiguravel', $data);
    }

    function reciboounota($paciente_id, $guia_id, $exames_id) {
        $data['paciente_id'] = $paciente_id;
        $data['guia_id'] = $guia_id;
        $data['exames_id'] = $exames_id;
        $this->loadView('ambulatorio/reciboounota', $data);
    }

    function reciboounotaindicador() {
//        var_dump($_POST['escolha']);die;
        $paciente_id = $_POST['paciente_id'];
        $guia_id = $_POST['guia_id'];
        $exames_id = $_POST['exames_id'];

        if ($_POST['escolha'] == 'R') {
            $this->impressaorecibo($paciente_id, $guia_id, $exames_id);
        } else {
            $this->impressaorecibo($paciente_id, $guia_id, $exames_id);
        }
    }

    function impressaorecibo($paciente_id, $guia_id, $exames_id) {
//        echo CI_VERSION;
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['empresapermissoes'] = $this->guia->listarempresapermissoes($empresa_id);
        $data['cabecalho'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $convenioid = $data['exame'][0]->convenio_id;
        $dinheiro = $data['exame'][0]->dinheiro;
        $data['exames'] = $this->guia->listarexamesguiaconvenio($guia_id, $convenioid);
        $data['guiavalor'] = $this->guia->guiavalor($guia_id, $convenioid);
//        echo '<pre>';
//        var_dump($data['guiavalor']); die;
        $exames = $data['exames'];
        $valor_total = 0;

        foreach ($exames as $item) :
            if ($dinheiro == "t") {
                $valor_total = $valor_total + ($item->valor_total);
            }
        endforeach;
        $data['valor_total'] = $valor_total;
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        if ($dinheiro == "t") {
            if ($data['empresapermissoes'][0]->valor_recibo_guia == 't') {
                $valor = number_format($valor_total, 2, ',', '.');
            } else {
                $valor = number_format($data['guiavalor'][0]->valor_guia, 2, ',', '.');
            }
        } else {
            $valor = '0,00';
        }
//        var_dump($data['exames'][0]->valor_guia); die;

        $data['valor'] = $valor;

        if ($valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {
            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            if ($dinheiro == "t") {
                $data['extenso'] = GExtenso::moeda($valoreditado);
            }
        }

        $dataFuturo = date("Y-m-d");

        if ($data['empresa'][0]->impressao_recibo == 1) {
            $this->load->View('ambulatorio/impressaorecibomed', $data);
        } elseif ($data['empresa'][0]->impressao_recibo == 2) {
            $this->load->View('ambulatorio/impressaorecibosantaimagem', $data);
        } else {
            $this->load->View('ambulatorio/impressaorecibo', $data);
        }
    }

    function relatoriomedicoatendimentomensal() {
        $data['convenio'] = $this->convenio->listardados();
        $data['grupoconvenio'] = $this->grupoconvenio->listargrupoconvenios();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicoatendimentomensal', $data);
    }

    function relatoriomedicoconveniofinanceiro() {
        $data['convenio'] = $this->convenio->listardados();
        $data['grupoconvenio'] = $this->grupoconvenio->listargrupoconvenios();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicoconveniofinanceiro', $data);
    }

    function relatoriolaboratorioconveniofinanceiro() {
        $data['convenio'] = $this->convenio->listardados();
        $data['grupoconvenio'] = $this->grupoconvenio->listargrupoconvenios();
        $data['laboratorios'] = $this->laboratorio->listarlaboratorios();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriolaboratorioconveniofinanceiro', $data);
    }

    function relatoriomedicoconvenioprevisaofinanceiro() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicoconvenioprevisaofinanceiro', $data);
    }

    function relatorioatendenteconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioatendenteconvenio', $data);
    }

    function gerarelatoriomedicoatendimentomensal() {
        $medicos = $_POST['medicos'];
        $revisor = $_POST['revisor'];

        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }

        if ($revisor != 0) {
            $data['revisor'] = $this->operador_m->listarCada($revisor);
        } else {
            $data['revisor'] = 0;
        }

        $data['periodo'] = $_POST['periodo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['empresamunicipio'] = $this->guia->listarempresamunicipio($_POST['empresa']);
        $data['medicos'] = $this->guia->relatoriomedicoatendimentomensal();
        $data['procedimentos'] = $this->guia->relatorioprocedimentoatendimentomensal();
        $data['medico_procedimento'] = $this->guia->relatoriomedicoprocedimentoatendimentomensal();

//        echo "<pre>";
//        var_dump($data['procedimentos']);die;

        $this->load->View('ambulatorio/impressaorelatoriomedicoatendimentomensal', $data);
    }

    function gerarelatoriomedicoconveniofinanceiro() {
        $medicos = $_POST['medicos'];
        $revisor = $_POST['revisor'];
        $data['tabela_recebimento'] = $_POST['tabela_recebimento'];
        $data['recibo'] = $_POST['recibo'];
        $data['clinica'] = $_POST['clinica'];
        $data['solicitante'] = $_POST['solicitante'];
        $data['situacao'] = $_POST['situacao'];
        $data['mostrar_taxa'] = $_POST['mostrar_taxa'];

        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }

        if ($revisor != 0) {
            $data['revisor'] = $this->operador_m->listarCada($revisor);
        } else {
            $data['revisor'] = 0;
        }

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['empresa_permissao'] = $this->guia->listarempresapermissoes($_POST['empresa']);
        $data['empresamunicipio'] = $this->guia->listarempresamunicipio($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicoconveniocontadorfinanceiro();
        $data['relatorio'] = $this->guia->relatoriomedicoconveniofinanceiro();


//        $this->db->where("al.data_producao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
//        $this->db->where("al.data_producao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
//        echo "<pre>";
//        var_dump($data['relatorio']);die;

        $data['relatoriogeral'] = $this->guia->relatoriomedicoconveniofinanceirotodos();
        $data['relatoriohomecare'] = $this->guia->relatoriomedicoconveniofinanceirohomecare();
        $data['relatoriohomecaregeral'] = $this->guia->relatoriomedicoconveniofinanceirohomecaretodos();
        $data['relatoriocirurgico'] = $this->guia->relatoriocirurgicomedicoconveniofinanceiro();
        $data['relatoriocirurgicogeral'] = $this->guia->relatoriocirurgicomedicoconveniofinanceirotodos();
//        echo "<pre>"; var_dump($data['relatorio']);die;
        $this->load->View('ambulatorio/impressaorelatoriomedicoconveniofinanceiro', $data);
    }

    function gerarelatoriolaboratorioconveniofinanceiro() {
        $laboratorios = $_POST['laboratorios'];
        $data['clinica'] = $_POST['clinica'];
        $data['solicitante'] = $_POST['solicitante'];
        $data['situacao'] = $_POST['situacao'];

        if ($laboratorios != 0) {
            $data['laboratorio'] = $this->laboratorio->listarlaboratoriorelatorio($laboratorios);
        } else {
            $data['laboratorio'] = 0;
        }
//        var_dump($data['laboratorio']); die;
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['empresa_permissao'] = $this->guia->listarempresapermissoes($_POST['empresa']);
        $data['empresamunicipio'] = $this->guia->listarempresamunicipio($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriolaboratorioconveniocontadorfinanceiro();

        $data['relatorio'] = $this->guia->relatoriolaboratorioconveniofinanceiro();
        $data['relatoriogeral'] = $this->guia->relatoriolaboratorioconveniofinanceirotodos();
//        echo '<pre>';
//        var_dump($data['relatorio']); die;
//        echo "<pre>"; var_dump($data['relatorio']);die;
        $this->load->View('ambulatorio/impressaorelatoriolaboratorioconveniofinanceiro', $data);
    }

    function gerarelatoriomedicoconvenioprevisaofinanceiro() {
        $medicos = $_POST['medicos'];
        $data['clinica'] = $_POST['clinica'];
        $data['solicitante'] = $_POST['solicitante'];
        $data['mostrar_taxa'] = $_POST['mostrar_taxa'];
        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }
//        var_dump($data['medico']);
//        die;
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriomedicoconvenioprevisaofinanceiro();
        $this->load->View('ambulatorio/impressaorelatoriomedicoconvenioprevisaofinanceiro', $data);
    }

    function gerarelatorioatendenteconvenio() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->gerarelatorioatendenteconvenio();
        $this->load->View('ambulatorio/impressaorelatorioatendenteconvenio', $data);
    }

    function relatoriogruporm() {
        $this->loadView('ambulatorio/relatoriorm');
    }

    function gerarelatoriogruporm() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['relatorio'] = $this->guia->relatoriogrupo();
        $data['contador'] = $this->guia->relatoriogrupocontador();
        $this->load->View('ambulatorio/impressaorelatoriorm', $data);
    }

    function verificado($agenda_exames_id) {
        $data['verificado'] = $this->guia->verificado($agenda_exames_id);
        $this->load->View('ambulatorio/verificado-form', $data);
    }

    function procedimentoguianota($ambulatorio_guia_id) {
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->guia->procedimentoguianota($ambulatorio_guia_id);
        $data['formapagamento'] = $this->formapagamento->listarforma();
        $this->load->View('ambulatorio/procedimentoguianota-form', $data);
    }

    function listarprocedimentosorcamento($ambulatorio_orcamento_id, $empresa_id) {
        $data['emissao'] = date("d-m-Y");
        $data['exames'] = $this->guia->listarexamesrelatorioorcamento($ambulatorio_orcamento_id);
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['permissoes'] = $this->guia->listarempresapermissoes($empresa_id);
        $data['impressaoorcamento'] = $this->guia->listarconfiguracaoimpressaoorcamento($empresa_id);
        $data['cabecalhoconfig'] = $this->guia->listarconfiguracaoimpressao($empresa_id);
        $data['cabecalho'] = @$data['cabecalhoconfig'][0]->cabecalho;
        $data['rodape'] = @$data['cabecalhoconfig'][0]->rodape;
        
        if ($data['permissoes'][0]->orcamento_config == 't') {
            $this->load->View('ambulatorio/impressaoorcamentorecepcaoconfiguravel', $data);
        } else {
            $this->load->View('ambulatorio/impressaorelatorioorcamentoprocedimento', $data);
        }
    }

    function procedimentoguianotaform($ambulatorio_guia_id, $valorguia, $valor = 0.00) {
        $data['valorguia'] = $valorguia;
        $data['valor'] = $valor;
        $data['guia_id'] = $ambulatorio_guia_id;
//        var_dump($ambulatorio_guia_id,$data['guia_id']);die;
        $this->load->View('ambulatorio/procedimentoguianota2-form', $data);
    }

    function gravarnotavalor($guia_id) {
        if ((float) $_POST['txtvalorguia'] <= (float) $_POST['totguia']) {
            $this->guia->gravarnotavalor($guia_id);
            redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
        } else {
            $mensagem = 'Valor informado excede o valor da guia!';
            $this->session->set_flashdata('message', $mensagem);

            $valor = (float) $_POST['txtvalorguia'];
            $valorGuia = (float) $_POST['totguia'];
            redirect(base_url() . "ambulatorio/guia/procedimentoguianotaform/{$valor}/{$valorGuia}");
        }
    }

    function graficovalormedio($procedimento, $valor, $txtdata_inicio, $txtdata_fim) {
//        var_dump($txtdata_inicio);
//        var_dump($txtdata_fim);
//        die;
        $data['grafico'] = $this->guia->relatoriograficoalormedio($procedimento);
        $data['valor'] = $valor;
        $data['txtdata_inicio'] = $txtdata_inicio;
        $data['txtdata_fim'] = $txtdata_fim;
        $data['procedimento'] = $procedimento;
        $this->load->View('ambulatorio/graficovalormedio', $data);
    }

    function entregaexame($paciente_id, $agenda_exames_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->guia->listarpaciente($paciente_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/exameentregue-form', $data);
    }

    function guiaobservacao($guia_id) {
        $data['guia_id'] = $this->guia->verificaobservacao($guia_id);
        $this->load->View('ambulatorio/guiaobservacao-form', $data);
    }

    function guiavalor($guia_id) {
        $data['exame'][0] = new stdClass();
        $data['exame1'] = $this->guia->listarexameguia($guia_id);
        $data['exame2'] = $this->guia->listarexameguiaforma($guia_id, null);
        $data['exame'][0]->total = $data['exame1'][0]->total - $data['exame2'][0]->total;
        $data['guia_id'] = $this->guia->verificavalor($guia_id);
        $this->load->View('ambulatorio/guiavalor-form', $data);
    }

    function guiaconvenio($guia_id) {
        $data['guia_id'] = $this->guia->guiaconvenio($guia_id);
        $this->load->View('ambulatorio/guiaconvenio-form', $data);
    }

    function guiaconvenioexame($guia_id, $agenda_exames_id) {
        $data['guia_id'] = $this->guia->guiaconvenioexame($agenda_exames_id);
        $this->load->View('ambulatorio/guiaconvenioexame-form', $data);
    }

    function guiadeclaracao($guia_id) {
        $data['guia_id'] = $this->guia->verificaodeclaracao($guia_id);
        $data['modelos'] = $this->modelodeclaracao->listarmodelo();
        $this->load->View('ambulatorio/guiadeclaracao-form', $data);
    }

    function vizualizarobservacao($agenda_exame_id) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['observacao'] = $this->guia->vizualizarobservacoes($agenda_exame_id);
        $this->load->View('ambulatorio/vizualizarobservacao-form', $data);
    }

    function vizualizarpreparo($tuss_id) {
        $data['preparo'] = $this->guia->vizualizarpreparo($tuss_id);
        $this->load->View('ambulatorio/vizualizarpreparo-form', $data);
    }

    function vizualizarpreparoconvenio($convenio_id) {
        $data['preparo'] = $this->guia->vizualizarpreparoconvenio($convenio_id);
        $this->load->View('ambulatorio/vizualizarpreparo-form', $data);
    }

    function gravarentregaexame() {
        $agenda_exames_id = $_POST['agenda_exames_id'];
        $this->guia->gravarentregaexame($agenda_exames_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarobservacaoguia($guia_id) {
        $this->guia->gravarobservacaoguia($guia_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarvalorguia($guia_id) {
        $this->guia->gravarvalorguia($guia_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarguiaconvenio($guia_id) {
        $this->guia->gravarguiaconvenio($guia_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarguiaconvenioexame($guia_id) {
        $this->guia->gravarguiaconvenioexame($guia_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function recebidoresultado($paciente_id, $agenda_exames_id) {
        $this->guia->recebidoresultado($agenda_exames_id);
        redirect(base_url() . "ambulatorio/guia/acompanhamento/$paciente_id");
    }

    function cancelarrecebidoresultado($paciente_id, $agenda_exames_id) {
        $this->guia->cancelarrecebidoresultado($agenda_exames_id);
        redirect(base_url() . "ambulatorio/guia/acompanhamento/$paciente_id");
    }

    function gravarverificado($agenda_exame_id) {
        $this->guia->gravarverificado($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function fecharprocedimentonota($agenda_exame_id) {
//        $this->guia->gravarverificado($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarchecknota($ambulatorio_guia_id) {
        $this->guia->gravarchecknota($ambulatorio_guia_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function valoralterado($agenda_exames_id) {
        $data['alterado'] = $this->guia->valoralterado($agenda_exames_id);
        $this->load->View('ambulatorio/valoralterado-form', $data);
    }

    function relatoriocaixapersonalizado() {
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
        $data['grupomedico'] = $this->grupomedico->listargrupomedicos();
        
        $data['empresa'] = $this->guia->listarempresas();
        $data['operadores'] = $this->operador_m->listartecnicos();
        $this->loadView('ambulatorio/relatoriocaixapersonalizado', $data);
    }

    function gerarelatoriocaixapersonalizando() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['paciente'] = ($_POST['txtNome'] != '') ? $_POST['txtNome'] : "TODOS";
        $data['grupo'] = $_POST['grupo'];
        $data['operador'] = $this->operador_m->listaroperador($_POST['operador']);
        $data['medico'] = $this->operador_m->listaroperador($_POST['medico']);
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['formapagamento'] = $this->formapagamento->listarforma();
        $data['caixa'] = $this->caixa->listarsangriacaixa();
        $data['creditos'] = $this->guia->relatoriocaixacreditoslancados();
        
        $data['procNaoFaturados'] = $this->guia->relatoriocaixapersonalizadoprocedimentosnaofaturados();
        $data['operadores'] = $this->guia->relatoriocaixapersonalizadooperadores();
        // Obs: A busca pelos procedimentos é feita na view. (Caso queira alterar a busca, altere as duas funções acima e a que está dentro da view)
        
        $this->load->View('ambulatorio/impressaorelatoriocaixapersonalizando', $data);
    }    

    function gerarelatoriocaixa() {
        $data['operador'] = $this->operador_m->listaroperador($_POST['operador']);
        $data['medico'] = $this->operador_m->listaroperador($_POST['medico']);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriocaixa();
        $data['creditos'] = $this->guia->relatoriocaixacreditoslancados();
        $data['relatoriohomecare'] = $this->guia->relatoriocaixahomecare();
        $data['caixa'] = $this->caixa->listarsangriacaixa();
        $data['contador'] = $this->guia->relatoriocaixacontador();
        $data['formapagamento'] = $this->formapagamento->listarforma();
        $this->load->View('ambulatorio/impressaorelatoriocaixa', $data);
    }

    function relatoriocaixa() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['procedimentos'] = $this->procedimento->listarprocedimentos();
        $data['grupomedico'] = $this->grupomedico->listargrupomedicos();
        $this->loadView('ambulatorio/relatoriocaixa', $data);
    }

    function relatoriocaixafaturado() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocaixafaturado', $data);
    }

    function ajustarvalorprocedimentocbhpm() {
        $data['convenio'] = $this->convenio->listardadoscbhpm();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriovalorprocedimentocbhpm', $data);
    }

    function relatoriovalorprocedimento() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriovalorprocedimento', $data);
    }

    function gerarrelatoriovalorprocedimento() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['empresa_id'] = $_POST['empresa'];
        $data['relatorio'] = $this->guia->relatoriovalorprocedimento();
        $data['contador'] = $this->guia->relatoriovalorprocedimentocontador();
        $this->loadView('ambulatorio/ajustarvalorprocedimento', $data);
    }

    function gravarajustarvalorprocedimentocbhpm() {
        $this->guia->gravarajustarvalorprocedimentocbhpm();
        $data['mensagem'] = 'Valores Alterados Com Sucesso.';

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/ajustarvalorprocedimentocbhpm", $data);
    }

    function gravarnovovalorprocedimento() {
        $ambulatorio_guia_id = $this->guia->gravarnovovalorprocedimento();
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar valor. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar valor.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/relatoriovalorprocedimento", $data);
    }

    function relatoriocaixacartaopersonalizado() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocaixacartaopersonalizado', $data);
    }

    function relatoriocaixacartao() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocaixacartao', $data);
    }

    function relatoriocaixacartaoconsolidado() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocaixacartaoconsolidado', $data);
    }

    function gerarelatoriocaixacartaoconsolidado() {
        $data['operador'] = $_POST['operador'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['formapagamento'] = $this->formapagamento->listarformacartao();
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriocaixacartaoconsolidado();
        $data['contador'] = $this->guia->relatoriocaixacontadorcartaoconsolidado();
//        echo '<pre>';
//        var_dump($data['relatorio']); die;
        $this->load->View('ambulatorio/impressaorelatoriocaixacartaoconsolidado', $data);
    }

    function relatoriophmetria() {
        $this->loadView('ambulatorio/relatoriophmetria');
    }

    function gerarelatoriocaixafaturado() {
        $data['operador'] = $_POST['operador'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriocaixafaturado();
        $data['contador'] = $this->guia->relatoriocaixacontadorfaturado();
        $data['formapagamento'] = $this->formapagamento->listarforma();
        $this->load->View('ambulatorio/impressaorelatoriocaixafaturado', $data);
    }

    function gerarelatoriocaixacartaopersonalizado() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['caixa'] = $this->caixa->listarsangriacaixa();
        $data['grupo'] = $_POST['grupo'];
        $data['operador'] = $this->operador_m->listaroperador($_POST['operador']);
        $data['medico'] = $this->operador_m->listaroperador($_POST['medico']);
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['formapagamento'] = $this->formapagamento->listarformacartao();
        
        $data['operadores'] = $this->guia->relatoriocaixacartaopersonalizadooperadores();
        // Obs: A busca pelos procedimentos é feita na view. (Caso queira alterar a busca, altere as duas funções acima e a que está dentro da view)
        
        $this->load->View('ambulatorio/impressaorelatoriocaixacartaopersonalizado', $data);
    }

    function gerarelatoriocaixacartao() {
        $data['operador'] = $this->operador_m->listaroperador($_POST['operador']);
        $data['medico'] = $this->operador_m->listaroperador($_POST['medico']);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriocaixacartao();
        $data['contador'] = $this->guia->relatoriocaixacontadorcartao();
        $data['caixa'] = $this->caixa->listarsangriacaixa();
        $data['formapagamento'] = $this->formapagamento->listarformacartao();
        $this->load->View('ambulatorio/impressaorelatoriocaixacartao', $data);
    }

    function gerarelatoriophmetria() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['relatorio'] = $this->guia->relatoriophmetria();
        $data['contador'] = $this->guia->relatoriophmetriacontador();
        $this->load->View('ambulatorio/impressaorelatoriophmetria', $data);
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

    function gerardicom($guia_id) {
        $exame = $this->exame->listardicom($guia_id);
        var_dump($guia_id);
        echo 'okk';
        var_dump($exame);
        echo 'okk';
        die;
        $grupo = $exame[0]->grupo;
        if ($grupo == 'RX' || $grupo == 'MAMOGRAFIA') {
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

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
