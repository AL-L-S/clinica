<?php

class caixa_model extends Model {

    var $_saida_id = null;
    var $_devedor = null;
    var $_razao_social = null;
    var $_data = null;
    var $_valor = null;
    var $_observacao = null;
    var $_tipo = null;
    var $_forma = null;

    function caixa_model($saida_id = null) {
        parent::Model();
        if (isset($saida_id)) {
            $this->instanciar($saida_id);
        }
    }

    function listarentrada($args = array()) {
        $this->db->select('valor,
                            entradas_id,
                            observacao,
                            fe.descricao as conta,
                            data,
                            fcd.razao_social,
                            tipo');
        $this->db->from('tb_entradas e');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = e.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = e.nome', 'left');
        $this->db->where('e.ativo', 'true');
        if (isset($args['empresa']) && strlen($args['empresa']) > 0) {
            $this->db->where('e.nome', $args['empresa']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('tipo', $args['nome']);
        }
        if (isset($args['conta']) && strlen($args['conta']) > 0) {
            $this->db->where('e.conta', $args['conta']);
        }
        if (isset($args['datainicio']) && strlen($args['datainicio']) > 0) {
            $this->db->where('e.data >=', $args['datainicio']);
        }
        if (isset($args['obs']) && strlen($args['obs']) != '') {
            $this->db->where('e.observacao ilike', "%" . $args['obs'] . "%");
        }
        if (isset($args['datafim']) && strlen($args['datafim']) > 0) {
            $this->db->where('e.data <=', $args['datafim']);
        }
        return $this->db;
    }

    function listarsaida($args = array()) {
        $this->db->select('s.valor,
                            s.saidas_id,
                            s.observacao,
                            s.data,
                            fcd.razao_social,
                            fe.descricao as conta,
                            s.tipo');
        $this->db->from('tb_saidas s');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if (isset($args['empresa']) && strlen($args['empresa']) > 0) {
            $this->db->where('s.nome', $args['empresa']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('tipo', $args['nome']);
        }
        if (isset($args['conta']) && strlen($args['conta']) > 0) {
            $this->db->where('s.conta', $args['conta']);
        }
        if (isset($args['datainicio']) && strlen($args['datainicio']) > 0) {
            $this->db->where('s.data >=', $args['datainicio']);
        }
        if (isset($args['datafim']) && strlen($args['datafim']) > 0) {
            $this->db->where('s.data <=', $args['datafim']);
        }
        if (isset($args['obs']) && strlen($args['obs']) != '') {
            $this->db->where('s.observacao ilike', "%" . $args['obs'] . "%");
        }
        return $this->db;
    }

    function listarsangria($args = array()) {
        $this->db->select('s.valor,
                            s.sangria_id,
                            s.observacao,
                            s.data,
                            s.ativo,
                            o.nome as operador,
                            op.nome as operador_caixa');
        $this->db->from('tb_sangria s');
        $this->db->join('tb_operador o', 'o.operador_id = s.operador_cadastro', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = s.operador_caixa', 'left');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('s.operador_cadastro', $args['nome']);
        }
        if (isset($args['datainicio']) && strlen($args['datainicio']) > 0) {
            $this->db->where('s.data >=', $args['datainicio']);
        }
        if (isset($args['datafim']) && strlen($args['datafim']) > 0) {
            $this->db->where('s.data <=', $args['datafim']);
        }
        if (isset($args['obs']) && strlen($args['obs']) != '') {
            $this->db->where('s.observacao ilike', "%" . $args['obs'] . "%");
        }
        return $this->db;
    }

    function listarsangriacaixa() {
        $this->db->select('s.valor,
                            s.sangria_id,
                            s.observacao,
                            s.data,
                            s.ativo,
                            o.nome as operador,
                            op.nome as operador_caixa');
        $this->db->from('tb_sangria s');
        $this->db->join('tb_operador o', 'o.operador_id = s.operador_cadastro', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = s.operador_caixa', 'left');
        $this->db->where('s.ativo', 't');
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaida() {
        $this->db->select('s.valor,
                            s.saidas_id,
                            s.observacao,
                            s.data,
                            fcd.razao_social,
                            fe.descricao as conta,
                            s.tipo');
        $this->db->from('tb_saidas s');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != '') {
            $this->db->where('s.tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $this->db->orderby('s.data');
        $this->db->orderby('fcd.razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupoprocedimentoacompanhamento() {

        $this->db->select('pt.nome,
            cg.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", $_POST['txtdata_inicio']);
        $this->db->where("ae.data <=", $_POST['txtdata_fim']);
        $this->db->groupby('pt.procedimento_tuss_id');
        $this->db->groupby('pt.nome');
        $this->db->groupby('cg.nome');
        $this->db->orderby('cg.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }
    
    function relatoriosaidaacompanhamentodecontas() {
        $this->db->select('sum(s.valor) as valor,
                            s.tipo');
        $this->db->from('tb_saidas s');
        $this->db->where('s.ativo', 'true');
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $this->db->groupby('s.tipo');
        $this->db->orderby('s.tipo');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaidagrupo() {
        $this->db->select('s.valor,
                            s.saidas_id,
                            s.observacao,
                            s.data,
                            fcd.razao_social,
                            fe.descricao as conta,
                            s.tipo');
        $this->db->from('tb_saidas s');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $this->db->orderby('s.tipo');
        $this->db->orderby('fcd.razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaidacontador() {
        $this->db->select('s.valor');
        $this->db->from('tb_saidas s');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarcancelarsangria($sangria_id) {
        $this->db->select('s.valor,
            s.sangria_id,
            s.operador_caixa,
            s.observacao,
            o.nome as operador');
        $this->db->from('tb_sangria s');
        $this->db->join('tb_operador o', 'o.operador_id = s.operador_caixa', 'left');
        $this->db->where('s.sangria_id', $sangria_id);
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioentradagrupo() {
        $this->db->select('s.valor,
                            s.entradas_id,
                            s.observacao,
                            s.data,
                            fcd.razao_social,
                            fe.descricao as conta,
                            s.tipo');
        $this->db->from('tb_entradas s');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $this->db->orderby('s.data');
        $this->db->orderby('s.conta');
        $this->db->orderby('fcd.razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioentredacontador() {
        $this->db->select('s.valor');
        $this->db->from('tb_entradas s');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatorioentrada() {
        $this->db->select('s.valor,
                            s.entradas_id,
                            s.observacao,
                            s.data,
                            fcd.razao_social,
                            fe.descricao as conta,
                            s.tipo');
        $this->db->from('tb_entradas s');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != '') {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $this->db->orderby('s.conta');
        $this->db->orderby('s.data');
        $this->db->orderby('fcd.razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioentradaacompanhamentodecontas() {
        $this->db->select('sum(s.valor) as valor,
                            s.tipo');
        $this->db->from('tb_entradas s');
        $this->db->where('s.ativo', 'true');
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $this->db->groupby('s.tipo');
        $this->db->orderby('s.tipo');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomovimento() {
        $this->db->select('s.valor,
                            s.data,
                            s.data_cadastro,
                            fcd.razao_social,
                            sa.tipo as tiposaida,
                            e.tipo as tipoentrada,
                            sa.observacao as observacaosaida,
                            e.observacao as observacaoentrada,
                            fe.descricao as contanome,
                            s.conta');
        $this->db->from('tb_saldo s');
        $this->db->join('tb_saidas sa', 'sa.saidas_id = s.saida_id', 'left');
        $this->db->join('tb_entradas e', 'e.entradas_id = s.entrada_id', 'left');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data >=', $_POST['txtdata_inicio'] . ' ' . '00:00:00');
        $this->db->where('s.data <=', $_POST['txtdata_fim'] . ' ' . '23:59:59');
        $this->db->orderby('s.data');
        $this->db->orderby('fcd.razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomovimentosaldoantigo() {
        $this->db->select('sum(s.valor) as total');
        $this->db->from('tb_saldo s');
        $this->db->join('tb_saidas sa', 'sa.saidas_id = s.saida_id', 'left');
        $this->db->join('tb_entradas e', 'e.entradas_id = s.entrada_id', 'left');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data <', $_POST['txtdata_inicio'] . ' ' . '00:00:00');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioentreda() {
        $this->db->select('s.valor');
        $this->db->from('tb_entradas s');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
        $this->db->where('s.ativo', 'true');
        if ($_POST['credordevedor'] != 0) {
            $this->db->where('fcd.financeiro_credor_devedor_id ', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != 0) {
            $this->db->where('tipo', $_POST['tipo']);
        }
        if ($_POST['conta'] != 0) {
            $this->db->where('s.conta', $_POST['conta']);
        }
        $this->db->where('s.data >=', $_POST['txtdata_inicio']);
        $this->db->where('s.data <=', $_POST['txtdata_fim']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarsomaconta($forma_entradas_saida_id) {
        $this->db->select('sum(valor) as total');
        $this->db->from('tb_saldo');
        $this->db->where('ativo', 'true');
        $this->db->where('conta', $forma_entradas_saida_id);
        $return = $this->db->get();
        return $return->result();
    }

    function statusparcelas() {
        $this->db->select('caixa_parcelas_id,
                            paga,
                            data,
                            caixa_id,
                            valor_parcela');
        $this->db->from('tb_caixa_parcelas');
        $this->db->where('paga', 'false');
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcredordevedor() {
        $this->db->select('financeiro_credor_devedor_id,
                            razao_social');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->where('ativo', 'true');
        $this->db->orderby('razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarcredordevedor($financeiro_credor_devedor_id) {
        $this->db->select('financeiro_credor_devedor_id,
                            razao_social');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->where('financeiro_credor_devedor_id', "$financeiro_credor_devedor_id");
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarentrada() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $inicio = $_POST['inicio'];
            $dia = substr($inicio, 0, 2);
            $mes = substr($inicio, 3, 2);
            $ano = substr($inicio, 6, 4);
            $datainicio = $ano . '-' . $mes . '-' . $dia;
            $this->db->set('data', $_POST['inicio']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('nome', $_POST['devedor']);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_entradas');
            $entradas_id = $this->db->insert_id();
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('entrada_id', $entradas_id);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('nome', $_POST['devedor']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $_POST['inicio']);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');




            return $entradas_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsaida() {
        try {

            if ($_POST['saida_id'] == "") {
                /* inicia o mapeamento no banco */
                $horario = date("Y-m-d H:i:s");
                $data = date("Y-m-d");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
                $inicio = $_POST['inicio'];
                $dia = substr($inicio, 0, 2);
                $mes = substr($inicio, 3, 2);
                $ano = substr($inicio, 6, 4);
                $datainicio = $ano . '-' . $mes . '-' . $dia;
                $this->db->set('data', $_POST['inicio']);
                $this->db->set('tipo', $_POST['tipo']);
                $this->db->set('conta', $_POST['conta']);
                $this->db->set('nome', $_POST['devedor']);
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
                $this->db->set('conta', $_POST['conta']);
                $this->db->set('nome', $_POST['devedor']);
                $this->db->set('saida_id', $saida_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('data', $_POST['inicio']);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_saldo');
            }else {
                /* inicia o mapeamento no banco */
                $horario = date("Y-m-d H:i:s");
                $data = date("Y-m-d");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
                $inicio = $_POST['inicio'];
                $dia = substr($inicio, 0, 2);
                $mes = substr($inicio, 3, 2);
                $ano = substr($inicio, 6, 4);
                $datainicio = $ano . '-' . $mes . '-' . $dia;
                $this->db->set('data', $_POST['inicio']);
                $this->db->set('tipo', $_POST['tipo']);
                $this->db->set('conta', $_POST['conta']);
                $this->db->set('nome', $_POST['devedor']);
                $this->db->set('observacao', $_POST['Observacao']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->where('saidas_id', $_POST['saida_id']);
                $this->db->update('tb_saidas');
                $saida_id = $this->db->insert_id();
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                
                    $valor = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
                $this->db->set('valor', -$valor);
                $this->db->set('conta', $_POST['conta']);
                $this->db->set('nome', $_POST['devedor']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('data', $_POST['inicio']);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->where('saida_id', $_POST['saida_id']);
                $this->db->update('tb_saldo');
            }


            return $saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravartransferencia() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $inicio = $_POST['inicio'];
            $dia = substr($inicio, 0, 2);
            $mes = substr($inicio, 3, 2);
            $ano = substr($inicio, 6, 4);
            $datainicio = $ano . '-' . $mes . '-' . $dia;
            $this->db->set('data', $datainicio);
            $this->db->set('tipo', 'TRANSFERENCIA');
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saidas');
            $saida_id = $this->db->insert_id();

            $valor = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
            $this->db->set('valor', -$valor);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('saida_id', $saida_id);
            $this->db->set('data', $datainicio);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $inicio = $_POST['inicio'];
            $dia = substr($inicio, 0, 2);
            $mes = substr($inicio, 3, 2);
            $ano = substr($inicio, 6, 4);
            $datainicio = $ano . '-' . $mes . '-' . $dia;
            $this->db->set('data', $datainicio);
            $this->db->set('tipo', 'TRANSFERENCIA');
            $this->db->set('conta', $_POST['contaentrada']);
            $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_entradas');
            $entrada_id = $this->db->insert_id();

            $valorentrada = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
            $this->db->set('valor', $valorentrada);
            $this->db->set('data', $datainicio);
            $this->db->set('conta', $_POST['contaentrada']);
            $this->db->set('entrada_id', $entrada_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');



            return $entradas_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsangria() {
        try {
            /* inicia o mapeamento no banco */


            $this->db->select(' o.operador_id,
                                o.perfil_id');
            $this->db->from('tb_operador o');
            $this->db->where('o.operador_id', $_POST['operador']);
            $this->db->where('o.senha', md5($_POST['senha']));
            $return = $this->db->get()->result();
            if (isset($return) && count($return) > 0) {
                $horario = date("Y-m-d H:i:s");
                $data = date("Y-m-d");
                $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
                $this->db->set('data', $data);
                $this->db->set('observacao', $_POST['Observacao']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $_POST['operador']);
                $this->db->set('operador_caixa', $_POST['caixa']);
                $this->db->insert('tb_sangria');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    return 1;
            }else {
                return 0;
            }
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarcancelarsangria() {
        try {
            /* inicia o mapeamento no banco */
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select(' o.operador_id,
                                o.perfil_id');
            $this->db->from('tb_operador o');
            $this->db->where('o.operador_id', $_POST['operador_id']);
            $this->db->where('o.senha', md5($_POST['senha']));
            $return = $this->db->get()->result();

            if (isset($return) && count($return) > 0) {
                $horario = date("Y-m-d H:i:s");
                $this->db->set('observacao', $_POST['Observacao']);
                $this->db->set('data_cancelamento', $horario);
                $this->db->set('ativo', 'f');
                $this->db->set('operador_cancelamento', $operador_id);
                $this->db->set('operador_caixa_cancelamento', $_POST['operador_id']);
                $this->db->where('sangria_id', $_POST['sangria_id']);
                $this->db->update('tb_sangria');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    return 1;
            }else {
                return 0;
            }
        } catch (Exception $exc) {
            return -1;
        }
    }

    function saldo() {

        $this->db->select('sum(valor)');
        $this->db->from('tb_saldo');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function empresa() {

        $this->db->select('financeiro_credor_devedor_id,
            razao_social');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->orderby('razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function excluirentrada($entrada) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('entrada_id', $entrada);
        $this->db->update('tb_saldo');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('entradas_id', $entrada);
        $this->db->update('tb_entradas');
    }

    function excluirsaida($saida) {


        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('saida_id', $saida);
        $this->db->update('tb_saldo');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('saidas_id', $saida);
        $this->db->update('tb_saidas');
    }

    function excluirsangria($saida) {


        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('saidas_id', $saida);
        $this->db->update('tb_sangria');
    }

    private function instanciar($saida_id) {

        if ($saida_id != 0) {
            $this->db->select('s.valor,
                            s.saidas_id,
                            s.observacao,
                            s.data,
                            s.valor,
                            s.tipo,
                            s.nome,
                            fcd.razao_social,
                            s.conta,
                            fe.descricao as contadescricao,
                            s.tipo');
            $this->db->from('tb_saidas s');
            $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = s.conta', 'left');
            $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = s.nome', 'left');
            $this->db->where("s.saidas_id", $saida_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_saida_id = $saida_id;
            $this->_valor = $return[0]->valor;
            $this->_devedor = $return[0]->nome;
            $this->_observacao = $return[0]->observacao;
            $this->_tipo = $return[0]->tipo;
            $this->_data = $return[0]->data;
            $this->_razao_social = $return[0]->razao_social;
            $this->_forma = $return[0]->conta;
        } else {
            $this->_estoque_produto_id = null;
        }
    }

}

?>
