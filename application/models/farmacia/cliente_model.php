<?php

class cliente_model extends Model {

    var $_farmacia_cliente_id = null;
    var $_nome = null;

    function Cliente_model($farmacia_cliente_id = null) {
        parent::Model();
        if (isset($farmacia_cliente_id)) {
            $this->instanciar($farmacia_cliente_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('farmacia_cliente_id,
                            nome, telefone');
        $this->db->from('tb_farmacia_cliente');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    
    function listarmenu() {
        $this->db->select('farmacia_menu_id,
                            descricao');
        $this->db->from('tb_farmacia_menu');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarclientes() {
        $this->db->select('farmacia_cliente_id,
                            nome');
        $this->db->from('tb_farmacia_cliente');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function contador($operador_id) {
        $this->db->select();
        $this->db->from('tb_farmacia_operador_cliente');
        $this->db->where('operador_id', $operador_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarcliente($operador_id) {
        $this->db->select('ec.nome, oc.farmacia_operador_cliente_id');
        $this->db->from('tb_farmacia_operador_cliente oc');
        $this->db->join('tb_farmacia_cliente ec', 'ec.farmacia_cliente_id = oc.cliente_id');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('oc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaroperadores($operador_id) {
        $this->db->select('operador_id,
                            usuario');
        $this->db->from('tb_operador');
        $this->db->where('ativo', 'true');
        $this->db->where('operador_id', $operador_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarclientes() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('operador_id', $_POST['txtoperador_id']);
            $this->db->set('cliente_id', $_POST['clientes_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_farmacia_operador_cliente');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $farmacia_menu_produtos_id = $this->db->insert_id();

            return $farmacia_menu_produtos_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirclientes($operado_cliente) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_operador_cliente_id', $operado_cliente);
        $this->db->update('tb_farmacia_operador_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluir($farmacia_cliente_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_cliente_id', $farmacia_cliente_id);
        $this->db->update('tb_farmacia_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $farmacia_cliente_id = $_POST['txtfarmaciaclienteid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('menu_id', $_POST['menu']);
            $this->db->set('telefone', $_POST['txttelefone']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtfarmaciaclienteid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_farmacia_cliente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $farmacia_cliente_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_cliente_id = $_POST['txtfarmaciaclienteid'];
                $this->db->where('farmacia_cliente_id', $farmacia_cliente_id);
                $this->db->update('tb_farmacia_cliente');
            }
            return $farmacia_cliente_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($farmacia_cliente_id) {

        if ($farmacia_cliente_id != 0) {
            $this->db->select('farmacia_cliente_id, nome, telefone, menu_id');
            $this->db->from('tb_farmacia_cliente');
            $this->db->where("farmacia_cliente_id", $farmacia_cliente_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_farmacia_cliente_id = $farmacia_cliente_id;
            $this->_nome = $return[0]->nome;
            $this->_telefone = $return[0]->telefone;
            $this->_menu = $return[0]->menu_id;
        } else {
            $this->_farmacia_cliente_id = null;
        }
    }

}

?>
