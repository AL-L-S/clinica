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
class Localizapaciente extends BaseController {

    function Localizapaciente() {
        parent::Controller();
        $this->load->model('ambulatorio/localizapaciente_model', 'localizapaciente');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar() {
        $data['definitivo'] ="";
        $data['totaldefinitivo'] =0;
        $data['totaltemp'] =0;
        if (isset($_POST['nome'])) {
        $data['definitivo'] = $this->localizapaciente->listarpaciente($_POST['nome']);
        $data['listatemp'] = $this->localizapaciente->listartemp($_POST['nome']);
        $data['totaldefinitivo'] = $this->localizapaciente->contadordefinitivo($_POST['nome']);
        $data['totaltemp'] = $this->localizapaciente->contadortemp($_POST['nome']);
        }
        $this->loadView('ambulatorio/localizapaciente-lista', $data);
//            $this->carregarView($data);
    }

    function novo() {
        $ambulatorio_pacientetemp_id = $this->localizapaciente->criar();
        $this->carregarlocalizapaciente($ambulatorio_pacientetemp_id);

//            $this->carregarView($data);
    }

    function carregarlocalizapaciente($ambulatorio_pacientetemp_id) {

        $obj_localizapaciente = new localizapaciente_model($ambulatorio_pacientetemp_id);
        $data['obj'] = $obj_localizapaciente;
        $data['idade'] = 0;
        $data['contador'] = $this->localizapaciente->contador($ambulatorio_pacientetemp_id);
        if ($data['contador'] > 0) {
            $data['exames'] = $this->localizapaciente->listaragendas($ambulatorio_pacientetemp_id);
        }
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/localizapaciente-form', $data);
    }

    function excluir($agenda_exames_id, $ambulatorio_pacientetemp_id) {
        $this->localizapaciente->excluir($agenda_exames_id);
        $this->carregarlocalizapaciente($ambulatorio_pacientetemp_id);
    }

    function gravar() {
        $localizapaciente_tuss_id = $this->localizapaciente->gravar();
        if ($localizapaciente_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/localizapaciente");
    }

    function gravartemp() {
        $ambulatorio_pacientetemp_id = $_POST['txtpaciente_id'];
        $this->localizapaciente->gravarexames();
        $this->carregarlocalizapaciente($ambulatorio_pacientetemp_id);
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
