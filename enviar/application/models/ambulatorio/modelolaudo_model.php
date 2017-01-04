<?php

class modelolaudo_model extends Model {

    var $_ambulatorio_modelo_laudo_id = null;
    var $_nome = null;
    var $_medico_id = null;
    var $_texto = null;
    var $_procedimento_tuss_id = null;

    function Modelolaudo_model($ambulatorio_modelo_laudo_id = null) {
        parent::Model();
        if (isset($ambulatorio_modelo_laudo_id)) {
            $this->instanciar($ambulatorio_modelo_laudo_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('ambulatorio_modelo_laudo_id,
                            aml.nome,
                            medico_id,
                            o.nome as medico,
                            texto,
                            aml.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_ambulatorio_modelo_laudo aml');
        $this->db->join('tb_operador o', 'o.operador_id = aml.medico_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = aml.procedimento_tuss_id', 'left');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('aml.nome ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('o.nome ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('pt.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($ambulatorio_modelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_modelo_laudo_id', $ambulatorio_modelo_laudo_id);
        $this->db->update('tb_ambulatorio_modelo_laudo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $ambulatorio_modelo_laudo_id = $_POST['ambulatorio_modelo_laudo_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('medico_id', $_POST['medico']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('texto', $_POST['laudo']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['ambulatorio_modelo_laudo_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_modelo_laudo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $ambulatorio_modelo_laudo_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('ambulatorio_modelo_laudo_id', $ambulatorio_modelo_laudo_id);
                $this->db->update('tb_ambulatorio_modelo_laudo');
            }
            return $ambulatorio_modelo_laudo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_modelo_laudo_id) {
        if ($ambulatorio_modelo_laudo_id != 0) {
            $this->db->select('ambulatorio_modelo_laudo_id,
                            aml.nome,
                            medico_id,
                            o.nome as medico,
                            aml.texto,
                            aml.procedimento_tuss_id,
                            pt.nome as procedimento');
            $this->db->from('tb_ambulatorio_modelo_laudo aml');
            $this->db->join('tb_operador o', 'o.operador_id = aml.medico_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = aml.procedimento_tuss_id', 'left');
            $this->db->where("ambulatorio_modelo_laudo_id", $ambulatorio_modelo_laudo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_modelo_laudo_id = $ambulatorio_modelo_laudo_id;
            $this->_nome = $return[0]->nome;
            $this->_medico_id = $return[0]->medico_id;
            $this->_texto = $return[0]->texto;
            $this->_procedimento_tuss_id = $return[0]->procedimento_tuss_id;
        } else {
            $this->_ambulatorio_modelo_laudo_id = null;
        }
    }

}

?>
