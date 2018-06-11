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
class Indicacao extends BaseController {

    function Indicacao() {
        parent::Controller();
        $this->load->model('ambulatorio/indicacao_model', 'indicacao');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/tipo_model', 'tipo');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('cadastro/classe_model', 'classe');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/indicacao-lista', $args);

//            $this->carregarView($data);
    }

    function pesquisargrupoindicacao($args = array()) {

        $this->loadView('ambulatorio/grupoindicacao-lista', $args);

//            $this->carregarView($data);
    }

    function carregargrupoindicacao($grupo_id) {
        $data['grupo'] = $this->indicacao->carregargrupoindicacao($grupo_id);
        $this->loadView('ambulatorio/grupoindicacao-form', $data);
    }

    function carregarindicacao($exame_indicacao_id) {
        $obj_indicacao = new indicacao_model($exame_indicacao_id);
        $data['obj'] = $obj_indicacao;
        $data['grupo'] = $this->indicacao->listargrupoindicacao();


        $this->loadView('ambulatorio/indicacao-form', $data);
    }

    function carregarindicacaofinanceiro($exame_indicacao_id) {
        $obj_indicacao = new indicacao_model($exame_indicacao_id);
        $data['obj'] = $obj_indicacao;
        $data['grupo'] = $this->indicacao->listargrupoindicacao();


        $this->loadView('ambulatorio/indicacaofinanceiro-form', $data);
    }

    function excluirgrupo($grupo_id) {
        if ($this->indicacao->excluirgrupo($grupo_id)) {
            $mensagem = 'Sucesso ao excluir o Grupo';
        } else {
            $mensagem = 'Erro ao excluir o Grupo. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/indicacao/pesquisargrupoindicacao");
    }

    function excluir($exame_indicacao_id) {
        if ($this->indicacao->excluir($exame_indicacao_id)) {
            $mensagem = 'Sucesso ao excluir este item.';
        } else {
            $mensagem = 'Erro ao excluir este item. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/indicacao");
    }

    function gravargrupo() {
        $exame_indicacao_id = $this->indicacao->gravargrupo();
        if ($exame_indicacao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Grupo. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Grupo.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/indicacao/pesquisargrupoindicacao");
    }

    function gravar() {
        $exame_indicacao_id = $this->indicacao->gravar();
        if ($exame_indicacao_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Indicacao. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Indicacao.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/indicacao");
    }

    function gravarfinanceiro() {
        $exame_indicacao_id = $this->indicacao->gravarfinanceiro();
//        var_dump($exame_indicacao_id); die;
        if ($exame_indicacao_id == "-1") {
                   echo '<html><meta charset="utf-8">
        <script type="text/javascript">
        alert("Operação Efetuada Com Sucesso");
        window.onunload = fechaEstaAtualizaAntiga;
        function fechaEstaAtualizaAntiga() {
            window.opener.location.reload();
            }
        window.close();
            </script>
            </html>';
        } else {
                              echo '<html><meta charset="utf-8">
        <script type="text/javascript">
        alert("Operação Efetuada Com Sucesso");
        window.onunload = fechaEstaAtualizaAntiga;
        function fechaEstaAtualizaAntiga() {
            window.opener.location.reload();
            }
        window.close();
            </script>
            </html>';
        }

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
