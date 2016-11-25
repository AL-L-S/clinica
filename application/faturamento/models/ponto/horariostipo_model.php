<?php

class horariostipo_model extends Model {

    var $_horariostipo_id = null;
    var $_nome = null;
    var $_tipo = null;

    function Horariostipo_model($horariostipo_id=null) {
        parent::Model();
        if (isset($horariostipo_id)) {
            $this->instanciar($horariostipo_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('horariostipo_id,
                            nome, tipo');
        $this->db->from('tb_horariostipo');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }
    
    function listarautocomplete($parametro=null) {
        $this->db->select('horariostipo_id,
                            nome');
        $this->db->from('tb_horariostipo');
        $this->db->where('ativo', 'true');
            if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }
    

    function excluir($horariostipo_id) {

        $this->db->set('ativo', 'f');
        $this->db->where('horariostipo_id', $horariostipo_id);
        $this->db->update('tb_horariostipo');
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
            $horariostipo_id = $_POST['txthorariostipoID'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('tipo', $_POST['txtTipo']);

            if ($_POST['txthorariostipoID'] == "") {// insert
                $this->db->insert('tb_horariostipo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $horariostipo_id = $this->db->insert_id();
            }
            else { // update
                $horariostipo_id = $_POST['txthorariostipoID'];
                $this->db->where('horariostipo_id', $horariostipo_id);
                $this->db->update('tb_horariostipo');
            }

            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }
    
    function listarhoariovariavel($horariostipo_id=null) {
        $this->db->select();
        $this->db->from('tb_horariovariavel');
        $this->db->where('horariostipo_id', $horariostipo_id);
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }

    
    function gravarhorariovariavel() {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('horariostipo_id', $_POST['txthorariostipoID']);
            $this->db->set('data', $_POST['txtData']);
            $this->db->set('horaentrada1', $_POST['txthoraEntrada1']);
            $this->db->set('horasaida1', $_POST['txthoraSaida1']);
            $this->db->set('horaentrada2', $_POST['txthoraEntrada2']);
            $this->db->set('horasaida2', $_POST['txthoraSaida2']);
            $this->db->set('horaentrada3', $_POST['txthoraEntrada3']);
            $this->db->set('horasaida3', $_POST['txthoraSaida3']);

                $this->db->insert('tb_horariovariavel');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return true;
                else
                    return false;
        } catch (Exception $exc) {
            return false;
        }
    }

    
    function excluirhorariovariavel($horariovariavel_id) {

        $this->db->where('horariovariavel_id', $horariovariavel_id);
        $this->db->delete('tb_horariovariavel');
        $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return false;
                else
                    return true;
        
    }
    
    function listarhoarioindividual($funcionario_id=null) {
        $this->db->select();
        $this->db->from('tb_horarioindividual');
        $this->db->where('funcionario_id', $funcionario_id);
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarhoariotroca($funcionario_id=null) {
        $this->db->select();
        $this->db->from('tb_horarioindividual');
        $this->db->where('troca_id', $funcionario_id);
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }
    
    function gravarhorarioindividual() {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('funcionario_id', $_POST['txtfuncionario_id']);
            $this->db->set('data', $_POST['txtData']);
            $this->db->set('horaentrada1', $_POST['txthoraEntrada1']);
            $this->db->set('horasaida1', $_POST['txthoraSaida1']);
            $this->db->set('horaentrada2', $_POST['txthoraEntrada2']);
            $this->db->set('horasaida2', $_POST['txthoraSaida2']);
            $this->db->set('horaentrada3', $_POST['txthoraEntrada3']);
            $this->db->set('horasaida3', $_POST['txthoraSaida3']);

                $this->db->insert('tb_horarioindividual');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return true;
                else
                    return false;
        } catch (Exception $exc) {
            return false;
        }
    }
    
    function gravarhorariotroca() {
        try {

            $this->db->set('funcionario_id', $_POST['txtNome']);
            $this->db->set('data', $_POST['txtData']);
            $this->db->set('horaentrada1', $_POST['txthoraEntrada1']);
            $this->db->set('horasaida1', $_POST['txthoraSaida1']);
            $this->db->set('horaentrada2', $_POST['txthoraEntrada2']);
            $this->db->set('horasaida2', $_POST['txthoraSaida2']);
            $this->db->set('horaentrada3', $_POST['txthoraEntrada3']);
            $this->db->set('observacao', $_POST['txtdescricao'] . "/" . $_POST['txtNomeLabel']);
            $this->db->set('horasaida3', $_POST['txthoraSaida3']);
            $this->db->set('troca_id', $_POST['txtfuncionario_id']);

                $this->db->insert('tb_horarioindividual');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return true;
                else
                    return false;
        } catch (Exception $exc) {
            return false;
        }
    }

    
    function excluirhorarioindividual($horarioindividual_id) {

        $this->db->where('horarioindividual_id', $horarioindividual_id);
        $this->db->delete('tb_horarioindividual');
        $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return false;
                else
                    return true;
        
    }

    function listarhorariofixo($horariostipo_id=null) {
        $this->db->select();
        $this->db->from('tb_horariofixo');
        $this->db->where('horariostipo_id', $horariostipo_id);
        $this->db->orderby('dia');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosemiflexivel($horariostipo_id=null) {
        $this->db->select();
        $this->db->from('tb_horariosemiflexivel');
        $this->db->where('horariostipo_id', $horariostipo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariovariavel($horariostipo_id=null) {
        $this->db->select();
        $this->db->from('tb_horariovariavel');
        $this->db->where('horariostipo_id', $horariostipo_id);
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listartotalhoariofixo() {
        $this->db->select();
        $this->db->from('tb_horariostipo');
        $this->db->where('tipo', 'Fixo');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listartotalhoariovariavel() {
        $this->db->select();
        $this->db->from('tb_horariostipo');
        $this->db->where('tipo', 'Variavel');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listartotalhoariosemiflexivel() {
        $this->db->select();
        $this->db->from('tb_horariostipo');
        $this->db->where('tipo', 'Semiflexivel');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }
    
        function gravarviradahorariovariavel($item, $index, $horariostipo_id) {
        try {
//            var_dump($item);
//            var_dump($index);
//            die;
            /* inicia o mapeamento no banco */
            $this->db->set('horariostipo_id', $horariostipo_id);
            $this->db->set('data', $index);
            $this->db->set('horaentrada1', $item->horaentrada1);
            $this->db->set('horasaida1', $item->horasaida1);
            $this->db->set('horaentrada2', $item->horaentrada2);
            $this->db->set('horasaida2', $item->horasaida2);
            $this->db->set('horaentrada3', $item->horaentrada3);
            $this->db->set('horasaida3', $item->horasaida3);

                $this->db->insert('tb_horariofixorodado');
                $erro = $this->db->_error_message();

                if (trim($erro) != "") // erro de banco
                    return true;
                else
                    return false;
        }catch (Exception $exc) {
            return false;
        }
    }
    
        function gravarviradahorariovariavelzerado($hora, $index, $horariostipo_id) {
        try {
//            var_dump($item);
//            var_dump($index);
//            die;
            /* inicia o mapeamento no banco */
            $this->db->set('horariostipo_id', $horariostipo_id);
            $this->db->set('data', $index);
            $this->db->set('horaentrada1', $hora['horaentrada1']);
            $this->db->set('horasaida1', $hora['horasaida1']);
            $this->db->set('horaentrada2', $hora['horaentrada2']);
            $this->db->set('horasaida2', $hora['horasaida2']);
            $this->db->set('horaentrada3', $hora['horaentrada3']);
            $this->db->set('horasaida3', $hora['horasaida3']);

                $this->db->insert('tb_horariofixorodado');
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

            /* inicia o mapeamento no banco */
            $this->db->set('horariostipo_id', $_POST['txthorariostipoID']);
            $this->db->set('dia', $_POST['txtDia']);
            $this->db->set('horaentrada1', $_POST['txthoraEntrada1']);
            $this->db->set('horasaida1', $_POST['txthoraSaida1']);
            $this->db->set('horaentrada2', $_POST['txthoraEntrada2']);
            $this->db->set('horasaida2', $_POST['txthoraSaida2']);
            $this->db->set('horaentrada3', $_POST['txthoraEntrada3']);
            $this->db->set('horasaida3', $_POST['txthoraSaida3']);

                $this->db->insert('tb_horariofixo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return true;
                else
                    return false;
        } catch (Exception $exc) {
            return false;
        }
    }
    
    function gravarhorariosemiflexivel() {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('horariostipo_id', $_POST['txthorariostipoID']);
            $this->db->set('inicio', $_POST['txtinicio']);
            $this->db->set('quantidade', $_POST['txtquantidade']);
            $this->db->set('horaentrada1', $_POST['txthoraEntrada1']);
            $this->db->set('horasaida1', $_POST['txthoraSaida1']);
            $this->db->set('horaentrada2', $_POST['txthoraEntrada2']);
            $this->db->set('horasaida2', $_POST['txthoraSaida2']);
            $this->db->set('horaentrada3', $_POST['txthoraEntrada3']);
            $this->db->set('horasaida3', $_POST['txthoraSaida3']);

                $this->db->insert('tb_horariosemiflexivel');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return true;
                else
                    return false;
        } catch (Exception $exc) {
            return false;
        }
    }

    
    function excluirhorariofixo($horariofixo_id) {

        $this->db->where('horariofixo_id',$horariofixo_id);
        $this->db->delete('tb_horariofixo');
        $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return false;
                else
                    return true;
        
    }

    
    function excluirhorariosemiflexivel($horariosemiflexivel_id) {

        $this->db->where('horariosemiflexivel_id',$horariosemiflexivel_id);
        $this->db->delete('tb_horariosemiflexivel');
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
    private function instanciar($horariostipo_id) {
        if ($horariostipo_id != 0) {
            $this->db->select('nome, tipo');
            $this->db->from('tb_horariostipo');
            $this->db->where("horariostipo_id", $horariostipo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_horariostipo_id = $horariostipo_id;

            $this->_nome = $return[0]->nome;
            $this->_tipo = $return[0]->tipo;
        } else {
            $this->_horariostipo_id = null;
        }
    }

}

?>
