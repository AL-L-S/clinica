<?php

class Ocorrenciatipo_model extends Model {

    var $_funcao_id = null;
    var $_nome = null;
    var $_sigla = null;

    function Ocorrenciatipo_model($ocorrenciatipo_id=null) {
        parent::Model();
        if (isset($ocorrenciatipo_id)) {
            $this->instanciar($ocorrenciatipo_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('ocorrenciatipo_id,
                            nome');
        $this->db->from('tb_ocorrenciatipo');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarautocomplete($parametro=null) {
        $this->db->select('ocorrenciatipo_id,
                            nome');
        $this->db->from('tb_ocorrenciatipo');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
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
            $ocorrenciatipo_id = $_POST['txtOcorrenciatipoID'];
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['txtOcorrenciatipoID'] == "") {// insert
                $this->db->insert('tb_ocorrenciatipo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $ocorrenciatipo_id = $this->db->insert_id();
            }
            else { // update
                $ocorrenciatipo_id = $_POST['txtOcorrenciatipo'];
                $this->db->where('ocorrenciatipo_id', $ocorrenciatipo_id);
                $this->db->update('tb_ocorrenciatipo');
            }

            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluir($ocorrenciatipo_id) {

        $this->db->set('ativo', 'f');
        $this->db->where('ocorrenciatipo_id', $ocorrenciatipo_id);
        $this->db->update('tb_ocorrenciatipo');
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
    private function instanciar($ocorrenciatipo_id) {
        if ($ocorrenciatipo_id != 0) {
            $this->db->select('nome');
            $this->db->from('tb_ocorrenciatipo');
            $this->db->where("ocorrenciatipo_id", $ocorrenciatipo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ocorrenciatipo_id = $ocorrenciatipo_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_ocorrenciatipo_id = null;
        }
    }

}

?>