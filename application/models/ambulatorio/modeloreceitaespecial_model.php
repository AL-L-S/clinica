<?php

class modeloreceitaespecial_model extends Model {

    var $_tb_ambulatorio_modelo_receita_especial = null;
    var $_nome = null;
    var $_medico_id = null;
    var $_texto = null;

    function Modeloreceitaespecial_model($ambulatorio_modelo_receita_especial = null) {
        parent::Model();
        if (isset($ambulatorio_modelo_receita_especial)) {
            $this->instanciar($ambulatorio_modelo_receita_especial);
        }
    }

    function listar($args = array()) {
        $this->db->select('ambulatorio_modelo_receita_especial_id,
                            aml.nome,
                            medico_id,
                            o.nome as medico,
                            texto');
        $this->db->from('tb_ambulatorio_modelo_receita_especial aml');
        $this->db->join('tb_operador o', 'o.operador_id = aml.medico_id', 'left');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('aml.nome ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('o.nome ilike', "%" . $args['nome'] . "%");
//            $this->db->orwhere('pt.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($ambulatorio_modelo_receita_especial_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_modelo_receita_especial_id', $ambulatorio_modelo_receita_especial_id);
        $this->db->update('tb_ambulatorio_modelo_receita_especial');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $ambulatorio_modelo_receita_especial_id = $_POST['ambulatorio_modelo_receita_especial_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('medico_id', $_POST['medico']);
            $this->db->set('texto', $_POST['receitaespecial']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['ambulatorio_modelo_receita_especial_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_modelo_receita_especial');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $ambulatorio_modelo_receita_especial_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('ambulatorio_modelo_receita_especial_id', $ambulatorio_modelo_receita_especial_id);
                $this->db->update('tb_ambulatorio_modelo_receita_especial');
            }
            return $ambulatorio_modelo_receita_especial_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_modelo_receita_especial_id) {
        if ($ambulatorio_modelo_receita_especial_id != 0) {
            $this->db->select('ambulatorio_modelo_receita_especial_id,
                            aml.nome,
                            medico_id,
                            o.nome as medico,
                            aml.texto');
            $this->db->from('tb_ambulatorio_modelo_receita_especial aml');
            $this->db->join('tb_operador o', 'o.operador_id = aml.medico_id', 'left');
            $this->db->where("ambulatorio_modelo_receita_especial_id", $ambulatorio_modelo_receita_especial_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_modelo_receita_especial_id = $ambulatorio_modelo_receita_especial_id;
            $this->_nome = $return[0]->nome;
            $this->_medico_id = $return[0]->medico_id;
            $this->_texto = $return[0]->texto;
        } else {
            $this->_ambulatorio_modelo_receita_especial_id = null;
        }
    }

}

?>
