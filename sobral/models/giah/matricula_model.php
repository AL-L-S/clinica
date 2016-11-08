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
class Matricula_model extends Model {

                /**
        * Função construtora para setar os valores de conexão com o banco.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return void
        */
        function Matricula_model() {
            parent::Model();
        }

        /**
        * Função para listar os valores da tabela TB_SUPLEMENTAR.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param string $parametro com a informação da matricula.
        */
        function listar($parametro=null) {
            $this->db->select('servidor_id,
                            matricula
                            ');
            if ($parametro != null)
            {
                $return = $this->db->where('matricula ilike', $parametro);
            }
            $return = $this->db->get('tb_servidor');
            return $return->result();
        }

    }
?>