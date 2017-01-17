<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class centrocirurgico_model extends BaseModel {

    var $_centrocirurgico_id = null;
    var $_localizacao = null;
    var $_nome = null;

    function centrocirurgico_model($centrocirurgico_id = null) {
        parent::Model();
        if (isset($centrocirurgico_id)) {
            $this->instanciar($centrocirurgico_id);
        }
    }

    private function instanciar($centrocirurgico_id) {
        if ($centrocirurgico_id != 0) {

            $this->db->select('centrocirurgico_id,
                            nome');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('ativo', 'true');
            $this->db->where('excluido', 'false');
            $this->db->where('centrocirurgico_id', $centrocirurgico_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_centrocirurgico_id = $centrocirurgico_id;
            $this->_nome = $return[0]->nome;
        }
    }

    function listarsolicitacoes($args = array()) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.data_prevista,
                            c.nome as convenio,
                            c.convenio_id,
                            o.nome as medico,
                            sc.situacao');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 'f');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_agendado', 'left');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarcirurgia($args = array()) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.data_prevista');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_internacao i', 'i.internacao_id = sc.internacao_id' , 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id ' , 'left');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 't');

        if ($args) {
            if (isset($args['txtdata_cirurgia']) && strlen($args['txtdata_cirurgia']) > 0) {
                $pesquisa = $args['txtdata_cirurgia'];
                $pesquisa1 = $pesquisa . ' 00:00:00';
                $pesquisa2 = $pesquisa . ' 23:59:59';
                $this->db->where("sc.data_prevista >=", "$pesquisa1");
                $this->db->where("sc.data_prevista <=", "$pesquisa2");
                if ($args['nome'] != null) {
                    $this->db->where('nome ilike', "%" . $args['nome'] . "%");
                }
            } else if ($args['nome'] != null) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
        } else {
            $hoje = date('Y-m-d');
            $hoje = $hoje . ' 00:00:00';
            $this->db->where("sc.data_prevista >=", "$hoje");
        }

        return $this->db;
    }

    function listacentrocirurgicoautocomplete($parametro = null) {
        $this->db->select('centrocirurgico_id,
                            nome,
                            localizacao');
        $this->db->from('tb_solicitacao_cirurgia');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalas() {
        $this->db->select('exame_sala_id,
                           nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('ativo', 'true');

        $return = $this->db->get();
        return $return->result();
    }

    function pegasolicitacaoinformacoes($solicitacao_id) {
        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.medico_agendado');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id ');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function liberarsolicitacao($solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('situacao', 'LIBERADA');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function finalizarrcamento($solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('situacao', 'ORCAMENTO_COMPLETO');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function autorizarcirurgia() {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_prevista', $_POST['dataprevista']);
        $this->db->set('medico_agendado', $_POST['medicoagendadoid']);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('sala_agendada', $_POST['salaagendada']);
        $this->db->set('autorizado', 't');
        $this->db->set('situacao', 'AUTORIZADA');
        $this->db->where('solicitacao_cirurgia_id', $_POST['idsolicitacaocirurgia']);
        $this->db->update('tb_solicitacao_cirurgia');
    }

    function listarmedicocirurgiaautocomplete($parametro = null) {
        $this->db->select('operador_id,
                           nome');
        $this->db->from('tb_operador');
        $this->db->where('consulta', 'true');
        $this->db->where('ativo', 'true');
//        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function gravarcentrocirurgico() {

        try {
            $this->db->set('nome', $_POST['nome']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['centrocirurgico_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_solicitacao_cirurgia');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $centrocirurgico_id = $this->db->insert_id();
            }
            else { // update
                $centrocirurgico_id = $_POST['centrocirurgico_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('centrocirurgico_id', $centrocirurgico_id);
                $this->db->update('tb_solicitacao_cirurgia');
            }


            return $centrocirurgico_id;
        } catch (Exception $exc) {
            return false;
        }
    }

}
?>

