<?php

class modelomedicamento_model extends Model {

    var $_ambulatorio_modelo_medicamento_id = null;
    var $_nome = null;
    var $_medico_id = null;
    var $_texto = null;

    function Modelomedicamento_model($ambulatorio_modelo_medicamento_id = null) {
        parent::Model();
        if (isset($ambulatorio_modelo_medicamento_id)) {
            $this->instanciar($ambulatorio_modelo_medicamento_id);
        }
    }

    function listar($args = array()) {
//        DIE;
        $this->db->select('arm.ambulatorio_receituario_medicamento_id as medicamento_id,
                           arm.nome,
                           o.nome as medico,
                           arm.texto');
        $this->db->from('tb_ambulatorio_receituario_medicamento arm');
        $this->db->join('tb_operador o', 'o.operador_id = arm.medico_id', 'left');
        $this->db->where('arm.ativo', "t");
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('arm.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarunidade($args = array()) {
        $this->db->select('amu.ambulatorio_receituario_medicamento_unidade_id as unidade_id,
                           amu.descricao');
        $this->db->from('tb_ambulatorio_receituario_medicamento_unidade amu');
        $this->db->where('amu.ativo', "t");
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('amu.descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function excluir($ambulatorio_modelo_medicamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_modelo_medicamento_id', $ambulatorio_modelo_medicamento_id);
        $this->db->update('tb_ambulatorio_modelo_medicamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirunidade($unidade_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_receituario_medicamento_unidade_id', $unidade_id);
        $this->db->update('tb_ambulatorio_receituario_medicamento_unidade');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        
        $this->db->set('nome', $_POST['txtmedicamento']);
        $this->db->set('quantidade', $_POST['qtde']);
        $this->db->set('unidade_id', $_POST['unidadeid']);
        $this->db->set('posologia', $_POST['posologia']);
        $this->db->set('texto', $_POST['txtmedicamento'] . ' ----- ' . $_POST['qtde'] . ' ----- ' . $_POST['unidade'] );
        $this->db->set('medico_id', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_receituario_medicamento');
    }

    function gravarunidade() {
        try {
            /* inicia o mapeamento no banco */
            $unidade_id = $_POST['txtunidadeid'];
            $this->db->set('descricao', $_POST['txtDescricao']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtunidadeid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_receituario_medicamento_unidade');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $unidade_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('ambulatorio_receituario_medicamento_unidade_id', $unidade_id);
                $this->db->update('tb_ambulatorio_receituario_medicamento_unidade');
            }
            return $unidade_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function carregarunidade($unidade_id) {
        if ($unidade_id != 0) {
            $this->db->select('amu.ambulatorio_receituario_medicamento_unidade_id as unidade_id,
                               amu.descricao');
            $this->db->from('tb_ambulatorio_receituario_medicamento_unidade amu');
            $this->db->where("ambulatorio_receituario_medicamento_unidade_id", $unidade_id);
            $query = $this->db->get();
            $return = $query->result();
        } else {
            $return = null;
        }
        return $return;
    }

    private function instanciar($ambulatorio_modelo_medicamento_id) {
        if ($ambulatorio_modelo_medicamento_id != 0) {
            $this->db->select('ambulatorio_receituario_medicamento_id,
                            amr.nome,
                            medico_id,
                            o.nome as medico,
                            amr.texto');
            $this->db->from('tb_ambulatorio_modelo_medicamento amr');
            $this->db->join('tb_operador o', 'o.operador_id = amr.medico_id', 'left');
            $this->db->where("ambulatorio_receituario_medicamento_id", $ambulatorio_modelo_medicamento_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_ambulatorio_modelo_medicamento_id = $ambulatorio_modelo_medicamento_id;
            $this->_nome = $return[0]->nome;
            $this->_medico_id = $return[0]->medico_id;
            $this->_texto = $return[0]->texto;
        } else {
            $this->_ambulatorio_modelo_medicamento_id = null;
        }
    }

}

?>
