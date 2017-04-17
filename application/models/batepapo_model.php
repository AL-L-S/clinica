<?php

require_once APPPATH . 'models/base/BaseModel.php';

class batepapo_model extends BaseModel {
    /* Método construtor */

    function Batepapo_model($servidor_id = null) {
        parent::Model();
    }

    function listarusuarios() {
        $operador_id = $this->session->userdata('operador_id');
        
        $sql = 'SELECT "o"."usuario" as usuario, "o"."operador_id", 
                        ( 
                                SELECT COUNT(*) 
                                FROM ponto.tb_chat_mensagens 
                                WHERE ponto.tb_chat_mensagens.operador_origem = o.operador_id 
                                AND ponto.tb_chat_mensagens.ativo = \'t\' AND ponto.tb_chat_mensagens.visualizada = \'f\' 
                                AND ponto.tb_chat_mensagens.operador_destino = 1 
                        ) as num_mensagens, 
                        ( 	
                                SELECT COALESCE((SELECT true WHERE (o.horario_login + INTERVAL\'3 minute\') >=  current_timestamp), false) 
                        ) as status 
                FROM "ponto"."tb_operador" o 
                WHERE "o"."ativo" = \'t\' AND "o"."operador_id" != \'1\' 
                AND "o"."usuario" != \'\' AND "o"."operador_id" IS NOT NULL
                ORDER BY status DESC, "o"."usuario"';
        
        $return = $this->db->query($sql);
        
        return $return->result_array();
    }

    function listarusuariosabrircontato() {
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('DISTINCT(operador_origem) as operador_origem,
                           cm.operador_destino,
                           o.usuario');
        $this->db->from('tb_chat_mensagens cm');
        $this->db->where('cm.ativo', 't');
        $this->db->where('cm.visualizada', 'f');
        $this->db->where('cm.operador_destino', $operador_id);
        $this->db->join('tb_operador o', 'o.operador_id = cm.operador_origem', 'left');
        $return = $this->db->get();
        return $return->result();
    }
    
    function totalmensagensnaolidas() {
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('COUNT(chat_mensagens_id) as total');
        $this->db->from('tb_chat_mensagens');
        $this->db->where('ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('visualizada', 'f');
        $return = $this->db->get();
        $return = $return->result();
        return $return[0]->total;
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
    
    
    function atualizastatusoperadores($operador) {
        $horario = date("Y-m-d H:i:s");
        $this->db->set('horario_logout', $horario);
        $this->db->set('online', 'f');
        $this->db->where('operador_id', $operador);
        $this->db->update('tb_operador');
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
        $sql .= " ORDER BY data_envio";

        $return = $this->db->query($sql);
        return $return->result();
    }
    
    function atualizastatus() {
        $operador_id = $this->session->userdata('operador_id');
        $horario = date("Y-m-d H:i:s");

        $this->db->set('horario_login', $horario);
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
