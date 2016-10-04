<?php

class formapagamento_model extends Model {

    var $_forma_pagamento_id = null;
    var $_nome = null;
    var $_conta_id = null;
    var $_ajuste = null;


    function Formapagamento_model($forma_pagamento_id = null) {
        parent::Model();
        if (isset($forma_pagamento_id)) {
            $this->instanciar($forma_pagamento_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('forma_pagamento_id,
                            nome, 
                            ');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarforma() {
        $this->db->select('forma_pagamento_id,
                            nome');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarforma($forma_pagamento_id) {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_pagamento_id', "$forma_pagamento_id");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($forma_pagamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('forma_pagamento_id', $forma_pagamento_id);
        $this->db->update('tb_forma_pagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('conta_id', $_POST['conta']);
            $this->db->set('ajuste', $_POST['ajuste']);
//            $this->db->set('ativo', 't');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtcadastrosformapagamentoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_forma_pagamento');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $forma_pagamento_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
//                $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
                $this->db->where('forma_pagamento_id', $forma_pagamento_id);
                $this->db->update('tb_forma_pagamento');
            }
            return $forma_pagamento_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($forma_pagamento_id) {

        if ($forma_pagamento_id != 0) {
            $this->db->select('forma_pagamento_id, nome, conta_id , ajuste');
            $this->db->from('tb_forma_pagamento');
            $this->db->where("forma_pagamento_id", $forma_pagamento_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_forma_pagamento_id = $forma_pagamento_id;
            $this->_nome = $return[0]->nome;
            $this->_conta_id = $return[0]->conta_id;
            $this->_ajuste = $return[0]->ajuste;
        } else {
            $this->_forma_pagamento_id = null;
        }
    }

}

?>
