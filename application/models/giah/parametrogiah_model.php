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
    class Parametrogiah_model extends Model {

        /* Métodoo construtor */

        /**
        * Função construtora para setar os valores de conexão com o banco.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return void
        */
        function Parametrogiah_model() {
            parent::Model();
        }

        /**
        * Função para listar os valores da tabela TB_COMPETENCIA.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param string $ano com a informação do ano/mês.
        */
        function listar($ano) {
            $this->db->select(" com.competencia,
                                par.competencia AS competencia_id,
                                par.valor_sih,
                                par.valor_aih,
                                par.valor_cib,
                                (par.valor_sih + par.valor_aih +
                                par.valor_cib) AS soma");
            $this->db->from("tb_competencia com");
            $this->db->join("tb_parametrogiah par", "par.competencia = com.competencia", "left");
            //$this->db->where("com.competencia like '". $ano . "%'");
            $this->db->orderby("com.competencia");
            return $this->db->get()->result();
        }

        /**
        * Função para gravar valores na tabela TB_PARAMETROGIAH.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Resposta true/false da conexão com o banco
        */
        function gravar($competencia) {
            try {
                /* inicia o mapeamento no banco */
                $this->db->set('competencia', $competencia);
                $this->db->set('valor_sih', str_replace(",", ".",str_replace(".", "", $_POST['txtValor_sih'])));
                $this->db->set('valor_aih', str_replace(",", ".",str_replace(".", "", $_POST['txtValor_aih'])));
                $this->db->set('valor_cib', str_replace(",", ".",str_replace(".", "", $_POST['txtValor_cib'])));

                $this->db->insert('tb_parametrogiah');
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
        * Função para excluir os valores da tabela TB_PARAMETROGIAH.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Resposta true/false da conexão com o banco
        * @param string $competencia com a informação da competencia atual.
        */
        function excluir($competencia) {
            try {
                $this->db->where('competencia', $competencia);
                $this->db->delete('tb_parametrogiah');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }
            } catch (Exception $exc) {
                return false;
            }


        }

    }
?>