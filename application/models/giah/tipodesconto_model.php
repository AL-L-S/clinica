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
   class Tipodesconto_model extends Model {

        /**
        * Função construtora para setar os valores de conexão com o banco.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return void
        */
       function Tipodesconto_model() {
            parent::Model();
        }

        /**
        * Função para listar os valores da tabela TB_TIPODESCONTO.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param string $parametro com a informação do nome.
        */
        function listar($parametro=null) {
            $this->db->select('tipodesconto_id,
                            nome');
            if ($parametro != null)
            {
                $this->db->where('nome ilike', $parametro . "%");
            }
            $return = $this->db->get('tb_tipodesconto');
            return $return->result();
        }

    }
?>