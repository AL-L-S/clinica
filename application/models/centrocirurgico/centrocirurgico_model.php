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
                            sc.data_prevista');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 'f');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id ');
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
                            sc.procedimento_id,
                            sc.solicitacao_cirurgia_id,
                            pt.descricao,
                            sc.data_prevista');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 't');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = sc.procedimento_id', 'left');
        $this->db->where('pc.ativo', 't');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pt.ativo', 't');

        if ($args) {
            if (isset($args['txtdata_cirurgia']) && strlen($args['txtdata_cirurgia']) > 0) {
                $pesquisa = $args['txtdata_cirurgia'];
                $pesquisa1 = $pesquisa . ' 00:00:00';
                $pesquisa2 = $pesquisa . ' 23:59:59';
                $this->db->where("sc.data_prevista >=",  "$pesquisa1");
                $this->db->where("sc.data_prevista <=",  "$pesquisa2");
                if ($args['nome'] != null) {
                    $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
                }
            }
            else if ($args['nome'] != null) {
                    $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
                }
        } else {
            $hoje = date('Y-m-d');
            $hoje = $hoje . ' 00:00:00';
            $this->db->where("sc.data_prevista >=",  "$hoje");
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

    function pegasolicitacaoinformacoes($solicitacao_id) {
        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.procedimento_id,
                            sc.solicitacao_cirurgia_id,
                            pr.descricao_resumida');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->join('tb_internacao i', 'i.internacao_id = sc.internacao_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->join('tb_procedimento pr', 'pr.procedimento_id = sc.procedimento_id ');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarautorizarcirurgia( ) {
        try {
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_prevista', $_POST['txtdata_prevista']);
            $this->db->set('medico_agendado', $_POST['medicoagenda']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('autorizado', 't');
            $this->db->where('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            
            return true;
        } catch (Exception $exc) {
            return false;
        }
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

