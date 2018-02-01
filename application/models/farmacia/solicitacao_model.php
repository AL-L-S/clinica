<?php

class solicitacao_model extends Model {

    var $_farmacia_solicitacao_id = null;
    var $_descricao = null;

    function Solicitacao_model($farmacia_solicitacao_id = null) {
        parent::Model();
        if (isset($farmacia_solicitacao_id)) {
            $this->instanciar($farmacia_solicitacao_id);
        }
    }

    function contador($farmacia_solicitacao_id) {
        $this->db->select('ep.descricao');
        $this->db->from('tb_farmacia_solicitacao_itens esi');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $farmacia_solicitacao_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarclientes() {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('farmacia_cliente_id,
                            nome');
        $this->db->from('tb_farmacia_cliente ec');
        $this->db->join('tb_farmacia_operador_cliente oc', 'oc.cliente_id = ec.farmacia_cliente_id');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('ec.ativo', 'true');
        $this->db->where('oc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function solicitacaonome($farmacia_solicitacao_id) {
        $this->db->select('nome');
        $this->db->from('tb_farmacia_solicitacao_cliente esc');
        $this->db->join('tb_farmacia_cliente ec', 'ec.farmacia_cliente_id = esc.cliente_id');
        $this->db->where('esc.farmacia_solicitacao_setor_id', $farmacia_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listararmazem() {
        $this->db->select('farmacia_armazem_id,
                            descricao');
        $this->db->from('tb_farmacia_armazem');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaos($farmacia_solicitacao_id) {
        $this->db->select('ep.descricao, esi.farmacia_solicitacao_itens_id, esi.quantidade, esi.exame_id');
        $this->db->from('tb_farmacia_solicitacao_itens esi');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $farmacia_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutos($farmacia_solicitacao_id) {
        $this->db->select('ep.farmacia_produto_id,
                            ep.descricao');
        $this->db->from('tb_farmacia_produto ep');
        $this->db->join('tb_farmacia_menu_produtos emp', 'emp.produto = ep.farmacia_produto_id');
        $this->db->join('tb_farmacia_menu em', 'em.farmacia_menu_id = emp.menu_id');
        $this->db->join('tb_farmacia_cliente ec', 'ec.menu_id = emp.menu_id');
        $this->db->join('tb_farmacia_solicitacao_cliente esc', 'esc.cliente_id = ec.farmacia_cliente_id');
        $this->db->where('esc.farmacia_solicitacao_setor_id', $farmacia_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorprodutositem($farmacia_solicitacao_itens_id) {
        $this->db->select('ep.farmacia_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem');
        $this->db->from('tb_farmacia_saldo ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = ep.armazem_id');
        $this->db->where('esi.farmacia_solicitacao_itens_id', $farmacia_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarprodutositem($farmacia_solicitacao_itens_id) {
        $this->db->select('ep.farmacia_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_farmacia_saldo ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = ep.armazem_id');
        $this->db->where('esi.farmacia_solicitacao_itens_id', $farmacia_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.farmacia_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsaidaprodutositem($farmacia_solicitacao_itens_id) {
        $this->db->select('ep.farmacia_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade');
        $this->db->from('tb_farmacia_saida ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->where('ep.farmacia_solicitacao_itens_id', $farmacia_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.farmacia_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaida($farmacia_solicitacao_itens_id) {
        $this->db->select('ep.farmacia_saida_id');
        $this->db->from('tb_farmacia_saida ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->where('ep.farmacia_solicitacao_itens_id', $farmacia_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.farmacia_saida_id');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarsaidaitem($farmacia_solicitacao_id) {
        $this->db->select('ep.farmacia_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade');
        $this->db->from('tb_farmacia_saida ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->where('ep.solicitacao_cliente_id', $farmacia_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.farmacia_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaidaitem($farmacia_solicitacao_id) {
        $this->db->select('ep.farmacia_saida_id');
        $this->db->from('tb_farmacia_saida ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->where('ep.solicitacao_cliente_id', $farmacia_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listar($args = array()) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('es.farmacia_solicitacao_setor_id,
                            es.cliente_id,
                            ec.nome as cliente,
                            es.data_cadastro,
                            es.situacao');
        $this->db->from('tb_farmacia_solicitacao_cliente es');
        $this->db->join('tb_farmacia_cliente ec', 'ec.farmacia_cliente_id = es.cliente_id');
        $this->db->join('tb_farmacia_operador_cliente oc', 'oc.cliente_id = ec.farmacia_cliente_id');
        $this->db->where('es.ativo', 'true');
        $this->db->where('oc.operador_id', $operador_id);
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ec.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarsolicitacao($farmacia_solicitacao_id) {
        $this->db->select('farmacia_solicitacao_id,
                            descricao');
        $this->db->from('tb_farmacia_solicitacao');
        $this->db->where('ativo', 'true');
        $this->db->where('farmacia_solicitacao_id', $farmacia_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsolicitacao($farmacia_solicitacao_id) {
        $this->db->select('farmacia_solicitacao_id,
                            descricao');
        $this->db->from('tb_farmacia_solicitacao');
        $this->db->where('farmacia_solicitacao_id', $farmacia_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($farmacia_solicitacao_setor_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_solicitacao_setor_id', $farmacia_solicitacao_setor_id);
        $this->db->update('tb_farmacia_solicitacao_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('cliente_id', $_POST['setor']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_farmacia_solicitacao_cliente');
            $farmacia_solicitacao_id = $this->db->insert_id();
            return $farmacia_solicitacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsolicitacaopaciente($setor) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('cliente_id', $setor);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_farmacia_solicitacao_cliente');
            $farmacia_solicitacao_id = $this->db->insert_id();
            return $farmacia_solicitacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirsolicitacao($farmacia_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_solicitacao_itens_id', $farmacia_saida_id);
        $this->db->update('tb_farmacia_solicitacao_itens');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirsaida($farmacia_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_saida_id', $farmacia_saida_id);
        $this->db->update('tb_farmacia_saida');
        
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_saida_id', $farmacia_saida_id);
        $this->db->update('tb_farmacia_saldo');
    }
        
    function liberarsolicitacao($farmacia_solicitacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('situacao', 'LIBERADA');
        $this->db->set('data_liberacao', $horario);
        $this->db->set('operador_liberacao', $operador_id);
        $this->db->where('farmacia_solicitacao_setor_id', $farmacia_solicitacao_id);
        $this->db->update('tb_farmacia_solicitacao_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function fecharsolicitacao($farmacia_solicitacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('situacao', 'FECHADA');
        $this->db->set('data_fechamento', $horario);
        $this->db->set('operador_fechamento', $operador_id);
        $this->db->where('farmacia_solicitacao_setor_id', $farmacia_solicitacao_id);
        $this->db->update('tb_farmacia_solicitacao_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravaritens() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('solicitacao_cliente_id', $_POST['txtfarmacia_solicitacao_id']);
            $this->db->set('quantidade', $_POST['txtqtde']);
            $this->db->set('produto_id', $_POST['produto_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_farmacia_solicitacao_itens');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $farmacia_solicitacao_produtos_id = $this->db->insert_id();

            return $farmacia_solicitacao_produtos_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsaidaitens() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->select('farmacia_entrada_id,
                            produto_id,
                            fornecedor_id,
                            armazem_id,
                            valor_compra,
                            quantidade,
                            nota_fiscal,
                            validade');
            $this->db->from('tb_farmacia_entrada');
            $this->db->where("farmacia_entrada_id", $_POST['produto_id']);
            $query = $this->db->get();
            $returno = $query->result();


            $farmacia_entrada_id = $_POST['produto_id'];
            $this->db->set('farmacia_entrada_id', $farmacia_entrada_id);
            $this->db->set('farmacia_solicitacao_itens_id', $_POST['txtfarmacia_solicitacao_itens_id']);
            $this->db->set('solicitacao_cliente_id', $_POST['txtfarmacia_solicitacao_id']);
            if ($_POST['txtexame'] != ''){
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
            $this->db->insert('tb_farmacia_saida');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $farmacia_saida_id = $this->db->insert_id();

            $this->db->set('farmacia_entrada_id', $farmacia_entrada_id);
            $this->db->set('farmacia_saida_id', $farmacia_saida_id);
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
            $this->db->insert('tb_farmacia_saldo');
            return $farmacia_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($farmacia_solicitacao_id) {

        if ($farmacia_solicitacao_id != 0) {
            $this->db->select('farmacia_solicitacao_id, descricao');
            $this->db->from('tb_farmacia_solicitacao');
            $this->db->where("farmacia_solicitacao_id", $farmacia_solicitacao_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_farmacia_solicitacao_id = $farmacia_solicitacao_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_farmacia_solicitacao_id = null;
        }
    }

}

?>
