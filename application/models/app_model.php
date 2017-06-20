<?php

class app_model extends Model {

    function App_model($ambulatorio_pacientetemp_id = null) {
        parent::Model();
    }

    function validaUsuario() {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('usuario', $_GET['usuario']);
        $this->db->where('senha', md5($_GET['pw']));
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

}

?>
