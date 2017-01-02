<?php

    class Classificacao_model extends Model {

        function Classificacao_model() {
            parent::Model();
        }

        function listar($parametro=null) {
            $this->db->select('classificacao_id,
                            nome
                            ');
            $this->db->from('tb_classificacao');
            if ($parametro != null)
            {
                $this->db->where('nome ilike', $parametro . "%");
            }
            $query = $this->db->get();
            $return = $query->result();
            return $return;
        }

    }
?>