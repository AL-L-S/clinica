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
class Processaponto extends BaseController {

    function Processaponto() {
        parent::Controller();
        $this->load->model('ponto/processaponto_model', 'processaponto');
        $this->load->model('ponto/Competencia_model', 'competencia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar() {

        $this->loadView('ponto/processar-tipo');

//            $this->carregarView($data);
    }

    function funcionariovariavel() {



        $funcionario = $this->processaponto->listarfuncionariosvariavel();

        foreach ($funcionario as $value) {


            $horarios = $this->processaponto->listarhorarios($value->horariostipo_id);
//            echo "<pre>";
//            var_dump($horarios);
//            echo "<pre>";
//            die;
//                $novadata = date('Y-m-d', strtotime("+15 days", strtotime($data)));
//                echo "$novadata";
//                die;
//                $novahora = date('H:i:s', strtotime("+15 minutes", strtotime($hora)));
//                echo "$novahora";
//                die;

            foreach ($horarios as $valor) {

                $ponto = $this->processaponto->listarfuncionarioponto($value->matricula);
                $novadata = date('Y-m-d', strtotime("+1 days", strtotime($valor->data)));
                $inserirentrada1 = "";
                $inserirsaida1 = "";
                $critica1 = "";
                $verificaentrada1 = 0;
                $verificasaida1 = 0;
                $horaentrada1 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada1)));
                $horaentrada1menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada1)));
                $horaentrada1mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada1)));
                $horasaida1menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida1)));
                $horasaida1mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida1)));
                $horasaida1 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida1)));
                $horasaida1errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida1)));
                $inserirentrada2 = "";
                $inserirsaida2 = "";
                $critica2 = "";
                $verificaentrada2 = 0;
                $verificasaida2 = 0;
                $horaentrada2 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada2)));
                $horaentrada2menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada2)));
                $horaentrada2mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada2)));
                $horasaida2menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida2)));
                $horasaida2mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida2)));
                $horasaida2 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida2)));
                $horasaida2errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida2)));
                $inserirentrada3 = "";
                $inserirsaida3 = "";
                $critica3 = "";
                $verificaentrada3 = 0;
                $verificasaida3 = 0;
                $horaentrada3 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada3)));
                $horaentrada3menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada3)));
                $horaentrada3mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada3)));
                $horasaida3menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida3)));
                $horasaida3mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida3)));
                $horasaida3 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida3)));
                $horasaida3errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida3)));

                foreach ($ponto as $item) {

                    $i = 0;
                    $b = 0;
                    $c = 0;
                    $data = substr($item->data_batida, 0, 10);
                    $hora = substr($item->data_batida, 11, 8);
                    //HORARIO NUMERO 1
                    if ($valor->horaentrada1 <> '00:00:00' && $valor->horasaida1 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada1 >= $hora && $horaentrada1menos2 <= $hora && $horaentrada1mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada1 = 1;
                            $inserirentrada1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida1menos2 <= $hora && $horasaida1mais2 >= $hora && $i == 0 && $verificasaida1 == 0) { //saida correta
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada1 > $valor->horasaida1) && ($horasaida1menos2 <= $hora && $horasaida1mais2 >= $hora) && $i == 0 && $verificasaida1 == 0) { //saida correta
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada1 < $hora && $horasaida1errada > $hora && $verificaentrada1 == 0) { // entrada atrasada
                            $verificaentrada1 = 1;
                            $inserirentrada1 = $hora;
                            $critica1 = $critica1 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida1 > $hora && $inserirentrada1 != $hora && $i == 0 && $verificasaida1 == 0) { // saida adiantada
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
//
//                        if (($verificaentrada1 == 0) && ($verificasaida1 == 0) && $valor->data == $data) { // falta
//                            $inserirentrada1 = "00:00:00";
//                            $inserirsaida1 = "00:00:00";
//                            $critica1 = "falta";
//                        }
                    }

                    //HORARIO NUMERO 2
                    if ($valor->horaentrada2 <> '00:00:00' && $valor->horasaida2 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada2 >= $hora && $horaentrada2menos2 <= $hora && $horaentrada2mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada2 = 1;
                            $inserirentrada2 = $hora;
                            $critica2 = $critica2 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida2menos2 <= $hora && $horasaida2mais2 >= $hora && $i == 0 && $verificasaida2 == 0) { //saida correta
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada2 > $valor->horasaida2) && ($horasaida2menos2 <= $hora && $horasaida2mais2 >= $hora) && $i == 0 && $verificasaida2 == 0) { //saida correta
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica2 = $critica2 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada2 < $hora && $horasaida2errada > $hora && $verificaentrada2 == 0 && $i == 0) { // entrada atrasada
                            $verificaentrada2 = 1;
                            $inserirentrada2 = $hora;
                            $critica2 = $critica2 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida2 > $hora && $inserirentrada2 != $hora && $i == 0 && $verificasaida2 == 0) { // saida adiantada
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica2 = $critica2 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
//
//                        if (($verificaentrada2 == 0 && $verificasaida2 == 0) && ($valor->data == $data || $novadata == $data)) { // falta
//                            $inserirentrada2 = "00:00:00";
//                            $inserirsaida2 = "00:00:00";
//                            $critica2 = "falta";
//                        }
                    }

                    //HORARIO NUMERO 3
                    if ($valor->horaentrada3 <> '00:00:00' && $valor->horasaida3 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada3 >= $hora && $horaentrada3menos2 <= $hora && $horaentrada3mais2 >= $hora && $i == 0 && $b == 0) { //entrada correta
                            $verificaentrada3 = 1;
                            $inserirentrada3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida3menos2 <= $hora && $horasaida3mais2 >= $hora && $i == 0 && $verificasaida3 == 0 && $b == 0) { //saida correta
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada3 > $valor->horasaida3) && ($horasaida3menos2 <= $hora && $horasaida3mais2 >= $hora) && $i == 0 && $verificasaida3 == 0 && $b == 0) { //saida correta
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada1 < $hora && $horasaida3errada > $hora && $verificaentrada3 == 0 && $i == 0 && $b == 0) { // entrada atrasada
                            $verificaentrada3 = 1;
                            $inserirentrada3 = $hora;
                            $critica3 = $critica3 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida3 > $hora && $inserirentrada3 != $hora && $i == 0 && $verificasaida3 == 0 && $b == 0) { // saida adiantada
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                    }
                }
                //HORARIO NUMERO 1
                if ($valor->horaentrada1 != '00:00:00' && $valor->horasaida1 != '00:00:00') {
                    if ($inserirentrada1 == "") { // entrada nao registrada
                        $inserirentrada1 = "00:00:00";
                        $critica1 = $critica1 . " entrada nao registrada";
                    }
                    if ($inserirsaida1 == "") { // saida nao registrada
                        $inserirsaida1 = "00:00:00";
                        $critica1 = $critica1 . " saida nao registrada";
                    }
                }
                //HORARIO NUMERO 2
                if ($valor->horaentrada2 != '00:00:00' && $valor->horasaida2 != '00:00:00') {
                    if ($inserirentrada2 == "") { // entrada nao registrada
                        $inserirentrada2 = "00:00:00";
                        $critica2 = $critica2 . " entrada nao registrada";
                    }
                    if ($inserirsaida2 == "") { // saida nao registrada
                        $inserirsaida2 = "00:00:00";
                        $critica2 = $critica2 . " saida nao registrada";
                    }
                }
                //HORARIO NUMERO 3
                if ($valor->horaentrada3 != '00:00:00' && $valor->horasaida3 != '00:00:00') {
                    if ($inserirentrada3 == "") { // entrada nao registrada
                        $inserirentrada3 = "00:00:00";
                        $critica3 = $critica3 . " entrada nao registrada";
                    }
                    if ($inserirsaida3 == "") { // saida nao registrada
                        $inserirsaida3 = "00:00:00";
                        $critica3 = $critica3 . " saida nao registrada";
                    }
                }
                $this->processaponto->gravarcritica($value->matricula, $valor->data, $inserirentrada1, $inserirsaida1, $critica1, $inserirentrada2, $inserirsaida2, $critica2, $inserirentrada3, $inserirsaida3, $critica3);
            }
        }
        $this->loadView('ponto/processar-tipo');
    }

    function funcionariolivres() {

        $funcionario = $this->processaponto->listarfuncionarioslivre();

//            echo "<pre>";
//        var_dump($funcionario);
//        echo "<pre>";
//        die;

        foreach ($funcionario as $value) {
            
            $data = substr($value->data_batida, 0, 10);

            $horarios = $this->processaponto->listarcritica($value->matricula, $data);

//                $novadata = date('Y-m-d', strtotime("+15 days", strtotime($data)));
//                echo "$novadata";
//                die;
//                $novahora = date('H:i:s', strtotime("+15 minutes", strtotime($hora)));
//                echo "$novahora";
//                die;
            
            foreach ($horarios as $valor) {

                    $i = 0;
                    
                        if ($valor->entrada1 == "") { //entrada correta
                            
                            $i++;
                           
                            $this->processaponto->verificadoponto($value->pontosimportados_id);
                        }
                        if ($valor->saida1 == "" && $i == 0) { //entrada correta

                            $i++;
                            
                            $this->processaponto->verificadoponto($value->pontosimportados_id);
                        }
                $this->processaponto->verificadoponto($value->pontosimportados_id);
       $this->loadView('ponto/processar-tipo');
            }
            
        }
       
    }

    function atualizarpontos() {

        $ponto = $this->processaponto->listarpontosiguais();
//            echo "<pre>";
//            var_dump($horarios);
//            echo "<pre>";
//            die;
//                $novadata = date('Y-m-d', strtotime("+15 days", strtotime($data)));
//                echo "$novadata";
//                die;
//                $novahora = date('H:i:s', strtotime("+15 minutes", strtotime($hora)));
//                echo "$novahora";
//                die;

        foreach ($ponto as $valor) {

            foreach ($ponto as $item) {
                $data = date('H:i:s', strtotime("+1 minutes", strtotime($item->data)));

                if ($valor->data == $item->data && ($valor->data == $data || $valor->matricula == $item->matricula) && $valor->pontosimportados_id != $item->pontosimportados_id) { //entrada correta
                    $this->processaponto->verificadoponto($item->pontosimportados_id);
                }
            }
            $this->loadView('ponto/processar-tipo');
        }
    }

    function funcionarioindividual() {

        $funcionario = $this->processaponto->listarfuncionarioindividual();


        foreach ($funcionario as $value) {

            $horarios = $this->processaponto->listarhorariosindividual($value->funcionario_id);
//            echo "<pre>";
//            var_dump($horarios);
//            echo "<pre>";
//            die;
//                $novadata = date('Y-m-d', strtotime("+15 days", strtotime($data)));
//                echo "$novadata";
//                die;
//                $novahora = date('H:i:s', strtotime("+15 minutes", strtotime($hora)));
//                echo "$novahora";
//                die;

            foreach ($horarios as $valor) {

                $ponto = $this->processaponto->listarfuncionarioponto($value->matricula);
                $novadata = date('Y-m-d', strtotime("+1 days", strtotime($valor->data)));
                $inserirentrada1 = "";
                $inserirsaida1 = "";
                $critica1 = "";
                $verificaentrada1 = 0;
                $verificasaida1 = 0;
                $horaentrada1 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada1)));
                $horaentrada1menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada1)));
                $horaentrada1mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada1)));
                $horasaida1menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida1)));
                $horasaida1mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida1)));
                $horasaida1 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida1)));
                $horasaida1errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida1)));
                $inserirentrada2 = "";
                $inserirsaida2 = "";
                $critica2 = "";
                $verificaentrada2 = 0;
                $verificasaida2 = 0;
                $horaentrada2 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada2)));
                $horaentrada2menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada2)));
                $horaentrada2mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada2)));
                $horasaida2menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida2)));
                $horasaida2mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida2)));
                $horasaida2 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida2)));
                $horasaida2errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida2)));
                $inserirentrada3 = "";
                $inserirsaida3 = "";
                $critica3 = "";
                $verificaentrada3 = 0;
                $verificasaida3 = 0;
                $horaentrada3 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada3)));
                $horaentrada3menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada3)));
                $horaentrada3mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada3)));
                $horasaida3menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida3)));
                $horasaida3mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida3)));
                $horasaida3 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida3)));
                $horasaida3errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida3)));

                foreach ($ponto as $item) {

                    $i = 0;
                    $b = 0;
                    $c = 0;
                    $data = substr($item->data_batida, 0, 10);
                    $hora = substr($item->data_batida, 11, 8);
                    //HORARIO NUMERO 1
                    if ($valor->horaentrada1 <> '00:00:00' && $valor->horasaida1 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada1 >= $hora && $horaentrada1menos2 <= $hora && $horaentrada1mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada1 = 1;
                            $inserirentrada1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida1menos2 <= $hora && $horasaida1mais2 >= $hora && $i == 0 && $verificasaida1 == 0) { //saida correta
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada1 > $valor->horasaida1) && ($horasaida1menos2 <= $hora && $horasaida1mais2 >= $hora) && $i == 0 && $verificasaida1 == 0) { //saida correta
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada1 < $hora && $horasaida1errada > $hora && $verificaentrada1 == 0) { // entrada atrasada
                            $verificaentrada1 = 1;
                            $inserirentrada1 = $hora;
                            $critica1 = $critica1 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida1 > $hora && $inserirentrada1 != $hora && $i == 0 && $verificasaida1 == 0) { // saida adiantada
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
//
//                        if (($verificaentrada1 == 0) && ($verificasaida1 == 0) && $valor->data == $data) { // falta
//                            $inserirentrada1 = "00:00:00";
//                            $inserirsaida1 = "00:00:00";
//                            $critica1 = "falta";
//                        }
                    }

                    //HORARIO NUMERO 2
                    if ($valor->horaentrada2 <> '00:00:00' && $valor->horasaida2 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada2 >= $hora && $horaentrada2menos2 <= $hora && $horaentrada2mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada2 = 1;
                            $inserirentrada2 = $hora;
                            $critica2 = $critica2 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida2menos2 <= $hora && $horasaida2mais2 >= $hora && $i == 0 && $verificasaida2 == 0) { //saida correta
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada2 > $valor->horasaida2) && ($horasaida2menos2 <= $hora && $horasaida2mais2 >= $hora) && $i == 0 && $verificasaida2 == 0) { //saida correta
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica2 = $critica2 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada2 < $hora && $horasaida2errada > $hora && $verificaentrada2 == 0) { // entrada atrasada
                            $verificaentrada2 = 1;
                            $inserirentrada2 = $hora;
                            $critica2 = $critica2 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida2 > $hora && $inserirentrada2 != $hora && $i == 0 && $verificasaida2 == 0) { // saida adiantada
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica2 = $critica2 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
//
//                        if (($verificaentrada2 == 0 && $verificasaida2 == 0) && ($valor->data == $data || $novadata == $data)) { // falta
//                            $inserirentrada2 = "00:00:00";
//                            $inserirsaida2 = "00:00:00";
//                            $critica2 = "falta";
//                        }
                    }

                    //HORARIO NUMERO 3
                    if ($valor->horaentrada3 <> '00:00:00' && $valor->horasaida3 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada3 >= $hora && $horaentrada3menos2 <= $hora && $horaentrada3mais2 >= $hora && $i == 0 && $b == 0) { //entrada correta
                            $verificaentrada3 = 1;
                            $inserirentrada3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida3menos2 <= $hora && $horasaida3mais2 >= $hora && $i == 0 && $verificasaida3 == 0 && $b == 0) { //saida correta
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada3 > $valor->horasaida3) && ($horasaida3menos2 <= $hora && $horasaida3mais2 >= $hora) && $i == 0 && $verificasaida3 == 0 && $b == 0) { //saida correta
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada1 < $hora && $horasaida3errada > $hora && $verificaentrada3 == 0 && $i == 0 && $b == 0) { // entrada atrasada
                            $verificaentrada3 = 1;
                            $inserirentrada3 = $hora;
                            $critica3 = $critica3 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida3 > $hora && $inserirentrada3 != $hora && $i == 0 && $verificasaida3 == 0 && $b == 0) { // saida adiantada
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                    }
                }
                //HORARIO NUMERO 1
                if ($valor->horaentrada1 != '00:00:00' && $valor->horasaida1 != '00:00:00') {
                    if ($inserirentrada1 == "") { // entrada nao registrada
                        $inserirentrada1 = "00:00:00";
                        $critica1 = $critica1 . " entrada nao registrada";
                    }
                    if ($inserirsaida1 == "") { // saida nao registrada
                        $inserirsaida1 = "00:00:00";
                        $critica1 = $critica1 . " saida nao registrada";
                    }
                }
                //HORARIO NUMERO 2
                if ($valor->horaentrada2 != '00:00:00' && $valor->horasaida2 != '00:00:00') {
                    if ($inserirentrada2 == "") { // entrada nao registrada
                        $inserirentrada2 = "00:00:00";
                        $critica2 = $critica2 . " entrada nao registrada";
                    }
                    if ($inserirsaida2 == "") { // saida nao registrada
                        $inserirsaida2 = "00:00:00";
                        $critica2 = $critica2 . " saida nao registrada";
                    }
                }
                //HORARIO NUMERO 3
                if ($valor->horaentrada3 != '00:00:00' && $valor->horasaida3 != '00:00:00') {
                    if ($inserirentrada3 == "") { // entrada nao registrada
                        $inserirentrada3 = "00:00:00";
                        $critica3 = $critica3 . " entrada nao registrada";
                    }
                    if ($inserirsaida3 == "") { // saida nao registrada
                        $inserirsaida3 = "00:00:00";
                        $critica3 = $critica3 . " saida nao registrada";
                    }
                }
                $this->processaponto->alterarcritica($value->matricula, $valor->data, $inserirentrada1, $inserirsaida1, $critica1, $inserirentrada2, $inserirsaida2, $critica2, $inserirentrada3, $inserirsaida3, $critica3);
            }
        }
        $this->loadView('ponto/processar-tipo');
    }

    function funcionariofixo() {



        $funcionario = $this->processaponto->listarfuncionariosfixo();

        foreach ($funcionario as $value) {


            $horarios = $this->processaponto->listarhorarios($value->horariostipo_id);

//                $novadata = date('Y-m-d', strtotime("+15 days", strtotime($data)));
//                echo "$novadata";
//                die;
//                $novahora = date('H:i:s', strtotime("+15 minutes", strtotime($hora)));
//                echo "$novahora";
//                die;

            foreach ($horarios as $valor) {

                $ponto = $this->processaponto->listarfuncionarioponto($value->matricula);
                $novadata = date('Y-m-d', strtotime("+1 days", strtotime($valor->data)));
                $inserirentrada1 = "";
                $inserirsaida1 = "";
                $critica1 = "";
                $verificaentrada1 = 0;
                $verificasaida1 = 0;
                $horaentrada1 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada1)));
                $horaentrada1menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada1)));
                $horaentrada1mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada1)));
                $horasaida1menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida1)));
                $horasaida1mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida1)));
                $horasaida1 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida1)));
                $horasaida1errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida1)));
                $inserirentrada2 = "";
                $inserirsaida2 = "";
                $critica2 = "";
                $verificaentrada2 = 0;
                $verificasaida2 = 0;
                $horaentrada2 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada2)));
                $horaentrada2menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada2)));
                $horaentrada2mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada2)));
                $horasaida2menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida2)));
                $horasaida2mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida2)));
                $horasaida2 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida2)));
                $horasaida2errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida2)));
                $inserirentrada3 = "";
                $inserirsaida3 = "";
                $critica3 = "";
                $verificaentrada3 = 0;
                $verificasaida3 = 0;
                $horaentrada3 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada3)));
                $horaentrada3menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada3)));
                $horaentrada3mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada3)));
                $horasaida3menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida3)));
                $horasaida3mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida3)));
                $horasaida3 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida3)));
                $horasaida3errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida3)));

                foreach ($ponto as $item) {

                    $i = 0;
                    $b = 0;
                    $c = 0;
                    $data = substr($item->data_batida, 0, 10);
                    $hora = substr($item->data_batida, 11, 8);
                    //HORARIO NUMERO 1
                    if ($valor->horaentrada1 <> '00:00:00' && $valor->horasaida1 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada1 >= $hora && $horaentrada1menos2 <= $hora && $horaentrada1mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada1 = 1;
                            $inserirentrada1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida1menos2 <= $hora && $horasaida1mais2 >= $hora && $i == 0 && $verificasaida1 == 0) { //saida correta
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada1 > $valor->horasaida1) && ($horasaida1menos2 <= $hora && $horasaida1mais2 >= $hora) && $i == 0 && $verificasaida1 == 0) { //saida correta
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada1 < $hora && $horasaida1errada > $hora && $verificaentrada1 == 0 && $i == 0) { // entrada atrasada
                            $verificaentrada1 = 1;
                            $inserirentrada1 = $hora;
                            $critica1 = $critica1 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida1 > $hora && $inserirentrada1 != $hora && $i == 0 && $verificasaida1 == 0) { // saida adiantada
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }

                        if (($verificaentrada1 == 0) && ($verificasaida1 == 0) && $valor->data == $data) { // falta
                            $inserirentrada1 = "00:00:00";
                            $inserirsaida1 = "00:00:00";
                            $critica1 = "falta";
                        }
                    }

                    //HORARIO NUMERO 2
                    if ($valor->horaentrada2 <> '00:00:00' && $valor->horasaida2 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada2 >= $hora && $horaentrada2menos2 <= $hora && $horaentrada2mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada2 = 1;
                            $inserirentrada2 = $hora;
                            $critica2 = $critica2 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida2menos2 <= $hora && $horasaida2mais2 >= $hora && $i == 0 && $verificasaida2 == 0) { //saida correta
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada2 > $valor->horasaida2) && ($horasaida2menos2 <= $hora && $horasaida2mais2 >= $hora) && $i == 0 && $verificasaida2 == 0) { //saida correta
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica2 = $critica2 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada2 < $hora && $horasaida2errada > $hora && $verificaentrada2 == 0 && $i == 0) { // entrada atrasada
                            $verificaentrada2 = 1;
                            $inserirentrada2 = $hora;
                            $critica2 = $critica2 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida2 > $hora && $inserirentrada2 != $hora && $i == 0 && $verificasaida2 == 0) { // saida adiantada
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica2 = $critica2 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
//
//                        if (($verificaentrada2 == 0 && $verificasaida2 == 0) && ($valor->data == $data || $novadata == $data)) { // falta
//                            $inserirentrada2 = "00:00:00";
//                            $inserirsaida2 = "00:00:00";
//                            $critica2 = "falta";
//                        }
                    }

                    //HORARIO NUMERO 3
                    if ($valor->horaentrada3 <> '00:00:00' && $valor->horasaida3 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada3 >= $hora && $horaentrada3menos2 <= $hora && $horaentrada3mais2 >= $hora && $i == 0 && $b == 0) { //entrada correta
                            $verificaentrada3 = 1;
                            $inserirentrada3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida3menos2 <= $hora && $horasaida3mais2 >= $hora && $i == 0 && $verificasaida3 == 0 && $b == 0) { //saida correta
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada3 > $valor->horasaida3) && ($horasaida3menos2 <= $hora && $horasaida3mais2 >= $hora) && $i == 0 && $verificasaida3 == 0 && $b == 0) { //saida correta
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada1 < $hora && $horasaida3errada > $hora && $verificaentrada3 == 0 && $i == 0 && $b == 0) { // entrada atrasada
                            $verificaentrada3 = 1;
                            $inserirentrada3 = $hora;
                            $critica3 = $critica3 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida3 > $hora && $inserirentrada3 != $hora && $i == 0 && $verificasaida3 == 0 && $b == 0) { // saida adiantada
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                    }
                }
                //HORARIO NUMERO 1
                if ($valor->horaentrada1 != '00:00:00' && $valor->horasaida1 != '00:00:00') {
                    if ($inserirentrada1 == "") { // entrada nao registrada
                        $inserirentrada1 = "00:00:00";
                        $critica1 = $critica1 . " entrada nao registrada";
                    }
                    if ($inserirsaida1 == "") { // saida nao registrada
                        $inserirsaida1 = "00:00:00";
                        $critica1 = $critica1 . " saida nao registrada";
                    }
                }
                //HORARIO NUMERO 2
                if ($valor->horaentrada2 != '00:00:00' && $valor->horasaida2 != '00:00:00') {
                    if ($inserirentrada2 == "") { // entrada nao registrada
                        $inserirentrada2 = "00:00:00";
                        $critica2 = $critica2 . " entrada nao registrada";
                    }
                    if ($inserirsaida2 == "") { // saida nao registrada
                        $inserirsaida2 = "00:00:00";
                        $critica2 = $critica2 . " saida nao registrada";
                    }
                }
                //HORARIO NUMERO 3
                if ($valor->horaentrada3 != '00:00:00' && $valor->horasaida3 != '00:00:00') {
                    if ($inserirentrada3 == "") { // entrada nao registrada
                        $inserirentrada3 = "00:00:00";
                        $critica3 = $critica3 . " entrada nao registrada";
                    }
                    if ($inserirsaida3 == "") { // saida nao registrada
                        $inserirsaida3 = "00:00:00";
                        $critica3 = $critica3 . " saida nao registrada";
                    }
                }
                $this->processaponto->gravarcritica($value->matricula, $valor->data, $inserirentrada1, $inserirsaida1, $critica1, $inserirentrada2, $inserirsaida2, $critica2, $inserirentrada3, $inserirsaida3, $critica3);
            }
        }
        $this->loadView('ponto/processar-tipo');
    }

    function funcionariosemiflexivel() {



        $funcionario = $this->processaponto->listarfuncionariossemiflexivel();

        foreach ($funcionario as $value) {

            $ponto = $this->processaponto->listarfuncionarioponto($value->matricula);
            $horarios = $this->processaponto->listarhorarios($value->horariostipo_id);

//                $novadata = date('Y-m-d', strtotime("+15 days", strtotime($data)));
//                echo "$novadata";
//                die;
//                $novahora = date('H:i:s', strtotime("+15 minutes", strtotime($hora)));
//                echo "$novahora";
//                die;

            foreach ($horarios as $valor) {

                $ponto = $this->processaponto->listarfuncionarioponto($value->matricula);
                $novadata = date('Y-m-d', strtotime("+1 days", strtotime($valor->data)));
                $inserirentrada1 = "";
                $inserirsaida1 = "";
                $critica1 = "";
                $verificaentrada1 = 0;
                $verificasaida1 = 0;
                $horaentrada1 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada1)));
                $horaentrada1menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada1)));
                $horaentrada1mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada1)));
                $horasaida1menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida1)));
                $horasaida1mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida1)));
                $horasaida1 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida1)));
                $horasaida1errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida1)));
                $inserirentrada2 = "";
                $inserirsaida2 = "";
                $critica2 = "";
                $verificaentrada2 = 0;
                $verificasaida2 = 0;
                $horaentrada2 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada2)));
                $horaentrada2menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada2)));
                $horaentrada2mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada2)));
                $horasaida2menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida2)));
                $horasaida2mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida2)));
                $horasaida2 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida2)));
                $horasaida2errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida2)));
                $inserirentrada3 = "";
                $inserirsaida3 = "";
                $critica3 = "";
                $verificaentrada3 = 0;
                $verificasaida3 = 0;
                $horaentrada3 = date('H:i:s', strtotime("+15 minutes", strtotime($valor->horaentrada3)));
                $horaentrada3menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horaentrada3)));
                $horaentrada3mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horaentrada3)));
                $horasaida3menos2 = date('H:i:s', strtotime("-120 minutes", strtotime($valor->horasaida3)));
                $horasaida3mais2 = date('H:i:s', strtotime("+120 minutes", strtotime($valor->horasaida3)));
                $horasaida3 = date('H:i:s', strtotime("-5 minutes", strtotime($valor->horasaida3)));
                $horasaida3errada = date('H:i:s', strtotime("-50 minutes", strtotime($valor->horasaida3)));

                foreach ($ponto as $item) {

                    $i = 0;
                    $b = 0;
                    $c = 0;
                    $data = substr($item->data_batida, 0, 10);
                    $hora = substr($item->data_batida, 11, 8);
                    //HORARIO NUMERO 1
                    if ($valor->horaentrada1 <> '00:00:00' && $valor->horasaida1 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada1 >= $hora && $horaentrada1menos2 <= $hora && $horaentrada1mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada1 = 1;
                            $inserirentrada1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida1menos2 <= $hora && $horasaida1mais2 >= $hora && $i == 0 && $verificasaida1 == 0) { //saida correta
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada1 > $valor->horasaida1) && ($horasaida1menos2 <= $hora && $horasaida1mais2 >= $hora) && $i == 0 && $verificasaida1 == 0) { //saida correta
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada1 < $hora && $horasaida1errada > $hora && $verificaentrada1 == 0) { // entrada atrasada
                            $verificaentrada1 = 1;
                            $inserirentrada1 = $hora;
                            $critica1 = $critica1 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida1 > $hora && $inserirentrada1 != $hora && $i == 0 && $verificasaida1 == 0) { // saida adiantada
                            $verificasaida1 = 2;
                            $inserirsaida1 = $hora;
                            $critica1 = $critica1 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }

                        if (($verificaentrada1 == 0) && ($verificasaida1 == 0) && $valor->data == $data) { // falta
                            $inserirentrada1 = "00:00:00";
                            $inserirsaida1 = "00:00:00";
                            $critica1 = "falta";
                        }
                    }

                    //HORARIO NUMERO 2
                    if ($valor->horaentrada2 <> '00:00:00' && $valor->horasaida2 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada2 >= $hora && $horaentrada2menos2 <= $hora && $horaentrada2mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada2 = 1;
                            $inserirentrada2 = $hora;
                            $critica2 = $critica2 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida2menos2 <= $hora && $horasaida2mais2 >= $hora && $i == 0 && $verificasaida2 == 0) { //saida correta
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica1 = $critica1 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada2 > $valor->horasaida2) && ($horasaida2menos2 <= $hora && $horasaida2mais2 >= $hora) && $i == 0 && $verificasaida2 == 0) { //saida correta
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica2 = $critica2 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada2 < $hora && $horasaida2errada > $hora && $verificaentrada2 == 0) { // entrada atrasada
                            $verificaentrada2 = 1;
                            $inserirentrada2 = $hora;
                            $critica2 = $critica2 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida2 > $hora && $inserirentrada2 != $hora && $i == 0 && $verificasaida2 == 0) { // saida adiantada
                            $verificasaida2 = 2;
                            $inserirsaida2 = $hora;
                            $critica2 = $critica2 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
//
//                        if (($verificaentrada2 == 0 && $verificasaida2 == 0) && ($valor->data == $data || $novadata == $data)) { // falta
//                            $inserirentrada2 = "00:00:00";
//                            $inserirsaida2 = "00:00:00";
//                            $critica2 = "falta";
//                        }
                    }

                    //HORARIO NUMERO 3
                    if ($valor->horaentrada3 <> '00:00:00' && $valor->horasaida3 <> '00:00:00') {
                        if ($valor->data == $data && $horaentrada3 >= $hora && $horaentrada3menos2 <= $hora && $horaentrada3mais2 >= $hora && $i == 0) { //entrada correta
                            $verificaentrada3 = 1;
                            $inserirentrada3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida3menos2 <= $hora && $horasaida3mais2 >= $hora && $i == 0 && $verificasaida3 == 0) { //saida correta
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if (($novadata == $data && $valor->horaentrada3 > $valor->horasaida3) && ($horasaida3menos2 <= $hora && $horasaida3mais2 >= $hora) && $i == 0 && $verificasaida3 == 0) { //saida correta
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . "";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horaentrada1 < $hora && $horasaida3errada > $hora && $verificaentrada3 == 0) { // entrada atrasada
                            $verificaentrada3 = 1;
                            $inserirentrada3 = $hora;
                            $critica3 = $critica3 . " atraso";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                        if ($valor->data == $data && $horasaida3 > $hora && $inserirentrada3 != $hora && $i == 0 && $verificasaida3 == 0) { // saida adiantada
                            $verificasaida3 = 2;
                            $inserirsaida3 = $hora;
                            $critica3 = $critica3 . " saida antencipada";
                            $i++;
                            $b++;
                            $c++;
                            $this->processaponto->verificadoponto($item->pontosimportados_id);
                        }
                    }
                }
                //HORARIO NUMERO 1
                if ($valor->horaentrada1 != '00:00:00' && $valor->horasaida1 != '00:00:00') {
                    if ($inserirentrada1 == "") { // entrada nao registrada
                        $inserirentrada1 = "00:00:00";
                        $critica1 = $critica1 . " entrada nao registrada";
                    }
                    if ($inserirsaida1 == "") { // saida nao registrada
                        $inserirsaida1 = "00:00:00";
                        $critica1 = $critica1 . " saida nao registrada";
                    }
                }
                //HORARIO NUMERO 2
                if ($valor->horaentrada2 != '00:00:00' && $valor->horasaida2 != '00:00:00') {
                    if ($inserirentrada2 == "") { // entrada nao registrada
                        $inserirentrada2 = "00:00:00";
                        $critica2 = $critica2 . " entrada nao registrada";
                    }
                    if ($inserirsaida2 == "") { // saida nao registrada
                        $inserirsaida2 = "00:00:00";
                        $critica2 = $critica2 . " saida nao registrada";
                    }
                }
                //HORARIO NUMERO 3
                if ($valor->horaentrada3 != '00:00:00' && $valor->horasaida3 != '00:00:00') {
                    if ($inserirentrada3 == "") { // entrada nao registrada
                        $inserirentrada3 = "00:00:00";
                        $critica3 = $critica3 . " entrada nao registrada";
                    }
                    if ($inserirsaida3 == "") { // saida nao registrada
                        $inserirsaida3 = "00:00:00";
                        $critica3 = $critica3 . " saida nao registrada";
                    }
                }
                $this->processaponto->gravarcritica($value->matricula, $valor->data, $inserirentrada1, $inserirsaida1, $critica1, $inserirentrada2, $inserirsaida2, $critica2, $inserirentrada3, $inserirsaida3, $critica3);
            }
        }
        $this->loadView('ponto/processar-tipo');
    }

    function excluirServidor($servidor_id) {
        if ($this->servidor->excluirServidor($servidor_id)) {
            $mensagem = 'Sucesso ao excluir o servidor.';
        } else {
            $mensagem = 'Erro ao excluir o servidor. Opera&ccedil;&atilde;o cancelada.';
        }

        $data['lista'] = $this->servidor->listar();
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "giah/servidor/index/$data");
    }

    function gravar() {
        $funcionario_id = $this->funcionario->gravar();
        if ($funcionario_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o funcionario. Opera&ccedil;&atilde;o cancelada.';
        }
        //    { $mensagem = 'servidor002';}
        else {
            $data['mensagem'] = 'Sucesso ao gravar o funcionario.';
        }
        //{ $mensagem = 'servidor001';}
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ponto/funcionario");

        //$this->carregarView();
        //redirect(base_url()."giah/servidor/index/$data","refresh");
    }

    private

    function carregarView($data = null, $view = null) {
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
