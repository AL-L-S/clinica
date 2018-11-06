<?php

class produto_model extends Model {

    var $_farmacia_produto_id = null;
    var $_descricao = null;
    var $_unidade_id = null;
    var $_unidade = null;
    var $_sub_classe_id = null;
    var $_sub_classe = null;
    var $_valor_compra = null;
    var $_valor_venda = null;
    var $_farmacia_minimo = null;

    function Produto_model($farmacia_produto_id = null) {
        parent::Model();
        if (isset($farmacia_produto_id)) {
            $this->instanciar($farmacia_produto_id);
        }
    }


    function listar($args = array()) {
        $this->db->select('p.farmacia_produto_id,
                            p.descricao,
                            p.unidade_id,
                            u.descricao as unidade,
                            p.sub_classe_id,
                            sc.descricao as sub_classe,
                            p.valor_compra');
        $this->db->from('tb_farmacia_produto p');
        $this->db->join('tb_farmacia_sub_classe sc', 'sc.farmacia_sub_classe_id = p.sub_classe_id', 'left');
        $this->db->join('tb_farmacia_unidade u', 'u.farmacia_unidade_id = p.unidade_id', 'left');
        $this->db->where('p.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarsub() {
        $this->db->select('sc.farmacia_sub_classe_id,
                            sc.descricao');
        $this->db->from('tb_farmacia_sub_classe sc');
        $this->db->where('sc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarunidade() {
        $this->db->select('farmacia_unidade_id,
                            descricao');
        $this->db->from('tb_farmacia_unidade');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($farmacia_produto_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_produto_id', $farmacia_produto_id);
        $this->db->update('tb_farmacia_produto');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function listarprocedimentos() {
        $this->db->select('pt.procedimento_tuss_id,
                           pt.codigo,
                           pt.nome');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->where('pt.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $farmacia_produto_id = $_POST['txtfarmaciaprodutoid'];
            $this->db->set('descricao', $_POST['nome']);
            $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
            $this->db->set('valor_venda', str_replace(",", ".", str_replace(".", "", $_POST['venda'])));
            $this->db->set('farmacia_minimo', $_POST['minimo']);
            $this->db->set('quantidade_unitaria', $_POST['quantidade']);
            if($_POST['procedimentoID'] > 0){
                $this->db->set('procedimento_tuss_id', $_POST['procedimentoID']);
            }
            $this->db->set('unidade_id', $_POST['unidade']);
            $this->db->set('sub_classe_id', $_POST['sub']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtfarmaciaprodutoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_farmacia_produto');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $farmacia_produto_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('farmacia_produto_id', $farmacia_produto_id);
                $this->db->update('tb_farmacia_produto');
            }
            return $farmacia_produto_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($farmacia_produto_id) {
        if ($farmacia_produto_id != 0) {
            $this->db->select('p.farmacia_produto_id,
                            p.descricao,
                            p.unidade_id,
                            p.procedimento_tuss_id,
                            p.quantidade_unitaria,
                            u.descricao as unidade,
                            p.sub_classe_id,
                            sc.descricao as sub_classe,
                            p.valor_compra,
                            p.valor_venda,
                            p.farmacia_minimo');
            $this->db->from('tb_farmacia_produto p');
            $this->db->join('tb_farmacia_sub_classe sc', 'sc.farmacia_sub_classe_id = p.sub_classe_id', 'left');
            $this->db->join('tb_farmacia_unidade u', 'u.farmacia_unidade_id = p.unidade_id', 'left');
            $this->db->where("farmacia_produto_id", $farmacia_produto_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_farmacia_produto_id = $farmacia_produto_id;
            $this->_descricao = $return[0]->descricao;
            $this->_unidade_id = $return[0]->unidade_id;
            $this->_procedimento_tuss_id = $return[0]->procedimento_tuss_id;
            $this->_quantidade_unitaria = $return[0]->quantidade_unitaria;
            $this->_unidade = $return[0]->unidade;
            $this->_sub_classe_id = $return[0]->sub_classe_id;
            $this->_sub_classe = $return[0]->sub_classe;
            $this->_valor_compra = $return[0]->valor_compra;
            $this->_valor_venda = $return[0]->valor_venda;
            $this->_farmacia_minimo = $return[0]->farmacia_minimo;
        } else {
            $this->_farmacia_produto_id = null;
        }
    }

}

?>
