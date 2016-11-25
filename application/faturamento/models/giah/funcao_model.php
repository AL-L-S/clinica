<?php

    class Funcao_model extends Model {

        function Funcao_model() {
            parent::Model();
        }

        function listar($parametro=null) {
            $this->db->select('funcao_id,
                            nome
                            ');
            if ($parametro != null)
            {
                $this->db->where('nome ilike', $parametro . "%");
            }
            $return = $this->db->get('tb_funcao');
            return $return->result();
        }

    }
?>