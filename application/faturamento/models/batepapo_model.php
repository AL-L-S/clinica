<?php

require_once APPPATH . 'models/base/BaseModel.php';

class batepapo_model extends BaseModel {
    /* Método construtor */

    function Batepapo_model($servidor_id = null) {
        parent::Model();
    }

    function listarusuarios() {
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('o.usuario,
                           o.operador_id ');
        $this->db->from('tb_operador o');
        $this->db->where('o.ativo', 't');
        $this->db->where('o.operador_id !=', $operador_id);
        $this->db->orderby('o.usuario');
        $return = $this->db->get();
        return $return->result();
    }
    
    function totalmensagensnaolidas() {
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('chat_mensagens_id');
        $this->db->from('tb_chat_mensagens');
        $this->db->where('ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('visualizada', 'f');
        $return = $this->db->get();
        return $return->result();
    }
    
    
    function atualizamensagensvisualizadas($destino) {
        $operador_id = $this->session->userdata('operador_id');

        
        $this->db->set('visualizada', 't');
        $this->db->where('operador_origem', $destino);
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('ativo', 't');
        $this->db->update('tb_chat_mensagens');
    }
    
    function visualizacontatoaberto($destino) {
        $operador_id = $this->session->userdata('operador_id');

        
        $this->db->set('visualizada', 't');
        $this->db->where('operador_origem', $destino);
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('ativo', 't');
        $this->db->update('tb_chat_mensagens');
    }
    
    function contamensagensporusuarios($operador_origem) {
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('chat_mensagens_id');
        $this->db->from('tb_chat_mensagens');
        $this->db->where('ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('operador_origem', $operador_origem);
        $this->db->where('visualizada', 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function historicomensagens() {

        $sql = "SELECT * ";
        $sql .= "FROM ponto.tb_chat_mensagens WHERE (ativo = 't') AND ";
        $sql .= "((operador_origem = " . $_GET['operador_origem'] . " AND operador_destino = " . $_GET['operador_destino'] . ") OR ";
        $sql .= "(operador_origem = " . $_GET['operador_destino'] . " AND operador_destino = " . $_GET['operador_origem'] . ")) ";
        $sql .= " ORDER BY chat_mensagens_id";

        $return = $this->db->query($sql);
        return $return->result();
    }

    function atualizahorario($operador_id) {
        $horario = date(" Y-m-d H:i:s");
        $limite = date(" Y-m-d H:i:s", strtotime('+2 min'));

        $this->db->set('horario_login', $horario);
        $this->db->set('limite', $limite);
        $this->db->where('operador_id', $operador_id);
        $this->db->update('tb_operador');
    }

    function atualizamensagens($timestamp, $ultimo_id) {
        $operador_id = $this->session->userdata('operador_id');

        
        $sql = "SELECT * FROM ponto.tb_chat_mensagens WHERE (ativo = 't' AND (operador_origem = $operador_id OR operador_destino = $operador_id))"; 
        if ($_GET["timestamp"] == 0){
            $sql .= " AND visualizada = 'f'";
        } else {
            $sql .= " AND data_envio <= $timestamp AND visualizada = 'f'";
        }
        
        if(!empty($ultimo_id)){
            $sql .= " AND chat_mensagens_id > $ultimo_id";
        }
        $sql .= " ORDER BY data_envio ";
        
        $return = $this->db->query($sql);
        return $return->result();
    }

    function enviarmensagem() {
        $horario = date("Y-m-d H:i:s");
//        $limite = date(" Y-m-d H:i:s", strtotime('+2 min'));
        $mensagem = utf8_encode($_GET['mensagem']);

        //salvando mensagem no banco
        $this->db->set('mensagem', $mensagem);
        $this->db->set('operador_origem', $_GET['origem']);
        $this->db->set('operador_destino', $_GET['destino']);
        $this->db->set('data_envio', $horario);
        $this->db->insert('tb_chat_mensagens');
    }

}

?>
