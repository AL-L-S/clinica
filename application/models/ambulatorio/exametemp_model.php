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

    function listarsaldocreditopaciente($paciente_id) {

        $this->db->select('SUM(pcr.valor) as saldo');
        $this->db->from('tb_paciente_credito pcr');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->where('pcr.empresa_id', $empresa_id);
        $this->db->where('pcr.ativo', 'true');
        $this->db->where("(pcr.faturado = 't' OR pcr.valor < 0)");
        $this->db->where('pcr.paciente_id', $paciente_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listarcreditofaturar($credito_id) {

        $this->db->select('pcr.valor, pcr.forma_pagamento_ajuste, pcr.valor_forma_pagamento_ajuste as valor_ajuste');
        $this->db->from('tb_paciente_credito pcr');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->where('pcr.empresa_id', $empresa_id);
//        $this->db->where('pcr.ativo', 'true');
        $this->db->where('pcr.paciente_credito_id', $credito_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listarpacienteporguia($guia_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('ambulatorio_guia_id', $guia_id);

        $return = $this->db->get();
        $return = $return->result();

        return $return[0]->paciente_id;
    }

    function listarcredito($paciente_id) {

        $this->db->select('pcr.paciente_credito_id,
                           pcr.paciente_id,
                           pcr.procedimento_convenio_id,
                           pcr.valor,
                           pcr.data,
                           pcr.faturado,
                           c.nome as convenio,
                           p.nome as paciente,
                           pt.nome as procedimento');
        $this->db->from('tb_paciente_credito pcr');
        $this->db->join('tb_paciente p', 'p.paciente_id = pcr.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pcr.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('pcr.ativo', 'true');
        $this->db->where('pcr.valor > 0');
        $this->db->where('pcr.paciente_id', $paciente_id);
//        $this->db->where('pcr.procedimento_convenio_id IS NOT NULL');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->where('pcr.empresa_id', $empresa_id);

        if (@$_GET['procedimento'] != '') {
            $this->db->where('pt.nome ilike', "%" . $_GET['procedimento'] . "%");
        }

        if (@$_GET['convenio'] != '') {
            $this->db->where('c.nome ilike', "%" . $_GET['convenio'] . "%");
        }

        return $this->db;
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

    function listarlembretesoperador() {
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('empresa_lembretes_id,
                            texto');
        $this->db->from('tb_empresa_lembretes');
        $this->db->where("ativo", 't');
        $this->db->where("operador_destino", $operador_id);
        $this->db->orderby("data_cadastro DESC");
        $return = $this->db->get();
        return $return->result();
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

    function salvaragendamentoexcluido($ambulatorio_pacientetemp_id) {
        $this->db->select('agenda_exames_id,
                            paciente_id,
                            procedimento_tuss_id,
                            data,
                            empresa_id,
                            observacoes');
        $this->db->from('tb_agenda_exames');
        $this->db->where("agenda_exames_id", $ambulatorio_pacientetemp_id);
        $return = $this->db->get()->result();

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('agenda_exames_id', $return[0]->agenda_exames_id);
        $this->db->set('paciente_id', $return[0]->paciente_id);
        $this->db->set('procedimento_tuss_id', $return[0]->procedimento_tuss_id);
        $this->db->set('empresa_id', $return[0]->empresa_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_atendimentos_excluiragendado');

//        var_dump($return);
//        die;
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
                            a.procedimento_tuss_id,
                            pc.convenio_id as convenio_agenda,
                            pt.grupo,
                            p.convenio_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("ag.tipo", 'EXAME');
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

    function listarpendenciasoperador() {
        $this->db->select('e.exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            e.data_cadastro,
                            e.data_pendente,
                            es.nome as sala,
                            pt.nome as procedimento');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = e.sala_id', 'left');
        $this->db->where('e.situacao', 'PENDENTE');
        $this->db->where('e.cancelada', 'false');

        $medico_id = $this->session->userdata('operador_id');
        $this->db->where('ae.medico_consulta_id', $medico_id);

        $return = $this->db->get();
        return $return->result();
    }

    function enviarpendenteatendimento($exame_id, $sala_id, $agenda_exames_id) {
        try {
            // Voltando exame
            $this->db->set('realizada', 'f');
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');

            $this->db->where('exames_id', $exame_id);
            $this->db->delete('tb_exames');

            $this->db->where('exame_id', $exame_id);
            $this->db->delete('tb_ambulatorio_laudo');

            // Enviando da sala de espera
            $this->db->select('ae.agenda_exames_nome_id, 
                               ae.paciente_id, 
                               ae.medico_agenda, 
                               ae.guia_id, 
                               ae.procedimento_tuss_id, 
                               e.medico_realizador,  
                               e.sala_id,  
                               ag.tipo');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join('tb_exames e', 'e.exames_id = ae.agenda_exames_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
            $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
            $retorno = $this->db->get()->result();

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('paciente_id', $retorno[0]->paciente_id);
            $this->db->set('procedimento_tuss_id', $retorno[0]->procedimento_tuss_id);
            $this->db->set('guia_id', $retorno[0]->guia_id);
            $this->db->set('tipo', $retorno[0]->tipo);
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('sala_id', $retorno[0]->sala_id);
            if ($retorno[0]->medico_realizador != "") {
                $this->db->set('medico_realizador', $retorno[0]->medico_realizador);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_exames');
            $exames_id = $this->db->insert_id();

            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data', $data);
            $this->db->set('paciente_id', $retorno[0]->paciente_id);
            $this->db->set('procedimento_tuss_id', $retorno[0]->procedimento_tuss_id);
            $this->db->set('exame_id', $exames_id);
            $this->db->set('guia_id', $retorno[0]->guia_id);
            $this->db->set('tipo', $retorno[0]->tipo);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            if ($retorno[0]->medico_realizador != "") {
                $this->db->set('medico_parecer1', $retorno[0]->medico_realizador);
            }
            $this->db->insert('tb_ambulatorio_laudo');
            $laudo_id = $this->db->insert_id();
            $guia_id = $retorno[0]->guia_id;

            if ($retorno[0]->medico_realizador != "") {
                $this->db->set('medico_consulta_id', $retorno[0]->medico_realizador);
                $this->db->set('medico_agenda', $retorno[0]->medico_realizador);

//                $this->db->set('valor_medico', $percentual[0]->perc_medico);
//                $this->db->set('percentual_medico', $percentual[0]->percentual);
            }
            $this->db->set('realizada', 'true');
            $this->db->set('senha', md5($agenda_exames_id));
            $this->db->set('data_realizacao', $horario);
            $this->db->set('operador_realizacao', $operador_id);
            $this->db->set('agenda_exames_nome_id', $retorno[0]->agenda_exames_nome_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('sala_id', $retorno[0]->sala_id);
            $this->db->set('paciente_id', $retorno[0]->paciente_id);
            $this->db->insert('tb_ambulatorio_chamada');
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function buscaexamesanteriores($paciente_id, $procedimento_id) {
        $data = date('Y-m-d', strtotime("-30 day", strtotime(date('Y-m-d'))));
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            a.tipo,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes,
                            a.procedimento_tuss_id,
                            pc.convenio_id as convenio_agenda,
                            p.convenio_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.cancelada", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.realizada", 't');
        $this->db->where('a.data <=', date('Y-m-d'));
        $this->db->where('a.data >=', $data);
        $this->db->where("a.empresa_id", $empresa_id);
        $this->db->where("a.paciente_id", $paciente_id);
        $this->db->where("a.procedimento_tuss_id", $procedimento_id);
        $return = $this->db->get();
        return $return->result();
    }

    function validaretornoprocedimento($paciente_id, $procedimento_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('pt.retorno_dias, pt.associacao_procedimento_tuss_id, pt.grupo, pt.procedimento_tuss_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_id);
        $return = $this->db->get();
        $return = $return->result();
//        var_dump($return[0]->associacao_procedimento_tuss_id); die;

        $data = date('Y-m-d', strtotime("-" . $return[0]->retorno_dias . " day", strtotime(date('Y-m-d'))));
        $this->db->select('a.agenda_exames_id, a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.cancelada", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.realizada", 't');
        $this->db->where('a.data <=', date('Y-m-d'));
        $this->db->where('a.data >=', $data);
        $this->db->where("a.empresa_id", $empresa_id);
        $this->db->where("a.paciente_id", $paciente_id);
        $this->db->where("pc.procedimento_tuss_id", $return[0]->associacao_procedimento_tuss_id);
        $this->db->orderby("a.data desc");
        $retorno = $this->db->get();

        if (count($retorno->result()) > 0) {
            $resultado = $retorno->result();
            $data_atendimento = $resultado[0]->data;
        } else {
            $data_atendimento = date('Y-m-d');
        }


        $this->db->select('a.agenda_exames_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.cancelada", 'false');
        $this->db->where('a.ativo', 'false');
//        $this->db->where('a.retorno', 'true');
        $this->db->where("a.realizada", 't');
        $this->db->where('a.data <=', date('Y-m-d'));
        $this->db->where('a.data >=', $data_atendimento);
        $this->db->where("a.empresa_id", $empresa_id);
        $this->db->where("a.paciente_id", $paciente_id);
        $this->db->where("pc.procedimento_tuss_id", $return[0]->procedimento_tuss_id);

        $retorno_realizado = $this->db->get();


//        echo "<pre>";
//        var_dump($retorno->result()); die;

        return array(
            "grupo" => $return[0]->grupo,
            "qtdeConsultas" => count($retorno->result()),
            "retorno_realizado" => count($retorno_realizado->result()),
            "diasRetorno" => $return[0]->retorno_dias);
    }

    function validaretornoprocedimentoinverso($paciente_id, $procedimento_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('pt.retorno_dias, pt.procedimento_tuss_id, pt.associacao_procedimento_tuss_id, pt.grupo, pc.convenio_id, pt.nome as procedimento_nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.associacao_procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_id);
        $this->db->where("pt.ativo", 't');
        $return = $this->db->get();
        $return = $return->result();
//        var_dump($return[0]->associacao_procedimento_tuss_id); die;

        $data = date('Y-m-d', strtotime("-" . $return[0]->retorno_dias . " day", strtotime(date('Y-m-d'))));
        $this->db->select('a.agenda_exames_id, a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.cancelada", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.realizada", 't');
        $this->db->where('a.data <=', date('Y-m-d'));
        $this->db->where('a.data >=', $data);
        $this->db->where("a.empresa_id", $empresa_id);
        $this->db->where("a.paciente_id", $paciente_id);
        $this->db->where("pc.procedimento_tuss_id", $return[0]->associacao_procedimento_tuss_id);
        $this->db->orderby("a.data desc");

        $retorno = $this->db->get();
        if (count($retorno->result()) > 0) {
            $resultado = $retorno->result();
            $data_atendimento = $resultado[0]->data;
        } else {
            $data_atendimento = date('Y-m-d');
        }
//        var_dump($retorno->result()); die;

        $this->db->select('a.agenda_exames_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.cancelada", 'false');
        $this->db->where('a.ativo', 'false');
//        $this->db->where('a.retorno', 'true');
        $this->db->where("a.realizada", 't');
        $this->db->where('a.data <=', date('Y-m-d'));
        $this->db->where('a.data >=', $data_atendimento);
        $this->db->where("a.empresa_id", $empresa_id);
        $this->db->where("a.paciente_id", $paciente_id);
        $this->db->where("pc.procedimento_tuss_id", $return[0]->procedimento_tuss_id);
        $retorno_realizado = $this->db->get()->result();



        $this->db->select('pc.procedimento_convenio_id, pc.convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where("pc.convenio_id", $return[0]->convenio_id);
        $this->db->where("pc.procedimento_tuss_id", $return[0]->procedimento_tuss_id);
        $procedimento_retorno = $this->db->get()->result();
//        echo "<pre>";
//        var_dump($retorno_realizado); die;           


        return array(
            "procedimento_retorno" => $procedimento_retorno[0]->procedimento_convenio_id,
            "grupo" => $return[0]->grupo,
            "procedimento_nome" => $return[0]->procedimento_nome,
            "qtdeConsultas" => count($retorno->result()),
            "retorno_realizado" => count($retorno_realizado),
            "diasRetorno" => $return[0]->retorno_dias);
    }

    function buscaconsultasanteriores($paciente_id, $procedimento_id) {
        $data = date('Y-m-d', strtotime("-30 day", strtotime(date('Y-m-d'))));
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            a.tipo,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes,
                            a.procedimento_tuss_id,
                            pc.convenio_id as convenio_agenda,
                            p.convenio_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.cancelada", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.realizada", 't');
        $this->db->where('a.data <=', date('Y-m-d'));
        $this->db->where('a.data >=', $data);
        $this->db->where("a.empresa_id", $empresa_id);
        $this->db->where("a.paciente_id", $paciente_id);
        $this->db->where("a.procedimento_tuss_id", $procedimento_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioscalendariovago($medico = null, $especialidade = null, $empresa_id = null, $sala_id = null, $grupo = null, $tipoagenda = null) {
        $data = date('Y-m-d');
        $data_passado = date('Y-m-d', strtotime("-1 year", strtotime($data)));
        $data_futuro = date('Y-m-d', strtotime("+1 year", strtotime($data)));
        $empresa_atual = $this->session->userdata('empresa_id');
        if ($medico != '') {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao, ae.medico_agenda as medico');
        } else {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao');
        }
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        if ($grupo != '') {
            $this->db->join('tb_exame_sala_grupo esg', 'esg.exame_sala_id = es.exame_sala_id', 'left');
            $this->db->where("esg.ativo", 'true');
        }
        $this->db->where("(ae.situacao = 'LIVRE' OR ae.situacao = 'OK')");
//        $this->db->where("ae.tipo IN ('CONSULTA', 'ESPECIALIDADE', 'FISIOTERAPIA', 'EXAME') OR ae.tipo is null");
        $this->db->where("ae.data is not null");
//        if ($grupo != '') {
//        }
        $this->db->where("ae.data >", $data_passado);
        $this->db->where("ae.data <", $data_futuro);
        $this->db->where('ae.bloqueado', 'f');
        if (isset($empresa_id)) {
            $this->db->where("ae.empresa_id", $empresa_id);
        } else {
            $this->db->where("ae.empresa_id", $empresa_atual);
        }
        if ($sala_id != '') {
            $this->db->where("ae.agenda_exames_nome_id", $sala_id);
        }
        if ($grupo != '') {
            $this->db->where("esg.grupo", $grupo);
        }
        if ($tipoagenda != '') {
            $this->db->where('ae.tipo_consulta_id', $tipoagenda);
        }
        if ($medico != '') {
            $this->db->where("ae.medico_agenda", $medico);
            $this->db->groupby("ae.data, situacao, ae.medico_agenda");
        } else {
            $this->db->groupby("ae.data, situacao");
        }
        $this->db->orderby("ae.data, situacao");

        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioscalendarioexame($medico = null, $especialidade = null, $empresa_id = null, $sala_id = null, $grupo = null) {
        $data = date('Y-m-d');
        $data_passado = date('d-m-Y', strtotime("-1 year", strtotime($data)));
        $data_futuro = date('d-m-Y', strtotime("+1 year", strtotime($data)));
        $empresa_atual = $this->session->userdata('empresa_id');
        if ($medico != '') {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao, ae.medico_agenda as medico');
        } elseif ($especialidade != '') {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao,o.cbo_ocupacao_id as especialidade');
        } else {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao');
        }
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exame_sala_grupo esg', 'esg.exame_sala_id = es.exame_sala_id', 'left');
        $this->db->where("(ae.situacao = 'LIVRE' OR ae.situacao = 'OK')");
        $this->db->where("ae.tipo IN ('EXAME')");
        $this->db->where("ae.data is not null");
        $this->db->where("ae.data >", $data_passado);
        if (isset($empresa_id)) {
            $this->db->where("ae.empresa_id", $empresa_id);
        } else {

            $this->db->where("ae.empresa_id", $empresa_atual);
        }
        $this->db->where("ae.data <", $data_futuro);
        if ($sala_id != '') {
            $this->db->where("ae.agenda_exames_nome_id", $sala_id);
        }
        if ($grupo != '') {
            $this->db->where("esg.grupo", $grupo);
        }
        if ($medico != '') {
            $this->db->where("ae.medico_agenda", $medico);
            $this->db->groupby("ae.data, situacao, ae.medico_agenda");
        } elseif ($especialidade != '') {
            $this->db->where('o.cbo_ocupacao_id', $especialidade);
            $this->db->groupby("ae.data, situacao, o.cbo_ocupacao_id");
        } else {
            $this->db->groupby("ae.data, situacao");
        }

        $this->db->orderby("ae.data");

        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioscalendarioconsulta($medico = null, $tipoagenda = null, $empresa_id = null) {
        $data = date('Y-m-d');
        $data_passado = date('d-m-Y', strtotime("-1 year", strtotime($data)));
        $data_futuro = date('d-m-Y', strtotime("+1 year", strtotime($data)));
        $empresa_atual = $this->session->userdata('empresa_id');
        if ($medico != '') {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao, ae.medico_agenda as medico');
        } elseif ($tipoagenda != '') {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao,ae.tipo_consulta_id');
        } else {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao');
        }
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->where("(ae.situacao = 'LIVRE' OR ae.situacao = 'OK')");
        $this->db->where("ae.tipo IN ('CONSULTA')");
        $this->db->where("ae.bloqueado", 'f');
//        $this->db->where("ae.data is not null");
        $this->db->where("ae.data >", $data_passado);
        $this->db->where("ae.data <", $data_futuro);
        if (isset($empresa_id)) {
            $this->db->where("ae.empresa_id", $empresa_id);
        } else {

            $this->db->where("ae.empresa_id", $empresa_atual);
        }
        if ($medico != '') {
            $this->db->where("ae.medico_agenda", $medico);
            $this->db->groupby("ae.data, situacao, ae.medico_agenda");
        }
        if ($tipoagenda != '') {
            $this->db->where('ae.tipo_consulta_id', $tipoagenda);
        } else {
            $this->db->groupby("ae.data, situacao");
        }

        $this->db->orderby("ae.data, situacao");

        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioscalendarioespecialidade($medico = null, $tipoagenda = null, $empresa_id = null) {
        $data = date('Y-m-d');
        $data_passado = date('d-m-Y', strtotime("-1 year", strtotime($data)));
        $data_futuro = date('d-m-Y', strtotime("+1 year", strtotime($data)));
        $empresa_atual = $this->session->userdata('empresa_id');
        if ($medico != '') {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao, ae.medico_agenda as medico');
        } else {
            $this->db->select('ae.data, count(ae.data) as contagem, situacao');
        }
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->where("(ae.situacao = 'LIVRE' OR ae.situacao = 'OK')");
        $this->db->where("ae.tipo IN ('ESPECIALIDADE', 'FISIOTERAPIA')");
        $this->db->where("ae.data is not null");
        $this->db->where("ae.data >", $data_passado);
        $this->db->where("ae.data <", $data_futuro);
        if (isset($empresa_id)) {
            $this->db->where("ae.empresa_id", $empresa_id);
        } else {

            $this->db->where("ae.empresa_id", $empresa_atual);
        }

        if ($medico != '') {
            $this->db->where("ae.medico_agenda", $medico);
            $this->db->groupby("ae.data, situacao, ae.medico_agenda");
        }
        if ($tipoagenda != '') {
            $this->db->where('ae.tipo_consulta_id', $tipoagenda);
//            $this->db->groupby("ae.data, situacao, ae.tipo_consulta_id");
        } else {
            $this->db->groupby("ae.data, situacao");
        }

        $this->db->orderby("ae.data, situacao");

        $return = $this->db->get();
        return $return->result();
    }

    function listarmedicosmultiempresa() {
        $this->db->select('o.operador_id,
                               o.usuario,
                               o.nome,
                               o.conselho,
                               o.conselho,
                               o.perfil_id,
                               p.nome as perfil');
        $this->db->from('tb_operador o');
        $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
        $this->db->where('consulta', 'true');
        $this->db->where('o.ativo', 'true');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarespecialidademultiempresa() {
        $this->db->select('distinct(co.cbo_ocupacao_id),
                               co.descricao');
        $this->db->from('tb_operador o');
        $this->db->join('tb_cbo_ocupacao co', 'co.cbo_ocupacao_id = o.cbo_ocupacao_id');
        $this->db->where('consulta', 'true');
        $this->db->where('o.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosmultiempresa() {
        $data = date('Y-m-d');
        $data_passado = date('d-m-Y', strtotime("-1 year", strtotime($data)));
        $data_futuro = date('d-m-Y', strtotime("+1 year", strtotime($data)));
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.ocupado,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            ae.tipo,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            e.situacao as situacaoexame,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            ae.medico_agenda,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador,
                            bloc.nome as operador_bloqueio,
                            desbloc.nome as operador_desbloqueio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->join('tb_operador bloc', 'bloc.operador_id = ae.operador_bloqueio', 'left');
        $this->db->join('tb_operador desbloc', 'desbloc.operador_id = ae.operador_desbloqueio', 'left');
//        $this->db->where("(ae.situacao = 'LIVRE')");
        $this->db->where("ae.tipo IN ('CONSULTA', 'ESPECIALIDADE', 'FISIOTERAPIA', 'EXAME')");
        $this->db->where("ae.data is not null");
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['nascimento']) && strlen($_POST['nascimento']) > 0) {
            $this->db->where('p.nascimento', $_POST['nascimento']);
        }
        if (isset($_POST['medico']) && strlen($_POST['medico']) > 0) {
            $this->db->where('o.conselho', $_POST['medico']);
        }
        if (isset($_POST['especialidade']) && strlen($_POST['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $_POST['especialidade']);
        }

        if (isset($_POST['data']) && strlen($_POST['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
        } else {
            $this->db->where('ae.data', date("Y-m-d"));
        }

        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");
//        $this->db->limit(100);

        $return = $this->db->get();
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
                            c.nome as convenio,
                            c.convenio_id as convenio_id_proc,
                            c.fidelidade_parceiro_id,
                            c.fidelidade_endereco_ip,
                            a.procedimento_tuss_id,
                            p.paciente_id,
                            p.cpf,
                            ag.tipo,
                            pc.convenio_id as convenio_agenda,
                            a.observacoes,
                            p.convenio_id');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = a.paciente_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("ag.tipo", 'CONSULTA');
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
                            a.observacoes,
                            a.procedimento_tuss_id,
                            pt.grupo,
                            pc.convenio_id as convenio_agenda');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("(ag.tipo = 'FISIOTERAPIA' OR ag.tipo = 'ESPECIALIDADE')");
        $this->db->where("a.guia_id", null);
        $this->db->where("(a.numero_sessao = 1 OR a.numero_sessao is null)");
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
                            a.valor,
                            a.quantidade,
                            a.medico_consulta_id,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            pt.nome as procedimento,
                            pt.grupo,
                            a.procedimento_tuss_id,
                            pc.convenio_id as convenio_agenda,
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
        $this->db->where("(a.numero_sessao = 1 OR a.numero_sessao is null)");
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");

        $return = $this->db->get();
//        echo "<pRE>";
//        var_dump($return->result());die;
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
                            a.observacoes,
                            pc.convenio_id');
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
                            a.confirmado,
                            a.realizada,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            pc.convenio_id,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
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
                            a.observacoes,
                            emp.nome as empresa');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = a.empresa_id', 'left');
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
        $this->db->where("(a.tipo = 'FISIOTERAPIA' OR a.tipo = 'ESPECIALIDADE')");
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpacientefisioterapiareangedar($agenda_exames_id) {
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
        $this->db->where("(a.tipo = 'FISIOTERAPIA' OR a.tipo = 'ESPECIALIDADE')");
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.agenda_exames_id", $agenda_exames_id);
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

    function listarfisioterapiaanterior($pacientetemp_id) {
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
        $this->db->where("(a.tipo = 'FISIOTERAPIA' OR a.tipo = 'ESPECIALIDADE')");
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

    function listarconveniomultiempresa() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("ce.ativo", 'true');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

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
                            a.observacoes,
                            emp.nome as empresa');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = a.empresa_id', 'left');
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

    function listarconsultaspacientemultiempresa($agenda_exames_id) {
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

    function listarpacoteexamespaciente($ambulatorio_guia_id) {

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
                            ae.procedimento_possui_ajuste_pagamento,
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
                            pt.grupo,
                            pt.descricao_procedimento,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            fp.forma_pagamento_id,
                            pt2.nome as pacote_nome,
                            apt.valor_diferenciado,
                            ae.agrupador_pacote_id,
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
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pp.forma_pagamento_id', 'left');
        $this->db->join('tb_agrupador_pacote_temp apt', 'apt.agrupador_pacote_temp_id = ae.agrupador_pacote_id', 'left');
        $this->db->join('tb_procedimento_convenio pc2', 'pc2.procedimento_convenio_id = apt.procedimento_agrupador_id', 'left');
        $this->db->join('tb_procedimento_tuss pt2', 'pt2.procedimento_tuss_id = pc2.procedimento_tuss_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $this->db->where("ae.agrupador_pacote_id IS NOT NULL");
        $this->db->orderby("pt2.nome");
        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");
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
                            ae.indicacao,
                            ae.faturado,
                            ae.medico_agenda as medico_agenda_id,
                            ae.medico_solicitante as medico_solicitante_id,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            ae.procedimento_possui_ajuste_pagamento,
                            pc.convenio_id,
                            op.nome as medico_agenda,
                            o.nome as medico_solicitante,
                            es.nome as sala,
                            p.nome as paciente,
                            c.dinheiro,
                            c.nome as convenio,
                            pt.codigo,
                            pt.grupo,
                            pt.descricao_procedimento,
                            pt.nome as procedimento,
                            fp.forma_pagamento_id,
                            apt.valor_diferenciado');
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
        $this->db->join('tb_agrupador_pacote_temp apt', 'apt.agrupador_pacote_temp_id = ae.agrupador_pacote_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $this->db->where("ae.agrupador_pacote_id IS NULL");
        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");
        $return = $this->db->get();
//        echo "<pre>"; var_dump($return->result()); die;
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

    function listarprocedimentocomformapagamento($ambulatorio_guia_id) {
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
                            pt.descricao_procedimento');
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
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.agrupador_pacote_id IS NULL");
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $this->db->where("pc.procedimento_convenio_id IN (
            SELECT pcfp.procedimento_convenio_id FROM ponto.tb_procedimento_convenio_forma_pagamento pcfp
            WHERE pcfp.ativo = 't'AND pc.procedimento_convenio_id = pcfp.procedimento_convenio_id
        )");
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
                            pt.descricao_procedimento,
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

    function gerargraficosexames() {
        $data = date("Y-m-d");

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            pt.nome as procedimento,
                            pt.grupo,
                            pt.codigo,
                            ae.data,
                            al.situacao');
        $this->db->from('tb_agenda_exames ae');
//        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
//        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
//        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
//        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
//        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
//        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.paciente_id is not null');

        if (isset($_GET['empresa']) && strlen($_GET['empresa']) > 0) {
            $this->db->where('ae.empresa_id', $_GET['empresa']);
        } else {
            $this->db->where('ae.empresa_id', $empresa_id);
        }

//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($_GET['nome']) && strlen($_GET['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_GET['nome'] . "%");
        }
        if (isset($_GET['nascimento']) && strlen($_GET['nascimento']) > 0) {
            $this->db->where('p.nascimento', date("Y-m-d", strtotime(str_replace('/', '-', $_GET['nascimento']))));
        }
        if (isset($_GET['especialidade']) && strlen($_GET['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $_GET['especialidade']);
        }
        if (isset($_GET['medico']) && strlen($_GET['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $_GET['medico']);
        }

        if (isset($_GET['data']) && strlen($_GET['data']) > 0) {
            $this->db->where('ae.data ', date("Y-m-d", strtotime(str_replace('/', '-', $_GET['data']))));
//            $this->db->where('ae.data <', date("Y-m-", strtotime("+1 month", str_replace('/', '-', $_GET['data']))) . '01');
        } else {
            $this->db->where('ae.data ', date("Y-m-d"));
        }
//        else{
//            $this->db->where('ae.data >=', date("Y-m-").'01');
//            $this->db->where('ae.data <', date("Y-m-",strtotime("+1 month")).'01');
//        }

        if (isset($_GET['sala']) && strlen($_GET['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $_GET['sala']);
        }

        if (isset($_GET['situacao']) && strlen($_GET['situacao']) > 0) {
            if ($_GET['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($_GET['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($_GET['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($_GET['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        $return = $this->db->get();

        return $return->result();
    }

    function listarexamespacienteatendimentoparticular($ambulatorio_guia_id) {

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
                            ae.procedimento_possui_ajuste_pagamento,
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
                            pt.descricao_procedimento,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            apt.valor_diferenciado');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_agrupador_pacote_temp apt', 'apt.agrupador_pacote_temp_id = ae.agrupador_pacote_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('c.dinheiro', 't');
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $this->db->orderby("c.nome");
        $this->db->orderby("ae.forma_pagamento DESC");
        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");

        $return = $this->db->get();

        return $return->result();
    }

    function listarexamespacienteatendimento($ambulatorio_guia_id) {

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
                            pt.descricao_procedimento,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            ae.procedimento_possui_ajuste_pagamento,
                            pt.nome as procedimento,
                            apt.valor_diferenciado');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_agrupador_pacote_temp apt', 'apt.agrupador_pacote_temp_id = ae.agrupador_pacote_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('c.dinheiro', 'f');
        $this->db->where("guia_id", $ambulatorio_guia_id);
//        $this->db->where("ae.procedimento_tuss_id", $procedimento_convenio_id);
        $this->db->orderby("c.nome");
        $this->db->orderby("ae.forma_pagamento DESC");
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
                            pt.descricao_procedimento,
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

        $this->db->select('procedimento_convenio_forma_pagamento_id');
        $this->db->from('tb_procedimento_convenio_forma_pagamento');
        $this->db->where("procedimento_convenio_id", $procedimento_convenio_id);
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        $retorno = $return->result();

        return $retorno;
    }

    function listaresponsavelorcamento($paciente_id) {
        $horario = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('o.nome');
        $this->db->from('tb_ambulatorio_orcamento ao');
        $this->db->join('tb_operador o', 'o.operador_id = ao.operador_cadastro', 'left');

        $this->db->where('ao.empresa_id', $empresa_id);
        $this->db->where("ao.paciente_id", $paciente_id);
        $this->db->where("ao.data_criacao", $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosorcamentocredito($orcamento_id) {
        $horario = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select(' oi.orcamento_id,
                            oi.paciente_id,
                            SUM(oi.valor_total) AS valortotal');
        $this->db->from('tb_ambulatorio_orcamento_item oi');
        $this->db->join('tb_paciente p', 'p.paciente_id = oi.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = oi.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = oi.forma_pagamento', 'left');
        $this->db->where('oi.orcamento_id', $orcamento_id);
        $this->db->where("oi.ativo", "t");
        $this->db->groupby("oi.orcamento_id, oi.paciente_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarorcamentos($paciente_id) {
        $horario = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select(' oi.ambulatorio_orcamento_item_id,
                            oi.data,
                            oi.orcamento_id,
                            oi.valor_total,
                            oi.orcamento_id,
                            oi.paciente_id,
                            oi.data_preferencia,
                            oi.dia_semana_preferencia,
                            oi.turno_prefencia,
                            ao.autorizado,
                            (oi.valor_ajustado * oi.quantidade) as valor_total_ajustado,
                            pc.convenio_id,
                            p.nome as paciente,
                            c.nome as convenio,
                            pt.descricao_procedimento,
                            pt.codigo,
                            pt.grupo,
                            pt.nome as procedimento,
                            fp.nome as forma_pagamento');
        $this->db->from('tb_ambulatorio_orcamento_item oi');
        $this->db->join('tb_ambulatorio_orcamento ao', 'ao.ambulatorio_orcamento_id = oi.orcamento_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = oi.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = oi.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = oi.forma_pagamento', 'left');
        $this->db->where('oi.empresa_id', $empresa_id);
        $this->db->where("oi.paciente_id", $paciente_id);
        $this->db->where("oi.data", $horario);
        $this->db->where("oi.ativo", "t");
        $this->db->orderby("oi.data_cadastro");

        $return = $this->db->get();
        return $return->result();
    }

    function excluirorcamento($ambulatorio_orcamento_item_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_orcamento_item_id', $ambulatorio_orcamento_item_id);
        $this->db->update('tb_ambulatorio_orcamento_item');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function listaagendafisioterapia($agendaexame_id) {
        $empresa_id = $this->session->userdata('empresa_id');
        $data_atual = data("Y-m-d");
        $this->db->select("ae.*, h.dia");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_horarioagenda h', 'h.horarioagenda_id = ae.horarioagenda_id', 'left');
        $this->db->where("ae.agenda_exames_id", $agendaexame_id);
//        $this->db->where("ae.data >=", $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaagendafisioterapiapersonalizada($agendaexame_id, $semana) {
        $empresa_id = $this->session->userdata('empresa_id');
//        $data = data("Y-m-d");
        $this->db->select("ae.*, h.dia");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_horarioagenda h', 'h.horarioagenda_id = ae.horarioagenda_id', 'left');
        $this->db->where("ae.agenda_exames_id", $agendaexame_id);
//        $this->db->where("ae.data >=", $data);
        $this->db->where('ae.empresa_id', $empresa_id);

        $return = $this->db->get()->result();
//        var_dump($return);
//        die;
        $diaSemana = date("Y-m-d", strtotime("+$semana week", strtotime($return[0]->data)));
//        echo '<pre>';
//        var_dump($diaSemana);

        $nulo = null;
        $this->db->select('ae.*');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where("ae.paciente_id", $nulo);
        $this->db->where('ae.situacao', "LIVRE");
//        $this->db->where('ativo', 't');
//        $this->db->where('cancelada', 'f');
        $this->db->where('confirmado', 'f');
        $this->db->where("(ae.tipo = 'FISIOTERAPIA' OR ae.tipo = 'ESPECIALIDADE')");
//        $this->db->where("ae.data >=", $data_atual);
        $this->db->where("ae.data ", $diaSemana);
        $this->db->where("ae.inicio", $return[0]->inicio);
//        $this->db->where("ae.fim", $return[0]->fim);
        $this->db->where("ae.medico_agenda", $return[0]->medico_agenda);
        $return2 = $this->db->get()->result();
//        var_dump($return2); die;
        if (count($return2) > 0) {
            return $return2;
        } else {
            return false;
        }
    }

    function listaagendafisioterapiapersonalizadaerro($agendaexame_id, $semana) {
        $empresa_id = $this->session->userdata('empresa_id');
//        $data = data("Y-m-d");
        $this->db->select("ae.*, h.dia");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_horarioagenda h', 'h.horarioagenda_id = ae.horarioagenda_id', 'left');
        $this->db->where("ae.agenda_exames_id", $agendaexame_id);
//        $this->db->where("ae.data >=", $data);
        $this->db->where('ae.empresa_id', $empresa_id);

        $return = $this->db->get()->result();
//        var_dump($return);
//        die;
        $diaSemana = date("Y-m-d", strtotime("+$semana week", strtotime($return[0]->data)));
//        echo '<pre>';
//        var_dump($diaSemana);

        $nulo = null;
        $this->db->select('ae.*');
        $this->db->from('tb_agenda_exames ae');

        $this->db->where("ae.data ", $diaSemana);
        $this->db->where("ae.inicio", $return[0]->inicio);
//        $this->db->where("ae.fim", $return[0]->fim);
        $this->db->where("ae.medico_agenda", $return[0]->medico_agenda);
        $return = $this->db->get()->result();
        return $return;
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

    function listadisponibilidadefisioterapiadia($agenda, $dias_escolhidos) {
        $empresa_id = $this->session->userdata('empresa_id');
        $data_atual = date("Y-m-d");
        $sessao_numero = $_POST['sessao'];
        $nulo = null;

//                var_dump($convenios); die;

        $string = array();
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
        $this->db->where("ae.data >=", $data_atual);
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
        $this->db->where("ae.agrupador_pacote_id IS NULL");
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
        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
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

            $this->db->set('data_criacao', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_realizacao']))));
            $this->db->where('ambulatorio_guia_id', $_POST['txtguiaid']);
            $this->db->update('tb_ambulatorio_guia');
        }
    }

    function gravarcredito() {
        try {
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->select('ep.associa_credito_procedimento');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $empresa_id);
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $return = $this->db->get()->result();

            if (isset($_POST['valorAjuste']) && $_POST['valorAjuste'] != 0) {
                $valorAjuste = (float) $_POST['valorAjuste'];
                $this->db->set('valor_forma_pagamento_ajuste', $valorAjuste);
                $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
            }

            if ($return[0]->associa_credito_procedimento == 't') {
                $this->db->set('ativo', 'f'); //So irá setar para true quando for faturado
                if (isset($valorAjuste)) {
                    $this->db->set('valor', $valorAjuste);
                } else {
                    $this->db->set('valor', $_POST['valor1']);
                }
                $this->db->set('procedimento_convenio_id', $_POST['procedimento1']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', date("Y-m-d"));

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $empresa_id = $this->session->userdata('empresa_id');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->insert('tb_paciente_credito');

                $paciente_credito_id = $this->db->insert_id();
            } else {
                $this->db->set('ativo', 'f'); //So irá setar para true quando for faturado

                if (isset($valorAjuste)) {
                    $this->db->set('valor', $valorAjuste);
                } else {
                    $this->db->set('valor', (float) str_replace(',', '.', str_replace('.', '', $_POST['valor1'])));
                }
                $this->db->set('data', date("Y-m-d"));
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $empresa_id = $this->session->userdata('empresa_id');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->insert('tb_paciente_credito');
                $paciente_credito_id = $this->db->insert_id();
            }


            return $paciente_credito_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function registrainformacaoestornocredito($credito_id) {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select("paciente_id,
                           procedimento_convenio_id,
                           valor,
                           data,
                           empresa_id,
                           forma_pagamento1,
                           valor1,
                           forma_pagamento2,
                           valor2,
                           forma_pagamento3,
                           valor3,
                           forma_pagamento4,
                           valor4,
                           parcelas1,
                           parcelas2,
                           parcelas3,
                           parcelas4,
                           faturado,
                           financeiro_fechado,
                           operador_financeiro,
                           data_financeiro");
        $this->db->from('tb_paciente_credito');
        $this->db->where('paciente_credito_id', $credito_id);
        $result = $this->db->get()->result();

        if ($result[0]->forma_pagamento1 != '') {
            $this->db->set('forma_pagamento1', $result[0]->forma_pagamento1);
        }
        if ($result[0]->forma_pagamento2 != '') {
            $this->db->set('forma_pagamento2', $result[0]->forma_pagamento2);
        }
        if ($result[0]->forma_pagamento3 != '') {
            $this->db->set('forma_pagamento3', $result[0]->forma_pagamento3);
        }
        if ($result[0]->forma_pagamento4 != '') {
            $this->db->set('forma_pagamento4', $result[0]->forma_pagamento4);
        }
        if ($result[0]->valor1 != '') {
            $this->db->set('valor1', $result[0]->valor1);
        }
        if ($result[0]->valor2 != '') {
            $this->db->set('valor2', $result[0]->valor2);
        }
        if ($result[0]->valor3 != '') {
            $this->db->set('valor3', $result[0]->valor3);
        }
        if ($result[0]->valor4 != '') {
            $this->db->set('valor4', $result[0]->valor4);
        }
        if ($result[0]->parcelas1 != '') {
            $this->db->set('parcelas1', $result[0]->parcelas1);
        }
        if ($result[0]->parcelas2 != '') {
            $this->db->set('parcelas2', $result[0]->parcelas2);
        }
        if ($result[0]->parcelas3 != '') {
            $this->db->set('parcelas3', $result[0]->parcelas3);
        }
        if ($result[0]->parcelas4 != '') {
            $this->db->set('parcelas4', $result[0]->parcelas4);
        }
        if ($result[0]->operador_financeiro != '') {
            $this->db->set('operador_financeiro', $result[0]->operador_financeiro);
        }
        if ($result[0]->data_financeiro != '') {
            $this->db->set('data_financeiro', $result[0]->data_financeiro);
        }
        if (isset($_GET['justificativa'])) {
            $this->db->set('justificativa', @$_GET['justificativa']);
        }
        $this->db->set('financeiro_fechado', $result[0]->financeiro_fechado);
        $this->db->set('data', $result[0]->data);
        $this->db->set('valor', $result[0]->valor);
        $this->db->set('paciente_credito_id', $credito_id);
        $this->db->set('empresa_id', $result[0]->empresa_id);
        $this->db->set('paciente_id', $result[0]->paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_paciente_estorno_registro');
    }

    function excluircredito($credito_id) {
        try {
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->select('valor, paciente_id');
            $this->db->from('tb_paciente_credito');
            $this->db->where('paciente_credito_id', $credito_id);
            $valorCredito = $this->db->get()->result();

            $this->db->select('SUM(pcr.valor) as saldo');
            $this->db->from('tb_paciente_credito pcr');
            $this->db->where('pcr.empresa_id', $empresa_id);
            $this->db->where('pcr.paciente_id', $valorCredito[0]->paciente_id);
            $this->db->where('pcr.ativo', 'true');
            $return = $this->db->get()->result();

            if ($valorCredito[0]->valor <= $return[0]->saldo) {
                $this->db->set('ativo', 'f');
                $this->db->where('paciente_credito_id', $credito_id);
                $this->db->update('tb_paciente_credito');
            } else {
                return -2;
            }

            return $credito_id;
        } catch (Exception $exc) {
            return -1;
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
                $this->db->set('tipo', 'ESPECIALIDADE');
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
                $this->db->set('medico_agenda', $_POST['medico']);
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


//            $agrupador = 0;
            //criar agrfupador temp
            $this->db->set('qtde_sessoes', $_POST['qtde']);
            $this->db->insert('tb_agrupador_fisioterapia_temp');
            $agrupador = $this->db->insert_id();
            if ($_POST['horarios'] != "") {

                $data = str_replace("/", "-", $_POST['data_ficha']);
                $data_ficha = date("Y-m-d", strtotime($data));

                for ($i = 1; $i <= $_POST['qtde']; $i++) {
                    if ($i > 1) {

                        //
                    }
                    $empresa_id = $this->session->userdata('empresa_id');

                    if ($agrupador != 0) {
                        $this->db->set('agrupador_fisioterapia', $agrupador);
                    }

                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('tipo', 'ESPECIALIDADE');
                    $this->db->set('medico_agenda', $_POST['medico']);
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
                    $this->db->set('numero_sessao', $i);
                    $this->db->set('qtde_sessao', $_POST['qtde']);
                    $this->db->set('data_fim', $data_ficha);
                    $this->db->set('data', $data_ficha);
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_agenda_exames');

                    $data_ficha = date("Y-m-d", strtotime("+1 week", strtotime($data_ficha)));
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
                $this->db->set('tipo', 'ESPECIALIDADE');
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

    function gravarfisioterapiapacientetempreagendar($ambulatorio_pacientetemp_id) {
        try {
            $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.encaixe,
                            a.guia_id,
                            a.procedimento_tuss_id,
                            a.data,
                            a.situacao,
                            a.ativo,
                            a.tipo,
                            a.cancelada,
                            a.observacoes,
                            a.realizada,
                            a.confirmado,
                            a.convenio_id,
                            a.agrupador_fisioterapia,
                            a.numero_sessao,
                            a.qtde_sessao,
                            valor1, 
                            valor, 
                            ordenador, 
                            forma_pagamento,
                            forma_pagamento2, 
                            valor2, 
                            forma_pagamento3, 
                            valor3, 
                            forma_pagamento4, 
                            valor4,
                            quantidade,
                            data_autorizacao,
                            operador_autorizacao,
                            valor_total,
                            a.agenda_exames_nome_id,
                            a.medico_agenda,
                            a.medico_consulta_id,
                            a.observacoes');
            $this->db->from('tb_agenda_exames a');
//            $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
//            $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
            $this->db->where("a.agenda_exames_id", $_POST['agenda_exames_id']);

            $return = $this->db->get()->result();
//            $return;
//            echo '<pre>';
//            var_dump($return);
//            die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            if ($_POST['horarios'] != "") {
//                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', $return[0]->tipo);
                $this->db->set('ativo', $return[0]->ativo);
                $this->db->set('cancelada', $return[0]->cancelada);
                $this->db->set('confirmado', $return[0]->confirmado);
                $this->db->set('realizada', $return[0]->realizada);
                $this->db->set('situacao', $return[0]->situacao);
                $this->db->set('observacoes', $return[0]->observacoes);
                if ($return[0]->ordenador != '') {
                    $this->db->set('ordenador', $return[0]->ordenador);
                }
                if ($return[0]->operador_autorizacao != '') {
                    $this->db->set('operador_autorizacao', $return[0]->operador_autorizacao);
                }
                if ($return[0]->data_autorizacao != '') {
                    $this->db->set('data_autorizacao', $return[0]->data_autorizacao);
                }
                if ($return[0]->quantidade != '') {
                    $this->db->set('quantidade', $return[0]->quantidade);
                }
                if ($return[0]->valor != '') {
                    $this->db->set('valor', $return[0]->valor);
                }
                if ($return[0]->valor_total != '') {
                    $this->db->set('valor_total', $return[0]->valor_total);
                }
                if ($return[0]->forma_pagamento4 != '') {
                    $this->db->set('forma_pagamento4', $return[0]->forma_pagamento4);
                }
                if ($return[0]->forma_pagamento3 != '') {
                    $this->db->set('forma_pagamento3', $return[0]->forma_pagamento3);
                }
                if ($return[0]->forma_pagamento2 != '') {
                    $this->db->set('forma_pagamento2', $return[0]->forma_pagamento2);
                }
                if ($return[0]->forma_pagamento != '') {
                    $this->db->set('forma_pagamento', $return[0]->forma_pagamento);
                }
                if ($return[0]->valor4 != '') {
                    $this->db->set('valor4', $return[0]->valor4);
                }
                if ($return[0]->valor3 != '') {
                    $this->db->set('valor3', $return[0]->valor3);
                }
                if ($return[0]->valor2 != '') {
                    $this->db->set('valor2', $return[0]->valor2);
                }
                if ($return[0]->valor1 != '') {
                    $this->db->set('valor1', $return[0]->valor1);
                }
                if ($return[0]->agrupador_fisioterapia != '') {
                    $this->db->set('agrupador_fisioterapia', $return[0]->agrupador_fisioterapia);
                }
                if ($return[0]->convenio_id != '') {
                    $this->db->set('convenio_id', $return[0]->convenio_id);
                }
                if ($return[0]->numero_sessao != '') {
                    $this->db->set('numero_sessao', $return[0]->numero_sessao);
                }
                if ($return[0]->qtde_sessao != '') {
                    $this->db->set('qtde_sessao', $return[0]->qtde_sessao);
                }
                if ($return[0]->guia_id != '') {
                    $this->db->set('guia_id', $return[0]->guia_id);
                }
                if ($return[0]->procedimento_tuss_id != '') {
                    $this->db->set('procedimento_tuss_id', $return[0]->procedimento_tuss_id);
                }
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');



                $this->db->set('paciente_id', null);
                $this->db->set('procedimento_tuss_id', null);
                $this->db->set('convenio_id', null);
                $this->db->set('guia_id', null);
                $this->db->set('agrupador_fisioterapia', null);
                $this->db->set('numero_sessao', null);
                $this->db->set('qtde_sessao', null);
                $this->db->set('realizada', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
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
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_agenda_exames');


                $this->db->set('agenda_exames_id', $_POST['horarios']);
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultapacientetempreagendar($ambulatorio_pacientetemp_id) {
        try {
            $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.encaixe,
                            a.guia_id,
                            a.procedimento_tuss_id,
                            a.data,
                            a.situacao,
                            a.ativo,
                            a.tipo,
                            a.cancelada,
                            a.observacoes,
                            a.realizada,
                            a.confirmado,
                            a.convenio_id,
                            a.agrupador_fisioterapia,
                            a.numero_sessao,
                            a.qtde_sessao,
                            valor1, 
                            valor, 
                            ordenador, 
                            forma_pagamento,
                            forma_pagamento2, 
                            valor2, 
                            forma_pagamento3, 
                            valor3, 
                            forma_pagamento4, 
                            valor4,
                            quantidade,
                            data_autorizacao,
                            operador_autorizacao,
                            valor_total,
                            a.agenda_exames_nome_id,
                            a.medico_agenda,
                            a.medico_consulta_id,
                            a.observacoes');
            $this->db->from('tb_agenda_exames a');
//            $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
//            $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
            $this->db->where("a.agenda_exames_id", $_POST['agenda_exames_id']);

            $return = $this->db->get()->result();
//            $return;
//            echo '<pre>';
//            var_dump($return);
//            die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            if ($_POST['horarios'] != "") {
//                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', $return[0]->tipo);
                $this->db->set('ativo', $return[0]->ativo);
                $this->db->set('cancelada', $return[0]->cancelada);
                $this->db->set('confirmado', $return[0]->confirmado);
                $this->db->set('realizada', $return[0]->realizada);
                $this->db->set('situacao', $return[0]->situacao);
                $this->db->set('observacoes', $return[0]->observacoes);
                if ($return[0]->ordenador != '') {
                    $this->db->set('ordenador', $return[0]->ordenador);
                }
                if ($return[0]->operador_autorizacao != '') {
                    $this->db->set('operador_autorizacao', $return[0]->operador_autorizacao);
                }
                if ($return[0]->data_autorizacao != '') {
                    $this->db->set('data_autorizacao', $return[0]->data_autorizacao);
                }
                if ($return[0]->quantidade != '') {
                    $this->db->set('quantidade', $return[0]->quantidade);
                }
                if ($return[0]->valor != '') {
                    $this->db->set('valor', $return[0]->valor);
                }
                if ($return[0]->valor_total != '') {
                    $this->db->set('valor_total', $return[0]->valor_total);
                }
                if ($return[0]->forma_pagamento4 != '') {
                    $this->db->set('forma_pagamento4', $return[0]->forma_pagamento4);
                }
                if ($return[0]->forma_pagamento3 != '') {
                    $this->db->set('forma_pagamento3', $return[0]->forma_pagamento3);
                }
                if ($return[0]->forma_pagamento2 != '') {
                    $this->db->set('forma_pagamento2', $return[0]->forma_pagamento2);
                }
                if ($return[0]->forma_pagamento != '') {
                    $this->db->set('forma_pagamento', $return[0]->forma_pagamento);
                }
                if ($return[0]->valor4 != '') {
                    $this->db->set('valor4', $return[0]->valor4);
                }
                if ($return[0]->valor3 != '') {
                    $this->db->set('valor3', $return[0]->valor3);
                }
                if ($return[0]->valor2 != '') {
                    $this->db->set('valor2', $return[0]->valor2);
                }
                if ($return[0]->valor1 != '') {
                    $this->db->set('valor1', $return[0]->valor1);
                }
                if ($return[0]->agrupador_fisioterapia != '') {
                    $this->db->set('agrupador_fisioterapia', $return[0]->agrupador_fisioterapia);
                }
                if ($return[0]->convenio_id != '') {
                    $this->db->set('convenio_id', $return[0]->convenio_id);
                }
                if ($return[0]->numero_sessao != '') {
                    $this->db->set('numero_sessao', $return[0]->numero_sessao);
                }
                if ($return[0]->qtde_sessao != '') {
                    $this->db->set('qtde_sessao', $return[0]->qtde_sessao);
                }
                if ($return[0]->guia_id != '') {
                    $this->db->set('guia_id', $return[0]->guia_id);
                }
                if ($return[0]->procedimento_tuss_id != '') {
                    $this->db->set('procedimento_tuss_id', $return[0]->procedimento_tuss_id);
                }
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');



                $this->db->set('paciente_id', null);
                $this->db->set('procedimento_tuss_id', null);
                $this->db->set('convenio_id', null);
                $this->db->set('guia_id', null);
                $this->db->set('agrupador_fisioterapia', null);
                $this->db->set('numero_sessao', null);
                $this->db->set('qtde_sessao', null);
                $this->db->set('realizada', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
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
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_agenda_exames');


                $this->db->set('agenda_exames_id', $_POST['horarios']);
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravargeralpacientetempreagendar($ambulatorio_pacientetemp_id) {
        try {
            $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.encaixe,
                            a.guia_id,
                            a.procedimento_tuss_id,
                            a.data,
                            a.situacao,
                            a.ativo,
                            a.tipo,
                            a.cancelada,
                            a.observacoes,
                            a.realizada,
                            a.confirmado,
                            a.convenio_id,
                            a.agrupador_fisioterapia,
                            a.numero_sessao,
                            a.qtde_sessao,
                            valor1, 
                            valor, 
                            ordenador, 
                            forma_pagamento,
                            forma_pagamento2, 
                            valor2, 
                            forma_pagamento3, 
                            valor3, 
                            forma_pagamento4, 
                            valor4,
                            quantidade,
                            data_autorizacao,
                            operador_autorizacao,
                            valor_total,
                            a.agenda_exames_nome_id,
                            a.medico_agenda,
                            a.medico_consulta_id,
                            a.observacoes');
            $this->db->from('tb_agenda_exames a');
//            $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
//            $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
            $this->db->where("a.agenda_exames_id", $_POST['agenda_exames_id']);

            $return = $this->db->get()->result();
//            $return;
//            echo '<pre>';
//            var_dump($return);
//            die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            if ($_POST['horarios'] != "") {
//                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', $return[0]->tipo);
                $this->db->set('ativo', $return[0]->ativo);
                $this->db->set('cancelada', $return[0]->cancelada);
                $this->db->set('confirmado', $return[0]->confirmado);
                $this->db->set('realizada', $return[0]->realizada);
                $this->db->set('situacao', $return[0]->situacao);
                $this->db->set('observacoes', $return[0]->observacoes);
                if ($return[0]->ordenador != '') {
                    $this->db->set('ordenador', $return[0]->ordenador);
                }
                if ($return[0]->operador_autorizacao != '') {
                    $this->db->set('operador_autorizacao', $return[0]->operador_autorizacao);
                }
                if ($return[0]->data_autorizacao != '') {
                    $this->db->set('data_autorizacao', $return[0]->data_autorizacao);
                }
                if ($return[0]->quantidade != '') {
                    $this->db->set('quantidade', $return[0]->quantidade);
                }
                if ($return[0]->valor != '') {
                    $this->db->set('valor', $return[0]->valor);
                }
                if ($return[0]->valor_total != '') {
                    $this->db->set('valor_total', $return[0]->valor_total);
                }
                if ($return[0]->forma_pagamento4 != '') {
                    $this->db->set('forma_pagamento4', $return[0]->forma_pagamento4);
                }
                if ($return[0]->forma_pagamento3 != '') {
                    $this->db->set('forma_pagamento3', $return[0]->forma_pagamento3);
                }
                if ($return[0]->forma_pagamento2 != '') {
                    $this->db->set('forma_pagamento2', $return[0]->forma_pagamento2);
                }
                if ($return[0]->forma_pagamento != '') {
                    $this->db->set('forma_pagamento', $return[0]->forma_pagamento);
                }
                if ($return[0]->valor4 != '') {
                    $this->db->set('valor4', $return[0]->valor4);
                }
                if ($return[0]->valor3 != '') {
                    $this->db->set('valor3', $return[0]->valor3);
                }
                if ($return[0]->valor2 != '') {
                    $this->db->set('valor2', $return[0]->valor2);
                }
                if ($return[0]->valor1 != '') {
                    $this->db->set('valor1', $return[0]->valor1);
                }
                if ($return[0]->agrupador_fisioterapia != '') {
                    $this->db->set('agrupador_fisioterapia', $return[0]->agrupador_fisioterapia);
                }
                if ($return[0]->convenio_id != '') {
                    $this->db->set('convenio_id', $return[0]->convenio_id);
                }
                if ($return[0]->numero_sessao != '') {
                    $this->db->set('numero_sessao', $return[0]->numero_sessao);
                }
                if ($return[0]->qtde_sessao != '') {
                    $this->db->set('qtde_sessao', $return[0]->qtde_sessao);
                }
                if ($return[0]->guia_id != '') {
                    $this->db->set('guia_id', $return[0]->guia_id);
                }
                if ($return[0]->procedimento_tuss_id != '') {
                    $this->db->set('procedimento_tuss_id', $return[0]->procedimento_tuss_id);
                }
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');



                $this->db->set('paciente_id', null);
                $this->db->set('procedimento_tuss_id', null);
                $this->db->set('convenio_id', null);
                $this->db->set('guia_id', null);
                $this->db->set('agrupador_fisioterapia', null);
                $this->db->set('numero_sessao', null);
                $this->db->set('qtde_sessao', null);
                $this->db->set('realizada', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
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
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_agenda_exames');


                $this->db->set('agenda_exames_id', $_POST['horarios']);
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_exames');
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

    function tipomultifuncaogeralmultiempresa($procedimento) {
        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimento);
        $return = $this->db->get();
        return $return->result();
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

    function gravartextoconvertido() {
        $horario = date("Y-m-d H:i:s");
        $texto = "<p>" . $_POST['texto'] . "</p>";

        $this->db->select('texto');
        $this->db->from('tb_ambulatorio_laudo');
        $this->db->where("ambulatorio_laudo_id", $_POST['laudo_id']);
        $return = $this->db->get()->result();


        $texto = $return[0]->texto . $texto;


        $this->db->set('texto', $texto);
        $this->db->set('operador_atualizacao', $_POST['operador_id']);
        $this->db->set('data_atualizacao', $horario);
        $this->db->where("ambulatorio_laudo_id", $_POST['laudo_id']);
        $this->db->update('tb_ambulatorio_laudo');
    }

    function gravarpacienteconsultasmultiempresa($agenda_exames_id, $tipo = null) {
        try {

            if ($_POST['txtNomeid'] == '') {
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
//                    if ($_POST['idade'] != 0) {
//                        $this->db->set('idade', $_POST['idade']);
//                    }

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
                $this->db->where("paciente_id", $paciente_id);
                $this->db->update('tb_paciente');
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', 1);
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 'f');
            $this->db->set('situacao', 'OK');
            if ($tipo != null) {
                $this->db->set('tipo', $tipo);
            }
            $this->db->set('observacoes', $_POST['observacoes']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return 0;
        }
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
            if (count($return) == 1) {

                if ($_POST['txtNomeid'] == '') {
                    if ($_POST['nascimento'] != '') {
                        $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                    }

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
//                $empresa_id = $this->session->userdata('empresa_id');
//                $this->db->set('empresa_id', $empresa_id);
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
                    if ($_POST['nascimento'] != '') {
                        $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                    }
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

    function gravarpacienteconsultasweb($paciente_id) {
        try {
            $data_atual = date("Y-m-d");
            $nome_paciente = str_replace('|||', ' ', $_GET['txtNome']);
//            $cpf = $_GET;
            $procedimento_convenio_id = $_GET['procedimento'];





            $grupo = $this->listarautocompletegrupoweb($procedimento_convenio_id);
//            var_dump($grupo); die;
            $horario = date("Y-m-d H:i:s");
            $this->db->set('procedimento_tuss_id', $_GET['procedimento']);
            $this->db->set('tipo', $grupo[0]->tipo);
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', $_GET['observacoes']);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
//                $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $_GET['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');

            $this->db->select('data, paciente_id');
            $this->db->from('tb_agenda_exames');
            $this->db->where("agenda_exames_id", $_GET['agenda_exames_id']);
//            $this->db->where("paciente_id is null");
            $retorno_data = $this->db->get()->result();
            return $retorno_data;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsenhatoten() {
        try {
            $operador_id = $this->session->userdata('operador_id');
            $horario = date("Y-m-d H:i:s");

            $this->db->set('senha', $_POST['senha']);
            $this->db->set('id', $_POST['id']);
            $this->db->set('data', $_POST['data']);
            $this->db->set('operador', $operador_id);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->insert('tb_toten_senha');

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function atendersenhatoten() {
        try {
            $operador_id = $this->session->userdata('operador_id');
            $horario = date("Y-m-d H:i:s");
            $this->db->select('toten_senha_id');
            $this->db->from('tb_toten_senha');
            $this->db->where('id', (string) $_POST['id']);
            $this->db->orderby("toten_senha_id desc");
            $retorno_data = $this->db->get()->result();


            if (count($retorno_data) > 0) {
                $id = @$retorno_data[0]->toten_senha_id;
                $this->db->set('atendida', 't');
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->where('toten_senha_id', $id);
                $this->db->update('tb_toten_senha');
            }


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarpacientefisioterapia($agenda_exames_id, $sessao_total, $contador_sessao, $agrupador) {
        try {

            $paciente_id = $_POST['txtNomeid'];

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
//            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'ESPECIALIDADE');
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', $_POST['observacoes']);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('qtde_sessao', $sessao_total);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->set('numero_sessao', $contador_sessao);
            $this->db->set('agrupador_fisioterapia', $agrupador);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarpacientefisioterapiapersonalizada($agenda, $sessao_total, $agrupador) {
        try {

            $paciente_id = $_POST['txtNomeid'];

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $agenda = array_filter($agenda);
            $contador_sessao = 1;
//            var_dump($agenda); die;
            foreach ($agenda as $item) {

//                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'ESPECIALIDADE');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('qtde_sessao', $_POST['sessao']);
                $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
                $this->db->set('convenio_id', $_POST['convenio']);
                $this->db->set('numero_sessao', $contador_sessao);
                $this->db->set('agrupador_fisioterapia', $agrupador);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $item);
                $this->db->update('tb_agenda_exames');
                $contador_sessao ++;
            }
            return $contador_sessao;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarpacientefisioterapiapersonalizadasessao($agenda_exames_id, $sessao_total, $contador_sessao, $agrupador) {
        try {

            $paciente_id = $_POST['txtNomeid'];

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
//            $agenda = array_filter($agenda);
//            var_dump($agenda); die;
//            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'ESPECIALIDADE');
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', $_POST['observacoes']);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('qtde_sessao', $_POST['sessao']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->set('numero_sessao', $contador_sessao);
            $this->db->set('agrupador_fisioterapia', $agrupador);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
//                $contador_sessao ++;


            return $contador_sessao;
        } catch (Exception $exc) {
            return false;
        }
    }

    function agrupadorfisioterapia() {


        $this->db->set('qtde_sessoes', $_POST['sessao']);
        $this->db->insert('tb_agrupador_fisioterapia_temp');
        $agrupador = $this->db->insert_id();
        return $agrupador;
    }

    function crianovopacienteorcamento() {
        $_POST['txtNome'] = strtoupper($_POST['txtNome']);
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

    function crianovopacienteespecialidade() {
        $_POST['txtNome'] = strtoupper($_POST['txtNome']);
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

    function criarnovopacienteintegracaoweb($cpf, $paciente_obj) {

        $this->db->select('paciente_id');
        $this->db->from('tb_paciente');
        $this->db->where("ativo", 't');
        $this->db->where("cpf", $cpf);
        $this->db->where("cpf is not null");
        $query = $this->db->get();
        $return = $query->result();


//        $paciente_id = $return[0]->paciente_id;
//        var_dump($return2); die;

        if (count($return) == 0) {

            $this->db->set('celular', $paciente_obj[0]->celular);
            $this->db->set('cpf', $paciente_obj[0]->cpf);
            $this->db->set('telefone', $paciente_obj[0]->telefone);
            $this->db->set('nome', $paciente_obj[0]->nome);
            $this->db->set('nascimento', $paciente_obj[0]->nascimento);
            $this->db->set('logradouro', $paciente_obj[0]->logradouro);
            $this->db->set('numero', $paciente_obj[0]->numero);
            $this->db->set('bairro', $paciente_obj[0]->bairro);
            $this->db->set('nome_mae', $paciente_obj[0]->nome_mae);
            $this->db->set('data_cadastro', date("Y-m-d H:i:s"));
            $this->db->set('paciente_web_id', $paciente_obj[0]->paciente_id);

//            $this->db->where('paciente_id', $paciente_id);
            $this->db->insert('tb_paciente');
            
            $paciente_id = $this->db->insert_id();
        } else {
            $paciente_id = $return[0]->paciente_id;

//            $this->db->set('celular', $_GET['txtCelular']);
//            $this->db->set('telefone', $_GET['txtTelefone']);
//            $this->db->set('nome', $_GET['txtNome']);
//            $this->db->where('paciente_id', $paciente_id);
//            $this->db->update('tb_paciente');
        }
        return $paciente_id;
    }

    function crianovopacientefidelidade() {

        $this->db->select('paciente_id');
        $this->db->from('tb_paciente');
        $this->db->where("ativo", 't');
        $this->db->where("cpf", $_GET['cpf']);
        $query = $this->db->get();
        $return = $query->result();
//        $paciente_id = $return[0]->paciente_id;
        $_GET['txtNome'] = strtoupper($_GET['txtNome']);
        $paciente_nome = str_replace("|||", " ", $_GET['txtNome']);
//        var_dump($_GET['nascimento']); die;
        if (count($return) == 0) {
            if ($_GET['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_GET['nascimento']))));
            }
            $this->db->set('celular', $_GET['celular']);
            $this->db->set('telefone', $_GET['telefone']);
            $this->db->set('cpf', $_GET['cpf']);
            $this->db->set('nome', $paciente_nome);
            $this->db->insert('tb_paciente');
            $paciente_id = $this->db->insert_id();
        } else {
            $paciente_id = $return[0]->paciente_id;

//            $this->db->set('celular', $_GET['txtCelular']);
//            $this->db->set('telefone', $_GET['txtTelefone']);
//            $this->db->set('nome', $_GET['txtNome']);
//            $this->db->where('paciente_id', $paciente_id);
//            $this->db->update('tb_paciente');
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
            $this->db->set('tipo', 'ESPECIALIDADE');
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
//            var_dump($_POST['guiaconvenio']);
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $numero_consultas = 0;
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
                $l = 0;
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
                            $this->db->select('dinheiro, fidelidade_endereco_ip');
                            $this->db->from('tb_convenio');
                            $this->db->where("convenio_id", $convenio);
                            $query = $this->db->get();
                            $return = $query->result();
                            $dinheiro = $return[0]->dinheiro;
                            $fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;

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
                    foreach ($_POST['guiaconvenio'] as $itemguiaconvenio) {
                        $l++;
                        if ($i == $l) {
                            $guiaconvenio = $itemguiaconvenio;
                            break;
                        }
                    }
                    if ($medicoexecutante == '') {
                        $medicoexecutante = 0;
                    }

//                    echo '<pre>';
//                    var_dump();
//                    die;
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medicoexecutante);
                    $this->db->where('mc.ativo', 'true');
                    $this->db->where('mc.revisor', 'false');
                    $percentual = $this->db->get()->result();
                    $grupo_laboratorio = $this->verificagrupoprocedimento($procedimento_tuss_id);
//                    $grupo = $_POST['grupo'][$i];
                    if ($grupo_laboratorio == 'LABORATORIAL') {
                        $this->db->select('mc.valor as perc_laboratorio, mc.percentual, mc.laboratorio');
                        $this->db->from('tb_procedimento_percentual_laboratorio_convenio mc');
                        $this->db->join('tb_procedimento_percentual_laboratorio m', 'm.procedimento_percentual_laboratorio_id = mc.procedimento_percentual_laboratorio_id', 'left');
                        $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
//        $this->db->where('mc.laboratorio', $laboratoriopercentual);
                        $this->db->where('mc.ativo', 'true');
//                        $this->db->where('mc.revisor', 'false');
                        $percentual_laboratorio = $this->db->get()->result();
                    }
//                    echo '<pre>';
//                    var_dump($percentual_laboratorio); die;

                    if (count($percentual) == 0) {
                        $this->db->select('pt.perc_medico, pt.percentual');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//                        $this->db->where('pc.ativo', 'true');
//                        $this->db->where('pt.ativo', 'true');
                        $percentual = $this->db->get()->result();
                    }

                    if ($indicacao != "") {
                        $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                        $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                        $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                        $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                        $this->db->where('mc.promotor', $indicacao);
                        $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                        $return2 = $this->db->get()->result();
                    } else {
                        $return2 = array();
                    }
//                    var_dump($percentual_laboratorio);
//                    die;
//                    if ($index == 1) {
//                    }
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

                    if ($fidelidade_endereco_ip != '') {
                        $numero_consultas = 1;
                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $this->db->select('p.cpf');
                        $this->db->from('tb_paciente p');
                        $this->db->where("p.paciente_id", $paciente_id);
                        $dados_paciente = $this->db->get()->result();

//                        $this->db->select('tipo');
//                        $this->db->from('tb_agenda_exames ae');
//                        $this->db->where("agenda_exames_id", $agenda_exames_id);
//                        $exame = $this->db->get()->result();


                        $informacoes['paciente_id'] = $paciente_id;
                        $informacoes['procedimento'] = $procedimento_tuss_id;
                        $informacoes['parceiro_id'] = $convenio;
                        $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                        $informacoes['grupo'] = $tipo_grupo;
                        $informacoes['agenda_exames_id'] = $agenda_exames_id;
                        $informacoes['numero_consultas'] = $numero_consultas;
                        $informacoes['valor'] = $valor;
//                        if ($exame[0]->tipo == 'CONSULTA'){
                        $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
                        if ($fidelidade == 'pending' || $fidelidade == 'no_exists') { // Caso esteja com pagamento pendente
                            $this->db->where('agenda_exames_id', $agenda_exames_id);
                            $this->db->delete('tb_agenda_exames');

                            return array(
                                "cod" => -1,
                                "message" => $fidelidade
                            );
                        }

                        if ($fidelidade == 'true') {
                            $fidelidade_liberado = true;
                        } elseif ($fidelidade == 'false') {
                            $fidelidade_liberado = false;
                        } else {
                            $fidelidade_liberado = false;
                        }
                    } else {
                        $fidelidade_liberado = false;
                    }


                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $procedimento_tuss_id = (int) $procedimento_tuss_id;
                    $agenda_exames_id = (int) $agenda_exames_id;

                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                    if ($indicacao != "") {
//                        $this->db->set('valor_promotor', $promotor[0]->valor_promotor);
//                        $this->db->set('percentual_promotor', $promotor[0]->percentual_promotor);
                        $this->db->set('indicacao', $indicacao);
                    }
                    if (count($percentual_laboratorio) > 0) {
//                        var_dump($index, $_POST['indicacao']);
                        $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                        $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                        $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
                    }
                    if (count($return2) > 0) {
//                        var_dump($index, $_POST['indicacao']);
                        $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                        $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
                        $this->db->set('indicacao', $indicacao);
                    }
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
                    if ($medico_id != "") {
                        $this->db->set('medico_solicitante', $medico_id);
                    }
                    if ($medicoexecutante != "") {
                        $this->db->set('medico_agenda', $medicoexecutante);
                        $this->db->set('medico_consulta_id', $medicoexecutante);
                    }

                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guiaconvenio', $guiaconvenio);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', $qtde);
//                    $this->db->set('valor', $valor);
                    $valortotal = $valor * $qtde;
//                    $this->db->set('valor_total', $valortotal);

                    if ($fidelidade_liberado) {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', $valortotal);
                    } else {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valortotal);
                    }

                    if ($fidelidade_liberado) {
                        $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    } elseif ($formapagamento != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valortotal);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }
                    $this->db->set('confirmado', 't');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $data = date("Y-m-d");
                    $this->db->set('data_faturar', $data);
                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');

                    $this->db->select('ep.autorizar_sala_espera');
                    $this->db->from('tb_empresa e');
                    $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                    $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                    $this->db->orderby('e.empresa_id');
                    $sala_de_espera_p = $this->db->get()->result();

                    $this->db->select('ae.agenda_exames_nome_id');
                    $this->db->from('tb_agenda_exames ae');
                    $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
//                    $this->db->orderby('e.empresa_id');
                    $agenda_exames_s = $this->db->get()->result();

                    if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $dados['agenda_exames_id'] = $agenda_exames_id;
                        $dados['medico'] = $medicoexecutante;
                        $dados['paciente_id'] = $paciente_id;
                        $dados['procedimento_tuss_id'] = $procedimento_tuss_id;
                        $dados['sala_id'] = @$agenda_exames_s[0]->agenda_exames_nome_id;
                        $dados['guia_id'] = $ambulatorio_guia_id;
                        $dados['tipo'] = $tipo_grupo;

                        $this->enviarsaladeespera($dados);
                    }

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

    function enviarsaladeespera($dados) {

        $agenda_exames_id = $dados['agenda_exames_id'];
        $medico = $dados['medico'];
        $paciente_id = $dados['paciente_id'];
        $procedimento_tuss_id = $dados['procedimento_tuss_id'];
        $sala_id = $dados['sala_id'];
        $guia_id = $dados['guia_id'];
        $tipo = $dados['tipo'];

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $exame_id = $agenda_exames_id;
//            echo '<pre>';
//            var_dump($_POST);
//            var_dump($procedimento_tuss_id);
//            var_dump($guia_id);
//            var_dump($agenda_exames_id);
//            var_dump($tipo);
//            die;


        $this->db->select('al.ambulatorio_laudo_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_exames ae', 'ae.exames_id = al.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->where("age.agenda_exames_id is not null");
        $this->db->where("al.data <=", $data);
        $this->db->where("age.paciente_id", $paciente_id);
        $this->db->where("al.medico_parecer1", $medico);
        $atendimentos = $this->db->get()->result();

        $this->db->select('data_senha, senha, toten_fila_id, toten_senha_id');
        $this->db->from('tb_paciente p');
        $this->db->where("p.paciente_id", $paciente_id);
        $paciente_inf = $this->db->get()->result();




//            var_dump($atendimentos); die;
        if (count($atendimentos) > 0) {
            $primeiro_atendimento = 'f';
        } else {
            $primeiro_atendimento = 't';
        }

        $this->db->select('ppmc.dia_recebimento, ppmc.tempo_recebimento');
        $this->db->from('tb_procedimento_percentual_medico ppm');
        $this->db->join("tb_procedimento_percentual_medico_convenio ppmc", "ppmc.procedimento_percentual_medico_id = ppm.procedimento_percentual_medico_id");
        $this->db->where("ppm.procedimento_tuss_id", $procedimento_tuss_id);
        $this->db->where("ppmc.medico", $medico);
        $retorno = $this->db->get()->result();

//            echo "<pre>"; var_dump($retorno); die;
        if (count($retorno) > 0 && @$retorno[0]->dia_recebimento != '' && @$retorno[0]->tempo_recebimento != '') {
            if (date("d") > $retorno[0]->dia_recebimento) {
                $d = date("Y-m-", strtotime("+1 month")) . $retorno[0]->dia_recebimento;
                $dataProducao = date("Y-m-d", strtotime("+" . $retorno[0]->tempo_recebimento . " days", strtotime($d)));
            } else {
                $d = date("Y-m-") . $retorno[0]->dia_recebimento;
                $dataProducao = date("Y-m-d", strtotime("+" . $retorno[0]->tempo_recebimento . " days", strtotime($d)));
            }
        } else {
            $dataProducao = $data;
        }

//                $this->db->set('ativo', 'f');
//                $this->db->where('exame_sala_id', $_POST['txtsalas']);
//                $this->db->update('tb_exame_sala');

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('paciente_id', $paciente_id);

        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->set('guia_id', $guia_id);
        $this->db->set('tipo', $tipo);
        $this->db->set('agenda_exames_id', $agenda_exames_id);
        $this->db->set('sala_id', $sala_id);
        if ($medico != "") {
            $this->db->set('medico_realizador', $medico);
        }

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_exames');
        $exames_id = $this->db->insert_id();

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data', $data);
        if (count($paciente_inf) > 0) {
            $this->db->set('toten_senha_id', $paciente_inf[0]->toten_senha_id);
            $this->db->set('toten_fila_id', $paciente_inf[0]->toten_fila_id);
            $this->db->set('senha ', $paciente_inf[0]->senha);
            $this->db->set('data_senha', $paciente_inf[0]->data_senha);
        }

        $this->db->set('data_producao', $dataProducao);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->set('exame_id', $exames_id);
        $this->db->set('guia_id', $guia_id);
        $this->db->set('tipo', $tipo);
        $this->db->set('primeiro_atendimento', $primeiro_atendimento);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        if ($medico != "") {
            $this->db->set('medico_parecer1', $medico);
        }
//        $this->db->set('id_chamada', $_POST['idChamada']);
        $this->db->insert('tb_ambulatorio_laudo');
        $laudo_id = $this->db->insert_id();

        if ($medico != "") {
            $this->db->set('medico_consulta_id', $medico);
            $this->db->set('medico_agenda', $medico);
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
        }
        $this->db->set('realizada', 'true');
        $this->db->set('senha', md5($exame_id));
        $this->db->set('data_realizacao', $horario);
        $this->db->set('operador_realizacao', $operador_id);

        $this->db->set('agenda_exames_nome_id', $sala_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('agenda_exames_id', $agenda_exames_id);
        $this->db->set('sala_id', $sala_id);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->insert('tb_ambulatorio_chamada');

        return true;
    }

    function autorizarpacientefidelidade($endereco, $informacoes) {
        $paciente_id = $informacoes['paciente_id'];
        $procedimento = $informacoes['procedimento'];
        $parceiro_id = $informacoes['parceiro_id'];
        $cpf = $informacoes['cpf'];
        $grupo = $informacoes['grupo'];
        $valor = $informacoes['valor'];
        $agenda_exames_id = $informacoes['agenda_exames_id'];
        $numero_consultas = $informacoes['numero_consultas'];
//        var_dump($informacoes); die;
        $return = file_get_contents("http://{$endereco}/autocomplete/autorizaratendimentoweb?paciente_id=$paciente_id&procedimento=$procedimento&parceiro_id=$parceiro_id&cpf=$cpf&grupo=$grupo&agenda_exames_id=$agenda_exames_id&numero_consultas=$numero_consultas&valor=$valor");
        $resposta = json_decode($return);
//        var_dump($return);
//        die;
        // Caso venha "no_exists" o paciente não existe no Fidelidade
        return $resposta;
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
            $numero_consultas = 0;
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
                            $this->db->select('dinheiro, fidelidade_endereco_ip');
                            $this->db->from('tb_convenio');
                            $this->db->where("convenio_id", $convenio);
                            $query = $this->db->get();
                            $return = $query->result();
                            $dinheiro = $return[0]->dinheiro;
                            $fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;

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


                    if ($fidelidade_endereco_ip != '') {
                        $numero_consultas = 1;
                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $this->db->select('p.cpf');
                        $this->db->from('tb_paciente p');
                        $this->db->where("p.paciente_id", $paciente_id);
                        $dados_paciente = $this->db->get()->result();




                        $informacoes['paciente_id'] = $paciente_id;
                        $informacoes['procedimento'] = $procedimento_tuss_id;
                        $informacoes['parceiro_id'] = $convenio;
                        $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                        $informacoes['grupo'] = $tipo_grupo;
                        $informacoes['agenda_exames_id'] = $agenda_exames_id;
                        $informacoes['numero_consultas'] = $numero_consultas;
                        $informacoes['valor'] = $valor;

                        $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
                        if ($fidelidade == 'pending' || $fidelidade == 'no_exists') { // Caso esteja com pagamento pendente
                            $this->db->where('agenda_exames_id', $agenda_exames_id);
                            $this->db->delete('tb_agenda_exames');

                            return array(
                                "cod" => -1,
                                "message" => $fidelidade
                            );
                        }

                        if ($fidelidade == 'true') {
                            $fidelidade_liberado = true;
                        } elseif ($fidelidade == 'false') {
                            $fidelidade_liberado = false;
                        } else {
                            $fidelidade_liberado = false;
                        }
                    } else {
                        $fidelidade_liberado = false;
                    }

                    // Função do Percentual
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medico_id);
                    $this->db->where('mc.ativo', 'true');
                    $this->db->where('mc.revisor', 'false');
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
//                    $this->db->select('pt.valor_promotor, pt.percentual_promotor');
//                    $this->db->from('tb_procedimento_convenio pc');
//                    $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
//                    $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//              $this->db->where('pc.ativo', 'true');
//                $this->db->where('pt.ativo', 'true');
//                    $promotor = $this->db->get()->result();

                    if ($indicacao != "") {
                        $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                        $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                        $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                        $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                        $this->db->where('mc.promotor', $indicacao);
                        $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                        $promotor = $this->db->get()->result();
                    } else {
                        $promotor = array();
                    }

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
                    if (count($promotor) > 0) {
                        $this->db->set('valor_promotor', $promotor[0]->valor_promotor);
                        $this->db->set('percentual_promotor', $promotor[0]->percentual_promotor);
                    }
                    if ($indicacao != "") {
                        $this->db->set('indicacao', $indicacao);
                    }
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', '1');
                    $this->db->set('agenda_exames_nome_id', $sala);
                    if ($fidelidade_liberado) {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', $valor);
                    } else {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor);
                    }

                    if ($fidelidade_liberado) {
                        $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    } elseif ($formapagamento != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }

                    $this->db->set('confirmado', 't');
                    $data = date("Y-m-d");
                    $this->db->set('data_faturar', $data);
                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');

                    $this->db->select('ep.autorizar_sala_espera');
                    $this->db->from('tb_empresa e');
                    $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                    $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                    $this->db->orderby('e.empresa_id');
                    $sala_de_espera_p = $this->db->get()->result();

                    if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $dados['agenda_exames_id'] = $agenda_exames_id;
                        $dados['medico'] = $medico_id;
                        $dados['paciente_id'] = $paciente_id;
                        $dados['procedimento_tuss_id'] = $procedimento_tuss_id;
                        $dados['sala_id'] = $sala;
                        $dados['guia_id'] = $ambulatorio_guia_id;
                        $dados['tipo'] = $tipo_grupo;

                        $this->enviarsaladeespera($dados);
                    }

                    $confimado = "";
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function autorizarpacientetempfisioterapiahomecare($paciente_id, $ambulatorio_guia_id) {
        try {
//            $testemedico = $_POST['medico_id'];
//            var_dump($_POST['medico_id']);die;
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $numero_consultas = 0;
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

                    if ($fidelidade_endereco_ip != '') {
                        $numero_consultas = 1;
                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $this->db->select('p.cpf');
                        $this->db->from('tb_paciente p');
                        $this->db->where("p.paciente_id", $paciente_id);
                        $dados_paciente = $this->db->get()->result();




                        $informacoes['paciente_id'] = $paciente_id;
                        $informacoes['procedimento'] = $procedimento_tuss_id;
                        $informacoes['parceiro_id'] = $convenio;
                        $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                        $informacoes['grupo'] = $tipo_grupo;
                        $informacoes['agenda_exames_id'] = $agenda_exames_id;
                        $informacoes['numero_consultas'] = $numero_consultas;
                        $informacoes['valor'] = $valor;

                        $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
//                        var_dump($fidelidade);
//                        die;
                        if ($fidelidade == 'true') {
                            $fidelidade_liberado = true;
                        } elseif ($fidelidade == 'false') {
                            $fidelidade_liberado = false;
                        } else {
                            $fidelidade_liberado = false;
                        }
                    } else {
                        $fidelidade_liberado = false;
                    }

                    // Função do Percentual
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medico_id);
                    $this->db->where('mc.ativo', 'true');
                    $this->db->where('mc.revisor', 'false');
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
                    $data = date("Y-m-d");
                    $this->db->set('data_faturar', $data);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                    for ($index = 2; $index <= $qtde; $index++) {
                        $this->db->set('convenio_id', $convenio);
                        $this->db->set('empresa_id', $empresa_id);
                        $this->db->set('tipo', 'ESPECIALIDADE');
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
                        $this->db->set('agrupador_fisioterapia', $agrupador_fisioterapia);
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
                        $data = date("Y-m-d");
                        $this->db->set('data_faturar', $datahoje);
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

    function autorizarpacientetempfisioterapia($paciente_id, $ambulatorio_guia_id) {
        try {
//            $testemedico = $_POST['medico_id'];
//            var_dump($_POST['medico_id']);die;
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $numero_consultas = 0;
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
//                $sala = $_POST['sala'][$i];

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
                            $this->db->select('dinheiro, fidelidade_endereco_ip');
                            $this->db->from('tb_convenio');
                            $this->db->where("convenio_id", $convenio);
                            $query = $this->db->get();
                            $return = $query->result();
                            $dinheiro = $return[0]->dinheiro;
                            $fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;
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

                    if ($fidelidade_endereco_ip != '') {
                        $numero_consultas = 1;
                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $this->db->select('p.cpf');
                        $this->db->from('tb_paciente p');
                        $this->db->where("p.paciente_id", $paciente_id);
                        $dados_paciente = $this->db->get()->result();




                        $informacoes['paciente_id'] = $paciente_id;
                        $informacoes['procedimento'] = $procedimento_tuss_id;
                        $informacoes['parceiro_id'] = $convenio;
                        $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                        $informacoes['grupo'] = $tipo_grupo;
                        $informacoes['agenda_exames_id'] = $agenda_exames_id;
                        $informacoes['numero_consultas'] = $numero_consultas;
                        $informacoes['valor'] = $valor;

                        $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
                        if ($fidelidade == 'pending' || $fidelidade == 'no_exists') { // Caso esteja com pagamento pendente
                            $this->db->where('agenda_exames_id', $agenda_exames_id);
                            $this->db->delete('tb_agenda_exames');

                            return array(
                                "cod" => -1,
                                "message" => $fidelidade
                            );
                        }
//                        var_dump($fidelidade);
//                        die;
                        if ($fidelidade == 'true') {
                            $fidelidade_liberado = true;
                        } elseif ($fidelidade == 'false') {
                            $fidelidade_liberado = false;
                        } else {
                            $fidelidade_liberado = false;
                        }
                    } else {
                        $fidelidade_liberado = false;
                    }



                    $valor_convenio = $valor / $qtde;

                    $this->db->select('pc.procedimento_convenio_id, 
                            pcs.procedimento_convenio_sessao_id,
                            pcs.sessao,
                            pcs.valor_sessao');
                    $this->db->from('tb_procedimento_convenio_sessao pcs');
                    $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pcs.procedimento_convenio_id', 'left');
                    $this->db->where('pcs.ativo', 't');
                    $this->db->where('pcs.sessao', 1);
                    $this->db->where('pcs.procedimento_convenio_id', $procedimento_tuss_id);
                    $sessao1_valor = $this->db->get()->result();
                    if (count($sessao1_valor) > 0 && $dinheiro == 't') {
                        $valor = $sessao1_valor[0]->valor_sessao;
                    }
//                    var_dump($valor); die;
                    // Função do Percentual
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medico_id);
                    $this->db->where('mc.ativo', 'true');
                    $this->db->where('mc.revisor', 'false');
                    $percentual = $this->db->get()->result();

                    if (count($percentual) == 0) {
                        $this->db->select('pt.perc_medico, pt.percentual');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//                        $this->db->where('pc.ativo', 'true');
//                        $this->db->where('pt.ativo', 'true');
                        $percentual = $this->db->get()->result();
                    }
//                var_dump($percentual); die;

                    if ($indicacao != "") {
                        $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                        $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                        $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                        $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                        $this->db->where('mc.promotor', $indicacao);
                        $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                        $promotor = $this->db->get()->result();
                    } else {
                        $promotor = array();
                    }



                    $hora = date("H:i:s");
                    $data = date("Y-m-d");


                    $this->db->select('ae.agrupador_fisioterapia');
                    $this->db->from('tb_agenda_exames ae');
                    $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
                    $result4 = $this->db->get()->result();
                    $agrupador_fisioterapia = $result4[0]->agrupador_fisioterapia;
//                    var_dump($qtde); die;

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
                    if (count($promotor) > 0) {
                        $this->db->set('valor_promotor', $promotor[0]->valor_promotor);
                        $this->db->set('percentual_promotor', $promotor[0]->percentual_promotor);
                    }
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

                    $this->db->set('agrupador_fisioterapia', $agrupador_fisioterapia);
                    $this->db->set('numero_sessao', '1');
                    $this->db->set('qtde_sessao', $qtde);

                    if ($fidelidade_liberado) {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    } else {
                        if ($dinheiro == "t") {
                            $this->db->set('valor', $valor);
                            $this->db->set('valor_total', $valor);
                            $this->db->set('confirmado', 't');
                        } else {
                            $this->db->set('valor', $valor_convenio);
                            $this->db->set('valor_total', $valor_convenio);
                            $this->db->set('confirmado', 't');
                        }
                    }

                    if ($fidelidade_liberado) {
                        $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    } elseif ($formapagamento != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }

                    $this->db->set('ativo', 'f');
//                    $data = date("Y-m-d");
                    $this->db->set('data_faturar', $data);
                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');


                    $this->db->select('ep.autorizar_sala_espera');
                    $this->db->from('tb_empresa e');
                    $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                    $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                    $this->db->orderby('e.empresa_id');
                    $sala_de_espera_p = $this->db->get()->result();

                    if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $dados['agenda_exames_id'] = $agenda_exames_id;
                        $dados['medico'] = $medico_id;
                        $dados['paciente_id'] = $paciente_id;
                        $dados['procedimento_tuss_id'] = $procedimento_tuss_id;
                        $dados['sala_id'] = $sala;
                        $dados['guia_id'] = $ambulatorio_guia_id;
                        $dados['tipo'] = $tipo_grupo;

                        $this->enviarsaladeespera($dados);
                    }

                    $confimado = "";
                    for ($index = 2; $index <= $qtde; $index++) {

                        if ($agrupador_fisioterapia != '') {
                            $this->db->set('convenio_id', $convenio);
                            $this->db->set('empresa_id', $empresa_id);
                            $this->db->set('tipo', 'ESPECIALIDADE');
                            if ($_POST['ordenador'] != "") {
                                $this->db->set('ordenador', $_POST['ordenador']);
                            }
//                            if ($medico_id != "") {
//                                $this->db->set('medico_agenda', $medico_id);
//                                $this->db->set('medico_consulta_id', $medico_id);
//                            }
                            $this->db->set('autorizacao', $autorizacao);
                            $this->db->set('guia_id', $ambulatorio_guia_id);
                            $this->db->set('quantidade', '1');
                            $this->db->set('agenda_exames_nome_id', $sala);
                            $sessao2_valor = $this->listarprocedimentoconveniosessao($procedimento_tuss_id, $index);
                            if (count($sessao2_valor) > 0) {
                                $valor = $sessao2_valor[0]->valor_sessao;
                            } else {
                                $valor = 0;
                            }
                            $this->db->set('valor_medico', $percentual[0]->perc_medico);
                            $this->db->set('percentual_medico', $percentual[0]->percentual);
//                            var_dump($sessao2_valor); die;
                            if ($fidelidade_liberado) {
                                $this->db->set('valor', 0);
                                $this->db->set('valor_total', $valor);
                                $this->db->set('confirmado', 'f');
                            } else {
                                if ($dinheiro == "t") {
                                    $this->db->set('valor', $valor);
                                    $this->db->set('valor_total', $valor);
                                    $this->db->set('confirmado', 'f');
                                } else {
                                    $this->db->set('valor', $valor_convenio);
                                    $this->db->set('valor_total', $valor_convenio);
                                    $this->db->set('confirmado', 'f');
                                }
                            }
                            $this->db->set('situacao', 'OK');
//                        $this->db->set('agrupador_fisioterapia', $agrupador_fisioterapia);
//                        $this->db->set('numero_sessao', $index);
//                        $this->db->set('qtde_sessao', $qtde);
                            if ($fidelidade_liberado) {
                                $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                                $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                                $this->db->set('operador_faturamento', $operador_id);
                                $this->db->set('data_faturamento', $horario);
                            } elseif ($formapagamento != 0 && $dinheiro == "t") {
                                $this->db->set('faturado', 't');
                                $this->db->set('forma_pagamento', $formapagamento);
                                $this->db->set('valor1', $valor);
                                $this->db->set('operador_faturamento', $operador_id);
                                $this->db->set('data_faturamento', $horario);
                            }
                            $this->db->set('ativo', 'f');
                            $this->db->set('data_atualizacao', $horario);
                            $this->db->set('operador_atualizacao', $operador_id);
                            $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                            $this->db->set('paciente_id', $paciente_id);
                            $this->db->set('ambulatorio_pacientetemp_id', null);
                            $this->db->set('data_autorizacao', $horario);
//                        $this->db->set('data', $datahoje);
                            $this->db->set('operador_autorizacao', $operador_id);
                            $this->db->where('numero_sessao', $index);
                            $this->db->where('qtde_sessao', $qtde);
                            $data = date("Y-m-d");
                            $this->db->set('data_faturar', $data);
                            $this->db->where('agrupador_fisioterapia', $agrupador_fisioterapia);
                            $this->db->update('tb_agenda_exames');
                            $confimado = "";
                        } else {
                            $this->db->set('convenio_id', $convenio);
                            $this->db->set('empresa_id', $empresa_id);
                            $this->db->set('tipo', 'ESPECIALIDADE');
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
                            $sessao2_valor = $this->listarprocedimentoconveniosessao($procedimento_tuss_id, $index);
                            if (count($sessao2_valor) > 0) {
                                $valor = $sessao2_valor[0]->valor_sessao;
                            } else {
                                $valor = 0;
                            }
                            $this->db->set('valor_medico', $percentual[0]->perc_medico);
                            $this->db->set('percentual_medico', $percentual[0]->percentual);
//                            var_dump($sessao2_valor); die;
                            if ($dinheiro == "t") {
                                $this->db->set('valor', $valor);
                                $this->db->set('valor_total', $valor);
                                $this->db->set('confirmado', 'f');
                            } else {
                                $this->db->set('valor', $valor_convenio);
                                $this->db->set('valor_total', $valor_convenio);
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
                            $data = date("Y-m-d");
                            $this->db->set('data_faturar', $datahoje);
                            $this->db->set('operador_autorizacao', $operador_id);
                            $this->db->insert('tb_agenda_exames');
                            $confimado = "";
                        }
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gerasaldocredito($paciente_credito_id) {
        $this->db->select('SUM(pcr.valor) AS valor_total,
                           p.nome as paciente');
        $this->db->from('tb_paciente_credito pcr');
        $this->db->join('tb_paciente p', 'p.paciente_id = pcr.paciente_id', 'left');
        $this->db->where("pcr.paciente_id", $paciente_credito_id);
        $this->db->where("pcr.ativo", 't');
        $this->db->groupby("p.nome");
        $query = $this->db->get();
        return $query->result();
    }

    function gerarecibocredito($paciente_credito_id) {

        $this->db->select('pcr.valor,
                           p.nome as paciente,
                           pt.nome as procedimento,
                           pcr.data_cadastro,
                           fp.nome as forma_pagamento,
                           m.nome as municipio');
        $this->db->from('tb_paciente_credito pcr');
        $this->db->join('tb_paciente p', 'p.paciente_id = pcr.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pcr.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pcr.forma_pagamento_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = pcr.empresa_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');
        $this->db->where("pcr.paciente_credito_id", $paciente_credito_id);
        $query = $this->db->get();
        return $query->result();
    }

    function buscarvalorprocedimentoagrupados($convenio_id, $procedimento_agrupador_id) {

        $this->db->select('pa.procedimento_tuss_id');
        $this->db->from('tb_procedimentos_agrupados_ambulatorial pa');
        $this->db->where("pa.procedimento_agrupador_id", $procedimento_agrupador_id);
        $this->db->where("pa.ativo", 't');
        $query = $this->db->get();
        $agrupados = $query->result();

        $this->db->select('procedimento_convenio_id');
        $this->db->from('tb_procedimento_convenio pc');

        $this->db->where("procedimento_tuss_id IN (SELECT procedimento_tuss_id 
                                                   FROM ponto.tb_procedimentos_agrupados_ambulatorial
                                                   WHERE ativo = 't' AND procedimento_agrupador_id = $procedimento_agrupador_id)");
        $this->db->where("convenio_id", $convenio_id);
        $this->db->where("ativo", 't');
        $query = $this->db->get();
        $procedimentos = $query->result();

//        echo "<pre>";var_dump($procedimentos); die;
        $string = '';
        for ($i = 0; $i < count($procedimentos); $i++) {
            $string .= $procedimentos[$i]->procedimento_convenio_id . (($i != count($procedimentos) - 1) ? ',' : '');
        }


        if (count($agrupados) == count($procedimentos) && count($procedimentos) != 0) {
            $this->db->select('SUM(valortotal) AS valor_pacote');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->where("procedimento_convenio_id IN ($string)");
            $this->db->where("ativo", 't');
            $query = $this->db->get();
            $procedimentos = $query->result();

            return $procedimentos[0]->valor_pacote;
        } else {
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

    function verificagrupoprocedimento($procedimento_convenio_id) {

        $this->db->select('ag.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $query = $this->db->get();
        $tipo = $query->result();
        return $tipo[0]->nome;
    }

    function verificatipoprocedimento($procedimento_convenio_id) {

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

            $this->db->select('ep.ajuste_pagamento_procedimento as ajustepagamento');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $flags = $this->db->get()->result();

            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $numero_consultas = 0;
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

                if ($procedimento_tuss_id != '') {
                    $tipo = $this->verificaexamemedicamento($procedimento_tuss_id);
                } else {
                    $tipo = '';
                }

                if (($tipo == 'EXAME' || $tipo == 'MEDICAMENTO' || $tipo == 'MATERIAL') && $_POST['medico'][$i] == '') {
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
                            $this->db->select('dinheiro, fidelidade_endereco_ip');
                            $this->db->from('tb_convenio');
                            $this->db->where("convenio_id", $convenio);
                            $query = $this->db->get();
                            $return = $query->result();
                            $dinheiro = $return[0]->dinheiro;
                            $fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;
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

                    if ($fidelidade_endereco_ip != '') {

                        $numero_consultas = 1;

                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $this->db->select('p.cpf');
                        $this->db->from('tb_paciente p');
                        $this->db->where("p.paciente_id", $paciente_id);
                        $dados_paciente = $this->db->get()->result();




                        $informacoes['paciente_id'] = $paciente_id;
                        $informacoes['procedimento'] = $procedimento_tuss_id;
                        $informacoes['parceiro_id'] = $convenio;
                        $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                        $informacoes['grupo'] = $tipo_grupo;
                        $informacoes['agenda_exames_id'] = $agenda_exames_id;
                        $informacoes['numero_consultas'] = $numero_consultas;
                        $informacoes['valor'] = $valor;

//                        $this->db->select('tipo');
//                        $this->db->from('tb_agenda_exames ae');
//                        $this->db->where("agenda_exames_id", $agenda_exames_id);
//                        $exame = $this->db->get()->result();

                        $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
                        if ($fidelidade == 'pending' || $fidelidade == 'no_exists') { // Caso esteja com pagamento pendente
                            $this->db->where('agenda_exames_id', $agenda_exames_id);
                            $this->db->delete('tb_agenda_exames');

                            return array(
                                "cod" => -1,
                                "message" => $fidelidade
                            );
                        }

//                        var_dump($fidelidade);
//                        die;
                        if ($fidelidade == 'true') {
                            $fidelidade_liberado = true;
                        } elseif ($fidelidade == 'false') {
                            $fidelidade_liberado = false;
                        } else {
                            $fidelidade_liberado = false;
                        }
                    } else {
                        $fidelidade_liberado = false;
                    }


                    $valor_convenio = $valor / $qtde;

                    $this->db->select('pc.procedimento_convenio_id, 
                            pcs.procedimento_convenio_sessao_id,
                            pcs.sessao,
                            pcs.valor_sessao');
                    $this->db->from('tb_procedimento_convenio_sessao pcs');
                    $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pcs.procedimento_convenio_id', 'left');
                    $this->db->where('pcs.ativo', 't');
                    $this->db->where('pcs.sessao', 1);
                    $this->db->where('pcs.procedimento_convenio_id', $procedimento_tuss_id);
                    $sessao1_valor = $this->db->get()->result();
                    if (count($sessao1_valor) > 0 && $dinheiro == 't') {
                        $valor = $sessao1_valor[0]->valor_sessao;
                    }


                    // Função do Percentual
                    $this->db->select('mc.valor as perc_medico, mc.percentual');
                    $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                    $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->where('mc.medico', $medico_id);
                    $this->db->where('mc.ativo', 'true');
                    $this->db->where('mc.revisor', 'false');
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
                    if ($indicacao != "") {
                        $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                        $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                        $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                        $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                        $this->db->where('mc.promotor', $indicacao);
                        $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                        $promotor = $this->db->get()->result();
                    } else {
                        $promotor = array();
                    }
//                    var_dump($procedimento_tuss_id); die;
//                    if(){
//                        
//                    }
//                    $grupo_laboratorio = $this->verificagrupoprocedimento($procedimento_tuss_id);
                    //if ($grupo_laboratorio == 'LABORATORIAL') {
                    $this->db->select('mc.valor as perc_laboratorio, mc.percentual, mc.laboratorio');
                    $this->db->from('tb_procedimento_percentual_laboratorio_convenio mc');
                    $this->db->join('tb_procedimento_percentual_laboratorio m', 'm.procedimento_percentual_laboratorio_id = mc.procedimento_percentual_laboratorio_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
//        $this->db->where('mc.laboratorio', $laboratoriopercentual);
                    $this->db->where('mc.ativo', 'true');
                    $this->db->where('mc.revisor', 'false');
                    $percentual_laboratorio = $this->db->get()->result();
                    // }




                    $hora = date("H:i:s");
                    $data = date("Y-m-d");



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
                    if (count($promotor) > 0) {

                        $this->db->set('valor_promotor', $promotor[0]->valor_promotor);
                        $this->db->set('percentual_promotor', $promotor[0]->percentual_promotor);
                    }

                    if (count($percentual_laboratorio) > 0) {
//                        var_dump($index, $_POST['indicacao']);
                        $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                        $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                        $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
                    }
                    if ($crmsolicitante != "") {
                        $this->db->set('medico_solicitante', $crmsolicitante);
                    }
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
//                    $_POST['qtdeProc'][$i];
                    $this->db->set('quantidade', (int) $_POST['qtdeProc'][$i]);
                    $this->db->set('agenda_exames_nome_id', $sala);
                    if ($fidelidade_liberado) {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    } else {
                        if ($dinheiro == "t") {
                            $this->db->set('valor', $valor);
                            $this->db->set('valor_total', $valor);
                            $this->db->set('confirmado', 't');
                        } else {
                            $this->db->set('valor', $valor_convenio);
                            $this->db->set('valor_total', $valor_convenio);
                            $this->db->set('confirmado', 't');
                        }
                    }

                    $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                    $this->db->set('numero_sessao', '1');
                    $this->db->set('qtde_sessao', $qtde);

                    if ($fidelidade_liberado) {
                        $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    } elseif ($formapagamento != '' && $dinheiro == "t") {
                        if ($flags[0]->ajustepagamento != 't') {
                            $this->db->set('faturado', 't');
                            $this->db->set('forma_pagamento', $formapagamento);
                            $this->db->set('valor1', $valor);
                            $this->db->set('operador_faturamento', $operador_id);
                            $this->db->set('data_faturamento', $horario);
                        } else {
                            $this->db->set('procedimento_possui_ajuste_pagamento', 't');
                            $this->db->set('forma_pagamento_ajuste', $formapagamento);
                            $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorajuste'][$i]);
                        }
                    }

                    $this->db->set('ativo', 'f');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->set('senha', md5($agenda_exames_id));
//                    $data = date("Y-m-d");
                    $this->db->set('data_faturar', $data);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');

                    $this->db->select('ep.autorizar_sala_espera');
                    $this->db->from('tb_empresa e');
                    $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                    $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                    $this->db->orderby('e.empresa_id');
                    $sala_de_espera_p = $this->db->get()->result();

                    if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $dados['agenda_exames_id'] = $agenda_exames_id;
                        $dados['medico'] = $medico_id;
                        $dados['paciente_id'] = $paciente_id;
                        $dados['procedimento_tuss_id'] = $procedimento_tuss_id;
                        $dados['sala_id'] = $sala;
                        $dados['guia_id'] = $ambulatorio_guia_id;
                        $dados['tipo'] = $tipo_grupo;

                        $this->enviarsaladeespera($dados);
                    }

                    $confimado = "";
                    for ($index = 2; $index <= $qtde; $index++) {
                        $this->db->set('convenio_id', $convenio);
                        $this->db->set('empresa_id', $empresa_id);
                        $this->db->set('tipo', 'ESPECIALIDADE');
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
                        $sessao2_valor = $this->listarprocedimentoconveniosessao($procedimento_tuss_id, $index);
                        if (count($sessao2_valor) > 0) {
                            $valor = $sessao2_valor[0]->valor_sessao;
                        } else {
                            $valor = 0;
                        }
//                            var_dump($sessao2_valor); die;
                        if ($fidelidade_liberado) {
                            $this->db->set('valor', 0);
                            $this->db->set('valor_total', $valor);
                            $this->db->set('confirmado', 'f');
                        } else {
                            if ($dinheiro == "t") {
                                $this->db->set('valor', $valor);
                                $this->db->set('valor_total', $valor);
                                $this->db->set('confirmado', 'f');
                            } else {
                                $this->db->set('valor', $valor_convenio);
                                $this->db->set('valor_total', $valor_convenio);
                                $this->db->set('confirmado', 'f');
                            }
                        }
                        $this->db->set('situacao', 'OK');
                        $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                        $this->db->set('numero_sessao', $index);
                        $this->db->set('qtde_sessao', $qtde);
                        if ($fidelidade_liberado) {
                            $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                            $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                            $this->db->set('operador_faturamento', $operador_id);
                            $this->db->set('data_faturamento', $horario);
                        } elseif ($formapagamento != '' && $dinheiro == "t") {
                            if ($flags[0]->ajustepagamento != 't') {
                                $this->db->set('faturado', 't');
                                $this->db->set('forma_pagamento', $formapagamento);
                                $this->db->set('valor1', $valor);
                                $this->db->set('operador_faturamento', $operador_id);
                                $this->db->set('data_faturamento', $horario);
                            } else {
                                $this->db->set('procedimento_possui_ajuste_pagamento', 't');
                                $this->db->set('forma_pagamento_ajuste', $formapagamento);
                                $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorajuste'][$i]);
                            }
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                        $this->db->set('paciente_id', $paciente_id);
                        $this->db->set('ambulatorio_pacientetemp_id', null);
                        $this->db->set('data_autorizacao', $horario);
                        $this->db->set('data', $datahoje);
//                        $data = date("Y-m-d");
                        $this->db->set('data_faturar', $datahoje);
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
            $this->db->where('es.exame_sala_id', $parametro);
            $this->db->where('a.data', $teste);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoconveniosessao($convenio_id, $sessao) {

        //verifica se esse medico já está cadastrado nesse procedimento 
        $this->db->select('pc.procedimento_convenio_id, 
                            pcs.procedimento_convenio_sessao_id,
                            pcs.sessao,
                            pcs.valor_sessao');
        $this->db->from('tb_procedimento_convenio_sessao pcs');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pcs.procedimento_convenio_id', 'left');
        $this->db->where('pcs.ativo', 't');
        $this->db->where('pcs.sessao', $sessao);
        $this->db->where('pcs.procedimento_convenio_id', $convenio_id);
        $return = $this->db->get();
        $result = $return->result();
        return $result;
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
                            a.medico_agenda,
                            o.nome as medico,
                            a.inicio,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda');

        $this->db->where('a.ativo', 'true');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.situacao', 'LIVRE');
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

    function listarhorariosespecialidadepersonalizado($parametro = null, $teste = null) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('a.agenda_exames_id,
                            a.medico_agenda,
                            o.nome as medico,
                            a.inicio,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda');

        $this->db->where('a.ativo', 'true');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.situacao', 'LIVRE');
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

    function listarhorariosdisponiveisorcamento($parametro, $empresa_id) {
        $this->db->select("pt.grupo");
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where('pc.procedimento_convenio_id', $parametro);
        $this->db->where('pt.grupo', 'LABORATORIAL');
        $retorno = $this->db->get()->result();

        if (count($retorno) == 0) {

            $horario = date("Y-m-d");
            // O "false" no parametro so SELECT serve para dizer ao CodeIgniter não pôr aspas.
            $this->db->select("a.data,to_char(a.data, 'DD-MM-YYYY') as data_formatada_picker,
                              to_char(a.data, 'DD/MM/YYYY') as data_formatada", false);
            $this->db->from('tb_agenda_exames a');
            $this->db->where('a.ativo', 'true');
            $this->db->where('a.bloqueado', 'false');
            $this->db->where('a.data >=', $horario);
            $this->db->where('a.empresa_id', $empresa_id);
            $this->db->where("a.medico_agenda IN (
                SELECT cop.operador FROM ponto.tb_convenio_operador_procedimento cop
                WHERE cop.ativo = 't' AND cop.procedimento_convenio_id = $parametro
                AND cop.empresa_id = $empresa_id
            )");
            $this->db->orderby('a.data');
            $this->db->groupby('a.data');
            //        $this->db->limit(250);
            $return = $this->db->get()->result();
            return $return;
        } else {
            return false;
        }
    }

    function listarhorariosdisponiveisorcamentodata($parametro, $empresa_id, $data) {
        $horario = date("Y-m-d");
        // O "false" no parametro so SELECT serve para dizer ao CodeIgniter não pôr aspas.
        $this->db->select("a.inicio,a.agenda_exames_id", false);
        $this->db->from('tb_agenda_exames a');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.bloqueado', 'false');
        $this->db->where('a.data', date("Y-m-d", strtotime(str_replace('/', '-', $data))));
        $this->db->where('a.empresa_id', $empresa_id);
        $this->db->where("a.medico_agenda IN (
                SELECT cop.operador FROM ponto.tb_convenio_operador_procedimento cop
                WHERE cop.ativo = 't' AND cop.procedimento_convenio_id = $parametro
                AND cop.empresa_id = $empresa_id
            )");
        $this->db->orderby('a.inicio');
//        $this->db->groupby('a.data');
        //        $this->db->limit(250);
        $return = $this->db->get()->result();
        return $return;
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
                            pt.nome as procedimento, 
                            pt.codigo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pt.agrupador", 'f');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentoconveniomedicocadastrosala($parametro, $teste, $sala) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento, 
                            pt.codigo');
        $this->db->from('tb_procedimento_convenio pc');
//        $this->db->join('tb_convenio_operador_procedimento cop', 'pc.procedimento_convenio_id = cop.procedimento_convenio_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pt.grupo IN (SELECT grupo FROM ponto.tb_exame_sala_grupo WHERE ativo = 't' AND exame_sala_id = {$sala})");
        $this->db->where('pc.convenio_id', $parametro);
//        $this->db->where("cop.ativo", 't');
        $procedimento_excecao = $this->session->userdata('procedimento_excecao');
        $empresa_id = $this->session->userdata('empresa_id');
        if ($procedimento_excecao == "t") {
            $this->db->where("pc.procedimento_convenio_id NOT IN (
                                SELECT cop.procedimento_convenio_id FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE pc2.convenio_id = {$parametro}
                                AND cop.operador = {$teste}
                                AND cop.empresa_id = {$empresa_id}
                                AND cop.ativo = 't'
                            )");
        } else {
            $this->db->where("pc.procedimento_convenio_id IN (
                                SELECT cop.procedimento_convenio_id FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE pc2.convenio_id = '{$parametro}'
                                AND cop.operador = {$teste}
                                AND cop.empresa_id = {$empresa_id}
                                AND cop.ativo = 't'
                            )");
        }

//        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosconveniomedicocadastro($parametro, $teste) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento, 
                            pt.codigo');
        $this->db->from('tb_procedimento_convenio pc');
//        $this->db->join('tb_convenio_operador_procedimento cop', 'pc.procedimento_convenio_id = cop.procedimento_convenio_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
//        $this->db->where("pc.agrupador", 'f');
        $this->db->where('pc.convenio_id', $parametro);
//        $this->db->where("cop.ativo", 't');
        $procedimento_excecao = $this->session->userdata('procedimento_excecao');
        if ($procedimento_excecao == "t") {
            $this->db->where("pc.procedimento_convenio_id NOT IN (
                                SELECT cop.procedimento_convenio_id FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE pc2.convenio_id = {$parametro}
                                AND cop.operador = {$teste}
                                AND cop.ativo = 't'
                            )");
        } else {
            $this->db->where("pc.procedimento_convenio_id IN (
                                SELECT cop.procedimento_convenio_id FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE pc2.convenio_id = '{$parametro}'
                                AND cop.operador = {$teste}
                                AND cop.ativo = 't'
                            )");
        }

        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosconveniomedico($parametro, $teste, $empresa_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento, 
                            pt.codigo');
        $this->db->from('tb_procedimento_convenio pc');
//        $this->db->join('tb_convenio_operador_procedimento cop', 'pc.procedimento_convenio_id = cop.procedimento_convenio_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pc.agrupador", 'f');
        $this->db->where('pc.convenio_id', $parametro);
//        $this->db->where("cop.ativo", 't');
//        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_excecao = $this->session->userdata('procedimento_excecao');
        if ($procedimento_excecao == "t") {
            $this->db->where("pc.procedimento_convenio_id NOT IN (
                                SELECT cop.procedimento_convenio_id FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE pc2.convenio_id = {$parametro}
                                AND cop.operador = {$teste}
                                AND cop.empresa_id = {$empresa_id}
                                AND cop.ativo = 't'
                            )");
        } else {
            $this->db->where("pc.procedimento_convenio_id IN (
                                SELECT cop.procedimento_convenio_id FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE pc2.convenio_id = '{$parametro}'
                                AND cop.operador = {$teste}
                                AND cop.empresa_id = {$empresa_id}
                                AND cop.ativo = 't'
                            )");
        }

        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
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

    function listarautocompleteprocedimentosorcamento($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
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
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosatendimento($parametro, $grupo = null) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        if ($grupo != '') {
            $this->db->where("pt.grupo", $grupo);
        }
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosatendimentonovo($parametro, $grupo = null) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        if ($grupo != '') {
            $this->db->where("pt.grupo", $grupo);
        }
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosfidelidadeweb($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
        $this->db->where("ag.tipo !=", 'MEDICAMENTO');
        $this->db->where("ag.tipo !=", 'MATERIAL');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
//        $empresa_id = $this->session->userdata('empresa_id');
//        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
//        if ($procedimento_multiempresa == 't') {
//            $this->db->where('pc.empresa_id', $empresa_id);
//        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosfaturar($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentoconveniointernacao($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
//        $this->db->where("ag.tipo !=", 'EXAME');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
//        $empresa_id = $this->session->userdata('empresa_id');
//        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
//        if ($procedimento_multiempresa == 't') {
//            $this->db->where('pc.empresa_id', $empresa_id);
//        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosfaturarmatmed($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("(ag.tipo = 'MATERIAL' OR ag.tipo = 'MEDICAMENTO')");
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
//        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteconveniocarteira($parametro) {
        $this->db->select(' c.convenio_id,
                            c.dinheiro,
                            c.carteira_obrigatoria');
        $this->db->from('tb_convenio c');
        $this->db->where('c.convenio_id', $parametro);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosgrupoorcamento($parametro = null, $parametro2 = null) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');

        if ($parametro != null) {
            $this->db->where('pc.convenio_id', $parametro);
        }
        if ($parametro2 != null) {
            $this->db->where('pt.grupo', $parametro2);
        }
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }

        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosgrupomedico($convenio_id = null, $grupo = null, $medico_id = null) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $procedimento_excecao = $this->session->userdata('procedimento_excecao');
        if ($procedimento_excecao == "t") {
            $this->db->where("pc.procedimento_convenio_id NOT IN (
                                SELECT cop.procedimento_convenio_id FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE pc2.convenio_id = {$convenio_id}
                                AND cop.operador = {$medico_id}
                                AND cop.empresa_id = {$empresa_id}
                                AND cop.ativo = 't'
                            )");
        } else {
            $this->db->where("pc.procedimento_convenio_id IN (
                                SELECT cop.procedimento_convenio_id FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE pc2.convenio_id = '{$convenio_id}'
                                AND cop.operador = {$medico_id}
                                AND cop.empresa_id = {$empresa_id}
                                AND cop.ativo = 't'
                            )");
        }
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');

        if ($convenio_id != null) {
            $this->db->where('pc.convenio_id', $convenio_id);
        }
        if ($grupo != null) {
            $this->db->where('pt.grupo', $grupo);
        }
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }

        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicoporprocedimento($procedimento_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' o.nome,
                            o.operador_id');
        $this->db->from('tb_operador o');
        $this->db->where('o.consulta', 't');
        $this->db->where('o.ativo', 't');
        $procedimento_excecao = $this->session->userdata('procedimento_excecao');
        if ($procedimento_excecao == "t") {
            $this->db->where("o.operador_id NOT IN (
                                SELECT cop.operador FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE cop.procedimento_convenio_id = {$procedimento_id}
                                AND cop.empresa_id = {$empresa_id}
                                AND cop.ativo = 't'
                            )");
        } else {
            $this->db->where("o.operador_id IN (
                                SELECT cop.operador FROM ponto.tb_convenio_operador_procedimento cop
                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
                                INNER JOIN ponto.tb_convenio c2 ON c2.convenio_id = pc2.convenio_id
                                INNER JOIN ponto.tb_procedimento_tuss pt2 ON pt2.procedimento_tuss_id = pc2.procedimento_tuss_id
                                WHERE cop.procedimento_convenio_id = {$procedimento_id}
                                AND cop.empresa_id = {$empresa_id}
                                AND cop.ativo = 't'
                            )");
        }


        $this->db->orderby("o.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletecadastroexcecaoprocedimentosgrupo($parametro = null, $parametro2 = null) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento,
                            pc.empresa_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');

        if ($parametro != null) {
            $this->db->where('pc.convenio_id', $parametro);
        }
        if ($parametro2 != null) {
            $this->db->where('pt.grupo', $parametro2);
        }
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }

        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletegruposala($sala_id = null) {
        $this->db->select('DISTINCT(ag.nome)');
        $this->db->from('tb_exame_sala_grupo esg');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = esg.grupo');
        $this->db->where("esg.ativo", 't');
        $this->db->where('exame_sala_id', $sala_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletesalaporgrupo($grupo = null) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('es.exame_sala_id, es.nome ');
        $this->db->from('tb_exame_sala_grupo esg');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = esg.exame_sala_id');
        $this->db->where("esg.ativo", 't');
        $this->db->where('es.excluido', 'f');
        $this->db->where('esg.grupo', $grupo);
        $this->db->where('es.empresa_id', $empresa_id);
        $this->db->orderby("es.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentoagrupadorgrupo($grupo = null) {

        $this->db->select('procedimento_tuss_id,
                            nome,
                            codigo');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->orderby('nome');
        $this->db->where("ativo", 't');
        $this->db->where("agrupador", 't');
        if ($grupo != '') {
            $this->db->where("pt.grupo", $grupo);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosgrupo($parametro = null, $parametro2 = null) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento,
                            pc.empresa_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pt.agrupador", 'f');

        if ($parametro != null) {
            $this->db->where('pc.convenio_id', $parametro);
        }
        if ($parametro2 != null) {
            $this->db->where('pt.grupo', $parametro2);
        }
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }

        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletegrupoweb($parametro = null) {
        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'CONSULTA');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
//        $this->db->where("ag.tipo !=", 'CIRURGICO');
//        $this->db->where("pc.ativo", 't');
        if ($parametro != null) {
            $this->db->where('pc.procedimento_convenio_id', $parametro);
        }


        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicoconveniogeral($parametro) {

        $this->db->select('c.convenio_id,
                            c.nome,');
        $this->db->from('tb_convenio c');

        $procedimento_excecao = $this->session->userdata('procedimento_excecao');
        $empresa_id = $this->session->userdata('empresa_id');

        if ($procedimento_excecao == "t") {
            $this->db->where("c.convenio_id NOT IN (
                                SELECT cop.convenio_id FROM ponto.tb_ambulatorio_convenio_operador cop
                                WHERE cop.ativo = 't'
                                AND cop.operador_id = {$parametro}
                                AND cop.empresa_id = {$empresa_id}
                            )");
        } else {
            $this->db->where("c.convenio_id IN (
                                SELECT cop.convenio_id FROM ponto.tb_ambulatorio_convenio_operador cop
                                WHERE cop.ativo = 't'
                                AND cop.operador_id = {$parametro}
                                AND cop.empresa_id = {$empresa_id}
                            )");
        }

        $this->db->where('c.ativo', 't');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicoconvenio($parametro) {

        $this->db->select('c.convenio_id,
                            c.nome,');
        $this->db->from('tb_convenio c');
//        $procedimento_excecao = $this->session->userdata('procedimento_excecao');
//        if ($procedimento_excecao == "t") {
//            $this->db->where("c.convenio_id NOT IN (
//                                SELECT pc2.convenio_id FROM ponto.tb_convenio_operador_procedimento cop
//                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
//                                WHERE cop.ativo = 't'
//                                AND cop.operador = {$parametro}
//                            )");
//        }
//        else {
//            $this->db->where("c.convenio_id IN (
//                                SELECT pc2.convenio_id FROM ponto.tb_convenio_operador_procedimento cop
//                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
//                                WHERE cop.ativo = 't'
//                                AND cop.operador = {$parametro}
//                            )");
//        }

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
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosmultiempresa($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("ag.tipo !=", 'EXAME');
//        $this->db->where("ag.tipo !=", 'ESPECIALIDADE');
//        $this->db->where("ag.tipo NOT IN ('MEDICAMENTO', 'MATERIAL')");
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
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
        $this->db->where("ag.tipo NOT IN ('MEDICAMENTO', 'MATERIAL')");
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
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
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("ag.tipo !=", 'EXAME');
        $this->db->where("ag.tipo !=", 'CONSULTA');
        $this->db->where("ag.tipo NOT IN ('MEDICAMENTO', 'MATERIAL')");
        $this->db->where("ag.tipo !=", 'CIRURGICO');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pt.agrupador", 'f');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicoespecialidade($parametro) {
        $this->db->select(' o.nome,
                            o.operador_id,
                            o.conselho,
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

    function listarautocompletemedicotipoagenda($parametro = "") {
        $this->db->select('o.nome,
                           o.operador_id');
        $this->db->from('tb_operador o');
        $this->db->where('o.ativo', 't');
        $this->db->where('o.medico', 't');
        if ($parametro != "") {
            $this->db->where("o.operador_id IN (SELECT medico_agenda FROM ponto.tb_agenda_exames WHERE tipo_consulta_id = {$parametro})");
        }

//        $this->db->groupby("e.empresa_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletegrupoempresa($parametro = null) {
        $this->db->select('distinct(e.empresa_id), e.nome');
        $this->db->from('tb_exame_sala es');
        $this->db->join('tb_empresa e', 'e.empresa_id = es.empresa_id');
        $this->db->join('tb_exame_sala_grupo esg', 'esg.exame_sala_id = es.exame_sala_id');
        if ($parametro != '') {
            $this->db->where('esg.grupo', $parametro);
        }

        $this->db->groupby("e.empresa_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteagendaempresasala($empresa_id) {

        $this->db->select('es.exame_sala_id, es.nome');
        $this->db->from('tb_exame_sala es');
        $this->db->where('es.excluido', 'f');
        $this->db->where('es.empresa_id', $empresa_id);
        $this->db->orderby('es.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletegrupoempresasala($parametro = null, $empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }
        $this->db->select('DISTINCT(es.exame_sala_id), es.nome');
        $this->db->from('tb_exame_sala es');
        $this->db->join('tb_exame_sala_grupo esg', 'esg.exame_sala_id = es.exame_sala_id');
        if ($parametro != '') {
            $this->db->where('esg.grupo', $parametro);
        }
        $this->db->where('es.excluido', 'f');
        $this->db->where('esg.ativo', 't');
        $this->db->where('es.empresa_id', $empresa_id);
        $this->db->orderby('es.exame_sala_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletegrupoempresasalatodos($parametro = null, $empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }
        $this->db->select('DISTINCT(es.exame_sala_id), es.nome');
        $this->db->from('tb_exame_sala es');
        $this->db->join('tb_exame_sala_grupo esg', 'esg.exame_sala_id = es.exame_sala_id');
        if ($parametro != '') {
            $this->db->where('esg.grupo', $parametro);
        }
        $this->db->where('es.excluido', 'f');
        $this->db->where('esg.ativo', 't');
        $this->db->where('es.empresa_id', $empresa_id);
        $this->db->orderby('es.exame_sala_id');

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
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosvalor($parametro = null) {
        $this->db->select('pc.valortotal, pt.qtde, pt.descricao_procedimento, pt.home_care, pt.grupo, ag.tipo, pc.procedimento_convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
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

    function buscaValorAjustePagamentoProcedimento($procedimento, $formaPagamento) {
        $this->db->select('ajuste');
        $this->db->from('tb_procedimento_convenio_forma_pagamento cp');
        $this->db->where('cp.procedimento_convenio_id', $procedimento);
        $this->db->where('cp.forma_pagamento_id', $formaPagamento);
        $this->db->where('cp.ativo', 't');
        $this->db->where("cp.ajuste != 0");
        $this->db->orderby("cp.ajuste DESC");
        $return = $this->db->get()->result();
        return $return;
    }

    function buscaValorAjustePagamentoFaturar($procedimento, $formaPagamento) {
        $this->db->select('ajuste');
        $this->db->from('tb_procedimento_convenio_forma_pagamento cp');
        $this->db->where('cp.procedimento_convenio_id', $procedimento);
        $this->db->where('cp.forma_pagamento_id', $formaPagamento);
        $this->db->where('cp.ativo', 't');
        $this->db->where("cp.ajuste != 0");
        $this->db->orderby("cp.ajuste DESC");
        $return = $this->db->get()->result();
        return $return;
    }

    function verificaAjustePagamentoProcedimento($procedimento) {
        $this->db->select('ajuste');
        $this->db->from('tb_procedimento_convenio_forma_pagamento cp');
        $this->db->where('cp.procedimento_convenio_id', $procedimento);
        $this->db->where('cp.ativo', 't');
        $this->db->where("cp.ajuste IS NOT NULL");
        $this->db->where("cp.ajuste != 0");
        $return = $this->db->get()->result();
        return $return;
    }

    function listarautocompleteprocedimentoconvenioforma($parametro = null) {
        $this->db->select('fp.nome,
                           fp.forma_pagamento_id');
        $this->db->from('tb_procedimento_convenio_forma_pagamento cp');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = cp.forma_pagamento_id', 'left');
        $this->db->where('cp.procedimento_convenio_id', $parametro);
        $this->db->where('fp.forma_pagamento_id !=', 1000);
        $this->db->where('cp.ativo', 't');
        $this->db->where('fp.ativo', 't');
        $return = $this->db->get();
        $result = $return->result();

        if (empty($result)) {
            $this->db->select('fp.nome,
                           fp.forma_pagamento_id');
            $this->db->from('tb_forma_pagamento fp');
            $this->db->where('fp.forma_pagamento_id !=', 1000);
            $return2 = $this->db->get();
            $result2 = $return2->result();
            return $result2;
        } else {
            return $result;
        }
    }

    function listarautocompleteprocedimentosforma($parametro = null) {
        $this->db->select('fp.nome,
                           fp.forma_pagamento_id');
        $this->db->from('tb_procedimento_convenio_pagamento cp');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = cp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
//        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = cp.forma_pagamento_id', 'left');
        $this->db->where('cp.procedimento_convenio_id', $parametro);
        $this->db->where('fp.forma_pagamento_id !=', 1000);
        $this->db->where('cp.ativo', 't');
        $this->db->where('gf.ativo', 't');
        $return = $this->db->get();
        $result = $return->result();

        if (empty($result)) {
            $this->db->select('fp.nome,
                           fp.forma_pagamento_id');
            $this->db->from('tb_forma_pagamento fp');
            $this->db->where('fp.forma_pagamento_id !=', 1000);
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

    function listarmodelosreceitaautomatico() {
        $this->db->select('aml.ambulatorio_modelo_receita_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_receita aml');
        $this->db->where('aml.ativo', 'true');
        $this->db->where('aml.carregar_automaticamente', 'true');
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

    function excluirexametempmultifuncaomedico($agenda_exames_id) {

        $this->db->set('paciente_id', null);
        $this->db->set('procedimento_tuss_id', null);
        $this->db->set('convenio_id', null);
        $this->db->set('guia_id', null);
        $this->db->set('agrupador_fisioterapia', null);
        $this->db->set('numero_sessao', null);
        $this->db->set('qtde_sessao', null);
        $this->db->set('realizada', 'f');
        $this->db->set('cancelada', 'f');
        $this->db->set('confirmado', 'f');
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

    function excluirexametemp($agenda_exames_id) {

        $this->db->set('paciente_id', null);
        $this->db->set('procedimento_tuss_id', null);
        $this->db->set('convenio_id', null);
        $this->db->set('guia_id', null);
        $this->db->set('agrupador_fisioterapia', null);
        $this->db->set('numero_sessao', null);
        $this->db->set('qtde_sessao', null);
        $this->db->set('realizada', 'f');
        $this->db->set('cancelada', 'f');
        $this->db->set('confirmado', 'f');
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

    function excluirfisioterapiatemp($agenda_exames_id) {

        $this->db->set('paciente_id', null);
        $this->db->set('procedimento_tuss_id', null);
        $this->db->set('convenio_id', null);
        $this->db->set('guia_id', null);
        $this->db->set('agrupador_fisioterapia', null);
        $this->db->set('numero_sessao', null);
        $this->db->set('qtde_sessao', null);
        $this->db->set('realizada', 'f');
        $this->db->set('cancelada', 'f');
        $this->db->set('confirmado', 'f');
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

    function excluirexametempencaixeodontologia($agenda_exames_id) {


        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->delete('tb_agenda_exames');
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
