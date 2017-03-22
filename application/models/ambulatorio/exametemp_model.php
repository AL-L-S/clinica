<?php

class exametemp_model extends Model {

    var $_ambulatorio_pacientetemp_id = null;
    var $_nome = null;
    var $_nascimento = null;
    var $_idade = null;
    var $_celular = null;
    var $_telefone = null;

    function Exametemp_model($ambulatorio_pacientetemp_id = null) {
        parent::Model();
        if (isset($ambulatorio_pacientetemp_id)) {
            $this->instanciar($ambulatorio_pacientetemp_id);
        }
    }

    function listarmedicoconsulta() {
        $this->db->select('operador_id,
            nome');
        $this->db->from('tb_operador');
        $this->db->where('consulta', 'true');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $this->db->select('ambulatorio_pacientetemp_id,
                            nome,
                            idade,
                            celular,
                            telefone');
        $this->db->from('tb_ambulatorio_pacientetemp');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('celular ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('telefone ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listaragendas($ambulatorio_pacientetemp_id) {
        $this->db->select('agenda_exames_id,
                            inicio,
                            data,
                            nome,
                            observacoes');
        $this->db->from('tb_agenda_exames');
        $this->db->where("ambulatorio_pacientetemp_id", $ambulatorio_pacientetemp_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaspaciente($pacientetemp_id) {
        $data = date("Y-m-d");
//        var_dump($data);
//        die;
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes,
                            p.convenio_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("a.tipo", 'EXAME');
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
//        echo '<pre>';
//        var_dump($return->result());die;
        return $return->result();
    }

    function listaragendaspacienteconsulta($pacientetemp_id) {
        $data = date("Y-m-d");
//        var_dump($data);
//        die;
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.medico_consulta_id,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes,
                            p.convenio_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("a.tipo", 'CONSULTA');
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaspacientefisioterapia($pacientetemp_id) {
        $data = date("Y-m-d");
//        var_dump($data);
//        die;
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.medico_consulta_id,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("a.tipo", 'FISIOTERAPIA');
        $this->db->where("a.guia_id", null);
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaspacienteatendimento($pacientetemp_id) {
        $data = date("Y-m-d");
//        var_dump($data);
//        die;
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.medico_consulta_id,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            pt.nome as procedimento,
                            o.nome as medico,
                            a.observacoes,
                            p.convenio_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("a.guia_id", null);
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaspacientepsicologia($pacientetemp_id) {
        $data = date("Y-m-d");
//        var_dump($data);
//        die;
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.medico_consulta_id,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("a.tipo", 'PSICOLOGIA');
        $this->db->where("a.guia_id", null);
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpaciente($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.encaixe,
                            a.data,
                            a.agenda_exames_nome_id,
                            pt.nome as procedimento,
                            es.nome as sala,
                            pt.tuss_id,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("a.tipo", 'EXAME');
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function carregasessaofisioterapia($agendaexame_id) {

        $this->db->select('tipo_consulta_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->where("a.tipo", 'FISIOTERAPIA');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.agenda_exames_id', $agendaexame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpacienteconsulta($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.encaixe,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.tipo", 'CONSULTA');
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpacientegeral($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpacientefisioterapia($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.encaixe,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.tipo", 'FISIOTERAPIA');
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listarconsultaanterior($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            c.nome as convenio,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("a.tipo", 'CONSULTA');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $this->db->limit(5);
        $return = $this->db->get();
        return $return->result();
    }

    function listarespecialidadeanterior($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            c.nome as convenio,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("a.tipo !=", 'CONSULTA');
        $this->db->where("a.tipo !=", 'EXAME');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $this->db->limit(5);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameanterior($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            c.nome as convenio,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("a.tipo", 'EXAME');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $this->db->limit(5);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosanterior($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            c.nome as convenio,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $this->db->limit(5);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconsultaanteriorcontador($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("a.tipo", 'CONSULTA');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarprocedimentoanteriorcontador($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listaragendasexamepaciente($agenda_exames_id) {
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.fim,
                            a.data,
                            a.nome,
                            es.nome as sala,
                            a.medico_agenda,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->where("a.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id) {
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.fim,
                            a.data,
                            a.nome,
                            es.nome as sala,
                            a.medico_agenda,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->where("a.paciente_id is null");
        $this->db->where("a.agenda_exames_id !=", $agenda_exames_id);
        $this->db->where("a.medico_consulta_id", $medico_id);
        $this->db->where("a.inicio >=", $horainicio);
        $this->db->where("a.inicio <", $horafim);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id) {
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.fim,
                            a.data,
                            a.nome,
                            es.nome as sala,
                            a.medico_agenda,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->where("a.paciente_id is null");
        $this->db->where("a.agenda_exames_id !=", $agenda_exames_id);
        $this->db->where("a.medico_consulta_id", $medico_id);
        $this->db->where("a.inicio <=", $horainicio);
        $this->db->where("a.fim >=", $horafim);
        $return = $this->db->get();
        return $return->result();
    }

    function listarvalortotalexames($medico, $data) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('sum(valortotal) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->where("ae.data", $data);
        $this->db->where("ae.medico_agenda", $medico);
        $this->db->where('ae.empresa_id', $empresa_id);
        $return = $this->db->get()->result();
        return $return;
    }

    function listaragendasconsultapaciente($agenda_exames_id) {
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            o.nome as medico,
                            a.medico_agenda,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaraexamespaciente($ambulatorio_guia_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.faturado,
                            pc.convenio_id,
                            ae.medico_agenda as medico_agenda_id,
                            op.nome as medico_agenda,
                            ae.medico_solicitante as medico_solicitante_id,
                            o.nome as medico_solicitante,
                            es.nome as sala,
                            p.nome as paciente,
                            c.dinheiro,
                            c.nome as convenio,
                            pt.codigo,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            fp.forma_pagamento_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pp.forma_pagamento_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");
        $return = $this->db->get();
        return $return->result();
    }

    function listarindicacaoguia($ambulatorio_guia_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('paciente_indicacao_id, nome');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ag.indicacao_id', 'left');
        $this->db->where("ambulatorio_guia_id", $ambulatorio_guia_id);
        $return = $this->db->get();
        return $return->result();
    }

//    function listarprocedimentocomformapagamentoconsulta($ambulatorio_guia_id, $grupo_pagamento_id) {
//
//        $empresa_id = $this->session->userdata('empresa_id');
//        $this->db->select('ae.agenda_exames_id,
//                            ae.agenda_exames_nome_id,
//                            ae.data,
//                            ae.inicio,
//                            ae.fim,
//                            ae.valor_total,
//                            ae.ativo,
//                            ae.situacao,
//                            ae.guia_id,
//                            ae.data_atualizacao,
//                            ae.paciente_id,
//                            ae.faturado,
//                            pc.convenio_id,
//                            ae.medico_agenda as medico_agenda_id,
//                            op.nome as medico_agenda,
//                            ae.medico_solicitante as medico_solicitante_id,
//                            o.nome as medico_solicitante,
//                            es.nome as sala,
//                            p.nome as paciente,
//                            c.dinheiro,
//                            c.nome as convenio,
//                            pt.codigo,
//                            ae.ordenador,
//                            ae.procedimento_tuss_id,
//                            pt.nome as procedimento,
//                            pp.grupo_pagamento_id');
//        $this->db->from('tb_agenda_exames ae');
//        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
//        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
//        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
//        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
//        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
//        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
//        $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
//        $this->db->where('ae.empresa_id', $empresa_id);
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('pt.grupo', 'CONSULTA');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
//        $this->db->where("guia_id", $ambulatorio_guia_id);
//        $this->db->where("pp.grupo_pagamento_id", $grupo_pagamento_id);
//        $this->db->orderby("ae.data");
//        $this->db->orderby("ae.inicio");
//        $return = $this->db->get();
//        $retorno = $return->result();
//        if (empty($retorno)) {
//            return 0;
//        } else {
//            return $return->result();
//        }
//    }

    function listarprocedimentocomformapagamento($ambulatorio_guia_id, $grupo_pagamento_id) {
//        var_dump($grupo_pagamento_id);die;
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.faturado,
                            pc.convenio_id,
                            ae.medico_agenda as medico_agenda_id,
                            op.nome as medico_agenda,
                            ae.medico_solicitante as medico_solicitante_id,
                            o.nome as medico_solicitante,
                            es.nome as sala,
                            p.nome as paciente,
                            c.dinheiro,
                            c.nome as convenio,
                            pt.codigo,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pp.grupo_pagamento_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $this->db->where("pp.grupo_pagamento_id", $grupo_pagamento_id);
        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");
        $return = $this->db->get();
        $retorno = $return->result();
        if (empty($retorno)) {
            return 0;
        } else {
            return $return->result();
        }
    }

//    function listarprocedimentosemformapagamentoconsulta($ambulatorio_guia_id, $procedimento_convenio_id) {
//
//        $empresa_id = $this->session->userdata('empresa_id');
//        $this->db->select('ae.agenda_exames_id,
//                            ae.agenda_exames_nome_id,
//                            ae.data,
//                            ae.inicio,
//                            ae.fim,
//                            ae.valor_total,
//                            ae.ativo,
//                            ae.situacao,
//                            ae.guia_id,
//                            ae.data_atualizacao,
//                            ae.paciente_id,
//                            ae.faturado,
//                            pc.convenio_id,
//                            ae.medico_agenda as medico_agenda_id,
//                            op.nome as medico_agenda,
//                            ae.medico_solicitante as medico_solicitante_id,
//                            o.nome as medico_solicitante,
//                            es.nome as sala,
//                            p.nome as paciente,
//                            c.dinheiro,
//                            c.nome as convenio,
//                            pt.codigo,
//                            ae.ordenador,
//                            ae.procedimento_tuss_id,
//                            pt.nome as procedimento');
//        $this->db->from('tb_agenda_exames ae');
//        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
//        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
//        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
//        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
//        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
//        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
//        $this->db->where('ae.empresa_id', $empresa_id);
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('pt.grupo =', 'CONSULTA');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
//        $this->db->where("guia_id", $ambulatorio_guia_id);
//        $this->db->where("ae.procedimento_tuss_id", $procedimento_convenio_id);
//        $this->db->orderby("ae.data");
//        $this->db->orderby("ae.inicio");
//        $return = $this->db->get();
//
//        return $return->result();
//    }

    function listarprocedimentosemformapagamento($agenda_exames_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.faturado,
                            pc.convenio_id,
                            ae.medico_agenda as medico_agenda_id,
                            op.nome as medico_agenda,
                            ae.medico_solicitante as medico_solicitante_id,
                            o.nome as medico_solicitante,
                            es.nome as sala,
                            p.nome as paciente,
                            c.dinheiro,
                            c.nome as convenio,
                            pt.codigo,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
//        $this->db->where("guia_id", $ambulatorio_guia_id);
//        $this->db->where("ae.procedimento_tuss_id", $procedimento_convenio_id);
        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");
        $return = $this->db->get();

        return $return->result();
    }

    function listarprocedimentosemformapagamentogeral($ambulatorio_guia_id, $procedimento_convenio_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.faturado,
                            pc.convenio_id,
                            ae.medico_agenda as medico_agenda_id,
                            op.nome as medico_agenda,
                            ae.medico_solicitante as medico_solicitante_id,
                            o.nome as medico_solicitante,
                            es.nome as sala,
                            p.nome as paciente,
                            c.dinheiro,
                            c.nome as convenio,
                            pt.codigo,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $this->db->where("ae.procedimento_tuss_id", $procedimento_convenio_id);
        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");
        $return = $this->db->get();

        return $return->result();
    }

    function verificaprocedimentosemformapagamento($procedimento_convenio_id) {

        $this->db->select('procedimento_convenio_pagamento_id');
        $this->db->from('tb_procedimento_convenio_pagamento');
        $this->db->where("procedimento_convenio_id", $procedimento_convenio_id);
        $return = $this->db->get();
        $retorno = $return->result();

        return $retorno;
    }

    function listarorcamentos($paciente_id) {
        $horario = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('oi.ambulatorio_orcamento_item_id,
                            oi.data,
                            oi.orcamento_id,
                            oi.valor_total,
                            oi.orcamento_id,
                            oi.paciente_id,
                            pc.convenio_id,
                            p.nome as paciente,
                            c.nome as convenio,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_ambulatorio_orcamento_item oi');
        $this->db->join('tb_paciente p', 'p.paciente_id = oi.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = oi.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('oi.empresa_id', $empresa_id);
        $this->db->where("oi.paciente_id", $paciente_id);
        $this->db->where("oi.data", $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function listaagendafisioterapia($agendaexame_id) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select("ae.*, h.dia");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_horarioagenda h', 'h.horarioagenda_id = ae.horarioagenda_id', 'left');
        $this->db->where("ae.agenda_exames_id", $agendaexame_id);
        $this->db->where('ae.empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function contadordisponibilidadefisioterapia($agenda) {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d");

        $nulo = null;
        $this->db->select('ae.*');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where("ae.paciente_id", $nulo);
        $this->db->where("ae.situacao", "LIVRE");
        $this->db->where('ativo', 't');
        $this->db->where('cancelada', 'f');
        $this->db->where('confirmado', 'f');
        $this->db->where("ae.tipo", "FISIOTERAPIA");
        $this->db->where("ae.data >=", $horario);
        $this->db->where("ae.data >=", $agenda->data);
        $this->db->where("ae.inicio", $agenda->inicio);
        $this->db->where("ae.fim", $agenda->fim);
        $this->db->where("ae.medico_agenda", $agenda->medico_agenda);
        $return = $this->db->get();
        return $return->result();
    }

    function contadorhorariosdisponiveisfisioterapia($data, $inicio, $medico) {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d");

        $data = str_replace("/", "-", $data);
        $data_es = date("Y-m-d", strtotime($data));

        $x = 0;
        for ($i = 1; $i <= $_POST['qtde']; $i++) {
            if ($i > 1) {
                $data_es = date("Y-m-d", strtotime("+1 week", strtotime($data_es)));
            }
            $this->db->select('agenda_exames_id');
            $this->db->from('tb_agenda_exames ae');
            $this->db->where("situacao", "OK");
//            $this->db->orwhere("situacao", "LIVRE");
            $this->db->where('empresa_id', $empresa_id);
            $this->db->where('ativo', 'f');
            $this->db->where('cancelada', 'f');
            $this->db->where('confirmado', 'f');
            $this->db->where("( (tipo = 'FISIOTERAPIA') OR (tipo = 'ESPECIALIDADE') )");
            $this->db->where("data >=", $horario);
            $this->db->where("data >=", $data_es);
            $this->db->where("inicio", $inicio);
            $this->db->where("medico_consulta_id", $medico);
            $return = $this->db->get();
            $count = count($return->result());
            if ($count > 0) {
                $x++;
            }
        }
        return $x;
    }

    function listadisponibilidadefisioterapia($agenda, $diaSemana) {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d");

        $nulo = null;
        $this->db->select('ae.*');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where("ae.paciente_id", $nulo);
        $this->db->where("ae.situacao", "LIVRE");
        $this->db->where('ativo', 't');
        $this->db->where('cancelada', 'f');
        $this->db->where('confirmado', 'f');
        $this->db->where("ae.tipo", "FISIOTERAPIA");
        $this->db->where("ae.data >=", $horario);
        $this->db->where("ae.data", $diaSemana);
        $this->db->where("ae.inicio", $agenda->inicio);
        $this->db->where("ae.fim", $agenda->fim);
        $this->db->where("ae.medico_agenda", $agenda->medico_agenda);
        $return = $this->db->get();
        return $return->result();
    }

    function contadorexamespaciente($ambulatorio_guia_id) {
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames_nome an', 'an.agenda_exames_nome_id = ae.agenda_exames_nome_id', 'left');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpacienteexame($paciente_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_exames');
        $this->db->where('cancelada', 'false');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpacienteguia($paciente_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('ativo', 'true');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpacienteconsulta($paciente_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_ambulatorio_consulta');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpacientelaudo($paciente_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_ambulatorio_laudo');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contador($ambulatorio_pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where('ambulatorio_pacientetemp_id', $ambulatorio_pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpaciente($pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where("tipo", 'EXAME');
        $this->db->where('confirmado', 'false');
        $this->db->where('ativo', 'false');
        $this->db->where('paciente_id', $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorconsultapaciente($pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where("tipo", 'CONSULTA');
        $this->db->where('confirmado', 'false');
        $this->db->where('ativo', 'false');
        $this->db->where('paciente_id', $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorfisioterapiapaciente($pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where("tipo", 'FISIOTERAPIA');
        $this->db->where('confirmado', 'false');
        $this->db->where('ativo', 'false');
        $this->db->where('paciente_id', $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function gravarguiacirurgicaprocedimentos() {
        $empresa_id = $this->session->userdata('empresa_id');

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $qtde = (int) str_replace('.', '', $_POST['qtde']);
        for ($i = 0; $i < $qtde; $i++) {
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'CIRURGICO');
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 't');
            $this->db->set('valor', str_replace(',', '.', $_POST['valor']));
            $this->db->set('valor_total', str_replace(',', '.', $_POST['valor']));
            $this->db->set('situacao', 'OK');
            $this->db->set('quantidade', 1);
            $this->db->set('data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_realizacao']))));
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('guia_id', $_POST['txtguiaid']);
            if (isset($_POST['horEspecial'])) {
                $this->db->set('horario_especial', 't');
            }
            $this->db->set('data_autorizacao', date("Y-m-d H:i", strtotime(str_replace('/', '-', $_POST['data_autorizacao']))));
            $this->db->set('data_realizacao', date("Y-m-d H:i", strtotime(str_replace('/', '-', $_POST['data_realizacao']))));
            $this->db->set('paciente_id', $_POST['txtNomeid']);

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
        }
    }

    function gravarexames($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['celular']);
            $this->db->set('telefone', $_POST['telefone']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');
            if ($_POST['procedimento1'] != '') {
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            }
            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'EXAME');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultas($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfisioterapia($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'FISIOTERAPIA');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultasencaixe() {
        try {

            $this->db->select('nome');
            $this->db->from('tb_operador');
            $this->db->where('operador_id', $_POST['medico']);
            $query = $this->db->get();
            $return = $query->result();

            $explode = explode(" ", $return[0]->nome);
            $nome = @$explode[0] . " " . @$explode[1];


            if ($_POST['txtNomeid'] == '') {
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
                if ($_POST['idade'] != 0) {
                    $this->db->set('idade', $_POST['idade']);
                }
                $this->db->set('celular', $_POST['txtCelular']);
                $this->db->set('convenio_id', $_POST['convenio']);
                $this->db->set('telefone', $_POST['txtTelefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                $paciente_id = $_POST['txtNomeid'];

                $this->db->set('celular', $_POST['txtCelular']);
                $this->db->set('telefone', $_POST['txtTelefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }



            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                if (isset($_POST['empresa']) && $_POST['empresa'] != '') {
                    $this->db->set('empresa_id', $_POST['empresa']);
                } else {
                    $this->db->set('empresa_id', $empresa_id);
                }
                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('nome', $nome);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);

                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $_POST['data_ficha'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_ficha'])));

                $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('encaixe', 't');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarexameencaixe() {
        try {

            if ($_POST['txtNomeid'] == '') {
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
                if ($_POST['idade'] != 0) {
                    $this->db->set('idade', $_POST['idade']);
                }
                $this->db->set('celular', $_POST['txtCelular']);
                $this->db->set('convenio_id', $_POST['convenio']);
                $this->db->set('telefone', $_POST['telefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                $paciente_id = $_POST['txtNomeid'];

                $this->db->set('celular', $_POST['txtCelular']);
                $this->db->set('telefone', $_POST['telefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $_POST['data_ficha'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_ficha'])));

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'EXAME');
                $this->db->set('agenda_exames_nome_id', $_POST['sala']);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('medico_agenda', $_POST['medico']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('encaixe', 't');
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarexameencaixegeral() {
        try {

            if ($_POST['txtNomeid'] == '') {
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
                if ($_POST['idade'] != 0) {
                    $this->db->set('idade', $_POST['idade']);
                }
                $this->db->set('celular', $_POST['celular']);
                $this->db->set('convenio_id', $_POST['convenio']);
                $this->db->set('telefone', $_POST['telefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                $paciente_id = $_POST['txtNomeid'];

                $this->db->set('celular', $_POST['celular']);
                $this->db->set('telefone', $_POST['telefone']);
                $this->db->set('nome', $_POST['txtNome']);
//                $this->db->set('nome', $_POST['txtEnd']);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }

            if ($_POST['horarios'] != "") {


                $empresa_id = $this->session->userdata('empresa_id');
//                if(isset($_POST['empresa']) && $_POST['empresa'] != ''){
//                    $this->db->set('empresa_id', $_POST['empresa']);
//                }
//                else{
                $this->db->set('empresa_id', $empresa_id);
//                }

                $tipo = $this->buscartipo($_POST['procedimento1']);

                if (count($tipo) > 0 && isset($tipo[0]->tipo)) {
                    $this->db->set('tipo', $tipo[0]->tipo);
                }
//                var_dump($tipo);die;
                $_POST['data_ficha'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_ficha'])));
//                 var_dump($_POST['data_ficha']);die;

                $this->db->set('agenda_exames_nome_id', $_POST['sala']);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('medico_agenda', $_POST['medico']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('encaixe', 't');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function buscartipo($procedimento_id) {
        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'pt.grupo = ag.nome', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_id);
        $this->db->where('ag.tipo !=', 'ESPECIALIDADE');
        $return = $this->db->get();

        return $return->result();
    }

    function gravarhorarioencaixe() {
        try {
            $_POST['data_ficha'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_ficha'])));

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'EXAME');
                $this->db->set('agenda_exames_nome_id', $_POST['sala']);
                $this->db->set('ativo', 't');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'LIVRE');
                $this->db->set('observacoes', $_POST['observacoes']);
                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('medico_agenda', $_POST['medico']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('encaixe', 't');
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarhorarioencaixegeral() {
        try {


            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                if (isset($_POST['tipo'])) {
                    $this->db->set('tipo', $_POST['tipo']);
                }
                $_POST['data_ficha'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_ficha'])));

                $this->db->set('agenda_exames_nome_id', $_POST['sala']);
                $this->db->set('ativo', 't');
                $this->db->set('encaixe', 't');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'LIVRE');
                $this->db->set('observacoes', $_POST['observacoes']);
                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('medico_agenda', $_POST['medico']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarfisioterapiaencaixe() {
        try {


            $this->db->select('nome');
            $this->db->from('tb_operador');
            $this->db->where('operador_id', $_POST['medico']);
            $query = $this->db->get();
            $return = $query->result();
            $explode = explode(" ", $return[0]->nome);
            $nome = @$explode[0] . " " . @$explode[1];


            if ($_POST['txtNomeid'] == '') {
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
                if ($_POST['idade'] != 0) {
                    $this->db->set('idade', $_POST['idade']);
                }
                $this->db->set('celular', $_POST['txtCelular']);
                $this->db->set('convenio_id', $_POST['convenio']);
                $this->db->set('telefone', $_POST['txtTelefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                $paciente_id = $_POST['txtNomeid'];

                $this->db->set('celular', $_POST['txtCelular']);
                $this->db->set('telefone', $_POST['txtTelefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }


            $agrupador = 0;
            if ($_POST['horarios'] != "") {

                $data = str_replace("/", "-", $_POST['data_ficha']);
                $data_ficha = date("Y-m-d", strtotime($data));

                for ($i = 1; $i <= $_POST['qtde']; $i++) {
                    if ($i > 1) {
                        $data_ficha = date("Y-m-d", strtotime("+1 week", strtotime($data_ficha)));
                        //criar agrfupador temp
                        $this->db->set('qtde_sessoes', $_POST['qtde']);
                        $this->db->insert('tb_agrupador_fisioterapia_temp');
                        $agrupador = $this->db->insert_id();
                        //
                    }
                    $empresa_id = $this->session->userdata('empresa_id');

                    if ($agrupador != 0) {
                        $this->db->set('agrupador_fisioterapia', $agrupador);
                    }

                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('tipo', 'FISIOTERAPIA');
                    $this->db->set('medico_consulta_id', $_POST['medico']);
                    $this->db->set('nome', $nome);
                    $this->db->set('ativo', 'f');
                    $this->db->set('cancelada', 'f');
                    $this->db->set('confirmado', 'f');
                    $this->db->set('situacao', 'OK');
                    $this->db->set('encaixe', 't');
                    $this->db->set('observacoes', $_POST['observacoes']);
                    $data = date("Y-m-d");
                    $hora = date("H:i:s");
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');

                    $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('data_inicio', $data_ficha);
                    $this->db->set('fim', $_POST['horarios']);
                    $this->db->set('inicio', $_POST['horarios']);
                    $this->db->set('data_fim', $data_ficha);
                    $this->db->set('data', $data_ficha);
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_agenda_exames');
                }
            }
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravaconsultasencaixe($ambulatorio_pacientetemp_id) {
        try {

            $this->db->select('nome');
            $this->db->from('tb_operador');
            $this->db->where('operador_id', $_POST['medico']);
            $query = $this->db->get();
            $return = $query->result();
            $explode = explode(" ", $return[0]->nome);
            $nome = $explode[0] . " " . $explode[1];
            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('nome', $nome);
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpacienteexistentegeral($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['celular']);
            $this->db->set('telefone', $_POST['telefone']);
            $this->db->set('convenio_id', $_POST['convenio1']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultaspacienteexistente($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['celular']);
            $this->db->set('telefone', $_POST['telefone']);
//            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfisioterapiapacienteexistente($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
//            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'FISIOTERAPIA');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarunificacao() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_exames');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_agenda_exames');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_ambulatorio_consulta');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_ambulatorio_guia');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_ambulatorio_laudo');

            // TB_laudo antigo
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_laudoantigo');

            if ($_POST['pacienteid'] != $_POST['paciente_id']) {
                $this->db->set('ativo', 'f');
                $this->db->set('data_exclusao', $horario);
                $this->db->set('operador_exclusao', $operador_id);
                $this->db->where('paciente_id', $_POST['pacienteid']);
                $this->db->update('tb_paciente');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function tipomultifuncaogeral($procedimento) {
        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimento);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarpacienteexames($agenda_exames_id, $tipo = null) {
        try {

            $this->db->select('agenda_exames_id,
                               data,
                               inicio,
                               fim,
                               medico_consulta_id');
            $this->db->from('tb_agenda_exames');
            $this->db->where("agenda_exames_id", $agenda_exames_id);
            $this->db->where("paciente_id is null");
            $query = $this->db->get();
            $return = $query->result();

            $this->db->select('medico');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->where("pc.procedimento_convenio_id", $_POST['procedimento1']);
            $querye = $this->db->get();
            $retorno = $querye->result();

            $data = $return[0]->data;
            $inicio = $return[0]->inicio;
            $fim = $return[0]->fim;
            $medico_consulta_id = $return[0]->medico_consulta_id;
//            var_dump($return);
//            echo '-----------';
//            var_dump($return[0]->data);
//            echo '-----------';
//            var_dump($return[0]->inicio);
//            echo '-----------';
//            var_dump($return[0]->fim);
//            echo '-----------';
//            var_dump($return[0]->medico_consulta_id);
//            echo '-----------';
//            die;
            if (count($return) == 1) {

                if ($_POST['txtNomeid'] == '') {
                    if ($_POST['nascimento'] != '') {
                        $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                    }
//                    if ($_POST['idade'] != 0) {
//                        $this->db->set('idade', $_POST['idade']);
//                    }

                    $this->db->set('celular', $_POST['txtCelular']);
                    $this->db->set('convenio_id', $_POST['convenio1']);

                    $this->db->set('telefone', $_POST['telefone']);
                    $this->db->set('nome', $_POST['txtNome']);
                    $this->db->insert('tb_paciente');
                    $paciente_id = $this->db->insert_id();
                } else {
                    $paciente_id = $_POST['txtNomeid'];

                    $this->db->set('celular', $_POST['txtCelular']);
                    $this->db->set('telefone', $_POST['telefone']);
                    $this->db->where("paciente_id", $paciente_id);
                    $this->db->update('tb_paciente');
                }

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                if (isset($_POST['medico']) && $_POST['medico'] != '') {
                    $this->db->set('medico_consulta_id', $_POST['medico']);
                    $this->db->set('medico_agenda', $_POST['medico']);
                }
                $this->db->set('situacao', 'OK');
                if ($tipo != null) {
                    $this->db->set('tipo', $tipo);
                }
                $this->db->set('observacoes', $_POST['observacoes']);
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
                if (isset($_POST['medico']) && $_POST['medico'] != '') {
                    $medico_consulta_id = $_POST['medico'];
                } else {
                    $medico_consulta_id = 0;
                }

                if ($retorno[0]->medico == 't') {
                    $this->db->set('ocupado', 't');
                    $this->db->where('medico_consulta_id', $medico_consulta_id);
                    $this->db->where('inicio >', $inicio);
                    $this->db->where('inicio <', $fim);
                    $this->db->where('data', $data);
                    $this->db->where('agenda_exames_id !=', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');

                    $this->db->set('ocupado', 't');
                    $this->db->where('medico_consulta_id', $medico_consulta_id);
                    $this->db->where('inicio <', $inicio);
                    $this->db->where('fim >', $fim);
                    $this->db->where('data', $data);
                    $this->db->where('agenda_exames_id !=', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                }
                return $paciente_id;
            } else {
                return 0;
            }
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarpacienteconsultas($agenda_exames_id) {
        try {
            $this->db->select('agenda_exames_id');
            $this->db->from('tb_agenda_exames');
            $this->db->where("agenda_exames_id", $agenda_exames_id);
            $this->db->where("paciente_id is null");
            $query = $this->db->get();
            $return = $query->result();

            if (count($return) == 1) {

                if ($_POST['txtNomeid'] == '') {
                    if ($_POST['nascimento'] != '') {
                        $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                    }
                    if ($_POST['idade'] != 0) {
                        $this->db->set('idade', $_POST['idade']);
                    }
                    $this->db->set('celular', $_POST['txtCelular']);
                    $this->db->set('convenio_id', $_POST['convenio']);
                    $this->db->set('telefone', $_POST['txtTelefone']);
                    $this->db->set('nome', $_POST['txtNome']);
                    $this->db->insert('tb_paciente');
                    $paciente_id = $this->db->insert_id();
                } else {
                    $paciente_id = $_POST['txtNomeid'];

                    $this->db->set('celular', $_POST['txtCelular']);
                    $this->db->set('telefone', $_POST['txtTelefone']);
                    $this->db->set('nome', $_POST['txtNome']);
                    $this->db->where('paciente_id', $paciente_id);
                    $this->db->update('tb_paciente');
                }
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $empresa_id = $this->session->userdata('empresa_id');

                $this->db->set('procedimento_tuss_id', $_POST['procedimento']);

//                $this->db->set('empresa_id', $empresa_id);

                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
                return $paciente_id;
            } else {
                return 0;
            }
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarpacientefisioterapia($agenda_exames_id) {
        try {

            $paciente_id = $_POST['txtNomeid'];

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'FISIOTERAPIA');
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', $_POST['observacoes']);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function crianovopacienteespecialidade() {
        if ($_POST['txtNomeid'] == '') {
            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['txtCelular']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->set('telefone', $_POST['txtTelefone']);
//                $this->db->set('numero_sessao', $_POST['sessao']);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->insert('tb_paciente');
            $paciente_id = $this->db->insert_id();
        } else {
            $paciente_id = $_POST['txtNomeid'];

            $this->db->set('celular', $_POST['txtCelular']);
            $this->db->set('telefone', $_POST['txtTelefone']);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->update('tb_paciente');
        }
        return $paciente_id;
    }

    function reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data) {
        try {

            $agenda_exames2 = $agenda_exames_id + 1;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'EXAME');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', 'reservado');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id is null');
            $this->db->where('data', $data);
            $this->db->where('agenda_exames_nome_id', $agenda_exames_nome_id);
            $this->db->where('agenda_exames_id', $agenda_exames2);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function reservarconsultatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        try {

            $agenda_exames2 = $agenda_exames_id + 1;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'CONSULTA');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', 'reservado');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id is null');
            $this->db->where('data', $data);
            $this->db->where('medico_consulta_id', $medico_consulta_id);
            $this->db->where('agenda_exames_id', $agenda_exames2);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function reservarfisioterapiatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        try {

            $agenda_exames2 = $agenda_exames_id + 1;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'FISIOTERAPIA');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', 'reservado');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id is null');
            $this->db->where('data', $data);
            $this->db->where('medico_consulta_id', $medico_consulta_id);
            $this->db->where('agenda_exames_id', $agenda_exames2);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function substituirpacientetemp($paciente_id, $paciente_temp_id) {
        try {
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_guia');
            $ambulatorio_guia_id = $this->db->insert_id();
            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = 0;
                $c = 0;
                $d = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $i++;
                foreach ($_POST['qtde'] as $itemnome) {
                    $c++;
                    if ($i == $c) {
                        $qtde = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valortotal'] as $itemnome) {
                    $d++;
                    if ($i == $d) {
                        $valortotal = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['convenio'] as $itemconvenio) {
                    $w++;
                    if ($i == $w) {
                        $convenio = $itemconvenio;
                        break;
                    }
                }
                foreach ($_POST['autorizacao'] as $itemautorizacao) {
                    $b++;
                    if ($i == $b) {
                        $autorizacao = $itemautorizacao;
                        break;
                    }
                }
                foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                    $x++;
                    if ($i == $x) {
                        $agenda_exames_id = $itemagenda_exames_id;
                        break;
                    }
                }
                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }
                $procedimento_tuss_id = (int) $procedimento_tuss_id;
                $agenda_exames_id = (int) $agenda_exames_id;
                if ($confimado == "on" && $procedimento_tuss_id > 0) {
                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('tipo', 'EXAME');
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->set('convenio_id', $convenio);
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', $qtde);
                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $valor)));
                    $this->db->set('valor_total', str_replace(",", ".", str_replace(".", "", $valortotal)));
                    $this->db->set('confirmado', 't');
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarguia($paciente_id) {
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('tipo', 'EXAME');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data_criacao', $data);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_guia');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function autorizarpacientetemp($paciente_id, $ambulatorio_guia_id) {
        try {
//            var_dump($_POST['medicoexecutante']);
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $formapagamento = 0;
                $z = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $k = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $j = 0;
                $i++;

                foreach ($_POST['qtde'] as $itemnome) {
                    $c++;
                    if ($i == $c) {
                        $qtde = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['formapamento'] as $itemnome) {
                    $e++;
                    if ($i == $e) {
                        $formapagamento = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }
                if ($confimado == "on" && $procedimento_tuss_id > 0) {

                    foreach ($_POST['convenio'] as $itemconvenio) {
                        $w++;
                        if ($i == $w) {
                            $convenio = $itemconvenio;
                            $this->db->select('dinheiro');
                            $this->db->from('tb_convenio');
                            $this->db->where("convenio_id", $convenio);
                            $query = $this->db->get();
                            $return = $query->result();
                            $dinheiro = $return[0]->dinheiro;

                            break;
                        }
                    }
                    foreach ($_POST['indicacao'] as $itemindicacao) {
                        $k++;
                        if ($i == $k) {
                            $indicacao = $itemindicacao;
                            break;
                        }
                    }
                    foreach ($_POST['medicoexecutante'] as $itemmedicoexecutante) {
                        $j++;
                        if ($i == $j) {
                            $medicoexecutante = $itemmedicoexecutante;
                            break;
                        }
                    }
                    if ($medicoexecutante == '') {
                        $medicoexecutante = 0;
                    }
//                var_dump($medicoexecutante); die;
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medicoexecutante);
                    $this->db->where('mc.ativo', 'true');
                    $percentual = $this->db->get()->result();

                    if (count($percentual) == 0) {
                        $this->db->select('pt.perc_medico, pt.percentual');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
                        $this->db->where('pc.ativo', 'true');
                        $this->db->where('pt.ativo', 'true');
                        $percentual = $this->db->get()->result();
                    }

//                var_dump($percentual); die;

                    foreach ($_POST['autorizacao'] as $itemautorizacao) {
                        $b++;
                        if ($i == $b) {
                            $autorizacao = $itemautorizacao;
                            break;
                        }
                    }
                    foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                        $x++;
                        if ($i == $x) {
                            $agenda_exames_id = $itemagenda_exames_id;
                            break;
                        }
                    }
                    foreach ($_POST['crm'] as $crm) {
                        $f++;
                        if ($i == $f) {
                            $medico_id = $crm;
                            break;
                        }
                    }

                    foreach ($_POST['data'] as $key => $itemdata) {
                        $h++;
                        if ($i == $h) {
                            $entregadata = $itemdata;
                            break;
                        }
                    }
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $procedimento_tuss_id = (int) $procedimento_tuss_id;
                    $agenda_exames_id = (int) $agenda_exames_id;

                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->set('convenio_id', $convenio);
                    if ($entregadata != "") {
                        $this->db->set('data_entrega', $entregadata);
                    }
                    if ($_POST['ordenador'] != "") {
                        $this->db->set('ordenador', $_POST['ordenador']);
                    }
                    if ($indicacao != "") {
                        $this->db->set('indicacao', $indicacao);
                    }
                    $this->db->set('medico_solicitante', $medico_id);
                    if ($medicoexecutante != "") {
                        $this->db->set('medico_agenda', $medicoexecutante);
                        $this->db->set('medico_consulta_id', $medicoexecutante);
                    }

                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', $qtde);
                    $this->db->set('valor', $valor);
                    $valortotal = $valor * $qtde;
                    $this->db->set('valor_total', $valortotal);

                    if ($formapagamento != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valortotal);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }
                    $this->db->set('confirmado', 't');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";

                    $this->db->select('ae.agenda_exames_id,
                            ae.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.sexo,
                            ae.agenda_exames_id,
                            ae.inicio,
                            c.nome as convenio,
                            ae.operador_autorizacao,
                            o.nome as tecnico,
                            ae.data_autorizacao,
                            pt.nome as procedimento,
                            pt.codigo,
                            ae.guia_id,
                            pt.grupo,
                            pc.procedimento_tuss_id');
                    $this->db->from('tb_agenda_exames ae');
                    $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
                    $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
                    $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
                    $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
                    $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
                    $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
                    $query = $this->db->get();
                    $return = $query->result();


                    $grupo = $return[0]->grupo;
                    if ($grupo == 'RX' || $grupo == 'MAMOGRAFIA') {
                        $grupo = 'CR';
                    }
                    if ($grupo == 'RM') {
                        $grupo = 'MR';
                    }

                    if ($grupo == 'TOMOGRAFIA') {
                        $grupo = 'CT';
                    }

                    if ($grupo == 'DENSITOMETRIA') {
                        $grupo = 'DX';
                    }

                    $this->db->set('wkl_aetitle', "AETITLE");
                    $this->db->set('wkl_procstep_startdate', str_replace("-", "", date("Y-m-d")));
                    $this->db->set('wkl_procstep_starttime', str_replace(":", "", date("H:i:s")));
                    $this->db->set('wkl_modality', $grupo);
                    $this->db->set('wkl_perfphysname', $return[0]->tecnico);
                    $this->db->set('wkl_procstep_descr', $return[0]->procedimento);
                    $this->db->set('wkl_procstep_id', $return[0]->codigo);
                    $this->db->set('wkl_reqprocid', $return[0]->codigo);
                    $this->db->set('wkl_reqprocdescr', $return[0]->procedimento);
                    $this->db->set('wkl_studyinstuid', $agenda_exames_id);
                    $this->db->set('wkl_accnumber', $agenda_exames_id);
                    $this->db->set('wkl_reqphysician', $return[0]->convenio);
                    $this->db->set('wkl_patientid', $return[0]->paciente_id);
                    $this->db->set('wkl_patientname', $return[0]->paciente);
                    $this->db->set('wkl_patientbirthdate', str_replace("-", "", $return[0]->nascimento));
                    $this->db->set('wkl_patientsex', $return[0]->sexo);
                    $this->db->set('wkl_exame_id', $agenda_exames_id);

                    $this->db->insert('tb_integracao');
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function autorizarpacientetempconsulta($paciente_id, $ambulatorio_guia_id) {
        try {
//            $testemedico = $_POST['medico_id'];
//            var_dump($_POST['medico_id']); die;
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $formapagamento = 0;
                $z = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $k = 0;
                $i++;

                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }
//Verifica o confirmado e entra de fato na função
                if ($confimado == "on" && $procedimento_tuss_id > 0) {

                    foreach ($_POST['sala'] as $itemnome) {
                        $c++;
                        if ($i == $c) {
                            $sala = $itemnome;
                            break;
                        }
                    }
                    foreach ($_POST['valor'] as $itemnome) {
                        $z++;
                        if ($i == $z) {
                            $valor = $itemnome;
                            break;
                        }
                    }
                    foreach ($_POST['formapamento'] as $itemnome) {
                        $e++;
                        if ($i == $e) {
                            $formapagamento = $itemnome;
                            break;
                        }
                    }
                    foreach ($_POST['indicacao'] as $itemindicacao) {
                        $k++;
                        if ($i == $k) {
                            $indicacao = $itemindicacao;
                            break;
                        }
                    }
                    foreach ($_POST['convenio'] as $itemconvenio) {
                        $w++;
                        if ($i == $w) {
                            $convenio = $itemconvenio;
                            $this->db->select('dinheiro');
                            $this->db->from('tb_convenio');
                            $this->db->where("convenio_id", $convenio);
                            $query = $this->db->get();
                            $return = $query->result();
                            $dinheiro = $return[0]->dinheiro;

                            break;
                        }
                    }
                    foreach ($_POST['autorizacao'] as $itemautorizacao) {
                        $b++;
                        if ($i == $b) {
                            $autorizacao = $itemautorizacao;
                            break;
                        }
                    }
                    foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                        $x++;
                        if ($i == $x) {
                            $agenda_exames_id = $itemagenda_exames_id;
                            break;
                        }
                    }
                    foreach ($_POST['medico_id'] as $crm) {
                        $f++;
                        if ($i == $f) {
                            $medico_id = $crm;
                            break;
                        }
                    }

                    if ($medico_id == '') {
                        $medico_id = 0;
                    }

                    // Função do Percentual
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medico_id);
                    $this->db->where('mc.ativo', 'true');
                    $percentual = $this->db->get()->result();

                    if (count($percentual) == 0) {
                        $this->db->select('pt.perc_medico, pt.percentual');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
                        $this->db->where('pc.ativo', 'true');
                        $this->db->where('pt.ativo', 'true');
                        $percentual = $this->db->get()->result();
                    }
//                var_dump($_POST['agenda_exames_id']); die;


                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $procedimento_tuss_id = (int) $procedimento_tuss_id;
                    $agenda_exames_id = (int) $agenda_exames_id;


                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);

                    $this->db->set('convenio_id', $convenio);
                    if ($_POST['ordenador'] != "") {
                        $this->db->set('ordenador', $_POST['ordenador']);
                    }
                    if ($medico_id != "") {
                        $this->db->set('medico_agenda', $medico_id);
                        $this->db->set('medico_consulta_id', $medico_id);
                    }
                    $this->db->set('autorizacao', $autorizacao);
                    if ($indicacao != "") {
                        $this->db->set('indicacao', $indicacao);
                    }
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', '1');
                    $this->db->set('agenda_exames_nome_id', $sala);
                    $this->db->set('valor', $valor);
                    $this->db->set('valor_total', $valor);
                    if ($formapagamento != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }

                    $this->db->set('confirmado', 't');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function autorizarpacientetempfisioterapia($paciente_id, $ambulatorio_guia_id) {
        try {
//            $testemedico = $_POST['medico_id'];
//            var_dump($_POST['medico_id']);die;
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $j = 0;
                $k = 0;
                $m = 0;
                $i++;

                foreach ($_POST['sala'] as $itemnome) {
                    $c++;
                    if ($i == $c) {
                        $sala = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['formapamento'] as $itemnome) {
                    $e++;
                    if ($i == $e) {
                        $formapagamento = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['indicacao'] as $itemindicacao) {
                    $k++;
                    if ($i == $k) {
                        $indicacao = $itemindicacao;
                        break;
                    }
                }

                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }

                if ($confimado == "on" && $procedimento_tuss_id > 0) {

                    foreach ($_POST['convenio'] as $itemconvenio) {
                        $w++;
                        if ($i == $w) {
                            $convenio = $itemconvenio;
                            $this->db->select('dinheiro');
                            $this->db->from('tb_convenio');
                            $this->db->where("convenio_id", $convenio);
                            $query = $this->db->get();
                            $return = $query->result();
                            $dinheiro = $return[0]->dinheiro;
                            break;
                        }
                    }
                    foreach ($_POST['autorizacao'] as $itemautorizacao) {
                        $b++;
                        if ($i == $b) {
                            $autorizacao = $itemautorizacao;
                            break;
                        }
                    }
                    foreach ($_POST['qtde'] as $itemqtde) {
                        $j++;
                        if ($i == $j) {
                            $qtde = $itemqtde;
                            break;
                        }
                    }
                    foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                        $x++;
                        if ($i == $x) {
                            $agenda_exames_id = $itemagenda_exames_id;
                            break;
                        }
                    }
                    foreach ($_POST['medico_id'] as $crm) {
                        $f++;
                        if ($i == $f) {
                            $medico_id = $crm;
                            break;
                        }
                    }

                    foreach ($_POST['crm'] as $crm) {
                        $m++;
                        if ($i == $f) {
                            $medico_solicitante = $crm;
                            break;
                        }
                    }
                    if ($medico_id == '') {
                        $medico_id = 0;
                    }

                    // Função do Percentual
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medico_id);
                    $this->db->where('mc.ativo', 'true');
                    $percentual = $this->db->get()->result();

                    if (count($percentual) == 0) {
                        $this->db->select('pt.perc_medico, pt.percentual');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
                        $this->db->where('pc.ativo', 'true');
                        $this->db->where('pt.ativo', 'true');
                        $percentual = $this->db->get()->result();
                    }
//                var_dump($percentual); die;



                    $horario = date("Y-m-d H:i:s");
                    $datahoje = date("Y-m-d");
                    $operador_id = $this->session->userdata('operador_id');
                    $procedimento_tuss_id = (int) $procedimento_tuss_id;
                    $agenda_exames_id = (int) $agenda_exames_id;


                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);

                    $this->db->set('convenio_id', $convenio);
                    if ($_POST['ordenador'] != "") {
                        $this->db->set('ordenador', $_POST['ordenador']);
                    }
                    if ($medico_id != "") {
                        $this->db->set('medico_agenda', $medico_id);
                        $this->db->set('medico_consulta_id', $medico_id);
                    }

                    if ($medico_solicitante != "") {
                        $this->db->set('medico_solicitante', $medico_solicitante);
                    }
                    if ($indicacao != "") {
                        $this->db->set('indicacao', $indicacao);
                    }
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', '1');
                    $this->db->set('agenda_exames_nome_id', $sala);
                    if ($dinheiro == "t") {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    }
                    $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                    $this->db->set('numero_sessao', '1');
                    $this->db->set('qtde_sessao', $qtde);
                    if ($formapagamento != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }
                    $this->db->set('ativo', 'f');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                    for ($index = 2; $index <= $qtde; $index++) {
                        $this->db->set('convenio_id', $convenio);
                        $this->db->set('empresa_id', $empresa_id);
                        $this->db->set('tipo', 'FISIOTERAPIA');
                        if ($_POST['ordenador'] != "") {
                            $this->db->set('ordenador', $_POST['ordenador']);
                        }
                        if ($medico_id != "") {
                            $this->db->set('medico_agenda', $medico_id);
                            $this->db->set('medico_consulta_id', $medico_id);
                        }
                        $this->db->set('autorizacao', $autorizacao);
                        $this->db->set('guia_id', $ambulatorio_guia_id);
                        $this->db->set('quantidade', '1');
                        $this->db->set('agenda_exames_nome_id', $sala);
                        if ($dinheiro == "t") {
                            $this->db->set('valor', 0);
                            $this->db->set('valor_total', 0);
                            $this->db->set('confirmado', 'f');
                        } else {
                            $this->db->set('valor', $valor);
                            $this->db->set('valor_total', $valor);
                            $this->db->set('confirmado', 'f');
                        }
                        $this->db->set('situacao', 'OK');
                        $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                        $this->db->set('numero_sessao', $index);
                        $this->db->set('qtde_sessao', $qtde);
                        if ($formapagamento != 0 && $dinheiro == "t") {
                            $this->db->set('faturado', 't');
                            $this->db->set('forma_pagamento', $formapagamento);
                            $this->db->set('valor1', $valor);
                            $this->db->set('operador_faturamento', $operador_id);
                            $this->db->set('data_faturamento', $horario);
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                        $this->db->set('paciente_id', $paciente_id);
                        $this->db->set('ambulatorio_pacientetemp_id', null);
                        $this->db->set('data_autorizacao', $horario);
                        $this->db->set('data', $datahoje);
                        $this->db->set('operador_autorizacao', $operador_id);
                        $this->db->insert('tb_agenda_exames');
                        $confimado = "";
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function verificaexamemedicamento($procedimento_convenio_id) {

        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $query = $this->db->get();
        $tipo = $query->result();
        return $tipo[0]->tipo;
    }

    function autorizarpacientetempgeral($paciente_id, $ambulatorio_guia_id) {
        try {
//            $testemedico = $_POST['medico_id'];
//            var_dump($_POST['indicacao']); die;
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $j = 0;
                $t = 0;
                $k = 0;
                $i++;


                $tipo = $this->verificaexamemedicamento($procedimento_tuss_id);
                if (($tipo == 'EXAME' || $tipo == 'MEDICAMENTO') && $_POST['medico'][$i] == '') {
                    return 2;
                }

                foreach ($_POST['sala'] as $itemnome) {
                    $c++;
                    if ($i == $c) {
                        $sala = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['formapamento'] as $itemnome) {
                    $e++;
                    if ($i == $e) {
                        $formapagamento = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['indicacao'] as $itemindicacao) {
                    $k++;
                    if ($i == $k) {
                        $indicacao = $itemindicacao;
                        break;
                    }
                }
                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }

                if ($confimado == "on" && $procedimento_tuss_id > 0) {

                    foreach ($_POST['convenio'] as $itemconvenio) {
                        $w++;
                        if ($i == $w) {
                            $convenio = $itemconvenio;
                            $this->db->select('dinheiro');
                            $this->db->from('tb_convenio');
                            $this->db->where("convenio_id", $convenio);
                            $query = $this->db->get();
                            $return = $query->result();
                            $dinheiro = $return[0]->dinheiro;
                            break;
                        }
                    }
                    foreach ($_POST['autorizacao'] as $itemautorizacao) {
                        $b++;
                        if ($i == $b) {
                            $autorizacao = $itemautorizacao;
                            break;
                        }
                    }
                    foreach ($_POST['qtde'] as $itemqtde) {
                        $j++;
                        if ($i == $j) {
                            $qtde = $itemqtde;
                            break;
                        }
                    }
                    foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                        $x++;
                        if ($i == $x) {
                            $agenda_exames_id = $itemagenda_exames_id;
                            break;
                        }
                    }
                    foreach ($_POST['medico_id'] as $crm) {
                        $f++;
                        if ($i == $f) {
                            $medico_id = $crm;
                            break;
                        }
                    }
                    if ($medico_id == '') {
                        $medico_id = 0;
                    }

                    // Função do Percentual
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medico_id);
                    $this->db->where('mc.ativo', 'true');
                    $percentual = $this->db->get()->result();

                    if (count($percentual) == 0) {
                        $this->db->select('pt.perc_medico, pt.percentual');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
                        $this->db->where('pc.ativo', 'true');
                        $this->db->where('pt.ativo', 'true');
                        $percentual = $this->db->get()->result();
                    }
//                var_dump($percentual); die;


                    foreach ($_POST['crm'] as $crmsolicitante) {
                        $t++;
                        if ($i == $t) {
                            $solicitante = $crmsolicitante;
                            break;
                        }
                    }

                    $horario = date("Y-m-d H:i:s");
                    $datahoje = date("Y-m-d");
                    $operador_id = $this->session->userdata('operador_id');
                    $procedimento_tuss_id = (int) $procedimento_tuss_id;
                    $agenda_exames_id = (int) $agenda_exames_id;


                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);

                    $this->db->set('convenio_id', $convenio);
                    if ($_POST['ordenador'] != "") {
                        $this->db->set('ordenador', $_POST['ordenador']);
                    }
                    if ($medico_id != "") {
                        $this->db->set('medico_agenda', $medico_id);
                        $this->db->set('medico_consulta_id', $medico_id);
                    }
                    if ($indicacao != "") {
                        $this->db->set('indicacao', $indicacao);
                    }
                    if ($crmsolicitante != "") {
                        $this->db->set('medico_solicitante', $crmsolicitante);
                    }
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', '1');
                    $this->db->set('agenda_exames_nome_id', $sala);
                    if ($dinheiro == "t") {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    }
                    $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                    $this->db->set('numero_sessao', '1');
                    $this->db->set('qtde_sessao', $qtde);
                    if ($formapagamento != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }
                    $this->db->set('ativo', 'f');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                    for ($index = 2; $index <= $qtde; $index++) {
                        $this->db->set('convenio_id', $convenio);
                        $this->db->set('empresa_id', $empresa_id);
                        $this->db->set('tipo', 'FISIOTERAPIA');
                        if ($_POST['ordenador'] != "") {
                            $this->db->set('ordenador', $_POST['ordenador']);
                        }
                        if ($medico_id != "") {
                            $this->db->set('medico_agenda', $medico_id);
                            $this->db->set('medico_consulta_id', $medico_id);
                        }
                        $this->db->set('autorizacao', $autorizacao);
                        $this->db->set('guia_id', $ambulatorio_guia_id);
                        $this->db->set('quantidade', '1');
                        $this->db->set('agenda_exames_nome_id', $sala);
                        if ($dinheiro == "t") {
                            $this->db->set('valor', 0);
                            $this->db->set('valor_total', 0);
                            $this->db->set('confirmado', 'f');
                        } else {
                            $this->db->set('valor', $valor);
                            $this->db->set('valor_total', $valor);
                            $this->db->set('confirmado', 'f');
                        }
                        $this->db->set('situacao', 'OK');
                        $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                        $this->db->set('numero_sessao', $index);
                        $this->db->set('qtde_sessao', $qtde);
                        if ($formapagamento != 0 && $dinheiro == "t") {
                            $this->db->set('faturado', 't');
                            $this->db->set('forma_pagamento', $formapagamento);
                            $this->db->set('valor1', $valor);
                            $this->db->set('operador_faturamento', $operador_id);
                            $this->db->set('data_faturamento', $horario);
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                        $this->db->set('paciente_id', $paciente_id);
                        $this->db->set('ambulatorio_pacientetemp_id', null);
                        $this->db->set('data_autorizacao', $horario);
                        $this->db->set('data', $datahoje);
                        $this->db->set('operador_autorizacao', $operador_id);
                        $this->db->insert('tb_agenda_exames');
                        $confimado = "";
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function asdçasjdlasjdasld() {

        $this->db->select();
        $this->db->from('tb_operador');



        $this->db->set('valor_medico', null);
        $this->db->set('percentual_medico', $horario);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
    }

    function verificamedico($crm) {
        $this->db->select();
        $this->db->from('tb_operador');
        $this->db->where('conselho', $crm);
        $this->db->where('medico', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function gravarmedico($crm, $medico) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('conselho', $crm);
        $this->db->set('nome', $medico);
        $this->db->set('medico', 't');
        $this->db->insert('tb_operador');
        $medico_id = $this->db->insert_id();
        return $medico_id;
    }

    function listarmedico($crm) {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('conselho', $crm);
        $this->db->where('medico', 'true');
        $return = $this->db->get();
        return $return->row_array();
    }

    function listarautocompletemedicamentounidade($parametro = null) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('amu.ambulatorio_receituario_medicamento_unidade_id as unidade_id,
                           amu.descricao');
        $this->db->from('tb_ambulatorio_receituario_medicamento_unidade amu');
        $this->db->where('ativo', 'true');
        $this->db->orderby('descricao');
        if ($parametro != null) {
            $this->db->where('descricao ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletehorarios($parametro = null, $teste = null) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('a.agenda_exames_id,
                            es.nome,
                            o.nome as medico,
                            a.medico_agenda,
                            a.inicio,
                            a.fim,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.empresa_id', $empresa_id);
        $this->db->where('a.tipo', 'EXAME');
        $this->db->orderby('es.nome');
        $this->db->orderby('a.inicio');
        if ($parametro != null) {
            $this->db->where('es.nome ilike', "%" . $parametro . "%");
            $this->db->where('a.data', $teste);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosconsulta($parametro = null, $teste = null) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('a.agenda_exames_id,
                            o.nome as medico,
                            a.inicio,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id');
        $this->db->orderby('a.inicio');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.tipo', 'CONSULTA');
        $this->db->where('a.empresa_id', $empresa_id);
        if ($parametro != null) {
            $this->db->where('a.medico_consulta_id', $parametro);
            $this->db->where('a.data', $teste);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosespecialidade($parametro = null, $teste = null) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('a.agenda_exames_id,
                            o.nome as medico,
                            a.inicio,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id');

        $this->db->where('a.ativo', 'true');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where("( (a.tipo = 'FISIOTERAPIA') OR (a.tipo = 'ESPECIALIDADE') )");
        $this->db->where('a.empresa_id', $empresa_id);
        if ($parametro != null) {
            $this->db->where('a.medico_agenda', $parametro);
            $this->db->where('a.data', $teste);
        }
        $this->db->orderby('a.inicio');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosgeral($parametro = null, $teste = null) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('a.agenda_exames_id,
                            o.nome as medico,
                            a.inicio,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id');
        $this->db->orderby('a.inicio');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.empresa_id', $empresa_id);
        if ($parametro != null) {
            $this->db->where('a.medico_consulta_id', $parametro);
            $this->db->where('a.data', $teste);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentostodos($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosconveniomedico($parametro, $teste) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_convenio_operador_procedimento cop');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = cop.procedimento_convenio_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where("cop.ativo", 't');
        $this->db->where('cop.convenio_id', $parametro);
        $this->db->where('cop.operador', $teste);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteconveniopaciente($parametro) {
        $this->db->select(' c.convenio_id,
                            c.nome');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->where("p.ativo", 't');
        $this->db->where("c.ativo", 't');
        $this->db->where('p.paciente_id', $parametro);
        $this->db->orderby("c.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentos($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("ag.tipo !=", 'CONSULTA');
        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosgrupo($parametro, $parametro2) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("ag.tipo !=", 'CONSULTA');
        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->where('pt.grupo', $parametro2);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicoconvenio($parametro) {

        $this->db->select('c.convenio_id,
                            c.nome,');
        $this->db->from('tb_ambulatorio_convenio_operador co');
        $this->db->join('tb_convenio c', 'c.convenio_id = co.convenio_id', 'left');
        $this->db->where('co.operador_id', $parametro);
        $this->db->where('co.ativo', 't');
        $this->db->where('c.ativo', 't');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosajustarvalor($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosconsulta($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("ag.tipo !=", 'EXAME');
        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosfisioterapia($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'EXAME');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicoespecialidade($parametro) {
        $this->db->select(' o.nome,
                            o.operador_id,
                            ');
        $this->db->from('tb_cbo_ocupacao co');
        $this->db->join('tb_operador o', 'co.cbo_ocupacao_id = o.cbo_ocupacao_id', 'left');
        $this->db->where('co.cbo_ocupacao_id', $parametro);
        $this->db->where('o.ativo', 't');
        $this->db->where('o.medico', 't');
        $this->db->where('o.usuario is not null');
        $this->db->orderby("o.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarespecialidade() {
        $this->db->select('distinct(co.cbo_ocupacao_id),
                               co.descricao');
        $this->db->from('tb_operador o');
        $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
        $this->db->join('tb_cbo_ocupacao co', 'co.cbo_ocupacao_id = o.cbo_ocupacao_id');
        $this->db->where('consulta', 'true');
        $this->db->where('o.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentospsicologia($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pt.grupo", 'PSICOLOGIA');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosvalor($parametro = null) {
        $this->db->select('pc.valortotal, pt.qtde, pt.descricao_procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.procedimento_convenio_id', $parametro);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosvalor2($parametro = null, $parametro2 = null) {
        $this->db->select('pc.valortotal');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro2);
        $this->db->where('pc.procedimento_tuss_id', $parametro);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosforma($parametro = null) {
        $this->db->select('fp.nome,
                           fp.forma_pagamento_id');
        $this->db->from('tb_procedimento_convenio_pagamento cp');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = cp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
//        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = cp.forma_pagamento_id', 'left');
        $this->db->where('cp.procedimento_convenio_id', $parametro);
        $return = $this->db->get();
        $result = $return->result();

        if (empty($result)) {
            $this->db->select('fp.nome,
                           fp.forma_pagamento_id');
            $this->db->from('tb_forma_pagamento fp');
            $return2 = $this->db->get();
            $result2 = $return2->result();
            return $result2;
        } else {
            return $result;
        }
    }

    function listarautocompletemodelos($parametro = null) {
        $this->db->select('ambulatorio_modelo_laudo_id,
                            nome,
                            texto');
        $this->db->from('tb_ambulatorio_modelo_laudo');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('ambulatorio_modelo_laudo_id', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemodelosdeclaracao($parametro = null) {
        $this->db->select('ambulatorio_modelo_declaracao_id,
                            nome,
                            texto');
        $this->db->from('tb_ambulatorio_modelo_declaracao');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('ambulatorio_modelo_declaracao_id', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarmodeloslaudo($procedimento_tuss_id) {
        $this->db->select('aml.ambulatorio_modelo_laudo_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_laudo aml');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = aml.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where('aml.ativo', 'true');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemodelosreceita($parametro = null) {
        $this->db->select('aml.ambulatorio_modelo_receita_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_receita aml');
        $this->db->where('aml.ativo', 'true');
        if ($parametro != null) {
            $this->db->where('ambulatorio_modelo_receita_id', $parametro);
        }
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemodelosatestado($parametro = null) {
        $this->db->select('aml.ambulatorio_modelo_atestado_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_atestado aml');
        $this->db->where('aml.ativo', 'true');
        if ($parametro != null) {
            $this->db->where('ambulatorio_modelo_atestado_id', $parametro);
        }
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemodelossolicitarexames($parametro = null) {
        $this->db->select('aml.ambulatorio_modelo_solicitar_exames_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_solicitar_exames aml');
        $this->db->where('aml.ativo', 'true');
        if ($parametro != null) {
            $this->db->where('ambulatorio_modelo_solicitar_exames_id', $parametro);
        }
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemodelosreceitaespecial($parametro = null) {
        $this->db->select('aml.ambulatorio_modelo_receita_especial_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_receita_especial aml');
        $this->db->where('aml.ativo', 'true');
        if ($parametro != null) {
            $this->db->where('ambulatorio_modelo_receita_especial_id', $parametro);
        }
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicamentolaudo($parametro = null) {
        $this->db->select('ambulatorio_receituario_medicamento_id,
                           nome,
                           quantidade,
                           unidade_id,
                           u.descricao,
                           posologia,
                           texto');
        $this->db->from('tb_ambulatorio_receituario_medicamento m');
        $this->db->where('m.ativo', 'true');
        $this->db->join('tb_ambulatorio_receituario_medicamento_unidade u', 'u.ambulatorio_receituario_medicamento_unidade_id = m.unidade_id', 'left');
//        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('nome ilike', '%' . $parametro . '%');
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletelinha($parametro = null) {
        $this->db->select('ambulatorio_modelo_linha_id,
                            nome,
                            texto');
        $this->db->from('tb_ambulatorio_modelo_linha');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarmodeloslinha($procedimento_tuss_id) {
        $this->db->select('aml.ambulatorio_modelo_linha_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_linha aml');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = aml.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where('aml.ativo', 'true');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($agenda_exames_id) {

        $this->db->set('ativo', 't');
        $this->db->set('situacao', 'LIVRE');
        $this->db->set('observacoes', "");
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ambulatorio_pacientetemp_id', null);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirprocedimentoguia($agenda_exames_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('paciente_id', null);
        $this->db->set('procedimento_tuss_id', null);
        $this->db->set('guia_id', null);
        $this->db->set('situacao', "LIVRE");
        $this->db->set('observacoes', "");
        $this->db->set('valor', NULL);
        $this->db->set('ativo', 't');
        $this->db->set('convenio_id', null);
        $this->db->set('autorizacao', null);
        $this->db->set('operador_atualizacao', null);
        $this->db->set('confirmado', 'f');
        $this->db->set('data_cancelamento', $horario);
        $this->db->set('operador_cancelamento', $operador_id);
        $this->db->set('cancelada', 't');
        $this->db->set('situacao', 'CANCELADO');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
    }

    function excluirexametemp($agenda_exames_id) {

        $this->db->set('paciente_id', null);
        $this->db->set('procedimento_tuss_id', null);
        $this->db->set('convenio_id', null);
//        $this->db->set('medico_consulta_id', null);
//        $this->db->set('medico_agenda', null);
        $this->db->set('ativo', 't');
        $this->db->set('encaixe', 'f');
        $this->db->set('situacao', 'LIVRE');
        $this->db->set('observacoes', "");
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ambulatorio_pacientetemp_id', null);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirexametempencaixe($agenda_exames_id) {


        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->delete('tb_agenda_exames');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function criar() {

        $this->db->set('nome', '');
        $this->db->insert('tb_ambulatorio_pacientetemp');
        $ambulatorio_pacientetemp_id = $this->db->insert_id();

        return $ambulatorio_pacientetemp_id;
    }

    function gravar() {
        try {

            /* inicia o mapeamento no banco */
            $procedimento_tuss_id = $_POST['txtprocedimentotussid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('tuss_id', $_POST['txtprocedimento']);
            $this->db->set('codigo', $_POST['txtcodigo']);
            $this->db->set('descricao', $_POST['txtdescricao']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtprocedimentotussid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_procedimento_tuss');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $procedimento_tuss_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $procedimento_tuss_id = $_POST['txtprocedimentotussid'];
                $this->db->where('procedimento_tuss_id', $procedimento_tuss_id);
                $this->db->update('tb_procedimento_tuss');
            }

            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirpaciente($paciente_id) {
        try {

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_exclusao', $horario);
            $this->db->set('operador_exclusao', $operador_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->update('tb_paciente');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_pacientetemp_id) {

        if ($ambulatorio_pacientetemp_id != 0) {
            $this->db->select('nome, nascimento, idade, celular, telefone');
            $this->db->from('tb_paciente');
            $this->db->where("paciente_id", $ambulatorio_pacientetemp_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_pacientetemp_id = $ambulatorio_pacientetemp_id;

            $this->_nome = $return[0]->nome;
            $this->_nascimento = $return[0]->nascimento;
            $this->_idade = $return[0]->idade;
            $this->_celular = $return[0]->celular;
            $this->_telefone = $return[0]->telefone;
        } else {
            $this->_ambulatorio_pacientetemp_id = null;
        }
    }

}

?>
