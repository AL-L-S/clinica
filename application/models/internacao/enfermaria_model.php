<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class enfermaria_model extends BaseModel {

    var $_internacao_enfermaria_id = null;
    var $_nome = null;
    var $_tipo = null;
    var $_localizacao = null;
    var $_unidade_nome = null;
    var $_unidade = null;

    function enfermaria_model($internacao_enfermaria_id = null) {
        parent::Model();
        if (isset($internacao_enfermaria_id)) {
            $this->instanciar($internacao_enfermaria_id);
        }
    }

    private function instanciar($internacao_enfermaria_id) {
        if ($internacao_enfermaria_id != 0) {

            $this->db->select('ie.internacao_enfermaria_id,
                            ie.nome,
                            ie.tipo,
                            ie.localizacao,
                            iu.nome as unidade_nome,
                            iu.internacao_unidade_id as unidade');
            $this->db->from('tb_internacao_enfermaria ie');
            $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
            $this->db->where('ie.internacao_enfermaria_id', $internacao_enfermaria_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_internacao_enfermaria_id = $internacao_enfermaria_id;
            $this->_nome = $return[0]->nome;
            $this->_tipo = $return[0]->tipo;
            $this->_localizacao = $return[0]->localizacao;
            $this->_unidade_nome = $return[0]->unidade_nome;
            $this->_unidade = $return[0]->unidade;
            
        }
    }

    function gravarenfermaria() {

        try {
            $this->db->set('nome', $_POST['nome']);
            $this->db->set('localizacao', $_POST['localizacao']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('unidade_id', $_POST['UnidadeID']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_enfermaria_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_enfermaria');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                }
                else
                    $internacao_enfermaria_id = $this->db->insert_id();
            }
            else { // update
                $internacao_enfermaria_id = $_POST['internacao_enfermaria_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_enfermaria_id', $internacao_enfermaria_id);
                $this->db->update('tb_internacao_enfermaria');
            }


            return $internacao_enfermaria_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listaenfermaria($args = array()) {
        $this->db->select(' ie.internacao_enfermaria_id,
                            ie.nome,
                            iu.nome as unidade,
                            ie.tipo');
        $this->db->from('tb_internacao_enfermaria ie');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('ie.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('ie.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('iu.nome ilike', "%" . $args['nome'] . "%");
            }
        }
        return $this->db;
    }

    function listaenfermariaautocomplete($parametro = null) {
        $this->db->select('ie.internacao_enfermaria_id,
                            ie.nome,
                            iu.nome as unidade');
        $this->db->from('tb_internacao_enfermaria ie');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('ie.ativo', 'true');
        if ($parametro != null) {
            $this->db->where('ie.nome ilike', "%" . $parametro . "%");
            $this->db->orwhere('iu.nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }
    
    function excluirenfermaria($enfermaria_id) {
        $this->db->set('ativo', 'f');
        $this->db->where('internacao_enfermaria_id', $enfermaria_id);
        $this->db->update('tb_internacao_enfermaria');
        $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                }
    }

}

?>
