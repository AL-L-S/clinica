<?php

class unidade_model extends Model {

    var $_estoque_unidade_id = null;
    var $_descricao = null;

    function Unidade_model($estoque_unidade_id = null) {
        parent::Model();
        if (isset($estoque_unidade_id)) {
            $this->instanciar($estoque_unidade_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('estoque_unidade_id,
                            descricao');
        $this->db->from('tb_estoque_unidade');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($estoque_unidade_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_unidade_id', $estoque_unidade_id);
        $this->db->update('tb_estoque_unidade');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_unidade_id = $_POST['txtestoqueunidadeid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoqueunidadeid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_unidade');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_unidade_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_unidade_id = $_POST['txtestoqueunidadeid'];
                $this->db->where('estoque_unidade_id', $estoque_unidade_id);
                $this->db->update('tb_estoque_unidade');
            }
            return $estoque_unidade_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_unidade_id) {

        if ($estoque_unidade_id != 0) {
            $this->db->select('estoque_unidade_id, descricao');
            $this->db->from('tb_estoque_unidade');
            $this->db->where("estoque_unidade_id", $estoque_unidade_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_unidade_id = $estoque_unidade_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_unidade_id = null;
        }
    }

}

?>
