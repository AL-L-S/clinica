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
//        $this->db->orderby('versao_id');
        return $this->db;
    }

    function listardetalhesversao($versao) {

        $this->db->select('versao,
                            alteracao,
                            chamado');
        $this->db->from('tb_versao_alteracao');
        $this->db->where("versao", $versao);
//        $this->db->orderby('versao_id');
        $return = $this->db->get();
        return $return->result();
    }

}
