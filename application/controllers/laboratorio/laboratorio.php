<?php
/**
 * Esta classe é o controller da Ficha Solicitante
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage laboratorio
 */
require_once APPPATH . 'controllers/base/BaseController.php';
class laboratorio extends BaseController {

        function laboratorio() {
            parent::Controller();
            
            $this->load->model('laboratorio/laboratorio_model', 'laboratorio_m');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
            $this->load->library('validation');
        }
    /**
     * Função
     * @name index
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param void
     */
        function index() {
            
            $this->pesquisar();
        }


        function novo () {
         $this->loadView('laboratorio/laboratorio-ficha');
        }

        function pesquisar($args = array()) {

        
        $this->loadView('laboratorio/laboratorio-lista');
        }

        function gravar() {
        $paciente_id = $this->laboratorio_m->gravar($_POST);

        if ($paciente_id != false) {

            $this->gerarArquivoND($paciente_id);

            $data['mensagem'] = 'laboratorio gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar laboratorio';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "laboratorio/laboratorio");
    }

    function carregar ($laboratorio_id) {

            $objLaboratorio = new laboratorio_model($laboratorio_id);
            $data['obj'] = $objLaboratorio;
            $this->loadView('laboratorio/laboratorio-ficha', $data);
        }

    function gerarArquivoND($paciente_id) {
        
            $lista = $this->laboratorio_m->listarpaciente($paciente_id);
            $rs = $lista["0"]->lotend;
            //$rs = $rs["lotend"];


            $cabecalholote = $this->gerarCabecalhoLoteND($lista["0"]->lotend);

            $cabecalhocliente = $this->gerarCabecalhoClienteND($lista["0"]->lotend, $lista["0"]->be,$lista["0"]->nome,
                                                               $lista["0"]->data_nascimento,$lista["0"]->sexo,
                                                               $lista["0"]->observacao,$lista["0"]->unidade,$lista["0"]->leito);
            $dadospedido = $this->gerarDadosPedidoND($lista["0"]->lotend, $lista["0"]->be);
            
            $totalcliente = $this->gerarTotalDoClienteND($lista["0"]->nome_mae,$lista["0"]->endereco,$lista["0"]->complemento,
                                                         $lista["0"]->bairro,$lista["0"]->municipio,$lista["0"]->estado);
//            var_dump($totalcliente);
//            die;
            $totallote = $this ->gerarTotalDoLoteND($lista["0"]->lotend);
            $data = date("dmY");
            $hora = date("Hi");

            //
            $lote = $this->utilitario->preencherEsquerda($lista["0"]->lotend, 4, "0");
            if (!is_dir("/home/hamilton/projetos/aph/arquivos/nd/"))
            { mkdir("/home/hamilton/projetos/aph/arquivos/nd/"); }
            $nome = "/home/hamilton/projetos/aph/arquivos/nd/" . 'ATD' . $lote . $data .  $hora . ".ATD";
            $fp = fopen($nome, "w+");
            fwrite($fp, $cabecalholote . "\n");
            fwrite($fp, $cabecalhocliente . "\n");
            fwrite($fp, $dadospedido . "\n");
            fwrite($fp, $totalcliente . "\n");
            fwrite($fp, $totallote . "\n");
            fclose($fp);

            

        }

    private function gerarCabecalhoLoteND($total_valor="") {
        
        $servico = "ATD";
        $cod_do_registro = "0";
        $cod_da_origem = "0001";
        $numero_do_lote = $this->utilitario->preencherEsquerda($total_valor, 4, "0");
        $nome_da_origem = $this->utilitario->preencherDireita("IJF", 100, " ");
        $data = date("dmY");
        $hora = date("Hi");
        $em_branco = $this->utilitario->preencherDireita("", 120, " ");
        $numero_do_registro = "000001";
        return $servico . $cod_do_registro . $cod_da_origem . $numero_do_lote . $nome_da_origem . $data
         . $hora . $em_branco . $numero_do_registro;

    }

    private function gerarCabecalhoClienteND($total_valor="", $be="", $nome="", $data_nascimento="",$sexo="",
                                             $observacao="", $unidade="", $leito="") {
        $be = trim($be);
        $nome = trim($nome);
        $data_nascimento = substr( $data_nascimento,8,2) . substr( $data_nascimento,5,2) . substr( $data_nascimento,0,4);
        if ($sexo == 1 ){
            $sexo = 'M';
        }
        if ($sexo == 2 ){
            $sexo = 'F';
        }
        $servico = "ATD";
        $cod_do_registro = "1";
        $cod_da_origem = "0001";
        $numero_do_lote  = $this->utilitario->preencherEsquerda($total_valor, 4, "0");//$total_valor
        $cod_cliente = $this->utilitario->preencherDireita($be, 20, " ");//be
        $nome_do_cliente = $this->utilitario->preencherDireita("$nome", 60, " ");//nome
        $data_nascimento = $this->utilitario->preencherEsquerda($data_nascimento, 8, "0");//data_nascimento
        $sex = $this->utilitario->preencherEsquerda($sexo, 1, " ");;//sexo
        $obs_cliente = $this->utilitario->preencherDireita($observacao, 80, " ");//observacao
        $cod_hospital = "          ";//dez espaços
        $setor_hospital = $this->utilitario->preencherDireita($unidade, 40, " ");//quarenta espaços
        $leito_hospital = $this->utilitario->preencherDireita($leito, 10, " ");//leito
        $em_branco = "   ";//três espaços
        $numero_do_registro = "000002";
        return $servico . $cod_do_registro . $cod_da_origem . $numero_do_lote . $cod_cliente . $nome_do_cliente
         . $data_nascimento . $sex . $obs_cliente . $cod_hospital . $setor_hospital . $leito_hospital . $em_branco
         . $numero_do_registro;

            }

    private function gerarDadosPedidoND($total_valor="", $be="") {
        $be = trim($be);
        $nome = trim($nome);
        $data = date("dmY");
        $hora = date("Hi");
        $servico = "ATD";
        $cod_do_registro = "2";
        $cod_da_origem = "0001";
        $numero_do_lote  = $this->utilitario->preencherEsquerda($total_valor, 4, "0");//$total_valor
        $cod_cliente = $this->utilitario->preencherDireita($be, 30, " ");//be
        $data_pedido = $this->utilitario->preencherEsquerda($data, 8, "0");//data_pedido
        $hora_pedido = $this->utilitario->preencherEsquerda($hora, 4, "0");;//sexo
        $febre = " ";//febre
        $peso = $this->utilitario->preencherEsquerda("", 6, "0");
        $altura = $this->utilitario->preencherEsquerda("", 3, "0");
        $data_menstruacao = $this->utilitario->preencherEsquerda("", 8, " ");
        $urgente = " ";//1 em branco
        $obs_pedido = $this->utilitario->preencherDireita("", 80, " ");
        $conselho_medico = $this->utilitario->preencherDireita("", 10, " ");
        $inscricao_medico = $this->utilitario->preencherDireita("", 10, " ");
        $uf_medico = $this->utilitario->preencherDireita("", 2, " ");
        $nome_medico = $this->utilitario->preencherDireita("", 50, " ");
        $em_branco = $this->utilitario->preencherDireita("", 19, " ");//19 em branco
        $numero_do_registro = "000003";
        return $servico . $cod_do_registro . $cod_da_origem . $numero_do_lote . $cod_cliente . $data_pedido
         . $hora_pedido . $febre . $peso . $altura . $data_menstruacao . $urgente . $obs_pedido . $conselho_medico
         . $inscricao_medico . $uf_medico . $nome_medico . $em_branco . $numero_do_registro;

            }

    private function gerarTotalDoClienteND($nome_mae="",$endereco="",$complemento="",$bairro="",
                                                    $municipio="",$estado="") {
        $nome_mae = trim($nome_mae);
        $endereco = trim($endereco);
        $complemento = trim($complemento);
        $bairro = trim($bairro);
        $municipio = trim($municipio);
        $estado = trim($estado);

        $servico = "ATD";
        $cod_do_registro = "3"; //Identificação de registro "Total Cliente"
        $cod_da_origem = "0001";//quatro espaços - Cód. Unidade Integrada De 0000 a 0099.
        $numero_do_lote = "    ";//quatro espaços
        $nome_da_mae_cliente = $this->utilitario->preencherDireita($nome_mae, 50, " ");//
        $endereco_cliente = $this->utilitario->preencherDireita("1", 60, " ");
        $complemento_end = $this->utilitario->preencherDireita($complemento, 30, " ");
        $bairro_cliente = $this->utilitario->preencherDireita($bairro, 40, " ");
        $cidade = $this->utilitario->preencherDireita($municipio, 30, " ");
        $estado = $this->utilitario->preencherDireita($estado, 2, " ");
        $cep = "          ";//dez espaços
        $quant_pedidos = "00001";//cinco espaços
        $em_branco = "     ";
        $num_do_registro = "000004";//seis espaços
        return $servico . $cod_do_registro . $cod_da_origem . $numero_do_lote . $nome_da_mae_cliente . $endereco_cliente . $complemento_end . $bairro_cliente . $cidade . $estado . $cep
         . $quant_pedidos . $em_branco . $num_do_registro;

    }

    private function gerarTotalDoLoteND($total_valor="") {

        $servico = "ATD";//Identificação do serviço(valor fixo ATD)
        $cod_do_registro = "4";//Identificação registro total do pedido(valro fixo de 4)
        $cod_da_origem = "0001";//De 0000 a 0099.
        $numero_do_lote = $this->utilitario->preencherEsquerda($total_valor, 4, "0");//Acrescentar +1 a cada envio ou arquivo gerado (numeração crescente)
        $quant_clientes = "00001";//Quantidade de clientes (registros "ATD1") do respectivo lote.
        $em_branco = $this->utilitario->preencherDireita("", 227, " ");//em branco
        $num_do_registro = "000005";//Cada linha = 1 (um) registro
        return $servico . $cod_do_registro . $cod_da_origem . $numero_do_lote . $quant_clientes 
         . $em_branco . $num_do_registro;

    }

    
}
?>
