<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class batepapo extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('batepapo_model', 'batepapo');
        $this->load->library('utilitario');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar() {
//        die('morreu');
        $operador_id = $this->session->userdata('operador_id');
        $data['usuarios'] = $this->batepapo->listarusuarios();
//        
        die(json_encode($data['usuarios']));
    }

    function enviarmensagem() {
        $this->batepapo->enviarmensagem();
    }

    function atualizastatus() {
        $this->batepapo->atualizastatus();
        $operadores = $this->batepapo->listarusuarios();

        foreach ($operadores as $item) {

            if (isset($item->horario_login)) {
                $horario = date("Y-m-d H:i:s");
                $horario_login = date("Y-m-d H:i:s", strtotime("+3 minutes", strtotime($data['usuarios'][$i]->horario_login)));
                if ($horario_login <= $horario) {
                    $this->batepapo->atualizastatusoperadores($item->operador_id);
                }
            }
        }
    }

    function historicomensagens() {
        $operador_id = $this->session->userdata('operador_id');
        $historico = $this->batepapo->historicomensagens();

        $this->batepapo->atualizamensagensvisualizadas($_GET["operador_destino"]);

        foreach ($historico as $item) {
            if ($item->operador_origem == $operador_id) {
                $janela = $item->operador_destino;
            } elseif ($item->operador_destino == $operador_id) {
                $janela = $item->operador_origem;
            }

            $mensagens[] = array(
                'chat_id' => $item->chat_mensagens_id,
                'mensagem' => utf8_decode($item->mensagem),
                'janela' => $janela,
                'id_origem' => $item->operador_origem,
                'id_destino' => $item->operador_destino,
                'data_envio' => date("d/m/Y H:i", strtotime($item->data_envio))
            );
        }
        die(json_encode($mensagens));
    }

    function visualizacontatoaberto() {
        $operador_id = $this->session->userdata('operador_id');
        $this->batepapo->visualizacontatoaberto($_GET["operador_destino"]);
        die;
    }

    function totalmensagensnaolidas() {
        $operador_id = $this->session->userdata('operador_id');
        $total = $this->batepapo->totalmensagensnaolidas();
        die(json_encode($total));
    }

    function abrindomensagensnaolidas() {
        $operador_id = $this->session->userdata('operador_id');
        $data['usuarios'] = $this->batepapo->listarusuariosabrircontato();

        for ($i = 0; $i < count($data['usuarios']); $i++) {

            $usuarios[] = array(
                'usuario' => utf8_encode($data['usuarios'][$i]->usuario),
                'operador_id' => $data['usuarios'][$i]->operador_origem,
            );
        }

        die(json_encode($usuarios));
    }

    function atualizamensagens() {
        

            $timestamp = date("Y-m-d H:i:s"); /* ($_GET["timestamp"] == 0)? date("Y-m-d H:i:s"): date("Y-m-d H:i:s", strtotime($_GET["timestamp"])); */
            $ultimo_id = (isset($_GET["ultimoid"]) && !empty($_GET["ultimoid"])) ? $_GET["ultimoid"] : 0;
            $operador_id = $this->session->userdata('operador_id');


            if (empty($timestamp)) {
                die(json_encode(array("status" => "erro")));
            }
            
            $mensagens = $this->batepapo->atualizamensagens($timestamp, $ultimo_id);

            $tot_linhas = count($mensagens);

            if ($tot_linhas >= 1) {
                foreach ($mensagens as $item) {

                    if ($operador_id == $item->operador_origem) {
                        $janela = $item->operador_destino;
                    } elseif ($operador_id == $item->operador_destino) {
                        $janela = $item->operador_origem;
                    }

                    $novas_mensagens[] = array(
                        'chat_id' => $item->chat_mensagens_id,
                        'mensagem' => utf8_decode($item->mensagem),
                        'janela' => $janela,
                        'id_origem' => $item->operador_origem,
                        'id_destino' => $item->operador_destino,
                        'data_envio' => date("d/m/Y H:i", strtotime($item->data_envio))
                    );
                }
            }
            $ultima_msg = end($novas_mensagens);
            $ultimo_id = $ultima_msg["chat_id"];
            die(json_encode(array("status" => "resultados", "ultimoid" => $ultimo_id, "timestamp" => time(), "dados" => $novas_mensagens)));
//        }
    }

}

?>
