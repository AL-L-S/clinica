<?php

class tipoconsulta_model extends Model {

    var $_ambulatorio_tipo_consulta_id = null;
    var $_descricao = null;

    function tipoconsulta_model($ambulatorio_tipo_consulta_id = null) {
        parent::Model();
        if (isset($ambulatorio_tipo_consulta_id)) {
            $this->instanciar($ambulatorio_tipo_consulta_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('ambulatorio_tipo_consulta_id,
                            descricao');
        $this->db->from('tb_ambulatorio_tipo_consulta');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }
    
    function listarcalendario($args = array()) {
        $this->db->select('ambulatorio_tipo_consulta_id,
                            descricao');
        $this->db->from('tb_ambulatorio_tipo_consulta');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listartodos() {
        $this->db->select('ambulatorio_tipo_consulta_id,
                            descricao');
        $this->db->from('tb_ambulatorio_tipo_consulta');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($ambulatorio_tipo_consulta_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_tipo_consulta_id', $ambulatorio_tipo_consulta_id);
        $this->db->update('tb_ambulatorio_tipo_consulta');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $ambulatorio_tipo_consulta_id = $_POST['tipo_consulta_id'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['tipo_consulta_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_tipo_consulta');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $ambulatorio_tipo_consulta_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_tipoconsulta_id = $_POST['txtambulatoriotipoconsultaid'];
                $this->db->where('ambulatorio_tipo_consulta_id', $ambulatorio_tipo_consulta_id);
                $this->db->update('tb_ambulatorio_tipo_consulta');
            }
            return $ambulatorio_tipo_consulta_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_tipo_consulta_id) {

        if ($ambulatorio_tipo_consulta_id != 0) {
            $this->db->select('ambulatorio_tipo_consulta_id, descricao');
            $this->db->from('tb_ambulatorio_tipo_consulta');
            $this->db->where("ambulatorio_tipo_consulta_id", $ambulatorio_tipo_consulta_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_tipo_consulta_id = $ambulatorio_tipo_consulta_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_ambulatorio_tipo_consulta_id = null;
        }
    }

}

?>
