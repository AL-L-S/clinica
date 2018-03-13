<?php

class grupoclassificacao_model extends Model {

    var $_classificacao_grupo_id = null;
    var $_nome = null;

    function Grupoclassificacao_model($classificacao_grupo_id = null) {
        parent::Model();
        if (isset($classificacao_grupo_id)) {
            $this->instanciar($classificacao_grupo_id);
        }
    }

    function listar($args = array()) {

        $this->db->select('classificacao_grupo_id,
                            nome');
        $this->db->from('tb_classificacao_grupo');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        $this->db->where('ativo', 't');
        return $this->db;
    }
    
    function listarsubgrupo($args = array()) {

        $this->db->select('ambulatorio_subgrupo_id,
                            nome');
        $this->db->from('tb_ambulatorio_subgrupo');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        $this->db->where('ativo', 't');
        return $this->db;
    }
    
    function listargrupo($args = array()) {

        $this->db->select('ambulatorio_grupo_id,
                           nome');
        $this->db->from('tb_ambulatorio_grupo');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarassociacaosubgrupo($grupo) {

        $this->db->select(' asg.ambulatorio_subgrupo_grupo_id,
                            sub.nome as subgrupo,
                            asg.grupo');
        $this->db->from('tb_ambulatorio_subgrupo_grupo asg');
        $this->db->join('tb_ambulatorio_subgrupo sub', 'sub.ambulatorio_subgrupo_id = asg.subgrupo_id', 'left');
        $this->db->where('asg.grupo', $grupo);
        $this->db->where('asg.ativo', 't');
//        $this->db->orderby('as.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsubgrupo2($args = array()) {

        $this->db->select('ambulatorio_subgrupo_id,
                            nome');
        $this->db->from('tb_ambulatorio_subgrupo');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupoclassificacaos() {

        $this->db->select('classificacao_grupo_id,
                            nome');
        $this->db->from('tb_classificacao_grupo');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function instanciarsubgrupo($subgrupo_id) {

        $this->db->select('ambulatorio_subgrupo_id,
                            nome');
        $this->db->from('tb_ambulatorio_subgrupo');
        $this->db->where('ambulatorio_subgrupo_id', $subgrupo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupoclassificacao($classificacao_grupo_id) {

        $this->db->select('classificacao_grupo_id,
                            nome');
        $this->db->from('tb_classificacao_grupo');
        $this->db->where('exame_grupoclassificacao_id', $classificacao_grupo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupoclassificacaoadicionar($classificacao_grupo_id) {

        $this->db->select('classificacao_grupo_id,
                            o.nome as operador,
                            classificacao_grupo_associar_id,
                            opm.operador_id');
        $this->db->from('tb_classificacao_grupo_associar opm');
        $this->db->join('tb_tuss_classificacao o', 'o.tuss_classificacao_id = opm.operador_id');
        $this->db->where('classificacao_grupo_id', $classificacao_grupo_id);
        $this->db->where('opm.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listargrupoclassificacaoadicionarteste() {

        $this->db->select('classificacao_grupo_id,
                            o.nome as operador,
                            opm.operador_id');
        $this->db->from('tb_classificacao_grupo_associar opm');
         $this->db->join('tb_tuss_classificacao o', 'o.tuss_classificacao_id = opm.operador_id');
        $this->db->where('classificacao_grupo_id', $_POST['grupoclassificacaoid']);
        $this->db->where('opm.operador_id', $_POST['classificacao']);
        $return = $this->db->get();
        return $return->result();
    }

    function excluirassociacaosubgrupo($associacaoSubgrupoId) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_subgrupo_grupo_id', $associacaoSubgrupoId);
        $this->db->update('tb_ambulatorio_subgrupo_grupo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirsubgrupo($subgrupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_subgrupo_id', $subgrupo_id);
        $this->db->update('tb_ambulatorio_subgrupo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluir($classificacao_grupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('classificacao_grupo_id', $classificacao_grupo_id);
        $this->db->update('tb_classificacao_grupo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }
    
    function excluirclassificacaogrupo($classificacao_grupo_associar_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
//        $this->db->where('operador_id', $operador_excluir_id);
        $this->db->where('classificacao_grupo_associar_id', $classificacao_grupo_associar_id);
        $this->db->update('tb_classificacao_grupo_associar');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarsubgrupo() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['ambulatorio_subgrupo_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_subgrupo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $classificacao_grupo_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $subgrupo_id = $_POST['ambulatorio_subgrupo_id'];
                $this->db->where('ambulatorio_subgrupo_id', $subgrupo_id);
                $this->db->update('tb_ambulatorio_subgrupo');
            }
            return $classificacao_grupo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarassociacaosubgrupo() {
        try {
            $grupo = $_POST['grupo'];
            $subgrupo_id = $_POST['subgrupo_id'];
            
            /* inicia o mapeamento no banco */
            $this->db->select('asg.ambulatorio_subgrupo_grupo_id');
            $this->db->from('tb_ambulatorio_subgrupo_grupo asg');
            $this->db->where('asg.grupo', $grupo);
            $this->db->where('asg.subgrupo_id', $subgrupo_id);
            $this->db->where('asg.ativo', 't');
            $return = $this->db->get()->result();
            
            if( count($return) == 0 ){
            
                $this->db->set('grupo', $grupo);
                $this->db->set('subgrupo_id', $subgrupo_id);
            
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_subgrupo_grupo');
                return 1;
            } else{
              return -2;  
            }
            
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $classificacao_grupo_id = $_POST['grupoclassificacaoid'];
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['grupoclassificacaoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_classificacao_grupo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $classificacao_grupo_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $classificacao_grupo_id = $_POST['grupoclassificacaoid'];
                $this->db->where('classificacao_grupo_id', $classificacao_grupo_id);
                $this->db->update('tb_classificacao_grupo');
            }
            return $classificacao_grupo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaradicionar() {
        try {
            /* inicia o mapeamento no banco */
            $classificacao_grupo_id = $_POST['grupoclassificacaoid'];
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('classificacao_grupo_id', $classificacao_grupo_id);
            $this->db->update('tb_classificacao_grupo');

//            die;
            if($_POST['classificacao'] != '') {
                $this->db->set('operador_id', $_POST['classificacao']);
                $this->db->set('classificacao_grupo_id', $classificacao_grupo_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_classificacao_grupo_associar');
            }
            return $classificacao_grupo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($classificacao_grupo_id) {

        if ($classificacao_grupo_id != 0) {
            $this->db->select('classificacao_grupo_id, nome');
            $this->db->from('tb_classificacao_grupo');
            $this->db->where("classificacao_grupo_id", $classificacao_grupo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_classificacao_grupo_id = $classificacao_grupo_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_classificacao_grupo_id = null;
        }
    }

}

?>
