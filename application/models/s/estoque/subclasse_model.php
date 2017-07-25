<?php

class subclasse_model extends Model {

    var $_estoque_sub_classe_id = null;
    var $_descricao = null;
    var $_tipo_id = null;

    function Subclasse_model($estoque_sub_classe_id = null) {
        parent::Model();
        if (isset($estoque_sub_classe_id)) {
            $this->instanciar($estoque_sub_classe_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('sc.estoque_sub_classe_id,
                            sc.descricao,
                            sc.classe_id,
                            c.descricao as classe');
        $this->db->from('tb_estoque_sub_classe sc');
        $this->db->join('tb_estoque_classe c', 'c.estoque_classe_id = sc.classe_id', 'left');
        $this->db->where('sc.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }
    
    
    function listartipo() {
        $this->db->select('estoque_classe_id as classe_id,
                            descricao');
        $this->db->from('tb_estoque_classe');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_sub_classe_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_sub_classe_id', $estoque_sub_classe_id);
        $this->db->update('tb_estoque_sub_classe');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_sub_classe_id = $_POST['txtestoquesub_classeid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $this->db->set('classe_id', $_POST['txtclasse_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoquesub_classeid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_sub_classe');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_sub_classe_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_sub_classe_id = $_POST['txtestoquesub_classeid'];
                $this->db->where('estoque_sub_classe_id', $estoque_sub_classe_id);
                $this->db->update('tb_estoque_sub_classe');
            }
            return $estoque_sub_classe_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_sub_classe_id) {

        if ($estoque_sub_classe_id != 0) {
            $this->db->select('estoque_sub_classe_id, descricao, classe_id');
            $this->db->from('tb_estoque_sub_classe');
            $this->db->where("estoque_sub_classe_id", $estoque_sub_classe_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_sub_classe_id = $estoque_sub_classe_id;
            $this->_descricao = $return[0]->descricao;
            $this->_classe_id = $return[0]->classe_id;
        } else {
            $this->_estoque_sub_classe_id = null;
        }
    }

}

?>
