<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class batepapo extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('batepapo_model', 'batepapo');
        $this->load->library('utilitario');
    }

    public function index() {
        $this->pesquisar();
    }

    public function pesquisar() {
        $operador_id = $this->session->userdata('operador_id');
        $data['usuarios'] = $this->batepapo->listarusuarios();
        $tot_mensagens[] = array();

        for ($i = 0; $i < count($data['usuarios']); $i++){
            $tot_mensagens[$i]["total_mensagens"] = $this->batepapo->contamensagensporusuarios($data['usuarios'][$i]->operador_id);
            $tot_mensagens[$i]["total_mensagens"] = count($tot_mensagens[$i]["total_mensagens"]);
            $tot_mensagens[$i]["operador_origem"] = $data['usuarios'][$i]->operador_id;
        }

        for($i = 0; $i< count($data['usuarios']); $i++){
            for($n = 0; $n < count($tot_mensagens); $n++){
                if ($tot_mensagens[$n]["operador_origem"] == $data['usuarios'][$i]->operador_id){
                    $num_mensagens = $tot_mensagens[$n]["total_mensagens"];
                    break;
                }
            }
            
            $usuarios[] = array(
                'usuario' => utf8_encode($data['usuarios'][$i]->usuario),
                'operador_id' => $data['usuarios'][$i]->operador_id,
                'num_mensagens' => $num_mensagens
            );
        }
        
        
        die(json_encode($usuarios));
    }
    
    
    function enviarmensagem() {
        $this->batepapo->enviarmensagem();
    }
    
    function historicomensagens() {        
        $operador_id = $this->session->userdata('operador_id');
        $historico = $this->batepapo->historicomensagens();
//        die(json_encode("oi"));
        $this->batepapo->atualizamensagensvisualizadas($_GET["operador_destino"]);
        
        foreach ($historico as $item){
            if($item->operador_origem == $operador_id){
                $janela = $item->operador_destino;
            } 
            elseif ($item->operador_destino == $operador_id) {
                $janela = $item->operador_origem;
            }
            
            $mensagens[] = array(
                'chat_id' => $item->chat_mensagens_id,
                'mensagem' => utf8_decode($item->mensagem),
                'janela' => $janela,
                'id_origem' => $item->operador_origem,
                'id_destino' => $item->operador_destino
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
//        var_dump($historico); die;
        
        $total = count($total);
        
        die(json_encode($total));
    }
       
    function abrindomensagensnaolidas() {        
        $operador_id = $this->session->userdata('operador_id');
        $data['usuarios'] = $this->batepapo->listarusuariosabrircontato();
        
        for($i = 0; $i< count($data['usuarios']); $i++){
            
            $usuarios[] = array(
                'usuario' => utf8_encode($data['usuarios'][$i]->usuario),
                'operador_id' => $data['usuarios'][$i]->operador_origem,
            );
            
        }
        
        die(json_encode($usuarios));
        
    }
    
    function atualizamensagens() {
        
        $timestamp = ($_GET["timestamp"] == 0)? time(): strip_tags(trim($_GET["timestamp"]));
        $ultimo_id = (isset($_GET["ultimoid"]) && !empty($_GET["ultimoid"]))? $_GET["ultimoid"]: 0;
        $operador_id = $this->session->userdata('operador_id');
        
        if(empty($timestamp)){
            die(json_encode(array("status" => "erro")));
        }
        
        $mensagens = $this->batepapo->atualizamensagens($timestamp, $ultimo_id);
//        $mensagens = array_reverse($mensagens);

        $tot_linhas = count($mensagens);
//        if( $tot_linhas<=0 ){
//            while($tot_linhas <= 0){
//                if($tot_linhas <= 0){
//                    
//                    //vai verificar por 20segundos
//                    if($tempo_gasto >= 5){
//                        die(json_encode(array("status" => "vazio", "ultimoid" => 0, "timestamp" => time())));
//                        exit;
//                    }
//                    
//                    sleep(1);
//                    $mensagens = $this->batepapo->atualizamensagens($timestamp, $ultimo_id);
//                    $tot_linhas = count($mensagens);
//                    $tempo_gasto++;
//                }
//            }
//        } 
//        echo "<pre>"; echo $operador_id . "<hr>";
        if( $tot_linhas >= 1){
            foreach ($mensagens as $item){
                
                if($operador_id == $item->operador_origem){
                    $janela = $item->operador_destino;
                }
                elseif($operador_id == $item->operador_destino){
                    $janela = $item->operador_origem;
                } 
                
                $novas_mensagens[] = array(
                    'chat_id' => $item->chat_mensagens_id,
                    'mensagem' => utf8_decode($item->mensagem),
                    'janela' => $janela,
                    'id_origem' => $item->operador_origem,
                    'id_destino' => $item->operador_destino
                );
            }
        }
        
        $ultima_msg = end($novas_mensagens);
        $ultimo_id = $ultima_msg["chat_id"];
        die(json_encode(array("status" => "resultados", "ultimoid" => $ultimo_id, "timestamp" => time(), "dados" => $novas_mensagens)));
    }


}

?>
