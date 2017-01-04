<?php

class Funcao_model extends Model {

    var $_funcao_id = null;
    var $_nome = null;
    var $_sigla = null;

    function Funcao_model($funcao_id=null) {
        parent::Model();
        if (isset($funcao_id)) {
            $this->instanciar($funcao_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('funcao_id,
                            nome,
                            sigla');
        $this->db->from('tb_funcao');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarautocomplete($parametro=null) {
        $this->db->select('funcao_id,
                            nome,
                            sigla');
        $this->db->from('tb_funcao');
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
            $funcao_id = $_POST['txtFuncaoID'];
            $this->db->set('nome', $_POST['txtNome']);
            if (isset($_POST['txtSIGLA']))
                $this->db->set('sigla', $_POST['txtSIGLA']);

            if ($_POST['txtFuncaoID'] == "") {// insert
                $this->db->insert('tb_funcao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $funcao_id = $this->db->insert_id();
            }
            else { // update
                $funcao_id = $_POST['txtFuncaoID'];
                $this->db->where('funcao_id', $funcao_id);
                $this->db->update('tb_funcao');
            }

            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluir($funcao_id) {

        $this->db->set('ativo', 'f');
        $this->db->where('funcao_id', $funcao_id);
        $this->db->update('tb_funcao');
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
    private function instanciar($funcao_id) {
        if ($funcao_id != 0) {
            $this->db->select('nome,
                            sigla');
            $this->db->from('tb_funcao');
            $this->db->where("funcao_id", $funcao_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_funcao_id = $funcao_id;
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