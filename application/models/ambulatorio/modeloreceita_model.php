<?php

class modeloreceita_model extends Model {

    var $_ambulatorio_modelo_receita_id = null;
    var $_nome = null;
    var $_medico_id = null;
    var $_texto = null;

    function Modeloreceita_model($ambulatorio_modelo_receita_id = null) {
        parent::Model();
        if (isset($ambulatorio_modelo_receita_id)) {
            $this->instanciar($ambulatorio_modelo_receita_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('ambulatorio_modelo_receita_id,
                            aml.nome,
                            medico_id,
                            o.nome as medico,
                            texto,
                            carregar_automaticamente');
        $this->db->from('tb_ambulatorio_modelo_receita aml');
        $this->db->join('tb_operador o', 'o.operador_id = aml.medico_id', 'left');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('aml.nome ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('o.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function desativarmodeloreceitaautomatico($modelo_receita_id) {
        
        $this->db->set('carregar_automaticamente', 'f');
        $this->db->where('ambulatorio_modelo_receita_id', $modelo_receita_id);
        $this->db->update('tb_ambulatorio_modelo_receita');
        
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function ativarmodeloreceitaautomatico($modelo_receita_id) {

        $this->db->set('carregar_automaticamente', 'f');
        $this->db->update('tb_ambulatorio_modelo_receita');
        
        $this->db->set('carregar_automaticamente', 't');
        $this->db->where('ambulatorio_modelo_receita_id', $modelo_receita_id);
        $this->db->update('tb_ambulatorio_modelo_receita');
        
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluir($ambulatorio_modelo_receita_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_modelo_receita_id', $ambulatorio_modelo_receita_id);
        $this->db->update('tb_ambulatorio_modelo_receita');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $ambulatorio_modelo_receita_id = $_POST['ambulatorio_modelo_receita_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('medico_id', $_POST['medico']);
            $this->db->set('texto', $_POST['receita']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['ambulatorio_modelo_receita_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_modelo_receita');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $ambulatorio_modelo_receita_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('ambulatorio_modelo_receita_id', $ambulatorio_modelo_receita_id);
                $this->db->update('tb_ambulatorio_modelo_receita');
            }
            return $ambulatorio_modelo_receita_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_modelo_receita_id) {
        if ($ambulatorio_modelo_receita_id != 0) {
            $this->db->select('ambulatorio_modelo_receita_id,
                            aml.nome,
                            medico_id,
                            o.nome as medico,
                            aml.texto');
            $this->db->from('tb_ambulatorio_modelo_receita aml');
            $this->db->join('tb_operador o', 'o.operador_id = aml.medico_id', 'left');
            $this->db->where("ambulatorio_modelo_receita_id", $ambulatorio_modelo_receita_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_modelo_receita_id = $ambulatorio_modelo_receita_id;
            $this->_nome = $return[0]->nome;
            $this->_medico_id = $return[0]->medico_id;
            $this->_texto = $return[0]->texto;
        } else {
            $this->_ambulatorio_modelo_receita_id = null;
        }
    }

}

?>
