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
        $this->db->select('
                            p.descricao,
                            p.estoque_produto_id,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
//        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('ep.ativo', 'true');
        $this->db->where('ep.armazem_id', $armazem);
        $this->db->where('ep.produto_id', $produto);
        $this->db->groupby('ea.descricao, p.descricao, p.estoque_produto_id');
//        $this->db->orderby('ep.validade');
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
            sum(es.quantidade) as total,
            ep.descricao as produto');
        $this->db->from('tb_estoque_saldo es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
//        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        $this->db->where('es.armazem_id', $armazem_id);
        $this->db->where('es.produto_id', $produto_id);
        $this->db->groupby('ea.descricao, ep.descricao');
        $this->db->orderby('ea.descricao, ep.descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function produtosaldofracionamento($produto_id = null) {
        $this->db->select('
            sum(es.quantidade) as total,
            ep.descricao as produto');
        $this->db->from('tb_estoque_saldo es');
        // $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
//        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        $this->db->where('es.produto_id', $produto_id);
        $this->db->groupby('ep.descricao');
        $this->db->orderby('ep.descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function produtofracionamentounidade($produto_id = null) {


        $this->db->select('
                        ep.estoque_produto_id,
                        ep.unidade_id,
                        ep.descricao as produto');
        $this->db->from('tb_estoque_produto ep');
        $this->db->where('ep.estoque_produto_id', $produto_id);
        $this->db->orderby('ep.descricao');
        $result = $this->db->get()->result();

        // var_dump($result); die;
        $this->db->select('
            ep.estoque_produto_id,
            u.descricao as unidade,
            ep.descricao as produto');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = ep.unidade_id', 'left');
        $this->db->where('ep.ativo', 'true');
        $this->db->where('ep.unidade_id !=', $result[0]->unidade_id);
        $this->db->orderby('ep.descricao');
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
            if( isset($_POST['visivel_solicitacao']) ){
                $this->db->set('visivel_solicitacao', 't');
            } else {
                $this->db->set('visivel_solicitacao', 'f');
            }
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
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('ea.descricao as armazem,
            ef.fantasia,
            sum(es.quantidade) as total,
            ep.descricao as produto');
            $this->db->from('tb_estoque_saldo es');
            $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
            $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
            $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
            $this->db->where('es.ativo', 'true');
            $this->db->where('es.armazem_id', $_POST['armazem']);
            $this->db->where('es.produto_id', $_POST['produto']);
            $this->db->groupby('ea.descricao, ef.fantasia, ep.descricao');
            $this->db->orderby('ea.descricao, ef.fantasia, ep.descricao');
            $saldo = $this->db->get()->result();
//            echo '<pre>';
//            var_dump($saldo); die;

            
            $this->db->select('e.estoque_entrada_id,
                            e.produto_id,
                            e.fornecedor_id,
                            e.armazem_id,
                            e.valor_compra,
                            sum(s.quantidade) as quantidade,
                            e.nota_fiscal,
                            e.validade');
            $this->db->from('tb_estoque_saldo s');
            $this->db->join('tb_estoque_entrada e', 'e.estoque_entrada_id = s.estoque_entrada_id', 'left');
            $this->db->where('e.produto_id', $_POST['produto']);
            $this->db->where('e.armazem_id', $_POST['armazem']);
            $this->db->where('e.ativo', 't');
            $this->db->where('s.ativo', 't');
//        $this->db->where('quantidade >', '0');
            $this->db->groupby("e.estoque_entrada_id,
                            e.produto_id,
                            e.fornecedor_id,
                            e.armazem_id,
                            e.valor_compra,
                            e.nota_fiscal,
                            e.validade");
            $this->db->orderby("sum(s.quantidade) desc");
//            $this->db->where("sum(s.quantidade) > 0");

            $return = $this->db->get()->result();


            $estoque_armazem_id = $_POST['armazementrada'];
            $estoque_transferencia = $_POST['armazem'];
            /* inicia o mapeamento no banco */

//            echo '<pre>';
//            var_dump($return);
//            die;
            $qtdeProduto = $_POST['quantidade'];
            $valor_compra = 0;
            $quantidade_compra = 0;
            foreach ($return as $item) {
                if($quantidade_compra == $_POST['quantidade']){
                    break;
                }
                $valor_compra = $valor_compra + $item->valor_compra;
                $quantidade_compra = $quantidade_compra + $item->quantidade;
            }
            $valor_entrada = round(($valor_compra / $quantidade_compra) * $_POST['quantidade'], 2);
            $estoque_entrada_id = $_POST['entrada'];
            // Pega os ids das saidas pra inserir na tabela de entrada e poder excluir depois
            $saida_array = '';
            $qtdeProdutoSaldo = $saldo[0]->total;
            $i = 0;
            while ($qtdeProduto > 0) {
                if ($qtdeProduto > $return[$i]->quantidade) {
                    $qtdeProduto = $qtdeProduto - $return[$i]->quantidade;
                    $qtde = $return[$i]->quantidade;
                } else {
                    $qtde = $qtdeProduto;
                    $qtdeProduto = 0;
                }


                $this->db->set('estoque_entrada_id', $return[$i]->estoque_entrada_id);
                //        $this->db->set('solicitacao_cliente_id', $_POST['txtestoque_solicitacao_id']);
//                if ($_POST['txtexame'] != '') {
//                    $this->db->set('exames_id', $_POST['txtexame']);
//                }
                $this->db->set('produto_id', $return[$i]->produto_id);
                $this->db->set('fornecedor_id', $return[$i]->fornecedor_id);
                $this->db->set('armazem_id', $return[$i]->armazem_id);
                if ($valor_entrada != '') {
                    $this->db->set('valor_venda', $valor_entrada);
                }
//                $this->db->set('ambulatorio_gasto_sala_id', $ambulatorio_gasto_sala_id);
                $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $qtde)));
                $this->db->set('nota_fiscal', $return[$i]->nota_fiscal);
                if ($return[$i]->validade != "") {
                    $this->db->set('validade', $return[$i]->validade);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_saida');
                $estoque_saida_id = $this->db->insert_id();

                // SALDO 
                $this->db->set('estoque_entrada_id', $return[$i]->estoque_entrada_id);
                $this->db->set('estoque_saida_id', $estoque_saida_id);
                $this->db->set('produto_id', $return[$i]->produto_id);
                $this->db->set('fornecedor_id', $return[$i]->fornecedor_id);
                $this->db->set('armazem_id', $return[$i]->armazem_id);
                if ($valor_entrada != '') {
                    $this->db->set('valor_compra', $valor_entrada);
                }
//                $this->db->set('ambulatorio_gasto_sala_id', $ambulatorio_gasto_sala_id);
                $quantidade = -(str_replace(",", ".", str_replace(".", "", $qtde)));
                $this->db->set('quantidade', $quantidade);
                $this->db->set('nota_fiscal', $return[$i]->nota_fiscal);
                if ($return[$i]->validade != "") {
                    $this->db->set('validade', $return[$i]->validade);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_saldo');

                $i++;
                if ($saida_array == '') {
                    $saida_array = $saida_array . $estoque_saida_id;
                } else {
                    $saida_array = $saida_array . ',' . $estoque_saida_id;
                }
            }
//            var_dump($saida_array); die;
            // ENTRADA AGORA
            // ENTRADA AGORA
            // ENTRADA AGORA
            // ENTRADA AGORA
            // ENTRADA AGORA
            // ENTRADA AGORA

            $this->db->set('saida_id_transferencia', $saida_array);
            $this->db->set('produto_id', $return[0]->produto_id);
            $this->db->set('fornecedor_id', $return[0]->fornecedor_id);
            $this->db->set('armazem_id', $estoque_armazem_id);
            $this->db->set('lote', $return[0]->lote);
            $this->db->set('transferencia', 't');
            $this->db->set('armazem_transferencia', $estoque_transferencia);
            if ($valor_entrada != '') {
                $this->db->set('valor_compra', $valor_entrada);
            }
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
            $this->db->set('nota_fiscal', $return[0]->nota_fiscal);
            if ($returno[0]->validade != "//") {
                $this->db->set('validade', $return[0]->validade);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_entrada');
            $estoque_entrada_id = $this->db->insert_id();

            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
//            $this->db->set('estoque_saida_id', $return[$i]->estoque_saida_id);
            $this->db->set('produto_id', $return[0]->produto_id);
            $this->db->set('fornecedor_id', $return[0]->fornecedor_id);
            $this->db->set('armazem_id', $estoque_armazem_id);
            if ($valor_entrada != '') {
                $this->db->set('valor_compra', $valor_entrada);
            }
//                $this->db->set('ambulatorio_gasto_sala_id', $ambulatorio_gasto_sala_id);
            $quantidade = (str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
            $this->db->set('quantidade', $quantidade);
            $this->db->set('nota_fiscal', $return[0]->nota_fiscal);
            if ($return[0]->validade != "") {
                $this->db->set('validade', $return[0]->validade);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_saldo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_entrada_id = $this->db->insert_id();



            return $estoque_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_armazem_id) {

        if ($estoque_armazem_id != 0) {
            $this->db->select('estoque_armazem_id, descricao, visivel_solicitacao');
            $this->db->from('tb_estoque_armazem');
            $this->db->where("estoque_armazem_id", $estoque_armazem_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_armazem_id = $estoque_armazem_id;
            $this->_descricao = $return[0]->descricao;
            $this->_visivel_solicitacao = $return[0]->visivel_solicitacao;
        } else {
            $this->_estoque_armazem_id = null;
        }
    }

}

?>
