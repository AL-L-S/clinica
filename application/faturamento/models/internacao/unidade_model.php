<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class unidade_model extends BaseModel {

    var $_internacao_unidade_id = null;
    var $_localizacao = null;
    var $_nome = null;

    function unidade_model($internacao_unidade_id = null) {
        parent::Model();
        if (isset($internacao_unidade_id)) {
            $this->instanciar($internacao_unidade_id);
        }
    }

    private function instanciar($internacao_unidade_id) {
        if ($internacao_unidade_id != 0) {

            $this->db->select('internacao_unidade_id,
                            nome,
                            localizacao');
            $this->db->from('tb_internacao_unidade');
            $this->db->where('ativo', 'true');
            $this->db->where('internacao_unidade_id', $internacao_unidade_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_internacao_unidade_id= $internacao_unidade_id;
            $this->_localizacao = $return[0]->localizacao;
            $this->_nome = $return[0]->nome;
        }
    }

    function listaunidade($args = array()) {
        $this->db->select(' internacao_unidade_id,
                            nome,
                            localizacao');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('nome ilike', "%" . $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listaunidadeautocomplete($parametro = null) {
        $this->db->select('internacao_unidade_id,
                            nome,
                            localizacao');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function gravarunidade() {

        try {
            $this->db->set('nome', $_POST['nome']);
            $this->db->set('localizacao', $_POST['localizacao']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_unidade_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_unidade');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                }
                else
                    $internacao_unidade_id = $this->db->insert_id();
            }
            else { // update
                $internacao_unidade_id = $_POST['internacao_unidade_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_unidade_id', $internacao_unidade_id);
                $this->db->update('tb_internacao_unidade');
            }


            return $internacao_unidade_id;
        } catch (Exception $exc) {
            return false;
        }
    }

}

?>
