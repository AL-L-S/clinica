<?php

class exame_model extends Model {

    var $_agenda_exames_id = null;
    var $_horarioagenda_id = null;
    var $_paciente_id = null;
    var $_procedimento_tuss_id = null;
    var $_inicio = null;
    var $_fim = null;
    var $_confirmado = null;
    var $_ativo = null;
    var $_nome = null;
    var $_data_inicio = null;
    var $_data_fim = null;

    function exame_model($agenda_exames_id = null) {
        parent::Model();
        if (isset($agenda_exames_id)) {
            $this->instanciar($agenda_exames_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('agenda_exames_nome_id,
                            nome');
        $this->db->from('tb_agenda_exames_nome');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarautocompletepaciente($parametro = null) {
        $this->db->select('paciente_id,
                            nome,
                            telefone,
                            nascimento,
                            cpf');
        $this->db->from('tb_paciente');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluiragenda($agenda_id) {

        $this->db->set('ativo', 'f');
        $this->db->where('agenda_exames_nome_id', $agenda_id);
        $this->db->update('tb_agenda_exames_nome');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarlote($b) {
        $this->db->set('lote', $b);
        $this->db->update('tb_lote');
        $erro = $this->db->_error_message();
    }

    function listarlote() {

        $this->db->select('lote');
        $this->db->from('tb_lote');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarpacientedetalhes() {
        try {
            /* inicia o mapeamento no banco */
            if ($_POST['peso'] != "") {
                $this->db->set('peso', str_replace(",", ".", $_POST['peso']));
            }
            if ($_POST['altura'] != "") {
                $this->db->set('altura', $_POST['altura']);
            }
            if ($_POST['pasistolica'] != "") {
                $this->db->set('pasistolica', $_POST['pasistolica']);
            }
            if ($_POST['padiastolica'] != "") {
                $this->db->set('padiastolica', $_POST['padiastolica']);
            }
            $this->db->where('ambulatorio_guia_id', $_POST['guia_id']);
            $this->db->update('tb_ambulatorio_guia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarautocompletepacientenascimento($parametro = null) {
        $this->db->select('paciente_id,
                            nome,
                            telefone,
                            nascimento,
                            cpf');
        $this->db->from('tb_paciente');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nascimento', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarobservacoes($agenda_exame_id) {
        $this->db->select('observacoes');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarmedico() {
        $this->db->select('operador_id,
            nome');
        $this->db->from('tb_operador');
        $this->db->where('consulta', 'true');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalas() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalastotal() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupo($agenda_exames_id) {
        $this->db->select('pt.grupo');
        $this->db->from('tb_agenda_exames e');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->where('e.agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarmedicoagenda($agenda_exames_id) {
        $this->db->select('medico_agenda');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalaagenda($agenda_exames_id) {
        $this->db->select('agenda_exames_nome_id, tipo');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listartodassalas() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcaixaempresa() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('caixa');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarcnpj() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('cnpjxml, razao_socialxml, cnpj, registroans, cpfxml, cnes');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexames($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('e.exames_id,
                            e.agenda_exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            e.guia_id,
                            e.procedimento_tuss_id,
                            e.data_cadastro,
                            es.nome as sala,
                            o.nome as tecnico,
                            pt.grupo,
                            pt.nome as procedimento,
                            ag.ambulatorio_laudo_id');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_ambulatorio_laudo ag', 'e.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = e.sala_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->where('e.situacao', 'EXECUTANDO');
        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('e.cancelada', 'false');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('e.sala_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function gerarelatoriotempoesperaexame() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('e.exames_id,
                            e.agenda_exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            e.guia_id,
                            e.procedimento_tuss_id,
                            e.data_cadastro,
                            e.data_atualizacao,
                            e.operador_atualizacao,
                            es.nome as sala,
                            o.nome as tecnico,
                            pt.grupo,
                            pt.nome as procedimento');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = e.sala_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('e.cancelada', 'false');
        if ($_POST['txtdata_inicio'] != '' && $_POST['txtdata_fim'] != '') {
            $this->db->where("e.data_cadastro >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])) . ' 00:00:00');
            $this->db->where("e.data_cadastro <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])) . ' 23:59:59');
        }
        if ($_POST['convenio'] != '') {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatoriotemposalaespera() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ordenador,
                            ae.data_autorizacao,
                            ae.data_realizacao,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.faturado,
                            o.nome as tecnico,
                            c.dinheiro,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->orderby('ae.ordenador');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.data_autorizacao');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        if ($_POST['txtdata_inicio'] != '' && $_POST['txtdata_fim'] != '') {
            $this->db->where("ae.data_autorizacao >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])) . ' 00:00:00');
            $this->db->where("ae.data_autorizacao <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])) . ' 23:59:59');
        }
        if ($_POST['convenio'] != '') {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamespendentes($args = array()) {
        $this->db->select('e.exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            e.data_cadastro,
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
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('e.sala_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listararquivo($agenda_exames_id) {
        $this->db->select(' ae.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.sexo,
                            ae.agenda_exames_id,
                            ae.inicio,
                            pt.nome as procedimento,
                            pc.procedimento_tuss_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listardicom($laudo_id) {
        $this->db->select('e.exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.sexo,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            c.nome as convenio,
                            e.tecnico_realizador,
                            o.nome as tecnico,
                            e.data_cadastro,
                            pt.nome as procedimento,
                            pt.codigo,
                            ae.guia_id,
                            pt.grupo,
                            pc.procedimento_tuss_id');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->where('l.ambulatorio_laudo_id', $laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function contador($parametro, $agenda_exames_nome_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where('data', $parametro);
        $this->db->where('nome_id', $agenda_exames_nome_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarexameagenda($parametro, $agenda_exames_nome_id) {
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.paciente_id,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = ae.procedimento_tuss_id', 'left');
        $this->db->orderby('inicio');
        $this->db->where('ae.data', $parametro);
        $this->db->where('ae.nome_id', $agenda_exames_nome_id);
        $return = $this->db->get();

        return $return->result();
    }

    function listarexameagendaconfirmada($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ordenador,
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
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['tipo']) && strlen($args['tipo']) > 0) {
            $this->db->where('ae.tipo', $args['tipo']);
        }
        return $this->db;
    }

    function listarexameagendaconfirmada2($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ordenador,
                            ae.data_autorizacao,
                            ae.ativo,
                            ae.numero_sessao,
                            ae.qtde_sessao,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            an.nome as sala,
                            ae.faturado,
                            c.dinheiro,
                            p.nome as paciente,
                            p.nascimento,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->orderby('ae.ordenador');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.data_autorizacao');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['tipo']) && strlen($args['tipo']) > 0) {
            $this->db->where('ae.tipo', $args['tipo']);
        }
        return $this->db;
    }

    function listarexamecaixaespera($grupo_pagamento_id, $args = array()) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('g.ambulatorio_guia_id,
                            sum(ae.valor_total) as valortotal,
                            sum(ae.valor1) as valorfaturado,
                            p.nome as paciente,
                            g.data_criacao,
                            ae.paciente_id');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        if ($grupo_pagamento_id != 0) {
            $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
            $this->db->where("cp.grupo_pagamento_id", $grupo_pagamento_id);
        }
        $this->db->where("c.dinheiro", 't');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.faturado', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }

        return $this->db;
    }

    function listarexamesguia($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            ae.paciente_id,
                            ae.faturado,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            c.nome as convenio,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->orderby('ae.valor_total desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamemultifuncao($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
//        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'EXAME');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', $args['nascimento']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        return $this->db;
    }

    function listarexamemultifuncao2($args = array()) {
        $data = date("Y-m-d");
        $contador = count($args);

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
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
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            e.situacao as situacaoexame,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'EXAME');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', $args['nascimento']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $args['medico']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        return $this->db;
    }

    function buscarmedicotroca($agenda_exames_id) {
        $this->db->select('o.nome as medicoagenda');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);

        $return = $this->db->get();
        return $return->result();
    }

    function buscarmedicotrocaconsulta($agenda_exames_id) {
        $this->db->select('o.nome as medicoagenda');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);

        $return = $this->db->get();
        return $return->result();
    }

    function trocarmedico() {

        try {
            if ($_POST['tipo'] == 1) {
                $this->db->set('medico_agenda', $_POST['medico2']);
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_agenda_exames');
            } elseif ($_POST['tipo'] == 2) {
                $this->db->set('medico_consulta_id', $_POST['medico2']);
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_agenda_exames');
            }
            $erro = $this->db->_error_message();

            $this->db->select('exames_id');
            $this->db->from('tb_exames');
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $return = $this->db->get();
            $result = $return->result();

            if (isset($result[0]->exames_id)) {
                $this->db->set('medico_parecer1', $_POST['medico2']);
                $this->db->where('exame_id', $result[0]->exames_id);
                $this->db->update('tb_ambulatorio_laudo');
            }
            if ($erro != '') {
                return false;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    function listarexamemultifuncaogeral($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
//        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', $args['nascimento']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        return $this->db;
    }

    function listarexamemultifuncaogeral2($args = array()) {
        $data = date("Y-m-d");
        $contador = count($args);

        $empresa_id = $this->session->userdata('empresa_id');
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
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        $this->db->where('ae.empresa_id', $empresa_id);
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', $args['nascimento']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        return $this->db;
    }

    function listarestatisticapaciente($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'EXAME');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarestatisticasempaciente($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'LIVRE');
        $this->db->where('ae.tipo', 'EXAME');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarexamemultifuncaoconsulta($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            p.celular,
                            p.telefone,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
//        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'CONSULTA');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        return $this->db;
    }

    function listarexamemultifuncaoconsulta2($args = array()) {
        $data = date("Y-m-d");
        $contador = count($args);
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            e.situacao as situacaoexame,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
//        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'CONSULTA');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        return $this->db;
    }

    function listaragendaconsulta($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where('ae.tipo', 'CONSULTA');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])));
        $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaordem($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.valor_total,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            f.nome as forma_pagamento,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.perc_medico,
                            pt.percentual,
                            pc.valortotal,
                            al.medico_parecer1,
                            pt.procedimento_tuss_id as procedimento_tuss_id_novo, 
                            c.dinheiro,
                            al.situacao as situacaolaudo,
                            ae.ordenador ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('pt.nome');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.ordenador', null);
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])));
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['hora_inicio'] != "" && $_POST['hora_fim'] != "") {
            $this->db->where('ae.inicio >=', $_POST['hora_inicio']);
            $this->db->where('ae.inicio <=', $_POST['hora_fim']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
        if ($_POST['salas'] != "0") {
            $this->db->where('an.exame_sala_id', $_POST['salas']);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaordemprioridade($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.valor_total,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            f.nome as forma_pagamento,
                            pt.nome as procedimento,
                            pt.percentual,
                            pt.procedimento_tuss_id as procedimento_tuss_id_novo,
                            pt.perc_medico,
                            pc.valortotal,
                            c.dinheiro,
                            al.situacao as situacaolaudo,
                            al.medico_parecer1,
                            ae.ordenador ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.ordenador');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.ordenador is not null');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])));
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['hora_inicio'] != "" && $_POST['hora_fim'] != "") {
            $this->db->where('ae.inicio >=', $_POST['hora_inicio']);
            $this->db->where('ae.inicio <=', $_POST['hora_fim']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
        if ($_POST['salas'] != "0") {
            $this->db->where('an.exame_sala_id', $_POST['salas']);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaexame($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where('ae.tipo', 'EXAME');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }
        if ($_POST['salas'] != "0") {
            $this->db->where('ae.agenda_exames_nome_id', $_POST['salas']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $return = $this->db->get();
        return $return->result();
    }

    function listarexamemultifuncaofisioterapia($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            p.celular,
                            p.telefone,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'FISIOTERAPIA');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        return $this->db;
    }

    function listarexamemultifuncaofisioterapia2($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where('ae.data >=', $data);
        $this->db->where('numero_sessao', null);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'FISIOTERAPIA');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        return $this->db;
    }

    function autorizarsessaofisioterapia($paciente_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.numero_sessao,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.numero_sessao');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.paciente_id', $paciente_id);
        $this->db->where('ae.tipo', 'FISIOTERAPIA');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.numero_sessao >=', '1');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.confirmado', 'false');
        $this->db->where('ae.cancelada', 'false');
        $return = $this->db->get();
        return $return->result();
    }

    function autorizarsessaopsicologia($paciente_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.numero_sessao,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.numero_sessao');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.paciente_id', $paciente_id);
        $this->db->where('ae.tipo', 'PSICOLOGIA');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.numero_sessao >=', '1');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.confirmado', 'false');
        $this->db->where('ae.cancelada', 'false');
        $return = $this->db->get();
        return $return->result();
    }

    function listarmultifuncaomedico($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'EXAME');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
//        $this->db->where('pt.grupo !=', 'LABORATORIAL');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
            $this->db->where('p.paciente_id', $args['prontuario']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        } if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $args['medico']);
        }
        return $this->db;
    }

    function listarmultifuncao2medico($args = array()) {


        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.data_autorizacao,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            e.situacao as situacaoexame,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            pt.grupo,
                            ae.bloqueado,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'EXAME');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
//        $this->db->where('pt.grupo !=', 'LABORATORIAL');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_agenda', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
                $this->db->where('p.paciente_id', $args['prontuario']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_agenda', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaomedicolaboratorial($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('pt.grupo', 'LABORATORIAL');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
//        $this->db->where('pt.grupo !=', 'LABORATORIAL');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        } if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $args['medico']);
        }
        return $this->db;
    }

    function listarmultifuncao2medicolaboratorial($args = array()) {


        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            pt.grupo,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('pt.grupo', 'LABORATORIAL');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
//        $this->db->where('pt.grupo !=', 'LABORATORIAL');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaoconsulta($args = array()) {
        $teste = empty($args);
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            o.nome as medicoconsulta,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'CONSULTA');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaogeral($args = array()) {
        $teste = empty($args);
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            o.nome as medicoconsulta,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_tuss t', 't.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tc', 'tc.tuss_classificacao_id = t.classificacao', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncao2consulta($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            e.exames_id,
                            e.sala_id,                            
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->orderby('al.situacao');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncao2geral($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            e.exames_id,
                            e.sala_id,
                            pt.grupo,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            pt.nome as procedimento,
                            tc.nome as classificacao,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_tuss t', 't.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tc', 'tc.tuss_classificacao_id = t.classificacao', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->orderby('al.situacao');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaofisioterapia($args = array()) {
        $teste = empty($args);
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            o.nome as medicoconsulta,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'FISIOTERAPIA');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncao2fisioterapia($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            ae.agenda_exames_nome_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'FISIOTERAPIA');
        $this->db->orderby('ae.realizada', 'desc');
        $this->db->orderby('al.situacao');
        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaopsicologia($args = array()) {
        $teste = empty($args);
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            o.nome as medicoconsulta,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'PSICOLOGIA');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncao2psicologia($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'PSICOLOGIA');
        $this->db->orderby('ae.realizada', 'desc');
        $this->db->orderby('al.situacao');
        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', $args['data']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarguiafaturamento() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('g.ambulatorio_guia_id,
                            ae.valor_total as valortotal,
                            ae.valor1 as valorfaturado,
                            p.nome as paciente,
                            ae.agenda_exames_id,
                            ae.faturado,
                            ae.numero_sessao,
                            g.data_criacao,
                            ae.autorizacao,
                            c.nome,
                            ae.financeiro,
                            pt.nome as procedimento,
                            pt.codigo,
                            o.nome as medico,
                            ae.paciente_id');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id= al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])));
        $this->db->where("c.dinheiro", 'f');
        $this->db->where("ae.confirmado", 't');
//        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->orderby('g.ambulatorio_guia_id');
        $this->db->orderby('g.data_criacao');
        $this->db->orderby('p.nome');
        $this->db->orderby('ae.numero_sessao');
        $this->db->orderby('ae.paciente_id');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargxmlfaturamento($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('g.ambulatorio_guia_id,
                            ae.valor_total,
                            ae.valor,
                            ae.autorizacao,
                            p.convenionumero,
                            p.nome as paciente,
                            op.nome as medicosolicitante,
                            op.conselho as conselhosolicitante,
                            o.nome as medico,
                            o.conselho,
                            o.cbo_ocupacao_id,
                            o.cpf,
                            ae.data_autorizacao,
                            ae.data_realizacao,
                            pt.codigo,
                            tu.descricao as procedimento,
                            ae.data,
                            pt.grupo,
                            c.nome as convenio,
                            tuc.nome as classificacao,
                            ae.quantidade,
                            c.registroans,
                            c.codigoidentificador,
                            e.data_cadastro,
                            e.data_atualizacao,
                            g.data_criacao,
                            g.guiaconvenio,
                            ae.paciente_id');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tuc', 'tuc.tuss_classificacao_id = tu.classificacao', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("c.dinheiro", 'f');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['datainicio']) && strlen($_POST['datainicio']) > 0) {
            $this->db->where('ae.data >=', $_POST['datainicio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['tipo'] != "0" && $_POST['tipo'] != "") {
            $this->db->where("tu.classificacao", $_POST['tipo']);
        }
        if ($_POST['tipo'] == "") {
            $this->db->where("tu.classificacao", "2");
            $this->db->where("tu.classificacao", "3");
        }
        if ($_POST['raca_cor'] != "0" && $_POST['raca_cor'] != "-1") {
            $this->db->where('p.raca_cor', $_POST['raca_cor']);
        }
        if ($_POST['raca_cor'] == "-1") {
            $this->db->where('p.raca_cor !=', '5');
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if (isset($_POST['datafim']) && strlen($_POST['datafim']) > 0) {
            $this->db->where('ae.data <=', $_POST['datafim']);
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientesxmlfaturamento($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.paciente_id, g.guiaconvenio, convenionumero, p.nome as paciente, ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tuc', 'tuc.tuss_classificacao_id = tu.classificacao', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("c.dinheiro", 'f');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['datainicio']) && strlen($_POST['datainicio']) > 0) {
            $this->db->where('ae.data >=', $_POST['datainicio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['tipo'] != "0" && $_POST['tipo'] != "") {
            $this->db->where("tu.classificacao", $_POST['tipo']);
        }
        if ($_POST['tipo'] == "") {
            $this->db->where("tu.classificacao", "2");
            $this->db->where("tu.classificacao", "3");
        }
        if ($_POST['raca_cor'] != "0" && $_POST['raca_cor'] != "-1") {
            $this->db->where('p.raca_cor', $_POST['raca_cor']);
        }
        if ($_POST['raca_cor'] == "-1") {
            $this->db->where('p.raca_cor !=', '5');
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if (isset($_POST['datafim']) && strlen($_POST['datafim']) > 0) {
            $this->db->where('ae.data <=', $_POST['datafim']);
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->groupby('ae.paciente_id, g.guiaconvenio, convenionumero, p.nome, ambulatorio_guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarxmlfaturamentoexames($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select("g.ambulatorio_guia_id,
                            sum(ae.valor_total) as valor_total,
                            ae.valor,
                            ae.autorizacao,
                            op.nome as medicosolicitante,
                            op.conselho as conselhosolicitante,
                            o.nome as medico,
                            o.conselho,
                            o.cbo_ocupacao_id,
                            o.cpf,
                            pt.codigo,
                            tu.descricao as procedimento,
                            sum(ae.quantidade) as quantidade,
                            g.guiaconvenio,
                            ae.paciente_id");
        $this->db->from("tb_ambulatorio_guia g");
        $this->db->join("tb_agenda_exames ae", "ae.guia_id = g.ambulatorio_guia_id", "left");
        $this->db->join("tb_paciente p", "p.paciente_id = ae.paciente_id", "left");
        $this->db->join("tb_procedimento_convenio pc", "pc.procedimento_convenio_id = ae.procedimento_tuss_id", "left");
        $this->db->join("tb_procedimento_tuss pt", "pt.procedimento_tuss_id = pc.procedimento_tuss_id", "left");
        $this->db->join("tb_tuss tu", "tu.tuss_id = pt.tuss_id", "left");
        $this->db->join("tb_tuss_classificacao tuc", "tuc.tuss_classificacao_id = tu.classificacao", "left");
        $this->db->join("tb_exame_sala an", "an.exame_sala_id = ae.agenda_exames_nome_id", "left");
        $this->db->join("tb_exames e", "e.agenda_exames_id= ae.agenda_exames_id", "left");
        $this->db->join("tb_ambulatorio_laudo al", "al.exame_id = e.exames_id", "left");
        $this->db->join("tb_operador o", "o.operador_id = al.medico_parecer1", "left");
        $this->db->join("tb_operador op", "op.operador_id = ae.medico_solicitante", "left");
        $this->db->join("tb_convenio c", "c.convenio_id = pc.convenio_id", "left");
        $this->db->where("c.dinheiro", 'f');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['datainicio']) && strlen($_POST['datainicio']) > 0) {
            $this->db->where('ae.data >=', $_POST['datainicio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['tipo'] != "0" && $_POST['tipo'] != "") {
            $this->db->where("tu.classificacao", $_POST['tipo']);
        }
        if ($_POST['tipo'] == "") {
            $this->db->where("tu.classificacao", "2");
            $this->db->where("tu.classificacao", "3");
        }
        if ($_POST['raca_cor'] != "0" && $_POST['raca_cor'] != "-1") {
            $this->db->where('p.raca_cor', $_POST['raca_cor']);
        }
        if ($_POST['raca_cor'] == "-1") {
            $this->db->where('p.raca_cor !=', '5');
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if (isset($_POST['datafim']) && strlen($_POST['datafim']) > 0) {
            $this->db->where('ae.data <=', $_POST['datafim']);
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->groupby("g.ambulatorio_guia_id,ae.valor, ae.autorizacao,
                            op.nome,
                            op.conselho,
                            o.nome,
                            o.conselho,
                            o.cbo_ocupacao_id,
                            o.cpf,
                            pt.codigo,
                            tu.descricao,
                            g.guiaconvenio,
                            ae.paciente_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarxmldataautorizacao($ambulatorio_guia_id) {
        $this->db->select('data_cadastro');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('ambulatorio_guia_id', $ambulatorio_guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($procedimento_tuss_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->update('tb_procedimento_tuss');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function autorizarsessao($agenda_exames_id) {

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('confirmado', 't');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('data', $data);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_autorizacao', $horario);
        $this->db->set('operador_autorizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
    }

    function gravarnome($nome) {
        try {
            $this->db->set('nome', $nome);
            $this->db->insert('tb_agenda_exames_nome');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_nome_id = $this->db->insert_id();
            return $agenda_exames_nome_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function contadorexames() {

        $this->db->select('agenda_exames_id');
        $this->db->from('tb_exames');
        $this->db->where('situacao !=', 'CANCELADO');
        $this->db->where("agenda_exames_id", $_POST['txtagenda_exames_id']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorexamestodos() {

        $this->db->select('pt.grupo');
        $this->db->from('tb_exames e');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->where('e.situacao !=', 'CANCELADO');
        $this->db->where("e.guia_id", $_POST['txtguia_id']);
        $this->db->where("pt.grupo", $_POST['txtgrupo']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarexamesguias($guia_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.faturado,
                            ae.agenda_exames_nome_id,
                            ae.ativo,
                            ae.situacao,
                            e.exames_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            ae.guia_id,
                            e.situacao as situacaoexame,
                            al.situacao as situacaolaudo,
                            ae.paciente_id,
                            c.dinheiro,
                            ae.recebido,
                            ae.data_recebido,
                            ae.entregue,
                            ae.data_entregue,
                            p.nome as paciente,
                            p.indicacao,
                            p.nascimento,
                            ae.entregue_telefone,
                            o.nome as operadorrecebido,
                            op.nome as operadorentregue,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id= pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_recebido', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_entregue', 'left');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.agenda_exames_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarguia($agenda_exames_id) {

        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            p.nome as paciente,
                            c.nome as convenio,
                            p.nascimento,
                            ae.data_cadastro as datacadastro,
                            ag.peso,
                            ag.altura,
                            ag.pasistolica,
                            ag.padiastolica,
                            o.usuario as medico,
                            op.usuario as operadorcadastro');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_cadastro', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaauditoria($agenda_exames_id) {

        $this->db->select('ae.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            ae.data_cadastro as datacadastro,
                            op.nome as operadorcadastro');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_cadastro', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendadoauditoria($agenda_exames_id) {

        $this->db->select('ae.paciente_id,
                            p.nome as paciente,
                            c.nome as convenio,
                            p.nascimento,
                            ae.data_cadastro as datacadastro,
                            o.usuario as medico,
                            ae.data_autorizacao,
                            ae.data_atualizacao,
                            op.nome as operadorcadastro,
                            ope.nome as operadoratualizacao,
                            opa.nome as operadorautorizacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_cadastro', 'left');
        $this->db->join('tb_operador opa', 'opa.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador ope', 'ope.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaratendimentos($guia_id) {

        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            p.nome as paciente,
                            c.nome as convenio,
                            p.nascimento,
                            ag.peso,
                            ag.altura,
                            ag.pasistolica,
                            ag.padiastolica,
                            o.usuario as medico');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarexame() {
        try {
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $exame_id = $_POST['txtagenda_exames_id'];

            if ($_POST['txttipo'] == 'EXAME') {

                $this->db->set('ativo', 'f');
                $this->db->where('exame_sala_id', $_POST['txtsalas']);
                $this->db->update('tb_exame_sala');

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $agenda_exames_id = $_POST['txtguia_id'];
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id = $this->db->insert_id();
                $guia_id = $_POST['txtguia_id'];

                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['txtmedico']);
                    $this->db->set('medico_agenda', $_POST['txtmedico']);
                }
                $this->db->set('realizada', 'true');
                $this->db->set('senha', md5($exame_id));
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->update('tb_agenda_exames');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->set('sala_id', $_POST['txtsalas']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->insert('tb_ambulatorio_chamada');
            }

            if ($_POST['txttipo'] == 'CONSULTA') {

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);

                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $agenda_exames_id = $_POST['txtguia_id'];
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id = $this->db->insert_id();
                $guia_id = $_POST['txtguia_id'];

                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['txtmedico']);
                    $this->db->set('medico_agenda', $_POST['txtmedico']);
                }
                $this->db->set('realizada', 'true');
                $this->db->set('senha', md5($exame_id));
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->update('tb_agenda_exames');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->set('sala_id', $_POST['txtsalas']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->insert('tb_ambulatorio_chamada');
            }

            if ($_POST['txttipo'] == 'FISIOTERAPIA') {

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);

                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $agenda_exames_id = $_POST['txtguia_id'];
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id = $this->db->insert_id();
                $guia_id = $_POST['txtguia_id'];

                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['txtmedico']);
                    $this->db->set('medico_agenda', $_POST['txtmedico']);
                }
                $this->db->set('realizada', 'true');
                $this->db->set('senha', md5($exame_id));
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->update('tb_agenda_exames');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->set('sala_id', $_POST['txtsalas']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->insert('tb_ambulatorio_chamada');
            }

            if ($_POST['txttipo'] == 'PSICOLOGIA') {

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);

                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $agenda_exames_id = $_POST['txtguia_id'];
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id = $this->db->insert_id();
                $guia_id = $_POST['txtguia_id'];

                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['txtmedico']);
                    $this->db->set('medico_agenda', $_POST['txtmedico']);
                }
                $this->db->set('realizada', 'true');
                $this->db->set('senha', md5($exame_id));
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->update('tb_agenda_exames');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->set('sala_id', $_POST['txtsalas']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->insert('tb_ambulatorio_chamada');
            }

            return $laudo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarexametodos() {
        try {

            $empresa_id = $this->session->userdata('empresa_id');
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->where('exame_sala_id', $_POST['txtsalas']);
            $this->db->update('tb_exame_sala');

            $this->db->select('e.procedimento_tuss_id,
                                e.agenda_exames_id');
            $this->db->from('tb_agenda_exames e');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
            $this->db->where('e.situacao !=', 'CANCELADO');
            $this->db->where("e.guia_id", $_POST['txtguia_id']);
            $this->db->where("pt.grupo", $_POST['txtgrupo']);
            $query = $this->db->get();
            $return = $query->result();
            $this->db->trans_start();
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->set('sala_id', $_POST['txtsalas']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->insert('tb_ambulatorio_chamada');

            foreach ($return as $value) {
                $procedimento = $value->procedimento_tuss_id;
                $agenda_exames_id = $value->agenda_exames_id;


                $this->db->set('realizada', 'true');
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $procedimento);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('agenda_exames_id', $agenda_exames_id);
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $procedimento);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id[] = $this->db->insert_id();
            }
            $guia_id = $_POST['txtguia_id'];
            $this->db->trans_complete();

            return $laudo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function telefonema($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('telefonema', 't');
            $this->db->set('data_telefonema', $horario);
            $this->db->set('operador_telefonema', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function observacao($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('observacoes', $_POST['txtobservacao']);
            $this->db->set('data_observacoes', $horario);
            $this->db->set('operador_observacoes', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelarespera() {
        try {
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
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->update('tb_agenda_exames');


            $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_atendimentos_cancelamento');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelartodosfisioterapia($agenda_exames_id) {
        try {
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
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelartodospsicologia($agenda_exames_id) {
        try {
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
            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function bloquear($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "OK");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 'f');
            $this->db->set('bloqueado', 't');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('data_bloqueio', $horario);
            $this->db->set('operador_bloqueio', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function desbloquear($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "OK");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 't');
            $this->db->set('bloqueado', 'f');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('data_desbloqueio', $horario);
            $this->db->set('operador_desbloqueio', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelarexame() {
        try {
            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $_POST['txtsala_id']);
            $this->db->update('tb_exame_sala');

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
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->update('tb_agenda_exames');

            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('exames_id', $_POST['txtexames_id']);
            $this->db->update('tb_exames');

            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('exame_id', $_POST['txtexames_id']);
            $this->db->update('tb_ambulatorio_laudo');

            $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_atendimentos_cancelamento');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function voltarexame($exame_id, $sala_id, $agenda_exames_id) {
        try {


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

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function finalizarexame($exames_id, $sala_id) {
        try {

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');

            $this->db->set('situacao', 'FINALIZADO');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function finalizarexametodos($sala_id, $guia_id, $grupo) {
        try {

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');


            $this->db->select('e.agenda_exames_id');
            $this->db->from('tb_agenda_exames e');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->where('e.situacao !=', 'CANCELADO');
            $this->db->where("e.guia_id", $guia_id);
            $this->db->where("pt.grupo", $grupo);
            $query = $this->db->get();
            $return = $query->result();

            foreach ($return as $value) {
//                $teste = $teste . "-" . $value->agenda_exames_id;
                $this->db->set('situacao', 'FINALIZADO');
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                $this->db->update('tb_exames');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    return 0;
            }
//            var_dump($teste);
//            die;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function atenderpacienteconsulta($exames_id) {
        try {

            $this->db->set('situacao', 'FINALIZADO');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function pendenteexame($exames_id, $sala_id) {
        try {

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');

            $this->db->set('situacao', 'PENDENTE');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_pendente', $horario);
            $this->db->set('operador_pendente', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpaciente($agenda_exames_id) {
        try {
            $OK = 'OK';
            $this->db->set('paciente_id', $_POST['txtpacienteid']);
            $this->db->set('procedimento_tuss_id', $_POST['txprocedimento']);
            $this->db->set('situacao', $OK);
            $this->db->set('ativo', 'false');
            if (isset($_POST['txtConfirmado'])) {
                $this->db->set('confirmado', 't');
            }
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'EXAME');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('horarioagenda_id', $agenda_id);
            $this->db->set('inicio', $horaconsulta);
            $this->db->set('fim', $horaverifica);
            $this->db->set('nome', $nome);
            $this->db->set('data_inicio', $datainicial);
            $this->db->set('data_fim', $datafinal);
            $this->db->set('data', $index);
            $this->db->set('nome_id', $id);
            if ($medico_id != '') {
                $this->db->set('medico_consulta_id', $medico_id);
                $this->db->set('medico_agenda', $medico_id);
            }
            $this->db->set('tipo_agenda', 'normal');
            $this->db->set('agenda_exames_nome_id', $sala_id);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'EXAME');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsulta($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('horarioagenda_id', $agenda_id);
            $this->db->set('inicio', $horaconsulta);
            $this->db->set('fim', $horaverifica);
            $this->db->set('nome', $nome);
            $this->db->set('data_inicio', $datainicial);
            $this->db->set('data_fim', $datafinal);
            $this->db->set('data', $index);
            $this->db->set('tipo_consulta_id', $_POST['txttipo']);
            $this->db->set('nome_id', $id);
            $this->db->set('medico_consulta_id', $medico_id);
            $this->db->set('medico_agenda', $medico_id);
            $this->db->set('tipo_agenda', 'normal');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'CONSULTA');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarespecialidade($agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('horarioagenda_id', $agenda_id);
            $this->db->set('inicio', $horaconsulta);
            $this->db->set('fim', $horaverifica);
            $this->db->set('nome', $nome);
            $this->db->set('data_inicio', $datainicial);
            $this->db->set('data_fim', $datafinal);
            $this->db->set('data', $index);
            $this->db->set('tipo_consulta_id', $_POST['txtespecialidade']);
            $this->db->set('nome_id', $id);
            $this->db->set('medico_consulta_id', $medico_id);
            $this->db->set('medico_agenda', $medico_id);
            $this->db->set('tipo_agenda', 'normal');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'FISIOTERAPIA');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravardicom($data) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('wkl_aetitle', $data['titulo']);
            $this->db->set('wkl_procstep_startdate', $data['data']);
            $this->db->set('wkl_procstep_starttime', $data['hora']);
            $this->db->set('wkl_modality', $data['tipo']);
            $this->db->set('wkl_perfphysname', $data['tecnico']);
            $this->db->set('wkl_procstep_descr', $data['procedimento']);
            $this->db->set('wkl_procstep_id', $data['procedimento_tuss_id']);
            $this->db->set('wkl_reqprocid', $data['procedimento_tuss_id_solicitado']);
            $this->db->set('wkl_reqprocdescr', $data['procedimento_solicitado']);
            $this->db->set('wkl_studyinstuid', $data['identificador_id']);
            $this->db->set('wkl_accnumber', $data['pedido_id']);
            $this->db->set('wkl_reqphysician', $data['solicitante']);
            $this->db->set('wkl_refphysname', $data['referencia']);
            $this->db->set('wkl_patientid', $data['paciente_id']);
            $this->db->set('wkl_patientname', $data['paciente']);
            $this->db->set('wkl_patientbirthdate', $data['nascimento']);
            $this->db->set('wkl_patientsex', $data['sexo']);
            $this->db->set('wkl_exame_id', $data['exame_id']);

            $this->db->insert('tb_integracao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function fecharfinanceiro() {
//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $data = date("Y-m-d");

        $credor_devedor_id = $_POST['relacao'];
        $conta_id = $_POST['conta'];
        $convenio_id = $_POST['convenio'];
        $data_inicio = $_POST['data1'];
        $data_fim = $_POST['data2'];

        $this->db->select('ir, pis, cofins, csll, iss, valor_base, entrega, pagamento');
        $this->db->from('tb_convenio');
        $this->db->where("convenio_id", $convenio_id);
        $query = $this->db->get();
        $returno = $query->result();
        $pagamento = $returno[0]->pagamento;
        $pagamentodata = substr($data, 0, 7) . "-" . $returno[0]->entrega;
        $data30 = date('Y-m-d', strtotime("+$pagamento days", strtotime($pagamentodata)));
        $ir = $returno[0]->ir / 100;
        $pis = $returno[0]->pis / 100;
        $cofins = $returno[0]->cofins / 100;
        $csll = $returno[0]->csll / 100;
        $iss = $returno[0]->iss / 100;
        $valor_base = $returno[0]->valor_base;
        $dineiro = str_replace(",", ".", str_replace(".", "", $_POST['dinheiro']));
        $dineirodescontado = $dineiro;

        if ($conta_id == "" || $credor_devedor_id == "" || $pagamento == "" || $pagamentodata == "") {

            $financeiro = -1;
        } else {


            if ($dineiro >= $valor_base) {
                $dineirodescontado = $dineirodescontado - ($dineiro * $ir);
            }
            $dineirodescontado = $dineirodescontado - ($dineiro * $pis);
            $dineirodescontado = $dineirodescontado - ($dineiro * $cofins);
            $dineirodescontado = $dineirodescontado - ($dineiro * $csll);
            $dineirodescontado = $dineirodescontado - ($dineiro * $iss);
            $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE ae.cancelada = 'false' 
AND ae.confirmado >= 'true' 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND c.convenio_id = $convenio_id 
ORDER BY ae.agenda_exames_id)";
            $this->db->query($sql);

            $this->db->set('valor', $dineirodescontado);
            $this->db->set('devedor', $credor_devedor_id);
            $this->db->set('data', $data30);
            $this->db->set('tipo', 'FATURADO CONVENIO');
            $this->db->set('observacao', "PERIODO DE $data_inicio ATE $data_fim");
            $this->db->set('conta', $conta_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_contasreceber');
        }
    }

    private function instanciar($agenda_exames_id) {

        if ($agenda_exames_id != 0) {
            $this->db->select('agenda_exames_id, horarioagenda_id, paciente_id, procedimento_tuss_id, inicio, fim, nome, ativo, confirmado, data_inicio, data_fim');
            $this->db->from('tb_agenda_exames');
            $this->db->where("agenda_exames_id", $agenda_exames_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_agenda_exames_id = $agenda_exames_id;

            $this->_horarioagenda_id = $return[0]->horarioagenda_id;
            $this->_paciente_id = $return[0]->paciente_id;
            $this->_procedimento_tuss_id = $return[0]->procedimento_tuss_id;
            $this->_inicio = $return[0]->inicio;
            $this->_fim = $return[0]->fim;
            $this->_nome = $return[0]->nome;
            $this->_ativo = $return[0]->ativo;
            $this->_confirmado = $return[0]->confirmado;
            $this->_data_inicio = $return[0]->data_inicio;
            $this->_data_fim = $return[0]->data_fim;
        } else {
            $this->_agenda_exames_id = null;
        }
    }

}

?>
