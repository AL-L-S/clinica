<?php

class contaspagar_model extends Model {

    var $_financeiro_contaspagar_id = null;
    var $_valor = null;
    var $_credor = null;
    var $_parcela = null;
    var $_numero_parcela = null;
    var $_observacao = null;
    var $_tipo = null;
    var $_forma = null;
    var $_tipo_numero = null;
    var $_conta = null;
    var $_conta_id = null;

    function Contaspagar_model($financeiro_contaspagar_id = null) {
        parent::Model();
        if (isset($financeiro_contaspagar_id)) {
            $this->instanciar($financeiro_contaspagar_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('fc.financeiro_contaspagar_id,
                            fc.valor,
                            fc.credor,
                            fc.parcela,
                            fc.numero_parcela,
                            fc.observacao,
                            fe.descricao as conta,
                            fc.tipo,
                            fc.data,
                            cd.razao_social,
                            fc.tipo_numero');
        $this->db->from('tb_financeiro_contaspagar fc');
        $this->db->where('fc.ativo', 'true');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor cd', 'cd.financeiro_credor_devedor_id = fc.credor', 'left');
        if (isset($args['empresa']) && strlen($args['empresa']) > 0) {
            $this->db->where('fc.credor', $args['empresa']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('fc.tipo', $args['nome']);
        }
        if (isset($args['conta']) && strlen($args['conta']) > 0) {
            $this->db->where('fc.conta', $args['conta']);
        }
        if (isset($args['datainicio']) && strlen($args['datainicio']) > 0) {
            $this->db->where('fc.data >=', $args['datainicio']);
        }
        if (isset($args['datafim']) && strlen($args['datafim']) > 0) {
            $this->db->where('fc.data <=', $args['datafim']);
        }
        if (isset($args['obs']) && strlen($args['obs']) != '') {
            $this->db->where('fc.observacao ilike', "%" . $args['obs'] . "%");
        }
        return $this->db;
    }

    function relatoriocontaspagar() {
        $this->db->select('fc.financeiro_contaspagar_id,
                            fc.valor,
                            fc.credor,
                            fc.observacao,
                            fc.data,
                            fcd.razao_social,
                            fe.descricao as conta,
                            fc.tipo');
        $this->db->from('tb_financeiro_contaspagar fc');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = fc.credor', 'left');
        $this->db->where('fc.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('fc.conta', $_POST['conta']);
        }
        $this->db->where('fc.data >=', $_POST['txtdata_inicio']);
        $this->db->where('fc.data <=', $_POST['txtdata_fim']);
        $this->db->orderby('fc.data');
        $this->db->orderby('fcd.razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocontaspagarcontador() {
        $this->db->select('fc.financeiro_contaspagar_id');
        $this->db->from('tb_financeiro_contaspagar fc');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = fc.credor', 'left');
        $this->db->where('fc.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('fc.conta', $_POST['conta']);
        }
        $this->db->where('fc.data >=', $_POST['txtdata_inicio']);
        $this->db->where('fc.data <=', $_POST['txtdata_fim']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarautocompletecredro($parametro = null) {
        $this->db->select('financeiro_credor_devedor_id,
                           razao_social,
                           cnpj,
                           cpf');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('razao_social ilike', $parametro . "%");
        }
        $return = $this->db->get();

        return $return->result();
    }

    function listarcontaspagar() {
        $this->db->select('financeiro_contaspagar_id,
                            descricao');
        $this->db->from('tb_financeiro_contaspagarr');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($financeiro_contaspagar_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('excluido', 't');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('financeiro_contaspagar_id', $financeiro_contaspagar_id);
        $this->db->update('tb_financeiro_contaspagar');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarconfirmacao() {
        try {
            /* inicia o mapeamento no banco */
            $financeiro_contaspagar_id = $_POST['financeiro_contaspagar_id'];
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('contas_pagar_id', $financeiro_contaspagar_id);
            $this->db->set('data', $_POST['inicio']);
            $this->db->set('nome', $_POST['credor']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('conta', $_POST['conta_id']);
            $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saidas');
            $saida_id = $this->db->insert_id();
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $valor = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
            $this->db->set('valor', -$valor);
            $this->db->set('nome', $_POST['credor']);
            $this->db->set('saida_id', $saida_id);
            $this->db->set('conta', $_POST['conta_id']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $_POST['inicio']);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('saida_id', $saida_id);
            $this->db->set('ativo', 'f');
            $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('financeiro_contaspagar_id', $financeiro_contaspagar_id);
            $this->db->update('tb_financeiro_contaspagar');

            return $entradas_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar($dia, $parcela) {
        try {
            /* inicia o mapeamento no banco */
            $financeiro_contaspagar_id = $_POST['financeiro_contaspagar_id'];
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('credor', $_POST['credor']);
            $this->db->set('data', $dia);
            $this->db->set('parcela', $parcela);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('tipo_numero', $_POST['tiponumero']);
            $this->db->set('numero_parcela', $_POST['repitir']);
            $this->db->set('observacao', $_POST['Observacao']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['financeiro_contaspagar_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_financeiro_contaspagar');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $financeiro_contaspagar_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('financeiro_contaspagar_id', $financeiro_contaspagar_id);
                $this->db->update('tb_financeiro_contaspagar');
            }
            return $financeiro_contaspagar_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($financeiro_contaspagar_id) {

        if ($financeiro_contaspagar_id != 0) {
            $this->db->select('fc.financeiro_contaspagar_id,
                            fc.valor,
                            fc.credor,
                            fc.parcela,
                            fc.numero_parcela,
                            fc.observacao,
                            fc.tipo,
                            fc.data,
                            fe.descricao,
                            fe.forma_entradas_saida_id,
                            cd.razao_social,
                            fc.tipo_numero');
            $this->db->from('tb_financeiro_contaspagar fc');
            $this->db->where('fc.ativo', 'true');
            $this->db->join('tb_financeiro_credor_devedor cd', 'cd.financeiro_credor_devedor_id = fc.credor', 'left');
            $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
            $this->db->where("fc.financeiro_contaspagar_id", $financeiro_contaspagar_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_financeiro_contaspagar_id = $financeiro_contaspagar_id;
            $this->_valor = $return[0]->valor;
            $this->_credor = $return[0]->credor;
            $this->_parcela = $return[0]->parcela;
            $this->_numero_parcela = $return[0]->numero_parcela;
            $this->_observacao = $return[0]->observacao;
            $this->_tipo = $return[0]->tipo;
            $this->_data = $return[0]->data;
            $this->_razao_social = $return[0]->razao_social;
            $this->_tipo_numero = $return[0]->tipo_numero;
            $this->_conta = $return[0]->descricao;
            $this->_conta_id = $return[0]->forma_entradas_saida_id;
        } else {
            $this->_estoque_produto_id = null;
        }
    }

}

?>
