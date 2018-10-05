<?php

class agenda_model extends Model {

    var $_agenda_id = null;
    var $_nome = null;
    var $_tipo = null;

    function Agenda_model($agenda_id = null) {
        parent::Model();
        if (isset($agenda_id)) {
            $this->instanciar($agenda_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('agenda_id,
                            nome, tipo');
        $this->db->from('tb_agenda');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarferiados($args = array()) {
        $this->db->select('feriado_id,
                            nome, data');
        $this->db->from('tb_feriado');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike',"%".$args['nome']."%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('data', $args['data']);
        }
        return $this->db;
    }

    function listarempresa() {
        $this->db->select('empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 't');
        $query = $this->db->get();

        return $query->result();
    }

    function listartiposala() {
        $this->db->select('tipo');
        $this->db->from('tb_exame_sala_grupo esg');        
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = esg.grupo', 'left');
        $this->db->where('esg.ativo', 't');
        $query = $this->db->get();

        return $query->result();
    }

    function listaragenda() {
        $this->db->select('agenda_id,
                            nome, 
                            tipo');
        $this->db->from('tb_agenda');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarespecialidades() {
        $this->db->select('ambulatorio_grupo_id,
                            nome');
        $this->db->from('tb_ambulatorio_grupo');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocomplete($parametro = null) {
        $this->db->select('agenda_id,
                            nome');
        $this->db->from('tb_agenda');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluirferiado($feriado_id) {

        $this->db->set('ativo', 'f');
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('feriado_id', $feriado_id);
        $this->db->update('tb_feriado');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluir($agenda_id) {
//        var_dump($_POST); die;
        if ($_POST['excluir'] == 'on') {
            if ($_POST['txttipo'] != 'TODOS') {
                if ($_POST['txttipo'] == 'ESPECIALIDADE') {
                    $this->db->where("(tipo = 'ESPECIALIDADE' OR tipo = 'FISIOTERAPIA')");
                } else {
                    $this->db->where('tipo', $_POST['txttipo']);
                }
            }
            if ($_POST['txtmedico'] != 'TODOS') {
                $this->db->where('medico_agenda', $_POST['txtmedico']);
            }
            $this->db->where('data >=', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdatainicial']))));
            $this->db->where('data <=', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdatafinal']))));
            $this->db->where('inicio >=', $_POST['horainicio']);
            $this->db->where('inicio <=', $_POST['horafim']);
            $this->db->where('horarioagenda_id', $agenda_id);
            $this->db->where('paciente_id is null');
            $this->db->delete('tb_agenda_exames');
        }

        $this->db->set('ativo', 'f');
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('agenda_id', $agenda_id);
        $this->db->update('tb_agenda');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }
    
    function excluiragendascriadas() {
        $this->db->where('nome', $_GET['nome']);
        $this->db->where('medico_agenda', $_GET['medico_id']);
        $this->db->where('horarioagenda_id', $_GET['horario_id']);
        $this->db->where('paciente_id IS NULL');
        $this->db->delete('tb_agenda_exames');
    }
        
    function listarhorarioagendaeditadas($agenda_id) {
        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_editada_id,
                           h.sala_id,
                           h.empresa_id,
                           s.nome as sala');
        $this->db->from('tb_horarioagenda_editada h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->join('tb_exame_sala s', 's.exame_sala_id = h.sala_id', 'left');
        $this->db->where("h.agenda_id", $agenda_id);
        $this->db->where("h.ativo", 't');
        $this->db->where("h.consolidado", 'f');
        $this->db->where("h.medico_id", $_GET['medico_id']);
        $this->db->where("h.nome",  $_GET['nome']);
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarhorariosagendacriadaconsolidados($agenda_id) {
        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_editada_id');
        $this->db->from('tb_horarioagenda_editada h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->where("h.agenda_id", $agenda_id);
        $this->db->where("h.horarioagenda_editada_id IN (   
                                SELECT horarioagenda_editada_id 
                                FROM ponto.tb_agenda_exames
                                WHERE horarioagenda_id = '{$agenda_id}'
                                AND paciente_id IS NULL
                                AND agenda_editada = 't'
                                AND nome = '{$_GET['nome']}')");
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }
    function listarhorariosagendacriada($agenda_id) {
        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_id,
                           h.sala_id,
                           s.nome as sala');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->join('tb_exame_sala s', 's.exame_sala_id = h.sala_id', 'left');
        $this->db->where("h.agenda_id", $agenda_id);
        $this->db->where("h.horarioagenda_id IN (   
                                SELECT horario_id 
                                FROM ponto.tb_agenda_exames
                                WHERE horarioagenda_id = '{$agenda_id}'
                                AND paciente_id IS NULL
                                AND medico_agenda = '{$_GET['medico_id']}'
                                AND nome = '{$_GET['nome']}')");
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarsalahorarioagenda() {
        try {
            $sala_id = $_POST['sala_id'];
            $horario_id = $_POST['horario_id'];
            $this->db->set('sala_id', $sala_id);
            $this->db->where('horarioagenda_id', $horario_id);
            $this->db->update('tb_horarioagenda');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarferiado() {
        try {

            /* inicia o mapeamento no banco */
            $feriado_id = $_POST['feriado_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('data', $_POST['data']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($feriado_id == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_feriado');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $agenda_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('feriado_id', $feriado_id);
                $this->db->update('tb_feriado');
            }
            return $feriado_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {

            /* inicia o mapeamento no banco */
            $agenda_id = $_POST['txtagendaID'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('tipo', 'Fixo');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txthorariostipoID'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $agenda_id = $this->db->insert_id();
            }
            else { // update
                $agenda_id = $_POST['txthorariostipoID'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_id', $agenda_id);
                $this->db->update('tb_agenda');
            }

            return $agenda_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarmedico() {
        try {

            $datainicial = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
            $datafinal = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));

            if (isset($_POST['txtdomingo'])) {
                $Domingo = 'Domingo';
            } else {
                $Domingo = '';
            }
            if (isset($_POST['txtsegunda'])) {
                $Segunda = 'Segunda';
            } else {
                $Segunda = '';
            }
            if (isset($_POST['txtterca'])) {
                $Terça = 'Terça';
            } else {
                $Terça = '';
            }
            if (isset($_POST['txtquarta'])) {
                $Quarta = 'Quarta';
            } else {
                $Quarta = '';
            }
            if (isset($_POST['txtquinta'])) {
                $Quinta = 'Quinta';
            } else {
                $Quinta = '';
            }
            if (isset($_POST['txtsexta'])) {
                $Sexta = 'Sexta';
            } else {
                $Sexta = '';
            }
            if (isset($_POST['txtsabado'])) {
                $Sabado = 'Sabado';
            } else {
                $Sabado = '';
            }

            if ($_POST['txtacao'] == 'Alterarmedico') {

                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('Y-m-d', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('medico_consulta_id', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }if ($_POST['txtacao'] == 'Bloquear') {


                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('bloqueado', 't');
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }
            if ($_POST['txtacao'] == 'Excluir') {


                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'EXAME');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->where('medico_agenda', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarmedicogeral() {
        try {

            $datainicial = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
            $datafinal = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));

            if (isset($_POST['txtdomingo'])) {
                $Domingo = 'Domingo';
            } else {
                $Domingo = '';
            }
            if (isset($_POST['txtsegunda'])) {
                $Segunda = 'Segunda';
            } else {
                $Segunda = '';
            }
            if (isset($_POST['txtterca'])) {
                $Terça = 'Terça';
            } else {
                $Terça = '';
            }
            if (isset($_POST['txtquarta'])) {
                $Quarta = 'Quarta';
            } else {
                $Quarta = '';
            }
            if (isset($_POST['txtquinta'])) {
                $Quinta = 'Quinta';
            } else {
                $Quinta = '';
            }
            if (isset($_POST['txtsexta'])) {
                $Sexta = 'Sexta';
            } else {
                $Sexta = '';
            }
            if (isset($_POST['txtsabado'])) {
                $Sabado = 'Sabado';
            } else {
                $Sabado = '';
            }

            if ($_POST['txtacao'] == 'Alterarmedico') {

                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }

            if ($_POST['txtacao'] == 'Bloquear') {

                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('bloqueado', 't');
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }
            if ($_POST['txtacao'] == 'Excluir') {


                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarmedicoconsulta() {
        try {

            $datainicial = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
            $datafinal = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));

            if (isset($_POST['txtdomingo'])) {
                $Domingo = 'Domingo';
            } else {
                $Domingo = '';
            }
            if (isset($_POST['txtsegunda'])) {
                $Segunda = 'Segunda';
            } else {
                $Segunda = '';
            }
            if (isset($_POST['txtterca'])) {
                $Terça = 'Terça';
            } else {
                $Terça = '';
            }
            if (isset($_POST['txtquarta'])) {
                $Quarta = 'Quarta';
            } else {
                $Quarta = '';
            }
            if (isset($_POST['txtquinta'])) {
                $Quinta = 'Quinta';
            } else {
                $Quinta = '';
            }
            if (isset($_POST['txtsexta'])) {
                $Sexta = 'Sexta';
            } else {
                $Sexta = '';
            }
            if (isset($_POST['txtsabado'])) {
                $Sabado = 'Sabado';
            } else {
                $Sabado = '';
            }

            if ($_POST['txtacao'] == 'Alterarmedico') {

                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        if($_POST['sala'] != ""){
                            $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        }
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        if($_POST['sala'] != ""){
                            $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        }
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        if($_POST['sala'] != ""){
                            $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        }
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        if($_POST['sala'] != ""){
                            $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        }
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        if($_POST['sala'] != ""){
                            $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        }
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        if($_POST['sala'] != ""){
                            $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        }
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        if($_POST['sala'] != ""){
                            $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        }
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }

            if ($_POST['txtacao'] == 'Bloquear') {

                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('bloqueado', 't');
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }
            if ($_POST['txtacao'] == 'Excluir') {


                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where('tipo', 'CONSULTA');
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarmedicoespecialidade() {
        try {

            $datainicial = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
            $datafinal = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));

            if (isset($_POST['txtdomingo'])) {
                $Domingo = 'Domingo';
            } else {
                $Domingo = '';
            }
            if (isset($_POST['txtsegunda'])) {
                $Segunda = 'Segunda';
            } else {
                $Segunda = '';
            }
            if (isset($_POST['txtterca'])) {
                $Terça = 'Terça';
            } else {
                $Terça = '';
            }
            if (isset($_POST['txtquarta'])) {
                $Quarta = 'Quarta';
            } else {
                $Quarta = '';
            }
            if (isset($_POST['txtquinta'])) {
                $Quinta = 'Quinta';
            } else {
                $Quinta = '';
            }
            if (isset($_POST['txtsexta'])) {
                $Sexta = 'Sexta';
            } else {
                $Sexta = '';
            }
            if (isset($_POST['txtsabado'])) {
                $Sabado = 'Sabado';
            } else {
                $Sabado = '';
            }

            if ($_POST['txtacao'] == 'Alterarmedico') {

                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('medico_agenda', $_POST['medico']);
                        $this->db->set('data_medico_agenda', $horario);
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('agenda_exames_nome_id', $_POST['sala']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }

            if ($_POST['txtacao'] == 'Bloquear') {

                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('bloqueado', 't');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        if ($_POST['txtobservacao'] != '') {
                            $this->db->set('observacoes', $_POST['txtobservacao']);
                        }
                        $this->db->set('bloqueado', 't');
                        $this->db->set('operador_medico_agenda', $operador_id);
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('paciente_id is null');
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->update('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }
            if ($_POST['txtacao'] == 'Excluir') {


                for ($index = $datainicial; strtotime($index) <= strtotime($datafinal); $index = date('d-m-Y', strtotime("+1 days", strtotime($index)))) {

                    $data = strftime("%A", strtotime($index));

                    switch ($data) {
                        case"Sunday": $data = "Domingo";
                            break;
                        case"Monday": $data = "Segunda";
                            break;
                        case"Tuesday": $data = "Terça";
                            break;
                        case"Wednesday": $data = "Quarta";
                            break;
                        case"Thursday": $data = "Quinta";
                            break;
                        case"Friday": $data = "Sexta";
                            break;
                        case"Saturday": $data = "Sabado";
                            break;
                    }

                    if ($data == $Domingo) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Segunda) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Terça) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quarta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Quinta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sexta) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                    if ($data == $Sabado) {
                        /* inicia o mapeamento no banco */
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->where('paciente_id is null');
                        $this->db->where('data', $index);
                        $this->db->where("(tipo = 'FISIOTERAPIA' OR tipo = 'ESPECIALIDADE')");
                        $this->db->where('inicio >=', $_POST['horainicio']);
                        $this->db->where('inicio <=', $_POST['horafim']);
                        $this->db->where('medico_consulta_id', $_POST['medico']);
                        $this->db->delete('tb_agenda_exames');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                            return -1;
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarhorarioagendacriado($agenda_id = null) {
        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_id,
                           s.nome as sala,
                           h.empresa_id,
                           h.sala_id');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->join('tb_exame_sala s', 's.exame_sala_id = h.sala_id', 'left');
        $this->db->where('agenda_id', $agenda_id);
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioagenda($agenda_id = null) {
        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_id,
                           h.empresa_id,
                           s.nome as sala,
                           h.sala_id');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->join('tb_exame_sala s', 's.exame_sala_id = h.sala_id', 'left');
        $this->db->where('agenda_id', $agenda_id);
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }

    function listartotalhoariofixo() {
        $this->db->select();
        $this->db->from('tb_agenda');
        $this->db->where('tipo', 'Fixo');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaratribuiragenda($agenda_id) {
        $this->db->select('agenda_id,
                            nome, 
                            tipo');
        $this->db->from('tb_agenda');
        $this->db->where('ativo', 'true');
        $this->db->where('agenda_id', $agenda_id);
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioagendacriacao($agenda_id = null, $medico_id = null, $datainicial, $datafinal, $tipo) {

        $this->db->select('distinct(horario_id)');
        $this->db->from('tb_agenda_exames ae');
//        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->where('horarioagenda_id', $agenda_id);
        $this->db->where('medico_agenda', $medico_id);
        $this->db->where('data >=', $datainicial);
        $this->db->where('data <=', $datafinal);
        $this->db->where('tipo', $tipo);
        $this->db->where('horario_id is not null');
        // $this->db->where('paciente_id is null');
        $this->db->groupby('horario_id');
        $return2 = $this->db->get()->result();
        if (count($return2) > 0) {
            $horario_id = '';
//            $horario_id = $return2
            foreach ($return2 as $item) {
                if ($horario_id == '') {
                    $horario_id = $horario_id . "$item->horario_id";
                } else {
                    $horario_id = $horario_id . ",$item->horario_id";
                }
            }
        }


        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_id,
                           h.sala_id');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->join('tb_exame_sala s', 's.exame_sala_id = h.sala_id', 'left');
        $this->db->where('agenda_id', $agenda_id);
        $this->db->where('h.sala_id IS NOT NULL');

        if (count($return2) > 0) {

            $this->db->where("horarioagenda_id NOT IN ($horario_id)");
        }

        $this->db->orderby('dia');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }
    function listarhorarioagendacriacaogeral($agenda_id = null, $medico_id = null, $datainicial, $datafinal, $tipo) {

        $this->db->select('distinct(horario_id)');
        $this->db->from('tb_agenda_exames ae');
//        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->where('horarioagenda_id', $agenda_id);
        $this->db->where('medico_agenda', $medico_id);
        $this->db->where('data >=', $datainicial);
        $this->db->where('data <=', $datafinal);
        $this->db->where('tipo', $tipo);
        $this->db->where('horario_id is not null');
        $this->db->groupby('horario_id');
        $return2 = $this->db->get()->result();
        if (count($return2) > 0) {
            $horario_id = '';
            foreach ($return2 as $item) {
                if ($horario_id == '') {
                    $horario_id = $horario_id . "$item->horario_id";
                } else {
                    $horario_id = $horario_id . ",$item->horario_id";
                }
            }
        }


        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_id,
                           h.sala_id');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->join('tb_exame_sala s', 's.exame_sala_id = h.sala_id', 'left');
        $this->db->where('agenda_id', $agenda_id);
        $this->db->where('h.sala_id IS NOT NULL');

        if (count($return2) > 0) {
            $this->db->where("horarioagenda_id NOT IN ($horario_id)");
        }

        $this->db->orderby('dia');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function listarnovoshorarioseditaragendacriada() {

        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_editada_id,
                           h.sala_id');
        $this->db->from('tb_horarioagenda_editada h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->join('tb_exame_sala s', 's.exame_sala_id = h.sala_id', 'left');
        $this->db->where("h.agenda_id", $_GET['agenda_id']);
        $this->db->where("h.ativo", 't');
        $this->db->where("h.consolidado", 'f');
        $this->db->where("h.medico_id", $_GET['medico_id']);
        $this->db->where("h.nome",  $_GET['nome_agenda']);
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioagendacriacaoespecialidade($agenda_id = null, $medico_id = null, $datainicial, $datafinal, $tipo) {

        $this->db->select('distinct(horario_id)');
        $this->db->from('tb_agenda_exames ae');
//        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->where('horarioagenda_id', $agenda_id);
        $this->db->where('medico_agenda', $medico_id);
        $this->db->where('data >=', $datainicial);
        $this->db->where('data <=', $datafinal);
        $this->db->where("(tipo ='ESPECIALIDADE' OR tipo = 'FISIOTERAPIA')");
        $this->db->where('horario_id is not null');
        $this->db->where('paciente_id is null');
        $this->db->groupby('horario_id');
        $return2 = $this->db->get()->result();
        if (count($return2) > 0) {
            $horario_id = '';
//            $horario_id = $return2
            foreach ($return2 as $item) {
                if ($horario_id == '') {
                    $horario_id = $horario_id . "$item->horario_id";
                } else {
                    $horario_id = $horario_id . ",$item->horario_id";
                }
            }
        }
//        var_dump($medico_id); die;


        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_id');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->where('agenda_id', $agenda_id);

        if (count($return2) > 0) {

            $this->db->where("horarioagenda_id NOT IN ($horario_id)");
        }

        $this->db->orderby('dia');
        $return = $this->db->get();
//        var_dump($agenda_id, $return->result()); die;
        return $return->result();
    }

    function instanciarferiado($feriado_id = null) {
        $this->db->select('feriado_id,
                           nome,
                           data');
        $this->db->from('tb_feriado');
        $this->db->where('feriado_id', $feriado_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarioagendaexclusao($agenda_id = null) {
        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_id');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->where('horarioagenda_id', $agenda_id);
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaexclusao($agenda_id = null) {
        $this->db->select('e.nome as empresa,
                           h.dia,
                           h.horaentrada1,
                           h.horasaida1,
                           h.intervaloinicio,
                           h.intervalofim,
                           h.tempoconsulta,
                           h.agenda_id,
                           h.qtdeconsulta,
                           h.empresa_id,
                           h.observacoes,
                           h.horarioagenda_id');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
        $this->db->where('agenda_id', $agenda_id);
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarhorarioagendacriada($agenda_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
//            $agenda_id = $_POST['txtagendaID'];
            $x = 0;
            foreach ($_POST['txtDia'] as $dia) { //verifica se esse dia ja tem algum cadastro nessa agenda, se tiver, deve primeiro exclui-lo para depois criar.
                $x++;
                $horaentrada1 = $_POST['txthoraEntrada'][$x];
                if ($horaentrada1 != '') {
                    $this->db->select('e.nome as empresa,
                                       h.dia,
                                       h.horaentrada1,
                                       h.horasaida1,
                                       h.intervaloinicio,
                                       h.intervalofim,
                                       h.tempoconsulta,
                                       h.agenda_id,
                                       h.qtdeconsulta,
                                       h.empresa_id,
                                       h.observacoes,
                                       h.horarioagenda_id');
                    $this->db->from('tb_horarioagenda h');
                    $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
                    $this->db->where("h.agenda_id", $agenda_id);
                    $this->db->where("h.dia", $dia);
                    $this->db->where("h.horarioagenda_id IN (   
                                            SELECT horario_id 
                                            FROM ponto.tb_agenda_exames
                                            WHERE horarioagenda_id = '{$agenda_id}'
                                            AND paciente_id IS NULL
                                            AND medico_agenda = '{$_POST['medico_id']}'
                                            AND nome = '{$_POST['nome_agenda']}')");
                    $this->db->orderby('dia');
                    $return = $this->db->get();
                    $return = $return->result();

                    if( count($return) > 0 ){
                        return true;
                    }
//                    
//                    $this->db->select('e.nome as empresa,
//                               h.dia,
//                               h.horaentrada1,
//                               h.horasaida1,
//                               h.intervaloinicio,
//                               h.intervalofim,
//                               h.tempoconsulta,
//                               h.agenda_id,
//                               h.qtdeconsulta,
//                               h.empresa_id,
//                               h.observacoes,
//                               h.horarioagenda_id');
//                    $this->db->from('tb_horarioagenda h');
//                    $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
//                    $this->db->where("h.agenda_id", $agenda_id);
//                    $this->db->where("h.dia", $dia);
//                    $this->db->where("h.horarioagenda_id IN (   
//                                            SELECT horario_id 
//                                            FROM ponto.tb_agenda_exames
//                                            WHERE horarioagenda_id = '{$agenda_id}'
//                                            AND paciente_id IS NULL
//                                            AND medico_agenda = '{$_POST['medico_id']}'
//                                            AND nome = '{$_POST['nome_agenda']}')");
//                    $this->db->orderby('dia');
//                    $return = $this->db->get();
//                    $return = $return->result();
//
//                    if( count($return) > 0 ){
//                        return true;
//                    }
                }
                
            }
            
            $i = 0;
            foreach ($_POST['txtDia'] as $dia) {
                $this->db->select('agenda_id, nome, tipo');
                $this->db->from('tb_agenda');
                $this->db->where("agenda_id", $agenda_id);
                $query = $this->db->get();
                $return = $query->result();
            
                $i++;
                $horaentrada1 = $_POST['txthoraEntrada'][$i];
                $horasaida1 = $_POST['txthoraSaida'][$i];
                $intervaloinicio = $_POST['txtIniciointervalo'][$i];
                $intervalofim = $_POST['txtFimintervalo'][$i];
                $tempoconsulta = $_POST['txtTempoconsulta'][$i];
                $qtdeconsulta = $_POST['txtQtdeconsulta'][$i];
                $empresa_id = $_POST['empresa'][$i];
                $sala_id = $_POST['sala'][$i];

                if ($horaentrada1 != '') {

                    
                    $this->db->set('agenda_id', $agenda_id);
                    $this->db->set('dia', $dia);
                    $this->db->set('horaentrada1', $horaentrada1);
                    $this->db->set('horasaida1', $horasaida1);
                    $this->db->set('intervaloinicio', $intervaloinicio);
                    $this->db->set('intervalofim', $intervalofim);
                    if($tempoconsulta != ''){
                        $this->db->set('tempoconsulta', $tempoconsulta);
                    }
                    if($qtdeconsulta != ''){
                        $this->db->set('qtdeconsulta', $qtdeconsulta);
                    }
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('sala_id', $sala_id);
                    $this->db->set('medico_id', $_POST['medico_id']);
                    $this->db->set('nome', $_POST['nome_agenda']);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);

                    $this->db->insert('tb_horarioagenda_editada');
                }
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return true;
            else
                return false;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarhorariofixo() {
        try {
            $agenda_id = $_POST['txtagendaID'];
            $i = 0;
            
            /* inicia o mapeamento no banco */
            
            foreach ($_POST['txtDia'] as $dia) {
                $i++;
                $horaentrada1 = $_POST['txthoraEntrada'][$i];
                $horasaida1 = $_POST['txthoraSaida'][$i];
                $intervaloinicio = $_POST['txtIniciointervalo'][$i];
                $intervalofim = $_POST['txtFimintervalo'][$i];
                $tempoconsulta = $_POST['txtTempoconsulta'][$i];
                $qtdeconsulta = $_POST['txtQtdeconsulta'][$i];
                $empresa_id = $_POST['empresa'][$i];
                $sala_id = $_POST['sala'][$i];

                if ($horaentrada1 != '') {
                    if ($horaentrada1 >= $horasaida1 ){
                        return -4;
                    }
                    
                    $this->db->select('horaentrada1, horasaida1');
                    $this->db->from('tb_horarioagenda');
                    $this->db->where('agenda_id', $agenda_id);
                    $this->db->where('dia', $dia);
                    $query = $this->db->get()->result();
                    
                    if( count($query) > 0 ) { // Caso ja tenha algum horario nesse dia
                        if ( count($query) == 1 ) { // Caso tenha apenas um horario
                            // A condição abaixo verifica se os horarios colidem
                            if (($horaentrada1 > $query[0]->horaentrada1 && $horaentrada1 >= $query[0]->horasaida1) || ($horasaida1 < $query[0]->horaentrada1 )){
                                
                                $this->db->set('agenda_id', $agenda_id);
                                $this->db->set('dia', $dia);
                                $this->db->set('horaentrada1', $horaentrada1);
                                $this->db->set('horasaida1', $horasaida1);
                                $this->db->set('intervaloinicio', $intervaloinicio);
                                $this->db->set('intervalofim', $intervalofim);

                                if($tempoconsulta != ""){
                                    $this->db->set('tempoconsulta', $tempoconsulta);
                                }
                                if($qtdeconsulta != ""){
                                    $this->db->set('qtdeconsulta', $qtdeconsulta);
                                }

                                $this->db->set('empresa_id', $empresa_id);
                                $this->db->set('sala_id', $sala_id);
                                $this->db->set('observacoes', $_POST['obs']);

                                $this->db->insert('tb_horarioagenda');
                            }
                            else {
                                return -2;
                            }
                        }
                        else {
                            return -3;
                        }
                    } else {
                    
                        $this->db->set('agenda_id', $agenda_id);
                        $this->db->set('dia', $dia);
                        $this->db->set('horaentrada1', $horaentrada1);
                        $this->db->set('horasaida1', $horasaida1);
                        $this->db->set('intervaloinicio', $intervaloinicio);
                        $this->db->set('intervalofim', $intervalofim);

                        if($tempoconsulta != ""){
                            $this->db->set('tempoconsulta', $tempoconsulta);
                        }
                        if($qtdeconsulta != ""){
                            $this->db->set('qtdeconsulta', $qtdeconsulta);
                        }

                        $this->db->set('empresa_id', $empresa_id);
                        $this->db->set('sala_id', $sala_id);
                        $this->db->set('observacoes', $_POST['obs']);

                        $this->db->insert('tb_horarioagenda');
                    }
                }
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 1;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirhorarioagendaconsolidada($agenda_id) {
        $this->db->where('paciente_id is null');
        $this->db->where('nome', $_GET['nome']);
        $this->db->where('horarioagenda_id', $agenda_id);
        $this->db->where('medico_agenda', $_GET['medico_id']);
        $this->db->where('horarioagenda_editada_id', $_GET['horario_id']);
        $this->db->delete('tb_agenda_exames');
        
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirhorarioagendacriada($agenda_id) {
//        echo "<pre>"; var_dump($_GET);die;
        $this->db->where('nome', $_GET['nome']);
        $this->db->where('horario_id', $_GET['horario_id']);
        $this->db->where('medico_agenda', $_GET['medico_id']);
        $this->db->where('horarioagenda_id', $agenda_id);
        $this->db->where('paciente_id is null');
        $this->db->delete('tb_agenda_exames');
        
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function consolidandonovoshorarios($horario_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('consolidado', 't');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('horarioagenda_editada_id', $horario_id);
        $this->db->update('tb_horarioagenda_editada');
    }

    function excluirhorarioagendaeditada($horario_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('horarioagenda_editada_id', $horario_id);
        $this->db->update('tb_horarioagenda_editada');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirhorariofixo($agenda_id) {
//        var_dump($agenda_id); die;
        if ($_POST['excluir'] == 'on') {
            if ($_POST['txttipo'] != 'TODOS') {
                if ($_POST['txttipo'] == 'ESPECIALIDADE') {
                    $this->db->where("(tipo = 'ESPECIALIDADE' OR tipo = 'FISIOTERAPIA')");
                } else {
                    $this->db->where('tipo', $_POST['txttipo']);
                }
            }
            if ($_POST['txtmedico'] != 'TODOS') {
                $this->db->where('medico_agenda', $_POST['txtmedico']);
            }
            $this->db->where('horario_id', $agenda_id);
            $this->db->where('paciente_id is null');
            $this->db->delete('tb_agenda_exames');
        }

        $this->db->where('horarioagenda_id', $agenda_id);
        $this->db->delete('tb_horarioagenda');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    /**
     * Função para instanciar os valores da tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access private
     * @return Resposta true/false da conexão com o banco
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    private function instanciar($agenda_id) {
        if ($agenda_id != 0) {
            $this->db->select('agenda_id, nome, tipo');
            $this->db->from('tb_agenda');
            $this->db->where("agenda_id", $agenda_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_agenda_id = $agenda_id;

            $this->_nome = $return[0]->nome;
            $this->_tipo = $return[0]->tipo;
        } else {
            $this->_agenda_id = null;
        }
    }

}

?>
