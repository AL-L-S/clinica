<?php

class grupoconta_model extends Model {

    var $_conta_grupo_id = null;
    var $_nome = null;

    function Grupoconta_model($conta_grupo_id = null) {
        parent::Model();
        if (isset($conta_grupo_id)) {
            $this->instanciar($conta_grupo_id);
        }
    }

    function listar($args = array()) {

        $this->db->select('conta_grupo_id,
                            nome');
        $this->db->from('tb_conta_grupo');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        $this->db->where('ativo', 't');
        return $this->db;
    }

//    function listargrupomedicos() {
//
//        $this->db->select('operador_grupo_id,
//                            nome');
//        $this->db->from('tb_operador_grupo');
//        $this->db->where('ativo', 't');
//        $this->db->orderby('nome');
//        $return = $this->db->get();
//        return $return->result();
//    }
//
//    function listargrupomedico($operador_grupo_id) {
//
//        $this->db->select('operador_grupo_id,
//                            nome');
//        $this->db->from('tb_operador_grupo');
//        $this->db->where('exame_grupomedico_id', $operador_grupo_id);
//        $return = $this->db->get();
//        return $return->result();
//    }

    function listargrupocontaadicionar($grupoconta_id) {

        $this->db->select('cpc.conta_grupo_id,
                            f.descricao,
                            e.nome,
                            cpc.conta_grupo_contas_id,
                            cpc.conta_id');
        $this->db->from('tb_conta_grupo_contas cpc');
        $this->db->join('tb_forma_entradas_saida f', 'f.forma_entradas_saida_id = cpc.conta_id');
        $this->db->join('tb_empresa e', 'e.empresa_id = f.empresa_id', 'left');
        $this->db->where('conta_grupo_id', $grupoconta_id);
        $this->db->where('cpc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listargrupocontaadicionarteste() {

        $this->db->select('cpc.conta_grupo_id,
                            f.forma_entradas_saida_id,
                            cpc.conta_id');
        $this->db->from('tb_conta_grupo_contas cpc');
        $this->db->join('tb_forma_entradas_saida f', 'f.forma_entradas_saida_id = cpc.conta_id');
        $this->db->where('cpc.conta_grupo_id', $_POST['grupocontaid']);
        $this->db->where('cpc.conta_id', $_POST['conta']);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($conta_grupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('conta_grupo_id', $conta_grupo_id);
        $this->db->update('tb_conta_grupo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }
    
    function excluircontagrupo($conta_grupo_contas_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
//        $this->db->where('operador_id', $operador_excluir_id);
        $this->db->where('conta_grupo_contas_id', $conta_grupo_contas_id);
        $this->db->update('tb_conta_grupo_contas');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $conta_grupo_id = $_POST['grupocontaid'];
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['grupocontaid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_conta_grupo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $conta_grupo_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $conta_grupo_id = $_POST['grupocontaid'];
                $this->db->where('conta_grupo_id', $conta_grupo_id);
                $this->db->update('tb_conta_grupo');
            }
            return $conta_grupo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaradicionar() {
        try {
            /* inicia o mapeamento no banco */
            $conta_grupo_id = $_POST['grupocontaid'];
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('conta_grupo_id', $conta_grupo_id);
            $this->db->update('tb_conta_grupo');


            if($_POST['conta'] != '') {
                $this->db->set('conta_id', $_POST['conta']);
                $this->db->set('conta_grupo_id', $conta_grupo_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_conta_grupo_contas');
            }
            return $conta_grupo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($conta_grupo_id) {

        if ($conta_grupo_id != 0) {
            $this->db->select('conta_grupo_id, nome');
            $this->db->from('tb_conta_grupo');
            $this->db->where("conta_grupo_id", $conta_grupo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_conta_grupo_id = $conta_grupo_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_conta_grupo_id = null;
        }
    }

}

?>

