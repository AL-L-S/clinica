<?php

class grupoconvenio_model extends Model {

    var $_convenio_grupo_id = null;
    var $_nome = null;

    function Grupoconvenio_model($convenio_grupo_id = null) {
        parent::Model();
        if (isset($convenio_grupo_id)) {
            $this->instanciar($convenio_grupo_id);
        }
    }

    function listar($args = array()) {

        $this->db->select('convenio_grupo_id,
                            nome');
        $this->db->from('tb_convenio_grupo');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listargrupoconvenios() {

        $this->db->select('convenio_grupo_id,
                            nome');
        $this->db->from('tb_convenio_grupo');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupoconvenio($convenio_grupo_id) {

        $this->db->select('convenio_grupo_id,
                            nome');
        $this->db->from('tb_convenio_grupo');
        $this->db->where('exame_grupoconvenio_id', $convenio_grupo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($convenio_grupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('convenio_grupo_id', $convenio_grupo_id);
        $this->db->update('tb_convenio_grupo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $convenio_grupo_id = $_POST['grupoconvenioid'];
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['grupoconvenioid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_convenio_grupo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $convenio_grupo_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $convenio_grupo_id = $_POST['grupoconvenioid'];
                $this->db->where('convenio_grupo_id', $convenio_grupo_id);
                $this->db->update('tb_convenio_grupo');
            }
            return $convenio_grupo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($convenio_grupo_id) {

        if ($convenio_grupo_id != 0) {
            $this->db->select('convenio_grupo_id, nome');
            $this->db->from('tb_convenio_grupo');
            $this->db->where("convenio_grupo_id", $convenio_grupo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_convenio_grupo_id = $convenio_grupo_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_convenio_grupo_id = null;
        }
    }

}

?>
