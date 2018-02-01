<?php

class menu_model extends Model {

    var $_farmacia_menu_id = null;
    var $_descricao = null;

    function Menu_model($farmacia_menu_id = null) {
        parent::Model();
        if (isset($farmacia_menu_id)) {
            $this->instanciar($farmacia_menu_id);
        }
    }

    function contador($farmacia_menu_id) {
        $this->db->select();
        $this->db->from('tb_farmacia_menu_produtos');
        $this->db->where('menu_id', $farmacia_menu_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarmenus($farmacia_menu_id) {
        $this->db->select('ep.descricao, mp.farmacia_menu_produtos_id');
        $this->db->from('tb_farmacia_menu_produtos mp');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = mp.produto');
        $this->db->where('mp.ativo', 'true');
        $this->db->where('menu_id', $farmacia_menu_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    
    function listarprodutos() {
        $this->db->select('p.farmacia_produto_id,
                            p.descricao');
        $this->db->from('tb_farmacia_produto p');
        $this->db->where('p.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $this->db->select('farmacia_menu_id,
                            descricao');
        $this->db->from('tb_farmacia_menu');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarmenu($farmacia_menu_id) {
        $this->db->select('farmacia_menu_id,
                            descricao');
        $this->db->from('tb_farmacia_menu');
        $this->db->where('ativo', 'true');
        $this->db->where('farmacia_menu_id', $farmacia_menu_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    function carregarmenu($farmacia_menu_id) {
        $this->db->select('farmacia_menu_id,
                            descricao');
        $this->db->from('tb_farmacia_menu');
        $this->db->where('farmacia_menu_id', $farmacia_menu_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($farmacia_menu_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_menu_id', $farmacia_menu_id);
        $this->db->update('tb_farmacia_menu');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $farmacia_menu_id = $_POST['txtfarmaciamenuid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtfarmaciamenuid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_farmacia_menu');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $farmacia_menu_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_menu_id = $_POST['txtfarmaciamenuid'];
                $this->db->where('farmacia_menu_id', $farmacia_menu_id);
                $this->db->update('tb_farmacia_menu');
            }
            return $farmacia_menu_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    
    function excluirmenu($farmacia_menu_produtos_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_menu_produtos_id', $farmacia_menu_produtos_id);
        $this->db->update('tb_farmacia_menu_produtos');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }
    
    function gravaritens() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('menu_id', $_POST['txtfarmacia_menu_id']);
            $this->db->set('produto', $_POST['produto_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_farmacia_menu_produtos');
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

    private function instanciar($farmacia_menu_id) {

        if ($farmacia_menu_id != 0) {
            $this->db->select('farmacia_menu_id, descricao');
            $this->db->from('tb_farmacia_menu');
            $this->db->where("farmacia_menu_id", $farmacia_menu_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_farmacia_menu_id = $farmacia_menu_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_farmacia_menu_id = null;
        }
    }

}

?>
