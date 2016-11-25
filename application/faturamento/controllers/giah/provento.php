<?php
/**
* Esta classe é o controler de Proventos. Responsável por chamar as funções e views, efetuando as chamadas de models
* @author Equipe de desenvolvimento APH
* @version 1.0
* @copyright Prefeitura de Fortaleza
* @access public
* @package Model
* @subpackage GIAH
*/

class Provento extends Controller {

    function Provento() {
        parent::Controller();
        $this->load->model('giah/provento_model', 'provento_m');
        $this->load->model('giah/giah_model', 'giah');
        $this->load->model('giah/servidor_model', 'servidor');
        $this->load->model('giah/competencia_model', 'competencia');
        $this->load->helper('download');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    function index() {
        $this->listarProventosDoAno();
    }

    function sam($competencia) {


        $dados = file_get_contents( "/home/public_html/aph/arquivos/sam/SAM". $competencia. ".txt"); // Lê o conteúdo do arquivo


        $nome = 'SAM'. $competencia . '.txt';

        force_download($nome, $dados);

    }

    function bb($competencia) {


        $dados = file_get_contents( "/home/public_html/aph/arquivos/bb/BB". $competencia. ".txt"); // Lê o conteúdo do arquivo

        $nome = 'BB'. $competencia . '.txt';

        force_download($nome, $dados);

    }

    function listarProventosDoAno(){
        $ano = date('Y');
        $data['lista'] = $this->provento_m->listarProventosDoAno($ano);
        $data['competencia'] = $this->competencia->competenciaAtiva();
        $this->carregarView($data);
    }

    function gerarProventos() {
        $competencia = $this->competencia->competenciaAtiva();

       if ($this->testarPontuacao($competencia))
            {  

            if ($this->testarParametro($competencia))
            {  
            
                if (!$this->GIAHGerada($competencia)) {

                    if ($this->gerarGIAH($competencia)) {
                        if (!$this->proventoGerado($competencia)) {
                            $this->giah->gerarGIAHunificada($competencia);
                            $this->provento_m->gerarProvento($competencia);
                            $this->provento_m->gerarProventoincentivomedico($competencia);
                            $this->gerarArquivoSAM($competencia);
                            $this->gerarArquivoBB($competencia);
                            
                            $data['mensagem'] = 'Provento gerado com sucesso.';
                        } else {
                            $data['mensagem'] = 'Provento ja exite.';
                        }
                     } else {

                        $data['mensagem'] = 'Erro ao gerar Giah.';
                        }
                    } else {
                    $data['mensagem'] = 'Giah ja existe.';
                    }
                }else{
                    $data['mensagem'] = 'Parametros n&atilde;o carregados.';
                }
        }else{
            $data['mensagem'] = 'Pontua&ccedil;&atilde;o n&atilde;o carregada.';
        
        }
        
        $ano = date('Y');
        $data['lista'] = $this->provento_m->listarProventosDoAno($ano);
        $data['competencia'] = $competencia;
//        $this->carregarView($data);
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url()."giah/provento",$data);
    }

    /* Métodos privados */
    private function GIAHGerada($competencia) {
        $total_giah = $this->provento_m->totalGIAHGerada($competencia);
        

        if ((count($total_giah)) > 0)
        {
            return true;}
        else
        {
            return false; }
    }

    private function proventoGerado($competencia) {
        $total = $this->provento_m->totalProventoGerado($competencia);
        if ((count($total)) > 0)
        {
            return true; }
        else
        {return false; }
    }

    private function gerarGIAH($competencia) {

        try {
            //if ($this->giah->excluirGIAHErrada($competencia)){
                
                // Gera produtividade médica
                $this->giah->gerarProdutividadeMedica($competencia);

                // Gera produtividade chefia médica
                $this->giah->gerarProdutividadeChefiaMedica($competencia);
                $y = $this->giah->calcularparametro($competencia);
                $sso = $this->giah->calcularSomaSuplementar($competencia);
                $ssc = $this->giah->calcularSomaSalariosDemaisCategorias();
                $ist = (((float)$y * 0.4)-(float)$sso)  / (float)$ssc;

//                var_dump(((float)$y * 0.4));
//                var_dump((float)$sso);
//                var_dump((float)$ssc);
//                var_dump((float)$ist);
//                die ();
                
                // Gera produtividade demais categorias
                $this->giah->gerarProdutividadeDemaisCategorias($competencia, $ist);
                $ssm = $this->giah->calcularSomaSuplementarMedicosECH($competencia);
                
                $spm = $this->giah->SomaProdutividadeMedicosECH($competencia);
                $suplementar = $this->giah->selecionarsuplementar($competencia);
                foreach ($suplementar as $value) {
                    $valor = $value->valor;
                    $servidor_id = $value->teto_id;
                    $this->giah->aplicarsuplementar($competencia, $valor, $servidor_id);
                }
                

                $ipm = (((1*$y)  * 0.6)-(1*$ssm)) / (1*$spm);

                // Corrigir Produtividade Medica e Chefia Medica
                $z = ((((float)$y)  * 0.6)-((float)$ssm));
                if ( $z == ((float)$spm))
                    {return true;
                    }else{
                    $this->giah->CorrigirProdutividadeMedicosECH($competencia, $ipm);
                    return true;}
                return true;
//           // } else {
//                return false;
//           // }

        } catch (Exception $exc) {
            return false;
        }



        
    }

    private function  carregarView($data=null, $view=null) {
        if (!isset ($data)) { $data['mensagem'] = ''; }

        
        if ($this->utilitario->autorizar(7, $this->session->userdata('modulo')) == true)
        {
            $this->load->view('header', $data);
            if (!isset ($view))
            { $this->load->view('giah/provento-lista', $data); }
            else
            { $this->load->view($view, $data); }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

    private function testarPontuacao($competencia, $mensagem=null) {

        $data['lista'] = $this->giah->listar($competencia);

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

    function gerarArquivoSAM($competencia) {

            $rs = $this->provento_m->gerarArquivoSAM($competencia);
            $total_valor = (float)0;
            $total_refer = (float)0;
            $total_regis = (int)0;
            foreach ($rs as $item) {
                $total_valor += (float)$item->valor_verba;
                $total_refer = "";
                $total_regis++;
                $lancamento[] = $this->gerarLancamentoSAM($item->matricula,
                                        $item->competencia, $item->data_base,
                                        $codigo_verba = 067,
                                        str_replace(".", "", $item->valor_verba),
                                        $valor_referencia="",
                                        $codigo_calculo= 65,
                                        $parcelas= 01);
            }
            $capalote = $this->gerarCapaLoteSAM(str_replace(".", "", $total_valor),
                                             str_replace(".", "", $total_refer));
            $fim = $this->gerarFimSAM($total_regis);

            if (!is_dir("/home/public_html/aph/arquivos/sam/"))
            { mkdir("/home/public_html/aph/arquivos/sam/"); }
            $nome = "/home/public_html/aph/arquivos/sam/SAM". $competencia . ".txt";
            $fp = fopen($nome, "w+");
            fwrite($fp, $capalote . "\n");
            foreach ($lancamento as $value) {
                fwrite($fp, $value . "\n");
            }
            fwrite($fp, $fim . "\n");
            fclose($fp);
            
        $ano = date('Y');
        $data['lista'] = $this->provento_m->listarProventosDoAno($ano);
        $this->listarProventosDoAno();
            
        }

    function gerarArquivoBB($competencia) {
        $rs = $this->provento_m->gerarArquivoBBServidor($competencia);
        $total_regis = (int)1;
        $total_valor = (int)0;
        foreach ($rs as $item) {
            
            $total_valor += number_format($item->valor, 2,"", "");
            $lancamento[] = $this->gerarRegistroDetalheBBsegmentoA($total_regis, $item->agencia,
                                    $item->agencia_dv,
                                    $item->conta,
                                    $item->conta_dv,
                                    $item->nome,
                                    $data=  str_replace("/", "", date("d/m/Y")),//informa data atual
                                    number_format($item->valor, 2, "", ""));
            $total_regis++;
            $lancamento[] = $this->gerarRegistroDetalheBBsegmentoB($total_regis, $item->cpf, number_format($item->valor, 2, "", ""));
            $total_regis++;
        }
        $rp = $this->provento_m->gerarArquivoBBPensionista($competencia);
        foreach ($rp as $item) {
            
            $total_valor += number_format($item->valor, 2,"", "");
            $lancamento[] = $this->gerarRegistroDetalheBBsegmentoA($total_regis, $item->agencia,
                                    $item->agencia_dv, $item->conta,
                                    $item->conta_dv,
                                    $item->nome,
                                    $data=  str_replace("/", "", date("d/m/Y")),//informa data atual
                                    number_format($item->valor, 2, "", ""));
            $total_regis++;
            $lancamento[] = $this->gerarRegistroDetalheBBsegmentoB($total_regis, $item->cpf, number_format($item->valor, 2, "", ""));
            $total_regis++;
        }
        $capaarquivo = $this->gerarCapaArquivoBB();
        $capalote = $this->gerarCapaLoteBB();
        $total_regis = $total_regis + (int)1;
        $fim_lote = $this->gerarFimLoteBB($total_regis, $total_valor);
        $total_regis = $total_regis + (int)2;
        $fim = $this->gerarFimBB($total_regis);
        
        if (!is_dir("/home/public_html/aph/arquivos/bb/".$competencia."/"))
        { mkdir("/home/public_html/aph/arquivos/bb/".$competencia."/"); }
        $nome = "/home/public_html/aph/arquivos/bb/BB". $competencia. ".txt";
        $fp = fopen($nome, "w+");
        fwrite($fp, $capaarquivo . "\n");
        fwrite($fp, $capalote . "\n");
        foreach ($lancamento as $value) {
            fwrite($fp, $value . "\n");
        }
        fwrite($fp, $fim_lote . "\n");
        fwrite($fp, $fim . "\n");
        fclose($fp);
        
        redirect(base_url()."giah/provento/gerarArquivoSAM/$competencia","refresh");
        //$this->gerarArquivoSAM($competencia);
    }

    /* Métodos privados */

    private function gerarCapaLoteSAM($total_valor="", $total_referencia="") {
        $tipo_registro = "1";
        $nome_lote = $this->utilitario->preencherDireita("PRDIJF", 10, " ");
        $filler01 = $this->utilitario->preencherDireita("", 4, " ");
        $empresa = "PMF";
        $filler02 = $this->utilitario->preencherDireita("", 25, " ");
        $valor = $this->utilitario->preencherEsquerda($total_valor, 17, " ");
        if ($total_referencia == "0") {
            $referencia = $this->utilitario->preencherEsquerda("", 11, " ");
        } else {
            $referencia = $this->utilitario->preencherEsquerda($total_referencia, 11, " ");
        }
        $filler03 = $this->utilitario->preencherDireita("", 4, " ");
        $filler04 = $this->utilitario->preencherDireita("", 7, "0");

        return $tipo_registro . $nome_lote . $filler01 . $empresa . $filler02
            . $valor . $referencia . $filler03 . $filler04;
    }

    private function gerarLancamentoSAM($matricula="", $competencia="", $data_base="",
                $codigo_verba="", $valor_verba="", $valor_referencia="",
                $codigo_calculo="65", $parcelas="01") {
        $tipo_registro = "2";
        $nome_lote = $this->utilitario->preencherDireita("PRDIJF", 10, " ");
        $estabelecimento = "0010";
        $empresa = "PMF";
        $prontuario = $this->utilitario->preencherEsquerda($matricula, 10, "0");
        $data_competencia = substr($competencia, 4, 2) . substr($competencia, 0, 4);
        $data_base = substr($data_base, 4, 2) . substr($data_base, 0, 4);
        $codigo_verba = $codigo_verba;
        $valor= $this->utilitario->preencherEsquerda($valor_verba, 17, "0");;
        $referencia = $this->utilitario->preencherEsquerda($valor_referencia, 11, " ");
        $calculo = $codigo_calculo;
        $numero_parcelas = $parcelas;
        $filler = $this->utilitario->preencherEsquerda("", 7, "0");
        return $tipo_registro . $nome_lote . $estabelecimento . $empresa . $prontuario
            . $data_competencia . $data_base . $codigo_verba . $valor . $referencia
            . $calculo . $numero_parcelas . $filler;
    }

    private function gerarFimSAM($total_registros="") {
        $tipo_registro = "9";
        $filler01 = $this->utilitario->preencherDireita("", 74, " ");
        $total = $this->utilitario->preencherEsquerda($total_registros, 7, " ");
        return $tipo_registro . $filler01 . $total;
    }

    /* Métodos privados */

    private function gerarCapaArquivoBB() {

        $data=  str_replace("/", "", date("d/m/Y"));//informa data atual
        $hora= str_replace(":", "", date("H:i:s"));// informa hora atual
        $codigo_banco_compensacao = "001";
        $lote_servico = "0000";
        $tipo_registro = "0";
        $febraban1 = $this->utilitario->preencherDireita("", 9, " ");
        $tipo_inscricao_empresa = "2";
        $numero_inscricao_empresa = "07835044000180";
        $codigo_convenio_banco = $this->utilitario->preencherDireita("0007102320126", 20, " ");
        $agencia_mantenedora_conta = $this->utilitario->preencherEsquerda("008", 5, "0");
        $digito_verificador_agencia = $this->utilitario->preencherDireita("6", 1, " ");
        $numero_conta_corrente = $this->utilitario->preencherEsquerda("75241", 12, "0");
        $digito_verificador_conta = "X";
        $digito_verificador_agencia_conta = " ";
        $nome_empresa = $this->utilitario->preencherDireita("INSTITUTO DR. JOSE FROTA", 30, " ");
        $nome_banco = $this->utilitario->preencherDireita("BANCO DO BRASIL", 30, " ");
        $febraban2 = $this->utilitario->preencherDireita("", 10, " ");
        $febraban3 = "1";
        $data_geracao_arquivo = $this->utilitario->preencherEsquerda("$data", 8, "0");
        $hora_geracao_arquivo = $this->utilitario->preencherEsquerda("$hora", 6, "0");
        $numero_sequencial_arquivo = $this->utilitario->preencherEsquerda("1", 6, "0");
        $versao_layout_arquivo = "082";
        $densidade_gravacao_arquivo = $this->utilitario->preencherEsquerda("1600", 5, "0");
        $uso_banco = $this->utilitario->preencherDireita("", 20, " ");
        $uso_empresa = $this->utilitario->preencherDireita("", 20, " ");
        $febraban4 = $this->utilitario->preencherDireita("", 29, " ");

        return $codigo_banco_compensacao . $lote_servico . $tipo_registro . $febraban1 . $tipo_inscricao_empresa . $numero_inscricao_empresa
         . $codigo_convenio_banco . $agencia_mantenedora_conta . $digito_verificador_agencia . $numero_conta_corrente . $digito_verificador_conta .
        $digito_verificador_agencia_conta . $nome_empresa . $nome_banco . $febraban2 . $febraban3 . $data_geracao_arquivo . $hora_geracao_arquivo .
        $numero_sequencial_arquivo . $versao_layout_arquivo . $densidade_gravacao_arquivo . $uso_banco . $uso_empresa . $febraban4;

    }

    private function gerarCapaLoteBB(){


        $codigo_banco_compensacao = "001";
        $lote_servico = "0001";
        $tipo_registro = "1";
        $tipo_operacao = "C";
        $tipo_servico = "30";
        $forma_lancamento = "01";
        $versao_layout_arquivo = "042";
        $febraban1 = " ";
        $tipo_inscricao_empresa = "2";
        $numero_inscricao_empresa = "07835044000180";
        $codigo_convenio_banco = $this->utilitario->preencherDireita("0007102320126", 20, " ");
        $agencia_mantenedora_conta = $this->utilitario->preencherEsquerda("008", 5, "0");
        $digito_verificador_agencia = "6";
        $numero_conta_corrente = $this->utilitario->preencherEsquerda("75241", 12, "0");
        $digito_verificador_conta = "X";
        $digito_verificador_agencia_conta = " ";
        $nome_empresa = $this->utilitario->preencherDireita("INSTITUTO DR. JOSE FROTA", 30, " ");
        $mensagem = $this->utilitario->preencherDireita("", 40, " ");
        $logradoro = $this->utilitario->preencherDireita("Rua Barao do Rio Branco", 30, " ");
        $numero = $this->utilitario->preencherEsquerda("1816", 5, "0");
        $complemento = $this->utilitario->preencherDireita("Centro", 15, " ");
        $cidade = $this->utilitario->preencherDireita("FORTALEZA", 20, " ");
        $cep = "60025";
        $complemento_cep = "061";
        $sigla_estado = "CE";
        $febraban2 = $this->utilitario->preencherDireita("", 8, " ");
        $codigo_ocorrencia = $this->utilitario->preencherDireita("", 10, " ");

        return $codigo_banco_compensacao . $lote_servico . $tipo_registro . $tipo_operacao . $tipo_servico . $forma_lancamento .
        $versao_layout_arquivo . $febraban1 . $tipo_inscricao_empresa . $numero_inscricao_empresa . $codigo_convenio_banco .
        $agencia_mantenedora_conta . $digito_verificador_agencia . $numero_conta_corrente . $digito_verificador_conta .
        $digito_verificador_agencia_conta . $nome_empresa . $mensagem . $logradoro . $numero . $complemento . $cidade . $cep .
        $complemento_cep . $sigla_estado . $febraban2 . $codigo_ocorrencia;

    }

    private function gerarRegistroDetalheBBsegmentoA($total_regis="", $agencia="", $agencia_dv="", $conta="", $conta_dv="", $nome="" ,$data="" , $valor=""){


        $codigo_banco_compensacao = "001";
        $lote_servico = $this->utilitario->preencherEsquerda("0001", 4, "0");
        $tipo_registro = "3";
        $numero_registro_lote = $this->utilitario->preencherEsquerda("$total_regis", 5, "0");
        $codigo_segmento = "A";
        $tipo_movimento = "0";
        $codigo_instrucao_movimento = "00";
        $codgico_camara_centralizadora = "000";
        $codigo_banco_favorecido = "001";
        $agencia_mantenedora_conta = $this->utilitario->preencherEsquerda("$agencia", 5, "0");
        $digito_verificador_agencia = $this->utilitario->preencherDireita("$agencia_dv", 1, " ");
        $numero_conta_corrente = $this->utilitario->preencherEsquerda("$conta", 12, "0");
        $digito_verificador_conta = $this->utilitario->preencherDireita("$conta_dv", 1, " ");
        $digito_verificador_agencia_conta = $this->utilitario->preencherDireita("", 1, " ");
        $nome_favorecido = $this->utilitario->preencherDireita("$nome", 30, " ");
        $numero_documento_empresa = $this->utilitario->preencherDireita("", 20, " ");
        $data_pagamento = $this->utilitario->preencherEsquerda("$data", 8, "0");
        $tipo_moeda = $this->utilitario->preencherDireita("BRL", 3, " ");
        $quantidade_moeda = $this->utilitario->preencherEsquerda("", 15, "0");
        $valor_pagamento = $this ->utilitario->preencherEsquerda("$valor", 15, "0");
        $numero_documento_banco = $this->utilitario->preencherDireita("", 20, " ");
        $data_efetivacao_pagamento = $this->utilitario->preencherEsquerda("", 8, "0");
        $valor_efetivacao_pagamento = $this->utilitario->preencherEsquerda("", 15, "0");
        $informacao2 = $this->utilitario->preencherDireita("", 40, " ");
        $qtipo_servico = $this->utilitario->preencherDireita("", 2, " ");
        $finalidade_ted = $this->utilitario->preencherDireita("", 5, " ");
        $finalidade_pagamento= $this->utilitario->preencherDireita("", 2, " ");
        $febraban1= $this->utilitario->preencherDireita("", 3, " ");
        $aviso_favorecido = $this->utilitario->preencherEsquerda("", 1, "0");
        $codigo_ocorrencia_retorno = $this->utilitario->preencherDireita("", 10, " ");

        return $codigo_banco_compensacao . $lote_servico . $tipo_registro . $numero_registro_lote .
        $codigo_segmento . $tipo_movimento . $codigo_instrucao_movimento . $codgico_camara_centralizadora .
        $codigo_banco_favorecido . $agencia_mantenedora_conta . $digito_verificador_agencia . $numero_conta_corrente .
        $digito_verificador_conta . $digito_verificador_agencia_conta . $nome_favorecido . $numero_documento_empresa .
        $data_pagamento . $tipo_moeda . $quantidade_moeda . $valor_pagamento . $numero_documento_banco . $data_efetivacao_pagamento .
        $valor_efetivacao_pagamento . $informacao2 . $qtipo_servico . $finalidade_ted . $finalidade_pagamento . $febraban1 .
        $aviso_favorecido . $codigo_ocorrencia_retorno;
    }

    private function gerarRegistroDetalheBBsegmentoB($total_regis="", $cpf="", $valor=""){


        $codigo_banco_compensacao = "001";
        $lote_servico = $this->utilitario->preencherEsquerda("0001", 4, "0");
        $tipo_registro = "3";
        $numero_registro_lote = $this->utilitario->preencherEsquerda("$total_regis", 5, "0");
        $codigo_segmento = "B";
        $febraban1 = "   ";
        $tipo_inscricao = "1";
        $numero_inscricao_favorecido = $this->utilitario->preencherEsquerda("$cpf", 14, "0");
        $endereco = $this->utilitario->preencherDireita("", 30, " ");
        $numero_local = $this->utilitario->preencherEsquerda("", 5, "0");
        $imovel = $this->utilitario->preencherDireita("", 15, " ");
        $bairro = $this->utilitario->preencherDireita("", 15, " ");
        $nome_cidade = $this->utilitario->preencherDireita("", 20, " ");
        $cep = $this->utilitario->preencherEsquerda("", 5, "0");
        $complemento_cep = $this->utilitario->preencherDireita("", 3, "0");
        $sigla_estado = "CE";
        $data_vencimento = $this->utilitario->preencherEsquerda("", 8, "0");
        $valor_documento = $this->utilitario->preencherEsquerda("", 15, "0");
        $valor_abastecimento = $this->utilitario->preencherEsquerda("", 15, "0");
        $valor_desconto = $this ->utilitario->preencherEsquerda("", 15, "0");
        $valor_mora = $this ->utilitario->preencherEsquerda("", 15, "0");
        $valor_muta = $this ->utilitario->preencherEsquerda("", 15, "0");
        $codigo_documento_favorecido = $this->utilitario->preencherDireita("", 15, " ");
        $aviso_favorecido = $this ->utilitario->preencherEsquerda("", 1, " ");
        $siape = $this ->utilitario->preencherEsquerda("", 6, " ");
        $febraban2 = $this->utilitario->preencherDireita("", 8, " ");

        return $codigo_banco_compensacao . $lote_servico . $tipo_registro . $numero_registro_lote .
        $codigo_segmento . $febraban1 . $tipo_inscricao . $numero_inscricao_favorecido . $endereco .
        $numero_local . $imovel . $bairro . $nome_cidade . $cep . $complemento_cep . $sigla_estado .
        $data_vencimento . $valor_documento . $valor_abastecimento . $valor_desconto . $valor_mora .
        $valor_muta . $codigo_documento_favorecido . $aviso_favorecido . $siape . $febraban2;
    }

    private function gerarFimLoteBB($total_regis="", $total_valor="") {

        
        $codigo_banco_compensacao = "001";
        $lote_servico = $this->utilitario->preencherEsquerda("0001", 4, "0");
        $tipo_registro = "5";
        $febraban1 = $this->utilitario->preencherDireita("", 9, " ");
        $qtde_lote = $this->utilitario->preencherEsquerda("$total_regis", 6, "0");
        $soma_valores = $this->utilitario->preencherEsquerda("$total_valor", 18, "0");
        $soma_qtde_moeda = $this->utilitario->preencherEsquerda("", 18, "0");
        $numero_aviso_debito = $this->utilitario->preencherEsquerda("", 6, " ");
        $febraban2 = $this->utilitario->preencherDireita("", 165, " ");
        $codigo_ocorrencia = $this->utilitario->preencherDireita("", 10, " ");

        return  $codigo_banco_compensacao . $lote_servico . $tipo_registro . $febraban1 . $qtde_lote . $soma_valores . $soma_qtde_moeda .
        $numero_aviso_debito . $febraban2 . $codigo_ocorrencia;
    }

    private function gerarFimBB($total_regis="") {

        $codigo_banco_compensacao = "001";
        $lote_servico = $this->utilitario->preencherEsquerda("9999", 4, "0");
        $tipo_registro = "9";
        $febraban1 = $this->utilitario->preencherDireita("", 9, " ");
        $qtde_lote = $this->utilitario->preencherEsquerda("1", 6, "0");
        $qtde_registros = $this->utilitario->preencherEsquerda("$total_regis", 6, "0");
        $qtde_contas_concil = $this->utilitario->preencherEsquerda("1", 6, "0");
        $febraban2 = $this->utilitario->preencherDireita("", 205, " ");

        return  $codigo_banco_compensacao . $lote_servico . $tipo_registro . $febraban1 . $qtde_lote . $qtde_registros .
        $qtde_contas_concil . $febraban2;
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */