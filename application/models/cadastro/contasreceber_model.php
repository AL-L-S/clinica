<?php

class contasreceber_model extends Model {

    var $_financeiro_contasreceber_id = null;
    var $_valor = null;
    var $_credor = null;
    var $_parcela = null;
    var $_numero_parcela = null;
    var $_observacao = null;
    var $_forma = null;
    var $_tipo = null;
    var $_tipo_numero = null;
    var $_conta = null;
    var $_conta_id = null;
    var $_classe = null;

    function Contasreceber_model($financeiro_contasreceber_id = null) {
        parent::Model();
        if (isset($financeiro_contasreceber_id)) {
            $this->instanciar($financeiro_contasreceber_id);
        }
    }

    function listar($args = array()) {
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->select('
                            tes.descricao
                            ');
            $this->db->from('tb_tipo_entradas_saida tes');
            $this->db->where('tes.ativo', 'true');
            $this->db->where('tes.tipo_entradas_saida_id', $args['nome']);
            $return = $this->db->get()->result();
        }
        
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select("fc.financeiro_contasreceber_id,
                            fc.valor,
                            fc.devedor,
                            fc.parcela,
                            fc.numero_parcela,
                            fc.observacao,
                            fe.descricao as conta,
                            fc.tipo,
                            fc.classe,
                            fc.data,
                            cd.razao_social,
                            fc.tipo_numero");
        $this->db->from('tb_financeiro_contasreceber fc');
        $this->db->where('fc.ativo', 'true');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor cd', 'cd.financeiro_credor_devedor_id = fc.devedor', 'left');
//        $this->db->join('tb_financeiro_classe f', 'f.descricao = fc.classe', 'left');
        if (isset($args['empresa']) && strlen($args['empresa']) > 0) {
            $this->db->where('fc.devedor', $args['empresa']);
        }
        
        if (isset($args['txtempresa']) && strlen($args['txtempresa']) > 0) {
            if ($args['txtempresa'] != '0'){
                $this->db->where('fc.empresa_id', $args['txtempresa']);
            }
        }
        else{
            $this->db->where("fc.empresa_id", $empresa_id);
        }
        
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('tipo', $return[0]->descricao);
        }
        if (isset($args['nome_classe']) && strlen($args['nome_classe']) > 0) {
            $this->db->where('fc.classe', $args['nome_classe']);
        }
        if (isset($args['conta']) && strlen($args['conta']) > 0) {
            $this->db->where('fc.conta', $args['conta']);
        }
        if (isset($args['datainicio']) && strlen($args['datainicio']) > 0) {
            $this->db->where('fc.data >=', date("Y-m-d", strtotime(str_replace('/', '-', $args['datainicio']))));
        }
        if (isset($args['datafim']) && strlen($args['datafim']) > 0) {
            $this->db->where('fc.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $args['datafim']))));
        }
        if (isset($args['obs']) && strlen($args['obs']) != '') {
            $this->db->where('fc.observacao ilike', "%" . $args['obs'] . "%");
        }
        return $this->db;
    }

    function confirmarprevisaorecebimentoconvenio() {
        try {
            
            $data = date("Y-m-d");
            $convenio_id = $_GET['convenio_id'];
            
            $this->db->select('ir, pis, cofins, csll, iss, valor_base, entrega, pagamento');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $convenio_id);
            $query = $this->db->get();

            $returno = $query->result();
            $pagamento = $returno[0]->pagamento;
            $pagamentodata = substr($data, 0, 7) . "-" . $returno[0]->entrega;
            $data30 = date('Y-m-d', strtotime("+$pagamento days", strtotime($pagamentodata)));
            
            $ir = $returno[0]->ir / 100;
            $pis = $returno[0]->pis / 100;
            $cofins = $returno[0]->cofins / 100;
            $csll = $returno[0]->csll / 100;
            $iss = $returno[0]->iss / 100;
            $valor_base = $returno[0]->valor_base;
            
            $dineiro = $_GET['valor'];
            $dineirodescontado = $dineiro;
            
            if ($dineiro >= $valor_base) {
                $dineirodescontado = $dineirodescontado - ($dineiro * $ir);
            }
            $dineirodescontado = $dineirodescontado - ($dineiro * $pis);
            $dineirodescontado = $dineirodescontado - ($dineiro * $cofins);
            $dineirodescontado = $dineirodescontado - ($dineiro * $csll);
            $dineirodescontado = $dineirodescontado - ($dineiro * $iss);
            
            if ($pagamento != "" || $pagamentodata != "") {
                $observacao = "Previsão Convênio " . $_GET['txtdata_inicio'] . " a " . $_GET['txtdata_fim'] . " Convênio: " . $_GET["convenio_nome"];            

                $this->db->set('valor', $dineirodescontado);
                $this->db->set('devedor', $_GET['credordevedor']);
                $this->db->set('data', $data30);
                $this->db->set('tipo', 'FATURADO CONVENIO');
                $this->db->set('empresa_id', $_GET['empresa']);
                $this->db->set('conta', $_GET['conta']);
                $this->db->set('observacao', $observacao);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_financeiro_contasreceber');
                
                $periodoAnterior = date("Y-m-d", strtotime("-1 month", strtotime($_GET['periodo_aquisicao'])));;
                
                $sql = "UPDATE ponto.tb_agenda_exames SET confirmacao_recebimento_convenio = 't' 
                        WHERE agenda_exames_id IN (
                            SELECT ae.agenda_exames_id FROM ponto.tb_agenda_exames ae 
                            LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
                            LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
                            LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
                            WHERE c.convenio_id = " . $_GET['convenio_id'] . "
                            AND ae.empresa_id = " . $_GET['empresa'] . "
                            AND pt.grupo != 'CIRURGICO'
                            AND ae.data > '" . $periodoAnterior . "'
                            AND ae.data <= '" . $_GET['periodo_aquisicao'] . "'
                        )";


                $this->db->query($sql);
                
            }
            
        } catch (Exception $exc) {
            return -1;
        }
    }

    function relatorioprevisaoconveniocontasreceber() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select(' pc.valortotal as valor_procedimento,
                            ae.valor_total,
                            ae.data,
                            c.nome as convenio,
                            credor_devedor_id,
                            c.dia_aquisicao,
                            c.convenio_id,
                            c.conta_id,
                            ae.confirmacao_recebimento_convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->where("c.dinheiro", 'f');
        $this->db->where("c.dia_aquisicao IS NOT NULL");
        $this->db->where('pt.grupo !=', 'CIRURGICO');
        $this->db->where('ae.cancelada', 'f');
        
        if ($_POST['empresa'] != "") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        
        $this->db->orderby('ae.data');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        
        return $return->result();
    }

    function listarconvenioprevistoscontasreceber() {
        $this->db->select('c.nome, c.convenio_id, c.dia_aquisicao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->where("c.dinheiro", 'f');
        $this->db->where("c.dia_aquisicao IS NOT NULL");
        $this->db->where('pt.grupo !=', 'CIRURGICO');
        $this->db->where('ae.cancelada', 'f');
        if ($_POST['empresa'] != "") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->groupby('c.nome, c.convenio_id, c.dia_aquisicao');
        $return = $this->db->get();
        
        return $return->result();
    }

    function relatoriocontasreceber() {
         if ($_POST['tipo'] > 0) {
            $this->db->select('
                            tes.descricao
                            ');
            $this->db->from('tb_tipo_entradas_saida tes');
            $this->db->where('tes.ativo', 'true');
            $this->db->where('tes.tipo_entradas_saida_id', $_POST['tipo']);
            $return = $this->db->get()->result();
        }
        $this->db->select('fc.financeiro_contasreceber_id,
                            fc.valor,
                            fc.devedor,
                            fc.observacao,
                            fc.data,
                            e.nome as empresa,
                            fcd.razao_social,
                            fe.descricao as conta,
                            fc.tipo,
                            fc.classe');
        $this->db->from('tb_financeiro_contasreceber fc');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = fc.devedor', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = fc.empresa_id', 'left');
//        $this->db->join('tb_financeiro_classe c', 'c.descricao = fc.classe', 'left');
        $this->db->where('fc.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['empresa'] != "") {
            $this->db->where('fc.empresa_id', $_POST['empresa']);
        }
        if ($_POST['tipo'] > 0) {
//            var_dump($args['nome']); die;
            $this->db->where('tipo', @$return[0]->descricao);
        }
        if ($_POST['classe'] != '') {
            $this->db->where('fc.classe', $_POST['classe']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('fc.conta', $_POST['conta']);
        }
        $this->db->where('fc.data >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('fc.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('fc.data');
        $this->db->orderby('fcd.razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocontasrecebercontador() {
        $this->db->select('fc.financeiro_contasreceber_id');
        $this->db->from('tb_financeiro_contasreceber fc');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = fc.devedor', 'left');
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
        $this->db->where('fc.data >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('fc.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarautocompletecredro($parametro = null) {
        $this->db->select('financeiro_credor_devedor_id,
                           razao_social,
                           cnpj,
                           cpf');
        $this->db->from('tb_financeiro_credor_devedor');
        if ($parametro != null) {
            $this->db->where('razao_social ilike', $parametro . "%");
        }
        $return = $this->db->get();

        return $return->result();
    }

    function listarcontasreceber() {
        $this->db->select('financeiro_contasreceber_id,
                            descricao');
        $this->db->from('tb_financeiro_contasreceberr');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($financeiro_contasreceber_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('excluido', 't');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('financeiro_contasreceber_id', $financeiro_contasreceber_id);
        $this->db->update('tb_financeiro_contasreceber');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarconfirmacao() {
        try {
//            die;
            $_POST['inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['inicio'])));
            /* inicia o mapeamento no banco */
            $financeiro_contasreceber_id = $_POST['financeiro_contasreceber_id'];
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('contas_receber_id', $financeiro_contasreceber_id);
            $this->db->set('data', $_POST['inicio']);
            if ($_POST['devedor'] != '') {
                $this->db->set('nome', $_POST['devedor']);
            }
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('classe', $_POST['classe']);
            $this->db->set('conta', $_POST['conta_id']);
            $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->insert('tb_entradas');
            $entrada_id = $this->db->insert_id();
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $valor = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
            
            if ($_POST['devedor'] != '') {
                $this->db->set('nome', $_POST['devedor']);
            }
            $this->db->set('valor', $valor);
            $this->db->set('entrada_id', $entrada_id);
            $this->db->set('conta', $_POST['conta_id']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $_POST['inicio']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('entrada_id', $entrada_id);
            $this->db->set('ativo', 'f');
            $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('financeiro_contasreceber_id', $financeiro_contasreceber_id);
            $this->db->update('tb_financeiro_contasreceber');



            return $entradas_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravardevedor() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            $this->db->set('razao_social', $_POST['devedorlabel']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_credor_devedor');
            $credor = $this->db->insert_id();
            return $credor;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar($dia, $parcela, $devedor_id) {
        try {
            if($_POST['empresa_id'] != ''){
                $empresa_id = $_POST['empresa_id'];
            }
            else{
                $empresa_id = $this->session->userdata('empresa_id');
            }
            //busca tipo
            $this->db->select('t.descricao');
            $this->db->from('tb_tipo_entradas_saida t');
            $this->db->join('tb_financeiro_classe c', 'c.tipo_id = t.tipo_entradas_saida_id', 'left');
            $this->db->where('c.ativo', 't');
            $this->db->where('c.descricao', $_POST['classe']);
            $return = $this->db->get();
            $result = $return->result();
            if (count($result) > 0) {
                $tipo = $result[0]->descricao;
            } else {
                $tipo = '';
            }
//            var_dump($devedor_id); die;
            /* inicia o mapeamento no banco */
            $financeiro_contasreceber_id = $_POST['financeiro_contasreceber_id'];
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('devedor', $devedor_id);
            $this->db->set('data', $dia);
            $this->db->set('parcela', $parcela);
            $this->db->set('tipo', $tipo);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('classe', $_POST['classe']);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('tipo_numero', $_POST['tiponumero']);
            $this->db->set('numero_parcela', $_POST['repitir']);
            $this->db->set('observacao', $_POST['Observacao']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['financeiro_contasreceber_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_financeiro_contasreceber');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $financeiro_contasreceber_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('financeiro_contasreceber_id', $financeiro_contasreceber_id);
                $this->db->update('tb_financeiro_contasreceber');
            }
            return $financeiro_contasreceber_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($financeiro_contasreceber_id) {

        if ($financeiro_contasreceber_id != 0) {
            $this->db->select('fc.financeiro_contasreceber_id,
                            fc.valor,
                            fc.devedor,
                            fc.parcela,
                            fc.numero_parcela,
                            fc.observacao,
                            fc.tipo,
                            fe.descricao,
                            fe.forma_entradas_saida_id,
                            fc.data,
                            cd.razao_social,
                            fc.tipo_numero,
                            fc.empresa_id,
                            fc.classe');
            $this->db->from('tb_financeiro_contasreceber fc');
            $this->db->where('fc.ativo', 'true');
            $this->db->join('tb_financeiro_credor_devedor cd', 'cd.financeiro_credor_devedor_id = fc.devedor', 'left');
            $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
            $this->db->where("fc.financeiro_contasreceber_id", $financeiro_contasreceber_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_financeiro_contasreceber_id = $financeiro_contasreceber_id;
            $this->_valor = $return[0]->valor;
            $this->_devedor = $return[0]->devedor;
            $this->_parcela = $return[0]->parcela;
            $this->_numero_parcela = $return[0]->numero_parcela;
            $this->_observacao = $return[0]->observacao;
            $this->_tipo = $return[0]->tipo;
            $this->_data = $return[0]->data;
            $this->_razao_social = $return[0]->razao_social;
            $this->_tipo_numero = $return[0]->tipo_numero;
            $this->_conta = $return[0]->descricao;
            $this->_conta_id = $return[0]->forma_entradas_saida_id;
            $this->_classe = $return[0]->classe;
            $this->_empresa_id = $return[0]->empresa_id;
        } else {
            $this->_estoque_produto_id = null;
        }
    }

}

?>
