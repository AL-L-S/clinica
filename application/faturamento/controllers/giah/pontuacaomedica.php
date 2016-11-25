<?php
require_once APPPATH . 'controllers/base/BaseController.php';
/**
 * Esta classe é o controler de Pontuação Médica. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Pontuacaomedica extends BaseController {

    /**
     * Função para carregar as informações de pensionistas
     * @name Pontuação Médica
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Pontuacaomedica() {
        parent::Controller();
        $this->load->model('giah/giah_model', 'giah');
        $this->load->model('giah/servidor_model', 'servidor');
        $this->load->model('giah/competencia_model', 'competencia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    /**
     * Função inicial; chama a view pesquisar
     * @name index
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function index($mensagem=null) {
        $this->pesquisar();
    }

    /**
     * Função para pesquisar as informações no banco
     * @name pesquisar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function pesquisar() {
        $ano = date('Y');
        $data['lista'] = $this->giah->listar($ano);
        $data['competencia'] = $this->competencia->competenciaAtiva();
        //$this->carregarView($data);
        $this->loadView('giah/pontuacao-lista', $data);
    }

    /**
     * Função
     * @name importar
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function importar() {

        // realiza o upload do arquivo
        $competencia = $this->competencia->competenciaAtiva();
        if (!is_dir("/home/public_html/aph/upload/$competencia")) {
            mkdir("/home/public_html/aph/upload/$competencia");
        }
        $config['upload_path'] = "/home/public_html/aph/upload/" . $competencia . "/";
        $config['allowed_types'] = 'txt';
        $config['max_size'] = '100';
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $data = array('upload_data' => $this->upload->data());
        }
        echo 'ok';
        // inicia a importacao
        if (!isset($error)) {

            // armazena o conteudo do arquivo em um array
            $fd = fopen("/home/public_html/aph/upload/" . $competencia . "/procalfi.txt", "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo
            while (!feof($fd)) {
                $buffer = fgets($fd, 4096);
                $lines[] = $buffer;
            }
            fclose($fd);
            $verificador_teto[] = 0;
            // inserir o registro para cada linha
            foreach ($lines as $line) {
                //$ref1 = substr($line, 0, 3);
                //$ref2 = substr($line, 10, 7);
                $crm = substr($line, 4, 6);
                if (trim($line) != "") {
                    $pontos = substr($line, 17);
                    $teto_id = $this->servidor->getServidorID($crm, $verificador_teto);
                    $verificador_teto[] = $teto_id;
                    if (isset($teto_id)) {
                        if($this->giah->gravarPontuacao($competencia, $teto_id, $pontos))
                            {$data['mensagem'] = 'Sucesso ao importar a pontua&ccedil;&atilde;o m&eacute;dica.';}
                        else
                            {$data['mensagem'] = 'Erro ao importar a pontua&ccedil;&atilde;o m&eacute;dica. Opera&ccedil;&atilde;o canceladaok.';}
                    } else {
                        $naoimportado[] = $crm;
                    }
                }
            }
            $mensagem = 'Sucesso ao importar a pontua&ccedil;&atilde;o m&eacute;dica.';
        } else {
            $mensagem = 'Erro ao importar a pontua&ccedil;&atilde;o m&eacute;dica. Opera&ccedil;&atilde;o canceladanao.';
        }

        if ($mensagem != null) {
            $data['mensagem'] = $this->mensagem->getMensagem($mensagem);
        }
        if (isset($naoimportado)) {
            $crmnaoimportado = null;
            $data['mensagem'] = null;
            foreach ($naoimportado as $crm) {
                    $crmnaoimportado = $crmnaoimportado . $crm . " - ";
                }
            $data['mensagem'] = "CRM n&atilde;o importados s&atilde;o: " . $crmnaoimportado;
        }
        if (isset($error)) {
            $data['erros'] = $error;
        }

        $ano = date('Y');
        $data['lista'] = $this->giah->listar($ano);
        $data['competencia'] = $this->competencia->competenciaAtiva();
//        $this->carregarView($data);

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/pontuacaomedica",$data);
    }

    /**
     * Função excluir uma competencia
     * @name excluir
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param $competencia: informa a competencia ativa
     */
    function excluir($competencia) {
        if ($this->giah->excluir($competencia)) {
            $data['mensagem'] = 'Sucesso ao excluir a pontua&ccedil;&atilde;o m&eacute;dica.';
        } else {
            $data['mensagem'] = 'Erro ao excluir a pontua&ccedil;&atilde;o m&eacute;dica. Opera&ccedil;&atilde;o cancelada.';
        }
//        $this->pesquisar($data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."giah/pontuacaomedica",$data);
    }

    /**
     * Função para chamar a view
     * @name carregarView
     * @author Equipe de desenvolvimento APH
     * @access private
     * @return void
     * @param $data, $view
     */
    private function carregarView($data=null, $view=null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }
        if ($this->utilitario->autorizar(13, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if (!isset($view)) {
                $this->load->view('giah/pontuacao-lista', $data);
            } else {
                $this->load->view($view, $data);
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