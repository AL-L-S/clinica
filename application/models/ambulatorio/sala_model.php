<?php

class sala_model extends Model {

    var $_exame_sala_id = null;
    var $_nome = null;
    var $_tipo = null;
    var $_nome_chamada = null;

    function Sala_model($exame_sala_id = null) {
        parent::Model();
        if (isset($exame_sala_id)) {
            $this->instanciar($exame_sala_id);
        }
    }

    function listar($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome, tipo');
        $this->db->from('tb_exame_sala');
        $this->db->where('excluido', 'f');
        $this->db->where('empresa_id', $empresa_id);
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarsalas() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome, tipo');
        $this->db->from('tb_exame_sala');
        $this->db->orderby('nome');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsala($sala_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome, tipo');
        $this->db->from('tb_exame_sala');
        $this->db->where('exame_sala_id', $sala_id);
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($exame_sala_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_sala_id', $exame_sala_id);
        $this->db->update('tb_exame_sala');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirsala($exame_sala_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('excluido', 't');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_sala_id', $exame_sala_id);
        $this->db->update('tb_exame_sala');
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
            $exame_sala_id = $_POST['txtexamesalaid'];
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('nome_chamada', $_POST['txtnomechamada']);
            $this->db->set('tipo', $_POST['tipo']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtexamesalaid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exame_sala');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $exame_sala_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_sala_id = $_POST['txtexamesalaid'];
                $this->db->where('exame_sala_id', $exame_sala_id);
                $this->db->update('tb_exame_sala');
            }
            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function ativar($exame_sala_id) {
        try {
            /* inicia o mapeamento no banco */

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $exame_sala_id);
            $this->db->update('tb_exame_sala');
            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($exame_sala_id) {

        if ($exame_sala_id != 0) {
            $this->db->select('exame_sala_id, nome, tipo, nome_chamada');
            $this->db->from('tb_exame_sala');
            $this->db->where("exame_sala_id", $exame_sala_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_exame_sala_id = $exame_sala_id;
            $this->_nome = $return[0]->nome;
            $this->_tipo = $return[0]->tipo;
            $this->_nome_chamada = $return[0]->nome_chamada;
        } else {
            $this->_exame_sala_id = null;
        }
    }

}

?>
