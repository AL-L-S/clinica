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
class Procedimento extends BaseController {

    function Procedimento() {
        parent::Controller();
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('cadastro/laboratorio_model', 'laboratorio');
        $this->load->model('cadastro/grupoclassificacao_model', 'grupoclassificacao');
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
        $this->loadView('ambulatorio/procedimento-lista', $data);
    }

    function procedimentoconveniovalor($procedimento_tuss_id) {

        $data['procedimento'] = $this->procedimento->listarprocedimentoprodutovalor($procedimento_tuss_id);
        $data['valor'] = $this->procedimento->listarprocedimentoconveniovalor($procedimento_tuss_id);
        $data['convenio'] = $this->convenio->listardados();
//        var_dump($data['valor']); die;
        $this->loadView('ambulatorio/procedimentoconveniovalor-form', $data);
    }

    function gravarprocedimentoconveniovalor($procedimento_tuss_id) {

        $this->procedimento->gravarprocedimentoconveniovalor($procedimento_tuss_id);
        redirect(base_url() . "ambulatorio/procedimento/procedimentoconveniovalor/$procedimento_tuss_id");
    }

    function excluirprocedimentoconveniovalor($procedimento_convenio_produto_valor_id, $procedimento_tuss_id) {

        $this->procedimento->excluirprocedimentoconveniovalor($procedimento_convenio_produto_valor_id);

        redirect(base_url() . "ambulatorio/procedimento/procedimentoconveniovalor/$procedimento_tuss_id");
    }

    function pesquisartuss($args = array()) {
        $this->loadView('ambulatorio/procedimentotuss-lista', $args);
    }

    function carregarajustevalores() {
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/ajustevalores-form', $data);
    }

//    function carregarajustevalores() {
//        $data['grupos'] = $this->procedimento->listargrupos();
//        $this->loadView('ambulatorio/ajustevalores-form', $data);
//    }

    function gravarajustevalores() {
        $verifica = $this->procedimento->gravarajustevalores();
        if ($verifica) {
            $data['mensagem'] = 'Erro ao ajustar os valores. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao ajustar os valores.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimento");
    }

    function carregarexclusaoporgrupo() {
        $obj_procedimento = new procedimento_model($procedimento_tuss_id);
        $data['obj'] = $obj_procedimento;
        $data['grupos'] = $this->procedimento->listargrupos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimento-form', $data);
    }

    function carregaragrupadorprocedimento($procedimento_tuss_id) {
        $obj_procedimento = new procedimento_model($procedimento_tuss_id);
        $data['obj'] = $obj_procedimento;
        $data['procedimento'] = $this->procedimento->listarprocedimento3();
        $data['procedimentoagrupados'] = $this->procedimento->listarprocedimentoagrupados($procedimento_tuss_id);
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/agrupadorprocedimento-form', $data);
    }

    function ajustarportetusschpm() {
        $this->loadView('ambulatorio/ajustarportetusschpm-form');
    }

    function gravarajustarportetusschpm() {
//        echo "<pre>"; 
//        var_dump($_POST);
//        die;
        $procedimento_tuss_id = $this->procedimento->gravarajustarportetusschpm();
        if ($procedimento_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao atualizar os valores. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao atualizar os valores.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimento/pesquisartuss");
    }

    function carregarprocedimento($procedimento_tuss_id) {
        $obj_procedimento = new procedimento_model($procedimento_tuss_id);
        $data['obj'] = $obj_procedimento;
        $data['procedimento'] = $this->procedimentoplano->listarprocedimento2();
        $data['subgrupos'] = $this->grupoclassificacao->listarsubgrupo2();
        $data['grupos'] = $this->procedimento->listargrupos();
        $data['laboratorios'] = $this->laboratorio->listarlaboratorios();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/procedimento-form', $data);
    }

    function carregarprocedimentotuss($procedimento_tuss_id) {
        $data['procedimento'] = $this->procedimento->listarprocedimentostuss($procedimento_tuss_id);
        $data['classificacao'] = $this->procedimento->listarclassificacaotuss();
        if (count($data['procedimento']) == 0) {
            $this->loadView('ambulatorio/procedimentotuss2-form', $data);
        } else {
            $this->loadView('ambulatorio/procedimentotuss-form', $data);
        }
    }

    function relatorioprocedimento() {
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioprocedimento', $data);
    }

    function relatorioprocedimentoconvenio() {

        $data['convenio'] = $this->convenio->listardados();
        $data['grupo'] = $this->guia->listargrupo();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioprocedimentoconvenio', $data);
    }

    function gerarelatorioprocedimento() {
        $data['grupo'] = $_POST['grupo'];
        $data['relatorio'] = $this->procedimento->relatorioprocedimentos();
        $data['empresa'] = $this->procedimento->listarempresas();
        $this->load->View('ambulatorio/impressaorelatorioprocedimento', $data);
    }

    function gerarelatorioprocedimentoconvenio() {

        $this->load->plugin('mpdf');
        $grupo = 'laboratorial';
        $filename = "laudo.pdf";
        $cabecalho = "";
        $rodape = "";


        $data['grupo'] = $_POST['grupo'];
        $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        $data['conveniotipo'] = $_POST['convenio'];
        $data['relatorio'] = $this->procedimento->relatorioprocedimentoconvenio();
        if ($_POST['planilha'] == '1') {

            $html = $this->load->view('ambulatorio/impressaorelatorioprocedimentoconvenio', $data, true);
            $horario = date('d-m-Y');
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-type: application/x-msexcel");
            header("Content-Disposition: attachment; filename=\"Procedimentos {$data['relatorio'][0]->convenio} $horario.xls\"");
            header("Content-Description: PHP Generated Data");
            // Envia o conteúdo do arquivo
            echo $html;
            exit;
        } else {
            $this->load->View('ambulatorio/impressaorelatorioprocedimentoconvenio', $data);
        }


//        pdf($html, $filename, $cabecalho, $rodape, $grupo);
    }

    function gerarelatorioprocedimentotuss() {
        $data['relatorio'] = $this->procedimento->relatorioprocedimentotuss();
        $data['empresa'] = $this->procedimento->listarempresas();
        $this->load->View('ambulatorio/impressaorelatorioprocedimentotuss', $data);
    }

    function excluirprocedimentoagrupado($procedimento_agrupador_id, $procedimento_id) {
        if ($this->procedimento->excluirprocedimentoagrupado($procedimento_agrupador_id)) {
            $mensagem = 'Sucesso ao excluir desagrupar o Procedimento';
        } else {
            $mensagem = 'Erro ao desagrupar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimento/carregaragrupadorprocedimento/$procedimento_id");
    }

    function excluir($procedimento_tuss_id) {
        if ($this->procedimento->excluir($procedimento_tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimento';
        } else {
            $mensagem = 'Erro ao excluir o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimento");
    }

    function excluirprocedimentotuss($tuss_id) {
        if ($this->procedimento->excluirprocedimentotuss($tuss_id)) {
            $mensagem = 'Sucesso ao excluir o Procedimento';
        } else {
            $mensagem = 'Erro ao excluir o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/procedimento/pesquisartuss");
    }

    function gravaragrupadorprocedimento() {
        $procedimento_tuss_id = $this->procedimento->gravaragrupadorprocedimento();

        $data['mensagem'] = 'Sucesso ao gravar o Agrupador.';
        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "ambulatorio/procedimento");
    }

    function gravar() {
        $procedimento_tuss_id = $this->procedimento->gravar();
        if ($procedimento_tuss_id == "0") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Procedimento ja cadastrado.';
        } elseif ($procedimento_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $this->procedimento->atualizaprocedimentosconvenioscbhpm($procedimento_tuss_id);
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimento");
    }

    function gravartuss() {
//        echo "<pre>";
//        var_dump($_POST); die;
        $procedimento_tuss_id = $this->procedimento->gravartuss();
        if ($procedimento_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/procedimento/pesquisartuss");
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
