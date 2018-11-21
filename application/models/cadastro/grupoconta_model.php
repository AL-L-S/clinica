<?php

class grupoconta_model extends Model {

    var $_operador_grupo_id = null;
    var $_nome = null;

    function Grupoconta_model($operador_grupo_id = null) {
        parent::Model();
        if (isset($operador_grupo_id)) {
            $this->instanciar($operador_grupo_id);
        }
    }

//    function listar($args = array()) {
//
//        $this->db->select('operador_grupo_id,
//                            nome');
//        $this->db->from('tb_operador_grupo');
//        if (isset($args['nome']) && strlen($args['nome']) > 0) {
//            $this->db->where('nome ilike', $args['nome'] . "%");
//        }
//        $this->db->where('ativo', 't');
//        return $this->db;
//    }
//
//    function listargrupomedicos() {
//
//        $this->db->select('operador_grupo_id,
//                            nome');
//        $this->db->from('tb_operador_grupo');
//        $this->db->where('ativo', 't');
//        $this->db->orderby('nome');
//        $return = $this->db->get();
//        return $return->result();
//    }
//
//    function listargrupomedico($operador_grupo_id) {
//
//        $this->db->select('operador_grupo_id,
//                            nome');
//        $this->db->from('tb_operador_grupo');
//        $this->db->where('exame_grupomedico_id', $operador_grupo_id);
//        $return = $this->db->get();
//        return $return->result();
//    }
//
//    function listargrupomedicoadicionar($operador_grupo_id) {
//
//        $this->db->select('operador_grupo_id,
//                            o.nome as operador,
//                            operador_grupo_medico_id,
//                            opm.operador_id');
//        $this->db->from('tb_operador_grupo_medico opm');
//        $this->db->join('tb_operador o', 'o.operador_id = opm.operador_id');
//        $this->db->where('operador_grupo_id', $operador_grupo_id);
//        $this->db->where('opm.ativo', 't');
//        $return = $this->db->get();
//        return $return->result();
//    }
//    
//    function listargrupomedicoadicionarteste() {
//
//        $this->db->select('operador_grupo_id,
//                            o.nome as operador,
//                            opm.operador_id');
//        $this->db->from('tb_operador_grupo_medico opm');
//        $this->db->join('tb_operador o', 'o.operador_id = opm.operador_id');
//        $this->db->where('operador_grupo_id', $_POST['grupomedicoid']);
//        $this->db->where('opm.operador_id', $_POST['medico']);
//        $return = $this->db->get();
//        return $return->result();
//    }
//
//    function excluir($operador_grupo_id) {
//
//        $horario = date("Y-m-d H:i:s");
//        $operador_id = $this->session->userdata('operador_id');
//        $this->db->set('ativo', 'f');
//        $this->db->set('data_atualizacao', $horario);
//        $this->db->set('operador_atualizacao', $operador_id);
//        $this->db->where('operador_grupo_id', $operador_grupo_id);
//        $this->db->update('tb_operador_grupo');
//        $erro = $this->db->_error_message();
//        if (trim($erro) != "") // erro de banco
//            return false;
//        else
//            return true;
//    }
//    
//    function excluirmedicogrupo($operador_grupo_medico_id) {
//
//        $horario = date("Y-m-d H:i:s");
//        $operador_id = $this->session->userdata('operador_id');
//        $this->db->set('ativo', 'f');
//        $this->db->set('data_atualizacao', $horario);
//        $this->db->set('operador_atualizacao', $operador_id);
////        $this->db->where('operador_id', $operador_excluir_id);
//        $this->db->where('operador_grupo_medico_id', $operador_grupo_medico_id);
//        $this->db->update('tb_operador_grupo_medico');
//        $erro = $this->db->_error_message();
//        if (trim($erro) != "") // erro de banco
//            return false;
//        else
//            return true;
//    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $operador_grupo_id = $_POST['grupomedicoid'];
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['grupomedicoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_operador_grupo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $operador_grupo_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $operador_grupo_id = $_POST['grupomedicoid'];
                $this->db->where('operador_grupo_id', $operador_grupo_id);
                $this->db->update('tb_operador_grupo');
            }
            return $operador_grupo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

//    function gravaradicionar() {
//        try {
//            /* inicia o mapeamento no banco */
//            $operador_grupo_id = $_POST['grupomedicoid'];
//            $horario = date("Y-m-d H:i:s");
//            $operador_id = $this->session->userdata('operador_id');
//
//            $this->db->set('nome', $_POST['txtNome']);
//            $this->db->set('data_atualizacao', $horario);
//            $this->db->set('operador_atualizacao', $operador_id);
//            $this->db->where('operador_grupo_id', $operador_grupo_id);
//            $this->db->update('tb_operador_grupo');
//
//
//            if($_POST['medico'] != '') {
//                $this->db->set('operador_id', $_POST['medico']);
//                $this->db->set('operador_grupo_id', $operador_grupo_id);
//                $this->db->set('data_cadastro', $horario);
//                $this->db->set('operador_cadastro', $operador_id);
//                $this->db->insert('tb_operador_grupo_medico');
//            }
//            return $operador_grupo_id;
//        } catch (Exception $exc) {
//            return -1;
//        }
//    }

    private function instanciar($conta_grupo_id) {

        if ($conta_grupo_id != 0) {
            $this->db->select('conta_grupo_id, nome');
            $this->db->from('tb_conta_grupo');
            $this->db->where("conta_grupo_id", $conta_grupo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_conta_grupo_id = $conta_grupo_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_conta_grupo_id = null;
        }
    }

}

?>

