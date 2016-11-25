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
class Relatorio extends BaseController
{

    function Relatorio()
    {
        parent::Controller();
        $this->load->model('ponto/funcionario_model', 'funcionario');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->model('ponto/relatorio_model', 'relatorio');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index()
    {
        $this->pesquisar();
    }


    function pesquisar($args = array())
    {

        $this->loadView('ponto/funcionario-lista', $args);

//            $this->carregarView($data);
    }

    function impressaocartaofixo()
    {
        $competencia = $this->competencia->listaAtiva();
        $inicio = $competencia[0]->data_abertura;
        $fim = $competencia[0]->data_fechamento;
        $data['critica'] = $this->relatorio->relatoriofuncionariosfixo($inicio, $fim);
        $data['fixo'] = $this->relatorio->listarhorariofixo();

        $data['inicio'] = $inicio;
        $data['fim'] = $fim;

        $this->load->View('ponto/impressao-cartaotodosfixo', $data);
    }

    function impressaocartaovariavel()
    {
        $competencia = $this->competencia->listaAtiva();
        $inicio = $competencia[0]->data_abertura;
        $fim = $competencia[0]->data_fechamento;
        $data['critica'] = $this->relatorio->relatoriofuncionariosvariavel($inicio, $fim);
        $data['fixo'] = $this->relatorio->listarhorariofixo();
        $data['inicio'] = $inicio;
        $data['fim'] = $fim;

        $this->load->View('ponto/impressao-cartaotodosvariavel', $data);
    }

    function impressaocartaosemiflexivel()
    {
        $competencia = $this->competencia->listaAtiva();
        $inicio = $competencia[0]->data_abertura;
        $fim = $competencia[0]->data_fechamento;
        $data['critica'] = $this->relatorio->relatoriofuncionariossemiflexivel($inicio, $fim);
        $data['fixo'] = $this->relatorio->listarhorariofixo();
        $data['inicio'] = $inicio;
        $data['fim'] = $fim;

        $this->load->View('ponto/impressao-cartaotodossemiflexivel', $data);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */