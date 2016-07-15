<?php

class indicacao_model extends Model {

    var $_paciente_indicacao_id = null;
    var $_nome = null;

    function Indicacao_model($paciente_indicacao_id = null) {
        parent::Model();
        if (isset($paciente_indicacao_id)) {
            $this->instanciar($paciente_indicacao_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('paciente_indicacao_id,
                            aml.nome');
        $this->db->from('tb_paciente_indicacao aml');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('aml.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($paciente_indicacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_indicacao_id', $paciente_indicacao_id);
        $this->db->update('tb_paciente_indicacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $paciente_indicacao_id = $_POST['paciente_indicacao_id'];
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['paciente_indicacao_id'] == "") {// insert
                $this->db->insert('tb_paciente_indicacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $paciente_indicacao_id = $this->db->insert_id();
            }
            else { // update
                $this->db->where('paciente_indicacao_id', $paciente_indicacao_id);
                $this->db->update('tb_paciente_indicacao');
            }
            return $paciente_indicacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($paciente_indicacao_id) {
        if ($paciente_indicacao_id != 0) {
            $this->db->select('paciente_indicacao_id,
                            aml.nome');
            $this->db->from('tb_paciente_indicacao aml');
            $this->db->where("paciente_indicacao_id", $paciente_indicacao_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_paciente_indicacao_id = $paciente_indicacao_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_paciente_indicacao_id = null;
        }
    }

}

?>
