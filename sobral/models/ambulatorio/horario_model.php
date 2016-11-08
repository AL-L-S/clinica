<?php

class horario_model extends Model {

    var $_horario_id = null;
    var $_sala_id = null;
    var $_nome = null;
    var $_tipo = null;

    function Horario_model($horario_id = null) {
        parent::Model();
        if (isset($horario_id)) {
            $this->instanciar($horario_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('h.horario_id,
                            h.sala_id, es.nome, h.tipo');
        $this->db->from('tb_horario h');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = h.sala_id', 'left');
        $this->db->where('h.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarhorario() {
        $this->db->select('horario_id,
                            nome, 
                            tipo');
        $this->db->from('tb_horario');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarionome($horario) {
        $this->db->select('es.nome');
        $this->db->from('tb_horario h');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = h.sala_id', 'left');
        $this->db->where('horario_id', $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocomplete($parametro = null) {
        $this->db->select('horario_id,
                            nome');
        $this->db->from('tb_horario');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($horario_id) {

        $this->db->set('ativo', 'f');
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('horario_id', $horario_id);
        $this->db->update('tb_horario');
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
            $horario_id = $_POST['txthorarioID'];
            $this->db->set('sala_id', $_POST['sala']);
            $this->db->set('tipo', 'Fixo');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txthorariostipoID'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_horario');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $horario_id = $this->db->insert_id();
            }
            else { // update
                $horario_id = $_POST['txthorariostipoID'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('horario_id', $horario_id);
                $this->db->update('tb_horario');
            }

            return $horario_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarhorariolivro($horario_id = null) {
        $this->db->select();
        $this->db->from('tb_horariolivro');
        $this->db->where('horario_id', $horario_id);
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }

    function listartotalhoariofixo() {
        $this->db->select();
        $this->db->from('tb_horario');
        $this->db->where('tipo', 'Fixo');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarhorariofixo() {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('horario_id', $_POST['txthorarioID']);
            $this->db->set('dia', $_POST['txtDia']);
            $this->db->set('horaentrada1', $_POST['txthoraEntrada1']);
            $this->db->set('horasaida1', $_POST['txthoraSaida1']);
            $this->db->set('intervaloinicio', $_POST['txtIniciointervalo']);
            $this->db->set('intervalofim', $_POST['txtFimintervalo']);
            $this->db->set('tempoconsulta', $_POST['txtTempoconsulta']);
            $this->db->set('qtdeconsulta', $_POST['txtQtdeconsulta']);

            $this->db->insert('tb_horariohorario');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return true;
            else
                return false;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirhorariofixo($horario_id) {

        $this->db->where('horariohorario_id', $horario_id);
        $this->db->delete('tb_horariohorario');
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
    private function instanciar($horario_id) {
        if ($horario_id != 0) {
            $this->db->select('horario_id, es.nome, h.sala_id, h.tipo');
            $this->db->from('tb_horario h ');
            $this->db->join('tb_exame_sala es', 'es.exame_sala_id = h.sala_id', 'left');
            $this->db->where("horario_id", $horario_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_horario_id = $horario_id;

            $this->_nome = $return[0]->nome;
            $this->_sala_id = $return[0]->sala_id;
            $this->_tipo = $return[0]->tipo;
        } else {
            $this->_horario_id = null;
        }
    }

}

?>
