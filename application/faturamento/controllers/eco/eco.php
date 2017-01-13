<?php

/**
 * Esta classe é o controller da Ficha Ceatox. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage eco
 */
require_once APPPATH . 'controllers/base/BaseController.php';

class Eco extends BaseController
{

    function Eco()
    {
        parent::Controller();
        $this->load->model('eco/eco_model', 'eco_m');
        $this->load->model('ceatox/ceatox_model', 'ceatox_m');
        $this->load->model('cadastro/paciente_model', 'paciente_m');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('validation');
        $this->load->library('image_lib');
    }

    /**
     * Função
     * @name index
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function index()
    {
        $this->pesquisar();
    }

    function impressaolaudo($laudo_id)
    {

        $data['laudo'] = $this->eco_m->impressaoLaudos($laudo_id);
        $data['ObservacoesGerais'] = $this->eco_m->impressaolaudoresposta(1, $laudo_id);
        $data['VentEsquerdoDimensoesHipertrofia'] = $this->eco_m->impressaolaudoresposta(2, $laudo_id);
        $data['VentEsquerdoAnaliseSgmentar'] = $this->eco_m->impressaolaudoresposta(3, $laudo_id);
        $data['VentEsquerdoFuncoes'] = $this->eco_m->impressaolaudoresposta(4, $laudo_id);
        $data['Aorta'] = $this->eco_m->impressaolaudoresposta(5, $laudo_id);
        $data['ValvulaAortica'] = $this->eco_m->impressaolaudoresposta(6, $laudo_id);
        $data['AtrioEsquerdo'] = $this->eco_m->impressaolaudoresposta(7, $laudo_id);
        $data['Valvulamitral'] = $this->eco_m->impressaolaudoresposta(8, $laudo_id);
        $data['Ventriculoireito'] = $this->eco_m->impressaolaudoresposta(9, $laudo_id);
        $data['AtrioDireito'] = $this->eco_m->impressaolaudoresposta(10, $laudo_id);
        $data['ValvulaTricuspide'] = $this->eco_m->impressaolaudoresposta(11, $laudo_id);
        $data['Valvulapulmonar'] = $this->eco_m->impressaolaudoresposta(12, $laudo_id);
        $data['Pericardio'] = $this->eco_m->impressaolaudoresposta(13, $laudo_id);
        $data['EstudoProteses'] = $this->eco_m->impressaolaudoresposta(14, $laudo_id);
        $data['AnaliseFluxoDoppler'] = $this->eco_m->impressaolaudoresposta(15, $laudo_id);
        $data['AnaliseMapeamentoFluxoCores'] = $this->eco_m->impressaolaudoresposta(16, $laudo_id);
        $data['Conclusao'] = $this->eco_m->impressaolaudoresposta(17, $laudo_id);
        $data['Classificacao'] = $this->eco_m->listarClassificacaoResposta();
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/public_html/aph/arquivos/eco/$laudo_id/");
        $data['laudo_id'] = $laudo_id;
        $this->load->View('eco/impressaolaudo', $data);
    }

    function reimpressaolaudo($laudo_id)
    {

        $data['laudo'] = $this->eco_m->impressaoLaudos($laudo_id);
        $data['ObservacoesGerais'] = $this->eco_m->impressaolaudoresposta(1, $laudo_id);
        $data['VentEsquerdoDimensoesHipertrofia'] = $this->eco_m->impressaolaudoresposta(2, $laudo_id);
        $data['VentEsquerdoAnaliseSgmentar'] = $this->eco_m->impressaolaudoresposta(3, $laudo_id);
        $data['VentEsquerdoFuncoes'] = $this->eco_m->impressaolaudoresposta(4, $laudo_id);
        $data['Aorta'] = $this->eco_m->impressaolaudoresposta(5, $laudo_id);
        $data['ValvulaAortica'] = $this->eco_m->impressaolaudoresposta(6, $laudo_id);
        $data['AtrioEsquerdo'] = $this->eco_m->impressaolaudoresposta(7, $laudo_id);
        $data['Valvulamitral'] = $this->eco_m->impressaolaudoresposta(8, $laudo_id);
        $data['Ventriculoireito'] = $this->eco_m->impressaolaudoresposta(9, $laudo_id);
        $data['AtrioDireito'] = $this->eco_m->impressaolaudoresposta(10, $laudo_id);
        $data['ValvulaTricuspide'] = $this->eco_m->impressaolaudoresposta(11, $laudo_id);
        $data['Valvulapulmonar'] = $this->eco_m->impressaolaudoresposta(12, $laudo_id);
        $data['Pericardio'] = $this->eco_m->impressaolaudoresposta(13, $laudo_id);
        $data['EstudoProteses'] = $this->eco_m->impressaolaudoresposta(14, $laudo_id);
        $data['AnaliseFluxoDoppler'] = $this->eco_m->impressaolaudoresposta(15, $laudo_id);
        $data['AnaliseMapeamentoFluxoCores'] = $this->eco_m->impressaolaudoresposta(16, $laudo_id);
        $data['Conclusao'] = $this->eco_m->impressaolaudoresposta(17, $laudo_id);
        $data['Classificacao'] = $this->eco_m->listarClassificacaoResposta();
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("/home/public_html/aph/arquivos/eco/$laudo_id/");
        $data['laudo_id'] = $laudo_id;
        $this->load->View('eco/reimpressaolaudo', $data);
    }

    function novo()
    {

        $data['ObservacoesGerais'] = $this->eco_m->listarGrupoResposta(1);
        $data['VentEsquerdoDimensoesHipertrofia'] = $this->eco_m->listarGrupoResposta(2);
        $data['VentEsquerdoAnaliseSgmentar'] = $this->eco_m->listarGrupoResposta(3);
        $data['VentEsquerdoFuncoes'] = $this->eco_m->listarGrupoResposta(4);
        $data['Aorta'] = $this->eco_m->listarGrupoResposta(5);
        $data['ValvulaAortica'] = $this->eco_m->listarGrupoResposta(6);
        $data['AtrioEsquerdo'] = $this->eco_m->listarGrupoResposta(7);
        $data['Valvulamitral'] = $this->eco_m->listarGrupoResposta(8);
        $data['Ventriculoireito'] = $this->eco_m->listarGrupoResposta(9);
        $data['AtrioDireito'] = $this->eco_m->listarGrupoResposta(10);
        $data['ValvulaTricuspide'] = $this->eco_m->listarGrupoResposta(11);
        $data['Valvulapulmonar'] = $this->eco_m->listarGrupoResposta(12);
        $data['Pericardio'] = $this->eco_m->listarGrupoResposta(13);
        $data['EstudoProteses'] = $this->eco_m->listarGrupoResposta(14);
        $data['AnaliseFluxoDoppler'] = $this->eco_m->listarGrupoResposta(15);
        $data['AnaliseMapeamentoFluxoCores'] = $this->eco_m->listarGrupoResposta(16);
        $data['Conclusao'] = $this->eco_m->listarGrupoResposta(17);
        $data['Classificacao'] = $this->eco_m->listarClassificacaoResposta();

        $this->loadView('eco/eco-laudo', $data);
    }

    function pesquisar($args = array())
    {

        $this->loadView('eco/eco-lista');
    }

    function gravar()
    {
        $laudo_id = $this->eco_m->gravar();

        $this->eco_m->gravarresposta($laudo_id);
        $this->eco_m->gravarItens($laudo_id);
//        $this->load->helper('directory');
//        $arquivo_pasta = directory_map('/home/public_html/ecoimagens/');
//        foreach ($arquivo_pasta as $value) {
//            if (!is_dir("/home/public_html/aph/arquivos/eco/$laudo_id")) {
//                mkdir("/home/public_html/aph/arquivos/eco/$laudo_id");
//                $destino = "/home/public_html/aph/arquivos/eco/$laudo_id";
//                chmod($destino, 0777);
//            }
//            $origem = "/home/public_html/ecoimagens/$value";
//            $destino = "/home/public_html/aph/arquivos/eco/$laudo_id/$value";
//            copy($origem, $destino);
//        }
//        delete_files("/home/public_html/ecoimagens/");
        
        $this->impressaolaudo($laudo_id);
//
//                $data['mensagem'] = 'Ficha de notifica&ccedil;&atilde;o cadastrada com sucesso.';
//
//            $data['mensagem'] = 'Erro ao cadastrar ficha de notifica&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.';
//        $this->session->set_flashdata('message', $data['mensagem']);
//        redirect(base_url() . "eco/eco", $data);
    }

}