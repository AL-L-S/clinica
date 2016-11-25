<?php

class Importarponto_model extends Model {

    var $_cargo_id = null;
    var $_nome = null;
    var $_sigla = null;

    function Importarponto_model($cargo_id=null) {
        parent::Model();
        if (isset($cargo_id)) {
            $this->instanciar($cargo_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('cargo_id,
                            nome,
                            sigla');
        $this->db->from('tb_cargo');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravarPonos($data, $hora, $matricula) {
        try {
            //$datacorrigida = substr($data, 3, 3) . substr($data, 0, 3) . substr($data, 6, 2);
            
            //$datahora= $datacorrigida . " " . $hora;
            $datahora= $data . " " . $hora;
            $matricula = trim($matricula);
            $matricula = str_replace(",", "",$matricula);
            $matricula = $matricula*1;
            /* inicia o mapeamento no banco */
            $this->db->set('data_batida', $datahora);
            $this->db->set('matricula', $matricula);

                $this->db->insert('tb_pontosimportados');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return false;
                else
                    return true;


        } catch (Exception $exc) {
            return false;
        }
    }
    
    function gravarbatidas($data, $hora, $matricula) {
        try {
            //$datacorrigida = substr($data, 3, 3) . substr($data, 0, 3) . substr($data, 6, 2);
            
            //$datahora= $datacorrigida . " " . $hora;
            $datahora= $data . " " . $hora;
            $matricula = trim($matricula);
            $matricula = str_replace(",", "",$matricula);
            $matricula = $matricula*1;
            /* inicia o mapeamento no banco */
            $this->db->set('data_batida', $datahora);
            $this->db->set('matricula', $matricula);

                $this->db->insert('tb_batidasimportadas');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return false;
                else
                    return true;


        } catch (Exception $exc) {
            return false;
        }
    }

    function excluir($cargo_id) {

        $this->db->set('ativo', 'f');
        $this->db->where('cargo_id', $cargo_id);
        $this->db->update('tb_cargo');
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
    private function instanciar($cargo_id) {
        if ($cargo_id != 0) {
            $this->db->select('nome,
                            sigla');
            $this->db->from('tb_cargo');
            $this->db->where("cargo_id", $cargo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_cargo_id = $cargo_id;
            if (isset($return[0]->sigla)) : $this->_sigla = $return[0]->sigla;
            else : $this->sigla = "";
            endif;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_servidor_id = null;
        }
    }

}

?>