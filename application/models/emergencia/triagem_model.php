<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class triagem_model extends BaseModel {

    var $_paciente_id = null;
    var $_nome = null;

    function triagem_model($emergencia_triagem_id = null) {
        parent::Model();
        if (isset($emergencia_triagem_id)) {
            $this->instanciar($emergencia_triagem_id);
        }
    }

    function gravarsolicitacaotriagem($paciente_id) {

        try {
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_emergencia_solicitacao_triagem');
            $solicitado_triagem_id = $this->db->insert_id();
            return $solicitado_triagem_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function verificatriagem($paciente_id) {
        $this->db->select();
        $this->db->from('tb_emergencia_solicitacao_triagem');
        $this->db->where("ativo", 'true');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listar($args = array()) {
        $this->db->from('tb_emergencia_solicitacao_triagem')
                ->join('tb_paciente', 'tb_paciente.paciente_id = tb_emergencia_solicitacao_triagem.paciente_id', 'left')
                ->select('"tb_paciente".nome,"tb_emergencia_solicitacao_triagem.*,tb_paciente.nascimento');
        $this->db->where('tb_emergencia_solicitacao_triagem.ativo', 'true');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('tb_paciente.nome ilike', "%" . $args['nome'] . "%");
            }
        }

        return $this->db;
    }

    function gravar($paciente_id) {

        try {
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('gravidade', $_POST['txtgravidade']);
            $this->db->set('descricao', $_POST['txtdescricao']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atendida', $horario);
            $this->db->set('operador_atendimento', $operador_id);
            $this->db->set('ativo', 'false');
            $this->db->insert('tb_emergencia_triagem');
            $triagem_id = $this->db->insert_id();

            $this->db->set('ativo', 'false');
            $this->db->set('data_atendida', $horario);
            $this->db->set('operador_atendimento', $operador_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->where('ativo', 'true');
            $this->db->update('tb_emergencia_solicitacao_triagem');

            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('gravidade', $_POST['txtgravidade']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_emergencia_solicitacao_acolhimento');
            $solicitacao_id = $this->db->insert_id();

            $this->db->set('solicitacao_acolhimento_id', $solicitacao_id);
            $this->db->where('emergencia_triagem_id', $triagem_id);
            $this->db->update('tb_emergencia_triagem');
            return $triagem_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function cancelar($paciente_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'false');
            $this->db->set('data_atendida', $horario);
            $this->db->set('operador_atendimento', $operador_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->where('ativo', 'true');
            $this->db->update('tb_emergencia_solicitacao_triagem');
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

}

?>
