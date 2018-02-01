<?php

class saida_model extends Model {

    var $_farmacia_saida_id = null;
    var $_descricao = null;

    function Solicitacao_model($farmacia_saida_id = null) {
        parent::Model();
        if (isset($farmacia_saida_id)) {
            $this->instanciar($farmacia_saida_id);
        }
    }

    function contador($farmacia_saida_id) {
        $this->db->select('ep.descricao');
        $this->db->from('tb_farmacia_saida_itens esi');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.saida_cliente_id', $farmacia_saida_id);
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

    function saidanome($farmacia_saida_id) {
        $this->db->select('nome');
        $this->db->from('tb_farmacia_saida_cliente esc');
        $this->db->join('tb_farmacia_cliente ec', 'ec.farmacia_cliente_id = esc.cliente_id');
        $this->db->where('esc.farmacia_saida_setor_id', $farmacia_saida_id);
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

    function listarsaidas($farmacia_saida_id) {
        $this->db->select('ep.descricao, esi.farmacia_saida_itens_id, esi.quantidade, esi.exame_id');
        $this->db->from('tb_farmacia_saida_itens esi');
        $this->db->join('tb_farmacia_produto ep', 'ep.farmacia_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.saida_cliente_id', $farmacia_saida_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutos($farmacia_saida_id) {
        $this->db->select('ep.farmacia_produto_id,
                            ep.descricao');
        $this->db->from('tb_farmacia_produto ep');
        $this->db->join('tb_farmacia_menu_produtos emp', 'emp.produto = ep.farmacia_produto_id');
        $this->db->join('tb_farmacia_menu em', 'em.farmacia_menu_id = emp.menu_id');
        $this->db->join('tb_farmacia_cliente ec', 'ec.menu_id = emp.menu_id');
        $this->db->join('tb_farmacia_saida_cliente esc', 'esc.cliente_id = ec.farmacia_cliente_id');
        $this->db->where('esc.farmacia_saida_setor_id', $farmacia_saida_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorprodutositem($farmacia_saida_itens_id) {
        $this->db->select('ep.farmacia_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem');
        $this->db->from('tb_farmacia_saldo ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_saida_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = ep.armazem_id');
        $this->db->where('esi.farmacia_saida_itens_id', $farmacia_saida_itens_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarprodutositemfarmacia($farmacia_produto_id) {
        $this->db->select('ep.farmacia_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_farmacia_saldo ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
//        $this->db->join('tb_farmacia_saida_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = ep.armazem_id');
        $this->db->where('p.farmacia_produto_id', $farmacia_produto_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.farmacia_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsaidaprodutositem($farmacia_saida_itens_id) {
        $this->db->select('ep.farmacia_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade');
        $this->db->from('tb_farmacia_saida ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->where('ep.farmacia_saida_itens_id', $farmacia_saida_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.farmacia_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaida($farmacia_saida_itens_id) {
        $this->db->select('ep.farmacia_saida_id');
        $this->db->from('tb_farmacia_saida ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->where('ep.farmacia_saida_itens_id', $farmacia_saida_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.farmacia_saida_id');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listasaidapaciente($args = array()) {
        $this->db->select(' i.internacao_id,
                            p.nome,
                            o.nome as medico');
        $this->db->from('tb_internacao_prescricao ip');
        $this->db->join('tb_internacao i', 'ip.internacao_id = i.internacao_id ', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.operador_cadastro ', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ', 'left');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
        }

        $this->db->where('ip.ativo', 't');
        $this->db->groupby('i.internacao_id, p.nome,o.nome');

        return $this->db;
    }

    function listasaidapacienteprescricao($internacao_id) {
        $this->db->select(' fp.descricao,
                            ip.internacao_prescricao_id,
                            p.nome as paciente,
                            ip.aprasamento,
                            ip.confirmado,
                            ip.dias,
                            fp.farmacia_produto_id,
                            o.nome as medico');
        $this->db->from('tb_internacao_prescricao ip');
        $this->db->join('tb_internacao i', 'ip.internacao_id = i.internacao_id ');
//        $this->db->join('tb_farmacia_saida fs', 'ip.internacao_prescricao_id = fs.internacao_prescricao_id ', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.operador_cadastro ');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('ip.ativo', 't');
        $this->db->orderby('ip.internacao_prescricao_id');
//        $this->db->where('(fs.ativo = true OR fs.ativo is null)');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarprodutositemfarmaciasaida($internacao_prescricao_id) {
        $this->db->select('fs.internacao_prescricao_id');
        $this->db->from('tb_farmacia_saida fs');
        $this->db->where('fs.internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->where('fs.ativo', 't');
//        $this->db->where('(fs.ativo = true OR fs.ativo is null)');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutositemsaidafarmacia($internacao_id) {
        $this->db->select('fs.farmacia_entrada_id,
                            fs.farmacia_saida_id,
                            p.descricao,
                            fs.validade,
                            fs.internacao_prescricao_id,
                            ip.confirmado,
                            ea.descricao as armazem,
                            fs.quantidade');
        $this->db->from('tb_farmacia_saida fs');
        $this->db->join('tb_internacao_prescricao ip', 'fs.internacao_prescricao_id = ip.internacao_prescricao_id', 'left');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = fs.produto_id');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = fs.armazem_id');
        $this->db->where('fs.internacao_id', $internacao_id);
        $this->db->where('fs.ativo', 'true');
//        $this->db->where('ip.confirmado', 'true');
//        $this->db->groupby('fs.farmacia_entrada_id,fs.farmacia_saida_id, p.descricao, fs.validade, ea.descricao');
        $this->db->orderby('fs.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function excluirsaida($farmacia_saida_id, $internacao_prescricao_id) {

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


        $this->db->set('confirmado', 'f');
        $this->db->set('qtde_ministrada', null);
        $this->db->set('qtde_volta', null);
        $this->db->set('qtde_original', null);
//        $this->db->set('dias', $_POST['dias']);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->update('tb_internacao_prescricao');
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

    function listarsaldoprodutofarmaciaautocomplete($farmacia_entrada_id) {
        $this->db->select('ep.farmacia_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_farmacia_saldo ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
//        $this->db->join('tb_farmacia_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = ep.armazem_id');
        $this->db->where('ep.farmacia_entrada_id', $farmacia_entrada_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.farmacia_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsaidaprescricaofarmaciaautocomplete($prescricao_id) {
        $this->db->select('ep.farmacia_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_farmacia_saldo ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_saida fs', 'fs.farmacia_saida_id = ep.farmacia_saida_id');
//        $this->db->join('tb_farmacia_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_farmacia_armazem ea', 'ea.farmacia_armazem_id = ep.armazem_id');
        $this->db->where('fs.internacao_prescricao_id', $prescricao_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.farmacia_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsaidaitem($farmacia_saida_id) {
        $this->db->select('ep.farmacia_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade');
        $this->db->from('tb_farmacia_saida ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->where('ep.saida_cliente_id', $farmacia_saida_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.farmacia_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaidaitem($farmacia_saida_id) {
        $this->db->select('ep.farmacia_saida_id');
        $this->db->from('tb_farmacia_saida ep');
        $this->db->join('tb_farmacia_produto p', 'p.farmacia_produto_id = ep.produto_id');
        $this->db->where('ep.saida_cliente_id', $farmacia_saida_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listar($args = array()) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('es.farmacia_saida_setor_id,
                            es.cliente_id,
                            ec.nome as cliente,
                            es.data_cadastro,
                            es.situacao');
        $this->db->from('tb_farmacia_saida_cliente es');
        $this->db->join('tb_farmacia_cliente ec', 'ec.farmacia_cliente_id = es.cliente_id');
        $this->db->join('tb_farmacia_operador_cliente oc', 'oc.cliente_id = ec.farmacia_cliente_id');
        $this->db->where('es.ativo', 'true');
        $this->db->where('oc.operador_id', $operador_id);
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ec.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarsaida($farmacia_saida_id) {
        $this->db->select('farmacia_saida_id,
                            descricao');
        $this->db->from('tb_farmacia_saida');
        $this->db->where('ativo', 'true');
        $this->db->where('farmacia_saida_id', $farmacia_saida_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsaida($farmacia_saida_id) {
        $this->db->select('farmacia_saida_id,
                            descricao');
        $this->db->from('tb_farmacia_saida');
        $this->db->where('farmacia_saida_id', $farmacia_saida_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($farmacia_saida_setor_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_saida_setor_id', $farmacia_saida_setor_id);
        $this->db->update('tb_farmacia_saida_cliente');
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
            $this->db->insert('tb_farmacia_saida_cliente');
            $farmacia_saida_id = $this->db->insert_id();
            return $farmacia_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsaidaitenspaciente($internacao_id) {
        try {
            /* inicia o mapeamento no banco */
            $contador_array = 0;
            foreach ($_POST['entrada_id'] as $entrada_id) {
//                var_dump($entrada_id);
//                die;
                if ($entrada_id != '') {

                    $quantidade = $_POST['qtde'][$contador_array];
                    $internacao_prescricao_id = $_POST['internacao_prescricao_id'][$contador_array];
//                    var_dump($quantidade); die;

                    $this->db->select('farmacia_entrada_id,
                            produto_id,
                            fornecedor_id,
                            armazem_id,
                            valor_compra,
                            quantidade,
                            nota_fiscal,
                            validade');
                    $this->db->from('tb_farmacia_entrada');
                    $this->db->where("farmacia_entrada_id", $entrada_id);
                    $query = $this->db->get();
                    $returno = $query->result();

//                    echo "<pre>";
//                    var_dump($returno);
//                    die;
//                    $farmacia_entrada_id = $_POST['produto_id'];
                    $this->db->set('farmacia_entrada_id', $entrada_id);
//                $this->db->set('farmacia_solicitacao_itens_id', $_POST['txtfarmacia_solicitacao_itens_id']);
//                $this->db->set('solicitacao_cliente_id', $_POST['txtfarmacia_solicitacao_id']);
//                if ($_POST['txtexame'] != '') {
//                    $this->db->set('exames_id', $_POST['txtexame']);
//                }
                    $this->db->set('internacao_id', $internacao_id);
                    $this->db->set('internacao_prescricao_id', $internacao_prescricao_id);
                    $this->db->set('produto_id', $returno[0]->produto_id);
                    $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
                    $this->db->set('armazem_id', $returno[0]->armazem_id);
                    $this->db->set('valor_venda', $returno[0]->valor_compra);
                    $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $quantidade)));
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

//            var_dump($farmacia_saida_id);
//            die;

                    $this->db->set('farmacia_entrada_id', $entrada_id);
                    $this->db->set('farmacia_saida_id', $farmacia_saida_id);
                    $this->db->set('produto_id', $returno[0]->produto_id);
                    $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
                    $this->db->set('armazem_id', $returno[0]->armazem_id);
                    $this->db->set('valor_compra', $returno[0]->valor_compra);
                    $quantidade_saldo = -(str_replace(",", ".", str_replace(".", "", $quantidade)));
                    $this->db->set('quantidade', $quantidade_saldo);
                    $this->db->set('nota_fiscal', $returno[0]->nota_fiscal);
                    if ($returno[0]->validade != "") {
                        $this->db->set('validade', $returno[0]->validade);
                    }
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_farmacia_saldo');

                    $contador_array ++;
                } else {
                    $contador_array ++;
                }
            }
            return $farmacia_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsaidapaciente($setor) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('cliente_id', $setor);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_farmacia_saida_cliente');
            $farmacia_saida_id = $this->db->insert_id();
            return $farmacia_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($farmacia_saida_id) {

        if ($farmacia_saida_id != 0) {
            $this->db->select('farmacia_saida_id, descricao');
            $this->db->from('tb_farmacia_saida');
            $this->db->where("farmacia_saida_id", $farmacia_saida_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_farmacia_saida_id = $farmacia_saida_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_farmacia_saida_id = null;
        }
    }

}

?>
