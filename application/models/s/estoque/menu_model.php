<?php

class menu_model extends Model {

    var $_estoque_menu_id = null;
    var $_descricao = null;

    function Menu_model($estoque_menu_id = null) {
        parent::Model();
        if (isset($estoque_menu_id)) {
            $this->instanciar($estoque_menu_id);
        }
    }

    function contador($estoque_menu_id) {
        $this->db->select();
        $this->db->from('tb_estoque_menu_produtos');
        $this->db->where('menu_id', $estoque_menu_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarmenus($estoque_menu_id) {
        $this->db->select('ep.descricao, mp.estoque_menu_produtos_id');
        $this->db->from('tb_estoque_menu_produtos mp');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = mp.produto');
        $this->db->where('mp.ativo', 'true');
        $this->db->where('menu_id', $estoque_menu_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    
    function listarprodutos() {
        $this->db->select('p.estoque_produto_id,
                            p.descricao');
        $this->db->from('tb_estoque_produto p');
        $this->db->where('p.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $this->db->select('estoque_menu_id,
                            descricao');
        $this->db->from('tb_estoque_menu');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarmenu($estoque_menu_id) {
        $this->db->select('estoque_menu_id,
                            descricao');
        $this->db->from('tb_estoque_menu');
        $this->db->where('ativo', 'true');
        $this->db->where('estoque_menu_id', $estoque_menu_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    function carregarmenu($estoque_menu_id) {
        $this->db->select('estoque_menu_id,
                            descricao');
        $this->db->from('tb_estoque_menu');
        $this->db->where('estoque_menu_id', $estoque_menu_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_menu_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_menu_id', $estoque_menu_id);
        $this->db->update('tb_estoque_menu');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_menu_id = $_POST['txtestoquemenuid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoquemenuid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_menu');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_menu_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_menu_id = $_POST['txtestoquemenuid'];
                $this->db->where('estoque_menu_id', $estoque_menu_id);
                $this->db->update('tb_estoque_menu');
            }
            return $estoque_menu_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    
    function excluirmenu($estoque_menu_produtos_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_menu_produtos_id', $estoque_menu_produtos_id);
        $this->db->update('tb_estoque_menu_produtos');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }
    
    function gravaritens() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('menu_id', $_POST['txtestoque_menu_id']);
            $this->db->set('produto', $_POST['produto_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_menu_produtos');
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

    private function instanciar($estoque_menu_id) {

        if ($estoque_menu_id != 0) {
            $this->db->select('estoque_menu_id, descricao');
            $this->db->from('tb_estoque_menu');
            $this->db->where("estoque_menu_id", $estoque_menu_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_menu_id = $estoque_menu_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_menu_id = null;
        }
    }

}

?>
