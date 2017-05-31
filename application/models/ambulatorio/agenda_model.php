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

    function listarempresa() {
        $this->db->select('empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 't');
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

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
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
                        $this->db->where('tipo', 'CONSULTA');
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
                        $this->db->where('tipo', 'CONSULTA');
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
                        $this->db->where('tipo', 'CONSULTA');
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
                        $this->db->where('tipo', 'CONSULTA');
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
                        $this->db->where('tipo', 'CONSULTA');
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
                        $this->db->where('tipo', 'CONSULTA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                        $this->db->where('tipo', 'FISIOTERAPIA');
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
                           h.horarioagenda_id');
        $this->db->from('tb_horarioagenda h');
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id', 'left');
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
//        var_dump(count($return2)); die;


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
//        var_dump($return->result()); die;
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
//        var_dump(count($return2)); die;


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
//        var_dump($return->result()); die;
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

    function gravarhorariofixo() {
        try {
            $agenda_id = $_POST['txtagendaID'];
            $i = 0;
            /* inicia o mapeamento no banco */
//            echo '<pre>';
//            var_dump($_POST); die;
            foreach ($_POST['txtDia'] as $dia) {
                $i++;
                $horaentrada1 = $_POST['txthoraEntrada'][$i];
                $horasaida1 = $_POST['txthoraSaida'][$i];
                $intervaloinicio = $_POST['txtIniciointervalo'][$i];
                $intervalofim = $_POST['txtFimintervalo'][$i];
                $tempoconsulta = $_POST['txtTempoconsulta'][$i];
                $qtdeconsulta = $_POST['txtQtdeconsulta'][$i];
                $empresa_id = $_POST['empresa'][$i];

//                var_dump($dia, $horaentrada1, $horasaida1, $intervaloinicio, $intervalofim, $tempoconsulta);

                if ($horaentrada1 != '') {


                    $this->db->set('agenda_id', $agenda_id);
                    $this->db->set('dia', $dia);
                    $this->db->set('horaentrada1', $horaentrada1);
                    $this->db->set('horasaida1', $horasaida1);
                    $this->db->set('intervaloinicio', $intervaloinicio);
                    $this->db->set('intervalofim', $intervalofim);
                    $this->db->set('tempoconsulta', $tempoconsulta);
                    $this->db->set('qtdeconsulta', $qtdeconsulta);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('observacoes', $_POST['obs']);

                    $this->db->insert('tb_horarioagenda');
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
