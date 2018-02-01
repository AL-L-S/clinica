<?php

class armazem_model extends Model {

    var $_farmacia_armazem_id = null;
    var $_descricao = null;

    function Armazem_model($farmacia_armazem_id = null) {
        parent::Model();
        if (isset($farmacia_armazem_id)) {
            $this->instanciar($farmacia_armazem_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('farmacia_armazem_id,
                            descricao');
        $this->db->from('tb_farmacia_armazem');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($farmacia_armazem_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_armazem_id', $farmacia_armazem_id);
        $this->db->update('tb_farmacia_armazem');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $farmacia_armazem_id = $_POST['txtfarmaciaarmazemid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtfarmaciaarmazemid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_farmacia_armazem');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $farmacia_armazem_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_armazem_id = $_POST['txtfarmaciaarmazemid'];
                $this->db->where('farmacia_armazem_id', $farmacia_armazem_id);
                $this->db->update('tb_farmacia_armazem');
            }
            return $farmacia_armazem_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($farmacia_armazem_id) {

        if ($farmacia_armazem_id != 0) {
            $this->db->select('farmacia_armazem_id, descricao');
            $this->db->from('tb_farmacia_armazem');
            $this->db->where("farmacia_armazem_id", $farmacia_armazem_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_farmacia_armazem_id = $farmacia_armazem_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_farmacia_armazem_id = null;
        }
    }

}

?>
