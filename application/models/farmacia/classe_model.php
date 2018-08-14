<?php

class classe_model extends Model {

    var $_farmacia_classe_id = null;
    var $_descricao = null;
    var $_tipo_id = null;

    function Classe_model($farmacia_classe_id = null) {
        parent::Model();
        if (isset($farmacia_classe_id)) {
            $this->instanciar($farmacia_classe_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('c.farmacia_classe_id,
                            c.descricao,
                            c.tipo_id,
                            t.descricao as tipo');
        $this->db->from('tb_farmacia_classe c');
        $this->db->join('tb_farmacia_tipo t', 't.farmacia_tipo_id = c.tipo_id', 'left');
        $this->db->where('c.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('c.descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }
    
    
    function listartipo() {
        $this->db->select('farmacia_tipo_id as tipo_id,
                            descricao');
        $this->db->from('tb_farmacia_tipo');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($farmacia_classe_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_classe_id', $farmacia_classe_id);
        $this->db->update('tb_farmacia_classe');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $farmacia_classe_id = $_POST['txtfarmaciaclasseid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $this->db->set('tipo_id', $_POST['txttipo_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtfarmaciaclasseid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_farmacia_classe');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $farmacia_classe_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_classe_id = $_POST['txtfarmaciaclasseid'];
                $this->db->where('farmacia_classe_id', $farmacia_classe_id);
                $this->db->update('tb_farmacia_classe');
            }
            return $farmacia_classe_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($farmacia_classe_id) {

        if ($farmacia_classe_id != 0) {
            $this->db->select('farmacia_classe_id, descricao, tipo_id');
            $this->db->from('tb_farmacia_classe');
            $this->db->where("farmacia_classe_id", $farmacia_classe_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_farmacia_classe_id = $farmacia_classe_id;
            $this->_descricao = $return[0]->descricao;
            $this->_tipo_id = $return[0]->tipo_id;
        } else {
            $this->_farmacia_classe_id = null;
        }
    }

}

?>
