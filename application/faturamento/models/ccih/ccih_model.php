<?php

require_once APPPATH . 'models/base/BaseModel.php';

class Ccih_model extends BaseModel
{
    /* Método construtor */

    function Ccih_model()
    {
        parent::Model();
    }

    function listarCirrugias()
    {
        $competencia =  str_replace("/", "", $_POST['txtcompetencia']);
        $tipo = $_POST['txtclassificacao'];
        $this->db->select();
        $this->db->from('tb_cirurgico c');
        $this->db->join('tb_cirurgico_procedimento cp', 'cp.procedimento = c.procedimento');
        $this->db->where('c.data ilike',  "%" . $competencia . "%");
        if ($tipo != " "){
            $this->db->where('c.tipo ilike', $tipo . "%");
        }
        $this->db->orderby('c.procedimento');

        $return = $this->db->get();
        return $return->result();
    }

}

?>