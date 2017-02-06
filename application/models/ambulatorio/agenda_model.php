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

            $datainicial = date("Y-m-d", strtotime( str_replace("/", "-", $_POST['datainicio']) ) );
            $datafinal = date("Y-m-d", strtotime( str_replace("/", "-", $_POST['datafim']) ) );

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

            $datainicial = date("Y-m-d", strtotime( str_replace("/", "-", $_POST['datainicio']) ) );
            $datafinal = date("Y-m-d", strtotime( str_replace("/", "-", $_POST['datafim']) ) );
            
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

            $datainicial = date("Y-m-d", strtotime( str_replace("/", "-", $_POST['datainicio']) ) );
            $datafinal = date("Y-m-d", strtotime( str_replace("/", "-", $_POST['datafim']) ) );

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

            $datainicial = date("Y-m-d", strtotime( str_replace("/", "-", $_POST['datainicio']) ) );
            $datafinal = date("Y-m-d", strtotime( str_replace("/", "-", $_POST['datafim']) ) );

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
        $this->db->join('tb_empresa e', 'e.empresa_id = h.empresa_id');
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

    function gravarhorariofixo() {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('agenda_id', $_POST['txtagendaID']);
            $this->db->set('dia', $_POST['txtDia']);
            $this->db->set('horaentrada1', $_POST['txthoraEntrada1']);
            $this->db->set('horasaida1', $_POST['txthoraSaida1']);
            $this->db->set('intervaloinicio', $_POST['txtIniciointervalo']);
            $this->db->set('intervalofim', $_POST['txtFimintervalo']);
            $this->db->set('tempoconsulta', $_POST['txtTempoconsulta']);
            $this->db->set('qtdeconsulta', $_POST['txtQtdeconsulta']);
            $this->db->set('empresa_id', $_POST['empresa']);
            $this->db->set('observacoes', $_POST['obs']);

            $this->db->insert('tb_horarioagenda');
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
