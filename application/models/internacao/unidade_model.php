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
            $this->_internacao_unidade_id = $internacao_unidade_id;
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

    function listasaida($args = array()) {
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

    function listaunidadepacientes() {
        $this->db->select('nome,
                internacao_unidade_id');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitounidade() {
        $this->db->select('internacao_leito_id,
                           nome,
                           tipo,
                           condicao,
                           enfermaria_id,
                           ativo');
        $this->db->from('tb_internacao_leito');
        $this->db->where('excluido', 'f');
        $this->db->where('condicao !=', 'Cirurgico');
        $return = $this->db->get();
        return $return->result();
    }

    function listaenfermariaunidade($unidade) {

        $this->db->select('nome,
                           internacao_enfermaria_id,
                           tipo,
                           ativo');
        $this->db->from('tb_internacao_enfermaria');
        $this->db->where('unidade_id', $unidade);
        $return = $this->db->get();
        return $return->result();
    }

    function mostrafichapaciente($leito_id) {

        $this->db->select('p.nome as paciente,
                           i.internacao_id,
                           p.paciente_id,
                           i.data_internacao,
                           il.internacao_leito_id as leito_id,
                           p.sexo,
                           p.nascimento,
                           il.nome as leito');
        $this->db->from('tb_internacao i, tb_paciente p, tb_internacao_leito il');
        $this->db->where('i.leito = il.internacao_leito_id');
        $this->db->where('p.paciente_id = i.paciente_id');
        $this->db->where('i.leito', $leito_id);
        $this->db->where('il.ativo', 'f');
        $this->db->where('i.ativo', 't');

        $return = $this->db->get();
        return $return->result();
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
                } else
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

    function gravarmotivosaida() {

        try {
            $this->db->set('nome', $_POST['nome']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

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
                $internacao_motivosaida_id = $_POST['internacao_unidade_id'];
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

    function excluirunidade($unidade_id) {
        $this->db->set('ativo', 'f');
        $this->db->where('internacao_unidade_id', $unidade_id);
        $this->db->update('tb_internacao_unidade');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
    }

}

?>
