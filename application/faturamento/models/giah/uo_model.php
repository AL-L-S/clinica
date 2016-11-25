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
class Uo_model extends Model {

    /**
    * Função construtora para setar os valores de conexão com o banco.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    */
    function Uo_model() {
        parent::Model();
    }

    /**
    * Função para listar os valores da tabela TB_UO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param string $parametro com a informação do nome ou sigla.
    */
    function listar($parametro=null) {
        $this->db->select('uo_id,
                            nome,
                            sigla');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
            $this->db->orwhere('sigla ilike', $parametro . "%");
        }
        $return = $this->db->get('tb_uo');
        return $return->result();
    }

    /**
    * Função para listar as diretorias cadastradas na tabela TB_UO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param string $parametro com a informação do nome ou sigla.
    */
    function listarTeto($parametro=null) {
        $this->db->select('uo_id,
                            nome,
                            uo_hierarquia,
                            sigla');
        if ($parametro != null) {
            $this->db->where('uo_hierarquia in (0,1)');
            $this->db->where('nome ilike', $parametro . "%");
            $this->db->orwhere('sigla ilike', $parametro . "%");
        }
        $return = $this->db->get('tb_uo');
        return $return->result();
    }

}

?>