<?php

class classificacao_model extends Model {

    var $_tuss_classificacao_id = null;
    var $_nome = null;

    function Classificacao_model($tuss_classificacao_id = null) {
        parent::Model();
        if (isset($tuss_classificacao_id)) {
            $this->instanciar($tuss_classificacao_id);
        }
    }

    function listar($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('tuss_classificacao_id,
                            nome');
        $this->db->from('tb_tuss_classificacao');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($tuss_classificacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('tuss_classificacao_id', $tuss_classificacao_id);
        $this->db->update('tb_tuss_classificacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            

            $empresa_id = $this->session->userdata('empresa_id');
            $tuss_classificacao_id = $_POST['txtexameclassificacaoid'];
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtexameclassificacaoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_tuss_classificacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $tuss_classificacao_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $tuss_classificacao_id = $_POST['txtexameclassificacaoid'];
                $this->db->where('tuss_classificacao_id', $tuss_classificacao_id);
                $this->db->update('tb_tuss_classificacao');
            }
            return $tuss_classificacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function ativar($tuss_classificacao_id) {
        try {
            /* inicia o mapeamento no banco */

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ativo', 't');
            $this->db->where('tuss_classificacao_id', $tuss_classificacao_id);
            $this->db->update('tb_tuss_classificacao');
            return $tuss_classificacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($tuss_classificacao_id) {

        if ($tuss_classificacao_id != 0) {
            $this->db->select('tuss_classificacao_id, nome');
            $this->db->from('tb_tuss_classificacao');
            $this->db->where("tuss_classificacao_id", $tuss_classificacao_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_tuss_classificacao_id = $tuss_classificacao_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_tuss_classificacao_id = null;
        }
    }

}

?>
