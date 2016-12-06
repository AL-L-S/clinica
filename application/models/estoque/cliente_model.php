<?php

class cliente_model extends Model {

    var $_estoque_cliente_id = null;
    var $_nome = null;

    function Cliente_model($estoque_cliente_id = null) {
        parent::Model();
        if (isset($estoque_cliente_id)) {
            $this->instanciar($estoque_cliente_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('estoque_cliente_id,
                            nome, telefone');
        $this->db->from('tb_estoque_cliente');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    
    function listarmenu() {
        $this->db->select('estoque_menu_id,
                            descricao');
        $this->db->from('tb_estoque_menu');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarclientes() {
        $this->db->select('estoque_cliente_id,
                            nome');
        $this->db->from('tb_estoque_cliente');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function contador($operador_id) {
        $this->db->select();
        $this->db->from('tb_estoque_operador_cliente');
        $this->db->where('operador_id', $operador_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarcliente($operador_id) {
        $this->db->select('ec.nome, oc.estoque_operador_cliente_id');
        $this->db->from('tb_estoque_operador_cliente oc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = oc.cliente_id');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('oc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function testaclienterepetidos($cliente_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('estoque_operador_cliente_id');
        $this->db->from('tb_estoque_operador_cliente oc');
        $this->db->join('tb_operador o', 'o.operador_id = oc.operador_id');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('oc.cliente_id', $cliente_id);
        $this->db->where('oc.ativo', 't');
        $this->db->where('o.ativo', 't');
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
            $this->db->insert('tb_estoque_operador_cliente');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_menu_produtos_id = $this->db->insert_id();

            return $estoque_menu_produtos_id;
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
        $this->db->where('estoque_operador_cliente_id', $operado_cliente);
        $this->db->update('tb_estoque_operador_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluir($estoque_cliente_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_cliente_id', $estoque_cliente_id);
        $this->db->update('tb_estoque_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_cliente_id = $_POST['txtestoqueclienteid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('menu_id', $_POST['menu']);
            $this->db->set('telefone', $_POST['txttelefone']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoqueclienteid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_cliente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_cliente_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_cliente_id = $_POST['txtestoqueclienteid'];
                $this->db->where('estoque_cliente_id', $estoque_cliente_id);
                $this->db->update('tb_estoque_cliente');
            }
            return $estoque_cliente_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_cliente_id) {

        if ($estoque_cliente_id != 0) {
            $this->db->select('estoque_cliente_id, nome, telefone, menu_id');
            $this->db->from('tb_estoque_cliente');
            $this->db->where("estoque_cliente_id", $estoque_cliente_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_cliente_id = $estoque_cliente_id;
            $this->_nome = $return[0]->nome;
            $this->_telefone = $return[0]->telefone;
            $this->_menu = $return[0]->menu_id;
        } else {
            $this->_estoque_cliente_id = null;
        }
    }

}

?>
