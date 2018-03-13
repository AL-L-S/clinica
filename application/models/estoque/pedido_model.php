<?php

class pedido_model extends Model {

    var $_estoque_pedido_id = null;
    var $_descricao = null;

    function Pedido_model($estoque_pedido_id = null) {
        parent::Model();
        if (isset($estoque_pedido_id)) {
            $this->instanciar($estoque_pedido_id);
        }
    }

    function contador($estoque_pedido_id) {
        $this->db->select('ep.descricao');
        $this->db->from('tb_estoque_pedido_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.pedido_cliente_id', $estoque_pedido_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarclientes() {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('estoque_cliente_id,
                            nome');
        $this->db->from('tb_estoque_cliente ec');
        $this->db->join('tb_estoque_operador_cliente oc', 'oc.cliente_id = ec.estoque_cliente_id');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('ec.ativo', 'true');
        $this->db->where('oc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function pedidonome($estoque_pedido_id) {
        $this->db->select('ep.descricao, ep.situacao');
        $this->db->from('tb_estoque_pedido ep');
        $this->db->where('ep.estoque_pedido_id', $estoque_pedido_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pedidonomeliberado($estoque_pedido_id) {

        $this->db->select('ec.nome  , esc.data_liberacao , o.nome as solicitante');
        $this->db->from('tb_estoque_pedido_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id');
        $this->db->join('tb_operador o', 'o.operador_id = esc.operador_liberacao', 'left');
        $this->db->where('esc.estoque_pedido_setor_id', $estoque_pedido_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listararmazem() {
        $this->db->select('estoque_armazem_id,
                            descricao');
        $this->db->from('tb_estoque_armazem');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioimpressaopedido($estoque_pedido_id) {
        $this->db->select("ep.descricao as produto, 
                           p.descricao,
                           epi.estoque_pedido_itens_id, 
                           epi.quantidade, 
                           epi.observacao,
                           (
                            SELECT (valor_compra/quantidade) 
                            FROM ponto.tb_estoque_entrada ee
                            WHERE ativo = 't'
                            AND ee.produto_id = epi.produto_id
                            ORDER BY ee.data_cadastro DESC
                            LIMIT 1
                           ) as valor_entrada");
        $this->db->from('tb_estoque_pedido_itens epi');
        $this->db->join('tb_estoque_pedido p', 'p.estoque_pedido_id = epi.estoque_pedido_id');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = epi.produto_id');
        $this->db->where('epi.estoque_pedido_id', $estoque_pedido_id);
        $this->db->where('epi.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarpedidos($estoque_pedido_id) {
        $this->db->select('ep.descricao, epi.estoque_pedido_itens_id, epi.quantidade, epi.observacao');
        $this->db->from('tb_estoque_pedido_itens epi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = epi.produto_id');
        $this->db->where('epi.ativo', 'true');
        $this->db->where('epi.estoque_pedido_id', $estoque_pedido_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutos() {
        $this->db->select("ep.estoque_produto_id,
                           ep.descricao,
                           ep.estoque_minimo,
                           (
                            SELECT SUM(es.quantidade) FROM ponto.tb_estoque_saldo es
                            WHERE es.ativo = 't'
                            AND es.produto_id = ep.estoque_produto_id
                           ) as saldo_atual");
        $this->db->from('tb_estoque_produto ep');
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorprodutositem($estoque_pedido_itens_id) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_pedido_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_pedido_itens_id', $estoque_pedido_itens_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarprodutositem($estoque_pedido_itens_id) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_pedido_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_pedido_itens_id', $estoque_pedido_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->where('ea.visivel_pedido', 'true');
        $this->db->groupby('ep.estoque_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function saidaprodutositemverificacao($produto_id) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_pedido_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_pedido_itens_id', $estoque_pedido_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.estoque_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsaidaprodutositem($estoque_pedido_itens_id) {
        $this->db->select('ep.estoque_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.estoque_pedido_itens_id', $estoque_pedido_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaida($estoque_pedido_itens_id) {
        $this->db->select('ep.estoque_saida_id');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.estoque_pedido_itens_id', $estoque_pedido_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarsaidaitem($estoque_pedido_id) {

        $this->db->select(' ep.estoque_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade,
                            u.descricao as unidade');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id= p.unidade_id');
//        $this->db->join('tb_estoque_saldo s', 's.produto_id = ep.produto_id', 'left');
//        $this->db->join('tb_estoque_pedido_itens si', 'si.estoque_pedido_itens_id = ep.estoque_pedido_itens_id', 'left');
        $this->db->where('ep.pedido_cliente_id', $estoque_pedido_id);
        $this->db->where('ep.ativo', 'true');
//        $this->db->groupby('ep.estoque_saida_id, p.descricao, ep.validade , u.descricao ');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->get();
        return $return->result();
    }
    function listarsaidaitemrelatorio($estoque_pedido_id) {

        $this->db->select("ep.estoque_saida_id,
                            p.descricao,
                            p.valor_compra,
                            p.valor_venda,
                            ep.validade,
                            ep.quantidade,
                            ( e.valor_compra / e.quantidade) as valor_unitario,
                            (( e.valor_compra / e.quantidade) * ep.quantidade) as valor_total,
                            si.quantidade as quantidade_solicitada,
                            sum(s.quantidade) as saldo,
                            (
                                SELECT sum(saldo.quantidade) FROM ponto.tb_estoque_saldo saldo 
                                WHERE saldo.ativo = 't' AND saldo.produto_id = ep.produto_id
                                GROUP BY saldo.produto_id
                            ) as saldo_atual,
                            u.descricao as unidade");
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_entrada e', 'e.estoque_entrada_id = ep.estoque_entrada_id');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id= p.unidade_id');
        $this->db->join('tb_estoque_saldo s', 's.produto_id = ep.produto_id', 'left');
        $this->db->join('tb_estoque_pedido_itens si', 'si.estoque_pedido_itens_id = ep.estoque_pedido_itens_id', 'left');
        $this->db->where('ep.pedido_cliente_id', $estoque_pedido_id);
        $this->db->where('ep.data_cadastro >= s.data_cadastro');
//        $this->db->where('s.ativo', 't');
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.estoque_saida_id,si.quantidade, p.descricao, ep.validade , u.descricao,p.valor_compra, p.valor_venda,e.valor_compra,e.quantidade ');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaritemliberado($estoque_pedido_id) {
        $this->db->select('sc.estoque_pedido_setor_id,
                          p.descricao,
                          p.valor_compra,
                          p.valor_venda,
                          u.descricao as unidade,
                          si.quantidade as quantidade_solicitada');
        $this->db->from('tb_estoque_pedido_cliente sc');
        $this->db->join('tb_estoque_pedido_itens si', 'si.pedido_cliente_id = sc.estoque_pedido_setor_id', 'left');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = si.produto_id');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id= p.unidade_id');

        $this->db->where('sc.estoque_pedido_setor_id', $estoque_pedido_id);
        $this->db->where('sc.ativo', 'true');
        $this->db->where('si.ativo', 'true');
        $this->db->where('sc.situacao', 'LIBERADA');
        $this->db->orderby('sc.estoque_pedido_setor_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaidaitem($estoque_pedido_id) {
        $this->db->select('ep.estoque_saida_id');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.pedido_cliente_id', $estoque_pedido_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listar($args = array()) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('ep.estoque_pedido_id,
                            ep.descricao,
                            ep.data_cadastro,
                            ep.situacao');
        $this->db->from('tb_estoque_pedido ep');
        $this->db->where('ep.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ep.descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarpedido($estoque_pedido_id) {
        $this->db->select('estoque_pedido_id,
                            descricao');
        $this->db->from('tb_estoque_pedido');
        $this->db->where('ativo', 'true');
        $this->db->where('estoque_pedido_id', $estoque_pedido_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarpedido($estoque_pedido_id) {
        $this->db->select('estoque_pedido_id,
                            descricao');
        $this->db->from('tb_estoque_pedido');
        $this->db->where('estoque_pedido_id', $estoque_pedido_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_pedido_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_pedido_id', $estoque_pedido_id);
        $this->db->update('tb_estoque_pedido');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('descricao', $_POST['descricao']);
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            if ($_POST['pedido_id'] == '') {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_pedido');
                $estoque_pedido_id = $this->db->insert_id();
            }
            else {
                $estoque_pedido_id = $_POST['pedido_id'];
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->where('estoque_pedido_id', $estoque_pedido_id);
                $this->db->update('tb_estoque_pedido');
            }
            return $estoque_pedido_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpedidopaciente($setor) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('cliente_id', $setor);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_pedido_cliente');
            $estoque_pedido_id = $this->db->insert_id();
            return $estoque_pedido_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirpedido($estoque_pedido_itens_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_pedido_itens_id', $estoque_pedido_itens_id);
        $this->db->update('tb_estoque_pedido_itens');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirsaida($estoque_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_saida_id', $estoque_saida_id);
        $this->db->update('tb_estoque_saida');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_saida_id', $estoque_saida_id);
        $this->db->update('tb_estoque_saldo');
    }

    function liberarpedido($estoque_pedido_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('situacao', 'LIBERADA');
        $this->db->set('data_liberacao', $horario);
        $this->db->set('operador_liberacao', $operador_id);
        $this->db->where('estoque_pedido_setor_id', $estoque_pedido_id);
        $this->db->update('tb_estoque_pedido_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function fecharpedido($estoque_pedido_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('situacao', 'FECHADA');
        $this->db->set('data_fechamento', $horario);
        $this->db->set('operador_fechamento', $operador_id);
        $this->db->where('estoque_pedido_setor_id', $estoque_pedido_id);
        $this->db->update('tb_estoque_pedido_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravaritens() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('estoque_pedido_id', $_POST['txtestoque_pedido_id']);
            $this->db->set('quantidade', $_POST['txtqtde']);
            $this->db->set('produto_id', $_POST['produto_id']);
            $this->db->set('observacao', $_POST['observacao']);
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_pedido_itens');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_pedido_produtos_id = $this->db->insert_id();

            return $estoque_pedido_produtos_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsaidaitens() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->select('estoque_entrada_id,
                            produto_id,
                            fornecedor_id,
                            armazem_id,
                            valor_compra,
                            quantidade,
                            nota_fiscal,
                            validade');
            $this->db->from('tb_estoque_entrada');
            $this->db->where("estoque_entrada_id", $_POST['produto_id']);
            $query = $this->db->get();
            $returno = $query->result();
            
//            echo "<pre>";
//            var_dump($returno);
//            die('bebo');

            $estoque_entrada_id = $_POST['produto_id'];
            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
            $this->db->set('estoque_pedido_itens_id', $_POST['txtestoque_pedido_itens_id']);
            $this->db->set('pedido_cliente_id', $_POST['txtestoque_pedido_id']);
            if ($_POST['txtexame'] != '') {
                $this->db->set('exames_id', $_POST['txtexame']);
            }
            $this->db->set('produto_id', $returno[0]->produto_id);
            $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
            $this->db->set('armazem_id', $returno[0]->armazem_id);
            $this->db->set('valor_venda', $returno[0]->valor_compra);
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['txtqtde'])));
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
            
//            var_dump($estoque_saida_id);
//            die;

            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
            $this->db->set('estoque_saida_id', $estoque_saida_id);
            $this->db->set('produto_id', $returno[0]->produto_id);
            $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
            $this->db->set('armazem_id', $returno[0]->armazem_id);
            $this->db->set('valor_compra', $returno[0]->valor_compra);
            $quantidade = -(str_replace(",", ".", str_replace(".", "", $_POST['txtqtde'])));
            $this->db->set('quantidade', $quantidade);
            $this->db->set('nota_fiscal', $returno[0]->nota_fiscal);
            if ($returno[0]->validade != "") {
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

    private function instanciar($estoque_pedido_id) {

        if ($estoque_pedido_id != 0) {
            $this->db->select('estoque_pedido_id, descricao');
            $this->db->from('tb_estoque_pedido');
            $this->db->where("estoque_pedido_id", $estoque_pedido_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_pedido_id = $estoque_pedido_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_pedido_id = null;
        }
    }

}

?>
