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
class Horariostipo extends BaseController {

    function Horariostipo() {
        parent::Controller();
        $this->load->model('ponto/horariostipo_model', 'horariostipo');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ponto/horariostipo-lista', $args);

//            $this->carregarView($data);
    }

    function virada() {

        $this->loadView('ponto/virada-tipo');

//            $this->carregarView($data);
    }

    function carregar($horariostipo_id) {
        $obj_horariostipo = new horariostipo_model($horariostipo_id);
        $data['obj'] = $obj_horariostipo;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ponto/horariostipo-form', $data);
    }

    function excluir($horariostipo_id) {
        if ($this->horariostipo->excluir($horariostipo_id)) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ponto/horariostipo");
    }

    function gravar() {
        $horariostipo_id = $this->horariostipo->gravar();
        if ($horariostipo_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo");
    }

    function listarhorariovariavel($horariotipo) {
        $data['horariotipo'] = $horariotipo;
        $data['lista'] = $this->horariostipo->listarhoariovariavel($horariotipo);
        $this->loadView('ponto/horariovariavel-lista', $data);
    }

    function novohorariovariavel($horariostipo_id) {
        $data['horariostipo_id'] = $horariostipo_id;
        $this->loadView('ponto/horariovariavel-form', $data);
    }

    function gravarhorariovariavel() {
        $horariotipo = $_POST['txthorariostipoID'];
        if ($this->horariostipo->gravarhorariovariavel()) {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorariovariavel/$horariotipo");
    }

    function excluirhorariovariavel($horariostipo_id, $horariotipo) {
        if ($this->horariostipo->excluirhorariovariavel($horariostipo_id)) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorariovariavel/$horariotipo");
    }

    function listarhorarioindividual($funcionario_id) {
        $data['funcionario_id'] = $funcionario_id;
        $data['lista'] = $this->horariostipo->listarhoarioindividual($funcionario_id);
        $this->loadView('ponto/horarioindividual-lista', $data);
    }

    function novohorarioindividual($funcionario_id) {
        $data['funcionario_id'] = $funcionario_id;
        $this->loadView('ponto/horarioindividual-form', $data);
    }    

    function listarhorariotroca($funcionario_id) {
        $data['funcionario_id'] = $funcionario_id;
        $data['lista'] = $this->horariostipo->listarhoariotroca($funcionario_id);
        $this->loadView('ponto/horariotroca-lista', $data);
    }

    function novohorariotroca($funcionario_id) {
        $data['funcionario_id'] = $funcionario_id;
        $this->loadView('ponto/horariotroca-form', $data);
    }

    function gravarhorarioindividual() {
        $funcionario_id = $_POST['txtfuncionario_id'];
        if ($this->horariostipo->gravarhorarioindividual()) {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorarioindividual/$funcionario_id");
    }

    function gravarhorariotroca() {
        $funcionario_id = $_POST['txtfuncionario_id'];
        if ($this->horariostipo->gravarhorariotroca()) {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorariotroca/$funcionario_id");
    }

    function excluirhorarioindividual($horarioindividual_id, $funcionario_id) {
        if ($this->horariostipo->excluirhorarioindividual($horarioindividual_id)) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorarioindividual/$funcionario_id");
    }

    function listarhorariofixo($horariotipo) {
        $data['horariotipo'] = $horariotipo;
        $data['lista'] = $this->horariostipo->listarhorariofixo($horariotipo);
        $this->loadView('ponto/horariofixo-lista', $data);
    }

    function listarhorariosemiflexivel($horariotipo) {
        $data['horariotipo'] = $horariotipo;
        $data['lista'] = $this->horariostipo->listarhorariosemiflexivel($horariotipo);
        $this->loadView('ponto/horariosemiflexivel-lista', $data);
    }

    function viradahorariofixo() {

        $competencia = $this->competencia->listaAtiva();

        $todosfixos = $this->horariostipo->listartotalhoariofixo();

        foreach ($todosfixos as $value) {

            $horario = $this->horariostipo->listarhorariofixo($value->horariostipo_id);
            foreach ($horario as $item) {

                for ($index = $competencia[0]->data_abertura; $index <= $competencia[0]->data_fechamento; $index = date('Y-m-d', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime("$index"));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == substr($item->dia, 4)) {

                        $this->horariostipo->gravarviradahorariovariavel($item, $index, $value->horariostipo_id);
                    }
                }
            }
        }

        $this->loadView('ponto/virada-tipo');
    }

    function viradahorariovariavel() {

        $competencia = $this->competencia->listaAtiva();

        $todosvariavel = $this->horariostipo->listartotalhoariovariavel();

        foreach ($todosvariavel as $value) {

            $horario = $this->horariostipo->listarhorariovariavel($value->horariostipo_id);
//                echo "<pre>";
//                var_dump($horario);
//                die;
                $horarioid = 0;
            foreach ($horario as $item) {

if ($horarioid !=  $item->horariostipo_id){
    $datavericadora = '0000-00-00';
}
$horarioid = $item->horariostipo_id;

    
                for ($index = $competencia[0]->data_abertura; $index <= $competencia[0]->data_fechamento; $index = date('Y-m-d', strtotime("+1 days", strtotime($index)))) {

                    if ($index == $item->data) {

                        $this->horariostipo->gravarviradahorariovariavel($item, $index, $value->horariostipo_id);
                        $datavericadora = $index;
                        break;
                     
                        
                    } elseif ($datavericadora < $index) {


                        $datavericadora = $index;
                        $hora['horaentrada1'] = '00:00:00';
                        $hora['horasaida1'] = '00:00:00';
                        $hora['horaentrada2'] = '00:00:00';
                        $hora['horasaida2'] = '00:00:00';
                        $hora['horaentrada3'] = '00:00:00';
                        $hora['horasaida3'] = '00:00:00';
                        
                        $this->horariostipo->gravarviradahorariovariavelzerado($hora, $index, $value->horariostipo_id);
                    }
                    
                }
            }
        }

        $this->loadView('ponto/virada-tipo');
    }

    function viradahorariosemiflexivel() {
        
        $competencia = $this->competencia->listaAtiva();

        $todossemiflexivel = $this->horariostipo->listartotalhoariosemiflexivel();

        foreach ($todossemiflexivel as $value) {

            $horario = $this->horariostipo->listarhorariosemiflexivel($value->horariostipo_id);

            foreach ($horario as $item) {
                 
                $i = $item->inicio;
                for ($index = $competencia[0]->data_abertura; $index <= $competencia[0]->data_fechamento; $index = date('Y-m-d', strtotime("+1 days", strtotime($index)))) {

                    if ($i == $item->quantidade) {

                        $this->horariostipo->gravarviradahorariovariavel($item, $index, $item->horariostipo_id);
                        $i = $item->inicio;
                    } else {
                        $hora['horaentrada1'] = '00:00:00';
                        $hora['horasaida1'] = '00:00:00';
                        $hora['horaentrada2'] = '00:00:00';
                        $hora['horasaida2'] = '00:00:00';
                        $hora['horaentrada3'] = '00:00:00';
                        $hora['horasaida3'] = '00:00:00';
                        $this->horariostipo->gravarviradahorariovariavelzerado($hora, $index, $value->horariostipo_id);
                        $i++;
                    }
                }
            }
        }
        
        $this->loadView('ponto/virada-tipo');
    }

    function novohorariofixo($horariostipo_id) {
        $data['horariostipo_id'] = $horariostipo_id;
        $this->loadView('ponto/horariofixo-form', $data);
    }

    function gravarhorariofixo() {
        $horariotipo = $_POST['txthorariostipoID'];
        if ($this->horariostipo->gravarhorariofixo()) {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorariofixo/$horariotipo");
    }

    function novohorariosemiflexivel($horariostipo_id) {
        $data['horariostipo_id'] = $horariostipo_id;
        $this->loadView('ponto/horariosemiflexivel-form', $data);
    }

    function gravarhorariosemiflexivel() {
        $horariotipo = $_POST['txthorariostipoID'];
        if ($this->horariostipo->gravarhorariosemiflexivel()) {
            $data['mensagem'] = 'Erro ao gravar o Horario. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Horario.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorariosemiflexivel/$horariotipo");
    }

    function excluirhorariofixo($horariovariavel_id, $horariotipo) {
        if ($this->horariostipo->excluirhorariofixo($horariovariavel_id)) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorariofixo/$horariotipo");
    }

    function excluirhorariosemiflexivel($horariosemiflexivel_id, $horariotipo) {
        if ($this->horariostipo->excluirhorariosemiflexive($horariosemiflexivel_id)) {
            $mensagem = 'Sucesso ao excluir o Horario';
        } else {
            $mensagem = 'Erro ao excluir o Horario. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/horariostipo/listarhorariofixo/$horariotipo");
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
