<?php

    /**
    * Esta classe é a responsável pela conexão com o banco de dados.
    * @author Equipe de desenvolvimento APH
    * @version 1.0
    * @copyright Prefeitura de Fortaleza
    * @access public
    * @package Model
    * @subpackage GIAH
    */
    class Suplementar_model extends Model {

        /**
        * Função construtora para setar os valores de conexão com o banco.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return void
        */
        function Suplementar_model() {
            parent::Model();
        }

        /**
        * Função para listar os valores da tabela TB_SUPLEMENTAR.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param integer $servidor_id com a informação do KEY do servidor.
        * @param string $competencia com a informação da competencia atual.
        */
        function listarSuplementarDoServidor($servidor_id, $competencia) {
            $this->db->select('su.servidor_id,
                               su.observacao,
                               su.valor,
                               su.competencia');
            $this->db->from('tb_suplementar su');
            $this->db->where('su.servidor_id', $servidor_id);
            $this->db->where('su.competencia', $competencia);
            $rs = $this->db->get()->result();
            return $rs;
        }

        /**
        * Função para inserir os valores na tabela TB_SUPLEMENTAR.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Resposta true/false da conexão com o banco
        * @param string $competencia com a informação da competencia atual
        */
        function gravar($competencia) {
            try {
                /* inicia o mapeamento no banco */
                $servidor_id    = $_POST['txtServidorID'];
                $valor          = str_replace(",", ".", str_replace(".", "", $_POST['txtValor']));
                $observacao     = $_POST['txtObservacao'];
                $this->db->set('teto_id', $_POST['txtServidorteto']);
                $this->db->set('servidor_id', $servidor_id);
                $this->db->set('competencia', $competencia);
                $this->db->set('valor', $valor);
                if (isset ($observacao)) $this->db->set('observacao', $observacao);
                $this->db->insert('tb_suplementar');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }

            } catch (Exception $exc) {
                return false;
            }

        }

        /**
        * Função para excluir um item da tabela TB_SUPLEMENTAR.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Resposta true/false da conexão com o banco
        * @param integer $servidor_id com a informação do KEY do servidor.
        * @param string $competencia com a informação da competencia atual.
        */
        function excluir($servidor_id, $competencia) {
            $this->db->where('servidor_id', $servidor_id);
            $this->db->where('competencia', $competencia);
            $this->db->delete('tb_suplementar');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
            { return false; }
            else
            { return true; }
        }

    }
?>
