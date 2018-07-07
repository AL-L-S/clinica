<?php

class forma_model extends Model {

    var $_forma_entradas_saida_id = null;
    var $_descricao = null;
    var $_conta = null;
    var $_agencia = null;

    function Forma_model($forma_entradas_saida_id = null) {
        parent::Model();
        if (isset($forma_entradas_saida_id)) {
            $this->instanciar($forma_entradas_saida_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('c.forma_entradas_saida_id,
                            c.conta,
                            c.agencia,
                            e.nome as empresa,
                            c.descricao');
        $this->db->from('tb_forma_entradas_saida c');
        $this->db->join('tb_empresa e', 'e.empresa_id = c.empresa_id', 'left');
        $this->db->where('c.ativo', 'true');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->where('c.empresa_id', $empresa_id);
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('c.descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarforma() {
        $this->db->select('c.forma_entradas_saida_id,
                            c.descricao,
                            e.nome as empresa');
        $this->db->from('tb_forma_entradas_saida c');
        $this->db->join('tb_empresa e', 'e.empresa_id = c.empresa_id', 'left');
        $this->db->where('c.ativo', 'true');
        $this->db->orderby('c.descricao');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarformaempresa($empresa_id = null) {
        if($empresa_id == null /*|| $empresa_id == '0'*/){
            $empresa_id = $this->session->userdata('empresa_id');
        }
        $this->db->select('forma_entradas_saida_id,
                            agencia,
                            conta,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('empresa_id', (int)$empresa_id);
        $this->db->where('ativo', 'true');
        $this->db->orderby('descricao');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarautocompletecontaempresa($empresa_post_id = null) {
        $this->db->select('forma_entradas_saida_id,
                            agencia,
                            conta,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $empresa_id = $this->session->userdata('empresa_id');
        
        if($empresa_post_id != null){
           $this->db->where('empresa_id', $empresa_post_id); 
        }else{
            $this->db->where('empresa_id', $empresa_id);  
        }
        
        $this->db->where('ativo', 'true');
         $this->db->orderby('descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarforma($forma_entradas_saida_id) {
        $this->db->select('forma_entradas_saida_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_entradas_saida_id', "$forma_entradas_saida_id");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($forma_entradas_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('forma_entradas_saida_id', $forma_entradas_saida_id);
        $this->db->update('tb_forma_entradas_saida');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $forma_entradas_saida_id = $_POST['txtcadastrosformaid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $this->db->set('agencia', $_POST['txtagencia']);
            $this->db->set('conta', $_POST['txtconta']);
            $empresa_id = $this->session->userdata('empresa_id');
//            var_du
            $this->db->set('empresa_id', $empresa_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtcadastrosformaid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_forma_entradas_saida');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $forma_entradas_saida_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_forma_id = $_POST['txtcadastrosformaid'];
                $this->db->where('forma_entradas_saida_id', $forma_entradas_saida_id);
                $this->db->update('tb_forma_entradas_saida');
            }
            return $forma_entradas_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($forma_entradas_saida_id) {

        if ($forma_entradas_saida_id != 0) {
            $this->db->select('forma_entradas_saida_id, descricao, conta, agencia');
            $this->db->from('tb_forma_entradas_saida');
            $this->db->where("forma_entradas_saida_id", $forma_entradas_saida_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_forma_entradas_saida_id = $forma_entradas_saida_id;
            $this->_descricao = $return[0]->descricao;
            $this->_agencia = $return[0]->agencia;
            $this->_conta = $return[0]->conta;
        } else {
            $this->_forma_entradas_saida_id = null;
        }
    }

}

?>
