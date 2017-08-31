<?php

class armazem_model extends Model {

    var $_estoque_armazem_id = null;
    var $_descricao = null;

    function Armazem_model($estoque_armazem_id = null) {
        parent::Model();
        if (isset($estoque_armazem_id)) {
            $this->instanciar($estoque_armazem_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('estoque_armazem_id,
                            descricao');
        $this->db->from('tb_estoque_armazem');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listararmazem() {
        $this->db->select('estoque_armazem_id,
                            descricao');
        $this->db->from('tb_estoque_armazem');
        $this->db->where('ativo', 'true');


        $return = $this->db->get();
        return $return->result();
    }

    function listarproduto() {
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

        $return = $this->db->get();
        return $return->result();
    }

    function armazemtransferenciaentrada() {
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

        $return = $this->db->get();
        return $return->result();
    }

    function armazemtransferenciaentradajson($produto = null, $armazem = null) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
//        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('ep.ativo', 'true');
        $this->db->where('ep.armazem_id', $armazem);
        $this->db->where('ep.produto_id', $produto);
        $this->db->groupby('ep.estoque_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function armazemtransferenciaentradaproduto($produto = null, $armazem = null) {
        $this->db->select('distinct(p.estoque_produto_id) as produto_id,
                            p.descricao,
                            ');
        $this->db->from('tb_estoque_produto p');
        $this->db->join('tb_estoque_entrada e', 'e.produto_id = p.estoque_produto_id', 'left');
        $this->db->where('e.armazem_id', $armazem);
        $this->db->orderby('p.descricao');
        $this->db->groupby('p.estoque_produto_id, p.descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function armazemtransferenciaentradajsonquantidade($entrada = null) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
//        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('ep.ativo', 'true');
        $this->db->where('ep.estoque_entrada_id', $entrada);
        $this->db->groupby('ep.estoque_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function armazemtransferenciaentradajsonquantidadegasto($produto_id = null, $armazem_id = null) {
        $this->db->select('ea.descricao as armazem,
            ef.fantasia,
            sum(es.quantidade) as total,
            ep.descricao as produto');
        $this->db->from('tb_estoque_saldo es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        $this->db->where('es.armazem_id', $armazem_id);
        $this->db->where('es.produto_id', $produto_id);
        $this->db->groupby('ea.descricao, ef.fantasia, ep.descricao');
        $this->db->orderby('ea.descricao, ef.fantasia, ep.descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_armazem_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_armazem_id', $estoque_armazem_id);
        $this->db->update('tb_estoque_armazem');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_armazem_id = $_POST['txtestoquearmazemid'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoquearmazemid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_armazem');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_armazem_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_armazem_id = $_POST['txtestoquearmazemid'];
                $this->db->where('estoque_armazem_id', $estoque_armazem_id);
                $this->db->update('tb_estoque_armazem');
            }
            return $estoque_armazem_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravartransferencia() {
        try {
            $estoque_armazem_id = $_POST['armazementrada'];
            /* inicia o mapeamento no banco */
            $this->db->select('estoque_entrada_id,
                            produto_id,
                            fornecedor_id,
                            armazem_id,
                            valor_compra,
                            lote,
                            quantidade,
                            nota_fiscal,
                            validade');
            $this->db->from('tb_estoque_entrada');
            $this->db->where("estoque_entrada_id", $_POST['entrada']);
            $query = $this->db->get();
            $returno = $query->result();
//            echo '<pre>';
//            var_dump($returno); die;
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.

            $estoque_entrada_id = $_POST['entrada'];
            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
//            $this->db->set('estoque_solicitacao_itens_id', $_POST['txtestoque_solicitacao_itens_id']);
//            $this->db->set('solicitacao_cliente_id', $_POST['txtestoque_solicitacao_id']);
//            if ($_POST['txtexame'] != '') {
//                $this->db->set('exames_id', $_POST['txtexame']);
//            }
            $this->db->set('produto_id', $returno[0]->produto_id);
            $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
            $this->db->set('armazem_id', $returno[0]->armazem_id);
            $this->db->set('valor_venda', $returno[0]->valor_compra);
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
            $this->db->set('nota_fiscal', $returno[0]->nota_fiscal);
            if ($returno[0]->validade != "") {
                $this->db->set('validade', $returno[0]->validade);
            }
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_saida');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_saida_id = $this->db->insert_id();

            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
            $this->db->set('estoque_saida_id', $estoque_saida_id);
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            // LEMBRAR DE COLOCAR UMA FlAG PRA VER SE É TRASNFERENCIA SENÂO VAI DAR BUXO LÀ NA FRENTE.
            $this->db->set('produto_id', $returno[0]->produto_id);
            $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
            $this->db->set('armazem_id', $returno[0]->armazem_id);
            $this->db->set('valor_compra', $returno[0]->valor_compra);
            $quantidade = -(str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
            $this->db->set('quantidade', $quantidade);
            $this->db->set('nota_fiscal', $returno[0]->nota_fiscal);
            if ($returno[0]->validade != "") {
                $this->db->set('validade', $returno[0]->validade);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_saldo');


            // ENTRADA AGORA
            // ENTRADA AGORA
            // ENTRADA AGORA
            // ENTRADA AGORA
            // ENTRADA AGORA
            // ENTRADA AGORA

            $this->db->set('produto_id', $returno[0]->produto_id);
            $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
            $this->db->set('armazem_id', $estoque_armazem_id);
            $this->db->set('lote', $returno[0]->lote);
            $this->db->set('valor_compra', $returno[0]->valor_compra);
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
            $this->db->set('nota_fiscal', $returno[0]->nota_fiscal);
            if ($returno[0]->validade != "//") {
                $this->db->set('validade', $returno[0]->validade);
            }
//            $horario = date("Y-m-d H:i:s");
//            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_entrada');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_entrada_id = $this->db->insert_id();

            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
            $this->db->set('produto_id', $returno[0]->produto_id);
            $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
            $this->db->set('armazem_id', $estoque_armazem_id);
            $this->db->set('valor_compra', $returno[0]->valor_compra);
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
            $this->db->set('nota_fiscal', $returno[0]->nota_fiscal);
            if ($returno[0]->validade != "//") {
                $this->db->set('validade', $returno[0]->validade);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_saldo');


            return $estoque_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_armazem_id) {

        if ($estoque_armazem_id != 0) {
            $this->db->select('estoque_armazem_id, descricao');
            $this->db->from('tb_estoque_armazem');
            $this->db->where("estoque_armazem_id", $estoque_armazem_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_armazem_id = $estoque_armazem_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_armazem_id = null;
        }
    }

}

?>
