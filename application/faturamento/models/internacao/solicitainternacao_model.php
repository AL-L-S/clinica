<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class solicitainternacao_model extends BaseModel {

    var $_internacao_solicitacao_id = null;
    var $_paciente_id = null;
    var $_unidade_id = null;
    var $_estado = null;
    var $_data_cadastro = null;
    var $_nome = null;
    var $_unidade = null;

    function solicitainternacao_model($internacao_solicitacao_id = null) {
        parent::Model();
        if (isset($internacao_solicitacao_id)) {
            $this->instanciar($internacao_solicitacao_id);
        }
    }

    private function instanciar($internacao_solicitacao_id) {
        if ($internacao_solicitacao_id != 0) {
        $this->db->select(' iso.internacao_solicitacao_id,
                            p.nome as paciente,
                            p.idade,
                            iso.paciente_id,
                            iu.nome as unidade,
                            iso.unidade_id,
                            iso.estado,
                            iso.data_cadastro');
        $this->db->from('tb_internacao_solicitacao iso');
        $this->db->join('tb_paciente p', 'p.paciente_id = iso.paciente_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = iso.unidade_id ');
            $this->db->where('is.internacao_solicitacao_id', $internacao_solicitacao_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_internacao_solicitacao_id = $internacao_solicitacao_id;
            $this->_nome = $return[0]->nome;
            $this->_estado = $return[0]->estado;
            $this->_paciente = $return[0]->paciente;
            $this->_unidade = $return[0]->unidade;
            $this->_unidade_id = $return[0]->unidade_id;
            $this->_data_cadastro = $return[0]->data_cadastro;
        }
    }

    function gravarsolicitacaointernacao($paciente_id) {

        try {
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('estado', $_POST['estado']);
            $this->db->set('unidade_id', $_POST['UnidadeID']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_solicitacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_solicitacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                }
                else
                    $internacao_leito_id = $this->db->insert_id();
            }
            else { // update
                $internacao_leito_id = $_POST['internacao_solicitacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_leito_id', $internacao_leito_id);
                $this->db->update('tb_internacao_solicitacao');
            }


            return $internacao_leito_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listasolicitacao($args = array()) {
        $this->db->select(' iso.internacao_solicitacao_id,
                            p.nome as paciente,
                            p.idade,
                            iso.paciente_id,
                            iu.nome as unidade,
                            iso.unidade_id,
                            iso.estado,
                            iso.data_cadastro');
        $this->db->from('tb_internacao_solicitacao iso');
        $this->db->join('tb_paciente p', 'p.paciente_id = iso.paciente_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = iso.unidade_id ');
        $this->db->where('iso.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('iso.paciente_id', $args['nome']);
                $this->db->orwhere('iu.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('iso.estado ilike', "%" . $args['nome'] . "%");
            }
        }
        return $this->db;
    }
    
    
    function verificasolicitacao($paciente_id) {
        $this->db->select();
        $this->db->from('tb_internacao_solicitacao');
        $this->db->where("ativo", 'true');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

}

?>
