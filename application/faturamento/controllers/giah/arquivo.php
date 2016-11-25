<?php

/**
 * Esta classe é o controler de Arquivo. Responsável por chamar as funções e views, efetuando as chamadas de models.
 * Este arquivo é chamado em pontuação média, para fazer a importação de arquivo texto.
 * @name Arquivo
 * * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Arquivo extends Controller {

    /**
     * Função
     * @name Arquivo
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
    function Arquivo() {
        parent::Controller();
//            $this->load->model('login_model', 'login');
        $this->load->model('giah/provento_model', 'provento');
        $this->load->library('utilitario');
    }

    /**
     * Função index. Apenas para implementação no framework, pois este controller não possui view
     * @name gerarCapaLoteSAM
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void.
     */
    function index() {
        
    }

    /**
     * Função para gerar arquivo de texto.
     * @name gerarArquivoSAM
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param integer $competencia com a informação do KEY do competencia.
     */
    function gerarArquivoSAM($competencia) {

        $rs = $this->provento->gerarArquivoSAM($competencia);
        $total_valor = (float) 0;
        $total_refer = (float) 0;
        $total_regis = (int) 0;
        foreach ($rs as $item) {
            $total_valor += (float) $item->valor_verba;
            $total_refer += (float) $item->valor_referencia;
            $total_regis++;
            $lancamento[] = $this->gerarLancamentoSAM($item->matricula,
                            $item->competencia, $item->data_base,
                            $codigo_verba = 067,
                            str_replace(".", "", $item->valor_verba),
                            $valor_referencia = '',
                            $codigo_calculo = 65,
                            $parcelas = 01);
        }
        $capalote = $this->gerarCapaLoteSAM(str_replace(".", "", $total_valor),
                        str_replace(".", "", $total_refer));
        $fim = $this->gerarFimSAM($total_regis);

        if (!is_dir("/home/hamilton/Projetos/aph/arquivos/sam/$competencia")) {
            mkdir("/home/hamilton/Projetos/aph/arquivos/sam/$competencia");
        }
        $nome = "/home/hamilton/Projetos/aph/arquivos/sam/" . $competencia . "/SAM" . $competencia . ".txt";
        $fp = fopen($nome, "w+");
        fwrite($fp, $capalote . "\n");
        foreach ($lancamento as $value) {
            fwrite($fp, $value . "\n");
        }
        fwrite($fp, $fim . "\n");
        fclose($fp);
    }
    /**
    * Função para gerar arquivo para o Banco do Brasil.
    * @name gerarArquivoBB
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param integer $competencia com a informação do KEY do competencia.
    */
    
    function gerarArquivoBB($competencia) {

        $rs = $this->provento->gerarArquivoBBServidor($competencia);
        $total_regis = (int) 0;
        foreach ($rs as $item) {
            $total_regis++;
            $lancamento[] = $this->gerarRegistroDetalheBB($total_regis, $item->agencia,
                            $item->agencia_dv,
                            $item->conta,
                            $item->conta_dv,
                            $item->nome,
                            $data = str_replace("/", "", date("d/m/Y")), //informa data atual
                            number_format($item->valor, 2, ".", ""));
        }

        $rp = $this->provento->gerarArquivoBBPensionista($competencia);
        foreach ($rp as $item) {
            $total_regis++;
            $lancamento[] = $this->gerarRegistroDetalheBB($total_regis, $item->agencia,
                            $item->agencia_dv, $item->conta,
                            $item->conta_dv,
                            $item->nome,
                            $data = str_replace("/", "", date("d/m/Y")), //informa data atual
                            number_format($item->valor, 2, ".", ""));
        }
        $capaarquivo = $this->gerarCapaArquivoBB();
        $capalote = $this->gerarCapaLoteBB();
        $fim = $this->gerarFimBB($total_regis);
        if (!is_dir("/home/hamilton/Projetos/aph/arquivos/bb/$competencia")) {
            mkdir("/home/hamilton/Projetos/aph/arquivos/bb/$competencia");
        }
        $nome = "/home/hamilton/Projetos/aph/arquivos/bb/" . $competencia . "/BB" . $competencia . ".txt";
        $fp = fopen($nome, "w+");
        fwrite($fp, $capaarquivo . "\n");
        fwrite($fp, $capalote . "\n");
        foreach ($lancamento as $value) {
            fwrite($fp, $value . "\n");
        }
        fwrite($fp, $fim . "\n");
        fclose($fp);
    }

    /* Métodos privados */

    /**
    * Função para gerar Lotes de arquivo da Sam.
    * @name gerarCapaLoteSAM
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return string lote
    * @param string $total_valor e string $total_referencia.
    */

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
    
    /**
    * Função para gerar o fim do arquivo de Lote da Sam.
    * @name gerarFimSAM
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return string lançamento
    * @param string $matricula com a matricula do servidor, int $competencia com o ID da competencia, string $data_base com a database do servidor, string $codigo_verba com o código da verba, string $valor_verba com o valor da verba, string $valor_referencia coma informação do valor de referencia, int $codigo_calculo com o código do cáuculo a ser efetuado (padrão=65), int $parcelas com a quantidade de parcelas (padrão=01).
    */
    private function gerarLancamentoSAM($matricula="", $competencia="", $data_base="", $codigo_verba="", $valor_verba="", $valor_referencia="", $codigo_calculo="65", $parcelas="01") {
        $tipo_registro = "2";
        $nome_lote = $this->utilitario->preencherDireita("PRDIJF", 10, " ");
        $estabelecimento = "0010";
        $empresa = "PMF";
        $prontuario = $this->utilitario->preencherEsquerda($matricula, 10, "0");
        $data_competencia = substr($competencia, 4, 2) . substr($competencia, 0, 4);
        $data_base = substr($data_base, 4, 2) . substr($data_base, 0, 4);
        $codigo_verba = $codigo_verba;
        $valor = $this->utilitario->preencherEsquerda($valor_verba, 17, "0");
        ;
        $referencia = $this->utilitario->preencherEsquerda($valor_referencia, 11, " ");
        $calculo = $codigo_calculo;
        $numero_parcelas = $parcelas;
        $filler = $this->utilitario->preencherEsquerda("", 7, "0");
        return $tipo_registro . $nome_lote . $estabelecimento . $empresa . $prontuario
        . $data_competencia . $data_base . $codigo_verba . $valor . $referencia
        . $calculo . $numero_parcelas . $filler;
    }

    /**
    * Função para gerar o fim do arquivo de Lote da Sam.
    * @name gerarFimSAM
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return string arquivo
    * @param int $total_regisros com o total de registros do arquivo.
    */

    private function gerarFimSAM($total_registros="") {
        $tipo_registro = "9";
        $filler01 = $this->utilitario->preencherDireita("", 74, " ");
        $total = $this->utilitario->preencherEsquerda($total_registros, 7, " ");
        return $tipo_registro . $filler01 . $total;
    }

    /**
    * Função para gerar a capa do arquivo de Lote do Banco do Brasil.
    * @name gerarCapaArquivoBB
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return String capa
    * @param string $total_valor e string $total_referencia.
    */
    private function gerarCapaArquivoBB() {

        $data = str_replace("/", "", date("d/m/Y")); //informa data atual
        $hora = str_replace(":", "", date("H:i:s")); // informa hora atual
        $codigo_banco_compensacao = "001";
        $lote_servico = "0000";
        $tipo_registro = "0";
        $febraban1 = $this->utilitario->preencherDireita("", 9, " ");
        $tipo_inscricao_empresa = "2";
        $numero_inscricao_empresa = "07835044000180";
        $codigo_convenio_banco = $this->utilitario->preencherDireita("710232", 20, " ");
        $agencia_mantenedora_conta = $this->utilitario->preencherEsquerda("008", 5, "0");
        $digito_verificador_agencia = $this->utilitario->preencherDireita("6", 1, " ");
        $numero_conta_corrente = $this->utilitario->preencherEsquerda("75241", 12, "0");
        $digito_verificador_conta = "x";
        $digito_verificador_agencia_conta = "x";
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
    
    /**
    * Função para gerar a capa do arquivo de Lote do Banco do Brasil.
    * @name gerarCapaLoteBB
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return string com as informações da capa
    * @param string $total_valor e string $total_referencia.
    */
    private function gerarCapaLoteBB() {


        $codigo_banco_compensacao = "001";
        $lote_servico = "0000";
        $tipo_registro = "1";
        $tipo_operacao = "C";
        $tipo_servico = "30";
        $forma_lancamento = "01";
        $versao_layout_arquivo = "042";
        $febraban1 = " ";
        $tipo_inscricao_empresa = "2";
        $numero_inscricao_empresa = "07835044000180";
        $codigo_convenio_banco = $this->utilitario->preencherDireita("710232", 20, " ");
        $agencia_mantenedora_conta = $this->utilitario->preencherEsquerda("008", 5, "0");
        $digito_verificador_agencia = "6";
        $numero_conta_corrente = $this->utilitario->preencherEsquerda("75241", 12, "0");
        $digito_verificador_conta = "X";
        $digito_verificador_agencia_conta = "X";
        $nome_empresa = $this->utilitario->preencherDireita("INSTITUTO DR. JOSE FROTA", 30, " ");
        $mensagem = $this->utilitario->preencherDireita("BANCO DO BRASIL", 40, " ");
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

    /**
    * Função para gerar registro de detalhe do Banco do Brasil.
    * @name gerarRegistroDetalheBB
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return string detalhes do arquivo
    * @param int $total_regis com a quantidade de registros do lote, string $agencia com número da agencia, char $agencia_dv com o dígito verificador da agencia, string $conta com o número da conta, char $conta_dv com o dígito verificador da conta, string $nome com o nome do correntista, sctring $data com a data da transação, string $valor com o valor da transação
    */
    private function gerarRegistroDetalheBB($total_regis="", $agencia="", $agencia_dv="", $conta="", $conta_dv="", $nome="", $data="", $valor="") {


        $codigo_banco_compensacao = "001";
        $lote_servico = $this->utilitario->preencherEsquerda("0000", 4, "0");
        $tipo_registro = "3";
        $numero_registro_lote = $this->utilitario->preencherEsquerda("$total_regis", 5, "0");
        $codigo_segmento = "A";
        $tipo_movimento = "0";
        $codigo_instrucao_movimento = "00";
        $codgico_camara_centralizadora = "033";
        $codigo_banco_favorecido = "001";
        $agencia_mantenedora_conta = $this->utilitario->preencherEsquerda("$agencia", 5, "0");
        $digito_verificador_agencia = $this->utilitario->preencherDireita("$agencia_dv", 1, " ");
        $numero_conta_corrente = $this->utilitario->preencherEsquerda("$conta", 12, "0");
        $digito_verificador_conta = $this->utilitario->preencherDireita("$conta_dv", 1, " ");
        $digito_verificador_agencia_conta = $this->utilitario->preencherDireita("$conta_dv", 1, " ");
        $nome_favorecido = $this->utilitario->preencherDireita("$nome", 30, " ");
        $numero_documento_empresa = $this->utilitario->preencherDireita("", 20, " ");
        $data_pagamento = $this->utilitario->preencherEsquerda("$data", 8, "0");
        $tipo_moeda = $this->utilitario->preencherDireita("BRL", 3, " ");
        $quantidade_moeda = $this->utilitario->preencherEsquerda("", 15, "0");
        $valor_pagamento = $this->utilitario->preencherEsquerda("$valor", 15, "0");
        $numero_documento_banco = $this->utilitario->preencherDireita("", 20, " ");
        $data_efetivacao_pagamento = $this->utilitario->preencherEsquerda("", 8, "0");
        $valor_efetivacao_pagamento = $this->utilitario->preencherEsquerda("", 15, "0");
        $informacao2 = $this->utilitario->preencherEsquerda("", 40, "0");
        $qtipo_servico = $this->utilitario->preencherEsquerda("", 2, "0");
        $finalidade_ted = $this->utilitario->preencherEsquerda("", 5, "0");
        $finalidade_pagamento = $this->utilitario->preencherEsquerda("", 2, "0");
        $febraban1 = $this->utilitario->preencherEsquerda("", 3, "0");
        $aviso_favorecido = $this->utilitario->preencherDireita("", 1, " ");
        $codigo_ocorrencia_retorno = $this->utilitario->preencherEsquerda("", 10, "0");

        return $codigo_banco_compensacao . $lote_servico . $tipo_registro . $numero_registro_lote .
        $codigo_segmento . $tipo_movimento . $codigo_instrucao_movimento . $codgico_camara_centralizadora .
        $codigo_banco_favorecido . $agencia_mantenedora_conta . $digito_verificador_agencia . $numero_conta_corrente .
        $digito_verificador_conta . $digito_verificador_agencia_conta . $nome_favorecido . $numero_documento_empresa .
        $data_pagamento . $tipo_moeda . $quantidade_moeda . $valor_pagamento . $numero_documento_banco . $data_efetivacao_pagamento .
        $valor_efetivacao_pagamento . $informacao2 . $qtipo_servico . $finalidade_ted . $finalidade_pagamento . $febraban1 .
        $aviso_favorecido . $codigo_ocorrencia_retorno;
    }
    /**
    * Função para gerar fim de registro de lote do Banco do Brasil.
    * @name gerarRegistroDetalheBB
    * @author Equipe de desenvolvimento APH
    * @access private
    * @return string fim do arquivo
    * @param string $total_regis com a quantidade de registros no lote.
    */
    private function gerarFimBB($total_regis="") {

        $codigo_banco_compensacao = "001";
        $lote_servico = $this->utilitario->preencherEsquerda("9999", 4, "0");
        $tipo_registro = "9";
        $febraban1 = $this->utilitario->preencherDireita("1", 9, " ");
        $qtde_lote = $this->utilitario->preencherEsquerda("1", 6, "0");
        $qtde_registros = $this->utilitario->preencherEsquerda("$total_regis", 6, "0");
        $qtde_contas_concil = $this->utilitario->preencherEsquerda("1", 6, "0");
        $febraban2 = $this->utilitario->preencherDireita("", 205, " ");

        return $codigo_banco_compensacao . $lote_servico . $tipo_registro . $febraban1 . $qtde_lote . $qtde_registros .
        $qtde_contas_concil . $febraban2;
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */