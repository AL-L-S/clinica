<?php

/**
 * Esta classe é o controler de Incentivo. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
require_once APPPATH . 'controllers/base/BaseController.php';

class Incentivo extends BaseController {

    /**
     * Função
     * @name carregarView
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Incentivo() {
        parent::__construct();
        $this->load->model('giah/incentivo_model', 'incentivo_m');
        $this->load->model('giah/competencia_model', 'competencia');
        $this->load->model('giah/servidor_model', 'servidor');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    /**
     * Função
     * @name carregarView
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function index() {
        $this->pesquisar();
    }
    /**
     * Função
     * @name pesquisar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function pesquisar() {
        $data['competencia'] = $this->competencia->competenciaAtiva();
        $data['lista'] = $this->incentivo_m->listarIncentivosDoAno(date('Y'));
        $this->loadView('giah/incentivo-lista', $data);
    }
     /**
     * Função
     * @name pesquisarCompetencia
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param $competencia com a informação da competencia aberta
     */
    function pesquisarCompetencia($competencia=null) {
        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        if (isset($_POST['competencia'])) {
            $data['competencia'] = $_POST['competencia'];
            $data['filtro'] = $_POST['filtro'];
            $data['lista'] = $this->incentivo_m->listarIncentivosDaCompetencia($data['competencia'], $data['filtro']);
        } else {
            $data['competencia'] = $competencia;
            $data['lista'] = $this->incentivo_m->listarIncentivosDaCompetencia($competencia);
        }
        
        $this->loadView('giah/incentivo-form', $data);
    }
    /**
     * Função
     * @name novo
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function novo() {
        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        $data['competencia'] = $this->competencia->competenciaAtiva();
        $data['lista'] = $this->incentivo_m->listarIncentivosDaCompetencia($data['competencia']);
        $data['novo'] = true;
        $this->loadView('giah/incentivo-form', $data);
    }
    /**
     * Função
     * @name gravar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function gravar() {
        
        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        
        $data['competencia'] = $this->competencia->competenciaAtiva();
        
        $totalincentivo = $this->incentivo_m->somarIncentivo($data['competenciaativa']);
        $ltt = $_POST['txtTeto_id'];
        $servidor_id = $_POST['txtServidorID'];
        
        $incentivo = str_replace(",", ".",str_replace(".", "", $_POST['txtValor']));
        $lotacao = $_POST['txtUo_id'];
        $somaincentivo = ((((float)$totalincentivo[0]->valor)) + (float)$incentivo);

        $incentivo = str_replace(",", ".", str_replace(".", "", $_POST['txtValor']));
        $somaincentivo = ((((float) $totalincentivo[0]->valor)) + (float) $incentivo);

        $tetolincentivodirecao = $this->incentivo_m->tetoIncentivodirecao($data['competenciaativa']);

        $tetolincentivodirecao = (((float) $tetolincentivodirecao[0]->valor));
        $testaservidor_id = $this->incentivo_m->verificarincentivoservidopor($data['competenciaativa'], $servidor_id);

        if ($testaservidor_id == 0){
            if (($tetolincentivodirecao >= $somaincentivo)||($lotacao == 1)){
                if ($this->incentivo_m->gravar($data['competenciaativa']))
                    {$data['mensagem'] = 'Sucesso ao gravar o incentivo.';}
                 else
                    {$data['mensagem'] = 'Erro ao gravar o incentivo. Opera&ccedil;&atilde;o cancelada.';}}
            else {$data['mensagem'] = 'Esta dire&ccedil;&atilde;o n&atilde;o pode solicitar incentivo ou atingiu o limite desta dire&ccedil;&atilde;o.';}
        }else{
            $data['mensagem'] = 'Erro ao gravar o incentivo. Servidor ja cadastrado.';
        }
        $data['lista'] = $this->incentivo_m->listarIncentivosDoAno(date('Y'));
    
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "giah/incentivo");
        //$this->loadView('giah/incentivo-lista', $data);

    }
    /**
    * Função
    * @name excluir
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param void
    */
    function excluir($competencia, $servidor_id) {
        if ($this->incentivo_m->delete($competencia, $servidor_id)) {
            $data['mensagem'] = 'Sucesso ao excluir o incentivo.';
        } else {
            $data['mensagem'] = 'Erro ao excluir o incentivo. Opera&ccedil;&atilde;o cancelada.';
        }

        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        $data['competencia'] = $competencia;
        $data['lista'] = $this->incentivo_m->listarIncentivosDaCompetencia($competencia);
//        $this->carregarView($data, 'giah/incentivo-form');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "giah/incentivo");
    }
    /**
    * Função
    * @name aprovar
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param $responsval, $competencia, $servidor_id, $valor
    */
    function aprovar($responsval, $competencia, $servidor_id=null, $valor=null) {
        $this->incentivo_m->listarIncentivosDaCompetencia($competencia);
        $this->incentivo_m->aprovar($responsval, $competencia, $servidor_id, $valor);
        $mensagem = 'incentivo006';
        if ($responsval == 1) {
            $this->carregarcompetenciadirex($responsval, $mensagem);
        } else {
            $this->carregarcompetenciasuper($responsval, $mensagem);
        }
        //redirect(base_url()."giah/incentivo/carregarcompetencia/$responsval/$mensagem","refresh");
    }
    /**
    * Função
    * @name aprovar
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param $responsval, $competencia, $lotacao, $valor
    */
    function aprovartodossetor($responsval, $competencia, $lotacao, $valor) {
        $this->incentivo_m->listarIncentivosDaCompetencia($competencia);

        $this->incentivo_m->aprovartodossetor($responsval, $competencia, $lotacao, $valor);
        $mensagem = 'Opera&ccedil;&atilde;o realizada com sucesso.';

        if ($responsval == 1) {
            $this->carregarcompetenciadirex($responsval, $mensagem);
        } else {
            $this->carregarcompetenciasuper($responsval, $mensagem);
        }
        // redirect(base_url()."giah/incentivo/carregarcompetencia/$responsval/$mensagem","refresh");
    }
    /**
    * Função
    * @name aprovartodos
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param $responsval, $competencia, $valor
    */
    function aprovartodos($responsval, $competencia, $valor) {
        $this->incentivo_m->listarIncentivosDaCompetencia($competencia);

        $this->incentivo_m->aprovartodos($responsval, $competencia, $valor);
        $mensagem = 'incentivo006';
        if ($responsval == 1) {
            $this->carregarcompetenciadirex($responsval, $mensagem);
        } else {
            $this->carregarcompetenciasuper($responsval, $mensagem);
        }
        //redirect(base_url()."giah/incentivo/carregarcompetencia/$responsval/$mensagem","refresh");
    }
    /**
    * Função
    * @name carregarcompetenciadirex
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param $responsval, $mensagem
    */
    function carregarcompetenciadirex($responsavel=null, $mensagem=null) {
        $competencia = $this->competencia->competenciaAtiva();
        if ($mensagem != null) {
            $data['mensagem'] = $this->mensagem->getMensagem($mensagem);
        } else {
            $data['mensagem'] = null;
        }

        if (isset($competencia)) {
            $data['responsavel'] = $responsavel; //TODO: hm lembrar que 1-diretoria e 2-superintendencia

            $data['lista'] = $this->incentivo_m->listarIncentivosDaCompetencia($competencia);
            $data['direcao'] = $this->incentivo_m->listarTetoDaCompetencia($competencia);
//                var_dump($data);
//                die();
            if (count($data['lista']) == 0) {
                $data['mensagem'] = $this->mensagem->getMensagem('incentivo005');
            }
        }
        if (($this->utilitario->autorizar(10, $this->session->userdata('modulo')) == true) == true) {

            $this->load->view('header', $data);
            $this->load->view('giah/incentivo-aprovacaodirex', $data);
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }

        $this->load->view('footer');
    }
    /**
    * Função
    * @name carregarcompetenciasuper
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param $responsval, $mensagem
    */
    function carregarcompetenciasuper($responsavel=null, $mensagem=null) {
        $competencia = $this->competencia->competenciaAtiva();
        if ($mensagem != null) {
            $data['mensagem'] = $this->mensagem->getMensagem($mensagem);
        } else {
            $data['mensagem'] = null;
        }

        if (isset($competencia)) {
            $data['responsavel'] = $responsavel; //TODO: hm lembrar que 1-diretoria e 2-superintendencia

            $data['lista'] = $this->incentivo_m->listarIncentivosDaCompetencia($competencia);
            $data['direcao'] = $this->incentivo_m->listarTetoDaCompetencia($competencia);
//                var_dump($data);
//                die();
            if (count($data['lista']) == 0) {
                $data['mensagem'] = $this->mensagem->getMensagem('incentivo005');
            }
        }
        if (($this->utilitario->autorizar(10, $this->session->userdata('modulo')) == true) == true) {

            $this->load->view('header', $data);
            $this->load->view('giah/incentivo-aprovacaosuper', $data);
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }

        $this->load->view('footer');
    }
    /**
    * Função
    * @name novoteto
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param void
    */
    function novoteto() {
        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        $data['competencia'] = $this->competencia->competenciaAtiva();
        $data['lista'] = $this->incentivo_m->listarTetoDaCompetencia($data['competencia']);
        $data['novo'] = true;
        //$this->carregarView($data, 'giah/incentivoteto-form');
        $this->loadView('giah/incentivoteto-form', $data);
    }
    /**
    * Função
    * @name pesquisarteto
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param void
    */
    function pesquisarteto() {
        $data['competencia'] = $this->competencia->competenciaAtiva();
        $data['lista'] = $this->incentivo_m->listarTetoDoAno(date('Y'));
        //$this->carregarView($data, 'giah/incentivoteto-lista');
        $this->loadView('giah/incentivoteto-lista', $data);
    }
    /**
    * Função
    * @name pesquisarCompetenciaTeto
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param $competencia
    */
    function pesquisarCompetenciaTeto($competencia=null) {
        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        if (isset($_POST['competencia'])) {
            $data['competencia'] = $_POST['competencia'];
            $data['lista'] = $this->incentivo_m->listarTetoDaCompetencia($data['competencia']);
        } else {
            $data['competencia'] = $competencia;
            $data['lista'] = $this->incentivo_m->listarTetoDaCompetencia($competencia);
        }
        $this->carregarView($data, 'giah/incentivoteto-form');
    }
    /**
    * Função
    * @name gravarteto
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param void
    */
    function gravarteto() {
        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        $data['competencia'] = $this->competencia->competenciaAtiva();
        $resultado = $this->incentivo_m->virificarTeto($data['competencia']);
//        var_dump($resultado);
//        die;
        if ($resultado == 0){
            if ($this->incentivo_m->gravarTeto($data['competencia'])) {
                $data['mensagem'] = 'Sucesso ao gravar o teto.';
            } else {
                $data['mensagem'] = 'Erro ao gravar o teto. Opera&ccedil;&atilde;o cancelada.';
            }
        }else{
            $data['mensagem'] = 'Erro ao gravar o teto. Teto ja cadastrado.';
        }

        $data['lista'] = $this->incentivo_m->listarTetoDaCompetencia($data['competencia']);
//        $this->carregarView($data, 'giah/incentivoteto-form');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/incentivo/novoteto",$data);
    }
    /**
    * Função
    * @name excluirteto
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param $competencia, $teto_id
    */
    function excluirteto($competencia, $teto_id) {
        if ($this->incentivo_m->excluirTeto($competencia, $teto_id)) {
            $data['mensagem'] = 'Sucesso ao excluir o teto.';
        } else {
            $data['mensagem'] = 'Erro ao excluir o teto.';
        }

        $data['competenciaativa'] = $this->competencia->competenciaAtiva();
        $data['competencia'] = $competencia;
        $data['lista'] = $this->incentivo_m->listarTetoDaCompetencia($competencia);
//        $this->carregarView($data, 'giah/incentivoteto-form');
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/incentivo/novoteto",$data);
    }

    /**
    * Função
    * @name carregarView
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return void
    * @param $data=null, $view=null
    */
    private function carregarView($data=null, $view=null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(9, $this->session->userdata('modulo')) == true) {

            $this->load->view('header', $data);

            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/incentivo-lista', $data);
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