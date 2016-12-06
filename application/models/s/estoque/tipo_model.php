<?php

class tipo_model extends Model {

    var $_estoque_tipo_id = null;
    var $_descricao = null;

    function Tipo_model($estoque_tipo_id = null) {
        parent::Model();
        if (isset($estoque_tipo_id)) {
            $this->instanciar($estoque_tipo_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('estoque_tipo_id,
                            descricao');
        $this->db->from('tb_estoque_tipo');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($estoque_tipo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_tipo_id', $estoque_tipo_id);
        $this->db->update('tb_estoque_tipo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_tipo_id = $_POST['txtestoquetipoid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoquetipoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_tipo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_tipo_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_tipo_id = $_POST['txtestoquetipoid'];
                $this->db->where('estoque_tipo_id', $estoque_tipo_id);
                $this->db->update('tb_estoque_tipo');
            }
            return $estoque_tipo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_tipo_id) {

        if ($estoque_tipo_id != 0) {
            $this->db->select('estoque_tipo_id, descricao');
            $this->db->from('tb_estoque_tipo');
            $this->db->where("estoque_tipo_id", $estoque_tipo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_tipo_id = $estoque_tipo_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_tipo_id = null;
        }
    }

}

?>
