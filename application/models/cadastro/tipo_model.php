<?php

class tipo_model extends Model {

    var $_tipo_entradas_saida_id = null;
    var $_descricao = null;

    function Tipo_model($tipo_entradas_saida_id = null) {
        parent::Model();
        if (isset($tipo_entradas_saida_id)) {
            $this->instanciar($tipo_entradas_saida_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('tipo_entradas_saida_id,
                            descricao');
        $this->db->from('tb_tipo_entradas_saida');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listartipo() {
        $this->db->select('tipo_entradas_saida_id,
                            descricao');
        $this->db->from('tb_tipo_entradas_saida');
        $this->db->where('ativo', 'true');
        $this->db->orderby('descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function buscartipo($tipo_entradas_saida_id) {
        $this->db->select('tipo_entradas_saida_id,
                            descricao');
        $this->db->from('tb_tipo_entradas_saida');
        $this->db->where('tipo_entradas_saida_id', "$tipo_entradas_saida_id");
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function buscartiporelatorio($descricao) {
        $this->db->select('tipo_entradas_saida_id,
                            descricao');
        $this->db->from('tb_tipo_entradas_saida');
        $this->db->where('descricao', "$descricao");
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($tipo_entradas_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('tipo_entradas_saida_id', $tipo_entradas_saida_id);
        $this->db->update('tb_tipo_entradas_saida');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $tipo_entradas_saida_id = $_POST['txtcadastrostipoid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtcadastrostipoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_tipo_entradas_saida');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $tipo_entradas_saida_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_tipo_id = $_POST['txtcadastrostipoid'];
                $this->db->where('tipo_entradas_saida_id', $tipo_entradas_saida_id);
                $this->db->update('tb_tipo_entradas_saida');
            }
            return $tipo_entradas_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($tipo_entradas_saida_id) {

        if ($tipo_entradas_saida_id != 0) {
            $this->db->select('tipo_entradas_saida_id, descricao');
            $this->db->from('tb_tipo_entradas_saida');
            $this->db->where("tipo_entradas_saida_id", $tipo_entradas_saida_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_tipo_entradas_saida_id = $tipo_entradas_saida_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_tipo_entradas_saida_id = null;
        }
    }

}

?>
