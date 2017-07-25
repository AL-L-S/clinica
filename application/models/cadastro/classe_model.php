<?php

class classe_model extends Model {

    var $_financeiro_classe_id = null;
    var $_descricao = null;
    var $_tipo_id = null;

    function Classe_model($financeiro_classe_id = null) {
        parent::Model();
        if (isset($financeiro_classe_id)) {
            $this->instanciar($financeiro_classe_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('c.financeiro_classe_id,
                            c.descricao,
                            c.tipo_id,
                            t.descricao as tipo');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id', 'left');
        $this->db->where('c.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('c.descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarclasse() {
        $this->db->select('financeiro_classe_id as classe_id,
                            descricao');
        $this->db->from('tb_financeiro_classe');
        $this->db->where('ativo', 'true');
        $this->db->orderby('descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function listartipo() {
        $this->db->select('tipo_entradas_saida_id as tipo_id,
                            descricao');
        $this->db->from('tb_tipo_entradas_saida');
        $this->db->where('ativo', 'true');
        $this->db->orderby('descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarclasse($classe_id) {
        $this->db->select('financeiro_classe_id,
                            descricao');
        $this->db->from('tb_financeiro_classe');
        $this->db->where('financeiro_classe_id', $classe_id);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarclasserelatorio($classe) {
        $this->db->select('financeiro_classe_id,
                            descricao');
        $this->db->from('tb_financeiro_classe');
        $this->db->where('descricao', $classe);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteclasses($parametro) {
        $this->db->select(' financeiro_classe_id as classe_id,                           
                            descricao as classe');
        $this->db->from('tb_financeiro_classe ');
        $this->db->where("ativo", 't');
        $this->db->where('tipo_id', $parametro);
        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteclassessaida($parametro) {
        $this->db->select(' c.financeiro_classe_id as classe_id,                           
                            c.descricao as classe');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id');
        $this->db->where("c.ativo", 't');
        $this->db->where('t.tipo_entradas_saida_id', $parametro);
        $this->db->orderby("c.descricao");
//        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarautocompleteclassessaidadescricao($parametro) {
        $this->db->select(' c.financeiro_classe_id as classe_id,                           
                            c.descricao as classe');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id');
        $this->db->where("c.ativo", 't');
        $this->db->where('t.descricao', $parametro);
        $this->db->orderby("c.descricao");
//        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }
    function listarautocompleteclassessaidadescricaotodos() {
        $this->db->select(' c.financeiro_classe_id as classe_id,                           
                            c.descricao as classe');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id');
        $this->db->where("c.ativo", 't');
//        $this->db->where('t.descricao', $parametro);
        $this->db->orderby("c.descricao");
//        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteclasse($parametro) {
        $this->db->select(' c.financeiro_classe_id as classe_id,                           
                            c.descricao as classe');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id');
        $this->db->where("c.ativo", 't');
        $this->db->where('t.descricao', $parametro);
        $this->db->orderby("c.descricao");
//        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($financeiro_classe_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('financeiro_classe_id', $financeiro_classe_id);
        $this->db->update('tb_financeiro_classe');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $financeiro_classe_id = $_POST['txtfinanceiroclasseid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $this->db->set('tipo_id', $_POST['txttipo_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtfinanceiroclasseid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_financeiro_classe');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $financeiro_classe_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_classe_id = $_POST['txtfinanceiroclasseid'];
                $this->db->where('financeiro_classe_id', $financeiro_classe_id);
                $this->db->update('tb_financeiro_classe');
            }
            return $financeiro_classe_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($financeiro_classe_id) {

        if ($financeiro_classe_id != 0) {
            $this->db->select('financeiro_classe_id, descricao, tipo_id');
            $this->db->from('tb_financeiro_classe');
            $this->db->where("financeiro_classe_id", $financeiro_classe_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_financeiro_classe_id = $financeiro_classe_id;
            $this->_descricao = $return[0]->descricao;
            $this->_tipo_id = $return[0]->tipo_id;
        } else {
            $this->_financeiro_classe_id = null;
        }
    }

}
