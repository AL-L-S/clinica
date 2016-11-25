<?php

class versao_model extends Model {

    function Empresa_model($versao_id = null) {
        parent::Model();
        if (isset($versao_id)) {
            $this->instanciar($versao_id);
        }
    }

    function listar() {

        $this->db->select('versao_id,
                            sistema,
                            banco_de_dados');
        $this->db->from('tb_versao');

        return $this->db;
    }

}
