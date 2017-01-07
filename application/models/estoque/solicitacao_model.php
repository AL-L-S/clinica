<?php

class solicitacao_model extends Model {

    var $_estoque_solicitacao_id = null;
    var $_descricao = null;

    function Solicitacao_model($estoque_solicitacao_id = null) {
        parent::Model();
        if (isset($estoque_solicitacao_id)) {
            $this->instanciar($estoque_solicitacao_id);
        }
    }

    function contador($estoque_solicitacao_id) {
        $this->db->select('ep.descricao');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listaclientenotafiscal($estoque_solicitacao_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('ec.*, m.estado, m.nome as municipio');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ec.municipio_id', 'left');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('esc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
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

    function solicitacaonome($estoque_solicitacao_id) {
        $this->db->select('ec.nome  , esc.data_fechamento , o.nome as liberou, op.nome as solicitante, es.data_cadastro');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id');
        $this->db->join('tb_operador o', 'o.operador_id = esc.operador_fechamento', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = esc.operador_liberacao', 'left');
        $this->db->join('tb_estoque_saida es', 'es.solicitacao_cliente_id = esc.estoque_solicitacao_setor_id', 'left');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function solicitacaonomeliberado($estoque_solicitacao_id) {

        $this->db->select('ec.nome  , esc.data_liberacao , o.nome as solicitante');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id');
        $this->db->join('tb_operador o', 'o.operador_id = esc.operador_liberacao', 'left');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
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

    function listarsolicitacaosnota($estoque_solicitacao_id) {
        $this->db->select('ep.descricao, esi.estoque_solicitacao_itens_id, esi.quantidade, esi.exame_id, esi.valor as valor_venda, ep.estoque_produto_id');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function calculavalortotalsolicitacao($estoque_solicitacao_id) {
        $this->db->select('esi.quantidade, esi.valor as valor_venda');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaos($estoque_solicitacao_id) {
        $this->db->select('ep.descricao, esi.estoque_solicitacao_itens_id, esi.quantidade, esi.exame_id, esi.valor as valor_venda');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosvalortotal($estoque_solicitacao_id) {
        $this->db->select('ep.descricao, esi.estoque_solicitacao_itens_id, esi.quantidade, esi.exame_id, ep.valor_venda');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function empresa() {
        $empresa = $this->session->userdata('empresa_id');
        $this->db->select('empresa_id,
                            nome,
                            cnpj,
                            cep,
                            razao_social,
                            logradouro,
                            bairro,
                            telefone,
                            internacao,
                            numero');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutos($estoque_solicitacao_id) {
        $this->db->select('ep.estoque_produto_id,
                            ep.descricao,
                            ep.valor_venda');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_menu_produtos emp', 'emp.produto = ep.estoque_produto_id');
        $this->db->join('tb_estoque_menu em', 'em.estoque_menu_id = emp.menu_id');
        $this->db->join('tb_estoque_cliente ec', 'ec.menu_id = emp.menu_id');
        $this->db->join('tb_estoque_solicitacao_cliente esc', 'esc.cliente_id = ec.estoque_cliente_id');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->where('emp.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listardadoscliente($estoque_solicitacao_id) {
        $this->db->select('ep.estoque_produto_id,
                            ep.descricao');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_menu_produtos emp', 'emp.produto = ep.estoque_produto_id');
        $this->db->join('tb_estoque_menu em', 'em.estoque_menu_id = emp.menu_id');
        $this->db->join('tb_estoque_cliente ec', 'ec.menu_id = emp.menu_id');
        $this->db->join('tb_estoque_solicitacao_cliente esc', 'esc.cliente_id = ec.estoque_cliente_id');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->where('emp.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorprodutositem($estoque_solicitacao_itens_id) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarprodutositem($estoque_solicitacao_itens_id) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
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
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.estoque_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsaidaprodutositem($estoque_solicitacao_itens_id) {
        $this->db->select('ep.estoque_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaida($estoque_solicitacao_itens_id) {
        $this->db->select('ep.estoque_saida_id');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarsaidaitem($estoque_solicitacao_id) {

        $this->db->select('sc.data_fechamento , sc.data_cadastro , si.estoque_solicitacao_itens_id');
        $this->db->from('tb_estoque_solicitacao_cliente sc');
        $this->db->join('tb_estoque_solicitacao_itens si', 'si.solicitacao_cliente_id = sc.estoque_solicitacao_setor_id', 'left');
//        $this->db->join('tb_estoque_saida es' , 'es.solicitacao_cliente_id = sc.estoque_solicitacao_setor_id' , 'left');
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $retorno = $this->db->get()->result();

//        var_dump($retorno[0]->estoque_solicitacao_itens_id , $estoque_solicitacao_id);die;

        $this->db->select('data_cadastro');
        $this->db->from('tb_estoque_saida ');
//        $this->db->join('tb_estoque_saida es' , 'es.solicitacao_cliente_id = sc.estoque_solicitacao_setor_id' , 'left');
        $this->db->where('estoque_solicitacao_itens_id', $retorno[0]->estoque_solicitacao_itens_id);
        $this->db->where('solicitacao_cliente_id', $estoque_solicitacao_id);
        $retorno3 = $this->db->get()->result();

//        var_dump($retorno3);die;
//        
//        $datateste = $retorno3[0]->data_cadastro;

        if (isset($retorno3[0]->data_cadastro)) {
            $data = $retorno3[0]->data_cadastro;
        } else {
            $data = $retorno[0]->data_cadastro;
        }

        $this->db->select(' ep.estoque_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade,
                            u.descricao as unidade,
                            sum(s.quantidade) as saldo,                           
                            si.quantidade as quantidade_solicitada');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id= p.unidade_id');
        $this->db->join('tb_estoque_saldo s', 's.produto_id = ep.produto_id', 'left');
        $this->db->join('tb_estoque_solicitacao_itens si', 'si.estoque_solicitacao_itens_id = ep.estoque_solicitacao_itens_id', 'left');
        $this->db->where('ep.solicitacao_cliente_id', $estoque_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->where('s.data_cadastro <=', $retorno[0]->data_cadastro);
        $this->db->where('s.data_cadastro <=', $data);
        $this->db->groupby('ep.estoque_saida_id, p.descricao, ep.validade , u.descricao , si.quantidade');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaritemliberado($estoque_solicitacao_id) {
        $this->db->select('sc.estoque_solicitacao_setor_id,
                          p.descricao,
                          u.descricao as unidade,
                          si.quantidade as quantidade_solicitada');
        $this->db->from('tb_estoque_solicitacao_cliente sc');
        $this->db->join('tb_estoque_solicitacao_itens si', 'si.solicitacao_cliente_id = sc.estoque_solicitacao_setor_id', 'left');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = si.produto_id');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id= p.unidade_id');

        $this->db->where('sc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('sc.ativo', 'true');
        $this->db->where('sc.situacao', 'LIBERADA');
        $this->db->orderby('sc.estoque_solicitacao_setor_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaidaitem($estoque_solicitacao_id) {
        $this->db->select('ep.estoque_saida_id');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.solicitacao_cliente_id', $estoque_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function formadepagamentoprocedimento() {
        $this->db->select('fp.forma_pagamento_id,
                            fp.nome as nome');
        $this->db->from('tb_forma_pagamento fp');
//        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
//        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('ativo', 't');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        $retorno = $return->result();

        if (empty($retorno)) {
            $this->db->select('fp.forma_pagamento_id,
                            fp.nome as nome');
            $this->db->from('tb_forma_pagamento fp');
            $this->db->orderby('fp.nome');
            $return = $this->db->get();
            return $return->result();
        } else {
            return $retorno;
        }
    }

    function listarsolicitacaofaturamento($estoque_solicitacao_id) {
        $this->db->select('*');
        $this->db->from('tb_estoque_solicitacao_faturamento');
        $this->db->where('estoque_solicitacao_id', $estoque_solicitacao_id);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('es.estoque_solicitacao_setor_id,
                            es.cliente_id,
                            ec.nome as cliente,
                            ec.saida,
                            es.data_cadastro,
                            es.faturado,
                            es.situacao');
        $this->db->from('tb_estoque_solicitacao_cliente es');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = es.cliente_id');
        $this->db->join('tb_estoque_operador_cliente oc', 'oc.cliente_id = es.cliente_id');
        $this->db->where('es.ativo', 'true');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('oc.ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ec.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarsolicitacao($estoque_solicitacao_id) {
        $this->db->select('estoque_solicitacao_id,
                            descricao');
        $this->db->from('tb_estoque_solicitacao');
        $this->db->where('ativo', 'true');
        $this->db->where('estoque_solicitacao_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsolicitacao($estoque_solicitacao_id) {
        $this->db->select('estoque_solicitacao_id,
                            descricao');
        $this->db->from('tb_estoque_solicitacao');
        $this->db->where('estoque_solicitacao_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_solicitacao_setor_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_setor_id);
        $this->db->update('tb_estoque_solicitacao_cliente');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('solicitacao_cliente_id', $estoque_solicitacao_setor_id);
        $this->db->update('tb_estoque_saida');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarfaturamento() {
        try {

            if ($_POST['ajuste1'] != "0") {
                $valor1 = $_POST['valorajuste1'];
            } else {
                $valor1 = $_POST['valor1'];
            }
            if ($_POST['ajuste2'] != "0") {
                $valor2 = $_POST['valorajuste2'];
            } else {
                $valor2 = $_POST['valor2'];
            }
            if ($_POST['ajuste3'] != "0") {
                $valor3 = $_POST['valorajuste3'];
            } else {
                $valor3 = $_POST['valor3'];
            }
            if ($_POST['ajuste4'] != "0") {
                $valor4 = $_POST['valorajuste4'];
            } else {
                $valor4 = $_POST['valor4'];
            }
            if ($_POST['ajuste1'] != "0" || $_POST['ajuste2'] != "0" || $_POST['ajuste3'] != "0" || $_POST['ajuste4'] != "0") {
                if ($_POST['valor1'] > $_POST['valorajuste1']) {
                    $desconto1 = $_POST['valor1'] - $_POST['valorajuste1'];
                } else {
                    $desconto1 = $_POST['valorajuste1'] - $_POST['valor1'];
                }
                if ($_POST['valor2'] > $_POST['valorajuste2']) {
                    $desconto2 = $_POST['valor1'] - $_POST['valorajuste1'];
                } else {
                    $desconto2 = $_POST['valorajuste2'] - $_POST['valor2'];
                }
                if ($_POST['valor3'] > $_POST['valorajuste3']) {
                    $desconto3 = $_POST['valor3'] - $_POST['valorajuste3'];
                } else {
                    $desconto3 = $_POST['valorajuste3'] - $_POST['valor3'];
                }
                if ($_POST['valor4'] > $_POST['valorajuste4']) {
                    $desconto4 = $_POST['valor4'] - $_POST['valorajuste4'];
                } else {
                    $desconto4 = $_POST['valorajuste4'] - $_POST['valor4'];
                }

                $desconto = $desconto1 + $desconto2 + $desconto3 + $desconto4;
            } else {
                $desconto = $_POST['desconto'];
            }

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['formapamento1'] != '') {
                $this->db->set('forma_pagamento', $_POST['formapamento1']);
                $this->db->set('valor1', str_replace(",", ".", $valor1));
                $this->db->set('parcelas1', $_POST['parcela1']);
            }
            if ($_POST['formapamento2'] != '') {
                $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                $this->db->set('valor2', str_replace(",", ".", $valor2));
                $this->db->set('parcelas2', $_POST['parcela2']);
            }
            if ($_POST['formapamento3'] != '') {
                $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                $this->db->set('valor3', str_replace(",", ".", $valor3));
                $this->db->set('parcelas3', $_POST['parcela3']);
            }
            if ($_POST['formapamento4'] != '') {
                $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                $this->db->set('valor4', str_replace(",", ".", $valor4));
                $this->db->set('parcelas4', $_POST['parcela4']);
            }
            $this->db->set('desconto', $desconto);
            $this->db->set('valor_total', $_POST['novovalortotal']);
            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->where('estoque_solicitacao_id', $_POST['estoque_solicitacao_id']);
            $this->db->update('tb_estoque_solicitacao_faturamento');
            
            $this->db->set('faturado', 't');
            $this->db->where('estoque_solicitacao_setor_id', $_POST['estoque_solicitacao_id']);
            $this->db->update('tb_estoque_solicitacao_cliente');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('cliente_id', $_POST['setor']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_solicitacao_cliente');
            $estoque_solicitacao_id = $this->db->insert_id();
            return $estoque_solicitacao_id;
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
            $this->db->insert('tb_estoque_solicitacao_cliente');
            $estoque_solicitacao_id = $this->db->insert_id();
            return $estoque_solicitacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirsolicitacao($estoque_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_solicitacao_itens_id', $estoque_saida_id);
        $this->db->update('tb_estoque_solicitacao_itens');
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

    function liberarsolicitacao($estoque_solicitacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('situacao', 'LIBERADA');
        $this->db->set('data_liberacao', $horario);
        $this->db->set('operador_liberacao', $operador_id);
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->update('tb_estoque_solicitacao_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarsolicitacaofaturamento($estoque_solicitacao_id, $valor) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('estoque_solicitacao_id', $estoque_solicitacao_id);
        $this->db->set('valor_total', $valor);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_estoque_solicitacao_faturamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function fecharsolicitacao($estoque_solicitacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('situacao', 'FECHADA');
        $this->db->set('data_fechamento', $horario);
        $this->db->set('operador_fechamento', $operador_id);
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->update('tb_estoque_solicitacao_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravaritens() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('solicitacao_cliente_id', $_POST['txtestoque_solicitacao_id']);
            $this->db->set('quantidade', $_POST['txtqtde']);
            $this->db->set('valor', $_POST['valor']);
            $this->db->set('produto_id', $_POST['produto_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_solicitacao_itens');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_solicitacao_produtos_id = $this->db->insert_id();

            return $estoque_solicitacao_produtos_id;
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


            $estoque_entrada_id = $_POST['produto_id'];
            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
            $this->db->set('estoque_solicitacao_itens_id', $_POST['txtestoque_solicitacao_itens_id']);
            $this->db->set('solicitacao_cliente_id', $_POST['txtestoque_solicitacao_id']);
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

    private
            function instanciar($estoque_solicitacao_id) {

        if ($estoque_solicitacao_id != 0) {
            $this->db->select('estoque_solicitacao_id, descricao');
            $this->db->from('tb_estoque_solicitacao');
            $this->db->where("estoque_solicitacao_id", $estoque_solicitacao_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_solicitacao_id = $estoque_solicitacao_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_solicitacao_id = null;
        }
    }

}

?>
