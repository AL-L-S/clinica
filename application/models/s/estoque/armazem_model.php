<?php

class armazem_model extends Model {

    var $_estoque_armazem_id = null;
    var $_descricao = null;

    function Armazem_model($estoque_armazem_id = null) {
        parent::Model();
        if (isset($estoque_armazem_id)) {
            $this->instanciar($estoque_armazem_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('estoque_armazem_id,
                            descricao');
        $this->db->from('tb_estoque_armazem');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($estoque_armazem_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_armazem_id', $estoque_armazem_id);
        $this->db->update('tb_estoque_armazem');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_armazem_id = $_POST['txtestoquearmazemid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoquearmazemid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_armazem');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_armazem_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_armazem_id = $_POST['txtestoquearmazemid'];
                $this->db->where('estoque_armazem_id', $estoque_armazem_id);
                $this->db->update('tb_estoque_armazem');
            }
            return $estoque_armazem_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_armazem_id) {

        if ($estoque_armazem_id != 0) {
            $this->db->select('estoque_armazem_id, descricao');
            $this->db->from('tb_estoque_armazem');
            $this->db->where("estoque_armazem_id", $estoque_armazem_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_armazem_id = $estoque_armazem_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_armazem_id = null;
        }
    }

}

?>
