<?php

class Ocorrencia_model extends Model {

    var $_ocorrencia_id = null;
    var $_ocorrenciatipo_id = null;
    var $_diainicio = null;
    var $_diafim = null;
    var $_observacao = null;
    var $_funcionario_id = null;

    function Ocorrencia_model($ocorrencia_id = null) {
        parent::Model();
        if (isset($ocorrencia_id)) {
            $this->instanciar($ocorrencia_id);
        }
    }

    function listar($funcionario_id, $competenciaativa) {
        $this->db->select('o.ocorrencia_id,
                            o.ocorrenciatipo_id,
                            o.diainicio,
                            o.diafim,
                            o.observacao,
                            ot.nome,
                            o.funcionario_id');
        $this->db->from('tb_ocorrencia o');
        $this->db->join('tb_ocorrenciatipo ot', 'ot.ocorrenciatipo_id = o.ocorrenciatipo_id');
        $this->db->where('funcionario_id', $funcionario_id);
        $this->db->where('o.competencia', $competenciaativa);
        $rs = $this->db->get()->result();
        return $rs;
    }

    function listarocorrencias($competenciaativa) {
        $this->db->select('o.ocorrencia_id,
                            o.ocorrenciatipo_id,
                            o.diainicio,
                            o.diafim,
                            o.observacao,
                            ot.nome,
                            f.matricula,
                            o.funcionario_id');
        $this->db->from('tb_ocorrencia o');
        $this->db->join('tb_ocorrenciatipo ot', 'ot.ocorrenciatipo_id = o.ocorrenciatipo_id');
        $this->db->join('tb_funcionario f', 'f.funcionario_id = o.funcionario_id');
        $this->db->where('competencia', $competenciaativa);
        $rs = $this->db->get()->result();
        return $rs;
    }

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravar($competenciaativa) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('ocorrenciatipo_id', $_POST['txtnome']);
            $this->db->set('competencia', $competenciaativa);
            $this->db->set('diainicio', $_POST['txtDatainicio']);
            $this->db->set('diafim', $_POST['txtDatafim']);
            $this->db->set('observacao', $_POST['txtobservacao']);
            $this->db->set('funcionario_id', $_POST['txtfuncionario_id']);
            //$this->db->set('competencia', $_POST['txtNome']);

            $this->db->insert('tb_ocorrencia');
            $erro = $this->db->_error_message();


            return true;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function processarocorrencia($critica, $data, $matricula) {

        /* inicia o mapeamento no banco */
        $this->db->set('critica1', $critica);
        $this->db->where('data', $data);
        $this->db->where('matricula', $matricula);
        $this->db->update('tb_criticafinal');
    }

    function excluir($ocorrencia_id) {

        $this->db->where('ocorrencia_id', $ocorrencia_id);
        $this->db->delete('tb_ocorrencia');
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
    private function instanciar($ocorrencia_id) {
        if ($ocorrencia_id != 0) {
            $this->db->select('o.ocorrencia_id,
                            o.ocorrenciatipo_id,
                            o.diainicio,
                            o.diafim,
                            o.observacao,
                            ot.nome,
                            o.competencia,
                            o.funcionario_id');
            $this->db->from('tb_ocorrencia o');
            $this->db->join('tb_ocorrenciatipo ot', 'ot.ocorrenciatipo_id = o.ocorrenciatipo_id');
            $this->db->where("ocorrencia_id", $ocorrencia_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ocorrencia_id = $ocorrencia_id;
            $this->_ocorrenciatipo_id = $return[0]->ocorrenciatipo_id;
            $this->_diainicio = $return[0]->diainicio;
            $this->_diafim = $return[0]->diafim;
            $this->_observacao = $return[0]->observacao;
            $this->_nome = $return[0]->nome;
            $this->_competencia = $return[0]->competencia;
            $this->_funcionario_id = $return[0]->funcionario_id;
        } else {
            $this->_funcionario_id = null;
        }
    }

}

?>