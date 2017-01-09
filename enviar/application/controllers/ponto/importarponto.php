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
class Importarponto extends BaseController {

    /**
     * Função para carregar as informações de pensionistas
     * @name Pontuação Médica
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Importarponto() {
        parent::Controller();
        $this->load->model('ponto/importarponto_model', 'importarponto');
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
        $this->loadView('ponto/importarponto');
    }
    
    function importarpontobatida() {
        $this->loadView('ponto/importarpontobatida');
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

        $config['upload_path'] = "/home/hamilton/projetos/aph/";
	//$config['upload_path'] = "/home/sistemaponto/sistema/aph/";
        //$config['upload_path'] = "/home/public_html/aph/upload/ponto/";
        $config['allowed_types'] = 'txt';
        $config['max_size'] = '3000';
        $config['overwrite'] = FALSE;
        
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $datas = array('upload_data' => $this->upload->data());


        }
                // inicia a importacao
        if (!isset($error)) {
            
            

            // armazena o conteudo do arquivo em um array
            $fd = fopen("/home/hamilton/projetos/aph/" . $datas["upload_data"]["file_name"], "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo
            //$fd = fopen("/home/hneto/teste/" . $datas["upload_data"]["file_name"], "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo
            //$fd = fopen("/home/public_html/aph/upload/ponto/" . $datas["upload_data"]["file_name"], "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo
            while (!feof($fd)) {
                $buffer = fgets($fd, 4096);
                $lines[] = $buffer;
            }
            fclose($fd);
            // inserir o registro para cada linha
            foreach ($lines as $line) {
                //$ref1 = substr($line, 0, 3);
                //$ref2 = substr($line, 10, 7);
//                var_dump($line);
//                die;
                $data = substr($line, 0, 10);
                $hora = substr($line, 11, 8);
                $matricula = substr($line, 20, 5);
                if (trim($line) != "") {
                        if($this->importarponto->gravarPonos($data, $hora, $matricula))
                            {$data['mensagem'] = 'Sucesso ao importar os pontos.';}
                        else
                            {$data['mensagem'] = 'Erro ao importar os pontos. Opera&ccedil;&atilde;o canceladaok.';}
                }
            }
            $mensagem = 'Sucesso ao importar os pontos.';
        } else {
            $mensagem = 'Erro ao importar os pontos. Opera&ccedil;&atilde;o canceladanao.';
        }

        if ($mensagem != null) {
            $data['mensagem'] = $this->mensagem->getMensagem($mensagem);
        }
        if (isset($error)) {
            $data['erros'] = $error;
        }


        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."ponto/importarponto",$data);
    }
    
    function importarbatida() {

        // realiza o upload do arquivo

        $config['upload_path'] = "/home/hamilton/bkphamilton/projetos/aph/batida/";
	//$config['upload_path'] = "/home/sistemaponto/sistema/aph/";
        //$config['upload_path'] = "/home/public_html/aph/upload/ponto/";
        $config['allowed_types'] = 'txt';
        $config['max_size'] = '3000';
        $config['overwrite'] = FALSE;
        
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $datas = array('upload_data' => $this->upload->data());


        }
                // inicia a importacao
        if (!isset($error)) {
            
            

            // armazena o conteudo do arquivo em um array
            $fd = fopen("/home/hamilton/bkphamilton/projetos/aph/batida/" . $datas["upload_data"]["file_name"], "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo
            //$fd = fopen("/home/hneto/teste/" . $datas["upload_data"]["file_name"], "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo
            //$fd = fopen("/home/public_html/aph/upload/ponto/" . $datas["upload_data"]["file_name"], "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo
            while (!feof($fd)) {
                $buffer = fgets($fd, 4096);
                $lines[] = $buffer;
            }
            fclose($fd);
            // inserir o registro para cada linha
            foreach ($lines as $line) {
                //$ref1 = substr($line, 0, 3);
                //$ref2 = substr($line, 10, 7);
//                var_dump($line);
//                die;
                $data = substr($line, 0, 9);
                $hora = substr($line, 9, 8);
                $matricula = substr($line, 19, 10);
                if (trim($line) != "") {
                        if($this->importarponto->gravarbatidas($data, $hora, $matricula))
                            {$data['mensagem'] = 'Sucesso ao importar os pontos.';}
                        else
                            {$data['mensagem'] = 'Erro ao importar os pontos. Opera&ccedil;&atilde;o canceladaok.';}
                }
            }
            $mensagem = 'Sucesso ao importar os pontos.';
        } else {
            $mensagem = 'Erro ao importar os pontos. Opera&ccedil;&atilde;o canceladanao.';
        }

        if ($mensagem != null) {
            $data['mensagem'] = $this->mensagem->getMensagem($mensagem);
        }
        if (isset($error)) {
            $data['erros'] = $error;
        }


        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."ponto/importarponto",$data);
    }


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
