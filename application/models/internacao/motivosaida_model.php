<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class motivosaida_model extends BaseModel {

    var $_internacao_motivosaida_id = null;
    var $_localizacao = null;
    var $_nome = null;

    function motivosaida_model($internacao_motivosaida_id = null) {
        parent::Model();
        if (isset($internacao_motivosaida_id)) {
            $this->instanciar($internacao_motivosaida_id);
        }
    }

    private function instanciar($internacao_motivosaida_id) {
        if ($internacao_motivosaida_id != 0) {

            $this->db->select('internacao_motivosaida_id,
                            nome');
            $this->db->from('tb_internacao_motivosaida');
            $this->db->where('ativo', 'true');
            $this->db->where('internacao_motivosaida_id', $internacao_motivosaida_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_internacao_motivosaida_id = $internacao_motivosaida_id;
            $this->_nome = $return[0]->nome;
        }
    }

    function listamotivosaida($args = array()) {
        $this->db->select(' internacao_motivosaida_id,
                            nome');
        $this->db->from('tb_internacao_motivosaida');
        $this->db->where('ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('nome ilike', "%" . $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listamotivosaidapacientes() {
        $this->db->select('nome,
                internacao_motivosaida_id');
        $this->db->from('tb_internacao_motivosaida');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitomotivosaida() {
        $this->db->select('internacao_leito_id,
                           nome,
                           tipo,
                           condicao,
                           enfermaria_id,
                           ativo');
        $this->db->from('tb_internacao_leito');
        $return = $this->db->get();
        return $return->result();
    }

    function mostrarsaidapaciente($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome as paciente,
                           m.nome as motivosaida,
                           i.motivo_saida,
                           i.hospital_transferencia,
                           m.internacao_motivosaida_id,
                           p.paciente_id,
                           i.data_internacao,
                           i.observacao_saida,
                           i.leito,
                           i.ativo,
                           i.data_saida,
                           il.nome as leito_nome,
                           ie.nome as enfermaria_nome,
                           iu.nome as unidade_nome,
                           o.nome as medico_internacao,
                           o2.nome as medico_saida,
                           p.sexo,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = i.medico_saida', 'left');
        $this->db->join('tb_internacao_motivosaida m', 'm.internacao_motivosaida_id = i.motivo_saida', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
//        $this->db->where('p.paciente_id = i.paciente_id');
//        $this->db->where('o.operador_id = i.medico_id');
        // $this->db->where('m.internacao_motivosaida_id = i.motivo_saida ');

        $return = $this->db->get();
        return $return->result();
    }

    function mostrarnovasaidapaciente($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome as paciente,
                           m.nome as motivosaida,
                           m.internacao_motivosaida_id,
                           p.paciente_id,
                           i.prelaudo,
                           o.nome as medico,
                           i.data_internacao,
                           i.data_saida,
                           i.motivo_saida,
                           i.medico_saida,
                           i.forma_de_entrada,
                           i.estado,
                           i.ativo,
                           i.carater_internacao,
                           i.justificativa,
                           i.observacao_saida,
                           i.leito as leito_id,
                           il.nome as leito,
                           i.procedimentosolicitado,
                           i.cid1solicitado,
                           p.sexo,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_internacao_motivosaida m', 'm.internacao_motivosaida_id = i.motivo_saida', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listamotivosaidaautocomplete($parametro = null) {
        $this->db->select('internacao_motivosaida_id,
                            nome,
                            localizacao');
        $this->db->from('tb_internacao_motivosaida');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluirmotivosaida($internacao_motivosaida_id) {


        $this->db->set('ativo', 'f');
        $this->db->where('internacao_motivosaida_id', $internacao_motivosaida_id);
        $this->db->update('tb_internacao_motivosaida');
    }

    function gravarsaida() {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
//        var_dump($_POST);
//        die;
        if ($_POST['ativo_internacao'] == 't') {

            $this->db->set('internacao_id', $_POST['internacao_id']);
            $this->db->set('leito_id', $_POST['leito_id']);
            $this->db->set('tipo', 'SAIDA');
            $this->db->set('status', 'SAIDA');
            $this->db->set('data', $horario);
            $this->db->set('operador_movimentacao', $operador_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_leito_movimentacao');


            //Tabela Ocupação alteração
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ocupado', 'f');
            $this->db->where('paciente_id', $_POST['idpaciente']);
            $this->db->update('tb_internacao_ocupacao');

            //Tabela internacao_leito

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ativo', 't');
            $this->db->where('internacao_leito_id', $_POST['leito_id']);
            $this->db->update('tb_internacao_leito');
        }


        //Tabela internação alteração
        if ($_POST['motivosaida'] == 'transferencia') {
            $this->db->set('ativo', 'f');
            $this->db->set('hospital_transferencia', $_POST['hospital']);
            $this->db->set('observacao_saida', $_POST['observacao']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('data_saida', date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['data_saida']))));
            if ($_POST['medico_saida'] != '') {
                $this->db->set('medico_saida', $_POST['medico_saida']);
            }

            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_id', $_POST['internacao_id']);
            $this->db->update('tb_internacao');
        } else {
            $this->db->set('ativo', 'f');
            $this->db->set('motivo_saida', $_POST['motivosaida']);
            $this->db->set('observacao_saida', $_POST['observacao']);
            $this->db->set('data_atualizacao', $horario);
            if ($_POST['medico_saida'] != '') {
                $this->db->set('medico_saida', $_POST['medico_saida']);
            }

            $this->db->set('data_saida', date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['data_saida']))));
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_id', $_POST['internacao_id']);
            $this->db->update('tb_internacao');
        }
    }

    function gravarmotivosaida() {

        try {
            $this->db->set('nome', $_POST['nome']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['internacao_motivosaida_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_motivosaida');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $internacao_motivosaida_id = $this->db->insert_id();
            }
            else { // update
                $internacao_motivosaida_id = $_POST['internacao_motivosaida_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_motivosaida_id', $internacao_motivosaida_id);
                $this->db->update('tb_internacao_motivosaida');
            }

            return $internacao_motivosaida_id;
        } catch (Exception $exc) {
            return false;
        }
    }

}

?>
