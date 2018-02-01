<?php

class fracionamento_model extends Model {

    var $_farmacia_fracionamento_entrada_id = null;
    var $_razao_social = null;
    var $_produto_id = null;
    var $_produto = null;
    var $_fornecedor_id = null;
    var $_fornecedor = null;
    var $_armazem_id = null;
    var $_armazem = null;
    var $_nota_fiscal = null;
    var $_valor_compra = null;
    var $_validade = null;

    function Fracionamento_model($farmacia_fracionamento_entrada_id = null) {
        parent::Model();
        if (isset($farmacia_fracionamento_entrada_id)) {
            $this->instanciar($farmacia_fracionamento_entrada_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('e.farmacia_fracionamento_entrada_id,
                            e.produto_id,
                            f.fantasia,
                            p.descricao as produto,
                            e.fornecedor_id,
                            f.razao_social as fornecedor,
                            e.armazem_id,
                            a.descricao as armazem,
                            e.valor_compra,
                            e.quantidade,
                            e.nota_fiscal,
                            e.validade');
        $this->db->from('tb_farmacia_fracionamento_entrada e');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = e.produto_id', 'left');
        $this->db->join('tb_farmacia_fornecedor f', 'f.farmacia_fornecedor_id = e.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_armazem a', 'a.farmacia_armazem_id = e.armazem_id', 'left');
        $this->db->where('e.ativo', 'true');
        $this->db->where('e.inventario', 'false');
        if (isset($args['produto']) && strlen($args['produto']) > 0) {
            $this->db->where('p.descricao ilike', "%" . $args['produto'] . "%");
        }
        if (isset($args['fornecedor']) && strlen($args['fornecedor']) > 0) {
            $this->db->where('f.razao_social ilike', "%" . $args['fornecedor'] . "%");
        }
        if (isset($args['armazem']) && strlen($args['armazem']) > 0) {
            $this->db->where('a.descricao ilike', "%" . $args['armazem'] . "%");
        }
        if (isset($args['nota']) && strlen($args['nota']) > 0) {
            $this->db->where('e.nota_fiscal ilike', "%" . $args['nota'] . "%");
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

    function listararmazem() {
        $this->db->select('farmacia_armazem_id,
                            descricao');
        $this->db->from('tb_farmacia_armazem');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listararmazemcada($farmacia_armazem_id) {
        $this->db->select('farmacia_armazem_id,
                            descricao');
        $this->db->from('tb_farmacia_armazem');
        if ($farmacia_armazem_id != "0" && $farmacia_armazem_id != "") {
            $this->db->where('farmacia_armazem_id', $farmacia_armazem_id);
        }
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfornecedorcada($farmacia_fornecedor_id) {
        $this->db->select('farmacia_fornecedor_id,
                            fantasia');
        $this->db->from('tb_farmacia_fornecedor');
        if ($farmacia_fornecedor_id != "0" && $farmacia_fornecedor_id != "") {
            $this->db->where("farmacia_fornecedor_id", $farmacia_fornecedor_id);
        }
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutocada($farmacia_produto_id) {
        $this->db->select('farmacia_produto_id,
                            descricao');
        $this->db->from('tb_farmacia_produto');
        if ($farmacia_produto_id != "0" && $farmacia_produto_id != "") {
            $this->db->where('farmacia_produto_id', $farmacia_produto_id);
        }
        $this->db->where('ativo', 'true');
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

    function relatoriosaldoarmazem() {
        $this->db->select('es.nota_fiscal,
            es.validade as data,
            ea.descricao as armazem,
            ef.fantasia,
            sum(es.quantidade) as quantidade,
            es.valor_compra,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_fracionamento_saldo es');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_farmacia_fornecedor ef', 'ef.farmacia_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $this->db->groupby('es.nota_fiscal, es.validade, ea.descricao, ef.fantasia, ep.descricao, es.valor_compra');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaldoarmazemcontador() {
        $this->db->select('es.nota_fiscal,
            es.validade,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            es.valor_compra,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_fracionamento_saldo es');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_farmacia_fornecedor ef', 'ef.farmacia_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriominimoarmazem() {
        $this->db->select('ea.descricao as armazem,
            sum(es.quantidade) as quantidade,
            ep.farmacia_minimo,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_produto ep');
        $this->db->join('tb_farmacia_fracionamento_saldo es', 'es.produto_id = ep.farmacia_produto_id', 'left');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->where('ep.ativo', 'true');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $this->db->groupby('ea.descricao, ep.descricao, ep.farmacia_minimo');
        $this->db->orderby('ea.descricao, ep.descricao, ep.farmacia_minimo');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriominimoarmazemcontador() {
        $this->db->select('ea.descricao as armazem,
            sum(es.quantidade) as quantidade,
            ep.farmacia_minimo,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_produto ep');
        $this->db->join('tb_farmacia_fracionamento_saldo es', 'es.produto_id = ep.farmacia_produto_id', 'left');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->where('ep.ativo', 'true');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriosaldo() {
        $this->db->select('ea.descricao as armazem,
            ef.fantasia,
            sum(es.quantidade) as quantidade,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_fracionamento_saldo es');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_farmacia_fornecedor ef', 'ef.farmacia_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $this->db->groupby('ea.descricao, ef.fantasia, ep.descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaldocontador() {
        $this->db->select('ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_fracionamento_saldo es');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_farmacia_fornecedor ef', 'ef.farmacia_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatorioproduto() {
        $this->db->select('sc.descricao as subclasse,
            eu.descricao as unidade,
            ep.farmacia_minimo,
            ep.valor_compra,
            ep.valor_venda,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_produto ep');
        $this->db->join('tb_farmacia_sub_classe sc', 'sc.farmacia_sub_classe_id = ep.sub_classe_id', 'left');
        $this->db->join('tb_farmacia_unidade eu', 'eu.farmacia_unidade_id = ep.unidade_id', 'left');
        $this->db->where('ep.ativo', 'true');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioprodutocontador() {
        $this->db->select('sc.descricao as subclasse,
            eu.descricao as unidade,
            ep.farmacia_minimo,
            ep.valor_compra,
            ep.valor_venda,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_produto ep');
        $this->db->join('tb_farmacia_sub_classe sc', 'sc.farmacia_sub_classe_id = ep.sub_classe_id', 'left');
        $this->db->join('tb_farmacia_unidade eu', 'eu.farmacia_unidade_id = ep.unidade_id', 'left');
        $this->db->where('ep.ativo', 'true');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriofornecedores() {
        $this->db->select('fantasia,
                            telefone,
                            celular,
                            logradouro,
                            numero,
                            bairro');
        $this->db->from('tb_farmacia_fornecedor');
        $this->db->where('ativo', 'true');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriofornecedorescontador() {
        $this->db->select('fantasia,
                            telefone,
                            celular');
        $this->db->from('tb_farmacia_fornecedor');
        $this->db->where('ativo', 'true');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriofracionamentoarmazem() {
        $datainicio = $_POST['txtdata_inicio'];
        $datafim = $_POST['txtdata_fim'];
        $datahorainicio = $datainicio . ' 00:00:00';
        $datahorafim = $datafim . ' 23:59:59';
        $this->db->select('es.nota_fiscal,
            es.validade as data,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            es.valor_compra,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_fracionamento_entrada es');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_farmacia_fornecedor ef', 'ef.farmacia_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = es.produto_id', 'left');
        $this->db->where("es.data_cadastro >=", $datahorainicio);
        $this->db->where("es.data_cadastro <=", $datahorafim);
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
        $this->db->orderby('ea.descricao');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriofracionamentoarmazemcontador() {
        $datainicio = $_POST['txtdata_inicio'];
        $datafim = $_POST['txtdata_fim'];
        $datahorainicio = $datainicio . ' 00:00:00';
        $datahorafim = $datafim . ' 23:59:59';
        $this->db->select('es.nota_fiscal,
            es.validade,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            es.valor_compra,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_fracionamento_entrada es');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_farmacia_fornecedor ef', 'ef.farmacia_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = es.produto_id', 'left');
        $this->db->where("es.data_cadastro >=", $datahorainicio);
        $this->db->where("es.data_cadastro <=", $datahorafim);
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriosaidaarmazem() {
        $datainicio = $_POST['txtdata_inicio'];
        $datafim = $_POST['txtdata_fim'];
        $datahorainicio = $datainicio . ' 00:00:00';
        $datahorafim = $datafim . ' 23:59:59';
        $this->db->select('es.nota_fiscal,
            es.validade as data,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            es.data_cadastro,
            ec.nome,
            es.valor_venda,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_fracionamento_saida es');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_farmacia_fornecedor ef', 'ef.farmacia_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = es.produto_id', 'left');
        $this->db->join('tb_farmacia_solicitacao_itens esi', 'esi.farmacia_solicitacao_itens_id = es.farmacia_solicitacao_itens_id', 'left');
        $this->db->join('tb_farmacia_solicitacao_cliente sc', 'sc.farmacia_solicitacao_setor_id = esi.solicitacao_cliente_id', 'left');
        $this->db->join('tb_farmacia_cliente ec', 'ec.farmacia_cliente_id = sc.cliente_id', 'left');
        $this->db->where("es.data_cadastro >=", $datahorainicio);
        $this->db->where("es.data_cadastro <=", $datahorafim);
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['setor'] != "0") {
            $this->db->where('ec.farmacia_cliente_id', $_POST['setor']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
        $this->db->orderby('ea.descricao');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaidaarmazemcontador() {
        $datainicio = $_POST['txtdata_inicio'];
        $datafim = $_POST['txtdata_fim'];
        $datahorainicio = $datainicio . ' 00:00:00';
        $datahorafim = $datafim . ' 23:59:59';
        $this->db->select('es.nota_fiscal,
            es.validade as data,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            ec.nome,
            es.valor_venda,
            ep.descricao as produto');
        $this->db->from('tb_farmacia_fracionamento_saida es');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_farmacia_fornecedor ef', 'ef.farmacia_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = es.produto_id', 'left');
        $this->db->join('tb_farmacia_solicitacao_itens esi', 'esi.farmacia_solicitacao_itens_id = es.farmacia_solicitacao_itens_id', 'left');
        $this->db->join('tb_farmacia_cliente ec', 'ec.farmacia_cliente_id = esi.solicitacao_cliente_id', 'left');
        $this->db->where("es.data_cadastro >=", $datahorainicio);
        $this->db->where("es.data_cadastro <=", $datahorafim);
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function excluir($farmacia_fracionamento_entrada_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_fracionamento_entrada_id', $farmacia_fracionamento_entrada_id);
        $this->db->update('tb_farmacia_fracionamento_entrada');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $farmacia_fracionamento_entrada_id = $_POST['txtfarmacia_fracionamento_entrada_id'];
            $this->db->set('produto_id', $_POST['txtproduto']);
            $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
            $this->db->set('armazem_id', $_POST['txtarmazem']);
            $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
            $this->db->set('nota_fiscal', str_replace(",", ".", str_replace(".", "", $_POST['nota'])));
            if ($_POST['validade'] != "//") {
                $this->db->set('validade', $_POST['validade']);
            }
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtfarmacia_fracionamento_entrada_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_farmacia_fracionamento_entrada');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $farmacia_fracionamento_entrada_id = $this->db->insert_id();

                $this->db->set('farmacia_fracionamento_entrada_id', $farmacia_fracionamento_entrada_id);
                $this->db->set('produto_id', $_POST['txtproduto']);
                $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
                $this->db->set('armazem_id', $_POST['txtarmazem']);
                $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
                $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
                $this->db->set('nota_fiscal', str_replace(",", ".", str_replace(".", "", $_POST['nota'])));
                if ($_POST['validade'] != "//") {
                    $this->db->set('validade', $_POST['validade']);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_farmacia_fracionamento_saldo');
            } else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('farmacia_fracionamento_entrada_id', $farmacia_fracionamento_entrada_id);
                $this->db->update('tb_farmacia_fracionamento_entrada');

                $this->db->set('farmacia_fracionamento_entrada_id', $farmacia_fracionamento_entrada_id);
                $this->db->set('produto_id', $_POST['txtproduto']);
                $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
                $this->db->set('armazem_id', $_POST['txtarmazem']);
                $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
                $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
                $this->db->set('nota_fiscal', str_replace(",", ".", str_replace(".", "", $_POST['nota'])));
                if ($_POST['validade'] != "//") {
                    $this->db->set('validade', $_POST['validade']);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->where('farmacia_fracionamento_entrada_id', $farmacia_fracionamento_entrada_id);
                $this->db->update('tb_farmacia_fracionamento_saldo');
            }
            return $farmacia_fracionamento_entrada_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($farmacia_fracionamento_entrada_id) {
        if ($farmacia_fracionamento_entrada_id != 0) {
            $this->db->select('e.farmacia_fracionamento_entrada_id,
                            e.produto_id,
                            p.descricao as produto,
                            e.armazem_id,
                            a.descricao as armazem,
                            e.fornecedor_id,
                            f.razao_social as fornecedor,
                            e.quantidade,
                            e.valor_compra,
                            e.quantidade,
                            e.validade,
                            e.nota_fiscal');
            $this->db->from('tb_farmacia_fracionamento_entrada e');
            $this->db->join('tb_farmacia_armazem a', 'a.farmacia_armazem_id = e.armazem_id', 'left');
            $this->db->join('tb_farmacia_fornecedor f', 'f.farmacia_fornecedor_id = e.fornecedor_id', 'left');
            $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = e.produto_id', 'left');
            $this->db->where("e.farmacia_fracionamento_entrada_id", $farmacia_fracionamento_entrada_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_farmacia_fracionamento_entrada_id = $farmacia_fracionamento_entrada_id;
            $this->_produto_id = $return[0]->produto_id;
            $this->_produto = $return[0]->produto;
            $this->_fornecedor_id = $return[0]->fornecedor_id;
            $this->_fornecedor = $return[0]->fornecedor;
            $this->_armazem_id = $return[0]->armazem_id;
            $this->_armazem = $return[0]->armazem;
            $this->_nota_fiscal = $return[0]->nota_fiscal;
            $this->_quantidade = $return[0]->quantidade;
            $this->_valor_compra = $return[0]->valor_compra;
            $this->_validade = $return[0]->validade;
        } else {
            $this->_farmacia_fracionamento_entrada_id = null;
        }
    }

}

?>
