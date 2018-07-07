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
    var $_classe = null;

    function Contaspagar_model($financeiro_contaspagar_id = null) {
        parent::Model();
        if (isset($financeiro_contaspagar_id)) {
            $this->instanciar($financeiro_contaspagar_id);
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
        
        $this->db->select('fc.financeiro_contaspagar_id,
                            fc.valor,
                            fc.credor,
                            fc.parcela,
                            fc.numero_parcela,
                            fc.observacao,
                            fe.descricao as conta,
                            fc.tipo,
                            fc.classe,
                            fc.empresa_id,
                            fc.data,
                            cd.razao_social,
                            fc.tipo_numero');
        $this->db->from('tb_financeiro_contaspagar fc');
        $this->db->where('fc.ativo', 'true');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor cd', 'cd.financeiro_credor_devedor_id = fc.credor', 'left');
//        $this->db->join('tb_financeiro_classe f', 'f.descricao = fc.classe', 'left');
        if (isset($args['empresa']) && strlen($args['empresa']) > 0) {
            $this->db->where('fc.credor', $args['empresa']);
        }
        
        if (isset($args['txtempresa']) && strlen($args['txtempresa']) > 0) {
            if ($args['txtempresa'] != '0'){
                $this->db->where('fc.empresa_id', $args['txtempresa']);
            }
        }
        else {
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
            $this->db->where('fc.data >=', date("Y-m-d", strtotime(str_replace('/', '-', $args['datainicio'])) ) );
        }
        if (isset($args['datafim']) && strlen($args['datafim']) > 0) {
            $this->db->where('fc.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $args['datafim'])) ));
        }
        if (isset($args['obs']) && strlen($args['obs']) != '') {
            $this->db->where('fc.observacao ilike', "%" . $args['obs'] . "%");
        }
        return $this->db;
    }

    function relatoriocontaspagar() {
        if ($_POST['tipo'] > 0) {
            $this->db->select('
                            tes.descricao
                            ');
            $this->db->from('tb_tipo_entradas_saida tes');
            $this->db->where('tes.ativo', 'true');
            $this->db->where('tes.tipo_entradas_saida_id', $_POST['tipo']);
            $return = $this->db->get()->result();
        }

        $this->db->select('fc.financeiro_contaspagar_id,
                            fc.valor,
                            fc.credor,
                            fc.observacao,
                            fc.data,
                            fc.parcela,
                            e.nome as empresa,
                            fcd.razao_social,
                            fe.descricao as conta,
                            fc.tipo,
                            fc.classe');
        $this->db->from('tb_financeiro_contaspagar fc');
        $this->db->join('tb_forma_entradas_saida fe', 'fe.forma_entradas_saida_id = fc.conta', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = fc.credor', 'left');
//         $this->db->join('tb_financeiro_classe c', 'c.descricao = fc.classe', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = fc.empresa_id', 'left');
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
        $this->db->where('fc.data >=', date("Y-m-d", strtotime ( str_replace('/','-', $_POST['txtdata_inicio']) ) ));
        $this->db->where('fc.data <=', date("Y-m-d", strtotime ( str_replace('/','-', $_POST['txtdata_fim']) ) ));
        $this->db->orderby('fc.data');
        $this->db->orderby('fcd.razao_social');
        $return = $this->db->get();
        return $return->result();
    }
    
    
    function relatorioprevisaolaboratoriocontaspagar() {

        $this->db->select(" ae.percentual_laboratorio,
                            ae.valor_laboratorio,
                            ae.data,
                            ae.valor_total,
                            lab.nome as laboratorio,
                            ae.laboratorio_id,
                            ae.confirmacao_previsao_labotorio,
                            lab.conta_id,
                            lab.credor_devedor_id,
                            lab.tipo,
                            lab.classe");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->where('ae.procedimento_tuss_id is not null');
        $this->db->where('ae.laboratorio_id is not null');
        if ($_POST['empresa'] != "") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['conta'] != "0") {
            $this->db->where('lab.conta_id', $_POST['conta']);
        }
        if ($_POST['credordevedor'] != "0") {
            $this->db->where('lab.credor_devedor_id', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != "0") {
            $this->db->where('lab.tipo_id', $_POST['tipo']);
        }
        if ($_POST['classe'] != "") {
            $this->db->where('lab.classe', $_POST['classe']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('ae.data');
        $this->db->orderby('lab.nome');
        $return = $this->db->get();
        return $return->result();
    }
    
    function relatorioprevisaopromotorcontaspagar() {

        $this->db->select(' ae.valor_promotor,
                            ae.percentual_promotor, 
                            ae.valor_total,
                            ae.data,
                            pi.nome as promotor,
                            ae.indicacao,
                            ae.confirmacao_previsao_promotor,
                            pi.credor_devedor_id,
                            pi.conta_id,
                            pi.classe,
                            pi.tipo_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'ae.paciente_id = p.paciente_id');
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.procedimento_tuss_id is not null');
        $this->db->where('ae.indicacao is not null');
        if ($_POST['empresa'] != "") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['conta'] != "0") {
            $this->db->where('op.conta_id', $_POST['conta']);
        }
        if ($_POST['credordevedor'] != "0") {
            $this->db->where('op.credor_devedor_id', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != "0") {
            $this->db->where('op.tipo_id', $_POST['tipo']);
        }
        if ($_POST['classe'] != "") {
            $this->db->where('op.classe', $_POST['classe']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('ae.data');
        $this->db->orderby('pi.nome');
        $return = $this->db->get();
        return $return->result();
    }
    
    
    function listacadaindicacao($promotor_id) {

        $this->db->select('pi.nome as indicacao,
                           pi.tipo_id,
                           pi.classe,
                           pi.conta_id,
                           pi.credor_devedor_id');
        $this->db->from('tb_paciente_indicacao pi');
        $this->db->where("pi.paciente_indicacao_id", $promotor_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    function listaindicacao() {

        $this->db->select('paciente_indicacao_id, nome, registro');
        $this->db->from('tb_paciente_indicacao');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarlaboratoriorelatorio($laboratorio_id) {
        $this->db->select('laboratorio_id,
                            nome,
                            credor_devedor_id,
                            tipo,
                            classe,
                            dinheiro,
                            conta_id');
        $this->db->from('tb_laboratorio');
//        $this->db->where("ativo", 't');
        $this->db->where("laboratorio_id", $laboratorio_id);
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }
    
    function detalhesprevisaolaboratorio($dataSelecionada, $laboratorio_id, $empresa) {
        $this->db->select("ae.quantidade,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            pc.procedimento_convenio_id,
                            ae.autorizacao,
                            ae.percentual_laboratorio,
                            ae.valor_laboratorio,
                            ae.data,
                            ae.valor,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.valor_total,
                            pc.procedimento_tuss_id,
          
                            pt.grupo,
                            (
                                SELECT dia_recebimento 
                                FROM ponto.tb_procedimento_percentual_laboratorio_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_laboratorio ppm 
                                ON ppm.procedimento_percentual_laboratorio_id = ppmc.procedimento_percentual_laboratorio_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.laboratorio = ae.laboratorio_id
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as dia_recebimento,
                            (
                                SELECT tempo_recebimento 
                                FROM ponto.tb_procedimento_percentual_laboratorio_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_laboratorio ppm 
                                ON ppm.procedimento_percentual_laboratorio_id = ppmc.procedimento_percentual_laboratorio_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.laboratorio = ae.laboratorio_id
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as tempo_recebimento,
                            lab.nome as laboratorio,
                            c.nome as convenio,
                            c.iss,
                            ae.valor1,
                            ae.laboratorio_id,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.numero_sessao,
                            ae.forma_pagamento4,
                            ae.valor4");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('ae.paciente_id is not null');
        
        if ($empresa != "") {
            $this->db->where('ae.empresa_id', $empresa);
        }
        $this->db->where('ae.laboratorio_id', $laboratorio_id);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($dataSelecionada)));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($dataSelecionada)));
        $return = $this->db->get();
        return $return->result();
    }
    
    function detalhesprevisaopromotor($dataSelecionada, $promotor_id, $empresa) {
        $this->db->select(' p.nome as paciente, 
                            ae.paciente_id,
                            ae.valor_promotor,ae.percentual_promotor, ae.valor_total,
                            pt.nome as procedimento,
                            ae.data,
                            pt.grupo,
                            c.nome as convenio,
                            pi.nome as indicacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'ae.paciente_id = p.paciente_id');
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ae.indicacao", $promotor_id);
        if ($empresa != "") {
            $this->db->where('ae.empresa_id', $empresa);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($dataSelecionada)));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($dataSelecionada)));
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }
    
    function detalhesprevisaomedica($dataSelecionada, $medico_id, $empresa) {
        
        $this->db->select(" ae.quantidade,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.autorizacao,
                            ae.data,            
                            ae.valor_total,
                            pc.procedimento_tuss_id,
                            pc.procedimento_convenio_id,
                            al.medico_parecer1,
                            pt.perc_medico,
                            al.situacao as situacaolaudo,
                            pt.percentual,
                            op.nome as medico,
                            op.taxa_administracao,
                            c.nome as convenio");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->where('ae.procedimento_tuss_id is not null');
        
        if ($empresa != "") {
            $this->db->where('ae.empresa_id', $empresa);
        }
        
        $this->db->where('ae.medico_agenda', $medico_id);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($dataSelecionada)));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($dataSelecionada)));
        
        $this->db->orderby('pt.grupo');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }
    
    function relatorioprevisaomedicacontaspagar() {
        
        $this->db->select(" ae.valor_total,
                            pc.procedimento_tuss_id,
                            pc.procedimento_convenio_id,
                            pt.perc_medico,
                            pt.percentual,
                            ae.medico_agenda,
                            op.nome as medico,
                            op.taxa_administracao,
                            (
                                SELECT mc.valor FROM ponto.tb_procedimento_percentual_medico_convenio mc
                                INNER JOIN ponto.tb_procedimento_percentual_medico m 
                                ON m.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id
                                WHERE m.procedimento_tuss_id = pc.procedimento_convenio_id
                                AND m.ativo = 't'
                                AND mc.medico = ae.medico_agenda
                                AND mc.ativo = 't'
                                LIMIT 1
                            ) AS perc_medico_excecao,
                            (
                                SELECT mc.percentual FROM ponto.tb_procedimento_percentual_medico_convenio mc
                                INNER JOIN ponto.tb_procedimento_percentual_medico m 
                                ON m.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id
                                WHERE m.procedimento_tuss_id = pc.procedimento_convenio_id
                                AND m.ativo = 't'
                                AND mc.medico = ae.medico_agenda
                                AND mc.ativo = 't'
                                LIMIT 1
                            ) AS percentual_excecao,
                            ae.confirmacao_previsao_medico,
                            op.tipo_id,
                            op.conta_id,
                            op.credor_devedor_id,
                            op.classe,
                            ae.confirmacao_previsao_medico,
                            ae.data");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->where('ae.procedimento_tuss_id is not null');
//        $this->db->where('c.dinheiro', 't');
        if ($_POST['empresa'] != "") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['conta'] != "0") {
            $this->db->where('op.conta_id', $_POST['conta']);
        }
        if ($_POST['credordevedor'] != "0") {
            $this->db->where('op.credor_devedor_id', $_POST['credordevedor']);
        }
        if ($_POST['tipo'] != "0") {
            $this->db->where('op.tipo_id', $_POST['tipo']);
        }
        if ($_POST['classe'] != "") {
            $this->db->where('op.classe', $_POST['classe']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        
        $this->db->orderby('ae.data');
        $this->db->orderby('op.nome');
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
        $this->db->where('fc.data >=', date("Y-m-d", strtotime ( str_replace('/','-', $_POST['txtdata_inicio']) ) ));
        $this->db->where('fc.data <=', date("Y-m-d", strtotime ( str_replace('/','-', $_POST['txtdata_fim']) ) ));
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

    function confirmarprevisaopromotor() {
        try {
            
            $observacao = "Previsão Promotor " . $_GET['txtdata_inicio'] . " a " . $_GET['txtdata_fim'];
            $this->db->set('valor', $_GET['valor']);
            $this->db->set('credor', $_GET['credordevedor']);
            $this->db->set('data', date("Y-m-d", strtotime( str_replace('/','-', $_GET['data'] ) ) ) );
//            $this->db->set('parcela', 1);
            $this->db->set('tipo', $_GET['tipo']);
            $this->db->set('empresa_id', $_GET['empresa']);
            $this->db->set('classe', $_GET['classe']);
            $this->db->set('conta', $_GET['conta']);
            $this->db->set('observacao', $observacao);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_contaspagar');
            
            $sql = "UPDATE ponto.tb_agenda_exames SET confirmacao_previsao_promotor = 't' 
                    WHERE agenda_exames_id IN (
                        SELECT ae.agenda_exames_id FROM ponto.tb_agenda_exames ae 
                        WHERE ae.procedimento_tuss_id is not null
                        AND ae.data >= '" . date("Y-m-d", strtotime( str_replace('/','-', $_GET['txtdata_inicio']) ) ) . "'
                        AND ae.data <= '" . date("Y-m-d", strtotime( str_replace('/','-', $_GET['txtdata_fim']) ) ) . "'
                        AND ae.indicacao = " . $_GET['promotor_id'] . "
                        AND ae.empresa_id = " . $_GET['empresa'] . "
                    )";
                    
            
            $this->db->query($sql);
            
        } catch (Exception $exc) {
            return -1;
        }
    }

    function confirmarprevisaomedico() {
        try {
            
            $observacao = "Previsão Médica " . $_GET['txtdata_inicio'] . " a " . $_GET['txtdata_fim'];
            $this->db->set('valor', $_GET['valor']);
            $this->db->set('credor', $_GET['credordevedor']);
            $this->db->set('data', date("Y-m-d", strtotime( str_replace('/','-', $_GET['data'] ) ) ) );
//            $this->db->set('parcela', 1);
            $this->db->set('tipo', $_GET['tipo']);
            $this->db->set('empresa_id', $_GET['empresa']);
            $this->db->set('classe', $_GET['classe']);
            $this->db->set('conta', $_GET['conta']);
            $this->db->set('observacao', $observacao);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_contaspagar');
            
            $sql = "UPDATE ponto.tb_agenda_exames SET confirmacao_previsao_medico = 't' 
                    WHERE agenda_exames_id IN (
                        SELECT ae.agenda_exames_id FROM ponto.tb_agenda_exames ae 
                        WHERE ae.procedimento_tuss_id is not null
                        AND ae.data >= '" . date("Y-m-d", strtotime( str_replace('/','-', $_GET['txtdata_inicio']) ) ) . "'
                        AND ae.data <= '" . date("Y-m-d", strtotime( str_replace('/','-', $_GET['txtdata_fim']) ) ) . "'
                        AND ae.medico_agenda = " . $_GET['medico_id'] . "
                        AND ae.empresa_id = " . $_GET['empresa'] . "
                    )";
                    
            
            $this->db->query($sql);
            
        } catch (Exception $exc) {
            return -1;
        }
    }

    function confirmarprevisaolaboratorio() {
        try {
            
            $observacao = "Previsão laboratórial " . $_GET['txtdata_inicio'] . " a " . $_GET['txtdata_fim'] . " Laboratório: " . $_GET["laboratorio_nome"];
            $this->db->set('valor', $_GET['valor']);
            $this->db->set('credor', $_GET['credordevedor']);
            $this->db->set('data', date("Y-m-d", strtotime( str_replace('/','-', $_GET['data'] ) ) ) );
//            $this->db->set('parcela', 1);
            $this->db->set('tipo', $_GET['tipo']);
            $this->db->set('empresa_id', $_GET['empresa']);
            $this->db->set('classe', $_GET['classe']);
            $this->db->set('conta', $_GET['conta']);
            $this->db->set('observacao', $observacao);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_contaspagar');
            
            $sql = "UPDATE ponto.tb_agenda_exames SET confirmacao_previsao_labotorio = 't' 
                    WHERE agenda_exames_id IN (
                        SELECT ae.agenda_exames_id FROM ponto.tb_agenda_exames ae 
                        LEFT JOIN ponto.tb_laboratorio lab ON lab.laboratorio_id = ae.laboratorio_id
                        WHERE ae.empresa_id = " . $_GET['empresa'] . "
                        AND ae.data >= '" . date("Y-m-d", strtotime( str_replace('/','-', $_GET['txtdata_inicio']) ) ) . "'
                        AND ae.data <= '" . date("Y-m-d", strtotime( str_replace('/','-', $_GET['txtdata_fim']) ) ) . "'
                        AND lab.laboratorio_id = " . $_GET['laboratorio_id'] . "
                    )";
                    
            
            $this->db->query($sql);
            
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconfirmacao() {
        try {
           $_POST['inicio']= date("Y-m-d", strtotime ( str_replace('/','-', $_POST['inicio'])));
            /* inicia o mapeamento no banco */
            $financeiro_contaspagar_id = $_POST['financeiro_contaspagar_id'];
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('contas_pagar_id', $financeiro_contaspagar_id);
            $this->db->set('data', $_POST['inicio']); 
            $this->db->set('nome', $_POST['credor']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('classe', $_POST['classe']);
            $this->db->set('conta', $_POST['conta_id']);
            $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
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
            $this->db->set('empresa_id', $empresa_id);
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

    function gravarcredor() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            $this->db->set('razao_social', $_POST['credorlabel']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_credor_devedor');
            $credor = $this->db->insert_id();
            return $credor;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar($dia, $parcela, $credor) {
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
            if(count($result) > 0){
             $tipo = $result[0]->descricao;   
            }else {
                $tipo = '';
            }
           
            
//            var_dump($tipo); die;

            /* inicia o mapeamento no banco */
            $financeiro_contaspagar_id = $_POST['financeiro_contaspagar_id'];
            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('credor', $credor);
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
                            fc.tipo_numero,
                            fc.empresa_id,
                            fc.classe');
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
            $this->_classe = $return[0]->classe;
            $this->_empresa_id = $return[0]->empresa_id;
        } else {
            $this->_estoque_produto_id = null;
        }
    }

}

?>
