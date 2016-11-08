<?php

class forma_model extends Model {

    var $_forma_entradas_saida_id = null;
    var $_descricao = null;
    var $_conta = null;
    var $_agencia = null;

    function Forma_model($forma_entradas_saida_id = null) {
        parent::Model();
        if (isset($forma_entradas_saida_id)) {
            $this->instanciar($forma_entradas_saida_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('forma_entradas_saida_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarforma() {
        $this->db->select('forma_entradas_saida_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarforma($forma_entradas_saida_id) {
        $this->db->select('forma_entradas_saida_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_entradas_saida_id', "$forma_entradas_saida_id");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($forma_entradas_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('forma_entradas_saida_id', $forma_entradas_saida_id);
        $this->db->update('tb_forma_entradas_saida');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $forma_entradas_saida_id = $_POST['txtcadastrosformaid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $this->db->set('agencia', $_POST['txtagencia']);
            $this->db->set('conta', $_POST['txtconta']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtcadastrosformaid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_forma_entradas_saida');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $forma_entradas_saida_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_forma_id = $_POST['txtcadastrosformaid'];
                $this->db->where('forma_entradas_saida_id', $forma_entradas_saida_id);
                $this->db->update('tb_forma_entradas_saida');
            }
            return $forma_entradas_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($forma_entradas_saida_id) {

        if ($forma_entradas_saida_id != 0) {
            $this->db->select('forma_entradas_saida_id, descricao, conta, agencia');
            $this->db->from('tb_forma_entradas_saida');
            $this->db->where("forma_entradas_saida_id", $forma_entradas_saida_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_forma_entradas_saida_id = $forma_entradas_saida_id;
            $this->_descricao = $return[0]->descricao;
            $this->_agencia = $return[0]->agencia;
            $this->_conta = $return[0]->conta;
        } else {
            $this->_forma_entradas_saida_id = null;
        }
    }

}

?>
