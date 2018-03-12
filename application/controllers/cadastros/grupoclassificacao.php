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
class Grupoclassificacao extends BaseController {

    function Grupoclassificacao() {
        parent::Controller();
        $this->load->model('cadastro/grupoclassificacao_model', 'grupoclassificacao');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/grupoclassificacao-lista', $args);

//            $this->carregarView($data);
    }

    function pesquisarsubgrupo($args = array()) {
        $this->loadView('cadastros/subgrupo-lista', $args);
    }

    function pesquisarassociacaosubgrupo($args = array()) {
        $this->loadView('cadastros/subgrupoassociacao-lista', $args);
    }

    function carregarassociacaosubgrupo($grupo) {
        $data['grupo'] = $grupo;
        $data['lista'] = $this->grupoclassificacao->listarassociacaosubgrupo($grupo);
//        echo "<pre>";
//        var_dump($data); die;
        $data['subgrupos'] = $this->grupoclassificacao->listarsubgrupo2();
        $this->loadView('cadastros/carregarassociacaosubgrupo-form', $data);
    }

    function carregarsubgrupo($subgrupo_id) {
        $data['obj'] = $this->grupoclassificacao->instanciarsubgrupo($subgrupo_id);
        $this->loadView('cadastros/subgrupo-form', $data);
    }

    function carregargrupoclassificacao($exame_grupoclassificacao_id) {
        $obj_grupoclassificacao = new grupoclassificacao_model($exame_grupoclassificacao_id);
        $data['obj'] = $obj_grupoclassificacao;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/grupoclassificacao-form', $data);
    }

    function carregargrupoclassificacaoadicionar($exame_grupoclassificacao_id) {
        $data['relatorio'] = $this->grupoclassificacao->listargrupoclassificacaoadicionar($exame_grupoclassificacao_id);
//        $data['classificacaos'] = $this->operador_m->listarclassificacaos();
        $data['classificacao'] = $this->guia->listarclassificacao();
        $obj_grupoclassificacao = new grupoclassificacao_model($exame_grupoclassificacao_id);
        $data['obj'] = $obj_grupoclassificacao;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/grupoclassificacaoadicionar-form', $data);
    }

    function excluirassociacaosubgrupo($associacaoSubgrupoId, $grupo) {
        if ($this->grupoclassificacao->excluirassociacaosubgrupo($associacaoSubgrupoId)) {
            $mensagem = 'Sucesso ao excluir o Subgrupo';
        } else {
            $mensagem = 'Erro ao excluir o Subgrupo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/grupoclassificacao/carregarassociacaosubgrupo/$grupo");
    }

    function excluirsubgrupo($subgrupo_id) {
        if ($this->grupoclassificacao->excluirsubgrupo($subgrupo_id)) {
            $mensagem = 'Sucesso ao excluir o Subgrupo';
        } else {
            $mensagem = 'Erro ao excluir o Subgrupo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/grupoclassificacao/pesquisarsubgrupo");
    }

    function excluir($grupoclassificacao_id) {
        if ($this->grupoclassificacao->excluir($grupoclassificacao_id)) {
            $mensagem = 'Sucesso ao excluir o Grupo de classificacão';
        } else {
            $mensagem = 'Erro ao excluir o Grupo de classificacão. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/grupoclassificacao");
    }
    
    function excluirclassificacaogrupo($operador_grupo_classificacao_id, $operador_grupo_id) {
        if ($this->grupoclassificacao->excluirclassificacaogrupo($operador_grupo_classificacao_id)) {
            $mensagem = 'Sucesso ao excluir classificação';
        } else {
            $mensagem = 'Erro ao excluir classificação. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "cadastros/grupoclassificacao/carregargrupoclassificacaoadicionar/$operador_grupo_id");
    }
    // Eu não quero mais programar esse sistema. Me salve!

    function gravarassociacaosubgrupo() {
        $grupo = $_POST['grupo'];
        $exame_grupoclassificacao_id = $this->grupoclassificacao->gravarassociacaosubgrupo();
        if ($exame_grupoclassificacao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Subgrupo. Opera&ccedil;&atilde;o cancelada.';
        } 
        elseif ($exame_grupoclassificacao_id == "-2") {
            $data['mensagem'] = 'Subgrupo já cadastrado.';
        }
        else {
            $data['mensagem'] = 'Sucesso ao gravar o Subgrupo.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoclassificacao/carregarassociacaosubgrupo/$grupo");
    }

    function gravarsubgrupo() {
        $exame_grupoclassificacao_id = $this->grupoclassificacao->gravarsubgrupo();
        if ($exame_grupoclassificacao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Subgrupo. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Subgrupo.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoclassificacao/pesquisarsubgrupo");
    }

    function gravar() {
        $exame_grupoclassificacao_id = $this->grupoclassificacao->gravar();
        if ($exame_grupoclassificacao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Grupoclassificacao. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Grupoclassificacao.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoclassificacao");
    }

    function gravaradicionar() {
        if ($_POST['classificacao'] != '') {
            $classificacao = $this->grupoclassificacao->listargrupoclassificacaoadicionarteste();
        } else {
            $classificacao = array();
        }
//        var_dump($classificacao); die;

        if (count($classificacao) == 0) {
            $exame_grupoclassificacao_id = $this->grupoclassificacao->gravaradicionar();
            if ($exame_grupoclassificacao_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar a classifcação. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar a classifcação.';
            }
        } else {
            $data['mensagem'] = 'Já existe um registro dessa classifcação no grupo.';
            $exame_grupoclassificacao_id = $_POST['grupoclassificacaoid'];
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoclassificacao/carregargrupoclassificacaoadicionar/$exame_grupoclassificacao_id");
    }

    function ativar($exame_grupoclassificacao_id) {
        $this->grupoclassificacao->ativar($exame_grupoclassificacao_id);
        $data['mensagem'] = 'Sucesso ao ativar a Grupoclassificacao.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/grupoclassificacao");
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
