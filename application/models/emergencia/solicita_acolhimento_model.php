<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class solicita_acolhimento_model extends BaseModel {

    var $_paciente_id = null;
    var $_nome = null;

    function solicita_acolhimento_model($emergencia_solicitacao_acolhimento_id = null) {
        parent::Model();
        if (isset($emergencia_solicitacao_acolhimento_id)) {
            $this->instanciar($emergencia_solicitacao_acolhimento_id);
        }
    }

    function gravarsolicitacao($paciente_id) {

        try {
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_emergencia_solicitacao_acolhimento');
            $solicitado_id = $this->db->insert_id();
            return $solicitado_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function verificaacolhimento($paciente_id) {
        $this->db->select();
        $this->db->from('tb_emergencia_solicitacao_acolhimento');
        $this->db->where("ativo", 'true');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function gravarrae($paciente_id) {

        try {
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('local_ocorrencia', $_POST['ocorrencia']);
            $this->db->set('descricao_ocorrencia', $_POST['descricaocorrencia']);
            $this->db->set('veiculo_ocorrencia', $_POST['veiculo']);
            $this->db->set('placa_ocorrencia', $_POST['placa']);
            $this->db->set('condutor_ocorrencia', $_POST['condutor']);
            $this->db->set('municipio_ocorrencia', $_POST['txtCidade']);
            $this->db->set('tipo_atendimento', $_POST['tipoatendimento']);
            $this->db->set('motivo_atendimento', $_POST['motivoID']);
            $this->db->set('sitomas_atendimento', $_POST['sinais']);
            $this->db->set('escala_dor', $_POST['esacalador']);
            $this->db->set('glasgow', $_POST['glasgow']);
            $this->db->set('pas', $_POST['pas']);
            $this->db->set('pad', $_POST['pad']);
            $this->db->set('fr', $_POST['fr']);
            $this->db->set('so2', $_POST['saturacao']);
            $this->db->set('classificacao', $_POST['classificacaorisco']);
            $this->db->set('acidente_trabalho', $_POST['trabalho']);
            $this->db->set('acidente_codigo', $_POST['codigoacidente']);
            $this->db->set('data_cadastro', $_POST['data']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_emergencia_rae');
            $solicitado_id = $this->db->insert_id();

            $this->db->set('rae', $solicitado_id);
            $this->db->set('ativo', 'false');
            $this->db->set('data_atendida', $horario);
            $this->db->set('operador_atendimento', $operador_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->where('ativo', 'true');
            $this->db->update('tb_emergencia_solicitacao_acolhimento');
            return $solicitado_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarfechamentorae($paciente_id) {

        try {
            $this->db->set('medico_fechamento', $_POST['medicoID']);
            $this->db->set('tipo_saida', $_POST['tiposaida']);
            $this->db->set('obs_saida', $_POST['observacoes']);
            //$horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'false');
            $this->db->set('data_fechamento', $_POST['data']);
            $this->db->set('operador_fechamento', $operador_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->where('ativo', 'true');
            $this->db->update('tb_emergencia_rae');



            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listar($args = array()) {
        $this->db->from('tb_emergencia_solicitacao_acolhimento')
                ->join('tb_paciente', 'tb_paciente.paciente_id = tb_emergencia_solicitacao_acolhimento.paciente_id', 'left')
                ->select('"tb_paciente".nome,"tb_emergencia_solicitacao_acolhimento.*,tb_paciente.nascimento');
        $this->db->where('tb_emergencia_solicitacao_acolhimento.ativo', 'true');
        if ($args) {
            if ($args['tipo'] != "0") {
                $this->db->where('tipo', $args['tipo']);
            }
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('tb_paciente.nome ilike', $args['nome']);
            }
        }

        return $this->db;
    }

    function listarrae($args = array()) {
        $this->db->from('tb_emergencia_rae')
                ->join('tb_paciente', 'tb_paciente.paciente_id = tb_emergencia_rae.paciente_id', 'left')
                ->select('"tb_paciente".nome,"tb_emergencia_rae.*,tb_paciente.nascimento');
        //$this->db->where('ativo', 'true');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('tb_paciente.nome ilike', $args['nome']);
            }
        }

        return $this->db;
    }

    function listamotivoautocomplete($parametro = null) {
        $this->db->select('emergencia_motivoatendimento_id,
                            nome');
        $this->db->from('tb_emergencia_motivoatendimento');
        $this->db->where('ativo', 't');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarmedicosaida($parametro = null) {
        $this->db->select('operador_id,
                            nome,
                            conselho');
        $this->db->from('tb_operador');
        $this->db->where('ativo', 't');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
            $this->db->orwhere('conselho ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listatipoatendimento() {
        $this->db->select('emergencia_tipoatendimento_id,
                            nome');
        $this->db->from('tb_emergencia_tipoatendimento');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

}

?>
