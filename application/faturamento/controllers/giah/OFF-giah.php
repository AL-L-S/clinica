<?php

class Giah extends Controller {

    function Giah() {
        parent::Controller();
        $this->load->model('giah/giah_model', 'giah');
        $this->load->model('giah/servidor_model', 'servidor');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    function index($mensagem=null) {
        if ($mensagem != null)
        { $data['mensagem'] = $this->mensagem->getMensagem($mensagem); }
        $data['lista'] = $this->giah->listar();

            if ($this->utilitario->autorizar(6, $this->session->userdata('modulo')) == true)
            {
                $this->load->view('header', $data);
                $this->load->view('giah/gerar-giah', $data);
            } else {
                $data['mensagem'] = $this->mensagem->getMensagem('login005');
                $this->load->view('header', $data);
                $this->load->view('home');
            }
            $this->load->view('footer');
        
    }

    function carregarcompetencia() {
        if (isset($_POST['txtCompetencia'])) 
        { 
            $competencia = str_replace("/", "", $_POST['txtCompetencia']);
            $mensagem[] = null;
            
            if (!$this->testarPontuacao($competencia))
            { $mensagem[] = 'giah001'; }

            if (!$this->testarParametro($competencia))
            { $mensagem[] = 'giah002'; }

            if (count($mensagem) == 1)
            { $mensagem[] = $this->gerarGIAH($competencia);}

        }
        else
        { $mensagem[] = 'sdasdas'; }

        $msg = "";
        foreach ($mensagem as $value) {
            $msg .= " " . $this->mensagem->getMensagem($value);
        }
        $data['mensagem'] = $msg;
        
        $this->load->view('header', $data);
        $this->load->view('giah/gerar-giah', $data);
        $this->load->view('footer');
    }

    /* Métodos privados */

    private function gerarGIAH($competencia) {
        try {
            $parametro = $this->giah->calcularparametro($competencia);
            $this->calcularISM($competencia, $parametro);
            $this->calcularIST($competencia, $parametro);
            echo "ok";
            $this->calcularIPT($competencia, $parametro);
            return "giah004";
        } catch (Exception $exc) {
            return "giah005";
        }

    }
    
    private function testarPontuacao($competencia, $mensagem=null) {
        $data['lista'] = $this->giah->listargiah($competencia);
        if (count($data['lista']) == 0)
        { return false; }
        else
        {return true; }
    }
    
    private function testarParametro($competencia, $mensagem=null) {
        $data['lista'] = $this->giah->listarparametro($competencia);
        if (count($data['lista']) == 0)
        { return false; }
        else
        { return true; }
    }

    private function calcularISM($competencia, $parametro) {
//        $ssm = $this->giah->calcularSomaSuplementar($competencia, 'M');
//        $ssmd = $this->giah->calcularSomaSalarios('M');
//        $ism = (((float)$parametro - (float)$ssm) * 0.6) / (float)$ssmd; // (indice para calculo da produtividade chefia medicos
        $this->giah->gerarProdutividadeChefiaMedica($competencia);
        return true;
    }

    private function calcularIST($competencia, $parametro) { 
        $sso = $this->giah->calcularSomaSuplementar($competencia);
        $ssc = $this->giah->calcularSomaSalarios();
        $ist = (((float)$parametro - (float)$sso) * 0.4) / (float)$ssc;
        $this->giah->gerarProdutividadeDemaisCategorias($competencia, $ist);
        return true;
    }

    private function calcularIPT($competencia, $parametro) {
//        $ssm = $this->giah->calcularSomaSuplementar($competencia, 'M');
//        $smd = $this->giah->calcularSomaPontuacaoMedica($competencia);
//        $spcm = $this->giah->calcularSomaProdutividadeChefiaMedica($competencia);
//        $ipt = ((((float)$parametro - (float)$ssm) * 0.6) - (float)$spcm) / (float)$smd; // (indice para calculo da produtividade medicos
        $this->giah->gerarProdutividadeMedica($competencia);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */