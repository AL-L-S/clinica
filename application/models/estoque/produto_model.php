<?php

class produto_model extends Model {

    var $_estoque_produto_id = null;
    var $_descricao = null;
    var $_unidade_id = null;
    var $_unidade = null;
    var $_sub_classe_id = null;
    var $_sub_classe = null;
    var $_valor_compra = null;
    var $_valor_venda = null;
    var $_estoque_minimo = null;

    function Produto_model($estoque_produto_id = null) {
        parent::Model();
        if (isset($estoque_produto_id)) {
            $this->instanciar($estoque_produto_id);
        }
    }

    function autocompleteproduto($parametro = null) {
        $this->db->select('estoque_produto_id,
                           descricao');
        if ($parametro != null) {
            $this->db->where('descricao ilike', $parametro . "%");
        }
        $this->db->where('ativo', 't');
        $this->db->from('tb_estoque_produto');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $this->db->select('p.estoque_produto_id,
                            p.descricao,
                            p.unidade_id,
                            u.descricao as unidade,
                            p.sub_classe_id,
                            sc.descricao as sub_classe,
                            p.valor_compra');
        $this->db->from('tb_estoque_produto p');
        $this->db->join('tb_estoque_sub_classe sc', 'sc.estoque_sub_classe_id = p.sub_classe_id', 'left');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = p.unidade_id', 'left');
        $this->db->where('p.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.descricao ilike', "%" . $args['nome'] . "%");
        }

        return $this->db;
    }

    function listarsub() {
        $this->db->select('sc.estoque_sub_classe_id,
                            sc.descricao');
        $this->db->from('tb_estoque_sub_classe sc');
        $this->db->where('sc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarunidade() {
        $this->db->select('estoque_unidade_id,
                            descricao');
        $this->db->from('tb_estoque_unidade');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_produto_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_produto_id', $estoque_produto_id);
        $this->db->update('tb_estoque_produto');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function listarprocedimentos() {
        $this->db->select('pt.procedimento_tuss_id,
                           pt.nome');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->where('pt.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_produto_id = $_POST['txtestoqueprodutoid'];
            $this->db->set('descricao', $_POST['nome']);
            $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
            $this->db->set('valor_venda', str_replace(",", ".", str_replace(".", "", $_POST['venda'])));
            $this->db->set('estoque_minimo', $_POST['minimo']);
            $this->db->set('unidade_id', $_POST['unidade']);
            $this->db->set('sub_classe_id', $_POST['sub']);
            if($_POST['procedimentoID'] != ''){
                $this->db->set('procedimento_id', $_POST['procedimentoID']);
            }
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoqueprodutoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_produto');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_produto_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('estoque_produto_id', $estoque_produto_id);
                $this->db->update('tb_estoque_produto');
            }
            return $estoque_produto_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_produto_id) {
        if ($estoque_produto_id != 0) {
            $this->db->select('p.estoque_produto_id,
                            p.descricao,
                            p.unidade_id,
                            pt.nome as procedimento,
                            pt.procedimento_tuss_id,
                            u.descricao as unidade,
                            p.sub_classe_id,
                            sc.descricao as sub_classe,
                            p.valor_compra,
                            p.valor_venda,
                            p.estoque_minimo');
            $this->db->from('tb_estoque_produto p');
            $this->db->join('tb_estoque_sub_classe sc', 'sc.estoque_sub_classe_id = p.sub_classe_id', 'left');
            $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = p.unidade_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = p.procedimento_id', 'left');
            $this->db->where("estoque_produto_id", $estoque_produto_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_produto_id = $estoque_produto_id;
            $this->_descricao = $return[0]->descricao;
            $this->_unidade_id = $return[0]->unidade_id;
            $this->_unidade = $return[0]->unidade;
            $this->_procedimento = $return[0]->procedimento;
            $this->_procedimento_tuss_id = $return[0]->procedimento_tuss_id;
            $this->_sub_classe_id = $return[0]->sub_classe_id;
            $this->_sub_classe = $return[0]->sub_classe;
            $this->_valor_compra = $return[0]->valor_compra;
            $this->_valor_venda = $return[0]->valor_venda;
            $this->_estoque_minimo = $return[0]->estoque_minimo;
        } else {
            $this->_estoque_produto_id = null;
        }
    }

}

?>
