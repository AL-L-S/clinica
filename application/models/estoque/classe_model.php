<?php

class classe_model extends Model {

    var $_estoque_classe_id = null;
    var $_descricao = null;
    var $_tipo_id = null;

    function Classe_model($estoque_classe_id = null) {
        parent::Model();
        if (isset($estoque_classe_id)) {
            $this->instanciar($estoque_classe_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('c.estoque_classe_id,
                            c.descricao,
                            c.tipo_id,
                            t.descricao as tipo');
        $this->db->from('tb_estoque_classe c');
        $this->db->join('tb_estoque_tipo t', 't.estoque_tipo_id = c.tipo_id', 'left');
        $this->db->where('c.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('c.descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }
    
    
    function listartipo() {
        $this->db->select('estoque_tipo_id as tipo_id,
                            descricao');
        $this->db->from('tb_estoque_tipo');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_classe_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_classe_id', $estoque_classe_id);
        $this->db->update('tb_estoque_classe');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_classe_id = $_POST['txtestoqueclasseid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $this->db->set('tipo_id', $_POST['txttipo_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoqueclasseid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_classe');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_classe_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_classe_id = $_POST['txtestoqueclasseid'];
                $this->db->where('estoque_classe_id', $estoque_classe_id);
                $this->db->update('tb_estoque_classe');
            }
            return $estoque_classe_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_classe_id) {

        if ($estoque_classe_id != 0) {
            $this->db->select('estoque_classe_id, descricao, tipo_id');
            $this->db->from('tb_estoque_classe');
            $this->db->where("estoque_classe_id", $estoque_classe_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_classe_id = $estoque_classe_id;
            $this->_descricao = $return[0]->descricao;
            $this->_tipo_id = $return[0]->tipo_id;
        } else {
            $this->_estoque_classe_id = null;
        }
    }

}

?>
